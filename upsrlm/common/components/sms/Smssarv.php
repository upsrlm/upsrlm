<?php

namespace common\components\sms;

use yii\db\Expression;

class Smssarv {

    const RISHTA_PIN_TEMPLATE = 'OTP for your UPSRLM Rishta app is %s. Do not share this OTP. TRILINE INFOTECH PRIVATE LIMITED';
    const RISHTA_PIN_TEMPLATE_NEW = 'रिश्ता ऐप के लिए आपका PIN है %s। कृपया इसे किसी के साथ साझा ना करें। रिश्ता हेल्पलाइन 9070804050।';
    const RISHTA_PIN_TEMPLATE_ONLINE = 'OTP for your UPSRLM Rishta app is %s. Do not share this OTP. TRILINE INFOTECH PRIVATE LIMITED';
    //const RISHTA_APP_LINK_TEMPLATE = 'नमस्कार! ग्राम्य विकास विभाग द्वारा सहायतित, UNICEF-प्रायोजित रिश्ता मोबाइल ऐप सिर्फ़ समूह के पदाधिकारी ही डाउनलोड कर पाएँगे। https://wada.upsrlm.org/rishta?m=%s लिंक से आप ऐप डाउनलोड कर पाएँगे। अगले SMS में आपको PIN मिलेगा जिसे किसी के साथ शेयर ना करें। रिश्ता हेल्पलाइन 9070804050 । नोट: हेल्पलाइन पर ग़ैर सदस्यों का फ़ोन स्वीकार नहीं होगा; ऐसे समूह क़मज़ोर/ प्रॉक्सी माने जाएँगे। - UPSRLM';
    const RISHTA_APP_LINK_TEMPLATE = 'नमस्कार! ग्राम्य विकास विभाग द्वारा सहायतित, UNICEF-प्रायोजित रिश्ता मोबाइल ऐप सिर्फ़ समूह के पदाधिकारी ही डाउनलोड कर पाएँगे। wada.upsrlm.org/rishta?m=%s लिंक से आप ऐप डाउनलोड कर पाएँगे। अगले SMS में आपको PIN मिलेगा जिसे किसी के साथ शेयर ना करें। रिश्ता हेल्पलाइन 9070804050 । नोट: हेल्पलाइन पर ग़ैर सदस्यों का फ़ोन स्वीकार नहीं होगा; ऐसे समूह क़मज़ोर/ प्रॉक्सी माने जाएँगे। - UPSRLM';
    const RISHTA_APP_LINK_PIN_TEMPLATE = 'आपके समूह ने आपको वादा-समूह सखी के लिए नामित किया है। आप ऐप के लिंक wada.upsrlm.org/sakhi?m=%s से आवेदन करें। ऐप का PIN %s है। सभी सूचनाएँ स्वयं भरे, किसी से मदद ना लें । रिश्ता हेल्पलाइन 9070804050 ।  नोट: हेल्पलाइन पर फ़ोन कॉल किसी पुरुष ग़ैर सदस्य को स्वीकार नहीं किया जाएगा; ऐसे आवेदक क़मज़ोर या प्रॉक्सी माने जाएँगे। - UPSRLM';
    const MOPUP_APP_LINK_PIN_TEMPLATE = 'निर्धनतम परिवारों के पंजीकरण के लिए मॉप-अप मोबाइल ऐप का लिंक: %s | ऐप के लिए आपका PIN: %s (कृपया इसे किसी के साथ साझा ना करें) अधिक जानकारी के लिये संपर्क करें: 9070804050 | पंचायती राज विभाग, ऊ0प्र0 शासन (Triline Infotech)';
    const MOPUP_APP_PIN_TEMPLATE = 'मोप-उप ऐप के लिए आपका PIN है %s। कृपया इसे किसी के साथ साझा ना करें। रिश्ता हेल्पलाइन 9070804050। - Triline';
    const RISHTA_PIN_TEMPLATE_ID = 1;
    const RISHTA_APP_LINK_TEMPLATE_ID = 2;
    const RISHTA_APP_LINK_PIN_TEMPLATE_ID = 3;
    const RISHTA_PIN_TEMPLATE_ID_ENG = 4;
    const MOPUP_PIN_TEMPLATE_ID = 21;
    const MOPUP_APP_PIN_TEMPLATE_ID = 22;
    const TEMPLATE_ID_PIN = 7428;
    const TEMPLATE_ID_LINK = 7190;
    const TEMPLATE_ID_LINK_PIN = 7429;
    const SARV_TEMPLATE_ID_PIN_MOP_UP = 11677;
    const SARV_TEMPLATE_ID_LINK_PIN_MOP_UP = 11678;

//   1 7190
//   2 7428
//   3 7429
    public $url = "https://m1.sarv.com/api/v2.0/sms_campaign.php";
    public $delivery_url = "https://m1.sarv.com/api/sms_campaign/viewMessageStatus";
    public $data = array(
        'token' => '',
        'user_id' => '',
        'route' => 'TR',
        'template_id' => "7066",
        'sender_id' => 'UPSRLM',
        'language' => "EN",
        'template' => "",
        'contact_numbers' => ''
    );
    public $delivery_data = array(
        'token' => "",
        'user_id' => "",
        'message_id' => "",
    );
    public $options;
    public $enableSendSms = false;
    public $template_model;
    public $sms_content;

    public function SendSMS() {

        foreach ($this->options as $key => $value) {
            $this->data[$key] = $value;
        }
        if (strlen($this->data['template']) != strlen(utf8_decode($this->data['template']))) {
            $this->data['language'] = 'UC';
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
            $get_url = $url . '?data={"token":"' . $_data['token'] . '","user_id":"' . $_data['user_id']  . '","message_id":"' . $_data['message_id'] . '"}';
//            $query = http_build_query($_data);
//            $get_url = $url . '?' . $query;
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
            
        }
    }

    private function PostRequestMsgSend($url, $_data) {
        try {
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
//            echo $get_url;exit;
            return json_decode($result, true);
        } catch (\Exception $ex) {
            
        }
    }

    public static function sms_content($message_content = array(), $sms_type = Smssarv::RISHTA_PIN_TEMPLATE_ID) {

        if ($sms_type == Smssarv::RISHTA_PIN_TEMPLATE_ID) {
            return sprintf(Smssarv::RISHTA_PIN_TEMPLATE_NEW, $message_content['pin']);
        }
        if ($sms_type == Smssarv::RISHTA_APP_LINK_TEMPLATE_ID) {
            return sprintf(Smssarv::RISHTA_APP_LINK_TEMPLATE, $message_content['m']);
        }
        if ($sms_type == Smssarv::RISHTA_APP_LINK_PIN_TEMPLATE_ID) {
            return sprintf(Smssarv::RISHTA_APP_LINK_PIN_TEMPLATE, $message_content['m'], $message_content['pin']);
        }
        if ($sms_type == Smssarv::RISHTA_PIN_TEMPLATE_ID_ENG) {
            return sprintf(Smssarv::RISHTA_PIN_TEMPLATE_ONLINE, $message_content['pin']);
        }
        if ($sms_type == Smssarv::MOPUP_APP_PIN_TEMPLATE_ID) {
            return sprintf(Smssarv::MOPUP_APP_LINK_PIN_TEMPLATE, $message_content['link'], $message_content['pin']);
        }
        if ($sms_type == Smssarv::MOPUP_PIN_TEMPLATE_ID) {
            return sprintf(Smssarv::MOPUP_APP_PIN_TEMPLATE, $message_content['pin']);
        }
    }
}
