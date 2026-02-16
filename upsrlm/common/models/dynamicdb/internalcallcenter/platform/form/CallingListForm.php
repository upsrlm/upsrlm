<?php

namespace common\models\dynamicdb\internalcallcenter\platform\form;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\dynamicdb\internalcallcenter\platform\CallingList;

class CallingListForm extends \yii\base\Model
{

    public $log_id;
    public $calling_model;
    public $connection_status;
    public $call_status;
    public $call_quality;
    public $call_outcome;
    public $call_again;
    public $connection_status_option = [];
    public $call_status_option = [];
    public $call_quality_option = [];
    public $call_outcome_option = [];
    public $call_again_option = [];
    public $callHistorydataProvider;
    public $agent_call_received;
    public $agent_call_received_option = [1 => 'Yes', 2 => 'No'];
    public $default_call_scenario_id;
    public $calling_agent_id;
    public $caller_group_id;
    public $call_start_time;
    public $call_end_time;
    public $rishta_shg_member_id;
    public $cbo_shg_id;
    public $cbo_vo_id;
    public $member_mobile;
    public $member_role;
    public $member_name;
    public $member_user_id;
    public $scenario_form_id;
    public $scenario_form_file;
    public $action_validate_url;

    public function __construct($calling_model)
    {

        $this->calling_model = $calling_model;
        $this->log_id = $this->calling_model->id;
        $this->connection_status_option = \common\models\base\GenralModel::cloud_tel_connection_status_option();
        $this->call_status_option = \common\models\base\GenralModel::cloud_tel_call_status_option();
        $this->call_quality_option = \common\models\base\GenralModel::cloud_tel_call_quality_option();
        $this->call_outcome_option = \common\models\base\GenralModel::cloud_tel_call_outcome_option();
        $this->call_again_option = \common\models\base\GenralModel::cloud_tel_call_again_option();
        // $this->callHistorydataProvider = new \yii\data\ActiveDataProvider([
        //     'query' => CallingList::find()->where(['customer_number' => $this->calling_model->customer_number, 'cbo_shg_id' => $this->calling_model->cbo_shg_id, 'status' => 1])->andwhere(['!=', 'id', $this->calling_model->id]),
        //     'pagination' => ['pageSize' => 3],
        //     'sort' => [
        //         'defaultOrder' =>
        //         [
        //             'call_complete_date' => SORT_ASC
        //         ]
        //     ],
        // ]);

        $searchModel = new \common\models\dynamicdb\internalcallcenter\CloudTeleApiLogSearch();
        $searchModel->upsrlm_call_type = 1;
        $searchModel->customernumber = $this->calling_model->customer_number;
        $this->callHistorydataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 5, \common\models\base\GenralModel::select_cloud_tele_log_columns());
        $searchModel->upsrlm_connection_status_option = \common\models\base\GenralModel::cloud_tel_connection_status_option();
        $searchModel->upsrlm_call_status_option = \common\models\base\GenralModel::cloud_tel_call_status_option();
        $searchModel->api_call_status_option = \common\models\base\GenralModel::cloud_tel_api_call_status_option();
        $searchModel->api_status_code_option = \common\models\base\GenralModel::cloud_tel_api_status_code_option();
        $searchModel->upsrlm_call_scenario_option = \common\models\base\GenralModel::cloud_tel_call_scenario_option();
        $this->callHistorydataProvider->query->andwhere(['!=', 'id', $this->calling_model->api_call_log_id]);

