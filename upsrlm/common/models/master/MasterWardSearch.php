<?php

namespace common\models\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\master\MasterWard;
use common\models\master\MasterRole;

/**
 * MasterWardSearch represents the model behind the search form of `common\models\master\MasterWard`.
 */
class MasterWardSearch extends MasterWard {

    public $division_option = [];
    public $district_option = [];
    public $ward_option = [];
    public $ulb_option = [];

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'division_code', 'district_code', 'sub_district_code', 'ulb_code', 'ward_code', 'ward_number'], 'integer'],
            [['division_name', 'district_name', 'sub_district_name', 'ulb_name', 'ward_name'], 'safe'],
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
        $query = MasterWard::find();
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_ULB])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_RURAL_DD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([MasterWard::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([MasterWard::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DSO])) {
                $query->andWhere([MasterWard::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([MasterWard::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([MasterWard::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BDO])) {
                $query->andWhere([MasterWard::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ADHIKARI])) {

                $query->andWhere([MasterWard::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAACHIV])) {
                $query->andWhere([MasterWard::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SECONDARY_ENUMERATOR])) {
                $query->andWhere([MasterWard::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_URBAN_PRIMARY_ENUMERATOR])) {
                $query->andWhere([MasterWard::getTableSchema()->fullName . '.ulb_code' => \yii\helpers\ArrayHelper::getColumn($user_model->ulbs, 'ulb_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_URBAN_SECONDARY_ENUMERATOR])) {
                $query->andWhere([MasterWard::getTableSchema()->fullName . '.ulb_code' => \yii\helpers\ArrayHelper::getColumn($user_model->ulbs, 'ulb_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MC])) {
                $query->andWhere([MasterWard::getTableSchema()->fullName . '.ulb_code' => \yii\helpers\ArrayHelper::getColumn($user_model->ulbs, 'ulb_code')]);
            } elseif ($user_model->id == '18123') {
                
            } else {
                $query->where('0=1');
            }
        }
        $query->andWhere(['!=', MasterWard::getTableSchema()->fullName . '.district_code', '0']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['ward_name' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'master_ward.id' => $this->id,
            'master_ward.division_code' => $this->division_code,
            'master_ward.district_code' => $this->district_code,
            'master_ward.sub_district_code' => $this->sub_district_code,
            'master_ward.ulb_code' => $this->ulb_code,
            'master_ward.ward_code' => $this->ward_code,
            'master_ward.ward_number' => $this->ward_number,
        ]);

        $query->andFilterWhere(['like', 'master_ward.division_name', $this->division_name])
                ->andFilterWhere(['like', 'master_ward.district_name', $this->district_name])
                ->andFilterWhere(['like', 'master_ward.sub_district_name', $this->sub_district_name])
                ->andFilterWhere(['like', 'master_ward.ulb_name', $this->ulb_name])
                ->andFilterWhere(['like', 'master_ward.ward_name', $this->ward_name]);

        return $dataProvider;
    }

}
