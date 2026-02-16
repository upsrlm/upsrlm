<?php

namespace common\models\master;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\master\MasterListBlockBdo;

/**
 * MasterListBlockBdoSearch represents the model behind the search form of `common\models\master\MasterListBlockBdo`.
 */
class MasterListBlockBdoSearch extends MasterListBlockBdo {
    
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'status'], 'integer'],
            [['district', 'role', 'block', 'mobile_no'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true, $column = null, $array = false) {
        $query = MasterListBlockBdo::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['block' => SORT_ASC]],
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
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'district', $this->district])
                ->andFilterWhere(['like', 'role', $this->role])
                ->andFilterWhere(['like', 'block', $this->block])
                ->andFilterWhere(['like', 'mobile_no', $this->mobile_no]);

        return $dataProvider;
    }

}
