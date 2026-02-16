<?php

namespace backend\modules\bc\controllers;

use Yii;
use bc\modules\selection\models\SrlmBcSelectionAppDetail;
use bc\modules\selection\models\SrlmBcSelectionAppDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AppinstallController implements the CRUD actions for SrlmBcSelectionAppDetail model.
 */
class AppinstallController extends Controller {

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
     * Lists all SrlmBcSelectionAppDetail models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SrlmBcSelectionAppDetailSearch();
        $searchModel->status = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SrlmBcSelectionAppDetail model.
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
        if (($model = SrlmBcSelectionAppDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
