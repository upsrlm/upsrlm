<?php

namespace bc\models\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\master\MasterDistrict;
use common\models\master\MasterRole;

/**
 * MasterDistrictSearch represents the model behind the search form of `common\models\master\MasterDistrict`.
 */
class MasterDistrictSearch extends MasterDistrict {

    public $division_option = [];
    public $district_option = [];
    public $filters;
    public $master_partner_bank_id;
    public $all;
    public $igrs;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'division_code', 'ulb_count', 'block_count', 'gram_panchayat_count', 'village_count'], 'safe'],
            [['division_name', 'district_code', 'district_name', 'lat', 'lng', 'state_code'], 'safe'],
            [['state_name', 'bc_selection_application_receive', 'bc_selection_sc_st_application_receive', 'bc_selection_obc_application_receive', 'bc_selection_general_application_receive', 'group_member', 'aspirational_block'], 'safe'],
            [['filters'], 'safe'],
            [['master_partner_bank_id'], 'safe'],
            [['wada_district', 'saheli'], 'safe'],
            [['all'], 'safe'],
            [['aspirational'], 'safe'],
            [['igrs'], 'safe']
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
    public function search($params, $user_model = null, $pagination = true, $columns = null, $array = false) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }

        $query = MasterDistrict::find();
        if ($columns != NULL) {
            $query->select($columns);
        }
        if ($user_model == NULL) {
//            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_HR_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_ULB])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_RURAL_DD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_STATE_UNIT])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_PANCHAYATI_RAJ])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RBI])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DSO])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BDO])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'district.district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'district.district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ADHIKARI])) {

                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAACHIV])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SECONDARY_ENUMERATOR])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_URBAN_PRIMARY_ENUMERATOR])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->ulbs, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_URBAN_SECONDARY_ENUMERATOR])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->ulbs, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MC])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->ulbs, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR])) {
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                //$query->andWhere([MasterDistrict::getTableSchema()->fullName . '.wada_district' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {
                //$query->andWhere([MasterDistrict::getTableSchema()->fullName . '.wada_district' => 1]);
            } elseif ($user_model->id == '18123') {
                
            } else {
                $query->where('0=1');
            }
        }
        if ($this->igrs) {
            $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.district_code' => \Yii::$app->params['igrs_disricts']]);
        }
        if ($this->master_partner_bank_id) {
            $query->joinWith(['partnerbank']);
            $query->andWhere([MasterPartnerBankDistrict::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id]);
        }
        // add conditions that should always apply here
        if ($array) {
            $query->asArray();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['district_name' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'master_district.id' => $this->id,
            'master_district.state_code' => $this->state_code,
            'master_district.division_code' => $this->division_code,
            'master_district.district_code' => $this->district_code,
            'master_district.ulb_count' => $this->ulb_count,
            'master_district.block_count' => $this->block_count,
            'master_district.gram_panchayat_count' => $this->gram_panchayat_count,
            'master_district.village_count' => $this->village_count,
            'master_district.wada_district' => $this->wada_district,
            'master_district.saheli' => $this->saheli,
            'master_district.aspirational' => $this->aspirational
        ]);

        $query->andFilterWhere(['like', 'master_district.division_name', $this->division_name])
                ->andFilterWhere(['like', 'master_district.district_name', $this->district_name]);

        return $dataProvider;
    }
}
