<?php

namespace bc\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\BcCumulativeReportDistrictPartnerBank;
use common\models\master\MasterRole;

/**
 * BcCumulativeReportDistrictPartnerBankSearch represents the model behind the search form of `bc\models\BcCumulativeReportDistrictPartnerBank`.
 */
class BcCumulativeReportDistrictPartnerBankSearch extends BcCumulativeReportDistrictPartnerBank {

    public $district_option = [];
    public $bank_option = [];
    public $aspirational;
    public $district_base_url = '/training/participants/certified';
    public $block_base_url = '/training/participants/certified';
    public $district_select_base_url = '/training/preselected';
    public $block_select_base_url = '/training/preselected';
    public $district_in_batch_base_url = '/training/preselected/inbatch';
    public $block_in_batch_base_url = '/training/preselected/inbatch';

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'district_code', 'master_partner_bank_id', 'blocked_bc', 'certified_bc', 'agree', 'unwilling', 'registered', 'not_certified', 'ineligible', 'absent', 'onboard_bc', 'pvr', 'shg_assigned', 'bc_shg_bank_verified', 'pfms_mapping', 'bc_support_fund_shg_transfer', 'bc_support_fund_shg_acknowledge', 'handheld_machine_provided', 'handheld_machine_acknowledge', 'operational', 'no_of_bc_shortlisted', 'urban', 'no_of_training_conculded', 'no_of_training_planned', 'no_of_bc_appeared_training', 'no_of_bc_registered', 'no_of_gp', 'no_of_unwilling', 'bc_bank_transaction_count'], 'safe'],
            [['district_name', 'partner_bank_name', 'date', 'last_updated_on'], 'safe'],
            [['bc_bank_transaction', 'bc_bank_transaction_avg_amt', 'honorarium_payment_to_bc'], 'safe'],
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
        $query = BcCumulativeReportDistrictPartnerBank::find();
        $query->joinWith(['district']);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
                $query->andWhere([BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
                $query->andWhere([BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } else {
                $query->where('0=1');
            }
        }
        if ($this->aspirational) {
            $query->andWhere([master\MasterDistrict::getTableSchema()->fullName . '.aspirational' => $this->aspirational]);
        }
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
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.id' => $this->id,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.blocked_bc' => $this->blocked_bc,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.certified_bc' => $this->certified_bc,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.agree' => $this->agree,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.unwilling' => $this->unwilling,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.registered' => $this->registered,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.not_certified' => $this->not_certified,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.ineligible' => $this->ineligible,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.absent' => $this->absent,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.onboard_bc' => $this->onboard_bc,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.pvr' => $this->pvr,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.shg_assigned' => $this->shg_assigned,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.bc_shg_bank_verified' => $this->bc_shg_bank_verified,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.pfms_mapping' => $this->pfms_mapping,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.bc_support_fund_shg_transfer' => $this->bc_support_fund_shg_transfer,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.bc_support_fund_shg_acknowledge' => $this->bc_support_fund_shg_acknowledge,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.handheld_machine_provided' => $this->handheld_machine_provided,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.handheld_machine_acknowledge' => $this->handheld_machine_acknowledge,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.operational' => $this->operational,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.bc_bank_transaction' => $this->bc_bank_transaction,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.no_of_bc_shortlisted' => $this->no_of_bc_shortlisted,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.urban' => $this->urban,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.no_of_training_conculded' => $this->no_of_training_conculded,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.no_of_training_planned' => $this->no_of_training_planned,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.no_of_bc_appeared_training' => $this->no_of_bc_appeared_training,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.no_of_bc_registered' => $this->no_of_bc_registered,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.no_of_gp' => $this->no_of_gp,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.no_of_unwilling' => $this->no_of_unwilling,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.bc_bank_transaction_avg_amt' => $this->bc_bank_transaction_avg_amt,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.bc_bank_transaction_count' => $this->bc_bank_transaction_count,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.honorarium_payment_to_bc' => $this->honorarium_payment_to_bc,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.date' => $this->date,
            BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.last_updated_on' => $this->last_updated_on,
        ]);

        $query->andFilterWhere(['like', BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.district_name', $this->district_name])
                ->andFilterWhere(['like', BcCumulativeReportDistrictPartnerBank::getTableSchema()->fullName . '.partner_bank_name', $this->partner_bank_name]);

        return $dataProvider;
    }
}
