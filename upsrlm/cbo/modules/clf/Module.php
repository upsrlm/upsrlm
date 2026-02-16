<?php

namespace cbo\modules\clf;

use Yii;

/**
 * clf module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'cbo\modules\clf\controllers';

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
