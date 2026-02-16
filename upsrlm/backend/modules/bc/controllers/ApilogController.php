<?php
namespace backend\modules\bc\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use bc\modules\selection\models\SrlmBcSelectionApiLog as ApiLog;
use bc\modules\selection\models\SrlmBcSelectionApiLogSearch as ApiLogSearch;


/**
 * ApilogController implements the CRUD actions for ApiLog model.
 */
class ApilogController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                // everything else is denied
                ],
            ],
        ];
    }

    /**
     * Lists all ApiLog models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ApiLogSearch();
        if (isset($_GET['id'])) {
            $searchModel->app_id = $_GET['id'];
        }
        if (isset($_GET['user_id'])) {
            $searchModel->user_id = $_GET['user_id'];
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,Yii::$app->user->identity,10,['id', 'notification_type', 'notification_sub_type', 'detail_id', 'user_id', 'app_id', 'visible', 'acknowledge', 'acknowledge_status', 'send_count', 'cron_status', 'status']);
     
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRequestbody($id) {
        $searchModel = new ApiLogSearch();
        $searchModel->id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('requestbody', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('requestbody', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single ApiLog model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    
    protected function findModel($id) {
        if (($model = ApiLog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
