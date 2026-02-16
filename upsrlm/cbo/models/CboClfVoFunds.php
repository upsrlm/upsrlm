<?php

namespace cbo\models;

use Yii;

/**
 * This is the model class for table "cbo_clf_vo_funds".
 *
 * @property int $id
 * @property int $cbo_clf_id
 * @property int $cbo_vo_id
 * @property string|null $date_fund_loan_provision
 * @property int|null $fund_type
 * @property float|null $loan_funds_amount
 * @property float|null $refund_amount
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class CboClfVoFunds extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

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
                'value' => function() {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'cbo_clf_vo_funds';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['cbo_clf_id', 'cbo_vo_id'], 'required'],
            [['cbo_clf_id', 'cbo_vo_id', 'fund_type', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['date_fund_loan_provision'], 'safe'],
            [['loan_funds_amount', 'refund_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_clf_id' => 'CLF',
            'cbo_vo_id' => 'VO',
            'date_fund_loan_provision' => 'Date Fund Loan Provision',
            'fund_type' => 'Fund Type',
            'loan_funds_amount' => 'Loan Funds Amount',
            'refund_amount' => 'Refund Amount',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {
        if ($this->date_fund_loan_provision != null and $this->date_fund_loan_provision != '') {
            $this->date_fund_loan_provision = \Yii::$app->formatter->asDatetime($this->date_fund_loan_provision, "php:Y-m-d");
        }
        return parent::beforeSave($insert);
    }

    public function getClf() {
        return $this->hasOne(CboClf::className(), ['id' => 'cbo_clf_id']);
    }

    public function getVo() {
        return $this->hasOne(CboVo::className(), ['id' => 'cbo_vo_id']);
    }

    public function getType() {
        return $this->hasOne(master\CboMasterFundtype::className(), ['id' => 'fund_type']);
    }

}
