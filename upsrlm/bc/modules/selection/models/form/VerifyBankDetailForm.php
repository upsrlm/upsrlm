<?php

namespace bc\modules\selection\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\RsetisBatchParticipants;

class VerifyBankDetailForm extends \yii\base\Model {

    public $bc_bank;
    public $shg_bank;
    public $verify_bc_passbook_photo;
    public $verify_bc_bank_account_no;
    public $verify_bc_branch_code_or_ifsc;
    public $verify_bc_shg;
    public $bc_bank_verify_by;
    public $bc_bank_verify_date;
    public $verification_status_bc_bank;
    public $verify_bc_shg_passbook_photo;
    public $verify_bc_shg_bank_account_no;
    public $verify_bc_shg_branch_code_or_ifsc;
    public $bc_shg_bank_verify_by;
    public $bc_shg_bank_verify_date;
    public $participant_model;
    public $shg_model;
    public $option = [];

    public function __construct($participant_model) {
        $this->participant_model = $participant_model;
        $this->shg_model = \cbo\models\Shg::findOne($this->participant_model->cbo_shg_id);
        $this->option = [1 => 'हाँ', 0 => 'नहीं'];
        $this->bc_bank = $this->participant_model->bc_bank;
        $this->shg_bank = $this->participant_model->shg_bank;
        $this->verify_bc_passbook_photo = $this->participant_model->verify_bc_passbook_photo;
        $this->verify_bc_bank_account_no = $this->participant_model->verify_bc_bank_account_no;
        $this->verify_bc_branch_code_or_ifsc = $this->participant_model->verify_bc_branch_code_or_ifsc;
        $this->verify_bc_shg = $this->participant_model->verify_bc_shg;
        $this->bc_bank_verify_by = $this->participant_model->bc_bank_verify_by;
        $this->bc_bank_verify_date = $this->participant_model->bc_bank_verify_date;
        $this->verification_status_bc_bank = $this->participant_model->verification_status_bc_bank;

        $this->verify_bc_shg_passbook_photo = $this->participant_model->verify_bc_shg_passbook_photo;
        $this->verify_bc_shg_bank_account_no = $this->participant_model->verify_bc_shg_bank_account_no;
        $this->verify_bc_shg_branch_code_or_ifsc = $this->participant_model->verify_bc_shg_branch_code_or_ifsc;
        $this->bc_shg_bank_verify_by = $this->participant_model->bc_shg_bank_verify_by;
        $this->bc_shg_bank_verify_date = $this->participant_model->bc_shg_bank_verify_date;
    }

    public function rules() {
        return [
            ['verify_bc_passbook_photo', 'required', 'when' => function ($model) {
                    return $model->bc_bank == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#bc_bank').val() == '1';
            }"],
            ['verify_bc_bank_account_no', 'required', 'when' => function ($model) {
                    return $model->bc_bank == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#bc_bank').val() == '1';
            }"],
            ['verify_bc_branch_code_or_ifsc', 'required', 'when' => function ($model) {
                    return $model->bc_bank == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#bc_bank').val() == '1';
            }"],
            ['verify_bc_shg', 'required', 'when' => function ($model) {
                    return $model->bc_bank == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#bc_bank').val() == '1';
            }"],
            ['verify_bc_shg_passbook_photo', 'required', 'when' => function ($model) {
                    return $model->shg_bank == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#shg_bank').val() == '1';
            }"],
            ['verify_bc_shg_bank_account_no', 'required', 'when' => function ($model) {
                    return $model->shg_bank == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#shg_bank').val() == '1';
            }"],
            ['verify_bc_shg_branch_code_or_ifsc', 'required', 'when' => function ($model) {
                    return $model->shg_bank == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#shg_bank').val() == '1';
            }"],
            [['bc_bank', 'shg_bank', 'verify_bc_passbook_photo', 'verify_bc_bank_account_no', 'verify_bc_branch_code_or_ifsc', 'verify_bc_shg', 'verification_status_bc_bank', 'bc_bank_verify_by', 'verify_bc_shg_passbook_photo', 'verify_bc_shg_bank_account_no', 'verify_bc_shg_branch_code_or_ifsc', 'bc_shg_bank_verify_by'], 'integer'],
            [['bc_bank_verify_date', 'bc_shg_bank_verify_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'bc_bank' => 'Bc Bank',
            'shg_bank' => 'Shg Bank',
            'verify_bc_passbook_photo' => 'Verify Bc Passbook Photo',
            'verify_bc_bank_account_no' => 'Verify Bc Bank Account No',
            'verify_bc_branch_code_or_ifsc' => 'Verify Bc Branch Code Or Ifsc',
            'verify_bc_shg' => 'Verify Bc Shg',
            'verification_status_bc_bank' => 'Verification Status Bc Bank',
            'bc_bank_verify_by' => 'Bc Bank Verify By',
            'bc_bank_verify_date' => 'Bc Bank Verify Date',
            'verify_bc_shg_passbook_photo' => 'Verify Bc Shg Passbook Photo',
            'verify_bc_shg_bank_account_no' => 'Verify Bc Shg Bank Account No',
            'verify_bc_shg_branch_code_or_ifsc' => 'Verify Bc Shg Branch Code Or Ifsc',
            'bc_shg_bank_verify_by' => 'Bc Shg Bank Verify By',
            'bc_shg_bank_verify_date' => 'Bc Shg Bank Verify Date',
        ];
    }

}
