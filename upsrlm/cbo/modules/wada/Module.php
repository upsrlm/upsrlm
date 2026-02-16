<?php

namespace cbo\modules\wada;
use Yii;
/**
 * wada module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'cbo\modules\wada\controllers';

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
