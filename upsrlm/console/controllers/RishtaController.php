<?php

namespace console\controllers;

use Yii;
use yii\helpers\Json;
use yii\console\Controller;
use yii\base\Model;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\RsetisCenter;
use bc\modules\training\models\RsetisEcalendar;
use bc\modules\training\models\RsetisBatchTraining;
use bc\modules\training\models\RsetisCenterTraining;
use bc\modules\training\models\TrainingEntity;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\models\master\MasterDistrict;
use bc\models\BcCumulativeReportDistrict;
use bc\modules\training\models\RsetisBatchParticipantsSearch;
use bc\modules\training\models\RsetisCenterSearch;
use common\models\rishta\RishtaUserData;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiaryBasicEducationPayment;
use console\helpers\Utility;
use common\helpers\FileHelpers;
use common\models\master\MasterRole;
use common\models\User;
use common\models\UserSearch;
use common\models\base\GenralModel;

class RishtaController extends Controller {

    public $menu_major_version = 1;
    public $menu_minor_version = 1;

    public function actionUsermenu() {
        $total_user = \common\models\User::find()->where(['role' => 100, 'dummy_column' => [0, 1]])->count();
        $limit = 1000;
        $batch = ceil($total_user / $limit);
        for ($i = 0; $i < $batch; ++$i) {
            $limitStart = $i * $limit;
            $user_models = \common\models\User::find()->where(['role' => 100, 'dummy_column' => [0, 1]])->limit($limit)->offset($limitStart)->orderBy('id asc')->all();
            foreach ($user_models as $user) {
                $rista = new \sakhi\components\Rishta($user);
                $rishta_user_data_model = RishtaUserData::findOne(['user_id' => $user->id]);
                if ($rishta_user_data_model == null) {
                    $rishta_user_data_model = new RishtaUserData();
                }
                $model = \common\models\User::findOne($user->id);
                $model->user_app_data_update = 1;
                $model->menu_version_major = \common\models\base\GenralModel::MENU_MAJOR_VERSION;
                $model->menu_version_minor = $this->menu_minor_version;
                $model->menu_version = ($model->menu_version_major + ('.' . $model->menu_version_minor));
                $rishta_user_data_model->user_id = $user->id;
                $rishta_user_data_model->menu_json = json_encode($rista->rishta_menu());
                $model->last_menu_updatetime = date("Y-m-d h:i:s");
                if ($model->save() and $rishta_user_data_model->save()) {
                    
                }
            }
        }
    }

    public function actionBasicbc($round = 2) {
        $pms = DbtBeneficiaryBasicEducationPayment::find()->where(['round' => $round])->groupBy('gram_panchayat_code')->all();
        try {
            foreach ($pms as $model) {
                $bc_model = SrlmBcApplication::find()->where(['training_status' => 3])->andWhere(['gram_panchayat_code' => $model->gram_panchayat_code])->andWhere(['not', ['user_id' => null]])->limit(1)->one();
                if (isset($bc_model) and $bc_model->user_id) {
                    $user_model = \common\models\User::findOne($bc_model->user_id);
                    $rista = new \sakhi\components\Rishta($user_model);
                    $user_model->user_app_data_update = 1;
                    $user_model->menu_version_major = \common\models\base\GenralModel::MENU_MAJOR_VERSION;
                    $user_model->menu_version_minor = ($user_model->menu_version_minor + 1);
                    $user_model->menu_version = ($user_model->menu_version_major + ('.' . $user_model->menu_version_minor));
                    $user_model->splash_screen = $rista->splash_screen($user_model);
                    $user_model->last_menu_updatetime = date("Y-m-d h:i:s");
                    $user_model->save();
                    $rishta_user_data_model = \common\models\rishta\RishtaUserData::findOne(['user_id' => $bc_model->user_id]);
                    if ($rishta_user_data_model == null) {
                        $rishta_user_data_model = new \common\models\rishta\RishtaUserData();
                    }
                    $rishta_user_data_model->user_id = $user_model->id;
                    $rishta_user_data_model->menu_json = json_encode($rista->rishta_menu());
                    $rishta_user_data_model->splash_screen_value = $rista->splash_screen_value($bc_model);
                    $rishta_user_data_model->save();
                    echo 'user id : ' . $bc_model->user_id . PHP_EOL;
                    echo 'gram_panchayat_code : ' . $bc_model->gram_panchayat_code . PHP_EOL;
                }
            }
        } catch (\Exception $ex) {
            
        }
    }

    public function actionBasicbccsv() {
        $pms = DbtBeneficiaryBasicEducationPayment::find()->where(['round' => [1, 2]])->groupBy('gram_panchayat_code')->orderBy('district_name asc')->all();
        $file = "basic_education_bc.csv";
        $file_path = Yii::$app->params['datapath'] . 'tmp/' . 'callcenter/' . $file;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $output = fopen($file_path, 'w');
        fputcsv($output, array(
            'Sr No',
            'District',
            'Block',
            'GP',
            'GP Code',
            'BC Name',
            'BC Mobile No',
            'Transaction'
        ));
        $sr_no = 1;
        $row = [];
        foreach ($pms as $model) {
            $bc_model = SrlmBcApplication::find()->where(['training_status' => 3])->andWhere(['gram_panchayat_code' => $model->gram_panchayat_code])->andWhere(['not', ['user_id' => null]])->limit(1)->one();
            if (isset($bc_model) and $bc_model->user_id) {
                $row = [
                    $sr_no,
                    $bc_model->district_name,
                    $bc_model->block_name,
                    $bc_model->gram_panchayat_name,
                    $bc_model->gram_panchayat_code,
                    $bc_model->name,
                    $bc_model->mobile_no,
                    DbtBeneficiaryBasicEducationPayment::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code])->count()
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
        }
    }

