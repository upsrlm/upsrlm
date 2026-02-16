<?php

namespace console\controllers;

use Yii;
use console\helpers\Utility;
use yii\helpers\ArrayHelper;
use yii\console\Controller;
use yii\base\Model;
use cbo\models\Shg;
use cbo\models\CboVo;
use cbo\models\CboClf;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplication2;
use bc\modules\selection\models\BcGramPanchayat;
use yii\console\ExitCode;

//Table 
//
//Master_village    (both upsrlm + bc_selection)
//======================================
//bc_selection database
//master_gram_panchayat
//master_village
//master_block 
//srlm_bc_application 
//rsetis_batch_participants
//user
//
//======================================
//upsrlm data base
//master_gram_panchayat
//master_village
//master_block 
//cbo_shg
//cbo_vo
//cbo_members
//cbo_member_profile
//user
class GpController extends Controller {

    public $month3;
    public $month2;
    public $month1;

    public function beforeAction($action) {
        $this->month1 = date('Y-m-01', strtotime(date('Y-m-01') . " -1 months"));
        $this->month2 = date('Y-m-01', strtotime(date('Y-m-01') . " -2 months"));
        $this->month3 = date('Y-m-01', strtotime(date('Y-m-01') . " -3 months"));
        return parent::beforeAction($action);
    }

