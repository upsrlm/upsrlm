<?php

namespace bc\modules\selection\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\selection\models\SrlmBcApplication6;
use common\models\master\MasterRole;

/**
 * SrlmBcApplication6Search represents the model behind the search form of `bc\modules\selection\models\SrlmBcApplication6`.
 */
class SrlmBcApplication6Search extends SrlmBcApplication6 {

    public $age_group;
    public $singleapplication;
    public static $coll_district = 'district_code';
    public static $coll_block = 'block_code';
    public static $coll_gram_panchayat = 'gram_panchayat_code';
    public static $coll_village = 'village_code';
    public $col_view_temp;
    public $col_send_temp;
    public $custom_member_column;
    public $assign_shg_status;
    public $blocked_bc;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'gender', 'age', 'cast', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'reading_skills', 'phone_type', 'what_else_with_mobile1', 'what_else_with_mobile2', 'what_else_with_mobile3', 'what_else_with_mobile4', 'what_else_with_mobile5', 'whats_app_number', 'vechicle_drive1', 'vechicle_drive2', 'vechicle_drive3', 'vechicle_drive4', 'vechicle_drive5', 'vechicle_drive6', 'marital_status', 'house_member_details1', 'house_member_details2', 'house_member_details3', 'future_scope1', 'future_scope2', 'future_scope3', 'future_scope4', 'future_scope5', 'future_scope6', 'future_scope7', 'future_scope8', 'future_scope9', 'future_scope10', 'future_scope11', 'future_scope12', 'future_scope13', 'opportunities_for_livelihood1', 'opportunities_for_livelihood2', 'opportunities_for_livelihood3', 'opportunities_for_livelihood4', 'opportunities_for_livelihood5', 'opportunities_for_livelihood6', 'opportunities_for_livelihood7', 'opportunities_for_livelihood8', 'opportunities_for_livelihood9', 'opportunities_for_livelihood10', 'planning_intervention1', 'planning_intervention2', 'planning_intervention3', 'planning_intervention4', 'planning_intervention5', 'planning_intervention6', 'immediate_aspiration1', 'immediate_aspiration2', 'immediate_aspiration3', 'immediate_aspiration4', 'immediate_aspiration5', 'immediate_aspiration6', 'which_program_your_group_formed', 'thought_of_forming_group', 'try_towards_group_formation1', 'try_towards_group_formation2', 'try_towards_group_formation3', 'try_towards_group_formation4', 'try_towards_group_formation5', 'try_towards_group_formation6', 'try_towards_group_formation7', 'try_towards_group_formation8', 'leadership_name_index', 'role_in_group1', 'role_in_group2', 'role_in_group3', 'role_in_group4', 'role_in_group5', 'role_in_group6', 'role_in_group7', 'role_in_group8', 'why_did_you_get_elected1', 'why_did_you_get_elected2', 'why_did_you_get_elected3', 'why_did_you_get_elected4', 'why_did_you_get_elected5', 'why_did_you_get_elected6', 'why_did_you_get_elected7', 'why_did_you_get_elected8', 'why_did_you_get_elected9', 'if_you_were_a_member_of_a_self_help_group1', 'if_you_were_a_member_of_a_self_help_group2', 'if_you_were_a_member_of_a_self_help_group3', 'if_you_were_a_member_of_a_self_help_group4', 'if_you_were_a_member_of_a_self_help_group5', 'if_you_were_a_member_of_a_self_help_group6', 'if_you_were_a_member_of_a_self_help_group7', 'if_you_were_a_member_of_a_self_help_group8', 'if_you_were_a_member_of_a_self_help_group9', 'active_members_position1', 'active_members_position2', 'belongingness_position1', 'belongingness_position2', 'awareness_position1', 'awareness_position2', 'member_who_contact_in_other_group_name1', 'member_who_contact_in_other_group_position1', 'member_who_contact_in_other_group_position2', 'demanded_group_member_position1', 'demanded_group_member_position2', 'capable_fast_pace', 'why_demanded1', 'why_demanded2', 'why_demanded3', 'why_demanded4', 'why_demanded5', 'why_demanded6', 'if_you_have_group_members_what_are_they', 'capable_fast_pace_member_number', 'his_perception1', 'his_perception2', 'his_perception3', 'his_perception4', 'his_perception5', 'his_perception6', 'his_perception7', 'his_perception8', 'what_could_you_do_if_you_were_in_a_group1', 'what_could_you_do_if_you_were_in_a_group2', 'what_could_you_do_if_you_were_in_a_group3', 'what_could_you_do_if_you_were_in_a_group4', 'what_could_you_do_if_you_were_in_a_group5', 'what_could_you_do_if_you_were_in_a_group6', 'what_could_you_do_if_you_were_in_a_group7', 'what_could_you_do_if_you_were_in_a_group8', 'what_could_you_do_if_you_were_in_a_group9', 'most_contribute_index', 'group_culture', 'provision_in_the_group_as_voluntary', 'entrepreneurial_index', 'economic_status', 'afraid_unknown_rules_index1', 'afraid_unknown_rules_index2', 'concept_of_setting_up_new_heights_index', 'livelihood_opportunity_for_another_member_index1', 'livelihood_opportunity_for_another_member_index2', 'negotiate_best_index1', 'negotiate_best_index2', 'which_member_can_talk_advantages_index1', 'which_member_can_talk_advantages_index2', 'can_read_write_hindi', 'confirtable_in_english', 'recognize_english_hindi', 'can_add_substract_multiply', 'who_maintain_account_index', 'choose_other_meaning1', 'choose_other_meaning2', 'choose_other_meaning3', 'choose_other_meaning4', 'choose_other_meaning5', 'same_to_same_word1', 'same_to_same_word2', 'same_to_same_word3', 'english_to_hindi1', 'english_to_hindi2', 'english_to_hindi3', 'english_to_hindi4', 'english_to_hindi5', 'percentage_option1', 'percentage_option2', 'percentage_option3', 'percentage_option4', 'percentage_option5', 'option_decision1', 'option_decision2', 'option_decision3', 'option_decision4', 'option_decision5', 'mobile_use_experience', 'whose_mobile_you_using', 'need_help_to_fill_form', 'already_worked', 'own_mobile', 'own_mobile_means1', 'own_mobile_means2', 'own_mobile_means3', 'own_mobile_means4', 'own_mobile_means5', 'own_mobile_means6', 'own_mobile_means7', 'own_mobile_means8', 'method_used_for_ledger_account1', 'method_used_for_ledger_account2', 'method_used_for_ledger_account3', 'method_used_for_ledger_account4', 'method_used_for_ledger_account5', 'method_used_for_ledger_account6', 'need_training1', 'need_training2', 'need_training3', 'need_training4', 'need_training5', 'form_number', 'srlm_bc_selection_app_detail_id', 'srlm_bc_selection_user_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'form_status', 'status', 'call1'], 'integer'],
            [['form_uuid', 'first_name', 'middle_name', 'sur_name', 'district_name', 'block_name', 'gram_panchayat_name', 'village_name', 'hamlet', 'aadhar_number', 'guardian_name', 'mobile_number', 'other_occupation', 'your_group_name', 'leadership_name', 'active_members_name1', 'active_members_name2', 'belongingness_name1', 'belongingness_name2', 'awareness_name1', 'awareness_name2', 'member_who_contact_in_other_group_name2', 'demanded_group_member_name1', 'demanded_group_member_name2', 'capable_fast_pace_member_name', 'most_contribute_name', 'entrepreneurial', 'afraid_unknown_rules1', 'afraid_unknown_rules2', 'concept_of_setting_up_new_heights', 'livelihood_opportunity_for_another_member1', 'livelihood_opportunity_for_another_member2', 'negotiate_best1', 'negotiate_best2', 'which_member_can_talk_advantages1', 'which_member_can_talk_advantages2', 'who_maintain_account', 'no_of_people_using_phone', 'profile_photo', 'aadhar_front_photo', 'aadhar_back_photo', 'gps', 'gps_accuracy', 'form_start_date', 'form1_date_time', 'form2_date_time', 'form3_date_time', 'form4_date_time', 'form5_date_time'], 'safe'],
            [['sec1', 'sec2', 'sec3', 'sec4', 'sec5', 'over_all', 'over_all_per', 'q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10', 'q11', 'q12', 'q13', 'q14', 'q15', 'q16', 'q17', 'q18', 'q19', 'q20', 'q21', 'q22', 'q23', 'q24', 'q25', 'q26', 'q27', 'q28', 'q29', 'q30', 'q31', 'q32', 'q33', 'q34', 'q35', 'q36', 'q37', 'q38', 'q39', 'q40', 'q41', 'q42', 'q43', 'q44', 'q45', 'q46', 'q47', 'q48', 'q49', 'q50', 'q51', 'q52', 'q53', 'q54', 'q55', 'q56', 'q57', 'q58', 'q59', 'q60', 'q61', 'q62', 'q63', 'q64', 'q65', 'q66', 'q67', 'q68', 'already_group_member', 'singleapplication', 'division_code'], 'safe'],
            [['age_group', 'cast', 'reading_skills', 'phone_type', 'marital_status', 'already_group_member', 'highest_score_in_gp'], 'safe'],
            [['call1', 'call1_by', 'call1_datetime'], 'safe'],
            [['training_id', 'training_center_id', 'training_batch_id', 'training_status'], 'safe'],
            [['call_by_rsetis'], 'safe'],
            [['call_by_rsetis', 'call_rsetis_datetime'], 'safe'],
            [['col_view_temp', 'col_send_temp'], 'safe'],
            [['viewtemp1', 'viewtemp2', 'viewtemp3', 'viewtemp4', 'viewtemp5', 'viewtemp6', 'viewtemp7', 'viewtemp8', 'viewtemp9', 'viewtemp10'], 'safe'],
            [['bc_photo_status'], 'safe'],
            [['user_id'], 'safe'],
            [['custom_member_column'], 'safe'],
            [['assign_shg_status'], 'safe'],
            [['bc_bank'], 'safe'],
            [['shg_bank'], 'safe'],
            [['bc_shg_funds_status'], 'safe'],
            [['pfms_maped_status'], 'safe'],
            [['pan_card_status', 'pan_card_status_by', 'handheld_machine_status', 'handheld_machine_by'], 'integer'],
            [['pan_card_status_date', 'handheld_machine_date'], 'safe'],
            [['urban_shg'], 'safe'],
            [['master_partner_bank_id'], 'safe'],
            [['blocked'], 'safe'],
            [['blocked_bc'], 'safe'],
            [['last_app_version'], 'safe'],
            [['form_data_validate'], 'safe'],
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
        $query = SrlmBcApplication6::find();
        if ($columns != NULL) {
            $query->select([$columns]);
        }
        $query->andWhere(['!=', 'srlm_bc_application6.status', 0]);
        $query->andWhere(['!=', 'srlm_bc_application6.status', SrlmBcApplication6::DELETE]);

