<?php

namespace bc\modules\report\controllers;

use Yii;
use yii\web\Controller;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\training\models\RsetisBatchParticipantsSearch;
use bc\modules\training\models\RsetisCenterTraining;
use bc\modules\training\models\RsetisCenterTrainingSearch;
use bc\modules\report\models\form\ReportSearchForm;

/**
 * RsetiController for the `report` module
 */
class RsetiController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $searchModel = new ReportSearchForm(Yii::$app->request->queryParams);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModel1 = new SrlmBcApplicationSearch();

        $dataProvider1 = $searchModel1->search([], Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider1->query->andWhere(['=', 'srlm_bc_application.form_number', '6']);
        $dataProvider1->query->andWhere(['=', 'srlm_bc_application.gender', '2']);
        $dataProvider1->query->andWhere(['=', 'srlm_bc_application.training_status', 0]);
        $dataProvider1->query->andWhere(['srlm_bc_application.missing_bc' => 0]);
        $dataProvider1->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
        $dataProvider1->query->andWhere(['srlm_bc_application.blocked' => 0]);
        //$dataProvider1->query->andWhere(['not in', 'srlm_bc_application.selection_by', [15]]);
        if ($searchModel->district_code)
            $dataProvider1->query->andWhere(['=', 'srlm_bc_application.district_code', $searchModel->district_code]);
        $dataProvider1->query->andWhere(['srlm_bc_application.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $searchModel2 = new SrlmBcApplicationSearch();
        $searchModel->training_status = 1;
        $dataProvider2 = $searchModel2->search([], Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider2->query->andWhere(['!=', 'srlm_bc_application.form_number', '0']);
        $dataProvider2->query->andWhere(['=', 'srlm_bc_application.form_number', '6']);
        $dataProvider2->query->andWhere(['=', 'srlm_bc_application.gender', '2']);
        $dataProvider2->query->andWhere(['=', 'srlm_bc_application.training_status', $searchModel->training_status]);
        if ($searchModel->district_code)
            $dataProvider2->query->andWhere(['=', 'srlm_bc_application.district_code', $searchModel->district_code]);
        $dataProvider2->query->andWhere(['srlm_bc_application.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider2->query->andWhere(['srlm_bc_application.missing_bc' => 0]);
        $dataProvider2->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
        $dataProvider2->query->andWhere(['srlm_bc_application.blocked' => 0]);
        $searchModel3 = new RsetisCenterTrainingSearch();
        if ($searchModel->district_code)
            $searchModel3->district_code = $searchModel->district_code;
        $dataProvider3 = $searchModel3->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $query_batch = RsetisCenterTraining::find()->where(['!=', 'status', -1]);
        if ($searchModel->district_code) {
            $query_batch->andWhere(['district_code' => $searchModel->district_code]);
        }
        $batch_participant = $query_batch->sum('no_of_participant');
        $batch_size = $dataProvider3->query->count() != 0 ? $batch_participant / $dataProvider3->query->count() : 0;
        $searchModel5 = new RsetisBatchParticipantsSearch();
        $searchModel5->show_blocked = 0;
        $searchModel5->district_code = $searchModel->district_code;
        $dataProvider5 = $searchModel5->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider5->query->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_UNWILLING]]);
        //$dataProvider2->query->andWhere(['srlm_bc_application.already_certified' => 0]);
//        $dataProvider5->query->andWhere(['srlm_bc_application.blocked' => 0]);
        $searchModel6 = new RsetisBatchParticipantsSearch();
        $searchModel6->show_blocked = 0;
        $searchModel6->district_code = $searchModel->district_code;
        $dataProvider6 = $searchModel6->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider6->query->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_PASS]]);
        $dataProvider6->query->andWhere(['srlm_bc_application.blocked' => 0]);
        $searchModel7 = new RsetisBatchParticipantsSearch();
        $searchModel7->show_blocked = 0;
        $searchModel7->district_code = $searchModel->district_code;
        $dataProvider7 = $searchModel6->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider7->query->andWhere(['srlm_bc_application.iibf_photo_status' => 1]);
        $dataProvider = [];
        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";
        if ($button_type == "1") {
            $dataProvider = $dataProvider1;
        } elseif ($button_type == "2") {
            $dataProvider = $dataProvider2;
        } elseif ($button_type == "3") {
            $dataProvider = $dataProvider3;
        } elseif ($button_type == "4") {
            $dataProvider = $dataProvider4;
        } elseif ($button_type == "5") {
            $dataProvider = $dataProvider5;
        } elseif ($button_type == "6") {
            $dataProvider = $dataProvider6;
        } elseif ($button_type == "7") {
            $dataProvider = $dataProvider6;
        }
        return $this->render('index', [
                    'button_type' => $button_type,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvider1' => $dataProvider1,
                    'dataProvider2' => $dataProvider2,
                    'dataProvider3' => $dataProvider3,
                    'batch_size' => $batch_size,
                    'dataProvider5' => $dataProvider5,
                    'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7,
        ]);
    }

}
