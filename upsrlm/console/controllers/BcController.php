<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\base\Model;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplication2;
use bc\modules\selection\models\SrlmBcApplication3;
use bc\modules\selection\models\SrlmBcApplication4;
use bc\modules\selection\models\SrlmBcApplication5;
use bc\modules\selection\models\SrlmBcApplication6;
use console\helpers\Utility;
use bc\modules\selection\models\BcMissing;
use bc\modules\selection\models\SrlmBcSelectionUser;
use yii\db\Query;
use cbo\models\Shg;
use common\models\User;
use common\models\wada\WadaApplicationSearch;
use common\models\wada\WadaApplication;
use common\models\UserSearch;
use common\models\master\MasterRole;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiCall;
use common\models\dynamicdb\internalcallcenter\platform\CallingList;
use common\models\dynamicdb\internalcallcenter\platform\CallingScenarioUserVerification;
use common\models\dynamicdb\internalcallcenter\platform\CallingScenarioUserNotUsedRishtaapp;
use common\models\dynamicdb\internalcallcenter\platform\CallingScenarioNotnominatedsamuhsakhi;
use common\models\dynamicdb\internalcallcenter\platform\CallingDailyProgress;
use common\models\dynamicdb\internalcallcenter\platform\BcCallingAgentProgress;
use common\models\dynamicdb\internalcallcenter\platform\BcCallingAgentProgressIbd;

