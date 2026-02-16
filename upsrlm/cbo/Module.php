<?php
namespace cbo;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'cbo\\controllers';
    public $layout = 'main_cbo';
    public $layoutPath = '@common/themes/smartadmin/views/layouts';

    public function init()
    {
        parent::init();

        // Register sub-modules explicitly
        $this->modules = [
            'shg' => [
                'class' => 'cbo\modules\shg\Module',
            ],
            'vo' => [
                'class' => 'cbo\modules\vo\Module',
            ],
            'clf' => [
                'class' => 'cbo\modules\clf\Module',
            ],
            'bc' => [
                'class' => 'cbo\modules\bc\Module',
            ],
            'wada' => [
                'class' => 'cbo\modules\wada\Module',
            ],
        ];
    }
}
