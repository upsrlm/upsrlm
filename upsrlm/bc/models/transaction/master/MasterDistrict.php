<?php

namespace bc\models\transaction\master;

use Yii;

/**
 * This is the model class for table "master_district".
 *
 * @property int $id
 * @property int $division_code
 * @property string $division_name
 * @property int $district_code
 * @property string $district_name
 * @property int $ulb_count
 * @property int $block_count
 * @property int $gram_panchayat_count
 * @property int $village_count
 * @property int $bc_selection_application_receive
 * @property int $bc_selection_sc_st_application_receive
 * @property int $bc_selection_obc_application_receive
 * @property int $bc_selection_general_application_receive
 * @property int $group_member
 * @property int $wada_district
 * @property int $saheli
 */
class MasterDistrict extends \bc\models\transaction\BctransactionactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'master_district';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['division_code', 'division_name', 'district_code', 'district_name', 'block_count', 'gram_panchayat_count', 'village_count'], 'required'],
            [['division_code', 'district_code', 'ulb_count', 'block_count', 'gram_panchayat_count', 'village_count', 'bc_selection_application_receive', 'bc_selection_sc_st_application_receive', 'bc_selection_obc_application_receive', 'bc_selection_general_application_receive', 'group_member'], 'integer'],
            [['division_name', 'district_name', 'lat', 'lng'], 'string', 'max' => 150],
            [['district_code'], 'unique'],
            [['bc_selection_application_receive'], 'default', 'value' => 0],
            [['bc_selection_sc_st_application_receive'], 'default', 'value' => 0],
            [['bc_selection_obc_application_receive'], 'default', 'value' => 0],
            [['bc_selection_general_application_receive'], 'default', 'value' => 0],
            [['group_member'], 'default', 'value' => 0],
            [['wada_district','saheli'], 'integer'],
            [['wada_district'], 'default', 'value' => 0],
            [['saheli'], 'default', 'value' => 0],
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
            'ulb_count' => 'Ulb Count',
            'block_count' => 'Block Count',
            'gram_panchayat_count' => 'Gram Panchayat Count',
            'village_count' => 'Village Count',
            'lat' => 'Lat',
            'lng' => 'Lng',
        ];
    }

    public function getPartnerbank() {
        return $this->hasOne(MasterPartnerBankDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getBlock() {
        return $this->hasMany(MasterBlock::className(), ['district_code' => 'district_code'])->where(['master_block.status' => 1]);
    }

    public function getUlb() {
        return $this->hasMany(MasterBlock::className(), ['district_code' => 'district_code']);
    }

    public function getGp() {
        return $this->hasMany(MasterGramPanchayat::className(), ['district_code' => 'district_code'])->where(['master_gram_panchayat.status' => 1])->andWhere(['!=', 'block_code', 0]);
    }

    public function getVillage() {
        return $this->hasMany(MasterVillage::className(), ['district_code' => 'district_code']);
    }

    public function getBcall() {
        return $this->hasMany(\bc\modules\selection\models\SrlmBcApplication::className(), ['district_code' => 'district_code'])->andWhere(['!=', 'srlm_bc_application.status', \bc\modules\selection\models\SrlmBcApplication::DELETE])->select('id')->asArray();
    }

    public function getBasicprofile() {
        return $this->hasMany(\bc\modules\selection\models\SrlmBcApplication::className(), ['district_code' => 'district_code'])->select('id')->andWhere(['!=', 'srlm_bc_application.status', \bc\modules\selection\models\SrlmBcApplication::DELETE])->andWhere(['srlm_bc_application.form_status' => \bc\modules\selection\models\SrlmBcApplication::FORM_STATUS_BASIC_PROFILE])->asArray();
    }

    public function getFamilyprofile() {
        return $this->hasMany(\bc\modules\selection\models\SrlmBcApplication::className(), ['district_code' => 'district_code'])->select('id')->andWhere(['!=', 'srlm_bc_application.status', \bc\modules\selection\models\SrlmBcApplication::DELETE])->andWhere(['srlm_bc_application.form_status' => \bc\modules\selection\models\SrlmBcApplication::FORM_STATUS_FAMILY_PROFILE])->asArray();
    }

    public function getPart1() {
        return $this->hasMany(\bc\modules\selection\models\SrlmBcApplication::className(), ['district_code' => 'district_code'])->select('id')->andWhere(['!=', 'srlm_bc_application.status', \bc\modules\selection\models\SrlmBcApplication::DELETE])->andWhere(['srlm_bc_application.form_status' => \bc\modules\selection\models\SrlmBcApplication::FORM_STATUS_BASIC_PROFILE])->asArray();
    }

    public function getPart2() {
        return $this->hasMany(\bc\modules\selection\models\SrlmBcApplication::className(), ['district_code' => 'district_code'])->select('id')->andWhere(['!=', 'srlm_bc_application.status', \bc\modules\selection\models\SrlmBcApplication::DELETE])->andWhere(['srlm_bc_application.form_status' => \bc\modules\selection\models\SrlmBcApplication::FORM_STATUS_PART_1])->asArray();
    }

    public function getPart3() {
        return $this->hasMany(\bc\modules\selection\models\SrlmBcApplication::className(), ['district_code' => 'district_code'])->select('id')->andWhere(['!=', 'srlm_bc_application.status', \bc\modules\selection\models\SrlmBcApplication::DELETE])->andWhere(['srlm_bc_application.form_status' => \bc\modules\selection\models\SrlmBcApplication::FORM_STATUS_PART_2])->asArray();
    }

    public function getPart4() {
        return $this->hasMany(\bc\modules\selection\models\SrlmBcApplication::className(), ['district_code' => 'district_code'])->select('id')->andWhere(['!=', 'srlm_bc_application.status', \bc\modules\selection\models\SrlmBcApplication::DELETE])->andWhere(['srlm_bc_application.form_status' => \bc\modules\selection\models\SrlmBcApplication::FORM_STATUS_PART_4])->asArray();
    }

    public function getBcalls() {
        return $this->hasMany(\bc\modules\selection\models\SrlmBcApplication::className(), ['district_code' => 'district_code'])->andWhere(['!=', 'srlm_bc_application.status', \bc\modules\selection\models\SrlmBcApplication::DELETE]);
    }

    public function getSelected() {
        return $this->hasMany(MasterGramPanchayat::className(), ['district_code' => 'district_code'])->andWhere(['!=', 'selected_application_id', 0])->count();
    }

    public function getGpnoreg() {
        return $this->hasMany(MasterGramPanchayat::className(), ['district_code' => 'district_code'])->joinWith(['bcall'])->andWhere(['srlm_bc_application.id' => null]);
    }

    public function getNoregsrlmgp() {
        return $this->hasMany(MasterGramPanchayat::className(), ['district_code' => 'district_code'])->select('master_gram_panchayat.id')->joinWith(['bcall'])->andWhere(['srlm_bc_application.id' => null])->count();
    }

}
