<?php

namespace common\models\rishta;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\rishta\RishtaNotificationLog;

/**
 * RishtaNotificationLogSearch represents the model behind the search form of `common\models\rishta\RishtaNotificationLog`.
 */
class RishtaNotificationLogSearch extends RishtaNotificationLog
{
    public $temp_option=[];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'app_id', 'visible', 'acknowledge', 'notification_template_id', 'acknowledge_status', 'send_count', 'cron_status', 'created_at', 'updated_at', 'status'], 'integer'],
            [['message_title', 'message', 'external_url', 'genrated_on', 'send_datetime', 'acknowledge_date'], 'safe'],
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
   public function search($params, $user_model = null, $pagination = true, $distinct_column = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = RishtaNotificationLog::find();

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
            RishtaNotificationLog::getTableSchema()->fullName . '.id' => $this->id,
            RishtaNotificationLog::getTableSchema()->fullName . '.user_id' => $this->user_id,
            RishtaNotificationLog::getTableSchema()->fullName . '.app_id' => $this->app_id,
            RishtaNotificationLog::getTableSchema()->fullName . '.visible' => $this->visible,
            RishtaNotificationLog::getTableSchema()->fullName . '.acknowledge' => $this->acknowledge,
            RishtaNotificationLog::getTableSchema()->fullName . '.notification_template_id' => $this->notification_template_id,
            RishtaNotificationLog::getTableSchema()->fullName . '.genrated_on' => $this->genrated_on,
            RishtaNotificationLog::getTableSchema()->fullName . '.send_datetime' => $this->send_datetime,
            RishtaNotificationLog::getTableSchema()->fullName . '.acknowledge_status' => $this->acknowledge_status,
            RishtaNotificationLog::getTableSchema()->fullName . '.acknowledge_date' => $this->acknowledge_date,
            RishtaNotificationLog::getTableSchema()->fullName . '.send_count' => $this->send_count,
            RishtaNotificationLog::getTableSchema()->fullName . '.cron_status' => $this->cron_status,
            RishtaNotificationLog::getTableSchema()->fullName . '.created_at' => $this->created_at,
            RishtaNotificationLog::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            RishtaNotificationLog::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', RishtaNotificationLog::getTableSchema()->fullName . '.message_title', $this->message_title])
            ->andFilterWhere(['like', RishtaNotificationLog::getTableSchema()->fullName . '.message', $this->message])
            ->andFilterWhere(['like', RishtaNotificationLog::getTableSchema()->fullName . '.external_url', $this->external_url]);

        return $dataProvider;
    }
}
