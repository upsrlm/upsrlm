<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "bc_honorarium_payment_history".
 *
 * @property int $id
 * @property int|null $bc_application_id
 * @property int|null $srlm_bc_selection_user_id
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property string|null $month1
 * @property float|null $month1_payment_amount
 * @property string|null $month1_payment_date
 * @property int|null $month1_payment_by
 * @property string|null $month1_payment_datetime
 * @property int $month1_acknowledge
 * @property string|null $month1_acknowledge_recived_date
 * @property int $month1_acknowledge_rishta_notification
 * @property int $month1_acknowledge_not_recived_reason
 * @property int $month1_acknowledge_not_recived_reason_other
 * @property float|null $month1_acknowledge_amount
 * @property string|null $month1_acknowledge_datetime
 * @property string|null $month2
 * @property float|null $month2_payment_amount
 * @property string|null $month2_payment_date
 * @property int|null $month2_payment_by
 * @property string|null $month2_payment_datetime
 * @property int $month2_acknowledge
 * @property string|null $month2_acknowledge_recived_date
 * @property int $month2_acknowledge_rishta_notification
 * @property int $month2_acknowledge_not_recived_reason
 * @property int $month2_acknowledge_not_recived_reason_other
 * @property float|null $month2_acknowledge_amount
 * @property string|null $month2_acknowledge_datetime
 * @property string|null $month3
 * @property float|null $month3_payment_amount
 * @property string|null $month3_payment_date
 * @property int|null $month3_payment_by
 * @property string|null $month3_payment_datetime
 * @property int $month3_acknowledge
 * @property string|null $month3_acknowledge_recived_date
 * @property int $month3_acknowledge_rishta_notification
 * @property int $month3_acknowledge_not_recived_reason
 * @property int $month3_acknowledge_not_recived_reason_other
 * @property float|null $month3_acknowledge_amount
 * @property string|null $month3_acknowledge_datetime
 * @property string|null $month4
 * @property float|null $month4_payment_amount
 * @property string|null $month4_payment_date
 * @property int|null $month4_payment_by
 * @property string|null $month4_payment_datetime
 * @property int $month4_acknowledge
 * @property string|null $month4_acknowledge_recived_date
 * @property int $month4_acknowledge_rishta_notification
 * @property int $month4_acknowledge_not_recived_reason
 * @property int $month4_acknowledge_not_recived_reason_other
 * @property float|null $month4_acknowledge_amount
 * @property string|null $month4_acknowledge_datetime
 * @property string|null $month5
 * @property float|null $month5_payment_amount
 * @property string|null $month5_payment_date
 * @property int|null $month5_payment_by
 * @property string|null $month5_payment_datetime
 * @property int $month5_acknowledge
 * @property string|null $month5_acknowledge_recived_date
 * @property int $month5_acknowledge_rishta_notification
 * @property int $month5_acknowledge_not_recived_reason
 * @property int $month5_acknowledge_not_recived_reason_other
 * @property float|null $month5_acknowledge_amount
 * @property string|null $month5_acknowledge_datetime
 * @property string|null $month6
 * @property float|null $month6_payment_amount
 * @property string|null $month6_payment_date
 * @property int|null $month6_payment_by
 * @property string|null $month6_payment_datetime
 * @property int $month6_acknowledge
 * @property string|null $month6_acknowledge_recived_date
 * @property int $month6_acknowledge_rishta_notification
 * @property int $month6_acknowledge_not_recived_reason
 * @property int $month6_acknowledge_not_recived_reason_other
 * @property float|null $month6_acknowledge_amount
 * @property string|null $month6_acknowledge_datetime
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 * @property int|null $parent_id
 */
class BcHonorariumPaymentHistory extends BcactiveRecord {

    const MONTHLY_PAYMEN_AMOUNT = 4000;

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_honorarium_payment_history';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bc_application_id', 'srlm_bc_selection_user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'month1_payment_by', 'month1_acknowledge', 'month1_acknowledge_rishta_notification', 'month1_acknowledge_not_recived_reason', 'month1_acknowledge_not_recived_reason_other', 'month2_payment_by', 'month2_acknowledge', 'month2_acknowledge_rishta_notification', 'month2_acknowledge_not_recived_reason', 'month2_acknowledge_not_recived_reason_other', 'month3_payment_by', 'month3_acknowledge', 'month3_acknowledge_rishta_notification', 'month3_acknowledge_not_recived_reason', 'month3_acknowledge_not_recived_reason_other', 'month4_payment_by', 'month4_acknowledge', 'month4_acknowledge_rishta_notification', 'month4_acknowledge_not_recived_reason', 'month4_acknowledge_not_recived_reason_other', 'month5_payment_by', 'month5_acknowledge', 'month5_acknowledge_rishta_notification', 'month5_acknowledge_not_recived_reason', 'month5_acknowledge_not_recived_reason_other', 'month6_payment_by', 'month6_acknowledge', 'month6_acknowledge_rishta_notification', 'month6_acknowledge_not_recived_reason', 'month6_acknowledge_not_recived_reason_other', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status', 'parent_id'], 'integer'],
            [['month1', 'month1_payment_date', 'month1_payment_datetime', 'month1_acknowledge_recived_date', 'month1_acknowledge_datetime', 'month2', 'month2_payment_date', 'month2_payment_datetime', 'month2_acknowledge_recived_date', 'month2_acknowledge_datetime', 'month3', 'month3_payment_date', 'month3_payment_datetime', 'month3_acknowledge_recived_date', 'month3_acknowledge_datetime', 'month4', 'month4_payment_date', 'month4_payment_datetime', 'month4_acknowledge_recived_date', 'month4_acknowledge_datetime', 'month5', 'month5_payment_date', 'month5_payment_datetime', 'month5_acknowledge_recived_date', 'month5_acknowledge_datetime', 'month6', 'month6_payment_date', 'month6_payment_datetime', 'month6_acknowledge_recived_date', 'month6_acknowledge_datetime'], 'safe'],
            [['month1_payment_amount', 'month1_acknowledge_amount', 'month2_payment_amount', 'month2_acknowledge_amount', 'month3_payment_amount', 'month3_acknowledge_amount', 'month4_payment_amount', 'month4_acknowledge_amount', 'month5_payment_amount', 'month5_acknowledge_amount', 'month6_payment_amount', 'month6_acknowledge_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Bc Application ID',
            'srlm_bc_selection_user_id' => 'Srlm Bc Selection User ID',
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
            'gram_panchayat_code' => 'Gram Panchayat Code',
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
            'parent_id' => 'Parent ID',
        ];
    }
}
