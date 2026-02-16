<?php

namespace common\models\dynamicdb\support;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\support\ConversationStatus;

/**
 * ConversationStatusSearch represents the model behind the search form of `common\models\dynamicdb\support\ConversationStatus`.
 */
class ConversationStatusSearch extends ConversationStatus
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'stakeholder_code'], 'integer'],
            [['conversation_code', 'task_code', 'currernt_status', 'reason_for_Incomplete_task', 'status_comments'], 'safe'],
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
        $query = ConversationStatus::find();

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
            'stakeholder_code' => $this->stakeholder_code,
        ]);

        $query->andFilterWhere(['like', 'conversation_code', $this->conversation_code])
            ->andFilterWhere(['like', 'task_code', $this->task_code])
            ->andFilterWhere(['like', 'currernt_status', $this->currernt_status])
            ->andFilterWhere(['like', 'reason_for_Incomplete_task', $this->reason_for_Incomplete_task])
            ->andFilterWhere(['like', 'status_comments', $this->status_comments]);

        return $dataProvider;
    }
}
