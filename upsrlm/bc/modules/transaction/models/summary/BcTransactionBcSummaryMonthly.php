<?php

namespace bc\modules\transaction\models\summary;

use Yii;

/**
 * This is the model class for table "bc_transaction_bc_summary_monthly".
 *
 * @property int $id
 * @property int|null $bc_application_id
 * @property string|null $bankidbc
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property int|null $master_partner_bank_id
 * @property string|null $transaction_start_date
 * @property string|null $month
 * @property int|null $month_id
 * @property string|null $month_start_date
 * @property string|null $month_end_date
 * @property int $total_day
 * @property int $total_working_day
 * @property int $total_not_working_day
 * @property int|null $no_of_transaction
 * @property int $no_of_actual_transaction
 * @property int|null $zero_transaction
 * @property float|null $transaction_amount
 * @property float|null $commission_amount
 * @property int $is_new
 * @property int $month_count
 * @property int $bc_category
 * @property int $change_day
 * @property int $change_transaction
 * @property float $change_transaction_amount
 * @property float $change_commission_amount
 * @property int $change_calculate
 */
class BcTransactionBcSummaryMonthly extends SummaryActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'bc_transaction_bc_summary_monthly';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['bc_application_id', 'month_id'], 'required'],
            [['bc_application_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'month_id', 'total_day', 'total_working_day', 'total_not_working_day', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction', 'is_new', 'month_count', 'bc_category'], 'integer'],
            [['transaction_start_date', 'month', 'month_start_date', 'month_end_date'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['bankidbc'], 'string', 'max' => 20],
            [['bc_application_id', 'month_id'], 'unique', 'targetAttribute' => ['bc_application_id', 'month_id']],
            [['change_day'], 'default', 'value' => 0],
            [['change_transaction'], 'default', 'value' => 0],
            [['change_transaction_amount'], 'default', 'value' => 0],
            [['change_commission_amount'], 'default', 'value' => 0],
            [['change_calculate'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'bc_application_id' => 'Name',
            'bankidbc' => 'Bankidbc',
            'district_code' => 'District',
            'block_code' => 'Block',
            'gram_panchayat_code' => 'GP',
            'master_partner_bank_id' => 'Partner Agency',
            'transaction_start_date' => 'Transaction Start Date',
            'month' => 'Month',
            'month_id' => 'Month ID',
            'month_start_date' => 'Month Start Date',
            'month_end_date' => 'Month End Date',
            'total_day' => 'Total Day',
            'total_working_day' => 'Total Working Day',
            'total_not_working_day' => 'Total Not Working Day',
            'no_of_transaction' => 'No Of Transaction',
            'no_of_actual_transaction' => 'No Of Actual Transaction',
            'zero_transaction' => 'Zero Transaction',
            'transaction_amount' => 'Txn Amount',
            'commission_amount' => 'Commission Amount',
            'is_new' => 'Is New',
            'month_count' => 'Month Count',
            'bc_category' => 'Bc Category',
        ];
    }
    public function getBc() {
        return $this->hasOne(\bc\modules\selection\models\SrlmBcApplication::className(), ['id' => 'bc_application_id']);
    }
    public function getBcsumm() {
        return $this->hasOne(BcTransactionBcSummary::className(), ['id' => 'bc_application_id']);
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
    public function getIconday() {
        $icon = '';
       
        if ($this->change_day == 0) {
            $icon = ' <i class="fal fa fa-arrow-right"></i>';
        }
        if ($this->change_day > 0) {
             $icon = ' <i class="fal fa fa-arrow-up" style="color:green"></i>';
        }
        if ($this->change_day < 0) {
             $icon = ' <i class="fal fa fa-arrow-down" style="color:red"></i>';
        }
        return $icon;
    }

    public function getIcontran() {
        $icon = '';
     
        if ($this->change_transaction == 0) {
            $icon = ' <i class="fal fa fa-arrow-right"></i>';
        }
        if ($this->change_transaction > 0) {
             $icon = ' <i class="fal fa fa-arrow-up" style="color:green"></i>';
        }
        if ($this->change_transaction < 0) {
             $icon = ' <i class="fal fa fa-arrow-down" style="color:red"></i>';
        }
        return $icon;
    }
    
    public function getIcontxnamount() {
        $icon = '';
       
        if ($this->change_transaction_amount == 0) {
            $icon = ' <i class="fal fa fa-arrow-right"></i>';
        }
        if ($this->change_transaction_amount > 0) {
             $icon = ' <i class="fal fa fa-arrow-up" style="color:green"></i>';
        }
        if ($this->change_transaction_amount < 0) {
             $icon = ' <i class="fal fa fa-arrow-down" style="color:red"></i>';
        }
        return $icon;
    }

    public function getIconcomamount() {
        $icon = '';
     
        if ($this->change_commission_amount == 0) {
            $icon = ' <i class="fal fa fa-arrow-right"></i>';
        }
        if ($this->change_commission_amount > 0) {
             $icon = ' <i class="fal fa fa-arrow-up" style="color:green"></i>';
        }
        if ($this->change_commission_amount < 0) {
             $icon = ' <i class="fal fa fa-arrow-down" style="color:red"></i>';
        }
        return $icon;
    }
    
}
