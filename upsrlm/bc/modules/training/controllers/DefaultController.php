<?php

namespace bc\modules\training\controllers;

use yii\web\Controller;

/**
 * Default controller for the `training` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect(['/training/training']);
        return $this->render('index');
    }

    
}
