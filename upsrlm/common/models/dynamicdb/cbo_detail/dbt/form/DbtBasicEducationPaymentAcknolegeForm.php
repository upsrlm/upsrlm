<?php

namespace common\models\dynamicdb\cbo_detail\dbt\form;

use Yii;
use yii\helpers\ArrayHelper;
use common\validators\MobileNoValidator;
use common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiaryMember;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeMgnrega;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeMgnregaYesno;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeMgnregaApplicant;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeMgnregaMasterCast;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeMgnregaDaFtoAcknowledge;

/**
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class DbtBasicEducationPaymentAcknolegeForm extends \yii\base\Model {

    public $dbt_beneficiary_basic_education_payment_id;
    public $name;
    public $payment_acknowledge;
    public $payment_acknowledge_by;
    public $payment_acknowledge_date;
    public $dbt_remit;
    public $withdrawn_any_amount_after_receiving_dbt;
    public $for_educational_purpose_only;
    public $get_monthyear;
    public $shg_member;
    public $payment_ack_model;
    public $status;
    public $yesnooption = [];
    public $get_monthyear_option = [];
    public $for_educational_purpose_only_option = [];

    public function __construct($model) {
        $this->get_monthyear_option = \common\models\base\GenralModel::month_option_basic_education();
        $this->payment_ack_model = $model;
        if ($this->payment_ack_model != null) {
            $this->name = $this->payment_ack_model->name_of_beneficiary;
            if ($this->payment_ack_model->payment_acknowledge) {
                $this->dbt_remit = $this->payment_ack_model->dbt_remit;
                $this->withdrawn_any_amount_after_receiving_dbt = $this->payment_ack_model->withdrawn_any_amount_after_receiving_dbt;
                $this->for_educational_purpose_only = $this->payment_ack_model->for_educational_purpose_only;
                $this->get_monthyear = $this->payment_ack_model->get_monthyear;
                $this->shg_member = $this->payment_ack_model->shg_member;
            }
        }
        $this->dbt_beneficiary_basic_education_payment_id = $model->id;
        $this->yesnooption = [1 => 'हाँ', 2 => 'नहीं '];
        $this->for_educational_purpose_only_option = [1 => 'हाँ', 2 => 'नहीं ', 3 => 'पता नहीं'];
    }

    public function rules() {
        return [
            [['dbt_beneficiary_basic_education_payment_id'], 'required', 'message' => "{attribute} भरे."],
            [['dbt_remit'], 'required', 'message' => "{attribute} चुने."],
            [['withdrawn_any_amount_after_receiving_dbt'], 'required', 'message' => "{attribute} चुने."],
            [['for_educational_purpose_only'], 'required', 'message' => "{attribute} चुने."],
            [['shg_member'], 'required', 'message' => "{attribute} चुने."],
            ['get_monthyear', 'required', 'when' => function ($model) {
                    return $model->dbt_remit == 1;
                }, 'message' => "{attribute} चुने.", 'whenClient' => "function (attribute, value) {
                  return $('#dbt_remit').val() == '1';
            }"],
            [['get_monthyear'], 'safe'],
            [['dbt_remit', 'withdrawn_any_amount_after_receiving_dbt', 'for_educational_purpose_only', 'shg_member'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'name' => '1). नाम',
            'dbt_remit' => 'लाभार्थी के खाते में संदर्भित DBT remit हो गया है',
            'withdrawn_any_amount_after_receiving_dbt' => 'क्या लाभार्थी/ कस्टमर ने DBT प्राप्त करने के उपरांत कोई राशि निकाली',
            'for_educational_purpose_only' => 'क्या लाभार्थी द्वारा निकाली गई राशि शिक्षा के लिए ही उद्द्येशित है?',
            'get_monthyear' => 'आपके बैंक खाते में डीबीटी कब remit हुई?',
            'shg_member' => 'क्या आप या आपके परिवार का कोई सदस्य एसएचजी/ समूह का भी सदस्य है?',
        ];
    }

    public function save() {

        $this->payment_ack_model->payment_acknowledge = 1;
        $this->payment_ack_model->payment_acknowledge_by = \Yii::$app->user->identity->id;
        $this->payment_ack_model->payment_acknowledge_date = new \yii\db\Expression('NOW()');
        $this->payment_ack_model->dbt_remit = $this->dbt_remit;
        $this->payment_ack_model->withdrawn_any_amount_after_receiving_dbt = $this->withdrawn_any_amount_after_receiving_dbt;
        $this->payment_ack_model->for_educational_purpose_only = $this->for_educational_purpose_only;
        if ($this->get_monthyear and $this->dbt_remit==1) {
            $this->payment_ack_model->get_monthyear = $this->get_monthyear;
        }
        $this->payment_ack_model->shg_member = $this->shg_member;
        $this->payment_ack_model->save();
        return $this->payment_ack_model;
    }

}
