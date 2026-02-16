<?php

namespace cbo\models;

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
 * @property int $verify_other
 * @property int $verify_shg_all
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
 * @property int $no_of_call
 * @property int $no_of_call_success
 * @property int $no_of_user
 * @property int $no_of_cst_user
 * @property int $no_of_cst_user_used_rishta
 * @property int $is_bc
 * @property int $no_of_user_used_rishta
 * @property int $suggest_samuh_sakhi
 * @property int $suggest_samuh_sakhi_completed_application
 * @property int $shg_profile_updated
 * @property int $no_of_member_added
 * @property int $bank_detail_add
 * @property int $no_of_fund_received
 * @property float $total_fund_received_amount
 * @property int $shg_feedback
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
 * @property int $wada_shg
 * @property int $repeated_error
 */
class Shg extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

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
        return 'cbo_shg';
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
            ['no_of_call', 'default', 'value' => 0],
            ['no_of_call_success', 'default', 'value' => 0],
            ['no_of_user', 'default', 'value' => 0],
            ['no_of_cst_user', 'default', 'value' => 0],
            ['no_of_cst_user_used_rishta', 'default', 'value' => 0],
            ['is_bc', 'default', 'value' => 0],
            ['no_of_user_used_rishta', 'default', 'value' => 0],
            ['suggest_samuh_sakhi', 'default', 'value' => 0],
            ['suggest_samuh_sakhi_completed_application', 'default', 'value' => 0],
            ['shg_profile_updated', 'default', 'value' => 0],
            ['no_of_member_added', 'default', 'value' => 0],
            ['bank_detail_add', 'default', 'value' => 0],
            ['no_of_fund_received', 'default', 'value' => 0],
            ['total_fund_received_amount', 'default', 'value' => 0],
            ['shg_feedback', 'default', 'value' => 0],
            ['wada_shg', 'default', 'value' => 0],
            ['repeated_error', 'default', 'value' => 0],
            ['verify_chaire_person_mobile_no', 'default', 'value' => 0],
            ['verify_secretary_mobile_no', 'default', 'value' => 0],
            ['verify_treasurer_mobile_no', 'default', 'value' => 0],
            ['verify_other', 'default', 'value' => 0],
            ['verify_shg_all', 'default', 'value' => 0],
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
            'verify_by' => 'Verify by',
            'ch_user_id' => 'Chaire Person User',
            'se_user_id' => 'Secretary User',
            'te_user_id' => 'Treasurer User',
            'ss_user_id' => 'Samuh Sakhi User',
            'bc_user_id' => 'BC Sakhi User',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'repeated_error' => 'Repeated/Error',
        ];
    }

    public function beforeSave($insert) {
        $this->last_updated_at = time();
        if (isset(\Yii::$app->user->identity->id)) {
            $this->last_updated_by = \Yii::$app->user->identity->id;
        }
        if ($this->gram_panchayat_code != NULL) {
            $gp_model = MasterGramPanchayat::find()->where(['gram_panchayat_code' => $this->gram_panchayat_code])->one();
            if (!empty($gp_model)) {
                $this->gram_panchayat_code = $gp_model->gram_panchayat_code;
                $this->gram_panchayat_name = $gp_model->gram_panchayat_name;
                $this->wada_shg = $gp_model->wada_gp;
            }
        }
        if ($this->village_code != NULL) {
            $vill_model = MasterVillage::find()->where(['village_code' => $this->village_code])->one();
            if (!empty($vill_model)) {
                $this->division_code = $vill_model->division_code;
                $this->division_name = $vill_model->division_name;
                $this->district_code = $vill_model->district_code;
                $this->district_name = $vill_model->district_name;
                $this->block_code = $vill_model->block_code;
                $this->block_name = $vill_model->block_name;
                $this->village_code = $vill_model->village_code;
                $this->village_name = $vill_model->village_name;
            }
        }
        if ($this->bank_id) {
            $bank_model = master\CboMasterBank::findOne($this->bank_id);
            if (!empty($bank_model)) {
                $this->name_of_bank = $bank_model->bank_name;
            }
        }
        if ($this->date_of_opening_the_bank_account != null and $this->date_of_opening_the_bank_account != '') {
            $this->date_of_opening_the_bank_account = \Yii::$app->formatter->asDatetime($this->date_of_opening_the_bank_account, "php:Y-m-d");
        }
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
        return $this->hasOne(\common\models\User::className(), ['id' => 'created_by']);
    }

    public function getVo() {
        return $this->hasOne(\cbo\models\CboVo::className(), ['id' => 'cbo_vo_id']);
    }

    public function getClf() {
        return $this->hasOne(\cbo\models\CboClf::className(), ['id' => 'cbo_clf_id'])->via('vo');
    }

    public function getRprofile() {
        return $this->hasOne(\common\models\dynamicdb\cbo_detail\RishtaShgProfile::className(), ['cbo_shg_id' => 'id']);
    }

    public function getRfeedback() {
        return $this->hasOne(\common\models\dynamicdb\cbo_detail\RishtaShgFeedback::className(), ['cbo_shg_id' => 'id']);
    }

    public function getDistrict() {
        return $this->hasOne(\common\models\master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getBlock() {
        return $this->hasOne(\common\models\master\MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getGp() {
        return $this->hasOne(\common\models\master\MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }

    public function getRmembers() {
        return $this->hasMany(\common\models\dynamicdb\cbo_detail\RishtaShgMember::className(), ['cbo_shg_id' => 'id'])->where([\common\models\dynamicdb\cbo_detail\RishtaShgMember::getTableSchema()->fullName . '.status' => 1]);
    }

    public function getRfundrecived() {
        return $this->hasMany(\common\models\dynamicdb\cbo_detail\RishtaShgFundReceived::className(), ['cbo_shg_id' => 'id'])->where([\common\models\dynamicdb\cbo_detail\RishtaShgFundReceived::getTableSchema()->fullName . '.status' => 1]);
    }

    public function getPassbookUrl() {

        return Yii::$app->params['app_url']['hr'] . "/getimage/cbo/shg/" . $this->id . "/" . $this->passbook_photo;
    }

    public function getProrole() {
        return $this->hasMany(\common\models\User::className(), ['username' => 'chaire_person_mobile_no'])->select(['username', 'role'])->where(['!=', 'user.role', '100'])->count();
    }

    public function getSeorole() {
        return $this->hasMany(\common\models\User::className(), ['username' => 'secretary_mobile_no'])->select(['username', 'role'])->where(['!=', 'user.role', '100'])->count();
    }

    public function getTrorole() {
        return $this->hasMany(\common\models\User::className(), ['username' => 'treasurer_mobile_no'])->select(['username', 'role'])->where(['!=', 'user.role', '100'])->count();
    }

    public function getDupacno() {
        $model = Shg::find()->select(['id', 'name_of_shg'])->andWhere(['dummy_column' => 0])->andWhere(['not', ['bank_account_no_of_the_shg' => null]])->andWhere(['bank_account_no_of_the_shg' => $this->bank_account_no_of_the_shg])->asArray()->count();
        return $model;
    }

    public function getChuser() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'ch_user_id']);
    }

    public function getSeuser() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'se_user_id']);
    }

    public function getTeuser() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'te_user_id']);
    }

    public function getBcuser() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'bc_user_id']);
    }

    public function getSsuser() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'ss_user_id']);
    }

    public function getWsuser() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'ws_user_id']);
    }

    public function getRishtashg() {
        return $this->hasOne(\common\models\dynamicdb\cbo_detail\RishtaShg::className(), ['id' => 'id']);
    }

    public function getColumnstatus($value) {
        if ($value) {
            $status = [1 => '<span class="text-success">Verified</span>', 2 => '<span class="text-danger">Return</span>', -1 => 'Skip'];
            return isset($status[$value]) ? ' (' . $status[$value] . ') ' : '';
        } else {
            return '';
        }
    }

    public function getFulladdress() {

        $html = '';
        if (isset($this->hamlet)) {
            $html .= 'Hamlet : ' . $this->hamlet . '<br/>';
        }
        if (isset($this->village_name)) {
            $html .= 'Village  : ' . $this->village_name . '<br/>';
        }
        if (isset($this->gram_panchayat_name)) {
            $html .= 'Gram Panchayat  : ' . $this->gram_panchayat_name . '<br/>';
        }
        if (isset($this->block_name)) {
            $html .= 'Block : ' . $this->block_name . '<br/>';
        }
        if (isset($this->district_name)) {
            $html .= 'District : ' . $this->district_name . '<br/>';
        }

        return $html;
    }

    public function afterSave($insert, $changedAttributes) {
        $attribute = Shg::findOne($this->id);

        try {
            $condition = ['and',
                ['=', 'cbo_shg_id', $attribute->id],
            ];
            \common\models\dynamicdb\cbo_detail\RishtaShgMember::updateAll([
                'division_code' => $attribute->division_code,
                'district_code' => $attribute->district_code,
                'block_code' => $attribute->block_code,
                'gram_panchayat_code' => $attribute->gram_panchayat_code,
                'village_code' => $attribute->village_code,
                    ], $condition);

            $cbo_detail = new \common\models\dynamicdb\cbo_detail\RishtaShg();
            $modelcbod = $cbo_detail::findOne($attribute->id);
            if (empty($modelcbod)) {
                $modelcbod = new \common\models\dynamicdb\cbo_detail\RishtaShg();
            }
            $modelcbod->id = $attribute->id;
            $modelcbod->setAttributes($attribute->toArray());
            if ($modelcbod->save()) {
                
            } else {
//                print_r($modelcbod->getErrors());
//                exit;
            }
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
            exit;
        }
        return true;
    }

}
