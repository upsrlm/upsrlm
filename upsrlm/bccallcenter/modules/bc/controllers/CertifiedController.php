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
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\form\AddScoreForm;
use common\models\master\MasterRole;
use yii\web\UploadedFile;
use common\models\CboMembers;
use common\models\User;
use common\models\CboMemberProfile;

/**
 * Default controller for the `bc` module
 */
class CertifiedController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'csvdownload', 'bankstatus', 'igrs'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'csvdownload', 'bankstatus', 'igrs'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $searchModel = new RsetisBatchParticipantsSearch();
        $searchModel->show_blocked = 0;
        if (Yii::$app->request->isGet)
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (Yii::$app->request->isPost)
            $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);

        if ($searchModel->rishta_access_page != '') {
            if ($searchModel->rishta_access_page == '0') {
                $dataProvider->query->andWhere(['srlm_bc_application.rishta_access_page_count' => 0]);
                $dataProvider->query->andWhere(['not', ['srlm_bc_application.user_id' => null]]);
                $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
                //$dataProvider->query->andWhere(['>', 'srlm_bc_application.no_of_transaction', 0]);
            }
            if ($searchModel->rishta_access_page == '1') {
                $dataProvider->query->andWhere(['>', 'srlm_bc_application.rishta_access_page_count', 0]);
            }
        }
        $searchModel->division_option = \bc\modules\selection\models\base\GenralModel::divisionoption();
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
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
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIgrs() {
        $searchModel = new RsetisBatchParticipantsSearch();
        $searchModel->igrs = 1;
        $searchModel->show_blocked = 0;
        if (Yii::$app->request->isGet)
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (Yii::$app->request->isPost)
            $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);

        if ($searchModel->rishta_access_page != '') {
            if ($searchModel->rishta_access_page == '0') {
                $dataProvider->query->andWhere(['srlm_bc_application.rishta_access_page_count' => 0]);
                $dataProvider->query->andWhere(['not', ['srlm_bc_application.user_id' => null]]);
                $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
                //$dataProvider->query->andWhere(['>', 'srlm_bc_application.no_of_transaction', 0]);
            }
            if ($searchModel->rishta_access_page == '1') {
                $dataProvider->query->andWhere(['>', 'srlm_bc_application.rishta_access_page_count', 0]);
            }
        }
        $searchModel->division_option = \bc\modules\selection\models\base\GenralModel::divisionoption();
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption($searchModel);
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
        return $this->render('igrs', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBankstatus($bcid) {
        $bc_model = $this->findModelbc($bcid);
        $model = new \bc\modules\selection\models\form\VerificationBankDetailForm($bc_model);

        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('bank_detail_status', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('bank_detail_status', [
                        'model' => $model,
            ]);
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

    public function actionCsvdownload() {
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '-1');
        try {
            $searchModel = new RsetisBatchParticipantsSearch();
            if (Yii::$app->request->isGet)
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            if (Yii::$app->request->isPost)
                $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
            $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
            if (count($searchModel->district_option) == 1) {
                $searchModel->district_code = key($searchModel->district_option);
            }
            $dataProvider->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dataProvider->query->select(['rsetis_batch_participants.id', 'rsetis_batch_participants.first_name', 'bc_application_id']);

            $dataProvider->query->asArray();
            $dataProvider->pagination = false;
            $models = $dataProvider->getModels();
            $file = "certified_bc_" . date("Y_m_d_H-m-s") . ".csv";
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
                'UPSRLM SHG Name',
                'Office Bearers ',
                'BC bank a/c',
                'बी0सी0 सखी बैंक विवरण',
                'SHG bank a/c',
                'बी0सी0 सखी स्वयं सहायता समूह बैंक विवरण',
                'BC-SHG payment status',
                'PAN photo',
                'BC photo',
                'PIN',
                'Got PIN'
            ));

            $sr_no = 1;
            $row = [];
            foreach ($models as $model) {
                $model = RsetisBatchParticipants::findOne($model['id']);
                $shg = \cbo\models\Shg::findOne($model->participant->cbo_shg_id);
                $status = '';
                if ($model->participant->bc_shg_funds_status == 1) {
                    $status = 'Yes';
                }
                if ($model->participant->bc_shg_funds_status == 0) {
                    $status = 'No';
                }
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
                    isset($model->participant->bank_account_no_of_the_bc) ? 'Yes' : 'No',
                    strip_tags($model->participant->bcbanks),
                    ($model->participant->bank_account_no_of_the_shg != null) ? 'Yes' : 'No',
                    strip_tags($model->participant->shgbanks),
                    $status,
                    $model->participant->pan_photo_upload == 1 ? 'Yes' : 'No',
                    $model->participant->bc_photo_status == 1 ? 'Yes' : 'No',
                    (isset($model->participant->user->pin) and $model->participant->blocked == '0') ? $model->participant->user->pin : '',
                    (isset($model->participant) and $model->participant->pin_used == 1) ? 'Yes' : 'No',
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
