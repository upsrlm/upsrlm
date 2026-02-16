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
class MemberAppPin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rishta_shg_member_app_pin';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbcbodetail');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mobile_no', 'cbo_shg_id', 'role'], 'required'],
            [['cbo_shg_id', 'role', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'app_sms_status', 'pin_sms_status', 'app_sms_call_log_id', 'app_install_call_log_id', 'suggest_samuh_sakhi_call_log_id', 'smart_phone', 'agree_download_rishta_app', 'else_having_smart_phone', 'carry_smart_phone', 'no_of_call', 'created_at', 'updated_at'], 'integer'],
            [['app_sms_time', 'ack_time', 'pin_sms_time'], 'safe'],
            [['mobile_no'], 'string', 'max' => 12],
            [['reason_not_talk'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobile_no' => 'Mobile No',
            'cbo_shg_id' => 'Cbo Shg ID',
            'role' => 'Role',
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'village_code' => 'Village Code',
            'app_sms_status' => 'App Sms Status',
            'pin_sms_status' => 'Pin Sms Status',
            'app_sms_time' => 'App Sms Time',
            'ack_time' => 'Ack Time',
            'pin_sms_time' => 'Pin Sms Time',
            'app_sms_call_log_id' => 'App Sms Call Log ID',
            'app_install_call_log_id' => 'App Install Call Log ID',
            'suggest_samuh_sakhi_call_log_id' => 'Suggest Samuh Sakhi Call Log ID',
            'reason_not_talk' => 'Reason Not Talk',
            'smart_phone' => 'Smart Phone availaibility',
            'agree_download_rishta_app' => 'Do you agree to download Rishta app in your phone',
            'else_having_smart_phone' => 'Who else is having smart phone in SHG',
            'carry_smart_phone' => 'Do they carry the smartphone with them',
            'no_of_call' => 'No Of Call',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
