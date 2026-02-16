<?php

namespace bc\modules\transaction\models\summary;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\transaction\models\summary\BcTransactionBankSummaryWeekly;
use common\models\master\MasterRole;

/**
 * BcTransactionBankSummaryWeeklySearch represents the model behind the search form of `bc\modules\transaction\models\summary\BcTransactionBankSummaryWeekly`.
 */
class BcTransactionBankSummaryWeeklySearch extends BcTransactionBankSummaryWeekly {

    public $bank_option = [];
    public $week_option;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'total_bc', 'no_of_district', 'no_of_block', 'no_of_gp', 'master_partner_bank_id', 'week_id', 'total_day', 'total_working_day', 'total_not_working_day', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction'], 'integer'],
            [['transaction_start_date', 'week_start_date', 'week_end_date'], 'safe'],
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
        $query = BcTransactionBankSummaryWeekly::find();

        $query->andWhere([BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.status' => 1]);
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
                $query->andWhere([BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
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
            BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.id' => $this->id,
            BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.total_bc' => $this->total_bc,
            BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.no_of_district' => $this->no_of_district,
            BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.no_of_block' => $this->no_of_block,
            BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.no_of_gp' => $this->no_of_gp,
            BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.transaction_start_date' => $this->transaction_start_date,
            BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.week_id' => $this->week_id,
            BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.week_start_date' => $this->week_start_date,
            BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.week_end_date' => $this->week_end_date,
            BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.total_day' => $this->total_day,
            BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.total_working_day' => $this->total_working_day,
            BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.total_not_working_day' => $this->total_not_working_day,
            BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.no_of_transaction' => $this->no_of_transaction,
            BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.no_of_actual_transaction' => $this->no_of_actual_transaction,
            BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.zero_transaction' => $this->zero_transaction,
            BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.transaction_amount' => $this->transaction_amount,
            BcTransactionBankSummaryWeekly::getTableSchema()->fullName . '.commission_amount' => $this->commission_amount,
        ]);

        return $dataProvider;
    }
}
