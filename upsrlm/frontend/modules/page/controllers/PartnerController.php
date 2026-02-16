<?php

namespace app\modules\page\controllers;

use Yii;
use yii\web\Controller;
use bc\models\BcMonthlyReport;

/**
 * Default controller for the `viewdashboard` module
 */
class PartnerController extends Controller {

    public function actionIndex() {
        $model = [];
        return $this->render('index', [
                    'model' => $model
        ]);
    }

    public function actionBob() {

        $model = [];

        return $this->render('bob', [
                    'model' => $model
        ]);
    }

    public function actionFino() {
        $model = [];

        return $this->render('fino', [
                    'model' => $model
        ]);
    }

    public function actionNearby() {
        $model = [];

        return $this->render('nearby', [
                    'model' => $model
        ]);
    }

    public function actionManipal() {

        $model = [];

        return $this->render('manipal', [
                    'model' => $model
        ]);
    }

    public function actionAirtel() {

        $model = [];

        return $this->render('airtel', [
                    'model' => $model
        ]);
    }

    public function actionPtm() {

        $model = [];

        return $this->render('ptm', [
                    'model' => $model
        ]);
    }

    public function actionSbi() {
        $model = [];

        return $this->render('sbi', [
                    'model' => $model
        ]);
    }
}
