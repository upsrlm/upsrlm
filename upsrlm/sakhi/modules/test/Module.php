<?php

namespace sakhi\modules\test;

use Yii;
use sakhi\components\MobileDetect;

/**
 * test module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'sakhi\modules\test\controllers';

    /**
     * {@inheritdoc}
     */
    public function init() {
        \Yii::$app->view->theme = new \yii\base\Theme([
            'basePath' => '@common/themes/smartadmin',
            'baseUrl' => '@common/themes/smartadmin',
            'pathMap' => ['@app/views' => '@common/themes/smartadmin/views']
        ]);
        $this->layout = '@common/themes/smartadmin/views/layouts/main_rishta_test.php';
        Yii::$app->params['bsVersion'] = '4.x';
        Yii::$app->params['bsDependencyEnabled'] = false;

        $mobile = new MobileDetect();
        if ($mobile->isAndroidOS()) {
           // throw new \yii\web\UnauthorizedHttpException("Unauthorized.");
        }
        if (!$mobile->isAndroidOS()) {
            if (!isset(Yii::$app->user->identity)) {
                return \Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/dashboard');
                exit;
            }
        }
        if (isset(Yii::$app->user->identity)) {
            
//            if (Yii::$app->user->identity->dummy_column == '0') {
//                Yii::$app->user->logout();
//                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www']);
//                 exit;
//            }
        }
        parent::init();
    }

}