    public function actionGpbcreport() {
//        echo $this->month1. PHP_EOL;
//        echo $this->month2. PHP_EOL;
//        echo $this->month3. PHP_EOL;
//        exit();
        $gps = BcGramPanchayat::find()->where(['re_calculate' => 0])->limit(5000)->all();
        echo "Gp Start time : " . date('Y-m-d H:i:s') . PHP_EOL;
        $date = date('Y-m-d');
        $sbi_onboard_date = '2024-02-15';
        if ($gps != null) {
            foreach ($gps as $gp) {
                try {
                    $bc_exist = SrlmBcApplication::find()->select(['id'])->where(['status' => 2, 'gram_panchayat_code' => $gp->gram_panchayat_code, 'training_status' => [0, 1, 2, 3]])->exists();
                    if ($bc_exist) {
                        $bc_model = SrlmBcApplication::find()->where(['status' => 2, 'srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6, 'gram_panchayat_code' => $gp->gram_panchayat_code, 'training_status' => [0, 1, 2, 3]])->one();
                        $gp->selected_bc_status = 1;
                        $gp->selected_bc_round = $bc_model->selection_by;
                        $gp->selected_bc_date = \Yii::$app->formatter->asDatetime($bc_model->selection_datetime, "php:Y-m-d");
                        if ($bc_model->call_rsetis_datetime != null) {
                            $gp->select_rsethi = 1;
                            $gp->select_rsethi_date = \Yii::$app->formatter->asDatetime($bc_model->call_rsetis_datetime, "php:Y-m-d");
                            $gp->pendency_select_rsethi_days = \common\helpers\Utility::daysBetween($gp->selected_bc_date, $gp->select_rsethi_date);
                        } else {
                            $gp->select_rsethi = 0;
                            $gp->select_rsethi_date = null;
                            $gp->pendency_select_rsethi_days = \common\helpers\Utility::daysBetween($gp->selected_bc_date, $date);
                        }
                        if ($bc_model->training_status == 3) {
                            if ($bc_model->iibf_date != null and $gp->certified_date == null) {
                                $gp->certified_status = 1;
                                $gp->certified_date = \Yii::$app->formatter->asDatetime($bc_model->iibf_date, "php:Y-m-d");
                                $gp->pendency_certified_days = \common\helpers\Utility::daysBetween($gp->selected_bc_date, $gp->certified_date);
                            }
                            //IIBF Photo

                            if ($bc_model->iibf_photo_status != null and $bc_model->iibf_photo_upload_date != null) {
                                $gp->iibf_photo_status = 1;
                                $gp->iibf_photo_date = \Yii::$app->formatter->asDatetime($bc_model->iibf_photo_upload_date, "php:Y-m-d");
                                $gp->pendency_iibf_photo_days = \common\helpers\Utility::daysBetween($gp->certified_date, $gp->iibf_photo_date);
                            } else {
                                $gp->iibf_photo_status = 0;
                                $gp->iibf_photo_date = null;
                                $gp->pendency_iibf_photo_days = \common\helpers\Utility::daysBetween($gp->certified_date, $date);
                            }
                            // shg
                            if ($bc_model->cbo_shg_id != null and $bc_model->assign_shg_datetime != null) {
                                $gp->assign_shg = 1;
                                $gp->assign_shg_date = \Yii::$app->formatter->asDatetime($bc_model->assign_shg_datetime, "php:Y-m-d");
                                $gp->pendency_assign_shg_days = \common\helpers\Utility::daysBetween($gp->certified_date, $gp->assign_shg_date);
                            } else {
                                $gp->assign_shg = 0;
                                $gp->assign_shg_date = null;
                                $gp->pendency_assign_shg_days = \common\helpers\Utility::daysBetween($gp->certified_date, $date);
                            }
                            // bc bank
                            if ($bc_model->bc_bank == 2 and $bc_model->bc_bank_verify_date != null and $gp->bank_bc_date == null) {
                                $gp->bank_bc_status = 1;
                                $gp->bank_bc_date = \Yii::$app->formatter->asDatetime($bc_model->bc_bank_verify_date, "php:Y-m-d");
                                $gp->pendency_bank_bc_days = \common\helpers\Utility::daysBetween($gp->certified_date, $gp->bank_bc_date);
                            } else {
                                $gp->bank_bc_status = 0;
                                $gp->bank_bc_date = null;
                                $gp->pendency_bank_bc_days = \common\helpers\Utility::daysBetween($gp->certified_date, $date);
                            }
                            // shg bank
                            if ($bc_model->shg_bank == 2 and $bc_model->bc_shg_bank_verify_date != null) {
                                $gp->bank_shg_status = 1;
                                $gp->bank_bc_shg_date = \Yii::$app->formatter->asDatetime($bc_model->bc_shg_bank_verify_date, "php:Y-m-d");
                                $gp->pendency_bank_shg_days = \common\helpers\Utility::daysBetween($gp->certified_date, $gp->bank_bc_shg_date);
                            } else {
                                $gp->bank_shg_status = 0;
                                $gp->bank_bc_shg_date = null;
                                $gp->pendency_bank_shg_days = \common\helpers\Utility::daysBetween($gp->certified_date, $date);
                            }
                            // bc shg bank
                            if ($bc_model->bc_bank == 2 and $bc_model->shg_bank == 2 and $bc_model->bc_bank_verify_date != null and $bc_model->bc_shg_bank_verify_date != null) {
                                $gp->bank_bc_shg_status = 1;
                                $gp->bank_bc_shg_date = \Yii::$app->formatter->asDatetime($bc_model->bc_shg_bank_verify_date, "php:Y-m-d");
                                $gp->pendency_bank_bc_shg_days = \common\helpers\Utility::daysBetween($gp->certified_date, $gp->bank_bc_shg_date);
                            } else {
                                $gp->bank_bc_shg_status = 0;
                                $gp->bank_bc_shg_date = null;
                                $gp->pendency_bank_bc_shg_days = \common\helpers\Utility::daysBetween($gp->certified_date, $date);
                            }
                            // pvr
                            if ($bc_model->pvr_status == 1 and $bc_model->pvr_upload_date != null) {
                                $gp->pvr = 1;
                                $gp->pvr_date = \Yii::$app->formatter->asDatetime($bc_model->pvr_upload_date, "php:Y-m-d");
                                $gp->pendency_pvr_days = \common\helpers\Utility::daysBetween($gp->certified_date, $gp->pvr_date);
                            } else {
                                $gp->pvr = 0;
                                $gp->pvr_date = null;
                                $gp->pendency_pvr_days = \common\helpers\Utility::daysBetween($gp->certified_date, $date);
                            }
                            // shg_pfms_mapping
                            if ($bc_model->pfms_maped_status == 1 and $bc_model->beneficiaries_code_date != null) {
                                $gp->shg_pfms_mapping = 1;
                                $gp->shg_pfms_mapping_date = \Yii::$app->formatter->asDatetime($bc_model->beneficiaries_code_date, "php:Y-m-d");
                                $gp->pendency_shg_pfms_mapping_days = \common\helpers\Utility::daysBetween($gp->certified_date, $gp->shg_pfms_mapping_date);
                            } else {
                                $gp->shg_pfms_mapping = 0;
                                $gp->shg_pfms_mapping_date = null;
                                $gp->pendency_shg_pfms_mapping_days = \common\helpers\Utility::daysBetween($gp->certified_date, $date);
                            }

                            // bc_shg_support_fund
                            if ($bc_model->bc_shg_funds_status == 1 and $bc_model->bc_shg_funds_date != null) {
                                $gp->bc_shg_support_fund = 1;
                                $gp->bc_shg_support_fund_date = \Yii::$app->formatter->asDatetime($bc_model->bc_shg_funds_date, "php:Y-m-d");
                                $gp->pendency_bc_shg_support_fund_days = \common\helpers\Utility::daysBetween($gp->certified_date, $gp->bc_shg_support_fund_date);
                            } else {
                                $gp->bc_shg_support_fund = 0;
                                $gp->bc_shg_support_fund_date = null;
                                $gp->pendency_bc_shg_support_fund_days = \common\helpers\Utility::daysBetween($gp->certified_date, $date);
                            }
                            if ($gp->gp_partner_bank_id == 7) { // sbi gp
                                if ($bc_model->bc_operational == 1) {
                                    if ($bc_model->transaction_start_date < $sbi_onboard_date) {
                                        if ($bc_model->handheld_machine_status == 1 and $bc_model->bc_shg_funds_date != null and $bc_model->handheld_machine_date != null and $bc_model->handheld_machine_date >= $sbi_onboard_date) {
                                            $gp->handheld_machine = 1;
                                            $gp->handheld_machine_date = \Yii::$app->formatter->asDatetime($bc_model->handheld_machine_date, "php:Y-m-d");
                                            $gp->pendency_handheld_machine_days = \common\helpers\Utility::daysBetween($sbi_onboard_date, $gp->handheld_machine_date);
                                        } else {
                                            $gp->handheld_machine = 0;
                                            $gp->handheld_machine_date = null;
                                            $gp->pendency_handheld_machine_days = \common\helpers\Utility::daysBetween($sbi_onboard_date, $date);
                                        }
                                        // onboarding
                                        if ($bc_model->onboarding == 1 and $bc_model->onboarding_date_time != null and $bc_model->onboarding_date_time >= $sbi_onboard_date) {
                                            $gp->onboarding = 1;
                                            $gp->onboarding_date = \Yii::$app->formatter->asDatetime($bc_model->onboarding_date_time, "php:Y-m-d");
                                            $gp->pendency_onboarding_days = \common\helpers\Utility::daysBetween($sbi_onboard_date, $gp->onboarding_date);
                                        } else {
                                            $gp->onboarding = 0;
                                            $gp->onboarding_date = null;
                                            $gp->pendency_onboarding_days = \common\helpers\Utility::daysBetween($sbi_onboard_date, $date);
                                        }
                                        $bank1 = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::find()->select(['bc_application_id'])->distinct()->joinWith(['gp'])->where(['bc_transaction_bc_summary_daily.bc_application_id' => $bc_model->id])->andWhere(['bc_transaction_bc_summary_daily.master_partner_bank_id' => $gp->gp_partner_bank_id])->andWhere(['>=', 'date', $sbi_onboard_date])->count();
                                        if (isset($bank1) and $bank1) {
                                            $gp->operational = 1;
                                            $gp->operational_date = \Yii::$app->formatter->asDatetime($bc_model->transaction_start_date, "php:Y-m-d");
                                            $gp->pendency_operational_days = \common\helpers\Utility::daysBetween($sbi_onboard_date, $gp->operational_date);
                                        } else {
                                            $gp->operational = 0;
                                            $gp->operational_date = null;
                                            $gp->pendency_operational_days = \common\helpers\Utility::daysBetween($sbi_onboard_date, $date);
                                        }
                                        if ($gp->operational == 1) {
                                            $gp->total_day = $bc_model->trans->total_day;
                                            $gp->total_working_day = $bc_model->trans->total_working_day;
                                            $gp->no_of_transaction = $bc_model->trans->no_of_transaction;
                                            $gp->transaction_amount = $bc_model->trans->transaction_amount;
                                            $gp->commission_amount = $bc_model->trans->commission_amount;
                                            $gp->start_month_id = $bc_model->trans->start_month_id;
                                            $gp->last_month_id = $bc_model->trans->last_month_id;
                                            $first = \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::find()->where(['bc_application_id' => $bc_model->id, 'month_start_date' => $this->month1])->one();
                                            $second = \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::find()->where(['bc_application_id' => $bc_model->id, 'month_start_date' => $this->month2])->one();
                                            $third = \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::find()->where(['bc_application_id' => $bc_model->id, 'month_start_date' => $this->month3])->one();
                                            if ($first != null) {
                                                $gp->pre1_total_working_day = $first->total_working_day;
                                                $gp->pre1_no_of_transaction = $first->no_of_transaction;
                                                $gp->pre1_transaction_amount = $first->transaction_amount;
                                                $gp->pre1_commission_amount = $first->commission_amount;
                                            }
                                            if ($second != null) {
                                                $gp->pre2_total_working_day = $second->total_working_day;
                                                $gp->pre2_no_of_transaction = $second->no_of_transaction;
                                                $gp->pre2_transaction_amount = $second->transaction_amount;
                                                $gp->pre2_commission_amount = $second->commission_amount;
                                            }
                                            if ($third != null) {
                                                $gp->pre3_total_working_day = $third->total_working_day;
                                                $gp->pre3_no_of_transaction = $third->no_of_transaction;
                                                $gp->pre3_transaction_amount = $third->transaction_amount;
                                                $gp->pre3_commission_amount = $third->commission_amount;
                                            }
                                        }
                                    } else {
                                        if ($bc_model->handheld_machine_status == 1 and $bc_model->bc_shg_funds_date != null and $bc_model->handheld_machine_date != null) {
                                            $gp->handheld_machine = 1;
                                            $gp->handheld_machine_date = \Yii::$app->formatter->asDatetime($bc_model->handheld_machine_date, "php:Y-m-d");
                                            $gp->pendency_handheld_machine_days = \common\helpers\Utility::daysBetween($sbi_onboard_date, $gp->handheld_machine_date);
                                        } else {
                                            $gp->handheld_machine = 0;
                                            $gp->handheld_machine_date = null;
                                            $gp->pendency_handheld_machine_days = \common\helpers\Utility::daysBetween($sbi_onboard_date, $date);
                                        }
                                        // onboarding
                                        if ($bc_model->onboarding == 1 and $bc_model->onboarding_date_time != null) {
                                            $gp->onboarding = 1;
                                            $gp->onboarding_date = \Yii::$app->formatter->asDatetime($bc_model->onboarding_date_time, "php:Y-m-d");
                                            $gp->pendency_onboarding_days = \common\helpers\Utility::daysBetween($sbi_onboard_date, $gp->onboarding_date);
                                        } else {
                                            $gp->onboarding = 0;
                                            $gp->onboarding_date = null;
                                            $gp->pendency_onboarding_days = \common\helpers\Utility::daysBetween($sbi_onboard_date, $date);
                                        }
                                        $bank = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::find()->select(['bc_application_id'])->distinct()->joinWith(['gp'])->where(['bc_transaction_bc_summary_daily.bc_application_id' => $bc_model->id])->andWhere(['bc_transaction_bc_summary_daily.master_partner_bank_id' => $gp->gp_partner_bank_id])->andWhere(['>=', 'date', $sbi_onboard_date])->count();
                                        if (isset($bank) and $bank) {
                                            $gp->operational = 1;
                                            $gp->operational_date = \Yii::$app->formatter->asDatetime($bc_model->transaction_start_date, "php:Y-m-d");
                                            $gp->pendency_operational_days = \common\helpers\Utility::daysBetween($sbi_onboard_date, $gp->operational_date);
                                        } else {
                                            $gp->operational = 0;
                                            $gp->operational_date = null;
                                            $gp->pendency_operational_days = \common\helpers\Utility::daysBetween($sbi_onboard_date, $date);
                                        }
                                    }
                                    if ($gp->operational == 1) {
                                        $gp->total_day = $bc_model->trans->total_day;
                                        $gp->total_working_day = $bc_model->trans->total_working_day;
                                        $gp->no_of_transaction = $bc_model->trans->no_of_transaction;
                                        $gp->transaction_amount = $bc_model->trans->transaction_amount;
                                        $gp->commission_amount = $bc_model->trans->commission_amount;
                                        $gp->start_month_id = $bc_model->trans->start_month_id;
                                        $gp->last_month_id = $bc_model->trans->last_month_id;
                                        $first = \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::find()->where(['bc_application_id' => $bc_model->id, 'month_start_date' => $this->month1])->one();
                                        $second = \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::find()->where(['bc_application_id' => $bc_model->id, 'month_start_date' => $this->month2])->one();
                                        $third = \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::find()->where(['bc_application_id' => $bc_model->id, 'month_start_date' => $this->month3])->one();
                                        if ($first != null) {
                                            $gp->pre1_total_working_day = $first->total_working_day;
                                            $gp->pre1_no_of_transaction = $first->no_of_transaction;
                                            $gp->pre1_transaction_amount = $first->transaction_amount;
                                            $gp->pre1_commission_amount = $first->commission_amount;
                                        }
                                        if ($second != null) {
                                            $gp->pre2_total_working_day = $second->total_working_day;
                                            $gp->pre2_no_of_transaction = $second->no_of_transaction;
                                            $gp->pre2_transaction_amount = $second->transaction_amount;
                                            $gp->pre2_commission_amount = $second->commission_amount;
                                        }
                                        if ($third != null) {
                                            $gp->pre3_total_working_day = $third->total_working_day;
                                            $gp->pre3_no_of_transaction = $third->no_of_transaction;
                                            $gp->pre3_transaction_amount = $third->transaction_amount;
                                            $gp->pre3_commission_amount = $third->commission_amount;
                                        }
                                    }
                                } else {
                                    if ($bc_model->handheld_machine_status == 1 and $bc_model->bc_shg_funds_date != null and $bc_model->handheld_machine_date >= $sbi_onboard_date) {
                                        $gp->handheld_machine = 1;
                                        $gp->handheld_machine_date = \Yii::$app->formatter->asDatetime($bc_model->handheld_machine_date, "php:Y-m-d");
                                        $gp->pendency_handheld_machine_days = \common\helpers\Utility::daysBetween($sbi_onboard_date, $gp->handheld_machine_date);
                                    } else {
                                        $gp->handheld_machine = 0;
                                        $gp->handheld_machine_date = null;
                                        $gp->pendency_handheld_machine_days = \common\helpers\Utility::daysBetween($sbi_onboard_date, $date);
                                    }
                                    // onboarding
                                    if ($bc_model->onboarding == 1 and $bc_model->onboarding_date_time != null and $bc_model->onboarding_date_time >= $sbi_onboard_date) {
                                        $gp->onboarding = 1;
                                        $gp->onboarding_date = \Yii::$app->formatter->asDatetime($bc_model->onboarding_date_time, "php:Y-m-d");
                                        $gp->pendency_onboarding_days = \common\helpers\Utility::daysBetween($sbi_onboard_date, $gp->onboarding_date);
                                    } else {
                                        $gp->onboarding = 0;
                                        $gp->onboarding_date = null;
                                        $gp->pendency_onboarding_days = \common\helpers\Utility::daysBetween($sbi_onboard_date, $date);
                                    }
                                }
                            } else { // other bank gp 
                                // handheld_machine_status
                                if ($bc_model->handheld_machine_status == 1 and $bc_model->bc_shg_funds_date != null and $gp->handheld_machine_date == null) {
                                    $gp->handheld_machine = 1;
                                    $gp->handheld_machine_date = \Yii::$app->formatter->asDatetime($bc_model->handheld_machine_date, "php:Y-m-d");
                                    $gp->pendency_handheld_machine_days = \common\helpers\Utility::daysBetween($gp->certified_date, $gp->handheld_machine_date);
                                } else {
                                    $gp->handheld_machine_date = null;
                                    $gp->handheld_machine = 0;
                                    $gp->pendency_handheld_machine_days = \common\helpers\Utility::daysBetween($gp->certified_date, $date);
                                }
                                // onboarding
                                if ($bc_model->onboarding == 1 and $bc_model->onboarding_date_time != null and $gp->onboarding_date == null) {
                                    $gp->onboarding = 1;
                                    $gp->onboarding_date = \Yii::$app->formatter->asDatetime($bc_model->onboarding_date_time, "php:Y-m-d");
                                    $gp->pendency_onboarding_days = \common\helpers\Utility::daysBetween($gp->certified_date, $gp->onboarding_date);
                                } else {
                                    $gp->onboarding = 0;
                                    $gp->onboarding_date = null;
                                    $gp->pendency_onboarding_days = \common\helpers\Utility::daysBetween($gp->certified_date, $date);
                                }
                                // operational
                                if ($bc_model->bc_operational == 1 and $bc_model->transaction_start_date != null) {
                                    $gp->operational = 1;
                                    $gp->operational_date = \Yii::$app->formatter->asDatetime($bc_model->transaction_start_date, "php:Y-m-d");
                                    $gp->pendency_operational_days = \common\helpers\Utility::daysBetween($gp->certified_date, $gp->operational_date);
                                    if (isset($bc_model->trans->total_day)) {
                                        $gp->total_day = $bc_model->trans->total_day;
                                        $gp->total_working_day = $bc_model->trans->total_working_day;
                                        $gp->no_of_transaction = $bc_model->trans->no_of_transaction;
                                        $gp->transaction_amount = $bc_model->trans->transaction_amount;
                                        $gp->commission_amount = $bc_model->trans->commission_amount;
                                        $gp->start_month_id = $bc_model->trans->start_month_id;
                                        $gp->last_month_id = $bc_model->trans->last_month_id;
                                        $first = \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::find()->where(['bc_application_id' => $bc_model->id, 'month_start_date' => $this->month1])->one();
                                        $second = \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::find()->where(['bc_application_id' => $bc_model->id, 'month_start_date' => $this->month2])->one();
                                        $third = \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::find()->where(['bc_application_id' => $bc_model->id, 'month_start_date' => $this->month3])->one();
                                        if ($first != null) {
                                            $gp->pre1_total_working_day = $first->total_working_day;
                                            $gp->pre1_no_of_transaction = $first->no_of_transaction;
                                            $gp->pre1_transaction_amount = $first->transaction_amount;
                                            $gp->pre1_commission_amount = $first->commission_amount;
                                        }
                                        if ($second != null) {
                                            $gp->pre2_total_working_day = $second->total_working_day;
                                            $gp->pre2_no_of_transaction = $second->no_of_transaction;
                                            $gp->pre2_transaction_amount = $second->transaction_amount;
                                            $gp->pre2_commission_amount = $second->commission_amount;
                                        }
                                        if ($third != null) {
                                            $gp->pre3_total_working_day = $third->total_working_day;
                                            $gp->pre3_no_of_transaction = $third->no_of_transaction;
                                            $gp->pre3_transaction_amount = $third->transaction_amount;
                                            $gp->pre3_commission_amount = $third->commission_amount;
                                        }
                                    }
                                } else {
                                    $gp->operational = 0;
                                    $gp->operational_date = null;
                                    $gp->pendency_operational_days = \common\helpers\Utility::daysBetween($gp->certified_date, $date);
                                }
                            }

                            // bc_settlement_ac_194n
                            if ($bc_model->bc_settlement_ac_194n == 1 and $bc_model->bc_settlement_ac_194n_date != null and $gp->operational_date == null) {
                                $gp->bc_settlement_ac_194n = 1;
                                $gp->bc_settlement_ac_194n_date = \Yii::$app->formatter->asDatetime($bc_model->bc_settlement_ac_194n_date, "php:Y-m-d");
                                $gp->pendency_bc_settlement_ac_194n_days = \common\helpers\Utility::daysBetween($gp->certified_date, $gp->bc_settlement_ac_194n_date);
                            } else {
                                $gp->bc_settlement_ac_194n = 0;
                                $gp->bc_settlement_ac_194n_date = null;
                                $gp->pendency_bc_settlement_ac_194n_days = \common\helpers\Utility::daysBetween($gp->certified_date, $date);
                            }
                        } else {
                            $gp->pendency_certified_days = \common\helpers\Utility::daysBetween($gp->selected_bc_date, $date);
                        }
                        $gp->c_bc_id = $bc_model->id;
                        $gp->c_bc_name = $bc_model->name;
                        $gp->bc_blocked = $bc_model->blocked;
                        $gp->c_partner_bank_id = $bc_model->master_partner_bank_id;
                        $gp->c_no_selection = SrlmBcApplication::find()->select(['id'])->where(['status' => 2, 'srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6, 'gram_panchayat_code' => $gp->gram_panchayat_code, 'training_status' => [0, 1, 2, 3]])->count();
                        $gp->bc_status = $bc_model->training_status;
                        $gp->gp_status = $bc_model->training_status;
                    } else {
                        $gp->gp_available_application = SrlmBcApplication::find()->select(['id'])->where(['status' => 1, 'gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->count();
                        $gp->selected_bc_status = 0;
                        $gp->selected_bc_round = 0;
                        $gp->selected_bc_date = null;
                        $gp->select_rsethi = 0;
                        $gp->select_rsethi_date = null;
                        $gp->pendency_select_rsethi_days = 0;
                        $gp->certified_status = 0;
                        $gp->certified_date = null;
                        $gp->pendency_certified_days = 0;
                        $gp->iibf_photo_status = 0;
                        $gp->iibf_photo_date = null;
                        $gp->pendency_iibf_photo_days = 0;
                        $gp->assign_shg = 0;
                        $gp->assign_shg_date = null;
                        $gp->pendency_assign_shg_days = 0;
                        $gp->bank_bc_status = 0;
                        $gp->bank_shg_status = 0;
                        $gp->bank_bc_date = null;
                        $gp->bank_shg_date = null;
                        $gp->pendency_bank_bc_days = 0;
                        $gp->pendency_bank_shg_days = 0;
                        $gp->bank_bc_shg_status = 0;
                        $gp->bank_bc_shg_date = null;
                        $gp->pendency_bank_bc_shg_days = 0;
                        $gp->pvr = 0;
                        $gp->pvr_date = null;
                        $gp->pendency_pvr_days = 0;
                        $gp->shg_pfms_mapping = 0;
                        $gp->shg_pfms_mapping_date = null;
                        $gp->pendency_shg_pfms_mapping_days = 0;
                        $gp->bc_shg_support_fund = 0;
                        $gp->bc_shg_support_fund_date = null;
                        $gp->pendency_bc_shg_support_fund_days = 0;
                        $gp->handheld_machine = 0;
                        $gp->handheld_machine_date = null;
                        $gp->pendency_handheld_machine_days = 0;
                        $gp->onboarding = 0;
                        $gp->onboarding_date = null;
                        $gp->operational = 0;
                        $gp->operational_date = null;
                        $gp->pendency_operational_days = 0;
                        $gp->bc_settlement_ac_194n = 0;
                        $gp->bc_settlement_ac_194n_date = null;
                        $gp->pendency_bc_settlement_ac_194n_days = 0;
                        $gp->c_bc_id = null;
                        $gp->c_bc_name = null;
                        $gp->bc_blocked = 0;
                        $gp->c_partner_bank_id = $gp->gp_partner_bank_id;
                        $gp->c_no_selection = 0;
                        if ($gp->gp_available_application) {
                            $gp->bc_status = 10;
                            $gp->gp_status = 10;
                        } else {
                            $gp->bc_status = 11;
                            $gp->gp_status = 11;
                        }
                    }
                    $gp->re_calculate = 1;
                    $gp->save();
                } catch (\Exception $exc) {
                    echo 'Message :' . $exc->getMessage() . PHP_EOL;
                    echo 'line :' . $exc->getLine() . PHP_EOL;
                    echo 'gp :' . $gp->gram_panchayat_code . PHP_EOL;
                }
            }
        }

        echo "Gp End time : " . date('Y-m-d H:i:s') . PHP_EOL;
    }

    public function actionGpbcshort() {
        $gps = BcGramPanchayat::find()->all();
        echo "Gp Start time : " . date('Y-m-d H:i:s') . PHP_EOL;
        $date = date('Y-m-d');
        if ($gps != null) {
            foreach ($gps as $gp) {
                $gp->bc_shortlist = SrlmBcApplication::find()->select(['id'])->where(['status' => 2, 'gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->count();
                $gp->save();
            }
        }
        echo "Gp End time : " . date('Y-m-d H:i:s') . PHP_EOL;
    }

//    public function actionChangeblock() {
//        $gps = \bc\models\master\MasterGramPanchayat::find()->where(['doubt_block' => 1, 'gp_covert_urban' => 0, 'new_status' => 1])->all();
//        foreach ($gps as $model) {
//            $block = \bc\models\master\MasterBlock::findOne(['new_block_code' => $model->new_block_code]);
//            if ($block != null) {
//                $block_code = $block->block_code;
//                $block_name = $block->block_name;
//                $condition1 = ['and',
//                    ['=', 'gram_panchayat_code', $model->gram_panchayat_code],
//                ];
//                // bc_selection data base start
//                \bc\models\master\MasterGramPanchayat::updateAll([
//                    'block_code' => $block_code,
//                    'block_name' => $block_name,
//                        ], $condition1);
//
//                \bc\models\master\MasterVillage::updateAll([
//                    'block_code' => $block_code,
//                    'block_name' => $block_name,
//                        ], $condition1);
//                SrlmBcApplication::updateAll([
//                    'block_code' => $block_code,
//                    'block_name' => $block_name,
//                        ], $condition1);
//                \bc\modules\training\models\RsetisBatchParticipants::updateAll([
//                    'block_code' => $block_code,
//                    'block_name' => $block_name,
//                        ], $condition1);
//                // end bc_selection
//                // upsrlm data base start
//                \common\models\dynamicdb\bc\RelationUserGramPanchayat::updateAll([
//                    'block_code' => $block_code,
//                        ], $condition1);
//                \common\models\master\MasterGramPanchayat::updateAll([
//                    'block_code' => $block_code,
//                    'block_name' => $block_name,
//                        ], $condition1);
//                Shg::updateAll([
//                    'block_code' => $block_code,
//                    'block_name' => $block_name,
//                        ], $condition1);
//                CboVo::updateAll([
//                    'block_code' => $block_code,
//                    'block_name' => $block_name,
//                        ], $condition1);
//                \common\models\CboMemberProfile::updateAll([
//                    'block_code' => $block_code,
//                    'block_name' => $block_name,
//                        ], $condition1);
//                \common\models\RelationUserGramPanchayat::updateAll([
//                    'block_code' => $block_code,
//                        ], $condition1);
//                // end upsrlm data base
//            }
//        }
//    }
//    public function actionVillage() {
//        $models = \bc\models\master\MasterVillage::find()->where(['block_code' => 0])->andWhere(['!=', 'gram_panchayat_code', 0])->all();
//        foreach ($models as $model) {
//            $condition1 = ['and',
//                ['=', 'village_code', $model->village_code],
//            ];
//            $gp_model = \bc\models\master\MasterGramPanchayat::findOne(['gram_panchayat_code' => $model->gram_panchayat_code]);
//            if ($gp_model != null) {
//                if ($gp_model->block_code) {
//                    $block_code = $gp_model->block_code;
//                    $block_name = $gp_model->block_name;
//                    \bc\models\master\MasterVillage::updateAll([
//                        'block_code' => $block_code,
//                        'block_name' => $block_name,
//                            ], $condition1);
//                    \common\models\master\MasterVillage::updateAll([
//                        'block_code' => $block_code,
//                        'block_name' => $block_name,
//                            ], $condition1);
//                }
//            }
//        }
//
//        return ExitCode::OK;
//    }
//    public function actionNewgpvillage() {
//        $new_gps = \bc\models\master\MasterGramPanchayat::find()->Where(['new' => 1, 'gp_covert_urban' => 0, 'status' => 1])->all();
//        foreach ($new_gps as $new_gp) {
//            $block = \bc\models\master\MasterBlock::findOne(['new_block_code' => $new_gp->new_block_code]);
//            $new_gpup = \common\models\master\MasterGramPanchayat::findOne(['gram_panchayat_code' => $new_gp->gram_panchayat_code]);
//            if ($block != null) {
//                if ($new_gp->save()) {
//                    $max = \bc\models\master\MasterVillage::find()->max('village_code');
//                    $vill_modelbc = new \bc\models\master\MasterVillage();
//                    $vill_modelbc->state_code = $new_gp->state_code;
//                    $vill_modelbc->state_name = $new_gp->state_name;
//                    $vill_modelbc->division_code = $new_gp->division_code;
//                    $vill_modelbc->division_name = $new_gp->division_name;
//                    $vill_modelbc->district_code = $new_gp->district_code;
//                    $vill_modelbc->district_name = $new_gp->district_name;
//                    $vill_modelbc->sub_district_code = $new_gp->sub_district_code;
//                    $vill_modelbc->sub_district_name = $new_gp->sub_district_name;
//                    $vill_modelbc->block_code = $new_gp->block_code;
//                    $vill_modelbc->block_name = $new_gp->block_name;
//                    $vill_modelbc->village_code = ($max + 1);
//                    $vill_modelbc->village_name = $new_gp->gram_panchayat_name;
//                    $vill_modelbc->gram_panchayat_code = $new_gp->gram_panchayat_code;
//                    $vill_modelbc->gram_panchayat_name = $new_gp->gram_panchayat_name;
//                    $vill_modelbc->status = 1;
//
//                    $vill_modelup = new \common\models\master\MasterVillage();
//                    $vill_modelup->state_code = $new_gp->state_code;
//                    $vill_modelup->state_name = $new_gp->state_name;
//                    $vill_modelup->division_code = $new_gp->division_code;
//                    $vill_modelup->division_name = $new_gp->division_name;
//                    $vill_modelup->district_code = $new_gp->district_code;
//                    $vill_modelup->district_name = $new_gp->district_name;
//                    $vill_modelup->sub_district_code = $new_gp->sub_district_code;
//                    $vill_modelup->sub_district_name = $new_gp->sub_district_name;
//                    $vill_modelup->block_code = $new_gp->block_code;
//                    $vill_modelup->block_name = $new_gp->block_name;
//                    $vill_modelup->village_code = ($max + 1);
//                    $vill_modelup->village_name = $new_gp->gram_panchayat_name;
//                    $vill_modelup->gram_panchayat_code = $new_gp->gram_panchayat_code;
//                    $vill_modelup->gram_panchayat_name = $new_gp->gram_panchayat_name;
//                    $vill_modelup->status = 1;
//                    if ($vill_modelbc->save() and $vill_modelup->save()) {
//                        $new_gp->village_count = 1;
//                        $new_gp->update();
//                        $new_gpup->village_count = 1;
//                        $new_gpup->update();
//                    }
//                }
//            }
//        }
//    }
//    public function actionVillageurban() {
//        $models = \bc\models\master\MasterGramPanchayat::find()->where(['gp_covert_urban' => 1])->all();
//        foreach ($models as $model) {
//            $condition1 = ['and',
//                ['=', 'gram_panchayat_code', $model->gram_panchayat_code],
//            ];
//
//            \bc\models\master\MasterVillage::updateAll([
//                'urban' => 1,
//                    ], $condition1);
//            \common\models\master\MasterVillage::updateAll([
//                'urban' => 1,
//                    ], $condition1);
//        }
//
//        return ExitCode::OK;
//    }

    public function actionDistrict() {
        $models = \bc\models\master\MasterDistrict::find()->all();
        foreach ($models as $model) {
            $condition1 = ['and',
                ['=', 'district_code', $model->district_code],
            ];
            $block_count = \bc\models\master\MasterBlock::find()->where(['district_code' => $model->district_code, 'status' => 1])->count();
            $gram_panchayat_count = \bc\models\master\MasterGramPanchayat::find()->where(['district_code' => $model->district_code, 'status' => 1])->count();
            $village_count = \bc\models\master\MasterVillage::find()->where(['district_code' => $model->district_code, 'status' => 1])->count();
            $bc_selection_application_receive = SrlmBcApplication::find()->where(['district_code' => $model->district_code])->andWhere(['!=', 'srlm_bc_application.status', 0])->andWhere(['!=', 'srlm_bc_application.status', -1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->andWhere(['urban_shg' => 0])->count();
            $bc_selection_sc_st_application_receive = SrlmBcApplication::find()->where(['district_code' => $model->district_code])->andWhere(['!=', 'srlm_bc_application.status', 0])->andWhere(['!=', 'srlm_bc_application.status', -1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6, 'srlm_bc_application.cast' => 1])->andWhere(['urban_shg' => 0])->count();
            $bc_selection_obc_application_receive = SrlmBcApplication::find()->where(['district_code' => $model->district_code])->andWhere(['!=', 'srlm_bc_application.status', 0])->andWhere(['!=', 'srlm_bc_application.status', -1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6, 'srlm_bc_application.cast' => 2])->andWhere(['urban_shg' => 0])->count();
            $bc_selection_general_application_receive = SrlmBcApplication::find()->where(['district_code' => $model->district_code])->andWhere(['!=', 'srlm_bc_application.status', 0])->andWhere(['!=', 'srlm_bc_application.status', -1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6, 'srlm_bc_application.cast' => 3])->andWhere(['urban_shg' => 0])->count();
            $group_member = SrlmBcApplication::find()->where(['district_code' => $model->district_code])->andWhere(['!=', 'srlm_bc_application.status', 0])->andWhere(['!=', 'srlm_bc_application.status', -1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6, 'already_group_member' => ArrayHelper::getColumn(\bc\modules\selection\models\master\BcApplicationMasterAlreadyGroupMember::find()->where(['!=', 'id', 1])->all(), 'id')])->andWhere(['urban_shg' => 0])->count();
            \bc\models\master\MasterDistrict::updateAll([
                'block_count' => $block_count,
                'gram_panchayat_count' => $gram_panchayat_count,
                'village_count' => $village_count,
                'bc_selection_application_receive' => $bc_selection_application_receive,
                'bc_selection_sc_st_application_receive' => $bc_selection_sc_st_application_receive,
                'bc_selection_obc_application_receive' => $bc_selection_obc_application_receive,
                'bc_selection_general_application_receive' => $bc_selection_general_application_receive,
                'group_member' => $group_member,
                    ], $condition1);
            \bc\modules\training\models\RsetisCenter::updateAll([
                'total_gp' => $gram_panchayat_count,
                    ], $condition1);
            \common\models\master\MasterDistrict::updateAll([
                'block_count' => $block_count,
                'gram_panchayat_count' => $gram_panchayat_count,
                'village_count' => $village_count,
                'bc_selection_application_receive' => $bc_selection_application_receive,
                'bc_selection_sc_st_application_receive' => $bc_selection_sc_st_application_receive,
                'bc_selection_obc_application_receive' => $bc_selection_obc_application_receive,
                'bc_selection_general_application_receive' => $bc_selection_general_application_receive,
                'group_member' => $group_member,
                    ], $condition1);
        }

        return ExitCode::OK;
    }

//    public function actionVc() {
//        $models = \bc\models\master\MasterGramPanchayat::find()->all();
//        foreach ($models as $model) {
//            $condition1 = ['and',
//                ['=', 'gram_panchayat_code', $model->gram_panchayat_code],
//            ];
//
//            $bc_selection_application_receive = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code])->andWhere(['!=', 'srlm_bc_application.status', 0])->andWhere(['!=', 'srlm_bc_application.status', -1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->count();
//
//            \bc\models\master\MasterGramPanchayat::updateAll([
//                'bc_selection_application_receive' => $bc_selection_application_receive,
//                    ], $condition1);
//
//            \common\models\master\MasterGramPanchayat::updateAll([
//                'bc_selection_application_receive' => $bc_selection_application_receive,
//                    ], $condition1);
//        }
//
//        return ExitCode::OK;
//    }
//    public function actionBlock() {
//        $models = \bc\models\master\MasterBlock::find()->all();
//        foreach ($models as $model) {
//            $condition1 = ['and',
//                ['=', 'block_code', $model->block_code],
//            ];
//            $gram_panchayat_count = \bc\models\master\MasterGramPanchayat::find()->where(['block_code' => $model->block_code, 'status' => 1])->count();
//            $village_count = \bc\models\master\MasterVillage::find()->where(['block_code' => $model->block_code, 'status' => 1])->count();
//            $bc_selection_application_receive = SrlmBcApplication::find()->where(['block_code' => $model->block_code])->andWhere(['!=', 'srlm_bc_application.status', 0])->andWhere(['!=', 'srlm_bc_application.status', -1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->andWhere(['urban_shg' => 0])->count();
//            $bc_selection_sc_st_application_receive = SrlmBcApplication::find()->where(['block_code' => $model->block_code])->andWhere(['!=', 'srlm_bc_application.status', 0])->andWhere(['!=', 'srlm_bc_application.status', -1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6, 'srlm_bc_application.cast' => 1])->andWhere(['urban_shg' => 0])->count();
//            $bc_selection_obc_application_receive = SrlmBcApplication::find()->where(['block_code' => $model->block_code])->andWhere(['!=', 'srlm_bc_application.status', 0])->andWhere(['!=', 'srlm_bc_application.status', -1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6, 'srlm_bc_application.cast' => 2])->andWhere(['urban_shg' => 0])->count();
//            $bc_selection_general_application_receive = SrlmBcApplication::find()->where(['block_code' => $model->block_code])->andWhere(['!=', 'srlm_bc_application.status', 0])->andWhere(['!=', 'srlm_bc_application.status', -1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6, 'srlm_bc_application.cast' => 3])->andWhere(['urban_shg' => 0])->count();
//            $group_member = SrlmBcApplication::find()->where(['block_code' => $model->block_code])->andWhere(['!=', 'srlm_bc_application.status', 0])->andWhere(['!=', 'srlm_bc_application.status', -1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6, 'already_group_member' => ArrayHelper::getColumn(\bc\modules\selection\models\master\BcApplicationMasterAlreadyGroupMember::find()->where(['!=', 'id', 1])->all(), 'id')])->andWhere(['urban_shg' => 0])->count();
//            \bc\models\master\MasterBlock::updateAll([
//                'gram_panchayat_count' => $gram_panchayat_count,
//                'village_count' => $village_count,
//                'bc_selection_application_receive' => $bc_selection_application_receive,
//                'bc_selection_sc_st_application_receive' => $bc_selection_sc_st_application_receive,
//                'bc_selection_obc_application_receive' => $bc_selection_obc_application_receive,
//                'bc_selection_general_application_receive' => $bc_selection_general_application_receive,
//                'group_member' => $group_member,
//                    ], $condition1);
//            \common\models\master\MasterBlock::updateAll([
//                'gram_panchayat_count' => $gram_panchayat_count,
//                'village_count' => $village_count,
//                'bc_selection_application_receive' => $bc_selection_application_receive,
//                'bc_selection_sc_st_application_receive' => $bc_selection_sc_st_application_receive,
//                'bc_selection_obc_application_receive' => $bc_selection_obc_application_receive,
//                'bc_selection_general_application_receive' => $bc_selection_general_application_receive,
//                'group_member' => $group_member,
//                    ], $condition1);
//        }
//
//        return ExitCode::OK;
//    }

    static function cmp_overall($a, $b) {
        $al = $a->over_all;
        $bl = $b->over_all;
        // echo "\n" . $al . " " . $bl . "\n";
        if ($al == $bl) {
            return 0;
        }
        return ($al < $bl) ? +1 : -1;
    }

//    public function actionGpbcpostvacant() {
//
//        $vacant_gps_bc = SrlmBcApplication::find()->where(['training_status' => [SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_UNWILLING, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE]])->andWhere(['gender' => 2, 'form_number' => 6, 'status' => 2])->andWhere(['urban_shg' => 0, 'replaced' => 0])->OrWhere(['srlm_bc_application.blocked' => 6])->all();
//        foreach ($vacant_gps_bc as $vacant_gp_bc) {
//            $vacant_gp_bc->replaced = 1;
//            $gp = \bc\models\master\MasterGramPanchayat::findOne(['gram_panchayat_code' => $vacant_gp_bc->gram_panchayat_code]);
//            $gp->gp_post_vacant = 1;
//            $vacant_gp_bc->save();
//            $gp->save();
//        }
//
//        $this->lot2();
//    }
//    public function lot2() {
//        $standby1 = \bc\models\master\MasterGramPanchayat::find()->andWhere(['NOT', ['standby1_id' => null]])->all();
//        if ($standby1 == null) {
//            $vacant_gps = \bc\models\master\MasterGramPanchayat::find()->where(['gp_post_vacant' => 1])->all();
//            foreach ($vacant_gps as $vacant_gp) {
//                $gp = \bc\models\master\MasterGramPanchayat::findOne(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code]);
//
//                $new_bc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1, 'status_new' => 2])->one();
//
//                if ($new_bc != null) {
//                    $gp->standby1_id = $new_bc->id;
//                    $gp->gp_post_vacant = 0;
//                    $gp->save();
//                    $new_bc->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                    $new_bc->selection_by = 2;
//                    $new_bc->selection_datetime = new \yii\db\Expression('NOW()');
//                    $new_bc->save();
//                } else {
//                    $bc_models = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1])->all();
//                    if (count($bc_models)) {
//                        if (count($bc_models) == 1) {
//                            $gp->standby1_id = $bc_models[0]->id;
//                            $gp->gp_post_vacant = 0;
//                            $gp->save();
//                            $standby1_model = $bc_models[0];
//                            $standby1_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                            $standby1_model->selection_by = 2;
//                            $standby1_model->selection_datetime = new \yii\db\Expression('NOW()');
//                            $standby1_model->save();
//                        } else {
//                            $chairperson = [];
//                            $samuhsakhi = [];
//                            $shgmember = [];
//                            $nomemeber = [];
//                            foreach ($bc_models as $model) {
//                                if ($model->already_group_member == "2")
//                                    array_push($chairperson, $model);
//                                else if ($model->already_group_member == "7")
//                                    array_push($samuhsakhi, $model);
//                                else if ($model->already_group_member == "1")
//                                    array_push($nomemeber, $model);
//                                else
//                                    array_push($shgmember, $model);
//                            }
//                            usort($chairperson, array($this, "cmp_overall"));
//                            usort($samuhsakhi, array($this, "cmp_overall"));
//                            usort($shgmember, array($this, "cmp_overall"));
//                            usort($nomemeber, array($this, "cmp_overall"));
//                            if (count($chairperson) > 0) {
//                                $standby1_model = $chairperson[0];
//                            } else if (count($samuhsakhi) > 0) {
//                                $standby1_model = $samuhsakhi[0];
//                            } else if (count($shgmember) > 0) {
//                                $standby1_model = $shgmember[0];
//                            } else if (count($nomemeber) > 0) {
//                                $standby1_model = $nomemeber[0];
//                            }
//                            if ($standby1_model != null) {
//                                $gp->standby1_id = $standby1_model->id;
//                                $gp->gp_post_vacant = 0;
//                                $gp->save();
//                                $standby1_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                                $standby1_model->selection_by = 2;
//                                $standby1_model->selection_datetime = new \yii\db\Expression('NOW()');
//                                $standby1_model->save();
//                            }
//                        }
//                    }
//                }
//            }
//        }
//    }

    public function actionStatusnew() {

        $sql = "  SELECT * FROM `srlm_bc_application` WHERE `status_new` = 2 AND `status` = 1 ";

        $models = SrlmBcApplication::findBySql($sql)->all();
        foreach ($models as $m) {
            //print_r($m);
            $sql1 = "select * from `srlm_bc_application` WHERE `gram_panchayat_code` = '" . $m['gram_panchayat_code'] . "' AND `status_new` = 1  AND `status` = 2";

            //$sql1 ="  SELECT * FROM `srlm_bc_application` WHERE `status_new` = 2 AND `status` = 1 ";

            $models1 = SrlmBcApplication::findBySql($sql1)->all();
            if (count($models1) > 1)
                echo $m['gram_panchayat_code'] . "-" . count($models1) . " ";
        }
    }

//    public function actionVacant15dec() {
//        $query = SrlmBcApplication::find();
//        $query->andWhere(['=', 'form_number', '6']);
//        $query->andWhere(['=', 'gender', '2']);
//        $query->andWhere(['=', 'urban_shg', '0']);
//        $query->andWhere(['=', 'replaced', '0']);
//        $query->andWhere(['training_status' => [SrlmBcApplication::TRAINING_STATUS_UNWILLING, SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE]]);
//        $query->andWhere(['srlm_bc_application.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
//        $models = $query->all();
//        foreach ($models as $model) {
//            $bc_stand_by = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->andWhere(['urban_shg' => 0])->count();
//
//            if ($bc_stand_by == '0') {
//                $condition1 = ['and',
//                    ['=', 'gram_panchayat_code', $model->gram_panchayat_code],
//                ];
//                \bc\models\master\MasterGramPanchayat::updateAll([
//                    'vacant_15dec' => 1,
//                        ], $condition1);
//            }
//        }
//        $gpmodels = \bc\models\master\MasterGramPanchayat::find()->where(['status' => 1, 'second_vacant' => 1])->all();
//        foreach ($gpmodels as $gmodel) {
//            if ($gmodel->second_complete == '0') {
//                $condition2 = ['and',
//                    ['=', 'gram_panchayat_code', $gmodel->gram_panchayat_code],
//                ];
//                \bc\models\master\MasterGramPanchayat::updateAll([
//                    'vacant_15dec' => 1,
//                        ], $condition2);
//            }
//        }
//    }
//    public function actionVacant27dec() {
//        $query = SrlmBcApplication::find();
//        $query->andWhere(['=', 'form_number', '6']);
//        $query->andWhere(['=', 'gender', '2']);
//        $query->andWhere(['=', 'urban_shg', '0']);
//        $query->andWhere(['=', 'replaced', '0']);
//        $query->andWhere(['training_status' => [SrlmBcApplication::TRAINING_STATUS_UNWILLING, SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE]]);
//        $query->andWhere(['srlm_bc_application.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
//        $models = $query->all();
//        foreach ($models as $model) {
//            $bc_stand_by = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->andWhere(['urban_shg' => 0])->count();
//
//            if ($bc_stand_by == '0') {
//                $condition1 = ['and',
//                    ['=', 'gram_panchayat_code', $model->gram_panchayat_code],
//                ];
//                \bc\models\master\MasterGramPanchayat::updateAll([
//                    'vacant_27dec' => 1,
//                        ], $condition1);
//            }
//        }
//        $gpmodels = \bc\models\master\MasterGramPanchayat::find()->where(['status' => 1, 'second_vacant' => 1])->all();
//        foreach ($gpmodels as $gmodel) {
//            if ($gmodel->second_complete == '0') {
//                $condition2 = ['and',
//                    ['=', 'gram_panchayat_code', $gmodel->gram_panchayat_code],
//                ];
//                \bc\models\master\MasterGramPanchayat::updateAll([
//                    'vacant_27dec' => 1,
//                        ], $condition2);
//            }
//        }
//    }
//    public function actionGpbcpostvacant28() {
//
//        $vacant_gps_bc = SrlmBcApplication::find()->where(['training_status' => [SrlmBcApplication::TRAINING_STATUS_UNWILLING, SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE]])->andWhere(['gender' => 2, 'form_number' => 6, 'status' => 2])->andWhere(['urban_shg' => 0, 'replaced' => 0])->all();
//        foreach ($vacant_gps_bc as $vacant_gp_bc) {
//            $vacant_gp_bc->replaced = 1;
//            $gp = \bc\models\master\MasterGramPanchayat::findOne(['gram_panchayat_code' => $vacant_gp_bc->gram_panchayat_code]);
//            $gp->gp_post_vacant = 1;
//            $vacant_gp_bc->save();
//            $gp->save();
//        }
//
////        $this->lot3();
//    }
//    public function actionLot3() {
//        $standby2 = \bc\models\master\MasterGramPanchayat::find()->andWhere(['NOT', ['standby2_id' => null]])->all();
//        if ($standby2 == null) {
//            $vacant_gps = \bc\models\master\MasterGramPanchayat::find()->where(['second_vacant' => 1])->all();
//            foreach ($vacant_gps as $vacant_gp) {
//                $gp = \bc\models\master\MasterGramPanchayat::findOne(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code]);
//                $bc_models = SrlmBcApplication2::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1])->all();
//                if (count($bc_models)) {
//                    if (count($bc_models) == 1) {
//                        $gp->standby2_id = $bc_models[0]->new_id;
//                        $gp->save();
//                        $standby2_model = $bc_models[0];
//                        $standby2_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                        $standby2_model->selection_by = 3;
//                        $standby2_model->selection_datetime = new \yii\db\Expression('NOW()');
//                        $standby2_model->save();
//                    } else {
//                        $chairperson = [];
//                        $samuhsakhi = [];
//                        $shgmember = [];
//                        $nomemeber = [];
//                        foreach ($bc_models as $model) {
//                            if ($model->already_group_member == "2")
//                                array_push($chairperson, $model);
//                            else if ($model->already_group_member == "7")
//                                array_push($samuhsakhi, $model);
//                            else if ($model->already_group_member == "1")
//                                array_push($nomemeber, $model);
//                            else
//                                array_push($shgmember, $model);
//                        }
//                        usort($chairperson, array($this, "cmp_overall"));
//                        usort($samuhsakhi, array($this, "cmp_overall"));
//                        usort($shgmember, array($this, "cmp_overall"));
//                        usort($nomemeber, array($this, "cmp_overall"));
//                        if (count($chairperson) > 0) {
//                            $standby2_model = $chairperson[0];
//                        } else if (count($samuhsakhi) > 0) {
//                            $standby2_model = $samuhsakhi[0];
//                        } else if (count($shgmember) > 0) {
//                            $standby2_model = $shgmember[0];
//                        } else if (count($nomemeber) > 0) {
//                            $standby2_model = $nomemeber[0];
//                        }
//                        if ($standby2_model != null) {
//                            $gp->standby2_id = $standby2_model->new_id;
//                            $gp->save();
//                            $standby2_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                            $standby2_model->selection_by = 3;
//                            $standby2_model->selection_datetime = new \yii\db\Expression('NOW()');
//                            $standby2_model->save();
//                        }
//                    }
//                }
//            }
//        }
//    }
//    public function actionRearange() {
//        
//    }

     public function actionRearange() {
      echo "Gp start time : " . date('Y-m-d H:i:s') . PHP_EOL;
      $models = \bc\models\master\MasterGramPanchayat::find()->all();
      foreach ($models as $model) {
      // if($model->gram_panchayat_code=="85352"){
      $condition1 = ['and',
      ['=', 'gram_panchayat_code', $model->gram_panchayat_code],
      ];
      $bc_selection_application_receive = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code])->andWhere(['!=', 'srlm_bc_application.status', 0])->andWhere(['!=', 'srlm_bc_application.status', -1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->count();
      $current_available = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->count();
      //$current_available2 = SrlmBcApplication2::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code])->andWhere(['srlm_bc_application2.status' => [1]])->andWhere(['srlm_bc_application2.gender' => 2, 'srlm_bc_application2.form_number' => 6])->count();
      $current_available5 = \bc\modules\selection\models\SrlmBcApplication5::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code])->andWhere(['srlm_bc_application5.status' => [1, 2]])->andWhere(['srlm_bc_application5.gender' => 2, 'srlm_bc_application5.form_number' => 6])->count();
      $first_roundbc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'selection_by' => 1])->one();
      //            print_r($first_roundbc);
      $second_roundbc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'selection_by' => 2])->one();
      $third_roundbc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'selection_by' => 3])->one();
      $fourth_roundbc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'selection_by' => 4])->one();
      $fifth_roundbc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'selection_by' => 5])->one();
      $sixth_roundbc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'selection_by' => 6])->one();
      $seventh_roundbc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'selection_by' => 7])->one();
      $eighth_roundbc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'selection_by' => 8])->one();
      $ninth_roundbc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'selection_by' => 9])->one();
      $tenth_roundbc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'selection_by' => 10])->one();
      $eleventh_roundbc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'selection_by' => 11])->one();
      $twelth_roundbc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'selection_by' => 12])->one();
      $thirteen_roundbc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'selection_by' => 13])->one();
      $fourteen_roundbc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'selection_by' => 14])->one();
      $fifteen_roundbc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'selection_by' => 15])->one();
      $first_roundbc_status = -100;
      $second_roundbc_status = -100;
      $third_roundbc_status = -100;
      $fourth_roundbc_status = -100;
      $fifth_roundbc_status = -100;
      $sixth_roundbc_status = -100;
      $seventh_roundbc_status = -100;
      $eighth_roundbc_status = -100;
      $ninth_roundbc_status = -100;
      $tenth_roundbc_status = -100;
      $eleventh_roundbc_status = -100;
      $twelth_roundbc_status = -100;
      $thirteen_roundbc_status = -100;
      $fourteen_roundbc_status = -100;
      $fifteen_roundbc_status = -100;
      $final_bc_id = null;
      $issue = 0;
      $current_status = -100;
      if ($first_roundbc != null) {
      if ($first_roundbc->training_status == 3 and in_array($model->gp_covert_urban, [1, 2])) {
      $first_roundbc_status = 33;
      } else {
      $first_roundbc_status = $first_roundbc->training_status;
      }
      $current_status = $first_roundbc_status;
      //                print_r($current_status);
      if (in_array($first_roundbc_status, [3, 33])) {
      $final_bc_id = $first_roundbc->id;
      }
      if (in_array($first_roundbc_status, [0, 1, 2, 3, 33])) {
      if ($second_roundbc == null and $third_roundbc == null and $fourth_roundbc == null and $fifth_roundbc == null and $sixth_roundbc == null and $seventh_roundbc == null and $eighth_roundbc == null and $ninth_roundbc == null and $tenth_roundbc == null and $eleventh_roundbc == null and $twelth_roundbc == null and $thirteen_roundbc == null and $fourteen_roundbc == null and $fifteen_roundbc == null) {

      } else {
      $issue = 1;
      }
      }
      }
      if ($second_roundbc != null) {
      if ($second_roundbc->training_status == 3 and in_array($model->gp_covert_urban, [1, 2])) {
      $second_roundbc_status = 33;
      } else {
      $second_roundbc_status = $second_roundbc->training_status;
      }
      $current_status = $second_roundbc_status;
      if ($final_bc_id == null) {
      if (in_array($second_roundbc_status, [3])) {
      $final_bc_id = $second_roundbc->id;
      }
      }
      if (in_array($second_roundbc_status, [0, 1, 2, 3, 33])) {
      if ($third_roundbc == null and $fourth_roundbc == null and $fifth_roundbc == null and $sixth_roundbc == null and $seventh_roundbc == null and $eighth_roundbc == null and $ninth_roundbc == null and $tenth_roundbc == null and $eleventh_roundbc == null and $twelth_roundbc == null and $thirteen_roundbc == null and $fourteen_roundbc == null and $fifteen_roundbc == null) {

      } else {
      $issue = 1;
      }
      }
      }
      if ($third_roundbc != null) {
      if ($third_roundbc->training_status == 3 and in_array($model->gp_covert_urban, [1, 2])) {
      $third_roundbc_status = 33;
      } else {
      $third_roundbc_status = $third_roundbc->training_status;
      }
      $current_status = $third_roundbc_status;
      if ($final_bc_id == null) {
      if (in_array($third_roundbc_status, [3])) {
      $final_bc_id = $third_roundbc->id;
      }
      }
      if (in_array($third_roundbc_status, [0, 1, 2, 3, 33])) {
      if ($fourth_roundbc == null and $fifth_roundbc == null and $sixth_roundbc == null and $seventh_roundbc == null and $eighth_roundbc == null and $ninth_roundbc == null and $tenth_roundbc == null and $eleventh_roundbc == null and $twelth_roundbc == null and $thirteen_roundbc == null and $fourteen_roundbc == null and $fifteen_roundbc == null) {

      } else {
      $issue = 1;
      }
      }
      }

      if ($fourth_roundbc != null) {
      if ($fourth_roundbc->training_status == 3 and in_array($model->gp_covert_urban, [1, 2])) {
      $fourth_roundbc_status = 33;
      } else {
      $fourth_roundbc_status = $fourth_roundbc->training_status;
      }
      $current_status = $fourth_roundbc_status;
      if ($final_bc_id == null) {
      if (in_array($fourth_roundbc_status, [3])) {
      $final_bc_id = $fourth_roundbc->id;
      }
      }
      if (in_array($fourth_roundbc_status, [0, 1, 2, 3, 33])) {
      if ($fifth_roundbc == null and $sixth_roundbc == null and $seventh_roundbc == null and $eighth_roundbc == null and $ninth_roundbc == null and $tenth_roundbc == null and $eleventh_roundbc == null and $twelth_roundbc == null and $thirteen_roundbc == null and $fourteen_roundbc == null and $fifteen_roundbc == null) {

      } else {
      $issue = 1;
      }
      }
      }
      if ($fifth_roundbc != null) {
      if ($fifth_roundbc->training_status == 3 and in_array($model->gp_covert_urban, [1, 2])) {
      $fifth_roundbc_status = 33;
      } else {
      $fifth_roundbc_status = $fifth_roundbc->training_status;
      }
      $current_status = $fifth_roundbc_status;
      if ($final_bc_id == null) {
      if (in_array($fifth_roundbc_status, [3])) {
      $final_bc_id = $fifth_roundbc->id;
      }
      }
      if (in_array($fifth_roundbc_status, [0, 1, 2, 3, 33])) {
      if ($sixth_roundbc == null and $seventh_roundbc == null and $eighth_roundbc == null and $ninth_roundbc == null and $tenth_roundbc == null and $eleventh_roundbc == null and $twelth_roundbc == null and $thirteen_roundbc == null and $fourteen_roundbc == null and $fifteen_roundbc == null) {

      } else {
      $issue = 1;
      }
      }
      }
      if ($sixth_roundbc != null) {
      if ($sixth_roundbc->training_status == 3 and in_array($model->gp_covert_urban, [1, 2])) {
      $sixth_roundbc_status = 33;
      } else {
      $sixth_roundbc_status = $sixth_roundbc->training_status;
      }
      $current_status = $sixth_roundbc_status;
      if ($final_bc_id == null) {
      if (in_array($sixth_roundbc_status, [3])) {
      $final_bc_id = $sixth_roundbc->id;
      }
      }
      if (in_array($sixth_roundbc_status, [0, 1, 2, 3, 33])) {
      if ($seventh_roundbc == null and $eighth_roundbc == null and $ninth_roundbc == null and $tenth_roundbc == null and $eleventh_roundbc == null and $twelth_roundbc == null and $thirteen_roundbc == null and $fourteen_roundbc == null and $fifteen_roundbc == null) {

      } else {
      $issue = 1;
      }
      }
      }
      if ($seventh_roundbc != null) {
      if ($seventh_roundbc->training_status == 3 and in_array($model->gp_covert_urban, [1, 2])) {
      $seventh_roundbc_status = 33;
      } else {
      $seventh_roundbc_status = $seventh_roundbc->training_status;
      }
      $current_status = $seventh_roundbc_status;
      if ($final_bc_id == null) {
      if (in_array($seventh_roundbc_status, [3])) {
      $final_bc_id = $seventh_roundbc->id;
      }
      }
      if (in_array($seventh_roundbc_status, [0, 1, 2, 3, 33])) {
      if ($eighth_roundbc == null and $ninth_roundbc == null and $tenth_roundbc == null and $eleventh_roundbc == null and $twelth_roundbc == null and $thirteen_roundbc == null and $fourteen_roundbc == null and $fifteen_roundbc == null) {

      } else {
      $issue = 1;
      }
      }
      }
      if ($eighth_roundbc != null) {
      if ($eighth_roundbc->training_status == 3 and in_array($model->gp_covert_urban, [1, 2])) {
      $eighth_roundbc_status = 33;
      } else {
      $eighth_roundbc_status = $eighth_roundbc->training_status;
      }
      $current_status = $eighth_roundbc_status;
      if ($final_bc_id == null) {
      if (in_array($eighth_roundbc_status, [3])) {
      $final_bc_id = $eighth_roundbc->id;
      }
      }
      if (in_array($eighth_roundbc_status, [0, 1, 2, 3, 33])) {
      if ($ninth_roundbc == null and $tenth_roundbc == null and $eleventh_roundbc == null and $twelth_roundbc == null and $thirteen_roundbc == null and $fourteen_roundbc == null and $fifteen_roundbc == null) {

      } else {
      $issue = 1;
      }
      }
      }
      if ($ninth_roundbc != null) {
      if ($ninth_roundbc->training_status == 3 and in_array($model->gp_covert_urban, [1, 2])) {
      $ninth_roundbc_status = 33;
      } else {
      $ninth_roundbc_status = $ninth_roundbc->training_status;
      }
      $current_status = $ninth_roundbc_status;
      if ($final_bc_id == null) {
      if (in_array($ninth_roundbc_status, [3])) {
      $final_bc_id = $ninth_roundbc->id;
      }
      }
      if (in_array($ninth_roundbc_status, [0, 1, 2, 3, 33])) {
      if ($tenth_roundbc == null and $eleventh_roundbc == null and $twelth_roundbc == null and $thirteen_roundbc == null and $fourteen_roundbc == null and $fifteen_roundbc == null) {

      } else {
      $issue = 1;
      }
      }
      }
      if ($tenth_roundbc != null) {
      if ($tenth_roundbc->training_status == 3 and in_array($model->gp_covert_urban, [1, 2])) {
      $tenth_roundbc_status = 33;
      } else {
      $tenth_roundbc_status = $tenth_roundbc->training_status;
      }
      $current_status = $tenth_roundbc_status;
      if ($final_bc_id == null) {
      if (in_array($tenth_roundbc_status, [3])) {
      $final_bc_id = $tenth_roundbc->id;
      }
      }
      if (in_array($tenth_roundbc_status, [0, 1, 2, 3, 33])) {
      if ($eleventh_roundbc == null and $twelth_roundbc == null and $thirteen_roundbc == null and $fourteen_roundbc == null and $fifteen_roundbc == null) {

      } else {
      $issue = 1;
      }
      }
      }
      if ($eleventh_roundbc != null) {
      if ($eleventh_roundbc->training_status == 3 and in_array($model->gp_covert_urban, [1, 2])) {
      $eleventh_roundbc_status = 33;
      } else {
      $eleventh_roundbc_status = $eleventh_roundbc->training_status;
      }
      $current_status = $eleventh_roundbc_status;
      if ($final_bc_id == null) {
      if (in_array($eleventh_roundbc_status, [3])) {
      $final_bc_id = $eleventh_roundbc->id;
      }
      }
      if (in_array($eleventh_roundbc_status, [0, 1, 2, 3, 33])) {
      if ($twelth_roundbc == null and $thirteen_roundbc == null and $fourteen_roundbc == null and $fifteen_roundbc == null) {

      } else {
      $issue = 1;
      }
      }
      }


      if ($twelth_roundbc != null) {
      if ($twelth_roundbc->training_status == 3 and in_array($model->gp_covert_urban, [1, 2])) {
      $twelth_roundbc_status = 33;
      } else {
      $twelth_roundbc_status = $twelth_roundbc->training_status;
      }
      $current_status = $twelth_roundbc_status;
      if ($final_bc_id == null) {
      if (in_array($twelth_roundbc_status, [3])) {
      $final_bc_id = $twelth_roundbc->id;
      }
      }
      if (in_array($twelth_roundbc_status, [0, 1, 2, 3, 33])) {
      if ($thirteen_roundbc == null and $fourteen_roundbc == null and $fifteen_roundbc == null) {

      } else {
      $issue = 1;
      }
      }
      }
      if ($thirteen_roundbc != null) {
      if ($thirteen_roundbc->training_status == 3 and in_array($model->gp_covert_urban, [1, 2])) {
      $thirteen_roundbc_status = 33;
      } else {
      $thirteen_roundbc_status = $thirteen_roundbc->training_status;
      }
      $current_status = $thirteen_roundbc_status;
      if ($final_bc_id == null) {
      if (in_array($thirteen_roundbc_status, [3])) {
      $final_bc_id = $thirteen_roundbc->id;
      }
      }
      if (in_array($thirteen_roundbc_status, [0, 1, 2, 3, 33])) {
      if ($fourteen_roundbc == null and $fifteen_roundbc == null) {

      } else {
      $issue = 1;
      }
      }
      }
      if ($fourteen_roundbc != null) {
      if ($fourteen_roundbc->training_status == 3 and in_array($model->gp_covert_urban, [1, 2])) {
      $fourteen_roundbc_status = 33;
      } else {
      $fourteen_roundbc_status = $fourteen_roundbc->training_status;
      }
      $current_status = $fourteen_roundbc_status;
      if ($final_bc_id == null) {
      if (in_array($fourteen_roundbc_status, [3])) {
      $final_bc_id = $fourteen_roundbc->id;
      }
      }
      if (in_array($fourteen_roundbc_status, [0, 1, 2, 3, 33])) {
      if ($fifteen_roundbc == null) {

      } else {
      $issue = 1;
      }
      }
      }


      if ($fifteen_roundbc != null) {
      if ($fifteen_roundbc->training_status == 3 and in_array($model->gp_covert_urban, [1, 2])) {
      $fifteen_roundbc_status = 33;
      } else {
      $fifteen_roundbc_status = $fifteen_roundbc->training_status;
      }
      $current_status = $fifteen_roundbc_status;
      if ($final_bc_id == null) {
      if (in_array($fifteen_roundbc_status, [3])) {
      $final_bc_id = $fifteen_roundbc->id;
      }
      }
      }
      \bc\models\master\MasterGramPanchayatDetailBc::updateAll([
      'current_available' => $current_available,
      'current_status' => $current_status,
      'final_bc_id' => $final_bc_id,
      'total_no_of_application' => $bc_selection_application_receive,
      'selected_bc_round1' => isset($first_roundbc) ? 1 : 0,
      'selected_bc_round2' => isset($second_roundbc) ? 1 : 0,
      'selected_bc_round3' => isset($third_roundbc) ? 1 : 0,
      'selected_bc_round1_status' => $first_roundbc_status,
      'selected_bc_round2_status' => $second_roundbc_status,
      'selected_bc_round3_status' => $third_roundbc_status,
      'selected_bc_round4_status' => $fourth_roundbc_status,
      'selected_bc_round5_status' => $fifth_roundbc_status,
      'selected_bc_round6_status' => $sixth_roundbc_status,
      'selected_bc_round7_status' => $seventh_roundbc_status,
      'selected_bc_round8_status' => $eighth_roundbc_status,
      'selected_bc_round9_status' => $ninth_roundbc_status,
      'selected_bc_round10_status' => $tenth_roundbc_status,
      'selected_bc_round11_status' => $eleventh_roundbc_status,
      'selected_bc_round12_status' => $twelth_roundbc_status,
      'selected_bc_round13_status' => $thirteen_roundbc_status,
      'selected_bc_round14_status' => $fourteen_roundbc_status,
      'selected_bc_round15_status' => $fifteen_roundbc_status,
      'issue' => $issue
      ], $condition1);
      }
      //}
      echo "Gp Coplete time : " . date('Y-m-d H:i:s') . PHP_EOL;
      return ExitCode::OK;
      } 

    public function actionBcstatus() {
        ini_set('memory_limit', '-1');
        $models = \bc\models\master\MasterGramPanchayat::find()->where(['status' => 1])->orderBy('district_name asc,block_name asc,gram_panchayat_name asc')->all();
        $file = "gp_status_" . date('Y-m-d') . ".csv";
        $file_path = Yii::$app->params['datapath'] . 'tmp/' . 'callcenter/' . $file;
        $array = ['-2' => 'Unwilling', 0 => 'Preselected', 1 => 'Agree', '2' => 'Registered(Assign Batch)', '3' => 'Certified', '32' => 'Certified Unwilling', '4' => 'Not Certified', '5' => 'ineligible', '55' => 'ineligible', '6' => 'Absent'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $output = fopen($file_path, 'w');
        fputcsv($output, array('Sr No',
            'District',
            'Block',
            'GP',
            'GP Code',
            'status',
            'Work Start Date',
            'No. of transaction',
            'Txn Amount',
            'Commission Amount',
            'No. Of Days',
            'Working Days',
            'Error'
                )
        );
        $sr_no = 1;
        $row = [];
        foreach ($models as $model) {
            $bc = \bc\models\transaction\BcTransactionOverallReport::find()->where(['bc_application_id' => $model->gpdetail->final_bc_id])->limit(1)->one();
            $issue = 0;
            $row = [
                $sr_no,
                $model->district_name,
                $model->block_name,
                "'" . $model->gram_panchayat_name . "'",
                $model->gram_panchayat_code,
                $array[$model->gpdetail->current_status],
                $bc != null ? $bc->start_date : '',
                $bc != null ? $bc->no_of_transaction : '',
                $bc != null ? $bc->transaction_amount : '',
                $bc != null ? $bc->commission_amount : '',
                $bc != null ? $bc->no_of_days : '',
                $bc != null ? $bc->no_of_working_days : '',
                $model->gpdetail->issue
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        echo "Gp Coplete time : " . date('Y-m-d H:i:s') . PHP_EOL;
        return ExitCode::OK;
    }

    public function actionGpbcstatus() {
        echo "Gp start time : " . date('Y-m-d H:i:s') . PHP_EOL;
        ini_set('memory_limit', '-1');
        $models = \bc\models\master\MasterGramPanchayat::find()->where(['status' => 1])->orderBy('district_name asc,block_name asc,gram_panchayat_name asc')->all();
        $file = "gp_bc_status_" . date('Y-m-d') . ".csv";
        $file_path = Yii::$app->params['datapath'] . 'tmp/' . 'callcenter/' . $file;
        $array = ['-2' => 'Unwilling', 0 => 'Preselected', 1 => 'Agree', '2' => 'Registered(Assign Batch)', '3' => 'Certified', '32' => 'Certified Unwilling', '4' => 'Not Certified', '5' => 'ineligible', '55' => 'ineligible', '6' => 'Absent'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $output = fopen($file_path, 'w');
        fputcsv($output, array('Sr No',
            'District',
            'Block',
            'GP',
            'GP Code',
            'BC Status',
            'GP Status'
                )
        );
        $sr_no = 1;
        $row = [];
        foreach ($models as $model) {
            if ($model->gpdetail->issue) {
                $srlm_bc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'training_status' => 3])->one();
                if ($srlm_bc != null) {
                    $model->gpdetail->current_status = 3;
                } else {
                    $bc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'status' => 2, 'training_status' => [0, 1, 2, 3]])->one();
                    if ($bc != null) {
                        $model->gpdetail->current_status = $bc->training_status;
                    }
                }
            }
            $gp_status = $array[$model->gpdetail->current_status];
            if (in_array($model->gpdetail->current_status, [-2, 32, 4, 5, 6, 34]) and $model->gpdetail->current_available == '0') {
                $gp_status = 'GP Vacant';
            }
            if (in_array($model->gpdetail->current_status, [-2, 32, 4, 5, 6, 34]) and $model->gpdetail->current_available > '0') {
                $gp_status = 'Standby';
            }
            $issue = 0;
            $row = [
                $sr_no,
                $model->district_name,
                $model->block_name,
                str_replace(',', '', trim($model->gram_panchayat_name, ',')),
                $model->gram_panchayat_code,
                $array[$model->gpdetail->current_status],
                $gp_status,
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        echo "Gp Coplete time : " . date('Y-m-d H:i:s') . PHP_EOL;
        return ExitCode::OK;
    }

    public function actionCheck() {
        /* SELECT master_gram_panchayat.district_name,master_gram_panchayat.block_name,master_gram_panchayat.gram_panchayat_name,master_gram_panchayat.gram_panchayat_code  FROM `master_gram_panchayat_detail_bc`

          join master_gram_panchayat on master_gram_panchayat.gram_panchayat_code=master_gram_panchayat_detail_bc.gram_panchayat_code

          where master_gram_panchayat.status=1 and master_gram_panchayat_detail_bc.current_available>0 and master_gram_panchayat_detail_bc.current_status IN (-100,-2,32,4,5,6) and master_gram_panchayat_detail_bc.issue=0

          ORDER by district_name asc,block_name ASC,gram_panchayat_name ASC */
        $gps = \bc\models\master\MasterGramPanchayatDetailBc::find()->joinWith(['gp'])->where("`issue` = 0 AND `current_available` > 0 AND `current_status` NOT IN (0,1,2,3) and master_gram_panchayat.status =1")->andWhere(['master_gram_panchayat.status' => 1])->all();
        //$gps = \bc\models\master\MasterGramPanchayatDetailBc::find()->joinWith(['gp'])->andWhere(['master_gram_panchayat.status' => 1, 'six_vacant' => 1])->all();
        echo count($gps) . PHP_EOL;
        foreach ($gps as $gp) {


            $bc_app_count = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->count();

            if ($bc_app_count == 0) {
                echo PHP_EOL;
                echo $gp->gram_panchayat_code;
                echo "Error11";
                echo PHP_EOL;
//                exit;
            }

            $bc_app_count2 = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 2])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->andWhere(['training_status' => [0, 1, 2, 3]])->count();

            if ($bc_app_count2 != 0) {
                echo PHP_EOL;
                echo $gp->gram_panchayat_code;
                echo "Error22";
                echo PHP_EOL;
                //  exit;
            }
        }
    }

    public function actionCheck1() {
        /* SELECT master_gram_panchayat.district_name,master_gram_panchayat.block_name,master_gram_panchayat.gram_panchayat_name,master_gram_panchayat.gram_panchayat_code  FROM `master_gram_panchayat_detail_bc`

          join master_gram_panchayat on master_gram_panchayat.gram_panchayat_code=master_gram_panchayat_detail_bc.gram_panchayat_code

          where master_gram_panchayat.status=1 and master_gram_panchayat_detail_bc.current_available>0 and master_gram_panchayat_detail_bc.current_status IN (-100,-2,32,4,5,6) and master_gram_panchayat_detail_bc.issue=0

          ORDER by district_name asc,block_name ASC,gram_panchayat_name ASC */
        $gps = \bc\models\master\MasterGramPanchayatDetailBc::find()->joinWith(['gp'])->where("`issue` = 0 AND `current_available` = 0 AND `current_status` NOT IN (0,1,2,3) and master_gram_panchayat.status =1")->andWhere(['master_gram_panchayat.status' => 1])->all();
        //$gps = \bc\models\master\MasterGramPanchayatDetailBc::find()->joinWith(['gp'])->andWhere(['master_gram_panchayat.status' => 1, 'six_vacant' => 1])->all();
        echo count($gps) . PHP_EOL;
        foreach ($gps as $gp) {


            $bc_app_count = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->count();

            if ($bc_app_count == 1) {
                echo PHP_EOL;
                echo $gp->gram_panchayat_code;
                echo "Error11";
                echo PHP_EOL;
//                exit;
            }

            $bc_app_count2 = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 2])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->andWhere(['training_status' => [0, 1, 2, 3]])->count();

            if ($bc_app_count2 != 0) {
                echo PHP_EOL;
                echo $gp->gram_panchayat_code;
                echo "Error22";
                echo PHP_EOL;
                //  exit;
            }
        }
    }

    public function actionChecks() {
        /* SELECT master_gram_panchayat.district_name,master_gram_panchayat.block_name,master_gram_panchayat.gram_panchayat_name,master_gram_panchayat.gram_panchayat_code  FROM `master_gram_panchayat_detail_bc`

          join master_gram_panchayat on master_gram_panchayat.gram_panchayat_code=master_gram_panchayat_detail_bc.gram_panchayat_code

          where master_gram_panchayat.status=1 and master_gram_panchayat_detail_bc.current_available>0 and master_gram_panchayat_detail_bc.current_status IN (-100,-2,32,4,5,6) and master_gram_panchayat_detail_bc.issue=0

          ORDER by district_name asc,block_name ASC,gram_panchayat_name ASC */
        $gps = \bc\models\master\MasterGramPanchayatDetailBc::find()->joinWith(['gp'])->where("`issue` = 0 and temp_gp_stand=1 AND `current_available` > 0 AND `current_status` NOT IN (0,1,2,3) and master_gram_panchayat.status =1")->andWhere(['master_gram_panchayat.status' => 1])->all();
        //$gps = \bc\models\master\MasterGramPanchayatDetailBc::find()->joinWith(['gp'])->andWhere(['master_gram_panchayat.status' => 1, 'six_vacant' => 1])->all();
        echo count($gps) . PHP_EOL;
        foreach ($gps as $gp) {


            $bc_app_count = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->count();

            if ($bc_app_count == 0) {
                echo PHP_EOL;
                echo $gp->gram_panchayat_code;
                echo "Error11";
                echo PHP_EOL;
//                exit;
            }

            $bc_app_count2 = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 2])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->andWhere(['training_status' => [0, 1, 2, 3]])->count();

            if ($bc_app_count2 != 0) {
                echo PHP_EOL;
                echo $gp->gram_panchayat_code;
                echo "Error22";
                echo PHP_EOL;
                //  exit;
            }
        }
    }

    public function actionCheckv() {
        /* SELECT master_gram_panchayat.district_name,master_gram_panchayat.block_name,master_gram_panchayat.gram_panchayat_name,master_gram_panchayat.gram_panchayat_code  FROM `master_gram_panchayat_detail_bc`

          join master_gram_panchayat on master_gram_panchayat.gram_panchayat_code=master_gram_panchayat_detail_bc.gram_panchayat_code

          where master_gram_panchayat.status=1 and master_gram_panchayat_detail_bc.current_available>0 and master_gram_panchayat_detail_bc.current_status IN (-100,-2,32,4,5,6) and master_gram_panchayat_detail_bc.issue=0

          ORDER by district_name asc,block_name ASC,gram_panchayat_name ASC */
        $gps = \bc\models\master\MasterGramPanchayatDetailBc::find()->joinWith(['gp'])->where("`issue` = 0 and seventh_vacant=1 AND `current_available` = 0 AND `current_status` NOT IN (0,1,2,3) and master_gram_panchayat.status =1")->andWhere(['master_gram_panchayat.status' => 1])->all();
        //$gps = \bc\models\master\MasterGramPanchayatDetailBc::find()->joinWith(['gp'])->andWhere(['master_gram_panchayat.status' => 1, 'six_vacant' => 1])->all();
        echo count($gps) . PHP_EOL;
        foreach ($gps as $gp) {


            $bc_app_count = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->count();

            if ($bc_app_count == 1) {
                echo PHP_EOL;
                echo $gp->gram_panchayat_code;
                echo "Error11";
                echo PHP_EOL;
//                exit;
            }

            $bc_app_count2 = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 2])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->andWhere(['training_status' => [0, 1, 2, 3]])->count();

            if ($bc_app_count2 != 0) {
                echo PHP_EOL;
                echo $gp->gram_panchayat_code;
                echo "Error22";
                echo PHP_EOL;
                //  exit;
            }
        }
    }

