<?php

namespace common\models\dynamicdb\cbo_detail;

use Yii;

/**
 * This is the model class for table "dbt_goverment_order".
 *
 * @property int $id
 * @property string|null $goverment_order_number
 * @property string|null $goverment_order_topic
 * @property string|null $goverment_order_date
 * @property int|null $goverment_order_department
 * @property string $file_name
 * @property string|null $file_size
 * @property string|null $file_type
 * @property int|null $upload_by
 * @property string|null $upload_datetime
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class DbtGovermentOrder extends CboDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'dbt_goverment_order';
    }

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
    public function rules() {
        return [
            [['goverment_order_date', 'upload_datetime'], 'safe'],
            [['goverment_order_department', 'upload_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['file_name'], 'required'],
            [['goverment_order_number', 'file_type'], 'string', 'max' => 200],
            [['goverment_order_topic', 'file_name'], 'string', 'max' => 500],
            [['file_size'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'goverment_order_number' => 'Goverment Order Number',
            'goverment_order_topic' => 'Goverment Order Topic',
            'goverment_order_date' => 'Goverment Order Date',
            'goverment_order_department' => 'Goverment Order Department',
            'file_name' => 'File Name',
            'file_size' => 'File Size',
            'file_type' => 'File Type',
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
