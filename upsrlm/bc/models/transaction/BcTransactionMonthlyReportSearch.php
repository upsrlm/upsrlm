<?php

namespace bc\models\transaction;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\transaction\BcTransactionMonthlyReport;
use common\models\master\MasterRole;

/**
 * BcTransactionMonthlyReportSearch represents the model behind the search form of `bc\models\transaction\BcTransactionMonthlyReport`.
 */
class BcTransactionMonthlyReportSearch extends BcTransactionMonthlyReport {

    public $bank_option = [];
    public $block_option = [];
    public $district_option = [];
    public $gp_option = [];
    public $numberofdays_option = [1 => '0 Days', 2 => '1-10 Days', 3 => '11-25 Days', 4 => '25 Above Days'];
    public $transaction_option = [1 => '0 Transaction', 2 => '1-29 Transaction', 3 => '30-349 Transaction', 4 => '350-999 Transaction', 5 => '1000 Above Transaction'];
    public $commission_option = [2 => '1-500 Earn', 3 => '501-2001 Earn', 4 => '2001-5000 Earn', 5 => '5000 Above Earn'];
    public $month_option;
    public $nretp;
    public $commission_earn;
    public $number_of_day_work;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'bc_application_id', 'user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'month_id', 'no_of_days', 'no_of_working_days', 'no_of_not_working_days', 'big_ticket_count', 'small_ticket_count', 'no_of_transaction', 'created_at', 'updated_at', 'status'], 'safe'],
            [['bankidbc', 'start_date', 'month', 'month_start_date', 'month_end_date'], 'safe'],
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
        $query = BcTransactionMonthlyReport::find();

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
                $query->andWhere([BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } else {
                $query->where('0=1');
            }
        }
        if ($this->month != '') {
            $query->andWhere([BcTransactionMonthlyReport::getTableSchema()->fullName . '.month' => $this->month]);
        }
        $transaction_query = [
            1 => "`no_of_transaction`=0",
            2 => "`no_of_transaction`>=1 and `no_of_transaction`<=29",
            3 => "`no_of_transaction`>=30 and `no_of_transaction`<=349",
            4 => "`no_of_transaction`>=350 and `no_of_transaction`<=999",
            5 => "`no_of_transaction`>=1000",
        ];

        if ($this->no_of_transaction) {
            $query->andWhere($transaction_query[$this->no_of_transaction]);
        }
        $commission_query = [
            1 => "`commission_amount`=0",
            2 => "`commission_amount`>=1 and `commission_amount`<=500",
            3 => "`commission_amount`>=501 and `commission_amount`<=2000",
            4 => "`commission_amount`>=2001 and `commission_amount`<=5000",
            5 => "`commission_amount`>=5001",
        ];

        if ($this->commission_earn) {
            $query->andWhere($commission_query[$this->commission_earn]);
        }
        $report_days = [
            1 => "`no_of_working_days`=0",
            2 => "`no_of_working_days`>=1 and `no_of_working_days`<=10",
            3 => "`no_of_working_days`>=11 and `no_of_working_days`<=25",
            4 => "`no_of_working_days`>=26",
        ];

        if ($this->number_of_day_work) {
            $query->andWhere($report_days[$this->number_of_day_work]);
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
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.id' => $this->id,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.user_id' => $this->user_id,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.start_date' => $this->start_date,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.month_id' => $this->month_id,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.month' => $this->month,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.month_start_date' => $this->month_start_date,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.month_end_date' => $this->month_end_date,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.no_of_days' => $this->no_of_days,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.no_of_working_days' => $this->no_of_working_days,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.no_of_not_working_days' => $this->no_of_not_working_days,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.big_ticket_count' => $this->big_ticket_count,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.small_ticket_count' => $this->small_ticket_count,
            // BcTransactionMonthlyReport::getTableSchema()->fullName . '.no_of_transaction' => $this->no_of_transaction,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.transaction_amount' => $this->transaction_amount,
            //BcTransactionMonthlyReport::getTableSchema()->fullName . '.commission_amount' => $this->commission_amount,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.created_at' => $this->created_at,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            BcTransactionMonthlyReport::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', BcTransactionMonthlyReport::getTableSchema()->fullName . '.bankidbc', $this->bankidbc]);

        return $dataProvider;
    }

    public function monthoption($params, $user_model = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = BcTransactionMonthlyReport::find();
        $query->select(['month']);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } else {
                $query->where('0=1');
            }
        }
        if ($this->district_code) {
            $query->andWhere([BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => $this->district_code]);
        }
        if ($this->master_partner_bank_id) {
            $query->andWhere([BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id]);
        }
        if ($this->block_code) {
            $query->andWhere([BcTransactionMonthlyReport::getTableSchema()->fullName . '.block_code' => $this->block_code]);
        }
        if ($this->gram_panchayat_code) {
            $query->andWhere([BcTransactionMonthlyReport::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code]);
        }
        if ($this->bc_application_id) {
            $query->andWhere([BcTransactionMonthlyReport::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id]);
        }
        $query->groupBy('month');
        $query->orderBy('month DESC');
        $models = $query->all();
        $arrays = [];
        foreach ($models as $a) {
            $arrays[$a->month] = \Yii::$app->formatter->asDatetime($a->month, "php:M-Y");
        }
        return $arrays;
    }
}
