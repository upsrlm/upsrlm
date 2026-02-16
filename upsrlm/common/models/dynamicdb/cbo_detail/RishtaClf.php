<?php

namespace common\models\dynamicdb\cbo_detail;

use Yii;

/**
 * This is the model class for table "cbo_clf".
 *
 * @property int $id
 * @property int|null $state_code
 * @property string|null $state_name
 * @property int|null $division_code
 * @property string|null $division_name
 * @property int|null $district_code
 * @property string|null $district_name
 * @property int|null $block_code
 * @property string|null $block_name
 * @property string $name_of_clf
 * @property string|null $nrlm_clf_code
 * @property string|null $date_of_formation
 * @property int|null $no_of_vo_connected
 * @property int $no_of_shg_connected
 * @property int|null $no_of_gps_covered
 * @property float|null $funds_received_so_far
 * @property string|null $bank_account_no_of_the_clf
 * @property int $bank_id
 * @property string|null $name_of_bank
 * @property string|null $branch
 * @property string|null $branch_code_or_ifsc
 * @property string|null $date_of_opening_the_bank_account
 * @property string|null $passbook_photo
 * @property float|null $updated_balance_in_bank
 * @property string|null $updated_balance_in_bank_date
 * @property string|null $bank_account_no_of_the_clf2
 * @property int $bank_id2
 * @property string|null $name_of_bank2
 * @property string|null $branch2
 * @property string|null $branch_code_or_ifsc2
 * @property string|null $date_of_opening_the_bank_account2
 * @property string|null $passbook_photo2
 * @property float|null $updated_balance_in_bank2
 * @property string|null $updated_balance_in_bank_date2
 * @property string|null $bank_account_no_of_the_clf3
 * @property int|null $bank_id3
 * @property string|null $name_of_bank3
 * @property string|null $branch3
 * @property string|null $branch_code_or_ifsc3
 * @property string|null $date_of_opening_the_bank_account3
 * @property string|null $passbook_photo3
 * @property float|null $updated_balance_in_bank3
 * @property string|null $updated_balance_in_bank_date3
 * @property int|null $more_bank
 * @property string|null $accountant_name
 * @property string|null $accountant_number
 * @property int|null $is_registered_under
 * @property string|null $reg_no
 * @property string|null $pan_no
 * @property string|null $pan_photo
 * @property string|null $registration_document_photo
 * @property int|null $verify_bank_passbook
 * @property int|null $verify_by
 * @property int $verification_status
 * @property float|null $total_funds_amount
 * @property float|null $start_up_funds_amount
 * @property float|null $cif_funds_amount
 * @property float|null $isf_funds_amount
 * @property float|null $if_funds_amount
 * @property float|null $vo_funds_amount
 * @property float|null $other_funds_amount
 * @property float|null $bank_balance
 * @property string|null $verify_datetime
 * @property string|null $accountant_name
 * @property string|null $accountant_number
 * @property int $edit_bmmu
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property integer $dummy_column
 * @property int $status
 */
class RishtaClf extends CboDetailactiveRecord {

