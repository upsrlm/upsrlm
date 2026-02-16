<?php

namespace cbo\controllers;

use Yii;
use common\models\master\MasterRole;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

class DashboardController extends Controller {

    /** @inheritdoc */
//    public function behaviors() {
//        return [
//            'access' => [
//                'class' => \yii\filters\AccessControl::className(),
//                'only' => ['index'],
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                    [
//                        'actions' => ['index'],
//                        'allow' => true,
//                        'matchCallback' => function ($rule, $action) {
//                            return (!Yii::$app->user->isGuest);
//                        }
//                    ],
//                ],
//            ],
//        ];
//    }

     public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        return true;
    }

 public function actionIndex()
{
    if (in_array(
        Yii::$app->user->identity->role,
        [
            MasterRole::ROLE_ADMIN,
            MasterRole::ROLE_MSC,
            MasterRole::ROLE_SUPER_ADMIN,
        ]
    )) {
        return $this->redirect(['/shg']);
        return $this->render('index', [
                    'model' => $model,
        ]);
    }
}
}