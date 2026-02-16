<?php

namespace bc\modules\report\controllers;

use Yii;
use yii\web\Controller;
use bc\modules\selection\models\form\DashboardSearchForm;
use bc\models\master\MasterDistrictSearch;
use bc\models\master\MasterBlockSearch;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use bc\models\srlm\SrlmBcApplicationGroupFamily;
use common\models\master\MasterRole;
use bc\components\srlm\BcApplication;
use bc\models\srlm\report\Graph;
use bc\modules\training\models\form\TrainingAgreeForm;
use bc\modules\training\models\RsetisCenterTrainingSearch;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\training\models\RsetisBatchParticipantsSearch;

/**
 * Default controller for the `report` module
 */
class DownloadController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'cpendencycsv', 'pvrpendencycsv'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'cpendencycsv', 'pvrpendencycsv'],
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

        $searchModel = [];
        $dataProvider = [];

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPvrpendencycsv() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $searchModel = new RsetisBatchParticipantsSearch();
            $searchModel->show_blocked = 0;
            $searchModel->training_status = SrlmBcApplication::TRAINING_STATUS_PASS;
            if (Yii::$app->request->isGet) {
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            }
            if (Yii::$app->request->isPost) {
                $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            }

            $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
            if (count($searchModel->district_option) == 1) {
                $searchModel->district_code = key($searchModel->district_option);
            }
            $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dataProvider->query->andWhere(['srlm_bc_application.urban_shg' => 0]);
            $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dataProvider->query->andWhere(['srlm_bc_application.pvr_status' => 0]);
            $dataProvider->query->select(['rsetis_batch_participants.id', 'rsetis_batch_participants.first_name', 'bc_application_id']);
            $dataProvider->query->addOrderBy("rsetis_batch_participants.first_name asc");
            $dataProvider->pagination = false;
            $dataProvider->query->asArray();
            $models = $dataProvider->getModels();
            $file = "PVR_Pendency_list_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Application ID', 'Name', 'Guardian Name', 'Mobile Number', 'OTP Verified mobile no', 'District', 'Block', 'Gram Panchayat', 'Village'));
            $sr_no = 1;
            $row = [];
            foreach ($models as $model) {
                $model = RsetisBatchParticipants::findOne($model['id']);
                $row = [
                    $sr_no,
                    $model->participant->application_id,
                    trim($model->name),
                    $model->participant->guardian_name,
                    $model->participant->mobile_number,
                    $model->participant->mobile_no,
                    $model->participant->district_name,
                    $model->participant->block_name,
                    $model->participant->gram_panchayat_name,
                    $model->participant->village_name,
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

    public function actionCpendencycsv() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $dataProvider = [];
            $user_model = Yii::$app->user->identity;
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
            $searchModels = new SrlmBcApplicationSearch();
            $searchModel->training_status = 0;
            $searchModels->training_status = 0;
            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, false, 'srlm_bc_application.id');
            $dataProvider->query->andWhere(['training_status' => 0]);
            $dataProvider->query->andWhere(['=', 'form_number', '6']);
            $dataProvider->query->andWhere(['=', 'gender', '2']);
            $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
            $dataProvider->query->andWhere(['missing_bc' => 0]);
            $dataProvider->query->andWhere(['urban_shg' => 0]);
            $dataProvider->query->andWhere(['blocked' => 0]);
            //$dataProvider->query->andWhere(['not in', 'srlm_bc_application.selection_by', [15]]);
            $dataProvider->query->addOrderBy("first_name asc");
            $file_name = "Certified_BC_pendency_list_" . date("Y_m_d_H-m-s") . '.csv';
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file_name");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Application ID', 'Name', 'Guardian Name', 'Mobile Number', 'OTP Verified mobile no', 'District', 'Block', 'Gram Panchayat', 'Village'));
            $models = $dataProvider->getModels();

            $sr_no = 1;
            foreach ($models as $model) {
                $model = SrlmBcApplication::findOne($model['id']);
                $education = $model->readingskills != null ? $model->readingskills->name_eng : '';
                $row = [
                    $sr_no,
                    $model->application_id,
                    $model->name,
                    $model->guardian_name,
                    $model->mobile_number,
                    $model->mobile_no,
                    $model->district_name,
                    $model->block_name,
                    $model->gram_panchayat_name,
                    $model->village_name,
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
            exit;
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
            exit;
        }
    }
}
