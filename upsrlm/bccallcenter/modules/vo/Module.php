<?php

namespace bccallcenter\modules\vo;

use Yii;

/**
 * vo module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'bccallcenter\modules\vo\controllers';

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();
        $check = new \common\components\Appcheck();
//        if (!$check->checkaccess(\common\models\WebApplication::WEB_APP_SUPPORT_ID)) {
//            return \Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['support'] . '/dashboard');
//            exit;
//        }
        // custom initialization code goes here
    }

}
