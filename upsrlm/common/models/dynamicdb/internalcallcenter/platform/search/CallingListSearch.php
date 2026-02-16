<?php

namespace common\models\dynamicdb\internalcallcenter\platform\search;

use common\models\dynamicdb\internalcallcenter\platform\CallingList;
use common\models\dynamicdb\internalcallcenter\platform\MasterCallScenario;
use common\models\dynamicdb\internalcallcenter\platform\MasterCallReason;
use Yii;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiCall;
use \yii\helpers\ArrayHelper;

/**
 * This is the search model class for table "calling_list".
 *
 * @property int $id
 * @property string|null $customer_number customer number for make a call
 * @property string|null $calling_agent_number this number will be fill when agent make a call
 * @property int|null $calling_agent_id caller user id or caller id
 * @property int|null $caller_group_id caller group id internal/external
 * @property int|null $call_reason_id reason for call come from call reason master 
 * @property string|null $call_start_time when user click for ctc
 * @property string|null $call_end_time when final call data submit
 * @property int|null $call_status this should be filled by a agent ,  what is status of this  call , continue , not picked, wrong number etc
 * @property int|null $call_duration call duration can be calculate based on call start time and  call end time
 * @property string|null $call_generate_date when this entry is generated
 * @property int|null $call_priority 1=normal,2=medium,3=high
 * @property string|null $call_schedule_date Call schedule date
 * @property string|null $call_schedule_time Call schedule date time if we know
 * @property string|null $call_complete_date when call is completed
 * @property int|null $previous_calling_id enter previous calling id if customer says call me next day
 * @property int|null $previous_call_log_id if this call generated from logs then enter previous call log id here
 * @property int|null $api_call_log_id call log id for this call
 * @property string|null $callid callid generated from sarv api
 * @property int|null $call_attempt this will be increased on every call attempt
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class CallingListSearch extends CallingList
{

    public $callreasons = [];
    public $defaulcallscenarios = [];
    public $callergroups = [1 => 'Internal', 2 => 'DBT'];
    public $api_request_datetime;
    public $searchfortoday = null;
    public $upsrlm_user_role;

    public function __construct()
    {
        $this->api_request_datetime = date('Y-m-d');
        $this->callreasons = ArrayHelper::map(\common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterCallReason::find()->where(['status' => 1])->all(), 'id', 'reason');
        $this->defaulcallscenarios = ArrayHelper::map(\common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterCallScenario::find()->where(['status' => 1])->all(), 'id', 'call_scenario');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_number', 'calling_agent_id', 'caller_group_id', 'call_reason_id', 'default_call_scenario_id', 'call_start_time', 'call_end_time', 'call_status', 'call_duration', 'call_priority', 'call_generate_date', 'call_priority', 'call_schedule_date', 'call_schedule_time', 'call_complete_date', 'previous_calling_id', 'previous_call_log_id', 'api_call_log_id', 'callid', 'call_attempt', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'api_request_datetime', 'ctc_click_count'], 'safe'],
            [['upsrlm_user_role', 'searchfortoday'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return \yii\base\Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CallingList::find()->where("`call_priority` IS NULL or `call_priority`='0'");
        $this->load($params);

        // add conditions that should always apply here

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 30],
            'sort' => [
                'defaultOrder' =>
                [
                    'call_schedule_date' => SORT_ASC,
                    'call_schedule_time' => SORT_ASC,
                    'call_attempt' => SORT_ASC
                ]
            ],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $this->basicquery($query);

        $query->andFilterWhere(['like', 'callid', $this->callid]);

        return $dataProvider;
    }

    /**
     * Call priority Search
     *
     * @param [type] $params
     * @return void
     */
    public function prioritysearch($params)
    {
        $query = CallingList::find()->where("`call_priority` IS NOT NULL and `call_priority`>'0'");
        $this->load($params);

        // add conditions that should always apply here

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 30],
            'sort' => [
                'defaultOrder' =>
                [
                    'call_priority' => SORT_DESC,
                    'call_schedule_date' => SORT_ASC,
                    'call_schedule_time' => SORT_ASC,
                    'ctc_click_count' => SORT_ASC,
                    'call_attempt' => SORT_ASC
                ]
            ],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $this->basicquery($query);

        $query->andFilterWhere(['like', 'callid', $this->callid]);

        return $dataProvider;
    }

    /**
     * IBD Call Search 
     *
     * @param [type] $params
     * @return void
     */
    public function ibdsearch($params)
    {
        $query = CallingList::find()->where([CallingList::getTableSchema()->fullName . '.upsrlm_call_type' => 2]);
        $this->load($params);

        // add conditions that should always apply here

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 30],
            'sort' => [
                'defaultOrder' =>
                [
                    'call_schedule_date' => SORT_ASC,
                    'ibd_request_datetime' => SORT_DESC,
                ]
            ],
        ]);

        // if (!$this->validate()) {
        //     // uncomment the following line if you do not want to return any records when validation fails
        //     // $query->where('0=1');
        //     return $dataProvider;
        // }
        // grid filtering conditions
        $this->basicquery($query);

        $query->joinWith(['cloudteleapilogcallid' => function ($q) {
            $q->where(\common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::getTableSchema()->fullName . '.`full_response` IS NULL');
        }]);

        return $dataProvider;
    }

    public function ibdsearch1()
    {
        $query = CallingList::find()->where([CallingList::getTableSchema()->fullName . '.upsrlm_call_type' => 2]);
        // $this->load($params);
        // add conditions that should always apply here

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 30],
            'sort' => [
                'defaultOrder' =>
                [
                    'call_schedule_date' => SORT_ASC,
                    'ibd_request_datetime' => SORT_DESC,
                ]
            ],
        ]);
        $query->andWhere(['status' => 0, 'agent_call_received' => 0]);

        $query->andFilterWhere([
            CallingList::getTableSchema()->fullName . '.customer_number' => $this->customer_number,
            CallingList::getTableSchema()->fullName . '.calling_agent_number' => $this->calling_agent_number,
            CallingList::getTableSchema()->fullName . '.calling_agent_id' => $this->calling_agent_id,
            CallingList::getTableSchema()->fullName . '.caller_group_id' => $this->caller_group_id,
            CallingList::getTableSchema()->fullName . '.call_reason_id' => $this->call_reason_id,
            CallingList::getTableSchema()->fullName . '.default_call_scenario_id' => $this->default_call_scenario_id,
            CallingList::getTableSchema()->fullName . '.call_start_time' => $this->call_start_time,
            CallingList::getTableSchema()->fullName . '.call_end_time' => $this->call_end_time,
            CallingList::getTableSchema()->fullName . '.call_status' => $this->call_status,
            CallingList::getTableSchema()->fullName . '.call_duration' => $this->call_duration,
            CallingList::getTableSchema()->fullName . '.call_generate_date' => $this->call_generate_date,
            CallingList::getTableSchema()->fullName . '.call_priority' => $this->call_priority,
            CallingList::getTableSchema()->fullName . '.call_schedule_date' => $this->call_schedule_date,
            CallingList::getTableSchema()->fullName . '.call_schedule_time' => $this->call_schedule_time,
            CallingList::getTableSchema()->fullName . '.call_complete_date' => $this->call_complete_date,
            CallingList::getTableSchema()->fullName . '.previous_calling_id' => $this->previous_calling_id,
            CallingList::getTableSchema()->fullName . '.previous_call_log_id' => $this->previous_call_log_id,
            CallingList::getTableSchema()->fullName . '.api_call_log_id' => $this->api_call_log_id,
            CallingList::getTableSchema()->fullName . '.call_attempt' => $this->call_attempt,
            CallingList::getTableSchema()->fullName . '.status' => $this->status,
        ]);
        $query->orderBy([CallingList::getTableSchema()->fullName . '.call_schedule_date' => SORT_ASC]);
        $query->orderBy([CallingList::getTableSchema()->fullName . '.ibd_request_datetime' => SORT_DESC]);

        $query->joinWith(['cloudteleapilogcallid' => function ($q) {
            $q->where(\common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::getTableSchema()->fullName . '.`full_response` IS NULL');
        }]);

        $query->limit(1);
        return $query->one();
    }

    /**
     * Agent data Search
     *
     * @param [type] $params
     * @return void
     */
    public function agentsearch($params)
    {
        $query = CallingList::find();
        $this->load($params);
        // grid filtering conditions
        $this->basicquery($query);
        if ($this->searchfortoday) {
            $query->andWhere(['call_complete_date' => date('Y-m-d')]);
        }
        $query->andWhere(['!=', 'calling_agent_id', 0]);
        $query->select(['calling_agent_id', 'caller_group_id']);
        $query->orderBy('caller_group_id desc');
        return $query->distinct()->all();
    }

    public function agentsearchtoday($params)
    {
        $query = \common\models\dynamicdb\internalcallcenter\CloudTeleApiCall::find();
        $this->load($params);
        $query->andFilterWhere(['>=', 'created_at', strtotime($this->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($this->api_request_datetime . ' 23:59:59')]);
        $query->andWhere(['upsrlm_call_type' => 1]);
        $query->andFilterWhere([
            'upsrlm_user_role' => $this->upsrlm_user_role,
        ]);
        $query->select('upsrlm_user_id');
        return $query->distinct()->all();
    }

    public function totalresult($extraQuery = null, $calling_agent_id = null)
    {
        $query = CallingList::find();
        $query->select([['id']]);
        $query->andFilterWhere([
            CallingList::getTableSchema()->fullName . '.caller_group_id' => $this->caller_group_id,
            CallingList::getTableSchema()->fullName . '.default_call_scenario_id' => $this->default_call_scenario_id
        ]);
        if ($calling_agent_id) {
            $query->andWhere(['calling_agent_id' => $calling_agent_id]);
        } else {
            $query->andFilterWhere([
                CallingList::getTableSchema()->fullName . '.calling_agent_id' => $this->calling_agent_id
            ]);
        }
        if ($extraQuery) {
            $query->andWhere($extraQuery);
        }
        return $query->count();
    }

    /**
     * Agent Daily Progress Search
     *
     * @param [type] $params
     * @return void
     */
    public function agentdailyprogresssearch($params)
    {
        $query = CallingList::find();
        $this->load($params);
        // grid filtering conditions
        $this->basicquery($query);
        $query->select("calling_agent_id");
        $query->groupBy("calling_agent_id");
        return $query->asArray()->all();
    }

    /**
     * Monitoring Page Search
     *
     * @param [type] $params
     * @return void
     */
    public function monitoringsearch($params)
    {
        $query = CallingList::find();
        $this->load($params);

        // add conditions that should always apply here

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 30],
            'sort' => [
                'defaultOrder' =>
                [
                    'call_complete_date' => SORT_ASC,
                    'call_start_time' => SORT_ASC,
                ]
            ],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $this->basicquery($query);

        $query->andFilterWhere(['like', 'callid', $this->callid]);

        return $dataProvider;
    }

    /**
     * Add Filter of Basic Query
     *
     * @param [type] $query
     * @return void
     */
    public function basicquery($query)
    {
        $query->andFilterWhere([
            CallingList::getTableSchema()->fullName . '.customer_number' => $this->customer_number,
            CallingList::getTableSchema()->fullName . '.calling_agent_number' => $this->calling_agent_number,
            CallingList::getTableSchema()->fullName . '.calling_agent_id' => $this->calling_agent_id,
            CallingList::getTableSchema()->fullName . '.caller_group_id' => $this->caller_group_id,
            CallingList::getTableSchema()->fullName . '.call_reason_id' => $this->call_reason_id,
            CallingList::getTableSchema()->fullName . '.default_call_scenario_id' => $this->default_call_scenario_id,
            CallingList::getTableSchema()->fullName . '.call_start_time' => $this->call_start_time,
            CallingList::getTableSchema()->fullName . '.call_end_time' => $this->call_end_time,
            CallingList::getTableSchema()->fullName . '.call_status' => $this->call_status,
            CallingList::getTableSchema()->fullName . '.call_duration' => $this->call_duration,
            CallingList::getTableSchema()->fullName . '.call_generate_date' => $this->call_generate_date,
            CallingList::getTableSchema()->fullName . '.call_priority' => $this->call_priority,
            CallingList::getTableSchema()->fullName . '.call_schedule_date' => $this->call_schedule_date,
            CallingList::getTableSchema()->fullName . '.call_schedule_time' => $this->call_schedule_time,
            CallingList::getTableSchema()->fullName . '.call_complete_date' => $this->call_complete_date,
            CallingList::getTableSchema()->fullName . '.previous_calling_id' => $this->previous_calling_id,
            CallingList::getTableSchema()->fullName . '.previous_call_log_id' => $this->previous_call_log_id,
            CallingList::getTableSchema()->fullName . '.api_call_log_id' => $this->api_call_log_id,
            CallingList::getTableSchema()->fullName . '.call_attempt' => $this->call_attempt,
            CallingList::getTableSchema()->fullName . '.status' => $this->status,
            CallingList::getTableSchema()->fullName . '.created_at' => $this->created_at,
            CallingList::getTableSchema()->fullName . '.created_by' => $this->created_by,
            CallingList::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            CallingList::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
        ]);

        return $query;
    }

    /**
     * This Function Return Overall Completed Call but if we pass today=true then return today completed CTC
     *
     * @param [type] $today
     * @return void
     */
    public function completedcall($today = null, $monitoring = null)
    {
        $query = CallingList::find();
        $query->where(['status' => 1]);
        if ($monitoring == null) {
            if ($today != null) {
                $query->andwhere(['call_complete_date' => date('Y-m-d')]);
            }
        } else {
            $query->andFilterWhere([
                CallingList::getTableSchema()->fullName . '.call_complete_date' => $this->call_complete_date,
                CallingList::getTableSchema()->fullName . '.default_call_scenario_id' => $this->default_call_scenario_id
            ]);
        }

        $query->andFilterWhere([
            CallingList::getTableSchema()->fullName . '.calling_agent_id' => $this->calling_agent_id
        ]);
        return $query->count();
    }

    /**
     * Overall and Today Schedule Calls
     *
     * @param [type] $today
     * @return void
     */
    public function schedulecall($today = null)
    {
        $query = CallingList::find();
        $query->where(['status' => 0]);
        $query->andFilterWhere(['calling_agent_id' => $this->calling_agent_id]);
        if ($today != null) {
            $query->andwhere(['call_schedule_date' => date('Y-m-d')]);
        }

        return $query->count();
    }

    /**
     * Number of Times Agent Click on CTC
     *
     * @param [type] $today
     * @param [type] $monitoring
     * @param [type] $calling_agent_id
     * @return void
     */
    public function ctcclick($monitoring = null, $calling_agent_id = null)
    {
        $query = CallingList::find();
        $query->andwhere(['call_complete_date' => date('Y-m-d')]);

        if ($monitoring != null) {
            $query->andFilterWhere([
                CallingList::getTableSchema()->fullName . '.caller_group_id' => $this->caller_group_id,
                CallingList::getTableSchema()->fullName . '.default_call_scenario_id' => $this->default_call_scenario_id
            ]);
        }
        if ($calling_agent_id) {
            $query->andwhere(['calling_agent_id' => $calling_agent_id]);
        } else {
            $query->andFilterWhere([
                CallingList::getTableSchema()->fullName . '.calling_agent_id' => $this->calling_agent_id
            ]);
        }

        return $query->sum('ctc_click_count') != null ? $query->sum('ctc_click_count') : 0;
    }

    /**
     * Total Call Attempt Till/Today Date
     *
     * @param [type] $today
     * @return void
     */
    public function callattempt($today = null, $monitoring = null, $calling_agent_id = null)
    {
        $query = CallingList::find();
        if ($today != null) {
            $query->andwhere(['call_complete_date' => date('Y-m-d')]);
        } else {
            $query->andFilterWhere([
                CallingList::getTableSchema()->fullName . '.call_complete_date' => $this->call_complete_date,
            ]);
        }
        if ($monitoring != null) {
            $query->andFilterWhere([
                CallingList::getTableSchema()->fullName . '.caller_group_id' => $this->caller_group_id,
                CallingList::getTableSchema()->fullName . '.default_call_scenario_id' => $this->default_call_scenario_id
            ]);
        }
        if ($calling_agent_id) {
            $query->andwhere(['calling_agent_id' => $calling_agent_id]);
        } else {
            $query->andFilterWhere([
                CallingList::getTableSchema()->fullName . '.calling_agent_id' => $this->calling_agent_id
            ]);
        }

        return $query->sum('call_attempt') != null ? $query->sum('call_attempt') : 0;
    }

    /**
     * Get First/Last Call Times for Tiles
     *
     * @param [type] $time
     * @return void
     */
    public function calltime($time, $monitoring = null, $calling_agent_id = null, $today = null)
    {
        $query = CallingList::find();

        if ($monitoring != null) {
            $query->andFilterWhere([
                CallingList::getTableSchema()->fullName . '.status' => $this->status,
                CallingList::getTableSchema()->fullName . '.caller_group_id' => $this->caller_group_id,
                CallingList::getTableSchema()->fullName . '.calling_agent_id' => $this->calling_agent_id,
                CallingList::getTableSchema()->fullName . '.call_complete_date' => $this->call_complete_date,
                CallingList::getTableSchema()->fullName . '.default_call_scenario_id' => $this->default_call_scenario_id
            ]);
        } else {
            $query->andwhere(['call_complete_date' => date('Y-m-d')]);
        }
        if ($today) {
            $query->andwhere(['call_complete_date' => date('Y-m-d')]);
        }
        if ($calling_agent_id) {
            $query->andwhere(['calling_agent_id' => $calling_agent_id]);
        }
        if ($time == 'first') {
            $query->orderBy(['call_start_time' => SORT_ASC]);
            $model = $query->limit(1)->one();
            if ($model) {
                return $model->call_start_time;
            }
        } else if ($time == 'last') {
            $query->orderBy(['call_end_time' => SORT_DESC]);
            $model = $query->limit(1)->one();
            if ($model) {
                return $model->call_end_time;
            }
        }
        return '';
    }

    /**
     * Total Talk Duration till/today date
     *
     * @return void
     */
    public function talkduration($today = null, $calling_agent_id = null)
    {
        $query = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::find();
        $query->innerjoinWith('callinglist');
        $query->andFilterWhere(['upsrlm_user_id' => $this->calling_agent_id]);
        if ($calling_agent_id) {
            $query->andWhere(['upsrlm_user_id' => $calling_agent_id]);
            $query->andWhere([CallingList::getTableSchema()->fullName . '.calling_agent_id' => $calling_agent_id]);
        }
        $query->andFilterWhere([
            CallingList::getTableSchema()->fullName . '.caller_group_id' => $this->caller_group_id,
            CallingList::getTableSchema()->fullName . '.calling_agent_id' => $this->calling_agent_id,
            // CallingList::getTableSchema()->fullName . '.call_complete_date' => $this->call_complete_date,
            CallingList::getTableSchema()->fullName . '.default_call_scenario_id' => $this->default_call_scenario_id
        ]);
        if ($today != null) {
            $query->andWhere("`api_request_datetime` LIKE '%" . date('Y-m-d') . "%'");
        }

        if ($this->call_complete_date) {
            $query->andWhere("`api_request_datetime` LIKE '%" . $this->call_complete_date . "%'");
        }

        return gmdate("H:i:s", $query->sum('talkDuration') != null ? $query->sum('talkDuration') : 0);
    }

    /**
     * Schedule Dates
     *
     * @return void
     */
    public function getScheduledates()
    {
        return ArrayHelper::map(CallingList::find()->where(['status' => 0, 'calling_agent_id' => $this->calling_agent_id])->all(), 'call_schedule_date', 'call_schedule_date');
    }

    /**
     * Get List of Calling Agents
     *
     * @return void
     */
    public function getCallingagents()
    {
        $query = CallingList::find();
        $query->andFilterWhere([
            CallingList::getTableSchema()->fullName . '.status' => $this->status,
            CallingList::getTableSchema()->fullName . '.caller_group_id' => $this->caller_group_id,
        ]);
        if ($this->searchfortoday) {
            $query->andWhere(['call_complete_date' => date('Y-m-d')]);
        }
        $query->select(['calling_agent_id']);
        $query->distinct('calling_agent_id');
        return ArrayHelper::map($query->all(), 'calling_agent_id', 'agentdetail.name');
    }

    /**
     * Completed Date
     *
     * @return void
     */
    public function getCompletedates()
    {
        $query = CallingList::find();
        $query->andFilterWhere([
            CallingList::getTableSchema()->fullName . '.calling_agent_id' => $this->calling_agent_id,
            CallingList::getTableSchema()->fullName . '.status' => $this->status
        ]);
        return ArrayHelper::map($query->all(), 'call_complete_date', 'call_complete_date');
    }

    /**
     * Call scnearios
     *
     * @return void
     */
    public function getCallscneario()
    {
        $query = CallingList::find();
        $query->andFilterWhere([
            CallingList::getTableSchema()->fullName . '.caller_group_id' => $this->caller_group_id,
            CallingList::getTableSchema()->fullName . '.calling_agent_id' => $this->calling_agent_id,
            CallingList::getTableSchema()->fullName . '.status' => $this->status,
            CallingList::getTableSchema()->fullName . '.call_complete_date' => $this->call_complete_date
        ]);
        return ArrayHelper::map($query->all(), 'default_call_scenario_id', 'callscneraio.call_scenario');
    }

    /**
     * Get How Many Call Completed in Scnearios
     *
     * @return void
     */
    public function getScnearioprogress()
    {
        $query = CallingList::find();

        $query->andFilterWhere([
            CallingList::getTableSchema()->fullName . '.calling_agent_id' => $this->calling_agent_id,
            CallingList::getTableSchema()->fullName . '.call_complete_date' => $this->call_complete_date,
            CallingList::getTableSchema()->fullName . '.default_call_scenario_id' => $this->default_call_scenario_id
        ]);
        $query->select("`default_call_scenario_id`,count(`default_call_scenario_id`) as count,`call_complete_date`");
        $query->groupBy("`default_call_scenario_id` ,`call_complete_date`");
        print_r($query->asArray()->all());
    }

    /**
     * Daily Progress Chart
     *
     * @return void
     */
    public function getDailyprogress()
    {
        $series = [];
        $scnearioseries = [];
        if ($this->callscneario) {
            foreach ($this->callscneario as $default_call_scenario_id => $scneario) {
                $scnearioname = 'scneario' . $default_call_scenario_id;
                $scnearioseries[$scnearioname] = [];
            }
        }
        $category = [];
        $query = CallingList::find();
        $query->select("`default_call_scenario_id`,count(`default_call_scenario_id`) as count,`call_complete_date`");
        $query->andFilterWhere([
            CallingList::getTableSchema()->fullName . '.calling_agent_id' => $this->calling_agent_id,
            CallingList::getTableSchema()->fullName . '.call_complete_date' => $this->call_complete_date,
            CallingList::getTableSchema()->fullName . '.default_call_scenario_id' => $this->default_call_scenario_id
        ]);
        $query->groupBy("`default_call_scenario_id` ,`call_complete_date`")->having("`call_complete_date` IS NOT NULL");
        $models = $query->asArray()->all();

        if ($models) {
            foreach ($models as $model) {
                if ($this->callscneario) {
                    foreach ($this->callscneario as $default_call_scenario_id => $scneario) {
                        $scnearioname = 'scneario' . $default_call_scenario_id;
                        if ($default_call_scenario_id == $model['default_call_scenario_id']) {
                            array_push($scnearioseries[$scnearioname], (int) $model['count']);
                        }
                    }
                }
                array_push($category, $model['call_complete_date']);
            }
        }
        if ($this->callscneario) {
            foreach ($this->callscneario as $default_call_scenario_id => $scneario) {
                $scnearioname = 'scneario' . $default_call_scenario_id;
                array_push($series, ['name' => $scneario, 'data' => $scnearioseries[$scnearioname]]);
            }
        }
        $chart = 'line';
        if (count($category) <= 1) {
            $chart = 'bar';
        }

        return "<script>
                var date_category = " . json_encode($category) . ";
                var chart_type = " . json_encode($chart) . ";
                var interview_series = " . json_encode($series) . ";
            </script>";
    }

    /**
     * Get How Many District Covered
     *
     * @return void
     */
    public function getDistrictcoverage()
    {
        $coverage = [];
        $query = CallingList::find();
        $query->andFilterWhere([
            CallingList::getTableSchema()->fullName . '.calling_agent_id' => $this->calling_agent_id,
            CallingList::getTableSchema()->fullName . '.call_complete_date' => $this->call_complete_date,
            CallingList::getTableSchema()->fullName . '.default_call_scenario_id' => $this->default_call_scenario_id
        ]);

        $query->select("`member_district_name`,`status`,COUNT(`status`) as count");
        $districtlist = $query->distinct("`member_district_name`")->all();
        if ($districtlist) {
            foreach ($districtlist as $district) {
                $coverage[$district->member_district_name] = ['pending' => NULL, 'complete' => NULL];
            }
        }
        $query->groupBy("`status`");
        $query->orderBy(['member_district_name' => SORT_ASC]);
        $models = $query->asArray()->all();
        if ($models) {
            foreach ($models as $model) {
                if ($model['status']) {
                    $coverage[$model['member_district_name']] = ['complete' => $model['count'], 'pending' => $coverage[$model['member_district_name']]['pending'] != null ? $coverage[$model['member_district_name']]['pending'] : 0];
                } else {
                    $coverage[$model['member_district_name']] = ['pending' => $model['count'], 'complete' => NULL];
                }
            }
        }
        return $coverage;
    }

    /**
     * Calculate Percentage
     *
     * @param [type] $total
     * @param [type] $achived
     * @return void
     */
    public static function calculatepercantage($total, $achived)
    {
        if ($total <= 0) {
            return 0;
        }
        if ($achived > 0) {
            return round(((int) $achived * 100) / $total, 0);
        } else {
            return 0;
        }
    }

    /**
     * Get Agent First Call
     *
     * @return void
     */
    public function getFirstcall()
    {
        $first = CloudTeleApiCall::find()->select(['api_request_datetime'])->where(['upsrlm_user_id' => $this->calling_agent_id, 'upsrlm_call_type' => 1])->andFilterWhere(['>=', 'created_at', strtotime($this->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($this->api_request_datetime . ' 23:59:59')])->orderBy(['api_request_datetime' => SORT_ASC])->limit(1)->one();
        if ($first) {
            return $first->api_request_datetime;
        }
    }

    /**
     * Agent Last Call
     *
     * @return void
     */
    public function getLastcall()
    {
        $last = CloudTeleApiCall::find()->select(['api_request_datetime'])->where(['upsrlm_user_id' => $this->calling_agent_id, 'upsrlm_call_type' => 1])->andFilterWhere(['>=', 'created_at', strtotime($this->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($this->api_request_datetime . ' 23:59:59')])->orderBy(['api_request_datetime' => SORT_DESC])->limit(1)->one();
        if ($last) {
            return $last->api_request_datetime;
        }
    }

    /**
     * Today Work Hours
     *
     * @return void
     */
    public function getWorkhour()
    {
        if ($this->firstcall && $this->lastcall) {
            echo gmdate("H:i:s", round(abs(strtotime($this->lastcall) - strtotime($this->firstcall)), 0));
        }
    }

    /**
     * Total CTC Click
     *
     * @return void
     */
    public function getTodayctcclick()
    {
        return CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => $this->calling_agent_id, 'upsrlm_call_type' => 1])->andFilterWhere(['>=', 'created_at', strtotime($this->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($this->api_request_datetime . ' 23:59:59')])->count();
    }

    /**
     * Get Today Agent Call Recivied
     *
     * @return void
     */
    public function getTodayagentreciviedcall()
    {
        return CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => $this->calling_agent_id, 'upsrlm_call_type' => 1, 'upsrlm_agent_call_received' => 1])->andFilterWhere(['>=', 'created_at', strtotime($this->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($this->api_request_datetime . ' 23:59:59')])->count();
    }

    /**
     * Get Today Both Answered
     *
     * @return void
     */
    public function getTodaybothanswered()
    {
        return CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => $this->calling_agent_id, 'callStatus' => 3, 'upsrlm_call_type' => 1])->andFilterWhere(['>=', 'created_at', strtotime($this->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($this->api_request_datetime . ' 23:59:59')])->count();
    }

    /**
     * Get Talk Duration 
     *
     * @return void
     */
    public function getTalkduration()
    {
        return gmdate("H:i:s", CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => $this->calling_agent_id, 'upsrlm_call_type' => 1])->andFilterWhere(['>=', 'created_at', strtotime($this->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($this->api_request_datetime . ' 23:59:59')])->sum('talkDuration'));
    }

    /**
     * IVR Duration
     *
     * @return void
     */
    public function getIverduration()
    {
        return gmdate("H:i:s", CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => $this->calling_agent_id, 'upsrlm_call_type' => 1])->andFilterWhere(['>=', 'created_at', strtotime($this->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($this->api_request_datetime . ' 23:59:59')])->sum('ivrDuration'));
    }
}
