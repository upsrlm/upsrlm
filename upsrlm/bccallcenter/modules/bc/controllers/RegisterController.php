<?php

namespace bccallcenter\modules\bc\controllers;

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
use common\models\CboMemberProfile;

/**
 * Default controller for the `bc` module
 */
class RegisterController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'csvdownload', 'bankstatus'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'csvdownload', 'bankstatus'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {

        if (Yii::$app->request->isGet)
            $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
        if (Yii::$app->request->isPost)
            $searchModel = new DashboardSearchForm(Yii::$app->request->post());
        $searchModels = new SrlmBcApplicationSearch();

        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 30,null,\bc\modules\selection\models\base\GenralModel::select_preselected_bc_column()); //, Yii::$app->user->identity, 150);

        $dataProvider->query->andWhere(['=', 'form_number', '6']);
        $dataProvider->query->andWhere(['=', 'gender', '2']);
        //$dataProvider->query->andWhere(['=', 'blocked', '0']);
        //$dataProvider->query->andWhere(['not in', 'srlm_bc_application.selection_by', [15]]);
        $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere(['training_status' => [0, 1, 2]]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
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

    public function actionCsvdownload() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            if (Yii::$app->request->isGet)
                $searchModel = new DashboardSearchForm(Yii::$app->request->queryParams);
            if (Yii::$app->request->isPost)
                $searchModel = new DashboardSearchForm(Yii::$app->request->post());
            $searchModels = new SrlmBcApplicationSearch();

            $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, 30, null, \bc\modules\selection\models\base\GenralModel::select_preselected_bc_column()); //, Yii::$app->user->identity, 150);

            $dataProvider->query->andWhere(['=', 'form_number', '6']);
            $dataProvider->query->andWhere(['=', 'gender', '2']);
            //$dataProvider->query->andWhere(['=', 'blocked', '0']);
           // $dataProvider->query->andWhere(['not in', 'srlm_bc_application.selection_by', [14]]);
            $dataProvider->query->andWhere(['status' => SrlmBcApplication::STATUS_PROVISIONAL]);
            $dataProvider->query->andWhere(['training_status' => [0, 1, 2]]);
            $dataProvider->query->asArray();
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            $file = "preselected_bc_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array(
                'Sr No',
                'id',
                'Application No',
                'Name of BC',
                'Mobile Number',
                'OTP Verified mobile no',
                'District',
                'District code',
                'Block',
                'Block code',
                'Gram Panchayat',
                'Gram Panchayat code',
                'Status',
                'Blocked',
                'PIN',
                'Got PIN'
            ));

            $sr_no = 1;
            $row = [];
            foreach ($models as $model) {
                $model = SrlmBcApplication::findOne($model['id']);
                
                $row = [
                    $sr_no,
                    $model->id,
                    $model->application_id,
                    $model->name,
                    $model->mobile_number,
                    $model->user->mobile_no,
                    $model->district_name,
                    $model->district_code,
                    $model->block_name,
                    $model->block_code,
                    $model->gram_panchayat_name,
                    $model->gram_panchayat_code,
                    $model->tstatus,
                    $model->blocked == 0 ? 'No' : 'Yes',
                    (isset($model->user->pin) and $model->blocked == '0') ? $model->user->pin : '',
                    (isset($model) and $model->pin_used == 1) ? 'Yes' : 'No',
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
