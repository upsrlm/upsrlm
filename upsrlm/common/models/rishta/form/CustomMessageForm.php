<?php

namespace common\models\rishta\form;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use common\models\base\GenralModel;
use common\models\User;
use common\models\master\MasterRole;
use common\models\rishta\RishtaNotificationLog;
use common\models\rishta\RishtaNotificationTemplate;
use common\models\rishta\RishtaNotificationLogFirebaseDetail;
use common\components\GoogleFirebaseRishta;
use bc\modules\selection\models\SrlmBcApplication;
/**
 * CustomMessageForm is the model behind the User
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class CustomMessageForm extends Model {

    public $id;
    public $user_id;
    public $app_id;
    public $visible = 1;
    public $acknowledge = 1;
    public $message_title;
    public $message;
    public $notification_template_id;
    public $external_url;
    public $genrated_on;
    public $send_datetime;
    public $acknowledge_status;
    public $acknowledge_date;
    public $send_count;
    public $cron_status;
    public $created_at;
    public $updated_at;
    public $status;
    public $user_model;
    public $bc_model;

    public function __construct($user_model) {
        $this->user_model = $user_model;
        $this->bc_model=SrlmBcApplication::findOne(['user_id'=>$this->user_model->id]);
        $this->user_id = $this->user_model->id;
        $this->app_id = $this->user_model->app_id;
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['user_id', 'app_id', 'message_title', 'message'], 'required'],
            [['message'], 'trim'],
            [['message_title'], 'trim'],
            [['message'], 'string', 'max' => 500],
            [['message_title'], 'string', 'max' => 150],
            [['message_title'], 'string', 'min' => 4],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'app_id' => 'App ID',
            'visible' => 'Visible',
            'acknowledge' => 'Acknowledge',
            'message_title' => 'Notification Title',
            'message' => 'Notification Message',
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

    public function save() {
        $noti_log_model = new RishtaNotificationLog();
        $noti_log_model->user_id = $this->user_model->id;
        $noti_log_model->app_id = $this->app_id;
        $noti_log_model->visible = 1;
        $noti_log_model->acknowledge = 1;
        $noti_log_model->message_title = $this->message_title;
        $noti_log_model->message = $this->message;
        $noti_log_model->notification_template_id = $this->notification_template_id;
        $noti_log_model->cron_status = 0;
        $noti_log_model->status = 0;
        $noti_log_model->genrated_on = new \yii\db\Expression('NOW()');
        if ($noti_log_model->save()) {
            try {
                $notification = RishtaNotificationLog::findOne($noti_log_model->id);
                $firbase_tocken = $this->user_model->firebase_token;
                $firebase = new GoogleFirebaseRishta($notification);
                $response = $firebase->send($firbase_tocken);
                $response_result = json_decode($response);
                $notification->cron_status = '1';
                $notification->send_count = ($notification->send_count + 1);
                $notification_model_detail = new RishtaNotificationLogFirebaseDetail();
                $notification_model_detail->notification_log_id = $notification->id;
                if ($response_result == null) {
                    $notification->status = -1;
                    $notification_model_detail->firebase_message = "No Token";
                } else {
                    if ($response_result->success) {
                        $notification->status = 1;
                        $notification->send_datetime = new \yii\db\Expression('NOW()');
                        $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
                    } else {
                        $notification->status = 2;
                        $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
                    }
                }
                $notification_model_detail->save();
                $notification->update();
            } catch (\Exception $ex) {
                
            }
            return true;
        }
        return false;
    }
}
