<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\internalcallcenter\platform\MissedCall;

/**
 * MissedCallSearch represents the model behind the search form of `common\models\dynamicdb\internalcallcenter\platform\MissedCall`.
 */
class MissedCallSearch extends MissedCall
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bcid', 'wadaid', 'user_id', 'rishta_member_id', 'hhs_id', 'role', 'no_attempt_call', 'no_talk', 'call_attempt_after_missed', 'log_id', 'project_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['customernumber', 'name', 'address', 'role_name', 'api_request_datetime', 'date', 'first_call', 'last_call'], 'safe'],
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
        $query = MissedCall::find();

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
            'bcid' => $this->bcid,
            'wadaid' => $this->wadaid,
            'user_id' => $this->user_id,
            'rishta_member_id' => $this->rishta_member_id,
            'hhs_id' => $this->hhs_id,
            'role' => $this->role,
            'api_request_datetime' => $this->api_request_datetime,
            'date' => $this->date,
            'no_attempt_call' => $this->no_attempt_call,
            'no_talk' => $this->no_talk,
            'first_call' => $this->first_call,
            'last_call' => $this->last_call,
            'call_attempt_after_missed' => $this->call_attempt_after_missed,
            'log_id' => $this->log_id,
            'project_id' => $this->project_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'customernumber', $this->customernumber])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'role_name', $this->role_name]);

        return $dataProvider;
    }
}
