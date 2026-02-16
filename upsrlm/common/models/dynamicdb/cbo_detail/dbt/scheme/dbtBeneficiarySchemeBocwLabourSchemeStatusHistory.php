<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use Yii;
use common\models\dynamicdb\cbo_detail\CboDetailactiveRecord;

/**
 * This is the model class for table "dbt_beneficiary_scheme_bocw_labour_scheme_status_history".
 *
 * @property int $id
 * @property int|null $dbt_beneficiary_scheme_bocw_labour_profile_id
 * @property string|null $uplmis_app_no
 * @property string|null $uplmis_lab_reg_no
 * @property string|null $uplmis_app_date
 * @property string|null $uplmis_scheme_name
 * @property string|null $uplmis_status
 * @property string|null $uplmis_Labour_name
 * @property string|null $uplmis_labour_name_eng
 * @property string|null $uplmis_father_husb_name
 * @property string|null $uplmis_father_husb_name_eng
 * @property string|null $uplmis_mother_name
 * @property string|null $uplmis_mother_name_eng
 * @property string|null $uplmis_dob
 * @property string|null $uplmis_temp_house_no
 * @property string|null $uplmis_village_name
 * @property string|null $uplmis_temp_pincode
 * @property string|null $uplmis_temp_post
 * @property string|null $uplmis_temp_thana
 * @property string|null $uplmis_temp_address
 * @property string|null $uplmis_vw_district_name
 * @property string|null $uplmis_vw_division_name
 * @property int|null $uplmis_gram_panchayat_code
 * @property int|null $scheme_id
 * @property string|null $app_date
 * @property string|null $dob
 * @property int|null $division_code
 * @property string|null $division_name
 * @property int|null $district_code
 * @property string|null $district_name
 * @property int|null $block_code
 * @property string|null $block_name
 * @property int|null $gram_panchayat_code
 * @property string|null $gram_panchayat_name
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 * @property int|null $parent_id
 */
class dbtBeneficiarySchemeBocwLabourSchemeStatusHistory extends CboDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'dbt_beneficiary_scheme_bocw_labour_scheme_status_history';
    }

    public function behaviors() {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['uplmis_gram_panchayat_code', 'scheme_id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'created_at', 'updated_at', 'status', 'parent_id', 'dbt_beneficiary_scheme_bocw_labour_profile_id'], 'integer'],
            [['app_date', 'dob'], 'safe'],
            [['uplmis_app_no', 'uplmis_lab_reg_no', 'uplmis_app_date'], 'string', 'max' => 50],
            [['uplmis_scheme_name', 'uplmis_temp_address'], 'string', 'max' => 255],
            [['uplmis_status'], 'string', 'max' => 100],
            [['uplmis_Labour_name', 'uplmis_labour_name_eng', 'uplmis_father_husb_name', 'uplmis_father_husb_name_eng', 'uplmis_mother_name', 'uplmis_mother_name_eng', 'uplmis_temp_house_no', 'uplmis_village_name', 'uplmis_temp_post', 'uplmis_temp_thana', 'uplmis_vw_district_name', 'uplmis_vw_division_name', 'division_name', 'district_name', 'block_name', 'gram_panchayat_name'], 'string', 'max' => 150],
            [['uplmis_dob'], 'string', 'max' => 30],
            [['uplmis_temp_pincode'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'uplmis_app_no' => 'Uplmis App No',
            'uplmis_lab_reg_no' => 'Uplmis Lab Reg No',
            'uplmis_app_date' => 'Uplmis App Date',
            'uplmis_scheme_name' => 'Uplmis Scheme Name',
            'uplmis_status' => 'Uplmis Status',
            'uplmis_Labour_name' => 'Uplmis Labour Name',
            'uplmis_labour_name_eng' => 'Uplmis Labour Name Eng',
            'uplmis_father_husb_name' => 'Uplmis Father Husb Name',
            'uplmis_father_husb_name_eng' => 'Uplmis Father Husb Name Eng',
            'uplmis_mother_name' => 'Uplmis Mother Name',
            'uplmis_mother_name_eng' => 'Uplmis Mother Name Eng',
            'uplmis_dob' => 'Uplmis Dob',
            'uplmis_temp_house_no' => 'Uplmis Temp House No',
            'uplmis_village_name' => 'Uplmis Village Name',
            'uplmis_temp_pincode' => 'Uplmis Temp Pincode',
            'uplmis_temp_post' => 'Uplmis Temp Post',
            'uplmis_temp_thana' => 'Uplmis Temp Thana',
            'uplmis_temp_address' => 'Uplmis Temp Address',
            'uplmis_vw_district_name' => 'Uplmis Vw District Name',
            'uplmis_vw_division_name' => 'Uplmis Vw Division Name',
            'uplmis_gram_panchayat_code' => 'Uplmis Gram Panchayat Code',
            'scheme_id' => 'Scheme ID',
            'app_date' => 'App Date',
            'dob' => 'Dob',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'parent_id' => 'Parent ID',
        ];
    }

}
