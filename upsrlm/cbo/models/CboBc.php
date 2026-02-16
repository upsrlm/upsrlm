<?php

namespace cbo\models;

use Yii;

/**
 * This is the model class for table "cbo_bc".
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $middle_name
 * @property string|null $sur_name
 * @property int|null $gender
 * @property int|null $age
 * @property int|null $cast
 * @property int|null $division_code
 * @property string|null $division_name
 * @property string|null $district_name
 * @property string|null $block_name
 * @property string|null $gram_panchayat_name
 * @property string|null $village_name
 * @property string|null $hamlet
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property int|null $village_code
 * @property string|null $aadhar_number
 * @property string|null $guardian_name
 * @property int|null $reading_skills
 * @property string|null $mobile_number
 * @property string|null $otp_mobile_no
 * @property int $marital_status
 * @property int|null $already_group_member
 * @property string|null $your_group_name
 * @property string|null $profile_photo
 * @property string|null $aadhar_front_photo
 * @property string|null $aadhar_back_photo
 * @property string|null $pvr_upload_file_name
 * @property string|null $iibf_photo_file_name
 * @property int|null $srlm_bc_application_id
 * @property int|null $srlm_bc_selection_user_id
 * @property int|null $cbo_shg_id
 * @property string|null $bank_account_no_of_the_bc
 * @property int|null $bank_id
 * @property string|null $name_of_bank
 * @property string|null $branch
 * @property string|null $branch_code_or_ifsc
 * @property string|null $date_of_opening_the_bank_account
 * @property string|null $cin
 * @property string|null $passbook_photo
 * @property int $onboarding
 * @property int|null $onboarding_by
 * @property string|null $onboarding_date_time
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class CboBc extends \common\models\dynamicdb\cbo\CboactiveRecord{

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
        return 'cbo_bc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['gender', 'age', 'cast', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'reading_skills', 'marital_status', 'already_group_member', 'srlm_bc_application_id', 'srlm_bc_selection_user_id', 'cbo_shg_id', 'bank_id', 'onboarding', 'onboarding_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['date_of_opening_the_bank_account', 'onboarding_date_time'], 'safe'],
            [['first_name', 'middle_name', 'sur_name', 'district_name', 'block_name', 'gram_panchayat_name', 'village_name', 'hamlet', 'guardian_name'], 'string', 'max' => 100],
            [['division_name'], 'string', 'max' => 50],
            [['aadhar_number'], 'string', 'max' => 30],
            [['mobile_number', 'otp_mobile_no'], 'string', 'max' => 15],
            [['your_group_name'], 'string', 'max' => 255],
            [['profile_photo', 'aadhar_front_photo', 'aadhar_back_photo', 'pvr_upload_file_name', 'iibf_photo_file_name', 'passbook_photo'], 'string', 'max' => 500],
            [['bank_account_no_of_the_bc', 'branch_code_or_ifsc'], 'string', 'max' => 25],
            [['name_of_bank', 'branch', 'cin'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'sur_name' => 'Sur Name',
            'gender' => 'Gender',
            'age' => 'Age',
            'cast' => 'Cast',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_name' => 'District Name',
            'block_name' => 'Block Name',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'village_name' => 'Village Name',
            'hamlet' => 'Hamlet',
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'village_code' => 'Village Code',
            'aadhar_number' => 'Aadhar Number',
            'guardian_name' => 'Guardian Name',
            'reading_skills' => 'Reading Skills',
            'mobile_number' => 'Mobile Number',
            'otp_mobile_no' => 'Otp Mobile No',
            'marital_status' => 'Marital Status',
            'already_group_member' => 'Already Group Member',
            'your_group_name' => 'Your Group Name',
            'profile_photo' => 'Profile Photo',
            'aadhar_front_photo' => 'Aadhar Front Photo',
            'aadhar_back_photo' => 'Aadhar Back Photo',
            'pvr_upload_file_name' => 'Pvr Upload File Name',
            'iibf_photo_file_name' => 'Iibf Photo File Name',
            'srlm_bc_application_id' => 'Srlm Bc Application ID',
            'srlm_bc_selection_user_id' => 'Srlm Bc Selection User ID',
            'cbo_shg_id' => 'Cbo Shg ID',
            'bank_account_no_of_the_bc' => 'Bank Account No Of The Bc',
            'bank_id' => 'Bank ID',
            'name_of_bank' => 'Name Of Bank',
            'branch' => 'Branch',
            'branch_code_or_ifsc' => 'Branch Code Or Ifsc',
            'date_of_opening_the_bank_account' => 'Date Of Opening The Bank Account',
            'cin' => 'Cin',
            'passbook_photo' => 'Passbook Photo',
            'onboarding' => 'Onboarding',
            'onboarding_by' => 'Onboarding By',
            'onboarding_date_time' => 'Onboarding Date Time',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {

        if ($this->date_of_opening_the_bank_account != null and $this->date_of_opening_the_bank_account != '') {
            $this->date_of_opening_the_bank_account = \Yii::$app->formatter->asDatetime($this->date_of_opening_the_bank_account, "php:Y-m-d");
        }
        return parent::beforeSave($insert);
    }

}
