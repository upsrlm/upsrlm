<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MopupVoiceSms;

/**
 * MopupVoiceSmsSearch represents the model behind the search form of `common\models\MopupVoiceSms`.
 */
class MopupVoiceSmsSearch extends MopupVoiceSms
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'role'], 'integer'],
            [['mobile_number', 'connect_time', 'duration', 'failure_reason'], 'safe'],
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
     public function search($params, $user_model = null, $pagination = true, $distinct_column = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = MopupVoiceSms::find();

        // add conditions that should always apply here

         $query->joinWith(['user']);
       if (isset($this->district_code) and $this->district_code != '') {
            $query->joinWith(['grampanchayat']);
            $query->andWhere(['relation_user_gram_panchayat.district_code' => $this->district_code]);
            $query->distinct('relation_user_gram_panchayat.district_code');
        }
        if (isset($this->block_code) and $this->block_code != '') {
            $query->joinWith(['grampanchayat']);
            $query->andWhere(['relation_user_gram_panchayat.block_code' => $this->block_code]);
            $query->distinct('relation_user_gram_panchayat.block_code');
        }
        if (isset($this->gram_panchayat_code) and $this->gram_panchayat_code != '') {
            $query->joinWith(['grampanchayat']);
            $query->andWhere(['relation_user_gram_panchayat.gram_panchayat_code' => $this->gram_panchayat_code]);
            $query->distinct('relation_user_gram_panchayat.gram_panchayat_code');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['mobile_number' => SORT_ASC]],
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
            'role' => $this->role,
        ]);

        $query->andFilterWhere(['like', 'mobile_number', $this->mobile_number])
            ->andFilterWhere(['like', 'connect_time', $this->connect_time])
            ->andFilterWhere(['like', 'duration', $this->duration])
            ->andFilterWhere(['like', 'failure_reason', $this->failure_reason]);

        return $dataProvider;
    }
}
