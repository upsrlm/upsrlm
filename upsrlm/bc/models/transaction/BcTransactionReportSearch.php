<?php

namespace bc\models\transaction;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\transaction\BcTransactionReport;
use common\models\master\MasterRole;

/**
 * BcTransactionReportSearch represents the model behind the search form of `bc\models\transaction\BcTransactionReport`.
 */
class BcTransactionReportSearch extends BcTransactionReport
{

    public $bank_option = [];
    public $block_option = [];
    public $district_option = [];
    public $gp_option = [];
    public $month_option;
    public $numberofdays_option = [1 => '0 Days', 2 => '1-10 Days', 3 => '11-25 Days', 4 => '25 Above Days'];
    public $number_of_day_work;
    public $commission_option = [2 => '1-500 Earn', 3 => '501-2001 Earn', 4 => '2001-5000 Earn', 5 => '5000 Above Earn'];
    public $transaction_option = [1 => '0 Transaction', 2 => '1-29 Transaction', 3 => '30-349 Transaction', 4 => '350-999 Transaction', 5 => '1000 Above Transaction'];
    public $commission_earn;
    public $no_of_transaction;
    public $nretp;
    public $month_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bc_application_id', 'user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'month_id', 'no_of_days', 'no_of_working_days', 'no_of_not_working_days', 'big_ticket_count', 'small_ticket_count', 'no_of_transaction', 'created_at', 'updated_at', 'status'], 'safe'],
            [['bankidbc', 'start_date', 'month', 'month_start_date', 'month_end_date'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'safe'],
            [['nretp', 'number_of_day_work', 'month_id', 'commission_earn', 'no_of_transaction'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true, $group = null)
    {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        // $query = BcTransactionReport::find();

        // if ($user_model == NULL) {
        //     $query->where('0=1');
        // } else {
        //     if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
        //     } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
        //     } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
        //     } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
        //     } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
        //         $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
        //         $query->andWhere([BcTransactionReport::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
        //     } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
        //         $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
        //         $query->andWhere([BcTransactionReport::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
        //         $query->andWhere([BcTransactionReport::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
        //     }elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
        //         $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
        //         $query->andWhere([BcTransactionReport::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
        //         $query->andWhere([BcTransactionReport::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
        //     } else {
        //         $query->where('0=1');
        //     }
        // }

        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,
        //     'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
        //     'sort' => ['defaultOrder' => ['commission_amount' => SORT_DESC]],
        // ]);

        $this->load($params);

        // if (!$this->validate()) {
        //     // uncomment the following line if you do not want to return any records when validation fails
        //     // $query->where('0=1');
        //     return $dataProvider;
        // }

        // grid filtering conditions
        // $query->andFilterWhere([
        //     BcTransactionReport::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
        //     BcTransactionReport::getTableSchema()->fullName . '.user_id' => $this->user_id,
        //     BcTransactionReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
        //     BcTransactionReport::getTableSchema()->fullName . '.block_code' => $this->block_code,
        //     BcTransactionReport::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
        //     BcTransactionReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
        // ]);

        // $query->andFilterWhere(['like', BcTransactionReport::getTableSchema()->fullName . '.bankidbc', $this->bankidbc]);

        // return $dataProvider;
        return true;
    }

    public function monthoption()
    {
        $current_month_id = \bc\modules\selection\models\base\GenralModel::current_month_id();
        $model = \bc\models\transaction\BcTransactionMasterMonth::find()->where(['status' => 1])
            ->andWhere("`id`>=6")
            ->andWhere("`id`<$current_month_id")
            ->orderBy('month_end_date desc')->all();
        return isset($model) ? \yii\helpers\ArrayHelper::map($model, 'id', function ($model) {
            return \Yii::$app->formatter->asDatetime($model->month_end_date, "php:M-Y");
        }) : [];
    }

    /**
     * Line Chart of Total Droping and New BC Members
     *
     * @return void
     */
    public function linechart()
    {
        $current_month_id = \bc\modules\selection\models\base\GenralModel::current_month_id();
        $month_option = \bc\models\transaction\BcTransactionMasterMonth::find()->where(['status' => 1])
            ->andWhere("`id`>=6")
            ->andWhere("`id`<$current_month_id")
            ->orderBy('month_end_date desc')->all();
        $current_month_id = $current_month_id - 1;
        $series_new_vs_droped = [];
        $series_total_vs_worked = [];
        $series_commission = [];
        $series_days = [];
        $category = [];
        $series1 = []; // New BC
        $series2 = []; // Drop BCs
        $series3 = []; // Total BCs
        $series4 = []; // Total BCs who can worked
        $series5 = []; // Commission Earn 0
        $series6 = []; // Commission Earn 1-500 Rs
        $series7 = []; // Commission Earn 501-2000
        $series8 = []; // Commission Earn 2001-5000
        $series9 = []; // Commission Earn 5000 Above
        $series10 = []; // 0 Days Worked
        $series11 = []; // 1-10 Days Worked
        $series12 = []; // 11=25 Days Worked
        $series13 = []; // 25 Above Days Worked

        if ($month_option) {
            foreach ($month_option as $month) {
                $month_id = $month->id;
                $month_name = \Yii::$app->formatter->asDatetime($month->month_end_date, "php:M-Y");

                $start_monthquery = BcTransactionReport::find()
                    ->select(['start_month_id'])
                    ->andWhere([
                        'start_month_id' => $month_id
                    ]);
                $start_monthquery->andFilterWhere([
                    BcTransactionReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
                    BcTransactionReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
                ]);
                $startmonth = $start_monthquery->count();
                if ($startmonth) {
                    array_push($series1, (int)$startmonth);
                }

                $last_month_query = BcTransactionReport::find()
                    ->select(['last_month_id'])
                    ->andWhere([
                        'last_month_id' => $month_id,
                    ])->andWhere("`last_month_id` != $current_month_id");
                $last_month_query->andFilterWhere([
                    BcTransactionReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
                    BcTransactionReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
                ]);
                $lastmonth = $last_month_query->count();
                if ($lastmonth) {
                    array_push($series2, (int)$lastmonth);
                }

                $totalbcquery = \bc\models\transaction\BcTransactionMonthlyReport::find()
                    ->select(['bc_application_id'])
                    ->andWhere("`month_id`<=$month_id")
                    ->andFilterWhere([
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
                    ]);
                // $this->daysquery($totalbcquery);
                $totalbc = $totalbcquery->distinct()->count();
                array_push($series3, (int)$totalbc);

                $totalbcthismonthquery = \bc\models\transaction\BcTransactionMonthlyReport::find()
                    ->select(['bc_application_id'])
                    ->andFilterWhere([
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
                    ])
                    ->andWhere(['month_id' => $month_id]);
                $this->daysquery($totalbcthismonthquery);
                $totalbcthismonth = $totalbcthismonthquery->distinct()->count();
                array_push($series4, (int)$totalbcthismonth);

                $commission0query = \bc\models\transaction\BcTransactionMonthlyReport::find()
                    ->select(['bc_application_id'])
                    ->andFilterWhere([
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
                    ])
                    ->andWhere(['month_id' => $month_id, 'commission_amount' => 0]);
                $this->daysquery($commission0query);
                $commission0 = $commission0query->distinct()->count();
                array_push($series5, (int)$commission0);

                $commission1query = \bc\models\transaction\BcTransactionMonthlyReport::find()
                    ->select(['bc_application_id'])
                    ->andFilterWhere([
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
                    ])
                    ->andWhere(['month_id' => $month_id])
                    ->andWhere("`commission_amount`>=1 and `commission_amount`<=500");
                $this->daysquery($commission1query);
                $commission1 = $commission1query->distinct()->count();
                array_push($series6, (int)$commission1);

                $commission2query = \bc\models\transaction\BcTransactionMonthlyReport::find()
                    ->select(['bc_application_id'])
                    ->andFilterWhere([
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
                    ])
                    ->andWhere(['month_id' => $month_id])
                    ->andWhere("`commission_amount`>=501 and `commission_amount`<=2000");
                $this->daysquery($commission2query);
                $commission2 = $commission2query->distinct()->count();
                array_push($series7, (int)$commission2);

                $commission3query = \bc\models\transaction\BcTransactionMonthlyReport::find()
                    ->select(['bc_application_id'])
                    ->andFilterWhere([
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
                    ])
                    ->andWhere(['month_id' => $month_id])
                    ->andWhere("`commission_amount`>=2001 and `commission_amount`<=5000");
                $this->daysquery($commission3query);
                $commission3 = $commission3query->distinct()->count();
                array_push($series8, (int)$commission3);

                $commission4query = \bc\models\transaction\BcTransactionMonthlyReport::find()
                    ->select(['bc_application_id'])
                    ->andFilterWhere([
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
                    ])
                    ->andWhere(['month_id' => $month_id])
                    ->andWhere("`commission_amount`>=5001");
                $this->daysquery($commission4query);
                $commission4 = $commission4query->distinct()->count();
                array_push($series9, (int)$commission4);

                // $days1query = \bc\models\transaction\BcTransactionMonthlyReport::find()
                //     ->select(['bc_application_id'])
                //     ->andFilterWhere([
                //         BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
                //         BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
                //     ])
                //     ->andWhere(['month_id' => $month_id])
                //     ->andWhere("`no_of_working_days`=0");
                // $this->daysquery($days1query);
                // $days1 = $days1query->distinct()->count();
                // array_push($series10, (int)$days1);
                $days1 = $totalbc - $totalbcthismonth;
                $day1_per = (int)$totalbc != 0 ? (float)  number_format((round(($days1 / (int)$totalbc), 3) * 100), 1) : 0;
                array_push($series10, (int)$day1_per);

                $days2query = \bc\models\transaction\BcTransactionMonthlyReport::find()
                    ->select(['bc_application_id'])
                    ->andFilterWhere([
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
                    ])
                    ->andWhere(['month_id' => $month_id])
                    ->andWhere("`no_of_working_days`>=1 and `no_of_working_days`<=10");
                $this->daysquery($days2query);
                $days2 = $days2query->distinct()->count();
                $days2_per = (int)$totalbc != 0 ? (float)  number_format((round(($days2 / (int)$totalbc), 3) * 100), 1) : 0;
                array_push($series11, (int)$days2_per);

                $days3query = \bc\models\transaction\BcTransactionMonthlyReport::find()
                    ->select(['bc_application_id'])
                    ->andFilterWhere([
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
                    ])
                    ->andWhere(['month_id' => $month_id])
                    ->andWhere("`no_of_working_days`>=11 and `no_of_working_days`<=25");
                $this->daysquery($days3query);
                $days3 = $days3query->distinct()->count();
                $days3_per = (int)$totalbc != 0 ? (float)  number_format((round(($days3 / (int)$totalbc), 3) * 100), 1) : 0;
                array_push($series12, (int)$days3_per);

                $days4query = \bc\models\transaction\BcTransactionMonthlyReport::find()
                    ->select(['bc_application_id'])
                    ->andFilterWhere([
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
                        BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
                    ])
                    ->andWhere(['month_id' => $month_id])
                    ->andWhere("`no_of_working_days`>=26");
                $this->daysquery($days4query);
                $days4 = $days4query->distinct()->count();
                $days4_per = (int)$totalbc != 0 ? (float)  number_format((round(($days4 / (int)$totalbc), 3) * 100), 1) : 0;
                array_push($series13, (int)$days4_per);


                array_push($category, $month_name);
            }
        }

        array_push($series_new_vs_droped, ['name' => 'New BC', 'data' => $series1]);
        array_push($series_new_vs_droped, ['name' => 'Droped BC', 'data' => $series2]);
        array_push($series_total_vs_worked, ['name' => 'Total BC', 'data' => $series3]);
        array_push($series_total_vs_worked, ['name' => 'Total BC Worked', 'data' => $series4]);
        array_push($series_commission, ['name' => '0 Earn', 'data' => $series5]);
        array_push($series_commission, ['name' => '1-500 Earn', 'data' => $series6]);
        array_push($series_commission, ['name' => '501-2000 Earn', 'data' => $series7]);
        array_push($series_commission, ['name' => '2001-5000 Earn', 'data' => $series8]);
        array_push($series_commission, ['name' => '5000 Above Earn', 'data' => $series9]);
        array_push($series_days, ['name' => '0 Days', 'data' => $series10]);
        array_push($series_days, ['name' => '1-10 Days', 'data' => $series11]);
        array_push($series_days, ['name' => '11-25 Days', 'data' => $series12]);
        array_push($series_days, ['name' => '25 Above Days', 'data' => $series13]);

        $chart = 'line';
        if (count($category) <= 1) {
            $chart = 'bar';
        }

        return "<script>
                var month_category = " . json_encode($category) . ";
                var chart_type = " . json_encode($chart) . ";
                var series_new_vs_droped = " . json_encode($series_new_vs_droped) . ";
                var series_total_vs_worked = " . json_encode($series_total_vs_worked) . ";
                var series_commission = " . json_encode($series_commission) . ";
                var series_days = " . json_encode($series_days) . ";
            </script>";
    }

    /**
     * Get Query of Report Days
     *
     * @return void
     */
    public function daysquery($query)
    {
        $report_days = [
            1 => "`no_of_working_days`=0",
            2 => "`no_of_working_days`>=1 and `no_of_working_days`<=10",
            3 => "`no_of_working_days`>=11 and `no_of_working_days`<=25",
            4 => "`no_of_working_days`>=26",
        ];

        if ($this->number_of_day_work) {
            $query->andWhere($report_days[$this->number_of_day_work]);
        }
        return $query;
    }

    /**
     * Combination of Line and Column Chart
     *
     * @return void
     */
    public function combochart()
    {
        $series_combination = [];
        $category = [];
        $series1 = []; // Total BC
        $series2 = []; // No of Transaction
        $series3 = []; // Total Commission Earn

        if ($this->daysinmonth) {
            $no_of_working_day = 1;
            while ($no_of_working_day <= $this->daysinmonth) {

                $total_bcquery = BcTransactionMonthlyReport::find()
                    ->select(['bc_application_id'])
                    ->andWhere([
                        'no_of_working_days' => $no_of_working_day
                    ]);
                $total_bcquery->andFilterWhere([
                    BcTransactionMonthlyReport::getTableSchema()->fullName . '.month_id' => $this->month_id,
                    BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
                    BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
                ]);
                $this->commissionquery($total_bcquery);
                $totalbsc = $total_bcquery->distinct()->count();
                array_push($series1, (int)$totalbsc);

                $total_transaction_query = BcTransactionMonthlyReport::find()
                    ->select("AVG(`no_of_transaction`-`zero_transaction`) as `no_of_transaction`")
                    // ->select(['no_of_transaction'])
                    ->andWhere([
                        'no_of_working_days' => $no_of_working_day,
                    ]);
                $total_transaction_query->andFilterWhere([
                    BcTransactionMonthlyReport::getTableSchema()->fullName . '.month_id' => $this->month_id,
                    BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
                    BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
                ]);
                $this->commissionquery($total_transaction_query);
                // $total_transaction = isset($this->month_id) ? $total_transaction_query->average('no_of_transaction') : $total_transaction_query->average('no_of_transaction');
                $total_transaction = $total_transaction_query->one();
                array_push($series2, (int)$total_transaction['no_of_transaction']);


                $total_commission_query = BcTransactionMonthlyReport::find()
                    ->select(['commission_amount'])
                    ->andWhere([
                        'no_of_working_days' => $no_of_working_day,
                    ]);
                $total_commission_query->andFilterWhere([
                    BcTransactionMonthlyReport::getTableSchema()->fullName . '.month_id' => $this->month_id,
                    BcTransactionMonthlyReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
                    BcTransactionMonthlyReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
                ]);
                $this->commissionquery($total_commission_query);
                $total_commission = isset($this->month_id) ? $total_commission_query->average('commission_amount') : $total_commission_query->average('commission_amount');
                array_push($series3, (int)$total_commission);


                array_push($category, $no_of_working_day);
                $no_of_working_day++;
            }
        }

        array_push($series_combination, ['type' => 'column', 'name' => 'Total BC', 'data' => $series1]);
        array_push($series_combination, ['type' => 'line', 'name' => 'No of Transactions', 'data' => $series2]);
        array_push($series_combination, ['type' => 'line', 'name' => 'Total Commission Earn', 'data' => $series3]);

        return "<script>
                var days_category = " . json_encode($category) . ";
                var series_combination = " . json_encode($series_combination) . ";
            </script>";
    }

    /***
     * Commission Query
     */
    public function commissionquery($query)
    {
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
        return $query;
    }

    public function transactionquery($query)
    {
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
        return $query;
    }

    /**
     * Get Number of Days in Selected Months
     *
     * @return void
     */
    public function getDaysinmonth()
    {
        $totaldays = 31;
        if ($this->month_id) {
            $month = \bc\models\transaction\BcTransactionMasterMonth::find()->where(['status' => 1])
                ->andWhere(['id' => $this->month_id])->one();
            if ($month) {
                $totaldays = explode('-', $month->month_end_date)[2];
            }
        }
        return $totaldays;
    }


    public function monthoptionasc()
    {
        $current_month_id = \bc\modules\selection\models\base\GenralModel::current_month_id();
        $model = \bc\models\transaction\BcTransactionMasterMonth::find()->where(['status' => 1])
            ->andWhere("`id`>=6")
            ->andWhere("`id`<$current_month_id")
            ->orderBy('month_end_date asc')->all();
        return isset($model) ? \yii\helpers\ArrayHelper::map($model, 'id', function ($model) {
            return \Yii::$app->formatter->asDatetime($model->month_end_date, "php:M-Y");
        }) : [];
    }

    /**
     * Bank Retentation 
     *
     * @param [type] $parm_month_id
     * @return void
     */
    public function bcretentation($parm_month_id)
    {
        $bcretentation = [];
        $bcretentation['data'] = [];

        if ($parm_month_id) {

            $total_bcquery = BcTransactionMonthlyReport::find()
                ->select(['bc_application_id'])
                ->andWhere([
                    'month_id' => $parm_month_id
                ]);
            if ($this->master_partner_bank_id) {
                $total_bcquery->andWhere([
                    'master_partner_bank_id' => $this->master_partner_bank_id
                ]);
            }
            $totalbsids = $total_bcquery->distinct()->column();
            $totalcount = $total_bcquery->distinct()->count();
            $month = 1;
            foreach ($this->monthoptionasc() as $internalmonth_id => $internalmonth_name) {
                $total_bcqueryinternal = BcTransactionMonthlyReport::find()
                    ->select(['bc_application_id'])
                    ->andWhere([
                        'month_id' => $internalmonth_id,
                    ])->andFilterWhere([
                        'bc_application_id' => $totalbsids
                    ]);
                $this->commissionquery($total_bcqueryinternal);

                if ($this->master_partner_bank_id) {
                    $total_bcqueryinternal->andWhere([
                        'master_partner_bank_id' => $this->master_partner_bank_id
                    ]);
                }
                if (($this->no_of_transaction && $this->no_of_transaction == 1) || ($this->number_of_day_work && $this->number_of_day_work == 1)) {
                    $totalcountthismonth = $total_bcqueryinternal->distinct()->count();
                    $totalcountinternal = $totalcount - $totalcountthismonth;
                } else {
                    $this->daysquery($total_bcqueryinternal);
                    $this->transactionquery($total_bcqueryinternal);
                    $totalcountinternal = $total_bcqueryinternal->distinct()->count();
                }

                if ($parm_month_id > $internalmonth_id) {
                    // $bcretentation['data'][$internalmonth_id] =  '-';
                } else {
                    $bcretentation['data'][$internalmonth_id] =  $totalcount != 0 ? (float)  number_format((round(($totalcountinternal / $totalcount), 3) * 100), 1) : 0;
                }
                $month++;
            }
        }

        return $bcretentation;
    }
}
