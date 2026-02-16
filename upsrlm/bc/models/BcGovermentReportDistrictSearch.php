<?php

namespace bc\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\BcGovermentReportDistrict;
use common\models\master\MasterRole;
use yii\helpers\ArrayHelper;

/**
 * BcGovermentReportBlockSearch represents the model behind the search form of `bc\models\BcGovermentReportBlock`.
 */
class BcGovermentReportDistrictSearch extends BcGovermentReportDistrict {

    public $district_option = [];
    public $block_option = [];
    public $division_option = [];
    public $date_option = [];

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['date'], 'required'],
            [['state_code', 'division_code', 'lgd_division_code', 'district_code', 'operational', 'trained_and_certified'], 'integer'],
            [['date', 'state_name', 'division_name', 'lgd_division_name', 'district_name'], 'safe'],
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
        $query = BcGovermentReportDistrict::find();

        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([BcGovermentReportDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL, MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([BcGovermentReportDistrict::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } else {
                $query->where('0=1');
            }
        }
        $query->andFilterWhere([
            BcGovermentReportDistrict::getTableSchema()->fullName . '.date' => $this->date,
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['district_name' => SORT_ASC]],
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 1000 : $pagination],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            BcGovermentReportDistrict::getTableSchema()->fullName . '.date' => $this->date,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.state_code' => $this->state_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.division_code' => $this->division_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.lgd_division_code' => $this->lgd_division_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.operational' => $this->operational,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.trained_and_certified' => $this->trained_and_certified,
        ]);

        $query->andFilterWhere(['like', BcGovermentReportDistrict::getTableSchema()->fullName . '.state_name', $this->state_name])
                ->andFilterWhere(['like', BcGovermentReportDistrict::getTableSchema()->fullName . '.division_name', $this->division_name])
                ->andFilterWhere(['like', BcGovermentReportDistrict::getTableSchema()->fullName . '.lgd_division_name', $this->lgd_division_name])
                ->andFilterWhere(['like', BcGovermentReportDistrict::getTableSchema()->fullName . '.district_name', $this->district_name])
        ;

        return $dataProvider;
    }

    public function getPushdates() {
        $query = BcGovermentReportBlock::find();
        $query->andFilterWhere([
            BcGovermentReportDistrict::getTableSchema()->fullName . '.state_code' => $this->state_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.division_code' => $this->division_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.lgd_division_code' => $this->lgd_division_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.operational' => $this->operational,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.trained_and_certified' => $this->trained_and_certified,
        ]);
        $query->select('date');
        $query->distinct('date');
        $query->orderBy(['date' => SORT_DESC]);
        return ArrayHelper::map($query->all(), 'date', 'date');
    }

    /**
     * Calling Agnets List
     *
     * @return void
     */
    public function getTotalpushday() {
        $query = BcGovermentReportBlock::find();
        $query->andFilterWhere([
            BcGovermentReportDistrict::getTableSchema()->fullName . '.state_code' => $this->state_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.division_code' => $this->division_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.lgd_division_code' => $this->lgd_division_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.operational' => $this->operational,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.trained_and_certified' => $this->trained_and_certified
        ]);
        $query->select('date');
        return $query->distinct('date')->count();
    }

    public function basicquery($query) {
        $query->andFilterWhere([
            BcGovermentReportDistrict::getTableSchema()->fullName . '.date' => $this->date,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.state_code' => $this->state_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.division_code' => $this->division_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.lgd_division_code' => $this->lgd_division_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.operational' => $this->operational,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.trained_and_certified' => $this->trained_and_certified,
        ]);

        return $query;
    }

    public function getTotaltc() {
        $query = BcGovermentReportDistrict::find();
        $this->basicquery($query);
        $query->select('trained_and_certified');
        return $query->sum('trained_and_certified');
    }

    public function getTotaloperational() {
        $query = BcGovermentReportDistrict::find();
        $this->basicquery($query);
        $query->select('operational');
        return $query->sum('operational');
    }

    public function getTcontc() {
        $query = BcGovermentReportDistrict::find();
        $this->basicquery($query);
        $query->select('change_trained_and_certified');
        $change_trained_and_certified = $query->sum('change_trained_and_certified');

        if ($change_trained_and_certified == 0) {
            $icon = '<i class="fal fa fa-arrow-right"></i>';
        }
        if ($change_trained_and_certified > 0) {
            $icon = '<i class="fal fa fa-arrow-up" style="color:green"></i>';
        }
        if ($change_trained_and_certified < 0) {
            $icon = '<i class="fal fa fa-arrow-down" style="color:red"></i>';
        }
        return $icon;
    }
    public function getTconop() {
        $query = BcGovermentReportDistrict::find();
        $this->basicquery($query);
        $query->select('change_operational');
        $change_operational= $query->sum('change_operational');

        if ($change_operational == 0) {
            $icon = '<i class="fal fa fa-arrow-right"></i>';
        }
        if ($change_operational > 0) {
            $icon = '<i class="fal fa fa-arrow-up" style="color:green"></i>';
        }
        if ($change_operational < 0) {
            $icon = '<i class="fal fa fa-arrow-down" style="color:red"></i>';
        }
        return $icon;
    }

    public function getFirstpushdate() {
        $query = BcGovermentReportDistrict::find();
        $query->andFilterWhere([
            BcGovermentReportDistrict::getTableSchema()->fullName . '.state_code' => $this->state_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.division_code' => $this->division_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.lgd_division_code' => $this->lgd_division_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.operational' => $this->operational,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.trained_and_certified' => $this->trained_and_certified,
        ]);
        $query->select('date');
        $first = $query->orderBy(['date' => SORT_ASC])->limit(1)->one();
        if ($first) {
            return $first->date;
        }
    }

    /**
     * Agent Last Call
     *
     * @return void
     */
    public function getLastpushdate() {
        $query = BcGovermentReportDistrict::find();
        $query->andFilterWhere([
            BcGovermentReportDistrict::getTableSchema()->fullName . '.state_code' => $this->state_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.division_code' => $this->division_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.lgd_division_code' => $this->lgd_division_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.operational' => $this->operational,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.trained_and_certified' => $this->trained_and_certified,
        ]);
        $query->select('date');
        $last = $query->orderBy(['date' => SORT_DESC])->limit(1)->one();
        if ($last) {
            return $last->date;
        }
    }

    public function getRemainpushday() {
        $query = BcGovermentReportDistrict::find();
        $query->andFilterWhere([
            BcGovermentReportDistrict::getTableSchema()->fullName . '.state_code' => $this->state_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.division_code' => $this->division_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.lgd_division_code' => $this->lgd_division_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.operational' => $this->operational,
            BcGovermentReportDistrict::getTableSchema()->fullName . '.trained_and_certified' => $this->trained_and_certified,
        ]);
        $query->select('date');
        $query->distinct('date');
        return $query->distinct('date')->count();
    }
}
