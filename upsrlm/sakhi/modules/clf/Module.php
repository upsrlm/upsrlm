<?php

namespace sakhi\modules\clf;

use Yii;

/**
 * clf module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'sakhi\modules\clf\controllers';
    public $params = ['clfid' => ''];

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();

        $skipAccess = Yii::$app->params['env'] === 'local';

        $request = explode('?', \Yii::$app->request->url);
        $request_url = rtrim($request[0], '/');
        if (isset($_REQUEST['clfid']))
            $this->params['clfid'] = $_REQUEST['clfid'];
        $app = new \sakhi\components\App();
        if ($skipAccess || $app->checkAccess('clf', Yii::$app->user->identity, $request_url, $this->params)) {
            $log = new \sakhi\components\Ristaweblog(Yii::$app->user->identity);
            $log->type = 3;
            $log->type_id = $this->params['clfid'];
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
