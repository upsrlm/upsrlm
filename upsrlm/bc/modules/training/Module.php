<?php

namespace bc\modules\training;

use Yii;
use common\models\master\MasterRole;

/**
 * training module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'bc\modules\training\controllers';

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
        Yii::$app->params['bsDependencyEnabled'] = false;
        parent::init();
        // Module-level access control moved to controller-level behaviors for better compatibility
        // Access is already checked by BC\components\App and ParticipantsController
        parent::init();
        // custom initialization code goes here
    }

}
