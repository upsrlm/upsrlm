<?php

namespace common\models\form;

use yii;
use common\models\User;
use yii\base\Model;
use yii\base\NotSupportedException;

/**
 * ChangePasswordForm gets user's password,currentpassword,re_password and changes them.
 *
 * @property User $user
 *
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class ChangePasswordForm extends Model {

    /** @var string */
    public $new_password;
    public $re_password;

    /** @var string */
    public $current_password;

    /** @var Module */
    protected $module;

    /** @var Mailer */
    protected $mailer;

    /** @var User */
    private $_user;

    /** @return User */
    public function getUser() {
        if ($this->_user == null) {
            $this->_user = \Yii::$app->user->identity;
        }

        return $this->_user;
    }

    /** @inheritdoc */
    public function rules() {
        return [
            [['new_password', 're_password'], 'required'],
            [['current_password'], 'safe'],
            ['new_password', 'string', 'min' => 6],
            ['re_password', 'compare', 'compareAttribute' => 'new_password', 'message' => "Passwords don't match"],
            ['current_password', function ($attr) {
                    if (!$this->user->validatePassword($this->$attr)) {
                        $this->addError($attr, 'Current password is not valid');
                    }
                }]
        ];
    }

    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'new_password' => 'New password',
            're_password' => 'Re Password',
            'current_password' => 'Current password'
        ];
    }

    /** @inheritdoc */
    public function formName() {
        return 'change-password-form';
    }

    /**
     * Saves new account settings.
     *
     * @return bool
     */
    public function save() {
        if (!$this->validate()) {
            return FALSE;
        }
        if ($this->validate()) {
            $this->user->password = $this->new_password;
            $this->user->setPassword($this->new_password);
            $this->user->setUpd($this->new_password);
            $this->user->action_type = 2;
            $this->user->update(FALSE);
            return TRUE;
        }

        return false;
    }

}
