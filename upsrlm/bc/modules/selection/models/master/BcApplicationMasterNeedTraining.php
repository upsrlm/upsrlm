<?php

namespace bc\modules\selection\models\master;

use Yii;

/**
 * This is the model class for table "bc_application_master_need_training".
 *
 * @property int $id
 * @property string $name_eng
 * @property string $name_hi
 * @property float $rating_weightage
 * @property int $status
 */
class BcApplicationMasterNeedTraining extends \bc\modules\selection\models\BcactiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_application_master_need_training';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_eng', 'name_hi'], 'required'],
            [['rating_weightage'], 'number'],
            [['status'], 'integer'],
            [['name_eng', 'name_hi'], 'string', 'max' => 100],
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
