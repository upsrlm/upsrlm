<?php

namespace bc\modules\transaction\models\summary;

use Yii;

/**
 * This is the model class for table "master_block".
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
 * @property string $block_code
 * @property string $block_name
 * @property int|null $new_block_code
 * @property string|null $new_block_name
 * @property int $gram_panchayat_count
 * @property int $village_count
 * @property int $bc_selection_application_receive
 * @property int $bc_selection_sc_st_application_receive
 * @property int $bc_selection_obc_application_receive
 * @property int $bc_selection_general_application_receive
 * @property int $group_member
 * @property int|null $updated_by
 * @property int|null $updated_at
 * @property int $aspirational
 * @property int $wada_block
 * @property int $nretp
 * @property int $status
 */
class MasterBlock extends SummaryActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['state_code', 'division_code', 'district_code', 'sub_district_code', 'new_block_code', 'gram_panchayat_count', 'village_count', 'bc_selection_application_receive', 'bc_selection_sc_st_application_receive', 'bc_selection_obc_application_receive', 'bc_selection_general_application_receive', 'group_member', 'updated_by', 'updated_at', 'aspirational', 'wada_block', 'nretp', 'status'], 'integer'],
            [['division_code', 'division_name', 'district_code', 'district_name', 'sub_district_code', 'sub_district_name', 'block_code', 'block_name'], 'required'],
            [['state_name', 'new_block_name'], 'string', 'max' => 100],
            [['division_name', 'district_name'], 'string', 'max' => 150],
            [['sub_district_name'], 'string', 'max' => 20],
            [['block_code'], 'string', 'max' => 4],
            [['block_name'], 'string', 'max' => 23],
            [['block_code'], 'unique'],
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
            'sub_district_code' => 'Sub District Code',
            'sub_district_name' => 'Sub District Name',
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'new_block_code' => 'New Block Code',
            'new_block_name' => 'New Block Name',
            'gram_panchayat_count' => 'Gram Panchayat Count',
            'village_count' => 'Village Count',
            'bc_selection_application_receive' => 'Bc Selection Application Receive',
            'bc_selection_sc_st_application_receive' => 'Bc Selection Sc St Application Receive',
            'bc_selection_obc_application_receive' => 'Bc Selection Obc Application Receive',
            'bc_selection_general_application_receive' => 'Bc Selection General Application Receive',
            'group_member' => 'Group Member',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'aspirational' => 'Aspirational',
            'wada_block' => 'Wada Block',
            'nretp' => 'Nretp',
            'status' => 'Status',
        ];
    }
}
