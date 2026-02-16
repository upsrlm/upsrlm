<?php

namespace bc\modules\training\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;

class RevertBankVerificationForm extends \yii\base\Model {

    public $revert;
    public $application_model;
    public $agree_option = [];

    public function __construct($application_model) {
        $this->application_model = $application_model;
    }

    public function rules() {
        return [
            [['revert'], 'required', 'requiredValue' => 1, 'message' => 'Please checked the revert checkbox'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'revert' => 'Revert Bank Verification',
        ];
    }

}
