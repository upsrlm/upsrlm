<?php

namespace cbo\models\form;

use Yii;

/**
 * CboClfFundsForm is the model behind the CboClfFunds
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class CboClfFundsForm extends \yii\base\Model {

    public $id;
    public $get_funds;
    public $cbo_clf_id;
    public $fund_type;
    public $type_name;
    public $date_of_receipt;
    public $instalment_if_any;
    public $total_amount_received;
    public $balance_as_on_date;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;

    public function __construct($funds_model = null) {
        
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
            [['get_funds'], 'required'],
            ['date_of_receipt', 'required', 'when' => function ($model) {
                    return $model->get_funds == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#get_funds').val() == '1';
            }"],
            ['instalment_if_any', 'required', 'when' => function ($model) {
                    return $model->get_funds == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#get_funds').val() == '1';
            }"],
            ['total_amount_received', 'required', 'when' => function ($model) {
                    return $model->get_funds == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#get_funds').val() == '1';
            }"],
            ['balance_as_on_date', 'required', 'when' => function ($model) {
                    return $model->get_funds == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#get_funds').val() == '1';
            }"],
            ['date_of_receipt', 'required', 'when' => function ($model) {
                    return $model->instalment_if_any != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#instalment_if_any').val() !== '';
            }"],
            ['date_of_receipt', 'required', 'when' => function ($model) {
                    return $model->total_amount_received != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#total_amount_received').val() !== '';
            }"],
            ['date_of_receipt', 'required', 'when' => function ($model) {
                    return $model->balance_as_on_date != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#balance_as_on_date').val() !== '';
            }"],
            ['total_amount_received', 'required', 'when' => function ($model) {
                    return $model->date_of_receipt != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#date_of_receipt').val() !== '';
            }"],
            ['total_amount_received', 'required', 'when' => function ($model) {
                    return $model->balance_as_on_date != '';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#balance_as_on_date').val() !== '';
            }"],
            [['cbo_clf_id', 'fund_type', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['date_of_receipt'], 'safe'],
            [['instalment_if_any', 'total_amount_received', 'balance_as_on_date'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_clf_id' => 'Cbo CLF ID',
            'fund_type' => 'Fund Type',
            'date_of_receipt' => 'Date Of Receipt',
            'instalment_if_any' => 'Instalment If Any',
            'total_amount_received' => 'Total Amount Received',
            'balance_as_on_date' => 'Balance as on date',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

}