        $this->agent_call_received = $this->calling_model->agent_call_received;
        $this->connection_status = $this->calling_model->connection_status;
        $this->call_status = $this->calling_model->call_status;
        $this->call_quality = $this->calling_model->call_quality;
        $this->call_outcome = $this->calling_model->call_outcome;
        $this->call_again = $this->calling_model->call_again;
        $this->default_call_scenario_id = $this->calling_model->default_call_scenario_id;
        $this->calling_agent_id = $this->calling_model->calling_agent_id;
        $this->caller_group_id = $this->calling_model->caller_group_id;
        $this->rishta_shg_member_id = $this->calling_model->rishta_shg_member_id;
        $this->cbo_shg_id = $this->calling_model->cbo_shg_id;
        $this->cbo_vo_id = $this->calling_model->cbo_vo_id;
        $this->member_mobile = $this->calling_model->member_mobile;
        $this->member_role = $this->calling_model->member_role;
        $this->member_name = $this->calling_model->member_name;
        $this->member_user_id = $this->calling_model->member_user_id;
        if ($this->calling_model->callscneraio) {
            $this->scenario_form_id = $this->calling_model->callscneraio->form_id;
            $this->scenario_form_file = $this->calling_model->callscneraio->scenario_form_file;
        }
    }

    public function rules()
    {
        return [
            [['agent_call_received'], 'required'],
            [['log_id'], 'required'],
            ['connection_status', 'required', 'when' => function ($model) {
                return $model->agent_call_received == 1;
            }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#agent_call_received').val() == '1';
            }"],
            ['call_status', 'required', 'when' => function ($model) {
                return $model->connection_status == \common\models\base\GenralModel::CONNECTION_STATUS_PHONE_PICKED;
            }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#connection_status').val() == '1';
            }"],
            [['agent_call_received', 'call_quality', 'call_outcome', 'call_again'], 'integer'],
            [['call_quality'], 'default', 'value' => 0],
            [['call_outcome'], 'default', 'value' => 0],
            [['call_again'], 'default', 'value' => 0],
            [['call_start_time', 'call_end_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'connection_status' => 'Connection status',
            'call_status' => 'Call status',
            'action_status' => 'Action',
            'smart_phone' => 'Smart Phone',
            'call_quality' => 'Call quality (कॉल गुणवत्ता)',
            'call_outcome' => 'Call outcome (कॉल परिणाम)',
            'call_again' => 'Call followup (कॉल फॉलोअप)',
        ];
    }

    /**
     * Run This after validate to Autosave these data
     *
     * @return void
     */
    public function aftervalidatesave()
    {
        $this->calling_model->agent_call_received = $this->agent_call_received;
        $this->calling_model->connection_status = $this->connection_status;
        $this->calling_model->call_status = $this->call_status;
        $this->calling_model->call_quality = $this->call_quality;
        $this->calling_model->call_outcome = $this->call_outcome;
        $this->calling_model->call_again = $this->call_again;
        $this->calling_model->save(false);

        $apilog = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::findOne($this->calling_model->api_call_log_id);
        if ($apilog != null) {
            $apilog->upsrlm_agent_call_received = $this->agent_call_received;
            $apilog->upsrlm_connection_status = $this->connection_status;
            $apilog->upsrlm_call_status = $this->call_status;
            $apilog->upsrlm_call_quality = $this->call_quality;
            $apilog->upsrlm_call_outcome = $this->call_outcome;
            $apilog->upsrlm_call_again = $this->call_again;
            $apilog->save();
        }
    }

    /**
     * initializeForm After Post Request
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->calling_model->agent_call_received = $this->agent_call_received;
        $this->calling_model->connection_status = $this->connection_status;
        $this->calling_model->call_status = $this->call_status;
        $this->calling_model->call_quality = $this->call_quality;
        $this->calling_model->call_outcome = $this->call_outcome;
        $this->calling_model->call_again = $this->call_again;
        $this->calling_model->call_start_time = $this->call_start_time;
        $this->calling_model->call_end_time = $this->call_end_time;
        $this->calling_model->call_duration = (strtotime($this->call_end_time) - strtotime($this->call_start_time));

        if ($this->agent_call_received == 1) {
            $this->calling_model->call_attempt = $this->calling_model->call_attempt + 1;
            if ($this->connection_status == \common\models\base\GenralModel::CONNECTION_STATUS_WRONG_NO_DOES_NOT_EXIST) {
                $this->calling_model->status = 1;
                $this->calling_model->call_complete_date = date('Y-m-d');
            } else {
                if ($this->call_outcome == 2) {
                    $this->calling_model->status = 1;
                    $this->calling_model->call_complete_date = date('Y-m-d');
                    $this->callfollowupagain(($this->calling_model->call_priority + 999));
                } else {
                    if ($this->connection_status == \common\models\base\GenralModel::CONNECTION_STATUS_PHONE_PICKED && $this->call_status == \common\models\base\GenralModel::CALL_STATUS_CALL_CONTINUED) {
                        $this->calling_model->status = 1;
                        $this->calling_model->call_complete_date = date('Y-m-d');
                    }
                    if (in_array($this->call_again, [1, 2, 3, 5])) {
                        $this->callfollowupagain();
                    }
                }
            }
        }
    }

    /**
     * Add New Data for This Call Again
     *
     * @return void
     */
    public function callfollowupagain($call_priority = null)
    {
        if ($this->calling_model->upsrlm_call_type == 2) {
            return true;
        } else {

            $newcall = new CallingList();
            $newcall->setAttributes([
                'rishta_shg_member_id' => $this->calling_model->rishta_shg_member_id,
                'customer_number' => $this->calling_model->customer_number,
                'calling_agent_number' => $this->calling_model->calling_agent_number,
                'calling_agent_id' => $this->calling_model->calling_agent_id,
                'caller_group_id' => $this->calling_model->caller_group_id,
                'call_generate_date' => date('Y-m-d'),
                'default_call_scenario_id' => $this->calling_model->default_call_scenario_id,
                'call_reason_id' => $this->calling_model->call_reason_id,
                'call_priority' => $this->calling_model->call_priority,
                'previous_calling_id' => $this->calling_model->id,
                'previous_call_log_id' => $this->calling_model->api_call_log_id,
                'call_attempt' => 0,
                'cbo_shg_id' => $this->calling_model->cbo_shg_id,
                'cbo_vo_id' => $this->calling_model->cbo_vo_id,
                'name_of_shg' => $this->calling_model->name_of_shg,
                'member_name' => $this->calling_model->member_name,
                'member_mobile' => $this->calling_model->member_mobile,
                'member_marital_status' => $this->calling_model->member_marital_status,
                'member_age' => $this->calling_model->member_age,
                'member_caste_category' => $this->calling_model->member_caste_category,
                'member_duration_of_membership' => $this->calling_model->member_duration_of_membership,
                'member_total_saving' => $this->calling_model->member_total_saving,
                'member_loan' => $this->calling_model->member_loan,
                'member_loan_count' => $this->calling_model->member_loan_count,
                'member_loan_amount' => $this->calling_model->member_loan_amount,
                'member_loan_date' => $this->calling_model->member_loan_date,
                'member_mcp_status' => $this->calling_model->member_mcp_status,
                'member_office_bearer' => $this->calling_model->member_office_bearer,
                'member_role' => $this->calling_model->member_role,
                'member_bank_account' => $this->calling_model->member_bank_account,
                'member_relative_in_shg' => $this->calling_model->member_relative_in_shg,
                'member_no_of_relative' => $this->calling_model->member_no_of_relative,
                'member_current_member' => $this->calling_model->member_current_member,
                'member_user_id' => $this->calling_model->member_user_id,
                'member_suggest_wada_sakhi' => $this->calling_model->member_suggest_wada_sakhi,
                'member_status' => $this->calling_model->member_status,
                'member_district_code' => $this->calling_model->member_district_code,
                'member_district_name' => $this->calling_model->member_district_name,
                'member_block_code' => $this->calling_model->member_block_code,
                'member_block_name' => $this->calling_model->member_block_name,
                'member_gram_panchayat_code' => $this->calling_model->member_gram_panchayat_code,
                'member_gram_panchayat_name' => $this->calling_model->member_gram_panchayat_name,
                'member_village_code' => $this->calling_model->member_village_code,
                'member_village_name' => $this->calling_model->member_village_name,
                'member_wada_shg' => $this->calling_model->member_wada_shg,
                'status' => 0
            ]);
            $newcall->call_schedule_time = date('h:i:s');

            if ($call_priority) {
                $newcall->call_schedule_date = date('Y-m-d');
                $newcall->call_priority = $call_priority;
            } else {
                $newcall->call_schedule_date = date('Y-m-d', strtotime("+1 days"));
                if ($this->call_again == 1 || $this->call_again == 2 || $this->call_again == 5) {
                    $newcall->call_schedule_date = date('Y-m-d');
                    if ($this->call_again == 1) {
                        // Increase 2 Hours From
                        $newcall->call_schedule_time = date('h:i:s', strtotime('+2 hours'));
                        $newcall->call_priority = 1;
                    } else if ($this->call_again == 2) {
                        // Increase 6 Hourse from Now
                        $newcall->call_schedule_time = date('h:i:s', strtotime('+6 hours'));
                        $newcall->call_priority = 1;
                    } else if ($this->call_again == 5) {
                        // Increase 15 Minute from Now
                        $newcall->call_schedule_time = date('h:i:s', strtotime('+15 minutes'));
                        $newcall->call_priority = 1;
                    }
                }
            }


            return $newcall->save();
        }
    }
}