class BcController extends Controller {
//    public function actionCheck() {
//        $bc_gp_applications = \bc\modules\selection\models\TempReverbc32::find()->where(['bc_exist' => 0])->all();
//        foreach ($bc_gp_applications as $bc) {
//            $bc_exist = SrlmBcApplication::find()->where(['gram_panchayat_code' => $bc->gram_panchayat_code, 'status' => 2, 'training_status' => [0, 1, 2, 3]])->andWhere(['!=', 'id', $bc->bcid])->count();
//            if ($bc_exist == 0) {
//                $bc->bc_exist = 2;
//                $bc->save();
//            } else {
//                $bc->bc_exist = 1;
//                $bc->save();
//            }
//        }
//    }
//    public function actionRevertunwilling() {
//        $bc_reverts = \bc\modules\selection\models\TempReverbc32::find()->where(['bc_exist' => 2])->all();
//        foreach ($bc_reverts as $reverts) {
//            $bc = SrlmBcApplication::findOne($reverts->bcid);
//            if ($bc != null) {
//                if ($reverts->training_status == 32) {
//                    $bc->training_status = 3;
//                }
//                $bc->bc_unwilling_bank_call_center = null;
//                $bc->bc_unwilling_bank_call_center_by = null;
//                $bc->bc_unwilling_bank_call_center_date = null;
//                $bc->bc_unwilling_bank = null;
//                $bc->bc_unwilling_bank_by = null;
//                $bc->bc_unwilling_bank_date = null;
//                $bc->action_type = SrlmBcApplication::ACTION_TYPE_BANK_UNWILLING_REVERT;
//                if ($bc->save()) {
//                    $reverts->bc_exist = 3;
//                    $reverts->save();
//                    $unwilling_modelb = \bc\modules\selection\models\BcUnwillingRsetis::findOne(['bc_application_id' => $bc->id, 'entry_type' => SrlmBcApplication::UNWILLING_TYPE_BANK]);
//                    $unwilling_modelc = \bc\modules\selection\models\BcUnwillingCallCenter::findOne(['bc_application_id' => $bc->id, 'entry_type' => SrlmBcApplication::UNWILLING_TYPE_BANK]);
//                    if ($unwilling_modelc != null) {
//                        $unwilling_modelc->delete();
//                    }
//                    if ($unwilling_modelb != null) {
//                        $unwilling_modelb->delete();
//                    }
//                    echo $bc->id.PHP_EOL;
//                }
//            }
//        }
//    }
//    public function actionA194nptm($user_id = '20308', $date = "2023-10-18 10:30:00") {
//        $bc_gp_applications = SrlmBcApplication::find()->where(['bc_settlement_ac_194n' => 1])->all();
//        foreach ($bc_gp_applications as $bc) {
//            if ($bc->bc_settlement_ac_194n_date == null) {
//                $bc->bc_settlement_ac_194n_date = $date;
//                $bc->bc_settlement_ac_194n_by = $user_id;
//                $bc->action_type = SrlmBcApplication::ACTION_TYPE_194N_AC;
//                $bc->save();
//            }
//        }
//    }
//
//    public function actionA194nbob($user_id = '20302', $bank_name = "Bank Of Baroda") {
//        $sql = "SELECT * FROM bc_sakhi_bob";
//        $connection = \Yii::$app->dbbc;
//        $insql = $connection->createCommand($sql);
//        $result = $insql->queryAll();
//        foreach ($result as $bcdata) {
//            $bc = SrlmBcApplication::find()->where(['bankidbc' => $bcdata['bc_sakhi_koid']])->limit(1)->one();
//            if ($bc != null) {
//                if ($bc->bc_settlement_ac_194n_date == null) {
//                    $bc->bc_settlement_account_bank_name = $bank_name;
//                    $bc->bc_settlement_account_no = $bcdata['bc_settlement_account_no'];
//                    $bc->bc_settlement_ac_194n = 1;
//                    $bc->bc_settlement_ac_194n_date = new \yii\db\Expression('NOW()');
//                    $bc->bc_settlement_ac_194n_by = $user_id;
//                    $bc->action_type = SrlmBcApplication::ACTION_TYPE_194N_AC;
//                    $bc->save();
//                }
//            }
//        }
//    }
//
//    public function actionRevertonboard() {
//        $bcs = SrlmBcApplication::find()->where(['status' => 2, 'master_partner_bank_id' => 7, 'onboarding' => 1])->all();
//        foreach ($bcs as $bc) {
//            if ($bc->onboarding == 1) {
//                $bc->onboarding = 0;
//                $bc->bankidbc = null;
//                $bc->bc_email_id = null;
//                $bc->onboarding_by = null;
//                $bc->onboarding_date_time = null;
//                $bc->action_type = SrlmBcApplication::ACTION_TYPE_BC_ONBOARDING_REVERT;
//                $bc->save();
//                echo $bc->id . PHP_EOL;
//            }
//        }
//    }
//
//    public function actionReverthhmack() {
//        $bcs = SrlmBcApplication::find()->where(['status' => 2, 'master_partner_bank_id' => 7, 'bc_handheld_machine_recived' => 1])->all();
//        foreach ($bcs as $bc) {
//            if ($bc->bc_handheld_machine_recived == 1) {
//                $bc->bc_handheld_machine_recived = null;
//                $bc->bc_handheld_machine_photo = null;
//                $bc->bc_handheld_machine_recived_submitdate = null;
//                $bc->action_type = SrlmBcApplication::ACTION_TYPE_BC_ACK_HANDHELD_MACHIN_REVERT;
//                $bc->save();
//                echo $bc->id . PHP_EOL;
//            }
//        }
//    }
//
//    public function actionChangebanksome($bank_id = 7) {
//        $sql = 'SELECT srlm_bc_application.id,srlm_bc_application.status,srlm_bc_application.onboarding,
//srlm_bc_application.selection_by,srlm_bc_application.bankidbc,
//srlm_bc_application.handheld_machine_status,srlm_bc_application.bc_handheld_machine_recived,
//srlm_bc_application.training_status,srlm_bc_application.blocked,master_gram_panchayat.sbi_status,master_gram_panchayat.change_status,master_gram_panchayat.master_partner_bank_id FROM `master_gram_panchayat` 
//JOIN srlm_bc_application on srlm_bc_application.gram_panchayat_code=master_gram_panchayat.gram_panchayat_code
//
//where master_gram_panchayat.status=1 and master_gram_panchayat.district_code IN (131,137,148,160,164,178,182)  and master_gram_panchayat.master_partner_bank_id=7 and srlm_bc_application.status=2 and srlm_bc_application.training_status in (0,1,2,3) and srlm_bc_application.master_partner_bank_id!=master_gram_panchayat.master_partner_bank_id and master_gram_panchayat.sbi_status=1  
//ORDER BY `srlm_bc_application`.`selection_by` ASC';
//        $bc_gp_applications = \bc\models\master\MasterGramPanchayat::findBySql($sql)->all();
//        echo "Total BC " . count($bc_gp_applications) . PHP_EOL;
//        $as_no = 0;
//        $chang_bank_id = 0;
//        $error_as_no = 0;
//        $error_chang_bank_id = 0;
//        foreach ($bc_gp_applications as $bcs) {
//            $bc = SrlmBcApplication::findOne($bcs->id);
//            if ($bcs->sbi_status == 1) {
//                if (!$bc->bankidbc and $bc->onboarding==0 and $bcs->master_partner_bank_id == 7 and $bc->master_partner_bank_id != 7 and $bc->status == 2 and in_array($bc->training_status, [0, 1, 2, 3])) {
//                    $bc->gp->change_status = 3;
//                    $bc->master_partner_bank_id = $bc->gp->master_partner_bank_id;
//                    $bc->changebankid_datetime = new \yii\db\Expression('NOW()');
//                    $bc->action_type = SrlmBcApplication::ACTION_TYPE_BC_CHANGE_BANK;
//                    if ($bc->save() and $bc->gp->save()) {
//                        if ($bc->bc_handheld_machine_recived == 1) {
//                            $bc->bc_handheld_machine_recived = null;
//                            $bc->bc_handheld_machine_photo = null;
//                            $bc->bc_handheld_machine_recived_submitdate = null;
//                            $bc->action_type = SrlmBcApplication::ACTION_TYPE_BC_ACK_HANDHELD_MACHIN_REVERT;
//                            $bc->save();
//                            echo $bc->id . PHP_EOL;
//                        }
//                        if ($bc->handheld_machine_status == 1) {
//                            $bc->handheld_machine_status = null;
//                            $bc->handheld_machine_by = null;
//                            $bc->handheld_machine_date = null;
//                            $bc->action_type = SrlmBcApplication::ACTION_TYPE_HANDHELD_MACHIN_PROVIDED_REVERT;
//                            $bc->save();
//                            echo $bc->id . PHP_EOL;
//                        }
//                        $as_no++;
//                        echo "Assign Bank To BC ID " . $bc->id . ' GP Name : ' . $bc->gp->gram_panchayat_name . PHP_EOL;
//                    } else {
//                        $error_as_no++;
//                    }
//                }
//            }
//        }
//        echo "TOTAL BC " . count($bc_gp_applications) . PHP_EOL;
//        echo "Total Bank ID CHANGE " . $chang_bank_id . ' ONly Assign GP TO BANK: ' . $as_no . PHP_EOL;
//        echo "ERROR Bank ID CHANGE " . $error_chang_bank_id . ' ERROR ONly Assign GP TO BANK: ' . $error_as_no . PHP_EOL;
//    }
//    public function actionGpchangebank($district_code, $bank_id = 7) {
//        $bc_gp_applications = SrlmBcApplication::find()->where(['district_code' => $district_code, 'blocked' => [0,1,4,5], 'status' => 2, 'gender' => 2, 'training_status' => [0, 1, 2, 3]])->all();
//        echo "Total BC " . count( $bc_gp_applications) . PHP_EOL;
//           $as_no=0;
//           $chang_bank_id=0;
//           $error_as_no=0;
//           $error_chang_bank_id=0;
//        foreach ($bc_gp_applications as $bc) {
//            if ($bc->gp->change_status == 0) {
//                if ($bc->bankidbc or $bc->handheld_machine_status == '1') {
//                    $old_bank = $bc->gp->master_partner_bank_id;
//                    $bc->gp->master_partner_bank_id = $bank_id;
//                    $bc->gp->previous_master_partner_bank_id = $old_bank;
//                    $bc->gp->change_status = 1;
//                    if ($bc->gp->save()) {
//                        $as_no++;
//                        echo "Assign Bank To BC ID " . $bc->id . ' GP Name : ' . $bc->gp->gram_panchayat_name . PHP_EOL;
//                    } else {
//                        $error_as_no++;
//                    }
//                } else {
//                    $old_bank = $bc->gp->master_partner_bank_id;
//                    $bc->gp->master_partner_bank_id = $bank_id;
//                    $bc->gp->previous_master_partner_bank_id = $old_bank;
//                    $bc->gp->change_status = 2;
//                    if ($bc->gp->save()) {
//                        $bc->gp->change_status = 3;
//                        $bc->master_partner_bank_id = $bc->gp->master_partner_bank_id;
//                        $bc->changebankid_datetime = new \yii\db\Expression('NOW()');
//                        $bc->action_type = SrlmBcApplication::ACTION_TYPE_BC_CHANGE_BANK;
//                        if ($bc->save() and $bc->gp->save()) {
//                             $chang_bank_id++;
//                            echo "Change Bank ID : BC Id " . $bc->id . ' GP Name : ' . $bc->gp->gram_panchayat_name . PHP_EOL;
//                        } else {
//                           $error_chang_bank_id++; 
//                        }
//                    }
//                }
//            }
//        }
//        echo "TOTAL BC " . count( $bc_gp_applications) . PHP_EOL;
//        echo "Total Bank ID CHANGE " . $chang_bank_id . ' ONly Assign GP TO BANK: ' . $as_no . PHP_EOL;
//        echo "ERROR Bank ID CHANGE " . $error_chang_bank_id . ' ERROR ONly Assign GP TO BANK: ' . $error_as_no . PHP_EOL;
//    }
//    public function actionChangebankid(){
//       $bc_gp_applications = SrlmBcApplication::find()->where(['srlm_bc_application.form_no' => 6, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.status' => 2, 'srlm_bc_application.gender' => 2, 'srlm_bc_application.training_status' => [0, 1, 2, 3]])->andWhere(['not', ['srlm_bc_application.temp_bankidbc' => null]])->all(); 
//        
//    }
//    public function actionChangebankdistrictall($bank_id = 7) {
//        $sql = 'SELECT srlm_bc_application.id,srlm_bc_application.bankidbc,srlm_bc_application.master_partner_bank_id,srlm_bc_application.handheld_machine_status,srlm_bc_application.status,srlm_bc_application.training_status,srlm_bc_application.blocked FROM `master_gram_panchayat`
//
//JOIN srlm_bc_application on srlm_bc_application.gram_panchayat_code=master_gram_panchayat.gram_panchayat_code
//where master_gram_panchayat.district_code in (131,137,148,160,164,178,182) and master_gram_panchayat.status=1 and master_gram_panchayat.master_partner_bank_id=master_gram_panchayat.previous_master_partner_bank_id  and srlm_bc_application.status=2 and srlm_bc_application.training_status in  (0,1,2,3)
//';
//        $bc_gp_applications = \bc\models\master\MasterGramPanchayat::findBySql($sql)->all();
//        echo "Total BC " . count($bc_gp_applications) . PHP_EOL;
//        $as_no = 0;
//        $chang_bank_id = 0;
//        $error_as_no = 0;
//        $error_chang_bank_id = 0;
//        foreach ($bc_gp_applications as $bcs) {
//            $bc = SrlmBcApplication::findOne($bcs->id);
//            if ($bc->gp->change_status == 0) {
//                if ($bc->bankidbc or $bc->handheld_machine_status == '1') {
//                    $old_bank = $bc->gp->master_partner_bank_id;
//                    $bc->gp->master_partner_bank_id = $bank_id;
//                    $bc->gp->previous_master_partner_bank_id = $old_bank;
//                    $bc->gp->change_status = 1;
//                    if ($bc->gp->save()) {
//                        $as_no++;
//                        echo "Assign Bank To BC ID " . $bc->id . ' GP Name : ' . $bc->gp->gram_panchayat_name . PHP_EOL;
//                    } else {
//                        $error_as_no++;
//                    }
//                } else {
//                    $old_bank = $bc->gp->master_partner_bank_id;
//                    $bc->gp->master_partner_bank_id = $bank_id;
//                    $bc->gp->previous_master_partner_bank_id = $old_bank;
//                    $bc->gp->change_status = 2;
//                    if ($bc->gp->save()) {
//                        $bc->gp->change_status = 3;
//                        $bc->master_partner_bank_id = $bc->gp->master_partner_bank_id;
//                        $bc->changebankid_datetime = new \yii\db\Expression('NOW()');
//                        $bc->action_type = SrlmBcApplication::ACTION_TYPE_BC_CHANGE_BANK;
//                        if ($bc->save() and $bc->gp->save()) {
//                            $chang_bank_id++;
//                            echo "Change Bank ID : BC Id " . $bc->id . ' GP Name : ' . $bc->gp->gram_panchayat_name . PHP_EOL;
//                        } else {
//                            $error_chang_bank_id++;
//                        }
//                    }
//                }
//            }
//        }
//        echo "TOTAL BC " . count($bc_gp_applications) . PHP_EOL;
//        echo "Total Bank ID CHANGE " . $chang_bank_id . ' ONly Assign GP TO BANK: ' . $as_no . PHP_EOL;
//        echo "ERROR Bank ID CHANGE " . $error_chang_bank_id . ' ERROR ONly Assign GP TO BANK: ' . $error_as_no . PHP_EOL;
//    }
//    public function actionChangebanksbi($bank_id = 7) {
//        $sql = 'SELECT * FROM `srlm_bc_application` where district_code in (124,134,145,152,158,167,168,169,172,177,181,660) and status=2 and training_status in (0,1,2,3) and master_partner_bank_id!=7 and bankidbc is null ';
//        $bc_gp_applications = SrlmBcApplication::findBySql($sql)->all();
//        echo "Total BC " . count($bc_gp_applications) . PHP_EOL;
//        $as_no = 0;
//        $chang_bank_id = 0;
//        $error_as_no = 0;
//        $error_chang_bank_id = 0;
//        foreach ($bc_gp_applications as $bcs) {
//            $bc = SrlmBcApplication::findOne($bcs->id);
//            if ($bc->gp->change_status == 0) {
//                if ($bc->bankidbc or $bc->handheld_machine_status == '1') {
//                    $old_bank = $bc->gp->master_partner_bank_id;
//                    $bc->gp->master_partner_bank_id = $bank_id;
//                    $bc->gp->previous_master_partner_bank_id = $old_bank;
//                    $bc->gp->change_status = 1;
//                    if ($bc->gp->save()) {
//                        $as_no++;
//                        echo "Assign Bank To BC ID " . $bc->id . ' GP Name : ' . $bc->gp->gram_panchayat_name . PHP_EOL;
//                    } else {
//                        $error_as_no++;
//                    }
//                } else {
//                    $old_bank = $bc->gp->master_partner_bank_id;
//                    $bc->gp->master_partner_bank_id = $bank_id;
//                    $bc->gp->previous_master_partner_bank_id = $old_bank;
//                    $bc->gp->change_status = 2;
//                    if ($bc->gp->save()) {
//                        $bc->gp->change_status = 3;
//                        $bc->master_partner_bank_id = $bc->gp->master_partner_bank_id;
//                        $bc->changebankid_datetime = new \yii\db\Expression('NOW()');
//                        $bc->action_type = SrlmBcApplication::ACTION_TYPE_BC_CHANGE_BANK;
//                        if ($bc->save() and $bc->gp->save()) {
//                            $chang_bank_id++;
//                            echo "Change Bank ID : BC Id " . $bc->id . ' GP Name : ' . $bc->gp->gram_panchayat_name . PHP_EOL;
//                        } else {
//                            $error_chang_bank_id++;
//                        }
//                    }
//                }
//            }
//        }
//        echo "TOTAL BC " . count($bc_gp_applications) . PHP_EOL;
//        echo "Total Bank ID CHANGE " . $chang_bank_id . ' ONly Assign GP TO BANK: ' . $as_no . PHP_EOL;
//        echo "ERROR Bank ID CHANGE " . $error_chang_bank_id . ' ERROR ONly Assign GP TO BANK: ' . $error_as_no . PHP_EOL;
//    }

