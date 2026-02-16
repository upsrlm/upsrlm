<?php

namespace bc\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\PartnerBankDistrictPlanning;
use common\models\master\MasterRole;

/**
 * PartnerBankDistrictPlanningSearch represents the model behind the search form of `bc\models\PartnerBankDistrictPlanning`.
 */
class PartnerBankDistrictPlanningSearch extends PartnerBankDistrictPlanning {

    public $district_option = [];
    public $bank_option = [];

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'master_partner_bank_id', 'district_code', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
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
        $query = PartnerBankDistrictPlanning::find();
        $query->joinWith(['district']);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([PartnerBankDistrictPlanning::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([PartnerBankDistrictPlanning::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } else {
                $query->where('0=1');
            }
        }
        $query->orderBy('master_district.district_name asc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            PartnerBankDistrictPlanning::getTableSchema()->fullName . '.id' => $this->id,
            PartnerBankDistrictPlanning::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            PartnerBankDistrictPlanning::getTableSchema()->fullName . '.district_code' => $this->district_code,
            PartnerBankDistrictPlanning::getTableSchema()->fullName . '.created_by' => $this->created_by,
            PartnerBankDistrictPlanning::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            PartnerBankDistrictPlanning::getTableSchema()->fullName . '.created_at' => $this->created_at,
            PartnerBankDistrictPlanning::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            PartnerBankDistrictPlanning::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        return $dataProvider;
    }

}
