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
use console\helpers\Utility;
use bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily;
use bc\models\BcGovermentReportBlock;

class GovController extends Controller {

    public $id = 0;
    public $state_code = 9;
    public $state_name = 'Uttar Pradesh';
    public $division_code;
    public $division_name;
    public $district_code;
    public $district_name;
    public $block_code;
    public $block_name;
    public $certified_bc = 0;
    public $operational = 0;
    public $date;
    public $last_updated_on;

//    public function actionBlockbc() {
//        $date = '2023-04-01';
//        $models_blocks = \bc\models\master\MasterBlock::find()->where(['status' => 1])->orderBy([
//                    'district_name' => SORT_ASC,
//                    'block_name' => SORT_ASC
//                ])->all();
//        $array[0] = ['date', 'state_code', 'state_name', 'division_code', 'division_name', 'district_code', 'district_name', 'block_code', 'block_name', 'trainded and certified', 'operational'];
//        $i = 1;
//        foreach ($models_blocks as $md) {
//            $user_model = \common\models\User::findOne(19852);
//            $bc = SrlmBcApplication::find()->select(['id'])->joinWith(['training'])->where(['srlm_bc_application.status' => 2, 'srlm_bc_application.training_status' => 3, 'srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.block_code' => $md->block_code])->andWhere(['<=', 'rsetis_center_training.schedule_date_of_exam', $date])->count();
//            $op = BcTransactionBcSummaryDaily::find()->joinWith(['gp'])->select(['bc_application_id'])->distinct()->where(['master_gram_panchayat.status' => 1, 'bc_transaction_bc_summary_daily.block_code' => $md->block_code])->andWhere(['<=', 'date', $date . ' 11'])->count();
//            $tep = [$date, $this->state_code, $this->state_name, $md->div->lgd_division_code, $md->div->lgd_division_name, $md->district_code, $md->district_name, $md->block_code, $md->block_name, $bc, $op];
//            array_push($array, $tep);
//        }
////        print_r($array);exit;
//        //$array = \bc\models\BcCumulativeReportBlock::find()->where(['date' => date('Y-m-d')])->asArray()->all();
//        $fp = fopen(Yii::$app->params['bcdatapath'] . 'bcselection/report/' . 'gov.json', 'w');
//        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
//        fclose($fp);
//    }
//    public function actionBlockbc() {
//        $date = '2023-04-01';
//        $models_blocks = \bc\models\master\MasterBlock::find()->where(['status' => 1])->orderBy([
//                    'district_name' => SORT_ASC,
//                    'block_name' => SORT_ASC
//                ])->all();
//        $array[0] = ['date', 'state_code', 'state_name', 'division_code', 'division_name', 'district_code', 'district_name', 'block_code', 'block_name', 'trainded and certified', 'operational'];
//        $i = 1;
//        foreach ($models_blocks as $md) {
//            $user_model = \common\models\User::findOne(19852);
//            $bc = SrlmBcApplication::find()->select(['id'])->joinWith(['training'])->where(['srlm_bc_application.status' => 2, 'srlm_bc_application.training_status' => 3, 'srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.block_code' => $md->block_code])->andWhere(['<=', 'rsetis_center_training.schedule_date_of_exam', $date])->count();
//            $op = BcTransactionBcSummaryDaily::find()->joinWith(['gp'])->select(['bc_application_id'])->distinct()->where(['master_gram_panchayat.status' => 1, 'bc_transaction_bc_summary_daily.block_code' => $md->block_code])->andWhere(['<=', 'date', $date.' 11'])->count();
//            $tep = [$date, $this->state_code, $this->state_name, $md->division_code, $md->division_name, $md->district_code, $md->district_name, $md->block_code, $md->block_name, $bc, $op];
//            array_push($array,$tep);
//        }
////        print_r($array);exit;
//        //$array = \bc\models\BcCumulativeReportBlock::find()->where(['date' => date('Y-m-d')])->asArray()->all();
//        $fp = fopen(Yii::$app->params['bcdatapath'] . 'bcselection/report/' . 'gov.json', 'w');
//        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
//        fclose($fp);
//    }
    public function actionDaily($date = '2023-04-01') {
        $date = $date;
        $models_blocks = \bc\models\master\MasterBlock::find()->orderBy([
                    'district_name' => SORT_ASC,
                    'block_name' => SORT_ASC
                ])->all();
        $array[0] = ['date', 'state_code', 'state_name', 'division_code', 'division_name', 'district_code', 'district_name', 'block_code', 'block_name', 'trainded and certified', 'operational'];
        $i = 1;
        foreach ($models_blocks as $md) {
            $user_model = \common\models\User::findOne(19852);
            $gov = BcGovermentReportBlock::find()->where(['date' => $date, 'block_code' => $md->block_code])->one();
            $bc = SrlmBcApplication::find()->select(['id', 'date(iibf_date) as iibf_date'])->where(['srlm_bc_application.status' => 2, 'srlm_bc_application.training_status' => 3, 'srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.block_code' => $md->block_code])->andWhere(['<=', 'srlm_bc_application.iibf_date', $date])->count();
            //$op = BcTransactionBcSummaryDaily::find()->joinWith(['gp'])->select(['bc_application_id'])->distinct()->where(['master_gram_panchayat.status' => 1, 'bc_transaction_bc_summary_daily.block_code' => $md->block_code])->andWhere(['<=', 'date', $date])->count();
            $op = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->joinWith(['gp'])->select(['bc_application_id'])->where(['master_gram_panchayat.status' => 1, 'bc_transaction_bc_summary.block_code' => $md->block_code, 'bc_transaction_bc_summary.bc_status' => 1])->count();

            $tep = [$date, $this->state_code, $this->state_name, $md->div->lgd_division_code, $md->div->lgd_division_name, $md->district_code, $md->district_name, $md->block_code, $md->block_name, $bc, $op];
            array_push($array, $tep);
            if ($gov == null) {
                $gov = new BcGovermentReportBlock();
            }
            $gov->date = $date;
            $gov->state_code = $md->state_code;
            $gov->state_name = $md->state_name;
            $gov->division_code = $md->division_code;
            $gov->division_name = $md->division_name;
            $gov->lgd_division_code = $md->div->lgd_division_code;
            $gov->lgd_division_name = $md->div->lgd_division_name;
            $gov->district_code = $md->district_code;
            $gov->district_name = $md->district_name;
            $gov->block_name = $md->block_name;
            $gov->block_code = $md->block_code;
            $gov->trained_and_certified = $bc;
            $gov->operational = $op;
            $gov->save();
        }
//        print_r($array);exit;
        //$array = \bc\models\BcCumulativeReportBlock::find()->where(['date' => date('Y-m-d')])->asArray()->all();
//        $fp = fopen(Yii::$app->params['bcdatapath'] . 'bcselection/report/' . 'gov5block.json', 'w');
//        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
//        fclose($fp);
    }

