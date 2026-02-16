<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "srlm_bc_application4".
 *
 * @property int $id
 * @property int|null $new_id
 * @property string|null $form_uuid
 * @property string|null $first_name
 * @property string|null $orig_first_name
 * @property string|null $middle_name
 * @property string|null $orig_middle_name
 * @property string|null $sur_name
 * @property string|null $orig_sur_name
 * @property int|null $gender
 * @property int|null $age
 * @property int|null $cast
 * @property string|null $application_id
 * @property int|null $division_code
 * @property string|null $division_name
 * @property string|null $district_name
 * @property string|null $block_name
 * @property string|null $gram_panchayat_name
 * @property string|null $village_name
 * @property string|null $hamlet
 * @property int|null $district_code
 * @property int|null $block_code
 * @property int|null $gram_panchayat_code
 * @property int|null $village_code
 * @property string|null $aadhar_number
 * @property string|null $guardian_name
 * @property int|null $reading_skills
 * @property string|null $mobile_number
 * @property int|null $phone_type
 * @property int $what_else_with_mobile1
 * @property int $what_else_with_mobile2
 * @property int $what_else_with_mobile3
 * @property int $what_else_with_mobile4
 * @property int $what_else_with_mobile5
 * @property int $whats_app_number
 * @property int $vechicle_drive1
 * @property int $vechicle_drive2
 * @property int $vechicle_drive3
 * @property int $vechicle_drive4
 * @property int $vechicle_drive5
 * @property int $vechicle_drive6
 * @property int $vechicle_drive7
 * @property int $marital_status
 * @property int $house_member_details1
 * @property int $house_member_details2
 * @property int $house_member_details3
 * @property int|null $future_scope1
 * @property int $future_scope2
 * @property int $future_scope3
 * @property int|null $future_scope4
 * @property int $future_scope5
 * @property int|null $future_scope6
 * @property int|null $future_scope7
 * @property int $future_scope8
 * @property int $future_scope9
 * @property int $future_scope10
 * @property int $future_scope11
 * @property int $future_scope12
 * @property int $future_scope13
 * @property int $opportunities_for_livelihood1
 * @property int $opportunities_for_livelihood2
 * @property int $opportunities_for_livelihood3
 * @property int $opportunities_for_livelihood4
 * @property int $opportunities_for_livelihood5
 * @property int $opportunities_for_livelihood6
 * @property int $opportunities_for_livelihood7
 * @property int $opportunities_for_livelihood8
 * @property int $opportunities_for_livelihood9
 * @property int $opportunities_for_livelihood10
 * @property string|null $other_occupation
 * @property int $planning_intervention1
 * @property int $planning_intervention2
 * @property int $planning_intervention3
 * @property int $planning_intervention4
 * @property int $planning_intervention5
 * @property int $planning_intervention6
 * @property int $immediate_aspiration1
 * @property int $immediate_aspiration2
 * @property int $immediate_aspiration3
 * @property int $immediate_aspiration4
 * @property int $immediate_aspiration5
 * @property int $immediate_aspiration6
 * @property int|null $already_group_member
 * @property string|null $your_group_name
 * @property int $which_program_your_group_formed
 * @property int $thought_of_forming_group
 * @property int $try_towards_group_formation1
 * @property int $try_towards_group_formation2
 * @property int $try_towards_group_formation3
 * @property int $try_towards_group_formation4
 * @property int $try_towards_group_formation5
 * @property int $try_towards_group_formation6
 * @property int $try_towards_group_formation7
 * @property int $try_towards_group_formation8
 * @property int $leadership_name_index
 * @property string|null $leadership_name
 * @property int $role_in_group1
 * @property int $role_in_group2
 * @property int $role_in_group3
 * @property int $role_in_group4
 * @property int $role_in_group5
 * @property int $role_in_group6
 * @property int $role_in_group7
 * @property int $role_in_group8
 * @property int $why_did_you_get_elected1
 * @property int $why_did_you_get_elected2
 * @property int $why_did_you_get_elected3
 * @property int $why_did_you_get_elected4
 * @property int $why_did_you_get_elected5
 * @property int $why_did_you_get_elected6
 * @property int $why_did_you_get_elected7
 * @property int $why_did_you_get_elected8
 * @property int $why_did_you_get_elected9
 * @property int $if_you_were_a_member_of_a_self_help_group1
 * @property int $if_you_were_a_member_of_a_self_help_group2
 * @property int $if_you_were_a_member_of_a_self_help_group3
 * @property int $if_you_were_a_member_of_a_self_help_group4
 * @property int $if_you_were_a_member_of_a_self_help_group5
 * @property int $if_you_were_a_member_of_a_self_help_group6
 * @property int $if_you_were_a_member_of_a_self_help_group7
 * @property int $if_you_were_a_member_of_a_self_help_group8
 * @property int $if_you_were_a_member_of_a_self_help_group9
 * @property string|null $active_members_name1
 * @property string|null $active_members_name2
 * @property int|null $active_members_position1
 * @property int|null $active_members_position2
 * @property string|null $belongingness_name1
 * @property string|null $belongingness_name2
 * @property int|null $belongingness_position1
 * @property int|null $belongingness_position2
 * @property string|null $awareness_name1
 * @property string|null $awareness_name2
 * @property int|null $awareness_position1
 * @property int|null $awareness_position2
 * @property string|null $member_who_contact_in_other_group_name1
 * @property string|null $member_who_contact_in_other_group_name2
 * @property int|null $member_who_contact_in_other_group_position1
 * @property int|null $member_who_contact_in_other_group_position2
 * @property string|null $demanded_group_member_name1
 * @property string|null $demanded_group_member_name2
 * @property int|null $demanded_group_member_position1
 * @property int|null $demanded_group_member_position2
 * @property int $capable_fast_pace
 * @property int $why_demanded1
 * @property int $why_demanded2
 * @property int $why_demanded3
 * @property int $why_demanded4
 * @property int $why_demanded5
 * @property int $why_demanded6
 * @property int|null $if_you_have_group_members_what_are_they
 * @property string|null $capable_fast_pace_member_name
 * @property int|null $capable_fast_pace_member_number
 * @property int $his_perception1
 * @property int $his_perception2
 * @property int $his_perception3
 * @property int $his_perception4
 * @property int $his_perception5
 * @property int $his_perception6
 * @property int $his_perception7
 * @property int $his_perception8
 * @property int $what_could_you_do_if_you_were_in_a_group1
 * @property int $what_could_you_do_if_you_were_in_a_group2
 * @property int $what_could_you_do_if_you_were_in_a_group3
 * @property int $what_could_you_do_if_you_were_in_a_group4
 * @property int $what_could_you_do_if_you_were_in_a_group5
 * @property int $what_could_you_do_if_you_were_in_a_group6
 * @property int $what_could_you_do_if_you_were_in_a_group7
 * @property int $what_could_you_do_if_you_were_in_a_group8
 * @property int $what_could_you_do_if_you_were_in_a_group9
 * @property int $most_contribute_index
 * @property string|null $most_contribute_name
 * @property int $group_culture
 * @property int $provision_in_the_group_as_voluntary
 * @property int $entrepreneurial_index
 * @property string|null $entrepreneurial
 * @property int $economic_status
 * @property int|null $afraid_unknown_rules_index1
 * @property string|null $afraid_unknown_rules1
 * @property int|null $afraid_unknown_rules_index2
 * @property string|null $afraid_unknown_rules2
 * @property int|null $concept_of_setting_up_new_heights_index
 * @property string|null $concept_of_setting_up_new_heights
 * @property int|null $livelihood_opportunity_for_another_member_index1
 * @property string|null $livelihood_opportunity_for_another_member1
 * @property int|null $livelihood_opportunity_for_another_member_index2
 * @property string|null $livelihood_opportunity_for_another_member2
 * @property int|null $negotiate_best_index1
 * @property string|null $negotiate_best1
 * @property int|null $negotiate_best_index2
 * @property string|null $negotiate_best2
 * @property int|null $which_member_can_talk_advantages_index1
 * @property string|null $which_member_can_talk_advantages1
 * @property int|null $which_member_can_talk_advantages_index2
 * @property string $which_member_can_talk_advantages2
 * @property int $can_read_write_hindi
 * @property int $confirtable_in_english
 * @property int $recognize_english_hindi
 * @property int $can_add_substract_multiply
 * @property int $who_maintain_account_index
 * @property string|null $who_maintain_account
 * @property int $choose_other_meaning1
 * @property int $choose_other_meaning2
 * @property int $choose_other_meaning3
 * @property int $choose_other_meaning4
 * @property int $choose_other_meaning5
 * @property int $same_to_same_word1
 * @property int $same_to_same_word2
 * @property int $same_to_same_word3
 * @property int $english_to_hindi1
 * @property int $english_to_hindi2
 * @property int $english_to_hindi3
 * @property int $english_to_hindi4
 * @property int $english_to_hindi5
 * @property int $percentage_option1
 * @property int $percentage_option2
 * @property int $percentage_option3
 * @property int $percentage_option4
 * @property int $percentage_option5
 * @property int $option_decision1
 * @property int $option_decision2
 * @property int $option_decision3
 * @property int $option_decision4
 * @property int $option_decision5
 * @property int $mobile_use_experience
 * @property int $whose_mobile_you_using
 * @property string $no_of_people_using_phone
 * @property int|null $no_of_family_people_using_phone
 * @property int $need_help_to_fill_form
 * @property int $already_worked
 * @property int $own_mobile
 * @property int $own_mobile_means1
 * @property int $own_mobile_means2
 * @property int $own_mobile_means3
 * @property int $own_mobile_means4
 * @property int $own_mobile_means5
 * @property int $own_mobile_means6
 * @property int $own_mobile_means7
 * @property int $own_mobile_means8
 * @property int $method_used_for_ledger_account1
 * @property int $method_used_for_ledger_account2
 * @property int $method_used_for_ledger_account3
 * @property int $method_used_for_ledger_account4
 * @property int $method_used_for_ledger_account5
 * @property int $method_used_for_ledger_account6
 * @property int $need_training1
 * @property int $need_training2
 * @property int $need_training3
 * @property int $need_training4
 * @property int $need_training5
 * @property string|null $profile_photo
 * @property string|null $aadhar_front_photo
 * @property string|null $aadhar_back_photo
 * @property string|null $gps
 * @property string|null $gps_accuracy
 * @property string|null $reg_date_time
 * @property string|null $form_start_date
 * @property string|null $form1_date_time
 * @property string|null $form2_date_time
 * @property string|null $form3_date_time
 * @property string|null $form4_date_time
 * @property string|null $form5_date_time
 * @property string|null $form6_date_time
 * @property int|null $form_number
 * @property int|null $srlm_bc_selection_app_detail_id
 * @property int|null $srlm_bc_selection_user_id
 * @property int|null $srlm_bc_selection_api_log_id
 * @property float $sec1
 * @property float $sec2
 * @property float $sec3
 * @property float $sec4
 * @property float $sec5
 * @property float $over_all
 * @property float $over_all_per
 * @property int $highest_score_in_gp
 * @property float $q1
 * @property float $q2
 * @property float $q3
 * @property float $q4
 * @property float $q5
 * @property float $q6
 * @property float $q7
 * @property float $q8
 * @property float $q9
 * @property float $q10
 * @property float $q11
 * @property float $q12
 * @property float $q13
 * @property float $q14
 * @property float $q15
 * @property float $q16
 * @property float $q17
 * @property float $q18
 * @property float $q19
 * @property float $q20
 * @property float $q21
 * @property float $q22
 * @property float $q23
 * @property float $q24
 * @property float $q25
 * @property float $q26
 * @property float $q27
 * @property float $q28
 * @property float $q29
 * @property float $q30
 * @property float $q31
 * @property float $q32
 * @property float $q33
 * @property float $q34
 * @property float $q35
 * @property float $q36
 * @property float $q37
 * @property float $q38
 * @property float $q39
 * @property float $q40
 * @property float $q41
 * @property float $q42
 * @property float $q43
 * @property float $q44
 * @property float $q45
 * @property float $q46
 * @property float $q47
 * @property float $q48
 * @property float $q49
 * @property float $q50
 * @property float $q51
 * @property float $q52
 * @property float $q53
 * @property float $q54
 * @property float $q55
 * @property float $q56
 * @property float $q57
 * @property float $q58
 * @property float $q59
 * @property float $q60
 * @property float $q61
 * @property float $q62
 * @property float $q63
 * @property float $q64
 * @property float $q65
 * @property float $q66
 * @property float $q67
 * @property float $q68
 * @property int $rating_process_status
 * @property int|null $selection_by
 * @property string|null $selection_datetime
 * @property int $replaced
 * @property int|null $call1
 * @property int|null $call1_by
 * @property string|null $call1_datetime
 * @property int|null $call_by_rsetis
 * @property string|null $call_rsetis_datetime
 * @property int|null $training_id
 * @property int|null $training_center_id
 * @property int|null $training_batch_id
 * @property int|null $training_status
 * @property int $already_certified
 * @property float|null $exam_score
 * @property string|null $certificate_code
 * @property int $pvr_status
 * @property int|null $pvr_upload_by
 * @property string|null $pvr_upload_date
 * @property string|null $pvr_upload_file_name
 * @property int|null $iibf_photo_status
 * @property int|null $iibf_photo_upload_by
 * @property string|null $iibf_photo_upload_date
 * @property string|null $iibf_photo_file_name
 * @property int|null $iibf_by
 * @property string|null $iibf_date
 * @property int|null $bc_photo_status
 * @property int|null $cbo_bc_id
 * @property int|null $cbo_shg_id
 * @property int|null $user_id
 * @property int|null $assign_shg_by
 * @property string|null $assign_shg_datetime
 * @property int $return_for_shg
 * @property int|null $return_for_shg_by
 * @property string|null $return_for_shg_datetime
 * @property int $onboarding
 * @property string|null $bankidbc
 * @property string|null $bc_email_id
 * @property int|null $onboarding_by
 * @property string|null $onboarding_date_time
 * @property string|null $bank_account_no_of_the_bc
 * @property int|null $bank_id
 * @property string|null $name_of_bank
 * @property string|null $branch
 * @property string|null $branch_code_or_ifsc
 * @property string|null $date_of_opening_the_bank_account
 * @property string|null $cin
 * @property string|null $passbook_photo
 * @property string|null $bank_account_no_of_the_shg
 * @property int|null $bank_id_shg
 * @property string|null $name_of_bank_shg
 * @property string|null $branch_shg
 * @property string|null $branch_code_or_ifsc_shg
 * @property string|null $passbook_photo_shg
 * @property int $bc_bank
 * @property int $shg_bank
 * @property int|null $verify_bc_passbook_photo
 * @property int|null $verify_bc_passbook_not
 * @property int|null $verify_bc_bank_account_no
 * @property int|null $verify_bc_branch_code_or_ifsc
 * @property int|null $verify_bc_ifsc_code_entered
 * @property int|null $verify_bc_other
 * @property string|null $verify_bc_other_reason
 * @property int|null $verify_bc_shg
 * @property int|null $verification_status_bc_bank
 * @property int|null $bc_bank_verify_by
 * @property string|null $bc_bank_verify_date
 * @property int|null $verify_bc_shg_passbook_photo
 * @property int|null $verify_bc_shg_name
 * @property int|null $verify_bc_shg_bank_account_no
 * @property int|null $verify_bc_shg_passbook_not
 * @property int|null $verify_bc_shg_other
 * @property string|null $verify_bc_shg_other_reason
 * @property int|null $verify_bc_shg_branch_code_or_ifsc
 * @property int|null $verify_bc_shg_ifsc_code_entered
 * @property int|null $bc_shg_bank_verify_by
 * @property string|null $bc_shg_bank_verify_date
 * @property int|null $verification_status_shg_bank
 * @property int|null $pfms_maped_status
 * @property int|null $bc_shg_funds_status
 * @property string|null $bc_shg_funds_date
 * @property float|null $bc_shg_funds_amount
 * @property int|null $bc_shg_funds_by
 * @property int|null $bc_support_funds_received
 * @property string|null $bc_support_funds_received_date
 * @property string|null $bc_support_funds_received_submitdate
 * @property float|null $bc_support_funds_received_amount
 * @property float|null $bc_support_funds_handheld_amount
 * @property float|null $bc_support_funds_od_amount
 * @property int|null $pan_card_status
 * @property int|null $pan_card_status_by
 * @property string|null $pan_card_status_date
 * @property string|null $pan_number
 * @property int $pan_photo_upload
 * @property string|null $pan_photo
 * @property string|null $pan_photo_date
 * @property int|null $pan_photo_by
 * @property int|null $handheld_machine_status
 * @property int|null $handheld_machine_by
 * @property string|null $handheld_machine_date
 * @property int|null $did_partner_bank_contact_bc
 * @property int|null $bc_handheld_machine_recived
 * @property string|null $bc_handheld_machine_photo
 * @property string|null $bc_handheld_machine_recived_submitdate
 * @property int $old_pfms
 * @property string|null $beneficiaries_code
 * @property int|null $beneficiaries_code_by
 * @property string|null $beneficiaries_code_date
 * @property int|null $revert_beneficiaries_code_by
 * @property int|null $revert_beneficiaries_reason
 * @property string|null $revert_beneficiaries_code_datetime
 * @property string|null $bc_beneficiaries_code
 * @property int|null $bc_beneficiaries_code_by
 * @property string|null $bc_beneficiaries_code_date
 * @property int $training_feedback
 * @property string|null $mobile_no
 * @property string|null $orig_otp_mobile_no
 * @property int|null $mobile_no_update_by
 * @property string|null $mobile_no_update_date
 * @property int $viewtemp1
 * @property int $viewtemp2
 * @property int $viewtemp3
 * @property int $viewtemp4
 * @property int $viewtemp5
 * @property int $viewtemp6
 * @property int $viewtemp7
 * @property int $viewtemp8
 * @property int $viewtemp9
 * @property int $viewtemp10
 * @property int $viewtemp11
 * @property int $viewtemp12
 * @property int $viewtemp13
 * @property int $viewtemp14
 * @property int $bc_shg_name_update
 * @property string|null $last_app_version
 * @property string|null $last_activity_time
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $form_status
 * @property int $status_new
 * @property int $status
 * @property int $bc_payment_count
 * @property int|null $master_partner_bank_id
 * @property int $urban_shg
 * @property int $missing_bc
 * @property int|null $bc_unwilling_rsetis
 * @property int|null $bc_unwilling_rsetis_by
 * @property string|null $bc_unwilling_rsetis_date
 * @property int|null $bc_unwilling_call_center
 * @property int|null $bc_unwilling_call_center_by
 * @property string|null $bc_unwilling_call_center_date
 * @property int|null $bc_unwilling_bank
 * @property int|null $bc_unwilling_bank_by
 * @property string|null $bc_unwilling_bank_date
 * @property int|null $bc_unwilling_bank_call_center
 * @property int|null $bc_unwilling_bank_call_center_by
 * @property string|null $bc_unwilling_bank_call_center_date
 * @property int $corona_feedback
 * @property int $blocked
 * @property int $aadhar_duplicate
 * @property int $application_phase
 * @property int $form_data_validate
 */
