<?php

namespace backend\modules\front\controllers;

use Yii;
use frontend\models\GovernmentOrder;
use frontend\models\GovernmentOrderSearch;
use frontend\models\form\GovernmentOrderForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * GoController implements the CRUD actions for GovernmentOrder model.
 */
class GoController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all GovernmentOrder models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new GovernmentOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GovernmentOrder model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($goid) {
        return $this->render('view', [
                    'model' => $this->findModel($goid),
        ]);
    }

    /**
     * Creates a new GovernmentOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new GovernmentOrderForm();
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->validate()) {
                $model->government_order_model->setAttributes([
                    'title' => $model->title,
                    'date' => $model->date,
                    'description' => $model->description,
                    'app' => $model->app,
                    'issued_by' => $model->issued_by,
                    'status' => 1,
                ]);

                if ($model->government_order_model->save()) {
                    if ($model->file != null) {
                        $filename = $model->file->baseName . '.' . $model->file->extension;
                        if (file_exists($model->base_path . '/' . $filename)) {
                            $filename = $this->file->baseName . '_' . $model->government_order_model->id . '.' . $this->file->extension;
                        }
                        $file_path = $model->base_path . '/' . $filename;

                        if ($model->file->saveAs($file_path)) {
                            $model->government_order_model->file = $filename;
                            $model->government_order_model->update();
                             chmod($file_path, 0777);
                        }
                    }
                    \Yii::$app->getSession()->setFlash('success', 'successfully saved');
                    return $this->redirect(['index']);
                } else {
                    
                }
            } else {
                
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing GovernmentOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($goid) {
        $go_model = $this->findModel($goid);

        $model = new GovernmentOrderForm($go_model);
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->validate()) {
                $model->government_order_model->setAttributes([
                    'title' => $model->title,
                    'date' => $model->date,
                    'description' => $model->description,
                    'app' => $model->app,
                    'issued_by' => $model->issued_by,
                    'status' => 1,
                ]);

                if ($model->government_order_model->save()) {
                    if ($model->file != null) {
                        $filename = $model->file->baseName . '.' . $model->file->extension;
                        if (file_exists($model->base_path . '/' . $filename)) {
                            $filename = $this->file->baseName . '_' . $model->government_order_model->id . '.' . $this->file->extension;
                        }
                        $file_path = $model->base_path . '/' . $filename;

                        if ($model->file->saveAs($file_path)) {
                            $model->government_order_model->file = $filename;
                            $model->government_order_model->update();
                            chmod($file_path, 0777);
                        }
                    }
                    \Yii::$app->getSession()->setFlash('success', 'successfully saved');
                    return $this->redirect(['index']);
                } else {
                    
                }
            } else {
                
            }
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Finds the GovernmentOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GovernmentOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = GovernmentOrder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
