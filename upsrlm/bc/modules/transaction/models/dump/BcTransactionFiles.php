<?php

namespace bc\modules\transaction\models\dump;

use Yii;

/**
 * This is the model class for table "bc_transaction_files".
 *
 * @property int $id
 * @property string|null $label
 * @property string $file_name
 * @property int|null $row_count
 * @property int $new
 * @property int $repeats
 * @property int $error
 * @property int|null $master_partner_bank_id
 * @property int|null $upload_by
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

    public static function tableName() {
        return 'bc_transaction_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['file_name'], 'required'],
            [['row_count', 'new', 'repeats', 'error', 'master_partner_bank_id', 'upload_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['upload_datetime'], 'safe'],
            [['label'], 'string', 'max' => 255],
            [['file_name'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'label' => 'Label',
            'file_name' => 'File Name',
            'row_count' => 'Row Count',
            'new' => 'New',
            'repeats' => 'Repeats',
            'error' => 'Error',
            'master_partner_bank_id' => 'Master Partner Bank ID',
            'upload_by' => 'Upload By',
            'upload_datetime' => 'Upload Datetime',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

}
