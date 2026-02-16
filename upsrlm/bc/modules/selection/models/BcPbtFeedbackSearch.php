<?php

namespace bc\modules\selection\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\selection\models\BcPbtFeedback;
use common\models\master\MasterRole;

/**
 * BcPbtFeedbackSearch represents the model behind the search form of `bc\modules\selection\models\BcPbtFeedback`.
 */
class BcPbtFeedbackSearch extends BcPbtFeedback {

    public $division_option = [];
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $village_option = [];
    public $q1_option=[];
    public $q2_option=[];
    public $q3_option=[];
    public $q4_option=[];
    public $bank_option = [];
    public $division_code;
    public $district_code;
    public $block_code;
    public $gram_panchayat_code;
    public $master_partner_bank_id;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'bc_application_id', 'srlm_bc_selection_user_id', 'user_id', 'ques_1', 'ques_2', 'ques_3', 'ques_4', 'ques_5', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['division_code', 'district_code', 'block_code', 'gram_panchayat_code'], 'safe'],
            [['master_partner_bank_id'], 'safe'],
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
        $query = BcPbtFeedback::find();
        $query->joinWith(['bcapplication']);
        if ($user_model == NULL) {
//            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {

                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {

                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {

                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {

//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_YOUNG_PROFESSIONAL])) {

                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } else {
                $query->where('0=1');
            }

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);

            $this->load($params);

            if (!$this->validate()) {
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            // grid filtering conditions
            $query->andFilterWhere([
                BcPbtFeedback::getTableSchema()->fullName . '.id' => $this->id,
                BcPbtFeedback::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
                BcPbtFeedback::getTableSchema()->fullName . '.srlm_bc_selection_user_id' => $this->srlm_bc_selection_user_id,
                BcPbtFeedback::getTableSchema()->fullName . '.user_id' => $this->user_id,
                BcPbtFeedback::getTableSchema()->fullName . '.ques_1' => $this->ques_1,
                BcPbtFeedback::getTableSchema()->fullName . '.ques_2' => $this->ques_2,
                BcPbtFeedback::getTableSchema()->fullName . '.ques_3' => $this->ques_3,
                BcPbtFeedback::getTableSchema()->fullName . '.ques_4' => $this->ques_4,
                BcPbtFeedback::getTableSchema()->fullName . '.ques_5' => $this->ques_5,
                BcPbtFeedback::getTableSchema()->fullName . '.created_by' => $this->created_by,
                BcPbtFeedback::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
                BcPbtFeedback::getTableSchema()->fullName . '.created_at' => $this->created_at,
                BcPbtFeedback::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
                BcPbtFeedback::getTableSchema()->fullName . '.status' => $this->status,
                SrlmBcApplication::getTableSchema()->fullName . '.division_code' => $this->division_code,
                SrlmBcApplication::getTableSchema()->fullName . '.district_code' => $this->district_code,
                SrlmBcApplication::getTableSchema()->fullName . '.block_code' => $this->block_code,
                SrlmBcApplication::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
                SrlmBcApplication::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            ]);

            return $dataProvider;
        }
    }

}
