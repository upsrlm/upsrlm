<?php

namespace common\models\rishta;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\rishta\RishtaNotificationTemplate;

/**
 * RishtaNotificationTemplateSearch represents the model behind the search form of `common\models\rishta\RishtaNotificationTemplate`.
 */
class RishtaNotificationTemplateSearch extends RishtaNotificationTemplate {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'acknowledge', 'visible', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['name', 'template'], 'safe'],
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
        $query = RishtaNotificationTemplate::find();

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
            RishtaNotificationTemplate::getTableSchema()->fullName . '.id' => $this->id,
            RishtaNotificationTemplate::getTableSchema()->fullName . '.acknowledge' => $this->acknowledge,
            RishtaNotificationTemplate::getTableSchema()->fullName . '.visible' => $this->visible,
            RishtaNotificationTemplate::getTableSchema()->fullName . '.created_at' => $this->created_at,
            RishtaNotificationTemplate::getTableSchema()->fullName . '.created_by' => $this->created_by,
            RishtaNotificationTemplate::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            RishtaNotificationTemplate::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            RishtaNotificationTemplate::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', RishtaNotificationTemplate::getTableSchema()->fullName . '.name', $this->name])
                ->andFilterWhere(['like', RishtaNotificationTemplate::getTableSchema()->fullName . '.template', $this->template]);

        return $dataProvider;
    }

}
