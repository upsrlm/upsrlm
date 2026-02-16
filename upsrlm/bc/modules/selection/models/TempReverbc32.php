<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "temp_reverbc32".
 *
 * @property int $id
 * @property int|null $sr_no
 * @property int|null $bcid
 * @property int $bc_exist
 * @property string|null $name
 * @property string|null $district_name
 * @property string|null $block_name
 * @property string|null $gram_panchayat_name
 * @property string|null $guardian_name
 * @property string|null $mobile_no
 * @property string|null $mobile_number
 * @property int $training_status
 * @property int|null $gram_panchayat_code
 * @property int|null $block_code
 * @property int|null $district_code
 * @property int|null $call_center_status
 * @property int|null $bank_status
 * @property int|null $bc_status
 * @property string|null $col_4
 * @property string|null $col_5
 * @property string|null $col_6
 * @property string|null $col_7
 * @property string|null $col_8
 * @property string|null $col_9
 * @property string|null $col_10
 * @property string|null $col_11
 * @property string|null $col_12
 * @property string|null $col_13
 */
class TempReverbc32 extends BcactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'temp_reverbc32';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sr_no', 'bcid', 'bc_exist', 'training_status', 'gram_panchayat_code', 'block_code', 'district_code', 'call_center_status', 'bank_status', 'bc_status'], 'integer'],
            [['name'], 'string', 'max' => 35],
            [['district_name', 'block_name', 'gram_panchayat_name'], 'string', 'max' => 200],
            [['guardian_name'], 'string', 'max' => 20],
            [['mobile_no', 'mobile_number'], 'string', 'max' => 15],
            [['col_4'], 'string', 'max' => 22],
            [['col_5'], 'string', 'max' => 3],
            [['col_6'], 'string', 'max' => 83],
            [['col_7'], 'string', 'max' => 161],
            [['col_8'], 'string', 'max' => 34],
            [['col_9'], 'string', 'max' => 37],
            [['col_10'], 'string', 'max' => 60],
            [['col_11'], 'string', 'max' => 73],
            [['col_12'], 'string', 'max' => 14],
            [['col_13'], 'string', 'max' => 39],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sr_no' => 'Sr No',
            'bcid' => 'Bcid',
            'bc_exist' => 'Bc Exist',
            'name' => 'Name',
            'district_name' => 'District Name',
            'block_name' => 'Block Name',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'guardian_name' => 'Guardian Name',
            'mobile_no' => 'Mobile No',
            'mobile_number' => 'Mobile Number',
            'training_status' => 'Training Status',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'block_code' => 'Block Code',
            'district_code' => 'District Code',
            'call_center_status' => 'Call Center Status',
            'bank_status' => 'Bank Status',
            'bc_status' => 'Bc Status',
            'col_4' => 'Col 4',
            'col_5' => 'Col 5',
            'col_6' => 'Col 6',
            'col_7' => 'Col 7',
            'col_8' => 'Col 8',
            'col_9' => 'Col 9',
            'col_10' => 'Col 10',
            'col_11' => 'Col 11',
            'col_12' => 'Col 12',
            'col_13' => 'Col 13',
        ];
    }
}
