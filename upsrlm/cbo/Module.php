<?php
namespace cbo;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'cbo\\controllers';

    public function init()
    {
        parent::init();

        // Register sub-modules explicitly
        $this->modules = [
            'shg' => [
                'class' => 'cbo\modules\shg\Module',
            ],
        ];
    }
}