    /**
     * Renders the index view for the module
     * @return string
     */
//    public function actionNewid() {
//        //698080 phase 6
//        echo "Start time : " . date('Y-m-d H:i:s');
//        $max_id = 698080;
//        $models = SrlmBcApplication6::find()->select(['id'])->orderBy('id asc')->all();
//        $sr_no = 1;
//        foreach ($models as $model) {
//            $new_id = $max_id + $sr_no;
//            $condition = ['and',
//                ['=', 'id', $model->id],
//            ];
//            SrlmBcApplication6::updateAll([
//                'new_id' => $new_id,
//                'application_id' => 'UPBC' . Utility::add_leading_zero($new_id, 6),
//                    ], $condition);
//            $sr_no++;
//        }
//        echo "End Time Time : " . date('Y-m-d H:i:s');
//    }
//    public function actionNewid() {
//        $max_id = 417842;
//        $models = SrlmBcApplication3::find()->orderBy('id asc')->all();
//        $sr_no = 1;
//        foreach ($models as $model) {
//            $new_id = $max_id + $sr_no;
//            $condition = ['and',
//                ['=', 'id', $model->id],
//            ];
//            SrlmBcApplication3::updateAll([
//                'new_id' => $new_id,
//                'application_id' => 'UPBC' . Utility::add_leading_zero($new_id, 6),
//                    ], $condition);
//            $sr_no++;
//        }
//    }
//    public function actionCopytabl6to1() {
//        echo "Copy Start time : " . date('Y-m-d H:i:s') . PHP_EOL;
//        $models = SrlmBcApplication6::find()->orderBy('id asc')->all();
//        $sr_no = 0;
//        foreach ($models as $model) {
//            $chphase1 = SrlmBcApplication::findOne(['srlm_bc_selection_user_id' => $model->srlm_bc_selection_user_id]);
//            if ($chphase1 == null) {
//                $bc = new SrlmBcApplication();
//                $bc->id = $model->id;
//                $bc->setAttributes($model->toArray());
//                $bc->application_phase = $model->application_phase;
//                if ($bc->save()) {
//                    $sr_no++;
//                }
//            } else {
//                echo 'copy error : ' . $model->id . PHP_EOL;
//            }
//        }
//        echo 'copy row : ' . $sr_no . PHP_EOL;
//    }
//    public function actionCopytabl5to1() {
//        $models = SrlmBcApplication5::find()->select(['id'])->orderBy('id asc')->all();
//        $sr_no = 0;
//        foreach ($models as $model) {
//            $model = SrlmBcApplication5::findOne($model->id);
//            $chphase1 = SrlmBcApplication::findOne(['srlm_bc_selection_user_id' => $model->srlm_bc_selection_user_id]);
//            if ($chphase1 == null) {
//                $bc = new SrlmBcApplication();
//                $bc->id = $model->id;
//                $bc->setAttributes($model->toArray());
//                $bc->application_phase = $model->application_phase;
//                $bc->action_type = 1;
//                if ($bc->save()) {
//                    $sr_no++;
//                }
//            } else {
//                if ($chphase1->form_number == 0) {
//                    if (!is_null($chphase1->form_uuid)) {
//                        $chphase1->form_uuid = null;
//                    }
//                    $chphase1->srlm_bc_selection_user_id = -$chphase1->srlm_bc_selection_user_id;
//                    $chphase1->status = -1;
//                    if ($chphase1->save()) {
//                        $bc = new SrlmBcApplication();
//                        $bc->id = $model->id;
//                        $bc->setAttributes($model->toArray());
//                        $bc->application_phase = $model->application_phase;
//                        $bc->action_type = 1;
//                        if ($bc->save(false)) {
//                            $sr_no++;
//                        }
//                    }
//                }
//                if ($chphase1->form_number > 0 and $chphase1->form_number < 5 and $model->gender) {
//                    if (!is_null($chphase1->form_uuid)) {
//                        $chphase1->form_uuid = null;
//                    }
//                    $chphase1->srlm_bc_selection_user_id = -$chphase1->srlm_bc_selection_user_id;
//                    $chphase1->status = -1;
//                    if ($chphase1->save()) {
//                        $bc = new SrlmBcApplication();
//                        $bc->id = $model->id;
//                        $bc->setAttributes($model->toArray());
//                        $bc->application_phase = $model->application_phase;
//                        $bc->action_type = 1;
//                        if ($bc->save(false)) {
//                            $sr_no++;
//                        }
//                    }
//                }
//            }
//        }
//        echo 'copy row : ' . $sr_no;
//    }
//    public function actionNewid() {
//        //604266
//        echo "Start time : " . date('Y-m-d H:i:s');
//        $max_id = 604266;
//        $models = SrlmBcApplication5::find()->select(['id'])->orderBy('id asc')->all();
//        $sr_no = 1;
//        foreach ($models as $model) {
//            $new_id = $max_id + $sr_no;
//            $condition = ['and',
//                ['=', 'id', $model->id],
//            ];
//            SrlmBcApplication5::updateAll([
//                'new_id' => $new_id,
//                'application_id' => 'UPBC' . Utility::add_leading_zero($new_id, 6),
//                    ], $condition);
//            $sr_no++;
//        }
//        echo "Gp Coplete time : " . date('Y-m-d H:i:s');
//    }
//    public function actionMarkbcgpuraban() {
//        $gpmodels = \bc\models\master\MasterGramPanchayat::find()->where(['gp_covert_urban' => 1])->all();
//
//        foreach ($gpmodels as $model) {
//            $condition = ['and',
//                ['=', 'gram_panchayat_code', $model->gram_panchayat_code],
//            ];
//            SrlmBcApplication::updateAll([
//                'urban_shg' => 1,
//                    ], $condition);
//        }
//    }
//    public function actionGenratepin() {
//        $null = new \yii\db\Expression('NULL');
//        $no = 38000;
//
//        for ($x = 0; $x <= $no; $x++) {
//            $models = SrlmBcSelectionUser::find()->andFilterWhere(['is', 'pin', new \yii\db\Expression('NULL')])->orderBy('id asc')->limit(500)->all();
//            foreach ($models as $model) {
//                $model->pin = mt_rand(1000, 9999);
//                if ($model->update(false)) {
//                    
//                } else {
//                    
//                }
//            }
//        }
//    }
//    public function actionGenratecbouserpin() {
//        $null = new \yii\db\Expression('NULL');
//        $no = 50;
//        for ($x = 0; $x <= $no; $x++) {
//            $sql = "SELECT * FROM user WHERE role=100 AND (LENGTH(otp_value) != 4 or otp_value is null) limit 1000";
//            $connection = \Yii::$app->dbcbo;
//            $insql = $connection->createCommand($sql);
//            $result = $insql->queryAll();
//            foreach ($result as $user) {
//                $bc = SrlmBcApplication::findOne(['user_id' => $user['id']]);
//                if ($bc != null) {
//                    $pin = $bc->user->pin;
//                    $condition = ['and',
//                        ['=', 'id', $user['id']],
//                    ];
//                    \common\models\User::updateAll([
//                        'otp_value' => $pin,
//                            ], $condition);
//                    \common\models\dynamicdb\bc\User::updateAll([
//                        'otp_value' => $pin,
//                            ], $condition);
//                    \common\models\dynamicdb\cbo_detail\User::updateAll([
//                        'otp_value' => $pin,
//                            ], $condition);
//                } else {
//                    $pin = \common\helpers\Utility::generateNumericOTP(4);
//                    $condition = ['and',
//                        ['=', 'id', $user['id']],
//                    ];
//                    \common\models\User::updateAll([
//                        'otp_value' => $pin,
//                            ], $condition);
//                    \common\models\dynamicdb\bc\User::updateAll([
//                        'otp_value' => $pin,
//                            ], $condition);
//                    \common\models\dynamicdb\cbo_detail\User::updateAll([
//                        'otp_value' => $pin,
//                            ], $condition);
//                }
//            }
//        }
//    }

