<?php

namespace app\modules\master\controllers;

use Yii;
use common\models\master\SafaiKarmi;
use common\models\master\SafaiKarmiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SafaikarmirController implements the CRUD actions for SafaiKarmi model.
 */
class SafaikarmiController extends Controller {

    public $message = '';

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
     * Lists all SafaiKarmi models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SafaiKarmiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['is', 'gram_panchayat_code', new \yii\db\Expression('null')]);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SafaiKarmi model.
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
     * Creates a new SafaiKarmi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new SafaiKarmi();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing SafaiKarmi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    public function actionUpdategpcode($id) {
        $model = $this->findModel($id);
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if (isset($_POST['hasEditable'])) {
                $this->message = 'gp code update successfully';
                $model->gram_panchayat_code = $_POST['gram_panchayat_code'];
                if ($model->save()) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ['output' => $model->gram_panchayat_code, 'message' => ''];
                } else {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return \yii\bootstrap4\ActiveForm::validate($model);
                }
            } else {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return \yii\bootstrap4\ActiveForm::validate($model);
            }
        }
    }

    /**
     * Finds the SafaiKarmi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SafaiKarmi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = SafaiKarmi::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
