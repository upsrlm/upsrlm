<?php

namespace bc\modules\training\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\RsetisBatchParticipants;
use common\models\master\MasterRole;

/**
 * RsetisBatchParticipantsSearch represents the model behind the search form of `bc\modules\training\models\RsetisBatchParticipants`.
 */
class RsetisBatchParticipantsSearch extends RsetisBatchParticipants {

    public $center_option = [];
    public $division_option = [];
    public $district_option = [];
    public $block_option = [];
    public $gp_option = [];
    public $gp_member_option = [];
    public $training_option = [];
    public $training_status_option = [];
    public $pendency_option = ['pvr' => 'PVR', 'bc_shg_assigned' => 'BC-SHG assigned', 'bc_shg_bank_verified' => 'BC-SHG bank a/c verified', 'pfms_mapping' => 'PFMS mapping', 'bc_shg_support_fund' => 'BC-support fund', 'handheld_machine' => 'Handheld machine provided', 'operational' => 'Operational'];
    public $district_code;
    public $bc_partner_bank_option = [];
    public $rseti_bank_option = [];
    public $rseti_bank;
    public $bc_partner_bank;
    public $already_group_member;
    public $pvr_status;
    public $custom_member_column;
    public $assign_shg_status;
    public $bc_bank;
    public $shg_bank;
    public $custum_training_status;
    public $bc_photo_status;
    public $bc_photo_option = ['0' => "तस्वीर मौजूद नहीं है", "1" => "तस्वीर मौजूद है"];
    public $pfms_maped_status;
    public $bc_shg_funds_status;
    public $pan_card_status;
    public $handheld_machine_status;
    public $pan_photo_upload;
    public $bc_shg_map;
    public $bc_shg_bank;
    public $onboarding;
    public $bc_support_funds_received;
    public $bc_handheld_machine_recived;
    public $iibf_photo_status;
    public $bankid;
    public $custom_education;
    public $last_app_version;
    public $urban_shg;
    public $master_partner_bank_id;
    public $training_feedback;
    public $bc_beneficiaries_map;
    public $show_blocked = 1;
    public $blocked_bc;
    public $saheli;
    public $nretp;
    public $pin_used;
    public $division_code;
    public $rishta_access_page;
    public $shg_confirm_funds_return;
    public $aspirational;
    public $bank_id;
    public $bank_id_shg;
    public $bc_operational;
    public $shg_confirm_funds_return_option = [];
    public $bank_option = [];
    public $bc_bank_option = [];
    public $shg_bank_option = [];
    public $rishta_access_option = ['1' => "Rishta App used", "0" => "Rishta app not used"];
    public $bc_settlement_ac_194n;
    public $bc_settlement_account_bank_name;
    public $pendency;
    public $ptm_device;
    public $ptm_device_option = ['1' => "Only Biometric Device", "2" => "Both (Biometric Device and Micro ATM Device)", '3' => "Only Micro ATM Device", "4" => "No device"];
    public $igrs;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['igrs'], 'safe'],
            [['rsetis_center_id', 'rsetis_batch_id', 'rsetis_center_training_id', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'bc_application_id', 'bc_selection_user_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'safe'],
            [['first_name', 'middle_name', 'sur_name', 'division_name', 'district_name', 'block_name', 'gram_panchayat_name'], 'safe'],
            [['mobile_number', 'otp_mobile_no'], 'safe'],
            [['training_status'], 'safe'],
            [['exam_score'], 'safe'],
            [['certificate_code'], 'safe'],
            [['rseti_bank', 'bc_partner_bank', 'batch_size'], 'safe'],
            [['already_group_member'], 'safe'],
            [['pvr_status'], 'safe'],
            [['custom_member_column'], 'safe'],
            [['assign_shg_status'], 'safe'],
            [['bc_bank'], 'safe'],
            [['shg_bank'], 'safe'],
            [['custum_training_status'], 'safe'],
            [['bc_photo_status'], 'safe'],
            [['bc_shg_funds_status'], 'safe'],
            [['pfms_maped_status'], 'safe'],
            [['pan_card_status'], 'safe'],
            [['handheld_machine_status'], 'safe'],
            [['pan_photo_upload'], 'safe'],
            [['bc_shg_map'], 'safe'],
            [['bc_shg_bank'], 'safe'],
            [['onboarding'], 'safe'],
            [['bc_support_funds_received'], 'safe'],
            [['bc_handheld_machine_recived'], 'safe'],
            [['iibf_photo_status'], 'safe'],
            [['bankid'], 'safe'],
            [['custom_education'], 'safe'],
            [['last_app_version'], 'safe'],
            [['urban_shg'], 'safe'],
            [['master_partner_bank_id'], 'safe'],
            [['training_feedback'], 'safe'],
            [['show_blocked'], 'safe'],
            [['bc_beneficiaries_map'], 'safe'],
            [['blocked_bc'], 'safe'],
            [['saheli'], 'safe'],
            [['nretp'], 'safe'],
            [['pin_used'], 'safe'],
            [['division_code'], 'safe'],
            [['shg_confirm_funds_return'], 'safe'],
            [['rishta_access_page'], 'safe'],
            [['aspirational'], 'safe'],
            [['bc_settlement_ac_194n'], 'safe'],
            [['bank_id'], 'safe'],
            [['bank_id_shg'], 'safe'],
            [['bc_operational'], 'safe'],
            [['bc_settlement_account_bank_name'], 'safe'],
            [['pendency'], 'safe'],
            [['ptm_device'], 'safe'],
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
        $query = RsetisBatchParticipants::find();
        $query->joinWith(['participant']);
        $query->andWhere(['!=', 'rsetis_batch_participants.status', -1]);
        if ($columns != NULL) {
            $query->select([$columns]);
        }


        $query->andWhere(['!=', RsetisBatchParticipants::getTableSchema()->fullName . '.status', -1]);
        if ($user_model == NULL) {
            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_STATE_UNIT])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_MANAGER])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_BATCH_CREATOR])) {
                $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
                $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.training_status' => RsetisBatchParticipants::TRAINING_STATUS_PASS]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
                $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.training_status' => RsetisBatchParticipants::TRAINING_STATUS_PASS]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.master_partner_bank_id' => $user_model->master_partner_bank_id]);
                $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.training_status' => RsetisBatchParticipants::TRAINING_STATUS_PASS]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                //$query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.training_status' => RsetisBatchParticipants::TRAINING_STATUS_PASS]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.training_status' => RsetisBatchParticipants::TRAINING_STATUS_PASS]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DMMU])) {
                $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.training_status' => RsetisBatchParticipants::TRAINING_STATUS_PASS]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                //$query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.training_status' => RsetisBatchParticipants::TRAINING_STATUS_PASS]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RBI])) {
                if (in_array($user_model->id, [326328, 326541])) {
                    
                } else {
                    $query->andWhere(['srlm_bc_application.bc_settlement_account_bank_name' => \bc\modules\selection\models\base\GenralModel::rbi_user_bank($user_model->id)]);
                }
                $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.training_status' => RsetisBatchParticipants::TRAINING_STATUS_PASS]);
                $query->andWhere(['srlm_bc_application.bc_operational' => 1]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SMMU])) {
                $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.training_status' => RsetisBatchParticipants::TRAINING_STATUS_PASS]);
            } else {
                $query->where('0=1');
            }
        }
        if ($this->show_blocked)
            $query->andWhere(['srlm_bc_application.blocked' => 0]);
        if ($this->custom_member_column) {
            if ($this->custom_member_column == 1) {
                $query->andWhere(['srlm_bc_application.already_group_member' => 1]);
            } else {
                $query->andWhere(['>', 'srlm_bc_application.already_group_member', 1]);
            }
        }
        if ($this->custom_education != '') {
            if ($this->custom_education == 1) {
                $query->andWhere(['srlm_bc_application.reading_skills' => [1, 2]]);
            }
            if ($this->custom_education == 2) {
                $query->andWhere(['srlm_bc_application.reading_skills' => [3, 4, 5]]);
            }
        }
        if ($this->custum_training_status != '') {
            if ($this->custum_training_status == '31') {
                $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.training_status' => 3]);
                $query->andWhere(['srlm_bc_application.already_certified' => 1]);
            } else {
                $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.training_status' => $this->custum_training_status]);
            }
        }
        if ($this->bc_bank != '') {
            if ($this->bc_bank == '4') {
                $query->andWhere(['srlm_bc_application.bc_bank' => [1, 2, 3]]);
            } else {
                $query->andWhere(['srlm_bc_application.bc_bank' => $this->bc_bank]);
            }
        }
        if ($this->blocked_bc != '') {
            if ($this->blocked_bc == '0') {
                $query->andWhere(['srlm_bc_application.blocked' => $this->blocked_bc]);
            }
            if ($this->blocked_bc == '1') {
                $query->andWhere(['>', 'srlm_bc_application.blocked', 0]);
            }
        }
        if ($this->master_partner_bank_id != '') {
            $query->andWhere(['srlm_bc_application.master_partner_bank_id' => $this->master_partner_bank_id]);
        }
        if ($this->bc_photo_status != '') {
            $query->andWhere(['srlm_bc_application.bc_photo_status' => $this->bc_photo_status]);
        }
        if ($this->training_feedback != '') {
            $query->andWhere(['srlm_bc_application.training_feedback' => $this->training_feedback]);
        }
        if ($this->urban_shg != '') {
            $query->andWhere(['srlm_bc_application.urban_shg' => $this->urban_shg]);
        }
        if ($this->pan_photo_upload != '') {
            $query->andWhere(['srlm_bc_application.pan_photo_upload' => $this->pan_photo_upload]);
        }
        if ($this->iibf_photo_status != '') {
            $query->andWhere(['srlm_bc_application.iibf_photo_status' => $this->iibf_photo_status]);
        }
        if ($this->shg_bank != '') {
            if ($this->shg_bank == '4') {
                $query->andWhere(['srlm_bc_application.shg_bank' => [1, 2, 3]]);
            } else {
                $query->andWhere(['srlm_bc_application.shg_bank' => $this->shg_bank]);
            }
        }
        if ($this->pfms_maped_status != '') {
            if ($this->pfms_maped_status) {
                $query->andWhere(['srlm_bc_application.pfms_maped_status' => $this->pfms_maped_status]);
            } else {
                $query->andWhere(['or',
                    ['=', 'srlm_bc_application.pfms_maped_status', 0],
                    ['IS ', 'srlm_bc_application.pfms_maped_status', new \yii\db\Expression('NULL')],
                ]);
//                $query->andWhere(['srlm_bc_application.pfms_maped_status' => NULL]);
            }
        }
        if ($this->bc_beneficiaries_map != '') {
            if ($this->bc_beneficiaries_map) {
                $query->andWhere(['not', ['srlm_bc_application.bc_beneficiaries_code' => NULL]]);
            } else {
                $query->andWhere(['srlm_bc_application.bc_beneficiaries_code' => NULL]);
            }
        }
        if ($this->bankid != '') {
            if ($this->bankid) {
                $query->andWhere(['not', ['srlm_bc_application.bankidbc' => NULL]]);
            } else {
                $query->andWhere(['or',
                    ['=', 'srlm_bc_application.bankidbc', 0],
                    ['IS ', 'srlm_bc_application.bankidbc', new \yii\db\Expression('NULL')],
                ]);
//                $query->andWhere(['srlm_bc_application.pfms_maped_status' => NULL]);
            }
        }
        if ($this->bc_shg_funds_status != '') {
            if ($this->bc_shg_funds_status) {
                $query->andWhere(['srlm_bc_application.bc_shg_funds_status' => $this->bc_shg_funds_status]);
            } else {
                $query->andWhere(['or',
                    ['=', 'srlm_bc_application.bc_shg_funds_status', 0],
                    ['IS ', 'srlm_bc_application.bc_shg_funds_status', new \yii\db\Expression('NULL')],
                ]);
            }
        }
        if ($this->pan_card_status != '') {
            if ($this->pan_card_status) {
                $query->andWhere(['srlm_bc_application.pan_card_status' => $this->pan_card_status]);
            } else {
                $query->andWhere(['or',
                    ['=', 'srlm_bc_application.pan_card_status', 0],
                    ['IS ', 'srlm_bc_application.pan_card_status', new \yii\db\Expression('NULL')],
                ]);
            }
        }
        if ($this->handheld_machine_status != '') {
            if ($this->handheld_machine_status) {
                $query->andWhere(['srlm_bc_application.handheld_machine_status' => $this->handheld_machine_status]);
            } else {
                $query->andWhere(['or',
                    ['=', 'srlm_bc_application.handheld_machine_status', 0],
                    ['IS ', 'srlm_bc_application.handheld_machine_status', new \yii\db\Expression('NULL')],
                ]);
            }
        }
        if ($this->onboarding != '') {
            if ($this->onboarding) {
                $query->andWhere(['srlm_bc_application.onboarding' => $this->onboarding]);
            } else {
                $query->andWhere(['or',
                    ['=', 'srlm_bc_application.onboarding', 0],
                    ['IS ', 'srlm_bc_application.onboarding', new \yii\db\Expression('NULL')],
                ]);
            }
        }
        if ($this->bc_shg_bank != '') {
            if ($this->bc_shg_bank == '1') {
                $query->andWhere(['or',
                    ['srlm_bc_application.bc_bank' => 1],
                    ['srlm_bc_application.shg_bank' => 1]
                ]);
                $query->andWhere(['not', ['srlm_bc_application.passbook_photo' => null]]);
                $query->andWhere(['not', ['srlm_bc_application.passbook_photo_shg' => null]]);
                $query->andWhere(['not', ['srlm_bc_application.bc_bank' => 3]]);
                $query->andWhere(['not', ['srlm_bc_application.shg_bank' => 3]]);
            }
            if ($this->bc_shg_bank == '2') {
                $query->andWhere(['or',
                    ['srlm_bc_application.bc_bank' => 0],
                    ['srlm_bc_application.shg_bank' => 0]
                ]);
                $query->andWhere(['not', ['srlm_bc_application.bc_bank' => 3]]);
                $query->andWhere(['not', ['srlm_bc_application.shg_bank' => 3]]);
            }
            if ($this->bc_shg_bank == '3') {

                $query->andWhere(['srlm_bc_application.bc_bank' => 2, 'srlm_bc_application.shg_bank' => 2]);
            }
            if ($this->bc_shg_bank == '4') {
                $query->andWhere(['or',
                    ['srlm_bc_application.bc_bank' => 3],
                    ['srlm_bc_application.shg_bank' => 3]
                ]);
            }
            if ($this->bc_shg_bank == '5') {
                $query->andWhere(['not', ['srlm_bc_application.cbo_shg_id' => NULL]]);
                $query->andWhere(['or',
                    ['srlm_bc_application.bc_bank' => 0],
                    ['srlm_bc_application.shg_bank' => 0],
                    ['srlm_bc_application.bc_bank' => 1],
                    ['srlm_bc_application.shg_bank' => 1],
                    ['srlm_bc_application.bc_bank' => 3],
                    ['srlm_bc_application.shg_bank' => 3]
                ]);
            }
        }
        if ($this->bc_support_funds_received != '') {
            if ($this->bc_support_funds_received) {
                $query->andWhere(['srlm_bc_application.bc_support_funds_received' => $this->bc_support_funds_received]);
            } else {
                $query->andWhere(['srlm_bc_application.bc_shg_funds_status' => 1]);
                $query->andWhere(['or',
                    ['=', 'srlm_bc_application.bc_support_funds_received', 0],
                    ['IS ', 'srlm_bc_application.bc_support_funds_received', new \yii\db\Expression('NULL')],
                ]);
            }
        }
        if ($this->bc_handheld_machine_recived != '') {
            if ($this->bc_handheld_machine_recived) {
                $query->andWhere(['srlm_bc_application.bc_handheld_machine_recived' => $this->bc_handheld_machine_recived]);
            } else {
                $query->andWhere(['srlm_bc_application.handheld_machine_status' => 1]);
                $query->andWhere(['srlm_bc_application.bc_shg_funds_status' => 1]);
                $query->andWhere(['or',
                    ['=', 'srlm_bc_application.bc_handheld_machine_recived', 0],
                    ['IS ', 'srlm_bc_application.bc_handheld_machine_recived', new \yii\db\Expression('NULL')],
                ]);
            }
        }
        if ($this->pin_used != '') {

            $query->andWhere(['=', 'srlm_bc_application.pin_used', $this->pin_used]);
        }
        if ($this->bank_id != '') {
            $query->andWhere(['=', 'srlm_bc_application.bank_id', $this->bank_id]);
        }
        if ($this->bc_settlement_account_bank_name != '') {
            $query->andWhere(['=', 'srlm_bc_application.bc_settlement_account_bank_name', $this->bc_settlement_account_bank_name]);
        }
