<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "paytm_bc_sakhi".
 *
 * @property int $id
 * @property int|null $sr_no
 * @property string|null $application_no
 * @property string|null $name
 * @property string|null $otp_mobile_no
 * @property string|null $mobile_number
 * @property string|null $onboarding_status
 * @property string|null $bmd_1650
 * @property string|null $sarthi_device_25000
 * @property string|null $both_devices
 * @property string|null $device_not_purchased
 * @property string|null $bc_operational
 * @property string|null $district
 * @property string|null $block
 * @property string|null $gp
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property string|null $bc_shg_payment_status
 * @property string|null $acknowledge_support_funds_received
 * @property string|null $bankidofbc
 * @property int $upsrlm_onboarding_status
 * @property int|null $upsrlm_handheld_machine_status
 * @property int|null $upsrlm_bc_handheld_machine_recived
 * @property int|null $upsrlm_pan_card_status
 * @property int|null $upsrlm_bc_shg_funds_status
 * @property int|null $upsrlm_bc_support_funds_received
 * @property string|null $upsrlm_bankidbc
 * @property int|null $upsrlm_master_partner_bank_id
 * @property int $upsrlm_training_status
 * @property int $upsrlm_bc_operational
 */
class PaytmBcSakhi extends BcactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'paytm_bc_sakhi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sr_no', 'district_code', 'block_code', 'gram_panchayat_code', 'upsrlm_onboarding_status', 'upsrlm_handheld_machine_status', 'upsrlm_bc_handheld_machine_recived', 'upsrlm_pan_card_status', 'upsrlm_bc_shg_funds_status', 'upsrlm_bc_support_funds_received', 'upsrlm_master_partner_bank_id', 'upsrlm_training_status', 'upsrlm_bc_operational'], 'integer'],
            [['application_no', 'bc_operational'], 'string', 'max' => 14],
            [['name'], 'string', 'max' => 95],
            [['otp_mobile_no', 'mobile_number', 'district'], 'string', 'max' => 13],
            [['onboarding_status'], 'string', 'max' => 17],
            [['bmd_1650'], 'string', 'max' => 8],
            [['sarthi_device_25000'], 'string', 'max' => 19],
            [['both_devices'], 'string', 'max' => 12],
            [['device_not_purchased', 'block'], 'string', 'max' => 20],
            [['gp'], 'string', 'max' => 38],
            [['bc_shg_payment_status'], 'string', 'max' => 21],
            [['acknowledge_support_funds_received'], 'string', 'max' => 34],
            [['bankidofbc'], 'string', 'max' => 10],
            [['upsrlm_bankidbc'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sr_no' => 'Sr No',
            'application_no' => 'Application No',
            'name' => 'Name',
            'otp_mobile_no' => 'Otp Mobile No',
            'mobile_number' => 'Mobile Number',
            'onboarding_status' => 'Onboarding Status',
            'bmd_1650' => 'Biometric Device',
            'sarthi_device_25000' => 'Micro ATM Device',
            'both_devices' => 'Both Devices',
            'device_not_purchased' => 'Device Not Purchased',
            'bc_operational' => 'Bc Operational',
            'district' => 'District',
            'block' => 'Block',
            'gp' => 'Gp',
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'bc_shg_payment_status' => 'Bc Shg Payment Status',
            'acknowledge_support_funds_received' => 'Acknowledge Support Funds Received',
            'bankidofbc' => 'Bank ID of BC',
            'upsrlm_onboarding_status' => 'Upsrlm Onboarding Status',
            'upsrlm_handheld_machine_status' => 'Upsrlm Handheld Machine Status',
            'upsrlm_bc_handheld_machine_recived' => 'Upsrlm Bc Handheld Machine Recived',
            'upsrlm_pan_card_status' => 'Upsrlm Pan Card Status',
            'upsrlm_bc_shg_funds_status' => 'Upsrlm Bc Shg Funds Status',
            'upsrlm_bc_support_funds_received' => 'Upsrlm Bc Support Funds Received',
            'upsrlm_bankidbc' => 'Upsrlm Bankidbc',
            'upsrlm_master_partner_bank_id' => 'Upsrlm Master Partner Bank ID',
            'upsrlm_training_status' => 'Upsrlm Training Status',
            'upsrlm_bc_operational' => 'Upsrlm Bc Operational',
        ];
    }
    public function GetBc(){
        return $this->hasOne(SrlmBcApplication::className(), ['application_id'=>'application_no']);
    }
}
