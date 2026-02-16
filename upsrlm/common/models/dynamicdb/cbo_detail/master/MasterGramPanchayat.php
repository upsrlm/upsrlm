<?php

namespace common\models\dynamicdb\cbo_detail\master;

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
 * @property int $bc_selection_application_receive
 * @property int $selected_application_id
 * @property int $bc_selection_sc_st_application_receive
 * @property int $bc_selection_obc_application_receive
 * @property int $bc_selection_general_application_receive
 * @property int $group_member
 * @property int|null $selected_bc
 * @property int $selected_but_not_eligible
 * @property int $no_of_eligible_application
 * @property int|null $first_standby_id
 * @property int|null $final_bc_id
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
class MasterGramPanchayat extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

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
            [['division_code', 'district_code', 'sub_district_code', 'block_code', 'gram_panchayat_code', 'bc_selection_application_receive', 'selected_application_id', 'bc_selection_sc_st_application_receive', 'bc_selection_obc_application_receive', 'bc_selection_general_application_receive', 'group_member'], 'integer'],
            [['division_name', 'district_name', 'sub_district_name', 'block_name'], 'string', 'max' => 150],
            [['gram_panchayat_name'], 'string', 'max' => 132],
            [['gram_panchayat_code'], 'unique'],
            [['bc_selection_application_receive'], 'default', 'value' => 0],
            [['selected_application_id'], 'default', 'value' => 0],
            [['bc_selection_sc_st_application_receive'], 'default', 'value' => 0],
            [['bc_selection_obc_application_receive'], 'default', 'value' => 0],
            [['bc_selection_general_application_receive'], 'default', 'value' => 0],
            [['group_member'], 'default', 'value' => 0],
            [['selected_bc'], 'integer'],
            [['selected_but_not_eligible', 'no_of_eligible_application', 'first_standby_id', 'final_bc_id', 'eligible', 'new', 'new_status', 'name_match_status'], 'integer'],
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
        return $this->hasMany(\common\models\RelationUserGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code'])->join('inner join', "user", "relation_user_gram_panchayat.user_id=user.id")->where(["user.role" => MasterRole::ROLE_GP_SAACHIV]);
    }

    public function getShg() {
        return $this->hasMany(\cbo\models\Shg::className(), ['gram_panchayat_code' => 'gram_panchayat_code'])->select(['id', 'gram_panchayat_code', 'status'])->where(['!=', 'cbo_shg.status', -1]);
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
