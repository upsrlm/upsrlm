<?php

namespace app\modules\page\controllers;
use Yii;
use yii\web\Controller;
use bc\models\BcMonthlyReport;

/**
 * Default controller for the `viewdashboard` module
 */
class MethodologyController extends Controller {

 
    
    public function actionIndex() {
         $model=[];
        return $this->render('index', [
    
                    'model' => $model
        ]);
    }

}
