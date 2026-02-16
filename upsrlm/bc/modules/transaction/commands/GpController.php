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
use bc\models\master\MasterGramPanchayat;

class GpController extends Controller {

    public $start_month_id;
    public $end_month_id;

    public function beforeAction($action) {
        $this->start_month_id = 8;
        $this->end_month_id = 9;
        return parent::beforeAction($action);
    }

    public function progress($month) {
        echo "Gp Progress Monthly Start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        if (isset($month->id)) {
            $gps = MasterGramPanchayat::find()->select(['division_code', 'division_name', 'district_code', 'district_name', 'block_code', 'block_name', 'gram_panchayat_code', 'gram_panchayat_name'])->where(['status' => 1])->all();
            foreach ($gps as $gp) {
                $gp_progress = GramPanchayatBcActiveProgressMonthly::findOne(['gram_panchayat_code' => $gp->gram_panchayat_code, 'month_id' => $month->id]);
                if ($gp_progress == null) {
                    $gp_progress = new GramPanchayatBcActiveProgressMonthly();
                }
                $gp_progress->district_code = $gp->district_code;
                $gp_progress->block_code = $gp->block_code;
                $gp_progress->gram_panchayat_code = $gp->gram_panchayat_code;
                $gp_progress->gram_panchayat_name = $gp->gram_panchayat_name;
                $gp_progress->month_id = $month->id;
                $bc_monthly = BcTransactionBcSummaryMonthly::findOne(['gram_panchayat_code' => $gp->gram_panchayat_code, 'month_id' => $month->id]);
                if ($bc_monthly != null) {
                    $gp_progress->bc_active = 1;
                    $gp_progress->no_of_transaction = $bc_monthly->no_of_transaction;
                    $gp_progress->transaction_amount = $bc_monthly->transaction_amount;
                    $gp_progress->commission_amount = $bc_monthly->commission_amount;
                }
                $gp_progress->save();
            }
        }
        echo "Gp Progress Monthly End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
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
