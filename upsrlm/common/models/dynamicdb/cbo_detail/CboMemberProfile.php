<?php

namespace common\models\dynamicdb\cbo_detail;

use Yii;

/**
 * This is the model class for table "cbo_member_profile".
 *
 * @property int $id
 * @property int $user_id
 * @property int $folder_prefix
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
 * @property int $bc
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
 * @property string|null $aadhaar_number
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
 * @property int $com_icrp
 * @property int $com_krishi_sakhi
 * @property int $com_icrp_fnhw
 * @property int $com_samooh_sakhi
 * @property int $com_ss_sakhi
 * @property int $com_bank_sakhi
 * @property int $com_vidyut_sakhi
 * @property int $com_vo_book_keeper
 * @property int $com_sr_icrp_vo
 * @property int $com_pds_shop_sanchalika
 * @property int $com_iprp
 * @property int $com_fl_crp
 * @property int $com_clf_book_keeper
 * @property int $com_ajeevika_sakhi
 * @property int $com_udyog_sakhi
 * @property int $com_women_associated_with_thr
 * @property int $com_icrp_clf
 * @property int $com_brp
 * @property int $com_pashu_sakshi
 * @property int $com_crp_ep
 * @property int $bc_operational
 */
class CboMemberProfile extends CboDetailactiveRecord {

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'cbo_member_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'first_name'], 'required'],
            [['first_name', 'middle_name', 'sur_name'], 'trim'],
            [['user_id', 'gender', 'primary_phone_no_verified', 'alternate_phone_no_verified', 'whatsapp_no_verified', 'email_id_verified', 'bc', 'age', 'cast', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'marital_status', 'srlm_bc_application_id', 'srlm_bc_selection_user_id', 'bank_id', 'created_by', 'created_at', 'updated_by', 'updated_at', 'status'], 'integer'],
            [['date_of_birth', 'primary_phone_no_verified_date', 'alternate_phone_no_verified_date', 'whatsapp_no_verified_date', 'email_id_verified_date', 'date_of_opening_the_bank_account'], 'safe'],
            [['first_name', 'middle_name', 'sur_name', 'hamlet', 'name_of_bank', 'branch', 'cin'], 'string', 'max' => 150],
            [['primary_phone_no', 'alternate_phone_no', 'whatsapp_no'], 'string', 'max' => 10],
            [['email_id', 'photo_aadhaar_front', 'photo_aadhaar_back', 'guardian_name'], 'string', 'max' => 255],
            [['aadhaar_number'], 'string', 'max' => 12],
            [['district_name', 'block_name', 'gram_panchayat_name', 'village_name', 'division_name'], 'string', 'max' => 100],
            [['bank_account_no', 'branch_code_or_ifsc'], 'string', 'max' => 25],
            [['otp_mobile_no'], 'string', 'max' => 15],
            [['profile_photo', 'pvr_upload_file_name', 'iibf_photo_file_name', 'passbook_photo'], 'string', 'max' => 500],
            [['user_id'], 'unique'],
            ['bc', 'default', 'value' => 0],
            ['shg', 'default', 'value' => 0],
            ['vo', 'default', 'value' => 0],
            ['clf', 'default', 'value' => 0],
            [['bank_id_shg'], 'integer'],
            [['bank_account_no_of_the_shg'], 'string', 'max' => 25],
            [['name_of_bank_shg', 'branch_shg'], 'string', 'max' => 150],
            [['branch_code_or_ifsc_shg'], 'string', 'max' => 20],
            [['master_partner_bank_id'], 'integer'],
            [['bc_copy_file_count'], 'integer'],
            [['folder_prefix'], 'integer'],
            ['com_icrp', 'default', 'value' => 0],
            ['com_krishi_sakhi', 'default', 'value' => 0],
            ['com_icrp_fnhw', 'default', 'value' => 0],
            ['com_samooh_sakhi', 'default', 'value' => 0],
            ['com_ss_sakhi', 'default', 'value' => 0],
            ['com_bank_sakhi', 'default', 'value' => 0],
            ['com_vidyut_sakhi', 'default', 'value' => 0],
            ['com_vo_book_keeper', 'default', 'value' => 0],
            ['com_sr_icrp_vo', 'default', 'value' => 0],
            ['com_pds_shop_sanchalika', 'default', 'value' => 0],
            ['com_iprp', 'default', 'value' => 0],
            ['com_fl_crp', 'default', 'value' => 0],
            ['com_clf_book_keeper', 'default', 'value' => 0],
            ['com_ajeevika_sakhi', 'default', 'value' => 0],
            ['com_udyog_sakhi', 'default', 'value' => 0],
            ['com_women_associated_with_thr', 'default', 'value' => 0],
            ['com_icrp_clf', 'default', 'value' => 0],
            ['com_brp', 'default', 'value' => 0],
            ['com_pashu_sakshi', 'default', 'value' => 0],
            ['com_crp_ep', 'default', 'value' => 0],
            [['bc_operational'], 'integer'],
            ['bc_operational', 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
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
            'photo_aadhaar_front' => 'Photo Aadhaar Front',
            'photo_aadhaar_back' => 'Photo Aadhaar Back',
            'bc' => 'Bc',
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
            'profile_photo' => 'Profile Photo',
            'pvr_upload_file_name' => 'Pvr Upload File Name',
            'iibf_photo_file_name' => 'Iibf Photo File Name',
            'srlm_bc_application_id' => 'Srlm Bc Application ID',
            'srlm_bc_selection_user_id' => 'Srlm Bc Selection User ID',
            'bank_account_no' => 'Bank Account No',
            'bank_id' => 'Bank ID',
            'name_of_bank' => 'Name Of Bank',
            'branch' => 'Branch',
            'branch_code_or_ifsc' => 'Branch Code Or Ifsc',
            'date_of_opening_the_bank_account' => 'Date Of Opening The Bank Account',
            'cin' => 'Cin',
            'passbook_photo' => 'Passbook Photo',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'com_icrp' => 'ICRP',
            'com_krishi_sakhi' => 'KRISHI SAKHI ',
            'com_icrp_fnhw' => 'ICRP-FNHW',
            'com_samooh_sakhi' => 'SAMOOH SAKHI',
            'com_ss_sakhi' => 'SAMUDAYIK SAUCHALAY SAKHI',
            'com_bank_sakhi' => 'BANK SAKHI',
            'com_vidyut_sakhi' => 'VIDYUT SAKHI',
            'com_vo_book_keeper' => 'VO BOOK KEEPER ',
            'com_sr_icrp_vo' => 'SR. ICRP (VO)',
            'com_pds_shop_sanchalika' => 'PDS SHOP SANCHALIKA',
            'com_iprp' => 'IPRP',
            'com_fl_crp' => 'FL CRP',
            'com_clf_book_keeper' => 'CLF BOOK KEEPER',
            'com_ajeevika_sakhi' => 'AJEEVIKA SAKHI',
            'com_udyog_sakhi' => 'UDYOG SAKHI',
            'com_women_associated_with_thr' => 'WOMEN ASSOCIATED WITH THR ',
            'com_icrp_clf' => ' SR. ICRP (CLF)',
            'com_brp' => 'BRP',
            'com_pashu_sakshi' => 'PASHU SAKSHI',
            'com_crp_ep' => 'CRP-EP',
            'bc_operational' => 'BC Operational',
        ];
    }

    public function getProfile_photo_url() {

        return Yii::$app->params['app_url']['sakhi'] . "/getimage/cbo/user/" . $this->user_id . "/" . $this->profile_photo;
    }

    public function getAadhar_front_photo_url() {

        return Yii::$app->params['app_url']['sakhi'] . "/getimage/cbo/user/" . $this->user_id . "/" . $this->photo_aadhaar_front;
    }

    public function getAadhar_back_photo_url() {

        return Yii::$app->params['app_url']['sakhi'] . "/getimage/cbo/user/" . $this->user_id . "/" . $this->photo_aadhaar_back;
    }

}
