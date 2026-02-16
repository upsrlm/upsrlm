<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "master_sub_district".
 *
 * @property int $id
 * @property int $division_code
 * @property string $division_name
 * @property int $district_code
 * @property string $district_name
 * @property int $sub_district_code
 * @property string $sub_district_name
 * @property int $block_count
 * @property int $gram_panchayat_count
 * @property int $village_count
 */
class MasterSubDistrict extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'master_sub_district';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['division_code', 'division_name', 'district_code', 'district_name', 'sub_district_code', 'sub_district_name', 'block_count', 'gram_panchayat_count', 'village_count'], 'required'],
            [['division_code', 'district_code', 'sub_district_code', 'block_count', 'gram_panchayat_count', 'village_count'], 'integer'],
            [['division_name', 'district_name'], 'string', 'max' => 150],
            [['sub_district_name'], 'string', 'max' => 20],
            [['sub_district_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'sub_district_code' => 'Sub District Code',
            'sub_district_name' => 'Sub District Name',
            'block_count' => 'Block Count',
            'gram_panchayat_count' => 'Gram Panchayat Count',
            'village_count' => 'Village Count',
        ];
    }

}
