<?php

namespace common\models\dynamicdb\internalcallcenter;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiCall;

/**
 * CloudTeleApiCallSearch represents the model behind the search form of `common\models\dynamicdb\internalcallcenter\CloudTeleApiCall`.
 */
class CloudTeleApiCallSearch extends CloudTeleApiCall {

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
            [['id', 'cloud_tele_api_log', 'bc_application_id', 'upsrlm_user_id', 'upsrlm_user_role', 'cbo_shg_id', 'api_status_code', 'ivrDuration', 'masterGroupId', 'talkDuration', 'agentOnCallDuration', 'lastFirstDuration', 'custAnswerDuration', 'callStatus', 'totalHoldDuration', 'upsrlm_agent_call_received', 'upsrlm_connection_status', 'upsrlm_call_status', 'upsrlm_call_quality', 'upsrlm_call_outcome', 'upsrlm_call_again', 'smart_phone_whose', 'upsrlm_call_type', 'upsrlm_call_scenario', 'calling_list_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'safe'],
            [['upsrlm_user_mobile_no', 'customernumber', 'api_request_datetime'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = CloudTeleApiCall::find();
        if ($columns != NULL) {
            $query->select($columns);
        }
        if (isset($this->from_date_time) && $this->from_date_time != '') {
            $query->andFilterWhere(['>=', CloudTeleApiCall::getTableSchema()->fullName . '.api_request_datetime', $this->from_date_time . ' 00:00:00']);
        }
        if (isset($this->to_date_time) && $this->to_date_time != '') {
            $query->andFilterWhere(['<=', CloudTeleApiCall::getTableSchema()->fullName . '.api_request_datetime', $this->to_date_time . ' 23:59:59']);
        }
        if (isset($this->upsrlm_user_id) && $this->upsrlm_user_id != '') {
            $query->andFilterWhere(['=', CloudTeleApiCall::getTableSchema()->fullName . '.upsrlm_user_id', $this->upsrlm_user_id]);
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

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            CloudTeleApiCall::getTableSchema()->fullName . '.id' => $this->id,
            CloudTeleApiCall::getTableSchema()->fullName . '.cloud_tele_api_log' => $this->cloud_tele_api_log,
            CloudTeleApiCall::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            CloudTeleApiCall::getTableSchema()->fullName . '.upsrlm_user_id' => $this->upsrlm_user_id,
            CloudTeleApiCall::getTableSchema()->fullName . '.upsrlm_user_role' => $this->upsrlm_user_role,
            CloudTeleApiCall::getTableSchema()->fullName . '.cbo_shg_id' => $this->cbo_shg_id,
            CloudTeleApiCall::getTableSchema()->fullName . '.api_status_code' => $this->api_status_code,
            CloudTeleApiCall::getTableSchema()->fullName . '.api_request_datetime' => $this->api_request_datetime,
            CloudTeleApiCall::getTableSchema()->fullName . '.ivrDuration' => $this->ivrDuration,
            CloudTeleApiCall::getTableSchema()->fullName . '.masterGroupId' => $this->masterGroupId,
            CloudTeleApiCall::getTableSchema()->fullName . '.talkDuration' => $this->talkDuration,
            CloudTeleApiCall::getTableSchema()->fullName . '.agentOnCallDuration' => $this->agentOnCallDuration,
            CloudTeleApiCall::getTableSchema()->fullName . '.lastFirstDuration' => $this->lastFirstDuration,
            CloudTeleApiCall::getTableSchema()->fullName . '.custAnswerDuration' => $this->custAnswerDuration,
            CloudTeleApiCall::getTableSchema()->fullName . '.callStatus' => $this->callStatus,
            CloudTeleApiCall::getTableSchema()->fullName . '.totalHoldDuration' => $this->totalHoldDuration,
            CloudTeleApiCall::getTableSchema()->fullName . '.upsrlm_agent_call_received' => $this->upsrlm_agent_call_received,
            CloudTeleApiCall::getTableSchema()->fullName . '.upsrlm_connection_status' => $this->upsrlm_connection_status,
            CloudTeleApiCall::getTableSchema()->fullName . '.upsrlm_call_status' => $this->upsrlm_call_status,
            CloudTeleApiCall::getTableSchema()->fullName . '.upsrlm_call_quality' => $this->upsrlm_call_quality,
            CloudTeleApiCall::getTableSchema()->fullName . '.upsrlm_call_outcome' => $this->upsrlm_call_outcome,
            CloudTeleApiCall::getTableSchema()->fullName . '.upsrlm_call_again' => $this->upsrlm_call_again,
            CloudTeleApiCall::getTableSchema()->fullName . '.smart_phone_whose' => $this->smart_phone_whose,
            CloudTeleApiCall::getTableSchema()->fullName . '.upsrlm_call_type' => $this->upsrlm_call_type,
            CloudTeleApiCall::getTableSchema()->fullName . '.upsrlm_call_scenario' => $this->upsrlm_call_scenario,
            CloudTeleApiCall::getTableSchema()->fullName . '.calling_list_id' => $this->calling_list_id,
            CloudTeleApiCall::getTableSchema()->fullName . '.created_at' => $this->created_at,
            CloudTeleApiCall::getTableSchema()->fullName . '.created_by' => $this->created_by,
            CloudTeleApiCall::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            CloudTeleApiCall::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', CloudTeleApiCall::getTableSchema()->fullName . '.upsrlm_user_mobile_no', $this->upsrlm_user_mobile_no])
                ->andFilterWhere(['like', CloudTeleApiCall::getTableSchema()->fullName . '.customernumber', $this->customernumber]);

        return $dataProvider;
    }

}
