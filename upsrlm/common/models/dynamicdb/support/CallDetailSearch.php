<?php

namespace common\models\dynamicdb\support;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\support\CallDetail;

/**
 * CallDetailSearch represents the model behind the search form of `common\models\dynamicdb\support\CallDetail`.
 */
class CallDetailSearch extends CallDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'call_duration'], 'integer'],
            [['call_date', 'call_type', 'calling_no', 'call_start', 'cc_executive_code', 'cc_executive_name'], 'safe'],
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
        $query = CallDetail::find();

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
            'call_duration' => $this->call_duration,
        ]);

        $query->andFilterWhere(['like', 'call_date', $this->call_date])
            ->andFilterWhere(['like', 'call_type', $this->call_type])
            ->andFilterWhere(['like', 'calling_no', $this->calling_no])
            ->andFilterWhere(['like', 'call_start', $this->call_start])
            ->andFilterWhere(['like', 'cc_executive_code', $this->cc_executive_code])
            ->andFilterWhere(['like', 'cc_executive_name', $this->cc_executive_name]);

        return $dataProvider;
    }
}
