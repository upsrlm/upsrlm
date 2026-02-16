<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\base\Model;
use bc\modules\selection\models\base\GenralModel;
use bc\modules\selection\models\SrlmBcApplication;
use cbo\models\CboBc;

class AcknowledgesupportfundsForm extends Model {

    public $id;
    public $bc_support_funds_received;
    public $bc_support_funds_received_date;
    public $bc_support_funds_received_submitdate;
    public $bc_support_funds_received_amount;
    public $bc_support_funds_handheld_amount;
    public $bc_support_funds_od_amount;
    public $bc_application_model;

    /**
     * {@inheritdoc}
     */
    public function __construct($model = null) {
        $this->bc_application_model = $model;
    }

    public function rules() {
        return [
            [['bc_support_funds_received', 'bc_support_funds_received_date'], 'safe'],
            [['bc_support_funds_received_submitdate', 'bc_support_funds_received_amount'], 'safe'],
            [['bc_support_funds_received_amount'], 'safe'],
            [['bc_support_funds_handheld_amount'], 'safe'],
            [['bc_support_funds_od_amount'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_support_funds_received' => 'bc_support_funds_received',
            'bc_support_funds_received_date' => 'bc_support_funds_received_date',
            'bc_support_funds_received_submitdate' => 'bc_support_funds_received_submitdate',
            'bc_support_funds_received_amount' => 'bc_support_funds_received_amount',
            'bc_support_funds_handheld_amount' => 'bc_support_funds_handheld_amount',
            'bc_support_funds_od_amount' => 'bc_support_funds_od_amount',
        ];
    }

}
