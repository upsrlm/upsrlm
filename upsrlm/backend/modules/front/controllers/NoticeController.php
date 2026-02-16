<?php

namespace backend\modules\front\controllers;

use Yii;
use frontend\models\Notice;
use frontend\models\NoticeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\form\NoticeForm;
use yii\web\UploadedFile;

/**
 * NoticeController implements the CRUD actions for Notice model.
 */
class NoticeController extends Controller {

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
     * Lists all Notice models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new NoticeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Notice model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($noticeid) {
        return $this->render('view', [
                    'model' => $this->findModel($noticeid),
        ]);
    }

    /**
     * Creates a new Notice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new NoticeForm();
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->validate()) {
                $model->notice_model->setAttributes([
                    'title' => $model->title,
                    'date' => $model->date,
                    'description' => $model->description,
                    'app' => $model->app,
                    'issued_by' => $model->issued_by,
                    'status' => 1,
                ]);

                if ($model->notice_model->save()) {
                    if ($model->file != null) {
                        $filename = $model->file->baseName . '.' . $model->file->extension;
                        if (file_exists($model->base_path . '/' . $filename)) {
                            $filename = $this->file->baseName . '_' . $model->notice_model->id . '.' . $this->file->extension;
                        }
                        $file_path = $model->base_path . '/' . $filename;
                        if ($model->file->saveAs($file_path)) {
                            $model->notice_model->file = $filename;
                            $model->notice_model->update();
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
     * Updates an existing Notice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($noticeid) {
        $notic_model = $this->findModel($noticeid);
        $model = new NoticeForm($notic_model);
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->validate()) {
                $model->notice_model->setAttributes([
                    'title' => $model->title,
                    'date' => $model->date,
                    'description' => $model->description,
                    'app' => $model->app,
                    'issued_by' => $model->issued_by,
                    'status' => 1,
                ]);

                if ($model->notice_model->save()) {
                    if ($model->file != null) {
                        $cnt = 1;
                        $filename = $model->file->baseName . '.' . $model->file->extension;
                        if (file_exists($model->base_path . '/' . $filename)) {
                            $filename = $this->file->baseName . '_' . $model->notice_model->id . '.' . $this->file->extension;
                        }
                        $file_path = $model->base_path . '/' . $filename;
                        if ($model->file->saveAs($file_path)) {
                            $model->notice_model->file = $filename;
                            $model->notice_model->update();
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
     * Finds the Notice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Notice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
