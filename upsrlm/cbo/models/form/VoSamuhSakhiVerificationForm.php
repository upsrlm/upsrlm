<?php

namespace cbo\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\master\MasterRole;
use cbo\models\Shg;
use common\models\CboMembers;
use common\models\CboMemberProfile;
use cbo\models\CboMasterMemberDesignation;
use cbo\models\sakhi\RishtaShgPermission;
use cbo\models\CboVo;

/**
 * VoSamuhSakhiVerificationForm is the model behind the CboVo and user CboMembers CboMemberProfile CboShgPermission
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class VoSamuhSakhiVerificationForm extends \yii\base\Model {

    public $id;
    public $name;
    public $mobile_no;
    public $cbo_vo_id;
    public $verification_status_samuh_sakhi;
    public $verify_samuh_sakhi_detail_by;
    public $verify_samuh_sakhi_detail_date;
    public $status;
    public $yes_no_option;
    public $vo_model;
    public $vo_shg_model;
    public $user_model;
    public $cbo_member_model;
    public $cbo_member_profile_model;
    public $cbo_shg_member_permition_model;
    public $cbo_type;
    public $entry_type;
    public $role;

    public function __construct($vo_model) {
        $this->vo_model = $vo_model;
        $this->cbo_vo_id = $this->vo_model->id;
        $this->vo_shg_model = Shg::find()->where(['cbo_vo_id' => $this->vo_model->id])->all();
//        print_r($this->vo_shg_model);exit;
        $this->yes_no_option = ['1' => 'Yes', '2' => 'No'];
        $this->user_model = User::findOne(['username' => $this->vo_model->samuh_sakhi_mobile_no]);
        $this->name = $this->vo_model->samuh_sakhi_name;
        $this->mobile_no = $this->vo_model->samuh_sakhi_mobile_no;

        if ($this->user_model != null) {
            $this->cbo_member_profile_model = CboMemberProfile::findOne(['user_id' => $this->user_model->id]);
        }
    }

    public function rules() {
        return [
            [['name'], 'required'],
            [['cbo_vo_id'], 'required'],
            [['mobile_no'], 'required'],
            [['verification_status_samuh_sakhi'], 'required'],
            [['verification_status_samuh_sakhi'], 'compare', 'compareValue' => true, 'message' => 'Please tick Samuh Sakhi के नाम व फ़ोन नम्बर सत्यापित करें'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'verification_status_samuh_sakhi' => 'Samuh Sakhi के नाम व फ़ोन नम्बर सत्यापित करें',
        ];
    }

    public function SaveUser() {
        if (isset($this->user_model) and $this->user_model != null) {
            
        } else {
            $this->user_model = new User();
            $this->user_model->name = $this->name;
            $this->user_model->mobile_no = $this->mobile_no;
            $this->user_model->username = $this->mobile_no;
            $this->user_model->role = MasterRole::ROLE_CBO_USER;
            $this->user_model->email = $this->mobile_no . '@gmail.com';
            $this->user_model->password = $this->mobile_no;
            $this->user_model->setPassword($this->mobile_no);
            $this->user_model->setUpd($this->mobile_no);
            $this->user_model->status = User::STATUS_ACTIVE;
            $this->user_model->profile_status = 1;
            $this->user_model->login_by_otp = 2;
            $this->user_model->otp_value = \common\helpers\Utility::generateNumericOTP(4);
            $this->user_model->dummy_column = $this->vo_model->dummy_column;
        }
        if ($this->user_model->isNewRecord) {
            $this->user_model->action_type = 1;
        } else {
            $this->user_model->action_type = 2;
        }
        if ($this->user_model->save()) {
            $this->vo_model->samuh_sakhi_user_id = $this->user_model->id;
            $this->vo_model->update();
            $p_bank = \common\models\master\MasterPartnerBankDistrict::findOne(['district_code' => $this->vo_model->district_code]);
            if ($this->cbo_member_profile_model != null) {
                $this->cbo_member_profile_model->shg = 1;
                $this->cbo_member_profile_model->samuh_sakhi = 1;
            } else {
                $this->cbo_member_profile_model = new CboMemberProfile();
                $this->cbo_member_profile_model->user_id = $this->user_model->id;
                $this->cbo_member_profile_model->first_name = $this->name;
                $this->cbo_member_profile_model->primary_phone_no = $this->mobile_no;
                $this->cbo_member_profile_model->shg = 1;
                $this->cbo_member_profile_model->samuh_sakhi = 1;
                $this->cbo_member_profile_model->division_code = $this->vo_model->division_code;
                $this->cbo_member_profile_model->division_name = $this->vo_model->division_name;
                $this->cbo_member_profile_model->district_code = $this->vo_model->district_code;
                $this->cbo_member_profile_model->district_name = $this->vo_model->district_name;
                $this->cbo_member_profile_model->block_code = $this->vo_model->block_code;
                $this->cbo_member_profile_model->block_name = $this->vo_model->block_name;
                $this->cbo_member_profile_model->gram_panchayat_code = $this->vo_model->gram_panchayat_code;
                $this->cbo_member_profile_model->gram_panchayat_name = $this->vo_model->gram_panchayat_name;
                $this->cbo_member_profile_model->master_partner_bank_id = isset($p_bank) ? $p_bank->master_partner_bank_id : '0';
            }
            $this->cbo_member_profile_model->save();
            if ($this->vo_shg_model != null) {
                foreach ($this->vo_shg_model as $shg) {
                    $this->cbo_member_model = CboMembers::findOne(['cbo_type' => CboMembers::CBO_TYPE_SHG, 'cbo_id' => $shg->id, 'user_id' => $this->user_model->id]);
                    if ($this->cbo_member_model == null) {
                        $this->cbo_member_model = new CboMembers();
                        $this->cbo_member_model->user_id = $this->user_model->id;
                        $this->cbo_member_model->cbo_type = CboMembers::CBO_TYPE_SHG;
                        $this->cbo_member_model->cbo_id = $shg->id;
                        $this->cbo_member_model->entry_type = 1;
                        $this->cbo_member_model->samuh_sakhi = 1;
                    } else {
                        $this->cbo_member_model->samuh_sakhi = 1;
                    }

                    $this->cbo_member_model->status = CboMembers::CBO_MEMBER_STATUS_CONFIRM;
                    $shg->ss_user_id = $this->user_model->id;
                    $shg->save();
                    if ($this->cbo_member_model->save()) {
                        
                    }
                }
            }

            return $this;
        } else {
            return true;
        }
    }

}
