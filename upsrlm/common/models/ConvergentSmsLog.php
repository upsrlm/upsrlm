<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "convergent_sms_log".
 *
 * @property int $id
 * @property string $mobile_number
 * @property int|null $otp
 * @property string|null $sms_content
 * @property string|null $service_provider_id
 * @property string|null $sms_send_time
 * @property int|null $unicode
 * @property int $sms_length
 * @property int|null $updated_at
 * @property int|null $created_at
 * @property int $status
 */
class ConvergentSmsLog extends \common\models\dynamicdb\cbo\CboactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'convergent_sms_log';
    }

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
    public function rules() {
        return [
            [['mobile_number', 'otp'], 'required'],
            [['unicode', 'sms_length', 'updated_at', 'created_at', 'status'], 'integer'],
            [['sms_send_time'], 'safe'],
            [['mobile_number'], 'string', 'max' => 20],
            [['sms_content'], 'string', 'max' => 255],
            [['service_provider_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'mobile_number' => 'Mobile Number',
            'otp' => 'OTP',
            'sms_content' => 'Sms Content',
            'service_provider_id' => 'Service Provider ID',
            'sms_send_time' => 'Sms Send Time',
            'unicode' => 'Unicode',
            'sms_length' => 'Sms Length',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
}
