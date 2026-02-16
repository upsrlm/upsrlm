<?php

namespace bc\models;

use Yii;
use common\models\master\MasterRole;

/**
 * This is the model class for table "district_performance_bcsakhi_program".
 *
 * @property int $id
 * @property int $district_code
 * @property string $district_name
 * @property int $no_of_gp
 * @property int $no_of_gp_urban
 * @property int $no_of_bc_shortlist
 * @property int $no_of_certitfied_bc
 * @property int $no_of_certitfied_bc_unwilling
 * @property int $no_of_unwillimg_bc
 * @property int $no_of_bc_registered_for_training
 * @property int $no_of_bc_unqualified
 * @property int $no_of_bc_ineligible
 * @property int $no_of_bc_absent_iibf_exam
 * @property float $per_certified_bc
 * @property float $per_certified_bc_unwilling
 * @property float $certified_bc_rating
 * @property float $certified_bc_unwilling_rating
 * @property int $upsrlm_payment_of_bc_support_fund
 * @property float $upsrlm_payment_of_bc_support_fund_per
 * @property int $upsrlm_payment_of_bc_honorarium
 * @property float $upsrlm_payment_of_bc_honorarium_per
 * @property int $upsrlm_payment_of_bc_honorarium1
 * @property int $upsrlm_payment_of_bc_honorarium2
 * @property int $upsrlm_payment_of_bc_honorarium3
 * @property int $upsrlm_payment_of_bc_honorarium4
 * @property int $upsrlm_payment_of_bc_honorarium5
 * @property int $upsrlm_payment_of_bc_honorarium6
 * @property float $upsrlm_payment_of_bc_support_fund_rating
 * @property float $upsrlm_payment_of_bc_honorarium_rating
 * @property float $partner_agency_avg_no_of_working_days
 * @property float $partner_agency_avg_no_of_txn
 * @property float $partner_agency_avg_no_of_txn_amount
 * @property float $partner_agency_avg_com_earning
 * @property float $partner_agency_avg_no_of_working_days_rating
 * @property float $partner_agency_avg_no_of_txn_rating
 * @property float $partner_agency_avg_no_of_txn_amount_rating
 * @property float $partner_agency_avg_com_earning_rating
 */
class DistrictPerformanceBcsakhiProgram extends BcactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'district_performance_bcsakhi_program';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['district_code', 'district_name'], 'required'],
            [['district_code', 'no_of_gp', 'no_of_gp_urban', 'no_of_bc_shortlist', 'no_of_certitfied_bc', 'no_of_certitfied_bc_unwilling', 'no_of_unwillimg_bc', 'no_of_bc_registered_for_training', 'no_of_bc_unqualified', 'no_of_bc_ineligible', 'no_of_bc_absent_iibf_exam', 'upsrlm_payment_of_bc_support_fund', 'upsrlm_payment_of_bc_honorarium', 'upsrlm_payment_of_bc_honorarium1', 'upsrlm_payment_of_bc_honorarium2', 'upsrlm_payment_of_bc_honorarium3', 'upsrlm_payment_of_bc_honorarium4', 'upsrlm_payment_of_bc_honorarium5', 'upsrlm_payment_of_bc_honorarium6'], 'integer'],
            [['per_certified_bc', 'per_certified_bc_unwilling', 'certified_bc_rating', 'certified_bc_unwilling_rating', 'upsrlm_payment_of_bc_support_fund_per', 'upsrlm_payment_of_bc_honorarium_per', 'upsrlm_payment_of_bc_support_fund_rating', 'upsrlm_payment_of_bc_honorarium_rating', 'partner_agency_avg_no_of_working_days', 'partner_agency_avg_no_of_txn', 'partner_agency_avg_no_of_txn_amount', 'partner_agency_avg_com_earning', 'partner_agency_avg_no_of_working_days_rating', 'partner_agency_avg_no_of_txn_rating', 'partner_agency_avg_no_of_txn_amount_rating', 'partner_agency_avg_com_earning_rating'], 'number'],
            [['district_name'], 'string', 'max' => 150],
