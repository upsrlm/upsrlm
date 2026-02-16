<?php

namespace bc\modules\selection\models\form;

use Yii;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\BcHonorariumPayment;
use yii\db\Expression;

/**
 * BCPaymenAckForm is the model behind the BcHonorariumPayment
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class BCPaymenAckForm extends \yii\base\Model {

    public $id;
    public $bc_application_id;
    public $srlm_bc_selection_user_id;
    public $district_code;
    public $block_code;
    public $gram_panchayat_code;
    public $month1;
    public $month1_payment_amount;
    public $month1_payment_date;
    public $month1_payment_by;
    public $month1_payment_datetime;
    public $month1_acknowledge;
    public $month1_acknowledge_recived_date;
    public $month1_acknowledge_rishta_notification;
    public $month1_acknowledge_not_recived_reason;
    public $month1_acknowledge_not_recived_reason_other;
    public $month1_acknowledge_amount;
    public $month1_acknowledge_datetime;
    public $month2;
    public $month2_payment_amount;
    public $month2_payment_date;
    public $month2_payment_by;
    public $month2_payment_datetime;
    public $month2_acknowledge;
    public $month2_acknowledge_recived_date;
    public $month2_acknowledge_rishta_notification;
    public $month2_acknowledge_not_recived_reason;
    public $month2_acknowledge_not_recived_reason_other;
    public $month2_acknowledge_amount;
    public $month2_acknowledge_datetime;
    public $month3;
    public $month3_payment_amount;
    public $month3_payment_date;
    public $month3_payment_by;
    public $month3_payment_datetime;
    public $month3_acknowledge;
    public $month3_acknowledge_recived_date;
    public $month3_acknowledge_rishta_notification;
    public $month3_acknowledge_not_recived_reason;
    public $month3_acknowledge_not_recived_reason_other;
    public $month3_acknowledge_amount;
    public $month3_acknowledge_datetime;
    public $month4;
    public $month4_payment_amount;
    public $month4_payment_date;
    public $month4_payment_by;
    public $month4_payment_datetime;
    public $month4_acknowledge;
    public $month4_acknowledge_recived_date;
    public $month4_acknowledge_rishta_notification;
    public $month4_acknowledge_not_recived_reason;
    public $month4_acknowledge_not_recived_reason_other;
    public $month4_acknowledge_amount;
    public $month4_acknowledge_datetime;
    public $month5;
    public $month5_payment_amount;
    public $month5_payment_date;
    public $month5_payment_by;
    public $month5_payment_datetime;
    public $month5_acknowledge;
    public $month5_acknowledge_recived_date;
    public $month5_acknowledge_rishta_notification;
    public $month5_acknowledge_not_recived_reason;
    public $month5_acknowledge_not_recived_reason_other;
    public $month5_acknowledge_amount;
    public $month5_acknowledge_datetime;
    public $month6;
    public $month6_payment_amount;
    public $month6_payment_date;
    public $month6_payment_by;
    public $month6_payment_datetime;
    public $month6_acknowledge;
    public $month6_acknowledge_recived_date;
    public $month6_acknowledge_rishta_notification;
    public $month6_acknowledge_not_recived_reason;
    public $month6_acknowledge_not_recived_reason_other;
    public $month6_acknowledge_amount;
    public $month6_acknowledge_datetime;
    public $month1_payment_get;
    public $month2_payment_get;
    public $month3_payment_get;
    public $month4_payment_get;
    public $month5_payment_get;
    public $month6_payment_get;
    public $month;
    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;
    public $status;
    public $bc_model;
    public $bc_payment_model;

    public function __construct($bc_model) {
        $this->bc_model = $bc_model;
        $this->bc_application_id = $this->bc_model->id;
        if ($this->bc_model->bcpayment != null) {
            $this->bc_payment_model = $this->bc_model->bcpayment;
        } else {
            $this->bc_payment_model = new BcHonorariumPayment();
            $this->bc_payment_model->bc_application_id = $this->bc_model->id;
            $this->bc_payment_model->srlm_bc_selection_user_id = $this->bc_model->srlm_bc_selection_user_id;
            $this->bc_payment_model->district_code = $this->bc_model->district_code;
            $this->bc_payment_model->block_code = $this->bc_model->block_code;
            $this->bc_payment_model->gram_panchayat_code = $this->bc_model->gram_panchayat_code;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id'], 'required'],
            [['month'], 'required'],
            [['bc_application_id', 'srlm_bc_selection_user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'month1_payment_by', 'month1_acknowledge', 'month1_acknowledge_rishta_notification', 'month1_acknowledge_not_recived_reason', 'month1_acknowledge_not_recived_reason_other', 'month2_payment_by', 'month2_acknowledge', 'month2_acknowledge_rishta_notification', 'month2_acknowledge_not_recived_reason', 'month2_acknowledge_not_recived_reason_other', 'month3_payment_by', 'month3_acknowledge', 'month3_acknowledge_rishta_notification', 'month3_acknowledge_not_recived_reason', 'month3_acknowledge_not_recived_reason_other', 'month4_payment_by', 'month4_acknowledge', 'month4_acknowledge_rishta_notification', 'month4_acknowledge_not_recived_reason', 'month4_acknowledge_not_recived_reason_other', 'month5_payment_by', 'month5_acknowledge', 'month5_acknowledge_rishta_notification', 'month5_acknowledge_not_recived_reason', 'month5_acknowledge_not_recived_reason_other', 'month6_payment_by', 'month6_acknowledge', 'month6_acknowledge_rishta_notification', 'month6_acknowledge_not_recived_reason', 'month6_acknowledge_not_recived_reason_other', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['month1', 'month1_payment_date', 'month1_payment_datetime', 'month1_acknowledge_recived_date', 'month1_acknowledge_datetime', 'month2', 'month2_payment_date', 'month2_payment_datetime', 'month2_acknowledge_recived_date', 'month2_acknowledge_datetime', 'month3', 'month3_payment_date', 'month3_payment_datetime', 'month3_acknowledge_recived_date', 'month3_acknowledge_datetime', 'month4', 'month4_payment_date', 'month4_payment_datetime', 'month4_acknowledge_recived_date', 'month4_acknowledge_datetime', 'month5', 'month5_payment_date', 'month5_payment_datetime', 'month5_acknowledge_recived_date', 'month5_acknowledge_datetime', 'month6', 'month6_payment_date', 'month6_payment_datetime', 'month6_acknowledge_recived_date', 'month6_acknowledge_datetime'], 'safe'],
            [['month1_payment_amount', 'month1_acknowledge_amount', 'month2_payment_amount', 'month2_acknowledge_amount', 'month3_payment_amount', 'month3_acknowledge_amount', 'month4_payment_amount', 'month4_acknowledge_amount', 'month5_payment_amount', 'month5_acknowledge_amount', 'month6_payment_amount', 'month6_acknowledge_amount'], 'number'],
            ['month1_acknowledge', 'required', 'on' => ['1'], 'when' => function ($model) {
                    return $model->month == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '1';
            }"],
            ['month1_acknowledge_rishta_notification', 'required', 'on' => ['1'], 'when' => function ($model) {
                    return $model->month == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '1';
            }"],
            ['month1_acknowledge_recived_date', 'required', 'on' => ['1'], 'when' => function ($model) {
                    return $model->month == 1 and $model->month1_acknowledge == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '1' && $('#month1_acknowledge').val() == '1';
            }"],
            ['month1_acknowledge_amount', 'required', 'on' => ['1'], 'when' => function ($model) {
                    return $model->month == 1 and $model->month1_acknowledge == 1;
                }, 'message' => 'मानदेय राशि मिला', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '1' && $('#month1_acknowledge').val() == '1';
            }"],
            ['month1_acknowledge_not_recived_reason', 'required', 'on' => ['1'], 'when' => function ($model) {
                    return $model->month == 1 and $model->month1_acknowledge == 2;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '1' && $('#month1_acknowledge').val() == '2';
            }"],
            ['month1_acknowledge_not_recived_reason_other', 'required', 'on' => ['1'], 'when' => function ($model) {
                    return $model->month == 1 and $model->month1_acknowledge == 2;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '1' && $('#month1_acknowledge').val() == '2';
            }"],
            ['month2_acknowledge', 'required', 'on' => ['2'], 'when' => function ($model) {
                    return $model->month == 2;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '2';
            }"],
            ['month2_acknowledge_rishta_notification', 'required', 'on' => ['2'], 'when' => function ($model) {
                    return $model->month == 2;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '2';
            }"],
            ['month2_acknowledge_recived_date', 'required', 'on' => ['2'], 'when' => function ($model) {
                    return $model->month == 2 and $model->month2_acknowledge == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '2' && $('#month1_acknowledge').val() == '2';
            }"],
            ['month2_acknowledge_amount', 'required', 'on' => ['2'], 'when' => function ($model) {
                    return $model->month == 2 and $model->month2_acknowledge == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '2' && $('#month2_acknowledge').val() == '1';
            }"],
            ['month2_acknowledge_not_recived_reason', 'required', 'on' => ['2'], 'when' => function ($model) {
                    return $model->month == 2 and $model->month2_acknowledge == 2;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '2' && $('#month2_acknowledge').val() == '2';
            }"],
            ['month2_acknowledge_not_recived_reason_other', 'required', 'on' => ['2'], 'when' => function ($model) {
                    return $model->month == 2 and $model->month2_acknowledge == 2;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '1' && $('#month2_acknowledge').val() == '2';
            }"],
            ['month3_acknowledge', 'required', 'on' => ['3'], 'when' => function ($model) {
                    return $model->month == 3;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '3';
            }"],
            ['month3_acknowledge_rishta_notification', 'required', 'on' => ['3'], 'when' => function ($model) {
                    return $model->month == 3;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '3';
            }"],
            ['month3_acknowledge_recived_date', 'required', 'on' => ['3'], 'when' => function ($model) {
                    return $model->month == 3 and $model->month3_acknowledge == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '3' && $('#month3_acknowledge').val() == '1';
            }"],
            ['month3_acknowledge_amount', 'required', 'on' => ['3'], 'when' => function ($model) {
                    return $model->month == 3 and $model->month3_acknowledge == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '3' && $('#month3_acknowledge').val() == '1';
            }"],
            ['month3_acknowledge_not_recived_reason', 'required', 'on' => ['3'], 'when' => function ($model) {
                    return $model->month == 3 and $model->month3_acknowledge == 2;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '3' && $('#month3_acknowledge').val() == '2';
            }"],
            ['month3_acknowledge_not_recived_reason_other', 'required', 'on' => ['3'], 'when' => function ($model) {
                    return $model->month == 3 and $model->month3_acknowledge == 2;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '1' && $('#month3_acknowledge').val() == '2';
            }"],
            ['month4_acknowledge', 'required', 'on' => ['4'], 'when' => function ($model) {
                    return $model->month == 4;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '4';
            }"],
            ['month4_acknowledge_rishta_notification', 'required', 'on' => ['4'], 'when' => function ($model) {
                    return $model->month == 4;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '4';
            }"],
            ['month4_acknowledge_recived_date', 'required', 'on' => ['4'], 'when' => function ($model) {
                    return $model->month == 4 and $model->month4_acknowledge == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '4' && $('#month4_acknowledge').val() == '1';
            }"],
            ['month4_acknowledge_amount', 'required', 'on' => ['4'], 'when' => function ($model) {
                    return $model->month == 4 and $model->month4_acknowledge == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '4' && $('#month4_acknowledge').val() == '1';
            }"],
            ['month4_acknowledge_not_recived_reason', 'required', 'on' => ['4'], 'when' => function ($model) {
                    return $model->month == 4 and $model->month4_acknowledge == 2;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '4' && $('#month4_acknowledge').val() == '2';
            }"],
            ['month4_acknowledge_not_recived_reason_other', 'required', 'on' => ['4'], 'when' => function ($model) {
                    return $model->month == 4 and $model->month4_acknowledge == 2;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '4' && $('#month4_acknowledge').val() == '2';
            }"],
            ['month5_acknowledge', 'required', 'on' => ['5'], 'when' => function ($model) {
                    return $model->month == 5;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '5';
            }"],
            ['month5_acknowledge_rishta_notification', 'required', 'on' => ['5'], 'when' => function ($model) {
                    return $model->month == 5;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '5';
            }"],
            ['month5_acknowledge_recived_date', 'required', 'on' => ['5'], 'when' => function ($model) {
                    return $model->month == 5 and $model->month5_acknowledge == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '5' && $('#month5_acknowledge').val() == '1';
            }"],
            ['month5_acknowledge_amount', 'required', 'on' => ['5'], 'when' => function ($model) {
                    return $model->month == 5 and $model->month5_acknowledge == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '5' && $('#month5_acknowledge').val() == '1';
            }"],
            ['month5_acknowledge_not_recived_reason', 'required', 'on' => ['5'], 'when' => function ($model) {
                    return $model->month == 5 and $model->month5_acknowledge == 2;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '5' && $('#month5_acknowledge').val() == '2';
            }"],
            ['month5_acknowledge_not_recived_reason_other', 'required', 'on' => ['5'], 'when' => function ($model) {
                    return $model->month == 5 and $model->month5_acknowledge == 2;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '5' && $('#month5_acknowledge').val() == '2';
            }"],
            ['month6_acknowledge', 'required', 'on' => ['6'], 'when' => function ($model) {
                    return $model->month == 6;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '6';
            }"],
            ['month6_acknowledge_rishta_notification', 'required', 'on' => ['6'], 'when' => function ($model) {
                    return $model->month == 6;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '6';
            }"],
            ['month6_acknowledge_recived_date', 'required', 'on' => ['6'], 'when' => function ($model) {
                    return $model->month == 6 and $model->month6_acknowledge == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '6' && $('#month6_acknowledge').val() == '1';
            }"],
            ['month6_acknowledge_amount', 'required', 'on' => ['6'], 'when' => function ($model) {
                    return $model->month == 6 and $model->month6_acknowledge == 1;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '6' && $('#month6_acknowledge').val() == '1';
            }"],
            ['month6_acknowledge_not_recived_reason', 'required', 'on' => ['6'], 'when' => function ($model) {
                    return $model->month == 6 and $model->month6_acknowledge == 2;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '6' && $('#month6_acknowledge').val() == '2';
            }"],
            ['month6_acknowledge_not_recived_reason_other', 'required', 'on' => ['6'], 'when' => function ($model) {
                    return $model->month == 6 and $model->month6_acknowledge == 2;
                }, 'message' => 'चुने', 'whenClient' => "function (attribute, value) {
                  return $('#month').val() == '6' && $('#month6_acknowledge').val() == '2';
            }"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'BC Name',
            'srlm_bc_selection_user_id' => 'Bc Selection User ID',
            'district_code' => 'District',
            'block_code' => 'Block',
            'gram_panchayat_code' => 'Gram Panchayat',
            'month1' => 'Month1',
            'month1_payment_amount' => 'Month1 Payment Amount',
            'month1_payment_date' => 'Month1 Payment Date',
            'month1_payment_by' => 'Month1 Payment By',
            'month1_payment_datetime' => 'Month1 Payment Datetime',
            'month1_acknowledge' => 'Month1 Acknowledge',
            'month1_acknowledge_recived_date' => 'Month1 Acknowledge Recived Date',
            'month1_acknowledge_rishta_notification' => 'Month1 Acknowledge Rishta Notification',
            'month1_acknowledge_not_recived_reason' => 'Month1 Acknowledge Not Recived Reason',
            'month1_acknowledge_not_recived_reason_other' => 'Month1 Acknowledge Not Recived Reason Other',
            'month1_acknowledge_amount' => 'Month1 Acknowledge Amount',
            'month1_acknowledge_datetime' => 'Month1 Acknowledge Datetime',
            'month2' => 'Month2',
            'month2_payment_amount' => 'Month2 Payment Amount',
            'month2_payment_date' => 'Month2 Payment Date',
            'month2_payment_by' => 'Month2 Payment By',
            'month2_payment_datetime' => 'Month2 Payment Datetime',
            'month2_acknowledge' => 'Month2 Acknowledge',
            'month2_acknowledge_recived_date' => 'Month2 Acknowledge Recived Date',
            'month2_acknowledge_rishta_notification' => 'Month2 Acknowledge Rishta Notification',
            'month2_acknowledge_not_recived_reason' => 'Month2 Acknowledge Not Recived Reason',
            'month2_acknowledge_not_recived_reason_other' => 'Month2 Acknowledge Not Recived Reason Other',
            'month2_acknowledge_amount' => 'Month2 Acknowledge Amount',
            'month2_acknowledge_datetime' => 'Month2 Acknowledge Datetime',
            'month3' => 'Month3',
            'month3_payment_amount' => 'Month3 Payment Amount',
            'month3_payment_date' => 'Month3 Payment Date',
            'month3_payment_by' => 'Month3 Payment By',
            'month3_payment_datetime' => 'Month3 Payment Datetime',
            'month3_acknowledge' => 'Month3 Acknowledge',
            'month3_acknowledge_recived_date' => 'Month3 Acknowledge Recived Date',
            'month3_acknowledge_rishta_notification' => 'Month3 Acknowledge Rishta Notification',
            'month3_acknowledge_not_recived_reason' => 'Month3 Acknowledge Not Recived Reason',
            'month3_acknowledge_not_recived_reason_other' => 'Month3 Acknowledge Not Recived Reason Other',
            'month3_acknowledge_amount' => 'Month3 Acknowledge Amount',
            'month3_acknowledge_datetime' => 'Month3 Acknowledge Datetime',
            'month4' => 'Month4',
            'month4_payment_amount' => 'Month4 Payment Amount',
            'month4_payment_date' => 'Month4 Payment Date',
            'month4_payment_by' => 'Month4 Payment By',
            'month4_payment_datetime' => 'Month4 Payment Datetime',
            'month4_acknowledge' => 'Month4 Acknowledge',
            'month4_acknowledge_recived_date' => 'Month4 Acknowledge Recived Date',
            'month4_acknowledge_rishta_notification' => 'Month4 Acknowledge Rishta Notification',
            'month4_acknowledge_not_recived_reason' => 'Month4 Acknowledge Not Recived Reason',
            'month4_acknowledge_not_recived_reason_other' => 'Month4 Acknowledge Not Recived Reason Other',
            'month4_acknowledge_amount' => 'Month4 Acknowledge Amount',
            'month4_acknowledge_datetime' => 'Month4 Acknowledge Datetime',
            'month5' => 'Month5',
            'month5_payment_amount' => 'Month5 Payment Amount',
            'month5_payment_date' => 'Month5 Payment Date',
            'month5_payment_by' => 'Month5 Payment By',
            'month5_payment_datetime' => 'Month5 Payment Datetime',
            'month5_acknowledge' => 'Month5 Acknowledge',
            'month5_acknowledge_recived_date' => 'Month5 Acknowledge Recived Date',
            'month5_acknowledge_rishta_notification' => 'Month5 Acknowledge Rishta Notification',
            'month5_acknowledge_not_recived_reason' => 'Month5 Acknowledge Not Recived Reason',
            'month5_acknowledge_not_recived_reason_other' => 'Month5 Acknowledge Not Recived Reason Other',
            'month5_acknowledge_amount' => 'Month5 Acknowledge Amount',
            'month5_acknowledge_datetime' => 'Month5 Acknowledge Datetime',
            'month6' => 'Month6',
            'month6_payment_amount' => 'Month6 Payment Amount',
            'month6_payment_date' => 'Month6 Payment Date',
            'month6_payment_by' => 'Month6 Payment By',
            'month6_payment_datetime' => 'Month6 Payment Datetime',
            'month6_acknowledge' => 'Month6 Acknowledge',
            'month6_acknowledge_recived_date' => 'Month6 Acknowledge Recived Date',
            'month6_acknowledge_rishta_notification' => 'Month6 Acknowledge Rishta Notification',
            'month6_acknowledge_not_recived_reason' => 'Month6 Acknowledge Not Recived Reason',
            'month6_acknowledge_not_recived_reason_other' => 'Month6 Acknowledge Not Recived Reason Other',
            'month6_acknowledge_amount' => 'Month6 Acknowledge Amount',
            'month6_acknowledge_datetime' => 'Month6 Acknowledge Datetime',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function save() {
        if ($this->month == 1) {
            $this->bc_payment_model->month1_acknowledge = $this->month1_acknowledge;
            $this->bc_payment_model->month1_acknowledge_rishta_notification = $this->month1_acknowledge_rishta_notification;
            $this->bc_payment_model->month1_acknowledge_datetime = new Expression('NOW()');
            if ($this->month1_acknowledge == 1) {
                $this->bc_payment_model->month1_acknowledge_recived_date = $this->month1_acknowledge_recived_date;
                $this->bc_payment_model->month1_acknowledge_amount = $this->month1_acknowledge_amount;
            }
            if ($this->month1_acknowledge == 2) {
                $this->bc_payment_model->month1_acknowledge_not_recived_reason = $this->month1_acknowledge_not_recived_reason;
                $this->bc_payment_model->month1_acknowledge_not_recived_reason_other = $this->month1_acknowledge_not_recived_reason_other;
            }
        }
        if ($this->month == 2) {
            $this->bc_payment_model->month2_acknowledge = $this->month2_acknowledge;
            $this->bc_payment_model->month2_acknowledge_rishta_notification = $this->month2_acknowledge_rishta_notification;
            $this->bc_payment_model->month2_acknowledge_datetime = new Expression('NOW()');
            if ($this->month2_acknowledge == 1) {
                $this->bc_payment_model->month2_acknowledge_recived_date = $this->month2_acknowledge_recived_date;
                $this->bc_payment_model->month2_acknowledge_amount = $this->month2_acknowledge_amount;
            }
            if ($this->month2_acknowledge == 2) {
                $this->bc_payment_model->month2_acknowledge_not_recived_reason = $this->month2_acknowledge_not_recived_reason;
                $this->bc_payment_model->month2_acknowledge_not_recived_reason_other = $this->month2_acknowledge_not_recived_reason_other;
            }
        }
        if ($this->month == 3) {
            $this->bc_payment_model->month3_acknowledge = $this->month3_acknowledge;
            $this->bc_payment_model->month3_acknowledge_rishta_notification = $this->month3_acknowledge_rishta_notification;
            $this->bc_payment_model->month3_acknowledge_datetime = new Expression('NOW()');
            if ($this->month3_acknowledge == 1) {
                $this->bc_payment_model->month3_acknowledge_recived_date = $this->month3_acknowledge_recived_date;
                $this->bc_payment_model->month3_acknowledge_amount = $this->month3_acknowledge_amount;
            }
            if ($this->month3_acknowledge == 2) {
                $this->bc_payment_model->month3_acknowledge_not_recived_reason = $this->month3_acknowledge_not_recived_reason;
                $this->bc_payment_model->month3_acknowledge_not_recived_reason_other = $this->month3_acknowledge_not_recived_reason_other;
            }
        }
        if ($this->month == 4) {
            $this->bc_payment_model->month4_acknowledge = $this->month4_acknowledge;
            $this->bc_payment_model->month4_acknowledge_rishta_notification = $this->month4_acknowledge_rishta_notification;
            $this->bc_payment_model->month4_acknowledge_datetime = new Expression('NOW()');
            if ($this->month4_acknowledge == 1) {
                $this->bc_payment_model->month4_acknowledge_recived_date = $this->month4_acknowledge_recived_date;
                $this->bc_payment_model->month4_acknowledge_amount = $this->month4_acknowledge_amount;
            }
            if ($this->month4_acknowledge == 2) {
                $this->bc_payment_model->month4_acknowledge_not_recived_reason = $this->month4_acknowledge_not_recived_reason;
                $this->bc_payment_model->month4_acknowledge_not_recived_reason_other = $this->month4_acknowledge_not_recived_reason_other;
            }
        }
        if ($this->month == 5) {
            $this->bc_payment_model->month5_acknowledge = $this->month5_acknowledge;
            $this->bc_payment_model->month5_acknowledge_rishta_notification = $this->month5_acknowledge_rishta_notification;
            $this->bc_payment_model->month5_acknowledge_datetime = new Expression('NOW()');
            if ($this->month5_acknowledge == 1) {
                $this->bc_payment_model->month5_acknowledge_recived_date = $this->month5_acknowledge_recived_date;
                $this->bc_payment_model->month5_acknowledge_amount = $this->month5_acknowledge_amount;
            }
            if ($this->month5_acknowledge == 2) {
                $this->bc_payment_model->month5_acknowledge_not_recived_reason = $this->month5_acknowledge_not_recived_reason;
                $this->bc_payment_model->month5_acknowledge_not_recived_reason_other = $this->month5_acknowledge_not_recived_reason_other;
            }
        }
        if ($this->month == 6) {
            $this->bc_payment_model->month6_acknowledge = $this->month6_acknowledge;
            $this->bc_payment_model->month6_acknowledge_rishta_notification = $this->month6_acknowledge_rishta_notification;
            $this->bc_payment_model->month6_acknowledge_datetime = new Expression('NOW()');
            if ($this->month6_acknowledge == 1) {
                $this->bc_payment_model->month6_acknowledge_recived_date = $this->month6_acknowledge_recived_date;
                $this->bc_payment_model->month6_acknowledge_amount = $this->month6_acknowledge_amount;
            }
            if ($this->month6_acknowledge == 2) {
                $this->bc_payment_model->month6_acknowledge_not_recived_reason = $this->month6_acknowledge_not_recived_reason;
                $this->bc_payment_model->month6_acknowledge_not_recived_reason_other = $this->month6_acknowledge_not_recived_reason_other;
            }
        }
        $this->bc_payment_model->save();
        return $this->bc_payment_model;
    }

}
