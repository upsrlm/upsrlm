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
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\modules\selection\models\form\DashboardSearchForm;
use bc\modules\training\models\form\AddScoreForm;
use common\models\master\MasterRole;
use yii\web\UploadedFile;
use common\models\CboMembers;
use common\models\User;
use common\models\CboMemberProfile;

/**
 * Default controller for the `bc` module
 */
class UnwillingController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'call','certified','final','callcertified'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'call','certified','final','callcertified'],
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
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 30, null, \bc\modules\selection\models\base\GenralModel::select_preselected_bc_column());

        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['training_status' => 0]);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere(['bc_unwilling_rsetis' => 1]);
        if ($searchModel->bc_unwilling_call_center != '') {
            if ($searchModel->bc_unwilling_call_center == 1) {
                $dataProvider->query->andWhere(['bc_unwilling_call_center' => 1]);
            }
            if ($searchModel->bc_unwilling_call_center == 0) {
                $dataProvider->query->andWhere(['or',
                    ['=', 'srlm_bc_application.bc_unwilling_call_center', 0],
                ]);
            }
            if ($searchModel->bc_unwilling_call_center == -1) {
                $dataProvider->query->andWhere(['IS ', 'srlm_bc_application.bc_unwilling_call_center', new \yii\db\Expression('NULL')]);
            }
        }
        $dataProvider->query->addOrderBy("first_name asc");
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCertified() {
        $select = \bc\modules\selection\models\base\GenralModel::select_preselected_bc_column();
        array_push($select, 'srlm_bc_application.bc_unwilling_bank');
        array_push($select, 'srlm_bc_application.bc_unwilling_bank_call_center');
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 30, null, $select);

        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere(['bc_unwilling_bank' => 1]);
        $dataProvider->query->andWhere(['training_status' => 3]);
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
    public function actionFinal() {
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
    public function actionCall($id) {
        $bc_model = $this->findModelbc($id);
        $trainin_status = $bc_model->training_status;
        if (isset($bc_model) and $bc_model->bc_unwilling_call_center == 1) {
            return $this->redirect(['/bc/unwilling']);
        }

        if (!in_array($bc_model->training_status, [0, 1])) {
            return $this->redirect(['/bc/unwilling']);
        }
        $model = new \bc\modules\selection\models\form\UnwillingCallCenterForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {
            if (in_array($trainin_status, [3])) {
                return $this->redirect(['/bc/unwilling/certified?DashboardSearchForm[district_code]=' . $bc_model->district_code . '&DashboardSearchForm[bc_unwilling_call_center]=0']);
            } else {
                return $this->redirect(['/bc/unwilling?DashboardSearchForm[district_code]=' . $bc_model->district_code . '&DashboardSearchForm[bc_unwilling_call_center]=-1']);
                return $this->redirect(['/bc/unwilling']);
            }
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_call_center_unwilling_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_call_center_unwilling_form', [
                        'model' => $model,
            ]);
        }
    }

//    public function actionCallcertified($id) {
//        $bc_model = $this->findModelbc($id);
//        $trainin_status = $bc_model->training_status;
//        if (isset($bc_model) and $bc_model->bc_unwilling_call_center == 1) {
//            return $this->redirect(['/bc/unwilling']);
//        }
//
//        if (!in_array($bc_model->training_status, [3])) {
//            return $this->redirect(['/bc/unwilling']);
//        }
//        $model = new \bc\modules\selection\models\form\UnwillingBankCallCenterForm($bc_model);
//        $this->performAjaxValidation($model);
//        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {
//            return $this->redirect(['/bc/unwilling/certified?DashboardSearchForm[district_code]=' . $bc_model->district_code . '&DashboardSearchForm[bc_unwilling_call_center]=0']);
//        }
//        if (\Yii::$app->request->isAjax) {
//
//            return $this->renderAjax('_call_center_bank_unwilling_form', [
//                        'model' => $model,
//            ]);
//        } else {
//            return $this->render('_call_center_bank_unwilling_form', [
//                        'model' => $model,
//            ]);
//        }
//    }

    protected function findModelbc($id) {
        if (($model = SrlmBcApplication::find()->where(['id' => $id])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
