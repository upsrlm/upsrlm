<?php

namespace bc\modules\training\controllers;

use Yii;
use bc\modules\training\models\RsetisCenterTrainingSearch;
use bc\modules\training\models\form\RsetisBatchTrainingForm;
use bc\modules\training\models\form\CenterTrainingForms;
use bc\modules\training\models\RsetisCenterTraining;
use bc\modules\training\models\RsetisBatchTraining;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\RsetisBatchParticipants;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\master\MasterRole;
use yii\web\UploadedFile;

/**
 * Default controller for the `training` module
 */
class TrainingController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'remove'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'remove'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'remove' => ['POST'],
                    'conclude' => ['POST']
                ],
            ],
        ];
    }

    public function BeforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        $searchModel = new RsetisCenterTrainingSearch();
        if (Yii::$app->request->isGet)
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (Yii::$app->request->isPost)
            $dataProvider = $searchModel->search(Yii::$app->request->post(), Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModel->batch_size_option = [1 => '< 20', 2 => '20-30', 3 => '> 30'];
        $searchModel->bank_option = \bc\modules\selection\models\base\GenralModel::partner_bank_option($searchModel);
        $rseth_bank_query = \common\models\dynamicdb\bc\User::find()->select(['user.id','user.name'])->joinWith(['profile', 'districts'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_RSETIS_DISTRICT_UNIT, 'user.status' => 10]);
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK])) {
            $rseth_bank_query->andWhere(['relation_user_district.district_code' => \yii\helpers\ArrayHelper::getColumn(Yii::$app->user->identity->districts, 'district_code')]);
        }
        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
            $rseth_bank_query->andWhere(['user.id' => Yii::$app->user->identity->id]);
        }
        $rseth_bank = $rseth_bank_query->orderBy('bank_name asc')->all();
