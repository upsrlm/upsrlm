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

class BcsakhiController extends Controller {

    public function actionBc() {
        echo "BC sakhi data Start Time : " . date('Y-m-d H:i:s').PHP_EOL;
//156600,312232,112631,16917,12253,284497,98499,397394,16139,28276,96917,139264,92684,176373,255412,124726,32608,40397,211188,31232,343801,184417,158051,368608,
//169239,57122,35183,334909,330852,12183,185156,370878,86637,391577,349382,74415,13830,40978,157332,86387,229220,218566,139513,43493,202242,158048,126512,135704,287887,61003
        $arr = [
            156600,
            284497,
            16917,
            312232,
            112631,
            16139,
            12253,
            98499,
            211188,
            96917,
            184417,
            35183,
            185156,
            28276,
            368608,
            32608,
            370878,
            255412,
            124726,
            124000,
            139264,
            92684,
            176373,
            40397,
            31232,
            343801,
            158051,
            169239,
            57122,
            334909,
            330852,
            12183,
            86637,
            391577,
            349382,
            74415,
            13830,
            40978,
            40978,
            86387,
            229220,
            218566,
            139513,
            43493,
            202242,
            158048,
            126512,
            135704,
            287887,
            61003,
            397394
        ];
        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $month_end_date = $date->format('Y-m-d');
        $month_models = BcTransactionMasterMonth::find()->where(['>', 'id', 5])->andWhere(['<', 'month_end_date', $month_end_date])->all();
        foreach ($arr as $key => $bc_application_id) {
            $bc_summary = BcTransactionBcSummary::findOne(['bc_application_id' => $bc_application_id]);
            $bcsakhi = BcsakhiTransactionBcSummary::findOne(['bc_application_id' => $bc_application_id]);
            if ($bcsakhi == null) {
                $bcsakhi = new BcsakhiTransactionBcSummary();
            }
            $bcsakhi->id = $bc_summary->id;
            $bcsakhi->setAttributes($bc_summary->toArray());
            $bcsakhi->save();

            foreach ($month_models as $month) {
                $bc_summary_month = BcTransactionBcSummaryMonthly::findOne(['bc_application_id' => $bc_application_id, 'month_id' => $month->id]);
                if ($bc_summary_month != null) {
                    $bcsakhimonth = BcsakhiTransactionBcSummaryMonthly::findOne(['bc_application_id' => $bc_application_id, 'month_id' => $month->id]);
                    if ($bcsakhimonth == null) {
                        $bcsakhimonth = new BcsakhiTransactionBcSummaryMonthly();
                    }
                    $bcsakhimonth->id = $bc_summary_month->id;
                    $bcsakhimonth->setAttributes($bc_summary_month->toArray());
                    $bcsakhimonth->save();
                }
            }
        }
        foreach ($month_models as $month_model) {
            if (isset($month_model)) {
                $bc_month = BcsakhiTransactionBcSummaryMonthly::find()->where(['month_id' => $month->id])->exists();
                $report_model = BcsakhiTransactionMonthlyReport::findOne(['month_id' => $month_model->id]);
                if (empty($report_model)) {
                    $report_model = new BcsakhiTransactionMonthlyReport();
                }
                $report_model->month_id = $month_model->id;
                $report_model->month_start_date = $month_model->month_start_date;
                $report_model->month_end_date = $month_model->month_end_date;

                $report_model->operational = $month_model->getBctransaction()->andWhere(['is_new'=>1])->count();;

                $report_model->no_of_bc = $month_model->getBctransaction()->count();
                if ($month_model->getBctransaction()->sum('zero_transaction')) {
                    $report_model->zero_transaction = $month_model->getBctransaction()->sum('zero_transaction');
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
                if ($report_model->operational) {
                    $report_model->avg_bc = FLOOR($report_model->no_of_bc / $report_model->operational);
                }
                if ($report_model->no_of_bc) {
                    $report_model->avg_transaction_no = FLOOR($report_model->no_of_transaction / $report_model->no_of_bc);
                }
                if ($report_model->no_of_bc) {
                    $report_model->avg_txn_amount = FLOOR($report_model->transaction_amount / $report_model->no_of_bc);
                }
                if ($report_model->no_of_bc) {
                    $report_model->avg_com_amount = FLOOR($report_model->commission_amount / $report_model->no_of_bc);
                }
                $report_model->save();
            }
        }
        echo "BC sakhi data End Time : " . date('Y-m-d H:i:s').PHP_EOL;
    }
    
    public function actionBcmonth() {
        echo "BC sakhi data Start Time : " . date('Y-m-d H:i:s').PHP_EOL;
//156600,312232,112631,16917,12253,284497,98499,397394,16139,28276,96917,139264,92684,176373,255412,124726,32608,40397,211188,31232,343801,184417,158051,368608,
//169239,57122,35183,334909,330852,12183,185156,370878,86637,391577,349382,74415,13830,40978,157332,86387,229220,218566,139513,43493,202242,158048,126512,135704,287887,61003
        $arr = [
            156600,
            284497,
            16917,
            312232,
            112631,
            16139,
            12253,
            98499,
            211188,
            96917,
            184417,
            35183,
            185156,
            28276,
            368608,
            32608,
            370878,
            255412,
            124726,
            124000,
            139264,
            92684,
            176373,
            40397,
            31232,
            343801,
            158051,
            169239,
            57122,
            334909,
            330852,
            12183,
            86637,
            391577,
            349382,
            74415,
            13830,
            40978,
            40978,
            86387,
            229220,
            218566,
            139513,
            43493,
            202242,
            158048,
            126512,
            135704,
            287887,
            61003,
            397394
        ];
        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $month_end_date = $date->format('Y-m-d');
        $month_models = BcTransactionMasterMonth::find()->where(['>', 'id', 5])->andWhere(['<', 'month_end_date', $month_end_date])->all();
        foreach ($arr as $key => $bc_application_id) {
            $bc_summary = BcTransactionBcSummary::findOne(['bc_application_id' => $bc_application_id]);
            $bcsakhi = BcsakhiTransactionBcSummary::findOne(['bc_application_id' => $bc_application_id]);
//            if ($bcsakhi == null) {
//                $bcsakhi = new BcsakhiTransactionBcSummary();
//            }
//            $bcsakhi->id = $bc_summary->id;
//            $bcsakhi->setAttributes($bc_summary->toArray());
//            $bcsakhi->save();

            foreach ($month_models as $month) {
                $bc_summary_month = BcTransactionBcSummaryMonthly::findOne(['bc_application_id' => $bc_application_id, 'month_id' => $month->id]);
                if ($bc_summary_month != null) {
                    $bcsakhimonth = BcsakhiTransactionBcSummaryMonthly::findOne(['bc_application_id' => $bc_application_id, 'month_id' => $month->id]);
                    if ($bcsakhimonth == null) {
                        $bcsakhimonth = new BcsakhiTransactionBcSummaryMonthly();
                    }
                    $bcsakhimonth->id = $bc_summary_month->id;
                    $bcsakhimonth->setAttributes($bc_summary_month->toArray());
                    $bcsakhimonth->save();
                }
            }
        }
        foreach ($month_models as $month_model) {
            if (isset($month_model)) {
                $bc_month = BcsakhiTransactionBcSummaryMonthly::find()->where(['month_id' => $month->id])->exists();
                $report_model = BcsakhiTransactionMonthlyReport::findOne(['month_id' => $month_model->id]);
                if (empty($report_model)) {
                    $report_model = new BcsakhiTransactionMonthlyReport();
                }
                $report_model->month_id = $month_model->id;
                $report_model->month_start_date = $month_model->month_start_date;
                $report_model->month_end_date = $month_model->month_end_date;

                $report_model->operational = $month_model->getBctransaction()->andWhere(['is_new'=>1])->count();;

                $report_model->no_of_bc = $month_model->getBctransaction()->count();
                if ($month_model->getBctransaction()->sum('zero_transaction')) {
                    $report_model->zero_transaction = $month_model->getBctransaction()->sum('zero_transaction');
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
                if ($report_model->operational) {
                    $report_model->avg_bc = FLOOR($report_model->no_of_bc / $report_model->operational);
                }
                if ($report_model->no_of_bc) {
                    $report_model->avg_transaction_no = FLOOR($report_model->no_of_transaction / $report_model->no_of_bc);
                }
                if ($report_model->no_of_bc) {
                    $report_model->avg_txn_amount = FLOOR($report_model->transaction_amount / $report_model->no_of_bc);
                }
                if ($report_model->no_of_bc) {
                    $report_model->avg_com_amount = FLOOR($report_model->commission_amount / $report_model->no_of_bc);
                }
                $report_model->save();
            }
        }
        echo "BC sakhi data End Time : " . date('Y-m-d H:i:s').PHP_EOL;
    }
}
