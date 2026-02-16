<?php

namespace bc\models;

use Yii;

/**
 * This is the model class for table "application_history".
 *
 * @property int $id
 * @property string|null $bc_beneficiaries_code
 * @property int|null $bc_beneficiaries_code_by
 * @property string|null $bc_beneficiaries_code_date
 * @property int $training_feedback
 */
class ApplicationHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bc_beneficiaries_code_by', 'training_feedback'], 'integer'],
            [['bc_beneficiaries_code_date'], 'safe'],
            [['bc_beneficiaries_code'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bc_beneficiaries_code' => 'Bc Beneficiaries Code',
            'bc_beneficiaries_code_by' => 'Bc Beneficiaries Code By',
            'bc_beneficiaries_code_date' => 'Bc Beneficiaries Code Date',
            'training_feedback' => 'Training Feedback',
        ];
    }
}
