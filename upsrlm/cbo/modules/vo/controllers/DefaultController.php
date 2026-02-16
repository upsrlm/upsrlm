<?php

namespace cbo\modules\vo\controllers;

use Yii;
use cbo\models\CboVo;
use cbo\models\CboVoSearch;
use cbo\models\form\CboVoForm;
use cbo\models\form\CboVoMembersForm;
use common\models\master\MasterRole;
use common\models\base\GenralModel;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

ini_set('memory_limit', '-1');

/**
 * Default controller for the `vo` module
 */
class DefaultController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message = '';

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'shg', 'samuhsakhi', 'verifysamuhsakhi', 'urban'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'urban'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU, MasterRole::ROLE_SMMU, MasterRole::ROLE_YOUNG_PROFESSIONAL, MasterRole::ROLE_MD, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_WADA_ADMIN]));
                        }
                    ],
                    [
                        'actions' => ['verify'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_YOUNG_PROFESSIONAL, MasterRole::ROLE_DMMU]));
                        }
                    ],
                    [
                        'actions' => ['create', 'update', 'samuhsakhi'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU]));
                        }
                    ],
                    [
                        'actions' => ['verifysamuhsakhi'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $searchModel = new CboVoSearch();
        $searchModel->urban_vo = 0;
        if (in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_WADA_ADMIN])) {
            $searchModel->wada = 1;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel->block_option = GenralModel::srlmblockopption($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if ($searchModel->block_code) {
            $searchModel->gp_option = GenralModel::nfsaoptiongp($searchModel);
        }
        $searchModel->cast_option = \yii\helpers\ArrayHelper::map(\cbo\models\master\CboMasterCast::find()->all(), 'id', 'name_hi');
        $searchModel->mobile_type_option = \yii\helpers\ArrayHelper::map(\cbo\models\master\CboMasterPhoneType::find()->all(), 'id', 'name_hi');
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUrban() {
        $searchModel = new CboVoSearch();
        $searchModel->urban_vo = 1;
        if (in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_WADA_ADMIN])) {
            $searchModel->wada = 1;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel->block_option = GenralModel::srlmblockopption($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if ($searchModel->block_code) {
            $searchModel->gp_option = GenralModel::nfsaoptiongp($searchModel);
        }
        $searchModel->cast_option = \yii\helpers\ArrayHelper::map(\cbo\models\master\CboMasterCast::find()->all(), 'id', 'name_hi');
        $searchModel->mobile_type_option = \yii\helpers\ArrayHelper::map(\cbo\models\master\CboMasterPhoneType::find()->all(), 'id', 'name_hi');
        return $this->render('urban', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($shgid) {
        return $this->render('view', [
                    'model' => $this->findModel($shgid),
        ]);
    }

    public function actionVerify($void) {
        $vo_model = $this->findModel($void);
        if (isset(Yii::$app->user->identity) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BMMU])) {
            if (!in_array($vo_model->district_code, \yii\helpers\ArrayHelper::getColumn(Yii::$app->user->identity->districts, 'district_code'))) {
                Yii::$app->getSession()->setFlash('warning', "Not Allowed - Permission denied");
                return $this->redirect(['/vo']);
            }
        }
        if ($vo_model->verification_status == 1) {
            Yii::$app->getSession()->setFlash('warning', "Not Allowed - Already verified");
            return $this->redirect(['/vo']);
        }
        $model = new \cbo\models\form\VoVerifyForm($vo_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            $model->vo_model->verify_vo_name_code_address = $model->verify_vo_name_code_address;
            $model->vo_model->verify_vo_formation_date_no_shg = $model->verify_vo_formation_date_no_shg;
            $model->vo_model->verify_vo_related_to_bank_account = $model->verify_vo_related_to_bank_account;
            $model->vo_model->verify_vo_total_amount = $model->verify_vo_total_amount;
            $model->vo_model->verify_vo_affiliated_shg_detail = $model->verify_vo_affiliated_shg_detail;
            $model->vo_model->verify_vo_members_detail = $model->verify_vo_members_detail;
            $model->vo_model->verify_vo_any_other_info = $model->verify_vo_any_other_info;
            if ($model->verify_vo_name_code_address == 1 and $model->verify_vo_formation_date_no_shg == 1 and $model->verify_vo_related_to_bank_account == 1 and $model->verify_vo_total_amount == 1 and $model->verify_vo_affiliated_shg_detail == 1 and $model->verify_vo_members_detail == 1 and $model->verify_vo_any_other_info == 1) {
                $model->vo_model->verification_status = 1;
            } else {
                $model->vo_model->verification_status = 2;
            }
            $model->vo_model->verify_by = Yii::$app->user->identity->id;
            $model->vo_model->verify_datetime = new \yii\db\Expression('NOW()');
            if ($model->vo_model->update()) {
//                Yii::$app->getSession()->setFlash('success', $this->message);
                return $this->redirect(['/vo']);
            }
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_verifyform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_verifyform', [
                        'model' => $model,
            ]);
        }
    }

    public function actionSamuhsakhi($void) {
        $vo_model = $this->findModel($void);
        if ($vo_model->created_by == \Yii::$app->user->identity->id) {
            
        } else {
            Yii::$app->getSession()->setFlash('warning', "Not Allowed - Permission denied");
            return $this->redirect(['index']);
        }

        $model = new \cbo\models\form\VoSamuhSakhiForm($vo_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {

            return $this->redirect(['/vo']);
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_samuhsakhiform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_samuhsakhiform', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new CboVo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
//        return $this->redirect(['/vo']);
        $model = new CboVoForm();

        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($model->funds_model, Yii::$app->request->post()) && Model::loadMultiple($model->members_model, Yii::$app->request->post()) && $model->validate() && Model::validateMultiple($model->funds_model) && Model::validateMultiple($model->members_model)) {
            if ($model->save()) {
                return $this->redirect(['/vo']);
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing CboVo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($void) {
//       return $this->redirect(['/vo']);
        $vo_model = $this->findModel($void);
        if ($vo_model->status == CboVo::STATUS_SAVE) {
            
        } else {
            Yii::$app->getSession()->setFlash('warning', "Not Allowed");
            return $this->redirect(['index']);
        }
        if ($vo_model->created_by == \Yii::$app->user->identity->id and $vo_model->edit_bmmu == '1') {
            
        } else {
            Yii::$app->getSession()->setFlash('warning', "Not Allowed - Permission denied");
            return $this->redirect(['index']);
        }


        $model = new CboVoForm($vo_model);
        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($model->funds_model, Yii::$app->request->post()) && Model::loadMultiple($model->members_model, Yii::$app->request->post()) && $model->validate() && Model::validateMultiple($model->funds_model) && Model::validateMultiple($model->members_model)) {
            if ($model->save()) {
                return $this->redirect(['/vo']);
            }
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    public function actionItemrow() {
        if (\Yii::$app->request->isAjax) {
            $i = time() + rand(0, time());
            $item = new CboVoMembersForm();
            $this->renderAjax('_member_row_form', ['item' => $item, 'i' => $i]);
        }
    }

    public function actionDelete($id) {
        //$this->findModel($id)->delete();

        return $this->redirect(['/vo']);
    }

    public function actionVerifysamuhsakhi($void) {
        $vo_model = $this->findModel($void);
        if ($vo_model->samuh_sakhi_cbo_shg_id and $vo_model->verification_status_samuh_sakhi == 0 and $vo_model->samuh_sakhi_name != null and $vo_model->getSamuhsakirole() == 0) {
            
        } else {
            return $this->redirect(['/vo']);
        }
        $model = new \cbo\models\form\VoSamuhSakhiVerificationForm($vo_model);

        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            $model->vo_model->verify_samuh_sakhi_detail_by = Yii::$app->user->identity->id;
            $model->vo_model->verify_samuh_sakhi_detail_date = new \yii\db\Expression('NOW()');
            $model->vo_model->verification_status_samuh_sakhi = $model->verification_status_samuh_sakhi;
            if ($model->vo_model->update() and $model->SaveUser()) {
                $this->message = 'Verify Samuh Sakhi successfully';
                Yii::$app->getSession()->setFlash('success', $this->message);
                return $this->redirect(['/vo']);
            }
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_verifysamuhsakhiform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_verifysamuhsakhiform', [
                        'model' => $model,
            ]);
        }
    }

    protected function findModel($id) {
        if (($model = CboVo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
