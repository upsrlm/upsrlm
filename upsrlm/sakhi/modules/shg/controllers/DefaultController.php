<?php

namespace sakhi\modules\shg\controllers;

use yii\web\Controller;
use cbo\models\Shg;
use cbo\models\ShgSearch;
use yii\filters\VerbFilter;
use Yii;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;

/**
 * Default controller for the `shg` module
 */
class DefaultController extends Controller {

    use \common\traits\AjaxValidationTrait;

    public $message = '';

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'remove' => ['POST'],
                ],
            ],
        ];
    }

    // public function beforeAction($action)
    // {            
    //    // if ($action->id == 'my-method') {
    //         $this->enableCsrfValidation = false;
    //    // }
    //     return parent::beforeAction($action);
    // }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    // public function actionView($shgid) {
    //     $model = Shg::findOne($shgid);
    //     return $this->render('view', ['model' => $model]);
    // }

    // public function actionFundsrecived($shgid) {
    //     return $this->render('index');
    // }

    /**
     * Profile Page of SHG
     *
     * @param [type] $shgid
     * @return void
     */
    // public function actionProfile($shgid) {

    //     $model = \cbo\models\shg\ShgProfile::find()->where(['cbo_shg_id' => $shgid])->one();
    //     $shg = Shg::findOne($shgid);
    //     if ($model) {
    //         $dataProvider = new ActiveDataProvider([
    //             'query' => \cbo\models\shg\ShgBankDetails::find()->where(['cbo_shg_id' => $shgid, 'status' => 1]),
    //             'pagination' => false,
    //         ]);
    //         return $this->render('profile', ['model' => $model, 'shg' => $shg, 'dataProvider' => $dataProvider]);
    //     } else {
    //         $this->addoldmember($shg);
    //         return $this->render('profile2', ['model' => $shg]);
    //     }
    // }

    /**
     * Add Old Member into New Table
     *
     * @param [type] $shg_model
     * @return void
     */
    // protected function addoldmember($shg_model) {
    //     $shgprofile = \cbo\models\shg\ShgProfile::find()->where(['cbo_shg_id' => $shg_model->id])->one();
    //     if (!$shgprofile) {
    //         $shgprofile = new \cbo\models\shg\ShgProfile();
    //     }
    //     $shgprofile->cbo_shg_id = $shg_model->id;
    //     $shgprofile->name_of_shg = $shg_model->name_of_shg;
    //     $shgprofile->shg_code = $shg_model->shg_code;
    //     $shgprofile->no_of_members = $shg_model->no_of_members;
    //     $shgprofile->division_code = $shg_model->division_code;
    //     $shgprofile->division_name = $shg_model->division_name;
    //     $shgprofile->district_code = $shg_model->district_code;
    //     $shgprofile->district_name = $shg_model->district_name;
    //     $shgprofile->block_code = $shg_model->block_code;
    //     $shgprofile->block_name = $shg_model->block_name;
    //     $shgprofile->gram_panchayat_code = $shg_model->gram_panchayat_code;
    //     $shgprofile->gram_panchayat_name = $shg_model->gram_panchayat_name;
    //     $shgprofile->village_code = $shg_model->village_code;
    //     $shgprofile->village_name = $shg_model->village_name;
    //     $shgprofile->hamlet = $shg_model->hamlet;
    //     $shgprofile->chaire_person_name = $shg_model->chaire_person_name;
    //     $shgprofile->chaire_person_mobile_no = $shg_model->chaire_person_mobile_no;
    //     $shgprofile->secretary_name = $shg_model->secretary_name;
    //     $shgprofile->secretary_mobile_no = $shg_model->secretary_mobile_no;
    //     $shgprofile->treasurer_name = $shg_model->treasurer_name;
    //     $shgprofile->treasurer_mobile_no = $shg_model->treasurer_mobile_no;
    //     $shgprofile->cbo_vo_id = $shg_model->cbo_vo_id;
    //     $shgprofile->shg_code = $shg_model->shg_code;
    //     if ($shgprofile->save(false)) {
    //         /**
    //          * Member One Chaire Person
    //          */
    //         $member1 = new \cbo\models\shg\ShgMembers();
    //         $member1->cbo_shg_id = $shg_model->id;
    //         $member1->name = $shg_model->chaire_person_name;
    //         $member1->mobile = $shg_model->chaire_person_mobile_no;
    //         if ($member1->save()) {
    //             $officebearers1 = new \cbo\models\shg\ShgMemberOfficeBearers();
    //             $officebearers1->cbo_shg_id = $shg_model->id;
    //             $officebearers1->cbo_shg_member_id = $member1->id;
    //             $officebearers1->role = 1;
    //             $officebearers1->save();
    //         }

    //         /**
    //          * Member Two Secretary Name
    //          */
    //         $member2 = new \cbo\models\shg\ShgMembers();
    //         $member2->cbo_shg_id = $shg_model->id;
    //         $member2->name = $shg_model->secretary_name;
    //         $member2->mobile = $shg_model->secretary_mobile_no;
    //         if ($member2->save()) {
    //             $officebearers2 = new \cbo\models\shg\ShgMemberOfficeBearers();
    //             $officebearers2->cbo_shg_id = $shg_model->id;
    //             $officebearers2->cbo_shg_member_id = $member2->id;
    //             $officebearers2->role = 2;
    //             $officebearers2->save();
    //         }


    //         /**
    //          * Member Three Treasurer Name
    //          */
    //         $member3 = new \cbo\models\shg\ShgMembers();
    //         $member3->cbo_shg_id = $shg_model->id;
    //         $member3->name = $shg_model->treasurer_name;
    //         $member3->mobile = $shg_model->treasurer_mobile_no;
    //         if ($member3->save()) {
    //             $officebearers3 = new \cbo\models\shg\ShgMemberOfficeBearers();
    //             $officebearers3->cbo_shg_id = $shg_model->id;
    //             $officebearers3->cbo_shg_member_id = $member3->id;
    //             $officebearers3->role = 3;
    //             $officebearers3->save();
    //         }
    //     }
    // }

    /**
     * Create SHG Profile
     *
     * @param [type] $shgid
     * @return void
     */
