<?php

namespace cbo\models\sakhi\form;

use Yii;
use cbo\models\Shg;
use cbo\models\sakhi\RishtaShgFeedback;
use yii\web\UploadedFile;
use common\models\base\GenralModel;

/**
 * RishtaShgFeedbackForm is the model behind the RishtaShgFeedback
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class DeleteRishtaShgFeedbackForm extends \yii\base\Model {

    public $id;
    public $cbo_shg_id;
    public $ques_1;
    public $ques_2;
    public $ques_3;
    public $ques_4;
    public $ques_5;
    public $ques6p;
    public $ques6p1;
    public $ques6p2;
    public $ques6p3;
    public $ques_61;
    public $ques_62;
    public $ques_63;
    public $ques_64;
    public $ques_65;
    public $ques_66;
    public $ques_7;
    public $ques_8;
    public $ques_10;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
    public $ques_1_option = [];
    public $ques_5_option = [];
    public $ques_8_option = [];
    public $shg_model;
    public $shg_feedback_model;
    public $ques6p1_option = [];
    public $ques6p1_array = [];
    public $dif_ques6p1_array = [];
    public $ques6p2_option = [];
    public $ques6p2_array = [];
    public $dif_ques6p2_array = [];
    public $ques6p3_option = [];
    public $ques6p3_array = [];
    public $dif_ques6p3_array = [];

    public function __construct($shg_model) {
        $this->shg_model = $shg_model;
        $this->shg_feedback_model = RishtaShgFeedback::findOne(['cbo_shg_id' => $this->shg_model->id]);
        $this->ques_1_option = [1 => 'एक वर्ष से कम', 2 => 'एक से दो वर्ष', 3 => 'दो से तीन वर्ष', 4 => 'तीन वर्ष से ज़्यादा ।'];
        $this->ques_5_option = [1 => 'जी हाँ, आवश्यकता के अनुरूप था;', 2 => 'नहीं, कम था;', 3 => 'जी नहीं, बहुत ज़्यादा कम था;', 4 => 'सभी सदस्य के मध्य ऋण बराबर बाँटा गया । जो भी  मिला, ठीक है ।'];
        $this->ques_8_option = [1 => '10,000 से कम, बहुत ज़्यादा', 2 => 'दस से बीस हज़ार', 3 => 'बीस से पचास हज़ार', 4 => 'पचास हज़ार से ज़्यादा '];
        $this->ques6p1_option = GenralModel::shg_feedback_ques6p1_option();
        $this->ques6p1_array = array_keys($this->ques6p1_option);
        $this->ques6p2_option = GenralModel::shg_feedback_ques6p2_option();
        $this->ques6p2_array = array_keys($this->ques6p2_option);
        $this->ques6p3_option = GenralModel::shg_feedback_ques6p3_option();
        $this->ques6p3_array = array_keys($this->ques6p3_option);
        if ($this->shg_feedback_model == null) {
            $this->shg_feedback_model = new RishtaShgFeedback();
            $this->shg_feedback_model->cbo_shg_id = $this->shg_model->id;
            $this->cbo_shg_id = $this->shg_model->id;
        } else {
            $this->cbo_shg_id = $this->shg_feedback_model->cbo_shg_id;
            $this->ques_1 = $this->shg_feedback_model->ques_1;
            $this->ques_2 = $this->shg_feedback_model->ques_2;
            $this->ques_3 = $this->shg_feedback_model->ques_3;
            $this->ques_4 = $this->shg_feedback_model->ques_4;
            $this->ques_5 = $this->shg_feedback_model->ques_5;
            $this->ques_7 = $this->shg_feedback_model->ques_7;
            $this->ques_8 = $this->shg_feedback_model->ques_8;
            $this->ques6p1 = $this->shg_feedback_model->ques6p1input;
            $this->ques6p2 = $this->shg_feedback_model->ques6p2input;
            $this->ques6p3 = $this->shg_feedback_model->ques6p3input;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['cbo_shg_id'], 'required'],
            [['ques_1', 'ques_2', 'ques_3', 'ques_4', 'ques_5'], 'required', 'on' => ['first'], 'message' => 'आवश्यक है'],
            [['ques_7', 'ques_8'], 'required', 'on' => ['first'], 'message' => 'आवश्यक है'],
            [['ques6p1', 'ques6p2', 'ques6p3'], 'required', 'on' => ['first'], 'message' => 'आवश्यक है'],
            ['ques6p1', 'each', 'rule' => ['integer']],
            ['ques6p2', 'each', 'rule' => ['integer']],
            ['ques6p3', 'each', 'rule' => ['integer']],
            [['ques_2', 'ques_3', 'ques_4', 'ques_7'], 'number'],
            [['ques_2', 'ques_3', 'ques_4', 'ques_7'], 'number', 'max' => 99, 'message' => 'अधिकतम 99'],
            [['ques_2', 'ques_3', 'ques_4', 'ques_7'], 'number', 'min' => 0, 'message' => 'Minimum 0'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_shg_id' => 'Cbo Shg ID',
            'ques_1' => '1. आपके समूह को वचत करते हुए कितना समय हो गया है?',
            'ques_2' => '2. समूह में कितने सदस्य को अबतक राज्य ग्रामीण आजीविका मिशन या बैंक से ऋण मिल पाया है?',
            'ques_3' => '3. समूह में जिन्हें अबतक ऋण नहीं मिला है उन में से कितने सदस्य को ऋण की त्वरित आवश्यकता है?',
            'ques_4' => '4. समूह में जिन्हें अबतक ऋण मिला है उन में से कितने सदस्य को दोबारा ऋण की त्वरित आवश्यकता है?',
            'ques_5' => '5. क्या जिन्हें अबतक ऋण मिला है, क्या ऋण उनके ज़रूरत के हिसाब से यथेष्ट थे?',
            'ques6p' => '6. आपके समूह के लिए राज्य ग्रामीण आजीविका मिशन के साथ अबतक का अनुभव कैसा रहा?',
            'ques6p1' => 'पार्ट – 1: अबतक का आँकलन',
            'ques6p2' => 'पार्ट – 2: प्रक्रिया पर आपकी राय/ फ़ीड्बैक',
            'ques6p3' => 'पार्ट – 3: कार्यक्रम पर आपके प्रमुख सुझाव ',
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
            'ques_7' => '7. समूह के कुल कितने सदस्य को त्वरित ऋण की आवश्यकता है?',
            'ques_8' => '8. प्रति सदस्य औसत कितने रुपए की ऋण की आवश्यकता है?',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save() {
        $this->shg_feedback_model = RishtaShgFeedback::findOne(['cbo_shg_id' => $this->cbo_shg_id]);
        if ($this->shg_feedback_model == null) {
            $this->shg_feedback_model = new RishtaShgFeedback();
            $this->shg_feedback_model->cbo_shg_id = $this->shg_model->id;
            $this->cbo_shg_id = $this->shg_model->id;
        }
        $this->shg_feedback_model->cbo_shg_id = $this->cbo_shg_id;
        $this->shg_feedback_model->ques_1 = $this->ques_1;
        $this->shg_feedback_model->ques_2 = $this->ques_2;
        $this->shg_feedback_model->ques_3 = $this->ques_3;
        $this->shg_feedback_model->ques_4 = $this->ques_4;
        $this->shg_feedback_model->ques_5 = $this->ques_5;
        $this->shg_feedback_model->ques_7 = $this->ques_7;
        $this->shg_feedback_model->ques_8 = $this->ques_8;
        $this->dif_ques6p1_array = array_diff($this->ques6p1_array, $this->ques6p1);
        if (isset($this->ques6p1) and is_array($this->ques6p1)) {
            foreach ($this->ques6p1 as $ques6p1_val) {
                $name = 'ques6p1_' . $ques6p1_val;
                $this->shg_feedback_model->$name = 1;
            }
        }
        foreach ($this->dif_ques6p1_array as $ques6p1_val) {
            $name = 'ques6p1_' . $ques6p1_val;
            $this->shg_feedback_model->$name = 0;
        }
        $this->dif_ques6p2_array = array_diff($this->ques6p2_array, $this->ques6p2);
        if (isset($this->ques6p2) and is_array($this->ques6p2)) {
            foreach ($this->ques6p2 as $ques6p2_val) {
                $name = 'ques6p2_' . $ques6p2_val;
                $this->shg_feedback_model->$name = 1;
            }
        }
        foreach ($this->dif_ques6p2_array as $ques6p2_val) {
            $name = 'ques6p2_' . $ques6p2_val;
            $this->shg_feedback_model->$name = 0;
        }
        $this->dif_ques6p3_array = array_diff($this->ques6p3_array, $this->ques6p3);
        if (isset($this->ques6p3) and is_array($this->ques6p3)) {
            foreach ($this->ques6p3 as $ques6p3_val) {
                $name = 'ques6p3_' . $ques6p3_val;
                $this->shg_feedback_model->$name = 1;
            }
        }
        foreach ($this->dif_ques6p3_array as $ques6p3_val) {
            $name = 'ques6p3_' . $ques6p3_val;
            $this->shg_feedback_model->$name = 0;
        }
        if (isset($_POST['save_b'])) {
            $this->shg_feedback_model->status = 1;
        }
        if (isset($_POST['submit_b'])) {
            $this->shg_feedback_model->status = 2;
        }
        if (!$this->shg_feedback_model->validate()) {
            return false;
        }
        if ($this->shg_feedback_model->save()) {
            return $this;
        }
    }

}
