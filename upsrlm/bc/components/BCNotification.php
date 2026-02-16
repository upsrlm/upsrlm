<?php

namespace bc\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use bc\models\NotificationLog;
use bc\models\NotificationTemplate;
use bc\models\NotificationLogFirebaseDetail;

class BCNotification {

    public $bc_model;
    public $app_user_model;
    public $notification_log_model;
    public $template_model;
    public $template_id;
    public $message_title;
    public $message;
    public $fire_base_detail_model;

    const SHORT_LIST_1 = 1;
    const STAND_BY_2 = 2;
    const APP_UPDATE_3 = 3;
    const APP_UPDATE_SHORT_4 = 4;
    const SHORT_lIST_INFO_5 = 5;
    const SHORT_lIST_BC_BATCH_FORMING_6 = 6;
    const CERTIFIED_BANK_DETAIL_INFO_7 = 7;
    const OWN_MOBILE_NO_INFO_8 = 8;
    const BC_APP_UPDATE_INFO_9 = 9;
    const BANK_DETAIL_INFO_10 = 10;
    const PAN_CARD_INFO_11 = 11;
    const PAN_CARD_UPLOAD_12 = 12;
    const CORONA_INFO_13 = 13;
    const CALL_CENTER_INFO_14 = 14;
    const RETURN_BANK_INFO_15 = 15;
    const POLICE_VERIFICATION_INFO_16 = 16;
    const ONBOARDING_PROCESS_INFO_17 = 17;
    const PAYMENT_OF_BC_SUPPORT_INFO_18 = 18;
    const MISSING_PHOTO_19 = 19;
    public function __construct($bc_model) {
        $this->bc_model = $bc_model;
        $this->app_user_model = $this->bc_model->user;
    }

