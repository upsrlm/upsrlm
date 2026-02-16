<?php

namespace api\modules\bcselection;

use Yii;
use yii\web\Response;
use yii\db\Expression;
use yii\base\ActionEvent;
use yii\base\Application;
use bc\modules\selection\models\SrlmBcSelectionApiLog as ApiLog;
use bc\modules\selection\models\SrlmBcSelectionAppDetail as AppDetail;
use bc\modules\selection\models\SrlmBcSelectionUser as AppUser;

/**
 * api module definition class
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class Module extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'api\modules\bcselection\controllers';

    /**
     * @var \app\models\ApiLog
     */
    public $model_apilog;

    /**
     * @var \app\models\AppRegistration
     */
    public $model_app;

    /**
     * @var app\models\srlm\SrlmBcSelectionUser
     */
    public $model_appuser;

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

    /*
     * Module Base URL
     */
    public $base_url = "bcselection/";

    /**
     *
     * @var type 
     */
    public $api_urls = [
        'bcselection/user/login',
        'bcselection/user/formsave',
        'bcselection/user/getphoto',
        'bcselection/user/getdetail',
        'bcselection/user/uploadphoto',
//        'bcselection/user/otp',
        'bcselection/user/phase',
        'bcselection/user/getgp',
        'bcselection/user/notificationacknowledge',
        'bcselection/user/veiwweb',
        'bcselection/user/bcbankaccountsave',
        'bcselection/user/bcshgbankaccountsave',
        'bcselection/user/getshg',
        'bcselection/user/updateshg',
        'bcselection/user/uploadpan',
        'bcselection/user/coronafeedback',
        'bcselection/user/acknowledgesupportfunds',
        'bcselection/user/acknowledgehandheldmachine',
        'bcselection/user/mobilepin',
        'bcselection/user/trainingfeedback'
    ];

    /**
     *
     * @var type 
     */
    public $login_url = 'bcselection/user/login';
    public $otp_url = 'bcselection/user/otp';
    public $phase_url = 'bcselection/user/phase';
    public $mobile_pin_url = 'bcselection/user/mobilepin';
    public $gp_url='bcselection/user/getgp';

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
            //  print_r($exception->getMessage() ); exit;
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

        $this->model_apilog->srlm_bc_selection_app_id = isset($this->php_input['app_id']) ? (int) $this->php_input['app_id'] : 0;
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
        if ($this->model_apilog->save(FALSE)) {

            if ($this->model_apilog->srlm_bc_selection_app_id > 0) {
                $this->model_app = AppDetail::find()->where(['id' => $this->model_apilog->srlm_bc_selection_app_id, 'status' => 1])->one();
                //$this->model_app = AppDetail::find()->where(['id' => $this->model_apilog->srlm_bc_selection_app_id])->one();
                if (!empty($this->model_app)) {
                    $this->model_appuser = AppUser::findOne($this->model_app->srlm_bc_selection_user_id);
                    $this->model_apilog->srlm_bc_selection_user_id = $this->model_app->srlm_bc_selection_user_id;
                }
            }
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
        if ($this->model_apilog->request_url == $this->login_url  or $this->model_apilog->request_url == $this->phase_url or $this->model_apilog->request_url == $this->mobile_pin_url or $this->model_apilog->request_url == $this->gp_url) {// at the time of login app_id will be missing
            if ($this->model_apilog->imei_no == "") {
                throw new \yii\web\BadRequestHttpException("Bad Request, imei_no missing"); //error 400
            }
        } else {
            //
            //exit;
            if ($this->model_apilog->srlm_bc_selection_app_id == 0 || $this->model_apilog->imei_no == "") {
                throw new \yii\web\BadRequestHttpException("Bad Request, imei_no or app id missing"); //error 400
            }

            // STEP 3 checking the request made from the app is active or not.
            $active_app = AppDetail::find()->where(['id' => $this->model_apilog->srlm_bc_selection_app_id, 'status' => 1])->one();
            //$active_app = AppDetail::find()->where(['id' => $this->model_apilog->srlm_bc_selection_app_id])->one();
            if (empty($active_app)) {
                throw new \yii\web\ConflictHttpException("App is not active"); //error 409
            }

            //Todo
            //STEP4 check wheather user is still active or not and asigned the app.
            //throw new \yii\web\ForbiddenHttpException(""); //error 403
            if (isset($this->model_appuser) && $this->model_appuser->status == "1") {
                if (isset($this->model_appuser->bcsapplication) and $this->model_appuser->bcsapplication->blocked != 0) {
                  throw new \yii\web\ForbiddenHttpException("Forbidden - User is blocked.");  
                }
            } else {
                throw new \yii\web\ForbiddenHttpException("Forbidden - User Disabled."); //error 403
            }
        }

        //STEP check for active app
    }

}
