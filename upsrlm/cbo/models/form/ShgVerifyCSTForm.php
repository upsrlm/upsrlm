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
use common\models\dynamicdb\cbo_detail\RishtaShgMemberAppPin;

/**
 * ShgVerifyCSTForm is the model behind the Shg and user CboMembers CboMemberProfile CboShgPermission
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class ShgVerifyCSTForm extends \yii\base\Model {

    public $id;
    public $cbo_shg_id;
    public $name;
    public $mobile_no;
    public $verify_chaire_person;
    public $shg_member_id;
    public $designation;
    public $verify_secretary;
    public $verify_treasurer;
    public $verify_over_all;
    public $verify_ques1;
    public $verify_ques2;
    public $verify_ques3;
    public $verify_s_ques1;
    public $verify_s_ques2;
    public $verify_s_ques3;
    public $verify_t_ques1;
    public $verify_t_ques2;
    public $verify_t_ques3;
    public $verify_shg_member_by;
    public $verify_shg_member_datetime;
    public $status;
    public $yes_no_option;
    public $shg_model;
    public $user_model;
    public $cbo_member_model;
    public $cbo_member_profile_model;
    public $cbo_shg_member_permition_model;
    public $cbo_type;
    public $entry_type;
    public $role;

    public function __construct($shg_model, $designation) {
        $this->shg_model = $shg_model;
        $this->cbo_shg_id = $this->shg_model->id;
        $this->designation = $designation;
        $this->yes_no_option = ['1' => 'Yes', '2' => 'No'];
        if ($this->designation == CboMasterMemberDesignation::SHG_CHAIRPERSON) {
            $this->user_model = User::findOne(['username' => $this->shg_model->chaire_person_mobile_no]);
            $this->name = $this->shg_model->chaire_person_name;
            $this->mobile_no = $this->shg_model->chaire_person_mobile_no;
        }
        if ($this->designation == CboMasterMemberDesignation::SHG_SECRETARY) {
            $this->user_model = User::findOne(['username' => $this->shg_model->secretary_mobile_no]);
            $this->name = $this->shg_model->secretary_name;
            $this->mobile_no = $this->shg_model->secretary_mobile_no;
        }
        if ($this->designation == CboMasterMemberDesignation::SHG_TREASURER) {
            $this->user_model = User::findOne(['username' => $this->shg_model->treasurer_mobile_no]);
            $this->name = $this->shg_model->treasurer_name;
            $this->mobile_no = $this->shg_model->treasurer_mobile_no;
        }
        if ($this->user_model != null) {
            $this->cbo_member_profile_model = CboMemberProfile::findOne(['user_id' => $this->user_model->id]);
            $this->cbo_member_model = CboMembers::findOne(['cbo_type' => CboMembers::CBO_TYPE_SHG, 'entry_type' => CboMembers::CBO_TYPE_SHG, 'cbo_id' => $this->shg_model->id, 'user_id' => $this->user_model->id]);
        }
    }

    public function rules() {
        return [
            [['designation'], 'required'],
            [['name'], 'required'],
            [['cbo_shg_id'], 'required'],
            [['mobile_no'], 'required'],
            [['verify_chaire_person'], 'required', 'on' => ['chairperson']],
            [['verify_secretary'], 'required', 'on' => ['secretary']],
            [['verify_treasurer'], 'required', 'on' => ['treasurer']],
            ['verify_ques1', 'required', 'on' => ['chairperson']],
            ['verify_ques2', 'required', 'on' => ['chairperson'], 'when' => function ($model) {
                    return $model->verify_ques1 == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#verify_ques1').val() == '1';
            }"],
            ['verify_ques3', 'required', 'on' => ['chairperson'], 'when' => function ($model) {
                    return $model->verify_ques2 == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#verify_ques2').val() == '1';
            }"],
            ['verify_s_ques1', 'required', 'on' => ['secretary']],
            ['verify_s_ques2', 'required', 'on' => ['secretary'], 'when' => function ($model) {
                    return $model->verify_s_ques1 == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#verify_s_ques1').val() == '1';
            }"],
            ['verify_s_ques3', 'required', 'on' => ['secretary'], 'when' => function ($model) {
                    return $model->verify_s_ques2 == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#verify_s_ques2').val() == '1';
            }"],
            ['verify_t_ques1', 'required', 'on' => ['treasurer']],
            ['verify_t_ques2', 'required', 'on' => ['treasurer'], 'when' => function ($model) {
                    return $model->verify_t_ques1 == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#verify_t_ques1').val() == '1';
            }"],
            ['verify_t_ques3', 'required', 'on' => ['treasurer'], 'when' => function ($model) {
                    return $model->verify_t_ques2 == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#verify_t_ques2').val() == '1';
            }"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'verify_chaire_person' => 'Verify Chaire Person',
            'verify_ques1' => 'समूह का नाम, पदाधिकारीयों के नाम व फ़ोन नम्बर सत्यापित करें',
            'verify_ques2' => 'क्या आपके पास स्मार्ट्फ़ोन है?',
            'verify_ques3' => 'अगर हाँ तो, क्या आप समूह सम्बन्धी मोबाइल ऐप अपने फ़ोन पर चलने के लिए सहमत हैं?',
            'verify_secretary' => 'Verify Secretary',
            'verify_s_ques1' => 'समूह का नाम, पदाधिकारीयों के नाम व फ़ोन नम्बर सत्यापित करें',
            'verify_s_ques2' => 'क्या आपके पास स्मार्ट्फ़ोन है?',
            'verify_s_ques3' => 'अगर हाँ तो, क्या आप समूह सम्बन्धी मोबाइल ऐप अपने फ़ोन पर चलने के लिए सहमत हैं?',
            'verify_treasurer' => 'Verify Treasurer',
            'verify_t_ques1' => 'समूह का नाम, पदाधिकारीयों के नाम व फ़ोन नम्बर सत्यापित करें',
            'verify_t_ques2' => 'क्या आपके पास स्मार्ट्फ़ोन है?',
            'verify_t_ques3' => 'अगर हाँ तो, क्या आप समूह सम्बन्धी मोबाइल ऐप अपने फ़ोन पर चलने के लिए सहमत हैं?',
            'verify_over_all' => 'Verify Over All',
            'verify_shg_member_by' => 'Verify Shg Member By',
            'verify_shg_member_datetime' => 'Verify Shg Member Datetime',
        ];
    }

    public function SaveUser() {
//        try {
//

        if (($this->designation == CboMasterMemberDesignation::SHG_CHAIRPERSON and $this->verify_chaire_person == 1) or ($this->designation == CboMasterMemberDesignation::SHG_SECRETARY and $this->verify_secretary == 1) or ($this->designation == CboMasterMemberDesignation::SHG_TREASURER and $this->verify_treasurer == 1)) {
            if (isset($this->user_model) and $this->user_model != null) {
                if ($this->user_model->role != MasterRole::ROLE_CBO_USER) {
                    return $this;
                }
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
                $this->user_model->dummy_column = $this->shg_model->dummy_column;
            }
            if ($this->user_model->isNewRecord) {
                $this->user_model->action_type = 1;
            } else {
                $this->user_model->action_type = 2;
            }
            if ($this->user_model->save()) {
                $p_bank = \common\models\master\MasterPartnerBankDistrict::findOne(['district_code' => $this->shg_model->district_code]);
                if ($this->cbo_member_profile_model != null) {
                    $this->cbo_member_profile_model->shg = 1;
                    if ($this->cbo_member_profile_model->bc == '0') {
                        $this->cbo_member_profile_model->first_name = $this->name;
                        $this->cbo_member_profile_model->primary_phone_no = $this->mobile_no;
                        $this->cbo_member_profile_model->division_code = $this->shg_model->division_code;
                        $this->cbo_member_profile_model->division_name = $this->shg_model->division_name;
                        $this->cbo_member_profile_model->district_code = $this->shg_model->district_code;
                        $this->cbo_member_profile_model->district_name = $this->shg_model->district_name;
                        $this->cbo_member_profile_model->block_code = $this->shg_model->block_code;
                        $this->cbo_member_profile_model->block_name = $this->shg_model->block_name;
                        $this->cbo_member_profile_model->gram_panchayat_code = $this->shg_model->gram_panchayat_code;
                        $this->cbo_member_profile_model->gram_panchayat_name = $this->shg_model->gram_panchayat_name;
                        $this->cbo_member_profile_model->village_code = $this->shg_model->village_code;
                        $this->cbo_member_profile_model->village_name = $this->shg_model->village_name;
                        $this->cbo_member_profile_model->hamlet = $this->shg_model->hamlet;
                        $this->cbo_member_profile_model->master_partner_bank_id = isset($p_bank) ? $p_bank->master_partner_bank_id : '0';
                    }
                } else {
                    $this->cbo_member_profile_model = new CboMemberProfile();
                    $this->cbo_member_profile_model->user_id = $this->user_model->id;
                    $this->cbo_member_profile_model->first_name = $this->name;
                    $this->cbo_member_profile_model->primary_phone_no = $this->mobile_no;
                    $this->cbo_member_profile_model->shg = 1;
                    $this->cbo_member_profile_model->division_code = $this->shg_model->division_code;
                    $this->cbo_member_profile_model->division_name = $this->shg_model->division_name;
                    $this->cbo_member_profile_model->district_code = $this->shg_model->district_code;
                    $this->cbo_member_profile_model->district_name = $this->shg_model->district_name;
                    $this->cbo_member_profile_model->block_code = $this->shg_model->block_code;
                    $this->cbo_member_profile_model->block_name = $this->shg_model->block_name;
                    $this->cbo_member_profile_model->gram_panchayat_code = $this->shg_model->gram_panchayat_code;
                    $this->cbo_member_profile_model->gram_panchayat_name = $this->shg_model->gram_panchayat_name;
                    $this->cbo_member_profile_model->village_code = $this->shg_model->village_code;
                    $this->cbo_member_profile_model->village_name = $this->shg_model->village_name;
                    $this->cbo_member_profile_model->hamlet = $this->shg_model->hamlet;
                    $this->cbo_member_profile_model->master_partner_bank_id = isset($p_bank) ? $p_bank->master_partner_bank_id : '0';
                }
                $this->cbo_member_profile_model->save();
                if ($this->cbo_member_model == null) {
                    $this->cbo_member_model = new CboMembers();
                }
                $this->cbo_member_model->user_id = $this->user_model->id;
                $this->cbo_member_model->cbo_type = CboMembers::CBO_TYPE_SHG;
                $this->cbo_member_model->cbo_id = $this->shg_model->id;
                $this->cbo_member_model->entry_type = 1;
                $this->cbo_member_model->role = $this->designation;
                if (in_array($this->designation, [\cbo\models\CboMasterMemberDesignation::SHG_CHAIRPERSON])) {
                    $this->cbo_member_model->shg_chairperson = 1;
                }
                if (in_array($this->designation, [\cbo\models\CboMasterMemberDesignation::SHG_SECRETARY])) {
                    $this->cbo_member_model->shg_secretary = 1;
                }
                if (in_array($this->designation, [\cbo\models\CboMasterMemberDesignation::SHG_TREASURER])) {
                    $this->cbo_member_model->shg_treasurer = 1;
                }
                if (in_array($this->designation, [\cbo\models\CboMasterMemberDesignation::SHG_MEMBER])) {
                    $this->cbo_member_model->shg_member = 1;
                }

                $this->cbo_member_model->status = CboMembers::CBO_MEMBER_STATUS_CONFIRM;
                if (in_array($this->designation, [\cbo\models\CboMasterMemberDesignation::SHG_CHAIRPERSON])) {
                    $this->shg_model->verify_chaire_person = $this->verify_chaire_person;
                    $this->shg_model->ch_user_id = $this->user_model->id;
                    if (isset(\Yii::$app->user->identity->id)) {
                        $this->shg_model->ch_verify_by = \Yii::$app->user->identity->id;
                    } else {
                        $this->shg_model->ch_verify_by = $this->user_model->id;
                    }
                    $this->shg_model->ch_verify_date = new \yii\db\Expression('NOW()');
                    $this->shg_model->verify_over_all = 1;
                    $this->shg_model->save();
                }
                if (in_array($this->designation, [\cbo\models\CboMasterMemberDesignation::SHG_SECRETARY])) {
                    $this->shg_model->verify_secretary = $this->verify_secretary;
                    $this->shg_model->se_user_id = $this->user_model->id;
                    if (isset(\Yii::$app->user->identity->id)) {
                        $this->shg_model->se_verify_by = \Yii::$app->user->identity->id;
                    } else {
                        $this->shg_model->se_verify_by = $this->user_model->id;
                    }
                    $this->shg_model->se_verify_date = new \yii\db\Expression('NOW()');
                    $this->shg_model->verify_over_all = 1;
                    $this->shg_model->save();
                }
                if (in_array($this->designation, [\cbo\models\CboMasterMemberDesignation::SHG_TREASURER])) {
                    $this->shg_model->verify_treasurer = $this->verify_treasurer;
                    $this->shg_model->te_user_id = $this->user_model->id;
                    if (isset(\Yii::$app->user->identity->id)) {
                        $this->shg_model->te_verify_by = \Yii::$app->user->identity->id;
                    } else {
                        $this->shg_model->te_verify_by = $this->user_model->id;
                    }
                    $this->shg_model->te_verify_date = new \yii\db\Expression('NOW()');
                    $this->shg_model->verify_over_all = 1;
                    $this->shg_model->save();
                }
                if ($this->cbo_member_model->save()) {
                    
                }
                $sms = new \common\components\Sms();
                $sms->mobile_number = $this->user_model->username;
                $sms->Sendcstapplink($sms->mobile_number);
            }
            return $this;
        } else {
            return $this;
        }
//        } catch (\Exception $ex) {
//            echo "<pre>";
//            print_r($ex->getMessage());
//            exit();
//        }
    }

    public function Assignshg() {
        if ($this->cbo_member_model == null) {
            $this->cbo_member_model = new CboMembers();
        }
        $this->cbo_member_model->user_id = $this->user_model->id;
        $this->cbo_member_model->cbo_type = CboMembers::CBO_TYPE_SHG;
        $this->cbo_member_model->cbo_id = $this->shg_model->id;
        $this->cbo_member_model->entry_type = 1;
        $this->cbo_member_model->role = $this->designation;
        if (in_array($this->designation, [\cbo\models\CboMasterMemberDesignation::SHG_CHAIRPERSON])) {
            $this->cbo_member_model->shg_chairperson = 1;
        }
        if (in_array($this->designation, [\cbo\models\CboMasterMemberDesignation::SHG_SECRETARY])) {
            $this->cbo_member_model->shg_secretary = 1;
        }
        if (in_array($this->designation, [\cbo\models\CboMasterMemberDesignation::SHG_TREASURER])) {
            $this->cbo_member_model->shg_treasurer = 1;
        }
        if (in_array($this->designation, [\cbo\models\CboMasterMemberDesignation::SHG_MEMBER])) {
            $this->cbo_member_model->shg_member = 1;
        }

        $this->cbo_member_model->status = CboMembers::CBO_MEMBER_STATUS_CONFIRM;
        if (in_array($this->designation, [\cbo\models\CboMasterMemberDesignation::SHG_CHAIRPERSON])) {
            $this->shg_model->verify_chaire_person = $this->verify_chaire_person;
            $this->shg_model->ch_user_id = $this->user_model->id;
            if (isset(\Yii::$app->user->identity->id)) {
                $this->shg_model->ch_verify_by = \Yii::$app->user->identity->id;
            } else {
                $this->shg_model->ch_verify_by = $this->user_model->id;
            }
            $this->shg_model->ch_verify_date = new \yii\db\Expression('NOW()');
            $this->shg_model->verify_over_all = 1;
            $this->shg_model->save();
        }
        if (in_array($this->designation, [\cbo\models\CboMasterMemberDesignation::SHG_SECRETARY])) {
            $this->shg_model->verify_secretary = $this->verify_secretary;
            $this->shg_model->se_user_id = $this->user_model->id;
            if (isset(\Yii::$app->user->identity->id)) {
                $this->shg_model->se_verify_by = \Yii::$app->user->identity->id;
            } else {
                $this->shg_model->se_verify_by = $this->user_model->id;
            }
            $this->shg_model->se_verify_date = new \yii\db\Expression('NOW()');
            $this->shg_model->verify_over_all = 1;
            $this->shg_model->save();
        }
        if (in_array($this->designation, [\cbo\models\CboMasterMemberDesignation::SHG_TREASURER])) {
            $this->shg_model->verify_treasurer = $this->verify_treasurer;
            $this->shg_model->te_user_id = $this->user_model->id;
            if (isset(\Yii::$app->user->identity->id)) {
                $this->shg_model->te_verify_by = \Yii::$app->user->identity->id;
            } else {
                $this->shg_model->te_verify_by = $this->user_model->id;
            }
            $this->shg_model->te_verify_date = new \yii\db\Expression('NOW()');
            $this->shg_model->verify_over_all = 1;
            $this->shg_model->save();
        }
        if ($this->cbo_member_model->save()) {
            $p_bank = \common\models\master\MasterPartnerBankDistrict::findOne(['district_code' => $this->shg_model->district_code]);
            if ($this->cbo_member_profile_model != null) {
                $this->cbo_member_profile_model->shg = 1;
                if ($this->cbo_member_profile_model->bc == '0') {
                    $this->cbo_member_profile_model->first_name = $this->name;
                    $this->cbo_member_profile_model->primary_phone_no = $this->mobile_no;
                    $this->cbo_member_profile_model->division_code = $this->shg_model->division_code;
                    $this->cbo_member_profile_model->division_name = $this->shg_model->division_name;
                    $this->cbo_member_profile_model->district_code = $this->shg_model->district_code;
                    $this->cbo_member_profile_model->district_name = $this->shg_model->district_name;
                    $this->cbo_member_profile_model->block_code = $this->shg_model->block_code;
                    $this->cbo_member_profile_model->block_name = $this->shg_model->block_name;
                    $this->cbo_member_profile_model->gram_panchayat_code = $this->shg_model->gram_panchayat_code;
                    $this->cbo_member_profile_model->gram_panchayat_name = $this->shg_model->gram_panchayat_name;
                    $this->cbo_member_profile_model->village_code = $this->shg_model->village_code;
                    $this->cbo_member_profile_model->village_name = $this->shg_model->village_name;
                    $this->cbo_member_profile_model->hamlet = $this->shg_model->hamlet;
                    $this->cbo_member_profile_model->master_partner_bank_id = isset($p_bank) ? $p_bank->master_partner_bank_id : '0';
                }
            } else {
                $this->cbo_member_profile_model = new CboMemberProfile();
                $this->cbo_member_profile_model->user_id = $this->user_model->id;
                $this->cbo_member_profile_model->first_name = $this->name;
                $this->cbo_member_profile_model->primary_phone_no = $this->mobile_no;
                $this->cbo_member_profile_model->shg = 1;
                $this->cbo_member_profile_model->division_code = $this->shg_model->division_code;
                $this->cbo_member_profile_model->division_name = $this->shg_model->division_name;
                $this->cbo_member_profile_model->district_code = $this->shg_model->district_code;
                $this->cbo_member_profile_model->district_name = $this->shg_model->district_name;
                $this->cbo_member_profile_model->block_code = $this->shg_model->block_code;
                $this->cbo_member_profile_model->block_name = $this->shg_model->block_name;
                $this->cbo_member_profile_model->gram_panchayat_code = $this->shg_model->gram_panchayat_code;
                $this->cbo_member_profile_model->gram_panchayat_name = $this->shg_model->gram_panchayat_name;
                $this->cbo_member_profile_model->village_code = $this->shg_model->village_code;
                $this->cbo_member_profile_model->village_name = $this->shg_model->village_name;
                $this->cbo_member_profile_model->hamlet = $this->shg_model->hamlet;
                $this->cbo_member_profile_model->master_partner_bank_id = isset($p_bank) ? $p_bank->master_partner_bank_id : '0';
            }
            $this->cbo_member_profile_model->save();
        }
    }
}
