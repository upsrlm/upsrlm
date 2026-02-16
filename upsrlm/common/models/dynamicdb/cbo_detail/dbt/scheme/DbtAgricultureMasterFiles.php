<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use Yii;

/**
 * This is the model class for table "dbt_agriculture_master_files".
 *
 * @property int $id
 * @property string|null $note
 * @property string $file_name
 * @property int|null $upload_by
 * @property string|null $upload_datetime
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class DbtAgricultureMasterFiles extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'dbt_agriculture_master_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['file_name'], 'required'],
            [['upload_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['upload_datetime'], 'safe'],
            [['note', 'file_name'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'note' => 'Note',
            'file_name' => 'File Name',
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
