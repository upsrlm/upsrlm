<?php

namespace cbo\modules\bc\controllers;

use Yii;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\selection\models\SrlmBcApplicationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\CboMemberProfile;
use common\models\CboMembers;
use common\models\master\MasterRole;
use backend\modules\bc\models\form\ShgForm;
use yii\web\UploadedFile;

/**
 * CertifiedController implements the CRUD actions for NotificationLog model.
 */
class NoshgController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'detail', 'update'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'detail', 'update'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all NotificationLog models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new \bc\modules\selection\models\form\DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity,\Yii::$app->params['page_size30'], null, \bc\modules\selection\models\base\GenralModel::select_preselected_bc_column());
        $dataProvider->query->andWhere(['srlm_bc_application.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere(['srlm_bc_application.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
        $dataProvider->query->andWhere(['srlm_bc_application.gender' => 2]);
        $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
//  
            $dataProvider->query->andWhere(['IS', 'srlm_bc_application.your_group_name', new \yii\db\Expression('null')]);
        
        if ($searchModel->custom_bc_shg_return == 2) {
            //$dataProvider->query->andWhere(['srlm_bc_application.return_for_shg' => 1]);
        }
        //$dataProvider->query->andWhere(['IS', 'srlm_bc_application.cbo_shg_id', new \yii\db\Expression('null')]);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionReturn() {
        $searchModel = new \bc\modules\selection\models\form\DashboardSearchForm(Yii::$app->request->queryParams);
        $searchModels = new SrlmBcApplicationSearch();
        $dataProvider = $searchModels->search($searchModel, Yii::$app->user->identity, \Yii::$app->params['page_size30']);
        $dataProvider->query->andWhere(['srlm_bc_application.status' => SrlmBcApplication::STATUS_PROVISIONAL]);
        $dataProvider->query->andWhere(['srlm_bc_application.form_number' => SrlmBcApplication::FORM_STATUS_PART_4]);
        $dataProvider->query->andWhere(['srlm_bc_application.gender' => 2]);
        $dataProvider->query->andWhere(['srlm_bc_application.blocked' => 0]);
        $dataProvider->query->andWhere(['srlm_bc_application.return_for_shg' => 1]);
       
        return $this->render('return', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
//    public function actionAssignshg($bcid) {
//        $bd_model = $this->findModel($bcid);
//        return $this->redirect(['/bc/noshg']);
//        $model = new \backend\modules\bc\models\form\BCAssignShgForm($bd_model);
//        if ($model->user_model != null) {
//            if ($model->user_model->role != MasterRole::ROLE_CBO_USER) {
//                \Yii::$app->getSession()->setFlash('error', 'Already user created');
//                return $this->redirect(['/bc/noshg']);
//            }
//        }
//        if ($model->load(Yii::$app->request->post())) {
//            if ($model->user_model == null) {
//                $model->user_model = new User();
//            }
//            $model->user_model->name = trim($model->bc_application_model->name);
//            $model->user_model->mobile_no = $model->bc_application_model->user->mobile_no;
//            $model->user_model->username = $model->bc_application_model->user->mobile_no;
//            $model->user_model->role = MasterRole::ROLE_CBO_USER;
//            $model->user_model->email = $model->bc_application_model->user->mobile_no . '@gmail.com';
//            $model->user_model->password = $model->bc_application_model->user->mobile_no;
//            $model->user_model->setPassword($model->bc_application_model->user->mobile_no);
//            $model->user_model->setUpd($model->bc_application_model->user->mobile_no);
//            $model->user_model->status = User::STATUS_INACTIVE;
//            $model->user_model->profile_status = 1;
//            $model->user_model->login_by_otp = 2;
//            $model->user_model->dummy_column = \Yii::$app->user->identity->dummy_column;
//            if ($model->user_model->validate() and $model->user_model->save()) {
//                $model->bc_application_model->user_id = $model->user_model->id;
//                $model->bc_application_model->cbo_shg_id = $model->cbo_shg_id;
//                $model->bc_application_model->assign_shg_by = \Yii::$app->user->identity->id;
//                $model->bc_application_model->assign_shg_datetime = new \yii\db\Expression('NOW()');
//                $model->bc_application_model->save();
//                $model->cbo_member_model = CboMembers::find()->where(['cbo_type' => CboMembers::CBO_TYPE_SHG, 'user_id' => $model->user_model->id])->one();
//                // $model->cbo_member_model = CboMembers::find()->where(['cbo_type' => CboMembers::CBO_TYPE_SHG, 'cbo_id' => $model->cbo_shg_id, 'user_id' => $model->user_model->id])->one();
//                if ($model->cbo_member_model == null) {
//                    $model->cbo_member_model = new CboMembers();
//                }
//                $model->cbo_member_model->user_id = $model->user_model->id;
//                $model->cbo_member_model->cbo_type = CboMembers::CBO_TYPE_SHG;
//                $model->cbo_member_model->cbo_id = $model->cbo_shg_id;
//                $model->cbo_member_model->entry_type = CboMembers::CBO_TYPE_SHG;
//                $model->cbo_member_model->status = 0;
//                $model->cbo_member_model->save();
//                $model->cbo_member_profile_model = CboMemberProfile::findOne(['user_id' => $model->user_model->id]);
//                if ($model->cbo_member_profile_model == null) {
//                    $model->cbo_member_profile_model = new CboMemberProfile();
//                }
//
//                $model->cbo_member_profile_model->user_id = $model->user_model->id;
//                $model->cbo_member_profile_model->first_name = $model->bc_application_model->first_name;
//                $model->cbo_member_profile_model->middle_name = $model->bc_application_model->middle_name;
//                $model->cbo_member_profile_model->sur_name = $model->bc_application_model->sur_name;
//                $model->cbo_member_profile_model->gender = $model->bc_application_model->gender;
//                $model->cbo_member_profile_model->age = $model->bc_application_model->age;
//                $model->cbo_member_profile_model->primary_phone_no = $model->bc_application_model->mobile_number;
//
//                $model->cbo_member_profile_model->marital_status = $model->bc_application_model->marital_status;
//                $model->cbo_member_profile_model->aadhaar_number = $model->bc_application_model->aadhar_number;
//                $model->cbo_member_profile_model->profile_photo = $model->bc_application_model->profile_photo;
//                $model->cbo_member_profile_model->photo_aadhaar_front = $model->bc_application_model->aadhar_front_photo;
//                $model->cbo_member_profile_model->photo_aadhaar_back = $model->bc_application_model->aadhar_back_photo;
//                $model->cbo_member_profile_model->bc = 1;
//                $model->cbo_member_profile_model->cast = $model->bc_application_model->cast;
//                $model->cbo_member_profile_model->division_code = $model->bc_application_model->division_code;
//                $model->cbo_member_profile_model->division_name = $model->bc_application_model->division_name;
//                $model->cbo_member_profile_model->district_code = $model->bc_application_model->district_code;
//                $model->cbo_member_profile_model->district_name = $model->bc_application_model->district_name;
//                $model->cbo_member_profile_model->block_code = $model->bc_application_model->block_code;
//                $model->cbo_member_profile_model->block_name = $model->bc_application_model->block_name;
//                $model->cbo_member_profile_model->gram_panchayat_code = $model->bc_application_model->gram_panchayat_code;
//                $model->cbo_member_profile_model->gram_panchayat_name = $model->bc_application_model->gram_panchayat_name;
//                $model->cbo_member_profile_model->village_code = $model->bc_application_model->village_code;
//                $model->cbo_member_profile_model->village_name = $model->bc_application_model->village_name;
//                $model->cbo_member_profile_model->hamlet = $model->bc_application_model->hamlet;
//                $model->cbo_member_profile_model->guardian_name = $model->bc_application_model->guardian_name;
//                $model->cbo_member_profile_model->otp_mobile_no = $model->bc_application_model->user->mobile_no;
//                $model->cbo_member_profile_model->pvr_upload_file_name = $model->bc_application_model->pvr_upload_file_name;
//                $model->cbo_member_profile_model->iibf_photo_file_name = $model->bc_application_model->iibf_photo_file_name;
//                $model->cbo_member_profile_model->srlm_bc_application_id = $model->bc_application_model->id;
//                $model->cbo_member_profile_model->srlm_bc_selection_user_id = $model->bc_application_model->srlm_bc_selection_user_id;
//                $model->cbo_member_profile_model->bank_account_no = $model->bc_application_model->bank_account_no_of_the_bc;
//                $model->cbo_member_profile_model->bank_id = $model->bc_application_model->bank_id;
//                $model->cbo_member_profile_model->name_of_bank = $model->bc_application_model->name_of_bank;
//                $model->cbo_member_profile_model->branch = $model->bc_application_model->branch;
//                $model->cbo_member_profile_model->branch_code_or_ifsc = $model->bc_application_model->branch_code_or_ifsc;
//                $model->cbo_member_profile_model->date_of_opening_the_bank_account = $model->bc_application_model->date_of_opening_the_bank_account;
//                $model->cbo_member_profile_model->cin = $model->bc_application_model->cin;
//                $model->cbo_member_profile_model->passbook_photo = $model->bc_application_model->passbook_photo;
//                if ($model->cbo_member_profile_model->save()) {
//                    //\Yii::$app->getSession()->setFlash('success', 'Assign SHG successfully');
//                    return $this->redirect(['/bc/noshg?DashboardSearchForm[district_code]=' . $model->bc_application_model->district_code . '&DashboardSearchForm[block_code]=' . $model->bc_application_model->block_code]);
//                } else {
//                    
//                }
//            }
//        }
//        if (\Yii::$app->request->isAjax) {
//
//            return $this->renderAjax('_assignshgform', [
//                        'model' => $model,
//            ]);
//        } else {
//            return $this->render('_assignshgform', [
//                        'model' => $model,
//            ]);
//        }
//    }

    public function actionAddshg($bcid) {
        $bd_model = $this->findModel($bcid);
        $model = new ShgForm($bd_model);

        if ($model->load(Yii::$app->request->post())) {
            $model->passbook_photo = UploadedFile::getInstance($model, 'passbook_photo');
            if ($model->validate()) {
                $model->save();
                return $this->redirect(['/bc/noshg?DashboardSearchForm[district_code]=' . $bd_model->district_code . '&DashboardSearchForm[block_code]=' . $bd_model->block_code]);
            }
        }
        if (\Yii::$app->request->isAjax) {

            return $this->renderAjax('addshg', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('addshg', [
                        'model' => $model,
            ]);
        }
    }

    protected function findModel($id) {
        if (($model = SrlmBcApplication::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
