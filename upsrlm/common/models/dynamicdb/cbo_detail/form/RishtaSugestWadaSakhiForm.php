<?php

namespace common\models\dynamicdb\cbo_detail\form;

use Yii;
use common\models\dynamicdb\cbo_detail\RishtaShgMember;
use common\models\CboMembers;
use common\models\User;
use common\models\CboMemberProfile;
use common\models\master\MasterRole;
use common\models\dynamicdb\cbo_detail\RishtaShgSamuhSakhiSmsApppinStatus;

/**
 * Class RishtaSugestWadaSakhiForm
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class RishtaSugestWadaSakhiForm extends \yii\base\Model {

    public $cbo_shg_id;
    public $sugest_wada_sakhi_member_id;
    public $shg_members_option = [];
    public $shg_model;
    public $user_model;
    public $shg_member_model;
    public $cbo_member_profile_model;
    public $cbo_member_model;
    public $samuh_sakhi_model;

    public function __construct($shg_model) {
        $this->shg_model = $shg_model;

        if ($this->shg_model != null) {

            $this->cbo_shg_id = $this->shg_model->id;
            $this->samuh_sakhi_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $this->cbo_shg_id, 'status' => 1, 'suggest_wada_sakhi' => 1])->one();
        }
        $this->shg_members_option = \common\models\base\GenralModel::rishta_shg_member_option($this);
        if ($this->samuh_sakhi_model != null) {
            $this->sugest_wada_sakhi_member_id = $this->samuh_sakhi_model->id;
        }
    }

    public function rules() {
        return [
            [['cbo_shg_id', 'sugest_wada_sakhi_member_id'], 'required', 'message' => "{attribute} खाली नहीं हो सकता."],
            [['sugest_wada_sakhi_member_id'], \common\validators\CheckWadaSakhSuggestiValidator::className()],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'cbo_shg_id' => 'SHG',
            'sugest_wada_sakhi_member_id' => 'समूह सखी का सुझाव दें',
        ];
    }

    public function Save() {
        $this->shg_model = \cbo\models\Shg::findOne($this->cbo_shg_id);
        $this->shg_member_model = RishtaShgMember::findOne($this->sugest_wada_sakhi_member_id);
        if ($this->shg_member_model != null) {
            $this->user_model = User::find()->where(['username' => $this->shg_member_model->mobile])->one();
            if (isset($this->user_model) and $this->user_model != null) {
                if ($this->user_model->otp_value == null) {
                    $this->user_model->otp_value = \common\helpers\Utility::generateNumericOTP(4);
                }
            } else {
                $this->user_model = new User();
                $this->user_model->name = $this->shg_member_model->name;
                $this->user_model->mobile_no = $this->shg_member_model->mobile;
                $this->user_model->username = $this->shg_member_model->mobile;
                $this->user_model->role = MasterRole::ROLE_CBO_USER;
                $this->user_model->email = $this->shg_member_model->mobile . '@gmail.com';
                $this->user_model->password = $this->shg_member_model->mobile;
                $this->user_model->setPassword($this->shg_member_model->mobile);
                $this->user_model->setUpd($this->shg_member_model->mobile);
                $this->user_model->status = User::STATUS_ACTIVE;
                $this->user_model->profile_status = 1;
                $this->user_model->login_by_otp = 2;
                $this->user_model->otp_value = \common\helpers\Utility::generateNumericOTP(4);
                $this->user_model->dummy_column = $this->shg_model->dummy_column;
            }
            if ($this->user_model->save()) {
                $p_bank = \common\models\master\MasterPartnerBankDistrict::findOne(['district_code' => $this->shg_model->district_code]);
                $this->cbo_member_profile_model = CboMemberProfile::findOne(['user_id' => $this->user_model->id]);
                if ($this->cbo_member_profile_model != null) {
                    $this->cbo_member_profile_model->shg = 1;
                } else {
                    $this->cbo_member_profile_model = new CboMemberProfile();
                    $this->cbo_member_profile_model->user_id = $this->user_model->id;
                    $this->cbo_member_profile_model->first_name = $this->shg_member_model->name;
                    $this->cbo_member_profile_model->primary_phone_no = $this->shg_member_model->mobile;
                    $this->cbo_member_profile_model->shg = 1;
                    $this->cbo_member_profile_model->division_code = $this->shg_model->division_code;
                    $this->cbo_member_profile_model->division_name = $this->shg_model->division_name;
                    $this->cbo_member_profile_model->district_code = $this->shg_model->district_code;
                    $this->cbo_member_profile_model->district_name = $this->shg_model->district_name;
                    $this->cbo_member_profile_model->block_code = $this->shg_model->block_code;
                    $this->cbo_member_profile_model->folder_prefix = $this->shg_model->block_code;
                    $this->cbo_member_profile_model->block_name = $this->shg_model->block_name;
                    $this->cbo_member_profile_model->gram_panchayat_code = $this->shg_model->gram_panchayat_code;
                    $this->cbo_member_profile_model->gram_panchayat_name = $this->shg_model->gram_panchayat_name;
                    $this->cbo_member_profile_model->master_partner_bank_id = isset($p_bank) ? $p_bank->master_partner_bank_id : '0';
                }
                $this->cbo_member_profile_model->folder_prefix = $this->shg_model->block_code;
                $this->cbo_member_profile_model->save();
                $this->shg_member_model->user_id = $this->user_model->id;
                $this->shg_member_model->suggest_wada_sakhi = 1;
                $this->shg_member_model->save();
                $this->cbo_member_model = CboMembers::findOne(['cbo_type' => CboMembers::CBO_TYPE_SHG, 'cbo_id' => $this->shg_model->id, 'user_id' => $this->user_model->id]);
                if ($this->cbo_member_model == null) {
                    $this->cbo_member_model = new CboMembers();
                    $this->cbo_member_model->user_id = $this->user_model->id;
                    $this->cbo_member_model->cbo_type = CboMembers::CBO_TYPE_SHG;
                    $this->cbo_member_model->cbo_id = $this->shg_model->id;
                    $this->cbo_member_model->entry_type = 1;
                    $this->cbo_member_model->suggest_wada_sakhi = 1;
                } else {
                    $this->cbo_member_model->suggest_wada_sakhi = 1;
                }

                $this->cbo_member_model->status = CboMembers::CBO_MEMBER_STATUS_CONFIRM;
                if ($this->cbo_member_model->save()) {
                    
                }
                try {
                    $sms_serve = new \common\components\sms\Smssarv();
                    $sms_log_model = new \common\models\rishta\RishtaSmsLog();
                    $sms_log_model->user_id = $this->user_model->id;
                    $sms_log_model->mobile_number = $this->user_model->username;
                    $sms_log_model->rishta_sms_template_id = \common\components\sms\Smssarv::RISHTA_APP_LINK_PIN_TEMPLATE_ID;
                    $sms_log_model->model = json_encode(['mobile_number' => $this->user_model->username, 'pin' => $this->user_model->otp_value, 'template_id' => \common\components\sms\Smssarv::TEMPLATE_ID_LINK_PIN]);
                    $sms_log_model->sms_content = $sms_serve::sms_content(['m' => $this->user_model->username, 'pin' => $this->user_model->otp_value], \common\components\sms\Smssarv::RISHTA_APP_LINK_PIN_TEMPLATE_ID);
                    $sms_log_model->sms_length = strlen($sms_log_model->sms_content);
                    $samuh_sakhi = new RishtaShgSamuhSakhiSmsApppinStatus();
                    $samuh_sakhi->user_id = $this->user_model->id;
                    $samuh_sakhi->mobile_no = $this->user_model->username;
                    $samuh_sakhi->role = 14;
                    $samuh_sakhi->cbo_shg_id = $this->shg_model->id;
                    $samuh_sakhi->district_code = $this->shg_model->district_code;
                    $samuh_sakhi->block_code = $this->shg_model->block_code;
                    $samuh_sakhi->apppin_sms_status = RishtaShgSamuhSakhiSmsApppinStatus::APP_PIN_SMS_STATUS_LOG;
                    if ($sms_log_model->save() and $samuh_sakhi->save()) {
                        $sms_serve->options = ['template_id' => \common\components\sms\Smssarv::TEMPLATE_ID_LINK_PIN, 'template' => $sms_log_model->sms_content, 'contact_numbers' => $this->user_model->username]; //$this->user_model->username];
                        $sms_serve->enableSendSms = \Yii::$app->params['sarv_sms_enable'];
                        if ($sms_serve->enableSendSms) {
                            $log = $sms_serve->SendSMS();
                            if (isset($log) and!empty($log)) {
                                $sms_log_model->sms_send_time = new \yii\db\Expression('NOW()');
                                $sms_log_model->status = 1;
                                $samuh_sakhi->apppin_sms_time = new \yii\db\Expression('NOW()');
                                $samuh_sakhi->apppin_sms_status = RishtaShgSamuhSakhiSmsApppinStatus::APP_PIN_SMS_STATUS_SEND;
                                if (isset($log['msg'])) {
                                    if ($log['msg'] == 'success') {
                                        $samuh_sakhi->apppin_sms_status = RishtaShgSamuhSakhiSmsApppinStatus::APP_PIN_SMS_STATUS_SEND;
                                        $samuh_sakhi->apppin_sms_time = new \yii\db\Expression('NOW()');
                                        $sms_log_model->status = 1;
                                        if (isset($log['data'][0]['campaign_id'])) {
                                            $sms_log_model->sms_provider_campaign_id = $log['data'][0]['campaign_id'];
                                        }
                                        if (isset($log['data'][0]['message_id'])) {
                                            $sms_log_model->sms_provider_message_id = $log['data'][0]['message_id'];
                                        }
                                        $samuh_sakhi->save();
                                    }
                                    if ($log['msg'] == 'error') {
                                        $sms_log_model->status = 2;
                                    }
                                    $sms_log_model->sms_provider_msg = $log['msg'];
                                    $sms_log_model->sms_provider_code = $log['code'];
                                    $sms_log_model->sms_provider_msg_text = $log['msg_text'];
                                }
                                $samuh_sakhi->save();
                                $sms_log_model->save();
                            }
                        }
                    }
                } catch (\Exception $ex) {
                    
                }
                return $this;
            } else {
                return false;
            }
        }
    }

}
