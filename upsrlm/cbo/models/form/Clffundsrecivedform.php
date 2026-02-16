<?php

namespace cbo\models\form;

use Yii;
use cbo\models\CboClf;
use cbo\models\CboClfFunds;
use cbo\models\CboClfMembers;
use cbo\models\form\CboClfMembersForm;
use cbo\models\form\CboClfFundsForm;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * CboClfForm is the model behind the CboClf
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class Clffundsrecivedform extends \yii\base\Model {

    public $id;
    public $cbo_clf_id;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
    public $clf_model;
    public $members_model;
    public $funds_model;
    public $member_role_option = [];
    public $bank_option = [];
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $funds_type_option = [];

    public function __construct($clf_model = null) {
        $this->clf_model = $clf_model;
        $this->cbo_clf_id = $this->clf_model->id;
        
        $this->funds_type_option = \common\models\base\GenralModel::cbo_funds_type_option('clf');
        $this->funds_model[] = new CboClfFundsForm();
        foreach ($this->funds_type_option as $key => $value) {

            $this->funds_model[$key - 1] = new CboClfFundsForm();
            if (isset($this->clf_model->funds)) {
                $funds = CboClfFunds::find()->where(['cbo_clf_id' => $this->clf_model->id, 'fund_type' => $key])->one();
                if ($funds != null) {
                    $this->funds_model[$key - 1]->id = $funds->id;
                    $this->funds_model[$key - 1]->get_funds = $funds->get_funds;
                    $this->funds_model[$key - 1]->cbo_clf_id = $funds->cbo_clf_id;
                    $this->funds_model[$key - 1]->date_of_receipt = $funds->date_of_receipt != null ? \Yii::$app->formatter->asDatetime($funds->date_of_receipt, "php:d-m-Y") : "";
                    $this->funds_model[$key - 1]->instalment_if_any = $funds->instalment_if_any;
                    $this->funds_model[$key - 1]->total_amount_received = $funds->total_amount_received;
                    $this->funds_model[$key - 1]->balance_as_on_date = $funds->balance_as_on_date;
                }
            }
            $this->funds_model[$key - 1]->fund_type = $key;
            $this->funds_model[$key - 1]->type_name = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['cbo_clf_id'], 'integer'],
            //[['cbo_clf_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_clf_id' => 'Name Of CLF',
        ];
    }

    public function save() {

        try {
           
            $condition = ['and',
                ['=', 'cbo_clf_id', $this->clf_model->id,],
                ['!=', 'status', -1],
            ];
            CboClfFunds::updateAll([
                'status' => 0,
                    ], $condition);
            foreach ($this->funds_model as $key => $fund) {
                $cbovofunds = CboClfFunds::find()->where(['cbo_clf_id' => $this->clf_model->id, 'fund_type' => $fund->fund_type])->one();
                if ($cbovofunds == null) {
                    $cbovofunds = new CboClfFunds();
                }
                $cbovofunds->cbo_clf_id = $this->clf_model->id;
                $cbovofunds->get_funds = $fund->get_funds;
                $cbovofunds->fund_type = $fund->fund_type;
                $cbovofunds->date_of_receipt = $fund->date_of_receipt;
                $cbovofunds->instalment_if_any = $fund->instalment_if_any;
                $cbovofunds->total_amount_received = $fund->total_amount_received;
                $cbovofunds->balance_as_on_date = $fund->balance_as_on_date;
                $cbovofunds->status = 1;
                if ($fund->get_funds) {
                    $cbovofunds->save();
                }
            }

            $this->clf_model->save();


            return $this;
        } catch (\Exception $ex) {
            print_r($ex->getMessage());exit;
        }
    }

}
