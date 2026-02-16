<?php

namespace sakhi\modules\online\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use kartik\form\ActiveForm;
use common\helpers\FileHelpers;

/**
 * Default controller for the `online` module
 */
class FbController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message = '';

    public function beforeAction($action) {

        Yii::$app->request->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionForm() {

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new \common\models\online\form\FbdemandsideForm();

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    
                }
            } else {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        } else {

            $model = new \common\models\online\form\FbdemandsideForm();

            return $this->render('form', ['model' => $model]);
        }
    }

    public function actionFormSection($section, $fd_section_qno) {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new \common\models\online\form\FbdemandsideForm();
            $model->fd_section = $section;
            $model->fd_section_qno = $fd_section_qno;
            $model->fd_section_name = $model->section_option[$model->fd_section];
            $section_column = 'fd_section' . $section;
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    $this->message = $model->fd_section_name . ' जानकारी सफलता पूर्वक प्राप्त हुआ';
                    if ($model->fd_section == '1') {
                        if ($model->fd_section_qno == '10a1') {
                            $model->fb_demand_side_model->name = $model->name;
                            $model->fb_demand_side_model->mobile_no = $model->mobile_no;
                            $model->fb_demand_side_model->phone_type = $model->phone_type;
                        }
                        if ($model->fd_section_qno == '10a2') {
                            $model->fb_demand_side_model->aadhar_number = $model->aadhar_number;
                        }
                        if ($model->fd_section_qno == '10a3') {
                            $dif_principal_occupation_array = [];
                            $principal_occupation_option = $model->principal_occupation_option;
                            $principal_occupation_array = array_keys($principal_occupation_option);
                            $dif_principal_occupation_array = array_diff($principal_occupation_array, $model->principal_occupation);
                            if (isset($model->principal_occupation) and is_array($model->principal_occupation)) {
                                foreach ($model->principal_occupation as $val) {
                                    $name = 'principal_occupation' . $val;
                                    $model->fb_demand_side_model->$name = 1;
                                }
                            }
                            foreach ($dif_principal_occupation_array as $val) {
                                $name = 'principal_occupation' . $val;
                                $model->fb_demand_side_model->$name = 0;
                            }
                            $model->fb_demand_side_model->principal_occupation99_text = $model->principal_occupation99_text;
                        }
                        if ($model->fd_section_qno == '10a4') {
                            $dif_important_high_speed_internet_array = [];
                            $important_high_speed_internet_option = $model->important_high_speed_internet_option;
                            $important_high_speed_internet_array = array_keys($important_high_speed_internet_option);
                            $dif_important_high_speed_internet_array = array_diff($important_high_speed_internet_array, $model->important_high_speed_internet);
                            if (isset($model->important_high_speed_internet) and is_array($model->important_high_speed_internet)) {
                                foreach ($model->important_high_speed_internet as $val) {
                                    $name = 'important_high_speed_internet' . $val;
                                    $model->fb_demand_side_model->$name = 1;
                                }
                            }
                            foreach ($dif_important_high_speed_internet_array as $val) {
                                $name = 'important_high_speed_internet' . $val;
                                $model->fb_demand_side_model->$name = 0;
                            }
                        }
                        if ($model->fd_section_qno == '10a5') {
                            $dif_closest_your_residence_array = [];
                            $closest_your_residence_option = $model->closest_your_residence_option;

                            $closest_your_residence_array = array_keys($closest_your_residence_option);
                            $dif_closest_your_residence_array = array_diff($closest_your_residence_array, $model->closest_your_residence);
                            if (isset($model->closest_your_residence) and is_array($model->closest_your_residence)) {
                                foreach ($model->closest_your_residence as $val) {
                                    $name = 'closest_your_residence' . $val;
                                    $model->fb_demand_side_model->$name = 1;
                                }
                            }
                            foreach ($dif_closest_your_residence_array as $val) {
                                $name = 'closest_your_residence' . $val;
                                $model->fb_demand_side_model->$name = 0;
                            }
                        }
                        if ($model->fd_section_qno == '10a6') {
                            $model->fb_demand_side_model->which_township_mohalla_residence_id = $model->which_township_mohalla_residence_id;
                        }
                        if ($model->fd_section_qno == '10a7') {
                            $model->fb_demand_side_model->category_consider_financially_id = $model->category_consider_financially_id;
                        }
                        if ($model->fd_section_qno == '10a8') {
                            $model->fb_demand_side_model->gram_panchayat_code = $model->gram_panchayat_code;
                        }
                        if ($model->fd_section_qno == '10b1') {
                            $model->fb_demand_side_model->social_class_id = $model->social_class_id;
                        }
                        if ($model->fd_section_qno == '10b2') {
                            $dif_occupation_family_head_household_array = [];
                            $occupation_family_head_household_option = $model->occupation_family_head_household_option;
                            $occupation_family_head_household_array = array_keys($occupation_family_head_household_option);
                            $dif_occupation_family_head_household_array = array_diff($occupation_family_head_household_array, $model->occupation_family_head_household);
                            if (isset($model->occupation_family_head_household) and is_array($model->occupation_family_head_household)) {
                                foreach ($model->occupation_family_head_household as $val) {
                                    $name = 'occupation_family_head_household' . $val;
                                    $model->fb_demand_side_model->$name = 1;
                                }
                            }

                            foreach ($dif_occupation_family_head_household_array as $val) {
                                $name = 'occupation_family_head_household' . $val;
                                $model->fb_demand_side_model->$name = 0;
                            }
                        }
                        if ($model->fd_section_qno == '10b3') {
                            $model->fb_demand_side_model->female_less5y = $model->female_less5y;
                            $model->fb_demand_side_model->male_less5y = $model->male_less5y;
                            $model->fb_demand_side_model->female_6to16y = $model->female_6to16y;
                            $model->fb_demand_side_model->male_6to16y = $model->male_6to16y;
                            $model->fb_demand_side_model->female_17to25y = $model->female_17to25y;
                            $model->fb_demand_side_model->male_17to25y = $model->male_17to25y;

                            $model->fb_demand_side_model->female_26to50y = $model->female_26to50y;
                            $model->fb_demand_side_model->male_26to50y = $model->male_26to50y;
                            $model->fb_demand_side_model->female_51to65y = $model->female_51to65y;
                            $model->fb_demand_side_model->male_51to65y = $model->male_51to65y;

                            $model->fb_demand_side_model->female_gr65y = $model->female_gr65y;
                            $model->fb_demand_side_model->male_gr65y = $model->male_gr65y;
                        }
                        if ($model->fd_section_qno == '10b4') {
                            $dif_family_structure_edu_health_live_array = [];
                            $family_structure_edu_health_live_option = $model->family_structure_edu_health_live_option;
                            $family_structure_edu_health_live_array = array_keys($family_structure_edu_health_live_option);
                            $dif_family_structure_edu_health_live_array = array_diff($family_structure_edu_health_live_array, $model->family_structure_edu_health_live);
                            if (isset($model->family_structure_edu_health_live) and is_array($model->family_structure_edu_health_live)) {
                                foreach ($model->family_structure_edu_health_live as $val) {
                                    $name = 'family_structure_edu_health_live' . $val;
                                    $model->fb_demand_side_model->$name = 1;
                                }
                            }
                            foreach ($dif_family_structure_edu_health_live_array as $val) {
                                $name = 'family_structure_edu_health_live' . $val;
                                $model->fb_demand_side_model->$name = 0;
                            }
                        }
                        if ($model->fd_section_qno == '10c1') {
                            if ($model->family_following_form_24years1)
                            $model->fb_demand_side_model->family_following_form_24years1 = $model->family_following_form_24years1;
                            if ($model->family_following_form_24years2)
                            $model->fb_demand_side_model->family_following_form_24years2 = $model->family_following_form_24years2;
                            if ($model->family_following_form_24years3)
                            $model->fb_demand_side_model->family_following_form_24years3 = $model->family_following_form_24years3;
                            if ($model->family_following_form_24years4)
                            $model->fb_demand_side_model->family_following_form_24years4 = $model->family_following_form_24years4;
                            if ($model->family_following_form_24years5)
                            $model->fb_demand_side_model->family_following_form_24years5 = $model->family_following_form_24years5;
                            if ($model->family_following_form_24years6)
                            $model->fb_demand_side_model->family_following_form_24years6 = $model->family_following_form_24years6;
                            if ($model->family_following_form_24years7)
                            $model->fb_demand_side_model->family_following_form_24years7 = $model->family_following_form_24years7;
                            if ($model->family_following_form_24years8)
                            $model->fb_demand_side_model->family_following_form_24years8 = $model->family_following_form_24years8;
                            if ($model->family_following_form_24years99)
                                $model->fb_demand_side_model->family_following_form_24years99 = $model->family_following_form_24years99;
//                            $dif_family_following_form_24years_array = [];
//                            $family_following_form_24years_option = $model->family_following_form_24years_option;
//                            $family_following_form_24years_array = array_keys($family_following_form_24years_option);
//                            $dif_family_following_form_24years_array = array_diff($family_following_form_24years_array, $model->family_following_form_24years);
//                            if (isset($model->family_following_form_24years) and is_array($model->family_following_form_24years)) {
//                                foreach ($model->family_following_form_24years as $val) {
//                                    $name = 'family_following_form_24years' . $val;
//                                    $model->fb_demand_side_model->$name = 1;
//                                }
//                            }
//                            foreach ($dif_family_following_form_24years_array as $val) {
//                                $name = 'family_following_form_24years' . $val;
//                                $model->fb_demand_side_model->$name = 0;
//                            }
                        }
                        if ($model->fd_section_qno == '10c2') {
                            $model->fb_demand_side_model->female_help1 = $model->female_help1;
                            $model->fb_demand_side_model->male_help1 = $model->male_help1;
                            $model->fb_demand_side_model->female_help2 = $model->female_help2;
                            $model->fb_demand_side_model->male_help2 = $model->male_help2;
                            $model->fb_demand_side_model->female_helpgr2 = $model->female_helpgr2;
                            $model->fb_demand_side_model->male_helpgr2 = $model->male_helpgr2;
                        }
                        if ($model->fd_section_qno == '10c3') {
                            $dif_what_can_government_help_array = [];
                            $what_can_government_help_option = $model->what_can_government_help_option;
                            $what_can_government_help_array = array_keys($what_can_government_help_option);
                            $dif_what_can_government_help_array = array_diff($what_can_government_help_array, $model->what_can_government_help);
                            if (isset($model->what_can_government_help) and is_array($model->what_can_government_help)) {
                                foreach ($model->what_can_government_help as $val) {
                                    $name = 'what_can_government_help' . $val;
                                    $model->fb_demand_side_model->$name = 1;
                                }
                            }
                            foreach ($dif_what_can_government_help_array as $val) {
                                $name = 'what_can_government_help' . $val;
                                $model->fb_demand_side_model->$name = 0;
                            }
                            $model->fb_demand_side_model->what_can_government_help99_text = $model->what_can_government_help99_text;
                        }
                        if ($model->fd_section_qno == '10c4') {
                            $model->fb_demand_side_model->your_family_financially_capable_id = $model->your_family_financially_capable_id;
                        }
                        if ($model->fd_section_qno == '10c5') {
                            $model->fb_demand_side_model->for_monthly_income_expect_id = $model->for_monthly_income_expect_id;
                        }

                        $model->fb_demand_side_model->fd_section = 1;
                        $model->fb_demand_side_model->fd_section1_date = new \yii\db\Expression('NOW()');

                        $APPLICATION_FORM_FILE_FOLDER = \Yii::$app->params['datapath'];
                        if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'online')) {
                            mkdir($APPLICATION_FORM_FILE_FOLDER . 'online');
                            chmod($APPLICATION_FORM_FILE_FOLDER . 'online', 0777);
                        }
                        if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'online/member')) {
                            mkdir($APPLICATION_FORM_FILE_FOLDER . 'online/member');
                            chmod($APPLICATION_FORM_FILE_FOLDER . 'online/member', 0777);
                        }
                        if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'online/member' . '/' . $model->user_id)) {
                            mkdir($APPLICATION_FORM_FILE_FOLDER . 'online/member' . '/' . $model->user_id);
                            chmod($APPLICATION_FORM_FILE_FOLDER . 'online/member' . '/' . $model->user_id, 0777);
                        }
                        $APPLICATION_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . 'online/member' . '/' . $model->user_id;
                        if ($model->fd_section_qno == '10a2') {
                            try {
                                if (isset(\Yii::$app->request->post()['FbdemandsideForm']['aadhar_front_photo']) and \Yii::$app->request->post()['FbdemandsideForm']['aadhar_front_photo']) {
                                    $content1 = base64_decode(\Yii::$app->request->post()['FbdemandsideForm']['aadhar_front_photo']);
                                    $im1 = imagecreatefromstring($content1);
                                    $image_name1 = 'aadhar_front_photo_' . uniqid() . '.jpg';
                                    $model->fb_demand_side_model->aadhar_front_photo = $image_name1;
                                    if ($im1 !== false) {
                                        header('Content-Type: image/jpeg');
                                        imagejpeg($im1, $APPLICATION_FILE_FOLDER . '/' . $image_name1);
                                        chmod($APPLICATION_FILE_FOLDER . '/' . $image_name1, 0777);
                                        $file = new FileHelpers();
                                        $file->file_path = $APPLICATION_FILE_FOLDER;
                                        $file->file_name = $image_name1;
                                        $file->upload();
                                        imagedestroy($im1);
                                    }
                                }
                            } catch (\Exception $ex) {
                                $file = \Yii::$app->params['datapath'] . 'tmp/file_upload_errror.log';
                                $fp = fopen($file, 'a+');
                                fwrite($fp, $ex->getMessage() . ' code ' . $ex->getCode());
                                fclose($fp);
                            }
                        }
                        if ($model->fd_section_qno == '10a2a') {
                            try {

                                if (isset(\Yii::$app->request->post()['FbdemandsideForm']['aadhar_back_photo']) and \Yii::$app->request->post()['FbdemandsideForm']['aadhar_back_photo']) {
                                    $content2 = base64_decode(\Yii::$app->request->post()['FbdemandsideForm']['aadhar_back_photo']);
                                    $im2 = imagecreatefromstring($content2);
                                    $image_name2 = 'aadhar_back_photo_' . uniqid() . '.jpg';
                                    $model->fb_demand_side_model->aadhar_back_photo = $image_name2;
                                    if ($im2 !== false) {
                                        header('Content-Type: image/jpeg');
                                        imagejpeg($im2, $APPLICATION_FILE_FOLDER . '/' . $image_name2);
                                        chmod($APPLICATION_FILE_FOLDER . '/' . $image_name2, 0777);
                                        $file = new FileHelpers();
                                        $file->file_path = $APPLICATION_FILE_FOLDER;
                                        $file->file_name = $image_name2;
                                        $file->upload();
                                        imagedestroy($im2);
                                    }
                                }
                            } catch (\Exception $ex) {
                                $file = \Yii::$app->params['datapath'] . 'tmp/file_upload_errror.log';
                                $fp = fopen($file, 'a+');
                                fwrite($fp, $ex->getMessage() . ' code ' . $ex->getCode());
                                fclose($fp);
                            }
                        }
                    }
                    if ($model->fd_section == '2') {
                        if ($model->fd_section_qno == '201') {
                            $model->fb_demand_side_model->sec1_use_any_elearning_app_portal = $model->sec1_use_any_elearning_app_portal;

                            if ($model->sec1_use_any_elearning_app_portal == 1) {
                                $model->fb_demand_side_model->sec1_yes_which_elearning_product_use = $model->sec1_yes_which_elearning_product_use;
                                $model->fb_demand_side_model->sec1_how_much_annual_subscription = $model->sec1_how_much_annual_subscription;
                            }
                            if ($model->sec1_use_any_elearning_app_portal == 2) {
                                $model->fb_demand_side_model->sec1_if_not_why = $model->sec1_if_not_why;
                            }
                        }
                        if ($model->fd_section_qno == '202') {
                            $model->fb_demand_side_model->sec1_whether_school_teachers_using_elearning_product = $model->sec1_whether_school_teachers_using_elearning_product;
                            if ($model->sec1_whether_school_teachers_using_elearning_product == 1) {
                                $model->fb_demand_side_model->sec1_yes_whether_school_teachers_using_elearning_product_name = $model->sec1_yes_whether_school_teachers_using_elearning_product_name;
                                $model->fb_demand_side_model->sec1_yes_whether_school_teachers_using_elearning_product_subscri = $model->sec1_yes_whether_school_teachers_using_elearning_product_subscri;
                            }
                            if ($model->sec1_whether_school_teachers_using_elearning_product == 2) {
                                $model->fb_demand_side_model->sec1_no_whether_school_teachers_using_elearning_product = $model->sec1_no_whether_school_teachers_using_elearning_product;
                            }
                        }
                        if ($model->fd_section_qno == '203') {
                            $model->fb_demand_side_model->sec1_elearning_facility_improve_education = $model->sec1_elearning_facility_improve_education;
                            if ($model->sec1_elearning_facility_improve_education == 1) {
                                $model->fb_demand_side_model->sec1_yes_elearning_facility_improve_education_min_cost = $model->sec1_yes_elearning_facility_improve_education_min_cost;
                            }
                        }
                        if ($model->fd_section_qno == '204') {
                            $model->fb_demand_side_model->sec1_part_of_cost_borne_by_government = $model->sec1_part_of_cost_borne_by_government;
                        }
                        $model->fb_demand_side_model->fd_section = 2;
                        $model->fb_demand_side_model->fd_section2_date = new \yii\db\Expression('NOW()');
                    }
                    if ($model->fd_section == '3') {
                        if ($model->fd_section_qno == '301') {
                            $model->fb_demand_side_model->sec2_know_tele_medicine_through_live_video = $model->sec2_know_tele_medicine_through_live_video;
                            $model->fb_demand_side_model->sec2_yes_used_tele_medicine_medium = $model->sec2_yes_used_tele_medicine_medium;
                        }
                        if ($model->fd_section_qno == '302') {
                            $model->fb_demand_side_model->sec2_know_effective_treatment_through_tele_medicine = $model->sec2_know_effective_treatment_through_tele_medicine;
                        }
                        if ($model->fd_section_qno == '303') {
                            $model->fb_demand_side_model->sec2_aware_cost_medical_consultation_through_tele_medicine = $model->sec2_aware_cost_medical_consultation_through_tele_medicine;
                        }
                        if ($model->fd_section_qno == '304') {
                            $dif_sec2_explain_understanding_tele_medicine_array = [];
                            $sec2_explain_understanding_tele_medicine_option = $model->sec2_explain_understanding_tele_medicine_option;
                            $sec2_explain_understanding_tele_medicine_array = array_keys($sec2_explain_understanding_tele_medicine_option);
                            $dif_sec2_explain_understanding_tele_medicine_array = array_diff($sec2_explain_understanding_tele_medicine_array, $model->sec2_explain_understanding_tele_medicine);
                            if (isset($model->sec2_explain_understanding_tele_medicine) and is_array($model->sec2_explain_understanding_tele_medicine)) {
                                foreach ($model->sec2_explain_understanding_tele_medicine as $val) {
                                    $name = 'sec2_explain_understanding_tele_medicine' . $val;
                                    $model->fb_demand_side_model->$name = 1;
                                }
                            }
                            foreach ($dif_sec2_explain_understanding_tele_medicine_array as $val) {
                                $name = 'sec2_explain_understanding_tele_medicine' . $val;
                                $model->fb_demand_side_model->$name = 0;
                            }
                        }
                        if ($model->fd_section_qno == '305') {
                            $model->fb_demand_side_model->sec2_strong_system_telemedicine_maximum_fee = $model->sec2_strong_system_telemedicine_maximum_fee;
                        }
                        if ($model->fd_section_qno == '306') {
                            $model->fb_demand_side_model->sec2_subsidy_by_government = $model->sec2_subsidy_by_government;
                        }

                        $model->fb_demand_side_model->fd_section = 2;
                        $model->fb_demand_side_model->fd_section2_date = new \yii\db\Expression('NOW()');
                    }
                    if ($model->fd_section == '4') {
                        if ($model->fd_section_qno == '401') {
                            $dif_sec3_agri_related_features_accessed_mobile_array = [];
                            $sec3_agri_related_features_accessed_mobile_option = $model->sec3_agri_related_features_accessed_mobile1_option;
                            $sec3_agri_related_features_accessed_mobile_array = array_keys($sec3_agri_related_features_accessed_mobile_option);
                            $dif_sec3_agri_related_features_accessed_mobile_array = array_diff($sec3_agri_related_features_accessed_mobile_array, $model->sec3_agri_related_features_accessed_mobile);
                            if (isset($model->sec3_agri_related_features_accessed_mobile) and is_array($model->sec3_agri_related_features_accessed_mobile)) {
                                foreach ($model->sec3_agri_related_features_accessed_mobile as $val) {
                                    $name = 'sec3_agri_related_features_accessed_mobile' . $val;
                                    $model->fb_demand_side_model->$name = 1;
                                }
                            }
                            foreach ($dif_sec3_agri_related_features_accessed_mobile_array as $val) {
                                $name = 'sec3_agri_related_features_accessed_mobile' . $val;
                                $model->fb_demand_side_model->$name = 0;
                            }
                        }
                        if ($model->fd_section_qno == '402') {
                            $dif_sec3_facility_available_benefit_you_array = [];
                            $sec3_facility_available_benefit_you_option = $model->sec3_facility_available_benefit_you_option;
                            $sec3_facility_available_benefit_you_array = array_keys($sec3_facility_available_benefit_you_option);
                            $dif_sec3_facility_available_benefit_you_array = array_diff($sec3_facility_available_benefit_you_array, $model->sec3_facility_available_benefit_you);
                            if (isset($model->sec3_facility_available_benefit_you) and is_array($model->sec3_facility_available_benefit_you)) {
                                foreach ($model->sec3_facility_available_benefit_you as $val) {
                                    $name = 'sec3_facility_available_benefit_you' . $val;
                                    $model->fb_demand_side_model->$name = 1;
                                }
                            }
                            foreach ($dif_sec3_facility_available_benefit_you_array as $val) {
                                $name = 'sec3_facility_available_benefit_you' . $val;
                                $model->fb_demand_side_model->$name = 0;
                            }
                        }
                        if ($model->fd_section_qno == '403') {
                            $dif_sec3_interested_agriculture_provided_smartphones_array = [];
                            $sec3_interested_agriculture_provided_smartphones_option = $model->sec3_interested_agriculture_provided_smartphones_option;
                            $sec3_interested_agriculture_provided_smartphones_array = array_keys($sec3_interested_agriculture_provided_smartphones_option);
                            $dif_sec3_interested_agriculture_provided_smartphones_array = array_diff($sec3_interested_agriculture_provided_smartphones_array, $model->sec3_interested_agriculture_provided_smartphones);
                            if (isset($model->sec3_interested_agriculture_provided_smartphones) and is_array($model->sec3_interested_agriculture_provided_smartphones)) {
                                foreach ($model->sec3_interested_agriculture_provided_smartphones as $val) {
                                    $name = 'sec3_interested_agriculture_provided_smartphones' . $val;
                                    $model->fb_demand_side_model->$name = 1;
                                }
                            }
                            foreach ($dif_sec3_interested_agriculture_provided_smartphones_array as $val) {
                                $name = 'sec3_interested_agriculture_provided_smartphones' . $val;
                                $model->fb_demand_side_model->$name = 0;
                            }
                        }
                        if ($model->fd_section_qno == '404') {
                            $model->fb_demand_side_model->sec3_maximum_fee_agri_related_facilities_arranged = $model->sec3_maximum_fee_agri_related_facilities_arranged;
                        }
                        $model->fb_demand_side_model->fd_section = 4;
                        $model->fb_demand_side_model->fd_section4_date = new \yii\db\Expression('NOW()');
                    }
                    if ($model->fd_section == '5') {
                        if ($model->fd_section_qno == '501') {
                            $model->fb_demand_side_model->sec4_can_you_do_mobile_banking_service = $model->sec4_can_you_do_mobile_banking_service;
                        }
                        if ($model->fd_section_qno == '502') {
                            $model->fb_demand_side_model->sec4_avg_visit_bank_atm_in_month = $model->sec4_avg_visit_bank_atm_in_month;
                        }
                        if ($model->fd_section_qno == '503') {
                            $model->fb_demand_side_model->sec4_easy_access_to_banking_services = $model->sec4_easy_access_to_banking_services;
                        }
                        if ($model->fd_section_qno == '504') {
                            $model->fb_demand_side_model->sec4_loan_application = $model->sec4_loan_application;

                            $model->fb_demand_side_model->sec4_Intimation_debt_any_other_receipt = $model->sec4_Intimation_debt_any_other_receipt;
                            $model->fb_demand_side_model->sec4_step_wise_information_financial_process_bank = $model->sec4_step_wise_information_financial_process_bank;

                            $model->fb_demand_side_model->sec4_transaction_details_bank_account = $model->sec4_transaction_details_bank_account;
                            $model->fb_demand_side_model->sec4_insurance_application = $model->sec4_insurance_application;
                            $model->fb_demand_side_model->sec4_all_payments_made_by_you = $model->sec4_all_payments_made_by_you;
                            $model->fb_demand_side_model->sec4_schemes_benefits_updates = $model->sec4_schemes_benefits_updates;
                            $model->fb_demand_side_model->sec4_buy_sell_on_ecommerce_platform = $model->sec4_buy_sell_on_ecommerce_platform;
                            $model->fb_demand_side_model->sec4_knowledge_financial_literacy_money_management = $model->sec4_knowledge_financial_literacy_money_management;
                        }
                        if ($model->fd_section_qno == '505') {
                            $model->fb_demand_side_model->sec4_bc_sakhi_gram_panchayat = $model->sec4_bc_sakhi_gram_panchayat;
                            if ($model->sec4_bc_sakhi_gram_panchayat == 1) {
                                $model->fb_demand_side_model->sec4_yes_bc_sakhi_gram_panchayat = $model->sec4_yes_bc_sakhi_gram_panchayat;
                                $model->fb_demand_side_model->sec4_transaction_failure_bc_sakhi = $model->sec4_transaction_failure_bc_sakhi;
                            }
                        }
                        $model->fb_demand_side_model->fd_section = 5;
                        $model->fb_demand_side_model->fd_section5_date = new \yii\db\Expression('NOW()');
                    }
                    if ($model->fd_section == '6') {
                        if ($model->fd_section_qno == '601') {
                            $model->fb_demand_side_model->sec5_birth_death_marriage_certificate = $model->sec5_birth_death_marriage_certificate;
                            $model->fb_demand_side_model->sec5_building_permits = $model->sec5_building_permits;
                            $model->fb_demand_side_model->sec5_business_license = $model->sec5_business_license;
                            $model->fb_demand_side_model->sec5_driving_license_application = $model->sec5_driving_license_application;
                            $model->fb_demand_side_model->sec5_environmental_permit = $model->sec5_environmental_permit;
                            $model->fb_demand_side_model->sec5_application_vacant_posts_government_jobs = $model->sec5_application_vacant_posts_government_jobs;

                            $model->fb_demand_side_model->sec5_land_title_records_registration = $model->sec5_land_title_records_registration;
                            $model->fb_demand_side_model->sec5_personal_id_card = $model->sec5_personal_id_card;
                            $model->fb_demand_side_model->sec5_social_security_schemes_applications = $model->sec5_social_security_schemes_applications;
                            $model->fb_demand_side_model->sec5_passport_visa_application = $model->sec5_passport_visa_application;
                            $model->fb_demand_side_model->sec5_payment_of_fee_and_penalty = $model->sec5_payment_of_fee_and_penalty;
                            $model->fb_demand_side_model->sec5_registering_an_fir_with_police = $model->sec5_registering_an_fir_with_police;

                            $model->fb_demand_side_model->sec5_payment_of_utilities = $model->sec5_payment_of_utilities;
                            $model->fb_demand_side_model->sec5_business_registration = $model->sec5_business_registration;
                            $model->fb_demand_side_model->sec5_vehicle_registration = $model->sec5_vehicle_registration;
                            $model->fb_demand_side_model->sec5_application_for_change_residence_address = $model->sec5_application_for_change_residence_address;
                            $model->fb_demand_side_model->sec5_pay_tax = $model->sec5_pay_tax;
                        }
                        if ($model->fd_section_qno == '602') {
                            $model->fb_demand_side_model->sec5_do_you_get_all_these_services_easily = $model->sec5_do_you_get_all_these_services_easily;
                        }
                        if ($model->fd_section_qno == '603') {
                            $model->fb_demand_side_model->sec5_go_government_office_for_these_government_services = $model->sec5_go_government_office_for_these_government_services;
                        }
                        if ($model->fd_section_qno == '604') {
                            $model->fb_demand_side_model->sec5_how_it_cost_to_get_such_government_service = $model->sec5_how_it_cost_to_get_such_government_service;
                        }
                        if ($model->fd_section_qno == '605') {
                            $model->fb_demand_side_model->sec5_high_speed_internet_panchayat_sahayak = $model->sec5_high_speed_internet_panchayat_sahayak;
                        }

                        $model->fb_demand_side_model->fd_section = 6;
                        $model->fb_demand_side_model->fd_section6_date = new \yii\db\Expression('NOW()');
                    }
                    if ($model->fd_section == '7') {
                        if ($model->fd_section_qno == '701')
                            $model->fb_demand_side_model->sec6_you_currently_able_watch_ott_id = $model->sec6_you_currently_able_watch_ott_id;
                        if ($model->fd_section_qno == '702')
                            $model->fb_demand_side_model->sec6_entertainment_low_cost_id = $model->sec6_entertainment_low_cost_id;


                        $model->fb_demand_side_model->fd_section = 7;
                        $model->fb_demand_side_model->fd_section7_date = new \yii\db\Expression('NOW()');
                    }
                    $model->fb_demand_side_model->$section_column = $model->fd_section_qno;
                    if ($model->fb_demand_side_model->save(false)) {
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        \Yii::$app->session->setFlash('success', $this->message);
                        return ['success' => true, 'redirecturl' => '/online/fb/section-view?section=' . $model->fd_section];
                    } else {
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ActiveForm::validate($model->fb_demand_side_model);
                    }
                }
            } else {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        } else {
            $model = new \common\models\online\form\FbdemandsideForm();
            $model->fd_section = $section;
            $model->fd_section_name = $model->section_option[$model->fd_section];
            $model->fd_section_qno = $fd_section_qno;

            return $this->render('section', ['model' => $model, $model->fd_section, 'section' => $model->fd_section, 'name' => $model->fd_section_name]);
        }
    }

    public function actionSectionView($section) {
        $model = new \common\models\online\form\FbdemandsideForm();
        $section_quetion_array = [];
        $section_quetion_array['1']['0'] = '10a1';
        $section_quetion_array['1']['10a1'] = '10a2';
        $section_quetion_array['1']['10a2'] = '10a2a';
        $section_quetion_array['1']['10a2a'] = '10a3';
        $section_quetion_array['1']['10a3'] = '10a4';
        $section_quetion_array['1']['10a4'] = '10a5';
        $section_quetion_array['1']['10a5'] = '10a6';
        $section_quetion_array['1']['10a6'] = '10a7';
        $section_quetion_array['1']['10a7'] = '10a8';

        $section_quetion_array['1']['10a8'] = '10b1';
        $section_quetion_array['1']['10b1'] = '10b2';
        $section_quetion_array['1']['10b2'] = '10b3';
        $section_quetion_array['1']['10b3'] = '10b4';
        $section_quetion_array['1']['10b4'] = '10c1';
        $section_quetion_array['1']['10c1'] = '10c2';
        $section_quetion_array['1']['10c2'] = '10c3';
        $section_quetion_array['1']['10c3'] = '10c4';
        $section_quetion_array['1']['10c4'] = '10c5';
        $section_quetion_array['1']['10c5'] = 'end';

        $section_quetion_array['2']['0'] = '201';
        $section_quetion_array['2']['201'] = '202';
        $section_quetion_array['2']['202'] = '203';
        $section_quetion_array['2']['203'] = '204';
        $section_quetion_array['2']['204'] = 'end';

        $section_quetion_array['3']['0'] = '301';
        $section_quetion_array['3']['301'] = '302';
        $section_quetion_array['3']['302'] = '303';
        $section_quetion_array['3']['303'] = '304';
        $section_quetion_array['3']['304'] = '305';
        $section_quetion_array['3']['305'] = '306';
        $section_quetion_array['3']['306'] = 'end';

        $section_quetion_array['4']['0'] = '401';
        $section_quetion_array['4']['401'] = '402';
        $section_quetion_array['4']['402'] = '403';
        $section_quetion_array['4']['403'] = '404';
        $section_quetion_array['4']['404'] = 'end';
        $section_quetion_array['5']['0'] = '501';
        $section_quetion_array['5']['501'] = '502';
        $section_quetion_array['5']['502'] = '503';
        $section_quetion_array['5']['503'] = '504';
        $section_quetion_array['5']['504'] = '505';
        $section_quetion_array['5']['505'] = 'end';

        $section_quetion_array['6']['0'] = '601';
        $section_quetion_array['6']['601'] = '602';
        $section_quetion_array['6']['602'] = '603';
        $section_quetion_array['6']['603'] = '604';
        $section_quetion_array['6']['604'] = '605';
        $section_quetion_array['6']['605'] = 'end';

        $section_quetion_array['7']['0'] = '701';
        $section_quetion_array['7']['701'] = '702';
        $section_quetion_array['7']['702'] = 'end';
        $model->fd_section = $section;
        $model->fd_section_name = $model->section_option[$model->fd_section];
        $name = 'fd_section' . $section;
//        echo $section_quetion_array[$section][$model->fb_demand_side_model->$name];exit;
        if (isset($section_quetion_array[$section][$model->fb_demand_side_model->$name]) and $section_quetion_array[$section][$model->fb_demand_side_model->$name] != 'end') {
            return $this->redirect(['/online/fb/form-section?section=' . $section . '&fd_section_qno=' . $section_quetion_array[$section][$model->fb_demand_side_model->$name]]);
        }
        return $this->render('section_view', ['model' => $model, $model->fd_section, 'section' => $model->fd_section, 'name' => $model->fd_section_name]);
    }

    public function actionPostassessment() {

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new \common\models\online\form\FbPostAssessmentForm();

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    
                }
            } else {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        } else {

            $model = new \common\models\online\form\FbPostAssessmentForm();

            return $this->render('post_assessment_form', ['model' => $model]);
        }
    }

}
