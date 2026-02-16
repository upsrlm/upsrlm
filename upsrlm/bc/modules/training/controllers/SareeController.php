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
use bc\modules\selection\models\BcProvidedSaree;
use bc\modules\selection\models\form\BCProvidedSareeForm;

class SareeController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'provided', 'upload'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'provided', 'upload'],
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
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
        $searchModels = new \bc\modules\selection\models\SrlmBcApplicationSearch();

        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->andWhere(['srlm_bc_application.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
        if ($searchModel->both_saree_status) {
            $dataProvider->query->joinWith(['bcsaree']);
            if ($searchModel->both_saree_status == 1) {
                $dataProvider->query->andWhere(['saree1_provided' => 1, 'saree2_provided' => 1]);
            }
            if ($searchModel->both_saree_status == 2) {
               $dataProvider->query->andWhere(['saree1_provided' => 1, 'saree2_provided' => 1, 'saree1_acknowledge' => [1, 2], 'saree2_acknowledge' => [1, 2]]); 
            }
            if ($searchModel->both_saree_status == 3) {
               $dataProvider->query->andWhere(['saree1_provided' => 1, 'saree2_provided' => 1, 'saree1_acknowledge' => 1, 'saree2_acknowledge' => 1]);  
            }
        }
        $searchModels1 = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider1 = $searchModels1->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider1->query->joinWith(['bcsaree']);
        $dataProvider1->query->andWhere(['saree1_provided' => 1]);
        $searchModels2 = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider2 = $searchModels2->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider2->query->joinWith(['bcsaree']);
        $dataProvider2->query->andWhere(['saree2_provided' => 1]);
        $searchModels3 = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider3 = $searchModels3->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider3->query->joinWith(['bcsaree']);
        $dataProvider3->query->andWhere(['saree1_provided' => 1, 'saree1_acknowledge' => [1, 2]]);
        $searchModels4 = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider4 = $searchModels4->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider4->query->joinWith(['bcsaree']);
        $dataProvider4->query->andWhere(['saree2_provided' => 1, 'saree2_acknowledge' => [1, 2]]);
        $searchModels5 = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider5 = $searchModels5->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider5->query->joinWith(['bcsaree']);
        $dataProvider5->query->andWhere(['saree1_provided' => 1])->andFilterWhere(['is', 'saree1_acknowledge', new \yii\db\Expression('NULL')]);
        $searchModels6 = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider6 = $searchModels6->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider6->query->joinWith(['bcsaree']);
        $dataProvider6->query->andWhere(['saree2_provided' => 1])->andFilterWhere(['is', 'saree2_acknowledge', new \yii\db\Expression('NULL')]);
        $searchModels7 = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider7 = $searchModels7->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider7->query->joinWith(['bcsaree']);
        $dataProvider7->query->andWhere(['saree1_provided' => 1, 'saree1_acknowledge' => 1]);
        $searchModels8 = new \bc\modules\selection\models\SrlmBcApplicationSearch();

        $dataProvider8 = $searchModels8->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider8->query->joinWith(['bcsaree']);
        $dataProvider8->query->andWhere(['saree1_provided' => 1, 'saree1_acknowledge' => 2]);

        $searchModels9 = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider9 = $searchModels9->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider9->query->joinWith(['bcsaree']);
        $dataProvider9->query->andWhere(['saree2_provided' => 1, 'saree2_acknowledge' => 1]);
        $searchModels10 = new \bc\modules\selection\models\SrlmBcApplicationSearch();

        $dataProvider10 = $searchModels10->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider10->query->joinWith(['bcsaree']);
        $dataProvider10->query->andWhere(['saree2_provided' => 1, 'saree2_acknowledge' => 2]);

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
        ]);
    }

    protected function findModel($id) {
        if (($model = RsetisBatchParticipants::find()->where(['id' => $id])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionProvided($bcid) {
        $bc_model = $this->findModelbc($bcid);
        if ($bc_model->blocked != '0') {
            return $this->redirect(['/training/saree/index?DashboardSearchForm[district_code]=' . $bc_model->district_code . '&DashboardSearchForm[block_code]=' . $bc_model->block_code]);
        }

        $model = new BCProvidedSareeForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {
            return $this->redirect(['/training/saree/index?DashboardSearchForm[district_code]=' . $bc_model->district_code . '&DashboardSearchForm[block_code]=' . $bc_model->block_code]);
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('provided_saree_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('provided_saree_form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpload() {
        $model = new \bc\modules\selection\models\form\BcSareeDistributionForm();
        $model->sample_csv_url = '/training/saree/sample?filename=sample_saree_distribution.csv';
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
                        if (!file_exists(Yii::$app->params['bcdatapath'] . '/tmp' . '/saree')) {
                            mkdir(Yii::$app->params['bcdatapath'] . '/tmp' . '/saree');
                            chmod(Yii::$app->params['bcdatapath'] . '/tmp' . '/saree', 0777);
                        }
                        $TEMP_FILE = Yii::$app->params['bcdatapath'] . '/tmp' . '/saree' . '/' . $new_file_name;

                        if ($model->file_name->saveAs($TEMP_FILE)) {
                            chmod($TEMP_FILE, 0777);
                            $fp = fopen(Yii::$app->params['bcdatapath'] . '/tmp' . '/saree' . '/' . $new_file_name, 'r');
                            if ($fp) {
                                $line = fgetcsv($fp, 1000, ",");
                                $file_row_count = count(file(Yii::$app->params['bcdatapath'] . '/tmp' . '/saree' . '/' . $new_file_name, FILE_SKIP_EMPTY_LINES));
                                $count = count($line);
                                $error_count = 0;
                                $success_count = 0;
//                        echo $count.'</br>';
//                        echo $file_row_count;                        exit();
                                if ($file_row_count < 2 or $file_row_count > 501 or $count != 1) {
                                    \Yii::$app->getSession()->setFlash('success', 'Invalid Saree Distribution BC CSV file');
                                    $model->addError('file_name', 'Invalid Saree Distribution BC CSV file .');
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
                                                $line[1] = ltrim($message, '<br/>');
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


                                                if ($message != '') {
                                                    $line[1] = ltrim($message, '<br/>');
                                                    array_push($model->rows, $line);
                                                    $error_count++;
                                                } else {
                                                    $bc_saree_model = \bc\modules\selection\models\BcProvidedSaree::findOne(['bc_application_id' => $app_model->id]);
                                                    $chek_column = 'saree' . $model->saree . '_acknowledge';
                                                    $saree_c = 'saree' . $model->saree . '_provided';
                                                    $saree_provided_date = 'saree' . $model->saree . '_provided_date';
                                                    $saree_provided_by = 'saree' . $model->saree . '_provided_by';
                                                    $saree_provided_datetime = 'saree' . $model->saree . '_provided_datetime';

                                                    if ($bc_saree_model == null) {
                                                        $bc_saree_model = new \bc\modules\selection\models\BcProvidedSaree();
                                                        $bc_saree_model->bc_application_id = $app_model->id;
                                                        $bc_saree_model->srlm_bc_selection_user_id = $app_model->srlm_bc_selection_user_id;
                                                        $bc_saree_model->district_code = $app_model->district_code;
                                                        $bc_saree_model->block_code = $app_model->block_code;
                                                        $bc_saree_model->gram_panchayat_code = $app_model->gram_panchayat_code;
                                                    }
                                                    if ($bc_saree_model->$chek_column == null) {
                                                        $bc_saree_model->$saree_c = 1;
                                                        $bc_saree_model->$saree_provided_date = $model->distribution_date;
                                                        $bc_saree_model->$saree_provided_by = \Yii::$app->user->identity->id;
                                                        $bc_saree_model->$saree_provided_datetime = new \yii\db\Expression('NOW()');

                                                        if ($bc_saree_model->save()) {
                                                            $success_count++;
                                                        } else {
                                                            print_r($bc_saree_model->getErrors());
                                                            $error_count++;
                                                        }
                                                    } else {
                                                        $message .= '<br/> Acknowledge By BC';
                                                        $line[1] = ltrim($message, '<br/>');
                                                        array_push($model->rows, $line);
                                                        $error_count++;
                                                    }
                                                }
                                            }
                                        }
                                        $i++;
                                    } while (($line = fgetcsv($fp, 1000, ",")) != FALSE);

                                    $file_model = new \bc\modules\selection\models\BcSareeFiles();
                                    $file_model->saree = $model->saree;
                                    $file_model->file_name = $new_file_name;
                                    $file_model->distribution_date = $model->distribution_date;
                                    $file_model->error_count = $error_count;
                                    $file_model->success_count = $success_count;
                                    $file_model->row_count = ($file_row_count - 1);
                                    $file_model->upload_by = Yii::$app->user->identity->id;
                                    $file_model->upload_datetime = new \yii\db\Expression('NOW()');
                                    $file_model->save();
                                    $model->fileid = $file_model->id;
                                    \Yii::$app->getSession()->setFlash('success', $success_count . ' records ' . ' of saree ' . $model->saree . ' successfully');
                                }
                            }
                        }
                    }
                }
            }
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('upload_saree_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('upload_saree_form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionSample($filename) {

        header('Content-type: application/csv');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        readfile(\Yii::getAlias("@bc/web/sample/") . $filename);
        exit();
    }

    public function actionView($bcid) {
        $bc_model = $this->findModelbc($bcid);

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                        'model' => $bc_model,
            ]);
        } else {
            return $this->render('view', [
                        'model' => $bc_model,
            ]);
        }
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
    public function actionResetmenu($userid) {
        $user_model = $this->findModelUser($userid);
        if ($user_model->role == 100) {
            $rista = new \sakhi\components\Rishta($user_model);
            $user_model->user_app_data_update = 1;
            $user_model->menu_version_major = \common\models\base\GenralModel::MENU_MAJOR_VERSION;
            $user_model->menu_version_minor = ($user_model->menu_version_minor + 1);
            $user_model->menu_version = ($user_model->menu_version_major + ('.' . $user_model->menu_version_minor));
            $user_model->splash_screen = $rista->splash_screen($user_model);
            $user_model->last_menu_updatetime = date("Y-m-d h:i:s");
            $user_model->save();
            $rishta_user_data_model = \common\models\rishta\RishtaUserData::findOne(['user_id' => $user_model->id]);
            if ($rishta_user_data_model == null) {
                $rishta_user_data_model = new \common\models\rishta\RishtaUserData();
            }
            $rishta_user_data_model->user_id = $user_model->id;
            $rishta_user_data_model->menu_json = json_encode($rista->rishta_menu());
            $rishta_user_data_model->splash_screen_value = $rista->splash_screen_value($user_model);
            if ($rishta_user_data_model->save()) {
                \Yii::$app->getSession()->setFlash('success', 'Reset menu successfully');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
     protected function findModelUser($id) {
        $user = User::findOne($id);
        if ($user === null) {
            throw new NotFoundHttpException('The requested page does not exist');
        }

        return $user;
    }
}
