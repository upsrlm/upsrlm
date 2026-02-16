<?php

namespace bc\modules\selection\modules\phasethree\controllers;

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
use bc\modules\selection\models\SrlmBcApplication3;
use bc\modules\selection\models\SrlmBcApplication3Search;
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

        $dataProvider = [];
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModel->second_vacant=1;
        $searchModels = new SrlmBcApplication3Search();
        $dataProvider1 = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider1->query->andWhere(['!=', 'form_number', '0']);
        $searchModels = new SrlmBcApplication3Search();
        if ($searchModel->section_at) {
            $searchModels->form_number = $searchModel->section_at;
        }
        $dataProvider3 = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider3->query->andWhere(['!=', 'form_number', '0']);
        $dataProvider3->query->andWhere(['<', 'form_number', '6']);
        $dataProvider3a = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        $dataProvider3a->query->andWhere(['<', 'form_number', '6']);
        $dataProvider3a->query->andWhere(['=', 'gender', '2']);
        $searchModels = new SrlmBcApplication3Search();
        $dataProvider2 = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider2->query->andWhere(['!=', 'form_number', '0']);
        $dataProvider2->query->andWhere(['=', 'form_number', '6']);
        $searchModels = new SrlmBcApplication3Search();
        $dataProvider2a = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        $dataProvider2a->query->andWhere(['=', 'form_number', '6']);
        $dataProvider2a->query->andWhere(['=', 'gender', '2']);
        $registeruser = \bc\modules\selection\models\SrlmBcSelectionUser::find()->select(['id'])->where(['phase' => 3])->count();
        $district_option_model = \bc\models\master\MasterGramPanchayat::find()->joinWith(['gpdetail'])->select(['district_code', 'district_name'])->distinct('district_code')->andWhere(['master_gram_panchayat.status' => 1])->andWhere(['or',
                    ['master_gram_panchayat_detail_bc.third_vacant' => 1],
                ])->all();

        $searchModel->district_option = \yii\helpers\ArrayHelper::map($district_option_model, 'district_code', 'district_name');

        $block_model = \bc\models\master\MasterGramPanchayat::find()->joinWith(['gpdetail'])->select(['block_code', 'block_name'])->distinct('block_code')->andWhere(['master_gram_panchayat.status' => 1])->andWhere(['or',
            ['master_gram_panchayat_detail_bc.third_vacant' => 1],
        ]);
        if ($searchModel->district_code) {
            $block_model->andWhere(['district_code' => $searchModel->district_code]);
        }
        $block_option_model = $block_model->all();
        $searchModel->block_option = \yii\helpers\ArrayHelper::map($block_option_model, 'block_code', 'block_name');
        if ($searchModel->block_code) {
            $gp_model = \bc\models\master\MasterGramPanchayat::find()->joinWith(['gpdetail'])->select(['master_gram_panchayat.gram_panchayat_code', 'gram_panchayat_name'])->distinct('gram_panchayat_code')->andWhere(['master_gram_panchayat.status' => 1])->andWhere(['or',
                ['master_gram_panchayat_detail_bc.third_vacant' => 1],
            ]);

            $gp_model->andWhere(['block_code' => $searchModel->block_code]);

            $gp_option_model = $gp_model->all();
            $searchModel->gp_option = \yii\helpers\ArrayHelper::map($gp_option_model, 'gram_panchayat_code', 'gram_panchayat_name');
        }
        $dataProvider = null;
        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";
        if ($button_type == "1") {
            \Yii::$app->params['title'] = $button_type . '. Total Registration Start';
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
//                foreach ($models as $model) {
//                    $bc_application = new BcApplication($model->id);
//                    $bc_application->calculaterating();
//                }
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
//                foreach ($models as $model) {
//                    $bc_application = new BcApplication($model->id);
//                    $bc_application->calculaterating();
//                }
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

    public function actionDownload() {

        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        date_default_timezone_set("Asia/Calcutta");
        $dataProvider = [];
        $user_model = Yii::$app->user->identity;
        $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplication3Search();
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
            $model = SrlmBcApplication3::findOne($model['id']);
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
                SrlmBcApplication3::find()->select('id')->where(['mobile_number' => $model->mobile_number, 'form_number' => 6])->asArray()->count(),
                SrlmBcApplication3::find()->select('id')->where(['aadhar_number' => $model->aadhar_number, 'form_number' => 6])->asArray()->count(),
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
        $searchModels = new SrlmBcApplication3Search();

        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, false, 'srlm_bc_application2.id');
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
