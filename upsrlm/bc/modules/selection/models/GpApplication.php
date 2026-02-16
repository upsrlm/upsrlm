<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "gp_application".
 *
 * @property int $id
 * @property int|null $district_code
 * @property string|null $district_name
 * @property int|null $gram_panchayat_code
 * @property string|null $gram_panchayat_name
 * @property int|null $bc1_id
 * @property string|null $bc1_first_name
 * @property int|null $bc1_reading_skills
 * @property int $bc1_what_else_with_mobile1
 * @property int $bc1_what_else_with_mobile2
 * @property int $bc1_what_else_with_mobile3
 * @property int $bc1_what_else_with_mobile4
 * @property int $bc1_what_else_with_mobile5
 * @property int $bc1_whats_app_number
 * @property int $bc1_vechicle_drive1
 * @property int $bc1_vechicle_drive2
 * @property int $bc1_vechicle_drive3
 * @property int $bc1_vechicle_drive5
 * @property int $bc1_vechicle_drive6
 * @property int $bc1_vechicle_drive7
 * @property int $bc1_house_member_details2
 * @property int $bc1_house_member_details3
 * @property int $bc1_immediate_aspiration1
 * @property int $bc1_immediate_aspiration2
 * @property int $bc1_immediate_aspiration3
 * @property int $bc1_immediate_aspiration4
 * @property int $bc1_immediate_aspiration5
 * @property int $bc1_immediate_aspiration6
 * @property int|null $bc1_already_group_member
 * @property string|null $bc1_leadership_name
 * @property int $bc1_role_in_group2
 * @property int $bc1_role_in_group3
 * @property int $bc1_role_in_group4
 * @property int $bc1_role_in_group5
 * @property int $bc1_role_in_group6
 * @property int $bc1_role_in_group7
 * @property int $bc1_role_in_group8
 * @property int $bc1_can_read_write_hindi
 * @property int $bc1_confirtable_in_english
 * @property int $bc1_recognize_english_hindi
 * @property int $bc1_can_add_substract_multiply
 * @property string|null $bc1_who_maintain_account
 * @property int $bc1_choose_other_meaning1
 * @property int $bc1_choose_other_meaning2
 * @property int $bc1_choose_other_meaning3
 * @property int $bc1_choose_other_meaning4
 * @property int $bc1_choose_other_meaning5
 * @property int $bc1_same_to_same_word1
 * @property int $bc1_same_to_same_word2
 * @property int $bc1_same_to_same_word3
 * @property int $bc1_english_to_hindi1
 * @property int $bc1_english_to_hindi2
 * @property int $bc1_english_to_hindi3
 * @property int $bc1_english_to_hindi4
 * @property int $bc1_english_to_hindi5
 * @property int $bc1_percentage_option1
 * @property int $bc1_percentage_option2
 * @property int $bc1_percentage_option3
 * @property int $bc1_percentage_option4
 * @property int $bc1_percentage_option5
 * @property int $bc1_option_decision1
 * @property int $bc1_option_decision2
 * @property int $bc1_option_decision3
 * @property int $bc1_option_decision4
 * @property int $bc1_option_decision5
 * @property int $bc1_mobile_use_experience
 * @property int $bc1_whose_mobile_you_using
 * @property int $bc1_no_of_people_using_phone
 * @property int $bc1_no_of_family_people_using_phone
 * @property int $bc1_already_worked
 * @property int $bc1_own_mobile
 * @property int $bc1_own_mobile_means3
 * @property int $bc1_own_mobile_means4
 * @property int $bc1_own_mobile_means5
 * @property int $bc1_own_mobile_means6
 * @property int $bc1_own_mobile_means7
 * @property int $bc1_own_mobile_means8
 * @property int $bc1_method_used_for_ledger_account3
 * @property int $bc1_method_used_for_ledger_account4
 * @property int $bc1_method_used_for_ledger_account5
 * @property int $bc1_method_used_for_ledger_account6
 * @property int $bc1_need_training1
 * @property int $bc1_need_training3
 * @property int $bc1_need_training4
 * @property int $bc1_need_training5
 * @property float $bc1_sec1
 * @property float $bc1_sec2
 * @property float $bc1_sec3
 * @property float $bc1_sec4
 * @property float $bc1_sec5
 * @property float $bc1_over_all
 * @property int $bc1_status_new
 * @property int|null $bc1_status
 * @property int $bc1_training_status
 * @property int|null $bc2_id
 * @property string|null $bc2_first_name
 * @property int|null $bc2_reading_skills
 * @property int|null $bc2_age
 * @property int $bc2_what_else_with_mobile1
 * @property int $bc2_what_else_with_mobile2
 * @property int $bc2_what_else_with_mobile3
 * @property int $bc2_what_else_with_mobile4
 * @property int $bc2_what_else_with_mobile5
 * @property int $bc2_whats_app_number
 * @property int $bc2_vechicle_drive1
 * @property int $bc2_vechicle_drive2
 * @property int $bc2_vechicle_drive3
 * @property int $bc2_vechicle_drive5
 * @property int $bc2_vechicle_drive6
 * @property int $bc2_vechicle_drive7
 * @property int $bc2_house_member_details2
 * @property int $bc2_house_member_details3
 * @property int $bc2_immediate_aspiration1
 * @property int $bc2_immediate_aspiration2
 * @property int $bc2_immediate_aspiration3
 * @property int $bc2_immediate_aspiration4
 * @property int $bc2_immediate_aspiration5
 * @property int $bc2_immediate_aspiration6
 * @property int|null $bc2_already_group_member
 * @property string|null $bc2_leadership_name
 * @property int $bc2_role_in_group2
 * @property int $bc2_role_in_group3
 * @property int $bc2_role_in_group4
 * @property int $bc2_role_in_group5
 * @property int $bc2_role_in_group6
 * @property int $bc2_role_in_group7
 * @property int $bc2_role_in_group8
 * @property int $bc2_can_read_write_hindi
 * @property int $bc2_confirtable_in_english
 * @property int $bc2_recognize_english_hindi
 * @property int $bc2_can_add_substract_multiply
 * @property string|null $bc2_who_maintain_account
 * @property int $bc2_choose_other_meaning1
 * @property int $bc2_choose_other_meaning2
 * @property int $bc2_choose_other_meaning3
 * @property int $bc2_choose_other_meaning4
 * @property int|null $bc2_choose_other_meaning5
 * @property int $bc2_same_to_same_word1
 * @property int $bc2_same_to_same_word2
 * @property int $bc2_same_to_same_word3
 * @property int $bc2_english_to_hindi1
 * @property int $bc2_english_to_hindi2
 * @property int $bc2_english_to_hindi3
 * @property int $bc2_english_to_hindi4
 * @property int $bc2_english_to_hindi5
 * @property int $bc2_percentage_option1
 * @property int $bc2_percentage_option2
 * @property int $bc2_percentage_option3
 * @property int $bc2_percentage_option4
 * @property int $bc2_percentage_option5
 * @property int $bc2_option_decision1
 * @property int $bc2_option_decision2
 * @property int $bc2_option_decision3
 * @property int $bc2_option_decision4
 * @property int $bc2_option_decision5
 * @property int $bc2_mobile_use_experience
 * @property int $bc2_whose_mobile_you_using
 * @property int $bc2_no_of_people_using_phone
 * @property int $bc2_no_of_family_people_using_phone
 * @property int $bc2_already_worked
 * @property int $bc2_own_mobile
 * @property int $bc2_own_mobile_means3
 * @property int $bc2_own_mobile_means4
 * @property int $bc2_own_mobile_means5
 * @property int $bc2_own_mobile_means6
 * @property int $bc2_own_mobile_means7
 * @property int $bc2_own_mobile_means8
 * @property int $bc2_method_used_for_ledger_account3
 * @property int $bc2_method_used_for_ledger_account4
 * @property int $bc2_method_used_for_ledger_account5
 * @property int $bc2_method_used_for_ledger_account6
 * @property int $bc2_need_training1
 * @property int $bc2_need_training3
 * @property int $bc2_need_training4
 * @property int $bc2_need_training5
 * @property float $bc2_sec1
 * @property float $bc2_sec2
 * @property float $bc2_sec3
 * @property float $bc2_sec4
 * @property float $bc2_sec5
 * @property float $bc2_over_all
 * @property int|null $bc2_status_new
 * @property int|null $bc2_status
 * @property float $dif_over_all
 * @property int|null $bc1_phone_type
 * @property int|null $bc2_phone_type
 * @property int $bc1_why_did_you_get_elected1
 * @property int $bc1_why_did_you_get_elected2
 * @property int $bc1_why_did_you_get_elected3
 * @property int $bc1_why_did_you_get_elected4
 * @property int $bc1_why_did_you_get_elected5
 * @property int $bc1_why_did_you_get_elected6
 * @property int $bc1_why_did_you_get_elected7
 * @property int $bc1_why_did_you_get_elected8
 * @property int $bc1_why_did_you_get_elected9
 * @property string|null $bc1_active_members_name1
 * @property string|null $bc1_active_members_name2
 * @property string|null $bc1_belongingness_name1
 * @property string|null $bc1_belongingness_name2
 * @property string|null $bc1_awareness_name1
 * @property string|null $bc1_awareness_name2
 * @property string|null $bc1_member_who_contact_in_other_group_name1
 * @property string|null $bc1_member_who_contact_in_other_group_name2
 * @property string|null $bc1_demanded_group_member_name1
 * @property string|null $bc1_demanded_group_member_name2
 * @property int $bc1_capable_fast_pace
 * @property int $bc1_his_perception3
 * @property string|null $bc1_most_contribute_name
 * @property string|null $bc1_entrepreneurial
 * @property string|null $bc1_afraid_unknown_rules1
 * @property string|null $bc1_afraid_unknown_rules2
 * @property string|null $bc1_concept_of_setting_up_new_heights
 * @property string|null $bc1_livelihood_opportunity_for_another_member1
 * @property string|null $bc1_livelihood_opportunity_for_another_member2
 * @property string|null $bc1_negotiate_best1
 * @property string|null $bc1_negotiate_best2
 * @property string|null $bc1_which_member_can_talk_advantages1
 * @property string|null $bc1_which_member_can_talk_advantages2
 * @property string|null $bc1_application_id
 * @property int $bc1_aadhar_duplicate
 * @property string|null $bc2_application_id
 * @property int|null $bc2_aadhar_duplicate
 * @property int|null $bc2_selected_round2
 * @property int|null $urban_gp
 * @property int $process_status
 * @property string|null $bc1_mobile_number
 * @property string|null $bc1_mobile_no
 * @property string|null $block_name
 */
