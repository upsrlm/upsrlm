<?php

namespace common\models\dynamicdb\internalcallcenter\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterMonth;
use common\models\master\MasterRole;

class CloudTeleMasterMonthSearch extends CloudTeleMasterMonth {

    public $month_option = [];

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['month_no', 'created_at', 'status'], 'integer'],
            [['year', 'month_start_date', 'month_end_date'], 'safe'],
            [['month_start_date', 'month_end_date'], 'required'],
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
        $query = CloudTeleMasterMonth::find();
        $query->andWhere(['status' => 1]);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                
            } else {
                $query->where('0=1');
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['month_end_date' => SORT_DESC]],
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            CloudTeleMasterMonth::getTableSchema()->fullName . '.id' => $this->id,
            CloudTeleMasterMonth::getTableSchema()->fullName . '.year' => $this->year,
            CloudTeleMasterMonth::getTableSchema()->fullName . '.month_no' => $this->month_no,
            CloudTeleMasterMonth::getTableSchema()->fullName . '.created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }

}
