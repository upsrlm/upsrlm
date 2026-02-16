<?php

namespace hr\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\form\UserProfileForm;
use common\models\User;
use yii\web\UploadedFile;

class ProfileController extends Controller {

    public function beforeAction($action) {

        if (!parent::beforeAction($action)) {
            return false;
        }

        // other custom code here

        return true; // or false to not run the action
    }

    /**
     * Lists all Application models.
     *
     * @return mixed
     */
    public function actionUpdate($userid = null) {
        if ($userid == null) {
            if (isset(\Yii::$app->user->identity->id))
                $userid = \Yii::$app->user->identity->id;
            else {
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/page/home')->send();
                exit;
            }
        }
        $user_model = User::findOne($userid);
        if ($user_model == null) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/page/home')->send();
            exit;
        }
        if ($user_model->profile_status) {
//            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/dashboard')->send();
//            exit;
        }
        if ($user_model->role == \common\models\master\MasterRole::ROLE_BMMU) {
            $model = new UserProfileForm($userid);
        } else if ($user_model->role == \common\models\master\MasterRole::ROLE_DMMU) {
            $model = new \common\models\form\DMMU_ProfileForm($userid);
        } else if ($user_model->role == \common\models\master\MasterRole::ROLE_SMMU) {
            $model = new \common\models\form\SMMU_ProfileForm($userid);
        } elseif ($user_model->role == \common\models\master\MasterRole::ROLE_RSETIS_DISTRICT_UNIT) {
            $model = new \common\models\form\RSETHIs_ProfileForm($userid);
        } elseif ($user_model->role == \common\models\master\MasterRole::ROLE_DC_NRLM) {
            $model = new \common\models\form\DCNRLM_ProfileForm($userid);
        } elseif ($user_model->role == \common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT) {
            $model = new \common\models\form\Bank_ProfileForm($userid);
        } elseif ($user_model->role == \common\models\master\MasterRole::ROLE_RBI) {
            $model = new \common\models\form\Bank194ProfileForm($userid);
            $model->bank_name= \bc\modules\selection\models\base\GenralModel::rbi_user_bank($userid);
        } else {
            $model = new \common\models\form\CommonProfileForm($userid);
        }
//        if ($model->profle_model->is_profile_complete == "1") {
//            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['hr'] . '/profile/view?userid=' . $userid)->send();
//            exit;
//        }

