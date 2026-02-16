<?php

namespace common\models\dynamicdb\internalcallcenter\platform\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\internalcallcenter\platform\CallingAgentProgressIbd;
use \yii\helpers\ArrayHelper;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiCall;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiLog;
/**
 * CallingAgentProgressSearch represents the model behind the search form of `common\models\dynamicdb\internalcallcenter\platform\CallingAgentProgress`.
 */
class CallingAgentProgressIbdSearch extends CallingAgentProgressIbd
{
    public $tables = 'cloud_tele_api_log';
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['calling_agent_id', 'calling_agent_role', 'work_hour', 'ibd_call', 'other_call', 'registred_call', 'agent_call_recived', 'both_answered', 'from_unanswered', 'talk_duration', 'ivr_duration', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['calling_date', 'start_time', 'end_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = CallingAgentProgressIbd::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 100],
            'sort' => [
                'defaultOrder' =>
                [
                    'calling_date' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $this->basicquery($query);

        return $dataProvider;
    }

    /**
     * Call Detail
     *
     * @param [type] $params
     * @return void
     */
    public function calldetailsearch($params)
    {
         $this->load($params);

        $q = new CloudTeleApiLog();
        if (isset($this->calling_date) && $this->calling_date != '') {
            if (date("my", strtotime($this->calling_date)) == date("my")) {
                
            } else {

                $tableSchema = \Yii::$app->dbinternalcallcenter->schema->getTableSchema($this->tables . '_' . date("Ym", strtotime($this->calling_date)));
                if ($tableSchema !== null) {
                    $q = new CloudTeleApiLog($this->tables . '_' . date("Ym", strtotime($this->calling_date)));
                }
            }
        }

        $query = $q->find();
        //$query = CloudTeleApiCall::find();
        // add conditions that should always apply here
        $query->andFilterWhere([
            'upsrlm_user_id' => $this->calling_agent_id,
            'upsrlm_user_role' => $this->calling_agent_role,
            'upsrlm_call_type' => 2,
            'project_id' => 1,
            
        ]);

        $query->andFilterWhere(['>=', 'created_at', strtotime($this->calling_date . ' 00:00:00')])
                ->andFilterWhere(['<=', 'created_at', strtotime($this->calling_date . ' 23:59:59')]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 100],
            'sort' => [
                'defaultOrder' =>
                [
                    'api_request_datetime' => SORT_ASC,
                ]
            ],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }



        return $dataProvider;
    }

    /**
     * Get Distnict Call Dates
     *
     * @return void
     */
    public function getCallingdates()
    {
        $query = CallingAgentProgressIbd::find();
        $query->andFilterWhere([
            'id' => $this->id,
            'calling_agent_id' => $this->calling_agent_id,
            'calling_agent_role' => $this->calling_agent_role,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'work_hour' => $this->work_hour,
            'ibd_call' => $this->ibd_call,
            'other_call' => $this->other_call,
            'registred_call' => $this->registred_call,
            'agent_call_recived' => $this->agent_call_recived,
            'both_answered' => $this->both_answered,
            'from_unanswered' => $this->from_unanswered,
            'talk_duration' => $this->talk_duration,
            'ivr_duration' => $this->ivr_duration,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $query->distinct('calling_date');
        $query->orderBy(['calling_date' => SORT_DESC]);
        return ArrayHelper::map($query->all(), 'calling_date', 'calling_date');
    }

    /**
     * Calling Agnets List
     *
     * @return void
     */
    public function getCallingagents()
    {
        $query = CallingAgentProgressIbd::find();
        $query->andFilterWhere([
            'id' => $this->id,
            'calling_agent_role' => $this->calling_agent_role,
            'calling_date' => $this->calling_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'work_hour' => $this->work_hour,
            'ibd_call' => $this->ibd_call,
            'other_call' => $this->other_call,
            'registred_call' => $this->registred_call,
            'agent_call_recived' => $this->agent_call_recived,
            'both_answered' => $this->both_answered,
            'from_unanswered' => $this->from_unanswered,
            'talk_duration' => $this->talk_duration,
            'ivr_duration' => $this->ivr_duration,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $query->distinct('calling_agent_id');
        return ArrayHelper::map($query->all(), 'calling_agent_id', 'agentdetail.name');
    }

    public function getCallingagentsrole()
    {
        $query = CallingAgentProgressIbd::find();
        $query->andFilterWhere([
            'id' => $this->id,
            'calling_date' => $this->calling_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'work_hour' => $this->work_hour,
            'ibd_call' => $this->ibd_call,
            'other_call' => $this->other_call,
            'registred_call' => $this->registred_call,
            'agent_call_recived' => $this->agent_call_recived,
            'both_answered' => $this->both_answered,
            'from_unanswered' => $this->from_unanswered,
            'talk_duration' => $this->talk_duration,
            'ivr_duration' => $this->ivr_duration,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $query->distinct('calling_agent_role');
        return ArrayHelper::map($query->all(), 'calling_agent_role', 'agentdetail.urole.role_name');
    }

    /**
     * Add Filer Basic Query
     *
     * @param [type] $query
     * @return void
     */
    public function basicquery($query)
    {
        $query->andFilterWhere([
            'id' => $this->id,
            'calling_agent_id' => $this->calling_agent_id,
            'calling_agent_role' => $this->calling_agent_role,
            'calling_date' => $this->calling_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'work_hour' => $this->work_hour,
            'ibd_call' => $this->ibd_call,
            'other_call' => $this->other_call,
            'registred_call' => $this->registred_call,
            'agent_call_recived' => $this->agent_call_recived,
            'both_answered' => $this->both_answered,
            'from_unanswered' => $this->from_unanswered,
            'talk_duration' => $this->talk_duration,
            'ivr_duration' => $this->ivr_duration,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        return $query;
    }

    public function getTotalagent()
    {
        $query = CallingAgentProgressIbd::find();
        $this->basicquery($query);
        $query->select('calling_agent_id');
        return $query->distinct('calling_agent_id')->count();
    }

    public function getTotaldays()
    {
        $query = CallingAgentProgressIbd::find();
        $this->basicquery($query);
        $query->select('calling_date');
        return $query->distinct('calling_date')->count();
    }

    public function getTotalibdcall()
    {
        $query = CallingAgentProgressIbd::find();
        $this->basicquery($query);
        $query->select('ibd_call');
        return $query->sum('ibd_call');
    }

    public function getTotalothercall()
    {
        $query = CallingAgentProgressIbd::find();
        $this->basicquery($query);
        $query->select('other_call');
        return $query->sum('other_call');
    }

    public function getTotalregistredcall()
    {
        $query = CallingAgentProgressIbd::find();
        $this->basicquery($query);
        $query->select('registred_call');
        return $query->sum('registred_call');
    }

    public function getTotalagentcallrecived()
    {
        $query = CallingAgentProgressIbd::find();
        $this->basicquery($query);
        $query->select('agent_call_recived');
        return $query->sum('agent_call_recived');
    }

    public function getTotalbothanswered()
    {
        $query = CallingAgentProgressIbd::find();
        $this->basicquery($query);
        $query->select('both_answered');
        return $query->sum('both_answered');
    }

    public function getTotalivrduration()
    {
        $query = CallingAgentProgressIbd::find();
        $this->basicquery($query);
        $query->select('ivr_duration');
        return self::seconds2human($query->sum('ivr_duration'));
    }

    public function getTotaltalkduration()
    {
        $query = CallingAgentProgressIbd::find();
        $this->basicquery($query);
        $query->select('talk_duration');
        return self::seconds2human($query->sum('talk_duration'));
    }

    public function getTotalunanswered()
    {
        $query = CallingAgentProgressIbd::find();
        $this->basicquery($query);
        $query->select('from_unanswered');
        return $query->sum('from_unanswered');
    }


    /**
     * Get Hours:Minute:Seconds From Seconds
     *
     * @param [type] $seconds
     * @return void
     */
    public static function seconds2human($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $seconds = $seconds % 60;
        if ($hours < 9) {
            $hours = '0' . $hours;
        }
        if ($minutes < 9) {
            $minutes = '0' . $minutes;
        }
        if ($seconds < 9) {
            $seconds = '0' . $seconds;
        }
        return "$hours:$minutes:$seconds";
    }


    public function getFirstcall()
    {
        $query = CallingAgentProgressIbd::find();
        $this->basicquery($query);
        $query->select('start_time');
        $first = $query->orderBy(['start_time' => SORT_ASC])->limit(1)->one();
        if ($first) {
            return $first->start_time;
        }
    }

    /**
     * Agent Last Call
     *
     * @return void
     */
    public function getLastcall()
    {
        $query = CallingAgentProgressIbd::find();
        $this->basicquery($query);
        $query->select('end_time');
        $last = $query->orderBy(['end_time' => SORT_DESC])->limit(1)->one();
        if ($last) {
            return $last->end_time;
        }
    }

    public function getWorkhour()
    {
        if ($this->firstcall && $this->lastcall) {
            echo gmdate("H:i:s", round(abs(strtotime($this->lastcall) - strtotime($this->firstcall)), 0));
        }
    }
}
