<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeMgnregaDaFtoAcknowledge;

/**
 * DbtBeneficiarySchemeMgnregaDaFtoAcknowledgeSearch represents the model behind the search form of `common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeMgnregaDaFtoAcknowledge`.
 */
class DbtBeneficiarySchemeMgnregaDaFtoAcknowledgeSearch extends DbtBeneficiarySchemeMgnregaDaFtoAcknowledge
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'mgnrega_scheme_id', 'dbt_beneficiary_household_id', 'dbt_beneficiary_scheme_mgnrega_da_id', 'dbt_beneficiary_scheme_mgnrega_applicant_id', 'dbt_beneficiary_member_id', 'cbo_shg_id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'work_detail_day', 'fto_upload_by', 'laborer_wages_were_paid', 'feed_did_you_get_your_wages_ontime', 'feed_whether_wages_were_cut_in_any_way', 'feed_bank_bc_delayed_discouraged_withdrawal_wages', 'feed_someone_wrongly_ask_money_commission', 'feed_misbehaved_gp_nrega_official_employee', 'feed_satisfied_behavior_officers_associated_nrega', 'fto_acknowledge_by', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['fto_id', 'fto_date', 'fto_uploaddate', 'work_start_date', 'work_end_date', 'date_of_receipt_of_wages', 'fto_acknowledge_datetime'], 'safe'],
            [['fto_dbt_value', 'total_wage_liability', 'wages_received_by_the_worker'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.id' => $this->id,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.mgnrega_scheme_id' => $this->mgnrega_scheme_id,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.dbt_beneficiary_household_id' => $this->dbt_beneficiary_household_id,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.dbt_beneficiary_scheme_mgnrega_da_id' => $this->dbt_beneficiary_scheme_mgnrega_da_id,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.dbt_beneficiary_scheme_mgnrega_applicant_id' => $this->dbt_beneficiary_scheme_mgnrega_applicant_id,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.dbt_beneficiary_member_id' => $this->dbt_beneficiary_member_id,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.cbo_shg_id' => $this->cbo_shg_id,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.division_code' => $this->division_code,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.district_code' => $this->district_code,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.block_code' => $this->block_code,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.village_code' => $this->village_code,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.work_detail_day' => $this->work_detail_day,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.fto_date' => $this->fto_date,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.fto_dbt_value' => $this->fto_dbt_value,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.fto_uploaddate' => $this->fto_uploaddate,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.fto_upload_by' => $this->fto_upload_by,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.work_start_date' => $this->work_start_date,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.work_end_date' => $this->work_end_date,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.laborer_wages_were_paid' => $this->laborer_wages_were_paid,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.total_wage_liability' => $this->total_wage_liability,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.wages_received_by_the_worker' => $this->wages_received_by_the_worker,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.date_of_receipt_of_wages' => $this->date_of_receipt_of_wages,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.feed_did_you_get_your_wages_ontime' => $this->feed_did_you_get_your_wages_ontime,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.feed_whether_wages_were_cut_in_any_way' => $this->feed_whether_wages_were_cut_in_any_way,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.feed_bank_bc_delayed_discouraged_withdrawal_wages' => $this->feed_bank_bc_delayed_discouraged_withdrawal_wages,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.feed_someone_wrongly_ask_money_commission' => $this->feed_someone_wrongly_ask_money_commission,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.feed_misbehaved_gp_nrega_official_employee' => $this->feed_misbehaved_gp_nrega_official_employee,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.feed_satisfied_behavior_officers_associated_nrega' => $this->feed_satisfied_behavior_officers_associated_nrega,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.fto_acknowledge_by' => $this->fto_acknowledge_by,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.fto_acknowledge_datetime' => $this->fto_acknowledge_datetime,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.created_at' => $this->created_at,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.created_by' => $this->created_by,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            DbtBeneficiarySchemeMgnregaDaFtoAcknowledge::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'fto_id', $this->fto_id]);

        return $dataProvider;
    }
}
