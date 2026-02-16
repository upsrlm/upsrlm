<?php

namespace common\models\dynamicdb\cbo_detail;

use Yii;

/**
 * This is the model class for table "rishta_shg_samuh_sakhi_sms_apppin_status".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $mobile_no
 * @property int $cbo_shg_id
 * @property int $role
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int $apppin_sms_status
 * @property string|null $apppin_sms_time
 * @property string|null $ack_time
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class RishtaShgSamuhSakhiSmsApppinStatus extends CboDetailactiveRecord {

    const APP_PIN_SMS_STATUS_DEFAULT = 0;
    const APP_PIN_SMS_STATUS_LOG = 1;
    const APP_PIN_SMS_STATUS_SEND = 2;
    const APP_PIN_SMS_STATUS_ACK = 3;
    const APP_PIN_SMS_STATUS_ALLREADY_CREATED = 4;

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
        return 'rishta_shg_samuh_sakhi_sms_apppin_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'cbo_shg_id', 'role', 'district_code', 'block_code', 'apppin_sms_status', 'created_at', 'updated_at'], 'integer'],
            [['mobile_no', 'cbo_shg_id', 'role'], 'required'],
            [['apppin_sms_time','ack_time'], 'safe'],
            [['mobile_no'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'mobile_no' => 'Mobile No',
            'cbo_shg_id' => 'Cbo Shg ID',
            'role' => 'Role',
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
            'apppin_sms_status' => 'Apppin Sms Status',
            'apppin_sms_time' => 'Apppin Sms Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
