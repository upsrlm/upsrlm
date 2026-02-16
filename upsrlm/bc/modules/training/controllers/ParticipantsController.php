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
use bc\modules\training\models\form\AddScoreForm;
use common\models\master\MasterRole;
use yii\web\UploadedFile;
use common\models\CboMembers;
use common\models\User;
use common\models\CboMemberProfile;
use bc\modules\selection\models\BcFiles;
use bc\modules\selection\models\BcFilesSearch;
use bc\components\BCNotification;

/**
 * Default controller for the `training` module
 */
class ParticipantsController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'miscsv', 'certified', 'verification', 'verificationcsv', 'pfmspayment', 'pfmspaymentcsv', 'view', 'assignshg', 'returnforshg', 'addscore', 'uploadpvr', 'bcpfmsmapping', 'detail', 'bcbeneficiariesrevert', 'paytm', 'cdounwilling', 'importbcpfms'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'miscsv', 'certified', 'verification', 'verificationcsv', 'pfmspayment', 'pfmspaymentcsv', 'view', 'assignshg', 'returnforshg', 'addscore', 'uploadpvr', 'pfmspayment', 'pfmspaymentcsv', 'bcpfmsmapping', 'detail', 'bcbeneficiariesrevert', 'paytm', 'cdounwilling', 'importbcpfms'],
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
        $searchModel = new RsetisBatchParticipantsSearch();
        $searchModel->show_blocked = 0;
        if (Yii::$app->request->isGet)
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (Yii::$app->request->isPost)
            $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH, SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_UNWILLING]]);
//        $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
//        $dataProvider->query->andWhere(['srlm_bc_application.already_certified' => 0]);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModel->center_option = \bc\modules\selection\models\base\GenralModel::center_option($searchModel);
        $searchModel->training_option = \bc\modules\selection\models\base\GenralModel::training_option($searchModel);
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])) {
            $searchModel->training_status_option = ['3' => 'Certified', '31' => 'Already certified']; //\yii\helpers\ArrayHelper::map(\bc\modules\training\models\RsetisTrainingStatus::find()->where(['status' => 1, 'id' => [3, 7]])->all(), 'id', 'status_eng');
        } else {
            $searchModel->training_status_option = ['2' => 'Registered', '3' => 'Certified', '31' => 'Already certified', '4' => 'Not Certified', '5' => 'ineligible', '6' => 'Absent']; //\yii\helpers\ArrayHelper::map(\bc\modules\training\models\RsetisTrainingStatus::find()->where(['status' => 1])->all(), 'id', 'status_eng');
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        $searchModel->gp_member_option = \yii\helpers\ArrayHelper::map(\bc\modules\selection\models\master\BcApplicationMasterAlreadyGroupMember::find()->andWhere(['status' => 1])->all(), 'id', 'name_eng');
        $searchModel1 = new RsetisBatchParticipantsSearch();
        $searchModel1->show_blocked = 0;
        if (Yii::$app->request->isGet)
            $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (Yii::$app->request->isPost)
            $dataProvider1 = $searchModel1->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider1->query->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH, SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_UNWILLING]]);
//        $dataProvider1->query->andWhere(['srlm_bc_application.blocked' => 0]);
//        $dataProvider1->query->andWhere(['srlm_bc_application.already_certified' => 0]);
        $searchModel2 = new RsetisBatchParticipantsSearch();
        $searchModel2->show_blocked = 0;
        if (Yii::$app->request->isGet)
            $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (Yii::$app->request->isPost)
            $dataProvider2 = $searchModel2->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider2->query->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_UNWILLING]]);
        //$dataProvider2->query->andWhere(['srlm_bc_application.already_certified' => 0]);
//        $dataProvider2->query->andWhere(['srlm_bc_application.blocked' => 0]);
        $searchModel3 = new RsetisBatchParticipantsSearch();
        $searchModel3->show_blocked = 0;
        if (Yii::$app->request->isGet)
            $dataProvider3 = $searchModel3->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (Yii::$app->request->isPost)
            $dataProvider3 = $searchModel3->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider3->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider3->query->andWhere(['srlm_bc_application.blocked' => 0]);
        $searchModel4 = new RsetisBatchParticipantsSearch();
        $searchModel4->show_blocked = 0;
        if (Yii::$app->request->isGet)
            $dataProvider4 = $searchModel4->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (Yii::$app->request->isPost)
            $dataProvider4 = $searchModel4->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider4->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_FAIL]);
//        $dataProvider4->query->andWhere(['srlm_bc_application.blocked' => 0]);
        $searchModel5 = new RsetisBatchParticipantsSearch();
        $searchModel5->show_blocked = 0;
        if (Yii::$app->request->isGet)
            $dataProvider5 = $searchModel5->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (Yii::$app->request->isPost)
            $dataProvider5 = $searchModel5->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider5->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE]);
//        $dataProvider5->query->andWhere(['srlm_bc_application.blocked' => 0]);
        $searchModel6 = new RsetisBatchParticipantsSearch();
        $searchModel6->show_blocked = 0;
        if (Yii::$app->request->isGet)
            $dataProvider6 = $searchModel6->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (Yii::$app->request->isPost)
            $dataProvider6 = $searchModel6->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider6->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_ABSENT]);
        //$dataProvider6->query->andWhere(['srlm_bc_application.blocked' => 0]);
        $searchModel7 = new RsetisBatchParticipantsSearch();
        $searchModel7->show_blocked = 0;
        if (Yii::$app->request->isGet)
            $dataProvider7 = $searchModel7->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (Yii::$app->request->isPost)
            $dataProvider7 = $searchModel7->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider7->query->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_UNWILLING, SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING]]);
