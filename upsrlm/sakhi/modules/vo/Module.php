<?php

namespace sakhi\modules\vo;

use Yii;

/**
 * vo module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'sakhi\modules\vo\controllers';
    public $params = ['void' => ''];

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();
        $request = explode('?', \Yii::$app->request->url);
        $request_url = rtrim($request[0], '/');
        if (isset($_REQUEST['void']))
            $this->params['void'] = $_REQUEST['void'];
        $app = new \sakhi\components\App();
        if ($app->checkAccess('vo', Yii::$app->user->identity, $request_url, $this->params)) {
            $log = new \sakhi\components\Ristaweblog(Yii::$app->user->identity);
            $log->type = 2;
            $log->type_id = $this->params['void'];
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
