<?php

namespace common\models\rishta;

use Yii;

/**
 * This is the model class for table "rishta_notification_log".
 *
 * @property int $id
 * @property int $user_id
 * @property int $app_id
 * @property int|null $visible
 * @property int $acknowledge
 * @property string $message_title
 * @property string $message
 * @property int|null $notification_template_id
 * @property string|null $external_url
 * @property string $genrated_on
 * @property string|null $send_datetime
 * @property int $acknowledge_status
 * @property string|null $acknowledge_date
 * @property int $send_count
 * @property int $cron_status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class RishtaNotificationLog extends \common\models\dynamicdb\rishta_log\RishtalogactiveRecord {

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'rishta_notification_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'message_title', 'message', 'genrated_on', 'status'], 'required'],
            [['user_id', 'app_id', 'visible', 'acknowledge', 'notification_template_id', 'acknowledge_status', 'send_count', 'cron_status', 'created_at', 'updated_at', 'status'], 'integer'],
            [['message_title', 'message'], 'string'],
            [['genrated_on', 'send_datetime', 'acknowledge_date'], 'safe'],
            [['external_url'], 'string', 'max' => 1500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'app_id' => 'App ID',
            'visible' => 'Visible',
            'acknowledge' => 'Acknowledge',
            'message_title' => 'Message Title',
            'message' => 'Message',
            'notification_template_id' => 'Notification Template ID',
            'external_url' => 'External Url',
            'genrated_on' => 'Genrated On',
            'send_datetime' => 'Send Datetime',
            'acknowledge_status' => 'Acknowledge Status',
            'acknowledge_date' => 'Acknowledge Date',
            'send_count' => 'Send Count',
            'cron_status' => 'Cron Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getUser() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }

    public function getTemplate() {
        return $this->hasOne(RishtaNotificationTemplate::className(), ['id' => 'notification_template_id']);
    }

    public function getDetail() {
        return $this->hasMany(RishtaNotificationLogFirebaseDetail::className(), ['notification_log_id' => 'id']);
    }

}
