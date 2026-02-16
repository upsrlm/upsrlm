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
        Yii::$app->params['baseurl_bc_image']='https://bc.upsrlm.org';
        $app_data= \common\models\ApplicationData::findOne(1);
        $model = new LoginForm();
        $this->performAjaxValidation($model);
        if (Yii::$app->request->post()) {
            if ((Yii::$app->request->post())['LoginForm']['login_type'] == "1")
                    $model->scenario = 'login_password';
            else if ((Yii::$app->request->post())['LoginForm']['login_type'] == "2" && (Yii::$app->request->post())['LoginForm']['otp_sent'] == "0")
                $model->scenario = 'login_otp_step1';
            else if ((Yii::$app->request->post())['LoginForm']['login_type'] == "2" && (Yii::$app->request->post())['LoginForm']['otp_sent'] == "1")
                $model->scenario = 'login_otp_step2';
        }
//print_r(Yii::$app->request->post()); exit;
        if ($model->load(Yii::$app->request->post())) {
             //echo $model->login_type;exit;
            if ($model->login_type == "1" && $model->validate() && $model->login()) {
//                if(Yii::$app->user->identity->master_partner_bank_id=='6'){
//                   Yii::$app->user->logout(); 
//                }
                if (in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_CBO_USER])) {
                    Yii::$app->user->logout();
                }
                return $this->redirect(['/dashboard']);
            } else if ($model->login_type == "2") {
                if ($model->otp_sent == "0") {
                    if ($model->validate())
                        if ($model->genrateOTP())
                            $model->otp_sent = 1;
                } else if ($model->otp_sent == "1") {
                    if ($model->validate() && $model->login())
                        return $this->redirect(['/dashboard']);
                }
            }
        }

        $model->password = '';
        $model->otp = '';
        //echo $model->login_type;exit;
        return $this->render('/default/index', ['model' => $model,'app_data'=>$app_data]);
    }

    public function otpsend($otp, $mobile_number) {
        $options = [];
        $smslane = new \common\components\sms\Smslanev2();
        $options['Message'] = \common\components\sms\Smslanev2::sms_content(['otp' => $otp], \common\components\sms\Smslanev2::TYPE_SMS_USER_OTP);
        $options['MobileNumbers'] = $smslane->sms_mobile_number($mobile_number);
        $smslane->options = $options;
        $smslane->enableSendSms = \Yii::$app->params['sms_lane_enable'];
        if ($smslane->enableSendSms) {
            $sms = $smslane->SendSMS(\common\components\sms\Smslanev2::SENDAR_OTP);
        }
    }

}
