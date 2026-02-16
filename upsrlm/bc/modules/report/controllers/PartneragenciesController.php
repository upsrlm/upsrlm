<?php

namespace bc\modules\report\controllers;

use Yii;
use yii\web\Controller;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\training\models\RsetisBatchParticipantsSearch;
use bc\modules\training\models\RsetisCenterTraining;
use bc\modules\training\models\RsetisCenterTrainingSearch;
use bc\modules\report\models\form\ReportSearchForm;
use bc\models\transaction\BcTransactionSearch;
use common\models\master\MasterRole;

/**
 * PartneragenciesController for the `report` module
 */
class PartneragenciesController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index','onboarding','validateonboarding','performance','bob','fino','nearby','manipal','airtel','ptm','sbi'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','performance','bob','fino','nearby','manipal','airtel','ptm','sbi'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $searchModel = new ReportSearchForm(Yii::$app->request->queryParams);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $bank_user = \common\models\dynamicdb\bc\User::findOne($searchModel->bc_partner_bank);

        $searchModel1 = new \bc\models\master\MasterGramPanchayatSearch();
        $dataProvider1 = $searchModel1->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
//        $searchModel1a = new \bc\models\master\MasterGramPanchayatSearch();
//        $dataProvider1a = $searchModel1a->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
//        $dataProvider1a->query->andWhere(['=', 'sbi_status', '1']);
//        $searchModel1b = new \bc\models\master\MasterGramPanchayatSearch();
//        $dataProvider1b = $searchModel1->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
//        $dataProvider1b->query->andWhere(['=', 'sbi_status', '2']);
//        $searchModels = new SrlmBcApplicationSearch();
//        $dataProvider2a = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
//        $dataProvider2a->query->andWhere(['!=', 'srlm_bc_application.form_number', '0']);
//        $dataProvider2a->query->andWhere(['=', 'srlm_bc_application.form_number', '6']);
//        $dataProvider2a->query->andWhere(['=', 'srlm_bc_application.gender', '2']);
//        $dataProvider2a->query->andWhere(['srlm_bc_application.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
//        // $dataProvider2a->query->andWhere(['not in', 'srlm_bc_application.selection_by', [15]]);
//        $dataProvider2a->query->addOrderBy("first_name asc");
//
//        $searchModel2 = new \bc\modules\selection\models\SrlmBcApplicationSearch();
//
//        $dataProvider2 = $searchModel2->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
//        $dataProvider2->query->andWhere(['!=', 'srlm_bc_application.form_number', '0']);
//        $dataProvider2->query->andWhere(['=', 'srlm_bc_application.form_number', '6']);
//        $dataProvider2->query->andWhere(['=', 'srlm_bc_application.gender', '2']);
//        //$dataProvider2->query->andWhere(['=', 'blocked', '0']);
//        $dataProvider2->query->andWhere(['srlm_bc_application.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
//        // $dataProvider2->query->andWhere(['not in', 'srlm_bc_application.selection_by', [15]]);
//        $dataProvider2->query->addOrderBy("first_name asc");

        $searchModel3 = new RsetisBatchParticipantsSearch();
        $searchModel3->show_blocked = 0;
        $dataProvider3 = $searchModel3->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider3->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider3->query->andWhere(['srlm_bc_application.blocked' => 0]);
//        $searchModel3a = new RsetisBatchParticipantsSearch();
//        $searchModel3a->show_blocked = 0;
//        $dataProvider3a = $searchModel3->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
//        $dataProvider3a->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
//        $dataProvider3a->query->andWhere(['!=', 'srlm_bc_application.blocked', '0']);
        $searchModel4 = new RsetisBatchParticipantsSearch();
        $searchModel4->show_blocked = 1;
        $searchModel4->district_code = $searchModel->district_code;
        $dataProvider4 = $searchModel4->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider4->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider4->query->andWhere(['srlm_bc_application.bc_shg_funds_status' => 1]);
