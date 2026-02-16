<?php

namespace bc\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\BcCumulativeReportDistrict;
use common\models\master\MasterRole;

/**
 * BcCumulativeReportDistrictSearch represents the model behind the search form of `bc\models\BcCumulativeReportDistrict`.
 */
class BcCumulativeReportDistrictSearch extends BcCumulativeReportDistrict {

    public $district_option = [];
    public $bank_option = [];
    public $aspirational;
    public $district_base_url = '/training/participants/certified';
    public $block_base_url = '/training/participants/certified';
    public $district_select_base_url = '/training/preselected';
    public $district_in_batch_base_url = '/training/preselected/inbatch';
    public $block_in_batch_base_url = '/training/preselected/inbatch';
    public $block_select_base_url = '/training/preselected';

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'district_code', 'master_partner_bank_id', 'certified_bc', 'onboard_bc', 'pvr', 'shg_assigned', 'bc_shg_bank_verified', 'pfms_mapping', 'bc_support_fund_shg_transfer', 'bc_support_fund_shg_acknowledge', 'handheld_machine_provided', 'handheld_machine_acknowledge', 'no_of_bc_shortlisted', 'no_of_training_conculded', 'no_of_training_planned', 'no_of_bc_appeared_training', 'no_of_gp', 'no_of_unwilling', 'bc_bank_transaction_count'], 'safe'],
            [['district_name', 'partner_bank_name', 'date', 'last_updated_on'], 'safe'],
            [['bc_bank_transaction', 'bc_bank_transaction_avg_amt', 'honorarium_payment_to_bc'], 'number'],
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
        $query = BcCumulativeReportDistrict::find();
        $query->joinWith(['district']);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_STATE_UNIT])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {

                $query->andWhere([BcCumulativeReportDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([BcCumulativeReportDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([BcCumulativeReportDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                //$query->andWhere([BcCumulativeReportDistrict::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
                $query->andWhere([BcCumulativeReportDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])) {
                //$query->andWhere([BcCumulativeReportDistrict::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
                $query->andWhere([BcCumulativeReportDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([BcCumulativeReportDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
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
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.id' => $this->id,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.certified_bc' => $this->certified_bc,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.onboard_bc' => $this->onboard_bc,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.pvr' => $this->pvr,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.shg_assigned' => $this->shg_assigned,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.bc_shg_bank_verified' => $this->bc_shg_bank_verified,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.pfms_mapping' => $this->pfms_mapping,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.bc_support_fund_shg_transfer' => $this->bc_support_fund_shg_transfer,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.bc_support_fund_shg_acknowledge' => $this->bc_support_fund_shg_acknowledge,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.handheld_machine_provided' => $this->handheld_machine_provided,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.handheld_machine_acknowledge' => $this->handheld_machine_acknowledge,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.bc_bank_transaction' => $this->bc_bank_transaction,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.no_of_bc_shortlisted' => $this->no_of_bc_shortlisted,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.no_of_training_conculded' => $this->no_of_training_conculded,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.no_of_training_planned' => $this->no_of_training_planned,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.no_of_bc_appeared_training' => $this->no_of_bc_appeared_training,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.no_of_gp' => $this->no_of_gp,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.no_of_unwilling' => $this->no_of_unwilling,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.bc_bank_transaction_avg_amt' => $this->bc_bank_transaction_avg_amt,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.bc_bank_transaction_count' => $this->bc_bank_transaction_count,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.honorarium_payment_to_bc' => $this->honorarium_payment_to_bc,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.date' => $this->date,
            BcCumulativeReportDistrict::getTableSchema()->fullName . '.last_updated_on' => $this->last_updated_on,
        ]);

        $query->andFilterWhere(['like', BcCumulativeReportDistrict::getTableSchema()->fullName . '.district_name', $this->district_name])
                ->andFilterWhere(['like', BcCumulativeReportDistrict::getTableSchema()->fullName . '.partner_bank_name', $this->partner_bank_name]);

        return $dataProvider;
    }
}
