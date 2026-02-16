<?php

namespace common\models\dynamicdb\cbo_detail\dbt\form;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiaryMember;
use common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiaryMasterGender;

/**
 * This is the model class for table "dbt_beneficiary_member".
 *
 * @property int $id
 * @property int|null $cbo_shg_id
 * @property string $name
 * @property string|null $mobile
 * @property int|null $marital_status
 * @property int|null $age
 * @property int|null $caste_category
 * @property int|null $duration_of_membership
 * @property int|null $total_saving
 * @property int|null $loan
 * @property int|null $loan_count
 * @property string|null $loan_amount
 * @property string|null $loan_date
 * @property int|null $mcp_status
 * @property int|null $role
 */

/**
 * @author Aayush Saini <aayushsaini9999@gmail.com>
 */
class DbtBeneficiaryMemberForm extends \yii\base\Model {

    public $id;
    public $cbo_shg_id;
    public $rishta_shg_member_id;
    public $dbt_beneficiary_household_id;
    public $name;
    public $mobile;
    public $marital_status;
    public $dob;
    public $age;
    public $user_id;
    public $dbt_member_model;
    public $family_head;
    public $relation_id;
    public $locality_id;
    public $bank_account_no;
    public $bank_id;
    public $name_of_bank;
    public $branch;
    public $branch_code_or_ifsc;
    public $dbt_beneficiary_member_id;
    public $physically_handicapped;
    public $aadhaar_number;
    public $gender;
    public $gender_option = [];
    public $voter_id_no;
    public $father_name;
    public $member_sign_thumb;
    public $passbook_photo;
    public $aadhar_front_photo;
    public $aadhar_back_photo;
    public $voter_id_photo;
    public $member_photo;
    public $relation_option = [1 => 'स्वयं', 2 => 'पति', 3 => 'पत्नी', 4 => 'पिता', 5 => 'पुत्र', 6 => 'ससुर/ जेठ/ देवर', 99 => 'अन्य'];

    public function __construct($dbt_member_model = null) {
        $this->dbt_member_model = Yii::createObject([
                    'class' => DbtBeneficiaryMember::className()
        ]);

        $this->gender_option = ArrayHelper::map(DbtBeneficiaryMasterGender::find()->where(['status' => 1])->all(), 'id', 'name_hi');
        if ($dbt_member_model != null) {
            $this->dbt_member_model = $dbt_member_model;
            $this->cbo_shg_id = $this->dbt_member_model->cbo_shg_id;
            $this->user_id = $this->dbt_member_model->user_id;
            $this->rishta_shg_member_id = $this->dbt_member_model->rishta_shg_member_id;
            $this->dbt_beneficiary_household_id = $this->dbt_member_model->dbt_beneficiary_household_id;
            $this->name = $this->dbt_member_model->name;
            $this->mobile = $this->dbt_member_model->mobile;
            $this->marital_status = $this->dbt_member_model->marital_status;
            $this->age = $this->dbt_member_model->age;
            $this->dob = $this->dbt_member_model->dob;
            $this->relation_id = $this->dbt_member_model->relation_id;
            $this->bank_account_no = $this->dbt_member_model->bank_account_no;
            $this->bank_id = $this->dbt_member_model->bank_id;
            $this->branch = $this->dbt_member_model->branch;
            $this->branch_code_or_ifsc = $this->dbt_member_model->branch_code_or_ifsc;
            $this->gender = $this->dbt_member_model->gender;
            $this->physically_handicapped = $this->dbt_member_model->physically_handicapped;
            $this->aadhaar_number = $this->dbt_member_model->aadhaar_number;
            $this->voter_id_no = $this->dbt_member_model->voter_id_no;
            $this->father_name = $this->dbt_member_model->father_name;
        }
    }

    public function rules() {
        return [
            [['name', 'marital_status', 'gender'], 'required', 'on' => 'profile', 'message' => "{attribute} खाली नहीं हो सकता."],
            [['cbo_shg_id', 'marital_status', 'dbt_beneficiary_household_id', 'dbt_beneficiary_household_id', 'rishta_shg_member_id', 'dbt_beneficiary_member_id', 'physically_handicapped', 'relation_id'], 'safe'],
            [['gender'], 'safe'],
            ['dob', 'date', 'format' => 'php:Y-m-d', 'max' => date('Y-m-d', strtotime('18 years ago'))],
            ['age', 'integer', 'min' => 0, 'max' => 100],
            [['mobile'], \common\validators\MobileNoValidator::class],
            [['mobile'], 'string', 'max' => 10],
            [['aadhaar_number'], \common\validators\AadharValidator::class],
            [['aadhaar_number'], 'string', 'max' => 12],
            [['voter_id_no'], \common\validators\VoterIDValidator::class],
            [['voter_id_no'], 'string', 'max' => 10],
            ['bank_account_no', \common\validators\BankAccountNoValidator::class],
            ['branch_code_or_ifsc', \common\validators\BankIFSCValidator::class],
            [['name', 'father_name'], 'trim'],
            [['name', 'father_name'], 'string', 'min' => 2, 'max' => 150],
            // [['branch', 'branch_code_or_ifsc', 'bank_id', 'bank_account_no'], 'required', 'message' => "{attribute} खाली नहीं हो सकती।"],
            [['branch'], 'string', 'max' => 150],
            [['branch_code_or_ifsc', 'bank_id'], 'string', 'max' => 25],
            [['bank_account_no'], 'integer'],
            [['bank_account_no'], 'string', 'min' => 9, 'max' => 18],
            [['passbook_photo', 'aadhar_front_photo', 'aadhar_back_photo', 'voter_id_photo', 'member_photo', 'member_sign_thumb'], 'safe'],
            ['scenario', 'safe', 'on' => ['profile', 'bank', 'aadhar', 'vote', 'default']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_shg_id' => 'Cbo Shg ID',
            'name' => 'सदस्यों के नाम',
            'mobile' => 'मोबाइल न0',
            'marital_status' => 'वैवाहिक स्थिति',
            'age' => 'आयु',
            'dob' => 'जन्म तिथि',
            'aadhaar_number' => 'आधार कार्ड नंबर',
            'voter_id_no' => 'मतदाता फ़ोटो पहचान पत्र संख्या ',
            'caste_category' => 'जाति श्रेणी',
            'gender' => 'लिंग',
            'relation_id' => 'परिवार के मुखिया के साथ संबंध',
            'member_photo' => 'वयस्क सदस्य की फ़ोट',
            'passbook_photo' => 'पासबुक फोटो अपलोड करें',
            'aadhar_front_photo' => 'आधार फ्रंट फोटो अपलोड करें',
            'aadhar_back_photo' => 'आधार बैक फोटो अपलोड करें',
            'voter_id_photo' => 'मतदाता पहचान पत्र फोटो अपलोड करें:',
            'member_sign_thumb' => 'मतदाता पहचान पत्र फोटो अपलोड करें:',
        ];
    }

}
