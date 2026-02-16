<?php

namespace sakhi\modules\shg;

use sakhi\components\ShgCheck;
use Yii;

/**
 * shg module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'sakhi\modules\shg\controllers';
    public $params = ['shgid' => ''];

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();

        $skipAccess = Yii::$app->params['env'] === 'local';
        $request = explode('?', Yii::$app->request->url);
        $request_url = rtrim($request[0], '/');
        if (isset($_REQUEST['shgid']))
            $this->params['shgid'] = $_REQUEST['shgid'];
        $app = new \sakhi\components\App();
        if ($skipAccess || $app->checkAccess('shg', Yii::$app->user->identity, $request_url, $this->params)) {
            $shgcheck = new ShgCheck();
            $shgcheck->copyshgdata();
            $log = new \sakhi\components\Ristaweblog(Yii::$app->user->identity);
            $log->type = 1;
            $log->type_id = $this->params['shgid'];
            $log->type_url = $request_url;
            $log->save();
        } else {
           throw new \yii\web\UnauthorizedHttpException("Unauthorized.");
        }
        $mobile = new \sakhi\components\MobileDetect();
        if (!$mobile->isAndroidOS()) {
            \Yii::$app->view->theme = new \yii\base\Theme([
                'basePath' => '@common/themes/smartadmin',
                'baseUrl' => '@common/themes/smartadmin',
                'pathMap' => ['@app/views' => '@common/themes/smartadmin/views']
            ]);
            $this->layout = '@common/themes/smartadmin/views/layouts/main_rishta_test.php';
            Yii::$app->params['bsVersion'] = '4.x';
            Yii::$app->params['bsDependencyEnabled'] = false;
        }
        // custom initialization code goes here
    }

}
