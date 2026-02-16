<?php

namespace app\modules\clf\controllers;

use Yii;
use cbo\models\CboClf;
use cbo\models\CboClfSearch;
use cbo\models\form\CboClfForm;
use cbo\models\form\CboClfMembersForm;
use common\models\base\GenralModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\master\MasterRole;
use kartik\mpdf\Pdf;
use Mpdf\Mpdf;

/**
 * View controller for the `clf` module
 */
class DashboardController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message = '';

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest);
                        }
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

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $searchModel = new CboClfSearch();
        if (empty((Yii::$app->request->queryParams))) {
            $searchModel->type_column = 'total_funds_amount';
            $searchModel->order_by = 'asc';
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel->block_option = GenralModel::srlmblockopption($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        $searchModel->funds_type_column_option = ['total_funds_amount' => 'total', 'start_up_funds_amount' => 'Start-up', 'cif_funds_amount' => 'CIF', 'isf_funds_amount' => 'ISF', 'if_funds_amount' => 'INFRA', 'other_funds_amount' => 'Others, if any'];
        $searchModel->order_by_option = ['asc' => 'Ascending', 'desc' => 'Descending'];
        $dataProviderr = $searchModel->dashboardreport(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
        $reports = $dataProviderr->getModels();

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'reports' => $reports
        ]);
    }

}
