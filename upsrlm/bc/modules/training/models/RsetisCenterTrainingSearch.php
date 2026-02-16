<?php

namespace bc\modules\training\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\training\models\RsetisCenterTraining;
use common\models\master\MasterRole;

/**
 * LifeAtLampSearch represents the model behind the search form of `app\models\lamp\LifeAtLamp`.
 */
class RsetisCenterTrainingSearch extends RsetisCenterTraining {

    public $center_option = [];
    public $district_option = [];
    public $district_code;
    public $s_date;
    public $e_date;
    public $date;
    public $format = 'Y-m-d';
    public $bc_partner_bank_option = [];
    public $rseti_bank_option = [];
    public $batch_size_option = [];
    public $bank_option = [];
    public $batch_size;
    public $rseti_bank;
    public $bc_partner_bank;
    public $master_partner_bank_id;
    public $aspirational;

    public function rules() {
        return [
            [['rsetis_center_id', 'training_start_date', 'training_end_date'], 'safe'],
            [['rsetis_center_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['training_start_date', 'training_end_date', 'district_code'], 'safe'],
            [['s_date', 'e_date'], 'safe'],
            [['date'], 'safe'],
            [['rseti_bank', 'bc_partner_bank', 'batch_size'], 'safe'],
            [['master_partner_bank_id'], 'safe'],
            [['aspirational'], 'safe'],
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
        $query = RsetisCenterTraining::find();
        if ($columns != NULL) {
            $query->select([$columns]);
        }
        if ($this->date != '') {
            $query->where(("'$this->date' BETWEEN `training_start_date` AND `training_end_date` "));
        }
        $query->andWhere(['!=', RsetisCenterTraining::getTableSchema()->fullName . '.status', -1]);
        $query->joinWith(['center']);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN, MasterRole::ROLE_SPM_FI_MF])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $query->andWhere([RsetisCenterTraining::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR])) {
                $query->andWhere([RsetisCenterTraining::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([RsetisCenterTraining::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([RsetisCenterTraining::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([RsetisCenterTraining::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $query->andWhere([RsetisCenterTraining::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([RsetisCenterTraining::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([RsetisCenterTraining::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } else {
                $query->where('0=1');
            }
        }
        if (isset($this->batch_size) and $this->batch_size != '') {
            if ($this->batch_size == '1') {
                $query->andWhere(['<', RsetisCenterTraining::getTableSchema()->fullName . '.no_of_participant', 20]);
            } else if ($this->batch_size == '2') {
                $query->andWhere(['between', RsetisCenterTraining::getTableSchema()->fullName . '.no_of_participant', '20', '30']);
            } else if ($this->batch_size == '3') {
                $query->andWhere(['>', RsetisCenterTraining::getTableSchema()->fullName . '.no_of_participant', 30]);
            }
        }
        if ($this->aspirational != '') {
            $query->joinWith(['district']);
            $query->andWhere([\bc\models\master\MasterDistrict::getTableSchema()->fullName . '.aspirational' => $this->aspirational]);
        }
        if ($columns != NULL) {
            $query->asArray();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['training_start_date' => SORT_DESC]],
        ]);
        if (isset($this->master_partner_bank_id) and $this->master_partner_bank_id != '') {
            $query->joinWith(['pbank']);
            $query->andWhere(['master_partner_bank_district.master_partner_bank_id' => $this->master_partner_bank_id]);
        }
        if (isset($this->rseti_bank) and $this->rseti_bank != '') {
            $query->joinWith(['rsethileadbank']);
            $query->andWhere(['user_profile.bank_name' => $this->rseti_bank]);
        }
        if (isset($this->bc_partner_bank) and $this->bc_partner_bank != '') {
            $query->joinWith(['bcbankpartner']);
            $query->andWhere(['user.id' => $this->bc_partner_bank]);
        }
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            RsetisCenterTraining::getTableSchema()->fullName . '.id' => $this->id,
            RsetisCenterTraining::getTableSchema()->fullName . '.rsetis_center_id' => $this->rsetis_center_id,
            RsetisCenterTraining::getTableSchema()->fullName . '.training_start_date' => $this->training_start_date,
            RsetisCenterTraining::getTableSchema()->fullName . '.training_end_date' => $this->training_end_date,
            RsetisCenter::getTableSchema()->fullName . '.district_code' => $this->district_code,
            RsetisCenterTraining::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        return $dataProvider;
    }

    public function calenderreport($params, $user_model = null, $pagination = true, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = RsetisCenterTraining::find();
        $query->select([
            "count(rsetis_center_training.id) AS no_of_batch",
            "SUM(rsetis_center_training.no_of_participant) AS no_of_participant",
            "SUM(rsetis_center_training.no_of_gp_covered) AS no_of_gp_covered",
        ]);
        if ($this->s_date != '' and $this->e_date != '') {
            $query->andWhere(['between', 'training_start_date', date('Y-m-d', strtotime($this->s_date)), date('Y-m-d', strtotime($this->e_date))])->orwhere(['between', 'training_end_date', date('Y-m-d', strtotime($this->s_date)), date('Y-m-d', strtotime($this->e_date))]);
        }
        $query->andWhere([RsetisCenterTraining::getTableSchema()->fullName . '.status' => 1]);
        $query->joinWith(['center']);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN, MasterRole::ROLE_SPM_FI_MF])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD, MasterRole::ROLE_SPM_FI_MF])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD, MasterRole::ROLE_SPM_FINANCE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $query->andWhere([RsetisCenter::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([RsetisCenter::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([RsetisCenter::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([RsetisCenter::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $query->andWhere([RsetisCenter::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([RsetisCenter::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([RsetisCenter::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } else {
                $query->where('0=1');
            }
        }
//        if ($this->s_date != '')
//            $query->andFilterWhere(['>=', RsetisCenterTraining::getTableSchema()->fullName . '.training_start_date', \Yii::$app->formatter->asDatetime($this->s_date, "php:" . $this->format)]);
//        if ($this->e_date != '')
//            $query->andFilterWhere(['<=', RsetisCenterTraining::getTableSchema()->fullName . '.training_end_date', \Yii::$app->formatter->asDatetime($this->e_date, "php:" . $this->format)]);
//        echo $query->createCommand()->getRawSql();exit;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            RsetisCenterTraining::getTableSchema()->fullName . '.id' => $this->id,
            RsetisCenterTraining::getTableSchema()->fullName . '.rsetis_center_id' => $this->rsetis_center_id,
            RsetisCenterTraining::getTableSchema()->fullName . '.training_start_date' => $this->training_start_date,
            RsetisCenterTraining::getTableSchema()->fullName . '.training_end_date' => $this->training_end_date,
            RsetisCenter::getTableSchema()->fullName . '.district_code' => $this->district_code,
        ]);

        return $dataProvider;
    }
}
