<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller {

    use \common\traits\AjaxValidationTrait;

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','maintenance'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'changepassword', 'phpinfo', 'acpuinfo', 'acpuclear','maintenance'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        // Only disable CSRF for maintenance action
        if ($action->id === 'maintenance') {
            $this->enableCsrfValidation = false;
            $this->layout = 'maintenance_view';
        } else {
            $this->enableCsrfValidation = true;
        }
        return parent::beforeAction($action);
    }

    public function actionMaintenance() {

        return $this->render('maintenance');
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionChangepassword() {
        /** @var User $user */
        $user = \Yii::createObject([
                    'class' => \common\models\form\ChangePasswordForm::className(),
        ]);

        $this->performAjaxValidation($user);

        if ($user->load(\Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->getSession()->setFlash('success', 'Password Change successfuly');
            return $this->goHome();
        }

        return $this->render('changepassword', [
                    'user' => $user
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        $model->setScenario('login_password');
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionPhpinfo() {
        phpinfo();

        //return $this->goHome();
    }

    public function actionAcpuinfo() {
        echo "<pre/>";
        print_r(apcu_sma_info());
        echo "<br/>";
        echo "<br/>";
        print_r(apcu_cache_info());
        exit; //  
        //return $this->goHome();
    }

    public function actionAcpuclear() {
        apcu_clear_cache();
        $this->redirect("/site/acpuinfo");
    }
}
