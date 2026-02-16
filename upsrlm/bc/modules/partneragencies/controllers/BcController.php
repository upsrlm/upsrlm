<?php

namespace bc\modules\partneragencies\controllers;

use Yii;
use bc\modules\selection\models\SrlmBcApplication;
use bc\models\master\MasterPartnerBank;
use bc\models\transaction\BcTransactionFiles;
use bc\models\transaction\BcTransactionFilesSearch;
use bc\models\transaction\BcTransaction;
use bc\models\transaction\BcTransactionSearch;
use bc\models\transaction\BcTransactionOverallReportSearch;
use bc\models\transaction\BcTransactionDailyReport;
use bc\models\transaction\BcTransactionDailyReportSearch;
use bc\models\transaction\BcTransactionMonthlyReport;
use bc\models\transaction\BcTransactionMonthlyReportSearch;
use bc\models\transaction\BcTransactionWeeklyReport;
use bc\models\transaction\BcTransactionWeeklyReportSearch;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BcController implements the CRUD actions for PartnerAssociates model.
 */
class BcController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['overallperformance', 'monthlyperformance', 'weeklyperformance', 'dailyperformance', 'downloadoverall'],
                'rules' => [
                    [
                        'actions' => ['overallperformance', 'monthlyperformance', 'weeklyperformance', 'dailyperformance', 'downloadoverall'],
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
    public function actionOverallperformance() {
        $searchModel = new BcTransactionOverallReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 30);
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
        return $this->render('overallperformance', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDailyperformance() {
        $searchModel = new BcTransactionDailyReportSearch();
        if (!isset(Yii::$app->request->queryParams['BcTransactionDailyReportSearch']['bc_application_id'])) {
            if (!isset(Yii::$app->request->queryParams['BcTransactionDailyReportSearch']['from_date_time'])) {
                $searchModel->from_date_time = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));
                $searchModel->to_date_time = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));
            }
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 30);
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
        return $this->render('dailyperformance', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionWeeklyperformance() {
        $searchModel = new BcTransactionWeeklyReportSearch();
        $searchModel->week_option = \bc\modules\selection\models\base\GenralModel::bctweekoption($searchModel);
        if (!isset(\Yii::$app->request->queryParams['BcTransactionWeeklyReportSearch']['week_id'])) {
            $searchModel->week_id = \bc\modules\selection\models\base\GenralModel::current_week_id();
        }
        if (empty(\Yii::$app->request->queryParams)) {
            $searchModel->week_id = \bc\modules\selection\models\base\GenralModel::current_week_id();
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 30);
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

        return $this->render('weeklyperformance', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMonthlyperformance() {
        $null = new \yii\db\Expression('NULL');
        $searchModel = new BcTransactionMonthlyReportSearch();

        if (!isset(\Yii::$app->request->queryParams['BcTransactionMonthlyReportSearch']['month_id'])) {
            $searchModel->month_id = \bc\modules\selection\models\base\GenralModel::current_month_id();
        }
        if (empty(Yii::$app->request->queryParams)) {
            $searchModel->month_id = \bc\modules\selection\models\base\GenralModel::current_month_id();
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 30);
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
        $searchModel->month_option = \bc\modules\selection\models\base\GenralModel::bctmonthoption();
        return $this->render('monthlyperformance', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDownloadoverall() {
        $null = new \yii\db\Expression('NULL');
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $searchModel = new \bc\models\transaction\BcTransactionOverallReportSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $file = "bc_transaction_overall_" . date("Y_m_d_H-m-s") . ".csv";

            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Srl. No.', 'Name', 'District', 'Block', 'GP', 'Partner Agency', 'No. of transaction', 'Txn Amount', 'Commission Amount', 'No. Of Days', 'Working Days', 'Non Working Days'));
            $sr_no = 1;
            $row = [];
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $row = [
                    $sr_no,
                    isset($model->bc) ? $model->bc->name : '',
                    isset($model->district) ? $model->district->district_name : '',
                    isset($model->block) ? $model->block->block_name : '',
                    isset($model->gp) ? $model->gp->gram_panchayat_name : '',
                    isset($model->pbank) ? $model->pbank->bank_short_name : '',
                    isset($model->no_of_transaction) ? $model->no_of_transaction : '',
                    $model->transaction_amount,
                    isset($model->commission_amount) ? round($model->commission_amount, 2) : '',
                    isset($model->no_of_days) ? $model->no_of_days : '',
                    isset($model->no_of_working_days) ? $model->no_of_working_days : '',
                    isset($model->no_of_not_working_days) ? $model->no_of_not_working_days : ''
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit();
        } catch (\Exception $ex) {
//            print_r($ex->getMessage());
//            exit;
        }
    }

}
