<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use Yii;

/**
 * This is the model class for table "calling_list".
 *
 * @property int $id
 * @property int|null $rishta_shg_member_id
 * @property string|null $customer_number customer number for make a call
 * @property string|null $calling_agent_number this number will be fill when agent make a call
 * @property int|null $calling_agent_id caller user id or caller id
 * @property int|null $caller_group_id caller group id internal/external
 * @property string|null $call_generate_date when this entry is generated
 * @property string|null $call_schedule_date Call schedule date
 * @property string|null $call_schedule_time Call schedule date time if we know
 * @property int|null $default_call_scenario_id enter id of call scnerio if call scnerio is already fix
 * @property int|null $call_reason_id reason for call come from call reason master 
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
 * @property int|null $cbo_shg_id
 * @property string|null $name_of_shg
 * @property string|null $member_name
 * @property string|null $member_mobile
 * @property int|null $member_marital_status
 * @property int|null $member_age
 * @property int|null $member_caste_category
 * @property int|null $member_duration_of_membership
 * @property int|null $member_total_saving
 * @property int|null $member_loan
 * @property int|null $member_loan_count
 * @property string|null $member_loan_amount
 * @property int|null $member_loan_date
 * @property int|null $member_mcp_status
 * @property int|null $member_office_bearer
 * @property int|null $member_role
 * @property int|null $member_bank_account
 * @property int|null $member_relative_in_shg
 * @property int|null $member_no_of_relative
 * @property int|null $member_current_member
 * @property int|null $member_user_id
 * @property int|null $member_suggest_wada_sakhi
 * @property int|null $member_status
 * @property int|null $member_district_code
 * @property string|null $member_district_name
 * @property int|null $member_block_code
 * @property string|null $member_block_name
 * @property int|null $member_gram_panchayat_code
 * @property string|null $member_gram_panchayat_name
 * @property int|null $member_village_code
 * @property string|null $member_village_name
 * @property int|null $member_wada_shg 0=not wada gp ,1 =wada gp
 * @property int|null $status 1=call complete,0=call pending
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 *
 * @property CloudTeleMasterCallReason $callReason
 * @property CallingScenarioList[] $callingScenarioLists
 * @property CallingScenarioUserVerification[] $callingScenarioUserVerifications
 * @property CloudTeleMasterCallScenario $defaultCallScenario
 */


class CallingList extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calling_list';
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
            [['rishta_shg_member_id', 'calling_agent_id', 'caller_group_id', 'default_call_scenario_id', 'call_reason_id', 'call_priority', 'call_duration', 'agent_call_received', 'connection_status', 'call_status', 'call_quality', 'call_outcome', 'call_again', 'previous_calling_id', 'previous_call_log_id', 'api_call_log_id', 'call_attempt', 'cbo_shg_id', 'member_marital_status', 'member_age', 'member_caste_category', 'member_duration_of_membership', 'member_total_saving', 'member_loan', 'member_loan_count', 'member_loan_date', 'member_mcp_status', 'member_office_bearer', 'member_role', 'member_bank_account', 'member_relative_in_shg', 'member_no_of_relative', 'member_current_member', 'member_user_id', 'member_suggest_wada_sakhi', 'member_status', 'member_district_code', 'member_block_code', 'member_gram_panchayat_code', 'member_village_code', 'member_wada_shg', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'ctc_click_count'], 'integer'],
            [['call_generate_date', 'call_schedule_date', 'call_schedule_time', 'call_start_time', 'call_end_time', 'call_complete_date'], 'safe'],
            [['customer_number', 'calling_agent_number'], 'string', 'max' => 13],
            [['refrence_page'], 'string', 'max' => 50],
            [['callid'], 'string', 'max' => 1000],
            [['name_of_shg', 'member_name', 'member_loan_amount'], 'string', 'max' => 150],
            [['member_mobile'], 'string', 'max' => 15],
            [['member_district_name', 'member_block_name'], 'string', 'max' => 30],
            [['member_gram_panchayat_name', 'member_village_name'], 'string', 'max' => 125],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rishta_shg_member_id' => 'Rishta Shg Member ID',
            'customer_number' => 'Customer Number',
            'calling_agent_number' => 'Calling Agent Number',
            'calling_agent_id' => 'Calling Agent ID',
            'caller_group_id' => 'Caller Group ID',
            'call_generate_date' => 'Call Generate Date',
            'call_schedule_date' => 'Call Schedule Date',
            'call_schedule_time' => 'Call Schedule Time',
            'default_call_scenario_id' => 'Default Call Scenario ID',
            'call_reason_id' => 'Call Reason ID',
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
            'cbo_shg_id' => 'Cbo Shg ID',
            'name_of_shg' => 'Name Of Shg',
            'member_name' => 'Member Name',
            'member_mobile' => 'Member Mobile',
            'member_marital_status' => 'Member Marital Status',
            'member_age' => 'Member Age',
            'member_caste_category' => 'Member Caste Category',
            'member_duration_of_membership' => 'Member Duration Of Membership',
            'member_total_saving' => 'Member Total Saving',
            'member_loan' => 'Member Loan',
            'member_loan_count' => 'Member Loan Count',
            'member_loan_amount' => 'Member Loan Amount',
            'member_loan_date' => 'Member Loan Date',
            'member_mcp_status' => 'Member Mcp Status',
            'member_office_bearer' => 'Member Office Bearer',
            'member_role' => 'Member Role',
            'member_bank_account' => 'Member Bank Account',
            'member_relative_in_shg' => 'Member Relative In Shg',
            'member_no_of_relative' => 'Member No Of Relative',
            'member_current_member' => 'Member Current Member',
            'member_user_id' => 'Member User ID',
            'member_suggest_wada_sakhi' => 'Member Suggest Wada Sakhi',
            'member_status' => 'Member Status',
            'member_district_code' => 'Member District Code',
            'member_district_name' => 'Member District Name',
            'member_block_code' => 'Member Block Code',
            'member_block_name' => 'Member Block Name',
            'member_gram_panchayat_code' => 'Member Gram Panchayat Code',
            'member_gram_panchayat_name' => 'Member Gram Panchayat Name',
            'member_village_code' => 'Member Village Code',
            'member_village_name' => 'Member Village Name',
            'member_wada_shg' => 'Member Wada Shg',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',

        ];
    }


    public function getShgrole()
    {
        return $this->hasOne(\common\models\dynamicdb\cbo_detail\master\CboMasterMemberDesignation::className(), ['id' => 'member_role']);
    }

    /**
     * Rishta SHG Member Detail
     *
     * @return void
     */
    public function getRishtashgmemberdetail()
    {
        return $this->hasOne(\common\models\dynamicdb\cbo_detail\RishtaShgMember::className(), ['id' => 'rishta_shg_member_id']);
    }

    public function getAgentdetail()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'calling_agent_id']);
    }

    /**
     * Call Reason
     *
     * @return void
     */
    public function getCallreason()
    {
        return $this->hasOne(\common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterCallReason::className(), ['id' => 'call_reason_id']);
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

    public function getCallingScenarioLists()
    {
        return $this->hasMany(CallingScenarioList::className(), ['calling_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'member_user_id']);
    }
}
