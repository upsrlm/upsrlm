<?php

namespace common\models\dynamicdb\cbo_detail;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\cbo_detail\RishtaShgFundReceived;

/**
 * RishtaShgFundReceivedSearch represents the model behind the search form of `common\models\dynamicdb\cbo_detail\RishtaShgFundReceived`.
 */
class RishtaShgFundReceivedSearch extends RishtaShgFundReceived
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cbo_shg_id', 'fund_type', 'received_from', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'safe'],
            [['date_of_receipt'], 'safe'],
            [['amount_received'], 'safe'],
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
        $query = RishtaShgFundReceived::find();

        // add conditions that should always apply here

         $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 20 : $pagination],
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
            'cbo_shg_id' => $this->cbo_shg_id,
            'fund_type' => $this->fund_type,
            'received_from' => $this->received_from,
            'date_of_receipt' => $this->date_of_receipt,
            'amount_received' => $this->amount_received,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
