<?php

namespace bc\models\transaction;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\transaction\BcTransactionWeeklyReport;
use common\models\master\MasterRole;

/**
 * BcTransactionWeeklyReportSearch represents the model behind the search form of `bc\models\transaction\BcTransactionWeeklyReport`.
 */
class BcTransactionWeeklyReportSearch extends BcTransactionWeeklyReport {

    public $bank_option = [];
    public $block_option = [];
    public $district_option = [];
    public $gp_option = [];
    public $week_option = [];
    public $numberofdays_option = [1 => '1 Days', 2 => '2 Days', 3 => '3 Days', 4 => '4 Days', 5 => '5 Days', 6 => '6 Days', 7 => '7 Days'];
    public $transaction_option = [1 => '0 Transaction', 2 => '1-29 Transaction', 3 => '30-349 Transaction', 4 => '350-500 Transaction', 5 => '500 Above Transaction'];
    public $commission_option = [1 => 'O Earn', 2 => '1-200 Earn', 3 => '201-500 Earn', 4 => '501-1000 Earn', 5 => '1001-2000 Earn', 6 => '2001-3000 Earn', 7 => '3000 Above Earn'];
    public $nretp;
    public $commission_earn;
    public $number_of_day_work;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'bc_application_id', 'user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'week_id', 'no_of_days', 'no_of_working_days', 'no_of_not_working_days', 'big_ticket_count', 'small_ticket_count', 'no_of_transaction', 'created_at', 'updated_at', 'status'], 'safe'],
            [['bankidbc', 'start_date', 'week_start_date', 'week_end_date'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'safe'],
            [['nretp'], 'safe'],
            [['commission_earn'], 'safe'],
            [['number_of_day_work'], 'safe'],
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
        $query = BcTransactionWeeklyReport::find();

        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionWeeklyReport::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionWeeklyReport::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionWeeklyReport::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionWeeklyReport::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionWeeklyReport::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } else {
                $query->where('0=1');
            }
        }
        if ($this->week_id != '') {
            $query->andWhere([BcTransactionWeeklyReport::getTableSchema()->fullName . '.week_id' => $this->week_id]);
        }
        $commission_query = [
            1 => "`commission_amount`=0",
            2 => "`commission_amount`>=1 and `commission_amount`<=200",
            3 => "`commission_amount`>=201 and `commission_amount`<=500",
            4 => "`commission_amount`>=501 and `commission_amount`<=1000",
            5 => "`commission_amount`>=1001 and `commission_amount`<=2000",
            6 => "`commission_amount`>=2001 and `commission_amount`<=3000",
            7 => "`commission_amount`>=3000",
        ];

        if ($this->commission_earn) {
            $query->andWhere($commission_query[$this->commission_earn]);
        }
        $transaction_query = [
            1 => "`no_of_transaction`=0",
            2 => "`no_of_transaction`>=1 and `no_of_transaction`<=29",
            3 => "`no_of_transaction`>=30 and `no_of_transaction`<=349",
            4 => "`no_of_transaction`>=350 and `no_of_transaction`<=500",
            5 => "`no_of_transaction`>=500",
        ];

        if ($this->no_of_transaction) {
            $query->andWhere($transaction_query[$this->no_of_transaction]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['commission_amount' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.id' => $this->id,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.user_id' => $this->user_id,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.start_date' => $this->start_date,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.week_id' => $this->week_id,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.week_start_date' => $this->week_start_date,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.week_end_date' => $this->week_end_date,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.no_of_days' => $this->no_of_days,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.no_of_working_days' => $this->no_of_working_days,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.no_of_not_working_days' => $this->no_of_not_working_days,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.big_ticket_count' => $this->big_ticket_count,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.small_ticket_count' => $this->small_ticket_count,
            //BcTransactionWeeklyReport::getTableSchema()->fullName . '.no_of_transaction' => $this->no_of_transaction,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.transaction_amount' => $this->transaction_amount,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.commission_amount' => $this->commission_amount,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.created_at' => $this->created_at,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            BcTransactionWeeklyReport::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', BcTransactionWeeklyReport::getTableSchema()->fullName . '.bankidbc', $this->bankidbc]);

        return $dataProvider;
    }

}
