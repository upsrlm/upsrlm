<?php

namespace hr\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\UserSearch;
use common\models\User;
use common\models\master\MasterRole;
use common\models\base\GenralModel;

class DashboardController extends Controller {

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
        if (!in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_JMD, MasterRole::ROLE_HR_ADMIN])) {
            return $this->redirect(['/profile/view']);
        }
        $searchModel = new UserSearch();
        $searchModel->status = User::STATUS_ACTIVE;
        $dataProvider1 = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $dataProvider1->query->andWhere(['user.role' => [MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU, MasterRole::ROLE_SMMU]]);
        $dataProvider2 = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $dataProvider2->query->andWhere(['user.role' => [MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU, MasterRole::ROLE_SMMU], 'user.profile_status' => 1]);

        $dataProvider3 = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $dataProvider3->query->andWhere(['user.role' => [MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU, MasterRole::ROLE_SMMU], 'user.profile_status' => [0, 2]]);
        if ($searchModel->profile_status != '') {
            if (in_array($searchModel->profile_status, [0, 2])) {
                $dataProvider3->query->andWhere(['user.profile_status' => $searchModel->profile_status]);
            }
        }
        $dataProvider4 = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $dataProvider4->query->andWhere(['user.role' => [MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU, MasterRole::ROLE_SMMU], 'user.profile_status' => 1]);
        $dataProvider4->query->joinWith(['profile']);
        $dataProvider4->query->andWhere(['user_profile.verification_status' => 1]);
        $dataProvider5 = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $dataProvider5->query->andWhere(['user.role' => [MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU, MasterRole::ROLE_SMMU], 'user.profile_status' => 1]);
        $dataProvider5->query->joinWith(['profile']);
        $dataProvider5->query->andWhere(['user_profile.verification_status' => 2]);

        $dataProvider6 = $searchModel->search(\Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30'], GenralModel::select_user_columns());
        $dataProvider6->query->andWhere(['user.role' => [MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU, MasterRole::ROLE_SMMU], 'user.profile_status' => 1]);
        $dataProvider6->query->joinWith(['profile']);
        $dataProvider6->query->andWhere(['user_profile.verification_status' => 0]);
        $dataProvider = [];
        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";
        if ($button_type == "1") {
            $dataProvider = $dataProvider1;
        } elseif ($button_type == "2") {
            $dataProvider = $dataProvider2;
        } elseif ($button_type == "3") {
            $dataProvider = $dataProvider3;
        } elseif ($button_type == "4") {
            $dataProvider = $dataProvider4;
        } elseif ($button_type == "5") {
            $dataProvider = $dataProvider5;
        } elseif ($button_type == "6") {
            $dataProvider = $dataProvider6;
        }
        return $this->render('index', [
                    'button_type' => $button_type,
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'dataProvider1' => $dataProvider1,
                    'dataProvider2' => $dataProvider2,
                    'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4,
                    'dataProvider5' => $dataProvider5,
                    'dataProvider6' => $dataProvider6,
        ]);
    }

}
