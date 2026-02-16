<?php

namespace sakhi\modules\vo\controllers;

use yii\web\Controller;

/**
 * Default controller for the `vo` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }
     public function actionView($void) {

        $model = [];

        return $this->render('index', [
                    'model' => $model,
        ]);
    }
    public function actionUpdate($void) {

        $model = [];

        return $this->render('index', [
                    'model' => $model,
        ]);
    }

    public function actionFundsrecived($void) {
        $model = [];

        return $this->render('index', [
                    'model' => $model,
        ]);
    }

    public function actionReceivefundsvo($void, $vofundsid = null) {
        $model = [];

        return $this->render('index', [
                    'model' => $model,
        ]);
    }

    public function actionFundshg($void) {
        $model = [];

        return $this->render('index', [
                    'model' => $model,
        ]);
    }

    public function actionAddshg($void) {
        $model = [];

        return $this->render('index', [
                    'model' => $model,
        ]);
    }

    public function actionMemberlist($void) {
        $model = [];

        return $this->render('index', [
                    'model' => $model,
        ]);
    }

    public function actionAddmember($void) {
         $model = [];

        return $this->render('index', [
                    'model' => $model,
        ]);
    }

    

}
