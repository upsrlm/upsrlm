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
use bc\modules\selection\models\SrlmBcApplication7;
use bc\modules\training\models\RsetisCenter;
use bc\modules\training\models\RsetisEcalendar;
use bc\modules\training\models\RsetisBatchTraining;
use bc\modules\training\models\RsetisCenterTraining;
use bc\modules\training\models\TrainingEntity;
use bc\modules\training\models\RsetisBatchParticipants;
use console\helpers\Utility;

/**
 * This command process SRLM DATA and calculate rating section and question and over all
 *
 * @author Habibur Rahman <rahman.kld@gmail.com>
 * @since 2.0
 */
class SrlmratingController extends Controller {

    public $process_limt = 1000;
    public $sec1 = 0;
    public $sec2 = 0;
    public $sec3 = 0;
    public $sec4 = 0;
    public $sec5 = 0;
    public $over_all = 0;
    public $over_all_per = 0;
    public $reading_skils = [1 => 1, 2 => 3, 3 => 2, 4 => 1];
    public $phone_type = [1 => 5, 2 => 1];
    public $what_else_with_mobile = 0;
    public $vechicle_drive = 0;
    public $immediate_aspiration = 0;

//    public function actionCalculate() {
//
//        $models = SrlmBcApplication::find()->where(['=', 'rating_process_status', 0])->andWhere(['!=', 'srlm_bc_application.status', 0])->andWhere(['!=', 'srlm_bc_application.status', SrlmBcApplication::DELETE])->andWhere(['form_number' => 6])->andWhere(['gender' => 2])->orderBy('id asc')->limit($this->process_limt)->all();
//        foreach ($models as $model) {
//            $bc_application = new \bc\modules\selection\components\BcApplication($model->id);
//            $bc_application->calculaterating();
//        }
//    }
//    public function actionCalculate() {
//
//        $models = SrlmBcApplication3::find()->where(['=', 'rating_process_status', 0])->andWhere(['!=', 'srlm_bc_application3.status', 0])->andWhere(['!=', 'srlm_bc_application3.status', SrlmBcApplication::DELETE])->andWhere(['form_number' => 6])->andWhere(['gender' => 2])->orderBy('id asc')->limit($this->process_limt)->all();
//        foreach ($models as $model) {
//            $bc_application = new \bc\modules\selection\components\BcApplication3($model->id);
//            $bc_application->calculaterating();
//        }
//    }
//    public function actionCalculate() {
//
//        $models = SrlmBcApplication4::find()->where(['=', 'rating_process_status', 0])->andWhere(['!=', 'srlm_bc_application4.status', 0])->andWhere(['!=', 'srlm_bc_application4.status', SrlmBcApplication::DELETE])->andWhere(['form_number' => 6])->andWhere(['gender' => 2])->orderBy('id asc')->limit($this->process_limt)->all();
//        foreach ($models as $model) {
//            $bc_application = new \bc\modules\selection\components\BcApplication4($model->id);
//            $bc_application->calculaterating();
//        }
//    }
//    public function actionCalculate() {
//
//        $models = SrlmBcApplication5::find()->where(['=', 'rating_process_status', 0])->andWhere(['!=', 'srlm_bc_application5.status', 0])->andWhere(['!=', 'srlm_bc_application5.status', SrlmBcApplication::DELETE])->andWhere(['form_number' => 6])->andWhere(['gender' => 2])->orderBy('id asc')->limit($this->process_limt)->all();
//        foreach ($models as $model) {
//            $bc_application = new \bc\modules\selection\components\BcApplication5($model->id);
//            $bc_application->calculaterating();
//        }
//    }
//    public function actionMax() {
//        $connection = \Yii::$app->dbbc;
//        $command = $connection->createCommand('SELECT id,gram_panchayat_code,MAX(over_all) as mx FROM `srlm_bc_application5` where status=1 and form_number=6 AND gender=2 GROUP BY gram_panchayat_code');
//        $result = $command->queryAll();
//        foreach ($result as $models) {
//            $model = SrlmBcApplication5::findOne($models['id']);
//            $model->highest_score_in_gp = 1;
//            $model->update();
//        }
//    }
//    public function actionMax() {
//        $connection = \Yii::$app->dbbc;
//        $command = $connection->createCommand('SELECT id,gram_panchayat_code,MAX(over_all) as mx FROM `srlm_bc_application4` where status=1 and form_number=6 AND gender=2 GROUP BY gram_panchayat_code');
//        $result = $command->queryAll();
//        foreach ($result as $models) {
//            $model = SrlmBcApplication4::findOne($models['id']);
//            $model->highest_score_in_gp = 1;
//            $model->update();
//        }
//    }
//     public function actionCalculate() {
//
//        $models = SrlmBcApplication6::find()->where(['=', 'rating_process_status', 0])->andWhere(['!=', 'srlm_bc_application6.status', 0])->andWhere(['!=', 'srlm_bc_application6.status', SrlmBcApplication::DELETE])->andWhere(['form_number' => 6])->andWhere(['gender' => 2])->orderBy('id asc')->limit($this->process_limt)->all();
//        foreach ($models as $model) {
//            $bc_application = new \bc\modules\selection\components\BcApplication6($model->id);
//            $bc_application->calculaterating();
//        }
//    }
//    public function actionMax() {
//        $connection = \Yii::$app->dbbc;
//        $command = $connection->createCommand('SELECT id,gram_panchayat_code,MAX(over_all) as mx FROM `srlm_bc_application6` where status=1 and form_number=6 AND gender=2 GROUP BY gram_panchayat_code');
//        $result = $command->queryAll();
//        foreach ($result as $models) {
//            $model = SrlmBcApplication6::findOne($models['id']);
//            $model->highest_score_in_gp = 1;
//            $model->update();
//        }
//    }
    public function actionCalculate() {

        $models = SrlmBcApplication7::find()->where(['=', 'rating_process_status', 0])->andWhere(['!=', 'srlm_bc_application7.status', 0])->andWhere(['!=', 'srlm_bc_application7.status', SrlmBcApplication::DELETE])->andWhere(['form_number' => 6])->andWhere(['gender' => 2])->orderBy('id asc')->limit($this->process_limt)->all();
        foreach ($models as $model) {
            $bc_application = new \bc\modules\selection\components\BcApplication7($model->id);
            $bc_application->calculaterating();
        }
    }

    public function actionMax() {
        $connection = \Yii::$app->dbbc;
        $command = $connection->createCommand('SELECT id,gram_panchayat_code,MAX(over_all) as mx FROM `srlm_bc_application7` where status=1 and form_number=6 AND gender=2 GROUP BY gram_panchayat_code');
        $result = $command->queryAll();
        foreach ($result as $models) {
            $model = SrlmBcApplication7::findOne($models['id']);
            $model->highest_score_in_gp = 1;
            $model->update();
        }
    }
}
