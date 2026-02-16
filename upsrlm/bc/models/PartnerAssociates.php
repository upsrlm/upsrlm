<?php

namespace bc\models;

use Yii;

/**
 * This is the model class for table "partner_associates".
 *
 * @property int $id
 * @property int|null $master_partner_bank_id
 * @property string|null $name_of_the_field_officer
 * @property int|null $gender
 * @property string|null $date_of_birth
 * @property int|null $age
 * @property string|null $photo_profile
 * @property string|null $designation
 * @property string|null $mobile_no
 * @property string|null $alternate_mobile_no
 * @property string|null $whatsapp_no
 * @property string|null $email_id
 * @property string|null $photo_aadhaar_front
 * @property string|null $photo_aadhaar_back
 * @property string|null $company_letter
 * @property string|null $name_of_supervisor
 * @property string|null $designation_of_supervisor
 * @property string|null $mobile_no_of_supervisor
 * @property string|null $bank_name
 * @property string|null $bank_branch
 * @property string|null $bank_ifsc_code
 * @property string|null $bank_account_number
 * @property int|null $created_by
 * @property int|null $created_at
 * @property int|null $updated_by
 * @property int|null $updated_at
 * @property int $status
 */
class PartnerAssociates extends \bc\models\BcactiveRecord {

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
        return 'partner_associates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['master_partner_bank_id', 'gender', 'age', 'created_by', 'created_at', 'updated_by', 'updated_at', 'status'], 'integer'],
            [['date_of_birth'], 'safe'],
            [['name_of_the_field_officer', 'photo_profile', 'email_id', 'photo_aadhaar_front', 'photo_aadhaar_back', 'company_letter', 'name_of_supervisor', 'bank_branch'], 'string', 'max' => 255],
            [['designation', 'designation_of_supervisor', 'bank_name'], 'string', 'max' => 100],
            [['mobile_no', 'alternate_mobile_no'], 'string', 'max' => 12],
            [['whatsapp_no'], 'string', 'max' => 10],
            [['mobile_no_of_supervisor'], 'string', 'max' => 15],
            [['bank_ifsc_code'], 'string', 'max' => 11],
            [['bank_account_number'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'master_partner_bank_id' => 'Partner Bank',
            'name_of_the_field_officer' => 'Name Of The Field Officer',
            'gender' => 'Gender',
            'date_of_birth' => 'Date Of Birth',
            'age' => 'Age',
            'photo_profile' => 'Photo Profile',
            'designation' => 'Designation',
            'mobile_no' => 'Mobile No',
            'alternate_mobile_no' => 'Alternate Mobile No',
            'whatsapp_no' => 'Whatsapp No',
            'email_id' => 'Email ID',
            'photo_aadhaar_front' => 'Photo Aadhaar Front',
            'photo_aadhaar_back' => 'Photo Aadhaar Back',
            'company_letter' => 'Company Letter',
            'name_of_supervisor' => 'Name Of Supervisor',
            'designation_of_supervisor' => 'Designation Of Supervisor',
            'mobile_no_of_supervisor' => 'Mobile No Of Supervisor',
            'bank_name' => 'Bank Name',
            'bank_branch' => 'Bank Branch',
            'bank_ifsc_code' => 'Bank Ifsc Code',
            'bank_account_number' => 'Bank Account Number',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
    public function getPartnerbank() {
        return $this->hasOne(master\MasterPartnerBank::className(), ['id' => 'master_partner_bank_id']);
    }
    public function getDisblock() {
        return $this->hasMany(PartnerAssociatesBlock::className(), ['partner_associates_id' => 'id'])->where(['partner_associates_block.status' => 1]);
    }

    public function getGen() {
        $a = [1 => 'Male', 2 => 'Femail'];
        return isset($a[$this->gender]) ? $a[$this->gender] : '';
    }

    public function getImageUrl($attribute) {
        return \Yii::$app->params['app_url']['hr']."/getimage/partneragencies/associates/" . $this->id . "/" . $this->$attribute;
    }

}
