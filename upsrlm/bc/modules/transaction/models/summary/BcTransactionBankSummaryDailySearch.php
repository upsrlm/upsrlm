<?php

namespace bc\modules\transaction\models\summary;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\transaction\models\summary\BcTransactionBankSummaryDaily;
use common\models\master\MasterRole;

/**
 * BcTransactionBankSummaryDailySearch represents the model behind the search form of `bc\modules\transaction\models\summary\BcTransactionBankSummaryDaily`.
 */
class BcTransactionBankSummaryDailySearch extends BcTransactionBankSummaryDaily {

    public $bank_option = [];
    public $from_date_time;
    public $to_date_time;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'total_bc', 'no_of_district', 'no_of_block', 'no_of_gp', 'master_partner_bank_id', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction'], 'integer'],
            [['date', 'transaction_start_date'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['from_date_time', 'to_date_time'], 'safe'],
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
        $query = BcTransactionBankSummaryDaily::find();

        $query->andWhere([BcTransactionBankSummaryDaily::getTableSchema()->fullName . '.status' => 1]);
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
                $query->andWhere([BcTransactionBankSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);

                $query->andWhere([BcTransactionBankSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);

                $query->andWhere([BcTransactionBankSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } else {
                $query->where('0=1');
            }
        }
        if (isset($this->from_date_time) && $this->from_date_time != '') {
            $query->andFilterWhere(['>=', BcTransactionBankSummaryDaily::getTableSchema()->fullName . '.date', \Yii::$app->formatter->asDatetime($this->from_date_time, "php:Y-m-d")]);
        }
        if (isset($this->to_date_time) && $this->to_date_time != '') {
            $query->andFilterWhere(['<=', BcTransactionBankSummaryDaily::getTableSchema()->fullName . '.date', \Yii::$app->formatter->asDatetime($this->to_date_time, "php:Y-m-d")]);
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
            BcTransactionBankSummaryDaily::getTableSchema()->fullName . '.id' => $this->id,
            BcTransactionBankSummaryDaily::getTableSchema()->fullName . '.total_bc' => $this->total_bc,
            BcTransactionBankSummaryDaily::getTableSchema()->fullName . '.no_of_district' => $this->no_of_district,
            BcTransactionBankSummaryDaily::getTableSchema()->fullName . '.no_of_block' => $this->no_of_block,
            BcTransactionBankSummaryDaily::getTableSchema()->fullName . '.no_of_gp' => $this->no_of_gp,
            BcTransactionBankSummaryDaily::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransactionBankSummaryDaily::getTableSchema()->fullName . '.date' => $this->date,
            BcTransactionBankSummaryDaily::getTableSchema()->fullName . '.transaction_start_date' => $this->transaction_start_date,
            BcTransactionBankSummaryDaily::getTableSchema()->fullName . '.no_of_transaction' => $this->no_of_transaction,
            BcTransactionBankSummaryDaily::getTableSchema()->fullName . '.no_of_actual_transaction' => $this->no_of_actual_transaction,
            BcTransactionBankSummaryDaily::getTableSchema()->fullName . '.zero_transaction' => $this->zero_transaction,
            BcTransactionBankSummaryDaily::getTableSchema()->fullName . '.transaction_amount' => $this->transaction_amount,
            BcTransactionBankSummaryDaily::getTableSchema()->fullName . '.commission_amount' => $this->commission_amount,
        ]);

        return $dataProvider;
    }
}
