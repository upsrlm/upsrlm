<?php

namespace bc\modules\training\models;

use Yii;

/**
 * This is the model class for table "rsetis_center_training".
 *
 * @property int $id
 * @property int $rsetis_center_id
 * @property string|null $training_start_date
 * @property string|null $training_end_date
 * @property int $district_code
 * @property string $district_name
 * @property int $no_of_batch
 * @property int $no_of_participant
 * @property int $no_of_gp_covered
 * @property string $schedule_date_of_exam
 * @property int $group_photo_status
 * @property int|null $group_photo_upload_by
 * @property string|null $group_photo_upload_date
 * @property string|null $group_photo_file_name
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status
 */
class RsetisCenterTraining extends \bc\models\BcactiveRecord {

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
                'value' => function() {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'rsetis_center_training';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['rsetis_center_id', 'training_start_date', 'training_end_date'], 'required'],
            [['rsetis_center_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status', 'district_code', 'no_of_batch'], 'integer'],
            [['training_start_date', 'training_end_date', 'schedule_date_of_exam'], 'safe'],
            [['district_name'], 'safe'],
            [['status'], 'default', 'value' => 1],
            [['no_of_participant'], 'default', 'value' => 0],
            [['no_of_gp_covered'], 'default', 'value' => 0],
            [['no_of_batch'], 'default', 'value' => 0],
            [['group_photo_status', 'group_photo_upload_by'], 'integer'],
            [['group_photo_upload_date'], 'safe'],
            [['group_photo_file_name'], 'string', 'max' => 500],
            [['group_photo_status'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'rsetis_center_id' => 'Venue',
            'district_code' => 'District',
            'district_name' => 'District Name',
            'training_start_date' => 'Training Start Date',
            'training_end_date' => 'Training End Date',
            'schedule_date_of_exam' => 'Schedule date of exam',
            'no_of_batch' => 'No Of batch',
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

        if ($this->training_start_date != NULL and $this->training_start_date != '') {
            $this->training_start_date = \Yii::$app->formatter->asDatetime($this->training_start_date, "php:Y-m-d");
        }

        if ($this->training_end_date != NULL and $this->training_end_date != '') {
            $this->training_end_date = \Yii::$app->formatter->asDatetime($this->training_end_date, "php:Y-m-d");
        }
        if ($this->schedule_date_of_exam != NULL and $this->schedule_date_of_exam != '') {
            $this->schedule_date_of_exam = \Yii::$app->formatter->asDatetime($this->schedule_date_of_exam, "php:Y-m-d");
        }
        $this->no_of_participant = RsetisBatchParticipants::find()->where(['rsetis_center_training_id' => $this->id])->andWhere(['!=', 'status', -1])->count();
        $this->no_of_gp_covered = RsetisBatchParticipants::find()->select('gram_panchayat_code')->distinct()->where(['rsetis_center_training_id' => $this->id])->andWhere(['!=', 'status', -1])->groupBy('gram_panchayat_code')->count();
        return parent::beforeSave($insert);
    }
    public function getDistrict() {
        return $this->hasOne(\bc\models\master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }
    public function getDate() {
        return date("d-m-Y", strtotime($this->training_start_date)) . " to " . date("d-m-Y", strtotime($this->training_end_date));
    }

    public function getBatch() {
        return $this->hasMany(RsetisBatchTraining::className(), ['rsetis_center_training_id' => 'id']);
    }

    public function getTbatch() {
        return $this->hasOne(RsetisBatchTraining::className(), ['rsetis_center_training_id' => 'id']);
    }

    public function getCenter() {
        return $this->hasOne(RsetisCenter::className(), ['id' => 'rsetis_center_id']);
    }
    public function getPbank() {
        return $this->hasOne(\bc\models\master\MasterPartnerBankDistrict::className(), ['district_code' => 'district_code']);
    }
    public function getParticipant() {
        return $this->hasMany(RsetisBatchParticipants::className(), ['rsetis_center_training_id' => 'id'])->joinWith(['participant'])->where(['!=', RsetisBatchParticipants::getTableSchema()->fullName . '.status', -1])->andWhere(['=', 'srlm_bc_application.blocked', '0']);
    }

    public function getContacts() {
        if (in_array($this->district_code, [162, 186])) {
            return $this->hasMany(\common\models\dynamicdb\bc\RelationUserDistrict::className(), ['district_code' => 'district_code', 'user_id' => 'created_by'])->joinWith(['user'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_RSETIS_DISTRICT_UNIT]);
        }
        return $this->hasMany(\common\models\dynamicdb\bc\RelationUserDistrict::className(), ['district_code' => 'district_code'])->joinWith(['user'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_RSETIS_DISTRICT_UNIT]);
    }

    public function getRsethileadbank() {
        if (in_array($this->district_code, [162, 186])) {
            return $this->hasMany(\common\models\dynamicdb\bc\RelationUserDistrict::className(), ['district_code' => 'district_code', 'user_id' => 'created_by'])->joinWith(['user'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_RSETIS_DISTRICT_UNIT]);
        }
        return $this->hasMany(\common\models\dynamicdb\bc\RelationUserDistrict::className(), ['district_code' => 'district_code'])->joinWith(['user', 'profile'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_RSETIS_DISTRICT_UNIT, 'relation_user_district.status' => 1]);
    }

    public function getBcbankpartner() {
        return $this->hasMany(\common\models\dynamicdb\bc\RelationUserDistrict::className(), ['district_code' => 'district_code'])->joinWith(['user'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, 'relation_user_district.status' => 1]);
    }

    public function getBatchstatus() {
        $op = [1 => 'Not Concluded', 2 => 'Concluded'];
        return isset($op[$this->status]) ? $op[$this->status] : '';
    }
    public function getGroup_photo_url() {
        return "/getimage/training/" . $this->id . "/" . $this->group_photo_file_name;
    }
}
