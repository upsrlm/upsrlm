<?php

namespace cbo\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use cbo\models\CboClf;
use common\models\master\MasterRole;

/**
 * CboClfSearch represents the model behind the search form of `app\models\CboClf`.
 */
class CboClfSearch extends CboClf {

    public $district_option = [];
    public $block_option = [];
    public $funds_type_column_option = [];
    public $order_by_option = [];
    public $type_column;
    public $order_by;
    public $feedback_status;
    public $user_status;
    public $saheli;
    public $wada;
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'no_of_vo_connected', 'no_of_shg_connected', 'no_of_gps_covered', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['name_of_clf', 'date_of_formation', 'bank_account_no_of_the_clf', 'name_of_bank', 'branch', 'branch_code_or_ifsc', 'date_of_opening_the_bank_account', 'district_code', 'block_code', 'nrlm_clf_code'], 'safe'],
            [['funds_received_so_far'], 'number'],
            [['total_funds_amount', 'start_up_funds_amount', 'cif_funds_amount', 'isf_funds_amount', 'if_funds_amount', 'other_funds_amount', 'bank_balance'], 'number'],
            [['type_column'], 'safe'],
            [['order_by'], 'safe'],
            [['type_column'], 'default', 'value' => 'total_funds_amount'],
            [['order_by'], 'default', 'value' => 'asc'],
            [['feedback_status'], 'safe'],
            [['user_status'], 'safe'],
            [['saheli'], 'safe'],
            [['wada'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = CboClf::find();
        if ($columns != NULL) {
            $query->select([$columns]);
        }
        $query->andWhere(['!=', CboClf::getTableSchema()->fullName . '.status', -1]);

        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.created_by' => $user_model->id]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.created_by' => $user_model->id]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CBO_USER])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.id' => \yii\helpers\ArrayHelper::getColumn($user_model->clf, 'cbo_id')]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                //$query->andWhere([CboClf::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_ADMIN])) {
                $query->joinWith(['district']);
                $query->andWhere([\common\models\master\MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN])) {
                $query->joinWith(['district']);
                $query->andWhere([\common\models\master\MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_ADMIN])) {
                $query->joinWith(['block']);
                $query->andWhere([\common\models\master\MasterBlock::getTableSchema()->fullName . '.wada_block' => 1]);
            } else {
                $query->where('0=1');
            }
        }
        if ($this->saheli) {
            $query->joinWith(['district']);
            $query->andWhere([\common\models\master\MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
        }

        if ($this->type_column != '') {
            $query->orderBy($this->type_column . ' ' . $this->order_by);
        }
        if ($columns != NULL) {
            $query->asArray();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            CboClf::getTableSchema()->fullName . '.id' => $this->id,
            CboClf::getTableSchema()->fullName . '.district_code' => $this->district_code,
            CboClf::getTableSchema()->fullName . '.block_code' => $this->block_code,
            CboClf::getTableSchema()->fullName . '.nrlm_clf_code' => $this->nrlm_clf_code,
            CboClf::getTableSchema()->fullName . '.no_of_vo_connected' => $this->no_of_vo_connected,
            CboClf::getTableSchema()->fullName . '.date_of_formation' => $this->date_of_formation,
            CboClf::getTableSchema()->fullName . '.no_of_vo_connected' => $this->no_of_vo_connected,
            CboClf::getTableSchema()->fullName . '.no_of_shg_connected' => $this->no_of_shg_connected,
            CboClf::getTableSchema()->fullName . '.no_of_gps_covered' => $this->no_of_gps_covered,
            CboClf::getTableSchema()->fullName . '.funds_received_so_far' => $this->funds_received_so_far,
            CboClf::getTableSchema()->fullName . '.date_of_opening_the_bank_account' => $this->date_of_opening_the_bank_account,
            CboClf::getTableSchema()->fullName . '.created_by' => $this->created_by,
            CboClf::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            CboClf::getTableSchema()->fullName . '.created_at' => $this->created_at,
            CboClf::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            CboClf::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', CboClf::getTableSchema()->fullName . '.name_of_clf', $this->name_of_clf])
                ->andFilterWhere(['like', CboClf::getTableSchema()->fullName . '.bank_account_no_of_the_clf', $this->bank_account_no_of_the_clf])
                ->andFilterWhere(['like', CboClf::getTableSchema()->fullName . '.name_of_bank', $this->name_of_bank])
                ->andFilterWhere(['like', CboClf::getTableSchema()->fullName . '.branch', $this->branch])
                ->andFilterWhere(['like', CboClf::getTableSchema()->fullName . '.branch_code_or_ifsc', $this->branch_code_or_ifsc]);

        return $dataProvider;
    }
    
    public function searchbccall($params, $user_model = null, $pagination = true, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = CboClf::find();
        if ($columns != NULL) {
            $query->select([$columns]);
        }
        $query->andWhere(['!=', CboClf::getTableSchema()->fullName . '.status', -1]);

        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.created_by' => $user_model->id]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.created_by' => $user_model->id]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CBO_USER])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.id' => \yii\helpers\ArrayHelper::getColumn($user_model->clf, 'cbo_id')]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                //$query->andWhere([CboClf::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_ADMIN])) {
                $query->joinWith(['district']);
                $query->andWhere([\common\models\master\MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN])) {
                $query->joinWith(['district']);
                $query->andWhere([\common\models\master\MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_ADMIN])) {
                $query->joinWith(['block']);
                $query->andWhere([\common\models\master\MasterBlock::getTableSchema()->fullName . '.wada_block' => 1]);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {
                
            }  else {
                $query->where('0=1');
            }
        }
        if ($this->saheli) {
            $query->joinWith(['district']);
            $query->andWhere([\common\models\master\MasterDistrict::getTableSchema()->fullName . '.saheli' => 1]);
        }

        if ($this->type_column != '') {
            $query->orderBy($this->type_column . ' ' . $this->order_by);
        }
        if ($columns != NULL) {
            $query->asArray();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            CboClf::getTableSchema()->fullName . '.id' => $this->id,
            CboClf::getTableSchema()->fullName . '.district_code' => $this->district_code,
            CboClf::getTableSchema()->fullName . '.block_code' => $this->block_code,
            CboClf::getTableSchema()->fullName . '.nrlm_clf_code' => $this->nrlm_clf_code,
            CboClf::getTableSchema()->fullName . '.no_of_vo_connected' => $this->no_of_vo_connected,
            CboClf::getTableSchema()->fullName . '.date_of_formation' => $this->date_of_formation,
            CboClf::getTableSchema()->fullName . '.no_of_vo_connected' => $this->no_of_vo_connected,
            CboClf::getTableSchema()->fullName . '.no_of_shg_connected' => $this->no_of_shg_connected,
            CboClf::getTableSchema()->fullName . '.no_of_gps_covered' => $this->no_of_gps_covered,
            CboClf::getTableSchema()->fullName . '.funds_received_so_far' => $this->funds_received_so_far,
            CboClf::getTableSchema()->fullName . '.date_of_opening_the_bank_account' => $this->date_of_opening_the_bank_account,
            CboClf::getTableSchema()->fullName . '.created_by' => $this->created_by,
            CboClf::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            CboClf::getTableSchema()->fullName . '.created_at' => $this->created_at,
            CboClf::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            CboClf::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', CboClf::getTableSchema()->fullName . '.name_of_clf', $this->name_of_clf])
                ->andFilterWhere(['like', CboClf::getTableSchema()->fullName . '.bank_account_no_of_the_clf', $this->bank_account_no_of_the_clf])
                ->andFilterWhere(['like', CboClf::getTableSchema()->fullName . '.name_of_bank', $this->name_of_bank])
                ->andFilterWhere(['like', CboClf::getTableSchema()->fullName . '.branch', $this->branch])
                ->andFilterWhere(['like', CboClf::getTableSchema()->fullName . '.branch_code_or_ifsc', $this->branch_code_or_ifsc]);

        return $dataProvider;
    }

    public function dashboardreport($params, $user_model = null, $pagination = true, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = CboClf::find();
        $query->select([
            "SUM(total_funds_amount) AS total_funds_amount",
            "SUM(start_up_funds_amount) AS start_up_funds_amount",
            "SUM(cif_funds_amount) AS cif_funds_amount",
            "SUM(isf_funds_amount) AS isf_funds_amount",
            "SUM(if_funds_amount) AS if_funds_amount",
            "SUM(other_funds_amount) AS other_funds_amount",
            "SUM(bank_balance) AS bank_balance"
        ]);
        if ($columns != NULL) {
            $query->select([$columns]);
        }
        $query->andWhere(['!=', CboClf::getTableSchema()->fullName . '.status', -1]);

        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.created_by' => $user_model->id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.created_by' => $user_model->id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                
            } else {
                $query->where('0=1');
            }
        }

        if ($this->type_column != '') {
            $query->orderBy($this->type_column . ' ' . $this->order_by);
        }
        if ($columns != NULL) {
            $query->asArray();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            CboClf::getTableSchema()->fullName . '.id' => $this->id,
            CboClf::getTableSchema()->fullName . '.district_code' => $this->district_code,
            CboClf::getTableSchema()->fullName . '.block_code' => $this->block_code,
            CboClf::getTableSchema()->fullName . '.nrlm_clf_code' => $this->nrlm_clf_code,
            CboClf::getTableSchema()->fullName . '.no_of_vo_connected' => $this->no_of_vo_connected,
            CboClf::getTableSchema()->fullName . '.date_of_formation' => $this->date_of_formation,
            CboClf::getTableSchema()->fullName . '.no_of_vo_connected' => $this->no_of_vo_connected,
            CboClf::getTableSchema()->fullName . '.no_of_shg_connected' => $this->no_of_shg_connected,
            CboClf::getTableSchema()->fullName . '.no_of_gps_covered' => $this->no_of_gps_covered,
            CboClf::getTableSchema()->fullName . '.funds_received_so_far' => $this->funds_received_so_far,
            CboClf::getTableSchema()->fullName . '.date_of_opening_the_bank_account' => $this->date_of_opening_the_bank_account,
            CboClf::getTableSchema()->fullName . '.created_by' => $this->created_by,
            CboClf::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            CboClf::getTableSchema()->fullName . '.created_at' => $this->created_at,
            CboClf::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            CboClf::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', CboClf::getTableSchema()->fullName . '.name_of_clf', $this->name_of_clf])
                ->andFilterWhere(['like', CboClf::getTableSchema()->fullName . '.bank_account_no_of_the_clf', $this->bank_account_no_of_the_clf])
                ->andFilterWhere(['like', CboClf::getTableSchema()->fullName . '.name_of_bank', $this->name_of_bank])
                ->andFilterWhere(['like', CboClf::getTableSchema()->fullName . '.branch', $this->branch])
                ->andFilterWhere(['like', CboClf::getTableSchema()->fullName . '.branch_code_or_ifsc', $this->branch_code_or_ifsc]);

        return $dataProvider;
    }

}
