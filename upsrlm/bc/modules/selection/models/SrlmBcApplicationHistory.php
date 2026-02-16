<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "srlm_bc_application_history".
 *
 * @property int $id
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
 * @property int|null $onboarding_by
 * @property string|null $bankbcid
 * @property string|null $bc_email_id
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
 * @property int $missing_bc
 * @property int|null $bc_unwilling_rsetis
 * @property int|null $bc_unwilling_rsetis_by
 * @property string|null $bc_unwilling_rsetis_date
 * @property int|null $bc_unwilling_call_center
 * @property int|null $bc_unwilling_call_center_by
 * @property string|null $bc_unwilling_call_center_date
 * @property int|null $bc_unwilling_bc
 * @property int|null $bc_unwilling_bc_by
 * @property string|null $bc_unwilling_bc_date
 * @property int|null $bc_unwilling_cdo
 * @property int|null $bc_unwilling_cdo_by
 * @property string|null $bc_unwilling_cdo_date
 * @property int|null $bc_unwilling_upsrlm
 * @property int|null $bc_unwilling_upsrlm_by
 * @property string|null $bc_unwilling_upsrlm_date
 * @property string|null $temp_bankidbc
 * @property int|null $temp_bankidbc_by
 * @property string|null $temp_bankidbc_datetime
 * @property string|null $changebankid_datetime
 * @property int $corona_feedback
 * @property int $blocked
 * @property int|null $blocked_by
 * @property string|null $blocked_date
 * @property string|null $alt_mobile_no
 * @property int $shg_confirm_funds_return
 * @property string|null $shg_confirm_funds_return_date
 * @property string|null $shg_confirm_funds_return_photo
 * @property int $bc_operational
 * @property int|null $bc_settlement_account_bank_id
 * @property int $bc_settlement_account_bank_confirm
 * @property string|null $bc_settlement_account_bank_name
 * @property string|null $bc_settlement_account_ifsc_code
 * @property string|null $bc_settlement_account_no
 * @property int $bc_settlement_ac_194n
 * @property string|null $bc_settlement_ac_194n_date
 * @property int|null $bc_settlement_ac_194n_by
 * @property int|null $parent_id
 * @property int|null $action_type
 */
