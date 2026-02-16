<?php

namespace common\components\sms;

use yii\db\Expression;
use app\models\MasterSmsTemplate;
use bc\models\srlm\SmsLog;

class Smslanev2 {

    //const SRLM_OTP_TEMPLATE = 'OTP for your UP BCSakhi mobile app is %s. Do not share this OTP.';
    const LOGIN_OTP_UPSRLM = 'OTP for login into UPSRLM portal is %s. Do not share this OTP.';
    const SRLM_OTP_TEMPLATE = 'OTP for login into UPSRLM portal is %s. Do not share this OTP. TRILINE INFOTECH PRIVATE LIMITED';
    const RISHTA_PIN_TEMPLATE_ONLINE = 'OTP for your UPSRLM Rishta app is %s. Do not share this OTP. TRILINE INFOTECH PRIVATE LIMITED';
    const RISHTA_PIN_LINK_TEMPLATE_ONLINE = 'HighSpeed Internet/ Download Rishta app: http://up-online.org/rishtaapp. Login PIN: %s. Helpline No.: 9070804050. - Triline Infotech';

    //working template LOGIN_OTP_UPSRLM and SenderId TLINFO 
    public $url = "https://api.smslane.com/api/v2/SendSMS";
    public $delivery_url = "http://www.smslane.com/vendorsms/CheckDelivery.aspx";
    public $referer = "";
    public $data = array(
        'ClientId' => "",
        'APIKey' => "",
        'MobileNumbers' => "",
        'SenderId' => "TLINFO",
        'Message' => "",
        'Is_Unicode' => "False",
        'Is_Flash' => "False",
    );
    public $data_otp = array(
        'ClientId' => "",
        'APIKey' => "",
        'MobileNumbers' => "",
        'SenderId' => "TLINFO",
        'Message' => "",
        'Is_Unicode' => "False",
        'Is_Flash' => "False",
    );
    public $delivery_data = array(
        'user' => "",
        'password' => "",
        'MessageID' => "",
    );
    public $sms_type = '';
    // config from config.php
    public $options;
    public $enableSendSms = true;
    public $service = 'smslane';
    public $template_model;
    public $sms_content;
    public $msisdn;

    const TYPE_SMS_BC_OTP = 1;
    const TYPE_SMS_USER_OTP = 2;
    const TYPE_SEND_SMS = 1;
    const TYPE_CHECK_SMS_DELEVERY = 1;
    const SENDAR_OTP = 1;
    const SENDAR_TRANSACTION = 2;
    const TYPE_SMS_OTP_ONLINE = 3;

    public function __construct($options = [], $url = '', $delivery_url = '') {
        $this->options = $options;
        if ($url != '')
            $this->url = $url;
        if ($delivery_url != '')
            $this->delivery_url = $delivery_url;
    }

    public function CheckDelivery() {
        foreach ($this->options as $key => $value) {
            $this->delivery_data[$key] = $value;
        }
        if ($this->enableSendSms) {
            list($header, $content) = $this->PostRequestMsgSend($this->delivery_url, $this->referer, $this->delivery_data);
            return $content;
        }
    }

    public function SendSMS($sendar) {
        if ($sendar == self::SENDAR_OTP) {
            foreach ($this->options as $key => $value) {
                $this->data_otp[$key] = $value;
            }
            if (strlen($this->data_otp['Message']) != strlen(utf8_decode($this->data_otp['Message']))) {
                $this->data_otp['Is_Unicode'] = 'true';
            }
            if ($this->enableSendSms) {
                $content = $this->PostRequestMsgSend($this->url, $this->referer, $this->data_otp);

                return $content;
            }
        }
        if ($sendar == self::SENDAR_TRANSACTION) {
            foreach ($this->options as $key => $value) {
                $this->data[$key] = $value;
            }
            if (strlen($this->data['Message']) != strlen(utf8_decode($this->data['Message']))) {
                $this->data['Is_Unicode'] = 'true';
            }
            if ($this->enableSendSms) {
                $content = $this->PostRequestMsgSend($this->url, $this->referer, $this->data);

                return $content;
            }
        }
    }

    private function PostRequestMsgSend($url, $referer, $_data) {
        $query = http_build_query($_data);
        $get_url = $url . '?' . $query;
        $ch = curl_init();
        //echo $get_url;exit;
        curl_setopt($ch, CURLOPT_URL, $get_url); //Url together with parameters
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60); //Timeout after 7 seconds
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

    public static function sms_content($message_content = array(), $sms_type = Smslanev2::TYPE_SMS_OTP, $option = array()) {

        if ($sms_type == Smslanev2::TYPE_SMS_BC_OTP) {
            return sprintf(Smslanev2::SRLM_OTP_TEMPLATE, $message_content['otp']);
        }
        if ($sms_type == Smslanev2::TYPE_SMS_USER_OTP) {
            return sprintf(Smslanev2::LOGIN_OTP_UPSRLM, $message_content['otp']);
        }
        if ($sms_type == Smslanev2::TYPE_SMS_OTP_ONLINE) {
            return sprintf(Smslanev2::RISHTA_PIN_LINK_TEMPLATE_ONLINE, $message_content['otp']);
        }
    }

    public function sms_mobile_number($mobile_number) {
        if (strlen($mobile_number) == 10) {
            return '91' . $mobile_number;
        }
        return $mobile_number;
    }

}
