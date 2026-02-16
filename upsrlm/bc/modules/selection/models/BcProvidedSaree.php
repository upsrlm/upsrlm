<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "bc_provided_saree".
 *
 * @property int $id
 * @property int|null $bc_application_id
 * @property int|null $srlm_bc_selection_user_id
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property int|null $saree1_provided
 * @property string|null $saree1_provided_date
 * @property int|null $saree1_provided_by
 * @property string|null $saree1_provided_datetime
 * @property int|null $saree1_acknowledge
 * @property string|null $get_saree1_date
 * @property string $get_saree1_packed_new
 * @property int $get_saree1_quality
 * @property int $get_saree1_quality_no_1
 * @property int $get_saree1_quality_no_2
 * @property int $get_saree1_quality_no_3
 * @property int $get_saree1_quality_no_4
 * @property int $get_saree1_quality_no_other
 * @property string|null $get_saree1_quality_no_other_text
 * @property string|null $get_saree1_quality_photo
 * @property string|null $saree1_acknowledge_datetime
 * @property int|null $saree2_provided
 * @property string|null $saree2_provided_date
 * @property int|null $saree2_provided_by
 * @property string|null $saree2_provided_datetime
 * @property int|null $saree2_acknowledge
 * @property string|null $get_saree2_date
 * @property string $get_saree2_packed_new
 * @property int $get_saree2_quality
 * @property int $get_saree2_quality_no_1
 * @property int $get_saree2_quality_no_2
 * @property int $get_saree2_quality_no_3
 * @property int $get_saree2_quality_no_4
 * @property int $get_saree2_quality_no_other
 * @property string|null $get_saree2_quality_no_other_text
 * @property string|null $get_saree2_quality_photo
 * @property string|null $saree2_acknowledge_datetime
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class BcProvidedSaree extends BcactiveRecord {

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
        return 'bc_provided_saree';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id'], 'required'],
            [['bc_application_id'], 'unique'],
            [['bc_application_id', 'srlm_bc_selection_user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'saree1_provided', 'saree1_provided_by', 'saree1_acknowledge', 'get_saree1_quality', 'get_saree1_quality_no_1', 'get_saree1_quality_no_2', 'get_saree1_quality_no_3', 'get_saree1_quality_no_4', 'get_saree1_quality_no_other', 'saree2_provided', 'saree2_provided_by', 'saree2_acknowledge', 'get_saree2_quality', 'get_saree2_quality_no_1', 'get_saree2_quality_no_2', 'get_saree2_quality_no_3', 'get_saree2_quality_no_4', 'get_saree2_quality_no_other', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['saree1_provided_date', 'saree1_provided_datetime', 'get_saree1_date', 'saree1_acknowledge_datetime', 'saree2_provided_date', 'saree2_provided_datetime', 'get_saree2_date', 'saree2_acknowledge_datetime'], 'safe'],
            [['get_saree1_packed_new', 'get_saree2_packed_new'], 'string', 'max' => 1],
            [['get_saree1_quality_no_other_text', 'get_saree2_quality_no_other_text'], 'string', 'max' => 255],
            [['get_saree1_quality_photo', 'get_saree2_quality_photo'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Name',
            'srlm_bc_selection_user_id' => 'Selection User ID',
            'district_code' => 'District',
            'block_code' => 'Block',
            'gram_panchayat_code' => 'Gram Panchayat',
            'saree1_provided' => 'Saree1 Provided',
            'saree1_provided_date' => 'Saree1 Provided Date',
            'saree1_provided_by' => 'Saree1 Provided By',
            'saree1_provided_datetime' => 'Saree1 Provided Datetime',
            'saree1_acknowledge' => 'क्या आपने बीसी सखी यूनिफ़ॉर्म साड़ी 1 प्राप्त की',
            'get_saree1_date' => 'बीसी सखी यूनिफ़ॉर्म साड़ी 1 प्राप्त दिनांक',
            'get_saree1_packed_new' => 'क्या आपको सही ढंग से पैक किया हुआ नया साड़ी मिला',
            'get_saree1_quality' => 'क्या साड़ी की क्वालिटी अच्छी है?',
            'get_saree1_quality_no_1' => 'साड़ी के कपड़े की क्वालिटी अच्छी नहीं है। साड़ी का मटेरीयल सिन्थेटिक है, सूती नहीं है।',
            'get_saree1_quality_no_2' => 'साड़ी में जो बुनाई है, उसके धागे निकल रहे है ।',
            'get_saree1_quality_no_3' => 'धुलने के बाद साड़ी का रंग हल्का हो गया है ।',
            'get_saree1_quality_no_4' => 'साड़ी की लंबाई कम है ।',
            'get_saree1_quality_no_other' => 'अन्य कोई',
            'get_saree1_quality_no_other_text' => 'अन्य',
            'get_saree1_quality_photo' => 'बीसी सखी यूनिफ़ॉर्म साड़ी 1 फ़ोटो',
            'saree1_acknowledge_datetime' => 'Saree1 Acknowledge Datetime',
            'saree2_provided' => 'Saree2 Provided',
            'saree2_provided_date' => 'Saree2 Provided Date',
            'saree2_provided_by' => 'Saree2 Provided By',
            'saree2_provided_datetime' => 'Saree2 Provided Datetime',
            'saree2_acknowledge' => 'क्या आपने बीसी सखी यूनिफ़ॉर्म साड़ी 2 प्राप्त की',
            'get_saree2_date' => 'बीसी सखी यूनिफ़ॉर्म साड़ी 2 प्राप्त दिनांक',
            'get_saree2_packed_new' => 'क्या आपको सही ढंग से पैक किया हुआ नया साड़ी मिला',
            'get_saree2_quality' => 'क्या साड़ी की क्वालिटी अच्छी है?',
            'get_saree2_quality_no_1' => 'साड़ी के कपड़े की क्वालिटी अच्छी नहीं है। साड़ी का मटेरीयल सिन्थेटिक है, सूती नहीं है।',
            'get_saree2_quality_no_2' => 'साड़ी में जो बुनाई है, उसके धागे निकल रहे है ।',
            'get_saree2_quality_no_3' => 'धुलने के बाद साड़ी का रंग हल्का हो गया है ।',
            'get_saree2_quality_no_4' => 'साड़ी की लंबाई कम है ।',
            'get_saree2_quality_no_other' => 'अन्य कोई',
            'get_saree2_quality_no_other_text' => 'अन्य',
            'get_saree2_quality_photo' => 'बीसी सखी यूनिफ़ॉर्म साड़ी 2 फ़ोटो',
            'saree2_acknowledge_datetime' => 'Saree2 Acknowledge Datetime',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getBc() {
        return $this->hasOne(SrlmBcApplication::className(), ['id' => 'bc_application_id']);
    }
    public function getBlock() {
        return $this->hasOne(\bc\models\master\MasterBlock::className(), ['block_code' => 'block_code']);
    }
    public function getSaree1_photo_url() {
        return \Yii::$app->params['app_url']['bc'] . "/getimage/bcprofile/" . $this->srlm_bc_selection_user_id . "/" . $this->get_saree1_quality_photo;
    }

    public function getSaree2_photo_url() {
        return \Yii::$app->params['app_url']['bc'] . "/getimage/bcprofile/" . $this->srlm_bc_selection_user_id . "/" . $this->get_saree2_quality_photo;
    }
    public function getSaree1_ack() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return $this->saree1_acknowledge != null ? $option[$this->saree1_acknowledge] : '';
    }

    public function getSaree2_ack() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return $this->saree2_acknowledge != null ? $option[$this->saree2_acknowledge] : '';
    }
    public function getSaree1_packed_new() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return $this->get_saree1_packed_new != null ? $option[$this->get_saree1_packed_new] : '';
    }

    public function getSaree2_packed_new() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return $this->get_saree2_packed_new != null ? $option[$this->get_saree2_packed_new] : '';
    }

    public function getSaree1_quality() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return $this->get_saree1_quality != null ? $option[$this->get_saree1_quality] : '';
    }

    public function getSaree2_quality() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return $this->get_saree2_quality != null ? $option[$this->get_saree2_quality] : '';
    }

    public function getSaree1_quality_no_1() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return $this->get_saree1_quality_no_1 != null ? $option[$this->get_saree1_quality_no_1] : '';
    }

    public function getSaree2_quality_no_1() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return $this->get_saree2_quality_no_1 != null ? $option[$this->get_saree2_quality_no_1] : '';
    }

    public function getSaree1_quality_no_2() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return $this->get_saree1_quality_no_2 != null ? $option[$this->get_saree1_quality_no_2] : '';
    }

    public function getSaree2_quality_no_2() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return $this->get_saree2_quality_no_2 != null ? $option[$this->get_saree2_quality_no_2] : '';
    }

    public function getSaree1_quality_no_3() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return $this->get_saree1_quality_no_3 != null ? $option[$this->get_saree1_quality_no_3] : '';
    }

    public function getSaree2_quality_no_3() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return $this->get_saree2_quality_no_3 != null ? $option[$this->get_saree2_quality_no_3] : '';
    }
    public function getSaree1_quality_no_4() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return $this->get_saree1_quality_no_4 != null ? $option[$this->get_saree1_quality_no_4] : '';
    }

    public function getSaree2_quality_no_4() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return $this->get_saree2_quality_no_4 != null ? $option[$this->get_saree2_quality_no_4] : '';
    }
    public function afterSave($insert, $changedAttributes) {
        try {
            $bc_saree_count = 0;
            $bc_model = SrlmBcApplication::findOne($this->bc_application_id);
            if ($bc_model != null) {
                if ($this->saree1_provided) {
                    $bc_saree_count = ($bc_saree_count + 1);
                }
                if ($this->saree2_provided) {
                    $bc_saree_count = ($bc_saree_count + 1);
                }

                $bc_model->bc_saree_count = $bc_saree_count;
                $bc_model->action_type = SrlmBcApplication::ACTION_TYPE_BC_PROVIDED_SAREE;
                $bc_model->save();
            }
            $model = new BcProvidedSareeHistory();
            $model->setAttributes($this->attributes);
            $model->parent_id = $this->id;

            if ($model->save()) {
                
            } else {
                
            }
        } catch (\Exception $ex) {
            
        }
        return true;
    }

}
