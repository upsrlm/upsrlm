<?php

namespace bc\modules\transaction\models\dump;

use Yii;

/**
 * This is the model class for table "bc_transaction_dump_1".
 *
 * @property int $id
 * @property string|null $col0
 * @property string|null $col1
 * @property string|null $col2
 * @property string|null $col3
 * @property string|null $col4
 * @property string|null $col5
 * @property string|null $col6
 * @property int|null $file_id
 * @property int|null $master_partner_bank_id
 * @property int $status
 */
class BcTransactionDump1 extends DumpActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_transaction_dump_1';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_id', 'master_partner_bank_id', 'status'], 'integer'],
            [['col0', 'col1', 'col2', 'col3', 'col4', 'col5', 'col6'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'col0' => 'Col 0',
            'col1' => 'Col 1',
            'col2' => 'Col 2',
            'col3' => 'Col 3',
            'col4' => 'Col 4',
            'col5' => 'Col 5',
            'col6' => 'Col 6',
            'file_id' => 'File ID',
            'master_partner_bank_id' => 'Master Partner Bank ID',
            'status' => 'Status',
        ];
    }
}
