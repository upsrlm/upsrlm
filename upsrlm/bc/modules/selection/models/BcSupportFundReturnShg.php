<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "bc_support_fund_return_shg".
 *
 * @property int $id
 * @property int|null $bc_application_id
 * @property int|null $srlm_bc_selection_user_id
 * @property int|null $user_id
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property float $retrun_amount
 * @property float $due_amount
 * @property float $due_after_installment
 * @property int $shg_has_received_refund
 * @property int $time_left_full_loan_repay
 * @property string|null $date
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class BcSupportFundReturnShg extends BcactiveRecord {

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
    public static function tableName() {
        return 'bc_support_fund_return_shg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id', 'srlm_bc_selection_user_id', 'user_id', 'shg_has_received_refund', 'time_left_full_loan_repay', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['retrun_amount', 'due_amount', 'due_after_installment'], 'number'],
            [['date'], 'safe'],
            [['bc_application_id', 'srlm_bc_selection_user_id', 'district_code', 'block_code', 'gram_panchayat_code'], 'integer'],
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
            'retrun_amount' => 'इस दिन/सप्ताह/माह कितना वापस चुकाया',
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

    public function getBc() {
        return $this->hasOne(SrlmBcApplication::className(), ['id' => 'bc_application_id']);
    }

    public function getBlock() {
        return $this->hasOne(\bc\models\master\MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getDistrict() {
        return $this->hasOne(\bc\models\master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getGp() {
        return $this->hasOne(\bc\models\master\MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }

}
