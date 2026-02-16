<?php

namespace bc\models\transaction;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\transaction\BcTransactionDailyReport;
use common\models\master\MasterRole;

/**
 * BcTransactionDailyReportSearch represents the model behind the search form of `bc\models\transaction\BcTransactionDailyReport`.
 */
class BcTransactionDailyReportSearch extends BcTransactionDailyReport {

    public $bank_option = [];
    public $block_option = [];
    public $district_option = [];
    public $gp_option = [];
    public $commission;
    public $from_date_time;
    public $to_date_time;
    public $month_option;
    public $month;
    public $nretp;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'bc_application_id', 'user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'big_ticket_count', 'small_ticket_count', 'no_of_transaction', 'created_at', 'updated_at', 'status'], 'integer'],
            [['bankidbc', 'date', 'start_date'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['from_date_time', 'to_date_time', 'transaction_datetime'], 'safe'],
            [['month'], 'safe'],
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
        $query = BcTransactionDailyReport::find();

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
                $query->andWhere([BcTransactionDailyReport::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionDailyReport::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionDailyReport::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransactionDailyReport::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransactionDailyReport::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } else {
                $query->where('0=1');
            }
        }
        if (isset($this->from_date_time) && $this->from_date_time != '') {
            $query->andFilterWhere(['>=', BcTransactionDailyReport::getTableSchema()->fullName . '.date', \Yii::$app->formatter->asDatetime($this->from_date_time, "php:Y-m-d")]);
        }
        if (isset($this->to_date_time) && $this->to_date_time != '') {
            $query->andFilterWhere(['<=', BcTransactionDailyReport::getTableSchema()->fullName . '.date', \Yii::$app->formatter->asDatetime($this->to_date_time, "php:Y-m-d")]);
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
            BcTransactionDailyReport::getTableSchema()->fullName . '.id' => $this->id,
            BcTransactionDailyReport::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            BcTransactionDailyReport::getTableSchema()->fullName . '.user_id' => $this->user_id,
            BcTransactionDailyReport::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcTransactionDailyReport::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcTransactionDailyReport::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            BcTransactionDailyReport::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransactionDailyReport::getTableSchema()->fullName . '.date' => $this->date,
            BcTransactionDailyReport::getTableSchema()->fullName . '.start_date' => $this->start_date,
            BcTransactionDailyReport::getTableSchema()->fullName . '.big_ticket_count' => $this->big_ticket_count,
            BcTransactionDailyReport::getTableSchema()->fullName . '.small_ticket_count' => $this->small_ticket_count,
            BcTransactionDailyReport::getTableSchema()->fullName . '.no_of_transaction' => $this->no_of_transaction,
            BcTransactionDailyReport::getTableSchema()->fullName . '.transaction_amount' => $this->transaction_amount,
            BcTransactionDailyReport::getTableSchema()->fullName . '.commission_amount' => $this->commission_amount,
            BcTransactionDailyReport::getTableSchema()->fullName . '.created_at' => $this->created_at,
            BcTransactionDailyReport::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            BcTransactionDailyReport::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['=', BcTransactionDailyReport::getTableSchema()->fullName . '.bankidbc', $this->bankidbc]);

        return $dataProvider;
    }
}
