<?php

namespace common\models\dynamicdb\internalcallcenter;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\internalcallcenter\CloudTeleUserMontlyReport;
use common\models\master\MasterRole;

/**
 * CloudTeleUserMontlyReportSearch represents the model behind the search form of `common\models\dynamicdb\internalcallcenter\CloudTeleUserMontlyReport`.
 */
class CloudTeleUserMontlyReportSearch extends CloudTeleUserMontlyReport {

    public $month_option = [];
    public $user_option = [];

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'user_id', 'role', 'month_id', 'no_of_call', 'no_of_ctc_call', 'no_of_ibd_call', 'total_time', 'ctc_time', 'ibd_time', 'created_at', 'updated_at'], 'safe'],
            [['month_start_date', 'month_end_date', 'total_time_text', 'ibd_time_text', 'ctc_time_text'], 'safe'],
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
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = CloudTeleUserMontlyReport::find();

        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
                $query->andWhere([CloudTeleUserMontlyReport::getTableSchema()->fullName . '.role' => [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN, MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE]]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                $query->andWhere([CloudTeleUserMontlyReport::getTableSchema()->fullName . '.role' => [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER, MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE]]);
            } else {
                $query->where('0=1');
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['month_id' => SORT_DESC]],
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            CloudTeleUserMontlyReport::getTableSchema()->fullName . '.id' => $this->id,
            CloudTeleUserMontlyReport::getTableSchema()->fullName . '.user_id' => $this->user_id,
            CloudTeleUserMontlyReport::getTableSchema()->fullName . '.role' => $this->role,
            CloudTeleUserMontlyReport::getTableSchema()->fullName . '.month_id' => $this->month_id,
            CloudTeleUserMontlyReport::getTableSchema()->fullName . '.month_start_date' => $this->month_start_date,
            CloudTeleUserMontlyReport::getTableSchema()->fullName . '.month_end_date' => $this->month_end_date,
            CloudTeleUserMontlyReport::getTableSchema()->fullName . '.no_of_call' => $this->no_of_call,
            CloudTeleUserMontlyReport::getTableSchema()->fullName . '.no_of_ctc_call' => $this->no_of_ctc_call,
            CloudTeleUserMontlyReport::getTableSchema()->fullName . '.no_of_ibd_call' => $this->no_of_ibd_call,
            CloudTeleUserMontlyReport::getTableSchema()->fullName . '.total_time' => $this->total_time,
            CloudTeleUserMontlyReport::getTableSchema()->fullName . '.ctc_time' => $this->ctc_time,
            CloudTeleUserMontlyReport::getTableSchema()->fullName . '.ibd_time' => $this->ibd_time,
            CloudTeleUserMontlyReport::getTableSchema()->fullName . '.created_at' => $this->created_at,
            CloudTeleUserMontlyReport::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', CloudTeleUserMontlyReport::getTableSchema()->fullName . '.total_time_text', $this->total_time_text])
                ->andFilterWhere(['like', CloudTeleUserMontlyReport::getTableSchema()->fullName . '.ibd_time_text', $this->ibd_time_text])
                ->andFilterWhere(['like', CloudTeleUserMontlyReport::getTableSchema()->fullName . '.ctc_time_text', $this->ctc_time_text]);

        return $dataProvider;
    }

}