class SrlmBcApplicationHistory extends BcactiveRecord {

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
    const ACTION_TYPE_ALT_MOBILE_NO = 150;
    const ZERO_VALUE = 0;
    const BLANK_VALUE = '';
    const NULL_VALUE = NULL;

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
        return 'srlm_bc_application_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['gender', 'age', 'cast', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'reading_skills', 'phone_type', 'what_else_with_mobile1', 'what_else_with_mobile2', 'what_else_with_mobile3', 'what_else_with_mobile4', 'what_else_with_mobile5', 'whats_app_number', 'vechicle_drive1', 'vechicle_drive2', 'vechicle_drive3', 'vechicle_drive4', 'vechicle_drive5', 'vechicle_drive6', 'vechicle_drive7', 'marital_status', 'house_member_details1', 'house_member_details2', 'house_member_details3', 'future_scope1', 'future_scope2', 'future_scope3', 'future_scope4', 'future_scope5', 'future_scope6', 'future_scope7', 'future_scope8', 'future_scope9', 'future_scope10', 'future_scope11', 'future_scope12', 'future_scope13', 'opportunities_for_livelihood1', 'opportunities_for_livelihood2', 'opportunities_for_livelihood3', 'opportunities_for_livelihood4', 'opportunities_for_livelihood5', 'opportunities_for_livelihood6', 'opportunities_for_livelihood7', 'opportunities_for_livelihood8', 'opportunities_for_livelihood9', 'opportunities_for_livelihood10', 'planning_intervention1', 'planning_intervention2', 'planning_intervention3', 'planning_intervention4', 'planning_intervention5', 'planning_intervention6', 'immediate_aspiration1', 'immediate_aspiration2', 'immediate_aspiration3', 'immediate_aspiration4', 'immediate_aspiration5', 'immediate_aspiration6', 'already_group_member', 'which_program_your_group_formed', 'thought_of_forming_group', 'try_towards_group_formation1', 'try_towards_group_formation2', 'try_towards_group_formation3', 'try_towards_group_formation4', 'try_towards_group_formation5', 'try_towards_group_formation6', 'try_towards_group_formation7', 'try_towards_group_formation8', 'leadership_name_index', 'role_in_group1', 'role_in_group2', 'role_in_group3', 'role_in_group4', 'role_in_group5', 'role_in_group6', 'role_in_group7', 'role_in_group8', 'why_did_you_get_elected1', 'why_did_you_get_elected2', 'why_did_you_get_elected3', 'why_did_you_get_elected4', 'why_did_you_get_elected5', 'why_did_you_get_elected6', 'why_did_you_get_elected7', 'why_did_you_get_elected8', 'why_did_you_get_elected9', 'if_you_were_a_member_of_a_self_help_group1', 'if_you_were_a_member_of_a_self_help_group2', 'if_you_were_a_member_of_a_self_help_group3', 'if_you_were_a_member_of_a_self_help_group4', 'if_you_were_a_member_of_a_self_help_group5', 'if_you_were_a_member_of_a_self_help_group6', 'if_you_were_a_member_of_a_self_help_group7', 'if_you_were_a_member_of_a_self_help_group8', 'if_you_were_a_member_of_a_self_help_group9', 'active_members_position1', 'active_members_position2', 'belongingness_position1', 'belongingness_position2', 'awareness_position1', 'awareness_position2', 'member_who_contact_in_other_group_position1', 'member_who_contact_in_other_group_position2', 'demanded_group_member_position1', 'demanded_group_member_position2', 'capable_fast_pace', 'why_demanded1', 'why_demanded2', 'why_demanded3', 'why_demanded4', 'why_demanded5', 'why_demanded6', 'if_you_have_group_members_what_are_they', 'capable_fast_pace_member_number', 'his_perception1', 'his_perception2', 'his_perception3', 'his_perception4', 'his_perception5', 'his_perception6', 'his_perception7', 'his_perception8', 'what_could_you_do_if_you_were_in_a_group1', 'what_could_you_do_if_you_were_in_a_group2', 'what_could_you_do_if_you_were_in_a_group3', 'what_could_you_do_if_you_were_in_a_group4', 'what_could_you_do_if_you_were_in_a_group5', 'what_could_you_do_if_you_were_in_a_group6', 'what_could_you_do_if_you_were_in_a_group7', 'what_could_you_do_if_you_were_in_a_group8', 'what_could_you_do_if_you_were_in_a_group9', 'most_contribute_index', 'group_culture', 'provision_in_the_group_as_voluntary', 'entrepreneurial_index', 'economic_status', 'afraid_unknown_rules_index1', 'afraid_unknown_rules_index2', 'concept_of_setting_up_new_heights_index', 'livelihood_opportunity_for_another_member_index1', 'livelihood_opportunity_for_another_member_index2', 'negotiate_best_index1', 'negotiate_best_index2', 'which_member_can_talk_advantages_index1', 'which_member_can_talk_advantages_index2', 'can_read_write_hindi', 'confirtable_in_english', 'recognize_english_hindi', 'can_add_substract_multiply', 'who_maintain_account_index', 'choose_other_meaning1', 'choose_other_meaning2', 'choose_other_meaning3', 'choose_other_meaning4', 'choose_other_meaning5', 'same_to_same_word1', 'same_to_same_word2', 'same_to_same_word3', 'english_to_hindi1', 'english_to_hindi2', 'english_to_hindi3', 'english_to_hindi4', 'english_to_hindi5', 'percentage_option1', 'percentage_option2', 'percentage_option3', 'percentage_option4', 'percentage_option5', 'option_decision1', 'option_decision2', 'option_decision3', 'option_decision4', 'option_decision5', 'mobile_use_experience', 'whose_mobile_you_using', 'need_help_to_fill_form', 'already_worked', 'own_mobile', 'own_mobile_means1', 'own_mobile_means2', 'own_mobile_means3', 'own_mobile_means4', 'own_mobile_means5', 'own_mobile_means6', 'own_mobile_means7', 'own_mobile_means8', 'method_used_for_ledger_account1', 'method_used_for_ledger_account2', 'method_used_for_ledger_account3', 'method_used_for_ledger_account4', 'method_used_for_ledger_account5', 'method_used_for_ledger_account6', 'need_training1', 'need_training2', 'need_training3', 'need_training4', 'need_training5', 'form_number', 'srlm_bc_selection_app_detail_id', 'srlm_bc_selection_user_id', 'no_of_family_people_using_phone', 'created_by', 'updated_by', 'created_at', 'updated_at', 'form_status', 'status', 'parent_id', 'action_type', 'srlm_bc_selection_api_log_id', 'selection_by'], 'integer'],
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
            [['action_type'], 'default', 'value' => self::ACTION_TYPE_REG],
            [['form_status'], 'default', 'value' => self::FORM_STATUS_REG],
            [['which_member_can_talk_advantages2'], 'default', 'value' => self::BLANK_VALUE],
            [['mobile_use_experience'], 'default', 'value' => self::ZERO_VALUE],
            [['whose_mobile_you_using'], 'default', 'value' => self::ZERO_VALUE],
            [['no_of_people_using_phone'], 'default', 'value' => self::ZERO_VALUE],
            [['what_else_with_mobile1', 'what_else_with_mobile2', 'what_else_with_mobile3', 'what_else_with_mobile4', 'what_else_with_mobile5'], 'default', 'value' => self::ZERO_VALUE],
            [['whats_app_number'], 'default', 'value' => self::ZERO_VALUE],
            [['vechicle_drive1', 'vechicle_drive2', 'vechicle_drive3', 'vechicle_drive4', 'vechicle_drive5', 'vechicle_drive6', 'vechicle_drive7'], 'default', 'value' => self::ZERO_VALUE],
            [['marital_status'], 'default', 'value' => self::ZERO_VALUE],
            [['house_member_details1', 'house_member_details2', 'house_member_details3'], 'default', 'value' => self::ZERO_VALUE],
            [['future_scope1', 'future_scope2', 'future_scope3', 'future_scope4', 'future_scope5', 'future_scope6', 'future_scope7', 'future_scope8', 'future_scope9', 'future_scope10', 'future_scope11', 'future_scope12', 'future_scope13'], 'default', 'value' => self::ZERO_VALUE],
            [['opportunities_for_livelihood1', 'opportunities_for_livelihood2', 'opportunities_for_livelihood3', 'opportunities_for_livelihood4', 'opportunities_for_livelihood5', 'opportunities_for_livelihood6', 'opportunities_for_livelihood7', 'opportunities_for_livelihood8', 'opportunities_for_livelihood9', 'opportunities_for_livelihood10'], 'default', 'value' => self::ZERO_VALUE],
            [['planning_intervention1', 'planning_intervention2', 'planning_intervention3', 'planning_intervention4', 'planning_intervention5', 'planning_intervention6'], 'default', 'value' => self::ZERO_VALUE],
            [['immediate_aspiration1', 'immediate_aspiration2', 'immediate_aspiration3', 'immediate_aspiration4', 'immediate_aspiration5', 'immediate_aspiration6'], 'default', 'value' => self::ZERO_VALUE],
            [['which_program_your_group_formed'], 'default', 'value' => self::ZERO_VALUE],
            [['thought_of_forming_group'], 'default', 'value' => self::ZERO_VALUE],
            [['thought_of_forming_group'], 'default', 'value' => self::ZERO_VALUE],
            [['try_towards_group_formation1', 'try_towards_group_formation2', 'try_towards_group_formation3', 'try_towards_group_formation4', 'try_towards_group_formation5', 'try_towards_group_formation6', 'try_towards_group_formation7', 'try_towards_group_formation8'], 'default', 'value' => self::ZERO_VALUE],
            [['leadership_name_index'], 'default', 'value' => self::ZERO_VALUE],
            [['role_in_group1', 'role_in_group2', 'role_in_group3', 'role_in_group4', 'role_in_group5', 'role_in_group6', 'role_in_group7', 'role_in_group8'], 'default', 'value' => self::ZERO_VALUE],
            [['why_did_you_get_elected1', 'why_did_you_get_elected2', 'why_did_you_get_elected3', 'why_did_you_get_elected4', 'why_did_you_get_elected5', 'why_did_you_get_elected6', 'why_did_you_get_elected7', 'why_did_you_get_elected8', 'why_did_you_get_elected9'], 'default', 'value' => self::ZERO_VALUE],
            [['if_you_were_a_member_of_a_self_help_group1', 'if_you_were_a_member_of_a_self_help_group2', 'if_you_were_a_member_of_a_self_help_group3', 'if_you_were_a_member_of_a_self_help_group4', 'if_you_were_a_member_of_a_self_help_group5', 'if_you_were_a_member_of_a_self_help_group6', 'if_you_were_a_member_of_a_self_help_group7', 'if_you_were_a_member_of_a_self_help_group8', 'if_you_were_a_member_of_a_self_help_group9'], 'default', 'value' => self::ZERO_VALUE],
            [['capable_fast_pace'], 'default', 'value' => self::ZERO_VALUE],
            [['why_demanded1', 'why_demanded2', 'why_demanded3', 'why_demanded4', 'why_demanded5', 'why_demanded6'], 'default', 'value' => self::ZERO_VALUE],
            [['his_perception1', 'his_perception2', 'his_perception3', 'his_perception4', 'his_perception5', 'his_perception6', 'his_perception7', 'his_perception8'], 'default', 'value' => self::ZERO_VALUE],
            [['what_could_you_do_if_you_were_in_a_group1', 'what_could_you_do_if_you_were_in_a_group2', 'what_could_you_do_if_you_were_in_a_group3', 'what_could_you_do_if_you_were_in_a_group4', 'what_could_you_do_if_you_were_in_a_group5', 'what_could_you_do_if_you_were_in_a_group6', 'what_could_you_do_if_you_were_in_a_group7', 'what_could_you_do_if_you_were_in_a_group8', 'what_could_you_do_if_you_were_in_a_group9'], 'default', 'value' => self::ZERO_VALUE],
            [['most_contribute_index'], 'default', 'value' => self::ZERO_VALUE],
            [['group_culture'], 'default', 'value' => self::ZERO_VALUE],
            [['provision_in_the_group_as_voluntary'], 'default', 'value' => self::ZERO_VALUE],
            [['entrepreneurial_index'], 'default', 'value' => self::ZERO_VALUE],
            [['economic_status'], 'default', 'value' => self::ZERO_VALUE],
            [['can_read_write_hindi'], 'default', 'value' => self::ZERO_VALUE],
            [['confirtable_in_english'], 'default', 'value' => self::ZERO_VALUE],
            [['recognize_english_hindi'], 'default', 'value' => self::ZERO_VALUE],
            [['can_add_substract_multiply'], 'default', 'value' => self::ZERO_VALUE],
            [['who_maintain_account_index'], 'default', 'value' => self::ZERO_VALUE],
            [['choose_other_meaning1', 'choose_other_meaning2', 'choose_other_meaning3', 'choose_other_meaning4', 'choose_other_meaning5'], 'default', 'value' => self::ZERO_VALUE],
            [['same_to_same_word1', 'same_to_same_word2', 'same_to_same_word3'], 'default', 'value' => self::ZERO_VALUE],
            [['english_to_hindi1', 'english_to_hindi2', 'english_to_hindi3', 'english_to_hindi4', 'english_to_hindi5'], 'default', 'value' => self::ZERO_VALUE],
            [['percentage_option1', 'percentage_option2', 'percentage_option3', 'percentage_option4', 'percentage_option5'], 'default', 'value' => self::ZERO_VALUE],
            [['option_decision1', 'option_decision2', 'option_decision3', 'option_decision4', 'option_decision5'], 'default', 'value' => self::ZERO_VALUE],
            [['need_help_to_fill_form'], 'default', 'value' => self::ZERO_VALUE],
            [['already_worked'], 'default', 'value' => self::ZERO_VALUE],
            [['own_mobile'], 'default', 'value' => self::ZERO_VALUE],
            [['own_mobile_means1', 'own_mobile_means2', 'own_mobile_means3', 'own_mobile_means4', 'own_mobile_means5', 'own_mobile_means6', 'own_mobile_means7', 'own_mobile_means8'], 'default', 'value' => self::ZERO_VALUE],
            [['method_used_for_ledger_account1', 'method_used_for_ledger_account2', 'method_used_for_ledger_account3', 'method_used_for_ledger_account4', 'method_used_for_ledger_account5', 'method_used_for_ledger_account6'], 'default', 'value' => self::ZERO_VALUE],
            [['need_training1', 'need_training2', 'need_training3', 'need_training4', 'need_training5'], 'default', 'value' => self::ZERO_VALUE],
            [['status'], 'default', 'value' => 1],
            [['age'], 'default', 'value' => self::ZERO_VALUE],
            [['gender', 'age', 'cast', 'division_code', 'district_code', 'block_code', 'gram_panchayat_code', 'village_code', 'reading_skills', 'phone_type', 'what_else_with_mobile1', 'what_else_with_mobile2', 'what_else_with_mobile3', 'what_else_with_mobile4', 'what_else_with_mobile5', 'whats_app_number', 'vechicle_drive1', 'vechicle_drive2', 'vechicle_drive3', 'vechicle_drive4', 'vechicle_drive5', 'vechicle_drive6', 'vechicle_drive7', 'marital_status', 'house_member_details1', 'house_member_details2', 'house_member_details3', 'future_scope1', 'future_scope2', 'future_scope3', 'future_scope4', 'future_scope5', 'future_scope6', 'future_scope7', 'future_scope8', 'future_scope9', 'future_scope10', 'future_scope11', 'future_scope12', 'future_scope13', 'opportunities_for_livelihood1', 'opportunities_for_livelihood2', 'opportunities_for_livelihood3', 'opportunities_for_livelihood4', 'opportunities_for_livelihood5', 'opportunities_for_livelihood6', 'opportunities_for_livelihood7', 'opportunities_for_livelihood8', 'opportunities_for_livelihood9', 'opportunities_for_livelihood10', 'planning_intervention1', 'planning_intervention2', 'planning_intervention3', 'planning_intervention4', 'planning_intervention5', 'planning_intervention6', 'immediate_aspiration1', 'immediate_aspiration2', 'immediate_aspiration3', 'immediate_aspiration4', 'immediate_aspiration5', 'immediate_aspiration6', 'already_group_member', 'which_program_your_group_formed', 'thought_of_forming_group', 'try_towards_group_formation1', 'try_towards_group_formation2', 'try_towards_group_formation3', 'try_towards_group_formation4', 'try_towards_group_formation5', 'try_towards_group_formation6', 'try_towards_group_formation7', 'try_towards_group_formation8', 'leadership_name_index', 'role_in_group1', 'role_in_group2', 'role_in_group3', 'role_in_group4', 'role_in_group5', 'role_in_group6', 'role_in_group7', 'role_in_group8', 'why_did_you_get_elected1', 'why_did_you_get_elected2', 'why_did_you_get_elected3', 'why_did_you_get_elected4', 'why_did_you_get_elected5', 'why_did_you_get_elected6', 'why_did_you_get_elected7', 'why_did_you_get_elected8', 'why_did_you_get_elected9', 'if_you_were_a_member_of_a_self_help_group1', 'if_you_were_a_member_of_a_self_help_group2', 'if_you_were_a_member_of_a_self_help_group3', 'if_you_were_a_member_of_a_self_help_group4', 'if_you_were_a_member_of_a_self_help_group5', 'if_you_were_a_member_of_a_self_help_group6', 'if_you_were_a_member_of_a_self_help_group7', 'if_you_were_a_member_of_a_self_help_group8', 'if_you_were_a_member_of_a_self_help_group9', 'active_members_position1', 'active_members_position2', 'belongingness_position1', 'belongingness_position2', 'awareness_position1', 'awareness_position2', 'member_who_contact_in_other_group_position1', 'member_who_contact_in_other_group_position2', 'demanded_group_member_position1', 'demanded_group_member_position2', 'capable_fast_pace', 'why_demanded1', 'why_demanded2', 'why_demanded3', 'why_demanded4', 'why_demanded5', 'why_demanded6', 'if_you_have_group_members_what_are_they', 'capable_fast_pace_member_number', 'his_perception1', 'his_perception2', 'his_perception3', 'his_perception4', 'his_perception5', 'his_perception6', 'his_perception7', 'his_perception8', 'what_could_you_do_if_you_were_in_a_group1', 'what_could_you_do_if_you_were_in_a_group2', 'what_could_you_do_if_you_were_in_a_group3', 'what_could_you_do_if_you_were_in_a_group4', 'what_could_you_do_if_you_were_in_a_group5', 'what_could_you_do_if_you_were_in_a_group6', 'what_could_you_do_if_you_were_in_a_group7', 'what_could_you_do_if_you_were_in_a_group8', 'what_could_you_do_if_you_were_in_a_group9', 'most_contribute_index', 'group_culture', 'provision_in_the_group_as_voluntary', 'entrepreneurial_index', 'economic_status', 'afraid_unknown_rules_index1', 'afraid_unknown_rules_index2', 'concept_of_setting_up_new_heights_index', 'livelihood_opportunity_for_another_member_index1', 'livelihood_opportunity_for_another_member_index2', 'negotiate_best_index1', 'negotiate_best_index2', 'which_member_can_talk_advantages_index1', 'which_member_can_talk_advantages_index2', 'can_read_write_hindi', 'confirtable_in_english', 'recognize_english_hindi', 'can_add_substract_multiply', 'who_maintain_account_index', 'choose_other_meaning1', 'choose_other_meaning2', 'choose_other_meaning3', 'choose_other_meaning4', 'choose_other_meaning5', 'same_to_same_word1', 'same_to_same_word2', 'same_to_same_word3', 'english_to_hindi1', 'english_to_hindi2', 'english_to_hindi3', 'english_to_hindi4', 'english_to_hindi5', 'percentage_option1', 'percentage_option2', 'percentage_option3', 'percentage_option4', 'percentage_option5', 'option_decision1', 'option_decision2', 'option_decision3', 'option_decision4', 'option_decision5', 'mobile_use_experience', 'whose_mobile_you_using', 'no_of_family_people_using_phone', 'need_help_to_fill_form', 'already_worked', 'own_mobile', 'own_mobile_means1', 'own_mobile_means2', 'own_mobile_means3', 'own_mobile_means4', 'own_mobile_means5', 'own_mobile_means6', 'own_mobile_means7', 'own_mobile_means8', 'method_used_for_ledger_account1', 'method_used_for_ledger_account2', 'method_used_for_ledger_account3', 'method_used_for_ledger_account4', 'method_used_for_ledger_account5', 'method_used_for_ledger_account6', 'need_training1', 'need_training2', 'need_training3', 'need_training4', 'need_training5', 'form_number', 'srlm_bc_selection_app_detail_id', 'srlm_bc_selection_user_id', 'srlm_bc_selection_api_log_id', 'highest_score_in_gp', 'rating_process_status', 'selection_by', 'call1', 'call1_by', 'call_by_rsetis', 'training_id', 'training_center_id', 'training_batch_id', 'training_status', 'already_certified', 'pvr_status', 'pvr_upload_by', 'iibf_photo_status', 'iibf_photo_upload_by', 'iibf_by', 'bc_photo_status', 'cbo_bc_id', 'cbo_shg_id', 'user_id', 'assign_shg_by', 'return_for_shg', 'return_for_shg_by', 'onboarding', 'onboarding_by', 'bank_id', 'bank_id_shg', 'bc_bank', 'shg_bank', 'verify_bc_passbook_photo', 'verify_bc_passbook_not', 'verify_bc_bank_account_no', 'verify_bc_branch_code_or_ifsc', 'verify_bc_ifsc_code_entered', 'verify_bc_other', 'verify_bc_shg', 'verification_status_bc_bank', 'bc_bank_verify_by', 'verify_bc_shg_passbook_photo', 'verify_bc_shg_name', 'verify_bc_shg_bank_account_no', 'verify_bc_shg_passbook_not', 'verify_bc_shg_other', 'verify_bc_shg_branch_code_or_ifsc', 'verify_bc_shg_ifsc_code_entered', 'bc_shg_bank_verify_by', 'verification_status_shg_bank', 'pfms_maped_status', 'bc_shg_funds_status', 'bc_shg_funds_by', 'bc_support_funds_received', 'pan_card_status', 'pan_card_status_by', 'pan_photo_upload', 'pan_photo_by', 'handheld_machine_status', 'handheld_machine_by', 'did_partner_bank_contact_bc', 'bc_handheld_machine_recived', 'beneficiaries_code_by', 'revert_beneficiaries_code_by', 'mobile_no_update_by', 'viewtemp1', 'viewtemp2', 'viewtemp3', 'viewtemp4', 'viewtemp5', 'viewtemp6', 'viewtemp7', 'viewtemp8', 'viewtemp9', 'viewtemp10', 'viewtemp11', 'viewtemp12', 'viewtemp13', 'viewtemp14', 'bc_shg_name_update', 'created_by', 'updated_by', 'created_at', 'updated_at', 'form_status', 'status_new', 'status', 'bc_unwilling_rsetis', 'bc_unwilling_rsetis_by', 'bc_unwilling_call_center', 'bc_unwilling_call_center_by', 'corona_feedback', 'parent_id', 'action_type'], 'integer'],
            [['reg_date_time', 'form1_date_time', 'form2_date_time', 'form3_date_time', 'form4_date_time', 'form5_date_time', 'form6_date_time', 'selection_datetime', 'call1_datetime', 'call_rsetis_datetime', 'pvr_upload_date', 'iibf_photo_upload_date', 'iibf_date', 'assign_shg_datetime', 'return_for_shg_datetime', 'onboarding_date_time', 'date_of_opening_the_bank_account', 'bc_bank_verify_date', 'bc_shg_bank_verify_date', 'bc_shg_funds_date', 'bc_support_funds_received_date', 'bc_support_funds_received_submitdate', 'pan_card_status_date', 'pan_photo_date', 'handheld_machine_date', 'bc_handheld_machine_recived_submitdate', 'beneficiaries_code_date', 'revert_beneficiaries_code_datetime', 'mobile_no_update_date', 'last_activity_time', 'bc_unwilling_rsetis_date', 'bc_unwilling_call_center_date'], 'safe'],
            [['sec1', 'sec2', 'sec3', 'sec4', 'sec5', 'over_all', 'over_all_per', 'q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10', 'q11', 'q12', 'q13', 'q14', 'q15', 'q16', 'q17', 'q18', 'q19', 'q20', 'q21', 'q22', 'q23', 'q24', 'q25', 'q26', 'q27', 'q28', 'q29', 'q30', 'q31', 'q32', 'q33', 'q34', 'q35', 'q36', 'q37', 'q38', 'q39', 'q40', 'q41', 'q42', 'q43', 'q44', 'q45', 'q46', 'q47', 'q48', 'q49', 'q50', 'q51', 'q52', 'q53', 'q54', 'q55', 'q56', 'q57', 'q58', 'q59', 'q60', 'q61', 'q62', 'q63', 'q64', 'q65', 'q66', 'q67', 'q68', 'exam_score', 'bc_shg_funds_amount', 'bc_support_funds_received_amount'], 'number'],
            [['form_uuid'], 'string', 'max' => 36],
            [['first_name', 'orig_first_name', 'middle_name', 'orig_middle_name', 'sur_name', 'orig_sur_name', 'district_name', 'block_name', 'gram_panchayat_name', 'village_name', 'hamlet', 'guardian_name', 'leadership_name', 'active_members_name1', 'active_members_name2', 'belongingness_name1', 'belongingness_name2', 'awareness_name1', 'awareness_name2', 'member_who_contact_in_other_group_name1', 'member_who_contact_in_other_group_name2', 'demanded_group_member_name1', 'demanded_group_member_name2', 'capable_fast_pace_member_name', 'most_contribute_name', 'entrepreneurial', 'afraid_unknown_rules1', 'afraid_unknown_rules2', 'concept_of_setting_up_new_heights', 'livelihood_opportunity_for_another_member1', 'livelihood_opportunity_for_another_member2', 'negotiate_best1', 'negotiate_best2', 'which_member_can_talk_advantages1', 'which_member_can_talk_advantages2', 'who_maintain_account', 'gps', 'certificate_code'], 'string', 'max' => 100],
            [['application_id'], 'string', 'max' => 20],
            [['last_app_version'], 'safe'],
            [['division_name', 'gps_accuracy', 'beneficiaries_code'], 'string', 'max' => 50],
            [['aadhar_number'], 'string', 'max' => 30],
            [['mobile_number'], 'string', 'max' => 15],
            [['other_occupation', 'profile_photo', 'aadhar_front_photo', 'aadhar_back_photo', 'pvr_upload_file_name', 'iibf_photo_file_name', 'passbook_photo', 'passbook_photo_shg', 'pan_photo', 'bc_handheld_machine_photo'], 'string', 'max' => 500],
            [['your_group_name', 'verify_bc_other_reason', 'verify_bc_shg_other_reason'], 'string', 'max' => 255],
            [['form_start_date'], 'string', 'max' => 60],
            [['bank_account_no_of_the_bc', 'branch_code_or_ifsc', 'bank_account_no_of_the_shg', 'branch_code_or_ifsc_shg'], 'string', 'max' => 25],
            [['name_of_bank', 'branch', 'cin', 'name_of_bank_shg', 'branch_shg'], 'string', 'max' => 150],
            [['pan_number'], 'string', 'max' => 16],
            [['mobile_no', 'orig_otp_mobile_no'], 'string', 'max' => 12],
            [['action_type'], 'default', 'value' => self::ACTION_TYPE_REG],
            [['form_status'], 'default', 'value' => self::FORM_STATUS_REG],
            [['status'], 'default', 'value' => 1],
            [['form_uuid', 'first_name'], 'default', 'value' => self::NULL_VALUE],
            [['age'], 'default', 'value' => self::ZERO_VALUE],
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
            [['master_partner_bank_id'], 'integer'],
            [['bc_support_funds_handheld_amount'], 'number'],
            [['bc_support_funds_od_amount'], 'number'],
            [['blocked'], 'default', 'value' => 0],
            [['bc_beneficiaries_code_by', 'training_feedback'], 'integer'],
            [['bc_beneficiaries_code_date'], 'safe'],
            [['bc_beneficiaries_code'], 'string', 'max' => 20],
            [['training_feedback'], 'default', 'value' => 0],
            [['replaced'], 'integer'],
            [['replaced'], 'default', 'value' => 0],
            [['bc_payment_count'], 'default', 'value' => 0],
            [['blocked_by'], 'integer'],
            [['blocked_date'], 'safe'],
            [['shg_confirm_funds_return'], 'integer'],
            [['shg_confirm_funds_return'], 'default', 'value' => 0],
            [['shg_confirm_funds_return_date'], 'safe'],
            [['shg_confirm_funds_return_photo'], 'safe'],
            [['alt_mobile_no'], 'safe'],
            [['temp_bankidbc_by'], 'integer'],
            [['temp_bankidbc_datetime'], 'safe'],
            [['changebankid_datetime'], 'safe'],
            [['temp_bankidbc'], 'safe'],
            [['bc_operational'], 'integer'],
            [['bc_settlement_ac_194n'], 'integer'],
            [['bc_settlement_ac_194n_by'], 'integer'],
            [['bc_settlement_ac_194n_by'], 'safe'],
            [['bc_settlement_ac_194n_date'], 'safe'],
            [['bc_operational'], 'default', 'value' => 0],
            [['bc_settlement_account_bank_confirm'], 'integer'],
            [['bc_settlement_account_bank_id'], 'integer'],
            [['bc_settlement_account_bank_confirm'], 'default', 'value' => 0],
            [['bc_settlement_account_bank_id'], 'safe'],
            [['bc_settlement_ac_194n'], 'default', 'value' => 0],
            [['bc_settlement_account_bank_name'], 'safe'],
            [['bc_settlement_account_ifsc_code'], 'safe'],
            [['bc_settlement_account_no'], 'safe'],
            [['bc_unwilling_bc', 'bc_unwilling_bc_by', 'bc_unwilling_cdo', 'bc_unwilling_cdo_by', 'bc_unwilling_upsrlm', 'bc_unwilling_upsrlm_by'], 'integer'],
            [['bc_unwilling_bc_date', 'bc_unwilling_cdo_date', 'bc_unwilling_upsrlm_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
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
            'beneficiaries_code' => 'Beneficiaries Code',
            'beneficiaries_code_by' => 'Beneficiaries Code By',
            'beneficiaries_code_date' => 'Beneficiaries Code Date',
            'revert_beneficiaries_code_by' => 'Revert Beneficiaries Code By',
            'revert_beneficiaries_code_datetime' => 'Revert Beneficiaries Code Datetime',
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
            'bc_unwilling_rsetis' => 'Bc Unwilling Rsetis',
            'bc_unwilling_rsetis_by' => 'Bc Unwilling Rsetis By',
            'bc_unwilling_rsetis_date' => 'Bc Unwilling Rsetis Date',
            'bc_unwilling_call_center' => 'Bc Unwilling Call Center',
            'bc_unwilling_call_center_by' => 'Bc Unwilling Call Center By',
            'bc_unwilling_call_center_date' => 'Bc Unwilling Call Center Date',
            'corona_feedback' => 'Corona Feedback',
            'parent_id' => 'Parent ID',
            'action_type' => 'Action Type',
        ];
    }