//            [['district_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'no_of_gp' => 'No Of Gp',
            'no_of_gp_urban' => 'No Of Gp Urban',
            'no_of_bc_shortlist' => 'No Of Bc Shortlist',
            'no_of_certitfied_bc' => 'No Of Certitfied Bc',
            'no_of_certitfied_bc_unwilling' => 'No Of Certitfied Bc Unwilling',
            'no_of_unwillimg_bc' => 'No Of Unwillimg Bc',
            'no_of_bc_registered_for_training' => 'No Of Bc Registered For Training',
            'no_of_bc_unqualified' => 'No Of Bc Unqualified',
            'no_of_bc_ineligible' => 'No Of Bc Ineligible',
            'no_of_bc_absent_iibf_exam' => 'No Of Bc Absent Iibf Exam',
            'per_certified_bc' => 'Per Certified Bc',
            'per_certified_bc_unwilling' => 'Per Certified Bc Unwilling',
            'certified_bc_rating' => 'Certified Bc Rating',
            'certified_bc_unwilling_rating' => 'Certified Bc Unwilling Rating',
            'upsrlm_payment_of_bc_support_fund' => 'Upsrlm Payment Of Bc Support Fund',
            'upsrlm_payment_of_bc_support_fund_per' => 'Upsrlm Payment Of Bc Support Fund Per',
            'upsrlm_payment_of_bc_honorarium' => 'Upsrlm Payment Of Bc Honorarium',
            'upsrlm_payment_of_bc_honorarium_per' => 'Upsrlm Payment Of Bc Honorarium Per',
            'upsrlm_payment_of_bc_honorarium1' => 'Upsrlm Payment Of Bc Honorarium1',
            'upsrlm_payment_of_bc_honorarium2' => 'Upsrlm Payment Of Bc Honorarium2',
            'upsrlm_payment_of_bc_honorarium3' => 'Upsrlm Payment Of Bc Honorarium3',
            'upsrlm_payment_of_bc_honorarium4' => 'Upsrlm Payment Of Bc Honorarium4',
            'upsrlm_payment_of_bc_honorarium5' => 'Upsrlm Payment Of Bc Honorarium5',
            'upsrlm_payment_of_bc_honorarium6' => 'Upsrlm Payment Of Bc Honorarium6',
            'upsrlm_payment_of_bc_support_fund_rating' => 'Upsrlm Payment Of Bc Support Fund Rating',
            'upsrlm_payment_of_bc_honorarium_rating' => 'Upsrlm Payment Of Bc Honorarium Rating',
            'partner_agency_avg_no_of_working_days' => 'Partner Agency Avg No Of Working Days',
            'partner_agency_avg_no_of_txn' => 'Partner Agency Avg No Of Txn',
            'partner_agency_avg_no_of_txn_amount' => 'Partner Agency Avg No Of Txn Amount',
            'partner_agency_avg_com_earning' => 'Partner Agency Avg Com Earning',
            'partner_agency_avg_no_of_working_days_rating' => 'Partner Agency Avg No Of Working Days Rating',
            'partner_agency_avg_no_of_txn_rating' => 'Partner Agency Avg No Of Txn Rating',
            'partner_agency_avg_no_of_txn_amount_rating' => 'Partner Agency Avg No Of Txn Amount Rating',
            'partner_agency_avg_com_earning_rating' => 'Partner Agency Avg Com Earning Rating',
        ];
    }

    public function getDistrict() {
        return $this->hasOne(master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public static function getTotal($provider, $columnName, $search = null) {
        $total = 0;
        $query = DistrictPerformanceBcsakhiProgram::find();
        if (isset($search->district_code) and $search->district_code != '') {
            $query->andWhere([DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.district_code' => $search->district_code]);
        }
        if (!$search->master_partner_bank_id) {
            $query->andWhere([DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.master_partner_bank_id' => 0]);
        }
        if ($search->master_partner_bank_id) {
            $query->andWhere([DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.master_partner_bank_id' => $search->master_partner_bank_id]);
        }
        if ($search->certified_bc_rating != '') {
            $query->andWhere([DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.certified_bc_rating' => $search->certified_bc_rating]);
        }
        if ($search->certified_bc_unwilling_rating != '') {
            $query->andWhere([DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.certified_bc_unwilling_rating' => $search->certified_bc_unwilling_rating]);
        }
        if ($search->upsrlm_payment_of_bc_support_fund_rating != '') {
            $query->andWhere([DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.upsrlm_payment_of_bc_support_fund_rating' => $search->upsrlm_payment_of_bc_support_fund_rating]);
        }
        if ($search->upsrlm_payment_of_bc_honorarium_rating != '') {
            $query->andWhere([DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.upsrlm_payment_of_bc_honorarium_rating' => $search->upsrlm_payment_of_bc_honorarium_rating]);
        }
        if ($search->partner_agency_avg_no_of_working_days_rating != '') {
            $query->andWhere([DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.partner_agency_avg_no_of_working_days_rating' => $search->partner_agency_avg_no_of_working_days_rating]);
        }
        if ($search->partner_agency_avg_no_of_txn_rating != '') {
            $query->andWhere([DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.partner_agency_avg_no_of_txn_rating' => $search->partner_agency_avg_no_of_txn_rating]);
        }
        if ($search->partner_agency_avg_com_earning_rating != '') {
            $query->andWhere([DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.partner_agency_avg_com_earning_rating' => $search->partner_agency_avg_com_earning_rating]);
        }
        $user_model = \Yii::$app->user->identity;
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF, MasterRole::ROLE_SPM_FINANCE, MasterRole::ROLE_VIEWER, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_SUPPORT_UNIT])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $query->andWhere([DistrictPerformanceBcsakhiProgram::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } else {
                $query->where('0=1');
            }
        }


        if ($columnName == 'per_certified_bc') {
            $total = $query->average('per_certified_bc');
        }
        if ($columnName == 'certified_bc_rating') {
            $total = $query->average('certified_bc_rating');
        }
        if ($columnName == 'per_certified_bc_unwilling') {
            $total = $query->average('per_certified_bc_unwilling');
        }
        if ($columnName == 'certified_bc_unwilling_rating') {
            $total = $query->average('certified_bc_unwilling_rating');
        }
        if ($columnName == 'upsrlm_payment_of_bc_support_fund_per') {
            $total = $query->average('upsrlm_payment_of_bc_support_fund_per');
        }
        if ($columnName == 'upsrlm_payment_of_bc_support_fund_rating') {
            $total = $query->average('upsrlm_payment_of_bc_support_fund_rating');
        }
        if ($columnName == 'upsrlm_payment_of_bc_honorarium_per') {
            $total = $query->average('upsrlm_payment_of_bc_honorarium_per');
        }
        if ($columnName == 'upsrlm_payment_of_bc_honorarium_rating') {
            $total = $query->average('upsrlm_payment_of_bc_honorarium_rating');
        }

        if ($columnName == 'partner_agency_avg_no_of_working_days') {
            $total = $query->average('partner_agency_avg_no_of_working_days');
        }
        if ($columnName == 'partner_agency_avg_no_of_working_days_rating') {
            $total = $query->average('partner_agency_avg_no_of_working_days_rating');
        }
        if ($columnName == 'partner_agency_avg_no_of_txn') {
            $total = $query->average('partner_agency_avg_no_of_txn');
        }
        if ($columnName == 'partner_agency_avg_no_of_txn_rating') {
            $total = $query->average('partner_agency_avg_no_of_txn_rating');
        }
        if ($columnName == 'partner_agency_avg_com_earning') {
            $total = $query->average('partner_agency_avg_com_earning');
        }
        if ($columnName == 'partner_agency_avg_com_earning_rating') {
            $total = $query->average('partner_agency_avg_com_earning_rating');
        }
        if ($total != 0) {
            $total = round($total, 1);
        }
        return $total;
    }
}
