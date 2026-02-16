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
class RSETHIs_ProfileForm extends Model {

    public $id;
    public $user_id;
    public $first_name;
    public $middle_name;
    public $sur_name;
    public $designation;
    public $posting_district_code;
    public $posting_district_name;
    public $primary_phone_no;
    public $alternate_phone_no;
    public $whatsapp_no;
    public $email_id;
    public $bank_name;
    public $is_profile_complete;
    public $office_address;
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
            $this->bank_name = $this->profle_model->bank_name;
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
            [['user_id', 'first_name', 'designation', 'primary_phone_no', 'designation', 'email_id', 'posting_district_code', 'office_address'], 'required'],
            [['user_id', 'posting_district_code', 'is_profile_complete', 'status'], 'integer'],
            [['first_name', 'middle_name', 'sur_name'], 'string', 'max' => 150],
            [['email_id'], 'string', 'max' => 255],
            [['designation', 'posting_district_name'], 'string', 'max' => 100],
            [['office_address'], 'string', 'max' => 255],
            [['bank_name'], 'string', 'max' => 100],
            [['bank_name'], 'required'],
            [['bank_name'], 'trim'],
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
            'bank_name' => 'Bank name',
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
