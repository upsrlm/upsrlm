<?php

namespace common\models\dynamicdb\cbo_detail;

use Yii;

/**
 * This is the model class for table "rishta_shg_member_app_pin".
 *
 * @property int $id
 * @property string $mobile_no
 * @property int $cbo_shg_id
 * @property int $role
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property int|null $village_code
 * @property int $app_sms_status
 * @property int $pin_sms_status
 * @property string|null $app_sms_time
 * @property string|null $ack_time
 * @property string|null $pin_sms_time
 * @property int $app_sms_call_log_id
 * @property int $app_install_call_log_id
 * @property int $suggest_samuh_sakhi_call_log_id
 * @property string|null $reason_not_talk
 * @property int $smart_phone
 * @property int $agree_download_rishta_app
 * @property int $else_having_smart_phone
 * @property int $carry_smart_phone
 * @property int $no_of_call
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class RishtaShgMemberAppPin extends CboDetailactiveRecord {

    const APP_SMS_STATUS_DEFAULT = 0;
    const APP_SMS_STATUS_LOG = 1;
    const APP_SMS_STATUS_SEND = 2;
    const APP_SMS_STATUS_ACK = 3;
    const APP_SMS_STATUS_ALLREADY_CREATED = 4;
    const PIN_SMS_STATUS_DEFAULT = 0;
    const PIN_SMS_STATUS_LOG = 1;
    const PIN_SMS_STATUS_SEND = 2;
    const PIN_SMS_STATUS_ACK = 3;
    const PIN_SMS_STATUS_ALLREADY_CREATED = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'rishta_shg_member_app_pin';
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
            [['mobile_no', 'cbo_shg_id', 'role'], 'required'],
            [['mobile_no'], 'unique'],
            [['cbo_shg_id', 'role', 'district_code', 'block_code', 'app_sms_status', 'pin_sms_status', 'created_at', 'updated_at'], 'integer'],
            [['app_sms_time', 'pin_sms_time', 'ack_time'], 'safe'],
            [['mobile_no'], 'string', 'max' => 12],
            [['app_sms_call_log_id', 'app_install_call_log_id', 'suggest_samuh_sakhi_call_log_id', 'smart_phone'], 'integer'],
            ['app_sms_call_log_id', 'default', 'value' => 0],
            ['app_install_call_log_id', 'default', 'value' => 0],
            ['suggest_samuh_sakhi_call_log_id', 'default', 'value' => 0],
            ['smart_phone', 'default', 'value' => 0],
            ['no_of_call', 'default', 'value' => 0],
            [['gram_panchayat_code', 'village_code', 'smart_phone', 'agree_download_rishta_app', 'else_having_smart_phone', 'carry_smart_phone'], 'integer'],
            [['app_sms_time', 'ack_time', 'pin_sms_time'], 'safe'],
            [['mobile_no'], 'string', 'max' => 12],
            [['reason_not_talk'], 'string', 'max' => 500],
            ['agree_download_rishta_app', 'default', 'value' => 0],
            ['else_having_smart_phone', 'default', 'value' => 0],
            ['carry_smart_phone', 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'mobile_no' => 'Mobile No',
            'cbo_shg_id' => 'Cbo Shg ID',
            'role' => 'Role',
            'district_code' => 'District',
            'block_code' => 'Block',
            'gram_panchayat_code' => 'Gram Panchayat',
            'village_code' => 'Rev. Village',
            'app_sms_status' => 'App Sms Status',
            'pin_sms_status' => 'Pin Sms Staus',
            'app_sms_time' => 'App Sms Time',
            'pin_sms_time' => 'Pin Sms Time',
            'reason_not_talk' => 'Reason for not able to talk with ',
            'smart_phone' => 'Smart Phone',
            'agree_download_rishta_app' => 'Agree Download Rishta App',
            'else_having_smart_phone' => 'Else Having Smart Phone',
            'carry_smart_phone' => 'Carry Smart Phone',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getShg() {
        return $this->hasOne(\cbo\models\Shg::className(), ['id' => 'cbo_shg_id']);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['username' => 'mobile_no']);
    }

    public function getTempm() {
        return $this->hasOne(TempMobileNo::className(), ['mobile_no' => 'mobile_no']);
    }

    public function getMrole() {
        return $this->hasOne(master\CboMasterMemberDesignation::className(), ['id' => 'role']);
    }

    public function getName() {
        $name = '';
        if ($this->role == 1) {
            $name = $this->shg->chaire_person_name;
        }
        if ($this->role == 2) {
            $name = $this->shg->secretary_name;
        }
        if ($this->role == 3) {
            $name = $this->shg->treasurer_name;
        }
        return $name;
    }

    public function getAppsms() {
        $arr = [
            0 => '',
            1 => '',
            2 => 'Send',
            3 => 'Acknowledge',
            4 => '',
        ];

        return $arr[$this->app_sms_status];
    }

    public function getPinsms() {
        $arr = [
            0 => '',
            1 => '',
            2 => 'Send',
            3 => 'Acknowledge',
            4 => '',
        ];

        return $arr[$this->pin_sms_status];
    }

}