//    public function actionLot4() {
//        //exit;
    //       $standby3 = \bc\models\master\MasterGramPanchayat::find()->andWhere(['NOT', ['standby3_id' => null]])->all();
//        if ($standby3 == null) {
//            $vacant_gps = \bc\models\master\MasterGramPanchayat::find()->where("`issue` = 0 AND `current_available` > 0 AND `current_status` NOT IN (0,1,2,3) and status =1")->all();
//            foreach ($vacant_gps as $vacant_gp) {
//                $gp = \bc\models\master\MasterGramPanchayat::findOne(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code]);
//                $bc_app_count = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->count();
//                $bc_app_count2 = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 2])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->andWhere(['training_status' => [0, 1, 2, 3]])->count();
//                if ($bc_app_count != 0 and $bc_app_count2 == 0) {
//                    $new_bc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1, 'status_new' => 2])->one();
//
//                    if ($new_bc != null) {
//                        $gp->standby3_id = $new_bc->id;
//                        $gp->save();
//                        $new_bc->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                        $new_bc->selection_by = 4;
//                        $new_bc->selection_datetime = new \yii\db\Expression('NOW()');
//                        $new_bc->save();
//                    } else {
//                        $bc_models = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1])->all();
//                        if (count($bc_models)) {
//                            if (count($bc_models) == 1) {
//                                $gp->standby3_id = $bc_models[0]->id;
//
//                                $gp->save();
//                                $standby3_model = $bc_models[0];
//                                $standby3_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                                $standby3_model->selection_by = 4;
//                                $standby3_model->selection_datetime = new \yii\db\Expression('NOW()');
//                                $standby3_model->save();
//                            } else {
//                                $chairperson = [];
//                                $samuhsakhi = [];
//                                $shgmember = [];
//                                $nomemeber = [];
//                                foreach ($bc_models as $model) {
//                                    if ($model->already_group_member == "2")
//                                        array_push($chairperson, $model);
//                                    else if ($model->already_group_member == "7")
//                                        array_push($samuhsakhi, $model);
//                                    else if ($model->already_group_member == "1")
//                                        array_push($nomemeber, $model);
//                                    else
//                                        array_push($shgmember, $model);
//                                }
//                                usort($chairperson, array($this, "cmp_overall"));
//                                usort($samuhsakhi, array($this, "cmp_overall"));
//                                usort($shgmember, array($this, "cmp_overall"));
//                                usort($nomemeber, array($this, "cmp_overall"));
//                                if (count($chairperson) > 0) {
//                                    $standby3_model = $chairperson[0];
//                                } else if (count($samuhsakhi) > 0) {
//                                    $standby3_model = $samuhsakhi[0];
//                                } else if (count($shgmember) > 0) {
//                                    $standby3_model = $shgmember[0];
//                                } else if (count($nomemeber) > 0) {
//                                    $standby3_model = $nomemeber[0];
//                                }
//                                if ($standby3_model != null) {
//                                    $gp->standby3_id = $standby3_model->id;
//
//                                    $gp->save();
//                                    $standby3_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                                    $standby3_model->selection_by = 4;
//                                    $standby3_model->selection_datetime = new \yii\db\Expression('NOW()');
//                                    $standby3_model->save();
//                                }
//                            }
//                        }
//                    }
//                }
//            }
//        }
//    }
//    public function actionLot5() {
//        //exit;
//        $standby4 = \bc\models\master\MasterGramPanchayatDetailBc::find()->andWhere(['NOT', ['standby4_id' => null]])->all();
//        if ($standby4 == null) {
//            $vacant_gps = \bc\models\master\MasterGramPanchayatDetailBc::find()->joinWith(['gp'])->where("`issue` = 0 AND `current_available` > 0 AND `current_status` NOT IN (0,1,2,3)")->andWhere(['master_gram_panchayat.status' => 1])->all();
//            foreach ($vacant_gps as $vacant_gp) {
//                $gp = \bc\models\master\MasterGramPanchayatDetailBc::findOne(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code]);
//                $bc_app_count = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->count();
//                $bc_app_count2 = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 2])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->andWhere(['training_status' => [0, 1, 2, 3]])->count();
//                if ($bc_app_count != 0 and $bc_app_count2 == 0) {
//                    $new_bc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1, 'status_new' => 2])->one();
//
//                    if ($new_bc != null) {
//                        $gp->standby4_id = $new_bc->id;
//                        $gp->save();
//                        $new_bc->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                        $new_bc->selection_by = 5;
//                        $new_bc->selection_datetime = new \yii\db\Expression('NOW()');
//                        $new_bc->save();
//                    } else {
//                        $bc_models = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1])->all();
//                        if (count($bc_models)) {
//                            if (count($bc_models) == 1) {
//                                $gp->standby4_id = $bc_models[0]->id;
//
//                                $gp->save();
//                                $standby4_model = $bc_models[0];
//                                $standby4_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                                $standby4_model->selection_by = 5;
//                                $standby4_model->selection_datetime = new \yii\db\Expression('NOW()');
//                                $standby4_model->save();
//                            } else {
//                                $chairperson = [];
//                                $samuhsakhi = [];
//                                $shgmember = [];
//                                $nomemeber = [];
//                                foreach ($bc_models as $model) {
//                                    if ($model->already_group_member == "2")
//                                        array_push($chairperson, $model);
//                                    else if ($model->already_group_member == "7")
//                                        array_push($samuhsakhi, $model);
//                                    else if ($model->already_group_member == "1")
//                                        array_push($nomemeber, $model);
//                                    else
//                                        array_push($shgmember, $model);
//                                }
//                                usort($chairperson, array($this, "cmp_overall"));
//                                usort($samuhsakhi, array($this, "cmp_overall"));
//                                usort($shgmember, array($this, "cmp_overall"));
//                                usort($nomemeber, array($this, "cmp_overall"));
//                                if (count($chairperson) > 0) {
//                                    $standby4_model = $chairperson[0];
//                                } else if (count($samuhsakhi) > 0) {
//                                    $standby4_model = $samuhsakhi[0];
//                                } else if (count($shgmember) > 0) {
//                                    $standby4_model = $shgmember[0];
//                                } else if (count($nomemeber) > 0) {
//                                    $standby4_model = $nomemeber[0];
//                                }
//                                if ($standby4_model != null) {
//                                    $gp->standby4_id = $standby4_model->id;
//
//                                    $gp->save();
//                                    $standby4_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                                    $standby4_model->selection_by = 5;
//                                    $standby4_model->selection_datetime = new \yii\db\Expression('NOW()');
//                                    $standby4_model->save();
//                                }
//                            }
//                        }
//                    }
//                } else {
//                    echo PHP_EOL;
//                    echo $gp->gram_panchayat_code;
//                    echo "Error2";
//                }
//            }
//        }
//    }
//    public function actionLot6() {
//        //exit;
//        $standby5 = \bc\models\master\MasterGramPanchayatDetailBc::find()->andWhere(['NOT', ['standby5_id' => null]])->all();
//        if ($standby5 == null) {
//            $vacant_gps = \bc\models\master\MasterGramPanchayatDetailBc::find()->joinWith(['gp'])->where("`issue` = 0 AND `current_available` > 0 AND `current_status` NOT IN (0,1,2,3)")->andWhere(['master_gram_panchayat.status' => 1])->all();
//            foreach ($vacant_gps as $vacant_gp) {
//                $gp = \bc\models\master\MasterGramPanchayatDetailBc::findOne(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code]);
//                $bc_app_count = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->count();
//                $bc_app_count2 = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 2])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->andWhere(['training_status' => [0, 1, 2, 3]])->count();
//                if ($bc_app_count != 0 and $bc_app_count2 == 0) {
//                    $new_bc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1, 'status_new' => 2])->one();
//
//                    if ($new_bc != null) {
//                        $gp->standby5_id = $new_bc->id;
//                        $gp->save();
//                        $new_bc->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                        $new_bc->selection_by = 6;
//                        $new_bc->selection_datetime = new \yii\db\Expression('NOW()');
//                        $new_bc->save();
//                    } else {
//                        $bc_models = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1])->all();
//                        if (count($bc_models)) {
//                            if (count($bc_models) == 1) {
//                                $gp->standby5_id = $bc_models[0]->id;
//
//                                $gp->save();
//                                $standby5_model = $bc_models[0];
//                                $standby5_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                                $standby5_model->selection_by = 6;
//                                $standby5_model->selection_datetime = new \yii\db\Expression('NOW()');
//                                $standby5_model->save();
//                            } else {
//                                $chairperson = [];
//                                $samuhsakhi = [];
//                                $shgmember = [];
//                                $nomemeber = [];
//                                foreach ($bc_models as $model) {
//                                    if ($model->already_group_member == "2")
//                                        array_push($chairperson, $model);
//                                    else if ($model->already_group_member == "7")
//                                        array_push($samuhsakhi, $model);
//                                    else if ($model->already_group_member == "1")
//                                        array_push($nomemeber, $model);
//                                    else
//                                        array_push($shgmember, $model);
//                                }
//                                usort($chairperson, array($this, "cmp_overall"));
//                                usort($samuhsakhi, array($this, "cmp_overall"));
//                                usort($shgmember, array($this, "cmp_overall"));
//                                usort($nomemeber, array($this, "cmp_overall"));
//                                if (count($chairperson) > 0) {
//                                    $standby5_model = $chairperson[0];
//                                } else if (count($samuhsakhi) > 0) {
//                                    $standby5_model = $samuhsakhi[0];
//                                } else if (count($shgmember) > 0) {
//                                    $standby5_model = $shgmember[0];
//                                } else if (count($nomemeber) > 0) {
//                                    $standby5_model = $nomemeber[0];
//                                }
//                                if ($standby5_model != null) {
//                                    $gp->standby5_id = $standby5_model->id;
//
//                                    $gp->save();
//                                    $standby5_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                                    $standby5_model->selection_by = 6;
//                                    $standby5_model->selection_datetime = new \yii\db\Expression('NOW()');
//                                    $standby5_model->save();
//                                }
//                            }
//                        }
//                    }
//                } else {
//                    echo PHP_EOL;
//                    echo $gp->gram_panchayat_code;
//                    echo "Error2";
//                }
//            }
//        }
//    }
//    public function actionLot7() {
//        //exit;
//        $standby6 = \bc\models\master\MasterGramPanchayatDetailBc::find()->andWhere(['NOT', ['standby6_id' => null]])->all();
//        if ($standby6 == null) {
//            $vacant_gps = \bc\models\master\MasterGramPanchayatDetailBc::find()->joinWith(['gp'])->where("`issue` = 0 AND `fourth_vacant`=1 AND `current_status` NOT IN (0,1,2,3)")->andWhere(['master_gram_panchayat.status' => 1])->all();
//            foreach ($vacant_gps as $vacant_gp) {
//                $gp = \bc\models\master\MasterGramPanchayatDetailBc::findOne(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code]);
//                $bc_app_count = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->count();
//                $bc_app_count2 = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 2])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->andWhere(['training_status' => [0, 1, 2, 3]])->count();
//                if ($bc_app_count != 0 and $bc_app_count2 == 0) {
//                    $new_bc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1, 'status_new' => 2])->one();
//
//                    if ($new_bc != null) {
//                        $gp->standby6_id = $new_bc->id;
//                        $gp->save();
//                        $new_bc->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                        $new_bc->selection_by = 7;
//                        $new_bc->selection_datetime = new \yii\db\Expression('NOW()');
//                        $new_bc->save();
//                    } else {
//                        $bc_models = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1])->all();
//                        if (count($bc_models)) {
//                            if (count($bc_models) == 1) {
//                                $gp->standby6_id = $bc_models[0]->id;
//
//                                $gp->save();
//                                $standby6_model = $bc_models[0];
//                                $standby6_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                                $standby6_model->selection_by = 7;
//                                $standby6_model->selection_datetime = new \yii\db\Expression('NOW()');
//                                $standby6_model->save();
//                            } else {
//                                $chairperson = [];
//                                $samuhsakhi = [];
//                                $shgmember = [];
//                                $nomemeber = [];
//                                foreach ($bc_models as $model) {
//                                    if ($model->already_group_member == "2")
//                                        array_push($chairperson, $model);
//                                    else if ($model->already_group_member == "7")
//                                        array_push($samuhsakhi, $model);
//                                    else if ($model->already_group_member == "1")
//                                        array_push($nomemeber, $model);
//                                    else
//                                        array_push($shgmember, $model);
//                                }
//                                usort($chairperson, array($this, "cmp_overall"));
//                                usort($samuhsakhi, array($this, "cmp_overall"));
//                                usort($shgmember, array($this, "cmp_overall"));
//                                usort($nomemeber, array($this, "cmp_overall"));
//                                if (count($chairperson) > 0) {
//                                    $standby6_model = $chairperson[0];
//                                } else if (count($samuhsakhi) > 0) {
//                                    $standby6_model = $samuhsakhi[0];
//                                } else if (count($shgmember) > 0) {
//                                    $standby6_model = $shgmember[0];
//                                } else if (count($nomemeber) > 0) {
//                                    $standby6_model = $nomemeber[0];
//                                }
//                                if ($standby6_model != null) {
//                                    $gp->standby6_id = $standby6_model->id;
//
//                                    $gp->save();
//                                    $standby6_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                                    $standby6_model->selection_by = 7;
//                                    $standby6_model->selection_datetime = new \yii\db\Expression('NOW()');
//                                    $standby6_model->save();
//                                }
//                            }
//                        }
//                    }
//                } else {
//                    echo PHP_EOL;
//                    echo $gp->gram_panchayat_code;
//                    echo "Error2";
//                }
//            }
//        }
//    }
//    public function actionLot8() {
//        //exit;
//        $standby7 = \bc\models\master\MasterGramPanchayatDetailBc::find()->andWhere(['NOT', ['standby7_id' => null]])->all();
//        if ($standby7 == null) {
//            $vacant_gps = \bc\models\master\MasterGramPanchayatDetailBc::find()->joinWith(['gp'])->where("`issue` = 0  AND `current_available` > 0 AND `current_status` NOT IN (0,1,2,3)")->andWhere(['master_gram_panchayat.status' => 1])->all();
////            echo count($vacant_gps);exit;
//            foreach ($vacant_gps as $vacant_gp) {
//                $gp = \bc\models\master\MasterGramPanchayatDetailBc::findOne(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code]);
//
//                $bc_app_count = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->count();
//                $bc_app_count2 = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 2])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->andWhere(['training_status' => [0, 1, 2, 3]])->count();
//                if ($bc_app_count != 0 and $bc_app_count2 == 0) {
//                    $new_bc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1, 'status_new' => 2])->one();
//
//                    if ($new_bc != null) {
//                        $gp->standby7_id = $new_bc->id;
//                        $gp->save();
//                        $new_bc->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                        $new_bc->selection_by = 8;
//                        $new_bc->selection_datetime = new \yii\db\Expression('NOW()');
//                        $new_bc->save();
//                    } else {
//                        $bc_models = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1])->all();
//                        if (count($bc_models)) {
//                            if (count($bc_models) == 1) {
//                                $gp->standby7_id = $bc_models[0]->id;
//
//                                $gp->save();
//                                $standby7_model = $bc_models[0];
//                                $standby7_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                                $standby7_model->selection_by = 8;
//                                $standby7_model->selection_datetime = new \yii\db\Expression('NOW()');
//                                $standby7_model->save();
//                            } else {
//                                $chairperson = [];
//                                $samuhsakhi = [];
//                                $shgmember = [];
//                                $nomemeber = [];
//                                foreach ($bc_models as $model) {
//                                    if ($model->already_group_member == "2")
//                                        array_push($chairperson, $model);
//                                    else if ($model->already_group_member == "7")
//                                        array_push($samuhsakhi, $model);
//                                    else if ($model->already_group_member == "1")
//                                        array_push($nomemeber, $model);
//                                    else
//                                        array_push($shgmember, $model);
//                                }
//                                usort($chairperson, array($this, "cmp_overall"));
//                                usort($samuhsakhi, array($this, "cmp_overall"));
//                                usort($shgmember, array($this, "cmp_overall"));
//                                usort($nomemeber, array($this, "cmp_overall"));
//                                if (count($chairperson) > 0) {
//                                    $standby7_model = $chairperson[0];
//                                } else if (count($samuhsakhi) > 0) {
//                                    $standby7_model = $samuhsakhi[0];
//                                } else if (count($shgmember) > 0) {
//                                    $standby7_model = $shgmember[0];
//                                } else if (count($nomemeber) > 0) {
//                                    $standby7_model = $nomemeber[0];
//                                }
//                                if ($standby7_model != null) {
//                                    $gp->standby7_id = $standby7_model->id;
//
//                                    $gp->save();
//                                    $standby7_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                                    $standby7_model->selection_by = 8;
//                                    $standby7_model->selection_datetime = new \yii\db\Expression('NOW()');
//                                    $standby7_model->save();
//                                }
//                            }
//                        }
//                    }
//                } else {
//                    echo PHP_EOL;
//                    echo $gp->gram_panchayat_code;
//                    echo "Error2";
//                }
//            }
//        }
////    }
//    public function actionLot10() {
//        exit;
//        $standby9 = \bc\models\master\MasterGramPanchayatDetailBc::find()->andWhere(['NOT', ['standby9_id' => null]])->all();
//        if ($standby9 == null) {
//            $vacant_gps = \bc\models\master\MasterGramPanchayatDetailBc::find()->joinWith(['gp'])->where("`issue` = 0  AND `current_available` > 0 AND `current_status` NOT IN (0,1,2,3)")->andWhere(['master_gram_panchayat.status' => 1, 'temp_gp_stand' => 1])->all();
//            //echo count($vacant_gps);exit;
//            foreach ($vacant_gps as $vacant_gp) {
//                $gp = \bc\models\master\MasterGramPanchayatDetailBc::findOne(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code]);
//                $bc_app_count = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->count();
//                $bc_app_count2 = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 2])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->andWhere(['training_status' => [0, 1, 2, 3]])->count();
//                if ($bc_app_count != 0 and $bc_app_count2 == 0) {
//                    $new_bc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1, 'status_new' => 2])->one();
//                    if ($new_bc != null) {
//                        $gp->standby9_id = $new_bc->id;
//                        $gp->save();
//                        $new_bc->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                        $new_bc->selection_by = 10;
//                        $new_bc->selection_datetime = new \yii\db\Expression('NOW()');
//                        $new_bc->action_type = SrlmBcApplication::ACTION_TYPE_SELECTION;
//                        $new_bc->save();
//                    } else {
//                        $bc_models = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1])->all();
//                        if (count($bc_models)) {
//                            if (count($bc_models) == 1) {
//                                $gp->standby9_id = $bc_models[0]->id;
//
//                                $gp->save();
//                                $standby9_model = $bc_models[0];
//                                $standby9_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                                $standby9_model->selection_by = 10;
//                                $standby9_model->selection_datetime = new \yii\db\Expression('NOW()');
//                                $standby9_model->action_type = SrlmBcApplication::ACTION_TYPE_SELECTION;
//                                $standby9_model->save();
//                            } else {
//                                $chairperson = [];
//                                $samuhsakhi = [];
//                                $shgmember = [];
//                                $nomemeber = [];
//                                foreach ($bc_models as $model) {
//                                    if ($model->already_group_member == "2")
//                                        array_push($chairperson, $model);
//                                    else if ($model->already_group_member == "7")
//                                        array_push($samuhsakhi, $model);
//                                    else if ($model->already_group_member == "1")
//                                        array_push($nomemeber, $model);
//                                    else
//                                        array_push($shgmember, $model);
//                                }
//                                usort($chairperson, array($this, "cmp_overall"));
//                                usort($samuhsakhi, array($this, "cmp_overall"));
//                                usort($shgmember, array($this, "cmp_overall"));
//                                usort($nomemeber, array($this, "cmp_overall"));
//                                if (count($chairperson) > 0) {
//                                    $standby9_model = $chairperson[0];
//                                } else if (count($samuhsakhi) > 0) {
//                                    $standby9_model = $samuhsakhi[0];
//                                } else if (count($shgmember) > 0) {
//                                    $standby9_model = $shgmember[0];
//                                } else if (count($nomemeber) > 0) {
//                                    $standby9_model = $nomemeber[0];
//                                }
//                                if ($standby9_model != null) {
//                                    $gp->standby9_id = $standby9_model->id;
//                                    $gp->save();
//                                    $standby9_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                                    $standby9_model->selection_by = 10;
//                                    $standby9_model->selection_datetime = new \yii\db\Expression('NOW()');
//                                    $standby9_model->action_type = SrlmBcApplication::ACTION_TYPE_SELECTION;
//                                    $standby9_model->save();
//                                }
//                            }
//                        }
//                    }
//                } else {
//                    echo PHP_EOL;
//                    echo $gp->gram_panchayat_code;
//                    echo "Error2";
//                }
//            }
//        }
//    }
//    public function actionLot11() {
//        exit;
//        $standby10 = \bc\models\master\MasterGramPanchayatDetailBc::find()->andWhere(['NOT', ['standby10_id' => null]])->all();
//        if ($standby10 == null) {
//            $vacant_gps = \bc\models\master\MasterGramPanchayatDetailBc::find()->joinWith(['gp'])->where("`issue` = 0  AND master_gram_panchayat_detail_bc.fifth_vacant=1 and master_gram_panchayat_detail_bc.fifth_complete!=0 AND `current_status` NOT IN (0,1,2,3)")->andWhere(['master_gram_panchayat.status' => 1])->all();
//            //echo count($vacant_gps);exit;
//            foreach ($vacant_gps as $vacant_gp) {
//                $gp = \bc\models\master\MasterGramPanchayatDetailBc::findOne(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code]);
//                $bc_app_count = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->count();
//                $bc_app_count2 = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 2])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->andWhere(['training_status' => [0, 1, 2, 3]])->count();
//                if ($bc_app_count != 0 and $bc_app_count2 == 0) {
//                    $new_bc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1, 'status_new' => 2])->one();
//                    if ($new_bc != null) {
//                        $gp->standby10_id = $new_bc->id;
//                        $gp->save();
//                        $new_bc->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                        $new_bc->selection_by = 11;
//                        $new_bc->selection_datetime = new \yii\db\Expression('NOW()');
//                        $new_bc->action_type = SrlmBcApplication::ACTION_TYPE_SELECTION;
//                        $new_bc->save();
//                    } else {
//                        $bc_models = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1])->all();
//                        if (count($bc_models)) {
//                            if (count($bc_models) == 1) {
//                                $gp->standby10_id = $bc_models[0]->id;
//
//                                $gp->save();
//                                $standby10_model = $bc_models[0];
//                                $standby10_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                                $standby10_model->selection_by = 11;
//                                $standby10_model->selection_datetime = new \yii\db\Expression('NOW()');
//                                $standby10_model->action_type = SrlmBcApplication::ACTION_TYPE_SELECTION;
//                                $standby10_model->save();
//                            } else {
//                                $chairperson = [];
//                                $samuhsakhi = [];
//                                $shgmember = [];
//                                $nomemeber = [];
//                                foreach ($bc_models as $model) {
//                                    if ($model->already_group_member == "2")
//                                        array_push($chairperson, $model);
//                                    else if ($model->already_group_member == "7")
//                                        array_push($samuhsakhi, $model);
//                                    else if ($model->already_group_member == "1")
//                                        array_push($nomemeber, $model);
//                                    else
//                                        array_push($shgmember, $model);
//                                }
//                                usort($chairperson, array($this, "cmp_overall"));
//                                usort($samuhsakhi, array($this, "cmp_overall"));
//                                usort($shgmember, array($this, "cmp_overall"));
//                                usort($nomemeber, array($this, "cmp_overall"));
//                                if (count($chairperson) > 0) {
//                                    $standby10_model = $chairperson[0];
//                                } else if (count($samuhsakhi) > 0) {
//                                    $standby10_model = $samuhsakhi[0];
//                                } else if (count($shgmember) > 0) {
//                                    $standby10_model = $shgmember[0];
//                                } else if (count($nomemeber) > 0) {
//                                    $standby10_model = $nomemeber[0];
//                                }
//                                if ($standby10_model != null) {
//                                    $gp->standby10_id = $standby10_model->id;
//                                    $gp->save();
//                                    $standby10_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                                    $standby10_model->selection_by = 11;
//                                    $standby10_model->selection_datetime = new \yii\db\Expression('NOW()');
//                                    $standby10_model->action_type = SrlmBcApplication::ACTION_TYPE_SELECTION;
//                                    $standby10_model->save();
//                                }
//                            }
//                        }
//                    }
//                } else {
//                    echo PHP_EOL;
//                    echo $gp->gram_panchayat_code;
//                    echo "Error2";
//                }
//            }
//        }
//    }
//    public function actionLot14() {
//
//        $standby11 = \bc\models\master\MasterGramPanchayatDetailBc::find()->andWhere(['NOT', ['standby13_id' => null]])->all();
//        if ($standby11 == null) {
//            $vacant_gps = \bc\models\master\MasterGramPanchayatDetailBc::find()->joinWith(['gp'])->where("`issue` = 0  AND master_gram_panchayat_detail_bc.six_vacant=1 and master_gram_panchayat_detail_bc.six_complete!=0 AND `current_status` NOT IN (0,1,2,3)")->andWhere(['master_gram_panchayat.status' => 1])->all();
//            echo count($vacant_gps);
//            foreach ($vacant_gps as $vacant_gp) {
//                $gp = \bc\models\master\MasterGramPanchayatDetailBc::findOne(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code]);
//                $bc_app_count = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->count();
//                $bc_app_count2 = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 2])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->andWhere(['training_status' => [0, 1, 2, 3]])->count();
//                if ($bc_app_count != 0 and $bc_app_count2 == 0) {
//                    $new_bc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1, 'status_new' => 2])->one();
//                    if ($new_bc != null) {
//                        $gp->standby13_id = $new_bc->id;
//                        $gp->save();
//                        $new_bc->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                        $new_bc->selection_by = 14;
//                        $new_bc->selection_datetime = new \yii\db\Expression('NOW()');
//                        $new_bc->action_type = SrlmBcApplication::ACTION_TYPE_SELECTION;
//                        $new_bc->save();
//                    } else {
//                        $bc_models = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1])->all();
//                        if (count($bc_models)) {
//                            if (count($bc_models) == 1) {
//                                $gp->standby13_id = $bc_models[0]->id;
//
//                                $gp->save();
//                                $standby11_model = $bc_models[0];
//                                $standby11_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                                $standby11_model->selection_by = 14;
//                                $standby11_model->selection_datetime = new \yii\db\Expression('NOW()');
//                                $standby11_model->action_type = SrlmBcApplication::ACTION_TYPE_SELECTION;
//                                $standby11_model->save();
//                            } else {
//                                $chairperson = [];
//                                $samuhsakhi = [];
//                                $shgmember = [];
//                                $nomemeber = [];
//                                foreach ($bc_models as $model) {
//                                    if ($model->already_group_member == "2")
//                                        array_push($chairperson, $model);
//                                    else if ($model->already_group_member == "7")
//                                        array_push($samuhsakhi, $model);
//                                    else if ($model->already_group_member == "1")
//                                        array_push($nomemeber, $model);
//                                    else
//                                        array_push($shgmember, $model);
//                                }
//                                usort($chairperson, array($this, "cmp_overall"));
//                                usort($samuhsakhi, array($this, "cmp_overall"));
//                                usort($shgmember, array($this, "cmp_overall"));
//                                usort($nomemeber, array($this, "cmp_overall"));
//                                if (count($chairperson) > 0) {
//                                    $standby11_model = $chairperson[0];
//                                } else if (count($samuhsakhi) > 0) {
//                                    $standby11_model = $samuhsakhi[0];
//                                } else if (count($shgmember) > 0) {
//                                    $standby11_model = $shgmember[0];
//                                } else if (count($nomemeber) > 0) {
//                                    $standby11_model = $nomemeber[0];
//                                }
//                                if ($standby11_model != null) {
//                                    $gp->standby13_id = $standby11_model->id;
//                                    $gp->save();
//                                    $standby11_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                                    $standby11_model->selection_by = 14;
//                                    $standby11_model->selection_datetime = new \yii\db\Expression('NOW()');
//                                    $standby11_model->action_type = SrlmBcApplication::ACTION_TYPE_SELECTION;
//                                    $standby11_model->save();
//                                }
//                            }
//                        }
//                    }
//                } else {
//                    echo PHP_EOL;
//                    echo $gp->gram_panchayat_code;
//                    echo "Error2";
//                }
//            }
//        }
//    }
//    public function actionLot15() {
//
//        $standby11 = \bc\models\master\MasterGramPanchayatDetailBc::find()->andWhere(['NOT', ['standby14_id' => null]])->all();
//        if ($standby11 == null) {
//            $vacant_gps = \bc\models\master\MasterGramPanchayatDetailBc::find()->joinWith(['gp'])->where("`issue` = 0 AND `current_available` > 0 AND `current_status` NOT IN (0,1,2,3) and master_gram_panchayat.status =1")->andWhere(['master_gram_panchayat.status' => 1])->all();
//            echo count($vacant_gps);
//            foreach ($vacant_gps as $vacant_gp) {
//                $gp = \bc\models\master\MasterGramPanchayatDetailBc::findOne(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code]);
//                $bc_app_count = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 1])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->count();
//                $bc_app_count2 = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gp->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 2])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6])->andWhere(['training_status' => [0, 1, 2, 3]])->count();
//                if ($bc_app_count != 0 and $bc_app_count2 == 0) {
//                    $new_bc = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1, 'status_new' => 2])->one();
//                    if ($new_bc != null) {
//                        $gp->standby14_id = $new_bc->id;
//                        $gp->save();
//                        $new_bc->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                        $new_bc->selection_by = 15;
//                        $new_bc->selection_datetime = new \yii\db\Expression('NOW()');
//                        $new_bc->action_type = SrlmBcApplication::ACTION_TYPE_SELECTION;
//                        $new_bc->save();
//                    } else {
//                        $bc_models = SrlmBcApplication::find()->where(['gram_panchayat_code' => $vacant_gp->gram_panchayat_code, 'gender' => 2, 'form_number' => 6, 'status' => 1])->all();
//                        if (count($bc_models)) {
//                            if (count($bc_models) == 1) {
//                                $gp->standby14_id = $bc_models[0]->id;
//
//                                $gp->save();
//                                $standby11_model = $bc_models[0];
//                                $standby11_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                                $standby11_model->selection_by = 15;
//                                $standby11_model->selection_datetime = new \yii\db\Expression('NOW()');
//                                $standby11_model->action_type = SrlmBcApplication::ACTION_TYPE_SELECTION;
//                                $standby11_model->save();
//                            } else {
//                                $chairperson = [];
//                                $samuhsakhi = [];
//                                $shgmember = [];
//                                $nomemeber = [];
//                                foreach ($bc_models as $model) {
//                                    if ($model->already_group_member == "2")
//                                        array_push($chairperson, $model);
//                                    else if ($model->already_group_member == "7")
//                                        array_push($samuhsakhi, $model);
//                                    else if ($model->already_group_member == "1")
//                                        array_push($nomemeber, $model);
//                                    else
//                                        array_push($shgmember, $model);
//                                }
//                                usort($chairperson, array($this, "cmp_overall"));
//                                usort($samuhsakhi, array($this, "cmp_overall"));
//                                usort($shgmember, array($this, "cmp_overall"));
//                                usort($nomemeber, array($this, "cmp_overall"));
//                                if (count($chairperson) > 0) {
//                                    $standby11_model = $chairperson[0];
//                                } else if (count($samuhsakhi) > 0) {
//                                    $standby11_model = $samuhsakhi[0];
//                                } else if (count($shgmember) > 0) {
//                                    $standby11_model = $shgmember[0];
//                                } else if (count($nomemeber) > 0) {
//                                    $standby11_model = $nomemeber[0];
//                                }
//                                if ($standby11_model != null) {
//                                    $gp->standby14_id = $standby11_model->id;
//                                    $gp->save();
//                                    $standby11_model->status = SrlmBcApplication::STATUS_PROVISIONAL;
//                                    $standby11_model->selection_by = 15;
//                                    $standby11_model->selection_datetime = new \yii\db\Expression('NOW()');
//                                    $standby11_model->action_type = SrlmBcApplication::ACTION_TYPE_SELECTION;
//                                    $standby11_model->save();
//                                }
//                            }
//                        }
//                    }
//                } else {
//                    echo PHP_EOL;
//                    echo $gp->gram_panchayat_code;
//                    echo "Error2";
//                }
//            }
//        }
//    }

    public function actionUrban2() {
        $null = new \yii\db\Expression('NULL');
        $sql = "SELECT * FROM gp_urban WHERE gp_covert_urban=0 ";
        $connection = \Yii::$app->dbbc;
        $insql = $connection->createCommand($sql);
        $result = $insql->queryAll();
        foreach ($result as $gp) {
            $gp_code = $gp['gram_panchayat_code'];
            $gp = new \common\components\Gp();
            if ($gp->urban($gp_code)) {
                
            }
        }
    }