        if ($model->load(Yii::$app->request->post()) and $model->validate()) {
            if ($user_model->role == \common\models\master\MasterRole::ROLE_RSETIS_DISTRICT_UNIT || $user_model->role == \common\models\master\MasterRole::ROLE_RSETIS_STATE_UNIT) {
                $model->profle_model->first_name = $model->first_name;
                $model->profle_model->middle_name = $model->middle_name;
                $model->profle_model->sur_name = $model->sur_name;
                $model->profle_model->primary_phone_no = $model->primary_phone_no;
                $model->profle_model->alternate_phone_no = $model->alternate_phone_no;
                $model->profle_model->whatsapp_no = $model->whatsapp_no;
                $model->profle_model->email_id = $model->email_id;
                $model->profle_model->designation = $model->designation;
                $model->profle_model->posting_district_code = $model->posting_district_code;
                $model->profle_model->office_address = $model->office_address;
                $model->profle_model->bank_name = $model->bank_name;
                $user_model->profile_status = 1;
                if ($model->profle_model->save() and $user_model->save()) {
                    return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/dashboard')->send();
                    exit;
                }
            } else if ($user_model->role == \common\models\master\MasterRole::ROLE_DC_NRLM) {
                $model->profle_model->first_name = $model->first_name;
                $model->profle_model->middle_name = $model->middle_name;
                $model->profle_model->sur_name = $model->sur_name;
                $model->profle_model->primary_phone_no = $model->primary_phone_no;
                $model->profle_model->alternate_phone_no = $model->alternate_phone_no;
                $model->profle_model->whatsapp_no = $model->whatsapp_no;
                $model->profle_model->email_id = $model->email_id;
                $model->profle_model->designation = $model->designation;
                $model->profle_model->posting_district_code = $model->posting_district_code;
                $model->profle_model->office_address = $model->office_address;
                $user_model->profile_status = 1;
                if ($model->profle_model->save() and $user_model->save()) {
                    return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/dashboard')->send();
                    exit;
                }
            }else if ($user_model->role == \common\models\master\MasterRole::ROLE_RBI) {
                $model->profle_model->first_name = $model->first_name;
                $model->profle_model->bank_name = $model->bank_name;
                $model->profle_model->primary_phone_no = $model->primary_phone_no;
                $model->profle_model->alternate_phone_no = $model->alternate_phone_no;
                $model->profle_model->whatsapp_no = $model->whatsapp_no;
                $model->profle_model->email_id = $model->email_id;
                $model->profle_model->designation = $model->designation;
                $model->profle_model->place_of_posting = $model->place_of_posting;
                $model->profle_model->employee_code_id = $model->employee_code_id;
                $model->profle_model->bank_name_of_reporting_officer = $model->bank_name_of_reporting_officer;
                $model->profle_model->bank_mobile_no_reporting_officer = $model->bank_mobile_no_reporting_officer;
                $model->profle_model->bank_whatsapp_no_reporting_officer = $model->bank_whatsapp_no_reporting_officer;
                $model->profle_model->bank_email_reporting_officer = $model->bank_email_reporting_officer;
                $model->profle_model->employee_code_id = $model->employee_code_id;
                $user_model->name = $model->first_name;
                $user_model->username = $model->primary_phone_no;
                $user_model->mobile_no = $model->primary_phone_no;
                $user_model->email = $model->email_id;
                $user_model->profile_status = 1;
                $user_model->action_type = 2;
                if ($model->profle_model->save() and $user_model->save()) {
                    return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/dashboard')->send();
                    exit;
                }
            } else if ($user_model->role == \common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT) {
                $model->profle_model->first_name = $model->first_name;
                $model->profle_model->middle_name = $model->middle_name;
                $model->profle_model->sur_name = $model->sur_name;
                $model->profle_model->primary_phone_no = $model->primary_phone_no;
                $model->profle_model->alternate_phone_no = $model->alternate_phone_no;
                $model->profle_model->whatsapp_no = $model->whatsapp_no;
                $model->profle_model->email_id = $model->email_id;
                $model->profle_model->name_of_organization = $model->name_of_organization;
                $model->profle_model->designation = $model->designation;
                $model->profle_model->inst_email = $model->inst_email;
                $model->profle_model->hq_email = $model->hq_email;
                $model->profle_model->office_phone_no = $model->office_phone_no;
                $model->profle_model->hq_phone_no = $model->hq_phone_no;
                $model->profle_model->hq_address = $model->hq_address;
                $model->profle_model->office_address = $model->office_address;

                $model->profle_model->signatory_first_name = $model->signatory_first_name;
                $model->profle_model->signatory_middle_name = $model->signatory_middle_name;
                $model->profle_model->signatory_sur_name = $model->signatory_sur_name;
                $model->profle_model->signatory_primary_phone_no = $model->signatory_primary_phone_no;
                $model->profle_model->signatory_alternate_phone_no = $model->signatory_alternate_phone_no;
                $model->profle_model->signatory_whatsapp_no = $model->signatory_whatsapp_no;
                $model->profle_model->signatory_designation = $model->signatory_designation;
                $model->profle_model->signatory_inst_email = $model->signatory_inst_email;
                $model->profle_model->signatory_hq_email = $model->signatory_hq_email;
                $model->profle_model->signatory_office_phone_no = $model->signatory_office_phone_no;
                $model->profle_model->signatory_hq_phone_no = $model->signatory_hq_phone_no;
                $model->profle_model->signatory_hq_address = $model->signatory_hq_address;
                $model->profle_model->signatory_office_address = $model->signatory_office_address;
                $user_model->profile_status = 1;
                if ($model->profle_model->save() and $user_model->save()) {
                    return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/dashboard')->send();
                    exit;
                }
            } else if ($user_model->role == \common\models\master\MasterRole::ROLE_BMMU) {
                $model->profle_model->first_name = $model->first_name;
                $model->profle_model->middle_name = $model->middle_name;
                $model->profle_model->sur_name = $model->sur_name;
                $model->profle_model->father_name = $model->father_name;
                $model->profle_model->gender = $model->gender;
                //$model->profle_model->date_of_birth = $model->date_of_birth;
                $model->profle_model->date_of_birth = \common\helpers\Utility::DateFormatForDb($model->date_of_birth);
                $model->profle_model->pan_number = $model->pan_number;
                $model->profle_model->aadhaar_number = $model->aadhaar_number;

                $model->profle_model->primary_phone_no = $model->primary_phone_no;
                $model->profle_model->alternate_phone_no = $model->alternate_phone_no;
                $model->profle_model->whatsapp_no = $model->whatsapp_no;
                $model->profle_model->email_id = $model->email_id;

                $model->profle_model->present_address_house_no = $model->present_address_house_no;
                $model->profle_model->present_address_street_mohalla = $model->present_address_street_mohalla;
                $model->profle_model->present_address_postoffice = $model->present_address_postoffice;
                $model->profle_model->present_address_district = $model->present_address_district;
                $model->profle_model->present_address_state = $model->present_address_state;

                $model->profle_model->permanent_address_house_no = $model->permanent_address_house_no;
                $model->profle_model->permanent_address_street_mohalla = $model->permanent_address_street_mohalla;
                $model->profle_model->permanent_address_postoffice = $model->permanent_address_postoffice;
                $model->profle_model->permanent_address_district = $model->permanent_address_district;
                $model->profle_model->permanent_address_state = $model->permanent_address_state;

                $model->profle_model->designation = $model->designation;
                $model->profle_model->date_of_joining = \common\helpers\Utility::DateFormatForDb($model->date_of_joining);
                $model->profle_model->date_of_last_posting = \common\helpers\Utility::DateFormatForDb($model->date_of_last_posting);
                $model->profle_model->posting_block_code = $model->posting_block_code;
                $model->profle_model->posting_district_code = $model->posting_district_code;
                $block = \common\models\master\MasterBlock::findOne(['block_code' => $model->posting_block_code]);
                $model->profle_model->posting_block_name = $block != null ? $block->block_name : "";
                $model->profle_model->posting_district_name = $block != null ? $block->district_name : "";

                $model->profle_model->bank_name = $model->bank_name;
                $model->profle_model->bank_branch = $model->bank_branch;
                $model->profle_model->bank_account_number = $model->bank_account_number;
                $model->profle_model->bank_ifsc_code = $model->bank_ifsc_code;
                if ($model->profle_model->verification_status == 2) {
                    $model->profle_model->verification_status = 0;
                }
                $array = [];
                if ($model->profle_model->posting_district_code != null) {
                    $searchModel = new \common\models\master\MasterBlockSearch();
                    $searchModel->district_code = $model->profle_model->posting_district_code;
                    $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
                    $models = $dataProvider->getModels();
                    if ($models != NULL) {
                        foreach ($models as $model1) {
                            $array[$model1->block_code] = $model1->block_name;
                        }
                    }
                    $model->block_option = $array;
                }
                if ($model->profle_model->validate()) {
                    $user_model->profile_status = 1;
                    $model->profle_model->save(false);
                    $user_model->save();
                    return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/dashboard')->send();
                    exit;
                } else {
                    //print_r($model->profle_model->errors);
                    //exit;
                }
            } else if ($user_model->role == \common\models\master\MasterRole::ROLE_DMMU) {
                $model->profle_model->first_name = $model->first_name;
                $model->profle_model->middle_name = $model->middle_name;
                $model->profle_model->sur_name = $model->sur_name;
                $model->profle_model->father_name = $model->father_name;
                $model->profle_model->gender = $model->gender;
                //$model->profle_model->date_of_birth = $model->date_of_birth;
                $model->profle_model->date_of_birth = \common\helpers\Utility::DateFormatForDb($model->date_of_birth);
                $model->profle_model->pan_number = $model->pan_number;
                $model->profle_model->aadhaar_number = $model->aadhaar_number;

                $model->profle_model->primary_phone_no = $model->primary_phone_no;
                $model->profle_model->alternate_phone_no = $model->alternate_phone_no;
                $model->profle_model->whatsapp_no = $model->whatsapp_no;
                $model->profle_model->email_id = $model->email_id;

                $model->profle_model->present_address_house_no = $model->present_address_house_no;
                $model->profle_model->present_address_street_mohalla = $model->present_address_street_mohalla;
                $model->profle_model->present_address_postoffice = $model->present_address_postoffice;
                $model->profle_model->present_address_district = $model->present_address_district;
                $model->profle_model->present_address_state = $model->present_address_state;

                $model->profle_model->permanent_address_house_no = $model->permanent_address_house_no;
                $model->profle_model->permanent_address_street_mohalla = $model->permanent_address_street_mohalla;
                $model->profle_model->permanent_address_postoffice = $model->permanent_address_postoffice;
                $model->profle_model->permanent_address_district = $model->permanent_address_district;
                $model->profle_model->permanent_address_state = $model->permanent_address_state;

                $model->profle_model->designation = $model->designation;
                $model->profle_model->date_of_joining = \common\helpers\Utility::DateFormatForDb($model->date_of_joining);
                $model->profle_model->date_of_last_posting = \common\helpers\Utility::DateFormatForDb($model->date_of_last_posting);
                //$model->profle_model->posting_block_code = $model->posting_block_code;
                $model->profle_model->posting_district_code = $model->posting_district_code;
                $district = \common\models\master\MasterDistrict::findOne(['district_code' => $model->posting_district_code]);
                //$model->profle_model->posting_block_name = $block != null ? $block->block_name : "";
                $model->profle_model->posting_district_name = $district != null ? $district->district_name : "";

                $model->profle_model->bank_name = $model->bank_name;
                $model->profle_model->bank_branch = $model->bank_branch;
                $model->profle_model->bank_account_number = $model->bank_account_number;
                $model->profle_model->bank_ifsc_code = $model->bank_ifsc_code;

                $model->profle_model->brief_professional_profile = $model->brief_professional_profile;
                $model->profle_model->academic_qualification_awards = $model->academic_qualification_awards;
                $model->profle_model->professional_training = $model->professional_training;
                $model->profle_model->experience = $model->experience;
                $model->profle_model->professional_association = $model->professional_association;
                if ($model->profle_model->verification_status == 2) {
                    $model->profle_model->verification_status = 0;
                }
                $array = [];
//                if ($model->profle_model->posting_district_code != null) {
//                    $searchModel = new \common\models\master\MasterBlockSearch();
//                    $searchModel->district_code = $model->profle_model->posting_district_code;
//                    $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
//                    $models = $dataProvider->getModels();
//                    if ($models != NULL) {
//                        foreach ($models as $model1) {
//                            $array[$model1->block_code] = $model1->block_name;
//                        }
//                    }
//                    $model->block_option = $array;
//                }
                if ($model->profle_model->validate()) {
                    $user_model->profile_status = 1;
                    $model->profle_model->save(false);
                    $user_model->save();
                    return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/dashboard')->send();
                    exit;
                } else {
                    
                }
            } else if ($user_model->role == \common\models\master\MasterRole::ROLE_SMMU) {
                $model->profle_model->first_name = $model->first_name;
                $model->profle_model->middle_name = $model->middle_name;
                $model->profle_model->sur_name = $model->sur_name;
                $model->profle_model->father_name = $model->father_name;
                $model->profle_model->gender = $model->gender;
                //$model->profle_model->date_of_birth = $model->date_of_birth;
                $model->profle_model->date_of_birth = \common\helpers\Utility::DateFormatForDb($model->date_of_birth);
                $model->profle_model->pan_number = $model->pan_number;
                $model->profle_model->aadhaar_number = $model->aadhaar_number;

                $model->profle_model->primary_phone_no = $model->primary_phone_no;
                $model->profle_model->alternate_phone_no = $model->alternate_phone_no;
                $model->profle_model->whatsapp_no = $model->whatsapp_no;
                $model->profle_model->email_id = $model->email_id;

                $model->profle_model->present_address_house_no = $model->present_address_house_no;
                $model->profle_model->present_address_street_mohalla = $model->present_address_street_mohalla;
                $model->profle_model->present_address_postoffice = $model->present_address_postoffice;
                $model->profle_model->present_address_district = $model->present_address_district;
                $model->profle_model->present_address_state = $model->present_address_state;

                $model->profle_model->permanent_address_house_no = $model->permanent_address_house_no;
                $model->profle_model->permanent_address_street_mohalla = $model->permanent_address_street_mohalla;
                $model->profle_model->permanent_address_postoffice = $model->permanent_address_postoffice;
                $model->profle_model->permanent_address_district = $model->permanent_address_district;
                $model->profle_model->permanent_address_state = $model->permanent_address_state;

                $model->profle_model->designation = $model->designation;
                $model->profle_model->date_of_joining = \common\helpers\Utility::DateFormatForDb($model->date_of_joining);
                $model->profle_model->date_of_last_posting = \common\helpers\Utility::DateFormatForDb($model->date_of_last_posting);
                // $model->profle_model->posting_block_code = $model->posting_block_code;
                $model->profle_model->posting_district_code = $model->posting_district_code;
                $district = \common\models\master\MasterDistrict::findOne(['district_code' => $model->posting_district_code]);
                //$model->profle_model->posting_block_name = $block != null ? $block->block_name : "";
                $model->profle_model->posting_district_name = $district != null ? $district->district_name : "";

                $model->profle_model->bank_name = $model->bank_name;
                $model->profle_model->bank_branch = $model->bank_branch;
                $model->profle_model->bank_account_number = $model->bank_account_number;
                $model->profle_model->bank_ifsc_code = $model->bank_ifsc_code;

                $model->profle_model->brief_professional_profile = $model->brief_professional_profile;
                $model->profle_model->academic_qualification_awards = $model->academic_qualification_awards;
                $model->profle_model->professional_training = $model->professional_training;
                $model->profle_model->experience = $model->experience;
                $model->profle_model->professional_association = $model->professional_association;
                if ($model->profle_model->verification_status == 2) {
                    $model->profle_model->verification_status = 0;
                }
                $array = [];
//                if ($model->profle_model->posting_district_code != null) {
//                    $searchModel = new \common\models\master\MasterBlockSearch();
//                    $searchModel->district_code = $model->profle_model->posting_district_code;
//                    $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
//                    $models = $dataProvider->getModels();
//                    if ($models != NULL) {
//                        foreach ($models as $model1) {
//                            $array[$model1->block_code] = $model1->block_name;
//                        }
//                    }
//                    $model->block_option = $array;
//                }
                if ($model->profle_model->validate()) {
                    $user_model->profile_status = 1;
                    $model->profle_model->save(false);
                    $user_model->save();
                    return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/dashboard')->send();
                    exit;
                } else {
                    //print_r($model->profle_model->errors);
                    //exit;
                }
            } else {
                $model->profle_model->first_name = $model->first_name;
                $model->profle_model->middle_name = $model->middle_name;
                $model->profle_model->sur_name = $model->sur_name;
                $model->profle_model->primary_phone_no = $model->primary_phone_no;
                $model->profle_model->alternate_phone_no = $model->alternate_phone_no;
                $model->profle_model->whatsapp_no = $model->whatsapp_no;
                $model->profle_model->email_id = $model->email_id;
                $model->profle_model->designation = $model->designation;
                $model->profle_model->office_address = $model->office_address;
                $user_model->profile_status = 1;
                if ($model->profle_model->save() and $user_model->save()) {
                    return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/dashboard')->send();
                    exit;
                }
            }
        }