//        $dataProvider7->query->andWhere(['srlm_bc_application.blocked' => 0]);
        $searchModelbc = new \bc\modules\selection\models\form\DashboardSearchForm(\Yii::$app->request->queryParams);
        if (count($searchModelbc->district_option) == 1) {
            $searchModelbc->district_code = key($searchModelbc->district_option);
        }
        $searchModels = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $searchModels->district_code = $searchModel->district_code;
        $dataProvider1b = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);

        $dataProvider1b->query->andWhere(['=', 'form_number', '6']);
        $dataProvider1b->query->andWhere(['=', 'gender', '2']);
        $dataProvider1b->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        //$dataProvider1b->query->andWhere(['not in', 'srlm_bc_application.selection_by', [15]]);
        $dataProvider1b->query->addOrderBy("first_name asc");

        $searchModels = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $searchModels->district_code = $searchModel->district_code;
        $dataProvider1c = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);

        $dataProvider1c->query->andWhere(['=', 'form_number', '6']);
        $dataProvider1c->query->andWhere(['=', 'gender', '2']);
        $dataProvider1c->query->andWhere(['=', 'urban_shg', '0']);
        $dataProvider1c->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        //$dataProvider1c->query->andWhere(['not in', 'srlm_bc_application.selection_by', [15]]);
        $dataProvider1c->query->addOrderBy("first_name asc");
        $dataProvider1d = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);

        $dataProvider1d->query->andWhere(['=', 'form_number', '6']);
        $dataProvider1d->query->andWhere(['=', 'gender', '2']);
        $dataProvider1d->query->andWhere(['=', 'urban_shg', '0']);
        $dataProvider1d->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider1d->query->andWhere(['selection_by' => '2']);
        $dataProvider1d->query->addOrderBy("first_name asc");
        $searchModel8 = new RsetisBatchParticipantsSearch();
        $searchModel8->show_blocked = 0;
        $dataProvider8 = $searchModel8->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        $dataProvider8->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING]);
        $dataProvider8->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
        $searchModel9 = new RsetisBatchParticipantsSearch();
        $searchModel9->show_blocked = 0;
        $dataProvider9 = $searchModel9->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        $dataProvider9->query->andWhere(['=', 'srlm_bc_application.form_number', '6']);
        $dataProvider9->query->andWhere(['=', 'srlm_bc_application.gender', '2']);
        $dataProvider9->query->andWhere(['srlm_bc_application.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider9->query->andWhere(['srlm_bc_application.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider9->query->andWhere(['srlm_bc_application.blocked' => SrlmBcApplication::BLOCKED_STATUS_BC_GP]);
        $searchModelgp = new \bc\models\master\MasterGramPanchayatSearch();
        $dataProvidergp = $searchModelgp->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10'], null, \common\models\base\GenralModel::select_gp_drop_columns());

        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";
        \Yii::$app->params['title'] = '3. BCs registered by RSETI for training';
        \Yii::$app->params['class'] = 'bg-info-100';
        if ($button_type == "1") {
            \Yii::$app->params['title'] = '3. BCs registered by RSETI for training';
            \Yii::$app->params['class'] = 'bg-info-100';
            $dataProvider = $dataProvider1;
        } elseif ($button_type == "1d") {
            \Yii::$app->params['title'] = '2b.First stand-by candidates approved against unqualified BCS';
            \Yii::$app->params['class'] = 'bg-info-100';
            $dataProvider = $dataProvider1d;
        } elseif ($button_type == "2") {
            \Yii::$app->params['title'] = '4. Total BCS appeared for IIBF exam';
            \Yii::$app->params['class'] = 'bg-info-100';
            $dataProvider = $dataProvider2;
        } elseif ($button_type == "3") {
            \Yii::$app->params['title'] = '5. Total BCs certified by IIBF';
            \Yii::$app->params['class'] = 'bg-success-100';
            $dataProvider = $dataProvider3;
        } elseif ($button_type == "4") {
            \Yii::$app->params['title'] = '6. List of unqualified BCs as on Sept. 2, 2021';
            \Yii::$app->params['class'] = 'bg-danger-300';

            $dataProvider = $dataProvider4;
        } elseif ($button_type == "5") {
            \Yii::$app->params['title'] = '7.2 Ineligible';
            \Yii::$app->params['class'] = 'bg-danger-300';

            $dataProvider = $dataProvider5;
        } elseif ($button_type == "6") {
            \Yii::$app->params['title'] = '7.3 Absent in IIBF exam';
            \Yii::$app->params['class'] = 'bg-danger-300';
            $dataProvider = $dataProvider6;
        } elseif ($button_type == "7") {
            \Yii::$app->params['title'] = '7.4 Unwilling';
            \Yii::$app->params['class'] = 'bg-danger-300';
            $dataProvider = $dataProvider7;
        } elseif ($button_type == "8") {
            \Yii::$app->params['title'] = '7.5 Certified Unwilling';
            \Yii::$app->params['class'] = 'bg-danger-300';
            $dataProvider = $dataProvider8;
        } elseif ($button_type == "9") {
            \Yii::$app->params['title'] = '7.6 Certified Mismatch GP';
            \Yii::$app->params['class'] = 'bg-danger-300';
            $dataProvider = $dataProvider9;
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider1b' => $dataProvider1b,
                    'dataProvider1c' => $dataProvider1c,
                    'dataProvider1d' => $dataProvider1d,
                    'dataProvidergp' => $dataProvidergp,
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
                    'button_type' => $button_type
        ]);
    }

    public function actionMiscsv() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $searchModel = new RsetisBatchParticipantsSearch();
            if (Yii::$app->request->isGet)
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            if (Yii::$app->request->isPost)
                $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $dataProvider->query->andWhere(['srlm_bc_application.reading_skills' => [1, 2]]);
            $dataProvider->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
            $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
            if (count($searchModel->district_option) == 1) {
                $searchModel->district_code = key($searchModel->district_option);
            }
            $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";
            if ($button_type == "1") {
                \Yii::$app->params['title'] = '3. Registered';
                $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH, SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_UNWILLING]]);
                $dataProvider->query->andWhere(['srlm_bc_application.already_certified' => 0]);
            } elseif ($button_type == "2") {
                \Yii::$app->params['title'] = '4. Total Appeared';
                $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE, SrlmBcApplication::TRAINING_STATUS_ABSENT]]);
                $dataProvider->query->andWhere(['srlm_bc_application.already_certified' => 0]);
            } elseif ($button_type == "3") {
                \Yii::$app->params['title'] = '5. Certified';
                $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            } elseif ($button_type == "4") {
                \Yii::$app->params['title'] = '6. Not Certified';
                $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_FAIL]);
            } elseif ($button_type == "5") {
                $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE]);

                \Yii::$app->params['title'] = '7. Ineligible';
            } elseif ($button_type == "6") {
                \Yii::$app->params['title'] = '8. Absent';
                $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_ABSENT]);
            } elseif ($button_type == "7") {
                \Yii::$app->params['title'] = '8. Unwilling';
                $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_UNWILLING]);
            } else {
                $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH, SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE, SrlmBcApplication::TRAINING_STATUS_ABSENT]]);
                $dataProvider->query->andWhere(['srlm_bc_application.already_certified' => 0]);
            }

            $file = "mis_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Application No', 'BC Name', 'OTP Verified Mobile No.', 'Mobile No.', 'BC District', 'BC Block', 'BC GP', 'Training Status', 'Exam Appeared', 'Certified by IIBF', 'IIBF membership No.', 'Upload PVR'));
            $sr_no = 1;
            $row = [];
            $dataProvider->query->select(['rsetis_batch_participants.id', 'rsetis_batch_participants.first_name', 'bc_application_id']);

            $dataProvider->query->asArray();
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $model = RsetisBatchParticipants::findOne($model['id']);

                $row = [
                    $sr_no,
                    $model->participant->application_id,
                    trim($model->name),
                    $model->otp_mobile_no,
                    $model->mobile_number,
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    strip_tags($model->trainingstatus),
                    $model->exam_score != null ? 'Yes' : '',
                    $model->exam_score >= 40 ? 'Yes' : '',
                    $model->certificate_code != null ? $model->certificate_code : '',
                    $model->participant->pvr_status == 1 ? 'Yes' : 'No',
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit();
        } catch (\Exception $ex) {
            
        }
    }

    public function actionCertified() {
        try {

            $user_model = Yii::$app->user->identity;
            $searchModel = new RsetisBatchParticipantsSearch();
            $searchModel->show_blocked = 0;
            if (empty(Yii::$app->request->queryParams)) {
                $searchModel->training_status = SrlmBcApplication::TRAINING_STATUS_PASS;
            }
            if (Yii::$app->request->isGet) {
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            }
            if (Yii::$app->request->isPost) {
                $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            }
//            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN])) {
//                $searchModel->pendency_option = ['pvr' => 'PVR', 'bc_shg_assigned' => 'BC-SHG assigned', 'bc_shg_bank_verified' => 'BC-SHG bank a/c verified', 'pfms_mapping' => 'PFMS mapping', 'bc_shg_support_fund' => 'BC-support fund', 'handheld_machine' => 'Handheld machine provided', 'operational' => 'Operational'];
//            } else if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])) {
//                $searchModel->pendency_option = ['handheld_machine' => 'Handheld machine provided', 'operational' => 'Operational']; //\yii\helpers\ArrayHelper::map(\bc\modules\training\models\RsetisTrainingStatus::find()->where(['status' => 1, 'id' => [3, 7]])->all(), 'id', 'status_eng');
//            } else {
//                $searchModel->pendency_option = ['pvr' => 'PVR', 'bc_shg_assigned' => 'BC-SHG assigned', 'bc_shg_bank_verified' => 'BC-SHG bank a/c verified', 'pfms_mapping' => 'PFMS mapping', 'bc_shg_support_fund' => 'BC-support fund']; //\yii\helpers\ArrayHelper::map(\bc\modules\training\models\RsetisTrainingStatus::find()->where(['status' => 1])->all(), 'id', 'status_eng');
//            }
            $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dataProvider->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
            $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
            if ($searchModel->bc_operational != '') {
                 $dataProvider->query->andWhere(['srlm_bc_application.bc_operational' => $searchModel->bc_operational]);
//                if ($user_model->master_partner_bank_id == \bc\models\master\MasterPartnerBank::SBI) {
//                    if($searchModel->bc_operational==1){
//                        
//                    }
//                    
//                } else {
//                    $dataProvider->query->andWhere(['srlm_bc_application.bc_operational' => $searchModel->bc_operational]);
//                }
            }
            if ($searchModel->ptm_device != '') {
                $dataProvider->query->andWhere(['srlm_bc_application.ptm_device' => $searchModel->ptm_device]);
            }
            $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
            if (count($searchModel->district_option) == 1) {
                $searchModel->district_code = key($searchModel->district_option);
            }
            if ($searchModel->district_code) {
                $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
            }
            if ($searchModel->block_code) {
                $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
            }
            $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
            $searchModel->training_status_option = ['3' => 'Certified', '31' => 'Already certified']; //\yii\helpers\ArrayHelper::map(\bc\modules\training\models\RsetisTrainingStatus::find()->where(['status' => 1, 'id' => [3, 7]])->all(), 'id', 'status_eng');
            $rseth_bank_query = \common\models\dynamicdb\bc\User::find()->joinWith(['profile', 'districts'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_RSETIS_DISTRICT_UNIT, 'user.status' => 10]);
            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $rseth_bank_query->andWhere(['relation_user_district.district_code' => \yii\helpers\ArrayHelper::getColumn(Yii::$app->user->identity->districts, 'district_code')]);
            }
            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $rseth_bank_query->andWhere(['user.id' => Yii::$app->user->identity->id]);
            }
            $rseth_bank = $rseth_bank_query->orderBy('bank_name asc')->all();
            $partner_bank_query = \common\models\dynamicdb\bc\User::find()->select(['user.id', 'user.name'])->joinWith(['profile', 'districts'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, 'user.status' => 10]);
            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $partner_bank_query->andWhere(['relation_user_district.district_code' => \yii\helpers\ArrayHelper::getColumn(Yii::$app->user->identity->districts, 'district_code')]);
            }
            if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $partner_bank_query->andWhere(['user.id' => Yii::$app->user->identity->id]);
            }
            $partner_bank_bank = $partner_bank_query->orderBy('name asc')->all();
            $searchModel->rseti_bank_option = \yii\helpers\ArrayHelper::map($rseth_bank, 'profile.bank_name', 'profile.bank_name');
            $searchModel->bc_partner_bank_option = \yii\helpers\ArrayHelper::map($partner_bank_bank, 'id', 'name');
            $searchModel->gp_member_option = \yii\helpers\ArrayHelper::map(\bc\modules\selection\models\master\BcApplicationMasterAlreadyGroupMember::find()->andWhere(['status' => 1])->all(), 'id', 'name_eng');
            return $this->render('certified', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function actionPaytm() {


        $searchModel = new RsetisBatchParticipantsSearch();
        $searchModel->show_blocked = 0;
        if (empty(Yii::$app->request->queryParams)) {
            $searchModel->training_status = SrlmBcApplication::TRAINING_STATUS_PASS;
        }
        if (Yii::$app->request->isGet) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        }
        if (Yii::$app->request->isPost) {
            $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        }
        $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
        $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
        $dataProvider->query->andWhere(['>', 'srlm_bc_application.ptm_device', 0]);
        if ($searchModel->bc_operational != '') {
            $dataProvider->query->andWhere(['srlm_bc_application.bc_operational' => $searchModel->bc_operational]);
        }
        if ($searchModel->ptm_device != '') {
            $dataProvider->query->andWhere(['srlm_bc_application.ptm_device' => $searchModel->ptm_device]);
        }
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->training_status_option = ['3' => 'Certified', '31' => 'Already certified']; //\yii\helpers\ArrayHelper::map(\bc\modules\training\models\RsetisTrainingStatus::find()->where(['status' => 1, 'id' => [3, 7]])->all(), 'id', 'status_eng');
        $rseth_bank_query = \common\models\dynamicdb\bc\User::find()->joinWith(['profile', 'districts'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_RSETIS_DISTRICT_UNIT, 'user.status' => 10]);
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK])) {
            $rseth_bank_query->andWhere(['relation_user_district.district_code' => \yii\helpers\ArrayHelper::getColumn(Yii::$app->user->identity->districts, 'district_code')]);
        }
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
            $rseth_bank_query->andWhere(['user.id' => Yii::$app->user->identity->id]);
        }
        $rseth_bank = $rseth_bank_query->orderBy('bank_name asc')->all();
        $partner_bank_query = \common\models\dynamicdb\bc\User::find()->select(['user.id', 'user.name'])->joinWith(['profile', 'districts'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, 'user.status' => 10]);
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK])) {
            $partner_bank_query->andWhere(['relation_user_district.district_code' => \yii\helpers\ArrayHelper::getColumn(Yii::$app->user->identity->districts, 'district_code')]);
        }
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            $partner_bank_query->andWhere(['user.id' => Yii::$app->user->identity->id]);
        }
        $partner_bank_bank = $partner_bank_query->orderBy('name asc')->all();
        $searchModel->rseti_bank_option = \yii\helpers\ArrayHelper::map($rseth_bank, 'profile.bank_name', 'profile.bank_name');
        $searchModel->bc_partner_bank_option = \yii\helpers\ArrayHelper::map($partner_bank_bank, 'id', 'name');
        $searchModel->gp_member_option = \yii\helpers\ArrayHelper::map(\bc\modules\selection\models\master\BcApplicationMasterAlreadyGroupMember::find()->andWhere(['status' => 1])->all(), 'id', 'name_eng');
        return $this->render('paytm', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBcpfmsmapping() {
        try {


            $searchModel = new RsetisBatchParticipantsSearch();
            $searchModel->show_blocked = 0;
            if (empty(Yii::$app->request->queryParams)) {
                $searchModel->training_status = SrlmBcApplication::TRAINING_STATUS_PASS;
            }
            if (Yii::$app->request->isGet) {
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            }
            if (Yii::$app->request->isPost) {
                $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            }
            $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dataProvider->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
            $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
            if (count($searchModel->district_option) == 1) {
                $searchModel->district_code = key($searchModel->district_option);
            }
            if ($searchModel->district_code) {
                $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
            }
            if ($searchModel->block_code) {
                $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
            }

            $searchModel->training_status_option = ['3' => 'Certified', '31' => 'Already certified']; //\yii\helpers\ArrayHelper::map(\bc\modules\training\models\RsetisTrainingStatus::find()->where(['status' => 1, 'id' => [3, 7]])->all(), 'id', 'status_eng');

            $searchModel->gp_member_option = \yii\helpers\ArrayHelper::map(\bc\modules\selection\models\master\BcApplicationMasterAlreadyGroupMember::find()->andWhere(['status' => 1])->all(), 'id', 'name_eng');
            return $this->render('bcpfmsmapping', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function actionVerification() {
        $searchModel = new RsetisBatchParticipantsSearch();
        $searchModel->show_blocked = 0;
        if (Yii::$app->request->isGet)
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (Yii::$app->request->isPost)
            $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
        //$dataProvider->query->andWhere(['srlm_bc_application.already_certified'=>0]);
        $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }

        $searchModel->training_status_option = ['3' => 'Certified', '31' => 'Already certified', '7' => 'Onboarding']; //\yii\helpers\ArrayHelper::map(\bc\modules\training\models\RsetisTrainingStatus::find()->where(['status' => 1, 'id' => [3, 7]])->all(), 'id', 'status_eng');
        $rseth_bank_query = \common\models\dynamicdb\bc\User::find()->joinWith(['profile', 'districts'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_RSETIS_DISTRICT_UNIT, 'user.status' => 10]);
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK])) {
            $rseth_bank_query->andWhere(['relation_user_district.district_code' => \yii\helpers\ArrayHelper::getColumn(Yii::$app->user->identity->districts, 'district_code')]);
        }
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
            $rseth_bank_query->andWhere(['user.id' => Yii::$app->user->identity->id]);
        }
        $rseth_bank = $rseth_bank_query->orderBy('bank_name asc')->all();
        $partner_bank_query = \common\models\dynamicdb\bc\User::find()->select(['user.id', 'user.name'])->joinWith(['profile', 'districts'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, 'user.status' => 10]);
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK])) {
            $partner_bank_query->andWhere(['relation_user_district.district_code' => \yii\helpers\ArrayHelper::getColumn(Yii::$app->user->identity->districts, 'district_code')]);
        }
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            $partner_bank_query->andWhere(['user.id' => Yii::$app->user->identity->id]);
        }
        $partner_bank_bank = $partner_bank_query->orderBy('name asc')->all();
        $searchModel->rseti_bank_option = \yii\helpers\ArrayHelper::map($rseth_bank, 'profile.bank_name', 'profile.bank_name');
        $searchModel->bc_partner_bank_option = \yii\helpers\ArrayHelper::map($partner_bank_bank, 'id', 'name');
        $searchModel->gp_member_option = \yii\helpers\ArrayHelper::map(\bc\modules\selection\models\master\BcApplicationMasterAlreadyGroupMember::find()->andWhere(['status' => 1])->all(), 'id', 'name_eng');
        return $this->render('verification', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionVerificationcsv() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $searchModel = new RsetisBatchParticipantsSearch();
            if (Yii::$app->request->isGet)
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            if (Yii::$app->request->isPost)
                $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);

            $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dataProvider->query->andWhere(['srlm_bc_application.reading_skills' => [1, 2]]);
            $dataProvider->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
            $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
            if (count($searchModel->district_option) == 1) {
                $searchModel->district_code = key($searchModel->district_option);
            }
            $file = "verification_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array(
                'Sr No',
                'Application No',
                'BC Name',
                'OTP Verified Mobile No.',
                'Mobile No.',
                'BC District',
                'BC Block',
                'BC GP',
                'Certified Date',
                'BC Passbook image',
                'BC Sakhi Bank Details',
                'BC SHG Name as per application',
                'UPSRLM SHG Name',
                'SHG Passbook image',
                'BC Sakhi Self Help Group Bank Details',
                'BC-SHG payment status'));
            $sr_no = 1;
            $row = [];
            $dataProvider->query->select(['rsetis_batch_participants.id', 'rsetis_batch_participants.first_name', 'bc_application_id']);

            $dataProvider->query->asArray();
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $model = RsetisBatchParticipants::findOne($model['id']);
                $shg = \cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                $pfms = 'No';
                if ($model->participant->pfms_maped_status == 1) {
                    $pfms = 'Yes';
                }

                $bc_shg_funds_status = 'No';
                if ($model->participant->bc_shg_funds_status == 1) {
                    $bc_shg_funds_status = 'Yes';
                }
                if ($model->participant->bc_shg_funds_status == 0) {
                    $bc_shg_funds_status = 'No';
                }


                $row = [
                    $sr_no,
                    $model->participant->application_id,
                    trim($model->name),
                    $model->otp_mobile_no,
                    $model->mobile_number,
                    $model->district_name,
                    $model->block_name,
                    str_replace(',', ' ', $model->gram_panchayat_name),
                    \Yii::$app->formatter->asDatetime($model->participant->iibf_date, "php:Y-m-d"),
                    $model->participant->passbook_photo != null ? 'Yes' : 'No',
                    strip_tags($model->participant->bcbanks),
                    isset($model->participant->your_group_name) ? $model->participant->your_group_name : '',
                    isset($shg) ? $shg->name_of_shg : '',
                    $model->participant->passbook_photo_shg != null ? 'Yes' : 'No',
                    strip_tags($model->participant->shgbanks),
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit();
        } catch (\Exception $ex) {
            
        }
    }

    public function actionDownload1() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $searchModel = new RsetisBatchParticipantsSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dataProvider->query->andWhere(['srlm_bc_application.reading_skills' => [1, 2]]);
            $dataProvider->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
            $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
            if (count($searchModel->district_option) == 1) {
                $searchModel->district_code = key($searchModel->district_option);
            }
            $file = "bc_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'BC Name', 'OTP Verified Mobile No.', 'Mobile No.', 'Banking Partner', 'BC District', 'BC Block', 'BC GP', 'BC bank a/c', 'BC Sakhi Bank Details', 'UPSRLM SHG Name', 'SHG bank a/c', 'BC Sakhi Self Help Group Bank Details', 'Beneficiaries code', 'PVR UPLOADING STATUS', 'Acknowledge support funds received', 'Acknowledge handheld machine received'));
            $sr_no = 1;
            $row = [];
            $dataProvider->query->asArray();
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $model = RsetisBatchParticipants::findOne($model['id']);
                $shg = \cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                $pfms = 'No';
                if ($model->participant->pfms_maped_status == 1) {
                    $pfms = 'Yes';
                }

                $bc_shg_funds_status = 'No';
                if ($model->participant->bc_shg_funds_status == 1) {
                    $bc_shg_funds_status = 'Yes';
                }
                if ($model->participant->bc_shg_funds_status == 0) {
                    $bc_shg_funds_status = 'No';
                }


                $row = [
                    $sr_no,
                    $model->participant->application_id,
                    trim($model->name),
                    $model->otp_mobile_no,
                    $model->mobile_number,
                    (isset($model->participant->pbank)) ? $model->participant->pbank->bank_name : '',
                    $model->district_name,
                    $model->block_name,
                    str_replace(',', ' ', $model->gram_panchayat_name),
                    $model->participant->passbook_photo != null ? 'Yes' : 'No',
                    strip_tags($model->participant->bcbanks),
                    isset($shg) ? $shg->name_of_shg : '',
                    $model->participant->passbook_photo_shg != null ? 'Yes' : 'No',
                    strip_tags($model->participant->shgbanks),
                    $model->participant->pfms_maped_status == 1 ? 'Yes' : 'No',
                    $model->participant->pvr_status == 1 ? 'Yes' : 'No',
                    $model->participant->bc_support_funds_received == 1 ? 'Yes' : 'No',
                    $model->participant->bc_handheld_machine_recived == 1 ? 'Yes' : 'No'
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit();
        } catch (\Exception $ex) {
            
        }
    }

    public function actionDownloadpendency() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $params = [];
            if (Yii::$app->request->isGet) {
                $params = Yii::$app->request->queryParams;
            }
            if (Yii::$app->request->isPost) {
                $params = Yii::$app->request->post();
            }
            $searchModel = new RsetisBatchParticipantsSearch();

            $dataProvider = $searchModel->search($params, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dataProvider->query->andWhere(['srlm_bc_application.reading_skills' => [1, 2]]);
            $dataProvider->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
            $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
            if (!$searchModel->pendency) {
                $dataProvider->query->andWhere(['srlm_bc_application.training_status' => -11]);
            }
            if (count($searchModel->district_option) == 1) {
                $searchModel->district_code = key($searchModel->district_option);
            }
            $file = "pendency_" . $searchModel->pendency . '_' . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            if ($searchModel->pendency == 'bc_shg_bank_verified') {
                fputcsv($output, array(
                    'Sr No',
                    'Application No',
                    'BC Name',
                    'OTP Verified Mobile No.',
                    'Mobile No.',
                    'Banking Partner',
                    'BC District',
                    'BC Block',
                    'BC GP',
                    'Certified Date',
                    'BC bank a/c',
                    'BC Sakhi Bank Details',
                    'UPSRLM SHG Name',
                    'SHG bank a/c',
                    'BC Sakhi Self Help Group Bank Details',
                ));
                $sr_no = 1;
                $row = [];
                $dataProvider->query->asArray();
                $dataProvider->pagination = false;
                $models = $dataProvider->getModels();
                foreach ($models as $model) {
                    $model = RsetisBatchParticipants::findOne($model['id']);
                    $shg = \cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                    $pfms = 'No';
                    if ($model->participant->pfms_maped_status == 1) {
                        $pfms = 'Yes';
                    }

                    $bc_shg_funds_status = 'No';
                    if ($model->participant->bc_shg_funds_status == 1) {
                        $bc_shg_funds_status = 'Yes';
                    }
                    if ($model->participant->bc_shg_funds_status == 0) {
                        $bc_shg_funds_status = 'No';
                    }


                    $row = [
                        $sr_no,
                        $model->participant->application_id,
                        trim($model->name),
                        $model->otp_mobile_no,
                        $model->mobile_number,
                        (isset($model->participant->pbank)) ? $model->participant->pbank->bank_name : '',
                        $model->district_name,
                        $model->block_name,
                        str_replace(',', ' ', $model->gram_panchayat_name),
                        \Yii::$app->formatter->asDatetime($model->participant->iibf_date, "php:Y-m-d"),
                        $model->participant->passbook_photo != null ? 'Yes' : 'No',
                        strip_tags($model->participant->bcbanks),
                        isset($shg) ? $shg->name_of_shg : '',
                        $model->participant->passbook_photo_shg != null ? 'Yes' : 'No',
                        strip_tags($model->participant->shgbanks)
                    ];
                    fputcsv($output, $row);
                    $sr_no++;
                }
            }
            if ($searchModel->pendency == 'bc_shg_assigned') {
                fputcsv($output, array(
                    'Sr No',
                    'Application No',
                    'BC Name',
                    'OTP Verified Mobile No.',
                    'Mobile No.',
                    'Banking Partner',
                    'BC District',
                    'BC Block',
                    'BC GP',
                    'Certified Date',
                    'UPSRLM SHG Name',
                ));
                $sr_no = 1;
                $row = [];
                $dataProvider->query->asArray();
                $dataProvider->pagination = false;
                $models = $dataProvider->getModels();
                foreach ($models as $model) {
                    $model = RsetisBatchParticipants::findOne($model['id']);
                    $shg = \cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                    $pfms = 'No';
                    if ($model->participant->pfms_maped_status == 1) {
                        $pfms = 'Yes';
                    }

                    $bc_shg_funds_status = 'No';
                    if ($model->participant->bc_shg_funds_status == 1) {
                        $bc_shg_funds_status = 'Yes';
                    }
                    if ($model->participant->bc_shg_funds_status == 0) {
                        $bc_shg_funds_status = 'No';
                    }


                    $row = [
                        $sr_no,
                        $model->participant->application_id,
                        trim($model->name),
                        $model->otp_mobile_no,
                        $model->mobile_number,
                        (isset($model->participant->pbank)) ? $model->participant->pbank->bank_name : '',
                        $model->district_name,
                        $model->block_name,
                        str_replace(',', ' ', $model->gram_panchayat_name),
                        \Yii::$app->formatter->asDatetime($model->participant->iibf_date, "php:Y-m-d"),
                        isset($shg) ? $shg->name_of_shg : '',
                    ];
                    fputcsv($output, $row);
                    $sr_no++;
                }
            }
            if ($searchModel->pendency == 'pvr') {
                fputcsv($output, array(
                    'Sr No',
                    'Application No',
                    'BC Name',
                    'OTP Verified Mobile No.',
                    'Mobile No.',
                    'Banking Partner',
                    'BC District',
                    'BC Block',
                    'BC GP',
                    'Certified Date',
                    'Upload PVR status',
                ));
                $sr_no = 1;
                $row = [];
                $dataProvider->query->asArray();
                $dataProvider->pagination = false;
                $models = $dataProvider->getModels();
                foreach ($models as $model) {
                    $model = RsetisBatchParticipants::findOne($model['id']);
                    $shg = \cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                    $pfms = 'No';
                    if ($model->participant->pfms_maped_status == 1) {
                        $pfms = 'Yes';
                    }

                    $bc_shg_funds_status = 'No';
                    if ($model->participant->bc_shg_funds_status == 1) {
                        $bc_shg_funds_status = 'Yes';
                    }
                    if ($model->participant->bc_shg_funds_status == 0) {
                        $bc_shg_funds_status = 'No';
                    }


                    $row = [
                        $sr_no,
                        $model->participant->application_id,
                        trim($model->name),
                        $model->otp_mobile_no,
                        $model->mobile_number,
                        (isset($model->participant->pbank)) ? $model->participant->pbank->bank_name : '',
                        $model->district_name,
                        $model->block_name,
                        str_replace(',', ' ', $model->gram_panchayat_name),
                        \Yii::$app->formatter->asDatetime($model->participant->iibf_date, "php:Y-m-d"),
                        $model->participant->pvr_status == 1 ? 'Yes' : 'No',
                    ];
                    fputcsv($output, $row);
                    $sr_no++;
                }
            }
            if ($searchModel->pendency == 'bc_shg_support_fund') {
                fputcsv($output, array(
                    'Sr No',
                    'Application No',
                    'BC Name',
                    'OTP Verified Mobile No.',
                    'Mobile No.',
                    'Banking Partner',
                    'BC District',
                    'BC Block',
                    'BC GP',
                    'Certified Date',
                    'BC bank a/c',
                    'BC Sakhi Bank Details',
                    'UPSRLM SHG Name',
                    'SHG bank a/c',
                    'BC Sakhi Self Help Group Bank Details',
                    'PFMS STATUS',
                    'BC-SHG payment status',
                    'Upload PVR status',
                    'Acknowledge support funds received',
                    'Acknowledge handheld machine received'
                ));
                $sr_no = 1;
                $row = [];
                $dataProvider->query->asArray();
                $dataProvider->pagination = false;
                $models = $dataProvider->getModels();
                foreach ($models as $model) {
                    $model = RsetisBatchParticipants::findOne($model['id']);
                    $shg = \cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                    $pfms = 'No';
                    if ($model->participant->pfms_maped_status == 1) {
                        $pfms = 'Yes';
                    }

                    $bc_shg_funds_status = 'No';
                    if ($model->participant->bc_shg_funds_status == 1) {
                        $bc_shg_funds_status = 'Yes';
                    }
                    if ($model->participant->bc_shg_funds_status == 0) {
                        $bc_shg_funds_status = 'No';
                    }


                    $row = [
                        $sr_no,
                        $model->participant->application_id,
                        trim($model->name),
                        $model->otp_mobile_no,
                        $model->mobile_number,
                        (isset($model->participant->pbank)) ? $model->participant->pbank->bank_name : '',
                        $model->district_name,
                        $model->block_name,
                        str_replace(',', ' ', $model->gram_panchayat_name),
                        \Yii::$app->formatter->asDatetime($model->participant->iibf_date, "php:Y-m-d"),
                        $model->participant->passbook_photo != null ? 'Yes' : 'No',
                        strip_tags($model->participant->bcbanks),
                        isset($shg) ? $shg->name_of_shg : '',
                        $model->participant->passbook_photo_shg != null ? 'Yes' : 'No',
                        strip_tags($model->participant->shgbanks),
                        $model->participant->pfms_maped_status == 1 ? 'Yes' : 'No',
                        $bc_shg_funds_status,
                        $model->participant->pvr_status == 1 ? 'Yes' : 'No',
                        $model->participant->bc_support_funds_received == 1 ? 'Yes' : 'No',
                        $model->participant->bc_handheld_machine_recived == 1 ? 'Yes' : 'No'
                    ];
                    fputcsv($output, $row);
                    $sr_no++;
                }
            }
            if ($searchModel->pendency == 'pfms_mapping') {
                fputcsv($output, array(
                    'Sr No',
                    'Application No',
                    'BC Name',
                    'OTP Verified Mobile No.',
                    'Mobile No.',
                    'Banking Partner',
                    'BC District',
                    'BC Block',
                    'BC GP',
                    'Certified Date',
                    'PFMS STATUS'
                ));
                $sr_no = 1;
                $row = [];
                $dataProvider->query->asArray();
                $dataProvider->pagination = false;
                $models = $dataProvider->getModels();
                foreach ($models as $model) {
                    $model = RsetisBatchParticipants::findOne($model['id']);
                    $shg = \cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                    $pfms = 'No';
                    if ($model->participant->pfms_maped_status == 1) {
                        $pfms = 'Yes';
                    }

                    $bc_shg_funds_status = 'No';
                    if ($model->participant->bc_shg_funds_status == 1) {
                        $bc_shg_funds_status = 'Yes';
                    }
                    if ($model->participant->bc_shg_funds_status == 0) {
                        $bc_shg_funds_status = 'No';
                    }


                    $row = [
                        $sr_no,
                        $model->participant->application_id,
                        trim($model->name),
                        $model->otp_mobile_no,
                        $model->mobile_number,
                        (isset($model->participant->pbank)) ? $model->participant->pbank->bank_name : '',
                        $model->district_name,
                        $model->block_name,
                        str_replace(',', ' ', $model->gram_panchayat_name),
                        \Yii::$app->formatter->asDatetime($model->participant->iibf_date, "php:Y-m-d"),
                        $model->participant->pfms_maped_status == 1 ? 'Yes' : 'No',
                    ];
                    fputcsv($output, $row);
                    $sr_no++;
                }
            }
            if ($searchModel->pendency == 'handheld_machine') {
                fputcsv($output, array(
                    'Sr No',
                    'Application No',
                    'BC Name',
                    'OTP Verified Mobile No.',
                    'Mobile No.',
                    'Banking Partner',
                    'BC District',
                    'BC Block',
                    'BC GP',
                    'Certified Date',
                    'Handheld Machine provided',
                    'Acknowledge support funds received',
                    'Acknowledge handheld machine received'
                ));
                $sr_no = 1;
                $row = [];
                $dataProvider->query->asArray();
                $dataProvider->pagination = false;
                $models = $dataProvider->getModels();
                foreach ($models as $model) {
                    $model = RsetisBatchParticipants::findOne($model['id']);
                    $shg = \cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                    $pfms = 'No';
                    if ($model->participant->pfms_maped_status == 1) {
                        $pfms = 'Yes';
                    }

                    $bc_shg_funds_status = 'No';
                    if ($model->participant->bc_shg_funds_status == 1) {
                        $bc_shg_funds_status = 'Yes';
                    }
                    if ($model->participant->bc_shg_funds_status == 0) {
                        $bc_shg_funds_status = 'No';
                    }


                    $row = [
                        $sr_no,
                        $model->participant->application_id,
                        trim($model->name),
                        $model->otp_mobile_no,
                        $model->mobile_number,
                        (isset($model->participant->pbank)) ? $model->participant->pbank->bank_name : '',
                        $model->district_name,
                        $model->block_name,
                        str_replace(',', ' ', $model->gram_panchayat_name),
                        \Yii::$app->formatter->asDatetime($model->participant->iibf_date, "php:Y-m-d"),
                        $model->participant->handheld_machine_status == 1 ? 'Yes' : 'No',
                        $model->participant->bc_support_funds_received == 1 ? 'Yes' : 'No',
                        $model->participant->bc_handheld_machine_recived == 1 ? 'Yes' : 'No'
                    ];
                    fputcsv($output, $row);
                    $sr_no++;
                }
            }
            if ($searchModel->pendency == 'operational') {
                fputcsv($output, array(
                    'Sr No',
                    'Application No',
                    'BC Name',
                    'OTP Verified Mobile No.',
                    'Mobile No.',
                    'Banking Partner',
                    'BC District',
                    'BC Block',
                    'BC GP',
                    'Certified Date',
                    'PFMS STATUS',
                    'BC-SHG payment status',
                    'Upload PVR status',
                    'Handheld Machine provided',
                    'BC Operational'
                ));
                $sr_no = 1;
                $row = [];
                $dataProvider->query->asArray();
                $dataProvider->pagination = false;
                $models = $dataProvider->getModels();
                foreach ($models as $model) {
                    $model = RsetisBatchParticipants::findOne($model['id']);
                    $shg = \cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                    $pfms = 'No';
                    if ($model->participant->pfms_maped_status == 1) {
                        $pfms = 'Yes';
                    }

                    $bc_shg_funds_status = 'No';
                    if ($model->participant->bc_shg_funds_status == 1) {
                        $bc_shg_funds_status = 'Yes';
                    }
                    if ($model->participant->bc_shg_funds_status == 0) {
                        $bc_shg_funds_status = 'No';
                    }


                    $row = [
                        $sr_no,
                        $model->participant->application_id,
                        trim($model->name),
                        $model->otp_mobile_no,
                        $model->mobile_number,
                        (isset($model->participant->pbank)) ? $model->participant->pbank->bank_name : '',
                        $model->district_name,
                        $model->block_name,
                        str_replace(',', ' ', $model->gram_panchayat_name),
                        \Yii::$app->formatter->asDatetime($model->participant->iibf_date, "php:Y-m-d"),
                        $model->participant->pfms_maped_status == 1 ? 'Yes' : 'No',
                        $bc_shg_funds_status,
                        $model->participant->pvr_status == 1 ? 'Yes' : 'No',
                        $model->participant->handheld_machine_status == 1 ? 'Yes' : 'No',
                        $model->participant->bc_operational == 1 ? 'Yes' : 'No'
                    ];
                    fputcsv($output, $row);
                    $sr_no++;
                }
            }
            exit();
        } catch (\Exception $ex) {
            
        }
    }

    public function actionPfmspayment() {
        $searchModel = new RsetisBatchParticipantsSearch();
        $searchModel->show_blocked = 0;
        //$searchModel->training_status = SrlmBcApplication::TRAINING_STATUS_PASS;
        //$searchModel->bc_bank = 1;
        if (Yii::$app->request->isGet)
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (Yii::$app->request->isPost)
            $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
        //$dataProvider->query->andWhere(['srlm_bc_application.already_certified'=>0]);
        $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }

        $searchModel->training_status_option = ['3' => 'Certified', '31' => 'Already certified', '7' => 'Onboarding']; //\yii\helpers\ArrayHelper::map(\bc\modules\training\models\RsetisTrainingStatus::find()->where(['status' => 1, 'id' => [3, 7]])->all(), 'id', 'status_eng');

        $searchModel->gp_member_option = \yii\helpers\ArrayHelper::map(\bc\modules\selection\models\master\BcApplicationMasterAlreadyGroupMember::find()->andWhere(['status' => 1])->all(), 'id', 'name_eng');
        return $this->render('pfmspayment', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPfmspaymentcsv() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $searchModel = new RsetisBatchParticipantsSearch();
            if (Yii::$app->request->isGet)
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            if (Yii::$app->request->isPost)
                $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dataProvider->query->andWhere(['srlm_bc_application.reading_skills' => [1, 2]]);
            $dataProvider->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
            $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
            if (count($searchModel->district_option) == 1) {
                $searchModel->district_code = key($searchModel->district_option);
            }
            $file = "PFMS_and_payment" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'BC Name', 'OTP Verified Mobile No.', 'Mobile No.', 'BC District', 'BC Block', 'BC GP', 'BC bank a/c', 'BC Sakhi Bank Details', 'UPSRLM SHG Name', 'SHG bank a/c', 'BC Sakhi Self Help Group Bank Details', 'Beneficiaries code', 'BC-SHG payment status', 'BC SAKHI PFMS CODE'));
            $sr_no = 1;
            $row = [];
            $dataProvider->query->select(['rsetis_batch_participants.id', 'rsetis_batch_participants.first_name', 'bc_application_id']);

            $dataProvider->query->asArray();
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $model = RsetisBatchParticipants::findOne($model['id']);
                $shg = \cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                $pfms = 'No';
                if ($model->participant->pfms_maped_status == 1) {
                    $pfms = 'Yes';
                }

                $bc_shg_funds_status = 'No';
                if ($model->participant->bc_shg_funds_status == 1) {
                    $bc_shg_funds_status = 'Yes';
                }
                if ($model->participant->bc_shg_funds_status == 0) {
                    $bc_shg_funds_status = 'No';
                }


                $row = [
                    $sr_no,
                    trim($model->name),
                    $model->otp_mobile_no,
                    $model->mobile_number,
                    $model->district_name,
                    $model->block_name,
                    str_replace(',', ' ', $model->gram_panchayat_name),
                    $model->participant->bc_bank == 2 ? $model->participant->bank_account_no_of_the_bc : '',
                    strip_tags($model->participant->bcbanks),
                    isset($shg) ? $shg->name_of_shg : '',
                    $model->participant->shg_bank == 2 ? $model->participant->bank_account_no_of_the_shg : '',
                    strip_tags($model->participant->shgbanks),
                    isset($model->participant->beneficiaries_code) ? $model->participant->beneficiaries_code : '',
                    $bc_shg_funds_status,
                    isset($model->participant->bc_beneficiaries_code) ? $model->participant->bc_beneficiaries_code : ''
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit();
        } catch (\Exception $ex) {
            
        }
    }

    public function actionAssignshg($bcid) {
        $bd_model = $this->findModelbc($bcid);
        if (!in_array($bd_model->reading_skills, [1, 2])) {
            return $this->redirect(['/training/participants/verification']);
        }
        if (in_array($bd_model->urban_shg, [1])) {
            return $this->redirect(['/training/participants/verification']);
        }
        if ($bd_model->blocked != '0') {
            return $this->redirect(['/training/participants/verification']);
        }
        $model = new \bc\modules\training\models\form\BCAssignShgForm($bd_model);
        if ($model->user_model != null) {
            if ($model->user_model->role != MasterRole::ROLE_CBO_USER) {
                \Yii::$app->getSession()->setFlash('error', 'Already user created');
                return $this->redirect(['/training/participants/verification?RsetisBatchParticipantsSearch[district_code]=' . $bd_model->district_code . '&RsetisBatchParticipantsSearch[block_code]=' . $bd_model->block_code]);
            }
        }
        if ($model->load(Yii::$app->request->post()) and $model->validate()) {
            if ($model->user_model == null) {
                $model->user_model = new User();
            }
            $model->user_model->name = trim($model->bc_application_model->name);
            $model->user_model->mobile_no = $model->bc_application_model->user->mobile_no;
            $model->user_model->username = $model->bc_application_model->user->mobile_no;
            $model->user_model->role = MasterRole::ROLE_CBO_USER;
            $model->user_model->email = $model->bc_application_model->user->mobile_no . '@gmail.com';
            $model->user_model->password = $model->bc_application_model->user->mobile_no;
            $model->user_model->setPassword($model->bc_application_model->user->mobile_no);
            $model->user_model->setUpd($model->bc_application_model->user->mobile_no);
            $model->user_model->status = User::STATUS_ACTIVE;
            $model->user_model->otp_value = $model->bc_application_model->user->pin;
            $model->user_model->profile_status = 1;
            $model->user_model->login_by_otp = 2;
            $model->user_model->dummy_column = \Yii::$app->user->identity->dummy_column;
            if ($model->user_model->isNewRecord) {
                $model->user_model->action_type = 1;
            } else {
                $model->user_model->action_type = 2;
            }
            if ($model->user_model->validate() and $model->user_model->save()) {
                $model->bc_application_model->user_id = $model->user_model->id;
                $model->bc_application_model->cbo_shg_id = $model->cbo_shg_id;
                $model->bc_application_model->assign_shg_by = \Yii::$app->user->identity->id;
                $model->bc_application_model->assign_shg_datetime = new \yii\db\Expression('NOW()');
                $model->bc_application_model->action_type = SrlmBcApplication::ACTION_TYPE_ASSIGN_SHG;
                $model->bc_application_model->save();
                //$model->cbo_member_model = \common\models\CboMembers::find()->where(['cbo_type' => \common\models\CboMembers::CBO_TYPE_SHG, 'user_id' => $model->user_model->id])->one();
                $model->cbo_member_model = CboMembers::find()->where(['cbo_type' => CboMembers::CBO_TYPE_SHG, 'cbo_id' => $model->cbo_shg_id, 'user_id' => $model->user_model->id])->one();
                if ($model->cbo_member_model == null) {
                    $model->cbo_member_model = new CboMembers();
                }
                $model->cbo_member_model->user_id = $model->user_model->id;
                $model->cbo_member_model->cbo_type = CboMembers::CBO_TYPE_SHG;
                $model->cbo_member_model->cbo_id = $model->cbo_shg_id;
                $model->cbo_member_model->entry_type = CboMembers::CBO_TYPE_SHG;
                $model->cbo_member_model->status = 1;
                $model->cbo_member_model->bc_sakhi = 1;
                $model->cbo_member_model->save();
                $model->cbo_member_profile_model = CboMemberProfile::findOne(['user_id' => $model->user_model->id]);
                if ($model->cbo_member_profile_model == null) {
                    $model->cbo_member_profile_model = new CboMemberProfile();
                }

                $model->cbo_member_profile_model->user_id = $model->user_model->id;
                $model->cbo_member_profile_model->first_name = $model->bc_application_model->first_name;
                $model->cbo_member_profile_model->middle_name = $model->bc_application_model->middle_name;
                $model->cbo_member_profile_model->sur_name = $model->bc_application_model->sur_name;
                $model->cbo_member_profile_model->gender = $model->bc_application_model->gender;
                $model->cbo_member_profile_model->age = $model->bc_application_model->age;
                $model->cbo_member_profile_model->primary_phone_no = $model->bc_application_model->mobile_number;

                $model->cbo_member_profile_model->marital_status = $model->bc_application_model->marital_status;
                $model->cbo_member_profile_model->aadhaar_number = $model->bc_application_model->aadhar_number;
                $model->cbo_member_profile_model->profile_photo = $model->bc_application_model->profile_photo;
                $model->cbo_member_profile_model->photo_aadhaar_front = $model->bc_application_model->aadhar_front_photo;
                $model->cbo_member_profile_model->photo_aadhaar_back = $model->bc_application_model->aadhar_back_photo;
                $model->cbo_member_profile_model->bc = 1;
                $model->cbo_member_profile_model->shg = 1;
                $model->cbo_member_profile_model->cast = $model->bc_application_model->cast;
                $model->cbo_member_profile_model->division_code = $model->bc_application_model->division_code;
                $model->cbo_member_profile_model->division_name = $model->bc_application_model->division_name;
                $model->cbo_member_profile_model->district_code = $model->bc_application_model->district_code;
                $model->cbo_member_profile_model->district_name = $model->bc_application_model->district_name;
                $model->cbo_member_profile_model->block_code = $model->bc_application_model->block_code;
                $model->cbo_member_profile_model->block_name = $model->bc_application_model->block_name;
                $model->cbo_member_profile_model->gram_panchayat_code = $model->bc_application_model->gram_panchayat_code;
                $model->cbo_member_profile_model->gram_panchayat_name = $model->bc_application_model->gram_panchayat_name;
                $model->cbo_member_profile_model->village_code = $model->bc_application_model->village_code;
                $model->cbo_member_profile_model->village_name = $model->bc_application_model->village_name;
                $model->cbo_member_profile_model->hamlet = $model->bc_application_model->hamlet;
                $model->cbo_member_profile_model->guardian_name = $model->bc_application_model->guardian_name;
                $model->cbo_member_profile_model->otp_mobile_no = $model->bc_application_model->user->mobile_no;
                $model->cbo_member_profile_model->pvr_upload_file_name = $model->bc_application_model->pvr_upload_file_name;
                $model->cbo_member_profile_model->iibf_photo_file_name = $model->bc_application_model->iibf_photo_file_name;
                $model->cbo_member_profile_model->srlm_bc_application_id = $model->bc_application_model->id;
                $model->cbo_member_profile_model->srlm_bc_selection_user_id = $model->bc_application_model->srlm_bc_selection_user_id;
                $model->cbo_member_profile_model->bank_account_no = $model->bc_application_model->bank_account_no_of_the_bc;
                $model->cbo_member_profile_model->bank_id = $model->bc_application_model->bank_id;
                $model->cbo_member_profile_model->name_of_bank = $model->bc_application_model->name_of_bank;
                $model->cbo_member_profile_model->branch = $model->bc_application_model->branch;
                $model->cbo_member_profile_model->branch_code_or_ifsc = $model->bc_application_model->branch_code_or_ifsc;
                $model->cbo_member_profile_model->date_of_opening_the_bank_account = $model->bc_application_model->date_of_opening_the_bank_account;
                $model->cbo_member_profile_model->cin = $model->bc_application_model->cin;
                $model->cbo_member_profile_model->passbook_photo = $model->bc_application_model->passbook_photo;
                $model->cbo_member_profile_model->master_partner_bank_id = $model->bc_application_model->master_partner_bank_id;
                if ($model->cbo_member_profile_model->save()) {
                    try {
                        if ($model->bc_application_model->user_id and $model->bc_application_model->cbo_shg_id) {
                            $member_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['mobile' => $model->bc_application_model->mobile_no, 'cbo_shg_id' => $model->cbo_shg_id, 'status' => 1])->one();
                            if ($member_model != null) {
                                $member_model->verified = 1;
                                $member_model->user_id = $model->bc_application_model->user_id;
                                $member_model->bc = 1;
                                $member_model->mobile_verified = 1;
                                $member_model->save();
                            } else {
                                $member_model = new \common\models\dynamicdb\cbo_detail\RishtaShgMember();
                                $member_model->name = $model->bc_application_model->name;
                                $member_model->mobile = $model->bc_application_model->mobile_no;
                                $member_model->role = 0;
                                $member_model->cbo_shg_id = $model->bc_application_model->cbo_shg_id;
                                $member_model->age = $model->bc_application_model->age;
                                $member_model->user_id = $model->bc_application_model->user_id;
                                $member_model->source = \common\models\base\GenralModel::SHG_MEMBER_SOURCE_BC;
                                $member_model->verified = 1;
                                $member_model->mobile_verified = 1;
                                $member_model->bc = 1;
                                if ($member_model->save()) {
                                    $member_model->parent_id = $member_model->id;
                                    $member_model->save();
                                }
                            }
                        }
                        $shg_model = \cbo\models\Shg::findOne($model->cbo_shg_id);
                        $shg_model->bc_user_id = $model->user_model->id;
                        $shg_model->save();
                    } catch (\Exception $ex) {
                        
                    }

                    \Yii::$app->getSession()->setFlash('success', 'Assign SHG successfully');
                    return $this->redirect(['/training/participants/verification?RsetisBatchParticipantsSearch[district_code]=' . $model->bc_application_model->district_code . '&RsetisBatchParticipantsSearch[block_code]=' . $model->bc_application_model->block_code]);
                } else {
                    
                }
            }
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_assignshgform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_assignshgform', [
                        'model' => $model,
            ]);
        }
    }

    public function actionReturnforshg($bcid) {
        $bc_model = $this->findModelbc($bcid);
        if (!in_array($bc_model->reading_skills, [1, 2])) {
            return $this->redirect(['/training/participants/verification']);
        }
        if (in_array($bc_model->urban_shg, [1])) {
            return $this->redirect(['/training/participants/verification']);
        }
        if ($bc_model->blocked != '0') {
            return $this->redirect(['/training/participants/verification']);
        }
        $bc_model->return_for_shg = 1;
        $bc_model->return_for_shg_by = \Yii::$app->user->identity->id;
        $bc_model->return_for_shg_datetime = new \yii\db\Expression('NOW()');
        $bc_model->action_type = SrlmBcApplication::ACTION_TYPE_RETURN_SHG_TO_BMMU;
        $bc_model->save();
        return $this->redirect(['/training/participants/verification?RsetisBatchParticipantsSearch[district_code]=' . $bc_model->district_code . '&RsetisBatchParticipantsSearch[block_code]=' . $bc_model->block_code]);
    }

    public function actionDownloadcsv() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $params = [];
            if (Yii::$app->request->isGet) {
                $params = Yii::$app->request->queryParams;
            }
            if (Yii::$app->request->isPost) {
                $params = Yii::$app->request->post();
            }
            $searchModel = new RsetisBatchParticipantsSearch();
            $searchModel->show_blocked = 0;
            $searchModel->training_status = SrlmBcApplication::TRAINING_STATUS_PASS;
            $dataProvider = $searchModel->search($params, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

            $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
            if (count($searchModel->district_option) == 1) {
                $searchModel->district_code = key($searchModel->district_option);
            }
            $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
//            $dataProvider->query->andWhere(['srlm_bc_application.reading_skills' => [1, 2]]);
            $dataProvider->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
            $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dataProvider->query->select(['rsetis_batch_participants.id', 'rsetis_batch_participants.first_name', 'bc_application_id']);

            $dataProvider->pagination = false;
            $dataProvider->query->asArray();
            $models = $dataProvider->getModels();
            $file = "certified_bc_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Application No', 'Name', 'OTP Verified Mobile No.', 'Mobile No.', 'Banking Partner', 'Aadhaar Number', 'IIBF membership No.', 'IIBF certification / Training Date', 'Upload PVR Status', 'District', 'Block', 'GP', 'BC SHG', 'BC Bank Account No.', 'BC Bank Name', 'BC Branch', 'BC Branch Code Or IFSC Code', 'BC SHG PFMS status', 'BC Sakhi PFMS status', 'BC-SHG payment status', 'PAN Card available', 'Handheld Machine provided', 'Acknowledge support funds received', 'Acknowledge handheld machine received', 'Bank ID of BC', 'BC Operational'));
            $sr_no = 1;
            $row = [];
            foreach ($models as $model) {
                $model = RsetisBatchParticipants::findOne($model['id']);
//                $bt= \bc\models\transaction\BcTransactionOverallReport::findOne(['bc_application_id'=>$model->participant->id]);
                $pfms = '';
                if ($model->participant->pfms_maped_status == 1) {
                    $pfms = 'Yes';
                }
                if ($model->participant->pfms_maped_status == 0) {
                    $pfms = 'No';
                }
                $bc_shg_funds_status = '';
                if ($model->participant->bc_shg_funds_status == 1) {
                    $bc_shg_funds_status = 'Yes';
                }
                if ($model->participant->bc_shg_funds_status == 0) {
                    $bc_shg_funds_status = 'No';
                }
                $pan = '';
                if ($model->participant->pan_card_status == 1) {
                    $pan = 'Yes';
                }
                if ($model->participant->pan_card_status == 0) {
                    $pan = 'No';
                }
                $handheld_machine_status = '';
                if ($model->participant->handheld_machine_status == 1) {
                    $handheld_machine_status = 'Yes';
                }
                if ($model->participant->handheld_machine_status == 0) {
                    $handheld_machine_status = 'No';
                }
                $bcshg = 'Yes';
                if ($model->participant->already_group_member == 1) {
                    $bcshg = 'No';
                }
                $row = [
                    $sr_no,
                    $model->participant->application_id,
                    trim($model->name),
                    $model->otp_mobile_no,
                    $model->mobile_number,
                    (isset($model->participant->pbank)) ? $model->participant->pbank->bank_name : '',
                    isset($model->participant->aadhar_number) ? $model->participant->aadhar_number : '',
                    $model->certificate_code != null ? $model->certificate_code : '',
                    $model->participant->iibf_date != null ? \Yii::$app->formatter->asDatetime($model->participant->iibf_date, "php:Y-m-d") : $model->training->schedule_date_of_exam,
                    $model->participant->pvr_status == 1 ? 'Yes' : 'No',
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    $bcshg,
                    $model->participant->bc_bank == 2 ? '"' . $model->participant->bank_account_no_of_the_bc . '"' : '',
                    $model->participant->bc_bank == 2 ? $model->participant->name_of_bank : '',
                    $model->participant->bc_bank == 2 ? $model->participant->branch : '',
                    $model->participant->bc_bank == 2 ? $model->participant->branch_code_or_ifsc : '',
                    $pfms,
                    isset($model->participant->bc_beneficiaries_code) ? 'Yes' : 'No',
                    $bc_shg_funds_status,
                    $pan,
                    $handheld_machine_status,
                    $model->participant->bc_support_funds_received == 1 ? 'Yes' : 'No',
                    $model->participant->bc_handheld_machine_recived == 1 ? 'Yes' : 'No',
                    $model->participant->bankidbc != null ? $model->participant->bankidbc : '',
                    isset($model->trans) ? 'Yes' : 'No',
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

    public function actionDownloadcsv1() {
        ini_set('max_execution_time', 1200);
        //ini_set('memory_limit', '2048M');
        ini_set('memory_limit', '-1');
        try {
            $params = [];
            if (Yii::$app->request->isGet) {
                $params = Yii::$app->request->queryParams;
            }
            if (Yii::$app->request->isPost) {
                $params = Yii::$app->request->post();
            }
            $searchModel = new RsetisBatchParticipantsSearch();
            $searchModel->show_blocked = 0;
            $searchModel->training_status = SrlmBcApplication::TRAINING_STATUS_PASS;
            $dataProvider = $searchModel->search($params, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $dataProvider->query->select(['rsetis_batch_participants.id', 'rsetis_batch_participants.first_name', 'bc_application_id']);
            $dataProvider->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
            $dataProvider->pagination = false;
            $dataProvider->query->asArray();
            $models = $dataProvider->getModels();
            $file = "certified_bc_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Application No', 'Name', 'OTP Verified Mobile No.', 'Mobile No.', 'Banking Partner', 'Aadhaar Number', 'IIBF membership No.', 'Upload PVR Status', 'District', 'Block', 'GP', 'BC SHG', 'BC Bank Account No.', 'BC Bank Name', 'BC Branch', 'BC Branch Code Or IFSC Code', 'PFMS status', 'BC-SHG payment status', 'PAN Card available', 'Handheld Machine provided', 'Acknowledge support funds received', 'Acknowledge handheld machine received', 'Bank ID of BC'));
            $sr_no = 1;
            $row = [];
            foreach ($models as $model) {
                $model = RsetisBatchParticipants::findOne($model['id']);
                $pfms = '';
                if ($model->participant->pfms_maped_status == 1) {
                    $pfms = 'Yes';
                }
                if ($model->participant->pfms_maped_status == 0) {
                    $pfms = 'No';
                }
                $bc_shg_funds_status = '';
                if ($model->participant->bc_shg_funds_status == 1) {
                    $bc_shg_funds_status = 'Yes';
                }
                if ($model->participant->bc_shg_funds_status == 0) {
                    $bc_shg_funds_status = 'No';
                }
                $pan = '';
                if ($model->participant->pan_card_status == 1) {
                    $pan = 'Yes';
                }
                if ($model->participant->pan_card_status == 0) {
                    $pan = 'No';
                }
                $handheld_machine_status = '';
                if ($model->participant->handheld_machine_status == 1) {
                    $handheld_machine_status = 'Yes';
                }
                if ($model->participant->handheld_machine_status == 0) {
                    $handheld_machine_status = 'No';
                }
                $bcshg = 'Yes';
                if ($model->participant->already_group_member == 1) {
                    $bcshg = 'No';
                }
                $row = [
                    $sr_no,
                    $model->participant->application_id,
                    trim($model->name),
                    $model->otp_mobile_no,
                    $model->mobile_number,
                    (isset($model->participant->pbank)) ? $model->participant->pbank->bank_name : '',
                    isset($model->participant->aadhar_number) ? $model->participant->aadhar_number : '',
                    $model->certificate_code != null ? $model->certificate_code : '',
                    $model->participant->pvr_status == 1 ? 'Yes' : 'No',
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    $bcshg,
                    $model->participant->bc_bank == 2 ? '"' . $model->participant->bank_account_no_of_the_bc . '"' : '',
                    $model->participant->bc_bank == 2 ? $model->participant->name_of_bank : '',
                    $model->participant->bc_bank == 2 ? $model->participant->branch : '',
                    $model->participant->bc_bank == 2 ? $model->participant->branch_code_or_ifsc : '',
                    $pfms,
                    $bc_shg_funds_status,
                    $pan,
                    $handheld_machine_status,
                    $model->participant->bc_support_funds_received == 1 ? 'Yes' : 'No',
                    $model->participant->bc_handheld_machine_recived == 1 ? 'Yes' : 'No',
                    $model->participant->bankidbc != null ? $model->participant->bankidbc : ''
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

    public function actionCsvsupport() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        try {
            $params = [];
            if (Yii::$app->request->isGet) {
                $params = Yii::$app->request->queryParams;
            }
            if (Yii::$app->request->isPost) {
                $params = Yii::$app->request->post();
            }
            $searchModel = new RsetisBatchParticipantsSearch();
            $dataProvider = $searchModel->search($params, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $dataProvider->query->andWhere(['srlm_bc_application.reading_skills' => [1, 2]]);
            $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
            if (count($searchModel->district_option) == 1) {
                $searchModel->district_code = key($searchModel->district_option);
            }
            $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dataProvider->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
            $models = $dataProvider->getModels();
            $file = "certified_bc_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'id', 'Application No', 'Name of BC', 'Mobile Number', 'OTP Verified mobile no', 'District', 'District code', 'Block', 'Block code', 'Gram Panchayat', 'Gram Panchayat code', 'SHG Name', 'Office Bearers '));

            $sr_no = 1;
            $row = [];
            foreach ($models as $model) {

                $shg = \cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                $row = [
                    $sr_no,
                    $model->participant->id,
                    $model->participant->application_id,
                    $model->name,
                    $model->mobile_number,
                    $model->participant->user->mobile_no,
                    $model->district_name,
                    $model->district_code,
                    $model->block_name,
                    $model->block_code,
                    $model->gram_panchayat_name,
                    $model->gram_panchayat_code,
                    isset($shg) ? $shg->name_of_shg : '',
                    isset($model->participant->agm) ? $model->participant->agm->name_eng : '',
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

    public function actionDownloadbcbankcsv() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $params = [];
            if (Yii::$app->request->isGet) {
                $params = Yii::$app->request->queryParams;
            }
            if (Yii::$app->request->isPost) {
                $params = Yii::$app->request->post();
            }
            $searchModel = new RsetisBatchParticipantsSearch();

            $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
            if (count($searchModel->district_option) == 1) {
                $searchModel->district_code = key($searchModel->district_option);
            }
            if (isset(Yii::$app->request->queryParams['RsetisBatchParticipantsSearch'])) {
                if (isset(Yii::$app->request->queryParams['RsetisBatchParticipantsSearch']['district_code'])) {
                    $searchModel->district_code = Yii::$app->request->queryParams['RsetisBatchParticipantsSearch']['district_code'];
                }
                if (isset(Yii::$app->request->queryParams['RsetisBatchParticipantsSearch']['block_code'])) {
                    $searchModel->block_code = Yii::$app->request->queryParams['RsetisBatchParticipantsSearch']['block_code'];
                }
                if (isset(Yii::$app->request->queryParams['RsetisBatchParticipantsSearch']['gram_panchayat_code'])) {
                    $searchModel->gram_panchayat_code = Yii::$app->request->queryParams['RsetisBatchParticipantsSearch']['gram_panchayat_code'];
                }
            }

            if (isset(Yii::$app->request->post()['RsetisBatchParticipantsSearch'])) {
                if (isset(Yii::$app->request->post()['RsetisBatchParticipantsSearch']['district_code'])) {
                    $searchModel->district_code = Yii::$app->request->post()['RsetisBatchParticipantsSearch']['district_code'];
                }
                if (isset(Yii::$app->request->post()['RsetisBatchParticipantsSearch']['block_code'])) {
                    $searchModel->block_code = Yii::$app->request->post()['RsetisBatchParticipantsSearch']['block_code'];
                }
                if (isset(Yii::$app->request->post()['RsetisBatchParticipantsSearch']['gram_panchayat_code'])) {
                    $searchModel->gram_panchayat_code = Yii::$app->request->post()['RsetisBatchParticipantsSearch']['gram_panchayat_code'];
                }
            }
            $dataProvider = $searchModel->search($params, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

            $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dataProvider->query->andWhere(['and',
                ['srlm_bc_application.bc_bank' => 2],
                ['srlm_bc_application.shg_bank' => 2]
            ]);
            $dataProvider->query->andWhere(['srlm_bc_application.reading_skills' => [1, 2]]);
            $dataProvider->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
            $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);

            $file = "bc_shg_verified_bank_detail_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Application No', 'Name', 'Banking Partner', 'District', 'Block', 'GP', 'Otp Verified Mobile No', 'Mobile No', 'BC Aadhaar Number', 'BC Bank Account No.', 'BC Bank Name', 'BC Branch', 'BC Branch Code Or IFSC Code', 'Name of SHG', 'SHG Bank Account No.', 'SHG Bank Name', 'SHG Branch', 'SHG Branch Code Or IFSC Code', 'PFMS status', 'BC-SHG payment status', 'PVR UPLOADING STATUS', 'Acknowledge support funds received', 'Acknowledge handheld machine received', 'Bank ID of BC', 'BC PFMS status', 'SHG PFMS ID', 'BC SAKHI PFMS ID'));
            $sr_no = 1;
            $row = [];
            $dataProvider->query->select(['rsetis_batch_participants.id', 'rsetis_batch_participants.first_name', 'bc_application_id']);

            $dataProvider->query->asArray();
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $model = RsetisBatchParticipants::findOne($model['id']);
                $pfms = '';
                if ($model->participant->pfms_maped_status == 1) {
                    $pfms = 'Yes';
                }
                if ($model->participant->pfms_maped_status == 0) {
                    $pfms = 'No';
                }
                $bc_shg_funds_status = '';
                if ($model->participant->bc_shg_funds_status == 1) {
                    $bc_shg_funds_status = 'Yes';
                }
                if ($model->participant->bc_shg_funds_status == 0) {
                    $bc_shg_funds_status = 'No';
                }
                $shg_model = \cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                $row = [
                    $sr_no,
                    $model->participant->application_id,
                    str_replace(',', '', $model->name),
                    (isset($model->participant->pbank)) ? $model->participant->pbank->bank_name : '',
                    $model->district_name,
                    $model->block_name,
                    str_replace(',', '', $model->gram_panchayat_name),
                    $model->otp_mobile_no,
                    $model->mobile_number,
                    isset($model->participant->aadhar_number) ? $model->participant->aadhar_number : '',
                    $model->participant->bc_bank == 2 ? $model->participant->bank_account_no_of_the_bc : '',
                    $model->participant->bc_bank == 2 ? $model->participant->name_of_bank : '',
                    $model->participant->bc_bank == 2 ? str_replace(',', '', $model->participant->branch) : '',
                    $model->participant->bc_bank == 2 ? $model->participant->branch_code_or_ifsc : '',
                    $shg_model != null ? str_replace(',', '', $shg_model->name_of_shg) : '',
                    (isset($shg_model) and $model->participant->shg_bank == 2) ? '"' . $model->participant->bank_account_no_of_the_shg . '"' : '',
                    (isset($shg_model) and $model->participant->shg_bank == 2) ? $model->participant->name_of_bank_shg : '',
                    (isset($shg_model) and $model->participant->shg_bank == 2) ? $model->participant->branch_shg : '',
                    (isset($shg_model) and $model->participant->shg_bank == 2) ? $model->participant->branch_code_or_ifsc_shg : '',
                    $pfms,
                    $bc_shg_funds_status,
                    $model->participant->pvr_status == 1 ? 'Yes' : 'No',
                    $model->participant->bc_support_funds_received == 1 ? 'Yes' : 'No',
                    $model->participant->bc_handheld_machine_recived == 1 ? 'Yes' : 'No',
                    $model->participant->bankidbc != null ? $model->participant->bankidbc : '',
                    isset($model->participant->bc_beneficiaries_code) ? 'Yes' : 'No',
                    isset($model->participant->beneficiaries_code) ? $model->participant->beneficiaries_code : '',
                    isset($model->participant->bc_beneficiaries_code) ? $model->participant->bc_beneficiaries_code : ''
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

    public function actionView($participantid) {

        $model = $this->findModel($participantid);

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('view', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDetail($bcid, $tab = null) {

        $model = $this->findModelbc($bcid);
        $pmodel = RsetisBatchParticipants::findOne(['bc_application_id' => $model->id]);
        if ($pmodel == null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $searchModel = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthlySearch();
        $searchModel->bc_application_id = $model->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->andWhere(['bc_application_id' => $model->id]);
        $dataProvider->sort->defaultOrder = ['month_start_date' => SORT_DESC];
        $scall = new \common\models\dynamicdb\support\ConversationDetailSearch();
        $scall->stakeholder_code = $model->id;
        $dataProviderCall = $scall->search($scall, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('_detailview', [
                        'tab' => $tab,
                        'model' => $model,
                        'pmodel' => $pmodel,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'dataProviderCall' => $dataProviderCall,
            ]);
        } else {
            return $this->render('_detailview', [
                        'tab' => $tab,
                        'model' => $model,
                        'pmodel' => $pmodel,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'dataProviderCall' => $dataProviderCall,
            ]);
        }
    }

    public function actionRemove($participantid) {
        $model = $this->findModel($participantid);
        if (in_array($model->training_status, [2])) {
            $model->status = -1;
            $model->training_status = SrlmBcApplication::TRAINING_STATUS_DEFAULT;
            if ($model->save()) {
                $bc_model = SrlmBcApplication::findOne($model->bc_application_id);
                $bc_model->training_id = SrlmBcApplication::ZERO_VALUE;
                $bc_model->training_center_id = SrlmBcApplication::ZERO_VALUE;
                $bc_model->training_batch_id = SrlmBcApplication::ZERO_VALUE;
                $bc_model->training_status = SrlmBcApplication::TRAINING_STATUS_DEFAULT;
                $bc_model->exam_score = null;
                $bc_model->certificate_code = null;
                $bc_model->action_type = SrlmBcApplication::ACTION_TYPE_RSETHIS_REMOVE_BATCH;
                $bc_model->update();
                $condition = ['and',
                    ['=', 'id', $model->bc_application_id],
                ];
                SrlmBcApplication::updateAll([
                    'training_id' => SrlmBcApplication::ZERO_VALUE,
                    'training_center_id' => SrlmBcApplication::ZERO_VALUE,
                    'training_batch_id' => SrlmBcApplication::ZERO_VALUE,
                    'training_status' => SrlmBcApplication::TRAINING_STATUS_DEFAULT,
                    'exam_score' => null,
                    'certificate_code' => null,
                        ], $condition);
                if ($model->rsetis_center_training_id) {
                    $model->center->update();
                    $model->batch->update();
                    $model->training->update();
                    $models = new \bc\modules\training\models\TrainingEntity($model->training);
                    $models->calendarpopulate();
                }
            }
            if (isset(Yii::$app->request->referrer))
                return $this->redirect(Yii::$app->request->referrer);
            else
                return $this->redirect(['/training/participants']);
        }
    }

    public function actionAddscore($participantid) {
        $participant_model = $this->findModel($participantid);
        if (in_array($participant_model->participant->urban_shg, [1])) {
            return $this->redirect(['/training/training/view?trainingid=' . $participant_model->rsetis_center_training_id]);
        }
        if ($participant_model->participant->blocked != '0') {

            return $this->redirect(['/training/training/view?trainingid=' . $participant_model->rsetis_center_training_id]);
        }
//        if (!in_array($participant_model->participant->reading_skills, [1, 2])) {
//            return $this->redirect(['/training/training/view?trainingid=' . $participant_model->rsetis_center_training_id]);
//        }
        $model = new AddScoreForm($participant_model);
        $gp_selected_application = SrlmBcApplication::find()->where(['gram_panchayat_code' => $participant_model->participant->gram_panchayat_code, 'status' => 2])->count();
        if ($gp_selected_application == 1) {
            
        } elseif ($gp_selected_application > 1) {
            if (in_array($participant_model->training_status, [2])) {
                
            } else {

                if ($model->checkgpapplicationstatus()) {
                    
                } else {
                    \Yii::$app->getSession()->setFlash('error', "Anther BC is already Certified/Selected in this GP; the training status can't be updated");
                    $js = "window.location.href = '/training/training/view?trainingid=$participant_model->rsetis_center_training_id'";
                    $this->getView()->registerJs($js);
//                    return \Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc'] . '/training/training/view?trainingid=' . $participant_model->rsetis_center_training_id, '302', true);
//                    exit(0);
                }
            }
        }
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            $model->iibf_photo_file_name = UploadedFile::getInstance($model, 'iibf_photo_file_name');
            if ($model->training_status == 34) {
                $model->participant_model->exam_score = $model->exam_score;
                $model->participant_model->certificate_code = $model->certificate_code;
                if ($model->exam_score < AddScoreForm::PASS_MARKS) {
                    $model->participant_model->training_status = SrlmBcApplication::TRAINING_STATUS_FAIL;
                } else {
                    $model->participant_model->training_status = SrlmBcApplication::TRAINING_STATUS_PASS;
                }
            } else {
                $model->participant_model->exam_score = null;
                $model->participant_model->certificate_code = null;
                $model->participant_model->training_status = $model->training_status;
            }
            $model->participant_model->participant->exam_score = $model->exam_score;
            $model->participant_model->participant->certificate_code = $model->certificate_code;
            $model->participant_model->participant->training_status = $model->participant_model->training_status;
            $model->participant_model->participant->updated_at = time();
            $model->participant_model->participant->iibf_by = \Yii::$app->user->identity->id;
            $model->participant_model->participant->iibf_date = new \yii\db\Expression('NOW()');
            if ($model->tenth_not_pass and $model->confirm_10th_pass) {
                $model->participant_model->participant->reading_skills = 1;
            }
            $model->participant_model->participant->action_type = SrlmBcApplication::ACTION_TYPE_RSETHIS_ADD_SCORE;
            if ($model->iibf_photo_file_name != null) {
                $APPLICATION_FORM_FILE_FOLDER = \Yii::$app->params['bcdatapath'];
                $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "bcselection/bcprofile/";

                if (!file_exists($APPLICATION_FORM_FILE_FOLDER . $participant_model->bc_selection_user_id)) {
                    mkdir($APPLICATION_FORM_FILE_FOLDER . $participant_model->bc_selection_user_id);
                    chmod($APPLICATION_FORM_FILE_FOLDER . $participant_model->bc_selection_user_id, 0777);
                }
                $new_file_name = 'iibf_photo' . '_' . time() . '_' . $model->iibf_photo_file_name->name;
                if ($model->iibf_photo_file_name->saveAs($APPLICATION_FORM_FILE_FOLDER . $participant_model->bc_selection_user_id . '/' . $new_file_name)) {
                    chmod($APPLICATION_FORM_FILE_FOLDER . $participant_model->bc_selection_user_id . '/' . $new_file_name, 0777);
                    $model->participant_model->participant->iibf_photo_status = 1;
                    $model->participant_model->participant->iibf_photo_upload_by = Yii::$app->user->identity->id;
                    $model->participant_model->participant->iibf_photo_upload_date = new \yii\db\Expression('NOW()');
                    $model->participant_model->participant->iibf_photo_file_name = $new_file_name;
                    $model->participant_model->participant->migrate_rishta = 0;
                }
            }
            if ($model->participant_model->update() and $model->participant_model->participant->update()) {
                if ($model->participant_model->participant->training_status == SrlmBcApplication::TRAINING_STATUS_PASS) {
                    $bc_noti = new BCNotification($model->participant_model->participant);
                    $bc_noti->Send(BCNotification::CERTIFIED_BANK_DETAIL_INFO_7);
                }
                \Yii::$app->getSession()->setFlash('success', 'Add score successfully');
                return $this->redirect(['/training/training/view?trainingid=' . $participant_model->rsetis_center_training_id]);
            } else {
                
            }
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_addsoreform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_addsoreform', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUploadiibf($participantid) {
        $participant_model = $this->findModel($participantid);
        if (in_array($participant_model->participant->urban_shg, [1])) {
            return $this->redirect(['/training/training/view?trainingid=' . $participant_model->rsetis_center_training_id]);
        }
        if ($participant_model->participant->blocked != '0') {
            return $this->redirect(['/training/training/view?trainingid=' . $participant_model->rsetis_center_training_id]);
        }
        $model = new \bc\modules\training\models\form\UploadIIBFCertificateForm($participant_model);
        //$this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            $model->iibf_photo_file_name = UploadedFile::getInstance($model, 'iibf_photo_file_name');

            if ($model->iibf_photo_file_name != null) {
                $APPLICATION_FORM_FILE_FOLDER = \Yii::$app->params['bcdatapath'];
                $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "bcselection/bcprofile/";

                if (!file_exists($APPLICATION_FORM_FILE_FOLDER . $participant_model->bc_selection_user_id)) {
                    mkdir($APPLICATION_FORM_FILE_FOLDER . $participant_model->bc_selection_user_id);
                    chmod($APPLICATION_FORM_FILE_FOLDER . $participant_model->bc_selection_user_id, 0777);
                }
                $new_file_name = 'iibf_photo' . '_' . time() . '_' . $model->iibf_photo_file_name->name;
                if ($model->iibf_photo_file_name->saveAs($APPLICATION_FORM_FILE_FOLDER . $participant_model->bc_selection_user_id . '/' . $new_file_name)) {
                    chmod($APPLICATION_FORM_FILE_FOLDER . $participant_model->bc_selection_user_id . '/' . $new_file_name, 0777);
                    $model->participant_model->participant->iibf_photo_status = 1;
                    $model->participant_model->participant->iibf_photo_upload_by = Yii::$app->user->identity->id;
                    $model->participant_model->participant->iibf_photo_upload_date = new \yii\db\Expression('NOW()');
                    $model->participant_model->participant->iibf_photo_file_name = $new_file_name;
                    $model->participant_model->participant->migrate_rishta = 0;
                    $model->participant_model->participant->action_type = SrlmBcApplication::ACTION_TYPE_RSETHIS_ADD_SCORE;
                }
            }
            if ($model->participant_model->participant->update()) {

                \Yii::$app->getSession()->setFlash('success', 'IIBF Cetificate photo upload successfully');
                return $this->redirect(['/training/training/view?trainingid=' . $participant_model->rsetis_center_training_id]);
            } else {
                
            }
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_iibfcertificateform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_iibfcertificateform', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUploadpvr($participantid) {
        $participant_model = $this->findModel($participantid);
        if (!in_array($participant_model->participant->reading_skills, [1, 2])) {
            return $this->redirect(['/training/participants']);
        }
        if (in_array($participant_model->participant->urban_shg, [1])) {
            return $this->redirect(['/training/participants']);
        }
        if ($participant_model->participant->blocked != '0') {
            return $this->redirect(['/training/participants']);
        }
        $model = new \bc\modules\training\models\form\UploadCandidatePVR($participant_model);
        //$this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            $model->pvr_upload_file_name = UploadedFile::getInstance($model, 'pvr_upload_file_name');
            $APPLICATION_FORM_FILE_FOLDER = \Yii::$app->params['bcdatapath'];
            $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "bcselection/bcprofile/";

            if (!file_exists($APPLICATION_FORM_FILE_FOLDER . $participant_model->bc_selection_user_id)) {
                mkdir($APPLICATION_FORM_FILE_FOLDER . $participant_model->bc_selection_user_id);
                chmod($APPLICATION_FORM_FILE_FOLDER . $participant_model->bc_selection_user_id, 0777);
            }

            if ($model->pvr_upload_file_name != null) {
                $new_file_name = 'pvr' . '_' . time() . '_' . $model->pvr_upload_file_name->name;
                if ($model->pvr_upload_file_name->saveAs($APPLICATION_FORM_FILE_FOLDER . $participant_model->bc_selection_user_id . '/' . $new_file_name)) {
                    chmod($APPLICATION_FORM_FILE_FOLDER . $participant_model->bc_selection_user_id . '/' . $new_file_name, 0777);
                    $participant_model->pvr_status = 1;
                    $participant_model->pvr_upload_by = Yii::$app->user->identity->id;
                    $participant_model->pvr_upload_date = new \yii\db\Expression('NOW()');
                    $participant_model->pvr_upload_file_name = $new_file_name;
                    $model->application_model->pvr_status = $participant_model->pvr_status;
                    $model->application_model->pvr_upload_by = Yii::$app->user->identity->id;
                    $model->application_model->pvr_upload_date = new \yii\db\Expression('NOW()');
                    $model->application_model->pvr_upload_file_name = $new_file_name;
                    $model->application_model->migrate_rishta = 0;
                    $model->application_model->action_type = SrlmBcApplication::ACTION_TYPE_UPLOAD_PVR;
                    if ($participant_model->update() and $model->application_model->update()) {
                        $bc_noti_pvr = new BCNotification($model->application_model);
                        $bc_noti_pvr->Send(BCNotification::POLICE_VERIFICATION_INFO_16);
                        \Yii::$app->getSession()->setFlash('success', 'PVR upload successfully');
                        return $this->redirect(['/training/participants']);
                    }
                }
            }
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_uploadpvrform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_uploadpvrform', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDelpvr($participantid) {
        $participant_model = $this->findModel($participantid);
        $model = new \bc\modules\training\models\form\UploadCandidatePVR($participant_model);
        if ($participant_model->pvr_status) {
            $participant_model->pvr_status = 0;
            $model->application_model->pvr_status = 0;
            $model->application_model->action_type = SrlmBcApplication::ACTION_TYPE_UPLOAD_REVERT_PVR;
            if ($participant_model->update() and $model->application_model->update()) {
                \Yii::$app->getSession()->setFlash('success', 'Delete PVR upload successfully');
                return $this->redirect(['/training/participants']);
            }
        } else {
            return $this->redirect(['/training/participants']);
        }
    }

    public function actionOnboarding($participantid) {
        $participant_model = $this->findModel($participantid);
        if ($participant_model->training_status != SrlmBcApplication::TRAINING_STATUS_PASS) {
            return $this->redirect(['/training/participants/certified']);
        }
        if (!in_array($participant_model->participant->reading_skills, [1, 2])) {
            return $this->redirect(['/training/participants/certified']);
        }
        if (in_array($participant_model->participant->urban_shg, [1])) {
            return $this->redirect(['/training/participants/certified']);
        }
        if ($participant_model->participant->blocked != '0') {
            return $this->redirect(['/training/participants/certified']);
        }
        $model = new \bc\modules\training\models\form\OnboardingForm($participant_model->participant);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {

                $model->bc_application_model->onboarding = $model->onboarding;
                $model->bc_application_model->bankidbc = $model->bankidbc;
                $model->bc_application_model->bc_email_id = $model->bc_email_id;
                $model->bc_application_model->onboarding_by = Yii::$app->user->identity->id;
                $model->bc_application_model->onboarding_date_time = \Yii::$app->formatter->asDatetime($model->onboarding_date_time, "php:Y-m-d");
                $model->bc_application_model->action_type = SrlmBcApplication::ACTION_TYPE_ONBOARDING;
                if ($participant_model->update() and $model->bc_application_model->update()) {
                    if ($model->bc_application_model->onboarding == 1) {
                        $bc_noti = new BCNotification($model->bc_application_model);
                        $bc_noti->Send(BCNotification::ONBOARDING_PROCESS_INFO_17);
                    }
                    return $this->redirect(['/training/participants/certified']);
                }
            }
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('_onboardingform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_onboardingform', [
                        'model' => $model,
            ]);
        }
    }

    public function actionPancard($participantid) {
        $participant_model = $this->findModel($participantid);
        if (!in_array($participant_model->training_status, [SrlmBcApplication::TRAINING_STATUS_PASS])) {
            return $this->redirect(['/training/participants/certified']);
        }
        if (!in_array($participant_model->participant->reading_skills, [1, 2])) {
            return $this->redirect(['/training/participants/certified']);
        }
        if (in_array($participant_model->participant->urban_shg, [1])) {
            return $this->redirect(['/training/participants/certified']);
        }
        if ($participant_model->participant->blocked != '0') {
            return $this->redirect(['/training/participants/certified']);
        }
        $model = new \bc\modules\training\models\form\PancardStatusForm($participant_model->participant);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {

                $model->bc_application_model->pan_card_status = $model->pan_card_status;
                $model->bc_application_model->pan_card_status_by = Yii::$app->user->identity->id;
                $model->bc_application_model->pan_card_status_date = new \yii\db\Expression('NOW()');
                $model->bc_application_model->action_type = SrlmBcApplication::ACTION_TYPE_PAN_AVAILABLE;
                if ($participant_model->update() and $model->bc_application_model->update()) {

                    if ($model->bc_application_model->pan_card_status == 1) {
                        $bc_noti = new BCNotification($model->bc_application_model);
                        $bc_noti->Send(BCNotification::PAN_CARD_UPLOAD_12);
                    }
                    return $this->redirect(['/training/participants/certified']);
                }
            }
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('_pancardstatusform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_pancardstatusform', [
                        'model' => $model,
            ]);
        }
    }

    public function actionHandheldmachine($participantid) {
        $participant_model = $this->findModel($participantid);
        if (!in_array($participant_model->training_status, [SrlmBcApplication::TRAINING_STATUS_PASS])) {
            return $this->redirect(['/training/participants/certified']);
        }
        if (!in_array($participant_model->participant->reading_skills, [1, 2])) {
            return $this->redirect(['/training/participants/certified']);
        }
        if (in_array($participant_model->participant->urban_shg, [1])) {
            return $this->redirect(['/training/participants/certified']);
        }
        if ($participant_model->participant->blocked != '0') {
            return $this->redirect(['/training/participants/certified']);
        }
        $model = new \bc\modules\training\models\form\HandheldMachineForm($participant_model->participant);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {

                if ($model->handheld_machine_status) {
                    $model->bc_application_model->handheld_machine_status = $model->handheld_machine_status;
                    $model->bc_application_model->handheld_machine_by = Yii::$app->user->identity->id;
                    $model->bc_application_model->handheld_machine_date = new \yii\db\Expression('NOW()');
                    $model->bc_application_model->action_type = SrlmBcApplication::ACTION_TYPE_HANDHELD_MACHIN_PROVIDED;
                    if ($participant_model->update() and $model->bc_application_model->update()) {
                        return $this->redirect(['/training/participants/certified']);
                    }
                } else {
                    return $this->redirect(['/training/participants/certified']);
                }
            }
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('handheld_machine_status_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('handheld_machine_status_form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionBeneficiaries($participantid) {
        $participant_model = $this->findModel($participantid);

        if (!(($participant_model->training_status == SrlmBcApplication::TRAINING_STATUS_PASS) and $participant_model->participant->cbo_shg_id != null and $participant_model->participant->shg_bank == 2 and $participant_model->participant->bc_bank == 2 and $participant_model->participant->beneficiaries_code == null and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_DC_NRLM]))) {
            return $this->redirect(['/training/participants/certified']);
        }
        if (!in_array($participant_model->participant->reading_skills, [1, 2])) {
            return $this->redirect(['/training/participants/certified']);
        }
        if (in_array($participant_model->participant->urban_shg, [1])) {
            return $this->redirect(['/training/participants/certified']);
        }
        if ($participant_model->participant->blocked != '0') {
            return $this->redirect(['/training/participants/certified']);
        }
        if (!in_array($participant_model->participant->bc_bank, [2])) {
            return $this->redirect(['/training/participants/certified']);
        }
        if (!in_array($participant_model->participant->shg_bank, [2])) {
            return $this->redirect(['/training/participants/certified']);
        }

        $model = new \bc\modules\training\models\form\BeneficiariesForm($participant_model->participant);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->bc_application_model->pfms_maped_status = 1;
                $model->bc_application_model->old_pfms = 0;
                $model->bc_application_model->beneficiaries_code = $model->beneficiaries_code;
                $model->bc_application_model->beneficiaries_code_by = Yii::$app->user->identity->id;
                $model->bc_application_model->beneficiaries_code_date = new \yii\db\Expression('NOW()');
                $model->bc_application_model->action_type = SrlmBcApplication::ACTION_TYPE_PFMS_BENEFICIARIES_CODE;
                if ($model->shg_model != null) {
                    $model->shg_model->pfms_maped_status = 1;
                    $model->shg_model->beneficiaries_code = $model->beneficiaries_code;
                    $model->shg_model->update();
                }
                if ($model->bc_application_model->update()) {
                    return $this->redirect(['/training/participants/certified']);
                }
            }
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('beneficiaries', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('beneficiaries', [
                        'model' => $model,
            ]);
        }
    }

    public function actionBcbeneficiaries($participantid) {
        $participant_model = $this->findModel($participantid);

        if (!(($participant_model->training_status == SrlmBcApplication::TRAINING_STATUS_PASS) and $participant_model->participant->cbo_shg_id != null and $participant_model->participant->shg_bank == 2 and $participant_model->participant->bc_bank == 2 and $participant_model->participant->bc_beneficiaries_code == null and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_DC_NRLM]))) {
            return $this->redirect(['/training/participants/bcpfmsmapping']);
        }
        if (!in_array($participant_model->participant->reading_skills, [1, 2])) {
            return $this->redirect(['/training/participants/bcpfmsmapping']);
        }
        if (in_array($participant_model->participant->urban_shg, [1])) {
            return $this->redirect(['/training/participants/bcpfmsmapping']);
        }
        if ($participant_model->participant->blocked != '0') {
            return $this->redirect(['/training/participants/bcpfmsmapping']);
        }
        $model = new \bc\modules\training\models\form\BCBeneficiariesForm($participant_model->participant);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->bc_application_model->bc_beneficiaries_code = $model->bc_beneficiaries_code;
                $model->bc_application_model->bc_beneficiaries_code_by = Yii::$app->user->identity->id;
                $model->bc_application_model->bc_beneficiaries_code_date = new \yii\db\Expression('NOW()');
                $model->bc_application_model->action_type = SrlmBcApplication::ACTION_TYPE_BC_BENEFICIARIES_CODE;

                if ($model->bc_application_model->update()) {
                    $model->bc_payment_model->bc_application_id = $model->bc_application_model->id;
                    $model->bc_payment_model->srlm_bc_selection_user_id = $model->bc_application_model->srlm_bc_selection_user_id;
                    $model->bc_payment_model->district_code = $model->bc_application_model->district_code;
                    $model->bc_payment_model->block_code = $model->bc_application_model->block_code;
                    $model->bc_payment_model->gram_panchayat_code = $model->bc_application_model->gram_panchayat_code;
                    $model->bc_payment_model->save();
                    return $this->redirect(['/training/participants/bcpfmsmapping']);
                }
            }
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('bcbeneficiariesform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('bcbeneficiariesform', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpdatemobileno($bcid) {
        $bc_model = $this->findModelbc($bcid);
        if (!in_array($bc_model->reading_skills, [1, 2])) {
            return $this->redirect(['/training/participants/certified']);
        }
        if (in_array($bc_model->urban_shg, [1])) {
            return $this->redirect(['/training/participants/certified']);
        }

        $model = new \bc\models\form\UpdateBCMobileNoForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {

            return $this->redirect(['/training/participants/certified']);
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

    public function actionConfirmbank($bcid) {
        $bc_model = $this->findModelbc($bcid);
        if (!in_array($bc_model->reading_skills, [1, 2])) {
            return $this->redirect(['/training/participants/certified']);
        }
        if (in_array($bc_model->urban_shg, [1])) {
            return $this->redirect(['/training/participants/certified']);
        }
        if (in_array($bc_model->bc_settlement_account_bank_confirm, [1])) {
            return $this->redirect(['/training/participants/certified']);
        }
        $model = new \bc\modules\training\models\form\BCSettelmentBankConfirmForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {

            return $this->redirect(['/training/participants/certified']);
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('confirmbank', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('confirmbank', [
                        'model' => $model,
            ]);
        }
    }

    public function actionVeryfybcshgbank($bcid) {
        $bc_model = $this->findModelbc($bcid);
        if (!in_array($bc_model->reading_skills, [1, 2])) {
            return $this->redirect(['/training/participants/verification']);
        }
        if (in_array($bc_model->urban_shg, [1])) {
            return $this->redirect(['/training/participants/verification']);
        }
        if ($bc_model->blocked != '0') {
            return $this->redirect(['/training/participants/verification']);
        }
        $model = new \bc\modules\selection\models\form\VerificationBankDetailForm($bc_model);
        if ($model->bc_bank == 1 or $model->shg_bank == 1) {
            
        } else {
            return $this->redirect(['/training/participants/verification?RsetisBatchParticipantsSearch[district_code]=' . $bc_model->district_code]);
        }
//        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate()) {

            if ($model->bc_bank == 1) {
                if ($model->verify_bc_passbook_photo == '1') {
                    $model->participant_model->verify_bc_passbook_photo = 0;
                } else {
                    $model->participant_model->verify_bc_passbook_photo = 1;
                }
                if ($model->verify_bc_passbook_not == '1') {
                    $model->participant_model->verify_bc_passbook_not = 0;
                } else {
                    $model->participant_model->verify_bc_passbook_not = 1;
                }
                if ($model->verify_bc_bank_account_no == '1') {
                    $model->participant_model->verify_bc_bank_account_no = 0;
                } else {
                    $model->participant_model->verify_bc_bank_account_no = 1;
                }
                if ($model->verify_bc_branch_code_or_ifsc == '1') {
                    $model->participant_model->verify_bc_branch_code_or_ifsc = 0;
                } else {
                    $model->participant_model->verify_bc_branch_code_or_ifsc = 1;
                }
                if ($model->verify_bc_ifsc_code_entered == '1') {
                    $model->participant_model->verify_bc_ifsc_code_entered = 0;
                } else {
                    $model->participant_model->verify_bc_ifsc_code_entered = 1;
                }
                if ($model->verify_bc_other == 1) {
                    $model->participant_model->verify_bc_other = 0;
                    $model->participant_model->verify_bc_other_reason = $model->verify_bc_other_reason;
                } else {
                    $model->participant_model->verify_bc_other = 1;
                    $model->participant_model->verify_bc_other_reason = null;
                }
                $model->participant_model->verification_status_bc_bank = 1;
                $model->participant_model->bc_bank_verify_by = Yii::$app->user->identity->id;
                $model->participant_model->bc_bank_verify_date = new \yii\db\Expression('NOW()');
                if ($model->participant_model->verify_bc_passbook_photo and $model->participant_model->verify_bc_passbook_not and $model->participant_model->verify_bc_bank_account_no and $model->participant_model->verify_bc_branch_code_or_ifsc and $model->participant_model->verify_bc_ifsc_code_entered and $model->participant_model->verify_bc_other) {
                    $model->participant_model->bc_bank = 2;
                } else {
                    $model->participant_model->bc_bank = 3;
                }
            }
            if ($model->shg_bank == 1 and $model->participant_model->cbo_shg_id) {
                if ($model->verify_bc_shg_passbook_photo == 1) {
                    $model->participant_model->verify_bc_shg_passbook_photo = 0;
                } else {
                    $model->participant_model->verify_bc_shg_passbook_photo = 1;
                }
                if ($model->verify_bc_shg_name == 1) {
                    $model->participant_model->verify_bc_shg_name = 0;
                } else {
                    $model->participant_model->verify_bc_shg_name = 1;
                }
                if ($model->verify_bc_shg_bank_account_no == 1) {
                    $model->participant_model->verify_bc_shg_bank_account_no = 0;
                } else {
                    $model->participant_model->verify_bc_shg_bank_account_no = 1;
                }
                if ($model->verify_bc_shg_passbook_not == 1) {
                    $model->participant_model->verify_bc_shg_passbook_not = 0;
                } else {
                    $model->participant_model->verify_bc_shg_passbook_not = 1;
                }
                if ($model->verify_bc_shg_branch_code_or_ifsc == 1) {
                    $model->participant_model->verify_bc_shg_branch_code_or_ifsc = 0;
                } else {
                    $model->participant_model->verify_bc_shg_branch_code_or_ifsc = 1;
                }
                if ($model->verify_bc_shg_ifsc_code_entered == 1) {
                    $model->participant_model->verify_bc_shg_ifsc_code_entered = 0;
                } else {
                    $model->participant_model->verify_bc_shg_ifsc_code_entered = 1;
                }
                if ($model->verify_bc_shg_other == 1) {
                    $model->participant_model->verify_bc_shg_other = 0;
                    $model->participant_model->verify_bc_shg_other_reason = $model->verify_bc_shg_other_reason;
                } else {
                    $model->participant_model->verify_bc_shg_other = 1;
                    $model->participant_model->verify_bc_shg_other_reason = null;
                }

                $model->participant_model->bc_shg_bank_verify_by = Yii::$app->user->identity->id;
                $model->participant_model->bc_shg_bank_verify_date = new \yii\db\Expression('NOW()');
                $model->participant_model->verification_status_shg_bank = 1;
                if ($model->participant_model->verify_bc_shg_passbook_photo and $model->participant_model->verify_bc_shg_name and $model->participant_model->verify_bc_shg_bank_account_no and $model->participant_model->verify_bc_shg_passbook_not and $model->participant_model->verify_bc_shg_branch_code_or_ifsc and $model->participant_model->verify_bc_shg_ifsc_code_entered and $model->participant_model->verify_bc_shg_other) {
                    $model->participant_model->shg_bank = 2;
                } else {
                    $model->participant_model->shg_bank = 3;
                }
            }
//
//            if ($model->participant_model->verify_bc_passbook_photo and $model->participant_model->verify_bc_passbook_not and $model->participant_model->verify_bc_bank_account_no and $model->participant_model->verify_bc_branch_code_or_ifsc and $model->participant_model->verify_bc_ifsc_code_entered and $model->participant_model->verify_bc_other and $model->participant_model->verify_bc_shg_passbook_photo and $model->participant_model->verify_bc_shg_name and $model->participant_model->verify_bc_shg_bank_account_no and $model->participant_model->verify_bc_shg_passbook_not and $model->participant_model->verify_bc_shg_branch_code_or_ifsc and $model->participant_model->verify_bc_shg_ifsc_code_entered and $model->participant_model->verify_bc_shg_other) {
//                $model->participant_model->bc_bank = 2;
//                $model->participant_model->shg_bank = 2;
//            }
            $model->participant_model->action_type = SrlmBcApplication::ACTION_TYPE_BANK_VERIFICATION;
            if ($model->participant_model->save() and $model->sendnotification()) {
                return $this->redirect(['/training/participants/verification?RsetisBatchParticipantsSearch[district_code]=' . $bc_model->district_code]);
            }
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('verification_bank_detail_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('verification_bank_detail_form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionShgrevert($bcid) {
        $bc_model = $this->findModelbc($bcid);
        if ($bc_model->blocked != '0') {
            return $this->redirect(['/training/participants/verification?RsetisBatchParticipantsSearch[district_code]=' . $bc_model->district_code . ""]);
        }
        if (($bc_model->bc_shg_funds_status == 1)) {
            return $this->redirect(['/training/participants/verification?RsetisBatchParticipantsSearch[district_code]=' . $bc_model->district_code . ""]);
        }
        if (($bc_model->pfms_maped_status == 1)) {
            return $this->redirect(['/training/participants/verification?RsetisBatchParticipantsSearch[district_code]=' . $bc_model->district_code . ""]);
        }
        $model = new \bc\modules\selection\models\form\RevertBCSHGMapping($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {
            \Yii::$app->getSession()->setFlash('success', ' Revert SHG Successfully');
            return $this->redirect(['/training/participants/verification?RsetisBatchParticipantsSearch[district_code]=' . $bc_model->district_code . ""]);
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('revert_shg_mapped_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('revert_shg_mapped_form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionMappfms($bcid) {
        $bc_model = $this->findModelbc($bcid);
        if (!($bc_model->shg_bank == 2 and $bc_model->bc_bank == 2 and $bc_model->pfms_maped_status == 1 and $bc_model->bc_shg_funds_status == null)) {
            return $this->redirect(['/training/participants/pfmspayment?RsetisBatchParticipantsSearch[district_code]=' . $bc_model->district_code . "&RsetisBatchParticipantsSearch[bc_bank]=&RsetisBatchParticipantsSearch[bc_shg_bank]=3"]);
        }
        if (!in_array($bc_model->reading_skills, [1, 2])) {
            return $this->redirect(['/training/participants/pfmspayment']);
        }
        if (in_array($bc_model->urban_shg, [1])) {
            return $this->redirect(['/training/participants/pfmspayment']);
        }
        if ($bc_model->blocked != '0') {
            return $this->redirect(['/training/participants/pfmspayment']);
        }
        $model = new \bc\modules\selection\models\form\BCSHGPFMSMapedForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->shg_bank == 2) {
                //$model->participant_model->pfms_maped_status = $model->pfms_maped_status;
                $model->participant_model->bc_shg_funds_status = $model->bc_shg_funds_status;
                if ($model->bc_shg_funds_date) {
                    $model->participant_model->bc_shg_funds_date = \Yii::$app->formatter->asDatetime($model->bc_shg_funds_date, "php:Y-m-d");
                }
                $model->participant_model->bc_shg_funds_by = Yii::$app->user->identity->id;
                if ($model->bc_shg_funds_status == 1) {
                    $model->participant_model->bc_shg_funds_amount = '75000';
                }
                if ($model->shg_model != null) {
                    //$model->shg_model->pfms_maped_status = $model->pfms_maped_status;
                    $model->shg_model->bc_shg_funds_status = $model->bc_shg_funds_status;
                    if ($model->bc_shg_funds_date) {
                        $model->shg_model->bc_shg_funds_date = \Yii::$app->formatter->asDatetime($model->bc_shg_funds_date, "php:Y-m-d");
                    }
                    $model->shg_model->bc_shg_funds_by = Yii::$app->user->identity->id;
                    if ($model->bc_shg_funds_status == 1) {
                        $model->shg_model->bc_shg_funds_amount = '75000';
                    }
                    $model->shg_model->update();
                }
            }
            $model->participant_model->action_type = SrlmBcApplication::ACTION_TYPE_FUNDS_TRANSFER;
            if ($model->participant_model->save()) {
                if ($model->bc_shg_funds_status == 1) {
                    $bc_noti_funds = new BCNotification($model->participant_model);
                    $bc_noti_funds->Send(BCNotification::PAYMENT_OF_BC_SUPPORT_INFO_18);
                }
                $next_model = RsetisBatchParticipants::find()->joinWith(['participant'])->andWhere(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS])->andWhere(['srlm_bc_application.shg_bank' => 2])->andWhere(['rsetis_batch_participants.district_code' => $bc_model->district_code])->one();
                if ($next_model != null) {
                    return $this->redirect(['/training/participants/pfmspayment?RsetisBatchParticipantsSearch[district_code]=' . $bc_model->district_code . "&RsetisBatchParticipantsSearch[bc_bank]=&RsetisBatchParticipantsSearch[bc_shg_bank]=3"]);
                } else {
                    return $this->redirect(['/training/participants/pfmspayment?RsetisBatchParticipantsSearch[district_code]=' . $bc_model->district_code . "&RsetisBatchParticipantsSearch[bc_bank]=&RsetisBatchParticipantsSearch[bc_shg_bank]=3"]);
                }
            }
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('pfms_mapped_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('pfms_mapped_form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionImportonboard() {
        $user_model = Yii::$app->user->identity;
        $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
        $model = new \bc\modules\training\models\form\UploadCsvActionForm();
        $model->form = \bc\modules\selection\models\BcFiles::FORM_ONBOARD;
        $model->page_title = 'Upload CSV for onboarding';
        $model->sample_csv_url = '/training/participants/sample?filename=onboarding.csv';
        $model->master_partner_bank_id = (isset($user_model->master_partner_bank_id) and $user_model->master_partner_bank_id) ? $user_model->master_partner_bank_id : '';
        $searchModel = new BcFilesSearch();
        $searchModel->form = $model->form;
        $searchModel->status = 2;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 10);
        $rows = [];
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            if ($model->fileid and isset($_POST['continue'])) {
                $csv_model = \bc\modules\selection\models\BcFiles::findOne($model->fileid);
                if ($csv_model == null) {
                    return $this->redirect(['importonboard']);
                }
                if ($csv_model->status == 2) {
                    return $this->redirect(['importonboard']);
                }
                $fp = fopen(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $csv_model->form . '/' . $csv_model->file_name, 'r');
                $line = fgetcsv($fp, 1000, ",");
                $rows = [];
                $first_time = true;
                do {
                    if ($first_time == true) {
                        $first_time = false;
                        continue;
                    } else {
                        $app_model = SrlmBcApplication::findOne(['application_id' => $line[0]]);
                        if ($app_model->bankidbc == null) {
                            $models = new \bc\modules\training\models\form\OnboardingForm($app_model);
                            $models->onboarding = $line[5];
                            $models->bankidbc = $line[7];
                            $models->bc_email_id = $line[8];
                            $models->onboarding_date_time = $line[6];
                            if ($models->validate()) {
                                $models->bc_application_model->onboarding = $models->onboarding;
                                $models->bc_application_model->bankidbc = $models->bankidbc;
                                $models->bc_application_model->bc_email_id = $models->bc_email_id;
                                $models->bc_application_model->onboarding_by = Yii::$app->user->identity->id;
                                $models->bc_application_model->onboarding_date_time = \Yii::$app->formatter->asDatetime($models->onboarding_date_time, "php:Y-m-d");
                                $models->bc_application_model->action_type = SrlmBcApplication::ACTION_TYPE_ONBOARDING;
                                $models->bc_application_model->save();
                                if ($models->bc_application_model->onboarding == 1) {
                                    $bc_noti = new BCNotification($models->bc_application_model);
                                    $bc_noti->Send(BCNotification::ONBOARDING_PROCESS_INFO_17);
                                }
                            }
                        }
                    }
                } while (($line = fgetcsv($fp, 1000, ",")) != FALSE);
                $csv_model->status = 2;
                $csv_model->save();
                \Yii::$app->getSession()->setFlash('success', $csv_model->row_count . ' Record Uploaded Successfully');
                return $this->redirect(['importonboard']);
            } else {
                $model->csvfile = UploadedFile::getInstance($model, 'csvfile');
                if ($model->csvfile != NULL) {
                    $new_file_name = time() . '_' . $model->csvfile->baseName . '.' . $model->csvfile->extension;
                    if (!file_exists(Yii::$app->params['bcdatapath'] . '/tmp')) {
                        mkdir(Yii::$app->params['bcdatapath'] . '/tmp');
                        chmod(Yii::$app->params['bcdatapath'] . '/tmp', 0777);
                    }
                    if (!file_exists(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form)) {
                        mkdir(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form);
                        chmod(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form, 0777);
                    }
                    $TEMP_FILE = Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form . '/' . $new_file_name;
                    if ($model->csvfile->saveAs($TEMP_FILE)) {
                        chmod($TEMP_FILE, 0777);
                        $fp = fopen(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form . '/' . $new_file_name, 'r');
                        if ($fp) {
                            $line = fgetcsv($fp, 1000, ",");
                            $file_row_count = count(file(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form . '/' . $new_file_name, FILE_SKIP_EMPTY_LINES));
                            $count = count($line);
                            if ($count < 9 || $file_row_count < 2 or $file_row_count > 101) {
                                \Yii::$app->getSession()->setFlash('success', 'Invalid onbboard csv');

                                $model->addError('csvfile', 'Invalid onbboard csv please see sample csv.');
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
                                        array_push($model->rows, $line);
                                        $app_model = SrlmBcApplication::findOne(['application_id' => $line[0]]);
                                        if ($app_model == null) {
                                            $model->rows[$i][9] = "Application Id not found";
                                            $message .= 'Application Id not found';
                                            $model->error = true;
                                        } else {
                                            if ($app_model->status != 2) {
                                                $model->rows[$i][9] = "Application not selected";
                                                $message .= '<br/>Application not selected';
                                                $model->error = true;
                                            }
                                            if ($app_model->training_status != SrlmBcApplication::TRAINING_STATUS_PASS) {
                                                $model->rows[$i][9] = "Applicant not certified";
                                                $message .= '<br/>Applicant not certified';
                                                $model->error = true;
                                            }
                                            if (!in_array($app_model->reading_skills, [1, 2])) {
                                                $model->rows[$i][9] = "Applicant Ineligible";
                                                $message .= '<br/>Applicant Ineligible';
                                                $model->error = true;
                                            }
                                            if (in_array($app_model->urban_shg, [1])) {
                                                $model->rows[$i][9] = "Applicant Ineligible";
                                                $message .= '<br/>Applicant Ineligible(BC GP Urban)';
                                                $model->error = true;
                                            }
                                            if ($app_model->blocked != '0') {
                                                $model->rows[$i][9] = "Applicant Blocked";
                                                $message .= '<br/>Applicant Blocked';
                                                $model->error = true;
                                            }
                                            if ($app_model->bankidbc) {
                                                $model->rows[$i][9] = "Can not change Bank Id";
                                                $message .= '<br/>Can not change Bank Id';
                                                $model->error = true;
                                            }
                                            if (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])) {
                                                if (!in_array($app_model->district_code, \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code'))) {
                                                    $model->rows[$i][9] = "access denied";
                                                    $message .= '<br/>access denied';
                                                    $model->error = true;
                                                }
                                            }
                                            $models = new \bc\modules\training\models\form\OnboardingForm($app_model);
                                            $models->onboarding = $line[5];
                                            $models->bankidbc = $line[7];
                                            $models->bc_email_id = $line[8];
                                            $models->onboarding_date_time = $line[6];
                                            if (!$models->validate()) {
                                                $model_errors = $models->getErrors();
                                                if (isset($model_errors['onboarding'])) {
                                                    $message .= '<br/>' . $model_errors['onboarding'][0];
                                                    $model->error = true;
                                                }
                                                if (isset($model_errors['onboarding_date_time'])) {
                                                    $message .= '<br/>' . $model_errors['onboarding_date_time'][0];
                                                    $model->error = true;
                                                }
                                                if (isset($model_errors['bankidbc'])) {
                                                    $message .= '<br/>' . $model_errors['bankidbc'][0];
                                                    $model->error = true;
                                                }
                                                if (isset($model_errors['bc_email_id'])) {
                                                    $message .= '<br/>' . $model_errors['bc_email_id'][0];
                                                    $model->error = true;
                                                }
                                            }
                                            if ($message != '') {
                                                $model->rows[$i][9] = ltrim($message, '<br/>');
                                            }
                                        }
                                    }
                                    $i++;
                                } while (($line = fgetcsv($fp, 1000, ",")) != FALSE);
                                if ($model->error == false) {
                                    $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                                    $file_model = new \bc\modules\selection\models\BcFiles();
                                    $file_model->master_partner_bank_id = isset($user_model->master_partner_bank_id) ? $user_model->master_partner_bank_id : 0;
                                    $file_model->file_name = $new_file_name;
                                    $file_model->label = $model->label;
                                    $file_model->form = \bc\modules\selection\models\BcFiles::FORM_ONBOARD;
                                    $file_model->row_count = ($file_row_count - 1);
                                    $file_model->upload_by = Yii::$app->user->identity->id;
                                    $file_model->upload_datetime = new \yii\db\Expression('NOW()');
                                    $file_model->save();
                                    $model->fileid = $file_model->id;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $this->render('uploadcsv', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionImportpan() {
        $user_model = Yii::$app->user->identity;
        $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
        $model = new \bc\modules\training\models\form\UploadCsvActionForm();
        $model->form = \bc\modules\selection\models\BcFiles::FORM_PAN;
        $model->page_title = 'Upload CSV for PAN Available';
        $model->sample_csv_url = '/training/participants/sample?filename=PAN_available.csv';
        $model->master_partner_bank_id = (isset($user_model->master_partner_bank_id) and $user_model->master_partner_bank_id) ? $user_model->master_partner_bank_id : '';
        $searchModel = new BcFilesSearch();
        $searchModel->form = $model->form;
        $searchModel->status = 2;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 10);
        $rows = [];
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            if ($model->fileid and isset($_POST['continue'])) {
                $csv_model = \bc\modules\selection\models\BcFiles::findOne($model->fileid);
                if ($csv_model == null) {
                    return $this->redirect(['importpan']);
                }
                if ($csv_model->status == 2) {
                    return $this->redirect(['importpan']);
                }
                $fp = fopen(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $csv_model->form . '/' . $csv_model->file_name, 'r');
                $line = fgetcsv($fp, 1000, ",");
                $rows = [];
                $first_time = true;
                do {
                    if ($first_time == true) {
                        $first_time = false;
                        continue;
                    } else {
                        $app_model = SrlmBcApplication::findOne(['application_id' => $line[0]]);
                        $models = new \bc\modules\training\models\form\PancardStatusForm($app_model);
                        $models->pan_card_status = $line[5];
                        if ($models->validate()) {

                            $models->bc_application_model->pan_card_status = $models->pan_card_status;
                            $models->bc_application_model->pan_card_status_by = Yii::$app->user->identity->id;
                            $models->bc_application_model->pan_card_status_date = new \yii\db\Expression('NOW()');
                            $models->bc_application_model->action_type = SrlmBcApplication::ACTION_TYPE_PAN_AVAILABLE;
                            $models->bc_application_model->save();
                        }
                    }
                } while (($line = fgetcsv($fp, 1000, ",")) != FALSE);
                $csv_model->status = 2;
                $csv_model->save();
                \Yii::$app->getSession()->setFlash('success', $csv_model->row_count . ' Record Uploaded Successfully');
                return $this->redirect(['importpan']);
            } else {
                $model->csvfile = UploadedFile::getInstance($model, 'csvfile');
                if ($model->csvfile != NULL) {
                    $new_file_name = time() . '_' . $model->csvfile->baseName . '.' . $model->csvfile->extension;
                    if (!file_exists(Yii::$app->params['bcdatapath'] . '/tmp')) {
                        mkdir(Yii::$app->params['bcdatapath'] . '/tmp');
                        chmod(Yii::$app->params['bcdatapath'] . '/tmp', 0777);
                    }
                    if (!file_exists(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form)) {
                        mkdir(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form);
                        chmod(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form, 0777);
                    }
                    $TEMP_FILE = Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form . '/' . $new_file_name;
                    if ($model->csvfile->saveAs($TEMP_FILE)) {
                        chmod($TEMP_FILE, 0777);
                        $fp = fopen(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form . '/' . $new_file_name, 'r');
                        if ($fp) {
                            $line = fgetcsv($fp, 1000, ",");
                            $file_row_count = count(file(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form . '/' . $new_file_name, FILE_SKIP_EMPTY_LINES));
                            $count = count($line);
                            if ($count < 6 || $file_row_count < 2 or $file_row_count > 101) {
                                \Yii::$app->getSession()->setFlash('success', 'Invalid PAN Available csv');

                                $model->addError('csvfile', 'Invalid PAN Available csv .');
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
                                        array_push($model->rows, $line);
                                        $app_model = SrlmBcApplication::findOne(['application_id' => $line[0]]);
                                        if ($app_model == null) {
                                            $model->rows[$i][6] = "Application Id not found";
                                            $message .= 'Application Id not found';
                                            $model->error = true;
                                        } else {
                                            if ($app_model->status != 2) {
                                                $model->rows[$i][6] = "Application not selected";
                                                $message .= '<br/>Application not selected';
                                                $model->error = true;
                                            }
                                            if ($app_model->training_status != SrlmBcApplication::TRAINING_STATUS_PASS) {
                                                $model->rows[$i][6] = "Applicant not certified";
                                                $message .= '<br/>Applicant not certified';
                                                $model->error = true;
                                            }
                                            if (!in_array($app_model->reading_skills, [1, 2])) {
                                                $model->rows[$i][6] = "Applicant Ineligible";
                                                $message .= '<br/>Applicant Ineligible';
                                                $model->error = true;
                                            }
                                            if (in_array($app_model->urban_shg, [1])) {
                                                $model->rows[$i][6] = "Applicant Ineligible(GP Urban)";
                                                $message .= '<br/>Applicant Ineligible(GP Urban)';
                                                $model->error = true;
                                            }
                                            if ($app_model->blocked != '0') {
                                                $model->rows[$i][6] = "Applicant blocked";
                                                $message .= '<br/>Applicant blocked';
                                                $model->error = true;
                                            }
                                            if (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])) {
                                                if (!in_array($app_model->district_code, \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code'))) {
                                                    $model->rows[$i][6] = "access denied";
                                                    $message .= '<br/>access denied';
                                                    $model->error = true;
                                                }
                                            }
                                            $models = new \bc\modules\training\models\form\PancardStatusForm($app_model);
                                            $models->pan_card_status = $line[5];

                                            if (!$models->validate()) {
                                                $model_errors = $models->getErrors();
                                                if (isset($model_errors['pan_card_status'])) {
                                                    $message .= '<br/>' . $model_errors['pan_card_status'][0];
                                                    $model->error = true;
                                                }
                                            }
                                            if ($message != '') {
                                                $model->rows[$i][6] = ltrim($message, '<br/>');
                                            }
                                        }
                                    }
                                    $i++;
                                } while (($line = fgetcsv($fp, 1000, ",")) != FALSE);
                                if ($model->error == false) {
                                    $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                                    $file_model = new \bc\modules\selection\models\BcFiles();
                                    $file_model->master_partner_bank_id = isset($user_model->master_partner_bank_id) ? $user_model->master_partner_bank_id : 0;
                                    $file_model->file_name = $new_file_name;
                                    $file_model->label = $model->label;
                                    $file_model->form = \bc\modules\selection\models\BcFiles::FORM_PAN;
                                    $file_model->row_count = ($file_row_count - 1);
                                    $file_model->upload_by = Yii::$app->user->identity->id;
                                    $file_model->upload_datetime = new \yii\db\Expression('NOW()');
                                    $file_model->save();
                                    $model->fileid = $file_model->id;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $this->render('uploadcsv', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionImporthandheldmachine() {
        $user_model = Yii::$app->user->identity;
        $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
        $model = new \bc\modules\training\models\form\UploadCsvActionForm();
        $model->form = \bc\modules\selection\models\BcFiles::FORM_HANDHELD_MACHIN;
        $model->page_title = 'Upload CSV for Handheld Machine provided';
        $model->sample_csv_url = '/training/participants/sample?filename=handheld_machine_provided.csv';
        $model->master_partner_bank_id = (isset($user_model->master_partner_bank_id) and $user_model->master_partner_bank_id) ? $user_model->master_partner_bank_id : '';
        $searchModel = new BcFilesSearch();
        $searchModel->form = $model->form;
        $searchModel->status = 2;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 10);
        $rows = [];
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            if ($model->fileid and isset($_POST['continue'])) {
                $csv_model = \bc\modules\selection\models\BcFiles::findOne($model->fileid);
                if ($csv_model == null) {
                    return $this->redirect(['importhandheldmachine']);
                }
                if ($csv_model->status == 2) {
                    return $this->redirect(['importhandheldmachine']);
                }
                $fp = fopen(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $csv_model->form . '/' . $csv_model->file_name, 'r');
                $line = fgetcsv($fp, 1000, ",");
                $rows = [];
                $first_time = true;
                do {
                    if ($first_time == true) {
                        $first_time = false;
                        continue;
                    } else {
                        $app_model = SrlmBcApplication::findOne(['application_id' => $line[0]]);
                        $models = new \bc\modules\training\models\form\HandheldMachineForm($app_model);
                        $models->handheld_machine_status = $line[5];
                        if ($models->validate()) {
                            if ($models->handheld_machine_status) {
                                $models->bc_application_model->handheld_machine_status = $models->handheld_machine_status;
                                $models->bc_application_model->handheld_machine_by = Yii::$app->user->identity->id;
                                $models->bc_application_model->handheld_machine_date = new \yii\db\Expression('NOW()');
                                $models->bc_application_model->action_type = SrlmBcApplication::ACTION_TYPE_HANDHELD_MACHIN_PROVIDED;
                                $models->bc_application_model->save();
                            }
                        }
                    }
                } while (($line = fgetcsv($fp, 1000, ",")) != FALSE);
                $csv_model->status = 2;
                $csv_model->save();
                \Yii::$app->getSession()->setFlash('success', $csv_model->row_count . ' Record Uploaded Successfully');
                return $this->redirect(['importhandheldmachine']);
            } else {
                $model->csvfile = UploadedFile::getInstance($model, 'csvfile');
                if ($model->csvfile != NULL) {
                    $new_file_name = time() . '_' . $model->csvfile->baseName . '.' . $model->csvfile->extension;
                    if (!file_exists(Yii::$app->params['bcdatapath'] . '/tmp')) {
                        mkdir(Yii::$app->params['bcdatapath'] . '/tmp');
                        chmod(Yii::$app->params['bcdatapath'] . '/tmp', 0777);
                    }
                    if (!file_exists(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form)) {
                        mkdir(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form);
                        chmod(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form, 0777);
                    }
                    $TEMP_FILE = Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form . '/' . $new_file_name;
                    if ($model->csvfile->saveAs($TEMP_FILE)) {
                        chmod($TEMP_FILE, 0777);
                        $fp = fopen(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form . '/' . $new_file_name, 'r');
                        if ($fp) {
                            $line = fgetcsv($fp, 1000, ",");
                            $file_row_count = count(file(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form . '/' . $new_file_name, FILE_SKIP_EMPTY_LINES));
                            $count = count($line);
                            if ($count < 6 || $file_row_count < 2 or $file_row_count > 101) {
                                \Yii::$app->getSession()->setFlash('success', 'Invalid Handheld Machine provided csv');

                                $model->addError('csvfile', 'Invalid Handheld Machine provided csv .');
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
                                        array_push($model->rows, $line);
                                        $app_model = SrlmBcApplication::findOne(['application_id' => $line[0]]);
                                        if ($app_model == null) {
                                            $model->rows[$i][6] = "Application Id not found";
                                            $message .= 'Application Id not found';
                                            $model->error = true;
                                        } else {
                                            if ($app_model->status != 2) {
                                                $model->rows[$i][6] = "Application not selected";
                                                $message .= '<br/>Application not selected';
                                                $model->error = true;
                                            }
                                            if ($app_model->training_status != SrlmBcApplication::TRAINING_STATUS_PASS) {
                                                $model->rows[$i][6] = "Applicant not certified";
                                                $message .= '<br/>Applicant not certified';
                                                $model->error = true;
                                            }
                                            if (!in_array($app_model->reading_skills, [1, 2])) {
                                                $model->rows[$i][6] = "Applicant Ineligible";
                                                $message .= '<br/>Applicant Ineligible';
                                                $model->error = true;
                                            }
                                            if (in_array($app_model->urban_shg, [1])) {
                                                $model->rows[$i][6] = "Applicant Ineligible(GP Urban)";
                                                $message .= '<br/>Applicant Ineligible(GP Urban)';
                                                $model->error = true;
                                            }
                                            if ($app_model->blocked != '0') {
                                                $model->rows[$i][6] = "Applicant Blocked";
                                                $message .= '<br/>Applicant Blocked';
                                                $model->error = true;
                                            }
                                            if (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])) {
                                                if (!in_array($app_model->district_code, \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code'))) {
                                                    $model->rows[$i][6] = "access denied";
                                                    $message .= '<br/>access denied';
                                                    $model->error = true;
                                                }
                                            }
                                            $models = new \bc\modules\training\models\form\HandheldMachineForm($app_model);
                                            $models->handheld_machine_status = $line[5];

                                            if (!$models->validate()) {
                                                $model_errors = $models->getErrors();
                                                if (isset($model_errors['handheld_machine_status'])) {
                                                    $message .= '<br/>' . $model_errors['handheld_machine_status'][0];
                                                    $model->error = true;
                                                }
                                            }
                                            if ($message != '') {
                                                $model->rows[$i][6] = ltrim($message, '<br/>');
                                            }
                                        }
                                    }
                                    $i++;
                                } while (($line = fgetcsv($fp, 1000, ",")) != FALSE);
                                if ($model->error == false) {
                                    $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                                    $file_model = new \bc\modules\selection\models\BcFiles();
                                    $file_model->master_partner_bank_id = $user_model->master_partner_bank_id;
                                    $file_model->file_name = $new_file_name;
                                    $file_model->label = $model->label;
                                    $file_model->form = \bc\modules\selection\models\BcFiles::FORM_HANDHELD_MACHIN;
                                    $file_model->row_count = ($file_row_count - 1);
                                    $file_model->upload_by = Yii::$app->user->identity->id;
                                    $file_model->upload_datetime = new \yii\db\Expression('NOW()');
                                    $file_model->save();
                                    $model->fileid = $file_model->id;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $this->render('uploadcsv', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionImportbcpfms() {
        $user_model = Yii::$app->user->identity;
        $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
        $model = new \bc\modules\training\models\form\UploadCsvActionForm();
        $model->form = \bc\modules\selection\models\BcFiles::FORM_REPLACE_BC_PFMS;
        $model->page_title = 'Upload CSV for replace BC Beneficiaries code (Vender Code) ';
        $model->sample_csv_url = '/training/participants/sample?filename=bc_vender_code.csv';
        $model->master_partner_bank_id = 0;
        $searchModel = new BcFilesSearch();
        $searchModel->form = $model->form;
        $searchModel->status = 2;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 10);
        $rows = [];
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            if ($model->fileid and isset($_POST['continue'])) {
                $csv_model = \bc\modules\selection\models\BcFiles::findOne($model->fileid);
                if ($csv_model == null) {
                    return $this->redirect(['importbcpfms']);
                }
                if ($csv_model->status == 2) {
                    return $this->redirect(['importbcpfms']);
                }
                $fp = fopen(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $csv_model->form . '/' . $csv_model->file_name, 'r');
                $line = fgetcsv($fp, 1000, ",");
                $rows = [];
                $first_time = true;
                do {
                    if ($first_time == true) {
                        $first_time = false;
                        continue;
                    } else {
                        $app_model = SrlmBcApplication::findOne(['district_name' => $line[0], 'block_name' => $line[1], 'gram_panchayat_name' => $line[2], 'bc_beneficiaries_code' => $line[3]]);
                        $models = new \bc\modules\training\models\form\BCBeneficiariesForm($app_model);
                        $models->bc_beneficiaries_code = $line[4];
                        $models->repeat_bc_beneficiaries_code = $line[4];
                        if ($models->validate()) {
                            $models->bc_application_model->bc_beneficiaries_code = $models->bc_beneficiaries_code;
                            $models->bc_application_model->bc_beneficiaries_code_by = Yii::$app->user->identity->id;
                            $models->bc_application_model->bc_beneficiaries_code_date = new \yii\db\Expression('NOW()');
                            $models->bc_application_model->action_type = SrlmBcApplication::ACTION_TYPE_BC_BENEFICIARIES_CODE_REPLACE;

                            if ($models->bc_application_model->update()) {
                                $models->bc_payment_model->bc_application_id = $models->bc_application_model->id;
                                $models->bc_payment_model->srlm_bc_selection_user_id = $models->bc_application_model->srlm_bc_selection_user_id;
                                $models->bc_payment_model->district_code = $models->bc_application_model->district_code;
                                $models->bc_payment_model->block_code = $models->bc_application_model->block_code;
                                $models->bc_payment_model->gram_panchayat_code = $models->bc_application_model->gram_panchayat_code;
                                $models->bc_payment_model->save();
                            }
                        }
                    }
                } while (($line = fgetcsv($fp, 1000, ",")) != FALSE);
                $csv_model->status = 2;
                $csv_model->save();
                \Yii::$app->getSession()->setFlash('success', $csv_model->row_count . ' Record Uploaded Successfully');
                return $this->redirect(['importbcpfms']);
            } else {
                $model->csvfile = UploadedFile::getInstance($model, 'csvfile');
                if ($model->csvfile != NULL) {
                    $new_file_name = time() . '_' . $model->csvfile->baseName . '.' . $model->csvfile->extension;
                    if (!file_exists(Yii::$app->params['bcdatapath'] . '/tmp')) {
                        mkdir(Yii::$app->params['bcdatapath'] . '/tmp');
                        chmod(Yii::$app->params['bcdatapath'] . '/tmp', 0777);
                    }
                    if (!file_exists(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form)) {
                        mkdir(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form);
                        chmod(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form, 0777);
                    }
                    $TEMP_FILE = Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form . '/' . $new_file_name;
                    if ($model->csvfile->saveAs($TEMP_FILE)) {
                        chmod($TEMP_FILE, 0777);
                        $fp = fopen(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form . '/' . $new_file_name, 'r');
                        if ($fp) {
                            $line = fgetcsv($fp, 1000, ",");
                            $file_row_count = count(file(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $model->form . '/' . $new_file_name, FILE_SKIP_EMPTY_LINES));
                            $count = count($line);
                            if ($count < 6 || $file_row_count < 2 or $file_row_count > 101) {
                                \Yii::$app->getSession()->setFlash('success', 'Invalid CSV for replace BC Beneficiaries code (Vender Cod) ');

                                $model->addError('csvfile', 'Invalid CSV for replace BC Beneficiaries code (Vender Cod).');
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
                                        array_push($model->rows, $line);
                                        $app_model = SrlmBcApplication::findOne(['district_name' => $line[0], 'block_name' => $line[1], 'gram_panchayat_name' => $line[2], 'bc_beneficiaries_code' => $line[3]]);
                                        if ($app_model == null) {
                                            $model->rows[$i][6] = "Application Id not found";
                                            $message .= 'Application Id not found';
                                            $model->error = true;
                                        } else {
                                            if ($app_model->status != 2) {
                                                $model->rows[$i][6] = "Application not selected";
                                                $message .= '<br/>Application not selected';
                                                $model->error = true;
                                            }
                                            if ($app_model->training_status != SrlmBcApplication::TRAINING_STATUS_PASS) {
                                                $model->rows[$i][6] = "Applicant not certified";
                                                $message .= '<br/>Applicant not certified';
                                                $model->error = true;
                                            }
                                            if (!in_array($app_model->reading_skills, [1, 2])) {
                                                $model->rows[$i][6] = "Applicant Ineligible";
                                                $message .= '<br/>Applicant Ineligible';
                                                $model->error = true;
                                            }
                                            if (in_array($app_model->urban_shg, [1])) {
                                                $model->rows[$i][6] = "Applicant Ineligible(GP Urban)";
                                                $message .= '<br/>Applicant Ineligible(GP Urban)';
                                                $model->error = true;
                                            }
                                            if ($app_model->blocked != '0') {
                                                $model->rows[$i][6] = "Applicant Blocked";
                                                $message .= '<br/>Applicant Blocked';
                                                $model->error = true;
                                            }
                                            if (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                                                if (!in_array($app_model->district_code, \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code'))) {
                                                    $model->rows[$i][6] = "access denied";
                                                    $message .= '<br/>access denied';
                                                    $model->error = true;
                                                }
                                            }
                                            $models = new \bc\modules\training\models\form\BCBeneficiariesForm($app_model);
                                            $models->bc_beneficiaries_code = $line[4];
                                            $models->repeat_bc_beneficiaries_code = $line[4];

                                            if (!$models->validate()) {
                                                $model_errors = $models->getErrors();
                                                if (isset($model_errors['bc_beneficiaries_code'])) {
                                                    $message .= '<br/>' . $model_errors['bc_beneficiaries_code'][0];
                                                    $model->error = true;
                                                }
                                            }
                                            if ($message != '') {
                                                $model->rows[$i][6] = ltrim($message, '<br/>');
                                            }
                                        }
                                    }
                                    $i++;
                                } while (($line = fgetcsv($fp, 1000, ",")) != FALSE);
                                if ($model->error == false) {
                                    $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                                    $file_model = new \bc\modules\selection\models\BcFiles();
                                    $file_model->master_partner_bank_id = 0;
                                    $file_model->file_name = $new_file_name;
                                    $file_model->label = $model->label;
                                    $file_model->form = \bc\modules\selection\models\BcFiles::FORM_REPLACE_BC_PFMS;
                                    $file_model->row_count = ($file_row_count - 1);
                                    $file_model->upload_by = Yii::$app->user->identity->id;
                                    $file_model->upload_datetime = new \yii\db\Expression('NOW()');
                                    $file_model->save();
                                    $model->fileid = $file_model->id;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $this->render('uploadbcbencodecsv', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionPdf($id) {
        date_default_timezone_set("Asia/Calcutta");
        $this->layout = 'pdf';

        $model = $this->findModelbc($id);
        if (!in_array($model->reading_skills, [1, 2])) {
            return $this->redirect(['/training/participants']);
        }
        if (in_array($model->urban_shg, [1])) {
            return $this->redirect(['/training/participants']);
        }
        if ($model->blocked != '0') {
            return $this->redirect(['/training/participants']);
        }
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 12,
            'default_font' => 'freesans',
            'margin_header' => 5,
            'margin-top' => 0,
            'margin_footer' => 0,
            'mode' => 'utf-8',
            'format' => 'A4'
        ]);

        $mpdf->SetHeader('<table style="width:100%;vertical-align: top;border:none">
            <tr>
            <td style="text-align:center;vertical-align: top;border:none;font-size:16px;font-weight:bold">उत्तर प्रदेश राज्य ग्रामीण आजीविका मिशन, ग्राम्य विकास विभाग, उत्तर प्रदेश के अंतर्गत तैनात की जाने वाली 58,000 ग्राम पंचायत स्तरीय बिज़नेस करेस्पॉन्डेंट सखी का पुलिस विभाग द्वारा सत्यापन का प्रारूप&nbsp;</td>
            </tr>
           </table>');
        //$mpdf->setFooter('{PAGENO} / {nb}');
        if ($mpdf->PageNo() == 1) {
            
        }
        //return $this->renderPartial('_pdf', ['model' => $model]);
        $content = $this->renderPartial('_pdf', ['model' => $model]);

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
        $mpdf->Output($model->name . '.pdf', 'D');
        exit;
    }

    public function actionRevert($bcid) {
        $bd_model = $this->findModelbc($bcid);
        if ($bd_model->blocked != '0') {
            return $this->redirect(['/training/participants/verification?RsetisBatchParticipantsSearch[district_code]=' . $bd_model->district_code . '&RsetisBatchParticipantsSearch[block_code]=' . $bd_model->block_code]);
        }
        if ($bd_model->bc_shg_funds_status == null and (in_array($bd_model->bc_bank, [2]) and in_array($bd_model->shg_bank, [2]))) {

            $model = new \bc\modules\training\models\form\RevertBankVerificationForm($bd_model);
            $this->performAjaxValidation($model);
            if ($model->load(Yii::$app->request->post())) {
                if (in_array($model->application_model->bc_bank, [2, 3])) {
                    $model->application_model->bc_bank = 1;

                    $model->application_model->bc_bank_verify_date = new \yii\db\Expression('NOW()');
                }
                if (in_array($model->application_model->shg_bank, [2, 3])) {
                    $model->application_model->shg_bank = 1;

                    $model->application_model->bc_shg_bank_verify_date = new \yii\db\Expression('NOW()');
                }
                $model->application_model->action_type = SrlmBcApplication::ACTION_TYPE_BANK_VERIFICATION_REVERT;
                if ($model->application_model->save()) {
                    \Yii::$app->getSession()->setFlash('success', 'Revert  successfully');
                    return $this->redirect(['/training/participants/verification?RsetisBatchParticipantsSearch[district_code]=' . $model->application_model->district_code . '&RsetisBatchParticipantsSearch[block_code]=' . $model->application_model->block_code]);
                } else {
                    
                }
            }

            if (\Yii::$app->request->isAjax) {

                return $this->renderAjax('_revertform', [
                            'model' => $model,
                ]);
            } else {
                return $this->render('_revertform', [
                            'model' => $model,
                ]);
            }
        } else {
            return $this->redirect(['/training/participants/verification?RsetisBatchParticipantsSearch[district_code]=' . $bd_model->district_code . '&RsetisBatchParticipantsSearch[block_code]=' . $bd_model->block_code]);
        }
    }

    public function actionBeneficiariesrevert($bcid) {
        $bd_model = $this->findModelbc($bcid);
        if ($bd_model->blocked != '0') {
            return $this->redirect(['/training/participants/pfmspayment?RsetisBatchParticipantsSearch[district_code]=' . $bd_model->district_code . '&RsetisBatchParticipantsSearch[block_code]=' . $bd_model->block_code]);
        }
        $model = new \bc\modules\training\models\form\RevertBeneficiariesCodeForm($bd_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            $model->application_model->pfms_maped_status = null;
            $model->application_model->beneficiaries_code = null;
            $model->application_model->revert_beneficiaries_code_by = Yii::$app->user->identity->id;
            $model->application_model->revert_beneficiaries_reason = $model->revert_beneficiaries_reason;
            $model->application_model->revert_beneficiaries_code_datetime = new \yii\db\Expression('NOW()');
            $model->application_model->action_type = SrlmBcApplication::ACTION_TYPE_PFMS_BENEFICIARIES_CODE_REVERT;
            if ($model->application_model->save()) {
                \Yii::$app->getSession()->setFlash('success', 'Revert  successfully');
                return $this->redirect(['/training/participants/pfmspayment?RsetisBatchParticipantsSearch[district_code]=' . $model->application_model->district_code . '&RsetisBatchParticipantsSearch[block_code]=' . $model->application_model->block_code]);
            } else {
                
            }
        }

        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_revertbeneficiariesform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_revertbeneficiariesform', [
                        'model' => $model,
            ]);
        }
    }

    public function actionBcbeneficiariesrevert($bcid) {
        $bd_model = $this->findModelbc($bcid);
        if ($bd_model->blocked != '0') {
            return $this->redirect(['/training/participants/bcpfmsmapping']);
        }
        $model = new \bc\modules\training\models\form\RevertBcBeneficiariesCodeForm($bd_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            $model->application_model->bc_beneficiaries_code = null;
            $model->application_model->revert_bc_beneficiaries_code_by = Yii::$app->user->identity->id;
            $model->application_model->revert_bc_beneficiaries_reason = $model->revert_bc_beneficiaries_reason;
            $model->application_model->revert_bc_beneficiaries_code_datetime = new \yii\db\Expression('NOW()');
            $model->application_model->action_type = SrlmBcApplication::ACTION_TYPE_BC_PFMS_BENEFICIARIES_CODE_REVERT;
            if ($model->application_model->save()) {
                \Yii::$app->getSession()->setFlash('success', 'Revert  successfully');
                return $this->redirect(['/training/participants/bcpfmsmapping?RsetisBatchParticipantsSearch[district_code]=' . $model->application_model->district_code . '&RsetisBatchParticipantsSearch[block_code]=' . $model->application_model->block_code]);
                //return $this->redirect(['/training/participants/bcpfmsmapping']);
            } else {
                
            }
        }

        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_revertbcbeneficiariesform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_revertbcbeneficiariesform', [
                        'model' => $model,
            ]);
        }
    }

    public function actionMappfmsrevert($bcid) {
        $bd_model = $this->findModelbc($bcid);
        if ($bd_model->blocked != '0') {
            return $this->redirect(['/training/participants/pfmspayment']);
        }
        if ($bd_model->urban_shg == '0' and $bd_model->bc_shg_funds_status == 1 and $bd_model->bc_support_funds_received == null) {
            
        } else {
            return $this->redirect(['/training/participants/pfmspayment']);
        }
        $model = new \bc\modules\training\models\form\RevertFundsTransferForm($bd_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            $model->application_model->bc_shg_funds_status = 0;
            $model->application_model->bc_shg_funds_amount = null;
            $model->application_model->revert_bc_shg_funds_by = Yii::$app->user->identity->id;
            $model->application_model->revert_bc_shg_funds_date = new \yii\db\Expression('NOW()');
            $model->application_model->action_type = SrlmBcApplication::ACTION_TYPE_REVERT_FUNDS_TRANSFER;
            if ($model->shg_model != null) {

                $model->shg_model->bc_shg_funds_status = 0;
                $model->shg_model->bc_shg_funds_amount = null;

                $model->shg_model->update();
            }
            if ($model->application_model->save()) {
                \Yii::$app->getSession()->setFlash('success', 'Revert  successfully');
                return $this->redirect(['/training/participants/pfmspayment?RsetisBatchParticipantsSearch[district_code]=' . $model->application_model->district_code . '&RsetisBatchParticipantsSearch[block_code]=' . $model->application_model->block_code]);
            } else {
                
            }
        }

        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_mappfmsrevertform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_mappfmsrevertform', [
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

    public function actionImportfile($fileid) {
        $file_model = BcFiles::findOne($fileid);
        header('Content-type: application/csv');
        header('Content-Disposition: attachment;filename="' . $file_model->file_name . '"');
        readfile(Yii::$app->params['bcdatapath'] . '/tmp' . '/' . $file_model->form . '/' . $file_model->file_name);
        exit();
    }

    public function actionUnwilling($bcid) {
        $bc_model = $this->findModelbc($bcid);
        if (isset($bc_model) and $bc_model->bc_unwilling_bank == '1') {
            return $this->redirect(['/training/participants/certified']);
        }
        if (isset($bc_model) and $bc_model->bc_unwilling_bank == '0') {
            return $this->redirect(['/training/participants/certified']);
        }
        if (!in_array($bc_model->reading_skills, [1, 2])) {
            return $this->redirect(['/training/participants/certified']);
        }
        if (in_array($bc_model->urban_shg, [1])) {
            return $this->redirect(['/training/participants/certified']);
        }
//        if ($bc_model->blocked != '0') {
//            return $this->redirect(['/training/participants/certified']);
//        }
        $model = new \bc\modules\selection\models\form\UnwillingBankNewForm($bc_model);
//        print_r($model->unwilling_reason);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {
            return $this->redirect(['/training/participants/certified']);
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_bank_unwilling_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_bank_unwilling_form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionCdounwilling($bcid) {
        $bc_model = $this->findModelbc($bcid);
        if (isset($bc_model) and $bc_model->bc_unwilling_bank != '1') {
            \Yii::$app->getSession()->setFlash('error', "Unwilling by Bank not done");
            $js = "window.location.href = '/training/certified/cdounwilling'";
            $this->getView()->registerJs($js);
            return $this->redirect(['/training/certified/cdounwilling']);
        }
        if (isset($bc_model) and $bc_model->bc_unwilling_bc != '1') {
            \Yii::$app->getSession()->setFlash('error', "Unwilling by BC not done");
            $js = "window.location.href = '/training/certified/cdounwilling'";
            $this->getView()->registerJs($js);
            return $this->redirect(['/training/certified/cdounwilling']);
        }
        if (isset($bc_model) and $bc_model->bc_unwilling_cdo == '1') {
            \Yii::$app->getSession()->setFlash('error', "Unwilling by CDO done");
            $js = "window.location.href = '/training/certified/cdounwilling'";
            $this->getView()->registerJs($js);
            return $this->redirect(['/training/certified/cdounwilling']);
        }
        $model = new \bc\modules\selection\models\form\UnwillingCdoNewForm($bc_model);
//        print_r($model->unwilling_reason);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {
            return $this->redirect(['/training/certified/cdounwilling']);
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_cdo_unwilling_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_cdo_unwilling_form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpsrlmunwilling($bcid) {
        $bc_model = $this->findModelbc($bcid);
        if (isset($bc_model) and $bc_model->bc_unwilling_bank != '1') {
            \Yii::$app->getSession()->setFlash('error', "Unwilling by Bank not done");
            $js = "window.location.href = '/training/certified/upsrlmunwilling'";
            $this->getView()->registerJs($js);
            return $this->redirect(['/training/certified/upsrlmunwilling']);
        }
        if (isset($bc_model) and $bc_model->bc_unwilling_bc == '0') {
            \Yii::$app->getSession()->setFlash('error', "Unwilling by BC not done");
            $js = "window.location.href = '/training/certified/upsrlmunwilling'";
            $this->getView()->registerJs($js);
            return $this->redirect(['/training/certified/upsrlmunwilling']);
        }
        if (isset($bc_model) and $bc_model->bc_unwilling_cdo != '1') {
            \Yii::$app->getSession()->setFlash('error', "Unwilling by CDO not done");
            $js = "window.location.href = '/training/certified/upsrlmunwilling'";
            $this->getView()->registerJs($js);
            return $this->redirect(['/training/certified/upsrlmunwilling']);
        }
        $model = new \bc\modules\selection\models\form\UnwillingUpsrlmNewForm($bc_model);
//        print_r($model->unwilling_reason);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {
            return $this->redirect(['/training/certified/upsrlmunwilling']);
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_upsrlm_unwilling_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_upsrlm_unwilling_form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionChangebatch($participantid) {
        $participant_model = $this->findModel($participantid);
        if (!in_array($participant_model->training_status, [2])) {
            return $this->redirect(['/training/training/view?trainingid=' . $participant_model->rsetis_center_training_id]);
        }
        if (in_array($participant_model->participant->urban_shg, [1])) {
            return $this->redirect(['/training/training/view?trainingid=' . $participant_model->rsetis_center_training_id]);
        }
        if ($participant_model->participant->blocked != '0') {

            return $this->redirect(['/training/training/view?trainingid=' . $participant_model->rsetis_center_training_id]);
        }
        $model = new \bc\modules\training\models\form\ChangeBatchForm($participant_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {

                \Yii::$app->getSession()->setFlash('success', 'Change Batch successfully');
                return $this->redirect(['/training/training/view?trainingid=' . $model->participant_model->rsetis_center_training_id]);
            } else {
                
            }
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_changebatchform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_changebatchform', [
                        'model' => $model,
            ]);
        }
    }

    public function actionIneligible($bcid) {
        $bc_model = $this->findModelbc($bcid);
        $p_model = RsetisBatchParticipants::findOne(['bc_application_id' => $bcid]);
        if (!in_array($bc_model->training_status, [0, 1, 2])) {
            return $this->redirect(['/training/training/view?trainingid=' . $p_model->rsetis_center_training_id]);
        }
        if ($bc_model->blocked != '0') {
            return $this->redirect(['/training/training/view?trainingid=' . $p_model->rsetis_center_training_id]);
        }
        $model = new \bc\modules\selection\models\form\IneligibleRsetisForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {
            return $this->redirect(['/training/training/view?trainingid=' . $p_model->rsetis_center_training_id]);
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

    public function actionNotification($bcid) {
        $bc_model = $this->findModelbc($bcid);
        $searchModel = new \bc\models\NotificationLogSearch();
        $searchModel->user_id = $bc_model->srlm_bc_selection_user_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('bc_notification', [
                        'model' => $bc_model,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('bc_notification', [
                        'model' => $bc_model,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionShg($gram_panchayat_code) {
        $searchModel = new \cbo\models\ShgSearch();
        $searchModel->gram_panchayat_code = $gram_panchayat_code;
        $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);

        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('shg', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('shg', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionBlocked($bcid) {
        $bc_model = $this->findModelbc($bcid);
        if ($bc_model->blocked != '0') {
            \Yii::$app->getSession()->setFlash('success', 'Already BC Blocked');
            return $this->redirect(['/training/participants/verification?RsetisBatchParticipantsSearch[district_code]=' . $bc_model->district_code . '&RsetisBatchParticipantsSearch[block_code]=' . $bc_model->block_code]);
        }
        $model = new \bc\modules\selection\models\form\BCBlockedForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            $model->bc_model->blocked = $model->blocked;
            $model->bc_model->blocked_by = Yii::$app->user->identity->id;
            $model->bc_model->blocked_date = new \yii\db\Expression('NOW()');
            $model->bc_model->action_type = SrlmBcApplication::ACTION_TYPE_BC_BLOCKED;
            if ($model->bc_model->save()) {
                \Yii::$app->getSession()->setFlash('success', 'BC Blocked  successfully');
                return $this->redirect(['/training/participants/verification?RsetisBatchParticipantsSearch[district_code]=' . $model->bc_model->district_code . '&RsetisBatchParticipantsSearch[block_code]=' . $model->bc_model->block_code]);
            } else {
                
            }
        }

        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_blockedform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_blockedform', [
                        'model' => $model,
            ]);
        }
    }

    protected function findModel($id) {
        if (($model = RsetisBatchParticipants::find()->where(['id' => $id])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
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
