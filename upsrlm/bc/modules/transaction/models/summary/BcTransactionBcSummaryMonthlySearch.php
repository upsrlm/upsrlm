<?php

namespace bc\modules\transaction\models\summary;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly;
use common\models\master\MasterRole;

/**
 * BcTransactionBcSummaryMonthlySearch represents the model behind the search form of `bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly`.
 */
class BcTransactionBcSummaryMonthlySearch extends BcTransactionBcSummaryMonthly {

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
    public $from_month_id;
    public $to_month_id;
    public $aspirational;
    public $track;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'bc_application_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'month_id', 'total_day', 'total_working_day', 'total_not_working_day', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction', 'is_new', 'month_count', 'bc_category'], 'integer'],
            [['bankidbc', 'transaction_start_date', 'month', 'month_start_date', 'month_end_date'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['nretp', 'commission_earn', 'number_of_day_work'], 'safe'],
            [['from_month_id'], 'safe'],
            [['to_month_id'], 'safe'],
            [['aspirational'], 'safe'],
            [['change_day'], 'safe'],
            [['change_transaction'], 'safe'],
            [['change_transaction_amount'], 'safe'],
            [['change_commission_amount'], 'safe'],
            [['track'], 'safe'],
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
        $query = BcTransactionBcSummaryMonthly::find();
        $query->joinWith(['gp']);
        $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.status' => 1]);
        //$query->andWhere([BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.status' => 1]);
        if ($user_model == NULL) {
            //$query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RBI])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } else {
                $query->where('0=1');
            }
        }
        if ($this->month != '') {
            $query->andWhere([BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.month' => $this->month]);
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
            1 => "`total_working_day`=0",
            2 => "`total_working_day`>=1 and `total_working_day`<=10",
            3 => "`total_working_day`>=11 and `total_working_day`<=25",
            4 => "`total_working_day`>=26",
        ];

        if ($this->number_of_day_work) {
            $query->andWhere($report_days[$this->number_of_day_work]);
        }
        if ($this->aspirational != '') {
            $query->joinWith(['block']);
            $query->andWhere(['master_block.aspirational' => $this->aspirational]);
        }
        if ($this->change_day) {
            if ($this->change_day == 1) {
                $query->andWhere(['>', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_day', 0]);
            }
            if ($this->change_day == 2) {
                $query->andWhere(['<', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_day', 0]);
            }
            if ($this->change_day == 3) {
                $query->andWhere(['=', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_day', 0]);
            }
        }
        if ($this->change_transaction) {
            if ($this->change_transaction == 1) {
                $query->andWhere(['>', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_transaction', 0]);
            }
            if ($this->change_transaction == 2) {
                $query->andWhere(['<', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_transaction', 0]);
            }
            if ($this->change_transaction == 3) {
                $query->andWhere(['=', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_transaction', 0]);
            }
        }
        if ($this->change_transaction_amount) {
            if ($this->change_transaction_amount == 1) {
                $query->andWhere(['>', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_transaction_amount', 0]);
            }
            if ($this->change_transaction_amount == 2) {
                $query->andWhere(['<', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_transaction_amount', 0]);
            }
            if ($this->change_transaction_amount == 3) {
                $query->andWhere(['=', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_transaction_amount', 0]);
            }
        }
        if ($this->change_commission_amount) {
            if ($this->change_commission_amount == 1) {
                $query->andWhere(['>', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_commission_amount', 0]);
            }
            if ($this->change_commission_amount == 2) {
                $query->andWhere(['<', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_commission_amount', 0]);
            }
            if ($this->change_commission_amount == 3) {
                $query->andWhere(['=', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_commission_amount', 0]);
            }
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
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.id' => $this->id,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.transaction_start_date' => $this->transaction_start_date,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.month' => $this->month,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.month_id' => $this->month_id,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.month_start_date' => $this->month_start_date,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.month_end_date' => $this->month_end_date,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.total_day' => $this->total_day,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.total_working_day' => $this->total_working_day,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.total_not_working_day' => $this->total_not_working_day,
            // BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.no_of_transaction' => $this->no_of_transaction,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.no_of_actual_transaction' => $this->no_of_actual_transaction,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.zero_transaction' => $this->zero_transaction,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.transaction_amount' => $this->transaction_amount,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.commission_amount' => $this->commission_amount,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.is_new' => $this->is_new,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.month_count' => $this->month_count,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.bc_category' => $this->bc_category,
        ]);

        $query->andFilterWhere(['like', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.bankidbc', $this->bankidbc]);

        return $dataProvider;
    }

    public function chart($params, $user_model = null) {
        $con = \Yii::$app->getModule('transaction')->bctransactionsummary;
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }

        $sql = "SELECT DATE_FORMAT(month_start_date, '%b %Y') as month,
           SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END) AS operational,
           COUNT(bc_application_id) as no_of_bc,
           SUM(no_of_transaction) as no_of_transaction,
           SUM(transaction_amount) as transaction_amount,
           SUM(commission_amount) as commission_amount,
           FLOOR(COUNT(bc_application_id)/SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END)) as avg_bc, 
           FLOOR(SUM(no_of_transaction)/COUNT(bc_application_id)) as avg_transaction_no,
           FLOOR(SUM(transaction_amount)/COUNT(bc_application_id)) as avg_txn_amount,
           FLOOR(SUM(commission_amount)/COUNT(bc_application_id)) as avg_com_amount
          FROM `bc_transaction_bc_summary_monthly` ";
        $where = " where bc_transaction_bc_summary_monthly.status >= 0";
        if ($this->master_partner_bank_id) {
            $where .= ' and bc_transaction_bc_summary_monthly.master_partner_bank_id=' . $this->master_partner_bank_id;
        }
        if ($this->district_code) {
            $where .= ' and bc_transaction_bc_summary_monthly.district_code=' . $this->district_code;
        }
        if ($this->block_code) {
            $where .= ' and bc_transaction_bc_summary_monthly.block_code=' . $this->block_code;
        }
        if ($this->gram_panchayat_code) {
            $where .= ' and bc_transaction_bc_summary_monthly.gram_panchayat_code=' . $this->gram_panchayat_code;
        }
        if ($this->bc_application_id) {
            $where .= ' and bc_transaction_bc_summary_monthly.bc_application_id=' . $this->bc_application_id;
        }
        if ($this->from_month_id) {
            $where .= ' and bc_transaction_bc_summary_monthly.month_id >=' . $this->from_month_id;
        }
        if ($this->to_month_id) {
            $where .= ' and bc_transaction_bc_summary_monthly.month_id <=' . $this->to_month_id;
        }
        $sql .= $where;
        $sql .= " GROUP BY month_id ORDER BY month_start_date ASC";
        $result = $con->createCommand($sql)->queryAll();
        return $result;
    }

    public function charttracking($params, $user_model = null) {
        $con = \Yii::$app->getModule('transaction')->bctransactionsummary;
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }

        $sql = "SELECT DATE_FORMAT(month_start_date, '%b %Y') as month,
           SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END) AS operational,
           COUNT(bc_application_id) as no_of_bc,
           SUM(no_of_transaction) as no_of_transaction,
           SUM(transaction_amount) as transaction_amount,
           SUM(commission_amount) as commission_amount,
           FLOOR(COUNT(bc_application_id)/SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END)) as avg_bc, 
           FLOOR(SUM(no_of_transaction)/COUNT(bc_application_id)) as avg_transaction_no,
           FLOOR(SUM(transaction_amount)/COUNT(bc_application_id)) as avg_txn_amount,
           FLOOR(SUM(commission_amount)/COUNT(bc_application_id)) as avg_com_amount
          FROM `bc_transaction_bc_summary_monthly` ";
        $where = " where bc_transaction_bc_summary_monthly.status >= 0";
        $where .= ' and bc_transaction_bc_summary_monthly.district_code in (152, 158, 181)';
        if ($this->master_partner_bank_id) {
            $where .= ' and bc_transaction_bc_summary_monthly.master_partner_bank_id=' . $this->master_partner_bank_id;
        }
        if ($this->district_code) {
            $where .= ' and bc_transaction_bc_summary_monthly.district_code=' . $this->district_code;
        }
        if ($this->block_code) {
            $where .= ' and bc_transaction_bc_summary_monthly.block_code=' . $this->block_code;
        }
        if ($this->gram_panchayat_code) {
            $where .= ' and bc_transaction_bc_summary_monthly.gram_panchayat_code=' . $this->gram_panchayat_code;
        }
        if ($this->from_month_id) {
            $where .= ' and bc_transaction_bc_summary_monthly.month_id >=' . $this->from_month_id;
        }
        if ($this->to_month_id) {
            $where .= ' and bc_transaction_bc_summary_monthly.month_id <=' . $this->to_month_id;
        }
        $sql .= $where;
        $sql .= " GROUP BY month_id ORDER BY month_start_date ASC";
        $result = $con->createCommand($sql)->queryAll();
        return $result;
    }

    public function basicquery($query) {
        $user_model = \Yii::$app->user->identity;
        $query->andFilterWhere([
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.month' => $this->month,
            BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.month_id' => $this->month_id,
        ]);
        if ($this->aspirational != '') {
            $query->joinWith(['block']);
            $query->andWhere(['master_block.aspirational' => $this->aspirational]);
        }
        if ($this->change_day) {
            if ($this->change_day == 1) {
                $query->andWhere(['>', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_day', 0]);
            }
            if ($this->change_day == 2) {
                $query->andWhere(['<', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_day', 0]);
            }
            if ($this->change_day == 3) {
                $query->andWhere(['=', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_day', 0]);
            }
        }
        if ($this->change_transaction) {
            if ($this->change_transaction == 1) {
                $query->andWhere(['>', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_transaction', 0]);
            }
            if ($this->change_transaction == 2) {
                $query->andWhere(['<', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_transaction', 0]);
            }
            if ($this->change_transaction == 3) {
                $query->andWhere(['=', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_transaction', 0]);
            }
        }
        if ($this->change_transaction_amount) {
            if ($this->change_transaction_amount == 1) {
                $query->andWhere(['>', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_transaction_amount', 0]);
            }
            if ($this->change_transaction_amount == 2) {
                $query->andWhere(['<', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_transaction_amount', 0]);
            }
            if ($this->change_transaction_amount == 3) {
                $query->andWhere(['=', BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.change_transaction_amount', 0]);
            }
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
            1 => "`total_working_day`=0",
            2 => "`total_working_day`>=1 and `total_working_day`<=10",
            3 => "`total_working_day`>=11 and `total_working_day`<=25",
            4 => "`total_working_day`>=26",
        ];

        if ($this->number_of_day_work) {
            $query->andWhere($report_days[$this->number_of_day_work]);
        }
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RBI])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } else {
                $query->where('0=1');
            }
        }
        return $query;
    }

    public function getIconday($track = 0) {
        $query = BcTransactionBcSummaryMonthly::find();
        if ($track) {
            $query->andWhere([BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.district_code' => \Yii::$app->params['bc_tracking_disricts']]);
        }
        $this->basicquery($query);
        $query->select('change_day');
        $change_day = $query->sum('change_day');

        if ($change_day == 0) {
            $icon = '<i class="fal fa fa-arrow-right"></i>';
        }
        if ($change_day > 0) {
            $icon = '<i class="fal fa fa-arrow-up" style="color:#ffffff"></i>';
        }
        if ($change_day < 0) {
            $icon = '<i class="fal fa fa-arrow-down" style="color:red"></i>';
        }
        return $icon;
    }

    public function getIcontran($track = 0) {
        $query = BcTransactionBcSummaryMonthly::find();
        if ($track) {
            $query->andWhere([BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.district_code' => \Yii::$app->params['bc_tracking_disricts']]);
        }
        $this->basicquery($query);
        $query->select('change_transaction');
        $change_transaction = $query->sum('change_transaction');

        if ($change_transaction == 0) {
            $icon = '<i class="fal fa fa-arrow-right"></i>';
        }
        if ($change_transaction > 0) {
            $icon = '<i class="fal fa fa-arrow-up" style="color:#ffffff"></i>';
        }
        if ($change_transaction < 0) {
            $icon = '<i class="fal fa fa-arrow-down" style="color:red"></i>';
        }
        return $icon;
    }

    public function getIcontxnamount($track = 0) {
        $query = BcTransactionBcSummaryMonthly::find();
        if ($track) {
            $query->andWhere([BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.district_code' => \Yii::$app->params['bc_tracking_disricts']]);
        }
        $this->basicquery($query);
        $query->select('change_transaction_amount');
        $change_transaction_amount = $query->sum('change_transaction_amount');

        if ($change_transaction_amount == 0) {
            $icon = '<i class="fal fa fa-arrow-right"></i>';
        }
        if ($change_transaction_amount > 0) {
            $icon = '<i class="fal fa fa-arrow-up" style="color:#ffffff"></i>';
        }
        if ($change_transaction_amount < 0) {
            $icon = '<i class="fal fa fa-arrow-down" style="color:red"></i>';
        }
        return $icon;
    }

    public function getIconcomamount($track = 0) {
        $query = BcTransactionBcSummaryMonthly::find();
        if ($track) {
            $query->andWhere([BcTransactionBcSummaryMonthly::getTableSchema()->fullName . '.district_code' => \Yii::$app->params['bc_tracking_disricts']]);
        }
        $this->basicquery($query);
        $query->select('change_commission_amount');
        $change_commission_amount = $query->sum('change_commission_amount');

        if ($change_commission_amount == 0) {
            $icon = '<i class="fal fa fa-arrow-right"></i>';
        }
        if ($change_commission_amount > 0) {
            $icon = '<i class="fal fa fa-arrow-up" style="color:#ffffff"></i>';
        }
        if ($change_commission_amount < 0) {
            $icon = '<i class="fal fa fa-arrow-down" style="color:red"></i>';
        }
        return $icon;
    }

    public function graph($params) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $graph = [];

        $query = "SELECT
                      SUM(CASE WHEN bcsummary.change_day  > '0' THEN 1 ELSE 0 END) AS change_day1,
                      SUM(CASE WHEN bcsummary.change_day  < '0' THEN 1 ELSE 0 END) AS change_day2,
                      SUM(CASE WHEN bcsummary.change_day  = '0' THEN 1 ELSE 0 END) AS change_day3,
                      
                      SUM(CASE WHEN bcsummary.change_transaction  > '0' THEN 1 ELSE 0 END) AS change_transaction1,
                      SUM(CASE WHEN bcsummary.change_transaction  < '0' THEN 1 ELSE 0 END) AS change_transaction2,
                      SUM(CASE WHEN bcsummary.change_transaction  = '0' THEN 1 ELSE 0 END) AS change_transaction3,
                                      
                      SUM(CASE WHEN bcsummary.change_transaction_amount  > '0' THEN 1 ELSE 0 END) AS change_transaction_amount1,
                      SUM(CASE WHEN bcsummary.change_transaction_amount  < '0' THEN 1 ELSE 0 END) AS change_transaction_amount2,
                      SUM(CASE WHEN bcsummary.change_transaction_amount  = '0' THEN 1 ELSE 0 END) AS change_transaction_amount3,
                  
                      SUM(CASE WHEN bcsummary.change_commission_amount  > '0' THEN 1 ELSE 0 END) AS change_commission_amount1,
                      SUM(CASE WHEN bcsummary.change_commission_amount  < '0' THEN 1 ELSE 0 END) AS change_commission_amount2,
                      SUM(CASE WHEN bcsummary.change_commission_amount  = '0' THEN 1 ELSE 0 END) AS change_commission_amount3,
                     
                      COUNT(*) AS total
                      FROM  bc_transaction_bc_summary_monthly AS bcsummary 
                      join master_gram_panchayat  on master_gram_panchayat.gram_panchayat_code=bcsummary.gram_panchayat_code
                    ";
        $where = " where master_gram_panchayat.status = '1' ";
        if ($this->track == 1) {
            $where .= ' and bcsummary.district_code in (' . implode(',', \Yii::$app->params['bc_tracking_disricts']) . ')';
        }
        if ($this->district_code) {
            $where .= ' and bcsummary.district_code=' . $this->district_code;
        }
        if ($this->block_code) {
            $where .= ' and bcsummary.block_code=' . $this->block_code;
        }
        if ($this->gram_panchayat_code) {
            $where .= ' and bcsummary.gram_panchayat_code=' . $this->gram_panchayat_code;
        }
        if ($this->month_id) {
            $where .= ' and bcsummary.month_id=' . $this->month_id;
        }
        if ($this->change_day) {
            if ($this->change_day == 1) {
                $where .= ' and bcsummary.change_day > 0';
            }
            if ($this->change_day == 2) {
                $where .= ' and bcsummary.change_day < 0';
            }
            if ($this->change_day == 3) {
                $where .= ' and bcsummary.change_day=0';
            }
        }
        if ($this->change_transaction) {
            if ($this->change_transaction == 1) {
                $where .= ' and bcsummary.change_transaction > 0';
            }
            if ($this->change_transaction == 2) {
                $where .= ' and bcsummary.change_transaction < 0';
            }
            if ($this->change_transaction == 3) {
                $where .= ' and bcsummary.change_transaction=0';
            }
        }
        if ($this->change_transaction_amount) {
            if ($this->change_transaction_amount == 1) {
                $where .= ' and bcsummary.change_transaction_amount > 0';
            }
            if ($this->change_transaction_amount == 2) {
                $where .= ' and bcsummary.change_transaction_amount < 0';
            }
            if ($this->change_transaction_amount == 3) {
                $where .= ' and bcsummary.change_transaction_amount=0';
            }
        }
        if ($this->change_commission_amount) {
            if ($this->change_commission_amount == 1) {
                $where .= ' and bcsummary.change_commission_amount > 0';
            }
            if ($this->change_commission_amount == 2) {
                $where .= ' and bcsummary.change_commission_amount < 0';
            }
            if ($this->change_commission_amount == 3) {
                $where .= ' and bcsummary.change_commission_amount=0';
            }
        }



        $query .= $where;
        $graph = \Yii::$app->getModule('transaction')->bctransactionsummary->createCommand($query)->queryOne();
        return $graph;
    }

    public function chartoverallbank($params, $user_model = null) {
        $con = \Yii::$app->getModule('transaction')->bctransactionsummary;
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $array['category'] = [];
        $array['overall_no_of_bc'] = [];
        $array['overall_avg_transaction_no'] = [];
        $array['overall_avg_txn_amount'] = [];
        $array['overall_avg_com_amount'] = [];
        $array['1_no_of_bc'] = [];
        $array['1_avg_transaction_no'] = [];
        $array['1_avg_txn_amount'] = [];
        $array['1_avg_com_amount'] = [];
        $array['2_no_of_bc'] = [];
        $array['2_avg_transaction_no'] = [];
        $array['2_avg_txn_amount'] = [];
        $array['2_avg_com_amount'] = [];
        $array['3_no_of_bc'] = [];
        $array['3_avg_transaction_no'] = [];
        $array['3_avg_txn_amount'] = [];
        $array['3_avg_com_amount'] = [];
        $array['4_no_of_bc'] = [];
        $array['4_avg_transaction_no'] = [];
        $array['4_avg_txn_amount'] = [];
        $array['4_avg_com_amount'] = [];
        $array['5_no_of_bc'] = [];
        $array['5_avg_transaction_no'] = [];
        $array['5_avg_txn_amount'] = [];
        $array['5_avg_com_amount'] = [];
        $array['7_no_of_bc'] = [];
        $array['7_avg_transaction_no'] = [];
        $array['7_avg_txn_amount'] = [];
        $array['7_avg_com_amount'] = [];

        $sql = "SELECT 
           DATE_FORMAT(month_start_date, '%b %Y') as month,
           month_id as month_id,
           SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END) AS operational,
           COUNT(bc_application_id) as no_of_bc,
           SUM(no_of_transaction) as no_of_transaction,
           SUM(transaction_amount) as transaction_amount,
           SUM(commission_amount) as commission_amount,
           FLOOR(COUNT(bc_application_id)/SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END)) as avg_bc, 
           FLOOR(SUM(no_of_transaction)/COUNT(bc_application_id)) as avg_transaction_no,
           FLOOR(SUM(transaction_amount)/COUNT(bc_application_id)) as avg_txn_amount,
           FLOOR(SUM(commission_amount)/COUNT(bc_application_id)) as avg_com_amount
          FROM `bc_transaction_bc_summary_monthly` ";
        $where = " where bc_transaction_bc_summary_monthly.status >= 0";

        if ($this->district_code) {
            $where .= ' and bc_transaction_bc_summary_monthly.district_code=' . $this->district_code;
        }
        if ($this->block_code) {
            $where .= ' and bc_transaction_bc_summary_monthly.block_code=' . $this->block_code;
        }
        if ($this->gram_panchayat_code) {
            $where .= ' and bc_transaction_bc_summary_monthly.gram_panchayat_code=' . $this->gram_panchayat_code;
        }
        if ($this->bc_application_id) {
            $where .= ' and bc_transaction_bc_summary_monthly.bc_application_id=' . $this->bc_application_id;
        }
        if ($this->from_month_id) {
            $where .= ' and bc_transaction_bc_summary_monthly.month_id >=' . $this->from_month_id;
        }
        if ($this->to_month_id) {
            $where .= ' and bc_transaction_bc_summary_monthly.month_id <=' . $this->to_month_id;
        }
        $sql .= $where;
        $sql .= " GROUP BY month_id ORDER BY month_start_date ASC";
        $result = $con->createCommand($sql)->queryAll();
        foreach ($result as $responces) {
            array_push($array['category'], $responces['month']);
            array_push($array['overall_no_of_bc'], (int) $responces['no_of_bc']);
            array_push($array['overall_avg_transaction_no'], (int) $responces['avg_transaction_no']);
            array_push($array['overall_avg_txn_amount'], (int) $responces['avg_txn_amount']);
            array_push($array['overall_avg_com_amount'], (int) $responces['avg_com_amount']);
            $sql1 = "SELECT 
           DATE_FORMAT(month_start_date, '%b %Y') as month,
           month_id as month_id,
           SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END) AS operational,
           COUNT(bc_application_id) as no_of_bc,
           SUM(no_of_transaction) as no_of_transaction,
           SUM(transaction_amount) as transaction_amount,
           SUM(commission_amount) as commission_amount,
           FLOOR(COUNT(bc_application_id)/SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END)) as avg_bc, 
           FLOOR(SUM(no_of_transaction)/COUNT(bc_application_id)) as avg_transaction_no,
           FLOOR(SUM(transaction_amount)/COUNT(bc_application_id)) as avg_txn_amount,
           FLOOR(SUM(commission_amount)/COUNT(bc_application_id)) as avg_com_amount
          FROM `bc_transaction_bc_summary_monthly` ";
            $where1 = " where bc_transaction_bc_summary_monthly.status >= 0";
            $where1 .= ' and bc_transaction_bc_summary_monthly.master_partner_bank_id=1';
            $where1 .= ' and bc_transaction_bc_summary_monthly.month_id =' . $responces['month_id'];
            $sql1 .= $where1;
            $sql1 .= " GROUP BY master_partner_bank_id";
            $result1 = $con->createCommand($sql1)->queryOne();
            if (!is_null($result1)) {
                if (isset($result1['no_of_bc'])) {
                    array_push($array['1_no_of_bc'], (int) $result1['no_of_bc']);
                } else {
                    array_push($array['1_no_of_bc'], 0);
                }
                if (isset($result1['avg_transaction_no'])) {
                    array_push($array['1_avg_transaction_no'], (int) $result1['avg_transaction_no']);
                } else {
                    array_push($array['1_avg_transaction_no'], 0);
                }
                if (isset($result1['avg_txn_amount'])) {
                    array_push($array['1_avg_txn_amount'], (int) $result1['avg_txn_amount']);
                } else {
                    array_push($array['1_avg_txn_amount'], 0);
                }
                if (isset($result1['avg_com_amount'])) {
                    array_push($array['1_avg_com_amount'], (int) $result1['avg_com_amount']);
                } else {
                    array_push($array['1_avg_com_amount'], 0);
                }
            } else {
                array_push($array['1_no_of_bc'], 0);
                array_push($array['1_avg_transaction_no'], 0);
                array_push($array['1_avg_txn_amount'], 0);
                array_push($array['1_avg_com_amount'], 0);
            }
            $sql2 = "SELECT 
           DATE_FORMAT(month_start_date, '%b %Y') as month,
           month_id as month_id,
           SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END) AS operational,
           COUNT(bc_application_id) as no_of_bc,
           SUM(no_of_transaction) as no_of_transaction,
           SUM(transaction_amount) as transaction_amount,
           SUM(commission_amount) as commission_amount,
           FLOOR(COUNT(bc_application_id)/SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END)) as avg_bc, 
           FLOOR(SUM(no_of_transaction)/COUNT(bc_application_id)) as avg_transaction_no,
           FLOOR(SUM(transaction_amount)/COUNT(bc_application_id)) as avg_txn_amount,
           FLOOR(SUM(commission_amount)/COUNT(bc_application_id)) as avg_com_amount
          FROM `bc_transaction_bc_summary_monthly` ";
            $where2 = " where bc_transaction_bc_summary_monthly.status >= 0";
            $where2 .= ' and bc_transaction_bc_summary_monthly.master_partner_bank_id=2';
            $where2 .= ' and bc_transaction_bc_summary_monthly.month_id =' . $responces['month_id'];
            $sql2 .= $where2;
            $sql2 .= " GROUP BY master_partner_bank_id";
            $result2 = $con->createCommand($sql2)->queryOne();
            if (!is_null($result2)) {
                if (isset($result2['no_of_bc'])) {
                    array_push($array['2_no_of_bc'], (int) $result2['no_of_bc']);
                } else {
                    array_push($array['2_no_of_bc'], 0);
                }
                if (isset($result2['avg_transaction_no'])) {
                    array_push($array['2_avg_transaction_no'], (int) $result2['avg_transaction_no']);
                } else {
                    array_push($array['2_avg_transaction_no'], 0);
                }
                if (isset($result2['avg_txn_amount'])) {
                    array_push($array['2_avg_txn_amount'], (int) $result2['avg_txn_amount']);
                } else {
                    array_push($array['2_avg_txn_amount'], 0);
                }
                if (isset($result2['avg_com_amount'])) {
                    array_push($array['2_avg_com_amount'], (int) $result2['avg_com_amount']);
                } else {
                    array_push($array['2_avg_com_amount'], 0);
                }
            } else {
                array_push($array['2_no_of_bc'], 0);
                array_push($array['2_avg_transaction_no'], 0);
                array_push($array['2_avg_txn_amount'], 0);
                array_push($array['2_avg_com_amount'], 0);
            }
            $sql3 = "SELECT 
           DATE_FORMAT(month_start_date, '%b %Y') as month,
           month_id as month_id,
           SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END) AS operational,
           COUNT(bc_application_id) as no_of_bc,
           SUM(no_of_transaction) as no_of_transaction,
           SUM(transaction_amount) as transaction_amount,
           SUM(commission_amount) as commission_amount,
           FLOOR(COUNT(bc_application_id)/SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END)) as avg_bc, 
           FLOOR(SUM(no_of_transaction)/COUNT(bc_application_id)) as avg_transaction_no,
           FLOOR(SUM(transaction_amount)/COUNT(bc_application_id)) as avg_txn_amount,
           FLOOR(SUM(commission_amount)/COUNT(bc_application_id)) as avg_com_amount
          FROM `bc_transaction_bc_summary_monthly` ";
            $where3 = " where bc_transaction_bc_summary_monthly.status >= 0";
            $where3 .= ' and bc_transaction_bc_summary_monthly.master_partner_bank_id=3';
            $where3 .= ' and bc_transaction_bc_summary_monthly.month_id =' . $responces['month_id'];
            $sql3 .= $where1;
            $sql3 .= " GROUP BY master_partner_bank_id";
            $result3 = $con->createCommand($sql3)->queryOne();
            if (!is_null($result3)) {
                if (isset($result3['no_of_bc'])) {
                    array_push($array['3_no_of_bc'], (int) $result3['no_of_bc']);
                } else {
                    array_push($array['3_no_of_bc'], 0);
                }
                if (isset($result3['avg_transaction_no'])) {
                    array_push($array['3_avg_transaction_no'], (int) $result3['avg_transaction_no']);
                } else {
                    array_push($array['3_avg_transaction_no'], 0);
                }
                if (isset($result3['avg_txn_amount'])) {
                    array_push($array['3_avg_txn_amount'], (int) $result3['avg_txn_amount']);
                } else {
                    array_push($array['3_avg_txn_amount'], 0);
                }
                if (isset($result3['avg_com_amount'])) {
                    array_push($array['3_avg_com_amount'], (int) $result3['avg_com_amount']);
                } else {
                    array_push($array['3_avg_com_amount'], 0);
                }
            } else {
                array_push($array['3_no_of_bc'], 0);
                array_push($array['3_avg_transaction_no'], 0);
                array_push($array['3_avg_txn_amount'], 0);
                array_push($array['3_avg_com_amount'], 0);
            }
            $sql4 = "SELECT 
           DATE_FORMAT(month_start_date, '%b %Y') as month,
           month_id as month_id,
           SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END) AS operational,
           COUNT(bc_application_id) as no_of_bc,
           SUM(no_of_transaction) as no_of_transaction,
           SUM(transaction_amount) as transaction_amount,
           SUM(commission_amount) as commission_amount,
           FLOOR(COUNT(bc_application_id)/SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END)) as avg_bc, 
           FLOOR(SUM(no_of_transaction)/COUNT(bc_application_id)) as avg_transaction_no,
           FLOOR(SUM(transaction_amount)/COUNT(bc_application_id)) as avg_txn_amount,
           FLOOR(SUM(commission_amount)/COUNT(bc_application_id)) as avg_com_amount
          FROM `bc_transaction_bc_summary_monthly` ";
            $where4 = " where bc_transaction_bc_summary_monthly.status >= 0";
            $where4 .= ' and bc_transaction_bc_summary_monthly.master_partner_bank_id=4';
            $where4 .= ' and bc_transaction_bc_summary_monthly.month_id =' . $responces['month_id'];
            $sql4 .= $where4;
            $sql4 .= " GROUP BY master_partner_bank_id";
            $result4 = $con->createCommand($sql4)->queryOne();
            if (!is_null($result4)) {
                if (isset($result4['no_of_bc'])) {
                    array_push($array['4_no_of_bc'], (int) $result4['no_of_bc']);
                } else {
                    array_push($array['4_no_of_bc'], 0);
                }
                if (isset($result4['avg_transaction_no'])) {
                    array_push($array['4_avg_transaction_no'], (int) $result4['avg_transaction_no']);
                } else {
                    array_push($array['4_avg_transaction_no'], 0);
                }
                if (isset($result4['avg_txn_amount'])) {
                    array_push($array['4_avg_txn_amount'], (int) $result4['avg_txn_amount']);
                } else {
                    array_push($array['4_avg_txn_amount'], 0);
                }
                if (isset($result4['avg_com_amount'])) {
                    array_push($array['4_avg_com_amount'], (int) $result4['avg_com_amount']);
                } else {
                    array_push($array['4_avg_com_amount'], 0);
                }
            } else {
                array_push($array['4_no_of_bc'], 0);
                array_push($array['4_avg_transaction_no'], 0);
                array_push($array['4_avg_txn_amount'], 0);
                array_push($array['4_avg_com_amount'], 0);
            }
            $sql5 = "SELECT 
           DATE_FORMAT(month_start_date, '%b %Y') as month,
           month_id as month_id,
           SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END) AS operational,
           COUNT(bc_application_id) as no_of_bc,
           SUM(no_of_transaction) as no_of_transaction,
           SUM(transaction_amount) as transaction_amount,
           SUM(commission_amount) as commission_amount,
           FLOOR(COUNT(bc_application_id)/SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END)) as avg_bc, 
           FLOOR(SUM(no_of_transaction)/COUNT(bc_application_id)) as avg_transaction_no,
           FLOOR(SUM(transaction_amount)/COUNT(bc_application_id)) as avg_txn_amount,
           FLOOR(SUM(commission_amount)/COUNT(bc_application_id)) as avg_com_amount
          FROM `bc_transaction_bc_summary_monthly` ";
            $where5 = " where bc_transaction_bc_summary_monthly.status >= 0";
            $where5 .= ' and bc_transaction_bc_summary_monthly.master_partner_bank_id=5';
            $where5 .= ' and bc_transaction_bc_summary_monthly.month_id =' . $responces['month_id'];
            $sql5 .= $where5;
            $sql5 .= " GROUP BY master_partner_bank_id";
            $result5 = $con->createCommand($sql5)->queryOne();
            if (!is_null($result5)) {
                if (isset($result5['no_of_bc'])) {
                    array_push($array['5_no_of_bc'], (int) $result5['no_of_bc']);
                } else {
                    array_push($array['5_no_of_bc'], 0);
                }
                if (isset($result5['avg_transaction_no'])) {
                    array_push($array['5_avg_transaction_no'], (int) $result5['avg_transaction_no']);
                } else {
                    array_push($array['5_avg_transaction_no'], 0);
                }
                if (isset($result5['avg_txn_amount'])) {
                    array_push($array['5_avg_txn_amount'], (int) $result5['avg_txn_amount']);
                } else {
                    array_push($array['5_avg_txn_amount'], 0);
                }
                if (isset($result5['avg_com_amount'])) {
                    array_push($array['5_avg_com_amount'], (int) $result5['avg_com_amount']);
                } else {
                    array_push($array['5_avg_com_amount'], 0);
                }
            } else {
                array_push($array['5_no_of_bc'], 0);
                array_push($array['5_avg_transaction_no'], 0);
                array_push($array['5_avg_txn_amount'], 0);
                array_push($array['5_avg_com_amount'], 0);
            }
            $sql7 = "SELECT 
           DATE_FORMAT(month_start_date, '%b %Y') as month,
           month_id as month_id,
           SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END) AS operational,
           COUNT(bc_application_id) as no_of_bc,
           SUM(no_of_transaction) as no_of_transaction,
           SUM(transaction_amount) as transaction_amount,
           SUM(commission_amount) as commission_amount,
           FLOOR(COUNT(bc_application_id)/SUM(CASE WHEN bc_transaction_bc_summary_monthly.month_count=1 THEN 1 ELSE 0 END)) as avg_bc, 
           FLOOR(SUM(no_of_transaction)/COUNT(bc_application_id)) as avg_transaction_no,
           FLOOR(SUM(transaction_amount)/COUNT(bc_application_id)) as avg_txn_amount,
           FLOOR(SUM(commission_amount)/COUNT(bc_application_id)) as avg_com_amount
          FROM `bc_transaction_bc_summary_monthly` ";
            $where7 = " where bc_transaction_bc_summary_monthly.status >= 0";
            $where7 .= ' and bc_transaction_bc_summary_monthly.master_partner_bank_id=7';
            $where7 .= ' and bc_transaction_bc_summary_monthly.month_id =' . $responces['month_id'];
            $sql7 .= $where7;
            $sql7 .= " GROUP BY master_partner_bank_id";
            $result7 = $con->createCommand($sql7)->queryOne();
            if (!is_null($result7)) {
                if (isset($result7['no_of_bc'])) {
                    array_push($array['7_no_of_bc'], (int) $result7['no_of_bc']);
                } else {
                    array_push($array['7_no_of_bc'], 0);
                }
                if (isset($result7['avg_transaction_no'])) {
                    array_push($array['7_avg_transaction_no'], (int) $result7['avg_transaction_no']);
                } else {
                    array_push($array['7_avg_transaction_no'], 0);
                }
                if (isset($result7['avg_txn_amount'])) {
                    array_push($array['7_avg_txn_amount'], (int) $result7['avg_txn_amount']);
                } else {
                    array_push($array['7_avg_txn_amount'], 0);
                }
                if (isset($result7['avg_com_amount'])) {
                    array_push($array['7_avg_com_amount'], (int) $result7['avg_com_amount']);
                } else {
                    array_push($array['7_avg_com_amount'], 0);
                }
            } else {
                array_push($array['7_no_of_bc'], 0);
                array_push($array['7_avg_transaction_no'], 0);
                array_push($array['7_avg_txn_amount'], 0);
                array_push($array['7_avg_com_amount'], 0);
            }
        }
        return $array;
    }
}