class SrlmBcApplication5 extends BcactiveRecord {

    public $action_type;

    const FORM_STATUS_REG = 0;
    const FORM_STATUS_BASIC_PROFILE = 1;
    const FORM_STATUS_FAMILY_PROFILE = 2;
    const FORM_STATUS_PART_1 = 3;
    const FORM_STATUS_PART_2 = 4;
    const FORM_STATUS_PART_3 = 5;
    const FORM_STATUS_PART_4 = 6;
    const ACTION_TYPE_REG = 1;
    const ACTION_TYPE_BASIC_PROFILE = 2;
    const ACTION_TYPE_FAMILY_PROFILE = 3;
    const ACTION_TYPE_PART_1 = 4;
    const ACTION_TYPE_PART_2 = 5;
    const ACTION_TYPE_PART_3 = 6;
    const ACTION_TYPE_PART_5 = 7;
    const ACTION_TYPE_SELECTION = 8;
    const ACTION_TYPE_STAND_BY1 = 9;
    const ACTION_TYPE_STAND_BY2 = 10;
    const ACTION_TYPE_CALL_CENTER_CALL1 = 11;
    const ACTION_TYPE_RSETHIS_AGREE = 12;
    const ACTION_TYPE_RSETHIS_RESET_AGREE = 13;
    const ACTION_TYPE_RSETHIS_ASSIGN_BATCH = 14;
    const ACTION_TYPE_RSETHIS_REMOVE_BATCH = 15;
    const ACTION_TYPE_RSETHIS_ADD_SCORE = 16;
    const ACTION_TYPE_RSETHIS_AREDY_CERTIFIED = 17;
    const ACTION_TYPE_UPLOAD_PVR = 18;
    const ACTION_TYPE_UPLOAD_REVERT_PVR = 19;
    const ACTION_TYPE_UPLOAD_PROFILE_PHOTO = 20;
    const ACTION_TYPE_BC_BANK = 21;
    const ACTION_TYPE_BC_SHG_BANK = 22;
    const ACTION_TYPE_UPDATE_SHG_NAME = 23;
    const ACTION_TYPE_UPLOAD_PAN = 24;
    const ACTION_TYPE_ACK_SUPPORT_FUNDS = 25;
    const ACTION_TYPE_ACK_HANDHELD_MACHIN = 26;
    const ACTION_TYPE_ASSIGN_SHG = 27;
    const ACTION_TYPE_NAME_MOBILE_NO_UPDATE = 28;
    const ACTION_TYPE_HANDHELD_MACHIN_PROVIDED = 29;
    const ACTION_TYPE_PAN_AVAILABLE = 30;
    const ACTION_TYPE_PFMS_BENEFICIARIES_CODE = 31;
    const ACTION_TYPE_PFMS_BENEFICIARIES_CODE_REVERT = 32;
    const ACTION_TYPE_ONBOARDING = 33;
    const ACTION_TYPE_BANK_VERIFICATION = 34;
    const ACTION_TYPE_BANK_VERIFICATION_REVERT = 35;
    const ACTION_TYPE_FUNDS_TRANSFER = 36;
    const ACTION_TYPE_RSETHIS_UNWILLING = 37;
    const ACTION_TYPE_CALL_CENTER_UNWILLING = 38;
    const ACTION_TYPE_RETURN_SHG_TO_BMMU = 39;
    const ACTION_TYPE_CHANGE_BATCH = 40;
    const ACTION_TYPE_INELIGIBLE = 41;
    const ACTION_TYPE_RSETHIS_CALL_CENTER_UNWILLING = 42;
    const ACTION_TYPE_AGE_UPDATE = 43;
    const ACTION_TYPE_CONFIRM_10TH_PASS = 44;
    const ACTION_TYPE_REVERT_BC_SHG_MAPPING = 45;
    const ACTION_TYPE_ADD_BC_CERTIFIED_RSETI = 46;
    const ACTION_TYPE_REVERT_FUNDS_TRANSFER = 47;
    const ACTION_TYPE_FINAL_UNWILLING = 48;
    const ACTION_TYPE_BC_PBANK_TRAINING_FEEDBACK = 49;
    const ACTION_TYPE_BC_BENEFICIARIES_CODE = 50;
    const ACTION_TYPE_BC_PAYMENT = 51;
    const ACTION_TYPE_BANK_UNWILLING = 52;
    const ACTION_TYPE_BANK_CALL_CENTER_UNWILLING = 53;
    const UNWILLING_TYPE_RSETHIS = 1;
    const UNWILLING_TYPE_BANK = 2;
    const ZERO_VALUE = 0;
    const BLANK_VALUE = '';
    const NULL_VALUE = NULL;
    const DELETE = -1;
    const STATUS_RECIEVED = 1;
    const STATUS_PROVISIONAL = 2;
    const STATUS_SELECTED = 3;
    const STATUS_STAND_BY_1 = 4;
    const STATUS_STAND_BY_2 = 5;
    const MAX_NO_BASIC_AND_FAMILY = 61.5;
    const MAX_NO_CRITERI1 = 100;
    const MAX_NO_CRITERI2 = 31;
    const MAX_NO_CRITERI3 = 59;
    const MAX_NO_CRITERI4 = 45;
    const MAX_NO_TOTAL = 296.5;
    // Basic & family
    const MAX_NO_Q1 = 3;
    const MAX_NO_Q2 = 5;
    const MAX_NO_Q3 = 5;
    const MAX_NO_Q4 = 2;
    const MAX_NO_Q5 = 24.5;
    const MAX_NO_Q6 = 0;
    const MAX_NO_Q7 = 2;
    const MAX_NO_Q8 = 5;
    const MAX_NO_Q9 = 15;
    // End Basic & family
    // Criteria 1
    const MAX_NO_Q10 = 10;
    const MAX_NO_Q11 = 3;
    const MAX_NO_Q12 = 36.5;
    const MAX_NO_Q13 = 2;
    const MAX_NO_Q14 = 7;
    const MAX_NO_Q15 = 7.5;
    const MAX_NO_Q16 = 7.5;
    const MAX_NO_Q17 = 7.5;
    const MAX_NO_Q18 = 7.5;
    const MAX_NO_Q19 = 7.5;
    const MAX_NO_Q20 = 2;
    const MAX_NO_Q21 = 2;
    //                100
    // End Criteria 1
    // Criteria 2
    const MAX_NO_Q22 = 3;
    const MAX_NO_Q23 = 3;
    const MAX_NO_Q24 = 5;
    const MAX_NO_Q25 = 5;
    const MAX_NO_Q26 = 5;
    const MAX_NO_Q27 = 5;
    const MAX_NO_Q28 = 5;
    //                31
    // End Criteria 2
    // Criteria 3
    const MAX_NO_Q29 = 2;
    const MAX_NO_Q30 = 3;
    const MAX_NO_Q31 = 2;
    const MAX_NO_Q32 = 2;
    const MAX_NO_Q33 = 0;
    const MAX_NO_Q34 = 2;
    const MAX_NO_Q35 = 2;
    const MAX_NO_Q36 = 2;
    const MAX_NO_Q37 = 2;
    const MAX_NO_Q38 = 2;
    const MAX_NO_Q39 = 2;
    const MAX_NO_Q40 = 2;
    const MAX_NO_Q41 = 2;
    const MAX_NO_Q42 = 2;
    const MAX_NO_Q43 = 2;
    const MAX_NO_Q44 = 2;
    const MAX_NO_Q45 = 2;
    const MAX_NO_Q46 = 2;
    const MAX_NO_Q47 = 2;
    const MAX_NO_Q48 = 2;
    const MAX_NO_Q49 = 2;
    const MAX_NO_Q50 = 2;
    const MAX_NO_Q51 = 2;
    const MAX_NO_Q52 = 2;
    const MAX_NO_Q53 = 2;
    const MAX_NO_Q54 = 2;
    const MAX_NO_Q55 = 2;
    const MAX_NO_Q56 = 2;
    const MAX_NO_Q57 = 3;
    //                 59
    // Criteria 3
    // Criteria 4
    const MAX_NO_Q58 = 2;
    const MAX_NO_Q59 = 5;
    const MAX_NO_Q60 = 5;
    const MAX_NO_Q61 = 5;
    const MAX_NO_Q62 = 0;
    const MAX_NO_Q63 = 0;
    const MAX_NO_Q64 = 1;
    const MAX_NO_Q65 = 2;
    const MAX_NO_Q66 = 14;
    const MAX_NO_Q67 = 5;
    const MAX_NO_Q68 = 6;
    const TRAINING_STATUS_DEFAULT = 0;
    const TRAINING_STATUS_INACCESSIBLE = -1;
    const TRAINING_STATUS_UNWILLING = -2;
    const TRAINING_STATUS_AGREE_TRAINING = 1;
    const TRAINING_STATUS_ASIGNT_TO_BATCH = 2;
    const TRAINING_STATUS_PASS = 3;
    const TRAINING_STATUS_CERTIFIED_UNWILLING = 32;
    const TRAINING_STATUS_FAIL = 4;
    const TRAINING_STATUS_INELIIGIBLE = 5;
    const TRAINING_STATUS_ABSENT = 6;
    const PIN_APP_VERSION = 2.59;
    const BLOCKED_STATUS_BC_SHG_GP_MISMATCH = 1;
    const BLOCKED_STATUS_URBAN = 2;
    const BLOCKED_STATUS_EDUCATION_ELIGIBILITY = 3;
    const BLOCKED_STATUS_PHONE_INUSED = 4;
    const BLOCKED_STATUS_BC_GP = 5;
    const BLOCKED_STATUS_MISSING_BC = 6;
    const BLOCKED_STATUS_AGE_ELIGIBILITY = 7;
    const BLOCKED_STATUS_PFMS = 8;
    const BLOCKED_STATUS_AADHAR = 9;

