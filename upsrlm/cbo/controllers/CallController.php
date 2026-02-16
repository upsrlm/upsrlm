<?php

namespace cbo\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use common\models\User;

class CallController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['request', 'upsrlmstatus', 'form', 'agent', 'requestbc', 'requestshg', 'requestsupplyuser'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['request', 'upsrlmstatus', 'agent', 'requestbc', 'requestshg', 'requestsupplyuser'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function BeforeAction($action) {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionRequestbc($bcid, $upsrlm_call_scenario) {
        $bc_model = \bc\modules\selection\models\SrlmBcApplication::findOne($bcid);
        $to = $bc_model->mobile_no;
        $call_status = $this->requestcall($to, $upsrlm_call_scenario);
        if ($call_status['success'] == true) {
            $log_model = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::findOne($call_status['log_id']);
            $log_model->bc_application_id = $bc_model->id;
            $log_model->save();
        } else {
            $log_model = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::findOne($call_status['log_id']);
            $log_model->bc_application_id = $bc_model->id;
            $log_model->save();
        }
        return $call_status;
    }

    public function actionRequestshg($shgid = 0, $upsrlm_call_scenario = 0, $to = 0, $user_id = 0, $id = 0) {
        if ($user_id) {
            $user_model = User::findOne($user_id);
            $to = $user_model->username;
        }
        if ($to) {
            $to = $to;
        }
        $call_status = $this->requestcall($to, $upsrlm_call_scenario);
        if ($call_status['success'] == true) {
            $log_model = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::findOne($call_status['log_id']);
            $log_model->cbo_shg_id = $shgid;

            $log_model->save();
        } else {
            $log_model = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::findOne($call_status['log_id']);
            $log_model->cbo_shg_id = $shgid;

            $log_model->save();
        }
        return $call_status;
    }

    public function actionRequestsupplyuser($to = 0, $upsrlm_call_scenario = 0) {
        $call_status = $this->requestcall($to, $upsrlm_call_scenario);
        return $call_status;
    }

    private function requestcall($to, $upsrlm_call_scenario) {
        $apilog = new \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog();
        $curl = curl_init();
        $apilog->serviceuserid = \Yii::$app->params['sarvuserid'];
        $apilog->token = \Yii::$app->params['sarvtoken'];
        $apilog->upsrlm_user_id = Yii::$app->user->identity->id;
        $apilog->customernumber = $TO = $to;
        $apilog->upsrlm_call_type = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::CALL_TYPE_OUTBOUND;
        $apilog->upsrlm_call_scenario = $upsrlm_call_scenario;
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
                return ['success' => true, 'message' => 'success', 'log_id' => $apilog->id];
            } else if (isset($response['code']) && $response['code'] == '111') {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['success' => false, 'message' => 'Number Not Valid!.', 'log_id' => $apilog->id];
            } else {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                 return ['success' => false, 'message' => 'Number Not Valid!.', 'log_id' => $apilog->id];
                //return ['success' => true, 'message' => 'success', 'log_id' => $apilog->id];
            }
        }
    }

    public function actionUpsrlmstatus() {
        if (Yii::$app->request->isAjax) {
            $apilog = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::findOne(Yii::$app->request->post('log_id'));
            if ($apilog != null) {
                $apilog->upsrlm_connection_status = Yii::$app->request->post('upsrlm_connection_status');
                $apilog->upsrlm_call_status = Yii::$app->request->post('upsrlm_call_status');
                $apilog->save();
            }
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['success' => true];
    }

    public function actionInbound($user_id) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $time = time();
        $before_time = ($time - 600);
        $model = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::find()->where(['upsrlm_user_mobile_no' => Yii::$app->user->identity->username, 'upsrlm_redirect' => 0])->andFilterWhere(['>=', 'created_at', $before_time])->orderBy('created_at desc')->limit(1)->one();
        if ($model != null) {
            $model->upsrlm_redirect = 1;
            $model->save();
            return ['success' => true, 'log_id' => $model->id];
        } else {
            return ['success' => false, 'log_id' => 0];
        }
    }

    public function actionForm($log_id) {
        $call_log_model = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::findOne($log_id);
        $model = new \callcenter\models\form\CloudLog(null, $call_log_model);
        return $this->render('call_form', [
                    'call_log_model' => $call_log_model,
                    'model' => $model,
        ]);
    }

    public function actionAgent() {
        $model = [];
        return $this->render('agentform', [
                    'model' => $model,
        ]);
    }

}
