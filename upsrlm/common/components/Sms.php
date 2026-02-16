<?php

namespace common\components;

use Yii;
use common\models\dynamicdb\cbo_detail\RishtaShgMemberAppPin;

/**
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class Sms {

    public $user_id = 0;
    public $mobile_number;

    public function Sendcstapplink($mobile_number) {
        try {
            $cts = RishtaShgMemberAppPin::findOne(['mobile_no' => $mobile_number]);
            if ($cts != null) {
                $this->mobile_number = $cts->mobile_no;
                $this->user_id = 0;
            }
            $user_model = \common\models\User::findOne(['username' => $mobile_number]);
            if ($user_model != null) {
                $this->mobile_number = $user_model->username;
                $this->user_id = $user_model->id;
            }
            // if ($cts != null) {
            if ($this->mobile_number != '') {
                $sms_serve = new \common\components\sms\Smssarv();
                $sms_log_model = new \common\models\rishta\RishtaSmsLog();
                $sms_log_model->user_id = $this->user_id;
                $sms_log_model->mobile_number = $this->mobile_number;
                $sms_log_model->rishta_sms_template_id = \common\components\sms\Smssarv::RISHTA_APP_LINK_TEMPLATE_ID;
                $sms_log_model->model = json_encode(['mobile_number' => $sms_log_model->mobile_number, 'm' => $sms_log_model->mobile_number, 'template_id' => \common\components\sms\Smssarv::TEMPLATE_ID_LINK]);
                $sms_log_model->sms_content = $sms_serve::sms_content(['m' => $sms_log_model->mobile_number], \common\components\sms\Smssarv::RISHTA_APP_LINK_TEMPLATE_ID);
                $sms_log_model->sms_length = strlen($sms_log_model->sms_content);
                if ($cts != null) {
                    $cts->app_sms_status = RishtaShgMemberAppPin::APP_SMS_STATUS_LOG;
                }
                if ($sms_log_model->save()) {
                    $sms_serve->options = ['template_id' => \common\components\sms\Smssarv::TEMPLATE_ID_LINK, 'template' => $sms_log_model->sms_content, 'contact_numbers' => $sms_log_model->mobile_number];
                    $sms_serve->enableSendSms = \Yii::$app->params['sarv_sms_enable'];
                    if ($sms_serve->enableSendSms) {
                        $log = $sms_serve->SendSMS();
                        if (isset($log) and !empty($log)) {
                            $sms_log_model->sms_send_time = new \yii\db\Expression('NOW()');
                            $sms_log_model->status = 1;
                            if ($cts != null) {
                                if ($cts->app_sms_status != 3) {
                                    $cts->app_sms_status = RishtaShgMemberAppPin::APP_SMS_STATUS_SEND;
                                    $cts->app_sms_time = new \yii\db\Expression('NOW()');
                                    $cts->save();
                                }
                            }
                            if (isset($log['msg'])) {
                                if ($log['msg'] == 'success') {
                                    $sms_log_model->status = 1;
                                    if (isset($log['data'][0]['campaign_id'])) {
                                        $sms_log_model->sms_provider_campaign_id = $log['data'][0]['campaign_id'];
                                    }
                                    if (isset($log['data'][0]['message_id'])) {
                                        $sms_log_model->sms_provider_message_id = $log['data'][0]['message_id'];
                                    }
                                }
                                if ($log['msg'] == 'error') {
                                    $sms_log_model->status = 2;
                                }
                                $sms_log_model->sms_provider_msg = $log['msg'];
                                $sms_log_model->sms_provider_code = $log['code'];
                                $sms_log_model->sms_provider_msg_text = $log['msg_text'];
                            }
                            $sms_log_model->save();
                        }
                        return $sms_log_model;
                    }
                }
            }
            // }
        } catch (\Exception $ex) {
            
        }
    }

    public function Sendpin($user_id) {
        try {
            $user_model = \common\models\User::findOne($user_id);
            $sms_serve = new \common\components\sms\Smssarv();
            $sms_log_model = new \common\models\rishta\RishtaSmsLog();
            $sms_log_model->user_id = $user_model->id;
            $sms_log_model->mobile_number = $user_model->username;
            $sms_log_model->rishta_sms_template_id = \common\components\sms\Smssarv::RISHTA_PIN_TEMPLATE_ID;
            $sms_log_model->model = json_encode(['mobile_number' => $user_model->username, 'pin' => $user_model->otp_value, 'template_id' => \common\components\sms\Smssarv::TEMPLATE_ID_PIN]);
            $sms_log_model->sms_content = $sms_serve::sms_content(['pin' => $user_model->otp_value], \common\components\sms\Smssarv::RISHTA_PIN_TEMPLATE_ID);
            $sms_log_model->sms_length = strlen($sms_log_model->sms_content);
            if ($sms_log_model->save()) {
//                $user_model->username='7838275272';
                $sms_serve->options = ['template_id' => \common\components\sms\Smssarv::TEMPLATE_ID_PIN, 'template' => $sms_log_model->sms_content, 'contact_numbers' => $user_model->username];
                $sms_serve->enableSendSms = \Yii::$app->params['sarv_sms_enable'];
                if ($sms_serve->enableSendSms) {
                    $log = $sms_serve->SendSMS();
                    if (isset($log) and !empty($log)) {
                        $sms_log_model->sms_send_time = new \yii\db\Expression('NOW()');
                        $sms_log_model->status = 1;
                        if (isset($log['msg'])) {
                            if ($log['msg'] == 'success') {
                                $sms_log_model->status = 1;
                                if (isset($log['data'][0]['campaign_id'])) {
                                    $sms_log_model->sms_provider_campaign_id = $log['data'][0]['campaign_id'];
                                }
                                if (isset($log['data'][0]['message_id'])) {
                                    $sms_log_model->sms_provider_message_id = $log['data'][0]['message_id'];
                                }
                            }
                            if ($log['msg'] == 'error') {
                                $sms_log_model->status = 2;
                            }
                            $sms_log_model->sms_provider_msg = $log['msg'];
                            $sms_log_model->sms_provider_code = $log['code'];
                            $sms_log_model->sms_provider_msg_text = $log['msg_text'];
                        }
                        $sms_log_model->save();
                    }
                }
                $this->resetmenu($user_model);
            }
            return $user_model;
        } catch (\Exception $ex) {
            
        }
    }

    public function resetmenu($user_model) {
        $user_model = \common\models\User::findOne($user_model->id);
        if ($user_model->role == 100) {
            $rista = new \sakhi\components\Rishta($user_model);
            $user_model->user_app_data_update = 1;
            $user_model->menu_version_major = \common\models\base\GenralModel::MENU_MAJOR_VERSION;
            $user_model->menu_version_minor = ($user_model->menu_version_minor + 1);
            $user_model->menu_version = ($user_model->menu_version_major + ('.' . $user_model->menu_version_minor));
            $user_model->splash_screen = $rista->splash_screen($user_model);
            $user_model->last_menu_updatetime = date("Y-m-d h:i:s");
            $user_model->save();
            $rishta_user_data_model = \common\models\rishta\RishtaUserData::findOne(['user_id' => $user_model->id]);
            if ($rishta_user_data_model == null) {
                $rishta_user_data_model = new \common\models\rishta\RishtaUserData();
            }
            $rishta_user_data_model->user_id = $user_model->id;
            $rishta_user_data_model->menu_json = json_encode($rista->rishta_menu());
            $rishta_user_data_model->splash_screen_value = $rista->splash_screen_value($user_model);
            if ($rishta_user_data_model->save()) {
                
            }
        }

        return $user_model;
    }

    public function Sendmopuppin($user_id) {
        try {
            $user_model = \common\models\User::findOne($user_id);
            if (in_array($user_model->role, [41, 42, 43, 44, 45, 46, 47, 100])) {
//                $sms_serve = new \common\components\sms\Smssarv();
//                $sms_log_model = new \common\models\dynamicdb\mopup\MopupSmsLog();
//                $sms_log_model->name = $user_model->name;
//                $sms_log_model->user_id = $user_model->id;
//                $sms_log_model->mobile_number = $user_model->username;
//                $sms_log_model->sms_template_id = \common\components\sms\Smssarv::MOPUP_PIN_TEMPLATE_ID;
//                $sms_log_model->template_id = (string) \common\components\sms\Smssarv::SARV_TEMPLATE_ID_PIN_MOP_UP;
//                $sms_log_model->model = json_encode(['mobile_number' => $user_model->username, 'pin' => $user_model->otp_value, 'template_id' => \common\components\sms\Smssarv::SARV_TEMPLATE_ID_PIN_MOP_UP]);
//                $sms_log_model->sms_content = $sms_serve::sms_content(['pin' => $user_model->otp_value], \common\components\sms\Smssarv::MOPUP_PIN_TEMPLATE_ID);
//                $sms_log_model->sms_length = strlen($sms_log_model->sms_content);
//                if ($sms_log_model->save()) {
////                $user_model->username='7838275272';
//                    $sms_serve->options = ['sender_id' => 'TLINFO', 'template_id' => \common\components\sms\Smssarv::SARV_TEMPLATE_ID_PIN_MOP_UP, 'template' => $sms_log_model->sms_content, 'contact_numbers' => $user_model->username];
//                    $sms_serve->enableSendSms = \Yii::$app->params['sarv_sms_enable'];
//                    if ($sms_serve->enableSendSms) {
//                        $log = $sms_serve->SendSMS();
//                        if (isset($log) and !empty($log)) {
//                            $sms_log_model->sms_send_time = new \yii\db\Expression('NOW()');
//                            $sms_log_model->status = 1;
//                            if (isset($log['msg'])) {
//                                if ($log['msg'] == 'success') {
//                                    $sms_log_model->status = 1;
//                                    if (isset($log['data'][0]['campaign_id'])) {
//                                        $sms_log_model->sms_provider_campaign_id = $log['data'][0]['campaign_id'];
//                                    }
//                                    if (isset($log['data'][0]['message_id'])) {
//                                        $sms_log_model->sms_provider_message_id = $log['data'][0]['message_id'];
//                                    }
//                                }
//                                if ($log['msg'] == 'error') {
//                                    $sms_log_model->status = 2;
//                                }
//                                $sms_log_model->sms_provider_msg = $log['msg'];
//                                $sms_log_model->sms_provider_code = $log['code'];
//                                $sms_log_model->sms_provider_msg_text = $log['msg_text'];
//                            }
//                            $sms_log_model->save();
//                        }
//                    }
//                } else {
////                print_r($sms_log_model->getErrors());
//                }
            }
            return $user_model;
        } catch (\Exception $ex) {
//            print_r($ex->getMessage());
        }
    }

    public function Sendmopuplinkpin($user_id) {
        try {
            $user_model = \common\models\User::findOne($user_id);
            $sms_serve = new \common\components\sms\Smssarv();
            $sms_log_model = \common\models\dynamicdb\mopup\MopupSmsLog::find()->where(['user_id' => $user_id])->all();
//            if ($sms_log_model == null) {
//                //echo "dd".$user_model->username;
//                $sms_log_model = new \common\models\dynamicdb\mopup\MopupSmsLog();
//                $sms_log_model->name = $user_model->name;
//                $sms_log_model->user_id = $user_model->id;
//                $sms_log_model->mobile_number = $user_model->username;
//                $sms_log_model->sms_template_id = \common\components\sms\Smssarv::MOPUP_APP_PIN_TEMPLATE_ID;
//                $sms_log_model->template_id = (string) \common\components\sms\Smssarv::SARV_TEMPLATE_ID_LINK_PIN_MOP_UP;
//                $sms_log_model->model = json_encode(['link' => \Yii::$app->params['mopup_app_link'], 'mobile_number' => $user_model->username, 'pin' => $user_model->otp_value, 'template_id' => \common\components\sms\Smssarv::SARV_TEMPLATE_ID_LINK_PIN_MOP_UP]);
//                $sms_log_model->sms_content = $sms_serve::sms_content(['link' => \Yii::$app->params['mopup_app_link'], 'pin' => $user_model->otp_value], \common\components\sms\Smssarv::MOPUP_APP_PIN_TEMPLATE_ID);
//                $sms_log_model->sms_length = strlen($sms_log_model->sms_content);
//                if ($sms_log_model->save()) {
//                    //$user_model->username='7838275272';
//                    $sms_serve->options = ['sender_id' => 'TLINFO', 'template_id' => \common\components\sms\Smssarv::SARV_TEMPLATE_ID_LINK_PIN_MOP_UP, 'template' => $sms_log_model->sms_content, 'contact_numbers' => $user_model->username];
//                    $sms_serve->enableSendSms = \Yii::$app->params['sarv_sms_enable'];
//                    if ($sms_serve->enableSendSms) {
//                        $log = $sms_serve->SendSMS();
//                        if (isset($log) and !empty($log)) {
//                            $sms_log_model->sms_send_time = new \yii\db\Expression('NOW()');
//                            $sms_log_model->status = 1;
//                            if (isset($log['msg'])) {
//                                if ($log['msg'] == 'success') {
//                                    $sms_log_model->status = 1;
//                                    if (isset($log['data'][0]['campaign_id'])) {
//                                        $sms_log_model->sms_provider_campaign_id = $log['data'][0]['campaign_id'];
//                                    }
//                                    if (isset($log['data'][0]['message_id'])) {
//                                        $sms_log_model->sms_provider_message_id = $log['data'][0]['message_id'];
//                                    }
//                                }
//                                if ($log['msg'] == 'error') {
//                                    $sms_log_model->status = 2;
//                                }
//                                $sms_log_model->sms_provider_msg = $log['msg'];
//                                $sms_log_model->sms_provider_code = $log['code'];
//                                $sms_log_model->sms_provider_msg_text = $log['msg_text'];
//                            }
//                            $sms_log_model->save();
//                        }
//                    }
//                }
//            } else {
////                echo "already sent" . $user_model->username;
//            }
            return $user_model;
        } catch (\Exception $ex) {
            
        }
    }
}