//        $searchModel4a = new RsetisBatchParticipantsSearch();
//        $searchModel4a->show_blocked = 1;
//        $searchModel4a->district_code = $searchModel->district_code;
//        $dataProvider4a = $searchModel4a->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
//        $dataProvider4a->query->andWhere(['srlm_bc_application.bc_shg_funds_status' => 1]);
        
       
//        $searchModel5 = new RsetisBatchParticipantsSearch();
//        $searchModel5->show_blocked = 1;
//        $searchModel5->district_code = $searchModel->district_code;
//        $dataProvider5 = $searchModel5->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
//        $dataProvider5->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
//        $dataProvider5->query->andWhere(['srlm_bc_application.pan_card_status' => 1]);
//        $dataProvider5->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
        $searchModel5a = new RsetisBatchParticipantsSearch();
        $searchModel5a->show_blocked = 1;
        $searchModel5a->district_code = $searchModel->district_code;
        $dataProvider5a = $searchModel5a->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider5a->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider5a->query->andWhere(['srlm_bc_application.pan_photo_upload' => 1]);
        $dataProvider5a->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
        $searchModel6 = new RsetisBatchParticipantsSearch();
        $searchModel6->show_blocked = 1;
        $searchModel6->district_code = $searchModel->district_code;
        $dataProvider6 = $searchModel6->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        //$dataProvider6->query->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_ONBOARDING]]);
        $dataProvider6->query->andWhere(['srlm_bc_application.onboarding' => 1]);
        $dataProvider6->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
        $searchModel7 = new RsetisBatchParticipantsSearch();
        $searchModel7->show_blocked = 1;
        $searchModel7->district_code = $searchModel->district_code;
        $dataProvider7 = $searchModel7->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider7->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider7->query->andWhere(['srlm_bc_application.handheld_machine_status' => 1]);
        $dataProvider7->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
        $searchModel8 = new RsetisBatchParticipantsSearch();
        $searchModel8->show_blocked = 1;
        $searchModel8->district_code = $searchModel->district_code;
        $dataProvider8 = $searchModel7->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider8->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider8->query->andWhere(['srlm_bc_application.bc_support_funds_received' => 1]);
        $dataProvider8->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
        $searchModel9 = new RsetisBatchParticipantsSearch();
        $searchModel9->show_blocked = 1;
        $searchModel9->district_code = $searchModel->district_code;
        $dataProvider9 = $searchModel7->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider9->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider9->query->andWhere(['srlm_bc_application.bc_handheld_machine_recived' => 1]);
        $dataProvider9->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
