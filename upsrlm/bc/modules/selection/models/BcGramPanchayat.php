<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "bc_gram_panchayat".
 *
 * @property int $id
 * @property int $state_code
 * @property string $state_name
 * @property int $division_code
 * @property string $division_name
 * @property int $district_code
 * @property string $district_name
 * @property int $sub_district_code
 * @property string $sub_district_name
 * @property int $block_code
 * @property string $block_name
 * @property int $gram_panchayat_code
 * @property string $gram_panchayat_name
 * @property int $gp_available_application
 * @property int|null $gp_partner_bank_id
 * @property int|null $gp_previous_master_bank_id
 * @property int $aspirational
 * @property int $selected_bc_status
 * @property int $selected_bc_round
 * @property string|null $selected_bc_date
 * @property int $select_rsethi
 * @property string|null $select_rsethi_date
 * @property int $pendency_select_rsethi_days
 * @property int $certified_status
 * @property string|null $certified_date
 * @property int $pendency_certified_days
 * @property int $iibf_photo_status
 * @property string|null $iibf_photo_date
 * @property int $pendency_iibf_photo_days
 * @property int $assign_shg
 * @property string|null $assign_shg_date
 * @property int $pendency_assign_shg_days
 * @property int $bank_bc_status
 * @property int $bank_shg_status
 * @property string|null $bank_bc_date
 * @property string|null $bank_shg_date
 * @property int $pendency_bank_bc_days
 * @property int $pendency_bank_shg_days
 * @property int $bank_bc_shg_status
 * @property string|null $bank_bc_shg_date
 * @property int $pendency_bank_bc_shg_days
 * @property int $pvr
 * @property string|null $pvr_date
 * @property int $pendency_pvr_days
 * @property int $shg_pfms_mapping
 * @property string|null $shg_pfms_mapping_date
 * @property int $pendency_shg_pfms_mapping_days
 * @property int $bc_shg_support_fund
 * @property string|null $bc_shg_support_fund_date
 * @property int $pendency_bc_shg_support_fund_days
 * @property int $handheld_machine
 * @property string|null $handheld_machine_date
 * @property int $pendency_handheld_machine_days
 * @property int $onboarding
 * @property string|null $onboarding_date
 * @property int|null $pendency_onboarding_days
 * @property int $operational
 * @property string|null $operational_date
 * @property int $pendency_operational_days
 * @property int $bc_settlement_ac_194n
 * @property string|null $bc_settlement_ac_194n_date
 * @property int $pendency_bc_settlement_ac_194n_days
 * @property int|null $c_bc_id
 * @property int|null $c_partner_bank_id
 * @property string|null $c_bc_name
 * @property int $bc_blocked
 * @property int $bc_status
 * @property int $gp_status
 * @property int $c_no_selection
 * @property int $re_calculate
 * @property string|null $updated_datetime
 * @property int $status
 */
class BcGramPanchayat extends BcactiveRecord {