    public function getBcbankrjregion() {
        $html = '';
        if ($this->bc_bank == 3) {
            if ($this->verify_bc_passbook_photo == '0') {
                $html .= 'बी0सी0 सखी द्वारा स्वयं की अपलोड की गयी पास-बुक स्पष्ट रूप में नही है।' . '<br/>';
            }
            if ($this->verify_bc_passbook_not == '0') {
                $html .= 'बी0सी0 सखी के द्वारा अपलोड की गयी पास बुक स्वयं की नही है।' . '<br/>';
            }
            if ($this->verify_bc_bank_account_no == '0') {
                $html .= 'बी0सी0 सखी द्वारा दर्ज स्वयं के बैंक खाता संख्या अपलोड बैंक खाता की पास-बुक से भिन्न है।' . '<br/>';
            }
            if ($this->verify_bc_branch_code_or_ifsc == '0') {
                $html .= 'बी0सी0 सखी के बैंक खाता का दर्ज आई0एफ0एस0सी0 अपलोड की गयी पास-बुक कोड से भिन्न है।' . '<br/>';
            }
            if ($this->verify_bc_ifsc_code_entered == '0') {
                $html .= 'बी0सी0 सखी द्वारा अपलोड की गयी स्वयं की बैंक खाता की पास-बुक में आई0एफ0एस0सी0 कोड नही दर्ज है।' . '<br/>';
            }
            if ($this->verify_bc_other == '0') {
                $html .= $this->verify_bc_other_reason . '<br/>';
            }
        }
        return rtrim($html, '<br/>');
    }