    public function actionMissingcolumnpoplate() {
        $models = BcMissing::find()->where(['!=', 'bc_application_id', 0])->orderBy('id asc')->all();
        if (!empty($models)) {
            foreach ($models as $model) {
                if ($model->bc_application_id == $model->listed_bc_application_id) {
                    $model->bc_same = 1;
                }
                $model->rseti_bc_age = $model->bc->age;
                $model->rseti_bc_education = $model->bc->reading_skills;
                if ($model->bc->already_group_member == 1) {
                    $model->rseti_bc_shg_member = 0;
                } else {
                    $model->rseti_bc_shg_member = 1;
                }
                $model->rseti_bc_application_status = $model->bc->form_number == 6 ? 1 : 0;
                $model->rseti_bc_cast = $model->bc->cast;

                $model->listed_bc_training_status = $model->listedbc->training_status;
                $model->listed_bc_age = $model->listedbc->age;
                $model->listed_bc_cast = $model->listedbc->cast;
                $model->listed_bc_education = $model->listedbc->reading_skills;
                if ($model->listedbc->already_group_member == 1) {
                    $model->listed_bc_shg_member = 0;
                } else {
                    $model->listed_bc_shg_member = 1;
                }
                if ($model->listedbc->onboarding) {
                    $model->listed_bc_onboard = 1;
                }
                if ($model->listedbc->bc_shg_funds_status) {
                    $model->listed_bc_funds_transfer = 1;
                }
                $model->save();
            }
        }
    }

    public function actionMissing() {
        $models = BcMissing::find()->orderBy('id asc')->all();
        if (!empty($models)) {
            foreach ($models as $model) {
                $bc = SrlmBcApplication::find()->where(['mobile_number' => $model->mobile_number])->one();
                if ($bc != null) {
                    $model->bc_application_id = $bc->id;
                    $model->bc_selection_user_id = $bc->srlm_bc_selection_user_id;
                    $listed_bc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $bc->gram_panchayat_code, 'status' => 2])->one();
                    if ($listed_bc != null) {
                        $model->listed_bc_training_status = $listed_bc->training_status;
                        $model->listed_bc_application_id = $listed_bc->id;
                        $model->listed_bc_selection_user_id = $listed_bc->srlm_bc_selection_user_id;
                    }
                    $model->save();
                }
            }
        }
    }

//    public function actionBarabanki() {
//        $connection = \Yii::$app->dbbc;
//        $insql = $connection->createCommand("SELECT * FROM rsethi_133");
//        $result = $insql->queryAll();
//
//        if (!empty($result)) {
//            foreach ($result as $model) {
//                $bbbc = SrlmBcApplication::find()->where(['application_id' => $model['id']])->one();
//                if ($bbbc != null) {
//                    $listed_bc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $bbbc->gram_panchayat_code, 'status' => 2])->orderBy('selection_by desc')->limit(1)->one();
//                    if ($listed_bc != null) {
//                        $sql = " UPDATE rsethi_133 SET current_listed_application_id='" . $listed_bc->application_id . "',";
//                        $sql .= " current_listed_application_status=" . $listed_bc->training_status;
//                        $sql .= " where id='" . $model['id'] . "'";
//                        \Yii::$app->dbbc->createCommand($sql)->execute();
//                    }
//                }
//            }
//        }
//    }

    public function actionMissingbc() {
        $models = BcMissing::find()->where(['!=', 'bc_application_id', 0])->orderBy('id asc')->all();
        if (!empty($models)) {
            foreach ($models as $model) {
                if ($model->bc_application_id != $model->listed_bc_application_id) {
                    if (isset($model->listedbc) and $model->listedbc->missing_bc == 0) {
                        $model->listedbc->missing_bc = 1;
                        $model->listedbc->save();
                    }
                }
            }
        }
    }

