<?php

namespace common\entites;

use Yii;
use common\models\User;
use common\models\CboMembers;
use common\models\dynamicdb\cbo_detail\RishtaShgMember;
use common\models\CboMemberProfile;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcSelectionUser;
use cbo\models\Shg;
use cbo\models\CboVo;
use cbo\models\CboVoMembers;
use cbo\models\CboClf;
use cbo\models\CboClfMembers;
use common\models\master\MasterRole;

/**
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class UserEntity
{
    public $mobile;
    public $name;
    public $user_role = 100;
    public $cbo_designation;
    public $bc_id;
    public $cbo_type;
    public $cbo_shg_id;
    public $cbo_clf_id;
    public $cbo_vo_id;
    public $bc_sakhi;
    public $samuh_sakhi;
    public $accountant;
    public $suggest_wada_sakhi;
    public $user;
    public $member_profile_model;
    public $cbo_member_model;
    public $dummy_column = 0;

    public function __construct($mobile)
    {
        $this->mobile = $mobile;
        $this->user = User::findOne(['username' => $mobile]);
    }

    public function Adduser()
    {
        if ($this->user == null) {
            $srlm_bc_user = SrlmBcSelectionUser::find()
                ->where(['mobile_no' => $this->mobile])
                ->one();

            $this->user = new User();
            $this->user->name = trim($this->name);
            $this->user->mobile_no = $this->mobile;
            $this->user->username = $this->mobile;
            $this->user->role = MasterRole::ROLE_CBO_USER;
            $this->user->email = $this->mobile . '@gmail.com';
            $this->user->password = $this->mobile;
            $this->user->setPassword($this->mobile);
            $this->user->setUpd($this->mobile);
            $this->user->status = User::STATUS_ACTIVE;

            if (isset($srlm_bc_user) && $srlm_bc_user->pin) {
                $this->user->otp_value = $srlm_bc_user->pin;
            } else {
                $this->user->otp_value = \common\helpers\Utility::generateNumericOTP(4);
            }

            $this->user->profile_status = 1;
            $this->user->login_by_otp = 2;
            $this->user->dummy_column = $this->dummy_column;

            if ($this->user->save()) {
                return $this->user;
            } else {
                return false;
            }
        } else {
            if ($this->user->role != MasterRole::ROLE_CBO_USER) {
                throw new \yii\web\BadRequestHttpException(
                    "Bad Request, this mobile number " . $this->user->username . " exists with a different role"
                );
            }

            return $this->user;
        }
    }

    public function Assigncbo()
    {
        // TODO: implement CBO assignment
    }

    public function Unassigncbo()
    {
        // TODO: implement CBO unassignment
    }

    public function Memberprofile()
    {
        // TODO: implement member profile logic
    }

    public function mobiledirectory()
    {
        // TODO: implement mobile directory logic
    }

    public function blocked()
    {
        // TODO: implement block logic
    }
}

?>