//        $searchModel10 = new RsetisBatchParticipantsSearch();
//        $searchModel10->show_blocked = 1;
//        $searchModel10->district_code = $searchModel->district_code;
//        $dataProvider10 = $searchModel7->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
//        $dataProvider10->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
//        $dataProvider10->query->andWhere(['not', ['srlm_bc_application.bankidbc' => null]]);
//        $dataProvider10->query->andWhere(['srlm_bc_application.urban_shg' => 0]);

        $searchModel->bc_partner_bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel11bc = new \bc\modules\transaction\models\summary\BcTransactionBcSummarySearch();
        $dataProvider11bc = $searchModel11bc->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $searchModel4b = new RsetisBatchParticipantsSearch();
        $searchModel4b->show_blocked = 0;
        $searchModel4b->district_code = $searchModel->district_code;
        $dataProvider4b = $searchModel4b->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider4b->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING]);
        $dataProvider4b->query->andWhere(['srlm_bc_application.bc_shg_funds_status' => 1]);
        $dataProvider = [];
        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";
        if ($button_type == "1") {
            $dataProvider = $dataProvider1;
        } elseif ($button_type == "2") {
            $dataProvider = $dataProvider2;
        } elseif ($button_type == "2a") {
            $dataProvider = $dataProvider2a;
        } elseif ($button_type == "3") {
            $dataProvider = $dataProvider3;
        } elseif ($button_type == "3a") {
            $dataProvider = $dataProvider3a;
        } elseif ($button_type == "4") {
            $dataProvider = $dataProvider4;
        }elseif ($button_type == "4b") {
            $dataProvider = $dataProvider4b;
        } elseif ($button_type == "5") {
            $dataProvider = $dataProvider5;
        } elseif ($button_type == "5a") {
            $dataProvider = $dataProvider5a;
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
                    
                    'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4,
                    'dataProvider4b' => $dataProvider4b,
                    'dataProvider5a' => $dataProvider5a,
                    'dataProvider6' => $dataProvider6,
                    'dataProvider7' => $dataProvider7,
                    'dataProvider8' => $dataProvider8,
                    'dataProvider9' => $dataProvider9,
                    'dataProvider11bc' => $dataProvider11bc,
        ]);
    }

    public function actionOnboarding($participantid) {
        $participant_model = $this->findModel($participantid);
        if ($participant_model->training_status != SrlmBcApplication::TRAINING_STATUS_PASS) {
            return $this->redirect(['/report/partneragencies']);
        }
        $model = new \bc\modules\training\models\form\OnboardingForm($participant_model->participant);
        $model->action_url = '/report/partneragencies/onboarding?participantid=' . $participantid;
        $model->action_validate_url = '/report/partneragencies/validateonboarding?participantid=' . $participantid;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                //if ($model->onboarding) {
                //    $model->bc_application_model->training_status = SrlmBcApplication::TRAINING_STATUS_ONBOARDING;
                //    $participant_model->training_status = SrlmBcApplication::TRAINING_STATUS_ONBOARDING;
                //}
                $model->bc_application_model->onboarding = $model->onboarding;
                $model->bc_application_model->onboarding_by = Yii::$app->user->identity->id;
                $model->bc_application_model->onboarding_date_time = \Yii::$app->formatter->asDatetime($model->onboarding_date_time, "php:Y-m-d");
                if ($participant_model->update() and $model->bc_application_model->update()) {
                    if (Yii::$app->request->isAjax) {
                        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ['success' => true];
                    } else {
                        return $this->redirect(['/report/partneragencies']);
                    }
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

    public function actionValidateonboarding($participantid) {
        $participant_model = $this->findModel($participantid);
        $model = new \bc\modules\training\models\form\OnboardingForm($participant_model->participant);
        $this->performAjaxValidation($model);
    }

    public function actionValidatepancard($participantid) {
        $participant_model = $this->findModel($participantid);
        $model = new \bc\modules\training\models\form\PancardStatusForm($participant_model->participant);
        $this->performAjaxValidation($model);
    }

    public function actionValidatehandheldmachine($participantid) {
        $participant_model = $this->findModel($participantid);
        $model = new \bc\modules\training\models\form\HandheldMachineForm($participant_model->participant);
        $this->performAjaxValidation($model);
    }

    public function actionPancard($participantid) {
        $participant_model = $this->findModel($participantid);
        if (!in_array($participant_model->training_status, SrlmBcApplication::TRAINING_STATUS_PASS)) {
            return $this->redirect(['/report/partneragencies']);
        }
        $model = new \bc\modules\training\models\form\PancardStatusForm($participant_model->participant);
        $model->action_url = '/report/partneragencies/pancard?participantid=' . $participantid;
        $model->action_validate_url = '/report/partneragencies/validatepancard?participantid=' . $participantid;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {

                $model->bc_application_model->pan_card_status = $model->pan_card_status;
                $model->bc_application_model->pan_card_status_by = Yii::$app->user->identity->id;
                $model->bc_application_model->pan_card_status_date = new \yii\db\Expression('NOW()');
                if ($participant_model->update() and $model->bc_application_model->update()) {
                    if (Yii::$app->request->isAjax) {
                        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ['success' => true];
                    } else {
                        return $this->redirect(['/report/partneragencies']);
                    }
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
        if (!in_array($participant_model->training_status, SrlmBcApplication::TRAINING_STATUS_PASS)) {
            return $this->redirect(['/report/partneragencies']);
        }
        $model = new \bc\modules\training\models\form\HandheldMachineForm($participant_model->participant);
        $model->action_url = '/report/partneragencies/handheldmachine?participantid=' . $participantid;
        $model->action_validate_url = '/report/partneragencies/validatehandheldmachine?participantid=' . $participantid;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {

                $model->bc_application_model->handheld_machine_status = $model->handheld_machine_status;
                $model->bc_application_model->handheld_machine_by = Yii::$app->user->identity->id;
                $model->bc_application_model->handheld_machine_date = new \yii\db\Expression('NOW()');
                if ($participant_model->update() and $model->bc_application_model->update()) {
                    if (Yii::$app->request->isAjax) {
                        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ['success' => true];
                    } else {
                        return $this->redirect(['/report/partneragencies']);
                    }
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
    public function actionPerformance() {

        $graph = new \bc\models\report\Graph();
        $bc_certified = $graph->getBankparformanc(1, 0);
        $bc_fund = $graph->getBankparformanc(2, 0);
        $bc_handheldmachine = $graph->getBankparformanc(3, 0);
        $bc_op = $graph->getBankparformanc(4, 0);
        
        return $this->render('performance', [
                    'bc_certified' => $bc_certified,
                    'bc_fund' => $bc_fund,
                    'bc_handheldmachine' => $bc_handheldmachine,
                    'bc_op' => $bc_op,
        ]);
    }
    public function actionBob() {

        $graph = new \bc\models\report\Graph();
        $bc_certified = $graph->getBankparformanc(1, 1);
        $bc_fund = $graph->getBankparformanc(2, 1);
        $bc_handheldmachine = $graph->getBankparformanc(3, 1);
        $bc_op = $graph->getBankparformanc(4, 1);
        
        return $this->render('bob', [
                    'bc_certified' => $bc_certified,
                    'bc_fund' => $bc_fund,
                    'bc_handheldmachine' => $bc_handheldmachine,
                    'bc_op' => $bc_op,
        ]);
    }
    public function actionFino() {

        $graph = new \bc\models\report\Graph();
        $bc_certified = $graph->getBankparformanc(1, 2);
        $bc_fund = $graph->getBankparformanc(2, 2);
        $bc_handheldmachine = $graph->getBankparformanc(3, 2);
        $bc_op = $graph->getBankparformanc(4, 2);
        
        return $this->render('fino', [
                    'bc_certified' => $bc_certified,
                    'bc_fund' => $bc_fund,
                    'bc_handheldmachine' => $bc_handheldmachine,
                    'bc_op' => $bc_op,
        ]);
    }
    public function actionNearby() {

        $graph = new \bc\models\report\Graph();
        $bc_certified = $graph->getBankparformanc(1, 3);
        $bc_fund = $graph->getBankparformanc(2, 3);
        $bc_handheldmachine = $graph->getBankparformanc(3, 3);
        $bc_op = $graph->getBankparformanc(4, 3);
        
        return $this->render('nearby', [
                    'bc_certified' => $bc_certified,
                    'bc_fund' => $bc_fund,
                    'bc_handheldmachine' => $bc_handheldmachine,
                    'bc_op' => $bc_op,
        ]);
    }
    public function actionManipal() {

        $graph = new \bc\models\report\Graph();
        $bc_certified = $graph->getBankparformanc(1, 4);
        $bc_fund = $graph->getBankparformanc(2, 4);
        $bc_handheldmachine = $graph->getBankparformanc(3, 4);
        $bc_op = $graph->getBankparformanc(4, 4);
        
        return $this->render('manipal', [
                    'bc_certified' => $bc_certified,
                    'bc_fund' => $bc_fund,
                    'bc_handheldmachine' => $bc_handheldmachine,
                    'bc_op' => $bc_op,
        ]);
    }
    public function actionAirtel() {

        $graph = new \bc\models\report\Graph();
        $bc_certified = $graph->getBankparformanc(1, 5);
        $bc_fund = $graph->getBankparformanc(2, 5);
        $bc_handheldmachine = $graph->getBankparformanc(3, 5);
        $bc_op = $graph->getBankparformanc(4, 5);
        
        return $this->render('airtel', [
                    'bc_certified' => $bc_certified,
                    'bc_fund' => $bc_fund,
                    'bc_handheldmachine' => $bc_handheldmachine,
                    'bc_op' => $bc_op,
        ]);
    }
    public function actionPtm() {

        $graph = new \bc\models\report\Graph();
        $bc_certified = $graph->getBankparformanc(1, 6);
        $bc_fund = $graph->getBankparformanc(2, 6);
        $bc_handheldmachine = $graph->getBankparformanc(3, 6);
        $bc_op = $graph->getBankparformanc(4, 6);
        
        return $this->render('ptm', [
                    'bc_certified' => $bc_certified,
                    'bc_fund' => $bc_fund,
                    'bc_handheldmachine' => $bc_handheldmachine,
                    'bc_op' => $bc_op,
        ]);
    }
    public function actionSbi() {

        $graph = new \bc\models\report\Graph();
        $bc_certified = $graph->getBankparformanc(1, 7);
        $bc_fund = $graph->getBankparformanc(2, 7);
        $bc_handheldmachine = $graph->getBankparformanc(3, 7);
        $bc_op = $graph->getBankparformanc(4, 7);
        
        return $this->render('sbi', [
                    'bc_certified' => $bc_certified,
                    'bc_fund' => $bc_fund,
                    'bc_handheldmachine' => $bc_handheldmachine,
                    'bc_op' => $bc_op,
        ]);
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
