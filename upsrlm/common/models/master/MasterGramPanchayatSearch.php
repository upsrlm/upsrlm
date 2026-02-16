<?php

namespace common\models\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\master\MasterGramPanchayat;

/**
 * MasterGramPanchayatSearch represents the model behind the search form of `common\models\master\MasterGramPanchayat`.
 */
class MasterGramPanchayatSearch extends MasterGramPanchayat {

    public static $coll_district = 'district_code';
    public static $coll_block = 'block_code';
    public static $coll_gram_panchayat = 'gram_panchayat_code';
    public static $coll_village = 'village_code';
    public $division_option = [];
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $saheli;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'division_code', 'district_code', 'sub_district_code', 'block_code', 'gram_panchayat_code'], 'integer'],
            [['division_name', 'district_name', 'sub_district_name', 'block_name', 'gram_panchayat_name', 'gp_covert_urban', 'new', 'new_status', 'name_match_status', 'doubt_block'], 'safe'],
            [['saheli'], 'safe'],
            [['wada_gp'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true, $distinct_column = null, $columns = null, $array = false) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = MasterGramPanchayat::find();
        if ($columns != NULL) {
            $query->select($columns);
        }
        $query->andWhere(['master_gram_panchayat.status' => 1]);
        $query->andWhere(['!=', 'master_gram_panchayat.district_code', 0]);
        $query->andWhere(['!=', 'master_gram_panchayat.block_code', 0]);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_ULTRA_POOR_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_HR_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_ULB])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_RURAL_DD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_PANCHAYATI_RAJ])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_AGRICULTURE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_AGRICULTURE_DEO])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DPRO])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_DPM])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DSO])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BDO])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_ADO])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ADHIKARI])) {

                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAACHIV])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAHAYAK])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ROJGAR_SEVAK])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAFAI_KARMI])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GRAM_PARDHAN])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SECONDARY_ENUMERATOR])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_ADMIN])) {
                $query->joinWith(['district']);
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN])) {
                $query->joinWith(['district']);
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_ADMIN])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BOCW_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_VIEWER])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE])) {
                if ($user_model->inbound) {
                    
                } else {
                    $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => 1]);
                    $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
                }
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => 1]);
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif ($user_model->id == '18123') {
                
            } else {
                $query->where('0=1');
            }
        }
        if ($this->saheli) {
            $query->joinWith(['district']);
            $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
        }
        if ($distinct_column != null) {
            if ($distinct_column == static::$coll_district) {

                $query->select(['master_gram_panchayat.district_code', 'master_gram_panchayat.district_name']);
                $query->groupBy('master_gram_panchayat.district_code');
                $query->orderBy('master_gram_panchayat.district_name asc');
            }
            if ($distinct_column == static::$coll_gram_panchayat) {
                $query->select(['master_gram_panchayat.gram_panchayat_code', 'master_gram_panchayat.gram_panchayat_name']);
                $query->groupBy('master_gram_panchayat.gram_panchayat_code');
                $query->orderBy('master_gram_panchayat.gram_panchayat_name asc');
            }
            if ($distinct_column == static::$coll_block) {

                $query->select(['master_gram_panchayat.block_code', 'master_gram_panchayat.block_name']);
                $query->groupBy('master_gram_panchayat.block_code');
                $query->orderBy('master_gram_panchayat.block_name asc');
            }
        }
// add conditions that should always apply here
        if ($array) {
            $query->asArray();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['gram_panchayat_name' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }


        $query->andFilterWhere([
            'master_gram_panchayat.id' => $this->id,
            'master_gram_panchayat.division_code' => $this->division_code,
            'master_gram_panchayat.district_code' => $this->district_code,
            'master_gram_panchayat.sub_district_code' => $this->sub_district_code,
            'master_gram_panchayat.block_code' => $this->block_code,
            'master_gram_panchayat.gram_panchayat_code' => $this->gram_panchayat_code,
            'master_gram_panchayat.gp_covert_urban' => $this->gp_covert_urban,
            'master_gram_panchayat.new' => $this->new,
            'master_gram_panchayat.new_status' => $this->new_status,
            'master_gram_panchayat.name_match_status' => $this->name_match_status,
            'master_gram_panchayat.doubt_block' => $this->doubt_block,
            'master_gram_panchayat.wada_gp' => $this->wada_gp,
        ]);

        $query->andFilterWhere(['like', 'master_gram_panchayat.division_name', $this->division_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.district_name', $this->district_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.sub_district_name', $this->sub_district_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.block_name', $this->block_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.gram_panchayat_name', $this->gram_panchayat_name]);

        return $dataProvider;
    }

    public function searchurban($params, $user_model = null, $pagination = true, $distinct_column = null, $columns = null, $array = false) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = MasterGramPanchayat::find();
        if ($columns != NULL) {
            $query->select($columns);
        }
        $query->andWhere(['master_gram_panchayat.status' => 0]);
        $query->andWhere(['!=', 'master_gram_panchayat.district_code', 0]);
        $query->andWhere(['!=', 'master_gram_panchayat.block_code', 0]);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_ULTRA_POOR_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_HR_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_ULB])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_RURAL_DD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_PANCHAYATI_RAJ])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DSO])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BDO])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ADHIKARI])) {

                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAACHIV])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAHAYAK])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ROJGAR_SEVAK])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAFAI_KARMI])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GRAM_PARDHAN])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SECONDARY_ENUMERATOR])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_ADMIN])) {
                $query->joinWith(['district']);
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN])) {
                $query->joinWith(['district']);
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_ADMIN])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BOCW_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_VIEWER])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE])) {
                if ($user_model->inbound) {
                    
                } else {
                    $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => 1]);
                    $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
                }
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.wada_gp' => 1]);
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif ($user_model->id == '18123') {
                
            } else {
                $query->where('0=1');
            }
        }
        if ($this->saheli) {
            $query->joinWith(['district']);
            $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
        }
        if ($distinct_column != null) {
            if ($distinct_column == static::$coll_district) {

                $query->select(['master_gram_panchayat.district_code', 'master_gram_panchayat.district_name']);
                $query->groupBy('master_gram_panchayat.district_code');
                $query->orderBy('master_gram_panchayat.district_name asc');
            }
            if ($distinct_column == static::$coll_gram_panchayat) {
                $query->select(['master_gram_panchayat.gram_panchayat_code', 'master_gram_panchayat.gram_panchayat_name']);
                $query->groupBy('master_gram_panchayat.gram_panchayat_code');
                $query->orderBy('master_gram_panchayat.gram_panchayat_name asc');
            }
            if ($distinct_column == static::$coll_block) {

                $query->select(['master_gram_panchayat.block_code', 'master_gram_panchayat.block_name']);
                $query->groupBy('master_gram_panchayat.block_code');
                $query->orderBy('master_gram_panchayat.block_name asc');
            }
        }
