<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use Yii;

/**
 * This is the model class for table "ultra_poor_agent_sahayak_daily_progress".
 *
 * @property int $id
 * @property int|null $upsrlm_user_id
 * @property int|null $upsrlm_user_role
 * @property int|null $upsrlm_user_group
 * @property string|null $upsrlm_user_name
 * @property string|null $upsrlm_user_mobile_no
 * @property string|null $upsrlm_user_district
 * @property string|null $upsrlm_user_block
 * @property string|null $date
 * @property int $target
 * @property int $attempt_call
 * @property int $sms_sent
 * @property int $app_download
 * @property int $no_of_user_add
 * @property int $goverment_order_sent
 * @property int|null $total_ivr_time
 * @property int|null $total_talk_time
 * @property string|null $call_start_time
 * @property string|null $call_end_time
 * @property int|null $work_hour
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class UltraPoorAgentSahayakDailyProgress extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ultra_poor_agent_sahayak_daily_progress';
    }

   public function behaviors() {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['upsrlm_user_id', 'upsrlm_user_role', 'upsrlm_user_group', 'target', 'attempt_call', 'sms_sent', 'app_download', 'no_of_user_add', 'goverment_order_sent', 'total_ivr_time', 'total_talk_time', 'work_hour', 'created_at', 'updated_at'], 'integer'],
            [['upsrlm_user_district', 'upsrlm_user_block'], 'string'],
            [['date', 'call_start_time', 'call_end_time'], 'safe'],
            [['upsrlm_user_name'], 'string', 'max' => 255],
            [['upsrlm_user_mobile_no'], 'string', 'max' => 15],
            [['upsrlm_user_id', 'date'], 'unique', 'targetAttribute' => ['upsrlm_user_id', 'date']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'upsrlm_user_id' => 'Upsrlm User ID',
            'upsrlm_user_role' => 'Upsrlm User Role',
            'upsrlm_user_group' => 'Upsrlm User Group',
            'upsrlm_user_name' => 'Upsrlm User Name',
            'upsrlm_user_mobile_no' => 'Upsrlm User Mobile No',
            'upsrlm_user_district' => 'Upsrlm User District',
            'upsrlm_user_block' => 'Upsrlm User Block',
            'date' => 'Date',
            'target' => 'Target',
            'attempt_call' => 'Attempt Call',
            'sms_sent' => 'Sms Sent',
            'app_download' => 'App Download',
            'no_of_user_add' => 'No Of User Add',
            'goverment_order_sent' => 'Goverment Order Sent',
            'total_ivr_time' => 'Total Ivr Time',
            'total_talk_time' => 'Total Talk Time',
            'call_start_time' => 'Call Start Time',
            'call_end_time' => 'Call End Time',
            'work_hour' => 'Work Hour',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
