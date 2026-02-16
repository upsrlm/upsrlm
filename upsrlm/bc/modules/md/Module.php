<?php

namespace bc\modules\md;

use Yii;

/**
 * md module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'bc\modules\md\controllers';

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
