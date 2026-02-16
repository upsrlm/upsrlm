<?php

namespace bccallcenter\modules\platform\controllers;

use yii\web\Controller;
use Yii;
use yii\filters\VerbFilter;
use common\models\dynamicdb\internalcallcenter\platform\search\CallingListSearch;
use common\models\dynamicdb\internalcallcenter\platform\CallingList;
use common\models\dynamicdb\internalcallcenter\platform\CallingScenarioList;
use common\models\dynamicdb\internalcallcenter\platform\form\CallingListForm;
use common\models\User;
use common\models\CboMemberProfile;
use common\models\CboMembers;
use common\models\master\MasterRole;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiLog;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiLogSearch;

class CallController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function BeforeAction($action) {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'scenario', 'scenarioatend'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'scenario', 'scenarioatend'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'scenarioatend' => ['post', 'get'],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionScenario($bcid) {
         if (!\Yii::$app->params['airphone_call']) {
            \Yii::$app->getSession()->setFlash('success', 'Contact to admin');
            $this->redirect(['/dashboard']);
        }
        $bc_model = $this->findBcModel($bcid);
        $model = new \common\models\dynamicdb\internalcallcenter\bc\form\CallScenarioForm($bc_model);
        $model->bcid = $bcid;
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {

                $bc_calling_model = new \common\models\dynamicdb\internalcallcenter\bc\bcCallingLog();
                $bc_calling_model->bc_application_id = $bc_model->id;
                $bc_calling_model->customer_number = $bc_model->mobile_no;
                $bc_calling_model->calling_agent_number = \Yii::$app->user->identity->username;
                $bc_calling_model->calling_agent_id = \Yii::$app->user->identity->id;
                if (Yii::$app->user->identity->role == MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE) {
                    $bc_calling_model->caller_group_id = 1;
                } elseif (Yii::$app->user->identity->role == MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE) {
                    $bc_calling_model->caller_group_id = 2;
                } else {
                    $bc_calling_model->caller_group_id = 0;
                }

                $bc_calling_model->call_generate_date = date('Y-m-d');
                $bc_calling_model->default_call_scenario_id = $model->scenario;
                $bc_calling_model->call_scenario = $model->scenario;
                $bc_calling_model->cbo_shg_id = $bc_model->cbo_shg_id;
                $shg_model = \cbo\models\Shg::findOne($bc_model->cbo_shg_id);
                if ($shg_model != null) {
                    $bc_calling_model->name_of_shg = $shg_model->name_of_shg;
                }
                $bc_calling_model->bc_name = $bc_model->name;
                $bc_calling_model->bc_user_id = $bc_model->user_id;
                $bc_calling_model->bc_district_code = $bc_model->district_code;
                $bc_calling_model->bc_district_name = $bc_model->district_name;
                $bc_calling_model->bc_block_code = $bc_model->block_code;
                $bc_calling_model->bc_block_name = $bc_model->block_name;
                $bc_calling_model->bc_gram_panchayat_code = $bc_model->gram_panchayat_code;
                $bc_calling_model->bc_gram_panchayat_name = $bc_model->gram_panchayat_name;
                $bc_calling_model->bc_village_code = $bc_model->village_code;
                $bc_calling_model->bc_village_name = $bc_model->village_name;
                $bc_calling_model->upsrlm_call_type = 1;

                if ($bc_calling_model->save()) {
                    $this->redirect(['/platform/default/callrequest?calling_list_id=' . $bc_calling_model->id]);
                } else {
//                    echo "<pre>";
//                    print_r($bc_calling_model->getErrors());
//                    echo 'rahman';
//                    exit;
                }
            }
        }

        return $this->render('_form', ['model' => $model]);
    }

    public function actionScenarioatend($bcid, $scenario, $alt = 0) {
        if (!\Yii::$app->params['airphone_call']) {
            \Yii::$app->getSession()->setFlash('success', 'Contact to admin');
            return $this->redirect(['/dashboard']);            exit();
        }
        $bc_model = $this->findBcModel($bcid);
        $model = new \common\models\dynamicdb\internalcallcenter\bc\form\CallScenarioForm($bc_model);
        $model->bcid = $bcid;
        $model->scenario = $scenario;
        if ($model->validate()) {

            $bc_calling_model = new \common\models\dynamicdb\internalcallcenter\bc\bcCallingLog();
            $bc_calling_model->bc_application_id = $bc_model->id;
            if ($alt and $bc_model->alt_mobile_no and preg_match('/^[6-9]\d{9}$/', $bc_model->alt_mobile_no)) {
                $bc_calling_model->customer_number = $bc_model->alt_mobile_no;
            } else {
                $bc_calling_model->customer_number = $bc_model->mobile_no;
            }
            $bc_calling_model->calling_agent_number = \Yii::$app->user->identity->username;
            $bc_calling_model->calling_agent_id = \Yii::$app->user->identity->id;
            if (Yii::$app->user->identity->role == MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE) {
                $bc_calling_model->caller_group_id = 1;
            } elseif (Yii::$app->user->identity->role == MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE) {
                $bc_calling_model->caller_group_id = 2;
            } else {
                $bc_calling_model->caller_group_id = 0;
            }

            $bc_calling_model->call_generate_date = date('Y-m-d');
            $bc_calling_model->default_call_scenario_id = $model->scenario;
            $bc_calling_model->call_scenario = $model->scenario;
            $bc_calling_model->cbo_shg_id = $bc_model->cbo_shg_id;
            $shg_model = \cbo\models\Shg::findOne($bc_model->cbo_shg_id);
            if ($shg_model != null) {
                $bc_calling_model->name_of_shg = $shg_model->name_of_shg;
            }
            $bc_calling_model->bc_name = $bc_model->name;
            $bc_calling_model->bc_user_id = $bc_model->user_id;
            $bc_calling_model->bc_district_code = $bc_model->district_code;
            $bc_calling_model->bc_district_name = $bc_model->district_name;
            $bc_calling_model->bc_block_code = $bc_model->block_code;
            $bc_calling_model->bc_block_name = $bc_model->block_name;
            $bc_calling_model->bc_gram_panchayat_code = $bc_model->gram_panchayat_code;
            $bc_calling_model->bc_gram_panchayat_name = $bc_model->gram_panchayat_name;
            $bc_calling_model->bc_village_code = $bc_model->village_code;
            $bc_calling_model->bc_village_name = $bc_model->village_name;
            $bc_calling_model->bc_tracking_open = $bc_model->bc_tracking_open;
            $bc_calling_model->upsrlm_call_type = 1;

            if ($bc_calling_model->save()) {
                $this->redirect(['/platform/default/callrequest?calling_list_id=' . $bc_calling_model->id]);
            } else {
//                    echo "<pre>";
//                    print_r($bc_calling_model->getErrors());
//                    echo 'rahman';
//                    exit;
            }
        }


        return $this->render('_form', ['model' => $model]);
    }

    /**
     * Find Assigned Calling Model 
     *
     * @param [type] $calling_list_id
     * @return void
     */
    protected function findBcModel($id) {
        if (($model = \bc\modules\selection\models\SrlmBcApplication::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }
}
