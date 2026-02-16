<?php

namespace bc\modules\selection\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\selection\models\BcGramPanchayat;
use common\models\master\MasterRole;

/**
 * BcGramPanchayatSearch represents the model behind the search form of `bc\modules\selection\models\BcGramPanchayat`.
 */
class BcGramPanchayatSearch extends BcGramPanchayat {

    public static $coll_district = 'district_code';
    public static $coll_block = 'block_code';
    public static $coll_gram_panchayat = 'gram_panchayat_code';
    public $block_option = [];
    public $district_option = [];
    public $gp_option = [];
    public $bank_option=[];
    public $aspirational_option = [];
    public $master_partner_bank_id;
    public $district_base_url='';
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'state_code', 'division_code', 'district_code', 'sub_district_code', 'block_code', 'gram_panchayat_code', 'gp_available_application', 'gp_partner_bank_id', 'gp_previous_master_bank_id', 'aspirational', 'bc_shortlist', 'selected_bc_status', 'selected_bc_round', 'select_rsethi', 'pendency_select_rsethi_days', 'certified_status', 'pendency_certified_days', 'iibf_photo_status', 'pendency_iibf_photo_days', 'assign_shg', 'pendency_assign_shg_days', 'bank_bc_status', 'bank_shg_status', 'pendency_bank_bc_days', 'pendency_bank_shg_days', 'bank_bc_shg_status', 'pendency_bank_bc_shg_days', 'pvr', 'pendency_pvr_days', 'shg_pfms_mapping', 'pendency_shg_pfms_mapping_days', 'bc_shg_support_fund', 'pendency_bc_shg_support_fund_days', 'handheld_machine', 'pendency_handheld_machine_days', 'onboarding', 'pendency_onboarding_days', 'operational', 'pendency_operational_days', 'bc_settlement_ac_194n', 'pendency_bc_settlement_ac_194n_days', 'c_bc_id', 'c_partner_bank_id', 'bc_blocked', 'bc_status', 'gp_status', 'c_no_selection', 're_calculate', 'status'], 'safe'],
            [['state_name', 'division_name', 'district_name', 'sub_district_name', 'block_name', 'gram_panchayat_name', 'selected_bc_date', 'select_rsethi_date', 'certified_date', 'iibf_photo_date', 'assign_shg_date', 'bank_bc_date', 'bank_shg_date', 'bank_bc_shg_date', 'pvr_date', 'shg_pfms_mapping_date', 'bc_shg_support_fund_date', 'handheld_machine_date', 'onboarding_date', 'operational_date', 'bc_settlement_ac_194n_date', 'c_bc_name', 'updated_datetime'], 'safe'],
            [['master_partner_bank_id'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true, $distinct_column = null, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = BcGramPanchayat::find();

        if ($columns != NULL) {
            $query->select($columns);
        }
        if ($user_model == NULL) {
//            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPPORT_UNIT])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RBI])) {
                $query->andWhere([BcGramPanchayat::getTableSchema()->fullName . '.operational' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $query->andWhere([BcGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR])) {
                $query->andWhere([BcGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([BcGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([BcGramPanchayat::getTableSchema()->fullName . '.c_partner_bank_id' => $user_model->master_partner_bank_id]);
                $query->andWhere([BcGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $query->andWhere([BcGramPanchayat::getTableSchema()->fullName . '.c_partner_bank_id' => $user_model->master_partner_bank_id]);
                $query->andWhere([BcGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([BcGramPanchayat::getTableSchema()->fullName . '.c_partner_bank_id' => $user_model->master_partner_bank_id]);
                $query->andWhere([BcGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([BcGramPanchayat::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([BcGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([BcGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([BcGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([BcGramPanchayat::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } else {
                $query->where('0=1');
            }
        }
        if ($distinct_column != null) {
            if ($distinct_column == static::$coll_district) {
                $query->groupBy(BcGramPanchayat::getTableSchema()->fullName . '.district_code');
                $query->orderBy(BcGramPanchayat::getTableSchema()->fullName . '.district_name asc');
            }
            if ($distinct_column == static::$coll_gram_panchayat) {

                $query->groupBy(BcGramPanchayat::getTableSchema()->fullName . '.gram_panchayat_code');
                $query->orderBy(BcGramPanchayat::getTableSchema()->fullName . '.gram_panchayat_name asc');
            }
            if ($distinct_column == static::$coll_block) {
                $query->groupBy(BcGramPanchayat::getTableSchema()->fullName . '.block_code');
                $query->orderBy(BcGramPanchayat::getTableSchema()->fullName . '.block_name asc');
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['district_name' => SORT_ASC, 'block_name' => SORT_ASC, 'gram_panchayat_name' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            BcGramPanchayat::getTableSchema()->fullName . '.id' => $this->id,
            BcGramPanchayat::getTableSchema()->fullName . '.state_code' => $this->state_code,
            BcGramPanchayat::getTableSchema()->fullName . '.division_code' => $this->division_code,
            BcGramPanchayat::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcGramPanchayat::getTableSchema()->fullName . '.sub_district_code' => $this->sub_district_code,
            BcGramPanchayat::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcGramPanchayat::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            BcGramPanchayat::getTableSchema()->fullName . '.gp_available_application' => $this->gp_available_application,
            BcGramPanchayat::getTableSchema()->fullName . '.gp_partner_bank_id' => $this->gp_partner_bank_id,
            BcGramPanchayat::getTableSchema()->fullName . '.gp_previous_master_bank_id' => $this->gp_previous_master_bank_id,
            BcGramPanchayat::getTableSchema()->fullName . '.aspirational' => $this->aspirational,
            BcGramPanchayat::getTableSchema()->fullName . '.bc_shortlist' => $this->bc_shortlist,
            BcGramPanchayat::getTableSchema()->fullName . '.selected_bc_status' => $this->selected_bc_status,
            BcGramPanchayat::getTableSchema()->fullName . '.selected_bc_round' => $this->selected_bc_round,
            BcGramPanchayat::getTableSchema()->fullName . '.selected_bc_date' => $this->selected_bc_date,
            BcGramPanchayat::getTableSchema()->fullName . '.select_rsethi' => $this->select_rsethi,
            BcGramPanchayat::getTableSchema()->fullName . '.select_rsethi_date' => $this->select_rsethi_date,
            BcGramPanchayat::getTableSchema()->fullName . '.pendency_select_rsethi_days' => $this->pendency_select_rsethi_days,
            BcGramPanchayat::getTableSchema()->fullName . '.certified_status' => $this->certified_status,
            BcGramPanchayat::getTableSchema()->fullName . '.certified_date' => $this->certified_date,
            BcGramPanchayat::getTableSchema()->fullName . '.pendency_certified_days' => $this->pendency_certified_days,
            BcGramPanchayat::getTableSchema()->fullName . '.iibf_photo_status' => $this->iibf_photo_status,
            BcGramPanchayat::getTableSchema()->fullName . '.iibf_photo_date' => $this->iibf_photo_date,
            BcGramPanchayat::getTableSchema()->fullName . '.pendency_iibf_photo_days' => $this->pendency_iibf_photo_days,
            BcGramPanchayat::getTableSchema()->fullName . '.assign_shg' => $this->assign_shg,
            BcGramPanchayat::getTableSchema()->fullName . '.assign_shg_date' => $this->assign_shg_date,
            BcGramPanchayat::getTableSchema()->fullName . '.pendency_assign_shg_days' => $this->pendency_assign_shg_days,
            BcGramPanchayat::getTableSchema()->fullName . '.bank_bc_status' => $this->bank_bc_status,
            BcGramPanchayat::getTableSchema()->fullName . '.bank_shg_status' => $this->bank_shg_status,
            BcGramPanchayat::getTableSchema()->fullName . '.bank_bc_date' => $this->bank_bc_date,
            BcGramPanchayat::getTableSchema()->fullName . '.bank_shg_date' => $this->bank_shg_date,
            BcGramPanchayat::getTableSchema()->fullName . '.pendency_bank_bc_days' => $this->pendency_bank_bc_days,
            BcGramPanchayat::getTableSchema()->fullName . '.pendency_bank_shg_days' => $this->pendency_bank_shg_days,
            BcGramPanchayat::getTableSchema()->fullName . '.bank_bc_shg_status' => $this->bank_bc_shg_status,
            BcGramPanchayat::getTableSchema()->fullName . '.bank_bc_shg_date' => $this->bank_bc_shg_date,
            BcGramPanchayat::getTableSchema()->fullName . '.pendency_bank_bc_shg_days' => $this->pendency_bank_bc_shg_days,
            BcGramPanchayat::getTableSchema()->fullName . '.pvr' => $this->pvr,
            BcGramPanchayat::getTableSchema()->fullName . '.pvr_date' => $this->pvr_date,
            BcGramPanchayat::getTableSchema()->fullName . '.pendency_pvr_days' => $this->pendency_pvr_days,
            BcGramPanchayat::getTableSchema()->fullName . '.shg_pfms_mapping' => $this->shg_pfms_mapping,
            BcGramPanchayat::getTableSchema()->fullName . '.shg_pfms_mapping_date' => $this->shg_pfms_mapping_date,
            BcGramPanchayat::getTableSchema()->fullName . '.pendency_shg_pfms_mapping_days' => $this->pendency_shg_pfms_mapping_days,
            BcGramPanchayat::getTableSchema()->fullName . '.bc_shg_support_fund' => $this->bc_shg_support_fund,
            BcGramPanchayat::getTableSchema()->fullName . '.bc_shg_support_fund_date' => $this->bc_shg_support_fund_date,
            BcGramPanchayat::getTableSchema()->fullName . '.pendency_bc_shg_support_fund_days' => $this->pendency_bc_shg_support_fund_days,
            BcGramPanchayat::getTableSchema()->fullName . '.handheld_machine' => $this->handheld_machine,
            BcGramPanchayat::getTableSchema()->fullName . '.handheld_machine_date' => $this->handheld_machine_date,
            BcGramPanchayat::getTableSchema()->fullName . '.pendency_handheld_machine_days' => $this->pendency_handheld_machine_days,
            BcGramPanchayat::getTableSchema()->fullName . '.onboarding' => $this->onboarding,
            BcGramPanchayat::getTableSchema()->fullName . '.onboarding_date' => $this->onboarding_date,
            BcGramPanchayat::getTableSchema()->fullName . '.pendency_onboarding_days' => $this->pendency_onboarding_days,
            BcGramPanchayat::getTableSchema()->fullName . '.operational' => $this->operational,
            BcGramPanchayat::getTableSchema()->fullName . '.operational_date' => $this->operational_date,
            BcGramPanchayat::getTableSchema()->fullName . '.pendency_operational_days' => $this->pendency_operational_days,
            BcGramPanchayat::getTableSchema()->fullName . '.bc_settlement_ac_194n' => $this->bc_settlement_ac_194n,
            BcGramPanchayat::getTableSchema()->fullName . '.bc_settlement_ac_194n_date' => $this->bc_settlement_ac_194n_date,
            BcGramPanchayat::getTableSchema()->fullName . '.pendency_bc_settlement_ac_194n_days' => $this->pendency_bc_settlement_ac_194n_days,
            BcGramPanchayat::getTableSchema()->fullName . '.c_bc_id' => $this->c_bc_id,
            BcGramPanchayat::getTableSchema()->fullName . '.c_partner_bank_id' => $this->c_partner_bank_id,
            BcGramPanchayat::getTableSchema()->fullName . '.bc_blocked' => $this->bc_blocked,
            BcGramPanchayat::getTableSchema()->fullName . '.bc_status' => $this->bc_status,
            BcGramPanchayat::getTableSchema()->fullName . '.gp_status' => $this->gp_status,
            BcGramPanchayat::getTableSchema()->fullName . '.c_no_selection' => $this->c_no_selection,
            BcGramPanchayat::getTableSchema()->fullName . '.re_calculate' => $this->re_calculate,
            BcGramPanchayat::getTableSchema()->fullName . '.updated_datetime' => $this->updated_datetime,
            BcGramPanchayat::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', BcGramPanchayat::getTableSchema()->fullName . '.state_name', $this->state_name])
                ->andFilterWhere(['like', BcGramPanchayat::getTableSchema()->fullName . '.division_name', $this->division_name])
                ->andFilterWhere(['like', BcGramPanchayat::getTableSchema()->fullName . '.district_name', $this->district_name])
                ->andFilterWhere(['like', BcGramPanchayat::getTableSchema()->fullName . '.sub_district_name', $this->sub_district_name])
                ->andFilterWhere(['like', BcGramPanchayat::getTableSchema()->fullName . '.block_name', $this->block_name])
                ->andFilterWhere(['like', BcGramPanchayat::getTableSchema()->fullName . '.gram_panchayat_name', $this->gram_panchayat_name])
                ->andFilterWhere(['like', BcGramPanchayat::getTableSchema()->fullName . '.c_bc_name', $this->c_bc_name]);

        return $dataProvider;
    }
}
