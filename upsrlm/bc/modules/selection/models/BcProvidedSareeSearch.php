<?php

namespace bc\modules\selection\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\selection\models\BcProvidedSaree;
use common\models\master\MasterRole;

/**
 * BcProvidedSareeSearch represents the model behind the search form of `bc\modules\selection\models\BcProvidedSaree`.
 */
class BcProvidedSareeSearch extends BcProvidedSaree {

    public $nretp;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'bc_application_id', 'srlm_bc_selection_user_id', 'district_code', 'block_code', 'gram_panchayat_code', 'saree1_provided', 'saree1_provided_by', 'saree1_acknowledge', 'get_saree1_quality', 'get_saree1_quality_no_1', 'get_saree1_quality_no_2', 'get_saree1_quality_no_3', 'get_saree1_quality_no_4', 'get_saree1_quality_no_other', 'saree2_provided', 'saree2_provided_by', 'saree2_acknowledge', 'get_saree2_quality', 'get_saree2_quality_no_1', 'get_saree2_quality_no_2', 'get_saree2_quality_no_3', 'get_saree2_quality_no_4', 'get_saree2_quality_no_other', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['saree1_provided_date', 'saree1_provided_datetime', 'get_saree1_date', 'get_saree1_packed_new', 'get_saree1_quality_no_other_text', 'get_saree1_quality_photo', 'saree1_acknowledge_datetime', 'saree2_provided_date', 'saree2_provided_datetime', 'get_saree2_date', 'get_saree2_packed_new', 'get_saree2_quality_no_other_text', 'get_saree2_quality_photo', 'saree2_acknowledge_datetime'], 'safe'],
            [['nretp'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true, $columns = null, $select = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = BcProvidedSaree::find();
        $query->joinWith(['bc']);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPPORT_UNIT])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
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
                
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_YOUNG_PROFESSIONAL])) {

                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $query->andWhere([BcProvidedSaree::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR])) {
                $query->andWhere([BcProvidedSaree::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([BcProvidedSaree::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([BcProvidedSaree::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $query->andWhere([BcProvidedSaree::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([BcProvidedSaree::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([BcProvidedSaree::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([BcProvidedSaree::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {

                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([BcProvidedSaree::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([BcProvidedSaree::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([BcProvidedSaree::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } else {
                $query->where('0=1');
            }
            // add conditions that should always apply here
            if ($this->nretp != '') {
                $query->joinWith(['block']);
                $query->andWhere(['master_block.nretp' => $this->nretp]);
            }
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
                    //'sort' => ['defaultOrder' => ['first_name' => SORT_ASC]],
            ]);

            $this->load($params);

            if (!$this->validate()) {
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            // grid filtering conditions
            $query->andFilterWhere([
                BcProvidedSaree::getTableSchema()->fullName . '.id' => $this->id,
                BcProvidedSaree::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
                BcProvidedSaree::getTableSchema()->fullName . '.srlm_bc_selection_user_id' => $this->srlm_bc_selection_user_id,
                BcProvidedSaree::getTableSchema()->fullName . '.district_code' => $this->district_code,
                BcProvidedSaree::getTableSchema()->fullName . '.block_code' => $this->block_code,
                BcProvidedSaree::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
                BcProvidedSaree::getTableSchema()->fullName . '.saree1_provided' => $this->saree1_provided,
                BcProvidedSaree::getTableSchema()->fullName . '.saree1_provided_date' => $this->saree1_provided_date,
                BcProvidedSaree::getTableSchema()->fullName . '.saree1_provided_by' => $this->saree1_provided_by,
                BcProvidedSaree::getTableSchema()->fullName . '.saree1_provided_datetime' => $this->saree1_provided_datetime,
                BcProvidedSaree::getTableSchema()->fullName . '.saree1_acknowledge' => $this->saree1_acknowledge,
                BcProvidedSaree::getTableSchema()->fullName . '.get_saree1_date' => $this->get_saree1_date,
                BcProvidedSaree::getTableSchema()->fullName . '.get_saree1_quality' => $this->get_saree1_quality,
                BcProvidedSaree::getTableSchema()->fullName . '.get_saree1_quality_no_1' => $this->get_saree1_quality_no_1,
                BcProvidedSaree::getTableSchema()->fullName . '.get_saree1_quality_no_2' => $this->get_saree1_quality_no_2,
                BcProvidedSaree::getTableSchema()->fullName . '.get_saree1_quality_no_3' => $this->get_saree1_quality_no_3,
                BcProvidedSaree::getTableSchema()->fullName . '.get_saree1_quality_no_4' => $this->get_saree1_quality_no_4,
                BcProvidedSaree::getTableSchema()->fullName . '.get_saree1_quality_no_other' => $this->get_saree1_quality_no_other,
                BcProvidedSaree::getTableSchema()->fullName . '.saree1_acknowledge_datetime' => $this->saree1_acknowledge_datetime,
                BcProvidedSaree::getTableSchema()->fullName . '.saree2_provided' => $this->saree2_provided,
                BcProvidedSaree::getTableSchema()->fullName . '.saree2_provided_date' => $this->saree2_provided_date,
                BcProvidedSaree::getTableSchema()->fullName . '.saree2_provided_by' => $this->saree2_provided_by,
                BcProvidedSaree::getTableSchema()->fullName . '.saree2_provided_datetime' => $this->saree2_provided_datetime,
                BcProvidedSaree::getTableSchema()->fullName . '.saree2_acknowledge' => $this->saree2_acknowledge,
                BcProvidedSaree::getTableSchema()->fullName . '.get_saree2_date' => $this->get_saree2_date,
                BcProvidedSaree::getTableSchema()->fullName . '.get_saree2_quality' => $this->get_saree2_quality,
                BcProvidedSaree::getTableSchema()->fullName . '.get_saree2_quality_no_1' => $this->get_saree2_quality_no_1,
                BcProvidedSaree::getTableSchema()->fullName . '.get_saree2_quality_no_2' => $this->get_saree2_quality_no_2,
                BcProvidedSaree::getTableSchema()->fullName . '.get_saree2_quality_no_3' => $this->get_saree2_quality_no_3,
                BcProvidedSaree::getTableSchema()->fullName . '.get_saree2_quality_no_4' => $this->get_saree2_quality_no_4,
                BcProvidedSaree::getTableSchema()->fullName . '.get_saree2_quality_no_other' => $this->get_saree2_quality_no_other,
                BcProvidedSaree::getTableSchema()->fullName . '.saree2_acknowledge_datetime' => $this->saree2_acknowledge_datetime,
                BcProvidedSaree::getTableSchema()->fullName . '.created_by' => $this->created_by,
                BcProvidedSaree::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
                BcProvidedSaree::getTableSchema()->fullName . '.created_at' => $this->created_at,
                BcProvidedSaree::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
                BcProvidedSaree::getTableSchema()->fullName . '.status' => $this->status,
            ]);

            $query->andFilterWhere(['like', BcProvidedSaree::getTableSchema()->fullName . '.get_saree1_packed_new', $this->get_saree1_packed_new])
                    ->andFilterWhere(['like', BcProvidedSaree::getTableSchema()->fullName . '.get_saree1_quality_no_other_text', $this->get_saree1_quality_no_other_text])
                    ->andFilterWhere(['like', BcProvidedSaree::getTableSchema()->fullName . '.get_saree1_quality_photo', $this->get_saree1_quality_photo])
                    ->andFilterWhere(['like', BcProvidedSaree::getTableSchema()->fullName . '.get_saree2_packed_new', $this->get_saree2_packed_new])
                    ->andFilterWhere(['like', BcProvidedSaree::getTableSchema()->fullName . '.get_saree2_quality_no_other_text', $this->get_saree2_quality_no_other_text])
                    ->andFilterWhere(['like', BcProvidedSaree::getTableSchema()->fullName . '.get_saree2_quality_photo', $this->get_saree2_quality_photo]);

            return $dataProvider;
        }
    }
}
