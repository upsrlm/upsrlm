<?php

namespace common\models\rishta;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\rishta\RishtaSmsLog;

/**
 * RishtaSmsLogSearch represents the model behind the search form of `common\models\rishta\RishtaSmsLog`.
 */
class RishtaSmsLogSearch extends RishtaSmsLog {

    public $tempplate_option = [];
    public $from_date_time;
    public $to_date_time;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'user_id', 'rishta_sms_template_id', 'try_send_count', 'unicode', 'sms_length', 'sms_provider_campaign_id', 'sms_provider_code', 'created_by', 'updated_by', 'updated_at', 'created_at', 'status'], 'integer'],
            [['mobile_number', 'model', 'sms_content', 'sms_send_time', 'delivery_status', 'sms_provider_message_id', 'sms_provider_msg', 'sms_provider_msg_text'], 'safe'],
            [['from_date_time', 'to_date_time'], 'safe'],
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
        $query = RishtaSmsLog::find();

        if (isset($this->from_date_time) && $this->from_date_time != '') {
            $query->andFilterWhere(['>=', RishtaSmsLog::getTableSchema()->fullName . '.sms_send_time', $this->from_date_time . ' 00:00:00']);
        }
        if (isset($this->to_date_time) && $this->to_date_time != '') {
            $query->andFilterWhere(['<=', RishtaSmsLog::getTableSchema()->fullName . '.sms_send_time', $this->to_date_time . ' 23:59:59']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
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
            RishtaSmsLog::getTableSchema()->fullName . '.id' => $this->id,
            RishtaSmsLog::getTableSchema()->fullName . '.user_id' => $this->user_id,
            RishtaSmsLog::getTableSchema()->fullName . '.rishta_sms_template_id' => $this->rishta_sms_template_id,
            RishtaSmsLog::getTableSchema()->fullName . '.sms_send_time' => $this->sms_send_time,
            RishtaSmsLog::getTableSchema()->fullName . '.try_send_count' => $this->try_send_count,
            RishtaSmsLog::getTableSchema()->fullName . '.unicode' => $this->unicode,
            RishtaSmsLog::getTableSchema()->fullName . '.sms_length' => $this->sms_length,
            RishtaSmsLog::getTableSchema()->fullName . '.sms_provider_campaign_id' => $this->sms_provider_campaign_id,
            RishtaSmsLog::getTableSchema()->fullName . '.sms_provider_code' => $this->sms_provider_code,
            RishtaSmsLog::getTableSchema()->fullName . '.created_by' => $this->created_by,
            RishtaSmsLog::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            RishtaSmsLog::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            RishtaSmsLog::getTableSchema()->fullName . '.created_at' => $this->created_at,
            RishtaSmsLog::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', RishtaSmsLog::getTableSchema()->fullName . '.mobile_number', $this->mobile_number])
                ->andFilterWhere(['like', RishtaSmsLog::getTableSchema()->fullName . '.model', $this->model])
                ->andFilterWhere(['like', RishtaSmsLog::getTableSchema()->fullName . '.sms_content', $this->sms_content])
                ->andFilterWhere(['like', RishtaSmsLog::getTableSchema()->fullName . '.delivery_status', $this->delivery_status])
                ->andFilterWhere(['like', RishtaSmsLog::getTableSchema()->fullName . '.sms_provider_message_id', $this->sms_provider_message_id])
                ->andFilterWhere(['like', RishtaSmsLog::getTableSchema()->fullName . '.sms_provider_msg', $this->sms_provider_msg])
                ->andFilterWhere(['like', RishtaSmsLog::getTableSchema()->fullName . '.sms_provider_msg_text', $this->sms_provider_msg_text]);

        return $dataProvider;
    }

}
