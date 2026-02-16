<?php

namespace bc\modules\training\models\form;

use bc\modules\selection\models\base\GenralModel;
use Yii;
use yii\base\Model;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\selection\models\SrlmBcApplication;

class BeneficiariesForm extends Model {

    public $id;
    public $beneficiaries_code;
    public $repeat_beneficiaries_code;
    public $beneficiaries_code_by;
    public $beneficiaries_code_date;
    public $bc_application_model;
    public $shg_model;
    public static $beneficiariesRegexp = '/^[A-Z]{6}[0-9]{8}?$/';
    /**
     * {@inheritdoc}
     */
    public function __construct($model = null) {
        $this->bc_application_model = $model;
        $this->shg_model = \cbo\models\Shg::findOne($this->bc_application_model->cbo_shg_id);
        if ($model != null) {
            $this->bc_application_model = $model;
        }
    }

    public function rules() {
        return [
            [['beneficiaries_code'], 'required'],
            [['repeat_beneficiaries_code'], 'required'],
//            ['beneficiaries_code', 'match', 'pattern' => static::$beneficiariesRegexp],
            ['beneficiaries_code', 'string', 'min' => 14, 'max' => 14, 'message' => 'Invalid {attribute}'],
            ['repeat_beneficiaries_code', 'compare', 'compareAttribute'=>'beneficiaries_code', 'message'=>"PFMS Beneficiaries code don't match" ],             
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'beneficiaries_code' => 'PFMS Beneficiaries code',
            'repeat_beneficiaries_code' => 'Repeat PFMS Beneficiaries code',
        ];
    }

}
