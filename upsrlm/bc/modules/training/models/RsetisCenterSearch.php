<?php

namespace bc\modules\training\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\training\models\RsetisCenter;
use common\models\master\MasterRole;

/**
 * RsetisCenterSearch represents the model behind the search form of `bc\modules\training\models\RsetisCenterSearch`.
 */
class RsetisCenterSearch extends RsetisCenter {

    public $district_option = [];
    public $center_option = [];
    public $bc_partner_bank_option = [];
    public $rsethi_bank_option = [];
    public $bank_option = [];
    public $rsethi_bank;
    public $bc_partner_bank;
    public $master_partner_bank_id;
    public $aspirational;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['district_code', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'safe'],
            [['name', 'district_name', 'gps', 'venue'], 'safe'],
            [['rsethi_bank', 'bc_partner_bank'], 'safe'],
            [['master_partner_bank_id'], 'safe'],
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
        $query = RsetisCenter::find();
        if ($columns != NULL) {
            $query->select([$columns]);
        }
        $query->andWhere([RsetisCenter::getTableSchema()->fullName . '.status' => 1]);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $query->andWhere([RsetisCenter::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR])) {
                $query->andWhere([RsetisCenter::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([RsetisCenter::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([RsetisCenter::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([RsetisCenter::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $query->andWhere([RsetisCenter::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([RsetisCenter::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([RsetisCenter::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } else {
                $query->where('0=1');
            }
        }
        if ($columns != NULL) {
            $query->asArray();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['name' => SORT_ASC]],
        ]);
        if (isset($this->rsethi_bank) and $this->rsethi_bank != '') {
            $query->joinWith(['rsethileadbank']);
            $query->andWhere(['user_profile.bank_name' => $this->rsethi_bank]);
        }
        if (isset($this->bc_partner_bank) and $this->bc_partner_bank != '') {
            $query->joinWith(['bcbankpartner']);

            $query->andWhere(['user.id' => $this->bc_partner_bank]);
        }
        if (isset($this->master_partner_bank_id) and $this->master_partner_bank_id != '') {
            $query->joinWith(['pbank']);
            $query->andWhere(['master_partner_bank_district.master_partner_bank_id' => $this->master_partner_bank_id]);
        }
        if ($this->aspirational != '') {
            $query->joinWith(['district']);
            $query->andWhere([\bc\models\master\MasterDistrict::getTableSchema()->fullName . '.aspirational' => $this->aspirational]);
        }
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            RsetisCenter::getTableSchema()->fullName . '.id' => $this->id,
            RsetisCenter::getTableSchema()->fullName . '.district_code' => $this->district_code,
        ]);

        $query->andFilterWhere(['=', RsetisCenter::getTableSchema()->fullName . '.district_code', $this->district_code])
                ->andFilterWhere(['like', RsetisCenter::getTableSchema()->fullName . '.district_name', $this->district_name])
                ->andFilterWhere(['like', RsetisCenter::getTableSchema()->fullName . '.name', $this->name])
                ->andFilterWhere(['like', 'gps', $this->gps]);

        return $dataProvider;
    }
}
