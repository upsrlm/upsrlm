<?php

namespace bc\models\transaction;

use Yii;

/**
 * This is the model class for table "bc_transaction_weekly_report".
 *
 * @property int $id
 * @property int|null $bc_application_id
 * @property int|null $user_id
 * @property string|null $bankidbc
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property int|null $master_partner_bank_id
 * @property string|null $start_date
 * @property int|null $week_id
 * @property string|null $week_start_date
 * @property string|null $week_end_date
 * @property int $no_of_days
 * @property int $no_of_working_days
 * @property int $no_of_not_working_days
 * @property int $big_ticket_count
 * @property int $small_ticket_count
 * @property int|null $no_of_transaction
 * @property float|null $transaction_amount
 * @property float|null $commission_amount
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class BcTransactionWeeklyReport extends \bc\models\transaction\BctransactionactiveRecord {

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
        return 'bc_transaction_weekly_report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id', 'user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'week_id', 'no_of_days', 'no_of_working_days', 'no_of_not_working_days', 'big_ticket_count', 'small_ticket_count', 'no_of_transaction', 'created_at', 'updated_at', 'status'], 'integer'],
            [['start_date', 'week_start_date', 'week_end_date'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['bankidbc'], 'string', 'max' => 20],
            [['bc_application_id', 'week_id'], 'unique', 'targetAttribute' => ['bc_application_id', 'week_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Name',
            'user_id' => 'User ID',
            'bankidbc' => 'Bankidbc',
            'district_code' => 'District',
            'block_code' => 'Block',
            'gram_panchayat_code' => 'Gram Panchayat',
            'master_partner_bank_id' => 'Partner Agency',
            'start_date' => 'Start Date',
            'week_id' => 'Week',
            'week_start_date' => 'Week Start Date',
            'week_end_date' => 'Week End Date',
            'no_of_days' => 'No Of Days',
            'no_of_working_days' => 'Working Days',
            'no_of_not_working_days' => 'Not Working Days',
            'big_ticket_count' => 'Big Ticket',
            'small_ticket_count' => 'Small Ticket',
            'no_of_transaction' => 'No Of Transaction',
            'transaction_amount' => 'Txn Amount',
            'commission_amount' => 'Commission Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getBc() {
        return $this->hasOne(\bc\modules\selection\models\SrlmBcApplication::className(), ['id' => 'bc_application_id']);
    }

    public function getPbank() {
        return $this->hasOne(\bc\models\master\MasterPartnerBank::className(), ['id' => 'master_partner_bank_id']);
    }

    public function getDistrict() {
        return $this->hasOne(\bc\models\master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getBlock() {
        return $this->hasOne(\bc\models\master\MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getGp() {
        return $this->hasOne(\bc\models\master\MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }

    public function getWeek() {
        return $this->hasOne(BcTransactionMasterWeek::className(), ['id' => 'week_id']);
    }

}
