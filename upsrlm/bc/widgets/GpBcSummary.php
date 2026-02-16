<?php

namespace bc\widgets;

use Yii;
use bc\modules\selection\models\form\DashboardSearchForm;
use bc\models\master\MasterDistrictSearch;
use bc\models\master\MasterBlockSearch;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;

/**
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class GpBcSummary extends \yii\base\Widget {

    public $model;

    /**
     * {@inheritdoc}
     */
    public function run() {
        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());

        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvidera = $searchModels->search($searchModel, Yii::$app->user->identity, 1);
        $dataProvidera->query->andWhere(['=', 'form_number', '6']);
        $dataProvidera->query->andWhere(['=', 'gender', '2']);
        $dataProvidera->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvidera->query->andWhere(['urban_shg' => 0]);
        $dataProvidera->query->andWhere(['blocked' => 0]);
        if ($this->model->master_partner_bank_id) {
            $dataProvidera->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.master_partner_bank_id' => $this->model->master_partner_bank_id]);
        }
        $dataProvidera->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.training_status' => 1]);
        $searchModelsab = new SrlmBcApplicationSearch();
        $dataProviderab = $searchModelsab->search($searchModel, Yii::$app->user->identity, 1);
        $dataProviderab->query->andWhere(['=', 'form_number', '6']);
        $dataProviderab->query->andWhere(['=', 'gender', '2']);
        $dataProviderab->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProviderab->query->andWhere(['urban_shg' => 0]);
        $dataProviderab->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.training_status' => [0, 1, 2]]);
        $dataProviderab->query->andWhere(['!=', 'blocked', '0']);
        $dataProviderab->query->andWhere(['blocked' => [SrlmBcApplication::BLOCKED_STATUS_BC_SHG_GP_MISMATCH, SrlmBcApplication::BLOCKED_STATUS_EDUCATION_ELIGIBILITY, SrlmBcApplication::BLOCKED_STATUS_PHONE_INUSED, SrlmBcApplication::BLOCKED_STATUS_BC_GP, SrlmBcApplication::BLOCKED_STATUS_MISSING_BC, SrlmBcApplication::BLOCKED_STATUS_AGE_ELIGIBILITY, SrlmBcApplication::BLOCKED_STATUS_PFMS, SrlmBcApplication::BLOCKED_STATUS_AADHAR]]);
        if ($this->model->master_partner_bank_id) {
            $dataProviderab->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.master_partner_bank_id' => $this->model->master_partner_bank_id]);
        }
        $searchModelsinb = new SrlmBcApplicationSearch();
        $dataProviderinb = $searchModelsinb->search($searchModel, Yii::$app->user->identity, 1);
        $dataProviderinb->query->andWhere(['=', 'form_number', '6']);
        $dataProviderinb->query->andWhere(['=', 'gender', '2']);
        $dataProviderinb->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProviderinb->query->andWhere(['urban_shg' => 0]);
        $dataProviderinb->query->andWhere(['blocked' => 0]);
        $dataProviderinb->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.training_status' => 2]);
        if ($this->model->master_partner_bank_id) {
            $dataProviderinb->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.master_partner_bank_id' => $this->model->master_partner_bank_id]);
        }
        $searchModelcb = new \bc\modules\selection\models\SrlmBcApplicationSearch();
        $dataProvidercb = $searchModelcb->search($searchModel, Yii::$app->user->identity, 1);
        $dataProvidercb->query->andWhere(['!=', 'srlm_bc_application.form_number', '0']);
        $dataProvidercb->query->andWhere(['=', 'srlm_bc_application.form_number', '6']);
        $dataProvidercb->query->andWhere(['=', 'srlm_bc_application.gender', '2']);
        $dataProvidercb->query->andWhere(['srlm_bc_application.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvidercb->query->andWhere(['!=', 'blocked', 0]);
        $dataProvidercb->query->andWhere(['!=', 'blocked', 2]);
        $dataProvidercb->query->andWhere(['!=', 'blocked', 21]);
        $dataProvidercb->query->andWhere(['srlm_bc_application.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
        if ($this->model->master_partner_bank_id) {
            $dataProvidercb->query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.master_partner_bank_id' => $this->model->master_partner_bank_id]);
        }
        return $this->render('gpbcsummary', [
                    'model' => $this->model,
                    'dataProvidera' => $dataProvidera,
                    'dataProviderab' => $dataProviderab,
                    'dataProviderinb' => $dataProviderinb,
                    'dataProvidercb' => $dataProvidercb,
        ]);
    }
}
