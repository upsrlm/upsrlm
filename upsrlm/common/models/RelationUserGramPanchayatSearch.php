<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RelationUserGramPanchayat;
use common\models\master\MasterRole;

/**
 * RelationUserGramPanchayatSearch represents the model behind the search form of `app\models\RelationUserGramPanchayat`.
 */
class RelationUserGramPanchayatSearch extends RelationUserGramPanchayat {

    public static $coll_district = 'district_code';
    public static $coll_block = 'block_code';
    public static $coll_gram_panchayat = 'gram_panchayat_id';
    public static $coll_secondary_user = 'user_id';
    public static $coll_primary_user = 'primary_user_id';
    public $username;
    public $name;
    public $mobile_no;
    public $email;
    public $role;
    public $date;
    public $user_status;
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $village_option = [];

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'user_id', 'primary_user_id', 'master_gram_panchayat_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'safe'],
            [['gram_panchayat_code', 'block_code', 'district_code', 'role'], 'safe'],
            [['username', 'name', 'email', 'role', 'user_status','date'], 'safe'],
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
        $query = RelationUserGramPanchayat::find();

        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_ULB])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_RURAL_DD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DSO])) {
                $query->andWhere([RelationUserGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([RelationUserGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([RelationUserGramPanchayat::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BDO])) {
                $query->andWhere([RelationUserGramPanchayat::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ADHIKARI])) {
                $query->andWhere([RelationUserGramPanchayat::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
                $query->andWhere([RelationUserGramPanchayat::getTableSchema()->fullName . '.primary_user_id' => $user_model->id]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAACHIV])) {
                $query->andWhere([RelationUserGramPanchayat::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
                $query->andWhere([RelationUserGramPanchayat::getTableSchema()->fullName . '.primary_user_id' => $user_model->id]);
            } else {
                $query->where('0=1');
            }
            if ($distinct_column != null) {
                if ($distinct_column == static::$coll_secondary_user) {
                    $query->joinWith(['user']);
                    $query->select(RelationUserGramPanchayat::getTableSchema()->fullName . '.user_id,user.name,'.RelationUserGramPanchayat::getTableSchema()->fullName . '.primary_user_id');
                    $query->distinct();
                    $query->orderBy('user.name');
                }
            }
            if ($distinct_column != null) {
                if ($distinct_column == static::$coll_primary_user) {
                    $query->joinWith(['primaryuser']);
                    $query->select(RelationUserGramPanchayat::getTableSchema()->fullName . '.primary_user_id,user.name');
                    $query->distinct();
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
            'relation_user_gram_panchayat.user_id' => $this->user_id,
            'relation_user_gram_panchayat.primary_user_id' => $this->primary_user_id,
            'relation_user_gram_panchayat.master_gram_panchayat_id' => $this->master_gram_panchayat_id,
            'relation_user_gram_panchayat.district_code' => $this->district_code,
            'relation_user_gram_panchayat.block_code' => $this->block_code,
            'relation_user_gram_panchayat.district_code' => $this->district_code,
            'relation_user_gram_panchayat.created_by' => $this->created_by,
            'relation_user_gram_panchayat.updated_by' => $this->updated_by,
            'relation_user_gram_panchayat.created_at' => $this->created_at,
            'relation_user_gram_panchayat.updated_at' => $this->updated_at,
            'relation_user_gram_panchayat.status' => $this->status,
            'user.role' => $this->role,
        ]);
        $query->andFilterWhere(['like', 'user.username', $this->username])
                ->andFilterWhere(['like', 'user.mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', 'user.email', $this->email])
                ->andFilterWhere(['like', 'user.name', $this->name]);
        return $dataProvider;
    }

}