//     public function actionCreateprofile($shgid) {
//         $shg_model = \cbo\models\Shg::findOne($shgid);
//         $shgprofile = \cbo\models\shg\ShgProfile::find()->where(['cbo_shg_id' => $shgid])->one();
//         if ($shgprofile) {
//             $model = new \cbo\models\shg\form\ShgProfileForm($shgprofile);
//         } else {
//             $model = new \cbo\models\shg\form\ShgProfileForm();
//         }
//         $model->scenario = 'create';
//         $model->name_of_shg = $shg_model->name_of_shg;
//         $model->shg_code = $shg_model->shg_code;
//         $model->no_of_members = $shg_model->no_of_members;
//         $this->performAjaxValidation($model);
//         if ($model->load(Yii::$app->request->post())) {
//             $model->shg_profile_model->cbo_shg_id = $shgid;
//             $model->shg_profile_model->division_code = $shg_model->division_code;
//             $model->shg_profile_model->division_name = $shg_model->division_name;
//             $model->shg_profile_model->district_code = $shg_model->district_code;
//             $model->shg_profile_model->district_name = $shg_model->district_name;
//             $model->shg_profile_model->block_code = $shg_model->block_code;
//             $model->shg_profile_model->block_name = $shg_model->block_name;
//             $model->shg_profile_model->gram_panchayat_code = $shg_model->gram_panchayat_code;
//             $model->shg_profile_model->gram_panchayat_name = $shg_model->gram_panchayat_name;
//             $model->shg_profile_model->village_code = $shg_model->village_code;
//             $model->shg_profile_model->village_name = $shg_model->village_name;
//             $model->shg_profile_model->hamlet = $shg_model->hamlet;
//             $model->shg_profile_model->chaire_person_name = $shg_model->chaire_person_name;
//             $model->shg_profile_model->chaire_person_mobile_no = $shg_model->chaire_person_mobile_no;
//             $model->shg_profile_model->secretary_name = $shg_model->secretary_name;
//             $model->shg_profile_model->secretary_mobile_no = $shg_model->secretary_mobile_no;
//             $model->shg_profile_model->treasurer_name = $shg_model->treasurer_name;
//             $model->shg_profile_model->treasurer_mobile_no = $shg_model->treasurer_mobile_no;
//             $model->shg_profile_model->cbo_vo_id = $shg_model->cbo_vo_id;
//             $model->shg_profile_model->shg_code = $shg_model->shg_code;

