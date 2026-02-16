<?php

namespace bc\modules\selection\models\form;

use Yii;
use bc\modules\selection\models\BcTrackingFeedback;
use common\models\User;
use yii\web\UploadedFile;
use bc\modules\selection\models\SrlmBcApplication;

/**
 * BcTrackingFeedback is the model behind the BcTrackingFeedback
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class BCTrackingFeedbackForm extends \yii\base\Model {

    public $id;
    public $bc_application_id;
    public $srlm_bc_selection_user_id;
    public $user_id;
    //bc_sakhi
    public $ques_1;
    public $ques_2;
    public $ques_3;
    // end
    //partner_bank
    public $ques_4;
    public $ques_5;
    public $ques_6;
    public $ques_7;
    // end 
    //bank
    public $ques_8;
    public $ques_9;
    public $ques_10;
    public $ques_11;
    // end
    // awareness_gap
    public $ques_12;
    public $ques_13;
    public $ques_14;
    public $ques_15;
    // end
    //operational_issues
    public $ques_16;
    public $ques_17;
    public $ques_18;
    public $ques_19;
    public $ques_20;
    // end 
    public $ques1;
    public $ques2;
    public $ques3;
    public $ques4;
    public $ques5;
    // new question section
    public $handheld_device;
    public $handheld_device_ques_1;
    public $handheld_device_ques_2;
    public $handheld_device_ques_3;
    public $handheld_device_ques_4;
    public $handheld_device_ques_5;
    public $fraud_transaction;
    public $fraud_transaction_ques_1;
    public $fraud_transaction_ques_2;
    public $fraud_transaction_ques_3;
    public $fraud_transaction_ques_4;
    public $problems_with_bank;
    public $problems_with_bank_ques_1;
    public $problems_with_bank_ques_2;
    public $bc_commissions_payment;
    public $bc_commissions_payment_ques_1;
    public $bc_commissions_payment_ques_2;
    public $bc_commissions_payment_ques_3;
    public $section;
    public $section_name;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
    public $ques1_option = [];
    public $ques2_option = [];
    public $ques3_option = [];
    public $ques4_option = [];
    public $ques5_option = [];
    public $yesno_option = [1 => 'हाँ', 2 => 'नहीं'];
    public $section_option = [1 => 'सेक्शन 1', 2 => 'सेक्शन 2', 3 => 'सेक्शन 3', 4 => 'सेक्शन 4', 5 => 'सेक्शन 5', 6 => 'कोई समस्या', 7 => 'कोई समस्या', 8 => 'कोई समस्या', 9 => 'कोई समस्या', 10 => 'धन्यवाद।'];
    public $user_model;
    public $bc_feedback_model;
    public $bc_model;

    public function __construct($model) {
        $this->bc_model = $model;
        $this->bc_feedback_model = BcTrackingFeedback::findOne(['bc_application_id' => $this->bc_model->id]);
        $this->ques1_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_bc_sakhi_option();
        $this->ques2_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_partner_bank_option();
        $this->ques3_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_bank_option();
        $this->ques4_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_awareness_gap_option();
        $this->ques5_option = \bc\modules\selection\models\base\GenralModel::bc_tracking_feedback_operational_issues_option();
        if ($this->bc_feedback_model == null) {
            $this->bc_feedback_model = new BcTrackingFeedback();
            $this->bc_feedback_model->bc_application_id = $this->bc_model->id;
            $this->bc_feedback_model->srlm_bc_selection_user_id = $this->bc_model->srlm_bc_selection_user_id;
            $this->bc_feedback_model->user_id = $this->bc_model->user_id;
            $this->bc_feedback_model->district_code = $this->bc_model->district_code;
            $this->bc_feedback_model->block_code = $this->bc_model->block_code;
            $this->bc_feedback_model->gram_panchayat_code = $this->bc_model->gram_panchayat_code;
            $this->bc_feedback_model->master_partner_bank_id = $this->bc_model->master_partner_bank_id;
            $this->bc_application_id = $this->bc_model->id;
            $this->srlm_bc_selection_user_id = $this->bc_model->srlm_bc_selection_user_id;
            $this->bc_feedback_model->user_id = $this->bc_model->user_id;
            $this->bc_application_id = $this->bc_model->id;
            $this->srlm_bc_selection_user_id = $this->bc_model->srlm_bc_selection_user_id;

            $this->user_id = $this->bc_model->user_id;
            $this->section = 1;
        } else {
            $this->bc_application_id = $this->bc_feedback_model->bc_application_id;
            $this->srlm_bc_selection_user_id = $this->bc_feedback_model->srlm_bc_selection_user_id;
            $this->user_id = $this->bc_feedback_model->user_id;
            $this->ques1 = $this->bc_feedback_model->ques1a;
            $this->ques2 = $this->bc_feedback_model->ques2a;
            $this->ques3 = $this->bc_feedback_model->ques3a;
            $this->ques4 = $this->bc_feedback_model->ques4a;
            $this->ques5 = $this->bc_feedback_model->ques5a;
            if ($this->bc_feedback_model->handheld_device != 0) {
                $this->handheld_device = $this->bc_feedback_model->handheld_device;
            }
            if ($this->bc_feedback_model->handheld_device_ques_1 != 0) {
                $this->handheld_device_ques_1 = $this->bc_feedback_model->handheld_device_ques_1;
            }
            if ($this->bc_feedback_model->handheld_device_ques_2 != 0) {
                $this->handheld_device_ques_2 = $this->bc_feedback_model->handheld_device_ques_2;
            }
            if ($this->bc_feedback_model->handheld_device_ques_3 != 0) {
                $this->handheld_device_ques_3 = $this->bc_feedback_model->handheld_device_ques_3;
            }
            if ($this->bc_feedback_model->handheld_device_ques_4 != 0) {
                $this->handheld_device_ques_4 = $this->bc_feedback_model->handheld_device_ques_4;
            }
            if ($this->bc_feedback_model->handheld_device_ques_5 != 0) {
                $this->handheld_device_ques_5 = $this->bc_feedback_model->handheld_device_ques_5;
            }
            if ($this->bc_feedback_model->fraud_transaction != 0) {
                $this->fraud_transaction = $this->bc_feedback_model->fraud_transaction;
            }
            if ($this->bc_feedback_model->fraud_transaction_ques_1 != 0) {
                $this->fraud_transaction_ques_1 = $this->bc_feedback_model->fraud_transaction_ques_1;
            }
            if ($this->bc_feedback_model->fraud_transaction_ques_2 != 0) {
                $this->fraud_transaction_ques_2 = $this->bc_feedback_model->fraud_transaction_ques_2;
            }
            if ($this->bc_feedback_model->fraud_transaction_ques_3 != 0) {
                $this->fraud_transaction_ques_3 = $this->bc_feedback_model->fraud_transaction_ques_3;
            }
            if ($this->bc_feedback_model->fraud_transaction_ques_4 != 0) {
                $this->fraud_transaction_ques_4 = $this->bc_feedback_model->fraud_transaction_ques_4;
            }
            if ($this->bc_feedback_model->problems_with_bank != 0) {
                $this->problems_with_bank = $this->bc_feedback_model->problems_with_bank;
            }
            if ($this->bc_feedback_model->problems_with_bank_ques_1 != 0) {
                $this->problems_with_bank_ques_1 = $this->bc_feedback_model->problems_with_bank_ques_1;
            }
            if ($this->bc_feedback_model->problems_with_bank_ques_2 != 0) {
                $this->problems_with_bank_ques_2 = $this->bc_feedback_model->problems_with_bank_ques_2;
            }
            if ($this->bc_feedback_model->bc_commissions_payment != 0) {
                $this->bc_commissions_payment = $this->bc_feedback_model->bc_commissions_payment;
            }
            if ($this->bc_feedback_model->bc_commissions_payment_ques_1 != 0) {
                $this->bc_commissions_payment_ques_1 = $this->bc_feedback_model->bc_commissions_payment_ques_1;
            }
            if ($this->bc_feedback_model->bc_commissions_payment_ques_2 != 0) {
                $this->bc_commissions_payment_ques_2 = $this->bc_feedback_model->bc_commissions_payment_ques_2;
            }
            if ($this->bc_feedback_model->bc_commissions_payment_ques_3 != 0) {
                $this->bc_commissions_payment_ques_3 = $this->bc_feedback_model->bc_commissions_payment_ques_3;
            }
            $this->section = ($this->bc_feedback_model->section + 1);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id'], 'required'],
            [['srlm_bc_selection_user_id'], 'required'],
            [['ques1'], 'safe', 'on' => ['1']],
            [['ques2'], 'safe', 'on' => ['2']],
            [['ques3'], 'safe', 'on' => ['3']],
            [['ques4'], 'safe', 'on' => ['4']],
            [['ques5'], 'safe', 'on' => ['5']],
            [['ques1'], \common\validators\FeedbackQValidator::className()],
            [['ques2'], \common\validators\FeedbackQValidator::className()],
            [['ques3'], \common\validators\FeedbackQValidator::className()],
            [['ques4'], \common\validators\FeedbackQValidator::className()],
            [['ques5'], \common\validators\FeedbackQValidator::className()],
            [['handheld_device'], 'required', 'on' => ['6'], 'message' => "{attribute} चयन कीजिए।"],
            [['fraud_transaction'], 'required', 'on' => ['7'], 'message' => "{attribute} चयन कीजिए।"],
            [['problems_with_bank'], 'required', 'on' => ['8'], 'message' => "{attribute} चयन कीजिए।"],
            [['bc_commissions_payment'], 'required', 'on' => ['9'], 'message' => "{attribute} चयन कीजिए।"],
            ['handheld_device_ques_1', 'required', 'on' => ['7'], 'when' => function ($model) {
                    return $model->handheld_device == 1 and $model->section == '6';
                }, 'message' => '{attribute} चयन कीजिए।', 'whenClient' => "function (attribute, value) {
                  return $('#handheld_device').val() == '1' && $('#section').val() == '6';
            }"],
            ['handheld_device_ques_2', 'required', 'when' => function ($model) {
                    return $model->handheld_device == 1 and $model->section == '6';
                }, 'message' => '{attribute} चयन कीजिए।', 'whenClient' => "function (attribute, value) {
                  return $('#handheld_device').val() == '1' && $('#section').val() == '6';
            }"],
            ['handheld_device_ques_3', 'required', 'when' => function ($model) {
                    return $model->handheld_device == 1 and $model->section == '6';
                }, 'message' => '{attribute} चयन कीजिए।', 'whenClient' => "function (attribute, value) {
                  return $('#handheld_device').val() == '1' && $('#section').val() == '6';
            }"],
            ['handheld_device_ques_4', 'required', 'when' => function ($model) {
                    return $model->handheld_device == 1 and $model->section == '6';
                }, 'message' => '{attribute} चयन कीजिए।', 'whenClient' => "function (attribute, value) {
                  return $('#handheld_device').val() == '1' && $('#section').val() == '6';
            }"],
            ['handheld_device_ques_5', 'required', 'when' => function ($model) {
                    return $model->handheld_device == 1 and $model->section == '6';
                }, 'message' => '{attribute} चयन कीजिए।', 'whenClient' => "function (attribute, value) {
                  return $('#handheld_device').val() == '1' && $('#section').val() == '6';
            }"],
             
             ['fraud_transaction_ques_1', 'required', 'when' => function ($model) {
                    return $model->fraud_transaction == 1 and $model->section == '7';
                }, 'message' => '{attribute} चयन कीजिए।', 'whenClient' => "function (attribute, value) {
                  return $('#fraud_transaction').val() == '1' && $('#section').val() == '7';
            }"],
            ['fraud_transaction_ques_2', 'required', 'when' => function ($model) {
                    return $model->fraud_transaction == 1 and $model->section == '7';
                }, 'message' => '{attribute} चयन कीजिए।', 'whenClient' => "function (attribute, value) {
                  return $('#fraud_transaction').val() == '1' && $('#section').val() == '7';
            }"],
            ['fraud_transaction_ques_3', 'required', 'when' => function ($model) {
                    return $model->fraud_transaction == 1 and $model->section == '7';
                }, 'message' => '{attribute} चयन कीजिए।', 'whenClient' => "function (attribute, value) {
                  return $('#fraud_transaction').val() == '1' && $('#section').val() == '7';
            }"],
            ['fraud_transaction_ques_4', 'required', 'when' => function ($model) {
                    return $model->fraud_transaction == 1 and $model->section == '7';
                }, 'message' => '{attribute} चयन कीजिए।', 'whenClient' => "function (attribute, value) {
                  return $('#fraud_transaction').val() == '1' && $('#section').val() == '7';
            }"],
            ['problems_with_bank_ques_1', 'required', 'when' => function ($model) {
                    return $model->problems_with_bank == 1 and $model->section == '8';
                }, 'message' => '{attribute} चयन कीजिए।', 'whenClient' => "function (attribute, value) {
                  return $('#problems_with_bank').val() == '1' && $('#section').val() == '8';
            }"],
            ['problems_with_bank_ques_2', 'required', 'when' => function ($model) {
                    return $model->problems_with_bank == 1 and $model->section == '8';
                }, 'message' => '{attribute} चयन कीजिए।', 'whenClient' => "function (attribute, value) {
                  return $('#problems_with_bank').val() == '1' && $('#section').val() == '8';
            }"],  
             ['bc_commissions_payment_ques_1', 'required', 'when' => function ($model) {
                    return $model->bc_commissions_payment == 1 and $model->section == '9';
                }, 'message' => '{attribute} चयन कीजिए।', 'whenClient' => "function (attribute, value) {
                  return $('#bc_commissions_payment').val() == '1' && $('#section').val() == '9';
            }"],
            ['bc_commissions_payment_ques_2', 'required', 'when' => function ($model) {
                    return $model->bc_commissions_payment == 1 and $model->section == '9';
                }, 'message' => '{attribute} चयन कीजिए।', 'whenClient' => "function (attribute, value) {
                  return $('#bc_commissions_payment').val() == '1' && $('#section').val() == '9';
            }"],
            ['bc_commissions_payment_ques_3', 'required', 'when' => function ($model) {
                    return $model->bc_commissions_payment == 1 and $model->section == '9';
                }, 'message' => '{attribute} चयन कीजिए।', 'whenClient' => "function (attribute, value) {
                  return $('#bc_commissions_payment').val() == '1' && $('#section').val() == '9';
            }"],            
            [['handheld_device', 'handheld_device_ques_1', 'handheld_device_ques_2', 'handheld_device_ques_3', 'handheld_device_ques_4', 'handheld_device_ques_5', 'fraud_transaction', 'fraud_transaction_ques_1', 'fraud_transaction_ques_2', 'fraud_transaction_ques_3', 'fraud_transaction_ques_4', 'problems_with_bank', 'problems_with_bank_ques_1', 'problems_with_bank_ques_2', 'bc_commissions_payment', 'bc_commissions_payment_ques_1', 'bc_commissions_payment_ques_2', 'bc_commissions_payment_ques_3'], 'integer'],
            [['bc_application_id', 'srlm_bc_selection_user_id', 'user_id', 'ques_1', 'ques_2', 'ques_3', 'ques_4', 'ques_5', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Bc Application ID',
            'srlm_bc_selection_user_id' => 'Srlm Bc Selection User ID',
            'user_id' => 'User ID',
            'ques1' => 'बीसी सखी के तौर पर आपके कार्य करने में प्रमुख 2 रुकावट क्या हैं?',
            'ques2' => 'बीसी सखी के तौर पर आपके कार्य करने में प्रमुख 2 रुकावट क्या हैं?',
            'ques3' => 'बीसी सखी के तौर पर आपके कार्य करने में प्रमुख 2 रुकावट क्या हैं?',
            'ques4' => 'बीसी सखी के तौर पर आपके कार्य करने में प्रमुख 2 रुकावट क्या हैं?',
            'ques5' => 'बीसी सखी के तौर पर आपके कार्य करने में प्रमुख 2 रुकावट क्या हैं?',
            'handheld_device' => 'हैंडहेल्ड मशीन से सम्बंधित कोई समस्या',
            'handheld_device_ques_1' => 'मशीन गर्म हो जाता है',
            'handheld_device_ques_2' => 'बैटरी की समस्या है / बैकअप नहीं है ',
            'handheld_device_ques_3' => 'ब्लूटूथ की समस्या है ',
            'handheld_device_ques_4' => 'फिंगर प्रिंट स्कैनर काम नहीं केर रहा है ',
            'handheld_device_ques_5' => 'मशीन ख़राब होने ओर बफर स्टैक से तत्काल बदला नहीं गया है , देरी हो रही है',
            'fraud_transaction' => 'फ्रॉड ट्रांसक्शन से  सम्बंधित कोई समस्या',
            'fraud_transaction_ques_1' => 'फ्रॉड कॉल आया है/ था',
            'fraud_transaction_ques_2' => 'फ्रॉड कॉल और फ्रॉड ट्रांसक्शन घटित हुआ है ( तत्काल रपोट करे  )',
            'fraud_transaction_ques_3' => 'पार्टनर बैंक के अन्दुरुनी स्टॉक का फ्रॉड में लिप्त होना ( कॉल सेंटर पैर भी रिपोर्ट करे )',
            'fraud_transaction_ques_4' => 'फ्रॉड कॉल के विषय में समय से कारवाही संपन्न नहीं हुआ है / देरी हो रही है (पुलिस/ बीमा/ बैंक )',
            'problems_with_bank' => 'बैंक से सम्बंधित कोई समस्या',
            'problems_with_bank_ques_1' => 'कैश देने में आनाकानी / देर करना',
            'problems_with_bank_ques_2' => 'कैश के लेन देन में लम्बी लाइन में लगना पड़ता है',
            'bc_commissions_payment' => 'BC  सखी के कमीशन पेमेंट भुगतान से सम्बंधित कोई समस्या ',
            'bc_commissions_payment_ques_1' => 'सही समय पर कमीशन पेमेंट नहीं हुआ है ',
            'bc_commissions_payment_ques_2' => 'कमीशन में अन्यावश्यक कटौती हुआ है  ',
            'bc_commissions_payment_ques_3' => 'कमीशन बैंक के बताये नियम / फार्मूला के अनुरूप नहीं हुआ है',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save() {

        return $this;
    }
}
