<?php

namespace app\modules\master\controllers;

use Yii;
use common\models\master\MasterUlb;
use common\models\master\MasterUlbSearch;
use common\models\base\GenralModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MasterTownController implements the CRUD actions for MasterTown model.
 */
class MasterUlbController extends Controller {

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
     * Lists all MasterTown models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MasterUlbSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        //$searchModel->town_option = \app\models\base\GenralModel::townoption($searchModel);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MasterTown model.
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
     * Creates a new MasterTown model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new \app\models\form\MasterTownForm();
//        $model = new MasterTown();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['index']);
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
        if ($model->load(Yii::$app->request->post())) {
            $model->mastertown->setAttributes([
                'state_code' => $model->state_code,
                'state_name' => $model->state_name,
                'district_code' => $model->district_code,
                'district_name' => $model->district_name,
                'sub_district_code' => $model->sub_district_code,
                'sub_district_name' => $model->sub_district_name,
                'town_code' => $model->town_code,
                'town_name' => $model->town_name,
                'town_type' => $model->town_type,
            ]);

            if ($model->mastertown->save()) {
                Yii::$app->getSession()->setFlash('success', 'Data Added Successfully!');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterTown model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $mastertown = $this->findModel($id);
        $model = new \app\models\form\MasterTownForm($mastertown);
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('update', [
//                    'model' => $model,
//        ]);
        if ($model->load(Yii::$app->request->post())) {
            $model->mastertown->setAttributes([
                'state_code' => $model->state_code,
                'state_name' => $model->state_name,
                'district_code' => $model->district_code,
                'district_name' => $model->district_name,
                'sub_district_code' => $model->sub_district_code,
                'sub_district_name' => $model->sub_district_name,
                'town_code' => $model->town_code,
                'town_name' => $model->town_name,
                'town_type' => $model->town_type,
            ]);

            if ($model->mastertown->save()) {
                Yii::$app->getSession()->setFlash('success', 'Data updated Successfully!');
                return $this->redirect(['index']);
            }
        }


        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MasterTown model.
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
     * Finds the MasterTown model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MasterTown the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = MasterTown::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
