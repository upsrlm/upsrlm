<?php

namespace cbo\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use cbo\models\CboClfMembers;
use common\models\master\MasterRole;

/**
 * CboClfMembersSearch represents the model behind the search form of `cbo\models\CboClfMembers`.
 */
class CboClfMembersSearch extends CboClfMembers {

    public $clf_option = [];
    public $vo_option = [];
    public $shg_option = [];
    public $role_option = [];
    public $district_option = [];
    public $block_option = [];
    public $district_code;
    public $block_code;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'cbo_clf_id', 'role', 'bank_operator', 'cbo_vo_id', 'cbo_vo_off_bearer', 'cbo_shg_id', 'cbo_shg_off_bearer', 'user_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'safe'],
            [['name', 'mobile_no'], 'safe'],
            [['district_code', 'block_code'], 'safe'],
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
        $query = CboClfMembers::find();
        $query->joinWith(['clf']);
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
            }elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                //$query->andWhere([CboClf::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } else {
                $query->where('0=1');
            }
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['created_at' => SORT_ASC, 'name' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            CboClfMembers::getTableSchema()->fullName . '.id' => $this->id,
            CboClfMembers::getTableSchema()->fullName . '.cbo_clf_id' => $this->cbo_clf_id,
            CboClfMembers::getTableSchema()->fullName . '.role' => $this->role,
            CboClfMembers::getTableSchema()->fullName . '.bank_operator' => $this->bank_operator,
            CboClfMembers::getTableSchema()->fullName . '.cbo_vo_id' => $this->cbo_vo_id,
            CboClfMembers::getTableSchema()->fullName . '.cbo_vo_off_bearer' => $this->cbo_vo_off_bearer,
            CboClfMembers::getTableSchema()->fullName . '.cbo_shg_id' => $this->cbo_shg_id,
            CboClfMembers::getTableSchema()->fullName . '.cbo_shg_off_bearer' => $this->cbo_shg_off_bearer,
            CboClfMembers::getTableSchema()->fullName . '.created_by' => $this->created_by,
            CboClfMembers::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            CboClfMembers::getTableSchema()->fullName . '.created_at' => $this->created_at,
            CboClfMembers::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            CboClfMembers::getTableSchema()->fullName . '.status' => $this->status,
            CboClf::getTableSchema()->fullName . '.district_code' => $this->district_code,
            CboClf::getTableSchema()->fullName . '.block_code' => $this->block_code,
        ]);

        $query->andFilterWhere(['like', CboClfMembers::getTableSchema()->fullName . '.name', $this->name])
                ->andFilterWhere(['like', CboClfMembers::getTableSchema()->fullName . '.mobile_no', $this->mobile_no]);

        return $dataProvider;
    }

}
