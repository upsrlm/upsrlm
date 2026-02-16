<?php

namespace bc\modules\selection\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\selection\models\SmsLog;

/**
 * SmsLogSearch represents the model behind the search form of `bc\modules\selection\models\SmsLog`.
 */
class SmsLogSearch extends SmsLog
{
    public $from_date_time;
    public $to_date_time;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['mobile_no', 'imei_no', 'os_type', 'manufacturer_name', 'os_version', 'firebase_token', 'app_version', 'time', 'sms_send_time', 'otp', 'message_id'], 'safe'],
            [['from_date_time', 'to_date_time'], 'safe']
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
        $query = SmsLog::find();
        $query->andFilterWhere(['!=', SmsLog::getTableSchema()->fullName . '.status', '0']);
        if (isset($this->from_date_time) && $this->from_date_time != '') {
            $query->andFilterWhere(['>=', SmsLog::getTableSchema()->fullName . '.time', $this->from_date_time . ' 00:00:00']);
        }
        if (isset($this->to_date_time) && $this->to_date_time != '') {
            $query->andFilterWhere(['<=', SmsLog::getTableSchema()->fullName . '.time', $this->to_date_time . ' 23:59:59']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
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
            SmsLog::getTableSchema()->fullName . '.id' => $this->id,
            SmsLog::getTableSchema()->fullName . '.time' => $this->time,
            SmsLog::getTableSchema()->fullName . '.sms_send_time' => $this->sms_send_time,
            SmsLog::getTableSchema()->fullName . '.created_at' => $this->created_at,
            SmsLog::getTableSchema()->fullName . '.created_by' => $this->created_by,
            SmsLog::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            SmsLog::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            SmsLog::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', SmsLog::getTableSchema()->fullName . '.mobile_no', $this->mobile_no])
            ->andFilterWhere(['like', SmsLog::getTableSchema()->fullName . '.imei_no', $this->imei_no])
            ->andFilterWhere(['like', SmsLog::getTableSchema()->fullName . '.os_type', $this->os_type])
            ->andFilterWhere(['like', SmsLog::getTableSchema()->fullName . '.manufacturer_name', $this->manufacturer_name])
            ->andFilterWhere(['like', SmsLog::getTableSchema()->fullName . '.os_version', $this->os_version])
            ->andFilterWhere(['like', SmsLog::getTableSchema()->fullName . '.firebase_token', $this->firebase_token])
            ->andFilterWhere(['like', SmsLog::getTableSchema()->fullName . '.app_version', $this->app_version])
            ->andFilterWhere(['like', SmsLog::getTableSchema()->fullName . '.otp', $this->otp])
            ->andFilterWhere(['like', SmsLog::getTableSchema()->fullName . '.message_id', $this->message_id]);

        return $dataProvider;
    }
}
