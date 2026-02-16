<?php

namespace common\models\dynamicdb\internalcallcenter;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\internalcallcenter\UltraPoorCloudTeleUserMontlyReport;

/**
 * UltraPoorCloudTeleUserMontlyReportSearch represents the model behind the search form of `common\models\dynamicdb\internalcallcenter\UltraPoorCloudTeleUserMontlyReport`.
 */
class UltraPoorCloudTeleUserMontlyReportSearch extends UltraPoorCloudTeleUserMontlyReport
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'role', 'month_id', 'no_of_call', 'no_of_ctc_call', 'no_of_ibd_call', 'total_time', 'ctc_time', 'ibd_time', 'ivr_time', 'created_at', 'updated_at'], 'integer'],
            [['name', 'mobile_no', 'month_start_date', 'month_end_date', 'total_time_text', 'ctc_time_text', 'ibd_time_text', 'ivr_time_text'], 'safe'],
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
        $query = UltraPoorCloudTeleUserMontlyReport::find();

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
            'role' => $this->role,
            'month_id' => $this->month_id,
            'month_start_date' => $this->month_start_date,
            'month_end_date' => $this->month_end_date,
            'no_of_call' => $this->no_of_call,
            'no_of_ctc_call' => $this->no_of_ctc_call,
            'no_of_ibd_call' => $this->no_of_ibd_call,
            'total_time' => $this->total_time,
            'ctc_time' => $this->ctc_time,
            'ibd_time' => $this->ibd_time,
            'ivr_time' => $this->ivr_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
            ->andFilterWhere(['like', 'total_time_text', $this->total_time_text])
            ->andFilterWhere(['like', 'ctc_time_text', $this->ctc_time_text])
            ->andFilterWhere(['like', 'ibd_time_text', $this->ibd_time_text])
            ->andFilterWhere(['like', 'ivr_time_text', $this->ivr_time_text]);

        return $dataProvider;
    }
}
