<?php

namespace bc\modules\selection\modules\phasefour\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication4;
use bc\modules\training\models\RsetisBatchParticipants;

class ValidateByTliForm extends \yii\base\Model {

    public $form_data_validate;
    public $bc_model;
    public $form_data_validation_option = [];

    public function __construct($bc_model) {
        $this->bc_model = $bc_model;
        
    }

    public function rules() {
        return [
            [['form_data_validate'], 'required'],
            ['form_data_validate', 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'form_data_validate' => 'Application Data',
        ];
    }

}
