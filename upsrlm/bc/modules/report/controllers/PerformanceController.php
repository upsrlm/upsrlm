<?php

namespace bc\modules\report\controllers;

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
use bc\modules\training\models\form\AddScoreForm;
use common\models\master\MasterRole;
use yii\web\UploadedFile;
use common\models\CboMembers;
use common\models\User;
use bc\models\DistrictPerformanceBcsakhiProgramSearch;

/**
 * Default controller for the `bc` module
 */
class PerformanceController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        return $this->redirect(['/report/performance/chart1']);
        try {
            $user_model = Yii::$app->user->identity;
            $params = [];
            if (Yii::$app->request->isGet) {
                $params = Yii::$app->request->queryParams;
            }
            if (Yii::$app->request->isPost) {
                $params = Yii::$app->request->post();
            }
            $searchModel1 = new \bc\models\report\Performance($params);
            if (in_array($user_model->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_SPM_FINANCE])) {
                
            } else {
                $searchModel1->master_partner_bank_id = $user_model->master_partner_bank_id;
            }
            $searchModel1->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option();
            $report = $searchModel1->chart($searchModel1, Yii::$app->user->identity);

            return $this->render('report', [
                        'searchModel' => $searchModel1,
                        'report' => $report
            ]);
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function actionChart1() {
        try {
            $user_model = Yii::$app->user->identity;
            $params = [];
            if (Yii::$app->request->isGet) {
                $params = Yii::$app->request->queryParams;
            }
            if (Yii::$app->request->isPost) {
                $params = Yii::$app->request->post();
            }
            $searchModel1 = new \bc\models\report\Performance($params);
            if (in_array($user_model->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_SPM_FINANCE])) {
                
            } else {
                $searchModel1->master_partner_bank_id = $user_model->master_partner_bank_id;
            }
            $searchModel1->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option();
            $report = $searchModel1->chart($searchModel1, Yii::$app->user->identity);
            $searchModel1->ordey_by_column = 'certified_percentage';
            $report1 = $searchModel1->chart1($searchModel1, Yii::$app->user->identity);

            return $this->render('chart1', [
                        'searchModel' => $searchModel1,
                        'report' => $report,
                        'report1' => $report1
            ]);
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function actionChart2() {
        try {
            $user_model = Yii::$app->user->identity;
            $params = [];
            if (Yii::$app->request->isGet) {
                $params = Yii::$app->request->queryParams;
            }
            if (Yii::$app->request->isPost) {
                $params = Yii::$app->request->post();
            }
            $searchModel1 = new \bc\models\report\Performance($params);
            if (in_array($user_model->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_SPM_FINANCE])) {
                
            } else {
                $searchModel1->master_partner_bank_id = $user_model->master_partner_bank_id;
            }
            $searchModel1->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option();
            $report = $searchModel1->chart($searchModel1, Yii::$app->user->identity);
            $searchModel1->ordey_by_column = 'operational_percentage';
            $report1 = $searchModel1->chart1($searchModel1, Yii::$app->user->identity);

            return $this->render('chart2', [
                        'searchModel' => $searchModel1,
                        'report' => $report,
                        'report1' => $report1
            ]);
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function actionChart3() {
        try {
            $user_model = Yii::$app->user->identity;
            $params = [];
            if (Yii::$app->request->isGet) {
                $params = Yii::$app->request->queryParams;
            }
            if (Yii::$app->request->isPost) {
                $params = Yii::$app->request->post();
            }
            $searchModel1 = new \bc\models\report\Performance($params);
            if (in_array($user_model->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_SPM_FINANCE])) {
                
            } else {
                $searchModel1->master_partner_bank_id = $user_model->master_partner_bank_id;
            }
            $searchModel1->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option();
            $report = $searchModel1->chart($searchModel1, Yii::$app->user->identity);
            $searchModel1->ordey_by_column = 'avg_working_day_percentage';
            $report1 = $searchModel1->chart1($searchModel1, Yii::$app->user->identity);

            return $this->render('chart3', [
                        'searchModel' => $searchModel1,
                        'report' => $report,
                        'report1' => $report1
            ]);
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function actionChart4() {
        try {
            $user_model = Yii::$app->user->identity;
            $params = [];
            if (Yii::$app->request->isGet) {
                $params = Yii::$app->request->queryParams;
            }
            if (Yii::$app->request->isPost) {
                $params = Yii::$app->request->post();
            }
            $searchModel1 = new \bc\models\report\Performance($params);
            if (in_array($user_model->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_SPM_FINANCE])) {
                
            } else {
                $searchModel1->master_partner_bank_id = $user_model->master_partner_bank_id;
            }
            $searchModel1->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option();
            $report = $searchModel1->chart($searchModel1, Yii::$app->user->identity);
            $searchModel1->ordey_by_column = 'avg_transcation_rating';
            $report1 = $searchModel1->chart1($searchModel1, Yii::$app->user->identity);

            return $this->render('chart4', [
                        'searchModel' => $searchModel1,
                        'report' => $report,
                        'report1' => $report1
            ]);
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function actionChart5() {
        try {
            $user_model = Yii::$app->user->identity;
            $params = [];
            if (Yii::$app->request->isGet) {
                $params = Yii::$app->request->queryParams;
            }
            if (Yii::$app->request->isPost) {
                $params = Yii::$app->request->post();
            }
            $searchModel1 = new \bc\models\report\Performance($params);
            if (in_array($user_model->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_BC_VIEWER, MasterRole::ROLE_SPM_FINANCE])) {
                
            } else {
                $searchModel1->master_partner_bank_id = $user_model->master_partner_bank_id;
            }
            $searchModel1->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option();
            $report = $searchModel1->chart($searchModel1, Yii::$app->user->identity);
            $searchModel1->ordey_by_column = 'avg_commission_amount_rateing';
            $report1 = $searchModel1->chart1($searchModel1, Yii::$app->user->identity);

            return $this->render('chart5', [
                        'searchModel' => $searchModel1,
                        'report' => $report,
                        'report1' => $report1
            ]);
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function actionBcsakhiprogram() {
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $searchModel = new DashboardSearchForm($params);
        if (!$searchModel->master_partner_bank_id) {
          $searchModel->master_partner_bank_id=0;  
        }
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option_current();
        $searchModels = new DistrictPerformanceBcsakhiProgramSearch();

        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 100, null); //, Yii::$app->user->identity, 150);

        return $this->render('bcsakhiprogram', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
}
