<?php

namespace backend\modules\bc\controllers;

use Yii;
use bc\models\transaction\BcTransactionMasterWeek;
use bc\models\transaction\BcTransactionMasterWeekSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TransactionWeekController implements the CRUD actions for BcTransactionMasterWeek model.
 */
class TransactionweekController extends Controller {

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
     * Lists all NotificationTemplate models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BcTransactionMasterWeekSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $current_week_id = \bc\modules\selection\models\base\GenralModel::current_week_id();
        $dataProvider->query->andWhere(['<=',BcTransactionMasterWeek::getTableSchema()->fullName . '.id',$current_week_id]);
        $dataProvider->query->andWhere(['>=',BcTransactionMasterWeek::getTableSchema()->fullName . '.id',23]);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BcTransactionMasterWeek model.
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
     * Finds the BcTransactionMasterWeek model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NotificationTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = BcTransactionMasterWeek::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
