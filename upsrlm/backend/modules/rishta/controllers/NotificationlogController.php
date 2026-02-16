<?php

namespace backend\modules\rishta\controllers;

use Yii;
use common\models\rishta\RishtaNotificationLog;
use common\models\rishta\RishtaNotificationLogSearch;
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
        $searchModel = new RishtaNotificationLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);

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

        $searchModel = new \common\models\rishta\RishtaNotificationLogFirebaseDetailSearch();
        $searchModel->notification_log_id = $_REQUEST['expandRowKey'];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity);

        return $this->renderAjax('detail', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the NotificationLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NotificationLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = RishtaNotificationLog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
