<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use Yii;


/**
 * This is the model class for table "calling_agent_progress".
 *
 * @property int $id
 * @property int $calling_agent_id
 * @property int|null $calling_agent_role
 * @property string $calling_date
 * @property string|null $start_time
 * @property string|null $end_time
 * @property int $work_hour work hours in seconds
 * @property int $ctc_click Number of Times Call APi get Success
 * @property int $agent_call_recived Number of Times Agent Mark they recivied Call
 * @property int $upsrlm_connection_status1
 * @property int $upsrlm_connection_status21
 * @property int $upsrlm_connection_status22
 * @property int $upsrlm_connection_status23
 * @property int $upsrlm_connection_status24
 * @property int $upsrlm_connection_status30
 * @property int $both_answered
 * @property int $from_unanswered
 * @property int $talk_duration talk duration in seconds
 * @property int $ivr_duration ivr duration in seconds
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int $status
 */
class CallingAgentProgress extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calling_agent_progress';
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['calling_agent_id', 'calling_date'], 'required'],
            [['calling_agent_id', 'calling_agent_role', 'work_hour', 'ctc_click', 'agent_call_recived', 'upsrlm_connection_status1', 'upsrlm_connection_status21', 'upsrlm_connection_status22', 'upsrlm_connection_status23', 'upsrlm_connection_status24', 'upsrlm_connection_status30', 'both_answered', 'from_unanswered', 'talk_duration', 'ivr_duration', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['calling_date', 'start_time', 'end_time'], 'safe'],
            [['calling_agent_id', 'calling_date'], 'unique', 'targetAttribute' => ['calling_agent_id', 'calling_date']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'calling_agent_id' => 'Calling Agent ID',
            'calling_agent_role' => 'Calling Agent Role',
            'calling_date' => 'Calling Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'work_hour' => 'Work Hour',
            'ctc_click' => 'Ctc Click',
            'agent_call_recived' => 'Agent Call Recived',
            'upsrlm_connection_status1' => 'Upsrlm Connection Status1',
            'upsrlm_connection_status21' => 'Upsrlm Connection Status21',
            'upsrlm_connection_status22' => 'Upsrlm Connection Status22',
            'upsrlm_connection_status23' => 'Upsrlm Connection Status23',
            'upsrlm_connection_status24' => 'Upsrlm Connection Status24',
            'upsrlm_connection_status30' => 'Upsrlm Connection Status30',
            'both_answered' => 'Both Answered',
            'from_unanswered' => 'From Unanswered',
            'talk_duration' => 'Talk Duration',
            'ivr_duration' => 'Ivr Duration',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    /**
     * Agent Detail
     */
    public function getAgentdetail()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'calling_agent_id']);
    }
}
