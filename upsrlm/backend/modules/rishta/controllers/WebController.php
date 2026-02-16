<?php

namespace backend\modules\rishta\controllers;

use Yii;
use yii\web\Controller;
use common\models\dynamicdb\cbo_detail\RishtaRolePermission;
use common\models\dynamicdb\cbo_detail\RishtaRolePermissionSearch;
use cbo\models\Shg;
use cbo\models\ShgSearch;
use common\models\CboMembers;
use common\models\CboMembersSearch;
use common\models\base\GenralModel;
use cbo\models\sakhi\RishtaWebLog;
use cbo\models\sakhi\RishtaWebLogSearch;

class WebController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['log'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['log'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionLog() {
        $searchModel = new RishtaWebLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
       
        return $this->render('log', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    

}