    const STATUS_DELETE = -1;
    const STATUS_SAVE = 1;
    const STATUS_SUBMIT = 2;
    const FUNDS_TYPE_START_UP_ID = 1;
    const FUNDS_TYPE_CIF_ID = 2;
    const FUNDS_TYPE_ISF_ID = 7;
    const FUNDS_TYPE_IF_ID = 8;
    const FUNDS_TYPE_OTHERS_ID = 10;
    const FUNDS_TYPE_VO = 11;

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
        return 'rishta_clf';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name_of_clf', 'no_of_shg_connected'], 'required'],
            [['date_of_formation', 'date_of_opening_the_bank_account'], 'safe'],
            [['state_code', 'division_code', 'district_code', 'block_code', 'no_of_vo_connected', 'no_of_shg_connected', 'no_of_gps_covered', 'bank_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['funds_received_so_far'], 'number'],
            [['state_name'], 'string', 'max' => 100],
            [['division_name'], 'string', 'max' => 150],
            [['district_name'], 'string', 'max' => 150],
            [['passbook_photo', 'passbook_photo2', 'passbook_photo3', 'pan_photo'], 'string', 'max' => 500],
            [['block_name'], 'string', 'max' => 60],
            [['name_of_clf', 'name_of_bank', 'branch', 'name_of_bank2', 'branch2'], 'string', 'max' => 150],
            [['bank_account_no_of_the_clf', 'branch_code_or_ifsc', 'bank_account_no_of_the_clf2', 'branch_code_or_ifsc2'], 'string', 'max' => 25],
            [['nrlm_clf_code'], 'trim'],
            [['updated_balance_in_bank_date', 'updated_balance_in_bank_date2', 'updated_balance_in_bank_date3'], 'safe'],
            [['updated_balance_in_bank', 'updated_balance_in_bank2'], 'number'],
            [['verify_bank_passbook', 'verify_by', 'verification_status'], 'integer'],
            [['verify_datetime'], 'safe'],
            [['passbook_photo2', 'name_of_bank2', 'branch2', 'bank_account_no_of_the_clf2', 'branch_code_or_ifsc2', 'updated_balance_in_bank_date2', 'updated_balance_in_bank2'], 'safe'],
            [['accountant_name', 'accountant_number'], 'safe'],
            [['accountant_name'], 'string', 'max' => 150],
            [['accountant_number'], 'string', 'max' => 15],
            [['total_funds_amount', 'start_up_funds_amount', 'cif_funds_amount', 'isf_funds_amount', 'if_funds_amount', 'other_funds_amount', 'bank_balance'], 'number'],
            [['total_funds_amount', 'start_up_funds_amount', 'cif_funds_amount', 'isf_funds_amount', 'if_funds_amount', 'other_funds_amount', 'bank_balance'], 'default', 'value' => 0],
            ['dummy_column', 'default', 'value' => 0],
            [['bank_account_no_of_the_clf3'], 'string', 'max' => 20],
            [['branch_code_or_ifsc3', 'pan_no'], 'string', 'max' => 25],
            [['name_of_bank3', 'branch3'], 'string', 'max' => 150],
            [['reg_no'], 'string', 'max' => 100],
            [['updated_balance_in_bank3'], 'number'],
            [['date_of_opening_the_bank_account3', 'updated_balance_in_bank_date3'], 'safe'],
            [['bank_id3', 'more_bank', 'is_registered_under'], 'integer'],
            [['bank_account_no_of_the_clf3', 'branch3', 'branch_code_or_ifsc3', 'date_of_opening_the_bank_account3', 'updated_balance_in_bank3', 'updated_balance_in_bank_date3', 'reg_no', 'pan_no'], 'trim'],
            [['edit_bmmu'], 'safe'],
            [['registration_document_photo'], 'safe'],
            ['edit_bmmu', 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'UPSRLM CLF ID',
            'name_of_clf' => 'Name Of CLF',
            'nrlm_clf_code' => 'NRLM CLF Code',
            'date_of_formation' => 'Date Of Formation',
            'no_of_vo_connected' => 'No Of VO Connected',
            'no_of_shg_connected' => 'No Of SHG Connected',
            'no_of_gps_covered' => "No Of GP's Covered",
            'funds_received_so_far' => 'Funds Received So Far',
            'bank_account_no_of_the_clf' => 'Bank Account No Of The CLF',
            'name_of_bank' => 'Name Of Bank',
            'branch' => 'Branch',
            'branch_code_or_ifsc' => 'Branch Code Or Ifsc',
            'date_of_opening_the_bank_account' => 'Date Of Opening The Bank Account',
            'updated_balance_in_bank' => "CLFs' updated balance in Bank",
            'updated_balance_in_bank_date' => "Date of CLFs' updated balance in Bank",
            'passbook_photo' => 'Passbook Photo',
            'bank_account_no_of_the_clf2' => 'Bank Account No Of The Clf2',
            'bank_id2' => 'Bank Id2',
            'name_of_bank2' => 'Name Of Bank2',
            'branch2' => 'Branch2',
            'branch_code_or_ifsc2' => 'Branch Code Or Ifsc2',
            'date_of_opening_the_bank_account2' => 'Date Of Opening The Bank Account2',
            'passbook_photo2' => 'Passbook Photo2',
            'updated_balance_in_bank2' => 'Updated Balance In Bank2',
            'updated_balance_in_bank_date2' => 'Updated Balance In Bank Date2',
            'bank_account_no_of_the_clf3' => 'Bank Account No Of The Clf3',
            'bank_id3' => 'Bank Id3',
            'name_of_bank3' => 'Name Of Bank3',
            'branch3' => 'Branch3',
            'branch_code_or_ifsc3' => 'Branch Code Or Ifsc3',
            'date_of_opening_the_bank_account3' => 'Date Of Opening The Bank Account3',
            'passbook_photo3' => 'Passbook Photo3',
            'updated_balance_in_bank3' => 'Updated Balance In Bank3',
            'updated_balance_in_bank_date3' => 'Updated Balance In Bank Date3',
            'more_bank' => 'More Bank',
            'accountant_name' => 'Accountant Name',
            'accountant_number' => 'Accountant Number',
            'is_registered_under' => 'क्या संकुल/ CLF पंजीकृत है?',
            'reg_no' => 'Reg No',
            'pan_no' => 'Pan No',
            'pan_photo' => 'Pan Photo',
            'verify_bank_passbook' => 'Verify Bank Passbook',
            'verify_datetime' => 'Verify Datetime',
            'verify_by' => 'Verify By',
            'verification_status' => 'Verification Status',
            'total_funds_amount' => 'Total Funds Amount',
            'start_up_funds_amount' => 'Start Up Funds Amount',
            'cif_funds_amount' => 'Cif Funds Amount',
            'isf_funds_amount' => 'Isf Funds Amount',
            'if_funds_amount' => 'If Funds Amount',
            'other_funds_amount' => 'Other Funds Amount',
            'registration_document_photo' => 'पंजीकरण के दस्तावेज की स्कैन कॉपी',
            'bank_balance' => 'Bank Balance',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {

        return parent::beforeSave($insert);
    }

    public function getCboclf() {
        return $this->hasOne(\cbo\models\CboClf::className(), ['id' => 'id']);
    }

    public function getVos() {
        return $this->hasMany(RishtaVo::className(), ['cbo_clf_id' => 'id']);
    }

    public function getClfstatus() {
        $array = [1 => 'Save', 2 => 'Submit'];
        return isset($array[$this->status]) ? $array[$this->status] : '';
    }

    public function getIsregistered() {
        $array = [1 => 'Yes', 0 => 'No'];
        return isset($array[$this->is_registered_under]) ? $array[$this->is_registered_under] : '';
    }

    public function getEntryby() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getPassbookUrl() {

        return Yii::$app->params['app_url']['cbo'] . "/getimage/cbo/clf/" . $this->id . "/" . $this->passbook_photo;
    }

    public function getPassbook2Url() {

        return Yii::$app->params['app_url']['cbo'] . "/getimage/cbo/clf/" . $this->id . "/" . $this->passbook_photo2;
    }

    public function getPanphotoUrl() {

        return Yii::$app->params['app_url']['cbo'] . "/getimage/cbo/clf/" . $this->id . "/" . $this->pan_photo;
    }

    public function getRegistrationdocumentphotoUrl() {

        return Yii::$app->params['app_url']['cbo'] . "/getimage/cbo/clf/" . $this->id . "/" . $this->registration_document_photo;
    }

}
