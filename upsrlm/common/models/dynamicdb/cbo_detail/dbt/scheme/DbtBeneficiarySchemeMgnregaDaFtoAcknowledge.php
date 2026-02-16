<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use Yii;

/**
 * This is the model class for table "dbt_beneficiary_scheme_mgnrega_da_fto_acknowledge".
 *
 * @property int $id
 * @property int|null $mgnrega_scheme_id
 * @property int|null $dbt_beneficiary_household_id
 * @property int|null $dbt_beneficiary_scheme_mgnrega_da_id
 * @property int|null $dbt_beneficiary_scheme_mgnrega_applicant_id
 * @property int|null $dbt_beneficiary_member_id
 * @property int|null $cbo_shg_id
 * @property int|null $division_code
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property int|null $village_code
 * @property int $work_detail_day
 * @property string|null $fto_id
 * @property string|null $fto_date
 * @property float|null $fto_dbt_value
 * @property string|null $fto_uploaddate
 * @property int|null $fto_upload_by
 * @property string|null $work_start_date
 * @property string|null $work_end_date
 * @property int $laborer_wages_were_paid
 * @property float|null $total_wage_liability
 * @property float|null $wages_received_by_the_worker
 * @property string|null $date_of_receipt_of_wages
 * @property int $feed_did_you_get_your_wages_ontime
 * @property int $feed_whether_wages_were_cut_in_any_way
 * @property int $feed_bank_bc_delayed_discouraged_withdrawal_wages
 * @property int $feed_someone_wrongly_ask_money_commission
 * @property int $feed_misbehaved_gp_nrega_official_employee
 * @property int $feed_satisfied_behavior_officers_associated_nrega
 * @property int|null $fto_acknowledge_by
 * @property string|null $fto_acknowledge_datetime
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class DbtBeneficiarySchemeMgnregaDaFtoAcknowledge extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

    public function behaviors() {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'dbt_beneficiary_scheme_mgnrega_da_fto_acknowledge';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['mgnrega_scheme_id', 'dbt_beneficiary_household_id', 'dbt_beneficiary_scheme_mgnrega_da_id', 'dbt_beneficiary_scheme_mgnrega_applicant_id', 'dbt_beneficiary_member_id', 'cbo_shg_id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'work_detail_day', 'fto_upload_by', 'laborer_wages_were_paid', 'feed_did_you_get_your_wages_ontime', 'feed_whether_wages_were_cut_in_any_way', 'feed_bank_bc_delayed_discouraged_withdrawal_wages', 'feed_someone_wrongly_ask_money_commission', 'feed_misbehaved_gp_nrega_official_employee', 'feed_satisfied_behavior_officers_associated_nrega', 'fto_acknowledge_by', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['fto_date', 'fto_uploaddate', 'work_start_date', 'work_end_date', 'date_of_receipt_of_wages', 'fto_acknowledge_datetime'], 'safe'],
            [['fto_dbt_value', 'total_wage_liability', 'wages_received_by_the_worker'], 'number'],
            [['fto_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'mgnrega_scheme_id' => 'Mgnrega Scheme ID',
            'dbt_beneficiary_household_id' => 'Dbt Beneficiary Household ID',
            'dbt_beneficiary_scheme_mgnrega_da_id' => 'Dbt Beneficiary Scheme Mgnrega Da ID',
            'dbt_beneficiary_scheme_mgnrega_applicant_id' => 'Dbt Beneficiary Scheme Mgnrega Applicant ID',
            'dbt_beneficiary_member_id' => 'Dbt Beneficiary Member ID',
            'cbo_shg_id' => 'Cbo Shg ID',
            'division_code' => 'Division Code',
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'village_code' => 'Village Code',
            'work_detail_day' => 'Work Detail Day',
            'fto_id' => 'Fto ID',
            'fto_date' => 'Fto Date',
            'fto_dbt_value' => 'Fto Dbt Value',
            'fto_uploaddate' => 'Fto Uploaddate',
            'fto_upload_by' => 'Fto Upload By',
            'work_start_date' => 'Work Start Date',
            'work_end_date' => 'Work End Date',
            'laborer_wages_were_paid' => 'Laborer Wages Were Paid',
            'total_wage_liability' => 'Total Wage Liability',
            'wages_received_by_the_worker' => 'Wages Received By The Worker',
            'date_of_receipt_of_wages' => 'Date Of Receipt Of Wages',
            'feed_did_you_get_your_wages_ontime' => 'Feed Did You Get Your Wages Ontime',
            'feed_whether_wages_were_cut_in_any_way' => 'Feed Whether Wages Were Cut In Any Way',
            'feed_bank_bc_delayed_discouraged_withdrawal_wages' => 'Feed Bank Bc Delayed Discouraged Withdrawal Wages',
            'feed_someone_wrongly_ask_money_commission' => 'Feed Someone Wrongly Ask Money Commission',
            'feed_misbehaved_gp_nrega_official_employee' => 'Feed Misbehaved Gp Nrega Official Employee',
            'feed_satisfied_behavior_officers_associated_nrega' => 'Feed Satisfied Behavior Officers Associated Nrega',
            'fto_acknowledge_by' => 'Fto Acknowledge By',
            'fto_acknowledge_datetime' => 'Fto Acknowledge Datetime',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    public function getCboshg() {
        return $this->hasOne(\cbo\models\Shg::className(), ['id' => 'cbo_shg_id']);
    }

    public function getHousehold() {
        return $this->hasOne(\common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiaryHousehold::className(), ['id' => 'dbt_beneficiary_household_id']);
    }

    public function getBmember() {
        return $this->hasOne(\common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiaryMember::className(), ['id' => 'dbt_beneficiary_member_id']);
    }

    public function getMgnregascheme() {
        return $this->hasOne(DbtBeneficiarySchemeMgnrega::className(), ['id' => 'mgnrega_scheme_id']);
    }

    public function getMgnregada() {
        return $this->hasOne(DbtBeneficiarySchemeMgnrega::className(), ['id' => 'dbt_beneficiary_scheme_mgnrega_da_id']);
    }

    public function getSchemeapplicant() {
        return $this->hasOne(DbtBeneficiarySchemeMgnregaApplicant::className(), ['id' => 'dbt_beneficiary_scheme_mgnrega_applicant_id']);
    }

    public function getWagespaid() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return (isset($this->laborer_wages_were_paid) and isset($option[$this->laborer_wages_were_paid])) ? $option[$this->laborer_wages_were_paid] : '';
    }

    public function getFdiswagesontime() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return (isset($this->feed_did_you_get_your_wages_ontime) and isset($option[$this->feed_did_you_get_your_wages_ontime])) ? $option[$this->feed_did_you_get_your_wages_ontime] : '';
    }

    public function getFwwwcinanyway() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return (isset($this->feed_whether_wages_were_cut_in_any_way) and isset($option[$this->feed_whether_wages_were_cut_in_any_way])) ? $option[$this->feed_whether_wages_were_cut_in_any_way] : '';
    }

    public function getFbankbcdelayed() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return (isset($this->feed_bank_bc_delayed_discouraged_withdrawal_wages) and isset($option[$this->feed_bank_bc_delayed_discouraged_withdrawal_wages])) ? $option[$this->feed_bank_bc_delayed_discouraged_withdrawal_wages] : '';
    }

    public function getFswaskmcom() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return (isset($this->feed_someone_wrongly_ask_money_commission) and isset($option[$this->feed_someone_wrongly_ask_money_commission])) ? $option[$this->feed_someone_wrongly_ask_money_commission] : '';
    }

    public function getFmgpoe() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return (isset($this->feed_misbehaved_gp_nrega_official_employee) and isset($option[$this->feed_misbehaved_gp_nrega_official_employee])) ? $option[$this->feed_misbehaved_gp_nrega_official_employee] : '';
    }

    public function getFsboanrega() {
        $option = [1 => 'हाँ', 2 => 'नहीं'];
        return (isset($this->feed_satisfied_behavior_officers_associated_nrega) and isset($option[$this->feed_satisfied_behavior_officers_associated_nrega])) ? $option[$this->feed_satisfied_behavior_officers_associated_nrega] : '';
    }

    public function getWorkdaylabel() {
        $work_day_option = \common\models\base\GenralModel::dbt_mgnrega_work_day_option();
        if (isset($work_day_option[$this->work_detail_day])) {
            return $work_day_option[$this->work_detail_day];
        }
        return '';
    }

}
