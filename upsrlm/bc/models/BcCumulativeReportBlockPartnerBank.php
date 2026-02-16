<?php

namespace bc\models;

use Yii;

/**
 * This is the model class for table "bc_cumulative_report_block_partner_bank".
 *
 * @property int $id
 * @property int|null $district_code
 * @property string|null $district_name
 * @property int|null $block_code
 * @property string|null $block_name
 * @property int|null $master_partner_bank_id
 * @property string|null $partner_bank_name
 * @property int $blocked_bc
 * @property int $certified_bc
 * @property int $agree
 * @property int $unwilling
 * @property int $registered
 * @property int $not_certified
 * @property int $ineligible
 * @property int $absent
 * @property int $onboard_bc
 * @property int $pvr
 * @property int $shg_assigned
 * @property int $bc_shg_bank_verified
 * @property int $pfms_mapping
 * @property int $bc_support_fund_shg_transfer
 * @property int $bc_support_fund_shg_acknowledge
 * @property int $handheld_machine_provided
 * @property int $handheld_machine_acknowledge
 * @property int $operational
 * @property float $bc_bank_transaction
 * @property int $no_of_bc_shortlisted
 * @property int $urban
 * @property int $no_of_training_conculded
 * @property int $no_of_training_planned
 * @property int $no_of_bc_appeared_training
 * @property int $no_of_bc_registered
 * @property int $no_of_gp
 * @property int $no_of_unwilling
 * @property float $bc_bank_transaction_avg_amt
 * @property int $bc_bank_transaction_count
 * @property float $honorarium_payment_to_bc
 * @property string|null $date
 * @property string $last_updated_on
 */
class BcCumulativeReportBlockPartnerBank extends BcactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'bc_cumulative_report_block_partner_bank';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['district_code', 'block_code', 'master_partner_bank_id', 'blocked_bc', 'certified_bc', 'agree', 'unwilling', 'registered', 'not_certified', 'ineligible', 'absent', 'onboard_bc', 'pvr', 'shg_assigned', 'bc_shg_bank_verified', 'pfms_mapping', 'bc_support_fund_shg_transfer', 'bc_support_fund_shg_acknowledge', 'handheld_machine_provided', 'handheld_machine_acknowledge', 'operational', 'no_of_bc_shortlisted', 'urban', 'no_of_training_conculded', 'no_of_training_planned', 'no_of_bc_appeared_training', 'no_of_bc_registered', 'no_of_gp', 'no_of_unwilling', 'bc_bank_transaction_count'], 'integer'],
            [['bc_bank_transaction', 'bc_bank_transaction_avg_amt', 'honorarium_payment_to_bc'], 'number'],
            [['date', 'last_updated_on'], 'safe'],
            [['last_updated_on'], 'required'],
            [['district_name', 'block_name'], 'string', 'max' => 150],
            [['partner_bank_name'], 'string', 'max' => 255],
            [['block_code', 'master_partner_bank_id', 'date'], 'unique', 'targetAttribute' => ['block_code', 'master_partner_bank_id', 'date']],
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
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'master_partner_bank_id' => 'Master Partner Bank ID',
            'partner_bank_name' => 'Partner Bank Name',
            'blocked_bc' => 'Blocked Bc',
            'certified_bc' => 'Certified Bc',
            'agree' => 'Agree',
            'unwilling' => 'Unwilling',
            'registered' => 'Registered',
            'not_certified' => 'Not Certified',
            'ineligible' => 'Ineligible',
            'absent' => 'Absent',
            'onboard_bc' => 'Onboard Bc',
            'pvr' => 'Pvr',
            'shg_assigned' => 'Shg Assigned',
            'bc_shg_bank_verified' => 'Bc Shg Bank Verified',
            'pfms_mapping' => 'Pfms Mapping',
            'bc_support_fund_shg_transfer' => 'Bc Support Fund Shg Transfer',
            'bc_support_fund_shg_acknowledge' => 'Bc Support Fund Shg Acknowledge',
            'handheld_machine_provided' => 'Handheld Machine Provided',
            'handheld_machine_acknowledge' => 'Handheld Machine Acknowledge',
            'operational' => 'Operational',
            'bc_bank_transaction' => 'Bc Bank Transaction',
            'no_of_bc_shortlisted' => 'No Of Bc Shortlisted',
            'urban' => 'Urban',
            'no_of_training_conculded' => 'No Of Training Conculded',
            'no_of_training_planned' => 'No Of Training Planned',
            'no_of_bc_appeared_training' => 'No Of Bc Appeared Training',
            'no_of_bc_registered' => 'No Of Bc Registered',
            'no_of_gp' => 'No Of Gp',
            'no_of_unwilling' => 'No Of Unwilling',
            'bc_bank_transaction_avg_amt' => 'Bc Bank Transaction Avg Amt',
            'bc_bank_transaction_count' => 'Bc Bank Transaction Count',
            'honorarium_payment_to_bc' => 'Honorarium Payment To Bc',
            'date' => 'Date',
            'last_updated_on' => 'Last Updated On',
        ];
    }

    public function getBlock() {
        return $this->hasOne(master\MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public static function getTotal($provider, $columnName) {
        $total = 0;

        foreach ($provider as $item) {
            $total += $item[$columnName];
        }

        return $total;
    }
}
