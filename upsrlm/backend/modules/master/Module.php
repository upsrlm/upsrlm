<?php

namespace app\modules\master;

/**
 * master module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\master\controllers';

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();
        $check = new \common\components\Appcheck();
        if (!$check->checkaccess(\common\models\WebApplication::WEB_APP_ADMIN_ID)) {
            return \Yii::$app->getResponse()->redirect(\Yii::$app->params['app_url']['www'] . '/dashboard');
            exit;
        }
        // custom initialization code goes here
    }

}
