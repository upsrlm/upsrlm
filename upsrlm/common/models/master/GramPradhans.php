<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "gram_pradhans".
 *
 * @property int $id
 * @property string|null $S.No
 * @property string|null $zp_name
 * @property string|null $bp_name
 * @property int|null $gp_code
 * @property string|null $gp_name
 * @property string|null $pradhan_name
 * @property string|null $mobile_number
 * @property int|null $role
 * @property int $user_id
 * @property int $status
 */
class GramPradhans extends \common\models\dynamicdb\cbo\CboactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gram_pradhans';
    }

    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gp_code', 'role', 'user_id', 'status'], 'integer'],
            [['S.No'], 'string', 'max' => 5],
            [['zp_name'], 'string', 'max' => 19],
            [['bp_name'], 'string', 'max' => 21],
            [['gp_name'], 'string', 'max' => 38],
            [['pradhan_name'], 'string', 'max' => 135],
            [['mobile_number'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'S.No' => 'S No',
            'zp_name' => 'Zp Name',
            'bp_name' => 'Bp Name',
            'gp_code' => 'Gp Code',
            'gp_name' => 'Gp Name',
            'pradhan_name' => 'Pradhan Name',
            'mobile_number' => 'Mobile Num',
            'role' => 'Role',
            'user_id' => 'User ID',
            'status' => 'Status',
        ];
    }
    
    public function getDistrict() {
        return $this->hasOne(MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getBlock() {
        return $this->hasOne(MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getGp() {
        return $this->hasOne(MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gp_code']);
    }
}
