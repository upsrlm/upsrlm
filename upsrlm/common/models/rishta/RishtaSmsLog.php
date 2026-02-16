<?php

namespace common\models\rishta;

use Yii;

/**
 * This is the model class for table "rishta_sms_log".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $mobile_number
 * @property int|null $rishta_sms_template_id
 * @property string|null $model
 * @property string $sms_content
 * @property string|null $sms_send_time
 * @property string|null $delivery_status
 * @property int $try_send_count
 * @property int|null $unicode
 * @property int $sms_length
 * @property string|null $sms_provider_message_id
 * @property int|null $sms_provider_campaign_id
 * @property string|null $sms_provider_msg
 * @property string|null $sms_provider_msg_text
 * @property int|null $sms_provider_code
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $updated_at
 * @property int|null $created_at
 * @property int $status
 */
class RishtaSmsLog extends \common\models\dynamicdb\rishta_log\RishtalogactiveRecord {

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
        return 'rishta_sms_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'rishta_sms_template_id', 'try_send_count', 'unicode', 'sms_length', 'sms_provider_campaign_id', 'sms_provider_code', 'created_by', 'updated_by', 'updated_at', 'created_at', 'status'], 'integer'],
            [['mobile_number', 'sms_content'], 'required'],
            [['model'], 'string'],
            [['sms_send_time'], 'safe'],
            [['mobile_number'], 'string', 'max' => 20],
            [['sms_content'], 'string', 'max' => 500],
            [['delivery_status', 'sms_provider_message_id'], 'string', 'max' => 150],
            [['sms_provider_msg', 'sms_provider_msg_text'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'mobile_number' => 'Mobile Number',
            'rishta_sms_template_id' => 'Rishta Sms Template ID',
            'model' => 'Model',
            'sms_content' => 'Sms Content',
            'sms_send_time' => 'Sms Send Time',
            'delivery_status' => 'Delivery Status',
            'try_send_count' => 'Try Send Count',
            'unicode' => 'Unicode',
            'sms_length' => 'Sms Length',
            'sms_provider_message_id' => 'Sms Provider Message ID',
            'sms_provider_campaign_id' => 'Sms Provider Campaign ID',
            'sms_provider_msg' => 'Sms Provider Msg',
            'sms_provider_msg_text' => 'Sms Provider Msg Text',
            'sms_provider_code' => 'Sms Provider Code',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {
        if ($this->rishta_sms_template_id == 1) {
            $this->sms_count = 2;
            $this->unicode = 1;
        }
        if ($this->rishta_sms_template_id == 2) {
            $this->sms_count = 6;
            $this->unicode = 1;
        }
        if ($this->rishta_sms_template_id == 3) {
            $this->sms_count = 5;
            $this->unicode = 1;
        }

        return parent::beforeSave($insert);
    }

    public function getUser() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }

    public function getTemplate() {
        $a = [2 => 'SHG Office Bearer', 1 => 'SHG Office Bearer PIN', 3 => 'Wada Samuh Sakhi Nominated'];
        return isset($a[$this->rishta_sms_template_id]) ? $a[$this->rishta_sms_template_id] : '';
    }

}
