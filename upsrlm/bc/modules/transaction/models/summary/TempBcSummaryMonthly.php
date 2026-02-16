<?php

namespace bc\modules\transaction\models\summary;

use Yii;

/**
 * This is the model class for table "temp_bc_summary_monthly".
 *
 * @property int $id
 * @property int|null $bc_application_id
 * @property string|null $bankidbc
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property int|null $master_partner_bank_id
 * @property string|null $district_name
 * @property string|null $block_name
 * @property string|null $gram_panchayat_name
 * @property string|null $partner_agency
 * @property string|null $bc_sakhi
 * @property string|null $transaction_start_date
 * @property int $total_day
 * @property int $total_working_day
 * @property int $total_not_working_day
 * @property int|null $no_of_transaction
 * @property int $no_of_actual_transaction
 * @property int|null $zero_transaction
 * @property float|null $transaction_amount
 * @property float|null $commission_amount
 * @property string|null $start_month_name
 * @property string|null $last_month_name
 * @property int $aspirational
 * @property int $nretp
 * @property int $no_of_transaction202401
 * @property float $transaction_amount202401
 * @property float $commission_amount202401
 * @property int $no_of_transaction202402
 * @property float $transaction_amount202402
 * @property float $commission_amount202402
 * @property int $no_of_transaction202403
 * @property float $transaction_amount202403
 * @property float $commission_amount202403
 * @property int $no_of_transaction202404
 * @property float $transaction_amount202404
 * @property float $commission_amount202404
 * @property int $no_of_transaction202405
 * @property float $transaction_amount202405
 * @property float $commission_amount202405
 * @property int $no_of_transaction202406
 * @property float $transaction_amount202406
 * @property float $commission_amount202406
 * @property int $no_of_transaction202407
 * @property float $transaction_amount202407
 * @property float $commission_amount202407
 * @property int $no_of_transaction202408
 * @property float $transaction_amount202408
 * @property float $commission_amount202408
 * @property int $status
 */
class TempBcSummaryMonthly extends SummaryActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'temp_bc_summary_monthly';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'total_day', 'total_working_day', 'total_not_working_day', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction', 'aspirational', 'nretp', 'no_of_transaction202401', 'no_of_transaction202402', 'no_of_transaction202403', 'no_of_transaction202404', 'no_of_transaction202405', 'no_of_transaction202406', 'no_of_transaction202407', 'no_of_transaction202408', 'status'], 'integer'],
            [['transaction_start_date'], 'safe'],
            [['transaction_amount', 'commission_amount', 'transaction_amount202401', 'commission_amount202401', 'transaction_amount202402', 'commission_amount202402', 'transaction_amount202403', 'commission_amount202403', 'transaction_amount202404', 'commission_amount202404', 'transaction_amount202405', 'commission_amount202405', 'transaction_amount202406', 'commission_amount202406', 'transaction_amount202407', 'commission_amount202407', 'transaction_amount202408', 'commission_amount202408'], 'number'],
            [['bankidbc'], 'string', 'max' => 20],
            [['district_name', 'block_name', 'gram_panchayat_name', 'partner_agency', 'bc_sakhi'], 'string', 'max' => 200],
            [['start_month_name', 'last_month_name'], 'string', 'max' => 14],
            [['bc_application_id'], 'unique'],
            [['transaction_amount202401'], 'default', 'value' => 0],
            [['commission_amount202401'], 'default', 'value' => 0],
            [['no_of_transaction202402'], 'default', 'value' => 0],
            [['transaction_amount202402'], 'default', 'value' => 0],
            [['commission_amount202402'], 'default', 'value' => 0],
            [['no_of_transaction202403'], 'default', 'value' => 0],
            [['transaction_amount202403'], 'default', 'value' => 0],
            [['commission_amount202403'], 'default', 'value' => 0],
            [['no_of_transaction202404'], 'default', 'value' => 0],
            [['transaction_amount202404'], 'default', 'value' => 0],
            [['commission_amount202404'], 'default', 'value' => 0],
            [['no_of_transaction202405'], 'default', 'value' => 0],
            [['transaction_amount202405'], 'default', 'value' => 0],
            [['commission_amount202405'], 'default', 'value' => 0],
            [['no_of_transaction202406'], 'default', 'value' => 0],
            [['transaction_amount202406'], 'default', 'value' => 0],
            [['commission_amount202406'], 'default', 'value' => 0],
            [['no_of_transaction202407'], 'default', 'value' => 0],
            [['transaction_amount202407'], 'default', 'value' => 0],
            [['commission_amount202407'], 'default', 'value' => 0],
            [['no_of_transaction202408'], 'default', 'value' => 0],
            [['transaction_amount202408'], 'default', 'value' => 0],
            [['commission_amount202408'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Bc Application ID',
            'bankidbc' => 'Bankidbc',
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'master_partner_bank_id' => 'Master Partner Bank ID',
            'district_name' => 'District Name',
            'block_name' => 'Block Name',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'partner_agency' => 'Partner Agency',
            'bc_sakhi' => 'Bc Sakhi',
            'transaction_start_date' => 'Transaction Start Date',
            'total_day' => 'Total Day',
            'total_working_day' => 'Total Working Day',
            'total_not_working_day' => 'Total Not Working Day',
            'no_of_transaction' => 'No Of Transaction',
            'no_of_actual_transaction' => 'No Of Actual Transaction',
            'zero_transaction' => 'Zero Transaction',
            'transaction_amount' => 'Transaction Amount',
            'commission_amount' => 'Commission Amount',
            'start_month_name' => 'Start Month Name',
            'last_month_name' => 'Last Month Name',
            'aspirational' => 'Aspirational',
            'nretp' => 'Nretp',
            'no_of_transaction202401' => 'No Of Transaction202401',
            'transaction_amount202401' => 'Transaction Amount202401',
            'commission_amount202401' => 'Commission Amount202401',
            'no_of_transaction202402' => 'No Of Transaction202402',
            'transaction_amount202402' => 'Transaction Amount202402',
            'commission_amount202402' => 'Commission Amount202402',
            'no_of_transaction202403' => 'No Of Transaction202403',
            'transaction_amount202403' => 'Transaction Amount202403',
            'commission_amount202403' => 'Commission Amount202403',
            'no_of_transaction202404' => 'No Of Transaction202404',
            'transaction_amount202404' => 'Transaction Amount202404',
            'commission_amount202404' => 'Commission Amount202404',
            'no_of_transaction202405' => 'No Of Transaction202405',
            'transaction_amount202405' => 'Transaction Amount202405',
            'commission_amount202405' => 'Commission Amount202405',
            'no_of_transaction202406' => 'No Of Transaction202406',
            'transaction_amount202406' => 'Transaction Amount202406',
            'commission_amount202406' => 'Commission Amount202406',
            'no_of_transaction202407' => 'No Of Transaction202407',
            'transaction_amount202407' => 'Transaction Amount202407',
            'commission_amount202407' => 'Commission Amount202407',
            'no_of_transaction202408' => 'No Of Transaction202408',
            'transaction_amount202408' => 'Transaction Amount202408',
            'commission_amount202408' => 'Commission Amount202408',
            'status' => 'Status',
        ];
    }

    public function getBc() {
        return $this->hasOne(\bc\modules\selection\models\SrlmBcApplication::className(), ['id' => 'bc_application_id']);
    }

    public function getPbank() {
        return $this->hasOne(MasterPartnerBank::className(), ['id' => 'master_partner_bank_id']);
    }

    public function getDistrict() {
        return $this->hasOne(MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getBlock() {
        return $this->hasOne(MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getGp() {
        return $this->hasOne(MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }
}
