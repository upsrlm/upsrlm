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
use bc\modules\selection\models\BcHonorariumPayment;

class HonorariumController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'payment', 'upload'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'payment', 'upload'],
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
        \Yii::$app->params['page_size30'] = 10;
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
        $searchModels = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30'], null);
        $dataProvider->query->andWhere(['srlm_bc_application.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
        $dataProvider->query->andWhere(['not', ['srlm_bc_application.bc_beneficiaries_code' => NULL]]);
        $searchModels1 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider1 = $searchModels1->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider1->query->andWhere(['not', ['month1' => null]]);
        $searchModels2 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider2 = $searchModels2->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider2->query->andWhere(['not', ['month2' => null]]);
        $searchModels3 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider3 = $searchModels3->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider3->query->andWhere(['not', ['month3' => null]]);
        $searchModels4 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider4 = $searchModels4->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider4->query->andWhere(['not', ['month4' => null]]);
        $searchModels5 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider5 = $searchModels5->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider5->query->andWhere(['not', ['month5' => null]]); //->andWhere(['saree1_provided' => 1])->andFilterWhere(['is', 'saree1_acknowledge', new \yii\db\Expression('NULL')]);
        $searchModels6 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider6 = $searchModels6->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider6->query->andWhere(['not', ['month6' => null]]);
        $searchModels7 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider7 = $searchModels7->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider7->query->andWhere(['not', ['month1' => null]])->andFilterWhere(['=', 'month1_acknowledge', 0]);
        $searchModels8 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider8 = $searchModels8->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider8->query->andWhere(['not', ['month2' => null]])->andFilterWhere(['=', 'month2_acknowledge', 0]);

        $searchModels9 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider9 = $searchModels9->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider9->query->andWhere(['not', ['month3' => null]])->andFilterWhere(['=', 'month3_acknowledge', 0]);
        $searchModels10 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider10 = $searchModels10->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider10->query->andWhere(['not', ['month4' => null]])->andFilterWhere(['=', 'month4_acknowledge', 0]);

        $searchModels11 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider11 = $searchModels11->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider11->query->andWhere(['not', ['month5' => null]])->andFilterWhere(['=', 'month5_acknowledge', 0]);
        $searchModels12 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider12 = $searchModels12->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider12->query->andWhere(['not', ['month6' => null]])->andFilterWhere(['=', 'month6_acknowledge', 0]);
        
        
        $searchModels13 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider13 = $searchModels13->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider13->query->andWhere(['not', ['month1' => null]])->andFilterWhere(['!=', 'month1_acknowledge', 0]);
        $searchModels14 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider14 = $searchModels14->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider14->query->andWhere(['not', ['month2' => null]])->andFilterWhere(['!=', 'month2_acknowledge', 0]);

        $searchModels15 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider15 = $searchModels15->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider15->query->andWhere(['not', ['month3' => null]])->andFilterWhere(['!=', 'month3_acknowledge', 0]);
        $searchModels16 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider16 = $searchModels16->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider16->query->andWhere(['not', ['month4' => null]])->andFilterWhere(['!=', 'month4_acknowledge', 0]);

        $searchModels17 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider17 = $searchModels17->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider17->query->andWhere(['not', ['month5' => null]])->andFilterWhere(['!=', 'month5_acknowledge', 0]);
        $searchModels18 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider18 = $searchModels15->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider18->query->andWhere(['not', ['month6' => null]])->andFilterWhere(['!=', 'month6_acknowledge', 0]);

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
            $dataProvider = $dataProvider7;
        } elseif ($button_type == "8") {
            $dataProvider = $dataProvider8;
        } elseif ($button_type == "9") {
            $dataProvider = $dataProvider9;
        } elseif ($button_type == "10") {
            $dataProvider = $dataProvider10;
        }elseif ($button_type == "11") {
            $dataProvider = $dataProvider11;
        } elseif ($button_type == "12") {
            $dataProvider = $dataProvider12;
        }elseif ($button_type == "13") {
            $dataProvider = $dataProvider13;
        } elseif ($button_type == "14") {
            $dataProvider = $dataProvider14;
        } elseif ($button_type == "15") {
            $dataProvider = $dataProvider15;
        } elseif ($button_type == "16") {
            $dataProvider = $dataProvider16;
        }elseif ($button_type == "17") {
            $dataProvider = $dataProvider17;
        } elseif ($button_type == "18") {
            $dataProvider = $dataProvider18;
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
                    'dataProvider11' => $dataProvider11,
                    'dataProvider12' => $dataProvider12,
                    'dataProvider13' => $dataProvider13,
                    'dataProvider14' => $dataProvider14,
                    'dataProvider15' => $dataProvider15,
                    'dataProvider16' => $dataProvider16,
                    'dataProvider17' => $dataProvider17,
                    'dataProvider18' => $dataProvider18,
        ]);
    }

    protected function findModel($id) {
        if (($model = RsetisBatchParticipants::find()->where(['id' => $id])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelbc($id) {
        if (($model = SrlmBcApplication::find()->where(['id' => $id])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelShg($id) {
        if (($model = \cbo\models\Shg::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
