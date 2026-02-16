<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeBocwLabourSchemeStatus;
use common\models\master\MasterRole;
/**
 * DbtBeneficiarySchemeBocwLabourSchemeStatusSearch represents the model behind the search form of `common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeBocwLabourSchemeStatus`.
 */
class DbtBeneficiarySchemeBocwLabourSchemeStatusSearch extends DbtBeneficiarySchemeBocwLabourSchemeStatus
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'dbt_beneficiary_scheme_bocw_labour_profile_id', 'uplmis_gram_panchayat_code', 'scheme_id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'created_at', 'updated_at', 'status'], 'integer'],
            [['uplmis_app_no', 'uplmis_lab_reg_no', 'uplmis_app_date', 'uplmis_scheme_name', 'uplmis_status', 'uplmis_Labour_name', 'uplmis_labour_name_eng', 'uplmis_father_husb_name', 'uplmis_father_husb_name_eng', 'uplmis_mother_name', 'uplmis_mother_name_eng', 'uplmis_dob', 'uplmis_temp_house_no', 'uplmis_village_name', 'uplmis_temp_pincode', 'uplmis_temp_post', 'uplmis_temp_thana', 'uplmis_temp_address', 'uplmis_vw_district_name', 'uplmis_vw_division_name', 'app_date', 'dob', 'division_name', 'district_name', 'block_name', 'gram_panchayat_name'], 'safe'],
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
        $query = DbtBeneficiarySchemeBocwLabourSchemeStatus::find();

         if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_VIEWER])) {
                
            }elseif (in_array($user_model->role, [MasterRole::ROLE_BOCW_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DSO])) {
                $query->andWhere([DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BDO])) {
                $query->andWhere([DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
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
            DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.d' => $this->id,
            DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.dbt_beneficiary_scheme_bocw_labour_profile_id' => $this->dbt_beneficiary_scheme_bocw_labour_profile_id,
            DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_gram_panchayat_code' => $this->uplmis_gram_panchayat_code,
            DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.scheme_id' => $this->scheme_id,
            DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.app_date' => $this->app_date,
            DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.dob' => $this->dob,
            DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.division_code' => $this->division_code,
            DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.district_code' => $this->district_code,
            DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.block_code' => $this->block_code,
            DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.created_at' => $this->created_at,
            DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_app_no', $this->uplmis_app_no])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_lab_reg_no', $this->uplmis_lab_reg_no])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_app_date', $this->uplmis_app_date])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_scheme_name', $this->uplmis_scheme_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_status', $this->uplmis_status])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_Labour_name', $this->uplmis_Labour_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_labour_name_eng', $this->uplmis_labour_name_eng])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_father_husb_name', $this->uplmis_father_husb_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_father_husb_name_eng', $this->uplmis_father_husb_name_eng])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_mother_name', $this->uplmis_mother_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_mother_name_eng', $this->uplmis_mother_name_eng])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_dob', $this->uplmis_dob])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_temp_house_no', $this->uplmis_temp_house_no])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_village_name', $this->uplmis_village_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_temp_pincode', $this->uplmis_temp_pincode])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_temp_post', $this->uplmis_temp_post])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_temp_thana', $this->uplmis_temp_thana])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_temp_address', $this->uplmis_temp_address])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_vw_district_name', $this->uplmis_vw_district_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.uplmis_vw_division_name', $this->uplmis_vw_division_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.division_name', $this->division_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.district_name', $this->district_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.block_name', $this->block_name])
            ->andFilterWhere(['like', DbtBeneficiarySchemeBocwLabourSchemeStatus::getTableSchema()->fullName . '.gram_panchayat_name', $this->gram_panchayat_name]);

        return $dataProvider;
    }
}
