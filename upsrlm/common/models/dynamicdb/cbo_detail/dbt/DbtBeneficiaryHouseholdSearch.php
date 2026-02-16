<?php

namespace common\models\dynamicdb\cbo_detail\dbt;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiaryHousehold;

/**
 * DbtBeneficiaryHouseholdSearch represents the model behind the search form of `common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiaryHousehold`.
 */
class DbtBeneficiaryHouseholdSearch extends DbtBeneficiaryHousehold
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cbo_shg_id', 'rishta_shg_member_id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'house_no', 'caste_category', 'family_head_member_id', 'minority_family', 'bpl_family', 'iay_beneficiary', 'st_or_tribal', 'land_reforms', 'small_marginal_farmers', 'rsbyi_beneficiary', 'aaby_beneficiary', 'current_mgnrega_beneficiary', 'current_mgnrega_beneficiary_interested_work', 'current_mgnrega_beneficiary_day', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['division_name', 'district_name', 'block_name', 'gram_panchayat_name', 'village_name', 'family_head_name', 'bpl_secc_id', 'mobile_number', 'current_job_card_photo', 'current_job_card_number'], 'safe'],
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
        $query = DbtBeneficiaryHousehold::find();

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
            'cbo_shg_id' => $this->cbo_shg_id,
            'rishta_shg_member_id' => $this->rishta_shg_member_id,
            'division_code' => $this->division_code,
            'district_code' => $this->district_code,
            'block_code' => $this->block_code,
            'gram_panchayat_code' => $this->gram_panchayat_code,
            'village_code' => $this->village_code,
            'house_no' => $this->house_no,
            'caste_category' => $this->caste_category,
            'family_head_member_id' => $this->family_head_member_id,
            'minority_family' => $this->minority_family,
            'bpl_family' => $this->bpl_family,
            'iay_beneficiary' => $this->iay_beneficiary,
            'st_or_tribal' => $this->st_or_tribal,
            'land_reforms' => $this->land_reforms,
            'small_marginal_farmers' => $this->small_marginal_farmers,
            'rsbyi_beneficiary' => $this->rsbyi_beneficiary,
            'aaby_beneficiary' => $this->aaby_beneficiary,
            'current_mgnrega_beneficiary' => $this->current_mgnrega_beneficiary,
            'current_mgnrega_beneficiary_interested_work' => $this->current_mgnrega_beneficiary_interested_work,
            'current_mgnrega_beneficiary_day' => $this->current_mgnrega_beneficiary_day,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'division_name', $this->division_name])
            ->andFilterWhere(['like', 'district_name', $this->district_name])
            ->andFilterWhere(['like', 'block_name', $this->block_name])
            ->andFilterWhere(['like', 'gram_panchayat_name', $this->gram_panchayat_name])
            ->andFilterWhere(['like', 'village_name', $this->village_name])
            ->andFilterWhere(['like', 'family_head_name', $this->family_head_name])
            ->andFilterWhere(['like', 'bpl_secc_id', $this->bpl_secc_id])
            ->andFilterWhere(['like', 'mobile_number', $this->mobile_number])
            ->andFilterWhere(['like', 'current_job_card_photo', $this->current_job_card_photo])
            ->andFilterWhere(['like', 'current_job_card_number', $this->current_job_card_number]);

        return $dataProvider;
    }
}
