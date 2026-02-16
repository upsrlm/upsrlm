<?php

namespace bc\modules\transaction\models\dump;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\transaction\models\dump\BcTransactionBank;

/**
 * BcTransactionBankSearch represents the model behind the search form of `bc\modules\transaction\models\dump\BcTransactionBank`.
 */
class BcTransactionBankSearch extends BcTransactionBank {

    public $bank_option = [];
    public $block_option = [];
    public $district_option = [];
    public $gp_option = [];
    public $from_date_time;
    public $to_date_time;
    public $commission;
    public $month_option;
    public $month;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['master_partner_bank_id'], 'required'],
            [['id', 'bc_application_id', 'master_partner_bank_id', 'district_code', 'block_code', 'gram_panchayat_code', 'file_id', 'dtable_id', 'ticket'], 'integer'],
            [['bankidbc', 'banktransactionid', 'transaction_datetime', 'transaction_date', 'transaction_time', 'transaction_type'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
        $q = new BcTransactionBank();
        if (isset($this->master_partner_bank_id) && $this->master_partner_bank_id != '') {
            $q = new BcTransactionBank(BcTransactionBank::$defaul_table . '_' . $this->master_partner_bank_id);
        }

        $query = $q->find();
        //$query->andWhere(['master_partner_bank_id' => $this->master_partner_bank_id]);
        if ($group != null) {
            $query->select(['*', 'COUNT(*) AS no_of_transaction']);
        }
        // add conditions that should always apply here
        if ($group != null) {
            $query->groupBy([$group]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['transaction_datetime' => SORT_DESC]],
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
            'master_partner_bank_id' => $this->master_partner_bank_id,
            'district_code' => $this->district_code,
            'block_code' => $this->block_code,
            'gram_panchayat_code' => $this->gram_panchayat_code,
            'file_id' => $this->file_id,
            'dtable_id' => $this->dtable_id,
            'transaction_datetime' => $this->transaction_datetime,
            'transaction_date' => $this->transaction_date,
            'transaction_time' => $this->transaction_time,
            'transaction_amount' => $this->transaction_amount,
            'ticket' => $this->ticket,
            'commission_amount' => $this->commission_amount,
        ]);

        $query->andFilterWhere(['like', 'bankidbc', $this->bankidbc])
                ->andFilterWhere(['like', 'banktransactionid', $this->banktransactionid])
                ->andFilterWhere(['like', 'transaction_type', $this->transaction_type]);

        return $dataProvider;
    }

}
