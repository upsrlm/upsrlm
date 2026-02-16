<?php

namespace bc\models\transaction;

use Yii;

/**
 * This is the model class for table "bc_transaction_table1".
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
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class BcTransactionTable4 extends \bc\models\transaction\BctransactionactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'bc_transaction_table4';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['file_id', 'master_partner_bank_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['col0', 'col1', 'col2', 'col3', 'col4', 'col5', 'col6'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'col0' => 'Col0',
            'col1' => 'Col1',
            'col2' => 'Col2',
            'col3' => 'Col3',
            'col4' => 'Col4',
            'col5' => 'Col5',
            'col6' => 'Col6',
            'file_id' => 'File ID',
            'master_partner_bank_id' => 'Partner agencies',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {

        if ($this->isNewRecord) {
            if ($this->created_at == null) {
                $this->created_at = time();
            }
            if ($this->updated_at == null) {
                $this->updated_at = time();
            }
        } else {
            if ($this->updated_at == null) {
                $this->updated_at = time();
            }
        }

        return parent::beforeSave($insert);
    }

    public function getPbank() {
        return $this->hasOne(\bc\models\master\MasterPartnerBank::className(), ['id' => 'master_partner_bank_id']);
    }

}
