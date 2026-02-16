<?php

namespace bc\models;

use Yii;

/**
 * This is the model class for table "gram_panchayat_bc_active_progress_monthly".
 *
 * @property int $id
 * @property int $district_code
 * @property int $block_code
 * @property int $gram_panchayat_code
 * @property string $gram_panchayat_name
 * @property int $bc_active
 * @property int $no_of_transaction
 * @property float $transaction_amount
 * @property float $commission_amount
 * @property int|null $month_id
 */
class GramPanchayatBcActiveProgressMonthly extends BcactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gram_panchayat_bc_active_progress_monthly';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['district_code', 'block_code', 'gram_panchayat_code', 'gram_panchayat_name'], 'required'],
            [['district_code', 'block_code', 'gram_panchayat_code', 'bc_active', 'no_of_transaction', 'month_id'], 'integer'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['gram_panchayat_name'], 'string', 'max' => 132],
            [['gram_panchayat_code', 'month_id'], 'unique', 'targetAttribute' => ['gram_panchayat_code', 'month_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'bc_active' => 'Bc Active',
            'no_of_transaction' => 'No Of Transaction',
            'transaction_amount' => 'Transaction Amount',
            'commission_amount' => 'Commission Amount',
            'month_id' => 'Month ID',
        ];
    }
}
