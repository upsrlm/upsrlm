<?php

namespace common\models\dynamicdb\bc\bcsakhi;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\bc\bcsakhi\BcsakhiTransactionBcSummaryMonthly;

/**
 * BcsakhiTransactionBcSummaryMonthlySearch represents the model behind the search form of `common\models\dynamicdb\bc\bcsakhi\BcsakhiTransactionBcSummaryMonthly`.
 */
class BcsakhiTransactionBcSummaryMonthlySearch extends BcsakhiTransactionBcSummaryMonthly {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'bc_application_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'month_id', 'total_day', 'total_working_day', 'total_not_working_day', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction', 'is_new', 'month_count', 'change_day', 'change_transaction', 'change_calculate', 'bc_category', 'status'], 'integer'],
            [['bankidbc', 'transaction_start_date', 'month', 'month_start_date', 'month_end_date'], 'safe'],
            [['transaction_amount', 'commission_amount', 'change_transaction_amount', 'change_commission_amount'], 'number'],
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
        $query = BcsakhiTransactionBcSummaryMonthly::find();

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
            'month' => $this->month,
            'month_id' => $this->month_id,
            'month_start_date' => $this->month_start_date,
            'month_end_date' => $this->month_end_date,
            'total_day' => $this->total_day,
            'total_working_day' => $this->total_working_day,
            'total_not_working_day' => $this->total_not_working_day,
            'no_of_transaction' => $this->no_of_transaction,
            'no_of_actual_transaction' => $this->no_of_actual_transaction,
            'zero_transaction' => $this->zero_transaction,
            'transaction_amount' => $this->transaction_amount,
            'commission_amount' => $this->commission_amount,
            'is_new' => $this->is_new,
            'month_count' => $this->month_count,
            'change_day' => $this->change_day,
            'change_transaction' => $this->change_transaction,
            'change_transaction_amount' => $this->change_transaction_amount,
            'change_commission_amount' => $this->change_commission_amount,
            'change_calculate' => $this->change_calculate,
            'bc_category' => $this->bc_category,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'bankidbc', $this->bankidbc]);

        return $dataProvider;
    }

    public function chart($params, $user_model = null) {
        $con = \Yii::$app->dbbc;
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }

        $sql = "SELECT DATE_FORMAT(month_start_date, '%b %Y') as month,
            annotations as annotations,
           SUM(CASE WHEN bcsakhi_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END) AS operational,
           COUNT(bc_application_id) as no_of_bc,
           SUM(no_of_transaction) as no_of_transaction,
           SUM(transaction_amount) as transaction_amount,
           SUM(commission_amount) as commission_amount,
           FLOOR(COUNT(bc_application_id)/SUM(CASE WHEN bcsakhi_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END)) as avg_bc, 
           FLOOR(SUM(no_of_transaction)/COUNT(bc_application_id)) as avg_transaction_no,
           FLOOR(SUM(transaction_amount)/COUNT(bc_application_id)) as avg_txn_amount,
           FLOOR(SUM(commission_amount)/COUNT(bc_application_id)) as avg_com_amount
          FROM `bcsakhi_transaction_bc_summary_monthly` ";
        $where = " where bcsakhi_transaction_bc_summary_monthly.status >= 0";
        if ($this->master_partner_bank_id) {
            $where .= ' and bcsakhi_transaction_bc_summary_monthly.master_partner_bank_id=' . $this->master_partner_bank_id;
        }
        if ($this->district_code) {
            $where .= ' and bcsakhi_transaction_bc_summary_monthly.district_code=' . $this->district_code;
        }
        if ($this->block_code) {
            $where .= ' and bcsakhi_transaction_bc_summary_monthly.block_code=' . $this->block_code;
        }
        if ($this->gram_panchayat_code) {
            $where .= ' and bcsakhi_transaction_bc_summary_monthly.gram_panchayat_code=' . $this->gram_panchayat_code;
        }
        if ($this->bc_application_id) {
            $where .= ' and bcsakhi_transaction_bc_summary_monthly.bc_application_id=' . $this->bc_application_id;
        }

        $sql .= $where;
        $sql .= " GROUP BY month_id ORDER BY month_start_date ASC";
        $result = $con->createCommand($sql)->queryAll();
        return $result;
    }

    public function chart1($params, $user_model = null) {
        $con = \Yii::$app->dbbc;
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }

        $sql = "SELECT DATE_FORMAT(month_start_date, '%b %Y') as month,
            row_NUMBER() OVER() as month_time,
            annotations as annotations,
           SUM(CASE WHEN bcsakhi_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END) AS operational,
           COUNT(bc_application_id) as no_of_bc,
           SUM(no_of_transaction) as no_of_transaction,
           SUM(transaction_amount) as transaction_amount,
           SUM(commission_amount) as commission_amount,
           FLOOR(COUNT(bc_application_id)/SUM(CASE WHEN bcsakhi_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END)) as avg_bc, 
           FLOOR(SUM(no_of_transaction)/COUNT(bc_application_id)) as avg_transaction_no,
           FLOOR(SUM(transaction_amount)/COUNT(bc_application_id)) as avg_txn_amount,
           FLOOR(SUM(commission_amount)/COUNT(bc_application_id)) as avg_com_amount
          FROM `bcsakhi_transaction_bc_summary_monthly` ";
        $where = " where bcsakhi_transaction_bc_summary_monthly.status >= 0";
        if ($this->master_partner_bank_id) {
            $where .= ' and bcsakhi_transaction_bc_summary_monthly.master_partner_bank_id=' . $this->master_partner_bank_id;
        }
        if ($this->district_code) {
            $where .= ' and bcsakhi_transaction_bc_summary_monthly.district_code=' . $this->district_code;
        }
        if ($this->block_code) {
            $where .= ' and bcsakhi_transaction_bc_summary_monthly.block_code=' . $this->block_code;
        }
        if ($this->gram_panchayat_code) {
            $where .= ' and bcsakhi_transaction_bc_summary_monthly.gram_panchayat_code=' . $this->gram_panchayat_code;
        }
        if ($this->bc_application_id) {
            $where .= ' and bcsakhi_transaction_bc_summary_monthly.bc_application_id=' . $this->bc_application_id;
        }

        $sql .= $where;
        $sql .= " GROUP BY month_id ORDER BY month_start_date ASC";
        $result = $con->createCommand($sql)->queryAll();
        $no=0;
        $annotation_label = [];
        $annotation_data = [];
        foreach ($result as $result_data) {
            $annotation_data[] = [(int) $no, (int) $result_data['commission_amount']];
            $no++;
            if ($result_data['annotations'] == '') {
                continue;
            }
            $annotation_label[] = [
                'point' => [
                    'xAxis' => 0,
                    'yAxis' => 0,
                    'x' => (int) $no,
                    'y' => (int) $result_data['commission_amount']
                ],
                'text' => $result_data['annotations'],
                'y' => -30
            ];
            
        }


        return [$result, $annotation_label, $annotation_data];
    }
}
