<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\RsetisBatchParticipants;

class BCSHGPFMSMapedForm extends \yii\base\Model {

    public $bc_bank;
    public $shg_bank;
    public $pfms_maped_status;
    public $bc_shg_funds_status;
    public $bc_shg_funds_date;
    public $bc_shg_funds_amount;
    public $bc_shg_funds_by;
    public $participant_model;
    public $shg_model;
    public $option = [];

    public function __construct($participant_model) {
        $this->participant_model = $participant_model;
        $this->shg_model = \cbo\models\Shg::findOne($this->participant_model->cbo_shg_id);
        $this->option = [1 => 'हाँ', 0 => 'नहीं'];
        $this->bc_bank = $this->participant_model->bc_bank;
        $this->shg_bank = $this->participant_model->shg_bank;
    }

    public function rules() {
        return [
//            ['pfms_maped_status', 'required'],
            ['bc_shg_funds_status', 'required'],
            ['bc_shg_funds_date', 'required', 'when' => function ($model) {
                    return $model->bc_shg_funds_status == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#bc_shg_funds_status').val() == '1';
            }"],
            [['bc_shg_funds_date'], 'safe'],
            [['bc_shg_funds_status'], 'integer'],
            [['bc_shg_funds_date'], 'safe'],
            [['bc_shg_funds_amount'], 'number'],
            [['bc_shg_funds_amount'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'bc_bank' => 'Bc Bank',
            'shg_bank' => 'Shg Bank',
            'pfms_maped_status' => 'PFMS Maped',
            'bc_shg_funds_status' => 'BC SHG funds transfer',
            'bc_shg_funds_date' => 'BC SHG funds transfer date',
        ];
    }

}
