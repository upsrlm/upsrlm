<?php

namespace common\models\dynamicdb\cbo_detail;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\DbtGovermentOrder;

/**
 * DbtGovermentOrderSearch represents the model behind the search form of `common\models\dynamicdb\cbo_detail\DbtGovermentOrder`.
 */
class DbtGovermentOrderSearch extends DbtGovermentOrder {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'goverment_order_department', 'upload_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['goverment_order_number', 'goverment_order_topic', 'goverment_order_date', 'file_name', 'file_size', 'file_type', 'upload_datetime'], 'safe'],
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
        $query = DbtGovermentOrder::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 40 : $pagination],
            'sort' => ['defaultOrder' => ['goverment_order_date' => SORT_DESC]],
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
            'goverment_order_date' => $this->goverment_order_date,
            'goverment_order_department' => $this->goverment_order_department,
            'upload_by' => $this->upload_by,
            'upload_datetime' => $this->upload_datetime,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'goverment_order_number', $this->goverment_order_number])
                ->andFilterWhere(['like', 'goverment_order_topic', $this->goverment_order_topic])
                ->andFilterWhere(['like', 'file_name', $this->file_name])
                ->andFilterWhere(['like', 'file_size', $this->file_size])
                ->andFilterWhere(['like', 'file_type', $this->file_type]);

        return $dataProvider;
    }
}
