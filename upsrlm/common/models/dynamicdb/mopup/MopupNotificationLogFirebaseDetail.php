<?php

namespace common\models\dynamicdb\mopup;

use Yii;
use common\models\dynamicdb\mopup\MopupactiveRecord;

/**
 * This is the model class for table "mopup_notification_log_firebase_detail".
 *
 * @property int $id
 * @property int $notification_log_id
 * @property string|null $firebase_id
 * @property string|null $firebase_message
 * @property string|null $create_on
 */
class MopupNotificationLogFirebaseDetail extends MopupactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mopup_notification_log_firebase_detail';
    }

  
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notification_log_id'], 'required'],
            [['notification_log_id'], 'integer'],
            [['create_on'], 'safe'],
            [['firebase_id', 'firebase_message'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'notification_log_id' => 'Notification Log ID',
            'firebase_id' => 'Firebase ID',
            'firebase_message' => 'Firebase Message',
            'create_on' => 'Create On',
        ];
    }
     public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->create_on = new \yii\db\Expression('NOW()');
        }
        return parent::beforeSave($insert);
    }
}
