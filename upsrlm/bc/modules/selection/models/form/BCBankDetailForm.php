<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\base\Model;
use bc\modules\selection\models\base\GenralModel;
use bc\modules\selection\models\SrlmBcApplication;
use cbo\models\CboBc;

class BCBankDetailForm extends Model {

    public $id;
    public $onboarding;
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

    /**
     * {@inheritdoc}
     */
    public function __construct($model = null) {
        $this->bc_application_model = $model;
        $this->bank_option = \common\models\base\GenralModel::cbo_bank_option($this);
        if ($model != null) {
            $this->bc_application_model = $model;
            $this->bank_account_no_of_the_bc = $this->bc_application_model->bank_account_no_of_the_bc;
            $this->name_of_bank = $this->bc_application_model->name_of_bank;
            $this->bank_id = $this->bc_application_model->bank_id;
            $this->branch = $this->bc_application_model->branch;
            $this->branch_code_or_ifsc = $this->bc_application_model->branch_code_or_ifsc;
            $this->date_of_opening_the_bank_account = $this->bc_application_model->date_of_opening_the_bank_account != null ? \Yii::$app->formatter->asDatetime($this->bc_application_model->date_of_opening_the_bank_account, "php:d-m-Y") : "";

            $this->passbook_photo = $this->bc_application_model->passbook_photo;
        }
    }

    public function rules() {
        return [
            [['bank_account_no_of_the_bc', 'bank_id', 'branch', 'branch_code_or_ifsc'], 'required'],
            [['bank_account_no_of_the_bc', 'bank_id', 'branch', 'branch_code_or_ifsc', 'date_of_opening_the_bank_account', 'cin'], 'trim'],
//            [['cin'], 'unique', 'when' => function ($model, $attribute) {
//                    return $this->bc_application_model->$attribute != $model->$attribute;
//                }, 'targetClass' => SrlmBcApplication::className(), 'message' => 'This CIN has already been taken'],
            [['passbook_photo'], 'required'],
            [['passbook_photo', 'passbook_photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg,jpeg,png,gif', 'wrongExtension' => 'Only jpg,jpeg,png,gif files are allowed'],
            [['passbook_photo', 'passbook_photo'], 'file', 'maxSize' => 1024 * 1024 * 2, 'tooBig' => 'Limit is 2MB'],
            [['onboarding', 'onboarding_by', 'bank_id'], 'integer'],
            [['onboarding_date_time', 'date_of_opening_the_bank_account'], 'safe'],
            [['bank_account_no_of_the_bc', 'branch_code_or_ifsc'], 'string', 'max' => 25],
            [['name_of_bank', 'branch', 'cin'], 'string', 'max' => 150],
            [['passbook_photo'], 'safe'],
            [['onboarding'], 'default', 'value' => 0],
            [['cin'], 'default', 'value' => NULL],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'onboarding' => 'Onboarding',
            'onboarding_by' => 'Onboarding By',
            'onboarding_date_time' => 'Onboarding Date Time',
            'bank_account_no_of_the_bc' => 'Bank Account No Of The Bc',
            'bank_id' => 'Bank ID',
            'name_of_bank' => 'Name Of Bank',
            'branch' => 'Branch',
            'branch_code_or_ifsc' => 'Branch Code Or Ifsc',
            'date_of_opening_the_bank_account' => 'Date Of Opening The Bank Account',
            'cin' => 'CIN',
            'passbook_photo' => 'Passbook / Statement  Photo',
        ];
    }

}
