<?php

namespace bc\models;

use Yii;
use bc\models\master\MasterGramPanchayat;
/**
 * This is the model class for table "district_bc_active_progress_monthly".
 *
 * @property int $id
 * @property int $district_code
 * @property int $no_of_gp
 * @property int $bc_active
 * @property int $no_of_transaction
 * @property float $transaction_amount
 * @property float $commission_amount
 * @property int|null $month_id
 */
class DistrictBcActiveProgressMonthly extends BcactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'district_bc_active_progress_monthly';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['district_code'], 'required'],
            [['district_code', 'no_of_gp', 'bc_active', 'no_of_transaction', 'month_id'], 'integer'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['district_code', 'month_id'], 'unique', 'targetAttribute' => ['district_code', 'month_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'district_code' => 'District Code',
            'no_of_gp' => 'No Of Gp',
            'bc_active' => 'Bc Active',
            'no_of_transaction' => 'No Of Transaction',
            'transaction_amount' => 'Transaction Amount',
            'commission_amount' => 'Commission Amount',
            'month_id' => 'Month ID',
        ];
    }

    public function beforeSave($insert) {
        if ($this->district_code != NULL) {
            $this->no_of_gp = MasterGramPanchayat::find()->select(['id'])->where(['district_code' => $this->district_code, 'status' => 1])->count();
        }

        return parent::beforeSave($insert);
    }
}
