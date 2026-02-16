<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\GovernmentOrder;

/**
 * GovernmentOrderSearch represents the model behind the search form of `frontend\models\GovernmentOrder`.
 */
class GovernmentOrderSearch extends GovernmentOrder {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'app', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['title', 'description', 'date', 'issued_by', 'file'], 'safe'],
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
    public function search($params, $pagination = true, $columns = null) {
        $query = GovernmentOrder::find();

        // add conditions that should always apply here

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
            'id' => $this->id,
            'date' => $this->date,
            'app' => $this->app,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'issued_by', $this->issued_by])
                ->andFilterWhere(['like', 'file', $this->file]);

        return $dataProvider;
    }

}
