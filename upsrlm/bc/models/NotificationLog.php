<?php

namespace bc\models;

use Yii;

/**
 * This is the model class for table "notification_log".
 *
 * @property int $id
 * @property int $notification_type
 * @property int $notification_sub_type
 * @property int $detail_id
 * @property int $user_id
 * @property int $app_id
 * @property int|null $visible
 * @property int $acknowledge
 * @property string $message_title
 * @property string $message
 * @property string $genrated_on
 * @property string $send_datetime
 * @property int $acknowledge_status
 * @property string|null $acknowledge_date
 * @property int $send_count
 * @property int $cron_status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int $status
 */
class NotificationLog extends \bc\modules\selection\models\BcactiveRecord {

    const NOTIFICATION_TYPE_BC_APPLICATION_SELECTION = 1;
    const NOTIFICATION_SUB_TYPE_BC_APPLICATION_SELECTION_ACKNOLEDGE = 101;

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
        return 'notification_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['notification_type', 'notification_sub_type', 'user_id', 'message_title', 'message', 'status'], 'required'],
            [['notification_type', 'notification_sub_type', 'detail_id', 'user_id', 'app_id', 'visible', 'acknowledge', 'acknowledge_status', 'send_count', 'cron_status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['message_title', 'message'], 'string'],
            [['genrated_on', 'acknowledge_date'], 'safe'],
            [['send_datetime'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'notification_type' => 'Notification Type',
            'notification_sub_type' => 'Notification Sub Type',
            'detail_id' => 'Detail ID',
            'user_id' => 'User ID',
            'app_id' => 'App ID',
            'visible' => 'Visible',
            'acknowledge' => 'Acknowledge',
            'message_title' => 'Message Title',
            'message' => 'Message',
            'genrated_on' => 'Genrated On',
            'acknowledge_status' => 'Acknowledge Status',
            'acknowledge_date' => 'Acknowledge Date',
            'send_count' => 'Send Count',
            'cron_status' => 'Cron Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->genrated_on = new \yii\db\Expression('NOW()');
        }
        return parent::beforeSave($insert);
    }

    public function getBcuser() {
        return $this->hasOne(\bc\modules\selection\models\SrlmBcSelectionUser::className(), ['id' => 'user_id']);
    }

    public function getTemplate() {
        return $this->hasOne(NotificationTemplate::className(), ['id' => 'detail_id']);
    }
     public function getDetail() {
        return $this->hasMany(NotificationLogFirebaseDetail::className(), ['notification_log_id' => 'id']);
    }

}
