<?php

namespace cbo\models;

use Yii;

/**
 * This is the model class for table "cbo_vo".
 *
 * @property int $id
 * @property int $state_code
 * @property string $state_name
 * @property int|null $division_code
 * @property string|null $division_name
 * @property int|null $district_code
 * @property string|null $district_name
 * @property int|null $block_code
 * @property string|null $block_name
 * @property int|null $gram_panchayat_code
 * @property string|null $gram_panchayat_name
 * @property string $name_of_vo
 * @property string|null $nrlm_vo_code
 * @property string|null $date_of_formation
 * @property int $no_of_shg_connected
 * @property string|null $bank_account_no_of_the_vo
 * @property int|null $bank_id
 * @property string|null $name_of_bank
 * @property string|null $branch
 * @property string|null $branch_code_or_ifsc
 * @property string|null $date_of_opening_the_bank_account
 * @property string|null $samuh_sakhi_name
 * @property int|null $samuh_sakhi_age
 * @property int|null $samuh_sakhi_cbo_shg_id
 * @property string|null $samuh_sakhi_mobile_no
 * @property int|null $samuh_sakhi_mobile_type
 * @property int|null $samuh_sakhi_social_category
 * @property int|null $samuh_sakhi_detail_by
 * @property string|null $samuh_sakhi_detail_date
 * @property int|null $cbo_clf_id
 * @property int $edit_bmmu
 * @property int $verify_vo_name_code_address
 * @property int $verify_vo_formation_date_no_shg
 * @property int $verify_vo_related_to_bank_account
 * @property int $verify_vo_total_amount
 * @property int $verify_vo_affiliated_shg_detail
 * @property int $verify_vo_members_detail
 * @property int $verify_vo_any_other_info
 * @property int $verification_status
 * @property int|null $verify_by
 * @property string|null $verify_datetime
 * @property int $urban_vo
 * @property int $verification_status_samuh_sakhi
 * @property int|null $verify_samuh_sakhi_detail_by
 * @property string|null $verify_samuh_sakhi_detail_date
 * @property int $wada
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $dummy_column
 * @property int $status
 */
