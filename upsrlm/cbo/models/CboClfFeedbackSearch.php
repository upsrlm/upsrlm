<?php

namespace cbo\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use cbo\models\CboClfFeedback;
use common\models\master\MasterRole;

/**
 * CboClfFeedbackSearch represents the model behind the search form of `cbo\models\CboClfFeedback`.
 */
class CboClfFeedbackSearch extends CboClfFeedback {

    public $district_option = [];
    public $block_option = [];
    public $district_code;
    public $block_code;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'cbo_clf_id', 'ques_1', 'ques_2', 'ques_3', 'ques_4', 'ques_5', 'ques_61', 'ques_62', 'ques_63', 'ques_64', 'ques_65', 'ques_66', 'ques_7', 'ques_8', 'ques_9', 'ques_91', 'ques_92', 'ques_93', 'ques_94', 'ques_95', 'ques_96', 'ques_97', 'ques_98', 'ques_99', 'ques_10', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['ques_91a', 'ques_92a', 'ques_93a', 'ques_94a', 'ques_95a', 'ques_96a', 'ques_97a', 'ques_98a', 'ques_99a'], 'number'],
            [['group_photo'], 'safe'],
            [['district_code', 'block_code'], 'safe'],
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
        $query = CboClfFeedback::find();

        $query->joinWith(['clf']);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.created_by' => $user_model->id]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.created_by' => $user_model->id]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CBO_USER])) {
                $query->andWhere([CboClf::getTableSchema()->fullName . '.id' => \yii\helpers\ArrayHelper::getColumn($user_model->clf, 'cbo_id')]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                //$query->andWhere([CboClf::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([CboClf::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
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
            CboClfFeedback::getTableSchema()->fullName . '.id' => $this->id,
            CboClfFeedback::getTableSchema()->fullName . '.cbo_clf_id' => $this->cbo_clf_id,
            CboClfFeedback::getTableSchema()->fullName . '.ques_1' => $this->ques_1,
            CboClfFeedback::getTableSchema()->fullName . '.ques_2' => $this->ques_2,
            CboClfFeedback::getTableSchema()->fullName . '.ques_3' => $this->ques_3,
            CboClfFeedback::getTableSchema()->fullName . '.ques_4' => $this->ques_4,
            CboClfFeedback::getTableSchema()->fullName . '.ques_5' => $this->ques_5,
            CboClfFeedback::getTableSchema()->fullName . '.ques_61' => $this->ques_61,
            CboClfFeedback::getTableSchema()->fullName . '.ques_62' => $this->ques_62,
            CboClfFeedback::getTableSchema()->fullName . '.ques_63' => $this->ques_63,
            CboClfFeedback::getTableSchema()->fullName . '.ques_64' => $this->ques_64,
            CboClfFeedback::getTableSchema()->fullName . '.ques_65' => $this->ques_65,
            CboClfFeedback::getTableSchema()->fullName . '.ques_66' => $this->ques_66,
            CboClfFeedback::getTableSchema()->fullName . '.ques_7' => $this->ques_7,
            CboClfFeedback::getTableSchema()->fullName . '.ques_8' => $this->ques_8,
            CboClfFeedback::getTableSchema()->fullName . '.ques_9' => $this->ques_9,
            CboClfFeedback::getTableSchema()->fullName . '.ques_91' => $this->ques_91,
            CboClfFeedback::getTableSchema()->fullName . '.ques_92' => $this->ques_92,
            CboClfFeedback::getTableSchema()->fullName . '.ques_93' => $this->ques_93,
            CboClfFeedback::getTableSchema()->fullName . '.ques_94' => $this->ques_94,
            CboClfFeedback::getTableSchema()->fullName . '.ques_95' => $this->ques_95,
            CboClfFeedback::getTableSchema()->fullName . '.ques_96' => $this->ques_96,
            CboClfFeedback::getTableSchema()->fullName . '.ques_97' => $this->ques_97,
            CboClfFeedback::getTableSchema()->fullName . '.ques_98' => $this->ques_98,
            CboClfFeedback::getTableSchema()->fullName . '.ques_99' => $this->ques_99,
            CboClfFeedback::getTableSchema()->fullName . '.ques_91a' => $this->ques_91a,
            CboClfFeedback::getTableSchema()->fullName . '.ques_92a' => $this->ques_92a,
            CboClfFeedback::getTableSchema()->fullName . '.ques_93a' => $this->ques_93a,
            CboClfFeedback::getTableSchema()->fullName . '.ques_94a' => $this->ques_94a,
            CboClfFeedback::getTableSchema()->fullName . '.ques_95a' => $this->ques_95a,
            CboClfFeedback::getTableSchema()->fullName . '.ques_96a' => $this->ques_96a,
            CboClfFeedback::getTableSchema()->fullName . '.ques_97a' => $this->ques_97a,
            CboClfFeedback::getTableSchema()->fullName . '.ques_98a' => $this->ques_98a,
            CboClfFeedback::getTableSchema()->fullName . '.ques_99a' => $this->ques_99a,
            CboClfFeedback::getTableSchema()->fullName . '.ques_10' => $this->ques_10,
            CboClfFeedback::getTableSchema()->fullName . '.created_by' => $this->created_by,
            CboClfFeedback::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            CboClfFeedback::getTableSchema()->fullName . '.created_at' => $this->created_at,
            CboClfFeedback::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            CboClfFeedback::getTableSchema()->fullName . '.status' => $this->status,
            CboClf::getTableSchema()->fullName . '.district_code' => $this->district_code,
            CboClf::getTableSchema()->fullName . '.block_code' => $this->block_code,
        ]);

        $query->andFilterWhere(['like', 'group_photo', $this->group_photo]);

        return $dataProvider;
    }

}
