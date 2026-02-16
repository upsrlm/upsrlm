<?php

namespace bccallcenter\modules\platform\controllers;

use yii\web\Controller;
use Yii;
use common\models\dynamicdb\internalcallcenter\platform\search\CallingListSearch;
use common\models\dynamicdb\internalcallcenter\platform\CallingList;
use common\models\dynamicdb\internalcallcenter\platform\CallingScenarioList;
use common\models\dynamicdb\internalcallcenter\bc\form\CallingListForm;
use common\models\User;
use common\models\CboMemberProfile;
use common\models\CboMembers;
use common\models\master\MasterRole;
use common\models\dynamicdb\cbo_detail\RishtaShgSamuhSakhiSmsApppinStatus;

/**
 * Default controller for the `platform` module
 */
class DefaultController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function BeforeAction($action) {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'callrequest', 'fillform', 'validateform', 'inbound', 'callhistory'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'callrequest', 'fillform', 'validateform', 'inbound', 'callhistory'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Make a New Call Request
     *
     * @return void
     */
    public function actionCallrequest($calling_list_id) {
        $callingmodel = $this->findCallingModel($calling_list_id);
        $requestcallresult = $this->requestcallairphone($callingmodel->customer_number, $callingmodel->id, $callingmodel->default_call_scenario_id, $callingmodel);
//        if(Yii::$app->user->identity->username=='7838275272'){
//         $requestcallresult = $this->requestcallairphone($callingmodel->customer_number, $callingmodel->id, $callingmodel->default_call_scenario_id, $callingmodel);   
//        }else{
//        $requestcallresult = $this->requestcall($callingmodel->customer_number, $callingmodel->id, $callingmodel->default_call_scenario_id, $callingmodel);
//        }
        if ($requestcallresult['success']) {
            $callingmodel->api_call_log_id = $requestcallresult['log_id'];
            $callingmodel->callid = $requestcallresult['callid'];
            $callingmodel->calling_agent_number = Yii::$app->user->identity->username;
            $callingmodel->ctc_click_count = $callingmodel->ctc_click_count + 1;
            $callingmodel->save(false);
            $callingmodel->cloudteleapilog->calling_list_id = $callingmodel->id;
            $callingmodel->cloudteleapilog->cbo_shg_id = $callingmodel->cbo_shg_id != null ? $callingmodel->cbo_shg_id : 0;
            $callingmodel->cloudteleapilog->save(false);
            return $this->redirect(['fillform?calling_list_id=' . $calling_list_id]);
        } else {
            // Write Some code When APi Failed
            $callingmodel->save(false);
        }

        return $this->redirect(['/']);
    }

    /**
     * If Scneario Already Covred then Close this Call Manualy Without Calling
     *
     * @return void
     */
    public function actionClosecallrequest($calling_list_id) {
        $callingmodel = $this->findCallingModel($calling_list_id);
        $callingmodel->status = 2; //Manualy Close This Call
        $callingmodel->save(false);
        return $this->redirect(['/platform']);
    }

