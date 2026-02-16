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

/**
 * Default controller for the `page` module
 */
class GoController extends Controller {

    use \common\traits\AjaxValidationTrait;

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $model = new LoginForm();
        return $this->render('index', ['model' => $model]);
    }
}
