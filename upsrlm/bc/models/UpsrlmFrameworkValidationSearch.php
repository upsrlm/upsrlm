<?php

namespace bc\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\UpsrlmFrameworkValidation;

/**
 * UpsrlmFrameworkValidationSearch represents the model behind the search form of `bc\models\UpsrlmFrameworkValidation`.
 */
class UpsrlmFrameworkValidationSearch extends UpsrlmFrameworkValidation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'key_id', 'deliverables_id', 'start_date', 'operational_stage', 'current_status', 'validation_by', 'validation_status', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['validation_datetime'], 'safe'],
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
    public function search($params)
    {
        $query = UpsrlmFrameworkValidation::find();

        // add conditions that should always apply here

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
            'id' => $this->id,
            'key_id' => $this->key_id,
            'deliverables_id' => $this->deliverables_id,
            'start_date' => $this->start_date,
            'operational_stage' => $this->operational_stage,
            'current_status' => $this->current_status,
            'validation_by' => $this->validation_by,
            'validation_status' => $this->validation_status,
            'validation_datetime' => $this->validation_datetime,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
