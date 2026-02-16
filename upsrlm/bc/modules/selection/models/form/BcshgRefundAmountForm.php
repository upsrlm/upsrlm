<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\RsetisBatchParticipants;

class BcshgRefundAmountForm extends \yii\base\Model {

    public $bc_application_id;
    public $srlm_bc_selection_user_id;
    public $district_code;
    public $block_code;
    public $gram_panchayat_code;
    public $bc_return_amount;
    public $shg_confirm_funds_return_date;
    public $shg_confirm_funds_return_photo;
    public $training_status_option = [];
    public $bc_model;

    public function rules() {
        return [
            [['bc_application_id'], 'required'],
            [['bc_return_amount'], 'required'],
            [['shg_confirm_funds_return_date'], 'required'],
            [['shg_confirm_funds_return_photo'], 'file', 'skipOnEmpty' => TRUE, 'extensions' => 'gif,jpg,jpeg,png', 'maxSize' => 1024 * 1024 * 1, 'tooBig' => 'File Size Limit is I MB'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'bc_application_id' => 'BC Sakhi',
            'bc_return_amount' => 'Return Amount',
            'shg_confirm_funds_return_date' => 'Return Amount Date',
            'shg_confirm_funds_return_photo' => 'कार्यवाही पुस्तिका की फोटो',
        ];
    }

}
