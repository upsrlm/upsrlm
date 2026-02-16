<?php

namespace common\models\dynamicdb\internalcallcenter;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiLog;

/**
 * CloudTeleApiLogSearch represents the model behind the search form of `common\models\dynamicdb\internalcallcenter\CloudTeleApiLog`.
 */
class DyCloudTeleApiLogSearch extends CloudTeleApiLog {

    public $api_call_status_option = [];
    public $api_status_code_option = [];
    public $upsrlm_connection_status_option = [];
    public $upsrlm_call_status_option = [];
    public $upsrlm_call_scenario_option = [];
    public $month_option = [];
    public $from_date_time;
    public $to_date_time;
    public $upsrlm_user_group;
    public $month;
    public $date;
    public $tables = 'cloud_tele_api_log';

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'bc_application_id', 'cbo_shg_id', 'upsrlm_call_scenario', 'upsrlm_user_id', 'api_status_code', 'ivrDuration', 'masterAgent', 'masterGroupId', 'talkDuration', 'agentOnCallDuration', 'lastFirstDuration', 'custAnswerDuration', 'callStatus', 'HangupBySourceDetected', 'totalHoldDuration', 'upsrlm_connection_status', 'upsrlm_call_status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'safe'],
            [['upsrlm_user_mobile_no', 'customernumber', 'serviceuserid', 'token', 'api_response', 'api_status', 'api_message', 'api_request_datetime', 'callid', 'did', 'cType', 'CTC', 'ivrSTime', 'ivrETime', 'userId', 'cNumber', 'masterNumCTC', 'masterAgentNumber', 'firstAttended', 'firstAnswerTime', 'lastHangupTime', 'custAnswerSTime', 'custAnswerETime', 'ivrExecuteFlow', 'forward', 'totalCreditsUsed', 'ivrIdArr', 'aAnsH', 'aH', 'nH', 'recordings', 'recording_file', 'cliArr', 'aHDetail', 'nHDetail', 'full_response', 'upsrlm_call_type'], 'safe'],
            [['from_date_time', 'to_date_time'], 'safe'],
            [['month'], 'safe'],
            [['upsrlm_user_role'], 'safe'],
            [['date'], 'safe'],
            [['date', 'project_id'], 'safe'],
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
        $q = new CloudTeleApiLog();
        if (isset($this->date) && $this->date != '') {
            if (date("my", strtotime($this->date)) == date("my")) {
                
            } else {
                $tableSchema = \Yii::$app->dbinternalcallcenter->schema->getTableSchema($this->tables . '_' . date("Ym", strtotime($this->date)));
                if ($tableSchema !== null) {
                    $q = new CloudTeleApiLog($this->tables . '_' . date("Ym", strtotime($this->date)));
                }
            }
        }
        if (isset($this->month) && $this->month != '') {
            if (date("my", strtotime($this->month)) == date("my")) {
                
            } else {
                $tableSchema = \Yii::$app->dbinternalcallcenter->schema->getTableSchema($this->tables . '_' . date("Ym", strtotime($this->month)));
                if ($tableSchema !== null) {
                    $q = new CloudTeleApiLog($this->tables . '_' . date("Ym", strtotime($this->month)));
                }
            }
        }
        $query = $q->find();
        if ($columns != NULL) {
            $query->select($columns);
        }

