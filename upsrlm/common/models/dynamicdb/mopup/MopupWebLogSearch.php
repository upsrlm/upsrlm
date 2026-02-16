<?php

namespace common\models\dynamicdb\mopup;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\mopup\MopupWebLog;

/**
 * MopupWebLogSearch represents the model behind the search form of `common\models\dynamicdb\mopup\MopupWebLog`.
 */
class MopupWebLogSearch extends MopupWebLog {

    public $tempplate_option = [];
    public $from_date_time;
    public $to_date_time;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'type', 'type_id', 'user_id', 'ajax'], 'integer'],
            [['type_url', 'datetime'], 'safe'],
            [['app_version'], 'number'],
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
        $query = MopupWebLog::find();
        if (isset($this->from_date_time) && $this->from_date_time != '') {
            $query->andFilterWhere(['>=', MopupWebLog::getTableSchema()->fullName . '.sms_send_time', $this->from_date_time . ' 00:00:00']);
        }
        if (isset($this->to_date_time) && $this->to_date_time != '') {
            $query->andFilterWhere(['<=', MopupWebLog::getTableSchema()->fullName . '.sms_send_time', $this->to_date_time . ' 23:59:59']);
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
            'type' => $this->type,
            'type_id' => $this->type_id,
            'user_id' => $this->user_id,
            'app_version' => $this->app_version,
            'ajax' => $this->ajax,
            'datetime' => $this->datetime,
        ]);

        $query->andFilterWhere(['like', 'type_url', $this->type_url]);

        return $dataProvider;
    }

}
