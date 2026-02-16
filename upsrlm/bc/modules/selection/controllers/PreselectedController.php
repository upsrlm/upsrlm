<?php

namespace bc\modules\selection\controllers;

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
use bc\modules\selection\models\form\Call1StatusForm;
use bc\models\master\MasterGramPanchayat;
use bc\models\master\MasterGramPanchayatSearch;

/**
 * Default controller for the `nfsaSurvey` module
 */
class PreselectedController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'call1update', 'bcnameupdate', 'ageupdate', 'ineligible', 'ineligiblelist', 'vacantgp', 'standby', 'standbydownload', 'urban'],
                'rules' => [
                    [
                        'actions' => ['index', 'call1update', 'bcnameupdate', 'ageupdate', 'ineligible', 'ineligiblelist', 'vacantgp', 'standby', 'standbydownload', 'urban'],
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
                    'alreadycertified' => ['post'],
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
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
        $searchModels = new SrlmBcApplicationSearch();

        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30'], null, \bc\modules\selection\models\base\GenralModel::select_preselected_bc_column());

        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.form_number', '6']);
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.gender', '2']);
        //$dataProvider->query->andWhere(['not in', 'srlm_bc_application.selection_by', [15]]);
//        $dataProvider->query->andWhere(['=', 'blocked', '0']);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUrban() {
        
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30'], null, \bc\modules\selection\models\base\GenralModel::select_urbun_bc_column());

        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.form_number', '6']);
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.gender', '2']);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.urban_shg' => 1]);
        if (Yii::$app->user->identity->role != MasterRole::ROLE_ADMIN) {
            $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.training_status' => 3]);
        }
        return $this->render('urban', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionVacantgp() {
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
        $searchModels = new SrlmBcApplicationSearch();

        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 150);
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.form_number', '6']);
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.gender', '2']);
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.urban_shg', '0']);
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.replaced', '0']);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.training_status' => [SrlmBcApplication::TRAINING_STATUS_UNWILLING, SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE]]);
        $dataProvider->query->andWhere(['srlm_bc_application.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
//        $dataProvider->query->OrWhere(['srlm_bc_application.blocked' => 6]);
        if ($searchModels->singleapplication) {
            $dataProvider->query->joinWith(['gp']);
            if ($searchModels->singleapplication == 1) {
                $dataProvider->query->andWhere(['=', 'master_gram_panchayat.bc_selection_application_receive', 1]);
            }
            if ($searchModels->singleapplication == 2) {
                $dataProvider->query->andWhere(['>', 'master_gram_panchayat.bc_selection_application_receive', 1]);
            }
        }
        return $this->render('vacantgp', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

//    public function actionStandby() {
//
//        if (Yii::$app->request->isGet)
//            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
//        if (Yii::$app->request->isPost)
//            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
//        $searchModels = new SrlmBcApplicationSearch();
//
//        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 150);
//        $dataProvider->query->andWhere(['=', 'form_number', '6']);
//        $dataProvider->query->andWhere(['=', 'gender', '2']);
//        $dataProvider->query->andWhere(['=', 'urban_shg', '0']);
//        $dataProvider->query->andWhere(['=', 'replaced', '0']);
//
//        $dataProvider->query->andWhere(['srlm_bc_application.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
//        $dataProvider->query->joinWith(['gp']);
//        $dataProvider->query->andWhere(['>', 'master_gram_panchayat.bc_selection_application_receive', 1]);
//        $dataProvider->query->andWhere(['=', 'master_gram_panchayat.gp_post_vacant', 1]);
//
//        if (\Yii::$app->request->isAjax) {
//            return $this->renderAjax('standby', [
//                        'searchModel' => $searchModel,
//                        'dataProvider' => $dataProvider,
//            ]);
//        } else {
//            return $this->render('standby', [
//                        'searchModel' => $searchModel,
//                        'dataProvider' => $dataProvider,
//            ]);
//        }
//    }

    public function actionStandby() {

        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());


        $searchModels = new MasterGramPanchayatSearch();

        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 150);
        $dataProvider->query->andWhere(['NOT', ['standby1_id' => null]]);

        $dataProvider->query->andWhere(['status' => 1]);

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('standby', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('standby', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionStandbydownload() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        try {
            if (Yii::$app->request->isGet)
                $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
            if (Yii::$app->request->isPost)
                $searchModel = new DashboardSearchForm(Yii::$app->request->post());


            $searchModels = new MasterGramPanchayatSearch();
            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 150);
            $dataProvider->query->andWhere(['NOT', ['standby1_id' => null]]);
            $dataProvider->query->andWhere(['status' => 1]);
            $dataProvider->pagination = false;
            $file_name = "Standby_BC_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file_name");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Name', 'Guardian Name', 'Mobile Number', 'Age', 'Social Category', 'District', 'Block', 'Gram Panchayat', 'Village', 'Hamlet', 'Form submit On', 'OTP Verified mobile no'));
            $models = $dataProvider->getModels();

            $sr_no = 1;
            foreach ($models as $modelg) {
                $model = SrlmBcApplication::findOne($modelg->standby1_id);
                $cast = $model->castrel != null ? $model->castrel->name_eng : '';
                $form_end_date = $model->form6_date_time != null ? $model->form6_date_time : '';
                $row = [
                    $sr_no,
                    $model->name,
                    $model->guardian_name,
                    $model->mobile_number,
                    $model->age,
                    $cast,
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    $model->village_name,
                    $model->hamlet,
                    $form_end_date,
                    $model->mobile_no,
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit;
        } catch (\Exception $ex) {
            
        }
    }

    public function actionStandbydownload2() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        try {
            if (Yii::$app->request->isGet)
                $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
            if (Yii::$app->request->isPost)
                $searchModel = new DashboardSearchForm(Yii::$app->request->post());


            $searchModels = new MasterGramPanchayatSearch();
            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 150);
            $dataProvider->query->andWhere(['NOT', ['standby2_id' => null]]);
            $dataProvider->query->andWhere(['status' => 1]);
            $dataProvider->pagination = false;
            $file_name = "Standby_2_BC_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file_name");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Name', 'Guardian Name', 'Mobile Number', 'Age', 'Social Category', 'District', 'Block', 'Gram Panchayat', 'Village', 'Hamlet', 'Form submit On', 'OTP Verified mobile no'));
            $models = $dataProvider->getModels();

            $sr_no = 1;
            foreach ($models as $modelg) {
                $model = \bc\modules\selection\models\SrlmBcApplication2::findOne(['new_id' => $modelg->standby2_id]);

                $cast = $model->castrel != null ? $model->castrel->name_eng : '';
                $form_end_date = $model->form6_date_time != null ? $model->form6_date_time : '';
                $row = [
                    $sr_no,
                    $model->name,
                    $model->guardian_name,
                    $model->mobile_number,
                    $model->age,
                    $cast,
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    $model->village_name,
                    $model->hamlet,
                    $form_end_date,
                    $model->mobile_no,
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit;
        } catch (\Exception $ex) {
            echo '<pre>';
            print_r($ex);
            exit;
        }
    }

    public function actionStandbydownload3() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        try {
            if (Yii::$app->request->isGet)
                $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
            if (Yii::$app->request->isPost)
                $searchModel = new DashboardSearchForm(Yii::$app->request->post());


            $searchModels = new MasterGramPanchayatSearch();
            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 150);
            $dataProvider->query->andWhere(['NOT', ['standby3_id' => null]]);
            $dataProvider->query->andWhere(['status' => 1]);
            $dataProvider->pagination = false;
            $file_name = "Standby_BC_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file_name");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Name', 'Guardian Name', 'Mobile Number', 'Age', 'Social Category', 'District', 'Block', 'Gram Panchayat', 'Village', 'Hamlet', 'Form submit On', 'OTP Verified mobile no'));
            $models = $dataProvider->getModels();

            $sr_no = 1;
            foreach ($models as $modelg) {
                $model = SrlmBcApplication::findOne($modelg->standby3_id);
                $cast = $model->castrel != null ? $model->castrel->name_eng : '';
                $form_end_date = $model->form6_date_time != null ? $model->form6_date_time : '';
                $row = [
                    $sr_no,
                    $model->name,
                    $model->guardian_name,
                    $model->mobile_number,
                    $model->age,
                    $cast,
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    $model->village_name,
                    $model->hamlet,
                    $form_end_date,
                    $model->mobile_no,
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit;
        } catch (\Exception $ex) {
            
        }
    }

    public function actionStandbydownload4() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        try {
            if (Yii::$app->request->isGet)
                $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
            if (Yii::$app->request->isPost)
                $searchModel = new DashboardSearchForm(Yii::$app->request->post());


            $searchModels = new MasterGramPanchayatSearch();
            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 150);
            $dataProvider->query->andWhere(['NOT', ['master_gram_panchayat_detail_bc.standby4_id' => null]]);
            $dataProvider->query->andWhere(['master_gram_panchayat.status' => 1]);
            $dataProvider->pagination = false;
            $file_name = "Standby_BC_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file_name");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Name', 'Guardian Name', 'Mobile Number', 'Age', 'Social Category', 'District', 'Block', 'Gram Panchayat', 'Village', 'Hamlet', 'Form submit On', 'OTP Verified mobile no'));
            $models = $dataProvider->getModels();

            $sr_no = 1;
            foreach ($models as $modelg) {
                $model = SrlmBcApplication::findOne($modelg->gpdetail->standby4_id);
                $cast = $model->castrel != null ? $model->castrel->name_eng : '';
                $form_end_date = $model->form6_date_time != null ? $model->form6_date_time : '';
                $row = [
                    $sr_no,
                    $model->name,
                    $model->guardian_name,
                    $model->mobile_number,
                    $model->age,
                    $cast,
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    $model->village_name,
                    $model->hamlet,
                    $form_end_date,
                    $model->mobile_no,
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit;
        } catch (\Exception $ex) {
            
        }
    }

    public function actionStandbydownload5() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        try {
            if (Yii::$app->request->isGet)
                $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
            if (Yii::$app->request->isPost)
                $searchModel = new DashboardSearchForm(Yii::$app->request->post());


            $searchModels = new MasterGramPanchayatSearch();
            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 150);
            $dataProvider->query->andWhere(['NOT', ['master_gram_panchayat_detail_bc.standby5_id' => null]]);
            $dataProvider->query->andWhere(['master_gram_panchayat.status' => 1]);
            $dataProvider->pagination = false;
            $file_name = "Standby_BC_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file_name");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Name', 'Guardian Name', 'Mobile Number', 'Age', 'Social Category', 'District', 'Block', 'Gram Panchayat', 'Village', 'Hamlet', 'Form submit On', 'OTP Verified mobile no'));
            $models = $dataProvider->getModels();

            $sr_no = 1;
            foreach ($models as $modelg) {
                $model = SrlmBcApplication::findOne($modelg->gpdetail->standby5_id);
                $cast = $model->castrel != null ? $model->castrel->name_eng : '';
                $form_end_date = $model->form6_date_time != null ? $model->form6_date_time : '';
                $row = [
                    $sr_no,
                    $model->name,
                    $model->guardian_name,
                    $model->mobile_number,
                    $model->age,
                    $cast,
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    $model->village_name,
                    $model->hamlet,
                    $form_end_date,
                    $model->mobile_no,
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit;
        } catch (\Exception $ex) {
            
        }
    }

    public function actionStandbydownload6() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        try {
            if (Yii::$app->request->isGet)
                $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
            if (Yii::$app->request->isPost)
                $searchModel = new DashboardSearchForm(Yii::$app->request->post());


            $searchModels = new MasterGramPanchayatSearch();
            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 150);
            $dataProvider->query->andWhere(['NOT', ['master_gram_panchayat_detail_bc.standby6_id' => null]]);
            $dataProvider->query->andWhere(['master_gram_panchayat.status' => 1]);
            $dataProvider->pagination = false;
            $file_name = "Standby_BC_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file_name");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Name', 'Guardian Name', 'Mobile Number', 'Age', 'Social Category', 'District', 'Block', 'Gram Panchayat', 'Village', 'Hamlet', 'Form submit On', 'OTP Verified mobile no'));
            $models = $dataProvider->getModels();

            $sr_no = 1;
            foreach ($models as $modelg) {
                $model = SrlmBcApplication::findOne($modelg->gpdetail->standby6_id);
                $cast = $model->castrel != null ? $model->castrel->name_eng : '';
                $form_end_date = $model->form6_date_time != null ? $model->form6_date_time : '';
                $row = [
                    $sr_no,
                    $model->name,
                    $model->guardian_name,
                    $model->mobile_number,
                    $model->age,
                    $cast,
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    $model->village_name,
                    $model->hamlet,
                    $form_end_date,
                    $model->mobile_no,
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit;
        } catch (\Exception $ex) {
            
        }
    }

    public function actionStandbydownload7() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        try {
            if (Yii::$app->request->isGet)
                $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
            if (Yii::$app->request->isPost)
                $searchModel = new DashboardSearchForm(Yii::$app->request->post());


            $searchModels = new MasterGramPanchayatSearch();
            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 150);
            $dataProvider->query->andWhere(['NOT', ['master_gram_panchayat_detail_bc.standby7_id' => null]]);
            $dataProvider->query->andWhere(['master_gram_panchayat.status' => 1]);
            $dataProvider->pagination = false;
            $file_name = "Standby_BC_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file_name");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Name', 'Guardian Name', 'Mobile Number', 'Age', 'Social Category', 'District', 'Block', 'Gram Panchayat', 'Village', 'Hamlet', 'Form submit On', 'OTP Verified mobile no'));
            $models = $dataProvider->getModels();

            $sr_no = 1;
            foreach ($models as $modelg) {
                $model = SrlmBcApplication::findOne($modelg->gpdetail->standby7_id);
                $cast = $model->castrel != null ? $model->castrel->name_eng : '';
                $form_end_date = $model->form6_date_time != null ? $model->form6_date_time : '';
                $row = [
                    $sr_no,
                    $model->name,
                    $model->guardian_name,
                    $model->mobile_number,
                    $model->age,
                    $cast,
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    $model->village_name,
                    $model->hamlet,
                    $form_end_date,
                    $model->mobile_no,
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit;
        } catch (\Exception $ex) {
            
        }
    }

    public function actionStandbydownload8() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        try {
            if (Yii::$app->request->isGet)
                $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
            if (Yii::$app->request->isPost)
                $searchModel = new DashboardSearchForm(Yii::$app->request->post());


            $searchModels = new MasterGramPanchayatSearch();
            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 150);
            $dataProvider->query->andWhere(['NOT', ['master_gram_panchayat_detail_bc.standby8_id' => null]]);
            $dataProvider->query->andWhere(['master_gram_panchayat.status' => 1]);
            $dataProvider->pagination = false;
            $file_name = "Standby_BC_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file_name");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Name', 'Guardian Name', 'Mobile Number', 'Age', 'Social Category', 'District', 'Block', 'Gram Panchayat', 'Village', 'Hamlet', 'Form submit On', 'OTP Verified mobile no'));
            $models = $dataProvider->getModels();

            $sr_no = 1;
            foreach ($models as $modelg) {
                $model = SrlmBcApplication::findOne($modelg->gpdetail->standby8_id);
                $cast = $model->castrel != null ? $model->castrel->name_eng : '';
                $form_end_date = $model->form6_date_time != null ? $model->form6_date_time : '';
                $row = [
                    $sr_no,
                    $model->name,
                    $model->guardian_name,
                    $model->mobile_number,
                    $model->age,
                    $cast,
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    $model->village_name,
                    $model->hamlet,
                    $form_end_date,
                    $model->mobile_no,
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit;
        } catch (\Exception $ex) {
            
        }
    }

    public function actionStandbydownload10() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        try {
            if (Yii::$app->request->isGet)
                $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
            if (Yii::$app->request->isPost)
                $searchModel = new DashboardSearchForm(Yii::$app->request->post());


            $searchModels = new MasterGramPanchayatSearch();
            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 150);
            $dataProvider->query->andWhere(['NOT', ['master_gram_panchayat_detail_bc.standby9_id' => null]]);
            $dataProvider->query->andWhere(['master_gram_panchayat.status' => 1]);
            $dataProvider->pagination = false;
            $file_name = "Standby_BC_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file_name");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Name', 'Guardian Name', 'Mobile Number', 'Age', 'Social Category', 'District', 'Block', 'Gram Panchayat', 'Village', 'Hamlet', 'Form submit On', 'OTP Verified mobile no'));
            $models = $dataProvider->getModels();

            $sr_no = 1;
            foreach ($models as $modelg) {
                $model = SrlmBcApplication::findOne($modelg->gpdetail->standby9_id);
                $cast = $model->castrel != null ? $model->castrel->name_eng : '';
                $form_end_date = $model->form6_date_time != null ? $model->form6_date_time : '';
                $row = [
                    $sr_no,
                    $model->name,
                    $model->guardian_name,
                    $model->mobile_number,
                    $model->age,
                    $cast,
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    $model->village_name,
                    $model->hamlet,
                    $form_end_date,
                    $model->mobile_no,
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit;
        } catch (\Exception $ex) {
            
        }
    }

    public function actionStandbydownload11() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        try {
            if (Yii::$app->request->isGet)
                $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
            if (Yii::$app->request->isPost)
                $searchModel = new DashboardSearchForm(Yii::$app->request->post());


            $searchModels = new MasterGramPanchayatSearch();
            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 150);
            $dataProvider->query->andWhere(['NOT', ['master_gram_panchayat_detail_bc.standby10_id' => null]]);
            $dataProvider->query->andWhere(['master_gram_panchayat.status' => 1]);
            $dataProvider->pagination = false;
            $file_name = "Standby_BC_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file_name");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Name', 'Guardian Name', 'Mobile Number', 'Age', 'Social Category', 'District', 'Block', 'Gram Panchayat', 'Village', 'Hamlet', 'Form submit On', 'OTP Verified mobile no'));
            $models = $dataProvider->getModels();

            $sr_no = 1;
            foreach ($models as $modelg) {
                $model = SrlmBcApplication::findOne($modelg->gpdetail->standby10_id);
                $cast = $model->castrel != null ? $model->castrel->name_eng : '';
                $form_end_date = $model->form6_date_time != null ? $model->form6_date_time : '';
                $row = [
                    $sr_no,
                    $model->name,
                    $model->guardian_name,
                    $model->mobile_number,
                    $model->age,
                    $cast,
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    $model->village_name,
                    $model->hamlet,
                    $form_end_date,
                    $model->mobile_no,
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit;
        } catch (\Exception $ex) {
            
        }
    }
    public function actionStandbydownload14() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        try {
            if (Yii::$app->request->isGet)
                $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
            if (Yii::$app->request->isPost)
                $searchModel = new DashboardSearchForm(Yii::$app->request->post());


            $searchModels = new MasterGramPanchayatSearch();
            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 150);
            $dataProvider->query->andWhere(['NOT', ['master_gram_panchayat_detail_bc.standby13_id' => null]]);
            $dataProvider->query->andWhere(['master_gram_panchayat.status' => 1]);
            $dataProvider->pagination = false;
            $file_name = "Standby_BC_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file_name");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Name', 'Guardian Name', 'Mobile Number', 'Age', 'Social Category', 'District', 'Block', 'Gram Panchayat', 'Village', 'Hamlet', 'Form submit On', 'OTP Verified mobile no'));
            $models = $dataProvider->getModels();

            $sr_no = 1;
            foreach ($models as $modelg) {
                $model = SrlmBcApplication::findOne($modelg->gpdetail->standby13_id);
                $cast = $model->castrel != null ? $model->castrel->name_eng : '';
                $form_end_date = $model->form6_date_time != null ? $model->form6_date_time : '';
                $row = [
                    $sr_no,
                    $model->name,
                    $model->guardian_name,
                    $model->mobile_number,
                    $model->age,
                    $cast,
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    $model->village_name,
                    $model->hamlet,
                    $form_end_date,
                    $model->mobile_no,
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit;
        } catch (\Exception $ex) {
            
        }
    }
    public function actionStandbydownload15() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        try {
            if (Yii::$app->request->isGet)
                $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
            if (Yii::$app->request->isPost)
                $searchModel = new DashboardSearchForm(Yii::$app->request->post());


            $searchModels = new MasterGramPanchayatSearch();
            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 150);
            $dataProvider->query->andWhere(['NOT', ['master_gram_panchayat_detail_bc.standby14_id' => null]]);
            $dataProvider->query->andWhere(['master_gram_panchayat.status' => 1]);
            $dataProvider->pagination = false;
            $file_name = "Standby_BC_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file_name");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Name', 'Guardian Name', 'Mobile Number', 'Age', 'Social Category', 'District', 'Block', 'Gram Panchayat', 'Village', 'Hamlet', 'Form submit On', 'OTP Verified mobile no','round'));
            $models = $dataProvider->getModels();

            $sr_no = 1;
            foreach ($models as $modelg) {
                $model = SrlmBcApplication::findOne($modelg->gpdetail->standby14_id);
                $cast = $model->castrel != null ? $model->castrel->name_eng : '';
                $form_end_date = $model->form6_date_time != null ? $model->form6_date_time : '';
                $row = [
                    $sr_no,
                    str_replace(',', '', trim($model->name, ',')),
                    str_replace(',', '', trim($model->guardian_name, ',')),
                    $model->mobile_number,
                    $model->age,
                    $cast,
                    $model->district_name,
                    $model->block_name,
                    str_replace(',', '', trim($model->gram_panchayat_name, ',')),
                    str_replace(',', '', trim($model->village_name, ',')),
                    str_replace(',', '', trim($model->hamlet, ',')),
                    
                    $form_end_date,
                    $model->mobile_no,
                    $model->selection_by,
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit;
        } catch (\Exception $ex) {
            
        }
    }
    public function actionStandbydownload1() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        try {
//            if (Yii::$app->request->isGet)
//                $searchModels = new DashboardSearchForm(Yii::$app->request->queryParams);
//            if (Yii::$app->request->isPost)
//                $searchModels = new DashboardSearchForm(Yii::$app->request->post());

            $searchModels = new \bc\modules\selection\models\SrlmBcApplicationSearch();
            $dataProvider1d = $searchModels->search($searchModels, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $dataProvider1d->query->andWhere(['!=', SrlmBcApplication::getTableSchema()->fullName . '.form_number', '0']);
            $dataProvider1d->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.form_number', '6']);
            $dataProvider1d->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.gender', '2']);
            $dataProvider1d->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.urban_shg', '0']);
            $dataProvider1d->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
            $dataProvider1d->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.selection_by' => '2']);
            $dataProvider1d->query->addOrderBy("first_name asc");
            $dataProvider1d->pagination = false;
            $file_name = "vcant_gp_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file_name");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'District', 'Block', 'Gram Panchayat', 'Vacant Candidate Name', 'Vacant Reason'));
            $models = $dataProvider1d->getModels();

            $sr_no = 1;
            foreach ($models as $modelg) {
                $arr = ['4' => 'Not Certified', '5' => 'ineligible', '6' => 'Absent', '-2' => 'Unwilling', '3' => 'Certified Unwilling'];

                $row = [
                    $sr_no,
                    $modelg->district_name,
                    $modelg->block_name,
                    $modelg->gram_panchayat_name,
                    $modelg->bc1->name,
                    isset($arr[$modelg->bc1->training_status]) ? $arr[$modelg->bc1->training_status] : '',
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit;
        } catch (\Exception $ex) {
            print_r($ex);
            exit;
        }
    }

    public function actionStandbybc($bcid) {
        $bc_model = $this->findModel($bcid);
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplicationSearch();

        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 150);
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.form_number', '6']);
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.gender', '2']);
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.urban_shg', '0']);
        $dataProvider->query->andWhere(['srlm_bc_application.gram_panchayat_code' => $bc_model->gram_panchayat_code]);
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.replaced', '0']);
        $dataProvider->query->joinWith(['gp']);
        $dataProvider->query->andWhere(['>', 'master_gram_panchayat.bc_selection_application_receive', 1]);
