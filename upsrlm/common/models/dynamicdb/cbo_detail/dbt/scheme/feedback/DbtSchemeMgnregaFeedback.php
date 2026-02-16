<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme\feedback;

use Yii;
use common\models\dynamicdb\cbo_detail\CboDetailactiveRecord;

/**
 * This is the model class for table "dbt_scheme_mgnrega_feedback".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $ques1
 * @property int|null $ques2
 * @property int|null $ques3
 * @property int|null $ques4
 * @property int|null $ques5
 * @property int|null $ques6
 * @property int|null $ques7
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $status
 */
class DbtSchemeMgnregaFeedback extends CboDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'dbt_scheme_mgnrega_feedback';
    }

    public function behaviors() {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'ques1', 'ques2', 'ques3', 'ques4', 'ques5', 'ques6', 'ques7', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'ques1' => 'क्या आप इस योजना के लाभ के बारे में जानती हैं?',
            'ques2' => 'क्या आप के परिवार में कोई इस लाभ के लिए पात्र हैं या हो सकते हैं/ कभी हो सकते थे?',
            'ques3' => 'क्या आपके ग्राम पंचायत के स्वयं सहायता समूह के सदस्यों के परिवारों में इस योजना के पात्र व्यक्ति हैं/ या हो सकते हैं ?',
            'ques4' => 'क्या आप या आपके ग्रा0प0 के समूहों के सदस्य परिवार BOCW में पंजीकृत हैं?',
            'ques5' => 'अगर नहीं, तो आपके आँकलन से आपके ग्रा0प0 के स्वयं सहायता समूहों में कितने परिवार इस योजना के पात्र बन सकते हैं?',
            'ques6' => 'अगर मोबाइल ऐप पर ही आवेदन की सुविधा मिले तो आप कितने दिनों में सभी समूह सदस्यों के सभी परिवार का पंजीकरण करवा सकती हैं?',
            'ques7' => 'क्या आप इस योजना के बारे मैं और जानकारी चाहतें है?',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    public function getQues_1() {
        $ques1_option = [1 => 'हाँ', 2 => 'नहीं'];
        return (isset($this->ques1) and isset($ques1_option[$this->ques1])) ? $ques1_option[$this->ques1] : '';
    }

    public function getQues_2() {
        $ques2_option = [1 => 'हाँ', 2 => 'नहीं', 3 => 'शायद हो सकते थे'];
        return (isset($this->ques2) and isset($ques2_option[$this->ques2])) ? $ques2_option[$this->ques3] : '';
    }

    public function getQues_3() {
        $ques3_option = [1 => 'हाँ', 2 => 'नहीं', 3 => 'स्पष्ट तौर पता नहीं'];
        return (isset($this->ques3) and isset($ques3_option[$this->ques3])) ? $ques3_option[$this->ques3] : '';
    }

    public function getQues_4() {
        $ques4_option = [1 => 'हाँ', 2 => 'नहीं'];
        return (isset($this->ques4) and isset($ques4_option[$this->ques4])) ? $ques4_option[$this->ques4] : '';
    }

    public function getQues_5() {
        $ques5_option = [1 => 'लगभग 25% परिवार', 2 => '25-50% परिवार', 3 => '50-90% परिवार', 4 => '90% से ज़्यादा परिवार'];
        return (isset($this->ques5) and isset($ques5_option[$this->ques5])) ? $ques5_option[$this->ques5] : '';
    }

    public function getQues_6() {
        $ques6_option = [1 => '15 दिनों में', 2 => 'लगभग एक महीने मैं', 3 => '1 महीने से ज़्यादा समय में'];
        return (isset($this->ques6) and isset($ques6_option[$this->ques6])) ? $ques6_option[$this->ques6] : '';
    }

    public function getQues_7() {
        $ques7_option = [1 => 'हाँ', 2 => 'नहीं'];
        return (isset($this->ques7) and isset($ques7_option[$this->ques7])) ? $ques7_option[$this->ques7] : '';
    }
    public function getUser() {
        return $this->hasOne(\common\models\dynamicdb\cbo_detail\User::className(), ['id' => 'user_id']);
    }

    public function getProfile() {
        return $this->hasOne(\common\models\dynamicdb\cbo_detail\CboMemberProfile::className(), ['user_id' => 'user_id']);
    }

    public function getWss() {
        return $this->hasOne(\common\models\wada\WadaApplication::className(), ['user_id' => 'user_id']);
    }
}