        // add conditions that should always apply here
        if ($columns != NULL) {
            $query->asArray();
        }
        if ($user_model == NULL) {
//            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {

                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {

                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {

                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {

//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {

//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_YOUNG_PROFESSIONAL])) {

                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DIVISIONAL_COMMISSIONER])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                //$query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } else {
                $query->where('0=1');
            }
            if (isset($this->col_view_temp) and $this->col_view_temp != '') {
                $query->andWhere([$this->col_view_temp => 2]);
            }
            if (isset($this->col_send_temp) and $this->col_send_temp != '') {
                $query->andWhere([$this->col_send_temp => [1, 2]]);
            }
            if ($this->custom_member_column) {
                if ($this->custom_member_column == 1) {
                    $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.already_group_member' => 1]);
                } else {
                    $query->andWhere(['>', SrlmBcApplication6::getTableSchema()->fullName . '.already_group_member', 1]);
                }
            }
            if ($this->assign_shg_status == '0') {
                $query->andWhere(['srlm_bc_application.cbo_shg_id' => NULL]);
            }
            if ($this->assign_shg_status == '1') {
                $query->andWhere(['not', ['srlm_bc_application.cbo_shg_id' => NULL]]);
            }
        }
        if ($this->age_group != '') {
            if ($this->age_group == '0') {
                $query->andWhere(['between', 'srlm_bc_application6.age', '0', '17']);
            } elseif ($this->age_group == '1') {
                $query->andWhere(['between', 'srlm_bc_application6.age', '18', '25']);
            } else if ($this->age_group == '2') {
                $query->andWhere(['between', 'srlm_bc_application6.age', '26', '32']);
            } else if ($this->age_group == '3') {
                $query->andWhere(['between', 'srlm_bc_application6.age', '33', '40']);
            } else if ($this->age_group == '4') {
                $query->andWhere(['between', 'srlm_bc_application6.age', '41', '50']);
            } else if ($this->age_group == '5') {
                $query->andWhere(['between', 'srlm_bc_application6.age', '51', '200']);
            }
        }
        if ($this->blocked_bc != '') {
            if ($this->blocked_bc == '0') {
                $query->andWhere(['srlm_bc_application6.blocked' => $this->blocked_bc]);
            }
            if ($this->blocked_bc == '1') {
                $query->andWhere(['>', 'srlm_bc_application6.blocked', 0]);
            }
        }
        if ($this->last_app_version != '') {
            if ($this->last_app_version == 1) {
                $query->andWhere(['>=', 'srlm_bc_application6.last_app_version', SrlmBcApplication6::PIN_APP_VERSION]);
            }
            if ($this->last_app_version == 0) {
                $query->andWhere(['<', 'srlm_bc_application6.last_app_version', SrlmBcApplication6::PIN_APP_VERSION]);
            }
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
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
            'srlm_bc_application6.id' => $this->id,
            'srlm_bc_application6.gender' => $this->gender,
            'srlm_bc_application6.age' => $this->age,
            'srlm_bc_application6.cast' => $this->cast,
            'srlm_bc_application6.division_code' => $this->division_code,
            'srlm_bc_application6.district_code' => $this->district_code,
            'srlm_bc_application6.block_code' => $this->block_code,
            'srlm_bc_application6.gram_panchayat_code' => $this->gram_panchayat_code,
            'srlm_bc_application6.village_code' => $this->village_code,
            'srlm_bc_application6.reading_skills' => $this->reading_skills,
            'srlm_bc_application6.phone_type' => $this->phone_type,
            'srlm_bc_application6.what_else_with_mobile1' => $this->what_else_with_mobile1,
            'srlm_bc_application6.what_else_with_mobile2' => $this->what_else_with_mobile2,
            'srlm_bc_application6.what_else_with_mobile3' => $this->what_else_with_mobile3,
            'srlm_bc_application6.what_else_with_mobile4' => $this->what_else_with_mobile4,
            'srlm_bc_application6.what_else_with_mobile5' => $this->what_else_with_mobile5,
            'srlm_bc_application6.whats_app_number' => $this->whats_app_number,
            'srlm_bc_application6.vechicle_drive1' => $this->vechicle_drive1,
            'srlm_bc_application6.vechicle_drive2' => $this->vechicle_drive2,
            'srlm_bc_application6.vechicle_drive3' => $this->vechicle_drive3,
            'srlm_bc_application6.vechicle_drive4' => $this->vechicle_drive4,
            'srlm_bc_application6.vechicle_drive5' => $this->vechicle_drive5,
            'srlm_bc_application6.vechicle_drive6' => $this->vechicle_drive6,
            'srlm_bc_application6.marital_status' => $this->marital_status,
            'srlm_bc_application6.house_member_details1' => $this->house_member_details1,
            'srlm_bc_application6.house_member_details2' => $this->house_member_details2,
            'srlm_bc_application6.house_member_details3' => $this->house_member_details3,
            'srlm_bc_application6.future_scope1' => $this->future_scope1,
            'srlm_bc_application6.future_scope2' => $this->future_scope2,
            'srlm_bc_application6.future_scope3' => $this->future_scope3,
            'srlm_bc_application6.future_scope4' => $this->future_scope4,
            'srlm_bc_application6.future_scope5' => $this->future_scope5,
            'srlm_bc_application6.future_scope6' => $this->future_scope6,
            'srlm_bc_application6.future_scope7' => $this->future_scope7,
            'srlm_bc_application6.future_scope8' => $this->future_scope8,
            'srlm_bc_application6.future_scope9' => $this->future_scope9,
            'srlm_bc_application6.future_scope10' => $this->future_scope10,
            'srlm_bc_application6.future_scope11' => $this->future_scope11,
            'srlm_bc_application6.future_scope12' => $this->future_scope12,
            'srlm_bc_application6.future_scope13' => $this->future_scope13,
            'srlm_bc_application6.opportunities_for_livelihood1' => $this->opportunities_for_livelihood1,
            'srlm_bc_application6.opportunities_for_livelihood2' => $this->opportunities_for_livelihood2,
            'srlm_bc_application6.opportunities_for_livelihood3' => $this->opportunities_for_livelihood3,
            'srlm_bc_application6.opportunities_for_livelihood4' => $this->opportunities_for_livelihood4,
            'srlm_bc_application6.opportunities_for_livelihood5' => $this->opportunities_for_livelihood5,
            'srlm_bc_application6.opportunities_for_livelihood6' => $this->opportunities_for_livelihood6,
            'srlm_bc_application6.opportunities_for_livelihood7' => $this->opportunities_for_livelihood7,
            'srlm_bc_application6.opportunities_for_livelihood8' => $this->opportunities_for_livelihood8,
            'srlm_bc_application6.opportunities_for_livelihood9' => $this->opportunities_for_livelihood9,
            'opportunities_for_livelihood10' => $this->opportunities_for_livelihood10,
            'planning_intervention1' => $this->planning_intervention1,
            'planning_intervention2' => $this->planning_intervention2,
            'planning_intervention3' => $this->planning_intervention3,
            'planning_intervention4' => $this->planning_intervention4,
            'planning_intervention5' => $this->planning_intervention5,
            'planning_intervention6' => $this->planning_intervention6,
            'immediate_aspiration1' => $this->immediate_aspiration1,
            'immediate_aspiration2' => $this->immediate_aspiration2,
            'immediate_aspiration3' => $this->immediate_aspiration3,
            'immediate_aspiration4' => $this->immediate_aspiration4,
            'immediate_aspiration5' => $this->immediate_aspiration5,
            'immediate_aspiration6' => $this->immediate_aspiration6,
            'already_group_member' => $this->already_group_member,
            'which_program_your_group_formed' => $this->which_program_your_group_formed,
            'thought_of_forming_group' => $this->thought_of_forming_group,
            'try_towards_group_formation1' => $this->try_towards_group_formation1,
            'try_towards_group_formation2' => $this->try_towards_group_formation2,
            'try_towards_group_formation3' => $this->try_towards_group_formation3,
            'try_towards_group_formation4' => $this->try_towards_group_formation4,
            'try_towards_group_formation5' => $this->try_towards_group_formation5,
            'try_towards_group_formation6' => $this->try_towards_group_formation6,
            'try_towards_group_formation7' => $this->try_towards_group_formation7,
            'try_towards_group_formation8' => $this->try_towards_group_formation8,
            'leadership_name_index' => $this->leadership_name_index,
            'role_in_group1' => $this->role_in_group1,
            'role_in_group2' => $this->role_in_group2,
            'role_in_group3' => $this->role_in_group3,
            'role_in_group4' => $this->role_in_group4,
            'role_in_group5' => $this->role_in_group5,
            'role_in_group6' => $this->role_in_group6,
            'role_in_group7' => $this->role_in_group7,
            'role_in_group8' => $this->role_in_group8,
            'why_did_you_get_elected1' => $this->why_did_you_get_elected1,
            'why_did_you_get_elected2' => $this->why_did_you_get_elected2,
            'why_did_you_get_elected3' => $this->why_did_you_get_elected3,
            'why_did_you_get_elected4' => $this->why_did_you_get_elected4,
            'why_did_you_get_elected5' => $this->why_did_you_get_elected5,
            'why_did_you_get_elected6' => $this->why_did_you_get_elected6,
            'why_did_you_get_elected7' => $this->why_did_you_get_elected7,
            'why_did_you_get_elected8' => $this->why_did_you_get_elected8,
            'why_did_you_get_elected9' => $this->why_did_you_get_elected9,
            'if_you_were_a_member_of_a_self_help_group1' => $this->if_you_were_a_member_of_a_self_help_group1,
            'if_you_were_a_member_of_a_self_help_group2' => $this->if_you_were_a_member_of_a_self_help_group2,
            'if_you_were_a_member_of_a_self_help_group3' => $this->if_you_were_a_member_of_a_self_help_group3,
            'if_you_were_a_member_of_a_self_help_group4' => $this->if_you_were_a_member_of_a_self_help_group4,
            'if_you_were_a_member_of_a_self_help_group5' => $this->if_you_were_a_member_of_a_self_help_group5,
            'if_you_were_a_member_of_a_self_help_group6' => $this->if_you_were_a_member_of_a_self_help_group6,
            'if_you_were_a_member_of_a_self_help_group7' => $this->if_you_were_a_member_of_a_self_help_group7,
            'if_you_were_a_member_of_a_self_help_group8' => $this->if_you_were_a_member_of_a_self_help_group8,
            'if_you_were_a_member_of_a_self_help_group9' => $this->if_you_were_a_member_of_a_self_help_group9,
            'active_members_position1' => $this->active_members_position1,
            'active_members_position2' => $this->active_members_position2,
            'belongingness_position1' => $this->belongingness_position1,
            'belongingness_position2' => $this->belongingness_position2,
            'awareness_position1' => $this->awareness_position1,
            'awareness_position2' => $this->awareness_position2,
            'member_who_contact_in_other_group_name1' => $this->member_who_contact_in_other_group_name1,
            'member_who_contact_in_other_group_position1' => $this->member_who_contact_in_other_group_position1,
            'member_who_contact_in_other_group_position2' => $this->member_who_contact_in_other_group_position2,
            'demanded_group_member_position1' => $this->demanded_group_member_position1,
            'demanded_group_member_position2' => $this->demanded_group_member_position2,
            'capable_fast_pace' => $this->capable_fast_pace,
            'why_demanded1' => $this->why_demanded1,
            'why_demanded2' => $this->why_demanded2,
            'why_demanded3' => $this->why_demanded3,
            'why_demanded4' => $this->why_demanded4,
            'why_demanded5' => $this->why_demanded5,
            'why_demanded6' => $this->why_demanded6,
            'if_you_have_group_members_what_are_they' => $this->if_you_have_group_members_what_are_they,
            'capable_fast_pace_member_number' => $this->capable_fast_pace_member_number,
            'his_perception1' => $this->his_perception1,
            'his_perception2' => $this->his_perception2,
            'his_perception3' => $this->his_perception3,
            'his_perception4' => $this->his_perception4,
            'his_perception5' => $this->his_perception5,
            'his_perception6' => $this->his_perception6,
            'his_perception7' => $this->his_perception7,
            'his_perception8' => $this->his_perception8,
            'what_could_you_do_if_you_were_in_a_group1' => $this->what_could_you_do_if_you_were_in_a_group1,
            'what_could_you_do_if_you_were_in_a_group2' => $this->what_could_you_do_if_you_were_in_a_group2,
            'what_could_you_do_if_you_were_in_a_group3' => $this->what_could_you_do_if_you_were_in_a_group3,
            'what_could_you_do_if_you_were_in_a_group4' => $this->what_could_you_do_if_you_were_in_a_group4,
            'what_could_you_do_if_you_were_in_a_group5' => $this->what_could_you_do_if_you_were_in_a_group5,
            'what_could_you_do_if_you_were_in_a_group6' => $this->what_could_you_do_if_you_were_in_a_group6,
            'what_could_you_do_if_you_were_in_a_group7' => $this->what_could_you_do_if_you_were_in_a_group7,
            'what_could_you_do_if_you_were_in_a_group8' => $this->what_could_you_do_if_you_were_in_a_group8,
            'what_could_you_do_if_you_were_in_a_group9' => $this->what_could_you_do_if_you_were_in_a_group9,
            'most_contribute_index' => $this->most_contribute_index,
            'group_culture' => $this->group_culture,
            'provision_in_the_group_as_voluntary' => $this->provision_in_the_group_as_voluntary,
            'entrepreneurial_index' => $this->entrepreneurial_index,
            'economic_status' => $this->economic_status,
            'afraid_unknown_rules_index1' => $this->afraid_unknown_rules_index1,
            'afraid_unknown_rules_index2' => $this->afraid_unknown_rules_index2,
            'concept_of_setting_up_new_heights_index' => $this->concept_of_setting_up_new_heights_index,
            'livelihood_opportunity_for_another_member_index1' => $this->livelihood_opportunity_for_another_member_index1,
            'livelihood_opportunity_for_another_member_index2' => $this->livelihood_opportunity_for_another_member_index2,
            'negotiate_best_index1' => $this->negotiate_best_index1,
            'negotiate_best_index2' => $this->negotiate_best_index2,
            'which_member_can_talk_advantages_index1' => $this->which_member_can_talk_advantages_index1,
            'which_member_can_talk_advantages_index2' => $this->which_member_can_talk_advantages_index2,
            'can_read_write_hindi' => $this->can_read_write_hindi,
            'confirtable_in_english' => $this->confirtable_in_english,
            'recognize_english_hindi' => $this->recognize_english_hindi,
            'can_add_substract_multiply' => $this->can_add_substract_multiply,
            'who_maintain_account_index' => $this->who_maintain_account_index,
            'choose_other_meaning1' => $this->choose_other_meaning1,
            'choose_other_meaning2' => $this->choose_other_meaning2,
            'choose_other_meaning3' => $this->choose_other_meaning3,
            'choose_other_meaning4' => $this->choose_other_meaning4,
            'choose_other_meaning5' => $this->choose_other_meaning5,
            'same_to_same_word1' => $this->same_to_same_word1,
            'same_to_same_word2' => $this->same_to_same_word2,
            'same_to_same_word3' => $this->same_to_same_word3,
            'english_to_hindi1' => $this->english_to_hindi1,
            'english_to_hindi2' => $this->english_to_hindi2,
            'english_to_hindi3' => $this->english_to_hindi3,
            'english_to_hindi4' => $this->english_to_hindi4,
            'english_to_hindi5' => $this->english_to_hindi5,
            'percentage_option1' => $this->percentage_option1,
            'percentage_option2' => $this->percentage_option2,
            'percentage_option3' => $this->percentage_option3,
            'percentage_option4' => $this->percentage_option4,
            'percentage_option5' => $this->percentage_option5,
            'option_decision1' => $this->option_decision1,
            'option_decision2' => $this->option_decision2,
            'option_decision3' => $this->option_decision3,
            'option_decision4' => $this->option_decision4,
            'option_decision5' => $this->option_decision5,
            'mobile_use_experience' => $this->mobile_use_experience,
            'whose_mobile_you_using' => $this->whose_mobile_you_using,
            'need_help_to_fill_form' => $this->need_help_to_fill_form,
            'already_worked' => $this->already_worked,
            'own_mobile' => $this->own_mobile,
            'own_mobile_means1' => $this->own_mobile_means1,
            'own_mobile_means2' => $this->own_mobile_means2,
            'own_mobile_means3' => $this->own_mobile_means3,
            'own_mobile_means4' => $this->own_mobile_means4,
            'own_mobile_means5' => $this->own_mobile_means5,
            'own_mobile_means6' => $this->own_mobile_means6,
            'own_mobile_means7' => $this->own_mobile_means7,
            'own_mobile_means8' => $this->own_mobile_means8,
            'method_used_for_ledger_account1' => $this->method_used_for_ledger_account1,
            'method_used_for_ledger_account2' => $this->method_used_for_ledger_account2,
            'method_used_for_ledger_account3' => $this->method_used_for_ledger_account3,
            'method_used_for_ledger_account4' => $this->method_used_for_ledger_account4,
            'method_used_for_ledger_account5' => $this->method_used_for_ledger_account5,
            'method_used_for_ledger_account6' => $this->method_used_for_ledger_account6,
            'need_training1' => $this->need_training1,
            'need_training2' => $this->need_training2,
            'need_training3' => $this->need_training3,
            'need_training4' => $this->need_training4,
            'need_training5' => $this->need_training5,
            'form_start_date' => $this->form_start_date,
            'form1_date_time' => $this->form1_date_time,
            'form2_date_time' => $this->form2_date_time,
            'form3_date_time' => $this->form3_date_time,
            'form4_date_time' => $this->form4_date_time,
            'form5_date_time' => $this->form5_date_time,
            'form_number' => $this->form_number,
            'srlm_bc_selection_app_detail_id' => $this->srlm_bc_selection_app_detail_id,
            'srlm_bc_selection_user_id' => $this->srlm_bc_selection_user_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'form_status' => $this->form_status,
            'status' => $this->status,
            'highest_score_in_gp' => $this->highest_score_in_gp,
            'training_id' => $this->training_id,
            'training_center_id' => $this->training_center_id,
            'training_batch_id' => $this->training_batch_id,
            'training_status' => $this->training_status,
            'call1' => $this->call1,
            'srlm_bc_application6.bc_photo_status' => $this->bc_photo_status,
            'srlm_bc_application6.pfms_maped_status' => $this->pfms_maped_status,
            'srlm_bc_application6.bc_shg_funds_status' => $this->bc_shg_funds_status,
            'srlm_bc_application6.pan_card_status' => $this->pan_card_status,
            'srlm_bc_application6.handheld_machine_status' => $this->handheld_machine_status,
            'srlm_bc_application6.urban_shg' => $this->urban_shg,
            'srlm_bc_application6.master_partner_bank_id' => $this->master_partner_bank_id,
            'srlm_bc_application6.blocked' => $this->blocked,
            'srlm_bc_application6.form_data_validate' => $this->form_data_validate
        ]);

        $query->andFilterWhere(['like', 'form_uuid', $this->form_uuid])
                ->andFilterWhere(['like', 'first_name', $this->first_name])
                ->andFilterWhere(['like', 'middle_name', $this->middle_name])
                ->andFilterWhere(['like', 'sur_name', $this->sur_name])
                ->andFilterWhere(['like', 'district_name', $this->district_name])
                ->andFilterWhere(['like', 'block_name', $this->block_name])
                ->andFilterWhere(['like', 'gram_panchayat_name', $this->gram_panchayat_name])
                ->andFilterWhere(['like', 'village_name', $this->village_name])
                ->andFilterWhere(['like', 'hamlet', $this->hamlet])
                ->andFilterWhere(['like', 'aadhar_number', $this->aadhar_number])
                ->andFilterWhere(['like', 'guardian_name', $this->guardian_name])
                ->andFilterWhere(['like', 'mobile_number', $this->mobile_number])
                ->andFilterWhere(['like', 'other_occupation', $this->other_occupation])
                ->andFilterWhere(['like', 'your_group_name', $this->your_group_name])
                ->andFilterWhere(['like', 'leadership_name', $this->leadership_name])
                ->andFilterWhere(['like', 'active_members_name1', $this->active_members_name1])
                ->andFilterWhere(['like', 'active_members_name2', $this->active_members_name2])
                ->andFilterWhere(['like', 'belongingness_name1', $this->belongingness_name1])
                ->andFilterWhere(['like', 'belongingness_name2', $this->belongingness_name2])
                ->andFilterWhere(['like', 'awareness_name1', $this->awareness_name1])
                ->andFilterWhere(['like', 'awareness_name2', $this->awareness_name2])
                ->andFilterWhere(['like', 'member_who_contact_in_other_group_name2', $this->member_who_contact_in_other_group_name2])
                ->andFilterWhere(['like', 'demanded_group_member_name1', $this->demanded_group_member_name1])
                ->andFilterWhere(['like', 'demanded_group_member_name2', $this->demanded_group_member_name2])
                ->andFilterWhere(['like', 'capable_fast_pace_member_name', $this->capable_fast_pace_member_name])
                ->andFilterWhere(['like', 'most_contribute_name', $this->most_contribute_name])
                ->andFilterWhere(['like', 'entrepreneurial', $this->entrepreneurial])
                ->andFilterWhere(['like', 'afraid_unknown_rules1', $this->afraid_unknown_rules1])
                ->andFilterWhere(['like', 'afraid_unknown_rules2', $this->afraid_unknown_rules2])
                ->andFilterWhere(['like', 'concept_of_setting_up_new_heights', $this->concept_of_setting_up_new_heights])
                ->andFilterWhere(['like', 'livelihood_opportunity_for_another_member1', $this->livelihood_opportunity_for_another_member1])
                ->andFilterWhere(['like', 'livelihood_opportunity_for_another_member2', $this->livelihood_opportunity_for_another_member2])
                ->andFilterWhere(['like', 'negotiate_best1', $this->negotiate_best1])
                ->andFilterWhere(['like', 'negotiate_best2', $this->negotiate_best2])
                ->andFilterWhere(['like', 'which_member_can_talk_advantages1', $this->which_member_can_talk_advantages1])
                ->andFilterWhere(['like', 'which_member_can_talk_advantages2', $this->which_member_can_talk_advantages2])
                ->andFilterWhere(['like', 'who_maintain_account', $this->who_maintain_account])
                ->andFilterWhere(['like', 'no_of_people_using_phone', $this->no_of_people_using_phone])
                ->andFilterWhere(['like', 'profile_photo', $this->profile_photo])
                ->andFilterWhere(['like', 'aadhar_front_photo', $this->aadhar_front_photo])
                ->andFilterWhere(['like', 'aadhar_back_photo', $this->aadhar_back_photo])
                ->andFilterWhere(['like', 'gps', $this->gps])
                ->andFilterWhere(['like', 'gps_accuracy', $this->gps_accuracy]);

        return $dataProvider;
    }

    public function searchc($params, $user_model = null, $pagination = true, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = SrlmBcApplication6::find();
        if ($columns != NULL) {
            $query->select([$columns]);
        }
        $query->andWhere(['!=', 'srlm_bc_application6.status', 0]);
        $query->andWhere(['!=', 'srlm_bc_application6.status', SrlmBcApplication::DELETE]);
        $query->andWhere(['is', 'srlm_bc_application6.created_by', new \yii\db\Expression('null')]);
        // add conditions that should always apply here
        if ($columns != NULL) {
            $query->asArray();
        }
        if ($user_model == NULL) {
//            $query->where('0=1');
        } else {
            if (in_array($user_model->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_CALL_CENTER_ADMIN])) {
                
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BACKEND_OPERATOR])) {

                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FI_MF])) {

                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SPM_FINANCE])) {

                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_VIEWER])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_MD])) {

//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_MSC])) {

//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BC_VIEWER])) {
//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
//                $query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_STATE_UNIT, MasterRole::ROLE_YOUNG_PROFESSIONAL])) {

                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_UPSRLM_RSETI_ANCHOR])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_DISTRICT_UNIT])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_RSETIS_NODAL_BANK])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            }elseif (in_array($user_model->role, [MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CORPORATE_BCS])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.division_code' => \yii\helpers\ArrayHelper::getColumn($user_model->division, 'division_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DM])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_SUPPORT_UNIT])) {
                //$query->andWhere([SrlmBcApplication::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_DC_NRLM])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_CDO])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.district_code' => \yii\helpers\ArrayHelper::getColumn($user_model->districts, 'district_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } elseif (in_array($user_model->role, [MasterRole::ROLE_BMMU])) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.block_code' => \yii\helpers\ArrayHelper::getColumn($user_model->blocks, 'block_code')]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.status' => SrlmBcApplication6::STATUS_PROVISIONAL]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.form_number' => SrlmBcApplication6::FORM_STATUS_PART_4]);
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.gender' => 2]);
            } else {
                $query->where('0=1');
            }
            if (isset($this->col_view_temp) and $this->col_view_temp != '') {
                $query->andWhere([$this->col_view_temp => 2]);
            }
            if (isset($this->col_send_temp) and $this->col_send_temp != '') {
                $query->andWhere([$this->col_send_temp => [1, 2]]);
            }
            if ($this->custom_member_column) {
                if ($this->custom_member_column == 1) {
                    $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.already_group_member' => 1]);
                } else {
                    $query->andWhere(['>', SrlmBcApplication6::getTableSchema()->fullName . '.already_group_member', 1]);
                }
            }
            if ($this->assign_shg_status == '0') {
                $query->andWhere(['srlm_bc_application6.cbo_shg_id' => NULL]);
            }
            if ($this->assign_shg_status == '1') {
                $query->andWhere(['not', ['srlm_bc_application6.cbo_shg_id' => NULL]]);
            }
        }
        if ($this->age_group != '') {
            if ($this->age_group == '0') {
                $query->andWhere(['between', 'srlm_bc_application6.age', '0', '17']);
            } elseif ($this->age_group == '1') {
                $query->andWhere(['between', 'srlm_bc_application6.age', '18', '25']);
            } else if ($this->age_group == '2') {
                $query->andWhere(['between', 'srlm_bc_application6.age', '26', '32']);
            } else if ($this->age_group == '3') {
                $query->andWhere(['between', 'srlm_bc_application6.age', '33', '40']);
            } else if ($this->age_group == '4') {
                $query->andWhere(['between', 'srlm_bc_application6.age', '41', '50']);
            } else if ($this->age_group == '5') {
                $query->andWhere(['between', 'srlm_bc_application6.age', '51', '200']);
            }
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'srlm_bc_application6.id' => $this->id,
            'srlm_bc_application6.gender' => $this->gender,
            'srlm_bc_application6.age' => $this->age,
            'srlm_bc_application6.cast' => $this->cast,
            'srlm_bc_application6.division_code' => $this->division_code,
            'srlm_bc_application6.district_code' => $this->district_code,
            'srlm_bc_application6.block_code' => $this->block_code,
            'srlm_bc_application6.gram_panchayat_code' => $this->gram_panchayat_code,
            'srlm_bc_application6.village_code' => $this->village_code,
            'srlm_bc_application6.reading_skills' => $this->reading_skills,
            'srlm_bc_application6.phone_type' => $this->phone_type,
            'srlm_bc_application6.what_else_with_mobile1' => $this->what_else_with_mobile1,
            'srlm_bc_application6.what_else_with_mobile2' => $this->what_else_with_mobile2,
            'srlm_bc_application6.what_else_with_mobile3' => $this->what_else_with_mobile3,
            'srlm_bc_application6.what_else_with_mobile4' => $this->what_else_with_mobile4,
            'srlm_bc_application6.what_else_with_mobile5' => $this->what_else_with_mobile5,
            'srlm_bc_application6.whats_app_number' => $this->whats_app_number,
            'srlm_bc_application6.vechicle_drive1' => $this->vechicle_drive1,
            'srlm_bc_application6.vechicle_drive2' => $this->vechicle_drive2,
            'srlm_bc_application6.vechicle_drive3' => $this->vechicle_drive3,
            'srlm_bc_application6.vechicle_drive4' => $this->vechicle_drive4,
            'srlm_bc_application6.vechicle_drive5' => $this->vechicle_drive5,
            'srlm_bc_application6.vechicle_drive6' => $this->vechicle_drive6,
            'srlm_bc_application6.marital_status' => $this->marital_status,
            'srlm_bc_application6.house_member_details1' => $this->house_member_details1,
            'srlm_bc_application6.house_member_details2' => $this->house_member_details2,
            'srlm_bc_application6.house_member_details3' => $this->house_member_details3,
            'srlm_bc_application6.future_scope1' => $this->future_scope1,
            'srlm_bc_application6.future_scope2' => $this->future_scope2,
            'srlm_bc_application6.future_scope3' => $this->future_scope3,
            'srlm_bc_application6.future_scope4' => $this->future_scope4,
            'srlm_bc_application6.future_scope5' => $this->future_scope5,
            'srlm_bc_application6.future_scope6' => $this->future_scope6,
            'srlm_bc_application6.future_scope7' => $this->future_scope7,
            'srlm_bc_application6.future_scope8' => $this->future_scope8,
            'srlm_bc_application6.future_scope9' => $this->future_scope9,
            'srlm_bc_application6.future_scope10' => $this->future_scope10,
            'srlm_bc_application6.future_scope11' => $this->future_scope11,
            'srlm_bc_application6.future_scope12' => $this->future_scope12,
            'srlm_bc_application6.future_scope13' => $this->future_scope13,
            'srlm_bc_application6.opportunities_for_livelihood1' => $this->opportunities_for_livelihood1,
            'srlm_bc_application6.opportunities_for_livelihood2' => $this->opportunities_for_livelihood2,
            'srlm_bc_application6.opportunities_for_livelihood3' => $this->opportunities_for_livelihood3,
            'srlm_bc_application6.opportunities_for_livelihood4' => $this->opportunities_for_livelihood4,
            'srlm_bc_application6.opportunities_for_livelihood5' => $this->opportunities_for_livelihood5,
            'srlm_bc_application6.opportunities_for_livelihood6' => $this->opportunities_for_livelihood6,
            'srlm_bc_application6.opportunities_for_livelihood7' => $this->opportunities_for_livelihood7,
            'srlm_bc_application6.opportunities_for_livelihood8' => $this->opportunities_for_livelihood8,
            'srlm_bc_application6.opportunities_for_livelihood9' => $this->opportunities_for_livelihood9,
            'opportunities_for_livelihood10' => $this->opportunities_for_livelihood10,
            'planning_intervention1' => $this->planning_intervention1,
            'planning_intervention2' => $this->planning_intervention2,
            'planning_intervention3' => $this->planning_intervention3,
            'planning_intervention4' => $this->planning_intervention4,
            'planning_intervention5' => $this->planning_intervention5,
            'planning_intervention6' => $this->planning_intervention6,
            'immediate_aspiration1' => $this->immediate_aspiration1,
            'immediate_aspiration2' => $this->immediate_aspiration2,
            'immediate_aspiration3' => $this->immediate_aspiration3,
            'immediate_aspiration4' => $this->immediate_aspiration4,
            'immediate_aspiration5' => $this->immediate_aspiration5,
            'immediate_aspiration6' => $this->immediate_aspiration6,
            'already_group_member' => $this->already_group_member,
            'which_program_your_group_formed' => $this->which_program_your_group_formed,
            'thought_of_forming_group' => $this->thought_of_forming_group,
            'try_towards_group_formation1' => $this->try_towards_group_formation1,
            'try_towards_group_formation2' => $this->try_towards_group_formation2,
            'try_towards_group_formation3' => $this->try_towards_group_formation3,
            'try_towards_group_formation4' => $this->try_towards_group_formation4,
            'try_towards_group_formation5' => $this->try_towards_group_formation5,
            'try_towards_group_formation6' => $this->try_towards_group_formation6,
            'try_towards_group_formation7' => $this->try_towards_group_formation7,
            'try_towards_group_formation8' => $this->try_towards_group_formation8,
            'leadership_name_index' => $this->leadership_name_index,
            'role_in_group1' => $this->role_in_group1,
            'role_in_group2' => $this->role_in_group2,
            'role_in_group3' => $this->role_in_group3,
            'role_in_group4' => $this->role_in_group4,
            'role_in_group5' => $this->role_in_group5,
            'role_in_group6' => $this->role_in_group6,
            'role_in_group7' => $this->role_in_group7,
            'role_in_group8' => $this->role_in_group8,
            'why_did_you_get_elected1' => $this->why_did_you_get_elected1,
            'why_did_you_get_elected2' => $this->why_did_you_get_elected2,
            'why_did_you_get_elected3' => $this->why_did_you_get_elected3,
            'why_did_you_get_elected4' => $this->why_did_you_get_elected4,
            'why_did_you_get_elected5' => $this->why_did_you_get_elected5,
            'why_did_you_get_elected6' => $this->why_did_you_get_elected6,
            'why_did_you_get_elected7' => $this->why_did_you_get_elected7,
            'why_did_you_get_elected8' => $this->why_did_you_get_elected8,
            'why_did_you_get_elected9' => $this->why_did_you_get_elected9,
            'if_you_were_a_member_of_a_self_help_group1' => $this->if_you_were_a_member_of_a_self_help_group1,
            'if_you_were_a_member_of_a_self_help_group2' => $this->if_you_were_a_member_of_a_self_help_group2,
            'if_you_were_a_member_of_a_self_help_group3' => $this->if_you_were_a_member_of_a_self_help_group3,
            'if_you_were_a_member_of_a_self_help_group4' => $this->if_you_were_a_member_of_a_self_help_group4,
            'if_you_were_a_member_of_a_self_help_group5' => $this->if_you_were_a_member_of_a_self_help_group5,
            'if_you_were_a_member_of_a_self_help_group6' => $this->if_you_were_a_member_of_a_self_help_group6,
            'if_you_were_a_member_of_a_self_help_group7' => $this->if_you_were_a_member_of_a_self_help_group7,
            'if_you_were_a_member_of_a_self_help_group8' => $this->if_you_were_a_member_of_a_self_help_group8,
            'if_you_were_a_member_of_a_self_help_group9' => $this->if_you_were_a_member_of_a_self_help_group9,
            'active_members_position1' => $this->active_members_position1,
            'active_members_position2' => $this->active_members_position2,
            'belongingness_position1' => $this->belongingness_position1,
            'belongingness_position2' => $this->belongingness_position2,
            'awareness_position1' => $this->awareness_position1,
            'awareness_position2' => $this->awareness_position2,
            'member_who_contact_in_other_group_name1' => $this->member_who_contact_in_other_group_name1,
            'member_who_contact_in_other_group_position1' => $this->member_who_contact_in_other_group_position1,
            'member_who_contact_in_other_group_position2' => $this->member_who_contact_in_other_group_position2,
            'demanded_group_member_position1' => $this->demanded_group_member_position1,
            'demanded_group_member_position2' => $this->demanded_group_member_position2,
            'capable_fast_pace' => $this->capable_fast_pace,
            'why_demanded1' => $this->why_demanded1,
            'why_demanded2' => $this->why_demanded2,
            'why_demanded3' => $this->why_demanded3,
            'why_demanded4' => $this->why_demanded4,
            'why_demanded5' => $this->why_demanded5,
            'why_demanded6' => $this->why_demanded6,
            'if_you_have_group_members_what_are_they' => $this->if_you_have_group_members_what_are_they,
            'capable_fast_pace_member_number' => $this->capable_fast_pace_member_number,
            'his_perception1' => $this->his_perception1,
            'his_perception2' => $this->his_perception2,
            'his_perception3' => $this->his_perception3,
            'his_perception4' => $this->his_perception4,
            'his_perception5' => $this->his_perception5,
            'his_perception6' => $this->his_perception6,
            'his_perception7' => $this->his_perception7,
            'his_perception8' => $this->his_perception8,
            'what_could_you_do_if_you_were_in_a_group1' => $this->what_could_you_do_if_you_were_in_a_group1,
            'what_could_you_do_if_you_were_in_a_group2' => $this->what_could_you_do_if_you_were_in_a_group2,
            'what_could_you_do_if_you_were_in_a_group3' => $this->what_could_you_do_if_you_were_in_a_group3,
            'what_could_you_do_if_you_were_in_a_group4' => $this->what_could_you_do_if_you_were_in_a_group4,
            'what_could_you_do_if_you_were_in_a_group5' => $this->what_could_you_do_if_you_were_in_a_group5,
            'what_could_you_do_if_you_were_in_a_group6' => $this->what_could_you_do_if_you_were_in_a_group6,
            'what_could_you_do_if_you_were_in_a_group7' => $this->what_could_you_do_if_you_were_in_a_group7,
            'what_could_you_do_if_you_were_in_a_group8' => $this->what_could_you_do_if_you_were_in_a_group8,
            'what_could_you_do_if_you_were_in_a_group9' => $this->what_could_you_do_if_you_were_in_a_group9,
            'most_contribute_index' => $this->most_contribute_index,
            'group_culture' => $this->group_culture,
            'provision_in_the_group_as_voluntary' => $this->provision_in_the_group_as_voluntary,
            'entrepreneurial_index' => $this->entrepreneurial_index,
            'economic_status' => $this->economic_status,
            'afraid_unknown_rules_index1' => $this->afraid_unknown_rules_index1,
            'afraid_unknown_rules_index2' => $this->afraid_unknown_rules_index2,
            'concept_of_setting_up_new_heights_index' => $this->concept_of_setting_up_new_heights_index,
            'livelihood_opportunity_for_another_member_index1' => $this->livelihood_opportunity_for_another_member_index1,
            'livelihood_opportunity_for_another_member_index2' => $this->livelihood_opportunity_for_another_member_index2,
            'negotiate_best_index1' => $this->negotiate_best_index1,
            'negotiate_best_index2' => $this->negotiate_best_index2,
            'which_member_can_talk_advantages_index1' => $this->which_member_can_talk_advantages_index1,
            'which_member_can_talk_advantages_index2' => $this->which_member_can_talk_advantages_index2,
            'can_read_write_hindi' => $this->can_read_write_hindi,
            'confirtable_in_english' => $this->confirtable_in_english,
            'recognize_english_hindi' => $this->recognize_english_hindi,
            'can_add_substract_multiply' => $this->can_add_substract_multiply,
            'who_maintain_account_index' => $this->who_maintain_account_index,
            'choose_other_meaning1' => $this->choose_other_meaning1,
            'choose_other_meaning2' => $this->choose_other_meaning2,
            'choose_other_meaning3' => $this->choose_other_meaning3,
            'choose_other_meaning4' => $this->choose_other_meaning4,
            'choose_other_meaning5' => $this->choose_other_meaning5,
            'same_to_same_word1' => $this->same_to_same_word1,
            'same_to_same_word2' => $this->same_to_same_word2,
            'same_to_same_word3' => $this->same_to_same_word3,
            'english_to_hindi1' => $this->english_to_hindi1,
            'english_to_hindi2' => $this->english_to_hindi2,
            'english_to_hindi3' => $this->english_to_hindi3,
            'english_to_hindi4' => $this->english_to_hindi4,
            'english_to_hindi5' => $this->english_to_hindi5,
            'percentage_option1' => $this->percentage_option1,
            'percentage_option2' => $this->percentage_option2,
            'percentage_option3' => $this->percentage_option3,
            'percentage_option4' => $this->percentage_option4,
            'percentage_option5' => $this->percentage_option5,
            'option_decision1' => $this->option_decision1,
            'option_decision2' => $this->option_decision2,
            'option_decision3' => $this->option_decision3,
            'option_decision4' => $this->option_decision4,
            'option_decision5' => $this->option_decision5,
            'mobile_use_experience' => $this->mobile_use_experience,
            'whose_mobile_you_using' => $this->whose_mobile_you_using,
            'need_help_to_fill_form' => $this->need_help_to_fill_form,
            'already_worked' => $this->already_worked,
            'own_mobile' => $this->own_mobile,
            'own_mobile_means1' => $this->own_mobile_means1,
            'own_mobile_means2' => $this->own_mobile_means2,
            'own_mobile_means3' => $this->own_mobile_means3,
            'own_mobile_means4' => $this->own_mobile_means4,
            'own_mobile_means5' => $this->own_mobile_means5,
            'own_mobile_means6' => $this->own_mobile_means6,
            'own_mobile_means7' => $this->own_mobile_means7,
            'own_mobile_means8' => $this->own_mobile_means8,
            'method_used_for_ledger_account1' => $this->method_used_for_ledger_account1,
            'method_used_for_ledger_account2' => $this->method_used_for_ledger_account2,
            'method_used_for_ledger_account3' => $this->method_used_for_ledger_account3,
            'method_used_for_ledger_account4' => $this->method_used_for_ledger_account4,
            'method_used_for_ledger_account5' => $this->method_used_for_ledger_account5,
            'method_used_for_ledger_account6' => $this->method_used_for_ledger_account6,
            'need_training1' => $this->need_training1,
            'need_training2' => $this->need_training2,
            'need_training3' => $this->need_training3,
            'need_training4' => $this->need_training4,
            'need_training5' => $this->need_training5,
            'form_start_date' => $this->form_start_date,
            'form1_date_time' => $this->form1_date_time,
            'form2_date_time' => $this->form2_date_time,
            'form3_date_time' => $this->form3_date_time,
            'form4_date_time' => $this->form4_date_time,
            'form5_date_time' => $this->form5_date_time,
            'form_number' => $this->form_number,
            'srlm_bc_selection_app_detail_id' => $this->srlm_bc_selection_app_detail_id,
            'srlm_bc_selection_user_id' => $this->srlm_bc_selection_user_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'form_status' => $this->form_status,
            'status' => $this->status,
            'highest_score_in_gp' => $this->highest_score_in_gp,
            'training_id' => $this->training_id,
            'training_center_id' => $this->training_center_id,
            'training_batch_id' => $this->training_batch_id,
            'training_status' => $this->training_status,
            'call1' => $this->call1,
            'srlm_bc_application6.bc_photo_status' => $this->bc_photo_status,
            'srlm_bc_application6.pfms_maped_status' => $this->pfms_maped_status,
            'srlm_bc_application6.bc_shg_funds_status' => $this->bc_shg_funds_status,
            'srlm_bc_application6.pan_card_status' => $this->pan_card_status,
            'srlm_bc_application6.handheld_machine_status' => $this->handheld_machine_status,
            'srlm_bc_application6.urban_shg' => $this->urban_shg,
            'srlm_bc_application6.master_partner_bank_id' => $this->master_partner_bank_id,
            'srlm_bc_application6.blocked' => $this->blocked,
            'srlm_bc_application6.form_data_validate' => $this->form_data_validate
        ]);

        $query->andFilterWhere(['like', 'form_uuid', $this->form_uuid])
                ->andFilterWhere(['like', 'first_name', $this->first_name])
                ->andFilterWhere(['like', 'middle_name', $this->middle_name])
                ->andFilterWhere(['like', 'sur_name', $this->sur_name])
                ->andFilterWhere(['like', 'district_name', $this->district_name])
                ->andFilterWhere(['like', 'block_name', $this->block_name])
                ->andFilterWhere(['like', 'gram_panchayat_name', $this->gram_panchayat_name])
                ->andFilterWhere(['like', 'village_name', $this->village_name])
                ->andFilterWhere(['like', 'hamlet', $this->hamlet])
                ->andFilterWhere(['like', 'aadhar_number', $this->aadhar_number])
                ->andFilterWhere(['like', 'guardian_name', $this->guardian_name])
                ->andFilterWhere(['like', 'mobile_number', $this->mobile_number])
                ->andFilterWhere(['like', 'other_occupation', $this->other_occupation])
                ->andFilterWhere(['like', 'your_group_name', $this->your_group_name])
                ->andFilterWhere(['like', 'leadership_name', $this->leadership_name])
                ->andFilterWhere(['like', 'active_members_name1', $this->active_members_name1])
                ->andFilterWhere(['like', 'active_members_name2', $this->active_members_name2])
                ->andFilterWhere(['like', 'belongingness_name1', $this->belongingness_name1])
                ->andFilterWhere(['like', 'belongingness_name2', $this->belongingness_name2])
                ->andFilterWhere(['like', 'awareness_name1', $this->awareness_name1])
                ->andFilterWhere(['like', 'awareness_name2', $this->awareness_name2])
                ->andFilterWhere(['like', 'member_who_contact_in_other_group_name2', $this->member_who_contact_in_other_group_name2])
                ->andFilterWhere(['like', 'demanded_group_member_name1', $this->demanded_group_member_name1])
                ->andFilterWhere(['like', 'demanded_group_member_name2', $this->demanded_group_member_name2])
                ->andFilterWhere(['like', 'capable_fast_pace_member_name', $this->capable_fast_pace_member_name])
                ->andFilterWhere(['like', 'most_contribute_name', $this->most_contribute_name])
                ->andFilterWhere(['like', 'entrepreneurial', $this->entrepreneurial])
                ->andFilterWhere(['like', 'afraid_unknown_rules1', $this->afraid_unknown_rules1])
                ->andFilterWhere(['like', 'afraid_unknown_rules2', $this->afraid_unknown_rules2])
                ->andFilterWhere(['like', 'concept_of_setting_up_new_heights', $this->concept_of_setting_up_new_heights])
                ->andFilterWhere(['like', 'livelihood_opportunity_for_another_member1', $this->livelihood_opportunity_for_another_member1])
                ->andFilterWhere(['like', 'livelihood_opportunity_for_another_member2', $this->livelihood_opportunity_for_another_member2])
                ->andFilterWhere(['like', 'negotiate_best1', $this->negotiate_best1])
                ->andFilterWhere(['like', 'negotiate_best2', $this->negotiate_best2])
                ->andFilterWhere(['like', 'which_member_can_talk_advantages1', $this->which_member_can_talk_advantages1])
                ->andFilterWhere(['like', 'which_member_can_talk_advantages2', $this->which_member_can_talk_advantages2])
                ->andFilterWhere(['like', 'who_maintain_account', $this->who_maintain_account])
                ->andFilterWhere(['like', 'no_of_people_using_phone', $this->no_of_people_using_phone])
                ->andFilterWhere(['like', 'profile_photo', $this->profile_photo])
                ->andFilterWhere(['like', 'aadhar_front_photo', $this->aadhar_front_photo])
                ->andFilterWhere(['like', 'aadhar_back_photo', $this->aadhar_back_photo])
                ->andFilterWhere(['like', 'gps', $this->gps])
                ->andFilterWhere(['like', 'gps_accuracy', $this->gps_accuracy]);

        return $dataProvider;
    }

    public function report($params, $user_model = null, $pagination = true, $distinct_column = null, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = SrlmBcApplication6::find();
        if ($this->singleapplication) {
            $query->joinWith(['gpdetail']);
            $query->andWhere(['=', 'master_gram_panchayat_detail_bc.fourth_complete', 1]);
        }
        if ($columns != NULL) {
            $query->select([$columns]);
        }
        $query->andWhere(['!=', 'srlm_bc_application6.status', 0]);
        $query->andWhere(['!=', 'srlm_bc_application6.status', SrlmBcApplication6::DELETE]);
        $query->andWhere(['srlm_bc_application6.form_number' => 6]);
        $query->andWhere(['srlm_bc_application6.gender' => 2]);
        if ($distinct_column != null) {
            if ($distinct_column == static::$coll_district) {

                $query->select(['srlm_bc_application6.district_code', 'srlm_bc_application6.district_name', 'COUNT(id) AS application_count', 'COUNT(gram_panchayat_code) AS application_gp_count']);
                $query->groupBy('srlm_bc_application6.district_code');
                $query->orderBy('srlm_bc_application6.district_name asc');
            }
            if ($distinct_column == static::$coll_gram_panchayat) {
                $query->select(['srlm_bc_application6.gram_panchayat_code', 'srlm_bc_application6.gram_panchayat_name', 'COUNT(id) AS application_count', 'COUNT(gram_panchayat_code) AS application_gp_count']);
                $query->groupBy('srlm_bc_application6.gram_panchayat_code');
                $query->orderBy('srlm_bc_application6.gram_panchayat_name asc');
            }
            if ($distinct_column == static::$coll_block) {

                $query->select(['srlm_bc_application6.block_code', 'srlm_bc_application6.block_name', 'COUNT(id) AS application_count', 'COUNT(gram_panchayat_code) AS application_gp_count']);
                $query->groupBy('srlm_bc_application6.block_code');
                $query->orderBy('srlm_bc_application6.block_name asc');
            }
        }
        if ($this->age_group != '') {
            if ($this->age_group == '0') {
                $query->andWhere(['between', 'srlm_bc_application6.age', '0', '17']);
            } elseif ($this->age_group == '1') {
                $query->andWhere(['between', 'srlm_bc_application6.age', '18', '25']);
            } else if ($this->age_group == '2') {
                $query->andWhere(['between', 'srlm_bc_application6.age', '26', '32']);
            } else if ($this->age_group == '3') {
                $query->andWhere(['between', 'srlm_bc_application6.age', '33', '40']);
            } else if ($this->age_group == '4') {
                $query->andWhere(['between', 'srlm_bc_application6.age', '41', '50']);
            } else if ($this->age_group == '5') {
                $query->andWhere(['between', 'srlm_bc_application6.age', '51', '200']);
            }
        }
        if ($this->custom_member_column) {
            if ($this->custom_member_column == 1) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.already_group_member' => 1]);
            } else {
                $query->andWhere(['>', SrlmBcApplication6::getTableSchema()->fullName . '.already_group_member', 1]);
            }
        }
        if ($this->assign_shg_status == '0') {
            $query->andWhere(['srlm_bc_application6.cbo_shg_id' => NULL]);
        }
        if ($this->assign_shg_status == '1') {
            $query->andWhere(['not', ['srlm_bc_application6.cbo_shg_id' => NULL]]);
        }
        if ($columns != NULL) {
            $query->asArray();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
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
            'srlm_bc_application6.id' => $this->id,
            'srlm_bc_application6.gender' => $this->gender,
            'srlm_bc_application6.age' => $this->age,
            'srlm_bc_application6.cast' => $this->cast,
            'srlm_bc_application6.division_code' => $this->division_code,
            'srlm_bc_application6.district_code' => $this->district_code,
            'srlm_bc_application6.block_code' => $this->block_code,
            'srlm_bc_application6.gram_panchayat_code' => $this->gram_panchayat_code,
            'srlm_bc_application6.village_code' => $this->village_code,
            'srlm_bc_application6.reading_skills' => $this->reading_skills,
            'srlm_bc_application6.phone_type' => $this->phone_type,
            'srlm_bc_application6.whats_app_number' => $this->whats_app_number,
            'srlm_bc_application6.marital_status' => $this->marital_status,
            'srlm_bc_application6.already_group_member' => $this->already_group_member,
            'srlm_bc_application6.own_mobile' => $this->own_mobile,
            'srlm_bc_application6.form_number' => $this->form_number,
            'srlm_bc_application6.srlm_bc_selection_user_id' => $this->srlm_bc_selection_user_id,
            'srlm_bc_application6.form_status' => $this->form_status,
            'srlm_bc_application6.status' => $this->status,
            'srlm_bc_application6.highest_score_in_gp' => $this->highest_score_in_gp,
            'srlm_bc_application6.bc_photo_status' => $this->bc_photo_status,
            'srlm_bc_application6.pfms_maped_status' => $this->pfms_maped_status,
            'srlm_bc_application6.bc_shg_funds_status' => $this->bc_shg_funds_status,
            'srlm_bc_application6.pan_card_status' => $this->pan_card_status,
            'srlm_bc_application6.handheld_machine_status' => $this->handheld_machine_status,
            'srlm_bc_application6.call1' => $this->call1,
            'srlm_bc_application6.urban_shg' => $this->urban_shg,
            'srlm_bc_application6.master_partner_bank_id' => $this->master_partner_bank_id,
            'srlm_bc_application6.blocked' => $this->blocked,
            'srlm_bc_application6.form_data_validate' => $this->form_data_validate
        ]);

        $query->andFilterWhere(['like', 'srlm_bc_application6.form_uuid', $this->form_uuid])
                ->andFilterWhere(['like', 'srlm_bc_application6.first_name', $this->first_name])
                ->andFilterWhere(['like', 'srlm_bc_application6.middle_name', $this->middle_name])
                ->andFilterWhere(['like', 'srlm_bc_application6.sur_name', $this->sur_name])
                ->andFilterWhere(['like', 'srlm_bc_application6.district_name', $this->district_name])
                ->andFilterWhere(['like', 'srlm_bc_application6.block_name', $this->block_name])
                ->andFilterWhere(['like', 'srlm_bc_application6.gram_panchayat_name', $this->gram_panchayat_name])
                ->andFilterWhere(['like', 'srlm_bc_application6.village_name', $this->village_name])
                ->andFilterWhere(['like', 'srlm_bc_application6.hamlet', $this->hamlet])
                ->andFilterWhere(['like', 'srlm_bc_application6.aadhar_number', $this->aadhar_number])
                ->andFilterWhere(['like', 'srlm_bc_application6.guardian_name', $this->guardian_name])
                ->andFilterWhere(['like', 'srlm_bc_application6.mobile_number', $this->mobile_number])
                ->andFilterWhere(['like', 'srlm_bc_application6.gps', $this->gps])
                ->andFilterWhere(['like', 'srlm_bc_application6.gps_accuracy', $this->gps_accuracy]);

        return $dataProvider;
    }

    public function verify($params, $user_model = null, $pagination = true, $distinct_column = null, $columns = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $query = SrlmBcApplication6::find();
        if ($this->singleapplication) {
            $query->joinWith(['gp']);
            $query->andWhere(['=', 'master_gram_panchayat.second_complete', 1]);
        }
        if ($columns != NULL) {
            $query->select([$columns]);
        }
        $query->andWhere(['=', 'srlm_bc_application6.status', "2"]);
        //$query->andWhere(['=', 'srlm_bc_application6.status', "5"]);
        //$query->andWhere(['!=', 'srlm_bc_application6.status', SrlmBcApplication::DELETE]);
        $query->andWhere(['srlm_bc_application6.form_number' => 6]);
        $query->andWhere(['srlm_bc_application6.gender' => 2]);
        if ($distinct_column != null) {
            if ($distinct_column == static::$coll_district) {

                $query->select(['srlm_bc_application6.district_code', 'srlm_bc_application6.district_name', 'COUNT(id) AS application_count', 'COUNT(gram_panchayat_code) AS application_gp_count']);
                $query->groupBy('srlm_bc_application6.district_code');
                $query->orderBy('srlm_bc_application6.district_name asc');
            }
            if ($distinct_column == static::$coll_gram_panchayat) {
                $query->select(['srlm_bc_application6.gram_panchayat_code', 'srlm_bc_application6.gram_panchayat_name', 'COUNT(id) AS application_count', 'COUNT(gram_panchayat_code) AS application_gp_count']);
                $query->groupBy('srlm_bc_application6.gram_panchayat_code');
                $query->orderBy('srlm_bc_application6.gram_panchayat_name asc');
            }
            if ($distinct_column == static::$coll_block) {

                $query->select(['srlm_bc_application6.block_code', 'srlm_bc_application6.block_name', 'COUNT(id) AS application_count', 'COUNT(gram_panchayat_code) AS application_gp_count']);
                $query->groupBy('srlm_bc_application6.block_code');
                $query->orderBy('srlm_bc_application6.block_name asc');
            }
        }
        if ($this->age_group == '1') {
            $query->andWhere(['between', 'srlm_bc_application6.age', '18', '25']);
        } else if ($this->age_group == '2') {
            $query->andWhere(['between', 'srlm_bc_application6.age', '26', '32']);
        } else if ($this->age_group == '3') {
            $query->andWhere(['between', 'srlm_bc_application6.age', '33', '40']);
        } else if ($this->age_group == '4') {
            $query->andWhere(['between', 'srlm_bc_application6.age', '41', '50']);
        } else if ($this->age_group == '5') {
            $query->andWhere(['between', 'srlm_bc_application6.age', '51', '200']);
        }

        if ($this->custom_member_column) {
            if ($this->custom_member_column == 1) {
                $query->andWhere([SrlmBcApplication6::getTableSchema()->fullName . '.already_group_member' => 1]);
            } else {
                $query->andWhere(['>', SrlmBcApplication6::getTableSchema()->fullName . '.already_group_member', 1]);
            }
        }
        if ($this->assign_shg_status == '0') {
            $query->andWhere(['srlm_bc_application6.cbo_shg_id' => NULL]);
        }
        if ($this->assign_shg_status == '1') {
            $query->andWhere(['not', ['srlm_bc_application6.cbo_shg_id' => NULL]]);
        }
        if ($columns != NULL) {
            $query->asArray();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
            'sort' => ['defaultOrder' => ['gram_panchayat_name' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'srlm_bc_application6.id' => $this->id,
            'srlm_bc_application6.gender' => $this->gender,
            'srlm_bc_application6.age' => $this->age,
            'srlm_bc_application6.cast' => $this->cast,
            'srlm_bc_application6.district_code' => $this->district_code,
            'srlm_bc_application6.block_code' => $this->block_code,
            'srlm_bc_application6.gram_panchayat_code' => $this->gram_panchayat_code,
            'srlm_bc_application6.village_code' => $this->village_code,
            'srlm_bc_application6.reading_skills' => $this->reading_skills,
            'srlm_bc_application6.phone_type' => $this->phone_type,
            'srlm_bc_application6.whats_app_number' => $this->whats_app_number,
            'srlm_bc_application6.marital_status' => $this->marital_status,
            'srlm_bc_application6.already_group_member' => $this->already_group_member,
            'srlm_bc_application6.own_mobile' => $this->own_mobile,
            'srlm_bc_application6.form_number' => $this->form_number,
            'srlm_bc_application6.srlm_bc_selection_user_id' => $this->srlm_bc_selection_user_id,
            'srlm_bc_application6.form_status' => $this->form_status,
            'srlm_bc_application6.status' => $this->status,
            'srlm_bc_application6.highest_score_in_gp' => $this->highest_score_in_gp,
            'srlm_bc_application6.bc_photo_status' => $this->bc_photo_status,
            'srlm_bc_application6.pfms_maped_status' => $this->pfms_maped_status,
            'srlm_bc_application6.bc_shg_funds_status' => $this->bc_shg_funds_status,
            'srlm_bc_application6.pan_card_status' => $this->pan_card_status,
            'srlm_bc_application6.handheld_machine_status' => $this->handheld_machine_status,
            'srlm_bc_application6.master_partner_bank_id' => $this->master_partner_bank_id,
            'srlm_bc_application6.blocked' => $this->blocked,
            'srlm_bc_application6.form_data_validate' => $this->form_data_validate
        ]);

        $query->andFilterWhere(['like', 'srlm_bc_application6.form_uuid', $this->form_uuid])
                ->andFilterWhere(['like', 'srlm_bc_application6.first_name', $this->first_name])
                ->andFilterWhere(['like', 'srlm_bc_application6.middle_name', $this->middle_name])
                ->andFilterWhere(['like', 'srlm_bc_application6.sur_name', $this->sur_name])
                ->andFilterWhere(['like', 'srlm_bc_application6.district_name', $this->district_name])
                ->andFilterWhere(['like', 'srlm_bc_application6.block_name', $this->block_name])
                ->andFilterWhere(['like', 'srlm_bc_application6.gram_panchayat_name', $this->gram_panchayat_name])
                ->andFilterWhere(['like', 'srlm_bc_application6.village_name', $this->village_name])
                ->andFilterWhere(['like', 'srlm_bc_application6.hamlet', $this->hamlet])
                ->andFilterWhere(['like', 'srlm_bc_application6.aadhar_number', $this->aadhar_number])
                ->andFilterWhere(['like', 'srlm_bc_application6.guardian_name', $this->guardian_name])
                ->andFilterWhere(['like', 'srlm_bc_application6.mobile_number', $this->mobile_number])
                ->andFilterWhere(['like', 'srlm_bc_application6.gps', $this->gps])
                ->andFilterWhere(['like', 'srlm_bc_application6.gps_accuracy', $this->gps_accuracy]);

        return $dataProvider;
    }

    public function dublicate($params, $user_model = null, $pagination = true, $distinct_column = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $where = "where i.form_number = 6 and i.status !=-1 ";
        if ($this->district_code) {
            $where .= " and i.district_code=" . $this->district_code;
        }
        if ($this->block_code) {
            $where .= " and i.block_code=" . $this->block_code;
        }
        if ($this->gram_panchayat_code) {
            $where .= " and i.gram_panchayat_code=" . $this->gram_panchayat_code;
        }
        if ($this->village_code) {
            $where .= " and i.village_code=" . $this->village_code;
        }
        if ($this->training_status) {
            $where .= " and i.training_status=" . $this->training_status;
        }
        $sql = "SELECT i.*
            FROM srlm_bc_application6 i
INNER JOIN (
 SELECT aadhar_number
    FROM srlm_bc_application6 
    where status !=-1 and form_number = 6
    GROUP BY aadhar_number
    HAVING COUNT( id ) > 1
) j ON i.aadhar_number=j.aadhar_number $where order by i.aadhar_number";

        $sqlc = "SELECT COUNT(*)
            FROM srlm_bc_application6 i
INNER JOIN (
 SELECT aadhar_number
    FROM srlm_bc_application6 
    GROUP BY aadhar_number
    HAVING COUNT( id ) > 1
) j ON i.aadhar_number=j.aadhar_number $where order by i.aadhar_number";
        $count = \Yii::$app->dbbc->createCommand($sqlc)->queryScalar();
        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' => $sql,
            'db' => 'dbbc',
            'totalCount' => $count,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
        ]);

        return $dataProvider;
    }

    public function dublicategpsame($params, $user_model = null, $pagination = true, $distinct_column = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $where = "where i.form_number = 6 and i.status !=-1 ";
        if ($this->district_code) {
            $where .= " and i.district_code=" . $this->district_code;
        }
        if ($this->block_code) {
            $where .= " and i.block_code=" . $this->block_code;
        }
        if ($this->gram_panchayat_code) {
            $where .= " and i.gram_panchayat_code=" . $this->gram_panchayat_code;
        }
        if ($this->village_code) {
            $where .= " and i.village_code=" . $this->village_code;
        }
        if ($this->training_status) {
            $where .= " and i.training_status=" . $this->training_status;
        }
        $sql = "SELECT i.*
            FROM srlm_bc_application6 i
INNER JOIN (
 SELECT aadhar_number,gram_panchayat_code
    FROM srlm_bc_application6 
    where status !=-1 and form_number = 6
    GROUP BY aadhar_number
    HAVING COUNT( id ) > 1
) j ON i.aadhar_number=j.aadhar_number and i.gram_panchayat_code=j.gram_panchayat_code  $where order by i.aadhar_number asc";

        $sqlc = "SELECT COUNT(*)
            FROM srlm_bc_application6 i
INNER JOIN (
 SELECT aadhar_number,gram_panchayat_code
    FROM srlm_bc_application6 
    GROUP BY aadhar_number
    HAVING COUNT( id ) > 1
) j ON i.aadhar_number=j.aadhar_number and i.gram_panchayat_code=j.gram_panchayat_code $where order by i.aadhar_number";
        $count = \Yii::$app->dbbc->createCommand($sqlc)->queryScalar();
        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' => $sql,
            'db' => 'dbbc',
            'totalCount' => $count,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
        ]);

        return $dataProvider;
    }

    public function dublicategpnotsame($params, $user_model = null, $pagination = true, $distinct_column = null) {
        if (isset($params->attributes))
            $this->setAttributes($params->attributes);
        else {
            $this->load($params);
        }
        $where = "where i.form_number = 6 and i.status !=-1 ";
        if ($this->district_code) {
            $where .= " and i.district_code=" . $this->district_code;
        }
        if ($this->block_code) {
            $where .= " and i.block_code=" . $this->block_code;
        }
        if ($this->gram_panchayat_code) {
            $where .= " and i.gram_panchayat_code=" . $this->gram_panchayat_code;
        }
        if ($this->village_code) {
            $where .= " and i.village_code=" . $this->village_code;
        }
        if ($this->training_status) {
            $where .= " and i.training_status=" . $this->training_status;
        }
        $sql = "SELECT i.*
            FROM srlm_bc_application6 i
INNER JOIN (
 SELECT aadhar_number,gram_panchayat_code
    FROM srlm_bc_application6 
    where status !=-1 and form_number = 6
    GROUP BY aadhar_number
    HAVING COUNT( id ) > 1
) j ON i.aadhar_number=j.aadhar_number  and i.gram_panchayat_code!=j.gram_panchayat_code $where order by i.aadhar_number";

        $sqlc = "SELECT COUNT(*)
            FROM srlm_bc_application6 i
INNER JOIN (
 SELECT aadhar_number,gram_panchayat_code
    FROM srlm_bc_application6 
    GROUP BY aadhar_number
    HAVING COUNT( id ) > 1
) j ON i.aadhar_number=j.aadhar_number and i.gram_panchayat_code!=j.gram_panchayat_code $where order by i.aadhar_number";
        $count = \Yii::$app->dbbc->createCommand($sqlc)->queryScalar();
        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' => $sql,
            'db' => 'dbbc',
            'totalCount' => $count,
            'pagination' => $pagination === false ? false : ['pageSize' => $pagination === true ? 100 : $pagination],
        ]);

        return $dataProvider;
    }

}
