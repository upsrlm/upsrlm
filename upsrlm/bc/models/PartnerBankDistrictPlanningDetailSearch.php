<?php

namespace bc\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\PartnerBankDistrictPlanningDetail;

/**
 * PartnerBankDistrictPlanningDetailSearch represents the model behind the search form of `bc\models\PartnerBankDistrictPlanningDetail`.
 */
class PartnerBankDistrictPlanningDetailSearch extends PartnerBankDistrictPlanningDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'partner_bank_district_planning_id', 'week', 'onboarding', 'ac_opening', 'supply_equipment', 'operational', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
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
        $query = PartnerBankDistrictPlanningDetail::find();

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
            'partner_bank_district_planning_id' => $this->partner_bank_district_planning_id,
            'week' => $this->week,
            'onboarding' => $this->onboarding,
            'ac_opening' => $this->ac_opening,
            'supply_equipment' => $this->supply_equipment,
            'operational' => $this->operational,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
