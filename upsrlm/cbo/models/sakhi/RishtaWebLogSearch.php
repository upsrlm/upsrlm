<?php

namespace cbo\models\sakhi;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use cbo\models\sakhi\RishtaWebLog;

/**
 * RishtaWebLogSearch represents the model behind the search form of `cbo\models\sakhi\RishtaWebLog`.
 */
class RishtaWebLogSearch extends RishtaWebLog {

    public $from_date_time;
    public $to_date_time;
    public $type_option = [];

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'type', 'type_id', 'user_id'], 'safe'],
            [['type_url', 'datetime'], 'safe'],
            [['app_version'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = RishtaWebLog::find();

        if (isset($this->from_date_time) && $this->from_date_time != '') {
            $query->andFilterWhere(['>=', RishtaWebLog::getTableSchema()->fullName . '.datetime', \Yii::$app->formatter->asDatetime($this->from_date_time, "php:Y-m-d").' 00-00-00']);
        }
        if (isset($this->to_date_time) && $this->to_date_time != '') {
            $query->andFilterWhere(['<=', RishtaWebLog::getTableSchema()->fullName . '.datetime', \Yii::$app->formatter->asDatetime($this->to_date_time, "php:Y-m-d").' 23.59.59']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['datetime' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            RishtaWebLog::getTableSchema()->fullName . '.id' => $this->id,
            RishtaWebLog::getTableSchema()->fullName . '.type' => $this->type,
            RishtaWebLog::getTableSchema()->fullName . '.type_id' => $this->type_id,
            RishtaWebLog::getTableSchema()->fullName . '.user_id' => $this->user_id,
            //'app_version' => $this->app_version,
            RishtaWebLog::getTableSchema()->fullName . '.datetime' => $this->datetime,
        ]);
        $query->andFilterWhere(['like', RishtaWebLog::getTableSchema()->fullName . '.app_version', $this->app_version]);
        $query->andFilterWhere(['like', RishtaWebLog::getTableSchema()->fullName . '.type_url', $this->type_url]);

        return $dataProvider;
    }

}
