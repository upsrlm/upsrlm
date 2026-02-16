<?php

namespace common\models\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\master\MasterTown;

/**
 * MasterTownSearch represents the model behind the search form of `common\models\master\MasterTown`.
 */
class MasterTownSearch extends MasterTown {

    public $town_option = [];

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'town_type'], 'integer'],
            [['state_code', 'state_name', 'district_code', 'district_name', 'sub_district_code', 'sub_district_name', 'town_code', 'town_name'], 'safe'],
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
        $query = MasterTown::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['district_name' => SORT_ASC, 'block_name' => SORT_ASC, 'gram_panchayat_name' => SORT_ASC, 'village_name' => SORT_ASC]],
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
            'town_type' => $this->town_type,
        ]);

        $query->andFilterWhere(['like', 'state_code', $this->state_code])
                ->andFilterWhere(['like', 'state_name', $this->state_name])
                ->andFilterWhere(['like', 'district_code', $this->district_code])
                ->andFilterWhere(['like', 'district_name', $this->district_name])
                ->andFilterWhere(['like', 'sub_district_code', $this->sub_district_code])
                ->andFilterWhere(['like', 'sub_district_name', $this->sub_district_name])
                ->andFilterWhere(['like', 'town_code', $this->town_code])
                ->andFilterWhere(['like', 'town_name', $this->town_name]);

        return $dataProvider;
    }

}
