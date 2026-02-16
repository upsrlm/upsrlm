<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\base\Model;
use common\models\User;
use bc\modules\selection\models\base\GenralModel;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\BcUnwillingRsetis;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

class UnwillingCdoNewForm extends Model {

    public $id;
    public $bc_application_id;
    public $bc_selection_user_id;
    public $entry_type;
    public $unwilling_reason;
    public $unwilling_reason1;
    public $unwilling_reason2;
    public $unwilling_reason3;
    public $unwilling_reason4;
    public $unwilling_reason5;
    public $unwilling_reason6;
    public $unwilling_reason7;
    public $unwilling_reason8;
    public $unwilling_reason9;
    public $unwilling_reason10;
    public $unwilling_reason11;
    public $unwilling_reason12;
    public $is_pvr;
    public $is_shg_assign;
    public $is_bc_shg_bank;
    public $is_pfms_mapping;
    public $is_support_fund_shg;
    public $is_onboarding;
    public $is_handheld_machine;
    public $is_bc_operational;
    public $is_bc_receive_support_fund;
    public $funds_returned_to_shg;
    public $return_date_of_support_fund;
    public $support_fund_responsible_name;
    public $support_fund_responsible_mobile_no;
    public $unwilling_reason7_text;
    public $confirm;
    public $entry_by;
    public $entry_date;
    public $training_status;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $status;
    public $bc_model;
    public $unwilling_model;
    public $unwilling_reason_option = [];
    public $yes_no_option = [];

    public function __construct($bc_model) {
        $this->bc_model = $bc_model;
        $this->training_status = $this->bc_model->training_status;
        $this->entry_type = SrlmBcApplication::UNWILLING_TYPE_BANK;
        $this->unwilling_model = BcUnwillingRsetis::findOne(['bc_application_id' => $this->bc_model->id, 'entry_type' => $this->entry_type]);
        $this->status=$this->unwilling_model->status;
        if ($this->bc_model != NULL) {
            $this->bc_application_id = $this->bc_model->id;
            $this->bc_selection_user_id = $this->bc_model->srlm_bc_selection_user_id;
        }
        $this->unwilling_reason_option = GenralModel::unwilling_reason_bank_option_new();
        $this->yes_no_option = [1 => 'हाँ', 2 => 'नहीं'];
    }

