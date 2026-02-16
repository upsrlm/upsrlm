<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "master_ward".
 *
 * @property int $id
 * @property int $division_code
 * @property string $division_name
 * @property int $district_code
 * @property string $district_name
 * @property int $sub_district_code
 * @property string $sub_district_name
 * @property int $ulb_code
 * @property string $ulb_name
 * @property int $ward_code
 * @property int $ward_number
 * @property string $ward_name
 */
class MasterWard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_ward';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['division_code', 'division_name', 'district_code', 'district_name', 'sub_district_code', 'sub_district_name', 'ulb_code', 'ulb_name', 'ward_code', 'ward_number', 'ward_name'], 'required'],
            [['division_code', 'district_code', 'sub_district_code', 'ulb_code', 'ward_code', 'ward_number'], 'integer'],
            [['division_name'], 'string', 'max' => 150],
            [['district_name', 'sub_district_name'], 'string', 'max' => 20],
            [['ulb_name'], 'string', 'max' => 31],
            [['ward_name'], 'string', 'max' => 107],
            [['ward_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'sub_district_code' => 'Sub District Code',
            'sub_district_name' => 'Sub District Name',
            'ulb_code' => 'Ulb Code',
            'ulb_name' => 'Ulb Name',
            'ward_code' => 'Ward Code',
            'ward_number' => 'Ward Number',
            'ward_name' => 'Ward Name',
        ];
    }
}
