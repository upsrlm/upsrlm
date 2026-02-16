<?php

namespace common\models\dynamicdb\internalcallcenter\bc\form;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\dynamicdb\internalcallcenter\bc\bcCallingLog;

class CallScenarioForm extends \yii\base\Model {

    public $bcid;
    public $bc_model;
    public $scenario;
    public $bc_calling_model;
    public $scenario_option=[];

    public function __construct($bc_model) {
        $this->bc_model = $bc_model;
        $this->scenario_option = \common\models\base\GenralModel::bc_call_scenario();
      
    }

    public function rules() {
        return [
            [['scenario'], 'required'],
           
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'scenario' => 'Call Scenario',
            
        ];
    }
}
