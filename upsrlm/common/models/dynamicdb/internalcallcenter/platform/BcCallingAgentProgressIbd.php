<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use Yii;

/**
 * This is the model class for table "bc_calling_agent_progress_ibd".
 *
 * @property int $id
 * @property string|null $calling_agent_name
 * @property int $calling_agent_id
 * @property int|null $calling_agent_role
 * @property string $calling_date
 * @property string|null $start_time
 * @property string|null $end_time
 * @property int $work_hour work hours in seconds
 * @property int $ibd_call Number of Times Call APi get Success
 * @property int $achieve
 * @property int $agent_call_recived Number of Times Agent Mark they recivied Call
 * @property int $both_answered
 * @property int $from_unanswered agent not picked call
 * @property int $talk_duration talk duration in seconds
 * @property int $ivr_duration ivr duration in seconds
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class BcCallingAgentProgressIbd extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'bc_calling_agent_progress_ibd';
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
            [['calling_agent_id', 'calling_date'], 'required'],
            [['calling_agent_id', 'calling_agent_role', 'work_hour', 'ibd_call', 'achieve', 'agent_call_recived', 'both_answered', 'from_unanswered', 'talk_duration', 'ivr_duration', 'created_at', 'updated_at', 'status'], 'integer'],
            [['calling_date', 'start_time', 'end_time'], 'safe'],
            [['calling_agent_name'], 'string', 'max' => 255],
            [['calling_agent_id', 'calling_date'], 'unique', 'targetAttribute' => ['calling_agent_id', 'calling_date']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'calling_agent_name' => 'Calling Agent Name',
            'calling_agent_id' => 'Calling Agent ID',
            'calling_agent_role' => 'Calling Agent Role',
            'calling_date' => 'Calling Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'work_hour' => 'Work Hour',
            'ibd_call' => 'Ibd Call',
            'achieve' => 'Achieve',
            'agent_call_recived' => 'Agent Call Recived',
            'both_answered' => 'Both Answered',
            'from_unanswered' => 'From Unanswered',
            'talk_duration' => 'Talk Duration',
            'ivr_duration' => 'Ivr Duration',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

}
