<?php

namespace common\components;

use yii\helpers\ArrayHelper;
use yii\db\Expression;
use common\models\User;
use common\models\master\MasterRole;

class BaseSurvey {

    use \common\traits\Signature;

    public $action_type;
    public $sum;

    const AREA_RURAL = 1;
    const AREA_URBAN = 2;
    const STATUS_SCRAP_BY_CALLCENTER = -1;
    const STATUS_SCRAP_BY_GP = -2;
    const STATUS_SCRAP_BY_BDO = -3;
    const STATUS_SCRAP_BY_CDO = -4;
    const STATUS_SUBMIT = 1;
    const STATUS_SEC1 = 11;
    const STATUS_SEC2 = 12;
    const STATUS_SEC3 = 13;
    const STATUS_SEC4 = 14;
    const STATUS_RETURN_BY_GP = 22;  // Not Use
    const STATUS_ELIGIBLE_BY_BDO = 33;
    const STATUS_NOTELIGLE_BY_BDO = 34;
    const STATUS_RETURN_BY_BDO = 32;
    const STATUS_ELIGIBLE_BY_CDO = 43;  // Not Use
    const STATUS_NOTELIGLE_BY_CDO = 44;  // Not Use
    const STATUS_RETURN_BY_CDO = 42;     // Not Use
    const STATUS_ELIGIBLE_BY_CALLCENTER = 3; // Not Use
    const STATUS_NOTELIGLE_BY_CALLCENTER = 4; // Not Use
    const STATUS_RETURN_BY_CALLCENTER = 2;
    const STATUS_APPLICATION_RECEIVED = 5;
    const RETURN_BDO_YES = 1;
    const SUBMITTED_DSO_YES = 1;
    const SUBMITTED_DSO_NO = 0;
    const ACTION_TYPE_CSO_VERIFICATION = 70;
    const ACTION_TYPE_DIGITAL_VERIFICATION = 100;
    const ACTION_TYPE_PHISICAL_VERIFICATION = 101;
    const ACTION_TYPE_PHISICAL_RETURN = 102;

    public $base_model;
    public $notification;
    public $mail_subject;
    public $mail_message;
    public $regards;

    public function __construct($id) {
        if (($this->base_model = \common\models\dynamicdb\ultrapoor\nfsa\NfsaBaseSurvey::findOne($id)) !== null) {
            
        }
    }

    public static function getObject($id) {
        return new BaseSurvey($id);
    }

    public function checkAccess($user_id, $action) {
        
    }

    public function todoAfterSubmit() {
        
    }

