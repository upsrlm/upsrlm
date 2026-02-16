<?php

namespace common\models\dynamicdb\cbo_detail;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\CboMembersSearch;
use common\models\master\MasterRole;

/**
 * CboMembersSearch represents the model behind the search form of `common\models\CboMembers`.
 */
class CboMembersSearch extends CboMembers {

    public $rishta_app_used;
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $village_option = [];
    public $bank_option = [];
    public $district_code;
    public $block_code;
    public $gram_panchayat_code;
    public $master_partner_bank_id;
    public $partner_bank_option = [];
    public $wada;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'user_id', 'cbo_type', 'cbo_id', 'entry_type', 'role', 'shg_chairperson', 'shg_secretary', 'shg_treasurer', 'shg_member', 'vo_chairperson', 'vo_secretary', 'vo_treasurer', 'vo_member', 'clf_chairperson', 'clf_secretary', 'clf_treasurer', 'clf_member', 'bc_sakhi', 'samuh_sakhi', 'wada_sakhi', 'accountant', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'], 'safe'],
            [['rishta_app_used'], 'safe'],
            [['district_code', 'block_code', 'gram_panchayat_code'], 'safe'],
            [['master_partner_bank_id'], 'safe'],
            [['wada'], 'safe'],
            [['suggest_wada_sakhi'], 'safe']
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
    public function search($params, $user_model = null, $pagination = true, $distinct_column = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = CboMembers::find();
        $query->joinWith(['user']);
        $query->andWhere(['!=', CboMembers::getTableSchema()->fullName . '.status', -1]);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_WADA_ADMIN])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                $query->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => 1]);
                $query->joinWith(['shg']);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_VIEWER])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                $query->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => 1]);
                $query->joinWith(['shg']);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                $query->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => 1]);
                $query->joinWith(['shg']);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                $query->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => 1]);
                $query->joinWith(['shg']);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                $query->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => 1]);
                $query->joinWith(['shg']);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                $query->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => 1]);
                $query->joinWith(['shg']);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
                $query->joinWith(['shg']);
                $query->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => 1]);
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                //$query->andWhere([\cbo\models\Shg::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE])) {
                $query->joinWith(['shg']);
                $query->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => 1]);
                $query->andWhere([\cbo\models\Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                $query->andWhere([\cbo\models\Shg::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                $query->joinWith(['shg']);
                $query->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => 1]);
                $query->andWhere([\cbo\models\Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                //$query->andWhere([\cbo\models\Shg::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {

                $query->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => 1]);
                $query->joinWith(['shg']);
                $query->andWhere([\cbo\models\Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                $query->andWhere([\cbo\models\Shg::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } else {
                $query->where('0=1');
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            CboMembers::getTableSchema()->fullName . '.id' => $this->id,
            CboMembers::getTableSchema()->fullName . '.user_id' => $this->user_id,
            CboMembers::getTableSchema()->fullName . '.cbo_type' => $this->cbo_type,
            CboMembers::getTableSchema()->fullName . '.cbo_id' => $this->cbo_id,
            CboMembers::getTableSchema()->fullName . '.entry_type' => $this->entry_type,
            CboMembers::getTableSchema()->fullName . '.role' => $this->role,
            CboMembers::getTableSchema()->fullName . '.shg_chairperson' => $this->shg_chairperson,
            CboMembers::getTableSchema()->fullName . '.shg_secretary' => $this->shg_secretary,
            CboMembers::getTableSchema()->fullName . '.shg_treasurer' => $this->shg_treasurer,
            CboMembers::getTableSchema()->fullName . '.shg_member' => $this->shg_member,
            CboMembers::getTableSchema()->fullName . '.vo_chairperson' => $this->vo_chairperson,
            CboMembers::getTableSchema()->fullName . '.vo_secretary' => $this->vo_secretary,
            CboMembers::getTableSchema()->fullName . '.vo_treasurer' => $this->vo_treasurer,
            CboMembers::getTableSchema()->fullName . '.vo_member' => $this->vo_member,
            CboMembers::getTableSchema()->fullName . '.clf_chairperson' => $this->clf_chairperson,
            CboMembers::getTableSchema()->fullName . '.clf_secretary' => $this->clf_secretary,
            CboMembers::getTableSchema()->fullName . '.clf_treasurer' => $this->clf_treasurer,
            CboMembers::getTableSchema()->fullName . '.clf_member' => $this->clf_member,
            CboMembers::getTableSchema()->fullName . '.bc_sakhi' => $this->bc_sakhi,
            CboMembers::getTableSchema()->fullName . '.samuh_sakhi' => $this->samuh_sakhi,
            CboMembers::getTableSchema()->fullName . '.wada_sakhi' => $this->wada_sakhi,
            CboMembers::getTableSchema()->fullName . '.suggest_wada_sakhi' => $this->suggest_wada_sakhi,
            CboMembers::getTableSchema()->fullName . '.accountant' => $this->accountant,
            CboMembers::getTableSchema()->fullName . '.created_at' => $this->created_at,
            CboMembers::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            CboMembers::getTableSchema()->fullName . '.created_by' => $this->created_by,
            CboMembers::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            CboMembers::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        return $dataProvider;
    }

    public function report($params, $user_model = null, $pagination = true, $distinct_column = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = CboMembers::find();
        $query->joinWith(['user']);
        $query->andWhere(['!=', CboMembers::getTableSchema()->fullName . '.status', -1]);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                $query->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => 1]);
                $query->joinWith(['shg']);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                $query->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => 1]);
                $query->joinWith(['shg']);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                $query->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => 1]);
                $query->joinWith(['shg']);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
                $query->joinWith(['shg']);
                $query->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => 1]);
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE])) {
                $query->joinWith(['shg']);
                $query->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => 1]);
                $query->andWhere([\cbo\models\Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                $query->andWhere([\cbo\models\Shg::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                $query->joinWith(['shg']);
                $query->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => 1]);
                $query->andWhere([\cbo\models\Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {

                $query->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => 1]);
                $query->joinWith(['shg']);
                $query->andWhere([\cbo\models\Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                $query->andWhere([\cbo\models\Shg::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } else {
                $query->where('0=1');
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            CboMembers::getTableSchema()->fullName . '.id' => $this->id,
            CboMembers::getTableSchema()->fullName . '.user_id' => $this->user_id,
            CboMembers::getTableSchema()->fullName . '.cbo_type' => $this->cbo_type,
            CboMembers::getTableSchema()->fullName . '.cbo_id' => $this->cbo_id,
            CboMembers::getTableSchema()->fullName . '.entry_type' => $this->entry_type,
            CboMembers::getTableSchema()->fullName . '.role' => $this->role,
            CboMembers::getTableSchema()->fullName . '.shg_chairperson' => $this->shg_chairperson,
            CboMembers::getTableSchema()->fullName . '.shg_secretary' => $this->shg_secretary,
            CboMembers::getTableSchema()->fullName . '.shg_treasurer' => $this->shg_treasurer,
            CboMembers::getTableSchema()->fullName . '.shg_member' => $this->shg_member,
            CboMembers::getTableSchema()->fullName . '.vo_chairperson' => $this->vo_chairperson,
            CboMembers::getTableSchema()->fullName . '.vo_secretary' => $this->vo_secretary,
            CboMembers::getTableSchema()->fullName . '.vo_treasurer' => $this->vo_treasurer,
            CboMembers::getTableSchema()->fullName . '.vo_member' => $this->vo_member,
            CboMembers::getTableSchema()->fullName . '.clf_chairperson' => $this->clf_chairperson,
            CboMembers::getTableSchema()->fullName . '.clf_secretary' => $this->clf_secretary,
            CboMembers::getTableSchema()->fullName . '.clf_treasurer' => $this->clf_treasurer,
            CboMembers::getTableSchema()->fullName . '.clf_member' => $this->clf_member,
            CboMembers::getTableSchema()->fullName . '.bc_sakhi' => $this->bc_sakhi,
            CboMembers::getTableSchema()->fullName . '.samuh_sakhi' => $this->samuh_sakhi,
            CboMembers::getTableSchema()->fullName . '.wada_sakhi' => $this->wada_sakhi,
            CboMembers::getTableSchema()->fullName . '.suggest_wada_sakhi' => $this->suggest_wada_sakhi,
            CboMembers::getTableSchema()->fullName . '.accountant' => $this->accountant,
            CboMembers::getTableSchema()->fullName . '.created_at' => $this->created_at,
            CboMembers::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            CboMembers::getTableSchema()->fullName . '.created_by' => $this->created_by,
            CboMembers::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            CboMembers::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        return $dataProvider;
    }

}