    public function actionCopybcfile() {
        echo "Copy BC file start Time : " . date('Y-m-d H:i:s');
        $count_bc = SrlmBcApplication::find()->select(['id', 'user_id'])->where(['training_status' => 3, 'blocked' => 0])->andWhere(['migrate_rishta' => 0])->andWhere(['NOT', ['user_id' => null]])->limit(1)->count();
        $limit = 500;
        $batch = ceil($count_bc / $limit);
        for ($i = 0; $i < $batch; ++$i) {
            $limitStart = $i * $limit;
            $models = SrlmBcApplication::find()->select(['id', 'user_id'])->where(['training_status' => 3, 'blocked' => 0])->andWhere(['migrate_rishta' => 0])->andWhere(['NOT', ['user_id' => null]])->limit($limit)->offset($limitStart)->orderBy('id asc')->all();
            echo count($models);
            if (!empty($models)) {
                foreach ($models as $model) {
                    $bc_model = SrlmBcApplication::findOne($model->id);
                    if ($bc_model->user_id) {
                        if (isset($bc_model)) {
                            $profile_model = \common\models\CboMemberProfile::findOne(['user_id' => $bc_model->user_id]);
                            if ($profile_model == null) {
                                $profile_model = new \common\models\CboMemberProfile();
                            }
                            $profile_model->user_id = $bc_model->user_id;
                            $profile_model->folder_prefix = $bc_model->block_code;
                            $profile_model->first_name = $bc_model->first_name;
                            $profile_model->middle_name = $bc_model->middle_name;
                            $profile_model->sur_name = $bc_model->sur_name;
                            $profile_model->gender = $bc_model->gender;
                            $profile_model->age = $bc_model->age;
                            $profile_model->primary_phone_no = $bc_model->mobile_number;
                            $profile_model->marital_status = $bc_model->marital_status;
                            $profile_model->aadhaar_number = $bc_model->aadhar_number;
                            $profile_model->bc = 1;
                            $profile_model->shg = 1;
                            $profile_model->cast = $bc_model->cast;
                            $profile_model->division_code = $bc_model->division_code;
                            $profile_model->division_name = $bc_model->division_name;
                            $profile_model->district_code = $bc_model->district_code;
                            $profile_model->district_name = $bc_model->district_name;
                            $profile_model->block_code = $bc_model->block_code;
                            $profile_model->block_name = $bc_model->block_name;
                            $profile_model->gram_panchayat_code = $bc_model->gram_panchayat_code;
                            $profile_model->gram_panchayat_name = $bc_model->gram_panchayat_name;
                            $profile_model->village_code = $bc_model->village_code;
                            $profile_model->village_name = $bc_model->village_name;
                            $profile_model->hamlet = $bc_model->hamlet;
                            $profile_model->guardian_name = $bc_model->guardian_name;
                            $profile_model->otp_mobile_no = $bc_model->mobile_no;
                            $profile_model->iibf_membership_no = $bc_model->certificate_code;
                            $profile_model->srlm_bc_application_id = $bc_model->id;
                            $profile_model->srlm_bc_selection_user_id = $bc_model->srlm_bc_selection_user_id;
                            $profile_model->bank_account_no = $bc_model->bank_account_no_of_the_bc;
                            $profile_model->bank_id = $bc_model->bank_id;
                            $profile_model->name_of_bank = $bc_model->name_of_bank;
                            $profile_model->branch = $bc_model->branch;
                            $profile_model->branch_code_or_ifsc = $bc_model->branch_code_or_ifsc;
                            $profile_model->date_of_opening_the_bank_account = $bc_model->date_of_opening_the_bank_account;
                            $profile_model->profile_photo = $bc_model->profile_photo;
                            $profile_model->photo_aadhaar_front = $bc_model->aadhar_front_photo;
                            $profile_model->photo_aadhaar_back = $bc_model->aadhar_back_photo;
                            $profile_model->passbook_photo = $bc_model->passbook_photo;
                            $profile_model->pan_photo = $bc_model->pan_photo;
                            $profile_model->bc_handheld_machine_photo = $bc_model->bc_handheld_machine_photo;
                            $profile_model->pvr_upload_file_name = $bc_model->pvr_upload_file_name;
                            $profile_model->iibf_photo_file_name = $bc_model->iibf_photo_file_name;
                            $profile_model->passbook_photo_shg = $bc_model->passbook_photo_shg;
                            $profile_model->bank_account_no_of_the_shg = $bc_model->bank_account_no_of_the_shg;
                            $profile_model->bank_id_shg = $bc_model->bank_id_shg;
                            $profile_model->name_of_bank_shg = $bc_model->name_of_bank_shg;
                            $profile_model->branch_shg = $bc_model->branch_shg;
                            $profile_model->branch_code_or_ifsc_shg = $bc_model->branch_code_or_ifsc_shg;
                            $profile_model->master_partner_bank_id = $bc_model->master_partner_bank_id;
                            $bc_copy_file_count = 0;
                            $bc_file_path = Yii::$app->params['bcdatapath'] . 'bcselection/bcprofile/' . $bc_model->srlm_bc_selection_user_id;
                            $user_profile_path = Yii::$app->params['datapath'] . 'cbo/member/' . $profile_model->folder_prefix . '/' . $model->user_id;
                            $user_profile_bc_path = Yii::$app->params['datapath'] . 'cbo/member/' . $profile_model->folder_prefix . '/' . $model->user_id . '/bc';
                            if (!file_exists(Yii::$app->params['datapath'] . 'cbo/member')) {
                                mkdir(Yii::$app->params['datapath'] . 'cbo/member');
                                chmod(Yii::$app->params['datapath'] . 'cbo/member', 0777);
                            }
                            if (!file_exists(Yii::$app->params['datapath'] . 'cbo/member/' . $profile_model->folder_prefix)) {
                                mkdir(Yii::$app->params['datapath'] . 'cbo/member/' . $profile_model->folder_prefix);
                                chmod(Yii::$app->params['datapath'] . 'cbo/member/' . $profile_model->folder_prefix, 0777);
                            }


                            if (!file_exists($user_profile_path)) {
                                mkdir($user_profile_path);
                                chmod($user_profile_path, 0777);
                            }
                            if (!file_exists($user_profile_bc_path)) {
                                mkdir($user_profile_bc_path);
                                chmod($user_profile_bc_path, 0777);
                            }
                            if ($bc_model->profile_photo) {
                                if (file_exists($bc_file_path . '/' . $bc_model->profile_photo)) {
                                    if (copy($bc_file_path . '/' . $bc_model->profile_photo, $user_profile_path . '/' . $bc_model->profile_photo)) {
                                        chmod($user_profile_path . '/' . $bc_model->profile_photo, 0777);
                                        $bc_copy_file_count++;
                                    }
                                }
                            }
                            if ($bc_model->aadhar_front_photo) {
                                if (file_exists($bc_file_path . '/' . $bc_model->aadhar_front_photo)) {
                                    if (copy($bc_file_path . '/' . $bc_model->aadhar_front_photo, $user_profile_path . '/' . $bc_model->aadhar_front_photo)) {
                                        chmod($user_profile_path . '/' . $bc_model->aadhar_front_photo, 0777);
                                        $bc_copy_file_count++;
                                    }
                                }
                            }
                            if ($bc_model->aadhar_back_photo) {
                                if (file_exists($bc_file_path . '/' . $bc_model->aadhar_back_photo)) {
                                    if (copy($bc_file_path . '/' . $bc_model->aadhar_back_photo, $user_profile_path . '/' . $bc_model->aadhar_back_photo)) {
                                        chmod($user_profile_path . '/' . $bc_model->aadhar_back_photo, 0777);
                                        $bc_copy_file_count++;
                                    }
                                }
                            }
                            if ($bc_model->passbook_photo) {
                                if (file_exists($bc_file_path . '/' . $bc_model->passbook_photo)) {
                                    if (copy($bc_file_path . '/' . $bc_model->passbook_photo, $user_profile_path . '/' . $bc_model->passbook_photo)) {
                                        chmod($user_profile_path . '/' . $bc_model->passbook_photo, 0777);
                                        $bc_copy_file_count++;
                                    }
                                }
                            }


                            if ($bc_model->pan_photo) {
                                if (file_exists($bc_file_path . '/' . $bc_model->pan_photo)) {
                                    if (copy($bc_file_path . '/' . $bc_model->pan_photo, $user_profile_path . '/' . $bc_model->pan_photo)) {
                                        chmod($user_profile_path . '/' . $bc_model->pan_photo, 0777);
                                        $bc_copy_file_count++;
                                    }
                                }
                            }
                            if ($bc_model->pvr_upload_file_name) {
                                if (file_exists($bc_file_path . '/' . $bc_model->pvr_upload_file_name)) {
                                    if (copy($bc_file_path . '/' . $bc_model->pvr_upload_file_name, $user_profile_bc_path . '/' . $bc_model->pvr_upload_file_name)) {
                                        chmod($user_profile_bc_path . '/' . $bc_model->pvr_upload_file_name, 0777);
                                        $bc_copy_file_count++;
                                    }
                                }
                            }
                            if ($bc_model->iibf_photo_file_name) {
                                if (file_exists($bc_file_path . '/' . $bc_model->iibf_photo_file_name)) {
                                    if (copy($bc_file_path . '/' . $bc_model->iibf_photo_file_name, $user_profile_bc_path . '/' . $bc_model->iibf_photo_file_name)) {
                                        chmod($user_profile_bc_path . '/' . $bc_model->iibf_photo_file_name, 0777);
                                        $bc_copy_file_count++;
                                    }
                                }
                            }
                            if ($bc_model->bc_handheld_machine_photo) {
                                if (file_exists($bc_file_path . '/' . $bc_model->bc_handheld_machine_photo)) {
                                    if (copy($bc_file_path . '/' . $bc_model->bc_handheld_machine_photo, $user_profile_bc_path . '/' . $bc_model->bc_handheld_machine_photo)) {
                                        chmod($user_profile_bc_path . '/' . $bc_model->bc_handheld_machine_photo, 0777);
                                        $bc_copy_file_count++;
                                    }
                                }
                            }
                            if ($bc_model->passbook_photo_shg) {
                                if (file_exists($bc_file_path . '/shg/' . $bc_model->passbook_photo_shg)) {
                                    if (copy($bc_file_path . '/shg/' . $bc_model->passbook_photo_shg, $user_profile_bc_path . '/' . $bc_model->passbook_photo_shg)) {
                                        chmod($user_profile_bc_path . '/' . $bc_model->passbook_photo_shg, 0777);
                                        $bc_copy_file_count++;
                                    }
                                }
                            }
                            $profile_model->bc_copy_file_count = $bc_copy_file_count;
                            if ($profile_model->save()) {
                                $bc_model->migrate_rishta = 1;
                                $bc_model->save();
                            }
                        }
                    }
                }
            }
//            exit;
        }

        echo "Copy BC file Completed Time : " . date('Y-m-d H:i:s');
    }

