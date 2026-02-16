<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiaryBasicEducationPayment;
use common\models\master\MasterRole;

/**
 * DbtBeneficiaryBasicEducationPaymentSearch represents the model behind the search form of `common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiaryBasicEducationPayment`.
 */
class DbtBeneficiaryBasicEducationPaymentSearch extends DbtBeneficiaryBasicEducationPayment {

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
            [['id', 'state_code', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'bank_id', 'created_at', 'created_by', 'updated_by', 'updated_at', 'status'], 'integer'],
            [['name_of_beneficiary', 'state_name', 'division_name', 'district_name', 'block_name', 'gram_panchayat_name', 'mobile_no', 'bank_name', 'bank_account_number', 'payment_date', 'transactionId'], 'safe'],
            [['amount_remited'], 'number'],
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
        $query = DbtBeneficiaryBasicEducationPayment::find();

        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BOCW_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DSO])) {
                $query->andWhere([DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BDO])) {
                $query->andWhere([DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CBO_USER]) and isset($user_model->cboprofile) and $user_model->cboprofile->bc) {
                $query->andWhere([DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.gram_panchayat_code' => $user_model->cboprofile->gram_panchayat_code]);
            } else {
                $query->where('0=1');
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['payment_date' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.id' => $this->id,
            DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.state_code' => $this->state_code,
            DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.division_code' => $this->division_code,
            DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.district_code' => $this->district_code,
            DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.block_code' => $this->block_code,
            DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.bank_id' => $this->bank_id,
            DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.amount_remited' => $this->amount_remited,
            DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.payment_date' => $this->payment_date,
            DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.created_at' => $this->created_at,
            DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.created_by' => $this->created_by,
            DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.name_of_beneficiary', $this->name_of_beneficiary])
                ->andFilterWhere(['like', DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.state_name', $this->state_name])
                ->andFilterWhere(['like', DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.division_name', $this->division_name])
                ->andFilterWhere(['like', DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.district_name', $this->district_name])
                ->andFilterWhere(['like', DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.block_name', $this->block_name])
                ->andFilterWhere(['like', DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.gram_panchayat_name', $this->gram_panchayat_name])
                ->andFilterWhere(['like', DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.bank_name', $this->bank_name])
                ->andFilterWhere(['like', DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.bank_account_number', $this->bank_account_number])
                ->andFilterWhere(['like', DbtBeneficiaryBasicEducationPayment::getTableSchema()->fullName . '.transactionId', $this->transactionId]);

        return $dataProvider;
    }

}
