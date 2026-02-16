<?php

namespace bc\models\transaction;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\transaction\BcTransactionOverallReport;
use common\models\master\MasterRole;

/**
 * BcTransactionOverallReportSearch represents the model behind the search form of `bc\models\transaction\BcTransactionOverallReport`.
 */
class BcTransactionOverallReportSearch extends BcTransactionOverallReport {

    public $bank_option = [];
    public $block_option = [];
    public $district_option = [];
    public $gp_option = [];
    public $commission;
    public $nretp;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'bc_application_id', 'user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'no_of_days', 'no_of_working_days', 'no_of_not_working_days', 'big_ticket_count', 'small_ticket_count', 'no_of_transaction', 'created_at', 'updated_at', 'status'], 'integer'],
            [['bankidbc', 'start_date'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['nretp'], 'safe'],
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
        $query = BcTransactionOverallReport::find();

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
                $query->andWhere([BcTransactionOverallReport::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionOverallReport::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionOverallReport::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionOverallReport::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionOverallReport::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } else {
                $query->where('0=1');
            }
        }
        if ($this->nretp != '') {
            $query->joinWith(['block']);
            $query->andWhere(['master_block.nretp' => $this->nretp]);
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
//        var_dump($dataProvider->query->prepare(\Yii::$app->dbbc->queryBuilder)->createCommand()->rawSql);exit;
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            BcTransactionOverallReport::getTableSchema()->fullName . '.id' => $this->id,
            BcTransactionOverallReport::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            BcTransactionOverallReport::getTableSchema()->fullName . '.user_id' => $this->user_id,
            BcTransactionOverallReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcTransactionOverallReport::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcTransactionOverallReport::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            BcTransactionOverallReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransactionOverallReport::getTableSchema()->fullName . '.start_date' => $this->start_date,
            BcTransactionOverallReport::getTableSchema()->fullName . '.no_of_days' => $this->no_of_days,
            BcTransactionOverallReport::getTableSchema()->fullName . '.no_of_working_days' => $this->no_of_working_days,
            BcTransactionOverallReport::getTableSchema()->fullName . '.no_of_not_working_days' => $this->no_of_not_working_days,
            BcTransactionOverallReport::getTableSchema()->fullName . '.big_ticket_count' => $this->big_ticket_count,
            BcTransactionOverallReport::getTableSchema()->fullName . '.small_ticket_count' => $this->small_ticket_count,
            BcTransactionOverallReport::getTableSchema()->fullName . '.no_of_transaction' => $this->no_of_transaction,
            BcTransactionOverallReport::getTableSchema()->fullName . '.transaction_amount' => $this->transaction_amount,
            BcTransactionOverallReport::getTableSchema()->fullName . '.commission_amount' => $this->commission_amount,
            BcTransactionOverallReport::getTableSchema()->fullName . '.created_at' => $this->created_at,
            BcTransactionOverallReport::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            BcTransactionOverallReport::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', BcTransactionOverallReport::getTableSchema()->fullName . '.bankidbc', $this->bankidbc]);
//        var_dump($dataProvider->query->prepare(\Yii::$app->dbbc->queryBuilder)->createCommand()->rawSql);exit;
        return $dataProvider;
    }
}
