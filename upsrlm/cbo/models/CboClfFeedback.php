<?php

namespace cbo\models;

use Yii;

/**
 * This is the model class for table "cbo_clf_feedback".
 *
 * @property int $id
 * @property int|null $cbo_clf_id
 * @property int|null $ques_1
 * @property int|null $ques_2
 * @property int|null $ques_3
 * @property int|null $ques_4
 * @property int|null $ques_5
 * @property int|null $ques_61
 * @property int|null $ques_62
 * @property int|null $ques_63
 * @property int|null $ques_64
 * @property int|null $ques_65
 * @property int|null $ques_66
 * @property int|null $ques_7
 * @property int|null $ques_8
 * @property int|null $ques_9
 * @property int|null $ques_91
 * @property int|null $ques_92
 * @property int|null $ques_93
 * @property int|null $ques_94
 * @property int|null $ques_95
 * @property int|null $ques_96
 * @property int|null $ques_97
 * @property int|null $ques_98
 * @property int|null $ques_99
 * @property int|null $ques_91a
 * @property int|null $ques_92a
 * @property int|null $ques_93a
 * @property int|null $ques_94a
 * @property int|null $ques_95a
 * @property int|null $ques_96a
 * @property int|null $ques_97a
 * @property int|null $ques_98a
 * @property int|null $ques_99a
 * @property int|null $ques_91oa
 * @property int|null $ques_92oa
 * @property int|null $ques_93oa
 * @property int|null $ques_94oa
 * @property int|null $ques_95oa
 * @property int|null $ques_96oa
 * @property int|null $ques_97oa
 * @property int|null $ques_98oa
 * @property int|null $ques_99oa
 * @property int|null $ques_10
 * @property string|null $group_photo
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class CboClfFeedback extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

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
    public static function tableName() {
        return 'cbo_clf_feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['cbo_clf_id'], 'required'],
            [['cbo_clf_id', 'ques_1', 'ques_2', 'ques_3', 'ques_4', 'ques_5', 'ques_61', 'ques_62', 'ques_63', 'ques_64', 'ques_65', 'ques_66', 'ques_7', 'ques_8', 'ques_9', 'ques_91', 'ques_92', 'ques_93', 'ques_94', 'ques_95', 'ques_96', 'ques_97', 'ques_98', 'ques_99', 'ques_10', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['ques_91a', 'ques_92a', 'ques_93a', 'ques_94a', 'ques_95a', 'ques_96a', 'ques_97a', 'ques_98a', 'ques_99a'], 'number'],
            [['ques_91oa', 'ques_92oa', 'ques_93oa', 'ques_94oa', 'ques_95oa', 'ques_96oa', 'ques_97oa', 'ques_98oa', 'ques_99oa'], 'integer'],
            [['group_photo'], 'string', 'max' => 500],
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
            'group_photo' => 'Group Photo',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getClf() {
        return $this->hasOne(CboClf::className(), ['id' => 'cbo_clf_id']);
    }

    public function getQues1() {
        $ques_1_option = [1 => 'बिलकुल ही आसान है', 2 => 'काफ़ी आसान है', 3 => 'एक बार करने के बाद आसान लगेगा', 4 => 'मुश्किल लगा'];
        return isset($ques_1_option[$this->ques_1]) ? $ques_1_option[$this->ques_1] : '';
    }

    public function getQues2() {
        $ques_2_option = [1 => 'सभी पदाधिकारी और लेखाकार के पास है', 2 => 'कुछ  पदाधिकारी और लेखाकार के पास है', 3 => 'सिर्फ़ लेखाकार के पास है'];
        return isset($ques_2_option[$this->ques_2]) ? $ques_2_option[$this->ques_2] : '';
    }

    public function getQues3() {
        $ques_3_option = [1 => 'ये बहुत ज़रूरी है, नया फ़ोन ख़रीद लेंगे', 2 => 'संकुल में किसी ना किसी के फ़ोन से कर लेंगे', 3 => 'परिवार में किसी के फ़ोन का उपयोग कर लेंगे', 4 => 'मोबाइल ऐप का उपयोग नहीं कर पाएँगे'];
        return isset($ques_3_option[$this->ques_3]) ? $ques_3_option[$this->ques_3] : '';
    }

    public function getQues4() {
        $ques_4_option = [1 => 'सभी संकुल सदस्य उपस्थित हैं', 2 => 'सभी पदाधिकारी उपस्थित है', 3 => 'सभी/ कई पदाधिकारी व लेखाकार उपस्थित हैं', 4 => 'अकेली सदस्य/ पदाधिकारी ने भरा हैं'];
        return isset($ques_4_option[$this->ques_4]) ? $ques_4_option[$this->ques_4] : '';
    }

    public function getQues5() {
        $ques_5_option = [1 => 'मोबाइल ऐप-आधारित व्यवस्था', 2 => 'रेजिस्टर वाली खाता बही'];
        return isset($ques_5_option[$this->ques_5]) ? $ques_5_option[$this->ques_5] : '';
    }

    public function getQues7() {
        $ques_7_option = [1 => 'हाँ, बहुत ज़्यादा', 2 => 'हाँ, काफ़ी हद तक', 3 => 'कुछ हद तक ', 4 => 'नहीं'];
        return isset($ques_7_option[$this->ques_7]) ? $ques_7_option[$this->ques_7] : '';
    }

    public function getQues8() {
        $ques_8_option = [1 => 'हाँ', 2 => 'नहीं '];
        return isset($ques_8_option[$this->ques_8]) ? $ques_8_option[$this->ques_8] : '';
    }

    public function getQues10() {
        $ques_10_option = [1 => 'स्वयं सोचकर', 2 => 'संकुल पदाधिकारियों से चर्चा की', 3 => 'घरवालों से भी चर्चा की'];
        return isset($ques_10_option[$this->ques_10]) ? $ques_10_option[$this->ques_10] : '';
    }

    public function getQues91oa() {
        $ques_9_option = [1 => '5 to 10', 2 => '11 to 25', 3 => '26 to 50', 4 => '51 to 99'];
        return isset($ques_9_option[$this->ques_91oa]) ? $ques_9_option[$this->ques_91oa] : '';
    }
    public function getQues92oa() {
        $ques_9_option = [1 => '5 to 10', 2 => '11 to 25', 3 => '26 to 50', 4 => '51 to 99'];
        return isset($ques_9_option[$this->ques_92oa]) ? $ques_9_option[$this->ques_92oa] : '';
    }
    public function getQues93oa() {
        $ques_9_option = [1 => '5 to 10', 2 => '11 to 25', 3 => '26 to 50', 4 => '51 to 99'];
        return isset($ques_9_option[$this->ques_93oa]) ? $ques_9_option[$this->ques_93oa] : '';
    }
    public function getQues94oa() {
        $ques_9_option = [1 => '5 to 10', 2 => '11 to 25', 3 => '26 to 50', 4 => '51 to 99'];
        return isset($ques_9_option[$this->ques_94oa]) ? $ques_9_option[$this->ques_94oa] : '';
    }
    public function getQues95oa() {
        $ques_9_option = [1 => '5 to 10', 2 => '11 to 25', 3 => '26 to 50', 4 => '51 to 99'];
        return isset($ques_9_option[$this->ques_95oa]) ? $ques_9_option[$this->ques_95oa] : '';
    }
    public function getQues96oa() {
        $ques_9_option = [1 => '5 to 10', 2 => '11 to 25', 3 => '26 to 50', 4 => '51 to 99'];
        return isset($ques_9_option[$this->ques_96oa]) ? $ques_9_option[$this->ques_96oa] : '';
    }
    public function getQues97oa() {
        $ques_9_option = [1 => '5 to 10', 2 => '11 to 25', 3 => '26 to 50', 4 => '51 to 99'];
        return isset($ques_9_option[$this->ques_97oa]) ? $ques_9_option[$this->ques_97oa] : '';
    }
    public function getQues98oa() {
        $ques_9_option = [1 => '5 to 10', 2 => '11 to 25', 3 => '26 to 50', 4 => '51 to 99'];
        return isset($ques_9_option[$this->ques_98oa]) ? $ques_9_option[$this->ques_98oa] : '';
    }
    public function getQues99oa() {
        $ques_9_option = [1 => '5 to 10', 2 => '11 to 25', 3 => '26 to 50', 4 => '51 to 99'];
        return isset($ques_9_option[$this->ques_99oa]) ? $ques_9_option[$this->ques_99oa] : '';
    }
    public function getGroupphotoUrl() {
        return Yii::$app->params['app_url']['cbo'] . "/getimage/cbo/clf/" . $this->cbo_clf_id . "/" . $this->group_photo;
    }

    public function getEntryby() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'created_by']);
    }

}