//        if ($this->last_app_version != '') {
//            if ($this->last_app_version == 1) {
//                $query->andWhere(['>=', 'srlm_bc_application.last_app_version', SrlmBcApplication::PIN_APP_VERSION]);
//            }
//            if ($this->last_app_version == 0) {
//                $query->andWhere(['<', 'srlm_bc_application.last_app_version', SrlmBcApplication::PIN_APP_VERSION]);
//            }
//        }
        if ($this->shg_confirm_funds_return != '') {
            if ($this->shg_confirm_funds_return == 1) {
                $query->andWhere(['srlm_bc_application.bc_shg_funds_status' => 1]);
                $query->andWhere(['srlm_bc_application.shg_confirm_funds_return' => 1]);
            } else {
                $query->andWhere(['srlm_bc_application.bc_shg_funds_status' => 1]);
                $query->andWhere(['srlm_bc_application.shg_confirm_funds_return' => [0, 1]]);
            }
        }
        if ($this->pendency != '') {
            if ($this->pendency == 'pvr') {
                $query->andWhere(['srlm_bc_application.pvr_status' => 0]);
            }
            if ($this->pendency == 'bc_shg_assigned') {
                $query->andWhere(['or',
                    ['=', 'srlm_bc_application.cbo_shg_id', 0],
                    ['IS ', 'srlm_bc_application.cbo_shg_id', new \yii\db\Expression('NULL')],
                ]);
                //$query->andWhere(['IS ', 'srlm_bc_application.cbo_shg_id', new \yii\db\Expression('NULL')]);
            }
            if ($this->pendency == 'bc_shg_bank_verified') {
                $query->andWhere(['not', ['srlm_bc_application.cbo_shg_id' => NULL]]);
                $query->andWhere(['or',
                    ['srlm_bc_application.bc_bank' => 0],
                    ['srlm_bc_application.shg_bank' => 0],
                    ['srlm_bc_application.bc_bank' => 1],
                    ['srlm_bc_application.shg_bank' => 1],
                    ['srlm_bc_application.bc_bank' => 3],
                    ['srlm_bc_application.shg_bank' => 3]
                ]);
            }
            if ($this->pendency == 'pfms_mapping') {
                $query->andWhere(['and',
                    ['srlm_bc_application.bc_bank' => 2],
                    ['srlm_bc_application.shg_bank' => 2]
                ]);
                $query->andWhere(['or',
                    ['=', 'srlm_bc_application.pfms_maped_status', 0],
                    ['IS ', 'srlm_bc_application.pfms_maped_status', new \yii\db\Expression('NULL')],
                ]);
            }
            if ($this->pendency == 'bc_shg_support_fund') {
                $query->andWhere(['srlm_bc_application.pfms_maped_status' => 1]);
                $query->andWhere(['or',
                    ['=', 'srlm_bc_application.bc_shg_funds_status', 0],
                    ['IS ', 'srlm_bc_application.bc_shg_funds_status', new \yii\db\Expression('NULL')],
                ]);
            }
            if ($this->pendency == 'handheld_machine') {
                $query->andWhere(['srlm_bc_application.bc_shg_funds_status' => 1]);

                $query->andWhere(['or',
                    ['=', 'srlm_bc_application.handheld_machine_status', 0],
                    ['IS ', 'srlm_bc_application.handheld_machine_status', new \yii\db\Expression('NULL')],
                ]);
            }
            if ($this->pendency == 'operational') {
                $query->andWhere(['srlm_bc_application.bc_operational' => 0]);
                $query->andWhere(['srlm_bc_application.handheld_machine_status' => 1]);
            }
        }
        if ($this->nretp != '') {
            $query->joinWith(['block']);
            $query->andWhere(['master_block.nretp' => $this->nretp]);
        }
        if ($this->aspirational != '') {
            $query->joinWith(['block']);
            $query->andWhere(['master_block.aspirational' => $this->aspirational]);
        }
        if ($this->igrs) {
            $query->andWhere([RsetisBatchParticipants::getTableSchema()->fullName . '.district_code' => \Yii::$app->params['igrs_disricts']]);
        }
        if ($columns != NULL) {
            $query->asArray();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 50 : $pagination],
            'sort' => ['defaultOrder' => ['first_name' => SORT_ASC]],
        ]);
        if (isset($this->already_group_member) and $this->already_group_member != '') {
            $query->joinWith(['participant']);
            $query->andWhere(['srlm_bc_application.already_group_member' => $this->already_group_member]);
        }
        if (isset($this->pvr_status) and $this->pvr_status != '') {
            $query->joinWith(['participant']);
            $query->andWhere(['srlm_bc_application.pvr_status' => $this->pvr_status]);
        }
        if (isset($this->rseti_bank) and $this->rseti_bank != '') {
            $query->joinWith(['rsethileadbank']);
            $query->andWhere(['user_profile.bank_name' => $this->rseti_bank]);
            $query->distinct('relation_user_district.district_code');
        }
        if (isset($this->bc_partner_bank) and $this->bc_partner_bank != '') {
            $query->joinWith(['bcbankpartner']);
            $query->andWhere(['user.id' => $this->bc_partner_bank]);
            $query->distinct('relation_user_district.district_code');
        }
        if ($this->assign_shg_status == '0') {
            $query->andWhere(['srlm_bc_application.cbo_shg_id' => NULL]);
        }
        if ($this->assign_shg_status == '1') {
            $query->andWhere(['not', ['srlm_bc_application.cbo_shg_id' => NULL]]);
        }
        if ($this->bc_shg_map == '1') {
            $query->andWhere(['not', ['srlm_bc_application.cbo_shg_id' => NULL]]);
        }
        if ($this->bc_shg_map == '2') {
            $query->andWhere(['srlm_bc_application.your_group_name' => NULL]);
        }
        if ($this->bc_operational != '') {
            $query->andWhere(['srlm_bc_application.bc_operational' => $this->bc_operational]);
        }
        if ($this->bc_shg_map == '3') {
            $query->andWhere(['srlm_bc_application.cbo_shg_id' => NULL]);
            //$query->andWhere(['not', ['srlm_bc_application.your_group_name' => NULL]]);
        }
        if ($this->division_code) {
            $query->andWhere(['srlm_bc_application.division_code' => $this->division_code]);
        }
