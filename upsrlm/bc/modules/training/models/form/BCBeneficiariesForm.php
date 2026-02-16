<?php

namespace bc\modules\training\models\form;

use Yii;
use yii\base\Model;
use bc\modules\selection\models\base\GenralModel;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\BcHonorariumPayment;

class BCBeneficiariesForm extends Model {

    public $id;
    public $bc_beneficiaries_code;
    public $repeat_bc_beneficiaries_code;
    public $bc_beneficiaries_code_by;
    public $bc_beneficiaries_code_date;
    public $bc_application_model;
    public $bc_payment_model;
    public static $beneficiariesRegexp = '/^[A-Z]{6}[0-9]{8}?$/';
    /**
     * {@inheritdoc}
     */
    public function __construct($model) {
        $this->bc_application_model = $model;
        $this->bc_beneficiaries_code = $this->bc_application_model->bc_beneficiaries_code;
        if ($this->bc_application_model->bcpayment == null) {
            $this->bc_payment_model = new BcHonorariumPayment();
        } else {
            $this->bc_payment_model = $this->bc_application_model->bcpayment;
        }
    }

    public function rules() {
        return [
            [['bc_beneficiaries_code'], 'required'],
            [['repeat_bc_beneficiaries_code'], 'required'],
            [['bc_beneficiaries_code'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->bc_application_model->$attribute != $model->$attribute;
                }, 'targetClass' => SrlmBcApplication::className(), 'message' => 'This BC Beneficiaries code has already been taken', 'targetAttribute' => 'bc_beneficiaries_code'],
//           ['bc_beneficiaries_code', 'match', 'pattern' => static::$beneficiariesRegexp], 
           ['bc_beneficiaries_code', 'string', 'min' => 13, 'max' => 14, 'message' => 'Invalid {attribute}'],
           ['repeat_bc_beneficiaries_code', 'compare', 'compareAttribute'=>'bc_beneficiaries_code', 'message'=>"BC Beneficiaries code don't match" ],             
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_beneficiaries_code' => 'BC Beneficiaries code',
            'repeat_bc_beneficiaries_code' => 'Repeat BC Beneficiaries code',
        ];
    }

}
