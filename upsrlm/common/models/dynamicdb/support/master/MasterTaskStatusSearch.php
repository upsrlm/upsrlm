<?php

namespace common\models\dynamicdb\support\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\support\master\MasterTaskStatus;

/**
 * MasterTaskStatusSearch represents the model behind the search form of `common\models\dynamicdb\support\master\MasterTaskStatus`.
 */
class MasterTaskStatusSearch extends MasterTaskStatus
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sr_no', 'status_code', 'task_status_name'], 'safe'],
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
        $query = MasterTaskStatus::find();

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
        $query->andFilterWhere(['like', 'sr_no', $this->sr_no])
            ->andFilterWhere(['like', 'status_code', $this->status_code])
            ->andFilterWhere(['like', 'task_status_name', $this->task_status_name]);

        return $dataProvider;
    }
}
