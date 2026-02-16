<?php

namespace bc\modules\training\models;

use Yii;

/**
 * This is the model class for table "rsetis_training_status".
 *
 * @property int $id
 * @property string $status_eng
 * @property string $status_hi
 * @property int $status
 */
class RsetisTrainingStatus extends \bc\models\BcactiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rsetis_training_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_eng', 'status_hi'], 'required'],
            [['status'], 'integer'],
            [['status_eng', 'status_hi'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_eng' => 'Status Eng',
            'status_hi' => 'Status Hi',
            'status' => 'Status',
        ];
    }
}
