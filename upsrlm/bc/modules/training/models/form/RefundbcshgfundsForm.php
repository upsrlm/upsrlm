<?php

namespace bc\modules\training\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\RsetisBatchParticipants;

class RefundbcshgfundsForm extends \yii\base\Model {

    public $bc_shg_funds_refund_status;
    public $bc_shg_funds_refund_amount;
    public $bc_shg_funds_refund_date;
    public $bc_shg_funds_refund_by;
    public $bc_shg_funds_refund_datetime;
    public $participant_model;
    public $shg_model;
    public $option = [];

    public function __construct($participant_model) {
        $this->participant_model = $participant_model;
        $this->shg_model = \cbo\models\Shg::findOne($this->participant_model->cbo_shg_id);
        $this->option = [1 => 'हाँ', 0 => 'नहीं'];
    }

    public function rules() {
        return [
            ['bc_shg_funds_refund_status', 'required'],
            ['bc_shg_funds_refund_date', 'required'],
            [['bc_shg_funds_refund_status'], 'integer'],
            [['bc_shg_funds_refund_date'], 'safe'],
            [['bc_shg_funds_refund_datetime'], 'safe'],
            [['bc_shg_funds_refund_amount'], 'number'],
            [['bc_shg_funds_refund_amount'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'bc_shg_funds_refund_status' => 'BC SHG funds refund',
            'bc_shg_funds_refund_amount' => 'BC SHG funds refund amount',
            'bc_shg_funds_refund_date' => 'BC SHG funds refund date',
            'bc_shg_funds_refund_by' => 'BC SHG funds refund entry by',
            'bc_shg_funds_refund_datetime' => 'BC SHG funds refund entry date',
        ];
    }

}
