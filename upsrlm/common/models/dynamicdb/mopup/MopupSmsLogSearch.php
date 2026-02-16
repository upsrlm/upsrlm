<?php

namespace common\models\dynamicdb\mopup;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\mopup\MopupSmsLog;

/**
 * MopupSmsLogSearch represents the model behind the search form of `common\models\dynamicdb\mopup\MopupSmsLog`.
 */
class MopupSmsLogSearch extends MopupSmsLog {

    public $tempplate_option = [];
    public $from_date_time;
    public $to_date_time;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'user_id', 'sms_template_id', 'try_send_count', 'unicode', 'sms_length', 'sms_count', 'sms_provider_campaign_id', 'sms_provider_code', 'created_by', 'updated_by', 'updated_at', 'created_at', 'status'], 'integer'],
            [['name', 'mobile_number', 'template_id', 'model', 'sms_content', 'sms_send_time', 'delivery_status', 'sms_provider_message_id', 'sms_provider_msg', 'sms_provider_msg_text'], 'safe'],
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
        $query = MopupSmsLog::find();
        if (isset($this->from_date_time) && $this->from_date_time != '') {
            $query->andFilterWhere(['>=', MopupSmsLog::getTableSchema()->fullName . '.sms_send_time', $this->from_date_time . ' 00:00:00']);
        }
        if (isset($this->to_date_time) && $this->to_date_time != '') {
            $query->andFilterWhere(['<=', MopupSmsLog::getTableSchema()->fullName . '.sms_send_time', $this->to_date_time . ' 23:59:59']);
        }
        // add conditions that should always apply here

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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'sms_template_id' => $this->sms_template_id,
            'sms_send_time' => $this->sms_send_time,
            'try_send_count' => $this->try_send_count,
            'unicode' => $this->unicode,
            'sms_length' => $this->sms_length,
            'sms_count' => $this->sms_count,
            'sms_provider_campaign_id' => $this->sms_provider_campaign_id,
            'sms_provider_code' => $this->sms_provider_code,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'mobile_number', $this->mobile_number])
                ->andFilterWhere(['like', 'template_id', $this->template_id])
                ->andFilterWhere(['like', 'model', $this->model])
                ->andFilterWhere(['like', 'sms_content', $this->sms_content])
                ->andFilterWhere(['like', 'delivery_status', $this->delivery_status])
                ->andFilterWhere(['like', 'sms_provider_message_id', $this->sms_provider_message_id])
                ->andFilterWhere(['like', 'sms_provider_msg', $this->sms_provider_msg])
                ->andFilterWhere(['like', 'sms_provider_msg_text', $this->sms_provider_msg_text]);

        return $dataProvider;
    }

}
