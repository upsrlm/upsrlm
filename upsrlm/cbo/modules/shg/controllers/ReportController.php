<?php

namespace cbo\modules\shg\controllers;

use Yii;
use cbo\models\Shg;
use cbo\models\ShgSearch;
use app\modules\shg\models\form\ShgForm;
use app\modules\shg\models\form\ShgVerifyForm;
use cbo\models\CboDistrict;
use cbo\models\CboDistrictSearch;
use cbo\models\CboBlock;
use cbo\models\CboBlockSearch;
use common\models\base\GenralModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\master\MasterRole;
use kartik\mpdf\Pdf;
use Mpdf\Mpdf;

/**
 * Default controller for the `shg` module
 */
class ReportController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message = '';

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['daily'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU, MasterRole::ROLE_YOUNG_PROFESSIONAL, MasterRole::ROLE_MD]));
                        }
                    ],
                    [
                        'actions' => ['daily', 'bmmu'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD]));
                        }
                    ],
                    [
                        'actions' => ['registration'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD]));
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
    public function actionBmmu() {

        \common\models\User::updateAll(['status' => \common\models\User::STATUS_INACTIVE], ['role' => MasterRole::ROLE_BMMU]);

        $bmmuv2s = \common\models\master\Bmmulistv2::find()->all();

        foreach ($bmmuv2s as $bmmu) {
            $user = \common\models\User::findOne(['username' => $bmmu->Contact_No, 'status' => 10]);
            if ($user == null || empty($user)) {
                
            }
            //echo "<br/>" . $bmmu->s_no . " " . $bmmu->Contact_No . " ";
            else {
                echo "<br/>" . $bmmu->s_no . " " . $bmmu->Contact_No . " ";
            }
            \common\models\User::updateAll(['status' => \common\models\User::STATUS_ACTIVE], ['username' => $bmmu->Contact_No]);
        }

        // $users = \common\models\User::findAll(['role' => MasterRole::ROLE_BMMU, 'status' => 10]);
//        $count = 0;
//        foreach ($users as $user) {
//            $count++;
//            echo $count . " " . $user->id . "<br/>";
//        }
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionDaily() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        $users = \common\models\User::findAll(['role' => MasterRole::ROLE_BMMU, 'status' => 10]);

        $date = date("Y-m-d");
        $date0 = date('Y-m-d', strtotime('+1 day', strtotime($date)));
        $date1 = date('Y-m-d', strtotime('-1 day', strtotime($date)));
        $date2 = date('Y-m-d', strtotime('-2 day', strtotime($date)));
        $date3 = date('Y-m-d', strtotime('-3 day', strtotime($date)));
        $date4 = date('Y-m-d', strtotime('-4 day', strtotime($date)));
        $date5 = date('Y-m-d', strtotime('-5 day', strtotime($date)));

        $count = 0;
        $temp = 'S_no,District,Block,Name,Contact_No,total_shg,sgh-' . $date . ',sgh-' . $date1 . ',sgh-' . $date2 . ',sgh-' . $date3 . ',sgh-' . $date4 . ',sgh-' . $date5 . " \n";

        $c_total = $c_total = $c0_total = $c1_total = $c2_total = $c3_total = $c4_total = $c5_total = 0;
        foreach ($users as $user) {
            if (isset($user->blocks[0])) {
                
            } else {
//                echo $user->name . ',' . $user->username;


                continue;
            }

            $count++;
            $temp .= $count . ',' . $user->blocks[0]->block->district_name . ',' . $user->blocks[0]->block->block_name . ',' . $user->name . ',' . $user->username;
            $c = Shg::find()->where(['created_by' => $user->id])->count();
            //strtotime("last Sunday")
            $c = Shg::find()->where(['created_by' => $user->id])->count();
            $c0 = Shg::find()->where(['created_by' => $user->id])->andWhere('created_at >' . strtotime($date . " 00:00") . " and created_at <" . strtotime($date0 . " 00:00"))->count();
            $c1 = Shg::find()->where(['created_by' => $user->id])->andWhere('created_at >' . strtotime($date1 . " 00:00") . " and created_at <" . strtotime($date . " 00:00"))->count();
            $c2 = Shg::find()->where(['created_by' => $user->id])->andWhere('created_at >' . strtotime($date2 . " 00:00") . " and created_at <" . strtotime($date1 . " 00:00"))->count();
            $c3 = Shg::find()->where(['created_by' => $user->id])->andWhere('created_at >' . strtotime($date3 . " 00:00") . " and created_at <" . strtotime($date2 . " 00:00"))->count();
            $c4 = Shg::find()->where(['created_by' => $user->id])->andWhere('created_at >' . strtotime($date4 . " 00:00") . " and created_at <" . strtotime($date3 . " 00:00"))->count();
            $c5 = Shg::find()->where(['created_by' => $user->id])->andWhere('created_at >' . strtotime($date5 . " 00:00") . " and created_at <" . strtotime($date4 . " 00:00"))->count();
            $temp .= "," . $c . "," . $c0 . "," . $c1 . "," . $c2 . "," . $c3 . "," . $c4 . "," . $c5 . "," . "\n";
            //$temp .= "\n";

            $c_total = $c_total + $c;
            $c0_total = $c0_total + $c0;
            $c1_total = $c1_total + $c1;
            $c2_total = $c2_total + $c2;
            $c3_total = $c3_total + $c3;
            $c4_total = $c4_total + $c4;
            $c5_total = $c5_total + $c5;
        }
        $temp .= "Total,,,,," . $c_total . "," . $c0_total . "," . $c1_total . "," . $c2_total . "," . $c3_total . "," . $c4_total . "," . $c5_total . "," . "\n";
        $file_name = "daily_activity_" . date("Y_m_d_H-m-s") . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file_name");
        $output = fopen('php://output', 'w');
        //fputcsv($output, "afssa");
        echo $temp;

        exit();
    }

    public function actionRegistration() {
        $searchModel = new CboDistrictSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 100);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        return $this->render('registration', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRegistrationblock() {
        $model = CboDistrict::findOne($_REQUEST['expandRowKey']);
        $searchModel = new \cbo\models\CboBlockSearch();
        $searchModel->district_code = $model->district_code;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);

        return $this->renderAjax('block', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDownloadregdistrict() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        date_default_timezone_set("Asia/Calcutta");
        $dataProvider = [];
        $user_model = Yii::$app->user->identity;
        $searchModel = new CboDistrictSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
        $file_name = "srlm_cbo_registration_status_district_wise_" . date("Y_m_d_H-m-s") . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file_name");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Sr No', 'District', 'Self-help groups (SHG) formed (Est.)', 'SHGs Entered', 'SHGs verified & correct', 'SHG difference', 'No. of SHG members (Est.)', 'SHG members E-registered', 'SHG members difference', 'No. of Village Organizations (VO)', 'VOs e-registered', 'VO difference', 'No. of Cluster level federations (CLF)', 'CLFs e-registered', 'CLF difference'));
        $models = $dataProvider->getModels();

        $sr_no = 1;
        foreach ($models as $model) {

            $row = [
                $sr_no,
                $model->district_name,
                $model->total_shgs,
                $model->getShgs()->count(),
                $model->getShgs()->andWhere(['verification_status' => 1])->andWhere(['verify_mobile_no' => 1])->count(),
                ($model->total_shgs - $model->getShgs()->andWhere(['verification_status' => 1])->andWhere(['verify_mobile_no' => 1])->count()),
                $model->total_members,
                $model->getShgs()->andWhere(['verification_status' => 1])->andWhere(['verify_mobile_no' => 1])->sum('no_of_members') != null ? $model->getShgs()->andWhere(['verification_status' => 1])->andWhere(['verify_mobile_no' => 1])->sum('no_of_members') : '',
                ($model->total_members - $model->getShgs()->andWhere(['verification_status' => 1])->andWhere(['verify_mobile_no' => 1])->sum('no_of_members')),
                $model->total_vo,
                $model->getVos()->andWhere(['status' => 2])->count(),
                ($model->total_vo - $model->getVos()->andWhere(['status' => 2])->count()),
                $model->total_clf,
                $model->getClfs()->andWhere(['status' => 2])->count(),
                ($model->total_clf - $model->getClfs()->andWhere(['status' => 2])->count()),
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        exit;
    }

    public function actionDownloadregblock() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        date_default_timezone_set("Asia/Calcutta");
        $dataProvider = [];
        $user_model = Yii::$app->user->identity;
        $searchModel = new CboBlockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
        $file_name = "srlm_cbo_registration_status_blcok_wise_" . date("Y_m_d_H-m-s") . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file_name");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Sr No', 'District', 'Block', 'Self-help groups (SHG) formed (Est.)', 'SHGs Entered', 'SHGs verified & correct', 'SHG difference', 'No. of SHG members (Est.)', 'SHG members E-registered', 'SHG members difference', 'No. of Village Organizations (VO)', 'VOs e-registered', 'VO difference', 'No. of Cluster level federations (CLF)', 'CLFs e-registered', 'CLF difference'));
        $models = $dataProvider->getModels();

        $sr_no = 1;
        foreach ($models as $model) {

            $row = [
                $sr_no,
                $model->district_name,
                $model->block_name,
                $model->total_shgs,
                $model->getShgs()->count(),
                $model->getShgs()->andWhere(['verification_status' => 1])->andWhere(['verify_mobile_no' => 1])->count(),
                ($model->total_shgs - $model->getShgs()->andWhere(['verification_status' => 1])->andWhere(['verify_mobile_no' => 1])->count()),
                $model->total_members,
                $model->getShgs()->andWhere(['verification_status' => 1])->andWhere(['verify_mobile_no' => 1])->sum('no_of_members') != null ? $model->getShgs()->andWhere(['verification_status' => 1])->andWhere(['verify_mobile_no' => 1])->sum('no_of_members') : '',
                ($model->total_members - $model->getShgs()->andWhere(['verification_status' => 1])->andWhere(['verify_mobile_no' => 1])->sum('no_of_members')),
                $model->total_vo,
                $model->getVos()->andWhere(['status' => 2])->count(),
                ($model->total_vo - $model->getVos()->andWhere(['status' => 2])->count()),
                $model->total_clf,
                $model->getClfs()->andWhere(['status' => 2])->count(),
                ($model->total_clf - $model->getClfs()->andWhere(['status' => 2])->count()),
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        exit;
    }

    public function actionDailyv() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        $users = \common\models\User::findAll(['role' => MasterRole::ROLE_YOUNG_PROFESSIONAL, 'status' => 10]);

        $date = date("Y-m-d");
        $date0 = date('Y-m-d', strtotime('+1 day', strtotime($date)));
        $date1 = date('Y-m-d', strtotime('-1 day', strtotime($date)));
        $date2 = date('Y-m-d', strtotime('-2 day', strtotime($date)));
        $date3 = date('Y-m-d', strtotime('-3 day', strtotime($date)));
        $date4 = date('Y-m-d', strtotime('-4 day', strtotime($date)));
        $date5 = date('Y-m-d', strtotime('-5 day', strtotime($date)));

        $count = 0;
        $temp = 'S_no,Name,Contact_No,total_shg,sgh-' . $date . ',sgh-' . $date1 . ',sgh-' . $date2 . ',sgh-' . $date3 . ',sgh-' . $date4 . ',sgh-' . $date5 . " \n";
        $c_total = $c_total = $c0_total = $c1_total = $c2_total = $c3_total = $c4_total = $c5_total = 0;
        foreach ($users as $user) {


            $count++;
            $temp .= $count . ',' . $user->name . ',' . $user->username;
            $c = Shg::find()->where(['updated_by' => $user->id])->count();
            //strtotime("last Sunday")
            $c = Shg::find()->where(['updated_by' => $user->id])->count();
            $c0 = Shg::find()->where(['updated_by' => $user->id])->andWhere('updated_at >' . strtotime($date . " 00:00") . " and updated_at <" . strtotime($date0 . " 00:00"))->count();
            $c1 = Shg::find()->where(['updated_by' => $user->id])->andWhere('updated_at >' . strtotime($date1 . " 00:00") . " and updated_at <" . strtotime($date . " 00:00"))->count();
            $c2 = Shg::find()->where(['updated_by' => $user->id])->andWhere('updated_at >' . strtotime($date2 . " 00:00") . " and updated_at <" . strtotime($date1 . " 00:00"))->count();
            $c3 = Shg::find()->where(['updated_by' => $user->id])->andWhere('updated_at >' . strtotime($date3 . " 00:00") . " and updated_at <" . strtotime($date2 . " 00:00"))->count();
            $c4 = Shg::find()->where(['updated_by' => $user->id])->andWhere('updated_at >' . strtotime($date4 . " 00:00") . " and updated_at <" . strtotime($date3 . " 00:00"))->count();
            $c5 = Shg::find()->where(['updated_by' => $user->id])->andWhere('updated_at >' . strtotime($date5 . " 00:00") . " and updated_at <" . strtotime($date4 . " 00:00"))->count();
            $temp .= "," . $c . "," . $c0 . "," . $c1 . "," . $c2 . "," . $c3 . "," . $c4 . "," . $c5 . "," . "\n";
            //$temp .= "\n";

            $c_total = $c_total + $c;
            $c0_total = $c0_total + $c0;
            $c1_total = $c1_total + $c1;
            $c2_total = $c2_total + $c2;
            $c3_total = $c3_total + $c3;
            $c4_total = $c4_total + $c4;
            $c5_total = $c5_total + $c5;
        }
        $temp .= "Total,,," . $c_total . "," . $c0_total . "," . $c1_total . "," . $c2_total . "," . $c3_total . "," . $c4_total . "," . $c5_total . "," . "\n";
        $file_name = "daily_activity_verfiy_" . date("Y_m_d_H-m-s") . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file_name");
        $output = fopen('php://output', 'w');
        //fputcsv($output, "afssa");
        echo $temp;

        exit();
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionDailyblock() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        $users = \common\models\master\MasterBlock::find()->orderBy('district_name asc , block_name asc')->all();

        $date = date("Y-m-d");
        $date0 = date('Y-m-d', strtotime('+1 day', strtotime($date)));
        $date1 = date('Y-m-d', strtotime('-1 day', strtotime($date)));
        $date2 = date('Y-m-d', strtotime('-2 day', strtotime($date)));
        $date3 = date('Y-m-d', strtotime('-3 day', strtotime($date)));
        $date4 = date('Y-m-d', strtotime('-4 day', strtotime($date)));
        $date5 = date('Y-m-d', strtotime('-5 day', strtotime($date)));

        $count = 0;
        $temp = 'S_no,District,Block,total_shg,sgh-' . $date . ',sgh-' . $date1 . ',sgh-' . $date2 . ',sgh-' . $date3 . ',sgh-' . $date4 . ',sgh-' . $date5 . " \n";

        $c_total = $c_total = $c0_total = $c1_total = $c2_total = $c3_total = $c4_total = $c5_total = 0;
        foreach ($users as $user) {


            $count++;
            $temp .= $count . ',' . $user->district_name . ',' . $user->block_name;
            $c = Shg::find()->where(['block_code' => $user->block_code])->count();
            //strtotime("last Sunday")
            $c = Shg::find()->where(['block_code' => $user->block_code])->count();
            $c0 = Shg::find()->where(['block_code' => $user->block_code])->andWhere('created_at >' . strtotime($date . " 00:00") . " and created_at <" . strtotime($date0 . " 00:00"))->count();
            $c1 = Shg::find()->where(['block_code' => $user->block_code])->andWhere('created_at >' . strtotime($date1 . " 00:00") . " and created_at <" . strtotime($date . " 00:00"))->count();
            $c2 = Shg::find()->where(['block_code' => $user->block_code])->andWhere('created_at >' . strtotime($date2 . " 00:00") . " and created_at <" . strtotime($date1 . " 00:00"))->count();
            $c3 = Shg::find()->where(['block_code' => $user->block_code])->andWhere('created_at >' . strtotime($date3 . " 00:00") . " and created_at <" . strtotime($date2 . " 00:00"))->count();
            $c4 = Shg::find()->where(['block_code' => $user->block_code])->andWhere('created_at >' . strtotime($date4 . " 00:00") . " and created_at <" . strtotime($date3 . " 00:00"))->count();
            $c5 = Shg::find()->where(['block_code' => $user->block_code])->andWhere('created_at >' . strtotime($date5 . " 00:00") . " and created_at <" . strtotime($date4 . " 00:00"))->count();
            $temp .= "," . $c . "," . $c0 . "," . $c1 . "," . $c2 . "," . $c3 . "," . $c4 . "," . $c5 . "," . "\n";
            //$temp .= "\n";

            $c_total = $c_total + $c;
            $c0_total = $c0_total + $c0;
            $c1_total = $c1_total + $c1;
            $c2_total = $c2_total + $c2;
            $c3_total = $c3_total + $c3;
            $c4_total = $c4_total + $c4;
            $c5_total = $c5_total + $c5;
        }
        $temp .= "Total,,," . $c_total . "," . $c0_total . "," . $c1_total . "," . $c2_total . "," . $c3_total . "," . $c4_total . "," . $c5_total . "," . "\n";
        $file_name = "daily_activity_block_" . date("Y_m_d_H-m-s") . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file_name");
        $output = fopen('php://output', 'w');
        //fputcsv($output, "afssa");
        echo $temp;

        exit();
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionDailydistrict() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        $users = \common\models\master\MasterDistrict::find()->orderBy('district_name asc')->all();

        $date = date("Y-m-d");
        $date0 = date('Y-m-d', strtotime('+1 day', strtotime($date)));
        $date1 = date('Y-m-d', strtotime('-1 day', strtotime($date)));
        $date2 = date('Y-m-d', strtotime('-2 day', strtotime($date)));
        $date3 = date('Y-m-d', strtotime('-3 day', strtotime($date)));
        $date4 = date('Y-m-d', strtotime('-4 day', strtotime($date)));
        $date5 = date('Y-m-d', strtotime('-5 day', strtotime($date)));

        $count = 0;
        $temp = 'S_no,District,total_shg,sgh-' . $date . ',sgh-' . $date1 . ',sgh-' . $date2 . ',sgh-' . $date3 . ',sgh-' . $date4 . ',sgh-' . $date5 . " \n";

        $c_total = $c_total = $c0_total = $c1_total = $c2_total = $c3_total = $c4_total = $c5_total = 0;
        foreach ($users as $user) {


            $count++;
            $temp .= $count . ',' . $user->district_name;
            $c = Shg::find()->where(['district_code' => $user->district_code])->count();
            //strtotime("last Sunday")
            $c = Shg::find()->where(['district_code' => $user->district_code])->count();
            $c0 = Shg::find()->where(['district_code' => $user->district_code])->andWhere('created_at >' . strtotime($date . " 00:00") . " and created_at <" . strtotime($date0 . " 00:00"))->count();
            $c1 = Shg::find()->where(['district_code' => $user->district_code])->andWhere('created_at >' . strtotime($date1 . " 00:00") . " and created_at <" . strtotime($date . " 00:00"))->count();
            $c2 = Shg::find()->where(['district_code' => $user->district_code])->andWhere('created_at >' . strtotime($date2 . " 00:00") . " and created_at <" . strtotime($date1 . " 00:00"))->count();
            $c3 = Shg::find()->where(['district_code' => $user->district_code])->andWhere('created_at >' . strtotime($date3 . " 00:00") . " and created_at <" . strtotime($date2 . " 00:00"))->count();
            $c4 = Shg::find()->where(['district_code' => $user->district_code])->andWhere('created_at >' . strtotime($date4 . " 00:00") . " and created_at <" . strtotime($date3 . " 00:00"))->count();
            $c5 = Shg::find()->where(['district_code' => $user->district_code])->andWhere('created_at >' . strtotime($date5 . " 00:00") . " and created_at <" . strtotime($date4 . " 00:00"))->count();
            $temp .= "," . $c . "," . $c0 . "," . $c1 . "," . $c2 . "," . $c3 . "," . $c4 . "," . $c5 . "," . "\n";
            //$temp .= "\n";

            $c_total = $c_total + $c;
            $c0_total = $c0_total + $c0;
            $c1_total = $c1_total + $c1;
            $c2_total = $c2_total + $c2;
            $c3_total = $c3_total + $c3;
            $c4_total = $c4_total + $c4;
            $c5_total = $c5_total + $c5;
        }
        $temp .= "Total,," . $c_total . "," . $c0_total . "," . $c1_total . "," . $c2_total . "," . $c3_total . "," . $c4_total . "," . $c5_total . "," . "\n";
        $file_name = "daily_activity_distrcit_" . date("Y_m_d_H-m-s") . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file_name");
        $output = fopen('php://output', 'w');
        //fputcsv($output, "afssa");
        echo $temp;

        exit();
    }

    public function actionCsvshgnotreggp() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        $searchModels = new \common\models\master\MasterGramPanchayatSearch();
        $dataProvider = $searchModels->search($searchModels, Yii::$app->user->identity, false);
        $dataProvider->query->joinWith(['shg']);
        $dataProvider->query->andWhere(['cbo_shg.id' => null]);
        $count = $dataProvider->query->count();
        $models = $dataProvider->getModels();
        $file = "shg_registration_not_gp" . date("Y_m_d_H-m-s") . ".csv";
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Sr No', 'Gram Panchayat Name', 'Block Name', 'District'));
        $sr_no = 1;
        $row = [];
        foreach ($models as $model) {
            $row = [
                $sr_no,
                $model->gram_panchayat_name,
                $model->block_name,
                $model->district_name,
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        exit();
    }

    public function actionCsvshgreggp() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '4048M');
//        $searchModels = new \common\models\master\MasterGramPanchayatSearch();
//        $dataProvider = $searchModels->search($searchModels, Yii::$app->user->identity, false);
//        $dataProvider->query->joinWith(['shg']);
//    
//        $count = $dataProvider->query->count();
//        $models = $dataProvider->getModels();
        $query = \common\models\master\MasterGramPanchayat::find()
                ->select(['master_gram_panchayat.*'])
                //->join('LEFT OUTER JOIN', \cbo\models\Shg::tableName(), 'cbo_shg.gram_panchayat_code=master_gram_panchayat.gram_panchayat_code')
                //->where(['dummy_column' => 0])->andWhere(['!=','cbo_shg.status',-1])
                ->andWhere(['!=', 'master_gram_panchayat.status', 1])
                ->andWhere(['!=', 'master_gram_panchayat.district_code', 0])
                ->andWhere(['!=', 'master_gram_panchayat.block_code', 0]);

        //->limit(10);
        $models = $query->all();
//        echo count($models);exit;

        $file = "cbo_shg_registration_gp" . date("Y_m_d_H-m-s") . ".csv";
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Sr No', 'Gram Panchayat Name', 'Block Name', 'District', 'SHGs Entered'));
        $sr_no = 1;
        $row = [];
        foreach ($models as $model) {
            $shg_count = \cbo\models\Shg::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code, 'dummy_column' => 0])->count();
            $row = [
                $sr_no,
                $model->gram_panchayat_name,
                $model->block_name,
                $model->district_name,
                $shg_count,
            ];
            fputcsv($output, $row);
            $sr_no++;
            $shg_count = 0;
        }
        exit();
    }

}