//        $dataProvider->query->andWhere(['=', 'master_gram_panchayat.gp_post_vacant', 1]);
        $dataProvider->query->addOrderBy("over_all desc");
        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('standbybc', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('standbybc', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionCall1update($id) {
        $bc_application = $this->findModel($id);

        $model = new Call1StatusForm($bc_application);

        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            $bc_application->call1 = $model->verify_complete;
            $bc_application->call1_by = Yii::$app->user->identity->id;
            $bc_application->call1_datetime = new \yii\db\Expression('NOW()');
            $bc_application->action_type = SrlmBcApplication::ACTION_TYPE_CALL_CENTER_CALL1;
            $bc_application->update(false);
            Yii::$app->getSession()->setFlash('success', '');
            return $this->redirect(['/selection/preselected']);
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_call1statusform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_call1statusform', [
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
            return $this->redirect(['/selection/preselected?DashboardSearchForm[district_code]=' . $bc_model->district_code . '&DashboardSearchForm[block_code]=' . $bc_model->block_code]);
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

    public function actionAgeupdate($bcid) {
        $bc_model = $this->findModel($bcid);

        $model = new \bc\modules\selection\models\form\AgeUpdateForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {

            Yii::$app->getSession()->setFlash('success', 'Age Update successfully');
            return $this->redirect(['/selection/preselected?DashboardSearchForm[district_code]=' . $bc_model->district_code . '&DashboardSearchForm[age_group]=5']);
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('bcageupdate', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('bcageupdate', [
                        'model' => $model,
            ]);
        }
    }

    public function actionResetbcphoto($bcid) {
        $bc_model = $this->findModel($bcid);

        $model = new \bc\modules\selection\models\form\ResetBCPhotoForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {

            Yii::$app->getSession()->setFlash('success', 'Reset candidate Profile photo successfully');
            return $this->redirect(['/selection/preselected?DashboardSearchForm[district_code]=' . $bc_model->district_code . '&DashboardSearchForm[bc_photo_status]=1']);
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('resetbcphoto', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('resetbcphoto', [
                        'model' => $model,
            ]);
        }
    }

    public function actionIneligible($id) {
        $bc_model = $this->findModel($id);
        if (!in_array($bc_model->training_status, [0, 1, 2])) {
            return $this->redirect(['/selection/preselected']);
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

//    public function actionBcdata() {
//        $user_model = Yii::$app->user->identity;
//        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
//        $searchModels = new MasterDistrictSearch();
//        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity);
//        return $this->render('district', [
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//        ]);
//    }
//
//    public function actionReportcsv($block_code) {
//        $user_model = Yii::$app->user->identity;
//        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
//        $searchModel->block_code = $block_code;
//        $searchModels = new SrlmBcApplicationSearch();
//        $dataProvider = $searchModels->verify($searchModel, Yii::$app->user->identity, false, 'srlm_bc_application.id');
//        $dataProvider->query->andWhere(['urban_shg' => 0]);
////        $dataProvider->query->andWhere(['selection_by' => '1']);
//        $block = \bc\models\master\MasterBlock::findOne(['block_code' => $searchModel->block_code]);
//        $file_name = $block->district_name . " (" . $block->block_name . ")_BC.csv";
//        header('Content-Type: text/csv; charset=utf-8');
//        header("Content-Disposition: attachment; filename=$file_name");
//        $output = fopen('php://output', 'w');
//        fputcsv($output, array('Sr No', 'Application No', 'Name', 'Guardian Name', 'Mobile Number', 'Age', 'Social Category', 'District', 'Block', 'Gram Panchayat', 'Village', 'Hamlet', 'OTP Verified mobile no'));
//        $models = $dataProvider->getModels();
//
//        $sr_no = 1;
//        foreach ($models as $model) {
//            $model = SrlmBcApplication::findOne($model['id']);
//            $cast = $model->castrel != null ? $model->castrel->name_eng : '';
//            $form_end_date = $model->form6_date_time != null ? $model->form6_date_time : '';
//            $row = [
//                $sr_no,
//                $model->application_id,
//                $model->name,
//                $model->guardian_name,
//                $model->mobile_number,
//                $model->age,
//                $cast,
//                $model->district_name,
//                $model->block_name,
//                $model->gram_panchayat_name,
//                $model->village_name,
//                $model->hamlet,
//                $model->user->mobile_no,
//            ];
//            fputcsv($output, $row);
//            $sr_no++;
//        }
//        exit;
//    }

    public function actionCsvsupport() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');

//        $user_model = Yii::$app->user->identity;
//        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
//
//        $searchModels = new SrlmBcApplicationSearch();
//        $dataProvider = $searchModels->verify($searchModel, Yii::$app->user->identity, 1000, 'srlm_bc_application.id');
        try {
            $file_name = "preselected_BC.csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file_name");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'id', 'Application No', 'Name of BC', 'Mobile Number', 'OTP Verified mobile no', 'District', 'District code', 'Block', 'Block code', 'Gram Panchayat', 'Gram Panchayat code', 'SHG Name', 'Office Bearers '));
//        $models = $dataProvider->getModels();


            $models = SrlmBcApplication::find()->select('id')->andWhere(['=', 'srlm_bc_application.status', "2"])->andWhere(['srlm_bc_application.form_number' => 6])->andWhere(['srlm_bc_application.gender' => 2])->asArray()->all();
            $sr_no = 1;
            foreach ($models as $model) {
                $model = SrlmBcApplication::findOne($model['id']);
                $shg = \cbo\models\Shg::findOne($model->cbo_shg_id);
                $row = [
                    $sr_no,
                    $model->id,
                    $model->application_id,
                    $model->name,
                    $model->mobile_number,
                    $model->user->mobile_no,
                    $model->district_name,
                    $model->district_code,
                    $model->block_name,
                    $model->block_code,
                    $model->gram_panchayat_name,
                    $model->gram_panchayat_code,
                    isset($shg) ? $shg->name_of_shg : '',
                    isset($model->agm) ? $model->agm->name_eng : '',
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
        exit;
    }

    public function actionReportpdf() {
        date_default_timezone_set("Asia/Calcutta");
        $this->layout = 'pdf';

        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider = $searchModels->verify($searchModel, Yii::$app->user->identity, false);
        //$dataProvider = $searchModels->report($searchModel, Yii::$app->user->identity, false);
        $block = \bc\models\master\MasterBlock::findOne(['block_code' => $searchModel->block_code]);
        $file_name = $block->district_name . " (" . $block->block_name . ")_BC";
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 9,
            'default_font' => 'freesans',
            'margin_header' => 0,
            'margin_footer' => 10,
        ]);

        $mpdf->SetHeader('<table style="width:100%;vertical-align: top;border:none">
            <tr>
            <td style="vertical-align: top;border:none"><img width="40px" src="/images/sgrca_logo.png"></td>
            <td style="vertical-align: top;border:none;color: #F79520;margin-top: 2px;margin-bottom: 4px;">State Rural Livelihood Mission : Selection of BC Sakhi
            <br/>District (Block) : ' . $block->district_name . ' (' . $block->block_name . ')
            </td>
            
<tr>
</table>');
        $mpdf->setFooter('{PAGENO} / {nb}');
        if ($mpdf->PageNo() == 1) {
            
        }



        $content = $this->renderPartial('report_pdf', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

        $html = '<style>
            
table {
  width:100%;
}
table, th, td {
  border: 1px solid grey;
  border-collapse: collapse;
}
th, td {
  padding: 3px;
  text-align: left;
}
table#t01 tr:nth-child(even) {
  background-color: #eee;
}
table#t01 tr:nth-child(odd) {
 background-color: #fff;
}
table#t01 th {
  background-color: black;
  color: white;
}
</style>';
        $html .= $content;

        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->WriteHTML($html);
        $mpdf->Output($file_name . '.pdf', 'D');
        exit;
    }

    public function actionGraph() {

        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
        $searchModel->graph_selection = 1;
        $searchModel->status = SrlmBcApplication::STATUS_PROVISIONAL;
        if (Yii::$app->user->identity->role == MasterRole::ROLE_DM) {
            $district = Yii::$app->user->identity->districts;
            $searchModel->district_code = isset(Yii::$app->user->identity->districts) ? Yii::$app->user->identity->districts[0]->district_code : -1;
        }
        if (Yii::$app->user->identity->role == MasterRole::ROLE_DIVISIONAL_COMMISSIONER) {
            $division = Yii::$app->user->identity->division;
            $searchModel->division_code = isset(Yii::$app->user->identity->division) ? Yii::$app->user->identity->division[0]->division_code : -1;
        }
        $rep = new Graph();
        $graph1 = $rep->mu($searchModel);
        $graph2 = $rep->edu($searchModel);
        $graph3 = $rep->cast($searchModel);
        $graph4 = $rep->age($searchModel);
        $graph5 = $rep->phone_type($searchModel);
        $graph6 = $rep->whatsup($searchModel);
        $graph7 = $rep->agm($searchModel);
        return $this->render('selection', [
                    'searchModel' => $searchModel,
                    'graph1' => $graph1,
                    'graph2' => $graph2,
                    'graph3' => $graph3,
                    'graph4' => $graph4,
                    'graph5' => $graph5,
                    'graph6' => $graph6,
                    'graph7' => $graph7,
        ]);
    }

    public function actionTblocked() {

        if (Yii::$app->request->isGet)
            $searchModel = new \bc\modules\selection\models\form\DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new \bc\modules\selection\models\form\DashboardSearchForm(Yii::$app->request->post());

        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 100);
        $dataProvider->query->andWhere(['!=', 'srlm_bc_application.form_number', '0']);
        $dataProvider->query->andWhere(['=', 'srlm_bc_application.form_number', '6']);
        $dataProvider->query->andWhere(['=', 'srlm_bc_application.gender', '2']);
        $dataProvider->query->andWhere(['srlm_bc_application.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.blocked' => [6, 60, 61, 62]]);
        $dataProvider->query->andWhere(['srlm_bc_application.training_status' => [0, 1, 2, 3]]);
        if ($searchModel->operational != '') {
            if ($searchModel->operational == 0) {
                $dataProvider->query->andWhere(['=', 'no_of_transaction', 0]);
            }
            if ($searchModel->operational == 1) {
                $dataProvider->query->andWhere(['>', 'no_of_transaction', 0]);
            }
        }
        return $this->render('tblocked', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

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
