<?php

namespace cbo\models\master;

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
 * @property int $verify_samuh_sakhi_ques1
 * @property int $verify_samuh_sakhi_ques2
 * @property int $verify_samuh_sakhi_ques3
 * @property int $verification_status_samuh_sakhi
 * @property int|null $verify_samuh_sakhi_detail_by
 * @property string|null $verify_samuh_sakhi_detail_date
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $dummy_column
 * @property int $status
 */
class CboVo extends \common\models\dynamicdb\cbo\CboactiveRecord {

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
            [['state_code', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'no_of_shg_connected', 'bank_id', 'samuh_sakhi_age', 'samuh_sakhi_cbo_shg_id', 'samuh_sakhi_mobile_type', 'samuh_sakhi_social_category', 'samuh_sakhi_detail_by', 'cbo_clf_id', 'edit_bmmu', 'verify_vo_name_code_address', 'verify_vo_formation_date_no_shg', 'verify_vo_related_to_bank_account', 'verify_vo_total_amount', 'verify_vo_affiliated_shg_detail', 'verify_vo_members_detail', 'verify_vo_any_other_info', 'verification_status', 'verify_by', 'urban_vo', 'verify_samuh_sakhi_ques1', 'verify_samuh_sakhi_ques2', 'verify_samuh_sakhi_ques3', 'verification_status_samuh_sakhi', 'verify_samuh_sakhi_detail_by', 'created_by', 'updated_by', 'created_at', 'updated_at', 'dummy_column', 'status'], 'integer'],
            [['name_of_vo', 'no_of_shg_connected'], 'required'],
            [['date_of_formation', 'date_of_opening_the_bank_account', 'samuh_sakhi_detail_date', 'verify_datetime', 'verify_samuh_sakhi_detail_date'], 'safe'],
            [['state_name'], 'string', 'max' => 100],
            [['division_name', 'name_of_vo', 'name_of_bank', 'branch'], 'string', 'max' => 150],
            [['district_name', 'block_name'], 'string', 'max' => 30],
            [['gram_panchayat_name'], 'string', 'max' => 125],
            [['nrlm_vo_code'], 'string', 'max' => 50],
            [['bank_account_no_of_the_vo', 'branch_code_or_ifsc'], 'string', 'max' => 25],
            [['samuh_sakhi_name'], 'string', 'max' => 255],
            [['samuh_sakhi_mobile_no'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'state_code' => 'State Code',
            'state_name' => 'State Name',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'block_code' => 'Block Code',
            'block_name' => 'Block Name',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'name_of_vo' => 'Name Of Vo',
            'nrlm_vo_code' => 'Nrlm Vo Code',
            'date_of_formation' => 'Date Of Formation',
            'no_of_shg_connected' => 'No Of Shg Connected',
            'bank_account_no_of_the_vo' => 'Bank Account No Of The Vo',
            'bank_id' => 'Bank ID',
            'name_of_bank' => 'Name Of Bank',
            'branch' => 'Branch',
            'branch_code_or_ifsc' => 'Branch Code Or Ifsc',
            'date_of_opening_the_bank_account' => 'Date Of Opening The Bank Account',
            'samuh_sakhi_name' => 'Samuh Sakhi Name',
            'samuh_sakhi_age' => 'Samuh Sakhi Age',
            'samuh_sakhi_cbo_shg_id' => 'Samuh Sakhi Cbo Shg ID',
            'samuh_sakhi_mobile_no' => 'Samuh Sakhi Mobile No',
            'samuh_sakhi_mobile_type' => 'Samuh Sakhi Mobile Type',
            'samuh_sakhi_social_category' => 'Samuh Sakhi Social Category',
            'samuh_sakhi_detail_by' => 'Samuh Sakhi Detail By',
            'samuh_sakhi_detail_date' => 'Samuh Sakhi Detail Date',
            'cbo_clf_id' => 'Cbo Clf ID',
            'edit_bmmu' => 'Edit Bmmu',
            'verify_vo_name_code_address' => 'Verify Vo Name Code Address',
            'verify_vo_formation_date_no_shg' => 'Verify Vo Formation Date No Shg',
            'verify_vo_related_to_bank_account' => 'Verify Vo Related To Bank Account',
            'verify_vo_total_amount' => 'Verify Vo Total Amount',
            'verify_vo_affiliated_shg_detail' => 'Verify Vo Affiliated Shg Detail',
            'verify_vo_members_detail' => 'Verify Vo Members Detail',
            'verify_vo_any_other_info' => 'Verify Vo Any Other Info',
            'verification_status' => 'Verification Status',
            'verify_by' => 'Verify By',
            'verify_datetime' => 'Verify Datetime',
            'urban_vo' => 'Urban Vo',
            'verify_samuh_sakhi_ques1' => 'Verify Samuh Sakhi Ques1',
            'verify_samuh_sakhi_ques2' => 'Verify Samuh Sakhi Ques2',
            'verify_samuh_sakhi_ques3' => 'Verify Samuh Sakhi Ques3',
            'verification_status_samuh_sakhi' => 'Verification Status Samuh Sakhi',
            'verify_samuh_sakhi_detail_by' => 'Verify Samuh Sakhi Detail By',
            'verify_samuh_sakhi_detail_date' => 'Verify Samuh Sakhi Detail Date',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'dummy_column' => 'Dummy Column',
            'status' => 'Status',
        ];
    }

}
