<?php

namespace bc\modules\selection\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\grid\GridView;
use kartik\mpdf\Pdf;
use Mpdf\Mpdf;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\modules\selection\models\SrlmBcApplicationHistory;
use bc\modules\selection\models\form\DashboardSearchForm;
use bc\modules\selection\models\SrlmBcSelectionUser;
use bc\modules\selection\models\SrlmBcSelectionUserSearch;
use bc\modules\selection\models\form\DownloadCSVForm;
use bc\models\master\MasterDistrictSearch;
use bc\models\master\MasterBlockSearch;
use bc\models\master\MasterGramPanchayatSearch;
use bc\modules\selection\models\base\GenralModel;

date_default_timezone_set("Asia/Calcutta");

/**
 * Default controller for the `srlm` module
 */
class ImportController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['file'],
                'rules' => [
                    [
                        'actions' => ['file'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionFile() {
         
        return $this->render('file', [
                    'model' => $model,
        ]);
    }

}
