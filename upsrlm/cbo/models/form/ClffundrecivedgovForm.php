<?php

namespace cbo\models\form;

use cbo\models\CboClf;
use cbo\models\CboClfFunds;
use Yii;

/**
 * CboClfFundsForm is the model behind the CboClfFunds
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class ClffundrecivedgovForm extends \yii\base\Model {

    public $id;
    public $get_funds;
    public $cbo_clf_id;
    public $fund_type;
    public $type_name;
    public $date_of_receipt;
    public $instalment_if_any;
    public $total_amount_received;
    public $balance_as_on_date;
    public $received_by;
    public $clf_model;
    public $clf_funds_gov_model;
    public $fund_type_option = [];
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;

    public function __construct($clf_model, $clf_funds_gov_model = null) {
        $this->get_funds = 1;
        $this->received_by = CboClfFunds::RECEIVED_BY_GOV;
        $this->fund_type_option = \common\models\base\GenralModel::cbo_funds_type_option('clf');
        $this->clf_model = $clf_model;
        $this->cbo_clf_id = $this->clf_model->id;
        $this->clf_funds_gov_model = new CboClfFunds();
        $this->clf_funds_gov_model->cbo_clf_id = $this->clf_model->id;
        $this->clf_funds_gov_model->get_funds = $this->get_funds;
        $this->clf_funds_gov_model->received_by = $this->received_by;
        if ($clf_funds_gov_model != null) {
            $this->clf_funds_gov_model = $clf_funds_gov_model;
            $this->cbo_clf_id = $this->clf_funds_gov_model->cbo_clf_id;
            $this->get_funds = $this->clf_funds_gov_model->get_funds;
            $this->fund_type = $this->clf_funds_gov_model->fund_type;
            $this->date_of_receipt = $this->clf_funds_gov_model->date_of_receipt != null ? \Yii::$app->formatter->asDatetime($this->clf_funds_gov_model->date_of_receipt, "php:d-m-Y") : ""; //$this->clf_funds_gov_model->date_of_receipt;
            $this->instalment_if_any = $this->clf_funds_gov_model->instalment_if_any;
            $this->total_amount_received = $this->clf_funds_gov_model->total_amount_received;
            $this->balance_as_on_date = $this->clf_funds_gov_model->balance_as_on_date;
            $this->received_by = $this->clf_funds_gov_model->received_by;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['date_of_receipt'], 'trim'],
            [['instalment_if_any'], 'trim'],
            [['total_amount_received'], 'trim'],
            [['balance_as_on_date'], 'trim'],
            [['cbo_clf_id'], 'required'],
            [['fund_type'], 'required'],
            ['date_of_receipt', 'required'],
            ['instalment_if_any', 'required'],
            ['total_amount_received', 'required'],
            ['balance_as_on_date', 'required'],
            ['date_of_receipt', 'required'],
            [['cbo_clf_id', 'fund_type', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['date_of_receipt'], 'safe'],
            [['instalment_if_any', 'total_amount_received', 'balance_as_on_date'], 'number'],
            ['instalment_if_any', 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_clf_id' => 'CLF',
            'fund_type' => 'थीमेटिक स्कीम',
            'date_of_receipt' => 'धन प्राप्त तिथि',
            'instalment_if_any' => 'कोई इंस्टॉलमेंट',
            'total_amount_received' => 'कुल प्राप्त धनराशि',
            'balance_as_on_date' => 'बैंक अकाउंट में दर्ज अद्यतन धनराशि',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save() {

        try {
            $this->clf_funds_gov_model->cbo_clf_id = $this->cbo_clf_id;
            $this->clf_funds_gov_model->get_funds = $this->get_funds;
            $this->clf_funds_gov_model->fund_type = $this->fund_type;
            $this->clf_funds_gov_model->date_of_receipt = $this->date_of_receipt;
            $this->clf_funds_gov_model->instalment_if_any = $this->instalment_if_any;
            $this->clf_funds_gov_model->total_amount_received = $this->total_amount_received;
            $this->clf_funds_gov_model->balance_as_on_date = $this->balance_as_on_date;
            $this->clf_funds_gov_model->received_by = $this->received_by;
            if ($this->clf_funds_gov_model->save()) {
                $this->clf_model->save();
                return $this;
            } else {
                return false;
            }

            
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
    }

}
