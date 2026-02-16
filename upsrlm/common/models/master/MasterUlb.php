<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "master_ulb".
 *
 * @property int $id
 * @property int $division_code
 * @property string $division_name
 * @property int $district_code
 * @property string $district_name
 * @property int $sub_district_code
 * @property string|null $sub_district_name
 * @property int $ulb_code
 * @property string $ulb_name
 * @property int|null $ulb_version
 * @property int|null $ulb_type_code
 * @property string|null $ulb_type_name
 */
class MasterUlb extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_ulb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['division_code', 'division_name', 'district_code', 'district_name', 'ulb_code', 'ulb_name'], 'required'],
            [['division_code', 'district_code', 'sub_district_code', 'ulb_code', 'ulb_version', 'ulb_type_code'], 'integer'],
            [['division_name'], 'string', 'max' => 150],
            [['district_name', 'sub_district_name'], 'string', 'max' => 20],
            [['ulb_name'], 'string', 'max' => 31],
            [['ulb_type_name'], 'string', 'max' => 22],
            [['ulb_code'], 'unique'],
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
            'ulb_version' => 'Ulb Version',
            'ulb_type_code' => 'Ulb Type Code',
            'ulb_type_name' => 'Ulb Type Name',
        ];
    }
   
}
