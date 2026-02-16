<?php

namespace bc\modules\training\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use bc\modules\training\models\RsetisCenterTrainingSearch;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\training\models\RsetisBatchParticipantsSearch;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\form\DashboardSearchForm;
use bc\modules\training\models\form\AddScoreForm;
use common\models\master\MasterRole;
use yii\web\UploadedFile;
use common\models\CboMembers;
use common\models\User;
use common\models\CboMemberProfile;
use bc\modules\selection\models\BcFiles;
use bc\modules\selection\models\BcFilesSearch;
use bc\components\BCNotification;
use bc\modules\selection\models\BcHonorariumPayment;

class HonorariumController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'payment', 'upload'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'payment', 'upload'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'reset' => ['POST'],
                ],
            ],
        ];
    }

    public function BeforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex() {
       \Yii::$app->params['page_size30'] = 10;
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
        $searchModels = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30'], null);
        $dataProvider->query->andWhere(['srlm_bc_application.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
        $dataProvider->query->andWhere(['not', ['srlm_bc_application.bc_beneficiaries_code' => NULL]]);
        $searchModels1 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider1 = $searchModels1->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider1->query->andWhere(['not', ['month1' => null]]);
        $searchModels2 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider2 = $searchModels2->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider2->query->andWhere(['not', ['month2' => null]]);
        $searchModels3 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider3 = $searchModels3->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider3->query->andWhere(['not', ['month3' => null]]);
        $searchModels4 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider4 = $searchModels4->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider4->query->andWhere(['not', ['month4' => null]]);
        $searchModels5 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider5 = $searchModels5->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider5->query->andWhere(['not', ['month5' => null]]); //->andWhere(['saree1_provided' => 1])->andFilterWhere(['is', 'saree1_acknowledge', new \yii\db\Expression('NULL')]);
        $searchModels6 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider6 = $searchModels6->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider6->query->andWhere(['not', ['month6' => null]]);
        $searchModels7 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider7 = $searchModels7->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider7->query->andWhere(['not', ['month1' => null]])->andFilterWhere(['=', 'month1_acknowledge', 0]);
        $searchModels8 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider8 = $searchModels8->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider8->query->andWhere(['not', ['month2' => null]])->andFilterWhere(['=', 'month2_acknowledge', 0]);

        $searchModels9 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider9 = $searchModels9->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider9->query->andWhere(['not', ['month3' => null]])->andFilterWhere(['=', 'month3_acknowledge', 0]);
        $searchModels10 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider10 = $searchModels10->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider10->query->andWhere(['not', ['month4' => null]])->andFilterWhere(['=', 'month4_acknowledge', 0]);

        $searchModels11 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider11 = $searchModels11->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider11->query->andWhere(['not', ['month5' => null]])->andFilterWhere(['=', 'month5_acknowledge', 0]);
        $searchModels12 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider12 = $searchModels12->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider12->query->andWhere(['not', ['month6' => null]])->andFilterWhere(['=', 'month6_acknowledge', 0]);
        
        
        $searchModels13 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider13 = $searchModels13->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider13->query->andWhere(['not', ['month1' => null]])->andFilterWhere(['!=', 'month1_acknowledge', 0]);
        $searchModels14 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider14 = $searchModels14->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider14->query->andWhere(['not', ['month2' => null]])->andFilterWhere(['!=', 'month2_acknowledge', 0]);

        $searchModels15 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider15 = $searchModels15->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider15->query->andWhere(['not', ['month3' => null]])->andFilterWhere(['!=', 'month3_acknowledge', 0]);
        $searchModels16 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider16 = $searchModels16->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider16->query->andWhere(['not', ['month4' => null]])->andFilterWhere(['!=', 'month4_acknowledge', 0]);

        $searchModels17 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider17 = $searchModels17->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider17->query->andWhere(['not', ['month5' => null]])->andFilterWhere(['!=', 'month5_acknowledge', 0]);
        $searchModels18 = new \bc\modules\selection\models\BcHonorariumPaymentSearch();
        $dataProvider18 = $searchModels15->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider18->query->andWhere(['not', ['month6' => null]])->andFilterWhere(['!=', 'month6_acknowledge', 0]);

        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";
        if ($button_type == "1") {
            $dataProvider = $dataProvider1;
        } elseif ($button_type == "2") {
            $dataProvider = $dataProvider2;
        } elseif ($button_type == "3") {
            $dataProvider = $dataProvider3;
        } elseif ($button_type == "4") {
            $dataProvider = $dataProvider4;
        } elseif ($button_type == "5") {
            $dataProvider = $dataProvider5;
        } elseif ($button_type == "6") {
            $dataProvider = $dataProvider6;
        } elseif ($button_type == "7") {
            $dataProvider = $dataProvider7;
        } elseif ($button_type == "8") {
            $dataProvider = $dataProvider8;
        } elseif ($button_type == "9") {
            $dataProvider = $dataProvider9;
        } elseif ($button_type == "10") {
            $dataProvider = $dataProvider10;
        }elseif ($button_type == "11") {
            $dataProvider = $dataProvider11;
        } elseif ($button_type == "12") {
            $dataProvider = $dataProvider12;
        }elseif ($button_type == "13") {
            $dataProvider = $dataProvider13;
        } elseif ($button_type == "14") {
            $dataProvider = $dataProvider14;
        } elseif ($button_type == "15") {
            $dataProvider = $dataProvider15;
        } elseif ($button_type == "16") {
            $dataProvider = $dataProvider16;
        }elseif ($button_type == "17") {
            $dataProvider = $dataProvider17;
        } elseif ($button_type == "18") {
            $dataProvider = $dataProvider18;
        }
        return $this->render('index', [
                    'button_type' => $button_type,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvider1' => $dataProvider1,
                    'dataProvider2' => $dataProvider2,
                    'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4,
                    'dataProvider5' => $dataProvider5,
                    'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7,
                    'dataProvider8' => $dataProvider8,
                    'dataProvider9' => $dataProvider9,
                    'dataProvider10' => $dataProvider10,
                    'dataProvider11' => $dataProvider11,
                    'dataProvider12' => $dataProvider12,
                    'dataProvider13' => $dataProvider13,
                    'dataProvider14' => $dataProvider14,
                    'dataProvider15' => $dataProvider15,
                    'dataProvider16' => $dataProvider16,
                    'dataProvider17' => $dataProvider17,
                    'dataProvider18' => $dataProvider18,
        ]);
    }
    

    protected function findModel($id) {
        if (($model = RsetisBatchParticipants::find()->where(['id' => $id])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPayment($bcid) {
        $bc_model = $this->findModelbc($bcid);
        if ($bc_model->blocked != '0') {
            return $this->redirect(['/training/honorarium']);
        }
        if ($bc_model->bc_beneficiaries_code == null) {
            return $this->redirect(['/training/honorarium']);
        }
        $model = new \bc\modules\selection\models\form\BcPaymentForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {

            return $this->redirect(['/training/honorarium']);
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('payment_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('payment_form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpload() {
        $model = new \bc\modules\selection\models\form\BcPaymentDistributionForm();
        $model->sample_csv_url = '/training/honorarium/sample?filename=sample_honorarium_payment.csv';
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->file_name = UploadedFile::getInstance($model, 'file_name');
                if ($model->validate()) {
                    if ($model->file_name != NULL) {
                        $new_file_name = time() . '_' . $model->file_name->baseName . '.' . $model->file_name->extension;
                        if (!file_exists(Yii::$app->params['bcdatapath'] . '/tmp')) {
                            mkdir(Yii::$app->params['bcdatapath'] . '/tmp');
                            chmod(Yii::$app->params['bcdatapath'] . '/tmp', 0777);
                        }
                        if (!file_exists(Yii::$app->params['bcdatapath'] . '/tmp' . '/uonorarium')) {
                            mkdir(Yii::$app->params['bcdatapath'] . '/tmp' . '/uonorarium');
                            chmod(Yii::$app->params['bcdatapath'] . '/tmp' . '/uonorarium', 0777);
                        }
                        $TEMP_FILE = Yii::$app->params['bcdatapath'] . '/tmp' . '/uonorarium' . '/' . $new_file_name;

                        if ($model->file_name->saveAs($TEMP_FILE)) {
                            chmod($TEMP_FILE, 0777);
                            $fp = fopen(Yii::$app->params['bcdatapath'] . '/tmp' . '/uonorarium' . '/' . $new_file_name, 'r');
                            if ($fp) {
                                $line = fgetcsv($fp, 1000, ",");
                                $file_row_count = count(file(Yii::$app->params['bcdatapath'] . '/tmp' . '/uonorarium' . '/' . $new_file_name, FILE_SKIP_EMPTY_LINES));
                                $count = count($line);
                                $error_count = 0;
                                $success_count = 0;
//                        echo $count.'</br>';
//                        echo $file_row_count;                        exit();
                                if ($file_row_count < 2 or $file_row_count > 501 or $count != 2) {
                                    \Yii::$app->getSession()->setFlash('success', 'Invalid Honorarium payment  csv');
                                    $model->addError('file_name', 'Invalid Honorarium payment  csv .');
                                    unlink($TEMP_FILE);
                                } else {
                                    $first_time = true;
                                    $i = 0;

                                    do {
                                        if ($first_time == true) {
                                            $first_time = false;
                                            continue;
                                        } else {
                                            $message = '';

                                            $app_model = SrlmBcApplication::findOne(['application_id' => $line[0]]);

                                            if ($app_model == null) {
                                                $message .= 'Application Id not found';
                                                $line[2] = ltrim($message, '<br/>');
                                                array_push($model->rows, $line);
                                                $error_count++;
                                            } else {
                                                if ($app_model->status != 2) {

                                                    $message .= '<br/>Application not selected';
                                                }
                                                if ($app_model->training_status != SrlmBcApplication::TRAINING_STATUS_PASS) {
                                                    $message .= '<br/>Applicant not certified';
                                                }
                                                if (!in_array($app_model->reading_skills, [1, 2])) {

                                                    $message .= '<br/>Applicant Ineligible';
                                                }
                                                if (in_array($app_model->urban_shg, [1])) {
                                                    $message .= '<br/>Applicant Ineligible(GP Urban)';
                                                }
                                                if ($app_model->blocked != '0') {

                                                    $message .= '<br/>Applicant blocked';
                                                }
                                                if ($app_model->bc_beneficiaries_code == null) {
                                                    $message .= '<br/>BC-PFMS Not Mapped';
                                                }
                                                if (!in_array($line[1], [1, 2, 3, 4, 5, 6])) {
                                                    $message .= '<br/> Invalid Payment No';
                                                }

                                                if ($message != '') {
                                                    $line[2] = ltrim($message, '<br/>');
                                                    array_push($model->rows, $line);

                                                    $error_count++;
                                                } else {
                                                    $term = $line[1];
                                                    $hon_model = \bc\modules\selection\models\BcHonorariumPayment::findOne(['bc_application_id' => $app_model->id]);
                                                    $chek_column = 'month' . $term . '_acknowledge_amount';
                                                    $month_c = 'month' . $term;
                                                    $month_payment_amount = 'month' . $term . '_payment_amount';
                                                    $month_payment_date = 'month' . $term . '_payment_date';
                                                    $month_payment_by = 'month' . $term . '_payment_by';
                                                    $month_payment_datetime = 'month' . $term . '_payment_datetime';

                                                    if ($hon_model == null) {
                                                        $hon_model = new \bc\modules\selection\models\BcHonorariumPayment();
                                                        $hon_model->bc_application_id = $app_model->id;
                                                        $hon_model->srlm_bc_selection_user_id = $app_model->srlm_bc_selection_user_id;
                                                        $hon_model->district_code = $app_model->district_code;
                                                        $hon_model->block_code = $app_model->block_code;
                                                        $hon_model->gram_panchayat_code = $app_model->gram_panchayat_code;
                                                    }
                                                    if ($hon_model->$chek_column == null) {
                                                        $hon_model->$month_c = $model->month;
                                                        $hon_model->$month_payment_date = $model->distribution_date;
                                                        $hon_model->$month_payment_amount = BcHonorariumPayment::MONTHLY_PAYMEN_AMOUNT;
                                                        $hon_model->$month_payment_by = \Yii::$app->user->identity->id;
                                                        $hon_model->$month_payment_datetime = new \yii\db\Expression('NOW()');

                                                        if ($hon_model->save()) {
                                                            $success_count++;
                                                        } else {
                                                            $error_count++;
                                                        }
                                                    } else {
                                                        $message .= '<br/> Acknowledge By BC';
                                                        $line[2] = ltrim($message, '<br/>');
                                                        array_push($model->rows, $line);
                                                        $error_count++;
                                                    }
                                                }
                                            }
                                        }
                                        $i++;
                                    } while (($line = fgetcsv($fp, 1000, ",")) != FALSE);

                                    $file_model = new \bc\modules\selection\models\BcHonorariumFiles();
                                    $file_model->month = $model->month;
                                    $file_model->file_name = $new_file_name;
                                    $file_model->distribution_date = $model->distribution_date;
                                    $file_model->error_count = $error_count;
                                    $file_model->success_count = $success_count;
                                    $file_model->row_count = ($file_row_count - 1);
                                    $file_model->upload_by = Yii::$app->user->identity->id;
                                    $file_model->upload_datetime = new \yii\db\Expression('NOW()');
                                    $file_model->save();
                                    $model->fileid = $file_model->id;
                                    \Yii::$app->getSession()->setFlash('success', $success_count . ' records ' . ' of month ' . $model->month . ' successfully');
                                }
                            }
                        }
                    }
                }
            }
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('upload_payment_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('upload_payment_form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDownloadcsv() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            if (Yii::$app->request->isGet)
                $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
            if (Yii::$app->request->isPost)
                $searchModel = new DashboardSearchForm(Yii::$app->request->post());
            $searchModels = new \bc\modules\selection\models\SrlmBcApplicationSearch();

            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

            $dataProvider->query->andWhere(['srlm_bc_application.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dataProvider->query->andWhere(['not', ['srlm_bc_application.bc_beneficiaries_code' => NULL]]);
            if (count($searchModel->district_option) == 1) {
                $searchModel->district_code = key($searchModel->district_option);
            }
            $file = "BC_Honorarium_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Application id', 'BC Name', 'OTP Verified Mobile No.', 'Mobile No.', 'BC District', 'BC Block', 'BC GP','BC Beneficiaries Code', 'Month 1 Name', 'Month 1 Payment Date', 'Month 1 Payment Acknowledge', 'Month 2 Name', 'Month 2 Payment Date', 'Month 2 Payment Acknowledge', 'Month 3 Name', 'Month 3 Payment Date', 'Month 3 Payment Acknowledge', 'Month 4 Name', 'Month 4 Payment Date', 'Month 4 Payment Acknowledge', 'Month 5 Name', 'Month 5 Payment Date', 'Month 5 Payment Acknowledge', 'Month 6 Name', 'Month 6 Payment Date', 'Month 6 Payment Acknowledge'));
            $sr_no = 1;
            $row = [];
            $dataProvider->query->select(['srlm_bc_application.id', 'srlm_bc_application.first_name']);

            $dataProvider->query->asArray();
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $model = SrlmBcApplication::findOne($model['id']);
                $month1 = isset($model->bcpayment->month1) ? date("F Y", strtotime($model->bcpayment->month1)) : '';
                $month1_payment_date = isset($model->bcpayment->month1_payment_date) ? $model->bcpayment->month1_payment_date : '';
                $month1_acknowledge = '';
                if (isset($model->bcpayment->month1)) {
                    if (isset($model->bcpayment->month1_acknowledge_amount)) {
                        $month1_acknowledge = 'Yes';
                    } else {
                        $month1_acknowledge = 'No';
                    }
                }
                $month2 = isset($model->bcpayment->month2) ? date("F Y", strtotime($model->bcpayment->month2)) : '';
                $month2_payment_date = isset($model->bcpayment->month2_payment_date) ? $model->bcpayment->month2_payment_date : '';
                $month2_acknowledge = '';
                if (isset($model->bcpayment->month2)) {
                    if (isset($model->bcpayment->month2_acknowledge_amount)) {
                        $month2_acknowledge = 'Yes';
                    } else {
                        $month2_acknowledge = 'No';
                    }
                }
                $month3 = isset($model->bcpayment->month3) ? date("F Y", strtotime($model->bcpayment->month3)) : '';
                $month3_payment_date = isset($model->bcpayment->month3_payment_date) ? $model->bcpayment->month3_payment_date : '';
                $month3_acknowledge = '';
                if (isset($model->bcpayment->month3)) {
                    if (isset($model->bcpayment->month3_acknowledge_amount)) {
                        $month3_acknowledge = 'Yes';
                    } else {
                        $month3_acknowledge = 'No';
                    }
                }
                $month4 = isset($model->bcpayment->month4) ? date("F Y", strtotime($model->bcpayment->month4)) : '';
                $month4_payment_date = isset($model->bcpayment->month4_payment_date) ? $model->bcpayment->month4_payment_date : '';
                $month4_acknowledge = '';
                if (isset($model->bcpayment->month4)) {
                    if (isset($model->bcpayment->month4_acknowledge_amount)) {
                        $month4_acknowledge = 'Yes';
                    } else {
                        $month4_acknowledge = 'No';
                    }
                }
                $month5 = isset($model->bcpayment->month5) ? date("F Y", strtotime($model->bcpayment->month5)) : '';
                $month5_payment_date = isset($model->bcpayment->month5_payment_date) ? $model->bcpayment->month5_payment_date : '';
                $month5_acknowledge = '';
                if (isset($model->bcpayment->month5)) {
                    if (isset($model->bcpayment->month5_acknowledge_amount)) {
                        $month5_acknowledge = 'Yes';
                    } else {
                        $month5_acknowledge = 'No';
                    }
                }
                $month6 = isset($model->bcpayment->month6) ? date("F Y", strtotime($model->bcpayment->month6)) : '';
                $month6_payment_date = isset($model->bcpayment->month6_payment_date) ? $model->bcpayment->month6_payment_date : '';
                $month6_acknowledge = '';
                if (isset($model->bcpayment->month6)) {
                    if (isset($model->bcpayment->month6_acknowledge_amount)) {
                        $month6_acknowledge = 'Yes';
                    } else {
                        $month6_acknowledge = 'No';
                    }
                }
                $row = [
                    $sr_no,
                    $model->application_id,
                    trim($model->name),
                    $model->mobile_no,
                    $model->mobile_number,
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    $model->bc_beneficiaries_code,
                    $month1,
                    $month1_payment_date,
                    $month1_acknowledge,
                    $month2,
                    $month2_payment_date,
                    $month2_acknowledge,
                    $month3,
                    $month3_payment_date,
                    $month3_acknowledge,
                    $month4,
                    $month4_payment_date,
                    $month4_acknowledge,
                    $month5,
                    $month5_payment_date,
                    $month5_acknowledge,
                    $month6,
                    $month6_payment_date,
                    $month6_acknowledge
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit();
        } catch (\Exception $ex) {
            print_r($ex->getMessage());exit;
        }
    }

    public function actionSample($filename) {

        header('Content-type: application/csv');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        readfile(\Yii::getAlias("@bc/web/sample/") . $filename);
        exit();
    }

    protected function findModelbc($id) {
        if (($model = SrlmBcApplication::find()->where(['id' => $id])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelShg($id) {
        if (($model = \cbo\models\Shg::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
