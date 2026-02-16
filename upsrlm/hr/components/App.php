<?php

namespace hr\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use common\models\User;
use common\models\master\MasterRole;
use common\components\Appcheck;
use common\models\WebApplication;

class App extends \yii\base\Component {

    public $check;

    public function init() {
        $this->check = new Appcheck();
        $this->check->current_app = Yii::$app->params['current_app'];
        $this->check->access();
        if (isset(Yii::$app->user->identity)) {
           
            // Explicitly call getApplication() method instead of relying on property access
            $userApplications = Yii::$app->user->identity->getApplication();
            if (empty($userApplications)) {
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www']);
                exit;
            }
            if (!in_array(WebApplication::WEB_APP_HR_ID, ArrayHelper::getColumn($userApplications, 'web_application_id'))) {
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/dashboard');
                exit;
            }
            if (!$this->check->checkaccess(\common\models\WebApplication::WEB_APP_HR_ID)) {
                return \Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www']);
                exit;
            }
        }
        parent::init();
    }

}
