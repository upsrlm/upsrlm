<?php

namespace bc\modules\transaction\models\summary;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\transaction\models\summary\BcTransactionBankSummaryMonthly;
use common\models\master\MasterRole;
/**
 * BcTransactionBankSummaryMonthlySearch represents the model behind the search form of `bc\modules\transaction\models\summary\BcTransactionBankSummaryMonthly`.
 */
class BcTransactionBankSummaryMonthlySearch extends BcTransactionBankSummaryMonthly {

    public $bank_option = [];
    public $month_option;
    public $from_month_id;
    public $to_month_id;
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'total_bc', 'no_of_district', 'no_of_block', 'no_of_gp', 'master_partner_bank_id', 'month_id', 'total_day', 'total_working_day', 'total_not_working_day', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction', 'month_count'], 'integer'],
            [['transaction_start_date', 'month', 'month_start_date', 'month_end_date'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['from_month_id', 'from_month_id'], 'safe'],
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
        $query = BcTransactionBankSummaryMonthly::find();
        $query->andWhere([BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.status' => 1]);
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
                $query->andWhere([BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } else {
                $query->where('0=1');
            }
        }
        // add conditions that should always apply here

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
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.id' => $this->id,
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.total_bc' => $this->total_bc,
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.no_of_district' => $this->no_of_district,
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.no_of_block' => $this->no_of_block,
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.no_of_gp' => $this->no_of_gp,
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.transaction_start_date' => $this->transaction_start_date,
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.month' => $this->month,
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.month_id' => $this->month_id,
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.month_start_date' => $this->month_start_date,
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.month_end_date' => $this->month_end_date,
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.total_day' => $this->total_day,
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.total_working_day' => $this->total_working_day,
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.total_not_working_day' => $this->total_not_working_day,
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.no_of_transaction' => $this->no_of_transaction,
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.no_of_actual_transaction' => $this->no_of_actual_transaction,
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.zero_transaction' => $this->zero_transaction,
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.transaction_amount' => $this->transaction_amount,
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.commission_amount' => $this->commission_amount,
            BcTransactionBankSummaryMonthly::getTableSchema()->fullName . '.month_count' => $this->month_count,
        ]);

        return $dataProvider;
    }

}
