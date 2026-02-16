<?php

namespace bc\modules\transaction\models\summary;

use Yii;

/**
 * This is the model class for table "master_village".
 *
 * @property int $id
 * @property int $state_code
 * @property string $state_name
 * @property int $division_code
 * @property string $division_name
 * @property int|null $district_code
 * @property string|null $district_name
 * @property int|null $sub_district_code
 * @property string|null $sub_district_name
 * @property int|null $village_code
 * @property string|null $village_name
 * @property int|null $gram_panchayat_code
 * @property string|null $gram_panchayat_name
 * @property int|null $block_code
 * @property string|null $block_name
 * @property int $urban
 * @property int $status
 */
class MasterVillage extends SummaryActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_village';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['state_code', 'division_code', 'district_code', 'sub_district_code', 'village_code', 'gram_panchayat_code', 'block_code', 'urban', 'status'], 'integer'],
            [['division_code', 'division_name', 'status'], 'required'],
            [['state_name'], 'string', 'max' => 100],
            [['division_name'], 'string', 'max' => 150],
            [['district_name', 'sub_district_name'], 'string', 'max' => 20],
            [['village_name'], 'string', 'max' => 123],
            [['gram_panchayat_name'], 'string', 'max' => 60],
            [['block_name'], 'string', 'max' => 30],
            [['village_code', 'gram_panchayat_code'], 'unique', 'targetAttribute' => ['village_code', 'gram_panchayat_code']],
            [['village_code', 'block_code', 'gram_panchayat_code'], 'unique', 'targetAttribute' => ['village_code', 'block_code', 'gram_panchayat_code']],
            [['village_code', 'status'], 'unique', 'targetAttribute' => ['village_code', 'status']],
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
            'village_code' => 'Village Code',
            'village_name' => 'Village Name',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'urban' => 'Urban',
            'status' => 'Status',
        ];
    }
}
