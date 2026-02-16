<?php

namespace cbo\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use cbo\models\Shg;
use common\models\master\MasterRole;

/**
 * ShgSearch represents the model behind the search form of `app\modules\shg\models\Shg`.
 */
class ShgSearch extends Shg {

    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $village_option = [];
    public $verify_option = [];
    public $return_option = [];
    public $verify_other_option = [];
    public $return;
    public $data_entry;
    public $shg_nrlm_code;
    public $saheli;
    public $wada;
    public $aspirational;
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'no_of_members', 'secretary_mobile_no', 'cbo_vo_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['division_name', 'district_name', 'block_name', 'gram_panchayat_name', 'village_name', 'hamlet', 'name_of_shg', 'chaire_person_name', 'chaire_person_mobile_no', 'secretary_name', 'treasurer_name', 'treasurer_mobile_no', 'shg_code'], 'safe'],
            [['verify_chaire_person_mobile_no', 'verify_secretary_mobile_no', 'verify_mobile_no', 'verify_by', 'verify_shg_code', 'verification_status', 'return', 'data_entry', 'shg_bank'], 'safe'],
            [['date_of_opening_the_bank_account'], 'safe'],
            [['bank_account_no_of_the_shg', 'branch_code_or_ifsc'], 'safe'],
            [['name_of_bank', 'branch'], 'safe'],
            [['urban_shg'], 'safe'],
            [['shg_nrlm_code'], 'safe'],
            [['wada'], 'safe'],
            [['verify_over_all'], 'safe'],
            [['no_of_user'], 'safe'],
            [['no_of_cst_user'], 'safe'],
            [['no_of_cst_user_used_rishta'], 'safe'],
            [['is_bc'], 'safe'],
            [['no_of_user_used_rishta'], 'safe'],
            [['suggest_samuh_sakhi'], 'safe'],
            [['suggest_samuh_sakhi_completed_application'], 'safe'],
            [['shg_profile_updated'], 'safe'],
            [['no_of_member_added'], 'safe'],
            [['bank_detail_add'], 'safe'],
            [['no_of_fund_received'], 'safe'],
            [['total_fund_received_amount'], 'safe'],
            [['shg_feedback'], 'safe'],
            [['verify_other'], 'safe'],
            [['aspirational'], 'safe'],
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

        $query = Shg::find();

        // add conditions that should always apply here

