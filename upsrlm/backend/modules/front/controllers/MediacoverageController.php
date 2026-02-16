<?php

namespace backend\modules\front\controllers;

use Yii;
use frontend\models\MediaCoverage;
use frontend\models\MediaCoverageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\form\MediaCoverageForm;
use yii\web\UploadedFile;

/**
 * MediacoverageController implements the CRUD actions for MediaCoverage model.
 */
class MediacoverageController extends Controller {

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
     * Lists all MediaCoverage models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MediaCoverageSearch();
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
    public function actionView($mediacoverageid) {
        return $this->render('view', [
                    'model' => $this->findModel($mediacoverageid),
        ]);
    }

    /**
     * Creates a new MediaCoverage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new MediaCoverageForm();
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->validate()) {
                $model->media_coverage_model->setAttributes([
                    'title' => $model->title,
                    'date' => $model->date,
                    'description' => $model->description,
                    'type' => $model->type,
                    'url' => $model->url,
                    'media_by' => $model->media_by,
                    'status' => 1,
                ]);

                if ($model->media_coverage_model->save()) {
                    if ($model->file != null) {
                        $filename = $model->file->baseName . '.' . $model->file->extension;
                        if (file_exists($model->base_path . '/' . $filename)) {
                            $filename = $this->file->baseName . '_' . $model->media_coverage_model->id . '.' . $this->file->extension;
                        }
                        $file_path = $model->base_path . '/' . $filename;

                        if ($model->file->saveAs($file_path)) {
                            $model->media_coverage_model->file = $filename;
                            $model->media_coverage_model->update();
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
     * Updates an existing MediaCoverage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($mediacoverageid) {
        $media_model = $this->findModel($mediacoverageid);
        $model = new MediaCoverageForm($media_model);
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->validate()) {
                $model->media_coverage_model->setAttributes([
                    'title' => $model->title,
                    'date' => $model->date,
                    'description' => $model->description,
                    'type' => $model->type,
                    'url' => $model->url,
                    'media_by' => $model->media_by,
                    'status' => 1,
                ]);

                if ($model->media_coverage_model->save()) {
                    if ($model->file != null) {
                        $filename = $model->file->baseName . '.' . $model->file->extension;
                        if (file_exists($model->base_path . '/' . $filename)) {
                            $filename = $this->file->baseName . '_' . $model->media_coverage_model->id . '.' . $this->file->extension;
                        }
                        $file_path = $model->base_path . '/' . $filename;

                        if ($model->file->saveAs($file_path)) {
                            $model->media_coverage_model->file = $filename;
                            $model->media_coverage_model->update();
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
     * Finds the MediaCoverage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = MediaCoverage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
