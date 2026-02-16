<?php

namespace bccallcenter\modules\bc\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use bc\modules\training\models\RsetisCenterTrainingSearch;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\training\models\RsetisBatchParticipantsSearch;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\form\DashboardSearchForm;
use bc\modules\training\models\form\AddScoreForm;
use common\models\master\MasterRole;
use yii\web\UploadedFile;
use common\models\CboMembers;
use common\models\User;
use common\models\CboMemberProfile;
use bc\modules\selection\models\BcFiles;
use bc\modules\selection\models\BcFilesSearch;
use bc\components\BCNotification;
use bc\modules\selection\models\BcProvidedSaree;
use bc\modules\selection\models\form\BCProvidedSareeForm;

class SareeController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'provided', 'upload'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'provided', 'upload'],
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
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
        $searchModels = new \bc\modules\selection\models\BcProvidedSareeSearch();

        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->andWhere(['srlm_bc_application.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
        $searchModels1 = new \bc\modules\selection\models\BcProvidedSareeSearch();
        $dataProvider1 = $searchModels1->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider1->query->andWhere(['saree1_provided' => 1]);
        $searchModels2 = new \bc\modules\selection\models\BcProvidedSareeSearch();
        $dataProvider2 = $searchModels2->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider2->query->andWhere(['saree2_provided' => 1]);
        $searchModels3 = new \bc\modules\selection\models\BcProvidedSareeSearch();
        $dataProvider3 = $searchModels3->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider3->query->andWhere(['saree1_provided' => 1, 'saree1_acknowledge' => [1, 2]]);
        $searchModels4 = new \bc\modules\selection\models\BcProvidedSareeSearch();
        $dataProvider4 = $searchModels4->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider4->query->andWhere(['saree2_provided' => 1, 'saree2_acknowledge' => [1, 2]]);
        $searchModels5 = new \bc\modules\selection\models\BcProvidedSareeSearch();
        $dataProvider5 = $searchModels5->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider5->query->andWhere(['saree1_provided' => 1])->andFilterWhere(['is', 'saree1_acknowledge', new \yii\db\Expression('NULL')]);
        $searchModels6 = new \bc\modules\selection\models\BcProvidedSareeSearch();
        $dataProvider6 = $searchModels6->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider6->query->andWhere(['saree2_provided' => 1])->andFilterWhere(['is', 'saree2_acknowledge', new \yii\db\Expression('NULL')]);
        $searchModels7 = new \bc\modules\selection\models\BcProvidedSareeSearch();
        $dataProvider7 = $searchModels7->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider7->query->andWhere(['saree1_provided' => 1, 'saree1_acknowledge' => 1]);
        $searchModels8 = new \bc\modules\selection\models\BcProvidedSareeSearch();
        $dataProvider8 = $searchModels8->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider8->query->andWhere(['saree1_provided' => 1, 'saree1_acknowledge' => 2]);
        
        $searchModels9 = new \bc\modules\selection\models\BcProvidedSareeSearch();
        $dataProvider9 = $searchModels9->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider9->query->andWhere(['saree2_provided' => 1, 'saree2_acknowledge' => 1]);
        $searchModels10 = new \bc\modules\selection\models\BcProvidedSareeSearch();
        $dataProvider10 = $searchModels10->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider10->query->andWhere(['saree2_provided' => 1, 'saree2_acknowledge' => 2]);
        
        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";
        if ($button_type == "1") {
            $dataProvider = $dataProvider1;
        } elseif ($button_type == "2") {
            $dataProvider = $dataProvider2;
        } elseif ($button_type == "3") {
            $dataProvider = $dataProvider3;
        }elseif ($button_type == "4") {
            $dataProvider = $dataProvider4;
        } elseif ($button_type == "5") {
            $dataProvider = $dataProvider5;
        } elseif ($button_type == "6") {
            $dataProvider = $dataProvider6;
        } elseif ($button_type == "7") {
            $dataProvider = $dataProvider7;
        } elseif ($button_type == "8") {
            $dataProvider = $dataProvider8;
        } elseif ($button_type == "9") {
            $dataProvider = $dataProvider9;
        } elseif ($button_type == "10") {
            $dataProvider = $dataProvider10;
        } 
        return $this->render('index', [
                    'button_type' => $button_type,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvider1' => $dataProvider1,
                    'dataProvider2' => $dataProvider2,
                    'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4,
                    'dataProvider5' => $dataProvider5,
                    'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7,
                    'dataProvider8' => $dataProvider8,
                    'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10,
        ]);
    }

    public function actionView($bcid) {
        $bc_model = $this->findModelbc($bcid);

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                        'model' => $bc_model,
            ]);
        } else {
            return $this->render('view', [
                        'model' => $bc_model,
            ]);
        }
    }
    protected function findModelbc($id) {
        if (($model = SrlmBcApplication::find()->where(['id' => $id])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
