<?php

namespace app\modules\page\controllers;

use yii\web\Controller;
use common\models\User;
use app\models\form\RecoveryForm;
use yii\authclient\AuthAction;
use yii\authclient\ClientInterface;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Response;

/**
 * Default controller for the `page` module
 */
class ForgotpasswordController extends Controller {

    use \common\traits\AjaxValidationTrait;
//    use EventTrait;

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['/dashboard']);
        }
        $model = new RecoveryForm();
        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->sendRecoveryMessage()) {

            return $this->refresh();
        }
        return $this->render('/default/forgotpassword', ['model' => $model]);
    }

}
