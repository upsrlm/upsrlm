<?php

namespace sakhi\modules\api\v1;

use Yii;
use yii\web\Response;
use yii\db\Expression;
use yii\base\ActionEvent;
use yii\base\Application;
use common\models\ApiLog;
use common\models\AppDetail;
use common\models\User;

/**
 * api module definition class
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class Module extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'sakhi\modules\api\v1\controllers';

    /**
     * @var \app\models\ApiLog
     */
    public $model_apilog;

    /**
     * @var JSON Ojbect of PHP input 
     */
    public $post_json;

    /**
     * @var JSON Ojbect of PHP input 
     */
    public $data_json;

    /**
     * @var JSON Ojbect of PHP input 
     */
    public $app_id;

    /**
     * @var JSON Ojbect of PHP input 
     */
    public $user_id;

    /**
     * @var JSON Ojbect of PHP input 
     */
    public $org_id;

    /**
     * @var PHP input Ojbect 
     */
    public $php_input;
    public $file_input;
    public $otp_url = 'api/v1/user/otp';
    public $beforelogindata_url = 'api/v1/user/beforelogindata';

    /**
     *
     * @var type 
     */
    public $api_urls = [
        'api/v1/user/login', //Done
        'api/v1/user/beforelogindata', //Done
        'cbo/v1/user/updategoogletoken', //Done
    ];

    /**
     *
     * @var type 
     */
    public $login_url = 'api/v1/user/login';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        $app = Yii::$app;
        $app->on(Application::EVENT_BEFORE_ACTION, [$this, 'onBeforeAction']);

        $app->request->enableCsrfValidation = false;

        $app->response->on(Response::EVENT_BEFORE_SEND, [$this, 'onBeforeSend']);
        $app->response->format = \yii\web\Response::FORMAT_JSON;

        $app->response->headers->add('Access-Control-Allow-Origin', '*');
    }

    public function onBeforeAction($event) {
        $this->file_input = $_FILES;
        $this->php_input = \Yii::$app->request->post(); //file_get_contents("php://input");
//        print_r($this->php_input['imei_no']);exit;
        if (isset($this->php_input['data'])) {
            
        } else {
            $this->php_input['data'] = "";
        }
        $this->post_json = json_decode($this->php_input['data'], true);
        //print_r($_REQUEST); exit;
        $this->data_json = $this->post_json;
        $this->saveApiInfo()->verifyandLogin();
    }

    public function onBeforeSend($event) {

        $response = $event->sender;

        if ($response->statusCode == 200) {
            $this->model_apilog->response = $response->data['message'];
            // $response->statusText = base64_encode($response->statusText);
        } else if ($response->statusCode == 400 || $response->statusCode == 401 || $response->statusCode == 403 || $response->statusCode == 404 || $response->statusCode == 409) {
            // this is required for not found (404) case. Because "onBeforeAction" method is not triggered.
            if (!isset($this->model_apilog)) {
                $this->saveApiInfo();
            }

            $this->model_apilog->response = $response->data['message'];

            $response->statusText = $response->data['message'];
            $response->data = null;
        } else if ($response->statusCode == 500) {
            // this is required for some cases. Because "onBeforeAction" method is not triggered.
            if (!isset($this->model_apilog)) {
                $this->saveApiInfo();
            }
            $exception = Yii::$app->errorHandler->exception;
            $response->statusText = $exception->getMessage() . " " . (isset($this->model_apilog->app_id) ? $this->model_apilog->app_id : 0 ) . " " . file_get_contents("php://input");
            $this->model_apilog->response = $exception->getMessage() . " File : " . $exception->getFile() . " Line : " . $exception->getFile() . "Trace : " . $exception->getTraceAsString();
            $response->data = null;
        }
        $this->model_apilog->http_response_code = $response->statusCode;
        $this->model_apilog->save(FALSE);
    }

    private function saveApiInfo() {
        $this->model_apilog = new ApiLog();

        $app = Yii::$app;

        $this->model_apilog->app_id = isset($this->php_input['app_id']) ? (int) $this->php_input['app_id'] : 0;
        $this->model_apilog->version_no = isset($this->post_json['version_no']) ? $this->post_json['version_no'] : '';
        if (isset($this->post_json['app_version'])) {
            $this->model_apilog->version_no = isset($this->post_json['app_version']) ? $this->post_json['app_version'] : '';
        }
        $this->model_apilog->imei_no = isset($this->php_input['imei_no']) ? $this->php_input['imei_no'] : '';
        $this->model_apilog->ip = $app->getRequest()->getUserIP();
        $this->model_apilog->time = new Expression('NOW()');
        $this->model_apilog->request_url = $app->request->pathInfo;
        $this->model_apilog->request_body = $this->php_input['data'];
        $this->model_apilog->http_response_code = 0;
        $this->model_apilog->api_response_status = 0;
        $this->model_apilog->created_at = time();

        if ($this->model_apilog->save(false)) {
            
        } else {

            throw new \yii\web\ServerErrorHttpException('Api info log save error. ' . json_encode($this->model_apilog->getErrors()));
        }
        return $this;
    }

    private function verifyandLogin() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // STEP 1 checking the url requested is part of current API or not
        // Ideally this check is not required, 
        if (!in_array($this->model_apilog->request_url, $this->api_urls)) {
            throw new \yii\web\NotFoundHttpException("Request URL not Found"); //error 404
        }

        // STEP 2 checking whether the app_id and imei_no exists or not.
        if ($this->model_apilog->request_url == $this->login_url or $this->model_apilog->request_url == $this->beforelogindata_url) {// at the time of login app_id will be missing
            if ($this->model_apilog->imei_no == "") {
                throw new \yii\web\BadRequestHttpException("Bad Request, imei_no missing"); //error 400
            }
        } else {
            if ($this->model_apilog->app_id == 0 || $this->model_apilog->imei_no == "") {
                throw new \yii\web\BadRequestHttpException("Bad Request, imei_no or app id missing"); //error 400
            }

            // STEP 3 checking the request made from the app is active or not.
            $active_app = AppDetail::find()->where(['id' => $this->model_apilog->app_id, 'status' => 1])->one();
            if (empty($active_app)) {
                throw new \yii\web\ConflictHttpException("App is not active"); //error 409
            }

            //Todo
            //STEP4 check wheather user is still active or not and asigned the app.
            //throw new \yii\web\ForbiddenHttpException(""); //error 403
            $user = User::findOne(['id' => $active_app->user_id]);
            if ($user->status == 10) {
                if (\Yii::$app->getUser()->login($user, 10)) {
                    //login successful;
                } else {
                    throw new \yii\web\ForbiddenHttpException("Forbidden - User unable to login."); //error 403
                    //unable to login
                }
            } else {
                throw new \yii\web\ForbiddenHttpException("Forbidden - User unable to login."); //error 403
                //unable to login
            }
        }

        //STEP check for active app
    }

}
