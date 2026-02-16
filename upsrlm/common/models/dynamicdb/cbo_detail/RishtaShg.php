<?php

namespace common\models\dynamicdb\cbo_detail;

use Yii;
use common\models\master\MasterGramPanchayat;
use common\models\master\MasterVillage;

/**
 * This is the model class for table "cbo_shg".
 *
 * @property int $id
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
 * @property string $hamlet
 * @property string $name_of_shg
 * @property string|null $shg_code
 * @property int $no_of_members
 * @property string|null $chaire_person_name
 * @property string|null $chaire_person_mobile_no
 * @property string|null $secretary_name
 * @property string|null $secretary_mobile_no
 * @property string|null $treasurer_name
 * @property string|null $treasurer_mobile_no
 * @property int|null $verify_chaire_person_mobile_no
 * @property int|null $verify_secretary_mobile_no
 * @property int|null $verify_treasurer_mobile_no
 * @property int $verify_shg_location
 * @property int $verify_shg_name
 * @property int $verify_shg_members
 * @property int|null $verify_mobile_no
 * @property int $verify_shg_code
 * @property string|null $verify_datetime
 * @property int|null $verify_by
 * @property int $verification_status
 * @property int|null $cbo_vo_id
 * @property string|null $bank_account_no_of_the_shg
 * @property int|null $bank_id
 * @property string|null $name_of_bank
 * @property string|null $branch
 * @property string|null $branch_code_or_ifsc
 * @property string|null $date_of_opening_the_bank_account
 * @property string|null $passbook_photo
 * @property int|null $bank_detail_by
 * @property string|null $bank_detail_date
 * @property int $return
 * @property int $edit_bmmu
 * @property int|null $verify_shg_passbook_photo
 * @property int|null $verify_shg_bank_account_no
 * @property int|null $verify_shg_branch_code_or_ifsc
 * @property int|null $shg_bank_verify_by
 * @property string|null $shg_bank_verify_date
 * @property int|null $verification_status_shg_bank
 * @property int|null $pfms_maped_status
 * @property string|null $beneficiaries_code
 * @property int|null $bc_shg_funds_status
 * @property string|null $bc_shg_funds_date
 * @property float|null $bc_shg_funds_amount
 * @property int|null $bc_shg_funds_by
 * @property int $shg_bank
 * @property int $temp
 * @property int $urban_shg
 * @property int $verify_chaire_person
 * @property int $verify_ques1
 * @property int $verify_ques2
 * @property int $verify_ques3
 * @property int $verify_secretary
 * @property int $verify_s_ques1
 * @property int $verify_s_ques2
 * @property int $verify_s_ques3
 * @property int $verify_treasurer
 * @property int $verify_t_ques1
 * @property int $verify_t_ques2
 * @property int $verify_t_ques3
 * @property int $verify_over_all
 * @property int|null $verify_shg_member_by
 * @property string|null $verify_shg_member_datetime
 * @property int|null $ch_user_id
 * @property int|null $se_user_id
 * @property int|null $te_user_id
 * @property int|null $ss_user_id
 * @property int|null $bc_user_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $last_updated_by
 * @property int|null $last_updated_at
 * @property int $dummy_column
 * @property int $status
 * @property string|null $date_of_formation
 * @property string|null $name_of_shg_original
 * @property int|null $no_of_members_original
 */