    public function actionMainbcfile() {
        $count_bc = SrlmBcApplication::find()->select(['id', 'user_id'])->where(['training_status' => 3, 'blocked' => 0])->andWhere(['migrate_rishta' => 0])->andWhere(['NOT', ['user_id' => null]])->limit(1)->count();
        $limit = 500;
        $batch = ceil($count_bc / $limit);
        for ($i = 0; $i < $batch; ++$i) {
            $limitStart = $i * $limit;
            $models = SrlmBcApplication::find()->select(['id', 'user_id'])->where(['training_status' => 3, 'blocked' => 0])->andWhere(['migrate_rishta' => 0])->andWhere(['NOT', ['user_id' => null]])->limit($limit)->offset($limitStart)->orderBy('id asc')->all();
            echo count($models);
            if (!empty($models)) {
                foreach ($models as $model) {
                    $bc_model = SrlmBcApplication::findOne($model->id);
                    if ($bc_model->user_id) {
                        if (isset($bc_model)) {
                            $profile_model = \common\models\CboMemberProfile::findOne(['user_id' => $bc_model->user_id]);
                            if ($profile_model == null) {
                                $profile_model = new \common\models\CboMemberProfile();
                            }
                            $profile_model->user_id = $bc_model->user_id;
                            $profile_model->folder_prefix = $bc_model->block_code;
                            $profile_model->first_name = $bc_model->first_name;
                            $profile_model->middle_name = $bc_model->middle_name;
                            $profile_model->sur_name = $bc_model->sur_name;
                            $profile_model->gender = $bc_model->gender;
                            $profile_model->age = $bc_model->age;
                            $profile_model->primary_phone_no = $bc_model->mobile_number;
                            $profile_model->marital_status = $bc_model->marital_status;
                            $profile_model->aadhaar_number = $bc_model->aadhar_number;
                            $profile_model->bc = 1;
                            $profile_model->shg = 1;
                            $profile_model->cast = $bc_model->cast;
                            $profile_model->division_code = $bc_model->division_code;
                            $profile_model->division_name = $bc_model->division_name;
                            $profile_model->district_code = $bc_model->district_code;
                            $profile_model->district_name = $bc_model->district_name;
                            $profile_model->block_code = $bc_model->block_code;
                            $profile_model->block_name = $bc_model->block_name;
                            $profile_model->gram_panchayat_code = $bc_model->gram_panchayat_code;
                            $profile_model->gram_panchayat_name = $bc_model->gram_panchayat_name;
                            $profile_model->village_code = $bc_model->village_code;
                            $profile_model->village_name = $bc_model->village_name;
                            $profile_model->hamlet = $bc_model->hamlet;
                            $profile_model->guardian_name = $bc_model->guardian_name;
                            $profile_model->otp_mobile_no = $bc_model->mobile_no;
                            $profile_model->iibf_membership_no = $bc_model->certificate_code;
                            $profile_model->srlm_bc_application_id = $bc_model->id;
                            $profile_model->srlm_bc_selection_user_id = $bc_model->srlm_bc_selection_user_id;
                            $profile_model->bank_account_no = $bc_model->bank_account_no_of_the_bc;
                            $profile_model->bank_id = $bc_model->bank_id;
                            $profile_model->name_of_bank = $bc_model->name_of_bank;
                            $profile_model->branch = $bc_model->branch;
                            $profile_model->branch_code_or_ifsc = $bc_model->branch_code_or_ifsc;
                            $profile_model->date_of_opening_the_bank_account = $bc_model->date_of_opening_the_bank_account;
                            $profile_model->profile_photo = $bc_model->profile_photo;
                            $profile_model->photo_aadhaar_front = $bc_model->aadhar_front_photo;
                            $profile_model->photo_aadhaar_back = $bc_model->aadhar_back_photo;
                            $profile_model->passbook_photo = $bc_model->passbook_photo;
                            $profile_model->pan_photo = $bc_model->pan_photo;
                            $profile_model->bc_handheld_machine_photo = $bc_model->bc_handheld_machine_photo;
                            $profile_model->pvr_upload_file_name = $bc_model->pvr_upload_file_name;
                            $profile_model->iibf_photo_file_name = $bc_model->iibf_photo_file_name;
                            $profile_model->passbook_photo_shg = $bc_model->passbook_photo_shg;
                            $profile_model->bank_account_no_of_the_shg = $bc_model->bank_account_no_of_the_shg;
                            $profile_model->bank_id_shg = $bc_model->bank_id_shg;
                            $profile_model->name_of_bank_shg = $bc_model->name_of_bank_shg;
                            $profile_model->branch_shg = $bc_model->branch_shg;
                            $profile_model->branch_code_or_ifsc_shg = $bc_model->branch_code_or_ifsc_shg;
                            $profile_model->master_partner_bank_id = $bc_model->master_partner_bank_id;
                            $bc_copy_file_count = 0;
                            $bc_file_path = Yii::$app->params['bcdatapath'] . 'bcselection/bcprofile/' . $bc_model->srlm_bc_selection_user_id;
                            $user_profile_path = Yii::$app->params['datapath'] . 'cbo/member/' . $profile_model->folder_prefix . '/' . $model->user_id;
                            $user_profile_bc_path = Yii::$app->params['datapath'] . 'cbo/member/' . $profile_model->folder_prefix . '/' . $model->user_id . '/bc';

                            if ($bc_model->profile_photo) {
                                if (file_exists($bc_file_path . '/' . $bc_model->profile_photo)) {
                                    $file = new FileHelpers();
                                    $file->file_path = $user_profile_path;
                                    $file->file_name = $bc_model->profile_photo;
                                    $file->upload();
                                    $bc_copy_file_count++;
//                                    
                                }
                            }
                            if ($bc_model->aadhar_front_photo) {
                                if (file_exists($bc_file_path . '/' . $bc_model->aadhar_front_photo)) {
                                    $file = new FileHelpers();
                                    $file->file_path = $user_profile_path;
                                    $file->file_name = $bc_model->aadhar_front_photo;
                                    $file->upload();
                                    $bc_copy_file_count++;
                                }
                            }
                            if ($bc_model->aadhar_back_photo) {
                                if (file_exists($bc_file_path . '/' . $bc_model->aadhar_back_photo)) {
                                    $file = new FileHelpers();
                                    $file->file_path = $user_profile_path;
                                    $file->file_name = $bc_model->aadhar_back_photo;
                                    $file->upload();
                                    $bc_copy_file_count++;
                                }
                            }
                            if ($bc_model->passbook_photo) {
                                if (file_exists($bc_file_path . '/' . $bc_model->passbook_photo)) {
                                    $file = new FileHelpers();
                                    $file->file_path = $user_profile_path;
                                    $file->file_name = $bc_model->passbook_photo;
                                    $file->upload();
                                    $bc_copy_file_count++;
                                }
                            }


                            if ($bc_model->pan_photo) {
                                if (file_exists($bc_file_path . '/' . $bc_model->pan_photo)) {
                                    $file = new FileHelpers();
                                    $file->file_path = $user_profile_path;
                                    $file->file_name = $bc_model->pan_photo;
                                    $file->upload();
                                    $bc_copy_file_count++;
                                }
                            }
                            if ($bc_model->pvr_upload_file_name) {
                                if (file_exists($bc_file_path . '/' . $bc_model->pvr_upload_file_name)) {
                                    $file = new FileHelpers();
                                    $file->file_path = $user_profile_bc_path;
                                    $file->file_name = $bc_model->pvr_upload_file_name;
                                    $file->upload();
                                    $bc_copy_file_count++;
                                }
                            }
                            if ($bc_model->iibf_photo_file_name) {
                                if (file_exists($bc_file_path . '/' . $bc_model->iibf_photo_file_name)) {
                                    $file = new FileHelpers();
                                    $file->file_path = $user_profile_bc_path;
                                    $file->file_name = $bc_model->iibf_photo_file_name;
                                    $file->upload();
                                    $bc_copy_file_count++;
                                }
                            }
                            if ($bc_model->bc_handheld_machine_photo) {
                                if (file_exists($bc_file_path . '/' . $bc_model->bc_handheld_machine_photo)) {
                                    $file = new FileHelpers();
                                    $file->file_path = $user_profile_bc_path;
                                    $file->file_name = $bc_model->bc_handheld_machine_photo;
                                    $file->upload();
                                    $bc_copy_file_count++;
                                }
                            }
                            if ($bc_model->passbook_photo_shg) {
                                if (file_exists($bc_file_path . '/shg/' . $bc_model->passbook_photo_shg)) {
                                    $file = new FileHelpers();
                                    $file->file_path = $user_profile_bc_path;
                                    $file->file_name = $bc_model->passbook_photo_shg;
                                    $file->upload();
                                    $bc_copy_file_count++;
                                }
                            }
                            $profile_model->bc_copy_file_count = $bc_copy_file_count;
                            if ($profile_model->save()) {
                                $bc_model->migrate_rishta = 1;
                                $bc_model->save();
                            }
                        }
                    }
                }
            }
//            exit;
        }
    }

