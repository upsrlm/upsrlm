<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use Yii;

/**
 * This is the model class for table "dbt_kisan_master".
 *
 * @property int $id
 * @property string|null $state_code
 * @property string|null $state_name
 * @property string|null $district_code
 * @property string|null $district_name
 * @property string|null $sub_district_code
 * @property string|null $sub_district_name
 * @property string|null $block_code
 * @property string|null $block_name
 * @property string|null $villige_code
 * @property string|null $village_name
 * @property string|null $farmer_id
 * @property string|null $farmer_name
 * @property string|null $gender
 * @property string|null $category
 * @property string|null $address
 * @property string|null $mobile_no
 * @property string|null $instalment
 */
class DbtKisanMaster extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbt_kisan_master';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['state_code', 'block_code', 'block_name', 'mobile_no', 'instalment'], 'string', 'max' => 10],
            [['state_name', 'district_code'], 'string', 'max' => 13],
            [['district_name', 'sub_district_name'], 'string', 'max' => 19],
            [['sub_district_code'], 'string', 'max' => 17],
            [['villige_code'], 'string', 'max' => 12],
            [['village_name'], 'string', 'max' => 31],
            [['farmer_id'], 'string', 'max' => 11],
            [['farmer_name'], 'string', 'max' => 41],
            [['gender'], 'string', 'max' => 6],
            [['category'], 'string', 'max' => 14],
            [['address'], 'string', 'max' => 100],
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
            'state_name' => 'State',
            'district_code' => 'District Code',
            'district_name' => 'Distric',
            'sub_district_code' => 'Sub District Code',
            'sub_district_name' => 'Sub District',
            'block_code' => 'Block Code',
            'block_name' => 'Block',
            'villige_code' => 'Villige Code',
            'village_name' => 'Village Name',
            'farmer_id' => 'Farmer ID',
            'farmer_name' => 'Farmer Name',
            'gender' => 'Gender',
            'category' => 'Category',
            'address' => 'Address',
            'mobile_no' => 'Mobile No',
            'instalment' => 'Instalment',
        ];
    }
}
