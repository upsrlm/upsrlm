<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CboMemberProfile;
use common\models\master\MasterRole;

/**
 * CboMemberProfileSearch represents the model behind the search form of `common\models\CboMemberProfile`.
 */
class CboMemberProfileSearch extends CboMemberProfile {

    public $division_option = [];
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $village_option = [];
    public $bank_option = [];
    public $member_option = [];
    public $rishta_access_option = [];
    public $ctc_call_option = [];
    public $ibd_call_option = [];
    public $page;
    public $member;
    public $rishta_access_page;
    public $transaction_start;
    public $ctc_call;
    public $ibd_call;
    public $from_date_time;
    public $to_date_time;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'user_id', 'folder_prefix', 'gender', 'primary_phone_no_verified', 'alternate_phone_no_verified', 'whatsapp_no_verified', 'email_id_verified', 'bc', 'samuh_sakhi', 'samuh_sakhi_old', 'wada_sakhi', 'accountant', 'shg', 'vo', 'clf', 'age', 'cast', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'marital_status', 'srlm_bc_application_id', 'srlm_bc_selection_user_id', 'bank_id', 'bank_id_shg', 'bc_no_of_transaction', 'ctc_call_count', 'ibd_call_count', 'master_partner_bank_id', 'bc_copy_file_count', 'created_by', 'created_at', 'updated_by', 'updated_at', 'status'], 'safe'],
            [['first_name', 'middle_name', 'sur_name', 'date_of_birth', 'primary_phone_no', 'primary_phone_no_verified_date', 'alternate_phone_no', 'alternate_phone_no_verified_date', 'whatsapp_no', 'whatsapp_no_verified_date', 'email_id', 'email_id_verified_date', 'aadhaar_number', 'division_name', 'district_name', 'block_name', 'gram_panchayat_name', 'village_name', 'hamlet', 'guardian_name', 'otp_mobile_no', 'bank_account_no', 'name_of_bank', 'branch', 'branch_code_or_ifsc', 'date_of_opening_the_bank_account', 'cin', 'iibf_membership_no', 'profile_photo', 'photo_aadhaar_front', 'photo_aadhaar_back', 'passbook_photo', 'pan_photo', 'iibf_photo_file_name', 'pvr_upload_file_name', 'bc_handheld_machine_photo', 'passbook_photo_shg', 'bank_account_no_of_the_shg', 'name_of_bank_shg', 'branch_shg', 'branch_code_or_ifsc_shg', 'rishta_app_last_access_time'], 'safe'],
            [['bc_transaction_amount'], 'safe'],
            [['member'], 'safe'],
            [['rishta_access_page', 'transaction_start'], 'safe'],
            [['ctc_call', 'ibd_call'], 'safe'],
            [['from_date_time', 'to_date_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $user_model = null, $pagination = true, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = CboMemberProfile::find();
        $query->joinWith(['user']);
        if ($columns != NULL) {
            $query->select($columns);
        }
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_YOUNG_PROFESSIONAL])) {
                $query->andWhere([Shg::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CBO_USER])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_ADMIN])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_FRONTIER_MARKET_DISTRICT_ADMIN])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_WADA_ADMIN])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_ADMIN])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE])) {
                $query->andWhere([User::getTableSchema()->fullName . '.dummy_column' => $user_model->dummy_column]);
            } else {
                $query->where('0=1');
            }
        }
        if (isset($this->from_date_time) && $this->from_date_time != '') {
            $query->andFilterWhere(['>=', CboMemberProfile::getTableSchema()->fullName . '.rishta_app_last_access_time', $this->from_date_time . ' 00:00:00']);
        }
        if (isset($this->to_date_time) && $this->to_date_time != '') {
            $query->andFilterWhere(['<=', CboMemberProfile::getTableSchema()->fullName . '.rishta_app_last_access_time', $this->to_date_time . ' 23:59:59']);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['first_name' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            CboMemberProfile::getTableSchema()->fullName . '.id' => $this->id,
            CboMemberProfile::getTableSchema()->fullName . '.user_id' => $this->user_id,
            CboMemberProfile::getTableSchema()->fullName . '.folder_prefix' => $this->folder_prefix,
            CboMemberProfile::getTableSchema()->fullName . '.gender' => $this->gender,
            CboMemberProfile::getTableSchema()->fullName . '.date_of_birth' => $this->date_of_birth,
            CboMemberProfile::getTableSchema()->fullName . '.primary_phone_no_verified' => $this->primary_phone_no_verified,
            CboMemberProfile::getTableSchema()->fullName . '.primary_phone_no_verified_date' => $this->primary_phone_no_verified_date,
            CboMemberProfile::getTableSchema()->fullName . '.alternate_phone_no_verified' => $this->alternate_phone_no_verified,
            CboMemberProfile::getTableSchema()->fullName . '.alternate_phone_no_verified_date' => $this->alternate_phone_no_verified_date,
            CboMemberProfile::getTableSchema()->fullName . '.whatsapp_no_verified' => $this->whatsapp_no_verified,
            CboMemberProfile::getTableSchema()->fullName . '.whatsapp_no_verified_date' => $this->whatsapp_no_verified_date,
            CboMemberProfile::getTableSchema()->fullName . '.email_id_verified' => $this->email_id_verified,
            CboMemberProfile::getTableSchema()->fullName . '.email_id_verified_date' => $this->email_id_verified_date,
            CboMemberProfile::getTableSchema()->fullName . '.bc' => $this->bc,
            CboMemberProfile::getTableSchema()->fullName . '.samuh_sakhi' => $this->samuh_sakhi,
            CboMemberProfile::getTableSchema()->fullName . '.samuh_sakhi_old' => $this->samuh_sakhi_old,
            CboMemberProfile::getTableSchema()->fullName . '.wada_sakhi' => $this->wada_sakhi,
            CboMemberProfile::getTableSchema()->fullName . '.accountant' => $this->accountant,
            CboMemberProfile::getTableSchema()->fullName . '.shg' => $this->shg,
            CboMemberProfile::getTableSchema()->fullName . '.vo' => $this->vo,
            CboMemberProfile::getTableSchema()->fullName . '.clf' => $this->clf,
            CboMemberProfile::getTableSchema()->fullName . '.age' => $this->age,
            CboMemberProfile::getTableSchema()->fullName . '.cast' => $this->cast,
            CboMemberProfile::getTableSchema()->fullName . '.division_code' => $this->division_code,
            CboMemberProfile::getTableSchema()->fullName . '.district_code' => $this->district_code,
            CboMemberProfile::getTableSchema()->fullName . '.block_code' => $this->block_code,
            CboMemberProfile::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
            CboMemberProfile::getTableSchema()->fullName . '.village_code' => $this->village_code,
            CboMemberProfile::getTableSchema()->fullName . '.marital_status' => $this->marital_status,
            CboMemberProfile::getTableSchema()->fullName . '.srlm_bc_application_id' => $this->srlm_bc_application_id,
            CboMemberProfile::getTableSchema()->fullName . '.srlm_bc_selection_user_id' => $this->srlm_bc_selection_user_id,
            CboMemberProfile::getTableSchema()->fullName . '.bank_id' => $this->bank_id,
            CboMemberProfile::getTableSchema()->fullName . '.date_of_opening_the_bank_account' => $this->date_of_opening_the_bank_account,
            CboMemberProfile::getTableSchema()->fullName . '.bank_id_shg' => $this->bank_id_shg,
            CboMemberProfile::getTableSchema()->fullName . '.rishta_app_last_access_time' => $this->rishta_app_last_access_time,
            CboMemberProfile::getTableSchema()->fullName . '.bc_no_of_transaction' => $this->bc_no_of_transaction,
            CboMemberProfile::getTableSchema()->fullName . '.bc_transaction_amount' => $this->bc_transaction_amount,
            CboMemberProfile::getTableSchema()->fullName . '.ctc_call_count' => $this->ctc_call_count,
            CboMemberProfile::getTableSchema()->fullName . '.ibd_call_count' => $this->ibd_call_count,
            CboMemberProfile::getTableSchema()->fullName . '.master_partner_bank_id' => $this->master_partner_bank_id,
            CboMemberProfile::getTableSchema()->fullName . '.bc_copy_file_count' => $this->bc_copy_file_count,
            CboMemberProfile::getTableSchema()->fullName . '.created_by' => $this->created_by,
            CboMemberProfile::getTableSchema()->fullName . '.created_at' => $this->created_at,
            CboMemberProfile::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            CboMemberProfile::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            CboMemberProfile::getTableSchema()->fullName . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.first_name', $this->first_name])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.middle_name', $this->middle_name])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.sur_name', $this->sur_name])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.primary_phone_no', $this->primary_phone_no])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.alternate_phone_no', $this->alternate_phone_no])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.whatsapp_no', $this->whatsapp_no])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.email_id', $this->email_id])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.aadhaar_number', $this->aadhaar_number])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.division_name', $this->division_name])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.district_name', $this->district_name])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.block_name', $this->block_name])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.gram_panchayat_name', $this->gram_panchayat_name])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.village_name', $this->village_name])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.hamlet', $this->hamlet])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.guardian_name', $this->guardian_name])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.otp_mobile_no', $this->otp_mobile_no])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.bank_account_no', $this->bank_account_no])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.name_of_bank', $this->name_of_bank])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.branch', $this->branch])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.branch_code_or_ifsc', $this->branch_code_or_ifsc])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.cin', $this->cin])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.iibf_membership_no', $this->iibf_membership_no])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.profile_photo', $this->profile_photo])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.photo_aadhaar_front', $this->photo_aadhaar_front])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.photo_aadhaar_back', $this->photo_aadhaar_back])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.passbook_photo', $this->passbook_photo])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.pan_photo', $this->pan_photo])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.iibf_photo_file_name', $this->iibf_photo_file_name])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.pvr_upload_file_name', $this->pvr_upload_file_name])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.bc_handheld_machine_photo', $this->bc_handheld_machine_photo])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.passbook_photo_shg', $this->passbook_photo_shg])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.bank_account_no_of_the_shg', $this->bank_account_no_of_the_shg])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.name_of_bank_shg', $this->name_of_bank_shg])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.branch_shg', $this->branch_shg])
                ->andFilterWhere(['like', CboMemberProfile::getTableSchema()->fullName . '.branch_code_or_ifsc_shg', $this->branch_code_or_ifsc_shg]);

        return $dataProvider;
    }

}
