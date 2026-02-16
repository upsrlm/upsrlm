<?php

namespace common\models\rishta;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\rishta\RishtaNotificationLogFirebaseDetail;

/**
 * RishtaNotificationLogFirebaseDetailSearch represents the model behind the search form of `common\models\rishta\RishtaNotificationLogFirebaseDetail`.
 */
class RishtaNotificationLogFirebaseDetailSearch extends RishtaNotificationLogFirebaseDetail {

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
    public function search($params, $user_model = null, $pagination = true, $distinct_column = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = RishtaNotificationLogFirebaseDetail::find();

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
            RishtaNotificationLogFirebaseDetail::getTableSchema()->fullName . '.id' => $this->id,
            RishtaNotificationLogFirebaseDetail::getTableSchema()->fullName . '.notification_log_id' => $this->notification_log_id,
            RishtaNotificationLogFirebaseDetail::getTableSchema()->fullName . '.create_on' => $this->create_on,
        ]);

        $query->andFilterWhere(['like', RishtaNotificationLogFirebaseDetail::getTableSchema()->fullName . '.firebase_id', $this->firebase_id])
                ->andFilterWhere(['like', RishtaNotificationLogFirebaseDetail::getTableSchema()->fullName . '.firebase_message', $this->firebase_message]);

        return $dataProvider;
    }

}
