<?php

namespace common\models\dynamicdb\mopup;

use Yii;
use common\models\dynamicdb\mopup\MopupactiveRecord;

/**
 * This is the model class for table "mopup_notification_log".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $app_id
 * @property int|null $visible
 * @property int $acknowledge
 * @property string $message_title
 * @property string|null $message
 * @property int|null $notification_template_id
 * @property string|null $external_url
 * @property string|null $genrated_on
 * @property string|null $send_datetime
 * @property int $acknowledge_status
 * @property string|null $acknowledge_date
 * @property int $send_count
 * @property int $cron_status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class MopupNotificationLog extends MopupactiveRecord {

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
        return 'mopup_notification_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'app_id', 'visible', 'acknowledge', 'notification_template_id', 'acknowledge_status', 'send_count', 'cron_status', 'created_at', 'updated_at', 'status'], 'integer'],
            [['message_title'], 'required'],
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

}
