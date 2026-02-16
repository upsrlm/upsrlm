<?php

namespace bc\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\SbiDistrictMou;

/**
 * SbiDistrictMouSearch represents the model behind the search form of `bc\models\SbiDistrictMou`.
 */
class SbiDistrictMouSearch extends SbiDistrictMou {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'state_code', 'division_code', 'district_code', 'block_count', 'before_2023_ulb_election_gp_count', 'current_gp_count', 'bc_sakhi_onboard', 'bc_sakhi_onboard_current', 'bc_sakhi_onboard_remain', 'sbi_distict_all', 'work_phase'], 'safe'],
            [['state_name', 'division_name', 'district_name'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = SbiDistrictMou::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
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
            'division_code' => $this->division_code,
            'district_code' => $this->district_code,
            'block_count' => $this->block_count,
            'before_2023_ulb_election_gp_count' => $this->before_2023_ulb_election_gp_count,
            'current_gp_count' => $this->current_gp_count,
            'bc_sakhi_onboard' => $this->bc_sakhi_onboard,
            'bc_sakhi_onboard_current' => $this->bc_sakhi_onboard_current,
            'bc_sakhi_onboard_remain' => $this->bc_sakhi_onboard_remain,
            'sbi_distict_all' => $this->sbi_distict_all,
            'work_phase' => $this->work_phase,
        ]);

        $query->andFilterWhere(['like', 'state_name', $this->state_name])
                ->andFilterWhere(['like', 'division_name', $this->division_name])
                ->andFilterWhere(['like', 'district_name', $this->district_name]);

        return $dataProvider;
    }
}
