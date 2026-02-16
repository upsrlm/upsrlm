<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "master_date".
 *
 * @property int $id
 * @property string $date
 * @property int $nfsa_survey
 */
class MasterDate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_date';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['date'], 'safe'],
            [['nfsa_survey'], 'integer'],
            [['date'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'nfsa_survey' => 'Nfsa Survey',
        ];
    }
}
