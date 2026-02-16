<?php

namespace bc\models\transaction;

use Yii;

/**
 * This is the model class for table "bc_transaction_master_week".
 *
 * @property int $id
 * @property int|null $week_no
 * @property string|null $year
 * @property string $week_start_date
 * @property string $week_end_date
 * @property int|null $created_at
 * @property int $status
 */
class BcTransactionMasterWeek extends \bc\modules\transaction\models\summary\SummaryActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'bc_transaction_master_week';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['week_no', 'created_at', 'status'], 'integer'],
            [['year', 'week_start_date', 'week_end_date'], 'safe'],
            [['week_start_date', 'week_end_date'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'week_no' => 'Week No',
            'year' => 'Year',
            'week_start_date' => 'Week Start Date',
            'week_end_date' => 'Week End Date',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }

    public function getBctransaction() {
        return $this->hasMany(BcTransactionWeeklyReport::className(), ['week_id' => 'id']);
    }

}
