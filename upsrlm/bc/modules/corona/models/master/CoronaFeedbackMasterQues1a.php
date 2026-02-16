<?php

namespace bc\modules\corona\models\master;

use Yii;

/**
 * This is the model class for table "corona_feedback_master_ques1a".
 *
 * @property int $id
 * @property string|null $name_eng
 * @property string|null $name_hi
 * @property int $status
 */
class CoronaFeedbackMasterQues1a extends \bc\modules\selection\models\BcactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'corona_feedback_master_ques1a';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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
            'status' => 'Status',
        ];
    }
}