    public function getdetail() {
        $array = [];
        $relation = \common\models\RelationUserGramPanchayat::find()->where(['user_id' => \Yii::$app->user->identity->id, 'status' => 1])->all();
        if (in_array(\Yii::$app->user->identity->id, [328362, 328363, 328364])) {
            $array['data']['village_list'] = \common\models\master\MasterVillage::find()->select(['village_code', 'village_name', 'gram_panchayat_code', 'gram_panchayat_name', 'block_code', 'block_name', 'district_code', 'district_name'])->where(['gram_panchayat_code' => ArrayHelper::getColumn($relation, 'gram_panchayat_code'), 'village_code' => '183105'])->asArray()->all();
        } else {
            $array['data']['village_list'] = \common\models\master\MasterVillage::find()->select(['village_code', 'village_name', 'gram_panchayat_code', 'gram_panchayat_name', 'block_code', 'block_name', 'district_code', 'district_name'])->where(['gram_panchayat_code' => ArrayHelper::getColumn($relation, 'gram_panchayat_code')])->asArray()->all();
        }
        $array['data']['gp_list'] = \common\models\master\MasterGramPanchayat::find()->select(['gram_panchayat_code', 'gram_panchayat_name', 'block_code', 'block_name', 'district_code', 'district_name'])->where(['gram_panchayat_code' => ArrayHelper::getColumn($relation, 'gram_panchayat_code')])->asArray()->all();
        $array['data']['block_list'] = \common\models\master\MasterBlock::find()->select(['block_code', 'block_name', 'district_code', 'district_name'])->where(['block_code' => ArrayHelper::getColumn($relation, 'block_code')])->asArray()->all();
        $array['data']['district_list'] = \common\models\master\MasterDistrict::find()->select(['district_code', 'district_name'])->where(['district_code' => ArrayHelper::getColumn($relation, 'district.district_code')])->asArray()->all();
        $array['data']['types_of_respondents_option'] = ArrayHelper::map(\common\models\dynamicdb\ultrapoor\nfsa\NfsaMasterRespondents::find()->where(['status' => 1])->orderBy('rorder asc')->all(), 'id', 'hindi_name');
        $array['data']['animal_use_option'] = ArrayHelper::map(\common\models\dynamicdb\ultrapoor\nfsa\NfsaMasterAnimalUses::find()->where(['status' => 1])->all(), 'id', 'hindi_name');
        $array['data']['get_pension_option'] = ArrayHelper::map(\common\models\dynamicdb\ultrapoor\nfsa\NfsaMasterPensionType::find()->where(['status' => 1])->all(), 'id', 'hindi_name');
        $array['data']['profit_received_in_the_last_2_years_option'] = ArrayHelper::map(\common\models\dynamicdb\ultrapoor\nfsa\NfsaMasterPaymentRecived2years::find()->where(['status' => 1])->all(), 'id', 'hindi_name');
        $array['data']['category_option'] = ArrayHelper::map(\common\models\dynamicdb\ultrapoor\nfsa\NfsaMasterCategory::find()->where(['status' => 1])->all(), 'id', 'hindi_name');
        $array['data']['gender_option'] = ArrayHelper::map(\common\models\dynamicdb\ultrapoor\nfsa\NfsaMasterGender::find()->where(['status' => 1])->all(), 'id', 'hindi_name');
        $array['data']['occupation_option'] = ArrayHelper::map(\common\models\dynamicdb\ultrapoor\nfsa\NfsaMasterOccupation::find()->where(['status' => 1])->all(), 'id', 'hindi_name');

        $array['data']['yes_no_option'] = ArrayHelper::map(\common\models\dynamicdb\ultrapoor\nfsa\NfsaMasterYesno::find()->where(['status' => 1])->all(), 'id', 'hindi_name');

        $array['data']['residence_option'] = ArrayHelper::map(\common\models\dynamicdb\ultrapoor\nfsa\NfsaMasterResidence::find()->where(['status' => 1])->all(), 'id', 'hindi_name');
        $array['data']['ration_card_type_option'] = [1 => 'पीला (बीपीएल)', 2 => 'लाल (अंत्योदय)', 3 => 'सफ़ेद (एपीएल)'];
        $array['data']['narega_day_work_option'] = ArrayHelper::map(\common\models\dynamicdb\ultrapoor\nfsa\NfsaMasterDayWork::find()->where(['status' => 1])->all(), 'id', 'hindi_name');
        $array['data']['payments_received_option'] = ArrayHelper::map(\common\models\dynamicdb\ultrapoor\nfsa\NfsaMasterPaymentRecived::find()->where(['status' => 1])->all(), 'id', 'hindi_name');
        $array['data']['type_of_asset_house2_option'] = ArrayHelper::map(\common\models\dynamicdb\ultrapoor\nfsa\NfsaMasterHouseType::find()->where(['status' => 1])->all(), 'id', 'hindi_name');
        $array['data']['type_of_asset_house1_option'] = ArrayHelper::map(\common\models\dynamicdb\ultrapoor\nfsa\NfsaMasterHouse::find()->where(['status' => 1])->all(), 'id', 'hindi_name');
        $array['data']['type_of_asset_land_option'] = ArrayHelper::map(\common\models\dynamicdb\ultrapoor\nfsa\NfsaMasterLand::find()->where(['status' => 1])->all(), 'id', 'hindi_name');
        $array['data']['external_hygiene_status_option'] = ArrayHelper::map(\common\models\dynamicdb\ultrapoor\nfsa\NfsaMasterExternalHygiene::find()->where(['status' => 1])->all(), 'id', 'hindi_name');

        $array['data']['mechanized_equipment_option'] = ArrayHelper::map(\common\models\dynamicdb\ultrapoor\nfsa\NfsaMasterYesno::find()->where(['status' => 1])->all(), 'id', 'hindi_name');
        $array['data']['mechanized_vehicle_option'] = ArrayHelper::map(\common\models\dynamicdb\ultrapoor\nfsa\NfsaMasterYesno::find()->where(['status' => 1])->all(), 'id', 'hindi_name');

        $array['data']['form_id'] = $this->base_model->id;
        $array['data']['area'] = $this->base_model->area;
        $array['data']['photo_of_eligible_household'] = $this->base_model->photo_of_eligible_household != NULL ? $this->base_model->image_photo_of_eligible_household : '';
        $array['data']['passbook_photo'] = $this->base_model->passbook_photo != NULL ? $this->base_model->image_passbook_photo : '';
        $array['data']['aadhar_card_front'] = $this->base_model->aadhar_card_front != NULL ? $this->base_model->image_aadhar_card_front : '';
        $array['data']['aadhar_card_back'] = $this->base_model->aadhar_card_back != NULL ? $this->base_model->image_aadhar_card_back : '';
        //$array['data']['photo_family'] = $this->base_model->photo_family != NULL ? $this->base_model->image_photo_family : '';
        $array['data']['house_photo_full_frame'] = $this->base_model->house_photo_full_frame != NULL ? $this->base_model->image_house_photo_full : '';
        $array['data']['aadhaar_card_number_of_head'] = $this->base_model->aadhaar_card_number_of_head;
        $array['data']['types_of_respondents1'] = $this->base_model->types_of_respondents1;
        $array['data']['types_of_respondents2'] = $this->base_model->types_of_respondents2;
        $array['data']['types_of_respondents3'] = $this->base_model->types_of_respondents3;
        $array['data']['types_of_respondents4'] = $this->base_model->types_of_respondents4;
        $array['data']['types_of_respondents5'] = $this->base_model->types_of_respondents5;
        $array['data']['types_of_respondents6'] = $this->base_model->types_of_respondents6;
        $array['data']['types_of_respondents7'] = $this->base_model->types_of_respondents7;
        $array['data']['types_of_respondents8'] = $this->base_model->types_of_respondents8;
        $array['data']['types_of_respondents9'] = $this->base_model->types_of_respondents9;
        $array['data']['types_of_respondents10'] = $this->base_model->types_of_respondents10;
        $array['data']['types_of_respondents11'] = $this->base_model->types_of_respondents11;
        $array['data']['types_of_respondents12'] = $this->base_model->types_of_respondents12;
        $array['data']['types_of_respondents13'] = $this->base_model->types_of_respondents13;
        $array['data']['types_of_respondents14'] = $this->base_model->types_of_respondents14;
        $array['data']['residence'] = $this->base_model->residence;
        $array['data']['ration_card'] = $this->base_model->ration_card;
        $array['data']['ration_card_type'] = $this->base_model->ration_card_type;
        $array['data']['food_program_mid_day_meal'] = $this->base_model->food_program_mid_day_meal;
        $array['data']['food_program_icd_services'] = $this->base_model->food_program_icd_services;
        $array['data']['ess_nrega_job_card'] = $this->base_model->ess_nrega_job_card;
        $array['data']['ess_nrega_demand_application'] = $this->base_model->ess_nrega_demand_application;
        $array['data']['narega_day_work'] = $this->base_model->narega_day_work;
        $array['data']['payments_received'] = $this->base_model->payments_received;
        $array['data']['get_pension_yes_no'] = $this->base_model->get_pension_yes_no;
        $array['data']['get_pension'] = $this->base_model->get_pension;
        $array['data']['profit_received_in_the_last_2_years'] = $this->base_model->profit_received_in_the_last_2_years;
        $array['data']['ayushman_india'] = $this->base_model->ayushman_india;
        $array['data']['type_of_asset_house1'] = $this->base_model->type_of_asset_house1;
        $array['data']['type_of_asset_house2'] = $this->base_model->type_of_asset_house2;
        $array['data']['type_of_asset_land'] = $this->base_model->type_of_asset_land;
        $array['data']['small_animals_numbers'] = $this->base_model->small_animals_numbers;
        $array['data']['small_animals_use1'] = $this->base_model->small_animals_use1;
        $array['data']['small_animals_use2'] = $this->base_model->small_animals_use2;
        $array['data']['small_animals_use3'] = $this->base_model->small_animals_use3;
        $array['data']['small_animals_use4'] = $this->base_model->small_animals_use4;
        $array['data']['big_animals_numbers'] = $this->base_model->big_animals_numbers;
        $array['data']['big_animals_use1'] = $this->base_model->big_animals_use1;
        $array['data']['big_animals_use2'] = $this->base_model->big_animals_use2;
        $array['data']['big_animals_use3'] = $this->base_model->big_animals_use3;
        $array['data']['big_animals_use4'] = $this->base_model->big_animals_use4;
        $array['data']['birds_animals_numbers'] = $this->base_model->birds_animals_numbers;
        $array['data']['birds_animals_use1'] = $this->base_model->birds_animals_use1;
        $array['data']['birds_animals_use2'] = $this->base_model->birds_animals_use2;
        $array['data']['birds_animals_use3'] = $this->base_model->birds_animals_use3;
        $array['data']['birds_animals_use4'] = $this->base_model->birds_animals_use4;
        $array['data']['mechanized_equipment'] = $this->base_model->mechanized_equipment;
        $array['data']['mechanized_vehicle'] = $this->base_model->mechanized_vehicle;
        // sec 2
        $array['data']['tax_payers'] = $this->base_model->tax_payers;
        $array['data']['wheeler_in_the_family'] = $this->base_model->wheeler_in_the_family;
        $array['data']['tractor'] = $this->base_model->tractor;
        $array['data']['family_has_a_harvester'] = $this->base_model->family_has_a_harvester;
        $array['data']['ac'] = $this->base_model->ac;
        $array['data']['generator'] = $this->base_model->generator;
        $array['data']['irrigated_land'] = $this->base_model->irrigated_land;
        $array['data']['number_of_licenses'] = $this->base_model->number_of_licenses;
        $array['data']['beggar'] = $this->base_model->beggar;
        $array['data']['domestic_workers'] = $this->base_model->domestic_workers;
        $array['data']['shoe_slippers_worker'] = $this->base_model->shoe_slippers_worker;
        $array['data']['hauliers_hawkers_rickshaw_pullers'] = $this->base_model->hauliers_hawkers_rickshaw_pullers;
        $array['data']['suffering_from_leprosy_cancer_aids'] = $this->base_model->suffering_from_leprosy_cancer_aids;
        $array['data']['orphans'] = $this->base_model->orphans;
        $array['data']['cleaner'] = $this->base_model->cleaner;
        $array['data']['daily_salaried_laborers'] = $this->base_model->daily_salaried_laborers;
        $array['data']['families_of_landless_laborers'] = $this->base_model->families_of_landless_laborers;
        $array['data']['below_poverty_line'] = $this->base_model->below_poverty_line;
        $array['data']['abandoned_women'] = $this->base_model->abandoned_women;
        $array['data']['family_headed_by_destitute_woman'] = $this->base_model->family_headed_by_destitute_woman;
        $array['data']['housingless_families'] = $this->base_model->housingless_families;
        // end sec 2
        // sec 3

        $array['data']['personal_features_accommodation'] = $this->base_model->personal_features_accommodation;
        $array['data']['personal_features_toilet'] = $this->base_model->personal_features_toilet;
        $array['data']['personal_features_structure_building_under_narega'] = $this->base_model->personal_features_structure_building_under_narega;
        $array['data']['personal_features_connection_of_tap_water'] = $this->base_model->personal_features_connection_of_tap_water;
        $array['data']['other_features_ration'] = $this->base_model->other_features_ration;
        $array['data']['other_features_economic_benefits_of_schooling'] = $this->base_model->other_features_economic_benefits_of_schooling;
        $array['data']['other_features_kisan_samman'] = $this->base_model->other_features_kisan_samman;
        $array['data']['other_features_benefits_provided_labor_department'] = $this->base_model->other_features_benefits_provided_labor_department;
        $array['data']['other_features_labor_worker_work_in_narega'] = $this->base_model->other_features_labor_worker_work_in_narega;

        $array['data']['other_features_benefits_associated_upsrlm'] = $this->base_model->other_features_benefits_associated_upsrlm;
        $array['data']['other_features_benefits_of_social_welfare_department'] = $this->base_model->other_features_benefits_of_social_welfare_department;
        $array['data']['other_features_benefits_of_women_welfare_department'] = $this->base_model->other_features_benefits_of_women_welfare_department;
        $array['data']['other_features_benefits_of_health_department'] = $this->base_model->other_features_benefits_of_health_department;
        // end sec 
        // sec sec 4

        $array['data']['name_of_head_of_household'] = $this->base_model->name_of_head_of_household;
        $array['data']['fathers_name_english'] = $this->base_model->fathers_name_english;
        $array['data']['gender_of_head'] = $this->base_model->gender_of_head;
        $array['data']['category'] = $this->base_model->category;
        $array['data']['occupation'] = $this->base_model->occupation;
        $array['data']['mobile_no'] = $this->base_model->mobile_no;
        $array['data']['voter_card_yes_no'] = $this->base_model->voter_card_yes_no;
        $array['data']['epic_number_of_head'] = $this->base_model->epic_number_of_head;
        $array['data']['family_has_smartphone'] = $this->base_model->family_has_smartphone;
        $array['data']['head_dob'] = $this->base_model->head_dob;
        $array['data']['head_age'] = $this->base_model->head_age;
        $array['data']['head_block_code'] = $this->base_model->head_block_code;
        $array['data']['head_district_code'] = $this->base_model->head_district_code;
        $array['data']['head_gram_panchayat_code'] = $this->base_model->head_gram_panchayat_code;
        $array['data']['head_village_code'] = $this->base_model->head_village_code;
        $array['data']['status'] = $this->base_model->status;
        return $array;
    }

