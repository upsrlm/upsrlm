<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;


/**
 * ReportdataController implements the ajax.
 */
class ReportdataController extends Controller {

    public function actionDisricts() {
        $data = json_decode(file_get_contents(Yii::$app->params['bcdatapath'] . 'bcselection/report/districts.json'));
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $data;
        return $response;
    }

    public function actionBlocks() {
        $data = json_decode(file_get_contents(Yii::$app->params['bcdatapath'] . 'bcselection/report/blocks.json'));
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $data;
        return $response;
    }
     public function actionSareedistributed() {
      
        echo \bc\modules\selection\models\BcProvidedSaree::find()->andWhere(['saree1_provided' => 1])->count()+\bc\modules\selection\models\BcProvidedSaree::find()->andWhere(['saree2_provided' => 1])->count();
        exit();
    }
}
