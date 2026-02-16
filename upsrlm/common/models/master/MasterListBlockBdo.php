<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "master_list_block_bdo".
 *
 * @property int $id
 * @property string $district
 * @property string $role
 * @property string $block
 * @property string $mobile_no
 * @property int $status
 */
class MasterListBlockBdo extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'master_list_block_bdo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['district', 'role', 'block', 'mobile_no'], 'required'],
            [['status'], 'integer'],
            [['district'], 'string', 'max' => 255],
            [['role'], 'string', 'max' => 100],
            [['block'], 'string', 'max' => 150],
            [['mobile_no'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'district' => 'District',
            'role' => 'Role',
            'block' => 'Block',
            'mobile_no' => 'Mobile No',
            'status' => 'Status',
        ];
    }

    public function getMaster_block() {
        return $this->hasOne(MasterBlock::className(), ['block_name' => 'block']);
    }

}
