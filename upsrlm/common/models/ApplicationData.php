<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "application_data".
 *
 * @property int $id
 * @property int|null $bc_identify
 * @property int|null $bc_preselect
 * @property int|null $bc_trained
 * @property int|null $bc_trained_and_certified
 * @property int|null $bc_onboarded
 * @property int|null $bc_operational
 * @property int|null $clf_formed
 * @property int|null $clf_e_registered
 * @property float|null $clf_app_operated
 * @property float|null $clf_start_up_received
 * @property float|null $clf_cif_received
 * @property float|null $clf_isf_received
 * @property float|null $clf_infra_fund_received
 * @property float|null $clf_others_fund_received
 * @property float|null $clf_fund_utilization_efficiency
 * @property float|null $clf_stagnant_fund
 * @property int|null $vo_formed
 * @property int|null $vo_e_registered
 * @property int|null $vo_app_operated
 * @property float|null $vo_start_up_received
 * @property float|null $vo_vrf_received
 * @property float|null $vo_lf_received
 * @property float|null $vo_patb_received
 * @property float|null $vo_agey_received
 * @property float|null $vo_isf_received
 * @property int|null $shg_formed
 * @property int|null $shg_e_registered
 * @property int|null $shg_members
 * @property float|null $shg_start_up_received
 * @property float|null $shg_cif_received
 * @property float|null $shg_repeated_bank_loan
 * @property float|null $shg_fund_3_received
 * @property float|null $shg_fund_4_received
 * @property float|null $shg_fund_utilization_efficiency
 * @property float|null $shg_stagnant_fund
 * @property int|null $ga_total_users
 * @property int|null $ga_total_pageviews
 * @property string|null $ga_last_updated_on
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class ApplicationData extends \yii\db\ActiveRecord {

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function() {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'application_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_identify', 'bc_preselect', 'bc_trained', 'bc_trained_and_certified', 'bc_onboarded', 'bc_operational', 'clf_formed', 'clf_e_registered', 'vo_formed', 'vo_e_registered', 'vo_app_operated', 'shg_formed', 'shg_e_registered', 'shg_members', 'ga_total_users', 'ga_total_pageviews', 'created_at', 'updated_at', 'status'], 'integer'],
            [['clf_app_operated', 'clf_start_up_received', 'clf_cif_received', 'clf_isf_received', 'clf_infra_fund_received', 'clf_others_fund_received', 'clf_fund_utilization_efficiency', 'clf_stagnant_fund', 'vo_start_up_received', 'vo_vrf_received', 'vo_lf_received', 'vo_patb_received', 'vo_agey_received', 'vo_isf_received', 'shg_start_up_received', 'shg_cif_received', 'shg_repeated_bank_loan', 'shg_fund_3_received', 'shg_fund_4_received', 'shg_fund_utilization_efficiency', 'shg_stagnant_fund'], 'number'],
            [['ga_last_updated_on'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_identify' => 'Bc Identify',
            'bc_preselect' => 'Bc Preselect',
            'bc_trained' => 'Bc Trained',
            'bc_trained_and_certified' => 'Bc Trained And Certified',
            'bc_onboarded' => 'Bc Onboarded',
            'bc_operational' => 'Bc Operational',
            'clf_formed' => 'Clf Formed',
            'clf_e_registered' => 'Clf E Registered',
            'clf_app_operated' => 'Clf App Operated',
            'clf_start_up_received' => 'Clf Start Up Received',
            'clf_cif_received' => 'Clf Cif Received',
            'clf_isf_received' => 'Clf Isf Received',
            'clf_infra_fund_received' => 'Clf Infra Fund Received',
            'clf_others_fund_received' => 'Clf Others Fund Received',
            'clf_fund_utilization_efficiency' => 'Clf Fund Utilization Efficiency',
            'clf_stagnant_fund' => 'Clf Stagnant Fund',
            'vo_formed' => 'Vo Formed',
            'vo_e_registered' => 'Vo E Registered',
            'vo_app_operated' => 'Vo App Operated',
            'vo_start_up_received' => 'Vo Start Up Received',
            'vo_vrf_received' => 'Vo Vrf Received',
            'vo_lf_received' => 'Vo Lf Received',
            'vo_patb_received' => 'Vo Patb Received',
            'vo_agey_received' => 'Vo Agey Received',
            'vo_isf_received' => 'Vo Isf Received',
            'shg_formed' => 'Shg Formed',
            'shg_e_registered' => 'Shg E Registered',
            'shg_members' => 'Shg Members',
            'shg_start_up_received' => 'Shg Start Up Received',
            'shg_cif_received' => 'Shg Cif Received',
            'shg_repeated_bank_loan' => 'Shg Repeated Bank Loan',
            'shg_fund_3_received' => 'Shg Fund 3 Received',
            'shg_fund_4_received' => 'Shg Fund 4 Received',
            'shg_fund_utilization_efficiency' => 'Shg Fund Utilization Efficiency',
            'shg_stagnant_fund' => 'Shg Stagnant Fund',
            'ga_total_users' => 'Ga Total Users',
            'ga_total_pageviews' => 'Ga Total Pageviews',
            'ga_last_updated_on' => 'Ga Last Updated On',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

}