    public $master_partner_bank_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'bc_gram_panchayat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['state_code', 'division_code', 'district_code', 'sub_district_code', 'block_code', 'gram_panchayat_code', 'gp_available_application', 'gp_partner_bank_id', 'gp_previous_master_bank_id', 'aspirational', 'selected_bc_status', 'selected_bc_round', 'select_rsethi', 'pendency_select_rsethi_days', 'certified_status', 'iibf_photo_status', 'pendency_iibf_photo_days', 'pendency_certified_days', 'assign_shg', 'pendency_assign_shg_days', 'bank_bc_status', 'bank_shg_status', 'pendency_bank_bc_days', 'pendency_bank_shg_days', 'bank_bc_shg_status', 'pendency_bank_bc_shg_days', 'pvr', 'pendency_pvr_days', 'shg_pfms_mapping', 'pendency_shg_pfms_mapping_days', 'bc_shg_support_fund', 'pendency_bc_shg_support_fund_days', 'handheld_machine', 'pendency_handheld_machine_days', 'onboarding', 'pendency_onboarding_days', 'operational', 'pendency_operational_days', 'bc_settlement_ac_194n', 'pendency_bc_settlement_ac_194n_days', 'c_bc_id', 'c_partner_bank_id', 'bc_blocked', 'bc_status', 'gp_status', 'c_no_selection', 're_calculate', 'status'], 'integer'],
            [['division_code', 'division_name', 'district_code', 'district_name', 'sub_district_code', 'sub_district_name', 'block_code', 'block_name', 'gram_panchayat_code', 'gram_panchayat_name'], 'required'],
            [['selected_bc_date', 'select_rsethi_date', 'certified_date', 'iibf_photo_date', 'assign_shg_date', 'bank_bc_date', 'bank_shg_date', 'bank_bc_shg_date', 'pvr_date', 'shg_pfms_mapping_date', 'bc_shg_support_fund_date', 'handheld_machine_date', 'onboarding_date', 'operational_date', 'bc_settlement_ac_194n_date'], 'safe'],
            [['state_name'], 'string', 'max' => 100],
            [['division_name', 'district_name', 'sub_district_name', 'block_name'], 'string', 'max' => 150],
            [['gram_panchayat_name'], 'string', 'max' => 132],
            [['c_bc_name'], 'string', 'max' => 255],
            [['gram_panchayat_code'], 'unique'],
            [['updated_datetime'], 'safe'],
            [['master_partner_bank_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'state_code' => 'State Code',
            'state_name' => 'State Name',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'sub_district_code' => 'Sub District Code',
            'sub_district_name' => 'Sub District Name',
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'gp_available_application' => 'Gp Available Application',
            'gp_partner_bank_id' => 'Gp Partner Bank ID',
            'gp_previous_master_bank_id' => 'Gp Previous Master Bank ID',
            'aspirational' => 'Aspirational',
            'selected_bc_status' => 'Selected Bc Status',
            'selected_bc_round' => 'Selected Bc Round',
            'selected_bc_date' => 'Selected Bc Date',
            'certified_status' => 'Certified Status',
            'certified_date' => 'Certified Date',
            'pendency_certified_days' => 'Pendency Certified Days',
            'assign_shg' => 'Assign Shg',
            'assign_shg_date' => 'Assign Shg Date',
            'pendency_assign_shg_days' => 'Pendency Assign Shg Days',
            'bank_bc_status' => 'Bank Bc Status',
            'bank_shg_status' => 'Bank Shg Status',
            'bank_bc_date' => 'Bank Bc Date',
            'bank_shg_date' => 'Bank Shg Date',
            'pendency_bank_bc_days' => 'Pendency Bank Bc Days',
            'pendency_bank_shg_days' => 'Pendency Bank Shg Days',
            'bank_bc_shg_status' => 'Bank Bc Shg Status',
            'bank_bc_shg_date' => 'Bank Bc Shg Date',
            'pendency_bank_bc_shg_days' => 'Pendency Bank Bc Shg Days',
            'pvr' => 'Pvr',
            'pvr_date' => 'Pvr Date',
            'pendency_pvr_days' => 'Pendency Pvr Days',
            'shg_pfms_mapping' => 'Shg Pfms Mapping',
            'shg_pfms_mapping_date' => 'Shg Pfms Mapping Date',
            'pendency_shg_pfms_mapping_days' => 'Pendency Shg Pfms Mapping Days',
            'bc_shg_support_fund' => 'Bc Shg Support Fund',
            'bc_shg_support_fund_date' => 'Bc Shg Support Fund Date',
            'pendency_bc_shg_support_fund_days' => 'Pendency Bc Shg Support Fund Days',
            'handheld_machine' => 'Handheld Machine',
            'handheld_machine_date' => 'Handheld Machine Date',
            'pendency_handheld_machine_days' => 'Pendency Handheld Machine Days',
            'onboarding' => 'Onboarding',
            'onboarding_date' => 'Onboarding Date',
            'pendency_onboarding_days' => 'Pendency Onboarding Days',
            'operational' => 'Operational',
            'operational_date' => 'Operational Date',
            'pendency_operational_days' => 'Pendency Operational Days',
            'bc_settlement_ac_194n' => 'Bc Settlement Ac 194n',
            'bc_settlement_ac_194n_date' => 'Bc Settlement Ac 194n Date',
            'pendency_bc_settlement_ac_194n_days' => 'Pendency Bc Settlement Ac 194n Days',
            'c_bc_id' => 'C Bc ID',
            'c_partner_bank_id' => 'C Partner Bank ID',
            'c_bc_name' => 'C Bc Name',
            'bc_blocked' => 'Bc Blocked',
            'bc_status' => 'Bc Status',
            'gp_status' => 'Gp Status',
            'c_no_selection' => 'C No Selection',
            're_calculate' => 'Re Calculate',
            'updated_datetime' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {
        $this->updated_datetime = new \yii\db\Expression('NOW()');
        return parent::beforeSave($insert);
    }
    public function afterSave($insert, $changedAttributes) {
        try {
            
            $models = BcGramPanchayat::findOne($this->id);
            
            $model = new BcGramPanchayatHistory();
            $model->setAttributes($models->attributes);
            
            if ($model->save()) {
                
            } else {
                
            }
        } catch (\Exception $ex) {
            
        }
        return true;
    }
    public static function getTotal($search, $columnName, $column) {
        $total = 0;
        if ($columnName == 'bc_shortlist') {
            $query = BcGramPanchayat::find();
            if (isset($search->master_partner_bank_id)) {
                $query->andWhere(['gp_partner_bank_id' => $search->master_partner_bank_id]);
            }

            if (isset($search->district_code)) {
                $query->andWhere(['district_code' => $search->district_code]);
            }
            if (isset($search->block_code)) {
                $query->andWhere(['block_code' => $search->block_code]);
            }
            if (isset($search->aspirational)) {
                $query->andWhere(['aspirational' => $search->aspirational]);
            }
            $total = $query->select($columnName)->sum($columnName);
        }
        if ($columnName == 'gp') {
            $query = BcGramPanchayat::find();
            if (isset($search->master_partner_bank_id)) {
                $query->andWhere(['gp_partner_bank_id' => $search->master_partner_bank_id]);
            }

            if (isset($search->district_code)) {
                $query->andWhere(['district_code' => $search->district_code]);
            }
            if (isset($search->block_code)) {
                $query->andWhere(['block_code' => $search->block_code]);
            }
            if (isset($search->aspirational)) {
                $query->andWhere(['aspirational' => $search->aspirational]);
            }
            $total = $query->count();
        }
        if ($columnName == 'standbc') {
            $query = BcGramPanchayat::find();
            $query->andWhere(['bc_status' => 10]);
            if (isset($search->master_partner_bank_id)) {
                $query->andWhere(['gp_partner_bank_id' => $search->master_partner_bank_id]);
            }

            if (isset($search->district_code)) {
                $query->andWhere(['district_code' => $search->district_code]);
            }
            if (isset($search->block_code)) {
                $query->andWhere(['block_code' => $search->block_code]);
            }
            if (isset($search->aspirational)) {
                $query->andWhere(['aspirational' => $search->aspirational]);
            }
            $total = $query->count();
            
        }
        if ($columnName == 'vacantgp') {
            $query = BcGramPanchayat::find();
            $query->andWhere(['bc_status' => 11]);
            if (isset($search->master_partner_bank_id)) {
                $query->andWhere(['gp_partner_bank_id' => $search->master_partner_bank_id]);
            }

            if (isset($search->district_code)) {
                $query->andWhere(['district_code' => $search->district_code]);
            }
            if (isset($search->block_code)) {
                $query->andWhere(['block_code' => $search->block_code]);
            }
            if (isset($search->aspirational)) {
                $query->andWhere(['aspirational' => $search->aspirational]);
            }
            $total = $query->count();
            
        }
        if ($columnName == 'certified_bc') {
            $query = BcGramPanchayat::find();
            $query->andWhere(['certified_status' => 1, 'bc_blocked' => 0]);
            if (isset($search->master_partner_bank_id)) {
                $query->andWhere(['gp_partner_bank_id' => $search->master_partner_bank_id]);
            }

            if (isset($search->district_code)) {
                $query->andWhere(['district_code' => $search->district_code]);
            }
            if (isset($search->block_code)) {
                $query->andWhere(['block_code' => $search->block_code]);
            }
            if (isset($search->aspirational)) {
                $query->andWhere(['aspirational' => $search->aspirational]);
            }
            $total = $query->count();
            
        }
        if ($columnName == 'certified_bc_pen') {
            $query = BcGramPanchayat::find();
            $query->andWhere(['certified_status' => 0, 'bc_blocked' => 0, 'bc_status' => 0]);
            if (isset($search->master_partner_bank_id)) {
                $query->andWhere(['gp_partner_bank_id' => $search->master_partner_bank_id]);
            }

            if (isset($search->district_code)) {
                $query->andWhere(['district_code' => $search->district_code]);
            }
            if (isset($search->block_code)) {
                $query->andWhere(['block_code' => $search->block_code]);
            }
            if (isset($search->aspirational)) {
                $query->andWhere(['aspirational' => $search->aspirational]);
            }
            $total = $query->count();
            
        }
        if ($columnName == 'pvr') {
            $query = BcGramPanchayat::find();
            $query->andWhere(['pvr' => 1, 'bc_blocked' => 0, 'certified_status' => 1]);
            if (isset($search->master_partner_bank_id)) {
                $query->andWhere(['c_partner_bank_id' => $search->master_partner_bank_id]);
            }

            if (isset($search->district_code)) {
                $query->andWhere(['district_code' => $search->district_code]);
            }
            if (isset($search->block_code)) {
                $query->andWhere(['block_code' => $search->block_code]);
            }
            if (isset($search->aspirational)) {
                $query->andWhere(['aspirational' => $search->aspirational]);
            }
            $total = $query->count();
            
        }
        if ($columnName == 'pvr_pen') {
            $query = BcGramPanchayat::find();
            $query->andWhere(['pvr' => 0, 'bc_blocked' => 0, 'certified_status' => 1]);
            if (isset($search->master_partner_bank_id)) {
                $query->andWhere(['c_partner_bank_id' => $search->master_partner_bank_id]);
            }

            if (isset($search->district_code)) {
                $query->andWhere(['district_code' => $search->district_code]);
            }
            if (isset($search->block_code)) {
                $query->andWhere(['block_code' => $search->block_code]);
            }
            if (isset($search->aspirational)) {
                $query->andWhere(['aspirational' => $search->aspirational]);
            }
            $total = $query->count();
            
        }
        if ($columnName == 'shg') {
            $query = BcGramPanchayat::find();
            $query->andWhere(['assign_shg' => 1, 'bc_blocked' => 0, 'certified_status' => 1]);
            if (isset($search->master_partner_bank_id)) {
                $query->andWhere(['c_partner_bank_id' => $search->master_partner_bank_id]);
            }

            if (isset($search->district_code)) {
                $query->andWhere(['district_code' => $search->district_code]);
            }
            if (isset($search->block_code)) {
                $query->andWhere(['block_code' => $search->block_code]);
            }
            if (isset($search->aspirational)) {
                $query->andWhere(['aspirational' => $search->aspirational]);
            }
            $total = $query->count();
            
        }
        if ($columnName == 'shg_pen') {
            $query = BcGramPanchayat::find();
            $query->andWhere(['assign_shg' => 0, 'bc_blocked' => 0, 'certified_status' => 1]);
            if (isset($search->master_partner_bank_id)) {
                $query->andWhere(['c_partner_bank_id' => $search->master_partner_bank_id]);
            }

            if (isset($search->district_code)) {
                $query->andWhere(['district_code' => $search->district_code]);
            }
            if (isset($search->block_code)) {
                $query->andWhere(['block_code' => $search->block_code]);
            }
            if (isset($search->aspirational)) {
                $query->andWhere(['aspirational' => $search->aspirational]);
            }
            $total = $query->count();
            
        }
        if ($columnName == 'bc_shg_bank') {
            $query = BcGramPanchayat::find();
            $query->andWhere(['bank_bc_shg_status' => 1, 'bc_blocked' => 0, 'certified_status' => 1]);
            if (isset($search->master_partner_bank_id)) {
                $query->andWhere(['c_partner_bank_id' => $search->master_partner_bank_id]);
            }

            if (isset($search->district_code)) {
                $query->andWhere(['district_code' => $search->district_code]);
            }
            if (isset($search->block_code)) {
                $query->andWhere(['block_code' => $search->block_code]);
            }
            if (isset($search->aspirational)) {
                $query->andWhere(['aspirational' => $search->aspirational]);
            }
            $total = $query->count();
            
        }
        if ($columnName == 'bc_shg_bank_pen') {
            $query = BcGramPanchayat::find();
            $query->andWhere(['bank_bc_shg_status' => 0, 'bc_blocked' => 0, 'certified_status' => 1]);
            if (isset($search->master_partner_bank_id)) {
                $query->andWhere(['c_partner_bank_id' => $search->master_partner_bank_id]);
            }

            if (isset($search->district_code)) {
                $query->andWhere(['district_code' => $search->district_code]);
            }
            if (isset($search->block_code)) {
                $query->andWhere(['block_code' => $search->block_code]);
            }
            if (isset($search->aspirational)) {
                $query->andWhere(['aspirational' => $search->aspirational]);
            }
            $total = $query->count();
            
        }
        return $total;
    }
}
