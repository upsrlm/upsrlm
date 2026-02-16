<?php

namespace bc\modules\transaction\controllers;

use Yii;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use bc\modules\transaction\models\summary\BcTransactionBcSummarySearch;
use bc\modules\transaction\models\summary\BcTransactionBcSummaryDailySearch;
use bc\modules\transaction\models\summary\BcTransactionBankSummaryWeeklySearch;
use bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthlySearch;
use common\models\master\MasterRole;

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
        $user_model = Yii::$app->user->identity;
        $searchModel = new BcTransactionBcSummarySearch();
        if (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
            $searchModel->master_partner_bank_id = $user_model->master_partner_bank_id;
        } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
            $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
            $searchModel->master_partner_bank_id = $user_model->master_partner_bank_id;
        } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
            $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
            $searchModel->master_partner_bank_id = $user_model->master_partner_bank_id;
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
        if ($searchModel->master_partner_bank_id || $searchModel->district_code || $searchModel->block_code || $searchModel->gram_panchayat_code || $searchModel->nretp != '') {
            Yii::$app->params['txn'] = 0;
            Yii::$app->params['txn_com'] = 0;
            Yii::$app->params['txn_amn'] = 0;
        }
        return $this->render('overallperformance', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDailyperformance() {
        $searchModel = new BcTransactionBcSummaryDailySearch();
        if (!isset(Yii::$app->request->queryParams['BcTransactionBcSummaryDailySearch']['bc_application_id'])) {
            if (!isset(Yii::$app->request->queryParams['BcTransactionBcSummaryDailySearch']['from_date_time'])) {
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
        $searchModel = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryWeeklySearch();
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
        $searchModel = new BcTransactionBcSummaryMonthlySearch();

        if (!isset(\Yii::$app->request->queryParams['BcTransactionBcSummaryMonthlySearch']['month_id'])) {
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
            $searchModel = new BcTransactionBcSummarySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $file = "bc_transaction_overall_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Srl. No.', 'Application No', 'Name', 'District', 'Block', 'GP', 'Partner Agency', 'No. of transaction', 'Txn Amount', 'Commission Amount', 'No. Of Days', 'Working Days', 'Non Working Days'));
            $sr_no = 1;
            $row = [];
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $row = [
                    $sr_no,
                    isset($model->bc) ? $model->bc->application_id : '',
                    isset($model->bc) ? $model->bc->name : '',
                    isset($model->district) ? $model->district->district_name : '',
                    isset($model->block) ? $model->block->block_name : '',
                    isset($model->gp) ? $model->gp->gram_panchayat_name : '',
                    isset($model->pbank) ? $model->pbank->bank_short_name : '',
                    isset($model->no_of_transaction) ? $model->no_of_transaction : '',
                    $model->transaction_amount,
                    isset($model->commission_amount) ? round($model->commission_amount, 2) : '',
                    isset($model->total_day) ? $model->total_day : '',
                    isset($model->total_working_day) ? $model->total_working_day : '',
                    isset($model->total_not_working_day) ? $model->total_not_working_day : ''
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

    public function actionDownloadmonthli() {
        $null = new \yii\db\Expression('NULL');
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $searchModel = new BcTransactionBcSummaryMonthlySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $file = "bc_transaction_monthly_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Srl. No.', 'Application No', 'Name', 'District', 'Block', 'GP', 'Partner Agency', 'Month', 'No. of transaction', 'Txn Amount', 'Commission Amount', 'No. Of Days', 'Working Days', 'Non Working Days', 'NRETP'));
            $sr_no = 1;
            $row = [];
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $row = [
                    $sr_no,
                    isset($model->bc) ? $model->bc->application_id : '',
                    isset($model->bc) ? $model->bc->name : '',
                    isset($model->district) ? $model->district->district_name : '',
                    isset($model->block) ? $model->block->block_name : '',
                    isset($model->gp) ? $model->gp->gram_panchayat_name : '',
                    isset($model->pbank) ? $model->pbank->bank_short_name : '',
                    isset($model->month_start_date) ? \Yii::$app->formatter->asDatetime($model->month_start_date, "php:M-Y") : '',
                    isset($model->no_of_transaction) ? $model->no_of_transaction : '',
                    $model->transaction_amount,
                    isset($model->commission_amount) ? round($model->commission_amount, 2) : '',
                    isset($model->total_day) ? $model->total_day : '',
                    isset($model->total_working_day) ? $model->total_working_day : '',
                    isset($model->total_not_working_day) ? $model->total_not_working_day : '',
                    (isset($model->block->nretp) and $model->block->nretp == 1) ? 'Yes' : 'No',
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

    public function actionDownloadmonthlim($month_id = 0) {
        $null = new \yii\db\Expression('NULL');
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $searchModel = new BcTransactionBcSummaryMonthlySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $dataProvider->query->andWhere(['>=', 'month_id', $month_id]);
            $dataProvider->query->orderBy(['month_id' => SORT_DESC]);
            $file = "bc_transaction_monthly_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Srl. No.', 'Application No', 'Name', 'District', 'Block', 'GP', 'Partner Agency', 'Month', 'No. of transaction', 'Txn Amount', 'Commission Amount', 'No. Of Days', 'Working Days', 'Non Working Days', 'NRETP'));
            $sr_no = 1;
            $row = [];
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $row = [
                    $sr_no,
                    isset($model->bc) ? $model->bc->application_id : '',
                    isset($model->bc) ? $model->bc->name : '',
                    isset($model->district) ? $model->district->district_name : '',
                    isset($model->block) ? $model->block->block_name : '',
                    isset($model->gp) ? str_replace(',', ' ', $model->gp->gram_panchayat_name) : '',
                    isset($model->pbank) ? $model->pbank->bank_short_name : '',
                    isset($model->month_start_date) ? \Yii::$app->formatter->asDatetime($model->month_start_date, "php:M-Y") : '',
                    isset($model->no_of_transaction) ? $model->no_of_transaction : '',
                    $model->transaction_amount,
                    isset($model->commission_amount) ? round($model->commission_amount, 2) : '',
                    isset($model->total_day) ? $model->total_day : '',
                    isset($model->total_working_day) ? $model->total_working_day : '',
                    isset($model->total_not_working_day) ? $model->total_not_working_day : '',
                    (isset($model->block->nretp) and $model->block->nretp == 1) ? 'Yes' : 'No',
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

    public function actionDownloadweekly() {
        $null = new \yii\db\Expression('NULL');
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $searchModel = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryWeeklySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $file = "bc_transaction_weekly_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Srl. No.', 'Application No', 'Name', 'District', 'Block', 'GP', 'Partner Agency', 'Week', 'No. of transaction', 'Txn Amount', 'Commission Amount', 'No. Of Days', 'Working Days', 'Non Working Days'));
            $sr_no = 1;
            $row = [];
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $row = [
                    $sr_no,
                    isset($model->bc) ? $model->bc->application_id : '',
                    isset($model->bc) ? $model->bc->name : '',
                    isset($model->district) ? $model->district->district_name : '',
                    isset($model->block) ? $model->block->block_name : '',
                    isset($model->gp) ? $model->gp->gram_panchayat_name : '',
                    isset($model->pbank) ? $model->pbank->bank_short_name : '',
                    isset($model->week) ? \Yii::$app->formatter->asDatetime($model->week_start_date, "php:d M Y") . ' to ' . \Yii::$app->formatter->asDatetime($model->week_end_date, "php:d M Y") : '',
                    isset($model->no_of_transaction) ? $model->no_of_transaction : '',
                    $model->transaction_amount,
                    isset($model->commission_amount) ? round($model->commission_amount, 2) : '',
                    isset($model->total_day) ? $model->total_day : '',
                    isset($model->total_working_day) ? $model->total_working_day : '',
                    isset($model->total_not_working_day) ? $model->total_not_working_day : ''
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

    public function actionBccsv($bc_application_id) {
        $null = new \yii\db\Expression('NULL');
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $model = $this->findModelbc($bc_application_id);
            if ($model == null) {
                return $this->redirect(['/']);
            }
            $searchModel = new BcTransactionBcSummaryMonthlySearch();
            $searchModel->bc_application_id = $bc_application_id;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $dataProvider->query->andWhere(['bc_application_id' => $bc_application_id]);
            $dataProvider->sort->defaultOrder = ['month_start_date' => SORT_DESC];
            $file = "bc_" . $model->name . '_' . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Srl. No.', 'Application No', 'Name', 'District', 'Block', 'GP', 'Partner Agency', 'Month', 'No. of transaction', 'Txn Amount', 'Commission Amount', 'No. Of Days', 'Working Days', 'Non Working Days'));
            $sr_no = 1;
            $row = [];
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $row = [
                    $sr_no,
                    isset($model->bc) ? $model->bc->application_id : '',
                    isset($model->bc) ? $model->bc->name : '',
                    isset($model->district) ? $model->district->district_name : '',
                    isset($model->block) ? $model->block->block_name : '',
                    isset($model->gp) ? $model->gp->gram_panchayat_name : '',
                    isset($model->pbank) ? $model->pbank->bank_short_name : '',
                    isset($model->month_start_date) ? \Yii::$app->formatter->asDatetime($model->month_start_date, "php:M-Y") : '',
                    isset($model->no_of_transaction) ? $model->no_of_transaction : '',
                    $model->transaction_amount,
                    isset($model->commission_amount) ? round($model->commission_amount, 2) : '',
                    isset($model->total_day) ? $model->total_day : '',
                    isset($model->total_working_day) ? $model->total_working_day : '',
                    isset($model->total_not_working_day) ? $model->total_not_working_day : ''
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

    public function actionDailydownload() {
        $null = new \yii\db\Expression('NULL');
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $searchModel = new BcTransactionBcSummaryDailySearch();
//            echo "<pre>";
//            print_r(Yii::$app->request->queryParams);
//            exit;
            if (isset(Yii::$app->request->queryParams['BcTransactionBcSummaryDailySearch']['from_date_time'])) {
                $searchModel->from_date_time = \Yii::$app->request->queryParams['BcTransactionBcSummaryDailySearch']['from_date_time'];
            }
            if (isset(Yii::$app->request->queryParams['BcTransactionBcSummaryDailySearch']['to_date_time'])) {
                $searchModel->to_date_time = \Yii::$app->request->queryParams['BcTransactionBcSummaryDailySearch']['to_date_time'];
            }
            if (isset(Yii::$app->request->queryParams['BcTransactionBcSummaryDailySearch']['date'])) {
                $searchModel->date = \Yii::$app->request->queryParams['BcTransactionBcSummaryDailySearch']['date'];
            }

            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 30);
            $file = "bc_transaction_daily_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Srl. No.', 'Application No', 'Name', 'District', 'Block', 'GP', 'Partner Agency', 'Date', 'No. of transaction', 'Txn Amount', 'Commission Amount'));
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
                    isset($model->date) ? $model->date : '',
                    isset($model->no_of_transaction) ? $model->no_of_transaction : '',
                    $model->transaction_amount,
                    isset($model->commission_amount) ? round($model->commission_amount, 2) : ''
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

    protected function findModelbc($id) {
        if (($model = \bc\modules\selection\models\SrlmBcApplication::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
