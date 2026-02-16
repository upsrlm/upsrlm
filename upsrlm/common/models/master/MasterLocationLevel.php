<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "master_location_level".
 *
 * @property int $id
 * @property string $location_level_name
 * @property int $status
 */
class MasterLocationLevel extends \yii\db\ActiveRecord {

    const LOCATION_STATE = 3;
    const LOCATION_DIVISION = 4;
    const LOCATION_DISTRICT = 5;
    const LOCATION_URBAN = 8;
    const LOCATION_RURAL = 9;
    const LOCATION_BLOCK = 21;
    const LOCATION_GP = 22;
    const LOCATION_VILLAGE = 23;
    const LOCATION_ULB = 31;
    const LOCATION_WARD = 32;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'master_location_level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'location_level_name'], 'required'],
            [['id', 'status'], 'integer'],
            [['location_level_name'], 'string', 'max' => 60],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'location_level_name' => 'Location Level Name',
            'status' => 'Status',
        ];
    }

}
