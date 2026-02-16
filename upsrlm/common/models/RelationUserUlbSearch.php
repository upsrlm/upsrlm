<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RelationUserUlb;
use common\models\master\MasterRole;

/**
 * RelationUserUlbSearch represents the model behind the search form of `app\models\RelationUserUlb`.
 */
class RelationUserUlbSearch extends RelationUserUlb {

    public static $coll_district = 'district_code';
    public static $coll_block = 'block_code';
    public static $coll_secondary_user = 'user_id';
    public static $coll_primary_user = 'primary_user_id';
    public $username;
    public $name;
    public $mobile_no;
    public $email;
    public $user_status;
    public $role;
    public $district_option = [];
    public $ulb_option = [];
    public $date;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'user_id', 'primary_user_id', 'master_ulb_id', 'ulb_code', 'district_code', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'safe'],
            [['username', 'name', 'email', 'role', 'user_status', 'date'], 'safe'],
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
        $query = RelationUserUlb::find();

        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_ULB])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_RURAL_DD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DSO])) {
                $query->andWhere([RelationUserUlb::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([RelationUserUlb::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([RelationUserUlb::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_URBAN_PRIMARY_ENUMERATOR])) {
                $query->andWhere([RelationUserUlb::getTableSchema()->fullName . '.ulb_code' => \yii\helpers\ArrayHelper::getColumn($user_model->ulbs, 'ulb_code')]);
                $query->andWhere([RelationUserUlb::getTableSchema()->fullName . '.primary_user_id' => $user_model->id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_URBAN_SECONDARY_ENUMERATOR])) {
                $query->andWhere([RelationUserUlb::getTableSchema()->fullName . '.ulb_code' => \yii\helpers\ArrayHelper::getColumn($user_model->ulbs, 'ulb_code')]);
                $query->andWhere([RelationUserUlb::getTableSchema()->fullName . '.user_id' => $user_model->id]);
            } else {
                $query->where('0=1');
            }
            if ($distinct_column != null) {
                if ($distinct_column == static::$coll_secondary_user) {
                    $query->joinWith(['user']);
                    $query->select(RelationUserUlb::getTableSchema()->fullName . '.user_id,user.name,' . RelationUserUlb::getTableSchema()->fullName . '.primary_user_id,user.name');
                    $query->distinct();
                    $query->andWhere(['or',['user.role'=> MasterRole::ROLE_URBAN_PRIMARY_ENUMERATOR],['user.role'=> MasterRole::ROLE_URBAN_SECONDARY_ENUMERATOR]]);
                    $query->orderBy('user.name');
                }
            }
            if ($distinct_column != null) {
                if ($distinct_column == static::$coll_primary_user) {
                    $query->joinWith(['primaryuser']);
                    $query->select(RelationUserUlb::getTableSchema()->fullName . '.primary_user_id,user.name');
                    $query->distinct();
                    $query->andWhere(['or',['user.role'=> MasterRole::ROLE_URBAN_PRIMARY_ENUMERATOR],['user.role'=> MasterRole::ROLE_URBAN_SECONDARY_ENUMERATOR]]);
                    $query->orderBy('user.name');
                }
            }
        }

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
            'relation_user_ulb.id' => $this->id,
            'relation_user_ulb.user_id' => $this->user_id,
            'relation_user_ulb.primary_user_id' => $this->primary_user_id,
            'relation_user_ulb.master_ulb_id' => $this->master_ulb_id,
            'relation_user_ulb.ulb_code' => $this->ulb_code,
            'relation_user_ulb.district_code' => $this->district_code,
            'relation_user_ulb.created_by' => $this->created_by,
            'relation_user_ulb.updated_by' => $this->updated_by,
            'relation_user_ulb.created_at' => $this->created_at,
            'relation_user_ulb.updated_at' => $this->updated_at,
            'relation_user_ulb.status' => $this->status,
            'user.role' => $this->role,
        ]);
        $query->andFilterWhere(['like', 'user.username', $this->username])
                ->andFilterWhere(['like', 'user.mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', 'user.email', $this->email])
                ->andFilterWhere(['like', 'user.name', $this->name]);
        return $dataProvider;
    }

}