    /**
     * Fill Rest of The CTC Form
     *
     * @return void
     */
    public function actionFillform($calling_list_id) {
        $callingmodel = $this->findCallingModel($calling_list_id);
        if (!$callingmodel->api_call_log_id) {
            Yii::$app->getSession()->setFlash('danger', 'You are Trying to Access a Unauthroize Call');
            return $this->redirect(['/platform']);
        }
        $model = new CallingListForm($callingmodel);
        $model->call_start_time = date('Y-m-d H:i:s');
        $model->action_validate_url = '/platform/default/validateform?calling_list_id=' . $calling_list_id;

        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->call_end_time = date('Y-m-d H:i:s');
                $model->initializeForm();
                if ($model->calling_model->save()) {
                    if ($model->calling_model->callscneraio) {
                        $this->submitscenario();
                    }
                    if ($callingmodel->upsrlm_call_type == 2) {
                        return $this->redirect(['/dashboard']);
                    } else if ($callingmodel->refrence_page) {
                        if ($callingmodel->refrence_page == 'scneario') {
                            if ($callingmodel->default_call_scenario_id == 2002) {
                                return $this->redirect(['/dashboard']);
                            } else {
                                $redirect_url = "/dashboard";

                                return $this->redirect($redirect_url);
                            }
                        }
                    } else {
                        if (in_array($callingmodel->bc_district_code, \Yii::$app->params['igrs_disricts'])) {
                            return $this->redirect(['/bc/certified/igrs']);
                        }
                        if ($callingmodel->call_scenario == 550) {
                            return $this->redirect(['/tracking/bc/transaction']);
                        }
                        if ($model->alt_mobile_no and preg_match('/^[6-9]\d{9}$/', $model->alt_mobile_no)) {
//                            return $this->redirect(['/platform/call/scenarioatend?bcid=' . $model->bc_model->id . '&scenario=' . $model->calling_model->call_scenario . '&alt=1']);
                        }
                        return $this->redirect(['/dashboard']);
                    }
                }
            }
        }

        $render = 'fillform';
        if ($callingmodel->upsrlm_call_type == 2) {
            $render = 'fillform_ibd';
        }
        return $this->render($render, ['model' => $model]);
    }

    protected function submitscenario() {
        if (Yii::$app->request->isPost) {
            
        }
    }

    /**
     * Validate Form Model This Function Auto Save CTC Form Data 
     *
     * @param [type] $calling_list_id
     * @return array
     */
    public function actionValidateform($calling_list_id = null) {
        $callingmodel = null;
        if ($calling_list_id != null) {
            $callingmodel = $this->findCallingModel($calling_list_id);
        }

        $model = new CallingListForm($callingmodel);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->aftervalidatesave();
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    /**
     * Find Assigned Calling Model 
     *
     * @param [type] $calling_list_id
     * @return void
     */
    protected function findCallingModel($calling_list_id) {
        if (($model = \common\models\dynamicdb\internalcallcenter\bc\bcCallingLog::findOne($calling_list_id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Find Call APi Log
     *
     * @param [type] $api_log_id
     * @return void
     */
    protected function findCloudapilogModel($api_log_id) {
        if (($model = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::findOne($api_log_id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Submit Scenario : This function Use for Submit Scneario from CTC Page
     *
     * @return void
     */
    /**
     * Save a User Verification scenario / Function Name Should BE Equal to Scneario Form File name
     *
     * @param [type] $scnearioform
     * @param [type] $callingform
     * @return void
     */

    /**
     * Main Function for Connect With Third Party API (SARV CLOUD CALLING)
     *
     * @param [type] $to
     * @param [type] $calling_list_id
     * @return void
     */
    public static function requestcall($to, $calling_list_id, $call_scenario, $calling_model) {
        $apilog = new \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog();
        $curl = curl_init();
        $apilog->serviceuserid = \Yii::$app->params['sarvuserid'];
        $apilog->token = \Yii::$app->params['sarvtoken'];
        $apilog->upsrlm_user_id = Yii::$app->user->identity->id;
        $apilog->customernumber = $TO = $to;
        $apilog->upsrlm_call_type = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::CALL_TYPE_OUTBOUND;
        $apilog->calling_list_id = $calling_list_id;
        $apilog->upsrlm_call_scenario = $call_scenario;
        $apilog->project_id = 4;
        $apilog->bc_application_id = $calling_model->bc_application_id;
        $apilog->upsrlm_user_mobile_no = Yii::$app->user->identity->username;
        $FROM = Yii::$app->user->identity->username;
        curl_setopt_array($curl, array(
            CURLOPT_URL => \Yii::$app->params['sarvctcapiurl'] . "?user_id=" . $apilog->serviceuserid . "&token=" . $apilog->token . "&from=" . $apilog->upsrlm_user_mobile_no . "&to=" . $apilog->customernumber,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $result = curl_exec($curl);
        //  $result = '{}';
        $err = curl_error($curl);
        curl_close($curl);
        $response = json_decode($result, true);
        $apilog->api_response = $result;
        $apilog->callid = isset($response['callId']) ? $response['callId'] : NULL;
        $apilog->api_message = isset($response['message']) ? $response['message'] : NULL;
        $apilog->api_status = isset($response['status']) ? $response['status'] : NULL;
        $apilog->api_status_code = isset($response['code']) ? $response['code'] : 0;
        $apilog->api_request_datetime = new \yii\db\Expression('NOW()');
        if ($apilog->save(false)) {
            if (isset($response['status']) && $response['status'] == 'success') {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['success' => true, 'message' => 'success', 'log_id' => $apilog->id, 'callid' => $apilog->callid];
            } else if (isset($response['code']) && $response['code'] == '111') {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['success' => false, 'message' => 'Number Not Valid!.', 'log_id' => $apilog->id, 'callid' => $apilog->callid];
            } else {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['success' => false, 'message' => 'Number Not Valid!.', 'log_id' => $apilog->id, 'callid' => $apilog->callid];
                //return ['success' => true, 'message' => 'Number Not Valid!.', 'log_id' => $apilog->id, 'callid' => $apilog->callid];
            }
        }
    }

    public static function requestcallairphone($to, $calling_list_id, $call_scenario, $calling_model) {
        //$to='7451934797';
        $apilog = new \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog();
        $curl = curl_init();
        $apilog->serviceuserid = \Yii::$app->params['airphone_api_ctc_service_user_id'];
        $apilog->token = \Yii::$app->params['airphone_api_ctc_token'];
        $apilog->upsrlm_user_id = Yii::$app->user->identity->id;
        $apilog->customernumber = $TO = $to;
        $apilog->upsrlm_call_type = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::CALL_TYPE_OUTBOUND;
        $apilog->calling_list_id = $calling_list_id;
        $apilog->upsrlm_call_scenario = $call_scenario;
        $apilog->project_id = 4;
        $apilog->bc_application_id = $calling_model->bc_application_id;
        $apilog->upsrlm_user_mobile_no = Yii::$app->user->identity->username;
        $FROM = Yii::$app->user->identity->username;
        $calling_api_url = Yii::$app->params['airphone_api_ctc_url'] . "?vnm=" . Yii::$app->params['airphone_api_ctc_vnm'] . "&token=" . $apilog->token . "&agent=" . $FROM . "&caller=" . $apilog->customernumber;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $calling_api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $result = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
//        print_r($result);exit;
        $response = json_decode($result, true);
        $apilog->api_response = $result;
        $apilog->callid = isset($response['unique_id']) ? (string) $response['unique_id'] : NULL;
        $apilog->api_message = isset($response['message']) ? $response['message'] : NULL;
        $apilog->api_status = isset($response['status']) ? $response['status'] : NULL;
        if (isset($response['status']) && $response['status'] == 'success') {
            $apilog->api_status_code = 200;
        } else {
            $apilog->api_status_code = 500;
        }

        $apilog->api_request_datetime = new \yii\db\Expression('NOW()');
        if ($apilog->save(false)) {
            if (isset($response['status']) && $response['status'] == 'success') {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['success' => true, 'message' => 'success', 'log_id' => $apilog->id, 'callid' => $apilog->callid];
            } else {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['success' => false, 'message' => 'Number Not Valid!.', 'log_id' => $apilog->id, 'callid' => $apilog->callid];
                //return ['success' => true, 'message' => 'Number Not Valid!.', 'log_id' => $apilog->id, 'callid' => $apilog->callid];
            }
        }
    }

    /**
     * Take a Break 
     *
     * @return void
     */
    public function actionInboundbreak($status) {
        $inbounduser = \common\models\dynamicdb\internalcallcenter\platform\CallingUserInbound::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
        if ($inbounduser) {
            if ($inbounduser->sarv_agent_id) {
                if ($status) {
                    $inbounduser->sarv_status = 1;
                } else {
                    $inbounduser->sarv_status = 0;
                }
                $response = \dbtcallcenter\controllers\UserController::updateagentonsarv($inbounduser->sarv_agent_id, $inbounduser->sarv_status);
                $inbounduser->sarv_last_update = date('Y-m-d H:i:s');
                $sarvlog = new \common\models\dynamicdb\internalcallcenter\platform\CallingUserSarvLog();
                $sarvlog->sarv_agent_id = $inbounduser->sarv_agent_id;
                $sarvlog->sarv_status = $inbounduser->sarv_status;
                $sarvlog->user_id = $inbounduser->user_id;
                $sarvlog->api_response = json_encode($response);
                $sarvlog->ref_from = 'agent-break';
                $sarvlog->created_at = date('Y-m-d H:i:s');
                ;
                $sarvlog->save(false);
            }
            $inbounduser->save(false);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}
