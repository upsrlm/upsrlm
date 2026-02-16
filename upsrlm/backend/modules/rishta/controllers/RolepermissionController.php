<?php

namespace backend\modules\rishta\controllers;

use Yii;
use yii\web\Controller;
use common\models\dynamicdb\cbo_detail\RishtaRolePermission;
use common\models\dynamicdb\cbo_detail\RishtaRolePermissionSearch;

/**
 * RolepermissionController for the `rishta` module
 */
class RolepermissionController extends Controller {

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

    public function actionIndex() {
        $searchModel = new RishtaRolePermissionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