    public function actionData() {
        echo "Gov start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        $start_date = date('Y-m-d');
        //$start_date = '2024-05-14';
        //$end_date = \DateTime::createFromFormat("Y-m-d", $start_date)->format("Y-m-t");
        $end_date = date('Y-m-d');
        $dates = \common\helpers\Utility::date_range_key_value_date($start_date, $end_date);
        foreach ($dates as $date) {

            Yii::$app->runAction('gov/daily', [$date]);
        }
        Yii::$app->runAction('gov/change');
        echo "Gov end Time : " . date('Y-m-d H:i:s') . PHP_EOL;
    }

    public function actionChange() {
        echo "Gov start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        $govs = BcGovermentReportBlock::find()->where(['change_calculated' => 0])->all();
        foreach ($govs as $model) {
            $date = new \DateTime($model->date);
            $date->modify('-1 day');
            $predate = $date->format('Y-m-d');
            $pre_model = BcGovermentReportBlock::find()->where(['date' => $predate, 'block_code' => $model->block_code])->one();
            $operational = 0;
            $trained_and_certified = 0;
            if ($pre_model != null) {
                $operational = $pre_model->operational;
                $trained_and_certified = $pre_model->trained_and_certified;
            }

            $model->change_operational = $model->operational - $operational;
            $model->change_trained_and_certified = $model->trained_and_certified - $trained_and_certified;

            $model->change_calculated = 1;
            $model->save();
        }
        echo "Gov end Time : " . date('Y-m-d H:i:s') . PHP_EOL;
    }

    public function actionCheck($date = '2023-04-01') {
        $date = $date;
        $models_blocks = \bc\models\master\MasterBlock::find()->orderBy([
                    'district_name' => SORT_ASC,
                    'block_name' => SORT_ASC
                ])->all();
        $array[0] = ['date', 'state_code', 'state_name', 'division_code', 'division_name', 'district_code', 'district_name', 'block_code', 'block_name', 'trainded and certified', 'operational'];
        $i = 1;
        $op = 0;
        foreach ($models_blocks as $md) {

            $op = ($op + \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->joinWith(['gp'])->select(['bc_application_id'])->where(['master_gram_panchayat.status' => 1, 'bc_transaction_bc_summary.block_code' => $md->block_code, 'bc_status' => 1])->count());
        }
        echo $op;
    }

//    public function actionDatainactive() {
//
//        echo "Gov start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
//        $start_date = '2023-04-01';
//        //$end_date = \DateTime::createFromFormat("Y-m-d", $start_date)->format("Y-m-t");
//        $end_date = '2023-10-24';
//        $dates = \common\helpers\Utility::date_range_key_value_date($start_date, $end_date);
//        foreach ($dates as $date) {
//            $models_blocks = \bc\models\master\MasterBlock::find()->orderBy([
//                        'district_name' => SORT_ASC,
//                        'block_name' => SORT_ASC
//                    ])->where(['status' => [0, 1]])->all();
//            foreach ($models_blocks as $md) {
//                $user_model = \common\models\User::findOne(19852);
//                $gov = BcGovermentReportBlock::find()->where(['date' => $date, 'block_code' => $md->block_code])->one();
//                $bc = SrlmBcApplication::find()->select(['id', 'date(iibf_date) as iibf_date'])->where(['srlm_bc_application.status' => 2, 'srlm_bc_application.training_status' => 3, 'srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.block_code' => $md->block_code])->andWhere(['<=', 'srlm_bc_application.iibf_date', $date])->count();
//
//                if ($gov == null) {
//                    $gov = new BcGovermentReportBlock();
//                }
//                $gov->date = $date;
//
//                $gov->trained_and_certified = $bc;
//
//                $gov->save();
//                
//            }
//            echo "" . $date . PHP_EOL;
//        }
//        echo "Gov END Time : " . date('Y-m-d H:i:s') . PHP_EOL;
//    }
}
