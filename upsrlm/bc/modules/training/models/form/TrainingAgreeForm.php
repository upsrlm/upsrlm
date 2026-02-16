<?php

namespace bc\modules\training\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;

class TrainingAgreeForm extends \yii\base\Model {

    public $agree;
    public $srlm_bc_application_model;
    public $agree_option=[];
    public function __construct($srlm_bc_application_model) {
        $this->srlm_bc_application_model = $srlm_bc_application_model;
        // $this->agree_option=[SrlmBcApplication::TRAINING_STATUS_INACCESSIBLE=>'Inaccessible Candidate',SrlmBcApplication::TRAINING_STATUS_UNWILLING=>'Unwilling Candidate',SrlmBcApplication::TRAINING_STATUS_AGREE_TRAINING=>'Agree for training'];
        $this->agree_option=[SrlmBcApplication::TRAINING_STATUS_AGREE_TRAINING=>'Agree for training'];
    }

    public function rules() {
        return [
            [['agree'], 'required', 'requiredValue' => 1, 'message' => 'Please checked the agree checkbox'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'agree' => 'Agree for training',
        ];
    }

}
