<?php

namespace bc\modules\selection\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use bc\modules\selection\models\GpApplication;

/**
 * GpApplicationSearch represents the model behind the search form of `bc\modules\selection\models\GpApplication`.
 */
class GpApplicationSearch extends GpApplication
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'district_code', 'gram_panchayat_code', 'bc1_id', 'bc1_reading_skills', 'bc1_what_else_with_mobile1', 'bc1_what_else_with_mobile2', 'bc1_what_else_with_mobile3', 'bc1_what_else_with_mobile4', 'bc1_what_else_with_mobile5', 'bc1_whats_app_number', 'bc1_vechicle_drive1', 'bc1_vechicle_drive2', 'bc1_vechicle_drive3', 'bc1_vechicle_drive5', 'bc1_vechicle_drive6', 'bc1_vechicle_drive7', 'bc1_house_member_details2', 'bc1_house_member_details3', 'bc1_immediate_aspiration1', 'bc1_immediate_aspiration2', 'bc1_immediate_aspiration3', 'bc1_immediate_aspiration4', 'bc1_immediate_aspiration5', 'bc1_immediate_aspiration6', 'bc1_already_group_member', 'bc1_role_in_group2', 'bc1_role_in_group3', 'bc1_role_in_group4', 'bc1_role_in_group5', 'bc1_role_in_group6', 'bc1_role_in_group7', 'bc1_role_in_group8', 'bc1_can_read_write_hindi', 'bc1_confirtable_in_english', 'bc1_recognize_english_hindi', 'bc1_can_add_substract_multiply', 'bc1_choose_other_meaning1', 'bc1_choose_other_meaning2', 'bc1_choose_other_meaning3', 'bc1_choose_other_meaning4', 'bc1_choose_other_meaning5', 'bc1_same_to_same_word1', 'bc1_same_to_same_word2', 'bc1_same_to_same_word3', 'bc1_english_to_hindi1', 'bc1_english_to_hindi2', 'bc1_english_to_hindi3', 'bc1_english_to_hindi4', 'bc1_english_to_hindi5', 'bc1_percentage_option1', 'bc1_percentage_option2', 'bc1_percentage_option3', 'bc1_percentage_option4', 'bc1_percentage_option5', 'bc1_option_decision1', 'bc1_option_decision2', 'bc1_option_decision3', 'bc1_option_decision4', 'bc1_option_decision5', 'bc1_mobile_use_experience', 'bc1_whose_mobile_you_using', 'bc1_no_of_people_using_phone', 'bc1_no_of_family_people_using_phone', 'bc1_already_worked', 'bc1_own_mobile', 'bc1_own_mobile_means3', 'bc1_own_mobile_means4', 'bc1_own_mobile_means5', 'bc1_own_mobile_means6', 'bc1_own_mobile_means7', 'bc1_own_mobile_means8', 'bc1_method_used_for_ledger_account3', 'bc1_method_used_for_ledger_account4', 'bc1_method_used_for_ledger_account5', 'bc1_method_used_for_ledger_account6', 'bc1_need_training1', 'bc1_need_training3', 'bc1_need_training4', 'bc1_need_training5', 'bc1_status_new', 'bc1_status', 'bc1_training_status', 'bc2_id', 'bc2_reading_skills', 'bc2_age', 'bc2_what_else_with_mobile1', 'bc2_what_else_with_mobile2', 'bc2_what_else_with_mobile3', 'bc2_what_else_with_mobile4', 'bc2_what_else_with_mobile5', 'bc2_whats_app_number', 'bc2_vechicle_drive1', 'bc2_vechicle_drive2', 'bc2_vechicle_drive3', 'bc2_vechicle_drive5', 'bc2_vechicle_drive6', 'bc2_vechicle_drive7', 'bc2_house_member_details2', 'bc2_house_member_details3', 'bc2_immediate_aspiration1', 'bc2_immediate_aspiration2', 'bc2_immediate_aspiration3', 'bc2_immediate_aspiration4', 'bc2_immediate_aspiration5', 'bc2_immediate_aspiration6', 'bc2_already_group_member', 'bc2_role_in_group2', 'bc2_role_in_group3', 'bc2_role_in_group4', 'bc2_role_in_group5', 'bc2_role_in_group6', 'bc2_role_in_group7', 'bc2_role_in_group8', 'bc2_can_read_write_hindi', 'bc2_confirtable_in_english', 'bc2_recognize_english_hindi', 'bc2_can_add_substract_multiply', 'bc2_choose_other_meaning1', 'bc2_choose_other_meaning2', 'bc2_choose_other_meaning3', 'bc2_choose_other_meaning4', 'bc2_choose_other_meaning5', 'bc2_same_to_same_word1', 'bc2_same_to_same_word2', 'bc2_same_to_same_word3', 'bc2_english_to_hindi1', 'bc2_english_to_hindi2', 'bc2_english_to_hindi3', 'bc2_english_to_hindi4', 'bc2_english_to_hindi5', 'bc2_percentage_option1', 'bc2_percentage_option2', 'bc2_percentage_option3', 'bc2_percentage_option4', 'bc2_percentage_option5', 'bc2_option_decision1', 'bc2_option_decision2', 'bc2_option_decision3', 'bc2_option_decision4', 'bc2_option_decision5', 'bc2_mobile_use_experience', 'bc2_whose_mobile_you_using', 'bc2_no_of_people_using_phone', 'bc2_no_of_family_people_using_phone', 'bc2_already_worked', 'bc2_own_mobile', 'bc2_own_mobile_means3', 'bc2_own_mobile_means4', 'bc2_own_mobile_means5', 'bc2_own_mobile_means6', 'bc2_own_mobile_means7', 'bc2_own_mobile_means8', 'bc2_method_used_for_ledger_account3', 'bc2_method_used_for_ledger_account4', 'bc2_method_used_for_ledger_account5', 'bc2_method_used_for_ledger_account6', 'bc2_need_training1', 'bc2_need_training3', 'bc2_need_training4', 'bc2_need_training5', 'bc2_status_new', 'bc2_status', 'bc1_phone_type', 'bc2_phone_type', 'bc1_why_did_you_get_elected1', 'bc1_why_did_you_get_elected2', 'bc1_why_did_you_get_elected3', 'bc1_why_did_you_get_elected4', 'bc1_why_did_you_get_elected5', 'bc1_why_did_you_get_elected6', 'bc1_why_did_you_get_elected7', 'bc1_why_did_you_get_elected8', 'bc1_why_did_you_get_elected9', 'bc1_capable_fast_pace', 'bc1_his_perception3', 'bc1_aadhar_duplicate', 'bc2_aadhar_duplicate', 'bc2_selected_round2', 'urban_gp', 'process_status'], 'integer'],
            [['district_name', 'gram_panchayat_name', 'bc1_first_name', 'bc1_leadership_name', 'bc1_who_maintain_account', 'bc2_first_name', 'bc2_leadership_name', 'bc2_who_maintain_account', 'bc1_active_members_name1', 'bc1_active_members_name2', 'bc1_belongingness_name1', 'bc1_belongingness_name2', 'bc1_awareness_name1', 'bc1_awareness_name2', 'bc1_member_who_contact_in_other_group_name1', 'bc1_member_who_contact_in_other_group_name2', 'bc1_demanded_group_member_name1', 'bc1_demanded_group_member_name2', 'bc1_most_contribute_name', 'bc1_entrepreneurial', 'bc1_afraid_unknown_rules1', 'bc1_afraid_unknown_rules2', 'bc1_concept_of_setting_up_new_heights', 'bc1_livelihood_opportunity_for_another_member1', 'bc1_livelihood_opportunity_for_another_member2', 'bc1_negotiate_best1', 'bc1_negotiate_best2', 'bc1_which_member_can_talk_advantages1', 'bc1_which_member_can_talk_advantages2', 'bc1_application_id', 'bc2_application_id', 'bc1_mobile_number', 'bc1_mobile_no', 'block_name'], 'safe'],
            [['bc1_sec1', 'bc1_sec2', 'bc1_sec3', 'bc1_sec4', 'bc1_sec5', 'bc1_over_all', 'bc2_sec1', 'bc2_sec2', 'bc2_sec3', 'bc2_sec4', 'bc2_sec5', 'bc2_over_all', 'dif_over_all'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = GpApplication::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'district_code' => $this->district_code,
            'gram_panchayat_code' => $this->gram_panchayat_code,
            'bc1_id' => $this->bc1_id,
            'bc1_reading_skills' => $this->bc1_reading_skills,
            'bc1_what_else_with_mobile1' => $this->bc1_what_else_with_mobile1,
            'bc1_what_else_with_mobile2' => $this->bc1_what_else_with_mobile2,
            'bc1_what_else_with_mobile3' => $this->bc1_what_else_with_mobile3,
            'bc1_what_else_with_mobile4' => $this->bc1_what_else_with_mobile4,
            'bc1_what_else_with_mobile5' => $this->bc1_what_else_with_mobile5,
            'bc1_whats_app_number' => $this->bc1_whats_app_number,
            'bc1_vechicle_drive1' => $this->bc1_vechicle_drive1,
            'bc1_vechicle_drive2' => $this->bc1_vechicle_drive2,
            'bc1_vechicle_drive3' => $this->bc1_vechicle_drive3,
            'bc1_vechicle_drive5' => $this->bc1_vechicle_drive5,
            'bc1_vechicle_drive6' => $this->bc1_vechicle_drive6,
            'bc1_vechicle_drive7' => $this->bc1_vechicle_drive7,
            'bc1_house_member_details2' => $this->bc1_house_member_details2,
            'bc1_house_member_details3' => $this->bc1_house_member_details3,
            'bc1_immediate_aspiration1' => $this->bc1_immediate_aspiration1,
            'bc1_immediate_aspiration2' => $this->bc1_immediate_aspiration2,
            'bc1_immediate_aspiration3' => $this->bc1_immediate_aspiration3,
            'bc1_immediate_aspiration4' => $this->bc1_immediate_aspiration4,
            'bc1_immediate_aspiration5' => $this->bc1_immediate_aspiration5,
            'bc1_immediate_aspiration6' => $this->bc1_immediate_aspiration6,
            'bc1_already_group_member' => $this->bc1_already_group_member,
            'bc1_role_in_group2' => $this->bc1_role_in_group2,
            'bc1_role_in_group3' => $this->bc1_role_in_group3,
            'bc1_role_in_group4' => $this->bc1_role_in_group4,
            'bc1_role_in_group5' => $this->bc1_role_in_group5,
            'bc1_role_in_group6' => $this->bc1_role_in_group6,
            'bc1_role_in_group7' => $this->bc1_role_in_group7,
            'bc1_role_in_group8' => $this->bc1_role_in_group8,
            'bc1_can_read_write_hindi' => $this->bc1_can_read_write_hindi,
            'bc1_confirtable_in_english' => $this->bc1_confirtable_in_english,
            'bc1_recognize_english_hindi' => $this->bc1_recognize_english_hindi,
            'bc1_can_add_substract_multiply' => $this->bc1_can_add_substract_multiply,
            'bc1_choose_other_meaning1' => $this->bc1_choose_other_meaning1,
            'bc1_choose_other_meaning2' => $this->bc1_choose_other_meaning2,
            'bc1_choose_other_meaning3' => $this->bc1_choose_other_meaning3,
            'bc1_choose_other_meaning4' => $this->bc1_choose_other_meaning4,
            'bc1_choose_other_meaning5' => $this->bc1_choose_other_meaning5,
            'bc1_same_to_same_word1' => $this->bc1_same_to_same_word1,
            'bc1_same_to_same_word2' => $this->bc1_same_to_same_word2,
            'bc1_same_to_same_word3' => $this->bc1_same_to_same_word3,
            'bc1_english_to_hindi1' => $this->bc1_english_to_hindi1,
            'bc1_english_to_hindi2' => $this->bc1_english_to_hindi2,
            'bc1_english_to_hindi3' => $this->bc1_english_to_hindi3,
            'bc1_english_to_hindi4' => $this->bc1_english_to_hindi4,
            'bc1_english_to_hindi5' => $this->bc1_english_to_hindi5,
            'bc1_percentage_option1' => $this->bc1_percentage_option1,
            'bc1_percentage_option2' => $this->bc1_percentage_option2,
            'bc1_percentage_option3' => $this->bc1_percentage_option3,
            'bc1_percentage_option4' => $this->bc1_percentage_option4,
            'bc1_percentage_option5' => $this->bc1_percentage_option5,
            'bc1_option_decision1' => $this->bc1_option_decision1,
            'bc1_option_decision2' => $this->bc1_option_decision2,
            'bc1_option_decision3' => $this->bc1_option_decision3,
            'bc1_option_decision4' => $this->bc1_option_decision4,
            'bc1_option_decision5' => $this->bc1_option_decision5,
            'bc1_mobile_use_experience' => $this->bc1_mobile_use_experience,
            'bc1_whose_mobile_you_using' => $this->bc1_whose_mobile_you_using,
            'bc1_no_of_people_using_phone' => $this->bc1_no_of_people_using_phone,
            'bc1_no_of_family_people_using_phone' => $this->bc1_no_of_family_people_using_phone,
            'bc1_already_worked' => $this->bc1_already_worked,
            'bc1_own_mobile' => $this->bc1_own_mobile,
            'bc1_own_mobile_means3' => $this->bc1_own_mobile_means3,
            'bc1_own_mobile_means4' => $this->bc1_own_mobile_means4,
            'bc1_own_mobile_means5' => $this->bc1_own_mobile_means5,
            'bc1_own_mobile_means6' => $this->bc1_own_mobile_means6,
            'bc1_own_mobile_means7' => $this->bc1_own_mobile_means7,
            'bc1_own_mobile_means8' => $this->bc1_own_mobile_means8,
            'bc1_method_used_for_ledger_account3' => $this->bc1_method_used_for_ledger_account3,
            'bc1_method_used_for_ledger_account4' => $this->bc1_method_used_for_ledger_account4,
            'bc1_method_used_for_ledger_account5' => $this->bc1_method_used_for_ledger_account5,
            'bc1_method_used_for_ledger_account6' => $this->bc1_method_used_for_ledger_account6,
            'bc1_need_training1' => $this->bc1_need_training1,
            'bc1_need_training3' => $this->bc1_need_training3,
            'bc1_need_training4' => $this->bc1_need_training4,
            'bc1_need_training5' => $this->bc1_need_training5,
            'bc1_sec1' => $this->bc1_sec1,
            'bc1_sec2' => $this->bc1_sec2,
            'bc1_sec3' => $this->bc1_sec3,
            'bc1_sec4' => $this->bc1_sec4,
            'bc1_sec5' => $this->bc1_sec5,
            'bc1_over_all' => $this->bc1_over_all,
            'bc1_status_new' => $this->bc1_status_new,
            'bc1_status' => $this->bc1_status,
            'bc1_training_status' => $this->bc1_training_status,
            'bc2_id' => $this->bc2_id,
            'bc2_reading_skills' => $this->bc2_reading_skills,
            'bc2_age' => $this->bc2_age,
            'bc2_what_else_with_mobile1' => $this->bc2_what_else_with_mobile1,
            'bc2_what_else_with_mobile2' => $this->bc2_what_else_with_mobile2,
            'bc2_what_else_with_mobile3' => $this->bc2_what_else_with_mobile3,
            'bc2_what_else_with_mobile4' => $this->bc2_what_else_with_mobile4,
            'bc2_what_else_with_mobile5' => $this->bc2_what_else_with_mobile5,
            'bc2_whats_app_number' => $this->bc2_whats_app_number,
            'bc2_vechicle_drive1' => $this->bc2_vechicle_drive1,
            'bc2_vechicle_drive2' => $this->bc2_vechicle_drive2,
            'bc2_vechicle_drive3' => $this->bc2_vechicle_drive3,
            'bc2_vechicle_drive5' => $this->bc2_vechicle_drive5,
            'bc2_vechicle_drive6' => $this->bc2_vechicle_drive6,
            'bc2_vechicle_drive7' => $this->bc2_vechicle_drive7,
            'bc2_house_member_details2' => $this->bc2_house_member_details2,
            'bc2_house_member_details3' => $this->bc2_house_member_details3,
            'bc2_immediate_aspiration1' => $this->bc2_immediate_aspiration1,
            'bc2_immediate_aspiration2' => $this->bc2_immediate_aspiration2,
            'bc2_immediate_aspiration3' => $this->bc2_immediate_aspiration3,
            'bc2_immediate_aspiration4' => $this->bc2_immediate_aspiration4,
            'bc2_immediate_aspiration5' => $this->bc2_immediate_aspiration5,
            'bc2_immediate_aspiration6' => $this->bc2_immediate_aspiration6,
            'bc2_already_group_member' => $this->bc2_already_group_member,
            'bc2_role_in_group2' => $this->bc2_role_in_group2,
            'bc2_role_in_group3' => $this->bc2_role_in_group3,
            'bc2_role_in_group4' => $this->bc2_role_in_group4,
            'bc2_role_in_group5' => $this->bc2_role_in_group5,
            'bc2_role_in_group6' => $this->bc2_role_in_group6,
            'bc2_role_in_group7' => $this->bc2_role_in_group7,
            'bc2_role_in_group8' => $this->bc2_role_in_group8,
            'bc2_can_read_write_hindi' => $this->bc2_can_read_write_hindi,
            'bc2_confirtable_in_english' => $this->bc2_confirtable_in_english,
            'bc2_recognize_english_hindi' => $this->bc2_recognize_english_hindi,
            'bc2_can_add_substract_multiply' => $this->bc2_can_add_substract_multiply,
            'bc2_choose_other_meaning1' => $this->bc2_choose_other_meaning1,
            'bc2_choose_other_meaning2' => $this->bc2_choose_other_meaning2,
            'bc2_choose_other_meaning3' => $this->bc2_choose_other_meaning3,
            'bc2_choose_other_meaning4' => $this->bc2_choose_other_meaning4,
            'bc2_choose_other_meaning5' => $this->bc2_choose_other_meaning5,
            'bc2_same_to_same_word1' => $this->bc2_same_to_same_word1,
            'bc2_same_to_same_word2' => $this->bc2_same_to_same_word2,
            'bc2_same_to_same_word3' => $this->bc2_same_to_same_word3,
            'bc2_english_to_hindi1' => $this->bc2_english_to_hindi1,
            'bc2_english_to_hindi2' => $this->bc2_english_to_hindi2,
            'bc2_english_to_hindi3' => $this->bc2_english_to_hindi3,
            'bc2_english_to_hindi4' => $this->bc2_english_to_hindi4,
            'bc2_english_to_hindi5' => $this->bc2_english_to_hindi5,
            'bc2_percentage_option1' => $this->bc2_percentage_option1,
            'bc2_percentage_option2' => $this->bc2_percentage_option2,
            'bc2_percentage_option3' => $this->bc2_percentage_option3,
            'bc2_percentage_option4' => $this->bc2_percentage_option4,
            'bc2_percentage_option5' => $this->bc2_percentage_option5,
            'bc2_option_decision1' => $this->bc2_option_decision1,
            'bc2_option_decision2' => $this->bc2_option_decision2,
            'bc2_option_decision3' => $this->bc2_option_decision3,
            'bc2_option_decision4' => $this->bc2_option_decision4,
            'bc2_option_decision5' => $this->bc2_option_decision5,
            'bc2_mobile_use_experience' => $this->bc2_mobile_use_experience,
            'bc2_whose_mobile_you_using' => $this->bc2_whose_mobile_you_using,
            'bc2_no_of_people_using_phone' => $this->bc2_no_of_people_using_phone,
            'bc2_no_of_family_people_using_phone' => $this->bc2_no_of_family_people_using_phone,
            'bc2_already_worked' => $this->bc2_already_worked,
            'bc2_own_mobile' => $this->bc2_own_mobile,
            'bc2_own_mobile_means3' => $this->bc2_own_mobile_means3,
            'bc2_own_mobile_means4' => $this->bc2_own_mobile_means4,
            'bc2_own_mobile_means5' => $this->bc2_own_mobile_means5,
            'bc2_own_mobile_means6' => $this->bc2_own_mobile_means6,
            'bc2_own_mobile_means7' => $this->bc2_own_mobile_means7,
            'bc2_own_mobile_means8' => $this->bc2_own_mobile_means8,
            'bc2_method_used_for_ledger_account3' => $this->bc2_method_used_for_ledger_account3,
            'bc2_method_used_for_ledger_account4' => $this->bc2_method_used_for_ledger_account4,
            'bc2_method_used_for_ledger_account5' => $this->bc2_method_used_for_ledger_account5,
            'bc2_method_used_for_ledger_account6' => $this->bc2_method_used_for_ledger_account6,
            'bc2_need_training1' => $this->bc2_need_training1,
            'bc2_need_training3' => $this->bc2_need_training3,
            'bc2_need_training4' => $this->bc2_need_training4,
            'bc2_need_training5' => $this->bc2_need_training5,
            'bc2_sec1' => $this->bc2_sec1,
            'bc2_sec2' => $this->bc2_sec2,
            'bc2_sec3' => $this->bc2_sec3,
            'bc2_sec4' => $this->bc2_sec4,
            'bc2_sec5' => $this->bc2_sec5,
            'bc2_over_all' => $this->bc2_over_all,
            'bc2_status_new' => $this->bc2_status_new,
            'bc2_status' => $this->bc2_status,
            'dif_over_all' => $this->dif_over_all,
            'bc1_phone_type' => $this->bc1_phone_type,
            'bc2_phone_type' => $this->bc2_phone_type,
            'bc1_why_did_you_get_elected1' => $this->bc1_why_did_you_get_elected1,
            'bc1_why_did_you_get_elected2' => $this->bc1_why_did_you_get_elected2,
            'bc1_why_did_you_get_elected3' => $this->bc1_why_did_you_get_elected3,
            'bc1_why_did_you_get_elected4' => $this->bc1_why_did_you_get_elected4,
            'bc1_why_did_you_get_elected5' => $this->bc1_why_did_you_get_elected5,
            'bc1_why_did_you_get_elected6' => $this->bc1_why_did_you_get_elected6,
            'bc1_why_did_you_get_elected7' => $this->bc1_why_did_you_get_elected7,
            'bc1_why_did_you_get_elected8' => $this->bc1_why_did_you_get_elected8,
            'bc1_why_did_you_get_elected9' => $this->bc1_why_did_you_get_elected9,
            'bc1_capable_fast_pace' => $this->bc1_capable_fast_pace,
            'bc1_his_perception3' => $this->bc1_his_perception3,
            'bc1_aadhar_duplicate' => $this->bc1_aadhar_duplicate,
            'bc2_aadhar_duplicate' => $this->bc2_aadhar_duplicate,
            'bc2_selected_round2' => $this->bc2_selected_round2,
            'urban_gp' => $this->urban_gp,
            'process_status' => $this->process_status,
        ]);

        $query->andFilterWhere(['like', 'district_name', $this->district_name])
            ->andFilterWhere(['like', 'gram_panchayat_name', $this->gram_panchayat_name])
            ->andFilterWhere(['like', 'bc1_first_name', $this->bc1_first_name])
            ->andFilterWhere(['like', 'bc1_leadership_name', $this->bc1_leadership_name])
            ->andFilterWhere(['like', 'bc1_who_maintain_account', $this->bc1_who_maintain_account])
            ->andFilterWhere(['like', 'bc2_first_name', $this->bc2_first_name])
            ->andFilterWhere(['like', 'bc2_leadership_name', $this->bc2_leadership_name])
            ->andFilterWhere(['like', 'bc2_who_maintain_account', $this->bc2_who_maintain_account])
            ->andFilterWhere(['like', 'bc1_active_members_name1', $this->bc1_active_members_name1])
            ->andFilterWhere(['like', 'bc1_active_members_name2', $this->bc1_active_members_name2])
            ->andFilterWhere(['like', 'bc1_belongingness_name1', $this->bc1_belongingness_name1])
            ->andFilterWhere(['like', 'bc1_belongingness_name2', $this->bc1_belongingness_name2])
            ->andFilterWhere(['like', 'bc1_awareness_name1', $this->bc1_awareness_name1])
            ->andFilterWhere(['like', 'bc1_awareness_name2', $this->bc1_awareness_name2])
            ->andFilterWhere(['like', 'bc1_member_who_contact_in_other_group_name1', $this->bc1_member_who_contact_in_other_group_name1])
            ->andFilterWhere(['like', 'bc1_member_who_contact_in_other_group_name2', $this->bc1_member_who_contact_in_other_group_name2])
            ->andFilterWhere(['like', 'bc1_demanded_group_member_name1', $this->bc1_demanded_group_member_name1])
            ->andFilterWhere(['like', 'bc1_demanded_group_member_name2', $this->bc1_demanded_group_member_name2])
            ->andFilterWhere(['like', 'bc1_most_contribute_name', $this->bc1_most_contribute_name])
            ->andFilterWhere(['like', 'bc1_entrepreneurial', $this->bc1_entrepreneurial])
            ->andFilterWhere(['like', 'bc1_afraid_unknown_rules1', $this->bc1_afraid_unknown_rules1])
            ->andFilterWhere(['like', 'bc1_afraid_unknown_rules2', $this->bc1_afraid_unknown_rules2])
            ->andFilterWhere(['like', 'bc1_concept_of_setting_up_new_heights', $this->bc1_concept_of_setting_up_new_heights])
            ->andFilterWhere(['like', 'bc1_livelihood_opportunity_for_another_member1', $this->bc1_livelihood_opportunity_for_another_member1])
            ->andFilterWhere(['like', 'bc1_livelihood_opportunity_for_another_member2', $this->bc1_livelihood_opportunity_for_another_member2])
            ->andFilterWhere(['like', 'bc1_negotiate_best1', $this->bc1_negotiate_best1])
            ->andFilterWhere(['like', 'bc1_negotiate_best2', $this->bc1_negotiate_best2])
            ->andFilterWhere(['like', 'bc1_which_member_can_talk_advantages1', $this->bc1_which_member_can_talk_advantages1])
            ->andFilterWhere(['like', 'bc1_which_member_can_talk_advantages2', $this->bc1_which_member_can_talk_advantages2])
            ->andFilterWhere(['like', 'bc1_application_id', $this->bc1_application_id])
            ->andFilterWhere(['like', 'bc2_application_id', $this->bc2_application_id])
            ->andFilterWhere(['like', 'bc1_mobile_number', $this->bc1_mobile_number])
            ->andFilterWhere(['like', 'bc1_mobile_no', $this->bc1_mobile_no])
            ->andFilterWhere(['like', 'block_name', $this->block_name]);

        return $dataProvider;
    }
}
