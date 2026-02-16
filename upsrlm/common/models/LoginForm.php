<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\UpsrlmSmsLog;
use common\models\UpsrlmSmsTemplate;

/**
 * Login form
 */
class LoginForm extends Model {

    public $username;
    public $password;
    public $rememberMe = true;
    public $login_type = 1;
    public $username_otp;
    public $otp;
    public $otp_sent = 0;
//    public $login_type_option = ['1' => 'Login By Password', '2' => 'Login By OTP'];
     public $login_type_option = ['1' => 'Login By Password'];
    private $_user;

    const LOGIN_ONLY_USERNAME_AND_PASSWORD = 1;
    const LOGIN_ONLY_OTP = 2;
    const LOGIN_BOTH = 3;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            // username and password are both required
            [['username', 'password'], 'required', 'on' => 'login_password'],
            [['username_otp', 'otp'], 'required', 'on' => 'login_otp_step2'],
            [['username_otp'], 'required', 'on' => 'login_otp_step1'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword', 'on' => 'login_password'],
            ['username_otp', 'validateUsername', 'on' => 'login_otp_step1'],
            ['otp', 'validateOTP', 'on' => 'login_otp_step2'],
            [['login_type', 'otp_sent'], 'safe']
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if ($user != null) {
                if ($user->login_by_otp == self::LOGIN_ONLY_OTP) {
                    $this->addError($attribute, 'Login By OTP Only');
                }
            }
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    public function validateUsername($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = User::findByUsername($this->username_otp);
            if (!$user) {
                $this->addError($attribute, 'Incorrect mobile no');
            } else {
                $this->_user = $user;
                if ($this->_user->login_by_otp == self::LOGIN_ONLY_USERNAME_AND_PASSWORD) {
                    $this->addError($attribute, 'Only allow Login By Password');
                }
            }
        }
    }

    public function validateOTP($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = User::findOne(['username' => $this->username_otp, 'otp_value' => $this->otp]);
            if (!$user) {
                $this->addError($attribute, 'Incorrect OTP');
            } else {
                $this->_user = $user;
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login() {
        if ($this->validate()) {
            $user = $this->getUser();
            if ($user === null) {
                $this->addError('username', 'Incorrect username or password.');
                return false;
            }

            return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function genrateOTP() {
        $this->getUser()->otp_value = \common\helpers\Utility::generateNumericOTP(6);
        $this->getUser()->otp_sendtime = time();    
        $this->getUser()->update();
        $this->otpsend($this->getUser()->otp_value, $this->username_otp);
        return true;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser() {
        if ($this->_user === null) {
            $username = trim((string) $this->username);
            if ($username === '') {
                return null;
            }

            $this->_user = User::findByUsername($username);
        }

        return $this->_user;
    }

    public function otpsend($otp, $mobile_number) {
        $options = [];
        $smslane = new \common\components\sms\Smslanev2();
        $options['Message'] = \common\components\sms\Smslanev2::sms_content(['otp' => $otp], \common\components\sms\Smslanev2::TYPE_SMS_USER_OTP);
        $options['MobileNumbers'] = $smslane->sms_mobile_number($mobile_number);
        $smslane->options = $options;
        $smslane->enableSendSms = \Yii::$app->params['sms_lane_enable'];
        $sms_log = new UpsrlmSmsLog();
        $sms_log->user_id = 0;
        $sms_log->mobile_number = $mobile_number;
        $sms_log->upsrlm_sms_template_id = UpsrlmSmsTemplate::USER_OTP_TEMPALTE_ID;
        $sms_log->model = json_encode(['otp' => $otp, 'mobile_number' => $mobile_number]);
        $sms_log->sms_content = $options['Message'];
        $sms_log->sms_length = strlen($sms_log->sms_content);
        ;

        if ($smslane->enableSendSms and $sms_log->save()) {
            $sms = $smslane->SendSMS(\common\components\sms\Smslanev2::SENDAR_OTP);
            if (empty($sms)) {
                $sms_log->status = -1;
                $sms_log->service_provider_id = $sms;
            } else {
                if ($sms['ErrorCode']) {
                    $sms_log->status = -1;
                    if (isset($sms['Data'][0]['MessageId'])) {
                        $sms_log->service_provider_id = $sms['Data'][0]['MessageId'];
                    } else {
                        if (isset($sms['ErrorDescription'])) {
                            $sms_log->service_provider_id = $sms['ErrorDescription'];
                        }
                    }
                } else {
                    $sms_log->status = 1;
                    if (isset($sms['Data'][0]['MessageId'])) {
                        $sms_log->service_provider_id = $sms['Data'][0]['MessageId'];
                    }
                }
                $sms_log->try_send_count=($sms_log->try_send_count+1);
                $sms_log->sms_send_time = new \yii\db\Expression('NOW()');
                $sms_log->save();
            }
        }
    }

}
