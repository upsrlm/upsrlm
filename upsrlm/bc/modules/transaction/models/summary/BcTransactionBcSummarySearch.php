<?php

namespace bc\modules\transaction\models\summary;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\transaction\models\summary\BcTransactionBcSummary;
use common\models\master\MasterRole;

/**
 * BcTransactionBcSummarySearch represents the model behind the search form of `bc\modules\transaction\models\summary\BcTransactionBcSummary`.
 */
class BcTransactionBcSummarySearch extends BcTransactionBcSummary {

    public $bank_option = [];
    public $block_option = [];
    public $district_option = [];
    public $gp_option = [];
    public $nretp;
    public $aspirational;
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'bc_application_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'total_day', 'total_working_day', 'total_not_working_day', 'no_of_transaction', 'no_of_actual_transaction', 'zero_transaction', 'start_month_id', 'last_month_id'], 'integer'],
            [['bankidbc', 'transaction_start_date', 'start_month_name', 'last_month_name'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['nretp'], 'safe'],
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
        $query = BcTransactionBcSummary::find();
        $query->joinWith(['gp']);
        $query->andWhere([MasterGramPanchayat::getTableSchema()->fullName . '.status' => 1]);
        $query->andWhere([BcTransactionBcSummary::getTableSchema()->fullName . '.bc_status' => 1]);
        if ($user_model == NULL) {
            //$query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            }elseif (in_array($user_model->role, [MasterRole::ROLE_RBI])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummary::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummary::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionBcSummary::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionBcSummary::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionBcSummary::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
            } else {
                $query->where('0=1');
            }
        }
        if ($this->nretp != '') {
            $query->joinWith(['block']);
            $query->andWhere(['master_block.nretp' => $this->nretp]);
        }
        if ($this->aspirational != '') {
            $query->joinWith(['block']);
            $query->andWhere(['master_block.aspirational' => $this->aspirational]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['commission_amount' => SORT_DESC, 'gram_panchayat_code' => SORT_ASC]],
        ]);
        if (isset($_REQUEST['sort'])) {
            if ($_REQUEST['sort'] == 'commission_amount') {
                $dataProvider->query->orderBy([
                    'commission_amount' => SORT_ASC,
                    'gram_panchayat_code' => SORT_ASC
                ]);
            }
            if ($_REQUEST['sort'] == '-commission_amount') {
                $dataProvider->query->orderBy([
                    'commission_amount' => SORT_DESC,
                    'gram_panchayat_code' => SORT_ASC
                ]);
            }
            if ($_REQUEST['sort'] == 'transaction_amount') {
                $dataProvider->query->orderBy([
                    'transaction_amount' => SORT_ASC,
                    'gram_panchayat_code' => SORT_ASC
                ]);
            }
            if ($_REQUEST['sort'] == '-transaction_amount') {
                $dataProvider->query->orderBy([
                    'transaction_amount' => SORT_DESC,
                    'gram_panchayat_code' => SORT_ASC
                ]);
            }
            if ($_REQUEST['sort'] == 'no_of_transaction') {
                $dataProvider->query->orderBy([
                    'no_of_transaction' => SORT_ASC,
                    'gram_panchayat_code' => SORT_ASC
                ]);
            }
            if ($_REQUEST['sort'] == '-no_of_transaction') {
                $dataProvider->query->orderBy([
                    'no_of_transaction' => SORT_DESC,
                    'gram_panchayat_code' => SORT_ASC
                ]);
            }
        }
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            BcTransactionBcSummary::getTableSchema()->fullName . '.id' => $this->id,
            BcTransactionBcSummary::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            BcTransactionBcSummary::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcTransactionBcSummary::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcTransactionBcSummary::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            BcTransactionBcSummary::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransactionBcSummary::getTableSchema()->fullName . '.transaction_start_date' => $this->transaction_start_date,
            BcTransactionBcSummary::getTableSchema()->fullName . '.total_day' => $this->total_day,
            BcTransactionBcSummary::getTableSchema()->fullName . '.total_working_day' => $this->total_working_day,
            BcTransactionBcSummary::getTableSchema()->fullName . '.total_not_working_day' => $this->total_not_working_day,
            BcTransactionBcSummary::getTableSchema()->fullName . '.no_of_transaction' => $this->no_of_transaction,
            BcTransactionBcSummary::getTableSchema()->fullName . '.no_of_actual_transaction' => $this->no_of_actual_transaction,
            BcTransactionBcSummary::getTableSchema()->fullName . '.zero_transaction' => $this->zero_transaction,
            BcTransactionBcSummary::getTableSchema()->fullName . '.transaction_amount' => $this->transaction_amount,
            BcTransactionBcSummary::getTableSchema()->fullName . '.commission_amount' => $this->commission_amount,
            BcTransactionBcSummary::getTableSchema()->fullName . '.start_month_id' => $this->start_month_id,
            BcTransactionBcSummary::getTableSchema()->fullName . '.last_month_id' => $this->last_month_id,
        ]);

        $query->andFilterWhere(['like', 'bankidbc', $this->bankidbc])
                ->andFilterWhere(['like', 'start_month_name', $this->start_month_name])
                ->andFilterWhere(['like', 'last_month_name', $this->last_month_name]);

        return $dataProvider;
    }

}
