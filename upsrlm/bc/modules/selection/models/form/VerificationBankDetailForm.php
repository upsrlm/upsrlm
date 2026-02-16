<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\models\NotificationTemplate;
use bc\models\NotificationLog;
use bc\components\GoogleFirebase;
use bc\models\NotificationLogFirebaseDetail;

class VerificationBankDetailForm extends \yii\base\Model {

    public $bc_bank;
    public $shg_bank;
    public $verify_bc_passbook_photo;
    public $verify_bc_passbook_not;
    public $verify_bc_bank_account_no;
    public $verify_bc_branch_code_or_ifsc;
    public $verify_bc_ifsc_code_entered;
    public $verify_bc_other;
    public $verify_bc_other_reason;
    public $bc_bank_verify_by;
    public $bc_bank_verify_date;
    public $verification_status_bc_bank;
    public $verify_bc_shg_passbook_photo;
    public $verify_bc_shg_name;
    public $verify_bc_shg_bank_account_no;
    public $verify_bc_shg_passbook_not;
    public $verify_bc_shg_branch_code_or_ifsc;
    public $verify_bc_shg_ifsc_code_entered;
    public $verify_bc_shg_other;
    public $verify_bc_shg_other_reason;
    public $bc_shg_bank_verify_by;
    public $bc_shg_bank_verify_date;
    public $participant_model;
    public $shg_model;
    public $option = [];

    public function __construct($participant_model) {
        $this->participant_model = $participant_model;
        $this->shg_model = \cbo\models\Shg::findOne($this->participant_model->cbo_shg_id);
        $this->option = [1 => 'हाँ', 0 => 'नहीं'];
        $this->bc_bank = $this->participant_model->bc_bank;
        $this->shg_bank = $this->participant_model->shg_bank;
        if ($this->participant_model->verify_bc_passbook_photo == '0')
            $this->verify_bc_passbook_photo = 1;
        if ($this->participant_model->verify_bc_passbook_not == '0')
            $this->verify_bc_passbook_not = 1;
        if ($this->participant_model->verify_bc_bank_account_no == '0')
            $this->verify_bc_bank_account_no = 1;
        if ($this->participant_model->verify_bc_branch_code_or_ifsc == '0')
            $this->verify_bc_branch_code_or_ifsc = 1;
        if ($this->participant_model->verify_bc_ifsc_code_entered == '0')
            $this->verify_bc_ifsc_code_entered = 1;
        if ($this->participant_model->verify_bc_other == '0')
            $this->verify_bc_other = 1;
        if ($this->participant_model->verify_bc_other == '0')
            $this->verify_bc_shg_other_reason = $this->participant_model->verify_bc_shg_other_reason;
        $this->bc_bank_verify_by = $this->participant_model->bc_bank_verify_by;
        $this->bc_bank_verify_date = $this->participant_model->bc_bank_verify_date;
        $this->verification_status_bc_bank = $this->participant_model->verification_status_bc_bank;
        if ($this->participant_model->verify_bc_shg_passbook_photo == '0')
            $this->verify_bc_shg_passbook_photo = 1;
        if ($this->participant_model->verify_bc_shg_name == '0')
            $this->verify_bc_shg_name = 1;
        if ($this->participant_model->verify_bc_shg_bank_account_no == '0')
            $this->verify_bc_shg_bank_account_no = 1;
        if ($this->participant_model->verify_bc_shg_passbook_not == '0')
            $this->verify_bc_shg_passbook_not = 1;
        if ($this->participant_model->verify_bc_shg_branch_code_or_ifsc == '0')
            $this->verify_bc_shg_branch_code_or_ifsc = 1;
        if ($this->participant_model->verify_bc_shg_ifsc_code_entered == '0')
            $this->verify_bc_shg_ifsc_code_entered = 1;
        if ($this->participant_model->verify_bc_shg_other == '0')
            $this->verify_bc_shg_other = $this->participant_model->verify_bc_shg_other = '0' ? 1 : '';
        if ($this->participant_model->verify_bc_shg_other == '0')
            $this->verify_bc_shg_other_reason = $this->participant_model->verify_bc_shg_other_reason;
        $this->bc_shg_bank_verify_by = $this->participant_model->bc_shg_bank_verify_by;
        $this->bc_shg_bank_verify_date = $this->participant_model->bc_shg_bank_verify_date;
    }