        if (isset($this->from_date_time) && $this->from_date_time != '') {
            $query->andFilterWhere(['>=', 'api_request_datetime', $this->from_date_time . ' 00:00:00']);
        }
        if (isset($this->to_date_time) && $this->to_date_time != '') {
            $query->andFilterWhere(['<=', 'api_request_datetime', $this->to_date_time . ' 23:59:59']);
        }
        if (isset($this->date) && $this->date != '') {
            $query->andFilterWhere(['>=', 'api_request_datetime', $this->date . ' 00:00:00']);
        }
        if (isset($this->date) && $this->date != '') {
            $query->andFilterWhere(['<=', 'api_request_datetime', $this->date . ' 23:59:59']);
        }
        if (isset($this->upsrlm_user_id) && $this->upsrlm_user_id != '') {
            $query->andFilterWhere(['=', 'upsrlm_user_id', $this->upsrlm_user_id]);
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
            'id' => $this->id,
            'bc_application_id' => $this->bc_application_id,
            'cbo_shg_id' => $this->cbo_shg_id,
            'upsrlm_user_id' => $this->upsrlm_user_id,
            'upsrlm_user_role' => $this->upsrlm_user_role,
            'api_status_code' => $this->api_status_code,
            'upsrlm_call_scenario' => $this->upsrlm_call_scenario,
            'api_request_datetime' => $this->api_request_datetime,
            'ivrSTime' => $this->ivrSTime,
            'ivrETime' => $this->ivrETime,
            'ivrDuration' => $this->ivrDuration,
            'masterAgent' => $this->masterAgent,
            'masterGroupId' => $this->masterGroupId,
            'talkDuration' => $this->talkDuration,
            'agentOnCallDuration' => $this->agentOnCallDuration,
            'firstAnswerTime' => $this->firstAnswerTime,
            'lastHangupTime' => $this->lastHangupTime,
            'lastFirstDuration' => $this->lastFirstDuration,
            'custAnswerSTime' => $this->custAnswerSTime,
            'custAnswerETime' => $this->custAnswerETime,
            'custAnswerDuration' => $this->custAnswerDuration,
            'callStatus' => $this->callStatus,
            'HangupBySourceDetected' => $this->HangupBySourceDetected,
            'totalHoldDuration' => $this->totalHoldDuration,
            'upsrlm_connection_status' => $this->upsrlm_connection_status,
            'upsrlm_call_status' => $this->upsrlm_call_status,
            'upsrlm_call_type' => $this->upsrlm_call_type,
            'project_id' => $this->project_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'upsrlm_user_mobile_no', $this->upsrlm_user_mobile_no])
                ->andFilterWhere(['like', 'customernumber', $this->customernumber])
                ->andFilterWhere(['like', 'serviceuserid', $this->serviceuserid])
                ->andFilterWhere(['like', 'token', $this->token])
                ->andFilterWhere(['like', 'api_response', $this->api_response])
                ->andFilterWhere(['like', 'api_status', $this->api_status])
                ->andFilterWhere(['like', 'api_message', $this->api_message])
                ->andFilterWhere(['like', 'callid', $this->callid])
                ->andFilterWhere(['like', 'did', $this->did])
                ->andFilterWhere(['like', 'cType', $this->cType])
                ->andFilterWhere(['like', 'CTC', $this->CTC])
                ->andFilterWhere(['like', 'userId', $this->userId])
                ->andFilterWhere(['like', 'cNumber', $this->cNumber])
                ->andFilterWhere(['like', 'masterNumCTC', $this->masterNumCTC])
                ->andFilterWhere(['like', 'masterAgentNumber', $this->masterAgentNumber])
                ->andFilterWhere(['like', 'firstAttended', $this->firstAttended])
                ->andFilterWhere(['like', 'ivrExecuteFlow', $this->ivrExecuteFlow])
                ->andFilterWhere(['like', 'forward', $this->forward])
                ->andFilterWhere(['like', 'totalCreditsUsed', $this->totalCreditsUsed])
                ->andFilterWhere(['like', 'ivrIdArr', $this->ivrIdArr])
                ->andFilterWhere(['like', 'aAnsH', $this->aAnsH])
                ->andFilterWhere(['like', 'aH', $this->aH])
                ->andFilterWhere(['like', 'nH', $this->nH])
                ->andFilterWhere(['like', 'recordings', $this->recordings])
                ->andFilterWhere(['like', 'recording_file', $this->recording_file])
                ->andFilterWhere(['like', 'cliArr', $this->cliArr])
                ->andFilterWhere(['like', 'aHDetail', $this->aHDetail])
                ->andFilterWhere(['like', 'nHDetail', $this->nHDetail])
                ->andFilterWhere(['like', 'full_response', $this->full_response]);

        return $dataProvider;
    }
     public function searchigrs($params, $user_model = null, $pagination = true, $columns = null, $distinct = false) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $q = new CloudTeleApiLog();
        if (isset($this->date) && $this->date != '') {
            if (date("my", strtotime($this->date)) == date("my")) {
                
            } else {
                $tableSchema = \Yii::$app->dbinternalcallcenter->schema->getTableSchema($this->tables . '_' . date("Ym", strtotime($this->date)));
                if ($tableSchema !== null) {
                    $q = new CloudTeleApiLog($this->tables . '_' . date("Ym", strtotime($this->date)));
                }
            }
        }
        if (isset($this->month) && $this->month != '') {
            if (date("my", strtotime($this->month)) == date("my")) {
                
            } else {
                $tableSchema = \Yii::$app->dbinternalcallcenter->schema->getTableSchema($this->tables . '_' . date("Ym", strtotime($this->month)));
                if ($tableSchema !== null) {
                    $q = new CloudTeleApiLog($this->tables . '_' . date("Ym", strtotime($this->month)));
                }
            }
        }
        $query = $q->find();
        if ($columns != NULL) {
            $query->select($columns);
        }

        if (isset($this->from_date_time) && $this->from_date_time != '') {
            $query->andFilterWhere(['>=', 'api_request_datetime', $this->from_date_time . ' 00:00:00']);
        }
        if (isset($this->to_date_time) && $this->to_date_time != '') {
            $query->andFilterWhere(['<=', 'api_request_datetime', $this->to_date_time . ' 23:59:59']);
        }
        if (isset($this->date) && $this->date != '') {
            $query->andFilterWhere(['>=', 'api_request_datetime', $this->date . ' 00:00:00']);
        }
        if (isset($this->date) && $this->date != '') {
            $query->andFilterWhere(['<=', 'api_request_datetime', $this->date . ' 23:59:59']);
        }
        if (isset($this->upsrlm_user_id) && $this->upsrlm_user_id != '') {
            $query->andFilterWhere(['=', 'upsrlm_user_id', $this->upsrlm_user_id]);
        }
        $query->andWhere(['upsrlm_user_mobile_no' => \Yii::$app->params['igrs_mobile']]);
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
            'id' => $this->id,
            'bc_application_id' => $this->bc_application_id,
            'cbo_shg_id' => $this->cbo_shg_id,
            'upsrlm_user_id' => $this->upsrlm_user_id,
            'upsrlm_user_role' => $this->upsrlm_user_role,
            'api_status_code' => $this->api_status_code,
            'upsrlm_call_scenario' => $this->upsrlm_call_scenario,
            'api_request_datetime' => $this->api_request_datetime,
            'ivrSTime' => $this->ivrSTime,
            'ivrETime' => $this->ivrETime,
            'ivrDuration' => $this->ivrDuration,
            'masterAgent' => $this->masterAgent,
            'masterGroupId' => $this->masterGroupId,
            'talkDuration' => $this->talkDuration,
            'agentOnCallDuration' => $this->agentOnCallDuration,
            'firstAnswerTime' => $this->firstAnswerTime,
            'lastHangupTime' => $this->lastHangupTime,
            'lastFirstDuration' => $this->lastFirstDuration,
            'custAnswerSTime' => $this->custAnswerSTime,
            'custAnswerETime' => $this->custAnswerETime,
            'custAnswerDuration' => $this->custAnswerDuration,
            'callStatus' => $this->callStatus,
            'HangupBySourceDetected' => $this->HangupBySourceDetected,
            'totalHoldDuration' => $this->totalHoldDuration,
            'upsrlm_connection_status' => $this->upsrlm_connection_status,
            'upsrlm_call_status' => $this->upsrlm_call_status,
            'upsrlm_call_type' => $this->upsrlm_call_type,
            'upsrlm_user_mobile_no'=>$this->upsrlm_user_mobile_no,
            'project_id' => $this->project_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'customernumber', $this->customernumber])
                ->andFilterWhere(['like', 'customernumber', $this->customernumber])
                ->andFilterWhere(['like', 'serviceuserid', $this->serviceuserid])
                ->andFilterWhere(['like', 'token', $this->token])
                ->andFilterWhere(['like', 'api_response', $this->api_response])
                ->andFilterWhere(['like', 'api_status', $this->api_status])
                ->andFilterWhere(['like', 'api_message', $this->api_message])
                ->andFilterWhere(['like', 'callid', $this->callid])
                ->andFilterWhere(['like', 'did', $this->did])
                ->andFilterWhere(['like', 'cType', $this->cType])
                ->andFilterWhere(['like', 'CTC', $this->CTC])
                ->andFilterWhere(['like', 'userId', $this->userId])
                ->andFilterWhere(['like', 'cNumber', $this->cNumber])
                ->andFilterWhere(['like', 'masterNumCTC', $this->masterNumCTC])
                ->andFilterWhere(['like', 'masterAgentNumber', $this->masterAgentNumber])
                ->andFilterWhere(['like', 'firstAttended', $this->firstAttended])
                ->andFilterWhere(['like', 'ivrExecuteFlow', $this->ivrExecuteFlow])
                ->andFilterWhere(['like', 'forward', $this->forward])
                ->andFilterWhere(['like', 'totalCreditsUsed', $this->totalCreditsUsed])
                ->andFilterWhere(['like', 'ivrIdArr', $this->ivrIdArr])
                ->andFilterWhere(['like', 'aAnsH', $this->aAnsH])
                ->andFilterWhere(['like', 'aH', $this->aH])
                ->andFilterWhere(['like', 'nH', $this->nH])
                ->andFilterWhere(['like', 'recordings', $this->recordings])
                ->andFilterWhere(['like', 'recording_file', $this->recording_file])
                ->andFilterWhere(['like', 'cliArr', $this->cliArr])
                ->andFilterWhere(['like', 'aHDetail', $this->aHDetail])
                ->andFilterWhere(['like', 'nHDetail', $this->nHDetail])
                ->andFilterWhere(['like', 'full_response', $this->full_response]);

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
            $query->andFilterWhere(['>=', 'api_request_datetime', $this->from_date_time . ' 00:00:00']);
        }
        if (isset($this->to_date_time) && $this->to_date_time != '') {
            $query->andFilterWhere(['<=', 'api_request_datetime', $this->to_date_time . ' 23:59:59']);
        }
        if (isset($this->upsrlm_user_id) && $this->upsrlm_user_id != '') {
            $query->andFilterWhere(['=', 'upsrlm_user_id', $this->upsrlm_user_id]);
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
            'id' => $this->id,
            'bc_application_id' => $this->bc_application_id,
            'upsrlm_user_id' => $this->upsrlm_user_id,
            'api_status_code' => $this->api_status_code,
            'upsrlm_call_scenario' => $this->upsrlm_call_scenario,
            'api_request_datetime' => $this->api_request_datetime,
            'ivrSTime' => $this->ivrSTime,
            'ivrETime' => $this->ivrETime,
            'ivrDuration' => $this->ivrDuration,
            'masterAgent' => $this->masterAgent,
            'masterGroupId' => $this->masterGroupId,
            'talkDuration' => $this->talkDuration,
            'agentOnCallDuration' => $this->agentOnCallDuration,
            'firstAnswerTime' => $this->firstAnswerTime,
            'lastHangupTime' => $this->lastHangupTime,
            'lastFirstDuration' => $this->lastFirstDuration,
            'custAnswerSTime' => $this->custAnswerSTime,
            'custAnswerETime' => $this->custAnswerETime,
            'custAnswerDuration' => $this->custAnswerDuration,
            'callStatus' => $this->callStatus,
            'HangupBySourceDetected' => $this->HangupBySourceDetected,
            'totalHoldDuration' => $this->totalHoldDuration,
            'upsrlm_connection_status' => $this->upsrlm_connection_status,
            'upsrlm_call_status' => $this->upsrlm_call_status,
            'upsrlm_call_type' => $this->upsrlm_call_type,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'upsrlm_user_mobile_no', $this->upsrlm_user_mobile_no])
                ->andFilterWhere(['like', 'customernumber', $this->customernumber])
                ->andFilterWhere(['like', 'serviceuserid', $this->serviceuserid])
                ->andFilterWhere(['like', 'token', $this->token])
                ->andFilterWhere(['like', 'api_response', $this->api_response])
                ->andFilterWhere(['like', 'api_status', $this->api_status])
                ->andFilterWhere(['like', 'api_message', $this->api_message])
                ->andFilterWhere(['like', 'callid', $this->callid])
                ->andFilterWhere(['like', 'did', $this->did])
                ->andFilterWhere(['like', 'cType', $this->cType])
                ->andFilterWhere(['like', 'CTC', $this->CTC])
                ->andFilterWhere(['like', 'userId', $this->userId])
                ->andFilterWhere(['like', 'cNumber', $this->cNumber])
                ->andFilterWhere(['like', 'masterNumCTC', $this->masterNumCTC])
                ->andFilterWhere(['like', 'masterAgentNumber', $this->masterAgentNumber])
                ->andFilterWhere(['like', 'firstAttended', $this->firstAttended])
                ->andFilterWhere(['like', 'ivrExecuteFlow', $this->ivrExecuteFlow])
                ->andFilterWhere(['like', 'forward', $this->forward])
                ->andFilterWhere(['like', 'totalCreditsUsed', $this->totalCreditsUsed])
                ->andFilterWhere(['like', 'ivrIdArr', $this->ivrIdArr])
                ->andFilterWhere(['like', 'aAnsH', $this->aAnsH])
                ->andFilterWhere(['like', 'aH', $this->aH])
                ->andFilterWhere(['like', 'nH', $this->nH])
                ->andFilterWhere(['like', 'recordings', $this->recordings])
                ->andFilterWhere(['like', 'recording_file', $this->recording_file])
                ->andFilterWhere(['like', 'cliArr', $this->cliArr])
                ->andFilterWhere(['like', 'aHDetail', $this->aHDetail])
                ->andFilterWhere(['like', 'nHDetail', $this->nHDetail])
                ->andFilterWhere(['like', 'full_response', $this->full_response]);

        return $dataProvider;
    }

    public function SetDate() {
        if (isset($this->month)) {
            $this->from_date_time = $this->month;
            $this->to_date_time = \DateTime::createFromFormat("Y-m-d", $this->month)->format("Y-m-t");
        }
    }

}
