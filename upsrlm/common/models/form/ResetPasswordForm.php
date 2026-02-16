<?php

namespace common\models\form;

use yii;
use common\models\User;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\Expression;

/**
 * ChangePasswordForm gets user's password,currentpassword,re_password and changes them.
 *
 * @property User $user
 *
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class ResetPasswordForm extends Model {

    /** @var string */
    public $new_password;
    public $re_password;
    /** @var Module */
    protected $module;

    /** @var Mailer */
    protected $mailer;

    /** @var User */
    private $_user;
    public $user;

    /** @inheritdoc */
    public function __construct($user) {
        $this->user = $user;
    }

    /** @inheritdoc */
    public function rules() {
        return [
            [['new_password', 're_password'], 'required'],
            ['new_password', 'string', 'min' => 6],
            ['re_password', 'compare', 'compareAttribute' => 'new_password', 'message' => "Passwords don't match"],
            [['mail_to_member'], 'safe'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'new_password' => 'New password',
            're_password' => 'Re Password',
        ];
    }

    /** @inheritdoc */
    public function formName() {
        return 'rest-password-form';
    }

    /**
     * Saves new account settings.
     *
     * @return bool
     */
    public function save() {
        if ($this->validate()) {
            $this->user->password = $this->new_password;
            $this->user->setPassword($this->new_password);
            $this->user->setUpd($this->new_password);
            $this->user->action_type = 2;
            if ($this->user->save()) {


                return $this->user;
            }

            return false;
        }
    }

}
