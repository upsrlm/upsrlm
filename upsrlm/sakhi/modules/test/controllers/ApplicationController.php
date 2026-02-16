<?php

namespace sakhi\modules\test\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use common\models\dynamicdb\cbo_detail\RishtaShg;
use sakhi\components\paytm\PaytmConfig;
use sakhi\components\paytm\PaytmChecksum;
use common\helpers\FileHelpers;

/**
 * ApplicationController for the `shg` module
 */
class ApplicationController extends Controller {

    public function beforeAction($action) {
        throw new \yii\web\UnauthorizedHttpException("Unauthorized.");
        Yii::$app->request->enableCsrfValidation = false;
        if ($action->id == 'paymentresponse') {
            Yii::$app->request->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    use \common\traits\AjaxValidationTrait;

    public $message = '';

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'makepayment' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Profile Index Page of SHG
     *
     * @param [type] $shgid
     * @return void
     */
    public function actionForm($shgid) {
        $shg_model = $this->findModel($shgid);
        $model = new \common\models\wada\form\ApplicationForm($shg_model);

        return $this->render('keycriteria', [
                    'model' => $model,
        ]);
    }

    public function actionFormNext($shgid) {
        $shg_model = $this->findModel($shgid);
        $model = new \common\models\wada\form\ApplicationForm($shg_model);

        return $this->render('form', [
                    'model' => $model,
        ]);
    }

    public function actionFormSection($shgid, $section = 1) {
        // check file upload
        $shg_model = $this->findModel($shgid);

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new \common\models\wada\form\ApplicationForm($shg_model);
            $model->scenario = 'section' . $section;
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    if ($model->scenario == 'section1') {
                        $this->message = 'Section 1 : बेसिक सूचना जानकारी सफलता पूर्वक प्राप्त हुआ';
                        $model->application_model->name = $model->name;
                        $model->application_model->mobile_number = $model->mobile_number;
                        $model->application_model->cbo_shg_id = $model->shg_model->id;
                        $model->application_model->user_id = Yii::$app->user->identity->id;
                        $model->application_model->division_code = $model->shg_model->division_code;
                        $model->application_model->division_name = $model->shg_model->division_name;
                        $model->application_model->district_code = $model->shg_model->district_code;
                        $model->application_model->district_name = $model->shg_model->district_name;
                        $model->application_model->block_code = $model->shg_model->block_code;
                        $model->application_model->block_name = $model->shg_model->block_name;
                        $model->application_model->gram_panchayat_code = $model->shg_model->gram_panchayat_code;
                        $model->application_model->gram_panchayat_name = $model->shg_model->gram_panchayat_name;
                        $model->application_model->cbo_shg_member_id = $model->cbo_shg_member_id;
                        $model->application_model->alt_mobile_number = $model->alt_mobile_number;
                        $model->application_model->whatsapp_number = $model->whatsapp_number;
                        $model->application_model->dob = $model->dob;
                        $model->application_model->academic_level = $model->academic_level;
                        $model->vocational_professional_training = $model->vocational_professional_training;
                        if (isset($model->user_model->cboprofile) and $model->user_model->cboprofile->folder_prefix) {
                            $model->folder_prefix = $model->user_model->cboprofile->folder_prefix;
                        } else {
                            $model->folder_prefix = $model->shg_model->block_code;
                        }
                        $model->application_model->folder_prefix = $model->folder_prefix;
                        $dif_use_array = [];
                        $use_option = ArrayHelper::map(\common\models\wada\master\WadaApplicationMasterVocationalTraining::find()->where(['status' => 1])->all(), 'id', 'name_hi');
                        $use_array = array_keys($use_option);
                        $dif_use_array = array_diff($use_array, $model->vocational_professional_training);
                        if (isset($model->vocational_professional_training) and is_array($model->vocational_professional_training)) {
                            foreach ($model->vocational_professional_training as $use_val) {
                                $name = 'vocational_professional_training' . $use_val;
                                $model->application_model->$name = 1;
                            }
                        }
                        foreach ($dif_use_array as $use_val) {
                            $name = 'vocational_professional_training' . $use_val;
                            $model->application_model->$name = 0;
                        }
                        $model->application_model->social_class = $model->social_class;
                        $model->application_model->marital_status = $model->marital_status;
                        $model->application_model->house_member_details1 = $model->house_member_details1;
                        $model->application_model->house_member_details2 = $model->house_member_details2;
                        $model->application_model->house_member_details3 = $model->house_member_details3;
                        $model->application_model->house_member_details4 = $model->house_member_details4;
                        $model->application_model->guardian_name = $model->guardian_name;
                        $model->application_model->aadhar_number = $model->aadhar_number;
                        $model->application_model->pan_no = $model->pan_no;
                        $model->application_model->bank_account_no = $model->bank_account_no;
                        $model->application_model->bank_id = $model->bank_id;
                        $model->application_model->branch = $model->branch;
                        $model->application_model->branch_code_or_ifsc = $model->branch_code_or_ifsc;
                        if ($model->application_model->form_number == null) {
                            $model->application_model->form_number = 1;
                            $model->application_model->form_start_date = new \yii\db\Expression('NOW()');
                            $model->application_model->form1_date_time = new \yii\db\Expression('NOW()');
                        }
                        $APPLICATION_FORM_FILE_FOLDER = \Yii::$app->params['datapath'];
                        if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo')) {
                            mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo');
                            chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo', 0777);
                        }
                        if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/member')) {
                            mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/member');
                            chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/member', 0777);
                        }
                        if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->application_model->folder_prefix)) {
                            mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->application_model->folder_prefix);
                            chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->application_model->folder_prefix, 0777);
                        }

                        if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->application_model->folder_prefix . '/' . $model->application_model->user_id)) {
                            mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->application_model->folder_prefix . '/' . $model->application_model->user_id);
                            chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->application_model->folder_prefix . '/' . $model->application_model->user_id, 0777);
                        }
                        $APPLICATION_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->application_model->folder_prefix . '/' . $model->application_model->user_id;
                        if (isset(\Yii::$app->request->post()['ApplicationForm']['profile_photo']) and \Yii::$app->request->post()['ApplicationForm']['profile_photo']) {
                            $photo_1_path = Yii::$app->params['datapath'] . "tmp/" . \Yii::$app->request->post()['ApplicationForm']['profile_photo'];
                            if (file_exists($photo_1_path) && is_file($photo_1_path)) {
                                $ext = pathinfo($photo_1_path, PATHINFO_EXTENSION);
                                $image_name1 = 'profile_photo_' . uniqid() . '.'.$ext;
                                $model->application_model->profile_photo = $image_name1;
                                if (copy($photo_1_path, $APPLICATION_FILE_FOLDER . '/' . $image_name1)) {
                                    chmod($APPLICATION_FILE_FOLDER . '/' . $image_name1, 0777);
    
                                    $file = new FileHelpers();
                                    $file->file_path = $APPLICATION_FILE_FOLDER;
                                    $file->file_name = $image_name1;
                                    $file->upload();
                                    unlink($photo_1_path);
                                }
                            }
  
                        }
                        if (isset(\Yii::$app->request->post()['ApplicationForm']['aadhar_front_photo']) and \Yii::$app->request->post()['ApplicationForm']['aadhar_front_photo']) {
                           
                            $photo_2_path = Yii::$app->params['datapath'] . "tmp/" . \Yii::$app->request->post()['ApplicationForm']['aadhar_front_photo'];
                            if (file_exists($photo_2_path) && is_file($photo_2_path)) {
                                $ext = pathinfo($photo_2_path, PATHINFO_EXTENSION);
                                $image_name2 = 'aadhar_front_photo_' . uniqid() . '.'.$ext;
                                $model->application_model->aadhar_front_photo = $image_name2;
                                if (copy($photo_2_path, $APPLICATION_FILE_FOLDER . '/' . $image_name2)) {
                                    chmod($APPLICATION_FILE_FOLDER . '/' . $image_name2, 0777);
    
                                    $file = new FileHelpers();
                                    $file->file_path = $APPLICATION_FILE_FOLDER;
                                    $file->file_name = $image_name2;
                                    $file->upload();
                                    unlink($photo_2_path);
                                }
                            }
                        }
                        if (isset(\Yii::$app->request->post()['ApplicationForm']['aadhar_back_photo']) and \Yii::$app->request->post()['ApplicationForm']['aadhar_back_photo']) {
                            $photo_3_path = Yii::$app->params['datapath'] . "tmp/" . \Yii::$app->request->post()['ApplicationForm']['aadhar_back_photo'];
                            if (file_exists($photo_3_path) && is_file($photo_3_path)) {
                                $ext = pathinfo($photo_3_path, PATHINFO_EXTENSION);
                                $image_name3 = 'aadhar_back_photo_' . uniqid() . '.'.$ext;
                                $model->application_model->aadhar_back_photo = $image_name3;
                                if (copy($photo_3_path, $APPLICATION_FILE_FOLDER . '/' . $image_name3)) {
                                    chmod($APPLICATION_FILE_FOLDER . '/' . $image_name3, 0777);
    
                                    $file = new FileHelpers();
                                    $file->file_path = $APPLICATION_FILE_FOLDER;
                                    $file->file_name = $image_name3;
                                    $file->upload();
                                    unlink($photo_3_path);
                                }
                            }
                          
                        }
                        if (isset(\Yii::$app->request->post()['ApplicationForm']['pan_photo']) and \Yii::$app->request->post()['ApplicationForm']['pan_photo']) {
                            $photo_4_path = Yii::$app->params['datapath'] . "tmp/" . \Yii::$app->request->post()['ApplicationForm']['pan_photo'];
                            if (file_exists($photo_4_path) && is_file($photo_4_path)) {
                                $ext = pathinfo($photo_4_path, PATHINFO_EXTENSION);
                                $image_name4 = 'pan_photo_' . uniqid() . '.'.$ext;
                                $model->application_model->pan_photo = $image_name4;
                                if (copy($photo_4_path, $APPLICATION_FILE_FOLDER . '/' . $image_name4)) {
                                    chmod($APPLICATION_FILE_FOLDER . '/' . $image_name4, 0777);
    
                                    $file = new FileHelpers();
                                    $file->file_path = $APPLICATION_FILE_FOLDER;
                                    $file->file_name = $image_name4;
                                    $file->upload();
                                    unlink($photo_4_path);
                                }
                            }
                            
                        }
                        if (isset(\Yii::$app->request->post()['ApplicationForm']['passbook_photo']) and \Yii::$app->request->post()['ApplicationForm']['passbook_photo']) {
                            $photo_5_path = Yii::$app->params['datapath'] . "tmp/" . \Yii::$app->request->post()['ApplicationForm']['passbook_photo'];
                            if (file_exists($photo_5_path) && is_file($photo_5_path)) {
                                $ext = pathinfo($photo_5_path, PATHINFO_EXTENSION);
                                $image_name5 = 'passbook_photo_' . uniqid() . '.'.$ext;
                                $model->application_model->passbook_photo = $image_name5;
                                if (copy($photo_5_path, $APPLICATION_FILE_FOLDER . '/' . $image_name5)) {
                                    chmod($APPLICATION_FILE_FOLDER . '/' . $image_name5, 0777);
    
                                    $file = new FileHelpers();
                                    $file->file_path = $APPLICATION_FILE_FOLDER;
                                    $file->file_name = $image_name5;
                                    $file->upload();
                                    unlink($photo_5_path);
                                }
                            }
                            
                        }
                    }
                    if ($model->scenario == 'section2') {
                        $this->message = 'Section 2 : Mobility जानकारी सफलता पूर्वक प्राप्त हुआ';
                        $model->application_model->travel_within_gp1 = $model->travel_within_gp1;
                        $model->application_model->travel_within_gp2 = $model->travel_within_gp2;
                        $model->application_model->travel_within_gp3 = $model->travel_within_gp3;
                        $model->application_model->travel_within_gp4 = $model->travel_within_gp4;
                        $model->application_model->travel_within_gp5 = $model->travel_within_gp5;
                        $model->application_model->travel_within_gp6 = $model->travel_within_gp6;
                        $model->application_model->travel_within_gp7 = $model->travel_within_gp7;
                        $model->application_model->travel_within_gp8 = $model->travel_within_gp8;
                        $model->application_model->travel_within_gp9 = $model->travel_within_gp9;
                        $model->application_model->travel_within_gp10 = $model->travel_within_gp10;
                        $model->application_model->vehicle_drive1 = $model->vehicle_drive1;
                        $model->application_model->vehicle_drive2 = $model->vehicle_drive2;
                        $model->application_model->vehicle_drive3 = $model->vehicle_drive3;
                        $model->application_model->vehicle_drive4 = $model->vehicle_drive4;
                        $model->application_model->vehicle_drive5 = $model->vehicle_drive5;
                        $model->application_model->vehicle_drive6 = $model->vehicle_drive6;
                        if ($model->application_model->form_number == 1) {
                            $model->application_model->form_number = 2;
                            $model->application_model->form2_date_time = new \yii\db\Expression('NOW()');
                        }
                    }
                    if ($model->scenario == 'section3') {
                        $this->message = 'Section 3 : टेक्नॉलजी पारंगतता जानकारी सफलता पूर्वक प्राप्त हुआ';
                        $model->application_model->phone_type = $model->phone_type;
                        if ($model->phone_type == 1) {
                            $model->application_model->mobile_with_touch_whose = $model->mobile_with_touch_whose;
                            $dif_use_array = [];
                            $use_option = ArrayHelper::map(\common\models\wada\master\WadaApplicationMasterMobileUsed::find()->where(['status' => 1])->all(), 'id', 'name_hi');
                            $use_array = array_keys($use_option);
                            $dif_use_array = array_diff($use_array, $model->mobile_with_touch_use);
                            if (isset($model->mobile_with_touch_use) and is_array($model->mobile_with_touch_use)) {
                                foreach ($model->mobile_with_touch_use as $use_val) {
                                    $name = 'mobile_with_touch_use' . $use_val;
                                    $model->application_model->$name = 1;
                                }
                            }
                            foreach ($dif_use_array as $use_val) {
                                $name = 'mobile_with_touch_use' . $use_val;
                                $model->application_model->$name = 0;
                            }
                        }
                        if ($model->application_model->form_number == 2) {
                            $model->application_model->form_number = 3;
                            $model->application_model->form3_date_time = new \yii\db\Expression('NOW()');
                        }
                    }
                    if ($model->scenario == 'section4') {
                        $this->message = 'Section 4 : नेतृत्व सफलतापूर्वक जानकारी सफलता पूर्वक प्राप्त हुआ';
                        $model->application_model->existing_member = $model->existing_member;
                        if ($model->existing_member == 1) {
                            $model->application_model->officer1 = $model->officer1;
                            $model->application_model->officer2 = $model->officer2;
                            $model->application_model->officer3 = $model->officer3;
                            $model->application_model->officer4 = $model->officer4;
                            $model->application_model->officer5 = $model->officer5;
                            $model->application_model->officer6 = $model->officer6;
                            $model->application_model->officer7 = $model->officer7;
                            $model->application_model->officer8 = $model->officer8;
                            $model->application_model->officer9 = $model->officer9;
                            $model->application_model->officer10 = $model->officer10;
                            $model->application_model->officer11 = $model->officer11;
                            $model->application_model->officer12 = $model->officer12;
                        }
                        $model->application_model->applicant_member_other_organization = $model->applicant_member_other_organization;
                        if ($model->applicant_member_other_organization == 1) {
                            $model->application_model->applicant_member_other_organization1 = $model->applicant_member_other_organization1;
                            $model->application_model->applicant_member_other_organization2 = $model->applicant_member_other_organization2;
                            $model->application_model->applicant_member_other_organization3 = $model->applicant_member_other_organization3;
                            $model->application_model->applicant_member_other_organization4 = $model->applicant_member_other_organization4;
                            $model->application_model->applicant_member_other_organization5 = $model->applicant_member_other_organization5;
                            $model->application_model->applicant_member_other_organization6 = $model->applicant_member_other_organization6;
                        }
                        if ($model->applicant_member_other_organization == 2) {
                            $model->application_model->election_in_future = $model->election_in_future;
                            if ($model->election_in_future == 1) {
                                $model->application_model->election_in_future1 = $model->election_in_future1;
                                $model->application_model->election_in_future2 = $model->election_in_future2;
                                $model->application_model->election_in_future3 = $model->election_in_future3;
                                $model->application_model->election_in_future4 = $model->election_in_future4;
                                $model->application_model->election_in_future5 = $model->election_in_future5;
                                $model->application_model->election_in_future6 = $model->election_in_future6;
                                $model->application_model->election_in_future7 = $model->election_in_future7;
                                $model->application_model->election_in_future8 = $model->election_in_future8;
                                $model->application_model->election_in_future9 = $model->election_in_future9;
                            }
                        }
                        $model->application_model->major_deficiencies_applicant_competent_leadership1 = $model->major_deficiencies_applicant_competent_leadership1;
                        $model->application_model->major_deficiencies_applicant_competent_leadership2 = $model->major_deficiencies_applicant_competent_leadership2;
                        $model->application_model->major_deficiencies_applicant_competent_leadership3 = $model->major_deficiencies_applicant_competent_leadership3;
                        $model->application_model->major_deficiencies_applicant_competent_leadership4 = $model->major_deficiencies_applicant_competent_leadership4;
                        $model->application_model->major_deficiencies_applicant_competent_leadership5 = $model->major_deficiencies_applicant_competent_leadership5;
                        $model->application_model->major_deficiencies_applicant_competent_leadership6 = $model->major_deficiencies_applicant_competent_leadership6;
                        $model->application_model->major_deficiencies_applicant_competent_leadership7 = $model->major_deficiencies_applicant_competent_leadership7;
                        $model->application_model->major_deficiencies_applicant_competent_leadership8 = $model->major_deficiencies_applicant_competent_leadership8;
                        $model->application_model->applicants_guess_their_role_as_wada_sakhi = $model->applicants_guess_their_role_as_wada_sakhi;

                        if ($model->application_model->form_number == 3) {
                            $model->application_model->form_number = 4;
                            $model->application_model->form4_date_time = new \yii\db\Expression('NOW()');
                        }
                    }
                    if ($model->scenario == 'section5') {
                        $this->message = 'Section 5 : मल्टी-सेक्टर सेवाओं के बारे में जानकारी सफलता पूर्वक प्राप्त हुआ';
                        $model->application_model->applicant_know_different_schemes_their_provisions = $model->applicant_know_different_schemes_their_provisions;
                        $model->application_model->applicants_know_about_following_schemes1 = $model->applicants_know_about_following_schemes1;
                        if ($model->applicants_know_about_following_schemes1 == 1) {
                            $model->application_model->applicants_know_about_following_schemes1_the_gain = $model->applicants_know_about_following_schemes1_the_gain;
                        }
                        $model->application_model->applicants_know_about_following_schemes2 = $model->applicants_know_about_following_schemes2;
                        if ($model->applicants_know_about_following_schemes2 == 1) {
                            $model->application_model->applicants_know_about_following_schemes2_the_gain = $model->applicants_know_about_following_schemes2_the_gain;
                        }
                        $model->application_model->applicants_know_about_following_schemes3 = $model->applicants_know_about_following_schemes3;
                        if ($model->applicants_know_about_following_schemes3 == 1) {
                            $model->application_model->applicants_know_about_following_schemes3_the_gain = $model->applicants_know_about_following_schemes3_the_gain;
                        }
                        $model->application_model->applicants_know_about_following_schemes4 = $model->applicants_know_about_following_schemes4;
                        if ($model->applicants_know_about_following_schemes4 == 1) {
                            $model->application_model->applicants_know_about_following_schemes4_the_gain = $model->applicants_know_about_following_schemes4_the_gain;
                        }
                        $model->application_model->applicants_know_about_following_schemes5 = $model->applicants_know_about_following_schemes5;
                        if ($model->applicants_know_about_following_schemes5 == 1) {
                            $model->application_model->applicants_know_about_following_schemes5_the_gain = $model->applicants_know_about_following_schemes4_the_gain;
                        }
                        $model->application_model->applicant_himself_beneficiary_these_schemes = $model->applicant_himself_beneficiary_these_schemes;
                        $model->application_model->whethe_members_beneficiaries_of_these_schemes = $model->whethe_members_beneficiaries_of_these_schemes;
                        $model->application_model->eligibility_level_of_such_schemes = $model->eligibility_level_of_such_schemes;
                        $model->application_model->think_about_need_wada_sakhi = $model->think_about_need_wada_sakhi;
                        if ($model->application_model->form_number == 4) {
                            $model->application_model->form_number = 5;
                            $model->application_model->form5_date_time = new \yii\db\Expression('NOW()');
                        }
                    }
                    if ($model->scenario == 'section6') {
                        $this->message = 'Section 6 जानकारी सफलता पूर्वक प्राप्त हुआ';
                        $model->application_model->mobile_feature1 = $model->mobile_feature1;
                        $model->application_model->mobile_feature2 = $model->mobile_feature2;
                        $model->application_model->mobile_feature3 = $model->mobile_feature3;
                        $model->application_model->mobile_feature4 = $model->mobile_feature4;
                        $model->application_model->mobile_feature5 = $model->mobile_feature5;
                        $model->application_model->mobile_feature6 = $model->mobile_feature6;
                        $model->application_model->mobile_feature7 = $model->mobile_feature7;
                        $model->application_model->mobile_feature8 = $model->mobile_feature8;
                        $model->application_model->mobile_feature_benefit = $model->mobile_feature_benefit;
                        $model->application_model->any_proble_filling_form = $model->any_proble_filling_form;
                        $model->application_model->pay_type = $model->pay_type;
                        $model->application_model->pay = $model->pay;
                        $model->application_model->pay_amount = 0;

                        if ($model->pay_type && $model->pay == 1) {
                            $pay_amount = 'pay_amount' . $model->pay_type;
                            $model->application_model->pay_amount = $model->$pay_amount;
                        }


                        if ($model->application_model->form_number == 5) {
                            $model->application_model->form_number = 6;
                            $model->application_model->form6_date_time = new \yii\db\Expression('NOW()');
                        }
                    }
                    if ($model->application_model->save(false)) {
                        if ($model->application_model->application_id == null) {
                            $model->application_model->application_id = 'UPWADA' . \common\helpers\Utility::add_leading_zero($model->application_model->id, 6);
                            $model->application_model->update();
                        }
                        if ($model->application_model->form_number == 6) {
                            $model->application_model->status = 2;
                            $model->application_model->update();
                        }
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        \Yii::$app->session->setFlash('success', $this->message);
                        return ['success' => true];
                    } else {
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ActiveForm::validate($model->application_model);
                    }
                }
            } else {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        } else {
            $shg_model = $this->findModel($shgid);
            $model = new \common\models\wada\form\ApplicationForm($shg_model);
            $model->scenario = 'section' . $section;
            $model->cbo_shg_id = $shgid;
            $model->profile_photo_id = 'wap-profile_photo-user_id-'.Yii::$app->user->identity->id.'-cbo_shg_id-'.$shgid.'-'.bin2hex(random_bytes(10)) . time();
            $model->aadhar_front_photo_id = 'wap-aadhar_front_photo-user_id-'.Yii::$app->user->identity->id.'-cbo_shg_id-'.$shgid.'-'.bin2hex(random_bytes(10)) . time();
            $model->aadhar_back_photo_id = 'wap-aadhar_back_photo-user_id-'.Yii::$app->user->identity->id.'-cbo_shg_id-'.$shgid.'-'.bin2hex(random_bytes(10)) . time();
            $model->pan_photo_id = 'wap-pan_photo-user_id-'.Yii::$app->user->identity->id.'-cbo_shg_id-'.$shgid.'-'.bin2hex(random_bytes(10)) . time();
            $model->passbook_photo_id = 'wap-passbook_photo-user_id-'.Yii::$app->user->identity->id.'-cbo_shg_id-'.$shgid.'-'.bin2hex(random_bytes(10)) . time();
            
            return $this->render('section_' . $section, ['model' => $model]);
        }
    }

    public function actionView($shgid) {
        $shg_model = $this->findModel($shgid);
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $model = new \common\models\wada\form\ApplicationForm($shg_model);
            if ($model->load(Yii::$app->request->post())) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    $model->application_model->status = 2;
                    if ($model->application_model->save(false)) {

                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        $this->message = 'फॉर्म डेटा सफलतापूर्वक सहेजा गया';
                        \Yii::$app->session->setFlash('success', $this->message);
                        return ['success' => true, 'message' => 'फॉर्म डेटा सफलतापूर्वक सहेजा गया', 'webview' => false];
                    } else {
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ActiveForm::validate($model->application_model);
                    }
                }
            }
        } else {
            $shg_model = $this->findModel($shgid);
            $model = new \common\models\wada\form\ApplicationForm($shg_model);
            $model->cbo_shg_id = $shgid;
            return $this->render('view', ['model' => $model]);
        }
    }

    protected function findModel($id) {
        if (($model = RishtaShg::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Payment Page 
     *
     * @param [type] $shgid
     * @return void
     */
    public function actionSaveimage($shgid) {
        $shg_model = $this->findModel($shgid);
        $model = new \common\models\wada\form\ApplicationForm($shg_model);
        if (isset($model->user_model->cboprofile) and $model->user_model->cboprofile->folder_prefix) {
            $model->folder_prefix = $model->user_model->cboprofile->folder_prefix;
        } else {
            $model->folder_prefix = $model->shg_model->block_code;
        }
        $model->application_model->folder_prefix = $model->folder_prefix;
        $model->application_model->name = $model->name;
        $model->application_model->mobile_number = $model->mobile_number;
        $model->application_model->cbo_shg_id = $model->shg_model->id;
        $model->application_model->user_id = Yii::$app->user->identity->id;
        $model->application_model->division_code = $model->shg_model->division_code;
        $model->application_model->division_name = $model->shg_model->division_name;
        $model->application_model->district_code = $model->shg_model->district_code;
        $model->application_model->district_name = $model->shg_model->district_name;
        $model->application_model->block_code = $model->shg_model->block_code;
        $model->application_model->block_name = $model->shg_model->block_name;
        $model->application_model->gram_panchayat_code = $model->shg_model->gram_panchayat_code;
        $model->application_model->gram_panchayat_name = $model->shg_model->gram_panchayat_name;
        $model->application_model->cbo_shg_member_id = $model->cbo_shg_member_id;
        $APPLICATION_FORM_FILE_FOLDER = \Yii::$app->params['datapath'];
        if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo')) {
            mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo');
            chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo', 0777);
        }
        if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/member')) {
            mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/member');
            chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/member', 0777);
        }
        if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->application_model->folder_prefix)) {
            mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->application_model->folder_prefix);
            chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->application_model->folder_prefix, 0777);
        }

        if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->application_model->folder_prefix . '/' . $model->application_model->user_id)) {
            mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->application_model->folder_prefix . '/' . $model->application_model->user_id);
            chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->application_model->folder_prefix . '/' . $model->application_model->user_id, 0777);
        }
        $APPLICATION_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/' . $model->application_model->folder_prefix . '/' . $model->application_model->user_id;
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if (isset(\Yii::$app->request->post()['file']) and \Yii::$app->request->post()['file_name']) {
                $file = \Yii::$app->request->post()['file'];
                $file_name = \Yii::$app->request->post()['file_name'];
                $content = base64_decode($file);
                $im = imagecreatefromstring($content);
                $image_name = $file_name . '_' . uniqid() . '.jpg';
                $model->application_model->$file_name = $image_name;
                if ($im !== false) {
                    header('Content-Type: image/jpeg');
                    imagejpeg($im, $APPLICATION_FILE_FOLDER . '/' . $image_name);
                    chmod($APPLICATION_FILE_FOLDER . '/' . $image_name, 0777);
                    try {
                        $file = new FileHelpers();
                        $file->file_path = $APPLICATION_FILE_FOLDER;
                        $file->file_name = $image_name;
                        $file->upload();
                        imagedestroy($im);
                    } catch (\Exception $ex) {
                        
                    }
                    if ($model->application_model->save(false)) {
                        return ['success' => true];
                    }
                } else {
                    return ['success' => false];
                }
            } else {
                return ['success' => false];
            }
        }
    }

    public function actionMakepayment($shgid) {
        $shg_model = $this->findModel($shgid);
        $wada_model = new \common\models\wada\form\ApplicationForm($shg_model);

        $model = new \common\models\wada\paytm\form\WadaPaytmLogForm();
        $model->cbo_shg_id = $shg_model->id;
        $model->amount = $wada_model->application_model->pay_amount;

        // if ($model->load(Yii::$app->request->post())) {
        $paytm = new PaytmConfig();
        $paytm->run();
        $orderId = time() . $shg_model->id;
        $custId = $shg_model->id;
        $mobileNo = "7777777777";
        $email = "username@emailprovider.com";
        if ($model->validate()) {
            $paytmParams = array();
            $paytmParams["ORDER_ID"] = $orderId;
            $paytmParams["CUST_ID"] = $custId;
            $paytmParams["MOBILE_NO"] = $mobileNo;
            $paytmParams["EMAIL"] = $email;
            $paytmParams["MID"] = $paytm->PAYTM_MERCHANT_MID;
            $paytmParams["CHANNEL_ID"] = $paytm->PAYTM_CHANNEL_ID;
            $paytmParams["WEBSITE"] = $paytm->PAYTM_MERCHANT_WEBSITE;
            $paytmParams["INDUSTRY_TYPE_ID"] = $paytm->PAYTM_INDUSTRY_TYPE_ID;
            $paytmParams["CALLBACK_URL"] = $paytm->PAYTM_CALLBACK_URL;
            $paytmChecksum = PaytmChecksum::generateSignature($paytmParams, $paytm->PAYTM_MERCHANT_KEY);
            $transactionURL = $paytm->PAYTM_TXN_URL;
            $paytmParams["TXN_AMOUNT"] = $model->amount;
            $model->paytemlog_model->amount = $model->amount;
            $model->paytemlog_model->mid = $paytm->PAYTM_MERCHANT_MID;
            $model->paytemlog_model->orderid = $orderId;
            $model->paytemlog_model->shg_id = $model->cbo_shg_id;
            $model->paytemlog_model->application_id = $wada_model->application_model->id;

            $paytmChecksum = PaytmChecksum::generateSignature($paytmParams, $paytm->PAYTM_MERCHANT_KEY);

            if ($model->paytemlog_model->save(false)) {

                return $this->render('payment', [
                            'paytmParams' => $paytmParams,
                            'paytmChecksum' => $paytmChecksum,
                            'transactionURL' => $transactionURL,
                            'shg_model' => $shg_model,
                            'model' => $model,
                            'wada_model' => $wada_model->application_model
                ]);
            }
        }
        // }
        // return $this->render(
        //     'makepayment',
        //     [
        //         'model' => $model,
        //         'shg_model' => $shg_model
        //     ]
        // );
    }

    /**
     * Get Response
     *
     * @return void
     */
    // public function actionPaymentresponse()
    // {
    //     $paytm = new PaytmConfig();
    //     $paytm->run();
    //     $paytmChecksum = "";
    //     $paramList = array();
    //     $isValidChecksum = "FALSE";
    //     $paramList = $_POST;
    //     $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : "";
    //     $isValidChecksum = PaytmChecksum::verifySignature($paramList, $paytm->PAYTM_MERCHANT_KEY, $paytmChecksum);
    //     if ($isValidChecksum == "TRUE") {
    //         $model = \common\models\wada\paytm\WadaPaytmLog::find()->where(['orderid' => $_POST['ORDERID']])->one();
    //         if (!$model) {
    //             $model = new \common\models\wada\paytm\WadaPaytmLog();
    //         }
    //         $model->txnid = isset($_POST['TXNID']) ? $_POST['TXNID'] : '';
    //         $model->txndate = isset($_POST['TXNDATE']) ? $_POST['TXNDATE'] : Null;
    //         $model->respcode = isset($_POST['RESPCODE']) ? $_POST['RESPCODE'] : '';
    //         $model->currency = isset($_POST['CURRENCY']) ? $_POST['CURRENCY'] : '';
    //         $model->gatewayname = isset($_POST['GATEWAYNAME']) ? $_POST['GATEWAYNAME'] : '';
    //         $model->respmsg = isset($_POST['RESPMSG']) ? $_POST['RESPMSG'] : '';
    //         $model->bankname = isset($_POST['BANKNAME']) ? $_POST['BANKNAME'] : '';
    //         $model->banktxnid = isset($_POST['BANKTXNID']) ? $_POST['BANKTXNID'] : '';
    //         $model->checksumhash = isset($_POST['CHECKSUMHASH']) ? $_POST['CHECKSUMHASH'] : '';
    //         $model->status_msg = isset($_POST['STATUS']) ? $_POST['STATUS'] : '';
    //         if (isset($_POST["STATUS"]) && $_POST["STATUS"] == "TXN_SUCCESS") {
    //             $model->status = 1;
    //         } else {
    //             $model->status = 0;
    //         }
    //         if ($model->save(false)) {
    //             $shg_model = $this->findModel($model->shg_id);
    //             $wada_model = new \common\models\wada\form\ApplicationForm($shg_model);
    //             if ($model->status == 1) {
    //                 $wada_model->application_model->is_amount_pay = 1;
    //                 $wada_model->application_model->amount_pay_datetime = $model->txndate;
    //                 $wada_model->application_model->amount_pay_datetime = $model->txndate;
    //                 $wada_model->application_model->amount_txnid = $model->txnid;
    //                 $wada_model->application_model->status = 2;
    //                 $wada_model->application_model->save(false);
    //             }
    //         }
    //         return $this->render('paymentresponse', [
    //             'isValidChecksum' => $isValidChecksum,
    //             'model' => $model
    //         ]);
    //     } else {
    //         echo "<b>Checksum mismatched.</b>";
    //         //Process transaction as suspicious.
    //     }
    // }
}
