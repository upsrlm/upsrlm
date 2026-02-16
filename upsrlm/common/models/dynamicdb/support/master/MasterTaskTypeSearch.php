<?php

namespace common\models\dynamicdb\support\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\support\master\MasterTaskType;

/**
 * MasterTaskTypeSearch represents the model behind the search form of `common\models\dynamicdb\support\master\MasterTaskType`.
 */
class MasterTaskTypeSearch extends MasterTaskType
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sr_no', 'stakeholder_category_code'], 'integer'],
            [['task_type_code', 'task_type_name', 'current_status'], 'safe'],
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
        $query = MasterTaskType::find();

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
            'sr_no' => $this->sr_no,
            'stakeholder_category_code' => $this->stakeholder_category_code,
        ]);

        $query->andFilterWhere(['like', 'task_type_code', $this->task_type_code])
            ->andFilterWhere(['like', 'task_type_name', $this->task_type_name])
            ->andFilterWhere(['like', 'current_status', $this->current_status]);

        return $dataProvider;
    }
}
