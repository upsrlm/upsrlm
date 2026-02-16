<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UpsrlmSmsLog;

/**
 * UpsrlmSmsLogSearch represents the model behind the search form of `common\models\UpsrlmSmsLog`.
 */
class UpsrlmSmsLogSearch extends UpsrlmSmsLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'upsrlm_sms_template_id', 'try_send_count', 'unicode', 'sms_length', 'created_by', 'updated_by', 'updated_at', 'created_at', 'status'], 'integer'],
            [['mobile_number', 'model', 'sms_content', 'service_provider_id', 'sms_send_time', 'delivery_status'], 'safe'],
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
        $query = UpsrlmSmsLog::find();

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
            'user_id' => $this->user_id,
            'upsrlm_sms_template_id' => $this->upsrlm_sms_template_id,
            'sms_send_time' => $this->sms_send_time,
            'try_send_count' => $this->try_send_count,
            'unicode' => $this->unicode,
            'sms_length' => $this->sms_length,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'mobile_number', $this->mobile_number])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'sms_content', $this->sms_content])
            ->andFilterWhere(['like', 'service_provider_id', $this->service_provider_id])
            ->andFilterWhere(['like', 'delivery_status', $this->delivery_status]);

        return $dataProvider;
    }
}
