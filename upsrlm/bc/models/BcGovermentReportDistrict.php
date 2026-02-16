<?php

namespace bc\models;

use Yii;

/**
 * This is the model class for table "bc_goverment_report_district".
 *
 * @property string|null $date
 * @property int $state_code
 * @property string $state_name
 * @property int|null $division_code
 * @property string|null $division_name
 * @property int|null $lgd_division_code
 * @property string|null $lgd_division_name
 * @property int|null $district_code
 * @property string|null $district_name
 * @property float|null $operational
 * @property float|null $trained_and_certified
 * @property float|null $change_operational
 * @property float|null $change_trained_and_certified
 * @property float|null $change_calculated
 */
class BcGovermentReportDistrict extends BcactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'bc_goverment_report_district';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['date'], 'safe'],
            [['state_code', 'division_code', 'lgd_division_code', 'district_code'], 'integer'],
            [['operational', 'trained_and_certified', 'change_operational', 'change_trained_and_certified', 'change_calculated'], 'number'],
            [['state_name'], 'string', 'max' => 100],
            [['division_name'], 'string', 'max' => 155],
            [['lgd_division_name', 'district_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'date' => 'Date',
            'state_code' => 'State Code',
            'state_name' => 'State Name',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'lgd_division_code' => 'Lgd Division Code',
            'lgd_division_name' => 'Lgd Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'operational' => 'Operational',
            'trained_and_certified' => 'Trained And Certified',
            'change_operational' => 'Change Operational',
            'change_trained_and_certified' => 'Change Trained And Certified',
            'change_calculated' => 'Change Calculated',
        ];
    }

    public function getPredata() {
        $date = new \DateTime($this->date);
        $date->modify('-1 day');
        $predate = $date->format('Y-m-d');
        return $this->hasOne(BcGovermentReportDistrict::className(), ['district_code' => 'district_code'])->andWhere(['=', 'date', $predate]);
    }

    public function getDistrict() {
        return $this->hasOne(master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getDiv() {
        return $this->hasOne(master\MasterDivision::className(), ['division_code' => 'division_code']);
    }

    public function getIconop() {
        $icon = '';
        $operational = 0;
        if ($this->predata != null) {
            $operational = $this->predata->operational;
        }
        $change_operational = $this->operational - $operational;
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

    public function getIconts() {
        $icon = '';
        $trained_and_certified = 0;
        if ($this->predata != null) {
            $trained_and_certified = $this->predata->trained_and_certified;
        }
        $change_trained_and_certified = $this->trained_and_certified - $trained_and_certified;
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
}
