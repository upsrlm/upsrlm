<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "google_analytics_log".
 *
 * @property int $id
 * @property int $date
 * @property int $total_visitor_count_yesterday
 * @property int $total_page_view_count_yesterday
 * @property int $created_at
 * @property int $updated_at
 */
class GoogleAnalyticsLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
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
    
    public static function tableName()
    {
        return 'google_analytics_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'total_visitor_count_yesterday', 'total_page_view_count_yesterday', 'created_at', 'updated_at'], 'safe'],
            [['date', 'total_visitor_count_yesterday', 'total_page_view_count_yesterday', 'created_at', 'updated_at'], 'integer'],
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
            'total_visitor_count_yesterday' => 'Total Visitor Count Yesterday',
            'total_page_view_count_yesterday' => 'Total Page View Count Yesterday',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
