<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\components\Appcheck;
use common\models\master\MasterRole;

/**
 * MobileController for the `page` module
 */
class MobileController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $enableCsrfValidation = false;

    /**
     * Renders the index view for the module
     * @return string
     */
//    public function actionLogin() {
//        if (!Yii::$app->user->isGuest) {
//            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/dashboard')->send();
//            exit;
//        }
//        $this->layout = "@common/themes/fiori/views/layouts/mobilelogin";
//        $model = new LoginForm();
//        $model->login_type = 1;
//        $model->scenario = 'login_password';
//        $this->performAjaxValidation($model);
//        if ($model->load(Yii::$app->request->post())) {
//
//            if ($model->login_type == "1" && $model->validate() && $model->login()) {
//                if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_CBO_USER])) {
//                    return $this->redirect(['/dashboard']);
//                }else{
//                   Yii::$app->user->logout(); 
//                }
//            } else if ($model->login_type == "2") {
//                if ($model->otp_sent == "0") {
//                    if ($model->validate())
//                        if ($model->genrateOTP())
//                            $model->otp_sent = 1;
//                } else if ($model->otp_sent == "1") {
//                    if ($model->validate() && $model->login())
//                        return $this->redirect(['/dashboard']);
//                }
//            }
//        }
//        return $this->render('login', ['model' => $model]);
//    }

}
