<?php

namespace sakhi\modules\page\controllers;

use yii\web\Controller;

/**
 * Default controller for the `page` module
 */
class HelpController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionSupport() {
        return $this->render('support');
    }

    public function actionKnowledge() {
        return $this->render('knowledge');
    }

}
