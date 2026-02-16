<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "upsrlm_sms_template".
 *
 * @property int $id
 * @property int|null $application_id
 * @property int $unicode
 * @property int $sms_count
 * @property string $name
 * @property string $sms_template
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class UpsrlmSmsTemplate extends \yii\db\ActiveRecord {

    const USER_OTP_TEMPALTE_ID = 1;

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
        return 'upsrlm_sms_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['application_id', 'unicode', 'sms_count', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['name', 'sms_template'], 'required'],
            [['name', 'sms_template'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'application_id' => 'Application ID',
            'unicode' => 'Unicode',
            'sms_count' => 'Sms Count',
            'name' => 'Name',
            'sms_template' => 'Sms Template',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

}
