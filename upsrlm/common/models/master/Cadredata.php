<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "cadredata".
 *
 * @property int $id
 * @property string|null $S.No
 * @property string|null $dist_name
 * @property string|null $block_name
 * @property string|null $gram_code
 * @property string|null $gram_name
 * @property string|null $vlg_code
 * @property string|null $vlg_name
 * @property string|null $shg_code
 * @property int|null $lgd_gp_code
 * @property string|null $cadre_name
 * @property string|null $cadre_designation
 * @property string|null $mobile_no
 * @property int|null $cbo_shg_id
 * @property int|null $user_id
 * @property int|null $role
 * @property int $is_assign_shg
 * @property int $status
 */
class Cadredata extends \common\models\dynamicdb\cbo\CboactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'cadredata';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['lgd_gp_code', 'cbo_shg_id', 'user_id', 'role', 'is_assign_shg', 'status'], 'integer'],
            [['S.No'], 'string', 'max' => 5],
            [['dist_name'], 'string', 'max' => 19],
            [['block_name'], 'string', 'max' => 21],
            [['gram_code', 'mobile_no'], 'string', 'max' => 10],
            [['gram_name'], 'string', 'max' => 38],
            [['vlg_code'], 'string', 'max' => 13],
            [['vlg_name'], 'string', 'max' => 49],
            [['shg_code'], 'string', 'max' => 8],
            [['cadre_name'], 'string', 'max' => 41],
            [['cadre_designation'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'S.No' => 'S No',
            'dist_name' => 'Dist Name',
            'block_name' => 'Block Name',
            'gram_code' => 'Gram Code',
            'gram_name' => 'Gram Name',
            'vlg_code' => 'Vlg Code',
            'vlg_name' => 'Vlg Name',
            'shg_code' => 'Shg Code',
            'lgd_gp_code' => 'Lgd Gp Code',
            'cadre_name' => 'Cadre Name',
            'cadre_designation' => 'Cadre Designation',
            'mobile_no' => 'Mobile No',
            'cbo_shg_id' => 'Cbo Shg ID',
            'user_id' => 'User ID',
            'role' => 'Role',
            'is_assign_shg' => 'Is Assign Shg',
            'status' => 'Status',
        ];
    }

}
