<?php

namespace cbo\models\form;

use Yii;
use cbo\models\CboClf;
use cbo\models\CboClfFeedback;
use yii\web\UploadedFile;

/**
 * CboClfFeedbackForm is the model behind the CboClfFeedback
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class CboClfFeedbackForm extends \yii\base\Model {

    public $id;
    public $cbo_clf_id;
    public $ques_1;
    public $ques_2;
    public $ques_3;
    public $ques_4;
    public $ques_5;
    public $ques_6;
    public $ques_61;
    public $ques_62;
    public $ques_63;
    public $ques_64;
    public $ques_65;
    public $ques_66;
    public $ques_7;
    public $ques_8;
    public $ques9 = 0;
    public $ques_9;
    public $ques_91;
    public $ques_92;
    public $ques_93;
    public $ques_94;
    public $ques_95;
    public $ques_96;
    public $ques_97;
    public $ques_98;
    public $ques_99;
    public $ques_91a;
    public $ques_92a;
    public $ques_93a;
    public $ques_94a;
    public $ques_95a;
    public $ques_96a;
    public $ques_97a;
    public $ques_98a;
    public $ques_99a;
    public $ques_91oa;
    public $ques_92oa;
    public $ques_93oa;
    public $ques_94oa;
    public $ques_95oa;
    public $ques_96oa;
    public $ques_97oa;
    public $ques_98oa;
    public $ques_99oa;
    public $ques_10;
    public $group_photo;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
    public $ques_1_option = [];
    public $ques_2_option = [];
    public $ques_3_option = [];
    public $ques_4_option = [];
    public $ques_5_option = [];
    public $ques_6_option = [];
    public $ques_7_option = [];
    public $ques_8_option = [];
    public $ques_9_option = [];
    public $ques_10_option = [];
    public $clf_model;
    public $clf_feedback_model;

    public function __construct($clf_model) {
        $this->clf_model = $clf_model;
        $this->clf_feedback_model = CboClfFeedback::findOne(['cbo_clf_id' => $this->clf_model->id]);
        $this->ques_1_option = [1 => 'बिलकुल ही आसान है', 2 => 'काफ़ी आसान है', 3 => 'एक बार करने के बाद आसान लगेगा', 4 => 'मुश्किल लगा'];
        $this->ques_2_option = [1 => 'सभी पदाधिकारी और लेखाकार के पास है', 2 => 'कुछ  पदाधिकारी और लेखाकार के पास है', 3 => 'सिर्फ़ लेखाकार के पास है'];
        $this->ques_3_option = [1 => 'ये बहुत ज़रूरी है, नया फ़ोन ख़रीद लेंगे', 2 => 'संकुल में किसी ना किसी के फ़ोन से कर लेंगे', 3 => 'परिवार में किसी के फ़ोन का उपयोग कर लेंगे', 4 => 'मोबाइल ऐप का उपयोग नहीं कर पाएँगे'];
        $this->ques_4_option = [1 => 'सभी संकुल सदस्य उपस्थित हैं', 2 => 'सभी पदाधिकारी उपस्थित है', 3 => 'सभी/ कई पदाधिकारी व लेखाकार उपस्थित हैं', 4 => 'अकेली सदस्य/ पदाधिकारी ने भरा हैं'];
        $this->ques_5_option = [1 => 'मोबाइल ऐप-आधारित व्यवस्था ', 2 => 'रेजिस्टर वाली खाता बही'];

        $this->ques_7_option = [1 => 'हाँ, बहुत ज़्यादा', 2 => 'हाँ, काफ़ी हद तक', 3 => 'कुछ हद तक ', 4 => 'नहीं'];
        $this->ques_8_option = [1 => 'हाँ', 2 => 'नहीं '];
        $this->ques_9_option = [1 => '5 to 10', 2 => '11 to 25', 3 => '26 to 50', 4 => '51 to 99'];
        $this->ques_10_option = [1 => 'स्वयं सोचकर', 2 => 'संकुल पदाधिकारियों से चर्चा की', 3 => 'घरवालों से भी चर्चा की'];
        if ($this->clf_feedback_model == null) {
            $this->clf_feedback_model = new CboClfFeedback();
            $this->clf_feedback_model->cbo_clf_id = $this->clf_model->id;
            $this->cbo_clf_id = $this->clf_model->id;
        } else {
            $this->cbo_clf_id = $this->clf_feedback_model->cbo_clf_id;
            $this->ques_1 = $this->clf_feedback_model->ques_1;
            $this->ques_2 = $this->clf_feedback_model->ques_2;
            $this->ques_3 = $this->clf_feedback_model->ques_3;
            $this->ques_4 = $this->clf_feedback_model->ques_4;
            $this->ques_5 = $this->clf_feedback_model->ques_5;
            $this->ques_61 = $this->clf_feedback_model->ques_61;
            $this->ques_62 = $this->clf_feedback_model->ques_62;
            $this->ques_63 = $this->clf_feedback_model->ques_63;
            $this->ques_64 = $this->clf_feedback_model->ques_64;
            $this->ques_65 = $this->clf_feedback_model->ques_65;
            $this->ques_66 = $this->clf_feedback_model->ques_66;
            $this->ques_7 = $this->clf_feedback_model->ques_7;
            $this->ques_8 = $this->clf_feedback_model->ques_8;
            $this->ques_9 = $this->clf_feedback_model->ques_9;
            $this->ques_91 = $this->clf_feedback_model->ques_91;
            $this->ques_92 = $this->clf_feedback_model->ques_92;
            $this->ques_93 = $this->clf_feedback_model->ques_93;
            $this->ques_94 = $this->clf_feedback_model->ques_94;
            $this->ques_95 = $this->clf_feedback_model->ques_95;
            $this->ques_96 = $this->clf_feedback_model->ques_96;
            $this->ques_97 = $this->clf_feedback_model->ques_97;
            $this->ques_98 = $this->clf_feedback_model->ques_98;
            $this->ques_99 = $this->clf_feedback_model->ques_99;
            $this->ques_10 = $this->clf_feedback_model->ques_10;
            $this->ques_91a = $this->clf_feedback_model->ques_91a;
            $this->ques_92a = $this->clf_feedback_model->ques_92a;
            $this->ques_93a = $this->clf_feedback_model->ques_93a;
            $this->ques_94a = $this->clf_feedback_model->ques_94a;
            $this->ques_95a = $this->clf_feedback_model->ques_95a;
            $this->ques_96a = $this->clf_feedback_model->ques_96a;
            $this->ques_97a = $this->clf_feedback_model->ques_97a;
            $this->ques_98a = $this->clf_feedback_model->ques_98a;
            $this->ques_99a = $this->clf_feedback_model->ques_99a;
            $this->ques_91oa = $this->clf_feedback_model->ques_91oa;
            $this->ques_92oa = $this->clf_feedback_model->ques_92oa;
            $this->ques_93oa = $this->clf_feedback_model->ques_93oa;
            $this->ques_94oa = $this->clf_feedback_model->ques_94oa;
            $this->ques_95oa = $this->clf_feedback_model->ques_95oa;
            $this->ques_96oa = $this->clf_feedback_model->ques_96oa;
            $this->ques_97oa = $this->clf_feedback_model->ques_97oa;
            $this->ques_98oa = $this->clf_feedback_model->ques_98oa;
            $this->ques_99oa = $this->clf_feedback_model->ques_99oa;
            $this->ques_10 = $this->clf_feedback_model->ques_10;
            $this->group_photo = $this->clf_feedback_model->group_photo;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['cbo_clf_id'], 'required'],
            [['ques_1', 'ques_2', 'ques_3', 'ques_4', 'ques_5'], 'required', 'on' => ['first'], 'message' => 'आवश्यक है'],
            [['ques_7', 'ques_8'], 'required', 'on' => ['first'], 'message' => 'आवश्यक है'],
            [['ques_10'], 'required', 'on' => ['first'], 'message' => 'आवश्यक है'],
            ['ques_10', 'required', 'on' => ['first'], 'when' => function ($model) {
                    return $model->ques_8 == '2';
                }, 'message' => 'आवश्यक है', 'whenClient' => "function (attribute, value) {
                  return $('#ques_8').val() === '2';
            }"],
            [['ques_91', 'ques_92', 'ques_93', 'ques_94', 'ques_95', 'ques_96', 'ques_97', 'ques_98', 'ques_99'], 'checkBoxMaxMin'],
            [['cbo_clf_id', 'ques_1', 'ques_2', 'ques_3', 'ques_4', 'ques_5', 'ques_61', 'ques_62', 'ques_63', 'ques_64', 'ques_65', 'ques_66', 'ques_7', 'ques_8', 'ques_9', 'ques_91', 'ques_92', 'ques_93', 'ques_94', 'ques_95', 'ques_96', 'ques_97', 'ques_98', 'ques_99', 'ques_10', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
//            [['ques_91a', 'ques_92a', 'ques_93a', 'ques_94a', 'ques_95a', 'ques_96a', 'ques_97a', 'ques_98a', 'ques_99a'], 'trim'],
//            [['ques_91a', 'ques_92a', 'ques_93a', 'ques_94a', 'ques_95a', 'ques_96a', 'ques_97a', 'ques_98a', 'ques_99a'], 'number'],
//            [['ques_91a', 'ques_92a', 'ques_93a', 'ques_94a', 'ques_95a', 'ques_96a', 'ques_97a', 'ques_98a', 'ques_99a'], 'number', 'max' => 99, 'message' => 'अधिकतम शुल्क 99 रु'],
            [['ques_91oa', 'ques_92oa', 'ques_93oa', 'ques_94oa', 'ques_95oa', 'ques_96oa', 'ques_97oa', 'ques_98oa', 'ques_99oa'], 'integer'],
            ['ques_91oa', 'required', 'when' => function ($model) {
                    return $model->ques_91 > '0' and $model->ques_8 == '1';
                }, 'message' => 'आवश्यक है', 'whenClient' => "function (attribute, value) {
                  return $('#ques_91').val() > '0' && $('#ques_8').val()=='1';
            }"],
            ['ques_92oa', 'required', 'when' => function ($model) {
                    return $model->ques_92 > '0' and $model->ques_8 == '1';
                }, 'message' => 'आवश्यक है', 'whenClient' => "function (attribute, value) {
                  return $('#ques_92').val() > '0' && $('#ques_8').val()=='1';
            }"],
            ['ques_93oa', 'required', 'when' => function ($model) {
                    return $model->ques_93 > '0';
                }, 'message' => 'आवश्यक है', 'whenClient' => "function (attribute, value) {
                  return $('#ques_93').val() > '0';
            }"],
            ['ques_94oa', 'required', 'when' => function ($model) {
                    return $model->ques_94 > '0' and $model->ques_8 == '1';
                }, 'message' => 'आवश्यक है', 'whenClient' => "function (attribute, value) {
                  return $('#ques_94').val() > '0' && $('#ques_8').val()=='1';
            }"],
            ['ques_95oa', 'required', 'when' => function ($model) {
                    return $model->ques_95 > '0' and $model->ques_8 == '1';
                }, 'message' => 'आवश्यक है', 'whenClient' => "function (attribute, value) {
                  return $('#ques_95').val() > '0' && $('#ques_8').val()=='1';
            }"],
            ['ques_96oa', 'required', 'when' => function ($model) {
                    return $model->ques_96 > '0' and $model->ques_8 == '1';
                }, 'message' => 'आवश्यक है', 'whenClient' => "function (attribute, value) {
                  return $('#ques_96').val() > '0';
            }"],
            ['ques_97oa', 'required', 'when' => function ($model) {
                    return $model->ques_97 > '0' and $model->ques_8 == '1';
                }, 'message' => 'आवश्यक है', 'whenClient' => "function (attribute, value) {
                  return $('#ques_97').val() > '0' && $('#ques_8').val()=='1';
            }"],
            ['ques_98oa', 'required', 'when' => function ($model) {
                    return $model->ques_98 > '0' and $model->ques_8 == '1';
                }, 'message' => 'आवश्यक है', 'whenClient' => "function (attribute, value) {
                  return $('#ques_98').val() > '0' && $('#ques_8').val()=='1';
            }"],
            ['ques_99oa', 'required', 'when' => function ($model) {
                    return $model->ques_99 > '0' and $model->ques_8 == '1';
                }, 'message' => 'आवश्यक है', 'whenClient' => "function (attribute, value) {
                 return $('#ques_99').val() > '0' && $('#ques_8').val()=='1';
            }"],
            [['group_photo'], 'safe'],
            [['group_photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg,jpeg,png,gif', 'wrongExtension' => 'Only jpg,jpeg,png,gif files are allowed'],
            [['group_photo'], 'file', 'maxSize' => 1024 * 1024 * 2, 'tooBig' => 'Limit is 2MB'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_clf_id' => 'CLF',
            'ques_1' => '1. क्या अबतक मोबाइल ऐप को भरने/ एडिट करने में आपका अनुभव कैसा रहा?',
            'ques_2' => '2. क्या संकुल के पदाधिकारी एवं लेखाकार में से किसी या सभी के पास टचवाला फ़ोन है?',
            'ques_3' => '3. अगर किसी के पास टच वाला फ़ोन नहीं हैं तो मोबाइल ऐप का उपयोग कैसे करेंगे',
            'ques_4' => '4. जब ये प्रश्नोत्तर आपके द्वारा भरा जा रहा है, उस समय संकुल के कितने पदाधिकारी/ सदस्य उपस्थित हैं?',
            'ques_5' => '5. आप को संकुल के लेखा सम्बन्धी खाताबही के रखरखाव के लिए कौन सी व्यवस्था ज़्यादा आसान लगती है ?',
            'ques_6' => '6. अगर मोबाइल-ऐप आधारित व्यवस्था हो तो क्यों?',
            'ques_61' => '6.1. मोबाइल-ऐप पर लिखने का कष्ट नहीं रहेगा – सिर्फ़ टच से सही उत्तर चुनना होगा – जैसा अभी हम संकुल के ऐप पर कर रहें हैं ।',
            'ques_62' => '6.2. मोबाइल पर खाता बही का सभी रिकार्ड रखना आसान होगा ।',
            'ques_63' => '6.3. मोबाइल पर कार्य करने सुविधा होने से संकुल के बैठक में लम्बे समय तक रहने की बाध्यता नहीं होगी; समय बचेगा ।',
            'ques_64' => '6.4. मोबाइल पर खाता बही की सुविधा होने से मिशन मैनेजर/ मिशन के अधिकारियों पर निर्भरता कम होगी – हम स्वयं सक्षम होंगे – बिना किसी के हस्तक्षेप के काम कर पाएँगे ',
            'ques_65' => '6.5. मोबाइल ऐप पर अंकगणित/ हिसाब करने सुविधाएँ उपलब्ध होंगी – ग़लतियाँ नहीं होगी ।',
            'ques_66' => '6.6. और भी कई सुविधाएँ हो सकती हैं',
            'ques_7' => '7. अगर इस तरह का मोबाइल ऐप लागू होता है तो क्या संकुल के कार्य में समय, ऊर्जा और खर्च बचेगा?',
            'ques_8' => '8. क्या मोबाइल ऐप के लिए कोई शुल्क निर्धारित होना चाहिए?',
            'ques_9' => '9. अगर हाँ, तो निम्न में से कौन से तीन प्रमुख सुविधा/ सेवाएँ ज़रूर मिलना चाहिए',
            'ques_91' => '9.1. मोबाइल ऐप पर ही इसके संचालन के लिए उपयुक्त दिशा-निर्देश/ गाइडलाइन मिले ।',
            'ques_92' => '9.2. राज्य मिशन से मिलनेवाले ऋणों व अन्य सुविधाओं की मोबाइल ऐप पर मैसज से पूर्व सूचना प्राप्त होना ।',
            'ques_93' => '9.3. मोबाइल ऐप पर संकुल के खाता बही रखरखाव सम्बन्धी कार्य किया जा सके – रजिस्टर पर कार्य करने की आवश्यकता ना हो ।',
            'ques_94' => '9.4. संकुल (CLF), ग्राम संगठन (VO), एवं समूह (SHG) स्तर पर ऋण के लेनदेन की पूरी रिकार्ड रखा जा सके । माहवार मूलधन व ब्याज सहित ऋण वापसी (EMI) की जानकारी मिले ।',
            'ques_95' => '9.5. ऋण का भुगतान एवं ऋण वापसी की जानकारी का मैसज, ऋण देने व ऋण प्राप्त करने वाले दोनो को, मोबाइल ऐप पर ही मिले । ',
            'ques_96' => '9.6. संकुल के खाताबही एवं अन्य सभी रिकार्ड का प्रिंट निकालने की सुविधा हो ।',
            'ques_97' => '9.7. वित्तीय एवं डिजिटल साक्षरता सम्बन्धी सभी उपयोगी जानकारी उपलब्ध हो । प्रिंट निकालने की सुविधा हो ।',
            'ques_98' => '9.8. मोबाइल ऐप प्रयोग करने पर अगर कोई शुल्क निर्धारित हो रहा हो तो उनका बिल एवं शुल्क भुगतान की रसीद ऐप पर ही मिले – ज़रूरत हो तो प्रिंट निकाला जा सके ।',
            'ques_99' => '9.9. मोबाइल ऐप के उपयोग में असुविधा हो तों तत्काल मदद के लिए हेल्पलाइन की सुविधा हो',
            'ques_91a' => 'सुविधाओं के लिए न्यूनतम शुल्क कितनी होनी चाहिए?',
            'ques_92a' => 'सुविधाओं के लिए न्यूनतम शुल्क कितनी होनी चाहिए?',
            'ques_93a' => 'सुविधाओं के लिए न्यूनतम शुल्क कितनी होनी चाहिए?',
            'ques_94a' => 'सुविधाओं के लिए न्यूनतम शुल्क कितनी होनी चाहिए?',
            'ques_95a' => 'सुविधाओं के लिए न्यूनतम शुल्क कितनी होनी चाहिए?',
            'ques_96a' => 'सुविधाओं के लिए न्यूनतम शुल्क कितनी होनी चाहिए?',
            'ques_97a' => 'सुविधाओं के लिए न्यूनतम शुल्क कितनी होनी चाहिए?',
            'ques_98a' => 'सुविधाओं के लिए न्यूनतम शुल्क कितनी होनी चाहिए?',
            'ques_99a' => 'सुविधाओं के लिए न्यूनतम शुल्क कितनी होनी चाहिए?',
            'ques_10' => '10. आपने सभी प्रश्नों का जवाब कैसे भरा',
            'ques_91oa' => 'प्रति माह न्यूनतम शुल्क (रु0 में)',
            'ques_92oa' => 'प्रति माह न्यूनतम शुल्क (रु0 में)',
            'ques_93oa' => 'प्रति माह न्यूनतम शुल्क (रु0 में)',
            'ques_94oa' => 'प्रति माह न्यूनतम शुल्क (रु0 में)',
            'ques_95oa' => 'प्रति माह न्यूनतम शुल्क (रु0 में)',
            'ques_96oa' => 'प्रति माह न्यूनतम शुल्क (रु0 में)',
            'ques_97oa' => 'प्रति माह न्यूनतम शुल्क (रु0 में)',
            'ques_98oa' => 'प्रति माह न्यूनतम शुल्क (रु0 में)',
            'ques_99oa' => 'प्रति माह न्यूनतम शुल्क (रु0 में)',
            'ques_10' => '10. आपने सभी प्रश्नों का जवाब कैसे भरा',
            'group_photo' => 'सेल्फ़ी अपलोड करें',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function checkBoxMaxMin($attribute, $params) {
        if ($this->ques_8 == '1') {
            $this->ques9 = 0;
            if ($this->ques_91)
                $this->ques9 += $this->ques_91;

            if ($this->ques_92)
                $this->ques9 += $this->ques_92;

            if ($this->ques_93)
                $this->ques9 += $this->ques_93;

            if ($this->ques_94)
                $this->ques9 += $this->ques_94;

            if ($this->ques_95)
                $this->ques9 += $this->ques_95;

            if ($this->ques_96)
                $this->ques9 += $this->ques_96;
            if ($this->ques_97)
                $this->ques9 += $this->ques_97;
            if ($this->ques_98)
                $this->ques9 += $this->ques_98;
            if ($this->ques_99)
                $this->ques9 += $this->ques_99;
            if ($this->ques9 == '6') {
                
            } else {
                $this->addError('ques_9', 'प्रमुख 3 सुविधा बटन दबाएँ .');
            }
            return true;
        }
    }

    public function save() {
        try {
            $this->group_photo = UploadedFile::getInstance($this, 'group_photo');
            $this->clf_feedback_model->cbo_clf_id = $this->cbo_clf_id;
            $this->clf_feedback_model->ques_1 = $this->ques_1;
            $this->clf_feedback_model->ques_2 = $this->ques_2;
            $this->clf_feedback_model->ques_3 = $this->ques_3;
            $this->clf_feedback_model->ques_4 = $this->ques_4;
            $this->clf_feedback_model->ques_5 = $this->ques_5;
            $this->clf_feedback_model->ques_61 = $this->ques_61;
            $this->clf_feedback_model->ques_62 = $this->ques_62;
            $this->clf_feedback_model->ques_63 = $this->ques_63;
            $this->clf_feedback_model->ques_64 = $this->ques_64;
            $this->clf_feedback_model->ques_65 = $this->ques_65;
            $this->clf_feedback_model->ques_66 = $this->ques_66;
            $this->clf_feedback_model->ques_7 = $this->ques_7;
            $this->clf_feedback_model->ques_8 = $this->ques_8;
            if ($this->ques_8 == 1) {
                $this->clf_feedback_model->ques_9 = $this->ques_9;
                $this->clf_feedback_model->ques_91 = $this->ques_91;
                $this->clf_feedback_model->ques_92 = $this->ques_92;
                $this->clf_feedback_model->ques_93 = $this->ques_93;
                $this->clf_feedback_model->ques_94 = $this->ques_94;
                $this->clf_feedback_model->ques_95 = $this->ques_95;
                $this->clf_feedback_model->ques_96 = $this->ques_96;
                $this->clf_feedback_model->ques_97 = $this->ques_97;
                $this->clf_feedback_model->ques_98 = $this->ques_98;
                $this->clf_feedback_model->ques_99 = $this->ques_99;
                $this->clf_feedback_model->ques_91oa = $this->ques_91oa;
                $this->clf_feedback_model->ques_92oa = $this->ques_92oa;
                $this->clf_feedback_model->ques_93oa = $this->ques_93oa;
                $this->clf_feedback_model->ques_94oa = $this->ques_94oa;
                $this->clf_feedback_model->ques_95oa = $this->ques_95oa;
                $this->clf_feedback_model->ques_96oa = $this->ques_96oa;
                $this->clf_feedback_model->ques_97oa = $this->ques_97oa;
                $this->clf_feedback_model->ques_98oa = $this->ques_98oa;
                $this->clf_feedback_model->ques_99oa = $this->ques_99oa;
            } else {
                $this->clf_feedback_model->ques_9 = null;
                $this->clf_feedback_model->ques_91 = null;
                $this->clf_feedback_model->ques_92 = null;
                $this->clf_feedback_model->ques_93 = null;
                $this->clf_feedback_model->ques_94 = null;
                $this->clf_feedback_model->ques_95 = null;
                $this->clf_feedback_model->ques_96 = null;
                $this->clf_feedback_model->ques_97 = null;
                $this->clf_feedback_model->ques_98 = null;
                $this->clf_feedback_model->ques_99 = null;

//                $this->clf_feedback_model->ques_91a = null;
//                $this->clf_feedback_model->ques_92a = null;
//                $this->clf_feedback_model->ques_93a = null;
//                $this->clf_feedback_model->ques_94a = null;
//                $this->clf_feedback_model->ques_95a = null;
//                $this->clf_feedback_model->ques_96a = null;
//                $this->clf_feedback_model->ques_97a = null;
//                $this->clf_feedback_model->ques_98a = null;
//                $this->clf_feedback_model->ques_99a = null;
                $this->clf_feedback_model->ques_91oa = null;
                $this->clf_feedback_model->ques_92oa = null;
                $this->clf_feedback_model->ques_93oa = null;
                $this->clf_feedback_model->ques_94oa = null;
                $this->clf_feedback_model->ques_95oa = null;
                $this->clf_feedback_model->ques_96oa = null;
                $this->clf_feedback_model->ques_97oa = null;
                $this->clf_feedback_model->ques_98oa = null;
                $this->clf_feedback_model->ques_99oa = null;
            }
            $this->clf_feedback_model->ques_10 = $this->ques_10;
            if ($this->clf_feedback_model->save()) {
                $FOLDER = Yii::$app->params['datapath'] . 'cbo/';
                if (!file_exists($FOLDER)) {
                    mkdir($FOLDER);
                    chmod($FOLDER, 0777);
                }
                $FOLDER = $FOLDER . 'clf' . '/';
                if (!file_exists($FOLDER)) {
                    mkdir($FOLDER);
                    chmod($FOLDER, 0777);
                }
                if ($this->group_photo != null) {
                    $tmp_file_name = 'selfi_photo_' . $this->group_photo->name . date("Y_m_d_H-m-s") . "." . $this->group_photo->extension;
                    $FOLDER = $FOLDER . $this->clf_model->id . '/';
                    if (!file_exists($FOLDER)) {
                        mkdir($FOLDER);
                        chmod($FOLDER, 0777);
                    }
                    $this->group_photo->saveAs($FOLDER . '/' . $tmp_file_name);
                    chmod($FOLDER . '/' . $tmp_file_name, 0777);
                    $this->clf_feedback_model->group_photo = $tmp_file_name;
                    $this->clf_feedback_model->update();
                }
            } else {
                return false;
            }
            return $this;
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

}
