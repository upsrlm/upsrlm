<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "district_partner_gram_panchayat_performance".
 *
 * @property int $id
 * @property int $state_code
 * @property string $state_name
 * @property int $division_code
 * @property string $division_name
 * @property int $district_code
 * @property string $district_name
 * @property string $partner_bank_name
 * @property int|null $master_partner_bank_id
 * @property int $no_of_gp
 * @property int $certified
 * @property int $operational
 * @property float|null $avg_working_day
 * @property float|null $avg_transaction
 * @property float|null $avg_transaction_amount
 * @property float|null $avg_commission_amount
 * @property int $bc_blocked
 * @property int $vacant_gp
 * @property int $standby_gp
 * @property string|null $updated_datetime
 * @property int $status
 */
class DistrictPartnerGramPanchayatPerformance extends BcactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'district_partner_gram_panchayat_performance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['state_code', 'division_code', 'district_code', 'master_partner_bank_id', 'no_of_gp', 'certified', 'operational', 'bc_blocked', 'vacant_gp', 'standby_gp', 'status'], 'integer'],
            [['division_code', 'division_name', 'district_code', 'district_name'], 'required'],
            [['avg_working_day', 'avg_transaction', 'avg_transaction_amount', 'avg_commission_amount'], 'number'],
            [['updated_datetime'], 'safe'],
            [['state_name'], 'string', 'max' => 100],
            [['division_name', 'district_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'state_code' => 'State Code',
            'state_name' => 'State Name',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'master_partner_bank_id' => 'Master Partner Bank ID',
            'no_of_gp' => 'No Of Gp',
            'certified' => 'Certified',
            'operational' => 'Operational',
            'avg_working_day' => 'Avg Working Day',
            'avg_transaction' => 'Avg Transaction',
            'avg_transaction_amount' => 'Avg Transaction Amount',
            'avg_commission_amount' => 'Avg Commission Amount',
            'bc_blocked' => 'Bc Blocked',
            'vacant_gp' => 'Vacant Gp',
            'standby_gp' => 'Standby Gp',
            'updated_datetime' => 'Updated Datetime',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {
        $this->updated_datetime = new \yii\db\Expression('NOW()');
        return parent::beforeSave($insert);
    }
}
