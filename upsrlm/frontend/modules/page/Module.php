<?php

namespace app\modules\page;

/**
 * page module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\page\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
       // $this->layout='@app/themes/aasaan/views/layouts/static';
        parent::init();

        // custom initialization code goes here
    }
}
