<?php

namespace bc\modules\report\controllers;

use Yii;
use yii\web\Controller;
use bc\models\report\Graph;
use bc\modules\training\models\RsetisBatchParticipantsSearch;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\RsetisBatchParticipants;
use common\models\master\MasterRole;

/**
 * Default controller for the `report` module
 */
class BcController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['performance', 'ac194n', 'view', 'setelmentac194n'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['performance', 'ac194n', 'view', 'setelmentac194n'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function BeforeAction($action) {
        $this->enableCsrfValidation = false;
        if ($action->id == 'reportchart') {
            return \Yii::$app->getResponse()->redirect(\Yii::$app->params['app_url']['bc'] . '/transaction/report/reportchart');
        }
        if ($action->id == 'reportchart1') {
            return \Yii::$app->getResponse()->redirect(\Yii::$app->params['app_url']['bc'] . '/transaction/report/reportchart1');
        }
        if ($action->id == 'reportchart2') {
            return \Yii::$app->getResponse()->redirect(\Yii::$app->params['app_url']['bc'] . '/transaction/report/reportchart2');
        }
        if ($action->id == 'reportchart3') {
            return \Yii::$app->getResponse()->redirect(\Yii::$app->params['app_url']['bc'] . '/transaction/report/reportchart3');
        }
        if ($action->id == 'reportchart4') {
            return \Yii::$app->getResponse()->redirect(\Yii::$app->params['app_url']['bc'] . '/transaction/report/reportchart4');
        }
        if ($action->id == 'monthlychart') {
            return \Yii::$app->getResponse()->redirect(\Yii::$app->params['app_url']['bc'] . '/transaction/report/monthlychart');
        }
        if ($action->id == 'bankchart') {
            return \Yii::$app->getResponse()->redirect(\Yii::$app->params['app_url']['bc'] . '/transaction/report/bankchart');
        }
        return parent::beforeAction($action);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionPerformance() {

        $graph = new Graph();
        $bc_bank_responce = $graph->getResponce(Graph::TYPE_BC_BANK);
        $bc_shg_bank_responce = $graph->getResponce(Graph::TYPE_BC_SHG_BANK);
        $bc_shg_fund = $graph->getResponce(Graph::TYPE_BC_SHG_BANK);
        $bc_handheldmachine = $graph->getResponce(Graph::TYPE_BC_HANDHELDMACHINE);
        $bc_pan = $graph->getResponce(Graph::TYPE_BC_PAN);
        return $this->render('performance', [
                    'bc_bank_responce' => $bc_bank_responce,
                    'bc_shg_bank_responce' => $bc_shg_bank_responce,
                    'bc_shg_fund' => $bc_shg_fund,
                    'bc_handheldmachine' => $bc_handheldmachine,
                    'bc_pan' => $bc_pan,
        ]);
    }

    /**
     * BC Report Chart
     *
     * @return void
     */
    public function actionReportchart() {
        $searchModel = new \bc\models\transaction\BcTransactionReportSearch();

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, \Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }


        return $this->render('reportchart', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Monthly Report Chart
     *
     * @return void
     */
    public function actionMonthlychart() {
        $searchModel = new \bc\models\transaction\BcTransactionReportSearch();
        $searchModel->month_id = \bc\modules\selection\models\base\GenralModel::current_month_id() - 1;

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, \Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        $searchModel->month_option = $searchModel->monthoption();
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }

        return $this->render('monthlychart', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Bank Report Chart
     *
     * @return void
     */
    public function actionBankchart() {
        $searchModel = new \bc\models\transaction\BcTransactionReportSearch();

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, \Yii::$app->user->identity, 30);
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModel->month_option = $searchModel->monthoption();

        return $this->render('bankchart', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLoanrepaid() {
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
            $dataProvider->query->andWhere(['srlm_bc_application.bc_shg_funds_status' => 1]);
            $dataProvider->query->andWhere(['srlm_bc_application.shg_confirm_funds_return' => 1]);
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
            return $this->render('loanrepaid', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

    public function actionShg() {
        $searchModel = new \cbo\models\ShgSearch();
        $searchModel->urban_shg = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->andWhere(['not', [\cbo\models\Shg::getTableSchema()->fullName . '.bc_user_id' => null]]);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
        $searchModel->block_option = \bc\modules\selection\models\base\GenralModel::blockoption($searchModel);
        if ($searchModel->block_code) {
            $searchModel->gp_option = \bc\modules\selection\models\base\GenralModel::gpoption($searchModel);
        }

        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";

        return $this->render('shg', [
                    'button_type' => $button_type,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAc194n() {
        $user_model = Yii::$app->user->identity;
        $searchModel = new RsetisBatchParticipantsSearch();
        $searchModel->shg_bank_option = \bc\modules\selection\models\base\GenralModel::shg_bank_option($searchModel);
        $searchModel->bc_bank_option = \bc\modules\selection\models\base\GenralModel::bc_bank_name_option($searchModel);
        $searchModel->show_blocked = 0;
        if (in_array($user_model->role, [MasterRole::ROLE_RBI])) {
            if (in_array($user_model->id, [326328, 326541])) {
                
            } else {
                $searchModel->bc_settlement_account_bank_name = \bc\modules\selection\models\base\GenralModel::rbi_user_bank($user_model->id);
            }
        }
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
        $dataProvider->query->andWhere(['srlm_bc_application.bc_operational' => 1]);
        if ($searchModel->bc_settlement_ac_194n != '') {
            $dataProvider->query->andWhere(['srlm_bc_application.bc_settlement_ac_194n' => $searchModel->bc_settlement_ac_194n]);
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
        $searchModel->training_status_option = ['3' => 'Certified', '31' => 'Already certified'];
        $searchModel1 = new RsetisBatchParticipantsSearch();
        $searchModel1->show_blocked = 0;
        if (Yii::$app->request->isGet)
            $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (Yii::$app->request->isPost)
            $dataProvider1 = $searchModel1->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider1->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider1->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
        $dataProvider1->query->andWhere(['srlm_bc_application.blocked' => 0]);
        $dataProvider1->query->andWhere(['srlm_bc_application.bc_settlement_ac_194n' => 0]);
        $dataProvider1->query->andWhere(['srlm_bc_application.bc_operational' => 1]);
        $searchModel2 = new RsetisBatchParticipantsSearch();
        $searchModel2->show_blocked = 0;
        if (Yii::$app->request->isGet)
            $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (Yii::$app->request->isPost)
            $dataProvider2 = $searchModel2->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider2->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        $dataProvider2->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
        $dataProvider2->query->andWhere(['srlm_bc_application.blocked' => 0]);
        $dataProvider2->query->andWhere(['srlm_bc_application.bc_settlement_ac_194n' => 1]);
        $dataProvider2->query->andWhere(['srlm_bc_application.bc_operational' => 1]);
        $button_type = isset($_REQUEST['button_type']) ? ($_REQUEST['button_type']) : "";
        \Yii::$app->params['title'] = 'BC settlement a/c <b>Tagged</b> for 194N';
        \Yii::$app->params['class'] = 'bg-info-100';
        if ($button_type == "1") {
            \Yii::$app->params['title'] = '1 BC settlement a/c <b>NOT Tagged</b> for 194N';
            \Yii::$app->params['class'] = 'bg-info-100';
            $dataProvider = $dataProvider1;
        } elseif ($button_type == "2") {
            \Yii::$app->params['title'] = '2 BC settlement a/c Tagged for 194N';
            \Yii::$app->params['class'] = 'bg-info-100';
            $dataProvider = $dataProvider2;
        }
        return $this->render('bc_194n', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvider1' => $dataProvider1,
                    'dataProvider2' => $dataProvider2,
                    'button_type' => $button_type
        ]);
    }

    public function actionAc194nifsc() {
        $user_model = Yii::$app->user->identity;
        \Yii::$app->params['page_size30'] = 40;
        if (Yii::$app->request->isGet)
            $searchModel = new \bc\modules\selection\models\form\DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new \bc\modules\selection\models\form\DashboardSearchForm(Yii::$app->request->post());

        $searchModel->bc_bank_option = \bc\modules\selection\models\base\GenralModel::bc_bank_name_option($searchModel);

        if (in_array($user_model->role, [MasterRole::ROLE_RBI])) {
            if (in_array($user_model->id, [326328, 326541])) {
                
            } else {
                $searchModel->bc_settlement_account_bank_name = \bc\modules\selection\models\base\GenralModel::rbi_user_bank($user_model->id);
            }
        }
        $searchModels = new \bc\modules\selection\models\SrlmBcApplicationSearch();

        $dataProvider = $searchModels->rbi($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30'], null, \bc\modules\selection\models\base\GenralModel::select_preselected_bc_column());

        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.form_number', '6']);
        $dataProvider->query->andWhere(['=', SrlmBcApplication::getTableSchema()->fullName . '.gender', '2']);
        //$dataProvider->query->andWhere(['not in', 'srlm_bc_application.selection_by', [15]]);
        $dataProvider->query->andWhere(['=', 'blocked', '0']);
        $dataProvider->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $button_type = isset($_REQUEST['button_type']) ? ($_REQUEST['button_type']) : "";
        \Yii::$app->params['title'] = 'BC settlement a/c tagged for 194N';
        \Yii::$app->params['class'] = 'bg-info-100';
        if ($button_type == "1") {
            \Yii::$app->params['title'] = 'Total BC settlement a/c tagged for 194N - No';
            \Yii::$app->params['class'] = 'bg-info-100';
            $dataProvider = $dataProvider1;
        } elseif ($button_type == "2") {
            \Yii::$app->params['title'] = '2 Total BC settlement a/c tagged for 194N - Yes';
            \Yii::$app->params['class'] = 'bg-info-100';
            $dataProvider = $dataProvider2;
        }
        return $this->render('bc_194nifsc', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'button_type' => $button_type
        ]);
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

    public function actionSetelmentac194n($bcid) {
        $bc_model = $this->findModelbc($bcid);
        if (!in_array($bc_model->reading_skills, [1, 2])) {
            return $this->redirect(['/report/bc/ac194n']);
        }
        if (in_array($bc_model->urban_shg, [1])) {
            return $this->redirect(['/report/bc/ac194n']);
        }
//        if (in_array($bc_model->bc_settlement_ac_194n, [1])) {
//            return $this->redirect(['/report/bc/ac194n']);
//        }
        $model = new \bc\modules\selection\models\form\BC194AcForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate()) {
            $model->bc_model->bc_settlement_ac_194n = 1;
            $model->bc_model->bc_settlement_ac_194n_date = new \yii\db\Expression('NOW()');
            $model->bc_model->bc_settlement_ac_194n_by = Yii::$app->user->identity->id;
            $model->bc_model->action_type = SrlmBcApplication::ACTION_TYPE_194N_AC;
            if ($model->bc_model->save()) {
                \Yii::$app->getSession()->setFlash('success', 'BC settlement a/c tagged for 194N of ' . $bc_model->name . ' successfully');
                return $this->redirect(['/report/bc/ac194nifsc?DashboardSearchForm[bank_id]=' . $model->bc_model->bank_id]);
            }
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('bc_194n_mapped_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('bc_194n_mapped_form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionChangebank($bcid) {
        $bc_model = $this->findModelbc($bcid);
        if (!in_array($bc_model->reading_skills, [1, 2])) {
            return $this->redirect(['/report/bc/bankinactive']);
        }
        if (in_array($bc_model->urban_shg, [1])) {
            return $this->redirect(['/report/bc/bankinactive']);
        }
        $model = new \bc\modules\training\models\form\BCChageBankDetailBankForm($bc_model);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) and $model->validate() and $model->save()) {

            \Yii::$app->getSession()->setFlash('success', 'BC Bank Account bank change of ' . $bc_model->name . ' successfully');
           return $this->redirect(['/report/bc/bankinactive']);
        }

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('bc_bank_change_form', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('bc_bank_change_form', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDetailpendency() {
        $model = SrlmBcApplication::findOne($_REQUEST['expandRowKey']);
        $searchModel = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider = $searchModel->search($searchModel, \Yii::$app->user->identity, false);
        $dataProvider->query->andWhere(['srlm_bc_application.training_status' => 3]);
        $dataProvider->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
        $dataProvider->query->andWhere(['srlm_bc_application.bc_operational' => 1]);
        $dataProvider->query->andWhere(['srlm_bc_application.bc_settlement_ac_194n' => 0]);
        $dataProvider->query->andWhere(['bc_settlement_account_ifsc_code' => $model->bc_settlement_account_ifsc_code]);
        $dataProvider->query->andWhere(['bc_settlement_account_bank_name' => $model->bc_settlement_account_bank_name]);
        return $this->renderPartial('ifscbankbcsakhi', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBankinactive() {
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $searchModel = new \bc\modules\selection\models\form\DashboardSearchForm($params);
        $searchModel->bc_bank_option = \yii\helpers\ArrayHelper::map(\cbo\models\master\CboMasterBank::find()->where(['!=', 'new_status', 1])->all(), 'id', 'bank_name');
        $searchModels = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, \Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->JoinWith(['bcbanksr']);
        $dataProvider->query->andWhere(['!=', 'cbo_master_bank.new_status', 1]);
        $dataProvider->query->andWhere(['srlm_bc_application.training_status' => 3]);
        $dataProvider->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
        $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
        if ($searchModel->bank_id) {
            $dataProvider->query->andWhere(['srlm_bc_application.bank_id' => $searchModel->bank_id]);
        }
        return $this->render('bcbankinactive', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetailpendencydownload($bank_id, $ifsc_code) {
        $searchModel = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvider = $searchModel->search($searchModel, \Yii::$app->user->identity, false);
        $dataProvider->query->andWhere(['srlm_bc_application.training_status' => 3]);
        $dataProvider->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
        $dataProvider->query->andWhere(['srlm_bc_application.bc_operational' => 1]);
        $dataProvider->query->andWhere(['srlm_bc_application.bc_settlement_ac_194n' => 0]);
        $dataProvider->query->andWhere(['bc_settlement_account_ifsc_code' => $ifsc_code]);
        $dataProvider->query->andWhere(['bc_settlement_account_bank_name' => $bank_id]);
        $file = "bc_sakhi_ifsc_code_wise_pendency_" . date("Y_m_d_H-m-s") . ".xlsx";
        header('Content-Type: application/xlsx; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Srl. No.', 'Name', 'District', 'Block', 'GP', 'Name Of Bank', 'IFSC Code', 'Onboarding Date', 'BC settlement a/c tagged for 194N', 'Pendency'));
        $sr_no = 1;
        $row = [];
        $dataProvider->pagination = false;
        $models = $dataProvider->getModels();
        foreach ($models as $model) {
            $row = [
                $sr_no,
                $model->name,
                $model->district_name,
                $model->block_name,
                $model->gram_panchayat_name,
                $model->bc_settlement_account_bank_name,
                $model->bc_settlement_account_ifsc_code,
                $model->onboarding_date_time,
                $model->bc_settlement_ac_194n == '1' ? 'Yes' : 'No',
                round((time() - strtotime($model->onboarding_date_time)) / (60 * 60 * 24))
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        exit();
    }
    public function actionDownloadac194ncsv() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
        $user_model = Yii::$app->user->identity;
        $searchModel = new RsetisBatchParticipantsSearch();
        $searchModel->shg_bank_option = \bc\modules\selection\models\base\GenralModel::shg_bank_option($searchModel);
        $searchModel->bc_bank_option = \bc\modules\selection\models\base\GenralModel::bc_bank_name_option($searchModel);
        $searchModel->show_blocked = 0;
        if (in_array($user_model->role, [MasterRole::ROLE_RBI])) {
            if (in_array($user_model->id, [326328, 326541])) {
                
            } else {
                $searchModel->bc_settlement_account_bank_name = \bc\modules\selection\models\base\GenralModel::rbi_user_bank($user_model->id);
            }
        }
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
        $dataProvider->query->andWhere(['srlm_bc_application.bc_operational' => 1]);
        $dataProvider->query->andWhere(['srlm_bc_application.bc_settlement_account_bank_name' => $searchModel->bc_settlement_account_bank_name]);
        $file = "bc_sakhi_" . date("Y_m_d_H-m-s") . ".xlsx";
        header('Content-Type: application/xlsx; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Srl. No.', 'Name', 'District', 'Block', 'GP', 'OTP Verified Mobile No.', 'Mobile No.', 'Name Of Bank','Bank Account No.', 'IFSC Code', 'Onboarding Date', 'BC settlement a/c tagged for 194N', 'Pendency'));
        $sr_no = 1;
        $row = [];
        $dataProvider->pagination = false;
        $models = $dataProvider->getModels();
        foreach ($models as $model) {
            $row = [
                $sr_no,
                $model->name,
                $model->district_name,
                $model->block_name,
                $model->gram_panchayat_name,
                $model->participant->mobile_no,
                $model->participant->mobile_number,
                $model->participant->bc_settlement_account_bank_name,
                $model->participant->bc_settlement_account_no,
                $model->participant->bc_settlement_account_ifsc_code,
                $model->participant->onboarding_date_time,
                $model->participant->bc_settlement_ac_194n == '1' ? 'Yes' : 'No',
                round((time() - strtotime($model->participant->onboarding_date_time)) / (60 * 60 * 24))
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        exit();
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }
    
    public function actionDownloadfull() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
        $user_model = Yii::$app->user->identity;
        $searchModel = new RsetisBatchParticipantsSearch();
        $searchModel->shg_bank_option = \bc\modules\selection\models\base\GenralModel::shg_bank_option($searchModel);
        $searchModel->bc_bank_option = \bc\modules\selection\models\base\GenralModel::bc_bank_name_option($searchModel);
        $searchModel->show_blocked = 0;
        if (in_array($user_model->role, [MasterRole::ROLE_RBI])) {
            if (in_array($user_model->id, [326328, 326541])) {
                
            } else {
                $searchModel->bc_settlement_account_bank_name = \bc\modules\selection\models\base\GenralModel::rbi_user_bank($user_model->id);
            }
        }
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
        $dataProvider->query->andWhere(['srlm_bc_application.bc_operational' => 1]);
        //$dataProvider->query->andWhere(['srlm_bc_application.bc_settlement_account_bank_name' => $searchModel->bc_settlement_account_bank_name]);
        $file = "bc_sakhi_" . date("Y_m_d_H-m-s") . ".xlsx";
        header('Content-Type: application/xlsx; charset=utf-8');
        header("Content-Disposition: attachment; filename=$file");
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Srl. No.', 'Name', 'OTP Verified Mobile No.', 'Mobile No.', 'District', 'Block', 'GP', 'Name Of Bank','Bank Account No.', 'BC settlement a/c tagged for 194N'));
        $sr_no = 1;
        $row = [];
        $dataProvider->pagination = false;
        $models = $dataProvider->getModels();
        foreach ($models as $model) {
            $row = [
                $sr_no,
                $model->name,
                $model->participant->mobile_no,
                $model->participant->mobile_number,
                $model->district_name,
                $model->block_name,
                $model->gram_panchayat_name,    
                $model->participant->bc_settlement_account_bank_name,
                $model->participant->bc_settlement_account_no,

                $model->participant->bc_settlement_ac_194n == '1' ? 'Yes' : 'No',
              
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        exit();
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
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
}
