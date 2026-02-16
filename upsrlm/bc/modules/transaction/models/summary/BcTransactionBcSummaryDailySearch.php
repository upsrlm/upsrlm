<?php

namespace bc\modules\transaction\models\summary;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily;
use common\models\master\MasterRole;

/**
 * BcTransactionBcSummaryDailySearch represents the model behind the search form of `bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily`.
 */
class BcTransactionBcSummaryDailySearch extends BcTransactionBcSummaryDaily {

    public $bank_option = [];
    public $block_option = [];
    public $district_option = [];
    public $gp_option = [];
    public $month_option = [];
    public $from_date_time;
    public $to_date_time;
    public $month;
    public $aspirational;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'bc_application_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction', 'is_new', 'status'], 'integer'],
            [['bankidbc', 'date', 'transaction_start_date'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['from_date_time', 'to_date_time'], 'safe'],
            [['month'], 'safe'],
            [['aspirational'], 'safe'],
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
        $query = BcTransactionBcSummaryDaily::find();
        $query->joinWith(['gp']);
        $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.status' => 1]);
        $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.status' => 1]);
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
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } else {
                $query->where('0=1');
            }
        }
        if (isset($this->from_date_time) && $this->from_date_time != '') {
            $query->andFilterWhere(['>=', BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.date', \Yii::$app->formatter->asDatetime($this->from_date_time, "php:Y-m-d")]);
        }
        if (isset($this->to_date_time) && $this->to_date_time != '') {
            $query->andFilterWhere(['<=', BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.date', \Yii::$app->formatter->asDatetime($this->to_date_time, "php:Y-m-d")]);
        }
        if ($this->aspirational != '') {
            $query->joinWith(['block']);
            $query->andWhere(['master_block.aspirational' => $this->aspirational]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['date' => SORT_DESC]],
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.id' => $this->id,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.date' => $this->date,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.transaction_start_date' => $this->transaction_start_date,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.no_of_transaction' => $this->no_of_transaction,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.no_of_actual_transaction' => $this->no_of_actual_transaction,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.zero_transaction' => $this->zero_transaction,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.transaction_amount' => $this->transaction_amount,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.commission_amount' => $this->commission_amount,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.is_new' => $this->is_new,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.bankidbc', $this->bankidbc]);

        return $dataProvider;
    }

    public function reportsearch($params, $user_model = null, $pagination = true, $group = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = BcTransactionBcSummaryDaily::find();
        $query->select(['date']);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                //$query->andWhere([BcTransaction::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } else {
                $query->where('0=1');
            }

            $query->andFilterWhere(['>=', BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.date', \Yii::$app->formatter->asDatetime($this->from_date_time, "php:Y-m-d")]);

            $query->andFilterWhere(['<=', BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.date', \Yii::$app->formatter->asDatetime($this->to_date_time, "php:Y-m-d")]);

            $query->groupBy('date');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['date' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.id' => $this->id,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.date' => $this->date,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.transaction_start_date' => $this->transaction_start_date,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.no_of_transaction' => $this->no_of_transaction,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.no_of_actual_transaction' => $this->no_of_actual_transaction,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.zero_transaction' => $this->zero_transaction,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.transaction_amount' => $this->transaction_amount,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.commission_amount' => $this->commission_amount,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.is_new' => $this->is_new,
            BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', BcTransactionBcSummaryDaily::getTableSchema()->fullName . '.bankidbc', $this->bankidbc]);

        return $dataProvider;
    }

    public function monthoption($params, $user_model = null) {
        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $last_day_month = $date->format('Y-m-d');
        $model = BcTransactionMasterMonth::find()->where(['status' => 1])->andFilterWhere(['<=', 'month_end_date', $last_day_month])->orderBy('month_end_date desc')->all();
        return isset($model) ? \yii\helpers\ArrayHelper::map($model, 'month_start_date', function ($model) {
                    return \Yii::$app->formatter->asDatetime($model->month_end_date, "php:M-Y");
                }) : [];
    }

    public function SetDate() {
        if (isset($this->month)) {
            $this->from_date_time = $this->month;
            $this->to_date_time = \DateTime::createFromFormat("Y-m-d", $this->month)->format("Y-m-t");
        }
    }
}
