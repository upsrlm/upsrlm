<?php

namespace bc\models;

use Yii;

/**
 * This is the model class for table "partner_bank_district_planning".
 *
 * @property int $id
 * @property int|null $master_partner_bank_id
 * @property int $district_code
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class PartnerBankDistrictPlanning extends \bc\models\BcactiveRecord {

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
        return 'partner_bank_district_planning';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['master_partner_bank_id', 'district_code', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['district_code'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'master_partner_bank_id' => 'Master Partner Bank ID',
            'district_code' => 'District Code',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
    public function getCMonth() {
        return (int) date('m');
    }

    public function getCyear() {
        return date('Y');
    }
    public function getPartnerbank() {
        return $this->hasOne(master\MasterPartnerBank::className(), ['id' => 'master_partner_bank_id']);
    }

    public function getDistrict() {
        return $this->hasOne(master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getSbc() {
        return $this->hasMany(\bc\modules\selection\models\SrlmBcApplication::className(), ['district_code' => 'district_code'])->select(['id'])->where(['srlm_bc_application.gender' => 2, 'srlm_bc_application.status' => 2]);
    }

    public function getRbc() {
        return $this->hasMany(\bc\modules\training\models\RsetisBatchParticipants::className(), ['district_code' => 'district_code'])->select(['id'])->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1]);
    }

    public function getWeekly() {
        return $this->hasMany(PartnerBankDistrictPlanningDetail::className(), ['partner_bank_district_planning_id' => 'id'])->andWhere(['month' => $this->cmonth, 'year' => $this->cyear]);
    }

    public function getOnboarding() {
        return PartnerBankDistrictPlanningDetail::find()->where(['partner_bank_district_planning_id' => $this->id])->andWhere(['month' => $this->cmonth, 'year' => $this->cyear])->sum('onboarding');
    }

    public function getAcopening() {
        return PartnerBankDistrictPlanningDetail::find()->where(['partner_bank_district_planning_id' => $this->id])->andWhere(['month' => $this->cmonth, 'year' => $this->cyear])->sum('ac_opening');
    }

    public function getOperational() {
        return PartnerBankDistrictPlanningDetail::find()->where(['partner_bank_district_planning_id' => $this->id])->andWhere(['month' => $this->cmonth, 'year' => $this->cyear])->sum('operational');
    }

    public function getSupplyequipment() {
        return PartnerBankDistrictPlanningDetail::find()->where(['partner_bank_district_planning_id' => $this->id])->andWhere(['month' => $this->cmonth, 'year' => $this->cyear])->sum('supply_equipment');
    }
    
    public static function getTotal($provider, $columnName) {
        $total = 0;
        if ($columnName == 'preselected') {
           foreach ($provider as $item) {
                $total += $item->getSbc()->count();
            } 
        } elseif ($columnName == 'certified') {
           foreach ($provider as $item) {
//                $total += $item->getRbc()->andWhere(['rsetis_batch_participants.training_status' => 3])->andWhere(['srlm_bc_application.blocked' => 0])->count();
                $total += $item->getRbc()->andWhere(['rsetis_batch_participants.training_status' => 3])->count();
            } 
        } elseif ($columnName == 'pvr') {
            foreach ($provider as $item) {
                $total += $item->getRbc()->andWhere(['srlm_bc_application.pvr_status' => 1])->count();
            }
        } elseif ($columnName == 'supportfund') {
            foreach ($provider as $item) {
                $total += $item->getRbc()->andWhere(['srlm_bc_application.bc_shg_funds_status' => 1])->count();
            }
        } elseif ($columnName == 'onboard') {
            foreach ($provider as $item) {
                $total += $item->getRbc()->andWhere(['srlm_bc_application.onboarding' => 1])->count();
            }
        } elseif ($columnName == 'pan_ava') {
            foreach ($provider as $item) {
                $total += $item->getRbc()->andWhere(['srlm_bc_application.pan_card_status' => 1])->count();
            }
        } elseif ($columnName == 'handheld_machine') {
            foreach ($provider as $item) {
                $total += $item->getRbc()->andWhere(['srlm_bc_application.handheld_machine_status' => 1])->count();
            }
        } else {
            foreach ($provider as $item) {
                $total += $item[$columnName];
            }
        }
        return $total;
    }

}
