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
use bc\models\transaction\BcTransactionSearch;
use bc\modules\report\models\form\ReportSearchForm;
use common\models\master\MasterRole;

/**
 * DashboardController for the `report` module
 */
class DashboardController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
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
         if (in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_RBI])) {
            return \Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc'] . '/report/bc/ac194n');
            exit;
        }
        if (in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK, MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
            return \Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc'] . '/report/cumulative/pendencyd');
            exit;
        }
        if (in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_BANK_DISTRICT_UNIT,MasterRole::ROLE_CORPORATE_BCS])) {
            return \Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc'] . '/report/cumulative/pendencyd');
            exit;
        }
        if (in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR])) {
            return \Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['bc'] . '/training/preselected');
            exit;
        }
        \Yii::$app->params['page_size30'] = '5';
        \Yii::$app->params['page_size10'] = '5';
        $searchModel = new ReportSearchForm(Yii::$app->request->queryParams);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $bank_user = \common\models\dynamicdb\bc\User::findOne($searchModel->bc_partner_bank);

        $searchModel1 = new SrlmBcApplicationSearch();

        $dataProvider1 = $searchModel1->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        $dataProvider1->query->andWhere(['=', 'srlm_bc_application.form_number', '6']);
        $dataProvider1->query->andWhere(['=', 'srlm_bc_application.gender', '2']);

        $dataProvider1->query->addOrderBy("first_name asc");
        $searchModel2 = new \bc\modules\selection\models\SrlmBcApplicationSearch();

        $dataProvider2 = $searchModel2->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);

        $dataProvider2->query->andWhere(['=', 'srlm_bc_application.form_number', '6']);
        $dataProvider2->query->andWhere(['=', 'srlm_bc_application.gender', '2']);

        $dataProvider2->query->andWhere(['srlm_bc_application.status' => SrlmBcApplication::STATUS_PROVISIONAL]);

        //$dataProvider2->query->andWhere(['not in', 'srlm_bc_application.selection_by', [15]]);
        $dataProvider2->query->addOrderBy("first_name asc");
        $searchModel2a = new \bc\modules\selection\models\SrlmBcApplicationSearch();

        $dataProvider2a = $searchModel2a->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);

        $dataProvider2a->query->andWhere(['=', 'srlm_bc_application.form_number', '6']);
        $dataProvider2a->query->andWhere(['=', 'srlm_bc_application.gender', '2']);
        $dataProvider2a->query->andWhere(['=', 'srlm_bc_application.urban_shg', '0']);
        $dataProvider2a->query->andWhere(['srlm_bc_application.status' => SrlmBcApplication::STATUS_PROVISIONAL]);

        //$dataProvider2a->query->andWhere(['not in', 'srlm_bc_application.selection_by', [15]]);
        $dataProvider2a->query->addOrderBy("first_name asc");
        $searchModel3 = new RsetisBatchParticipantsSearch();
        $searchModel3->show_blocked = 0;
        $dataProvider3 = $searchModel3->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider3->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider3->query->andWhere(['=', 'srlm_bc_application.urban_shg', '0']);
        $dataProvider3->query->andWhere(['=', 'srlm_bc_application.blocked', '0']);
        $searchModel4 = new RsetisBatchParticipantsSearch();
        $searchModel4->show_blocked = 0;
        $searchModel4->district_code = $searchModel->district_code;
        $dataProvider4 = $searchModel4->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider4->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider4->query->andWhere(['srlm_bc_application.bc_shg_funds_status' => 1]);
        $searchModel5 = new RsetisBatchParticipantsSearch();
        $searchModel5->show_blocked = 0;
        $searchModel5->district_code = $searchModel->district_code;
        $dataProvider5 = $searchModel5->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider5->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider5->query->andWhere(['srlm_bc_application.pan_card_status' => 1]);
        $searchModel5a = new RsetisBatchParticipantsSearch();
        $searchModel5a->show_blocked = 0;
        $searchModel5a->district_code = $searchModel->district_code;
        $dataProvider5a = $searchModel5->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider5a->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider5a->query->andWhere(['srlm_bc_application.pan_photo_upload' => 1]);
        $searchModel6 = new RsetisBatchParticipantsSearch();
        $searchModel6->show_blocked = 0;
        $searchModel6->district_code = $searchModel->district_code;
        $dataProvider6 = $searchModel6->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        //$dataProvider6->query->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_ONBOARDING]]);
        $dataProvider6->query->andWhere(['srlm_bc_application.onboarding' => 1]);
        $searchModel7 = new RsetisBatchParticipantsSearch();
        $searchModel7->show_blocked = 0;
        $searchModel7->district_code = $searchModel->district_code;
        $dataProvider7 = $searchModel7->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider7->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider7->query->andWhere(['srlm_bc_application.handheld_machine_status' => 1]);
        $searchModel8 = new RsetisBatchParticipantsSearch();
        $searchModel8->show_blocked = 0;
        $searchModel8->district_code = $searchModel->district_code;
        $dataProvider8 = $searchModel7->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider8->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider8->query->andWhere(['srlm_bc_application.bc_support_funds_received' => 1]);
        $searchModel9 = new RsetisBatchParticipantsSearch();
        $searchModel9->show_blocked = 0;
        $searchModel9->district_code = $searchModel->district_code;
        $dataProvider9 = $searchModel7->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider9->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider9->query->andWhere(['srlm_bc_application.bc_handheld_machine_recived' => 1]);
        $searchModel10 = new RsetisBatchParticipantsSearch();
        $searchModel10->show_blocked = 0;
        $searchModel10->district_code = $searchModel->district_code;
        $dataProvider10 = $searchModel7->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider10->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider10->query->andWhere(['not', ['srlm_bc_application.bankidbc' => null]]);
        $partner_bank_query = \common\models\dynamicdb\bc\User::find()->joinWith(['profile', 'districts'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, 'user.status' => 10]);

        $searchModel->bc_partner_bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel11 = new \bc\modules\transaction\models\summary\BcTransactionBcSummarySearch();
        $dataProvider11 = $searchModel11->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $searchModel12 = new SrlmBcApplicationSearch();
        $searchModel12->district_code = $searchModel->district_code;
        $dataProvider12 = $searchModel12->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider12->query->andWhere(['>', 'srlm_bc_application.bc_payment_count', '0']);
        $searchModel13 = new SrlmBcApplicationSearch();
        $searchModel13->district_code = $searchModel->district_code;
        $dataProvider13 = $searchModel13->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider13->query->andWhere(['>', 'srlm_bc_application.bc_payment_count', '1']);
        $searchModel14 = new SrlmBcApplicationSearch();
        $searchModel14->district_code = $searchModel->district_code;
        $dataProvider14 = $searchModel14->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider14->query->andWhere(['>', 'srlm_bc_application.bc_payment_count', '2']);
        $searchModel15 = new SrlmBcApplicationSearch();
        $searchModel15->district_code = $searchModel->district_code;
        $dataProvider15 = $searchModel15->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider15->query->andWhere(['>', 'srlm_bc_application.bc_payment_count', '3']);
        $searchModel16 = new SrlmBcApplicationSearch();
        $searchModel16->district_code = $searchModel->district_code;
        $dataProvider16 = $searchModel16->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider16->query->andWhere(['>', 'srlm_bc_application.bc_payment_count', '4']);
        $searchModel17 = new SrlmBcApplicationSearch();
        $searchModel17->district_code = $searchModel->district_code;
        $dataProvider17 = $searchModel17->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider17->query->andWhere(['>', 'srlm_bc_application.bc_payment_count', '5']);

        $searchModel18 = new SrlmBcApplicationSearch();
        $searchModel18->district_code = $searchModel->district_code;
        $dataProvider18 = $searchModel18->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider18->query->andWhere(['>', 'srlm_bc_application.bc_saree_count', '0']);
        $searchModel19 = new SrlmBcApplicationSearch();
        $searchModel19->district_code = $searchModel->district_code;
        $dataProvider19 = $searchModel13->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size10']);
        $dataProvider19->query->andWhere(['>', 'srlm_bc_application.bc_saree_count', '1']);

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
        } elseif ($button_type == "4") {
            $dataProvider = $dataProvider4;
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
        } elseif ($button_type == "11a") {
            $dataProvider11a = $searchModel11->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], 'bc_application_id');
            $dataProvider = $dataProvider11a;
        }
        return $this->render('index', [
                    'button_type' => $button_type,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvider1' => $dataProvider1,
                    'dataProvider2' => $dataProvider2,
                    'dataProvider2a' => $dataProvider2a,
                    'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4,
                    'dataProvider5' => $dataProvider5,
                    'dataProvider5a' => $dataProvider5a,
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
                    'dataProvider19' => $dataProvider19,
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
