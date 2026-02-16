<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use Yii;

/**
 * This is the model class for table "calling_daily_progress".
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
 * @property int $s1001
 * @property int $s1002
 * @property int $s1003
 * @property int $s1004
 * @property int $s1005
 * @property int $s1013
 * @property int $s1001_call_atempt
 * @property int $s1001_call_continue
 * @property int $s1001_call_achieve
 * @property int $s1001_call_pending
 * @property int $s1001_ivr_time
 * @property int $s1001_talk_time
 * @property int $s1002_call_atempt
 * @property int $s1002_call_continue
 * @property int $s1002_call_achieve
 * @property int $s1002_call_pending
 * @property int $s1002_ivr_time
 * @property int $s1002_talk_time
 * @property int $s1003_call_atempt
 * @property int $s1003_call_continue
 * @property int $s1003_call_achieve
 * @property int $s1003_call_pending
 * @property int $s1003_ivr_time
 * @property int $s1003_talk_time
 * @property int $s1004_call_atempt
 * @property int $s1004_call_continue
 * @property int $s1004_call_achieve
 * @property int $s1004_call_pending
 * @property int $s1004_ivr_time
 * @property int $s1004_talk_time
 * @property int $s1005_call_atempt
 * @property int $s1005_call_continue
 * @property int $s1005_call_achieve
 * @property int $s1005_call_pending
 * @property int $s1005_ivr_time
 * @property int $s1005_talk_time
 * @property int $s1013_call_atempt
 * @property int $s1013_call_continue
 * @property int $s1013_call_achieve
 * @property int $s1013_call_pending
 * @property int $s1013_ivr_time
 * @property int $s1013_talk_time
 * @property int $total_call_atempt
 * @property int $total_call_continue
 * @property int $total_ivr_time
 * @property int $total_talk_time
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class CallingDailyProgress extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'calling_daily_progress';
    }

    public function behaviors() {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['upsrlm_user_id', 'upsrlm_user_role', 'upsrlm_user_group', 's1001', 's1002', 's1003', 's1004', 's1005', 's1013', 's1001_call_atempt', 's1001_call_continue', 's1001_call_achieve', 's1001_call_pending', 's1001_ivr_time', 's1001_talk_time', 's1002_call_atempt', 's1002_call_continue', 's1002_call_achieve', 's1002_call_pending', 's1002_ivr_time', 's1002_talk_time', 's1003_call_atempt', 's1003_call_continue', 's1003_call_achieve', 's1003_call_pending', 's1003_ivr_time', 's1003_talk_time', 's1004_call_atempt', 's1004_call_continue', 's1004_call_achieve', 's1004_call_pending', 's1004_ivr_time', 's1004_talk_time', 's1005_call_atempt', 's1005_call_continue', 's1005_call_achieve', 's1005_call_pending', 's1005_ivr_time', 's1005_talk_time', 's1013_call_atempt', 's1013_call_continue', 's1013_call_achieve', 's1013_call_pending', 's1013_ivr_time', 's1013_talk_time', 'total_call_atempt', 'total_call_continue', 'total_ivr_time', 'total_talk_time', 'created_at', 'updated_at'], 'integer'],
            [['date'], 'safe'],
            [['upsrlm_user_name'], 'string', 'max' => 255],
            [['upsrlm_user_mobile_no'], 'string', 'max' => 15],
            [['upsrlm_user_district', 'upsrlm_user_block'], 'string', 'max' => 1000],
            [['upsrlm_user_id', 'date'], 'unique', 'targetAttribute' => ['upsrlm_user_id', 'date']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
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
            's1001' => 'S1001',
            's1002' => 'S1002',
            's1003' => 'S1003',
            's1004' => 'S1004',
            's1005' => 'S1005',
            's1013' => 'S1013',
            's1001_call_atempt' => 'S1001 Call Atempt',
            's1001_call_continue' => 'S1001 Call Continue',
            's1001_call_achieve' => 'S1001 Call Achieve',
            's1001_call_pending' => 'S1001 Call Pending',
            's1001_ivr_time' => 'S1001 Ivr Time',
            's1001_talk_time' => 'S1001 Talk Time',
            's1002_call_atempt' => 'S1002 Call Atempt',
            's1002_call_continue' => 'S1002 Call Continue',
            's1002_call_achieve' => 'S1002 Call Achieve',
            's1002_call_pending' => 'S1002 Call Pending',
            's1002_ivr_time' => 'S1002 Ivr Time',
            's1002_talk_time' => 'S1002 Talk Time',
            's1003_call_atempt' => 'S1003 Call Atempt',
            's1003_call_continue' => 'S1003 Call Continue',
            's1003_call_achieve' => 'S1003 Call Achieve',
            's1003_call_pending' => 'S1003 Call Pending',
            's1003_ivr_time' => 'S1003 Ivr Time',
            's1003_talk_time' => 'S1003 Talk Time',
            's1004_call_atempt' => 'S1004 Call Atempt',
            's1004_call_continue' => 'S1004 Call Continue',
            's1004_call_achieve' => 'S1004 Call Achieve',
            's1004_call_pending' => 'S1004 Call Pending',
            's1004_ivr_time' => 'S1004 Ivr Time',
            's1004_talk_time' => 'S1004 Talk Time',
            's1005_call_atempt' => 'S1005 Call Atempt',
            's1005_call_continue' => 'S1005 Call Continue',
            's1005_call_achieve' => 'S1005 Call Achieve',
            's1005_call_pending' => 'S1005 Call Pending',
            's1005_ivr_time' => 'S1005 Ivr Time',
            's1005_talk_time' => 'S1005 Talk Time',
            's1013_call_atempt' => 'S1013 Call Atempt',
            's1013_call_continue' => 'S1013 Call Continue',
            's1013_call_achieve' => 'S1013 Call Achieve',
            's1013_call_pending' => 'S1013 Call Pending',
            's1013_ivr_time' => 'S1013 Ivr Time',
            's1013_talk_time' => 'S1013 Talk Time',
            'total_call_atempt' => 'Total Call Atempt',
            'total_call_continue' => 'Total Call Continue',
            'total_ivr_time' => 'Total Ivr Time',
            'total_talk_time' => 'Total Talk Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getAgentd() {
        return $this->hasOne(\common\models\dynamicdb\internalcallcenter\platform\CallingAgentProgress::className(), ['calling_agent_id' => 'upsrlm_user_id', 'calling_date' => 'date']);
    }

}
