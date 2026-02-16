<?php

namespace common\models\dynamicdb\bc\bcsakhi;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\bc\bcsakhi\BcsakhiTransactionBcSummary;

/**
 * BcsakhiTransactionBcSummarySearch represents the model behind the search form of `common\models\dynamicdb\bc\bcsakhi\BcsakhiTransactionBcSummary`.
 */
class BcsakhiTransactionBcSummarySearch extends BcsakhiTransactionBcSummary
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bc_application_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'total_day', 'total_working_day', 'total_not_working_day', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction', 'start_month_id', 'last_month_id', 'change_bank', 'status', 'bc_status'], 'integer'],
            [['bankidbc', 'transaction_start_date', 'start_month_name', 'last_month_name'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
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
        $query = BcsakhiTransactionBcSummary::find();

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
            'no_of_transaction' => $this->no_of_transaction,
            'no_of_actual_transaction' => $this->no_of_actual_transaction,
            'zero_transaction' => $this->zero_transaction,
            'transaction_amount' => $this->transaction_amount,
            'commission_amount' => $this->commission_amount,
            'start_month_id' => $this->start_month_id,
            'last_month_id' => $this->last_month_id,
            'change_bank' => $this->change_bank,
            'status' => $this->status,
            'bc_status' => $this->bc_status,
        ]);

        $query->andFilterWhere(['like', 'bankidbc', $this->bankidbc])
            ->andFilterWhere(['like', 'start_month_name', $this->start_month_name])
            ->andFilterWhere(['like', 'last_month_name', $this->last_month_name]);

        return $dataProvider;
    }
}
