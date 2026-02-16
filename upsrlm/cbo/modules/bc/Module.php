<?php

namespace cbo\modules\bc;
use Yii;
/**
 * bc module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'cbo\modules\bc\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        // Module-level access control moved to controller-level behaviors
        // Access is already checked by CBO\components\App and controller-level AccessControl
        // custom initialization code goes here
    }
}
