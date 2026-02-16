<?php

namespace common\models\dynamicdb\bc;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string|null $sur_name
 * @property int $gender
 * @property string $date_of_birth
 * @property string|null $photo_profile
 * @property string|null $present_address_house_no
 * @property string|null $present_address_street_mohalla
 * @property string|null $present_address_postoffice
 * @property string|null $present_address_district
 * @property int|null $present_address_district_code
 * @property int|null $present_address_state_code
 * @property string|null $present_address_state
 * @property int|null $present_address_pincode
 * @property int $permanent_address_same_as_present_address
 * @property string|null $permanent_address_house_no
 * @property string|null $permanent_address_street_mohalla
 * @property string|null $permanent_address_postoffice
 * @property int|null $permanent_address_district_code
 * @property string|null $permanent_address_district
 * @property int|null $permanent_address_state_code
 * @property string|null $permanent_address_state
 * @property int|null $permanent_address_pincode
 * @property string $father_name
 * @property string $designation
 * @property string|null $date_of_joining
 * @property string|null $photo_letter_of_appointment
 * @property string|null $photo_service_agreement
 * @property string|null $date_of_last_posting
 * @property string|null $photo_letter_of_last_posting_order
 * @property int|null $posting_block_code
 * @property string|null $posting_block_name
 * @property int|null $posting_district_code
 * @property string|null $posting_district_name
 * @property string $primary_phone_no
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
 * @property string|null $bank_name
 * @property string|null $bank_branch
 * @property string|null $bank_account_number
 * @property string|null $bank_ifsc_code
 * @property string|null $photo_bank_passbook
 * @property string|null $pan_number
 * @property string|null $photo_pan
 * @property string|null $aadhaar_number
 * @property string|null $photo_aadhaar_front
 * @property string|null $photo_aadhaar_back
 * @property string|null $name_of_organization
 * @property string|null $hq_address
 * @property string|null $inst_email
 * @property string|null $office_phone_no
 * @property string|null $hq_phone_no
 * @property string|null $hq_email
 * @property string|null $signatory_first_name
 * @property string|null $signatory_middle_name
 * @property string|null $signatory_sur_name
 * @property string|null $signatory_designation
 * @property string|null $signatory_primary_phone_no
 * @property string|null $signatory_alternate_phone_no
 * @property string|null $signatory_whatsapp_no
 * @property string|null $signatory_inst_email
 * @property string|null $signatory_hq_email
 * @property string|null $signatory_office_phone_no
 * @property string|null $signatory_hq_phone_no
 * @property string|null $signatory_office_address
 * @property string|null $signatory_hq_address
 * @property string|null $brief_professional_profile
 * @property string|null $academic_qualification_awards
 * @property string|null $professional_training
 * @property string|null $experience
 * @property string|null $professional_association
 * @property int $is_profile_complete
 * @property string|null $office_address
 * @property int|null $created_by
 * @property int|null $created_at
 * @property int|null $updated_by
 * @property int|null $updated_at
 * @property int $status
 */
