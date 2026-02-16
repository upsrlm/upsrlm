<?php

namespace common\models\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\master\MasterListSaachiv;

/**
 * MasterListSaachivSearch represents the model behind the search form of `common\models\master\MasterListSaachiv`.
 */
class MasterListSaachivSearch extends MasterListSaachiv {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'status'], 'integer'],
            [['district', 'block', 'gp', 'sachiv_name', 'sachiv_mob'], 'safe'],
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
    public function search($params) {
        $query = MasterListSaachiv::find();

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
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'district', $this->district])
                ->andFilterWhere(['like', 'block', $this->block])
                ->andFilterWhere(['like', 'gp', $this->gp])
                ->andFilterWhere(['like', 'sachiv_name', $this->sachiv_name])
                ->andFilterWhere(['like', 'sachiv_mob', $this->sachiv_mob]);

        return $dataProvider;
    }

}
