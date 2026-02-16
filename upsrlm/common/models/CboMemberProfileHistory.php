<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cbo_member_profile_history".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $folder_prefix
 * @property string $first_name
 * @property string|null $middle_name
 * @property string|null $sur_name
 * @property int|null $gender
 * @property string|null $date_of_birth
 * @property string|null $primary_phone_no
 * @property int $primary_phone_no_verified
 * @property string|null $primary_phone_no_verified_date
 * @property string|null $alternate_phone_no
 * @property int $alternate_phone_no_verified
 * @property string|null $alternate_phone_no_verified_date
 * @property string|null $whatsapp_no
 * @property int $whatsapp_no_verified
 * @property string|null $whatsapp_no_verified_date
 * @property string|null $email_id
 * @property int $email_id_verified
 * @property string|null $email_id_verified_date
 * @property string|null $aadhaar_number
 * @property int $bc
 * @property int $samuh_sakhi
 * @property int $wada_sakhi
 * @property int $accountant
 * @property int $shg
 * @property int $vo
 * @property int $clf
 * @property int|null $age
 * @property int|null $cast
 * @property int|null $division_code
 * @property string|null $division_name
 * @property int|null $district_code
 * @property string|null $district_name
 * @property int|null $block_code
 * @property string|null $block_name
 * @property int|null $gram_panchayat_code
 * @property string|null $gram_panchayat_name
 * @property int|null $village_code
 * @property string|null $village_name
 * @property string|null $hamlet
 * @property string|null $guardian_name
 * @property string|null $otp_mobile_no
 * @property int|null $marital_status
 * @property int|null $srlm_bc_application_id
 * @property int|null $srlm_bc_selection_user_id
 * @property string|null $bank_account_no
 * @property int|null $bank_id
 * @property string|null $name_of_bank
 * @property string|null $branch
 * @property string|null $branch_code_or_ifsc
 * @property string|null $date_of_opening_the_bank_account
 * @property string|null $cin
 * @property string|null $iibf_membership_no
 * @property string|null $profile_photo
 * @property string|null $photo_aadhaar_front
 * @property string|null $photo_aadhaar_back
 * @property string|null $passbook_photo
 * @property string|null $pan_photo
 * @property string|null $iibf_photo_file_name
 * @property string|null $pvr_upload_file_name
 * @property string|null $bc_handheld_machine_photo
 * @property string|null $passbook_photo_shg
 * @property string|null $bank_account_no_of_the_shg
 * @property int|null $bank_id_shg
 * @property string|null $name_of_bank_shg
 * @property string|null $branch_shg
 * @property string|null $branch_code_or_ifsc_shg
 * @property int|null $master_partner_bank_id
 * @property int $bc_copy_file_count
 * @property int|null $created_by
 * @property int|null $created_at
 * @property int|null $updated_by
 * @property int|null $updated_at
 * @property int $status
 * @property int|null $parent_id
 * @property int|null $action_type
 */