class RishtaShg extends CboDetailactiveRecord {

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
        return 'rishta_shg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'no_of_members', 'cbo_vo_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['verify_chaire_person_mobile_no'], 'integer'],
            [['hamlet', 'name_of_shg', 'no_of_members'], 'required'],
            [['division_name', 'hamlet', 'name_of_shg'], 'string', 'max' => 150],
            [['district_name', 'block_name'], 'string', 'max' => 30],
            [['shg_code'], 'string', 'max' => 50],
            [['gram_panchayat_name', 'village_name'], 'string', 'max' => 125],
            [['chaire_person_name', 'secretary_name', 'treasurer_name'], 'string', 'max' => 60],
            [['chaire_person_mobile_no', 'treasurer_mobile_no', 'secretary_mobile_no'], 'string', 'max' => 13],
            [['verify_chaire_person_mobile_no', 'verify_secretary_mobile_no', 'verify_treasurer_mobile_no', 'verify_mobile_no', 'verify_shg_code', 'verify_by', 'verification_status'], 'integer'],
            [['verify_datetime', 'verify_shg_member_datetime'], 'safe'],
            ['dummy_column', 'default', 'value' => 0],
            [['edit_bmmu'], 'safe'],
            [['bank_id', 'return'], 'integer'],
            [['date_of_opening_the_bank_account'], 'safe'],
            [['bank_account_no_of_the_shg', 'branch_code_or_ifsc'], 'string', 'max' => 25],
            [['name_of_bank', 'branch'], 'string', 'max' => 150],
            [['passbook_photo'], 'string', 'max' => 500],
            ['return', 'default', 'value' => 0],
            [['verify_shg_passbook_photo', 'verify_shg_bank_account_no', 'verify_shg_branch_code_or_ifsc', 'shg_bank_verify_by', 'verification_status_shg_bank'], 'integer'],
            [['shg_bank_verify_date'], 'safe'],
            ['shg_bank', 'default', 'value' => 0],
            [['pfms_maped_status', 'bc_shg_funds_status', 'bc_shg_funds_by'], 'integer'],
            [['bc_shg_funds_date'], 'safe'],
            [['bc_shg_funds_amount'], 'number'],
            [['bc_shg_funds_amount'], 'safe'],
            [['beneficiaries_code'], 'safe'],
            [['urban_shg'], 'integer'],
            ['urban_shg', 'default', 'value' => 0],
            [['verify_chaire_person', 'verify_ques1', 'verify_ques2', 'verify_ques3', 'verify_secretary', 'verify_s_ques1', 'verify_s_ques2', 'verify_s_ques3', 'verify_treasurer', 'verify_t_ques1', 'verify_t_ques2', 'verify_t_ques3', 'verify_over_all', 'verify_shg_member_by'], 'integer'],
            [['last_updated_by', 'last_updated_at'], 'integer'],
            [['date_of_formation'], 'safe'],
            [['ch_user_id', 'se_user_id', 'te_user_id', 'ss_user_id', 'bc_user_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'UPSRLM SHG ID',
            'division_code' => 'Division',
            'division_name' => 'Division Name',
            'district_code' => 'District',
            'district_name' => 'District Name',
            'block_code' => 'Block',
            'block_name' => 'Block Name',
            'gram_panchayat_code' => 'Gram Panchayat',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'village_code' => 'Village',
            'village_name' => 'Village Name',
            'hamlet' => 'Hamlet',
            'name_of_shg' => 'Name of SHG',
            'shg_code' => 'SHG Code',
            'no_of_members' => 'No. of members',
            'chaire_person_name' => 'Chaire Person Name',
            'chaire_person_mobile_no' => 'Chaire Person Mobile No',
            'secretary_name' => 'Secretary Name',
            'secretary_mobile_no' => 'Secretary Mobile No',
            'treasurer_name' => 'Treasurer Name',
            'treasurer_mobile_no' => 'Treasurer Mobile No',
            'verify_chaire_person_mobile_no' => 'Verify chaire person mobile no.',
            'verify_secretary_mobile_no' => 'Verify chaire person mobile no.',
            'verify_treasurer_mobile_no' => 'Verify chaire person mobile no.',
            'verify_mobile_no' => 'Verified',
            'verify_shg_code' => 'Verify SHG Code',
            'verify_datetime' => 'Verify datetime',
            'verification_status' => 'Verification status',
            'cbo_vo_id' => 'VO',
            'bank_account_no_of_the_shg' => 'Bank Account No Of The Shg',
            'bank_id' => 'Bank ID',
            'name_of_bank' => 'Name Of Bank',
            'branch' => 'Branch',
            'branch_code_or_ifsc' => 'Branch Code Or Ifsc',
            'date_of_opening_the_bank_account' => 'Date Of Opening The Bank Account',
            'passbook_photo' => 'Passbook Photo',
            'return' => 'Return',
            'urban_shg' => 'GP Convert Urban',
            'verify_chaire_person' => 'Verify Chaire Person',
            'verify_ques1' => 'समूह का नाम, पदाधिकारीयों के नाम व फ़ोन नम्बर सत्यापित करें',
            'verify_ques2' => 'क्या आपके पास स्मार्ट्फ़ोन है?',
            'verify_ques3' => 'अगर हाँ तो, क्या आप समूह सम्बन्धी मोबाइल ऐप अपने फ़ोन पर चलने के लिए सहमत हैं?',
            'verify_secretary' => 'Verify Secretary',
            'verify_s_ques1' => 'समूह का नाम, पदाधिकारीयों के नाम व फ़ोन नम्बर सत्यापित करें',
            'verify_s_ques2' => 'क्या आपके पास स्मार्ट्फ़ोन है?',
            'verify_s_ques3' => 'अगर हाँ तो, क्या आप समूह सम्बन्धी मोबाइल ऐप अपने फ़ोन पर चलने के लिए सहमत हैं?',
            'verify_treasurer' => 'Verify Treasurer',
            'verify_t_ques1' => 'समूह का नाम, पदाधिकारीयों के नाम व फ़ोन नम्बर सत्यापित करें',
            'verify_t_ques2' => 'क्या आपके पास स्मार्ट्फ़ोन है?',
            'verify_t_ques3' => 'अगर हाँ तो, क्या आप समूह सम्बन्धी मोबाइल ऐप अपने फ़ोन पर चलने के लिए सहमत हैं?',
            'verify_over_all' => 'Verify Over All',
            'verify_shg_member_by' => 'Verify Shg Member By',
            'verify_shg_member_datetime' => 'Verify Shg Member Datetime',
            'ch_user_id' => 'Chaire Person User',
            'se_user_id' => 'Secretary User',
            'te_user_id' => 'Treasurer User',
            'ss_user_id' => 'Samuh Sakhi User',
            'bc_user_id' => 'BC Sakhi User',
            'verify_by' => 'Verify by',
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

    public function getVerifyshgcodestatus() {
        $yes_no_option = ['1' => 'Yes', '0' => 'No', '-1' => 'skip'];
        return isset($yes_no_option[$this->verify_shg_code]) ? $yes_no_option[$this->verify_shg_code] : "";
    }

    public function getVerifyshglocationstatus() {
        $yes_no_option = ['1' => 'Yes', '0' => 'No', '-1' => 'skip'];
        return isset($yes_no_option[$this->verify_shg_location]) ? $yes_no_option[$this->verify_shg_location] : "";
    }

    public function getVerifyshgnamestatus() {
        $yes_no_option = ['1' => 'Yes', '0' => 'No', '-1' => 'skip'];
        return isset($yes_no_option[$this->verify_shg_name]) ? $yes_no_option[$this->verify_shg_name] : "";
    }

    public function getVerifyshgmembersstatus() {
        $yes_no_option = ['1' => 'Yes', '0' => 'No', '-1' => 'skip'];
        return isset($yes_no_option[$this->verify_shg_members]) ? $yes_no_option[$this->verify_shg_members] : "";
    }

    public function getVerifychairepersonmobilenostatus() {
        $yes_no_option = ['1' => 'Yes', '0' => 'No', '-1' => 'skip'];
        return isset($yes_no_option[$this->verify_chaire_person_mobile_no]) ? $yes_no_option[$this->verify_chaire_person_mobile_no] : "";
    }

    public function getVerifysecretarymobilenostatus() {
        $yes_no_option = ['1' => 'Yes', '0' => 'No', '-1' => 'skip'];
        return isset($yes_no_option[$this->verify_secretary_mobile_no]) ? $yes_no_option[$this->verify_secretary_mobile_no] : "";
    }

    public function getVerifytreasurermobilenostatus() {
        $yes_no_option = ['1' => 'Yes', '0' => 'No', '-1' => 'skip'];
        return isset($yes_no_option[$this->verify_treasurer_mobile_no]) ? $yes_no_option[$this->verify_treasurer_mobile_no] : "";
    }

    public function getEntryby() {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getVo() {
        return $this->hasOne(RishtaVo::className(), ['id' => 'cbo_vo_id']);
    }

    public function getClf() {
        return $this->hasOne(RishtaClf::className(), ['id' => 'cbo_clf_id'])->via('vo');
    }

    public function getRprofile() {
        return $this->hasOne(RishtaShgProfile::className(), ['cbo_shg_id' => 'id']);
    }

    public function getRfeedback() {
        return $this->hasOne(RishtaShgFeedback::className(), ['cbo_shg_id' => 'id']);
    }

    public function getBlock() {
        return $this->hasOne(\common\models\master\MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getRmembers() {
        return $this->hasMany(RishtaShgMember::className(), ['cbo_shg_id' => 'id'])->where([RishtaShgMember::getTableSchema()->fullName . '.status' => 1]);
    }

    public function getRfundrecived() {
        return $this->hasMany(RishtaShgFundReceived::className(), ['cbo_shg_id' => 'id'])->where([RishtaShgFundReceived::getTableSchema()->fullName . '.status' => 1]);
    }

    public function getPassbookUrl() {

        return Yii::$app->params['app_url']['cbo'] . "/getimage/cbo/shg/" . $this->id . "/" . $this->passbook_photo;
    }

    public function getProrole() {
        return $this->hasMany(User::className(), ['username' => 'chaire_person_mobile_no'])->select(['username', 'role'])->where(['!=', 'user.role', '100'])->count();
    }

    public function getSeorole() {
        return $this->hasMany(User::className(), ['username' => 'secretary_mobile_no'])->select(['username', 'role'])->where(['!=', 'user.role', '100'])->count();
    }

    public function getTrorole() {
        return $this->hasMany(User::className(), ['username' => 'treasurer_mobile_no'])->select(['username', 'role'])->where(['!=', 'user.role', '100'])->count();
    }

    public function getCboshg() {
        return $this->hasOne(\cbo\models\Shg::className(), ['id' => 'id']);
    }

}
