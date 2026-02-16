<?php

namespace common\models\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\master\GramPradhans;
use common\models\master\MasterRole;
/**
 * GramPradhansSearch represents the model behind the search form of `common\models\master\GramPradhans`.
 */
class GramPradhansSearch extends GramPradhans
{
    public $division_option = [];
    public $district_option = [];
    public $block_option = [];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'district_code', 'block_code', 'gp_code', 'role', 'user_id', 'status', 'mobile_change', 'sahayak', 'match_mobile', 'digital_name_confirm', 'digital_mobile_confirm', 'phone_type', 'mobile_you_always_have', 'digital_verification_status', 'digital_verification_by', 'mobile_status', 'ctc_click_count', 'ibd', 'ibd_date', 'ibd_datetime', 'cloud_tele_api_log', 'calling_agent_id'], 'integer'],
            [['S.No', 'zp_name', 'bp_name', 'gp_name', 'pradhan_name', 'mobile_number', 'old_mobile_no', 'name', 'mobile_no', 'whatsapp_no', 'digital_verification_datetime'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
    public function search($params, $user_model = null, $pagination = true, $columns = null, $array = false) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = GramPradhans::find();
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
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_PANCHAYATI_RAJ])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BOCW_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $query->andWhere([GramPradhans::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([GramPradhans::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([GramPradhans::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([GramPradhans::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([GramPradhans::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DSO])) {
                $query->andWhere([GramPradhans::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([GramPradhans::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([GramPradhans::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([GramPradhans::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                $query->andWhere([GramPradhans::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BDO])) {
                $query->andWhere([GramPradhans::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([GramPradhans::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ADHIKARI])) {

                $query->andWhere([GramPradhans::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAACHIV])) {
                $query->andWhere([GramPradhans::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAHAYAK])) {
                $query->andWhere([GramPradhans::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ROJGAR_SEVAK])) {
                $query->andWhere([GramPradhans::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAFAI_KARMI])) {
                $query->andWhere([GramPradhans::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GRAM_PARDHAN])) {
                $query->andWhere([GramPradhans::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SECONDARY_ENUMERATOR])) {
                $query->andWhere([GramPradhans::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->grampanchayat, 'block_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN])) {
               
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_ADMIN])) {
               
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {

                if ($user_model->inbound) {
                    
                } else {
                    
                }
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR])) {
               
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
               
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE])) {
                
            } elseif ($user_model->id == '18123') {
                
            } else {
                $query->where('0=1');
            }
            
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['pradhan_name' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            GramPradhans::getTableSchema()->fullName . '.id' => $this->id,
            GramPradhans::getTableSchema()->fullName . '.district_code' => $this->district_code,
            GramPradhans::getTableSchema()->fullName . '.block_code' => $this->block_code,
            GramPradhans::getTableSchema()->fullName . '.gp_code' => $this->gp_code,
            GramPradhans::getTableSchema()->fullName . '.role' => $this->role,
            GramPradhans::getTableSchema()->fullName . '.user_id' => $this->user_id,
            GramPradhans::getTableSchema()->fullName . '.status' => $this->status,
            GramPradhans::getTableSchema()->fullName . '.mobile_change' => $this->mobile_change,
            GramPradhans::getTableSchema()->fullName . '.sahayak' => $this->sahayak,
            GramPradhans::getTableSchema()->fullName . '.match_mobile' => $this->match_mobile,
            GramPradhans::getTableSchema()->fullName . '.digital_name_confirm' => $this->digital_name_confirm,
            GramPradhans::getTableSchema()->fullName . '.digital_mobile_confirm' => $this->digital_mobile_confirm,
            GramPradhans::getTableSchema()->fullName . '.phone_type' => $this->phone_type,
            GramPradhans::getTableSchema()->fullName . '.mobile_you_always_have' => $this->mobile_you_always_have,
            GramPradhans::getTableSchema()->fullName . '.digital_verification_status' => $this->digital_verification_status,
            GramPradhans::getTableSchema()->fullName . '.digital_verification_by' => $this->digital_verification_by,
            GramPradhans::getTableSchema()->fullName . '.digital_verification_datetime' => $this->digital_verification_datetime,
            GramPradhans::getTableSchema()->fullName . '.mobile_status' => $this->mobile_status,
            GramPradhans::getTableSchema()->fullName . '.ctc_click_count' => $this->ctc_click_count,
            GramPradhans::getTableSchema()->fullName . '.ibd' => $this->ibd,
            GramPradhans::getTableSchema()->fullName . '.ibd_date' => $this->ibd_date,
            GramPradhans::getTableSchema()->fullName . '.ibd_datetime' => $this->ibd_datetime,
            GramPradhans::getTableSchema()->fullName . '.cloud_tele_api_log' => $this->cloud_tele_api_log,
            GramPradhans::getTableSchema()->fullName . '.calling_agent_id' => $this->calling_agent_id,
        ]);

        $query->andFilterWhere(['like', GramPradhans::getTableSchema()->fullName . '.S.No', $this->S.No])
            ->andFilterWhere(['like', GramPradhans::getTableSchema()->fullName . '.zp_name', $this->zp_name])
            ->andFilterWhere(['like', GramPradhans::getTableSchema()->fullName . '.bp_name', $this->bp_name])
            ->andFilterWhere(['like', GramPradhans::getTableSchema()->fullName . '.gp_name', $this->gp_name])
            ->andFilterWhere(['like', GramPradhans::getTableSchema()->fullName . '.pradhan_name', $this->pradhan_name])
            ->andFilterWhere(['like', GramPradhans::getTableSchema()->fullName . '.mobile_number', $this->mobile_number])
            ->andFilterWhere(['like', GramPradhans::getTableSchema()->fullName . '.old_mobile_no', $this->old_mobile_no])
            ->andFilterWhere(['like', GramPradhans::getTableSchema()->fullName . '.name', $this->name])
            ->andFilterWhere(['like', GramPradhans::getTableSchema()->fullName . '.mobile_no', $this->mobile_no])
            ->andFilterWhere(['like', GramPradhans::getTableSchema()->fullName . '.whatsapp_no', $this->whatsapp_no]);

        return $dataProvider;
    }
}
