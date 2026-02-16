<?php

namespace console\controllers;

use Yii;
use yii\helpers\Json;
use yii\console\Controller;
use yii\base\Model;
use console\helpers\Utility;
use common\models\master\MasterDistrict;
use common\models\master\MasterBlock;
use bc\models\master\MasterGramPanchayat;
use bc\modules\selection\models\SrlmBcApplication;
use bc\models\master\MasterPartnerBank;
use bc\models\PartnerBankPendencyTimeline;
use bc\modules\transaction\models\summary\BcTransactionBcSummary;
use bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly;
use bc\modules\transaction\models\summary\BcTransactionBcSummaryWeekly;
use bc\models\DistrictPerformanceBcsakhiProgram;
use bc\modules\selection\models\BcHonorariumPayment;
use bc\modules\training\models\RsetisBatchParticipants;

class PerformanceController extends Controller {

    public $certified_bc = 0;
    public $operational = 0;
    public $date;
    public $last_updated_on;
    public $from_month_id = 50;
    public $to_month_id = 52;

    public function actionDistrict() {
        $models = MasterDistrict::find()->orderBy(['district_name' => SORT_ASC])->all();
        foreach ($models as $model) {
            $pmodel = DistrictPerformanceBcsakhiProgram::findOne(['district_code' => $model->district_code, 'master_partner_bank_id' => 0]);
            $con = \Yii::$app->getModule('transaction')->bctransactionsummary;
            $sql = "SELECT 
           SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END) AS operational,
           COUNT(bc_application_id) as no_of_bc,
           SUM(no_of_transaction) as no_of_transaction,
           SUM(transaction_amount) as transaction_amount,
           SUM(commission_amount) as commission_amount,
           FLOOR(COUNT(bc_application_id)/SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END)) as avg_bc, 
           FLOOR(SUM(total_working_day)/COUNT(bc_application_id)) as avg_working_days,
           FLOOR(SUM(no_of_transaction)/COUNT(bc_application_id)) as avg_transaction_no,
           FLOOR(SUM(transaction_amount)/COUNT(bc_application_id)) as avg_txn_amount,
           FLOOR(SUM(commission_amount)/COUNT(bc_application_id)) as avg_com_amount
           FROM `bc_transaction_bc_summary_monthly` ";
            $where = " where bc_transaction_bc_summary_monthly.status >= 0";
            $where .= ' and bc_transaction_bc_summary_monthly.district_code=' . $model->district_code;
            if ($this->from_month_id) {
                $where .= ' and bc_transaction_bc_summary_monthly.month_id >=' . $this->from_month_id;
            }
            if ($this->to_month_id) {
                $where .= ' and bc_transaction_bc_summary_monthly.month_id <=' . $this->to_month_id;
            }
            $sql .= $where;
            $result = $con->createCommand($sql)->queryAll();
            if ($pmodel == null) {
                $pmodel = new DistrictPerformanceBcsakhiProgram();
            }
            $pmodel->district_code = $model->district_code;
            $pmodel->district_name = $model->district_name;
            $pmodel->master_partner_bank_id = 0;
            $pmodel->no_of_gp = MasterGramPanchayat::find()->select(['id'])->where(['district_code' => $model->district_code, 'status' => 1])->count();
            $pmodel->no_of_gp_urban = MasterGramPanchayat::find()->select(['id'])->where(['district_code' => $model->district_code, 'status' => 0])->count();
            $pmodel->no_of_bc_shortlist = SrlmBcApplication::find()->where(['district_code' => $model->district_code, 'gender' => 2, 'form_number' => 6, 'status' => 2])->count();
            $pmodel->no_of_certitfied_bc = SrlmBcApplication::find()->select(['id'])->where(['srlm_bc_application.status' => 2, 'srlm_bc_application.training_status' => 3, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.district_code' => $model->district_code])->count();
            $pmodel->no_of_certitfied_bc_unwilling = SrlmBcApplication::find()->where(['district_code' => $model->district_code, 'training_status' => 32])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $pmodel->no_of_unwillimg_bc = SrlmBcApplication::find()->where(['district_code' => $model->district_code, 'training_status' => -2])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $pmodel->no_of_bc_registered_for_training = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.district_code' => $model->district_code])->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH, SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_UNWILLING, SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING, 34, 35]])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $pmodel->urban = SrlmBcApplication::find()->where(['district_code' => $model->district_code, 'gender' => 2, 'form_number' => 6, 'status' => 2])->andWhere(['srlm_bc_application.urban_shg' => 1])->count();
            $pmodel->blocked_bc = SrlmBcApplication::find()->where(['district_code' => $model->district_code])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['!=', 'srlm_bc_application.blocked', 0])->count();
            $pmodel->no_of_bc_unqualified = SrlmBcApplication::find()->where(['district_code' => $model->district_code, 'training_status' => 4])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['!=', 'srlm_bc_application.blocked', 0])->count();
            $pmodel->no_of_bc_ineligible = SrlmBcApplication::find()->where(['district_code' => $model->district_code, 'training_status' => 5])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['!=', 'srlm_bc_application.blocked', 0])->count();
            $pmodel->no_of_bc_absent_iibf_exam = SrlmBcApplication::find()->where(['district_code' => $model->district_code, 'training_status' => 6])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['!=', 'srlm_bc_application.blocked', 0])->count();
            $pmodel->per_certified_bc = round(($pmodel->no_of_certitfied_bc * 100) / $pmodel->no_of_gp, 1);
            $pmodel->per_certified_bc_unwilling = round(($pmodel->no_of_certitfied_bc_unwilling * 100) / $pmodel->no_of_gp, 1);
            $pmodel->upsrlm_payment_of_bc_support_fund = SrlmBcApplication::find()->select(['id'])->where(['srlm_bc_application.status' => 2, 'srlm_bc_application.training_status' => 3, 'srlm_bc_application.bc_shg_funds_status' => 1, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.district_code' => $model->district_code])->count();
            $pmodel->upsrlm_payment_of_bc_support_fund_per = round(($pmodel->upsrlm_payment_of_bc_support_fund * 100) / $pmodel->no_of_certitfied_bc, 1);
            $pmodel->upsrlm_payment_of_bc_honorarium = SrlmBcApplication::find()->select(['id'])->where(['srlm_bc_application.status' => 2, 'srlm_bc_application.training_status' => 3, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.district_code' => $model->district_code])->andWhere(['>', 'bc_payment_count', 0])->count();
            $pmodel->upsrlm_payment_of_bc_honorarium_per = round(($pmodel->upsrlm_payment_of_bc_honorarium * 100) / $pmodel->no_of_certitfied_bc, 1);
            $pmodel->upsrlm_payment_of_bc_honorarium1 = BcHonorariumPayment::find()->joinWith(['bc'])->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => $model->district_code])->andWhere(['not', ['month1' => null]])->count();
            $pmodel->upsrlm_payment_of_bc_honorarium2 = BcHonorariumPayment::find()->joinWith(['bc'])->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => $model->district_code])->andWhere(['not', ['month2' => null]])->count();
            $pmodel->upsrlm_payment_of_bc_honorarium3 = BcHonorariumPayment::find()->joinWith(['bc'])->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => $model->district_code])->andWhere(['not', ['month3' => null]])->count();
            $pmodel->upsrlm_payment_of_bc_honorarium4 = BcHonorariumPayment::find()->joinWith(['bc'])->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => $model->district_code])->andWhere(['not', ['month4' => null]])->count();
            $pmodel->upsrlm_payment_of_bc_honorarium5 = BcHonorariumPayment::find()->joinWith(['bc'])->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => $model->district_code])->andWhere(['not', ['month5' => null]])->count();
            $pmodel->upsrlm_payment_of_bc_honorarium6 = BcHonorariumPayment::find()->joinWith(['bc'])->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => $model->district_code])->andWhere(['not', ['month6' => null]])->count();
            $pmodel->certified_bc_rating = $pmodel->per_certified_bc > '89' ? '10' : '0';
            $pmodel->certified_bc_unwilling_rating = $pmodel->per_certified_bc_unwilling < '25' ? '5' : '0';
            $pmodel->upsrlm_payment_of_bc_support_fund_rating = $pmodel->upsrlm_payment_of_bc_support_fund_per > '89' ? '10' : '0';
            $pmodel->upsrlm_payment_of_bc_honorarium_rating = $pmodel->upsrlm_payment_of_bc_honorarium_per > '89' ? '10' : '0';
            $partner_agency_avg_no_of_working_days_rating = 0;
            $partner_agency_avg_no_of_txn_rating = 0;
            $partner_agency_avg_com_earning_rating = 0;
            if ($pmodel->partner_agency_avg_no_of_working_days > 25) {
                $partner_agency_avg_no_of_working_days_rating = 10;
            } elseif ($pmodel->partner_agency_avg_no_of_working_days > 15 and $pmodel->partner_agency_avg_no_of_working_days < 26) {
                $partner_agency_avg_no_of_working_days_rating = 5;
            } else {
                $partner_agency_avg_no_of_working_days_rating = 0;
            }
            $pmodel->partner_agency_avg_no_of_working_days_rating = $partner_agency_avg_no_of_working_days_rating;
            if ($pmodel->partner_agency_avg_no_of_txn > 100) {
                $partner_agency_avg_no_of_txn_rating = 10;
            } elseif ($pmodel->partner_agency_avg_no_of_txn > 49 and $pmodel->partner_agency_avg_no_of_txn < 101) {
                $partner_agency_avg_no_of_txn_rating = 5;
            } else {
                $partner_agency_avg_no_of_txn_rating = 0;
            }
            $pmodel->partner_agency_avg_no_of_txn_rating = $partner_agency_avg_no_of_txn_rating;
            if ($pmodel->partner_agency_avg_com_earning > 25000) {
                $partner_agency_avg_com_earning_rating = 50;
            } elseif ($pmodel->partner_agency_avg_com_earning > 9999 and $pmodel->partner_agency_avg_com_earning < 25000) {
                $partner_agency_avg_com_earning_rating = 25;
            } else {
                $partner_agency_avg_com_earning_rating = 0;
            }
            $pmodel->partner_agency_avg_com_earning_rating = $partner_agency_avg_com_earning_rating;
            $pmodel->composite_rank = ($pmodel->certified_bc_rating+$pmodel->certified_bc_unwilling_rating+$pmodel->upsrlm_payment_of_bc_support_fund_rating+$pmodel->upsrlm_payment_of_bc_honorarium_rating+$pmodel->partner_agency_avg_no_of_working_days_rating+$pmodel->partner_agency_avg_no_of_txn_rating+$pmodel->partner_agency_avg_com_earning_rating);
            $pmodel->last_update_on = date('Y-m-d H:i:s');

            if (isset($result[0])) {
                $pmodel->partner_agency_avg_no_of_working_days = isset($result[0]['avg_working_days']) ? $result[0]['avg_working_days'] : 0;
                $pmodel->partner_agency_avg_no_of_txn = isset($result[0]['avg_transaction_no']) ? $result[0]['avg_transaction_no'] : 0;
                $pmodel->partner_agency_avg_no_of_txn_amount = isset($result[0]['avg_txn_amount']) ? $result[0]['avg_txn_amount'] : 0;
                $pmodel->partner_agency_avg_com_earning = isset($result[0]['avg_com_amount']) ? $result[0]['avg_com_amount'] : 0;
            }
            $pmodel->save();
        }
    }

    public function actionPartner() {




        $models = \bc\models\master\MasterPartnerBankDistrict::find()->andWhere(['!=', 'master_partner_bank_id', 6])->orderBy(['master_partner_bank_id' => SORT_ASC])->all();
        foreach ($models as $model) {
            try {
                $pmodel = DistrictPerformanceBcsakhiProgram::findOne(['district_code' => $model->district_code, 'master_partner_bank_id' => $model->master_partner_bank_id]);
                $con = \Yii::$app->getModule('transaction')->bctransactionsummary;
                $sql = "SELECT 
           SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END) AS operational,
           COUNT(bc_application_id) as no_of_bc,
           SUM(no_of_transaction) as no_of_transaction,
           SUM(transaction_amount) as transaction_amount,
           SUM(commission_amount) as commission_amount,
           FLOOR(COUNT(bc_application_id)/SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END)) as avg_bc, 
           FLOOR(SUM(total_working_day)/COUNT(bc_application_id)) as avg_working_days,
           FLOOR(SUM(no_of_transaction)/COUNT(bc_application_id)) as avg_transaction_no,
           FLOOR(SUM(transaction_amount)/COUNT(bc_application_id)) as avg_txn_amount,
           FLOOR(SUM(commission_amount)/COUNT(bc_application_id)) as avg_com_amount
           FROM `bc_transaction_bc_summary_monthly` ";
                $where = " where bc_transaction_bc_summary_monthly.status >= 0";
                $where .= ' and bc_transaction_bc_summary_monthly.district_code=' . $model->district_code;
                $where .= ' and bc_transaction_bc_summary_monthly.master_partner_bank_id=' . $model->master_partner_bank_id;
                if ($this->from_month_id) {
                    $where .= ' and bc_transaction_bc_summary_monthly.month_id >=' . $this->from_month_id;
                }
                if ($this->to_month_id) {
                    $where .= ' and bc_transaction_bc_summary_monthly.month_id <=' . $this->to_month_id;
                }
                $sql .= $where;
                $result = $con->createCommand($sql)->queryAll();
                if ($pmodel == null) {
                    $pmodel = new DistrictPerformanceBcsakhiProgram();
                }
                $pmodel->district_code = $model->district_code;
                $pmodel->district_name = $model->district->district_name;
                $pmodel->master_partner_bank_id = $model->master_partner_bank_id;
                $pmodel->no_of_gp = MasterGramPanchayat::find()->select(['id'])->where(['district_code' => $model->district_code, 'status' => 1])->count();
                $pmodel->no_of_gp_urban = MasterGramPanchayat::find()->select(['id'])->where(['district_code' => $model->district_code, 'status' => 0])->count();
                $pmodel->no_of_bc_shortlist = SrlmBcApplication::find()->where(['district_code' => $model->district_code, 'gender' => 2, 'form_number' => 6, 'status' => 2])->count();
                $pmodel->no_of_certitfied_bc = SrlmBcApplication::find()->select(['id'])->where(['srlm_bc_application.status' => 2, 'srlm_bc_application.training_status' => 3, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.district_code' => $model->district_code])->count();
                $pmodel->no_of_certitfied_bc_unwilling = SrlmBcApplication::find()->where(['district_code' => $model->district_code, 'training_status' => 32])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['srlm_bc_application.blocked' => 0])->count();
                $pmodel->no_of_unwillimg_bc = SrlmBcApplication::find()->where(['district_code' => $model->district_code, 'training_status' => -2])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['srlm_bc_application.blocked' => 0])->count();
                $pmodel->no_of_bc_registered_for_training = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.district_code' => $model->district_code])->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH, SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_UNWILLING, SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING, 34, 35]])->andWhere(['srlm_bc_application.blocked' => 0])->count();
                $pmodel->urban = SrlmBcApplication::find()->where(['district_code' => $model->district_code, 'gender' => 2, 'form_number' => 6, 'status' => 2])->andWhere(['srlm_bc_application.urban_shg' => 1])->count();
                $pmodel->blocked_bc = SrlmBcApplication::find()->where(['district_code' => $model->district_code])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['!=', 'srlm_bc_application.blocked', 0])->count();
                $pmodel->no_of_bc_unqualified = SrlmBcApplication::find()->where(['district_code' => $model->district_code, 'training_status' => 4])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['!=', 'srlm_bc_application.blocked', 0])->count();
                $pmodel->no_of_bc_ineligible = SrlmBcApplication::find()->where(['district_code' => $model->district_code, 'training_status' => 5])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['!=', 'srlm_bc_application.blocked', 0])->count();
                $pmodel->no_of_bc_absent_iibf_exam = SrlmBcApplication::find()->where(['district_code' => $model->district_code, 'training_status' => 6])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['!=', 'srlm_bc_application.blocked', 0])->count();
                $pmodel->per_certified_bc = round(($pmodel->no_of_certitfied_bc * 100) / $pmodel->no_of_gp, 1);
                $pmodel->per_certified_bc_unwilling = round(($pmodel->no_of_certitfied_bc_unwilling * 100) / $pmodel->no_of_gp, 1);
                $pmodel->upsrlm_payment_of_bc_support_fund = SrlmBcApplication::find()->select(['id'])->where(['srlm_bc_application.status' => 2, 'srlm_bc_application.training_status' => 3, 'srlm_bc_application.bc_shg_funds_status' => 1, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.district_code' => $model->district_code])->count();
                $pmodel->upsrlm_payment_of_bc_support_fund_per = round(($pmodel->upsrlm_payment_of_bc_support_fund * 100) / $pmodel->no_of_certitfied_bc, 1);
                $pmodel->upsrlm_payment_of_bc_honorarium = SrlmBcApplication::find()->select(['id'])->where(['srlm_bc_application.status' => 2, 'srlm_bc_application.training_status' => 3, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.district_code' => $model->district_code])->andWhere(['>', 'bc_payment_count', 0])->count();
                $pmodel->upsrlm_payment_of_bc_honorarium_per = round(($pmodel->upsrlm_payment_of_bc_honorarium * 100) / $pmodel->no_of_certitfied_bc, 1);
                $pmodel->upsrlm_payment_of_bc_honorarium1 = BcHonorariumPayment::find()->joinWith(['bc'])->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => $model->district_code])->andWhere(['not', ['month1' => null]])->count();
                $pmodel->upsrlm_payment_of_bc_honorarium2 = BcHonorariumPayment::find()->joinWith(['bc'])->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => $model->district_code])->andWhere(['not', ['month2' => null]])->count();
                $pmodel->upsrlm_payment_of_bc_honorarium3 = BcHonorariumPayment::find()->joinWith(['bc'])->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => $model->district_code])->andWhere(['not', ['month3' => null]])->count();
                $pmodel->upsrlm_payment_of_bc_honorarium4 = BcHonorariumPayment::find()->joinWith(['bc'])->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => $model->district_code])->andWhere(['not', ['month4' => null]])->count();
                $pmodel->upsrlm_payment_of_bc_honorarium5 = BcHonorariumPayment::find()->joinWith(['bc'])->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => $model->district_code])->andWhere(['not', ['month5' => null]])->count();
                $pmodel->upsrlm_payment_of_bc_honorarium6 = BcHonorariumPayment::find()->joinWith(['bc'])->andWhere([BcHonorariumPayment::getTableSchema()->fullName . '.district_code' => $model->district_code])->andWhere(['not', ['month6' => null]])->count();
                $pmodel->certified_bc_rating = $pmodel->per_certified_bc > '89' ? '10' : '0';
                $pmodel->certified_bc_unwilling_rating = $pmodel->per_certified_bc_unwilling < '25' ? '5' : '0';
                $pmodel->upsrlm_payment_of_bc_support_fund_rating = $pmodel->upsrlm_payment_of_bc_support_fund_per > '89' ? '10' : '0';
                $pmodel->upsrlm_payment_of_bc_honorarium_rating = $pmodel->upsrlm_payment_of_bc_honorarium_per > '89' ? '10' : '0';
                $partner_agency_avg_no_of_working_days_rating = 0;
                $partner_agency_avg_no_of_txn_rating = 0;
                $partner_agency_avg_com_earning_rating = 0;
                if ($pmodel->partner_agency_avg_no_of_working_days > 25) {
                    $partner_agency_avg_no_of_working_days_rating = 10;
                } elseif ($pmodel->partner_agency_avg_no_of_working_days > 15 and $pmodel->partner_agency_avg_no_of_working_days < 26) {
                    $partner_agency_avg_no_of_working_days_rating = 5;
                } else {
                    $partner_agency_avg_no_of_working_days_rating = 0;
                }
                $pmodel->partner_agency_avg_no_of_working_days_rating = $partner_agency_avg_no_of_working_days_rating;
                if ($pmodel->partner_agency_avg_no_of_txn > 100) {
                    $partner_agency_avg_no_of_txn_rating = 10;
                } elseif ($pmodel->partner_agency_avg_no_of_txn > 49 and $pmodel->partner_agency_avg_no_of_txn < 101) {
                    $partner_agency_avg_no_of_txn_rating = 5;
                } else {
                    $partner_agency_avg_no_of_txn_rating = 0;
                }
                $pmodel->partner_agency_avg_no_of_txn_rating = $partner_agency_avg_no_of_txn_rating;
                if ($pmodel->partner_agency_avg_com_earning > 25000) {
                    $partner_agency_avg_com_earning_rating = 50;
                } elseif ($pmodel->partner_agency_avg_com_earning > 9999 and $pmodel->partner_agency_avg_com_earning < 25000) {
                    $partner_agency_avg_com_earning_rating = 25;
                } else {
                    $partner_agency_avg_com_earning_rating = 0;
                }
                $pmodel->partner_agency_avg_com_earning_rating = $partner_agency_avg_com_earning_rating;
                $pmodel->composite_rank = ($pmodel->certified_bc_rating+$pmodel->certified_bc_unwilling_rating+$pmodel->upsrlm_payment_of_bc_support_fund_rating+$pmodel->upsrlm_payment_of_bc_honorarium_rating+$pmodel->partner_agency_avg_no_of_working_days_rating+$pmodel->partner_agency_avg_no_of_txn_rating+$pmodel->partner_agency_avg_com_earning_rating);
                $pmodel->last_update_on = date('Y-m-d H:i:s');

                if (isset($result[0])) {
                    $pmodel->partner_agency_avg_no_of_working_days = isset($result[0]['avg_working_days']) ? $result[0]['avg_working_days'] : 0;
                    $pmodel->partner_agency_avg_no_of_txn = isset($result[0]['avg_transaction_no']) ? $result[0]['avg_transaction_no'] : 0;
                    $pmodel->partner_agency_avg_no_of_txn_amount = isset($result[0]['avg_txn_amount']) ? $result[0]['avg_txn_amount'] : 0;
                    $pmodel->partner_agency_avg_com_earning = isset($result[0]['avg_com_amount']) ? $result[0]['avg_com_amount'] : 0;
                }
//                print_r($pmodel);
                $pmodel->save();
            } catch (\Exception $exc) {
                echo $exc->getMessage() . PHP_EOL;
                echo $exc->getLine() . PHP_EOL;
            }
        }
    }
}
