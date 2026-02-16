<?php

namespace frontend\modules\api\controllers;

use yii\web\Controller;
use common\models\User;

/**
 * UserController for the `api` module
 */
class UserController extends Controller {

    protected $finder;
    private $custom_response = [];
    private $post_json;
    private $data_json;
    public $current_module;
    public $user_message = '';
    public $options = [];

    public function beforeAction($event) {
        $this->current_module = \Yii::$app->controller->module;
        $this->post_json = $this->current_module->post_json;
        $this->data_json = $this->current_module->data_json;
        $this->custom_response['status'] = "1";
        $this->custom_response['message'] = "Success";

        return parent::beforeAction($event);
    }

    public function actionCreateForOnline() {
        if (isset($this->post_json)) {
            if (isset($this->post_json['name']) and $this->post_json['name'] and isset($this->post_json['mobile_no']) and $this->post_json['mobile_no'] and isset($this->post_json['gram_panchayat']) and $this->post_json['gram_panchayat']) {
                $user_model = User::findOne(['username' => $this->post_json['mobile_no']]);
                if ($user_model == null) {
                    $user_model = new User();
                    $user_model->name = $this->post_json['name'];
                    $user_model->mobile_no = $this->post_json['mobile_no'];
                    $user_model->username = $this->post_json['mobile_no'];
                    $user_model->email = $this->post_json['mobile_no'] . '@gmail.com';
                    $user_model->otp_value = \common\helpers\Utility::generateNumericOTP(4);
                    $user_model->password = $this->post_json['mobile_no'];
                    $user_model->setPassword($this->post_json['mobile_no']);
                    $user_model->setUpd($this->post_json['mobile_no']);
                    $user_model->status = User::STATUS_ACTIVE;
                    $user_model->profile_status = 1;
                    $user_model->login_by_otp = 2;
                    $user_model->role = \common\models\online\master\MasterRole::ROLE_UPWIFI_TEMP;
                    $user_model->online = 1;
                    $user_model->action_type = 1;
                }
                if ($user_model != null) {
                    $user_model->action_type = 2;
                    $user_model->online = 1;
                    if ($user_model->otp_value == null or strlen($user_model->otp_value) != 4) {
                        $user_model->otp_value = \common\helpers\Utility::generateNumericOTP(4);
                    }
                }
                if ($user_model->save()) {
                    $rista = new \sakhi\components\Rishta($user_model);
                    $rishta_user_data_model = \common\models\rishta\RishtaUserData::findOne(['user_id' => $user_model->id]);
                    if ($rishta_user_data_model == null) {
                        $rishta_user_data_model = new \common\models\rishta\RishtaUserData();
                    }
                    $model = \common\models\User::findOne($user_model->id);
                    $model->user_app_data_update = 1;
                    $model->menu_version_major = \common\models\base\GenralModel::MENU_MAJOR_VERSION;
                    $model->menu_version_minor = ($user_model->menu_version_minor + 1);
                    $model->menu_version = ($model->menu_version_major + ('.' . $model->menu_version_minor));
                    $model->splash_screen = $rista->splash_screen($user_model);
                    $rishta_user_data_model->user_id = $user_model->id;
                    $rishta_user_data_model->menu_json = json_encode($rista->rishta_menu());
                    $model->last_menu_updatetime = date("Y-m-d h:i:s");
                    if ($model->save() and $rishta_user_data_model->save()) {
                        $this->custom_response['data']['user_id'] = $model->id;
                        $this->custom_response['data']['pin'] = $model->otp_value;
                        $this->options['Message'] = \common\components\sms\Smslanev2::sms_content(['otp' => $model->otp_value], \common\components\sms\Smslanev2::TYPE_SMS_OTP_ONLINE);
                        $msisdn = '';
                        if (strlen($user_model->username) == 10)
                            $msisdn = '91';
                        $msisdn .= $user_model->username;
                        $this->options['MobileNumbers'] = $msisdn;
                        
                        $sms_lane = new \common\components\sms\Smslanev2($this->options);
                        $sms_lane->enableSendSms = \Yii::$app->params['sms_lane_enable'];
                        $log = $sms_lane->SendSMS(\common\components\sms\Smslanev2::SENDAR_OTP);
//                        $sms_log_model = new \common\models\online\SmsLog();
//                        $sms_log_model->user_id = $user_model->id;
//                        $sms_log_model->mobile_number = $user_model->username;
//                        $sms_log_model->template_id = 41;
//                        $sms_log_model->model = json_encode(['mobile_number' => $user_model->username, 'm' => $user_model->username, 'template_id' => 4]);
//                        $sms_log_model->sms_content = $this->options['Message'];
//                        $sms_log_model->sms_length = strlen($this->options['Message']);
//                        $sms_log_model->sms_send_time = new \yii\db\Expression('NOW()');
//                        $sms_log_model->status = 1;
//                        $sms_log_model->save();
//                        if (isset($log['Data'][0]['MessageId'])) {
//                            $sms_log_model->sms_provider_message_id = $log['Data'][0]['MessageId'];
//                            $sms_log_model->update();
//                        }
                        
////                       $sms_serve = new \common\components\sms\Smssarv();
////                       $sms_serve->enableSendSms=1;
////                       $sms_serve->options = ['template_id' => '1707162426817958967', 'template' => $sms_serve::sms_content(['pin' => $user_model->otp_value], \common\components\sms\Smssarv::RISHTA_PIN_TEMPLATE_ID_ENG), 'contact_numbers' => $user_model->username];
////                       $log = $sms_serve->SendSMS();
                       // $this->custom_response['data']['log'] = $log;
                    }
                }else{
//                    $this->custom_response['data']['log'] = $user_model->getErrors();
//                    print_r($user_model->getErrors());
                }
            } else {
                $this->custom_response['status'] = "0";
                $this->custom_response['message'] = "Invalid request";
            }
        } else {
            $this->custom_response['status'] = "0";
            $this->custom_response['message'] = "Invalid request";
        }
        $response = \Yii::$app->response;
        $response->data = $this->custom_response;
        return $this->custom_response;
    }
    
}
