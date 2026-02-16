<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property int $id
 * @property string $name
 * @property int $value
 */
class ApplicationConfig extends \yii\db\ActiveRecord {

    const GP_VERSION_ID = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'application_config';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'value'], 'required'],
            [['value'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }

}
