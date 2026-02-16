<?php

namespace cbo\models;

use Yii;

/**
 * This is the model class for table "cbo_clf_funds".
 *
 * @property int $id
 * @property int|null $cbo_clf_id
 * @property int $get_funds
 * @property int|null $fund_type
 * @property string|null $date_of_receipt
 * @property float|null $instalment_if_any
 * @property float|null $total_amount_received
 * @property float|null $balance_as_on_date
 * @property int|null $received_by
 * @property int|null $cbo_vo_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class CboClfFunds extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

    const RECEIVED_BY_GOV = 1;
    const RECEIVED_BY_VO = 2;

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
        return 'cbo_clf_funds';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['cbo_clf_id', 'get_funds', 'fund_type', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['cbo_clf_id', 'get_funds', 'fund_type'], 'required'],
            [['date_of_receipt'], 'safe'],
            [['instalment_if_any', 'total_amount_received', 'balance_as_on_date'], 'number'],
            [['received_by', 'cbo_vo_id'], 'integer'],
            ['received_by', 'default', 'value' => 1],
            ['instalment_if_any', 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_clf_id' => 'Cbo Clf ID',
            'get_funds' => 'Get Funds',
            'fund_type' => 'Fund Type',
            'date_of_receipt' => 'Date of receipt of last tranche',
            'instalment_if_any' => 'Instalment If Any',
            'total_amount_received' => 'Total Amount Received',
            'balance_as_on_date' => 'Balance As On Date',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {

        if ($this->date_of_receipt != null and $this->date_of_receipt != '') {
            $this->date_of_receipt = \Yii::$app->formatter->asDatetime($this->date_of_receipt, "php:Y-m-d");
        }
        return parent::beforeSave($insert);
    }

    public function getType() {
        return $this->hasOne(master\CboMasterFundtype::className(), ['id' => 'fund_type']);
    }

    public function getClf() {
        return $this->hasOne(CboClf::className(), ['id' => 'cbo_clf_id']);
    }
    public function getVo() {
        return $this->hasOne(CboVo::className(), ['id' => 'cbo_vo_id']);
    }
    public function getReceivedby() {
        $rec = [1 => 'Goverment', 2 => 'VO'];
        return isset($rec[$this->received_by]) ? $rec[$this->received_by] : '';
    }

}
