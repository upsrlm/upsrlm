<?php

namespace api\modules\bcselection\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\db\Expression;
use yii\web\Controller;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcSelectionApiLog as ApiLog;
use bc\modules\selection\models\SrlmBcSelectionAppDetail as AppDetail;
use bc\modules\selection\models\SrlmBcSelectionUser as AppUser;
use bc\modules\selection\models\form\UploadPhotoForm;
use common\components\sms\Smslane;
use bc\models\srlm\SmsLog;
use common\models\ApplicationConfig;
use bc\models\NotificationTemplate;
use bc\models\NotificationLog;
use bc\models\NotificationLogFirebaseDetail;
use common\helpers\Utility;
use bc\modules\corona\models\form\CoronaFeedbackForm;
use bc\models\PartnerAssociates;
use bc\components\BCNotification;

/**
 * User controller for the `api` module
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class UserController extends Controller {

    protected $finder;
    private $custom_response = [];
    private $post_json;
    private $data_json;
    public $app_id;
    public $imei_no;
    public $current_module;
    public $user_message = '';
    public $options = [];
    public $fix_otp = "000000";
    public $test_user_mobile = ['8279901198', '9716026121', '9953326121', '8800579215', '9260985122', '8000000001', '8000000002', '8000000003', '8000000004', '7060780262', '9120377431', '9650901148', '9454205990', '9598830000', '9891175910', '9582119970', '9760363335', '7451934797'];
    public $gp_not_exist_message = "Your Gram Panchayat application is closed no more application of your Gram Panchayat ";

    public function beforeAction($event) {
        $this->current_module = \Yii::$app->controller->module;
        $this->post_json = $this->current_module->post_json;
        $this->data_json = $this->current_module->data_json;
        $this->custom_response['status'] = "1";
        $this->custom_response['message'] = "Success";
        $this->custom_response['login_pin_message']='डिजिटल निजता एवं सुरक्षा के दृष्टिगत, 
www.upsrlm.org पोर्टल के द्वारा बीसी सखी मोबाइल ऐप के पासवर्ड स्वतः बदलने का समय हो गया है । BC सखी ऐप के ब्लॉक हो जाने के स्थिति में आप का पिन नम्बर स्वतः सृजित हो जाएगा, जिसे आप "रिश्ता कॉल सेंटर" (फ़ोन नम्बर <a href=tel:9070804050>9070804050</a> , सुबह 7 बजे से शाम 7 बजे के बीच) पर फ़ोन कर अपना PIN नम्बर प्राप्त कर लें । PIN नम्बर मोबाइल ऐप पर डालने से बीसी सखी ऐप पुनः सक्रिय हो जाएगा ।';
        $this->custom_response['bank_account_message']='कम्पनी का संस्थागत पूल अकाउंट जिसमें हैंड्हेल्ड मशीन के लिए भुगतान किया जाना प्रस्तावित है:----
कृपया कैश भुगतान बिलकुल ना करें । शासनादेश में उधृत की गयी मशीन एवं निर्धारित रकम ही भुगतान करें । किसी भी सम्बंधित जानकारी के लिए में रिश्ता कॉल सेंटर : <a href="tel:9070804050">9070804050</a> में कॉल करें ।';
        return parent::beforeAction($event);
    }

    public function actionLogin() {

        $app_user = AppUser::findOne(['mobile_no' => $this->data_json['mobile_no']]);
        if (!empty($app_user)) {
            AppDetail::updateAll(['date_of_uninstall' => new Expression('NOW()'), 'status' => 0], 'srlm_bc_selection_user_id ="' . $app_user->id . '" and status=' . '1');
        } else {
            $app_user = new AppUser();
            $app_user->mobile_no = $this->data_json['mobile_no'];
            $app_user->orig_otp_mobile_no = $this->data_json['mobile_no'];
            $app_user->phase = 7;
            $app_user->pin = mt_rand(1000, 9999);
            $app_user->save(false);
        }

        $app_register = new AppDetail();
        $app_register->srlm_bc_selection_user_id = $app_user->id;
        $app_register->imei_no = $this->data_json['imei_no'];
        $app_register->os_type = $this->data_json['os_type'];
        $app_register->manufacturer_name = $this->data_json['manufacturer_name'];
        $app_register->os_version = $this->data_json['os_version'];
        $app_register->app_version = $this->data_json['app_version'];
        $app_register->firebase_token = $this->data_json['firebase_token'];
        $app_register->date_of_install = new Expression('NOW()');
        $app_register->save(false);
        $app_user->firebase_token = $app_register->firebase_token;
        $app_user->srlm_bc_selection_app_detail_id = $app_register->id;
        $app_user->save(false);
        $this->custom_response['data']['user_id'] = $app_user->id;
        $this->custom_response['data']['app_id'] = $app_user->srlm_bc_selection_app_detail_id;
        if ($app_user->form_uuid != "" && $app_user->form_uuid != NULL)
            $this->custom_response['data']['form_uuid'] = $app_user->form_uuid;
        if ($app_user->form_json != "" && $app_user->form_json != NULL)
            $this->custom_response['data']['form_json'] = $app_user->form_json;

        $this->custom_response['data']['Gp_version'] = $this->gpversion();
        $this->custom_response['data']['Bc_status'] = $this->bcstatus($app_user);
        $this->custom_response['data']['user_message'] = $this->getusermessage($app_user);
        $this->custom_response['support_text'] = 'किसी भी सम्बंधित जानकारी के लिए में रिश्ता कॉल सेंटर : <a href="tel:9070804050">9070804050</a> में कॉल करें।';

//        if (isset($app_user->bcsapplication)) {
//            if ($app_user->bcsapplication->corona_feedback == 0) {
//                $this->custom_response['data']['corona_feedback'] = 1;
//            }
//        }

        $this->custom_response['data']['notification_list'] = $this->getNotification($app_user);
        $this->sendnotification($app_user);
        $response = \Yii::$app->response;
        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    public function sendnotification($app_user) {
        if (isset($app_user->bcsapplication)) {
            $model = $app_user->bcsapplication;
            if ($model->form_number == 6 and $model->gender == 2 and $model->blocked == '0') {
                if ($model->bc_photo_status == '0') {
                    $bc_noti = new BCNotification($model);
//                    $bc_noti->Send(BCNotification::MISSING_PHOTO_19);
                }

                if ($model->status == SrlmBcApplication::STATUS_RECIEVED and $model->viewtemp2 != 2) {
                    $bc_noti = new BCNotification($model);
                    $bc_noti->Send(BCNotification::STAND_BY_2);
                }
                if ($model->status == SrlmBcApplication::STATUS_PROVISIONAL) {

                    if ($model->training_status == SrlmBcApplication::TRAINING_STATUS_DEFAULT and $model->viewtemp5 != 2) {
                        $bc_noti = new BCNotification($model);
                        $bc_noti->Send(BCNotification::SHORT_lIST_INFO_5);
                    }
                    if ($model->training_status == SrlmBcApplication::TRAINING_STATUS_PASS) {
                        $bc_noti = new BCNotification($model);
                        $bc_noti->Send(BCNotification::CALL_CENTER_INFO_14);
                        if ($model->viewtemp7 != 2 and $model->bc_bank != 2 and $model->shg_bank != 2) {
                            $bc_noti = new BCNotification($model);
                            $bc_noti->Send(BCNotification::CERTIFIED_BANK_DETAIL_INFO_7);
                        }
                        if ($model->pvr_status == 1 and $model->onboarding == '0') {
                            $bc_noti = new BCNotification($model);
                            $bc_noti->Send(BCNotification::POLICE_VERIFICATION_INFO_16);
                        }
                        if ($model->bc_bank == 3 or $model->shg_bank == 3) {
                            $bc_noti = new BCNotification($model);
                            $bc_noti->Send(BCNotification::RETURN_BANK_INFO_15);
                        }
                        if ($model->bc_shg_funds_status == '1' and $model->bc_support_funds_received == null) {
                            $bc_noti = new BCNotification($model);
                            $bc_noti->Send(BCNotification::PAYMENT_OF_BC_SUPPORT_INFO_18);
                        }
                        if ($model->pan_card_status == '1' and $model->pan_photo_upload == '0') {
                            $bc_noti = new BCNotification($model);
                            $bc_noti->Send(BCNotification::PAN_CARD_UPLOAD_12);
                        }
                        if ($model->onboarding == '1') {
                            $bc_noti = new BCNotification($model);
                            $bc_noti->Send(BCNotification::ONBOARDING_PROCESS_INFO_17);
                        }
                    }
                }
            }
        }
    }

    public function sendnotificationold($app_user) {
        if (isset($app_user->bcsapplication)) {
            $model = $app_user->bcsapplication;
            if ($model->form_number == 6 and $model->status == SrlmBcApplication::STATUS_PROVISIONAL and $model->viewtemp5 != 2 and in_array($model->training_status, [0])) {
                $template_model = \bc\models\NotificationTemplate::findOne(\bc\models\NotificationTemplate::PRESELECTED_ACKNOLEDGE_TELE_INFO_TEMPLATE_ID);
                $noti_log_model = new NotificationLog();
                $noti_log_model->notification_type = NotificationLog::NOTIFICATION_TYPE_BC_APPLICATION_SELECTION;
                $noti_log_model->notification_sub_type = NotificationLog::NOTIFICATION_SUB_TYPE_BC_APPLICATION_SELECTION_ACKNOLEDGE;
                $noti_log_model->detail_id = $template_model->id;
                $noti_log_model->user_id = $model->user->id;
                $noti_log_model->app_id = $model->user->srlm_bc_selection_app_detail_id;
                $noti_log_model->visible = $template_model->visible;
                $noti_log_model->acknowledge = $template_model->acknowledge;
                $noti_log_model->message_title = $template_model->name;
                $noti_log_model->message = sprintf($template_model->template, $model->gram_panchayat_name, $model->block_name, $model->district_name);
                $noti_log_model->cron_status = 0;
                $noti_log_model->status = 0;
                if ($noti_log_model->save()) {
                    try {
                        $notification = \bc\models\NotificationLog::findOne($noti_log_model->id);
                        $firbase_tocken = $notification->bcuser->firebase_token;
                        //$firbase_tocken = 'eyJyuB6DShm6gAxeyoy1Ve:APA91bE0fPMIRq-C3WTMHB1tBcCc1xuR8zsShq85IpV3u29JzbN9y3aql6c5vFJ_KwPYOm5DqJmnXuWGcGtcF6Z4teu7ta83-X7WpHgwhJA_4tqA5GTl4HEk-7dhG4vFyneZtLqoR-VR';
                        $firebase = new \bc\components\GoogleFirebase($notification);
                        $response = $firebase->send($firbase_tocken);

                        $response_result = json_decode($response);
                        $notification->cron_status = '1';
                        $notification->send_count = ($notification->send_count + 1);
                        $notification->status = 1;
                        $notification->send_datetime = new \yii\db\Expression('NOW()');
                        $notification_model_detail = new NotificationLogFirebaseDetail();
                        $notification_model_detail->notification_log_id = $notification->id;
                        if ($response_result == null) {
                            $notification->status = 3;
                            $notification_model_detail->firebase_message = "No Token";
                        } else {
                            if ($response_result->success) {
                                $notification->status = 2;
                                $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
                            } else {
                                $notification->status = 4;
                                $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
                            }
                        }
                        $notification_model_detail->save();
                        $notification->update();
                        if ($model->viewtemp5 != 2) {
                            $model->viewtemp5 = 1;
                            $model->update();
                        }
                    } catch (\Exception $ex) {
                        
                    }
                }
            }
            if ($model->form_number == 6 and $model->gender == 2 and $model->status == 1 and $model->viewtemp2 != 2) {
                $template_model = \bc\models\NotificationTemplate::findOne(\bc\models\NotificationTemplate::STANDBY_ACKNOLEDGE_TEMPLATE_ID);
                $noti_log_model = new NotificationLog();
                $noti_log_model->notification_type = NotificationLog::NOTIFICATION_TYPE_BC_APPLICATION_SELECTION;
                $noti_log_model->notification_sub_type = NotificationLog::NOTIFICATION_SUB_TYPE_BC_APPLICATION_SELECTION_ACKNOLEDGE;
                $noti_log_model->detail_id = $template_model->id;
                $noti_log_model->user_id = $model->user->id;
                $noti_log_model->app_id = $model->user->srlm_bc_selection_app_detail_id;
                $noti_log_model->visible = $template_model->visible;
                $noti_log_model->acknowledge = $template_model->acknowledge;
                $noti_log_model->message_title = $template_model->name;
                $noti_log_model->message = $template_model->template;
                $noti_log_model->cron_status = 0;
                $noti_log_model->status = 0;
                if ($noti_log_model->save()) {
                    try {
                        $notification = \bc\models\NotificationLog::findOne($noti_log_model->id);
                        $firbase_tocken = $notification->bcuser->firebase_token;
                        //$firbase_tocken = 'eyJyuB6DShm6gAxeyoy1Ve:APA91bE0fPMIRq-C3WTMHB1tBcCc1xuR8zsShq85IpV3u29JzbN9y3aql6c5vFJ_KwPYOm5DqJmnXuWGcGtcF6Z4teu7ta83-X7WpHgwhJA_4tqA5GTl4HEk-7dhG4vFyneZtLqoR-VR';
                        $firebase = new \bc\components\GoogleFirebase($notification);
                        $response = $firebase->send($firbase_tocken);

                        $response_result = json_decode($response);
                        $notification->cron_status = '1';
                        $notification->send_count = ($notification->send_count + 1);
                        $notification->status = 1;
                        $notification->send_datetime = new \yii\db\Expression('NOW()');
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
                        if ($model->viewtemp2 != 2) {
                            $model->viewtemp2 = 1;
                            $model->update();
                        }
                    } catch (\Exception $ex) {
                        
                    }
                }
            }
            // certified bc send notifiction

            if ($model->form_number == 6 and $model->gender == 2 and $model->status == 2 and $model->viewtemp7 != 2) {
                $resethi_bc = \bc\modules\training\models\RsetisBatchParticipants::findOne(['bc_application_id' => $model->id]);
                $send = false;
                if ($model->bc_bank == 0 and $model->shg_bank == 0) {
                    $send = true;
                }
                if (isset($resethi_bc) and in_array($resethi_bc->training_status, [3, 7]) and $send) {
                    $template_model = \bc\models\NotificationTemplate::findOne(\bc\models\NotificationTemplate::CERTIFIED_BC_BANK_ACCOUNT_TEMPLATE_ID);
                    $noti_log_model = new NotificationLog();
                    $noti_log_model->notification_type = NotificationLog::NOTIFICATION_TYPE_BC_APPLICATION_SELECTION;
                    $noti_log_model->notification_sub_type = NotificationLog::NOTIFICATION_SUB_TYPE_BC_APPLICATION_SELECTION_ACKNOLEDGE;
                    $noti_log_model->detail_id = $template_model->id;
                    $noti_log_model->user_id = $model->user->id;
                    $noti_log_model->app_id = $model->user->srlm_bc_selection_app_detail_id;
                    $noti_log_model->visible = $template_model->visible;
                    $noti_log_model->acknowledge = $template_model->acknowledge;
                    $noti_log_model->message_title = $template_model->name;
                    $noti_log_model->message = $template_model->template;
                    $noti_log_model->cron_status = 0;
                    $noti_log_model->status = 0;
                    if ($noti_log_model->save()) {
                        try {
                            $notification = \bc\models\NotificationLog::findOne($noti_log_model->id);
                            $firbase_tocken = $notification->bcuser->firebase_token;
                            //$firbase_tocken = 'eyJyuB6DShm6gAxeyoy1Ve:APA91bE0fPMIRq-C3WTMHB1tBcCc1xuR8zsShq85IpV3u29JzbN9y3aql6c5vFJ_KwPYOm5DqJmnXuWGcGtcF6Z4teu7ta83-X7WpHgwhJA_4tqA5GTl4HEk-7dhG4vFyneZtLqoR-VR';
                            $firebase = new \bc\components\GoogleFirebase($notification);
                            $response = $firebase->send($firbase_tocken);

                            $response_result = json_decode($response);
                            $notification->cron_status = '1';
                            $notification->send_count = ($notification->send_count + 1);
                            $notification->status = 1;
                            $notification->send_datetime = new \yii\db\Expression('NOW()');
                            $notification_model_detail = new NotificationLogFirebaseDetail();
                            $notification_model_detail->notification_log_id = $notification->id;
                            if ($response_result == null) {
                                $notification->status = 3;
                                $notification_model_detail->firebase_message = "No Token";
                            } else {
                                if ($response_result->success) {
                                    $notification->status = 2;

                                    $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
                                } else {
                                    $notification->status = 4;
                                    $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
                                }
                            }
                            $notification_model_detail->save();
                            $notification->update();
                            if ($model->viewtemp7 != 2) {
                                $model->viewtemp7 = 1;
                                $model->update();
                            }
                        } catch (\Exception $ex) {
                            
                        }
                    }
                }
            }
        }
    }

    public function gpversion() {
        $model = ApplicationConfig::findOne(ApplicationConfig::GP_VERSION_ID);
        return isset($model) ? $model->value : null;
    }

    public function bcstatus($model) {
        $bsstatus = 1;
        if (isset($model->bcsapplication)) {
            if ($model->bcsapplication->status == SrlmBcApplication::DELETE) {
                $bsstatus = 0;
            } elseif ($model->bcsapplication->status == SrlmBcApplication::STATUS_PROVISIONAL) {
                $bsstatus = 21;
            } else {
                if (isset($model) and ($model->form_number == SrlmBcApplication::FORM_STATUS_PART_4)) {
                    $bsstatus = 2;
                }
            }
        }
        return $bsstatus;
    }

    public function getusermessage($model) {
        $message = '';
        if (isset($model->bcsapplication)) {
            if ($model->bcsapplication->status == SrlmBcApplication::DELETE) {
                $message = 0;
            } elseif ($model->bcsapplication->status == SrlmBcApplication::STATUS_PROVISIONAL) {
                $message = 21;
            } else {
                if (isset($model) and ($model->form_number == SrlmBcApplication::FORM_STATUS_PART_4) and ($model->profile_photo and $model->aadhar_front_photo and $model->aadhar_back_photo)) {
                    $message = 'इस ऍप पर आपका आवेदन प्रक्रिया समाप्त हुआ I धन्यवाद I';
                }
                if (isset($model) and ($model->form_number == SrlmBcApplication::FORM_STATUS_PART_4) and ($model->profile_photo || $model->aadhar_front_photo || $model->aadhar_back_photo)) {
                    $message = 'कृपया प्रोफ़ाइल और आधार फोटो लापता फोटो अपलोड करें ';
                }
            }
        }
        return $message;
    }

    public function actionMobilepin() {
        try {
            $user_model = AppUser::findOne(['mobile_no' => $this->data_json['mobile_no'], 'pin' => $this->data_json['pin']]);
            if (isset($user_model)) {
                if (in_array($this->data_json['mobile_no'], $this->test_user_mobile)) {
                    
                } else {
                    if ($user_model->form_number == SrlmBcApplication::FORM_STATUS_PART_4) {
                        if (isset($user_model->bcsapplication) and $user_model->bcsapplication->blocked != 0) {
                            $this->custom_response['status'] = "0";
                            $this->custom_response['message'] = 'क्षमा करें, आपने गलत मोबाइल नंबर या पिन डाला है। पुनः प्रयास करें ';
                        }
//                        if (isset($user_model->bcsapplication)) {
//                            if ($user_model->bcsapplication->pin_used == '0') {
//                                $user_model->bcsapplication->pin_used = 1;
//                                $user_model->bcsapplication->update();
//                            }
//                        }
                    } else {
                        $this->custom_response['status'] = "0";
                        $this->custom_response['message'] = 'क्षमा करें, आपने गलत मोबाइल नंबर या पिन डाला है। पुनः प्रयास करें ';
                    }
                }
            } else {
                $this->custom_response['status'] = "0";
                $this->custom_response['message'] = 'क्षमा करें, आपने गलत मोबाइल नंबर या पिन डाला है। पुनः प्रयास करें ';
            }
        } catch (Exception $ex) {
            $this->custom_response['status'] = "0";
            $this->custom_response['message'] = 'Sorry, something went wrong there. Try again.';
        }
        $response = \Yii::$app->response;

        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    public function actionPhase() {
        try {
            $user_model = AppUser::findOne(['mobile_no' => $this->data_json['mobile_no']]);
            $this->custom_response['data']['Gp_version'] = $this->gpversion();
            $this->custom_response['data']['Bc_status'] = $this->bcstatus($user_model);
            $this->custom_response['data']['user_message'] = $this->getusermessage($user_model);
            if (in_array($this->data_json['mobile_no'], $this->test_user_mobile)) {
                $this->custom_response['data']['mobile_no'] = $this->data_json['mobile_no'];
                $this->custom_response['data']['time'] = date("Y-m-d h:i:s");
                $this->custom_response['data']['pin'] = 0;
            } else {
                if (isset($user_model)) {
                    if (in_array($user_model->phase, [1, 2, 3, 4, 5,6])) {
                        $this->custom_response['data']['pin'] = 1;
                    }
//                    if ($user_model->phase == 2) {
//                        $this->custom_response['data']['pin'] = 0;
//                        $sql = "SELECT *
//        FROM `sms_log`
//        WHERE   mobile_no=" . $this->data_json['mobile_no'] . ' order by sms_send_time desc LIMIT 1';
//                        $modle = SmsLog::findBySql($sql)->one();
//
////                        $expression = new Expression('NOW()');
////                        $now = (new \yii\db\Query)->select($expression)->scalar();
////                        $this->custom_response['data']['otp'] = $modle->otp;
////                        $this->custom_response['data']['mobile_no'] = $modle->mobile_no;
////                        $this->custom_response['data']['time'] = $now;
//                        $form_json = json_decode($user_model->form_json, true);
//                        if ((isset($form_json['gram_panchayat_code']) and $this->gp($form_json['gram_panchayat_code'])) or ($user_model->form_number == SrlmBcApplication::FORM_STATUS_PART_4)) {
//                            $otp_sms_log_model = new SmsLog();
//                            $otp_sms_log_model->mobile_no = $this->data_json['mobile_no'];
//                            $otp_sms_log_model->imei_no = $this->data_json['imei_no'];
//                            $otp_sms_log_model->os_type = $this->data_json['os_type'];
//                            $otp_sms_log_model->manufacturer_name = $this->data_json['manufacturer_name'];
//                            $otp_sms_log_model->os_version = $this->data_json['os_version'];
//                            $otp_sms_log_model->app_version = $this->data_json['app_version'];
//                            $otp_sms_log_model->firebase_token = isset($this->data_json['firebase_token']) ? $this->data_json['firebase_token'] : '';
//                            $otp_sms_log_model->time = new Expression('NOW()');
//                            if (!empty($modle)) {
//                                $otp_sms_log_model->otp = $modle->otp;
//                            } else {
//                                $otp_sms_log_model->otp = \common\helpers\Utility::generateNumericOTP(6);
//                            }
//                            $this->custom_response['data']['otp'] = $otp_sms_log_model->otp;
//                            $this->custom_response['data']['mobile_no'] = $otp_sms_log_model->mobile_no;
//                            $this->custom_response['data']['time'] = date("Y-m-d h:i:s");
//                            if ($otp_sms_log_model->save()) {
//                                $this->options['Message'] = \common\components\sms\Smslanev2::sms_content(['otp' => $otp_sms_log_model->otp], \common\components\sms\Smslanev2::TYPE_SMS_BC_OTP);
//                                $msisdn = '';
//                                if (strlen($otp_sms_log_model->mobile_no) == 10)
//                                    $msisdn = '91';
//                                $msisdn .= $otp_sms_log_model->mobile_no;
//                                $this->options['MobileNumbers'] = $msisdn;
//                                $sms_lane = new \common\components\sms\Smslanev2($this->options);
//                                $sms_lane->enableSendSms =0;// \Yii::$app->params['sms_lane_enable'];
//                                if ($sms_lane->enableSendSms) {
//                                    $sms = $sms_lane->SendSMS(\common\components\sms\Smslanev2::SENDAR_OTP);
//                                    // status 1 =>send -1 error
//                                    if (empty($sms)) {
//                                        $this->custom_response['data']['content'] = $sms;
//                                        $otp_sms_log_model->status = -1;
//                                        $otp_sms_log_model->message_id = $sms;
//                                    } else {
//                                        if ($sms['ErrorCode']) {
//                                            $otp_sms_log_model->status = -1;
//                                            if (isset($sms['Data'][0]['MessageId'])) {
//                                                $otp_sms_log_model->message_id = $sms['Data'][0]['MessageId'];
//                                            } else {
//                                                if (isset($sms['ErrorDescription'])) {
//                                                    $otp_sms_log_model->message_id = $sms['ErrorDescription'];
//                                                }
//                                            }
//                                        } else {
//                                            $otp_sms_log_model->status = 1;
//                                            if (isset($sms['Data'][0]['MessageId'])) {
//                                                $otp_sms_log_model->message_id = $sms['Data'][0]['MessageId'];
//                                            }
//                                        }
//
//                                        $otp_sms_log_model->sms_send_time = new Expression('NOW()');
//                                    }
//                                    if ($otp_sms_log_model->update()) {
//                                        
//                                    } else {
//                                        
//                                    }
//                                }
//                                $otp_sms_log_model = SmsLog::findOne($otp_sms_log_model->id);
////                                $this->custom_response['data']['otp'] = $otp_sms_log_model->otp;
////                                $this->custom_response['data']['mobile_no'] = $otp_sms_log_model->mobile_no;
////                                $this->custom_response['data']['time'] = $otp_sms_log_model->sms_send_time;
//                                $this->custom_response['status'] = "0";
//                                $this->custom_response['message'] = 'BC Sakhi Application is closed';
//                            } else {
//                                $this->custom_response['status'] = "0";
//                                $this->custom_response['message'] = "Error(s): {" . \common\helpers\Utility::convertModelErrorToString($otp_sms_log_model) . "}";
//                            }
//                        } else {
//                            $this->custom_response['status'] = "0";
//                            $this->custom_response['data']['otp'] = "000001";
//                            $this->custom_response['data']['mobile_no'] = $this->data_json['mobile_no'];
//                            $this->custom_response['data']['time'] = date("Y-m-d h:i:s");
//                            $this->custom_response['data']['user_message'] = $this->gp_not_exist_message;
//                        }
//                    }
                    elseif ($user_model->phase == 6) {
                        $this->custom_response['data']['pin'] = 0;
                        $sql = "SELECT *
        FROM `sms_log`
        WHERE   mobile_no=" . $this->data_json['mobile_no'] . ' order by sms_send_time desc LIMIT 1';
                        $modle = SmsLog::findBySql($sql)->one();

                        $expression = new Expression('NOW()');
                        $now = (new \yii\db\Query)->select($expression)->scalar();
                        $this->custom_response['data']['otp'] = $modle->otp;
                        $this->custom_response['data']['mobile_no'] = $modle->mobile_no;
                        $this->custom_response['data']['time'] = $now;

                        $otp_sms_log_model = new SmsLog();
                        $otp_sms_log_model->mobile_no = $this->data_json['mobile_no'];
                        $otp_sms_log_model->imei_no = $this->data_json['imei_no'];
                        $otp_sms_log_model->os_type = $this->data_json['os_type'];
                        $otp_sms_log_model->manufacturer_name = $this->data_json['manufacturer_name'];
                        $otp_sms_log_model->os_version = $this->data_json['os_version'];
                        $otp_sms_log_model->app_version = $this->data_json['app_version'];
                        $otp_sms_log_model->firebase_token = isset($this->data_json['firebase_token']) ? $this->data_json['firebase_token'] : '';
                        $otp_sms_log_model->time = new Expression('NOW()');
                        $otp_sms_log_model->sms_provider = 3;
                        if (!empty($modle)) {
                            $otp_sms_log_model->otp = $modle->otp;
                        } else {
                            $otp_sms_log_model->otp = \common\helpers\Utility::generateNumericOTP(6);
                        }
                        $this->custom_response['data']['otp'] = $otp_sms_log_model->otp;
                        $this->custom_response['data']['mobile_no'] = $otp_sms_log_model->mobile_no;
                        $this->custom_response['data']['time'] = date("Y-m-d h:i:s");
                        if ($otp_sms_log_model->save()) {
                            $this->options['sms'] = \common\components\sms\Smstriline::sms_content(['otp' => $otp_sms_log_model->otp], \common\components\sms\Smstriline::BC_SAKHI_OTP_TEMPLATE_ID);
                            $this->options['templateid'] = \common\components\sms\Smstriline::BC_SAKHI_OTP_TEMPLATE_ID;
                            $this->options['number'] = $otp_sms_log_model->mobile_no;
                            $smstli = new \common\components\sms\Smstriline($this->options);
                            $smstli->enableSendSms = 0;//\Yii::$app->params['sms_lane_enable'];
                            if ($smstli->enableSendSms) {
                                $sms = $smstli->SendSMS();
                                $otp_sms_log_model->status = 1;
                                $otp_sms_log_model->message_id = $sms;
                                $otp_sms_log_model->sms_send_time = new Expression('NOW()');
                                if ($otp_sms_log_model->update()) {
                                    
                                } else {
                                    
                                }
                            }
                            //$this->options['Message'] = \common\components\sms\Smslanev2::sms_content(['otp' => $otp_sms_log_model->otp], \common\components\sms\Smslanev2::TYPE_SMS_BC_OTP);
//                            $msisdn = '';
//                            if (strlen($otp_sms_log_model->mobile_no) == 10)
//                                $msisdn = '91';
//                            $msisdn .= $otp_sms_log_model->mobile_no;
//                            $this->options['MobileNumbers'] = $msisdn;
//                            $sms_lane = new \common\components\sms\Smslanev2($this->options);
//                            $sms_lane->enableSendSms = \Yii::$app->params['sms_lane_enable'];
//                            if ($sms_lane->enableSendSms) {
//                                $sms = $sms_lane->SendSMS(\common\components\sms\Smslanev2::SENDAR_OTP);
//                                // status 1 =>send -1 error
//                                if (empty($sms)) {
//                                    $this->custom_response['data']['content'] = $sms;
//                                    $otp_sms_log_model->status = -1;
//                                    $otp_sms_log_model->message_id = $sms;
//                                } else {
//                                    if ($sms['ErrorCode']) {
//                                        $otp_sms_log_model->status = -1;
//                                        if (isset($sms['Data'][0]['MessageId'])) {
//                                            $otp_sms_log_model->message_id = $sms['Data'][0]['MessageId'];
//                                        } else {
//                                            if (isset($sms['ErrorDescription'])) {
//                                                $otp_sms_log_model->message_id = $sms['ErrorDescription'];
//                                            }
//                                        }
//                                    } else {
//                                        $otp_sms_log_model->status = 1;
//                                        if (isset($sms['Data'][0]['MessageId'])) {
//                                            $otp_sms_log_model->message_id = $sms['Data'][0]['MessageId'];
//                                        }
//                                    }
//
//                                    $otp_sms_log_model->sms_send_time = new Expression('NOW()');
//                                }
//                                if ($otp_sms_log_model->update()) {
//                                    
//                                } else {
//                                    
//                                }
//                            }
                            $otp_sms_log_model = SmsLog::findOne($otp_sms_log_model->id);
//                            $this->custom_response['data']['otp'] = $otp_sms_log_model->otp;
//                            $this->custom_response['data']['mobile_no'] = $otp_sms_log_model->mobile_no;
//                            $this->custom_response['data']['time'] = $otp_sms_log_model->sms_send_time;
                            $this->custom_response['status'] = "0";
                            $this->custom_response['message'] = 'BC Sakhi Application is closed';
                        } else {
                            $this->custom_response['status'] = "0";
                            $this->custom_response['message'] = "Error(s): {" . \common\helpers\Utility::convertModelErrorToString($otp_sms_log_model) . "}";
                        }
                    }
                } else {
                    $sql = "SELECT *
        FROM `sms_log`
        WHERE   mobile_no=" . $this->data_json['mobile_no'] . ' order by sms_send_time desc LIMIT 1';
                    $modle = SmsLog::findBySql($sql)->one();
                    $this->custom_response['data']['pin'] = 0;
                    $otp_sms_log_model = new SmsLog();
                    $otp_sms_log_model->mobile_no = $this->data_json['mobile_no'];
                    $otp_sms_log_model->imei_no = $this->data_json['imei_no'];
                    $otp_sms_log_model->os_type = $this->data_json['os_type'];
                    $otp_sms_log_model->manufacturer_name = $this->data_json['manufacturer_name'];
                    $otp_sms_log_model->os_version = $this->data_json['os_version'];
                    $otp_sms_log_model->app_version = $this->data_json['app_version'];
                    $otp_sms_log_model->firebase_token = isset($this->data_json['firebase_token']) ? $this->data_json['firebase_token'] : '';
                    $otp_sms_log_model->time = new Expression('NOW()');
                    $otp_sms_log_model->sms_provider = 3;
                    if (!empty($modle)) {
                        $otp_sms_log_model->otp = $modle->otp;
                    } else {
                        $otp_sms_log_model->otp = \common\helpers\Utility::generateNumericOTP(6);
                    }

                    $this->custom_response['data']['otp'] = $otp_sms_log_model->otp;
                    $this->custom_response['data']['mobile_no'] = $otp_sms_log_model->mobile_no;
                    $this->custom_response['data']['time'] = date("Y-m-d h:i:s");
                    if ($otp_sms_log_model->save()) {

                        $this->options['sms'] = \common\components\sms\Smstriline::sms_content(['otp' => $otp_sms_log_model->otp], \common\components\sms\Smstriline::BC_SAKHI_OTP_TEMPLATE_ID);
                        $this->options['templateid'] = \common\components\sms\Smstriline::BC_SAKHI_OTP_TEMPLATE_ID;
                        $this->options['number'] = $otp_sms_log_model->mobile_no;
                        $smstli = new \common\components\sms\Smstriline($this->options);
                        $smstli->enableSendSms = 0;//\Yii::$app->params['sms_lane_enable'];
                        if ($smstli->enableSendSms) {
                            $sms = $smstli->SendSMS();
                            $otp_sms_log_model->status = 1;
                            $otp_sms_log_model->message_id = $sms;
                            $otp_sms_log_model->sms_send_time = new Expression('NOW()');
                            if ($otp_sms_log_model->update()) {
                                
                            } else {
                                
                            }
                        }
//                        $this->options['Message'] = \common\components\sms\Smslanev2::sms_content(['otp' => $otp_sms_log_model->otp], \common\components\sms\Smslanev2::TYPE_SMS_BC_OTP);
//                        $msisdn = '';
//                        if (strlen($otp_sms_log_model->mobile_no) == 10)
//                            $msisdn = '91';
//                        $msisdn .= $otp_sms_log_model->mobile_no;
//                        $this->options['MobileNumbers'] = $msisdn;
//                        $sms_lane = new \common\components\sms\Smslanev2($this->options);
//                        $sms_lane->enableSendSms = \Yii::$app->params['sms_lane_enable'];
//                        if ($sms_lane->enableSendSms) {
//                            $sms = $sms_lane->SendSMS(\common\components\sms\Smslanev2::SENDAR_OTP);
//                            // status 1 =>send -1 error
//                            if (empty($sms)) {
//                                $this->custom_response['data']['content'] = $sms;
//                                $otp_sms_log_model->status = -1;
//                                $otp_sms_log_model->message_id = $sms;
//                            } else {
//                                if ($sms['ErrorCode']) {
//                                    $otp_sms_log_model->status = -1;
//                                    if (isset($sms['Data'][0]['MessageId'])) {
//                                        $otp_sms_log_model->message_id = $sms['Data'][0]['MessageId'];
//                                    } else {
//                                        if (isset($sms['ErrorDescription'])) {
//                                            $otp_sms_log_model->message_id = $sms['ErrorDescription'];
//                                        }
//                                    }
//                                } else {
//                                    $otp_sms_log_model->status = 1;
//                                    if (isset($sms['Data'][0]['MessageId'])) {
//                                        $otp_sms_log_model->message_id = $sms['Data'][0]['MessageId'];
//                                    }
//                                }
//
//                                $otp_sms_log_model->sms_send_time = new Expression('NOW()');
//                            }
//                            if ($otp_sms_log_model->update()) {
//                                
//                            } else {
//                                
//                            }
//                        }
                        $otp_sms_log_model = SmsLog::findOne($otp_sms_log_model->id);
//                        $this->custom_response['data']['otp'] = $otp_sms_log_model->otp;
//                        $this->custom_response['data']['mobile_no'] = $otp_sms_log_model->mobile_no;
//                        $this->custom_response['data']['time'] = $otp_sms_log_model->sms_send_time;
                        $this->custom_response['status'] = "0";
                        $this->custom_response['message'] = 'BC Sakhi Application is closed';
                    } else {
                        $this->custom_response['status'] = "0";
                        $this->custom_response['message'] = "Error(s): {" . \common\helpers\Utility::convertModelErrorToString($otp_sms_log_model) . "}";
                    }
                }
            }
        } catch (\Exception $ex) {
            $this->custom_response['status'] = "0";
            $this->custom_response['message'] = 'Sorry, something went wrong there. Try again.';
        }
        $response = \Yii::$app->response;

        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    public function actionOtp() {
        try {
            $user_model = AppUser::findOne(['mobile_no' => $this->data_json['mobile_no']]);
            $this->custom_response['data']['Gp_version'] = $this->gpversion();
            $this->custom_response['data']['Bc_status'] = $this->bcstatus($user_model);
            $this->custom_response['data']['user_message'] = $this->getusermessage($user_model);
            if (in_array($this->data_json['mobile_no'], $this->test_user_mobile)) {
                $this->custom_response['data']['mobile_no'] = $this->data_json['mobile_no'];
                $this->custom_response['data']['time'] = date("Y-m-d h:i:s");
            } else {

                if (isset($user_model) and $user_model->form_number == SrlmBcApplication::FORM_STATUS_PART_4) {
                    $this->custom_response['data']['otp'] = "000001"; //$this->fix_otp;
                    $this->custom_response['data']['mobile_no'] = $this->data_json['mobile_no'];
                    $this->custom_response['data']['time'] = date("Y-m-d h:i:s");
                } else {
                    if ($user_model != null) {
                        $form_json = json_decode($user_model->form_json, true);
                        if (isset($form_json['gram_panchayat_code'])) {
                            if (!$this->gp($form_json['gram_panchayat_code'])) {
                                $this->custom_response['data']['otp'] = "000001";
                                $this->custom_response['data']['mobile_no'] = $this->data_json['mobile_no'];
                                $this->custom_response['data']['time'] = date("Y-m-d h:i:s");
                                $this->custom_response['data']['user_message'] = $this->gp_not_exist_message;
                            }
                        } else {
                            $sql = "SELECT *
        FROM `sms_log`
        WHERE  sms_send_time >= DATE_SUB(NOW(), interval 5 minute) and  mobile_no=" . $this->data_json['mobile_no'] . ' order by sms_send_time desc LIMIT 1';
                            $modle = SmsLog::findBySql($sql)->one();
                            if (!empty($modle)) {
                                $expression = new Expression('NOW()');
                                $now = (new \yii\db\Query)->select($expression)->scalar();
                                $this->custom_response['data']['otp'] = $modle->otp;
                                $this->custom_response['data']['mobile_no'] = $modle->mobile_no;
                                $this->custom_response['data']['time'] = $now;
                            } else {
                                $otp_sms_log_model = new SmsLog();
                                $otp_sms_log_model->mobile_no = $this->data_json['mobile_no'];
                                $otp_sms_log_model->imei_no = $this->data_json['imei_no'];
                                $otp_sms_log_model->os_type = $this->data_json['os_type'];
                                $otp_sms_log_model->manufacturer_name = $this->data_json['manufacturer_name'];
                                $otp_sms_log_model->os_version = $this->data_json['os_version'];
                                $otp_sms_log_model->app_version = $this->data_json['app_version'];
                                $otp_sms_log_model->firebase_token = isset($this->data_json['firebase_token']) ? $this->data_json['firebase_token'] : '';
                                $otp_sms_log_model->time = new Expression('NOW()');
                                $otp_sms_log_model->otp = \common\helpers\Utility::generateNumericOTP(6);
                                $this->custom_response['data']['otp'] = $otp_sms_log_model->otp;
                                $this->custom_response['data']['mobile_no'] = $otp_sms_log_model->mobile_no;
                                $this->custom_response['data']['time'] = date("Y-m-d h:i:s");
//                                if ($otp_sms_log_model->save()) {
//                                    $this->options['Message'] = \common\components\sms\Smslanev2::sms_content(['otp' => $otp_sms_log_model->otp], \common\components\sms\Smslanev2::TYPE_SMS_BC_OTP);
//                                    $msisdn = '';
//                                    if (strlen($otp_sms_log_model->mobile_no) == 10)
//                                        $msisdn = '91';
//                                    $msisdn .= $otp_sms_log_model->mobile_no;
//                                    $this->options['MobileNumbers'] = $msisdn;
//                                    $sms_lane = new \common\components\sms\Smslanev2($this->options);
//                                    $sms_lane->enableSendSms = \Yii::$app->params['sms_lane_enable'];
//                                    if ($sms_lane->enableSendSms) {
//                                        $sms = $sms_lane->SendSMS(\common\components\sms\Smslanev2::SENDAR_OTP);
//                                        // status 1 =>send -1 error
//                                        if (empty($sms)) {
//                                            $this->custom_response['data']['content'] = $sms;
//                                            $otp_sms_log_model->status = -1;
//                                            $otp_sms_log_model->message_id = $sms;
//                                        } else {
//                                            if ($sms['ErrorCode']) {
//                                                $otp_sms_log_model->status = -1;
//                                                if (isset($sms['Data'][0]['MessageId'])) {
//                                                    $otp_sms_log_model->message_id = $sms['Data'][0]['MessageId'];
//                                                } else {
//                                                    if (isset($sms['ErrorDescription'])) {
//                                                        $otp_sms_log_model->message_id = $sms['ErrorDescription'];
//                                                    }
//                                                }
//                                            } else {
//                                                $otp_sms_log_model->status = 1;
//                                                if (isset($sms['Data'][0]['MessageId'])) {
//                                                    $otp_sms_log_model->message_id = $sms['Data'][0]['MessageId'];
//                                                }
//                                            }
//
//                                            $otp_sms_log_model->sms_send_time = new Expression('NOW()');
//                                        }
//                                        if ($otp_sms_log_model->update()) {
//                                            
//                                        } else {
//                                            
//                                        }
//                                    }
//                                    $otp_sms_log_model = SmsLog::findOne($otp_sms_log_model->id);
//                                    $this->custom_response['data']['otp'] = $otp_sms_log_model->otp;
//                                    $this->custom_response['data']['mobile_no'] = $otp_sms_log_model->mobile_no;
//                                    $this->custom_response['data']['time'] = $otp_sms_log_model->sms_send_time;
//                                } else {
//                                    $this->custom_response['status'] = "0";
//                                    $this->custom_response['message'] = "Error(s): {" . \common\helpers\Utility::convertModelErrorToString($otp_sms_log_model) . "}";
//                                }
                            }
                        }
                    } else {
                        $sql = "SELECT *
        FROM `sms_log`
        WHERE  sms_send_time >= DATE_SUB(NOW(), interval 5 minute) and  mobile_no=" . $this->data_json['mobile_no'] . ' order by sms_send_time desc LIMIT 1';
                        $modle = SmsLog::findBySql($sql)->one();
                        if (!empty($modle)) {
                            $expression = new Expression('NOW()');
                            $now = (new \yii\db\Query)->select($expression)->scalar();
                            $this->custom_response['data']['otp'] = $modle->otp;
                            $this->custom_response['data']['mobile_no'] = $modle->mobile_no;
                            $this->custom_response['data']['time'] = $now;
                        } else {
                            $otp_sms_log_model = new SmsLog();
                            $otp_sms_log_model->mobile_no = $this->data_json['mobile_no'];
                            $otp_sms_log_model->imei_no = $this->data_json['imei_no'];
                            $otp_sms_log_model->os_type = $this->data_json['os_type'];
                            $otp_sms_log_model->manufacturer_name = $this->data_json['manufacturer_name'];
                            $otp_sms_log_model->os_version = $this->data_json['os_version'];
                            $otp_sms_log_model->app_version = $this->data_json['app_version'];
                            $otp_sms_log_model->firebase_token = isset($this->data_json['firebase_token']) ? $this->data_json['firebase_token'] : '';
                            $otp_sms_log_model->time = new Expression('NOW()');
                            $otp_sms_log_model->otp = \common\helpers\Utility::generateNumericOTP(6);
                            $this->custom_response['data']['otp'] = $otp_sms_log_model->otp;
                            $this->custom_response['data']['mobile_no'] = $otp_sms_log_model->mobile_no;
                            $this->custom_response['data']['time'] = date("Y-m-d h:i:s");
//                            if ($otp_sms_log_model->save()) {
//                                $this->options['Message'] = \common\components\sms\Smslanev2::sms_content(['otp' => $otp_sms_log_model->otp], \common\components\sms\Smslanev2::TYPE_SMS_BC_OTP);
//                                $msisdn = '';
//                                if (strlen($otp_sms_log_model->mobile_no) == 10)
//                                    $msisdn = '91';
//                                $msisdn .= $otp_sms_log_model->mobile_no;
//                                $this->options['MobileNumbers'] = $msisdn;
//                                $sms_lane = new \common\components\sms\Smslanev2($this->options);
//                                $sms_lane->enableSendSms = \Yii::$app->params['sms_lane_enable'];
//                                if ($sms_lane->enableSendSms) {
//                                    $sms = $sms_lane->SendSMS(\common\components\sms\Smslanev2::SENDAR_OTP);
//                                    // status 1 =>send -1 error
//                                    if (empty($sms)) {
//                                        $this->custom_response['data']['content'] = $sms;
//                                        $otp_sms_log_model->status = -1;
//                                        $otp_sms_log_model->message_id = $sms;
//                                    } else {
//                                        if ($sms['ErrorCode']) {
//                                            $otp_sms_log_model->status = -1;
//                                            if (isset($sms['Data'][0]['MessageId'])) {
//                                                $otp_sms_log_model->message_id = $sms['Data'][0]['MessageId'];
//                                            } else {
//                                                if (isset($sms['ErrorDescription'])) {
//                                                    $otp_sms_log_model->message_id = $sms['ErrorDescription'];
//                                                }
//                                            }
//                                        } else {
//                                            $otp_sms_log_model->status = 1;
//                                            if (isset($sms['Data'][0]['MessageId'])) {
//                                                $otp_sms_log_model->message_id = $sms['Data'][0]['MessageId'];
//                                            }
//                                        }
//
//                                        $otp_sms_log_model->sms_send_time = new Expression('NOW()');
//                                    }
//                                    if ($otp_sms_log_model->update()) {
//                                        
//                                    } else {
//                                        
//                                    }
//                                }
//                                $otp_sms_log_model = SmsLog::findOne($otp_sms_log_model->id);
//                                $this->custom_response['data']['otp'] = $otp_sms_log_model->otp;
//                                $this->custom_response['data']['mobile_no'] = $otp_sms_log_model->mobile_no;
//                                $this->custom_response['data']['time'] = $otp_sms_log_model->sms_send_time;
//                            } else {
//                                $this->custom_response['status'] = "0";
//                                $this->custom_response['message'] = "Error(s): {" . \common\helpers\Utility::convertModelErrorToString($otp_sms_log_model) . "}";
//                            }
                        }
                    }
                }
            }
        } catch (\Exception $ex) {
            $this->custom_response['status'] = "0";
            $this->custom_response['message'] = 'Sorry, something went wrong there. Try again.';
        }
        $response = \Yii::$app->response;

        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    public function actionFormsave() {
        $app_user = AppUser::findOne(\Yii::$app->controller->module->model_apilog->srlm_bc_selection_user_id);
        $app_user->form_json = json_encode($this->data_json);
        $app_user->form_uuid = $this->data_json['form_uuid'];
        throw new \yii\web\ForbiddenHttpException("Forbidden - Not Allowed.BC Sakhi Application is closed");
        exit;
        if (isset($this->data_json['form_number']))
            $app_user->form_number = $this->data_json['form_number'];
        if ($app_user->form_number == '1') {

            $app_user->form_start_date = new Expression('NOW()');
        }
        $app_user->form_end_date = new Expression('NOW()');
        if ($app_user->update(false)) {
            
        } else {
            print_r($app_user->errors);
        }

        $APPLICATION_FORM_FILE_FOLDER = Yii::$app->params['bcdatapath'];
        $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "bcselection/bcprofile/";

        if (!file_exists($APPLICATION_FORM_FILE_FOLDER . $app_user->id)) {
            mkdir($APPLICATION_FORM_FILE_FOLDER . $app_user->id);
            chmod($APPLICATION_FORM_FILE_FOLDER . $app_user->id, 0777);
        }

        if (isset($_FILES['profile_photo'])) {
            $new_file_name = 'profile_photo' . '_' . time() . '_' . basename($_FILES['profile_photo']['name']);
            $target_path = $APPLICATION_FORM_FILE_FOLDER . $app_user->id . "/" . $new_file_name;
            if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_path)) {
                chmod($target_path, 0777);
                $app_user->profile_photo = $new_file_name;
                $app_user->update();
            }
        }
        if (isset($_FILES['aadhar_front_photo'])) {
            $new_file_name = 'aadhar_front_photo' . '_' . time() . '_' . basename($_FILES['aadhar_front_photo']['name']);
            $target_path = $APPLICATION_FORM_FILE_FOLDER . $app_user->id . "/" . $new_file_name;
            if (move_uploaded_file($_FILES['aadhar_front_photo']['tmp_name'], $target_path)) {
                chmod($target_path, 0777);
                $app_user->aadhar_front_photo = $new_file_name;
                $app_user->update();
            }
        }
        if (isset($_FILES['aadhar_back_photo'])) {
            $new_file_name = 'aadhar_back_photo' . '_' . time() . '_' . basename($_FILES['aadhar_back_photo']['name']);
            $target_path = $APPLICATION_FORM_FILE_FOLDER . $app_user->id . "/" . $new_file_name;
            if (move_uploaded_file($_FILES['aadhar_back_photo']['tmp_name'], $target_path)) {
                chmod($target_path, 0777);
                $app_user->aadhar_back_photo = $new_file_name;
                $app_user->update();
            }
        }

        if ($app_user->profile_photo == "" || $app_user->aadhar_front_photo = "" || $app_user->aadhar_back_photo = "") {
            throw new \yii\web\BadRequestHttpException("Bad Request, Photo missing");
        }

        $response = \Yii::$app->response;

        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    public function actionCoronafeedback() {
        $app_user = AppUser::findOne(\Yii::$app->controller->module->model_apilog->srlm_bc_selection_user_id);
//        print_r($app_user);exit;
//        $model = new CoronaFeedbackForm($app_user);
//        if ($model->load(['CoronaFeedbackForm' => $this->data_json], null)) {
//            $model->feedback_model->que1a = $model->que1a;
//            $model->feedback_model->que2a = $model->que2a;
//            $model->feedback_model->que3a = $model->que3a;
//            $model->feedback_model->que4a = $model->que4a;
//            $model->feedback_model->gps = $model->gps;
//            $model->feedback_model->gps_accuracy = $model->gps_accuracy;
//            $model->feedback_model->status = 1;
////            print_r($model);exit;
//            if ($model->validate()) {
//                if ($model->feedback_model->save()) {
//                    if (isset($app_user->bcsapplication)) {
//                        $app_user->bcsapplication->corona_feedback = 1;
//                        $app_user->bcsapplication->save();
//                    }
//                } else {
//                    $this->custom_response['status'] = "0";
//                    $this->custom_response['message'] = "Error occure during saving";
//                }
//            } else {
//                $this->custom_response['status'] = "0";
//                $this->custom_response['message'] = "Error(s): {" . \common\helpers\Utility::convertModelErrorToString($model) . "}";
//            }
//        }
        $response = \Yii::$app->response;

        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    public function actionTrainingfeedback() {
        $app_user = AppUser::findOne(\Yii::$app->controller->module->model_apilog->srlm_bc_selection_user_id);
        if ($app_user->bcsapplication->blocked == '0') {
            $model = new \bc\modules\training\models\form\BCFeedbackForm($app_user->bcsapplication);
            if ($model->load(['BCFeedbackForm' => $this->data_json], null)) {

                if ($model->validate()) {
                    if ($model->save()) {
                        
                    } else {
                        $this->custom_response['status'] = "0";
                        $this->custom_response['message'] = "Error occure during saving";
                    }
                } else {
                    $this->custom_response['status'] = "0";
                    $this->custom_response['message'] = "Error(s): {" . \common\helpers\Utility::convertModelErrorToString($model) . "}";
                }
            }
        }
        $response = \Yii::$app->response;

        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    public function actionBcbankaccountsave() {
        $app_user = AppUser::findOne(\Yii::$app->controller->module->model_apilog->srlm_bc_selection_user_id);
        if ($app_user->bcsapplication->blocked == '0') {
            $APPLICATION_FORM_FILE_FOLDER = Yii::$app->params['bcdatapath'];
            $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "bcselection/bcprofile/";
            if (!file_exists($APPLICATION_FORM_FILE_FOLDER . $app_user->id)) {
                mkdir($APPLICATION_FORM_FILE_FOLDER . $app_user->id);
                chmod($APPLICATION_FORM_FILE_FOLDER . $app_user->id, 0777);
            }

            $passbook_photo = NULL;
            $model = new \bc\modules\selection\models\form\BCBankDetailForm($app_user->bcsapplication);
            //VKC 2022-05-09 if ($app_user->bcsapplication->training_status == SrlmBcApplication::TRAINING_STATUS_PASS and in_array($app_user->bcsapplication->bc_bank, [0, 3])) {
            if (in_array($app_user->bcsapplication->training_status, [SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH]) and in_array($app_user->bcsapplication->bc_bank, [0, 3])) {
                if (isset($_FILES['passbook_photo']))
                    $passbook_photo = $_FILES['passbook_photo'];

                if ($model->load(['BCBankDetailForm' => $this->data_json], null)) {
                    if (isset($_FILES['passbook_photo']))
                        $model->passbook_photo = $_FILES['passbook_photo']['name'];
                    if ($model->validate()) {
                        if (isset($_FILES['passbook_photo'])) {
                            $new_file_name = 'passbook_photo' . '_' . time() . '_' . basename($_FILES['passbook_photo']['name']);
                            $target_path = $APPLICATION_FORM_FILE_FOLDER . $app_user->id . "/" . $new_file_name;
                            if (move_uploaded_file($_FILES['passbook_photo']['tmp_name'], $target_path)) {
                                chmod($target_path, 0777);
                                $model->bc_application_model->passbook_photo = $new_file_name;
                            }
                        }
                        $model->bc_application_model->bank_account_no_of_the_bc = $model->bank_account_no_of_the_bc;
                        $model->bc_application_model->name_of_bank = $model->name_of_bank;
                        $model->bc_application_model->bank_id = $model->bank_id;
                        $bank_model = \cbo\models\master\CboMasterBank::findOne($model->bank_id);
                        if ($bank_model != null) {
                            $model->bc_application_model->name_of_bank = $bank_model->bank_name;
                        }

                        $model->bc_application_model->branch = $model->branch;
                        $model->bc_application_model->branch_code_or_ifsc = $model->branch_code_or_ifsc;
                        //$model->bc_application_model->date_of_opening_the_bank_account = $model->date_of_opening_the_bank_account;
                        $model->bc_application_model->cin = $model->cin;
                        $model->bc_application_model->verify_bc_passbook_photo = null;
                        $model->bc_application_model->verify_bc_passbook_not = null;
                        $model->bc_application_model->verify_bc_bank_account_no = null;
                        $model->bc_application_model->verify_bc_branch_code_or_ifsc = null;
                        $model->bc_application_model->verify_bc_ifsc_code_entered = null;
                        $model->bc_application_model->verify_bc_other = null;
                        $model->bc_application_model->verify_bc_other_reason = null;
                        $model->bc_application_model->bc_bank = 1;
                        $model->bc_application_model->migrate_rishta = 0;
                        $model->bc_application_model->action_type = SrlmBcApplication::ACTION_TYPE_BC_BANK;
                        if ($model->bc_application_model->save()) {
                            
                        } else {
                            $this->custom_response['status'] = "0";
                            $this->custom_response['message'] = "Error occure during saving";
                        }
                    } else {
                        $this->custom_response['status'] = "0";
                        $this->custom_response['message'] = "Error(s): {" . \common\helpers\Utility::convertModelErrorToString($model) . "}";
                    }

                    $response = \Yii::$app->response;
                    $response->format = \yii\web\Response::FORMAT_JSON;
                    $response->data = $this->custom_response;
                    return $this->custom_response;
                }
            }
        }

        $response = \Yii::$app->response;

        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    public function actionBcshgbankaccountsave() {
        $app_user = AppUser::findOne(\Yii::$app->controller->module->model_apilog->srlm_bc_selection_user_id);
        if ($app_user->bcsapplication->blocked == '0') {
            $FOLDER = Yii::$app->params['datapath'] . 'cbo/';
            if (!file_exists($FOLDER)) {
                mkdir($FOLDER);
                chmod($FOLDER, 0777);
            }
            $FOLDER = $FOLDER . 'shg' . '/';
            if (!file_exists($FOLDER)) {
                mkdir($FOLDER);
                chmod($FOLDER, 0777);
            }
            $APPLICATION_FORM_FILE_FOLDER = Yii::$app->params['bcdatapath'];
            $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "bcselection/bcprofile/";
            if (!file_exists($APPLICATION_FORM_FILE_FOLDER . $app_user->id)) {
                mkdir($APPLICATION_FORM_FILE_FOLDER . $app_user->id);
                chmod($APPLICATION_FORM_FILE_FOLDER . $app_user->id, 0777);
            }
            if (!file_exists($APPLICATION_FORM_FILE_FOLDER . $app_user->id . '/shg')) {
                mkdir($APPLICATION_FORM_FILE_FOLDER . $app_user->id . '/shg');
                chmod($APPLICATION_FORM_FILE_FOLDER . $app_user->id . '/shg', 0777);
            }
            //VKC 2022-05-09 if ($app_user->bcsapplication->training_status == SrlmBcApplication::TRAINING_STATUS_PASS and in_array($app_user->bcsapplication->shg_bank, [0, 3])) {
            if (in_array($app_user->bcsapplication->training_status, [SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH]) and in_array($app_user->bcsapplication->shg_bank, [0, 3])) {
                if (isset($app_user->bcsapplication) and $app_user->bcsapplication->cbo_shg_id) {
                    $shg_model = \cbo\models\Shg::findOne($app_user->bcsapplication->cbo_shg_id);
                    $passbook_photo = NULL;
                    $model = new \cbo\models\form\CboShgBankDetailForm($shg_model);
                    if (isset($_FILES['passbook_photo']))
                        $passbook_photo = $_FILES['passbook_photo'];

                    if ($model->load(['CboShgBankDetailForm' => $this->data_json], null)) {
                        if (isset($_FILES['passbook_photo']))
                            $model->passbook_photo = $_FILES['passbook_photo']['name'];
                        if ($model->validate()) {
                            if (isset($_FILES['passbook_photo'])) {
                                $new_file_name = 'passbook_photo' . '_' . time() . '_' . basename($_FILES['passbook_photo']['name']);
                                $FOLDER = $FOLDER . $model->shg_model->id . '/';
                                if (!file_exists($FOLDER)) {
                                    mkdir($FOLDER);
                                    chmod($FOLDER, 0777);
                                }
                                $target_path = $FOLDER . $new_file_name;
                                $target_path_bc = $APPLICATION_FORM_FILE_FOLDER . $app_user->id . '/shg/' . $new_file_name;
                                if (move_uploaded_file($_FILES['passbook_photo']['tmp_name'], $target_path_bc)) {
                                    chmod($target_path_bc, 0777);
                                    $model->shg_model->passbook_photo = $new_file_name;
                                }
                                //copy($target_path, $target_path_bc);
                            }
                            $model->shg_model->bank_account_no_of_the_shg = $model->bank_account_no_of_the_shg;
                            $model->shg_model->name_of_bank = $model->name_of_bank;
                            $model->shg_model->bank_id = $model->bank_id;
                            $bank_model = \cbo\models\master\CboMasterBank::findOne($model->bank_id);
                            if ($bank_model != null) {
                                $model->shg_model->name_of_bank = $bank_model->bank_name;
                            }
                            $model->shg_model->branch = $model->branch;
                            $model->shg_model->branch_code_or_ifsc = $model->branch_code_or_ifsc;
                            $model->shg_model->date_of_opening_the_bank_account = $model->date_of_opening_the_bank_account;
                            $model->shg_model->bank_detail_by = $app_user->bcsapplication->user_id;
                            $model->shg_model->bank_detail_date = new \yii\db\Expression('NOW()');
                            $model->shg_model->shg_bank = 1;
                            $app_user->bcsapplication->shg_bank = 1;
                            $app_user->bcsapplication->bank_account_no_of_the_shg = $model->shg_model->bank_account_no_of_the_shg;
                            $app_user->bcsapplication->bank_id_shg = $model->shg_model->bank_id;
                            $app_user->bcsapplication->name_of_bank_shg = $model->shg_model->name_of_bank;
                            $app_user->bcsapplication->branch_shg = $model->shg_model->branch;
                            $app_user->bcsapplication->branch_code_or_ifsc_shg = $model->shg_model->branch_code_or_ifsc;
                            $app_user->bcsapplication->passbook_photo_shg = $model->shg_model->passbook_photo;
                            $app_user->bcsapplication->verify_bc_shg_passbook_photo = null;
                            $app_user->bcsapplication->verify_bc_shg_name = null;
                            $app_user->bcsapplication->verify_bc_shg_bank_account_no = null;
                            $app_user->bcsapplication->verify_bc_shg_passbook_not = null;
                            $app_user->bcsapplication->verify_bc_shg_branch_code_or_ifsc = null;
                            $app_user->bcsapplication->verify_bc_shg_ifsc_code_entered = null;
                            $app_user->bcsapplication->verify_bc_shg_other = null;
                            $app_user->bcsapplication->verify_bc_shg_other_reason = null;
                            $app_user->bcsapplication->migrate_rishta = 0;
                            $app_user->bcsapplication->action_type = SrlmBcApplication::ACTION_TYPE_BC_SHG_BANK;
                            if ($app_user->bcsapplication->save()) {
                                //$app_user->bcsapplication->save();
                            } else {
                                $this->custom_response['status'] = "0";
                                $this->custom_response['message'] = "Error occure during saving";
                            }
                        } else {
                            $this->custom_response['status'] = "0";
                            $this->custom_response['message'] = "Error(s): {" . \common\helpers\Utility::convertModelErrorToString($model) . "}";
                        }

                        $response = \Yii::$app->response;
                        $response->format = \yii\web\Response::FORMAT_JSON;
                        $response->data = $this->custom_response;
                        return $this->custom_response;
                    }
                } else {
                    $this->custom_response['status'] = "0";
                    $this->custom_response['message'] = "Error(s): unauthorized SHF Bank Account save";
                }
            }
        }
        $response = \Yii::$app->response;

        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    public function actionUploadphoto() {
        $app_user = AppUser::findOne(\Yii::$app->controller->module->model_apilog->srlm_bc_selection_user_id);
        $model = new UploadPhotoForm($app_user);

        $APPLICATION_FORM_FILE_FOLDER = Yii::$app->params['bcdatapath'];
        $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "bcselection/bcprofile/";
        if (!file_exists($APPLICATION_FORM_FILE_FOLDER . $app_user->id)) {
            mkdir($APPLICATION_FORM_FILE_FOLDER . $app_user->id);
            chmod($APPLICATION_FORM_FILE_FOLDER . $app_user->id, 0777);
        }
        $profile_photo = NULL;
        $aadhar_front_photo = NULL;
        $aadhar_back_photo = NULL;
        if (isset($_FILES['profile_photo'])) {
            $profile_photo = $_FILES['profile_photo'];
            $model->profile_photo = basename($_FILES['profile_photo']['name']);
        }
        if (isset($_FILES['aadhar_front_photo'])) {
            $aadhar_front_photo = $_FILES['aadhar_front_photo'];
            $model->aadhar_front_photo = basename($_FILES['aadhar_front_photo']['name']);
        }
        if (isset($_FILES['aadhar_back_photo'])) {
            $aadhar_back_photo = $_FILES['aadhar_back_photo'];
            $model->aadhar_back_photo = basename($_FILES['aadhar_back_photo']['name']);
        }

        if ($model->validate()) {
            if (isset($_FILES['profile_photo'])) {
                $new_file_name = 'profile_photo' . '_' . time() . '_' . basename($_FILES['profile_photo']['name']);
                $target_path = $APPLICATION_FORM_FILE_FOLDER . $model->user_model->id . "/" . $new_file_name;
                if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_path)) {
                    chmod($target_path, 0777);
                    $model->user_model->profile_photo = $new_file_name;
                }
            }
            if (isset($_FILES['aadhar_front_photo'])) {
                $new_file_name = 'aadhar_front_photo' . '_' . time() . '_' . basename($_FILES['aadhar_front_photo']['name']);
                $target_path = $APPLICATION_FORM_FILE_FOLDER . $model->user_model->id . "/" . $new_file_name;
                if (move_uploaded_file($_FILES['aadhar_front_photo']['tmp_name'], $target_path)) {
                    chmod($target_path, 0777);
                    $model->user_model->aadhar_front_photo = $new_file_name;
                }
            }
            if (isset($_FILES['aadhar_back_photo'])) {
                $new_file_name = 'aadhar_back_photo' . '_' . time() . '_' . basename($_FILES['aadhar_back_photo']['name']);
                $target_path = $APPLICATION_FORM_FILE_FOLDER . $model->user_model->id . "/" . $new_file_name;
                if (move_uploaded_file($_FILES['aadhar_back_photo']['tmp_name'], $target_path)) {
                    chmod($target_path, 0777);
                    $model->user_model->aadhar_back_photo = $new_file_name;
                }
            }
            if ($model->user_model->update()) {
                if (!empty($model->application_model)) {
                    $model->application_model->profile_photo = $model->user_model->profile_photo;
                    $model->application_model->aadhar_front_photo = $model->user_model->aadhar_front_photo;
                    $model->application_model->aadhar_back_photo = $model->user_model->aadhar_back_photo;
                    if ($model->application_model->profile_photo and $model->application_model->aadhar_front_photo and $model->application_model->aadhar_back_photo) {
                        $model->application_model->bc_photo_status = 1;
                    }
                    $model->application_model->migrate_rishta = 0;
                    $model->application_model->action_type = SrlmBcApplication::ACTION_TYPE_UPLOAD_PROFILE_PHOTO;
                    $model->application_model->save();
                }
            } else {
                $this->custom_response['status'] = "0";
                $this->custom_response['message'] = "Error(s): {" . \common\helpers\Utility::convertModelErrorToString($model->user_model) . "}";
            }
        } else {
            $this->custom_response['status'] = "0";
            $this->custom_response['message'] = "Error(s): {" . \common\helpers\Utility::convertModelErrorToString($model) . "}";
        }
        $response = \Yii::$app->response;

        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    public function actionUploadpan() {
        $app_user = AppUser::findOne(\Yii::$app->controller->module->model_apilog->srlm_bc_selection_user_id);
        if ($app_user->bcsapplication->blocked == '0') {
            $model = new UploadPhotoForm($app_user);

            $APPLICATION_FORM_FILE_FOLDER = Yii::$app->params['bcdatapath'];
            $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "bcselection/bcprofile/";
            if (!file_exists($APPLICATION_FORM_FILE_FOLDER . $app_user->id)) {
                mkdir($APPLICATION_FORM_FILE_FOLDER . $app_user->id);
                chmod($APPLICATION_FORM_FILE_FOLDER . $app_user->id, 0777);
            }
            $pan_photo = NULL;

            if (isset($_FILES['pan_photo'])) {
                $new_file_name = 'pan_photo' . '_' . time() . '_' . basename($_FILES['pan_photo']['name']);
                $target_path = $APPLICATION_FORM_FILE_FOLDER . $model->user_model->id . "/" . $new_file_name;
                if (move_uploaded_file($_FILES['pan_photo']['tmp_name'], $target_path)) {
                    chmod($target_path, 0777);
                    $model->application_model->pan_photo = $new_file_name;
                    $model->application_model->pan_photo_upload = 1;
                    $model->application_model->pan_photo_date = new \yii\db\Expression('NOW()');
                    $model->application_model->migrate_rishta = 0;
                    $model->application_model->action_type = SrlmBcApplication::ACTION_TYPE_UPLOAD_PAN;
                    $model->application_model->update();
                }
            } else {
                $this->custom_response['status'] = "0";
                $this->custom_response['message'] = "Error(s): Pan Photo missing";
            }
        }
        $response = \Yii::$app->response;

        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    public function actionAcknowledgehandheldmachine() {
        $app_user = AppUser::findOne(\Yii::$app->controller->module->model_apilog->srlm_bc_selection_user_id);
        if ($app_user->bcsapplication->blocked == '0') {
            if ($app_user->bcsapplication->training_status == SrlmBcApplication::TRAINING_STATUS_PASS and $app_user->bcsapplication->bc_shg_funds_status == '1' and $app_user->bcsapplication->bc_support_funds_received == '1' and $app_user->bcsapplication->bc_handheld_machine_recived == null) {
                $APPLICATION_FORM_FILE_FOLDER = Yii::$app->params['bcdatapath'];
                $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "bcselection/bcprofile/";
                if (!file_exists($APPLICATION_FORM_FILE_FOLDER . $app_user->id)) {
                    mkdir($APPLICATION_FORM_FILE_FOLDER . $app_user->id);
                    chmod($APPLICATION_FORM_FILE_FOLDER . $app_user->id, 0777);
                }

                $bc_handheld_machine_photo = NULL;
                $model = new \bc\modules\selection\models\form\AcknowledgehandheldmachineForm($app_user->bcsapplication);

                if (isset($_FILES['bc_handheld_machine_photo']))
                    $bc_handheld_machine_photo = $_FILES['bc_handheld_machine_photo'];

                if ($model->load(['AcknowledgehandheldmachineForm' => $this->data_json], null)) {
                    if (isset($_FILES['bc_handheld_machine_photo']))
                        $model->bc_handheld_machine_photo = $_FILES['bc_handheld_machine_photo']['name'];
                    if ($model->validate()) {
                        if (isset($_FILES['bc_handheld_machine_photo'])) {
                            $new_file_name = 'bc_handheld_machine_photo' . '_' . time() . '_' . basename($_FILES['bc_handheld_machine_photo']['name']);
                            $target_path = $APPLICATION_FORM_FILE_FOLDER . $app_user->id . "/" . $new_file_name;
                            if (move_uploaded_file($_FILES['bc_handheld_machine_photo']['tmp_name'], $target_path)) {
                                chmod($target_path, 0777);
                                $model->bc_application_model->bc_handheld_machine_photo = $new_file_name;
                            }
                        }
                        $model->bc_application_model->did_partner_bank_contact_bc = $model->did_partner_bank_contact_bc;
                        $model->bc_application_model->bc_handheld_machine_recived = $model->bc_handheld_machine_recived;
                        $model->bc_application_model->bc_handheld_machine_recived_submitdate = new \yii\db\Expression('NOW()');
                        $model->bc_application_model->migrate_rishta = 0;
                        if ($model->did_partner_bank_contact_bc == '1' and $model->bc_handheld_machine_recived == '1') {
                            $model->bc_application_model->action_type = SrlmBcApplication::ACTION_TYPE_ACK_HANDHELD_MACHIN;
                            if ($model->bc_application_model->save()) {
                                
                            } else {
                                $this->custom_response['status'] = "0";
                                $this->custom_response['message'] = "Error occure during saving";
                            }
                        }
                    } else {
                        $this->custom_response['status'] = "0";
                        $this->custom_response['message'] = "Error(s): {" . \common\helpers\Utility::convertModelErrorToString($model) . "}";
                    }

                    $response = \Yii::$app->response;
                    $response->format = \yii\web\Response::FORMAT_JSON;
                    $response->data = $this->custom_response;
                    return $this->custom_response;
                }
            }
        }
        $response = \Yii::$app->response;

        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    public function actionAcknowledgesupportfunds() {
        $app_user = AppUser::findOne(\Yii::$app->controller->module->model_apilog->srlm_bc_selection_user_id);
        if ($app_user->bcsapplication->blocked == '0') {
            if ($app_user->bcsapplication->training_status == SrlmBcApplication::TRAINING_STATUS_PASS and $app_user->bcsapplication->bc_support_funds_handheld_amount == null) {
                $model = new \bc\modules\selection\models\form\AcknowledgesupportfundsForm($app_user->bcsapplication);
                if ($model->load(['AcknowledgesupportfundsForm' => $this->data_json], null)) {

                    if ($model->validate()) {


                        $model->bc_application_model->bc_support_funds_received = $model->bc_support_funds_received;
                        $model->bc_application_model->bc_support_funds_received_date = \Yii::$app->formatter->asDatetime($model->bc_support_funds_received_date, "php:Y-m-d");
                        $model->bc_application_model->bc_support_funds_received_submitdate = new \yii\db\Expression('NOW()');

                        $model->bc_application_model->bc_support_funds_received_amount = $model->bc_support_funds_received_amount;
                        $model->bc_application_model->bc_support_funds_handheld_amount = $model->bc_support_funds_handheld_amount;
                        $model->bc_application_model->bc_support_funds_od_amount = $model->bc_support_funds_od_amount;
                        if ($model->bc_support_funds_received == 1) {
                            $model->bc_application_model->action_type = SrlmBcApplication::ACTION_TYPE_ACK_SUPPORT_FUNDS;
                            if ($model->bc_application_model->save()) {
                                
                            } else {
                                $this->custom_response['status'] = "0";
                                $this->custom_response['message'] = "Error occure during saving";
                            }
                        }
                    } else {
                        $this->custom_response['status'] = "0";
                        $this->custom_response['message'] = "Error(s): {" . \common\helpers\Utility::convertModelErrorToString($model) . "}";
                    }

                    $response = \Yii::$app->response;
                    $response->format = \yii\web\Response::FORMAT_JSON;
                    $response->data = $this->custom_response;
                    return $this->custom_response;
                }
            }
        }
        $response = \Yii::$app->response;

        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    public function actionGetdetail() {
        $app_user = AppUser::findOne(\Yii::$app->controller->module->model_apilog->srlm_bc_selection_user_id);
        if (!empty($app_user)) {
            $this->app_id = isset($this->data_json['app_id']) ? $this->data_json['app_id'] : $app_user->srlm_bc_selection_app_detail_id;
            $this->custom_response['data']['user_message'] = '';
            if ($app_user->form_number == 6 and ($app_user->profile_photo and $app_user->aadhar_front_photo and $app_user->aadhar_back_photo)) {
                $this->user_message = "इस ऍप पर आपका आवेदन प्रक्रिया समाप्त हुआ I धन्यवाद I";
            }
            $this->custom_response['data']['user_message'] = $this->getusermessage($app_user);
            $this->custom_response['data']['user_message'] = $this->user_message;
            $this->custom_response['data']['form_number'] = $app_user->form_number;
            $this->custom_response['data']['photo_uploaded'] = ($app_user->profile_photo and $app_user->aadhar_front_photo and $app_user->aadhar_back_photo) ? 1 : 0;
            if (isset($app_user->bcsapplication)) {
                if (isset($this->data_json['app_version'])) {
                    $app_user->bcsapplication->last_app_version = $this->data_json['app_version'];
                    $app_user->bcsapplication->last_activity_time = new \yii\db\Expression('NOW()');
                    $app_user->bcsapplication->update();
                }
                if ($app_user->bcsapplication->bc_photo_status == '0') {
                    $this->custom_response['data']['photo_uploaded'] = 0;
                }
            }

            if ($app_user->form_uuid != "" && $app_user->form_uuid != NULL)
                $this->custom_response['data']['form_uuid'] = $app_user->form_uuid;
            else
                $this->custom_response['data']['form_uuid'] = "";
            if ($app_user->form_json != "" && $app_user->form_json != NULL)
                $this->custom_response['data']['form_json'] = $app_user->form_json;
            else
                $this->custom_response['data']['form_json'] = "";
            $this->custom_response['data']['Gp_version'] = $this->gpversion();
            $this->custom_response['data']['Bc_status'] = $this->bcstatus($app_user);
            //$this->custom_response['data']['profile_photo_url'] = $app_user->profile_photo != null ? \Yii::$app->params['app_url']['bc'] . '/getimage/bcprofile/' . $app_user->id . '/' . $app_user->profile_photo : null;
            $this->custom_response['data']['profile_photo_url'] = $app_user->profile_photo != null ? \Yii::$app->params['app_url']['api'] . '/imagesrlmbc/image1?app_id=' . $this->app_id . '&photo=profile_photo&token=' . Utility::token(15) . '.' . date('d-m-Y') : null;
            //$this->custom_response['data']['aadhar_front_photo_url'] = $app_user->aadhar_front_photo != null ? \Yii::$app->params['app_url']['bc'] . '/getimage/bcprofile/' . $app_user->id . '/' . $app_user->aadhar_front_photo : null;
            $this->custom_response['data']['aadhar_front_photo_url'] = $app_user->aadhar_front_photo != null ? \Yii::$app->params['app_url']['api'] . '/imagesrlmbc/image1?app_id=' . $this->app_id . '&photo=aadhar_front_photo&token=' . Utility::token(15) . '.' . date('d-m-Y') : null;
            //$this->custom_response['data']['aadhar_back_photo_url'] = $app_user->aadhar_back_photo != null ? \Yii::$app->params['app_url']['bc'] . '/getimage/bcprofile/' . $app_user->id . '/' . $app_user->aadhar_back_photo : null;
            $this->custom_response['data']['aadhar_back_photo_url'] = $app_user->aadhar_back_photo != null ? \Yii::$app->params['app_url']['api'] . '/imagesrlmbc/image1?app_id=' . $this->app_id . '&photo=aadhar_back_photo&token=' . Utility::token(15) . '.' . date('d-m-Y') : null;
            $this->custom_response['data']['iibf_photo_url'] = null;
            $this->custom_response['data']['pvr_photo_url'] = null;
            $this->custom_response['data']['iibf_membership_no'] = null;
            $this->custom_response['data']['viewweb'] = 0;
            $this->custom_response['data']['bc_passbook_photo_url'] = null;
            $this->custom_response['data']['bc_bank_account_no_of_the_bc'] = null;
            $this->custom_response['data']['bc_name_of_bank'] = null;
            $this->custom_response['data']['bc_branch'] = null;
            $this->custom_response['data']['bc_branch_code_or_ifsc'] = null;
            $this->custom_response['data']['Shg_name'] = null;
            $this->custom_response['data']['shg_passbook_photo_url'] = null;
            $this->custom_response['data']['shg_bank_account_no_of_the_shg'] = null;
            $this->custom_response['data']['shg_name_of_bank'] = null;
            $this->custom_response['data']['shg_branch'] = null;
            $this->custom_response['data']['shg_branch_code_or_ifsc'] = null;
            $this->custom_response['data']['bc_shg_name_update'] = 0;
            // $this->custom_response['data']['corona_feedback'] = 0; //corona_feedback
            $this->custom_response['data']['training_feedback'] = 0;
            $this->custom_response['data']['migrate_rishta'] = 0;
            if (isset($app_user->bcsapplication)) {
                $this->custom_response['data']['migrate_rishta'] = $app_user->bcsapplication->migrate_rishta;
//                if ($app_user->bcsapplication->corona_feedback == 0) {
//                    $this->custom_response['data']['corona_feedback'] = 1;
//                }
                if ($app_user->bcsapplication->cbo_shg_id == null) {
                    $this->custom_response['data']['bc_shg_name_update'] = 1;
                }
                if ($app_user->bcsapplication->status == SrlmBcApplication::STATUS_PROVISIONAL) {
                    $this->custom_response['data']['viewweb'] = 0;
                }
                if ($app_user->bcsapplication->blocked == '0') {
                    if ($app_user->bcsapplication->training_feedback == 0 and $app_user->bcsapplication->training_status == SrlmBcApplication::TRAINING_STATUS_PASS) {
                        $this->custom_response['data']['training_feedback'] = 1;
                    }
                }
            }
            if (in_array($app_user->mobile_no, $this->test_user_mobile)) {
                $this->custom_response['data']['viewweb'] = 0;
            }
            $this->custom_response['data']['bc_bank_account_detail'] = 0;
            $this->custom_response['data']['bc_shg_bank_account_detail'] = 0;
            $this->custom_response['data']['bc_pan_photo_status'] = 0;
            $this->custom_response['data']['partner_bank_field_associate'] = $this->getassociate($app_user);
            $this->custom_response['data']['bc_support_funds'] = 0;
            $this->custom_response['data']['bc_handheldmachine'] = 0;
            $this->custom_response['data']['bc_bank_detail_rejection_region'] = '';
            $this->custom_response['data']['bc_shg_bank_detail_rejection_region'] = '';
//            if (in_array($app_user->mobile_no, $this->test_user_mobile)) {
//                $this->custom_response['data']['bc_bank_account_detail'] = 1;
//            }
            if (isset($app_user->bcsapplication)) {
                if ($app_user->bcsapplication->blocked == '0') {
                    if ($app_user->bcsapplication->training_status == SrlmBcApplication::TRAINING_STATUS_PASS and $app_user->bcsapplication->bc_shg_funds_status == '1' and $app_user->bcsapplication->bc_support_funds_handheld_amount == null) {
                        $this->custom_response['data']['bc_support_funds'] = 1;
                    }
                    if ($app_user->bcsapplication->training_status == SrlmBcApplication::TRAINING_STATUS_PASS and $app_user->bcsapplication->bc_shg_funds_status == '1' and $app_user->bcsapplication->bc_support_funds_received == '1' and $app_user->bcsapplication->bc_handheld_machine_recived == null) {
                        $this->custom_response['data']['bc_handheldmachine'] = 1;
                    }
                }
                //$this->custom_response['data']['iibf_photo_url'] = $app_user->bcsapplication->iibf_photo_file_name != null ? \Yii::$app->params['app_url']['bc'] . '/getimage/bcprofile/' . $app_user->id . '/' . $app_user->bcsapplication->iibf_photo_file_name : null;
                $this->custom_response['data']['iibf_photo_url'] = $app_user->bcsapplication->iibf_photo_file_name != null ? \Yii::$app->params['app_url']['api'] . '/imagesrlmbc/image1?app_id=' . $this->app_id . '&photo=iibf_photo_file_name&token=' . Utility::token(15) . '.' . date('d-m-Y') : null;
                //$this->custom_response['data']['pvr_photo_url'] = $app_user->bcsapplication->pvr_upload_file_name != null ? \Yii::$app->params['app_url']['bc'] . '/getimage/bcprofile/' . $app_user->id . '/' . $app_user->bcsapplication->pvr_upload_file_name : null;
                $this->custom_response['data']['pvr_photo_url'] = $app_user->bcsapplication->pvr_upload_file_name != null ? \Yii::$app->params['app_url']['api'] . '/imagesrlmbc/image1?app_id=' . $this->app_id . '&photo=pvr_upload_file_name&token=' . Utility::token(15) . '.' . date('d-m-Y') : null;
                $this->custom_response['data']['iibf_membership_no'] = $app_user->bcsapplication->certificate_code != null ? $app_user->bcsapplication->certificate_code : null;
                if ($app_user->bcsapplication->blocked == '0') {
                    //VKC 2022-05-09 if ($app_user->bcsapplication->training_status == SrlmBcApplication::TRAINING_STATUS_PASS and in_array($app_user->bcsapplication->bc_bank, [0, 3])) {
                    if (in_array($app_user->bcsapplication->training_status, [SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH]) and in_array($app_user->bcsapplication->bc_bank, [0, 3])) {
                        $this->custom_response['data']['bc_bank_account_detail'] = 1;
                    }
                }
                if (in_array($app_user->bcsapplication->bc_bank, [3])) {
                    $html1 = 'बी0सी0 सखी बैंक विवरण वापसी का कारण.<br/>';
                    $html1 .= $app_user->bcsapplication->bcbankrjregion;
                    $this->custom_response['data']['bc_bank_detail_rejection_region'] = $html1;
                }
                if (in_array($app_user->bcsapplication->bc_bank, [1, 2])) {
                    $this->custom_response['data']['bc_bank_account_detail'] = 0;
                }
                //VKC 2022-05-09 if ($app_user->bcsapplication->training_status == SrlmBcApplication::TRAINING_STATUS_PASS and in_array($app_user->bcsapplication->pan_photo_upload, [0])) {
                if (in_array($app_user->bcsapplication->training_status, [SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH]) and in_array($app_user->bcsapplication->pan_photo_upload, [0])) {
                    $this->custom_response['data']['bc_pan_photo_status'] = 1;
                }
                //VKC 2022-05-09 if ($app_user->bcsapplication->cbo_shg_id and $app_user->bcsapplication->training_status == SrlmBcApplication::TRAINING_STATUS_PASS) {
                if ($app_user->bcsapplication->cbo_shg_id and in_array($app_user->bcsapplication->training_status, [SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH])) {
                    $shg_model = \cbo\models\Shg::findOne($app_user->bcsapplication->cbo_shg_id);
                    if ($app_user->bcsapplication->blocked == '0' and in_array($app_user->bcsapplication->shg_bank, [0, 3])) {
                        $this->custom_response['data']['bc_shg_bank_account_detail'] = 1;
                    }
                    if (in_array($app_user->bcsapplication->shg_bank, [1, 2])) {
                        $this->custom_response['data']['bc_shg_bank_account_detail'] = 0;
                        $this->custom_response['data']['Shg_name'] = $shg_model != null ? $shg_model->name_of_shg : null;
                    }
                    if ($shg_model != null) {
                        if ($app_user->bcsapplication->shg_bank) {
                            if (in_array($app_user->bcsapplication->shg_bank, [3])) {
                                $html2 = 'बी0सी0 सखी बैंक विवरण वापसी का कारण.<br/>';
                                $html2 .= $app_user->bcsapplication->bcshgbankrjregion;
                                $this->custom_response['data']['bc_shg_bank_detail_rejection_region'] = $html2;
                            }
                            if (in_array($app_user->bcsapplication->shg_bank, [1, 2])) {
                                $this->custom_response['data']['bc_shg_bank_account_detail'] = 0;
                            }
                            if (in_array($app_user->bcsapplication->shg_bank, [1, 2])) {
//                                $this->custom_response['data']['shg_passbook_photo_url'] = $shg_model->passbook_photo != null ? $shg_model->passbookUrl : null;
//                                $this->custom_response['data']['shg_passbook_photo_url'] = $shg_model->passbook_photo != null ? \Yii::$app->params['app_url']['api'] . '/imagesrlmbc/shg?app_id=' . $this->app_id . '&photo=passbook_photo&token=' . Utility::token(15) . '.' . date('d-m-Y') : null;
//                                $this->custom_response['data']['shg_bank_account_no_of_the_shg'] = $shg_model->bank_account_no_of_the_shg;
//                                $this->custom_response['data']['shg_name_of_bank'] = $shg_model->name_of_bank;
//                                $this->custom_response['data']['shg_branch'] = $shg_model->branch;
//                                $this->custom_response['data']['shg_branch_code_or_ifsc'] = $shg_model->branch_code_or_ifsc;
                                $this->custom_response['data']['shg_passbook_photo_url'] = $app_user->bcsapplication->passbook_photo_shg != null ? \Yii::$app->params['app_url']['api'] . '/imagesrlmbc/image1?app_id=' . $this->app_id . '&photo=passbook_photo_shg&token=' . Utility::token(15) . '.' . date('d-m-Y') : null;
                                $this->custom_response['data']['shg_bank_account_no_of_the_shg'] = $app_user->bcsapplication->bank_account_no_of_the_shg;
                                $this->custom_response['data']['shg_name_of_bank'] = $app_user->bcsapplication->name_of_bank_shg;
                                $this->custom_response['data']['shg_branch'] = $app_user->bcsapplication->branch_shg;
                                $this->custom_response['data']['shg_branch_code_or_ifsc'] = $app_user->bcsapplication->branch_code_or_ifsc_shg;
                            }
                        }
                    }
                }
                if ($app_user->bcsapplication->passbook_photo != null) {
                    if (in_array($app_user->bcsapplication->bc_bank, [1, 2])) {
                        //$this->custom_response['data']['bc_passbook_photo_url'] = $app_user->bcsapplication->passbook_photo != null ? \Yii::$app->params['app_url']['bc'] . '/getimage/bcprofile/' . $app_user->id . '/' . $app_user->bcsapplication->passbook_photo : null;
                        $this->custom_response['data']['bc_passbook_photo_url'] = $app_user->bcsapplication->passbook_photo != null ? \Yii::$app->params['app_url']['api'] . '/imagesrlmbc/image1?app_id=' . $this->app_id . '&photo=passbook_photo&token=' . Utility::token(15) . '.' . date('d-m-Y') : null;
                        $this->custom_response['data']['bc_bank_account_no_of_the_bc'] = $app_user->bcsapplication->bank_account_no_of_the_bc;
                        $this->custom_response['data']['bc_name_of_bank'] = $app_user->bcsapplication->name_of_bank;
                        $this->custom_response['data']['bc_branch'] = $app_user->bcsapplication->branch;
                        $this->custom_response['data']['bc_branch_code_or_ifsc'] = $app_user->bcsapplication->branch_code_or_ifsc;
                        // $this->custom_response['data']['bc_date_of_opening_the_bank_account'] = $app_user->bcsapplication->date_of_opening_the_bank_account;
                    }
                }
                if ($app_user->bcsapplication->pan_photo != null) {
                    //$this->custom_response['data']['bc_pan_photo_url'] = $app_user->bcsapplication->pan_photo != null ? \Yii::$app->params['app_url']['bc'] . '/getimage/bcprofile/' . $app_user->id . '/' . $app_user->bcsapplication->pan_photo : null;
                    $this->custom_response['data']['bc_pan_photo_url'] = $app_user->bcsapplication->pan_photo != null ? \Yii::$app->params['app_url']['api'] . '/imagesrlmbc/image1?app_id=' . $this->app_id . '&photo=pan_photo&token=' . Utility::token(15) . '.' . date('d-m-Y') : null;
                }
            }
            $response = \Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            $response->data = $this->custom_response;
            return $this->custom_response;
        } else {
            throw new \yii\web\NotFoundHttpException("Request URL not Found"); //error 404
        }
    }

    public function actionGetphoto() {
        $photo_name = $this->data_json['photo'];
        $app_user = AppUser::findOne(\Yii::$app->controller->module->model_apilog->srlm_bc_selection_user_id);
        $APPLICATION_FORM_FILE_FOLDER = Yii::$app->params['bcdatapath'];
        $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "bcselection/bcprofile/";
        $photo = $APPLICATION_FORM_FILE_FOLDER . $app_user->id . "/" . $app_user->$photo_name;
        setlocale(LC_ALL, 'en_US.UTF-8');
        if (file_exists($photo) && is_file($photo)) {
            $ext = pathinfo($photo, PATHINFO_EXTENSION);
            switch ($ext) {
                case 'jpg':
                    $mimetype = "image/jpg";
                    break;
                case 'jpeg':
                    $mimetype = "image/jpeg";
                    break;
                case 'gif':
                    $mimetype = "image/gif";
                    break;
                case 'png':
                    $mimetype = "image/png";
                    break;
                case 'bm':
                    $mimetype = "image/bmp";
                    break;
                case 'bmp':
                    $mimetype = "image/bmp";
                    break;
                default:
                    $mimetype = "application/octet-stream";
            }
            header('X-Accel-Buffering: no');
            \Yii::$app->response->format = yii\web\Response::FORMAT_RAW;
            \Yii::$app->response->headers->add("content-type", $mimetype);
            \Yii::$app->response->data = Yii::$app->response->sendFile(readfile($photo));
            \Yii::$app->response->send();
            ob_end_flush();
            flush();
            return ob_get_clean();
            die();
        } else {
            throw new \yii\web\NotFoundHttpException("Request URL not Found"); //error 404
        }
    }

    public function actionGetgp() {
        $this->custom_response['bc_login_info'] = $this->logininfo();
        $this->custom_response['support_text'] = 'किसी भी सम्बंधित जानकारी के लिए में रिश्ता कॉल सेंटर : <a href="tel:9070804050">9070804050</a> में कॉल करें।';
        $query = new \yii\db\Query();
        $query->select([
            'id',
            'district_code',
            'district_name',
            'block_code',
            'block_name',
            'gram_panchayat_code',
            'gram_panchayat_name',
            'village_code',
            'village_name',
        ]);
        $query->from('master_village');
        $query->where(['status' => 1]);
        $query->orderBy('id asc');
        $this->custom_response['data'] = $query->all(\Yii::$app->dbbc);
        
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    public function logininfo() {
        $html = '';
//        $html = '<p> वांछित बीसी सखी अभ्यर्थी सिर्फ़ उन्हीं ग्राम पंचायतों के लिए आवेदन कर सकती हैं जहां से बीसी सखी का कोई भी आवेदन शेष नहीं हैं। बीसी सखी के आधार कार्ड पर दर्ज पता से उनके आवेदन का सत्यापन होगा कि वे रिक्त ग्राम पंचायत की रहनेवाली है या नहीं । मोबाइल ऐप के माध्यम से आवेदन करने का अंतिम तिथि व समय: <b>  अगस्त 26, 2023, रात्रि 12 बजे तक है। </b> कोई भी असुविधा होने पर बीसी कॉल सेंटर पर फ़ोन करें: <a href="tel:9070804050">9070804050</a>   सिर्फ़ बीसी सखी अभ्यर्थी ही फ़ोन करें। </p>';
//        
        $html = '<p> कोई भी असुविधा होने पर बीसी कॉल सेंटर पर फ़ोन करें: <a href="tel:9070804050">9070804050</a>   सिर्फ़ बीसी सखी अभ्यर्थी ही फ़ोन करें। </p>';

        return $html;
    }

    public function gp($gp_code) {
        $query = new \yii\db\Query();
        $query->from('master_village');
        $query->where(['gram_panchayat_code' => $gp_code, 'status' => 1]);
        return $query->exists(\Yii::$app->dbbc);
    }

    public function getassociate($app_user) {
        $associate_array = [];
        if (isset($app_user->bcsapplication)) {
            if ($app_user->bcsapplication->bc_shg_funds_status == 1) {
                //$models = PartnerAssociates::find()->joinWith(['disblock'])->andWhere(['partner_associates.status' => 1])->all();
                $models = PartnerAssociates::find()->joinWith(['disblock'])->where(['partner_associates_block.block_code' => $app_user->bcsapplication->block_code])->andWhere(['partner_associates.status' => 1])->all();
                $associate_array = ArrayHelper::toArray($models, [
                            'bc\models\PartnerAssociates' => [
                                'id',
                                'name_of_the_field_officer',
                                'partner_bank_name' => function ($model) {
                                    $bank = \bc\models\master\MasterPartnerBank::findOne($model->master_partner_bank_id);
                                    return isset($bank) ? $bank->bank_name : null;
                                },
                                'gender' => function ($model) {
                                    return $model->gen;
                                },
                                'age',
                                'designation',
                                'mobile_no',
                                'alternate_mobile_no',
                                'whatsapp_no',
                                'email_id',
                                'name_of_supervisor',
                                'designation_of_supervisor',
                                'mobile_no_of_supervisor',
                                'bank_account_number',
                                'photo_profile_url' => function ($model) {
                                    return isset($model->photo_profile) ? \Yii::$app->params['app_url']['api'] . '/imagesrlmbc/imageasso?id=' . $model->id . '&photo=photo_profile&token=' . Utility::token(15) . '.' . date('d-m-Y') : null;
                                },
                                'company_letter_url' => function ($model) {
                                    return isset($model->photo_profile) ? \Yii::$app->params['app_url']['api'] . '/imagesrlmbc/imageasso?id=' . $model->id . '&photo=company_letter&token=' . Utility::token(15) . '.' . date('d-m-Y') : null;
                                },
                            ],
                ]);
            }
        }

        return $associate_array;
    }

    public function actionGetshg() {
        $app_user = AppUser::findOne(\Yii::$app->controller->module->model_apilog->srlm_bc_selection_user_id);
        $shg_array = [];
        if (isset($app_user->bcsapplication)) {
            $shg_list = \cbo\models\Shg::find()->select(['id', 'name_of_shg'])->where(['!=', 'status', -1])->andWhere(['dummy_column' => 0, 'gram_panchayat_code' => $app_user->bcsapplication->gram_panchayat_code])->orderBy('name_of_shg asc')->asArray()->all();
            $shg_array = $shg_list;
        }
        $this->custom_response['data']['shg_list'] = $shg_array;
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    public function actionUpdateshg() {
        $app_user = AppUser::findOne(\Yii::$app->controller->module->model_apilog->srlm_bc_selection_user_id);
        if ($app_user->bcsapplication->blocked == '0') {
            if (isset($app_user->bcsapplication) and isset($this->data_json['shg_name']) and $this->data_json['shg_name'] != '') {
                $app_user->bcsapplication->your_group_name = $this->data_json['shg_name'];
                $app_user->bcsapplication->bc_shg_name_update = 0;
                $app_user->bcsapplication->updated_at = time();
                $app_user->bcsapplication->action_type = SrlmBcApplication::ACTION_TYPE_UPDATE_SHG_NAME;
                $app_user->bcsapplication->save();
            } else {
                $this->custom_response['status'] = "0";
                $this->custom_response['message'] = "Error(s): shg name can not be blank ";
            }
        }
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $this->custom_response;
        return $this->custom_response;
    }

//    public function actionGetvillage() {
//        $query = new \yii\db\Query;
//        $query->select(['master_village.id', 'master_village.district_code', 'master_village.district_name', 'master_village.block_code', 'master_village.block_name', 'master_village.gram_panchayat_code', 'master_village.gram_panchayat_name', 'master_village.village_code', 'master_village.village_name']);
//        $query->where(['>', 'id', $this->data_json['from']]);
//        $query->from('master_village');
//        $query->orderBy('id asc');
//        $this->custom_response['total_record_count'] = $query->count();
//        $command = $query->createCommand();
//        $models = $command->queryAll();
//        $this->custom_response['master_village'] = $models;
//        $response = \Yii::$app->response;
//        $response->format = \yii\web\Response::FORMAT_JSON;
//        $response->data = $this->custom_response;
//        return $this->custom_response;
//    }

    public function actionNotificationacknowledge() {
        if (isset($this->data_json['log_id']) && $this->data_json['log_id'] != '') {
            $notification_model = \bc\models\NotificationLog::findOne($this->data_json['log_id']);
            if ($notification_model == null) {
                throw new \yii\web\ForbiddenHttpException("Forbidden. notification not found.");
            } else {

                \Yii::$app->dbbc->createCommand()
                        ->update('notification_log', ['acknowledge_status' => 1, 'acknowledge_date' => date('Y-m-d H:i:s ')], ' acknowledge_status = 0 and user_id = ' . \Yii::$app->controller->module->model_apilog->srlm_bc_selection_user_id . ' and id=' . $this->data_json['log_id'])
                        ->execute();
                $bcmodel = SrlmBcApplication::find()->where(['srlm_bc_selection_user_id' => $notification_model->user_id])->one();
                if ($bcmodel != null) {
                    if ($notification_model->detail_id == 1) {
                        $bcmodel->viewtemp1 = 2;
                    }
                    if ($notification_model->detail_id == 2) {
                        $bcmodel->viewtemp2 = 2;
                    }
                    if ($notification_model->detail_id == 3) {
                        $bcmodel->viewtemp3 = 2;
                    }
                    if ($notification_model->detail_id == 4) {
                        $bcmodel->viewtemp4 = 2;
                    }
                    if ($notification_model->detail_id == 5) {
                        $bcmodel->viewtemp5 = 2;
                    }
                    if ($notification_model->detail_id == 6) {
                        $bcmodel->viewtemp6 = 2;
                    }
                    if ($notification_model->detail_id == 7) {
                        $bcmodel->viewtemp7 = 2;
                    }
                    if ($notification_model->detail_id == 8) {
                        $bcmodel->viewtemp8 = 2;
                    }
                    if ($notification_model->detail_id == 9) {
                        $bcmodel->viewtemp9 = 2;
                    }
                    if ($notification_model->detail_id == 10) {
                        $bcmodel->viewtemp10 = 2;
                    }
                    if ($notification_model->detail_id == 11) {
                        $bcmodel->viewtemp11 = 2;
                    }
                    if ($notification_model->detail_id == 12) {
                        $bcmodel->viewtemp12 = 2;
                    }
                    if ($notification_model->detail_id == 13) {
                        $bcmodel->viewtemp13 = 2;
                    }
                    if ($notification_model->detail_id == 14) {
                        $bcmodel->viewtemp14 = 2;
                    }
                    $bcmodel->update(false);
                }
                $this->custom_response['notification_detail'] = \bc\models\NotificationLog::findOne($this->data_json['log_id']);

//                if ($notification_model->detail_id == \bc\models\NotificationTemplate::PRESELECTED_ACKNOLEDGE_TELE_INFO_TEMPLATE_ID) {
//                    \Yii::$app->dbbc->createCommand()
//                            ->update('srlm_bc_application', ['viewtemp5' => 2], ' srlm_bc_selection_user_id =  ' . $notification_model->user_id)
//                            ->execute();
//                }
            }
        } else {
            throw new \yii\web\BadRequestHttpException("Bad Request, notification not found"); // HTTP Code 400
        }
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    public function actionVeiwweb() {

        return $this->redirect(['/mobile']);
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $this->custom_response;
        return $this->custom_response;
    }

    public function getNotification($app_user) {
        if ($app_user->id == 2) {
            $user_id = 10;
        } else {
            $user_id = $app_user->id;
        }
        $sql = "SELECT  a.message_title as title,message,genrated_on
           FROM    notification_log a
		INNER JOIN
		(
			SELECT detail_id, MIN(id) min_ID
			FROM   notification_log
             where user_id=" . $user_id . "
			GROUP BY detail_id
		) b ON a.detail_id = b.detail_id AND
				a.id = b.min_ID
             where a.user_id=" . $user_id;
        return NotificationLog::findBySql($sql)->asArray()->all();
    }
}