    public function getBcshgbankrjregion() {
        $html = '';
        if ($this->shg_bank == 3) {
            if ($this->verify_bc_shg_passbook_photo == '0') {
                $html .= 'बी0सी0 सखी द्वारा स्वयं सहायता समूह की अपलोड की गयी पास-बुक स्पष्ट रूप में नही है।' . '<br/>';
            }
            if ($this->verify_bc_shg_name == '0') {
                $html .= 'बी0सी0 सखी द्वारा दर्ज स्वयं सहायता समूह का नाम अपलोड की गयी पास-बुक में लिखित स्वयं सहायता समूह के नाम से भिन्न है।' . '<br/>';
            }
            if ($this->verify_bc_shg_bank_account_no == '0') {
                $html .= 'बी0सी0 सखी द्वारा दर्ज स्वयं सहायता समूह के बैंक खाता संख्या अपलोड की गयी पास-बुक के खाता संख्या से भिन्न है।' . '<br/>';
            }
            if ($this->verify_bc_shg_passbook_not == '0') {
                $html .= 'बी0सी0 सखी द्वारा अपलोड पास-बुक स्वयं सहायता समूह की नही है।' . '<br/>';
            }
            if ($this->verify_bc_shg_branch_code_or_ifsc == '0') {
                $html .= 'बी0सी0 सखी द्वारा स्वयं सहायता समूह के बैंक खाता का दर्ज आई0एफ0एस0सी0 अपलोड की गयी पास-बुक कोड से भिन्न है।' . '<br/>';
            }
            if ($this->verify_bc_shg_ifsc_code_entered == '0') {
                $html .= 'बी0सी0 सखी द्वारा अपलोड की गयी स्वयं सहायता समूह की पास-बुक में आई0एफ0एस0सी0 कोड नही दर्ज है' . '<br/>';
            }
            if ($this->verify_bc_shg_other == '0') {
                $html .= $this->verify_bc_shg_other_reason . '<br/>';
            }
        }
        return rtrim($html, '<br/>');
    }

    public function getBc() {
        return $this->hasOne(SrlmBcApplication::className(), ['id' => 'parent_id']);
    }

}
