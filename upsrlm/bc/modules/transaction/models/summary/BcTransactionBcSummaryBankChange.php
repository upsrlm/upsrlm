<?php

namespace bc\modules\transaction\models\summary;

use Yii;

/**
 * This is the model class for table "bc_transaction_bc_summary_bank_change".
 *
 * @property int $id
 * @property int|null $bc_application_id
 * @property string|null $bankidbc
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property int|null $master_partner_bank_id
 * @property string|null $transaction_start_date
 * @property int $total_day
 * @property int $total_working_day
 * @property int $total_not_working_day
 * @property int|null $no_of_transaction
 * @property int $no_of_actual_transaction
 * @property int|null $zero_transaction
 * @property float|null $transaction_amount
 * @property float|null $commission_amount
 * @property int|null $start_month_id
 * @property string|null $start_month_name
 * @property int|null $last_month_id
 * @property string|null $last_month_name
 * @property int $change_bank
 * @property int $status
 * @property int|null $created_at
 */
class BcTransactionBcSummaryBankChange extends SummaryActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'bc_transaction_bc_summary_bank_change';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'total_day', 'total_working_day', 'total_not_working_day', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction', 'start_month_id', 'last_month_id', 'change_bank', 'status', 'created_at'], 'integer'],
            [['transaction_start_date'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['bankidbc'], 'string', 'max' => 20],
            [['start_month_name', 'last_month_name'], 'string', 'max' => 14],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Bc Application ID',
            'bankidbc' => 'Bankidbc',
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'master_partner_bank_id' => 'Master Partner Bank ID',
            'transaction_start_date' => 'Transaction Start Date',
            'total_day' => 'Total Day',
            'total_working_day' => 'Total Working Day',
            'total_not_working_day' => 'Total Not Working Day',
            'no_of_transaction' => 'No Of Transaction',
            'no_of_actual_transaction' => 'No Of Actual Transaction',
            'zero_transaction' => 'Zero Transaction',
            'transaction_amount' => 'Transaction Amount',
            'commission_amount' => 'Commission Amount',
            'start_month_id' => 'Start Month ID',
            'start_month_name' => 'Start Month Name',
            'last_month_id' => 'Last Month ID',
            'last_month_name' => 'Last Month Name',
            'change_bank' => 'Change Bank',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
