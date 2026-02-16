<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;

class Call1StatusForm extends \yii\base\Model {

    public $verify_complete;
    public $yes_no_option;
    public $srlm_bc_application_model;

    public function __construct($srlm_bc_application_model) {
        //$this->yes_no_option = ['1' => 'Called and Informed', '0' => 'Not Called', '-1' => 'Unable to connect'];
        $this->yes_no_option = ['1' => 'Called and Informed'];
        $this->srlm_bc_application_model = $srlm_bc_application_model;
    }

    public function rules() {
        return [
            [['verify_complete'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'verify_complete' => 'Verify Complete',
        ];
    }

}
