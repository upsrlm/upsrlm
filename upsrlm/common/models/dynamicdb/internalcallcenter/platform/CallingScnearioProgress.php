<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use Yii;

/**
 * This is the model class for table "calling_scneario_progress".
 *
 * @property int $id
 * @property int $call_scenario_id
 * @property string $calling_date
 * @property string|null $start_time
 * @property string|null $end_time
 * @property int $total_call
 * @property int $ctc_click Number of Times Call APi get Success
 * @property int $ibd_call
 * @property int $success_call
 * @property int $agent_call_recived Number of Times Agent Mark they recivied Call
 * @property int $upsrlm_connection_status1 Phone picked
 * @property int $upsrlm_connection_status21 Bell Ring
 * @property int $upsrlm_connection_status22 Busy
 * @property int $upsrlm_connection_status23 unreacheble
 * @property int $upsrlm_connection_status24 Mobile switch off
 * @property int $upsrlm_connection_status30 Wrong No does not exist
 * @property int $both_answered
 * @property int $from_unanswered agent not picked call
 * @property int $talk_duration talk duration in seconds
 * @property int $ivr_duration ivr duration in seconds
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int $status
 */
class CallingScnearioProgress extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calling_scneario_progress';
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
            [['call_scenario_id', 'calling_date'], 'required'],
            [['call_scenario_id', 'work_hour', 'total_call', 'ctc_click', 'ibd_call', 'success_call', 'agent_call_recived', 'upsrlm_connection_status1', 'upsrlm_connection_status21', 'upsrlm_connection_status22', 'upsrlm_connection_status23', 'upsrlm_connection_status24', 'upsrlm_connection_status30', 'both_answered', 'from_unanswered', 'talk_duration', 'ivr_duration', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['calling_date', 'start_time', 'end_time'], 'safe'],
            [['call_scenario_id', 'calling_date'], 'unique', 'targetAttribute' => ['call_scenario_id', 'calling_date']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'call_scenario_id' => 'Call Scenario ID',
            'calling_date' => 'Calling Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'total_call' => 'Total Call',
            'ctc_click' => 'Ctc Click',
            'ibd_call' => 'Ibd Call',
            'success_call' => 'Success Call',
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
     * Get Scneario Details
     *
     * @return void
     */
    public function getScneario()
    {
        return $this->hasOne(\common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterCallScenario::className(), ['id' => 'call_scenario_id']);
    }
}
