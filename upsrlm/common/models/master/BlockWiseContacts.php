<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "block_wise_contacts".
 *
 * @property int $id
 * @property string|null $sr_no
 * @property string|null $call_provider_name
 * @property string|null $division_district
 * @property string|null $designation
 * @property string|null $district_block
 * @property int|null $block_code
 * @property string|null $mobile_number
 * @property string|null $status
 * @property int|null $user_id
 * @property int|null $role
 * @property int|null $user_block_code
 */
class BlockWiseContacts extends \common\models\dynamicdb\cbo\CboactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'block_wise_contacts';
    }

    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['block_code', 'user_id', 'role', 'user_block_code'], 'integer'],
            [['sr_no'], 'string', 'max' => 5],
            [['call_provider_name'], 'string', 'max' => 18],
            [['division_district'], 'string', 'max' => 17],
            [['designation'], 'string', 'max' => 25],
            [['district_block'], 'string', 'max' => 19],
            [['mobile_number'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 21064],
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
            'call_provider_name' => 'Call Provider Name',
            'division_district' => 'Division District',
            'designation' => 'Designation',
            'district_block' => 'District Block',
            'block_code' => 'Block Code',
            'mobile_number' => 'Mobile Number',
            'status' => 'Status',
            'user_id' => 'User ID',
            'role' => 'Role',
            'user_block_code' => 'User Block Code',
        ];
    }
}
