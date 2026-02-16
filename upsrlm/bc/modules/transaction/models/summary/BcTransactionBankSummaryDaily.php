<?php

namespace bc\modules\transaction\models\summary;

use Yii;

/**
 * This is the model class for table "bc_transaction_bank_summary_daily".
 *
 * @property int $id
 * @property int|null $total_bc
 * @property int|null $no_of_district
 * @property int|null $no_of_block
 * @property int|null $no_of_gp
 * @property int|null $master_partner_bank_id
 * @property string|null $date
 * @property string|null $transaction_start_date
 * @property int|null $no_of_transaction
 * @property int $no_of_actual_transaction
 * @property int|null $zero_transaction
 * @property float|null $transaction_amount
 * @property float|null $commission_amount
 */
class BcTransactionBankSummaryDaily extends SummaryActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_transaction_bank_summary_daily';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_partner_bank_id', 'date'], 'required'],
            [['total_bc', 'no_of_district', 'no_of_block', 'no_of_gp', 'master_partner_bank_id', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction'], 'integer'],
            [['date', 'transaction_start_date'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['master_partner_bank_id', 'date'], 'unique', 'targetAttribute' => ['master_partner_bank_id', 'date']],
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
            'date' => 'Date',
            'transaction_start_date' => 'Transaction Start Date',
            'no_of_transaction' => 'No Of Transaction',
            'no_of_actual_transaction' => 'No Of Actual Transaction',
            'zero_transaction' => 'Zero Transaction',
            'transaction_amount' => 'Txn. Amount',
            'commission_amount' => 'Commission Amount',
        ];
    }
    public function getPbank() {
        return $this->hasOne(MasterPartnerBank::className(), ['id' => 'master_partner_bank_id']);
    }
}
