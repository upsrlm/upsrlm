<?php

namespace common\components\sms;

use yii\db\Expression;

class Smstriline {

    const BC_SAKHI_OTP_TEMPLATE = 'OTP for your UPSRLM BCSakhi mobile app is %s. Do not share this OTP. TRILINE INFOTECH PRIVATE LIMITED';
    const RISHTA_PIN_TEMPLATE = 'OTP for your UPSRLM Rishta app is {%s}. Do not share this OTP. TRILINE INFOTECH PRIVATE LIMITED';
    const UPSRLM_WEB_PIN_TEMPLATE = 'OTP for login into UPSRLM portal is {%s}. Do not share this OTP. TRILINE INFOTECH PRIVATE LIMITED';
    const BC_SAKHI_OTP_TEMPLATE_ID = '1707162426826280981';
    const RISHTA_PIN_TEMPLATE_ID = '1707162426817958967';
    const UPSRLM_WEB_PIN_TEMPLATE_ID = '1707162426822850694';

    public $url = "http://sms.trilineinfotech.com/api/smsapi";
    public $delivery_url = "http://sms.trilineinfotech.com/api/dlrapi";
    public $data = array(
        'key' => '',
        'route' => '1',
        'sender' => 'TLINFO',
        'number' => '',
        'sms' => "",
        'templateid' => ""
    );
    public $delivery_data = array(
        'key' => "",
        'messageid' => "",
    );
    public $options;
    public $enableSendSms = false;
    public $template_model;
    public $sms_content;
    public function __construct($options = [], $url = '', $delivery_url = '') {
        $this->options = $options;
        if ($url != '')
            $this->url = $url;
        if ($delivery_url != '')
            $this->delivery_url = $delivery_url;
    }
    public function SendSMS() {

        foreach ($this->options as $key => $value) {
            $this->data[$key] = $value;
        }

        if ($this->enableSendSms) {
            $content = $this->PostRequestMsgSend($this->url, $this->data);
            return $content;
        }
    }

    public function Smsstatus() {
        foreach ($this->options as $key => $value) {
            $this->delivery_data[$key] = $value;
        }
        $content = $this->PostRequestSmsstatus($this->delivery_url, $this->delivery_data);
        return $content;
    }

    private function PostRequestSmsstatus($url, $_data) {
        try {
            $get_url = $url . '?data={"token":"' . $_data['token'] . '","user_id":"' . $_data['user_id'] . '","message_id":"' . $_data['message_id'] . '"}';
//            $query = http_build_query($_data);
//            $get_url = $url . '?' . $query;
            $ch = curl_init();
            echo $get_url;exit;
            curl_setopt($ch, CURLOPT_URL, $get_url); //Url together with parameters
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60); //Timeout after 7 seconds
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close($ch);
//            echo $get_url;exit;
            return json_decode($result, true);
        } catch (\Exception $ex) {
            
        }
    }

    private function PostRequestMsgSend($url, $_data) {
        try {
            $query = http_build_query($_data);
            $get_url = $url . '?' . $query;
            $ch = curl_init();
//            echo $get_url;exit;
            curl_setopt($ch, CURLOPT_URL, $get_url); //Url together with parameters
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60); //Timeout after 7 seconds
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close($ch);
//            echo $get_url;exit;
            return json_decode($result, true);
        } catch (\Exception $ex) {
            print_r($ex);            exit();
        }
    }

    public static function sms_content($message_content = array(), $sms_type = Smstriline::BC_SAKHI_OTP_TEMPLATE_ID) {
        if ($sms_type == Smstriline::BC_SAKHI_OTP_TEMPLATE_ID) {
            return sprintf(Smstriline::BC_SAKHI_OTP_TEMPLATE, $message_content['otp']);
        }
         if ($sms_type == Smstriline::CONVERGENT_OTP_TEMPLATE_ID) {
            return sprintf(Smstriline::CONVERGENT_OTP_TEMPLATE, $message_content['otp']);
        }
    }
}
