<?php

namespace bc\modules\report;

use Yii;

/**
 * report module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'bc\modules\report\controllers';

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
        $this->modules = [
            'tracking' => [
                'class' => 'bc\modules\report\modules\tracking\Module',
            ],
        ];
        parent::init();

        // custom initialization code goes here
    }
}