//             $model->shg_profile_model->name_of_shg = isset($model->name_of_shg) ? $model->name_of_shg : $shg_model->name_of_shg;
//             $model->shg_profile_model->no_of_members = isset($model->no_of_members) ? $model->no_of_members : $shg_model->no_of_members;
//             $model->shg_profile_model->date_of_formation = $model->date_of_formation;

//             if ($model->shg_profile_model->save()) {
//                 return $this->redirect(['/shg/default/profile?shgid=' . $model->shg_profile_model->cbo_shg_id]);
//             }
//         }

//         return $this->render('createprofile', [
//                     'model' => $model,
//                     'shg_model' => $shg_model
//         ]);
//     }

//     /**
//      * Update SHG Profile
//      *
//      * @param [type] $shgid
//      * @return void
//      */
//     public function actionUpdateprofile($shgid) {
//         $shg_model = \cbo\models\shg\ShgProfile::find()->where(['cbo_shg_id' => $shgid])->one();
//         $model = new \cbo\models\shg\form\ShgProfileForm($shg_model);
//         $model->scenario = 'update';
//         $this->performAjaxValidation($model);
//         if ($model->load(Yii::$app->request->post())) {

//             $model->shg_profile_model->name_of_shg = $model->name_of_shg;
//             $model->shg_profile_model->no_of_members = $model->no_of_members;
//             $model->shg_profile_model->date_of_formation = $model->date_of_formation;

//             if ($model->shg_profile_model->save()) {
//                 return $this->redirect(['/shg/default/profile?shgid=' . $model->shg_profile_model->cbo_shg_id]);
//             }
//         }

//         return $this->render('updateprofile', [
//                     'model' => $model,
//                     'shg_model' => $shg_model
//         ]);
//     }

//     /**
//      * CBO SHG Members List
//      *
//      * @param [type] $shgid
//      * @return void
//      */
//     public function actionMemberlist($shgid) {
//         $shg_model = \cbo\models\Shg::findOne($shgid);
//         $shg_profile_model = \cbo\models\shg\ShgProfile::find()->where(['cbo_shg_id' => $shgid])->one();
//         $memberlimit = isset($shg_profile_model->no_of_members) ? $shg_profile_model->no_of_members : $shg_model->no_of_members;

//         $dataProvider = new ActiveDataProvider([
//             'query' => \cbo\models\shg\ShgMembers::find()->where(['cbo_shg_id' => $shgid, 'status' => 1]),
//             'pagination' => false,
//         ]);
//         $totalmember = $dataProvider->getTotalCount();

//         return $this->render('memberlist', ['shg_model' => $shg_model,
//                     'dataProvider' => $dataProvider,
//                     'shgid' => $shgid,
//                     'memberlimit' => $memberlimit,
//                     'totalmember' => $totalmember]);
//     }

