<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\internalcallcenter\platform\UltraCallingAgentProgressIbd;

/**
 * UltraCallingAgentProgressIbdSearch represents the model behind the search form of `common\models\dynamicdb\internalcallcenter\platform\UltraCallingAgentProgressIbd`.
 */
class UltraCallingAgentProgressIbdSearch extends UltraCallingAgentProgressIbd
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'calling_agent_id', 'calling_agent_role', 'work_hour', 'ibd_call', 'achieve', 'agent_call_recived', 'both_answered', 'from_unanswered', 'talk_duration', 'ivr_duration', 'created_at', 'updated_at', 'status'], 'integer'],
            [['calling_agent_name', 'calling_date', 'start_time', 'end_time'], 'safe'],
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
        $query = UltraCallingAgentProgressIbd::find();

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
            'ibd_call' => $this->ibd_call,
            'achieve' => $this->achieve,
            'agent_call_recived' => $this->agent_call_recived,
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
}
