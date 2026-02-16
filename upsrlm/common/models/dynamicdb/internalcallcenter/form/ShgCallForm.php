<?php

namespace common\models\dynamicdb\internalcallcenter\form;

use Yii;
use yii\helpers\ArrayHelper;
use cbo\models\Shg;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiLog;
use common\models\dynamicdb\cbo_detail\RishtaShgMemberVerificationFormLog;

class ShgCallForm extends \yii\base\Model {

    public $log_id;
    public $talk_with_shg_member;
    public $cbo_shg_id;
    public $designation;
    public $mobile_no;
    public $bc_model;
    public $log_model;
    public $talk_with_shg_member_yes;
    public $talk_with_call_center;
    public $how_many_time_for_suggest_samuh_sakhi;
    public $talk_with_shg_member_option = [];
    public $talk_with_shg_member_yes_option = [];
    public $talk_with_call_center_option = [];
    public $how_many_time_for_suggest_samuh_sakhi_option = [];
    public $shg_model;
    public $log_history;

    public function __construct($shg_model, $designation, $mobile_no) {
        $this->shg_model = $shg_model;
        $this->designation = $designation;
        $this->mobile_no = $mobile_no;
        $this->cbo_shg_id = $this->shg_model->id;
        $this->talk_with_shg_member_option = [1 => 'हाँ, पूरी बात हुई ', 2 => 'उनके पति/ परिवार के सदस्य के साथ बात हुई ', 3 => 'फ़ोन नहीं लगा, फिर से कॉल करना होगा ।'];
        $this->talk_with_shg_member_yes_option = [1 => 'जी हाँ ', 2 => 'शायद उन्हें दोबारा बताना पड़े', 3 => 'कुछ कह नहीं सकते'];
        $this->talk_with_call_center_option = [1 => 'जी हाँ', 2 => 'नहीं कहा, क्योंकि मैं खुद ज़्यादा बेहतर बता सकता/ सकती हूँ', 3 => 'भूल गया/ गयी'];
        $this->how_many_time_for_suggest_samuh_sakhi_option = [1 => 'एक दिन', 2 => 'एक से दो दिन', 3 => 'दो दिन से ज़्यादा'];

        $this->load(Yii::$app->request->post());
    }

    public function rules() {
        return [
            [['talk_with_shg_member'], 'required'],
            [['cbo_shg_id'], 'required'],
            [['designation'], 'required'],
            ['talk_with_shg_member_yes', 'required', 'when' => function ($model) {
                    return $model->talk_with_shg_member == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#talk_with_shg_member').val() == '1';
            }"],
            ['talk_with_call_center', 'required', 'when' => function ($model) {
                    return $model->talk_with_shg_member == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#talk_with_shg_member').val() == '1';
            }"],
            ['how_many_time_for_suggest_samuh_sakhi', 'required', 'when' => function ($model) {
                    return $model->talk_with_shg_member == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#talk_with_shg_member').val() == '1';
            }"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'talk_with_shg_member' => 'क्या स्वयं सहायता समूह के पदाधिकारी से बात हुई ?',
            'talk_with_shg_member_yes' => 'अगर हाँ, तो क्या वे रिश्ता ऐप डाउनलोड करने के बारे में समझ गयीं ?',
            'talk_with_call_center' => 'क्या आपने उनसे ये कहा कि कोई भी असुविधा होने पर वे कॉल सेंटर पर बात करें ?',
            'how_many_time_for_suggest_samuh_sakhi' => 'अगर बात हुई हो तो, समूह के पदाधिकारी ने समूह सखी के आवेदिका का मनोनयन करने के लिए कितना समय माँगा ',
        ];
    }

}
