<?php

namespace bc\modules\transaction\commands;

use Yii;
use yii\helpers\Json;
use yii\console\Controller;
use yii\base\Model;
use bc\modules\selection\models\SrlmBcApplication;
use bc\models\master\MasterPartnerBank;
use console\helpers\Utility;
use bc\modules\transaction\models\summary\BcTransactionBcSummary;
use bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly;
use common\models\dynamicdb\bc\bcsakhi\BcsakhiTransactionBcSummary;
use common\models\dynamicdb\bc\bcsakhi\BcsakhiTransactionBcSummaryMonthly;
use common\models\dynamicdb\bc\bcsakhi\BcsakhiTransactionMonthlyReport;
use bc\modules\transaction\models\summary\BcTransactionMasterMonth;
use bc\models\GramPanchayatBcActiveProgressMonthly;
use bc\models\DistrictBcActiveProgressMonthly;
use bc\models\master\MasterGramPanchayat;
use bc\models\master\MasterDistrict;

class DistrictController extends Controller {

    public $start_month_id;
    public $end_month_id;

    public function beforeAction($action) {
        $this->start_month_id = 6;
        $this->end_month_id = 55;
        return parent::beforeAction($action);
    }

    public function progress($month) {
        echo "District Progress Monthly Start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        if (isset($month->id)) {
            $models = MasterDistrict::find()->select(['district_code', 'district_name'])->all();
            foreach ($models as $model) {
                $progress = DistrictBcActiveProgressMonthly::findOne(['district_code' => $model->district_code, 'month_id' => $month->id]);
                if ($progress == null) {
                    $progress = new DistrictBcActiveProgressMonthly();
                }
                $progress->district_code = $model->district_code;
                $progress->month_id = $month->id;
                $bc_active = GramPanchayatBcActiveProgressMonthly::find()->where(['district_code' => $model->district_code, 'month_id' => $month->id])->sum('bc_active');
                $no_of_transaction = GramPanchayatBcActiveProgressMonthly::find()->where(['district_code' => $model->district_code, 'month_id' => $month->id])->sum('no_of_transaction');
                $transaction_amount = GramPanchayatBcActiveProgressMonthly::find()->where(['district_code' => $model->district_code, 'month_id' => $month->id])->sum('transaction_amount');
                $commission_amount = GramPanchayatBcActiveProgressMonthly::find()->where(['district_code' => $model->district_code, 'month_id' => $month->id])->sum('commission_amount');
                if ($bc_active) {
                    $progress->bc_active = $bc_active;
                }
                if ($no_of_transaction) {
                    $progress->no_of_transaction = $no_of_transaction;
                }
                if ($transaction_amount) {
                    $progress->transaction_amount = $transaction_amount;
                }
                if ($commission_amount) {
                    $progress->commission_amount = $commission_amount;
                }

                $progress->save();
            }
        }
        echo "District Progress Monthly End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
    }

    public function actionMonthly($start_month_id, $end_month_id) {
        $this->start_month_id = $start_month_id;
        $this->end_month_id = $end_month_id;
        echo "Start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $month_end_date = $date->format('Y-m-d');
        $month_models = BcTransactionMasterMonth::find()->where(['>=', 'id', $this->start_month_id])->andWhere(['<=', 'id', $this->end_month_id])->all();
        foreach ($month_models as $month) {
            $this->progress($month);
        }

        echo "End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
    }
}
