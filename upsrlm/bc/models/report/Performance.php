<?php

namespace bc\models\report;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use common\models\User;
use common\models\base\GenralModel;
use common\models\master\MasterRole;

ini_set('memory_limit', '1024M');
ini_set('max_execution_time', 500);

/**
 * Report for Performance
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class Performance extends Model {

    public $master_partner_bank_id;
    public $bank_option = [];
    public $ordey_by_column = 'district_name';

    public function __construct($params) {
        $this->load($params);
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['master_partner_bank_id'], 'safe'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'master_partner_bank_id' => 'Partner agency',
        ];
    }

    public function chart($params, $user_model = null) {
        try {


            if (isset($params->attributes))
                $this->setAttributes($params->attributes);
            else {
                $this->load($params);
            }

            $sql = "SELECT  district_name  as  district_name ,
           no_of_gp AS no_of_gp,
           certified as certified,
           operational as operational,
           handheld_machine as handheld_machine,
           FLOOR((certified*100)/no_of_gp) as certified_percentage,
           operational_percentage as operational_percentage,
           avg_working_day_percentage as avg_working_day_percentage, 
           avg_transcation_rating as avg_transcation_rating,
           avg_commission_amount_rateing as avg_commission_amount_rateing
          FROM `district_partner_performances` ";
            $where = ' where district_partner_performances.no_of_gp!=0 ';
            if ($this->master_partner_bank_id) {
                $where .= ' and district_partner_performances.master_partner_bank_id=' . $this->master_partner_bank_id;
            }

            $sql .= $where;
            if ($this->ordey_by_column == 'district_name') {
                $sql .= "  ORDER BY district_name ASC";
            }
            if ($this->ordey_by_column == 'certified_percentage') {
                $sql .= "  ORDER BY certified_percentage DESC";
            }
            if ($this->ordey_by_column == 'operational_percentage') {
                $sql .= "  ORDER BY operational_percentage DESC";
            }
            if ($this->ordey_by_column == 'avg_working_day_percentage') {
                $sql .= "  ORDER BY avg_working_day_percentage DESC";
            }
            if ($this->ordey_by_column == 'avg_transcation_rating') {
                $sql .= "  ORDER BY avg_transcation_rating DESC";
            }
            if ($this->ordey_by_column == 'avg_commission_amount_rateing') {
                $sql .= "  ORDER BY avg_commission_amount_rateing DESC";
            }
            $result = \Yii::$app->dbbc->createCommand($sql)->queryAll();
            //print_r($result);exit;
            return $result;
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function chart1($params, $user_model = null) {
        try {
            $array['category'] = [];
            $array['certified_percentage'] = [];
            $array['operational_percentage'] = [];
            $array['avg_working_day_percentage'] = [];
            $array['avg_transcation_rating'] = [];
            $array['avg_commission_amount_rateing'] = [];

            if (isset($params->attributes))
                $this->setAttributes($params->attributes);
            else {
                $this->load($params);
            }

            $sql = "SELECT  district_name  as  district_name ,
           no_of_gp AS no_of_gp,
           certified as certified,
           operational as operational,
           handheld_machine as handheld_machine,
           FLOOR((pcertified*100)/no_of_gp) as certified_percentage,
           operational_percentage as operational_percentage,
           avg_working_day_percentage as avg_working_day_percentage, 
           avg_transcation_rating as avg_transcation_rating,
           avg_commission_amount_rateing as avg_commission_amount_rateing
          FROM `district_partner_performances` ";
            $where = ' where district_partner_performances.no_of_gp!=0 ';
            if ($this->master_partner_bank_id) {
                $where .= ' and district_partner_performances.master_partner_bank_id=' . $this->master_partner_bank_id;
            }

            $sql .= $where;
            if ($this->ordey_by_column == 'district_name') {
                $sql .= "  ORDER BY district_name ASC";
            }
            if ($this->ordey_by_column == 'certified_percentage') {
                $sql .= "  ORDER BY certified_percentage DESC";
            }
            if ($this->ordey_by_column == 'operational_percentage') {
                $sql .= "  ORDER BY operational_percentage DESC";
            }
            if ($this->ordey_by_column == 'avg_working_day_percentage') {
                $sql .= "  ORDER BY avg_working_day_percentage DESC";
            }
            if ($this->ordey_by_column == 'avg_transcation_rating') {
                $sql .= "  ORDER BY avg_transcation_rating DESC";
            }
            if ($this->ordey_by_column == 'avg_commission_amount_rateing') {
                $sql .= "  ORDER BY avg_commission_amount_rateing DESC";
            }
            $result = \Yii::$app->dbbc->createCommand($sql)->queryAll();
            foreach ($result as $responces) {
                array_push($array['category'], $responces['district_name']);
                array_push($array['certified_percentage'], (int) $responces['certified_percentage']);
                array_push($array['operational_percentage'], (int) $responces['operational_percentage']);
                array_push($array['avg_working_day_percentage'], (int) $responces['avg_working_day_percentage']);
                array_push($array['avg_transcation_rating'], (int) $responces['avg_transcation_rating']);
                array_push($array['avg_commission_amount_rateing'],(int) $responces['avg_commission_amount_rateing']);
            }
            //print_r($result);exit;
            return $array;
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
