<?php

namespace sakhi\modules\page\controllers;

use yii\web\Controller;

/**
 * Default controller for the `page` module
 */
class GoController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    

}
