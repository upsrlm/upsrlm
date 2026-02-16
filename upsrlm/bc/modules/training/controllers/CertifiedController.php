<?php

namespace bc\modules\training\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use bc\modules\training\models\RsetisCenterTrainingSearch;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\training\models\RsetisBatchParticipantsSearch;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\form\AddScoreForm;
use common\models\master\MasterRole;
use yii\web\UploadedFile;
use common\models\CboMembers;
use common\models\User;
use common\models\CboMemberProfile;
use bc\modules\selection\models\BcFiles;
use bc\modules\selection\models\BcFilesSearch;
use bc\components\BCNotification;

/**
 * Default controller for the `training` module
 */
class CertifiedController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['unwilling', 'cdounwilling', 'upsrlmunwilling'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['unwilling', 'cdounwilling', 'upsrlmunwilling'],
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

    public function actionCdounwilling() {
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $select1 = \bc\modules\selection\models\base\GenralModel::select_preselected_bc_column();
        $select2 = \bc\modules\selection\models\base\GenralModel::select_certified_bc_column();
        $select = array_merge($select1, $select2);
        array_push($select, 'srlm_bc_application.iibf_date');
        array_push($select, 'srlm_bc_application.pvr_upload_date');
        array_push($select, 'srlm_bc_application.assign_shg_datetime');
        array_push($select, 'srlm_bc_application.onboarding_date_time');
        array_push($select, 'srlm_bc_application.handheld_machine_date');
        array_push($select, 'srlm_bc_application.beneficiaries_code_date');
        array_push($select, 'srlm_bc_application.bc_beneficiaries_code_date');
        array_push($select, 'srlm_bc_application.bc_unwilling_bc');
        array_push($select, 'srlm_bc_application.bc_unwilling_bc_by');
        array_push($select, 'srlm_bc_application.bc_unwilling_bc_date');
        array_push($select, 'srlm_bc_application.bc_unwilling_bank');
        array_push($select, 'srlm_bc_application.bc_unwilling_bank_by');
        array_push($select, 'srlm_bc_application.bc_unwilling_bank_date');
        array_push($select, 'srlm_bc_application.bc_unwilling_cdo');
        $searchModel = new \bc\modules\selection\models\form\DashboardSearchForm($params);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 30, null, $select);

        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere(['training_status' => 3]);
        $dataProvider->query->andWhere(['bc_unwilling_bank' => 1]);
        $dataProvider->query->andWhere(['bc_unwilling_bc' => 1]);
        $dataProvider->query->andWhere(['or',
            ['=', 'srlm_bc_application.bc_unwilling_cdo', 0],
            ['IS ', 'srlm_bc_application.bc_unwilling_cdo', new \yii\db\Expression('NULL')],
        ]);

        $dataProvider->query->addOrderBy("first_name asc");
        return $this->render('cdounwilling', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpsrlmunwilling() {
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $select1 = \bc\modules\selection\models\base\GenralModel::select_preselected_bc_column();
        $select2 = \bc\modules\selection\models\base\GenralModel::select_certified_bc_column();
        $select = array_merge($select1, $select2);
        array_push($select, 'srlm_bc_application.iibf_date');
        array_push($select, 'srlm_bc_application.pvr_upload_date');
        array_push($select, 'srlm_bc_application.assign_shg_datetime');
        array_push($select, 'srlm_bc_application.onboarding_date_time');
        array_push($select, 'srlm_bc_application.handheld_machine_date');
        array_push($select, 'srlm_bc_application.beneficiaries_code_date');
        array_push($select, 'srlm_bc_application.bc_beneficiaries_code_date');
        array_push($select, 'srlm_bc_application.bc_unwilling_bc');
        array_push($select, 'srlm_bc_application.bc_unwilling_bc_by');
        array_push($select, 'srlm_bc_application.bc_unwilling_bc_date');
        array_push($select, 'srlm_bc_application.bc_unwilling_bank');
        array_push($select, 'srlm_bc_application.bc_unwilling_bank_by');
        array_push($select, 'srlm_bc_application.bc_unwilling_bank_date');
        array_push($select, 'srlm_bc_application.bc_unwilling_cdo');
        array_push($select, 'srlm_bc_application.bc_unwilling_cdo_by');
        array_push($select, 'srlm_bc_application.bc_unwilling_cdo_date');
        $searchModel = new \bc\modules\selection\models\form\DashboardSearchForm($params);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 30, null, $select);

        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere(['training_status' => 3]);
        $dataProvider->query->andWhere(['bc_unwilling_bank' => 1]);
        $dataProvider->query->andWhere(['bc_unwilling_bc' => 1]);
        $dataProvider->query->andWhere(['bc_unwilling_cdo' => 1]);

        $dataProvider->query->addOrderBy("first_name asc");
        return $this->render('upsrlmunwilling', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUnwillingprogress() {
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $select1 = \bc\modules\selection\models\base\GenralModel::select_preselected_bc_column();
        $select2 = \bc\modules\selection\models\base\GenralModel::select_certified_bc_column();
        $select = array_merge($select1, $select2);
        array_push($select, 'srlm_bc_application.iibf_date');
        array_push($select, 'srlm_bc_application.pvr_upload_date');
        array_push($select, 'srlm_bc_application.assign_shg_datetime');
        array_push($select, 'srlm_bc_application.onboarding_date_time');
        array_push($select, 'srlm_bc_application.handheld_machine_date');
        array_push($select, 'srlm_bc_application.beneficiaries_code_date');
        array_push($select, 'srlm_bc_application.bc_beneficiaries_code_date');
        array_push($select, 'srlm_bc_application.bc_unwilling_bc');
        array_push($select, 'srlm_bc_application.bc_unwilling_bc_by');
        array_push($select, 'srlm_bc_application.bc_unwilling_bc_date');
        array_push($select, 'srlm_bc_application.bc_unwilling_bank');
        array_push($select, 'srlm_bc_application.bc_unwilling_bank_by');
        array_push($select, 'srlm_bc_application.bc_unwilling_bank_date');
        array_push($select, 'srlm_bc_application.bc_unwilling_cdo');
        array_push($select, 'srlm_bc_application.bc_unwilling_cdo_by');
        array_push($select, 'srlm_bc_application.bc_unwilling_cdo_date');
        $searchModel = new \bc\modules\selection\models\form\DashboardSearchForm($params);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 100, null, $select);

        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere(['training_status' => 3]);
        $dataProvider->query->andWhere(['or',
            ['=', 'srlm_bc_application.bc_unwilling_bc', 1],
            ['=', 'srlm_bc_application.bc_unwilling_bank', 1],
            ['=', 'srlm_bc_application.bc_unwilling_cdo', 1],
        ]);
        if ($searchModel->bc_unwilling_bc != '') {
            if ($searchModel->bc_unwilling_bc == 1) {
                $dataProvider->query->andWhere(['srlm_bc_application.bc_unwilling_bc' => 1]);
            }
            if ($searchModel->bc_unwilling_bc == 2) {
                $dataProvider->query->andWhere(['srlm_bc_application.bc_unwilling_bc' => 2]);
            }
            if ($searchModel->bc_unwilling_bc == 0) {
                $dataProvider->query->andWhere(['or',
                    ['=', 'srlm_bc_application.bc_unwilling_bc', 0],
                    ['IS ', 'srlm_bc_application.bc_unwilling_bc', new \yii\db\Expression('NULL')],
                ]);
            }
        }
        $dataProvider->query->addOrderBy("first_name asc");
        return $this->render('unwillingprogress', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBankunwilling() {
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $select1 = \bc\modules\selection\models\base\GenralModel::select_preselected_bc_column();
        $select2 = \bc\modules\selection\models\base\GenralModel::select_certified_bc_column();
        $select = array_merge($select1, $select2);
        array_push($select, 'srlm_bc_application.bc_unwilling_bank');
        array_push($select, 'srlm_bc_application.bc_unwilling_bank_call_center');
        array_push($select, 'srlm_bc_application.iibf_date');
        array_push($select, 'srlm_bc_application.pvr_upload_date');
        array_push($select, 'srlm_bc_application.assign_shg_datetime');
        array_push($select, 'srlm_bc_application.onboarding_date_time');
        array_push($select, 'srlm_bc_application.handheld_machine_date');
        array_push($select, 'srlm_bc_application.beneficiaries_code_date');
        array_push($select, 'srlm_bc_application.bc_beneficiaries_code_date');

        $searchModel = new \bc\modules\selection\models\form\DashboardSearchForm($params);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 30, null, $select);

        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere(['training_status' => 3]);
        $dataProvider->query->andWhere(['bc_unwilling_bank' => 1]);
        if ($searchModel->bc_unwilling_bank_call_center != '') {
            if ($searchModel->bc_unwilling_bank_call_center == 1) {
                $dataProvider->query->andWhere(['bc_unwilling_bank_call_center' => 1]);
            }
            if ($searchModel->bc_unwilling_bank_call_center == 0) {
                $dataProvider->query->andWhere(['bc_unwilling_bank_call_center' => 0]);
            }
            if ($searchModel->bc_unwilling_bank_call_center == -1) {
                $dataProvider->query->andWhere(['IS ', 'srlm_bc_application.bc_unwilling_bank_call_center', new \yii\db\Expression('NULL')]);
            }
        }
        $dataProvider->query->addOrderBy("first_name asc");
        return $this->render('certified', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUnwilling() {
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $select1 = \bc\modules\selection\models\base\GenralModel::select_preselected_bc_column();
        $select2 = \bc\modules\selection\models\base\GenralModel::select_certified_bc_column();
        $select = array_merge($select1, $select2);
        array_push($select, 'srlm_bc_application.iibf_date');
        array_push($select, 'srlm_bc_application.pvr_upload_date');
        array_push($select, 'srlm_bc_application.assign_shg_datetime');
        array_push($select, 'srlm_bc_application.onboarding_date_time');
        array_push($select, 'srlm_bc_application.handheld_machine_date');
        array_push($select, 'srlm_bc_application.beneficiaries_code_date');
        array_push($select, 'srlm_bc_application.bc_beneficiaries_code_date');
        array_push($select, 'srlm_bc_application.bc_shg_funds_date');
        $searchModel = new \bc\modules\selection\models\form\DashboardSearchForm($params);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30'], null, $select);

        $dataProvider->query->andWhere(['=', 'srlm_bc_application.form_number', '6']);
        $dataProvider->query->andWhere(['=', 'srlm_bc_application.gender', '2']);
        $dataProvider->query->andWhere(['srlm_bc_application.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere(['srlm_bc_application.training_status' => SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING]);

        return $this->render('unwilling', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBlocked() {

        if (Yii::$app->request->isGet)
            $searchModel = new \bc\modules\selection\models\form\DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new \bc\modules\selection\models\form\DashboardSearchForm(Yii::$app->request->post());

        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->andWhere(['!=', 'srlm_bc_application.form_number', '0']);
        $dataProvider->query->andWhere(['=', 'srlm_bc_application.form_number', '6']);
        $dataProvider->query->andWhere(['=', 'srlm_bc_application.gender', '2']);
        $dataProvider->query->andWhere(['srlm_bc_application.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere(['!=', 'blocked', 0]);
        $dataProvider->query->andWhere(['!=', 'blocked', 2]);
        $dataProvider->query->andWhere(['!=', 'blocked', 21]);
        $dataProvider->query->andWhere(['srlm_bc_application.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        if ($searchModel->operational != '') {
            if ($searchModel->operational == 0) {
                $dataProvider->query->andWhere(['=', 'bc_operational', 0]);
            }
            if ($searchModel->operational == 1) {
                $dataProvider->query->andWhere(['=', 'bc_operational', 1]);
            }
        }
        return $this->render('blocked', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
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
