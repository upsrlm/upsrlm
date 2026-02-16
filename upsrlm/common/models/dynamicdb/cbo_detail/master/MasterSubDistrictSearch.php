<?php

namespace common\models\dynamicdb\cbo_detail\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\master\MasterSubDistrict;

/**
 * MasterSubDistrictSearch represents the model behind the search form of `common\models\master\MasterSubDistrict`.
 */
class MasterSubDistrictSearch extends MasterSubDistrict {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'division_code', 'district_code', 'sub_district_code', 'block_count', 'gram_panchayat_count', 'village_count'], 'integer'],
            [['division_name', 'district_code', 'district_name', 'sub_district_code', 'sub_district_name'], 'safe'],
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
        $query = MasterSubDistrict::find();

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
            'division_code' => $this->division_code,
            'district_code' => $this->district_code,
            'sub_district_code' => $this->sub_district_code,
            'block_count' => $this->block_count,
            'gram_panchayat_count' => $this->gram_panchayat_count,
            'village_count' => $this->village_count,
        ]);

        $query->andFilterWhere(['like', 'division_name', $this->division_name])
                ->andFilterWhere(['like', 'district_name', $this->district_name])
                ->andFilterWhere(['like', 'sub_district_name', $this->sub_district_name]);

        return $dataProvider;
    }

}
