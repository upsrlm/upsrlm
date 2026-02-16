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
 * RSETHIs_ProfileForm is the model behind the UserProfile
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class Bank_ProfileForm extends Model {

    public $id;
    public $user_id;
    public $first_name;
    public $middle_name;
    public $sur_name;
    public $designation;
    //public $posting_district_code;
    //public $posting_district_name;
    public $primary_phone_no;
    public $alternate_phone_no;
    public $whatsapp_no;
    public $email_id;
    public $is_profile_complete;
    public $name_of_organization;
    public $hq_address;
    public $inst_email;
    public $office_phone_no;
    public $hq_phone_no;
    public $hq_email;
    public $office_address;
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
            [['first_name', 'designation', 'primary_phone_no', 'designation', 'email_id', 'office_address'], 'trim'],
            [['name_of_organization', 'hq_address', 'inst_email', 'office_phone_no', 'hq_phone_no', 'hq_email'], 'required'],
            [['name_of_organization', 'hq_address', 'inst_email', 'office_phone_no', 'hq_phone_no', 'hq_email'], 'trim'],
            [['user_id', 'is_profile_complete', 'status'], 'integer'],
            [['first_name', 'middle_name', 'sur_name'], 'string', 'max' => 150],
            [['email_id'], 'string', 'max' => 255],
            [['designation',], 'string', 'max' => 100],
            [['office_address'], 'string', 'max' => 255],
            [['email_id'], 'email'],
            [['inst_email'], 'email'],
            [['hq_email'], 'email'],
            [['signatory_inst_email'], 'email'],
            [['signatory_hq_email'], 'email'],
            [['first_name', 'middle_name', 'sur_name', 'designation', 'primary_phone_no', 'alternate_phone_no', 'whatsapp_no', 'office_address', 'email_id'], 'trim'],
            [['primary_phone_no', 'alternate_phone_no', 'whatsapp_no'], \common\validators\MobileNoValidator::className(), 'message' => 'In valid {attribute}.'],
            [['signatory_primary_phone_no', 'signatory_alternate_phone_no', 'signatory_whatsapp_no'], \common\validators\MobileNoValidator::className(), 'message' => 'In valid {attribute}.'],
            [['name_of_organization', 'inst_email', 'hq_email'], 'string', 'max' => 255],
            [['hq_address'], 'string', 'max' => 500],
            [['office_phone_no', 'hq_phone_no'], 'string', 'max' => 15],
            [['signatory_first_name', 'signatory_middle_name', 'signatory_sur_name'], 'string', 'max' => 150],
            [['signatory_first_name', 'signatory_designation', 'signatory_primary_phone_no', 'signatory_designation', 'signatory_office_address'], 'required'],
            [['signatory_first_name', 'signatory_designation', 'signatory_primary_phone_no', 'signatory_designation', 'signatory_office_address'], 'trim'],
            [['signatory_hq_address', 'signatory_inst_email', 'signatory_office_phone_no', 'signatory_hq_phone_no', 'signatory_hq_email'], 'required'],
            [['signatory_hq_address', 'signatory_inst_email', 'signatory_office_phone_no', 'signatory_hq_phone_no', 'signatory_hq_email'], 'trim'],
            [['signatory_designation'], 'string', 'max' => 100],
            [['signatory_office_phone_no', 'signatory_hq_phone_no'], 'string', 'max' => 15],
            [['signatory_inst_email', 'signatory_hq_email'], 'string', 'max' => 255],
            [['signatory_office_address', 'signatory_hq_address'], 'string', 'max' => 500],
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
            'primary_phone_no' => 'Mobile No',
            'alternate_phone_no' => 'Alternate Mobile No',
            'whatsapp_no' => 'Whatsapp No',
            'email_id' => 'Email ID',
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
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

}
