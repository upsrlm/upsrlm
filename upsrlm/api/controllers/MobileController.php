<?php

namespace api\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class MobileController extends Controller {
         
    public function actionIndex() {
        $this->layout='mobile';
        return $this->render('index');
    }

}
