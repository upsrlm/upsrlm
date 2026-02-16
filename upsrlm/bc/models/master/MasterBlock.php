<?php

namespace bc\models\master;

use Yii;

/**
 * This is the model class for table "master_block".
 *
 * @property int $id
 * @property int $division_code
 * @property string $division_name
 * @property int $district_code
 * @property string $district_name
 * @property int $sub_district_code
 * @property string $sub_district_name
 * @property string $block_code
 * @property string $block_name
 * @property int|null $new_block_code
 * @property string|null $new_block_name
 * @property int $gram_panchayat_count
 * @property int $village_count
 * @property int $bc_selection_application_receive
 * @property int $bc_selection_sc_st_application_receive
 * @property int $bc_selection_obc_application_receive
 * @property int $bc_selection_general_application_receive
 * @property int $group_member
 * @property int|null $updated_by
 * @property int|null $updated_at
 * @property int $aspirational
 */
class MasterBlock extends \bc\modules\selection\models\BcactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'master_block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['division_code', 'division_name', 'district_code', 'district_name', 'sub_district_code', 'sub_district_name', 'block_code', 'block_name'], 'required'],
            [['division_code', 'district_code', 'sub_district_code', 'gram_panchayat_count', 'village_count', 'bc_selection_application_receive', 'bc_selection_sc_st_application_receive', 'bc_selection_obc_application_receive', 'bc_selection_general_application_receive', 'group_member','aspirational'], 'integer'],
            [['division_name', 'district_name'], 'string', 'max' => 150],
            [['sub_district_name'], 'string', 'max' => 20],
            [['block_code'], 'string', 'max' => 4],
            [['block_name'], 'string', 'max' => 23],
            [['block_code'], 'unique'],
            [['bc_selection_application_receive'], 'default', 'value' => 0],
            [['bc_selection_sc_st_application_receive'], 'default', 'value' => 0],
            [['bc_selection_obc_application_receive'], 'default', 'value' => 0],
            [['bc_selection_general_application_receive'], 'default', 'value' => 0],
            [['group_member'], 'default', 'value' => 0],
            [['new_block_code'], 'unique'],
            [['new_block_code'], 'integer'],
            [['new_block_name'], 'string', 'max' => 23],
            [['updated_by', 'updated_at'], 'integer'],
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
            'new_block_code' => 'New Block Code',
            'new_block_name' => 'New Block Name',
            'gram_panchayat_count' => 'Gram Panchayat Count',
            'village_count' => 'Village Count',
            'aspirational' => 'Wada Sakhi block',
        ];
    }

    public function getGp() {
        return $this->hasMany(MasterGramPanchayat::className(), ['block_code' => 'block_code']);
    }

    public function getVillage() {
        return $this->hasMany(MasterVillage::className(), ['block_code' => 'block_code']);
    }

    public function getBdo_detail() {
        return $this->hasMany(\common\models\RelationUserBdoBlock::className(), ['block_code' => 'block_code'])->where(['status' => \common\models\base\GenralModel::STATUS_ACTIVE]);
    }

    public function getDistrict() {
        return $this->hasOne(MasterVillage::className(), ['district_code' => 'district_code']);
    }

    public function getSubdistrict() {
        return $this->hasOne(MasterVillage::className(), ['sub_district_code' => 'sub_district_code']);
    }
    public function getDiv() {
        return $this->hasOne(MasterDivision::className(), ['division_code' => 'division_code']);
    }
    public function getBcall() {
        return $this->hasMany(\bc\modules\selection\models\SrlmBcApplication::className(), ['block_code' => 'block_code'])->select('id')->andWhere(['!=', 'srlm_bc_application.status', \bc\modules\selection\models\SrlmBcApplication::DELETE])->asArray();
    }

    public function getBasicprofile() {
        return $this->hasMany(\bc\modules\selection\models\SrlmBcApplication::className(), ['block_code' => 'block_code'])->select('id')->andWhere(['!=', 'srlm_bc_application.status', \bc\modules\selection\models\SrlmBcApplication::DELETE])->andWhere(['srlm_bc_application.form_status' => \bc\modules\selection\models\SrlmBcApplication::FORM_STATUS_BASIC_PROFILE])->asArray();
    }

    public function getFamilyprofile() {
        return $this->hasMany(\bc\modules\selection\models\SrlmBcApplication::className(), ['block_code' => 'block_code'])->select('id')->andWhere(['!=', 'srlm_bc_application.status', \bc\modules\selection\models\SrlmBcApplication::DELETE])->andWhere(['srlm_bc_application.form_status' => \bc\modules\selection\models\SrlmBcApplication::FORM_STATUS_FAMILY_PROFILE])->asArray();
    }

    public function getPart1() {
        return $this->hasMany(\bc\modules\selection\models\SrlmBcApplication::className(), ['block_code' => 'block_code'])->select('id')->andWhere(['!=', 'srlm_bc_application.status', \bc\modules\selection\models\SrlmBcApplication::DELETE])->andWhere(['srlm_bc_application.form_status' => \bc\modules\selection\models\SrlmBcApplication::FORM_STATUS_BASIC_PROFILE])->asArray();
    }

    public function getPart2() {
        return $this->hasMany(\bc\modules\selection\models\SrlmBcApplication::className(), ['block_code' => 'block_code'])->select('id')->andWhere(['!=', 'srlm_bc_application.status', \bc\modules\selection\models\SrlmBcApplication::DELETE])->andWhere(['srlm_bc_application.form_status' => \bc\modules\selection\models\SrlmBcApplication::FORM_STATUS_PART_1])->asArray();
    }

    public function getPart3() {
        return $this->hasMany(\bc\modules\selection\models\SrlmBcApplication::className(), ['block_code' => 'block_code'])->select('id')->andWhere(['!=', 'srlm_bc_application.status', \bc\modules\selection\models\SrlmBcApplication::DELETE])->andWhere(['srlm_bc_application.form_status' => \bc\modules\selection\models\SrlmBcApplication::FORM_STATUS_PART_2])->asArray();
    }

    public function getPart4() {
        return $this->hasMany(\bc\modules\selection\models\SrlmBcApplication::className(), ['block_code' => 'block_code'])->select('id')->andWhere(['!=', 'srlm_bc_application.status', \bc\modules\selection\models\SrlmBcApplication::DELETE])->andWhere(['srlm_bc_application.form_status' => \bc\modules\selection\models\SrlmBcApplication::FORM_STATUS_PART_4])->asArray();
    }

    public function getBcalls() {
        return $this->hasMany(\bc\modules\selection\models\SrlmBcApplication::className(), ['block_code' => 'block_code'])->andWhere(['!=', 'srlm_bc_application.status', \bc\modules\selection\models\SrlmBcApplication::DELETE]);
    }

    public function getSelected() {
        return $this->hasMany(MasterGramPanchayat::className(), ['block_code' => 'block_code'])->andWhere(['!=', 'selected_application_id', 0])->count();
    }

    public function getNoregsrlmgp() {
        return $this->hasMany(MasterGramPanchayat::className(), ['block_code' => 'block_code'])->select('master_gram_panchayat.id')->joinWith(['bcall'])->andWhere(['srlm_bc_application.id' => null])->count();
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
