<?php

namespace cbo\models\master;

use Yii;

/**
 * This is the model class for table "cbo_master_phone_type".
 *
 * @property int $id
 * @property string $name_eng
 * @property string $name_hi
 * @property float $rating_weightage
 * @property int $status
 */
class CboMasterPhoneType extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'cbo_master_phone_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name_eng', 'name_hi'], 'required'],
            [['rating_weightage'], 'number'],
            [['status'], 'integer'],
            [['name_eng', 'name_hi'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name_eng' => 'Name Eng',
            'name_hi' => 'Name Hi',
            'rating_weightage' => 'Rating Weightage',
            'status' => 'Status',
        ];
    }

}
