<?php

namespace app\modules\master\controllers;

use Yii;
use common\models\master\MasterVillage;
use common\models\master\MasterVillageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MasterVillageController implements the CRUD actions for MasterVillage model.
 */
class MasterVillageController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MasterVillage models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MasterVillageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MasterVillage model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MasterVillage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new \app\models\form\MasterVillageForm();
        if ($model->load(Yii::$app->request->post())) {
            $model->mastervillage->setAttributes([
                'state_code' => $model->state_code,
                'state_name' => $model->state_name,
                'district_code' => $model->district_code,
                'district_name' => $model->district_name,
                'sub_district_code' => $model->sub_district_code,
                'sub_district_name' => $model->sub_district_name,
//                'block_id' => $model->block_id,
                'block_code' => $model->block_code,
                'block_name' => $model->block_name,
                'village_code' => $model->village_code,
                'village_name' => $model->village_name,
//                'gram_panchayat_id' => $model->gram_panchayat_id,
                'gram_panchayat_code' => $model->gram_panchayat_code,
                'gram_panchayat_name' => $model->gram_panchayat_name,
            ]);

            if ($model->mastervillage->save()) {
                Yii::$app->getSession()->setFlash('success', 'Data Added Successfully!');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterVillage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
         $mastervillage = $this->findModel($id);
        $model = new \app\models\form\MasterVillageForm($mastervillage);
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('update', [
//                    'model' => $model,
//        ]);
        if ($model->load(Yii::$app->request->post())) {
            $model->mastervillage->setAttributes([
               'state_code' => $model->state_code,
                'state_name' => $model->state_name,
                'district_code' => $model->district_code,
                'district_name' => $model->district_name,
                'sub_district_code' => $model->sub_district_code,
                'sub_district_name' => $model->sub_district_name,
//                'block_id' => $model->block_id,
                'block_code' => $model->block_code,
                'block_name' => $model->block_name,
                'village_code' => $model->village_code,
                'village_name' => $model->village_name,
//                'gram_panchayat_id' => $model->gram_panchayat_id,
                'gram_panchayat_code' => $model->gram_panchayat_code,
                'gram_panchayat_name' => $model->gram_panchayat_name,
            ]);

            if ($model->mastervillage->save()) {
                Yii::$app->getSession()->setFlash('success', 'Data updated Successfully!');
                return $this->redirect(['index']);
            }
        }


        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MasterVillage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MasterVillage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MasterVillage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = MasterVillage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
