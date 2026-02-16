<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "bc_pbt_feedback".
 *
 * @property int $id
 * @property int|null $bc_application_id
 * @property int|null $srlm_bc_selection_user_id
 * @property int|null $user_id
 * @property int|null $ques_1
 * @property int|null $ques_2
 * @property int|null $ques_3
 * @property int|null $ques_4
 * @property int|null $ques_5
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class BcPbtFeedback extends BcactiveRecord {

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
        return 'bc_pbt_feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id'], 'required'],
            [['bc_application_id', 'srlm_bc_selection_user_id', 'user_id', 'ques_1', 'ques_2', 'ques_3', 'ques_4', 'ques_5', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Bc Application ID',
            'srlm_bc_selection_user_id' => 'Srlm Bc Selection User ID',
            'user_id' => 'User ID',
            'ques_1' => '1. फ़्रॉड कॉल के माध्यम से ऑनलाइन आपके बैंक खाते से पैसे निकाल लेने के ख़तरे',
            'ques_2' => '2. ऐंटी मनी लॉंडरिंग (AML)/ ग़लत तरीक़े से ऑनलाइन पैसे के लेनदेन से जुड़े विषय ',
            'ques_3' => '3. नक़ली मुद्रा/ नोट के ख़तरे - उनके व्यवहार एवं पहचान करने के तरीक़े ताकि उनसे बचा जा सके ।',
            'ques_4' => '4.क्या आपको सभी विषय एवं उनसे सम्बंधित सावधानियों के बारे समझ मिली?',
            'ques_5' => 'Ques 5',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getBcapplication() {
        return $this->hasOne(\bc\modules\selection\models\SrlmBcApplication::className(), ['id' => 'bc_application_id']);
    }

    public function getQues1() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं', 3 => 'थोड़ी बहुत'];
        return isset($ques_option[$this->ques_1]) ? $ques_option[$this->ques_1] : '';
    }

    public function getQues2() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं', 3 => 'थोड़ी बहुत'];
        return isset($ques_option[$this->ques_2]) ? $ques_option[$this->ques_2] : '';
    }

    public function getQues3() {
        $ques_option = [1 => 'हाँ', 2 => 'नहीं', 3 => 'थोड़ी बहुत'];
        return isset($ques_option[$this->ques_3]) ? $ques_option[$this->ques_3] : '';
    }

    public function getQues4() {
        $ques_option = [1 => 'बिलकुल जानकारी नहीं मिली है', 2 => 'और जानकारी और स्पष्टता की ज़रूरत है', 3 => 'अच्छी समझ बनी है - ख़तरों से स्वयं निपट सकेंगे'];
        return isset($ques_option[$this->ques_4]) ? $ques_option[$this->ques_4] : '';
    }

}
