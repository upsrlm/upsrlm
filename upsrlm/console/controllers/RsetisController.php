<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\base\Model;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\RsetisCenter;
use bc\modules\training\models\RsetisEcalendar;
use bc\modules\training\models\RsetisBatchTraining;
use bc\modules\training\models\RsetisCenterTraining;
use bc\modules\training\models\TrainingEntity;
use bc\modules\training\models\RsetisBatchParticipants;
use console\helpers\Utility;

class RsetisController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionResetcalendar() {
        Yii::$app->dbbc->createCommand()->truncateTable('rsetis_ecalendar')->execute();
        $models = RsetisCenterTraining::find()->where(['!=', 'status', -1])->orderBy('training_start_date asc')->all();
        foreach ($models as $training) {
            $cal = new TrainingEntity($training);
            $cal->calendarpopulate();
        }
    }

    public function actionRcenter() {

        $models = RsetisCenter::find()->where(['status' => 1])->all();
        foreach ($models as $model) {
            $condition = ['and',
                ['=', 'id', $model->id],
            ];
            RsetisCenter::updateAll([
                'no_of_participant' => RsetisBatchParticipants::find()->where(['rsetis_center_training_id' => $model->id])->andWhere(['!=', 'status', -1])->count(),
                'no_of_gp_covered' => RsetisBatchParticipants::find()->select('gram_panchayat_code')->distinct()->where(['rsetis_center_training_id' => $model->id])->andWhere(['!=', 'status', -1])->groupBy('gram_panchayat_code')->count(),
                'total_bc_sortlisted' => SrlmBcApplication::find()->where(['district_code' => $model->district_code, 'gender' => 2, 'form_number' => 6, 'status' => 2])->count(),
                'urban' => SrlmBcApplication::find()->where(['district_code' => $model->district_code, 'gender' => 2, 'form_number' => 6, 'status' => 2])->andWhere(['srlm_bc_application.urban_shg' => 1])->count(),
                'total_gp' => $model->noofgp,
                    ], $condition);
        }
    }

//    public function actionReseticenter() {
//
//        $models = RsetisCenter::find()->where(['status' => 1])->all();
//        foreach ($models as $model) {
//            $condition = ['and',
//                ['=', 'id', $model->id],
//            ];
//            RsetisCenter::updateAll([
//                'total_gp' => $model->noofgp,
//                'total_bc_sortlisted' => $model->selectedcadidate,
//                    ], $condition);
//        }
//    }

    public function actionResettraining() {
        $models = RsetisCenterTraining::find()->where(['=', 'status', 1])->orderBy('id asc')->all();
        foreach ($models as $model) {
            $condition = ['and',
                ['=', 'id', $model->id],
            ];
            RsetisCenterTraining::updateAll([
                'no_of_participant' => RsetisBatchParticipants::find()->where(['rsetis_center_training_id' => $model->id])->andWhere(['!=', 'status', -1])->count(),
                'no_of_gp_covered' => RsetisBatchParticipants::find()->select('gram_panchayat_code')->distinct()->where(['rsetis_center_training_id' => $model->id])->andWhere(['!=', 'status', -1])->groupBy('gram_panchayat_code')->count(),
                    ], $condition);
        }
    }

    public function actionDistrict() {
        $models = \bc\models\master\MasterDistrict::find()->orderBy('id asc')->all();
        foreach ($models as $model) {
            $count = \bc\models\master\MasterBlock::find()->where(['district_code' => $model->district_code, 'aspirational' => 1, 'status' => 1])->count();
            $condition = ['and',
                ['=', 'district_code', $model->district_code],
            ];
            \bc\models\master\MasterDistrict::updateAll([
                'aspirational' => $count > 0 ? 1 : 0,
                'aspirational_block' => $count,
                    ], $condition);
            \common\models\master\MasterDistrict::updateAll([
                'aspirational' => $count > 0 ? 1 : 0,
                'aspirational_block' => $count,
                    ], $condition);
            \common\models\dynamicdb\cbo_detail\master\MasterDistrict::updateAll([
                'aspirational' => $count > 0 ? 1 : 0,
                'aspirational_block' => $count,
                    ], $condition);
            \bc\modules\transaction\models\summary\MasterDistrict::updateAll([
                'aspirational' => $count > 0 ? 1 : 0,
                'aspirational_block' => $count,
                    ], $condition);
        }
    }

    public function actionDistrict1() {
        $models = \bc\models\master\MasterDistrict::find()->orderBy('id asc')->all();
        foreach ($models as $model) {
            $condition = ['and',
                ['=', 'id', $model->id],
            ];
            \bc\models\master\MasterDistrict::updateAll([
                'gram_panchayat_count' => $model->getGp()->count(),
                    ], $condition);
        }
    }

    public function actionDistrict2() {
        $models = \common\models\master\MasterDistrict::find()->orderBy('id asc')->all();
        foreach ($models as $model) {
            $condition = ['and',
                ['=', 'id', $model->id],
            ];
            \common\models\master\MasterDistrict::updateAll([
                'gram_panchayat_count' => $model->getGp()->count(),
                    ], $condition);
        }
    }

