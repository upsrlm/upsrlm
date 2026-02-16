<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "upsrlm_sms_log".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $mobile_number
 * @property int|null $upsrlm_sms_template_id
 * @property string|null $model
 * @property string $sms_content
 * @property string|null $service_provider_id
 * @property string|null $sms_send_time
 * @property string|null $delivery_status
 * @property int $try_send_count
 * @property int|null $unicode
 * @property int $sms_length
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $updated_at
 * @property int|null $created_at
 * @property int $status
 */
class UpsrlmSmsLog extends \yii\db\ActiveRecord {

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
        return 'upsrlm_sms_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'upsrlm_sms_template_id', 'try_send_count', 'unicode', 'sms_length', 'created_by', 'updated_by', 'updated_at', 'created_at', 'status'], 'integer'],
            [['mobile_number', 'sms_content'], 'required'],
            [['model'], 'string'],
            [['sms_send_time'], 'safe'],
            [['mobile_number'], 'string', 'max' => 20],
            [['sms_content'], 'string', 'max' => 500],
            [['service_provider_id', 'delivery_status'], 'string', 'max' => 150],
            [['status'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'mobile_number' => 'Mobile Number',
            'upsrlm_sms_template_id' => 'Upsrlm Sms Template ID',
            'model' => 'Model',
            'sms_content' => 'Sms Content',
            'service_provider_id' => 'Service Provider ID',
            'sms_send_time' => 'Sms Send Time',
            'delivery_status' => 'Delivery Status',
            'try_send_count' => 'Try Send Count',
            'unicode' => 'Unicode',
            'sms_length' => 'Sms Length',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }

}
