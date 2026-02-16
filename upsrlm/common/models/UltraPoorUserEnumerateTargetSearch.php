<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UltraPoorUserEnumerateTarget;

/**
 * UltraPoorUserEnumerateTargetSearch represents the model behind the search form of `common\models\UltraPoorUserEnumerateTarget`.
 */
class UltraPoorUserEnumerateTargetSearch extends UltraPoorUserEnumerateTarget {

    public $division_option = [];
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $village_option = [];
    public $bank_option = [];
    public $division_code;
    public $district_code;
    public $block_code;
    public $gram_panchayat_code;
    public $member_option;
    public $profile_status;
    public $wada;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'user_id', 'enumerate', 'target', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'profile_status'], 'safe'],
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
    public function search($params, $user_model = null, $pagination = true, $select = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = UltraPoorUserEnumerateTarget::find();
         
        // add conditions that should always apply here
        if (isset($this->district_code) and $this->district_code != '') {
            $query->joinWith(['gps']);
            $query->andWhere(['relation_user_gram_panchayat.district_code' => $this->district_code]);
            $query->distinct('relation_user_gram_panchayat.user_id');
        }
        if (isset($this->block_code) and $this->block_code != '') {
            $query->joinWith(['gps']);
            $query->andWhere(['relation_user_gram_panchayat.block_code' => $this->block_code]);
            $query->distinct('relation_user_gram_panchayat.user_id');
        }
        if (isset($this->gram_panchayat_code) and $this->gram_panchayat_code != '') {
            $query->joinWith(['gps']);
            $query->andWhere(['relation_user_gram_panchayat.gram_panchayat_code' => $this->gram_panchayat_code]);
            $query->distinct('relation_user_gram_panchayat.user_id');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['created_at' => SORT_ASC]],
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
            'enumerate' => $this->enumerate,
            'target' => $this->target,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