//     /**
//      * Add SHG Members
//      *
//      * @param [type] $shgid
//      * @return void
//      */
//     public function actionAddmember($shgid) {
//         $shg_model = \cbo\models\Shg::findOne($shgid);
//         $model = new \cbo\models\shg\form\ShgMemberForm();
//         $model->scenario = 'create';
//         $model->cbo_shg_id = $shg_model->id;
//         $this->performAjaxValidation($model);
//         if ($model->load(Yii::$app->request->post())) {
//             $model->shg_member_model->cbo_shg_id = $shg_model->id;
//             $model->shg_member_model->name = $model->name;
//             $model->shg_member_model->mobile = $model->mobile;
//             $model->shg_member_model->age = $model->age;
//             $model->shg_member_model->marital_status = $model->marital_status;
//             $model->shg_member_model->caste_category = $model->caste_category;
//             $model->shg_member_model->duration_of_membership = $model->duration_of_membership;
//             $model->shg_member_model->total_saving = $model->total_saving;
//             $model->shg_member_model->loan = $model->loan;
//             $model->shg_member_model->loan_count = $model->loan_count;
//             $model->shg_member_model->loan_amount = $model->loan_amount;
//             $model->shg_member_model->loan_date = $model->loan_date;
//             $model->shg_member_model->mcp_status = $model->mcp_status;
//             if ($model->shg_member_model->save()) {
//                 return $this->redirect(['/shg/default/memberlist?shgid=' . $model->shg_member_model->cbo_shg_id]);
//             }
//         }
//         return $this->render('addmember', [
//                     'model' => $model,
//         ]);
//     }

//     /**
//      * Update SHG Member
//      *
//      * @param [type] $shgid
//      * @param [type] $shgmemberid
//      * @return void
//      */
//     public function actionUpdatemember($shgid, $shgmemberid) {
//         $shg_model = \cbo\models\Shg::findOne($shgid);
//         $member_model = \cbo\models\shg\ShgMembers::find()->where(['cbo_shg_id' => $shgid, 'id' => $shgmemberid, 'status' => 1])->one();
//         $model = new \cbo\models\shg\form\ShgMemberForm($member_model);
//         $model->scenario = 'update';
//         $model->cbo_shg_id = $shg_model->id;
//         $this->performAjaxValidation($model);
//         if ($model->load(Yii::$app->request->post())) {
//             $model->shg_member_model->cbo_shg_id = $shg_model->id;
//             $model->shg_member_model->name = $model->name;
//             $model->shg_member_model->mobile = $model->mobile;
//             $model->shg_member_model->age = $model->age;
//             $model->shg_member_model->marital_status = $model->marital_status;
//             $model->shg_member_model->caste_category = $model->caste_category;
//             $model->shg_member_model->duration_of_membership = $model->duration_of_membership;
//             $model->shg_member_model->total_saving = $model->total_saving;
//             $model->shg_member_model->loan = $model->loan;
//             $model->shg_member_model->loan_count = $model->loan_count;
//             $model->shg_member_model->loan_amount = $model->loan_amount;
//             $model->shg_member_model->loan_date = $model->loan_date;
//             $model->shg_member_model->mcp_status = $model->mcp_status;
//             if ($model->shg_member_model->save()) {
//                 return $this->redirect(['/shg/default/memberlist?shgid=' . $model->shg_member_model->cbo_shg_id]);
//             }
//         }
//         return $this->render('updatemember', [
//                     'model' => $model,
//         ]);
//     }

//     /**
//      * Remove CBO SHG Member
//      *
//      * @param [type] $shgid
//      * @param [type] $shgmemberid
//      * @return void
//      */
//     public function actionRemovemember($shgid, $shgmemberid) {
//         $member_model = \cbo\models\shg\ShgMembers::find()->where(['cbo_shg_id' => $shgid, 'id' => $shgmemberid])->one();
//         $member_model->status = -1;

//         if ($member_model->save()) {
//             return $this->redirect(['/shg/default/memberlist?shgid=' . $member_model->cbo_shg_id]);
//         }
//     }

//     /**
//      * Update SHG Member
//      *
//      * @param [type] $shgid
//      * @param [type] $shgmemberid
//      * @return void
//      */
//     public function actionOfficebearers($shgid, $shgmemberid) {
//         $shg_model = \cbo\models\Shg::findOne($shgid);
//         $member_model = \cbo\models\shg\ShgMembers::find()->where(['cbo_shg_id' => $shgid, 'id' => $shgmemberid, 'status' => 1])->one();
//         $office_bearers_model = \cbo\models\shg\ShgMemberOfficeBearers::find()->where(['cbo_shg_id' => $shgid, 'cbo_shg_member_id' => $shgmemberid])->one();
//         if ($office_bearers_model) {
//             $model = new \cbo\models\shg\form\ShgMemberOfficeBearersForm($office_bearers_model);
//         } else {
//             $model = new \cbo\models\shg\form\ShgMemberOfficeBearersForm();
//         }