        return $this->render('update', [
                    'model' => $model,
                    'user_model' => $user_model
        ]);
    }

    public function actionView($userid = null) {
        if ($userid == null) {
            if (isset(\Yii::$app->user->identity->id))
                $userid = \Yii::$app->user->identity->id;
            else {
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/page/home')->send();
                exit;
            }
        }
        $user_model = User::findOne($userid);
        if ($user_model == null) {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/page/home')->send();
            exit;
        }
        $model = new UserProfileForm($userid);
        $profile_complete = false;
        $profile_complete = $model->profle_model->chcekProfileStatus();
        // $model->setScenario(UserProfileForm::SCENARIOSAVE);

        if (Yii::$app->request->post()) {

            if ($profile_complete) {
                $model->profle_model->is_profile_complete = 1;
                if ($model->profle_model->validate()) {
                    $model->profle_model->save(false);
                } else {
                    //print_r($model->profle_model->errors);
                    //exit;
                }
            } else {
                Yii::$app->getSession()->setFlash('warning', "All fields are mandatory. Please complete the profile");
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['hr'] . '/profile/update?userid=' . $userid)->send();
                exit;
            }
        }

        return $this->render('view', [
                    'model' => $model,
                    'profile_complete' => $profile_complete,
                    'user_model' => $user_model
        ]);
    }

    public function actionUploadfile($userid = null, $file_type = null) {
        if ($userid == null) {
            if (isset(\Yii::$app->user->identity->id)) {
                $userid = \Yii::$app->user->identity->id;
                $model_profile = new UserProfileForm($userid);
            } else {
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/page/home')->send();
                exit;
            }
        } else {
            if (isset(\Yii::$app->user->identity->id)) {
                $userid = \Yii::$app->user->identity->id;
                $model_profile = new UserProfileForm($userid);
            } else {
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/page/home')->send();
                exit;
            }
        }
        $model = new \common\models\form\UserFileForm();
        $model->file_type = $file_type;
        $model->user_id = \Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post())) {
            $model->image_file = UploadedFile::getInstance($model, 'image_file');

            if ($model->image_file != null) {
                $tmp_image_file = $model->file_type . "_" . $model->image_file->name . date("Y_m_d_H-m-s") . "." . $model->image_file->extension;

                $FOLDER = Yii::$app->params['datapath'] . 'user_profile/';
                $FOLDER = $FOLDER . $model->user_id . '/';

                if (!file_exists($FOLDER)) {
                    mkdir($FOLDER);
                    chmod($FOLDER, 0777);
                }
            }
            if ($model->validate()) {
                $model->image_file->saveAs($FOLDER . '/' . $tmp_image_file);
                chmod($FOLDER . '/' . $tmp_image_file, 0777);
                if ($model->file_type == "1") {
                    $model_profile->profle_model->photo_profile = $tmp_image_file;
                } else if ($model->file_type == "2") {
                    $model_profile->profle_model->photo_pan = $tmp_image_file;
                } else if ($model->file_type == "3") {
                    $model_profile->profle_model->photo_aadhaar_front = $tmp_image_file;
                } else if ($model->file_type == "4") {
                    $model_profile->profle_model->photo_aadhaar_back = $tmp_image_file;
                } else if ($model->file_type == "5") {
                    $model_profile->profle_model->photo_bank_passbook = $tmp_image_file;
                } else if ($model->file_type == "6") {
                    $model_profile->profle_model->photo_letter_of_appointment = $tmp_image_file;
                } else if ($model->file_type == "7") {
                    $model_profile->profle_model->photo_service_agreement = $tmp_image_file;
                } else if ($model->file_type == "8") {
                    $model_profile->profle_model->photo_letter_of_last_posting_order = $tmp_image_file;
                }else if ($model->file_type == "9") {
                    $model_profile->profle_model->bank_photoid1 = $tmp_image_file;
                }else if ($model->file_type == "10") {
                    $model_profile->profle_model->bank_photoid2 = $tmp_image_file;
                }
                if ($model_profile->profle_model->verification_status == 2) {
                    $model_profile->profle_model->verification_status = 0;
                }
                $model_profile->profle_model->save(false);
                Yii::$app->getSession()->setFlash('success', "File Uploaded successfully.");
                return $this->renderPartial('file_upload', [
                            'model' => $model,
                            'model_profile' => $model_profile,
                            'status' => '1'
                ]);
            }
        }

        return $this->renderPartial('file_upload', [
                    'model' => $model,
                    'model_profile' => $model_profile,
                    'status' => '0'
        ]);
    }
}
