<?php

namespace bccallcenter\modules\shg\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use Mpdf\Mpdf;
use yii\web\UploadedFile;
use cbo\models\Shg;
use cbo\models\ShgSearch;
use cbo\models\form\ShgVerifyCSTForm;
use common\models\base\GenralModel;
use common\models\master\MasterRole;
use cbo\models\CboMasterMemberDesignation;

/**
 * Default controller for the `shg` module
 */
class DefaultController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message = '';

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'verifychairperson', 'verifysecretary', 'verifytreasurer'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'verifychairperson', 'verifysecretary', 'verifytreasurer'],
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
        $searchModel = new ShgSearch();
        if (Yii::$app->request->isGet)
            $dataProvider = $searchModel->searchbccall(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (Yii::$app->request->isPost)
            $dataProvider = $searchModel->searchbccall(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }
        $searchModel->verify_option = [1 => 'Member detail correct', 0 => 'Member detail wrong'];
        $searchModel->return_option = [1 => 'Return'];
        if (isset($searchModel->return) and $searchModel->return != '') {
            $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.verification_status' => 1]);
            $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.verify_mobile_no' => 0]);
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Shg model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($shgid) {
        return $this->render('view', [
                    'model' => $this->findModel($shgid),
        ]);
    }

//    public function actionVerifychairperson($shgid) {
//        $shg_model = $this->findModel($shgid);
//        if ($shg_model->verify_over_all == 0 and $shg_model->verify_chaire_person == 0 and $shg_model->getProrole() == 0 and isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SUPPORT_UNIT])) {
//            
//        } else {
//            return $this->redirect(['/shg']);
//        }
//        $model = new ShgVerifyCSTForm($shg_model, CboMasterMemberDesignation::SHG_CHAIRPERSON);
//        $model->scenario = 'chairperson';
//        $model->verify_chaire_person = 2;
//        $this->performAjaxValidation($model);
//        if ($model->load(Yii::$app->request->post())) {
//            $model->shg_model->verify_shg_member_by = Yii::$app->user->identity->id;
//            $model->shg_model->verify_shg_member_datetime = new \yii\db\Expression('NOW()');
//            if ($model->verify_ques1 == '1' and $model->verify_ques2 == '1' and $model->verify_ques3 == 1) {
//                $model->verify_chaire_person = 1;
//            }
//            $model->shg_model->verify_chaire_person = $model->verify_chaire_person;
//            $model->shg_model->verify_ques1 = $model->verify_ques1;
//            $model->shg_model->verify_ques2 = $model->verify_ques2;
//            $model->shg_model->verify_ques3 = $model->verify_ques3;
//
//            if ($model->shg_model->verify_chaire_person == '1') {
//                $model->shg_model->verify_over_all = 1;
//            }
//            if ($model->SaveUser() and $model->shg_model->update()) {
//                 $this->message = 'Verify Chairperson successfully';
//                Yii::$app->getSession()->setFlash('success', $this->message);
//                return $this->redirect(['/shg']);
//            }
//        }
//        if (\Yii::$app->request->isAjax) {
//
//            return $this->renderAjax('_verifychairpersonform', [
//                        'model' => $model,
//            ]);
//        } else {
//            return $this->render('_verifychairpersonform', [
//                        'model' => $model,
//            ]);
//        }
//    }
//
//    public function actionVerifysecretary($shgid) {
//        $shg_model = $this->findModel($shgid);
//        if ($shg_model->verify_over_all == 0 and $shg_model->verify_chaire_person == 2 and $shg_model->getSeorole() == 0 and isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SUPPORT_UNIT])) {
//            
//        } else {
//            return $this->redirect(['/shg']);
//        }
//        $model = new ShgVerifyCSTForm($shg_model, CboMasterMemberDesignation::SHG_SECRETARY);
//        $model->verify_secretary = 2;
//        $model->scenario = 'secretary';
//        $this->performAjaxValidation($model);
//        if ($model->load(Yii::$app->request->post())) {
//            $model->shg_model->verify_shg_member_by = Yii::$app->user->identity->id;
//            $model->shg_model->verify_shg_member_datetime = new \yii\db\Expression('NOW()');
//
//            if ($model->verify_s_ques1 == '1' and $model->verify_s_ques2 == '1' and $model->verify_s_ques3 == 1) {
//                $model->verify_secretary = 1;
//            }
//            $model->shg_model->verify_secretary = $model->verify_secretary;
//            $model->shg_model->verify_s_ques1 = $model->verify_s_ques1;
//            $model->shg_model->verify_s_ques2 = $model->verify_s_ques2;
//            $model->shg_model->verify_s_ques3 = $model->verify_s_ques3;
//
//            if ($model->shg_model->verify_secretary == '1') {
//                $model->shg_model->verify_over_all = 1;
//            }
//            if ($model->SaveUser() and $model->shg_model->update()) {
//                $this->message = 'Verify Secretary successfully';
//                Yii::$app->getSession()->setFlash('success', $this->message);
//                return $this->redirect(['/shg']);
//            }
//        }
//        if (\Yii::$app->request->isAjax) {
//
//            return $this->renderAjax('_verifysecretaryform', [
//                        'model' => $model,
//            ]);
//        } else {
//            return $this->render('_verifysecretaryform', [
//                        'model' => $model,
//            ]);
//        }
//    }
//
//    public function actionVerifytreasurer($shgid) {
//        $shg_model = $this->findModel($shgid);
//        if ($shg_model->verify_over_all == 0 and $shg_model->verify_secretary == 2 and $shg_model->getTrorole() == 0 and isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SUPPORT_UNIT])) {
//            
//        } else {
//            return $this->redirect(['/shg']);
//        }
//        $model = new ShgVerifyCSTForm($shg_model, CboMasterMemberDesignation::SHG_TREASURER);
//        $model->verify_treasurer = 2;
//        $model->scenario = 'treasurer';
//        $this->performAjaxValidation($model);
//        if ($model->load(Yii::$app->request->post())) {
//            $model->shg_model->verify_shg_member_by = Yii::$app->user->identity->id;
//            $model->shg_model->verify_shg_member_datetime = new \yii\db\Expression('NOW()');
//            if ($model->verify_t_ques1 == '1' and $model->verify_t_ques2 == '1' and $model->verify_t_ques3 == 1) {
//                $model->verify_treasurer = 1;
//            }
//            $model->shg_model->verify_t_ques1 = $model->verify_t_ques1;
//            $model->shg_model->verify_t_ques2 = $model->verify_t_ques2;
//            $model->shg_model->verify_t_ques3 = $model->verify_t_ques3;
//
//            $model->shg_model->verify_treasurer = $model->verify_treasurer;
//            if ($model->shg_model->verify_treasurer == '1') {
//                $model->shg_model->verify_over_all = 1;
//            }
//            if ($model->SaveUser() and $model->shg_model->update()) {
//                $this->message = 'Verify Treasurer successfully';
//                Yii::$app->getSession()->setFlash('success', $this->message);
//                return $this->redirect(['/shg']);
//            }
//        }
//        if (\Yii::$app->request->isAjax) {
//
//            return $this->renderAjax('_verifytreasurerform', [
//                        'model' => $model,
//            ]);
//        } else {
//            return $this->render('_verifytreasurerform', [
//                        'model' => $model,
//            ]);
//        }
//    }

    protected function findModel($id) {
        if (($model = Shg::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
