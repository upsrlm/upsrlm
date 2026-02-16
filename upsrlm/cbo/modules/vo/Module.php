<?php

namespace cbo\modules\vo;

use Yii;

/**
 * vo module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\vo\controllers';

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();
        // Module-level access control moved to controller-level behaviors
        // Access is already checked by CBO\components\App and controller-level AccessControl
        // custom initialization code goes here
    }

}
