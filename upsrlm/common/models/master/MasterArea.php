<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "master_area".
 *
 * @property int $id
 * @property string|null $hindi_name
 * @property string|null $english_name
 * @property int $status
 */
class MasterArea extends \yii\db\ActiveRecord {

    const AREA_RURAL = 1;
    const AREA_URBAN = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'master_area';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['status'], 'integer'],
            [['hindi_name', 'english_name'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'hindi_name' => 'Hindi Name',
            'english_name' => 'English Name',
            'status' => 'Status',
        ];
    }

}
