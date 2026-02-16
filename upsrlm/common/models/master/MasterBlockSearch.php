<?php

namespace common\models\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\master\MasterBlockSearch;
use common\models\master\MasterRole;

/**
 * MasterBlockSearch represents the model behind the search form of `common\models\master\MasterBlock`.
 */
class MasterBlockSearch extends MasterBlock {

    public $division_option = [];
    public $district_option = [];
    public $block_option = [];
    public $saheli;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'division_code', 'district_code', 'sub_district_code', 'gram_panchayat_count', 'village_count'], 'safe'],
            [['division_name', 'district_name', 'sub_district_name', 'block_code', 'block_name', 'aspirational'], 'safe'],
            [['saheli'], 'safe'],
            [['wada_block'], 'safe'],
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

        $query = MasterBlock::find();
        $query->andWhere(['master_block.status' => 1]);
        if ($columns != NULL) {
            $query->select($columns);
        }
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_ULTRA_POOR_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_HR_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_ULB])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_RURAL_DD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_STATE_UNIT])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_PANCHAYATI_RAJ])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BOCW_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_AGRICULTURE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_AGRICULTURE_DEO])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DPRO])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DPM])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DSO])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BDO])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_ADO])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ADHIKARI])) {

                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAACHIV])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAHAYAK])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ROJGAR_SEVAK])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAFAI_KARMI])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GRAM_PARDHAN])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SECONDARY_ENUMERATOR])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_ADMIN])) {
                $query->joinWith(['district']);
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN])) {
                $query->joinWith(['district']);
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_ADMIN])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.wada_block' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_VIEWER])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.wada_block' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.wada_block' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {

                if ($user_model->inbound) {
                    
                } else {
                    $query->andWhere([MasterBlock::getTableSchema()->fullName . '.wada_block' => 1]);
                    $query->andWhere([MasterBlock::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
                }
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.wada_block' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.wada_block' => 1]);
                $query->andWhere([MasterBlock::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif ($user_model->id == '18123') {
                
            } else {
                $query->where('0=1');
            }
            if ($this->saheli) {
                $query->joinWith(['district']);
                $query->andWhere([MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
            }
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['district_name' => SORT_ASC, 'block_name' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'master_block.id' => $this->id,
            'master_block.division_code' => $this->division_code,
            'master_block.district_code' => $this->district_code,
            'master_block.sub_district_code' => $this->sub_district_code,
            'master_block.block_code' => $this->block_code,
            'master_block.wada_block' => $this->wada_block,
            'master_block.gram_panchayat_count' => $this->gram_panchayat_count,
            'master_block.village_count' => $this->village_count,
            'master_block.aspirational' => $this->aspirational,
        ]);

        $query->andFilterWhere(['like', 'master_block.division_name', $this->division_name])
                ->andFilterWhere(['like', 'master_block.district_name', $this->district_name])
                ->andFilterWhere(['like', 'master_block.sub_district_name', $this->sub_district_name])
                ->andFilterWhere(['like', 'master_block.block_name', $this->block_name]);

        return $dataProvider;
    }
}
