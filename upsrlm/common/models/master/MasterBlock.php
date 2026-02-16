<?php

namespace common\models\master;

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
class MasterBlock extends \common\models\dynamicdb\cbo\CboactiveRecord {

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
            [['division_code', 'district_code', 'sub_district_code', 'gram_panchayat_count', 'village_count', 'bc_selection_application_receive', 'bc_selection_sc_st_application_receive', 'bc_selection_obc_application_receive', 'bc_selection_general_application_receive', 'group_member', 'aspirational'], 'integer'],
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
            [['new_block_name'], 'string', 'max' => 50],
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
        return $this->hasMany(\common\models\RelationUserBdoBlock::className(), ['block_code' => 'block_code'])->joinWith(['user'])->where(['relation_user_bdo_block.status' => \common\models\base\GenralModel::STATUS_ACTIVE,'user.role'=>31,'user.status'=>10]);
    }

    public function getDistrict() {
        return $this->hasOne(MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getSubdistrict() {
        return $this->hasOne(MasterVillage::className(), ['sub_district_code' => 'sub_district_code']);
    }

    public function beforeSave($insert) {

        $this->updated_at = time();

        if (is_a(\Yii::$app, 'yii\console\Application')) {
            
        } else {
            $this->updated_by = \Yii::$app->user->identity->id;
        }
        return parent::beforeSave($insert);
    }
      public static function getTotal($provider, $columnName, $search = null) {
        $total = 0;
        $query = \common\models\dynamicdb\ultrapoor\nfsa\NfsaBaseSurvey::find()->select(['id'])->where(['>=', 'nfsa_base_survey.status', 0])->andwhere(['area' => 1])->andWhere(['=', 'nfsa_base_survey.urban_gp', 0]);
        if (isset($search->district_code) and $search->district_code != '') {
            $query->andWhere(['district_code' => $search->district_code]);
        }
        if (isset($search->block_code) and $search->block_code != '') {
            $query->andWhere(['block_code' => $search->block_code]);
        }
        if ($columnName == 'name') {
            $name = 'Uttar Pradesh';
            if (isset($search->district_code) and $search->district_code != '') {
                $model = MasterDistrict::find()->where(['district_code' => $search->district_code])->one();
                if ($model != null) {
                    $name .= ' : ' . $model->district_name;
                }
            }
            if (isset($search->block_code) and $search->block_code != '') {
               $model1 = MasterBlock::find()->where(['block_code' => $search->block_code])->one();
                if ($model1 != null) {
                    $name .= ' : ' . $model1->block_name;
                }
            }
            return $name;
        }
        if ($columnName == 'hhs') {
            $total = $query->count();
        }
        if ($columnName == 'attempt_hhs_number') {
            $query->andWhere(['>', 'nfsa_base_survey.ctc_click_count', 0]);
            $total = $query->count();
        }
        if ($columnName == 'remain') {
            $query->andWhere(['=', 'nfsa_base_survey.ctc_click_count', 0]);
            $total = $query->count();
        }
        if ($columnName == 'verified') {
            $query->andWhere(['digital_verification_status' => 1]);
            $total = $query->count();
        }
        if ($columnName == 'unverified') {
            $query->andWhere(['digital_verification_status' => 2]);
            $total = $query->count();
        }
        if ($columnName == 'phone_type') {
            $query->andWhere(['phone_type' => 1]);
            $total = $query->count();
        }
        if ($columnName == 'wrong_no') {
            $query->andWhere(['mobile_status' => 11]);
            $total = $query->count();
        }
        if ($columnName == 'no_does_notexist') {
            $query->andWhere(['mobile_status' => 30]);
            $total = $query->count();
        }
        return $total;
    }

}
