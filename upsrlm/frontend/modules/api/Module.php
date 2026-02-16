<?php

namespace frontend\modules\api;

use Yii;
use yii\web\Response;
use yii\db\Expression;
use yii\base\ActionEvent;
use yii\base\Application;

/**
 * api module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\api\controllers';

    /**
     * @var \app\models\ApiLog
     */
    public $model_apilog;
    public $post_json;
    public $data_json;

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
     * {@inheritdoc}
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
        $this->php_input = \Yii::$app->request->post();
        $this->post_json = $this->php_input;
        $this->data_json = $this->post_json;
    }

    public function onBeforeSend($event) {

        $response = $event->sender;
    }

}
