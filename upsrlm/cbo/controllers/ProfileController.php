<?php

namespace cbo\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\form\UserProfileForm;
use yii\web\UploadedFile;

class ProfileController extends Controller {

    public function beforeAction($action) {

        if (!parent::beforeAction($action)) {
            return false;
        }

        // other custom code here

        return true; // or false to not run the action
    }

    /**
     * Lists all Application models.
     *
     * @return mixed
     */
    public function actionUpdate($userid = null) {
        if ($userid == null) {
            if (isset(\Yii::$app->user->identity->id))
                $userid = \Yii::$app->user->identity->id;
            else {
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/page/home')->send();
                exit;
            }
        }
        $model = new UserProfileForm($userid);
        // $model->setScenario(UserProfileForm::SCENARIOSAVE);

        if ($model->profle_model->is_profile_complete == "1") {
            return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['cbo'] . '/profile/view?userid=' . $userid)->send();
            exit;
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->profle_model->first_name = $model->first_name;
            $model->profle_model->middle_name = $model->middle_name;
            $model->profle_model->sur_name = $model->sur_name;
            $model->profle_model->father_name = $model->father_name;
            $model->profle_model->gender = $model->gender;
            //$model->profle_model->date_of_birth = $model->date_of_birth;
            $model->profle_model->date_of_birth = \common\helpers\Utility::DateFormatForDb($model->date_of_birth);
            $model->profle_model->pan_number = $model->pan_number;
            $model->profle_model->aadhaar_number = $model->aadhaar_number;

            $model->profle_model->primary_phone_no = $model->primary_phone_no;
            $model->profle_model->alternate_phone_no = $model->alternate_phone_no;
            $model->profle_model->whatsapp_no = $model->whatsapp_no;
            $model->profle_model->email_id = $model->email_id;

            $model->profle_model->present_address_house_no = $model->present_address_house_no;
            $model->profle_model->present_address_street_mohalla = $model->present_address_street_mohalla;
            $model->profle_model->present_address_postoffice = $model->present_address_postoffice;
            $model->profle_model->present_address_district = $model->present_address_district;
            $model->profle_model->present_address_state = $model->present_address_state;

            $model->profle_model->permanent_address_house_no = $model->permanent_address_house_no;
            $model->profle_model->permanent_address_street_mohalla = $model->permanent_address_street_mohalla;
            $model->profle_model->permanent_address_postoffice = $model->permanent_address_postoffice;
            $model->profle_model->permanent_address_district = $model->permanent_address_district;
            $model->profle_model->permanent_address_state = $model->permanent_address_state;


            $model->profle_model->designation = $model->designation;
            $model->profle_model->date_of_joining = \common\helpers\Utility::DateFormatForDb($model->date_of_joining);
            $model->profle_model->date_of_last_posting = \common\helpers\Utility::DateFormatForDb($model->date_of_last_posting);
            $model->profle_model->posting_block_code = $model->posting_block_code;
            $model->profle_model->posting_district_code = $model->posting_district_code;
            $block = \common\models\master\MasterBlock::findOne(['block_code' => $model->posting_block_code]);
            $model->profle_model->posting_block_name = $block != null ? $block->block_name : "";
            $model->profle_model->posting_district_name = $block != null ? $block->district_name : "";

            $model->profle_model->bank_name = $model->bank_name;
            $model->profle_model->bank_branch = $model->bank_branch;
            $model->profle_model->bank_account_number = $model->bank_account_number;
            $model->profle_model->bank_ifsc_code = $model->bank_ifsc_code;

            $array = [];
            if ($model->profle_model->posting_district_code != null) {
                $searchModel = new \common\models\master\MasterBlockSearch();
                $searchModel->district_code = $model->profle_model->posting_district_code;
                $dataProvider = $searchModel->search($searchModel, Yii::$app->user->identity, false);
                $models = $dataProvider->getModels();
                if ($models != NULL) {
                    foreach ($models as $model1) {
                        $array[$model1->block_code] = $model1->block_name;
                    }
                }
                $model->block_option = $array;
            }
            if ($model->profle_model->validate()) {
                $model->profle_model->save(false);
            } else {
                //print_r($model->profle_model->errors);
                //exit;
            }

//            if ($model->validate()) {
//                
//            }
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    public function actionView($userid = null) {
        if ($userid == null) {
            if (isset(\Yii::$app->user->identity->id))
                $userid = \Yii::$app->user->identity->id;
            else {
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/page/home')->send();
                exit;
            }
        }
        $model = new UserProfileForm($userid);
        $profile_complete = false;
        $profile_complete = $model->profle_model->chcekProfileStatus();
        // $model->setScenario(UserProfileForm::SCENARIOSAVE);

        if (Yii::$app->request->post()) {

            if ($profile_complete) {
                $model->profle_model->is_profile_complete = 1;
                if ($model->profle_model->validate()) {
                    $model->profle_model->save(false);
                } else {
                    //print_r($model->profle_model->errors);
                    //exit;
                }
            } else {
                Yii::$app->getSession()->setFlash('warning', "All fields are mandatory. Please complete the profile");
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['cbo'] . '/profile/update?userid=' . $userid)->send();
                exit;
            }
        }

        return $this->render('view', [
                    'model' => $model,
                    'profile_complete' => $profile_complete,
        ]);
    }

