<?php

namespace common\models\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\master\SafaiKarmi;

/**
 * SafaiKarmiSearch represents the model behind the search form of `common\models\master\SafaiKarmi`.
 */
class SafaiKarmiSearch extends SafaiKarmi {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'district_code', 'block_code', 'gram_panchayat_code', 'role', 'user_id', 'status', 'mobile_status', 'ctc_click_count', 'ibd'], 'integer'],
            [['s_no', 'district', 'block', 'gram_panchyat', 'name', 'gender', 'age', 'mobile_no', 'alternative_mobile_no', 'ibd_date', 'ibd_datetime'], 'safe'],
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
        $query = SafaiKarmi::find();
        $query->orderBy([
            'district' => SORT_ASC,
            'block' => SORT_ASC,
            'gram_panchyat' => SORT_ASC
        ]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
                //'sort' => ['defaultOrder' => ['district' => SORT_ASC,'block' => SORT_ASC,'gram_panchyat' => SORT_ASC]],
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
            'district_code' => $this->district_code,
            'block_code' => $this->block_code,
            'gram_panchayat_code' => $this->gram_panchayat_code,
            'role' => $this->role,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'mobile_status' => $this->mobile_status,
            'ctc_click_count' => $this->ctc_click_count,
            'ibd' => $this->ibd,
            'ibd_date' => $this->ibd_date,
            'ibd_datetime' => $this->ibd_datetime,
        ]);

        $query->andFilterWhere(['like', 's_no', $this->s_no])
                ->andFilterWhere(['like', 'district', $this->district])
                ->andFilterWhere(['like', 'block', $this->block])
                ->andFilterWhere(['like', 'gram_panchyat', $this->gram_panchyat])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'gender', $this->gender])
                ->andFilterWhere(['like', 'age', $this->age])
                ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', 'alternative_mobile_no', $this->alternative_mobile_no]);

        return $dataProvider;
    }

}
