<?php

namespace sakhi\modules\bc;

use Yii;

/**
 * bc module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'sakhi\modules\bc\controllers';
    public $params = ['bcid' => ''];

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();
        $skipAccess = Yii::$app->params['env'] === 'local';
        $request = explode('?', \Yii::$app->request->url);
        $request_url = rtrim($request[0], '/');
//         throw new \yii\web\UnauthorizedHttpException("Unauthorized.");
        if (isset($_REQUEST['bcid']))
            $this->params['bcid'] = $_REQUEST['bcid'];
        $app = new \sakhi\components\App();
        if ($skipAccess || $app->checkAccess('bc', Yii::$app->user->identity, $request_url, $this->params)) {
            $log = new \sakhi\components\Ristaweblog(Yii::$app->user->identity);
            $log->type = 4;
            $log->type_id = $this->params['bcid'];
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
