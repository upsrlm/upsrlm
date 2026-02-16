<?php

namespace bc\modules\training\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use bc\models\master\MasterDistrict;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\form\RsetisBatchParticipantForm;
use bc\modules\training\models\BatchParticipants;
use bc\modules\training\models\BatchTraining;
use bc\modules\training\models\BatchTrainingSearch;
use bc\modules\training\models\form\BatchForm;
use bc\modules\training\models\RsetisBatchTraining;
use bc\modules\training\models\RsetisBatchTrainingSearch;
use bc\modules\training\models\report\ReportSearch;
use bc\modules\training\models\RsetisCenterTrainingSearch;

/**
 * Default controller for the `training` module
 */
class EcalendarController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'addparticipant'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function BeforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    public function actionIndex() {
        $ecall = new ReportSearch(Yii::$app->request->post());

        $ecall->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
        if (count($ecall->district_option) == 1) {
            $ecall->district_code = key($ecall->district_option);
        }
        $ecalendar = $ecall->ecalendar(Yii::$app->user->identity);
        $searchModel = new RsetisCenterTrainingSearch();
        if ($ecall->district_code) {
            $searchModel->district_code = $ecall->district_code;
        }
        $searchModel->s_date = $ecall->year_month_start_date;
        $searchModel->e_date =  $ecall->end_date;
//        $searchModel->s_date = "2020-12-20"; // $ecall->year_month_start_date;
//        $searchModel->e_date = "2021-03-31"; // $ecall->end_date;
        $dataProviderr = $searchModel->calenderreport($searchModel, Yii::$app->user->identity, false);
        $reports = $dataProviderr->getModels();
        return $this->render('index', [
                    'searchModel' => $ecall,
                    'ecalendar' => $ecalendar,
                    'reports' => $reports
        ]);
    }

}
