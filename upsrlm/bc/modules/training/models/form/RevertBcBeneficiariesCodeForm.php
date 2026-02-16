<?php

namespace bc\modules\training\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;

class RevertBcBeneficiariesCodeForm extends \yii\base\Model {

    public $revert;
    public $revert_bc_beneficiaries_reason;
    public $application_model;
    public $reason_option = [];

    public function __construct($application_model) {
        $this->reason_option = [1 => 'BC PFMS Beneficiaries code ग़लत है; typo error', 2 => 'BC के नाम १०० कैरिक्टर से ज़्यादा है'];
        $this->application_model = $application_model;
    }

    public function rules() {
        return [
            [['revert'], 'required', 'requiredValue' => 1, 'message' => 'Please checked the revert checkbox'],
            [['revert_bc_beneficiaries_reason'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'revert' => 'Revert BC PFMS Beneficiaries code',
            'revert_bc_beneficiaries_reason' => 'Revert Reason',
        ];
    }

}
