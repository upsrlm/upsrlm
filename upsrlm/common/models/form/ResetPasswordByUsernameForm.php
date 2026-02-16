<?php

namespace common\models\form;

use yii;
use common\models\User;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\Expression;
use common\models\master\MasterRole;

/**
 * ChangePasswordForm gets user's password,currentpassword,re_password and changes them.
 *
 * @property User $user
 *
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class ResetPasswordByUsernameForm extends Model {

    /** @var string */
    public $username;
    public $name;
    public $role;
    public $new_password;
    public $re_password;
    public $success;

    /** @var Module */
    protected $module;

    /** @var Mailer */
    protected $mailer;

    /** @var User */
    private $_user;
    public $user;
    public $alow_role = [
        MasterRole::ROLE_MSC,
        MasterRole::ROLE_HR_ADMIN,
        MasterRole::ROLE_MD,
        MasterRole::ROLE_JMD,
        MasterRole::ROLE_SPM_FI_MF,
        MasterRole::ROLE_BACKEND_OPERATOR,
        MasterRole::ROLE_SMMU,
        MasterRole::ROLE_DMMU,
        MasterRole::ROLE_BMMU,
        MasterRole::ROLE_CDO,
        MasterRole::ROLE_DC_NRLM,
        MasterRole::ROLE_SUPPORT_UNIT,
        MasterRole::ROLE_CUSTOM,
        MasterRole::ROLE_YOUNG_PROFESSIONAL,
        MasterRole::ROLE_VIEWER,
        MasterRole::ROLE_SPM_FINANCE,
        MasterRole::ROLE_BC_VIEWER,
        MasterRole::ROLE_RSETIS_STATE_UNIT,
        MasterRole::ROLE_RSETIS_DISTRICT_UNIT,
        MasterRole::ROLE_RSETIS_NODAL_BANK,
        MasterRole::ROLE_UPSRLM_RSETI_ANCHOR,
        MasterRole::ROLE_RSETIS_BATCH_CREATOR,
        MasterRole::ROLE_RBI,
        MasterRole::ROLE_BANK_DISTRICT_UNIT,
        MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,
        MasterRole::ROLE_CORPORATE_BCS,
        MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN,
        MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE,
        MasterRole::ROLE_DBT_CALL_CENTER_MANAGER,
        MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE
    ];

    /** @inheritdoc */
    public function rules() {
        return [
            ['new_password', 'safe'],
            ['new_password', 'trim'],
            ['success', 'safe'],
            ['username', 'required'],
            ['username', 'exist',
                'targetClass' => User::class,
                'targetAttribute' => 'username',
                'message' => 'This Mobile No does not exist.'
            ],
            [['username'], \common\validators\UsernameValidator::className()],
            ['new_password', 'required', 'when' => function ($model) {
                    return $model->success == 1;
                }, 'message' => 'New password is required', 'whenClient' => "function (attribute, value) {
                  return $('#success').val() == '1';
            }"],
            ['re_password', 'required', 'when' => function ($model) {
                    return $model->success == 1;
                }, 'message' => 'Re Password is required', 'whenClient' => "function (attribute, value) {
                  return $('#success').val() == '1';
            }"],            
            ['new_password', 'string', 'min' => 6],
            ['new_password', 'string', 'max' => 20],
            ['re_password', 'compare', 'compareAttribute' => 'new_password', 'message' => "Passwords don't match"],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'username' => 'Mobile No',
            'new_password' => 'New password',
            're_password' => 'Re Password',
            'name' => 'Name',
            'role' => 'Role',
        ];
    }

    /** @inheritdoc */
    public function formName() {
        return 'rest-password-form-by-username';
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