//         $this->performAjaxValidation($model);
//         if ($model->load(Yii::$app->request->post())) {
//             $model->shg_member_office_bearers_model->cbo_shg_id = $shg_model->id;
//             $model->shg_member_office_bearers_model->cbo_shg_member_id = $shgmemberid;
//             $model->shg_member_office_bearers_model->role = $model->role;
//             $model->shg_member_office_bearers_model->bank_account = $model->bank_account;
//             $model->shg_member_office_bearers_model->relative_in_shg = $model->relative_in_shg;
//             $model->shg_member_office_bearers_model->no_of_relative = $model->no_of_relative;
//             $model->shg_member_office_bearers_model->duration_of_membership = $model->duration_of_membership;

//             if ($model->shg_member_office_bearers_model->save()) {
//                 return $this->redirect(['/shg/default/memberlist?shgid=' . $model->shg_member_office_bearers_model->cbo_shg_id]);
//             }
//         }
//         return $this->render('officebearers', [
//                     'model' => $model,
//         ]);
//     }

//     /**
//      * Add/Update Bank Detail
//      *
//      * @param [type] $shgid
//      * @param [type] $bankid
//      * @return void
//      */
//     public function actionBankdetail($shgid, $bankid = null) {
//         $shg_model = \cbo\models\Shg::findOne($shgid);
//         $bank_detail_model = \cbo\models\shg\ShgBankDetails::find()->where(['cbo_shg_id' => $shgid, 'id' => $bankid])->one();
//         if ($bank_detail_model) {
//             $model = new \cbo\models\shg\form\ShgBankDetailForm($bank_detail_model);
//         } else {
//             $model = new \cbo\models\shg\form\ShgBankDetailForm();
//         }
//         $model->status = 1;

//         $this->performAjaxValidation($model);
//         if ($model->load(Yii::$app->request->post())) {
//             $model->shg_bank_detail_model->cbo_shg_id = $shg_model->id;
//             $model->shg_bank_detail_model->bank_id = $model->bank_id;
//             $model->shg_bank_detail_model->branch = $model->branch;
//             $model->shg_bank_detail_model->branch_code_or_ifsc = $model->branch_code_or_ifsc;
//             $model->shg_bank_detail_model->bank_account_no_of_the_shg = $model->bank_account_no_of_the_shg;
//             $model->shg_bank_detail_model->balance_as_on_date = $model->balance_as_on_date;
//             $model->shg_bank_detail_model->date_of_opening_the_bank_account = $model->date_of_opening_the_bank_account;
//             $model->shg_bank_detail_model->bank_detail_date = isset($model->bank_detail_date) ? $model->bank_detail_date : date('Y-m-d H:i:s');
//             $model->shg_bank_detail_model->name_of_bank = $model->shg_bank_detail_model->bank->bank_name;

//             // Bank Statement Upload 
//             $APPLICATION_FORM_FILE_FOLDER = \Yii::$app->params['datapath'];

//             if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo')) {
//                 mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo');
//                 chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo', 0777);
//             }
//             if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/shg')) {
//                 mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/shg');
//                 chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/shg', 0777);
//             }
//             if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/shg/' . $shg_model->id)) {
//                 mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/shg/' . $shg_model->id);
//                 chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/shg/' . $shg_model->id, 0777);
//             }

