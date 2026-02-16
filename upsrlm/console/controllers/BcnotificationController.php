<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\db\Expression;
use yii\web\UploadedFile;
use yii\base\ActionEvent;
use yii\base\Application;
use yii\base\Model;
use bc\modules\selection\models\SrlmBcSelectionApiLog;
use bc\modules\selection\models\SrlmBcSelectionAppDetail;
use bc\modules\selection\models\SrlmBcSelectionUser;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationGroupFamily;
use bc\modules\selection\models\SrlmBcSelectionApiLog20200621;
use bc\modules\selection\models\BcApplicationCrone;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\models\NotificationTemplate;
use bc\models\NotificationLog;
use bc\models\NotificationLogFirebaseDetail;
use console\helpers\Utility;

/**
 * This command process Bc Application notification
 *
 * @author Habibur Rahman <rahman.kld@gmail.com>
 * @since 2.0
 */
class BcnotificationController extends Controller {

    public $process_limit = 1000;
    public $process_limit1 = 50000;
    public $process_limit2 = 1000;
    public $user_process_limit = 1000;
    public $data_json = [];

    public function actionTemplate14() {

        ini_set('memory_limit', '3072M');
        $models = RsetisBatchParticipants::find()->select('bc_application_id')->andWhere(['!=', 'status', -1])->andWhere(['training_status' => SrlmBcApplication::TRAINING_STATUS_PASS])->orderBy('id asc')->asArray()->all();
//         echo count($models);exit;
        foreach ($models as $model) {

            $model = SrlmBcApplication::findOne($model['bc_application_id']);
            $template_model = NotificationTemplate::findOne(NotificationTemplate::RISHTA_CALL_CENTER_TEMPLATE_ID_14);

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
                    // vikas
                    //$firbase_tocken = 'eFEccFiITGGCEEYmn5M4qZ:APA91bFyLEPOvChdt-0wRPS3hVMN66KwrIm8YRIv6y46R6wBTBCAFZZO6dAKlsf2Hqt7WNNnHxYRzy5g3hVrXxeRxWtNPoaSDV8dAON8eaetT9BpmLLnSaY3kVgF0ZcS2A9AzWc-Y0du';
                    // rahman
//                    $firbase_tocken = 'czKXaVWbQnqHQrAEqQEIf-:APA91bEdTjwZuT5eCReYk2oT1D3osMspDSMC6h9UtmarYpGcrztVAijUrHblEWSh36aebXQ1beYkRHS_SKaNfnfhcOXnQPkIu9VNsNHjzASKtm-C9ily50-LdVD2M1ax-EKfPkgA7ryj';
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

                    $model->viewtemp14 = 1;
                    $model->update();
                } catch (\Exception $ex) {
                    
                }
            } else {
                print_r($noti_log_model->getErrors());
            }
            //exit;
        }
    }

    public function actionTemplate13($division, $mod_value) {

        ini_set('memory_limit', '3072M');
        $models = SrlmBcApplication::find()->select('id')->andWhere(['=', 'form_number', '6'])->andWhere(['corona_feedback' => 0])->andWhere(['=', 'gender', '2'])->andWhere(['status' => [1, 2]])->orderBy('id asc')->asArray()->all();

        foreach ($models as $model) {
            if ($model['id'] % $division == $mod_value) {
                
            } else {
                continue;
            }

            $model = SrlmBcApplication::findOne($model['id']);
            $template_model = NotificationTemplate::findOne(NotificationTemplate::CORONA_TEMPLATE_ID_13);

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
                    // vikas
                    //$firbase_tocken = 'eFEccFiITGGCEEYmn5M4qZ:APA91bFyLEPOvChdt-0wRPS3hVMN66KwrIm8YRIv6y46R6wBTBCAFZZO6dAKlsf2Hqt7WNNnHxYRzy5g3hVrXxeRxWtNPoaSDV8dAON8eaetT9BpmLLnSaY3kVgF0ZcS2A9AzWc-Y0du';
                    // rahman
                    //$firbase_tocken = 'eyJyuB6DShm6gAxeyoy1Ve:APA91bE0fPMIRq-C3WTMHB1tBcCc1xuR8zsShq85IpV3u29JzbN9y3aql6c5vFJ_KwPYOm5DqJmnXuWGcGtcF6Z4teu7ta83-X7WpHgwhJA_4tqA5GTl4HEk-7dhG4vFyneZtLqoR-VR';
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

                    $model->viewtemp13 = 1;
                    $model->update();
                } catch (\Exception $ex) {
                    
                }
            } else {
                print_r($noti_log_model->getErrors());
            }
            //exit;
        }
    }

