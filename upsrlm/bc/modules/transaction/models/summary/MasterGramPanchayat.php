<?php

namespace bc\modules\transaction\models\summary;

use Yii;

/**
 * This is the model class for table "master_gram_panchayat".
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
 * @property int $village_count
 * @property int $gp_covert_urban
 * @property int $new
 * @property int|null $new_status
 * @property int $name_match_status
 * @property string|null $new_block_name
 * @property int|null $new_block_code
 * @property string|null $new_gram_panchayat_name
 * @property int|null $new_gram_panchayat_code
 * @property int|null $doubt_block
 * @property int $shg_count
 * @property int $aspirational
 * @property int $select_round1_wada
 * @property int $wada_gp
 * @property int|null $updated_by
 * @property int|null $updated_at
 * @property int $status
 */
class MasterGramPanchayat extends SummaryActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_gram_panchayat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['state_code', 'division_code', 'district_code', 'sub_district_code', 'block_code', 'gram_panchayat_code', 'village_count', 'gp_covert_urban', 'new', 'new_status', 'name_match_status', 'new_block_code', 'new_gram_panchayat_code', 'doubt_block', 'shg_count', 'aspirational', 'select_round1_wada', 'wada_gp', 'updated_by', 'updated_at', 'status'], 'integer'],
            [['division_code', 'division_name', 'district_code', 'district_name', 'sub_district_code', 'sub_district_name', 'block_code', 'block_name', 'gram_panchayat_code', 'gram_panchayat_name'], 'required'],
            [['state_name'], 'string', 'max' => 100],
            [['division_name', 'district_name', 'sub_district_name', 'block_name', 'new_block_name', 'new_gram_panchayat_name'], 'string', 'max' => 150],
            [['gram_panchayat_name'], 'string', 'max' => 132],
            [['gram_panchayat_code'], 'unique'],
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
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'village_count' => 'Village Count',
            'gp_covert_urban' => 'Gp Covert Urban',
            'new' => 'New',
            'new_status' => 'New Status',
            'name_match_status' => 'Name Match Status',
            'new_block_name' => 'New Block Name',
            'new_block_code' => 'New Block Code',
            'new_gram_panchayat_name' => 'New Gram Panchayat Name',
            'new_gram_panchayat_code' => 'New Gram Panchayat Code',
            'doubt_block' => 'Doubt Block',
            'shg_count' => 'Shg Count',
            'aspirational' => 'Aspirational',
            'select_round1_wada' => 'Select Round 1 Wada',
            'wada_gp' => 'Wada Gp',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
