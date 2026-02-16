<?php

namespace bc\modules\selection\components;

use yii\helpers\ArrayHelper;
use yii\db\Expression;
use bc\modules\selection\models\SrlmBcSelectionApiLog;
use bc\modules\selection\models\SrlmBcSelectionAppDetail;
use bc\modules\selection\models\SrlmBcSelectionUser;
use bc\modules\selection\models\SrlmBcApplication20210902;
use bc\modules\selection\models\SrlmBcApplicationGroupFamily;

class BcdApplication {

    public $sec1 = 0;
    public $sec2 = 0;
    public $sec3 = 0;
    public $sec4 = 0;
    public $sec5 = 0;
    public $over_all = 0;
    public $over_all_per = 0;
    public $reading_skils = [1 => 1, 2 => 3, 3 => 2, 4 => 1];
    public $phone_type = [1 => 5, 2 => 1];
    public $what_else_with_mobile = 0;
    public $vechicle_drive = 0;
    public $immediate_aspiration = 0;
    public $role_in_group = 0;
    public $why_did_you_get_elected = 0;
    public $srlm_bc_application_group_family = 0;
    public $already_group_member = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 2, 10 => 1, 11 => 1, 12 => 0, 13 => 0];
    public $can_read_write_hindi = [1 => 2, 2 => 1, 3 => 0];
    public $confirtable_in_english = [1 => 0, 2 => 0, 3 => 1, 4 => 2, 5 => 3];
    public $recognize_english_hindi = [1 => 2, 2 => 0];
    public $can_add_substract_multiply = [1 => 2, 2 => 1, 3 => 0];
    public $choose_other_meaning1 = [1 => 0, 2 => 0, 3 => 2, 4 => 0, 5 => 0];
    public $choose_other_meaning2 = [1 => 0, 2 => 2, 3 => 0, 4 => 0, 5 => 0];
    public $choose_other_meaning3 = [1 => 2, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
    public $choose_other_meaning4 = [1 => 0, 2 => 0, 3 => 2, 4 => 0, 5 => 0];
    public $choose_other_meaning5 = [1 => 0, 2 => 2, 3 => 0, 4 => 0, 5 => 0];
    public $same_to_same_word1 = [1 => 0, 2 => 2, 3 => 0, 4 => 0, 5 => 0];
    public $same_to_same_word2 = [1 => 0, 2 => 0, 3 => 2, 4 => 0, 5 => 0];
    public $same_to_same_word3 = [1 => 2, 2 => 2, 3 => 0, 4 => 0, 5 => 0];
    public $english_to_hindi1 = [1 => 0, 2 => 0, 3 => 2, 4 => 0, 5 => 0];
    public $english_to_hindi2 = [1 => 0, 2 => 0, 3 => 2, 4 => 0, 5 => 0];
    public $english_to_hindi3 = [1 => 2, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
    public $english_to_hindi4 = [1 => 0, 2 => 0, 3 => 2, 4 => 0, 5 => 0];
    public $english_to_hindi5 = [1 => 0, 2 => 0, 3 => 0, 4 => 2, 5 => 0];
    public $percentage_option1 = [1 => 0, 2 => 0, 3 => 2, 4 => 0, 5 => 0];
    public $percentage_option2 = [1 => 2, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
    public $percentage_option3 = [1 => 0, 2 => 2, 3 => 0, 4 => 0, 5 => 0];
    public $percentage_option4 = [1 => 0, 2 => 0, 3 => 0, 4 => 2, 5 => 0];
    public $percentage_option5 = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 2];
    public $option_decision1 = [1 => 0, 2 => 2, 3 => 0, 4 => 0, 5 => 0];
    public $option_decision2 = [1 => 0, 2 => 0, 3 => 2, 4 => 0, 5 => 0];
    public $option_decision3 = [1 => 0, 2 => 2, 3 => 0, 4 => 0, 5 => 0];
    public $option_decision4 = [1 => 0, 2 => 0, 3 => 0, 4 => 2, 5 => 0];
    public $option_decision5 = [1 => 0, 2 => 0, 3 => 0, 4 => 2, 5 => 0];
    public $mobile_use_experience = [1 => 2, 2 => 1, 3 => 1, 4 => 0, 5 => 2];
    public $whose_mobile_you_using = [1 => 5, 2 => 3, 3 => 3, 4 => 1, 5 => 0];
    public $already_worked = [1 => 1, 2 => 0];
    public $own_mobile = [1 => 2, 2 => 1, 3 => 0];
    public $own_mobile_means = 0;
    public $method_used_for_ledger_account = 0;
    public $need_training = 0;
    public $srlm_bc_application_model;

//    public function __construct($srlm_bc_application_id) {
//        if (($this->srlm_bc_application_model = SrlmBcApplication20210902::findOne($srlm_bc_application_id)) !== null) {
//            
//        }
//    }
//
//    public static function getObject($srlm_bc_application_id) {
//        return new BcApplication($srlm_bc_application_id);
//    }

    public function calculaterating() {
        try {
            $model = $this->srlm_bc_application_model;
//            print_r($model->what_else_with_mobile1);exit;
            if ($model->rating_process_status == 0 and $model->form_number == 6) {
                // sec1 process start
                // आपका शिक्षा/ पढ़ने लिखने की कुशलता
                if ($model->reading_skills) {
                    $model->q1 = isset($this->reading_skils[$model->reading_skills]) ? $this->reading_skils[$model->reading_skills] : 0;
                    $this->sec1 += $model->q1;
                }
                // कौन सा मोबाइल है? 
                if ($model->phone_type) {
                    $model->q2 = isset($this->phone_type[$model->phone_type]) ? $this->phone_type[$model->phone_type] : 0;
                    $this->sec1 += $model->q2;
                }
                // फ़ोन करने के अलावा, मोबाइल से और क्या क्या कर लेते हैं? 
                if ($model->what_else_with_mobile1) {
                    $this->what_else_with_mobile++;
                }
                if ($model->what_else_with_mobile2) {
                    $this->what_else_with_mobile++;
                }
                if ($model->what_else_with_mobile3) {
                    $this->what_else_with_mobile++;
                }

                if ($model->what_else_with_mobile4) {
                    $this->what_else_with_mobile++;
                }
                if ($model->what_else_with_mobile5) {
                    $this->what_else_with_mobile++;
                }
                if ($this->what_else_with_mobile == 1) {
                    $model->q3 = 1;
                    $this->sec1 += $model->q3;
                } elseif ($this->what_else_with_mobile == 2) {
                    $model->q3 = 2;
                    $this->sec1 += $model->q3;
                } elseif ($this->what_else_with_mobile > 2) {
                    $model->q3 = 5;
                    $this->sec1 += $model->q3;
                } else {
                    
                }
                // कोई व्हाट्सएप्प नंबर है? 
                if ($model->whats_app_number) {
                    $model->q4 = 2;
                    $this->sec1 += $model->q4;
                }
                // निम्न में से कौन सा वाहन चलाना आता है?
                if ($model->vechicle_drive1) {
                    $this->vechicle_drive += 3;
                }
                if ($model->vechicle_drive2) {
                    $this->vechicle_drive += 4;
                }
                if ($model->vechicle_drive3) {
                    $this->vechicle_drive += 5;
                }

                if ($model->vechicle_drive5) {
                    $this->vechicle_drive += 5;
                }
                if ($model->vechicle_drive6) {
                    $this->vechicle_drive += 0;
                }
                if ($model->vechicle_drive7) {
                    $this->vechicle_drive += 7.5;
                }
                $model->q5 = $this->vechicle_drive;
                $this->sec1 += $model->q5;
                // घर में कितने सदस्य हैं? बच्चों एवं सदस्यों का आयुवार विवरण?
                if ($model->house_member_details1) {
                    $model->q6 = 0;
                    $this->sec1 += $model->q6;
                }
                if ($model->house_member_details2) {
                    $model->q7 = 2;
                    $this->sec1 += $model->q7;
                }
                if ($model->house_member_details3) {
                    $model->q8 = 5;
                    $this->sec1 += $model->q8;
                }
                // घर में प्रमुख तीन कमी जो आप अपने साधन से पूरा करना चाहती हैं?
                if ($model->immediate_aspiration1) {
                    $this->immediate_aspiration += 2;
                }
                if ($model->immediate_aspiration2) {
                    $this->immediate_aspiration += 2;
                }
                if ($model->immediate_aspiration3) {
                    $this->immediate_aspiration += 2;
                }
                if ($model->immediate_aspiration4) {
                    $this->immediate_aspiration += 5;
                }
                if ($model->immediate_aspiration5) {
                    $this->immediate_aspiration += 5;
                }
                if ($model->immediate_aspiration6) {
                    $this->immediate_aspiration += 5;
                }
                $model->q9 = $this->immediate_aspiration;
                $this->sec1 += $model->q9;

                // sec1 process end
                // sec2 process start
                // अपने समूह के सभी/ ज़्यादातर अन्य (खुद को छोड़कर) सदस्यों के नाम लिखें (कम से कम पांच) – with mobile no.
                $this->srlm_bc_application_group_family = $model->getFamily()->where(['!=', 'srlm_bc_application_group_family.mobile_no', '0000000000'])->count();
                if ($model->already_group_member != 1) {
                    if ($this->srlm_bc_application_group_family >= 5) {
                        $model->q10 = 10;
                        $this->sec2 += $model->q10;
                    } else {
                        $model->q10 = 0;
                        $this->sec2 += $model->q10;
                    }

                    // समूह की स्थापना में किसने/ किन्होंने पहल की थी – सबसे ज़्यादा सहयोग किया? 
                    if ($model->leadership_name) {
                        if ($model->leadership_name == 'स्वयं') {
                            $model->q11 = 3;
                        } else {
                            $model->q11 = 0;
                        }

                        $this->sec2 += $model->q11;
                    }
                    if ($model->role_in_group1) {
                        $this->role_in_group += 0;
                    }
                    if ($model->role_in_group2) {
                        $this->role_in_group += 2;
                    }
                    if ($model->role_in_group3) {
                        $this->role_in_group += 2;
                    }
                    if ($model->role_in_group4) {
                        $this->role_in_group += 5;
                    }
                    if ($model->role_in_group5) {
                        $this->role_in_group += 5;
                    }
                    if ($model->role_in_group6) {
                        $this->role_in_group += 7.5;
                    }
                    if ($model->role_in_group7) {
                        $this->role_in_group += 7.5;
                    }
                    if ($model->role_in_group8) {
                        $this->role_in_group += 7.5;
                    }
                    $model->q12 = $this->role_in_group;
                    $this->sec2 += $model->q12;
                    //क्या आप किसी स्वयं सहायता समूह के सदस्य, पदाधिकारी या कम्युनिटी/ सामुदायिक कैडर हैं
                    if ($model->already_group_member) {
                        $model->q13 = isset($this->already_group_member[$model->already_group_member]) ? $this->already_group_member[$model->already_group_member] : 0;
                        $this->sec2 += $model->q13;
                    }
                    if ($model->why_did_you_get_elected1) {
                        $this->why_did_you_get_elected += 0;
                    }
                    if ($model->why_did_you_get_elected2) {
                        $this->why_did_you_get_elected += 1;
                    }
                    if ($model->why_did_you_get_elected3) {
                        $this->why_did_you_get_elected += 0;
                    }
                    if ($model->why_did_you_get_elected4) {
                        $this->why_did_you_get_elected += 0;
                    }
                    if ($model->why_did_you_get_elected5) {
                        $this->why_did_you_get_elected += 1;
                    }
                    if ($model->why_did_you_get_elected6) {
                        $this->why_did_you_get_elected += 1;
                    }
                    if ($model->why_did_you_get_elected7) {
                        $this->why_did_you_get_elected += 1;
                    }
                    if ($model->why_did_you_get_elected8) {
                        $this->why_did_you_get_elected += 2;
                    }
                    if ($model->why_did_you_get_elected9) {
                        $this->why_did_you_get_elected += 1;
                    }
                    $model->q14 = $this->why_did_you_get_elected;
                    $this->sec2 += $model->q14;

                    if ((($model->active_members_name1 == 'स्वयं' and $model->active_members_name2 == null) || ($model->active_members_name2 == 'स्वयं' and $model->active_members_name1 == null))) {
                        $model->q15 = 3;
                    } elseif (($model->active_members_name1 == 'स्वयं' and $model->active_members_name2 != null) || ($model->active_members_name2 == 'स्वयं' and $model->active_members_name1 != null)) {
                        $model->q15 = 7.5;
                    } else {
                        $model->q15 = 0;
                    }

                    $this->sec2 += $model->q15;

                    if ((($model->belongingness_name1 == 'स्वयं' and $model->belongingness_name2 == null) || ($model->belongingness_name2 == 'स्वयं' and $model->belongingness_name1 == null))) {
                        $model->q16 = 3;
                    } elseif (($model->belongingness_name1 == 'स्वयं' and $model->belongingness_name2 != null) || ($model->belongingness_name2 == 'स्वयं' and $model->belongingness_name1 != null)) {
                        $model->q16 = 7.5;
                    } else {
                        $model->q16 = 0;
                    }

                    $this->sec2 += $model->q16;

                    if ((($model->awareness_name1 == 'स्वयं' and $model->awareness_name2 == null) || ($model->awareness_name2 == 'स्वयं' and $model->awareness_name1 == null))) {
                        $model->q17 = 3;
                    } elseif (($model->awareness_name1 == 'स्वयं' and $model->awareness_name2 != null) || ($model->awareness_name2 == 'स्वयं' and $model->awareness_name1 != null)) {
                        $model->q17 = 7.5;
                    } else {
                        $model->q17 = 0;
                    }

                    $this->sec2 += $model->q17;

                    if ((($model->member_who_contact_in_other_group_name1 == 'स्वयं' and $model->member_who_contact_in_other_group_name2 == null) || ($model->member_who_contact_in_other_group_name2 == 'स्वयं' and $model->member_who_contact_in_other_group_name1 == null))) {
                        $model->q18 = 3;
                    } elseif (($model->member_who_contact_in_other_group_name1 == 'स्वयं' and $model->member_who_contact_in_other_group_name2 != null) || ($model->member_who_contact_in_other_group_name2 == 'स्वयं' and $model->member_who_contact_in_other_group_name1 != null)) {
                        $model->q18 = 7.5;
                    } else {
                        $model->q18 = 0;
                    }

                    $this->sec2 += $model->q18;

                    if ((($model->demanded_group_member_name1 == 'स्वयं' and $model->demanded_group_member_name2 == null) || ($model->demanded_group_member_name2 == 'स्वयं' and $model->demanded_group_member_name1 == null))) {
                        $model->q19 = 3;
                    } elseif (($model->demanded_group_member_name1 == 'स्वयं' and $model->demanded_group_member_name2 != null) || ($model->demanded_group_member_name2 == 'स्वयं' and $model->demanded_group_member_name1 != null)) {
                        $model->q19 = 7.5;
                    } else {
                        $model->q19 = 0;
                    }

                    $this->sec2 += $model->q19;

                    if ($model->capable_fast_pace == 1) {
                        $model->q20 = 2;
                    } else {
                        $model->q20 = 0;
                    }
                    $this->sec2 += $model->q20;
                    if ($model->his_perception3) {
                        $model->q21 = 2;
                    } else {
                        $model->q21 = 0;
                    }
                    $this->sec2 += $model->q21;
                }

                // sec1 process end
                // sect 3 criteria 2 process start
                // आपके समूह गतिविधिओं में सबसे ज़्यादा किसका सहयोग रहता है?
                if ($model->most_contribute_name) {
                    if ($model->most_contribute_name == 'स्वयं') {
                        $model->q22 = 3;
                    } else {
                        $model->q22 = 0;
                    }

                    $this->sec3 += $model->q22;
                }
                // अगर हाँ, तो कौन सबसे ज़्यादा स्वेच्छा से वचत की पैरवी करता है?
                if ($model->entrepreneurial) {
                    if ($model->entrepreneurial == 'स्वयं') {
                        $model->q23 = 3;
                    } else {
                        $model->q23 = 0;
                    }

                    $this->sec3 += $model->q23;
                }
                //  क्या कोई दो सदस्य हैं जो नए अनजान नियमों/ विषयों से नहीं घबराता है? कौन ?

                if ((($model->afraid_unknown_rules1 == 'स्वयं' and $model->afraid_unknown_rules2 == null) || ($model->afraid_unknown_rules2 == 'स्वयं' and $model->afraid_unknown_rules1 == null))) {
                    $model->q24 = 3;
                } elseif (($model->afraid_unknown_rules1 == 'स्वयं' and $model->afraid_unknown_rules2 != null) || ($model->afraid_unknown_rules2 == 'स्वयं' and $model->afraid_unknown_rules1 != null)) {
                    $model->q24 = 5;
                } else {
                    $model->q24 = 0;
                }

                $this->sec3 += $model->q24;

                // समूह के लिए नए उंचाईओं - उद्यमों या व्यवसायों के स्थापना की संकल्पना कीन्हे हैं ?
                if ($model->concept_of_setting_up_new_heights) {
                    if ($model->concept_of_setting_up_new_heights == 'स्वयं') {
                        $model->q25 = 3;
                    } else {
                        $model->q25 = 0;
                    }

                    $this->sec3 += $model->q25;
                }
                //  क्या कोई दो सदस्य दूसरे सदस्य के लिए कोई व्यावसायिक, आजीविका के अवसर की समझ रखता हैं? चर्चा करता है

                if ((($model->livelihood_opportunity_for_another_member1 == 'स्वयं' and $model->livelihood_opportunity_for_another_member2 == null) || ($model->livelihood_opportunity_for_another_member2 == 'स्वयं' and $model->livelihood_opportunity_for_another_member1 == null))) {
                    $model->q26 = 3;
                } elseif (($model->livelihood_opportunity_for_another_member1 == 'स्वयं' and $model->livelihood_opportunity_for_another_member2 != null) || ($model->livelihood_opportunity_for_another_member2 == 'स्वयं' and $model->livelihood_opportunity_for_another_member1 != null)) {
                    $model->q26 = 5;
                } else {
                    $model->q26 = 0;
                }

                $this->sec3 += $model->q26;

                //  किसी व्यावसायिक/ आर्थिक विषय पर, कौन दो सदस्य सबसे अच्छा मोलभाव कर सकता है?

                if ((($model->negotiate_best1 == 'स्वयं' and $model->negotiate_best2 == null) || ($model->negotiate_best2 == 'स्वयं' and $model->negotiate_best1 == null))) {
                    $model->q27 = 3;
                } elseif (($model->negotiate_best1 == 'स्वयं' and $model->negotiate_best2 != null) || ($model->negotiate_best2 == 'स्वयं' and $model->negotiate_best1 != null)) {
                    $model->q27 = 5;
                } else {
                    $model->q27 = 0;
                }


                $this->sec3 += $model->q27;

                //   कौन दो सदस्य समूह के फायदे/ हित को ध्यान में रखकर औरों से बात कर सकता है - समूह के लाभ को सुरक्षित कर सकता है?

                if ((($model->which_member_can_talk_advantages1 == 'स्वयं' and $model->which_member_can_talk_advantages2 == null) || ($model->which_member_can_talk_advantages2 == 'स्वयं' and $model->which_member_can_talk_advantages1 == null))) {
                    $model->q28 = 3;
                } elseif (($model->which_member_can_talk_advantages1 == 'स्वयं' and $model->which_member_can_talk_advantages2 != null) || ($model->which_member_can_talk_advantages2 == 'स्वयं' and $model->which_member_can_talk_advantages1 != null)) {
                    $model->q28 = 5;
                } else {
                    $model->q28 = 0;
                }


                $this->sec3 += $model->q28;

                // sect 3 criteria 2 process end
                // sect 4 criteria 3 process start
                // क्या आप आराम से हिंदी पढ़ और लिख लेते हैं
                if ($model->can_read_write_hindi) {
                    $model->q29 = isset($this->can_read_write_hindi[$model->can_read_write_hindi]) ? $this->can_read_write_hindi[$model->can_read_write_hindi] : 0;
                    $this->sec4 += $model->q29;
                }
                // अंग्रेज़ी पढ़ने लिखने में आप कितना सहज हैं
                if ($model->confirtable_in_english) {
                    $model->q30 = isset($this->confirtable_in_english[$model->confirtable_in_english]) ? $this->confirtable_in_english[$model->confirtable_in_english] : 0;
                    $this->sec4 += $model->q30;
                }
                // क्या आप हिंदी और अंग्रेज़ी में सभी अंक पहचान लेते हैं
                if ($model->recognize_english_hindi) {
                    $model->q31 = isset($this->recognize_english_hindi[$model->recognize_english_hindi]) ? $this->recognize_english_hindi[$model->recognize_english_hindi] : 0;
                    $this->sec4 += $model->q31;
                }
                // क्या आप हिंदी और अंग्रेज़ी में जोड़, घटाव, गुणा, भाग इत्यादि कर लेते हैं
                if ($model->can_add_substract_multiply) {
                    $model->q32 = isset($this->can_add_substract_multiply[$model->can_add_substract_multiply]) ? $this->can_add_substract_multiply[$model->can_add_substract_multiply] : 0;
                    $this->sec4 += $model->q32;
                }
                // कौन सदस्य आपके समूह का खाता बही रखता है या उनका रखरखाव करता है
                if ($model->who_maintain_account) {
                    $model->q33 = 0;
                    $this->sec4 += $model->q33;
                }
                // नीचे दिए गए शब्दों के मतलब का कोई दूसरा शब्द चुनें 
                //मुद्रा
                if ($model->choose_other_meaning1) {
                    $model->q34 = isset($this->choose_other_meaning1[$model->choose_other_meaning1]) ? $this->choose_other_meaning1[$model->choose_other_meaning1] : 0;
                    $this->sec4 += $model->q34;
                }
                // श्रम
                if ($model->choose_other_meaning2) {
                    $model->q35 = isset($this->choose_other_meaning2[$model->choose_other_meaning2]) ? $this->choose_other_meaning2[$model->choose_other_meaning2] : 0;
                    $this->sec4 += $model->q35;
                }
                // व्यय
                if ($model->choose_other_meaning3) {
                    $model->q36 = isset($this->choose_other_meaning3[$model->choose_other_meaning3]) ? $this->choose_other_meaning3[$model->choose_other_meaning3] : 0;
                    $this->sec4 += $model->q36;
                }
                // निवेदन
                if ($model->choose_other_meaning4) {
                    $model->q37 = isset($this->choose_other_meaning4[$model->choose_other_meaning4]) ? $this->choose_other_meaning4[$model->choose_other_meaning4] : 0;
                    $this->sec4 += $model->q37;
                }
                // ऋण
                if ($model->choose_other_meaning5) {
                    $model->q38 = isset($this->choose_other_meaning5[$model->choose_other_meaning5]) ? $this->choose_other_meaning5[$model->choose_other_meaning5] : 0;
                    $this->sec4 += $model->q38;
                }
                // नीचे दिए गए वाक्यों से हूबहू मिलता जुलता कोई दूसरा वाक्य चुनें 
                //वह विश्राम कर रहा है
                if ($model->same_to_same_word1) {
                    $model->q39 = isset($this->same_to_same_word1[$model->same_to_same_word1]) ? $this->same_to_same_word1[$model->same_to_same_word1] : 0;
                    $this->sec4 += $model->q39;
                }
                // रमेश भ्रमण पर गया
                if ($model->same_to_same_word2) {
                    $model->q40 = isset($this->same_to_same_word2[$model->same_to_same_word2]) ? $this->same_to_same_word2[$model->same_to_same_word2] : 0;
                    $this->sec4 += $model->q40;
                }
                // सुनीता को व्यवसाय के लिए धन की आवश्यकता है:
                if ($model->same_to_same_word3) {
                    $model->q41 = isset($this->same_to_same_word3[$model->same_to_same_word3]) ? $this->same_to_same_word3[$model->same_to_same_word3] : 0;
                    $this->sec4 += $model->q41;
                }
                // नीचे दिए गए अंग्रेज़ी वाक्यों का हिंदी मतलब बताएं  
                //My name is Rajesh
                if ($model->english_to_hindi1) {
                    $model->q42 = isset($this->english_to_hindi1[$model->english_to_hindi1]) ? $this->english_to_hindi1[$model->english_to_hindi1] : 0;
                    $this->sec4 += $model->q42;
                }
                // I live in Varanasi.
                if ($model->english_to_hindi2) {
                    $model->q43 = isset($this->english_to_hindi2[$model->english_to_hindi2]) ? $this->english_to_hindi2[$model->english_to_hindi2] : 0;
                    $this->sec4 += $model->q43;
                }
                // I like mangoes and banana.
                if ($model->english_to_hindi3) {
                    $model->q44 = isset($this->english_to_hindi3[$model->english_to_hindi3]) ? $this->english_to_hindi3[$model->english_to_hindi3] : 0;
                    $this->sec4 += $model->q44;
                }
                // I like Red colour.
                if ($model->english_to_hindi4) {
                    $model->q45 = isset($this->english_to_hindi4[$model->english_to_hindi4]) ? $this->english_to_hindi4[$model->english_to_hindi4] : 0;
                    $this->sec4 += $model->q45;
                }
                // I love my family.
                if ($model->english_to_hindi5) {
                    $model->q46 = isset($this->english_to_hindi5[$model->english_to_hindi5]) ? $this->english_to_hindi5[$model->english_to_hindi5] : 0;
                    $this->sec4 += $model->q46;
                }

                // नीचे दिए गए अंक-गणित का जवाब भरें; जोड़, घटाव, गुना-भाग एवं प्रतिशत निकलना 
                //100 रुपये का 20 प्रतिशत कितना हुआ?
                if ($model->percentage_option1) {
                    $model->q47 = isset($this->percentage_option1[$model->percentage_option1]) ? $this->percentage_option1[$model->percentage_option1] : 0;
                    $this->sec4 += $model->q47;
                }
                // 300 रुपये का 30 प्रतिशत कितना हुआ?
                if ($model->percentage_option2) {
                    $model->q48 = isset($this->percentage_option2[$model->percentage_option2]) ? $this->percentage_option2[$model->percentage_option2] : 0;
                    $this->sec4 += $model->q48;
                }
                // 200 रुपये का 45 प्रतिशत कितना हुआ?
                if ($model->percentage_option3) {
                    $model->q49 = isset($this->percentage_option3[$model->percentage_option3]) ? $this->percentage_option3[$model->percentage_option3] : 0;
                    $this->sec4 += $model->q49;
                }
                // 500 रुपये का 5 प्रतिशत कितना हुआ?
                if ($model->percentage_option4) {
                    $model->q50 = isset($this->percentage_option4[$model->percentage_option4]) ? $this->percentage_option4[$model->percentage_option4] : 0;
                    $this->sec4 += $model->q50;
                }
                // 900 रुपये का 4 प्रतिशत कितना हुआ?
                if ($model->percentage_option5) {
                    $model->q51 = isset($this->percentage_option5[$model->percentage_option5]) ? $this->percentage_option5[$model->percentage_option5] : 0;
                    $this->sec4 += $model->q51;
                }
                //  नीचे दिए गए लेखा-बही के हिसाब से, दिए गए विकल्पों पर अपना निर्णय लें - 
                //रामू ने सुरेश से 1,000 रूपए लिए और बनिया का 800 रूपए का उधार चुकाया, तो रामू के पास कितने रुपये शेष बचे?
                if ($model->option_decision1) {
                    $model->q52 = isset($this->option_decision1[$model->option_decision1]) ? $this->option_decision1[$model->option_decision1] : 0;
                    $this->sec4 += $model->q52;
                }
                // एक स्वयं सहायता समूह में 10 सदस्य हैं, अगर सभी सदस्यों ने समूह के लिए 200-200 रूपए जमा किये तो कुल कितने रुपये एकत्रित 
                if ($model->option_decision2) {
                    $model->q53 = isset($this->option_decision2[$model->option_decision2]) ? $this->option_decision2[$model->option_decision2] : 0;
                    $this->sec4 += $model->q53;
                }
                // राजेश ने विमला से 5 प्रतिशत सालाना ब्याज पर 1000 रूपए लिए, दो साल बाद राजेश विमला को कुल कितने रूपए वापस देगा?
                if ($model->option_decision3) {
                    $model->q54 = isset($this->option_decision3[$model->option_decision3]) ? $this->option_decision3[$model->option_decision3] : 0;
                    $this->sec4 += $model->q54;
                }
                // महेश के पास 10,000 रू थे, उसने 500 रू माला को दिए, 400 रू राहुल को दिए, 3000 रू अपनी माँ को दिए, तो अब महेश के पास कुल कितने रूपए शेष बचे?
                if ($model->option_decision4) {
                    $model->q55 = isset($this->option_decision4[$model->option_decision4]) ? $this->option_decision4[$model->option_decision4] : 0;
                    $this->sec4 += $model->q55;
                }
                // रामू 20 रूपए प्रति किलो के हिसाब से 50 किलो आलू लाया और उसे 25 रूपए प्रति किलो के हिसाब से बेच दिया, तो उसे कुल कितना लाभ हुआ?
                if ($model->option_decision5) {
                    $model->q56 = isset($this->option_decision5[$model->option_decision5]) ? $this->option_decision5[$model->option_decision5] : 0;
                    $this->sec4 += $model->q56;
                }

                // sect 4 criteria 3 process end 
                // sec5 criteria 4 process start
                // यहाँ तक आपको मोबाइल ऍप का उपयोग करना कैसा महसूस हुआ?यहाँ तक आपको मोबाइल ऍप का उपयोग करना कैसा महसूस हुआ? 
                if ($model->mobile_use_experience) {
                    $model->q58 = isset($this->mobile_use_experience[$model->mobile_use_experience]) ? $this->mobile_use_experience[$model->mobile_use_experience] : 0;
                    $this->sec5 += $model->q58;
                }
                // आप किनके स्मार्टफोन पर यह ऍप उपयोग कर रहे हैं
                if ($model->whose_mobile_you_using) {
                    $model->q59 = isset($this->whose_mobile_you_using[$model->whose_mobile_you_using]) ? $this->whose_mobile_you_using[$model->whose_mobile_you_using] : 0;
                    $this->sec5 += $model->q59;
                }
                // आपके समूह में कितने सदस्यों के पास स्वयं का स्मार्टफोन है?
                if ($model->no_of_people_using_phone) {
                    if ($model->no_of_people_using_phone <= '2')
                        $model->q60 = 2;
                    if ($model->no_of_people_using_phone > '2')
                        $model->q60 = 5;
                    $this->sec5 += $model->q60;
                }

                //  आपके समूह में कितने सदस्यों के परिवारों में स्मार्टफोन उपलब्ध है, जिनका वे आवश्यकता अनुसार कभी कभी उपयोग कर सकते हैं?
                if ($model->no_of_family_people_using_phone) {
                    if ($model->no_of_family_people_using_phone <= 2)
                        $model->q61 = 2;
                    if ($model->no_of_family_people_using_phone > 2)
                        $model->q61 = 5;
                    $this->sec5 += $model->q61;
                }
                // इस फॉर्म को भरने के लिए आपको किसी और का मदद क्यों लेनी पड़ी?
                // क्या आपने पहले भी कभी ऐसा फॉर्म मोबाइल ऍप पर भरा है 
                if ($model->already_worked) {
                    $model->q64 = isset($this->already_worked[$model->already_worked]) ? $this->already_worked[$model->already_worked] : 0;
                    $this->sec5 += $model->q64;
                }
                //अगर आपका स्वयं का मोबाइल हो, तो क्या आप बिना किसी के मदद के ये फॉर्म भर सकते हैं?  
                if ($model->own_mobile) {
                    $model->q65 = isset($this->own_mobile[$model->own_mobile]) ? $this->own_mobile[$model->own_mobile] : 0;
                    $this->sec5 += $model->q65;
                }
                // स्वयं के पास मोबाइल फ़ोन होने का आपके लिए क्या मायने हैं 
                if ($model->own_mobile_means1) {
                    $this->own_mobile_means += 0;
                }
                if ($model->own_mobile_means2) {
                    $this->own_mobile_means += 0;
                }
                if ($model->own_mobile_means3) {
                    $this->own_mobile_means += 1;
                }
                if ($model->own_mobile_means4) {
                    $this->own_mobile_means += 1;
                }
                if ($model->own_mobile_means5) {
                    $this->own_mobile_means += 2;
                }
                if ($model->own_mobile_means6) {
                    $this->own_mobile_means += 3;
                }
                if ($model->own_mobile_means7) {
                    $this->own_mobile_means += 3;
                }
                if ($model->own_mobile_means8) {
                    $this->own_mobile_means += 4;
                }
                $model->q66 = $this->own_mobile_means;
                $this->sec5 += $model->q66;
                // समूह के बही खाता का रखरखाव के लिए कौन सी पद्धति सही व आसान दोनों है 
                if ($model->method_used_for_ledger_account1) {
                    $this->method_used_for_ledger_account += 0;
                }
                if ($model->method_used_for_ledger_account2) {
                    $this->method_used_for_ledger_account += 0;
                }
                if ($model->method_used_for_ledger_account3) {
                    $this->method_used_for_ledger_account += 1;
                }
                if ($model->method_used_for_ledger_account4) {
                    $this->method_used_for_ledger_account += 1;
                }
                if ($model->method_used_for_ledger_account5) {
                    $this->method_used_for_ledger_account += 2;
                }
                if ($model->method_used_for_ledger_account6) {
                    $this->method_used_for_ledger_account += 1;
                }
                $model->q67 = $this->method_used_for_ledger_account;
                $this->sec5 += $model->q67;
                //  मोबाइल पर कार्य करने के लिए आपको कोई प्रशिक्षण की आवश्यकता है? कितने समय की 
                if ($model->need_training1) {
                    $this->need_training += 2;
                }
                if ($model->need_training2) {
                    $this->need_training += 0;
                }
                if ($model->need_training3) {
                    $this->need_training += 1;
                }
                if ($model->need_training4) {
                    $this->need_training += 2;
                }
                if ($model->need_training5) {
                    $this->need_training += 1;
                }

                $model->q68 = $this->need_training;
                $this->sec5 += $model->q68;
                // sec4 process end
                $model->sec1 = $this->sec1;
                $model->sec2 = $this->sec2;
                $model->sec3 = $this->sec3;
                $model->sec4 = $this->sec4;
                $model->sec5 = $this->sec5;
                $this->over_all += $this->sec1;
                $this->over_all += $this->sec2;
                $this->over_all += $this->sec3;
                $this->over_all += $this->sec4;
                $this->over_all += $this->sec5;
                $model->over_all = $this->over_all;
                $model->rating_process_status = 1;
                $model->update();

                // end section 1
                // sec2 process start
                // end section 2  
            }
        } catch (\Exception $e) {
            print_r($e->getMessage());
            print_r($e->getLine());
        }
        return TRUE;
    }

    public function updatehistory() {
        $bc_model = $this->srlm_bc_application_model;
        $model = SrlmBcApplication20210902::findOne($bc_model->id);
        $condition1 = ['and',
            ['=', 'parent_id', $model->id],
        ];

        \bc\modules\selection\models\SrlmBcApplicationHistory::updateAll([
            'district_code' => $model->district_code,
            'district_name' => $model->district_name,
            'block_code' => $model->block_code,
            'block_name' => $model->block_name,
            'age' => $model->age,
            'reading_skills' => $model->reading_skills,
            'phone_type' => $model->phone_type,
            'what_else_with_mobile1' => $model->what_else_with_mobile1,
            'what_else_with_mobile2' => $model->what_else_with_mobile2,
            'what_else_with_mobile3' => $model->what_else_with_mobile3,
            'what_else_with_mobile4' => $model->what_else_with_mobile4,
            'what_else_with_mobile5' => $model->what_else_with_mobile5,
            'whats_app_number' => $model->whats_app_number,
            'vechicle_drive1' => $model->vechicle_drive1,
            'vechicle_drive2' => $model->vechicle_drive2,
            'vechicle_drive3' => $model->vechicle_drive2,
            'vechicle_drive4' => $model->vechicle_drive2,
            'vechicle_drive5' => $model->vechicle_drive2,
            'vechicle_drive6' => $model->vechicle_drive2,
            'vechicle_drive7' => $model->vechicle_drive2,
            'marital_status' => $model->marital_status,
            'house_member_details1' => $model->house_member_details1,
            'house_member_details2' => $model->house_member_details2,
            'house_member_details3' => $model->house_member_details3,
            'future_scope1' => $model->future_scope1,
            'future_scope2' => $model->future_scope2,
            'future_scope3' => $model->future_scope3,
            'future_scope4' => $model->future_scope4,
            'future_scope5' => $model->future_scope5,
            'future_scope6' => $model->future_scope6,
            'future_scope7' => $model->future_scope7,
            'future_scope8' => $model->future_scope8,
            'future_scope9' => $model->future_scope9,
            'future_scope10' => $model->future_scope10,
            'future_scope11' => $model->future_scope11,
            'future_scope12' => $model->future_scope12,
            'opportunities_for_livelihood1' => $model->opportunities_for_livelihood1,
            'opportunities_for_livelihood2' => $model->opportunities_for_livelihood2,
            'opportunities_for_livelihood3' => $model->opportunities_for_livelihood3,
            'opportunities_for_livelihood4' => $model->opportunities_for_livelihood4,
            'opportunities_for_livelihood5' => $model->opportunities_for_livelihood5,
            'opportunities_for_livelihood6' => $model->opportunities_for_livelihood6,
            'opportunities_for_livelihood7' => $model->opportunities_for_livelihood7,
            'opportunities_for_livelihood8' => $model->opportunities_for_livelihood8,
            'opportunities_for_livelihood9' => $model->opportunities_for_livelihood9,
            'opportunities_for_livelihood10' => $model->opportunities_for_livelihood10,
            'planning_intervention1' => $model->planning_intervention1,
            'planning_intervention2' => $model->planning_intervention2,
            'planning_intervention3' => $model->planning_intervention3,
            'planning_intervention4' => $model->planning_intervention4,
            'planning_intervention5' => $model->planning_intervention5,
            'planning_intervention6' => $model->planning_intervention6,
            'immediate_aspiration1' => $model->immediate_aspiration1,
            'immediate_aspiration2' => $model->immediate_aspiration2,
            'immediate_aspiration3' => $model->immediate_aspiration3,
            'immediate_aspiration4' => $model->immediate_aspiration4,
            'immediate_aspiration5' => $model->immediate_aspiration5,
            'immediate_aspiration6' => $model->immediate_aspiration6,
            'already_group_member' => $model->already_group_member,
            'your_group_name' => $model->your_group_name,
            'which_program_your_group_formed' => $model->which_program_your_group_formed,
            'thought_of_forming_group' => $model->thought_of_forming_group,
            'try_towards_group_formation1' => $model->try_towards_group_formation1,
            'try_towards_group_formation2' => $model->try_towards_group_formation2,
            'try_towards_group_formation3' => $model->try_towards_group_formation3,
            'try_towards_group_formation4' => $model->try_towards_group_formation4,
            'try_towards_group_formation5' => $model->try_towards_group_formation5,
            'try_towards_group_formation6' => $model->try_towards_group_formation6,
            'try_towards_group_formation7' => $model->try_towards_group_formation7,
            'try_towards_group_formation8' => $model->try_towards_group_formation8,
            'leadership_name' => $model->leadership_name,
            'leadership_name_index' => $model->leadership_name_index,
            'role_in_group1' => $model->role_in_group1,
            'role_in_group2' => $model->role_in_group2,
            'role_in_group3' => $model->role_in_group3,
            'role_in_group4' => $model->role_in_group4,
            'role_in_group5' => $model->role_in_group5,
            'role_in_group6' => $model->role_in_group6,
            'role_in_group7' => $model->role_in_group7,
            'role_in_group8' => $model->role_in_group8,
            'why_did_you_get_elected1' => $model->why_did_you_get_elected1,
            'why_did_you_get_elected2' => $model->why_did_you_get_elected2,
            'why_did_you_get_elected3' => $model->why_did_you_get_elected3,
            'why_did_you_get_elected4' => $model->why_did_you_get_elected4,
            'why_did_you_get_elected5' => $model->why_did_you_get_elected5,
            'why_did_you_get_elected6' => $model->why_did_you_get_elected6,
            'why_did_you_get_elected7' => $model->why_did_you_get_elected7,
            'why_did_you_get_elected8' => $model->why_did_you_get_elected8,
            'why_did_you_get_elected9' => $model->why_did_you_get_elected9,
            'if_you_were_a_member_of_a_self_help_group1' => $model->if_you_were_a_member_of_a_self_help_group1,
            'if_you_were_a_member_of_a_self_help_group2' => $model->if_you_were_a_member_of_a_self_help_group2,
            'if_you_were_a_member_of_a_self_help_group3' => $model->if_you_were_a_member_of_a_self_help_group3,
            'if_you_were_a_member_of_a_self_help_group4' => $model->if_you_were_a_member_of_a_self_help_group4,
            'if_you_were_a_member_of_a_self_help_group5' => $model->if_you_were_a_member_of_a_self_help_group5,
            'if_you_were_a_member_of_a_self_help_group6' => $model->if_you_were_a_member_of_a_self_help_group6,
            'if_you_were_a_member_of_a_self_help_group7' => $model->if_you_were_a_member_of_a_self_help_group7,
            'if_you_were_a_member_of_a_self_help_group8' => $model->if_you_were_a_member_of_a_self_help_group8,
            'if_you_were_a_member_of_a_self_help_group9' => $model->if_you_were_a_member_of_a_self_help_group9,
            'active_members_name1' => $model->active_members_name1,
            'active_members_name2' => $model->active_members_name2,
            'active_members_position1' => $model->active_members_position1,
            'active_members_position2' => $model->active_members_position2,
            'belongingness_name1' => $model->belongingness_name1,
            'belongingness_name2' => $model->belongingness_name2,
            'belongingness_position1' => $model->belongingness_position1,
            'belongingness_position2' => $model->belongingness_position2,
            'awareness_name1' => $model->awareness_name1,
            'awareness_name2' => $model->awareness_name2,
            'awareness_position1' => $model->awareness_position1,
            'awareness_position2' => $model->awareness_position2,
            'member_who_contact_in_other_group_name1' => $model->member_who_contact_in_other_group_name1,
            'member_who_contact_in_other_group_name2' => $model->member_who_contact_in_other_group_name2,
            'member_who_contact_in_other_group_position1' => $model->member_who_contact_in_other_group_position1,
            'member_who_contact_in_other_group_position2' => $model->member_who_contact_in_other_group_position2,
            'demanded_group_member_name1' => $model->demanded_group_member_name1,
            'demanded_group_member_name2' => $model->demanded_group_member_name2,
            'demanded_group_member_position1' => $model->demanded_group_member_position1,
            'demanded_group_member_position2' => $model->demanded_group_member_position2,
            'capable_fast_pace' => $model->capable_fast_pace,
            'why_demanded1' => $model->why_demanded1,
            'why_demanded2' => $model->why_demanded2,
            'why_demanded3' => $model->why_demanded3,
            'why_demanded4' => $model->why_demanded4,
            'why_demanded5' => $model->why_demanded5,
            'why_demanded6' => $model->why_demanded6,
            'if_you_have_group_members_what_are_they' => $model->if_you_have_group_members_what_are_they,
            'capable_fast_pace_member_name' => $model->capable_fast_pace_member_name,
            'capable_fast_pace_member_number' => $model->capable_fast_pace_member_number,
            'his_perception1' => $model->his_perception1,
            'his_perception2' => $model->his_perception2,
            'his_perception3' => $model->his_perception3,
            'his_perception3' => $model->his_perception3,
            'his_perception5' => $model->his_perception5,
            'his_perception6' => $model->his_perception6,
            'his_perception7' => $model->his_perception7,
            'his_perception8' => $model->his_perception8,
            'what_could_you_do_if_you_were_in_a_group1' => $model->what_could_you_do_if_you_were_in_a_group1,
            'what_could_you_do_if_you_were_in_a_group2' => $model->what_could_you_do_if_you_were_in_a_group2,
            'what_could_you_do_if_you_were_in_a_group3' => $model->what_could_you_do_if_you_were_in_a_group3,
            'what_could_you_do_if_you_were_in_a_group4' => $model->what_could_you_do_if_you_were_in_a_group4,
            'what_could_you_do_if_you_were_in_a_group5' => $model->what_could_you_do_if_you_were_in_a_group5,
            'what_could_you_do_if_you_were_in_a_group6' => $model->what_could_you_do_if_you_were_in_a_group6,
            'what_could_you_do_if_you_were_in_a_group7' => $model->what_could_you_do_if_you_were_in_a_group7,
            'what_could_you_do_if_you_were_in_a_group8' => $model->what_could_you_do_if_you_were_in_a_group8,
            'what_could_you_do_if_you_were_in_a_group9' => $model->what_could_you_do_if_you_were_in_a_group9,
            'most_contribute_name' => $model->most_contribute_name,
            'most_contribute_index' => $model->most_contribute_index,
            'group_culture' => $model->group_culture,
            'provision_in_the_group_as_voluntary' => $model->provision_in_the_group_as_voluntary,
            'entrepreneurial' => $model->entrepreneurial,
            'entrepreneurial_index' => $model->entrepreneurial_index,
            'economic_status' => $model->economic_status,
            'afraid_unknown_rules1' => $model->afraid_unknown_rules1,
            'afraid_unknown_rules2' => $model->afraid_unknown_rules2,
            'afraid_unknown_rules_index1' => $model->afraid_unknown_rules_index1,
            'afraid_unknown_rules_index2' => $model->afraid_unknown_rules_index2,
            'concept_of_setting_up_new_heights' => $model->concept_of_setting_up_new_heights,
            'concept_of_setting_up_new_heights_index' => $model->concept_of_setting_up_new_heights_index,
            'livelihood_opportunity_for_another_member1' => $model->livelihood_opportunity_for_another_member1,
            'livelihood_opportunity_for_another_member2' => $model->livelihood_opportunity_for_another_member2,
            'livelihood_opportunity_for_another_member_index1' => $model->livelihood_opportunity_for_another_member_index1,
            'livelihood_opportunity_for_another_member_index2' => $model->livelihood_opportunity_for_another_member_index2,
            'negotiate_best1' => $model->negotiate_best1,
            'negotiate_best2' => $model->negotiate_best2,
            'negotiate_best_index1' => $model->negotiate_best_index1,
            'negotiate_best_index2' => $model->negotiate_best_index2,
            'which_member_can_talk_advantages1' => $model->which_member_can_talk_advantages1,
            'which_member_can_talk_advantages2' => $model->which_member_can_talk_advantages2,
            'which_member_can_talk_advantages_index1' => $model->which_member_can_talk_advantages_index1,
            'which_member_can_talk_advantages_index2' => $model->which_member_can_talk_advantages_index2,
            'can_read_write_hindi' => $model->can_read_write_hindi,
            'confirtable_in_english' => $model->confirtable_in_english,
            'recognize_english_hindi' => $model->recognize_english_hindi,
            'can_add_substract_multiply' => $model->can_add_substract_multiply,
            'who_maintain_account' => $model->who_maintain_account,
            'choose_other_meaning1' => $model->choose_other_meaning1,
            'choose_other_meaning2' => $model->choose_other_meaning2,
            'choose_other_meaning3' => $model->choose_other_meaning3,
            'choose_other_meaning4' => $model->choose_other_meaning4,
            'choose_other_meaning5' => $model->choose_other_meaning5,
            'same_to_same_word1' => $model->same_to_same_word1,
            'same_to_same_word2' => $model->same_to_same_word2,
            'same_to_same_word3' => $model->same_to_same_word3,
            'english_to_hindi1' => $model->english_to_hindi1,
            'english_to_hindi2' => $model->english_to_hindi2,
            'english_to_hindi3' => $model->english_to_hindi3,
            'english_to_hindi4' => $model->english_to_hindi4,
            'english_to_hindi5' => $model->english_to_hindi5,
            'percentage_option1' => $model->percentage_option1,
            'percentage_option2' => $model->percentage_option2,
            'percentage_option3' => $model->percentage_option3,
            'percentage_option4' => $model->percentage_option4,
            'percentage_option5' => $model->percentage_option5,
            'option_decision1' => $model->option_decision1,
            'option_decision2' => $model->option_decision2,
            'option_decision3' => $model->option_decision3,
            'option_decision4' => $model->option_decision4,
            'option_decision5' => $model->option_decision5,
            'mobile_use_experience' => $model->mobile_use_experience,
            'whose_mobile_you_using' => $model->whose_mobile_you_using,
            'no_of_people_using_phone' => $model->no_of_people_using_phone,
            'no_of_family_people_using_phone' => $model->no_of_family_people_using_phone,
            'need_help_to_fill_form' => $model->need_help_to_fill_form,
            'already_worked' => $model->already_worked,
            'own_mobile' => $model->own_mobile,
            'own_mobile_means1' => $model->own_mobile_means1,
            'own_mobile_means2' => $model->own_mobile_means2,
            'own_mobile_means3' => $model->own_mobile_means3,
            'own_mobile_means4' => $model->own_mobile_means4,
            'own_mobile_means5' => $model->own_mobile_means5,
            'own_mobile_means6' => $model->own_mobile_means6,
            'own_mobile_means7' => $model->own_mobile_means7,
            'own_mobile_means8' => $model->own_mobile_means8,
            'method_used_for_ledger_account1' => $model->method_used_for_ledger_account1,
            'method_used_for_ledger_account2' => $model->method_used_for_ledger_account2,
            'method_used_for_ledger_account3' => $model->method_used_for_ledger_account3,
            'method_used_for_ledger_account4' => $model->method_used_for_ledger_account4,
            'method_used_for_ledger_account5' => $model->method_used_for_ledger_account5,
            'method_used_for_ledger_account6' => $model->method_used_for_ledger_account6,
            'need_training1' => $model->need_training1,
            'need_training2' => $model->need_training2,
            'need_training3' => $model->need_training3,
            'need_training4' => $model->need_training4,
            'need_training5' => $model->need_training5,
            'sec1' => $model->sec1,
            'sec2' => $model->sec2,
            'sec3' => $model->sec3,
            'sec4' => $model->sec4,
            'sec5' => $model->sec5,
            'over_all' => $model->over_all,
            'over_all_per' => $model->over_all_per,
            'rating_process_status' => $model->rating_process_status,
            'q1' => $model->Q1,
            'q2' => $model->Q2,
            'q3' => $model->Q3,
            'q4' => $model->Q4,
            'q5' => $model->Q5,
            'q6' => $model->Q6,
            'q7' => $model->Q7,
            'q8' => $model->Q8,
            'q9' => $model->Q9,
            'q10' => $model->q10,
            'q11' => $model->q11,
            'q12' => $model->q12,
            'q13' => $model->q13,
            'q14' => $model->q14,
            'q15' => $model->q15,
            'q16' => $model->q16,
            'q17' => $model->q17,
            'q18' => $model->q18,
            'q19' => $model->q19,
            'q20' => $model->q20,
            'q21' => $model->q21,
            'q22' => $model->q22,
            'q23' => $model->q23,
            'q24' => $model->q24,
            'q25' => $model->q25,
            'q26' => $model->q26,
            'q27' => $model->q27,
            'q28' => $model->q28,
            'q29' => $model->q29,
            'q30' => $model->q30,
            'q31' => $model->q31,
            'q32' => $model->q32,
            'q33' => $model->q33,
            'q34' => $model->q34,
            'q35' => $model->q35,
            'q36' => $model->q36,
            'q37' => $model->q37,
            'q38' => $model->q38,
            'q39' => $model->q39,
            'q40' => $model->q40,
            'q41' => $model->q41,
            'q42' => $model->q42,
            'q43' => $model->q43,
            'q44' => $model->q44,
            'q45' => $model->q45,
            'q46' => $model->q46,
            'q47' => $model->q47,
            'q48' => $model->q48,
            'q49' => $model->q49,
            'q50' => $model->q50,
            'q51' => $model->q51,
            'q52' => $model->q52,
            'q53' => $model->q53,
            'q54' => $model->q54,
            'q55' => $model->q55,
            'q56' => $model->q56,
            'q57' => $model->q57,
            'q58' => $model->q58,
            'q59' => $model->q59,
            'q60' => $model->q60,
            'q61' => $model->q61,
            'q62' => $model->q62,
            'q63' => $model->q63,
            'q64' => $model->q64,
            'q65' => $model->q65,
            'q66' => $model->q66,
            'q67' => $model->q67,
            'q68' => $model->q68,
            'form_status' => $model->form_status,
                ], $condition1);
    }

    public function updateuser() {
        $bc_model = $this->srlm_bc_application_model;
        $model = SrlmBcApplication20210902::findOne($bc_model->id);
        $data_array = [
            'form_uuid' => $model->form_uuid,
            'first_name' => $model->first_name,
            'middle_name' => $model->middle_name,
            'sur_name' => $model->sur_name,
            'gender' => $model->gender,
            'age' => $model->age,
            'cast' => $model->cast,
            'district_name' => $model->district_name,
            'block_name' => $model->block_name,
            'gram_panchayat_name' => $model->gram_panchayat_name,
            'village_name' => $model->village_name,
            'hamlet' => $model->hamlet,
            'district_code' => $model->district_code,
            'block_code' => $model->block_code,
            'gram_panchayat_code' => $model->gram_panchayat_code,
            'village_code' => $model->village_code,
            'aadhar_number' => $model->aadhar_number,
            'guardian_name' => $model->guardian_name,
            'reading_skills' => $model->reading_skills,
            'mobile_number' => $model->mobile_number,
            'phone_type' => $model->phone_type,
            'what_else_with_mobile1' => $model->what_else_with_mobile1,
            'what_else_with_mobile2' => $model->what_else_with_mobile2,
            'what_else_with_mobile3' => $model->what_else_with_mobile3,
            'what_else_with_mobile4' => $model->what_else_with_mobile4,
            'what_else_with_mobile5' => $model->what_else_with_mobile5,
            'whats_app_number' => $model->whats_app_number,
            'vechicle_drive1' => $model->vechicle_drive1,
            'vechicle_drive2' => $model->vechicle_drive2,
            'vechicle_drive3' => $model->vechicle_drive2,
            'vechicle_drive4' => $model->vechicle_drive2,
            'vechicle_drive5' => $model->vechicle_drive2,
            'vechicle_drive6' => $model->vechicle_drive2,
            'vechicle_drive7' => $model->vechicle_drive2,
            'marital_status' => $model->marital_status,
            'house_member_details1' => $model->house_member_details1,
            'house_member_details2' => $model->house_member_details2,
            'house_member_details3' => $model->house_member_details3,
            'future_scope1' => $model->future_scope1,
            'future_scope2' => $model->future_scope2,
            'future_scope3' => $model->future_scope3,
            'future_scope4' => $model->future_scope4,
            'future_scope5' => $model->future_scope5,
            'future_scope6' => $model->future_scope6,
            'future_scope7' => $model->future_scope7,
            'future_scope8' => $model->future_scope8,
            'future_scope9' => $model->future_scope9,
            'future_scope10' => $model->future_scope10,
            'future_scope11' => $model->future_scope11,
            'future_scope12' => $model->future_scope12,
            'opportunities_for_livelihood1' => $model->opportunities_for_livelihood1,
            'opportunities_for_livelihood2' => $model->opportunities_for_livelihood2,
            'opportunities_for_livelihood3' => $model->opportunities_for_livelihood3,
            'opportunities_for_livelihood4' => $model->opportunities_for_livelihood4,
            'opportunities_for_livelihood5' => $model->opportunities_for_livelihood5,
            'opportunities_for_livelihood6' => $model->opportunities_for_livelihood6,
            'opportunities_for_livelihood7' => $model->opportunities_for_livelihood7,
            'opportunities_for_livelihood8' => $model->opportunities_for_livelihood8,
            'opportunities_for_livelihood9' => $model->opportunities_for_livelihood9,
            'opportunities_for_livelihood10' => $model->opportunities_for_livelihood10,
            'other_occupation' => $model->other_occupation,
            'planning_intervention1' => $model->planning_intervention1,
            'planning_intervention2' => $model->planning_intervention2,
            'planning_intervention3' => $model->planning_intervention3,
            'planning_intervention4' => $model->planning_intervention4,
            'planning_intervention5' => $model->planning_intervention5,
            'planning_intervention6' => $model->planning_intervention6,
            'immediate_aspiration1' => $model->immediate_aspiration1,
            'immediate_aspiration2' => $model->immediate_aspiration2,
            'immediate_aspiration3' => $model->immediate_aspiration3,
            'immediate_aspiration4' => $model->immediate_aspiration4,
            'immediate_aspiration5' => $model->immediate_aspiration5,
            'immediate_aspiration6' => $model->immediate_aspiration6,
            'already_group_member' => $model->already_group_member,
            'your_group_name' => $model->your_group_name,
            'which_program_your_group_formed' => $model->which_program_your_group_formed,
            'thought_of_forming_group' => $model->thought_of_forming_group,
            'try_towards_group_formation1' => $model->try_towards_group_formation1,
            'try_towards_group_formation2' => $model->try_towards_group_formation2,
            'try_towards_group_formation3' => $model->try_towards_group_formation3,
            'try_towards_group_formation4' => $model->try_towards_group_formation4,
            'try_towards_group_formation5' => $model->try_towards_group_formation5,
            'try_towards_group_formation6' => $model->try_towards_group_formation6,
            'try_towards_group_formation7' => $model->try_towards_group_formation7,
            'try_towards_group_formation8' => $model->try_towards_group_formation8,
            'groupInformation' => [],
            'leadership_name_index' => $model->leadership_name_index,
            'leadership_name' => $model->leadership_name,
            'role_in_group1' => $model->role_in_group1,
            'role_in_group2' => $model->role_in_group2,
            'role_in_group3' => $model->role_in_group3,
            'role_in_group4' => $model->role_in_group4,
            'role_in_group5' => $model->role_in_group5,
            'role_in_group6' => $model->role_in_group6,
            'role_in_group7' => $model->role_in_group7,
            'role_in_group8' => $model->role_in_group8,
            'why_did_you_get_elected1' => $model->why_did_you_get_elected1,
            'why_did_you_get_elected2' => $model->why_did_you_get_elected2,
            'why_did_you_get_elected3' => $model->why_did_you_get_elected3,
            'why_did_you_get_elected4' => $model->why_did_you_get_elected4,
            'why_did_you_get_elected5' => $model->why_did_you_get_elected5,
            'why_did_you_get_elected6' => $model->why_did_you_get_elected6,
            'why_did_you_get_elected7' => $model->why_did_you_get_elected7,
            'why_did_you_get_elected8' => $model->why_did_you_get_elected8,
            'why_did_you_get_elected9' => $model->why_did_you_get_elected9,
            'if_you_were_a_member_of_a_self_help_group1' => $model->if_you_were_a_member_of_a_self_help_group1,
            'if_you_were_a_member_of_a_self_help_group2' => $model->if_you_were_a_member_of_a_self_help_group2,
            'if_you_were_a_member_of_a_self_help_group3' => $model->if_you_were_a_member_of_a_self_help_group3,
            'if_you_were_a_member_of_a_self_help_group4' => $model->if_you_were_a_member_of_a_self_help_group4,
            'if_you_were_a_member_of_a_self_help_group5' => $model->if_you_were_a_member_of_a_self_help_group5,
            'if_you_were_a_member_of_a_self_help_group6' => $model->if_you_were_a_member_of_a_self_help_group6,
            'if_you_were_a_member_of_a_self_help_group7' => $model->if_you_were_a_member_of_a_self_help_group7,
            'if_you_were_a_member_of_a_self_help_group8' => $model->if_you_were_a_member_of_a_self_help_group8,
            'if_you_were_a_member_of_a_self_help_group9' => $model->if_you_were_a_member_of_a_self_help_group9,
            'active_members_name1' => $model->active_members_name1,
            'active_members_name2' => $model->active_members_name2,
            'active_members_position1' => $model->active_members_position1,
            'active_members_position2' => $model->active_members_position2,
            'belongingness_name1' => $model->belongingness_name1,
            'belongingness_name2' => $model->belongingness_name2,
            'belongingness_position1' => $model->belongingness_position1,
            'belongingness_position2' => $model->belongingness_position1,
            'awareness_name1' => $model->awareness_name1,
            'awareness_name2' => $model->awareness_name2,
            'awareness_position1' => $model->awareness_position1,
            'awareness_position2' => $model->awareness_position2,
            'member_who_contact_in_other_group_name1' => $model->member_who_contact_in_other_group_name1,
            'member_who_contact_in_other_group_name2' => $model->member_who_contact_in_other_group_name2,
            'member_who_contact_in_other_group_position1' => $model->member_who_contact_in_other_group_position1,
            'member_who_contact_in_other_group_position2' => $model->member_who_contact_in_other_group_position2,
            'demanded_group_member_name1' => $model->demanded_group_member_name1,
            'demanded_group_member_name2' => $model->demanded_group_member_name2,
            'demanded_group_member_position1' => $model->demanded_group_member_position1,
            'demanded_group_member_position2' => $model->demanded_group_member_position2,
            'capable_fast_pace' => $model->capable_fast_pace,
            'why_demanded1' => $model->why_demanded1,
            'why_demanded2' => $model->why_demanded2,
            'why_demanded3' => $model->why_demanded3,
            'why_demanded4' => $model->why_demanded4,
            'why_demanded5' => $model->why_demanded5,
            'why_demanded6' => $model->why_demanded6,
            'if_you_have_group_members_what_are_they' => $model->if_you_have_group_members_what_are_they,
            'capable_fast_pace_member_name' => $model->capable_fast_pace_member_name,
            'capable_fast_pace_member_number' => $model->capable_fast_pace_member_number,
            'his_perception1' => $model->his_perception1,
            'his_perception2' => $model->his_perception2,
            'his_perception3' => $model->his_perception3,
            'his_perception3' => $model->his_perception3,
            'his_perception5' => $model->his_perception5,
            'his_perception6' => $model->his_perception6,
            'his_perception7' => $model->his_perception7,
            'his_perception8' => $model->his_perception8,
            'what_could_you_do_if_you_were_in_a_group1' => $model->what_could_you_do_if_you_were_in_a_group1,
            'what_could_you_do_if_you_were_in_a_group2' => $model->what_could_you_do_if_you_were_in_a_group2,
            'what_could_you_do_if_you_were_in_a_group3' => $model->what_could_you_do_if_you_were_in_a_group3,
            'what_could_you_do_if_you_were_in_a_group4' => $model->what_could_you_do_if_you_were_in_a_group4,
            'what_could_you_do_if_you_were_in_a_group5' => $model->what_could_you_do_if_you_were_in_a_group5,
            'what_could_you_do_if_you_were_in_a_group6' => $model->what_could_you_do_if_you_were_in_a_group6,
            'what_could_you_do_if_you_were_in_a_group7' => $model->what_could_you_do_if_you_were_in_a_group7,
            'what_could_you_do_if_you_were_in_a_group8' => $model->what_could_you_do_if_you_were_in_a_group8,
            'what_could_you_do_if_you_were_in_a_group9' => $model->what_could_you_do_if_you_were_in_a_group9,
            'most_contribute_index' => $model->most_contribute_index,
            'most_contribute_name' => $model->most_contribute_name,
            'group_culture' => $model->group_culture,
            'provision_in_the_group_as_voluntary' => $model->provision_in_the_group_as_voluntary,
            'entrepreneurial_index' => $model->entrepreneurial_index,
            'entrepreneurial' => $model->entrepreneurial,
            'economic_status' => $model->economic_status,
            'afraid_unknown_rules_index1' => $model->afraid_unknown_rules_index1,
            'afraid_unknown_rules1' => $model->afraid_unknown_rules1,
            'afraid_unknown_rules_index2' => $model->afraid_unknown_rules_index2,
            'afraid_unknown_rules2' => $model->afraid_unknown_rules2,
            'concept_of_setting_up_new_heights_index' => $model->concept_of_setting_up_new_heights_index,
            'concept_of_setting_up_new_heights' => $model->concept_of_setting_up_new_heights,
            'livelihood_opportunity_for_another_member_index1' => $model->livelihood_opportunity_for_another_member_index1,
            'livelihood_opportunity_for_another_member1' => $model->livelihood_opportunity_for_another_member1,
            'livelihood_opportunity_for_another_member_index2' => $model->livelihood_opportunity_for_another_member_index2,
            'livelihood_opportunity_for_another_member2' => $model->livelihood_opportunity_for_another_member2,
            'negotiate_best_index1' => $model->negotiate_best_index1,
            'negotiate_best1' => $model->negotiate_best1,
            'negotiate_best_index2' => $model->negotiate_best_index2,
            'negotiate_best2' => $model->negotiate_best2,
            'which_member_can_talk_advantages_index1' => $model->which_member_can_talk_advantages_index1,
            'which_member_can_talk_advantages1' => $model->which_member_can_talk_advantages1,
            'which_member_can_talk_advantages_index2' => $model->which_member_can_talk_advantages_index2,
            'which_member_can_talk_advantages2' => $model->which_member_can_talk_advantages2,
            'can_read_write_hindi' => $model->can_read_write_hindi,
            'confirtable_in_english' => $model->confirtable_in_english,
            'recognize_english_hindi' => $model->recognize_english_hindi,
            'can_add_substract_multiply' => $model->can_add_substract_multiply,
            'who_maintain_account_index' => $model->who_maintain_account_index,
            'who_maintain_account' => $model->who_maintain_account,
            'choose_other_meaning1' => $model->choose_other_meaning1,
            'choose_other_meaning2' => $model->choose_other_meaning2,
            'choose_other_meaning3' => $model->choose_other_meaning3,
            'choose_other_meaning4' => $model->choose_other_meaning4,
            'choose_other_meaning5' => $model->choose_other_meaning5,
            'same_to_same_word1' => $model->same_to_same_word1,
            'same_to_same_word2' => $model->same_to_same_word2,
            'same_to_same_word3' => $model->same_to_same_word3,
            'english_to_hindi1' => $model->english_to_hindi1,
            'english_to_hindi2' => $model->english_to_hindi2,
            'english_to_hindi3' => $model->english_to_hindi3,
            'english_to_hindi4' => $model->english_to_hindi4,
            'english_to_hindi5' => $model->english_to_hindi5,
            'percentage_option1' => $model->percentage_option1,
            'percentage_option2' => $model->percentage_option2,
            'percentage_option3' => $model->percentage_option3,
            'percentage_option4' => $model->percentage_option4,
            'percentage_option5' => $model->percentage_option5,
            'option_decision1' => $model->option_decision1,
            'option_decision2' => $model->option_decision2,
            'option_decision3' => $model->option_decision3,
            'option_decision4' => $model->option_decision4,
            'option_decision5' => $model->option_decision5,
            'mobile_use_experience' => $model->mobile_use_experience,
            'whose_mobile_you_using' => $model->whose_mobile_you_using,
            'no_of_people_using_phone' => $model->no_of_people_using_phone,
            'no_of_family_people_using_phone' => $model->no_of_family_people_using_phone,
            'need_help_to_fill_form' => $model->need_help_to_fill_form,
            'already_worked' => $model->already_worked,
            'own_mobile' => $model->own_mobile,
            'own_mobile_means1' => $model->own_mobile_means1,
            'own_mobile_means2' => $model->own_mobile_means2,
            'own_mobile_means3' => $model->own_mobile_means3,
            'own_mobile_means4' => $model->own_mobile_means4,
            'own_mobile_means5' => $model->own_mobile_means5,
            'own_mobile_means6' => $model->own_mobile_means6,
            'own_mobile_means7' => $model->own_mobile_means7,
            'own_mobile_means8' => $model->own_mobile_means8,
            'method_used_for_ledger_account1' => $model->method_used_for_ledger_account1,
            'method_used_for_ledger_account2' => $model->method_used_for_ledger_account2,
            'method_used_for_ledger_account3' => $model->method_used_for_ledger_account3,
            'method_used_for_ledger_account4' => $model->method_used_for_ledger_account4,
            'method_used_for_ledger_account5' => $model->method_used_for_ledger_account5,
            'method_used_for_ledger_account6' => $model->method_used_for_ledger_account6,
            'need_training1' => $model->need_training1,
            'need_training2' => $model->need_training2,
            'need_training3' => $model->need_training3,
            'need_training4' => $model->need_training4,
            'need_training5' => $model->need_training5,
            'form_start_date' => $model->form_start_date,
            'form_number' => $model->form_number,
            'gps' => $model->gps,
            'gps_accuracy' => $model->gps_accuracy
        ];
        $family_group = SrlmBcApplicationGroupFamily::find()->select(['form_uuid', 'family_uuid', 'member_name', 'position', 'mobile_no'])->where(['srlm_bc_application_id' => $model->id])->asArray()->all();
        if (isset($family_group)) {
            $data_array['groupInformation'] = $family_group;
        }
        $condition1 = ['and',
            ['=', 'id', $model->srlm_bc_selection_user_id],
        ];
        $form_json = json_encode($data_array);
        SrlmBcSelectionUser::updateAll([
            'form_json' => $form_json,
                ], $condition1);
    }

}
