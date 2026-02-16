<?php

namespace bc\modules\report\modules\tracking\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use bc\modules\training\models\RsetisCenterTrainingSearch;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\training\models\RsetisBatchParticipantsSearch;
use bc\modules\selection\models\form\DashboardSearchForm;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\modules\transaction\models\summary\BcTransactionBcSummarySearch;
use bc\modules\transaction\models\summary\BcTransactionBcSummary;
use bc\modules\transaction\models\summary\BcTransactionBcSummaryDailySearch;
use bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily;
use bc\modules\transaction\models\summary\BcTransactionBankSummaryWeeklySearch;
use bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthlySearch;
use common\models\master\MasterRole;
use yii\web\UploadedFile;
use common\models\CboMembers;
use common\models\User;
use common\models\CboMemberProfile;
use bc\modules\selection\models\base\GenralModel;

/**
 * Default controller for the `bc` module
 */
class BcController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'overallperformance', 'monthlyperformance', 'weeklyperformance', 'dailyperformance', 'downloadoverall'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'overallperformance', 'monthlyperformance', 'weeklyperformance', 'dailyperformance', 'downloadoverall'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'block' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $searchModel = new DashboardSearchForm($params);
        $searchModel->district_code = Yii::$app->params['bc_tracking_disricts'];
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::trackinbcdistrictoption($searchModel);
        $searchModel->block_option = GenralModel::blockoption($searchModel);
        $searchModels = new SrlmBcApplicationSearch();

        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 30, null, \bc\modules\selection\models\base\GenralModel::select_preselected_bc_column()); //, Yii::$app->user->identity, 150);

        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        $dataProvider->query->andWhere(['=', 'blocked', '0']);
        //$dataProvider->query->andWhere(['not in', 'srlm_bc_application.selection_by', [15]]);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere(['training_status' => 3]);
        $dataProvider->query->andWhere(['bc_tracking_open' => 1]);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOverallperformance() {
        $user_model = Yii::$app->user->identity;
        $searchModel = new BcTransactionBcSummarySearch();
        if (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
            $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
            $searchModel->master_partner_bank_id = $user_model->master_partner_bank_id;
        } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
            $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
            $searchModel->master_partner_bank_id = $user_model->master_partner_bank_id;
        } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
            $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
            $searchModel->master_partner_bank_id = $user_model->master_partner_bank_id;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 30);
        $dataProvider->query->andWhere([BcTransactionBcSummary::getTableSchema()->fullName . '.district_code' => Yii::$app->params['bc_tracking_disricts']]);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::trackinbcdistrictoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }
        if ($searchModel->master_partner_bank_id || $searchModel->district_code || $searchModel->block_code || $searchModel->gram_panchayat_code || $searchModel->nretp != '') {
            Yii::$app->params['txn'] = 0;
            Yii::$app->params['txn_com'] = 0;
            Yii::$app->params['txn_amn'] = 0;
        }
        return $this->render('overallperformance', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDailyperformance() {
        $searchModel = new BcTransactionBcSummaryDailySearch();
        if (!isset(Yii::$app->request->queryParams['BcTransactionBcSummaryDailySearch']['bc_application_id'])) {
            if (!isset(Yii::$app->request->queryParams['BcTransactionBcSummaryDailySearch']['from_date_time'])) {
                $searchModel->from_date_time = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));
                $searchModel->to_date_time = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));
            }
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 30);
        $dataProvider->query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.district_code' => Yii::$app->params['bc_tracking_disricts']]);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::trackinbcdistrictoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }
        return $this->render('dailyperformance', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionWeeklyperformance() {
        $searchModel = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryWeeklySearch();
        $searchModel->week_option = \bc\modules\selection\models\base\GenralModel::bctweekoption($searchModel);
        if (!isset(\Yii::$app->request->queryParams['BcTransactionWeeklyReportSearch']['week_id'])) {
            $searchModel->week_id = \bc\modules\selection\models\base\GenralModel::current_week_id();
        }
        if (empty(\Yii::$app->request->queryParams)) {
            $searchModel->week_id = \bc\modules\selection\models\base\GenralModel::current_week_id();
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 30);
        $dataProvider->query->andWhere([\bc\modules\transaction\models\summary\BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.district_code' => Yii::$app->params['bc_tracking_disricts']]);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::trackinbcdistrictoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }

        return $this->render('weeklyperformance', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMonthlyperformance() {
        $null = new \yii\db\Expression('NULL');
        $searchModel = new BcTransactionBcSummaryMonthlySearch();

        if (!isset(\Yii::$app->request->queryParams['BcTransactionBcSummaryMonthlySearch']['month_id'])) {
            $searchModel->month_id = \bc\modules\selection\models\base\GenralModel::current_month_id();
        }
        if (empty(Yii::$app->request->queryParams)) {
            $searchModel->month_id = \bc\modules\selection\models\base\GenralModel::current_month_id();
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 30);
        $dataProvider->query->andWhere([\bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.district_code' => Yii::$app->params['bc_tracking_disricts']]);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::trackinbcdistrictoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }
        $searchModel->month_option = \bc\modules\selection\models\base\GenralModel::bctmonthoption();
        return $this->render('monthlyperformance', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMonthlygraph() {
        $null = new \yii\db\Expression('NULL');
        $searchModel = new BcTransactionBcSummaryMonthlySearch();
        $searchModel->track = 1;
        if (!isset(\Yii::$app->request->queryParams['BcTransactionBcSummaryMonthlySearch']['month_id'])) {
            $searchModel->month_id = \bc\modules\selection\models\base\GenralModel::current_month_id();
        }
        if (empty(Yii::$app->request->queryParams)) {
            $searchModel->month_id = \bc\modules\selection\models\base\GenralModel::current_month_id();
        }

        $graph = $searchModel->graph(Yii::$app->request->queryParams);

        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::trackinbcdistrictoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }
        $searchModel->month_option = \bc\modules\selection\models\base\GenralModel::bctmonthoption();
        return $this->render('monthlygraph', [
                    'searchModel' => $searchModel,
                    'graph' => $graph,
        ]);
    }

    public function actionWeeklygraph() {
        $null = new \yii\db\Expression('NULL');
        $searchModel = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryWeeklySearch();
        $searchModel->track = 1;
        $searchModel->week_option = \bc\modules\selection\models\base\GenralModel::bctweekoption($searchModel);
        if (!isset(\Yii::$app->request->queryParams['BcTransactionWeeklyReportSearch']['week_id'])) {
            $searchModel->week_id = \bc\modules\selection\models\base\GenralModel::current_week_id();
        }
        if (empty(\Yii::$app->request->queryParams)) {
            $searchModel->week_id = \bc\modules\selection\models\base\GenralModel::current_week_id();
        }
        $graph = $searchModel->graph(Yii::$app->request->queryParams);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::trackinbcdistrictoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }
        return $this->render('weeklygraph', [
                    'searchModel' => $searchModel,
                    'graph' => $graph,
        ]);
    }

    public function actionChart() {
        $seach = new \bc\modules\transaction\models\summary\form\SearchForm(Yii::$app->request->queryParams);
        $seach->district_option = \bc\modules\selection\models\base\GenralModel::trackinbcdistrictoption($seach);
        $searchModel = new \bc\modules\transaction\models\summary\BcTransactionBcSummarySearch();
        $dataProvider = $searchModel->search($seach, Yii::$app->user->identity, 30);
        $dataProvider->query->andWhere([BcTransactionBcSummary::getTableSchema()->fullName . '.district_code' => Yii::$app->params['bc_tracking_disricts']]);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::trackinbcdistrictoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        if ($searchModel->district_code) {
            $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        }
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }
        $searchModel1 = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthlySearch();
        $report = $searchModel1->charttracking($seach, Yii::$app->user->identity);
        if ($searchModel->master_partner_bank_id || $searchModel->district_code || $searchModel->block_code || $searchModel->gram_panchayat_code || $searchModel->nretp != '') {
            \Yii::$app->params['txn'] = 0;
            \Yii::$app->params['txn_com'] = 0;
            \Yii::$app->params['txn_amn'] = 0;
        }
        return $this->render('chart', [
                    'searchModel' => $seach,
                    'dataProvider' => $dataProvider,
                    'report' => $report
        ]);
    }

    public function actionReportchart() {
        $searchModel = new \bc\modules\transaction\models\summary\report\Graph();
        $searchModel->master_partner_bank_id = 6;
        $searchModel->district_code = Yii::$app->params['bc_tracking_disricts'];
        if (!isset(\Yii::$app->request->queryParams['Graph']['district_code'])) {
            $searchModel->district_code = Yii::$app->params['bc_tracking_disricts'];
        }
        if (isset(\Yii::$app->request->queryParams['Graph']['district_code']) and \Yii::$app->request->queryParams['Graph']['district_code'] != '') {
            $searchModel->district_code = \Yii::$app->request->queryParams['Graph']['district_code'];
        }
        if (isset(\Yii::$app->request->queryParams['Graph']['number_of_day_work'])) {
            $searchModel->number_of_day_work = \Yii::$app->request->queryParams['Graph']['number_of_day_work'];
        }
        $dataProvider = $searchModel->search($searchModel->number_of_day_work, \Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::trackinbcdistrictoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }


        return $this->render('reportchart', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReportchart1() {
        $searchModel = new \bc\modules\transaction\models\summary\report\Graph();
        $searchModel->master_partner_bank_id = 6;
        $searchModel->district_code = Yii::$app->params['bc_tracking_disricts'];
        if (!isset(\Yii::$app->request->queryParams['Graph']['district_code'])) {
            $searchModel->district_code = Yii::$app->params['bc_tracking_disricts'];
        }
        if (isset(\Yii::$app->request->queryParams['Graph']['district_code']) and \Yii::$app->request->queryParams['Graph']['district_code'] != '') {
            $searchModel->district_code = \Yii::$app->request->queryParams['Graph']['district_code'];
        }
        if (isset(\Yii::$app->request->queryParams['Graph']['number_of_day_work'])) {
            $searchModel->number_of_day_work = \Yii::$app->request->queryParams['Graph']['number_of_day_work'];
        }
        $dataProvider = $searchModel->search($searchModel->number_of_day_work, \Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::trackinbcdistrictoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }

        return $this->render('reportchart1', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReportchart2() {
        $searchModel = new \bc\modules\transaction\models\summary\report\Graph();
        $searchModel->master_partner_bank_id = 6;
        $searchModel->district_code = Yii::$app->params['bc_tracking_disricts'];
        if (!isset(\Yii::$app->request->queryParams['Graph']['district_code'])) {
            $searchModel->district_code = Yii::$app->params['bc_tracking_disricts'];
        }
        if (isset(\Yii::$app->request->queryParams['Graph']['district_code']) and \Yii::$app->request->queryParams['Graph']['district_code'] != '') {
            $searchModel->district_code = \Yii::$app->request->queryParams['Graph']['district_code'];
        }
        if (isset(\Yii::$app->request->queryParams['Graph']['number_of_day_work'])) {
            $searchModel->number_of_day_work = \Yii::$app->request->queryParams['Graph']['number_of_day_work'];
        }
        $dataProvider = $searchModel->search($searchModel->number_of_day_work, \Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::trackinbcdistrictoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }

        return $this->render('reportchart2', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReportchart3() {
        $searchModel = new \bc\modules\transaction\models\summary\report\Graph();
        $searchModel->master_partner_bank_id = 6;
        $searchModel->district_code = Yii::$app->params['bc_tracking_disricts'];
        if (!isset(\Yii::$app->request->queryParams['Graph']['district_code'])) {
            $searchModel->district_code = Yii::$app->params['bc_tracking_disricts'];
        }
        if (isset(\Yii::$app->request->queryParams['Graph']['district_code']) and \Yii::$app->request->queryParams['Graph']['district_code'] != '') {
            $searchModel->district_code = \Yii::$app->request->queryParams['Graph']['district_code'];
        }
        if (isset(\Yii::$app->request->queryParams['Graph']['number_of_day_work'])) {
            $searchModel->number_of_day_work = \Yii::$app->request->queryParams['Graph']['number_of_day_work'];
        }
        $dataProvider = $searchModel->search($searchModel->number_of_day_work, \Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::trackinbcdistrictoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }

        return $this->render('reportchart3', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReportchart4() {
        $searchModel = new \bc\modules\transaction\models\summary\report\Graph();
        $searchModel->master_partner_bank_id = 6;
        $searchModel->district_code = Yii::$app->params['bc_tracking_disricts'];
        if (!isset(\Yii::$app->request->queryParams['Graph']['district_code'])) {
            $searchModel->district_code = Yii::$app->params['bc_tracking_disricts'];
        }
        if (isset(\Yii::$app->request->queryParams['Graph']['district_code']) and \Yii::$app->request->queryParams['Graph']['district_code'] != '') {
            $searchModel->district_code = \Yii::$app->request->queryParams['Graph']['district_code'];
        }
        if (isset(\Yii::$app->request->queryParams['Graph']['number_of_day_work'])) {
            $searchModel->number_of_day_work = \Yii::$app->request->queryParams['Graph']['number_of_day_work'];
        }
        $dataProvider = $searchModel->search($searchModel->number_of_day_work, \Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::trackinbcdistrictoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }

        return $this->render('reportchart4', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDownloadoverall() {
        $null = new \yii\db\Expression('NULL');
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $searchModel = new BcTransactionBcSummarySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $dataProvider->query->andWhere([BcTransactionBcSummary::getTableSchema()->fullName . '.district_code' => Yii::$app->params['bc_tracking_disricts']]);
            $file = "bc_transaction_overall_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Srl. No.', 'Application No', 'Name', 'District', 'Block', 'GP', 'Partner Agency', 'No. of transaction', 'Txn Amount', 'Commission Amount', 'No. Of Days', 'Working Days', 'Non Working Days'));
            $sr_no = 1;
            $row = [];
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $row = [
                    $sr_no,
                    isset($model->bc) ? $model->bc->application_id : '',
                    isset($model->bc) ? $model->bc->name : '',
                    isset($model->district) ? $model->district->district_name : '',
                    isset($model->block) ? $model->block->block_name : '',
                    isset($model->gp) ? $model->gp->gram_panchayat_name : '',
                    isset($model->pbank) ? $model->pbank->bank_short_name : '',
                    isset($model->no_of_transaction) ? $model->no_of_transaction : '',
                    $model->transaction_amount,
                    isset($model->commission_amount) ? round($model->commission_amount, 2) : '',
                    isset($model->total_day) ? $model->total_day : '',
                    isset($model->total_working_day) ? $model->total_working_day : '',
                    isset($model->total_not_working_day) ? $model->total_not_working_day : ''
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit();
        } catch (\Exception $ex) {
//            print_r($ex->getMessage());
//            exit;
        }
    }

    public function actionDownloadmonthli() {
        $null = new \yii\db\Expression('NULL');
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $searchModel = new BcTransactionBcSummaryMonthlySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $dataProvider->query->andWhere([\bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.district_code' => Yii::$app->params['bc_tracking_disricts']]);
            $file = "bc_transaction_monthly_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Srl. No.', 'Application No', 'Name', 'District', 'Block', 'GP', 'Partner Agency', 'Month', 'No. of transaction', 'Txn Amount', 'Commission Amount', 'No. Of Days', 'Working Days', 'Non Working Days'));
            $sr_no = 1;
            $row = [];
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $row = [
                    $sr_no,
                    isset($model->bc) ? $model->bc->application_id : '',
                    isset($model->bc) ? $model->bc->name : '',
                    isset($model->district) ? $model->district->district_name : '',
                    isset($model->block) ? $model->block->block_name : '',
                    isset($model->gp) ? $model->gp->gram_panchayat_name : '',
                    isset($model->pbank) ? $model->pbank->bank_short_name : '',
                    isset($model->month_start_date) ? \Yii::$app->formatter->asDatetime($model->month_start_date, "php:M-Y") : '',
                    isset($model->no_of_transaction) ? $model->no_of_transaction : '',
                    $model->transaction_amount,
                    isset($model->commission_amount) ? round($model->commission_amount, 2) : '',
                    isset($model->total_day) ? $model->total_day : '',
                    isset($model->total_working_day) ? $model->total_working_day : '',
                    isset($model->total_not_working_day) ? $model->total_not_working_day : ''
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit();
        } catch (\Exception $ex) {
//            print_r($ex->getMessage());
//            exit;
        }
    }

    public function actionDownloadweekly() {
        $null = new \yii\db\Expression('NULL');
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $searchModel = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryWeeklySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $dataProvider->query->andWhere([\bc\modules\transaction\models\summary\BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.district_code' => Yii::$app->params['bc_tracking_disricts']]);
            $file = "bc_transaction_weekly_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Srl. No.', 'Application No', 'Name', 'District', 'Block', 'GP', 'Partner Agency', 'Week', 'No. of transaction', 'Txn Amount', 'Commission Amount', 'No. Of Days', 'Working Days', 'Non Working Days'));
            $sr_no = 1;
            $row = [];
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $row = [
                    $sr_no,
                    isset($model->bc) ? $model->bc->application_id : '',
                    isset($model->bc) ? $model->bc->name : '',
                    isset($model->district) ? $model->district->district_name : '',
                    isset($model->block) ? $model->block->block_name : '',
                    isset($model->gp) ? $model->gp->gram_panchayat_name : '',
                    isset($model->pbank) ? $model->pbank->bank_short_name : '',
                    isset($model->week) ? \Yii::$app->formatter->asDatetime($model->week_start_date, "php:d M Y") . ' to ' . \Yii::$app->formatter->asDatetime($model->week_end_date, "php:d M Y") : '',
                    isset($model->no_of_transaction) ? $model->no_of_transaction : '',
                    $model->transaction_amount,
                    isset($model->commission_amount) ? round($model->commission_amount, 2) : '',
                    isset($model->total_day) ? $model->total_day : '',
                    isset($model->total_working_day) ? $model->total_working_day : '',
                    isset($model->total_not_working_day) ? $model->total_not_working_day : ''
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit();
        } catch (\Exception $ex) {
//            print_r($ex->getMessage());
//            exit;
        }
    }

    public function actionBccsv($bc_application_id) {
        $null = new \yii\db\Expression('NULL');
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $model = $this->findModelbc($bc_application_id);
            if ($model == null) {
                return $this->redirect(['/']);
            }
            $searchModel = new BcTransactionBcSummaryMonthlySearch();
            $searchModel->bc_application_id = $bc_application_id;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $dataProvider->query->andWhere(['bc_application_id' => $bc_application_id]);
            $dataProvider->sort->defaultOrder = ['month_start_date' => SORT_DESC];
            $file = "bc_" . $model->name . '_' . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Srl. No.', 'Application No', 'Name', 'District', 'Block', 'GP', 'Partner Agency', 'Month', 'No. of transaction', 'Txn Amount', 'Commission Amount', 'No. Of Days', 'Working Days', 'Non Working Days'));
            $sr_no = 1;
            $row = [];
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $row = [
                    $sr_no,
                    isset($model->bc) ? $model->bc->application_id : '',
                    isset($model->bc) ? $model->bc->name : '',
                    isset($model->district) ? $model->district->district_name : '',
                    isset($model->block) ? $model->block->block_name : '',
                    isset($model->gp) ? $model->gp->gram_panchayat_name : '',
                    isset($model->pbank) ? $model->pbank->bank_short_name : '',
                    isset($model->month_start_date) ? \Yii::$app->formatter->asDatetime($model->month_start_date, "php:M-Y") : '',
                    isset($model->no_of_transaction) ? $model->no_of_transaction : '',
                    $model->transaction_amount,
                    isset($model->commission_amount) ? round($model->commission_amount, 2) : '',
                    isset($model->total_day) ? $model->total_day : '',
                    isset($model->total_working_day) ? $model->total_working_day : '',
                    isset($model->total_not_working_day) ? $model->total_not_working_day : ''
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit();
        } catch (\Exception $ex) {
//            print_r($ex->getMessage());
//            exit;
        }
    }

    public function actionDailydownload() {
        $null = new \yii\db\Expression('NULL');
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $searchModel = new BcTransactionBcSummaryDailySearch();
//            echo "<pre>";
//            print_r(Yii::$app->request->queryParams);
//            exit;
            if (isset(Yii::$app->request->queryParams['BcTransactionBcSummaryDailySearch']['from_date_time'])) {
                $searchModel->from_date_time = \Yii::$app->request->queryParams['BcTransactionBcSummaryDailySearch']['from_date_time'];
            }
            if (isset(Yii::$app->request->queryParams['BcTransactionBcSummaryDailySearch']['to_date_time'])) {
                $searchModel->to_date_time = \Yii::$app->request->queryParams['BcTransactionBcSummaryDailySearch']['to_date_time'];
            }
            if (isset(Yii::$app->request->queryParams['BcTransactionBcSummaryDailySearch']['date'])) {
                $searchModel->date = \Yii::$app->request->queryParams['BcTransactionBcSummaryDailySearch']['date'];
            }

            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, 30);
            $file = "bc_transaction_daily_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Srl. No.', 'Application No', 'Name', 'District', 'Block', 'GP', 'Partner Agency', 'Date', 'No. of transaction', 'Txn Amount', 'Commission Amount'));
            $sr_no = 1;
            $row = [];
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            foreach ($models as $model) {
                $row = [
                    $sr_no,
                    isset($model->bc) ? $model->bc->name : '',
                    isset($model->district) ? $model->district->district_name : '',
                    isset($model->block) ? $model->block->block_name : '',
                    isset($model->gp) ? $model->gp->gram_panchayat_name : '',
                    isset($model->pbank) ? $model->pbank->bank_short_name : '',
                    isset($model->date) ? $model->date : '',
                    isset($model->no_of_transaction) ? $model->no_of_transaction : '',
                    $model->transaction_amount,
                    isset($model->commission_amount) ? round($model->commission_amount, 2) : ''
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit();
        } catch (\Exception $ex) {
//            print_r($ex->getMessage());
//            exit;
        }
    }

    public function actionView($bcid) {

        $model = $this->findModelbc($bcid);

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

    public function actionFeedback() {
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $searchModel = new DashboardSearchForm($params);
        $rep = new \bc\modules\selection\models\report\Feedback();
        $graph = $rep->bctraiking($searchModel);
        $dataProvider = [];
        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";

        return $this->render('feedback', [
                    'feedback' => $graph,
                    'searchModel' => $searchModel
        ]);
    }

    public function actionFeedbacks() {
        try {
            $params = [];
            if (Yii::$app->request->isGet) {
                $params = Yii::$app->request->queryParams;
            }
            if (Yii::$app->request->isPost) {
                $params = Yii::$app->request->post();
            }
            $searchModel = new DashboardSearchForm($params);

            $searchModels = new \bc\modules\selection\models\BcTrackingFeedbackSearch();
            $searchModels->district_code = Yii::$app->params['bc_tracking_disricts'];
            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 30); //, Yii::$app->user->identity, 150);
            if ($searchModel->feedback_form_status == 1) {
                $dataProvider->query->andWhere(['=', \bc\modules\selection\models\BcTrackingFeedback::getTableSchema()->fullName . '.section', '9']);
            }
            if ($searchModel->feedback_form_status == 2) {
                $dataProvider->query->andWhere(['<', \bc\modules\selection\models\BcTrackingFeedback::getTableSchema()->fullName . '.section', '9']);
            }
            $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::trackinbcdistrictoption($searchModels);
            if ($searchModel->district_code) {
                $searchModel->block_option = GenralModel::blockoption($searchModel);
            }
            return $this->render('feedbacks', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }

    protected function findModelbc($id) {
        if (($model = SrlmBcApplication::find()->where(['id' => $id])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModel($id) {
        if (($model = RsetisBatchParticipants::find()->where(['id' => $id])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
