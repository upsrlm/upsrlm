<?php

namespace backend\modules\bc\controllers;

use Yii;
use bc\models\transaction\BcTransactionMasterMonth;
use bc\models\transaction\BcTransactionMasterMonthSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TransactionmonthController implements the CRUD actions for BcTransactionMasterMonth model.
 */
class TransactionmonthController extends Controller {

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
     * Lists all BcTransactionMasterMonth models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BcTransactionMasterMonthSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $current_month_id = \bc\modules\selection\models\base\GenralModel::current_month_id();
        $dataProvider->query->andWhere(['<=',BcTransactionMasterMonth::getTableSchema()->fullName . '.id',$current_month_id]);
        $dataProvider->query->andWhere(['>=',BcTransactionMasterMonth::getTableSchema()->fullName . '.id',6]);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BcTransactionMasterMonth model.
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
     * Finds the BcTransactionMasterMonth model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NotificationTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = BcTransactionMasterMonth::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
