<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "sms_log".
 *
 * @property int $id
 * @property string $mobile_no
 * @property string $imei_no
 * @property string $os_type
 * @property string $manufacturer_name
 * @property string $os_version
 * @property string $firebase_token
 * @property string $app_version
 * @property string $time
 * @property string|null $sms_send_time
 * @property string|null $otp
 * @property string|null $message_id
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int $status
 */
class SmsLog extends BcactiveRecord {

    use \common\traits\Signature;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'sms_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['mobile_no', 'imei_no', 'os_type', 'manufacturer_name', 'os_version', 'app_version', 'time'], 'required'],
            [['firebase_token'], 'string'],
            [['firebase_token'], 'safe'],
            [['firebase_token'], 'default','value'=>''],
            [['time', 'sms_send_time'], 'safe'],
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['mobile_no', 'otp'], 'safe'],
            [['imei_no', 'os_type', 'app_version'], 'string', 'max' => 100],
            [['manufacturer_name', 'os_version'], 'string', 'max' => 150],
            [['message_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'mobile_no' => 'Mobile No',
            'imei_no' => 'Imei No',
            'os_type' => 'Os Type',
            'manufacturer_name' => 'Manufacturer Name',
            'os_version' => 'Os Version',
            'firebase_token' => 'Firebase Token',
            'app_version' => 'App Version',
            'time' => 'Time',
            'sms_send_time' => 'Sms Send Time',
            'otp' => 'Otp',
            'message_id' => 'Message ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

}
