<?php

namespace bc\modules\selection\modules\dashboard\controllers;

use Yii;
use yii\web\Controller;
use bc\modules\selection\models\form\DashboardSearchForm;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\modules\selection\models\SrlmBcApplicationGroupFamily;
use common\models\master\MasterRole;
use bc\modules\selection\components\BcApplication;

/**
 * Default controller for the `dashboard` module
 */
class Phase1Controller extends Controller {

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
        if (!in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER])) {
            return $this->redirect(['/selection/preselected']);
        }
        $dataProvider = [];
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider1 = $searchModels->searchc($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10'], null, \bc\modules\selection\models\base\GenralModel::select_selection_dashboard_column());
        $dataProvider1->query->andWhere(['!=', 'form_number', '0']);
        $dataProvider1->query->andWhere(['=', 'application_phase', '1']);
        $searchModels = new SrlmBcApplicationSearch();
        if ($searchModel->section_at) {
            $searchModels->form_number = $searchModel->section_at;
        }
        $dataProvider3 = $searchModels->searchc($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10'], null, \bc\modules\selection\models\base\GenralModel::select_selection_dashboard_column());
        $dataProvider3->query->andWhere(['!=', 'form_number', '0']);
        $dataProvider3->query->andWhere(['<', 'form_number', '6']);
        $dataProvider3->query->andWhere(['=', 'application_phase', '1']);
        $dataProvider3a = $searchModels->searchc($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10'], null, \bc\modules\selection\models\base\GenralModel::select_selection_dashboard_column());
        $dataProvider3a->query->andWhere(['!=', 'form_number', '0']);
        $dataProvider3a->query->andWhere(['<', 'form_number', '6']);
        $dataProvider3a->query->andWhere(['=', 'gender', '2']);
        $dataProvider3a->query->andWhere(['=', 'application_phase', '1']);
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider2 = $searchModels->searchc($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10'], null, \bc\modules\selection\models\base\GenralModel::select_selection_dashboard_column());
        
        $dataProvider2->query->andWhere(['=', 'form_number', '6']);
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider2a = $searchModels->searchc($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10'], null, \bc\modules\selection\models\base\GenralModel::select_selection_dashboard_column());
        
        $dataProvider2a->query->andWhere(['=', 'form_number', '6']);
        $dataProvider2a->query->andWhere(['=', 'gender', '2']);
        $dataProvider2a->query->andWhere(['=', 'application_phase', '1']);
        //$registeruser = \Yii::$app->dbbc->createCommand((new \yii\db\Query('dbbc'))->select('COUNT(*)')->from('srlm_bc_selection_user'))->scalar();
//        $registeruser = \Yii::$app->dbbc->createCommand("SELECT 'COUNT(id)' FROM srlm_bc_selection_user")->queryOne(); 
        $registeruser = \bc\modules\selection\models\SrlmBcSelectionUser::find()->where(['phase' => 1])->select('id')->count();
//        print_r($registeruser);exit;
        $dataProvider = null;
        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";
        if ($button_type == "1") {
            \Yii::$app->params['title'] = $button_type . '. Total application submitted';
            \Yii::$app->params['class'] = 'bg-info-100';

            $dataProvider = $dataProvider1;
        } elseif ($button_type == "3") {
            if (isset($this->params['page']))
                unset($this->params['page']);
            \Yii::$app->params['title'] = $button_type . ' Incomplete applications';
            \Yii::$app->params['class'] = 'bg-danger-100';
            $dataProvider = $dataProvider3;
        } elseif ($button_type == "3a") {
            if (isset($this->params['page']))
                unset($this->params['page']);
            \Yii::$app->params['title'] = $button_type . ' Incomplete applications (Only Females)';
            \Yii::$app->params['class'] = 'bg-danger-300';
            $dataProvider = $dataProvider3a;
        } elseif ($button_type == "2") {
            if (isset($this->params['page']))
                unset($this->params['page']);
            \Yii::$app->params['title'] = $button_type . ' Complete applications';
            \Yii::$app->params['class'] = 'bg-success-300';
            $models = $dataProvider2->getModels();
            $dataProvider=$dataProvider2;
           
        } elseif ($button_type == "2a") {
            if (isset($this->params['page']))
                unset($this->params['page']);
            \Yii::$app->params['title'] = $button_type . ' Complete applications  (Only Females)';
            \Yii::$app->params['class'] = 'bg-success-800';
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

    public function actionDownload() {
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
