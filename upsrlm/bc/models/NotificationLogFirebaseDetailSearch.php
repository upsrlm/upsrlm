<?php

namespace bc\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\NotificationLogFirebaseDetail;

/**
 * NotificationLogFirebaseDetailSearch represents the model behind the search form of `bc\models\NotificationLogFirebaseDetail`.
 */
class NotificationLogFirebaseDetailSearch extends NotificationLogFirebaseDetail {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'notification_log_id'], 'integer'],
            [['firebase_id', 'firebase_message', 'create_on'], 'safe'],
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
        $query = NotificationLogFirebaseDetail::find();

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
            'id' => $this->id,
            'notification_log_id' => $this->notification_log_id,
            'create_on' => $this->create_on,
        ]);

        $query->andFilterWhere(['like', 'firebase_id', $this->firebase_id])
                ->andFilterWhere(['like', 'firebase_message', $this->firebase_message]);

        return $dataProvider;
    }

}
