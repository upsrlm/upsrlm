<?php

namespace bc\modules\partneragencies;

use Yii;

/**
 * partneragencies module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'bc\modules\partneragencies\controllers';

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
        $this->layout = '@common/themes/smartadmin/views/layouts/main_bc.php';
        Yii::$app->params['bsVersion'] = '4.x';
        // Module-level access control moved to controller-level behaviors
        // Access is already checked by BC\components\App and controller-level AccessControl
    }

}
