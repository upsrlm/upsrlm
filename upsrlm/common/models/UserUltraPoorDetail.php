<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_ultra_poor_detail".
 *
 * @property int $id
 * @property int $user_id
 * @property int $role
 * @property int $contact
 * @property int $go_send
 * @property int $go_contact
 * @property int $text_sms
 * @property int $voice_sms
 * @property int $firebase_notification
 * @property int $login
 * @property int $user_add
 * @property int $no_of_call_attempt
 * @property int $call_talk
 * @property string|null $last_call
 * @property int $hhs_enumerated
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class UserUltraPoorDetail extends \common\models\dynamicdb\cbo\CboactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user_ultra_poor_detail';
    }

    public function behaviors() {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id'], 'required'],
            [['user_id', 'role', 'contact', 'go_send', 'go_contact', 'text_sms', 'voice_sms', 'firebase_notification', 'login', 'user_add', 'no_of_call_attempt', 'call_talk', 'hhs_enumerated', 'created_at', 'updated_at'], 'integer'],
            [['last_call'], 'safe'],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'role' => 'Role',
            'contact' => 'Contact',
            'go_send' => 'Go Send',
            'go_contact' => 'Go Contact',
            'text_sms' => 'Text Sms',
            'voice_sms' => 'Voice Sms',
            'firebase_notification' => 'Firebase Notification',
            'login' => 'Login',
            'user_add' => 'User Add',
            'no_of_call_attempt' => 'No Of Call Attempt',
            'call_talk' => 'Call Talk',
            'last_call' => 'Last Call',
            'hhs_enumerated' => 'Hhs Enumerated',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
