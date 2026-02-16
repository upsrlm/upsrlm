<?php

namespace frontend\controllers;

use Yii;
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
use common\components\Appcheck;

class DashboardController extends Controller {

    /** @inheritdoc */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'checksession'],
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
                    [
                        'actions' => ['checksession'],
                        'allow' => true,
                        'roles' => ['@', '#'],
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
        $model = [];
        $check = new Appcheck();
        $check->current_app = Yii::$app->params['current_app'];
        $check->redirect();
        return $this->render('index', [
                    'model' => $model,
        ]);
    }

    public function actionChecksession() {
        $model = [];
        if (!Yii::$app->user->isGuest) {
            if (isset(Yii::$app->request->referrer)) {
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                return $this->redirect(['/dashboard']);
            }
        } else {
            return $this->goHome();
        }
        return $this->render('index', [
                    'model' => $model,
        ]);
    }

}
