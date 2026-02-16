<?php

namespace bc\modules\transaction\models\dump;

use Yii;

/**
 * This is the model class for table "bc_transaction_bank_5".
 *
 * @property int $id
 * @property int|null $bc_application_id
 * @property string|null $bankidbc
 * @property int|null $master_partner_bank_id
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property int|null $file_id
 * @property int|null $dtable_id
 * @property string|null $banktransactionid
 * @property string|null $transaction_datetime
 * @property string|null $transaction_date
 * @property string|null $transaction_time
 * @property float|null $transaction_amount
 * @property string|null $transaction_type
 * @property int $ticket
 * @property float|null $commission_amount
 */
class BcTransactionBank5 extends DumpActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_transaction_bank_5';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bc_application_id', 'master_partner_bank_id', 'district_code', 'block_code', 'gram_panchayat_code', 'file_id', 'dtable_id', 'ticket'], 'integer'],
            [['transaction_datetime', 'transaction_date', 'transaction_time'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['bankidbc'], 'string', 'max' => 20],
            [['banktransactionid'], 'string', 'max' => 40],
            [['transaction_type'], 'string', 'max' => 255],
            [['master_partner_bank_id'], 'required'],
            [['transaction_type'], 'required'],
            [['banktransactionid', 'transaction_datetime'], 'required'],
            [['banktransactionid'], 'unique'],
            ['transaction_datetime', 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            ['transaction_datetime', \common\validators\TransactionDateValidator::className()],
            [['transaction_amount'], 'required'],
            ['commission_amount', 'default', 'value' => 0],
            ['ticket', 'default', 'value' => 0],
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
            'bankidbc' => 'Bankidbc',
            'master_partner_bank_id' => 'Master Partner Bank ID',
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'file_id' => 'File ID',
            'dtable_id' => 'Dtable ID',
            'banktransactionid' => 'Banktransactionid',
            'transaction_datetime' => 'Transaction Datetime',
            'transaction_date' => 'Transaction Date',
            'transaction_time' => 'Transaction Time',
            'transaction_amount' => 'Transaction Amount',
            'transaction_type' => 'Transaction Type',
            'ticket' => 'Ticket',
            'commission_amount' => 'Commission Amount',
        ];
    }
    public function beforeSave($insert) {
         if (class_exists('\bc\modules\transaction\components\transaction')) {
            if ($this->transaction_amount) {
                if ($this->transaction_amount < \bc\modules\transaction\components\transaction::BIG_SMALL_TICKET) {
                    $this->ticket = \bc\modules\transaction\components\transaction::SMALL_TICKET;
                }
                if ($this->transaction_amount >= \bc\modules\transaction\components\transaction::BIG_SMALL_TICKET) {
                    $this->ticket = \bc\modules\transaction\components\transaction::BIG_TICKET;
                }
            }
        }
        if ($this->transaction_datetime) {
            if (\bc\modules\transaction\helpers\Utility::validateDate($this->transaction_datetime)) {
                list($date, $time) = explode(' ', $this->transaction_datetime);
                $this->transaction_date = $date;
                $this->transaction_time = $time;
            }
        }
        return parent::beforeSave($insert);
    }

    

//    public function afterSave($insert, $changedAttributes) {
//        try {
//            list($date, $time) = explode(' ', $this->transaction_datetime);
//            $condition = ['and',
//                ['=', 'id', $this->id],
//            ];
//            BcTransactionBank5::updateAll([
//                'transaction_date' => $date,
//                'transaction_time' => $time
//                    ], $condition);
//        } catch (\Exception $ex) {
//            
//        }
//        return true;
//    }
}
