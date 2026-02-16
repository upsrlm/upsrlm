<?php

namespace common\models\dynamicdb\internalcallcenter\platform\form;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\dynamicdb\internalcallcenter\platform\CallingList;

class DialerForm extends \yii\base\Model
{

    public $log_id;
    public $customer_number;
    public $call_start_time;
    public $call_end_time;
    public $default_call_scenario_id = 2001;
    public $calling_agent_id;
    public $calling_agent_number;
    public $dialer_model;

    public function __construct($dialer_model = null)
    {

        $this->dialer_model = Yii::createObject([
            'class' => CallingList::className()
        ]);
        if ($dialer_model != null) {
            $this->qcuser_model = $dialer_model;
            $this->log_id = $this->dialer_model->id;
        }
    }

    public function rules()
    {
        return [
            [['customer_number'], 'required'],
            ['customer_number', 'integer'],
            ['customer_number', 'string', 'max' => 10, 'min' => 10],
            [['default_call_scenario_id'], 'integer'],
            [['call_start_time', 'call_end_time'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customer_number' => 'Mobile Number',
        ];
    }


    /**
     * initializeForm After Post Request
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->dialer_model->customer_number = $this->customer_number;
        $this->dialer_model->calling_agent_id = $this->calling_agent_id;
        $this->dialer_model->calling_agent_number = $this->calling_agent_number;
        $this->dialer_model->call_generate_date = date("Y-m-d");
        $this->dialer_model->call_schedule_date = date("Y-m-d");
        $this->dialer_model->call_schedule_time = date("H:i:s");
        $this->dialer_model->default_call_scenario_id = $this->default_call_scenario_id;
        $this->dialer_model->call_reason_id = 1; // Direct Call
        $this->dialer_model->call_start_time = $this->call_start_time;
        $this->dialer_model->call_end_time = $this->call_end_time;
        $this->dialer_model->call_duration = (strtotime($this->call_end_time) - strtotime($this->call_start_time));
        $this->dialer_model->status = 1;
        $this->dialer_model->agent_call_received = 1;
        $this->dialer_model->connection_status = 1;
        $this->dialer_model->caller_group_id = 2;
        $this->dialer_model->rishta_shg_member_id = 0;
        $this->dialer_model->caller_group_id = 2;

        $member_type = 0; // None
        $user = \common\models\User::findOne(['username' => $this->customer_number]);

        $member = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['mobile' => $this->customer_number, 'status' => 1])->one();
        if ($member != null) {
            $member_type = 2; // SHG
        }

        if ($member_type == 2) {
            $this->dialer_model->rishta_shg_member_id = $member->id;
            $this->dialer_model->cbo_shg_id = $member->cbo_shg_id;
            $this->dialer_model->name_of_shg = $member->cboshg->name_of_shg;
            $this->dialer_model->member_name = $member->name;
            $this->dialer_model->member_mobile = $member->mobile;
            $this->dialer_model->member_marital_status = $member->marital_status;
            $this->dialer_model->member_age = $member->age;
            $this->dialer_model->member_caste_category = $member->caste_category;
            $this->dialer_model->member_duration_of_membership = $member->duration_of_membership;
            $this->dialer_model->member_total_saving = $member->total_saving;
            $this->dialer_model->member_loan = $member->loan;
            $this->dialer_model->member_loan_count = $member->loan_count;
            $this->dialer_model->member_loan_amount = $member->loan_amount;
            $this->dialer_model->member_role = $member->role;
            $this->dialer_model->member_relative_in_shg = $member->relative_in_shg;
            $this->dialer_model->member_no_of_relative = $member->no_of_relative;
            $this->dialer_model->member_current_member = $member->current_member;
            $this->dialer_model->member_user_id = $member->user_id;
            $this->dialer_model->member_status = $member->status;
            $this->dialer_model->member_district_code = $member->cboshg->district_code;
            $this->dialer_model->member_district_name = $member->cboshg->district_name;
            $this->dialer_model->member_block_code = $member->cboshg->block_code;
            $this->dialer_model->member_block_name = $member->cboshg->block_name;
            $this->dialer_model->member_gram_panchayat_code = $member->cboshg->gram_panchayat_code;
            $this->dialer_model->member_gram_panchayat_name = $member->cboshg->gram_panchayat_name;
            $this->dialer_model->member_village_code = $member->cboshg->village_code;
            $this->dialer_model->member_village_name = $member->cboshg->village_name;
            $this->dialer_model->member_wada_shg = $member->cboshg->wada_shg;
        } else if ($member_type == 0) {
            if ($user) {
                $this->dialer_model->member_user_id = $user->id;
                $this->dialer_model->member_role = $user->role;
                $this->dialer_model->member_name = $user->username;
            }
        }
    }
}
