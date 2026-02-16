<?php

namespace bc\modules\transaction\models\summary;

use Yii;

/**
 * This is the model class for table "bc_transaction_bank_summary_weekly".
 *
 * @property int $id
 * @property int|null $total_bc
 * @property int|null $no_of_district
 * @property int|null $no_of_block
 * @property int|null $no_of_gp
 * @property int|null $master_partner_bank_id
 * @property string|null $transaction_start_date
 * @property int|null $week_id
 * @property string|null $week_start_date
 * @property string|null $week_end_date
 * @property int $total_day
 * @property int $total_working_day
 * @property int $total_not_working_day
 * @property int|null $no_of_transaction
 * @property int $no_of_actual_transaction
 * @property int|null $zero_transaction
 * @property float|null $transaction_amount
 * @property float|null $commission_amount
 */
class BcTransactionBankSummaryWeekly extends SummaryActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'bc_transaction_bank_summary_weekly';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['master_partner_bank_id', 'week_id'], 'required'],
            [['total_bc', 'no_of_district', 'no_of_block', 'no_of_gp', 'master_partner_bank_id', 'week_id', 'total_day', 'total_working_day', 'total_not_working_day', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction'], 'integer'],
            [['transaction_start_date', 'week_start_date', 'week_end_date'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['master_partner_bank_id', 'week_id'], 'unique', 'targetAttribute' => ['master_partner_bank_id', 'week_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'total_bc' => 'Total BC',
            'no_of_district' => 'District',
            'no_of_block' => 'Block',
            'no_of_gp' => 'GP',
            'master_partner_bank_id' => 'Partner Agency',
            'transaction_start_date' => 'Start Date',
            'week_id' => 'Week',
            'week_start_date' => 'Week Start Date',
            'week_end_date' => 'Week End Date',
            'total_day' => 'Total Day',
            'total_working_day' => 'Total Working Day',
            'total_not_working_day' => 'Total Not Working Day',
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
    public function getWeek() {
        return $this->hasOne(BcTransactionMasterWeek::className(), ['id' => 'week_id']);
    }
}
