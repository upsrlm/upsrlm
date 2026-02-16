<?php

namespace bc\modules\corona;

use Yii;

/**
 * corona module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'bc\modules\corona\controllers';

    /**
     * {@inheritdoc}
     */
    public function init() {
        \Yii::$app->view->theme = new \yii\base\Theme([
            'basePath' => '@common/themes/smartadmin',
            'baseUrl' => '@common/themes/smartadmin',
            'pathMap' => ['@app/views' => '@common/themes/smartadmin/views']
        ]);
        $this->layout = '@common/themes/smartadmin/views/layouts/main_bc.php';
        Yii::$app->params['bsVersion'] = '4.x';
        parent::init();
        // Module-level access control moved to controller-level behaviors
        // Access is already checked by BC\components\App and controller-level AccessControl
        // custom initialization code goes here
    }

}