    public function actionBcfile($bc_id) {

        $models = SrlmBcApplication::find()->where(['training_status' => 3])->andWhere(['id' => $bc_id])->andWhere(['migrate_rishta' => 0])->all();
        if (!empty($models)) {
            foreach ($models as $model) {
                $bc_model = SrlmBcApplication::findOne($model->id);
                if ($bc_model->user_id) {
                    if (isset($bc_model)) {
                        $profile_model = \common\models\CboMemberProfile::findOne(['user_id' => $bc_model->user_id]);
                        if ($profile_model == null) {
                            $profile_model = new \common\models\CboMemberProfile();
                        }
                        $profile_model->user_id = $bc_model->user_id;
                        $profile_model->first_name = $bc_model->first_name;
                        $profile_model->middle_name = $bc_model->middle_name;
                        $profile_model->sur_name = $bc_model->sur_name;
                        $profile_model->gender = $bc_model->gender;
                        $profile_model->age = $bc_model->age;
                        $profile_model->primary_phone_no = $bc_model->mobile_number;
                        $profile_model->marital_status = $bc_model->marital_status;
                        $profile_model->aadhaar_number = $bc_model->aadhar_number;
                        $profile_model->bc = 1;
                        $profile_model->shg = 1;
                        $profile_model->cast = $bc_model->cast;
                        $profile_model->division_code = $bc_model->division_code;
                        $profile_model->division_name = $bc_model->division_name;
                        $profile_model->district_code = $bc_model->district_code;
                        $profile_model->district_name = $bc_model->district_name;
                        $profile_model->block_code = $bc_model->block_code;
                        $profile_model->block_name = $bc_model->block_name;
                        $profile_model->gram_panchayat_code = $bc_model->gram_panchayat_code;
                        $profile_model->gram_panchayat_name = $bc_model->gram_panchayat_name;
                        $profile_model->village_code = $bc_model->village_code;
                        $profile_model->village_name = $bc_model->village_name;
                        $profile_model->hamlet = $bc_model->hamlet;
                        $profile_model->guardian_name = $bc_model->guardian_name;
                        $profile_model->otp_mobile_no = $bc_model->mobile_no;
                        $profile_model->iibf_membership_no = $bc_model->certificate_code;
                        $profile_model->srlm_bc_application_id = $bc_model->id;
                        $profile_model->srlm_bc_selection_user_id = $bc_model->srlm_bc_selection_user_id;
                        $profile_model->bank_account_no = $bc_model->bank_account_no_of_the_bc;
                        $profile_model->bank_id = $bc_model->bank_id;
                        $profile_model->name_of_bank = $bc_model->name_of_bank;
                        $profile_model->branch = $bc_model->branch;
                        $profile_model->branch_code_or_ifsc = $bc_model->branch_code_or_ifsc;
                        $profile_model->date_of_opening_the_bank_account = $bc_model->date_of_opening_the_bank_account;
                        $profile_model->profile_photo = $bc_model->profile_photo;
                        $profile_model->photo_aadhaar_front = $bc_model->aadhar_front_photo;
                        $profile_model->photo_aadhaar_back = $bc_model->aadhar_back_photo;
                        $profile_model->passbook_photo = $bc_model->passbook_photo;
                        $profile_model->pan_photo = $bc_model->pan_photo;
                        $profile_model->bc_handheld_machine_photo = $bc_model->bc_handheld_machine_photo;
                        $profile_model->pvr_upload_file_name = $bc_model->pvr_upload_file_name;
                        $profile_model->iibf_photo_file_name = $bc_model->iibf_photo_file_name;
                        $profile_model->passbook_photo_shg = $bc_model->passbook_photo_shg;
                        $profile_model->bank_account_no_of_the_shg = $bc_model->bank_account_no_of_the_shg;
                        $profile_model->bank_id_shg = $bc_model->bank_id_shg;
                        $profile_model->name_of_bank_shg = $bc_model->name_of_bank_shg;
                        $profile_model->branch_shg = $bc_model->branch_shg;
                        $profile_model->branch_code_or_ifsc_shg = $bc_model->branch_code_or_ifsc_shg;
                        $profile_model->master_partner_bank_id = $bc_model->master_partner_bank_id;
                        $bc_copy_file_count = 0;
                        $bc_file_path = Yii::$app->params['bcdatapath'] . 'bcselection/bcprofile/' . $bc_model->srlm_bc_selection_user_id;
                        $user_profile_path = Yii::$app->params['datapath'] . 'cbo/user/' . $model->user_id;
                        $user_profile_bc_path = Yii::$app->params['datapath'] . 'cbo/user/' . $model->user_id . '/bc';
                        if (!file_exists($user_profile_path)) {

                            mkdir($user_profile_path);
                            chmod($user_profile_path, 0777);
                        }
                        if (!file_exists($user_profile_bc_path)) {

                            mkdir($user_profile_bc_path);
                            chmod($user_profile_bc_path, 0777);
                        }
                        if ($bc_model->profile_photo) {
                            if (file_exists($bc_file_path . '/' . $bc_model->profile_photo)) {
                                if (copy($bc_file_path . '/' . $bc_model->profile_photo, $user_profile_path . '/' . $bc_model->profile_photo)) {
                                    chmod($user_profile_path . '/' . $bc_model->profile_photo, 0777);
                                    $bc_copy_file_count++;
                                }
                            }
                        }
                        if ($bc_model->aadhar_front_photo) {
                            if (file_exists($bc_file_path . '/' . $bc_model->aadhar_front_photo)) {
                                if (copy($bc_file_path . '/' . $bc_model->aadhar_front_photo, $user_profile_path . '/' . $bc_model->aadhar_front_photo)) {
                                    chmod($user_profile_path . '/' . $bc_model->aadhar_front_photo, 0777);
                                    $bc_copy_file_count++;
                                }
                            }
                        }
                        if ($bc_model->aadhar_back_photo) {
                            if (file_exists($bc_file_path . '/' . $bc_model->aadhar_back_photo)) {
                                if (copy($bc_file_path . '/' . $bc_model->aadhar_back_photo, $user_profile_path . '/' . $bc_model->aadhar_back_photo)) {
                                    chmod($user_profile_path . '/' . $bc_model->aadhar_back_photo, 0777);
                                    $bc_copy_file_count++;
                                }
                            }
                        }
                        if ($bc_model->passbook_photo) {
                            if (file_exists($bc_file_path . '/' . $bc_model->passbook_photo)) {
                                if (copy($bc_file_path . '/' . $bc_model->passbook_photo, $user_profile_path . '/' . $bc_model->passbook_photo)) {
                                    chmod($user_profile_path . '/' . $bc_model->passbook_photo, 0777);
                                    $bc_copy_file_count++;
                                }
                            }
                        }


                        if ($bc_model->pan_photo) {
                            if (file_exists($bc_file_path . '/' . $bc_model->pan_photo)) {
                                if (copy($bc_file_path . '/' . $bc_model->pan_photo, $user_profile_path . '/' . $bc_model->pan_photo)) {
                                    chmod($user_profile_path . '/' . $bc_model->pan_photo, 0777);
                                    $bc_copy_file_count++;
                                }
                            }
                        }
                        if ($bc_model->pvr_upload_file_name) {
                            if (file_exists($bc_file_path . '/' . $bc_model->pvr_upload_file_name)) {
                                if (copy($bc_file_path . '/' . $bc_model->pvr_upload_file_name, $user_profile_bc_path . '/' . $bc_model->pvr_upload_file_name)) {
                                    chmod($user_profile_bc_path . '/' . $bc_model->pvr_upload_file_name, 0777);
                                    $bc_copy_file_count++;
                                }
                            }
                        }
                        if ($bc_model->iibf_photo_file_name) {
                            if (file_exists($bc_file_path . '/' . $bc_model->iibf_photo_file_name)) {
                                if (copy($bc_file_path . '/' . $bc_model->iibf_photo_file_name, $user_profile_bc_path . '/' . $bc_model->iibf_photo_file_name)) {
                                    chmod($user_profile_bc_path . '/' . $bc_model->iibf_photo_file_name, 0777);
                                    $bc_copy_file_count++;
                                }
                            }
                        }
                        if ($bc_model->bc_handheld_machine_photo) {
                            if (file_exists($bc_file_path . '/' . $bc_model->bc_handheld_machine_photo)) {
                                if (copy($bc_file_path . '/' . $bc_model->bc_handheld_machine_photo, $user_profile_bc_path . '/' . $bc_model->bc_handheld_machine_photo)) {
                                    chmod($user_profile_bc_path . '/' . $bc_model->bc_handheld_machine_photo, 0777);
                                    $bc_copy_file_count++;
                                }
                            }
                        }
                        if ($bc_model->passbook_photo_shg) {
                            if (file_exists($bc_file_path . '/shg/' . $bc_model->passbook_photo_shg)) {
                                if (copy($bc_file_path . '/shg/' . $bc_model->passbook_photo_shg, $user_profile_bc_path . '/' . $bc_model->passbook_photo_shg)) {
                                    chmod($user_profile_bc_path . '/' . $bc_model->passbook_photo_shg, 0777);
                                    $bc_copy_file_count++;
                                }
                            }
                        }
                        $profile_model->bc_copy_file_count = $bc_copy_file_count;
                        if ($profile_model->save()) {
                            $bc_model->migrate_rishta = 1;
                            $bc_model->save();
                        }
                    }
                }
            }
        }
        exit;
    }

