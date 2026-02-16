<?php

namespace common\models\dynamicdb\support\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\support\master\MasterTaskStatusReason;

/**
 * MasterTaskStatusReasonSearch represents the model behind the search form of `common\models\dynamicdb\support\master\MasterTaskStatusReason`.
 */
class MasterTaskStatusReasonSearch extends MasterTaskStatusReason
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reason_code', 'status_code', 'task_type_code', 'reason_for_Incomplete_task'], 'safe'],
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
        $query = MasterTaskStatusReason::find();

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
        $query->andFilterWhere(['like', 'reason_code', $this->reason_code])
            ->andFilterWhere(['like', 'status_code', $this->status_code])
            ->andFilterWhere(['like', 'task_type_code', $this->task_type_code])
            ->andFilterWhere(['like', 'reason_for_Incomplete_task', $this->reason_for_Incomplete_task]);

        return $dataProvider;
    }
}
