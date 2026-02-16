<?php

namespace bc\modules\selection\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\selection\models\SrlmBcSelectionApiLog as ApiLog;

/**
 * ApiLogSearch represents the model behind the search form of `app\models\ApiLog`.
 */
class SrlmBcSelectionApiLogSearch extends ApiLog {

    public $user_id;
    public $app_option = [];
    public $app_version;

//    public static function getDb() {
//        return \Yii::$app->db_api;
//    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'srlm_bc_selection_app_id', 'http_response_code', 'api_response_status', 'created_at'], 'integer'],
            [['user_id', 'app_version', 'app_option', 'version_no', 'imei_no', 'ip', 'time', 'request_body', 'request_url', 'response'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true) {
        $query = ApiLog::find()->joinWith('appdetail');

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
            'srlm_bc_selection_api_log.id' => $this->id,
            'srlm_bc_selection_api_log.srlm_bc_selection_app_id' => $this->srlm_bc_selection_app_id,
            'srlm_bc_selection_api_log.time' => $this->time,
            'srlm_bc_selection_api_log.http_response_code' => $this->http_response_code,
            'srlm_bc_selection_api_log.api_response_status' => $this->api_response_status,
            'srlm_bc_selection_api_log.created_at' => $this->created_at,
            'srlm_bc_selection_api_log.srlm_bc_selection_user_id' => $this->srlm_bc_selection_user_id,
            'srlm_bc_selection_api_log.app_version' => $this->app_version,
        ]);

        $query->andFilterWhere(['like', 'srlm_bc_selection_api_log.version_no', $this->version_no])
                ->andFilterWhere(['like', 'srlm_bc_selection_api_log.imei_no', $this->imei_no])
                ->andFilterWhere(['like', 'srlm_bc_selection_api_log.ip', $this->ip])
                ->andFilterWhere(['like', 'srlm_bc_selection_api_log.request_body', $this->request_body])
                ->andFilterWhere(['like', 'srlm_bc_selection_api_log.request_url', $this->request_url])
                ->andFilterWhere(['like', 'srlm_bc_selection_api_log.response', $this->response]);

        return $dataProvider;
    }

}
