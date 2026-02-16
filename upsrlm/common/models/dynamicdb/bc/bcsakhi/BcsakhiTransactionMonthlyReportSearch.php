<?php

namespace common\models\dynamicdb\bc\bcsakhi;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\bc\bcsakhi\BcsakhiTransactionMonthlyReport;

/**
 * BcsakhiTransactionMonthlyReportSearch represents the model behind the search form of `common\models\dynamicdb\bc\bcsakhi\BcsakhiTransactionMonthlyReport`.
 */
class BcsakhiTransactionMonthlyReportSearch extends BcsakhiTransactionMonthlyReport
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'month_id', 'operational', 'no_of_bc', 'no_of_transaction', 'zero_transaction', 'created_at', 'updated_at', 'status'], 'integer'],
            [['month_start_date', 'month_end_date'], 'safe'],
            [['transaction_amount', 'commission_amount', 'avg_bc', 'avg_transaction_no', 'avg_txn_amount', 'avg_com_amount'], 'number'],
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
        $query = BcsakhiTransactionMonthlyReport::find();

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
            'month_id' => $this->month_id,
            'month_start_date' => $this->month_start_date,
            'month_end_date' => $this->month_end_date,
            'operational' => $this->operational,
            'no_of_bc' => $this->no_of_bc,
            'no_of_transaction' => $this->no_of_transaction,
            'zero_transaction' => $this->zero_transaction,
            'transaction_amount' => $this->transaction_amount,
            'commission_amount' => $this->commission_amount,
            'avg_bc' => $this->avg_bc,
            'avg_transaction_no' => $this->avg_transaction_no,
            'avg_txn_amount' => $this->avg_txn_amount,
            'avg_com_amount' => $this->avg_com_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
