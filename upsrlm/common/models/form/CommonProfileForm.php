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
 * CommonProfileForm is the model behind the UserProfile
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class CommonProfileForm extends Model {

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
    public $save_profile;
    public $submit_profile;
    public $created_at;
    public $created_by;
    public $updated_at;
    public $updated_by;
    public $status;
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
            $this->primary_phone_no = $this->profle_model->primary_phone_no;
            $this->alternate_phone_no = $this->profle_model->alternate_phone_no;
            $this->whatsapp_no = $this->profle_model->whatsapp_no;
            $this->email_id = $this->profle_model->email_id;
            $this->designation = $this->profle_model->designation;
            $this->posting_district_code = $this->profle_model->posting_district_code;
            $this->posting_district_name = $this->profle_model->posting_district_name;
            $this->office_address = $this->profle_model->office_address;
            $this->is_profile_complete = $this->profle_model->is_profile_complete;
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
            [['user_id', 'first_name', 'designation', 'primary_phone_no', 'designation', 'email_id', 'office_address'], 'required'],
            [['user_id', 'posting_district_code', 'is_profile_complete', 'status'], 'integer'],
            [['first_name', 'middle_name', 'sur_name'], 'string', 'max' => 150],
            [['email_id'], 'string', 'max' => 255],
            [['designation', 'posting_district_name'], 'string', 'max' => 100],
            [['office_address'], 'string', 'max' => 255],
            [['email_id'], 'email'],
            [['first_name', 'middle_name', 'sur_name', 'designation', 'primary_phone_no', 'alternate_phone_no', 'whatsapp_no', 'office_address', 'email_id'], 'trim'],
            [['primary_phone_no', 'alternate_phone_no', 'whatsapp_no'], \common\validators\MobileNoValidator::className(), 'message' => 'In valid Mobile Number.'],
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
            'designation' => 'Designation',
            'posting_district_code' => 'Posting District Code',
            'posting_district_name' => 'Posting District Name',
            'primary_phone_no' => 'Mobile No',
            'alternate_phone_no' => 'Alternate Mobile No',
            'whatsapp_no' => 'Whatsapp No',
            'email_id' => 'Email ID',
            'is_profile_complete' => 'Is Profile Complete',
            'office_address' => 'Office address',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

}
