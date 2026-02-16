<?php

namespace common\models\dynamicdb\support;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\support\ConversationDetail;

/**
 * ConversationDetailSearch represents the model behind the search form of `common\models\dynamicdb\support\ConversationDetail`.
 */
class ConversationDetailSearch extends ConversationDetail {

    public $from_date_time;
    public $to_date_time;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id'], 'safe'],
            [['conversation_code', 'stakeholder_code', 'call_type', 'calling_no', 'calling_person_name', 'calling_person_designation', 'calling_person_district', 'calling_person_block', 'calling_person_gp', 'call_response', 'comments', 'cc_executive_code', 'call_date'], 'safe'],
            [['from_date_time','to_date_time'], 'safe'],
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
    public function search($params) {
        $query = ConversationDetail::find();

        if (isset($this->from_date_time) && $this->from_date_time != '') {
            $query->andFilterWhere(['>=', 'conversation_detail.call_date', $this->from_date_time . ' 00:00:00']);
            
        }
        if (isset($this->to_date_time) && $this->to_date_time != '') {
            $query->andFilterWhere(['<=', 'conversation_detail.call_date', $this->to_date_time . ' 23:59:59']);
            
        }
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
        ]);

        $query->andFilterWhere(['=', 'conversation_code', $this->conversation_code])
                ->andFilterWhere(['=', 'stakeholder_code', $this->stakeholder_code])
                ->andFilterWhere(['like', 'call_type', $this->call_type])
                ->andFilterWhere(['like', 'calling_no', $this->calling_no])
                ->andFilterWhere(['like', 'calling_person_name', $this->calling_person_name])
                ->andFilterWhere(['like', 'calling_person_designation', $this->calling_person_designation])
                ->andFilterWhere(['like', 'calling_person_district', $this->calling_person_district])
                ->andFilterWhere(['like', 'calling_person_block', $this->calling_person_block])
                ->andFilterWhere(['like', 'calling_person_gp', $this->calling_person_gp])
                ->andFilterWhere(['like', 'call_response', $this->call_response])
                ->andFilterWhere(['like', 'comments', $this->comments])
                ->andFilterWhere(['=', 'cc_executive_code', $this->cc_executive_code]);

        return $dataProvider;
    }

}
