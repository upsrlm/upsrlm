<?php

namespace bccallcenter\modules\rsetis\controllers;

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

/**
 * Default controller for the `nfsaSurvey` module
 */
class PreselectedController extends Controller {

    use \common\traits\AjaxValidationTrait;

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
                    'reset' => ['POST'],
                ],
            ],
        ];
    }

    public function BeforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {

        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new SrlmBcApplicationSearch();
        $searchModel->training_status = 0;
        $searchModels->training_status = 0;
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 50, null, \bc\modules\selection\models\base\GenralModel::select_preselected_bc_column());
        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
//        $dataProvider->query->andWhere(['missing_bc' => 0]);
        $dataProvider->query->andWhere(['urban_shg' => 0]);
        $dataProvider->query->andWhere(['blocked' => 0]);
        // $dataProvider->query->andWhere(['not in', 'srlm_bc_application.selection_by', [14]]);
//        $dataProvider->query->andWhere(['=', 'selection_by', '1']);
        $dataProvider->query->addOrderBy("first_name asc");

        $searchModelsagree = new SrlmBcApplicationSearch();
        $searchModel->training_status = 1;
        $dataProvideragree = $searchModelsagree->search([], Yii::$app->user->identity, \Yii::$app->params['page_size30'], null, ['srlm_bc_application.id']);

        $dataProvideragree->query->andWhere(['=', 'form_number', '6']);
        $dataProvideragree->query->andWhere(['=', 'gender', '2']);
        $dataProvideragree->query->andWhere(['=', 'training_status', $searchModel->training_status]);
        $dataProvideragree->query->andWhere(['=', 'district_code', $searchModel->district_code]);
        $dataProvideragree->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvideragree' => $dataProvideragree,
        ]);
    }

    protected function findModel($id) {
        if (($model = SrlmBcApplication::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
