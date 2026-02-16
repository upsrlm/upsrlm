<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "master_gram_panchayat".
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
 * @property int $block_code
 * @property string $block_name
 * @property int $gram_panchayat_code
 * @property string $gram_panchayat_name
 * @property int $village_count
 * @property int $gp_covert_urban
 * @property int $eligible
 * @property int $new
 * @property int|null $new_status
 * @property int $name_match_status
 * @property string|null $new_block_name
 * @property int|null $new_block_code
 * @property string|null $new_gram_panchayat_name
 * @property int|null $new_gram_panchayat_code
 * @property int|null $doubt_block
 * @property int|null $updated_by
 * @property int|null $updated_at
 */
class MasterGramPanchayat extends \common\models\dynamicdb\cbo\CboactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'master_gram_panchayat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['division_code', 'division_name', 'district_code', 'district_name', 'sub_district_code', 'sub_district_name', 'block_code', 'block_name', 'gram_panchayat_code', 'gram_panchayat_name'], 'required'],
            [['division_code', 'district_code', 'sub_district_code', 'block_code', 'gram_panchayat_code'], 'integer'],
            [['division_name', 'district_name', 'sub_district_name', 'block_name'], 'string', 'max' => 150],
            [['gram_panchayat_name'], 'string', 'max' => 132],
            [['gram_panchayat_code'], 'unique'],
            [['new', 'new_status'], 'integer'],
            [['new_gram_panchayat_name'], 'string', 'max' => 150],
            [['new_gram_panchayat_code'], 'integer'],
            [['gp_covert_urban'], 'default', 'value' => 0],
            [['updated_by', 'updated_at'], 'integer'],
            [['new_block_name'], 'string', 'max' => 150],
            [['new_block_code'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'sub_district_code' => 'Sub District Code',
            'sub_district_name' => 'Sub District Name',
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'gp_covert_urban' => 'GP covert urban',
        ];
    }
    public function getGpdetailwada() {
        return $this->hasOne(MasterGramPanchayatDetailWada::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }
    public function getVillage() {
        return $this->hasMany(MasterVillage::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }

    public function getDistrict() {
        return $this->hasOne(MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getsubdistrict() {
        return $this->hasOne(MasterVillage::className(), ['sub_district_code' => 'sub_district_code']);
    }

    public function getBlock() {
        return $this->hasOne(MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getGpa_detail() {
        return $this->hasMany(\common\models\RelationUserGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code'])->join('inner join', "user", "relation_user_gram_panchayat.user_id=user.id")->where(["relation_user_gram_panchayat.status" => 1,"user.role" => MasterRole::ROLE_GP_SAACHIV]);
    }

    public function getShg() {
        return $this->hasMany(\cbo\models\Shg::className(), ['gram_panchayat_code' => 'gram_panchayat_code'])->select(['id', 'gram_panchayat_code', 'status'])->where(['!=', 'cbo_shg.status', -1]);
    }
    public function getGpsel() {
        return $this->hasOne(\bc\models\master\MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }
    public function beforeSave($insert) {

        $this->updated_at = time();

        if (is_a(\Yii::$app, 'yii\console\Application')) {
            
        } else {
            $this->updated_by = \Yii::$app->user->identity->id;
        }
        return parent::beforeSave($insert);
    }

}
