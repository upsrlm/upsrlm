<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\base\Model;
use bc\modules\selection\models\base\GenralModel;
use bc\modules\selection\models\SrlmBcApplication;
use cbo\models\CboBc;

class AcknowledgehandheldmachineForm extends Model {

    public $id;
    public $did_partner_bank_contact_bc;
    public $bc_handheld_machine_recived;
    public $bc_handheld_machine_photo;
    public $bc_handheld_machine_recived_submitdate;
    public $bc_application_model;

    /**
     * {@inheritdoc}
     */
    public function __construct($model = null) {
        $this->bc_application_model = $model;
    }

    public function rules() {
        return [
            [['did_partner_bank_contact_bc', 'bc_handheld_machine_recived'], 'safe'],
            [['bc_handheld_machine_photo', 'bc_handheld_machine_recived_submitdate'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'did_partner_bank_contact_bc' => 'Did partner bank contact bc',
            'bc_handheld_machine_recived' => 'Handheld machine recived',
            'bc_handheld_machine_photo' => 'Handheld machine photo',
            'bc_handheld_machine_recived_submitdate' => 'Handheld machine recived submitdate',
        ];
    }

}
