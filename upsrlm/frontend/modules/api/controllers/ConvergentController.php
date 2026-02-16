<?php

namespace frontend\modules\api\controllers;

use yii\web\Controller;
use common\models\User;
use common\models\ConvergentSmsLog;

/**
 * UserController for the `api` module
 */
class ConvergentController extends Controller {

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

    public function actionOtp() {
        if (isset($this->post_json['mobile_no']) and preg_match('/^[6-9]\d{9}$/', $this->post_json['mobile_no'])) {
            $sql = "SELECT *
        FROM `convergent_sms_log`
        WHERE   mobile_number=" . $this->post_json['mobile_no'] . ' order by sms_send_time desc LIMIT 1';
            $modle = ConvergentSmsLog::findBySql($sql)->one();
            $otp_sms_log_model = new ConvergentSmsLog();
            $otp_sms_log_model->mobile_number = $this->post_json['mobile_no'];
            $otp_sms_log_model->sms_send_time = new \yii\db\Expression('NOW()');
            if (!empty($modle)) {
                $otp_sms_log_model->otp = $modle->otp;
            } else {
                $otp_sms_log_model->otp = \common\helpers\Utility::generateNumericOTP(6);
            }
            $this->custom_response['otp'] = $otp_sms_log_model->otp;
            $this->custom_response['mobile_no'] = $otp_sms_log_model->mobile_number;
            $this->custom_response['time'] = date("Y-m-d h:i:s");
            if ($otp_sms_log_model->save()) {
                $this->options['sms'] = \common\components\sms\Smstriline::sms_content(['otp' => $otp_sms_log_model->otp], \common\components\sms\Smstriline::CONVERGENT_OTP_TEMPLATE_ID);
                $this->options['key'] = \common\components\sms\Smstriline::CONVERGENT_KEY;
                $this->options['sender'] = \common\components\sms\Smstriline::CONVERGENT_SENDER_ID;
                $this->options['templateid'] = \common\components\sms\Smstriline::CONVERGENT_OTP_TEMPLATE_ID;
                $this->options['number'] = $otp_sms_log_model->mobile_number;
                $smstli = new \common\components\sms\Smstriline($this->options);
                $smstli->enableSendSms = \Yii::$app->params['sms_lane_enable'];
                if ($smstli->enableSendSms) {
                    $sms = $smstli->SendSMS();
                    $otp_sms_log_model->sms_content = $this->options['sms'];
                    $otp_sms_log_model->status = 1;
                    $otp_sms_log_model->service_provider_id = $sms;
                    $otp_sms_log_model->sms_send_time = new \yii\db\Expression('NOW()');
                    if ($otp_sms_log_model->update()) {
                        
                    } else {
                        
                    }
                }
            } else {
                $this->custom_response['status'] = "0";
                $this->custom_response['message'] = "somthing went wrong";
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
