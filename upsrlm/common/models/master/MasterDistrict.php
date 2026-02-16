<?php

namespace common\models\master;

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
class MasterDistrict extends \common\models\dynamicdb\cbo\CboactiveRecord {

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
            [['wada_district', 'saheli'], 'integer'],
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
        return $this->hasMany(MasterBlock::className(), ['district_code' => 'district_code']);
    }

    public function getUlb() {
        return $this->hasMany(MasterBlock::className(), ['district_code' => 'district_code']);
    }

    public function getGp() {
        return $this->hasMany(MasterGramPanchayat::className(), ['district_code' => 'district_code'])->andWhere(['!=', 'block_code', 0]);
    }

    public function getVillage() {
        return $this->hasMany(MasterVillage::className(), ['district_code' => 'district_code']);
    }

    public function getGpnoreg() {
        return $this->hasMany(MasterGramPanchayat::className(), ['district_code' => 'district_code'])->joinWith(['bcall'])->andWhere(['srlm_bc_application.id' => null]);
    }

    public static function getTotal($provider, $columnName, $search = null) {
        $total = 0;
        $query = \common\models\dynamicdb\ultrapoor\nfsa\NfsaBaseSurvey::find()->select(['id'])->where(['>=', 'nfsa_base_survey.status', 0])->andwhere(['area' => 1])->andWhere(['=', 'nfsa_base_survey.urban_gp', 0]);
        if (isset($search->district_code) and $search->district_code != '') {
            $query->andWhere(['district_code' => $search->district_code]);
        }
        if ($columnName == 'name') {
            $name = 'Uttar Pradesh';
            if (isset($search->district_code) and $search->district_code != '') {
                $model = MasterDistrict::find()->where(['district_code' => $search->district_code])->one();
                if ($model != null) {
                    $name .= ' : ' . $model->district_name;
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
