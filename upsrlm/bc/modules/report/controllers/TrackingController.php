<?php

namespace bc\modules\report\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use bc\modules\training\models\RsetisCenterTrainingSearch;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\training\models\RsetisBatchParticipantsSearch;
use bc\modules\selection\models\form\DashboardSearchForm;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\modules\training\models\form\AddScoreForm;
use common\models\master\MasterRole;
use yii\web\UploadedFile;
use common\models\CboMembers;
use common\models\User;
use common\models\CboMemberProfile;

/**
 * Default controller for the `bc` module
 */
class TrackingController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $searchModel = new DashboardSearchForm($params);
        $searchModels = new SrlmBcApplicationSearch();

        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 30, null, \bc\modules\selection\models\base\GenralModel::select_preselected_bc_column()); //, Yii::$app->user->identity, 150);

        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['=', 'blocked', '0']);
        //$dataProvider->query->andWhere(['not in', 'srlm_bc_application.selection_by', [15]]);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere(['training_status' => 3]);
        $dataProvider->query->andWhere(['bc_tracking_open' => 1]);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($bcid) {

        $model = $this->findModelbc($bcid);

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('view', [
                        'model' => $model,
            ]);
        }
    }

    protected function findModelbc($id) {
        if (($model = SrlmBcApplication::find()->where(['id' => $id])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModel($id) {
        if (($model = RsetisBatchParticipants::find()->where(['id' => $id])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