    public function Send($template_id) {

        try {
            $this->template_id = $template_id;
            $this->template_model = NotificationTemplate::findOne($this->template_id);
            $this->message_title = $this->template_model->name;
            switch ($this->template_id) {
                case BCNotification::SHORT_LIST_1:
                    $this->message = $this->template_model->template;
                    break;
                case BCNotification::STAND_BY_2:
                    $this->message = $this->template_model->template;
                    break;
                case BCNotification::APP_UPDATE_3:
                    $this->message = $this->template_model->template;
                    break;
                case BCNotification::APP_UPDATE_SHORT_4:
                    $this->message = $this->template_model->template;
                    break;
                case BCNotification::SHORT_lIST_INFO_5:
                    $this->message = sprintf($this->template_model->template, $this->bc_model->gram_panchayat_name, $this->bc_model->block_name, $this->bc_model->district_name);
                    break;
                case BCNotification::SHORT_lIST_BC_BATCH_FORMING_6:
                  break;  
                case BCNotification::CERTIFIED_BANK_DETAIL_INFO_7:
                    $this->message = $this->template_model->template;
                    break;
                case BCNotification::OWN_MOBILE_NO_INFO_8:
                    $this->message = $this->template_model->template;
                    break;
                case BCNotification::BC_APP_UPDATE_INFO_9:
                    $this->message = $this->template_model->template;
                    break;
                case BCNotification::BANK_DETAIL_INFO_10:
                    $this->message = $this->template_model->template;
                    break;
                case BCNotification::PAN_CARD_INFO_11:
                    $this->message = $this->template_model->template;
                    break;
                case BCNotification::PAN_CARD_UPLOAD_12:
                    $this->message = $this->template_model->template;
                    break;
                case BCNotification::CORONA_INFO_13:
                    $this->message = $this->template_model->template;
                    break;
                case BCNotification::CALL_CENTER_INFO_14:
                    $this->message = $this->template_model->template;
                    break;
                case BCNotification::RETURN_BANK_INFO_15:
                    $html = '';
                    if ($this->bc_model->bc_bank == '3' or $this->bc_model->shg_bank = '3') {
                        if ($this->bc_model->bc_bank == '3') {
                            $html .= 'बी0सी0 सखी बैंक विवरण वापसी का कारण.';
                            $html .= $this->bc_model->bcbankrjregion;
                        }

                        if ($this->bc_model->shg_bank == '3') {
                            $html .= 'बी0सी0 सखी का स्वयं सहायता समूह बैंक विवरण वापसी का कारण.';
                            $html .= $this->bc_model->bcshgbankrjregion;
                        }
                        $this->message = strip_tags($html);
                    }
                    break;
                case BCNotification::POLICE_VERIFICATION_INFO_16:
                    $this->message = $this->template_model->template;
                    break;
                case BCNotification::ONBOARDING_PROCESS_INFO_17:
                    $this->message = $this->template_model->template;
                    break;
                case BCNotification::PAYMENT_OF_BC_SUPPORT_INFO_18:
                    $this->message = $this->template_model->template;
                    break;
                case BCNotification::MISSING_PHOTO_19:
                    $this->message = $this->template_model->template;
                    break;
            }
           
            if ($this->message and $this->bc_model->blocked == '0') {
                $this->notification_log_model = new NotificationLog();
                $this->notification_log_model->notification_type = NotificationLog::NOTIFICATION_TYPE_BC_APPLICATION_SELECTION;
                $this->notification_log_model->notification_sub_type = NotificationLog::NOTIFICATION_SUB_TYPE_BC_APPLICATION_SELECTION_ACKNOLEDGE;
                $this->notification_log_model->detail_id = $this->template_model->id;
                $this->notification_log_model->user_id = $this->bc_model->user->id;
                $this->notification_log_model->app_id = $this->bc_model->user->srlm_bc_selection_app_detail_id;
                $this->notification_log_model->visible = $this->template_model->visible;
                $this->notification_log_model->acknowledge = $this->template_model->acknowledge;
                $this->notification_log_model->message_title = $this->message_title;
                $this->notification_log_model->message = $this->message;
                $this->notification_log_model->cron_status = 0;
                $this->notification_log_model->status = 0;
                
                if ($this->notification_log_model->save()) {
                     
                    $notification = \bc\models\NotificationLog::findOne($this->notification_log_model->id);
                    $firbase_tocken = $notification->bcuser->firebase_token;
                    //$firbase_tocken='cDLhRI6_QeaClFAN38HH7T:APA91bGVHPs2dVYJeb9KDl6NDh0yzLvpM5m66pe7nEgtNMLZEZRLlNWWLWw8ovU_gzaAxE4KsROD-r3JspQwSlkQzvj7FA-wQ_0C3XG6-15AVNKFjBCM3bVw2BdItBTeG31k13pU01xm';
                    $firebase = new \bc\components\GoogleFirebase($notification);
                    $response = $firebase->send($firbase_tocken);
                    $response_result = json_decode($response);
                    $notification->cron_status = '1';
                    $notification->status = '1';
                    $notification->send_count = ($notification->send_count + 1);
                    $notification_model_detail = new NotificationLogFirebaseDetail();
                    $notification_model_detail->notification_log_id = $notification->id;
                    if ($response_result == null) {
                        $notification->status = 3;
                        $notification_model_detail->firebase_message = "No Token";
                    } else {
                        if ($response_result->success) {
                            $notification->status = 2;
                            $notification->send_datetime = new \yii\db\Expression('NOW()');
                            $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
                        } else {
                            $notification->status = 4;
                            $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
                        }
                    }
                    $notification_model_detail->save();
                    $notification->update();
                    $viewtemp = 'viewtemp' . $this->template_model->id;
                    if (isset($this->bc_model->$viewtemp) and $this->bc_model->$viewtemp == '0') {
                        $this->bc_model->$viewtemp = 1;
                        $this->bc_model->update();
                    }
                }
            }
        } catch (\Exception $e) {
            //print_r($e->getMessage());exit;
        }
    }

}
