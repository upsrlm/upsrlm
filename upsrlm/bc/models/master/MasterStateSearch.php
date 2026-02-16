<?php

namespace bc\models\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\master\MasterState;

/**
 * MasterStateSearch represents the model behind the search form of `common\models\master\MasterState`.
 */
class MasterStateSearch extends MasterState {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'state_code', 'status'], 'integer'],
            [['state_name', 'state_type', 'short_name'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true, $distinct_column = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = MasterState::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['state_name' => SORT_ASC]],
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
            'state_code' => $this->state_code,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'state_name', $this->state_name])
                ->andFilterWhere(['like', 'short_name', $this->short_name])
                ->andFilterWhere(['like', 'state_type', $this->state_type]);

        return $dataProvider;
    }

}
