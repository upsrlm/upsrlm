<?php

namespace bc\modules\transaction\controllers;

use Yii;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

ini_set('max_execution_time', 1200);
ini_set('memory_limit', '-1');

/**
 * TransactionController implements the CRUD actions for PartnerAssociates model.
 */
class ReportController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'block' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all PartnerAssociates models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryDailySearch();
        $searchModel->month_option = $searchModel->monthoption(Yii::$app->request->queryParams, Yii::$app->user->identity);

        $searchModel->setAttributes(Yii::$app->request->queryParams);
        if (!isset(Yii::$app->request->queryParams['BcTransactionBcSummaryDailySearch']['month'])) {
            $date = new \DateTime('now');
            $date->modify('first day of this month');
            $searchModel->month = $date->format('Y-m-d');
        } else {
            if (Yii::$app->request->queryParams['BcTransactionBcSummaryDailySearch']['month'] == '') {
                $date = new \DateTime('now');
                $date->modify('first day of this month');
                $searchModel->month = $date->format('Y-m-d');
            } else {
                $searchModel->month = Yii::$app->request->queryParams['BcTransactionBcSummaryDailySearch']['month'];
            }
        }
        $searchModel->SetDate($searchModel->month);
        $dataProvider = $searchModel->reportsearch(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReportchart() {
        $searchModel = new \bc\modules\transaction\models\summary\report\Graph();

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, \Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }


        return $this->render('reportchart', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReportchart1() {
        $searchModel = new \bc\modules\transaction\models\summary\report\Graph();

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, \Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }


        return $this->render('reportchart1', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReportchart2() {
        $searchModel = new \bc\modules\transaction\models\summary\report\Graph();

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, \Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }


        return $this->render('reportchart2', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReportchart3() {
        $searchModel = new \bc\modules\transaction\models\summary\report\Graph();

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, \Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }


        return $this->render('reportchart3', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReportchart4() {
        $searchModel = new \bc\modules\transaction\models\summary\report\Graph();

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, \Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }


        return $this->render('reportchart4', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Monthly Report Chart
     *
     * @return void
     */
    public function actionMonthlychart() {
        $searchModel = new \bc\modules\transaction\models\summary\report\Graph();
        $searchModel->month_id = \bc\modules\selection\models\base\GenralModel::current_month_id() - 1;

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, \Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        $searchModel->month_option = $searchModel->monthoption();
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }

        return $this->render('monthlychart', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Bank Report Chart
     *
     * @return void
     */
    public function actionBankchart() {
        $searchModel = new \bc\modules\transaction\models\summary\report\Graph();

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, \Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModel->month_option = $searchModel->monthoption();

        return $this->render('bankchart', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionChart() {
        $seach = new \bc\modules\transaction\models\summary\form\SearchForm(Yii::$app->request->queryParams);
        $searchModel = new \bc\modules\transaction\models\summary\BcTransactionBcSummarySearch();
        $dataProvider = $searchModel->search($seach, Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }
        $searchModel1 = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthlySearch();
        $report = $searchModel1->chart($seach, Yii::$app->user->identity);
        if ($searchModel->master_partner_bank_id || $searchModel->district_code || $searchModel->block_code || $searchModel->gram_panchayat_code || $searchModel->nretp != '') {
            \Yii::$app->params['txn'] = 0;
            \Yii::$app->params['txn_com'] = 0;
            \Yii::$app->params['txn_amn'] = 0;
        }
        return $this->render('chart', [
                    'searchModel' => $seach,
                    'dataProvider' => $dataProvider,
                    'report' => $report
        ]);
    }

    public function actionChart1() {
        $seach = new \bc\modules\transaction\models\summary\form\SearchForm(Yii::$app->request->queryParams);
        $searchModel = new \bc\modules\transaction\models\summary\BcTransactionBcSummarySearch();
        $dataProvider = $searchModel->search($seach, Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }
        $searchModel1 = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthlySearch();
        $report = $searchModel1->chart($seach, Yii::$app->user->identity);
        if ($searchModel->master_partner_bank_id || $searchModel->district_code || $searchModel->block_code || $searchModel->gram_panchayat_code || $searchModel->nretp != '') {
            \Yii::$app->params['txn'] = 0;
            \Yii::$app->params['txn_com'] = 0;
            \Yii::$app->params['txn_amn'] = 0;
        }
        return $this->render('chart1', [
                    'searchModel' => $seach,
                    'dataProvider' => $dataProvider,
                    'report' => $report
        ]);
    }

    public function actionChart4() {
        $seach = new \bc\modules\transaction\models\summary\form\SearchForm(Yii::$app->request->queryParams);

        $searchModel1 = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthlySearch();
        try {
            //$seach->from_month_id=43;
            $report = $searchModel1->chartoverallbank($seach, Yii::$app->user->identity);
//             echo "<pre>";
//             print_r($report);exit;
            return $this->render('chart4', [
                        'searchModel' => $seach,
                        'report' => $report
            ]);
        } catch (\Exception $ex) {
                        echo "<pre>";
             print_r($ex->getMessage());           
             print_r($ex->getLine());exit;
        }
    }
}
