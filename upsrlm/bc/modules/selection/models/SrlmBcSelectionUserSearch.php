<?php

namespace bc\modules\selection\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\selection\models\SrlmBcSelectionUser;

/**
 * SrlmBcSelectionUserSearch represents the model behind the search form of `app\models\srlm\SrlmBcSelectionUser`.
 */
class SrlmBcSelectionUserSearch extends SrlmBcSelectionUser {

    public $csv_data;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'srlm_bc_selection_app_detail_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['mobile_no', 'firebase_token', 'form_uuid', 'form_json', 'profile_photo', 'aadhar_front_photo', 'aadhar_back_photo'], 'safe'],
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
        $query = SrlmBcSelectionUser::find();
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 30 : $pagination],
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
            'id' => $this->id,
            'srlm_bc_selection_app_detail_id' => $this->srlm_bc_selection_app_detail_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', 'firebase_token', $this->firebase_token])
                ->andFilterWhere(['like', 'form_uuid', $this->form_uuid])
                ->andFilterWhere(['like', 'form_json', $this->form_json])
                ->andFilterWhere(['like', 'profile_photo', $this->profile_photo])
                ->andFilterWhere(['like', 'aadhar_front_photo', $this->aadhar_front_photo])
                ->andFilterWhere(['like', 'aadhar_back_photo', $this->aadhar_back_photo]);

        return $dataProvider;
    }

}
