<?php

namespace bc\models\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\transaction\master\MasterDivision;

/**
 * MasterDivisionSearch represents the model behind the search form of `common\models\master\MasterDivision`.
 */
class MasterDivisionSearch extends MasterDivision {

    public $division_option = [];

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'division_code'], 'integer'],
            [['division_name', 'division_headquarter'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true, $column = null, $array = false) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }

        $query = MasterDivision::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['division_name' => SORT_ASC]], 
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'master_division.id' => $this->id,
            'master_division.division_code' => $this->division_code,
        ]);

        $query->andFilterWhere(['like', 'master_division.division_name', $this->division_name])
                ->andFilterWhere(['like', 'master_division.division_headquarter', $this->division_headquarter]);

        return $dataProvider;
    }

}
