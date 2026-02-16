<?php

namespace backend\modules\bc\controllers;

use Yii;
use bc\models\NotificationLog;
use bc\models\NotificationLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NotificationlogController implements the CRUD actions for NotificationLog model.
 */
class NotificationlogController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'detail', 'update'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'detail', 'update'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
 public function BeforeAction($action) {
        $this->enableCsrfValidation = false;
        
        return parent::beforeAction($action);
    }
    /**
     * Lists all NotificationLog models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new NotificationLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity,5,['id','message_title', 'genrated_on', 'send_datetime', 'acknowledge_date', 'user_id', 'app_id', 'acknowledge', 'acknowledge_status', 'send_count', 'cron_status', 'status']);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single NotificationLog model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionDetail() {

        $searchModel = new \bc\models\NotificationLogFirebaseDetailSearch();
        $searchModel->notification_log_id = $_REQUEST['expandRowKey'];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);

        return $this->renderAjax('detail', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing NotificationLog model.
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
     * Finds the NotificationLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NotificationLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = NotificationLog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