class UserProfile extends BcactiveRecord {

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function() {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            //[['user_id', 'first_name', 'gender', 'date_of_birth', 'father_name', 'designation', 'primary_phone_no'], 'required'],
            [['user_id'], 'required'],
            [['user_id', 'gender', 'present_address_district_code', 'present_address_state_code', 'present_address_pincode', 'permanent_address_same_as_present_address', 'permanent_address_district_code', 'permanent_address_state_code', 'permanent_address_pincode', 'posting_block_code', 'posting_district_code', 'primary_phone_no_verified', 'alternate_phone_no_verified', 'whatsapp_no_verified', 'email_id_verified', 'is_profile_complete', 'created_by', 'created_at', 'updated_by', 'updated_at', 'status'], 'integer'],
            [['date_of_birth', 'date_of_joining', 'date_of_last_posting', 'primary_phone_no_verified_date', 'alternate_phone_no_verified_date', 'whatsapp_no_verified_date', 'email_id_verified_date'], 'safe'],
            [['first_name', 'middle_name', 'sur_name', 'present_address_street_mohalla', 'present_address_postoffice', 'permanent_address_street_mohalla', 'permanent_address_postoffice'], 'string', 'max' => 150],
            [['photo_profile', 'photo_letter_of_appointment', 'photo_service_agreement', 'photo_letter_of_last_posting_order', 'email_id', 'bank_branch', 'photo_bank_passbook', 'photo_pan', 'photo_aadhaar_front', 'photo_aadhaar_back'], 'string', 'max' => 255],
            [['present_address_house_no', 'permanent_address_house_no'], 'string', 'max' => 50],
            [['present_address_district', 'present_address_state', 'permanent_address_district', 'permanent_address_state', 'father_name', 'designation', 'posting_block_name', 'posting_district_name', 'bank_name'], 'string', 'max' => 100],
            [['primary_phone_no', 'alternate_phone_no', 'whatsapp_no', 'pan_number'], 'string', 'max' => 10],
            [['bank_account_number'], 'string', 'max' => 20],
            [['bank_ifsc_code'], 'string', 'max' => 11],
            [['aadhaar_number'], 'string', 'max' => 12],
            [['office_address'], 'string', 'max' => 500],
            [['office_address'], 'trim'],
            [['user_id'], 'unique'],
            [['name_of_organization', 'inst_email', 'hq_email'], 'string', 'max' => 255],
            [['hq_address'], 'string', 'max' => 500],
            [['office_phone_no', 'hq_phone_no'], 'string', 'max' => 15],
            [['signatory_first_name', 'signatory_middle_name', 'signatory_sur_name'], 'string', 'max' => 150],
            [['signatory_designation'], 'string', 'max' => 100],
            [['signatory_primary_phone_no', 'signatory_alternate_phone_no', 'signatory_whatsapp_no', 'signatory_office_phone_no', 'signatory_hq_phone_no'], 'string', 'max' => 15],
            [['signatory_inst_email', 'signatory_hq_email'], 'string', 'max' => 255],
            [['signatory_office_address', 'signatory_hq_address'], 'string', 'max' => 500],
            [['brief_professional_profile', 'academic_qualification_awards', 'professional_training', 'experience', 'professional_association'], 'string', 'max' => 1000],
            [['first_name'], 'default','value'=>''],
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
            'sur_name' => 'Surname',
            'gender' => 'Gender',
            'date_of_birth' => 'Date Of Birth',
            'photo_profile' => 'Photo Profile',
            'present_address_house_no' => 'Present Address House No',
            'present_address_street_mohalla' => 'Present Address Street Mohalla',
            'present_address_postoffice' => 'Present Address Postoffice',
            'present_address_district' => 'Present Address District',
            'present_address_district_code' => 'Present Address District Code',
            'present_address_state_code' => 'Present Address State Code',
            'present_address_state' => 'Present Address State',
            'present_address_pincode' => 'Present Address Pincode',
            'permanent_address_same_as_present_address' => 'Permanent Address Same As Present Address',
            'permanent_address_house_no' => 'Permanent Address House No',
            'permanent_address_street_mohalla' => 'Permanent Address Street Mohalla',
            'permanent_address_postoffice' => 'Permanent Address Postoffice',
            'permanent_address_district_code' => 'Permanent Address District Code',
            'permanent_address_district' => 'Permanent Address District',
            'permanent_address_state_code' => 'Permanent Address State Code',
            'permanent_address_state' => 'Permanent Address State',
            'permanent_address_pincode' => 'Permanent Address Pincode',
            'father_name' => 'Father Name',
            'designation' => 'Designation',
            'date_of_joining' => 'Date Of Joining',
            'photo_letter_of_appointment' => 'Photo Letter Of Appointment',
            'date_of_last_posting' => 'Date Of Last Posting',
            'photo_letter_of_last_posting_order' => 'Photo Letter Of Last Posting Order',
            'posting_block_code' => 'Posting Block Code',
            'posting_block_name' => 'Posting Block Name',
            'posting_district_code' => 'Posting District Code',
            'posting_district_name' => 'Posting District Name',
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
            'bank_name' => 'Bank Name',
            'bank_branch' => 'Bank Branch',
            'bank_account_number' => 'Bank Account Number',
            'bank_ifsc_code' => 'Bank Ifsc Code',
            'photo_bank_passbook' => 'Photo Bank Passbook',
            'pan_number' => 'Pan Number',
            'photo_pan' => 'Photo Pan',
            'aadhaar_number' => 'Aadhaar Number',
            'photo_aadhaar_front' => 'Photo Aadhaar Front',
            'photo_aadhaar_back' => 'Photo Aadhaar Back',
            'name_of_organization' => 'Name Of Organization',
            'hq_address' => 'HQ Address',
            'inst_email' => 'Inst Email',
            'office_phone_no' => 'Office Phone No',
            'hq_phone_no' => 'HQ Phone No',
            'hq_email' => 'HQ Email',
            'is_profile_complete' => 'Is Profile Complete',
            'office_address' => 'Office address',
            'name_of_organization' => 'Name Of Organization',
            'hq_address' => 'HQ Address',
            'inst_email' => 'Inst Email',
            'office_phone_no' => 'Office Phone No',
            'hq_phone_no' => 'HQ Phone No',
            'hq_email' => 'HQ Email',
            'signatory_first_name' => 'First Name',
            'signatory_middle_name' => 'Middle Name',
            'signatory_sur_name' => 'Surname',
            'signatory_designation' => 'Designation',
            'signatory_primary_phone_no' => 'Mobile No',
            'signatory_alternate_phone_no' => 'Alternate Mobile No',
            'signatory_whatsapp_no' => 'Whatsapp No',
            'signatory_inst_email' => 'Inst Email',
            'signatory_hq_email' => 'HQ Email',
            'signatory_office_phone_no' => 'Office Phone No',
            'signatory_hq_phone_no' => 'HQ Phone No',
            'signatory_office_address' => 'Office Address',
            'signatory_hq_address' => 'HQ Address',
            'brief_professional_profile' => 'Brief Professional Profile',
            'academic_qualification_awards' => 'Academic Qualification / Awards',
            'professional_training' => 'Professional Training',
            'experience' => 'Experience',
            'professional_association' => 'Professional Association',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function chcekProfileStatus() {
        if ($this->first_name == "" || $this->middle_name == "" || $this->sur_name == "" || $this->father_name == "" || $this->gender == "" || $this->gender == "0" || $this->date_of_birth == "" || $this->date_of_birth == null || $this->aadhaar_number == "" || $this->pan_number == "")
            return false;

        if ($this->photo_profile == "" || $this->photo_aadhaar_front == "" || $this->photo_aadhaar_back == "" || $this->photo_pan == "")
            return false;

        if ($this->primary_phone_no == "" || $this->alternate_phone_no == "" || $this->whatsapp_no == "" || $this->email_id == "")
            return false;

        if ($this->permanent_address_house_no == "" || $this->permanent_address_street_mohalla == "" || $this->permanent_address_postoffice == "" || $this->permanent_address_district == "" || $this->permanent_address_state == "")
            return false;

        if ($this->permanent_address_house_no == "" || $this->permanent_address_street_mohalla == "" || $this->permanent_address_postoffice == "" || $this->permanent_address_district == "" || $this->permanent_address_state == "")
            return false;

        if ($this->designation == "" || $this->photo_letter_of_appointment == "" || $this->photo_service_agreement == "" || $this->posting_district_code == "" || $this->posting_block_code == "" || $this->date_of_last_posting == "" || $this->photo_letter_of_last_posting_order == "")
            return false;

        if ($this->bank_name == "" || $this->bank_branch == "" || $this->bank_account_number == "" || $this->bank_ifsc_code == "" || $this->photo_bank_passbook == "")
            return false;

        return true;
    }

    public function getImageUrl($attribute) {

        return Yii::$app->params['baseurl_profile_image'] . "/getimage/user_profile/" . $this->user_id . "/" . $this->$attribute;
    }

    public function beforeSave($insert) {

        if ($this->date_of_birth != null and $this->date_of_birth != '') {
            $this->date_of_birth = \Yii::$app->formatter->asDatetime($this->date_of_birth, "php:Y-m-d");
        }
        if ($this->date_of_joining != null and $this->date_of_joining != '') {
            $this->date_of_joining = \Yii::$app->formatter->asDatetime($this->date_of_joining, "php:Y-m-d");
        }
        if ($this->date_of_last_posting != null and $this->date_of_last_posting != '') {
            $this->date_of_last_posting = \Yii::$app->formatter->asDatetime($this->date_of_last_posting, "php:Y-m-d");
        }
        return parent::beforeSave($insert);
    }

}
