<?php

namespace bc\modules\transaction\models\summary;

use Yii;

/**
 * This is the model class for table "bc_transaction_bank_summary_monthly".
 *
 * @property int $id
 * @property int|null $total_bc
 * @property int|null $no_of_district
 * @property int|null $no_of_block
 * @property int|null $no_of_gp
 * @property int|null $master_partner_bank_id
 * @property string|null $transaction_start_date
 * @property string|null $month
 * @property int|null $month_id
 * @property string|null $month_start_date
 * @property string|null $month_end_date
 * @property int $total_day
 * @property int $total_working_day
 * @property int $total_not_working_day
 * @property int|null $no_of_transaction
 * @property int $no_of_actual_transaction
 * @property int|null $zero_transaction
 * @property float|null $transaction_amount
 * @property float|null $commission_amount
 * @property int $month_count
 */
class BcTransactionBankSummaryMonthly extends SummaryActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_transaction_bank_summary_monthly';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_partner_bank_id', 'month_id'], 'required'],
            [['total_bc', 'no_of_district', 'no_of_block', 'no_of_gp', 'master_partner_bank_id', 'month_id', 'total_day', 'total_working_day', 'total_not_working_day', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction', 'month_count'], 'integer'],
            [['transaction_start_date', 'month', 'month_start_date', 'month_end_date'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['master_partner_bank_id', 'month_id'], 'unique', 'targetAttribute' => ['master_partner_bank_id', 'month_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'total_bc' => 'Total BC',
            'no_of_district' => 'District',
            'no_of_block' => 'Block',
            'no_of_gp' => 'GP',
            'master_partner_bank_id' => 'Partner Agency',
            'transaction_start_date' => 'Start Date',
            'month' => 'Month',
            'month_id' => 'Month ID',
            'month_start_date' => 'Month Start Date',
            'month_end_date' => 'Month End Date',
            'total_day' => 'Total Day',
            'total_working_day' => 'Total Working Day',
            'total_not_working_day' => 'Total Not Working Day',
            'no_of_transaction' => 'No Of Transaction',
            'no_of_actual_transaction' => 'No Of Actual Transaction',
            'zero_transaction' => 'Zero Transaction',
            'transaction_amount' => 'Txn Amount',
            'commission_amount' => 'Commission Amount',
            'month_count' => 'Month Count',
        ];
    }
    public function getPbank() {
        return $this->hasOne(MasterPartnerBank::className(), ['id' => 'master_partner_bank_id']);
    }
}
