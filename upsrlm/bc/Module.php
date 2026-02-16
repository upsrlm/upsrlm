<?php
namespace bc;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'bc\controllers';

    public function init()
    {
        parent::init();

        $this->modules = [
            'report' => [
                'class' => 'bc\\modules\\report\\Module',
            ],
            // Register training sub-module so routes under /bc/training/* resolve
            'training' => [
                'class' => 'bc\\modules\\training\\Module',
            ],
        ];
    }
}
