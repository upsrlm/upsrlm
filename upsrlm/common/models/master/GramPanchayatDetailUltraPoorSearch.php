<?php

namespace common\models\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\master\GramPanchayatDetailUltraPoor;
use common\models\master\MasterRole;
use yii\db\Expression;
/**
 * GramPanchayatDetailUltraPoorSearch represents the model behind the search form of `common\models\master\GramPanchayatDetailUltraPoor`.
 */
class GramPanchayatDetailUltraPoorSearch extends GramPanchayatDetailUltraPoor {

    public $division_option = [];
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $gram_pardhan_sahayak;
    public $gram_pardhan_sahayak_login;
    public $gram_pardhan_sahayak_add_no_user;
    public $aspirational;
    public $gram_pardhan_verify_hhs_group;
    public static $coll_district = 'district_code';
    public static $coll_block = 'block_code';

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'gram_panchayat_code', 'block_code', 'district_code', 'gram_pardhan', 'gram_pardhan_login', 'gram_pardhan_add_no_user', 'no_of_user', 'no_of_user_login', 'hhs_enumerated', 'hhs_enumerated_old', 'hhs_enumerated_mopup', 'gram_pardhan_return_hhs', 'gram_pardhan_verify_hhs', 'gram_pardhan_remain_verification', 'hhs_in_save_mode', 'digital_hhs_attempt', 'digital_hhs_remain_attempt', 'digital_hhs_verified', 'digital_hhs_unverified', 'digital_hhs_has_smartphone', 'digital_hhs_wrong_mobile_no', 'digital_hhs_wrong_mobile_no_does_not_exist', 'gp_covert_urban', 'updated_at', 'status'], 'integer'],
            [['gram_panchayat_name'], 'safe'],
            [['gram_pardhan_sahayak', 'gram_pardhan_sahayak_login', 'gram_pardhan_sahayak_add_no_user'], 'safe'],
            [['aspirational'],'safe'],
            [['gram_pardhan_verify_hhs_group'],'safe']
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
    public function search($params, $user_model = null, $pagination = true, $columns = null, $distinct_column = false) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = GramPanchayatDetailUltraPoor::find();
        $query->joinWith(['gp','block']);
        $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.status' => 1]);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_ULTRA_POOR_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_HR_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_ULB])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_RURAL_DD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_STATE_UNIT])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_PANCHAYATI_RAJ])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAACHIV])) {
                $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAHAYAK])) {
                $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ROJGAR_SEVAK])) {
                $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAFAI_KARMI])) {
                $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GRAM_PARDHAN])) {
                $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SECONDARY_ENUMERATOR])) {
                $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_panchayat_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'gram_panchayat_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {

                if ($user_model->inbound) {
                    
                } else {
                    
                }
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE])) {
                
            } elseif ($user_model->id == '18123') {
                
            } else {
                $query->where('0=1');
            }
        }
         if ($this->aspirational != ''){
            $query->andWhere([MasterBlock::getTableSchema()->fullName . '.aspirational' => $this->aspirational]);
        }
        // add conditions that should always apply here
        if ($this->hhs_enumerated_mopup != '') {
            if ($this->hhs_enumerated_mopup == 0) {
                $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.hhs_enumerated_mopup' => 0]);
            }
            if ($this->hhs_enumerated_mopup == 1) {
                $query->andWhere(['>', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.hhs_enumerated_mopup', 0]);
            }
        }
        if ($this->gram_pardhan_verify_hhs != '') {
            if ($this->gram_pardhan_verify_hhs == 0) {
                $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan_verify_hhs' => 0]);
            }
            if ($this->gram_pardhan_verify_hhs == 1) {
                $query->andWhere(['>', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan_verify_hhs', 0]);
            }
        }
        if ($this->gram_pardhan_add_no_user != '') {
            if ($this->gram_pardhan_add_no_user == 0) {
                $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan_add_no_user' => 0]);
            }
            if ($this->gram_pardhan_add_no_user == 1) {
                $query->andWhere(['>', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan_add_no_user', 0]);
            }
        }
        if ($this->no_of_user_login != '') {
            if ($this->gram_pardhan_add_no_user == 0) {
                $query->andWhere([GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.no_of_user_login' => 0]);
            }
            if ($this->gram_pardhan_add_no_user == 1) {
                $query->andWhere(['>', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.no_of_user_login', 0]);
            }
        }
        if ($this->gram_pardhan_verify_hhs_group != '') {
            if ($this->gram_pardhan_verify_hhs_group == '0') {
                $query->andWhere(['between', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan_verify_hhs', '0', '0']);
            } elseif ($this->gram_pardhan_verify_hhs_group == '1') {
                $query->andWhere(['between', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan_verify_hhs', '1', '9']);
            } else if ($this->gram_pardhan_verify_hhs_group == '2') {
                $query->andWhere(['between', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan_verify_hhs', '10', '25']);
            } else if ($this->gram_pardhan_verify_hhs_group == '3') {
                $query->andWhere(['>', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_pardhan_verify_hhs', '25']);
            }
        }
        if ($distinct_column != null) {
            if ($distinct_column == static::$coll_district) {
                $query->select(['master_gram_panchayat.district_code', 'master_gram_panchayat.district_name', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_panchayat_code', new Expression('SUM(hhs_enumerated) as hhs_enumerated'), new Expression('SUM(gram_pardhan) as gram_pardhan'), new Expression('SUM(gram_pardhan_go_contact) as gram_pardhan_go_contact'), new Expression('SUM(gram_pardhan_login) as gram_pardhan_login'), new Expression('SUM(gram_pardhan_add_no_user) as gram_pardhan_add_no_user'), new Expression('SUM(sahayak) as sahayak'), new Expression('SUM(sahayak_go_contact) as sahayak_go_contact'), new Expression('SUM(sahayak_login) as sahayak_login'), new Expression('SUM(sahayak_add_no_user) as sahayak_add_no_user'), new Expression('SUM(no_of_user_login) as no_of_user_login'), new Expression('SUM(gram_pardhan_return_hhs) as gram_pardhan_return_hhs'), new Expression('SUM(gram_pardhan_verify_hhs) as gram_pardhan_verify_hhs'), new Expression('SUM(gram_pardhan_remain_verification) as gram_pardhan_remain_verification')]);

                $query->groupBy('master_gram_panchayat.district_code');
                $query->orderBy('master_gram_panchayat.district_name asc');
            }

            if ($distinct_column == static::$coll_block) {
                $query->select(['master_gram_panchayat.district_code', 'master_gram_panchayat.district_name', 'master_gram_panchayat.block_code', 'master_gram_panchayat.block_name', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_panchayat_code', new Expression('SUM(hhs_enumerated) as hhs_enumerated'), new Expression('SUM(gram_pardhan) as gram_pardhan'), new Expression('SUM(gram_pardhan_go_contact) as gram_pardhan_go_contact'), new Expression('SUM(gram_pardhan_login) as gram_pardhan_login'), new Expression('SUM(gram_pardhan_add_no_user) as gram_pardhan_add_no_user'), new Expression('SUM(sahayak) as sahayak'), new Expression('SUM(sahayak_go_contact) as sahayak_go_contact'), new Expression('SUM(sahayak_login) as sahayak_login'), new Expression('SUM(sahayak_add_no_user) as sahayak_add_no_user'), new Expression('SUM(no_of_user_login) as no_of_user_login'), new Expression('SUM(gram_pardhan_return_hhs) as gram_pardhan_return_hhs'), new Expression('SUM(gram_pardhan_verify_hhs) as gram_pardhan_verify_hhs'), new Expression('SUM(gram_pardhan_remain_verification) as gram_pardhan_remain_verification')]);
                $query->groupBy('master_gram_panchayat.block_code');
                $query->orderBy(['master_gram_panchayat.district_name' => SORT_ASC, 'master_gram_panchayat.block_name' => SORT_ASC]);
            }
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.id' => $this->id,
            GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.block_code' => $this->block_code,
            GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.district_code' => $this->district_code,
            'gram_pardhan' => $this->gram_pardhan,
            'gram_pardhan_login' => $this->gram_pardhan_login,
            'no_of_user_login' => $this->no_of_user_login,
            'hhs_enumerated' => $this->hhs_enumerated,
            'hhs_enumerated_old' => $this->hhs_enumerated_old,
            'gram_pardhan_return_hhs' => $this->gram_pardhan_return_hhs,
            //'gram_pardhan_verify_hhs' => $this->gram_pardhan_verify_hhs,
            'gram_pardhan_remain_verification' => $this->gram_pardhan_remain_verification,
            'hhs_in_save_mode' => $this->hhs_in_save_mode,
            'digital_hhs_attempt' => $this->digital_hhs_attempt,
            'digital_hhs_remain_attempt' => $this->digital_hhs_remain_attempt,
            'digital_hhs_verified' => $this->digital_hhs_verified,
            'digital_hhs_unverified' => $this->digital_hhs_unverified,
            'digital_hhs_has_smartphone' => $this->digital_hhs_has_smartphone,
            'digital_hhs_wrong_mobile_no' => $this->digital_hhs_wrong_mobile_no,
            'digital_hhs_wrong_mobile_no_does_not_exist' => $this->digital_hhs_wrong_mobile_no_does_not_exist,
            GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gp_covert_urban' => $this->gp_covert_urban,
            GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', GramPanchayatDetailUltraPoor::getTableSchema()->fullName . '.gram_panchayat_name', $this->gram_panchayat_name]);

        return $dataProvider;
    }
}
