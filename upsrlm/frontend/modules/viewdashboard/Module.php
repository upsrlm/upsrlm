<?php

namespace app\modules\viewdashboard;

use Yii;

/**
 * viewdashboard module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\viewdashboard\controllers';

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();

        \Yii::$app->view->theme = new \yii\base\Theme([
            'basePath' => '@common/themes/smartadmin',
            'baseUrl' => '@common/themes/smartadmin',
            'pathMap' => ['@app/views' => '@common/themes/smartadmin/views']
        ]);
        $this->layout = '@common/themes/smartadmin/views/layouts/main_frontend.php';
        Yii::$app->params['bsVersion'] = '4.x';
        Yii::$app->params['bsDependencyEnabled'] = false;
    }

}
