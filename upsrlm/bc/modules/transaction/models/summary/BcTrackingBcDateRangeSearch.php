<?php

namespace bc\modules\transaction\models\summary;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\transaction\models\summary\BcTrackingBcDateRange;

/**
 * BcTrackingBcDateRangeSearch represents the model behind the search form of `bc\modules\transaction\models\summary\BcTrackingBcDateRange`.
 */
class BcTrackingBcDateRangeSearch extends BcTrackingBcDateRange
{
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bc_application_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'total_day', 'total_working_day', 'total_not_working_day', 'total_no_of_transaction', 'total_no_of_actual_transaction', 'total_zero_transaction', 'start_month_id', 'last_month_id', 'days', 'working_day', 'not_working_day', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction'], 'safe'],
            [['bc_name', 'bankidbc', 'district_name', 'block_name', 'gram_panchayat_name', 'banking_partner_name', 'transaction_start_date', 'start_month_name', 'last_month_name', 'date_from', 'date_to'], 'safe'],
            [['total_transaction_amount', 'total_commission_amount', 'transaction_amount', 'commission_amount'], 'safe'],
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
   public function search($params, $user_model = null, $pagination = true, $group = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = BcTrackingBcDateRange::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            BcTrackingBcDateRange::getTableSchema()->fullName . '.id' => $this->id,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.transaction_start_date' => $this->transaction_start_date,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.total_day' => $this->total_day,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.total_working_day' => $this->total_working_day,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.total_not_working_day' => $this->total_not_working_day,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.total_no_of_transaction' => $this->total_no_of_transaction,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.total_no_of_actual_transaction' => $this->total_no_of_actual_transaction,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.total_zero_transaction' => $this->total_zero_transaction,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.total_transaction_amount' => $this->total_transaction_amount,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.total_commission_amount' => $this->total_commission_amount,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.start_month_id' => $this->start_month_id,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.last_month_id' => $this->last_month_id,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.days' => $this->days,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.working_day' => $this->working_day,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.not_working_day' => $this->not_working_day,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.no_of_transaction' => $this->no_of_transaction,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.no_of_actual_transaction' => $this->no_of_actual_transaction,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.zero_transaction' => $this->zero_transaction,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.transaction_amount' => $this->transaction_amount,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.commission_amount' => $this->commission_amount,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.date_from' => $this->date_from,
            BcTrackingBcDateRange::getTableSchema()->fullName . '.date_to' => $this->date_to,
        ]);

        $query->andFilterWhere(['like', BcTrackingBcDateRange::getTableSchema()->fullName . '.bc_name', $this->bc_name])
            ->andFilterWhere(['like', BcTrackingBcDateRange::getTableSchema()->fullName . '.bankidbc', $this->bankidbc])
            ->andFilterWhere(['like', BcTrackingBcDateRange::getTableSchema()->fullName . '.district_name', $this->district_name])
            ->andFilterWhere(['like', BcTrackingBcDateRange::getTableSchema()->fullName . '.block_name', $this->block_name])
            ->andFilterWhere(['like', BcTrackingBcDateRange::getTableSchema()->fullName . '.gram_panchayat_name', $this->gram_panchayat_name])
            ->andFilterWhere(['like', BcTrackingBcDateRange::getTableSchema()->fullName . '.banking_partner_name', $this->banking_partner_name])
            ->andFilterWhere(['like', BcTrackingBcDateRange::getTableSchema()->fullName . '.start_month_name', $this->start_month_name])
            ->andFilterWhere(['like', BcTrackingBcDateRange::getTableSchema()->fullName . '.last_month_name', $this->last_month_name]);

        return $dataProvider;
    }
}
