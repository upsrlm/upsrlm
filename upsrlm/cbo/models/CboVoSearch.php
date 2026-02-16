<?php

namespace cbo\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use cbo\models\CboVo;
use common\models\master\MasterRole;

/**
 * CboVoSearch represents the model behind the search form of `app\models\CboVo`.
 */
class CboVoSearch extends CboVo {

    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $vs_option = [];
    public $cast_option = [];
    public $mobile_type_option = [];
    public $samuh_sakhi;
    public $saheli;
    public $wada;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'state_code', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'no_of_shg_connected', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['state_name', 'division_name', 'district_name', 'block_name', 'gram_panchayat_name', 'name_of_vo', 'date_of_formation', 'bank_account_no_of_the_vo', 'name_of_bank', 'branch', 'branch_code_or_ifsc', 'date_of_opening_the_bank_account', 'nrlm_vo_code'], 'safe'],
            [['verify_vo_name_code_address', 'verify_vo_formation_date_no_shg', 'verify_vo_related_to_bank_account', 'verify_vo_total_amount', 'verify_vo_affiliated_shg_detail', 'verify_vo_members_detail', 'verify_vo_any_other_info', 'verification_status'], 'safe'],
            [['urban_vo'], 'safe'],
            [['samuh_sakhi'], 'safe'],
            [['samuh_sakhi_name'], 'safe'],
            [['samuh_sakhi_age'], 'safe'],
            [['samuh_sakhi_age', 'samuh_sakhi_cbo_shg_id', 'samuh_sakhi_mobile_type', 'samuh_sakhi_social_category', 'samuh_sakhi_detail_by'], 'safe'],
            [['samuh_sakhi_detail_date'], 'safe'],
            [['samuh_sakhi_name'], 'safe'],
            [['samuh_sakhi_mobile_no'], 'safe'],
            [['saheli', 'wada'], 'safe'],
            [['wada'], 'safe'],
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
        $query = CboVo::find();
        if ($columns != NULL) {
            $query->select([$columns]);
        }
        $query->andWhere(['!=', CboVo::getTableSchema()->fullName . '.status', -1]);

        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            $query->andWhere([CboVo::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([CboVo::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([CboVo::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([CboVo::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([CboVo::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                $query->andWhere([CboVo::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CBO_USER])) {
                $query->andWhere([CboVo::getTableSchema()->fullName . '.id' => \yii\helpers\ArrayHelper::getColumn($user_model->vo, 'cbo_id')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                //$query->andWhere([CboClf::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_ADMIN])) {
                $query->joinWith(['district']);
                $query->andWhere([\common\models\master\MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN])) {
                $query->joinWith(['district']);
                $query->andWhere([\common\models\master\MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
                $query->andWhere([CboVo::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_ADMIN])) {
                $query->andWhere([CboVo::getTableSchema()->fullName . '.wada' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([CboVo::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([CboVo::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } else {
                $query->where('0=1');
            }
        }
        if ($this->saheli) {
            $query->joinWith(['district']);
            $query->andWhere([\common\models\master\MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
        }
        if ($this->samuh_sakhi != '') {
            if ($this->samuh_sakhi == 0) {
                $query->andWhere([CboVo::getTableSchema()->fullName . '.samuh_sakhi_name' => NULL]);
            }
            if ($this->samuh_sakhi == 1) {
                $query->andWhere(['not', [CboVo::getTableSchema()->fullName . '.samuh_sakhi_name' => NULL]]);
            }
        }

        if ($columns != NULL) {
            $query->asArray();
        }
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

        // grid filtering conditions
        $query->andFilterWhere([
            CboVo::getTableSchema()->fullName . '.id' => $this->id,
            CboVo::getTableSchema()->fullName . '.state_code' => $this->state_code,
            CboVo::getTableSchema()->fullName . '.division_code' => $this->division_code,
            CboVo::getTableSchema()->fullName . '.district_code' => $this->district_code,
            CboVo::getTableSchema()->fullName . '.block_code' => $this->block_code,
            CboVo::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            CboVo::getTableSchema()->fullName . '.date_of_formation' => $this->date_of_formation,
            CboVo::getTableSchema()->fullName . '.no_of_shg_connected' => $this->no_of_shg_connected,
            CboVo::getTableSchema()->fullName . '.date_of_opening_the_bank_account' => $this->date_of_opening_the_bank_account,
            CboVo::getTableSchema()->fullName . '.nrlm_vo_code' => $this->nrlm_vo_code,
            CboVo::getTableSchema()->fullName . '.created_by' => $this->created_by,
            CboVo::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            CboVo::getTableSchema()->fullName . '.created_at' => $this->created_at,
            CboVo::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            CboVo::getTableSchema()->fullName . '.status' => $this->status,
            CboVo::getTableSchema()->fullName . '.verification_status' => $this->verification_status,
            CboVo::getTableSchema()->fullName . '.urban_vo' => $this->urban_vo,
            CboVo::getTableSchema()->fullName . '.samuh_sakhi_mobile_type' => $this->samuh_sakhi_mobile_type,
            CboVo::getTableSchema()->fullName . '.wada' => $this->wada,
        ]);

        $query->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.state_name', $this->state_name])
                ->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.division_name', $this->division_name])
                ->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.district_name', $this->district_name])
                ->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.block_name', $this->block_name])
                ->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.gram_panchayat_name', $this->gram_panchayat_name])
                ->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.name_of_vo', $this->name_of_vo])
                ->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.bank_account_no_of_the_vo', $this->bank_account_no_of_the_vo])
                ->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.name_of_bank', $this->name_of_bank])
                ->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.branch', $this->branch])
                ->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.branch_code_or_ifsc', $this->branch_code_or_ifsc]);

        return $dataProvider;
    }
    public function searchbccall($params, $user_model = null, $pagination = true, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = CboVo::find();
        if ($columns != NULL) {
            $query->select([$columns]);
        }
        $query->andWhere(['!=', CboVo::getTableSchema()->fullName . '.status', -1]);

        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            $query->andWhere([CboVo::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([CboVo::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([CboVo::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([CboVo::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([CboVo::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                $query->andWhere([CboVo::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CBO_USER])) {
                $query->andWhere([CboVo::getTableSchema()->fullName . '.id' => \yii\helpers\ArrayHelper::getColumn($user_model->vo, 'cbo_id')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                //$query->andWhere([CboClf::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_ADMIN])) {
                $query->joinWith(['district']);
                $query->andWhere([\common\models\master\MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN])) {
                $query->joinWith(['district']);
                $query->andWhere([\common\models\master\MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
                $query->andWhere([CboVo::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_ADMIN])) {
                $query->andWhere([CboVo::getTableSchema()->fullName . '.wada' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE])) {
                //$query->andWhere([CboVo::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {
                //$query->andWhere([CboVo::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } else {
                $query->where('0=1');
            }
        }
        if ($this->saheli) {
            $query->joinWith(['district']);
            $query->andWhere([\common\models\master\MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
        }
        if ($this->samuh_sakhi != '') {
            if ($this->samuh_sakhi == 0) {
                $query->andWhere([CboVo::getTableSchema()->fullName . '.samuh_sakhi_name' => NULL]);
            }
            if ($this->samuh_sakhi == 1) {
                $query->andWhere(['not', [CboVo::getTableSchema()->fullName . '.samuh_sakhi_name' => NULL]]);
            }
        }

        if ($columns != NULL) {
            $query->asArray();
        }
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

        // grid filtering conditions
        $query->andFilterWhere([
            CboVo::getTableSchema()->fullName . '.id' => $this->id,
            CboVo::getTableSchema()->fullName . '.state_code' => $this->state_code,
            CboVo::getTableSchema()->fullName . '.division_code' => $this->division_code,
            CboVo::getTableSchema()->fullName . '.district_code' => $this->district_code,
            CboVo::getTableSchema()->fullName . '.block_code' => $this->block_code,
            CboVo::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            CboVo::getTableSchema()->fullName . '.date_of_formation' => $this->date_of_formation,
            CboVo::getTableSchema()->fullName . '.no_of_shg_connected' => $this->no_of_shg_connected,
            CboVo::getTableSchema()->fullName . '.date_of_opening_the_bank_account' => $this->date_of_opening_the_bank_account,
            CboVo::getTableSchema()->fullName . '.nrlm_vo_code' => $this->nrlm_vo_code,
            CboVo::getTableSchema()->fullName . '.created_by' => $this->created_by,
            CboVo::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            CboVo::getTableSchema()->fullName . '.created_at' => $this->created_at,
            CboVo::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            CboVo::getTableSchema()->fullName . '.status' => $this->status,
            CboVo::getTableSchema()->fullName . '.verification_status' => $this->verification_status,
            CboVo::getTableSchema()->fullName . '.urban_vo' => $this->urban_vo,
            CboVo::getTableSchema()->fullName . '.samuh_sakhi_mobile_type' => $this->samuh_sakhi_mobile_type,
            CboVo::getTableSchema()->fullName . '.wada' => $this->wada,
        ]);

        $query->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.state_name', $this->state_name])
                ->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.division_name', $this->division_name])
                ->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.district_name', $this->district_name])
                ->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.block_name', $this->block_name])
                ->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.gram_panchayat_name', $this->gram_panchayat_name])
                ->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.name_of_vo', $this->name_of_vo])
                ->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.bank_account_no_of_the_vo', $this->bank_account_no_of_the_vo])
                ->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.name_of_bank', $this->name_of_bank])
                ->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.branch', $this->branch])
                ->andFilterWhere(['like', CboVo::getTableSchema()->fullName . '.branch_code_or_ifsc', $this->branch_code_or_ifsc]);

        return $dataProvider;
    }

}
