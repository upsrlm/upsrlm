<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeBocwLabourProfile;
use common\models\master\MasterRole;
/**
 * DbtBeneficiarySchemeBocwLabourProfileSearch represents the model behind the search form of `common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeBocwLabourProfile`.
 */
class DbtBeneficiarySchemeBocwLabourProfileSearch extends DbtBeneficiarySchemeBocwLabourProfile
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'uplmis_gram_panchayat_code', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'created_at', 'updated_at', 'status'], 'integer'],
            [['uplmis_lab_reg_no', 'uplmis_date_of_reg', 'uplmis_Labour_name', 'uplmis_labour_name_eng', 'uplmis_gender', 'uplmis_father_husb_name', 'uplmis_father_husb_name_eng', 'uplmis_mobile_no', 'uplmis_dob', 'uplmis_caste', 'uplmis_temp_house_no', 'uplmis_temp_post', 'uplmis_temp_thana', 'uplmis_temp_address', 'uplmis_perm_house_no', 'uplmis_perm_address', 'uplmis_perm_post', 'uplmis_perm_thana', 'uplmis_perm_block', 'uplmis_labour_status', 'uplmis_marital_status', 'uplmis_perm_ward_village_name', 'uplmis_tmp_dis_name', 'uplmis_tmp_tehsil_name', 'uplmis_municipal_block_name', 'uplmis_occ_name', 'uplmis_state_name', 'uplmis_nominee', 'uplmis_nominee_relation', 'uplmis_niyojak_name_add', 'uplmis_niyojak_mobile_no', 'date_of_reg', 'dob', 'division_name', 'district_name', 'block_name', 'gram_panchayat_name'], 'safe'],
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
     public function search($params, $user_model = null, $pagination = true, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = DbtBeneficiarySchemeBocwLabourProfile::find();

        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_VIEWER])) {
                
            }elseif (in_array($user_model->role, [MasterRole::ROLE_BOCW_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DSO])) {
                $query->andWhere([DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BDO])) {
                $query->andWhere([DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
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
            DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.id' => $this->id,
            DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_gram_panchayat_code' => $this->uplmis_gram_panchayat_code,
            DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.date_of_reg' => $this->date_of_reg,
            DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.dob' => $this->dob,
            DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.division_code' => $this->division_code,
            DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.district_code' => $this->district_code,
            DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.block_code' => $this->block_code,
            DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.created_at' => $this->created_at,
            DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_lab_reg_no', $this->uplmis_lab_reg_no])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_date_of_reg', $this->uplmis_date_of_reg])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_Labour_name', $this->uplmis_Labour_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_labour_name_eng', $this->uplmis_labour_name_eng])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_gender', $this->uplmis_gender])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_father_husb_name', $this->uplmis_father_husb_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_father_husb_name_eng', $this->uplmis_father_husb_name_eng])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_mobile_no', $this->uplmis_mobile_no])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_dob', $this->uplmis_dob])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_caste', $this->uplmis_caste])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_temp_house_no', $this->uplmis_temp_house_no])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_temp_post', $this->uplmis_temp_post])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_temp_thana', $this->uplmis_temp_thana])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_temp_address', $this->uplmis_temp_address])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_perm_house_no', $this->uplmis_perm_house_no])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_perm_address', $this->uplmis_perm_address])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_perm_post', $this->uplmis_perm_post])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_perm_thana', $this->uplmis_perm_thana])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_perm_block', $this->uplmis_perm_block])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_labour_status', $this->uplmis_labour_status])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_marital_status', $this->uplmis_marital_status])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_perm_ward_village_name', $this->uplmis_perm_ward_village_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_tmp_dis_name', $this->uplmis_tmp_dis_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_tmp_tehsil_name', $this->uplmis_tmp_tehsil_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_municipal_block_name', $this->uplmis_municipal_block_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_occ_name', $this->uplmis_occ_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_state_name', $this->uplmis_state_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_nominee', $this->uplmis_nominee])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_nominee_relation', $this->uplmis_nominee_relation])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_niyojak_name_add', $this->uplmis_niyojak_name_add])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.uplmis_niyojak_mobile_no', $this->uplmis_niyojak_mobile_no])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.division_name', $this->division_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.district_name', $this->district_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.block_name', $this->block_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourProfile::getTableSchema()->fullName . '.gram_panchayat_name', $this->gram_panchayat_name]);

        return $dataProvider;
    }
}
