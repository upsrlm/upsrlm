<?php

namespace cbo\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use cbo\models\CboBlock;

/**
 * CboBlockSearch represents the model behind the search form of `app\models\CboBlock`.
 */
class CboBlockSearch extends CboBlock {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'state_code', 'division_code', 'district_code', 'sub_district_code', 'total_shgs', 'total_members', 'total_vo', 'total_clf', 'status'], 'integer'],
            [['state_name', 'division_name', 'district_name', 'sub_district_name', 'block_code', 'block_name'], 'safe'],
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
        $query = CboBlock::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['block_name' => SORT_ASC, 'district_name' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            CboBlock::getTableSchema()->fullName . '.id' => $this->id,
            CboBlock::getTableSchema()->fullName . '.state_code' => $this->state_code,
            CboBlock::getTableSchema()->fullName . '.division_code' => $this->division_code,
            CboBlock::getTableSchema()->fullName . '.district_code' => $this->district_code,
            CboBlock::getTableSchema()->fullName . '.sub_district_code' => $this->sub_district_code,
            CboBlock::getTableSchema()->fullName . '.total_shgs' => $this->total_shgs,
            CboBlock::getTableSchema()->fullName . '.total_members' => $this->total_members,
            CboBlock::getTableSchema()->fullName . '.total_vo' => $this->total_vo,
            CboBlock::getTableSchema()->fullName . '.total_clf' => $this->total_clf,
            CboBlock::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', CboBlock::getTableSchema()->fullName . '.state_name', $this->state_name])
                ->andFilterWhere(['like', CboBlock::getTableSchema()->fullName . '.division_name', $this->division_name])
                ->andFilterWhere(['like', CboBlock::getTableSchema()->fullName . '.district_name', $this->district_name])
                ->andFilterWhere(['like', CboBlock::getTableSchema()->fullName . '.sub_district_name', $this->sub_district_name])
                ->andFilterWhere(['like', CboBlock::getTableSchema()->fullName . '.block_code', $this->block_code])
                ->andFilterWhere(['like', CboBlock::getTableSchema()->fullName . '.block_name', $this->block_name]);

        return $dataProvider;
    }

}
