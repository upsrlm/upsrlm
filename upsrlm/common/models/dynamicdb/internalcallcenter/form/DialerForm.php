<?php

namespace common\models\dynamicdb\internalcallcenter\form;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\dynamicdb\internalcallcenter\platform\CallingList;

class DialerForm extends \yii\base\Model {

    public $log_id;
    public $customer_number;
    public $call_start_time;
    public $call_end_time;
    public $default_call_scenario_id = 2001;
    public $calling_agent_id;
    public $calling_agent_number;
    public $dialer_model;
    public $customer_number_option = ['8545055020' => 'Shalini', '9415012006' => 'Sandeep Majhi', '9953326121' => 'Vikas Chaudhary'];

    public function rules() {
        return [
            [['customer_number'], 'required'],
            ['customer_number', 'integer'],
            ['customer_number', \common\validators\MobileNoValidator::className()],
            ['customer_number', 'string', 'max' => 10, 'min' => 10],
            [['default_call_scenario_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'customer_number' => 'Mobile Number',
        ];
    }
}