    public function rules() {
        return [
            [['bc_application_id', 'bc_selection_user_id'], 'required', 'message' => 'Is required'],
            [['unwilling_reason'], 'required', 'message' => 'एक से ज़्यादा कारण पर टिक कर सकते हैं'],
//            ['unwilling_reason', 'each', 'rule' => ['integer']],
            [['unwilling_reason1', 'unwilling_reason2', 'unwilling_reason3', 'unwilling_reason4', 'unwilling_reason5', 'unwilling_reason6', 'unwilling_reason7', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'safe'],
            [['unwilling_reason8', 'unwilling_reason9', 'unwilling_reason10', 'unwilling_reason11', 'unwilling_reason12'], 'safe'],
            [['entry_date'], 'safe'],
            [['unwilling_reason7_text'], 'string', 'max' => 500],
            [['unwilling_reason7_text'], 'trim'],
            ['unwilling_reason', \common\validators\BankUnwillingValidator::className()],
            ['training_status', 'in', 'range' => [3]],
            ['status', 'in', 'range' => [2]],
            ['is_bc_operational', 'required'],
            ['is_pvr', 'required'],
            ['is_shg_assign', 'required'],
            ['is_bc_shg_bank', 'required'],
            ['is_pfms_mapping', 'required'],
            ['is_support_fund_shg', 'required'],
            ['is_handheld_machine', 'required'],
            ['is_onboarding', 'required'],
            ['is_bc_receive_support_fund', 'required'],
            ['funds_returned_to_shg', 'required', 'when' => function ($model) {
                    return $model->is_bc_receive_support_fund == '1';
                }, 'message' => '{attribute} चयन कीजिए', 'whenClient' => "function (attribute, value) {
                  return $('#is_bc_receive_support_fund').val() == '1';
            }"],
            ['return_date_of_support_fund', 'required', 'when' => function ($model) {
                    return $model->is_bc_receive_support_fund == '1' and $model->funds_returned_to_shg == '2';
                }, 'message' => '{attribute} चयन कीजिए', 'whenClient' => "function (attribute, value) {
                  return $('#is_bc_receive_support_fund').val() == '1' and $('#funds_returned_to_shg').val() == '2'; 
            }"],
            ['support_fund_responsible_name', 'required', 'when' => function ($model) {
                    return $model->is_bc_receive_support_fund == '1' and $model->funds_returned_to_shg == '2';
                }, 'message' => '{attribute} चयन कीजिए', 'whenClient' => "function (attribute, value) {
                  return $('#is_bc_receive_support_fund').val() == '1' and $('#funds_returned_to_shg').val() == '2'; 
            }"],
            ['support_fund_responsible_mobile_no', 'required', 'when' => function ($model) {
                    return $model->is_bc_receive_support_fund == '1' and $model->funds_returned_to_shg == '2';
                }, 'message' => '{attribute} चयन कीजिए', 'whenClient' => "function (attribute, value) {
                  return $('#is_bc_receive_support_fund').val() == '1' and $('#funds_returned_to_shg').val() == '2'; 
            }"],
            [['is_pvr', 'is_shg_assign', 'is_bc_shg_bank', 'is_pfms_mapping', 'is_support_fund_shg', 'is_onboarding', 'is_handheld_machine', 'is_bc_operational', 'is_bc_receive_support_fund', 'funds_returned_to_shg'], 'integer'],
            [['return_date_of_support_fund'], 'safe'],
            [['return_date_of_support_fund'], 'trim'],
            [['support_fund_responsible_name'], 'trim'],
            [['support_fund_responsible_mobile_no'], 'trim'],
            [['support_fund_responsible_name'], 'string', 'min' => 2],
            [['support_fund_responsible_name'], 'string', 'max' => 255],
            [['support_fund_responsible_mobile_no'], 'string', 'max' => 15],
            [['support_fund_responsible_mobile_no'], \common\validators\MobileNoValidator::className(), 'message' => 'Invalid Mobile No'],
//            [['confirm'], 'compare', 'compareValue' => true, 'message' => 'Please tick authenticated'], 
             ['confirm','compare', 'compareValue' => true, 'when' => function ($model) {
                    return $model->is_bc_receive_support_fund == '1' and $model->funds_returned_to_shg == '1';
                }, 'message' => '{attribute} टिक करें', 'whenClient' => "function (attribute, value) {
                  return $('#is_bc_receive_support_fund').val() == '1' and $('#funds_returned_to_shg').val() == '1'; 
            }"],            
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'unwilling_reason' => 'अगर हाँ, तो कृपया अपने अनिच्छा के कारण बतायें -',
            'unwilling_reason7_text' => 'कोई अन्य कारण;',
            'is_bc_operational' => 'क्या बीसी ऑपरेशनल हैं/ थीं?',
            'is_bc_receive_support_fund' => 'क्या बीसी सखी ने बीसी सपोर्ट फण्ड प्राप्त किया है?',
            'funds_returned_to_shg' => 'अगर हाँ, तो क्या फण्ड की वापसी assigned SHG में की गई है?',
            'is_pvr' => 'पीवीआर',
            'is_shg_assign' => 'बीसी-एसएचजी लिंक',
            'is_bc_shg_bank' => 'बीसी-एसएचजी बैंक खाता सत्यापित',
            'is_pfms_mapping' => 'पीएफएमएस मैपिंग',
            'is_support_fund_shg' => 'बीसी-सहायता निधि (एसएचजी)',
            'is_handheld_machine' => 'हैंडहेल्ड मशीन उपलब्ध करायी गयी',
            'is_onboarding' => 'ऑनबोर्डिंग',
            'is_bc_operational' => 'क्या बीसी ऑपरेशनल हैं/ थीं',
            'is_bc_receive_support_fund' => 'क्या बीसी सखी ने बीसी सपोर्ट फण्ड प्राप्त किया है',
            'funds_returned_to_shg' => 'क्या फण्ड की वापसी assigned SHG में की गई है?',
            'return_date_of_support_fund' => 'किस तारीख़ तक वापस करेंगे, संकेत करें',
            'support_fund_responsible_name' => 'बीसी सपोर्ट फण्ड वापसी के लिए ज़िम्मेदार अधिकारी/ प्रोफेशनल का नाम',
            'support_fund_responsible_mobile_no' => 'बीसी सपोर्ट फण्ड वापसी के लिए ज़िम्मेदार अधिकारी/ प्रोफेशनल का मोबाइल नंबर',
            'confirm'=>'मैंने पार्टनर एजेंसी/ मुख्य विकास अधिकारी के प्रतिनिधित्व में वस्तुस्थिति की परीक्षण के बाद पूरी ज़िम्मेदारी से बीसी सखी के फण्ड वापसी कन्फर्म किया है। इस रिपोर्ट के सत्यता की ज़िम्मेदारी मुझ पर है ।',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save() {

        $this->unwilling_model->setAttributes([
            'bc_application_id' => $this->bc_application_id,
            'bc_selection_user_id' => $this->bc_selection_user_id,
            'cdo_entry_by' => \Yii::$app->user->identity->id,
            'cdo_entry_date' => new Expression('NOW()'),
            'entry_type' => $this->entry_type,
        ]);

        if (isset($this->unwilling_reason) and is_array($this->unwilling_reason)) {
            foreach ($this->unwilling_reason as $unwilling_reason_val) {
                $name = 'cdo_unwilling_reason' . $unwilling_reason_val;
                $this->unwilling_model->$name = 1;
            }
        }
        $this->unwilling_model->is_pvr = $this->is_pvr;
        $this->unwilling_model->is_shg_assign = $this->is_shg_assign;
        $this->unwilling_model->is_bc_shg_bank = $this->is_bc_shg_bank;
        $this->unwilling_model->is_pfms_mapping = $this->is_pfms_mapping;
        $this->unwilling_model->is_support_fund_shg = $this->is_support_fund_shg;
        $this->unwilling_model->is_handheld_machine = $this->is_handheld_machine;
        $this->unwilling_model->is_onboarding = $this->is_onboarding;

        $this->unwilling_model->is_bc_operational = $this->is_bc_operational;
        $this->unwilling_model->is_bc_receive_support_fund = $this->is_bc_receive_support_fund;
        if ($this->is_bc_receive_support_fund == 1) {
            $this->unwilling_model->funds_returned_to_shg = $this->funds_returned_to_shg;
        }
        if ($this->is_bc_receive_support_fund == 1 and $this->funds_returned_to_shg == 2) {
            $this->unwilling_model->return_date_of_support_fund = $this->return_date_of_support_fund;
            $this->unwilling_model->support_fund_responsible_name = $this->support_fund_responsible_name;
            $this->unwilling_model->support_fund_responsible_mobile_no = $this->support_fund_responsible_mobile_no;
        }
        if ($this->is_bc_receive_support_fund == 1 and $this->funds_returned_to_shg == 1) {
            $this->unwilling_model->confirm = 1;
           
        }
        if(isset($this->unwilling_model->status) and $this->unwilling_model->status==2){
            $this->unwilling_model->status=3;
        }
        if ($this->unwilling_model->validate()) {
            if ($this->unwilling_model->save()) {
                $this->bc_model->bc_unwilling_cdo = 1;
                $this->bc_model->bc_unwilling_cdo_by = \Yii::$app->user->identity->id;
                $this->bc_model->bc_unwilling_cdo_date = new Expression('NOW()');
                $this->bc_model->action_type = SrlmBcApplication::ACTION_TYPE_BC_UNWILLING_CDO;
                $this->bc_model->save();
                return $this->unwilling_model;
            } else {

                return false;
            }
        } else {

            return false;
        }
    }
}