    public function actionUploadfile($userid = null, $file_type = null) {
        if ($userid == null) {
            if (isset(\Yii::$app->user->identity->id)) {
                $userid = \Yii::$app->user->identity->id;
                $model_profile = new UserProfileForm($userid);
            } else {
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/page/home')->send();
                exit;
            }
        } else {
            if (isset(\Yii::$app->user->identity->id)) {
                $userid = \Yii::$app->user->identity->id;
                $model_profile = new UserProfileForm($userid);
            } else {
                return Yii::$app->getResponse()->redirect(Yii::$app->params['app_url']['www'] . '/page/home')->send();
                exit;
            }
        }
        $model = new \common\models\form\UserFileForm();
        $model->file_type = $file_type;
        $model->user_id = \Yii::$app->user->identity->id;

        if ($model->load(Yii::$app->request->post())) {
            $model->image_file = UploadedFile::getInstance($model, 'image_file');

            if ($model->image_file != null) {
                $tmp_image_file = $model->file_type . "_" . $model->image_file->name . date("Y_m_d_H-m-s") . "." . $model->image_file->extension;

                $FOLDER = Yii::$app->params['datapath'] . 'user_profile/';
                $FOLDER = $FOLDER . $model->user_id . '/';

                if (!file_exists($FOLDER)) {
                    mkdir($FOLDER);
                    chmod($FOLDER, 0777);
                }
            }
            if ($model->validate()) {
                $model->image_file->saveAs($FOLDER . '/' . $tmp_image_file);
                chmod($FOLDER . '/' . $tmp_image_file, 0777);
                if ($model->file_type == "1") {
                    $model_profile->profle_model->photo_profile = $tmp_image_file;
                } else if ($model->file_type == "2") {
                    $model_profile->profle_model->photo_pan = $tmp_image_file;
                } else if ($model->file_type == "3") {
                    $model_profile->profle_model->photo_aadhaar_front = $tmp_image_file;
                } else if ($model->file_type == "4") {
                    $model_profile->profle_model->photo_aadhaar_back = $tmp_image_file;
                } else if ($model->file_type == "5") {
                    $model_profile->profle_model->photo_bank_passbook = $tmp_image_file;
                } else if ($model->file_type == "6") {
                    $model_profile->profle_model->photo_letter_of_appointment = $tmp_image_file;
                } else if ($model->file_type == "7") {
                    $model_profile->profle_model->photo_service_agreement = $tmp_image_file;
                } else if ($model->file_type == "8") {
                    $model_profile->profle_model->photo_letter_of_last_posting_order = $tmp_image_file;
                }

                $model_profile->profle_model->save(false);
                Yii::$app->getSession()->setFlash('success', "File Uploaded successfully.");
                return $this->renderPartial('file_upload', [
                            'model' => $model,
                            'model_profile' => $model_profile,
                            'status' => '1'
                ]);
            }
        }

        return $this->renderPartial('file_upload', [
                    'model' => $model,
                    'model_profile' => $model_profile,
                    'status' => '0'
        ]);
    }

}
