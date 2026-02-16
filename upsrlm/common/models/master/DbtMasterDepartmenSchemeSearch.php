<?php

namespace common\models\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\master\DbtMasterDepartmenScheme;
use common\models\master\MasterRole;
/**
 * DbtMasterDepartmenSchemeSearch represents the model behind the search form of `common\models\master\DbtMasterDepartmenScheme`.
 */
class DbtMasterDepartmenSchemeSearch extends DbtMasterDepartmenScheme
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'department_id', 'status'], 'integer'],
            [['scheme_name_hi', 'scheme_name_en'], 'safe'],
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
        $query = DbtMasterDepartmenScheme::find();

        if ($columns != NULL) {
            $query->select($columns);
        }
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
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_AGRICULTURE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_AGRICULTURE_DEO])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
               
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DPRO])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DPM])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DSO])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CALL_CENTER_EXECUTIVE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
               
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
               
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BDO])) {
               
            } elseif (in_array($user_model->role, [MasterRole::ROLE_ADO])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ADHIKARI])) {

            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAACHIV])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAHAYAK])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_ROJGAR_SEVAK])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SAFAI_KARMI])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GRAM_PARDHAN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_GP_SECONDARY_ENUMERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN])) {
               
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {

            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE])) {
               
            } elseif ($user_model->id == '18123') {
                
            } else {
                $query->where('0=1');
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
            'id' => $this->id,
            'department_id' => $this->department_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'scheme_name_hi', $this->scheme_name_hi])
            ->andFilterWhere(['like', 'scheme_name_en', $this->scheme_name_en]);

        return $dataProvider;
    }
}
