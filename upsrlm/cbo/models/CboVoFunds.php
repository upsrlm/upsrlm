<?php

namespace cbo\models;

use Yii;

/**
 * This is the model class for table "cbo_vo_funds".
 *
 * @property int $id
 * @property int|null $cbo_vo_id
 * @property int|null $fund_type
 * @property string|null $date_of_receipt
 * @property float|null $instalment_if_any
 * @property float|null $total_amount_received
 * @property float|null $balance_as_on_date
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class CboVoFunds extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

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
        return 'cbo_vo_funds';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['cbo_vo_id', 'fund_type', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['date_of_receipt'], 'safe'],
            [['instalment_if_any', 'total_amount_received', 'balance_as_on_date'], 'number'],
            [['date_of_receipt'], 'trim'],
            [['instalment_if_any'], 'trim'],
            [['total_amount_received'], 'trim'],
            [['balance_as_on_date'], 'trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_vo_id' => 'Cbo Vo ID',
            'fund_type' => 'Fund Type',
            'date_of_receipt' => 'Date of receipt of last tranche',
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

    public function beforeSave($insert) {

        if ($this->date_of_receipt != null and $this->date_of_receipt != '') {
            $this->date_of_receipt = \Yii::$app->formatter->asDatetime($this->date_of_receipt, "php:Y-m-d");
        }
        return parent::beforeSave($insert);
    }
    public function getType(){
       return $this->hasOne(master\CboMasterFundtype::className(), ['id'=>'fund_type']);
    }
    public function getVo(){
       return $this->hasOne(CboVo::className(), ['id'=>'cbo_vo_id']);
    }
}