//    public function actionCertifiedtemplate8($division = null, $mod_value = null) {
//        ini_set('memory_limit', '3072M');
//        $models = RsetisBatchParticipants::find()->select('bc_application_id')->andWhere(['!=', 'status', -1])->andWhere(['=', 'training_status', SrlmBcApplication::TRAINING_STATUS_PASS])->orderBy('id asc')->asArray()->all();
//
////        echo count($models);        exit();
//        $template_model = NotificationTemplate::findOne(NotificationTemplate::CERTIFIED_TEMPLATE_ID_8);
//        foreach ($models as $pmodel) {
//            $model = SrlmBcApplication::findOne($pmodel['bc_application_id']);
//            $noti_log_model = new NotificationLog();
//            $noti_log_model->notification_type = NotificationLog::NOTIFICATION_TYPE_BC_APPLICATION_SELECTION;
//            $noti_log_model->notification_sub_type = NotificationLog::NOTIFICATION_SUB_TYPE_BC_APPLICATION_SELECTION_ACKNOLEDGE;
//            $noti_log_model->detail_id = $template_model->id;
//            $noti_log_model->user_id = $model->user->id;
//            $noti_log_model->app_id = $model->user->srlm_bc_selection_app_detail_id;
//            $noti_log_model->visible = $template_model->visible;
//            $noti_log_model->acknowledge = $template_model->acknowledge;
//            $noti_log_model->message_title = $template_model->name;
//            $noti_log_model->message = $template_model->template;
//            $noti_log_model->cron_status = 0;
//            $noti_log_model->status = 0;
//            if ($noti_log_model->save()) {
//                try {
//                    $notification = \bc\models\NotificationLog::findOne($noti_log_model->id);
//                    $firbase_tocken = $notification->bcuser->firebase_token;
//                    // vikas
//                    //$firbase_tocken = 'eFEccFiITGGCEEYmn5M4qZ:APA91bFyLEPOvChdt-0wRPS3hVMN66KwrIm8YRIv6y46R6wBTBCAFZZO6dAKlsf2Hqt7WNNnHxYRzy5g3hVrXxeRxWtNPoaSDV8dAON8eaetT9BpmLLnSaY3kVgF0ZcS2A9AzWc-Y0du';
//                    // rahman
//                    //$firbase_tocken = 'cpa3oDNZScOOUSwt3Kiqmd:APA91bFxfLdAf4yFChtdJGXmF7MjGGI1SK_Lm0OJC7yf1nzxeUdRFdaZc_yqsV540K8Jc3d82Lg6S_p1fOsDhKRPAF5Mc8lRaO24V6s1O1i4on15Vvs7Zabchtc9hzpync_GyiNA9lnF';
//                    $firebase = new \bc\components\GoogleFirebase($notification);
//                    $response = $firebase->send($firbase_tocken);
//
//                    $response_result = json_decode($response);
//                    $notification->cron_status = '1';
//                    $notification->status = '1';
//                    $notification->send_count = ($notification->send_count + 1);
//                    $notification->send_datetime = new \yii\db\Expression('NOW()');
//                    $notification_model_detail = new NotificationLogFirebaseDetail();
//                    $notification_model_detail->notification_log_id = $notification->id;
//                    if ($response_result == null) {
//                        $notification->status = 3;
//                        $notification_model_detail->firebase_message = "No Token";
//                    } else {
//                        if ($response_result->success) {
//                            $notification->status = 2;
//                            $notification->send_datetime = new \yii\db\Expression('NOW()');
//                            $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
//                        } else {
//                            $notification->status = 4;
//                            $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
//                        }
//                    }
//                    $notification_model_detail->save();
//                    $notification->update();
//                    $model->viewtemp8 = 1;
//                    $model->update();
//                } catch (\Exception $ex) {
//                    
//                }
//            } else {
//                print_r($noti_log_model->getErrors());
//            }
//            //exit;
//        }
//    }
//
//    public function actionCertifiedtemplate9($division = null, $mod_value = null) {
//        ini_set('memory_limit', '3072M');
//        $models = RsetisBatchParticipants::find()->select('bc_application_id')->andWhere(['!=', 'status', -1])->andWhere(['=', 'training_status', SrlmBcApplication::TRAINING_STATUS_PASS])->orderBy('id asc')->asArray()->all();
//
////        echo count($models);        exit();
//        $template_model = NotificationTemplate::findOne(NotificationTemplate::CERTIFIED_TEMPLATE_ID_9);
//        foreach ($models as $pmodel) {
//            $model = SrlmBcApplication::findOne($pmodel['bc_application_id']);
//            $noti_log_model = new NotificationLog();
//            $noti_log_model->notification_type = NotificationLog::NOTIFICATION_TYPE_BC_APPLICATION_SELECTION;
//            $noti_log_model->notification_sub_type = NotificationLog::NOTIFICATION_SUB_TYPE_BC_APPLICATION_SELECTION_ACKNOLEDGE;
//            $noti_log_model->detail_id = $template_model->id;
//            $noti_log_model->user_id = $model->user->id;
//            $noti_log_model->app_id = $model->user->srlm_bc_selection_app_detail_id;
//            $noti_log_model->visible = $template_model->visible;
//            $noti_log_model->acknowledge = $template_model->acknowledge;
//            $noti_log_model->message_title = $template_model->name;
//            $noti_log_model->message = $template_model->template;
//            $noti_log_model->cron_status = 0;
//            $noti_log_model->status = 0;
//            if ($noti_log_model->save()) {
//                try {
//                    $notification = \bc\models\NotificationLog::findOne($noti_log_model->id);
//                    $firbase_tocken = $notification->bcuser->firebase_token;
//                    // vikas
//                    //$firbase_tocken = 'eFEccFiITGGCEEYmn5M4qZ:APA91bFyLEPOvChdt-0wRPS3hVMN66KwrIm8YRIv6y46R6wBTBCAFZZO6dAKlsf2Hqt7WNNnHxYRzy5g3hVrXxeRxWtNPoaSDV8dAON8eaetT9BpmLLnSaY3kVgF0ZcS2A9AzWc-Y0du';
//                    // rahman
//                    //$firbase_tocken = 'cpa3oDNZScOOUSwt3Kiqmd:APA91bFxfLdAf4yFChtdJGXmF7MjGGI1SK_Lm0OJC7yf1nzxeUdRFdaZc_yqsV540K8Jc3d82Lg6S_p1fOsDhKRPAF5Mc8lRaO24V6s1O1i4on15Vvs7Zabchtc9hzpync_GyiNA9lnF';
//                    $firebase = new \bc\components\GoogleFirebase($notification);
//                    $response = $firebase->send($firbase_tocken);
//
//                    $response_result = json_decode($response);
//                    $notification->cron_status = '1';
//                    $notification->status = '1';
//                    $notification->send_count = ($notification->send_count + 1);
//                    $notification->send_datetime = new \yii\db\Expression('NOW()');
//                    $notification_model_detail = new NotificationLogFirebaseDetail();
//                    $notification_model_detail->notification_log_id = $notification->id;
//                    if ($response_result == null) {
//                        $notification->status = 3;
//                        $notification_model_detail->firebase_message = "No Token";
//                    } else {
//                        if ($response_result->success) {
//                            $notification->status = 2;
//                            $notification->send_datetime = new \yii\db\Expression('NOW()');
//                            $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
//                        } else {
//                            $notification->status = 4;
//                            $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
//                        }
//                    }
//                    $notification_model_detail->save();
//                    $notification->update();
//                    $model->viewtemp9 = 1;
//                    $model->update();
//                } catch (\Exception $ex) {
//                    
//                }
//            } else {
//                print_r($noti_log_model->getErrors());
//            }
//            //exit;
//        }
//    }
//
//    public function actionCertifiedtemplate10($division = null, $mod_value = null) {
//        ini_set('memory_limit', '3072M');
//        $models = RsetisBatchParticipants::find()->select('bc_application_id')->andWhere(['!=', 'status', -1])->andWhere(['=', 'training_status', SrlmBcApplication::TRAINING_STATUS_PASS])->orderBy('id asc')->asArray()->all();
//
////        echo count($models);        exit();
//        $template_model = NotificationTemplate::findOne(NotificationTemplate::CERTIFIED_TEMPLATE_ID_10);
//        foreach ($models as $pmodel) {
//            $model = SrlmBcApplication::findOne($pmodel['bc_application_id']);
//            $noti_log_model = new NotificationLog();
//            $noti_log_model->notification_type = NotificationLog::NOTIFICATION_TYPE_BC_APPLICATION_SELECTION;
//            $noti_log_model->notification_sub_type = NotificationLog::NOTIFICATION_SUB_TYPE_BC_APPLICATION_SELECTION_ACKNOLEDGE;
//            $noti_log_model->detail_id = $template_model->id;
//            $noti_log_model->user_id = $model->user->id;
//            $noti_log_model->app_id = $model->user->srlm_bc_selection_app_detail_id;
//            $noti_log_model->visible = $template_model->visible;
//            $noti_log_model->acknowledge = $template_model->acknowledge;
//            $noti_log_model->message_title = $template_model->name;
//            $noti_log_model->message = $template_model->template;
//            $noti_log_model->cron_status = 0;
//            $noti_log_model->status = 0;
//            if ($noti_log_model->save()) {
//                try {
//                    $notification = \bc\models\NotificationLog::findOne($noti_log_model->id);
//                    $firbase_tocken = $notification->bcuser->firebase_token;
//                    // vikas
//                    //$firbase_tocken = 'eFEccFiITGGCEEYmn5M4qZ:APA91bFyLEPOvChdt-0wRPS3hVMN66KwrIm8YRIv6y46R6wBTBCAFZZO6dAKlsf2Hqt7WNNnHxYRzy5g3hVrXxeRxWtNPoaSDV8dAON8eaetT9BpmLLnSaY3kVgF0ZcS2A9AzWc-Y0du';
//                    // rahman
//                    //$firbase_tocken = 'cpa3oDNZScOOUSwt3Kiqmd:APA91bFxfLdAf4yFChtdJGXmF7MjGGI1SK_Lm0OJC7yf1nzxeUdRFdaZc_yqsV540K8Jc3d82Lg6S_p1fOsDhKRPAF5Mc8lRaO24V6s1O1i4on15Vvs7Zabchtc9hzpync_GyiNA9lnF';
//                    $firebase = new \bc\components\GoogleFirebase($notification);
//                    $response = $firebase->send($firbase_tocken);
//
//                    $response_result = json_decode($response);
//                    $notification->cron_status = '1';
//                    $notification->status = 1;
//                    $notification->send_count = ($notification->send_count + 1);
//                    $notification->send_datetime = new \yii\db\Expression('NOW()');
//                    $notification_model_detail = new NotificationLogFirebaseDetail();
//                    $notification_model_detail->notification_log_id = $notification->id;
//                    if ($response_result == null) {
//                        $notification->status = 3;
//                        $notification_model_detail->firebase_message = "No Token";
//                    } else {
//                        if ($response_result->success) {
//                            $notification->status = 2;
//                            $notification->send_datetime = new \yii\db\Expression('NOW()');
//                            $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
//                        } else {
//                            $notification->status = 4;
//                            $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
//                        }
//                    }
//                    $notification_model_detail->save();
//                    $notification->update();
//                    $model->viewtemp10 = 1;
//                    $model->update();
//                } catch (\Exception $ex) {
//                    
//                }
//            } else {
//                print_r($noti_log_model->getErrors());
//            }
//            //exit;
//        }
//    }
//        public function actionCertifiedtemplate11($division = null, $mod_value = null) {
//        ini_set('memory_limit', '3072M');
//        $models = RsetisBatchParticipants::find()->select('bc_application_id')->andWhere(['!=', 'status', -1])->andWhere(['training_status'=> SrlmBcApplication::TRAINING_STATUS_PASS])->orderBy('id asc')->asArray()->all();
//
//        $template_model = NotificationTemplate::findOne(NotificationTemplate::CERTIFIED_TEMPLATE_ID_11);
//        foreach ($models as $pmodel) {
//            $model = SrlmBcApplication::findOne($pmodel['bc_application_id']);
//            $noti_log_model = new NotificationLog();
//            $noti_log_model->notification_type = NotificationLog::NOTIFICATION_TYPE_BC_APPLICATION_SELECTION;
//            $noti_log_model->notification_sub_type = NotificationLog::NOTIFICATION_SUB_TYPE_BC_APPLICATION_SELECTION_ACKNOLEDGE;
//            $noti_log_model->detail_id = $template_model->id;
//            $noti_log_model->user_id = $model->user->id;
//            $noti_log_model->app_id = $model->user->srlm_bc_selection_app_detail_id;
//            $noti_log_model->visible = $template_model->visible;
//            $noti_log_model->acknowledge = $template_model->acknowledge;
//            $noti_log_model->message_title = $template_model->name;
//            $noti_log_model->message = $template_model->template;
//            $noti_log_model->cron_status = 0;
//            $noti_log_model->status = 0;
//            if ($noti_log_model->save()) {
//                try {
//                    $notification = \bc\models\NotificationLog::findOne($noti_log_model->id);
//                    $firbase_tocken = $notification->bcuser->firebase_token;
//                    // vikas
//                    //$firbase_tocken = 'eFEccFiITGGCEEYmn5M4qZ:APA91bFyLEPOvChdt-0wRPS3hVMN66KwrIm8YRIv6y46R6wBTBCAFZZO6dAKlsf2Hqt7WNNnHxYRzy5g3hVrXxeRxWtNPoaSDV8dAON8eaetT9BpmLLnSaY3kVgF0ZcS2A9AzWc-Y0du';
//                    // rahman
////                    $firbase_tocken = 'cVbUQXVORgGinGKInSyPtV:APA91bEVjBDT7XUssrkh3qHPgJE93ol8gkbyIyGjsJropK4TjuYk-NQi23Gx6NRxlPLksKk2mdMos-lREJq64JBwygYItbtoYXX8Bki48F8LnkqKWp6THveNsAddQGJ21WBg8epj78Fa';
////                    
//                    $firebase = new \bc\components\GoogleFirebase($notification);
//                    $response = $firebase->send($firbase_tocken);
//
//                    $response_result = json_decode($response);
//                    $notification->cron_status = '1';
//                    $notification->status = 1;
//                    $notification->send_count = ($notification->send_count + 1);
//                    $notification->send_datetime = new \yii\db\Expression('NOW()');
//                    $notification_model_detail = new NotificationLogFirebaseDetail();
//                    $notification_model_detail->notification_log_id = $notification->id;
//                    if ($response_result == null) {
//                        $notification->status = 3;
//                        $notification_model_detail->firebase_message = "No Token";
//                    } else {
//                        if ($response_result->success) {
//                            $notification->status = 2;
//                            $notification->send_datetime = new \yii\db\Expression('NOW()');
//                            $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
//                        } else {
//                            $notification->status = 4;
//                            $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
//                        }
//                    }
//                    $notification_model_detail->save();
//                    $notification->update();
//                    $model->viewtemp11 = 1;
//                    $model->update();
//                    
//                } catch (\Exception $ex) {
//                    
//                }
//            } else {
//                print_r($noti_log_model->getErrors());
//            }
//            //exit;
//        }
//    }
//    public function actionCertifiedtemplate12($division = null, $mod_value = null) {
//        ini_set('memory_limit', '3072M');
//        $models = RsetisBatchParticipants::find()->select('bc_application_id')->andWhere(['!=', 'status', -1])->andWhere(['training_status'=> SrlmBcApplication::TRAINING_STATUS_PASS])->orderBy('id asc')->asArray()->all();
//
//       
//        $template_model = NotificationTemplate::findOne(NotificationTemplate::CERTIFIED_TEMPLATE_ID_12);
//        foreach ($models as $pmodel) {
//            $model = SrlmBcApplication::findOne($pmodel['bc_application_id']);
//            $noti_log_model = new NotificationLog();
//            $noti_log_model->notification_type = NotificationLog::NOTIFICATION_TYPE_BC_APPLICATION_SELECTION;
//            $noti_log_model->notification_sub_type = NotificationLog::NOTIFICATION_SUB_TYPE_BC_APPLICATION_SELECTION_ACKNOLEDGE;
//            $noti_log_model->detail_id = $template_model->id;
//            $noti_log_model->user_id = $model->user->id;
//            $noti_log_model->app_id = $model->user->srlm_bc_selection_app_detail_id;
//            $noti_log_model->visible = $template_model->visible;
//            $noti_log_model->acknowledge = $template_model->acknowledge;
//            $noti_log_model->message_title = $template_model->name;
//            $noti_log_model->message = $template_model->template;
//            $noti_log_model->cron_status = 0;
//            $noti_log_model->status = 0;
//            if ($noti_log_model->save()) {
//                try {
//                    $notification = \bc\models\NotificationLog::findOne($noti_log_model->id);
//                    $firbase_tocken = $notification->bcuser->firebase_token;
//                    // vikas
//                    //$firbase_tocken = 'eFEccFiITGGCEEYmn5M4qZ:APA91bFyLEPOvChdt-0wRPS3hVMN66KwrIm8YRIv6y46R6wBTBCAFZZO6dAKlsf2Hqt7WNNnHxYRzy5g3hVrXxeRxWtNPoaSDV8dAON8eaetT9BpmLLnSaY3kVgF0ZcS2A9AzWc-Y0du';
//                    // rahman
//                    //$firbase_tocken = 'cpa3oDNZScOOUSwt3Kiqmd:APA91bFxfLdAf4yFChtdJGXmF7MjGGI1SK_Lm0OJC7yf1nzxeUdRFdaZc_yqsV540K8Jc3d82Lg6S_p1fOsDhKRPAF5Mc8lRaO24V6s1O1i4on15Vvs7Zabchtc9hzpync_GyiNA9lnF';
////                    $firbase_tocken = 'cVbUQXVORgGinGKInSyPtV:APA91bEVjBDT7XUssrkh3qHPgJE93ol8gkbyIyGjsJropK4TjuYk-NQi23Gx6NRxlPLksKk2mdMos-lREJq64JBwygYItbtoYXX8Bki48F8LnkqKWp6THveNsAddQGJ21WBg8epj78Fa';
////                    
//                    $firebase = new \bc\components\GoogleFirebase($notification);
//                    $response = $firebase->send($firbase_tocken);
//
//                    $response_result = json_decode($response);
//                    $notification->cron_status = '1';
//                    $notification->status = 1;
//                    $notification->send_count = ($notification->send_count + 1);
//                    $notification->send_datetime = new \yii\db\Expression('NOW()');
//                    $notification_model_detail = new NotificationLogFirebaseDetail();
//                    $notification_model_detail->notification_log_id = $notification->id;
//                    if ($response_result == null) {
//                        $notification->status = 3;
//                        $notification_model_detail->firebase_message = "No Token";
//                    } else {
//                        if ($response_result->success) {
//                            $notification->status = 2;
//                            $notification->send_datetime = new \yii\db\Expression('NOW()');
//                            $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
//                        } else {
//                            $notification->status = 4;
//                            $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
//                        }
//                    }
//                    $notification_model_detail->save();
//                    $notification->update();
//                    $model->viewtemp12 = 1;
//                    $model->update();
//                    
//                } catch (\Exception $ex) {
//                    
//                }
//            } else {
//                print_r($noti_log_model->getErrors());
//            }
//            //exit;
//        }
//    }
//    public function actionCertifiedtemplate7($division = null, $mod_value = null) {
//        ini_set('memory_limit', '3072M');
//        $models = RsetisBatchParticipants::find()->select('bc_application_id')->andWhere(['!=', 'status', -1])->andWhere(['=', 'training_status', SrlmBcApplication::TRAINING_STATUS_PASS])->orderBy('id asc')->asArray()->all();
//
////        echo count($models);        exit();
//        $template_model = NotificationTemplate::findOne(NotificationTemplate::CERTIFIED_BC_BANK_ACCOUNT_TEMPLATE_ID);
//        foreach ($models as $pmodel) {
//            $model = SrlmBcApplication::findOne($pmodel['bc_application_id']);
//            $noti_log_model = new NotificationLog();
//            $noti_log_model->notification_type = NotificationLog::NOTIFICATION_TYPE_BC_APPLICATION_SELECTION;
//            $noti_log_model->notification_sub_type = NotificationLog::NOTIFICATION_SUB_TYPE_BC_APPLICATION_SELECTION_ACKNOLEDGE;
//            $noti_log_model->detail_id = $template_model->id;
//            $noti_log_model->user_id = $model->user->id;
//            $noti_log_model->app_id = $model->user->srlm_bc_selection_app_detail_id;
//            $noti_log_model->visible = $template_model->visible;
//            $noti_log_model->acknowledge = $template_model->acknowledge;
//            $noti_log_model->message_title = $template_model->name;
//            $noti_log_model->message = $template_model->template;
//            $noti_log_model->cron_status = 0;
//            $noti_log_model->status = 0;
//            if ($noti_log_model->save()) {
//                try {
//                    $notification = \bc\models\NotificationLog::findOne($noti_log_model->id);
//                    $firbase_tocken = $notification->bcuser->firebase_token;
//                    // vikas
//                    //$firbase_tocken = 'eFEccFiITGGCEEYmn5M4qZ:APA91bFyLEPOvChdt-0wRPS3hVMN66KwrIm8YRIv6y46R6wBTBCAFZZO6dAKlsf2Hqt7WNNnHxYRzy5g3hVrXxeRxWtNPoaSDV8dAON8eaetT9BpmLLnSaY3kVgF0ZcS2A9AzWc-Y0du';
//                    // rahman
//                    //$firbase_tocken = 'cpa3oDNZScOOUSwt3Kiqmd:APA91bFxfLdAf4yFChtdJGXmF7MjGGI1SK_Lm0OJC7yf1nzxeUdRFdaZc_yqsV540K8Jc3d82Lg6S_p1fOsDhKRPAF5Mc8lRaO24V6s1O1i4on15Vvs7Zabchtc9hzpync_GyiNA9lnF';
//                    $firebase = new \bc\components\GoogleFirebase($notification);
//                    $response = $firebase->send($firbase_tocken);
//
//                    $response_result = json_decode($response);
//                    $notification->cron_status = '1';
//                    $notification->send_count = ($notification->send_count + 1);
//                    $notification_model_detail = new NotificationLogFirebaseDetail();
//                    $notification_model_detail->notification_log_id = $notification->id;
//                    if ($response_result == null) {
//                        $notification->status = 0;
//                        $notification_model_detail->firebase_message = "No Token";
//                    } else {
//                        if ($response_result->success) {
//                            $notification->status = 1;
//                            $notification->send_datetime = new \yii\db\Expression('NOW()');
//                            $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
//                        } else {
//                            $notification->status = 0;
//                            $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
//                        }
//                    }
//                    $notification_model_detail->save();
//                    $notification->update();
//                    $model->viewtemp7 = 1;
//                    $model->update();
//                } catch (\Exception $ex) {
//                    
//                }
//            } else {
//                print_r($noti_log_model->getErrors());
//            }
//            //exit;
//        }
//    }
//    public function actionSelectedacknoledgetemplate5($division, $mod_value) {
//
//        ini_set('memory_limit', '3072M');
//        $models = SrlmBcApplication::find()->select('id')->andWhere(['=', 'form_number', '6'])->andWhere(['=', 'gender', '2'])->andWhere(['=', 'status', SrlmBcApplication::STATUS_PROVISIONAL])->orderBy('id asc')->asArray()->all();
//
//        foreach ($models as $model) {
//            if ($model['id'] % $division == $mod_value) {
//                
//            } else {
//                continue;
//            }
//
//            $model = SrlmBcApplication::findOne($model['id']);
//            if ($model->status == SrlmBcApplication::STATUS_PROVISIONAL) {
//                $template_model = NotificationTemplate::findOne(NotificationTemplate::PRESELECTED_ACKNOLEDGE_TELE_INFO_TEMPLATE_ID);
//            } else {
//                // $template_model = NotificationTemplate::findOne(NotificationTemplate::STANDBY_ACKNOLEDGE_TEMPLATE_ID);
//            }
//            $noti_log_model = new NotificationLog();
//            $noti_log_model->notification_type = NotificationLog::NOTIFICATION_TYPE_BC_APPLICATION_SELECTION;
//            $noti_log_model->notification_sub_type = NotificationLog::NOTIFICATION_SUB_TYPE_BC_APPLICATION_SELECTION_ACKNOLEDGE;
//            $noti_log_model->detail_id = $template_model->id;
//            $noti_log_model->user_id = $model->user->id;
//            $noti_log_model->app_id = $model->user->srlm_bc_selection_app_detail_id;
//            $noti_log_model->visible = $template_model->visible;
//            $noti_log_model->acknowledge = $template_model->acknowledge;
//            $noti_log_model->message_title = $template_model->name;
//            $noti_log_model->message = sprintf($template_model->template, $model->gram_panchayat_name, $model->block_name, $model->district_name);
//            $noti_log_model->cron_status = 0;
//            $noti_log_model->status = 0;
//            if ($noti_log_model->save()) {
//                try {
//                    $notification = \bc\models\NotificationLog::findOne($noti_log_model->id);
//                    $firbase_tocken = $notification->bcuser->firebase_token;
//                    // vikas
//                    //$firbase_tocken = 'eFEccFiITGGCEEYmn5M4qZ:APA91bFyLEPOvChdt-0wRPS3hVMN66KwrIm8YRIv6y46R6wBTBCAFZZO6dAKlsf2Hqt7WNNnHxYRzy5g3hVrXxeRxWtNPoaSDV8dAON8eaetT9BpmLLnSaY3kVgF0ZcS2A9AzWc-Y0du';
//                    // rahman
//                    //$firbase_tocken = 'eyJyuB6DShm6gAxeyoy1Ve:APA91bE0fPMIRq-C3WTMHB1tBcCc1xuR8zsShq85IpV3u29JzbN9y3aql6c5vFJ_KwPYOm5DqJmnXuWGcGtcF6Z4teu7ta83-X7WpHgwhJA_4tqA5GTl4HEk-7dhG4vFyneZtLqoR-VR';
//                    $firebase = new \bc\components\GoogleFirebase($notification);
//                    $response = $firebase->send($firbase_tocken);
//
//                    $response_result = json_decode($response);
//                    $notification->cron_status = '1';
//                    $notification->send_count = ($notification->send_count + 1);
//                    $notification_model_detail = new NotificationLogFirebaseDetail();
//                    $notification_model_detail->notification_log_id = $notification->id;
//                    if ($response_result == null) {
//                        $notification->status = 0;
//                        $notification_model_detail->firebase_message = "No Token";
//                    } else {
//                        if ($response_result->success) {
//                            $notification->status = 1;
//                            $notification->send_datetime = new \yii\db\Expression('NOW()');
//                            $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
//                        } else {
//                            $notification->status = 0;
//                            $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
//                        }
//                    }
//                    $notification_model_detail->save();
//                    $notification->update();
//
////                    $model->viewtemp5 = 1;
////                    $model->update();
//                } catch (\Exception $ex) {
//                    
//                }
//            } else {
//                print_r($noti_log_model->getErrors());
//            }
//            //exit;
//        }
//    }

    public function actionSelectedacknoledge($division, $mod_value) {

        ini_set('memory_limit', '3072M');
        $models = SrlmBcApplication::find()->select('id')->andWhere(['=', 'form_number', '6'])->andWhere(['=', 'gender', '2'])->orderBy('id asc')->asArray()->all();

        foreach ($models as $model) {
            if ($model['id'] % $division == $mod_value) {
                
            } else {
                continue;
            }

            $model = SrlmBcApplication::findOne($model['id']);
            if ($model->status == SrlmBcApplication::STATUS_PROVISIONAL) {
                $template_model = NotificationTemplate::findOne(NotificationTemplate::PRESELECTED_ACKNOLEDGE_TEMPLATE_ID);
                $model->viewtemp1 = 1;
            } else {
                $template_model = NotificationTemplate::findOne(NotificationTemplate::STANDBY_ACKNOLEDGE_TEMPLATE_ID);
                $model->viewtemp2 = 1;
            }
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
                    // vikas
                    //$firbase_tocken='cOmoLqIsTDyAkpKNnvhDTo:APA91bF2Put4DmC-qc03dlfvGJL377DBad2iJnDbVRv8ryk3WXDkbi5dduARFWvOhXnqwTIDsOGUMVFGrvw4IlXNOYa1sh6qAIL4DgIKIUranOmBQVQrHulxsuvFj__pOpAO21SkUk_Q';
                    // rahman
                    //$firbase_tocken = 'eyJyuB6DShm6gAxeyoy1Ve:APA91bE0fPMIRq-C3WTMHB1tBcCc1xuR8zsShq85IpV3u29JzbN9y3aql6c5vFJ_KwPYOm5DqJmnXuWGcGtcF6Z4teu7ta83-X7WpHgwhJA_4tqA5GTl4HEk-7dhG4vFyneZtLqoR-VR';
                    $firebase = new \bc\components\GoogleFirebase($notification);
                    $response = $firebase->send($firbase_tocken);

                    $response_result = json_decode($response);
                    $notification->cron_status = '1';
                    $notification->send_count = ($notification->send_count + 1);
                    $notification_model_detail = new NotificationLogFirebaseDetail();
                    $notification_model_detail->notification_log_id = $notification->id;
                    if ($response_result == null) {
                        $notification->status = 0;
                        $notification_model_detail->firebase_message = "No Token";
                    } else {
                        if ($response_result->success) {
                            $notification->status = 1;
                            $notification->send_datetime = new \yii\db\Expression('NOW()');
                            $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
                        } else {
                            $notification->status = 0;
                            $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
                        }
                    }
                    $notification_model_detail->save();
                    $notification->update();

                    $model->update();
                } catch (\Exception $ex) {
                    
                }
            } else {
                print_r($noti_log_model->getErrors());
            }
        }
    }

    public function actionSelectedshortappupdateacknoledge() {
        ini_set('memory_limit', '3072M');
        $models = SrlmBcApplication::find()->select('id')->andWhere(['=', 'form_number', '6'])->andWhere(['=', 'gender', '2'])->asArray()->all();
        $template_model = NotificationTemplate::findOne(NotificationTemplate::APP_UPDATE_SHORT_ACKNOLEDGE_TEMPLATE_ID);
        foreach ($models as $model) {
            $model = SrlmBcApplication::findOne($model['id']);
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
                    // vikas
                    //$firbase_tocken='cOmoLqIsTDyAkpKNnvhDTo:APA91bF2Put4DmC-qc03dlfvGJL377DBad2iJnDbVRv8ryk3WXDkbi5dduARFWvOhXnqwTIDsOGUMVFGrvw4IlXNOYa1sh6qAIL4DgIKIUranOmBQVQrHulxsuvFj__pOpAO21SkUk_Q';
                    // rahman
                    //$firbase_tocken = 'eyJyuB6DShm6gAxeyoy1Ve:APA91bE0fPMIRq-C3WTMHB1tBcCc1xuR8zsShq85IpV3u29JzbN9y3aql6c5vFJ_KwPYOm5DqJmnXuWGcGtcF6Z4teu7ta83-X7WpHgwhJA_4tqA5GTl4HEk-7dhG4vFyneZtLqoR-VR';
                    $firebase = new \bc\components\GoogleFirebase($notification);
                    $response = $firebase->send($firbase_tocken);

                    $response_result = json_decode($response);
                    $notification->cron_status = '1';
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
                } catch (\Exception $ex) {
                    
                }
            } else {
                print_r($noti_log_model->getErrors());
            }
        }
    }

    public function actionSelectedshort1() {
        ini_set('memory_limit', '3072M');
        $models = SrlmBcApplication::find()->select('id')->andWhere(['=', 'form_number', '6'])->andWhere(['=', 'gender', '2'])->andWhere(['>', 'id', 54004])->limit(100000)->asArray()->all();
        $template_model = NotificationTemplate::findOne(NotificationTemplate::APP_UPDATE_SHORT_ACKNOLEDGE_TEMPLATE_ID);
        foreach ($models as $model) {
            $model = SrlmBcApplication::findOne($model['id']);
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
                    // vikas
                    //$firbase_tocken='cOmoLqIsTDyAkpKNnvhDTo:APA91bF2Put4DmC-qc03dlfvGJL377DBad2iJnDbVRv8ryk3WXDkbi5dduARFWvOhXnqwTIDsOGUMVFGrvw4IlXNOYa1sh6qAIL4DgIKIUranOmBQVQrHulxsuvFj__pOpAO21SkUk_Q';
                    // rahman
                    //$firbase_tocken = 'eyJyuB6DShm6gAxeyoy1Ve:APA91bE0fPMIRq-C3WTMHB1tBcCc1xuR8zsShq85IpV3u29JzbN9y3aql6c5vFJ_KwPYOm5DqJmnXuWGcGtcF6Z4teu7ta83-X7WpHgwhJA_4tqA5GTl4HEk-7dhG4vFyneZtLqoR-VR';
                    $firebase = new \bc\components\GoogleFirebase($notification);
                    $response = $firebase->send($firbase_tocken);

                    $response_result = json_decode($response);
                    $notification->cron_status = '1';
                    $notification->send_count = ($notification->send_count + 1);
                    $notification_model_detail = new NotificationLogFirebaseDetail();
                    $notification_model_detail->notification_log_id = $notification->id;
                    if ($response_result == null) {
                        $notification->status = 0;
                        $notification_model_detail->firebase_message = "No Token";
                    } else {
                        if ($response_result->success) {
                            $notification->status = 1;
                            $notification->send_datetime = new \yii\db\Expression('NOW()');
                            $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
                        } else {
                            $notification->status = 0;
                            $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
                        }
                    }
                    $notification_model_detail->save();
                    $notification->update();
                } catch (\Exception $ex) {
                    
                }
            } else {
                print_r($noti_log_model->getErrors());
            }
        }
    }

    public function actionSelectedshort2() {
        ini_set('memory_limit', '3072M');
        $models = SrlmBcApplication::find()->select('id')->andWhere(['=', 'form_number', '6'])->andWhere(['=', 'gender', '2'])->andWhere(['>', 'id', 154004])->limit(400000)->asArray()->all();
        $template_model = NotificationTemplate::findOne(NotificationTemplate::APP_UPDATE_SHORT_ACKNOLEDGE_TEMPLATE_ID);
        foreach ($models as $model) {
            $model = SrlmBcApplication::findOne($model['id']);
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
                    // vikas
                    //$firbase_tocken='cOmoLqIsTDyAkpKNnvhDTo:APA91bF2Put4DmC-qc03dlfvGJL377DBad2iJnDbVRv8ryk3WXDkbi5dduARFWvOhXnqwTIDsOGUMVFGrvw4IlXNOYa1sh6qAIL4DgIKIUranOmBQVQrHulxsuvFj__pOpAO21SkUk_Q';
                    // rahman
                    //$firbase_tocken = 'eyJyuB6DShm6gAxeyoy1Ve:APA91bE0fPMIRq-C3WTMHB1tBcCc1xuR8zsShq85IpV3u29JzbN9y3aql6c5vFJ_KwPYOm5DqJmnXuWGcGtcF6Z4teu7ta83-X7WpHgwhJA_4tqA5GTl4HEk-7dhG4vFyneZtLqoR-VR';
                    $firebase = new \bc\components\GoogleFirebase($notification);
                    $response = $firebase->send($firbase_tocken);

                    $response_result = json_decode($response);
                    $notification->cron_status = '1';
                    $notification->send_count = ($notification->send_count + 1);
                    $notification_model_detail = new NotificationLogFirebaseDetail();
                    $notification_model_detail->notification_log_id = $notification->id;
                    if ($response_result == null) {
                        $notification->status = 0;
                        $notification_model_detail->firebase_message = "No Token";
                    } else {
                        if ($response_result->success) {
                            $notification->status = 1;
                            $notification->send_datetime = new \yii\db\Expression('NOW()');
                            $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
                        } else {
                            $notification->status = 0;
                            $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
                        }
                    }
                    $notification_model_detail->save();
                    $notification->update();
                } catch (\Exception $ex) {
                    
                }
            } else {
                print_r($noti_log_model->getErrors());
            }
        }
    }

    public function actionTemplate4($division, $mod_value) {
        ini_set('memory_limit', '3072M');
        $models = SrlmBcApplication::find()->select('id')->andWhere(['=', 'form_number', '6'])->andWhere(['=', 'gender', '2'])->orderBy('id asc')->asArray()->all();
        $template_model = NotificationTemplate::findOne(NotificationTemplate::APP_UPDATE_SHORT_ACKNOLEDGE_TEMPLATE_ID);
        foreach ($models as $model) {
            if ($model['id'] % $division == $mod_value) {
                
            } else {
                continue;
            }
            $model = SrlmBcApplication::findOne($model['id']);
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
                    // vikas
                    //$firbase_tocken='cOmoLqIsTDyAkpKNnvhDTo:APA91bF2Put4DmC-qc03dlfvGJL377DBad2iJnDbVRv8ryk3WXDkbi5dduARFWvOhXnqwTIDsOGUMVFGrvw4IlXNOYa1sh6qAIL4DgIKIUranOmBQVQrHulxsuvFj__pOpAO21SkUk_Q';
                    // rahman
                    //$firbase_tocken = 'eyJyuB6DShm6gAxeyoy1Ve:APA91bE0fPMIRq-C3WTMHB1tBcCc1xuR8zsShq85IpV3u29JzbN9y3aql6c5vFJ_KwPYOm5DqJmnXuWGcGtcF6Z4teu7ta83-X7WpHgwhJA_4tqA5GTl4HEk-7dhG4vFyneZtLqoR-VR';
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
                } catch (\Exception $ex) {
                    
                }
            } else {
                print_r($noti_log_model->getErrors());
            }
        }
    }

    public function actionAllalongppupdateacknoledge() {
        ini_set('memory_limit', '3072M');
        $models = SrlmBcApplication::find()->select('id')->asArray()->all();
        $template_model = NotificationTemplate::findOne(NotificationTemplate::APP_UPDATE_ACKNOLEDGE_TEMPLATE_ID);
        foreach ($models as $model) {
            $model = SrlmBcApplication::findOne($model['id']);
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
                    // vikas
                    //$firbase_tocken='cOmoLqIsTDyAkpKNnvhDTo:APA91bF2Put4DmC-qc03dlfvGJL377DBad2iJnDbVRv8ryk3WXDkbi5dduARFWvOhXnqwTIDsOGUMVFGrvw4IlXNOYa1sh6qAIL4DgIKIUranOmBQVQrHulxsuvFj__pOpAO21SkUk_Q';
                    // rahman
                    //$firbase_tocken = 'eyJyuB6DShm6gAxeyoy1Ve:APA91bE0fPMIRq-C3WTMHB1tBcCc1xuR8zsShq85IpV3u29JzbN9y3aql6c5vFJ_KwPYOm5DqJmnXuWGcGtcF6Z4teu7ta83-X7WpHgwhJA_4tqA5GTl4HEk-7dhG4vFyneZtLqoR-VR';
                    $firebase = new \bc\components\GoogleFirebase($notification);
                    $response = $firebase->send($firbase_tocken);

                    $response_result = json_decode($response);
                    $notification->cron_status = '1';
                    $notification->send_count = ($notification->send_count + 1);
                    $notification_model_detail = new NotificationLogFirebaseDetail();
                    $notification_model_detail->notification_log_id = $notification->id;
                    if ($response_result == null) {
                        $notification->status = 0;
                        $notification_model_detail->firebase_message = "No Token";
                    } else {
                        if ($response_result->success) {
                            $notification->status = 1;
                            $notification->send_datetime = new \yii\db\Expression('NOW()');
                            $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
                        } else {
                            $notification->status = 0;
                            $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
                        }
                    }
                    $notification_model_detail->save();
                    $notification->update();
                } catch (\Exception $ex) {
                    
                }
            } else {
                print_r($noti_log_model->getErrors());
            }
        }
    }

    public function actionSendqueu() {
        $models = NotificationLog::find()->andWhere(['status' => 0])->limit($this->process_limit)->all();
        foreach ($models as $notification) {
            $firbase_tocken = $notification->bcuser->firebase_token;
            $firebase = new \bc\components\GoogleFirebase($notification);
            $response = $firebase->send($firbase_tocken);
            $response_result = json_decode($response);
            $notification->cron_status = '1';
            $notification->status = 1;
            $notification->send_datetime = new \yii\db\Expression('NOW()');
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
        }
    }

    public function actionViewtemp($temp_id) {
        $models = NotificationLog::find()->select(['detail_id', 'user_id'])->andWhere(['acknowledge_status' => 1, 'detail_id' => $temp_id])->all();
        foreach ($models as $notification) {
            $bcapp = SrlmBcApplication::find()->where(['srlm_bc_selection_user_id' => $notification->user_id])->one();
            if ($bcapp != null) {
                if ($notification->detail_id == 1) {
                    $bcapp->viewtemp1 = 2;
                }
                if ($notification->detail_id == 2) {
                    $bcapp->viewtemp2 = 2;
                }
                if ($notification->detail_id == 3) {
                    $bcapp->viewtemp3 = 2;
                }
                if ($notification->detail_id == 4) {
                    $bcapp->viewtemp4 = 2;
                }
                if ($notification->detail_id == 5) {
                    $bcapp->viewtemp5 = 2;
                }
                if ($notification->detail_id == 6) {
                    $bcapp->viewtemp6 = 2;
                }
                if ($notification->detail_id == 7) {
                    $bcapp->viewtemp7 = 2;
                }
                $bcapp->update(false);
            }
        }
    }

    public function actionView($division, $mod_value) {

        ini_set('memory_limit', '3072M');
        $models = SrlmBcApplication::find()->select('id')->andWhere(['=', 'form_number', '6'])->andWhere(['=', 'gender', '2'])->orderBy('id asc')->asArray()->all();

        foreach ($models as $model) {
            if ($model['id'] % $division == $mod_value) {
                
            } else {
                continue;
            }

            $modelbc = SrlmBcApplication::findOne($model['id']);
            $notifications = NotificationLog::find()->where(['user_id' => $modelbc->srlm_bc_selection_user_id])->all();
            foreach ($notifications as $noti) {
                if ($noti->detail_id == 1) {
                    $modelbc->viewtemp1 = 1;
                    if ($noti->acknowledge_status == 1) {
                        $modelbc->viewtemp1 = 2;
                    }
                }
                if ($noti->detail_id == 2) {
                    $modelbc->viewtemp2 = 1;
                    if ($noti->acknowledge_status == 1) {
                        $modelbc->viewtemp2 = 2;
                    }
                }
                if ($noti->detail_id == 3) {
                    $modelbc->viewtemp3 = 1;
                    if ($noti->acknowledge_status == 1) {
                        $modelbc->viewtemp3 = 2;
                    }
                }
                $modelbc->update();
            }
        }
    }

}
