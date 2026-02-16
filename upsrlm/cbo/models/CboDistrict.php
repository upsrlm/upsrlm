<?php

namespace cbo\models;

use Yii;

/**
 * This is the model class for table "cbo_district".
 *
 * @property int $id
 * @property int $state_code
 * @property string $state_name
 * @property int $division_code
 * @property string $division_name
 * @property int $district_code
 * @property string $district_name
 * @property int $total_shgs
 * @property int $total_members
 * @property int $total_vo
 * @property int $total_clf
 * @property int $status
 */
class CboDistrict extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'cbo_district';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['state_code', 'division_code', 'district_code', 'total_shgs', 'total_members', 'total_vo', 'total_clf', 'status'], 'integer'],
            [['division_code', 'division_name', 'district_code', 'district_name', 'total_members', 'total_vo', 'total_clf'], 'required'],
            [['state_name'], 'string', 'max' => 100],
            [['division_name', 'district_name'], 'string', 'max' => 150],
            [['district_code'], 'unique'],
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
            'total_shgs' => 'Self-help groups (SHG) formed (Est.)',
            'total_members' => 'No. of SHG members (Est.)',
            'total_vo' => 'No. of Village Organizations (VO)',
            'total_clf' => 'No. of Cluster level federations (CLF)',
            'status' => 'Status',
        ];
    }

    public function getShgs() {
        return $this->hasMany(Shg::className(), ['district_code' => 'district_code'])->select(['id','no_of_members'])->where(['dummy_column' => 0]);
    }
    public function getVos() {
        return $this->hasMany(CboVo::className(), ['district_code' => 'district_code'])->select(['id'])->where(['dummy_column' => 0]);
    }
    public function getClfs() {
        return $this->hasMany(CboClf::className(), ['district_code' => 'district_code'])->select(['id'])->where(['dummy_column' => 0]);
    }
     public function getBlocks() {
        return $this->hasMany(\cbo\models\CboBlock::className(), ['district_code' => 'district_code']);
    }
}
