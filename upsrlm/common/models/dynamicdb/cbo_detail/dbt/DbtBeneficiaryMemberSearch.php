<?php

namespace common\models\dynamicdb\cbo_detail\dbt;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiaryMember;

/**
 * DbtBeneficiaryMemberSearch represents the model behind the search form of `common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiaryMember`.
 */
class DbtBeneficiaryMemberSearch extends DbtBeneficiaryMember {

    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $village_option = [];
    public $wada_option;
    public $wada;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'cbo_shg_id', 'rishta_shg_member_id', 'dbt_beneficiary_household_id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'user_id', 'role', 'marital_status', 'age', 'relation_id', 'locality_id', 'gender', 'family_head', 'bank_id', 'physically_handicapped', 'created_by', 'updated_at', 'created_at', 'updated_by', 'status'], 'integer'],
            [['division_name', 'district_name', 'block_name', 'gram_panchayat_name', 'village_name', 'name', 'mobile', 'dob', 'bank_account_no', 'name_of_bank', 'branch', 'branch_code_or_ifsc', 'passbook_photo', 'aadhar_front_photo', 'aadhar_back_photo', 'voter_id_photo', 'member_photo', 'member_sign_thumb', 'father_name', 'aadhaar_number', 'voter_id_no'], 'safe'],
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
        $query = DbtBeneficiaryMember::find();

        // add conditions that should always apply here
        if ($user_model == NULL) {
//            $query->where('0=1');
        } else {
            
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 20 : $pagination],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            DbtBeneficiaryMember::getTableSchema()->fullName . '.id' => $this->id,
            DbtBeneficiaryMember::getTableSchema()->fullName . '.cbo_shg_id' => $this->cbo_shg_id,
            DbtBeneficiaryMember::getTableSchema()->fullName . '.rishta_shg_member_id' => $this->rishta_shg_member_id,
            DbtBeneficiaryMember::getTableSchema()->fullName . '.dbt_beneficiary_household_id' => $this->dbt_beneficiary_household_id,
            DbtBeneficiaryMember::getTableSchema()->fullName . '.division_code' => $this->division_code,
            DbtBeneficiaryMember::getTableSchema()->fullName . '.district_code' => $this->district_code,
            DbtBeneficiaryMember::getTableSchema()->fullName . '.block_code' => $this->block_code,
            DbtBeneficiaryMember::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            'village_code' => $this->village_code,
            'user_id' => $this->user_id,
            'role' => $this->role,
            'marital_status' => $this->marital_status,
            'dob' => $this->dob,
            'age' => $this->age,
            'relation_id' => $this->relation_id,
            'locality_id' => $this->locality_id,
            'gender' => $this->gender,
            'family_head' => $this->family_head,
            'bank_id' => $this->bank_id,
            'physically_handicapped' => $this->physically_handicapped,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'division_name', $this->division_name])
                ->andFilterWhere(['like', 'district_name', $this->district_name])
                ->andFilterWhere(['like', 'block_name', $this->block_name])
                ->andFilterWhere(['like', 'gram_panchayat_name', $this->gram_panchayat_name])
                ->andFilterWhere(['like', 'village_name', $this->village_name])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'mobile', $this->mobile])
                ->andFilterWhere(['like', 'bank_account_no', $this->bank_account_no])
                ->andFilterWhere(['like', 'name_of_bank', $this->name_of_bank])
                ->andFilterWhere(['like', 'branch', $this->branch])
                ->andFilterWhere(['like', 'branch_code_or_ifsc', $this->branch_code_or_ifsc])
                ->andFilterWhere(['like', 'passbook_photo', $this->passbook_photo])
                ->andFilterWhere(['like', 'aadhar_front_photo', $this->aadhar_front_photo])
                ->andFilterWhere(['like', 'aadhar_back_photo', $this->aadhar_back_photo])
                ->andFilterWhere(['like', 'voter_id_photo', $this->voter_id_photo])
                ->andFilterWhere(['like', 'member_photo', $this->member_photo])
                ->andFilterWhere(['like', 'member_sign_thumb', $this->member_sign_thumb])
                ->andFilterWhere(['like', 'father_name', $this->father_name])
                ->andFilterWhere(['like', 'aadhaar_number', $this->aadhaar_number])
                ->andFilterWhere(['like', 'voter_id_no', $this->voter_id_no]);

        return $dataProvider;
    }

}
