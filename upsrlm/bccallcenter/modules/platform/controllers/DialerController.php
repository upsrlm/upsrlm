<?php

namespace bccallcenter\modules\platform\controllers;

use yii\web\Controller;
use Yii;
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

/**
 * Dialer controller for the `platform` module
 */
class DialerController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function BeforeAction($action) {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $model = new \common\models\dynamicdb\internalcallcenter\form\DialerForm();
        $message = '';
        //$this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $requestcallresult = $this->requestcall($model->customer_number, '2004');
                if ($requestcallresult['success']) {
                    //return $this->refresh();
                      Yii::$app->session->setFlash('success', "Call requested. please wait for 1 minute before starting another call.");
                }
                return $this->redirect(['/platform/dialer']);
            }
        }

        return $this->render('_form', ['model' => $model, 'message' => $message]);
    }

    public static function requestcall($to, $call_scenario) {
        $apilog = new \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog();
        $curl = curl_init();
        $apilog->serviceuserid = \Yii::$app->params['sarvuserid'];
        $apilog->token = \Yii::$app->params['sarvtoken'];
        $apilog->upsrlm_user_id = Yii::$app->user->identity->id;
        $apilog->customernumber = $TO = $to;
        $apilog->upsrlm_call_type = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::CALL_TYPE_OUTBOUND;
        $apilog->calling_list_id = 0;
        $apilog->upsrlm_call_scenario = $call_scenario;
        $apilog->project_id = 4;
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
        //$result = '{}';
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
                // return ['success' => true, 'message' => 'Number Not Valid!.', 'log_id' => $apilog->id, 'callid' => $apilog->callid];
            }
        }
    }
}
