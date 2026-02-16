<?php

namespace bc\modules\transaction\models\summary;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\transaction\models\summary\BcTransactionBankSummary;
use common\models\master\MasterRole;

/**
 * BcTransactionBankSummarySearch represents the model behind the search form of `bc\modules\transaction\models\summary\BcTransactionBankSummary`.
 */
class BcTransactionBankSummarySearch extends BcTransactionBankSummary {

    public $bank_option = [];

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'master_partner_bank_id', 'total_bc', 'no_of_district', 'no_of_block', 'no_of_gp', 'total_day', 'total_working_day', 'total_not_working_day', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction', 'start_month_id', 'last_month_id'], 'integer'],
            [['transaction_start_date', 'start_month_name', 'last_month_name'], 'safe'],
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
        $query = BcTransactionBankSummary::find();
        $query->andWhere([BcTransactionBankSummary::getTableSchema()->fullName . '.status' => 1]);
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
                $query->andWhere([BcTransactionBankSummary::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);

                $query->andWhere([BcTransactionBankSummary::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);

                $query->andWhere([BcTransactionBankSummary::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } else {
                $query->where('0=1');
            }
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['master_partner_bank_id' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            BcTransactionBankSummary::getTableSchema()->fullName . '.id' => $this->id,
            BcTransactionBankSummary::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransactionBankSummary::getTableSchema()->fullName . '.transaction_start_date' => $this->transaction_start_date,
            BcTransactionBankSummary::getTableSchema()->fullName . '.total_bc' => $this->total_bc,
            BcTransactionBankSummary::getTableSchema()->fullName . '.no_of_district' => $this->no_of_district,
            BcTransactionBankSummary::getTableSchema()->fullName . '.no_of_block' => $this->no_of_block,
            BcTransactionBankSummary::getTableSchema()->fullName . '.no_of_gp' => $this->no_of_gp,
            BcTransactionBankSummary::getTableSchema()->fullName . '.total_day' => $this->total_day,
            BcTransactionBankSummary::getTableSchema()->fullName . '.total_working_day' => $this->total_working_day,
            BcTransactionBankSummary::getTableSchema()->fullName . '.total_not_working_day' => $this->total_not_working_day,
            BcTransactionBankSummary::getTableSchema()->fullName . '.no_of_transaction' => $this->no_of_transaction,
            BcTransactionBankSummary::getTableSchema()->fullName . '.no_of_actual_transaction' => $this->no_of_actual_transaction,
            BcTransactionBankSummary::getTableSchema()->fullName . '.zero_transaction' => $this->zero_transaction,
            BcTransactionBankSummary::getTableSchema()->fullName . '.transaction_amount' => $this->transaction_amount,
            BcTransactionBankSummary::getTableSchema()->fullName . '.commission_amount' => $this->commission_amount,
            BcTransactionBankSummary::getTableSchema()->fullName . '.start_month_id' => $this->start_month_id,
            BcTransactionBankSummary::getTableSchema()->fullName . '.last_month_id' => $this->last_month_id,
        ]);

        $query->andFilterWhere(['like', 'start_month_name', $this->start_month_name])
                ->andFilterWhere(['like', 'last_month_name', $this->last_month_name]);

        return $dataProvider;
    }

}
