<?php

namespace app\modules\viewdashboard\controllers;

use yii\web\Controller;

/**
 * Default controller for the `viewdashboard` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect(['/viewdashboard/transaction']);
        return $this->render('index');
    }
}
