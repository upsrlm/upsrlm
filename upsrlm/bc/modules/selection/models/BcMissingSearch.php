<?php

namespace bc\modules\selection\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\selection\models\BcMissing;

/**
 * BcMissingSearch represents the model behind the search form of `bc\modules\selection\models\BcMissing`.
 */
class BcMissingSearch extends BcMissing {

    public $map;
    public $bc_missing_listed;
    public $district_option = [];
    public $block_option = [];
    public $district_code;
    public $block_code;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'bc_application_id', 'bc_selection_user_id', 'listed_bc_training_status', 'listed_bc_application_id', 'listed_bc_selection_user_id'], 'safe'],
            [['bc_name', 'mobile_number', 'district_name', 'block_name', 'gram_panchayat_name', 'date_of_training', 'certified', 'map', 'bc_missing_listed', 'district_code', 'block_code'], 'safe'],
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
        $query = BcMissing::find();

        if ($this->map != '') {
            if ($this->map == 1) {
                $query->andWhere(['!=', 'bc_missing.bc_application_id', 0]);
            }
            if ($this->map == 0) {
                $query->andWhere(['=', 'bc_missing.bc_application_id', '0']);
            }
        }
        $query->andWhere(['!=', 'bc_missing.bc_application_id', 0])->andWhere(" `bc_application_id`!= `listed_bc_application_id`");
        if ($this->bc_missing_listed != '') {
            if ($this->bc_missing_listed == '1') {

                $query->andWhere(['!=', 'bc_missing.bc_application_id', 0])->andWhere(" `bc_application_id` = `listed_bc_application_id`");
            }
            if ($this->bc_missing_listed == '0') {
                $query->andWhere(['!=', 'bc_missing.bc_application_id', 0])->andWhere(" `bc_application_id`!= `listed_bc_application_id`");
            }

//            var_dump($query->prepare(\Yii::$app->db->queryBuilder)->createCommand()->rawSql);exit;
        }
        $query->joinWith(['bc']);
        $query->andWhere(['srlm_bc_application.urban_shg' => 0]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
        ]);
        if ($this->district_code != '') {
            $query->joinWith(['bc']);
            $query->andWhere(['srlm_bc_application.district_code' => $this->district_code]);
        }
        if ($this->block_code != '') {
            $query->joinWith(['bc']);
            $query->andWhere(['srlm_bc_application.block_code' => $this->block_code]);
        }
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            BcMissing::getTableSchema()->fullName . '.id' => $this->id,
            BcMissing::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            BcMissing::getTableSchema()->fullName . '.bc_selection_user_id' => $this->bc_selection_user_id,
            BcMissing::getTableSchema()->fullName . '.listed_bc_training_status' => $this->listed_bc_training_status,
            BcMissing::getTableSchema()->fullName . '.listed_bc_application_id' => $this->listed_bc_application_id,
            BcMissing::getTableSchema()->fullName . '.listed_bc_selection_user_id' => $this->listed_bc_selection_user_id,
        ]);

        $query->andFilterWhere(['like', BcMissing::getTableSchema()->fullName . '.bc_name', $this->bc_name])
                ->andFilterWhere(['like', BcMissing::getTableSchema()->fullName . '.mobile_number', $this->mobile_number])
                ->andFilterWhere(['like', BcMissing::getTableSchema()->fullName . '.district_name', $this->district_name])
                ->andFilterWhere(['like', BcMissing::getTableSchema()->fullName . '.block_name', $this->block_name])
                ->andFilterWhere(['like', BcMissing::getTableSchema()->fullName . '.gram_panchayat_name', $this->gram_panchayat_name])
                ->andFilterWhere(['like', BcMissing::getTableSchema()->fullName . '.date_of_training', $this->date_of_training])
                ->andFilterWhere(['like', BcMissing::getTableSchema()->fullName . '.certified', $this->certified]);

        return $dataProvider;
    }

}
