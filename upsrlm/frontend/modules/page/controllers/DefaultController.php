<?php

namespace app\modules\page\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
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

/**
 * Default controller for the `page` module
 */
class DefaultController extends Controller {

    use \common\traits\AjaxValidationTrait;

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->goHome();
        $model = new LoginForm();
        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $check = new Appcheck();
            $check->current_app = Yii::$app->params['current_app'];
            $check->redirect();

            return $this->goHome();
        }
        return $this->render('/default/index', ['model' => $model]);
    }

}
