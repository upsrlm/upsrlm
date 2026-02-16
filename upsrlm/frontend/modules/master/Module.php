<?php

namespace app\modules\master;

/**
 * master module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\master\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
         \Yii::$app->params['bsVersion'] = '4.x';
        // custom initialization code goes here
         if (\Yii::$app->user->isGuest) {
            header('Location:/');
            exit;
        }
    }
}
