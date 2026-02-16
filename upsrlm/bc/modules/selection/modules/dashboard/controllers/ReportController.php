<?php

namespace bc\modules\selection\modules\dashboard\controllers;

use Yii;
use yii\web\Controller;
use bc\modules\selection\models\form\DashboardSearchForm;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\modules\selection\models\SrlmBcApplicationGroupFamily;
use common\models\master\MasterRole;
use bc\modules\selection\components\BcApplication;
use bc\models\master\MasterGramPanchayatSearch;

/**
 * Report controller for the `dashboard` module
 */
class ReportController extends Controller {

    public $flash_message;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest );
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            return $this->redirect(['/selection/preselected']);
        }
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
        $searchModels = new SrlmBcApplicationSearch();
        $searchModel->report_type = 1;
        if ($searchModel->district_code == '') {
            $searchModel->report_type = 1;
            $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, 100, SrlmBcApplicationSearch::$coll_district);
        }
        if ($searchModel->district_code) {
            $searchModel->report_type = 2;
            $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, 100, SrlmBcApplicationSearch::$coll_block);
        }
        if ($searchModel->block_code) {
            $searchModel->report_type = 3;
            $dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, 100, SrlmBcApplicationSearch::$coll_gram_panchayat);
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSelected() {
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            return $this->redirect(['/selection/preselected']);
        }
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
        $searchModels = new MasterGramPanchayatSearch();
        $searchModel->report_type = 1;
        if ($searchModel->district_code == '') {
            $searchModel->report_type = 1;
            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 100, SrlmBcApplicationSearch::$coll_district);
        }
        if ($searchModel->district_code) {
            $searchModel->report_type = 2;
            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 100, SrlmBcApplicationSearch::$coll_block);
        }
        if ($searchModel->block_code) {
            $searchModel->report_type = 3;
            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 100, SrlmBcApplicationSearch::$coll_gram_panchayat);
        }
        return $this->render('selected', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
