<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "site_report".
 *
 * @property int $id
 * @property int $ga_visitor_count_till_date
 * @property int $ga_visitor_count_till_yesterday
 * @property int $ga_visitor_count_till_last_one_week
 * @property int $ga_visitor_count_today
 * @property int $created_at
 * @property int $updated_at
 * @property string $last_update_time
 */
class SiteReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'site_report';
    }

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function() {
                    return time();
                },
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ga_visitor_count_till_date', 'ga_visitor_count_till_yesterday', 'ga_visitor_count_till_last_one_week', 'ga_visitor_count_today', 'created_at', 'updated_at', 'last_update_time'], 'safe'],
            [['ga_visitor_count_till_date', 'ga_visitor_count_till_yesterday', 'ga_visitor_count_till_last_one_week', 'ga_visitor_count_today', 'created_at', 'updated_at'], 'integer'],
            [['last_update_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ga_visitor_count_till_date' => 'Ga Visitor Count Till Date',
            'ga_visitor_count_till_yesterday' => 'Ga Visitor Count Till Yesterday',
            'ga_visitor_count_till_last_one_week' => 'Ga Visitor Count Till Last One Week',
            'ga_visitor_count_today' => 'Ga Visitor Count Today',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'last_update_time' => 'Last Update Time',
        ];
    }
}
