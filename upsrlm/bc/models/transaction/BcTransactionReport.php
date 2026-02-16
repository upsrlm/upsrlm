<?php

namespace bc\models\transaction;

use Yii;

/**
 * This is the model class for table "bc_transaction_report".
 *
 * @property string|null $name
 * @property int $bc_application_id
 * @property int|null $user_id
 * @property int|null $bankidbc
 * @property int|null $district_code
 * @property string|null $district_name
 * @property int|null $block_code
 * @property string|null $block_name
 * @property int|null $gram_panchayat_code
 * @property string|null $gram_panchayat_name
 * @property int|null $master_partner_bank_id
 * @property string|null $master_partner_bank_name
 * @property string|null $master_partner_bank_short_name
 * @property int|null $start_month_id
 * @property string|null $start_month_name
 * @property int|null $last_month_id
 * @property string|null $last_month_name
 */
class BcTransactionReport extends \bc\models\transaction\BctransactionactiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bc_transaction_report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bc_application_id'], 'required'],
            [['bc_application_id', 'user_id', 'bankidbc', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'start_month_id', 'last_month_id', 'dropout', 'no_of_days_worked', 'no_of_days_bw_ft_lt', 'per_of_work_days', 'avg_commission_per_day', 'no_of_transaction', 'avg_transaction_per_day'], 'integer'],
            [['first_transaction_date', 'last_transaction_date'], 'safe'],
            [['name'], 'string', 'max' => 512],
            [['district_name', 'block_name', 'master_partner_bank_name'], 'string', 'max' => 50],
            [['gram_panchayat_name'], 'string', 'max' => 100],
            [['master_partner_bank_short_name'], 'string', 'max' => 10],
            [['start_month_name', 'last_month_name'], 'string', 'max' => 14],
            [['bc_application_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'bc_application_id' => 'Bc Application ID',
            'user_id' => 'User ID',
            'bankidbc' => 'Bankidbc',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'master_partner_bank_id' => 'Master Partner Bank ID',
            'master_partner_bank_name' => 'Master Partner Bank Name',
            'master_partner_bank_short_name' => 'Master Partner Bank Short Name',
            'start_month_id' => 'Start Month ID',
            'start_month_name' => 'Start Month Name',
            'last_month_id' => 'Last Month ID',
            'last_month_name' => 'Last Month Name',
        ];
    }
}
