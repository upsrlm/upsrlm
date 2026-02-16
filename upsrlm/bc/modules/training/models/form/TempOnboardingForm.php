<?php

namespace bc\modules\training\models\form;

use bc\modules\selection\models\base\GenralModel;
use Yii;
use yii\base\Model;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\selection\models\SrlmBcApplication;
use cbo\models\CboBc;

class TempOnboardingForm extends Model {

    public $id;
    public $temp_bankidbc;
    public $temp_bankidbc_by;
    public $temp_bankidbc_datetime;
    public $bc_application_model;

    /**
     * {@inheritdoc}
     */
    public function __construct($model = null) {
        $this->bc_application_model = $model;
    }

    public function rules() {
        return [
            [['temp_bankidbc'], 'required'],
            [['temp_bankidbc'], 'trim'],
            [['temp_bankidbc'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->bc_application_model->$attribute != $model->$attribute;
                }, 'targetClass' => SrlmBcApplication::className(), 'message' => 'This Bank ID of BC has already been taken', 'targetAttribute' => 'temp_bankidbc'],
            [['temp_bankidbc'], 'string', 'max' => 20],
            [['temp_bankidbc'], 'string', 'min' => 4],            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'temp_bankidbc' => 'Bank ID of BC',
            'temp_bankidbc_datetime' => 'Onboarding Date',
        ];
    }
}