class CboVo extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

    const STATUS_SAVE = 1;
    const STATUS_SUBMIT = 2;

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
        return 'cbo_vo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'no_of_shg_connected', 'bank_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status', 'cbo_clf_id'], 'integer'],
            [['name_of_vo', 'no_of_shg_connected'], 'required'],
            [['date_of_formation', 'date_of_opening_the_bank_account', 'verify_datetime'], 'safe'],
            [['division_name', 'name_of_vo', 'name_of_bank', 'branch'], 'string', 'max' => 150],
            [['district_name', 'block_name'], 'string', 'max' => 30],
            [['gram_panchayat_name'], 'string', 'max' => 125],
            [['bank_account_no_of_the_vo', 'branch_code_or_ifsc'], 'string', 'max' => 25],
            [['nrlm_vo_code'], 'trim'],
            [['name_of_vo'], 'trim'],
            [['no_of_shg_connected'], 'trim'],
            [['date_of_formation'], 'trim'],
            [['date_of_opening_the_bank_account'], 'trim'],
            [['bank_account_no_of_the_vo'], 'trim'],
            [['branch_code_or_ifsc'], 'trim'],
            [['branch'], 'trim'],
            ['dummy_column', 'default', 'value' => 0],
            [['edit_bmmu'], 'safe'],
            [['verify_vo_name_code_address', 'verify_vo_formation_date_no_shg', 'verify_vo_related_to_bank_account', 'verify_vo_total_amount', 'verify_vo_affiliated_shg_detail', 'verify_vo_members_detail', 'verify_vo_any_other_info', 'verification_status'], 'integer'],
            [['urban_vo'], 'integer'],
            ['urban_vo', 'default', 'value' => 0],
            [['samuh_sakhi_name'], 'trim'],
            [['samuh_sakhi_name'], 'default', 'value' => NULL],
            [['samuh_sakhi_age'], 'trim'],
            [['samuh_sakhi_age', 'samuh_sakhi_cbo_shg_id', 'samuh_sakhi_mobile_type', 'samuh_sakhi_social_category', 'samuh_sakhi_detail_by'], 'integer'],
            [['samuh_sakhi_detail_date'], 'safe'],
            [['samuh_sakhi_name'], 'string', 'max' => 255],
            [['samuh_sakhi_mobile_no'], 'string', 'max' => 15],
            [['verification_status_samuh_sakhi', 'verify_samuh_sakhi_detail_by', 'wada'], 'integer'],
            [['verify_samuh_sakhi_detail_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'UPSRLM VO ID',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'name_of_vo' => 'Name Of Vo',
            'nrlm_vo_code' => 'NRLM VO code',
            'date_of_formation' => 'Date Of Formation',
            'no_of_shg_connected' => 'No Of Shg Connected',
            'bank_account_no_of_the_vo' => 'Bank Account No Of The Vo',
            'name_of_bank' => 'Name Of Bank',
            'branch' => 'Branch',
            'branch_code_or_ifsc' => 'Branch Code Or Ifsc',
            'date_of_opening_the_bank_account' => 'Date Of Opening The Bank Account',
            'samuh_sakhi_name' => 'समूह सखी का नाम',
            'samuh_sakhi_age' => 'आयु',
            'samuh_sakhi_cbo_shg_id' => 'जिस समूह की सदस्या हैं ',
            'samuh_sakhi_mobile_no' => 'मोबाइल नम्बर,',
            'samuh_sakhi_mobile_type' => 'मोबाइल फ़ोन का प्रकार ',
            'samuh_sakhi_social_category' => 'सामाजिक श्रेणी',
            'samuh_sakhi_detail_by' => 'Samuh Sakhi Detail By',
            'samuh_sakhi_detail_date' => 'Samuh Sakhi Detail Date',
            'verify_vo_name_code_address' => 'VO के नाम, कोड, स्थान व पता ',
            'verify_vo_formation_date_no_shg' => 'VO गठन की तिथि एवं सम्बद्ध स्वयं सहायता समूह (एसएचजी) की संख्या ',
            'verify_vo_related_to_bank_account' => 'बैंक अकाउंट से जुड़े सभी विवरणा',
            'verify_vo_total_amount' => 'VO द्वारा योजना-वार अबतक प्राप्त कुल धनराशि एवं अद्यतन बैंक बैलेन्स',
            'verify_vo_affiliated_shg_detail' => 'VO के साथ सम्बद्ध सभी SHG के विवरण',
            'verify_vo_members_detail' => 'VO के सभी सदस्यों के नाम एवं पूर्ण विवरण',
            'verify_vo_any_other_info' => 'कोई अन्य सूचना ',
            'verification_status' => 'Verification Status',
            'verify_by' => 'Verify By',
            'verify_datetime' => 'Verify Datetime',
            'urban_shg' => 'GP Convert Urban',
            'verification_status_samuh_sakhi' => 'Verification Status Samuh Sakhi',
            'verify_samuh_sakhi_detail_by' => 'Verify Samuh Sakhi Detail By',
            'verify_samuh_sakhi_detail_date' => 'Verify Samuh Sakhi Detail Date',
            'wada' => 'WADA',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {
        if ($this->gram_panchayat_code != NULL) {
            $gp_model = \common\models\master\MasterGramPanchayat::find()->where(['gram_panchayat_code' => $this->gram_panchayat_code])->one();
            if (!empty($gp_model)) {
                $this->division_code = $gp_model->division_code;
                $this->division_name = $gp_model->division_name;
                $this->district_code = $gp_model->district_code;
                $this->district_name = $gp_model->district_name;
                $this->block_code = $gp_model->block_code;
                $this->block_name = $gp_model->block_name;
                $this->gram_panchayat_code = $gp_model->gram_panchayat_code;
                $this->gram_panchayat_name = $gp_model->gram_panchayat_name;
                $this->wada = $gp_model->wada_gp;
            }
        }
        if ($this->bank_id) {
            $bank_model = master\CboMasterBank::findOne($this->bank_id);
            if (!empty($bank_model)) {
                $this->name_of_bank = $bank_model->bank_name;
            }
        }
        if ($this->date_of_formation != null and $this->date_of_formation != '') {
            $this->date_of_formation = \Yii::$app->formatter->asDatetime($this->date_of_formation, "php:Y-m-d");
        }
        if ($this->date_of_opening_the_bank_account != null and $this->date_of_opening_the_bank_account != '') {
            $this->date_of_opening_the_bank_account = \Yii::$app->formatter->asDatetime($this->date_of_opening_the_bank_account, "php:Y-m-d");
        }
        return parent::beforeSave($insert);
    }

    public function getDistrict() {
        return $this->hasOne(\common\models\master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getClf() {
        return $this->hasOne(CboClf::className(), ['id' => 'cbo_clf_id']);
    }

    public function getFunds() {
        return $this->hasMany(CboVoFunds::className(), ['cbo_vo_id' => 'id'])->where(['status' => 1]);
    }

    public function getClfFunds() {
        return $this->hasMany(CboClfVoFunds::className(), ['cbo_vo_id' => 'id'])->where(['status' => 1]);
    }

    public function getFundsgivetoclf() {
        return $this->hasMany(CboClfFunds::className(), ['cbo_vo_id' => 'id'])->where(['status' => 1, 'received_by' => CboClfFunds::RECEIVED_BY_VO]);
    }

    public function getMembers() {
        return $this->hasMany(CboVoMembers::className(), ['cbo_vo_id' => 'id'])->where(['status' => 1]);
    }

    public function getShg() {
        return $this->hasMany(Shg::className(), ['cbo_vo_id' => 'id']);
    }

    public function getShghtml() {
        $html = '';
//        foreach ($this->shg as $shg) {
//            $url = "/shg/view?shgid=" . $shg->cbo_shg_id;
//            $html .= "<a href='$url' target='_blank'>" . $shg->shg->name_of_shg . "</a><br/>";
//        }
        return $html;
    }

    public function getVostatus() {
        $array = [1 => 'Save', 2 => 'Submit'];
        return isset($array[$this->status]) ? $array[$this->status] : '';
    }

    public function getVerificationstatus() {
        $array = [1 => 'Verified', 2 => 'Unverified'];
        return isset($array[$this->verification_status]) ? $array[$this->verification_status] : '';
    }

    public function getVerify1status() {
        $array = [1 => 'हाँ', 2 => 'नहीं', 3 => 'अपूर्ण'];
        return isset($array[$this->verify_vo_name_code_address]) ? $array[$this->verify_vo_name_code_address] : '';
    }

    public function getVerify2status() {
        $array = [1 => 'हाँ', 2 => 'नहीं', 3 => 'अपूर्ण'];
        return isset($array[$this->verify_vo_formation_date_no_shg]) ? $array[$this->verify_vo_formation_date_no_shg] : '';
    }

    public function getVerify3status() {
        $array = [1 => 'हाँ', 2 => 'नहीं', 3 => 'अपूर्ण'];
        return isset($array[$this->verify_vo_related_to_bank_account]) ? $array[$this->verify_vo_related_to_bank_account] : '';
    }

    public function getVerify4status() {
        $array = [1 => 'हाँ', 2 => 'नहीं', 3 => 'अपूर्ण'];
        return isset($array[$this->verify_vo_total_amount]) ? $array[$this->verify_vo_total_amount] : '';
    }

    public function getVerify5status() {
        $array = [1 => 'हाँ', 2 => 'नहीं', 3 => 'अपूर्ण'];
        return isset($array[$this->verify_vo_affiliated_shg_detail]) ? $array[$this->verify_vo_affiliated_shg_detail] : '';
    }

    public function getVerify6status() {
        $array = [1 => 'हाँ', 2 => 'नहीं', 3 => 'अपूर्ण'];
        return isset($array[$this->verify_vo_members_detail]) ? $array[$this->verify_vo_members_detail] : '';
    }

    public function getVerify7status() {
        $array = [1 => 'हाँ', 2 => 'नहीं', 3 => 'अपूर्ण'];
        return isset($array[$this->verify_vo_any_other_info]) ? $array[$this->verify_vo_any_other_info] : '';
    }

    public function getEntryby() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'created_by']);
    }

    public function getVerifyby() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'verify_by']);
    }

    public function getSamuhsakhishg() {
        return $this->hasOne(Shg::className(), ['id' => 'samuh_sakhi_cbo_shg_id']);
    }

    public function getSocialcategory() {
        return $this->hasOne(\cbo\models\master\CboMasterCast::className(), ['id' => 'samuh_sakhi_social_category']);
    }

    public function getMobiletype() {
        return $this->hasOne(\cbo\models\master\CboMasterPhoneType::className(), ['id' => 'samuh_sakhi_mobile_type']);
    }

    public function getSamuhsakirole() {
        return $this->hasMany(\common\models\User::className(), ['username' => 'samuh_sakhi_mobile_no'])->select(['username', 'role'])->where(['!=', 'user.role', '100'])->count();
    }

    public function getRishtavo() {
        return $this->hasOne(\common\models\dynamicdb\cbo_detail\RishtaVo::className(), ['id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes) {
        $attribute = CboVo::findOne($this->id);
        try {

            $cbo_detail = new \common\models\dynamicdb\cbo_detail\RishtaVo();
            $modelcbod = $cbo_detail::findOne($attribute->id);

            if (empty($modelcbod)) {
                $modelcbod = new \common\models\dynamicdb\cbo_detail\RishtaVo();
            }
            $modelcbod->id = $attribute->id;
            $modelcbod->setAttributes($attribute->toArray());
            if ($modelcbod->save()) {
                
            } else {
//                print_r($modelcbod->getErrors());
//                exit;
            }
        } catch (\Exception $ex) {
            
        }
        return true;
    }

    public function GetCtccount() {
        return $this->hasMany(\common\models\dynamicdb\internalcallcenter\CloudTeleApiCall::className(), ['customernumber' => 'samuh_sakhi_mobile_no', 'cbo_shg_id' => 'samuh_sakhi_cbo_shg_id'])->select(['id'])->where(['upsrlm_call_type' => 1]);
    }

    public function GetFirstcall() {
        $firstcall = \common\models\dynamicdb\internalcallcenter\CloudTeleApiCall::find()->where(['customernumber' => $this->samuh_sakhi_mobile_no,'cbo_shg_id' => $this->samuh_sakhi_cbo_shg_id, 'upsrlm_call_type' => 1,'upsrlm_call_status' => 10])->orderBy(['api_request_datetime' => SORT_ASC])->limit(1)->one();
        if ($firstcall) {
            return $firstcall->api_request_datetime;
        }
        return null;
    }

    public function GetLastcall() {
        $firstcall = \common\models\dynamicdb\internalcallcenter\CloudTeleApiCall::find()->where(['customernumber' => $this->samuh_sakhi_mobile_no, 'cbo_shg_id' => $this->samuh_sakhi_cbo_shg_id, 'upsrlm_call_type' => 1,'upsrlm_call_status' => 10])->orderBy(['api_request_datetime' => SORT_DESC])->limit(1)->one();
        if ($firstcall) {
            return $firstcall->api_request_datetime;
        }
        return null;
    }

}
