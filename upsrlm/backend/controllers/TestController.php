<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\rishta\RishtaNotificationLog;
use common\models\rishta\RishtaNotificationLogFirebaseDetail;
use common\models\rishta\RishtaNotificationTemplate;
use bc\models\NotificationLog;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

/**
 * TestController implements the CRUD actions for User model.
 */
class TestController extends Controller {

    public $options = [];

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $date = '2112-01-01 12:12:12';
        $r = \common\helpers\Utility::validateDateFormat($date);
        echo $r;exit;
        echo \common\helpers\Utility::maskaadhar('783827527211');
        $m = \common\models\dynamicdb\internalcallcenter\platform\MissedCall::find()->andWhere(['customernumber' => '8755055791', 'click' => 1])->orderBy(['api_request_datetime' => SORT_DESC])->limit(1)->one();
        if ($m != null) {
            $m->click = 0;
            $m->save();
            echo 'rahman';
        }
        echo date("Y-m-d H:i:s", 1678991341) . '<br/>';
        echo date("Y-m-d H:i:s", 1678967581) . '<br/>';
        echo date("Y-m-d H:i:s", 1678991341) . '<br/>';
        echo date("Y-m-d H:i:s", 1678985581) . '<br/>';

//        $models = \common\models\dynamicdb\mopup\MopupSmsLog::find()->limit(10)->all();
//        foreach ($models as $md) {
//            $md->update();
//            echo $md->id.PHP_EOL;
//        }
    }

