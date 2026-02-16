<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use Yii;

/**
 * This is the model class for table "ultra_poor_calling_log".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $name
 * @property int|null $role
 * @property string|null $district_name
 * @property string|null $block_name
 * @property string|null $gram_panchayat_name
 * @property string|null $customer_number customer number for make a call
 * @property string|null $calling_agent_number this number will be fill when agent make a call
 * @property int|null $calling_agent_id caller user id or caller id
 * @property int|null $caller_group_id caller group id internal/external
 * @property string|null $call_generate_date when this entry is generated
 * @property string|null $call_schedule_date Call schedule date
 * @property string|null $call_schedule_time Call schedule date time if we know
 * @property int|null $default_call_scenario_id enter id of call scnerio if call scnerio is already fix
 * @property int|null $call_scenario reason for call come from call reason master 
 * @property int|null $call_priority 1=normal,2=medium,3=high
 * @property string|null $call_start_time when user click for ctc
 * @property string|null $call_end_time when final call data submit
 * @property int|null $call_duration call duration can be calculate based on call start time and  call end time
 * @property int|null $agent_call_received
 * @property int|null $connection_status
 * @property int|null $call_status this should be filled by a agent ,  what is status of this  call , continue , not picked, wrong number etc
 * @property int|null $call_quality
 * @property int|null $call_outcome
 * @property int|null $call_again
 * @property string|null $call_complete_date when call is completed
 * @property int|null $previous_calling_id enter previous calling id if customer says call me next day
 * @property int|null $previous_call_log_id if this call generated from logs then enter previous call log id here
 * @property int|null $api_call_log_id call log id for this call
 * @property string|null $callid callid generated from sarv api
 * @property int|null $call_attempt this will be increased on every call attempt
 * @property int $ctc_click_count
 * @property int $upsrlm_call_type
 * @property int $ibd_call_count
 * @property string|null $ibd_request_datetime
 * @property int $achievement
 * @property int|null $status 1=call complete,0=call pending
 * @property string|null $refrence_page
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class UltraPoorCallingLog extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ultra_poor_calling_log';
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
            [['user_id', 'role', 'calling_agent_id', 'caller_group_id', 'default_call_scenario_id', 'call_scenario', 'call_priority', 'call_duration', 'agent_call_received', 'connection_status', 'call_status', 'call_quality', 'call_outcome', 'call_again', 'previous_calling_id', 'previous_call_log_id', 'api_call_log_id', 'call_attempt', 'ctc_click_count', 'upsrlm_call_type', 'ibd_call_count', 'achievement', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['call_generate_date', 'call_schedule_date', 'call_schedule_time', 'call_start_time', 'call_end_time', 'call_complete_date', 'ibd_request_datetime'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['district_name', 'block_name', 'gram_panchayat_name'], 'string', 'max' => 500],
            [['customer_number', 'calling_agent_number'], 'string', 'max' => 13],
            [['callid'], 'string', 'max' => 1000],
            [['refrence_page'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'role' => 'Role',
            'district_name' => 'District Name',
            'block_name' => 'Block Name',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'customer_number' => 'Customer Number',
            'calling_agent_number' => 'Calling Agent Number',
            'calling_agent_id' => 'Calling Agent ID',
            'caller_group_id' => 'Caller Group ID',
            'call_generate_date' => 'Call Generate Date',
            'call_schedule_date' => 'Call Schedule Date',
            'call_schedule_time' => 'Call Schedule Time',
            'default_call_scenario_id' => 'Default Call Scenario ID',
            'call_scenario' => 'Call Scenario',
            'call_priority' => 'Call Priority',
            'call_start_time' => 'Call Start Time',
            'call_end_time' => 'Call End Time',
            'call_duration' => 'Call Duration',
            'agent_call_received' => 'Agent Call Received',
            'connection_status' => 'Connection Status',
            'call_status' => 'Call Status',
            'call_quality' => 'Call Quality',
            'call_outcome' => 'Call Outcome',
            'call_again' => 'Call Again',
            'call_complete_date' => 'Call Complete Date',
            'previous_calling_id' => 'Previous Calling ID',
            'previous_call_log_id' => 'Previous Call Log ID',
            'api_call_log_id' => 'Api Call Log ID',
            'callid' => 'Callid',
            'call_attempt' => 'Call Attempt',
            'ctc_click_count' => 'Ctc Click Count',
            'upsrlm_call_type' => 'Upsrlm Call Type',
            'ibd_call_count' => 'Ibd Call Count',
            'ibd_request_datetime' => 'Ibd Request Datetime',
            'achievement' => 'Achievement',
            'status' => 'Status',
            'refrence_page' => 'Refrence Page',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
    

    public function getAgentdetail()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'calling_agent_id']);
    }

    

    /**
     * Call Scneraio
     *
     * @return void
     */
    public function getCallscneraio()
    {
        return $this->hasOne(\common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterCallScenario::className(), ['id' => 'default_call_scenario_id']);
    }

    public function getCloudteleapilog()
    {
        return $this->hasOne(\common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::className(), ['id' => 'api_call_log_id']);
    }

    public function getCloudteleapilogcallid()
    {
        return $this->hasOne(\common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::className(), ['callid' => 'callid']);
    }

    public function getCallstatus()
    {
        return $this->hasOne(\common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterCallStatus::className(), ['id' => 'call_status']);
    }

    public function getConnectionstatus()
    {
        return $this->hasOne(\common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterConnectionStatus::className(), ['id' => 'connection_status']);
    }

    public function getCallqullity()
    {
        return $this->hasOne(\common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterCallQuality::className(), ['id' => 'call_quality']);
    }

    public function getCalloutcome()
    {
        return $this->hasOne(\common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterCallOutcome::className(), ['id' => 'call_outcome']);
    }

    public function getCallagain()
    {
        return $this->hasOne(\common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterCallAgain::className(), ['id' => 'call_again']);
    }

   

    public function getUser()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }
}