// add conditions that should always apply here
        if ($array) {
            $query->asArray();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['gram_panchayat_name' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }


        $query->andFilterWhere([
            'master_gram_panchayat.id' => $this->id,
            'master_gram_panchayat.division_code' => $this->division_code,
            'master_gram_panchayat.district_code' => $this->district_code,
            'master_gram_panchayat.sub_district_code' => $this->sub_district_code,
            'master_gram_panchayat.block_code' => $this->block_code,
            'master_gram_panchayat.gram_panchayat_code' => $this->gram_panchayat_code,
            'master_gram_panchayat.gp_covert_urban' => $this->gp_covert_urban,
            'master_gram_panchayat.new' => $this->new,
            'master_gram_panchayat.new_status' => $this->new_status,
            'master_gram_panchayat.name_match_status' => $this->name_match_status,
            'master_gram_panchayat.doubt_block' => $this->doubt_block,
            'master_gram_panchayat.wada_gp' => $this->wada_gp,
        ]);

        $query->andFilterWhere(['like', 'master_gram_panchayat.division_name', $this->division_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.district_name', $this->district_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.sub_district_name', $this->sub_district_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.block_name', $this->block_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.gram_panchayat_name', $this->gram_panchayat_name]);

        return $dataProvider;
    }

    public function searchlist($params, $user_model = null, $pagination = true, $distinct_column = null, $columns = null, $array = false) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = MasterGramPanchayat::find();
        if ($columns != NULL) {
            $query->select([$columns]);
        }
        $query->andWhere(['!=', 'master_gram_panchayat.district_code', 0]);
//        $query->andWhere(['!=', 'master_gram_panchayat.block_code', 0]);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_HR_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_ULB])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_RURAL_DD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_PANCHAYATI_RAJ])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DSO])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BDO])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ADHIKARI])) {

                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAACHIV])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SECONDARY_ENUMERATOR])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif ($user_model->id == '18123') {
                
            } else {
                $query->where('0=1');
            }
        }
        if ($distinct_column != null) {
            if ($distinct_column == static::$coll_district) {

                $query->select(['master_gram_panchayat.district_code', 'master_gram_panchayat.district_name']);
                $query->groupBy('master_gram_panchayat.district_code');
                $query->orderBy('master_gram_panchayat.district_name asc');
            }
            if ($distinct_column == static::$coll_gram_panchayat) {
                $query->select(['master_gram_panchayat.gram_panchayat_code', 'master_gram_panchayat.gram_panchayat_name']);
                $query->groupBy('master_gram_panchayat.gram_panchayat_code');
                $query->orderBy('master_gram_panchayat.gram_panchayat_name asc');
            }
            if ($distinct_column == static::$coll_block) {

                $query->select(['master_gram_panchayat.block_code', 'master_gram_panchayat.block_name']);
                $query->groupBy('master_gram_panchayat.block_code');
                $query->orderBy('master_gram_panchayat.block_name asc');
            }
        }
// add conditions that should always apply here
        if ($array) {
            $query->asArray();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['gram_panchayat_name' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }


        $query->andFilterWhere([
            'master_gram_panchayat.id' => $this->id,
            'master_gram_panchayat.division_code' => $this->division_code,
            'master_gram_panchayat.district_code' => $this->district_code,
            'master_gram_panchayat.sub_district_code' => $this->sub_district_code,
            'master_gram_panchayat.block_code' => $this->block_code,
            'master_gram_panchayat.gram_panchayat_code' => $this->gram_panchayat_code,
            'master_gram_panchayat.gp_covert_urban' => $this->gp_covert_urban,
            'master_gram_panchayat.new' => $this->new,
            'master_gram_panchayat.new_status' => $this->new_status,
            'master_gram_panchayat.name_match_status' => $this->name_match_status,
            'master_gram_panchayat.doubt_block' => $this->doubt_block,
        ]);

        $query->andFilterWhere(['like', 'master_gram_panchayat.division_name', $this->division_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.district_name', $this->district_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.sub_district_name', $this->sub_district_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.block_name', $this->block_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.gram_panchayat_name', $this->gram_panchayat_name]);

        return $dataProvider;
    }
}
