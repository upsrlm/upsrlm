<?php

namespace common\models\dynamicdb\cbo_detail\dbt;

use common\models\dynamicdb\cbo_detail\CboDetailactiveRecord;
use Yii;
use common\models\dynamicdb\cbo_detail\RishtaShgMember;

/**
 * This is the model class for table "dbt_beneficiary_household".
 *
 * @property int $id
 * @property int|null $cbo_shg_id
 * @property int|null $rishta_shg_member_id
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
 * @property string|null $house_no
 * @property int|null $caste_category
 * @property string|null $family_head_name
 * @property int|null $family_head_member_id
 * @property int|null $minority_family
 * @property int|null $bpl_family
 * @property string|null $bpl_secc_id
 * @property string|null $mobile_number
 * @property int|null $iay_beneficiary
 * @property int|null $st_or_tribal
 * @property int|null $land_reforms
 * @property int|null $small_marginal_farmers
 * @property int|null $rsbyi_beneficiary
 * @property int|null $aaby_beneficiary
 * @property int $current_mgnrega_beneficiary
 * @property int $current_mgnrega_beneficiary_interested_work
 * @property int $current_mgnrega_beneficiary_day
 * @property string|null $current_job_card_photo
 * @property string|null $current_job_card_number
 * @property string|null $bocw_reg_no
 * @property string|null $bocw_date
 * @property int|null $bocw
 * @property int|null $bocw_by
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int $status
 */
class DbtBeneficiaryHousehold extends CboDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'dbt_beneficiary_household';
    }

    public function behaviors() {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['cbo_shg_id', 'rishta_shg_member_id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'caste_category', 'family_head_member_id', 'minority_family', 'bpl_family', 'iay_beneficiary', 'st_or_tribal', 'land_reforms', 'small_marginal_farmers', 'rsbyi_beneficiary', 'aaby_beneficiary', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['division_name', 'family_head_name'], 'string', 'max' => 150],
            [['district_name', 'block_name'], 'string', 'max' => 30],
            [['gram_panchayat_name', 'village_name', 'house_no'], 'string', 'max' => 125],
            [['bpl_secc_id'], 'string', 'max' => 50],
            [['mobile_number'], 'string', 'max' => 12],
            [['current_mgnrega_beneficiary', 'current_mgnrega_beneficiary_interested_work', 'current_mgnrega_beneficiary_day'], 'integer'],
            [['current_job_card_photo'], 'string', 'max' => 500],
            [['current_job_card_number'], 'string', 'max' => 50],
            [['current_mgnrega_beneficiary', 'current_mgnrega_beneficiary_interested_work', 'current_mgnrega_beneficiary_day'], 'default', 'value' => 0],
            [['bocw', 'bocw_by'], 'integer'],
            [['bocw_date'], 'safe'],
            [['bocw_reg_no'], 'string', 'max' => 100],
            [['bocw'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'cbo_shg_id' => 'Cbo Shg ID',
            'rishta_shg_member_id' => 'Rishta Shg Member ID',
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
            'house_no' => 'House No',
            'caste_category' => 'Caste Category',
            'family_head_name' => 'Family Head Name',
            'minority_family' => 'Minority Family',
            'bpl_family' => 'Bpl Family',
            'bpl_secc_id' => 'Bpl Secc ID',
            'mobile_number' => 'Mobile Number',
            'iay_beneficiary' => 'Iay Beneficiary',
            'st_or_tribal' => 'St Or Tribal',
            'land_reforms' => 'Land Reforms',
            'small_marginal_farmers' => 'Small Marginal Farmers',
            'rsbyi_beneficiary' => 'Rsbyi Beneficiary',
            'aaby_beneficiary' => 'Aaby Beneficiary',
            'bocw_reg_no' => 'बीओसीडब्ल्यू पंजीकरण संख्या',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getRishtashgmember() {
        return $this->hasOne(RishtaShgMember::className(), ['id' => 'rishta_shg_member_id']);
    }

    public function getJabcard_photo_url() {

        return Yii::$app->params['app_url']['hr'] . "/getimage/cbo/member/scheme/mgnrega/" . $this->id . "/" . $this->current_job_card_photo;
    }

}
