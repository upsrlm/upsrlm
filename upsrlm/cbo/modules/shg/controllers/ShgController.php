<?php

namespace cbo\modules\shg\controllers;

use Yii;
use cbo\models\Shg;
use app\modules\shg\models\ShgSearch;
use app\modules\shg\models\form\ShgForm;
use app\modules\shg\models\form\ShgVerifyForm;
use common\models\base\GenralModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\master\MasterRole;
use kartik\mpdf\Pdf;
use Mpdf\Mpdf;

/**
 * ShgController implements the CRUD actions for Shg model.
 */
class ShgController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message = '';

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'verify'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU, MasterRole::ROLE_SMMU, MasterRole::ROLE_BACKEND_OPERATOR, MasterRole::ROLE_YOUNG_PROFESSIONAL]));
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Shg models.
     * @return mixed
     */
//    public function actionIndex() {
//        $searchModel = new ShgSearch();
//        if (MasterRole::ROLE_YOUNG_PROFESSIONAL == Yii::$app->user->identity->role) {
//            $searchModel->verification_status = 0;
//        }
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
//        $searchModel->block_option = GenralModel::optionblock($searchModel);
//        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
//        //$searchModel->gp_option = \app\modules\shg\models\base\GenralModel::nfsaoptiongp($searchModel);
//        // print_r(\app\modules\shg\models\base\GenralModel::nfsaoptiongp($this));exit;
//        //$searchModel->village_option = \app\modules\shg\models\base\GenralModel::optionvillage($searchModel);
//        $searchModel->verify_option = [1 => 'Member detail correct', 0 => 'Member detail wrong'];
//        return $this->render('index', [
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//        ]);
//    }
//
//    public function actionVerify($id) {
//        $shg_model = $this->findModel($id);
//
//        $model = new ShgVerifyForm($shg_model);
//
//        $this->performAjaxValidation($model);
//        if ($model->load(Yii::$app->request->post())) {
//            $model->shg_model->verification_status = 1;
//            $model->shg_model->verify_by = Yii::$app->user->identity->id;
//            if ($model->verify_shg_location == "1" and $model->verify_shg_name == "1" and $model->verify_shg_members == "1" and $model->verify_chaire_person_mobile_no == "1" and $model->verify_secretary_mobile_no == "1" and $model->verify_treasurer_mobile_no == "1") {
//                $model->shg_model->verify_mobile_no = 1;
//            }
//            $model->shg_model->verify_chaire_person_mobile_no = $model->verify_chaire_person_mobile_no;
//            $model->shg_model->verify_secretary_mobile_no = $model->verify_secretary_mobile_no;
//            $model->shg_model->verify_treasurer_mobile_no = $model->verify_treasurer_mobile_no;
//            $model->shg_model->verify_shg_code = $model->verify_shg_code;
//            $model->shg_model->verify_datetime = new \yii\db\Expression('NOW()');
//            $model->shg_model->update();
//            Yii::$app->getSession()->setFlash('success', $this->message);
//            return $this->redirect(['index']);
//        }
//        if (\Yii::$app->request->isAjax) {
//
//            return $this->renderAjax('_verifyform', [
//                        'model' => $model,
//            ]);
//        } else {
//            return $this->render('_verifyform', [
//                        'model' => $model,
//            ]);
//        }
//    }
//
//    /**
//     * Displays a single Shg model.
//     * @param integer $id
//     * @return mixed
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionView($id) {
//        return $this->render('view', [
//                    'model' => $this->findModel($id),
//        ]);
//    }
//
//    /**
//     * Creates a new Shg model.
//     * If creation is successful, the browser will be redirected to the 'view' page.
//     * @return mixed
//     */
//    public function actionCreate() {
//        $model = new ShgForm();
//
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            $model->save();
//            return $this->redirect(['index']);
//        }
//
//        return $this->render('create', [
//                    'model' => $model,
//        ]);
//    }
//
//    /**
//     * Updates an existing Shg model.
//     * If update is successful, the browser will be redirected to the 'view' page.
//     * @param integer $id
//     * @return mixed
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionUpdate($id) {
//        $shg_model = $this->findModel($id);
//        $model = new ShgForm($shg_model);
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            $model->save();
//            return $this->redirect(['index']);
//        }
//
//        return $this->render('update', [
//                    'model' => $model,
//        ]);
//    }
//
//    /**
//     * Deletes an existing Shg model.
//     * If deletion is successful, the browser will be redirected to the 'index' page.
//     * @param integer $id
//     * @return mixed
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    public function actionDelete($id) {
//        //$this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the Shg model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shg the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Shg::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
