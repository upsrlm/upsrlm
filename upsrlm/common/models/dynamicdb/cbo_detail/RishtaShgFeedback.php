<?php

namespace common\models\dynamicdb\cbo_detail;

use Yii;

/**
 * This is the model class for table "rishta_shg_feedback".
 *
 * @property int $id
 * @property int|null $cbo_shg_id
 * @property int|null $ques_1
 * @property int|null $ques_2
 * @property int|null $ques_3
 * @property int|null $ques_4
 * @property int|null $ques_5
 * @property int|null $ques6p1_1
 * @property int|null $ques6p1_2
 * @property int|null $ques6p1_3
 * @property int|null $ques6p2_4
 * @property int|null $ques6p2_5
 * @property int|null $ques6p2_6
 * @property int|null $ques6p2_7
 * @property int|null $ques6p2_8
 * @property int|null $ques6p2_9
 * @property int|null $ques6p2_10
 * @property int|null $ques6p2_11
 * @property int|null $ques6p3_12
 * @property int|null $ques6p3_13
 * @property int|null $ques6p3_14
 * @property int|null $ques6p3_15
 * @property int|null $ques6p3_16
 * @property int|null $ques6p3_17
 * @property int|null $ques6p3_18
 * @property int|null $ques_7
 * @property int|null $ques_8
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class RishtaShgFeedback extends CboDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'rishta_shg_feedback';
    }

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['cbo_shg_id', 'ques_1', 'ques_2', 'ques_3', 'ques_4', 'ques_5', 'ques6p1_1', 'ques6p1_2', 'ques6p1_3', 'ques6p2_4', 'ques6p2_5', 'ques6p2_6', 'ques6p2_7', 'ques6p2_8', 'ques6p2_9', 'ques6p2_10', 'ques6p2_11', 'ques6p3_12', 'ques6p3_13', 'ques6p3_14', 'ques6p3_15', 'ques6p3_16', 'ques6p3_17', 'ques6p3_18', 'ques_7', 'ques_8', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_shg_id' => 'Cbo Shg ID',
            'ques_1' => 'आपके समूह को वचत करते हुए कितना समय हो गया है?',
            'ques_2' => 'समूह में कितने सदस्य को अबतक राज्य ग्रामीण आजीविका मिशन या बैंक से ऋण मिल पाया है?',
            'ques_3' => 'समूह में जिन्हें अबतक ऋण नहीं मिला है उन में से कितने सदस्य को ऋण की त्वरित आवश्यकता है?',
            'ques_4' => 'समूह में जिन्हें अबतक ऋण मिला है उन में से कितने सदस्य को दोबारा ऋण की त्वरित आवश्यकता है?',
            'ques_5' => 'क्या जिन्हें अबतक ऋण मिला है, क्या ऋण उनके ज़रूरत के हिसाब से यथेष्ट थे?',
            'ques6p1_1' => '6.1 बहुत ही अच्छा; हमारे समूह के सभी सदस्यों की ज़िंदगी बदल गयी',
            'ques6p1_2' => '6.2 ठीक ठाक; मिशन के कार्यक्रमों के कारण हमारे जीवन में अच्छे बदलाव की सम्भावना है ।',
            'ques6p1_3' => '6.3 कुछ बता नहीं सकते; काफ़ी समय हो जाने के बाद भी कार्यक्रम से हमें कुछ ख़ास लाभ नहीं मिल पाया है ।',
            'ques6p2_4' => '6.4 समूह संचालन की प्रक्रिया हमारे सक्षमता से से कही ज़्यादा जटिल है – प्रशिक्षण होने पर भी सफलता पूर्वक करना मुश्किल है ।',
            'ques6p2_5' => '6.5 समूह में  बैठक़, वचत एवं अन्य गतिविधि में काफ़ी समय जाता है; आजीविका से जुड़े विषय पर धीमी प्रगति होती है;',
            'ques6p2_6' => '6.6 मिशन मैनेजर हमसे तभी सम्बद्ध होते हैं जब मिशन से समूह के बारे में सूचनाएँ माँगी जाती है ।',
            'ques6p2_7' => '6.7 लम्बे समय तक इंतज़ार करने पर भी ऋण मिलने पर कोई बात नहीं होती है ।',
            'ques6p2_8' => '6.8 मिशन मैनेजर के प्रभाव से ही समूह की प्राथमिकता तय होती है – वे ही निश्चित करते हैं कि समूह कैसे चलेगा ।',
            'ques6p2_9' => '6.9 लेन देन के बही खाते लिखना मुश्किल है, BMM के मदद के बिना समूह का कार्यवाही चलाना मुश्किल है ।',
            'ques6p2_10' => '6.10 ऋण लेन देन की प्रक्रिया सही नहीं है – पक्षपात/ धांधली होता है;  इसमें सुधार की ज़रूरत है ।',
            'ques6p2_11' => '6.11 माइक्रो-क्रेडिट प्लान (MCP) भरना बहुत ही जटिल है; इसे नहीं भर पाने के कारण ऋण मिलने में देरी होती है ।',
            'ques6p3_12' => '6.12 समूहों के सदस्यों के आजीविका व उनके ऋण प्राप्ति पर शुरू से ही प्रमुखता दी जाए;',
            'ques6p3_13' => '6.13 बैंक से ऋण प्राप्त करने से ज़्यादा प्राथमिकता मिशन के माध्यम से ऋण प्राप्त करने पर दिया जाए;',
            'ques6p3_14' => '6.14 सभी सदस्य के लिए माइक्रो-क्रेडिट प्लान (MCP) भर कर रखा जाए ताकि रोटेशन आने पर उन्हें ऋण मिलने देरी ना हो;',
            'ques6p3_15' => '6.15 हर समूह के सदस्य को ये स्पष्ट समय सीमा बताया जाए कि उनके कितने समय में ऋण मिल सकेगा ।',
            'ques6p3_16' => '6.16 सभी सदस्य को ऋण मिलने से पूर्व, उनके सम्भावित रोज़गार/ उद्यम से सम्बंधित प्रशिक्षण/ जानकारी दी जाए ताकि वे सफल हो सकें ।',
            'ques6p3_17' => '6.17 हो सके तो ऋण पाने वाले सम्भावित सदस्यों को पूर्व सूचना हो कि ग्राम संगठन (VO) या संकुल (CLF) से उन को भुगतान किस दिन हो सकेगी;',
            'ques6p3_18' => '6.18 सभी समूह के पास जानकारी के लिए और आवश्यक हो तो शिकायत करने के लिए कॉल सेंटर की व्यवस्था हो ताकि मिशन के मुख्यालय तक हमारी बात पहुँच सके ',
            'ques_7' => 'समूह के कुल कितने सदस्य को त्वरित ऋण की आवश्यकता है?',
            'ques_8' => 'प्रति सदस्य औसत कितने रुपए की ऋण की आवश्यकता है?',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }


    public function getShg() {
        return $this->hasOne(RishtaShg::className(), ['id' => 'cbo_shg_id']);
    }
     public function getCboshg() {
        return $this->hasOne(\cbo\models\Shg::className(), ['id' => 'cbo_shg_id']);
    }
    public function getQues1() {
        $ques_1_option = [1 => 'एक वर्ष से कम', 2 => 'एक से दो वर्ष', 3 => 'दो से तीन वर्ष', 4 => 'तीन वर्ष से ज़्यादा ।'];
        return isset($ques_1_option[$this->ques_1]) ? $ques_1_option[$this->ques_1] : '';
    }

    public function getQues5() {
        $ques_5_option = [1 => 'जी हाँ, आवश्यकता के अनुरूप था;', 2 => 'नहीं, कम था;', 3 => 'जी नहीं, बहुत ज़्यादा कम था;', 4 => 'सभी सदस्य के मध्य ऋण बराबर बाँटा गया । जो भी  मिला, ठीक है ।'];
        return isset($ques_5_option[$this->ques_5]) ? $ques_5_option[$this->ques_5] : '';
    }

    public function getQues8() {
        $ques_8_option = [1 => '10,000 से कम, बहुत ज़्यादा', 2 => 'दस से बीस हज़ार', 3 => 'बीस से पचास हज़ार', 4 => 'पचास हज़ार से ज़्यादा  '];
        return isset($ques_8_option[$this->ques_8]) ? $ques_8_option[$this->ques_8] : '';
    }

    public function getEntryby() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getQues6p1input() {
        $array = [];
        if ($this->ques6p1_1) {
            array_push($array, 1);
        }
        if ($this->ques6p1_2) {
            array_push($array, 2);
        }
        if ($this->ques6p1_3) {
            array_push($array, 3);
        }
        return $array;
    }

    public function getQues6p2input() {
        $array = [];
        if ($this->ques6p2_4) {
            array_push($array, 4);
        }
        if ($this->ques6p2_5) {
            array_push($array, 5);
        }
        if ($this->ques6p2_6) {
            array_push($array, 6);
        }
        if ($this->ques6p2_7) {
            array_push($array, 7);
        }
        if ($this->ques6p2_8) {
            array_push($array, 8);
        }
        if ($this->ques6p2_9) {
            array_push($array, 9);
        }
        if ($this->ques6p2_10) {
            array_push($array, 10);
        }
        if ($this->ques6p2_11) {
            array_push($array, 11);
        }
        return $array;
    }

    public function getQues6p3input() {
        $array = [];
        if ($this->ques6p3_12) {
            array_push($array, 12);
        }
        if ($this->ques6p3_13) {
            array_push($array, 13);
        }
        if ($this->ques6p3_14) {
            array_push($array, 14);
        }
        if ($this->ques6p3_15) {
            array_push($array, 15);
        }
        if ($this->ques6p3_16) {
            array_push($array, 16);
        }
        if ($this->ques6p3_17) {
            array_push($array, 17);
        }
        if ($this->ques6p3_18) {
            array_push($array, 18);
        }

        return $array;
    }

    public function getQues6p1html() {
        $array = \common\models\base\GenralModel::shg_feedback_ques6p1_option();
        $html = '<ul class="nav">';
        foreach ($array as $key => $option) {
            $name = 'ques6p1_' . $key;
            if ($this->$name) {
                $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> ' . $option . '</li>';
            } else {
                $html .= '<li> <i class="fal fa-square" aria-hidden="true"></i> ' . $option . '</li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }

    public function getQues6p2html() {
        $array = \common\models\base\GenralModel::shg_feedback_ques6p2_option();
        $html = '<ul class="nav">';
        foreach ($array as $key => $option) {
            $name = 'ques6p2_' . $key;
            if ($this->$name) {
                $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> ' . $option . '</li>';
            } else {
                $html .= '<li> <i class="fal fa-square" aria-hidden="true"></i> ' . $option . '</li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }

    public function getQues6p3html() {
        $array = \common\models\base\GenralModel::shg_feedback_ques6p3_option();
        $html = '<ul class="nav">';
        foreach ($array as $key => $option) {
            $name = 'ques6p3_' . $key;
            if ($this->$name) {
                $html .= '<li> <i class="fal fa-check-square" aria-hidden="true"></i> ' . $option . '</li>';
            } else {
                $html .= '<li> <i class="fal fa-square" aria-hidden="true"></i> ' . $option . '</li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }

}
