<?php

namespace common\models\dynamicdb\internalcallcenter;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiLog;

/**
 * CloudTeleApiLogSearch represents the model behind the search form of `common\models\dynamicdb\internalcallcenter\CloudTeleApiLog`.
 */
class CloudTeleApiLogSearch extends CloudTeleApiLog {

    public $api_call_status_option = [];
    public $api_status_code_option = [];
    public $upsrlm_connection_status_option = [];
    public $upsrlm_call_status_option = [];
    public $upsrlm_call_scenario_option = [];
    public $from_date_time;
    public $to_date_time;
    public $upsrlm_user_group;
    public $month_id;
    public $date;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'bc_application_id','cbo_shg_id', 'upsrlm_call_scenario', 'upsrlm_user_id', 'api_status_code', 'ivrDuration', 'masterAgent', 'masterGroupId', 'talkDuration', 'agentOnCallDuration', 'lastFirstDuration', 'custAnswerDuration', 'callStatus', 'HangupBySourceDetected', 'totalHoldDuration', 'upsrlm_connection_status', 'upsrlm_call_status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'safe'],
            [['upsrlm_user_mobile_no', 'customernumber', 'serviceuserid', 'token', 'api_response', 'api_status', 'api_message', 'api_request_datetime', 'callid', 'did', 'cType', 'CTC', 'ivrSTime', 'ivrETime', 'userId', 'cNumber', 'masterNumCTC', 'masterAgentNumber', 'firstAttended', 'firstAnswerTime', 'lastHangupTime', 'custAnswerSTime', 'custAnswerETime', 'ivrExecuteFlow', 'forward', 'totalCreditsUsed', 'ivrIdArr', 'aAnsH', 'aH', 'nH', 'recordings', 'recording_file', 'cliArr', 'aHDetail', 'nHDetail', 'full_response', 'upsrlm_call_type'], 'safe'],
            [['from_date_time', 'to_date_time'], 'safe'],
            [['month_id'], 'safe'],
            [['upsrlm_user_role'], 'safe'],
            [['date'], 'safe'],
            [['date','project_id'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true, $columns = null, $distinct = false) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = CloudTeleApiLog::find();
        if ($columns != NULL) {
            $query->select($columns);
        }
        
        if (isset($this->from_date_time) && $this->from_date_time != '') {
            $query->andFilterWhere(['>=', CloudTeleApiLog::getTableSchema()->fullName . '.api_request_datetime', $this->from_date_time . ' 00:00:00']);
        }
        if (isset($this->to_date_time) && $this->to_date_time != '') {
            $query->andFilterWhere(['<=', CloudTeleApiLog::getTableSchema()->fullName . '.api_request_datetime', $this->to_date_time . ' 23:59:59']);
        }
        if (isset($this->date) && $this->date != '') {
            $query->andFilterWhere(['>=', CloudTeleApiLog::getTableSchema()->fullName . '.api_request_datetime', $this->date . ' 00:00:00']);
        }
        if (isset($this->date) && $this->date != '') {
            $query->andFilterWhere(['<=', CloudTeleApiLog::getTableSchema()->fullName . '.api_request_datetime', $this->date . ' 23:59:59']);
        }
        if (isset($this->upsrlm_user_id) && $this->upsrlm_user_id != '') {
            $query->andFilterWhere(['=', CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_user_id', $this->upsrlm_user_id]);
        }
        if ($distinct) {
           $query->groupBy($distinct); 
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            CloudTeleApiLog::getTableSchema()->fullName . '.id' => $this->id,
            CloudTeleApiLog::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            CloudTeleApiLog::getTableSchema()->fullName . '.cbo_shg_id' => $this->cbo_shg_id,
            CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_user_id' => $this->upsrlm_user_id,
            CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_user_role' => $this->upsrlm_user_role,
            CloudTeleApiLog::getTableSchema()->fullName . '.api_status_code' => $this->api_status_code,
            CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_call_scenario' => $this->upsrlm_call_scenario,
            CloudTeleApiLog::getTableSchema()->fullName . '.api_request_datetime' => $this->api_request_datetime,
            CloudTeleApiLog::getTableSchema()->fullName . '.ivrSTime' => $this->ivrSTime,
            CloudTeleApiLog::getTableSchema()->fullName . '.ivrETime' => $this->ivrETime,
            CloudTeleApiLog::getTableSchema()->fullName . '.ivrDuration' => $this->ivrDuration,
            CloudTeleApiLog::getTableSchema()->fullName . '.masterAgent' => $this->masterAgent,
            CloudTeleApiLog::getTableSchema()->fullName . '.masterGroupId' => $this->masterGroupId,
            CloudTeleApiLog::getTableSchema()->fullName . '.talkDuration' => $this->talkDuration,
            CloudTeleApiLog::getTableSchema()->fullName . '.agentOnCallDuration' => $this->agentOnCallDuration,
            CloudTeleApiLog::getTableSchema()->fullName . '.firstAnswerTime' => $this->firstAnswerTime,
            CloudTeleApiLog::getTableSchema()->fullName . '.lastHangupTime' => $this->lastHangupTime,
            CloudTeleApiLog::getTableSchema()->fullName . '.lastFirstDuration' => $this->lastFirstDuration,
            CloudTeleApiLog::getTableSchema()->fullName . '.custAnswerSTime' => $this->custAnswerSTime,
            CloudTeleApiLog::getTableSchema()->fullName . '.custAnswerETime' => $this->custAnswerETime,
            CloudTeleApiLog::getTableSchema()->fullName . '.custAnswerDuration' => $this->custAnswerDuration,
            CloudTeleApiLog::getTableSchema()->fullName . '.callStatus' => $this->callStatus,
            CloudTeleApiLog::getTableSchema()->fullName . '.HangupBySourceDetected' => $this->HangupBySourceDetected,
            CloudTeleApiLog::getTableSchema()->fullName . '.totalHoldDuration' => $this->totalHoldDuration,
            CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_connection_status' => $this->upsrlm_connection_status,
            CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_call_status' => $this->upsrlm_call_status,
            CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_call_type' => $this->upsrlm_call_type,
            CloudTeleApiLog::getTableSchema()->fullName . '.project_id' => $this->project_id,
            CloudTeleApiLog::getTableSchema()->fullName . '.created_at' => $this->created_at,
            CloudTeleApiLog::getTableSchema()->fullName . '.created_by' => $this->created_by,
            CloudTeleApiLog::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            CloudTeleApiLog::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_user_mobile_no', $this->upsrlm_user_mobile_no])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.customernumber', $this->customernumber])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.serviceuserid', $this->serviceuserid])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.token', $this->token])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.api_response', $this->api_response])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.api_status', $this->api_status])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.api_message', $this->api_message])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.callid', $this->callid])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.did', $this->did])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.cType', $this->cType])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.CTC', $this->CTC])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.userId', $this->userId])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.cNumber', $this->cNumber])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.masterNumCTC', $this->masterNumCTC])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.masterAgentNumber', $this->masterAgentNumber])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.firstAttended', $this->firstAttended])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.ivrExecuteFlow', $this->ivrExecuteFlow])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.forward', $this->forward])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.totalCreditsUsed', $this->totalCreditsUsed])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.ivrIdArr', $this->ivrIdArr])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.aAnsH', $this->aAnsH])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.aH', $this->aH])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.nH', $this->nH])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.recordings', $this->recordings])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.recording_file', $this->recording_file])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.cliArr', $this->cliArr])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.aHDetail', $this->aHDetail])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.nHDetail', $this->nHDetail])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.full_response', $this->full_response]);

        return $dataProvider;
    }

    public function usearch($params, $user_model = null, $pagination = true, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = CloudTeleApiLog::find();
        if ($columns != NULL) {
            $query->select($columns);
        }
        $query->distinct();
        if (isset($this->from_date_time) && $this->from_date_time != '') {
            $query->andFilterWhere(['>=', CloudTeleApiLog::getTableSchema()->fullName . '.api_request_datetime', $this->from_date_time . ' 00:00:00']);
        }
        if (isset($this->to_date_time) && $this->to_date_time != '') {
            $query->andFilterWhere(['<=', CloudTeleApiLog::getTableSchema()->fullName . '.api_request_datetime', $this->to_date_time . ' 23:59:59']);
        }
        if (isset($this->upsrlm_user_id) && $this->upsrlm_user_id != '') {
            $query->andFilterWhere(['=', CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_user_id', $this->upsrlm_user_id]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            CloudTeleApiLog::getTableSchema()->fullName . '.id' => $this->id,
            CloudTeleApiLog::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_user_id' => $this->upsrlm_user_id,
            CloudTeleApiLog::getTableSchema()->fullName . '.api_status_code' => $this->api_status_code,
            CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_call_scenario' => $this->upsrlm_call_scenario,
            CloudTeleApiLog::getTableSchema()->fullName . '.api_request_datetime' => $this->api_request_datetime,
            CloudTeleApiLog::getTableSchema()->fullName . '.ivrSTime' => $this->ivrSTime,
            CloudTeleApiLog::getTableSchema()->fullName . '.ivrETime' => $this->ivrETime,
            CloudTeleApiLog::getTableSchema()->fullName . '.ivrDuration' => $this->ivrDuration,
            CloudTeleApiLog::getTableSchema()->fullName . '.masterAgent' => $this->masterAgent,
            CloudTeleApiLog::getTableSchema()->fullName . '.masterGroupId' => $this->masterGroupId,
            CloudTeleApiLog::getTableSchema()->fullName . '.talkDuration' => $this->talkDuration,
            CloudTeleApiLog::getTableSchema()->fullName . '.agentOnCallDuration' => $this->agentOnCallDuration,
            CloudTeleApiLog::getTableSchema()->fullName . '.firstAnswerTime' => $this->firstAnswerTime,
            CloudTeleApiLog::getTableSchema()->fullName . '.lastHangupTime' => $this->lastHangupTime,
            CloudTeleApiLog::getTableSchema()->fullName . '.lastFirstDuration' => $this->lastFirstDuration,
            CloudTeleApiLog::getTableSchema()->fullName . '.custAnswerSTime' => $this->custAnswerSTime,
            CloudTeleApiLog::getTableSchema()->fullName . '.custAnswerETime' => $this->custAnswerETime,
            CloudTeleApiLog::getTableSchema()->fullName . '.custAnswerDuration' => $this->custAnswerDuration,
            CloudTeleApiLog::getTableSchema()->fullName . '.callStatus' => $this->callStatus,
            CloudTeleApiLog::getTableSchema()->fullName . '.HangupBySourceDetected' => $this->HangupBySourceDetected,
            CloudTeleApiLog::getTableSchema()->fullName . '.totalHoldDuration' => $this->totalHoldDuration,
            CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_connection_status' => $this->upsrlm_connection_status,
            CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_call_status' => $this->upsrlm_call_status,
            CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_call_type' => $this->upsrlm_call_type,
            CloudTeleApiLog::getTableSchema()->fullName . '.created_at' => $this->created_at,
            CloudTeleApiLog::getTableSchema()->fullName . '.created_by' => $this->created_by,
            CloudTeleApiLog::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            CloudTeleApiLog::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.upsrlm_user_mobile_no', $this->upsrlm_user_mobile_no])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.customernumber', $this->customernumber])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.serviceuserid', $this->serviceuserid])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.token', $this->token])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.api_response', $this->api_response])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.api_status', $this->api_status])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.api_message', $this->api_message])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.callid', $this->callid])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.did', $this->did])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.cType', $this->cType])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.CTC', $this->CTC])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.userId', $this->userId])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.cNumber', $this->cNumber])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.masterNumCTC', $this->masterNumCTC])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.masterAgentNumber', $this->masterAgentNumber])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.firstAttended', $this->firstAttended])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.ivrExecuteFlow', $this->ivrExecuteFlow])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.forward', $this->forward])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.totalCreditsUsed', $this->totalCreditsUsed])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.ivrIdArr', $this->ivrIdArr])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.aAnsH', $this->aAnsH])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.aH', $this->aH])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.nH', $this->nH])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.recordings', $this->recordings])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.recording_file', $this->recording_file])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.cliArr', $this->cliArr])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.aHDetail', $this->aHDetail])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.nHDetail', $this->nHDetail])
                ->andFilterWhere(['like', CloudTeleApiLog::getTableSchema()->fullName . '.full_response', $this->full_response]);

        return $dataProvider;
    }

}
