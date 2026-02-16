<?php

namespace cbo\modules\shg\controllers;

use Yii;
use cbo\models\Shg;
use cbo\models\ShgSearch;
use app\modules\shg\models\form\ShgForm;
use cbo\models\form\ShgVerifyForm;
use common\models\base\GenralModel;
use cbo\models\form\ShgVerifyCSTForm;
use cbo\models\CboMasterMemberDesignation;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\master\MasterRole;
use kartik\mpdf\Pdf;
use Mpdf\Mpdf;
use yii\web\UploadedFile;
use yii\base\Model;

ini_set('memory_limit', '-1');

/**
 * Default controller for the `shg` module
 */
class DefaultController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message = '';

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'verify', 'return','urban'],
                'rules' => [
                    [
                        'actions' => ['index', 'view','urban'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU, MasterRole::ROLE_SMMU, MasterRole::ROLE_YOUNG_PROFESSIONAL, MasterRole::ROLE_MD, MasterRole::ROLE_DC_NRLM, MasterRole::ROLE_CDO, MasterRole::ROLE_WADA_ADMIN]));
                        }
                    ],
                    [
                        'actions' => ['verify'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_YOUNG_PROFESSIONAL, MasterRole::ROLE_DMMU]));
                        }
                    ],
                    [
                        'actions' => ['return'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN]));
                        }
                    ],
                    [
                        'actions' => ['create', 'update'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_ADMIN, MasterRole::ROLE_BMMU, MasterRole::ROLE_DMMU]));
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $searchModel = new ShgSearch();
        $searchModel->urban_shg = 0;
        if (in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_WADA_ADMIN])) {
            $searchModel->wada = 1;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $searchModel->block_option = GenralModel::optionblock($searchModel);
        $searchModel->district_option = GenralModel::nfsaoptiondistrict($searchModel);
        if ($searchModel->block_code) {
            $searchModel->gp_option = GenralModel::nfsaoptiongp($searchModel);
        }
        $searchModel->verify_option = [1 => 'Member detail correct', 2 => 'Member detail wrong'];
        $searchModel->verify_other_option = [1 => 'SHG detail correct', 2 => 'SHG detail wrong or skip'];
        $searchModel->return_option = [1 => 'Return'];
        if (isset($searchModel->return) and $searchModel->return != '') {
            $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.verification_status' => 1]);
            $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.verify_mobile_no' => 2]);
        }
        $searchModel1 = new ShgSearch();
        $searchModel1->urban_shg = 0;
        $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider1->query->andWhere([Shg::getTableSchema()->fullName . '.status' => [1, 2]]);
        $searchModel2 = new ShgSearch();
        $searchModel2->urban_shg = 0;
        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider2->query->andWhere([Shg::getTableSchema()->fullName . '.status' => 2]);

        $searchModel3 = new ShgSearch();
        $searchModel3->urban_shg = 0;
        $dataProvider3 = $searchModel3->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);

        $dataProvider3->query->andWhere([Shg::getTableSchema()->fullName . '.status' => 1]);

        $searchModel4 = new ShgSearch();
        $searchModel4->urban_shg = 0;
        $dataProvider4 = $searchModel4->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider4->query->andWhere(['>', Shg::getTableSchema()->fullName . '.verification_status', 0]);
        $dataProvider4->query->andWhere([Shg::getTableSchema()->fullName . '.verify_shg_all' => 2]);

        $searchModel5 = new ShgSearch();
        $searchModel5->urban_shg = 0;
        $dataProvider5 = $searchModel5->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider5->query->andWhere(['>', Shg::getTableSchema()->fullName . '.verification_status', 0]);
        $dataProvider5->query->andWhere([Shg::getTableSchema()->fullName . '.verify_mobile_no' => 1]);

        $searchModel6 = new ShgSearch();
        $searchModel6->urban_shg = 0;
        $dataProvider6 = $searchModel6->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider6->query->andWhere(['>', Shg::getTableSchema()->fullName . '.verification_status', 0]);
        $dataProvider6->query->andWhere([Shg::getTableSchema()->fullName . '.verify_mobile_no' => 2]);
        $button_type = isset($_GET['button_type']) ? ($_GET['button_type']) : "";
        if ($button_type == "1") {
            $dataProvider = $dataProvider1;
        } elseif ($button_type == "2") {
            $dataProvider = $dataProvider2;
        } elseif ($button_type == "3") {
            $dataProvider = $dataProvider3;
        } elseif ($button_type == "4") {
            $dataProvider = $dataProvider4;
        } elseif ($button_type == "5") {
            $dataProvider = $dataProvider5;
        } elseif ($button_type == "6") {
            $dataProvider = $dataProvider6;
        }
        return $this->render('index', [
                    'button_type' => $button_type,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvider1' => $dataProvider1,
                    'dataProvider2' => $dataProvider2,
                    'dataProvider3' => $dataProvider3,
                    'dataProvider4' => $dataProvider4,
                    'dataProvider5' => $dataProvider5,
                    'dataProvider6' => $dataProvider6,
        ]);
    }

    public function actionUrban() {
        $searchModel = new ShgSearch();
        $searchModel->urban_shg = 1;
        if (in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_WADA_ADMIN])) {
            $searchModel->wada = 1;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $button_type = '';
        return $this->render('urban', [
                    'button_type' => $button_type,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionVerify($shgid) {
        $shg_model = $this->findModel($shgid);

        $model = new ShgVerifyForm($shg_model);

        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {

            $model->shg_model->verify_by = Yii::$app->user->identity->id;
            if ($model->verify_chaire_person_mobile_no == 1 and $model->verify_secretary_mobile_no == 1 and $model->verify_treasurer_mobile_no == 1) {
                $model->shg_model->verify_mobile_no = 1;
            } else {
                $model->shg_model->verify_mobile_no = 2;
            }
            $model->shg_model->verify_chaire_person_mobile_no = $model->verify_chaire_person_mobile_no;
            $model->shg_model->verify_secretary_mobile_no = $model->verify_secretary_mobile_no;
            $model->shg_model->verify_treasurer_mobile_no = $model->verify_treasurer_mobile_no;
            $model->shg_model->verify_shg_code = $model->verify_shg_code;
            $model->shg_model->verify_shg_location = $model->verify_shg_location;
            $model->shg_model->verify_shg_name = $model->verify_shg_name;
            $model->shg_model->verify_shg_members = $model->verify_shg_members;
            if ($model->verify_shg_name == 1 and $model->verify_shg_code == 1 and $model->verify_shg_location == 1 and $model->verify_shg_members == 1) {
                $model->shg_model->verify_other = 1;
            } else {
                $model->shg_model->verify_other = 2;
            }

            if ($model->shg_model->verify_mobile_no == 1 and $model->shg_model->verify_other == 1) {
                $model->shg_model->verify_shg_all = 1;
            } else {
                $model->shg_model->verify_shg_all = 2;
            }
            $model->shg_model->verify_datetime = new \yii\db\Expression('NOW()');
            $model->shg_model->status = 2;
            $model->shg_model->verification_status = ($model->shg_model->verification_status + 1);
            $model->shg_model->update();
            //Yii::$app->getSession()->setFlash('success', $this->message);
            return $this->redirect(['/shg?button_type=3']);
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_verifyform', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_verifyform', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Displays a single Shg model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($shgid) {
        return $this->render('view', [
                    'model' => $this->findModel($shgid),
        ]);
    }

    /**
     * Creates a new Shg model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate() {
//        Yii::$app->getSession()->setFlash('warning', "Not Allowed ");
//        return $this->redirect(['index']);
//        $model = new ShgForm();
//        if (in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) {
//            $model->scenario = 'admincreate';
//        }
//        if ($model->load(Yii::$app->request->post())) {
//            $model->passbook_photo = UploadedFile::getInstance($model, 'passbook_photo');
//            if ($model->validate()) {
//                $model->save();
//                return $this->redirect(['/shg']);
//            }
//        }
//
//        return $this->render('create', [
//                    'model' => $model,
//        ]);
//    }
    public function actionCreate() {
        $model = new \cbo\models\form\ShgNewFORM();
//        return $this->redirect(['index']);
        if (Yii::$app->request->isPost) {

            if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($model->shg_member_model, Yii::$app->request->post()) and $model->validate() && Model::validateMultiple($model->shg_member_model)) {
                $valid = true;
                $dulicate_entry_array = [];

                foreach ($model->shg_member_model as $member) {

                    if (in_array($member->mobile, $dulicate_entry_array)) {
                        $valid = FALSE;
                    }
                    if (!$valid) {
                        $model->shg_member_model[$member->role]->addError("mobile", "Mobile Number repeat");
                    }
                    array_push($dulicate_entry_array, $member->mobile);
                }
                if ($valid) {
                    if ($model->save()) {
                        return $this->redirect(['/shg']);
                    }
                }
            } else {
                
            }
        }
        return $this->render('create_new', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Shg model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($shgid) {
        $shg_model = $this->findModel($shgid);
        $model = new \cbo\models\form\ShgNewFORM($shg_model);
        if ((in_array($shg_model->block_code, \yii\helpers\ArrayHelper::getColumn(Yii::$app->user->identity->blocks, 'block_code')) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BMMU])) or in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) {
            if (($shg_model->status == 0 or ($shg_model->status == 2 and ($shg_model->verify_mobile_no == 2 or $shg_model->verify_shg_location == 2 or $shg_model->verify_shg_name == 2 or $shg_model->verify_shg_members == 2 or $shg_model->verify_shg_code == 2)))) {
                
            } else {
                Yii::$app->getSession()->setFlash('error', "Not Allowed - SHG already verified or submitted");
                return $this->redirect(['index']);
            }
        } else {
            Yii::$app->getSession()->setFlash('error', "Not Allowed - Permission denied");
            return $this->redirect(['index']);
        }
//        
        if (Yii::$app->request->isPost) {

            if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($model->shg_member_model, Yii::$app->request->post()) and $model->validate() && Model::validateMultiple($model->shg_member_model)) {
                $valid = true;
                $dulicate_entry_array = [];

                foreach ($model->shg_member_model as $member) {

                    if (in_array($member->mobile, $dulicate_entry_array)) {
                        $valid = FALSE;
                    }
                    if (!$valid) {
                        $model->shg_member_model[$member->role]->addError("mobile", "Mobile Number repeat");
                    }
                    array_push($dulicate_entry_array, $member->mobile);
                }
                if ($valid) {
                    if ($model->save()) {
                        return $this->redirect(['/shg']);
                    }
                }
            } else {
                
            }
        }
        return $this->render('update_new', [
                    'model' => $model,
        ]);
    }

//    public function actionUpdate($shgid) {
//        $shg_model = $this->findModel($shgid);
//        Yii::$app->getSession()->setFlash('warning', "Not Allowed ");
//        return $this->redirect(['index']);
//        if ((in_array($shg_model->block_code, \yii\helpers\ArrayHelper::getColumn(Yii::$app->user->identity->blocks, 'block_code')) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_BMMU])) and $shg_model->edit_bmmu == '1' or in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) {
//            if ($shg_model->verify_over_all == '1' and $shg_model->shg_code) {
//                Yii::$app->getSession()->setFlash('error', "Not Allowed - Permission denied");
//                return $this->redirect(['index']);
//            }
//        } else {
//            Yii::$app->getSession()->setFlash('error', "Not Allowed - Permission denied");
//            return $this->redirect(['index']);
//        }
//        if ($shg_model->verify_mobile_no == "1" and $shg_model->return == 0 and $shg_model->shg_code) {
//            Yii::$app->getSession()->setFlash('error', "Not Allowed - SHG already verified");
//            return $this->redirect(['index']);
//        }
//
//        $model = new ShgForm($shg_model);
//        if (in_array(\Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN])) {
//            $model->scenario = 'adminupdate';
//        }
//        if ($model->load(Yii::$app->request->post())) {
//            $model->passbook_photo = UploadedFile::getInstance($model, 'passbook_photo');
//            if ($model->passbook_photo == null) {
//                $model->passbook_photo = $shg_model->passbook_photo;
//            }
//            if ($model->validate()) {
//                $model->save();
//                return $this->redirect(['/shg']);
//            }
//        }
//
//        return $this->render('update', [
//                    'model' => $model,
//        ]);
//    }

    /**
     * Deletes an existing Shg model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        //$this->findModel($id)->delete();

        return $this->redirect(['/shg']);
    }

    public function actionReturn($shgid) {
        $model = $this->findModel($shgid);
        $model->return = 1;
        if ($model->save()) {
            return $this->redirect(['/shg']);
        }
    }

    public function actionMemberverificaton($shgid, $designation, $mobile_no) {
        $shg_model = $this->findModel($shgid);
        $model = new \common\models\dynamicdb\internalcallcenter\form\ShgCallForm($shg_model, $designation, $mobile_no);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {
            $log_model = new \common\models\dynamicdb\cbo_detail\RishtaShgMemberVerificationFormLog();
            $log_model->cbo_shg_id = $model->cbo_shg_id;
            $log_model->mobile_no = $model->mobile_no;
            $log_model->designation = $model->designation;
            $log_model->talk_with_shg_member = $model->talk_with_shg_member;
            $log_model->talk_with_shg_member_yes = $model->talk_with_shg_member_yes;
            $log_model->talk_with_call_center = $model->talk_with_call_center;
            $log_model->how_many_time_for_suggest_samuh_sakhi = $model->how_many_time_for_suggest_samuh_sakhi;
            $shg_user_model = new \cbo\models\form\ShgVerifyCSTForm($shg_model, $designation);
            if ($log_model->talk_with_shg_member == '1') {
                $log_model->verify = 1;
                if ($model->designation == \cbo\models\CboMasterMemberDesignation::SHG_CHAIRPERSON) {
                    $shg_user_model->verify_chaire_person = 1;
                }
                if ($model->designation == \cbo\models\CboMasterMemberDesignation::SHG_SECRETARY) {
                    $shg_user_model->verify_secretary = 1;
                }
                if ($model->designation == \cbo\models\CboMasterMemberDesignation::SHG_TREASURER) {
                    $shg_user_model->verify_treasurer = 1;
                }
            }
            if ($log_model->save() and $shg_user_model->SaveUser()) {
                return $this->redirect('/shg?ShgSearch[district_code]=' . $shg_model->district_code . '&ShgSearch[block_code]=' . $shg_model->block_code);
            }
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('_memberverifiction', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('_memberverifiction', [
                        'model' => $model,
            ]);
        }
    }

//    public function actionVerifychairperson($shgid) {
//        $shg_model = $this->findModel($shgid);
//        if ($shg_model->verify_over_all == 0 and $shg_model->verify_chaire_person == 0 and $shg_model->getProrole() == 0 and isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SUPPORT_UNIT])) {
//            
//        } else {
//            return $this->redirect(['/shg']);
//        }
//        $model = new ShgVerifyCSTForm($shg_model, CboMasterMemberDesignation::SHG_CHAIRPERSON);
//        $model->scenario = 'chairperson';
//        $model->verify_chaire_person = 2;
//        $this->performAjaxValidation($model);
//        if ($model->load(Yii::$app->request->post())) {
//            $model->shg_model->verify_shg_member_by = Yii::$app->user->identity->id;
//            $model->shg_model->verify_shg_member_datetime = new \yii\db\Expression('NOW()');
//            if ($model->verify_ques1 == '1' and $model->verify_ques2 == '1' and $model->verify_ques3 == 1) {
//                $model->verify_chaire_person = 1;
//            }
//            $model->shg_model->verify_chaire_person = $model->verify_chaire_person;
//            $model->shg_model->verify_ques1 = $model->verify_ques1;
//            $model->shg_model->verify_ques2 = $model->verify_ques2;
//            $model->shg_model->verify_ques3 = $model->verify_ques3;
//
//            if ($model->shg_model->verify_chaire_person == '1') {
//                $model->shg_model->verify_over_all = 1;
//            }
//            if ($model->SaveUser() and $model->shg_model->update()) {
//                $this->message = 'Verify Chairperson successfully';
//                Yii::$app->getSession()->setFlash('success', $this->message);
//                return $this->redirect(['/shg']);
//            }
//        }
//        if (\Yii::$app->request->isAjax) {
//
//            return $this->renderAjax('_verifychairpersonform', [
//                        'model' => $model,
//            ]);
//        } else {
//            return $this->render('_verifychairpersonform', [
//                        'model' => $model,
//            ]);
//        }
//    }
//
//    public function actionVerifysecretary($shgid) {
//        $shg_model = $this->findModel($shgid);
//        if ($shg_model->verify_over_all == 0 and $shg_model->verify_chaire_person == 2 and $shg_model->getSeorole() == 0 and isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SUPPORT_UNIT])) {
//            
//        } else {
//            return $this->redirect(['/shg']);
//        }
//        $model = new ShgVerifyCSTForm($shg_model, CboMasterMemberDesignation::SHG_SECRETARY);
//        $model->verify_secretary = 2;
//        $model->scenario = 'secretary';
//        $this->performAjaxValidation($model);
//        if ($model->load(Yii::$app->request->post())) {
//            $model->shg_model->verify_shg_member_by = Yii::$app->user->identity->id;
//            $model->shg_model->verify_shg_member_datetime = new \yii\db\Expression('NOW()');
//
//            if ($model->verify_s_ques1 == '1' and $model->verify_s_ques2 == '1' and $model->verify_s_ques3 == 1) {
//                $model->verify_secretary = 1;
//            }
//            $model->shg_model->verify_secretary = $model->verify_secretary;
//            $model->shg_model->verify_s_ques1 = $model->verify_s_ques1;
//            $model->shg_model->verify_s_ques2 = $model->verify_s_ques2;
//            $model->shg_model->verify_s_ques3 = $model->verify_s_ques3;
//
//            if ($model->shg_model->verify_secretary == '1') {
//                $model->shg_model->verify_over_all = 1;
//            }
//            if ($model->SaveUser() and $model->shg_model->update()) {
//                $this->message = 'Verify Secretary successfully';
//                Yii::$app->getSession()->setFlash('success', $this->message);
//                return $this->redirect(['/shg']);
//            }
//        }
//        if (\Yii::$app->request->isAjax) {
//
//            return $this->renderAjax('_verifysecretaryform', [
//                        'model' => $model,
//            ]);
//        } else {
//            return $this->render('_verifysecretaryform', [
//                        'model' => $model,
//            ]);
//        }
//    }
//
//    public function actionVerifytreasurer($shgid) {
//        $shg_model = $this->findModel($shgid);
//        if ($shg_model->verify_over_all == 0 and $shg_model->verify_secretary == 2 and $shg_model->getTrorole() == 0 and isset(Yii::$app->user->identity->role) and in_array(Yii::$app->user->identity->role, [MasterRole::ROLE_ADMIN, MasterRole::ROLE_SUPER_ADMIN, MasterRole::ROLE_SUPPORT_UNIT])) {
//            
//        } else {
//            return $this->redirect(['/shg']);
//        }
//        $model = new ShgVerifyCSTForm($shg_model, CboMasterMemberDesignation::SHG_TREASURER);
//        $model->verify_treasurer = 2;
//        $model->scenario = 'treasurer';
//        $this->performAjaxValidation($model);
//        if ($model->load(Yii::$app->request->post())) {
//            $model->shg_model->verify_shg_member_by = Yii::$app->user->identity->id;
//            $model->shg_model->verify_shg_member_datetime = new \yii\db\Expression('NOW()');
//            if ($model->verify_t_ques1 == '1' and $model->verify_t_ques2 == '1' and $model->verify_t_ques3 == 1) {
//                $model->verify_treasurer = 1;
//            }
//            $model->shg_model->verify_t_ques1 = $model->verify_t_ques1;
//            $model->shg_model->verify_t_ques2 = $model->verify_t_ques2;
//            $model->shg_model->verify_t_ques3 = $model->verify_t_ques3;
//
//            $model->shg_model->verify_treasurer = $model->verify_treasurer;
//            if ($model->shg_model->verify_treasurer == '1') {
//                $model->shg_model->verify_over_all = 1;
//            }
//            if ($model->SaveUser() and $model->shg_model->update()) {
//                $this->message = 'Verify Treasurer successfully';
//                Yii::$app->getSession()->setFlash('success', $this->message);
//                return $this->redirect(['/shg']);
//            }
//        }
//        if (\Yii::$app->request->isAjax) {
//
//            return $this->renderAjax('_verifytreasurerform', [
//                        'model' => $model,
//            ]);
//        } else {
//            return $this->render('_verifytreasurerform', [
//                        'model' => $model,
//            ]);
//        }
//    }

    /**
     * Finds the Shg model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shg the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Shg::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}