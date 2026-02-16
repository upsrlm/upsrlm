<?php

namespace common\components\sms;

use yii\db\Expression;
use app\models\MasterSmsTemplate;
use bc\models\srlm\SmsLog;

class Smslane {

    const SRLM_OTP_TEMPLATE = 'OTP for your UP BCSakhi mobile app is %s. Do not share this OTP.';

    public $url = "http://www.smslane.com/vendorsms/pushsms.aspx";
    public $delivery_url = "http://www.smslane.com/vendorsms/CheckDelivery.aspx";
    public $referer = "";
    public $data = array(
        'user' => "",
        'password' => "",
        'msisdn' => "",
//        'sid' => "UPSRLM",
        'sid' => "TRINFO",
        'msg' => "",
        'fl' => "0",
        'gwid' => "2",
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

    const TYPE_SMS_OTP = 1;
    const TYPE_SEND_SMS = 1;
    const TYPE_CHECK_SMS_DELEVERY = 1;

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

    public function SendSMS() {
        foreach ($this->options as $key => $value) {
            $this->data[$key] = $value;
        }
        if (strlen($this->data['msg']) != strlen(utf8_decode($this->data['msg']))) {
            $this->data['dc'] = 8;
        }
//        echo "<pre>";
//        print_r($this->data);exit;
        if ($this->enableSendSms) {
            list($header, $content) = $this->PostRequestMsgSend($this->url, $this->referer, $this->data);
            return $content;
        }
    }

    private function PostRequestMsgSend($url, $referer, $_data) {
        // convert variables array to string:
        $data = array();
        while (list($n, $v) = each($_data)) {
            $data[] = "$n=$v";
        }
        $data = implode('&', $data);
        // format --> test1=a&test2=b etc.
        // parse the given URL
        $url = parse_url($url);
        if ($url['scheme'] != 'http') {
            die('Only HTTP request are supported !');
        }
        // extract host and path:
        $host = $url['host'];
        $path = $url['path'];
        // open a socket connection on port 80
        $fp = fsockopen($host, 80);
        // send the request headers:
        fputs($fp, "POST $path HTTP/1.1\r\n");
        fputs($fp, "Host: $host\r\n");
        fputs($fp, "Referer: $referer\r\n");
        fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
        fputs($fp, "Content-length: " . strlen($data) . "\r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        fputs($fp, $data);
        $result = '';
        while (!feof($fp)) {
            // receive the results of the request
            $result .= fgets($fp, 128);
        }
        // close the socket connection:
        fclose($fp);
        // split the result header from the content
        $result = explode("\r\n\r\n", $result, 2);
        $header = isset($result[0]) ? $result[0] : '';
        $content = isset($result[1]) ? $result[1] : '';
        // return as array:
        return array($header, $content);
    }

    public static function sms_content($model, $sms_type= Smslane::TYPE_SMS_OTP , $option = array()) {
       
        if ($sms_type == Smslane::TYPE_SMS_OTP) {
            return sprintf(Smslane::SRLM_OTP_TEMPLATE, $model->otp);
        }
        
    }

    public function sms_mobile_number($model) {
        if (strlen($model->mobile_number) == 10) {
            return '91' . $model->mobile_number;
        }
        return $model->mobile_number;
    }

}
