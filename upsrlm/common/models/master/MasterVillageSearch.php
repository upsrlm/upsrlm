<?php

namespace common\models\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\master\MasterVillage;
use common\models\master\MasterRole;

/**
 * MasterVillageSearch represents the model behind the search form of `common\models\master\MasterVillage`.
 */
class MasterVillageSearch extends MasterVillage {

    public static $coll_district = 'district_code';
    public static $coll_sub_district = 'sub_district_code';
    public static $coll_village = 'village_code';
    public static $coll_block = 'block_code';
    public static $coll_gram_panchayat = 'gram_panchayat_id';
    public $division_option = [];
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $village_option = [];
    public $saheli;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'division_code', 'district_code', 'sub_district_code', 'village_code', 'gram_panchayat_code', 'block_code', 'status'], 'integer'],
            [['division_name', 'district_name', 'sub_district_name', 'village_name', 'gram_panchayat_name', 'block_name'], 'safe'],
            [['saheli'], 'safe'],
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
        $query = MasterVillage::find();
        if ($columns != NULL) {
            $query->select($columns);
        }
        $query->andWhere(['master_village.status' => 1]);
        if ($user_model == NULL) {
            
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
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
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BOCW_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_AGRICULTURE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_AGRICULTURE_DEO])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DPRO])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DPM])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DSO])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BDO])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_ADO])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ADHIKARI])) {

                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAACHIV])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAHAYAK])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ROJGAR_SEVAK])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAFAI_KARMI])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GRAM_PARDHAN])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SECONDARY_ENUMERATOR])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_ADMIN])) {
                $query->joinWith(['districts']);
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN])) {
                $query->joinWith(['districts']);
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE])) {
                
            } elseif ($user_model->id == '18123') {
                
            } else {
                $query->where('0=1');
            }
            if ($this->saheli) {
                $query->joinWith(['districts']);
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
            }
            if ($distinct_column != null) {
                if ($distinct_column == static::$coll_district) {

                  $query->select([
    'master_village.district_code',
    'master_village.district_name',
]);

$query->groupBy([
    'master_village.district_code',
    'master_village.district_name',
]);

$query->orderBy([
    'master_village.district_name' => SORT_ASC,
]);

                }
                if ($distinct_column == static::$coll_sub_district) {

                  $query->select([
    'master_village.sub_district_code',
    'master_village.sub_district_name',
]);

$query->groupBy([
    'master_village.sub_district_code',
    'master_village.sub_district_name',
]);

$query->orderBy([
    'master_village.sub_district_name' => SORT_ASC,
]);

                }
                if ($distinct_column == static::$coll_village) {

                  $query->select([
    'master_village.village_code',
    'master_village.village_name',
]);

$query->groupBy([
    'master_village.village_code',
    'master_village.village_name',
]);

$query->orderBy([
    'master_village.village_name' => SORT_ASC,
]);

                }
                if ($distinct_column == static::$coll_gram_panchayat) {

                 $query->select([
    'master_village.gram_panchayat_id',
    'master_village.gram_panchayat_name',
]);

$query->groupBy([
    'master_village.gram_panchayat_id',
    'master_village.gram_panchayat_name',
]);

$query->orderBy([
    'master_village.gram_panchayat_name' => SORT_ASC,
]);

                }
                if ($distinct_column == static::$coll_block) {
$query->select([
    'master_village.block_code',
    'master_village.block_name',
]);
$query->groupBy([
    'master_village.block_code',
    'master_village.block_name',
]);
$query->orderBy(['master_village.block_name' => SORT_ASC]);

                }
            }
        }
        if ($array) {
            $query->asArray();
        }
     $sort = false;

if ($distinct_column === null) {
    $sort = ['defaultOrder' => ['village_name' => SORT_ASC]];
}

$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'pagination' => $pagination === false
        ? false
        : ['pageSize' => $pagination === true ? 100 : $pagination],
    'sort' => $sort,
]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'master_village.id' => $this->id,
            'master_village.division_code' => $this->division_code,
            'master_village.district_code' => $this->district_code,
            'master_village.sub_district_code' => $this->sub_district_code,
            'master_village.village_code' => $this->village_code,
            'master_village.gram_panchayat_code' => $this->gram_panchayat_code,
            'master_village.block_code' => $this->block_code,
            'master_village.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'master_village.division_name', $this->division_name])
                ->andFilterWhere(['like', 'master_village.district_name', $this->district_name])
                ->andFilterWhere(['like', 'master_village.sub_district_name', $this->sub_district_name])
                ->andFilterWhere(['like', 'master_village.village_name', $this->village_name])
                ->andFilterWhere(['like', 'master_village.gram_panchayat_name', $this->gram_panchayat_name])
                ->andFilterWhere(['like', 'master_village.block_name', $this->block_name]);

        return $dataProvider;
    }

    public function getdistrict($sub_dist_id) {
        $arr = [];
        if ($sub_dist_id != '') {
            $m = MasterVillage::find()->where(['sub_district_code' => $sub_dist_id])->one();
            $arr[$sub_dist_id] = $m->sub_district_name;
        }
        return $arr;
    }

    public function getblock($sub_block_id) {
        $arr = [];
        if ($sub_block_id != '') {
            $m = MasterVillage::find()->where(['block_code' => $sub_block_id])->one();
            $arr[$sub_block_id] = $m->block_name;
        }
        return $arr;
    }
}
