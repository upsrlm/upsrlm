<?php

namespace bc\models\transaction;

use Yii;

/**
 * This is the model class for table "bc_transaction_overall_partner_bank".
 *
 * @property int $id
 * @property int|null $master_partner_bank_id
 * @property string|null $bank_name
 * @property string|null $bank_short_name
 * @property int $bc_operational
 * @property int $no_of_district
 * @property int $no_of_gp
 * @property string|null $start_date
 * @property int $no_of_days
 * @property int $big_ticket_count
 * @property int $big_ticket_count_map
 * @property int $big_ticket_count_not_map
 * @property int $small_ticket_count
 * @property int $small_ticket_count_map
 * @property int $small_ticket_count_not_map
 * @property int|null $no_of_transaction
 * @property int $no_of_transaction_map
 * @property int $no_of_transaction_not_map
 * @property int|null $zero_transaction
 * @property int $zero_transaction_map
 * @property int $zero_transaction_not_map
 * @property float|null $transaction_amount
 * @property float $transaction_amount_map
 * @property float $transaction_amount_not_map
 * @property float|null $commission_amount
 * @property float $commission_amount_map
 * @property float $commission_amount_not_map
 * @property float $avg_bc_commission_amount
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class BcTransactionOverallPartnerBank extends \bc\models\transaction\BctransactionactiveRecord {

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'bc_transaction_overall_partner_bank';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['master_partner_bank_id', 'bc_operational', 'no_of_district', 'no_of_gp', 'no_of_days', 'big_ticket_count', 'big_ticket_count_map', 'big_ticket_count_not_map', 'small_ticket_count', 'small_ticket_count_map', 'small_ticket_count_not_map', 'no_of_transaction', 'no_of_transaction_map', 'no_of_transaction_not_map', 'zero_transaction', 'zero_transaction_map', 'zero_transaction_not_map', 'created_at', 'updated_at', 'status'], 'integer'],
            [['start_date'], 'safe'],
            [['transaction_amount', 'transaction_amount_map', 'transaction_amount_not_map', 'commission_amount', 'commission_amount_map', 'commission_amount_not_map', 'avg_bc_commission_amount'], 'number'],
            [['bank_name'], 'string', 'max' => 50],
            [['bank_short_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'master_partner_bank_id' => 'Master Partner Bank ID',
            'bank_name' => 'Bank Name',
            'bank_short_name' => 'Bank Short Name',
            'bc_operational' => 'Bc Operational',
            'no_of_district' => 'No Of District',
            'no_of_gp' => 'No Of Gp',
            'start_date' => 'Start Date',
            'no_of_days' => 'No Of Days',
            'big_ticket_count' => 'Big Ticket Count',
            'big_ticket_count_map' => 'Big Ticket Count Map',
            'big_ticket_count_not_map' => 'Big Ticket Count Not Map',
            'small_ticket_count' => 'Small Ticket Count',
            'small_ticket_count_map' => 'Small Ticket Count Map',
            'small_ticket_count_not_map' => 'Small Ticket Count Not Map',
            'no_of_transaction' => 'No Of Transaction',
            'no_of_transaction_map' => 'No Of Transaction Map',
            'no_of_transaction_not_map' => 'No Of Transaction Not Map',
            'zero_transaction' => 'Zero Transaction',
            'zero_transaction_map' => 'Zero Transaction Map',
            'zero_transaction_not_map' => 'Zero Transaction Not Map',
            'transaction_amount' => 'Transaction Amount',
            'transaction_amount_map' => 'Transaction Amount Map',
            'transaction_amount_not_map' => 'Transaction Amount Not Map',
            'commission_amount' => 'Commission Amount',
            'commission_amount_map' => 'Commission Amount Map',
            'commission_amount_not_map' => 'Commission Amount Not Map',
            'avg_bc_commission_amount' => 'Avg Bc Commission Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public static function getTotal($provider, $columnName) {
        $total = 0;

        foreach ($provider as $item) {
            $total += floor($item[$columnName]);
        }

        return $total;
    }

    public static function getNomonth($provider, $columnName) {
        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $last_day_month = $date->format('Y-m-d');
        return BcTransactionMasterMonth::find()->where(['>', 'id', 5])->andFilterWhere(['<=', 'month_end_date', $last_day_month])->count();
    }

    public function getMonth() {
        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $last_day_month = $date->format('Y-m-d');
        return BcTransactionMasterMonth::find()->where(['>', 'id', 5])->andFilterWhere(['<=', 'month_end_date', $last_day_month])->count();
    }

}
