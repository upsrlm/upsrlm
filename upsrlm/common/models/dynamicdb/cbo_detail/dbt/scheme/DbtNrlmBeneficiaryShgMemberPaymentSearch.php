<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtNrlmBeneficiaryShgMemberPayment;
use common\models\master\MasterRole;

/**
 * DbtNrlmBeneficiaryShgMemberPaymentSearch represents the model behind the search form of `common\models\dynamicdb\cbo_detail\dbt\scheme\DbtNrlmBeneficiaryShgMemberPayment`.
 */
class DbtNrlmBeneficiaryShgMemberPaymentSearch extends DbtNrlmBeneficiaryShgMemberPayment {

    public $division_option = [];
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $wada;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'cbo_shg_id', 'type_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['division_name', 'district_name', 'block_name', 'gram_panchayat_name', 'village_name', 'shg_name', 'shg_code', 'shg_member_name', 'husband_name', 'payment_date', 'type'], 'safe'],
            [['payment_amt'], 'number'],
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
        $query = DbtNrlmBeneficiaryShgMemberPayment::find();

        // add conditions that should always apply here

        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BOCW_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DSO])) {
                $query->andWhere([DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BDO])) {
                $query->andWhere([DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } else {
                $query->where('0=1');
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['shg_member_name' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.id' => $this->id,
            DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.division_code' => $this->division_code,
            DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.district_code' => $this->district_code,
            DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.block_code' => $this->block_code,
            DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.village_code' => $this->village_code,
            DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.cbo_shg_id' => $this->cbo_shg_id,
            DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.payment_date' => $this->payment_date,
            DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.payment_amt' => $this->payment_amt,
            DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.type_id' => $this->type_id,
            DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.created_at' => $this->created_at,
            DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.division_name', $this->division_name])
                ->andFilterWhere(['like', DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.district_name', $this->district_name])
                ->andFilterWhere(['like', DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.block_name', $this->block_name])
                ->andFilterWhere(['like', DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.gram_panchayat_name', $this->gram_panchayat_name])
                ->andFilterWhere(['like', DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.village_name', $this->village_name])
                ->andFilterWhere(['like', DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.shg_name', $this->shg_name])
                ->andFilterWhere(['like', DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.shg_code', $this->shg_code])
                ->andFilterWhere(['like', DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.shg_member_name', $this->shg_member_name])
                ->andFilterWhere(['like', DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.husband_name', $this->husband_name])
                ->andFilterWhere(['like', DbtNrlmBeneficiaryShgMemberPayment::getTableSchema()->fullName . '.type', $this->type]);

        return $dataProvider;
    }

}
