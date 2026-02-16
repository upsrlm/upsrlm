<?php

namespace bc\modules\training\models;

use bc\models\master\MasterDistrict;
use Yii;

/**
 * This is the model class for table "rsetis_batch_training".
 *
 * @property int $id
 * @property string $batch_name
 * @property int $rsetis_center_id
 * @property int $district_code
 * @property string $district_name
 * @property int $rsetis_center_training_id
 * @property int $no_of_participant
 * @property int $no_of_gp_covered
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status
 */
class RsetisBatchTraining extends \bc\models\BcactiveRecord {

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
        return 'rsetis_batch_training';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['batch_name', 'district_code'], 'required'],
            [['rsetis_center_id', 'rsetis_center_training_id'], 'safe'],
            [['rsetis_center_id', 'rsetis_center_training_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['batch_name'], 'string', 'max' => 255],
            [['batch_name'], 'trim'],
            [['status'], 'default', 'value' => 1],
            [['rsetis_center_id'], 'default', 'value' => 0],
            [['rsetis_center_training_id'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
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
            'batch_name' => 'Batch Name',
            'rsetis_center_id' => 'Venue',
            'rsetis_center_training_id' => 'Center Training ID',
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
        $this->no_of_participant = RsetisBatchParticipants::find()->where(['rsetis_batch_id' => $this->id])->andWhere(['!=', 'status', -1])->count();
        $this->no_of_gp_covered = RsetisBatchParticipants::find()->select('gram_panchayat_code')->distinct()->where(['rsetis_batch_id' => $this->id])->andWhere(['!=', 'status', -1])->groupBy('gram_panchayat_code')->count();
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {
        try {
            if ($this->center != null) {
                $this->center->update();
            }
        } catch (Exception $ex) {
            
        }
        return true;
    }

    public function getCenter() {
        return $this->hasOne(RsetisCenter::className(), ['id' => 'rsetis_center_id']);
    }

    public function getTraining() {
        return $this->hasOne(RsetisCenterTraining::className(), ['id' => 'rsetis_center_training_id']);
    }

    public function getParticipant() {
        return $this->hasMany(RsetisBatchParticipants::className(), ['rsetis_batch_id' => 'id'])->where(['!=', RsetisBatchParticipants::getTableSchema()->fullName . '.status', -1]);
    }

    public function getBatch() {
        return $this->hasOne(RsetisBatchTraining::className(), ['id' => 'rsetis_batch_id']);
    }

    public function getDistrict() {
        return $this->hasOne(MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getCentertraining() {
        return $this->hasOne(RsetisCenterTraining::className(), ['id' => 'rsetis_center_training_id']);
    }

}
