<?php

namespace bcsakhi\modules\page\controllers;

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
use common\models\master\MasterRole;

/**
 * Default controller for the `page` module
 */
class HomeController extends Controller {

    use \common\traits\AjaxValidationTrait;

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $app_data = \common\models\ApplicationData::findOne(1);
        $top_20_bc= \common\models\dynamicdb\bc\bcsakhi\BcsakhiTransactionBcSummary::find()->orderBy(['commission_amount'=>SORT_DESC])->all();
        $model = new LoginForm();

        $model->password = '';
        $model->otp = '';
        //echo $model->login_type;exit;
        return $this->render('/default/index', ['model' => $model, 'app_data' => $app_data,'top_20_bc'=>$top_20_bc]);
    }
     public function actionIndexv2() {
        $app_data = \common\models\ApplicationData::findOne(1);
        $top_20_bc= \common\models\dynamicdb\bc\bcsakhi\BcsakhiTransactionBcSummary::find()->orderBy(['commission_amount'=>SORT_DESC])->all();
        $model = new LoginForm();

        $model->password = '';
        $model->otp = '';
        //echo $model->login_type;exit;
        return $this->render('/default/indexv2', ['model' => $model, 'app_data' => $app_data,'top_20_bc'=>$top_20_bc]);
    }
}
