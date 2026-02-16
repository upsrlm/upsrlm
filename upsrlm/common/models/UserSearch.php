<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form of `common\models\User`.
 */
class UserSearch extends User {

    public $division_option = [];
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $village_option = [];
    public $bank_option = [];
    public $division_code;
    public $district_code;
    public $block_code;
    public $gram_panchayat_code;
    public $member_option;
    public $profile_status;
    public $verification_status;
    public $verification_status_option = [];
    public $partner_bank_option = [];
    public $role_option = [];
    public $page;
    public $member;
    public $bc;
    public $shg;
    public $vo;
    public $clf;
    public $master_partner_bank_id;
    public $saheli;
    public $wada;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'role', 'confirmed_at', 'blocked_at', 'created_at', 'updated_at', 'created_by', 'updated_by', 'flags', 'last_login_at', 'status'], 'safe'],
            [['name', 'username', 'email', 'mobile_no', 'password_hash', 'auth_key', 'unconfirmed_email', 'registration_ip', 'upd', 'password_digest', 'password_reset_token'], 'safe'],
            [['division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'profile_status'], 'safe'],
            [['verification_status'], 'safe'],
            [['page'], 'default', 'value' => 1],
            [['bc', 'shg', 'vo', 'clf'], 'safe'],
            [['member'], 'safe'],
            [['master_partner_bank_id'], 'safe'],
            [['saheli'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true, $select = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = User::find();
        if ($select != NULL) {
            $query->select($select);
        }
        $query->andWhere(['!=', 'user.status', User::STATUS_DELETED]);
// add conditions that should always apply here
        if (!\Yii::$app->request->isConsoleRequest) {
            $this->page = \Yii::$app->request->get('page') != '' ? \Yii::$app->request->get('page') : $this->page;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination, 'page' => $this->page - 1],
            'sort' => ['defaultOrder' => ['name' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
// uncomment the following line if you do not want to return any records when validation fails
// $query->where('0=1');
            return $dataProvider;
        }

// grid filtering conditions
        $query->andFilterWhere([
            'user.id' => $this->id,
            'user.role' => $this->role,
            'user.confirmed_at' => $this->confirmed_at,
            'user.blocked_at' => $this->blocked_at,
            'user.created_at' => $this->created_at,
            'user.updated_at' => $this->updated_at,
            'user.created_by' => $this->created_by,
            'user.updated_by' => $this->updated_by,
            'user.flags' => $this->flags,
            'user.last_login_at' => $this->last_login_at,
            'user.status' => $this->status,
            'user.profile_status' => $this->profile_status,
        ]);

        $query->andFilterWhere(['like', 'user.name', $this->name])
                ->andFilterWhere(['like', 'user.username', $this->username])
                ->andFilterWhere(['like', 'user.email', $this->email])
                ->andFilterWhere(['like', 'user.mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', 'user.password_hash', $this->password_hash])
                ->andFilterWhere(['like', 'user.auth_key', $this->auth_key])
                ->andFilterWhere(['like', 'user.unconfirmed_email', $this->unconfirmed_email])
                ->andFilterWhere(['like', 'user.registration_ip', $this->registration_ip])
                ->andFilterWhere(['like', 'user.upd', $this->upd])
                ->andFilterWhere(['like', 'user.password_digest', $this->password_digest])
                ->andFilterWhere(['like', 'user.password_reset_token', $this->password_reset_token]);
        if (!\Yii::$app->request->isConsoleRequest) {
            if ((int) $query->limit(-1)->offset(-1)->orderBy([])->count('*', $this->db) <= $dataProvider->pagination->pageSize * ($this->page - 1)) {
                $dataProvider->pagination->page = false;
                $this->page = 1;
            }
        }
        return $dataProvider;
    }

    public function deleted($params, $user_model = null, $pagination = true, $select = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = User::find();
        if ($select != NULL) {
            $query->select($select);
        }
        $query->andWhere(['=', 'user.status', User::STATUS_DELETED]);
// add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
//            'sort' => ['defaultOrder' => ['name' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
// uncomment the following line if you do not want to return any records when validation fails
// $query->where('0=1');
            return $dataProvider;
        }

// grid filtering conditions
        $query->andFilterWhere([
            'user.id' => $this->id,
            'user.role' => $this->role,
            'user.confirmed_at' => $this->confirmed_at,
            'user.blocked_at' => $this->blocked_at,
            'user.created_at' => $this->created_at,
            'user.updated_at' => $this->updated_at,
            'user.created_by' => $this->created_by,
            'user.updated_by' => $this->updated_by,
            'user.flags' => $this->flags,
            'user.last_login_at' => $this->last_login_at,
            'user.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'user.name', $this->name])
                ->andFilterWhere(['like', 'user.username', $this->username])
                ->andFilterWhere(['like', 'user.email', $this->email])
                ->andFilterWhere(['like', 'user.mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', 'user.password_hash', $this->password_hash])
                ->andFilterWhere(['like', 'user.auth_key', $this->auth_key])
                ->andFilterWhere(['like', 'user.unconfirmed_email', $this->unconfirmed_email])
                ->andFilterWhere(['like', 'user.registration_ip', $this->registration_ip])
                ->andFilterWhere(['like', 'user.upd', $this->upd])
                ->andFilterWhere(['like', 'user.password_digest', $this->password_digest])
                ->andFilterWhere(['like', 'user.password_reset_token', $this->password_reset_token]);

        return $dataProvider;
    }

}