    public function actionBcapplication() {
        echo "BC Rishta app used Cron Strat Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        $total_user = \common\models\User::find()->select(['user.id'])->joinWith(['cboprofile'])->where(['user.role' => 100, \common\models\CboMemberProfile::getTableSchema()->fullName . '.bc' => 1])->count();
        $limit = 1000;
        $batch = ceil($total_user / $limit);
        for ($i = 0; $i < $batch; ++$i) {
            $limitStart = $i * $limit;
            $user_models = \common\models\User::find()->select(['user.id'])->joinWith(['cboprofile'])->where(['user.role' => 100, \common\models\CboMemberProfile::getTableSchema()->fullName . '.bc' => 1])->limit($limit)->offset($limitStart)->orderBy('id asc')->all();
            foreach ($user_models as $user) {
                $last_access_date = \cbo\models\sakhi\RishtaWebLog::find()->select('datetime')
                                ->where(['user_id' => $user->id, 'type' => 4])
                                ->orderBy(['datetime' => SORT_DESC])->limit(1)->one();
                if ($last_access_date != null) {
                    $bc_model = SrlmBcApplication::findOne(['user_id' => $user->id]);
                    $access_page_count = \cbo\models\sakhi\RishtaWebLog::find()->select('id')
                                    ->where(['user_id' => $user->id, 'type' => 4])->count();
                    if ($bc_model != null) {
                        $bc_model->rishta_app_last_access_time = $last_access_date->datetime;
                        $bc_model->rishta_access_page_count = $access_page_count;
                        if (isset($bc_model->trans->no_of_transaction)) {
                            $bc_model->no_of_transaction = $bc_model->trans->no_of_transaction;
                        }
                        $bc_model->update();
                    }
                }
            }
        }
        echo "BC Rishta app used Cron End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
    }

