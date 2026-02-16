<?php

namespace bc\modules\training\models;

use Yii;
use common\models\User;
use bc\modules\training\models\RsetisCenterTraining;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\modules\training\models\RsetisEcalendar;

class TrainingEntity {

    public $training_model;
    public $start_date;
    public $end_date;
    public $district_code;
    public $state_code = 0;
    public $ecalendar_model_district;
    public $ecalendar_model_state;

    public function __construct(RsetisCenterTraining $training_model) {
        $this->training_model = $training_model;
        $this->start_date = $this->training_model->training_start_date;
        $this->end_date = $this->training_model->training_end_date;
        $this->district_code = $this->training_model->district_code;
    }

    public function calendarpopulate() {
        if ($this->training_model != null) {
            $begin = new \DateTime($this->start_date);
            $end = new \DateTime($this->end_date);
            $end = $end->modify('+1 day');
            $interval = new \DateInterval('P1D');
            $daterange = new \DatePeriod($begin, $interval, $end);

            foreach ($daterange as $date) {
                $training_date1=$date->format("Y-m-d");
                $training_date = "'" . $date->format("Y-m-d") . "'";
                $querytd = "SELECT
                      COUNT(*) AS total
                      FROM  rsetis_center_training AS rct";
                $wheretd = " where ( $training_date BETWEEN `training_start_date` AND `training_end_date` ) and rct.status != -1 ";
                $wheretd .= ' and rct.district_code=' . $this->district_code;
                $querytd .= $wheretd;
                $district_t_count = \Yii::$app->dbbc->createCommand($querytd)->queryScalar();
                $queryts = "SELECT
                      COUNT(*) AS total
                      FROM  rsetis_center_training AS rct";
                $wherets = " where ( $training_date BETWEEN `training_start_date` AND `training_end_date` ) and rct.status != -1 ";
                $queryts .= $wherets;
                $state_t_count = \Yii::$app->dbbc->createCommand($queryts)->queryScalar();
               
                $querypd = "SELECT
                      COUNT(*) AS total
                      FROM  rsetis_batch_participants AS rbp  
                      join  rsetis_center_training on rsetis_center_training.id=rbp.rsetis_center_training_id 
                    ";
                          
                $wherepd = " where ( $training_date BETWEEN `training_start_date` AND `training_end_date` ) and rbp.status != -1 ";
                $wherepd .= ' and rbp.district_code=' . $this->district_code;
                $querypd .= $wherepd;
                $district_p_count = \Yii::$app->dbbc->createCommand($querypd)->queryScalar();
                $queryps = "SELECT
                      COUNT(*) AS total
                      FROM  rsetis_batch_participants AS rbp  
                      join  rsetis_center_training on rsetis_center_training.id=rbp.rsetis_center_training_id";
                $whereps = " where ( $training_date BETWEEN `training_start_date` AND `training_end_date` ) and rbp.status != -1 ";
                $queryps .= $whereps;
                $state_p_count = \Yii::$app->dbbc->createCommand($queryps)->queryScalar();

//            Error in cod
//                $t_query = RsetisCenterTraining::find();
//                $t_query->select('id')->where(['between', new \yii\db\Expression($training_date), 'training_start_date', 'training_end_date'])->andWhere(['rsetis_center_training.status' => 1]);
//                $state_t_count = $t_query->count();
//                $district_t_count = $t_query->andWhere(['district_code' => $this->district_code])->count();
//
//                $p_query = RsetisBatchParticipants::find();
//                $p_query->select('id')->where(['between', new \yii\db\Expression($training_date), 'training_start_date', 'training_end_date'])->andWhere(['rsetis_batch_participants.status' => 1]);
//                $state_p_count = $p_query->count();
//                $district_p_count = $p_query->andWhere(['district_code' => $this->district_code])->count();
                $this->ecalendar_model_district = RsetisEcalendar::find()->where(['date' => $training_date1, 'district_code' => $this->district_code])->one();
                $this->ecalendar_model_state = RsetisEcalendar::find()->where(['date' => $training_date1, 'district_code' => $this->state_code])->one();
                if ($this->ecalendar_model_district == null) {
                    $this->ecalendar_model_district = new RsetisEcalendar();
                }
                $this->ecalendar_model_district->date = $training_date1;
                $this->ecalendar_model_district->district_code = $this->district_code;
                $this->ecalendar_model_district->total_training = $district_t_count;
                $this->ecalendar_model_district->total_participant = $district_p_count;
                $this->ecalendar_model_district->status = 1;
                $this->ecalendar_model_district->save();
                if ($this->ecalendar_model_state == null) {
                    $this->ecalendar_model_state = new RsetisEcalendar();
                }
                $this->ecalendar_model_state->date = $training_date1;
                $this->ecalendar_model_state->district_code = $this->state_code;
                $this->ecalendar_model_state->total_training = $state_t_count;
                $this->ecalendar_model_state->total_participant = $state_p_count;
                $this->ecalendar_model_state->status = 1;
                $this->ecalendar_model_state->save();
            }
        }
    }

}
