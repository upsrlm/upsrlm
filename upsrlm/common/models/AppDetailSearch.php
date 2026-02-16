<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AppDetail;

/**
 * AppDetailSearch represents the model behind the search form of `common\models\AppDetail`.
 */
class AppDetailSearch extends AppDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['token', 'email_id', 'imei_no', 'os_type', 'manufacturer_name', 'os_version', 'firebase_token', 'app_version', 'date_of_install', 'date_of_uninstall'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true) {
        $query = AppDetail::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 20 : $pagination],
            'sort' => ['defaultOrder' => ['date_of_install' => SORT_DESC]],
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
            'date_of_install' => $this->date_of_install,
            'date_of_uninstall' => $this->date_of_uninstall,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'email_id', $this->email_id])
            ->andFilterWhere(['like', 'imei_no', $this->imei_no])
            ->andFilterWhere(['like', 'os_type', $this->os_type])
            ->andFilterWhere(['like', 'manufacturer_name', $this->manufacturer_name])
            ->andFilterWhere(['like', 'os_version', $this->os_version])
            ->andFilterWhere(['like', 'firebase_token', $this->firebase_token])
            ->andFilterWhere(['like', 'app_version', $this->app_version]);

        return $dataProvider;
    }
}
