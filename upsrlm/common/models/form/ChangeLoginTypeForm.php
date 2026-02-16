<?php

namespace common\models\form;

use yii;
use common\models\User;
use yii\base\Model;
use yii\base\NotSupportedException;
use common\models\master\MasterRole;

//use common\models\RelationUserBdoBlock;
//use common\models\dynamicdb\bc\RelationUserBdoBlock;
//use common\models\RelationUserDistrict;
//use common\models\dynamicdb\bc\RelationUserDistrict;
//use common\models\RelationUserDivision;
//use common\models\dynamicdb\bc\RelationUserDivision;

/**
 * ChangeRoleForm gets user's password,currentpassword,re_password and changes them.
 *
 * @property User $user
 *
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class ChangeLoginTypeForm extends Model {

    public $login_by_otp;
    public $old_role;

    /** @var Module */
    protected $module;

    /** @var Mailer */
    protected $mailer;

    /** @var User */
    private $_user;
    public $user;
    public $login_by_otp_option;

    /** @inheritdoc */
    public function __construct($user) {
        $this->user = $user;
        $this->login_by_otp = $this->user->login_by_otp;
        $this->login_by_otp_option = [
            1 => 'Login By Password',
            2 => 'Login By OTP',
            3 => 'Login By Both (Password or OTP)',
        ];
    }

    /** @inheritdoc */
    public function rules() {
        return [
            [['login_by_otp'], 'required'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'login_by_otp' => 'Login By',
        ];
    }

    /** @inheritdoc */
    public function formName() {
        return 'reset-role-form';
    }

    /**
     * Saves new account settings.
     *
     * @return bool
     */
    public function save() {
        if ($this->validate()) {
            $this->user->login_by_otp = $this->login_by_otp;
            $this->user->action_type = 2;
            if ($this->user->save()) {

                return $this->user;
            }

            return false;
        }
    }

}
