<?php

namespace common\models\dynamicdb\cbo_detail;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "rishta_temp_photo".
 *
 * @property int $id
 * @property string $file_id
 * @property string $file_name
 * @property int|null $created_by
 * @property int|null $created_at
 */
class RishtaTempPhoto extends CboDetailactiveRecord {

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ],
            ],
            'blameable' => [
                'class' => 'yii\behaviors\BlameableBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by']
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'rishta_temp_photo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['file_id', 'file_name'], 'required'],
            [['created_by', 'created_at'], 'integer'],
            [['file_id', 'file_name'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'file_id' => 'File ID',
            'file_name' => 'File Name',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }

}
