<?php

namespace bc\modules\training\models\form;

use bc\modules\selection\models\base\GenralModel;
use Yii;
use yii\base\Model;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\selection\models\SrlmBcApplication;

class HandheldMachineForm extends Model {

    public $id;
    public $handheld_machine_status;
    public $handheld_machine_by;
    public $handheld_machine_date;
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
            [['handheld_machine_status'], 'required'],
            [['handheld_machine_status'], \common\validators\SbiDistrictBlockedValidator::className()],
            ['handheld_machine_status', 'in', 'range' => [0, 1]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'handheld_machine_status' => 'Handheld Machine provided',
        ];
    }

}
