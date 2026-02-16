<?php

namespace bc\modules\transaction\models\summary;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\transaction\models\summary\BcTransactionBcSummaryWeekly;
use common\models\master\MasterRole;

/**
 * BcTransactionBcSummaryWeeklySearch represents the model behind the search form of `bc\modules\transaction\models\summary\BcTransactionBcSummaryWeekly`.
 */
class BcTransactionBcSummaryWeeklySearch extends BcTransactionBcSummaryWeekly {

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
    public $aspirational;
    public $track;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'bc_application_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'week_id', 'total_day', 'total_working_day', 'total_not_working_day', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction', 'is_new'], 'integer'],
            [['bankidbc', 'transaction_start_date', 'week_start_date', 'week_end_date'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['nretp', 'commission_earn', 'number_of_day_work'], 'safe'],
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
        $query = BcTransactionBcSummaryWeekly::find();
        $query->joinWith(['gp']);
        $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.status' => 1]);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } else {
                $query->where('0=1');
            }
        }
        if ($this->week_id != '') {
            $query->andWhere([BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.week_id' => $this->week_id]);
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
        if ($this->aspirational != '') {
            $query->joinWith(['block']);
            $query->andWhere(['master_block.aspirational' => $this->aspirational]);
        }
        if ($this->change_day) {
            if ($this->change_day == 1) {
                $query->andWhere(['>', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_day', 0]);
            }
            if ($this->change_day == 2) {
                $query->andWhere(['<', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_day', 0]);
            }
            if ($this->change_day == 3) {
                $query->andWhere(['=', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_day', 0]);
            }
        }
        if ($this->change_transaction) {
            if ($this->change_transaction == 1) {
                $query->andWhere(['>', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_transaction', 0]);
            }
            if ($this->change_transaction == 2) {
                $query->andWhere(['<', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_transaction', 0]);
            }
            if ($this->change_transaction == 3) {
                $query->andWhere(['=', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_transaction', 0]);
            }
        }
        if ($this->change_transaction_amount) {
            if ($this->change_transaction_amount == 1) {
                $query->andWhere(['>', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_transaction_amount', 0]);
            }
            if ($this->change_transaction_amount == 2) {
                $query->andWhere(['<', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_transaction_amount', 0]);
            }
            if ($this->change_transaction_amount == 3) {
                $query->andWhere(['=', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_transaction_amount', 0]);
            }
        }
        if ($this->change_commission_amount) {
            if ($this->change_commission_amount == 1) {
                $query->andWhere(['>', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_commission_amount', 0]);
            }
            if ($this->change_commission_amount == 2) {
                $query->andWhere(['<', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_commission_amount', 0]);
            }
            if ($this->change_commission_amount == 3) {
                $query->andWhere(['=', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_commission_amount', 0]);
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
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.id' => $this->id,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.transaction_start_date' => $this->transaction_start_date,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.week_id' => $this->week_id,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.week_start_date' => $this->week_start_date,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.week_end_date' => $this->week_end_date,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.total_day' => $this->total_day,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.total_working_day' => $this->total_working_day,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.total_not_working_day' => $this->total_not_working_day,
            //BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.no_of_transaction' => $this->no_of_transaction,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.no_of_actual_transaction' => $this->no_of_actual_transaction,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.zero_transaction' => $this->zero_transaction,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.transaction_amount' => $this->transaction_amount,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.commission_amount' => $this->commission_amount,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.is_new' => $this->is_new,
        ]);

        $query->andFilterWhere(['like', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.bankidbc', $this->bankidbc]);

        return $dataProvider;
    }

    public function basicquery($query) {
        $user_model = \Yii::$app->user->identity;
        $query->andFilterWhere([
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.transaction_start_date' => $this->transaction_start_date,
            BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.week_id' => $this->week_id,
        ]);
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
        if ($this->change_day) {
            if ($this->change_day == 1) {
                $query->andWhere(['>', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_day', 0]);
            }
            if ($this->change_day == 2) {
                $query->andWhere(['<', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_day', 0]);
            }
            if ($this->change_day == 3) {
                $query->andWhere(['=', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_day', 0]);
            }
        }
        if ($this->change_transaction) {
            if ($this->change_transaction == 1) {
                $query->andWhere(['>', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_transaction', 0]);
            }
            if ($this->change_transaction == 2) {
                $query->andWhere(['<', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_transaction', 0]);
            }
            if ($this->change_transaction == 3) {
                $query->andWhere(['=', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_transaction', 0]);
            }
        }
        if ($this->change_transaction_amount) {
            if ($this->change_transaction_amount == 1) {
                $query->andWhere(['>', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_transaction_amount', 0]);
            }
            if ($this->change_transaction_amount == 2) {
                $query->andWhere(['<', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_transaction_amount', 0]);
            }
            if ($this->change_transaction_amount == 3) {
                $query->andWhere(['=', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_transaction_amount', 0]);
            }
        }
        if ($this->change_commission_amount) {
            if ($this->change_commission_amount == 1) {
                $query->andWhere(['>', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_commission_amount', 0]);
            }
            if ($this->change_commission_amount == 2) {
                $query->andWhere(['<', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_commission_amount', 0]);
            }
            if ($this->change_commission_amount == 3) {
                $query->andWhere(['=', BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.change_commission_amount', 0]);
            }
        }
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } else {
                $query->where('0=1');
            }
        }
        return $query;
    }

    public function getIconday($track = 0) {
        $query = BcTransactionBcSummaryWeekly::find();
        if ($track) {
            $query->andWhere([BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.district_code' => \Yii::$app->params['bc_tracking_disricts']]);
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
        $user_model = \Yii::$app->user->identity;
        $query = BcTransactionBcSummaryWeekly::find();
        if ($track) {
            $query->andWhere([BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.district_code' => \Yii::$app->params['bc_tracking_disricts']]);
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
        $user_model = \Yii::$app->user->identity;
        $query = BcTransactionBcSummaryWeekly::find();
        if ($track) {
            $query->andWhere([BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.district_code' => \Yii::$app->params['bc_tracking_disricts']]);
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
        $user_model = \Yii::$app->user->identity;
        $query = BcTransactionBcSummaryWeekly::find();
        if ($track) {
            $query->andWhere([BcTransactionBcSummaryWeekly::getTableSchema()->fullName . '.district_code' => \Yii::$app->params['bc_tracking_disricts']]);
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
                      FROM  bc_transaction_bc_summary_weekly AS bcsummary 
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
        if ($this->week_id) {
            $where .= ' and bcsummary.week_id=' . $this->week_id;
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
}
