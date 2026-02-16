<?php

namespace bc\modules\selection\models\master;

use Yii;

/**
 * This is the model class for table "bc_application_master_other_meaning4".
 *
 * @property int $id
 * @property string|null $name_eng
 * @property string|null $name_hi
 * @property float $rating_weightage
 * @property int $status
 */
class BcApplicationMasterOtherMeaning4 extends \bc\modules\selection\models\BcactiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_application_master_other_meaning4';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rating_weightage'], 'number'],
            [['status'], 'integer'],
            [['name_eng', 'name_hi'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_eng' => 'Name Eng',
            'name_hi' => 'Name Hi',
            'rating_weightage' => 'Rating Weightage',
            'status' => 'Status',
        ];
    }
}
