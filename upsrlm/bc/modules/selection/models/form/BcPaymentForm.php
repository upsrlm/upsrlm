<?php

namespace bc\modules\selection\models\form;

use Yii;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\BcHonorariumPayment;

/**
 * BcPaymentForm is the model behind the BcHonorariumPayment
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class BcPaymentForm extends \yii\base\Model {

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
    public $month1_acknowledge_amount;
    public $month1_acknowledge_datetime;
    public $month2;
    public $month2_payment_amount;
    public $month2_payment_date;
    public $month2_payment_by;
    public $month2_payment_datetime;
    public $month2_acknowledge_amount;
    public $month2_acknowledge_datetime;
    public $month3;
    public $month3_payment_amount;
    public $month3_payment_date;
    public $month3_payment_by;
    public $month3_payment_datetime;
    public $month3_acknowledge_amount;
    public $month3_acknowledge_datetime;
    public $month4;
    public $month4_payment_amount;
    public $month4_payment_date;
    public $month4_payment_by;
    public $month4_payment_datetime;
    public $month4_acknowledge_amount;
    public $month4_acknowledge_datetime;
    public $month5;
    public $month5_payment_amount;
    public $month5_payment_date;
    public $month5_payment_by;
    public $month5_payment_datetime;
    public $month5_acknowledge_amount;
    public $month5_acknowledge_datetime;
    public $month6;
    public $month6_payment_amount;
    public $month6_payment_date;
    public $month6_payment_by;
    public $month6_payment_datetime;
    public $month6_acknowledge_amount;
    public $month6_acknowledge_datetime;
    public $month1_payment_get;
    public $month2_payment_get;
    public $month3_payment_get;
    public $month4_payment_get;
    public $month5_payment_get;
    public $month6_payment_get;
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
            if ($this->bc_payment_model->month1) {
                $this->month1 = $this->bc_payment_model->month1;
                $this->month1_payment_get = 1;
                $this->month1_payment_date = $this->bc_payment_model->month1_payment_date;
            }
            if ($this->bc_payment_model->month2) {
                $this->month2 = $this->bc_payment_model->month2;
                $this->month2_payment_get = 1;
                $this->month2_payment_date = $this->bc_payment_model->month2_payment_date;
            }
            if ($this->bc_payment_model->month3) {
                $this->month3 = $this->bc_payment_model->month3;
                $this->month3_payment_get = 1;
                $this->month3_payment_date = $this->bc_payment_model->month3_payment_date;
            }
            if ($this->bc_payment_model->month4) {
                $this->month4 = date('Y-m-01', strtotime($this->month4));
                $this->month4_payment_get = 1;
                $this->month4_payment_date = $this->bc_payment_model->month4_payment_date;
            }
            if ($this->bc_payment_model->month5) {
                $this->month5 = $this->bc_payment_model->month5;
                $this->month5_payment_get = 1;
                $this->month5_payment_date = $this->bc_payment_model->month5_payment_date;
            }
            if ($this->bc_payment_model->month6) {
                $this->month6 = $this->bc_payment_model->month6;
                $this->month6_payment_get = 1;
                $this->month6_payment_date = $this->bc_payment_model->month6_payment_date;
            }
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
            [['month1_payment_get', 'month2_payment_get', 'month3_payment_get', 'month4_payment_get', 'month5_payment_get', 'month6_payment_get'], 'safe'],
            ['month1', 'required', 'when' => function ($model) {
                    return $model->month1_payment_get == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#month1_payment_get').val() == '1';
            }"],
            [['month1'], 'date', 'format' => 'php:M-Y'],
            ['month1_payment_date', 'required', 'when' => function ($model) {
                    return $model->month1_payment_get == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#month1_payment_get').val() == '1';
            }"],
            [['month1_payment_date'], 'date', 'format' => 'php:Y-m-d'],
            ['month1', \common\validators\PaymentMonthValidator::className()],
            ['month1_payment_date', \common\validators\PaymentDateValidator::className()],
            ['month2', 'required', 'when' => function ($model) {
                    return $model->month2_payment_get == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#month2_payment_get').val() == '1';
            }"],
            ['month2_payment_date', 'required', 'when' => function ($model) {
                    return $model->month2_payment_get == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#month2_payment_get').val() == '1';
            }"],
            [['month2_payment_date'], 'date', 'format' => 'php:Y-m-d'],
            ['month2', \common\validators\PaymentMonthValidator::className()],
            [['month2'], 'date', 'format' => 'php:M-Y'],
            ['month2_payment_date', \common\validators\PaymentDateValidator::className()],
            ['month3', 'required', 'when' => function ($model) {
                    return $model->month3_payment_get == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#month3_payment_get').val() == '1';
            }"],
            ['month3_payment_date', 'required', 'when' => function ($model) {
                    return $model->month3_payment_get == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#month3_payment_get').val() == '1';
            }"],
            [['month3_payment_date'], 'date', 'format' => 'php:Y-m-d'],
            ['month3', \common\validators\PaymentMonthValidator::className()],
            [['month3'], 'date', 'format' => 'php:M-Y'],
            ['month3_payment_date', \common\validators\PaymentDateValidator::className()],
            ['month4', 'required', 'when' => function ($model) {
                    return $model->month4_payment_get == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#month4_payment_get').val() == '1';
            }"],
            ['month4_payment_date', 'required', 'when' => function ($model) {
                    return $model->month4_payment_get == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#month4_payment_get').val() == '1';
            }"],
            [['month4_payment_date'], 'date', 'format' => 'php:Y-m-d'],
            ['month4', \common\validators\PaymentMonthValidator::className()],
            [['month4'], 'date', 'format' => 'php:M-Y'],
            ['month4_payment_date', \common\validators\PaymentDateValidator::className()],
            ['month5', 'required', 'when' => function ($model) {
                    return $model->month5_payment_get == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#month5_payment_get').val() == '1';
            }"],
            ['month5_payment_date', 'required', 'when' => function ($model) {
                    return $model->month5_payment_get == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#month5_payment_get').val() == '1';
            }"],
            [['month5_payment_date'], 'date', 'format' => 'php:Y-m-d'],
            ['month5', \common\validators\PaymentMonthValidator::className()],
            [['month5'], 'date', 'format' => 'php:M-Y'],
            ['month5_payment_date', \common\validators\PaymentDateValidator::className()],
            ['month6', 'required', 'when' => function ($model) {
                    return $model->month6_payment_get == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#month6_payment_get').val() == '1';
            }"],
            ['month6_payment_date', 'required', 'when' => function ($model) {
                    return $model->month6_payment_get == '1';
                }, 'message' => 'Is required', 'whenClient' => "function (attribute, value) {
                  return $('#month6_payment_get').val() == '1';
            }"],
            [['month6_payment_date'], 'date', 'format' => 'php:Y-m-d'],
            ['month6', \common\validators\PaymentMonthValidator::className()],
            [['month6'], 'date', 'format' => 'php:M-Y'],
            ['month6_payment_date', \common\validators\PaymentDateValidator::className()],
            [['bc_application_id', 'srlm_bc_selection_user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'month1_payment_by', 'month2_payment_by', 'month3_payment_by', 'month4_payment_by', 'month5_payment_by', 'month6_payment_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['month1', 'month1_payment_date', 'month1_payment_datetime', 'month1_acknowledge_datetime', 'month2', 'month2_payment_date', 'month2_payment_datetime', 'month2_acknowledge_datetime', 'month3', 'month3_payment_date', 'month3_payment_datetime', 'month3_acknowledge_datetime', 'month4', 'month4_payment_date', 'month4_payment_datetime', 'month4_acknowledge_datetime', 'month5', 'month5_payment_date', 'month5_payment_datetime', 'month5_acknowledge_datetime', 'month6', 'month6_payment_date', 'month6_payment_datetime', 'month6_acknowledge_datetime'], 'safe'],
            [['month1_payment_amount', 'month1_acknowledge_amount', 'month2_payment_amount', 'month2_acknowledge_amount', 'month3_payment_amount', 'month3_acknowledge_amount', 'month4_payment_amount', 'month4_acknowledge_amount', 'month5_payment_amount', 'month5_acknowledge_amount', 'month6_payment_amount', 'month6_acknowledge_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Bc Name',
            'srlm_bc_selection_user_id' => 'BC Name',
            'district_code' => 'District',
            'block_code' => 'Block',
            'gram_panchayat_code' => 'Gram Panchayat',
            'month1' => 'Month1 Name',
            'month1_payment_amount' => 'Month1 Payment Amount',
            'month1_payment_date' => 'Month1 Payment Date',
            'month1_payment_by' => 'Month1 Payment By',
            'month1_payment_datetime' => 'Month1 Payment Datetime',
            'month1_acknowledge_amount' => 'Month1 Acknowledge Amount',
            'month1_acknowledge_datetime' => 'Month1 Acknowledge Datetime',
            'month2' => 'Month2 Name',
            'month2_payment_amount' => 'Month2 Payment Amount',
            'month2_payment_date' => 'Month2 Payment Date',
            'month2_payment_by' => 'Month2 Payment By',
            'month2_payment_datetime' => 'Month2 Payment Datetime',
            'month2_acknowledge_amount' => 'Month2 Acknowledge Amount',
            'month2_acknowledge_datetime' => 'Month2 Acknowledge Datetime',
            'month3' => 'Month3 Name',
            'month3_payment_amount' => 'Month3 Payment Amount',
            'month3_payment_date' => 'Month3 Payment Date',
            'month3_payment_by' => 'Month3 Payment By',
            'month3_payment_datetime' => 'Month3 Payment Datetime',
            'month3_acknowledge_amount' => 'Month3 Acknowledge Amount',
            'month3_acknowledge_datetime' => 'Month3 Acknowledge Datetime',
            'month4' => 'Month4 Name',
            'month4_payment_amount' => 'Month4 Payment Amount',
            'month4_payment_date' => 'Month4 Payment Date',
            'month4_payment_by' => 'Month4 Payment By',
            'month4_payment_datetime' => 'Month4 Payment Datetime',
            'month4_acknowledge_amount' => 'Month4 Acknowledge Amount',
            'month4_acknowledge_datetime' => 'Month4 Acknowledge Datetime',
            'month5' => 'Month5 Name',
            'month5_payment_amount' => 'Month5 Payment Amount',
            'month5_payment_date' => 'Month5 Payment Date',
            'month5_payment_by' => 'Month5 Payment By',
            'month5_payment_datetime' => 'Month5 Payment Datetime',
            'month5_acknowledge_amount' => 'Month5 Acknowledge Amount',
            'month5_acknowledge_datetime' => 'Month5 Acknowledge Datetime',
            'month6' => 'Month6 Name',
            'month6_payment_amount' => 'Month6 Payment Amount',
            'month6_payment_date' => 'Month6 Payment Date',
            'month6_payment_by' => 'Month6 Payment By',
            'month6_payment_datetime' => 'Month6 Payment Datetime',
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
        if ($this->month1_payment_get) {
            if ($this->bc_payment_model->month1_acknowledge_amount == null) {
                $this->bc_payment_model->month1 = $this->month1;
                $this->bc_payment_model->month1_payment_date = $this->month1_payment_date;
                if ($this->bc_payment_model->month1_payment_amount == null)
                    $this->bc_payment_model->month1_payment_amount = BcHonorariumPayment::MONTHLY_PAYMEN_AMOUNT;
                if ($this->bc_payment_model->month1_payment_by == null)
                    $this->bc_payment_model->month1_payment_by = \Yii::$app->user->identity->id;
                if ($this->bc_payment_model->month1_payment_datetime == null)
                    $this->bc_payment_model->month1_payment_datetime = new \yii\db\Expression('NOW()');
            }
        } else {
            if ($this->bc_payment_model->month1_acknowledge_amount == null) {
                $this->bc_payment_model->month1 = null;
                $this->bc_payment_model->month1_payment_date = null;
                $this->bc_payment_model->month1_payment_amount = null;
                $this->bc_payment_model->month1_payment_by = null;
                $this->bc_payment_model->month1_payment_datetime = null;
            }
        }
        if ($this->month2_payment_get) {
            if ($this->bc_payment_model->month2_acknowledge_amount == null) {
                $this->bc_payment_model->month2 = $this->month2;
                $this->bc_payment_model->month2_payment_date = $this->month2_payment_date;
                if ($this->bc_payment_model->month2_payment_amount == null)
                    $this->bc_payment_model->month2_payment_amount = BcHonorariumPayment::MONTHLY_PAYMEN_AMOUNT;
                if ($this->bc_payment_model->month2_payment_by == null)
                    $this->bc_payment_model->month2_payment_by = \Yii::$app->user->identity->id;
                if ($this->bc_payment_model->month2_payment_datetime == null)
                    $this->bc_payment_model->month2_payment_datetime = new \yii\db\Expression('NOW()');
            }
        } else {
            if ($this->bc_payment_model->month2_acknowledge_amount == null) {
                $this->bc_payment_model->month2 = null;
                $this->bc_payment_model->month2_payment_date = null;
                $this->bc_payment_model->month2_payment_amount = null;
                $this->bc_payment_model->month2_payment_by = null;
                $this->bc_payment_model->month2_payment_datetime = null;
            }
        }
        if ($this->month3_payment_get) {
            if ($this->bc_payment_model->month3_acknowledge_amount == null) {
                $this->bc_payment_model->month3 = $this->month3;
                $this->bc_payment_model->month3_payment_date = $this->month3_payment_date;
                if ($this->bc_payment_model->month3_payment_amount == null)
                    $this->bc_payment_model->month3_payment_amount = BcHonorariumPayment::MONTHLY_PAYMEN_AMOUNT;
                if ($this->bc_payment_model->month3_payment_by == null)
                    $this->bc_payment_model->month3_payment_by = \Yii::$app->user->identity->id;
                if ($this->bc_payment_model->month3_payment_datetime == null)
                    $this->bc_payment_model->month3_payment_datetime = new \yii\db\Expression('NOW()');
            }
        } else {
            if ($this->bc_payment_model->month3_acknowledge_amount == null) {
                $this->bc_payment_model->month3 = null;
                $this->bc_payment_model->month3_payment_date = null;
                $this->bc_payment_model->month3_payment_amount = null;
                $this->bc_payment_model->month3_payment_by = null;
                $this->bc_payment_model->month3_payment_datetime = null;
            }
        }
        if ($this->month4_payment_get) {
            if ($this->bc_payment_model->month4_acknowledge_amount == null) {
                $this->bc_payment_model->month4 = $this->month4;
                $this->bc_payment_model->month4_payment_date = $this->month4_payment_date;
                if ($this->bc_payment_model->month4_payment_amount == null)
                    $this->bc_payment_model->month4_payment_amount = BcHonorariumPayment::MONTHLY_PAYMEN_AMOUNT;
                if ($this->bc_payment_model->month4_payment_by == null)
                    $this->bc_payment_model->month4_payment_by = \Yii::$app->user->identity->id;
                if ($this->bc_payment_model->month4_payment_datetime == null)
                    $this->bc_payment_model->month4_payment_datetime = new \yii\db\Expression('NOW()');
            }
        } else {
            if ($this->bc_payment_model->month4_acknowledge_amount == null) {
                $this->bc_payment_model->month4 = null;
                $this->bc_payment_model->month4_payment_date = null;
                $this->bc_payment_model->month4_payment_amount = null;
                $this->bc_payment_model->month4_payment_by = null;
                $this->bc_payment_model->month4_payment_datetime = null;
            }
        }
        if ($this->month5_payment_get) {
            if ($this->bc_payment_model->month5_acknowledge_amount == null) {
                $this->bc_payment_model->month5 = $this->month5;
                $this->bc_payment_model->month5_payment_date = $this->month5_payment_date;
                if ($this->bc_payment_model->month5_payment_amount == null)
                    $this->bc_payment_model->month5_payment_amount = BcHonorariumPayment::MONTHLY_PAYMEN_AMOUNT;
                if ($this->bc_payment_model->month5_payment_by == null)
                    $this->bc_payment_model->month5_payment_by = \Yii::$app->user->identity->id;
                if ($this->bc_payment_model->month5_payment_datetime == null)
                    $this->bc_payment_model->month5_payment_datetime = new \yii\db\Expression('NOW()');
            }
        } else {
            if ($this->bc_payment_model->month5_acknowledge_amount == null) {
                $this->bc_payment_model->month5 = null;
                $this->bc_payment_model->month5_payment_date = null;
                $this->bc_payment_model->month5_payment_amount = null;
                $this->bc_payment_model->month5_payment_by = null;
                $this->bc_payment_model->month5_payment_datetime = null;
            }
        }
        if ($this->month6_payment_get) {
            if ($this->bc_payment_model->month6_acknowledge_amount == null) {
                $this->bc_payment_model->month6 = $this->month6;
                $this->bc_payment_model->month6_payment_date = $this->month6_payment_date;
                if ($this->bc_payment_model->month6_payment_amount == null)
                    $this->bc_payment_model->month6_payment_amount = BcHonorariumPayment::MONTHLY_PAYMEN_AMOUNT;
                if ($this->bc_payment_model->month6_payment_by == null)
                    $this->bc_payment_model->month6_payment_by = \Yii::$app->user->identity->id;
                if ($this->bc_payment_model->month6_payment_datetime == null)
                    $this->bc_payment_model->month6_payment_datetime = new \yii\db\Expression('NOW()');
            }
        } else {
            if ($this->bc_payment_model->month6_acknowledge_amount == null) {
                $this->bc_payment_model->month6 = null;
                $this->bc_payment_model->month6_payment_date = null;
                $this->bc_payment_model->month6_payment_amount = null;
                $this->bc_payment_model->month6_payment_by = null;
                $this->bc_payment_model->month6_payment_datetime = null;
            }
        }

        $this->bc_payment_model->save();
        return $this->bc_payment_model;
    }

}
