<?php

namespace backend\modules\rishta\controllers;

use Yii;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\modules\selection\models\form\DashboardSearchForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\CboMemberProfile;
use common\models\CboMembers;
use common\models\master\MasterRole;
use backend\modules\bc\models\form\ShgForm;
use yii\web\UploadedFile;

/**
 * BcController implements the CRUD actions for NotificationLog model.
 */
class BcController extends Controller {

    use \common\traits\AjaxValidationTrait;

    /**
     * {@inheritdoc}
     */
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
        
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
        $searchModels = new SrlmBcApplicationSearch();
        if (empty(Yii::$app->request->queryParams)) {
            $searchModels->training_status = SrlmBcApplication::TRAINING_STATUS_PASS;
        }
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30'],null,\bc\modules\selection\models\base\GenralModel::select_rishta_bc_column());
        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere(['srlm_bc_application.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        if ($searchModel->rishta_access_page != '') {
            if ($searchModel->rishta_access_page == '0') {
                $dataProvider->query->andWhere(['srlm_bc_application.rishta_access_page_count' => 0]);
            }
            if ($searchModel->rishta_access_page == '1') {
                $dataProvider->query->andWhere(['>', 'srlm_bc_application.rishta_access_page_count', 0]);
            }
        }
        if ($searchModel->transaction_start != '') {
            if ($searchModel->transaction_start == '0') {
                $dataProvider->query->andWhere(['srlm_bc_application.no_of_transaction' => 0]);
            }
            if ($searchModel->transaction_start == '1') {
                $dataProvider->query->andWhere(['>', 'srlm_bc_application.no_of_transaction', 0]);
            }
        }
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    protected function findModel($id) {
        if (($model = SrlmBcApplication::findOne(['id' => $id, 'training_status' => SrlmBcApplication::TRAINING_STATUS_PASS])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
