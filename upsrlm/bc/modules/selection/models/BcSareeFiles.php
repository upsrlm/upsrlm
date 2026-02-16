<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "bc_saree_files".
 *
 * @property int $id
 * @property int|null $saree
 * @property string|null $distribution_date
 * @property string $file_name
 * @property int|null $row_count
 * @property int $error_count
 * @property int|null $success_count
 * @property int|null $upload_by
 * @property string|null $upload_datetime
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class BcSareeFiles extends BcactiveRecord {

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
    public static function tableName()
    {
        return 'bc_saree_files';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['saree', 'row_count', 'error_count', 'success_count', 'upload_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['distribution_date', 'upload_datetime'], 'safe'],
            [['saree','distribution_date'], 'required'],
            [['file_name'], 'required'],
            [['file_name'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'saree' => 'Saree',
            'distribution_date' => 'Distribution Date',
            'file_name' => 'File Name',
            'row_count' => 'Row Count',
            'error_count' => 'Error Count',
            'success_count' => 'Success Count',
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