class CboMemberProfileHistory extends \common\models\dynamicdb\cbo\CboactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cbo_member_profile_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'first_name'], 'required'],
            [['user_id', 'folder_prefix', 'gender', 'primary_phone_no_verified', 'alternate_phone_no_verified', 'whatsapp_no_verified', 'email_id_verified', 'bc', 'samuh_sakhi', 'wada_sakhi', 'accountant', 'shg', 'vo', 'clf', 'age', 'cast', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'marital_status', 'srlm_bc_application_id', 'srlm_bc_selection_user_id', 'bank_id', 'bank_id_shg', 'master_partner_bank_id', 'bc_copy_file_count', 'created_by', 'created_at', 'updated_by', 'updated_at', 'status', 'parent_id', 'action_type'], 'integer'],
            [['date_of_birth', 'primary_phone_no_verified_date', 'alternate_phone_no_verified_date', 'whatsapp_no_verified_date', 'email_id_verified_date', 'date_of_opening_the_bank_account'], 'safe'],
            [['first_name', 'middle_name', 'sur_name', 'hamlet', 'guardian_name', 'name_of_bank', 'branch', 'cin', 'name_of_bank_shg', 'branch_shg'], 'string', 'max' => 150],
            [['primary_phone_no', 'alternate_phone_no', 'whatsapp_no'], 'string', 'max' => 10],
            [['email_id', 'photo_aadhaar_front', 'photo_aadhaar_back'], 'string', 'max' => 255],
            [['aadhaar_number'], 'string', 'max' => 12],
            [['division_name', 'district_name', 'block_name', 'gram_panchayat_name', 'village_name'], 'string', 'max' => 100],
            [['otp_mobile_no'], 'string', 'max' => 15],
            [['bank_account_no', 'branch_code_or_ifsc', 'bank_account_no_of_the_shg'], 'string', 'max' => 25],
            [['iibf_membership_no'], 'string', 'max' => 50],
            [['profile_photo', 'passbook_photo', 'pan_photo', 'iibf_photo_file_name', 'pvr_upload_file_name', 'bc_handheld_machine_photo', 'passbook_photo_shg'], 'string', 'max' => 500],
            [['branch_code_or_ifsc_shg'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'folder_prefix' => 'Folder Prefix',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'sur_name' => 'Sur Name',
            'gender' => 'Gender',
            'date_of_birth' => 'Date Of Birth',
            'primary_phone_no' => 'Primary Phone No',
            'primary_phone_no_verified' => 'Primary Phone No Verified',
            'primary_phone_no_verified_date' => 'Primary Phone No Verified Date',
            'alternate_phone_no' => 'Alternate Phone No',
            'alternate_phone_no_verified' => 'Alternate Phone No Verified',
            'alternate_phone_no_verified_date' => 'Alternate Phone No Verified Date',
            'whatsapp_no' => 'Whatsapp No',
            'whatsapp_no_verified' => 'Whatsapp No Verified',
            'whatsapp_no_verified_date' => 'Whatsapp No Verified Date',
            'email_id' => 'Email ID',
            'email_id_verified' => 'Email Id Verified',
            'email_id_verified_date' => 'Email Id Verified Date',
            'aadhaar_number' => 'Aadhaar Number',
            'bc' => 'Bc',
            'samuh_sakhi' => 'Samuh Sakhi',
            'wada_sakhi' => 'Wada Sakhi',
            'accountant' => 'Accountant',
            'shg' => 'Shg',
            'vo' => 'Vo',
            'clf' => 'Clf',
            'age' => 'Age',
            'cast' => 'Cast',
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
            'hamlet' => 'Hamlet',
            'guardian_name' => 'Guardian Name',
            'otp_mobile_no' => 'Otp Mobile No',
            'marital_status' => 'Marital Status',
            'srlm_bc_application_id' => 'Srlm Bc Application ID',
            'srlm_bc_selection_user_id' => 'Srlm Bc Selection User ID',
            'bank_account_no' => 'Bank Account No',
            'bank_id' => 'Bank ID',
            'name_of_bank' => 'Name Of Bank',
            'branch' => 'Branch',
            'branch_code_or_ifsc' => 'Branch Code Or Ifsc',
            'date_of_opening_the_bank_account' => 'Date Of Opening The Bank Account',
            'cin' => 'Cin',
            'iibf_membership_no' => 'Iibf Membership No',
            'profile_photo' => 'Profile Photo',
            'photo_aadhaar_front' => 'Photo Aadhaar Front',
            'photo_aadhaar_back' => 'Photo Aadhaar Back',
            'passbook_photo' => 'Passbook Photo',
            'pan_photo' => 'Pan Photo',
            'iibf_photo_file_name' => 'Iibf Photo File Name',
            'pvr_upload_file_name' => 'Pvr Upload File Name',
            'bc_handheld_machine_photo' => 'Bc Handheld Machine Photo',
            'passbook_photo_shg' => 'Passbook Photo Shg',
            'bank_account_no_of_the_shg' => 'Bank Account No Of The Shg',
            'bank_id_shg' => 'Bank Id Shg',
            'name_of_bank_shg' => 'Name Of Bank Shg',
            'branch_shg' => 'Branch Shg',
            'branch_code_or_ifsc_shg' => 'Branch Code Or Ifsc Shg',
            'master_partner_bank_id' => 'Master Partner Bank ID',
            'bc_copy_file_count' => 'Bc Copy File Count',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'parent_id' => 'Parent ID',
            'action_type' => 'Action Type',
        ];
    }
}
