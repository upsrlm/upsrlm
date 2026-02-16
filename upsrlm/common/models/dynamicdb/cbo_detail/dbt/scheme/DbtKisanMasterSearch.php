<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtKisanMaster;
use common\models\master\MasterRole;
/**
 * DbtKisanMasterSearch represents the model behind the search form of `common\models\dynamicdb\cbo_detail\dbt\scheme\DbtKisanMaster`.
 */
class DbtKisanMasterSearch extends DbtKisanMaster
{
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $village_option = [];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['state_code', 'state_name', 'district_code', 'district_name', 'sub_district_code', 'sub_district_name', 'block_code', 'block_name', 'villige_code', 'village_name', 'farmer_id', 'farmer_name', 'gender', 'category', 'address', 'mobile_no', 'instalment'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = DbtKisanMaster::find();

        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_MD, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BOCW_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_AGRICULTURE_ADMIN])) {
                
                
            }else{
                $query->where('0=1');
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['id' => SORT_ASC]],
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
        ]);

        $query->andFilterWhere(['like', 'state_code', $this->state_code])
            ->andFilterWhere(['like', 'state_name', $this->state_name])
            ->andFilterWhere(['like', 'district_code', $this->district_code])
            ->andFilterWhere(['like', 'district_name', $this->district_name])
            ->andFilterWhere(['like', 'sub_district_code', $this->sub_district_code])
            ->andFilterWhere(['like', 'sub_district_name', $this->sub_district_name])
            ->andFilterWhere(['like', 'block_code', $this->block_code])
            ->andFilterWhere(['like', 'block_name', $this->block_name])
            ->andFilterWhere(['like', 'villige_code', $this->villige_code])
            ->andFilterWhere(['like', 'village_name', $this->village_name])
            ->andFilterWhere(['like', 'farmer_id', $this->farmer_id])
            ->andFilterWhere(['like', 'farmer_name', $this->farmer_name])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
            ->andFilterWhere(['like', 'instalment', $this->instalment]);

        return $dataProvider;
    }
}
