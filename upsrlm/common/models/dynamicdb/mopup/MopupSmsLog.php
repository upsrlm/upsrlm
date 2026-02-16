<?php

namespace common\models\dynamicdb\mopup;

use Yii;
use common\models\dynamicdb\mopup\MopupactiveRecord;

/**
 * This is the model class for table "mopup_sms_log".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $user_id
 * @property int $role
 * @property string $mobile_number
 * @property int|null $sms_template_id
 * @property string|null $template_id
 * @property string|null $model
 * @property string $sms_content
 * @property string|null $sms_send_time
 * @property string|null $delivery_status
 * @property int $delstatus
 * @property int $try_send_count
 * @property int|null $unicode
 * @property int $sms_length
 * @property int $sms_count
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
class MopupSmsLog extends MopupactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'mopup_sms_log';
    }

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
    public function rules() {
        return [
            [['user_id', 'sms_template_id', 'try_send_count', 'unicode', 'sms_length', 'sms_count', 'sms_provider_campaign_id', 'sms_provider_code', 'created_by', 'updated_by', 'updated_at', 'created_at', 'status', 'role', 'delstatus'], 'integer'],
            [['mobile_number', 'sms_content'], 'required'],
            [['model'], 'string'],
            [['sms_send_time'], 'safe'],
            [['name', 'sms_provider_msg', 'sms_provider_msg_text'], 'string', 'max' => 255],
            [['mobile_number'], 'string', 'max' => 20],
            [['template_id'], 'string', 'max' => 100],
            [['sms_content'], 'string', 'max' => 500],
            [['delivery_status', 'sms_provider_message_id'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'user_id' => 'User ID',
            'mobile_number' => 'Mobile Number',
            'sms_template_id' => 'Sms Template ID',
            'template_id' => 'Template ID',
            'model' => 'Model',
            'sms_content' => 'Sms Content',
            'sms_send_time' => 'Sms Send Time',
            'delivery_status' => 'Delivery Status',
            'try_send_count' => 'Try Send Count',
            'unicode' => 'Unicode',
            'sms_length' => 'Sms Length',
            'sms_count' => 'Sms Count',
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
        if ($this->sms_template_id == 22) {
            $this->sms_count = 4;
            $this->unicode = 1;
        }
        if ($this->sms_template_id == 21) {
            $this->sms_count = 6;
            $this->unicode = 1;
        }
        $user = \common\models\User::find()->where(['username' => $this->mobile_number])->one();
        if ($user != null) {
            $this->role = $user->role;
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {
        $attribute = MopupSmsLog::findOne($this->id);
        try {
            $logmain = new \common\models\MopupSmsLog();
            $modellog = $logmain::findOne($attribute->id);
            if (empty($modellog)) {
                $modellog = new \common\models\MopupSmsLog();
            }
            $modellog->id = $attribute->id;
            $modellog->setAttributes($attribute->toArray());
            $modellog->role = $attribute->role;
            $modellog->user_id = $attribute->user_id;
            $modellog->created_by = $attribute->created_by;
            $modellog->updated_by = $attribute->updated_by;

            if ($modellog->save()) {
                
            } else {
//                print_r($modellog->getErrors());exit;
            }
        } catch (\Exception $ex) {
//            print_r($ex->getMessage());
//            exit;
        }


        return true;
    }
}