    public function actionResetbcmenu() {
        $count_bc = SrlmBcApplication::find()->select(['id', 'user_id'])->where(['training_status' => 3, 'blocked' => 0])->andWhere(['migrate_rishta' => 0])->count();
        $limit = 1000;
        $batch = ceil($count_bc / $limit);
        for ($i = 0; $i < $batch; ++$i) {
            $limitStart = $i * $limit;
            $models = SrlmBcApplication::find()->where(['training_status' => 3])->andWhere(['migrate_rishta' => 0])->limit($limit)->offset($limitStart)->orderBy('id asc')->all();
            if (!empty($models)) {
                foreach ($models as $model) {
                    $bc_model = SrlmBcApplication::findOne($model->id);
                    if (isset($bc_model) and $bc_model->user_id) {
                        $user_model = \common\models\User::findOne($bc_model->user_id);
                        $rista = new \sakhi\components\Rishta($user_model);
                        $user_model->user_app_data_update = 1;
                        $user_model->menu_version_major = \common\models\base\GenralModel::MENU_MAJOR_VERSION;
                        $user_model->menu_version_minor = ($user_model->menu_version_minor + 1);
                        $user_model->menu_version = ($user_model->menu_version_major + ('.' . $user_model->menu_version_minor));
                        $user_model->splash_screen = $rista->splash_screen($user_model);
                        $user_model->last_menu_updatetime = date("Y-m-d h:i:s");
                        $user_model->save();
                        $rishta_user_data_model = \common\models\rishta\RishtaUserData::findOne(['user_id' => $bc_model->user_id]);
                        if ($rishta_user_data_model == null) {
                            $rishta_user_data_model = new \common\models\rishta\RishtaUserData();
                        }
                        $rishta_user_data_model->user_id = $user_model->id;
                        $rishta_user_data_model->menu_json = json_encode($rista->rishta_menu());
                        $rishta_user_data_model->splash_screen_value = $rista->splash_screen_value($bc_model);
                        $rishta_user_data_model->save();
                    }
                }
            }
        }
    }

