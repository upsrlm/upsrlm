<?php

namespace common\models\form;

use Yii;
use common\models\User;
use common\models\UserProfile;
use common\models\base\GenralModel;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\Expression;

/**
 * UserProfileForm is the model behind the UserProfile
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class UserProfileForm extends Model {

    public $id;
    public $user_id;
    public $first_name;
    public $middle_name;
    public $sur_name;
    public $gender;
    public $date_of_birth;
    public $photo_profile;
    public $present_address_house_no;
    public $present_address_street_mohalla;
    public $present_address_postoffice;
    public $present_address_district;
    public $present_address_district_code;
    public $present_address_state_code;
    public $present_address_state;
    public $present_address_pincode;
    public $permanent_address_same_as_present_address;
    public $permanent_address_house_no;
    public $permanent_address_street_mohalla;
    public $permanent_address_postoffice;
    public $permanent_address_district_code;
    public $permanent_address_district;
    public $permanent_address_state_code;
    public $permanent_address_state;
    public $permanent_address_pincode;
    public $father_name;
    public $designation;
    public $date_of_joining;
    public $photo_letter_of_appointment;
    public $photo_service_agreement;
    public $date_of_last_posting;
    public $photo_letter_of_last_posting_order;
    public $posting_block_code;
    public $posting_block_name;
    public $posting_district_code;
    public $posting_district_name;
    public $primary_phone_no;
    public $primary_phone_no_verified;
    public $primary_phone_no_verified_date;
    public $alternate_phone_no;
    public $alternate_phone_no_verified;
    public $alternate_phone_no_verified_date;
    public $whatsapp_no;
    public $whatsapp_no_verified;
    public $whatsapp_no_verified_date;
    public $email_id;
    public $email_id_verified;
    public $email_id_verified_date;
    public $bank_name;
    public $bank_branch;
    public $bank_account_number;
    public $bank_ifsc_code;
    public $photo_bank_passbook;
    public $pan_number;
    public $photo_pan;
    public $aadhaar_number;
    public $photo_aadhaar_front;
    public $photo_aadhaar_back;
    public $is_profile_complete;
    public $office_address;
    public $name_of_organization;
    public $hq_address;
    public $inst_email;
    public $office_phone_no;
    public $hq_phone_no;
    public $hq_email;
    public $signatory_first_name;
    public $signatory_middle_name;
    public $signatory_sur_name;
    public $signatory_designation;
    public $signatory_primary_phone_no;
    public $signatory_alternate_phone_no;
    public $signatory_whatsapp_no;
    public $signatory_inst_email;
    public $signatory_hq_email;
    public $signatory_office_phone_no;
    public $signatory_hq_phone_no;
    public $signatory_office_address;
    public $signatory_hq_address;
    public $brief_professional_profile;
    public $academic_qualification_awards;
    public $professional_training;
    public $experience;
    public $professional_association;
    public $save_profile;
    public $submit_profile;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
    public $gendr;
    public $comment;
    public $user_model;
    public $profle_model;
    public $state_option = [];
    public $district_option = [];
    public $block_option = [];

    const SCENARIOSAVE = 'scenariousave';
    const SCENARIOSUBMIT = 'scenariosubmit';

    public function __construct($user_id) {
        $this->user_model = User::findOne($user_id);
        $this->block_option = [];
        $this->district_option = GenralModel::district_options($this);
        $this->state_option = GenralModel::state_options($this);
        $this->profle_model = UserProfile::findOne(['user_id' => $user_id]);

        if ($this->profle_model != null) {
            $this->user_id = $this->user_model->id;

            $this->profle_model->user_id = $this->profle_model->user_id;

            $this->first_name = $this->profle_model->first_name;
            $this->middle_name = $this->profle_model->middle_name;
            $this->sur_name = $this->profle_model->sur_name;
            $this->father_name = $this->profle_model->father_name;
            $this->gender = $this->profle_model->gender;
            $this->gendr = $this->profle_model->gendr;
            $this->date_of_birth = $this->profle_model->date_of_birth;
            $this->pan_number = $this->profle_model->pan_number;
            $this->aadhaar_number = $this->profle_model->aadhaar_number;


            $this->primary_phone_no = $this->profle_model->primary_phone_no;
            $this->alternate_phone_no = $this->profle_model->alternate_phone_no;
            $this->whatsapp_no = $this->profle_model->whatsapp_no;
            $this->email_id = $this->profle_model->email_id;

            $this->present_address_house_no = $this->profle_model->present_address_house_no;
            $this->present_address_street_mohalla = $this->profle_model->present_address_street_mohalla;
            $this->present_address_postoffice = $this->profle_model->present_address_postoffice;
            $this->present_address_district = $this->profle_model->present_address_district;
            $this->present_address_state = $this->profle_model->present_address_state;

            $this->permanent_address_house_no = $this->profle_model->permanent_address_house_no;
            $this->permanent_address_street_mohalla = $this->profle_model->permanent_address_street_mohalla;
            $this->permanent_address_postoffice = $this->profle_model->permanent_address_postoffice;
            $this->permanent_address_district = $this->profle_model->permanent_address_district;
            $this->permanent_address_state = $this->profle_model->permanent_address_state;


            $this->designation = $this->profle_model->designation;
            $this->date_of_joining = $this->profle_model->date_of_joining;
            $this->date_of_last_posting = $this->profle_model->date_of_last_posting;
            $this->posting_block_code = $this->profle_model->posting_block_code;
            $this->posting_district_code = $this->profle_model->posting_district_code;
            $this->posting_block_name = $this->profle_model->posting_block_name;
            $this->posting_district_name = $this->profle_model->posting_district_name;

            $this->bank_name = $this->profle_model->bank_name;
            $this->bank_branch = $this->profle_model->bank_branch;
            $this->bank_account_number = $this->profle_model->bank_account_number;
            $this->bank_ifsc_code = $this->profle_model->bank_ifsc_code;


            $array = [];
            if ($this->profle_model->posting_district_code != null) {
                $searchModel = new \common\models\master\MasterBlockSearch();
                $searchModel->district_code = $this->profle_model->posting_district_code;
                $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
                $models = $dataProvider->getModels();
                if ($models != NULL) {
                    foreach ($models as $model) {
                        $array[$model->block_code] = $model->block_name;
                    }
                }
                $this->block_option = $array;
            }

            $this->photo_profile = $this->profle_model->photo_profile;
            $this->photo_aadhaar_front = $this->profle_model->photo_aadhaar_front;
            $this->photo_aadhaar_back = $this->profle_model->photo_aadhaar_back;
            $this->photo_pan = $this->profle_model->photo_pan;
            $this->photo_bank_passbook = $this->profle_model->photo_bank_passbook;
            $this->photo_letter_of_appointment = $this->profle_model->photo_letter_of_appointment;
            $this->photo_letter_of_last_posting_order = $this->profle_model->photo_letter_of_last_posting_order;
            $this->photo_service_agreement = $this->profle_model->photo_service_agreement;
            $this->is_profile_complete = $this->profle_model->is_profile_complete;
            $this->office_address = $this->profle_model->office_address;
            $this->name_of_organization = $this->profle_model->name_of_organization;
            $this->hq_address = $this->profle_model->hq_address;
            $this->inst_email = $this->profle_model->inst_email;
            $this->office_phone_no = $this->profle_model->office_phone_no;
            $this->hq_phone_no = $this->profle_model->hq_phone_no;
            $this->hq_email = $this->profle_model->hq_email;
            $this->office_address = $this->profle_model->office_address;
            $this->signatory_first_name = $this->profle_model->signatory_first_name;
            $this->signatory_middle_name = $this->profle_model->signatory_middle_name;
            $this->signatory_sur_name = $this->profle_model->signatory_sur_name;
            $this->signatory_designation = $this->profle_model->signatory_designation;
            $this->signatory_primary_phone_no = $this->profle_model->signatory_primary_phone_no;
            $this->signatory_alternate_phone_no = $this->profle_model->signatory_alternate_phone_no;
            $this->signatory_whatsapp_no = $this->profle_model->signatory_whatsapp_no;
            $this->signatory_inst_email = $this->profle_model->signatory_inst_email;
            $this->signatory_hq_email = $this->profle_model->signatory_hq_email;
            $this->signatory_office_phone_no = $this->profle_model->signatory_office_phone_no;
            $this->signatory_hq_phone_no = $this->profle_model->signatory_hq_phone_no;
            $this->signatory_office_address = $this->profle_model->signatory_office_address;
            $this->signatory_hq_address = $this->profle_model->signatory_hq_address;
            $this->brief_professional_profile = $this->profle_model->brief_professional_profile;
            $this->academic_qualification_awards = $this->profle_model->academic_qualification_awards;
            $this->professional_training = $this->profle_model->professional_training;
            $this->experience = $this->profle_model->experience;
            $this->professional_association = $this->profle_model->professional_association;
        } else {
            $this->profle_model = new UserProfile();
            $this->profle_model->user_id = \Yii::$app->user->identity->id;
            $this->user_id = $this->user_model->id;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'first_name', 'gender', 'date_of_birth', 'father_name', 'designation', 'primary_phone_no'], 'required'],
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
            [['email_id'], 'email'],
            [['save_profile', 'submit_profile'], 'safe'],
            [['first_name', 'gender', 'date_of_birth', 'father_name', 'designation', 'primary_phone_no'], 'trim'],
            [['present_address_pincode', 'permanent_address_pincode'], \common\validators\PinCodeValidator::className()],
            [['primary_phone_no', 'alternate_phone_no', 'whatsapp_no'], \common\validators\MobileNoValidator::className(), 'message' => 'In valid Mobile Number.'],
            ['pan_number', \common\validators\PanCardValidtor::className(), 'message' => 'In valid pan no.'],
            ['aadhaar_number', \common\validators\AadharValidator::className(), 'message' => 'In valid Aadhar no.'],
            ['bank_account_number', \common\validators\BankAccountNoValidator::className(), 'message' => 'In valid account no.'],
            ['bank_ifsc_code', \common\validators\BankIFSCValidator::className(), 'message' => 'In valid IFSC Code'],
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIOSAVE] = ['save_profile', 'first_name', 'gender', 'date_of_birth', 'father_name'];
        $scenarios[self::SCENARIOSUBMIT] = ['submit_profile', 'first_name', 'gender', 'date_of_birth', 'father_name'];
        return $scenarios;
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
            'is_profile_complete' => 'Is Profile Complete',
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

}
