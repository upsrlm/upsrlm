<?php

namespace bc\modules\transaction\models\dump;

use Yii;

/**
 * This is the model class for table "bc_transaction_bank_1".
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
class BcTransactionBank extends DumpActiveRecord {

    public static $defaul_table = 'bc_transaction_bank';
    protected static $table = 'bc_transaction_bank';
    public $no_of_transaction;

    public function __construct($table = NULL) {
        if ($table === null || $table === '') {
            return self::$table;
        }
        self::$table = $table;
    }

    public static function tableName() {
        return self::$table;
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
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
            ['no_of_transaction', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Bc Name',
            'bankidbc' => 'Bankidbc',
            'master_partner_bank_id' => 'Partner agencies',
            'district_code' => 'District',
            'block_code' => 'Block',
            'gram_panchayat_code' => 'Gram Panchayat',
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
    public function getPbank() {
        return $this->hasOne(\bc\modules\transaction\models\summary\MasterPartnerBank::className(), ['id' => 'master_partner_bank_id']);
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
}