    public function actionResetbctrackmenu() {
        $models = \bc\modules\transaction\models\summary\BcTrackingBcDateRange::find()->all();
        if (!empty($models)) {
            foreach ($models as $model) {
                if ($model->user_id) {
                    $user_model = \common\models\User::findOne($model->user_id);
                    if (isset($user_model)) {
                        $rista = new \sakhi\components\Rishta($user_model);
                        $user_model->user_app_data_update = 1;
                        $user_model->menu_version_major = \common\models\base\GenralModel::MENU_MAJOR_VERSION;
                        $user_model->menu_version_minor = ($user_model->menu_version_minor + 1);
                        $user_model->menu_version = ($user_model->menu_version_major + ('.' . $user_model->menu_version_minor));
                        $user_model->splash_screen = $rista->splash_screen($user_model);
                        $user_model->last_menu_updatetime = date("Y-m-d h:i:s");
                        $user_model->save();
                        $rishta_user_data_model = \common\models\rishta\RishtaUserData::findOne(['user_id' => $model->user_id]);
                        if ($rishta_user_data_model == null) {
                            $rishta_user_data_model = new \common\models\rishta\RishtaUserData();
                        }
                        $rishta_user_data_model->user_id = $user_model->id;
                        $rishta_user_data_model->menu_json = json_encode($rista->rishta_menu());
                        $rishta_user_data_model->splash_screen_value = $rista->splash_screen_value($user_model);
                        $rishta_user_data_model->save();
                    }
                }
            }
        }
    }

    public function actionSmenu($user_id) {
        $user_model = \common\models\User::findOne(['id' => $user_id, 'role' => 100]);
        if ($user_model != null) {
            $rista = new \sakhi\components\Rishta($user_model);
            $user_model->user_app_data_update = 1;
            $user_model->save();
            $rishta_user_data_model = \common\models\rishta\RishtaUserData::findOne(['user_id' => $user_model->id]);
            if ($rishta_user_data_model == null) {
                $rishta_user_data_model = new \common\models\rishta\RishtaUserData();
            }
            $rishta_user_data_model->user_id = $user_model->id;
            $rishta_user_data_model->menu_json = json_encode($rista->rishta_menu());
            $rishta_user_data_model->splash_screen_value = $rista->splash_screen_value($user_model);
            $rishta_user_data_model->save();
            echo 'user id : ' . $user_id;
        }
    }

    public function actionSasakhimenu() {
        $cbo_models = \common\models\CboMembers::find()->where(['suggest_wada_sakhi' => 1])->all();
//        echo count($cbo_models).PHP_EOL;
        foreach ($cbo_models as $cmodel) {
            $user_model = $cmodel->user;
            $wada = \common\models\wada\WadaApplication::find()->where(['cbo_shg_id' => $cmodel->cbo_id, 'user_id' => $cmodel->user_id])->one();
//            if ($wada == null) {
            if ($user_model != null) {
                $rista = new \sakhi\components\Rishta($user_model);
                $user_model->user_app_data_update = 1;
                $user_model->save();
                $rishta_user_data_model = \common\models\rishta\RishtaUserData::findOne(['user_id' => $user_model->id]);
                if ($rishta_user_data_model == null) {
                    $rishta_user_data_model = new \common\models\rishta\RishtaUserData();
                }
                $rishta_user_data_model->user_id = $user_model->id;
                $rishta_user_data_model->menu_json = json_encode($rista->rishta_menu());
                $rishta_user_data_model->splash_screen_value = $rista->splash_screen_value($user_model);
                $rishta_user_data_model->save();
                echo $user_model->id . PHP_EOL;
//                }
            }
        }
    }

    public function actionSomenu() {
        $cbo_models = \common\models\CboMembers::find()->where(['role' => [1, 2, 3]])->all();
//        echo count($cbo_models).PHP_EOL;
        foreach ($cbo_models as $cmodel) {
            $user_model = $cmodel->user;
            $wada = \common\models\wada\WadaApplication::find()->where(['cbo_shg_id' => $cmodel->cbo_id, 'user_id' => $cmodel->user_id])->one();
//            if ($wada == null) {
            if ($user_model != null) {
                $rista = new \sakhi\components\Rishta($user_model);
                $user_model->user_app_data_update = 1;
                $user_model->save();
                $rishta_user_data_model = \common\models\rishta\RishtaUserData::findOne(['user_id' => $user_model->id]);
                if ($rishta_user_data_model == null) {
                    $rishta_user_data_model = new \common\models\rishta\RishtaUserData();
                }
                $rishta_user_data_model->user_id = $user_model->id;
                $rishta_user_data_model->menu_json = json_encode($rista->rishta_menu());
                $rishta_user_data_model->splash_screen_value = $rista->splash_screen_value($user_model);
                $rishta_user_data_model->save();
                echo $user_model->id . PHP_EOL;
//                }
            }
        }
    }

    public function actionMenubymobileno($mobile_no) {
        $user_model = \common\models\User::findOne(['username' => $mobile_no, 'role' => 100]);
        if ($user_model != null) {
            $rista = new \sakhi\components\Rishta($user_model);
            $user_model->user_app_data_update = 1;
            $user_model->save();
            $rishta_user_data_model = \common\models\rishta\RishtaUserData::findOne(['user_id' => $user_model->id]);
            if ($rishta_user_data_model == null) {
                $rishta_user_data_model = new \common\models\rishta\RishtaUserData();
            }
            $rishta_user_data_model->user_id = $user_model->id;
            $rishta_user_data_model->menu_json = json_encode($rista->rishta_menu());
            $rishta_user_data_model->splash_screen_value = $rista->splash_screen_value($user_model);
            $rishta_user_data_model->save();
            //echo 'user id : ' . $user_id;
        }
    }

