<?php

namespace bccallcenter\modules\rsetis;

use Yii;

/**
 * rsetis module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'bccallcenter\modules\rsetis\controllers';

    /**
     * {@inheritdoc}
     */
    public function init() {
        $check = new \common\components\Appcheck();
//        if (!$check->checkaccess(\common\models\WebApplication::WEB_APP_SUPPORT_ID)) {
//            return \Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/dashboard');
//            exit;
//        }
        parent::init();

        // custom initialization code goes here
    }

}
