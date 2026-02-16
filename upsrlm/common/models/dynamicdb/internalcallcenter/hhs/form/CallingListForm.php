<?php

namespace common\models\dynamicdb\internalcallcenter\hhs\form;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\dynamicdb\internalcallcenter\hhs\HhsCallingLog;
use common\models\dynamicdb\ultrapoor\nfsa\NfsaBaseSurvey;

class CallingListForm extends \yii\base\Model {

    public $log_id;
    public $calling_model;
    public $connection_status;
    public $call_status;
    public $call_quality;
    public $call_outcome;
    public $call_again;
    public $alt_mobile_no;
    public $comment;
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
    public $household_member_id;
    public $cbo_shg_id;
    public $hhs_name;
    public $user_id;
    public $user_role;
    public $pin;
    public $user_login;
    public $scenario_form_id;
    public $scenario_form_file;
    public $action_validate_url;
    public $hhs_model;

    public function __construct($calling_model) {

        $this->calling_model = $calling_model;
        $this->log_id = $this->calling_model->id;
        $this->connection_status_option = \common\models\base\GenralModel::cloud_tel_connection_status_option();
        $this->call_status_option = \common\models\base\GenralModel::cloud_tel_call_status_option();
        $this->call_quality_option = \common\models\base\GenralModel::cloud_tel_call_quality_option();
        $this->call_outcome_option = \common\models\base\GenralModel::cloud_tel_call_outcome_option();
        $this->call_again_option = \common\models\base\GenralModel::cloud_tel_call_again_option();
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
        $this->household_member_id = $this->calling_model->household_member_id;
        $this->cbo_shg_id = $this->calling_model->cbo_shg_id;
        $this->hhs_name = $this->calling_model->hhs_name;
        $this->user_id = $this->calling_model->user_id;
        $this->user_role = $this->calling_model->user_role;
        $this->pin = $this->calling_model->pin;
        $this->user_login = $this->calling_model->user_login;
        $this->hhs_model = NfsaBaseSurvey::findOne($this->household_member_id);
    }

    public function rules() {
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
            [['comment'], 'string', 'max' => 1000],
            [['comment'], 'safe'],
            [['alt_mobile_no'], 'safe'],
            [['alt_mobile_no'], \common\validators\InmobilenoValidator::className()],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'connection_status' => 'Connection status',
            'call_status' => 'Call status',
            'action_status' => 'Action',
            'smart_phone' => 'Smart Phone',
            'call_quality' => 'Call quality (कॉल गुणवत्ता)',
            'call_outcome' => 'Call outcome (कॉल परिणाम)',
            'call_again' => 'Call followup (कॉल फॉलोअप)',
            'alt_mobile_no' => 'Alternate Mobile Number'
        ];
    }

    /**
     * Run This after validate to Autosave these data
     *
     * @return void
     */
    public function aftervalidatesave() {
        $this->calling_model->agent_call_received = $this->agent_call_received;
        $this->calling_model->connection_status = $this->connection_status;
        $this->calling_model->call_status = $this->call_status;
        $this->calling_model->call_quality = $this->call_quality;
        $this->calling_model->call_outcome = $this->call_outcome;
        $this->calling_model->call_again = $this->call_again;
        $this->calling_model->comment = $this->comment;
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
        if ($this->alt_mobile_no and preg_match('/^[6-9]\d{9}$/', $this->alt_mobile_no)) {
            if ($this->hhs_model != null) {
                $this->hhs_model->alt_mobile_no = $this->alt_mobile_no;

                $this->hhs_model->action_type = NfsaBaseSurvey::ACTION_TYPE_ALT_MOBILE_NO;
                $this->hhs_model->save();
            }
        }
    }

    /**
     * initializeForm After Post Request
     *
     * @return void
     */
    public function initializeForm() {
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
                } else {
                    if ($this->connection_status == \common\models\base\GenralModel::CONNECTION_STATUS_PHONE_PICKED && $this->call_status == \common\models\base\GenralModel::CALL_STATUS_CALL_CONTINUED) {
                        $this->calling_model->status = 1;
                        $this->calling_model->call_complete_date = date('Y-m-d');
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
}
