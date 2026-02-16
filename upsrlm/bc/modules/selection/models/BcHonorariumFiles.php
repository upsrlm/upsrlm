<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "bc_honorarium_files".
 *
 * @property int $id
 * @property string|null $month
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
class BcHonorariumFiles extends BcactiveRecord {

    const MONTHLY_PAYMEN_AMOUNT = 4000;

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
        return 'bc_honorarium_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['month', 'distribution_date', 'upload_datetime'], 'safe'],
            [['file_name'], 'required'],
            [['row_count', 'error_count', 'success_count', 'upload_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['file_name'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'month' => 'Month',
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
    public function beforeSave($insert) {
        if ($this->month) {
            $this->month = date('Y-m-01', strtotime($this->month));
        }
        
        return parent::beforeSave($insert);
    }
}