//     public function actionSms() {
//        $sms= new \common\components\Sms();
//        $sms->Sendmopuppin('19852');
//        
//    }
//    public function actionApp($user_id) {
//        $app_details = \common\models\AppDetail::find()->joinWith(['user'])->where(['app_detail.status' => 1])->andWhere(['user.user_app_data_update' => 1])->all();
//        $user_model = User::findOne($user_id);
//        $rista = new \sakhi\components\Rishta($user_model);
//        $tempplate_model = \common\models\rishta\RishtaNotificationTemplate::findOne(\common\models\rishta\RishtaNotificationTemplate::APP_DATA_UPDATE_TEMP_ID);
//        $noti_log_model = new \common\models\rishta\RishtaNotificationLog();
//        $noti_log_model->user_id = $user_model->id;
//        $noti_log_model->app_id = $user_model->app_id;
//        $noti_log_model->visible = $tempplate_model->visible;
//        $noti_log_model->acknowledge = $tempplate_model->acknowledge;
//        $noti_log_model->message_title = $tempplate_model->name;
//        $noti_log_model->message = $tempplate_model->template;
//        $noti_log_model->notification_template_id = $tempplate_model->id;
//        $noti_log_model->cron_status = 0;
//        $noti_log_model->status = 0;
//        $noti_log_model->genrated_on = new \yii\db\Expression('NOW()');
//        if ($noti_log_model->save()) {
//            try {
//                $notification = \common\models\rishta\RishtaNotificationLog::findOne($noti_log_model->id);
//                $firbase_tocken = $user_model->firebase_token;
//                $firebase = new \common\components\GoogleFirebaseRishta($notification);
//                $response = $firebase->send($firbase_tocken);
//                $response_result = json_decode($response);
//                $notification->cron_status = '1';
//                $notification->send_count = ($notification->send_count + 1);
//                $notification_model_detail = new \common\models\rishta\RishtaNotificationLogFirebaseDetail();
//                $notification_model_detail->notification_log_id = $notification->id;
//                if ($response_result == null) {
//                    $notification->status = -1;
//                    $notification_model_detail->firebase_message = "No Token";
//                } else {
//                    if ($response_result->success) {
//                        $notification->status = 1;
//                        $notification->send_datetime = new \yii\db\Expression('NOW()');
//                        $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
//                    } else {
//                        $notification->status = 2;
//                        $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
//                    }
//                }
//                $notification_model_detail->save();
//                $notification->update();
//            } catch (\Exception $ex) {
//                
//            }
//        }
//    }
//
//    public function actionAckno($user_id) {
//        $app_details = \common\models\AppDetail::find()->joinWith(['user'])->where(['app_detail.status' => 1])->andWhere(['user.user_app_data_update' => 1])->all();
//        $user_model = User::findOne($user_id);
//        $rista = new \sakhi\components\Rishta($user_model);
//        $tempplate_model = \common\models\rishta\RishtaNotificationTemplate::findOne(\common\models\rishta\RishtaNotificationTemplate::APP_DATA_UPDATE_TEMP_ID);
//        $noti_log_model = new \common\models\rishta\RishtaNotificationLog();
//        $noti_log_model->user_id = $user_model->id;
//        $noti_log_model->app_id = $user_model->app_id;
//        $noti_log_model->visible = 1;
//        $noti_log_model->acknowledge = 1;
//        $noti_log_model->message_title = 'परिचय– वादा सखी ';
//        $noti_log_model->message = 'राज्य ग्रामीण आजीविका मिशन के अंतर्गत स्वयं सहायता समूहों के माध्यम से गाँव के सबसे गरीब परिवारों को सरकार द्वारा कुछ विशिष्ट संस्थागत/ स्कीम-आधारित सुविधाएँ देने का प्रावधान है, जिसमें ऋण, आजीविका से जुड़े मदद तथा प्रशिक्षण/ सक्षमता विकास प्रमुख हैं  । इस से अलग, राज्य व केंद्र सरकार के अनेकों विभाग व कार्यक्रमों के मुख्य उद्धेश्य है कि योजनाओं के माध्यम से गरीब परिबरों तक विभिन्न प्रकार के सुविधाएँ प्रदान की जाएँ, जिनमे स्वास्थ्य, शिक्षा, खाद्य व पौष्टिक आहार, सामाजिक सुरक्षा, महिला, सामाजिक व श्रमिक कल्याण के पेन्शन इत्यादि प्रमुख हैं । ऐसी संभावना है कि स्वयं सहायता समूह के मध्य, विशेष सामुदायिक काडर की तैनाती पर विचार किया जाए जो मूल रूप से ऐसी सभी सेवाओं के मोबलिज़ेशन के लिए क्रियाशील होंगी । उन्हें डिजिटल टेक्नॉलजी के ज़रूरी आयामों पर प्रशिक्षित कर ऐसी सेवाओं से समूहों के सभी पात्र सदस्यों को लाभ पहुँचाना सूनिश्चित किया जाए ।';
//        $noti_log_model->notification_template_id = 2;
//        $noti_log_model->cron_status = 0;
//        $noti_log_model->status = 0;
//        $noti_log_model->genrated_on = new \yii\db\Expression('NOW()');
//        if ($noti_log_model->save()) {
//            try {
//                $notification = \common\models\rishta\RishtaNotificationLog::findOne($noti_log_model->id);
//                $firbase_tocken = $user_model->firebase_token;
//                $firebase = new \common\components\GoogleFirebaseRishta($notification);
//                $response = $firebase->send($firbase_tocken);
//                $response_result = json_decode($response);
//                $notification->cron_status = '1';
//                $notification->send_count = ($notification->send_count + 1);
//                $notification_model_detail = new \common\models\rishta\RishtaNotificationLogFirebaseDetail();
//                $notification_model_detail->notification_log_id = $notification->id;
//                if ($response_result == null) {
//                    $notification->status = -1;
//                    $notification_model_detail->firebase_message = "No Token";
//                } else {
//                    if ($response_result->success) {
//                        $notification->status = 1;
//                        $notification->send_datetime = new \yii\db\Expression('NOW()');
//                        $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
//                    } else {
//                        $notification->status = 2;
//                        $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
//                    }
//                }
//                $notification_model_detail->save();
//                $notification->update();
//            } catch (\Exception $ex) {
//                
//            }
//        }
//    }
//
//    public function actionExternalurl($user_id) {
//        $app_details = \common\models\AppDetail::find()->joinWith(['user'])->where(['app_detail.status' => 1])->andWhere(['user.user_app_data_update' => 1])->all();
//        $user_model = User::findOne($user_id);
//        $rista = new \sakhi\components\Rishta($user_model);
//        $tempplate_model = \common\models\rishta\RishtaNotificationTemplate::findOne(\common\models\rishta\RishtaNotificationTemplate::APP_DATA_UPDATE_TEMP_ID);
//        $noti_log_model = new \common\models\rishta\RishtaNotificationLog();
//        $noti_log_model->user_id = $user_model->id;
//        $noti_log_model->app_id = $user_model->app_id;
//        $noti_log_model->visible = 1;
//        $noti_log_model->acknowledge = 1;
//        $noti_log_model->message_title = 'कौन आवेदन कर सकते हैं ';
//        $noti_log_model->message = 'हर समूह से ऐसा कोई एक सदस्य आवेदन कर सकते हैं, जिनके वादा सखी होने के योग्यता पर सभी अन्य सदस्यों को भरोसा व सहमति हो । एक वादा सखी को लगभग 20-25 समूहों के सदस्यों को, यानी कि लगभग 250-300 समूह सदस्यों को स्वयं से जोड़ कर कार्य करना होगा । सखी को 2 से 3 ग्राम पंचायतों में भ्रमण करना पड़ सकता है, और कभी कभी ब्लॉक ऑफ़िस भी जाना पड़ सकता है । इसलिए ये आवश्यक है वे भ्रमण के लिए व पूरा समय देने के लिए तैयार हों । हर समूह अपने सखी के उमीदवार के चयन में इन बातों का ध्यान रखें ।';
//        $noti_log_model->notification_template_id = 3;
//        $noti_log_model->external_url = \Yii::$app->params['app_url']['sakhi'] . '/rest/notificationexternalurl?notificationid=';
//        $noti_log_model->cron_status = 0;
//        $noti_log_model->status = 0;
//        $noti_log_model->genrated_on = new \yii\db\Expression('NOW()');
//        if ($noti_log_model->save()) {
//            try {
//                $noti_log_model->external_url = \Yii::$app->params['app_url']['sakhi'] . '/rest/notificationexternalurl?notificationid=' . $noti_log_model->id . '&url=/shg/application/form?shgid=341739';
//                $noti_log_model->update();
//                $notification = \common\models\rishta\RishtaNotificationLog::findOne($noti_log_model->id);
//                $firbase_tocken = $user_model->firebase_token;
//                $firebase = new \common\components\GoogleFirebaseRishta($notification);
//                $response = $firebase->send($firbase_tocken);
//                $response_result = json_decode($response);
//                $notification->cron_status = '1';
//                $notification->send_count = ($notification->send_count + 1);
//                $notification_model_detail = new \common\models\rishta\RishtaNotificationLogFirebaseDetail();
//                $notification_model_detail->notification_log_id = $notification->id;
//                if ($response_result == null) {
//                    $notification->status = -1;
//                    $notification_model_detail->firebase_message = "No Token";
//                } else {
//                    if ($response_result->success) {
//                        $notification->status = 1;
//                        $notification->send_datetime = new \yii\db\Expression('NOW()');
//                        $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
//                    } else {
//                        $notification->status = 2;
//                        $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
//                    }
//                }
//                $notification_model_detail->save();
//                $notification->update();
//            } catch (\Exception $ex) {
//                
//            }
//        }
//    }
    public function actionAckno($user_id) {

        $user_model = User::findOne($user_id);

        $noti_log_model = new \common\models\dynamicdb\mopup\MopupNotificationLog();
        $noti_log_model->user_id = $user_model->id;
        $noti_log_model->app_id = $user_model->mopup_app_id;
        $noti_log_model->visible = 1;
        $noti_log_model->acknowledge = 1;
        $noti_log_model->message_title = 'यूजर ऐड: निर्धनतम परिवारों की पहचान करने के लिए निम्न को यूजर ऐड करें ';
        $noti_log_model->message = 'प्रति ग्राम पंचायत निर्धनतम परिवारों की पहचान किए जाने की संख्या: 10 से 25.प्रति ग्राम पंचायत निर्धनतम परिवारों की पहचान किए जाने की संख्या: 10 से 25';
        $noti_log_model->notification_template_id = 200;
        $noti_log_model->cron_status = 0;
        $noti_log_model->status = 0;
        $noti_log_model->genrated_on = new \yii\db\Expression('NOW()');
        if ($noti_log_model->save()) {
            try {
                $notification = \common\models\dynamicdb\mopup\MopupNotificationLog::findOne($noti_log_model->id);
                $firbase_tocken = $user_model->mopup_firebase_token;
                $firebase = new \common\components\GoogleFirebaseMopup($notification);
                $response = $firebase->send($firbase_tocken);
                $response_result = json_decode($response);
                $notification->cron_status = '1';
                $notification->send_count = ($notification->send_count + 1);
                $notification_model_detail = new \common\models\dynamicdb\mopup\MopupNotificationLogFirebaseDetail();
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
        }
    }

    public function actionExternalurl($user_id) {
        $app_details = \common\models\AppDetail::find()->joinWith(['user'])->where(['app_detail.status' => 1])->andWhere(['user.user_app_data_update' => 1])->all();
        $user_model = User::findOne($user_id);
        $rista = new \sakhi\components\Rishta($user_model);
        $tempplate_model = \common\models\rishta\RishtaNotificationTemplate::findOne(\common\models\rishta\RishtaNotificationTemplate::APP_DATA_UPDATE_TEMP_ID);
        $noti_log_model = new \common\models\rishta\RishtaNotificationLog();
        $noti_log_model->user_id = $user_model->id;
        $noti_log_model->app_id = $user_model->app_id;
        $noti_log_model->visible = 1;
        $noti_log_model->acknowledge = 1;
        $noti_log_model->message_title = 'कौन आवेदन कर सकते हैं ';
        $noti_log_model->message = 'हर समूह से ऐसा कोई एक सदस्य आवेदन कर सकते हैं, जिनके वादा सखी होने के योग्यता पर सभी अन्य सदस्यों को भरोसा व सहमति हो । एक वादा सखी को लगभग 20-25 समूहों के सदस्यों को, यानी कि लगभग 250-300 समूह सदस्यों को स्वयं से जोड़ कर कार्य करना होगा । सखी को 2 से 3 ग्राम पंचायतों में भ्रमण करना पड़ सकता है, और कभी कभी ब्लॉक ऑफ़िस भी जाना पड़ सकता है । इसलिए ये आवश्यक है वे भ्रमण के लिए व पूरा समय देने के लिए तैयार हों । हर समूह अपने सखी के उमीदवार के चयन में इन बातों का ध्यान रखें ।';
        $noti_log_model->notification_template_id = 3;
        $noti_log_model->external_url = \Yii::$app->params['app_url']['sakhi'] . '/rest/notificationexternalurl?notificationid=';
        $noti_log_model->cron_status = 0;
        $noti_log_model->status = 0;
        $noti_log_model->genrated_on = new \yii\db\Expression('NOW()');
        if ($noti_log_model->save()) {
            try {
                $noti_log_model->external_url = \Yii::$app->params['app_url']['sakhi'] . '/rest/notificationexternalurl?notificationid=' . $noti_log_model->id . '&url=/shg/application/form?shgid=341739';
                $noti_log_model->update();
                $notification = \common\models\rishta\RishtaNotificationLog::findOne($noti_log_model->id);
                $firbase_tocken = $user_model->firebase_token;
                $firebase = new \common\components\GoogleFirebaseRishta($notification);
                $response = $firebase->send($firbase_tocken);
                $response_result = json_decode($response);
                $notification->cron_status = '1';
                $notification->send_count = ($notification->send_count + 1);
                $notification_model_detail = new \common\models\rishta\RishtaNotificationLogFirebaseDetail();
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
        }
    }

    public function actionNoti() {
        $model = \bc\modules\selection\models\SrlmBcApplication::findOne(2);
        $template_model = \bc\models\NotificationTemplate::findOne(\bc\models\NotificationTemplate::RISHTA_CALL_CENTER_TEMPLATE_ID_14);
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
            $notification = \bc\models\NotificationLog::findOne($noti_log_model->id);
            $firbase_tocken = "fWSWqvvmTNeHdhOgG1BPav:APA91bF3Uh0ps2BBeFrFkzi2PiEtU1CkgOgqTprQ1neCVyT4eKPdOBElmHEpzjvx-D80_J4W2-m6GV2tzWDg4gbyTMGBVPLmvfMOiuOcaiWEBs8vHaQDcabgbGc1shh1CLjzdXhGdrMj";

            $firebase = new \bc\components\GoogleFirebase($notification);
            $response = $firebase->send($firbase_tocken);

            $response_result = json_decode($response);
            print_r($response_result);
            exit;
        }
    }

    public function actionTel() {
        $models = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::find()->all();
        foreach ($models as $model) {
            $model->save();
        }
    }

    public function actionUpload($srlm_user_id) {

        $upload = new \common\helpers\FileHelpers();
        $upload->file_name = 'passbook_photo_1624046794_IMG_20210619_013547679.jpg';
        $upload->file_path = '/home/rahman/website/upsrlm-bc-data/bcselection/bcprofile/2/shg';

        $upload->upload();
    }

    public function actionCheck() {

        $upload = new \common\helpers\FileHelpers();
        $upload->file_name = 'passbook_photo_1624046794_IMG_20210619_013547679.jpg';
        $upload->file_path = '/home/rahman/website/upsrlm-bc-data/bcselection/bcprofile/2/shg';
        $upload->check();
    }

    public function actionAd() {
        ini_set('memory_limit', '-1');
        $aws = \Yii::$app->get('aws');
        $s3 = new \common\components\aws\AwsS3();
        $obj = $aws->getS3Client();
        $cmd = $obj->getCommand('GetObject', [
            'Bucket' => $aws->bucket,
            'Key' => '/callrecord/202204/l2l0qn2o165132607181316427_7817986594_2022-4-30-19-11-29_CTC.mp3'
        ]);
        echo "<pre>";
        echo print_r($cmd);
        exit;
        $url = \Aws\serialize($cmd)->getUri();
        $my_file_name = 'aud.mp3';
        header('Content-Description: File Transfer');
        //this assumes content type is set when uploading the file.
        header('Content-Type: ' . $cmd->ContentType);
        header('Content-Disposition: attachment; filename=' . $my_file_name);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        //send file to browser for download. 
        echo $cmd->body;
        exit;
    }

    public function actionAwsimage() {
//        $string='/home/upsrlm/callrecord/202205';
//        $pieces = explode("/home/upsrlm", $string);
//        print_r($pieces);
//        $date = new \DateTime('now');
//        $date->modify('-3 month'); 
//        $date = $date->format('Ym');
//        echo $date;
//        exit;
        $aws = \Yii::$app->get('aws');
        $s3 = new \common\components\aws\AwsS3();
        $obj = $aws->getS3Client();
//        $cmd = $obj->getCommand('GetObject', [
//            'Bucket' => $aws->bucket,
//            'Key' => 'cbo/clf/1/clf baghi.jpg2021_01_13_14-01-16.jpg'
//        ]);
//
//        $request = $obj->createPresignedRequest($cmd, '+20 minutes');
// Get the actual presigned-url
        // $presignedUrl = (string) $request->getUri();
        $presignedUrl = $obj->getObjectUrl($aws->bucket, 'cbo/clf/1/clf baghi.jpg2021_01_13_14-01-16.jpg');
//        try {
//        $result = $obj->createBucket([
//            'Bucket' => 'upsrlm-data-demo2',
//        ]);
//        
//    } catch (\AwsException $e) {
//        return 'Error: ' . $e->getAwsErrorMessage();
//    }
//        $buckets = $obj->listBuckets();
//        
//        foreach ($buckets['Buckets'] as $bucket) {
//            echo $bucket['Name'] . "\n";
//        }
//        
//        exit;
//        $s3->key = $aws->key;
//        $s3->secret = $aws->secret;
//        $s3->bucket = $aws->bucket;
//        $s3->region = $aws->region;
//        $s3->version = $aws->version;
//        try {
//            // Get the object.
//            $obj = $s3->getS3Client();
//            $result = $obj->getObject([
//                'Bucket' => $aws->bucket,
//                'Key' => 'bankstatement.jpg'
//            ]);
//
//            // Display the object in the browser.
//            header("Content-Type: {$result['ContentType']}");
//            echo $result['Body'];
//        } catch (S3Exception $e) {
//            echo $e->getMessage() . PHP_EOL;
//        }
//        $file_name = 'bankstatement.jpg';
//
//        try {
//            $response = $s3->getObjectUrl($file_name);
//
        return $this->render('/site/index', ['imgsrc' => $presignedUrl]);
//        } catch (\Aws\S3\Exception\S3Exception $e) {
//            echo "There was an error uploading the file.\n";
////                    echo $e->getMessage();
//        }
    }

    public function actionSmsbc() {
//        $otp_sms_log_model = new \bc\modules\selection\models\SmsLog();
//        $otp_sms_log_model->mobile_no = '7838275272';
//        $otp_sms_log_model->imei_no = 'test';
//        $otp_sms_log_model->os_type = 'test';
//        $otp_sms_log_model->manufacturer_name = 'test';
//        $otp_sms_log_model->os_version = 'test';
//        $otp_sms_log_model->app_version = '2.62';
//        $otp_sms_log_model->firebase_token = '';
//        $otp_sms_log_model->time = new \yii\db\Expression('NOW()');
//
//        $otp_sms_log_model->otp = \common\helpers\Utility::generateNumericOTP(6);
//
//        $this->options['Message'] = \common\components\sms\Smslanev2::sms_content(['otp' => $otp_sms_log_model->otp], \common\components\sms\Smslanev2::TYPE_SMS_BC_OTP);
//        $msisdn = '';
//        if (strlen($otp_sms_log_model->mobile_no) == 10)
//            $msisdn = '91';
//        $msisdn .= $otp_sms_log_model->mobile_no;
//        $this->options['MobileNumbers'] = $msisdn;
//        $sms_lane = new \common\components\sms\Smslanev2($this->options);
//
//        $sms = $sms_lane->SendSMS(\common\components\sms\Smslanev2::SENDAR_OTP);
//        echo "<pre>";
//        print_r($sms);
    }

    public function actionSmsbctli() {
//        $this->options['sms'] = \common\components\sms\Smstriline::sms_content(['otp' => 123456], \common\components\sms\Smstriline::BC_SAKHI_OTP_TEMPLATE_ID);
//        $this->options['templateid']=\common\components\sms\Smstriline::BC_SAKHI_OTP_TEMPLATE_ID;
//        $this->options['number']='7838275272';
//        $sms = new \common\components\sms\Smstriline($this->options);
//        $sms->enableSendSms=1;
//        print_r($sms->SendSMS());
    }

    public function actionTestibd($ibd_id) {
        $model = \common\models\dynamicdb\internalcallcenter\CloudTeleIbdLog::findOne($ibd_id);
        if ($model != null) {
            $model->updated_at = time();
            $model->save();
        }
    }

    function actionTestdel($id) {
        $model = \common\models\dynamicdb\mopup\MopupSmsLog::findOne($id);
        $sarve = new \common\components\sms\Smssarv();
        $sarve->options = ['message_id' => $model->sms_provider_message_id];
        $data = $sarve->Smsstatus();
        print_r($data);
        exit;
    }

    function actionTestdelr($id) {
        $model = \common\models\rishta\RishtaSmsLog::findOne($id);
        $sarve = new \common\components\sms\Smssarv();
        $sarve->options = ['message_id' => $model->sms_provider_message_id];
        $data = $sarve->Smsstatus();
        print_r($data);
        exit;
    }
}