//             if (isset(\Yii::$app->request->post()['bankstatement']) and \Yii::$app->request->post()['bankstatement']) {
//                 $content = base64_decode(\Yii::$app->request->post()['bankstatement']);
//                 $im = imagecreatefromstring($content);
//                 $image_name = 'bankstatement_' . uniqid() . '.jpg';
//                 $model->shg_bank_detail_model->passbook_photo = $image_name;
//                 if ($im !== false) {
//                     header('Content-Type: image/jpeg');
//                     imagejpeg($im, $APPLICATION_FORM_FILE_FOLDER . 'cbo/shg/' . $shg_model->id . '/' . $image_name);

//                     imagedestroy($im);
//                 }
//             }

//             // End


//             if ($model->shg_bank_detail_model->save()) {
//                 return $this->redirect(['/shg/default/banklist?shgid=' . $model->shg_bank_detail_model->cbo_shg_id]);
//             }
//         }
//         return $this->render('bankdetail', [
//                     'model' => $model,
//         ]);
//     }

//     /**
//      * Attcahed Bank List of SHG 
//      *
//      * @param [type] $shgid
//      * @return void
//      */
//     public function actionBanklist($shgid) {
//         $shg_model = \cbo\models\Shg::findOne($shgid);

//         $dataProvider = new ActiveDataProvider([
//             'query' => \cbo\models\shg\ShgBankDetails::find()->where(['cbo_shg_id' => $shgid, 'status' => 1]),
//             'pagination' => false,
//         ]);
//         $totalbank = $dataProvider->getTotalCount();

//         return $this->render('banklist', ['shg_model' => $shg_model,
//                     'dataProvider' => $dataProvider,
//                     'shgid' => $shgid,
//                     'totalbank' => $totalbank]);
//     }

//     /**
//      * Remove Bank
//      *
//      * @param [type] $shgid
//      * @param [type] $bankid
//      * @return void
//      */
//     public function actionRemovebank($shgid, $bankid) {
//         $bank_detail_model = \cbo\models\shg\ShgBankDetails::find()->where(['cbo_shg_id' => $shgid, 'id' => $bankid])->one();
//         $bank_detail_model->status = -1;

//         if ($bank_detail_model->save()) {
//             return $this->redirect(['/shg/default/profile?shgid=' . $bank_detail_model->cbo_shg_id]);
//         }
//     }

//     /**
//      * All Fund Status
//      *
//      * @param [type] $shgid
//      * @return void
//      */
//     public function actionFundstatus($shgid) {
//         $shg_model = \cbo\models\Shg::findOne($shgid);
//         $fundtypes = \common\models\base\GenralModel::cbo_funds_type_option('shg');

//         return $this->render('fundstatus', [
//                     'fundtypes' => $fundtypes,
//                     'shg_model' => $shg_model
//         ]);
//     }

//     /**
//      * All Funds Listing
//      *
//      * @param [type] $shgid
//      * @param [type] $fund_id
//      * @return void
//      */
//     public function actionFundlist($shgid, $fund_id) {
//         $shg_model = \cbo\models\Shg::findOne($shgid);
//         $fundtype = \cbo\models\master\CboMasterFundtype::find()->where(['id' => $fund_id])->one();

//         $dataProvider = new ActiveDataProvider([
//             'query' => \cbo\models\shg\ShgFundStatus::find()->where(['cbo_shg_id' => $shgid, 'fund_type' => $fund_id, 'status' => 1]),
//             'pagination' => false,
//         ]);
//         $total_amount_received = \cbo\models\shg\ShgFundStatus::find()->where(['cbo_shg_id' => $shgid, 'fund_type' => $fund_id, 'status' => 1])->Sum('amount_received');
//         $number_of_ammount_received = \cbo\models\shg\ShgFundStatus::find()->where(['cbo_shg_id' => $shgid, 'fund_type' => $fund_id, 'status' => 1])->count();

//         return $this->render('fundlist', [
//                     'models' => $dataProvider->getModels(),
//                     'shg_model' => $shg_model,
//                     'fundtype' => $fundtype,
//                     'total_amount_received' => $total_amount_received,
//                     'number_of_ammount_received' => $number_of_ammount_received
//         ]);
//     }

//     /**
//      * Fund Create and Update
//      *
//      * @param [type] $shgid
//      * @param [type] $fundid
//      * @return void
//      */
//     public function actionFund($shgid, $editfundid = null, $fund_type) {

