<?php

namespace common\models\master;

use Yii;

/**
 * This is the model class for table "gram_panchayat_detail_ultra_poor_history".
 *
 * @property int $id
 * @property int $gram_panchayat_code
 * @property int $block_code
 * @property int $district_code
 * @property string $date
 * @property string $gram_panchayat_name
 * @property int $gram_pardhan
 * @property int $gram_pardhan_user_id
 * @property int $gram_pardhan_contact
 * @property int $gram_pardhan_login
 * @property int $gram_pardhan_add_no_user
 * @property int $gram_pardhan_go_sent
 * @property int $gram_pardhan_go_contact
 * @property int $sahayak_go_sent
 * @property int $sahayak_go_contact
 * @property int $sahayak
 * @property int $sahayak_user_id
 * @property int $sahayak_contact
 * @property int $sahayak_login
 * @property int $sahayak_add_no_user
 * @property int $no_of_user
 * @property int $no_of_user_login
 * @property int $gp_user_login
 * @property int $hhs_enumerated
 * @property int $hhs_enumerated_old
 * @property int $hhs_enumerated_mopup
 * @property int $gram_pardhan_return_hhs
 * @property int $gram_pardhan_verify_hhs
 * @property int $gram_pardhan_remain_verification
 * @property int $hhs_in_save_mode
 * @property int $hhs_shg_member
 * @property int $digital_hhs_attempt
 * @property int $digital_hhs_remain_attempt
 * @property int $digital_hhs_verified
 * @property int $digital_hhs_unverified
 * @property int $digital_hhs_has_smartphone
 * @property int $digital_hhs_wrong_mobile_no
 * @property int $digital_hhs_wrong_mobile_no_does_not_exist
 * @property int $gp_covert_urban
 * @property int|null $updated_at
 * @property int $status
 */
class GramPanchayatDetailUltraPoorHistory extends \common\models\dynamicdb\cbo\CboactiveRecord {

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => false,
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
        return 'gram_panchayat_detail_ultra_poor_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['gram_panchayat_code', 'gram_panchayat_name'], 'required'],
            [['gram_panchayat_code', 'block_code', 'district_code', 'gram_pardhan','gram_pardhan_user_id','gram_pardhan_contact', 'gram_pardhan_login', 'gram_pardhan_add_no_user', 'no_of_user', 'no_of_user_login', 'hhs_enumerated', 'hhs_enumerated_old', 'hhs_enumerated_mopup', 'gram_pardhan_return_hhs', 'gram_pardhan_verify_hhs', 'gram_pardhan_remain_verification', 'hhs_in_save_mode', 'digital_hhs_attempt', 'digital_hhs_remain_attempt', 'digital_hhs_verified', 'digital_hhs_unverified', 'digital_hhs_has_smartphone', 'digital_hhs_wrong_mobile_no', 'digital_hhs_wrong_mobile_no_does_not_exist','hhs_shg_member', 'gp_covert_urban', 'updated_at', 'status'], 'integer'],
            [['date'], 'safe'],
            [['gram_panchayat_name'], 'string', 'max' => 132],
            [['gram_panchayat_code', 'date'], 'unique', 'targetAttribute' => ['gram_panchayat_code', 'date']],
            [['sahayak', 'sahayak_user_id','sahayak_contact','sahayak_login','sahayak_add_no_user','gram_pardhan_go_sent','sahayak_go_sent','sahayak_go_contact','gram_pardhan_go_contact','gp_user_login'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'block_code' => 'Block Code',
            'district_code' => 'District Code',
            'date' => 'Date',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'gram_pardhan' => 'Gram Pardhan',
            'gram_pardhan_login' => 'Gram Pardhan Login',
            'gram_pardhan_add_no_user' => 'Gram Pardhan Add No User',
            'no_of_user' => 'No Of User',
            'no_of_user_login' => 'No Of User Login',
            'hhs_enumerated' => 'Hhs Enumerated',
            'hhs_enumerated_old' => 'Hhs Enumerated Old',
            'hhs_enumerated_mopup' => 'Hhs Enumerated Mopup',
            'gram_pardhan_return_hhs' => 'Gram Pardhan Return Hhs',
            'gram_pardhan_verify_hhs' => 'Gram Pardhan Verify Hhs',
            'gram_pardhan_remain_verification' => 'Gram Pardhan Remain Verification',
            'hhs_in_save_mode' => 'Hhs In Save Mode',
            'digital_hhs_attempt' => 'Digital Hhs Attempt',
            'digital_hhs_remain_attempt' => 'Digital Hhs Remain Attempt',
            'digital_hhs_verified' => 'Digital Hhs Verified',
            'digital_hhs_unverified' => 'Digital Hhs Unverified',
            'digital_hhs_has_smartphone' => 'Digital Hhs Has Smartphone',
            'digital_hhs_wrong_mobile_no' => 'Digital Hhs Wrong Mobile No',
            'digital_hhs_wrong_mobile_no_does_not_exist' => 'Digital Hhs Wrong Mobile No Does Not Exist',
            'gp_covert_urban' => 'Gp Covert Urban',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getDistrict() {
        return $this->hasOne(MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getBlock() {
        return $this->hasOne(MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getGp() {
        return $this->hasOne(MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }
}
