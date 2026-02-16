<?php

namespace bc\models\srlm\report;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\base\GenralModel;
use yii\helpers\ArrayHelper;

/**
 * Report  
 */
class Graph extends Model {

    public $division_code;
    public $district_code;
    public $sub_district_code;
    public $block_code;
    public $village_code;
    public $gram_panchayat_code;
    public $section_at;
    public $start_date;
    public $end_date;
    public $created_by;
    public $status;
    public $change_type = "";
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $village_option = [];
    public $status_option = [];
    public $graph_selection;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['district_code', 'sub_district_code', 'block_code', 'village_code', 'gram_panchayat_code', 'section_at'], 'safe'],
            [['start_date', 'end_date', 'status', 'graph_selection', 'division_code'], 'safe'],
        ];
    }

    public function attributeLabels() {
        return [
            'district_code' => 'District',
            'division_code' => 'Division',
            'block_code' => 'Block',
            'gram_panchayat_code' => 'Gram Panchayat',
            'village_code' => 'Village',
            'section_at' => 'Section At',
            'status' => 'Hhs Status',
        ];
    }

    public function mu($params) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $graph = [];

        $query = "SELECT
                      SUM(CASE WHEN srlmbc.marital_status  = '1' THEN 1 ELSE 0 END) AS married,
                      SUM(CASE WHEN srlmbc.marital_status  = '2' THEN 1 ELSE 0 END) AS unmarried,
                      COUNT(*) AS total
                      FROM  srlm_bc_application AS srlmbc";
        $where = " where srlmbc.status !=-1 and srlmbc.form_number=6 and srlmbc.gender=2";
        if ($this->division_code) {
            $where .= ' and srlmbc.division_code=' . $this->division_code;
        }
        if ($this->district_code) {
            $where .= ' and srlmbc.district_code=' . $this->district_code;
        }
        if ($this->block_code) {
            $where .= ' and srlmbc.block_code=' . $this->block_code;
        }
        if ($this->gram_panchayat_code) {
            $where .= ' and srlmbc.gram_panchayat_code=' . $this->gram_panchayat_code;
        }
        if ($this->village_code) {
            $where .= ' and srlmbc.village_code=' . $this->village_code;
        }
        if ($this->graph_selection) {
            $where .= ' and srlmbc.status=' . $this->status;
        }
        $query .= $where;
        $graph = \Yii::$app->dbbc->createCommand($query)->queryOne();
        return $graph;
    }

    public function phone_type($params) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $graph = [];

        $query = "SELECT
                      SUM(CASE WHEN srlmbc.phone_type  = '1' THEN 1 ELSE 0 END) AS pt1,
                      SUM(CASE WHEN srlmbc.phone_type  = '2' THEN 1 ELSE 0 END) AS pt2,
                      COUNT(*) AS total
                      FROM  srlm_bc_application AS srlmbc";
        $where = " where srlmbc.status !=-1 and srlmbc.form_number=6 and srlmbc.gender=2";
        if ($this->division_code) {
            $where .= ' and srlmbc.division_code=' . $this->division_code;
        }
        if ($this->district_code) {
            $where .= ' and srlmbc.district_code=' . $this->district_code;
        }
        if ($this->block_code) {
            $where .= ' and srlmbc.block_code=' . $this->block_code;
        }
        if ($this->gram_panchayat_code) {
            $where .= ' and srlmbc.gram_panchayat_code=' . $this->gram_panchayat_code;
        }
        if ($this->village_code) {
            $where .= ' and srlmbc.village_code=' . $this->village_code;
        }
        if ($this->graph_selection) {
            $where .= ' and srlmbc.status=' . $this->status;
        }
        $query .= $where;
        $graph = \Yii::$app->dbbc->createCommand($query)->queryOne();
        return $graph;
    }

    public function whatsup($params) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $graph = [];

        $query = "SELECT
                      SUM(CASE WHEN srlmbc.whats_app_number  = '1' THEN 1 ELSE 0 END) AS yes,
                      SUM(CASE WHEN srlmbc.whats_app_number  = '2' THEN 1 ELSE 0 END) AS no,
                      COUNT(*) AS total
                      FROM  srlm_bc_application AS srlmbc";
    $where = " where srlmbc.status !=-1 and srlmbc.form_number=6 and srlmbc.gender=2";
        if ($this->division_code) {
            $where .= ' and srlmbc.division_code=' . $this->division_code;
        }
        if ($this->district_code) {
            $where .= ' and srlmbc.district_code=' . $this->district_code;
        }
        if ($this->block_code) {
            $where .= ' and srlmbc.block_code=' . $this->block_code;
        }
        if ($this->gram_panchayat_code) {
            $where .= ' and srlmbc.gram_panchayat_code=' . $this->gram_panchayat_code;
        }
        if ($this->village_code) {
            $where .= ' and srlmbc.village_code=' . $this->village_code;
        }
        if ($this->graph_selection) {
            $where .= ' and srlmbc.status=' . $this->status;
        }
        $query .= $where;
        $graph = \Yii::$app->dbbc->createCommand($query)->queryOne();
        return $graph;
    }

    public function edu($params) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $graph = [];

        $query = "SELECT
                      SUM(CASE WHEN srlmbc.reading_skills  = '1' THEN 1 ELSE 0 END) AS reds1,
                      SUM(CASE WHEN srlmbc.reading_skills  = '2' THEN 1 ELSE 0 END) AS reds2,
                      SUM(CASE WHEN srlmbc.reading_skills  = '3' THEN 1 ELSE 0 END) AS reds3,
                      SUM(CASE WHEN srlmbc.reading_skills  = '4' THEN 1 ELSE 0 END) AS reds4,
                      SUM(CASE WHEN srlmbc.reading_skills  = '5' THEN 1 ELSE 0 END) AS reds5,
                      COUNT(*) AS total
                      FROM  srlm_bc_application AS srlmbc";
        $where = " where srlmbc.status !=-1 and srlmbc.form_number=6 and srlmbc.gender=2";
        if ($this->division_code) {
            $where .= ' and srlmbc.division_code=' . $this->division_code;
        }
        if ($this->district_code) {
            $where .= ' and srlmbc.district_code=' . $this->district_code;
        }
        if ($this->block_code) {
            $where .= ' and srlmbc.block_code=' . $this->block_code;
        }
        if ($this->gram_panchayat_code) {
            $where .= ' and srlmbc.gram_panchayat_code=' . $this->gram_panchayat_code;
        }
        if ($this->village_code) {
            $where .= ' and srlmbc.village_code=' . $this->village_code;
        }
        if ($this->graph_selection) {
            $where .= ' and srlmbc.status=' . $this->status;
        }
        $query .= $where;
        $graph = \Yii::$app->dbbc->createCommand($query)->queryOne();
        return $graph;
    }

    public function cast($params) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $graph = [];

        $query = "SELECT
                      SUM(CASE WHEN srlmbc.cast  = '1' THEN 1 ELSE 0 END) AS cast1,
                      SUM(CASE WHEN srlmbc.cast  = '2' THEN 1 ELSE 0 END) AS cast2,
                      SUM(CASE WHEN srlmbc.cast  = '3' THEN 1 ELSE 0 END) AS cast3,
                      SUM(CASE WHEN srlmbc.cast  = '4' THEN 1 ELSE 0 END) AS cast4,
                      COUNT(*) AS total
                      FROM  srlm_bc_application AS srlmbc";
        $where = " where srlmbc.status !=-1 and srlmbc.form_number=6 and srlmbc.gender=2";
        if ($this->division_code) {
            $where .= ' and srlmbc.division_code=' . $this->division_code;
        }
        if ($this->district_code) {
            $where .= ' and srlmbc.district_code=' . $this->district_code;
        }
        if ($this->block_code) {
            $where .= ' and srlmbc.block_code=' . $this->block_code;
        }
        if ($this->gram_panchayat_code) {
            $where .= ' and srlmbc.gram_panchayat_code=' . $this->gram_panchayat_code;
        }
        if ($this->village_code) {
            $where .= ' and srlmbc.village_code=' . $this->village_code;
        }
        if ($this->graph_selection) {
            $where .= ' and srlmbc.status=' . $this->status;
        }
        $query .= $where;
        $graph = \Yii::$app->dbbc->createCommand($query)->queryOne();
        return $graph;
    }

    public function agm($params) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $graph = [];

        $query = "SELECT
                      SUM(CASE WHEN srlmbc.already_group_member  = '1' THEN 1 ELSE 0 END) AS agm1,
                      SUM(CASE WHEN srlmbc.already_group_member  = '2' THEN 1 ELSE 0 END) AS agm2,
                      SUM(CASE WHEN srlmbc.already_group_member  = '3' THEN 1 ELSE 0 END) AS agm3,
                      SUM(CASE WHEN srlmbc.already_group_member  = '4' THEN 1 ELSE 0 END) AS agm4,
                      SUM(CASE WHEN srlmbc.already_group_member  = '5' THEN 1 ELSE 0 END) AS agm5,
                      SUM(CASE WHEN srlmbc.already_group_member  = '6' THEN 1 ELSE 0 END) AS agm6,
                      SUM(CASE WHEN srlmbc.already_group_member  = '7' THEN 1 ELSE 0 END) AS agm7,
                      SUM(CASE WHEN srlmbc.already_group_member  = '8' THEN 1 ELSE 0 END) AS agm8,
                      SUM(CASE WHEN srlmbc.already_group_member  = '9' THEN 1 ELSE 0 END) AS agm9,
                      SUM(CASE WHEN srlmbc.already_group_member  = '10' THEN 1 ELSE 0 END) AS agm10,
                      SUM(CASE WHEN srlmbc.already_group_member  = '11' THEN 1 ELSE 0 END) AS agm11,
                      SUM(CASE WHEN srlmbc.already_group_member  = '12' THEN 1 ELSE 0 END) AS agm12,
                      SUM(CASE WHEN srlmbc.already_group_member  = '13' THEN 1 ELSE 0 END) AS agm13,
                      COUNT(*) AS total
                      FROM  srlm_bc_application AS srlmbc";
        $where = " where srlmbc.status !=-1 and srlmbc.form_number=6 and srlmbc.gender=2";
        if ($this->division_code) {
            $where .= ' and srlmbc.division_code=' . $this->division_code;
        }
        if ($this->district_code) {
            $where .= ' and srlmbc.district_code=' . $this->district_code;
        }
        if ($this->block_code) {
            $where .= ' and srlmbc.block_code=' . $this->block_code;
        }
        if ($this->gram_panchayat_code) {
            $where .= ' and srlmbc.gram_panchayat_code=' . $this->gram_panchayat_code;
        }
        if ($this->village_code) {
            $where .= ' and srlmbc.village_code=' . $this->village_code;
        }
        if ($this->graph_selection) {
            $where .= ' and srlmbc.status=' . $this->status;
        }
        $query .= $where;
        $graph = \Yii::$app->dbbc->createCommand($query)->queryOne();
        return $graph;
    }

    public function age($params) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $graph = [];

        $query = "SELECT
                      SUM(IF(age BETWEEN 18 and 25,1,0)) AS age1,
                      SUM(IF(age BETWEEN 26 and 32,1,0)) AS age2,
                      SUM(IF(age BETWEEN 33 and 40,1,0)) AS age3,
                      SUM(IF(age BETWEEN 41 and 50,1,0)) AS age4,
                      SUM(IF(age > 50,1,0)) AS age5,
                      COUNT(*) AS total
                      FROM  srlm_bc_application AS srlmbc";
        $where = " where srlmbc.status !=-1 and srlmbc.form_number=6 and srlmbc.gender=2";
        if ($this->division_code) {
            $where .= ' and srlmbc.division_code=' . $this->division_code;
        }
        if ($this->district_code) {
            $where .= ' and srlmbc.district_code=' . $this->district_code;
        }
        if ($this->block_code) {
            $where .= ' and srlmbc.block_code=' . $this->block_code;
        }
        if ($this->gram_panchayat_code) {
            $where .= ' and srlmbc.gram_panchayat_code=' . $this->gram_panchayat_code;
        }
        if ($this->village_code) {
            $where .= ' and srlmbc.village_code=' . $this->village_code;
        }
        if ($this->graph_selection) {
            $where .= ' and srlmbc.status=' . $this->status;
        }
        $query .= $where;
        $graph = \Yii::$app->dbbc->createCommand($query)->queryOne();
        return $graph;
    }

}
