<?php

namespace bc\models;

use Yii;

/**
 * This is the model class for table "upsrlm_framework_validation".
 *
 * @property int $id
 * @property int|null $key_id
 * @property int|null $deliverables_id
 * @property int|null $start_date
 * @property int|null $operational_stage
 * @property int|null $current_status
 * @property int|null $validation_by
 * @property int|null $validation_status
 * @property string|null $validation_datetime
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class UpsrlmFrameworkValidation extends BcactiveRecord {

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
        return 'upsrlm_framework_validation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['key_id', 'deliverables_id', 'start_date', 'operational_stage', 'current_status', 'validation_by', 'validation_status', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['validation_datetime'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'key_id' => 'Key ID',
            'deliverables_id' => 'Deliverables ID',
            'start_date' => 'Start Date',
            'operational_stage' => 'Operational Stage',
            'current_status' => 'Current Status',
            'validation_by' => 'Validation By',
            'validation_status' => 'Validation Status',
            'validation_datetime' => 'Validation Datetime',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getKeyf() {
        return $this->hasOne(UpsrlmFrameworkValidationKey::className(), ['id' => 'key_id']);
    }

    public function getDeli() {
        return $this->hasOne(UpsrlmFrameworkValidationDeliverables::className(), ['id' => 'deliverables_id']);
    }

    public function getOps() {
        return $this->hasOne(UpsrlmFrameworkValidationOperationalStage::className(), ['id' => 'operational_stage']);
    }

    public function getCt() {
        return $this->hasOne(UpsrlmFrameworkValidationCurrentStatus::className(), ['id' => 'current_status']);
    }

    public function getSt() {
        return $this->hasOne(UpsrlmFrameworkValidationStart::className(), ['id' => 'start_date']);
    }

    public function getBy() {
        return $this->hasOne(\common\models\dynamicdb\bc\User::className(), ['id' => 'validation_by']);
    }

}
