<?php

namespace common\models\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\master\MasterUlb;
use common\models\master\MasterRole;

/**
 * MasterUlbSearch represents the model behind the search form of `common\models\master\MasterUlb`.
 */
class MasterUlbSearch extends MasterUlb {

    public $division_option = [];
    public $district_option = [];
    public $ulb_option = [];

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'division_code', 'district_code', 'sub_district_code', 'ulb_code', 'ulb_version', 'ulb_type_code'], 'integer'],
            [['division_name', 'district_name', 'sub_district_name', 'ulb_name', 'ulb_type_name'], 'safe'],
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
        $query = MasterUlb::find();
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_ULB])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIRECTOR_RURAL_DD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([MasterUlb::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([MasterUlb::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DSO])) {
                $query->andWhere([MasterUlb::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([MasterUlb::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                $query->andWhere([MasterUlb::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([MasterUlb::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BDO])) {
                $query->andWhere([MasterUlb::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'district.district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ADHIKARI])) {

                $query->andWhere([MasterUlb::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAACHIV])) {
                $query->andWhere([MasterUlb::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SECONDARY_ENUMERATOR])) {
                $query->andWhere([MasterUlb::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_URBAN_PRIMARY_ENUMERATOR])) {
                $query->andWhere([MasterUlb::getTableSchema()->fullName . '.ulb_code' => \yii\helpers\ArrayHelper::getColumn($user_model->ulbs, 'ulb_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_URBAN_SECONDARY_ENUMERATOR])) {
                $query->andWhere([MasterUlb::getTableSchema()->fullName . '.ulb_code' => \yii\helpers\ArrayHelper::getColumn($user_model->ulbs, 'ulb_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MC])) {
                $query->andWhere([MasterUlb::getTableSchema()->fullName . '.ulb_code' => \yii\helpers\ArrayHelper::getColumn($user_model->ulbs, 'ulb_code')]);
            } elseif ($user_model->id == '18123') {
                
            } else {
                $query->where('0=1');
            }
        }
        $query->andWhere(['!=', MasterUlb::getTableSchema()->fullName . '.district_code', '0']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['district_name' => SORT_ASC, 'ulb_name' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'master_ulb.id' => $this->id,
            'master_ulb.division_code' => $this->division_code,
            'master_ulb.district_code' => $this->district_code,
            'master_ulb.sub_district_code' => $this->sub_district_code,
            'master_ulb.ulb_code' => $this->ulb_code,
            'master_ulb.ulb_version' => $this->ulb_version,
            'master_ulb.ulb_type_code' => $this->ulb_type_code,
        ]);

        $query->andFilterWhere(['like', 'master_ulb.division_name', $this->division_name])
                ->andFilterWhere(['like', 'master_ulb.district_name', $this->district_name])
                ->andFilterWhere(['like', 'master_ulb.sub_district_name', $this->sub_district_name])
                ->andFilterWhere(['like', 'master_ulb.ulb_name', $this->ulb_name])
                ->andFilterWhere(['like', 'master_ulb.ulb_type_name', $this->ulb_type_name]);

        return $dataProvider;
    }

}
