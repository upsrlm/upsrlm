<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeBocwApplicant;
use common\models\master\MasterRole;

/**
 * DbtBeneficiarySchemeBocwApplicantSearch represents the model behind the search form of `common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeBocwApplicant`.
 */
class DbtBeneficiarySchemeBocwApplicantSearch extends DbtBeneficiarySchemeBocwApplicant {

    public $division_option = [];
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $village_option = [];
    public $shg_option = [];
    public $wada = 1;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'cbo_shg_id', 'rishta_shg_member_id', 'dbt_beneficiary_household_id', 'dbt_beneficiary_member_id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'marital_status', 'age', 'relation_id', 'locality_id', 'gender', 'family_head', 'bank_id', 'physically_handicapped', 'scheme_id', 'no_of_family_member', 'created_by', 'updated_at', 'created_at', 'updated_by', 'status'], 'integer'],
            [['division_name', 'district_name', 'block_name', 'gram_panchayat_name', 'village_name', 'name', 'mobile', 'dob', 'bank_account_no', 'name_of_bank', 'branch', 'branch_code_or_ifsc', 'passbook_photo', 'member_photo', 'member_sign_thumb', 'aadhar_front_photo', 'aadhar_back_photo', 'voter_id_photo', 'father_name', 'aadhaar_number', 'voter_id_no', 'bocw_reg_no', 'application_number', 'application_date', 'scheme_name'], 'safe'],
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
        $query = DbtBeneficiarySchemeBocwApplicant::find();

        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DSO])) {
                $query->andWhere([DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BDO])) {
                $query->andWhere([DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } else {
                $query->where('0=1');
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.id' => $this->id,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.cbo_shg_id' => $this->cbo_shg_id,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.rishta_shg_member_id' => $this->rishta_shg_member_id,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.dbt_beneficiary_household_id' => $this->dbt_beneficiary_household_id,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.dbt_beneficiary_member_id' => $this->dbt_beneficiary_member_id,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.division_code' => $this->division_code,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.district_code' => $this->district_code,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.block_code' => $this->block_code,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.village_code' => $this->village_code,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.marital_status' => $this->marital_status,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.dob' => $this->dob,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.age' => $this->age,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.relation_id' => $this->relation_id,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.locality_id' => $this->locality_id,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.gender' => $this->gender,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.family_head' => $this->family_head,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.bank_id' => $this->bank_id,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.physically_handicapped' => $this->physically_handicapped,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.application_date' => $this->application_date,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.scheme_id' => $this->scheme_id,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.no_of_family_member' => $this->no_of_family_member,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.created_by' => $this->created_by,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.created_at' => $this->created_at,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.division_name', $this->division_name])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.district_name', $this->district_name])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.block_name', $this->block_name])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.gram_panchayat_name', $this->gram_panchayat_name])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.village_name', $this->village_name])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.name', $this->name])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.mobile', $this->mobile])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.bank_account_no', $this->bank_account_no])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.name_of_bank', $this->name_of_bank])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.branch', $this->branch])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.branch_code_or_ifsc', $this->branch_code_or_ifsc])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.passbook_photo', $this->passbook_photo])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.ember_photo', $this->member_photo])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.member_sign_thumb', $this->member_sign_thumb])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.aadhar_front_photo', $this->aadhar_front_photo])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.aadhar_back_photo', $this->aadhar_back_photo])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.voter_id_photo', $this->voter_id_photo])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.father_name', $this->father_name])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.aadhaar_number', $this->aadhaar_number])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.voter_id_no', $this->voter_id_no])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.bocw_reg_no', $this->bocw_reg_no])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.application_number', $this->application_number])
                ->andFilterWhere(['like', DbtBeneficiarySchemeBocwApplicant::getTableSchema()->fullName . '.scheme_name', $this->scheme_name]);

        return $dataProvider;
    }

}
