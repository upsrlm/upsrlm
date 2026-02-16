<?php

namespace common\models\dynamicdb\cbo_detail\dbt\scheme;

use Yii;
use common\models\dynamicdb\cbo_detail\CboDetailactiveRecord;

/**
 * This is the model class for table "dbt_beneficiary_scheme_bocw_labour_profile".
 *
 * @property int $id
 * @property string|null $uplmis_lab_reg_no
 * @property string|null $uplmis_date_of_reg
 * @property string|null $uplmis_Labour_name
 * @property string|null $uplmis_labour_name_eng
 * @property string|null $uplmis_gender
 * @property string|null $uplmis_father_husb_name
 * @property string|null $uplmis_father_husb_name_eng
 * @property string|null $uplmis_mobile_no
 * @property string|null $uplmis_dob
 * @property string|null $uplmis_caste
 * @property string|null $uplmis_temp_house_no
 * @property string|null $uplmis_temp_post
 * @property string|null $uplmis_temp_thana
 * @property string|null $uplmis_temp_address
 * @property string|null $uplmis_perm_house_no
 * @property string|null $uplmis_perm_address
 * @property string|null $uplmis_perm_post
 * @property string|null $uplmis_perm_thana
 * @property string|null $uplmis_perm_block
 * @property string|null $uplmis_labour_status
 * @property string|null $uplmis_marital_status
 * @property string|null $uplmis_perm_ward_village_name
 * @property string|null $uplmis_tmp_dis_name
 * @property string|null $uplmis_tmp_tehsil_name
 * @property string|null $uplmis_municipal_block_name
 * @property string|null $uplmis_occ_name
 * @property string|null $uplmis_state_name
 * @property string|null $uplmis_nominee
 * @property string|null $uplmis_nominee_relation
 * @property string|null $uplmis_niyojak_name_add
 * @property string|null $uplmis_niyojak_mobile_no
 * @property int|null $uplmis_gram_panchayat_code
 * @property string|null $date_of_reg
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
 */
class DbtBeneficiarySchemeBocwLabourProfile extends CboDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'dbt_beneficiary_scheme_bocw_labour_profile';
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
            [['uplmis_gram_panchayat_code', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'created_at', 'updated_at', 'status'], 'integer'],
            [['date_of_reg', 'dob'], 'safe'],
            [['uplmis_lab_reg_no', 'uplmis_date_of_reg', 'uplmis_gender', 'uplmis_labour_status', 'uplmis_marital_status'], 'string', 'max' => 50],
            [['uplmis_Labour_name', 'uplmis_labour_name_eng', 'uplmis_father_husb_name', 'uplmis_father_husb_name_eng', 'uplmis_temp_house_no', 'uplmis_temp_post', 'uplmis_temp_thana', 'uplmis_perm_house_no', 'uplmis_perm_address', 'uplmis_perm_post', 'uplmis_perm_thana', 'uplmis_perm_block', 'uplmis_perm_ward_village_name', 'uplmis_tmp_dis_name', 'uplmis_tmp_tehsil_name', 'uplmis_municipal_block_name', 'uplmis_occ_name', 'uplmis_state_name', 'uplmis_nominee', 'uplmis_nominee_relation', 'uplmis_niyojak_name_add', 'uplmis_niyojak_mobile_no', 'division_name', 'district_name', 'block_name', 'gram_panchayat_name'], 'string', 'max' => 150],
            [['uplmis_mobile_no'], 'string', 'max' => 20],
            [['uplmis_dob'], 'string', 'max' => 30],
            [['uplmis_caste'], 'string', 'max' => 100],
            [['uplmis_temp_address'], 'string', 'max' => 255],
            [['uplmis_lab_reg_no'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'uplmis_lab_reg_no' => 'Uplmis Lab Reg No',
            'uplmis_date_of_reg' => 'Uplmis Date Of Reg',
            'uplmis_Labour_name' => 'Uplmis Labour Name',
            'uplmis_labour_name_eng' => 'Uplmis Labour Name Eng',
            'uplmis_gender' => 'Uplmis Gender',
            'uplmis_father_husb_name' => 'Uplmis Father Husb Name',
            'uplmis_father_husb_name_eng' => 'Uplmis Father Husb Name Eng',
            'uplmis_mobile_no' => 'Uplmis Mobile No',
            'uplmis_dob' => 'Uplmis Dob',
            'uplmis_caste' => 'Uplmis Caste',
            'uplmis_temp_house_no' => 'Uplmis Temp House No',
            'uplmis_temp_post' => 'Uplmis Temp Post',
            'uplmis_temp_thana' => 'Uplmis Temp Thana',
            'uplmis_temp_address' => 'Uplmis Temp Address',
            'uplmis_perm_house_no' => 'Uplmis Perm House No',
            'uplmis_perm_address' => 'Uplmis Perm Address',
            'uplmis_perm_post' => 'Uplmis Perm Post',
            'uplmis_perm_thana' => 'Uplmis Perm Thana',
            'uplmis_perm_block' => 'Uplmis Perm Block',
            'uplmis_labour_status' => 'Uplmis Labour Status',
            'uplmis_marital_status' => 'Uplmis Marital Status',
            'uplmis_perm_ward_village_name' => 'Uplmis Perm Ward Village Name',
            'uplmis_tmp_dis_name' => 'Uplmis Tmp Dis Name',
            'uplmis_tmp_tehsil_name' => 'Uplmis Tmp Tehsil Name',
            'uplmis_municipal_block_name' => 'Uplmis Municipal Block Name',
            'uplmis_occ_name' => 'Uplmis Occ Name',
            'uplmis_state_name' => 'Uplmis State Name',
            'uplmis_nominee' => 'Uplmis Nominee',
            'uplmis_nominee_relation' => 'Uplmis Nominee Relation',
            'uplmis_niyojak_name_add' => 'Uplmis Niyojak Name Add',
            'uplmis_niyojak_mobile_no' => 'Uplmis Niyojak Mobile No',
            'uplmis_gram_panchayat_code' => 'Uplmis Gram Panchayat Code',
            'date_of_reg' => 'Date Of Reg',
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
        ];
    }

    public function beforeSave($insert) {

        if ($this->uplmis_date_of_reg) {
            $this->date_of_reg = date('Y-m-d H:i:s', strtotime($this->uplmis_date_of_reg));
        }
        if ($this->uplmis_dob) {
            $this->dob = date('Y-m-d H:i:s', strtotime($this->uplmis_dob));
        }

        return parent::beforeSave($insert);
    }

    public function getSchemeapplication() {
        return $this->hasMany(DbtBeneficiarySchemeBocwLabourSchemeStatus::className(), ['dbt_beneficiary_scheme_bocw_labour_profile_id' => 'id']);
    }

    public function getSchemepayment() {
        return $this->hasMany(DbtBeneficiarySchemeBocwPayment::className(), ['dbt_beneficiary_scheme_bocw_labour_scheme_status_id' => 'id'])->via('schemeapplication');
    }

}
