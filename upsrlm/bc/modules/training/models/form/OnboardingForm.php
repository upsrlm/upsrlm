<?php

namespace bc\modules\training\models\form;

use bc\modules\selection\models\base\GenralModel;
use Yii;
use yii\base\Model;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\selection\models\SrlmBcApplication;
use cbo\models\CboBc;

class OnboardingForm extends Model {

    public $id;
    public $onboarding;
    public $bankidbc;
    public $bc_email_id;
    public $onboarding_by;
    public $onboarding_date_time;
    public $bank_account_no_of_the_bc;
    public $bank_id;
    public $name_of_bank;
    public $branch;
    public $branch_code_or_ifsc;
    public $date_of_opening_the_bank_account;
    public $cin;
    public $passbook_photo;
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
            $this->onboarding = $this->bc_application_model->onboarding;
            $this->bankidbc = $this->bc_application_model->bankidbc;
            $this->bc_email_id = $this->bc_application_model->bc_email_id;
            $this->onboarding_date_time = $this->bc_application_model->onboarding_date_time;
        }
    }

    public function rules() {
        return [
            [['onboarding', 'onboarding_date_time'], 'required'],
            [['bankidbc'], 'required'],
            [['onboarding_date_time'], 'date', 'format' => 'php:Y-m-d'],
            ['onboarding_date_time', \common\validators\DateFromatValidator::className()],
            [['bankidbc'], 'trim'],
            [['bankidbc'], \common\validators\SbiDistrictBlockedValidator::className()],
            [['bankidbc'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->bc_application_model->$attribute != $model->$attribute;
                }, 'targetClass' => SrlmBcApplication::className(), 'message' => 'This Bank ID of BC has already been taken', 'targetAttribute' => 'bankidbc'],
            ['onboarding', 'in', 'range' => [0, 1]],
//            [['bc_email_id'], 'required'],
            [['bc_email_id'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->bc_application_model->$attribute != $model->$attribute;
                }, 'targetClass' => SrlmBcApplication::className(), 'message' => 'This Email ID of BC has already been taken', 'targetAttribute' => 'bc_email_id'],            
            [['bankidbc'], 'string', 'max' => 20],
            [['bc_email_id'], 'string', 'max' => 255], 
            [['bc_email_id'], 'email'],            
            [['onboarding'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'onboarding' => 'Onboarding',
            'bankidbc' => 'Bank ID of BC',
            'bc_email_id' => 'Email ID of BC',
            'onboarding_by' => 'Onboarding By',
            'onboarding_date_time' => 'Onboarding Date',
            
        ];
    }

}
