<?php

namespace common\models\dynamicdb\cbo_detail;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\RishtaShgMember;
use common\models\master\MasterRole;
use cbo\models\Shg;

/**
 * RishtaShgMemberSearch represents the model behind the search form of `common\models\dynamicdb\cbo_detail\RishtaShgMember`.
 */
class RishtaShgMemberSearch extends RishtaShgMember {

    public $division_code;
    public $district_code;
    public $block_code;
    public $gram_panchayat_code;
    public $village_code;
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $village_option = [];
    public $wada_option;
    public $wada;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'cbo_shg_id', 'marital_status', 'age', 'caste_category', 'duration_of_membership', 'total_saving', 'loan', 'loan_count', 'mcp_status', 'office_bearer', 'role', 'bank_account', 'relative_in_shg', 'no_of_relative', 'current_member', 'user_id', 'suggest_wada_sakhi', 'sent_for_calling', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status', 'source', 'verified', 'mobile_verified', 'bc', 'parent_id', 'ucount'], 'safe'],
            [['name', 'mobile', 'loan_amount', 'loan_date'], 'safe'],
            [['wada'], 'safe'],
            [['division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code'], 'safe'],
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
        $query = RishtaShgMember::find();
        $query->joinWith(['cboshg']);
        $query->andWhere(['rishta_shg_member.status' => 1]);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
                $query->andWhere([\cbo\models\Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_ADMIN])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_VIEWER])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
                $query->andWhere([\cbo\models\Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                //$query->andWhere([RishtaShgMember::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([\cbo\models\Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                $query->andWhere([RishtaShgMember::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                $query->andWhere([\cbo\models\Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                //$query->andWhere([RishtaShgMember::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
                if ($user_model->inbound) {
                    
                } else {
                    $query->andWhere([RishtaShgMember::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
                }
            } else {
                $query->where('0=1');
            }
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 20 : $pagination],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            RishtaShgMember::getTableSchema()->fullName . '.id' => $this->id,
            RishtaShgMember::getTableSchema()->fullName . '.cbo_shg_id' => $this->cbo_shg_id,
            RishtaShgMember::getTableSchema()->fullName . '.marital_status' => $this->marital_status,
            RishtaShgMember::getTableSchema()->fullName . '.age' => $this->age,
            RishtaShgMember::getTableSchema()->fullName . '.caste_category' => $this->caste_category,
            RishtaShgMember::getTableSchema()->fullName . '.duration_of_membership' => $this->duration_of_membership,
            RishtaShgMember::getTableSchema()->fullName . '.total_saving' => $this->total_saving,
            RishtaShgMember::getTableSchema()->fullName . '.loan' => $this->loan,
            RishtaShgMember::getTableSchema()->fullName . '.loan_count' => $this->loan_count,
            RishtaShgMember::getTableSchema()->fullName . '.loan_date' => $this->loan_date,
            RishtaShgMember::getTableSchema()->fullName . '.mcp_status' => $this->mcp_status,
            RishtaShgMember::getTableSchema()->fullName . '.office_bearer' => $this->office_bearer,
            RishtaShgMember::getTableSchema()->fullName . '.role' => $this->role,
            RishtaShgMember::getTableSchema()->fullName . '.bank_account' => $this->bank_account,
            RishtaShgMember::getTableSchema()->fullName . '.relative_in_shg' => $this->relative_in_shg,
            RishtaShgMember::getTableSchema()->fullName . '.no_of_relative' => $this->no_of_relative,
            RishtaShgMember::getTableSchema()->fullName . '.current_member' => $this->current_member,
            RishtaShgMember::getTableSchema()->fullName . '.user_id' => $this->user_id,
            RishtaShgMember::getTableSchema()->fullName . '.suggest_wada_sakhi' => $this->suggest_wada_sakhi,
            RishtaShgMember::getTableSchema()->fullName . '.sent_for_calling' => $this->sent_for_calling,
            RishtaShgMember::getTableSchema()->fullName . '.created_by' => $this->created_by,
            RishtaShgMember::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            RishtaShgMember::getTableSchema()->fullName . '.created_at' => $this->created_at,
            RishtaShgMember::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            RishtaShgMember::getTableSchema()->fullName . '.status' => $this->status,
            RishtaShgMember::getTableSchema()->fullName . '.source' => $this->source,
            RishtaShgMember::getTableSchema()->fullName . '.verified' => $this->verified,
            RishtaShgMember::getTableSchema()->fullName . '.mobile_verified' => $this->mobile_verified,
            RishtaShgMember::getTableSchema()->fullName . '.bc' => $this->bc,
            RishtaShgMember::getTableSchema()->fullName . '.parent_id' => $this->parent_id,
            RishtaShgMember::getTableSchema()->fullName . '.ucount' => $this->ucount,
            RishtaShgMember::getTableSchema()->fullName . '.division_code' => $this->division_code,
            RishtaShgMember::getTableSchema()->fullName . '.district_code' => $this->district_code,
            RishtaShgMember::getTableSchema()->fullName . '.block_code' => $this->block_code,
            RishtaShgMember::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            RishtaShgMember::getTableSchema()->fullName . '.village_code' => $this->village_code,
            \cbo\models\Shg::getTableSchema()->fullName . '.wada_shg' => $this->wada,
        ]);

        $query->andFilterWhere(['like', RishtaShgMember::getTableSchema()->fullName . '.name', $this->name])
                ->andFilterWhere(['like', RishtaShgMember::getTableSchema()->fullName . '.mobile', $this->mobile])
                ->andFilterWhere(['like', RishtaShgMember::getTableSchema()->fullName . '.loan_amount', $this->loan_amount]);

        return $dataProvider;
    }

}
