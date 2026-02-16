<?php

namespace bc\modules\transaction\models\summary;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\transaction\models\summary\BcTrackingBcDateRangeHistory;

/**
 * BcTrackingBcDateRangeHistorySearch represents the model behind the search form of `bc\modules\transaction\models\summary\BcTrackingBcDateRangeHistory`.
 */
class BcTrackingBcDateRangeHistorySearch extends BcTrackingBcDateRangeHistory
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bc_application_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'total_day', 'total_working_day', 'total_not_working_day', 'total_no_of_transaction', 'total_no_of_actual_transaction', 'total_zero_transaction', 'start_month_id', 'last_month_id', 'days', 'working_day', 'not_working_day', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction'], 'integer'],
            [['bc_name', 'bankidbc', 'district_name', 'block_name', 'gram_panchayat_name', 'banking_partner_name', 'transaction_start_date', 'start_month_name', 'last_month_name', 'date_from', 'date_to', 'date_time'], 'safe'],
            [['total_transaction_amount', 'total_commission_amount', 'transaction_amount', 'commission_amount'], 'number'],
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
        $query = BcTrackingBcDateRangeHistory::find();

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
            'id' => $this->id,
            'bc_application_id' => $this->bc_application_id,
            'district_code' => $this->district_code,
            'block_code' => $this->block_code,
            'gram_panchayat_code' => $this->gram_panchayat_code,
            'master_partner_bank_id' => $this->master_partner_bank_id,
            'transaction_start_date' => $this->transaction_start_date,
            'total_day' => $this->total_day,
            'total_working_day' => $this->total_working_day,
            'total_not_working_day' => $this->total_not_working_day,
            'total_no_of_transaction' => $this->total_no_of_transaction,
            'total_no_of_actual_transaction' => $this->total_no_of_actual_transaction,
            'total_zero_transaction' => $this->total_zero_transaction,
            'total_transaction_amount' => $this->total_transaction_amount,
            'total_commission_amount' => $this->total_commission_amount,
            'start_month_id' => $this->start_month_id,
            'last_month_id' => $this->last_month_id,
            'days' => $this->days,
            'working_day' => $this->working_day,
            'not_working_day' => $this->not_working_day,
            'no_of_transaction' => $this->no_of_transaction,
            'no_of_actual_transaction' => $this->no_of_actual_transaction,
            'zero_transaction' => $this->zero_transaction,
            'transaction_amount' => $this->transaction_amount,
            'commission_amount' => $this->commission_amount,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'date_time' => $this->date_time,
        ]);

        $query->andFilterWhere(['like', 'bc_name', $this->bc_name])
            ->andFilterWhere(['like', 'bankidbc', $this->bankidbc])
            ->andFilterWhere(['like', 'district_name', $this->district_name])
            ->andFilterWhere(['like', 'block_name', $this->block_name])
            ->andFilterWhere(['like', 'gram_panchayat_name', $this->gram_panchayat_name])
            ->andFilterWhere(['like', 'banking_partner_name', $this->banking_partner_name])
            ->andFilterWhere(['like', 'start_month_name', $this->start_month_name])
            ->andFilterWhere(['like', 'last_month_name', $this->last_month_name]);

        return $dataProvider;
    }
}
