<?php

namespace common\models\dynamicdb\internalcallcenter\master;

use Yii;

/**
 * This is the model class for table "cloud_tele_master_month".
 *
 * @property int $id
 * @property int|null $month_no
 * @property string|null $year
 * @property string $month_start_date
 * @property string $month_end_date
 * @property int|null $created_at
 * @property int $status
 */
class CloudTeleMasterMonth extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'cloud_tele_master_month';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['month_no', 'created_at', 'status'], 'integer'],
            [['year', 'month_start_date', 'month_end_date'], 'safe'],
            [['month_start_date', 'month_end_date'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'month_no' => 'Month No',
            'year' => 'Year',
            'month_start_date' => 'Month Start Date',
            'month_end_date' => 'Month End Date',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }

}
