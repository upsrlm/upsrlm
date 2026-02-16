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
 * Bank194ProfileForm is the model behind the UserProfile
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class Bank194ProfileForm extends Model {

    public $id;
    public $user_id;
    public $bank_name;
    public $first_name;
    public $middle_name;
    public $sur_name;
    public $designation;
    public $primary_phone_no;
    public $alternate_phone_no;
    public $whatsapp_no;
    public $email_id;
    public $name_of_organization;
    public $place_of_posting;
    public $employee_code_id;
    public $bank_name_of_reporting_officer;
    public $bank_mobile_no_reporting_officer;
    public $bank_whatsapp_no_reporting_officer;
    public $bank_email_reporting_officer;
    public $bank_photoid1;
    public $bank_photoid2;
    public $is_profile_complete;
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
            $this->bank_name = $this->profle_model->bank_name;
            $this->place_of_posting = $this->profle_model->place_of_posting;
            $this->employee_code_id = $this->profle_model->employee_code_id;
            $this->bank_photoid1 = $this->profle_model->bank_photoid1;
            $this->bank_photoid2 = $this->profle_model->bank_photoid2;
            $this->bank_name_of_reporting_officer = $this->profle_model->bank_name_of_reporting_officer;
            $this->bank_mobile_no_reporting_officer = $this->profle_model->bank_mobile_no_reporting_officer;
            $this->bank_whatsapp_no_reporting_officer = $this->profle_model->bank_whatsapp_no_reporting_officer;
            $this->bank_email_reporting_officer = $this->profle_model->bank_email_reporting_officer;
        } else {
            $this->profle_model = new UserProfile();
            $this->profle_model->user_id = \Yii::$app->user->identity->id;
            $this->user_id = $this->user_model->id;
            $this->primary_phone_no = $this->user_model->username;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id','bank_name', 'first_name','employee_code_id', 'designation', 'primary_phone_no', 'designation', 'email_id', 'place_of_posting', 'whatsapp_no'], 'required'],
            [['first_name','bank_name','employee_code_id', 'designation', 'primary_phone_no', 'designation', 'email_id', 'place_of_posting'], 'trim'],
            [['bank_mobile_no_reporting_officer', 'bank_name_of_reporting_officer', 'bank_email_reporting_officer', 'bank_whatsapp_no_reporting_officer'], 'required'],
            [['bank_mobile_no_reporting_officer', 'bank_name_of_reporting_officer', 'bank_email_reporting_officer', 'bank_whatsapp_no_reporting_officer'], 'trim'],
            [['user_id', 'is_profile_complete', 'status'], 'integer'],
            [['first_name', 'middle_name', 'sur_name'], 'string', 'max' => 150],
            [['email_id'], 'string', 'max' => 255],
            [['designation',], 'string', 'max' => 100],
            [['place_of_posting'], 'string', 'max' => 255],
            [['bank_email_reporting_officer'], 'email'],
            [['primary_phone_no', 'alternate_phone_no', 'whatsapp_no'], \common\validators\MobileValidator::className(), 'message' => 'In valid {attribute}.'],
            [['bank_mobile_no_reporting_officer', 'bank_whatsapp_no_reporting_officer', 'whatsapp_no'], \common\validators\MobileValidator::className(), 'message' => 'In valid {attribute}.'],
           
            [['bank_name', 'first_name','bank_name_of_reporting_officer'], 'string', 'min' => 3],
            [['primary_phone_no'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->user_model->username != $model->$attribute;
                }, 'targetClass' => User::className(), 'message' => 'This login has already been taken', 'targetAttribute' => 'username'],
            [['email_id'], 'unique', 'when' => function ($model, $attribute) {
                    return $this->user_model->email != $model->$attribute;
                }, 'targetClass' => User::className(), 'message' => 'This email has already been taken', 'targetAttribute' => 'email'],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'first_name' => 'Name of nodal officer/user',
            'middle_name' => 'Middle Name',
            'sur_name' => 'Surname',
            'designation' => 'Designation',
            'primary_phone_no' => 'Please put your mobile number. Now on, your mobile number will be your login id',
            'alternate_phone_no' => 'Alternate Mobile No',
            'whatsapp_no' => 'Whatsapp No',
            'email_id' => 'Email ID',    
            'bank_name' => 'Please indicate name of your Bank',
            'place_of_posting' => 'Place of posting',
            'employee_code_id' => 'Employee code/ id no.',
            'bank_photoid1' => 'Please upload your photo id',
            'bank_photoid2' => 'Please upload your photo id',
            'bank_name_of_reporting_officer' => 'Name of your reporting officer',
            'bank_mobile_no_reporting_officer' => 'Mobile no. of reporting officer',
            'bank_whatsapp_no_reporting_officer' => 'WhatsApp no. of reporting officer',
            'bank_email_reporting_officer' => 'Email id: of reporting officer',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
