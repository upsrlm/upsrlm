<?php

namespace cbo\models;

use Yii;

/**
 * This is the model class for table "cbo_block".
 *
 * @property int $id
 * @property int $state_code
 * @property string $state_name
 * @property int $division_code
 * @property string $division_name
 * @property int $district_code
 * @property string $district_name
 * @property int $sub_district_code
 * @property string $sub_district_name
 * @property string $block_code
 * @property string $block_name
 * @property int $total_shgs
 * @property int $total_members
 * @property int $total_vo
 * @property int $total_clf
 * @property int $status
 */
class CboBlock extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'cbo_block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['state_code', 'division_code', 'district_code', 'sub_district_code', 'total_shgs', 'total_members', 'total_vo', 'total_clf', 'status'], 'integer'],
            [['division_code', 'division_name', 'district_code', 'district_name', 'sub_district_code', 'sub_district_name', 'block_code', 'block_name'], 'required'],
            [['state_name'], 'string', 'max' => 100],
            [['division_name', 'district_name'], 'string', 'max' => 150],
            [['sub_district_name'], 'string', 'max' => 20],
            [['block_code'], 'string', 'max' => 4],
            [['block_name'], 'string', 'max' => 23],
            [['block_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'state_code' => 'State Code',
            'state_name' => 'State Name',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'sub_district_code' => 'Sub District Code',
            'sub_district_name' => 'Sub District Name',
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'total_shgs' => 'Self-help groups (SHG) formed (Est.)',
            'total_members' => 'No. of SHG members (Est.)',
            'total_vo' => 'No. of Village Organizations (VO)',
            'total_clf' => 'No. of Cluster level federations (CLF)',
            'status' => 'Status',
        ];
    }

    public function getShgs() {
        return $this->hasMany(Shg::className(), ['block_code' => 'block_code'])->select(['id','no_of_members'])->where(['dummy_column' => 0]);
    }

    public function getVos() {
        return $this->hasMany(CboVo::className(), ['block_code' => 'block_code'])->select(['id'])->where(['dummy_column' => 0]);
    }

    public function getClfs() {
        return $this->hasMany(CboClf::className(), ['block_code' => 'block_code'])->select(['id'])->where(['dummy_column' => 0]);
    }

}