//         if (Yii::$app->request->isAjax) {
//             Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//             $model = new \cbo\models\shg\form\ShgFundStatusForm();
//             if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//                 if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {

//                     $fund_status_model = \cbo\models\shg\ShgFundStatus::find()->where(['cbo_shg_id' => $model->shgid, 'id' => $model->editfundid])->one();
//                     if ($fund_status_model) {
//                         $model->shg_fund_status_model = $fund_status_model;
//                     } else {
//                         $model->shg_fund_status_model = new \cbo\models\shg\ShgFundStatus();
//                     }

//                     $model->shg_fund_status_model->cbo_shg_id = $model->shgid;
//                     $model->shg_fund_status_model->fund_type = $model->fund_type;
//                     $model->shg_fund_status_model->received_from = $model->received_from;
//                     $model->shg_fund_status_model->date_of_receipt = $model->date_of_receipt;
//                     $model->shg_fund_status_model->amount_received = $model->amount_received;
//                     $model->shg_fund_status_model->amount_received_date = date('Y-m-d');
//                     if ($model->shg_fund_status_model->save()) {
//                         Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
//                         return ['success' => true];
//                     } else {
//                         return ActiveForm::validate($model->shg_fund_status_model);
//                     }
//                 }
//             }
//             return ActiveForm::validate($model);
//         } else {
//             $fund_status_model = \cbo\models\shg\ShgFundStatus::find()->where(['cbo_shg_id' => $shgid, 'id' => $editfundid])->one();
//             if ($fund_status_model) {
//                 $model = new \cbo\models\shg\form\ShgFundStatusForm($fund_status_model);
//             } else {
//                 $model = new \cbo\models\shg\form\ShgFundStatusForm();
//             }
//             $model->fund_type = $fund_type;
//             $model->shgid = $shgid;
//             $model->editfundid = $editfundid;

//             return $this->render('fund', ['model' => $model]);
//         }



// //
// //        $shg_model = \cbo\models\Shg::findOne($shgid);
// //        $fundtype = \cbo\models\master\CboMasterFundtype::find()->where(['id' => $fund_type, 'shg' => 1])->one();
// //
// //        $fund_status_model = \cbo\models\shg\ShgFundStatus::find()->where(['cbo_shg_id' => $shgid, 'id' => $editfundid])->one();
// //        if ($fund_status_model) {
// //            $model = new \cbo\models\shg\form\ShgFundStatusForm($fund_status_model);
// ////            $model->fund_type = $fund_type;
// ////            $model->shgid = $shgid;
// ////            $model->editfundid = $editfundid;
// //            // $model->action_url = '/shg/default/fund?shgid='.$shgid.'&editfundid='.$editfundid.'&fund_type='.$fund_type;
// //            //$model->action_validate_url = '/shg/default/fundvalidation?shgid=' . $shgid . '&fund_type=' . $fund_type . '&id=' . $editfundid;
// //        } else {
// //            $model = new \cbo\models\shg\form\ShgFundStatusForm();
// ////            $model->fund_type = $fund_type;
// ////            $model->shgid = $shgid;
// ////            $model->editfundid = $editfundid;
// //            // $model->action_url = '/shg/default/fund?shgid='.$shgid.'&fund_type='.$fund_type;
// //            //$model->action_validate_url = '/shg/default/fundvalidation?shgid=' . $shgid . '&fund_type=' . $fund_type;
// //        }
// //        $model->fund_type = $fund_type;
// //        $model->shgid = $shgid;
// //        $model->editfundid = $editfundid;
// //        $id = null;
// //        if (Yii::$app->request->isAjax) {
// //            $fund_status_model = null;
// //            if ($id != null) {
// //                $fund_status_model = \cbo\models\shg\ShgFundStatus::find()->where(['cbo_shg_id' => $shgid, 'id' => $id])->one();
// //            }
// //
// //            $model = new \cbo\models\shg\form\ShgFundStatusForm($fund_status_model);
// //            $model->fund_type = $fund_type;
// //            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
// //                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
// //                return ActiveForm::validate($model);
// //            }
// //        }
// //
// //
// //        // $this->performAjaxValidation($model);
// //        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $model->validate()) {
// //
// //            if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == 1) {
// //                if ($model->validate()) {
// //                    $model->shg_fund_status_model->cbo_shg_id = $model->shgid;
// //                    $model->shg_fund_status_model->fund_type = $model->fund_type;
// //                    $model->shg_fund_status_model->received_from = $model->received_from;
// //                    $model->shg_fund_status_model->date_of_receipt = $model->date_of_receipt;
// //                    $model->shg_fund_status_model->amount_received = $model->amount_received;
// //                    $model->shg_fund_status_model->amount_received_date = date('Y-m-d');
// //                    if ($model->shg_fund_status_model->save()) {
// //                        Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
// //                        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
// //                        return ['success' => true];
// //                    }
// //                } else {
// //                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
// //                    return ActiveForm::validate($model);
// //                }
// //            } else {
// //                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
// //                return ActiveForm::validate($model);
// //            }
// //        }
// //
// //        return $this->render('fund', [
// //                    'model' => $model,
// //                    'fundtype' => $fundtype
// //        ]);
//     }

