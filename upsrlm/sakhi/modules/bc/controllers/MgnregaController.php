<?php

namespace sakhi\modules\bc\controllers;

use Yii;
use yii\web\Controller;
use yii\widgets\ActiveForm;

/**
 * MgnregaController for the `bc` module
 */
class MgnregaController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message;

    public function actionIndex() {
        return $this->render('index');
    }

}
