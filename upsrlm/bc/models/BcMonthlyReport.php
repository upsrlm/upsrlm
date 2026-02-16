<?php

namespace bc\models;

use Yii;

/**
 * This is the model class for table "bc_monthly_report".
 *
 * @property int $id
 * @property int|null $month_id
 * @property string|null $month_start_date
 * @property string|null $month_end_date
 * @property int $trained_certified
 * @property int $onboard
 * @property int $operational
 * @property int $no_of_bc
 * @property int $no_of_transaction
 * @property float|null $transaction_amount
 * @property float|null $commission_amount
 * @property int $big_ticket_count
 * @property int $small_ticket_count
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class BcMonthlyReport extends BcactiveRecord {

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
        return 'bc_monthly_report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['month_id', 'trained_certified', 'onboard', 'operational', 'no_of_bc', 'no_of_transaction', 'big_ticket_count', 'small_ticket_count', 'created_at', 'updated_at', 'status'], 'integer'],
            [['month_start_date', 'month_end_date'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'month_id' => 'Month ID',
            'month_start_date' => 'Month Start Date',
            'month_end_date' => 'Month End Date',
            'trained_certified' => 'Trained Certificate',
            'onboard' => 'Onboard',
            'operational' => 'Operational',
            'no_of_transaction' => 'No Of Transaction',
            'transaction_amount' => 'Transaction Amount',
            'commission_amount' => 'Commission Amount',
            'big_ticket_count' => 'Big Ticket Count',
            'small_ticket_count' => 'Small Ticket Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

}
