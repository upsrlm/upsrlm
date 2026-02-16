<?php

namespace bc\modules\corona\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\corona\models\BcCoronaFeedback;
use common\models\master\MasterRole;

/**
 * BcCoronaFeedbackSearch represents the model behind the search form of `bc\modules\corona\models\BcCoronaFeedback`.
 */
class BcCoronaFeedbackSearch extends BcCoronaFeedback {

    public static $coll_district = 'district_code';
    public static $coll_village = 'village_code';
    public static $coll_block = 'block_code';
    public static $coll_gram_panchayat = 'gram_panchayat_code';
    public $division_option = [];
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $village_option = [];
    public $q1_option = [];
    public $q2_option = [];
    public $q3_option = [];
    public $q4_option = [];

    public function rules() {
        return [
            [['id', 'bc_application_id', 'srlm_bc_selection_user_id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'que1a', 'que2a', 'que3a', 'que4a', 'created_at', 'updated_at', 'status'], 'integer'],
            [['bc_name', 'division_name', 'district_name', 'block_name', 'gram_panchayat_name', 'village_name', 'hamlet', 'gps', 'gps_accuracy'], 'safe'],
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
        $query = BcCoronaFeedback::find();

        $query->andWhere(['!=', BcCoronaFeedback::getTableSchema()->fullName . '.status', -1]);
        // add conditions that should always apply here
        if ($columns != NULL) {
            $query->asArray();
        }
        if ($user_model == NULL) {
//            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                $query->andWhere([BcCoronaFeedback::getTableSchema()->fullName . '.status' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {
                $query->andWhere([BcCoronaFeedback::getTableSchema()->fullName . '.status' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                $query->andWhere([BcCoronaFeedback::getTableSchema()->fullName . '.status' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                $query->andWhere([BcCoronaFeedback::getTableSchema()->fullName . '.status' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([BcCoronaFeedback::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } else {
                $query->where('0=1');
            }
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
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
            BcCoronaFeedback::getTableSchema()->fullName . '.id' => $this->id,
            BcCoronaFeedback::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            BcCoronaFeedback::getTableSchema()->fullName . '.srlm_bc_selection_user_id' => $this->srlm_bc_selection_user_id,
            BcCoronaFeedback::getTableSchema()->fullName . '.division_code' => $this->division_code,
            BcCoronaFeedback::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcCoronaFeedback::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcCoronaFeedback::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            BcCoronaFeedback::getTableSchema()->fullName . '.village_code' => $this->village_code,
            BcCoronaFeedback::getTableSchema()->fullName . '.que1a' => $this->que1a,
            BcCoronaFeedback::getTableSchema()->fullName . '.que2a' => $this->que2a,
            BcCoronaFeedback::getTableSchema()->fullName . '.que3a' => $this->que3a,
            BcCoronaFeedback::getTableSchema()->fullName . '.que4a' => $this->que4a,
            BcCoronaFeedback::getTableSchema()->fullName . '.created_at' => $this->created_at,
            BcCoronaFeedback::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            BcCoronaFeedback::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', BcCoronaFeedback::getTableSchema()->fullName . '.bc_name', $this->bc_name])
                ->andFilterWhere(['like', BcCoronaFeedback::getTableSchema()->fullName . '.division_name', $this->division_name])
                ->andFilterWhere(['like', BcCoronaFeedback::getTableSchema()->fullName . '.district_name', $this->district_name])
                ->andFilterWhere(['like', BcCoronaFeedback::getTableSchema()->fullName . '.block_name', $this->block_name])
                ->andFilterWhere(['like', BcCoronaFeedback::getTableSchema()->fullName . '.gram_panchayat_name', $this->gram_panchayat_name])
                ->andFilterWhere(['like', BcCoronaFeedback::getTableSchema()->fullName . '.village_name', $this->village_name])
                ->andFilterWhere(['like', BcCoronaFeedback::getTableSchema()->fullName . '.hamlet', $this->hamlet])
                ->andFilterWhere(['like', BcCoronaFeedback::getTableSchema()->fullName . '.gps', $this->gps])
                ->andFilterWhere(['like', BcCoronaFeedback::getTableSchema()->fullName . '.gps_accuracy', $this->gps_accuracy]);

        return $dataProvider;
    }
}
