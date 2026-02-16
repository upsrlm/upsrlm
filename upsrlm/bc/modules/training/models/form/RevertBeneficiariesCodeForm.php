<?php

namespace bc\modules\training\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;

class RevertBeneficiariesCodeForm extends \yii\base\Model {

    public $revert;
    public $revert_beneficiaries_reason;
    public $application_model;
    public $reason_option = [];

    public function __construct($application_model) {
        $this->reason_option = [1 => 'समूह के पदाधिकारी के ID/ CIF पर SHG का अकाउंट है', 2 => 'समूह के नाम १०० कैरिक्टर से ज़्यादा है', 3 => 'SHG ID ग़लत है; typo error'];
        $this->application_model = $application_model;
    }

    public function rules() {
        return [
            [['revert'], 'required', 'requiredValue' => 1, 'message' => 'Please checked the revert checkbox'],
            [['revert_beneficiaries_reason'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'revert' => 'Revert PFMS Beneficiaries code',
            'revert_beneficiaries_reason' => 'Revert Reason',
        ];
    }

}
