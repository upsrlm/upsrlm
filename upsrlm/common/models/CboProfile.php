<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cbo_profile".
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string|null $sur_name
 * @property int|null $gender
 * @property string|null $date_of_birth
 * @property string|null $photo_profile
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
 * @property string|null $photo_aadhaar_front
 * @property string|null $photo_aadhaar_back
 * @property int $bc
 * @property int|null $created_by
 * @property int|null $created_at
 * @property int|null $updated_by
 * @property int|null $updated_at
 * @property int $status
 */
class CboProfile extends \yii\db\ActiveRecord {

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
        return 'cbo_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'first_name'], 'required'],
            [['user_id', 'gender', 'primary_phone_no_verified', 'alternate_phone_no_verified', 'whatsapp_no_verified', 'email_id_verified', 'bc', 'created_by', 'created_at', 'updated_by', 'updated_at', 'status'], 'integer'],
            [['date_of_birth', 'primary_phone_no_verified_date', 'alternate_phone_no_verified_date', 'whatsapp_no_verified_date', 'email_id_verified_date'], 'safe'],
            [['first_name', 'middle_name', 'sur_name'], 'string', 'max' => 150],
            [['photo_profile', 'email_id', 'photo_aadhaar_front', 'photo_aadhaar_back'], 'string', 'max' => 255],
            [['primary_phone_no', 'alternate_phone_no', 'whatsapp_no'], 'string', 'max' => 10],
            [['aadhaar_number'], 'string', 'max' => 12],
            [['user_id'], 'unique'],
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
            'photo_profile' => 'Photo Profile',
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
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

}
