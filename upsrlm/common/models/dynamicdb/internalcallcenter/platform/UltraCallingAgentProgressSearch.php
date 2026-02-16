<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\internalcallcenter\platform\UltraCallingAgentProgress;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiLog;

/**
 * UltraCallingAgentProgressSearch represents the model behind the search form of `common\models\dynamicdb\internalcallcenter\platform\UltraCallingAgentProgress`.
 */
class UltraCallingAgentProgressSearch extends UltraCallingAgentProgress {
    public $tables = 'cloud_tele_api_log';
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'calling_agent_id', 'calling_agent_role', 'work_hour', 'target', 'achieve', 'ctc_click', 'agent_call_recived', 'upsrlm_connection_status1', 'upsrlm_connection_status21', 'upsrlm_connection_status22', 'upsrlm_connection_status23', 'upsrlm_connection_status24', 'upsrlm_connection_status30', 'both_answered', 'from_unanswered', 'talk_duration', 'ivr_duration', 'created_at', 'updated_at', 'status'], 'safe'],
            [['calling_agent_name', 'calling_date', 'start_time', 'end_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params) {
        $query = UltraCallingAgentProgress::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'calling_agent_id' => $this->calling_agent_id,
            'calling_agent_role' => $this->calling_agent_role,
            'calling_date' => $this->calling_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'work_hour' => $this->work_hour,
            'target' => $this->target,
            'achieve' => $this->achieve,
            'ctc_click' => $this->ctc_click,
            'agent_call_recived' => $this->agent_call_recived,
            'upsrlm_connection_status1' => $this->upsrlm_connection_status1,
            'upsrlm_connection_status21' => $this->upsrlm_connection_status21,
            'upsrlm_connection_status22' => $this->upsrlm_connection_status22,
            'upsrlm_connection_status23' => $this->upsrlm_connection_status23,
            'upsrlm_connection_status24' => $this->upsrlm_connection_status24,
            'upsrlm_connection_status30' => $this->upsrlm_connection_status30,
            'both_answered' => $this->both_answered,
            'from_unanswered' => $this->from_unanswered,
            'talk_duration' => $this->talk_duration,
            'ivr_duration' => $this->ivr_duration,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'calling_agent_name', $this->calling_agent_name]);

        return $dataProvider;
    }

    public function searcha($params) {
        $query = UltraCallingAgentProgress::find();

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

    public function calldetailsearch($params) {
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
            'upsrlm_call_type' => 1,
            'project_id' => 3
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
    public function getCallingdates() {
        $query = UltraCallingAgentProgress::find();
        $query->andFilterWhere([
            'id' => $this->id,
            'calling_agent_id' => $this->calling_agent_id,
            'calling_agent_role' => $this->calling_agent_role,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'work_hour' => $this->work_hour,
            'ctc_click' => $this->ctc_click,
            'agent_call_recived' => $this->agent_call_recived,
            'upsrlm_connection_status1' => $this->upsrlm_connection_status1,
            'upsrlm_connection_status21' => $this->upsrlm_connection_status21,
            'upsrlm_connection_status22' => $this->upsrlm_connection_status22,
            'upsrlm_connection_status23' => $this->upsrlm_connection_status23,
            'upsrlm_connection_status24' => $this->upsrlm_connection_status24,
            'upsrlm_connection_status30' => $this->upsrlm_connection_status30,
            'both_answered' => $this->both_answered,
            'from_unanswered' => $this->from_unanswered,
            'talk_duration' => $this->talk_duration,
            'ivr_duration' => $this->ivr_duration,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
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
    public function getCallingagents() {
        $query = UltraCallingAgentProgress::find();
        $query->andFilterWhere([
            'id' => $this->id,
            'calling_agent_role' => $this->calling_agent_role,
            'calling_date' => $this->calling_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'work_hour' => $this->work_hour,
            'ctc_click' => $this->ctc_click,
            'agent_call_recived' => $this->agent_call_recived,
            'upsrlm_connection_status1' => $this->upsrlm_connection_status1,
            'upsrlm_connection_status21' => $this->upsrlm_connection_status21,
            'upsrlm_connection_status22' => $this->upsrlm_connection_status22,
            'upsrlm_connection_status23' => $this->upsrlm_connection_status23,
            'upsrlm_connection_status24' => $this->upsrlm_connection_status24,
            'upsrlm_connection_status30' => $this->upsrlm_connection_status30,
            'both_answered' => $this->both_answered,
            'from_unanswered' => $this->from_unanswered,
            'talk_duration' => $this->talk_duration,
            'ivr_duration' => $this->ivr_duration,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->distinct('calling_agent_id');
        return ArrayHelper::map($query->all(), 'calling_agent_id', 'agentdetail.name');
    }

    public function getCallingagentsrole() {
        $query = UltraCallingAgentProgress::find();
        $query->andFilterWhere([
            'id' => $this->id,
            'calling_date' => $this->calling_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'work_hour' => $this->work_hour,
            'ctc_click' => $this->ctc_click,
            'agent_call_recived' => $this->agent_call_recived,
            'upsrlm_connection_status1' => $this->upsrlm_connection_status1,
            'upsrlm_connection_status21' => $this->upsrlm_connection_status21,
            'upsrlm_connection_status22' => $this->upsrlm_connection_status22,
            'upsrlm_connection_status23' => $this->upsrlm_connection_status23,
            'upsrlm_connection_status24' => $this->upsrlm_connection_status24,
            'upsrlm_connection_status30' => $this->upsrlm_connection_status30,
            'both_answered' => $this->both_answered,
            'from_unanswered' => $this->from_unanswered,
            'talk_duration' => $this->talk_duration,
            'ivr_duration' => $this->ivr_duration,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
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
    public function basicquery($query) {
        $query->andFilterWhere([
            'id' => $this->id,
            'calling_agent_id' => $this->calling_agent_id,
            'calling_agent_role' => $this->calling_agent_role,
            'calling_date' => $this->calling_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'work_hour' => $this->work_hour,
            'ctc_click' => $this->ctc_click,
            'agent_call_recived' => $this->agent_call_recived,
            'upsrlm_connection_status1' => $this->upsrlm_connection_status1,
            'upsrlm_connection_status21' => $this->upsrlm_connection_status21,
            'upsrlm_connection_status22' => $this->upsrlm_connection_status22,
            'upsrlm_connection_status23' => $this->upsrlm_connection_status23,
            'upsrlm_connection_status24' => $this->upsrlm_connection_status24,
            'upsrlm_connection_status30' => $this->upsrlm_connection_status30,
            'both_answered' => $this->both_answered,
            'from_unanswered' => $this->from_unanswered,
            'talk_duration' => $this->talk_duration,
            'ivr_duration' => $this->ivr_duration,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        return $query;
    }

    public function getTotalagent() {
        $query = UltraCallingAgentProgress::find();
        $this->basicquery($query);
        $query->select('calling_agent_id');
        return $query->distinct('calling_agent_id')->count();
    }

    public function getTotaldays() {
        $query = UltraCallingAgentProgress::find();
        $this->basicquery($query);
        $query->select('calling_date');
        return $query->distinct('calling_date')->count();
    }

    public function getTotalctcclick() {
        $query = UltraCallingAgentProgress::find();
        $this->basicquery($query);
        $query->select('ctc_click');
        return $query->sum('ctc_click');
    }
     public function getTotaltarget() {
        $query = UltraCallingAgentProgress::find();
        $this->basicquery($query);
        $query->select('target');
        return $query->sum('target');
    }
    public function getTotalachieve() {
        $query = UltraCallingAgentProgress::find();
        $this->basicquery($query);
        $query->select('achieve');
        return $query->sum('achieve');
    }
    public function getTotalagentcallrecived() {
        $query = UltraCallingAgentProgress::find();
        $this->basicquery($query);
        $query->select('agent_call_recived');
        return $query->sum('agent_call_recived');
    }

    public function getTotalbothanswered() {
        $query = UltraCallingAgentProgress::find();
        $this->basicquery($query);
        $query->select('both_answered');
        return $query->sum('both_answered');
    }

    public function getTotalivrduration() {
        $query = UltraCallingAgentProgress::find();
        $this->basicquery($query);
        $query->select('ivr_duration');
        return self::seconds2human($query->sum('ivr_duration'));
    }

    public function getTotaltalkduration() {
        $query = UltraCallingAgentProgress::find();
        $this->basicquery($query);
        $query->select('talk_duration');
        return self::seconds2human($query->sum('talk_duration'));
    }

    public function getTotalunanswered() {
        $query = UltraCallingAgentProgress::find();
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
    public static function seconds2human($seconds) {
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

    public function getFirstcall() {
        $query = UltraCallingAgentProgress::find();
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
    public function getLastcall() {
        $query = UltraCallingAgentProgress::find();
        $this->basicquery($query);
        $query->select('end_time');
        $last = $query->orderBy(['end_time' => SORT_DESC])->limit(1)->one();
        if ($last) {
            return $last->end_time;
        }
    }

    public function getWorkhour() {
        if ($this->firstcall && $this->lastcall) {
            echo gmdate("H:i:s", round(abs(strtotime($this->lastcall) - strtotime($this->firstcall)), 0));
        }
    }

}
