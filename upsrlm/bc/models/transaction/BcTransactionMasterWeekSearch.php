<?php

namespace bc\models\transaction;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\transaction\BcTransactionMasterWeek;

/**
 * BcTransactionMasterWeekSearch represents the model behind the search form of `bc\models\transaction\BcTransactionMasterWeek`.
 */
class BcTransactionMasterWeekSearch extends BcTransactionMasterWeek {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'week_no', 'created_at', 'status'], 'integer'],
            [['year', 'week_start_date', 'week_end_date'], 'safe'],
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
        $query = BcTransactionMasterWeek::find();
        $query->andWhere([BcTransactionMasterWeek::getTableSchema()->fullName . '.status'=>1]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 10 : $pagination],
            'sort' => ['defaultOrder' => ['week_end_date' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            BcTransactionMasterWeek::getTableSchema()->fullName . '.id' => $this->id,
            BcTransactionMasterWeek::getTableSchema()->fullName . '.week_no' => $this->week_no,
            BcTransactionMasterWeek::getTableSchema()->fullName . '.year' => $this->year,
            BcTransactionMasterWeek::getTableSchema()->fullName . '.week_start_date' => $this->week_start_date,
            BcTransactionMasterWeek::getTableSchema()->fullName . '.week_end_date' => $this->week_end_date,
            BcTransactionMasterWeek::getTableSchema()->fullName . '.created_at' => $this->created_at,
            BcTransactionMasterWeek::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        return $dataProvider;
    }

}
