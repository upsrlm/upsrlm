<?php

namespace sakhi\modules\api;

/**
 * api module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'sakhi\modules\api\controllers';

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();

        $this->modules = [
            'v1' => [
                'class' => 'sakhi\modules\api\v1\Module',
            ],
        ];
    }

}