//        var_dump($query->prepare(\Yii::$app->dbbc->queryBuilder)->createCommand()->rawSql);exit;
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            RsetisBatchParticipants::getTableSchema()->fullName . '.id' => $this->id,
            RsetisBatchParticipants::getTableSchema()->fullName . '.rsetis_center_id' => $this->rsetis_center_id,
            RsetisBatchParticipants::getTableSchema()->fullName . '.rsetis_batch_id' => $this->rsetis_batch_id,
            RsetisBatchParticipants::getTableSchema()->fullName . '.rsetis_center_training_id' => $this->rsetis_center_training_id,
            RsetisBatchParticipants::getTableSchema()->fullName . '.bc_application_id' => $this->bc_application_id,
            RsetisBatchParticipants::getTableSchema()->fullName . '.bc_selection_user_id' => $this->bc_selection_user_id,
            RsetisBatchParticipants::getTableSchema()->fullName . '.created_by' => $this->created_by,
            RsetisBatchParticipants::getTableSchema()->fullName . '.updated_by' => $this->updated_by,
            RsetisBatchParticipants::getTableSchema()->fullName . '.created_at' => $this->created_at,
            RsetisBatchParticipants::getTableSchema()->fullName . '.updated_at' => $this->updated_at,
            RsetisBatchParticipants::getTableSchema()->fullName . '.status' => $this->status,
            RsetisBatchParticipants::getTableSchema()->fullName . '.training_status' => $this->training_status,
            RsetisBatchParticipants::getTableSchema()->fullName . '.exam_score' => $this->exam_score,
            RsetisBatchParticipants::getTableSchema()->fullName . '.district_code' => $this->district_code,
            RsetisBatchParticipants::getTableSchema()->fullName . '.block_code' => $this->block_code,
            RsetisBatchParticipants::getTableSchema()->fullName . '.gram_panchayat_code' => $this->gram_panchayat_code,
        ]);
        $query->andFilterWhere(['like', RsetisBatchParticipants::getTableSchema()->fullName . '.otp_mobile_no', $this->otp_mobile_no]);
        return $dataProvider;
    }
}
