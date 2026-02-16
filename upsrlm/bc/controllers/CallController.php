<?php

namespace bc\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use common\models\User;
use bc\models\master\MasterDivisionSearch;
use bc\models\master\MasterDistrictSearch;
use common\models\master\MasterSubDistrictSearch;
use bc\models\master\MasterBlockSearch;
use bc\models\master\MasterGramPanchayatSearch;
use bc\models\master\MasterVillageSearch;
use common\models\master\MasterTownSearch;
use common\models\master\MasterTown;

class CallController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['request', 'upsrlmstatus'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['request', 'upsrlmstatus'],
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

    public function actionRequest($server_id, $actiontype) {
        $bc_model = \bc\modules\selection\models\SrlmBcApplication::findOne($server_id);
        //$to = '7838275272';
        $to = $bc_model->mobile_no;
//        $redirect_url = '/';
//        if ($actiontype == 1) {
//            $redirect_url = '/training/preselected?DashboardSearchForm[district_code]=' . $bc_model->district_code;
//        }
//        if ($actiontype == 2) {
//            $redirect_url = '/training/preselected?DashboardSearchForm[district_code]=' . $bc_model->district_code;
//        }
//        if ($actiontype == 3) {
//            $redirect_url = '/training/preselected';
//        }
//        if ($actiontype == 4) {
//            
//        }
        $apilog = new \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog();
        $apilog->bc_application_id = $server_id;
        $curl = curl_init();
        $apilog->serviceuserid = $USER_ID = "85456183";
        $apilog->token = $TOKEN = "DGyh6xWFLAL6cbf3mIfG";
        $apilog->upsrlm_user_id = Yii::$app->user->identity->id;
        $apilog->customernumber = $TO = $to;
        $apilog->upsrlm_user_mobile_no = Yii::$app->user->identity->username;
        $FROM = Yii::$app->user->identity->username;
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://s-ct3.sarv.com/clickToCall/v1/para?user_id=" . $USER_ID . "&token=" . $TOKEN . "&from=" . $FROM . "&to=" . $TO,
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
//        $result = '{}';
        $err = curl_error($curl);

        curl_close($curl);
        $response = json_decode($result, true);

        $apilog->api_response = $result;

        $apilog->callid = isset($response['callId']) ? $response['callId'] : NULL;
        $apilog->api_message = isset($response['message']) ? $response['message'] : NULL;
        $apilog->api_status = isset($response['status']) ? $response['status'] : NULL;
        $apilog->api_status_code = isset($response['code']) ? $response['code'] : 0;
        $apilog->api_request_datetime = new \yii\db\Expression('NOW()');
        $apilog->upsrlm_call_type = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::CALL_TYPE_OUTBOUND;
        $apilog->upsrlm_call_scenario = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::CALL_SCENARIO_RSETHI_BATCH_CREATE;
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
            }
        }
//        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//        return ['success' => true];
        //return $this->redirect('/');
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

//    public function actionMultiple($mobile_nos, $mul = 0) {
//
////        $bc_model = \bc\modules\selection\models\SrlmBcApplication::findOne($server_id);
//        $to = '9891012345'; //Vi Customer Care Number Phone Number Delhi (For Enquiries and Requests)
//        $to = '8081667777';
//        $to_array = [
//            7838275272 => '8574948010',
//            9454205990 => '9650753413',
//            9953326121 => '8800579215',
//            8587842573 => '9953511356',
//            9919917878 => '7607400606',
//            9120377431 => '9911978387',
//            8825317553 => '9918676527',
//            9557654207 => '8750631382',
//            9650901148 => '7982566075',
//            7451934797 => '9838755040',
//            9582119970 => '8076703684',
//            7060780262 => '8860680409',
//            7065529259 => '9820572609',
//            8650704147 => '9015831497',
//            8279901198 => '8285656549',
//            8742931524 => '9891960162',
//            9891175910 => '9555152423'
//        ];
//        if ($mul) {
//            $mobile_no_array = [7838275272, 9454205990, 9953326121, 8587842573, 9919917878, 9120377431, 8825317553, 9557654207, 9650901148, 7451934797, 9582119970, 7060780262, 7065529259, 8650704147, 8279901198, 8742931524, 9891175910];
//        } else {
//            $mobile_no_array = [$mobile_nos];
//        }
//        if (isset($mobile_no_array)) {
//            foreach ($mobile_no_array as $from) {
//                $apilog = new \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog();
//                $apilog->bc_application_id = 0;
//                if ($apilog->save(false)) {
//                    try {
//                        $curl = curl_init();
//                        $apilog->serviceuserid = $USER_ID = "85456183";
//                        $apilog->token = $TOKEN = "DGyh6xWFLAL6cbf3mIfG";
//                        $apilog->upsrlm_user_id = -1;
//                        $apilog->customernumber = $TO = $to;
//                        $apilog->upsrlm_user_mobile_no = Yii::$app->user->identity->username;
//                        $FROM = $from;
//                        //echo $FROM;
//                        curl_setopt_array($curl, array(
//                            CURLOPT_URL => "https://s-ct3.sarv.com/clickToCall/v1/para?user_id=" . $USER_ID . "&token=" . $TOKEN . "&from=" . $FROM . "&to=" . $TO,
//                            CURLOPT_RETURNTRANSFER => true,
//                            CURLOPT_ENCODING => "",
//                            CURLOPT_MAXREDIRS => 10,
//                            CURLOPT_TIMEOUT => 30,
//                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                            CURLOPT_CUSTOMREQUEST => "POST",
//                            CURLOPT_POSTFIELDS => "",
//                            CURLOPT_HTTPHEADER => array(
//                                "cache-control: no-cache"
//                            ),
//                        ));
//
//                        $result = curl_exec($curl);
//                        //$result="{}";
//                        $err = curl_error($curl);
//
//                        curl_close($curl);
//                        $response = json_decode($result, true);
//
//                        $apilog->api_response = $result;
//                        $apilog->request_time = time();
//                        $apilog->callid = isset($response['callId']) ? $response['callId'] : NULL;
//                        $apilog->api_message = isset($response['message']) ? $response['message'] : NULL;
//                        $apilog->api_status = isset($response['status']) ? $response['status'] : NULL;
//                        $apilog->api_status_code = isset($response['code']) ? $response['code'] : 0;
//                        $apilog->save(false);
////                        if (isset($response['status']) && $response['status'] == 'success') {
////                            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
////                            return ['success' => true, 'message' => 'Number Not Valid!.'];
////                        } else if (isset($response['code']) && $response['code'] == '111') {
////                            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
////                            return ['success' => true, 'message' => 'Number Not Valid!.'];
////                        } else {
////                            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
////                            return ['success' => true, 'message' => 'Number Not Valid!.'];
////                        }
//                    } catch (\Exception $ex) {
//                        print_r($ex);
//                        exit;
//                    }
//                }
//            }
//        }
//    }

}
