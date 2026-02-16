<?php

namespace bc\modules\training\controllers;

use Yii;
use yii\web\Controller;
use bc\modules\selection\models\form\DashboardSearchForm;
use bc\models\master\MasterDistrictSearch;
use bc\models\master\MasterBlockSearch;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\models\srlm\SrlmBcApplicationGroupFamily;
use common\models\master\MasterRole;
use bc\components\srlm\BcApplication;
use bc\models\srlm\report\Graph;
use bc\modules\training\models\form\TrainingAgreeForm;

/**
 * Default controller for the `nfsaSurvey` module
 */
class PreselectedController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'agree', 'alreadycertified', 'reset', 'addbatch', 'unwilling', 'unwillinglist', 'ineligible', 'ineligiblelist', 'blocked', 'certifiedblocked', 'certifiedblockeddownload', 'mobileinuse', 'mobileinusedownload', 'addmobileno', 'aadharduplicacy', 'bcnameupdate'],
                'rules' => [
                    [
                        'actions' => ['index', 'agree', 'alreadycertified', 'reset', 'addbatch', 'unwilling', 'unwillinglist', 'ineligible', 'ineligiblelist', 'blocked', 'certifiedblocked', 'certifiedblockeddownload', 'mobileinuse', 'mobileinusedownload', 'addmobileno', 'aadharduplicacy', 'bcnameupdate'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest );
                        }
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

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {

        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new SrlmBcApplicationSearch();
        $searchModel->training_status = 0;
        $searchModels->training_status = 0;
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 50, null, \bc\modules\selection\models\base\GenralModel::select_preselected_bc_column());
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.form_number', '6']);
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.gender', '2']);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
//        $dataProvider->query->andWhere(['missing_bc' => 0]);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.urban_shg' => 0]);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.blocked' => 0]);
        //$dataProvider->query->andWhere(['not in', 'srlm_bc_application.selection_by', [15]]);
//        $dataProvider->query->andWhere(['=', 'selection_by', '1']);
        $dataProvider->query->addOrderBy("first_name asc");

        $searchModelsagree = new SrlmBcApplicationSearch();
        $searchModel->training_status = 1;
        $dataProvideragree = $searchModelsagree->search([], Yii::$app->user->identity, \Yii::$app->params['page_size30'], null, ['srlm_bc_application.id']);

        $dataProvideragree->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.form_number', '6']);
        $dataProvideragree->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.gender', '2']);
        $dataProvideragree->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.training_status', $searchModel->training_status]);
        $dataProvideragree->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.district_code', $searchModel->district_code]);
        $dataProvideragree->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvideragree' => $dataProvideragree,
        ]);
    }

    public function actionCall($bcid, $log_id) {
        $bc_model = $this->findModel($bcid);
        $log_model = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::findOne(['id' => $log_id]);
        if ($bc_model->status == 2 and $bc_model->training_status == 0) {
            $model = new \bc\modules\training\models\form\CloudLog($bc_model, $log_model);
            $this->performAjaxValidation($model);
            if ($model->load(Yii::$app->request->post())) {
                if (!in_array($model->upsrlm_connection_status, [\common\models\base\GenralModel::CONNECTION_STATUS_PHONE_PICKED])) {
                    $model->bc_model->rsetis_call_log_id = $model->log_model->id;
                    $model->log_model->upsrlm_connection_status = $model->upsrlm_connection_status;
                } else {
                    if (!in_array($model->upsrlm_call_status, [\common\models\base\GenralModel::CALL_STATUS_CALL_CONTINUED])) {
                        $model->bc_model->rsetis_call_log_id = $model->log_model->id;
                        $model->log_model->upsrlm_connection_status = $model->upsrlm_connection_status;
                        $model->log_model->upsrlm_call_status = $model->upsrlm_call_status;
                    } else {
                        if ($model->upsrlm_connection_status == \common\models\base\GenralModel::CONNECTION_STATUS_PHONE_PICKED and $model->upsrlm_call_status == \common\models\base\GenralModel::CALL_STATUS_CALL_CONTINUED and $model->action_status == 1) {
                            $model->bc_model->rsetis_call_log_id = $model->log_model->id;
                            $model->bc_model->training_status = 1;
                            $model->bc_model->call_by_rsetis = Yii::$app->user->identity->id;
                            $model->bc_model->call_rsetis_datetime = new \yii\db\Expression('NOW()');
                            $model->bc_model->updated_at = time();
                            $model->bc_model->action_type = SrlmBcApplication::ACTION_TYPE_RSETHIS_AGREE;
                            $model->log_model->upsrlm_connection_status = $model->upsrlm_connection_status;
                            $model->log_model->upsrlm_call_status = $model->upsrlm_call_status;
                        }
                        if ($model->upsrlm_connection_status == \common\models\base\GenralModel::CONNECTION_STATUS_PHONE_PICKED and $model->upsrlm_call_status == \common\models\base\GenralModel::CALL_STATUS_CALL_CONTINUED and $model->action_status == 2) {
                            $model->bc_model->rsetis_call_log_id = $model->log_model->id;
                            $model->log_model->upsrlm_connection_status = $model->upsrlm_connection_status;
                            $model->log_model->upsrlm_call_status = $model->upsrlm_call_status;
                            $unwilling_model = new \bc\modules\selection\models\form\UnwillingRsetisForm($bc_model);
                            $unwilling_model->unwilling_reason = $model->unwilling_reason;
                            if ($unwilling_model->validate() and $unwilling_model->save()) {
                                
                            }
                        }
                    }
                }

                if ($model->bc_model->save()) {
                    return $this->redirect(['/training/preselected?DashboardSearchForm[district_code]=' . $bc_model->district_code . '&DashboardSearchForm[block_code]=' . $bc_model->block_code]);
                } else {
                    
                }
            }
            if (\Yii::$app->request->isAjax) {

                return $this->renderAjax('_callcloudform', [
                            'model' => $model,
                ]);
            } else {
                return $this->render('_callcloudform', [
                            'model' => $model,
                ]);
            }
        } else {
            return $this->redirect(['/training/preselected?DashboardSearchForm[district_code]=' . $bc_model->district_code . '&DashboardSearchForm[block_code]=' . $bc_model->block_code]);
        }
    }

    public function actionAgree($id) {
        $bc_application = $this->findModel($id);
        if (in_array($bc_application->urban_shg, [1])) {
            return $this->redirect(['/training/preselected?DashboardSearchForm[district_code]=' . $bc_application->district_code . '&DashboardSearchForm[block_code]=' . $bc_application->block_code]);
        }
        if ($bc_application->blocked != '0') {
            return $this->redirect(['/training/preselected?DashboardSearchForm[district_code]=' . $bc_application->district_code . '&DashboardSearchForm[block_code]=' . $bc_application->block_code]);
        }
        if (in_array($bc_application->bc_unwilling_rsetis, [1]) and in_array($bc_application->bc_unwilling_call_center, [1])) {
            return $this->redirect(['/training/preselected?DashboardSearchForm[district_code]=' . $bc_application->district_code . '&DashboardSearchForm[block_code]=' . $bc_application->block_code]);
        }
        if (in_array($bc_application->bc_unwilling_rsetis, [1]) and in_array($bc_application->bc_unwilling_call_center, [1])) {
            return $this->redirect(['/training/preselected?DashboardSearchForm[district_code]=' . $bc_application->district_code . '&DashboardSearchForm[block_code]=' . $bc_application->block_code]);
        }
        if (!in_array($bc_application->training_status, [0])) {
            return $this->redirect(['/training/preselected?DashboardSearchForm[district_code]=' . $bc_application->district_code . '&DashboardSearchForm[block_code]=' . $bc_application->block_code]);
        }
        if ($bc_application->status == 2 and $bc_application->training_status == 0) {
            $model = new TrainingAgreeForm($bc_application);

            $this->performAjaxValidation($model);
            if ($model->load(Yii::$app->request->post())) {
                $model->srlm_bc_application_model->training_status = 1;
                $model->srlm_bc_application_model->call_by_rsetis = Yii::$app->user->identity->id;
                $model->srlm_bc_application_model->call_rsetis_datetime = new \yii\db\Expression('NOW()');
                $model->srlm_bc_application_model->updated_at = time();
                $model->srlm_bc_application_model->action_type = SrlmBcApplication::ACTION_TYPE_RSETHIS_AGREE;
                if ($model->srlm_bc_application_model->save()) {
                    return $this->redirect(['/training/preselected?DashboardSearchForm[district_code]=' . $bc_application->district_code . '&DashboardSearchForm[block_code]=' . $bc_application->block_code]);
                } else {
                    
                }
            }
            if (\Yii::$app->request->isAjax) {

                return $this->renderAjax('_callagreeform', [
                            'model' => $model,
                ]);
            } else {
                return $this->render('_callagreeform', [
                            'model' => $model,
                ]);
            }
        } else {
            return $this->redirect(['/training/preselected?DashboardSearchForm[district_code]=' . $bc_application->district_code . '&DashboardSearchForm[block_code]=' . $bc_application->block_code]);
        }
    }

    public function actionReset($district_code) {
        $condition = ['and',
            ['=', 'district_code', $district_code],
            ['=', 'form_number', SrlmBcApplication::FORM_STATUS_PART_4],
            ['=', 'gender', 2],
            ['=', 'status', SrlmBcApplication::STATUS_PROVISIONAL],
            ['=', 'training_status', SrlmBcApplication::TRAINING_STATUS_AGREE_TRAINING],
        ];
        SrlmBcApplication::updateAll([
            'training_status' => SrlmBcApplication::TRAINING_STATUS_DEFAULT,
                ], $condition);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionAddbatch($district_code) {

        $model = new \bc\modules\training\models\form\CenterTrainingForm(null, $district_code);

        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                return $this->redirect(['/training/preselected?DashboardSearchForm[district_code]=' . $district_code]);
            } else {
                
            }
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_addbatcform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_addbatcform', [
                        'model' => $model,
            ]);
        }
    }

    public function actionAlreadycertified($id) {
        $bc_application = $this->findModel($id);
        if ($bc_application->blocked != '0') {
            return $this->redirect(['/training/preselected?DashboardSearchForm[district_code]=' . $bc_application->district_code . '&DashboardSearchForm[block_code]=' . $bc_application->block_code]);
        }
//        if (!in_array($bc_application->reading_skills, [1, 2])) {
//            return $this->redirect(['/training/preselected']);
//        }
        if ($bc_application->status == 2 and $bc_application->training_status == 0) {
            $model = new \bc\modules\selection\models\form\AlreadyCetifiedForm($bc_application);
            $model->training_status = SrlmBcApplication::TRAINING_STATUS_PASS;
            $this->performAjaxValidation($model);
            if ($model->load(Yii::$app->request->post())) {
                $bc_application->already_certified = 1;
                $bc_application->training_status = SrlmBcApplication::TRAINING_STATUS_PASS;
                $bc_application->exam_score = $model->exam_score;
                $bc_application->certificate_code = $model->certificate_code;
                $bc_application->iibf_date = $model->iibf_date;
                $bc_application->iibf_by = Yii::$app->user->identity->id;
                $batchp_model = \bc\modules\training\models\RsetisBatchParticipants::findOne(['bc_application_id' => $bc_application->id]);
                if ($batchp_model == null) {
                    $batchp_model = new \bc\modules\training\models\RsetisBatchParticipants();
                }
                $batchp_model->setAttributes([
                    'bc_application_id' => $bc_application->id,
                    'rsetis_center_id' => 0,
                    'rsetis_batch_id' => 0,
                    'rsetis_center_training_id' => 0,
                    'bc_selection_user_id' => $bc_application->srlm_bc_selection_user_id,
                    'status' => 0,
                    'training_status' => SrlmBcApplication::TRAINING_STATUS_PASS,
                    'exam_score' => $bc_application->exam_score,
                    'certificate_code' => $bc_application->certificate_code,
                ]);
                $bc_application->action_type = SrlmBcApplication::ACTION_TYPE_RSETHIS_AREDY_CERTIFIED;
                if ($bc_application->save() and $batchp_model->save()) {
                    return $this->redirect(['/training/preselected']);
                }
            }
            if (\Yii::$app->request->isAjax) {

                return $this->renderAjax('_alreadycertified', [
                            'model' => $model,
                ]);
            } else {
                return $this->render('_alreadycertified', [
                            'model' => $model,
                ]);
            }
        }
    }

    public function actionUnwilling($id) {
        $bc_model = $this->findModel($id);
        if (isset($bc_model) and $bc_model->bc_unwilling_rsetis == 1) {
            return $this->redirect(['/training/preselected']);
        }
        $model = new \bc\modules\selection\models\form\UnwillingRsetisForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {
            return $this->redirect(['/training/preselected']);
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_rshetis_unwilling_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_rshetis_unwilling_form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUnwillinglist() {
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 30, null, \bc\modules\selection\models\base\GenralModel::select_preselected_bc_column());

        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.form_number', '6']);
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.gender', '2']);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.bc_unwilling_rsetis' => 1]);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.training_status' => -2]);
//        $dataProvider->query->andWhere(['or',
//            ['=', 'srlm_bc_application.bc_unwilling_call_center', 0],
//            ['IS ', 'srlm_bc_application.bc_unwilling_call_center', new \yii\db\Expression('NULL')],
//        ]);
//        if ($searchModel->bc_unwilling_call_center != '') {
//            if ($searchModel->bc_unwilling_call_center == 1) {
//                $dataProvider->query->andWhere(['bc_unwilling_call_center' => 1]);
//            }
//            if ($searchModel->bc_unwilling_call_center == 0) {
//                $dataProvider->query->andWhere(['or',
//                    ['=', 'srlm_bc_application.bc_unwilling_call_center', 0],
//                    ['IS ', 'srlm_bc_application.bc_unwilling_call_center', new \yii\db\Expression('NULL')],
//                ]);
//            }
//        }
        $dataProvider->query->addOrderBy("first_name asc");
        return $this->render('unwillinglist', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIneligible($id) {
        $bc_model = $this->findModel($id);
        if (!in_array($bc_model->training_status, [0, 1, 2])) {
            return $this->redirect(['/training/preselected']);
        }
        $model = new \bc\modules\selection\models\form\IneligibleRsetisForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {
            return $this->redirect(['/training/preselected']);
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_rshetis_ineligible_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_rshetis_ineligible_form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionIneligiblelist() {
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 50);

        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        //$dataProvider->query->andWhere(['missing_bc' => 0]);
        $dataProvider->query->andWhere(['training_status' => 55]);

        $dataProvider->query->addOrderBy("first_name asc");
        return $this->render('ineligiblelisttemp', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIneligibletemp($id) {
        $bc_model = $this->findModel($id);
        if (!in_array($bc_model->training_status, [55])) {
            return $this->redirect(['/training/preselected/ineligiblelist']);
        }
        $model = new \bc\modules\selection\models\form\IneligibleRsetisForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {
            return $this->redirect(['/training/preselected/ineligiblelist']);
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_rshetis_ineligible_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_rshetis_ineligible_form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDownloadcsv() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');

        $dataProvider = [];
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplicationSearch();
        $searchModel->training_status = 0;
        $searchModels->training_status = 0;
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, false, 'srlm_bc_application.id');
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.training_status' => 0]);
        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere(['missing_bc' => 0]);
        $dataProvider->query->andWhere(['urban_shg' => 0]);
        $dataProvider->query->andWhere(['blocked' => 0]);
        $dataProvider->query->addOrderBy("first_name asc");
        $file_name = "preselected_bc_" . date("Y_m_d_H-m-s") . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file_name");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Sr No', 'Application ID', 'Name', 'Guardian Name', 'Mobile Number', 'OTP Verified mobile no', 'Age', 'Education', 'District', 'Block', 'Gram Panchayat', 'Village', 'Unwlling'));
        $models = $dataProvider->getModels();

        $sr_no = 1;
        foreach ($models as $model) {
            $model = SrlmBcApplication::findOne($model['id']);
            $education = $model->readingskills != null ? $model->readingskills->name_eng : '';
            $row = [
                $sr_no,
                $model->application_id,
                $model->name,
                $model->guardian_name,
                $model->mobile_number,
                $model->mobile_no,
                $model->age,
                $education,
                $model->district_name,
                $model->block_name,
                $model->gram_panchayat_name,
                $model->village_name,
                $model->bc_unwilling_rsetis == 1 ? 'Yes' : 'No',
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        exit;
    }

    public function actionBlocked() {
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());

        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 50);
        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere(['urban_shg' => 0]);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.training_status' => 0]);
        $dataProvider->query->andWhere(['!=', 'blocked', '0']);
        $dataProvider->query->addOrderBy("first_name asc");
        if (isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) {
            $dataProvider->query->andWhere(['blocked' => [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH, SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY, SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED, SrlmBcApplication::BLOCKED_STATUS_BC_GP, SrlmBcApplication::BLOCKED_STATUS_MISSING_BC, SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY, SrlmBcApplication::BLOCKED_STATUS_PFMS, SrlmBcApplication::BLOCKED_STATUS_AADHAR]]);
        } else {
            $dataProvider->query->andWhere(['blocked' => [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH, SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY, SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED, SrlmBcApplication::BLOCKED_STATUS_BC_GP, SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY, SrlmBcApplication::BLOCKED_STATUS_PFMS, SrlmBcApplication::BLOCKED_STATUS_AADHAR]]);
        }
        $dataProvider->query->addOrderBy("first_name asc");
        return $this->render('blocked', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionAgreed() {
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());

        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 50);
        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere(['urban_shg' => 0]);
        $dataProvider->query->andWhere(['blocked' => 0]);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.training_status' => 1]);
        $dataProvider->query->addOrderBy("first_name asc");
       
        return $this->render('agreed', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
     public function actionInbatch() {
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());

        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 50);
        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere(['urban_shg' => 0]);
        $dataProvider->query->andWhere(['blocked' => 0]);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.training_status' => 2]);
        $dataProvider->query->addOrderBy("first_name asc");
       
        return $this->render('inbatch', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCertifiedblockeddownload() {
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());

        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, false, 'srlm_bc_application.id');
        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider->query->andWhere(['>', 'blocked', 0]);
        $file_name = "certified_bc_blocked" . date("Y_m_d_H-m-s") . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file_name");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Sr No', 'Application ID', 'Name', 'Guardian Name', 'Aadhar number', 'Mobile Number', 'OTP Verified mobile no', 'Age', 'Education', 'District', 'Block', 'Gram Panchayat', 'Upload PVR', 'BC bank a/c', 'BC bank a/c', 'SHG bank a/c', 'BC-SHG payment status', 'Acknowledge support funds received', 'Acknowledge handheld machine received', 'Onboarding', 'Operational', 'Blocked Reason'));
        $models = $dataProvider->getModels();

        $sr_no = 1;
        foreach ($models as $model) {
            $model = SrlmBcApplication::findOne($model['id']);
            $education = $model->readingskills != null ? $model->readingskills->name_eng : '';
            $row = [
                $sr_no,
                $model->application_id,
                $model->name,
                $model->guardian_name,
                common\helpers\Utility::maskaadhar($model->aadhar_number),
                $model->mobile_number,
                $model->mobile_no,
                $model->age,
                $education,
                $model->district_name,
                $model->block_name,
                $model->gram_panchayat_name,
                $model->pvr_status == 1 ? 'Yes' : 'No',
                strip_tags($model->bcbanks),
                strip_tags($model->shgbanks),
                $model->bc_shg_funds_status == 1 ? 'Yes' : 'No',
                $model->bc_support_funds_received == 1 ? 'Yes' : 'No',
                $model->bc_handheld_machine_recived == 1 ? 'Yes' : 'No',
                $model->bc_handheld_machine_recived == 1 ? 'Yes' : 'No',
                $model->onboarding == 1 ? 'Yes' : 'No',
                \bc\models\transaction\BcTransaction::find()->where(['bc_application_id' => $model->id])->exists() ? 'Yes' : 'No',
                strip_tags($model->blockedr)
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        exit;
    }

    public function actionCertifiedblocked() {
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());

        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 50);
        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider->query->andWhere(['>', 'blocked', 0]);
        $dataProvider->query->addOrderBy("first_name asc");
        return $this->render('certifiedblocked', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMobileinuse() {
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());

        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModel->blocked = SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED;
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 50);
        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider->query->andWhere(['=', 'blocked', SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED]);
        $dataProvider->query->addOrderBy("first_name asc");
        return $this->render('mobileinuse', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMobileinusedownload() {
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());

        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModel->blocked = SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED;
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, false, 'srlm_bc_application.id');
        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider->query->andWhere(['=', 'blocked', SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED]);
        $file_name = "certified_bc_blocked_mobile_inused" . date("Y_m_d_H-m-s") . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file_name");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Sr No', 'Application ID', 'Name', 'Guardian Name', 'Age', 'Education', 'District', 'Block', 'Gram Panchayat', 'Upload PVR', 'BC bank a/c', 'BC bank a/c', 'SHG bank a/c', 'BC-SHG payment status', 'Acknowledge support funds received', 'Acknowledge handheld machine received', 'Onboarding', 'Operational', 'Blocked Reason'));
        $models = $dataProvider->getModels();

        $sr_no = 1;
        foreach ($models as $model) {
            $model = SrlmBcApplication::findOne($model['id']);
            $education = $model->readingskills != null ? $model->readingskills->name_eng : '';
            $row = [
                $sr_no,
                $model->application_id,
                $model->name,
                $model->guardian_name,
                $model->age,
                $education,
                $model->district_name,
                $model->block_name,
                $model->gram_panchayat_name,
                $model->pvr_status == 1 ? 'Yes' : 'No',
                strip_tags($model->bcbanks),
                strip_tags($model->shgbanks),
                $model->bc_shg_funds_status == 1 ? 'Yes' : 'No',
                $model->bc_support_funds_received == 1 ? 'Yes' : 'No',
                $model->bc_handheld_machine_recived == 1 ? 'Yes' : 'No',
                $model->bc_handheld_machine_recived == 1 ? 'Yes' : 'No',
                $model->onboarding == 1 ? 'Yes' : 'No',
                \bc\models\transaction\BcTransaction::find()->where(['bc_application_id' => $model->id])->exists() ? 'Yes' : 'No',
                strip_tags($model->blockedr)
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        exit;
    }

    public function actionAddmobileno($bcid) {
        $bc_model = $this->findModel($bcid);
        $model = new \bc\modules\selection\models\form\AddBCMobileNoForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Mobile No Add successfully');
            return $this->redirect(['/training/preselected/mobileinuse?DashboardSearchForm[district_code]=' . $bc_model->district_code]);
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('addmobileno', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('addmobileno', [
                        'model' => $model,
            ]);
        }
    }

    public function actionAadharduplicacy($bcid) {
        $bc_model = $this->findModel($bcid);
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplicationSearch();

        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 150);
        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['aadhar_number' => $bc_model->aadhar_number]);

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('aadharduplicacy', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('aadharduplicacy', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionPfmswobankverification() {
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());

        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModel->blocked = SrlmBcApplication::BLOCKED_STATUS_PFMS;
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 50);
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.form_number', '6']);
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.gender', '2']);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.blocked', SrlmBcApplication::BLOCKED_STATUS_PFMS]);
        $dataProvider->query->addOrderBy("first_name asc");
        return $this->render('pfmswobankverification', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBcshggpchange() {
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());

        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModel->blocked = SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH;
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 50);
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.form_number', '6']);
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.gender', '2']);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.blocked', SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH]);
        $dataProvider->query->addOrderBy("first_name asc");
        return $this->render('bcshggpchange', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionUpdatemobileno($bcid) {
        $bc_model = $this->findModel($bcid);
        if (!in_array($bc_model->reading_skills, [1, 2])) {
            return $this->redirect(['/training/preselected']);
        }
        if (in_array($bc_model->urban_shg, [1])) {
            return $this->redirect(['/training/preselected']);
        }

        $model = new \bc\models\form\UpdateBCMobileNoForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {

            return $this->redirect(['/training/preselected']);
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('updatemobileno', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('updatemobileno', [
                        'model' => $model,
            ]);
        }
    }
    public function actionBcnameupdate($bcid) {
        $bc_model = $this->findModel($bcid);

        $model = new \bc\modules\selection\models\form\UpdateBCNameForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {

            Yii::$app->getSession()->setFlash('success', 'Name Update successfully');
            return $this->redirect(['/training/preselected?DashboardSearchForm[district_code]=' . $bc_model->district_code . '&DashboardSearchForm[block_code]=' . $bc_model->block_code]);
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('bcnameupdate', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('bcnameupdate', [
                        'model' => $model,
            ]);
        }
    }
//    public function actionIneligiblelist() {
//        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
//        if (count($searchModel->district_option) == 1) {
//            $searchModel->district_code = key($searchModel->district_option);
//        }
//        $searchModels = new SrlmBcApplicationSearch();
//        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 50);
//
//        $dataProvider->query->andWhere(['=', 'form_number', '6']);
//        $dataProvider->query->andWhere(['=', 'gender', '2']);
//        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
//        $dataProvider->query->andWhere(['missing_bc' => 0]);
//        $dataProvider->query->andWhere(['training_status' => SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE]);
//        
//        $dataProvider->query->addOrderBy("first_name asc");
//        return $this->render('ineligiblelist', [
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//        ]);
//    }

    /**
     * Finds the NfsaBaseSurvey model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NfsaBaseSurvey the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = SrlmBcApplication::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
