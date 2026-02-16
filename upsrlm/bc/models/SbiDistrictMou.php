<?php

namespace bc\models;

use Yii;

/**
 * This is the model class for table "sbi_district_mou".
 *
 * @property int $id
 * @property int $state_code
 * @property string $state_name
 * @property int $division_code
 * @property string $division_name
 * @property int $district_code
 * @property string $district_name
 * @property int $block_count
 * @property int $before_2023_ulb_election_gp_count
 * @property int $current_gp_count
 * @property int $bc_sakhi_onboard
 * @property int $bc_sakhi_onboard_current
 * @property int $bc_sakhi_onboard_remain
 * @property int $sbi_distict_all
 * @property int $work_phase
 */
class SbiDistrictMou extends BcactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sbi_district_mou';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['state_code', 'division_code', 'district_code', 'block_count', 'before_2023_ulb_election_gp_count', 'current_gp_count', 'bc_sakhi_onboard', 'bc_sakhi_onboard_current', 'bc_sakhi_onboard_remain', 'sbi_distict_all', 'work_phase'], 'integer'],
            [['division_code', 'division_name', 'district_code', 'district_name', 'block_count', 'before_2023_ulb_election_gp_count', 'current_gp_count'], 'required'],
            [['state_name'], 'string', 'max' => 100],
            [['division_name', 'district_name'], 'string', 'max' => 150],
            [['district_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'state_code' => 'State Code',
            'state_name' => 'State Name',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'block_count' => 'Block Count',
            'before_2023_ulb_election_gp_count' => 'Before 2023 Ulb Election Gp Count',
            'current_gp_count' => 'Current Gp Count',
            'bc_sakhi_onboard' => 'Bc Sakhi Onboard',
            'bc_sakhi_onboard_current' => 'Bc Sakhi Onboard Current',
            'bc_sakhi_onboard_remain' => 'Bc Sakhi Onboard Remain',
            'sbi_distict_all' => 'Sbi Distict All',
            'work_phase' => 'Work Phase',
        ];
    }
}
