<?php

namespace bc\modules\transaction\models\summary;

use Yii;

/**
 * This is the model class for table "bc_tracking_bc_date_range_history".
 *
 * @property int $id
 * @property int|null $bc_application_id
 * @property string|null $bc_name
 * @property string|null $bankidbc
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property int|null $master_partner_bank_id
 * @property string|null $district_name
 * @property string|null $block_name
 * @property string|null $gram_panchayat_name
 * @property string|null $banking_partner_name
 * @property string|null $transaction_start_date
 * @property int $total_day
 * @property int $total_working_day
 * @property int $total_not_working_day
 * @property int|null $total_no_of_transaction
 * @property int $total_no_of_actual_transaction
 * @property int|null $total_zero_transaction
 * @property float|null $total_transaction_amount
 * @property float|null $total_commission_amount
 * @property int|null $start_month_id
 * @property string|null $start_month_name
 * @property int|null $last_month_id
 * @property string|null $last_month_name
 * @property int $days
 * @property int $working_day
 * @property int $not_working_day
 * @property int $no_of_transaction
 * @property int $no_of_actual_transaction
 * @property int $zero_transaction
 * @property float $transaction_amount
 * @property float $commission_amount
 * @property string|null $date_from
 * @property string|null $date_to
 * @property string|null $date_time
 */
class BcTrackingBcDateRangeHistory extends SummaryActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_tracking_bc_date_range_history';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bc_application_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'total_day', 'total_working_day', 'total_not_working_day', 'total_no_of_transaction', 'total_no_of_actual_transaction', 'total_zero_transaction', 'start_month_id', 'last_month_id', 'days', 'working_day', 'not_working_day', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction'], 'integer'],
            [['transaction_start_date', 'date_from', 'date_to', 'date_time'], 'safe'],
            [['total_transaction_amount', 'total_commission_amount', 'transaction_amount', 'commission_amount'], 'number'],
            [['bc_name'], 'string', 'max' => 255],
            [['bankidbc'], 'string', 'max' => 20],
            [['district_name', 'block_name', 'gram_panchayat_name', 'banking_partner_name'], 'string', 'max' => 150],
            [['start_month_name', 'last_month_name'], 'string', 'max' => 14],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Bc Application ID',
            'bc_name' => 'Bc Name',
            'bankidbc' => 'Bankidbc',
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'master_partner_bank_id' => 'Master Partner Bank ID',
            'district_name' => 'District Name',
            'block_name' => 'Block Name',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'banking_partner_name' => 'Banking Partner Name',
            'transaction_start_date' => 'Transaction Start Date',
            'total_day' => 'Total Day',
            'total_working_day' => 'Total Working Day',
            'total_not_working_day' => 'Total Not Working Day',
            'total_no_of_transaction' => 'Total No Of Transaction',
            'total_no_of_actual_transaction' => 'Total No Of Actual Transaction',
            'total_zero_transaction' => 'Total Zero Transaction',
            'total_transaction_amount' => 'Total Transaction Amount',
            'total_commission_amount' => 'Total Commission Amount',
            'start_month_id' => 'Start Month ID',
            'start_month_name' => 'Start Month Name',
            'last_month_id' => 'Last Month ID',
            'last_month_name' => 'Last Month Name',
            'days' => 'Days',
            'working_day' => 'Working Day',
            'not_working_day' => 'Not Working Day',
            'no_of_transaction' => 'No Of Transaction',
            'no_of_actual_transaction' => 'No Of Actual Transaction',
            'zero_transaction' => 'Zero Transaction',
            'transaction_amount' => 'Transaction Amount',
            'commission_amount' => 'Commission Amount',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
            'date_time' => 'Date Time',
        ];
    }
}