//    public function actionAppidpopulate() {
//        for ($x = 0; $x <= 37000; $x++) {
//            $models = SrlmBcApplication::find()->where(['is', 'application_id', new \yii\db\Expression('null')])->orderBy('id asc')->limit(10)->all();
//            if (!empty($models)) {
//                foreach ($models as $model) {
//                    $condition = ['and',
//                        ['=', 'id', $model->id],
//                    ];
//                    SrlmBcApplication::updateAll([
//                        'application_id' => 'UPBC' . Utility::add_leading_zero($model->id, 6),
//                        'division_code' => $model->district != null ? $model->district->division_code : null,
//                        'division_name' => $model->district != null ? $model->district->division_name : null,
//                        'profile_photo' => $model->user != null ? $model->user->profile_photo : null,
//                        'aadhar_front_photo' => $model->user != null ? $model->user->aadhar_front_photo : null,
//                        'aadhar_back_photo' => $model->user != null ? $model->user->aadhar_back_photo : null,
//                            ], $condition);
//                }
//            }
//        }
//    }
//    public function actionBcphotostatus() {
//        for ($x = 0; $x <= 38000; $x++) {
//            $models = SrlmBcApplication::find()->where(['is', 'bc_photo_status', new \yii\db\Expression('null')])->andwhere(['>=', 'form_number', 1])->orderBy('id asc')->limit(500)->all();
//            if (!empty($models)) {
//                foreach ($models as $model) {
//                    $condition = ['and',
//                        ['=', 'id', $model->id],
//                    ];
//                    SrlmBcApplication::updateAll([
//                        'profile_photo' => $model->user != null ? $model->user->profile_photo : null,
//                        'aadhar_front_photo' => $model->user != null ? $model->user->aadhar_front_photo : null,
//                        'aadhar_back_photo' => $model->user != null ? $model->user->aadhar_back_photo : null,
//                        'bc_photo_status' => ($model->user->profile_photo and $model->user->aadhar_front_photo and $model->user->aadhar_back_photo) ? 1 : 0,
//                            ], $condition);
//                }
//            }
//        }
//    }
//    public function actionSelectedblockpdf() {
//        $district_models = \bc\models\master\MasterDistrict::find()->select('district_code')->orderBy('district_name asc')->all();
//
//        foreach ($district_models as $district_model) {
//            try {
//                $block_models = \bc\models\master\MasterBlock::find()->select('block_code')->where(['district_code' => $district_model->district_code])->orderBy('block_name asc')->all();
//                // print_r($block_models);exit;
//                foreach ($block_models as $block_model) {
//                    echo $block_model->block_code . PHP_EOL;
//                    $searchModels = new \bc\modules\selection\models\SrlmBcApplicationSearch();
//                    $searchModels->block_code = $block_model->block_code;
//                    $dataProvider = $searchModels->verify($searchModels, null, false);
//                    $block = \bc\models\master\MasterBlock::findOne(['block_code' => $searchModels->block_code]);
//                    $models = $dataProvider->getModels();
//                    $file_name = $block->district_name . "_" . $block->block_name . "";
//                    echo $file_name . PHP_EOL;
//                    $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf', 'default_font_size' => 9,
//                        'default_font' => 'freesans',
//                        'margin_header' => 0,
//                        'margin_footer' => 10,]);
//
//                    $mpdf->SetHeader('<table style="width:100%;vertical-align: top;border:none">
//            <tr>
//            <td style="vertical-align: top;border:none">
//            <img width="40px" src="https://bc.upsrlm.org/images/sgrca_logo.png">
//            </td>
//            <td style="vertical-align: top;border:none;color: #F79520;margin-top: 2px;margin-bottom: 4px;">State Rural Livelihood Mission : Selection of BC Sakhi
//            <br/>District (Block) : ' . $block->district_name . ' (' . $block->block_name . ')
//            </td>
//            
//<tr>
//</table>');
//                    $mpdf->setFooter('{PAGENO} / {nb}');
//                    $html = "<div>";
//                    if ($dataProvider->getTotalCount() > 0) {
//                        $html .= "<table class='layout'>";
//                        $html .= "<thead>";
//                        $html .= "<tr>";
//                        $html .= "<th width='6%'>";
//                        $html .= "S.R. NO.";
//                        $html .= "</th>";
//                        $html .= "<th width='20%'>";
//                        $html .= "Candidiate Detail";
//                        $html .= "</th>";
//                        $html .= "<th width='20%'>";
//                        $html .= "Address <br/>Mobile No";
//                        $html .= "</th>";
//                        $html .= "<th width='20%'>";
//                        $html .= "Aadhar front photo";
//                        $html .= "</th>";
//                        $html .= "<th width='20%'>";
//                        $html .= "Aadhar back photo";
//                        $html .= "</th>";
//                        $html .= "</tr>";
//                        $html .= "</thead>";
//                        $html .= "<tbody>";
//                        $sr_no = 1;
//                        foreach ($models as $model) {
//                            $html .= "<tr>";
//                            $html .= "<td width='6%'>";
//                            $html .= $sr_no;
//                            $html .= "</th>";
//                            $html .= "<td width='30%'>";
//                            $html .= "Application No. : " . $model->application_id . "<br/>Name : " . $model->name . '<br/>Guardian name : ' . $model->guardian_name . '<br/>Age : ' . $model->age . '<br/>Category : ' . $model->castrel->name_eng;
//                            $html .= "</td>";
//                            $html .= "<td width='20%'>";
//                            $html .= $model->fulladdressgp . '<br/><br/>Mobile Number : ' . $model->mobile_number . '<br/>Verified mobile no :  ' . $model->user->mobile_no;
//                            $html .= "</td>";
//                            $html .= "<td width='22%'>";
//                            if ($model->user->aadhar_front_photo != null) {
//                                $html .= ' <span class="profile-picture">
//                                        <img width="140px" height="140px" src="' . $model->aadhar_front_photo_url . '" data-src="' . $model->aadhar_front_photo_url . '"  class="lozad" title="aadhar_front_photo" style="cursor : pointer"/>
//                                        </span>';
//                            }
//                            $html .= "</td>";
//                            $html .= "<td width='22%'>";
//                            if ($model->user->aadhar_back_photo != null) {
//                                $html .= '<span class="profile-picture">
//                                        <img width="140px" height="140px" src="' . $model->aadhar_back_photo_url . '" data-src="' . $model->aadhar_back_photo_url . '"  class="lozad" title="aadhar_back_photo" style="cursor : pointer"/>
//                                        </span>';
//                            }
//                            $html .= "</td>";
//                            $html .= "</tr>";
//                            $sr_no++;
//                        }
//                        $html .= "</tbody>";
//                        $html .= "</table>";
//                        $html .= '<style>
//            
//table {
//  width:100%;
//}
//table, th, td {
//  border: 1px solid grey;
//  border-collapse: collapse;
//}
//th, td {
//  padding: 3px;
//  text-align: left;
//}
//table#t01 tr:nth-child(even) {
//  background-color: #eee;
//}
//table#t01 tr:nth-child(odd) {
// background-color: #fff;
//}
//table#t01 th {
//  background-color: black;
//  color: white;
//}
//</style>';
//                    }
//                    $html .= "/<div>";
//                    //$mpdf->WriteHTML($this->renderPartial('@bc/modules/selection/views/bcdata/report_pdf', ['searchModel' => $searchModels, 'dataProvider' => $dataProvider]));
//
//                    $mpdf->autoScriptToLang = true;
//                    $mpdf->autoLangToFont = true;
//                    $mpdf->WriteHTML($html);
//                    $APPLICATION_FORM_FILE_FOLDER = \Yii::$app->params['bcdatapath'];
//                    $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "bcselection/bcdata/pdf/";
//                    $mpdf->Output($APPLICATION_FORM_FILE_FOLDER . $file_name . '.pdf', 'F');
//                }
//            } catch (\Exception $exc) {
//                echo $exc->getTraceAsString();
//            }
//        }
//    }
//    public function actionResetdistrict() {
//        $sql = "SELECT A.id,
//A.first_name,
//A.middle_name,
//A.sur_name,
//A.guardian_name,
//A.mobile_number,
//A.district_name,
//A.district_code,
//A.block_name,
//A.block_code,
//A.gram_panchayat_name,
//A.gram_panchayat_code,
//A.village_name,
//A.village_code,
//A.hamlet,
//A.training_status
//FROM `srlm_bc_application` AS A
//
//LEFT JOIN `master_gram_panchayat` AS B
//ON B.`gram_panchayat_code` = A.`gram_panchayat_code`  AND B.`district_code` = A.`district_code` 
//
//where A.status!=0 and A.status!=-1  and A.gender=2 and A.form_number=6  and B.id IS NULL  
//ORDER BY `A`.`id` ASC";
//        $models = SrlmBcApplication::findBySql($sql)->all();
//        foreach ($models as $model) {
//            $model = SrlmBcApplication::findOne($model->id);
//            $gpmodel = \bc\models\master\MasterGramPanchayat::findOne(['gram_panchayat_code' => $model->gram_panchayat_code]);
//
//            $model->district_code = $gpmodel->district_code;
//            $model->district_name = $gpmodel->district_name;
//            $model->block_code = $gpmodel->block_code;
//            $model->block_name = $gpmodel->block_name;
//            if ($model->update()) {
//                $condition = ['and',
//                    ['=', 'parent_id', $model->id],
//                ];
//                \bc\modules\selection\models\SrlmBcApplicationHistory::updateAll([
//                    'district_code' => $model->district_code,
//                    'district_name' => $model->district_name,
//                    'block_code' => $model->block_code,
//                    'block_name' => $model->block_name,
//                        ], $condition);
//                $condition1 = ['and',
//                    ['=', 'bc_application_id', $model->id],
//                ];
//                \bc\modules\training\models\RsetisBatchParticipants::updateAll([
//                    'district_code' => $model->district_code,
//                    'district_name' => $model->district_name,
//                    'block_code' => $model->block_code,
//                    'block_name' => $model->block_name,
//                        ], $condition1);
//                echo $model->id . PHP_EOL;
//            } else {
//                print_r($model->getErrors());
//            }
////            echo $gpmodel->district_name . PHP_EOL;
////            print_r($gpmodel->village);
////            if($model->block_code=='0'){
////               echo $gpmodel->district_name . PHP_EOL; 
////            }
//        }
//    }
    public function actionRd6() {
        $sql = "SELECT A.id,
A.first_name,
A.middle_name,
A.sur_name,
A.guardian_name,
A.mobile_number,
A.district_name,
A.district_code,
A.block_name,
A.block_code,
A.gram_panchayat_name,
A.gram_panchayat_code,
A.village_name,
A.village_code,
A.hamlet,
A.training_status
FROM `srlm_bc_application6` AS A

LEFT JOIN `master_gram_panchayat` AS B
ON B.`gram_panchayat_code` = A.`gram_panchayat_code`  AND B.`district_code` = A.`district_code` 

where A.status!=0 and A.status!=-1  and A.gender=2 and A.form_number=6  and B.id IS NULL  
ORDER BY `A`.`id` ASC";
        $models = \bc\modules\selection\models\SrlmBcApplication6::findBySql($sql)->all();
        foreach ($models as $model) {
            $model = \bc\modules\selection\models\SrlmBcApplication6::findOne($model->id);
            $gpmodel = \bc\models\master\MasterGramPanchayat::findOne(['gram_panchayat_code' => $model->gram_panchayat_code]);

            $model->district_code = $gpmodel->district_code;
            $model->district_name = $gpmodel->district_name;
            $model->block_code = $gpmodel->block_code;
            $model->block_name = $gpmodel->block_name;
            if ($model->update()) {

                echo $model->id . PHP_EOL;
            } else {
                print_r($model->getErrors());
            }
//            echo $gpmodel->district_name . PHP_EOL;
//            print_r($gpmodel->village);
//            if($model->block_code=='0'){
//               echo $gpmodel->district_name . PHP_EOL; 
//            }
        }
    }

