<?php

namespace bc\modules\selection\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\grid\GridView;
use kartik\mpdf\Pdf;
use Mpdf\Mpdf;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\modules\selection\models\form\DashboardSearchForm;
use common\models\master\MasterRole;
use bc\modules\selection\models\SrlmBcSelectionUser;
use bc\modules\selection\models\SrlmBcSelectionUserSearch;
use bc\models\master\MasterDistrictSearch;
use bc\models\master\MasterBlockSearch;
use bc\models\master\MasterGramPanchayatSearch;
use bc\modules\selection\models\base\GenralModel;
use bc\modules\selection\components\BcApplication;

/**
 * Default controller for the `srlm` module
 */
class DashboardController extends Controller {

    public $flash_message;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'download'],
                'rules' => [
                    [
                        'actions' => ['index', 'download'],
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
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        if (!in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) {
            return $this->redirect(['/selection/preselected']);
        }
        $dataProvider = [];
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider1 = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider1->query->andWhere(['!=', 'form_number', '0']);
        $searchModels = new SrlmBcApplicationSearch();
        if ($searchModel->section_at) {
            $searchModels->form_number = $searchModel->section_at;
        }
        $dataProvider3 = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider3->query->andWhere(['!=', 'form_number', '0']);
        $dataProvider3->query->andWhere(['<', 'form_number', '6']);
        $dataProvider3a = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        
        $dataProvider3a->query->andWhere(['<', 'form_number', '6']);
        $dataProvider3a->query->andWhere(['=', 'gender', '2']);
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider2 = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider2->query->andWhere(['!=', 'form_number', '0']);
        $dataProvider2->query->andWhere(['=', 'form_number', '6']);
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider2a = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        
        $dataProvider2a->query->andWhere(['=', 'form_number', '6']);
        $dataProvider2a->query->andWhere(['=', 'gender', '2']);
        $registeruser = (new \yii\db\Query())->select('COUNT(*)')->from('srlm_bc_selection_user')->scalar();

        $dataProvider = null;
        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";
        if ($button_type == "1") {
            \Yii::$app->params['title'] = $button_type . '. Total application submitted';
            \Yii::$app->params['class'] = 'widget-box widget-color-blue';

            $dataProvider = $dataProvider1;
        } elseif ($button_type == "3") {
            if (isset($this->params['page']))
                unset($this->params['page']);
            \Yii::$app->params['title'] = $button_type . ' Incomplete applications';
            \Yii::$app->params['class'] = 'widget-box widget-color-red';
            $dataProvider = $dataProvider3;
        } elseif ($button_type == "3a") {
            if (isset($this->params['page']))
                unset($this->params['page']);
            \Yii::$app->params['title'] = $button_type . ' Incomplete applications (Only Females)';
            \Yii::$app->params['class'] = 'widget-box widget-color-red';
            $dataProvider = $dataProvider3a;
        } elseif ($button_type == "2") {
            if (isset($this->params['page']))
                unset($this->params['page']);
            \Yii::$app->params['title'] = $button_type . ' Complete applications';
            \Yii::$app->params['class'] = 'widget-box widget-color-green';
            $models = $dataProvider2->getModels();
            if (!empty($models)) {
                foreach ($models as $model) {
                    $bc_application = new BcApplication($model->id);
                    $bc_application->calculaterating();
                }
            }
            $dataProvider2 = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $dataProvider2->query->andWhere(['!=', 'form_number', '0']);
            $dataProvider2->query->andWhere(['=', 'form_number', '6']);

            $dataProvider = $dataProvider2;
        } elseif ($button_type == "2a") {
            if (isset($this->params['page']))
                unset($this->params['page']);
            \Yii::$app->params['title'] = $button_type . ' Complete applications  (Only Females)';
            \Yii::$app->params['class'] = 'widget-box widget-color-green';
            $models = $dataProvider2a->getModels();
            if (!empty($models)) {
                foreach ($models as $model) {
                    $bc_application = new BcApplication($model->id);
                    $bc_application->calculaterating();
                }
            }
            $dataProvider2a = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $dataProvider2a->query->andWhere(['!=', 'form_number', '0']);
            $dataProvider2a->query->andWhere(['=', 'form_number', '6']);
            $dataProvider2a->query->andWhere(['=', 'gender', '2']);
            $dataProvider = $dataProvider2a;
        }

        return $this->render('index', [
                    'button_type' => $button_type,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvider1' => $dataProvider1,
                    'dataProvider2' => $dataProvider2,
                    'dataProvider2a' => $dataProvider2a,
                    'dataProvider3' => $dataProvider3,
                    'dataProvider3a' => $dataProvider3a,
                    'registeruser' => $registeruser
        ]);
    }
    public function actionPhase1() {
        if (!in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) {
            return $this->redirect(['/selection/preselected']);
        }
        $dataProvider = [];
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider1 = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider1->query->andWhere(['!=', 'form_number', '0']);
        $dataProvider1->query->andWhere(['=', 'application_phase', '1']);
        $searchModels = new SrlmBcApplicationSearch();
        if ($searchModel->section_at) {
            $searchModels->form_number = $searchModel->section_at;
        }
        $dataProvider3 = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider3->query->andWhere(['!=', 'form_number', '0']);
        $dataProvider3->query->andWhere(['<', 'form_number', '6']);
        $dataProvider3->query->andWhere(['=', 'application_phase', '1']);
        $dataProvider3a = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        
        $dataProvider3a->query->andWhere(['<', 'form_number', '6']);
        $dataProvider3a->query->andWhere(['=', 'gender', '2']);
        $dataProvider3a->query->andWhere(['=', 'application_phase', '1']);
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider2 = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider2->query->andWhere(['!=', 'form_number', '0']);
        $dataProvider2->query->andWhere(['=', 'form_number', '6']);
        $dataProvider2->query->andWhere(['=', 'application_phase', '1']);
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider2a = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        
        $dataProvider2a->query->andWhere(['=', 'form_number', '6']);
        $dataProvider2a->query->andWhere(['=', 'gender', '2']);
        $dataProvider2a->query->andWhere(['=', 'application_phase', '1']);
        $registeruser = (new \yii\db\Query())->select('COUNT(*)')->where(['phase'=>1])->from('srlm_bc_selection_user')->scalar();

        $dataProvider = null;
        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";
        if ($button_type == "1") {
            \Yii::$app->params['title'] = $button_type . '. Total application submitted';
            \Yii::$app->params['class'] = 'widget-box widget-color-blue';

            $dataProvider = $dataProvider1;
        } elseif ($button_type == "3") {
            if (isset($this->params['page']))
                unset($this->params['page']);
            \Yii::$app->params['title'] = $button_type . ' Incomplete applications';
            \Yii::$app->params['class'] = 'widget-box widget-color-red';
            $dataProvider = $dataProvider3;
        } elseif ($button_type == "3a") {
            if (isset($this->params['page']))
                unset($this->params['page']);
            \Yii::$app->params['title'] = $button_type . ' Incomplete applications (Only Females)';
            \Yii::$app->params['class'] = 'widget-box widget-color-red';
            $dataProvider = $dataProvider3a;
        } elseif ($button_type == "2") {
            if (isset($this->params['page']))
                unset($this->params['page']);
            \Yii::$app->params['title'] = $button_type . ' Complete applications';
            \Yii::$app->params['class'] = 'widget-box widget-color-green';
            $models = $dataProvider2->getModels();
//            if (!empty($models)) {
//                foreach ($models as $model) {
//                    $bc_application = new BcApplication($model->id);
//                    $bc_application->calculaterating();
//                }
//            }
            $dataProvider2 = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $dataProvider2->query->andWhere(['!=', 'form_number', '0']);
            $dataProvider2->query->andWhere(['=', 'form_number', '6']);
            $dataProvider2->query->andWhere(['=', 'application_phase', '1']);
            $dataProvider = $dataProvider2;
        } elseif ($button_type == "2a") {
            if (isset($this->params['page']))
                unset($this->params['page']);
            \Yii::$app->params['title'] = $button_type . ' Complete applications  (Only Females)';
            \Yii::$app->params['class'] = 'widget-box widget-color-green';
            $models = $dataProvider2a->getModels();
//            if (!empty($models)) {
//                foreach ($models as $model) {
//                    $bc_application = new BcApplication($model->id);
//                    $bc_application->calculaterating();
//                }
//            }
            $dataProvider2a = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $dataProvider2a->query->andWhere(['!=', 'form_number', '0']);
            $dataProvider2a->query->andWhere(['=', 'form_number', '6']);
            $dataProvider2a->query->andWhere(['=', 'gender', '2']);
            $dataProvider2a->query->andWhere(['=', 'application_phase', '1']);
            $dataProvider = $dataProvider2a;
        }

        return $this->render('phase1', [
                    'button_type' => $button_type,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvider1' => $dataProvider1,
                    'dataProvider2' => $dataProvider2,
                    'dataProvider2a' => $dataProvider2a,
                    'dataProvider3' => $dataProvider3,
                    'dataProvider3a' => $dataProvider3a,
                    'registeruser' => $registeruser
        ]);
    }
    public function actionDownload() {
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_MD, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            return $this->redirect(['/selection/preselected']);
        }
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        date_default_timezone_set("Asia/Calcutta");
        $dataProvider = [];
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplicationSearch();
        if ($searchModel->section_at) {
            $searchModels->form_number = $searchModel->section_at;
        }
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, false, 'srlm_bc_application.id');
        $dataProvider->query->andWhere(['!=', 'form_number', '0']);
        $dataProvider->query->andWhere(['<', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $file_name = "srlm_bc_selection_incomplete_applications_" . date("Y_m_d_H-m-s") . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file_name");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Sr No', 'Name', 'Guardian Name', 'Mobile Number', 'Aadhar Number', 'Age', 'Social Category', 'District', 'Block', 'Gram Panchayat', 'Village', 'Hamlet', 'Section At', 'Started Filling Form On', 'Number of completed on the basic of mobile number', 'Number of completed on the basic of aadhar number', 'OTP Verified mobile no'));
        $models = $dataProvider->getModels();

        $sr_no = 1;
        foreach ($models as $model) {
            $model = SrlmBcApplication::findOne($model['id']);
            $gender = $model->genderrel != null ? $model->genderrel->name_eng : '';
            $cast = $model->castrel != null ? $model->castrel->name_eng : '';
            $form_start_date = $model->form_start_date != null ? $model->form_start_date : '';
            $row = [
                $sr_no,
                $model->name,
                $model->guardian_name,
                $model->mobile_number,
                common\helpers\Utility::maskaadhar($model->aadhar_number),
                $model->age,
                $cast,
                $model->district_name,
                $model->block_name,
                $model->gram_panchayat_name,
                $model->village_name,
                $model->hamlet,
                $model->form_number,
                $form_start_date,
                SrlmBcApplication::find()->select('id')->where(['mobile_number' => $model->mobile_number, 'form_number' => 6])->asArray()->count(),
                SrlmBcApplication::find()->select('id')->where(['aadhar_number' => $model->aadhar_number, 'form_number' => 6])->asArray()->count(),
                $model->user->mobile_no,
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        exit;
    }

    public function actionDownloadcomapplication() {
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_DM, MasterRole::ROLE_MD, MasterRole::ROLE_DIVISIONAL_COMMISSIONER, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            return $this->redirect(['/selection/preselected']);
        }
        date_default_timezone_set("Asia/Calcutta");
        $dataProvider = [];
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplicationSearch();

        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, false, 'srlm_bc_application.id');
        $dataProvider->query->andWhere(['!=', 'form_number', '0']);
        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvidera->query->andWhere(['=', 'gender', '2']);
        $file_name = "srlm_bc_selection_complete_applications_" . date("Y_m_d_H-m-s") . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file_name");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Sr No', 'Name', 'Guardian Name', 'Mobile Number', 'Age', 'Social Category', 'District', 'Block', 'Gram Panchayat', 'Village', 'Hamlet', 'Form submit On'));
        $models = $dataProvider->getModels();

        $sr_no = 1;
        foreach ($models as $model) {
            $gender = $model->genderrel != null ? $model->genderrel->name_eng : '';
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
                $form_end_date
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        exit;
//        } else {
////            $this->flash_message = 'It is too large to  download results  It must be less than 3000  results'; //'You are try downloading larger data please .';
////            \Yii::$app->getSession()->setFlash('error', \Yii::t('user', $this->flash_message));
//            if (isset(\Yii::$app->request->referrer)) {
//                return $this->redirect(\Yii::$app->request->referrer);
//            }
//        }
    }

}
