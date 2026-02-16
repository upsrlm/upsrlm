<?php

namespace bc\models\transaction;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\transaction\BcTransactionOverallPartnerBank;

/**
 * BcTransactionOverallPartnerBankSearch represents the model behind the search form of `bc\models\transaction\BcTransactionOverallPartnerBank`.
 */
class BcTransactionOverallPartnerBankSearch extends BcTransactionOverallPartnerBank
{
    public $bank_option=[];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'master_partner_bank_id', 'bc_operational', 'no_of_district', 'no_of_gp', 'no_of_days', 'big_ticket_count', 'big_ticket_count_map', 'big_ticket_count_not_map', 'small_ticket_count', 'small_ticket_count_map', 'small_ticket_count_not_map', 'no_of_transaction', 'no_of_transaction_map', 'no_of_transaction_not_map', 'zero_transaction', 'zero_transaction_map', 'zero_transaction_not_map', 'created_at', 'updated_at', 'status'], 'integer'],
            [['bank_name', 'bank_short_name', 'start_date'], 'safe'],
            [['transaction_amount', 'transaction_amount_map', 'transaction_amount_not_map', 'commission_amount', 'commission_amount_map', 'commission_amount_not_map', 'avg_bc_commission_amount'], 'number'],
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
        $query = BcTransactionOverallPartnerBank::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['master_partner_bank_id' => SORT_ASC]],
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
            'master_partner_bank_id' => $this->master_partner_bank_id,
            'bc_operational' => $this->bc_operational,
            'no_of_district' => $this->no_of_district,
            'no_of_gp' => $this->no_of_gp,
            'start_date' => $this->start_date,
            'no_of_days' => $this->no_of_days,
            'big_ticket_count' => $this->big_ticket_count,
            'big_ticket_count_map' => $this->big_ticket_count_map,
            'big_ticket_count_not_map' => $this->big_ticket_count_not_map,
            'small_ticket_count' => $this->small_ticket_count,
            'small_ticket_count_map' => $this->small_ticket_count_map,
            'small_ticket_count_not_map' => $this->small_ticket_count_not_map,
            'no_of_transaction' => $this->no_of_transaction,
            'no_of_transaction_map' => $this->no_of_transaction_map,
            'no_of_transaction_not_map' => $this->no_of_transaction_not_map,
            'zero_transaction' => $this->zero_transaction,
            'zero_transaction_map' => $this->zero_transaction_map,
            'zero_transaction_not_map' => $this->zero_transaction_not_map,
            'transaction_amount' => $this->transaction_amount,
            'transaction_amount_map' => $this->transaction_amount_map,
            'transaction_amount_not_map' => $this->transaction_amount_not_map,
            'commission_amount' => $this->commission_amount,
            'commission_amount_map' => $this->commission_amount_map,
            'commission_amount_not_map' => $this->commission_amount_not_map,
            'avg_bc_commission_amount' => $this->avg_bc_commission_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'bank_short_name', $this->bank_short_name]);

        return $dataProvider;
    }
}
