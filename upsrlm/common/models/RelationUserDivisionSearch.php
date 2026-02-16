<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RelationUserDivision;
use app\models\master\MasterRole;

/**
 * RelationUserDivisionSearch represents the model behind the search form of `app\models\RelationUserDivision`.
 */
class RelationUserDivisionSearch extends RelationUserDivision {

    public $username;
    public $name;
    public $mobile_no;
    public $email;
    public $role;
    public $user_status;
    public $division_option = [];
    public static $coll_user = 'user_id';

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'user_id', 'division_code', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'safe'],
            [['user_status'], 'safe'],
            [['username', 'name', 'email', 'role'], 'safe'],
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
        $query = RelationUserDivision::find();
        $query->joinWith(['user', 'division']);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_ULB])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_RURAL_DD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([RelationUserDivision::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CALL_CENTER_EXECUTIVE])) {
                $query->where('0=1');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->where('0=1');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BDO])) {
                $query->where('0=1');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ADHIKARI])) {
                $query->where('0=1');
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAACHIV])) {
                $query->where('0=1');
            } else {
                $query->where('0=1');
            }
            if ($distinct_column != null) {
                if ($distinct_column == static::$coll_user) {
                    $query->joinWith(['user']);
                    $query->select(RelationUserDivision::getTableSchema()->fullName . '.user_id,user.name');
                    $query->distinct();
                    $query->orderBy('user.name');
                }
            }
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
        ]);

        $this->load($params);
        if ($this->user_status == '1') {
            $query->andWhere(['user.blocked_at' => NULL]);
        }
        if ($this->user_status == 0) {
            $query->andWhere(['not', ['user.blocked_at' => NULL]]);
        }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'relation_user_division.id' => $this->id,
            'relation_user_division.user_id' => $this->user_id,
            'relation_user_division.division_code' => $this->division_code,
            'relation_user_division.created_by' => $this->created_by,
            'relation_user_division.updated_by' => $this->updated_by,
            'relation_user_division.created_at' => $this->created_at,
            'relation_user_division.updated_at' => $this->updated_at,
            'relation_user_division.status' => $this->status,
            'user.role' => $this->role,
        ]);

        $query->andFilterWhere(['like', 'user.username', $this->username])
                ->andFilterWhere(['like', 'user.mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', 'user.email', $this->email])
                ->andFilterWhere(['like', 'user.name', $this->name]);

        return $dataProvider;
    }

}
