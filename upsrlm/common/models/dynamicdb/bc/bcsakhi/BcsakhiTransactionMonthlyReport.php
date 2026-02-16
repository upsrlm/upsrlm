<?php

namespace common\models\dynamicdb\bc\bcsakhi;

use Yii;

/**
 * This is the model class for table "bcsakhi_transaction_monthly_report".
 *
 * @property int $id
 * @property int|null $month_id
 * @property string|null $month_start_date
 * @property string|null $month_end_date
 * @property int $operational
 * @property int $no_of_bc
 * @property int $no_of_transaction
 * @property int|null $zero_transaction
 * @property float|null $transaction_amount
 * @property float|null $commission_amount
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class BcsakhiTransactionMonthlyReport extends \common\models\dynamicdb\bc\BcactiveRecord {
    
    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function() {
                    return time();
                },
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bcsakhi_transaction_monthly_report';
    }

   

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month_id', 'operational', 'no_of_bc', 'no_of_transaction', 'zero_transaction', 'created_at', 'updated_at', 'status'], 'integer'],
            [['month_start_date', 'month_end_date'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['month_id'], 'unique'],
            [['month_start_date'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'month_id' => 'Month ID',
            'month_start_date' => 'Month Start Date',
            'month_end_date' => 'Month End Date',
            'operational' => 'Operational',
            'no_of_bc' => 'No Of Bc',
            'no_of_transaction' => 'No Of Transaction',
            'zero_transaction' => 'Zero Transaction',
            'transaction_amount' => 'Transaction Amount',
            'commission_amount' => 'Commission Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
