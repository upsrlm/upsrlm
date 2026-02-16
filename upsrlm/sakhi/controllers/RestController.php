<?php

namespace sakhi\controllers;

use Yii;
use sizeg\jwt\Jwt;
use sizeg\jwt\JwtHttpBearerAuth;
use yii\rest\Controller;
use cbo\models\sakhi\RishtaApiLog;
use common\models\AppDetail;
use common\models\User;
use common\models\dynamicdb\cbo_detail\RishtaTempPhoto;

class RestController extends Controller {

    public $model_apilog;
    private $custom_response = [];
    public $app_id;
    public $user_id;
    public $php_input = [];
    public $gps;
    public $gps_accuracy;
    public $token;
    public $url;
    public $type;
    public $type_id;
    public $type_url;
    public $app_version;
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
            'optional' => [
                'login',
            ],
        ];

        return $behaviors;
    }

    public function actionBc() {
        $this->type = RishtaApiLog::TYPE_BC;
        $this->type_id = $_REQUEST['bcid'];
        $this->SetApiData();
        $this->saveApiInfo();
        $this->verifyandLogin();

        return $this->redirect([$this->url]);
    }

    public function actionShg() {
        $this->type = RishtaApiLog::TYPE_SHG;
        $this->type_id = $_REQUEST['shgid'];
        $this->SetApiData();
        $this->saveApiInfo();
        $this->verifyandLogin();
        return $this->redirect([$this->url]);
    }

    public function actionVo() {
        $this->type = RishtaApiLog::TYPE_VO;
        $this->type_id = $_REQUEST['void'];
        $this->SetApiData();
        $this->saveApiInfo();
        $this->verifyandLogin();

        return $this->redirect([$this->url]);
    }

    public function actionClf() {
        $this->type = RishtaApiLog::TYPE_CLF;
        $this->type_id = $_REQUEST['clfid'];
        $this->SetApiData();
        $this->saveApiInfo();
        $this->verifyandLogin();
        return $this->redirect([$this->url]);
    }
     public function actionHhs() {
        $this->type = RishtaApiLog::TYPE_HHS;
        $this->type_id = $_REQUEST['hhsid'];
        $this->SetApiData();
        $this->saveApiInfo();
        $this->verifyandLogin();
        return $this->redirect([$this->url]);
    }
    public function actionNotificationexternalurl() {
        $this->type = RishtaApiLog::TYPE_NOTIFICATION_EXTERNAL_URL;
        $this->type_id = $_REQUEST['notificationid'];
        $notification_model = \common\models\rishta\RishtaNotificationLog::findOne($this->type_id);
        \Yii::$app->user->login($notification_model->user, 3600);
        $this->SetApiData();
        $this->saveApiInfo();
        $this->verifyandLogin();
        $notification_model = \common\models\rishta\RishtaNotificationLog::findOne($this->type_id);
        if ($notification_model != null) {
            $notification_model->acknowledge_date = date('Y-m-d H:i:s ');
            $notification_model->acknowledge_status = 1;
            $notification_model->save();
        }
//        $req_dump = $this->url . json_encode($this->php_input);
//        $req_dump.=
//        $APPLICATION_FORM_FILE_FOLDER = \Yii::$app->params['datapath'] . 'app.log';
//        $fp = fopen($APPLICATION_FORM_FILE_FOLDER, 'a+');
//        fwrite($fp, $req_dump);
//        fclose($fp);
        if ($this->isAbsolute($this->url)) {
            return $this->redirect($this->url);
        } else {
            return $this->redirect([$this->url]);
        }
    }

    public function actionNotificationacknowledgementurl() {
        $this->type = RishtaApiLog::TYPE_NOTIFICATION_ACKNOWLEDGEMENT_URL;
        $this->type_id = $_REQUEST['notificationid'];
        $this->SetApiData();
        $this->saveApiInfo();
        $this->verifyandLogin();
        $notification_model = \common\models\rishta\RishtaNotificationLog::findOne($this->type_id);
        if ($notification_model != null) {
            $notification_model->acknowledge_date = date('Y-m-d H:i:s ');
            $notification_model->acknowledge_status = 1;
            $notification_model->save();
        }
    }

    public function actionPage() {
        $this->type = RishtaApiLog::TYPE_STATIC_PAGE;
        $this->type_id = 0;
        $this->SetApiData();
        $this->saveApiInfo();
        $this->verifyandLogin();

        return $this->redirect([$this->url]);
    }

    public function actionUploadimage($userid = 0) {
        $this->type = RishtaApiLog::TYPE_USER;
        $this->type_id = $userid;
        $this->SetApiData();
        //$this->saveApiInfo();
        $this->verifyandLogin();
        $m = new RishtaTempPhoto();
        $m->file_id = $_REQUEST['file_id'];

        $APPLICATION_FORM_FILE_FOLDER = Yii::$app->params['datapath'] . 'tmp';
        if (!file_exists($APPLICATION_FORM_FILE_FOLDER)) {
            mkdir($APPLICATION_FORM_FILE_FOLDER);
            chmod($APPLICATION_FORM_FILE_FOLDER, 0777);
        }
        if (isset($_FILES['file'])) {
            $new_file_name = bin2hex(random_bytes(10)) . time() . basename($_FILES['file']['name']);
            $target_path = $APPLICATION_FORM_FILE_FOLDER . "/" . $new_file_name;
            if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
                chmod($target_path, 0777);
                $m->file_name = $new_file_name;
                $m->save();
                $this->custom_response['status'] = 1;
            }
        } else {
            $this->custom_response['status'] = 0;
        }


        return $this->asJson($this->custom_response);
    }

    public function actionImage($userid, $photo) {
        $this->type = RishtaApiLog::TYPE_USER;
        $this->type_id = $userid;
        $this->SetApiData();
        $this->saveApiInfo();
        $this->verifyandLogin();
        $app_user = \common\models\CboMemberProfile::findOne(['user_id' => \Yii::$app->user->identity->id]);
        $photo_name = $photo;
        $APPLICATION_FORM_FILE_FOLDER = Yii::$app->params['datapath'];
        $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "cbo/user/";

        $photo = $APPLICATION_FORM_FILE_FOLDER . $app_user->user_id . "/" . $app_user->$photo_name;

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
//            ob_end_flush();
//            header("Content-type: $mimetype");
//            \Yii::$app->response->format = yii\web\Response::FORMAT_RAW;
//            \Yii::$app->response->headers->set('Content-Type', $mimetype);
            return Yii::$app->response->sendFile($photo);
            die();
        } else {
            throw new \yii\web\NotFoundHttpException("Request URL not Found"); //error 404
        }
    }

    public function actionUser() {
        $this->type = RishtaApiLog::TYPE_USER;
        $this->type_id = $_REQUEST['userid'];
        $this->SetApiData();
        $this->saveApiInfo();
        $this->verifyandLogin();

        return $this->redirect([$this->url]);
    }

    public function actionApp() {
        $this->type = RishtaApiLog::TYPE_APP;
        $this->type_id = $_REQUEST['notificationid'];
//        echo "<pre>";
//        print_r(Yii::$app->user->identity->rishtauserdata->menu_json);exit;
        $this->SetApiData();
        $this->saveApiInfo();
        $this->verifyandLogin();

        $this->custom_response['splash_screen'] = \Yii::$app->user->identity->splash_screen;
        $this->custom_response['splash_screen_value'] = isset(\Yii::$app->user->identity->rishtauserdata) ? \Yii::$app->user->identity->rishtauserdata->splash_screen_value : "";
        $this->custom_response['menu_version'] = \Yii::$app->user->identity->menu_version;
        $this->custom_response['cbo_menu'] = isset(\Yii::$app->user->identity->rishtauserdata) ? json_decode(\Yii::$app->user->identity->rishtauserdata->menu_json, true) : [];
        $user_model = \Yii::$app->user->identity;
        $user_model->user_app_data_update = 0;
        $user_model->save();

        $notification_model = \common\models\rishta\RishtaNotificationLog::findOne($this->type_id);
        if ($notification_model != null) {
            $notification_model->acknowledge_date = date('Y-m-d H:i:s ');
            $notification_model->acknowledge_status = 1;
            $notification_model->save();
        }
        return $this->asJson($this->custom_response);
    }

    public function actionGetnotification() {
        $this->type = RishtaApiLog::TYPE_GET_NOTIFICATION;
        $this->type_id = $_REQUEST['last_notificationid'];
        $this->SetApiData();
        $this->saveApiInfo();
        $this->verifyandLogin();
        $this->custom_response['notification_list'] = $this->getNotification($this);

        return $this->asJson($this->custom_response);
    }

    public function SetApiData() {
        $this->php_input = $_REQUEST;
        if (isset(\Yii::$app->request->headers['authorization'])) {
            $this->token = isset(explode(' ', \Yii::$app->request->headers['authorization'])[1]) ? explode(' ', \Yii::$app->request->headers['authorization'])[1] : '';
            $this->php_input['token'] = $this->token;
        }
        if (isset(\Yii::$app->request->headers['gps'])) {
            $this->gps = \Yii::$app->request->headers['gps'];
            $this->php_input['gps'] = $this->gps;
        }
        if (isset(\Yii::$app->request->headers['gps_accuracy'])) {
            $this->gps_accuracy = \Yii::$app->request->headers['gps_accuracy'];
            $this->php_input['gps_accuracy'] = $this->gps_accuracy;
        }
        if (isset($this->php_input['url'])) {
            $this->url = $this->php_input['url'];
            $type_url = explode('?', $this->url);
            $this->type_url = rtrim($type_url[0], '/');
        }

        if (isset($this->php_input['app_version'])) {
            $this->app_version = $this->php_input['app_version'];
        }
        if (isset($this->php_input['wadaid'])) {
            $this->url = $this->url.'&wadaid='.$this->php_input['wadaid'];
        }
    }

    private function saveApiInfo() {
        $app = Yii::$app;
        $this->model_apilog = new RishtaApiLog();

        $this->model_apilog->user_id = isset(\Yii::$app->user->identity) ? (int) Yii::$app->user->identity->id : 0;
        if (isset(\Yii::$app->user->identity))
            $this->model_apilog->app_version = \Yii::$app->user->identity->app_version;
        $this->model_apilog->type = $this->type;
        $this->model_apilog->type_id = $this->type_id;
        $this->model_apilog->type_url = $this->type_url;
        $this->model_apilog->created_at = time();
        $this->model_apilog->status = 1;
        if ($this->model_apilog->save(false)) {
            
        } else {

            throw new \yii\web\ServerErrorHttpException('Api info log save error. ' . json_encode($this->model_apilog->getErrors()));
        }
//        print_r($this->model_apilog);exit;
        return $this;
    }

    private function verifyandLogin() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (isset(Yii::$app->user->identity->id)) {
            $user = User::findOne(['id' => Yii::$app->user->identity->id]);
            if ($user->status != User::STATUS_ACTIVE) {
                throw new \yii\web\UnauthorizedHttpException("Unauthorized.");
            }
            if (!in_array($this->type, [RishtaApiLog::TYPE_APP])) {
                if (Yii::$app->user->identity->user_app_data_update) {
                    $app = AppDetail::findOne(['token' => $this->token, 'status' => 1]);
                    if ($app == null) {
                        $app->date_of_uninstall = date('Y-m-d H:i:s');
                        $app->status = 0;
                        $app->save();
                    }
                    throw new \yii\web\UnauthorizedHttpException("Unauthorized.");
                }
            }
            // second check app is active or not 
            $app_model = AppDetail::findOne(['token' => $this->token, 'status' => 1]);
            if ($app_model == null) {
                throw new \yii\web\UnauthorizedHttpException("Unauthorized.");
            }
            $user->last_access_time = date('Y-m-d H:i:s');
            $user->save();
        }
    }

    public function getNotification($model) {
        if (isset(Yii::$app->user->identity)) {
            $user_id = Yii::$app->user->identity->id;
        } else {
            $user_id = 0;
        }
        $sql = "SELECT  a.id as message_id ,a.message_title as title,message,visible,external_url,genrated_on
           FROM    rishta_notification_log a
		
             where a.user_id=" . $user_id . ' and visible=1 and a.id <=' . $this->type_id . ' limit 10';
//        echo $sql;
        return \common\models\rishta\RishtaNotificationLog::findBySql($sql)->asArray()->all();
    }

    public function isAbsolute($url) {
        return isset(parse_url($url)['host']);
    }

}
