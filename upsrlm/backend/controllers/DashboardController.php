<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\UserSearch;
use common\models\User;
use common\models\master\MasterRole;

class DashboardController extends Controller {

    /** @inheritdoc */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest);
                        }
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action) {

        if (!parent::beforeAction($action)) {
            return false;
        }

        // other custom code here

        return true; // or false to not run the action
    }

    /**
     * Lists all Application models.
     *
     * @return mixed
     */
    public function actionIndex() {
        $report = [
            'cbo' =>
            [
                'shg' => '482417',
                'vo' => '20123',
                'clf' => '1265',
                'shg_member' => '1449786',
                'vo_member' => '200798',
                'clf_member' => '14738',
            ]
        ];
        $searchModel = new UserSearch();
        if (!isset(\Yii::$app->request->queryParams['UserSearch']))
            $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider1 = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], \common\models\base\GenralModel::select_user_columns());
//        $dataProvider1->query->andWhere(['user.role' => [MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU, MasterRole::ROLE_SMMU]]);
        $dataProvider2 = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], \common\models\base\GenralModel::select_user_columns());
        $dataProvider2->query->andWhere(['user.role' => [MasterRole::ROLE_CBO_USER], 'user.profile_status' => 1]);

        $dataProvider = [];
        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";
//        if ($button_type == "1") {
//            $dataProvider = $dataProvider1;
//        } elseif ($button_type == "2") {
//            $dataProvider = $dataProvider2;
//        } elseif ($button_type == "3") {
//            $dataProvider = $dataProvider3;
//        } elseif ($button_type == "4") {
//            $dataProvider = $dataProvider4;
//        } elseif ($button_type == "5") {
//            $dataProvider = $dataProvider5;
//        }
        return $this->render('index', [
                    'button_type' => $button_type,
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'dataProvider1' => $dataProvider1,
                    'dataProvider2' => $dataProvider2,
//                    'dataProvider3' => $dataProvider3,
//                    'dataProvider4' => $dataProvider4,
//                    'dataProvider5' => $dataProvider5,
        ]);
    }

}
