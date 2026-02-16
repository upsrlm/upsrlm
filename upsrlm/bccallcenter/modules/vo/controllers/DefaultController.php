<?php

namespace bccallcenter\modules\vo\controllers;

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
                'only' => ['index', 'view', 'verifysamuhsakhi'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'verifysamuhsakhi'],
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

    public function actionIndex() {
        $searchModel = new CboVoSearch();
        //$searchModel->samuh_sakhi = 1;
        $dataProvider = $searchModel->searchbccall(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }
        $searchModel->cast_option = \yii\helpers\ArrayHelper::map(\cbo\models\master\CboMasterCast::find()->all(), 'id', 'name_hi');
        $searchModel->mobile_type_option = \yii\helpers\ArrayHelper::map(\cbo\models\master\CboMasterPhoneType::find()->all(), 'id', 'name_hi');
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

//    public function actionVerifysamuhsakhi($void) {
//        $vo_model = $this->findModel($void);
//        if ($vo_model->samuh_sakhi_cbo_shg_id and $vo_model->verification_status_samuh_sakhi == 0 and $vo_model->samuh_sakhi_name != null and $vo_model->getSamuhsakirole() == 0) {
//            
//        } else {
//            return $this->redirect(['/vo']);
//        }
//        $model = new \cbo\models\form\VoSamuhSakhiVerificationForm($vo_model);
//
//        $this->performAjaxValidation($model);
//        if ($model->load(Yii::$app->request->post())) {
//            $model->vo_model->verify_samuh_sakhi_detail_by = Yii::$app->user->identity->id;
//            $model->vo_model->verify_samuh_sakhi_detail_date = new \yii\db\Expression('NOW()');
//            $model->vo_model->verification_status_samuh_sakhi = $model->verification_status_samuh_sakhi;
//            if ($model->vo_model->update() and $model->SaveUser()) {
//                $this->message = 'Verify Samuh Sakhi successfully';
//                Yii::$app->getSession()->setFlash('success', $this->message);
//                return $this->redirect(['/vo']);
//            }
//        }
//        if (\Yii::$app->request->isAjax) {
//
//            return $this->renderAjax('_verifysamuhsakhiform', [
//                        'model' => $model,
//            ]);
//        } else {
//            return $this->render('_verifysamuhsakhiform', [
//                        'model' => $model,
//            ]);
//        }
//    }

    protected function findModel($id) {
        if (($model = CboVo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
