<?php

namespace bc\modules\report\controllers;

use Yii;
use bc\modules\selection\models\PaytmBcSakhi;
use bc\modules\selection\models\PaytmBcSakhiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PaytmbcsakhiController implements the CRUD actions for PaytmBcSakhi model.
 */
class PaytmbcsakhiController extends Controller
{
    use \common\traits\AjaxValidationTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all PaytmBcSakhi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = [];
        if (Yii::$app->request->isGet) {
            $params = Yii::$app->request->queryParams;
        }
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
        }
        $searchModel = new PaytmBcSakhiSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
