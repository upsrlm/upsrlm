<?php

namespace bc\modules\corona\models;

use Yii;

/**
 * This is the model class for table "bc_corona_feedback".
 *
 * @property int $id
 * @property int $bc_application_id
 * @property int $srlm_bc_selection_user_id
 * @property string|null $bc_name
 * @property int|null $division_code
 * @property string|null $division_name
 * @property int|null $district_code
 * @property string|null $district_name
 * @property int|null $block_code
 * @property string|null $block_name
 * @property int|null $gram_panchayat_code
 * @property string|null $gram_panchayat_name
 * @property int|null $village_code
 * @property string|null $village_name
 * @property string|null $hamlet
 * @property int|null $que1a
 * @property int|null $que2a
 * @property int|null $que3a
 * @property int|null $que4a
 * @property string|null $gps
 * @property string|null $gps_accuracy
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class BcCoronaFeedback extends \bc\modules\selection\models\BcactiveRecord {

    public function behaviors() {
        return [
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
        return 'bc_corona_feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id', 'srlm_bc_selection_user_id'], 'required'],
            [['bc_application_id', 'srlm_bc_selection_user_id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'que1a', 'que2a', 'que3a', 'que4a', 'created_at', 'updated_at', 'status'], 'integer'],
            [['bc_name'], 'string', 'max' => 255],
            [['division_name'], 'string', 'max' => 60],
            [['district_name', 'block_name', 'gram_panchayat_name', 'village_name', 'hamlet'], 'string', 'max' => 100],
            [['gps'], 'safe'],
            [['gps_accuracy'], 'safe'],
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
            'bc_name' => 'Bc Name',
            'division_code' => 'Division',
            'division_name' => 'Division',
            'district_code' => 'District',
            'district_name' => 'District',
            'block_code' => 'Block',
            'block_name' => 'Block',
            'gram_panchayat_code' => 'Gram Panchayat',
            'gram_panchayat_name' => 'Gram Panchayat',
            'village_code' => 'Village',
            'village_name' => 'Village',
            'hamlet' => 'Hamlet',
            'que1a' => 'क्या आपके गाँव/ ग्राम पंचायत में काफ़ी लोगों को तेज बुख़ार, साँस की तकलीफ़, सीने में जकड़न इत्यादि की शिकायत है ?',
            'que2a' => 'अगर हाँ तो % ?',
            'que3a' => 'पिछले एक दो महीने में गाँव/ ग्रा०प० में कितने लोगों की मृत्यु हुई है ?',
            'que4a' => 'पिछले कुछ दिनों में गाँव में इस तरह के बीमारियों की गम्भीरता कैसी है?',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getBcapplication() {
        return $this->hasOne(\bc\modules\selection\models\SrlmBcApplication::className(), ['id' => 'bc_application_id']);
    }

    public function getBcuser() {
        return $this->hasOne(\bc\modules\selection\models\SrlmBcSelectionUser::className(), ['id' => 'srlm_bc_selection_user_id']);
    }

    public function getDivision() {
        return $this->hasOne(\bc\models\master\MasterDivision::className(), ['division_code' => 'division_code']);
    }

    public function getDistrict() {
        return $this->hasOne(\bc\models\master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getBlock() {
        return $this->hasOne(\bc\models\master\MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getVillage() {
        return $this->hasOne(\bc\models\master\MasterVillage::className(), ['village_code' => 'village_code']);
    }

    public function getGp() {
        return $this->hasOne(\bc\models\master\MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }

    public function getQ1a() {
        return $this->hasOne(master\CoronaFeedbackMasterQues1a::className(), ['id' => 'que1a']);
    }

    public function getQ2a() {
        return $this->hasOne(master\CoronaFeedbackMasterQues2a::className(), ['id' => 'que2a']);
    }

    public function getQ3a() {
        return $this->hasOne(master\CoronaFeedbackMasterQues3a::className(), ['id' => 'que3a']);
    }

    public function getQ4a() {
        return $this->hasOne(master\CoronaFeedbackMasterQues4a::className(), ['id' => 'que4a']);
    }

}
