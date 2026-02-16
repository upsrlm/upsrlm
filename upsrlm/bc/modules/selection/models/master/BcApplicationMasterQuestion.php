<?php

namespace bc\modules\selection\models\master;

use Yii;

/**
 * This is the model class for table "bc_application_master_question".
 *
 * @property int $id
 * @property string $question_name
 * @property int $section_id
 * @property float $rating
 * @property string $question_type
 * @property string $question_column
 * @property int $status
 */
class BcApplicationMasterQuestion extends \bc\modules\selection\models\BcactiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_application_master_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_name', 'section_id', 'rating', 'question_type', 'question_column'], 'required'],
            [['section_id', 'status'], 'integer'],
            [['rating'], 'number'],
            [['question_name'], 'string', 'max' => 500],
            [['question_type'], 'string', 'max' => 150],
            [['question_column'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_name' => 'Question Name',
            'section_id' => 'Section ID',
            'rating' => 'Rating',
            'question_type' => 'Question Type',
            'question_column' => 'Question Column',
            'status' => 'Status',
        ];
    }
}
