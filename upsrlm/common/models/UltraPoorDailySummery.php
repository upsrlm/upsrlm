<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ultra_poor_daily_summery".
 *
 * @property int $id
 * @property string $date
 * @property int $user_add
 * @property int $form_submit
 * @property int $form_return
 * @property int $form_verify
 * @property int $text_sms_send
 * @property int $voice_sms_send
 * @property int $call_attempt
 * @property int $call_talk
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class UltraPoorDailySummery extends \common\models\dynamicdb\cbo\CboactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ultra_poor_daily_summery';
    }

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
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['date'], 'safe'],
            [['user_add', 'form_submit', 'form_return', 'form_verify', 'text_sms_send', 'voice_sms_send', 'call_attempt', 'call_talk', 'created_at', 'updated_at'], 'integer'],
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
            'user_add' => 'User Add',
            'form_submit' => 'Form Submit',
            'form_return' => 'Form Return',
            'form_verify' => 'Form Verify',
            'text_sms_send' => 'Text Sms Send',
            'voice_sms_send' => 'Voice Sms Send',
            'call_attempt' => 'Call Attempt',
            'call_talk' => 'Call Talk',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