//    public function actionUnwillingrsetis() {
//        $models = \bc\modules\selection\models\BcUnwillingRsetis::find()->orderBy('id asc')->all();
//        foreach ($models as $model) {
//            $condition = ['and',
//                ['=', 'id', $model->id],
//            ];
//            \bc\modules\selection\models\BcUnwillingRsetis::updateAll([
//                'unwilling_reason7' => 0,
//                'unwilling_reason7_text' => null,
//                    ], $condition);
//            $bc_unwilling_rsetis = 0;
//            if ($model->unwilling_reason1 or $model->unwilling_reason2 or $model->unwilling_reason3 or $model->unwilling_reason4 or $model->unwilling_reason5 or $model->unwilling_reason6) {
//                $bc_unwilling_rsetis = 1;
//            }
//            $condition1 = ['and',
//                ['=', 'id', $model->bc_application_id],
//            ];
//            SrlmBcApplication::updateAll([
//                'bc_unwilling_rsetis' => $bc_unwilling_rsetis,
//                    ], $condition1);
//        }
//    }
//    public function actionUnwillingcallcenter() {
//        $models = \bc\modules\selection\models\BcUnwillingCallCenter::find()->orderBy('id asc')->all();
//        foreach ($models as $model) {
//            $condition = ['and',
//                ['=', 'id', $model->id],
//            ];
//            \bc\modules\selection\models\BcUnwillingCallCenter::updateAll([
//                'unwilling_reason7' => 0,
//                'unwilling_reason7_text' => null,
//                    ], $condition);
//            $bc_unwilling_call_center = 0;
//            if ($model->unwilling_reason1 or $model->unwilling_reason2 or $model->unwilling_reason3 or $model->unwilling_reason4 or $model->unwilling_reason5 or $model->unwilling_reason6) {
//                $bc_unwilling_call_center = 1;
//            }
//            $condition1 = ['and',
//                ['=', 'id', $model->bc_application_id],
//            ];
//            SrlmBcApplication::updateAll([
//                'bc_unwilling_call_center' => $bc_unwilling_call_center,
//                    ], $condition1);
//        }
//    }
//    public function actionIneligible() {
//        $models = SrlmBcApplication::find()->andwhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL, 'gender' => 2, 'form_number' => SrlmBcApplication::FORM_STATUS_PART_4])->andWhere(['training_status' => [SrlmBcApplication::TRAINING_STATUS_DEFAULT, SrlmBcApplication::TRAINING_STATUS_AGREE_TRAINING, SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE]])->andWhere(['reading_skills' => [3, 4, 5]])->all();
//        foreach ($models as $model) {
//            $model->training_status = SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE;
//            $model->training_id = 0;
//            $model->training_id = 0;
//        }
//    }
}
