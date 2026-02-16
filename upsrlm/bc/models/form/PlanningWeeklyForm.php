<?php

namespace bc\models\form;

use bc\models\PartnerBankDistrictPlanning;
use bc\models\PartnerBankDistrictPlanningDetail;
use Yii;

/**
 * PlanningWeeklyForm is the model behind the PartnerBankDistrictPlanningDetail
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class PlanningWeeklyForm extends \yii\base\Model {

    public $id;
    public $partner_bank_district_planning_id;
    public $week;
    public $month;
    public $year;
    public $week_name;
    public $onboarding;
    public $ac_opening;
    public $supply_equipment;
    public $operational;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;

    public function __construct() {
        
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['partner_bank_district_planning_id', 'week', 'onboarding', 'ac_opening', 'supply_equipment', 'operational', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['week', 'onboarding', 'ac_opening', 'supply_equipment', 'operational'], 'required'],
            [['week_name'],'safe'],
            [['onboarding'], 'default', 'value' => 0],
            [['ac_opening'], 'default', 'value' => 0],
            [['supply_equipment'], 'default', 'value' => 0],
            [['operational'], 'default', 'value' => 0],
            [['month'], 'default', 'value' => date('m')],
            [['year'], 'default', 'value' => date('Y')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'partner_bank_district_planning_id' => 'Bank District',
            'week' => 'Week',
            'onboarding' => 'Onboarding',
            'ac_opening' => 'A/c opening',
            'supply_equipment' => 'Supply Equipment',
            'operational' => 'Operational',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

}