        if ($columns != NULL) {
            $query->select($columns);
        }
        $query->andWhere(['!=', Shg::getTableSchema()->fullName . '.status', -1]);
        $query->andWhere([Shg::getTableSchema()->fullName . '.repeated_error' => 0]);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                //$query->andWhere([Shg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CBO_USER])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.id' => \yii\helpers\ArrayHelper::getColumn($user_model->shg, 'cbo_id')]);
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                //$query->andWhere([CboClf::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_ADMIN])) {
                $query->joinWith(['district']);
                $query->andWhere([\common\models\master\MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN])) {
                $query->joinWith(['district']);
                $query->andWhere([\common\models\master\MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
                $query->andWhere([Shg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_ADMIN])) {
                $query->joinWith(['gp']);
                $query->andWhere([\common\models\master\MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_VIEWER])) {
                $query->joinWith(['gp']);
                $query->andWhere([\common\models\master\MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                $query->andWhere([Shg::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                $query->andWhere([Shg::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } else {
                $query->where('0=1');
            }
        }
        if ($this->saheli) {
            $query->joinWith(['district']);
            $query->andWhere([\common\models\master\MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
        }
        if ($this->wada != '') {
            $query->joinWith(['gp']);
            $query->andWhere([\common\models\master\MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => $this->wada]);
        }
        if ($this->data_entry) {
            $query->andWhere([Shg::getTableSchema()->fullName . '.created_by' => $user_model->id]);
        }
        if ($this->shg_nrlm_code != '') {
            if ($this->shg_nrlm_code == 0) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.shg_code' => NULL]);
            }
            if ($this->shg_nrlm_code == 1) {
                $query->andWhere(['not', [Shg::getTableSchema()->fullName . '.shg_code' => NULL]]);
            }
        }
        if ($this->aspirational != '') {
            $query->joinWith(['block']);
            $query->andWhere(['master_block.aspirational' => $this->aspirational]);
        }
//        echo $query->createCommand()->getRawSql();exit;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if ($this->no_of_cst_user !== '') {
            if ($this->no_of_cst_user == '0') {
                $query->andWhere([Shg::getTableSchema()->fullName . '.no_of_cst_user' => $this->no_of_cst_user]);
            } else if ($this->no_of_cst_user == '1') {
                $query->andWhere(['>', Shg::getTableSchema()->fullName . '.no_of_cst_user', 0]);
            } else if ($this->no_of_cst_user > '1') {
                $query->andWhere([Shg::getTableSchema()->fullName . '.no_of_cst_user' => $this->no_of_cst_user]);
            }
        }
//        if ($this->no_of_cst_user !== '') {
//            if ($this->no_of_cst_user == '0') {
//                $query->andWhere([Shg::getTableSchema()->fullName . '.no_of_cst_user' => $this->no_of_cst_user]);
//            } else if ($this->no_of_cst_user == '1') {
//                $query->andWhere(['>', Shg::getTableSchema()->fullName . '.no_of_cst_user', 0]);
//            } else if ($this->no_of_cst_user > '1')  {
//                $query->andWhere([Shg::getTableSchema()->fullName . '.no_of_cst_user' => $this->no_of_cst_user]);
//            }
//        }
        if ($this->no_of_cst_user_used_rishta !== '') {
            if ($this->no_of_cst_user_used_rishta == '0') {
                $query->andWhere([Shg::getTableSchema()->fullName . '.no_of_cst_user_used_rishta' => $this->no_of_cst_user_used_rishta]);
            } else if ($this->no_of_cst_user_used_rishta == '1') {
                $query->andWhere(['>', Shg::getTableSchema()->fullName . '.no_of_cst_user_used_rishta', 0]);
            } else if ($this->no_of_cst_user_used_rishta > '1') {
                $query->andWhere([Shg::getTableSchema()->fullName . '.no_of_cst_user_used_rishta' => $this->no_of_cst_user_used_rishta]);
            }
        }
        // grid filtering conditions
        $query->andFilterWhere([
            Shg::getTableSchema()->fullName . '.id' => $this->id,
            Shg::getTableSchema()->fullName . '.division_code' => $this->division_code,
            Shg::getTableSchema()->fullName . '.district_code' => $this->district_code,
            Shg::getTableSchema()->fullName . '.block_code' => $this->block_code,
            Shg::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            Shg::getTableSchema()->fullName . '.village_code' => $this->village_code,
            Shg::getTableSchema()->fullName . '.no_of_members' => $this->no_of_members,
            Shg::getTableSchema()->fullName . '.verify_chaire_person_mobile_no' => $this->verify_chaire_person_mobile_no,
            Shg::getTableSchema()->fullName . '.verify_secretary_mobile_no' => $this->verify_secretary_mobile_no,
            Shg::getTableSchema()->fullName . '.verify_treasurer_mobile_no' => $this->verify_treasurer_mobile_no,
            Shg::getTableSchema()->fullName . '.verify_mobile_no' => $this->verify_mobile_no,
            Shg::getTableSchema()->fullName . '.verify_other' => $this->verify_other,
            Shg::getTableSchema()->fullName . '.verify_shg_code' => $this->verify_shg_code,
            Shg::getTableSchema()->fullName . '.verify_datetime' => $this->verify_datetime,
            Shg::getTableSchema()->fullName . '.verify_by' => $this->verify_by,
            Shg::getTableSchema()->fullName . '.verification_status' => $this->verification_status,
            Shg::getTableSchema()->fullName . '.verify_over_all' => $this->verify_over_all,
            Shg::getTableSchema()->fullName . '.created_by' => $this->created_by,
            Shg::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            Shg::getTableSchema()->fullName . '.created_at' => $this->created_at,
            Shg::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            Shg::getTableSchema()->fullName . '.status' => $this->status,
            Shg::getTableSchema()->fullName . '.cbo_vo_id' => $this->cbo_vo_id,
            Shg::getTableSchema()->fullName . '.shg_bank' => $this->shg_bank,
            Shg::getTableSchema()->fullName . '.urban_shg' => $this->urban_shg,
            Shg::getTableSchema()->fullName . '.bank_account_no_of_the_shg' => $this->bank_account_no_of_the_shg,
            Shg::getTableSchema()->fullName . '.is_bc' => $this->is_bc,
            Shg::getTableSchema()->fullName . '.suggest_samuh_sakhi' => $this->suggest_samuh_sakhi,
            Shg::getTableSchema()->fullName . '.suggest_samuh_sakhi_completed_application' => $this->suggest_samuh_sakhi_completed_application,
            Shg::getTableSchema()->fullName . '.shg_profile_updated' => $this->shg_profile_updated,
            Shg::getTableSchema()->fullName . '.urban_shg' => $this->urban_shg,
            Shg::getTableSchema()->fullName . '.bank_account_no_of_the_shg' => $this->bank_account_no_of_the_shg,
            Shg::getTableSchema()->fullName . '.wada_shg' => $this->wada,
        ]);

        $query->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.division_name', $this->division_name])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.district_name', $this->district_name])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.block_name', $this->block_name])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.gram_panchayat_name', $this->gram_panchayat_name])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.village_name', $this->village_name])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.hamlet', $this->hamlet])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.name_of_shg', $this->name_of_shg])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.shg_code', $this->shg_code])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.chaire_person_name', $this->chaire_person_name])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.chaire_person_mobile_no', $this->chaire_person_mobile_no])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.secretary_name', $this->secretary_name])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.treasurer_name', $this->treasurer_name])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.treasurer_mobile_no', $this->treasurer_mobile_no]);

        return $dataProvider;
    }
    
    public function searchbccall($params, $user_model = null, $pagination = true, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }

        $query = Shg::find();

        // add conditions that should always apply here

        if ($columns != NULL) {
            $query->select($columns);
        }
        $query->andWhere(['!=', Shg::getTableSchema()->fullName . '.status', -1]);
        $query->andWhere([Shg::getTableSchema()->fullName . '.repeated_error' => 0]);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                //$query->andWhere([Shg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CBO_USER])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.id' => \yii\helpers\ArrayHelper::getColumn($user_model->shg, 'cbo_id')]);
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                //$query->andWhere([CboClf::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_ADMIN])) {
                $query->joinWith(['district']);
                $query->andWhere([\common\models\master\MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN])) {
                $query->joinWith(['district']);
                $query->andWhere([\common\models\master\MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
                $query->andWhere([Shg::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_ADMIN])) {
                $query->joinWith(['gp']);
                $query->andWhere([\common\models\master\MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_VIEWER])) {
                $query->joinWith(['gp']);
                $query->andWhere([\common\models\master\MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                //$query->andWhere([Shg::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                //$query->andWhere([Shg::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } else {
                $query->where('0=1');
            }
        }
        if ($this->saheli) {
            $query->joinWith(['district']);
            $query->andWhere([\common\models\master\MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
        }
        if ($this->wada != '') {
            $query->joinWith(['gp']);
            $query->andWhere([\common\models\master\MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => $this->wada]);
        }
        if ($this->data_entry) {
            $query->andWhere([Shg::getTableSchema()->fullName . '.created_by' => $user_model->id]);
        }
        if ($this->shg_nrlm_code != '') {
            if ($this->shg_nrlm_code == 0) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.shg_code' => NULL]);
            }
            if ($this->shg_nrlm_code == 1) {
                $query->andWhere(['not', [Shg::getTableSchema()->fullName . '.shg_code' => NULL]]);
            }
        }
        if ($this->aspirational != '') {
            $query->joinWith(['block']);
            $query->andWhere(['master_block.aspirational' => $this->aspirational]);
        }
//        echo $query->createCommand()->getRawSql();exit;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if ($this->no_of_cst_user !== '') {
            if ($this->no_of_cst_user == '0') {
                $query->andWhere([Shg::getTableSchema()->fullName . '.no_of_cst_user' => $this->no_of_cst_user]);
            } else if ($this->no_of_cst_user == '1') {
                $query->andWhere(['>', Shg::getTableSchema()->fullName . '.no_of_cst_user', 0]);
            } else if ($this->no_of_cst_user > '1') {
                $query->andWhere([Shg::getTableSchema()->fullName . '.no_of_cst_user' => $this->no_of_cst_user]);
            }
        }
//        if ($this->no_of_cst_user !== '') {
//            if ($this->no_of_cst_user == '0') {
//                $query->andWhere([Shg::getTableSchema()->fullName . '.no_of_cst_user' => $this->no_of_cst_user]);
//            } else if ($this->no_of_cst_user == '1') {
//                $query->andWhere(['>', Shg::getTableSchema()->fullName . '.no_of_cst_user', 0]);
//            } else if ($this->no_of_cst_user > '1')  {
//                $query->andWhere([Shg::getTableSchema()->fullName . '.no_of_cst_user' => $this->no_of_cst_user]);
//            }
//        }
        if ($this->no_of_cst_user_used_rishta !== '') {
            if ($this->no_of_cst_user_used_rishta == '0') {
                $query->andWhere([Shg::getTableSchema()->fullName . '.no_of_cst_user_used_rishta' => $this->no_of_cst_user_used_rishta]);
            } else if ($this->no_of_cst_user_used_rishta == '1') {
                $query->andWhere(['>', Shg::getTableSchema()->fullName . '.no_of_cst_user_used_rishta', 0]);
            } else if ($this->no_of_cst_user_used_rishta > '1') {
                $query->andWhere([Shg::getTableSchema()->fullName . '.no_of_cst_user_used_rishta' => $this->no_of_cst_user_used_rishta]);
            }
        }
        // grid filtering conditions
        $query->andFilterWhere([
            Shg::getTableSchema()->fullName . '.id' => $this->id,
            Shg::getTableSchema()->fullName . '.division_code' => $this->division_code,
            Shg::getTableSchema()->fullName . '.district_code' => $this->district_code,
            Shg::getTableSchema()->fullName . '.block_code' => $this->block_code,
            Shg::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            Shg::getTableSchema()->fullName . '.village_code' => $this->village_code,
            Shg::getTableSchema()->fullName . '.no_of_members' => $this->no_of_members,
            Shg::getTableSchema()->fullName . '.verify_chaire_person_mobile_no' => $this->verify_chaire_person_mobile_no,
            Shg::getTableSchema()->fullName . '.verify_secretary_mobile_no' => $this->verify_secretary_mobile_no,
            Shg::getTableSchema()->fullName . '.verify_treasurer_mobile_no' => $this->verify_treasurer_mobile_no,
            Shg::getTableSchema()->fullName . '.verify_mobile_no' => $this->verify_mobile_no,
            Shg::getTableSchema()->fullName . '.verify_other' => $this->verify_other,
            Shg::getTableSchema()->fullName . '.verify_shg_code' => $this->verify_shg_code,
            Shg::getTableSchema()->fullName . '.verify_datetime' => $this->verify_datetime,
            Shg::getTableSchema()->fullName . '.verify_by' => $this->verify_by,
            Shg::getTableSchema()->fullName . '.verification_status' => $this->verification_status,
            Shg::getTableSchema()->fullName . '.verify_over_all' => $this->verify_over_all,
            Shg::getTableSchema()->fullName . '.created_by' => $this->created_by,
            Shg::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            Shg::getTableSchema()->fullName . '.created_at' => $this->created_at,
            Shg::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            Shg::getTableSchema()->fullName . '.status' => $this->status,
            Shg::getTableSchema()->fullName . '.cbo_vo_id' => $this->cbo_vo_id,
            Shg::getTableSchema()->fullName . '.shg_bank' => $this->shg_bank,
            Shg::getTableSchema()->fullName . '.urban_shg' => $this->urban_shg,
            Shg::getTableSchema()->fullName . '.bank_account_no_of_the_shg' => $this->bank_account_no_of_the_shg,
            Shg::getTableSchema()->fullName . '.is_bc' => $this->is_bc,
            Shg::getTableSchema()->fullName . '.suggest_samuh_sakhi' => $this->suggest_samuh_sakhi,
            Shg::getTableSchema()->fullName . '.suggest_samuh_sakhi_completed_application' => $this->suggest_samuh_sakhi_completed_application,
            Shg::getTableSchema()->fullName . '.shg_profile_updated' => $this->shg_profile_updated,
            Shg::getTableSchema()->fullName . '.urban_shg' => $this->urban_shg,
            Shg::getTableSchema()->fullName . '.bank_account_no_of_the_shg' => $this->bank_account_no_of_the_shg,
            Shg::getTableSchema()->fullName . '.wada_shg' => $this->wada,
        ]);

        $query->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.division_name', $this->division_name])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.district_name', $this->district_name])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.block_name', $this->block_name])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.gram_panchayat_name', $this->gram_panchayat_name])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.village_name', $this->village_name])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.hamlet', $this->hamlet])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.name_of_shg', $this->name_of_shg])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.shg_code', $this->shg_code])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.chaire_person_name', $this->chaire_person_name])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.chaire_person_mobile_no', $this->chaire_person_mobile_no])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.secretary_name', $this->secretary_name])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.treasurer_name', $this->treasurer_name])
                ->andFilterWhere(['like', Shg::getTableSchema()->fullName . '.treasurer_mobile_no', $this->treasurer_mobile_no]);

        return $dataProvider;
    }

}
