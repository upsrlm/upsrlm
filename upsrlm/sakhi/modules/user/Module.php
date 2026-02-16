<?php

namespace sakhi\modules\user;

use sakhi\components\ShgCheck;
use Yii;

/**
 * user module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'sakhi\modules\user\controllers';
    public $params = ['userid' => ''];

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();
        $skipAccess = Yii::$app->params['env'] === 'local';
        $request = explode('?', Yii::$app->request->url);
        $request_url = rtrim($request[0], '/');
        if (isset($_REQUEST['userid']))
            $this->params['userid'] = $_REQUEST['userid'];
        $app = new \sakhi\components\App();
        if ($skipAccess || $app->checkAccess('user', Yii::$app->user->identity, $request_url, $this->params)) {
            $shgcheck = new ShgCheck();
            $shgcheck->copyshgdata();
            $log = new \sakhi\components\Ristaweblog(Yii::$app->user->identity);
            $log->type = 10;
            $log->type_id = Yii::$app->user->identity->id;
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
    }

}
