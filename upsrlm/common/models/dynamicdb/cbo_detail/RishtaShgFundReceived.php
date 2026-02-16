<?php

namespace common\models\dynamicdb\cbo_detail;

use Yii;

/**
 * This is the model class for table "rishta_shg_fund_received".
 *
 * @property int $id
 * @property int|null $cbo_shg_id
 * @property int|null $fund_type
 * @property int|null $received_from
 * @property string|null $date_of_receipt
 * @property float|null $amount_received
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class RishtaShgFundReceived extends CboDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'rishta_shg_fund_received';
    }

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
    public function rules() {
        return [
            [['cbo_shg_id', 'fund_type', 'received_from', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['date_of_receipt'], 'safe'],
            [['amount_received'], 'number', 'max' => 100000000],
            [['date_of_receipt'], 'date', 'format' => 'php:Y-m-d']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_shg_id' => 'Cbo Shg ID',
            'fund_type' => 'Fund Type',
            'received_from' => 'Received From',
            'date_of_receipt' => 'Date Of Receipt',
            'amount_received' => 'Amount Received',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getShg() {
        return $this->hasOne(RishtaShg::className(), ['id' => 'cbo_shg_id']);
    }

    public function getCboshg() {
        return $this->hasOne(\cbo\models\Shg::className(), ['id' => 'cbo_shg_id']);
    }

    public function getFunddetail() {
        return $this->hasOne(master\CboMasterFundtype::className(), ['id' => 'fund_type']);
    }

    public function getReceivedfrom() {
        $list = [1 => 'UPSRLM', 2 => 'VO', 3 => 'CLF'];
        if (isset($list[$this->received_from])) {
            return $list[$this->received_from];
        }
    }

}