//    public function actionBlockfromvillage() {
//        $gpmodels = \bc\models\master\MasterGramPanchayat::find()->where(['block_code' => 0])->all();
//        foreach ($gpmodels as $old_gp) {
//            $village = \bc\models\master\MasterVillage::find()->where(['gram_panchayat_code' => $old_gp->gram_panchayat_code])->andWhere(['!=', 'block_code', '0'])->one();
//            if ($village != null) {
//                $condition1 = ['and',
//                    ['=', 'gram_panchayat_code', $old_gp->gram_panchayat_code],
//                ];
//                \bc\models\master\MasterGramPanchayat::updateAll([
//                    'block_code' => $village->block_code,
//                    'block_name' => $village->block_name,
//                        ], $condition1);
//                \common\models\master\MasterGramPanchayat::updateAll([
//                    'block_code' => $village->block_code,
//                    'block_name' => $village->block_name,
//                        ], $condition1);
//            }
//        }
//    }
//    public function actionMarknewentry() {
//        $gpmodels = \common\models\master\MasterGramPanchayat::find()->where(['>', 'id', '58586'])->all();
//        foreach ($gpmodels as $gp) {
//            $condition1 = ['and',
//                ['=', 'gram_panchayat_code', $gp->gram_panchayat_code],
//                ['=', 'id', $gp->id],
//            ];
//
//            \common\models\master\MasterGramPanchayat::updateAll([
//                'new' => 1,
//                    ], $condition1);
//        }
//    }
//    public function actionNewoldgp() {
//        $newgps = \common\models\master\MasterGramPanchayatNew::find()->all();
//        foreach ($newgps as $newgp) {
//            $old_gp = \common\models\master\MasterGramPanchayat::findOne(['gram_panchayat_code' => $newgp->gram_code]);
//            if ($old_gp != null) {
//                $newgp->old_status = 1;
//                $old_gp->new_status = 1;
//                $old_gp->new_gram_panchayat_name = $newgp->gram_name;
//                $old_gp->new_gram_panchayat_code = $newgp->gram_code;
//                $old_gp->new_block_name = $newgp->block_name;
//                $old_gp->new_block_code = $newgp->block_code;
//                $newgp->old_gp_name = $old_gp->gram_panchayat_name;
//                $newgp->old_gp_code = $old_gp->gram_panchayat_code;
//                if ($old_gp->block_code != '0') {
//                    $newgp->old_block_code = $old_gp->block_code;
//                    $newgp->old_block_name = $old_gp->block_name;
//                }
//                if (strtolower($newgp->gram_name) == strtolower($old_gp->gram_panchayat_name)) {
//                    $old_gp->name_match_status = 1;
//                }
//                if (strtolower($newgp->block_name) != strtolower($old_gp->block_name)) {
//                    $old_gp->doubt_block = 1;
//                }
//                if ($newgp->save(false) and $old_gp->save(false)) {
//                    
//                }
//            } else {
//                $newgp->old_status = 0;
//                $newgp->save(false);
//            }
//        }
//    }
//    public function actionOldnewgp() {
//        $oldgps = \common\models\master\MasterGramPanchayat::find()->all();
//        foreach ($oldgps as $old_gp) {
//            $newgp = \common\models\master\MasterGramPanchayatNew::findOne(['gram_code' => $old_gp->gram_panchayat_code]);
//            if ($newgp != null) {
//                $newgp->old_status = 1;
//                $old_gp->new_status = 1;
//                $old_gp->new_gram_panchayat_name = $newgp->gram_name;
//                $old_gp->new_gram_panchayat_code = $newgp->gram_code;
//                $old_gp->new_block_name = $newgp->block_name;
//                $old_gp->new_block_code = $newgp->block_code;
//                $newgp->old_gp_name = $old_gp->gram_panchayat_name;
//                $newgp->old_gp_code = $old_gp->gram_panchayat_code;
//                if ($old_gp->block_code != '0') {
//                    $newgp->old_block_code = $old_gp->block_code;
//                    $newgp->old_block_name = $old_gp->block_name;
//                }
//                if (strtolower($newgp->gram_name) == strtolower($old_gp->gram_panchayat_name)) {
//                    $old_gp->name_match_status = 1;
//                }
////                if (strtolower($newgp->block_name) != strtolower($old_gp->block_name)) {
////                    $old_gp->doubt_block = 1;
////                }
//
//                if ($newgp->save(false) and $old_gp->save(false)) {
//                    
//                }
//            } else {
//                $old_gp->new_status = 0;
//                $old_gp->save(false);
//            }
//        }
//    }
//    public function actionGp() {
//        $old_gp = \bc\models\master\MasterGramPanchayat::find()->all();
//        foreach ($old_gp as $old_gp) {
//            $selected_but_not_enag = SrlmBcApplication::findOne($old_gp->selected_application_id);
//            if ($selected_but_not_enag != null) {
//                if (in_array($selected_but_not_enag->reading_skills, [1, 2]) and $selected_but_not_enag->age < 50) {
//                    
//                } else {
//                    $old_gp->selected_but_not_eligible = 1;
//                }
//            }
//            $no_of_eligible_application = SrlmBcApplication::find()->andWhere(['gram_panchayat_code' => $old_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'reading_skills' => [1, 2]])->andWhere(['<', 'age', 50])->count();
//            $old_gp->no_of_eligible_application = $no_of_eligible_application;
//            if ($old_gp->no_of_eligible_application) {
//                $old_gp->eligible = 1;
//            }
//            $old_gp->update();
//        }
//    }
//    public function actionNewblockcode() {
//        $new_gps_blocks = \common\models\master\MasterGramPanchayatNew::find()->select(['block_code', 'block_name', 'district_code'])->distinct()->all();
//        foreach ($new_gps_blocks as $bm) {
//            $block = \common\models\master\MasterBlock::find()->where(['district_code' => $bm->district_code])->andWhere(['block_name' => $bm->block_name])->one();
//            if ($block != null) {
//                $model = new \backend\models\form\BlockNewCodeForm($block);
//                $model->new_block_code = $bm->block_code;
//                $model->new_block_name = $bm->block_name;
//                if ($model->validate() and $model->save()) {
//                    
//                }
//            }
//        }
//    }
//    public function actionTemp() {
//        $models = \bc\models\NotificationLog::find()->where(['detail_id' => 15])->andWhere(['message' => ''])->all();
//        foreach ($models as $lmodel) {
//            $model = \bc\modules\selection\models\SrlmBcApplicationHistory::find()->where(['action_type' => SrlmBcApplication::ACTION_TYPE_BANK_VERIFICATION])->andWhere(['srlm_bc_selection_user_id' => $lmodel->user_id])->one();
//            if ($model != null) {
//                $html = '';
//                if ($model->bc_bank == '3') {
//                    $html .= 'बी0सी0 सखी बैंक विवरण वापसी का कारण.<br/>';
//                    $html .= $model->bcbankrjregion;
//                }
//                if ($model->shg_bank == '3') {
//                    $html .= 'बी0सी0 सखी का स्वयं सहायता समूह बैंक विवरण वापसी का कारण .<br/>';
//                    $html .= $model->bcshgbankrjregion;
//                }
//                $condition = ['and',
//                    ['=', 'id', $lmodel->id],
//                ];
//                \bc\models\NotificationLog::updateAll([
//                    'message' => strip_tags($html),
//                        ], $condition);
//            }
//        }
//        echo count($models);
//    }
//    public function actionGpnamematch() {
//        $oldgps = \common\models\master\MasterGramPanchayat::find()->where(['new_status' => 1, 'name_match_status' => 0])->all();
//        foreach ($oldgps as $old_gp) {
//            if (strtolower($old_gp->new_gram_panchayat_name) == preg_replace('/\s+/', ' ', strtolower($old_gp->gram_panchayat_name))) {
//                $old_gp->name_match_status = 1;
//                $old_gp->update(false);
//            }
//        }
//    }
//    public function actionGpvacent() {
////        $oldgps = SrlmBcApplication::find()->where(['training_status' => [SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_UNWILLING, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE]])->andWhere(['gender' => 2, 'form_number' => 6])->andWhere(['urban_shg' => 0])->all();
//        $oldgps = SrlmBcApplication::find()->where(['bc_unwilling_rsetis' => 1])->andWhere(['gender' => 2, 'form_number' => 6])->andWhere(['urban_shg' => 0])->all();
//        foreach ($oldgps as $old_gp) {
//            $gp = \bc\models\master\MasterGramPanchayat::findOne(['gram_panchayat_code' => $old_gp->gram_panchayat_code]);
//            $bc_count = SrlmBcApplication::find()->where(['gram_panchayat_code' => $old_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6])->count();
//            $gp->first_standby_id = $bc_count;
//            $gp->save();
//        }
//    }
//    public function actionGpvacent1() {
//        $oldgps = SrlmBcApplication::find()->where(['training_status' => [SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_UNWILLING, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE]])->andWhere(['gender' => 2, 'form_number' => 6])->andWhere(['urban_shg' => 0])->all();
//
//        foreach ($oldgps as $old_gp) {
//            $gp = \bc\models\master\MasterGramPanchayat::findOne(['gram_panchayat_code' => $old_gp->gram_panchayat_code]);
//            $bc_count = SrlmBcApplication::find()->where(['gram_panchayat_code' => $old_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6])->count();
//            $gp->first_standby_id = $bc_count;
//            $gp->save();
//        }
//    }
//    public function actionNewgpadd() {
//        $new_gps = \bc\models\master\MasterGramPanchayatNew::find()->Where(['old_status' => 0])->andWhere(['not', ['old_block_code' => null]])->all();
//        foreach ($new_gps as $new_gp) {
//            $block = \bc\models\master\MasterBlock::findOne(['block_code' => $new_gp->old_block_code]);
//            if ($block != null) {
//                $gp_model = new \bc\models\master\MasterGramPanchayat();
//                $gp_model->state_code = 9;
//                $gp_model->state_name = 'Uttar Pradesh';
//                $gp_model->division_name = $block->district_name;
//                $gp_model->division_code = $block->district_code;
//                $gp_model->district_code = $new_gp->district_code;
//                $gp_model->district_name = $new_gp->district_name;
//                $gp_model->sub_district_code = $block->sub_district_code;
//                $gp_model->sub_district_name = $block->sub_district_name;
//                $gp_model->block_code = $new_gp->old_block_code;
//                $gp_model->block_name = $new_gp->old_block_name;
//                $gp_model->gram_panchayat_code = $new_gp->gram_code;
//                $gp_model->gram_panchayat_name = $new_gp->gram_name;
//                $gp_model->new = 1;
//                $gp_model->new_status = 1;
//                $gp_model->name_match_status = 1;
//                $gp_model->new_gram_panchayat_name = $new_gp->gram_name;
//                $gp_model->village_count = 0;
//                if ($gp_model->save()) {
//                    $max = \bc\models\master\MasterVillage::find()->max('village_code');
//                    $vill_model = new \bc\models\master\MasterVillage();
//                    $vill_model->state_code = $gp_model->state_code;
//                    $vill_model->state_name = $gp_model->state_name;
//                    $vill_model->division_code = $gp_model->division_code;
//                    $vill_model->division_name = $gp_model->division_name;
//                    $vill_model->district_code = $gp_model->district_code;
//                    $vill_model->district_name = $gp_model->district_name;
//                    $vill_model->sub_district_code = $gp_model->sub_district_code;
//                    $vill_model->sub_district_name = $gp_model->sub_district_name;
//                    $vill_model->block_code = $gp_model->block_code;
//                    $vill_model->block_name = $gp_model->block_name;
//                    $vill_model->village_code = ($max + 1);
//                    $vill_model->village_name = $gp_model->gram_panchayat_name;
//                    $vill_model->gram_panchayat_code = $gp_model->gram_panchayat_code;
//                    $vill_model->gram_panchayat_name = $gp_model->gram_panchayat_name;
//                    $vill_model->status = 1;
//                    if ($vill_model->save()) {
//                        $gp_model->village_count = 1;
//                        $gp_model->update();
//                    }
//                }
//            }
//        }
//    }
//    public function actionGpmatch() {
//        $old_gp = \bc\models\master\MasterGramPanchayat::find()->all();
//        foreach ($old_gp as $old_gp) {
//            $condition1 = ['and',
//                ['=', 'gram_panchayat_code', $old_gp->gram_panchayat_code],
//                ['=', 'id', $old_gp->id],
//            ];
//
//            \common\models\master\MasterGramPanchayat::updateAll([
//                'bc_selection_application_receive' => $old_gp->bc_selection_application_receive,
//                'selected_application_id' => $old_gp->selected_application_id,
//                'bc_selection_sc_st_application_receive' => $old_gp->bc_selection_sc_st_application_receive,
//                'bc_selection_obc_application_receive' => $old_gp->bc_selection_obc_application_receive,
//                'bc_selection_general_application_receive' => $old_gp->bc_selection_general_application_receive,
//                'group_member' => $old_gp->group_member,
//                'selected_bc' => $old_gp->selected_bc,
//                'selected_but_not_eligible' => $old_gp->selected_but_not_eligible,
//                'no_of_eligible_application' => $old_gp->no_of_eligible_application,
//                'first_standby_id' => $old_gp->first_standby_id,
//                'final_bc_id' => $old_gp->final_bc_id,
//                'eligible' => $old_gp->eligible,
//                    ], $condition1);
//        }
//    }

    public function actionMonthlyreport() {
        $sqlcer = "SELECT count(*) as certified,DATE_FORMAT(rsetis_center_training.schedule_date_of_exam, '%Y-%m-01') as month FROM `srlm_bc_application`
 JOIN rsetis_batch_participants on rsetis_batch_participants.bc_application_id=srlm_bc_application.id
 join rsetis_center_training on rsetis_center_training.id=rsetis_batch_participants.rsetis_center_training_id
 where rsetis_batch_participants.training_status=3 and rsetis_batch_participants.status !=-1 

 GROUP BY DATE_FORMAT(rsetis_center_training.schedule_date_of_exam, '%Y%m')  
 ORDER BY `month`  ASC";
        $connection = \Yii::$app->dbbc;
        $command = $connection->createCommand($sqlcer);
        $result = $command->queryAll();
        foreach ($result as $models) {
            echo $models['month'] . PHP_EOL;
            $month_model = \bc\models\transaction\BcTransactionMasterMonth::find()->where(['month_start_date' => $models['month']])->one();
            if (isset($month_model)) {
                $report_model = \bc\models\BcMonthlyReport::findOne(['month_id' => $month_model->id]);
                if (empty($report_model)) {
                    $report_model = new \bc\models\BcMonthlyReport();
                }
                $report_model->month_id = $month_model->id;
                $report_model->month_start_date = $month_model->month_start_date;
                $report_model->month_end_date = $month_model->month_end_date;
                $report_model->trained_certified = $models['certified'];

                $report_model->save();
            }
        }
    }

    public function actionMonthlyreporttransaction() {
        echo "Monthly transaction graph start Time : " . date('Y-m-d H:i:s');
        $month = date('Y-m-01');
        $month_end_date = \DateTime::createFromFormat("Y-m-d", $month)->format("Y-m-t");
        $month_models = \bc\models\transaction\BcTransactionMasterMonth::find()->andFilterWhere(['<=', 'month_end_date', $month_end_date])->all();

        foreach ($month_models as $month_model) {
            if (isset($month_model)) {
                $report_model = \bc\models\BcMonthlyReport::findOne(['month_id' => $month_model->id]);
                if (empty($report_model)) {
                    $report_model = new \bc\models\BcMonthlyReport();
                }
                $report_model->month_id = $month_model->id;
                $report_model->month_start_date = $month_model->month_start_date;
                $report_model->month_end_date = $month_model->month_end_date;
                if ($month_model->getBctransaction()->sum('is_new')) {
                    $report_model->operational = $month_model->getBctransaction()->sum('is_new');
                }
                if ($month_model->getBctransaction()->count()) {
                    $report_model->no_of_bc = $month_model->getBctransaction()->count();
                }
                if ($month_model->getBctransaction()->sum('no_of_transaction')) {
                    $report_model->no_of_transaction = $month_model->getBctransaction()->sum('no_of_transaction');
                }
                if ($month_model->getBctransaction()->sum('transaction_amount')) {
                    $report_model->transaction_amount = $month_model->getBctransaction()->sum('transaction_amount');
                }
                if ($month_model->getBctransaction()->sum('commission_amount')) {
                    $report_model->commission_amount = $month_model->getBctransaction()->sum('commission_amount');
                }
                if ($month_model->getBctransaction()->sum('big_ticket_count')) {
                    $report_model->big_ticket_count = $month_model->getBctransaction()->sum('big_ticket_count');
                }
                if ($month_model->getBctransaction()->sum('small_ticket_count')) {
                    $report_model->small_ticket_count = $month_model->getBctransaction()->sum('small_ticket_count');
                }
                $report_model->zero_transaction = $month_model->getBctransaction()->sum('zero_transaction');
                $report_model->save();
            }
        }
        echo "Monthly transaction graph completed Time : " . date('Y-m-d H:i:s');
    }

