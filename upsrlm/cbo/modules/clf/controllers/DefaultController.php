<?php

namespace cbo\modules\clf\controllers;

use Yii;
use cbo\models\CboClf;
use cbo\models\CboClfSearch;
use cbo\models\form\CboClfForm;
use cbo\models\form\CboClfMembersForm;
use common\models\master\MasterRole;
use common\models\base\GenralModel;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * Default controller for the `clf` module
 */
class DefaultController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message = '';

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'shg', 'remove', 'onetimep'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU, MasterRole::ROLE_SMMU, MasterRole::ROLE_YOUNG_PROFESSIONAL, MasterRole::ROLE_MD, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_WADA_ADMIN]));
                        }
                    ],
                    [
                        'actions' => ['verify'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_YOUNG_PROFESSIONAL]));
                        }
                    ],
                    [
                        'actions' => ['remove', 'onetimep'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN,]));
                        }
                    ],
                    [
                        'actions' => ['create', 'update'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU]));
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'remove' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $searchModel = new CboClfSearch();
        if (in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_WADA_ADMIN])) {
          $searchModel->wada=1;    
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel->block_option = GenralModel::srlmblockopption($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($clfid) {
        return $this->render('view', [
                    'model' => $this->findModel($clfid),
        ]);
    }

    /**
     * Creates a new CboClf model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
//        if (Yii::$app->user->identity->dummy_column == '0') {
//            return $this->redirect(['/clf']);
//        }
        $model = new CboClfForm();
        $model->scenario = 'create';

        if (Yii::$app->request->isPost) {
            $model->passbook_photo = UploadedFile::getInstance($model, 'passbook_photo');
            $model->passbook_photo2 = UploadedFile::getInstance($model, 'passbook_photo2');
            if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($model->funds_model, Yii::$app->request->post()) && Model::loadMultiple($model->members_model, Yii::$app->request->post()) && $model->validate() && Model::validateMultiple($model->funds_model) && Model::validateMultiple($model->members_model)) {
                if ($model->save()) {
                    return $this->redirect(['/clf']);
                }
            } else {
                
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing CboClf model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($clfid) {
//        if (Yii::$app->user->identity->dummy_column == '0') {
//            return $this->redirect(['/clf']);
//        }
        $clf_model = $this->findModel($clfid);
        if ($clf_model->status == CboClf::STATUS_SAVE) {
            
        } else {
            Yii::$app->getSession()->setFlash('warning', "Not Allowed");
            return $this->redirect(['index']);
        }
        if (($clf_model->created_by == \Yii::$app->user->identity->id and $clf_model->edit_bmmu == '1') || in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) {
            
        } else {
            Yii::$app->getSession()->setFlash('warning', "Not Allowed - Permission denied");
            return $this->redirect(['index']);
        }


        $model = new CboClfForm($clf_model);
        if (Yii::$app->request->isPost) {
            $model->passbook_photo = UploadedFile::getInstance($model, 'passbook_photo');
            $model->passbook_photo2 = UploadedFile::getInstance($model, 'passbook_photo2');
            if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($model->funds_model, Yii::$app->request->post()) && Model::loadMultiple($model->members_model, Yii::$app->request->post()) && $model->validate() && Model::validateMultiple($model->funds_model) && Model::validateMultiple($model->members_model)) {

                if ($model->save()) {
                    return $this->redirect(['/clf']);
                }
            }
        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    public function actionVerify($clfid) {
        $clf_model = $this->findModel($clfid);

        $model = new \cbo\models\form\ClfVerifyForm($clf_model);

        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            //$model->shg_model->verification_status = 1;
            //$model->shg_model->verify_by = Yii::$app->user->identity->id;
            if ($model->return == "1") {
                $model->clf_model->status = 1;
                $model->clf_model->update();
                Yii::$app->getSession()->setFlash('success', $this->message);
                return $this->redirect(['/clf']);
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

    public function actionItemrow() {
        if (\Yii::$app->request->isAjax) {
            $i = time() + rand(0, time());
            $item = new CboClfMembersForm();
            $this->renderAjax('_member_row_form', ['item' => $item, 'i' => $i]);
        }
    }

    public function actionRemove($clfid) {
        $model = $this->findModel($clfid);
        $vo_link = \cbo\models\CboVo::find()->where(['cbo_clf_id' => $clfid])->count();
        $clf_members = \common\models\CboMembers::find()->where(['cbo_id' => $clfid, 'cbo_type' => 3])->count();
        if ($vo_link == '0' and $clf_members == '0') {
            $model->status = CboClf::STATUS_DELETE;
            if ($model->save()) {
                $condition = ['and',
                    ['=', 'cbo_clf_id', $model->id,],
                    ['!=', 'status', -1],
                ];
                \cbo\models\CboClfMembers::updateAll([
                    'status' => -1,
                        ], $condition);
                $this->message = 'Remove CLF ' . $model->name_of_clf . ' successfully';
                Yii::$app->getSession()->setFlash('success', $this->message);
                return $this->redirect(['/clf']);
            }
        } else {
            return $this->redirect(['/clf']);
        }
    }

    public function actionOnetimep() {
        $models = CboClf::find()->all();
        foreach ($models as $model) {
            $model->save();
        }
        return $this->redirect(['/clf/dashboard']);
    }

    protected function findModel($id) {
        if (($model = CboClf::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
