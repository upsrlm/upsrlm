<?php

namespace common\models\dynamicdb\internalcallcenter\platform\search;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\internalcallcenter\platform\CallingScneario1001Progress;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiCall;

/**
 * CallingScneario1001ProgressSearch represents the model behind the search form of `common\models\dynamicdb\internalcallcenter\platform\CallingScneario1001Progress`.
 */
class CallingScneario1001ProgressSearch extends CallingScneario1001Progress {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'call_scenario_id', 'work_hour', 'total_call', 'ctc_click', 'ibd_call', 'success_call', 'agent_call_recived', 'upsrlm_connection_status1', 'upsrlm_connection_status21', 'upsrlm_connection_status22', 'upsrlm_connection_status23', 'upsrlm_connection_status24', 'upsrlm_connection_status30', 'both_answered', 'from_unanswered', 'talk_duration', 'ivr_duration', 'sce_q1_none', 'sce_q1_1', 'sce_q1_2', 'sce_q2_none', 'sce_q2_1', 'sce_q2_2', 'sce_q2_3', 'sce_q3_none', 'sce_q3_1', 'sce_q3_2', 'sce_q4_none', 'sce_q4_1', 'sce_q4_2', 'sce_q4_3', 'sce_q5_none', 'sce_q5_1', 'sce_q5_2', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['calling_date', 'start_time', 'end_time'], 'safe'],
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
        $query = CallingScneario1001Progress::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'call_scenario_id' => $this->call_scenario_id,
            'calling_date' => $this->calling_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'work_hour' => $this->work_hour,
            'total_call' => $this->total_call,
            'ctc_click' => $this->ctc_click,
            'ibd_call' => $this->ibd_call,
            'success_call' => $this->success_call,
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
            'sce_q1_none' => $this->sce_q1_none,
            'sce_q1_1' => $this->sce_q1_1,
            'sce_q1_2' => $this->sce_q1_2,
            'sce_q2_none' => $this->sce_q2_none,
            'sce_q2_1' => $this->sce_q2_1,
            'sce_q2_2' => $this->sce_q2_2,
            'sce_q2_3' => $this->sce_q2_3,
            'sce_q3_none' => $this->sce_q3_none,
            'sce_q3_1' => $this->sce_q3_1,
            'sce_q3_2' => $this->sce_q3_2,
            'sce_q4_none' => $this->sce_q4_none,
            'sce_q4_1' => $this->sce_q4_1,
            'sce_q4_2' => $this->sce_q4_2,
            'sce_q4_3' => $this->sce_q4_3,
            'sce_q5_none' => $this->sce_q5_none,
            'sce_q5_1' => $this->sce_q5_1,
            'sce_q5_2' => $this->sce_q5_2,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }

    public function basicquery($query) {
        $query->andFilterWhere([
            'id' => $this->id,
            'call_scenario_id' => $this->call_scenario_id,
            'calling_date' => $this->calling_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'work_hour' => $this->work_hour,
            'total_call' => $this->total_call,
            'ctc_click' => $this->ctc_click,
            'ibd_call' => $this->ibd_call,
            'success_call' => $this->success_call,
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
            'sce_q1_none' => $this->sce_q1_none,
            'sce_q1_1' => $this->sce_q1_1,
            'sce_q1_2' => $this->sce_q1_2,
            'sce_q2_none' => $this->sce_q2_none,
            'sce_q2_1' => $this->sce_q2_1,
            'sce_q2_2' => $this->sce_q2_2,
            'sce_q2_3' => $this->sce_q2_3,
            'sce_q3_none' => $this->sce_q3_none,
            'sce_q3_1' => $this->sce_q3_1,
            'sce_q3_2' => $this->sce_q3_2,
            'sce_q4_none' => $this->sce_q4_none,
            'sce_q4_1' => $this->sce_q4_1,
            'sce_q4_2' => $this->sce_q4_2,
            'sce_q4_3' => $this->sce_q4_3,
            'sce_q5_none' => $this->sce_q5_none,
            'sce_q5_1' => $this->sce_q5_1,
            'sce_q5_2' => $this->sce_q5_2,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        return $query;
    }

    public function calldetailsearch($params) {
        $query = CloudTeleApiCall::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 50],
            'sort' => [
                'defaultOrder' =>
                [
                    'api_request_datetime' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'upsrlm_call_scenario' => 1001,
            'upsrlm_call_type' => [1, 2],
        ]);

        $query->andFilterWhere(['>=', 'created_at', strtotime($this->calling_date . ' 00:00:00')])
                ->andFilterWhere(['<=', 'created_at', strtotime($this->calling_date . ' 23:59:59')]);

        return $dataProvider;
    }

    public function getCallingdates() {
        $query = CallingScneario1001Progress::find();
        $query->andFilterWhere([
            'id' => $this->id,
            'call_scenario_id' => $this->call_scenario_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'work_hour' => $this->work_hour,
            'total_call' => $this->total_call,
            'ctc_click' => $this->ctc_click,
            'ibd_call' => $this->ibd_call,
            'success_call' => $this->success_call,
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
            'sce_q1_none' => $this->sce_q1_none,
            'sce_q1_1' => $this->sce_q1_1,
            'sce_q1_2' => $this->sce_q1_2,
            'sce_q2_none' => $this->sce_q2_none,
            'sce_q2_1' => $this->sce_q2_1,
            'sce_q2_2' => $this->sce_q2_2,
            'sce_q2_3' => $this->sce_q2_3,
            'sce_q3_none' => $this->sce_q3_none,
            'sce_q3_1' => $this->sce_q3_1,
            'sce_q3_2' => $this->sce_q3_2,
            'sce_q4_none' => $this->sce_q4_none,
            'sce_q4_1' => $this->sce_q4_1,
            'sce_q4_2' => $this->sce_q4_2,
            'sce_q4_3' => $this->sce_q4_3,
            'sce_q5_none' => $this->sce_q5_none,
            'sce_q5_1' => $this->sce_q5_1,
            'sce_q5_2' => $this->sce_q5_2,
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

    public function getTotaldays() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('calling_date');
        return $query->distinct('calling_date')->count();
    }

    public function getTotalcall() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('total_call');
        return $query->sum('total_call');
    }

    public function getTotalctcclick() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('ctc_click');
        return $query->sum('ctc_click');
    }

    public function getTotalibdcall() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('ibd_call');
        return $query->sum('ibd_call');
    }

    public function getTotalsuccesscall() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('success_call');
        return $query->sum('success_call');
    }

    public function getTotalagentcallrecived() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('agent_call_recived');
        return $query->sum('agent_call_recived');
    }

    public function getTotalbothanswered() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('both_answered');
        return $query->sum('both_answered');
    }

    public function getTotalivrduration() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('ivr_duration');
        return self::seconds2human($query->sum('ivr_duration'));
    }

    public function getTotaltalkduration() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('talk_duration');
        return self::seconds2human($query->sum('talk_duration'));
    }

    public function getTotalunanswered() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('from_unanswered');
        return $query->sum('from_unanswered');
    }

    public function getTotalcallstatus10() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('upsrlm_call_status10');
        return $query->sum('upsrlm_call_status10');
    }

    public function getTotalcallstatus11() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('upsrlm_call_status11');
        return $query->sum('upsrlm_call_status11');
    }

    public function getTotalcallstatus12() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('upsrlm_call_status12');
        return $query->sum('upsrlm_call_status12');
    }

    public function getTotalcallstatus13() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('upsrlm_call_status13');
        return $query->sum('upsrlm_call_status13');
    }

    public function getQ11() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('sce_q1_1');
        return $query->sum('sce_q1_1');
    }

    public function getQ12() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('sce_q1_2');
        return $query->sum('sce_q1_2');
    }

    public function getQ21() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('sce_q2_1');
        return $query->sum('sce_q2_1');
    }

    public function getQ22() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('sce_q2_2');
        return $query->sum('sce_q2_2');
    }

    public function getQ23() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('sce_q2_3');
        return $query->sum('sce_q2_3');
    }

    public function getQ31() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('sce_q3_1');
        return $query->sum('sce_q3_1');
    }

    public function getQ32() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('sce_q3_2');
        return $query->sum('sce_q3_2');
    }
    public function getQ40() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('sce_q4_0');
        return $query->sum('sce_q4_0');
    }
    public function getQ41() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('sce_q4_1');
        return $query->sum('sce_q4_1');
    }

    public function getQ42() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('sce_q4_2');
        return $query->sum('sce_q4_2');
    }

    public function getQ43() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('sce_q4_3');
        return $query->sum('sce_q4_3');
    }

    public function getQ51() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('sce_q5_1');
        return $query->sum('sce_q5_1');
    }

    public function getQ52() {
        $query = CallingScneario1001Progress::find();
        $this->basicquery($query);
        $query->select('sce_q5_2');
        return $query->sum('sce_q5_2');
    }

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

}
