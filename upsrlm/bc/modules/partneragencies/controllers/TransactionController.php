<?php

namespace bc\modules\partneragencies\controllers;

use Yii;
use bc\modules\selection\models\SrlmBcApplication;
use bc\models\master\MasterPartnerBank;
use bc\models\transaction\BcTransactionFiles;
use bc\models\transaction\BcTransactionFilesSearch;
use bc\models\transaction\BcTransaction;
use bc\models\transaction\BcTransactionSearch;
use bc\models\transaction\BcTransactionTable1;
use bc\models\transaction\BcTransactionTable2;
use bc\models\transaction\BcTransactionTable3;
use bc\models\transaction\BcTransactionTable4;
use bc\models\transaction\BcTransactionTable5;
use bc\models\transaction\BcTransactionTable6;
use bc\models\transaction\BcTransactionMasterMonth;
use bc\models\transaction\BcTransactionMasterMonthSearch;
use bc\models\transaction\BcTransactionMasterWeek;
use bc\models\transaction\BcTransactionMasterWeekSearch;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

ini_set('max_execution_time', 1200);
ini_set('memory_limit', '-1');

/**
 * TransactionController implements the CRUD actions for PartnerAssociates model.
 */
class TransactionController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'import', 'importfile', 'primaryreport', 'secondaryreport', 'report', 'reportadmin', 'dailydownload', 'weekly', 'monthly', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'import', 'importfile', 'primaryreport', 'secondaryreport', 'report', 'reportadmin', 'dailydownload', 'weekly', 'monthly', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all PartnerAssociates models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BcTransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
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

