<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme\feedback;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\dbt\scheme\feedback\DbtSchemeBocwMaternityFeedback;

/**
 * DbtSchemeBocwMaternityFeedbackSearch represents the model behind the search form of `common\models\dynamicdb\cbo_detail\dbt\scheme\feedback\DbtSchemeBocwMaternityFeedback`.
 */
class DbtSchemeBocwMaternityFeedbackSearch extends DbtSchemeBocwMaternityFeedback
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'ques1', 'ques2', 'ques3', 'ques4', 'ques5', 'ques6', 'ques7', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'integer'],
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
        $query = DbtSchemeBocwMaternityFeedback::find();

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
            'user_id' => $this->user_id,
            'ques1' => $this->ques1,
            'ques2' => $this->ques2,
            'ques3' => $this->ques3,
            'ques4' => $this->ques4,
            'ques5' => $this->ques5,
            'ques6' => $this->ques6,
            'ques7' => $this->ques7,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
