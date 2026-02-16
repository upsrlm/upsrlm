<?php

namespace bccallcenter\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use common\models\User;
use common\models\master\MasterRole;
use common\components\Appcheck;
use common\models\WebApplication;

class App extends \yii\base\Component {

    public $check;
    public $request;
    public $request_url;

    public function init() {
        $this->request = explode('?', Yii::$app->request->url);
        $this->request_url = rtrim($this->request[0], '/');
//        $this->check = new Appcheck();
//        $this->check->current_app = Yii::$app->params['current_app'];
//        $this->check->access();
        if (isset(Yii::$app->user->identity)) {
            if (Yii::$app->user->identity->application == null) {
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www']);
                exit;
            }
            if (!in_array(WebApplication::WEB_APP_BC_CALL_CENTER_ID, ArrayHelper::getColumn(Yii::$app->user->identity->application, 'web_application_id'))) {
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/dashboard');
                exit;
            }
            if (Yii::$app->user->identity->profile_status == \common\models\base\GenralModel::STATUS_INACTIVE) {

                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['hr'] . '/profile/update');
                exit;
            }
        }
        parent::init();
    }

}
