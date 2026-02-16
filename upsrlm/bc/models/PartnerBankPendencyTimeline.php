<?php

namespace bc\models;

use Yii;

/**
 * This is the model class for table "partner_bank_pendency_timeline".
 *
 * @property int $id
 * @property int|null $master_partner_bank_id
 * @property string|null $partner_bank_name
 * @property string|null $partner_short_bank_name
 * @property int $certified_bc
 * @property int $bc_support_fund_shg_transfer
 * @property int $bc_support_fund_shg_acknowledge
 * @property int $handheld_machine_provided
 * @property int $handheld_machine_acknowledge
 * @property int $onboard_bc
 * @property int $operational
 * @property int $pfms_mapping
 * @property int $pvr
 * @property int $shg_assigned
 * @property string|null $date
 * @property string $last_updated_on
 */
class PartnerBankPendencyTimeline extends \bc\models\BcactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partner_bank_pendency_timeline';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_partner_bank_id', 'certified_bc', 'bc_support_fund_shg_transfer', 'bc_support_fund_shg_acknowledge', 'handheld_machine_provided', 'handheld_machine_acknowledge', 'onboard_bc', 'operational', 'pfms_mapping', 'pvr', 'shg_assigned'], 'integer'],
            [['date', 'last_updated_on'], 'safe'],
            [['last_updated_on'], 'required'],
            [['partner_bank_name'], 'string', 'max' => 255],
            [['partner_short_bank_name'], 'string', 'max' => 100],
            [['date', 'master_partner_bank_id'], 'unique', 'targetAttribute' => ['date', 'master_partner_bank_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'master_partner_bank_id' => 'Partner Bank',
            'partner_bank_name' => 'Partner Bank Name',
            'partner_short_bank_name' => 'Partner Short Bank Name',
            'certified_bc' => 'Certified Bc',
            'bc_support_fund_shg_transfer' => 'Bc Support Fund Shg Transfer',
            'bc_support_fund_shg_acknowledge' => 'Bc Support Fund Shg Acknowledge',
            'handheld_machine_provided' => 'Handheld Machine Provided',
            'handheld_machine_acknowledge' => 'Handheld Machine Acknowledge',
            'onboard_bc' => 'Onboard Bc',
            'operational' => 'Operational',
            'pfms_mapping' => 'Pfms Mapping',
            'pvr' => 'Pvr',
            'shg_assigned' => 'Shg Assigned',
            'date' => 'Date',
            'last_updated_on' => 'Last Updated On',
        ];
    }
}
