<?php

namespace bc\models\transaction\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\transaction\master\MasterGramPanchayat;
use common\models\master\MasterRole;

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
    public $ca2_option = [];
    public $master_partner_bank_id;
    public $saheli;
    public $second_complete;
    public $third_complete;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'division_code', 'district_code', 'sub_district_code', 'block_code', 'gram_panchayat_code'], 'safe'],
            [['division_name', 'district_name', 'sub_district_name', 'block_name', 'gram_panchayat_name', 'gp_covert_urban'], 'safe'],
            [['master_partner_bank_id'], 'safe'],
            [['saheli'], 'safe'],
            [['second_complete'], 'safe'],
            [['third_complete'], 'safe'],
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
            $query->select([$columns]);
        }
        $query->joinWith(['gpdetail']);
        $query->andWhere(['master_gram_panchayat.status' => 1]);
        $query->andWhere(['!=', 'master_gram_panchayat.district_code', 0]);
        $query->andWhere(['!=', 'master_gram_panchayat.block_code', 0]);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_HR_ADMIN])) {
                
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
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
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
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                
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
        ]);

        $query->andFilterWhere(['like', 'master_gram_panchayat.division_name', $this->division_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.district_name', $this->district_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.sub_district_name', $this->sub_district_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.block_name', $this->block_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.gram_panchayat_name', $this->gram_panchayat_name]);

        return $dataProvider;
    }

    public function searchopenapplcation($params, $user_model = null, $pagination = true, $distinct_column = null, $columns = null, $array = false) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = MasterGramPanchayat::find();
        $query->joinWith(['gpdetail']);
        if ($columns != NULL) {
            $query->select([$columns]);
        }
        $query->andWhere(['master_gram_panchayat.status' => 1]);
        $query->andWhere(['master_gram_panchayat_detail_bc.third_vacant' => 1]);

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
        if ($this->master_partner_bank_id) {
            $query->joinWith(['partnerbank']);
            $query->andWhere([MasterPartnerBankDistrict::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id]);
        }
        if ($array) {
            $query->asArray();
        }
        $query->orderBy(['district_name' => SORT_ASC, 'block_name' => SORT_ASC, 'gram_panchayat_name' => SORT_ASC]);
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
            'master_gram_panchayat.district_code' => $this->district_code,
            'master_gram_panchayat.sub_district_code' => $this->sub_district_code,
            'master_gram_panchayat.block_code' => $this->block_code,
            'master_gram_panchayat.gram_panchayat_code' => $this->gram_panchayat_code,
            'master_gram_panchayat.gp_covert_urban' => $this->gp_covert_urban,
            'master_gram_panchayat_detail_bc.second_complete' => $this->second_complete,
            'master_gram_panchayat_detail_bc.third_complete' => $this->third_complete,
        ]);

        $query->andFilterWhere(['like', 'master_gram_panchayat.division_name', $this->division_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.district_name', $this->district_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.sub_district_name', $this->sub_district_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.block_name', $this->block_name])
                ->andFilterWhere(['like', 'master_gram_panchayat.gram_panchayat_name', $this->gram_panchayat_name]);

        return $dataProvider;
    }

}