//    public function actionRevert2() {
//        $null = new \yii\db\Expression('NULL');
//        $sql = "SELECT * FROM gp_urban WHERE gp_covert_urban=0 ";
//        $connection = \Yii::$app->dbbc;
//        $insql = $connection->createCommand($sql);
//        $result = $insql->queryAll();
//        foreach ($result as $gp) {
//            $gp_code = $gp['gram_panchayat_code'];
//            $gp = new \common\components\Gp();
//            if ($gp->reverrural($gp_code)) {
//                
//            }
//        }
//    }
    public function actionRevert($gp_code) {
        $gp = new \common\components\Gp();
        if ($gp->reverrural($gp_code)) {
            echo 'Revert : ' . $gp_code;
        }
    }

    public function actionGpbconboard() {
        $models = \bc\models\master\MasterGramPanchayat::find()->where(['status' => 1])->all();
        foreach ($models as $model) {
            $bc_onboard = SrlmBcApplication::find()->select(['id'])->where(['gram_panchayat_code' => $model->gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 2])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6, 'srlm_bc_application.training_status' => 3])->andWhere(['not', ['srlm_bc_application.bankidbc' => null]])->count();
            $condition1 = ['and',
                ['=', 'gram_panchayat_code', $model->gram_panchayat_code],
            ];
            if ($bc_onboard) {
                \bc\models\master\MasterGramPanchayat::updateAll([
                    'bc_status' => 1,
                        ], $condition1);
            }
        }
        echo "Gp Coplete time : " . date('Y-m-d H:i:s') . PHP_EOL;
        return ExitCode::OK;
    }
}
