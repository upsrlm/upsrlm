<?php

namespace bc\models\form;

use Yii;
use bc\models\PartnerBankDistrictPlanning;
use bc\models\PartnerBankDistrictPlanningDetail;
use bc\models\form\PlanningWeeklyForm;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * PlanningForm is the model behind the PartnerBankDistrictPlanningDetail
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class PlanningForm extends \yii\base\Model {

    public $id;
    public $partner_bank_district_planning_id;
    public $partner_bank_district_model;
    public $weekly_planning_model;
    public $month;
    public $year;

    const WEEK_ROW_INIT = 5;

    public function __construct($partner_bank_district_model) {
        $this->month = (int) date('m');
        $this->year = date('Y');
        $this->partner_bank_district_model = $partner_bank_district_model;
        $this->load(\Yii::$app->request->post());
        if ($this->partner_bank_district_model != null) {
            $this->partner_bank_district_planning_id = $this->partner_bank_district_model->id;
        }
        $this->weekly_planning_model[] = new PlanningWeeklyForm();
        $week_option = [1 => 'Week 1', 2 => 'Week 2', 3 => 'Week 3', 4 => 'Week 4', 5 => 'Week 5'];
        foreach ($week_option as $key => $value) {
            $this->weekly_planning_model[$key - 1] = new PlanningWeeklyForm();
            $this->weekly_planning_model[$key - 1]->partner_bank_district_planning_id = $this->partner_bank_district_planning_id;
            $this->weekly_planning_model[$key - 1]->week = $key;
            $this->weekly_planning_model[$key - 1]->week_name = $value;
            $this->weekly_planning_model[$key - 1]->month = $this->month;
            $this->weekly_planning_model[$key - 1]->year = $this->year;
        }
        $planning_weekly = $this->partner_bank_district_model->getWeekly()->andWhere(['month' => $this->month, 'year' => $this->year])->all();

        if (isset($planning_weekly)) {
            foreach ($planning_weekly as $key => $weekly_planning) {
                $this->weekly_planning_model[$key] = new PlanningWeeklyForm();
                $this->weekly_planning_model[$key]->id = $weekly_planning->id;
                $this->weekly_planning_model[$key]->partner_bank_district_planning_id = $weekly_planning->partner_bank_district_planning_id;
                $this->weekly_planning_model[$key]->week = $weekly_planning->week;
                $this->weekly_planning_model[$key]->month = $weekly_planning->month;
                $this->weekly_planning_model[$key]->year = $weekly_planning->year;
                $this->weekly_planning_model[$key]->week_name = $week_option[$weekly_planning->week];
                $this->weekly_planning_model[$key]->onboarding = $weekly_planning->onboarding;
                $this->weekly_planning_model[$key]->ac_opening = $weekly_planning->ac_opening;
                $this->weekly_planning_model[$key]->supply_equipment = $weekly_planning->supply_equipment;
                $this->weekly_planning_model[$key]->operational = $weekly_planning->operational;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['partner_bank_district_planning_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'partner_bank_district_planning_id' => 'Bank District',
        ];
    }

    public function save() {

        try {
            if (!$this->validate()) {
                return false;
            }
            foreach ($this->weekly_planning_model as $key => $weekly_planning) {
                $weekly_planning_model = PartnerBankDistrictPlanningDetail::find()->where(['week' => $weekly_planning->week,'month' => $this->month,'year' => $this->year, 'partner_bank_district_planning_id' => $this->partner_bank_district_planning_id])->one();
                if ($weekly_planning_model == null) {
                    $weekly_planning_model = new PartnerBankDistrictPlanningDetail();
                }
                $weekly_planning_model->partner_bank_district_planning_id = $this->partner_bank_district_planning_id;
                $weekly_planning_model->week = $weekly_planning->week;
                $weekly_planning_model->month = $this->month;
                $weekly_planning_model->year = $this->year;
                $weekly_planning_model->onboarding = $weekly_planning->onboarding;
                $weekly_planning_model->ac_opening = $weekly_planning->ac_opening;
                $weekly_planning_model->supply_equipment = $weekly_planning->supply_equipment;
                $weekly_planning_model->supply_equipment = $weekly_planning->supply_equipment;
                $weekly_planning_model->operational = $weekly_planning->operational;
                $weekly_planning_model->status = 1;

                $weekly_planning_model->save();
            }
            $this->partner_bank_district_model->save();

            return $this;
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
            exit;
        }
    }

}
