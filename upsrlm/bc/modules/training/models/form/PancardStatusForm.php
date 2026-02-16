<?php

namespace bc\modules\training\models\form;

use bc\modules\selection\models\base\GenralModel;
use Yii;
use yii\base\Model;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\selection\models\SrlmBcApplication;

class PancardStatusForm extends Model {

    public $id;
    public $pan_card_status;
    public $pan_card_status_by;
    public $pan_card_status_date;
    public $bank_option = [];
    public $bc_application_model;
    public $cbo_bc_model;
    public $action_url;
    public $action_validate_url;
    /**
     * {@inheritdoc}
     */
    public function __construct($model = null) {
        $this->bc_application_model = $model;

        if ($model != null) {
            $this->bc_application_model = $model;
        }
    }

    public function rules() {
        return [
            [['pan_card_status'], 'required'],
            [['pan_card_status'], \common\validators\SbiDistrictBlockedValidator::className()],
            ['pan_card_status', 'in', 'range' => [0, 1]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'pan_card_status' => 'PAN Card available',
            'pan_card_status_by' => 'Pan Card Status By',
            'pan_card_status_date' => 'Pan Card Status Date',
        ];
    }

}
