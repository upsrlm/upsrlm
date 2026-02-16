<?php

namespace console\controllers;

use Yii;
use bc\modules\transaction\models\dump\BcTransactionFiles;
use bc\modules\transaction\models\summary\BcTransactionBankSummary;
use bc\modules\transaction\models\summary\BcTransactionBcSummary;
use bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily;
use bc\modules\transaction\models\summary\BcTransactionBcSummaryWeekly;
use bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly;
use bc\modules\transaction\models\summary\BcTrackingBcDateRange;
use bc\modules\transaction\models\summary\BcTrackingBcDateRangeHistory;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\transaction\models\summary\MasterGramPanchayat;

class BctrackingController extends \yii\console\Controller {

    public $DumoModelClass = '\bc\modules\transaction\models\dump\BcTransactionDump';
    public $BankModelClass = '\bc\modules\transaction\models\dump\BcTransactionBank';
    public $bctable = 'bc_transaction_bc_';
    public $bcdbconnectionname = 'bctransactiondistrict';
    public $start_date;
    public $end_date;
    public $days;

    public function beforeAction($action) {
        $this->start_date = date("Y-m-d", strtotime("-16 day"));
        $this->end_date = date("Y-m-d", strtotime("-1 day"));
        $this->days = \common\helpers\Utility::daysBetween($this->start_date, $this->end_date);
        return parent::beforeAction($action);
    }

    public function actionTest() {

        exit;
    }

    public function actionPop() {
        $null = new \yii\db\Expression('NULL');
        try {
            echo "BC tracking table populate Start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
            \Yii::$app->getModule('transaction')->bctransactionsummary->createCommand()->truncateTable('bc_tracking_bc_date_range')->execute();
            $transaction_models = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->joinWith(['gp'])->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.status' => 1])->andWhere([BcTransactionBcSummary::getTableSchema()->fullName . '.district_code' => \Yii::$app->params['bc_tracking_disricts']])->all();
            foreach ($transaction_models as $transaction) {
                if ($transaction->bc->training_status == 3) {
                    $sql = "SELECT SUM(no_of_transaction) as no_of_transaction,SUM(no_of_actual_transaction) as no_of_actual_transaction,SUM(zero_transaction) as zero_transaction,sum(transaction_amount) as transaction_amount,SUM(commission_amount) as commission_amount,COUNT(date) as day_count FROM `bc_transaction_bc_summary_daily` where bc_application_id=" . $transaction->bc_application_id . " and date>='" . $this->start_date . "' and date<'" . $this->end_date . "'";
                    $range = BcTransactionBcSummaryDaily::findBySql($sql)->one();
                    $user = \common\models\User::findOne($transaction->bc->user_id);
                    $bc_tracking = new BcTrackingBcDateRange();
                    $bc_tracking->bc_application_id = $transaction->bc_application_id;
                    $bc_tracking->bc_name = $transaction->bc->name;
                    $bc_tracking->user_id = $transaction->bc->user_id;
                    $bc_tracking->mobile_no = $transaction->bc->mobile_no;
                    if ($user != null) {
                        $bc_tracking->pin = $user->otp_value;
                    }
                    $bc_tracking->bankidbc = $transaction->bankidbc;
                    $bc_tracking->district_code = $transaction->district_code;
                    $bc_tracking->block_code = $transaction->block_code;
                    $bc_tracking->gram_panchayat_code = $transaction->gram_panchayat_code;
                    $bc_tracking->master_partner_bank_id = $transaction->master_partner_bank_id;
                    $bc_tracking->district_name = $transaction->bc->district_name;
                    $bc_tracking->block_name = $transaction->bc->block_name;
                    $bc_tracking->gram_panchayat_name = $transaction->bc->gram_panchayat_name;
                    $bc_tracking->banking_partner_name = $transaction->pbank->bank_name;
                    $bc_tracking->transaction_start_date = $transaction->transaction_start_date;
                    $bc_tracking->total_day = $transaction->total_day;
                    $bc_tracking->total_working_day = $transaction->total_working_day;
                    $bc_tracking->total_not_working_day = $transaction->total_not_working_day;
                    $bc_tracking->total_no_of_transaction = $transaction->no_of_transaction;
                    $bc_tracking->total_no_of_actual_transaction = $transaction->no_of_actual_transaction;
                    $bc_tracking->total_zero_transaction = $transaction->zero_transaction;
                    $bc_tracking->total_transaction_amount = $transaction->transaction_amount;
                    $bc_tracking->total_commission_amount = $transaction->commission_amount;
                    $bc_tracking->start_month_id = $transaction->start_month_id;
                    $bc_tracking->start_month_name = $transaction->start_month_name;
                    $bc_tracking->last_month_id = $transaction->last_month_id;
                    $bc_tracking->last_month_name = $transaction->last_month_name;

                    $bc_tracking->working_day = $range->day_count;
                    $bc_tracking->not_working_day = ($this->days - $bc_tracking->working_day);
                    if ($range->no_of_transaction) {
                        $bc_tracking->no_of_transaction = $range->no_of_transaction;
                    }
                    if ($range->no_of_actual_transaction) {
                        $bc_tracking->no_of_actual_transaction = $range->no_of_actual_transaction;
                    }
                    if ($range->zero_transaction) {
                        $bc_tracking->zero_transaction = $range->zero_transaction;
                    }
                    if ($range->transaction_amount) {
                        $bc_tracking->transaction_amount = $range->transaction_amount;
                    }
                    if ($range->commission_amount) {
                        $bc_tracking->commission_amount = $range->commission_amount;
                    }
                    $bc_tracking->days = $this->days;
                    $bc_tracking->date_from = $this->start_date;
                    $bc_tracking->date_to = $this->end_date;

                    if ($bc_tracking->save()) {
                        
                    }
                } else {
                    echo $transaction->bc->id . PHP_EOL;
                }
            }

            echo "BC tracking table populate End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        } catch (\Exception $exc) {
            echo $exc->getMessage();
        }
    }
}