    public function rules() {
        return [
            [['bc_bank', 'verify_bc_passbook_photo', 'verify_bc_bank_account_no', 'verify_bc_branch_code_or_ifsc', 'verification_status_bc_bank', 'bc_bank_verify_by', 'verify_bc_shg_passbook_photo', 'verify_bc_shg_bank_account_no', 'verify_bc_shg_branch_code_or_ifsc', 'bc_shg_bank_verify_by'], 'integer'],
            [['bc_bank', 'shg_bank', 'verify_bc_passbook_photo', 'verify_bc_bank_account_no', 'verify_bc_branch_code_or_ifsc', 'verification_status_bc_bank', 'bc_bank_verify_by', 'verify_bc_shg_passbook_photo', 'verify_bc_shg_bank_account_no', 'verify_bc_shg_branch_code_or_ifsc', 'bc_shg_bank_verify_by'], 'integer'],
            [['bc_bank_verify_date', 'bc_shg_bank_verify_date'], 'safe'],
            [['verify_bc_other_reason', 'verify_bc_shg_other_reason'], 'trim'],
           
//            ['verify_bc_other_reason', 'required', 'when' => function ($model) {
//                    return $model->verify_bc_other == '1' and $model->bc_bank == 1;
//                }, 'whenClient' => "function (attribute, value) {
//                return $('#verify_bc_other').val() ==='1' and $('#bc_bank').val() ==='1';
//            }"],
//            ['verify_bc_shg_other_reason', 'required', 'when' => function ($model) {
//                    return $model->verify_bc_shg_other == '1' and $model->shg_bank == 1;
//                }, 'whenClient' => "function (attribute, value) {
//                return $('#verify_bc_shg_other').val() ==='1' and $('#shg_bank').val() ==='1';
//            }"],
            [['verify_bc_other_reason', 'verify_bc_shg_other_reason'], 'string', 'max' => 512],
            [['verify_bc_passbook_photo', 'verify_bc_passbook_not', 'verify_bc_bank_account_no', 'verify_bc_branch_code_or_ifsc', 'verify_bc_ifsc_code_entered', 'verify_bc_other', 'verify_bc_shg_passbook_photo', 'verify_bc_shg_name', 'verify_bc_shg_bank_account_no', 'verify_bc_shg_passbook_not', 'verify_bc_shg_other', 'verify_bc_shg_branch_code_or_ifsc', 'verify_bc_shg_ifsc_code_entered'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'bc_bank' => 'Bc Bank',
            'shg_bank' => 'Shg Bank',
            'verify_bc_passbook_photo' => '1. बी0सी0 सखी द्वारा स्वयं की अपलोड की गयी पास-बुक स्पष्ट रूप में नही है',
            'verify_bc_passbook_not' => '2. बी0सी0 सखी के द्वारा अपलोड की गयी पास बुक स्वयं की नही है।',
            'verify_bc_bank_account_no' => '3. बी0सी0 सखी द्वारा दर्ज स्वयं के बैंक खाता संख्या अपलोड बैंक खाता की पास-बुक से भिन्न है।',
            'verify_bc_branch_code_or_ifsc' => '4. बी0सी0 सखी के बैंक खाता का दर्ज आई0एफ0एस0सी0 अपलोड की गयी पास-बुक कोड से भिन्न है।',
            'verify_bc_ifsc_code_entered' => '5. बी0सी0 सखी द्वारा अपलोड की गयी स्वयं की बैंक खाता की पास-बुक में आई0एफ0एस0सी0 कोड नही दर्ज है। ',
            'verify_bc_other' => '6. अन्य कारण',
            'verify_bc_other_reason' => 'कारण',
            'bc_bank_verify_date' => 'Bc Bank Verify Date',
            'verify_bc_shg_passbook_photo' => '1. बी0सी0 सखी द्वारा स्वयं सहायता समूह की अपलोड की गयी पास-बुक स्पष्ट रूप में नही है।',
            'verify_bc_shg_name' => '2. बी0सी0 सखी द्वारा दर्ज स्वयं सहायता समूह का नाम अपलोड की गयी पास-बुक में लिखित स्वयं सहायता समूह के नाम से भिन्न है। ',
            'verify_bc_shg_bank_account_no' => '3. बी0सी0 सखी द्वारा दर्ज स्वयं सहायता समूह के बैंक खाता संख्या अपलोड की गयी पास-बुक के खाता संख्या से भिन्न है।',
            'verify_bc_shg_passbook_not' => '4. बी0सी0 सखी द्वारा अपलोड पास-बुक स्वयं सहायता समूह की नही है।',
            'verify_bc_shg_branch_code_or_ifsc' => '5. बी0सी0 सखी द्वारा स्वयं सहायता समूह के बैंक खाता का दर्ज आई0एफ0एस0सी0 अपलोड की गयी पास-बुक कोड से भिन्न है।',
            'verify_bc_shg_ifsc_code_entered' => '6. बी0सी0 सखी द्वारा अपलोड की गयी स्वयं सहायता समूह की पास-बुक में आई0एफ0एस0सी0 कोड नही दर्ज है।',
            'verify_bc_shg_other' => '7. अन्य कारण',
            'verify_bc_shg_other_reason' => 'कारण',
            'bc_shg_bank_verify_by' => 'Bc Shg Bank Verify By',
            'bc_shg_bank_verify_date' => 'Bc Shg Bank Verify Date',
        ];
    }

    public function sendnotification() {
        try {


            $model = SrlmBcApplication::findOne($this->participant_model->id);
            if ($model != null) {
                if ($model->bc_bank == '3' or $model->shg_bank = '3') {
                    $template_model = NotificationTemplate::findOne(NotificationTemplate::RETURN_BANK_DETAIL_TEMPLATE_ID_15);
                    $html = '';
                    if ($model->bc_bank == '3') {
                        $html .= 'बी0सी0 सखी बैंक विवरण वापसी का कारण.<br/>';
                        $html .= $model->bcbankrjregion;
                    }

                    if ($model->shg_bank == '3') {
                        $html .= 'बी0सी0 सखी का स्वयं सहायता समूह बैंक विवरण वापसी का कारण .<br/>';
                        $html .= $model->bcshgbankrjregion;
                    }
                    $noti_log_model = new NotificationLog();
                    $noti_log_model->notification_type = NotificationLog::NOTIFICATION_TYPE_BC_APPLICATION_SELECTION;
                    $noti_log_model->notification_sub_type = NotificationLog::NOTIFICATION_SUB_TYPE_BC_APPLICATION_SELECTION_ACKNOLEDGE;
                    $noti_log_model->detail_id = $template_model->id;
                    $noti_log_model->user_id = $model->user->id;
                    $noti_log_model->app_id = $model->user->srlm_bc_selection_app_detail_id;
                    $noti_log_model->visible = $template_model->visible;
                    $noti_log_model->acknowledge = $template_model->acknowledge;
                    $noti_log_model->message_title = $template_model->name;
                    $noti_log_model->message = strip_tags($html);
                    $noti_log_model->cron_status = 0;
                    $noti_log_model->status = 0;
                    if ($noti_log_model->save()) {

                        $notification = \bc\models\NotificationLog::findOne($noti_log_model->id);
                        $firbase_tocken = $notification->bcuser->firebase_token;
//                    $firbase_tocken = 'czKXaVWbQnqHQrAEqQEIf-:APA91bEdTjwZuT5eCReYk2oT1D3osMspDSMC6h9UtmarYpGcrztVAijUrHblEWSh36aebXQ1beYkRHS_SKaNfnfhcOXnQPkIu9VNsNHjzASKtm-C9ily50-LdVD2M1ax-EKfPkgA7ryj';
                        $firebase = new \bc\components\GoogleFirebase($notification);
                        $response = $firebase->send($firbase_tocken);

                        $response_result = json_decode($response);
                        $notification->cron_status = '1';
                        $notification->status = '1';
                        $notification->send_count = ($notification->send_count + 1);
                        $notification_model_detail = new NotificationLogFirebaseDetail();
                        $notification_model_detail->notification_log_id = $notification->id;
                        if ($response_result == null) {
                            $notification->status = 3;
                            $notification_model_detail->firebase_message = "No Token";
                        } else {
                            if ($response_result->success) {
                                $notification->status = 2;
                                $notification->send_datetime = new \yii\db\Expression('NOW()');
                                $notification_model_detail->firebase_id = isset($response_result->results[0]->message_id) ? $response_result->results[0]->message_id : NULL;
                            } else {
                                $notification->status = 4;
                                $notification_model_detail->firebase_message = isset($response_result->results[0]->error) ? $response_result->results[0]->error : NULL;
                            }
                        }
                        $notification_model_detail->save();
                        $notification->update();
                    }
                }
            }
            return true;
        } catch (\Exception $ex) {
            return true;
        }
    }

}
