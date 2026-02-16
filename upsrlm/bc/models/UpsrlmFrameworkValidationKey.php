<?php

namespace bc\models;

use Yii;

/**
 * This is the model class for table "upsrlm_framework_validation_key".
 *
 * @property int $id
 * @property string|null $key_name
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status
 */
class UpsrlmFrameworkValidationKey extends BcactiveRecord {

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
        return 'upsrlm_framework_validation_key';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['key_name'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'key_name' => 'Key Name',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

}