class GpApplication extends BcactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gp_application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['district_code', 'gram_panchayat_code', 'bc1_id', 'bc1_reading_skills', 'bc1_what_else_with_mobile1', 'bc1_what_else_with_mobile2', 'bc1_what_else_with_mobile3', 'bc1_what_else_with_mobile4', 'bc1_what_else_with_mobile5', 'bc1_whats_app_number', 'bc1_vechicle_drive1', 'bc1_vechicle_drive2', 'bc1_vechicle_drive3', 'bc1_vechicle_drive5', 'bc1_vechicle_drive6', 'bc1_vechicle_drive7', 'bc1_house_member_details2', 'bc1_house_member_details3', 'bc1_immediate_aspiration1', 'bc1_immediate_aspiration2', 'bc1_immediate_aspiration3', 'bc1_immediate_aspiration4', 'bc1_immediate_aspiration5', 'bc1_immediate_aspiration6', 'bc1_already_group_member', 'bc1_role_in_group2', 'bc1_role_in_group3', 'bc1_role_in_group4', 'bc1_role_in_group5', 'bc1_role_in_group6', 'bc1_role_in_group7', 'bc1_role_in_group8', 'bc1_can_read_write_hindi', 'bc1_confirtable_in_english', 'bc1_recognize_english_hindi', 'bc1_can_add_substract_multiply', 'bc1_choose_other_meaning1', 'bc1_choose_other_meaning2', 'bc1_choose_other_meaning3', 'bc1_choose_other_meaning4', 'bc1_choose_other_meaning5', 'bc1_same_to_same_word1', 'bc1_same_to_same_word2', 'bc1_same_to_same_word3', 'bc1_english_to_hindi1', 'bc1_english_to_hindi2', 'bc1_english_to_hindi3', 'bc1_english_to_hindi4', 'bc1_english_to_hindi5', 'bc1_percentage_option1', 'bc1_percentage_option2', 'bc1_percentage_option3', 'bc1_percentage_option4', 'bc1_percentage_option5', 'bc1_option_decision1', 'bc1_option_decision2', 'bc1_option_decision3', 'bc1_option_decision4', 'bc1_option_decision5', 'bc1_mobile_use_experience', 'bc1_whose_mobile_you_using', 'bc1_no_of_people_using_phone', 'bc1_no_of_family_people_using_phone', 'bc1_already_worked', 'bc1_own_mobile', 'bc1_own_mobile_means3', 'bc1_own_mobile_means4', 'bc1_own_mobile_means5', 'bc1_own_mobile_means6', 'bc1_own_mobile_means7', 'bc1_own_mobile_means8', 'bc1_method_used_for_ledger_account3', 'bc1_method_used_for_ledger_account4', 'bc1_method_used_for_ledger_account5', 'bc1_method_used_for_ledger_account6', 'bc1_need_training1', 'bc1_need_training3', 'bc1_need_training4', 'bc1_need_training5', 'bc1_status_new', 'bc1_status', 'bc1_training_status', 'bc2_id', 'bc2_reading_skills', 'bc2_age', 'bc2_what_else_with_mobile1', 'bc2_what_else_with_mobile2', 'bc2_what_else_with_mobile3', 'bc2_what_else_with_mobile4', 'bc2_what_else_with_mobile5', 'bc2_whats_app_number', 'bc2_vechicle_drive1', 'bc2_vechicle_drive2', 'bc2_vechicle_drive3', 'bc2_vechicle_drive5', 'bc2_vechicle_drive6', 'bc2_vechicle_drive7', 'bc2_house_member_details2', 'bc2_house_member_details3', 'bc2_immediate_aspiration1', 'bc2_immediate_aspiration2', 'bc2_immediate_aspiration3', 'bc2_immediate_aspiration4', 'bc2_immediate_aspiration5', 'bc2_immediate_aspiration6', 'bc2_already_group_member', 'bc2_role_in_group2', 'bc2_role_in_group3', 'bc2_role_in_group4', 'bc2_role_in_group5', 'bc2_role_in_group6', 'bc2_role_in_group7', 'bc2_role_in_group8', 'bc2_can_read_write_hindi', 'bc2_confirtable_in_english', 'bc2_recognize_english_hindi', 'bc2_can_add_substract_multiply', 'bc2_choose_other_meaning1', 'bc2_choose_other_meaning2', 'bc2_choose_other_meaning3', 'bc2_choose_other_meaning4', 'bc2_choose_other_meaning5', 'bc2_same_to_same_word1', 'bc2_same_to_same_word2', 'bc2_same_to_same_word3', 'bc2_english_to_hindi1', 'bc2_english_to_hindi2', 'bc2_english_to_hindi3', 'bc2_english_to_hindi4', 'bc2_english_to_hindi5', 'bc2_percentage_option1', 'bc2_percentage_option2', 'bc2_percentage_option3', 'bc2_percentage_option4', 'bc2_percentage_option5', 'bc2_option_decision1', 'bc2_option_decision2', 'bc2_option_decision3', 'bc2_option_decision4', 'bc2_option_decision5', 'bc2_mobile_use_experience', 'bc2_whose_mobile_you_using', 'bc2_no_of_people_using_phone', 'bc2_no_of_family_people_using_phone', 'bc2_already_worked', 'bc2_own_mobile', 'bc2_own_mobile_means3', 'bc2_own_mobile_means4', 'bc2_own_mobile_means5', 'bc2_own_mobile_means6', 'bc2_own_mobile_means7', 'bc2_own_mobile_means8', 'bc2_method_used_for_ledger_account3', 'bc2_method_used_for_ledger_account4', 'bc2_method_used_for_ledger_account5', 'bc2_method_used_for_ledger_account6', 'bc2_need_training1', 'bc2_need_training3', 'bc2_need_training4', 'bc2_need_training5', 'bc2_status_new', 'bc2_status', 'bc1_phone_type', 'bc2_phone_type', 'bc1_why_did_you_get_elected1', 'bc1_why_did_you_get_elected2', 'bc1_why_did_you_get_elected3', 'bc1_why_did_you_get_elected4', 'bc1_why_did_you_get_elected5', 'bc1_why_did_you_get_elected6', 'bc1_why_did_you_get_elected7', 'bc1_why_did_you_get_elected8', 'bc1_why_did_you_get_elected9', 'bc1_capable_fast_pace', 'bc1_his_perception3', 'bc1_aadhar_duplicate', 'bc2_aadhar_duplicate', 'bc2_selected_round2', 'urban_gp', 'process_status'], 'integer'],
            [['bc1_sec1', 'bc1_sec2', 'bc1_sec3', 'bc1_sec4', 'bc1_sec5', 'bc1_over_all', 'bc2_sec1', 'bc2_sec2', 'bc2_sec3', 'bc2_sec4', 'bc2_sec5', 'bc2_over_all', 'dif_over_all'], 'number'],
            [['district_name'], 'string', 'max' => 150],
            [['gram_panchayat_name', 'bc1_first_name', 'bc1_leadership_name', 'bc1_who_maintain_account', 'bc2_first_name', 'bc2_leadership_name', 'bc2_who_maintain_account', 'bc1_active_members_name1', 'bc1_active_members_name2', 'bc1_belongingness_name1', 'bc1_belongingness_name2', 'bc1_awareness_name1', 'bc1_awareness_name2', 'bc1_member_who_contact_in_other_group_name1', 'bc1_member_who_contact_in_other_group_name2', 'bc1_demanded_group_member_name1', 'bc1_demanded_group_member_name2', 'bc1_most_contribute_name', 'bc1_entrepreneurial', 'bc1_afraid_unknown_rules1', 'bc1_afraid_unknown_rules2', 'bc1_concept_of_setting_up_new_heights', 'bc1_livelihood_opportunity_for_another_member1', 'bc1_livelihood_opportunity_for_another_member2', 'bc1_negotiate_best1', 'bc1_negotiate_best2', 'bc1_which_member_can_talk_advantages1', 'bc1_which_member_can_talk_advantages2'], 'string', 'max' => 100],
            [['bc1_application_id', 'bc2_application_id'], 'string', 'max' => 20],
            [['bc1_mobile_number', 'bc1_mobile_no'], 'string', 'max' => 13],
            [['block_name'], 'string', 'max' => 255],
            [['gram_panchayat_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'district_code' => 'District Code',
            'district_name' => 'District Name',
            'gram_panchayat_code' => 'Gram Panchayat Code',
            'gram_panchayat_name' => 'Gram Panchayat Name',
            'bc1_id' => 'Bc1 ID',
            'bc1_first_name' => 'Bc1 First Name',
            'bc1_reading_skills' => 'Bc1 Reading Skills',
            'bc1_what_else_with_mobile1' => 'Bc1 What Else With Mobile1',
            'bc1_what_else_with_mobile2' => 'Bc1 What Else With Mobile2',
            'bc1_what_else_with_mobile3' => 'Bc1 What Else With Mobile3',
            'bc1_what_else_with_mobile4' => 'Bc1 What Else With Mobile4',
            'bc1_what_else_with_mobile5' => 'Bc1 What Else With Mobile5',
            'bc1_whats_app_number' => 'Bc1 Whats App Number',
            'bc1_vechicle_drive1' => 'Bc1 Vechicle Drive1',
            'bc1_vechicle_drive2' => 'Bc1 Vechicle Drive2',
            'bc1_vechicle_drive3' => 'Bc1 Vechicle Drive3',
            'bc1_vechicle_drive5' => 'Bc1 Vechicle Drive5',
            'bc1_vechicle_drive6' => 'Bc1 Vechicle Drive6',
            'bc1_vechicle_drive7' => 'Bc1 Vechicle Drive7',
            'bc1_house_member_details2' => 'Bc1 House Member Details2',
            'bc1_house_member_details3' => 'Bc1 House Member Details3',
            'bc1_immediate_aspiration1' => 'Bc1 Immediate Aspiration1',
            'bc1_immediate_aspiration2' => 'Bc1 Immediate Aspiration2',
            'bc1_immediate_aspiration3' => 'Bc1 Immediate Aspiration3',
            'bc1_immediate_aspiration4' => 'Bc1 Immediate Aspiration4',
            'bc1_immediate_aspiration5' => 'Bc1 Immediate Aspiration5',
            'bc1_immediate_aspiration6' => 'Bc1 Immediate Aspiration6',
            'bc1_already_group_member' => 'Bc1 Already Group Member',
            'bc1_leadership_name' => 'Bc1 Leadership Name',
            'bc1_role_in_group2' => 'Bc1 Role In Group2',
            'bc1_role_in_group3' => 'Bc1 Role In Group3',
            'bc1_role_in_group4' => 'Bc1 Role In Group4',
            'bc1_role_in_group5' => 'Bc1 Role In Group5',
            'bc1_role_in_group6' => 'Bc1 Role In Group6',
            'bc1_role_in_group7' => 'Bc1 Role In Group7',
            'bc1_role_in_group8' => 'Bc1 Role In Group8',
            'bc1_can_read_write_hindi' => 'Bc1 Can Read Write Hindi',
            'bc1_confirtable_in_english' => 'Bc1 Confirtable In English',
            'bc1_recognize_english_hindi' => 'Bc1 Recognize English Hindi',
            'bc1_can_add_substract_multiply' => 'Bc1 Can Add Substract Multiply',
            'bc1_who_maintain_account' => 'Bc1 Who Maintain Account',
            'bc1_choose_other_meaning1' => 'Bc1 Choose Other Meaning1',
            'bc1_choose_other_meaning2' => 'Bc1 Choose Other Meaning2',
            'bc1_choose_other_meaning3' => 'Bc1 Choose Other Meaning3',
            'bc1_choose_other_meaning4' => 'Bc1 Choose Other Meaning4',
            'bc1_choose_other_meaning5' => 'Bc1 Choose Other Meaning5',
            'bc1_same_to_same_word1' => 'Bc1 Same To Same Word1',
            'bc1_same_to_same_word2' => 'Bc1 Same To Same Word2',
            'bc1_same_to_same_word3' => 'Bc1 Same To Same Word3',
            'bc1_english_to_hindi1' => 'Bc1 English To Hindi1',
            'bc1_english_to_hindi2' => 'Bc1 English To Hindi2',
            'bc1_english_to_hindi3' => 'Bc1 English To Hindi3',
            'bc1_english_to_hindi4' => 'Bc1 English To Hindi4',
            'bc1_english_to_hindi5' => 'Bc1 English To Hindi5',
            'bc1_percentage_option1' => 'Bc1 Percentage Option1',
            'bc1_percentage_option2' => 'Bc1 Percentage Option2',
            'bc1_percentage_option3' => 'Bc1 Percentage Option3',
            'bc1_percentage_option4' => 'Bc1 Percentage Option4',
            'bc1_percentage_option5' => 'Bc1 Percentage Option5',
            'bc1_option_decision1' => 'Bc1 Option Decision1',
            'bc1_option_decision2' => 'Bc1 Option Decision2',
            'bc1_option_decision3' => 'Bc1 Option Decision3',
            'bc1_option_decision4' => 'Bc1 Option Decision4',
            'bc1_option_decision5' => 'Bc1 Option Decision5',
            'bc1_mobile_use_experience' => 'Bc1 Mobile Use Experience',
            'bc1_whose_mobile_you_using' => 'Bc1 Whose Mobile You Using',
            'bc1_no_of_people_using_phone' => 'Bc1 No Of People Using Phone',
            'bc1_no_of_family_people_using_phone' => 'Bc1 No Of Family People Using Phone',
            'bc1_already_worked' => 'Bc1 Already Worked',
            'bc1_own_mobile' => 'Bc1 Own Mobile',
            'bc1_own_mobile_means3' => 'Bc1 Own Mobile Means3',
            'bc1_own_mobile_means4' => 'Bc1 Own Mobile Means4',
            'bc1_own_mobile_means5' => 'Bc1 Own Mobile Means5',
            'bc1_own_mobile_means6' => 'Bc1 Own Mobile Means6',
            'bc1_own_mobile_means7' => 'Bc1 Own Mobile Means7',
            'bc1_own_mobile_means8' => 'Bc1 Own Mobile Means8',
            'bc1_method_used_for_ledger_account3' => 'Bc1 Method Used For Ledger Account3',
            'bc1_method_used_for_ledger_account4' => 'Bc1 Method Used For Ledger Account4',
            'bc1_method_used_for_ledger_account5' => 'Bc1 Method Used For Ledger Account5',
            'bc1_method_used_for_ledger_account6' => 'Bc1 Method Used For Ledger Account6',
            'bc1_need_training1' => 'Bc1 Need Training1',
            'bc1_need_training3' => 'Bc1 Need Training3',
            'bc1_need_training4' => 'Bc1 Need Training4',
            'bc1_need_training5' => 'Bc1 Need Training5',
            'bc1_sec1' => 'Bc1 Sec1',
            'bc1_sec2' => 'Bc1 Sec2',
            'bc1_sec3' => 'Bc1 Sec3',
            'bc1_sec4' => 'Bc1 Sec4',
            'bc1_sec5' => 'Bc1 Sec5',
            'bc1_over_all' => 'Bc1 Over All',
            'bc1_status_new' => 'Bc1 Status New',
            'bc1_status' => 'Bc1 Status',
            'bc1_training_status' => 'Bc1 Training Status',
            'bc2_id' => 'Bc2 ID',
            'bc2_first_name' => 'Bc2 First Name',
            'bc2_reading_skills' => 'Bc2 Reading Skills',
            'bc2_age' => 'Bc2 Age',
            'bc2_what_else_with_mobile1' => 'Bc2 What Else With Mobile1',
            'bc2_what_else_with_mobile2' => 'Bc2 What Else With Mobile2',
            'bc2_what_else_with_mobile3' => 'Bc2 What Else With Mobile3',
            'bc2_what_else_with_mobile4' => 'Bc2 What Else With Mobile4',
            'bc2_what_else_with_mobile5' => 'Bc2 What Else With Mobile5',
            'bc2_whats_app_number' => 'Bc2 Whats App Number',
            'bc2_vechicle_drive1' => 'Bc2 Vechicle Drive1',
            'bc2_vechicle_drive2' => 'Bc2 Vechicle Drive2',
            'bc2_vechicle_drive3' => 'Bc2 Vechicle Drive3',
            'bc2_vechicle_drive5' => 'Bc2 Vechicle Drive5',
            'bc2_vechicle_drive6' => 'Bc2 Vechicle Drive6',
            'bc2_vechicle_drive7' => 'Bc2 Vechicle Drive7',
            'bc2_house_member_details2' => 'Bc2 House Member Details2',
            'bc2_house_member_details3' => 'Bc2 House Member Details3',
            'bc2_immediate_aspiration1' => 'Bc2 Immediate Aspiration1',
            'bc2_immediate_aspiration2' => 'Bc2 Immediate Aspiration2',
            'bc2_immediate_aspiration3' => 'Bc2 Immediate Aspiration3',
            'bc2_immediate_aspiration4' => 'Bc2 Immediate Aspiration4',
            'bc2_immediate_aspiration5' => 'Bc2 Immediate Aspiration5',
            'bc2_immediate_aspiration6' => 'Bc2 Immediate Aspiration6',
            'bc2_already_group_member' => 'Bc2 Already Group Member',
            'bc2_leadership_name' => 'Bc2 Leadership Name',
            'bc2_role_in_group2' => 'Bc2 Role In Group2',
            'bc2_role_in_group3' => 'Bc2 Role In Group3',
            'bc2_role_in_group4' => 'Bc2 Role In Group4',
            'bc2_role_in_group5' => 'Bc2 Role In Group5',
            'bc2_role_in_group6' => 'Bc2 Role In Group6',
            'bc2_role_in_group7' => 'Bc2 Role In Group7',
            'bc2_role_in_group8' => 'Bc2 Role In Group8',
            'bc2_can_read_write_hindi' => 'Bc2 Can Read Write Hindi',
            'bc2_confirtable_in_english' => 'Bc2 Confirtable In English',
            'bc2_recognize_english_hindi' => 'Bc2 Recognize English Hindi',
            'bc2_can_add_substract_multiply' => 'Bc2 Can Add Substract Multiply',
            'bc2_who_maintain_account' => 'Bc2 Who Maintain Account',
            'bc2_choose_other_meaning1' => 'Bc2 Choose Other Meaning1',
            'bc2_choose_other_meaning2' => 'Bc2 Choose Other Meaning2',
            'bc2_choose_other_meaning3' => 'Bc2 Choose Other Meaning3',
            'bc2_choose_other_meaning4' => 'Bc2 Choose Other Meaning4',
            'bc2_choose_other_meaning5' => 'Bc2 Choose Other Meaning5',
            'bc2_same_to_same_word1' => 'Bc2 Same To Same Word1',
            'bc2_same_to_same_word2' => 'Bc2 Same To Same Word2',
            'bc2_same_to_same_word3' => 'Bc2 Same To Same Word3',
            'bc2_english_to_hindi1' => 'Bc2 English To Hindi1',
            'bc2_english_to_hindi2' => 'Bc2 English To Hindi2',
            'bc2_english_to_hindi3' => 'Bc2 English To Hindi3',
            'bc2_english_to_hindi4' => 'Bc2 English To Hindi4',
            'bc2_english_to_hindi5' => 'Bc2 English To Hindi5',
            'bc2_percentage_option1' => 'Bc2 Percentage Option1',
            'bc2_percentage_option2' => 'Bc2 Percentage Option2',
            'bc2_percentage_option3' => 'Bc2 Percentage Option3',
            'bc2_percentage_option4' => 'Bc2 Percentage Option4',
            'bc2_percentage_option5' => 'Bc2 Percentage Option5',
            'bc2_option_decision1' => 'Bc2 Option Decision1',
            'bc2_option_decision2' => 'Bc2 Option Decision2',
            'bc2_option_decision3' => 'Bc2 Option Decision3',
            'bc2_option_decision4' => 'Bc2 Option Decision4',
            'bc2_option_decision5' => 'Bc2 Option Decision5',
            'bc2_mobile_use_experience' => 'Bc2 Mobile Use Experience',
            'bc2_whose_mobile_you_using' => 'Bc2 Whose Mobile You Using',
            'bc2_no_of_people_using_phone' => 'Bc2 No Of People Using Phone',
            'bc2_no_of_family_people_using_phone' => 'Bc2 No Of Family People Using Phone',
            'bc2_already_worked' => 'Bc2 Already Worked',
            'bc2_own_mobile' => 'Bc2 Own Mobile',
            'bc2_own_mobile_means3' => 'Bc2 Own Mobile Means3',
            'bc2_own_mobile_means4' => 'Bc2 Own Mobile Means4',
            'bc2_own_mobile_means5' => 'Bc2 Own Mobile Means5',
            'bc2_own_mobile_means6' => 'Bc2 Own Mobile Means6',
            'bc2_own_mobile_means7' => 'Bc2 Own Mobile Means7',
            'bc2_own_mobile_means8' => 'Bc2 Own Mobile Means8',
            'bc2_method_used_for_ledger_account3' => 'Bc2 Method Used For Ledger Account3',
            'bc2_method_used_for_ledger_account4' => 'Bc2 Method Used For Ledger Account4',
            'bc2_method_used_for_ledger_account5' => 'Bc2 Method Used For Ledger Account5',
            'bc2_method_used_for_ledger_account6' => 'Bc2 Method Used For Ledger Account6',
            'bc2_need_training1' => 'Bc2 Need Training1',
            'bc2_need_training3' => 'Bc2 Need Training3',
            'bc2_need_training4' => 'Bc2 Need Training4',
            'bc2_need_training5' => 'Bc2 Need Training5',
            'bc2_sec1' => 'Bc2 Sec1',
            'bc2_sec2' => 'Bc2 Sec2',
            'bc2_sec3' => 'Bc2 Sec3',
            'bc2_sec4' => 'Bc2 Sec4',
            'bc2_sec5' => 'Bc2 Sec5',
            'bc2_over_all' => 'Bc2 Over All',
            'bc2_status_new' => 'Bc2 Status New',
            'bc2_status' => 'Bc2 Status',
            'dif_over_all' => 'Dif Over All',
            'bc1_phone_type' => 'Bc1 Phone Type',
            'bc2_phone_type' => 'Bc2 Phone Type',
            'bc1_why_did_you_get_elected1' => 'Bc1 Why Did You Get Elected1',
            'bc1_why_did_you_get_elected2' => 'Bc1 Why Did You Get Elected2',
            'bc1_why_did_you_get_elected3' => 'Bc1 Why Did You Get Elected3',
            'bc1_why_did_you_get_elected4' => 'Bc1 Why Did You Get Elected4',
            'bc1_why_did_you_get_elected5' => 'Bc1 Why Did You Get Elected5',
            'bc1_why_did_you_get_elected6' => 'Bc1 Why Did You Get Elected6',
            'bc1_why_did_you_get_elected7' => 'Bc1 Why Did You Get Elected7',
            'bc1_why_did_you_get_elected8' => 'Bc1 Why Did You Get Elected8',
            'bc1_why_did_you_get_elected9' => 'Bc1 Why Did You Get Elected9',
            'bc1_active_members_name1' => 'Bc1 Active Members Name1',
            'bc1_active_members_name2' => 'Bc1 Active Members Name2',
            'bc1_belongingness_name1' => 'Bc1 Belongingness Name1',
            'bc1_belongingness_name2' => 'Bc1 Belongingness Name2',
            'bc1_awareness_name1' => 'Bc1 Awareness Name1',
            'bc1_awareness_name2' => 'Bc1 Awareness Name2',
            'bc1_member_who_contact_in_other_group_name1' => 'Bc1 Member Who Contact In Other Group Name1',
            'bc1_member_who_contact_in_other_group_name2' => 'Bc1 Member Who Contact In Other Group Name2',
            'bc1_demanded_group_member_name1' => 'Bc1 Demanded Group Member Name1',
            'bc1_demanded_group_member_name2' => 'Bc1 Demanded Group Member Name2',
            'bc1_capable_fast_pace' => 'Bc1 Capable Fast Pace',
            'bc1_his_perception3' => 'Bc1 His Perception3',
            'bc1_most_contribute_name' => 'Bc1 Most Contribute Name',
            'bc1_entrepreneurial' => 'Bc1 Entrepreneurial',
            'bc1_afraid_unknown_rules1' => 'Bc1 Afraid Unknown Rules1',
            'bc1_afraid_unknown_rules2' => 'Bc1 Afraid Unknown Rules2',
            'bc1_concept_of_setting_up_new_heights' => 'Bc1 Concept Of Setting Up New Heights',
            'bc1_livelihood_opportunity_for_another_member1' => 'Bc1 Livelihood Opportunity For Another Member1',
            'bc1_livelihood_opportunity_for_another_member2' => 'Bc1 Livelihood Opportunity For Another Member2',
            'bc1_negotiate_best1' => 'Bc1 Negotiate Best1',
            'bc1_negotiate_best2' => 'Bc1 Negotiate Best2',
            'bc1_which_member_can_talk_advantages1' => 'Bc1 Which Member Can Talk Advantages1',
            'bc1_which_member_can_talk_advantages2' => 'Bc1 Which Member Can Talk Advantages2',
            'bc1_application_id' => 'Bc1 Application ID',
            'bc1_aadhar_duplicate' => 'Bc1 Aadhar Duplicate',
            'bc2_application_id' => 'Bc2 Application ID',
            'bc2_aadhar_duplicate' => 'Bc2 Aadhar Duplicate',
            'bc2_selected_round2' => 'Bc2 Selected Round2',
            'urban_gp' => 'Urban Gp',
            'process_status' => 'Process Status',
            'bc1_mobile_number' => 'Bc1 Mobile Number',
            'bc1_mobile_no' => 'Bc1 Mobile No',
            'block_name' => 'Block Name',
        ];
    }
}