    public function actionBcmenudistrict($district_code) {
        $searchModel = new UserSearch();
        $searchModel->role = MasterRole::ROLE_CBO_USER;
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider = $searchModel->search($searchModel, null, false, GenralModel::select_user_columns());
        $dataProvider->query->joinWith(['cboprofile']);
        $dataProvider->query->andWhere(['cbo_member_profile.bc' => 1]);
        $dataProvider->query->andWhere(['cbo_member_profile.district_code' => $district_code]);
        $dataProvider->query->distinct('cbo_member_profile.district_code');
        if ($dataProvider->models) {
            foreach ($dataProvider->models as $model) {
                $user_model = \common\models\User::findOne(['id' => $model->id, 'role' => 100]);
                $wada = \common\models\wada\WadaApplication::find()->where(['user_id' => $model->id])->count();
                if ($user_model != null) {
                    $rista = new \sakhi\components\Rishta($user_model);
                    $user_model->user_app_data_update = 1;
                    $user_model->save();
                    $rishta_user_data_model = \common\models\rishta\RishtaUserData::findOne(['user_id' => $user_model->id]);
                    if ($rishta_user_data_model == null) {
                        $rishta_user_data_model = new \common\models\rishta\RishtaUserData();
                    }
                    $rishta_user_data_model->user_id = $user_model->id;
                    $rishta_user_data_model->menu_json = json_encode($rista->rishta_menu());
                    $rishta_user_data_model->splash_screen_value = $rista->splash_screen_value($user_model);
                    $rishta_user_data_model->save();
                    echo 'user id : ' . $model->id . PHP_EOL;
                }
            }
        }
    }

    public function actionBcmenudis() {
        $dis_model = \common\models\master\MasterDistrict::find()->all();
        foreach ($dis_model as $dis) {
            $searchModel = new UserSearch();
            $searchModel->role = MasterRole::ROLE_CBO_USER;
            $searchModel->status = User::STATUS_ACTIVE;
            $dataProvider = $searchModel->search($searchModel, null, false, GenralModel::select_user_columns());
            $dataProvider->query->joinWith(['cboprofile']);
            $dataProvider->query->andWhere(['cbo_member_profile.bc' => 1]);
            $dataProvider->query->andWhere(['cbo_member_profile.district_code' => $dis->district_code]);
            $dataProvider->query->distinct('cbo_member_profile.district_code');
            if ($dataProvider->models) {
                foreach ($dataProvider->models as $model) {
                    $user_model = \common\models\User::findOne(['id' => $model->id, 'role' => 100]);
                    if ($user_model != null) {
                        $rista = new \sakhi\components\Rishta($user_model);
                        $user_model->user_app_data_update = 1;
                        $user_model->save();
                        $rishta_user_data_model = \common\models\rishta\RishtaUserData::findOne(['user_id' => $user_model->id]);
                        if ($rishta_user_data_model == null) {
                            $rishta_user_data_model = new \common\models\rishta\RishtaUserData();
                        }
                        $rishta_user_data_model->user_id = $user_model->id;
                        $rishta_user_data_model->menu_json = json_encode($rista->rishta_menu());
                        $rishta_user_data_model->splash_screen_value = $rista->splash_screen_value($user_model);
                        $rishta_user_data_model->save();
                       // echo 'user id : ' . $model->id . PHP_EOL;
                    }
                }
            }
            echo $dis->district_code.PHP_EOL;
        }
    }

    public function actionWsmenu() {
        $models = \common\models\wada\WadaApplication::find()->where(['wada_status' => 1])->all();
        foreach ($models as $model) {
            $user_model = \common\models\User::findOne(['id' => $model->user_id, 'role' => 100]);
            if ($user_model != null) {
                $rista = new \sakhi\components\Rishta($user_model);
                $user_model->user_app_data_update = 1;
                $user_model->menu_version_minor = ($user_model->menu_version_minor + 1);
                $user_model->menu_version = ($user_model->menu_version_major + ('.' . $user_model->menu_version_minor));
                $user_model->last_menu_updatetime = date("Y-m-d h:i:s");
                $user_model->save();
                $rishta_user_data_model = \common\models\rishta\RishtaUserData::findOne(['user_id' => $user_model->id]);
                if ($rishta_user_data_model == null) {
                    $rishta_user_data_model = new \common\models\rishta\RishtaUserData();
                }
                $rishta_user_data_model->user_id = $user_model->id;
                $rishta_user_data_model->menu_json = json_encode($rista->rishta_menu());
                $rishta_user_data_model->splash_screen_value = $rista->splash_screen_value($user_model);
                $rishta_user_data_model->save();
                echo 'user id : ' . $model->user_id . PHP_EOL;
            }
        }
    }

    public function actionDeleteshg($gp_code) {
        $shg_model = \cbo\models\Shg::find()->where(['gram_panchayat_code' => $gp_code, 'status' => -1])->all();
        if ($shg_model != null) {
            foreach ($shg_model as $shg) {
                $member_models = \common\models\CboMembers::find()->where(['cbo_type' => 1, 'cbo_id' => $shg->id])->all();
                foreach ($member_models as $member) {
                    $model = \common\models\CboMembers::findOne($member->id);
                    $model->status = -1;
                    $model->save();
                }
            }
        }
    }

    public function actionAssign($gp_code) {
        $wada_application = \common\models\wada\WadaApplication::find()->joinWith(['user', 'profile'])->where(['wada_application.gram_panchayat_code' => $gp_code, 'wada_application.form_number' => 6, 'wada_application.status' => \common\models\wada\WadaApplication::STATUS_SUBMIT, 'cbo_member_profile.bc' => 0, 'user.dummy_column' => 0, 'wada_status' => 1, 'highest_score_in_gp' => 1])->one();
        if ($wada_application != null) {
            $wada_assign_shg = new \common\components\Gpshg();
            $wada_assign_shg->assignwada($wada_application, $wada_application->user);
        }
    }

    public function actionEmailchange() {
        $null = new \yii\db\Expression('NULL');
        $sql = 'select id,name,role,username,email from `user`

where user.username!=REGEXP_SUBSTR(email,"[0-9]+") and role=100';
        $connection = \Yii::$app->dbcbo;
        $insql = $connection->createCommand($sql);
        $result = $insql->queryAll();
//        print_r($result);        exit();
        foreach ($result as $user) {
            $new_email = $user['username'] . '@gmail.com';
            $bc = \common\models\User::find()->where(['email' => $new_email])->limit(1)->one();
            if ($bc == null) {
                $status = \common\models\User::STATUS_ACTIVE;
                $condition = ['and',
                    ['=', 'id', $user['id']],
                ];
                \common\models\User::updateAll([
                    'email' => $new_email,
                        ], $condition);
                \common\models\dynamicdb\bc\User::updateAll([
                    'email' => $new_email,
                        ], $condition);
                \common\models\dynamicdb\cbo_detail\User::updateAll([
                    'email' => $new_email,
                        ], $condition);
            }
        }
    }
}
