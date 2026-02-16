<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class ReportController extends Controller
{

    /**
     * Angular Based Dashboard
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'angular';
        return $this->render('index');
    }
}
