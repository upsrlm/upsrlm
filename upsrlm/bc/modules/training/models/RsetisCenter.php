<?php

namespace bc\modules\training\models;

use bc\models\master\MasterDistrict;
use Yii;

/**
 * This is the model class for table "rsetis_center".
 *
 * @property int $id
 * @property string $name
 * @property int|null $district_code
 * @property string|null $district_name
 * @property string|null $venue
 * @property string|null $gps
 * @property int $no_of_batch
 * @property int $no_of_training
 * @property int $no_of_participant
 * @property int $no_of_gp_covered
 * @property int|null $total_bc_sortlisted
 * @property int|null $total_gp
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status
 */
class RsetisCenter extends \bc\models\BcactiveRecord {

    // public $district_option=[];
    // public $center_model;

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
        return 'rsetis_center';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'district_code', 'venue'], 'required'],
            [['name', 'district_code', 'venue'], 'trim'],
            [['district_code', 'created_by', 'no_of_batch', 'no_of_training', 'no_of_participant', 'no_of_gp_covered', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['total_bc_sortlisted', 'total_gp'], 'integer'],
            [['name', 'district_name', 'gps'], 'string', 'max' => 255],
            [['venue'], 'string', 'max' => 500],
            [['status'], 'default', 'value' => 1],
            [['no_of_batch'], 'default', 'value' => 0],
            [['no_of_training'], 'default', 'value' => 0],
            [['no_of_participant'], 'default', 'value' => 0],
            [['no_of_gp_covered'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Venue',
            'district_code' => 'District',
            'district_name' => 'District Name',
            'venue' => 'Venue Address',
            'gps' => 'Gps',
            'no_of_batch' => 'No Of Batch',
            'no_of_training' => 'No Of Training',
            'no_of_participant' => 'No Of Participant',
            'no_of_gp_covered' => 'No Of GP Covered',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {
        $this->no_of_batch = RsetisBatchTraining::find()->where(['rsetis_center_id' => $this->id])->andWhere(['!=', 'status', -1])->count();
        $this->no_of_training = RsetisCenterTraining::find()->where(['rsetis_center_id' => $this->id])->andWhere(['!=', 'status', -1])->count();
        $this->no_of_participant = RsetisBatchParticipants::find()->where(['rsetis_center_id' => $this->id])->andWhere(['!=', 'status', -1])->count();
        $this->no_of_gp_covered = RsetisBatchParticipants::find()->select('gram_panchayat_code')->distinct()->where(['rsetis_center_id' => $this->id])->andWhere(['!=', 'status', -1])->groupBy('gram_panchayat_code')->count();
        return parent::beforeSave($insert);
    }

    public function getBatch() {
        return $this->hasMany(RsetisBatchTraining::className(), ['rsetis_center_id' => 'id'])->andWhere(['!=', RsetisBatchTraining::getTableSchema()->fullName . '.status', -1]);
    }

    public function getTraining() {
        return $this->hasMany(RsetisCenterTraining::className(), ['rsetis_center_id' => 'id'])->where(['!=', RsetisCenterTraining::getTableSchema()->fullName . '.status', -1]);
    }

    public function getParticipant() {
        return $this->hasMany(RsetisBatchParticipants::className(), ['district_code' => 'district_code'])->joinWith(['participant'])->where(['!=', RsetisBatchParticipants::getTableSchema()->fullName . '.status', -1]);
    }

    public function getDistrict() {
        return $this->hasOne(MasterDistrict::className(), ['district_code' => 'district_code']);
    }
    public function getPbank() {
        return $this->hasOne(\bc\models\master\MasterPartnerBankDistrict::className(), ['district_code' => 'district_code']);
    }
    public function getRsethicontacts() {
        return $this->hasMany(\common\models\dynamicdb\bc\RelationUserDistrict::className(), ['district_code' => 'district_code'])->joinWith(['user'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_RSETIS_DISTRICT_UNIT, 'relation_user_district.status' => 1]);
    }

    public function getRsethileadbank() {
        return $this->hasMany(\common\models\dynamicdb\bc\RelationUserDistrict::className(), ['district_code' => 'district_code'])->joinWith(['user', 'profile'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_RSETIS_DISTRICT_UNIT, 'relation_user_district.status' => 1]);
    }

    public function getBcbankpartner() {
        return $this->hasMany(\common\models\dynamicdb\bc\RelationUserDistrict::className(), ['district_code' => 'district_code'])->joinWith(['user'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, 'relation_user_district.status' => 1]);
    }

    public function getNoofgp() {
        return $this->hasMany(\bc\models\master\MasterGramPanchayat::className(), ['district_code' => 'district_code'])->select('id')->where(['master_gram_panchayat.status' => 1])->asArray()->count();
    }

    public function getSelectedcadidate() {
        return $this->hasMany(\bc\modules\selection\models\SrlmBcApplication::className(), ['district_code' => 'district_code'])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->select('id')->asArray()->count();
    }

    public function getNooftrainingplaned() {
        return $this->hasMany(RsetisCenterTraining::className(), ['district_code' => 'district_code'])->select('id')->andWhere(['status' => [1, 2]])->asArray()->count();
    }

    public function getNooftrainingfinished() {
        return $this->hasMany(RsetisCenterTraining::className(), ['district_code' => 'district_code'])->select('id')->andWhere(['status' => 2])->asArray()->count();
    }

}
