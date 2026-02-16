<?php

namespace bc\modules\training\models;

use Yii;

/**
 * This is the model class for table "rsetis_ecalendar".
 *
 * @property int $id
 * @property string $date
 * @property int $district_code
 * @property int $total_training
 * @property int $total_participant
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $status
 */
class RsetisEcalendar extends \bc\models\BcactiveRecord {

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function() {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'rsetis_ecalendar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['date'], 'required'],
            [['date'], 'safe'],
            [['district_code', 'total_training', 'total_participant', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'district_code' => 'District',
            'total_training' => 'Total Training',
            'total_participant' => 'Total Participant',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {

//        if ($this->date != NULL and $this->date != '') {
//            $this->date = \Yii::$app->formatter->asDatetime($this->date, "php:Y-m-d");
//        }


        return parent::beforeSave($insert);
    }

}
