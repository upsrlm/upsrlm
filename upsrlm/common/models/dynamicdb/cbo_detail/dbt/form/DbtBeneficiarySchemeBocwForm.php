<?php

namespace common\models\dynamicdb\cbo_detail\dbt\form;

use Yii;
use yii\helpers\ArrayHelper;
use common\validators\MobileNoValidator;
use common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiaryMember;
use common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiaryHousehold;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeBocwApplicant;
use common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiarySchemeBocwMasterBenifits;

/**
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class DbtBeneficiarySchemeBocwForm extends \yii\base\Model {

    public $cbo_shg_id;
    public $rishta_shg_member_id;
    public $dbt_beneficiary_household_id;
    public $dbt_beneficiary_member_id;
    public $division_code;
    public $division_name;
    public $district_code;
    public $district_name;
    public $block_code;
    public $block_name;
    public $gram_panchayat_code;
    public $gram_panchayat_name;
    public $village_code;
    public $village_name;
    public $name;
    public $mobile;
    public $marital_status;
    public $dob;
    public $age;
    public $relation_id;
    public $locality_id;
    public $gender;
    public $family_head;
    public $bank_account_no;
    public $bank_id;
    public $name_of_bank;
    public $branch;
    public $branch_code_or_ifsc;
    public $passbook_photo;
    public $member_photo;
    public $member_sign_thumb;
    public $aadhar_front_photo;
    public $aadhar_back_photo;
    public $voter_id_photo;
    public $father_name;
    public $physically_handicapped;
    public $aadhaar_number;
    public $voter_id_no;
    public $bocw_reg_no;
    public $application_number;
    public $application_date;
    public $scheme_name;
    public $scheme_id;
    public $no_of_family_member;
    public $created_by;
    public $updated_at;
    public $created_at;
    public $updated_by;
    public $status;
    public $scheme_option = [];
    public $member_model;
    public $member_bocw_application_model;

    public function __construct($member_model) {
        $this->member_model = $member_model;
        $this->member_bocw_application_model = Yii::createObject([
                    'class' => DbtBeneficiarySchemeBocwApplicant::className()
        ]);
        $this->cbo_shg_id = $this->member_model->cbo_shg_id;
        $this->rishta_shg_member_id = $this->member_model->rishta_shg_member_id;
        $this->dbt_beneficiary_household_id = $this->member_model->dbt_beneficiary_household_id;
        $this->dbt_beneficiary_member_id = $this->member_model->id;
        $this->name = $this->member_model->name;
        $this->mobile = $this->member_model->mobile;
        $this->bocw_reg_no = $this->member_model->household->bocw_reg_no;
        $this->scheme_option = ArrayHelper::map(DbtBeneficiarySchemeBocwMasterBenifits::find()->where(['status' => 1])->all(), 'id', 'name_hi');
    }

    public function rules() {
        return [
            [['cbo_shg_id', 'dbt_beneficiary_household_id', 'dbt_beneficiary_member_id', 'scheme_id', 'bocw_reg_no', 'application_number'], 'required'],
            [['application_number'], 'required'],
            [['application_number'], 'string', 'min' => 3],
            [['application_date'], 'required'],
            [['scheme_id'], 'required'],
            [['name'], 'required'],
            [['mobile'], 'required'],
            [['bocw_reg_no'], 'required'],
            [['application_number'], \common\validators\DuplicateApplicationNoValidator::className()],
            [['cbo_shg_id', 'rishta_shg_member_id', 'dbt_beneficiary_household_id', 'dbt_beneficiary_member_id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'marital_status', 'age', 'relation_id', 'locality_id', 'gender', 'family_head', 'bank_id', 'physically_handicapped', 'scheme_id', 'created_by', 'updated_at', 'created_at', 'updated_by', 'status'], 'integer'],
            [['dob', 'application_date'], 'safe'],
            [['scheme_name'], 'safe'],
            [['division_name', 'name', 'name_of_bank', 'branch', 'father_name'], 'string', 'max' => 150],
            [['district_name', 'block_name'], 'string', 'max' => 30],
            [['gram_panchayat_name', 'village_name'], 'string', 'max' => 125],
            [['mobile'], 'string', 'max' => 15],
            [['bank_account_no', 'branch_code_or_ifsc'], 'string', 'max' => 25],
            [['passbook_photo', 'member_photo', 'member_sign_thumb', 'aadhar_front_photo', 'aadhar_back_photo', 'voter_id_photo'], 'string', 'max' => 500],
            [['aadhaar_number', 'voter_id_no'], 'string', 'max' => 12],
            [['bocw_reg_no', 'application_number'], 'string', 'max' => 100],
            [['scheme_name'], 'string', 'max' => 255],
            [['no_of_family_member'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_shg_id' => 'Cbo Shg ID',
            'rishta_shg_member_id' => 'Rishta Shg Member ID',
            'dbt_beneficiary_household_id' => 'Dbt Beneficiary Household ID',
            'dbt_beneficiary_member_id' => 'Dbt Beneficiary Member ID',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'village_code' => 'Village Code',
            'village_name' => 'Village Name',
            'name' => 'नाम',
            'mobile' => 'मोबाइल नंबर',
            'marital_status' => 'Marital Status',
            'dob' => 'Dob',
            'age' => 'Age',
            'relation_id' => 'Relation ID',
            'locality_id' => 'Locality ID',
            'gender' => 'Gender',
            'family_head' => 'Family Head',
            'bank_account_no' => 'Bank Account No',
            'bank_id' => 'Bank ID',
            'name_of_bank' => 'Name Of Bank',
            'branch' => 'Branch',
            'branch_code_or_ifsc' => 'Branch Code Or Ifsc',
            'passbook_photo' => 'Passbook Photo',
            'member_photo' => 'Member Photo',
            'member_sign_thumb' => 'Member Sign Thumb',
            'aadhar_front_photo' => 'Aadhar Front Photo',
            'aadhar_back_photo' => 'Aadhar Back Photo',
            'voter_id_photo' => 'Voter Id Photo',
            'father_name' => 'Father Name',
            'physically_handicapped' => 'Physically Handicapped',
            'aadhaar_number' => 'Aadhaar Number',
            'voter_id_no' => 'Voter Id No',
            'bocw_reg_no' => 'बीओसीडब्ल्यू पंजीकरण संख्या',
            'application_number' => 'आवेदन संख्या',
            'application_date' => 'आवेदन तिथि',
            'scheme_name' => 'योजना का नाम',
            'scheme_id' => 'योजना का नाम',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

}
