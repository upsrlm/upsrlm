<?php

namespace common\models\dynamicdb\internalcallcenter;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\internalcallcenter\CloudTeleUserReport;
use common\models\master\MasterRole;

/**
 * CloudTeleUserReportSearch represents the model behind the search form of `common\models\dynamicdb\internalcallcenter\CloudTeleUserReport`.
 */
class CloudTeleUserReportSearch extends CloudTeleUserReport {

    public $user_option = [];
    public $from_date;
    public $to_date;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'user_id', 'role', 'no_of_call', 'no_of_call_success', 'total_call_duration', 'api_status_code0', 'api_status_code200', 'api_status_code111', 'api_status_code150', 'api_call_status3', 'api_call_status4', 'api_call_status5', 'api_call_status6', 'api_call_status7', 'api_call_status8', 'api_call_status9', 'api_call_status10', 'api_call_status11', 'api_call_status12', 'api_call_status13', 'api_call_status14', 'api_call_status15', 'api_call_status16', 'upsrlm_call_status10', 'upsrlm_call_status11', 'upsrlm_call_status12', 'upsrlm_call_status13', 'upsrlm_connection_status1', 'upsrlm_connection_status21', 'upsrlm_connection_status22', 'upsrlm_connection_status23', 'upsrlm_connection_status24', 'upsrlm_connection_status30', 'last_updated_at'], 'safe'],
            [['date', 'start_time', 'end_time'], 'safe'],
            [['from_date', 'to_date'], 'safe'],
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
        $query = CloudTeleUserReport::find();
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
                
            } else {
                $query->andFilterWhere(['=', CloudTeleUserReport::getTableSchema()->fullName . '.user_id', $user_model->id]);
            }
        }
        if (isset($this->from_date) && $this->from_date != '') {
            $query->andFilterWhere(['>=', CloudTeleUserReport::getTableSchema()->fullName . '.date', $this->from_date]);
        }
        if (isset($this->to_date) && $this->to_date != '') {
            $query->andFilterWhere(['<=', CloudTeleUserReport::getTableSchema()->fullName . '.date', $this->to_date]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['date' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            CloudTeleUserReport::getTableSchema()->fullName . '.id' => $this->id,
            CloudTeleUserReport::getTableSchema()->fullName . '.user_id' => $this->user_id,
            CloudTeleUserReport::getTableSchema()->fullName . '.role' => $this->role,
            CloudTeleUserReport::getTableSchema()->fullName . '.date' => $this->date,
            CloudTeleUserReport::getTableSchema()->fullName . '.start_time' => $this->start_time,
            CloudTeleUserReport::getTableSchema()->fullName . '.end_time' => $this->end_time,
            CloudTeleUserReport::getTableSchema()->fullName . '.no_of_call' => $this->no_of_call,
            CloudTeleUserReport::getTableSchema()->fullName . '.no_of_call_success' => $this->no_of_call_success,
            CloudTeleUserReport::getTableSchema()->fullName . '.total_call_duration' => $this->total_call_duration,
            CloudTeleUserReport::getTableSchema()->fullName . '.api_status_code0' => $this->api_status_code0,
            CloudTeleUserReport::getTableSchema()->fullName . '.api_status_code200' => $this->api_status_code200,
            CloudTeleUserReport::getTableSchema()->fullName . '.api_status_code111' => $this->api_status_code111,
            CloudTeleUserReport::getTableSchema()->fullName . '.api_status_code150' => $this->api_status_code150,
            CloudTeleUserReport::getTableSchema()->fullName . '.api_call_status3' => $this->api_call_status3,
            CloudTeleUserReport::getTableSchema()->fullName . '.api_call_status4' => $this->api_call_status4,
            CloudTeleUserReport::getTableSchema()->fullName . '.api_call_status5' => $this->api_call_status5,
            CloudTeleUserReport::getTableSchema()->fullName . '.api_call_status6' => $this->api_call_status6,
            CloudTeleUserReport::getTableSchema()->fullName . '.api_call_status7' => $this->api_call_status7,
            CloudTeleUserReport::getTableSchema()->fullName . '.api_call_status8' => $this->api_call_status8,
            CloudTeleUserReport::getTableSchema()->fullName . '.api_call_status9' => $this->api_call_status9,
            CloudTeleUserReport::getTableSchema()->fullName . '.api_call_status10' => $this->api_call_status10,
            CloudTeleUserReport::getTableSchema()->fullName . '.api_call_status11' => $this->api_call_status11,
            CloudTeleUserReport::getTableSchema()->fullName . '.api_call_status12' => $this->api_call_status12,
            CloudTeleUserReport::getTableSchema()->fullName . '.api_call_status13' => $this->api_call_status13,
            CloudTeleUserReport::getTableSchema()->fullName . '.api_call_status14' => $this->api_call_status14,
            CloudTeleUserReport::getTableSchema()->fullName . '.api_call_status15' => $this->api_call_status15,
            CloudTeleUserReport::getTableSchema()->fullName . '.api_call_status16' => $this->api_call_status16,
            CloudTeleUserReport::getTableSchema()->fullName . '.upsrlm_call_status10' => $this->upsrlm_call_status10,
            CloudTeleUserReport::getTableSchema()->fullName . '.upsrlm_call_status11' => $this->upsrlm_call_status11,
            CloudTeleUserReport::getTableSchema()->fullName . '.upsrlm_call_status12' => $this->upsrlm_call_status12,
            CloudTeleUserReport::getTableSchema()->fullName . '.upsrlm_call_status13' => $this->upsrlm_call_status13,
            CloudTeleUserReport::getTableSchema()->fullName . '.upsrlm_connection_status1' => $this->upsrlm_connection_status1,
            CloudTeleUserReport::getTableSchema()->fullName . '.upsrlm_connection_status21' => $this->upsrlm_connection_status21,
            CloudTeleUserReport::getTableSchema()->fullName . '.upsrlm_connection_status22' => $this->upsrlm_connection_status22,
            CloudTeleUserReport::getTableSchema()->fullName . '.upsrlm_connection_status23' => $this->upsrlm_connection_status23,
            CloudTeleUserReport::getTableSchema()->fullName . '.upsrlm_connection_status24' => $this->upsrlm_connection_status24,
            CloudTeleUserReport::getTableSchema()->fullName . '.upsrlm_connection_status30' => $this->upsrlm_connection_status30,
            CloudTeleUserReport::getTableSchema()->fullName . '.last_updated_at' => $this->last_updated_at,
        ]);

        return $dataProvider;
    }

}
