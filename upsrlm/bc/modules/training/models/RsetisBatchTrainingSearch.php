<?php

namespace bc\modules\training\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\training\models\RsetisBatchTraining;
use common\models\master\MasterRole;

/**
 * BatchTrainingSearch represents the model behind the search form of `bc\modules\training\models\RsetisBatchTraining`.
 */
class RsetisBatchTrainingSearch extends RsetisBatchTraining {

    public $center_option = [];
    public $district_option = [];
    public $training_option = [];
    public $district_code;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'rsetis_center_id', 'rsetis_center_training_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['batch_name', 'district_code'], 'safe'],
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
        $query = RsetisBatchTraining::find();
        $query->andWhere(['!=', RsetisBatchTraining::getTableSchema()->fullName . '.status', -1]);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $query->andWhere([RsetisBatchTraining::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([RsetisBatchTraining::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } else {
                $query->where('0=1');
            }
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            RsetisBatchTraining::getTableSchema()->fullName . '.id' => $this->id,
            RsetisBatchTraining::getTableSchema()->fullName . '.rsetis_center_id' => $this->rsetis_center_id,
            RsetisBatchTraining::getTableSchema()->fullName . '.rsetis_center_training_id' => $this->rsetis_center_training_id,
            RsetisBatchTraining::getTableSchema()->fullName . '.created_by' => $this->created_by,
            RsetisBatchTraining::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            RsetisBatchTraining::getTableSchema()->fullName . '.created_at' => $this->created_at,
            RsetisBatchTraining::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            RsetisBatchTraining::getTableSchema()->fullName . '.status' => $this->status,
            RsetisCenter::getTableSchema()->fullName . '.district_code' => $this->district_code,
        ]);

        $query->andFilterWhere(['like', RsetisBatchTraining::getTableSchema()->fullName . '.batch_name', $this->batch_name]);

        return $dataProvider;
    }
}
