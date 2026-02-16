<?php

namespace bc\modules\transaction\models\dump;

use Yii;

/**
 * This is the model class for table "master_district".
 *
 * @property int $id
 * @property int $state_code
 * @property string $state_name
 * @property int $division_code
 * @property string $division_name
 * @property int $district_code
 * @property string $district_name
 * @property int $ulb_count
 * @property int $block_count
 * @property int $gram_panchayat_count
 * @property int $village_count
 * @property int $bc_selection_application_receive
 * @property int $bc_selection_sc_st_application_receive
 * @property int $bc_selection_obc_application_receive
 * @property int $bc_selection_general_application_receive
 * @property int $group_member
 * @property string|null $lat
 * @property string|null $lng
 * @property int $wada_district
 * @property int $saheli
 */
class MasterDistrict extends DumpActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_district';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['state_code', 'division_code', 'district_code', 'ulb_count', 'block_count', 'gram_panchayat_count', 'village_count', 'bc_selection_application_receive', 'bc_selection_sc_st_application_receive', 'bc_selection_obc_application_receive', 'bc_selection_general_application_receive', 'group_member', 'wada_district', 'saheli'], 'integer'],
            [['division_code', 'division_name', 'district_code', 'district_name', 'block_count', 'gram_panchayat_count', 'village_count'], 'required'],
            [['state_name'], 'string', 'max' => 100],
            [['division_name', 'district_name'], 'string', 'max' => 150],
            [['lat'], 'string', 'max' => 255],
            [['lng'], 'string', 'max' => 11],
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
            'ulb_count' => 'Ulb Count',
            'block_count' => 'Block Count',
            'gram_panchayat_count' => 'Gram Panchayat Count',
            'village_count' => 'Village Count',
            'bc_selection_application_receive' => 'Bc Selection Application Receive',
            'bc_selection_sc_st_application_receive' => 'Bc Selection Sc St Application Receive',
            'bc_selection_obc_application_receive' => 'Bc Selection Obc Application Receive',
            'bc_selection_general_application_receive' => 'Bc Selection General Application Receive',
            'group_member' => 'Group Member',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'wada_district' => 'Wada District',
            'saheli' => 'Saheli',
        ];
    }
}
