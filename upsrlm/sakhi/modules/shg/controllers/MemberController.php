<?php

namespace sakhi\modules\shg\controllers;

use Yii;
use cbo\models\Shg;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use common\helpers\FileHelpers;
use yii\data\ActiveDataProvider;
use cbo\models\form\ShgVerifyCSTForm;
use cbo\models\CboMasterMemberDesignation;
use common\models\dynamicdb\cbo_detail\RishtaShg;
use common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiaryMember;
use common\models\dynamicdb\cbo_detail\dbt\DbtBeneficiaryHousehold;
use common\models\dynamicdb\cbo_detail\dbt\form\DbtBeneficiaryMemberForm;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeMgnrega;
use common\models\dynamicdb\cbo_detail\dbt\form\DbtBeneficiarySchemeMgnregaForm;
use common\models\dynamicdb\cbo_detail\dbt\scheme\DbtBeneficiarySchemeMgnregaApplicant;

/**
 * Member controller for the `shg` module
 */
class MemberController extends Controller {

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

    /**
     * Member list Index Page of SHG
     *
     * @param [type] $shgid
     * @return void
     */
    public function actionIndex($shgid) {
        $shg_model = \common\models\dynamicdb\cbo_detail\RishtaShgProfile::find()->where(['cbo_shg_id' => $shgid])->one();
        $memberlimit = $shg_model->no_of_members;

        $dataProvider = new ActiveDataProvider([
            'query' => \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $shgid, 'status' => 1]),
            'pagination' => false,
        ]);
        $totalmember = $dataProvider->getTotalCount();

        return $this->render('index', [
                    'shg_model' => $shg_model,
                    'dataProvider' => $dataProvider,
                    'shgid' => $shgid,
                    'memberlimit' => $memberlimit,
                    'totalmember' => $totalmember
        ]);
    }

    /**
     * Update SHG Member
     *
     * @param [type] $shgid
     * @param [type] $shg_member_id
     * @return void
     */
    public function actionUpdate($shgid, $shg_member_id = null) {

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new \common\models\dynamicdb\cbo_detail\form\RishtaShgMemberForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {

                    $member_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $model->cbo_shg_id, 'id' => $model->shg_member_id, 'status' => 1])->one();
                    if ($member_model) {
                        $model->shg_member_model = $member_model;
                    } else {
                        $model->shg_member_model = new \common\models\dynamicdb\cbo_detail\RishtaShgMember();
                    }

                    $model->shg_member_model->cbo_shg_id = $model->cbo_shg_id;
                    $model->shg_member_model->name = $model->name;
                    if (!isset($model->shg_member_model->user_id)) {
                        $model->shg_member_model->mobile = $model->mobile;
                    }
                    $model->shg_member_model->division_code = isset($model->shg) ? $model->shg->division_code : NULL;
                    $model->shg_member_model->district_code = isset($model->shg) ? $model->shg->district_code : NULL;
                    $model->shg_member_model->block_code = isset($model->shg) ? $model->shg->block_code : NULL;
                    $model->shg_member_model->gram_panchayat_code = isset($model->shg) ? $model->shg->gram_panchayat_code : NULL;
                    $model->shg_member_model->village_code = isset($model->shg) ? $model->shg->village_code : NULL;

                    $model->shg_member_model->age = $model->age;
                    $model->shg_member_model->marital_status = $model->marital_status;
                    $model->shg_member_model->caste_category = $model->caste_category;
                    $model->shg_member_model->duration_of_membership = $model->duration_of_membership;
                    $model->shg_member_model->total_saving = $model->total_saving;
                    $model->shg_member_model->loan = $model->loan;
                    $model->shg_member_model->loan_count = $model->loan_count;
                    $model->shg_member_model->loan_amount = $model->loan_amount;
                    $model->shg_member_model->loan_date = $model->loan_date;
                    $model->shg_member_model->mcp_status = $model->mcp_status;
                    $model->shg_member_model->source = \common\models\base\GenralModel::SHG_MEMBER_SOURCE_CBO;

                    $model->shg_member_model->verified = 1;
                    if ($model->shg_member_model->save()) {
                        $model->shg_member_model->parent_id = $model->shg_member_model->id;
                        $model->shg_member_model->ucount = 1;
                        $model->shg_member_model->save();
                        Yii::$app->session->setFlash('success', 'जानकारी सफलता पूर्वक प्राप्त हुआ');
                        return ['success' => true];
                    } else {
                        return ActiveForm::validate($model->shg_fund_status_model);
                    }
                }
            }
            return ActiveForm::validate($model);
        } else {
            $member_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $shgid, 'id' => $shg_member_id, 'status' => 1])->one();
            if ($member_model) {
                $model = new \common\models\dynamicdb\cbo_detail\form\RishtaShgMemberForm($member_model);
            } else {
                $model = new \common\models\dynamicdb\cbo_detail\form\RishtaShgMemberForm();
            }
            $model->cbo_shg_id = $shgid;
            $model->shg_member_id = $shg_member_id;

            return $this->render('update', ['model' => $model]);
        }
    }

    public function actionSuggestwadasakhi($shgid) {
        $shg_model = $this->findModel($shgid);
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new \common\models\dynamicdb\cbo_detail\form\RishtaSugestWadaSakhiForm($shg_model);
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'जानकारी सफलता पूर्वक प्राप्त हुआ');
                        return ['success' => true];
                    } else {
                        return ActiveForm::validate($model);
                    }
                }
            }
            return ActiveForm::validate($model);
        } else {
            $model = new \common\models\dynamicdb\cbo_detail\form\RishtaSugestWadaSakhiForm($shg_model);
            $model->cbo_shg_id = $shgid;

            return $this->render('suggest_wada_sakhi_form', ['model' => $model]);
        }
    }

    /**
     * Remove CBO SHG Member
     *
     * @param [type] $shgid
     * @param [type] $shg_member_id
     * @return void
     */
    public function actionRemove() {
        if (Yii::$app->request->isAjax) {
            if (isset($_REQUEST['removeRequest']) && $_REQUEST['removeRequest'] == "1") {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $shgid = $_REQUEST['shgid'];
                $shg_member_id = $_REQUEST['shg_member_id'];
                $member_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $shgid, 'id' => $shg_member_id])->one();
                if (!isset($member_model->user_id)) {
                    $member_model->status = -1;
                }
                if ($member_model->save()) {
                    Yii::$app->session->setFlash('success', 'सदस्य को सफलतापूर्वक निकाला गया ');
                    return ['success' => true];
                }
            }
        }
    }

    /**
     * Update SHG Member Office Bearers Detail
     *
     * @param [type] $shgid
     * @param [type] $shg_member_id
     * @return void
     */
    public function actionOfficebearers($shgid, $shg_member_id) {

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new \common\models\dynamicdb\cbo_detail\form\RishtaShgMemberOfficeBearersForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {

                    $model->shg_member_office_bearers_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $model->cbo_shg_id, 'id' => $model->cbo_shg_member_id])->one();
                    $model->shg_member_office_bearers_model->cbo_shg_id = $model->cbo_shg_id;
                    $model->shg_member_office_bearers_model->role = $model->role;
                    $model->shg_member_office_bearers_model->bank_account = $model->bank_account;
                    $model->shg_member_office_bearers_model->relative_in_shg = $model->relative_in_shg;
                    $model->shg_member_office_bearers_model->no_of_relative = $model->no_of_relative;
                    $model->shg_member_office_bearers_model->duration_of_membership = $model->duration_of_membership;
                    $model->shg_member_office_bearers_model->office_bearer = 1;

                    if ($model->shg_member_office_bearers_model->save()) {
                        Yii::$app->session->setFlash('success', 'डेटा सफलतापूर्वक सहेजा गया');
                        return ['success' => true];
                    } else {
                        return ActiveForm::validate($model->shg_fund_status_model);
                    }
                }
            }
            return ActiveForm::validate($model);
        } else {
            $office_bearers_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['id' => $shg_member_id])->one();
            $model = new \common\models\dynamicdb\cbo_detail\form\RishtaShgMemberOfficeBearersForm($office_bearers_model);
            $model->cbo_shg_id = $shgid;
            $model->cbo_shg_member_id = $shg_member_id;

            return $this->render('officebearers', ['model' => $model]);
        }
    }

    public function actionVerifychairperson($shgid, $shg_member_id) {
        $shg_model = $this->findModel($shgid);
        if ($shg_model->verify_over_all == 0 and $shg_model->verify_chaire_person == 0 and $shg_model->getProrole() == 0) {
            
        } else {
            return $this->redirect(['/shg/member/index?shgid=' . $shgid]);
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new ShgVerifyCSTForm($shg_model, CboMasterMemberDesignation::SHG_CHAIRPERSON);
            $model->shg_member_id = $shg_member_id;
            $model->scenario = 'chairperson';
            $model->verify_chaire_person = 2;
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    $member_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $model->cbo_shg_id, 'id' => $model->shg_member_id])->one();
                    $model->shg_model->verify_shg_member_by = Yii::$app->user->identity->id;
                    $model->shg_model->verify_shg_member_datetime = new \yii\db\Expression('NOW()');
                    if ($model->verify_ques1 == '1' and $model->verify_ques2 == '1' and $model->verify_ques3 == 1) {
                        $model->verify_chaire_person = 1;
                    }
                    $model->shg_model->verify_chaire_person = $model->verify_chaire_person;
                    $model->shg_model->verify_ques1 = $model->verify_ques1;
                    $model->shg_model->verify_ques2 = $model->verify_ques2;
                    $model->shg_model->verify_ques3 = $model->verify_ques3;

                    if ($model->shg_model->verify_chaire_person == '1') {
                        $model->shg_model->verify_over_all = 1;
                    }

                    if ($model->SaveUser() and $model->shg_model->save()) {
                        if (isset($member_model)) {
                            if (isset($model->user_model->id)) {
                                $member_model->user_id = $model->user_model->id;
                                $member_model->update();
                            }
                        }
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        $this->message = 'सत्यापन अध्यक्ष सफलतापूर्वक';
                        Yii::$app->getSession()->setFlash('success', $this->message);
                        return ['success' => true];
                    } else {
                        return ActiveForm::validate($model);
                    }
                }
            }
            return ActiveForm::validate($model);
        } else {
            $model = new ShgVerifyCSTForm($shg_model, CboMasterMemberDesignation::SHG_CHAIRPERSON);
            $model->shg_member_id = $shg_member_id;
            $model->scenario = 'chairperson';
            $model->verify_chaire_person = 2;

            return $this->render('_verifychairpersonform', [
                        'model' => $model,
            ]);
        }
    }

    public function actionVerifysecretary($shgid, $shg_member_id) {
        $shg_model = $this->findModel($shgid);
        if ($shg_model->verify_over_all == 0 and $shg_model->verify_chaire_person == 2 and $shg_model->verify_secretary == 0 and $shg_model->getSeorole() == 0) {
            
        } else {
            return $this->redirect(['/shg/member/index?shgid=' . $shgid]);
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new ShgVerifyCSTForm($shg_model, CboMasterMemberDesignation::SHG_SECRETARY);
            $model->verify_secretary = 2;
            $model->shg_member_id = $shg_member_id;
            $model->scenario = 'secretary';
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    $member_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $model->cbo_shg_id, 'id' => $model->shg_member_id])->one();
                    $model->shg_model->verify_shg_member_by = Yii::$app->user->identity->id;
                    $model->shg_model->verify_shg_member_datetime = new \yii\db\Expression('NOW()');

                    if ($model->verify_s_ques1 == '1' and $model->verify_s_ques2 == '1' and $model->verify_s_ques3 == 1) {
                        $model->verify_secretary = 1;
                    }
                    $model->shg_model->verify_secretary = $model->verify_secretary;
                    $model->shg_model->verify_s_ques1 = $model->verify_s_ques1;
                    $model->shg_model->verify_s_ques2 = $model->verify_s_ques2;
                    $model->shg_model->verify_s_ques3 = $model->verify_s_ques3;

                    if ($model->shg_model->verify_secretary == '1') {
                        $model->shg_model->verify_over_all = 1;
                    }
                    if ($model->SaveUser() and $model->shg_model->save()) {
                        if (isset($member_model)) {
                            if (isset($model->user_model->id)) {
                                $member_model->user_id = $model->user_model->id;
                                $member_model->update();
                            }
                        }
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        $this->message = 'सत्यापन सचिव सफलतापूर्वक ';
                        Yii::$app->getSession()->setFlash('success', $this->message);
                        return ['success' => true];
                    } else {
                        return ActiveForm::validate($model);
                    }
                }
            }
            return ActiveForm::validate($model);
        } else {
            $model = new ShgVerifyCSTForm($shg_model, CboMasterMemberDesignation::SHG_SECRETARY);
            $model->verify_secretary = 2;
            $model->shg_member_id = $shg_member_id;
            $model->scenario = 'secretary';

            return $this->render('_verifysecretaryform', [
                        'model' => $model,
            ]);
        }
    }

    public function actionVerifytreasurer($shgid, $shg_member_id) {
        $shg_model = $this->findModel($shgid);
        if ($shg_model->verify_over_all == 0 and $shg_model->verify_chaire_person == 2 and $shg_model->verify_secretary == 2 and $shg_model->verify_treasurer == 0 and $shg_model->getTrorole() == 0) {
            
        } else {
            return $this->redirect(['/shg/member/index?shgid=' . $shgid]);
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new ShgVerifyCSTForm($shg_model, CboMasterMemberDesignation::SHG_TREASURER);
            $model->verify_treasurer = 2;
            $model->shg_member_id = $shg_member_id;
            $model->scenario = 'treasurer';
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    $member_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $model->cbo_shg_id, 'id' => $model->shg_member_id])->one();
                    $model->shg_model->verify_shg_member_by = Yii::$app->user->identity->id;
                    $model->shg_model->verify_shg_member_datetime = new \yii\db\Expression('NOW()');
                    if ($model->verify_t_ques1 == '1' and $model->verify_t_ques2 == '1' and $model->verify_t_ques3 == 1) {
                        $model->verify_treasurer = 1;
                    }
                    $model->shg_model->verify_t_ques1 = $model->verify_t_ques1;
                    $model->shg_model->verify_t_ques2 = $model->verify_t_ques2;
                    $model->shg_model->verify_t_ques3 = $model->verify_t_ques3;

                    $model->shg_model->verify_treasurer = $model->verify_treasurer;
                    if ($model->shg_model->verify_treasurer == '1') {
                        $model->shg_model->verify_over_all = 1;
                    }
                    if ($model->SaveUser() and $model->shg_model->save()) {
                        if (isset($model->user_model->id)) {
                            $member_model->user_id = $model->user_model->id;
                            $member_model->update();
                        }
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        $this->message = 'सत्यापन सचिव सफलतापूर्वक';
                        Yii::$app->getSession()->setFlash('success', $this->message);
                        return ['success' => true];
                    } else {
                        return ActiveForm::validate($model);
                    }
                }
            }
            return ActiveForm::validate($model);
        } else {
            $model = new ShgVerifyCSTForm($shg_model, CboMasterMemberDesignation::SHG_TREASURER);
            $model->verify_treasurer = 2;
            $model->shg_member_id = $shg_member_id;
            $model->scenario = 'treasurer';

            return $this->render('_verifytreasurerform', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Insert or Update in Shg household table and member table
     *
     * @param [type] $shgid
     * @param [type] $shg_member_id
     * @return void
     */
    public function actionScheme($shgid, $shg_member_id) {
        $shg_model = $this->findModel($shgid);
        $member_model = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $shgid, 'id' => $shg_member_id, 'status' => 1])->one();
        if ($member_model) {
            $household = DbtBeneficiaryHousehold::find()->where(['cbo_shg_id' => $shgid, 'rishta_shg_member_id' => $shg_member_id])->one();
            if (!$household) {
                $household = new DbtBeneficiaryHousehold();
                $household->cbo_shg_id = $member_model->cbo_shg_id;
                $household->rishta_shg_member_id = $member_model->id;
                $household->division_code = $member_model->division_code;
                $household->division_name = $member_model->shg->division_name;
                $household->district_code = $member_model->district_code;
                $household->district_name = $member_model->shg->district_name;
                $household->block_code = $member_model->block_code;
                $household->block_name = $member_model->shg->block_name;
                $household->gram_panchayat_code = $member_model->gram_panchayat_code;
                $household->gram_panchayat_name = $member_model->shg->gram_panchayat_name;
                $household->village_code = $member_model->village_code;
                $household->village_name = $member_model->shg->village_name;
                $household->caste_category = $member_model->caste_category;
                if ($household->save()) {
                    $household_member = new DbtBeneficiaryMember();
                    $household_member->cbo_shg_id = $household->cbo_shg_id;
                    $household_member->rishta_shg_member_id = $household->rishta_shg_member_id;
                    $household_member->dbt_beneficiary_household_id = $household->id;
                    $household_member->division_code = $member_model->division_code;
                    $household_member->division_name = $member_model->shg->division_name;
                    $household_member->district_code = $member_model->district_code;
                    $household_member->district_name = $member_model->shg->district_name;
                    $household_member->block_code = $member_model->block_code;
                    $household_member->block_name = $member_model->shg->block_name;
                    $household_member->gram_panchayat_code = $member_model->gram_panchayat_code;
                    $household_member->gram_panchayat_name = $member_model->shg->gram_panchayat_name;
                    $household_member->village_code = $member_model->village_code;
                    $household_member->village_name = $member_model->shg->village_name;
                    $household_member->name = $member_model->name;
                    $household_member->mobile = $member_model->mobile;
                    $household_member->user_id = $member_model->user_id;
                    $household_member->role = $member_model->role;
                    $household_member->marital_status = $member_model->marital_status;
                    // $household_member->age = $member_model->age;
                    $household_member->relation_id = 1; //self
                    $household_member->locality_id = 1; //rural
                    $household_member->save();
                }
            }
            return $this->redirect('householdmember?shgid=' . $shgid . '&dbt_household_id=' . $household->id);
        }

        return $this->redirect('index', ['shgid' => $shgid]);
    }

    /**
     * Get List of Household Members
     *
     * @param [type] $shgid
     * @param [type] $dbt_household_id
     * @return void
     */
    public function actionHouseholdmember($shgid, $dbt_household_id) {
        $shg_model = $this->findModel($shgid);
        $household = DbtBeneficiaryHousehold::find()->where(['cbo_shg_id' => $shgid, 'id' => $dbt_household_id])->one();

        $dataProvider = new ActiveDataProvider([
            'query' => DbtBeneficiaryMember::find()->where(['cbo_shg_id' => $shgid, 'dbt_beneficiary_household_id' => $household->id]),
            'pagination' => false,
        ]);
        $totalmember = $dataProvider->getTotalCount();

        return $this->render('householdmember', [
                    'shg_model' => $shg_model,
                    'household' => $household,
                    'dataProvider' => $dataProvider,
                    'totalmember' => $totalmember
        ]);
    }

    /**
     * Add or Update Household Members
     *
     * @param [type] $shgid
     * @param [type] $dbt_household_id
     * @return void
     */
    public function actionHouseholdmemberupdate($shgid, $dbt_household_id, $dbt_member_id = null, $scenario = null) {

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new DbtBeneficiaryMemberForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {

                    $member_model = DbtBeneficiaryMember::find()->where([
                                'cbo_shg_id' => $model->cbo_shg_id,
                                'dbt_beneficiary_household_id' => $model->dbt_beneficiary_household_id,
                                'id' => $model->dbt_beneficiary_member_id
                            ])->one();
                    if ($member_model) {
                        $model->dbt_member_model = $member_model;
                    } else {
                        $model->dbt_member_model = new DbtBeneficiaryMember();
                    }

                    $model->dbt_member_model->cbo_shg_id = $model->cbo_shg_id;
                    // $model->dbt_member_model->rishta_shg_member_id = $model->rishta_shg_member_id;
                    $model->dbt_member_model->dbt_beneficiary_household_id = $model->dbt_beneficiary_household_id;
                    // $model->dbt_member_model->user_id = $model->user_id;
                    $model->dbt_member_model->cbo_shg_id = $model->cbo_shg_id;
                    if ($model->scenario == 'profile') {
                        $model->dbt_member_model->name = $model->name;
                        $model->dbt_member_model->dob = $model->dob;
                        if ($model->dbt_member_model->dob) {
                            $current_year = date('Y');
                            $birth_year = date('Y', strtotime($model->dbt_member_model->dob));
                            $model->dbt_member_model->age = abs($birth_year - $current_year);
                        } else {
                            $model->dbt_member_model->age = $model->age;
                            if ($model->dbt_member_model->age) {
                                // $model->dbt_member_model->dob = date('Y-01-01', strtotime($model->dbt_member_model->age . ' years ago'));
                            }
                        }

                        $model->dbt_member_model->mobile = $model->mobile;
                        $model->dbt_member_model->marital_status = $model->marital_status;
                        $model->dbt_member_model->gender = $model->gender;
                        $model->dbt_member_model->relation_id = $model->relation_id;
                        if (($model->dbt_member_model->name && $model->dbt_member_model->age && $model->dbt_member_model->gender && $model->dbt_member_model->relation_id) != '') {
                            $model->dbt_member_model->profile_complete = 1;
                        }
                    }

                    if ($model->scenario == 'bank') {
                        $model->dbt_member_model->bank_account_no = $model->bank_account_no;
                        $model->dbt_member_model->bank_id = $model->bank_id;
                        $bank_model = \common\models\dynamicdb\cbo_detail\master\CboMasterBank::find()->where(['id' => $model->dbt_member_model->bank_id])->one();
                        if ($bank_model) {
                            $model->dbt_member_model->name_of_bank = $bank_model->bank_name;
                        }
                        $model->dbt_member_model->branch = $model->branch;
                        $model->dbt_member_model->branch_code_or_ifsc = $model->branch_code_or_ifsc;
                        if (($model->dbt_member_model->bank_account_no && $model->dbt_member_model->bank_id && $model->dbt_member_model->branch_code_or_ifsc && $model->dbt_member_model->branch) != '') {
                            $model->dbt_member_model->bank_complete = 1;
                        }
                    }

                    if ($model->scenario == 'aadhar') {
                        $model->dbt_member_model->aadhaar_number = $model->aadhaar_number;
                        if ($model->dbt_member_model->aadhaar_number != '') {
                            $model->dbt_member_model->aadhar_complete = 1;
                        }
                    }

                    if ($model->scenario == 'vote') {
                        $model->dbt_member_model->voter_id_no = $model->voter_id_no;
                        if ($model->dbt_member_model->voter_id_no != '') {
                            $model->dbt_member_model->voter_complete = 1;
                        }
                    }

                    $model->dbt_member_model->division_code = $model->dbt_member_model->household->division_code;
                    $model->dbt_member_model->division_name = $model->dbt_member_model->household->division_name;
                    $model->dbt_member_model->district_code = $model->dbt_member_model->household->district_code;
                    $model->dbt_member_model->district_name = $model->dbt_member_model->household->district_name;
                    $model->dbt_member_model->block_code = $model->dbt_member_model->household->block_code;
                    $model->dbt_member_model->block_name = $model->dbt_member_model->household->block_name;
                    $model->dbt_member_model->gram_panchayat_code = $model->dbt_member_model->household->gram_panchayat_code;
                    $model->dbt_member_model->gram_panchayat_name = $model->dbt_member_model->household->gram_panchayat_name;
                    $model->dbt_member_model->village_code = $model->dbt_member_model->household->village_code;
                    $model->dbt_member_model->village_name = $model->dbt_member_model->household->village_name;

                    // Bank Statement Upload 
                    $APPLICATION_FORM_FILE_FOLDER = \Yii::$app->params['datapath'];

                    if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo')) {
                        mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo');
                        chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo', 0777);
                    }
                    if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/member')) {
                        mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/member');
                        chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/member', 0777);
                    }
                    if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/member/scheme')) {
                        mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/member/scheme');
                        chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/member/scheme', 0777);
                    }

                    if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/member/scheme/' . $model->dbt_beneficiary_household_id)) {
                        mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/member/scheme/' . $model->dbt_beneficiary_household_id);
                        chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/member/scheme/' . $model->dbt_beneficiary_household_id, 0777);
                    }

                    if ($model->dbt_member_model->save()) {

                        if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/member/scheme/' . $model->dbt_beneficiary_household_id . '/' . $model->dbt_member_model->id)) {
                            mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/member/scheme/' . $model->dbt_beneficiary_household_id . '/' . $model->dbt_member_model->id);
                            chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/member/scheme/' . $model->dbt_beneficiary_household_id . '/' . $model->dbt_member_model->id, 0777);
                        }
                        $APPLICATION_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . 'cbo/member/scheme/' . $model->dbt_beneficiary_household_id . '/' . $model->dbt_member_model->id;

                        if ($model->scenario == 'profile') {
                            if (isset(\Yii::$app->request->post()['DbtBeneficiaryMemberForm']['member_photo']) and \Yii::$app->request->post()['DbtBeneficiaryMemberForm']['member_photo']) {
                                $content1 = base64_decode(\Yii::$app->request->post()['DbtBeneficiaryMemberForm']['member_photo']);
                                $im1 = imagecreatefromstring($content1);
                                $image_name1 = 'member_photo_' . uniqid() . '.jpg';
                                $model->dbt_member_model->member_photo = $image_name1;

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
                        }
                        if ($model->scenario == 'bank') {
                            if (isset(\Yii::$app->request->post()['DbtBeneficiaryMemberForm']['passbook_photo']) and \Yii::$app->request->post()['DbtBeneficiaryMemberForm']['passbook_photo']) {
                                $content2 = base64_decode(\Yii::$app->request->post()['DbtBeneficiaryMemberForm']['passbook_photo']);
                                $im2 = imagecreatefromstring($content2);
                                $image_name2 = 'passbook_photo_' . uniqid() . '.jpg';
                                $model->dbt_member_model->passbook_photo = $image_name2;

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
                        }

                        if ($model->scenario == 'aadhar') {
                            if (isset(\Yii::$app->request->post()['DbtBeneficiaryMemberForm']['aadhar_front_photo']) and \Yii::$app->request->post()['DbtBeneficiaryMemberForm']['aadhar_front_photo']) {
                                $content3 = base64_decode(\Yii::$app->request->post()['DbtBeneficiaryMemberForm']['aadhar_front_photo']);
                                $im3 = imagecreatefromstring($content3);
                                $image_name3 = 'aadhar_front_photo_' . uniqid() . '.jpg';
                                $model->dbt_member_model->aadhar_front_photo = $image_name3;

                                if ($im3 !== false) {
                                    header('Content-Type: image/jpeg');
                                    imagejpeg($im3, $APPLICATION_FILE_FOLDER . '/' . $image_name3);
                                    chmod($APPLICATION_FILE_FOLDER . '/' . $image_name3, 0777);
                                    $file = new FileHelpers();
                                    $file->file_path = $APPLICATION_FILE_FOLDER;
                                    $file->file_name = $image_name3;
                                    $file->upload();
                                    imagedestroy($im3);
                                }
                            }
                            if (isset(\Yii::$app->request->post()['DbtBeneficiaryMemberForm']['aadhar_back_photo']) and \Yii::$app->request->post()['DbtBeneficiaryMemberForm']['aadhar_back_photo']) {
                                $content4 = base64_decode(\Yii::$app->request->post()['DbtBeneficiaryMemberForm']['aadhar_back_photo']);
                                $im4 = imagecreatefromstring($content4);
                                $image_name4 = 'aadhar_back_photo_' . uniqid() . '.jpg';
                                $model->dbt_member_model->aadhar_back_photo = $image_name4;

                                if ($im4 !== false) {
                                    header('Content-Type: image/jpeg');
                                    imagejpeg($im4, $APPLICATION_FILE_FOLDER . '/' . $image_name4);
                                    chmod($APPLICATION_FILE_FOLDER . '/' . $image_name4, 0777);
                                    $file = new FileHelpers();
                                    $file->file_path = $APPLICATION_FILE_FOLDER;
                                    $file->file_name = $image_name4;
                                    $file->upload();
                                    imagedestroy($im4);
                                }
                            }
                        }

                        if ($model->scenario == 'vote') {
                            if (isset(\Yii::$app->request->post()['DbtBeneficiaryMemberForm']['voter_id_photo']) and \Yii::$app->request->post()['DbtBeneficiaryMemberForm']['voter_id_photo']) {
                                $content5 = base64_decode(\Yii::$app->request->post()['DbtBeneficiaryMemberForm']['voter_id_photo']);
                                $im5 = imagecreatefromstring($content5);
                                $image_name5 = 'voter_id_photo_' . uniqid() . '.jpg';
                                $model->dbt_member_model->voter_id_photo = $image_name5;

                                if ($im5 !== false) {
                                    header('Content-Type: image/jpeg');
                                    imagejpeg($im5, $APPLICATION_FILE_FOLDER . '/' . $image_name5);
                                    chmod($APPLICATION_FILE_FOLDER . '/' . $image_name5, 0777);
                                    $file = new FileHelpers();
                                    $file->file_path = $APPLICATION_FILE_FOLDER;
                                    $file->file_name = $image_name5;
                                    $file->upload();
                                    imagedestroy($im5);
                                }
                            }
                        }

                        if ($model->dbt_member_model->save(false)) {
                            if ($model->scenario == 'vote') {
                                Yii::$app->session->setFlash('success', 'जानकारी सफलता पूर्वक प्राप्त हुआ');
                                return ['success' => true, 'dbt_member_id' => $model->dbt_member_model->id];
                            } else {
                                return ['success' => false, 'dbt_member_id' => $model->dbt_member_model->id];
                            }
                        } else {
                            return ActiveForm::validate($model->dbt_member_model);
                        }
                    } else {
                        return ActiveForm::validate($model->dbt_member_model);
                    }
                }
            }
            return ActiveForm::validate($model);
        } else {
            $household = DbtBeneficiaryHousehold::find()->where(['cbo_shg_id' => $shgid, 'id' => $dbt_household_id])->one();

            $dbt_member_model = DbtBeneficiaryMember::find()->where(['cbo_shg_id' => $shgid, 'id' => $dbt_member_id])->one();
            if ($dbt_member_model) {
                $model = new DbtBeneficiaryMemberForm($dbt_member_model);
                // $model->rishta_shg_member_id = $dbt_member_model->rishta_shg_member_id;
                // $model->dbt_member_model->rishta_shg_member_id = $household->rishta_shg_member_id;
            } else {
                $model = new DbtBeneficiaryMemberForm();
                // $model->rishta_shg_member_id = $household->rishta_shg_member_id;
                // $model->dbt_member_model->rishta_shg_member_id = $household->rishta_shg_member_id;
            }
            if ($scenario) {
                $model->scenario = $scenario;
            } else {
                $model->scenario = 'profile';
            }
            $model->cbo_shg_id = $shgid;
            $model->dbt_beneficiary_household_id = $household->id;
            $model->dbt_beneficiary_member_id = $dbt_member_id;
            // $model->user_id = $model->dbt_member_model->rishtashgmember->user_id;
            return $this->render('householdmemberupdate', ['model' => $model]);
        }
    }

    public function actionHouseholdmemberupdatecheck($shgid, $dbt_household_id, $dbt_member_id = null, $scenario = null) {
        $household = DbtBeneficiaryHousehold::find()->where(['cbo_shg_id' => $shgid, 'id' => $dbt_household_id])->one();

        $dbt_member_model = DbtBeneficiaryMember::find()->where(['cbo_shg_id' => $shgid, 'id' => $dbt_member_id])->one();
        if ($dbt_member_model) {
            $model = new DbtBeneficiaryMemberForm($dbt_member_model);
            // $model->rishta_shg_member_id = $dbt_member_model->rishta_shg_member_id;
            // $model->dbt_member_model->rishta_shg_member_id = $household->rishta_shg_member_id;
        } else {
            $model = new DbtBeneficiaryMemberForm();
            // $model->rishta_shg_member_id = $household->rishta_shg_member_id;
            // $model->dbt_member_model->rishta_shg_member_id = $household->rishta_shg_member_id;
        }
        if ($scenario) {
            $model->scenario = $scenario;
        } else {
            $model->scenario = 'profile';
        }
        $model->cbo_shg_id = $shgid;
        $model->dbt_beneficiary_household_id = $household->id;
        $model->dbt_beneficiary_member_id = $dbt_member_id;
        // $model->user_id = $model->dbt_member_model->rishtashgmember->user_id;
        return $this->renderAjax('householdmemberupdate', ['model' => $model]);
    }

    /**
     * File and Update Mgnrega Scheme Form
     *
     * @param [type] $shgid
     * @param [type] $dbt_household_id
     * @return void
     */
    public function actionMgnregascheme($shgid, $dbt_household_id, $final_step = null) {

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new DbtBeneficiarySchemeMgnregaForm();
            if ($final_step && $final_step == 2) {
                $model->scenario = 'formcomplete';
            } else {
                $model->scenario = 'setp_form';
            }
            if (Yii::$app->request->post('DbtBeneficiarySchemeMgnregaForm')['scenario'] == 'setp_current') {
                $model->scenario = 'setp_current';
            }
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    $scheme_model = DbtBeneficiarySchemeMgnrega::find()->where(['cbo_shg_id' => $shgid, 'dbt_beneficiary_household_id' => $model->dbt_beneficiary_household_id, 'id' => $model->dbt_beneficiary_scheme_mgnrega_id])->one();
                    if ($scheme_model) {
                        $model->scheme_model = $scheme_model;
                    } else {
                        $model->scheme_model = new DbtBeneficiarySchemeMgnrega();
                    }
                    if ($model->scenario == 'formcomplete') {
                        $model->scheme_model->status = 2; // Form Complete
                        $model->form_complete = 1;
                        $model->scheme_model->form_complete_date = date('Y-m-d H:i:s'); // Form Complete
                    } else if ($model->scenario == 'setp_current') {
                        $model->scheme_model->current_mgnrega_beneficiary = $model->current_mgnrega_beneficiary;
                        $model->scheme_model->current_mgnrega_beneficiary_interested_work = $model->current_mgnrega_beneficiary_interested_work;
                        $model->scheme_model->current_mgnrega_beneficiary_day = $model->current_mgnrega_beneficiary_day;
                        $model->scheme_model->current_beneficiary_section_complete = 1; // Form Intro Complete
                    } else {
                        $model->scheme_model->status = 2; // Form Filled
                        $model->scheme_model->form_complete_date = date('Y-m-d H:i:s');
                        $model->scheme_model->cbo_shg_id = $model->cbo_shg_id;
                        $model->scheme_model->rishta_shg_member_id = $model->rishta_shg_member_id;
                        $model->scheme_model->dbt_beneficiary_household_id = $model->dbt_beneficiary_household_id;
                        $model->scheme_model->mobile_number = $model->mobile_number;
                        $model->scheme_model->house_no = $model->house_no;
                        $model->scheme_model->caste_category = $model->caste_category;
                        $model->scheme_model->caste_category_name = isset($model->scheme_model->castecategory->name_hi) ? $model->scheme_model->castecategory->name_hi : null;
                        $model->scheme_model->family_head_member_id = $model->family_head_member_id;
                        DbtBeneficiaryMember::updateAll(['family_head' => 0], ['cbo_shg_id' => $model->cbo_shg_id, 'rishta_shg_member_id' => $model->rishta_shg_member_id, 'dbt_beneficiary_household_id' => $model->dbt_beneficiary_household_id]);
                        if (isset($model->scheme_model->familyhead)) {
                            $model->scheme_model->family_head_name = $model->scheme_model->familyhead->name;
                        }
                        $model->scheme_model->familyhead->family_head = 1;
                        $model->scheme_model->familyhead->save(false);
                        $model->scheme_model->minority_family = $model->minority_family;
                        $model->scheme_model->bpl_family = $model->bpl_family;
                        $model->scheme_model->bpl_secc_id = $model->bpl_secc_id;
                        $model->scheme_model->iay_beneficiary = $model->iay_beneficiary;
                        $model->scheme_model->st_or_tribal = $model->st_or_tribal;
                        $model->scheme_model->land_reforms = $model->land_reforms;
                        $model->scheme_model->small_marginal_farmers = $model->small_marginal_farmers;
                        $model->scheme_model->rsbyi_beneficiary = $model->rsbyi_beneficiary;
                        $model->scheme_model->aaby_beneficiary = $model->aaby_beneficiary;

                        $model->scheme_model->division_code = $model->scheme_model->household->division_code;
                        $model->scheme_model->division_name = $model->scheme_model->household->division_name;
                        $model->scheme_model->district_code = $model->scheme_model->household->district_code;
                        $model->scheme_model->district_name = $model->scheme_model->household->district_name;
                        $model->scheme_model->block_code = $model->scheme_model->household->block_code;
                        $model->scheme_model->block_name = $model->scheme_model->household->block_name;
                        $model->scheme_model->gram_panchayat_code = $model->scheme_model->household->gram_panchayat_code;
                        $model->scheme_model->gram_panchayat_name = $model->scheme_model->household->gram_panchayat_name;
                        $model->scheme_model->village_code = $model->scheme_model->household->village_code;
                        $model->scheme_model->village_name = $model->scheme_model->household->village_name;

                        // Update in Household
                        $model->scheme_model->household->house_no = $model->house_no;
                        $model->scheme_model->household->caste_category = $model->caste_category;
                        $model->scheme_model->household->family_head_member_id = $model->family_head_member_id;
                        $model->scheme_model->household->family_head_name = $model->scheme_model->family_head_name;

                        $model->scheme_model->household->minority_family = $model->minority_family;
                        $model->scheme_model->household->bpl_family = $model->bpl_family;
                        $model->scheme_model->household->bpl_secc_id = $model->bpl_secc_id;
                        $model->scheme_model->household->iay_beneficiary = $model->iay_beneficiary;
                        $model->scheme_model->household->st_or_tribal = $model->st_or_tribal;
                        $model->scheme_model->household->land_reforms = $model->land_reforms;
                        $model->scheme_model->household->small_marginal_farmers = $model->small_marginal_farmers;
                        $model->scheme_model->household->rsbyi_beneficiary = $model->rsbyi_beneficiary;
                        $model->scheme_model->household->aaby_beneficiary = $model->aaby_beneficiary;
                        $model->scheme_model->household->save(false);

                        DbtBeneficiarySchemeMgnregaApplicant::updateAll(['status' => 0], ['mgnrega_form_id' => $model->scheme_model->id]);
                        if ($model->applicants_ids) {
                            $applicants = DbtBeneficiaryMember::find()->where(['cbo_shg_id' => $model->cbo_shg_id, 'dbt_beneficiary_household_id' => $model->dbt_beneficiary_household_id, 'id' => $model->applicants_ids])->all();
                            if ($applicants) {
                                foreach ($applicants as $applicant) {
                                    $mgnrega_applicant = DbtBeneficiarySchemeMgnregaApplicant::find()->where(['cbo_shg_id' => $model->cbo_shg_id, 'dbt_beneficiary_household_id' => $model->dbt_beneficiary_household_id, 'mgnrega_form_id' => $model->scheme_model->id, 'dbt_beneficiary_member_id' => $applicant->id])->one();
                                    if (!$mgnrega_applicant) {
                                        $mgnrega_applicant = new DbtBeneficiarySchemeMgnregaApplicant();
                                    }
                                    $mgnrega_applicant->setAttributes($applicant->toArray());
                                    $mgnrega_applicant->mgnrega_form_id = $model->scheme_model->id;
                                    $mgnrega_applicant->dbt_beneficiary_member_id = $applicant->id;
                                    $mgnrega_applicant->status = 1;
                                    $mgnrega_applicant->save(false);
                                }
                            }
                        }
                    }

                    if ($model->scenario == 'setp_current') {
                        $APPLICATION_FORM_FILE_FOLDER = \Yii::$app->params['datapath'];
                        if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo')) {
                            mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo');
                            chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo', 0777);
                        }
                        if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/member')) {
                            mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/member');
                            chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/member', 0777);
                        }
                        if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/scheme')) {
                            mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/scheme');
                            chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/scheme', 0777);
                        }

                        if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/scheme/mgnrega')) {
                            mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/scheme/mgnrega');
                            chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/scheme/mgnrega', 0777);
                        }
                        if (!file_exists($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/scheme/mgnrega' . '/' . $model->scheme_model->household->id)) {
                            mkdir($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/scheme/mgnrega' . '/' . $model->scheme_model->household->id);
                            chmod($APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/scheme/mgnrega' . '/' . $model->scheme_model->household->id, 0777);
                        }
                        $APPLICATION_FILE_FOLDER = $APPLICATION_FORM_FILE_FOLDER . 'cbo/member' . '/scheme/mgnrega' . '/' . $model->scheme_model->household->id;
                        $model->scheme_model->current_mgnrega_beneficiary = $model->current_mgnrega_beneficiary;
                        $model->scheme_model->current_mgnrega_beneficiary_interested_work = $model->current_mgnrega_beneficiary_interested_work;
                        if ($model->current_mgnrega_beneficiary_interested_work == 1) {
                            $model->scheme_model->current_mgnrega_beneficiary_day = $model->current_mgnrega_beneficiary_day;
                        }
                        $model->scheme_model->household->current_mgnrega_beneficiary = $model->current_mgnrega_beneficiary;
                        $model->scheme_model->household->current_mgnrega_beneficiary_interested_work = $model->scheme_model->current_mgnrega_beneficiary_interested_work;
                        $model->scheme_model->household->current_mgnrega_beneficiary_day = $model->scheme_model->current_mgnrega_beneficiary_day;

                        if (isset(\Yii::$app->request->post()['DbtBeneficiarySchemeMgnregaForm']['current_job_card_photo']) and \Yii::$app->request->post()['DbtBeneficiarySchemeMgnregaForm']['current_job_card_photo']) {
                            $content = base64_decode(\Yii::$app->request->post()['DbtBeneficiarySchemeMgnregaForm']['current_job_card_photo']);
                            $im = imagecreatefromstring($content);
                            $image_name = 'mgnrega_job_card_photo_' . uniqid() . '.jpg';
                            $model->scheme_model->current_job_card_photo = $image_name;
                            $model->scheme_model->household->current_job_card_photo = $image_name;
                            if ($im !== false) {
                                header('Content-Type: image/jpeg');
                                imagejpeg($im, $APPLICATION_FILE_FOLDER . '/' . $image_name);
                                chmod($APPLICATION_FILE_FOLDER . '/' . $image_name, 0777);
                                $file = new FileHelpers();
                                $file->file_path = $APPLICATION_FILE_FOLDER;
                                $file->file_name = $image_name;
                                $file->upload();
                                imagedestroy($im);
                            }
                        }
                        $model->scheme_model->household->save(false);
                    }
                    if ($model->scheme_model->save()) {
                        Yii::$app->session->setFlash('success', 'जानकारी सफलता पूर्वक प्राप्त हुआ');
                        if ($model->scenario = 'setp_current') {
                            if ($model->current_mgnrega_beneficiary_interested_work == 1) {
                                $url = '/shg/member/mgnregascheme?shgid=' . $shgid . '&dbt_household_id=' . $model->scheme_model->household->id;
                                //                                $js = "window.location.href = '$url'";
                                //                                $this->getView()->registerJs($js);
                                //                                return $this->render('mgnregascheme', ['model' => $model]);
                                //                                return Yii::$app->getResponse()->redirect($url);
                                //                                exit;
                                //return $this->redirect(['/shg/member/mgnregascheme?shgid=' . $shgid . '&dbt_household_id=' . $model->scheme_model->household->id]);
                                return ['success' => true];
                            }
                            return ['success' => true];
                        }
                        return ['success' => true];
                    } else {
                        return ActiveForm::validate($model->scheme_model);
                    }
                }
            }
            return ActiveForm::validate($model);
        } else {
            $household = DbtBeneficiaryHousehold::find()->where(['cbo_shg_id' => $shgid, 'id' => $dbt_household_id])->one();

            $scheme_model = DbtBeneficiarySchemeMgnrega::find()->where(['cbo_shg_id' => $shgid, 'dbt_beneficiary_household_id' => $dbt_household_id])->one();
            if ($scheme_model) {
                
            } else {
                $scheme_model = new DbtBeneficiarySchemeMgnrega();
                $scheme_model->cbo_shg_id = $shgid;
                $scheme_model->rishta_shg_member_id = $household->rishta_shg_member_id;
                $scheme_model->dbt_beneficiary_household_id = $dbt_household_id;
                $scheme_model->division_code = $scheme_model->household->division_code;
                $scheme_model->division_name = $scheme_model->household->division_name;
                $scheme_model->district_code = $scheme_model->household->district_code;
                $scheme_model->district_name = $scheme_model->household->district_name;
                $scheme_model->block_code = $scheme_model->household->block_code;
                $scheme_model->block_name = $scheme_model->household->block_name;
                $scheme_model->gram_panchayat_code = $scheme_model->household->gram_panchayat_code;
                $scheme_model->gram_panchayat_name = $scheme_model->household->gram_panchayat_name;
                $scheme_model->village_code = $scheme_model->household->village_code;
                $scheme_model->village_name = $scheme_model->household->village_name;
                $scheme_model->house_no = $scheme_model->household->house_no;
                $scheme_model->caste_category = $scheme_model->household->caste_category;
                $scheme_model->family_head_name = $scheme_model->household->family_head_name;
                $scheme_model->family_head_member_id = $scheme_model->family_head_member_id;
                $scheme_model->minority_family = $scheme_model->minority_family;
                $scheme_model->save(false);
            }
            $model = new DbtBeneficiarySchemeMgnregaForm($scheme_model);
            if ($final_step && $final_step == 2) {
                $model->scenario = 'formcomplete';
            } else {
                $model->scenario = 'setp_form';
            }
            if ($scheme_model->current_mgnrega_beneficiary == 0) {
                $model->scenario = 'setp_current';
            }
            $model->rishta_shg_member_id = $household->rishta_shg_member_id;
            $model->cbo_shg_id = $shgid;
            $model->dbt_beneficiary_household_id = $household->id;
            $model->dbt_beneficiary_scheme_mgnrega_id = $scheme_model->id;

            return $this->render('mgnregascheme', ['model' => $model]);
        }
    }

    public function actionBocw($shgid, $dbt_household_id) {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $household = DbtBeneficiaryHousehold::find()->where(['cbo_shg_id' => $shgid, 'id' => $dbt_household_id])->one();
            $model = new \common\models\dynamicdb\cbo_detail\dbt\form\DbtBeneficaryHouseholdbocwForm($household);
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    $model->household_model->bocw_reg_no = $model->bocw_reg_no;
                    $model->household_model->bocw = 1;
                    $model->household_model->bocw_date = new \yii\db\Expression('NOW()');
                    $model->household_model->bocw_by = \Yii::$app->user->identity->id;
                    if ($model->household_model->save()) {
                        Yii::$app->session->setFlash('success', 'जानकारी सफलता पूर्वक प्राप्त हुआ');
                        return ['success' => true];
                    } else {
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ActiveForm::validate($model);
                    }
                }
            } else {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        } else {
            $household = DbtBeneficiaryHousehold::find()->where(['cbo_shg_id' => $shgid, 'id' => $dbt_household_id])->one();
            $model = new \common\models\dynamicdb\cbo_detail\dbt\form\DbtBeneficaryHouseholdbocwForm($household);
            $model->rishta_shg_member_id = $household->rishta_shg_member_id;
            $model->cbo_shg_id = $shgid;
            $model->dbt_beneficiary_household_id = $household->id;
            return $this->render('householdbocw', ['model' => $model]);
        }
    }

    public function actionBocwform($shgid, $dbt_household_id, $dbt_member_id) {
        $dbt_member_model = DbtBeneficiaryMember::find()->where(['cbo_shg_id' => $shgid, 'id' => $dbt_member_id])->one();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new \common\models\dynamicdb\cbo_detail\dbt\form\DbtBeneficiarySchemeBocwForm($dbt_member_model);
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (isset($_REQUEST['SubmitRequest']) && $_REQUEST['SubmitRequest'] == "1") {
                    $model->member_bocw_application_model->setAttributes($dbt_member_model->toArray());
                    $model->member_bocw_application_model->dbt_beneficiary_member_id = $model->dbt_beneficiary_member_id;
                    $model->member_bocw_application_model->bocw_reg_no = $model->bocw_reg_no;
                    $model->member_bocw_application_model->application_number = $model->application_number;
                    $model->member_bocw_application_model->application_date = $model->application_date;
                    $model->member_bocw_application_model->scheme_id = $model->scheme_id;
                    $model->member_bocw_application_model->no_of_family_member = DbtBeneficiaryMember::find()->where(['dbt_beneficiary_household_id' => $dbt_member_model->dbt_beneficiary_household_id])->andWhere(['!=', 'status', -1])->count();
                    if ($model->member_bocw_application_model->save()) {
                        Yii::$app->session->setFlash('success', 'जानकारी सफलता पूर्वक प्राप्त हुआ');
                        return ['success' => true];
                    } else {
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ActiveForm::validate($model);
                    }
                }
            } else {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        } else {
            $household = DbtBeneficiaryHousehold::find()->where(['cbo_shg_id' => $shgid, 'id' => $dbt_household_id])->one();
            $dbt_member_model = DbtBeneficiaryMember::find()->where(['cbo_shg_id' => $shgid, 'id' => $dbt_member_id])->one();
            $model = new \common\models\dynamicdb\cbo_detail\dbt\form\DbtBeneficiarySchemeBocwForm($dbt_member_model);
            $model->cbo_shg_id = $shgid;
            $model->dbt_beneficiary_household_id = $household->id;
            $model->dbt_beneficiary_member_id = $dbt_member_id;
            return $this->render('_bocw_application_form', ['model' => $model]);
        }
    }

    /**
     * Find SHG Model
     *
     * @param [type] $id
     * @return void
     */
    protected function findModel($id) {
        if (($model = Shg::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }

}
