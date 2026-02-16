<?php

namespace bc\modules\training\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use bc\models\master\MasterDistrict;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\form\RsetisBatchParticipantForm;
use bc\modules\training\models\BatchParticipants;
use bc\modules\training\models\BatchTraining;
use bc\modules\training\models\BatchTrainingSearch;
use bc\modules\training\models\form\BatchForm;
use bc\modules\training\models\RsetisBatchTraining;
use bc\modules\training\models\RsetisBatchTrainingSearch;

/**
 * Default controller for the `training` module
 */
class BatchController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'addparticipant', 'getparticipants'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'addparticipant', 'getparticipants'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        return $this->redirect(['/training/training']);
        $searchModel = new RsetisBatchTrainingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel->district_option = \bc\modules\selection\models\base\GenralModel::districtoption();
        if (count($searchModel->district_option) == 1) {
            $searchModel->district_code = key($searchModel->district_option);
        }
        $searchModel->center_option = \bc\modules\selection\models\base\GenralModel::center_option($searchModel);
        $searchModel->training_option = \bc\modules\selection\models\base\GenralModel::training_option($searchModel);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($batchid) {
        return $this->redirect(['/training/training']);
        $model = $this->findModel($batchid);
        $searchModelp = new \bc\modules\training\models\RsetisBatchParticipantsSearch();
        $searchModelp->rsetis_batch_id = $batchid;
        $dataProviderp = $searchModelp->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                        'model' => $model,
                        'searchModelp' => $searchModelp,
                        'dataProviderp' => $dataProviderp,
            ]);
        } else {
            return $this->render('view', [
                        'model' => $model,
                        'searchModelp' => $searchModelp,
                        'dataProviderp' => $dataProviderp,
            ]);
        }
    }

//    public function actionCreate() {
//        $model = new BatchForm();
//        if (count($model->district_option) == 1) {
//            $model->district_code = key($model->district_option);
//        }
//        if ($model->load(Yii::$app->request->post()) and $model->validate()) {
//            $model->batch_model->setAttributes([
//                'batch_name' => $model->batch_name,
//                'district_code' => $model->district_code,
//            ]);
//
//            if ($model->batch_model->save()) {
//                \Yii::$app->getSession()->setFlash('success', 'successfully saved');
//                return $this->redirect(['/training/batch/addparticipant?batchid=' . $model->batch_model->id]);
//            }
//        }
//        return $this->render('create', [
//                    'model' => $model,
//        ]);
//    }
//
//    public function actionUpdate($batchid) {
//        $batch_model = $this->findModel($batchid);
//        $model = new BatchForm($batch_model);
//        if (count($model->district_option) == 1) {
//            $model->district_code = key($model->district_option);
//        }
//        if ($model->load(Yii::$app->request->post()) and $model->validate()) {
//            $model->batch_model->setAttributes([
//                'batch_name' => $model->batch_name,
//                'district_code' => $model->district_code,
//            ]);
//            if ($model->batch_model->save()) {
//                \Yii::$app->getSession()->setFlash('success', 'successfully saved');
//                return $this->redirect(['/training/batch/addparticipant?batchid=' . $model->batch_model->id]);
//            }
//        }
//        return $this->render('create', [
//                    'model' => $model,
//        ]);
//    }

    public function actionAddparticipant($batchid) {
        return $this->redirect(['/training/training']);
        $bmodel = $this->findModel($batchid);
        $model = new \bc\modules\training\models\form\BatchParticipantForm($bmodel);

        if ($model->load(Yii::$app->request->post())) {

            $requestSize = sizeof($_REQUEST['BatchParticipantForm']['participant_ids']);
            if ($model->remaining_participant >= $requestSize) {
                foreach ($_REQUEST['BatchParticipantForm']['participant_ids'] as $participant) {
                    $batchp_model = new \bc\modules\training\models\RsetisBatchParticipants();
                    $bc_selection_app_model = SrlmBcApplication::find()->where(['id' => $participant])->one();
                    if ($bc_selection_app_model->training_status == 1) {
                        $batchp_model->setAttributes([
                            'bc_application_id' => $participant,
                            'rsetis_center_id' => $model->rsetis_center_id,
                            'rsetis_batch_id' => $model->rsetis_batch_id,
                            'rsetis_center_training_id' => $model->rsetis_center_training_id,
                            'bc_selection_user_id' => $bc_selection_app_model->srlm_bc_selection_user_id
                        ]);
                        if ($batchp_model->save()) {

                            $bc_selection_app_model->training_batch_id = $model->rsetis_batch_id;
                            $bc_selection_app_model->training_status = \bc\modules\selection\models\SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH;
                            $bc_selection_app_model->update();
                        }
                    }
                }
                $bmodel->update();
                if ($bmodel->training != null) {
                    $model = new \bc\modules\training\models\TrainingEntity($bmodel->training);
                    $model->calendarpopulate();
                }
                \Yii::$app->getSession()->setFlash('success', 'successfully saved');
                return $this->redirect(['index']);
            }
            return $this->redirect(['index']);
        }
        return $this->render('addparticipant', [
                    'model' => $model,
                    'bmodel' => $bmodel
        ]);
    }

    // 


    protected function findModel($id) {
        if (($model = RsetisBatchTraining::find()->where(['id'=>$id])->andWhere(['!=','status',-1])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetparticipants($block) {
        $status = \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL;
        $applications = SrlmBcApplication::find()->where(['block_code' => $block, 'form_number' => 6, 'gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['=', 'training_status', \bc\modules\selection\models\SrlmBcApplication::TRAINING_STATUS_AGREE_TRAINING])->orderBy('first_name asc')->all();

        if ($applications != null) {
            foreach ($applications as $application) {
                echo "<option value='" . $application->id . "'>" . $application->first_name . ' ' . $application->middle_name . ' ' . $application->sur_name . "</option>";
            }
        } else {
            echo "<option value=''>No Participants found</option>";
        }
    }

}
