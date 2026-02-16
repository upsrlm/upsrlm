<?php

namespace bc\models\transaction\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\transaction\master\MasterVillage;
use common\models\master\MasterRole;

/**
 * MasterVillageSearch represents the model behind the search form of `bc\models\master\MasterVillage`.
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
        $query->andWhere(['master_village.status' => 1]);
        if ($user_model == NULL) {
            
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
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DSO])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BDO])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ADHIKARI])) {

                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAACHIV])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SECONDARY_ENUMERATOR])) {
                $query->andWhere([MasterVillage::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif ($user_model->id == '18123') {
                
            } else {
                $query->where('0=1');
            }
            if ($distinct_column != null) {
                if ($distinct_column == static::$coll_district) {

                    $query->select(MasterVillage::getTableSchema()->fullName . '.district_code,master_village.district_name');
                    $query->distinct();
                    $query->orderBy('master_village.district_name');
                }
                if ($distinct_column == static::$coll_sub_district) {

                    $query->select(MasterVillage::getTableSchema()->fullName . '.sub_district_code,master_village.sub_district_name');
                    $query->distinct();
                    $query->orderBy('master_village.sub_district_name');
                }
                if ($distinct_column == static::$coll_village) {

                    $query->select(MasterVillage::getTableSchema()->fullName . '.village_code,master_village.village_name,master_village.gram_panchayat_name');
                    $query->distinct();
                    $query->orderBy('master_village.village_name');
                }
                if ($distinct_column == static::$coll_gram_panchayat) {

                    $query->select(MasterVillage::getTableSchema()->fullName . '.gram_panchayat_id,master_village.gram_panchayat_name');
                    $query->distinct();
                    $query->orderBy('master_village.gram_panchayat_name asc');
                }
                if ($distinct_column == static::$coll_block) {

                    $query->select(MasterVillage::getTableSchema()->fullName . '.block_code,master_village.block_name');
                    $query->distinct();
                    $query->orderBy('master_village.block_name asc');
                }
            }
        }
        if ($array) {
            $query->asArray();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['village_name' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'division_code' => $this->division_code,
            'district_code' => $this->district_code,
            'sub_district_code' => $this->sub_district_code,
            'village_code' => $this->village_code,
            'gram_panchayat_code' => $this->gram_panchayat_code,
            'block_code' => $this->block_code,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'division_name', $this->division_name])
                ->andFilterWhere(['like', 'district_name', $this->district_name])
                ->andFilterWhere(['like', 'sub_district_name', $this->sub_district_name])
                ->andFilterWhere(['like', 'village_name', $this->village_name])
                ->andFilterWhere(['like', 'gram_panchayat_name', $this->gram_panchayat_name])
                ->andFilterWhere(['like', 'block_name', $this->block_name]);

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