    //const TRAINING_STATUS_ONBOARDING = 7;
    //                45
    // End Criteria 4
    public $application_count;
    public $application_gp_count;

    public function behaviors() {
        return [
            'typecast' => [
                'class' => \yii\behaviors\AttributeTypecastBehavior::className(),
                'attributeTypes' => [
                    'last_app_version' => \yii\behaviors\AttributeTypecastBehavior::TYPE_FLOAT,
                ],
                'typecastAfterValidate' => false,
                'typecastBeforeSave' => false,
                'typecastAfterFind' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'srlm_bc_application5';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['gender', 'age', 'cast', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'reading_skills', 'phone_type', 'what_else_with_mobile1', 'what_else_with_mobile2', 'what_else_with_mobile3', 'what_else_with_mobile4', 'what_else_with_mobile5', 'whats_app_number', 'vechicle_drive1', 'vechicle_drive2', 'vechicle_drive3', 'vechicle_drive4', 'vechicle_drive5', 'vechicle_drive6', 'vechicle_drive7', 'marital_status', 'house_member_details1', 'house_member_details2', 'house_member_details3', 'future_scope1', 'future_scope2', 'future_scope3', 'future_scope4', 'future_scope5', 'future_scope6', 'future_scope7', 'future_scope8', 'future_scope9', 'future_scope10', 'future_scope11', 'future_scope12', 'future_scope13', 'opportunities_for_livelihood1', 'opportunities_for_livelihood2', 'opportunities_for_livelihood3', 'opportunities_for_livelihood4', 'opportunities_for_livelihood5', 'opportunities_for_livelihood6', 'opportunities_for_livelihood7', 'opportunities_for_livelihood8', 'opportunities_for_livelihood9', 'opportunities_for_livelihood10', 'planning_intervention1', 'planning_intervention2', 'planning_intervention3', 'planning_intervention4', 'planning_intervention5', 'planning_intervention6', 'immediate_aspiration1', 'immediate_aspiration2', 'immediate_aspiration3', 'immediate_aspiration4', 'immediate_aspiration5', 'immediate_aspiration6', 'already_group_member', 'which_program_your_group_formed', 'thought_of_forming_group', 'try_towards_group_formation1', 'try_towards_group_formation2', 'try_towards_group_formation3', 'try_towards_group_formation4', 'try_towards_group_formation5', 'try_towards_group_formation6', 'try_towards_group_formation7', 'try_towards_group_formation8', 'leadership_name_index', 'role_in_group1', 'role_in_group2', 'role_in_group3', 'role_in_group4', 'role_in_group5', 'role_in_group6', 'role_in_group7', 'role_in_group8', 'why_did_you_get_elected1', 'why_did_you_get_elected2', 'why_did_you_get_elected3', 'why_did_you_get_elected4', 'why_did_you_get_elected5', 'why_did_you_get_elected6', 'why_did_you_get_elected7', 'why_did_you_get_elected8', 'why_did_you_get_elected9', 'if_you_were_a_member_of_a_self_help_group1', 'if_you_were_a_member_of_a_self_help_group2', 'if_you_were_a_member_of_a_self_help_group3', 'if_you_were_a_member_of_a_self_help_group4', 'if_you_were_a_member_of_a_self_help_group5', 'if_you_were_a_member_of_a_self_help_group6', 'if_you_were_a_member_of_a_self_help_group7', 'if_you_were_a_member_of_a_self_help_group8', 'if_you_were_a_member_of_a_self_help_group9', 'active_members_position1', 'active_members_position2', 'belongingness_position1', 'belongingness_position2', 'awareness_position1', 'awareness_position2', 'member_who_contact_in_other_group_position1', 'member_who_contact_in_other_group_position2', 'demanded_group_member_position1', 'demanded_group_member_position2', 'capable_fast_pace', 'why_demanded1', 'why_demanded2', 'why_demanded3', 'why_demanded4', 'why_demanded5', 'why_demanded6', 'if_you_have_group_members_what_are_they', 'capable_fast_pace_member_number', 'his_perception1', 'his_perception2', 'his_perception3', 'his_perception4', 'his_perception5', 'his_perception6', 'his_perception7', 'his_perception8', 'what_could_you_do_if_you_were_in_a_group1', 'what_could_you_do_if_you_were_in_a_group2', 'what_could_you_do_if_you_were_in_a_group3', 'what_could_you_do_if_you_were_in_a_group4', 'what_could_you_do_if_you_were_in_a_group5', 'what_could_you_do_if_you_were_in_a_group6', 'what_could_you_do_if_you_were_in_a_group7', 'what_could_you_do_if_you_were_in_a_group8', 'what_could_you_do_if_you_were_in_a_group9', 'most_contribute_index', 'group_culture', 'provision_in_the_group_as_voluntary', 'entrepreneurial_index', 'economic_status', 'afraid_unknown_rules_index1', 'afraid_unknown_rules_index2', 'concept_of_setting_up_new_heights_index', 'livelihood_opportunity_for_another_member_index1', 'livelihood_opportunity_for_another_member_index2', 'negotiate_best_index1', 'negotiate_best_index2', 'which_member_can_talk_advantages_index1', 'which_member_can_talk_advantages_index2', 'can_read_write_hindi', 'confirtable_in_english', 'recognize_english_hindi', 'can_add_substract_multiply', 'who_maintain_account_index', 'choose_other_meaning1', 'choose_other_meaning2', 'choose_other_meaning3', 'choose_other_meaning4', 'choose_other_meaning5', 'same_to_same_word1', 'same_to_same_word2', 'same_to_same_word3', 'english_to_hindi1', 'english_to_hindi2', 'english_to_hindi3', 'english_to_hindi4', 'english_to_hindi5', 'percentage_option1', 'percentage_option2', 'percentage_option3', 'percentage_option4', 'percentage_option5', 'option_decision1', 'option_decision2', 'option_decision3', 'option_decision4', 'option_decision5', 'mobile_use_experience', 'whose_mobile_you_using', 'need_help_to_fill_form', 'already_worked', 'own_mobile', 'own_mobile_means1', 'own_mobile_means2', 'own_mobile_means3', 'own_mobile_means4', 'own_mobile_means5', 'own_mobile_means6', 'own_mobile_means7', 'own_mobile_means8', 'method_used_for_ledger_account1', 'method_used_for_ledger_account2', 'method_used_for_ledger_account3', 'method_used_for_ledger_account4', 'method_used_for_ledger_account5', 'method_used_for_ledger_account6', 'need_training1', 'need_training2', 'need_training3', 'need_training4', 'need_training5', 'form_number', 'srlm_bc_selection_app_detail_id', 'srlm_bc_selection_user_id', 'no_of_family_people_using_phone', 'srlm_bc_selection_api_log_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'form_status', 'status', 'selection_by', 'call1', 'call1_by', 'training_id', 'training_center_id', 'training_batch_id', 'training_status'], 'integer'],
            [['which_member_can_talk_advantages2', 'mobile_use_experience', 'whose_mobile_you_using', 'no_of_people_using_phone'], 'safe'],
            [['reg_date_time', 'form_start_date', 'form1_date_time', 'form2_date_time', 'form3_date_time', 'form4_date_time', 'form5_date_time', 'form6_date_time', 'selection_datetime'], 'safe'],
            [['form_uuid'], 'string', 'max' => 36],
            [['first_name', 'middle_name', 'sur_name', 'district_name', 'block_name', 'gram_panchayat_name', 'village_name', 'hamlet', 'guardian_name', 'leadership_name', 'active_members_name1', 'active_members_name2', 'belongingness_name1', 'belongingness_name2', 'awareness_name1', 'awareness_name2', 'member_who_contact_in_other_group_name2', 'demanded_group_member_name1', 'demanded_group_member_name2', 'capable_fast_pace_member_name', 'most_contribute_name', 'entrepreneurial', 'afraid_unknown_rules1', 'afraid_unknown_rules2', 'concept_of_setting_up_new_heights', 'livelihood_opportunity_for_another_member1', 'livelihood_opportunity_for_another_member2', 'negotiate_best1', 'negotiate_best2', 'which_member_can_talk_advantages1', 'which_member_can_talk_advantages2', 'who_maintain_account', 'gps', 'member_who_contact_in_other_group_name1'], 'string', 'max' => 100],
            [['other_occupation'], 'string', 'max' => 500],
            [['aadhar_number', 'no_of_people_using_phone'], 'safe'],
            [['mobile_number'], 'string', 'max' => 15],
            [['your_group_name'], 'string', 'max' => 255],
            [['profile_photo', 'aadhar_front_photo', 'aadhar_back_photo'], 'string', 'max' => 500],
            [['gps_accuracy'], 'string', 'max' => 50],
            [['form_uuid'], 'unique'],
            [['action_type'], 'default', 'value' => 0],
            [['form_status'], 'default', 'value' => self::FORM_STATUS_REG],
            [['which_member_can_talk_advantages2'], 'default', 'value' => self::BLANK_VALUE],
            [['mobile_use_experience'], 'default', 'value' => self::ZERO_VALUE],
            [['whose_mobile_you_using'], 'default', 'value' => self::ZERO_VALUE],
            [['no_of_people_using_phone'], 'default', 'value' => self::ZERO_VALUE],
            [['age'], 'default', 'value' => self::ZERO_VALUE],
            [['srlm_bc_selection_user_id'], 'unique'],
            [['sec1', 'sec2', 'sec3', 'sec4', 'sec5', 'over_all', 'over_all_per', 'highest_score_in_gp', 'q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10', 'q11', 'q12', 'q13', 'q14', 'q15', 'q16', 'q17', 'q18', 'q19', 'q20', 'q21', 'q22', 'q23', 'q24', 'q25', 'q26', 'q27', 'q28', 'q29', 'q30', 'q31', 'q32', 'q33', 'q34', 'q35', 'q36', 'q37', 'q38', 'q39', 'q40', 'q41', 'q42', 'q43', 'q44', 'q45', 'q46', 'q47', 'q48', 'q49', 'q50', 'q51', 'q52', 'q53', 'q54', 'q55', 'q56', 'q57', 'q58', 'q59', 'q60', 'q61', 'q62', 'q63', 'q64', 'q65', 'q66', 'q67', 'q68'], 'number'],
            [['sec1', 'sec2', 'sec3', 'sec4', 'sec5', 'over_all', 'over_all_per', 'q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10', 'q11', 'q12', 'q13', 'q14', 'q15', 'q16', 'q17', 'q18', 'q19', 'q20', 'q21', 'q22', 'q23', 'q24', 'q25', 'q26', 'q27', 'q28', 'q29', 'q30', 'q31', 'q32', 'q33', 'q34', 'q35', 'q36', 'q37', 'q38', 'q39', 'q40', 'q41', 'q42', 'q43', 'q44', 'q45', 'q46', 'q47', 'q48', 'q49', 'q50', 'q51', 'q52', 'q53', 'q54', 'q55', 'q56', 'q57', 'q58', 'q59', 'q60', 'q61', 'q62', 'q63', 'q64', 'q65', 'q66', 'q67', 'q68'], 'default', 'value' => self::ZERO_VALUE],
            [['rating_process_status'], 'default', 'value' => self::ZERO_VALUE],
            [['application_count', 'application_gp_count'], 'default', 'value' => self::ZERO_VALUE],
            [['division_code'], 'integer'],
            [['division_name'], 'string', 'max' => 50],
            [['application_id'], 'string', 'max' => 20],
            [['application_id'], 'unique'],
            [['call1', 'call1_by', 'call1_datetime'], 'safe'],
            [['training_id', 'training_center_id', 'training_batch_id', 'training_status'], 'safe'],
            [['training_id', 'training_center_id', 'training_batch_id', 'training_status'], 'default', 'value' => self::ZERO_VALUE],
            [['exam_score'], 'number'],
            [['certificate_code'], 'string', 'max' => 100],
            [['exam_score'], 'default', 'value' => self::NULL_VALUE],
            [['certificate_code'], 'default', 'value' => self::NULL_VALUE],
            [['call_by_rsetis'], 'integer'],
            [['call_by_rsetis'], 'default', 'value' => self::ZERO_VALUE],
            [['call_by_rsetis', 'call_rsetis_datetime'], 'safe'],
            [['viewtemp1', 'viewtemp2', 'viewtemp3', 'viewtemp4', 'viewtemp5', 'viewtemp6', 'viewtemp7', 'viewtemp8', 'viewtemp9', 'viewtemp10', 'viewtemp11', 'viewtemp12', 'viewtemp13', 'viewtemp14'], 'default', 'value' => self::ZERO_VALUE],
            [['pvr_status', 'pvr_upload_by'], 'integer'],
            [['pvr_upload_date'], 'safe'],
            [['pvr_upload_file_name'], 'string', 'max' => 500],
            [['pvr_status'], 'default', 'value' => self::ZERO_VALUE],
            [['iibf_photo_status', 'iibf_photo_upload_by', 'bc_photo_status'], 'integer'],
            [['iibf_photo_upload_date'], 'safe'],
            [['iibf_photo_file_name'], 'string', 'max' => 500],
            [['iibf_photo_status'], 'default', 'value' => self::ZERO_VALUE],
            [['bc_photo_status'], 'default', 'value' => self::ZERO_VALUE],
            [['cbo_bc_id', 'cbo_shg_id', 'onboarding', 'onboarding_by', 'bank_id'], 'integer'],
            [['onboarding_date_time', 'date_of_opening_the_bank_account'], 'safe'],
            [['bank_account_no_of_the_bc', 'branch_code_or_ifsc'], 'string', 'max' => 25],
            [['name_of_bank', 'branch', 'cin'], 'string', 'max' => 150],
            [['passbook_photo'], 'string', 'max' => 500],
            [['onboarding'], 'default', 'value' => self::ZERO_VALUE],
            [['user_id'], 'integer'],
            [['already_certified'], 'integer'],
            [['already_certified'], 'default', 'value' => self::ZERO_VALUE],
            [['assign_shg_datetime'], 'safe'],
            [['return_for_shg', 'assign_shg_by'], 'integer'],
            [['return_for_shg'], 'default', 'value' => self::ZERO_VALUE],
            [['return_for_shg_by'], 'integer'],
            [['return_for_shg_datetime'], 'safe'],
            [['cin'], 'default', 'value' => NULL],
            [['last_app_version'], 'safe'],
            [['last_activity_time'], 'safe'],
            [['bc_shg_name_update'], 'default', 'value' => self::ZERO_VALUE],
            [['bc_bank', 'shg_bank', 'verify_bc_passbook_photo', 'verify_bc_bank_account_no', 'verify_bc_branch_code_or_ifsc', 'verify_bc_shg', 'verification_status_bc_bank', 'bc_bank_verify_by', 'verify_bc_shg_passbook_photo', 'verify_bc_shg_bank_account_no', 'verify_bc_shg_branch_code_or_ifsc', 'bc_shg_bank_verify_by'], 'integer'],
            [['bc_bank_verify_date', 'bc_shg_bank_verify_date'], 'safe'],
            [['pfms_maped_status', 'bc_shg_funds_status', 'bc_shg_funds_by'], 'integer'],
            [['bc_shg_funds_date'], 'safe'],
            [['bc_shg_funds_amount'], 'number'],
            [['bc_shg_funds_amount'], 'safe'],
            [['pan_card_status', 'pan_card_status_by', 'handheld_machine_status', 'handheld_machine_by'], 'integer'],
            [['pan_card_status_date', 'handheld_machine_date'], 'safe'],
            [['beneficiaries_code_by'], 'integer'],
            [['beneficiaries_code'], 'safe'],
            [['beneficiaries_code'], 'string', 'max' => 50],
            [['beneficiaries_code_date'], 'safe'],
            [['pan_photo_by', 'pan_photo_upload'], 'integer'],
            [['pan_photo_date'], 'safe'],
            [['pan_photo'], 'string', 'max' => 500],
            [['pan_photo_upload'], 'default', 'value' => 0],
            [['corona_feedback'], 'default', 'value' => 0],
            [['pan_number'], 'string', 'max' => 16],
            [['bank_id_shg'], 'integer'],
            [['bank_account_no_of_the_shg', 'branch_code_or_ifsc_shg'], 'string', 'max' => 25],
            [['name_of_bank_shg', 'branch_shg'], 'string', 'max' => 150],
            [['passbook_photo_shg'], 'string', 'max' => 500],
            [['mobile_no'], 'string', 'max' => 12],
            [['orig_otp_mobile_no'], 'string', 'max' => 12],
            [['mobile_no_update_by'], 'integer'],
            [['mobile_no_update_date'], 'safe'],
            [['verify_bc_other_reason', 'verify_bc_shg_other_reason'], 'string', 'max' => 512],
            [['verify_bc_passbook_photo', 'verify_bc_passbook_not', 'verify_bc_bank_account_no', 'verify_bc_branch_code_or_ifsc', 'verify_bc_ifsc_code_entered', 'verify_bc_other', 'verify_bc_shg_passbook_photo', 'verify_bc_shg_name', 'verify_bc_shg_bank_account_no', 'verify_bc_shg_passbook_not', 'verify_bc_shg_other', 'verify_bc_shg_branch_code_or_ifsc', 'verify_bc_shg_ifsc_code_entered'], 'integer'],
            [['first_name', 'middle_name', 'sur_name'], 'trim'],
            [['orig_first_name', 'orig_middle_name', 'orig_sur_name'], 'trim'],
            [['bc_support_funds_received', 'did_partner_bank_contact_bc', 'bc_handheld_machine_recived', 'bc_unwilling_rsetis', 'bc_unwilling_call_center'], 'integer'],
            [['bc_support_funds_received_date', 'bc_support_funds_received_submitdate', 'bc_handheld_machine_recived_submitdate'], 'safe'],
            [['bc_support_funds_received_amount'], 'number'],
            [['bc_support_funds_handheld_amount'], 'number'],
            [['bc_support_funds_od_amount'], 'number'],
            [['bc_handheld_machine_photo'], 'string', 'max' => 500],
            [['revert_beneficiaries_code_by', 'revert_beneficiaries_reason'], 'integer'],
            [['revert_beneficiaries_code_datetime'], 'safe'],
            [['bc_unwilling_rsetis', 'bc_unwilling_rsetis_by'], 'integer'],
            [['bc_unwilling_rsetis_date'], 'safe'],
            [['bc_unwilling_call_center', 'bc_unwilling_call_center_by'], 'integer'],
            [['bc_unwilling_call_center_date'], 'safe'],
            [['bankidbc'], 'string', 'max' => 20],
            [['bc_email_id'], 'string', 'max' => 255],
            [['missing_bc'], 'integer'],
            [['missing_bc'], 'default', 'value' => 0],
            [['urban_shg'], 'integer'],
            [['urban_shg'], 'default', 'value' => 0],
            [['master_partner_bank_id'], 'integer'],
            [['blocked'], 'default', 'value' => 0],
            [['bc_beneficiaries_code_by', 'training_feedback'], 'integer'],
            [['bc_beneficiaries_code_date'], 'safe'],
            [['bc_beneficiaries_code'], 'string', 'max' => 20],
            [['training_feedback'], 'default', 'value' => 0],
            [['replaced'], 'integer'],
            [['replaced'], 'default', 'value' => 0],
            [['bc_payment_count'], 'default', 'value' => 0],
            [['aadhar_duplicate'], 'default', 'value' => 0],
            [['bc_unwilling_bank', 'bc_unwilling_bank_by', 'bc_unwilling_bank_call_center', 'bc_unwilling_bank_call_center_by'], 'integer'],
            [['bc_unwilling_bank_date', 'bc_unwilling_bank_call_center_date'], 'safe'],
            [['form_data_validate'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'new_id' => 'New ID',
            'form_uuid' => 'Form Uuid',
            'first_name' => 'First Name',
            'orig_first_name' => 'Orig First Name',
            'middle_name' => 'Middle Name',
            'orig_middle_name' => 'Orig Middle Name',
            'sur_name' => 'Sur Name',
            'orig_sur_name' => 'Orig Sur Name',
            'gender' => 'Gender',
            'age' => 'Age',
            'cast' => 'Cast',
            'application_id' => 'Application ID',
            'division_code' => 'Division Code',
            'division_name' => 'Division Name',
            'district_name' => 'District Name',
            'block_name' => 'Block Name',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'village_name' => 'Village Name',
            'hamlet' => 'Hamlet',
            'district_code' => 'District Code',
            'block_code' => 'Block Code',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'village_code' => 'Village Code',
            'aadhar_number' => 'Aadhar Number',
            'guardian_name' => 'Guardian Name',
            'reading_skills' => 'Reading Skills',
            'mobile_number' => 'Mobile Number',
            'phone_type' => 'Phone Type',
            'what_else_with_mobile1' => 'What Else With Mobile1',
            'what_else_with_mobile2' => 'What Else With Mobile2',
            'what_else_with_mobile3' => 'What Else With Mobile3',
            'what_else_with_mobile4' => 'What Else With Mobile4',
            'what_else_with_mobile5' => 'What Else With Mobile5',
            'whats_app_number' => 'Whats App Number',
            'vechicle_drive1' => 'Vechicle Drive1',
            'vechicle_drive2' => 'Vechicle Drive2',
            'vechicle_drive3' => 'Vechicle Drive3',
            'vechicle_drive4' => 'Vechicle Drive4',
            'vechicle_drive5' => 'Vechicle Drive5',
            'vechicle_drive6' => 'Vechicle Drive6',
            'vechicle_drive7' => 'Vechicle Drive7',
            'marital_status' => 'Marital Status',
            'house_member_details1' => 'House Member Details1',
            'house_member_details2' => 'House Member Details2',
            'house_member_details3' => 'House Member Details3',
            'future_scope1' => 'Future Scope1',
            'future_scope2' => 'Future Scope2',
            'future_scope3' => 'Future Scope3',
            'future_scope4' => 'Future Scope4',
            'future_scope5' => 'Future Scope5',
            'future_scope6' => 'Future Scope6',
            'future_scope7' => 'Future Scope7',
            'future_scope8' => 'Future Scope8',
            'future_scope9' => 'Future Scope9',
            'future_scope10' => 'Future Scope10',
            'future_scope11' => 'Future Scope11',
            'future_scope12' => 'Future Scope12',
            'future_scope13' => 'Future Scope13',
            'opportunities_for_livelihood1' => 'Opportunities For Livelihood1',
            'opportunities_for_livelihood2' => 'Opportunities For Livelihood2',
            'opportunities_for_livelihood3' => 'Opportunities For Livelihood3',
            'opportunities_for_livelihood4' => 'Opportunities For Livelihood4',
            'opportunities_for_livelihood5' => 'Opportunities For Livelihood5',
            'opportunities_for_livelihood6' => 'Opportunities For Livelihood6',
            'opportunities_for_livelihood7' => 'Opportunities For Livelihood7',
            'opportunities_for_livelihood8' => 'Opportunities For Livelihood8',
            'opportunities_for_livelihood9' => 'Opportunities For Livelihood9',
            'opportunities_for_livelihood10' => 'Opportunities For Livelihood10',
            'other_occupation' => 'Other Occupation',
            'planning_intervention1' => 'Planning Intervention1',
            'planning_intervention2' => 'Planning Intervention2',
            'planning_intervention3' => 'Planning Intervention3',
            'planning_intervention4' => 'Planning Intervention4',
            'planning_intervention5' => 'Planning Intervention5',
            'planning_intervention6' => 'Planning Intervention6',
            'immediate_aspiration1' => 'Immediate Aspiration1',
            'immediate_aspiration2' => 'Immediate Aspiration2',
            'immediate_aspiration3' => 'Immediate Aspiration3',
            'immediate_aspiration4' => 'Immediate Aspiration4',
            'immediate_aspiration5' => 'Immediate Aspiration5',
            'immediate_aspiration6' => 'Immediate Aspiration6',
            'already_group_member' => 'Already Group Member',
            'your_group_name' => 'Your Group Name',
            'which_program_your_group_formed' => 'Which Program Your Group Formed',
            'thought_of_forming_group' => 'Thought Of Forming Group',
            'try_towards_group_formation1' => 'Try Towards Group Formation1',
            'try_towards_group_formation2' => 'Try Towards Group Formation2',
            'try_towards_group_formation3' => 'Try Towards Group Formation3',
            'try_towards_group_formation4' => 'Try Towards Group Formation4',
            'try_towards_group_formation5' => 'Try Towards Group Formation5',
            'try_towards_group_formation6' => 'Try Towards Group Formation6',
            'try_towards_group_formation7' => 'Try Towards Group Formation7',
            'try_towards_group_formation8' => 'Try Towards Group Formation8',
            'leadership_name_index' => 'Leadership Name Index',
            'leadership_name' => 'Leadership Name',
            'role_in_group1' => 'Role In Group1',
            'role_in_group2' => 'Role In Group2',
            'role_in_group3' => 'Role In Group3',
            'role_in_group4' => 'Role In Group4',
            'role_in_group5' => 'Role In Group5',
            'role_in_group6' => 'Role In Group6',
            'role_in_group7' => 'Role In Group7',
            'role_in_group8' => 'Role In Group8',
            'why_did_you_get_elected1' => 'Why Did You Get Elected1',
            'why_did_you_get_elected2' => 'Why Did You Get Elected2',
            'why_did_you_get_elected3' => 'Why Did You Get Elected3',
            'why_did_you_get_elected4' => 'Why Did You Get Elected4',
            'why_did_you_get_elected5' => 'Why Did You Get Elected5',
            'why_did_you_get_elected6' => 'Why Did You Get Elected6',
            'why_did_you_get_elected7' => 'Why Did You Get Elected7',
            'why_did_you_get_elected8' => 'Why Did You Get Elected8',
            'why_did_you_get_elected9' => 'Why Did You Get Elected9',
            'if_you_were_a_member_of_a_self_help_group1' => 'If You Were A Member Of A Self Help Group1',
            'if_you_were_a_member_of_a_self_help_group2' => 'If You Were A Member Of A Self Help Group2',
            'if_you_were_a_member_of_a_self_help_group3' => 'If You Were A Member Of A Self Help Group3',
            'if_you_were_a_member_of_a_self_help_group4' => 'If You Were A Member Of A Self Help Group4',
            'if_you_were_a_member_of_a_self_help_group5' => 'If You Were A Member Of A Self Help Group5',
            'if_you_were_a_member_of_a_self_help_group6' => 'If You Were A Member Of A Self Help Group6',
            'if_you_were_a_member_of_a_self_help_group7' => 'If You Were A Member Of A Self Help Group7',
            'if_you_were_a_member_of_a_self_help_group8' => 'If You Were A Member Of A Self Help Group8',
            'if_you_were_a_member_of_a_self_help_group9' => 'If You Were A Member Of A Self Help Group9',
            'active_members_name1' => 'Active Members Name1',
            'active_members_name2' => 'Active Members Name2',
            'active_members_position1' => 'Active Members Position1',
            'active_members_position2' => 'Active Members Position2',
            'belongingness_name1' => 'Belongingness Name1',
            'belongingness_name2' => 'Belongingness Name2',
            'belongingness_position1' => 'Belongingness Position1',
            'belongingness_position2' => 'Belongingness Position2',
            'awareness_name1' => 'Awareness Name1',
            'awareness_name2' => 'Awareness Name2',
            'awareness_position1' => 'Awareness Position1',
            'awareness_position2' => 'Awareness Position2',
            'member_who_contact_in_other_group_name1' => 'Member Who Contact In Other Group Name1',
            'member_who_contact_in_other_group_name2' => 'Member Who Contact In Other Group Name2',
            'member_who_contact_in_other_group_position1' => 'Member Who Contact In Other Group Position1',
            'member_who_contact_in_other_group_position2' => 'Member Who Contact In Other Group Position2',
            'demanded_group_member_name1' => 'Demanded Group Member Name1',
            'demanded_group_member_name2' => 'Demanded Group Member Name2',
            'demanded_group_member_position1' => 'Demanded Group Member Position1',
            'demanded_group_member_position2' => 'Demanded Group Member Position2',
            'capable_fast_pace' => 'Capable Fast Pace',
            'why_demanded1' => 'Why Demanded1',
            'why_demanded2' => 'Why Demanded2',
            'why_demanded3' => 'Why Demanded3',
            'why_demanded4' => 'Why Demanded4',
            'why_demanded5' => 'Why Demanded5',
            'why_demanded6' => 'Why Demanded6',
            'if_you_have_group_members_what_are_they' => 'If You Have Group Members What Are They',
            'capable_fast_pace_member_name' => 'Capable Fast Pace Member Name',
            'capable_fast_pace_member_number' => 'Capable Fast Pace Member Number',
            'his_perception1' => 'His Perception1',
            'his_perception2' => 'His Perception2',
            'his_perception3' => 'His Perception3',
            'his_perception4' => 'His Perception4',
            'his_perception5' => 'His Perception5',
            'his_perception6' => 'His Perception6',
            'his_perception7' => 'His Perception7',
            'his_perception8' => 'His Perception8',
            'what_could_you_do_if_you_were_in_a_group1' => 'What Could You Do If You Were In A Group1',
            'what_could_you_do_if_you_were_in_a_group2' => 'What Could You Do If You Were In A Group2',
            'what_could_you_do_if_you_were_in_a_group3' => 'What Could You Do If You Were In A Group3',
            'what_could_you_do_if_you_were_in_a_group4' => 'What Could You Do If You Were In A Group4',
            'what_could_you_do_if_you_were_in_a_group5' => 'What Could You Do If You Were In A Group5',
            'what_could_you_do_if_you_were_in_a_group6' => 'What Could You Do If You Were In A Group6',
            'what_could_you_do_if_you_were_in_a_group7' => 'What Could You Do If You Were In A Group7',
            'what_could_you_do_if_you_were_in_a_group8' => 'What Could You Do If You Were In A Group8',
            'what_could_you_do_if_you_were_in_a_group9' => 'What Could You Do If You Were In A Group9',
            'most_contribute_index' => 'Most Contribute Index',
            'most_contribute_name' => 'Most Contribute Name',
            'group_culture' => 'Group Culture',
            'provision_in_the_group_as_voluntary' => 'Provision In The Group As Voluntary',
            'entrepreneurial_index' => 'Entrepreneurial Index',
            'entrepreneurial' => 'Entrepreneurial',
            'economic_status' => 'Economic Status',
            'afraid_unknown_rules_index1' => 'Afraid Unknown Rules Index1',
            'afraid_unknown_rules1' => 'Afraid Unknown Rules1',
            'afraid_unknown_rules_index2' => 'Afraid Unknown Rules Index2',
            'afraid_unknown_rules2' => 'Afraid Unknown Rules2',
            'concept_of_setting_up_new_heights_index' => 'Concept Of Setting Up New Heights Index',
            'concept_of_setting_up_new_heights' => 'Concept Of Setting Up New Heights',
            'livelihood_opportunity_for_another_member_index1' => 'Livelihood Opportunity For Another Member Index1',
            'livelihood_opportunity_for_another_member1' => 'Livelihood Opportunity For Another Member1',
            'livelihood_opportunity_for_another_member_index2' => 'Livelihood Opportunity For Another Member Index2',
            'livelihood_opportunity_for_another_member2' => 'Livelihood Opportunity For Another Member2',
            'negotiate_best_index1' => 'Negotiate Best Index1',
            'negotiate_best1' => 'Negotiate Best1',
            'negotiate_best_index2' => 'Negotiate Best Index2',
            'negotiate_best2' => 'Negotiate Best2',
            'which_member_can_talk_advantages_index1' => 'Which Member Can Talk Advantages Index1',
            'which_member_can_talk_advantages1' => 'Which Member Can Talk Advantages1',
            'which_member_can_talk_advantages_index2' => 'Which Member Can Talk Advantages Index2',
            'which_member_can_talk_advantages2' => 'Which Member Can Talk Advantages2',
            'can_read_write_hindi' => 'Can Read Write Hindi',
            'confirtable_in_english' => 'Confirtable In English',
            'recognize_english_hindi' => 'Recognize English Hindi',
            'can_add_substract_multiply' => 'Can Add Substract Multiply',
            'who_maintain_account_index' => 'Who Maintain Account Index',
            'who_maintain_account' => 'Who Maintain Account',
            'choose_other_meaning1' => 'Choose Other Meaning1',
            'choose_other_meaning2' => 'Choose Other Meaning2',
            'choose_other_meaning3' => 'Choose Other Meaning3',
            'choose_other_meaning4' => 'Choose Other Meaning4',
            'choose_other_meaning5' => 'Choose Other Meaning5',
            'same_to_same_word1' => 'Same To Same Word1',
            'same_to_same_word2' => 'Same To Same Word2',
            'same_to_same_word3' => 'Same To Same Word3',
            'english_to_hindi1' => 'English To Hindi1',
            'english_to_hindi2' => 'English To Hindi2',
            'english_to_hindi3' => 'English To Hindi3',
            'english_to_hindi4' => 'English To Hindi4',
            'english_to_hindi5' => 'English To Hindi5',
            'percentage_option1' => 'Percentage Option1',
            'percentage_option2' => 'Percentage Option2',
            'percentage_option3' => 'Percentage Option3',
            'percentage_option4' => 'Percentage Option4',
            'percentage_option5' => 'Percentage Option5',
            'option_decision1' => 'Option Decision1',
            'option_decision2' => 'Option Decision2',
            'option_decision3' => 'Option Decision3',
            'option_decision4' => 'Option Decision4',
            'option_decision5' => 'Option Decision5',
            'mobile_use_experience' => 'Mobile Use Experience',
            'whose_mobile_you_using' => 'Whose Mobile You Using',
            'no_of_people_using_phone' => 'No Of People Using Phone',
            'no_of_family_people_using_phone' => 'No Of Family People Using Phone',
            'need_help_to_fill_form' => 'Need Help To Fill Form',
            'already_worked' => 'Already Worked',
            'own_mobile' => 'Own Mobile',
            'own_mobile_means1' => 'Own Mobile Means1',
            'own_mobile_means2' => 'Own Mobile Means2',
            'own_mobile_means3' => 'Own Mobile Means3',
            'own_mobile_means4' => 'Own Mobile Means4',
            'own_mobile_means5' => 'Own Mobile Means5',
            'own_mobile_means6' => 'Own Mobile Means6',
            'own_mobile_means7' => 'Own Mobile Means7',
            'own_mobile_means8' => 'Own Mobile Means8',
            'method_used_for_ledger_account1' => 'Method Used For Ledger Account1',
            'method_used_for_ledger_account2' => 'Method Used For Ledger Account2',
            'method_used_for_ledger_account3' => 'Method Used For Ledger Account3',
            'method_used_for_ledger_account4' => 'Method Used For Ledger Account4',
            'method_used_for_ledger_account5' => 'Method Used For Ledger Account5',
            'method_used_for_ledger_account6' => 'Method Used For Ledger Account6',
            'need_training1' => 'Need Training1',
            'need_training2' => 'Need Training2',
            'need_training3' => 'Need Training3',
            'need_training4' => 'Need Training4',
            'need_training5' => 'Need Training5',
            'profile_photo' => 'Profile Photo',
            'aadhar_front_photo' => 'Aadhar Front Photo',
            'aadhar_back_photo' => 'Aadhar Back Photo',
            'gps' => 'Gps',
            'gps_accuracy' => 'Gps Accuracy',
            'reg_date_time' => 'Reg Date Time',
            'form_start_date' => 'Form Start Date',
            'form1_date_time' => 'Form1 Date Time',
            'form2_date_time' => 'Form2 Date Time',
            'form3_date_time' => 'Form3 Date Time',
            'form4_date_time' => 'Form4 Date Time',
            'form5_date_time' => 'Form5 Date Time',
            'form6_date_time' => 'Form6 Date Time',
            'form_number' => 'Form Number',
            'srlm_bc_selection_app_detail_id' => 'Srlm Bc Selection App Detail ID',
            'srlm_bc_selection_user_id' => 'Srlm Bc Selection User ID',
            'srlm_bc_selection_api_log_id' => 'Srlm Bc Selection Api Log ID',
            'sec1' => 'Sec1',
            'sec2' => 'Sec2',
            'sec3' => 'Sec3',
            'sec4' => 'Sec4',
            'sec5' => 'Sec5',
            'over_all' => 'Over All',
            'over_all_per' => 'Over All Per',
            'highest_score_in_gp' => 'Highest Score In Gp',
            'q1' => 'Q1',
            'q2' => 'Q2',
            'q3' => 'Q3',
            'q4' => 'Q4',
            'q5' => 'Q5',
            'q6' => 'Q6',
            'q7' => 'Q7',
            'q8' => 'Q8',
            'q9' => 'Q9',
            'q10' => 'Q10',
            'q11' => 'Q11',
            'q12' => 'Q12',
            'q13' => 'Q13',
            'q14' => 'Q14',
            'q15' => 'Q15',
            'q16' => 'Q16',
            'q17' => 'Q17',
            'q18' => 'Q18',
            'q19' => 'Q19',
            'q20' => 'Q20',
            'q21' => 'Q21',
            'q22' => 'Q22',
            'q23' => 'Q23',
            'q24' => 'Q24',
            'q25' => 'Q25',
            'q26' => 'Q26',
            'q27' => 'Q27',
            'q28' => 'Q28',
            'q29' => 'Q29',
            'q30' => 'Q30',
            'q31' => 'Q31',
            'q32' => 'Q32',
            'q33' => 'Q33',
            'q34' => 'Q34',
            'q35' => 'Q35',
            'q36' => 'Q36',
            'q37' => 'Q37',
            'q38' => 'Q38',
            'q39' => 'Q39',
            'q40' => 'Q40',
            'q41' => 'Q41',
            'q42' => 'Q42',
            'q43' => 'Q43',
            'q44' => 'Q44',
            'q45' => 'Q45',
            'q46' => 'Q46',
            'q47' => 'Q47',
            'q48' => 'Q48',
            'q49' => 'Q49',
            'q50' => 'Q50',
            'q51' => 'Q51',
            'q52' => 'Q52',
            'q53' => 'Q53',
            'q54' => 'Q54',
            'q55' => 'Q55',
            'q56' => 'Q56',
            'q57' => 'Q57',
            'q58' => 'Q58',
            'q59' => 'Q59',
            'q60' => 'Q60',
            'q61' => 'Q61',
            'q62' => 'Q62',
            'q63' => 'Q63',
            'q64' => 'Q64',
            'q65' => 'Q65',
            'q66' => 'Q66',
            'q67' => 'Q67',
            'q68' => 'Q68',
            'rating_process_status' => 'Rating Process Status',
            'selection_by' => 'Selection By',
            'selection_datetime' => 'Selection Datetime',
            'replaced' => 'Replaced',
            'call1' => 'Call1',
            'call1_by' => 'Call1 By',
            'call1_datetime' => 'Call1 Datetime',
            'call_by_rsetis' => 'Call By Rsetis',
            'call_rsetis_datetime' => 'Call Rsetis Datetime',
            'training_id' => 'Training ID',
            'training_center_id' => 'Training Center ID',
            'training_batch_id' => 'Training Batch ID',
            'training_status' => 'Training Status',
            'already_certified' => 'Already Certified',
            'exam_score' => 'Exam Score',
            'certificate_code' => 'Certificate Code',
            'pvr_status' => 'Pvr Status',
            'pvr_upload_by' => 'Pvr Upload By',
            'pvr_upload_date' => 'Pvr Upload Date',
            'pvr_upload_file_name' => 'Pvr Upload File Name',
            'iibf_photo_status' => 'Iibf Photo Status',
            'iibf_photo_upload_by' => 'Iibf Photo Upload By',
            'iibf_photo_upload_date' => 'Iibf Photo Upload Date',
            'iibf_photo_file_name' => 'Iibf Photo File Name',
            'iibf_by' => 'Iibf By',
            'iibf_date' => 'Iibf Date',
            'bc_photo_status' => 'Bc Photo Status',
            'cbo_bc_id' => 'Cbo Bc ID',
            'cbo_shg_id' => 'Cbo Shg ID',
            'user_id' => 'User ID',
            'assign_shg_by' => 'Assign Shg By',
            'assign_shg_datetime' => 'Assign Shg Datetime',
            'return_for_shg' => 'Return For Shg',
            'return_for_shg_by' => 'Return For Shg By',
            'return_for_shg_datetime' => 'Return For Shg Datetime',
            'onboarding' => 'Onboarding',
            'bankidbc' => 'Bankidbc',
            'bc_email_id' => 'Bc Email ID',
            'onboarding_by' => 'Onboarding By',
            'onboarding_date_time' => 'Onboarding Date Time',
            'bank_account_no_of_the_bc' => 'Bank Account No Of The Bc',
            'bank_id' => 'Bank ID',
            'name_of_bank' => 'Name Of Bank',
            'branch' => 'Branch',
            'branch_code_or_ifsc' => 'Branch Code Or Ifsc',
            'date_of_opening_the_bank_account' => 'Date Of Opening The Bank Account',
            'cin' => 'Cin',
            'passbook_photo' => 'Passbook Photo',
            'bank_account_no_of_the_shg' => 'Bank Account No Of The Shg',
            'bank_id_shg' => 'Bank Id Shg',
            'name_of_bank_shg' => 'Name Of Bank Shg',
            'branch_shg' => 'Branch Shg',
            'branch_code_or_ifsc_shg' => 'Branch Code Or Ifsc Shg',
            'passbook_photo_shg' => 'Passbook Photo Shg',
            'bc_bank' => 'Bc Bank',
            'shg_bank' => 'Shg Bank',
            'verify_bc_passbook_photo' => 'Verify Bc Passbook Photo',
            'verify_bc_passbook_not' => 'Verify Bc Passbook Not',
            'verify_bc_bank_account_no' => 'Verify Bc Bank Account No',
            'verify_bc_branch_code_or_ifsc' => 'Verify Bc Branch Code Or Ifsc',
            'verify_bc_ifsc_code_entered' => 'Verify Bc Ifsc Code Entered',
            'verify_bc_other' => 'Verify Bc Other',
            'verify_bc_other_reason' => 'Verify Bc Other Reason',
            'verify_bc_shg' => 'Verify Bc Shg',
            'verification_status_bc_bank' => 'Verification Status Bc Bank',
            'bc_bank_verify_by' => 'Bc Bank Verify By',
            'bc_bank_verify_date' => 'Bc Bank Verify Date',
            'verify_bc_shg_passbook_photo' => 'Verify Bc Shg Passbook Photo',
            'verify_bc_shg_name' => 'Verify Bc Shg Name',
            'verify_bc_shg_bank_account_no' => 'Verify Bc Shg Bank Account No',
            'verify_bc_shg_passbook_not' => 'Verify Bc Shg Passbook Not',
            'verify_bc_shg_other' => 'Verify Bc Shg Other',
            'verify_bc_shg_other_reason' => 'Verify Bc Shg Other Reason',
            'verify_bc_shg_branch_code_or_ifsc' => 'Verify Bc Shg Branch Code Or Ifsc',
            'verify_bc_shg_ifsc_code_entered' => 'Verify Bc Shg Ifsc Code Entered',
            'bc_shg_bank_verify_by' => 'Bc Shg Bank Verify By',
            'bc_shg_bank_verify_date' => 'Bc Shg Bank Verify Date',
            'verification_status_shg_bank' => 'Verification Status Shg Bank',
            'pfms_maped_status' => 'Pfms Maped Status',
            'bc_shg_funds_status' => 'Bc Shg Funds Status',
            'bc_shg_funds_date' => 'Bc Shg Funds Date',
            'bc_shg_funds_amount' => 'Bc Shg Funds Amount',
            'bc_shg_funds_by' => 'Bc Shg Funds By',
            'bc_support_funds_received' => 'Bc Support Funds Received',
            'bc_support_funds_received_date' => 'Bc Support Funds Received Date',
            'bc_support_funds_received_submitdate' => 'Bc Support Funds Received Submitdate',
            'bc_support_funds_received_amount' => 'Bc Support Funds Received Amount',
            'bc_support_funds_handheld_amount' => 'Bc Support Funds Handheld Amount',
            'bc_support_funds_od_amount' => 'Bc Support Funds Od Amount',
            'pan_card_status' => 'Pan Card Status',
            'pan_card_status_by' => 'Pan Card Status By',
            'pan_card_status_date' => 'Pan Card Status Date',
            'pan_number' => 'Pan Number',
            'pan_photo_upload' => 'Pan Photo Upload',
            'pan_photo' => 'Pan Photo',
            'pan_photo_date' => 'Pan Photo Date',
            'pan_photo_by' => 'Pan Photo By',
            'handheld_machine_status' => 'Handheld Machine Status',
            'handheld_machine_by' => 'Handheld Machine By',
            'handheld_machine_date' => 'Handheld Machine Date',
            'did_partner_bank_contact_bc' => 'Did Partner Bank Contact Bc',
            'bc_handheld_machine_recived' => 'Bc Handheld Machine Recived',
            'bc_handheld_machine_photo' => 'Bc Handheld Machine Photo',
            'bc_handheld_machine_recived_submitdate' => 'Bc Handheld Machine Recived Submitdate',
            'old_pfms' => 'Old Pfms',
            'beneficiaries_code' => 'Beneficiaries Code',
            'beneficiaries_code_by' => 'Beneficiaries Code By',
            'beneficiaries_code_date' => 'Beneficiaries Code Date',
            'revert_beneficiaries_code_by' => 'Revert Beneficiaries Code By',
            'revert_beneficiaries_reason' => 'Revert Beneficiaries Reason',
            'revert_beneficiaries_code_datetime' => 'Revert Beneficiaries Code Datetime',
            'bc_beneficiaries_code' => 'Bc Beneficiaries Code',
            'bc_beneficiaries_code_by' => 'Bc Beneficiaries Code By',
            'bc_beneficiaries_code_date' => 'Bc Beneficiaries Code Date',
            'training_feedback' => 'Training Feedback',
            'mobile_no' => 'Mobile No',
            'orig_otp_mobile_no' => 'Orig Otp Mobile No',
            'mobile_no_update_by' => 'Mobile No Update By',
            'mobile_no_update_date' => 'Mobile No Update Date',
            'viewtemp1' => 'Viewtemp1',
            'viewtemp2' => 'Viewtemp2',
            'viewtemp3' => 'Viewtemp3',
            'viewtemp4' => 'Viewtemp4',
            'viewtemp5' => 'Viewtemp5',
            'viewtemp6' => 'Viewtemp6',
            'viewtemp7' => 'Viewtemp7',
            'viewtemp8' => 'Viewtemp8',
            'viewtemp9' => 'Viewtemp9',
            'viewtemp10' => 'Viewtemp10',
            'viewtemp11' => 'Viewtemp11',
            'viewtemp12' => 'Viewtemp12',
            'viewtemp13' => 'Viewtemp13',
            'viewtemp14' => 'Viewtemp14',
            'bc_shg_name_update' => 'Bc Shg Name Update',
            'last_app_version' => 'Last App Version',
            'last_activity_time' => 'Last Activity Time',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'form_status' => 'Form Status',
            'status_new' => 'Status New',
            'status' => 'Status',
            'bc_payment_count' => 'Bc Payment Count',
            'master_partner_bank_id' => 'Master Partner Bank ID',
            'urban_shg' => 'Urban Shg',
            'missing_bc' => 'Missing Bc',
            'bc_unwilling_rsetis' => 'Bc Unwilling Rsetis',
            'bc_unwilling_rsetis_by' => 'Bc Unwilling Rsetis By',
            'bc_unwilling_rsetis_date' => 'Bc Unwilling Rsetis Date',
            'bc_unwilling_call_center' => 'Bc Unwilling Call Center',
            'bc_unwilling_call_center_by' => 'Bc Unwilling Call Center By',
            'bc_unwilling_call_center_date' => 'Bc Unwilling Call Center Date',
            'bc_unwilling_bank' => 'Bc Unwilling Bank',
            'bc_unwilling_bank_by' => 'Bc Unwilling Bank By',
            'bc_unwilling_bank_date' => 'Bc Unwilling Bank Date',
            'bc_unwilling_bank_call_center' => 'Bc Unwilling Bank Call Center',
            'bc_unwilling_bank_call_center_by' => 'Bc Unwilling Bank Call Center By',
            'bc_unwilling_bank_call_center_date' => 'Bc Unwilling Bank Call Center Date',
            'corona_feedback' => 'Corona Feedback',
            'blocked' => 'Blocked',
            'aadhar_duplicate' => 'Aadhar Duplicate',
            'application_phase' => 'Application Phase',
            'form_data_validate' => 'Form Data Validate',
        ];
    }

    public function beforeSave($insert) {
        if ($this->district_code) {
            $dis_model = \bc\models\master\MasterDistrict::findOne(['district_code' => $this->district_code]);
            if ($dis_model != self::NULL_VALUE) {
                $this->division_code = $dis_model->division_code;
                $this->division_name = $dis_model->division_name;
            }
        }

        return parent::beforeSave($insert);
    }

    public function getFulladdress() {

        $html = '';
        if (!empty($this->hamlet)) {
            $html .= 'Hamlet : ' . $this->hamlet . '<br/>';
        }
        if (!empty($this->village)) {
            $html .= 'Village  : ' . $this->village->village_name . '<br/>';
        }
        if (!empty($this->gp)) {
            $html .= 'Gram Panchayat  : ' . $this->gp->gram_panchayat_name . '<br/>';
        }
        if (!empty($this->block)) {
            $html .= 'Block : ' . $this->block->block_name . '<br/>';
        }
        if (!empty($this->district)) {
            $html .= 'District : ' . $this->district->district_name . '<br/>';
        }

        return $html;
    }

    public function getFulladdressdbgp() {

        $html = '';
        if (!empty($this->gp)) {
            $html .= 'Gram Panchayat  : ' . $this->gp->gram_panchayat_name . '<br/>';
        }
        if (!empty($this->block)) {
            $html .= 'Block : ' . $this->block->block_name . '<br/>';
        }
        if (!empty($this->district)) {
            $html .= 'District : ' . $this->district->district_name . '<br/>';
        }

        return $html;
    }

    public function getFulladdressgp() {

        $html = '';
        if (!empty($this->hamlet)) {
            $html .= 'Hamlet : ' . $this->hamlet . '<br/>';
        }
        if (!empty($this->village)) {
            $html .= 'Village  : ' . $this->village->village_name . '<br/>';
        }
        if (!empty($this->gp)) {
            $html .= 'GP  : ' . $this->gp->gram_panchayat_name . '<br/>';
        }


        return $html;
    }

    public function getName() {
        $html = '';
        if ($this->first_name)
            $html .= $this->first_name . ' ';
        if ($this->middle_name)
            $html .= $this->middle_name . ' ';
        if ($this->sur_name)
            $html .= $this->sur_name;
        return trim($html);
    }

    public function getUser() {
        return $this->hasOne(SrlmBcSelectionUser::className(), ['id' => 'srlm_bc_selection_user_id']);
    }

    public function getFamily() {
        return $this->hasMany(SrlmBcApplicationGroupFamily5::className(), ['srlm_bc_application_id' => 'id'])->where(['srlm_bc_application_group_family5.status' => base\GenralModel::STATUS_ACTIVE]);
    }

    public function getDistrict() {
        return $this->hasOne(\bc\models\master\MasterDistrict::className(), ['district_code' => 'district_code']);
    }

    public function getBlock() {
        return $this->hasOne(\bc\models\master\MasterBlock::className(), ['block_code' => 'block_code']);
    }

    public function getVillage() {
        return $this->hasOne(\bc\models\master\MasterVillage::className(), ['village_code' => 'village_code']);
    }

    public function getGp() {
        return $this->hasOne(\bc\models\master\MasterGramPanchayat::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }

    public function getGpdetail() {
        return $this->hasOne(\bc\models\master\MasterGramPanchayatDetailBc::className(), ['gram_panchayat_code' => 'gram_panchayat_code']);
    }

    public function getGenderrel() {
        return $this->hasOne(master\BcApplicationMasterGender::className(), ['id' => 'gender']);
    }

    public function getCastrel() {
        return $this->hasOne(master\BcApplicationMasterCast::className(), ['id' => 'cast']);
    }

    public function getBcsreguser() {
        return $this->hasOne(SrlmBcSelectionUser::className(), ['id' => 'srlm_bc_selection_user_id']);
    }

    public function getReadingskills() {
        return $this->hasOne(master\BcApplicationMasterReadingSkills::className(), ['id' => 'reading_skills']);
    }

    public function getPhonetype() {
        return $this->hasOne(master\BcApplicationMasterPhoneType::className(), ['id' => 'phone_type']);
    }

    public function getWewm() {
        $models = master\BcApplicationMasterWhatElseWithMobile::find()->where(['status' => 1])->all();
        $option_array = \yii\helpers\ArrayHelper::map($models, 'id', 'name_hi');
        $html = '';

        foreach ($option_array as $key => $option) {
            $name = 'what_else_with_mobile' . $key;
            if ($this->$name == '1') {
                $html .= '<img src="/images/checked_checkbox.png" alt="Yes"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            } else {
                $html .= '<img src="/images/unchecked_checkbox.png" alt="No"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            }
        }

        return $html;
    }

    public function getWatsup() {
        return $this->hasOne(master\BcApplicationMasterYesno::className(), ['id' => 'whats_app_number']);
    }

    public function getVd() {
        $models = master\BcApplicationMasterVechicleDrive::find()->where(['status' => 1])->all();
        $option_array = \yii\helpers\ArrayHelper::map($models, 'id', 'name_hi');
        $html = '';

        foreach ($option_array as $key => $option) {
            $name = 'vechicle_drive' . $key;
            if ($this->$name == '1') {
                $html .= '<img src="/images/checked_checkbox.png" alt="Yes"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            } else {
                $html .= '<img src="/images/unchecked_checkbox.png" alt="No"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            }
        }

        return $html;
    }

    public function getFs() {
        $models = master\BcApplicationMasterFutureScope::find()->where(['status' => 1])->all();
        $option_array = \yii\helpers\ArrayHelper::map($models, 'id', 'name_hi');
        $html = '';

        foreach ($option_array as $key => $option) {
            $name = 'future_scope' . $key;
            if ($this->$name == '1') {
                $html .= '<img src="/images/checked_checkbox.png" alt="Yes"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            } else {
                $html .= '<img src="/images/unchecked_checkbox.png" alt="No"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            }
        }

        return $html;
    }

    public function getOfl() {
        $models = master\BcApplicationMasterOpportunitiesForLivelihood::find()->where(['status' => 1])->all();
        $option_array = \yii\helpers\ArrayHelper::map($models, 'id', 'name_hi');
        $html = '';

        foreach ($option_array as $key => $option) {
            $name = 'future_scope' . $key;
            if ($this->$name == '1') {
                $html .= '<img src="/images/checked_checkbox.png" alt="Yes"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            } else {
                $html .= '<img src="/images/unchecked_checkbox.png" alt="No"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            }
        }

        return $html;
    }

    public function getPi() {
        $models = master\BcApplicationMasterPlanningIntervention::find()->where(['status' => 1])->all();
        $option_array = \yii\helpers\ArrayHelper::map($models, 'id', 'name_hi');
        $html = '';

        foreach ($option_array as $key => $option) {
            $name = 'planning_intervention' . $key;
            if ($this->$name == '1') {
                $html .= '<img src="/images/checked_checkbox.png" alt="Yes"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            } else {
                $html .= '<img src="/images/unchecked_checkbox.png" alt="No"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            }
        }

        return $html;
    }

    public function getIas() {
        $models = master\BcApplicationMasterImmediateAspiration::find()->where(['status' => 1])->all();
        $option_array = \yii\helpers\ArrayHelper::map($models, 'id', 'name_hi');
        $html = '';

        foreach ($option_array as $key => $option) {
            $name = 'immediate_aspiration' . $key;
            if ($this->$name == '1') {
                $html .= '<img src="/images/checked_checkbox.png" alt="Yes"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            } else {
                $html .= '<img src="/images/unchecked_checkbox.png" alt="No"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            }
        }

        return $html;
    }

// part 1 
// 3 try_towards_group_formation1
    public function getTrytgf() {
        $models = master\BcApplicationMasterTryTowardsGroupFormation::find()->where(['status' => 1])->all();
        $option_array = \yii\helpers\ArrayHelper::map($models, 'id', 'name_hi');
        $html = '';

        foreach ($option_array as $key => $option) {
            $name = 'try_towards_group_formation' . $key;
            if ($this->$name == '1') {
                $html .= '<img src="/images/checked_checkbox.png" alt="Yes"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            } else {
                $html .= '<img src="/images/unchecked_checkbox.png" alt="No"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            }
        }

        return $html;
    }

    // 5 role_in_group   
    public function getRolingroup() {
        $models = master\BcApplicationMasterRoleInGroup::find()->where(['status' => 1])->all();
        $option_array = \yii\helpers\ArrayHelper::map($models, 'id', 'name_hi');
        $html = '';

        foreach ($option_array as $key => $option) {
            $name = 'role_in_group' . $key;
            if ($this->$name == '1') {
                $html .= '<img src="/images/checked_checkbox.png" alt="Yes"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            } else {
                $html .= '<img src="/images/unchecked_checkbox.png" alt="No"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            }
        }

        return $html;
    }

    // 5 if_you_have_group_members_what_are_they अगर आपने समूह के सदस्यों के बारे में है, तो वे क्या है?  
    public function getIfyougroupmemberswhatarethe() {
        return $this->hasOne(master\BcApplicationMasterGroupMembersWhatAreThey::className(), ['id' => 'if_you_have_group_members_what_are_they']);
    }

// 6 what_could_you_do_if_you_were_in_a_group1  
    public function getWcydoiywiagroup() {
        $models = master\BcApplicationMasterYouDoWereInAGroup::find()->where(['status' => 1])->all();
        $option_array = \yii\helpers\ArrayHelper::map($models, 'id', 'name_hi');
        $html = '';

        foreach ($option_array as $key => $option) {
            $name = 'what_could_you_do_if_you_were_in_a_group' . $key;
            if ($this->$name == '1') {
                $html .= '<img src="/images/checked_checkbox.png" alt="Yes"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            } else {
                $html .= '<img src="/images/unchecked_checkbox.png" alt="No"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            }
        }

        return $html;
    }

// 7.why_did_you_get_elected
    public function getWdygelect() {
        $models = master\BcApplicationMasterWhyDidYouGetElected::find()->where(['status' => 1])->all();
        $option_array = \yii\helpers\ArrayHelper::map($models, 'id', 'name_hi');
        $html = '';

        foreach ($option_array as $key => $option) {
            $name = 'why_did_you_get_elected' . $key;
            if ($this->$name == '1') {
                $html .= '<img src="/images/checked_checkbox.png" alt="Yes"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            } else {
                $html .= '<img src="/images/unchecked_checkbox.png" alt="No"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            }
        }

        return $html;
    }

    // 6what_could_you_do_if_you_were_in_a_group1
    public function getWcydiyiagroup() {
        $models = master\BcApplicationMasterYouDoWereInAGroup::find()->where(['status' => 1])->all();
        $option_array = \yii\helpers\ArrayHelper::map($models, 'id', 'name_hi');
        $html = '';

        foreach ($option_array as $key => $option) {
            $name = 'what_could_you_do_if_you_were_in_a_group' . $key;
            if ($this->$name == '1') {
                $html .= '<img src="/images/checked_checkbox.png" alt="Yes"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            } else {
                $html .= '<img src="/images/unchecked_checkbox.png" alt="No"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            }
        }

        return $html;
    }

    // 13 why_demanded1
    public function getWhydemanded() {
        $models = master\BcApplicationMasterWhyDemanded::find()->where(['status' => 1])->all();
        $option_array = \yii\helpers\ArrayHelper::map($models, 'id', 'name_hi');
        $html = '';

        foreach ($option_array as $key => $option) {
            $name = 'why_demanded' . $key;
            if ($this->$name == 1) {
                $html .= '<img src="/images/checked_checkbox.png" alt="Yes"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            } else {
                $html .= '<img src="/images/unchecked_checkbox.png" alt="No"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            }
        }

        return $html;
    }

    //14 capablefastpace
    public function getCapablefastpace() {
        return $this->hasOne(master\BcApplicationMasterYesno::className(), ['id' => 'capable_fast_pace']);
    }

    // 17 his_perception
    public function getHisperception() {
        $models = master\BcApplicationMasterHisPerception::find()->where(['status' => 1])->all();
        $option_array = \yii\helpers\ArrayHelper::map($models, 'id', 'name_hi');
        $html = '';

        foreach ($option_array as $key => $option) {
            $name = 'his_perception' . $key;
            if ($this->$name == 1) {
                $html .= '<img src="/images/checked_checkbox.png" alt="Yes"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            } else {
                $html .= '<img src="/images/unchecked_checkbox.png" alt="No"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            }
        }

        return $html;
    }

//paert2 
    public function getGroupculture() {
        return $this->hasOne(master\BcApplicationMasterYesno::className(), ['id' => 'group_culture']);
    }

    public function getProvisioninthegroupasvoluntary() {
        return $this->hasOne(master\BcApplicationMasterYesno::className(), ['id' => 'provision_in_the_group_as_voluntary']);
    }

    public function getEconomicstatus() {
        return $this->hasOne(master\BcApplicationMasterEconomicStatus::className(), ['id' => 'economic_status']);
    }

// part 3
    public function getCanreadwritehindi() {
        return $this->hasOne(master\BcApplicationMasterCanReadWriteHindi::className(), ['id' => 'can_read_write_hindi']);
    }

    public function getConfirtableinenglish() {
        return $this->hasOne(master\BcApplicationMasterConfirtableInEnglish::className(), ['id' => 'confirtable_in_english']);
    }

    public function getRecognizeenglishhindi() {
        return $this->hasOne(master\BcApplicationMasterYesno::className(), ['id' => 'recognize_english_hindi']);
    }

    public function getCanaddsubstractmultiply() {
        return $this->hasOne(master\BcApplicationMasterCanReadWriteHindi::className(), ['id' => 'can_add_substract_multiply']);
    }

    public function getOthermeaning1() {
        return $this->hasOne(master\BcApplicationMasterOtherMeaning1::className(), ['id' => 'choose_other_meaning1']);
    }

    public function getOthermeaning2() {
        return $this->hasOne(master\BcApplicationMasterOtherMeaning2::className(), ['id' => 'choose_other_meaning2']);
    }

    public function getOthermeaning3() {
        return $this->hasOne(master\BcApplicationMasterOtherMeaning3::className(), ['id' => 'choose_other_meaning3']);
    }

    public function getOthermeaning4() {
        return $this->hasOne(master\BcApplicationMasterOtherMeaning4::className(), ['id' => 'choose_other_meaning4']);
    }

    public function getOthermeaning5() {
        return $this->hasOne(master\BcApplicationMasterOtherMeaning5::className(), ['id' => 'choose_other_meaning5']);
    }

    public function getSameword1() {
        return $this->hasOne(master\BcApplicationMasterSameWord1::className(), ['id' => 'same_to_same_word1']);
    }

    public function getSameword2() {
        return $this->hasOne(master\BcApplicationMasterSameWord2::className(), ['id' => 'same_to_same_word2']);
    }

    public function getSameword3() {
        return $this->hasOne(master\BcApplicationMasterSameWord3::className(), ['id' => 'same_to_same_word3']);
    }

    //english_to_hindi1
    public function getEnglishtohindi1() {
        return $this->hasOne(master\BcApplicationMasterEnglishToHindi1::className(), ['id' => 'english_to_hindi1']);
    }

    public function getEnglishtohindi2() {
        return $this->hasOne(master\BcApplicationMasterEnglishToHindi2::className(), ['id' => 'english_to_hindi2']);
    }

    public function getEnglishtohindi3() {
        return $this->hasOne(master\BcApplicationMasterEnglishToHindi3::className(), ['id' => 'english_to_hindi3']);
    }

    public function getEnglishtohindi4() {
        return $this->hasOne(master\BcApplicationMasterEnglishToHindi4::className(), ['id' => 'english_to_hindi4']);
    }

    public function getEnglishtohindi5() {
        return $this->hasOne(master\BcApplicationMasterEnglishToHindi5::className(), ['id' => 'english_to_hindi5']);
    }

    public function getPercentageoption1() {
        return $this->hasOne(master\BcApplicationMasterPercentageOption1::className(), ['id' => 'percentage_option1']);
    }

    public function getPercentageoption2() {
        return $this->hasOne(master\BcApplicationMasterPercentageOption2::className(), ['id' => 'percentage_option2']);
    }

    public function getPercentageoption3() {
        return $this->hasOne(master\BcApplicationMasterPercentageOption3::className(), ['id' => 'percentage_option3']);
    }

    public function getPercentageoption4() {
        return $this->hasOne(master\BcApplicationMasterPercentageOption4::className(), ['id' => 'percentage_option4']);
    }

    public function getPercentageoption5() {
        return $this->hasOne(master\BcApplicationMasterPercentageOption5::className(), ['id' => 'percentage_option5']);
    }

    public function getOptiondecision1() {
        return $this->hasOne(master\BcApplicationMasterOptionDecision1::className(), ['id' => 'option_decision1']);
    }

    public function getOptiondecision2() {
        return $this->hasOne(master\BcApplicationMasterOptionDecision2::className(), ['id' => 'option_decision2']);
    }

    public function getOptiondecision3() {
        return $this->hasOne(master\BcApplicationMasterOptionDecision3::className(), ['id' => 'option_decision3']);
    }

    public function getOptiondecision4() {
        return $this->hasOne(master\BcApplicationMasterOptionDecision4::className(), ['id' => 'option_decision4']);
    }

    public function getOptiondecision5() {
        return $this->hasOne(master\BcApplicationMasterOptionDecision5::className(), ['id' => 'option_decision5']);
    }

    public function getProfile_photo_path() {

        return \Yii::$app->params['datapath'] . "srlm/bcselection/photo/" . $this->srlm_bc_selection_user_id . "/" . $this->profile_photo;
    }

    public function getAadhar_front_photo_path() {

        return \Yii::$app->params['datapath'] . "srlm/bcselection/photo/" . $this->srlm_bc_selection_user_id . "/" . $this->aadhar_front_photo;
    }

    public function getAadhar_back_photo_path() {
        return \Yii::$app->params['datapath'] . "srlm/bcselection/photo/" . $this->srlm_bc_selection_user_id . "/" . $this->aadhar_back_photo;
    }

    public function getProfile_photo_path_for_pdf() {

        return \Yii::$app->params['bcdatapath'] . "bcselection/bcprofile/" . $this->srlm_bc_selection_user_id . "/" . $this->profile_photo;
    }

    public function getAadhar_front_photo_path_for_pdf() {

        return \Yii::$app->params['bcdatapath'] . "bcselection/bcprofile/" . $this->srlm_bc_selection_user_id . "/" . $this->aadhar_front_photo;
    }

    public function getAadhar_back_photo_path_for_pdf() {
        return \Yii::$app->params['bcdatapath'] . "bcselection/bcprofile/" . $this->srlm_bc_selection_user_id . "/" . $this->aadhar_back_photo;
    }

    public function getProfile_photo_url() {
        //return "/srlm/user/getphoto?user_id=" . $this->srlm_bc_selection_user_id . "&photo_name=profile_photo";
        return "/getimage/bcprofile/" . $this->srlm_bc_selection_user_id . "/" . $this->profile_photo;
    }

    public function getAadhar_front_photo_url() {
        //return "/srlm/user/getphoto?user_id=" . $this->srlm_bc_selection_user_id . "&photo_name=aadhar_front_photo";
        return "/getimage/bcprofile/" . $this->srlm_bc_selection_user_id . "/" . $this->aadhar_front_photo;
    }

    public function getPan_photo_url() {

        return "/getimage/bcprofile/" . $this->srlm_bc_selection_user_id . "/" . $this->pan_photo;
    }

    public function getAadhar_back_photo_url() {
        //return "/srlm/user/getphoto?user_id=" . $this->srlm_bc_selection_user_id . "&photo_name=aadhar_back_photo";
        return "/getimage/bcprofile/" . $this->srlm_bc_selection_user_id . "/" . $this->aadhar_back_photo;
    }

    public function getIibf_photo_url() {
        return "/getimage/bcprofile/" . $this->srlm_bc_selection_user_id . "/" . $this->iibf_photo_file_name;
    }

    public function getPvr_upload_file_name_url() {
        return "/getimage/bcprofile/" . $this->srlm_bc_selection_user_id . "/" . $this->pvr_upload_file_name;
    }

    public function getPassbook_photo_url() {
        return "/getimage/bcprofile/" . $this->srlm_bc_selection_user_id . "/" . $this->passbook_photo;
    }

    public function getPassbook_photo_shg_url() {
        return "/getimage/bcprofile/" . $this->srlm_bc_selection_user_id . "/shg/" . $this->passbook_photo_shg;
    }

    public function getBc_handheld_machine_photo_url() {
        return "/getimage/bcprofile/" . $this->srlm_bc_selection_user_id . "/" . $this->bc_handheld_machine_photo;
    }

    public function getMs() {
        return $this->hasOne(master\BcApplicationMasterYesno::className(), ['id' => 'marital_status']);
    }

    public function getAgm() {
        return $this->hasOne(master\BcApplicationMasterAlreadyGroupMember::className(), ['id' => 'already_group_member']);
    }

    public function getWhygformed() {
        return $this->hasOne(master\BcApplicationMasterWhichProgramYourGroupFormed::className(), ['id' => 'which_program_your_group_formed']);
    }

    public function getThofformg() {
        return $this->hasOne(master\BcApplicationMasterYesno::className(), ['id' => 'thought_of_forming_group']);
    }

    public function getMusee() {
        return $this->hasOne(master\BcApplicationMasterMobileUseExperience::className(), ['id' => 'mobile_use_experience']);
    }

    public function getWhosemuse() {
        return $this->hasOne(master\BcApplicationMasterWhoseMobileYouUsing::className(), ['id' => 'whose_mobile_you_using']);
    }

    public function getNeedhelptofillform() {
        return $this->hasOne(master\BcApplicationMasterNeedHelpToFillForm::className(), ['id' => 'need_help_to_fill_form']);
    }

    public function getAw() {
        return $this->hasOne(master\BcApplicationMasterYesno::className(), ['id' => 'already_worked']);
    }

    public function getOwnmobile() {
        return $this->hasOne(master\BcApplicationMasterOwnMobile::className(), ['id' => 'own_mobile']);
    }

    public function getOwn_mobile_means() {
        $models = master\BcApplicationMasterOwnMobileMeans::find()->where(['status' => 1])->all();
        $option_array = \yii\helpers\ArrayHelper::map($models, 'id', 'name_hi');
        $html = '';

        foreach ($option_array as $key => $option) {
            $name = 'own_mobile_means' . $key;
            if ($this->$name == 1) {
                $html .= '<img src="/images/checked_checkbox.png" alt="Yes"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            } else {
                $html .= '<img src="/images/unchecked_checkbox.png" alt="No"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            }
        }

        return $html;
    }

    public function getMethod_used_for_ledger_account() {
        $models = master\bcApplicationMasterMethodUsedForLedgerAccount::find()->where(['status' => 1])->all();
        $option_array = \yii\helpers\ArrayHelper::map($models, 'id', 'name_hi');
        $html = '';

        foreach ($option_array as $key => $option) {
            $name = 'method_used_for_ledger_account' . $key;
            if ($this->$name == 1) {
                $html .= '<img src="/images/checked_checkbox.png" alt="Yes"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            } else {
                $html .= '<img src="/images/unchecked_checkbox.png" alt="No"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            }
        }

        return $html;
    }

    public function getNeed_training() {
        $models = master\BcApplicationMasterNeedTraining::find()->where(['status' => 1])->all();
        $option_array = \yii\helpers\ArrayHelper::map($models, 'id', 'name_hi');
        $html = '';

        foreach ($option_array as $key => $option) {
            $name = 'need_training' . $key;
            if ($this->$name == 1) {
                $html .= '<img src="/images/checked_checkbox.png" alt="Yes"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            } else {
                $html .= '<img src="/images/unchecked_checkbox.png" alt="No"> <span> ' . str_replace('*', '', $option) . '</span><br/>';
            }
        }

        return $html;
    }

    public function getRatingchoseother() {
        return ($this->q34 + $this->q35 + $this->q36 + $this->q37 + $this->q38);
    }

    public function getRatingsameword() {
        return ($this->q39 + $this->q40 + $this->q41);
    }

    public function getRatingenglishtohindi() {
        return ($this->q42 + $this->q43 + $this->q44 + $this->q45 + $this->q46);
    }

    public function getRatingpercentageoption() {
        return ($this->q47 + $this->q48 + $this->q49 + $this->q50 + $this->q51);
    }

    public function getRatingengoptiondecision() {
        return ($this->q52 + $this->q53 + $this->q54 + $this->q55 + $this->q56);
    }

    public function getAppgp($model, $search) {
        $query = $this->find()
                ->select(['`srlm_bc_application2`.`gram_panchayat_code`'])
                ->distinct();
        $query->andWhere(['!=', 'srlm_bc_application2.status', 0]);
        $query->andWhere(['!=', 'srlm_bc_application2.status', -1]);
        $query->andWhere(['not', ['srlm_bc_application2.gram_panchayat_code' => null]]);
        $query->andWhere(['srlm_bc_application2.form_number' => 6]);
        $query->andWhere(['srlm_bc_application2.gender' => 2]);
        if ($search->report_type == 1) {
            $query->andWhere(['srlm_bc_application2.district_code' => $model->district_code]);
        }
        if ($search->report_type == 2) {
            $query->andWhere(['srlm_bc_application2.block_code' => $model->block_code]);
        }
        if ($search->report_type == 3) {
            $query->andWhere(['srlm_bc_application2.gram_panchayat_code' => $model->gram_panchayat_code]);
        }
        if ($search->district_code) {
            $query->andWhere(['srlm_bc_application2.district_code' => $search->district_code]);
        }
        if ($search->block_code) {
            $query->andWhere(['srlm_bc_application2.block_code' => $search->block_code]);
        }
        if ($search->cast) {
            $query->andWhere(['srlm_bc_application2.cast' => $search->cast]);
        }
        if ($search->reading_skills) {
            $query->andWhere(['srlm_bc_application2.reading_skills' => $search->reading_skills]);
        }
        if ($search->phone_type) {
            $query->andWhere(['srlm_bc_application2.phone_type' => $search->phone_type]);
        }
        if ($search->marital_status) {
            $query->andWhere(['srlm_bc_application2.marital_status' => $search->marital_status]);
        }
        if ($search->already_group_member) {
            $query->andWhere(['srlm_bc_application2.already_group_member' => $search->already_group_member]);
        }
        if ($model->already_group_member) {
            $query->andWhere(['srlm_bc_application2.already_group_member' => $model->already_group_member]);
        }
        if ($model->highest_score_in_gp == "Y") {
            $query->andWhere(['highest_score_in_gp' => '1']);
        }
        if ($search->age_group == '1') {
            $query->andWhere(['between', 'srlm_bc_application2.age', '18', '25']);
        } else if ($search->age_group == '2') {
            $query->andWhere(['between', 'srlm_bc_application2.age', '26', '32']);
        } else if ($search->age_group == '3') {
            $query->andWhere(['between', 'srlm_bc_application2.age', '33', '40']);
        } else if ($search->age_group == '4') {
            $query->andWhere(['between', 'srlm_bc_application2.age', '41', '50']);
        } else if ($search->age_group == '5') {
            $query->andWhere(['between', 'srlm_bc_application2.age', '51', '200']);
        }
        return $query->count();
    }

    public function getIsallphoto() {
        return ($this->user->profile_photo and $this->user->aadhar_front_photo and $this->user->aadhar_back_photo) ? 1 : 0;
    }

    public function getIsopenbcbankdetail() {
        return ($this->bank_account_no_of_the_bc and $this->name_of_bank and $this->branch and $this->branch_code_or_ifsc and $this->passbook_photo and in_array($this->bc_bank, [1, 2])) ? 0 : 1;
    }

}
