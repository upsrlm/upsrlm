<?php

namespace bc\models\transaction;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\transaction\BcTransactionMasterMonth;

/**
 * BcTransactionMasterMonthSearch represents the model behind the search form of `bc\models\transaction\BcTransactionMasterMonth`.
 */
class BcTransactionMasterMonthSearch extends BcTransactionMasterMonth {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'month_no', 'created_at', 'status'], 'integer'],
            [['year', 'month_start_date', 'month_end_date'], 'safe'],
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
        $query = BcTransactionMasterMonth::find();
        $query->andWhere([BcTransactionMasterMonth::getTableSchema()->fullName . '.status' => 1]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 10 : $pagination],
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
            BcTransactionMasterMonth::getTableSchema()->fullName . '.id' => $this->id,
            BcTransactionMasterMonth::getTableSchema()->fullName . '.month_no' => $this->month_no,
            BcTransactionMasterMonth::getTableSchema()->fullName . '.year' => $this->year,
            BcTransactionMasterMonth::getTableSchema()->fullName . '.month_start_date' => $this->month_start_date,
            BcTransactionMasterMonth::getTableSchema()->fullName . '.month_end_date' => $this->month_end_date,
            BcTransactionMasterMonth::getTableSchema()->fullName . '.created_at' => $this->created_at,
            BcTransactionMasterMonth::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        return $dataProvider;
    }

}
