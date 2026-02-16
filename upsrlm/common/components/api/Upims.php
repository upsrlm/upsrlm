<?php

namespace common\components\api;

use yii\db\Expression;
use app\models\MasterSmsTemplate;
use bc\models\srlm\SmsLog;

class Upims {

//    public $url = "https://devapi.uplmis.in/api/Gen/GetLabourPayments";
    public $url = "https://prodapi.uplmis.in/api/gen/getlabourpayments";
    public $base_url = 'https://prodapi.uplmis.in/api/gen/';
    public $aes_key = "azJOV09WZmdYajI4MmFUaGtodGd6dz09fHlSaTRISFh5NExrRW9mazJZWEdqTWdSRnZwd0g0b1F2UVRlTEZIV1F0bEU9";
    public $data = array(
        'gram' => "",
        'fromdate' => "",
        'todate' => "",
    );

    public function __construct($options = [], $url = '') {
        if ($url != '')
            $this->url = $url;
    }

    public function Getdata($url, $data) {
        $this->url = $url;
        $content = $this->PostRequest($this->url, $data);
        return $content;
    }

    public function Getbocwpayment($data) {
        $content = $this->PostRequest($this->url, $data);
        return $content;
    }

    public function Getlaberinfo($data) {
        $content = $this->PostRequest($this->url, $data);
        return $content;
    }

    public function GetScheme($data) {
        $content = $this->PostRequest($this->url, $data);
        return $content;
    }

    private function PostRequest($url, $_data) {
        $post = json_encode($_data);
//        $post = array($post);
        $query = http_build_query($_data);
        $get_url = $url . '?' . $query;
//        return  $post;
        $ch = curl_init($url);
        // curl_setopt($ch, CURLOPT_URL, $get_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60); //Timeout after 7 seconds
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

    public function encrypt($plaintext, $password) {
        $method = "AES-256-CBC";
        $key = hash('sha256', $password, true);
        $iv = openssl_random_pseudo_bytes(16);

        $ciphertext = openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv);
        $hash = hash_hmac('sha256', $ciphertext . $iv, $key, true);

        return $iv . $hash . $ciphertext;
    }

//        $key = utf8_encode($key);
//
//        //make it 32 chars long. pad with \0 for shorter keys
//        $key = str_pad($key, 32, "\0");
//
//        //make the input string length multiples of 16. This is necessary
//        $padding = 16 - (strlen($string) % 16);
//        $string .= str_repeat(chr($padding), $padding);
//
//        //emtpy IV - initialization vector
//        $iv = "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
//
//        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $string, MCRYPT_MODE_CBC, $iv));
//        return rtrim($encrypted);
//    }
}
