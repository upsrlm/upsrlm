<?php

namespace bc\modules\transaction\models\summary;

use Yii;

/**
 * This is the model class for table "bc_transaction_bank_summary".
 *
 * @property int $id
 * @property int|null $master_partner_bank_id
 * @property string|null $transaction_start_date
 * @property int|null $total_bc
 * @property int $no_of_district
 * @property int $no_of_block
 * @property int $no_of_gp
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
 */
class BcTransactionBankSummary extends SummaryActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_transaction_bank_summary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_partner_bank_id'], 'required'],
            [['master_partner_bank_id'], 'unique'],
            [['master_partner_bank_id', 'total_bc', 'no_of_district','no_of_block', 'no_of_gp', 'total_day', 'total_working_day', 'total_not_working_day', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction', 'start_month_id', 'last_month_id'], 'integer'],
            [['transaction_start_date'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
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
            'master_partner_bank_id' => 'Partner Agency',
            'transaction_start_date' => 'Start Date',
            'total_bc' => 'Total BC',
            'no_of_district' => 'District',
            'no_of_block' => 'Block',
            'no_of_gp' => 'GP',
            'total_day' => 'Total Day',
            'total_working_day' => 'Total Working Day',
            'total_not_working_day' => 'Total Not Working Day',
            'no_of_transaction' => 'No Of Transaction',
            'no_of_actual_transaction' => 'No Of Actual Transaction',
            'zero_transaction' => 'Zero Transaction',
            'transaction_amount' => 'Txn. Amount',
            'commission_amount' => 'Commission Amount',
            'start_month_id' => 'Start Month ID',
            'start_month_name' => 'Start Month',
            'last_month_id' => 'Last Month ID',
            'last_month_name' => 'Last Month',
        ];
    }
    public function getPbank() {
        return $this->hasOne(MasterPartnerBank::className(), ['id' => 'master_partner_bank_id']);
    }
}
