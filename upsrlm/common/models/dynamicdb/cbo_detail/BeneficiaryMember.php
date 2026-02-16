<?php

namespace common\models\dynamicdb\cbo_detail;

use Yii;

/**
 * This is the model class for table "dbt_beneficiary_member".
 *
 * @property int $id
 * @property int|null $cbo_shg_id
 * @property int|null $rishta_shg_member_id
 * @property int|null $dbt_beneficiary_household_id
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
 * @property string|null $name
 * @property string|null $mobile
 * @property int|null $user_id
 * @property int|null $role
 * @property int|null $marital_status
 * @property string|null $dob
 * @property int|null $age
 * @property int|null $relation_id
 * @property int|null $locality_id 1=rural,2-urban
 * @property int|null $gender
 * @property int|null $family_head
 * @property string|null $bank_account_no
 * @property int|null $bank_id
 * @property string|null $name_of_bank
 * @property string|null $branch
 * @property string|null $branch_code_or_ifsc
 * @property string|null $passbook_photo
 * @property string|null $aadhar_front_photo
 * @property string|null $aadhar_back_photo
 * @property string|null $voter_id_photo
 * @property string|null $member_photo
 * @property string|null $member_sign_thumb
 * @property string|null $father_name
 * @property int|null $physically_handicapped
 * @property string|null $aadhaar_number
 * @property string|null $voter_id_no
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $created_at
 * @property int|null $updated_by
 * @property int $status
 */
class BeneficiaryMember extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbt_beneficiary_member';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbcbodetail');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cbo_shg_id', 'rishta_shg_member_id', 'dbt_beneficiary_household_id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'user_id', 'role', 'marital_status', 'age', 'relation_id', 'locality_id', 'gender', 'family_head', 'bank_id', 'physically_handicapped', 'created_by', 'updated_at', 'created_at', 'updated_by', 'status'], 'integer'],
            [['dob'], 'safe'],
            [['division_name', 'name', 'name_of_bank', 'branch', 'father_name'], 'string', 'max' => 150],
            [['district_name', 'block_name'], 'string', 'max' => 30],
            [['gram_panchayat_name', 'village_name'], 'string', 'max' => 125],
            [['mobile'], 'string', 'max' => 15],
            [['bank_account_no', 'branch_code_or_ifsc'], 'string', 'max' => 25],
            [['passbook_photo', 'aadhar_front_photo', 'aadhar_back_photo', 'voter_id_photo', 'member_photo', 'member_sign_thumb'], 'string', 'max' => 500],
            [['aadhaar_number', 'voter_id_no'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cbo_shg_id' => 'Cbo Shg ID',
            'rishta_shg_member_id' => 'Rishta Shg Member ID',
            'dbt_beneficiary_household_id' => 'Dbt Beneficiary Household ID',
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
            'name' => 'Name',
            'mobile' => 'Mobile',
            'user_id' => 'User ID',
            'role' => 'Role',
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
            'aadhar_front_photo' => 'Aadhar Front Photo',
            'aadhar_back_photo' => 'Aadhar Back Photo',
            'voter_id_photo' => 'Voter Id Photo',
            'member_photo' => 'Member Photo',
            'member_sign_thumb' => 'Member Sign Thumb',
            'father_name' => 'Father Name',
            'physically_handicapped' => 'Physically Handicapped',
            'aadhaar_number' => 'Aadhaar Number',
            'voter_id_no' => 'Voter Id No',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }
}
