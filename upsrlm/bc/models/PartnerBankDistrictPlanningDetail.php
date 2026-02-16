<?php

namespace bc\models;

use Yii;

/**
 * This is the model class for table "partner_bank_district_planning_detail".
 *
 * @property int $id
 * @property int|null $partner_bank_district_planning_id
 * @property int|null $week
 * @property int|null $month
 * @property string|null $year
 * @property int|null $onboarding
 * @property int|null $ac_opening
 * @property int|null $supply_equipment
 * @property int|null $operational
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class PartnerBankDistrictPlanningDetail extends \bc\models\BcactiveRecord {

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'partner_bank_district_planning_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['partner_bank_district_planning_id', 'month', 'week', 'onboarding', 'ac_opening', 'supply_equipment', 'operational', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['onboarding'], 'default', 'value' => 0],
            [['ac_opening'], 'default', 'value' => 0],
            [['supply_equipment'], 'default', 'value' => 0],
            [['operational'], 'default', 'value' => 0],
            [['year'], 'safe'],
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
            'partner_bank_district_planning_id' => 'Partner Bank District Planning ID',
            'week' => 'Week',
            'month' => 'Month',
            'year' => 'Year',
            'onboarding' => 'Onboarding',
            'ac_opening' => 'Ac Opening',
            'supply_equipment' => 'Supply Equipment',
            'operational' => 'Operational',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getDistrictplanning() {
        return $this->hasOne(PartnerBankDistrictPlanning::className(), ['id' => 'partner_bank_district_planning_id']);
    }

}
