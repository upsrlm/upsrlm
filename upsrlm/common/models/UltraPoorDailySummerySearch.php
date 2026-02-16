<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UltraPoorDailySummery;

/**
 * UltraPoorDailySummerySearch represents the model behind the search form of `common\models\UltraPoorDailySummery`.
 */
class UltraPoorDailySummerySearch extends UltraPoorDailySummery
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_add', 'form_submit', 'form_return', 'form_verify', 'text_sms_send', 'voice_sms_send', 'call_attempt', 'call_talk', 'created_at', 'updated_at'], 'integer'],
            [['date'], 'safe'],
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
     public function search($params, $user_model = null, $pagination = true, $select = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = UltraPoorDailySummery::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['date' => SORT_DESC]],
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
            'date' => $this->date,
            'user_add' => $this->user_add,
            'form_submit' => $this->form_submit,
            'form_return' => $this->form_return,
            'form_verify' => $this->form_verify,
            'text_sms_send' => $this->text_sms_send,
            'voice_sms_send' => $this->voice_sms_send,
            'call_attempt' => $this->call_attempt,
            'call_talk' => $this->call_talk,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
