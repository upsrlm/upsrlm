<?php

namespace cbo\models\sakhi;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use cbo\models\sakhi\RishtaShgFeedback;
use common\models\master\MasterRole;

/**
 * RishtaShgFeedbackSearch represents the model behind the search form of `cbo\models\sakhi\RishtaShgFeedback`.
 */
class DeleteRishtaShgFeedbackSearch extends RishtaShgFeedback {

    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $district_code;
    public $block_code;
    public $gram_panchayat_code;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'cbo_shg_id', 'ques_1', 'ques_2', 'ques_3', 'ques_4', 'ques_5', 'ques6p1_1', 'ques6p1_2', 'ques6p1_3', 'ques6p2_4', 'ques6p2_5', 'ques6p2_6', 'ques6p2_7', 'ques6p2_8', 'ques6p2_9', 'ques6p2_10', 'ques6p2_11', 'ques6p3_12', 'ques6p3_13', 'ques6p3_14', 'ques6p3_15', 'ques6p3_16', 'ques6p3_17', 'ques6p3_18', 'ques_7', 'ques_8', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
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
        $query = RishtaShgFeedback::find();

        $query->joinWith(['shg']);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                $query->andWhere([\cbo\models\Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {

                $query->andWhere([\cbo\models\Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } else {
                $query->where('0=1');
            }
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
            RishtaShgFeedback::getTableSchema()->fullName . '.id' => $this->id,
            RishtaShgFeedback::getTableSchema()->fullName . '.cbo_shg_id' => $this->cbo_shg_id,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques_1' => $this->ques_1,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques_2' => $this->ques_2,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques_3' => $this->ques_3,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques_4' => $this->ques_4,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques_5' => $this->ques_5,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques6p1_1' => $this->ques6p1_1,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques6p1_2' => $this->ques6p1_2,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques6p1_3' => $this->ques6p1_3,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques6p2_4' => $this->ques6p2_4,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques6p2_5' => $this->ques6p2_5,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques6p2_6' => $this->ques6p2_6,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques6p2_7' => $this->ques6p2_7,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques6p2_8' => $this->ques6p2_8,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques6p2_9' => $this->ques6p2_9,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques6p2_10' => $this->ques6p2_10,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques6p2_11' => $this->ques6p2_11,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques6p3_12' => $this->ques6p3_12,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques6p3_13' => $this->ques6p3_13,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques6p3_14' => $this->ques6p3_14,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques6p3_15' => $this->ques6p3_15,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques6p3_16' => $this->ques6p3_16,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques6p3_17' => $this->ques6p3_17,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques6p3_18' => $this->ques6p3_18,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques_7' => $this->ques_7,
            RishtaShgFeedback::getTableSchema()->fullName . '.ques_8' => $this->ques_8,
            RishtaShgFeedback::getTableSchema()->fullName . '.created_by' => $this->created_by,
            RishtaShgFeedback::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            RishtaShgFeedback::getTableSchema()->fullName . '.created_at' => $this->created_at,
            RishtaShgFeedback::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            RishtaShgFeedback::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        return $dataProvider;
    }

}