//    public function actionHonorariumnov2021() {
//        $file = 'uonorariumnov_2_2021.csv';
//        $file_path = Yii::$app->params['bcdatapath'] . 'tmp/' . 'uonorarium/' . $file;
//        $fp = fopen($file_path, 'r');
//        if (file_exists($file_path)) {
//            $line = fgetcsv($fp, 10000, ",");
//            $first_time = true;
//            $sr_no = 0;
//            $succ_no = 0;
//            do {
//                if ($first_time == true) {
//                    $first_time = false;
//                    $sr_no++;
//                    continue;
//                } else {
//                    $bc_model = SrlmBcApplication::findOne(['application_id' => $line[1]]);
//                    if ($bc_model != null) {
//                        if ($bc_model->training_status == 3 and $bc_model->bc_beneficiaries_code and $bc_model->blocked == '0') {
//                            $model = new \bc\modules\selection\models\form\BcPaymentForm($bc_model);
//                            $model->month1_payment_get = 1;
//                            $model->month1 = '2021-11';
//                            $model->bc_payment_model->month1_payment_by = 1;
//                            $model->month1_payment_date = '2021-12-27';
//                            if ($model->save()) {
//                                
//                            }
//                        } else {
//                            echo 'Error row ' . $sr_no . ' application id : ' . $bc_model->application_id . ' does not certified : ' . $line[5] . PHP_EOL;
//                        }
//                    } else {
//                        echo 'Error row ' . $sr_no . ' application id : ' . $line[1] . ' Not found' . PHP_EOL;
//                    }
//                    $sr_no++;
//                }
//            } while (($line = fgetcsv($fp, 10000, ",")) != FALSE);
//            echo 'Total row ' . $sr_no . PHP_EOL;
//            echo 'Success reset row ' . $succ_no . PHP_EOL;
//        }
//        return true;
//    }
//    public function actionRevertshg() {
//        $connection = \Yii::$app->dbbc;
//        $insql = $connection->createCommand("SELECT * FROM revert_bc_sh");
//        $result = $insql->queryAll();
//
//        if (!empty($result)) {
//            foreach ($result as $models) {
//                $bbbc = SrlmBcApplication::find()->where(['application_id' => $models['application_no']])->one();
//                if ($bbbc != null) {
//                    if ($bbbc->bc_shg_funds_status != 1) {
//                        if (!in_array($bbbc->shg_bank, [2])) {
//                            $cbo_shg_id = $bbbc->cbo_shg_id;
//                            $bbbc->cbo_shg_id = null;
//                            $bbbc->action_type = SrlmBcApplication::ACTION_TYPE_REVERT_BC_SHG_MAPPING;
//                            if ($bbbc->save()) {
//                                $model = \common\models\CboMembers::findOne(['cbo_id' => $cbo_shg_id, 'user_id' => $bbbc->user_id, 'cbo_type' => \common\models\CboMembers::CBO_TYPE_SHG]);
//                                if (isset($model)) {
//                                    if (($model->shg_chairperson + $model->shg_secretary + $model->shg_treasurer + $model->shg_member + $model->bc_sakhi + $model->samuh_sakhi + $model->wada_sakhi + $model->accountant) > 1) {
//                                        $model->bc_sakhi = 0;
//                                        $model->save();
//                                    } else {
//                                        $model->bc_sakhi = 0;
//                                        $model->status = -1;
//                                        $model->save();
//                                    }
//                                }
//                                try {
//                                    $condition1 = ['and',
//                                        ['=', 'id', $cbo_shg_id]
//                                    ];
//                                    \cbo\models\Shg::updateAll([
//                                        'bc_user_id' => null,
//                                            ], $condition1);
//                                    \common\models\dynamicdb\cbo_detail\RishtaShg::updateAll([
//                                        'bc_user_id' => null,
//                                            ], $condition1);
//                                } catch (\Exception $ex) {
//                                    
//                                }
//                                // \common\models\CboMembers::deleteAll('cbo_id = :cbo_id AND user_id = :user_id AND cbo_type = :cbo_type', [':cbo_type' => CboMembers::CBO_TYPE_SHG, ':user_id' => $this->bc_model->user_id, ':cbo_id' => $this->cbo_shg_id]);
//                                $condition = ['and',
//                                    ['=', 'user_id', $this->bc_model->user_id]
//                                ];
//                                CboMemberProfile::updateAll([
//                                    'shg' => 0,
//                                        ], $condition);
//                            }
//                        }
//                    }
//                }
//            }
//        }
//    }


}
