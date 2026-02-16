<?php

namespace bc\modules\partneragencies\controllers;

use Yii;
use bc\modules\selection\models\SrlmBcApplication;
use bc\models\master\MasterPartnerBank;
use bc\models\master\MasterGramPanchayat;
use bc\models\master\MasterGramPanchayatSearch;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BcController implements the CRUD actions for PartnerAssociates model.
 */
class GpController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message;

    public function beforeAction($action) {

        Yii::$app->request->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['in', 'out', 'ajaxupdate'],
                'rules' => [
                    [
                        'actions' => ['in', 'out', 'ajaxupdate'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'block' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all PartnerAssociates models.
     * @return mixed
     */
    public function actionIn() {
        $searchModel = new MasterGramPanchayatSearch();
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $dataProvider = $searchModel->searchin($params, Yii::$app->user->identity, 30);

        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }
        return $this->render('in', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOut() {
        $searchModel = new MasterGramPanchayatSearch();
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $dataProvider = $searchModel->searchout($params, Yii::$app->user->identity, 30);

        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }
        return $this->render('out', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOnboarding($gram_panchayat_code) {
        $gp_model = $this->findModelbycodebc($gram_panchayat_code);
        $bc_onboard = SrlmBcApplication::find()->where(['gram_panchayat_code' => $gram_panchayat_code])->andWhere(['=', 'srlm_bc_application.status', 2])->andWhere(['srlm_bc_application.gender' => 2, 'srlm_bc_application.form_number' => 6, 'srlm_bc_application.training_status' => 3])->andWhere(['not', ['srlm_bc_application.bankidbc' => null]])->one();
        if ($bc_onboard != null and $gp_model->change_status==1) {
            $model = new \bc\modules\training\models\form\TempOnboardingForm($bc_onboard);
            $this->performAjaxValidation($model);
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $gp_model->change_status=2;
                    $model->bc_application_model->temp_bankidbc = $model->temp_bankidbc;
                    $model->bc_application_model->temp_bankidbc_by = Yii::$app->user->identity->id;
                    $model->bc_application_model->temp_bankidbc_datetime = new \yii\db\Expression('NOW()');
                    $model->bc_application_model->action_type = SrlmBcApplication::ACTION_TYPE_BC_TEMP_BANKBCID;
                    if ($model->bc_application_model->save() and $gp_model->save()) {
                        return $this->redirect(['/partneragencies/gp/in?MasterGramPanchayatSearch[district_code]=' . $gp_model->district_code . '&MasterGramPanchayatSearch[block_code]=' . $gp_model->block_code]);
                    }
                }
            }

            if (\Yii::$app->request->isAjax) {
                return $this->renderAjax('_onboardingform', [
                            'model' => $model,
                ]);
            } else {
                return $this->render('_onboardingform', [
                            'model' => $model,
                ]);
            }
        } else {
           // \Yii::$app->getSession()->setFlash('error', "Anther BC is already Certified/Selected in this GP; the training status can't be updated");
            $js = "window.location.href = '/partneragencies/gp/in?MasterGramPanchayatSearch[district_code]=' . $gp_model->district_code . '&MasterGramPanchayatSearch[block_code]=' . $gp_model->block_code'";
            $this->getView()->registerJs($js);
        }
    }

    public function actionAjaxupdate($change_status, $gram_panchayat_code) {
        $model = MasterGramPanchayat::findOne(['gram_panchayat_code' => $gram_panchayat_code]);
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($model != null) {
                $model->change_status = $change_status;
                if ($model->save()) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ['output' => $model->change_status, 'message' => ''];
                } else {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ['output' => $model->change_status, 'message' => ''];
                }
            }
        }
    }

    protected function findModelbycodebc($gram_panchayat_code) {
        if (($model = \bc\models\master\MasterGramPanchayat::findOne(['gram_panchayat_code' => $gram_panchayat_code])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
