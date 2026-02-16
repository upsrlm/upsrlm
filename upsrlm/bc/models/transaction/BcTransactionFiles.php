<?php

namespace bc\models\transaction;

use Yii;

/**
 * This is the model class for table "bc_transaction_files".
 *
 * @property int $id
 * @property string|null $label
 * @property string $file_name
 * @property int|null $row_count
 * @property int|null $master_partner_bank_id
 * @property int|null $upload_by
 * @property int $new
 * @property int $repeats
 * @property int $error
 * @property string|null $upload_datetime
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class BcTransactionFiles extends \bc\modules\transaction\models\dump\DumpActiveRecord {

    const STATUS_FILE_UPLOAD = 1;
    const STATUS_FILE_DUMP = 2;
    const STATUS_FILE_PROCESS = 3;
    const STATUS_FILE_ERROR = 11;

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
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
        return 'bc_transaction_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['file_name'], 'required'],
            [['row_count', 'master_partner_bank_id', 'upload_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['upload_datetime'], 'safe'],
            [['file_name'], 'string', 'max' => 500],
            [['label'], 'string', 'max' => 255],
            ['new', 'default', 'value' => 0],
            ['repeats', 'default', 'value' => 0],
            ['error', 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'file_name' => 'File Name',
            'row_count' => 'Number of rows',
            'master_partner_bank_id' => 'Partner agencies',
            'upload_by' => 'Upload By',
            'error' => 'Errors',
            'new' => 'New',
            'repeats' => 'Repeats',
            'upload_datetime' => 'Upload Datetime',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getPbank() {
        return $this->hasOne(\bc\models\master\MasterPartnerBank::className(), ['id' => 'master_partner_bank_id']);
    }

    public function getDetail() {
        if ($this->master_partner_bank_id == \bc\models\master\MasterPartnerBank::BOB) {
            return $this->hasMany(BcTransactionTable1::className(), ['file_id' => 'id']);
        }
        if ($this->master_partner_bank_id == \bc\models\master\MasterPartnerBank::FINO) {
            return $this->hasMany(BcTransactionTable2::className(), ['file_id' => 'id']);
        }
        if ($this->master_partner_bank_id == \bc\models\master\MasterPartnerBank::NEARBY) {
            return $this->hasMany(BcTransactionTable3::className(), ['file_id' => 'id']);
        }
        if ($this->master_partner_bank_id == \bc\models\master\MasterPartnerBank::MANIPAL) {
            return $this->hasMany(BcTransactionTable4::className(), ['file_id' => 'id']);
        }
        if ($this->master_partner_bank_id == \bc\models\master\MasterPartnerBank::MFSL_AIRTEl) {
            return $this->hasMany(BcTransactionTable5::className(), ['file_id' => 'id']);
        }
        if ($this->master_partner_bank_id == \bc\models\master\MasterPartnerBank::PTM) {
            return $this->hasMany(BcTransactionTable6::className(), ['file_id' => 'id']);
        }
        return '';
    }

}
