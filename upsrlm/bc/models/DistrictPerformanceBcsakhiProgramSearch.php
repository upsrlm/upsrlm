<?php

namespace bc\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\DistrictPerformanceBcsakhiProgram;
use common\models\master\MasterRole;

/**
 * DistrictPerformanceBcsakhiProgramSearch represents the model behind the search form of `bc\models\DistrictPerformanceBcsakhiProgram`.
 */
class DistrictPerformanceBcsakhiProgramSearch extends DistrictPerformanceBcsakhiProgram {

    public $district_option = [];
    public $bank_option = [];

    public function rules() {
        return [
            [['id', 'district_code', 'no_of_gp', 'no_of_gp_urban', 'no_of_bc_shortlist', 'no_of_certitfied_bc', 'no_of_certitfied_bc_unwilling', 'no_of_unwillimg_bc', 'no_of_bc_registered_for_training', 'no_of_bc_unqualified', 'no_of_bc_ineligible', 'no_of_bc_absent_iibf_exam', 'urban', 'blocked_bc', 'upsrlm_payment_of_bc_support_fund', 'upsrlm_payment_of_bc_honorarium', 'upsrlm_payment_of_bc_honorarium1', 'upsrlm_payment_of_bc_honorarium2', 'upsrlm_payment_of_bc_honorarium3', 'upsrlm_payment_of_bc_honorarium4', 'upsrlm_payment_of_bc_honorarium5', 'upsrlm_payment_of_bc_honorarium6', 'master_partner_bank_id'], 'safe'],
            [['district_name'], 'safe'],
            [['per_certified_bc', 'per_certified_bc_unwilling', 'certified_bc_rating', 'certified_bc_unwilling_rating', 'upsrlm_payment_of_bc_support_fund_per', 'upsrlm_payment_of_bc_honorarium_per', 'upsrlm_payment_of_bc_support_fund_rating', 'upsrlm_payment_of_bc_honorarium_rating', 'partner_agency_avg_no_of_working_days', 'partner_agency_avg_no_of_txn', 'partner_agency_avg_no_of_txn_amount', 'partner_agency_avg_com_earning', 'partner_agency_avg_no_of_working_days_rating', 'partner_agency_avg_no_of_txn_rating', 'partner_agency_avg_no_of_txn_amount_rating', 'partner_agency_avg_com_earning_rating'], 'number'],
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
        $query = DistrictPerformanceBcsakhiProgram::find();

        $query->joinWith(['district']);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {

                $query->andWhere([DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])) {

                $query->andWhere([DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } else {
                $query->where('0=1');
            }
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
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.id' => $this->id,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.district_code' => $this->district_code,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.no_of_gp' => $this->no_of_gp,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.no_of_gp_urban' => $this->no_of_gp_urban,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.no_of_bc_shortlist' => $this->no_of_bc_shortlist,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.no_of_certitfied_bc' => $this->no_of_certitfied_bc,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.no_of_certitfied_bc_unwilling' => $this->no_of_certitfied_bc_unwilling,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.no_of_unwillimg_bc' => $this->no_of_unwillimg_bc,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.no_of_bc_registered_for_training' => $this->no_of_bc_registered_for_training,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.no_of_bc_unqualified' => $this->no_of_bc_unqualified,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.no_of_bc_ineligible' => $this->no_of_bc_ineligible,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.no_of_bc_absent_iibf_exam' => $this->no_of_bc_absent_iibf_exam,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.urban' => $this->urban,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.blocked_bc' => $this->blocked_bc,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.per_certified_bc' => $this->per_certified_bc,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.per_certified_bc_unwilling' => $this->per_certified_bc_unwilling,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.certified_bc_rating' => $this->certified_bc_rating,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.certified_bc_unwilling_rating' => $this->certified_bc_unwilling_rating,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.upsrlm_payment_of_bc_support_fund' => $this->upsrlm_payment_of_bc_support_fund,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.upsrlm_payment_of_bc_support_fund_per' => $this->upsrlm_payment_of_bc_support_fund_per,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.upsrlm_payment_of_bc_honorarium' => $this->upsrlm_payment_of_bc_honorarium,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.upsrlm_payment_of_bc_honorarium_per' => $this->upsrlm_payment_of_bc_honorarium_per,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.upsrlm_payment_of_bc_honorarium1' => $this->upsrlm_payment_of_bc_honorarium1,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.upsrlm_payment_of_bc_honorarium2' => $this->upsrlm_payment_of_bc_honorarium2,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.upsrlm_payment_of_bc_honorarium3' => $this->upsrlm_payment_of_bc_honorarium3,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.upsrlm_payment_of_bc_honorarium4' => $this->upsrlm_payment_of_bc_honorarium4,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.upsrlm_payment_of_bc_honorarium5' => $this->upsrlm_payment_of_bc_honorarium5,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.upsrlm_payment_of_bc_honorarium6' => $this->upsrlm_payment_of_bc_honorarium6,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.upsrlm_payment_of_bc_support_fund_rating' => $this->upsrlm_payment_of_bc_support_fund_rating,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.upsrlm_payment_of_bc_honorarium_rating' => $this->upsrlm_payment_of_bc_honorarium_rating,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.partner_agency_avg_no_of_working_days' => $this->partner_agency_avg_no_of_working_days,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.partner_agency_avg_no_of_txn' => $this->partner_agency_avg_no_of_txn,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.partner_agency_avg_no_of_txn_amount' => $this->partner_agency_avg_no_of_txn_amount,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.partner_agency_avg_com_earning' => $this->partner_agency_avg_com_earning,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.partner_agency_avg_no_of_working_days_rating' => $this->partner_agency_avg_no_of_working_days_rating,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.partner_agency_avg_no_of_txn_rating' => $this->partner_agency_avg_no_of_txn_rating,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.partner_agency_avg_no_of_txn_amount_rating' => $this->partner_agency_avg_no_of_txn_amount_rating,
            DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.partner_agency_avg_com_earning_rating' => $this->partner_agency_avg_com_earning_rating,
        ]);

        $query->andFilterWhere(['like', DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.district_name', $this->district_name]);

        return $dataProvider;
    }
}