//        $partner_bank_query = \common\models\dynamicdb\bc\User::find()->select(['user.id','user.name'])->joinWith(['profile', 'districts'])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_BANK_DISTRICT_UNIT, 'user.status' => 10]);
//        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_RSETIS_NODAL_BANK])) {
//            $partner_bank_query->andWhere(['relation_user_district.district_code' => \yii\helpers\ArrayHelper::getColumn(Yii::$app->user->identity->districts, 'district_code')]);
//        }
//        if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
//            $partner_bank_query->andWhere(['user.id' => Yii::$app->user->identity->id]);
//        }
//        $partner_bank_bank = $partner_bank_query->orderBy('name asc')->all();
        $searchModel->rseti_bank_option = \yii\helpers\ArrayHelper::map($rseth_bank, 'profile.bank_name', 'profile.bank_name');
        //$searchModel->bc_partner_bank_option = \yii\helpers\ArrayHelper::map($partner_bank_bank, 'id', 'name');
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDownloadcsv() {
        try {

            $searchModel = new RsetisCenterTrainingSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
            $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
            $models = $dataProvider->getModels();
            $file = "training_batch_" . date("Y_m_d_H-m-s") . ".csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=$file");
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Sr No', 'Batch Name', 'Training Start Date', 'Training End Date', 'Contact Person', 'RSETI Bank', 'BC Partner Bank', 'District', 'Shedule date of exam', 'No Of Participant', 'Batch Status'));
            $sr_no = 1;
            $row = [];
            foreach ($models as $model) {
                $contacts = '';
                if ($model->contacts != null) {
                    foreach ($model->contacts as $contact) {
                        $contacts .= $contact->user->name . " (" . $contact->user->mobile_no . ")" . " ";
                    }
                }
                $bcp = '';
                if ($model->bcbankpartner != null) {
                    foreach ($model->bcbankpartner as $bcbankpartner) {
                        $bcp .= $bcbankpartner->user->name . " ";
                    }
                }

                $row = [
                    $sr_no,
                    isset($model->tbatch) ? $model->tbatch->batch_name : '',
                    date("d-m-Y", strtotime($model->training_start_date)),
                    date("d-m-Y", strtotime($model->training_end_date)),
                    $contacts,
                    implode(" ", array_unique(yii\helpers\ArrayHelper::getColumn($model->rsethileadbank, 'profile.bank_name'))),
                    $bcp,
                    $model->district_name,
                    $model->schedule_date_of_exam != null ? \Yii::$app->formatter->asDatetime($model->schedule_date_of_exam, "php:d-m-Y") : "",
                    $model->no_of_participant,
                    $model->batchstatus
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

    public function actionUpdate($trainingid) {
        $tramodel = $this->findModel($trainingid);
        if ($tramodel->status == 2) {
            return $this->redirect(['index']);
        }
        $model = new \bc\modules\training\models\form\CenterTrainingForm($tramodel, $tramodel->district_code);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }


        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    public function actionView($trainingid) {

        $model = $this->findModel($trainingid);
        $searchModelb = new \bc\modules\training\models\RsetisBatchTrainingSearch();
        $searchModelb->rsetis_center_training_id = $trainingid;
        $dataProviderb = $searchModelb->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModelp = new \bc\modules\training\models\RsetisBatchParticipantsSearch();
        $searchModelp->rsetis_center_training_id = $trainingid;
        $dataProviderp = $searchModelp->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                        'model' => $model,
                        'searchModelb' => $searchModelb,
                        'searchModelp' => $searchModelp,
                        'dataProviderb' => $dataProviderb,
                        'dataProviderp' => $dataProviderp,
            ]);
        } else {
            return $this->render('view', [
                        'model' => $model,
                        'searchModelb' => $searchModelb,
                        'searchModelp' => $searchModelp,
                        'dataProviderb' => $dataProviderb,
                        'dataProviderp' => $dataProviderp,
            ]);
        }
    }

    public function actionGetbatch($centerid) {
        $cmodel = \bc\modules\training\models\RsetisCenter::findOne($centerid);
        if ($cmodel != null) {
            $batches = RsetisBatchTraining::find()->where(['district_code' => $cmodel->district_code, 'rsetis_center_training_id' => 0])->all();
            if ($batches != null) {
                foreach ($batches as $batch) {
                    echo "<option value='" . $batch->id . "'>" . $batch->batch_name . ' ' . "</option>";
                }
            } else {
                echo "<option value=''>No Batch found</option>";
            }
        } else {
            echo "<option value=''>No Batch found</option>";
        }
    }

    public function actionRemove($trainingid) {
        $model = $this->findModel($trainingid);
        if ($model->no_of_participant == 0) {
            $model->status = -1;
            $model->tbatch->status = -1;
            if ($model->save() and $model->tbatch->save()) {
                $model->center->update();
                $models = new \bc\modules\training\models\TrainingEntity($model);
                $models->calendarpopulate();
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionConclude($trainingid) {
        $model = $this->findModel($trainingid);
        if ($model->getParticipant()->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.training_status' => SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH])->count() == 0) {
            $model->status = 2;
            $model->tbatch->status = 2;
            if ($model->save() and $model->tbatch->save()) {
                $model->center->update();
                $models = new \bc\modules\training\models\TrainingEntity($model);
                $models->calendarpopulate();
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionUnconclude($trainingid) {
        $model = $this->findModel($trainingid);
        if ($model->getParticipant()->count() >= 0) {
            $model->status = 1;
            $model->tbatch->status = 1;
            if ($model->save() and $model->tbatch->save()) {
                $model->center->update();
                $models = new \bc\modules\training\models\TrainingEntity($model);
                $models->calendarpopulate();
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionUploadgroupphoto($trainingid) {
        $training_model = $this->findModel($trainingid);
        $model = new \bc\modules\training\models\form\UploadTrainingBatchGroupPhotoForm($training_model);
        //$this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            $model->group_photo_file_name = UploadedFile::getInstance($model, 'group_photo_file_name');
            $APPLICATION_FORM_FILE_FOLDER = \Yii::$app->params['bcdatapath'];
            $APPLICATION_FORM_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . "bcselection/training/";
            if (!file_exists($APPLICATION_FORM_FILE_FOLDER)) {
                mkdir($APPLICATION_FORM_FILE_FOLDER);
                chmod($APPLICATION_FORM_FILE_FOLDER, 0777);
            }
            if (!file_exists($APPLICATION_FORM_FILE_FOLDER . $training_model->id)) {
                mkdir($APPLICATION_FORM_FILE_FOLDER . $training_model->id);
                chmod($APPLICATION_FORM_FILE_FOLDER . $training_model->id, 0777);
            }

            if ($model->group_photo_file_name != null) {
                $new_file_name = 'group_photo' . '_' . time() . '_' . $model->group_photo_file_name->name;
                if ($model->group_photo_file_name->saveAs($APPLICATION_FORM_FILE_FOLDER . $training_model->id . '/' . $new_file_name)) {
                    chmod($APPLICATION_FORM_FILE_FOLDER . $training_model->id . '/' . $new_file_name, 0777);
                    $model->training_model->group_photo_status = 1;
                    $model->training_model->group_photo_upload_by = Yii::$app->user->identity->id;
                    $model->training_model->group_photo_upload_date = new \yii\db\Expression('NOW()');
                    $model->training_model->group_photo_file_name = $new_file_name;
                    if ($model->training_model->update()) {
                        \Yii::$app->getSession()->setFlash('success', 'Group Photo upload successfully');
                        return $this->redirect(['/training/training']);
                    }
                }
            }
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_uploadgroupphotoform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_uploadgroupphotoform', [
                        'model' => $model,
            ]);
        }
    }

    public function actionPdf($trainingid) {
        date_default_timezone_set("Asia/Calcutta");
        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', '2048M');
        $this->layout = 'pdf';

        $model = $this->findModel($trainingid);
        $searchModelp = new \bc\modules\training\models\RsetisBatchParticipantsSearch();
        $searchModelp->rsetis_center_training_id = $trainingid;
        $dataProviderp = $searchModelp->search(Yii::$app->request->queryParams, Yii::$app->user->identity, false);
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
            <td style="text-align:center;vertical-align: top;border:none;font-size:20px;font-weight:bold"></td>
            <tr>
           </table>');
        //$mpdf->setFooter('{PAGENO} / {nb}');
        if ($mpdf->PageNo() == 1) {
            
        }
        $content = $this->renderPartial('_pdf', [
            'model' => $model,
            'searchModelp' => $searchModelp,
            'dataProviderp' => $dataProviderp,
        ]);
        $stylesheet = '';
        $stylesheet .= file_get_contents(Yii::getAlias('@bc') . '/themes/field/assets/css/bootstrap.css');
//        $stylesheet .= file_get_contents(Yii::getAlias('@bc') . '/themes/field/assets/css/font-awesome.css');
//        $stylesheet .= file_get_contents(Yii::getAlias('@bc') . '/themes/field/assets/css/ace-fonts.css');
//        $stylesheet .= file_get_contents(Yii::getAlias('@bc') . '/themes/field/assets/css/ace.css');
//        $stylesheet .= file_get_contents(Yii::getAlias('@bc') . '/themes/field/assets/css/addon-tli.css');

        $html = '<style>';
        //$html .= $stylesheet;    
        $html .= ' table {
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
        //$html .= $stylesheet;

        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->WriteHTML($html);
        $mpdf->Output($model->tbatch->batch_name . '.pdf', 'D');
        exit;
    }

    protected function findModel($id) {
        if (($model = RsetisCenterTraining::find()->where(['id' => $id])->andWhere(['!=', 'status', -1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
