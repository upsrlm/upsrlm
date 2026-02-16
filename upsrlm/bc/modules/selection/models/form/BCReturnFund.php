<?php

namespace bc\modules\selection\models\form;

use Yii;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\BcSupportFundReturnShg;

/**
 * BCReturnFund is the model behind the BcSupportFundReturnShg
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class BCReturnFund extends \yii\base\Model {

    public $id;
    public $bc_application_id;
    public $srlm_bc_selection_user_id;
    public $user_id;
    public $district_code;
    public $block_code;
    public $gram_panchayat_code;
    public $retrun_amount;
    public $due_amount;
    public $due_after_installment;
    public $shg_has_received_refund;
    public $time_left_full_loan_repay;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $status;
    public $bc_model;
    public $bc_fund_return_model;

    public function __construct($bc_model) {
        $this->bc_model = $bc_model;
        $this->bc_fund_return_model=new BcSupportFundReturnShg();
        $this->bc_application_id = $this->bc_model->id;
        $this->srlm_bc_selection_user_id = $this->bc_model->srlm_bc_selection_user_id;
        $this->user_id = $this->bc_model->user_id;
        $this->district_code = $this->bc_model->district_code;
        $this->block_code = $this->bc_model->block_code;
        $this->gram_panchayat_code = $this->bc_model->gram_panchayat_code;
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id'], 'required'],
            [['srlm_bc_selection_user_id'], 'required'],
            [['retrun_amount'], 'required'],
            [['retrun_amount'], 'number', 'min' => 100],
            [['due_amount'], 'required'],
            [['due_after_installment'], 'required'],
            [['shg_has_received_refund'], 'required'],
            [['time_left_full_loan_repay'], 'required'],
            [['bc_application_id', 'srlm_bc_selection_user_id', 'user_id', 'shg_has_received_refund', 'time_left_full_loan_repay', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['retrun_amount', 'due_amount', 'due_after_installment'], 'number'],
            [['bc_application_id', 'srlm_bc_selection_user_id', 'district_code', 'block_code', 'gram_panchayat_code'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Name',
            'user_id' => 'User ID',
            'retrun_amount' => 'इस दिन/सप्ताह/माह कितना वापस चुकाया?',
            'due_amount' => 'कितना बकाया था',
            'due_after_installment' => 'इस इंस्टॉलमेंट के बाद कितना बकाया रहा',
            'shg_has_received_refund' => 'क्या समूह ने वापसी प्राप्त की है',
            'time_left_full_loan_repay' => 'पूरा ऋण वापस करने में कितने दिन सप्ताह/ महीने बचे हैं',
            'date' => 'दिनांक',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save() {
        $this->bc_fund_return_model->bc_application_id=$this->bc_application_id;
        $this->bc_fund_return_model->srlm_bc_selection_user_id=$this->srlm_bc_selection_user_id;
        $this->bc_fund_return_model->user_id=$this->user_id;
        $this->bc_fund_return_model->district_code=$this->district_code;
        $this->bc_fund_return_model->block_code=$this->block_code;
        $this->bc_fund_return_model->gram_panchayat_code=$this->gram_panchayat_code;
        $this->bc_fund_return_model->retrun_amount=$this->retrun_amount;
        $this->bc_fund_return_model->due_amount=$this->due_amount;
        $this->bc_fund_return_model->due_after_installment=$this->due_after_installment;
        $this->bc_fund_return_model->shg_has_received_refund=$this->shg_has_received_refund;
        $this->bc_fund_return_model->time_left_full_loan_repay=$this->time_left_full_loan_repay;
        $this->bc_fund_return_model->date=new \yii\db\Expression('NOW()');
        if($this->bc_fund_return_model->save()){
            return $this->bc_fund_return_model;
        } else {
            return false;
        }
        
    }

}
