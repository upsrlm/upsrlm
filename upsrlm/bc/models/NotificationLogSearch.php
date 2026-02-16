<?php

namespace bc\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\NotificationLog;

/**
 * NotificationLogSearch represents the model behind the search form of `bc\models\NotificationLog`.
 */
class NotificationLogSearch extends NotificationLog {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'notification_type', 'notification_sub_type', 'detail_id', 'user_id', 'app_id', 'visible', 'acknowledge', 'acknowledge_status', 'send_count', 'cron_status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['message_title', 'message', 'genrated_on', 'send_datetime', 'acknowledge_date'], 'safe'],
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
        $query = NotificationLog::find();
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        if ($columns != NULL) {
            $query->select($columns);
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 5 : $pagination],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
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
            'notification_type' => $this->notification_type,
            'notification_sub_type' => $this->notification_sub_type,
            'detail_id' => $this->detail_id,
            'user_id' => $this->user_id,
            'app_id' => $this->app_id,
            'visible' => $this->visible,
            'acknowledge' => $this->acknowledge,
            'genrated_on' => $this->genrated_on,
            'send_datetime' => $this->send_datetime,
            'acknowledge_status' => $this->acknowledge_status,
            'acknowledge_date' => $this->acknowledge_date,
            'send_count' => $this->send_count,
            'cron_status' => $this->cron_status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'message_title', $this->message_title])
                ->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }

}
