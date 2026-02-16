<?php

namespace cbo\models\master;

use Yii;

/**
 * This is the model class for table "cbo_master_cast".
 *
 * @property int $id
 * @property string|null $name_eng
 * @property string|null $name_hi
 * @property float $rating_weightage
 * @property int $status
 */
class CboMasterCast extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'cbo_master_cast';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['rating_weightage'], 'number'],
            [['status'], 'integer'],
            [['name_eng', 'name_hi'], 'string', 'max' => 500],
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