    public function changenu() {
        if ($this->base_model->survey == '0' and $this->base_model->sec7_com == '0') {
            $gp_sachive = User::find()->joinWith(['grampanchayat'])->andWhere(['user.status' => 10, 'role' => MasterRole::ROLE_GP_SAACHIV])->andWhere(['relation_user_gram_panchayat.status' => 1, 'relation_user_gram_panchayat.gram_panchayat_code' => $this->base_model->gram_panchayat_code])->all();
            $gp_sahayak = User::find()->joinWith(['grampanchayat'])->andWhere(['user.status' => 10, 'role' => MasterRole::ROLE_GP_SAHAYAK])->andWhere(['relation_user_gram_panchayat.status' => 1, 'relation_user_gram_panchayat.gram_panchayat_code' => $this->base_model->gram_panchayat_code])->limit(1)->one();
            $gp_rojgar_sevak = User::find()->joinWith(['grampanchayat'])->andWhere(['user.status' => 10, 'role' => MasterRole::ROLE_GP_ROJGAR_SEVAK])->andWhere(['relation_user_gram_panchayat.status' => 1, 'relation_user_gram_panchayat.gram_panchayat_code' => $this->base_model->gram_panchayat_code])->limit(1)->one();
            $gp_bc_sakhi = User::find()->joinWith(['cboprofile'])->andWhere(['user.status' => 10, 'role' => MasterRole::ROLE_CBO_USER, 'cbo_member_profile.bc' => 1, 'cbo_member_profile.bc_operational' => 1])->andWhere(['cbo_member_profile.gram_panchayat_code' => $this->base_model->gram_panchayat_code])->limit(1)->one();
            $gp_safai_karmi = User::find()->joinWith(['grampanchayat'])->andWhere(['user.status' => 10, 'role' => MasterRole::ROLE_GP_SAFAI_KARMI])->andWhere(['relation_user_gram_panchayat.status' => 1, 'relation_user_gram_panchayat.gram_panchayat_code' => $this->base_model->gram_panchayat_code])->limit(1)->one();
            $cbo_user = User::find()->joinWith(['grampanchayat'])->andWhere(['user.status' => 10, 'role' => MasterRole::ROLE_ULTRA_POOR_ENUMERATOR])->andWhere(['relation_user_gram_panchayat.status' => 1, 'relation_user_gram_panchayat.gram_panchayat_code' => $this->base_model->gram_panchayat_code])->limit(1)->one();
            if ($gp_sahayak != null) {
                $this->base_model->created_by = $gp_sahayak->id;
                $this->base_model->sec7_com = 1;
                $this->base_model->save();
            } elseif ($gp_rojgar_sevak != null) {
                $this->base_model->created_by = $gp_rojgar_sevak->id;
                $this->base_model->sec7_com = 1;
                $this->base_model->save();
            } elseif ($gp_safai_karmi != null) {
                $this->base_model->created_by = $gp_safai_karmi->id;
                $this->base_model->sec7_com = 1;
                $this->base_model->save();
            } elseif ($gp_bc_sakhi != null) {
                $this->base_model->created_by = $gp_bc_sakhi->id;
                $this->base_model->sec7_com = 1;
                $this->base_model->save();
            }
        }
        return $this->base_model;
    }
}