//    public function actionWobcid() {
//        $null = new \yii\db\Expression('NULL');
//        $searchModel = new BcTransactionSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
//        $dataProvider->query->andFilterWhere(['is', 'bc_application_id', $null]);
//        $dataProvider->query->addOrderBy("bankidbc asc");
//        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
//        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
//        if (count($searchModel->district_option) == 1) {
//            $searchModel->district_code = key($searchModel->district_option);
//        }
//        if ($searchModel->district_code) {
//            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
//        }
//        if ($searchModel->block_code) {
//            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
//        }
//        return $this->render('wobcid', [
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//        ]);
//    }

    public function actionWouniquebcid() {
        $null = new \yii\db\Expression('NULL');
        $searchModel = new \bc\modules\transaction\models\dump\BcTransactionBankSearch();
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if (count($searchModel->bank_option) == 1) {
            $searchModel->master_partner_bank_id = key($searchModel->bank_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], 'bankidbc');
        $dataProvider->query->andFilterWhere(['is', 'bc_application_id', $null]);
        $dataProvider->query->addOrderBy("bankidbc asc");

        return $this->render('wouniquebcid', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

//    public function actionReport() {
//        $searchModel = new BcTransactionSearch();
//        $searchModel->month_option = $searchModel->monthoption(Yii::$app->request->queryParams, Yii::$app->user->identity);
//
//        $searchModel->setAttributes(Yii::$app->request->queryParams);
//        if (!isset(Yii::$app->request->queryParams['BcTransactionSearch']['month'])) {
//            $date = new \DateTime('now');
//            $date->modify('first day of this month');
//            $searchModel->month = $date->format('Y-m-d');
//        } else {
//            if (Yii::$app->request->queryParams['BcTransactionSearch']['month'] == '') {
//                $date = new \DateTime('now');
//                $date->modify('first day of this month');
//                $searchModel->month = $date->format('Y-m-d');
//            } else {
//                $searchModel->month = Yii::$app->request->queryParams['BcTransactionSearch']['month'];
//            }
//        }
//        $searchModel->SetDate($searchModel->month);
//        $dataProvider = $searchModel->reportsearch(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
//        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
//        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
//        if (count($searchModel->district_option) == 1) {
//            $searchModel->district_code = key($searchModel->district_option);
//        }
//        if ($searchModel->district_code) {
//            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
//        }
//        if ($searchModel->block_code) {
//            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
//        }
//
//        return $this->render('report', [
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//        ]);
//    }

    public function actionReportadmin() {
        $searchModel = new \bc\models\transaction\report\Report(Yii::$app->request->post());
        $searchModel->month_option = $searchModel->monthoption(Yii::$app->request->post(), Yii::$app->user->identity);
        $dataProvider = $searchModel->monthly(Yii::$app->request->post(), Yii::$app->user->identity);
        return $this->render('reportadmin', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($fileid) {
        $model = $this->findModel($fileid);
        $model->status = -3;
        $model->new_process = -3;
        if ($model->save()) {
            \Yii::$app->getSession()->setFlash('success', 'BC Transation files deleted successfully');
            return $this->redirect(['import']);
        }
    }

    public function actionPrimaryreport() {
        \Yii::$app->params['page_size30'] = 5;
        $searchModel = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryDailySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel1 = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryDailySearch();
        $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
//        $searchModel2 = new BcTransactionSearch();
//        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
//        $searchModel3 = new BcTransactionSearch();
//        $dataProvider3 = $searchModel3->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
//        $searchModel4 = new BcTransactionSearch();
//        $dataProvider4 = $searchModel4->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
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
        $dataProviderdata = null;
        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";
        if ($button_type == "1") {
            $searchModelbc = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryDailySearch();
            $dataProviderbc = $searchModelbc->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], 'bc_application_id');
            $dataProviderdata = $dataProviderbc;
        } elseif ($button_type == "2") {

            $dataProviderdata = $dataProvider1;
        } elseif ($button_type == "3") {
            $dataProviderdata = $dataProvider1;
        } elseif ($button_type == "4") {


            $dataProviderdata = $dataProvider1;
        }
        return $this->render('primaryreport', [
                    'button_type' => $button_type,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvider1' => $dataProvider1,
                    'dataProvider2' => $dataProvider1,
                    'dataProvider3' => $dataProvider1,
                    'dataProvider4' => $dataProvider1,
                    'dataProviderdata' => $dataProviderdata,
        ]);
    }

//    public function actionSecondaryreport() {
//        $searchModel = new BcTransactionSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
//        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
//        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
//        if (count($searchModel->district_option) == 1) {
//            $searchModel->district_code = key($searchModel->district_option);
//        }
//        if ($searchModel->district_code) {
//            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
//        }
//        if ($searchModel->block_code) {
//            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
//        }
//        $dataProviderdata = null;
//        $searchModel1 = new BcTransactionSearch();
//        $searchModel1->ticket = BcTransaction::BIG_TICKET;
//        $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
//        $searchModel2 = new BcTransactionSearch();
//        $searchModel2->ticket = BcTransaction::SMALL_TICKET;
//        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
//        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";
//        if ($button_type == "1") {
//
//            $dataProviderdata = $dataProvider1;
//        } elseif ($button_type == "2") {
//
//            $dataProviderdata = $dataProvider2;
//        }
//        return $this->render('secondaryreport', [
//                    'button_type' => $button_type,
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//                    'dataProvider1' => $dataProvider1,
//                    'dataProvider2' => $dataProvider2,
//                    'dataProviderdata' => $dataProviderdata,
//        ]);
//    }
//    public function actionMonthly() {
//        $searchModel = new BcTransactionMasterMonthSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $current_month_id = \bc\modules\selection\models\base\GenralModel::current_month_id();
//        $dataProvider->query->andWhere(['<=', BcTransactionMasterMonth::getTableSchema()->fullName . '.id', $current_month_id]);
//        $dataProvider->query->andWhere(['>=', BcTransactionMasterMonth::getTableSchema()->fullName . '.id', 6]);
//        return $this->render('monthly', [
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//        ]);
//    }
//
//    public function actionWeekly() {
//        $searchModel = new BcTransactionMasterWeekSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $current_week_id = \bc\modules\selection\models\base\GenralModel::current_week_id();
//        $dataProvider->query->andWhere(['<=', BcTransactionMasterWeek::getTableSchema()->fullName . '.id', $current_week_id]);
//        $dataProvider->query->andWhere(['>=', BcTransactionMasterWeek::getTableSchema()->fullName . '.id', 23]);
//        return $this->render('weekly', [
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//        ]);
//    }

    public function actionImport() {
        $user_model = Yii::$app->user->identity;
        if (in_array($user_model->role, [\common\models\master\MasterRole::ROLE_ADMIN])) {
            
        } else {
            if (!$user_model->master_partner_bank_id) {
                \Yii::$app->getSession()->setFlash('error', "you are not authorized to perform this operation ");
                return $this->redirect('/transaction/report');
                exit;
            }
             if ($user_model->master_partner_bank_id==MasterPartnerBank::BOB) {
//                \Yii::$app->getSession()->setFlash('error', "Now you are not authorized to perform this operation ");
//                return $this->redirect('/transaction/report');
//                exit;
            }
        }
        $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
        $model = new \bc\models\transaction\form\UploadCsvTransactionForm();
        $model->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option();
        if ($user_model->master_partner_bank_id) {
            $model->master_partner_bank_id = $user_model->master_partner_bank_id;
        }
        $model->page_title = 'Upload CSV for BC Transaction';
        $searchModel = new BcTransactionFilesSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 10);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $rows = [];
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->csvfile = UploadedFile::getInstance($model, 'csvfile');
            $model->file_model = new BcTransactionFiles();
            $model->file_model->master_partner_bank_id = $model->master_partner_bank_id;
            if ($model->csvfile != NULL) {
                $new_file_name = time() . '_' . $model->csvfile->baseName . '.' . $model->csvfile->extension;
                if (!file_exists(Yii::$app->params['datapath'] . '/partneragencies')) {
                    mkdir(Yii::$app->params['datapath'] . '/partneragencies');
                    chmod(Yii::$app->params['datapath'] . '/partneragencies', 0777);
                }
                if (!file_exists(Yii::$app->params['datapath'] . '/partneragencies' . '/transaction')) {
                    mkdir(Yii::$app->params['datapath'] . '/partneragencies' . '/transaction');
                    chmod(Yii::$app->params['datapath'] . '/partneragencies' . '/transaction', 0777);
                }
                if (!file_exists(Yii::$app->params['datapath'] . '/partneragencies' . '/transaction/' . $model->master_partner_bank_id)) {
                    mkdir(Yii::$app->params['datapath'] . '/partneragencies' . '/transaction/' . $model->master_partner_bank_id);
                    chmod(Yii::$app->params['datapath'] . '/partneragencies' . '/transaction/' . $model->master_partner_bank_id, 0777);
                }
                $TEMP_FILE = Yii::$app->params['datapath'] . '/partneragencies' . '/transaction/' . $model->master_partner_bank_id . '/' . $new_file_name;
                if ($model->csvfile->saveAs($TEMP_FILE)) {
                    chmod($TEMP_FILE, 0777);
                    $fp = fopen(Yii::$app->params['datapath'] . '/partneragencies' . '/transaction/' . $model->master_partner_bank_id . '/' . $new_file_name, 'r');
                    if ($fp) {
                        $line = fgetcsv($fp, 1000, ",");
                        $file_row_count = count(file(Yii::$app->params['datapath'] . '/partneragencies' . '/transaction/' . $model->master_partner_bank_id . '/' . $new_file_name, FILE_SKIP_EMPTY_LINES));
                        $model->file_model->file_name = $new_file_name;
                        $model->file_model->label = $model->label;
                        $model->file_model->row_count = ($file_row_count - 1);
                        $model->file_model->upload_by = Yii::$app->user->identity->id;
                        $model->file_model->upload_datetime = new \yii\db\Expression('NOW()');
                        if ($model->file_model->save()) {
                            return $this->refresh();
//                            if ($model->dump($model->file_model)) {
//                                if ($model->transaction($model->file_model)) {
//                                    
//                                }
//                            }
                        }
                    }
                }
            }
        }
        return $this->render('_importform', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

//    public function actionDailydownload() {
//
//        ini_set('max_execution_time', 1200);
//        ini_set('memory_limit', '2048M');
//        try {
//            $searchModel = new BcTransactionSearch();
//            if (Yii::$app->request->isGet)
//                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
//            if (Yii::$app->request->isPost)
//                $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
//            $file = "bc_transaction.csv";
//            if ($searchModel->transaction_date)
//                $file = "bc_transaction_" . $searchModel->transaction_date . ".csv";
//            if ($searchModel->from_date_time)
//                $file = "bc_transaction_" . \Yii::$app->formatter->asDatetime($searchModel->from_date_time, "php:M-Y") . ".csv";
//            header('Content-Type: text/csv; charset=utf-8');
//            header("Content-Disposition: attachment; filename=$file");
//            $output = fopen('php://output', 'w');
//            fputcsv($output, array('usr_id', 'txn_id', 'product_type', 'txn_value', 'datetime', 'bc_commison'));
//            $sr_no = 1;
//            $row = [];
//            $dataProvider->pagination = false;
//            $models = $dataProvider->getModels();
//            foreach ($models as $model) {
//                $row = [
//                    $model->bankidbc,
//                    $model->banktransactionid,
//                    $model->transaction_type,
//                    $model->transaction_amount,
//                    $model->transaction_datetime,
//                    $model->commission_amount
//                ];
//                fputcsv($output, $row);
//                $sr_no++;
//            }
//            exit();
//        } catch (\Exception $ex) {
//            
//        }
//    }

    public function actionImportfile($fileid) {
        $file_model = BcTransactionFiles::findOne($fileid);
        header('Content-type: application/csv');
        header('Content-Disposition: attachment;filename="' . $file_model->file_name . '"');
        readfile(Yii::$app->params['datapath'] . '/partneragencies' . '/transaction/' . $file_model->master_partner_bank_id . '/' . $file_model->file_name);
        exit();
    }

    public function actionErrorfile($fileid) {
        $file_model = BcTransactionFiles::findOne($fileid);
        $file_path = Yii::$app->params['datapath'] . '/partneragencies' . '/transaction/' . $file_model->master_partner_bank_id . '/';
        $file_csv_path = Yii::$app->params['datapath'] . '/partneragencies' . '/transaction/' . $file_model->master_partner_bank_id . '/' . $file_model->file_name;
        $file_csv_name = basename($file_csv_path, ".csv");
        $error_file_name = $file_csv_name . '_error.csv';
        header('Content-type: application/csv');
        header('Content-Disposition: attachment;filename="' . $error_file_name . '"');
        readfile(Yii::$app->params['datapath'] . '/partneragencies' . '/transaction/' . $file_model->master_partner_bank_id . '/' . $error_file_name);
        exit();
    }

    public function actionErrordetail($fileid) {
        $file_model = BcTransactionFiles::findOne($fileid);
        $file_path = Yii::$app->params['datapath'] . '/partneragencies' . '/transaction/' . $file_model->master_partner_bank_id . '/';
        $file_csv_path = Yii::$app->params['datapath'] . '/partneragencies' . '/transaction/' . $file_model->master_partner_bank_id . '/' . $file_model->file_name;
        $file_csv_name = basename($file_csv_path, ".csv");
        $error_file_name = $file_csv_name . '_error.csv';
        try {
            $csv = fopen(Yii::$app->params['datapath'] . '/partneragencies' . '/transaction/' . $file_model->master_partner_bank_id . '/' . $error_file_name, 'r');
            $rows = [];
            $header = [];
            $index = 0;
            while (($line = fgetcsv($csv)) !== FALSE) {
                if ($index == 0) {
                    $header = $line;
                    $index = 1;
                } else {
                    $row = [];
                    for ($i = 0; $i < count($header); $i++) {
                        $row[$header[$i]] = $line[$i];
                    }
                    array_push($rows, $row);
                }
            }
            $data_obj = json_encode($rows);
            return $this->render('errordetail', [
                        'model' => $file_model, 'data' => $data_obj
            ]);
        } catch (Exception $exception) {
            return false;
        }
    }

    public function actionSample() {
        $filename = 'sample_bc_transaction.csv';
        header('Content-type: application/csv');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        readfile(\Yii::getAlias("@bc/web/sample/") . $filename);
        exit();
    }

    public function actionDownloadwobcid() {
        $null = new \yii\db\Expression('NULL');
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        try {
            $searchModel = new \bc\modules\transaction\models\dump\BcTransactionBankSearch();
            $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
            $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
            if (count($searchModel->district_option) == 1) {
                $searchModel->district_code = key($searchModel->district_option);
            }
            if (count($searchModel->bank_option) == 1) {
                $searchModel->master_partner_bank_id = key($searchModel->bank_option);
            }
            if ($searchModel->district_code) {
                $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
            }
            if ($searchModel->block_code) {
                $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
            }
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], 'bankidbc');
            $dataProvider->query->andFilterWhere(['is', 'bc_application_id', $null]);
            $dataProvider->query->addOrderBy("bankidbc asc");
            $file = "bc_transaction_without_map_.csv";

            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Srl. No.', 'Bank ID', 'Partner agencies', 'No Of Transaction'));
            $sr_no = 1;
            $row = [];
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $row = [
                    $sr_no,
                    $model->bankidbc,
                    $model->pbank->bank_short_name,
                    $model->no_of_transaction
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit();
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
            exit;
        }
    }

    protected function findModel($id) {
        if (($model = BcTransactionFiles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
