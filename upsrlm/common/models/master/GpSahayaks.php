<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "gp_sahayaks".
 *
 * @property int $id
 * @property string|null $district
 * @property string|null $block
 * @property string|null $panchayat
 * @property int|null $gp_code
 * @property string|null $employee_name
 * @property string|null $mobile_number
 * @property int|null $role
 * @property int $user_id
 * @property int $status
 */
class GpSahayaks extends \common\models\dynamicdb\cbo\CboactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gp_sahayaks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gp_code', 'role', 'user_id', 'status'], 'integer'],
            [['district'], 'string', 'max' => 28],
            [['block'], 'string', 'max' => 21],
            [['panchayat'], 'string', 'max' => 38],
            [['employee_name'], 'string', 'max' => 100],
            [['mobile_number'], 'string', 'max' => 13],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'district' => 'District',
            'block' => 'Block',
            'panchayat' => 'Panchayat',
            'gp_code' => 'Gp Code',
            'employee_name' => 'Employee Name',
            'mobile_number' => 'Mobile Number',
            'role' => 'Role',
            'user_id' => 'User ID',
            'status' => 'Status',
        ];
    }
}
