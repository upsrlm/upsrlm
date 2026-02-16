<?php

namespace bc\modules\training\controllers;

use Yii;
use yii\web\Controller;
use bc\modules\selection\models\form\DashboardSearchForm;
use bc\models\master\MasterDistrictSearch;
use bc\models\master\MasterBlockSearch;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\models\srlm\SrlmBcApplicationGroupFamily;
use common\models\master\MasterRole;
use bc\components\srlm\BcApplication;
use bc\models\srlm\report\Graph;
use bc\modules\training\models\form\TrainingAgreeForm;
use bc\modules\training\models\RsetisBatchParticipantsSearch;
use bc\modules\training\models\RsetisCenterTrainingSearch;
use bc\modules\training\models\RsetisCenterTraining;
/**
 * DashboardController for the `training` module
 */
class DashboardController extends Controller {

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
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'reset' => ['POST'],
                ],
            ],
        ];
    }

    public function BeforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    public function actionIndex() {
        $searchModel = new \bc\modules\selection\models\form\DashboardSearchForm(Yii::$app->request->post());
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10'], \bc\modules\selection\models\base\GenralModel::select_preselected_bc_column());
        
        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        //$dataProvider->query->andWhere(['not in', 'srlm_bc_application.selection_by', [15]]);
        $dataProvider->query->addOrderBy("first_name asc");
        $dataProvidera = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10'], \bc\modules\selection\models\base\GenralModel::select_preselected_bc_column());
     
        $dataProvidera->query->andWhere(['=', 'form_number', '6']);
        $dataProvidera->query->andWhere(['=', 'gender', '2']);
        $dataProvidera->query->andWhere(['=', 'urban_shg', '0']);
        $dataProvidera->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
       // $dataProvidera->query->andWhere(['not in', 'srlm_bc_application.selection_by', [15]]);
        $dataProvidera->query->addOrderBy("first_name asc");
        $searchModelgp = new \bc\models\master\MasterGramPanchayatSearch();
        $dataProvidergp = $searchModelgp->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $searchModel1 = new RsetisBatchParticipantsSearch();
        $searchModel1->show_blocked=0;
        $dataProvider1 = $searchModel1->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider1->query->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_UNWILLING]]);
//        $dataProvider1->query->andWhere(['srlm_bc_application.already_certified' => 0]);
//        $dataProvider1->query->andWhere(['srlm_bc_application.blocked' => 0]);
        $searchModel2 = new RsetisBatchParticipantsSearch();
        $searchModel2->show_blocked=0;
        $dataProvider2 = $searchModel2->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider2->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
//        $dataProvider2->query->andWhere(['srlm_bc_application.blocked' => 0]);
        
        $searchModelpen = new SrlmBcApplicationSearch();

        $dataProviderpen = $searchModelpen->search([], Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProviderpen->query->andWhere(['=', 'form_number', '6']);
        $dataProviderpen->query->andWhere(['=', 'gender', '2']);
        $dataProviderpen->query->andWhere(['=', 'training_status', 0]);
        $dataProviderpen->query->andWhere(['missing_bc' => 0]);
        $dataProviderpen->query->andWhere(['urban_shg' => 0]);
        $dataProviderpen->query->andWhere(['blocked' => 0]);
        //$dataProviderpen->query->andWhere(['not in', 'srlm_bc_application.selection_by', [15]]);
        if ($searchModel->district_code)
            $dataProviderpen->query->andWhere(['=', 'district_code', $searchModel->district_code]);
        $dataProviderpen->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $searchModelibf = new RsetisBatchParticipantsSearch();
        $searchModelibf->show_blocked = 0;
        $searchModelibf->district_code = $searchModel->district_code;
        $dataProvideribf = $searchModelibf->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvideribf->query->andWhere(['srlm_bc_application.iibf_photo_status' => 1]);
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
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvidera' => $dataProvidera,
                    'dataProvider1' => $dataProvider1,
                    'dataProvider2' => $dataProvider2,
                    'dataProvidergp' => $dataProvidergp,
                    'dataProvider' => $dataProvider,
                    'dataProviderpen' => $dataProviderpen,
                    'dataProvideribf' => $dataProvideribf,
                    'dataProvider3' => $dataProvider3,
                    'batch_size' => $batch_size,
        ]);
    }

}
