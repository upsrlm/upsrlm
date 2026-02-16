<?php

namespace bc\modules\transaction\models\districtdump;

use Yii;

/**
 * This is the model class for table "bc_transaction_1".
 *
 * @property int $id
 * @property int|null $bc_application_id
 * @property string|null $bankidbc
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property int|null $master_partner_bank_id
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
class BcTransactionUserDump extends DistrictDumpActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bc_application_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'file_id', 'dtable_id', 'ticket'], 'integer'],
            [['transaction_datetime', 'transaction_date', 'transaction_time'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['bankidbc'], 'string', 'max' => 20],
            [['banktransactionid'], 'string', 'max' => 40],
            [['transaction_type'], 'string', 'max' => 255],
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
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'master_partner_bank_id' => 'Master Partner Bank ID',
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
}
