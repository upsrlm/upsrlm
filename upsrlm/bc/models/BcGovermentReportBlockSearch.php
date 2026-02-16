<?php

namespace bc\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\models\BcGovermentReportBlock;
use common\models\master\MasterRole;
use yii\helpers\ArrayHelper;
/**
 * BcGovermentReportBlockSearch represents the model behind the search form of `bc\models\BcGovermentReportBlock`.
 */
class BcGovermentReportBlockSearch extends BcGovermentReportBlock {

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
            [['id', 'state_code', 'division_code', 'lgd_division_code', 'district_code', 'block_code', 'operational', 'trained_and_certified', 'is_operation_decreased', 'is_trained_certified_decreased', 'is_pushed'], 'integer'],
            [['date', 'state_name', 'division_name', 'lgd_division_name', 'district_name', 'block_name', 'push_datetime', 'last_updated_on'], 'safe'],
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
        $query = BcGovermentReportBlock::find();

        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([BcGovermentReportBlock::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([BcGovermentReportBlock::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } else {
                $query->where('0=1');
            }
        }
        $query->andFilterWhere([
            
            BcGovermentReportBlock::getTableSchema()->fullName . '.date' => $this->date,
           
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['district_name' => SORT_ASC,'block_name' => SORT_ASC]],
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
            BcGovermentReportBlock::getTableSchema()->fullName . '.id' => $this->id,
            BcGovermentReportBlock::getTableSchema()->fullName . '.date' => $this->date,
            BcGovermentReportBlock::getTableSchema()->fullName . '.state_code' => $this->state_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.division_code' => $this->division_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.lgd_division_code' => $this->lgd_division_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.operational' => $this->operational,
            BcGovermentReportBlock::getTableSchema()->fullName . '.trained_and_certified' => $this->trained_and_certified,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_operation_decreased' => $this->is_operation_decreased,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_trained_certified_decreased' => $this->is_trained_certified_decreased,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_pushed' => $this->is_pushed,
            BcGovermentReportBlock::getTableSchema()->fullName . '.push_datetime' => $this->push_datetime,
            BcGovermentReportBlock::getTableSchema()->fullName . '.last_updated_on' => $this->last_updated_on,
        ]);

        $query->andFilterWhere(['like', BcGovermentReportBlock::getTableSchema()->fullName . '.state_name', $this->state_name])
                ->andFilterWhere(['like', BcGovermentReportBlock::getTableSchema()->fullName . '.division_name', $this->division_name])
                ->andFilterWhere(['like', BcGovermentReportBlock::getTableSchema()->fullName . '.lgd_division_name', $this->lgd_division_name])
                ->andFilterWhere(['like', BcGovermentReportBlock::getTableSchema()->fullName . '.district_name', $this->district_name])
                ->andFilterWhere(['like', BcGovermentReportBlock::getTableSchema()->fullName . '.block_name', $this->block_name]);

        return $dataProvider;
    }

    public function getPushdates() {
        $query = BcGovermentReportBlock::find();
        $query->andFilterWhere([
            BcGovermentReportBlock::getTableSchema()->fullName . '.state_code' => $this->state_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.division_code' => $this->division_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.lgd_division_code' => $this->lgd_division_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.operational' => $this->operational,
            BcGovermentReportBlock::getTableSchema()->fullName . '.trained_and_certified' => $this->trained_and_certified,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_operation_decreased' => $this->is_operation_decreased,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_trained_certified_decreased' => $this->is_trained_certified_decreased,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_pushed' => 1,
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
            BcGovermentReportBlock::getTableSchema()->fullName . '.state_code' => $this->state_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.division_code' => $this->division_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.lgd_division_code' => $this->lgd_division_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.operational' => $this->operational,
            BcGovermentReportBlock::getTableSchema()->fullName . '.trained_and_certified' => $this->trained_and_certified,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_operation_decreased' => $this->is_operation_decreased,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_trained_certified_decreased' => $this->is_trained_certified_decreased,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_pushed' => 1,
        ]);
        $query->select('date');
        return $query->distinct('date')->count();
    }

    public function basicquery($query) {
        $query->andFilterWhere([
            BcGovermentReportBlock::getTableSchema()->fullName . '.date' => $this->date,
            BcGovermentReportBlock::getTableSchema()->fullName . '.state_code' => $this->state_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.division_code' => $this->division_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.lgd_division_code' => $this->lgd_division_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.operational' => $this->operational,
            BcGovermentReportBlock::getTableSchema()->fullName . '.trained_and_certified' => $this->trained_and_certified,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_operation_decreased' => $this->is_operation_decreased,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_trained_certified_decreased' => $this->is_trained_certified_decreased,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_pushed' => $this->is_pushed,
            BcGovermentReportBlock::getTableSchema()->fullName . '.push_datetime' => $this->push_datetime,
            BcGovermentReportBlock::getTableSchema()->fullName . '.last_updated_on' => $this->last_updated_on,
        ]);

        return $query;
    }

    public function getTotaltc() {
        $query = BcGovermentReportBlock::find();
        $this->basicquery($query);
        $query->select('trained_and_certified');
        return $query->sum('trained_and_certified');
    }

    public function getTotaloperational() {
        $query = BcGovermentReportBlock::find();
        $this->basicquery($query);
        $query->select('operational');
        return $query->sum('operational');
    }
    public function getTcontc() {
        $query = BcGovermentReportBlock::find();
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
        $query = BcGovermentReportBlock::find();
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
        $query = BcGovermentReportBlock::find();
        $query->andFilterWhere([
            BcGovermentReportBlock::getTableSchema()->fullName . '.state_code' => $this->state_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.division_code' => $this->division_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.lgd_division_code' => $this->lgd_division_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.operational' => $this->operational,
            BcGovermentReportBlock::getTableSchema()->fullName . '.trained_and_certified' => $this->trained_and_certified,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_operation_decreased' => $this->is_operation_decreased,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_trained_certified_decreased' => $this->is_trained_certified_decreased,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_pushed' => 1,
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
        $query = BcGovermentReportBlock::find();
        $query->andFilterWhere([
            BcGovermentReportBlock::getTableSchema()->fullName . '.state_code' => $this->state_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.division_code' => $this->division_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.lgd_division_code' => $this->lgd_division_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.operational' => $this->operational,
            BcGovermentReportBlock::getTableSchema()->fullName . '.trained_and_certified' => $this->trained_and_certified,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_operation_decreased' => $this->is_operation_decreased,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_trained_certified_decreased' => $this->is_trained_certified_decreased,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_pushed' => 1,
        ]);
        $query->select('date');
        $last = $query->orderBy(['date' => SORT_DESC])->limit(1)->one();
        if ($last) {
            return $last->date;
        }
    }

    public function getRemainpushday() {
        $query = BcGovermentReportBlock::find();
        $query->andFilterWhere([
            BcGovermentReportBlock::getTableSchema()->fullName . '.state_code' => $this->state_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.division_code' => $this->division_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.lgd_division_code' => $this->lgd_division_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.district_code' => $this->district_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.block_code' => $this->block_code,
            BcGovermentReportBlock::getTableSchema()->fullName . '.operational' => $this->operational,
            BcGovermentReportBlock::getTableSchema()->fullName . '.trained_and_certified' => $this->trained_and_certified,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_operation_decreased' => $this->is_operation_decreased,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_trained_certified_decreased' => $this->is_trained_certified_decreased,
            BcGovermentReportBlock::getTableSchema()->fullName . '.is_pushed' => 0,
        ]);
        $query->select('date');
        $query->distinct('date');
        return $query->distinct('date')->count();
    }
}
