<?php

namespace bc\models\transaction;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\transaction\BcTransaction;
use common\models\master\MasterRole;

/**
 * BcTransactionSearch represents the model behind the search form of `bc\models\transaction\BcTransaction`.
 */
class BcTransactionSearch extends BcTransaction {

    public $bank_option = [];
    public $block_option = [];
    public $district_option = [];
    public $gp_option = [];
    public $from_date_time;
    public $to_date_time;
    public $commission;
    public $month_option;
    public $month;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'bc_application_id', 'user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'file_id', 'created_by', 'created_at', 'status'], 'integer'],
            [['bankidbc', 'fileupload_datetime', 'banktransactionid', 'transaction_date', 'transaction_time', 'transaction_type'], 'safe'],
            [['transaction_amount', 'commission_amount'], 'number'],
            [['from_date_time', 'to_date_time', 'transaction_datetime'], 'safe'],
            [['ticket'], 'safe'],
            [['month'], 'safe'],
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
        $query = BcTransaction::find();

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
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                //$query->andWhere([BcTransaction::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                //$query->andWhere([BcTransaction::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } else {
                $query->where('0=1');
            }
            if ($group != null) {
                $query->groupBy([$group]);
            }
            if ($this->commission == '1') {
                $query->andWhere(['!=', BcTransaction::getTableSchema()->fullName . '.commission_amount', 0]);
            }
            if (isset($this->from_date_time) && $this->from_date_time != '') {
                $query->andFilterWhere(['>=', BcTransaction::getTableSchema()->fullName . '.transaction_date', \Yii::$app->formatter->asDatetime($this->from_date_time, "php:Y-m-d")]);
            }
            if (isset($this->to_date_time) && $this->to_date_time != '') {
                $query->andFilterWhere(['<=', BcTransaction::getTableSchema()->fullName . '.transaction_date', \Yii::$app->formatter->asDatetime($this->to_date_time, "php:Y-m-d")]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['transaction_datetime' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            BcTransaction::getTableSchema()->fullName . '.id' => $this->id,
            BcTransaction::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            BcTransaction::getTableSchema()->fullName . '.user_id' => $this->user_id,
            BcTransaction::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcTransaction::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcTransaction::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransaction::getTableSchema()->fullName . '.file_id' => $this->file_id,
            BcTransaction::getTableSchema()->fullName . '.fileupload_datetime' => $this->fileupload_datetime,
            BcTransaction::getTableSchema()->fullName . '.transaction_date' => $this->transaction_date,
            BcTransaction::getTableSchema()->fullName . '.transaction_time' => $this->transaction_time,
            BcTransaction::getTableSchema()->fullName . '.transaction_amount' => $this->transaction_amount,
            BcTransaction::getTableSchema()->fullName . '.commission_amount' => $this->commission_amount,
            BcTransaction::getTableSchema()->fullName . '.ticket' => $this->ticket,
            BcTransaction::getTableSchema()->fullName . '.created_by' => $this->created_by,
            BcTransaction::getTableSchema()->fullName . '.created_at' => $this->created_at,
            BcTransaction::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['=', BcTransaction::getTableSchema()->fullName . '.bankidbc', $this->bankidbc])
                ->andFilterWhere(['like', BcTransaction::getTableSchema()->fullName . '.banktransactionid', $this->banktransactionid])
                ->andFilterWhere(['like', BcTransaction::getTableSchema()->fullName . '.transaction_type', $this->transaction_type]);

        return $dataProvider;
    }

    public function searchunique($params, $user_model = null, $pagination = true, $group = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = BcTransaction::find();
        $query->select(['*', 'COUNT(*) AS no_of_transaction']);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                //$query->andWhere([BcTransaction::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                //$query->andWhere([BcTransaction::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } else {
                $query->where('0=1');
            }
            if ($group != null) {
                $query->groupBy([$group]);
            }
            if ($this->commission == '1') {
                $query->andWhere(['!=', BcTransaction::getTableSchema()->fullName . '.commission_amount', 0]);
            }
            if (isset($this->from_date_time) && $this->from_date_time != '') {
                $query->andFilterWhere(['>=', BcTransaction::getTableSchema()->fullName . '.transaction_date', \Yii::$app->formatter->asDatetime($this->from_date_time, "php:Y-m-d")]);
            }
            if (isset($this->to_date_time) && $this->to_date_time != '') {
                $query->andFilterWhere(['<=', BcTransaction::getTableSchema()->fullName . '.transaction_date', \Yii::$app->formatter->asDatetime($this->to_date_time, "php:Y-m-d")]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['transaction_datetime' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            BcTransaction::getTableSchema()->fullName . '.id' => $this->id,
            BcTransaction::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            BcTransaction::getTableSchema()->fullName . '.user_id' => $this->user_id,
            BcTransaction::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcTransaction::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcTransaction::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransaction::getTableSchema()->fullName . '.file_id' => $this->file_id,
            BcTransaction::getTableSchema()->fullName . '.fileupload_datetime' => $this->fileupload_datetime,
            BcTransaction::getTableSchema()->fullName . '.transaction_date' => $this->transaction_date,
            BcTransaction::getTableSchema()->fullName . '.transaction_time' => $this->transaction_time,
            BcTransaction::getTableSchema()->fullName . '.transaction_amount' => $this->transaction_amount,
            BcTransaction::getTableSchema()->fullName . '.commission_amount' => $this->commission_amount,
            BcTransaction::getTableSchema()->fullName . '.ticket' => $this->ticket,
            BcTransaction::getTableSchema()->fullName . '.created_by' => $this->created_by,
            BcTransaction::getTableSchema()->fullName . '.created_at' => $this->created_at,
            BcTransaction::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['=', BcTransaction::getTableSchema()->fullName . '.bankidbc', $this->bankidbc])
                ->andFilterWhere(['like', BcTransaction::getTableSchema()->fullName . '.banktransactionid', $this->banktransactionid])
                ->andFilterWhere(['like', BcTransaction::getTableSchema()->fullName . '.transaction_type', $this->transaction_type]);

        return $dataProvider;
    }

    public function searchapp($params, $user_model = null, $pagination = true, $group = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = BcTransaction::find();
        $query->andWhere([BcTransaction::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['transaction_datetime' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            BcTransaction::getTableSchema()->fullName . '.id' => $this->id,
            BcTransaction::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            BcTransaction::getTableSchema()->fullName . '.user_id' => $this->user_id,
            BcTransaction::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcTransaction::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcTransaction::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransaction::getTableSchema()->fullName . '.file_id' => $this->file_id,
            BcTransaction::getTableSchema()->fullName . '.fileupload_datetime' => $this->fileupload_datetime,
            BcTransaction::getTableSchema()->fullName . '.transaction_date' => $this->transaction_date,
            BcTransaction::getTableSchema()->fullName . '.transaction_time' => $this->transaction_time,
            BcTransaction::getTableSchema()->fullName . '.transaction_amount' => $this->transaction_amount,
            BcTransaction::getTableSchema()->fullName . '.commission_amount' => $this->commission_amount,
            BcTransaction::getTableSchema()->fullName . '.ticket' => $this->ticket,
            BcTransaction::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['=', BcTransaction::getTableSchema()->fullName . '.bankidbc', $this->bankidbc])
                ->andFilterWhere(['like', BcTransaction::getTableSchema()->fullName . '.banktransactionid', $this->banktransactionid])
                ->andFilterWhere(['like', BcTransaction::getTableSchema()->fullName . '.transaction_type', $this->transaction_type]);

        return $dataProvider;
    }

    public function reportsearch($params, $user_model = null, $pagination = true, $group = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = BcTransaction::find();
        $query->select(['transaction_date']);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                //$query->andWhere([BcTransaction::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
                //$query->andWhere([BcTransaction::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => isset($profile) ? $profile->master_partner_bank_id : 0]);
            } else {
                $query->where('0=1');
            }

            $query->andFilterWhere(['>=', BcTransaction::getTableSchema()->fullName . '.transaction_date', \Yii::$app->formatter->asDatetime($this->from_date_time, "php:Y-m-d")]);

            $query->andFilterWhere(['<=', BcTransaction::getTableSchema()->fullName . '.transaction_date', \Yii::$app->formatter->asDatetime($this->to_date_time, "php:Y-m-d")]);

            $query->groupBy('transaction_date');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['transaction_datetime' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            BcTransaction::getTableSchema()->fullName . '.id' => $this->id,
            BcTransaction::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            BcTransaction::getTableSchema()->fullName . '.user_id' => $this->user_id,
            BcTransaction::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcTransaction::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcTransaction::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            BcTransaction::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            BcTransaction::getTableSchema()->fullName . '.file_id' => $this->file_id,
            BcTransaction::getTableSchema()->fullName . '.fileupload_datetime' => $this->fileupload_datetime,
            BcTransaction::getTableSchema()->fullName . '.transaction_date' => $this->transaction_date,
            BcTransaction::getTableSchema()->fullName . '.transaction_time' => $this->transaction_time,
            BcTransaction::getTableSchema()->fullName . '.transaction_amount' => $this->transaction_amount,
            BcTransaction::getTableSchema()->fullName . '.commission_amount' => $this->commission_amount,
            BcTransaction::getTableSchema()->fullName . '.ticket' => $this->ticket,
            BcTransaction::getTableSchema()->fullName . '.created_by' => $this->created_by,
            BcTransaction::getTableSchema()->fullName . '.created_at' => $this->created_at,
            BcTransaction::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['=', BcTransaction::getTableSchema()->fullName . '.bankidbc', $this->bankidbc])
                ->andFilterWhere(['like', BcTransaction::getTableSchema()->fullName . '.banktransactionid', $this->banktransactionid])
                ->andFilterWhere(['like', BcTransaction::getTableSchema()->fullName . '.transaction_type', $this->transaction_type]);

        return $dataProvider;
    }

//    public function monthoption($params, $user_model = null) {
//        $sql = 'SELECT DATE_FORMAT(transaction_date, "%Y-%m-01") as t_date from bc_transaction';
//        if (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
//            $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
//            $sql .= ' where master_partner_bank_id=' . $profile->master_partner_bank_id;
//        }
//        $sql .= ' group by t_date order by t_date asc';
//        $res = \Yii::$app->dbbc->createCommand($sql)->queryAll();
//        $array = \yii\helpers\ArrayHelper::getColumn($res, 't_date');
//        $arrays = [];
//        foreach ($array as $a) {
//            $arrays[$a] = \Yii::$app->formatter->asDatetime($a, "php:M-Y");
//        }
//        return $arrays;
//    }
    public function monthoption($params, $user_model = null) {
        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $last_day_month = $date->format('Y-m-d');
        $model = \bc\models\transaction\BcTransactionMasterMonth::find()->where(['status' => 1])->andFilterWhere(['<=', 'month_end_date', $last_day_month])->orderBy('month_end_date desc')->all();
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