//     /**
//      * Fund Validation
//      *
//      * @param [type] $shgid
//      * @param [type] $fund_type
//      * @param [type] $id
//      * @return void
//      */
//     public function actionFundvalidation($shgid, $fund_type, $id = null) {
// //        $fund_status_model = null;
// //        if ($id != null) {
// //            $fund_status_model = \cbo\models\shg\ShgFundStatus::find()->where(['cbo_shg_id' => $shgid, 'id' => $id])->one();
// //        }
// //
// //        $model = new \cbo\models\shg\form\ShgFundStatusForm($fund_status_model);
// //        $model->fund_type = $fund_type;
// //        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
// //            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
// //            return ActiveForm::validate($model);
// //        }
//         }

//     /**
//      * Save Final Fund Data
//      *
//      * @return void
//      */
//     // public function actionFundsave(){
//     //     print_r($_REQUEST);exit;
//     //     if($_REQUEST && $_REQUEST['ShgFundStatusForm']){
//     //         $model = \cbo\models\shg\ShgFundStatus::find()->where(['cbo_shg_id'=>$_REQUEST['ShgFundStatusForm']['shgid'],'id'=>$_REQUEST['ShgFundStatusForm']['editfundid']])->one();
//     //         if(!$model){
//     //             $model = new \cbo\models\shg\ShgFundStatus();
//     //         }
//     //         $model->cbo_shg_id = $_REQUEST['ShgFundStatusForm']['shgid'];
//     //         $model->fund_type = $_REQUEST['ShgFundStatusForm']['fund_type'];
//     //         $model->received_from = $_REQUEST['ShgFundStatusForm']['received_from'];
//     //         $model->date_of_receipt = $_REQUEST['ShgFundStatusForm']['date_of_receipt'];
//     //         $model->amount_received = $_REQUEST['ShgFundStatusForm']['amount_received'];
//     //         $model->amount_received_date = date('Y-m-d');
//     //         if($model->validate() && $model->save()){
//     //             Yii::$app->session->setFlash('success', 'Data Submitted Successfully');
//     //             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//     //             return ['success' => true];
//     //         }else{
//     //             return ['success' => false];
//     //         }
//     //     }
//     // }

//     /**
//      * Get Bank Passbook Image
//      *
//      * @param [type] $shgid
//      * @param [type] $path
//      * @return void
//      */
//     public function actionBankpassbook($shgid, $path) {
//         if (file_exists(\Yii::$app->params['datapath'] . 'cbo/shg/' . $shgid . '/' . $path)) {
//             Yii::$app->response->sendFile(\Yii::$app->params['datapath'] . 'cbo/shg/' . $shgid . '/' . $path);
//         } else {
//             return '';
//         }
//     }

}
