<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\db\Expression;
use yii\web\UploadedFile;
use yii\base\ActionEvent;
use yii\base\Application;
use yii\base\Model;
use bc\modules\selection\models\SrlmBcSelectionApiLog;
use bc\modules\selection\models\SrlmBcSelectionAppDetail;
use bc\modules\selection\models\SrlmBcSelectionUser;
use bc\modules\selection\models\SrlmBcApplication;
//use bc\modules\selection\models\SrlmBcApplication2;
//use bc\modules\selection\models\SrlmBcApplication3;
//use bc\modules\selection\models\SrlmBcApplication4;
//use bc\modules\selection\models\SrlmBcApplication5;
//use bc\modules\selection\models\SrlmBcApplication6;
use bc\modules\selection\models\SrlmBcApplication7;
//use bc\modules\selection\models\SrlmBcApplicationGroupFamily2;
//use bc\modules\selection\models\SrlmBcApplicationGroupFamily3;
//use bc\modules\selection\models\SrlmBcApplicationGroupFamily4;
//use bc\modules\selection\models\SrlmBcApplicationGroupFamily5;
//use bc\modules\selection\models\SrlmBcApplicationGroupFamily6;
use bc\modules\selection\models\SrlmBcApplicationGroupFamily7;
use bc\modules\selection\models\SrlmBcSelectionApiLog20200621;
use bc\modules\selection\models\BcApplicationCrone;
use console\helpers\Utility;

/**
 * This command process SRLM DATA
 *
 * @author Habibur Rahman <rahman.kld@gmail.com>
 * @since 2.0
 */
class SrlmbcapplicationController extends Controller {

    public $process_limt = 5000;
    public $user_process_limit = 1000;
    public $data_json = [];

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionParse() {
        echo "Phase 5 Parse Application Cron Strat Time : " . date('Y-m-d H:i:s');
        \Yii::$app->runAction('srlmbcapplication/rsph6');
        \Yii::$app->runAction('srlmbcapplication/process');
        \Yii::$app->runAction('srlmbcapplication/gpcomplete');
        echo "Phase 4 Parse Application Cron End Time : " . date('Y-m-d H:i:s');
        return ExitCode::OK;
    }

//    public function actionProcess() {
//        $max = SrlmBcApplication::find()->max('srlm_bc_selection_api_log_id');
//        $max = $max != NULL ? $max : 0;
//
//        $models = SrlmBcSelectionApiLog20200621::find()->where(['>', 'id', $max])->andWhere(['!=', 'srlm_bc_selection_user_id', 0])->andWhere(['http_response_code' => 200])->andWhere(['request_url' => 'api/v2/user/formsave'])->orderBy('id asc')->limit($this->process_limt)->all();
//        foreach ($models as $model) {
//            $this->data_json = json_decode($model->request_body, true);
////            print_r($this->data_json);exit;
//            $srlm_bc_application = SrlmBcApplication::findOne(['srlm_bc_selection_user_id' => $model->srlm_bc_selection_user_id]);
//            if (!empty($srlm_bc_application)) {
//                if (isset($this->data_json['form_uuid']))
//                    $srlm_bc_application->form_uuid = $this->data_json['form_uuid'];
//                if (isset($this->data_json['first_name']) and $this->data_json['first_name'])
//                    $srlm_bc_application->first_name = $this->data_json['first_name'];
//                if (isset($this->data_json['middle_name']) and $this->data_json['middle_name'])
//                    $srlm_bc_application->middle_name = $this->data_json['middle_name'];
//                if (isset($this->data_json['sur_name']) and $this->data_json['sur_name'])
//                    $srlm_bc_application->sur_name = $this->data_json['sur_name'];
//                if (isset($this->data_json['gender']) and $this->data_json['gender'])
//                    $srlm_bc_application->gender = $this->data_json['gender'];
//                if (isset($this->data_json['age']) and $this->data_json['age'])
//                    $srlm_bc_application->age = $this->data_json['age'];
//                if (isset($this->data_json['cast']) and $this->data_json['cast'])
//                    $srlm_bc_application->cast = $this->data_json['cast'];
//                if (isset($this->data_json['district_name']) and $this->data_json['district_name'])
//                    $srlm_bc_application->district_name = $this->data_json['district_name'];
//                if (isset($this->data_json['block_name']) and $this->data_json['block_name'])
//                    $srlm_bc_application->block_name = $this->data_json['block_name'];
//                if (isset($this->data_json['gram_panchayat_name']) and $this->data_json['gram_panchayat_name'])
//                    $srlm_bc_application->gram_panchayat_name = $this->data_json['gram_panchayat_name'];
//                if (isset($this->data_json['village_name']) and $this->data_json['village_name'])
//                    $srlm_bc_application->village_name = $this->data_json['village_name'];
//                if (isset($this->data_json['hamlet']) and $this->data_json['hamlet'])
//                    $srlm_bc_application->hamlet = $this->data_json['hamlet'];
//                if (isset($this->data_json['district_code']) and $this->data_json['district_code'])
//                    $srlm_bc_application->district_code = $this->data_json['district_code'];
//                if (isset($this->data_json['block_code']) and $this->data_json['block_code'])
//                    $srlm_bc_application->block_code = $this->data_json['block_code'];
//                if (isset($this->data_json['gram_panchayat_code']) and $this->data_json['gram_panchayat_code'])
//                    $srlm_bc_application->gram_panchayat_code = $this->data_json['gram_panchayat_code'];
//                if (isset($this->data_json['village_code']) and $this->data_json['village_code'])
//                    $srlm_bc_application->village_code = $this->data_json['village_code'];
//                if (isset($this->data_json['aadhar_number']) and $this->data_json['aadhar_number'])
//                    $srlm_bc_application->aadhar_number = $this->data_json['aadhar_number'];
//                if (isset($this->data_json['guardian_name']) and $this->data_json['guardian_name'])
//                    $srlm_bc_application->guardian_name = $this->data_json['guardian_name'];
//                if (isset($this->data_json['reading_skills']) and $this->data_json['reading_skills'])
//                    $srlm_bc_application->reading_skills = $this->data_json['reading_skills'];
//                if (isset($this->data_json['mobile_number']) and $this->data_json['mobile_number'])
//                    $srlm_bc_application->mobile_number = $this->data_json['mobile_number'];
//                if (isset($this->data_json['phone_type']) and $this->data_json['phone_type'])
//                    $srlm_bc_application->phone_type = $this->data_json['phone_type'];
//                if (isset($this->data_json['what_else_with_mobile1']) and $this->data_json['what_else_with_mobile1'])
//                    $srlm_bc_application->what_else_with_mobile1 = $this->data_json['what_else_with_mobile1'];
//                if (isset($this->data_json['what_else_with_mobile2']) and $this->data_json['what_else_with_mobile2'])
//                    $srlm_bc_application->what_else_with_mobile2 = $this->data_json['what_else_with_mobile2'];
//                if (isset($this->data_json['what_else_with_mobile3']) and $this->data_json['what_else_with_mobile3'])
//                    $srlm_bc_application->what_else_with_mobile3 = $this->data_json['what_else_with_mobile3'];
//                if (isset($this->data_json['what_else_with_mobile4']) and $this->data_json['what_else_with_mobile4'])
//                    $srlm_bc_application->what_else_with_mobile4 = $this->data_json['what_else_with_mobile4'];
//                if (isset($this->data_json['what_else_with_mobile5']) and $this->data_json['what_else_with_mobile5'])
//                    $srlm_bc_application->what_else_with_mobile5 = $this->data_json['what_else_with_mobile5'];
//                if (isset($this->data_json['whats_app_number']) and $this->data_json['whats_app_number'])
//                    $srlm_bc_application->whats_app_number = $this->data_json['whats_app_number'];
//                if (isset($this->data_json['vechicle_drive1']) and $this->data_json['vechicle_drive1'])
//                    $srlm_bc_application->vechicle_drive1 = $this->data_json['vechicle_drive1'];
//                if (isset($this->data_json['vechicle_drive2']) and $this->data_json['vechicle_drive2'])
//                    $srlm_bc_application->vechicle_drive2 = $this->data_json['vechicle_drive2'];
//                if (isset($this->data_json['vechicle_drive3']) and $this->data_json['vechicle_drive3'])
//                    $srlm_bc_application->vechicle_drive3 = $this->data_json['vechicle_drive3'];
//                if (isset($this->data_json['vechicle_drive4']) and $this->data_json['vechicle_drive4'])
//                    $srlm_bc_application->vechicle_drive4 = $this->data_json['vechicle_drive4'];
//                if (isset($this->data_json['vechicle_drive5']) and $this->data_json['vechicle_drive5'])
//                    $srlm_bc_application->vechicle_drive5 = $this->data_json['vechicle_drive5'];
//                if (isset($this->data_json['vechicle_drive6']) and $this->data_json['vechicle_drive6'])
//                    $srlm_bc_application->vechicle_drive6 = $this->data_json['vechicle_drive6'];
//                if (isset($this->data_json['marital_status']) and $this->data_json['marital_status'])
//                    $srlm_bc_application->marital_status = $this->data_json['marital_status'];
//                if (isset($this->data_json['house_member_details1']) and $this->data_json['house_member_details1'])
//                    $srlm_bc_application->house_member_details1 = $this->data_json['house_member_details1'];
//                if (isset($this->data_json['house_member_details2']) and $this->data_json['house_member_details2'])
//                    $srlm_bc_application->house_member_details2 = $this->data_json['house_member_details2'];
//                if (isset($this->data_json['house_member_details3']) and $this->data_json['house_member_details3'])
//                    $srlm_bc_application->house_member_details3 = $this->data_json['house_member_details3'];
//                if (isset($this->data_json['future_scope1']) and $this->data_json['future_scope1'])
//                    $srlm_bc_application->future_scope1 = $this->data_json['future_scope1'];
//                if (isset($this->data_json['future_scope2']) and $this->data_json['future_scope2'])
//                    $srlm_bc_application->future_scope2 = $this->data_json['future_scope2'];
//                if (isset($this->data_json['future_scope3']) and $this->data_json['future_scope3'])
//                    $srlm_bc_application->future_scope3 = $this->data_json['future_scope3'];
//                if (isset($this->data_json['future_scope4']) and $this->data_json['future_scope4'])
//                    $srlm_bc_application->future_scope4 = $this->data_json['future_scope4'];
//                if (isset($this->data_json['future_scope5']) and $this->data_json['future_scope5'])
//                    $srlm_bc_application->future_scope5 = $this->data_json['future_scope5'];
//                if (isset($this->data_json['future_scope6']) and $this->data_json['future_scope6'])
//                    $srlm_bc_application->future_scope6 = $this->data_json['future_scope6'];
//                if (isset($this->data_json['future_scope7']) and $this->data_json['future_scope7'])
//                    $srlm_bc_application->future_scope7 = $this->data_json['future_scope7'];
//                if (isset($this->data_json['future_scope8']) and $this->data_json['future_scope8'])
//                    $srlm_bc_application->future_scope8 = $this->data_json['future_scope8'];
//                if (isset($this->data_json['future_scope9']) and $this->data_json['future_scope9'])
//                    $srlm_bc_application->future_scope9 = $this->data_json['future_scope9'];
//                if (isset($this->data_json['future_scope10']) and $this->data_json['future_scope10'])
//                    $srlm_bc_application->future_scope10 = $this->data_json['future_scope10'];
//                if (isset($this->data_json['future_scope11']) and $this->data_json['future_scope11'])
//                    $srlm_bc_application->future_scope11 = $this->data_json['future_scope11'];
//                if (isset($this->data_json['future_scope12']) and $this->data_json['future_scope12'])
//                    $srlm_bc_application->future_scope12 = $this->data_json['future_scope12'];
//                if (isset($this->data_json['opportunities_for_livelihood1']) and $this->data_json['opportunities_for_livelihood1'])
//                    $srlm_bc_application->opportunities_for_livelihood1 = $this->data_json['opportunities_for_livelihood1'];
//                if (isset($this->data_json['opportunities_for_livelihood2']) and $this->data_json['opportunities_for_livelihood2'])
//                    $srlm_bc_application->opportunities_for_livelihood2 = $this->data_json['opportunities_for_livelihood2'];
//                if (isset($this->data_json['opportunities_for_livelihood3']) and $this->data_json['opportunities_for_livelihood3'])
//                    $srlm_bc_application->opportunities_for_livelihood3 = $this->data_json['opportunities_for_livelihood3'];
//                if (isset($this->data_json['opportunities_for_livelihood4']) and $this->data_json['opportunities_for_livelihood4'])
//                    $srlm_bc_application->opportunities_for_livelihood4 = $this->data_json['opportunities_for_livelihood4'];
//                if (isset($this->data_json['opportunities_for_livelihood5']) and $this->data_json['opportunities_for_livelihood5'])
//                    $srlm_bc_application->opportunities_for_livelihood5 = $this->data_json['opportunities_for_livelihood5'];
//                if (isset($this->data_json['opportunities_for_livelihood6']) and $this->data_json['opportunities_for_livelihood6'])
//                    $srlm_bc_application->opportunities_for_livelihood6 = $this->data_json['opportunities_for_livelihood6'];
//                if (isset($this->data_json['opportunities_for_livelihood7']) and $this->data_json['opportunities_for_livelihood7'])
//                    $srlm_bc_application->opportunities_for_livelihood7 = $this->data_json['opportunities_for_livelihood7'];
//                if (isset($this->data_json['opportunities_for_livelihood8']) and $this->data_json['opportunities_for_livelihood8'])
//                    $srlm_bc_application->opportunities_for_livelihood8 = $this->data_json['opportunities_for_livelihood8'];
//                if (isset($this->data_json['opportunities_for_livelihood9']) and $this->data_json['opportunities_for_livelihood9'])
//                    $srlm_bc_application->opportunities_for_livelihood9 = $this->data_json['opportunities_for_livelihood9'];
//                if (isset($this->data_json['opportunities_for_livelihood10']) and $this->data_json['opportunities_for_livelihood10'])
//                    $srlm_bc_application->opportunities_for_livelihood10 = $this->data_json['opportunities_for_livelihood10'];
//                if (isset($this->data_json['other_occupation']) and $this->data_json['other_occupation'])
//                    $srlm_bc_application->other_occupation = $this->data_json['other_occupation'];
//                if (isset($this->data_json['planning_intervention1']) and $this->data_json['planning_intervention1'])
//                    $srlm_bc_application->planning_intervention1 = $this->data_json['planning_intervention1'];
//                if (isset($this->data_json['planning_intervention2']) and $this->data_json['planning_intervention2'])
//                    $srlm_bc_application->planning_intervention2 = $this->data_json['planning_intervention2'];
//                if (isset($this->data_json['planning_intervention3']) and $this->data_json['planning_intervention3'])
//                    $srlm_bc_application->planning_intervention3 = $this->data_json['planning_intervention3'];
//                if (isset($this->data_json['planning_intervention4']) and $this->data_json['planning_intervention4'])
//                    $srlm_bc_application->planning_intervention4 = $this->data_json['planning_intervention4'];
//                if (isset($this->data_json['planning_intervention5']) and $this->data_json['planning_intervention5'])
//                    $srlm_bc_application->planning_intervention5 = $this->data_json['planning_intervention5'];
//                if (isset($this->data_json['planning_intervention6']) and $this->data_json['planning_intervention6'])
//                    $srlm_bc_application->planning_intervention6 = $this->data_json['planning_intervention6'];
//                if (isset($this->data_json['immediate_aspiration1']) and $this->data_json['immediate_aspiration1'])
//                    $srlm_bc_application->immediate_aspiration1 = $this->data_json['immediate_aspiration1'];
//                if (isset($this->data_json['immediate_aspiration2']) and $this->data_json['immediate_aspiration2'])
//                    $srlm_bc_application->immediate_aspiration2 = $this->data_json['immediate_aspiration2'];
//                if (isset($this->data_json['immediate_aspiration3']) and $this->data_json['immediate_aspiration3'])
//                    $srlm_bc_application->immediate_aspiration3 = $this->data_json['immediate_aspiration3'];
//                if (isset($this->data_json['immediate_aspiration4']) and $this->data_json['immediate_aspiration4'])
//                    $srlm_bc_application->immediate_aspiration4 = $this->data_json['immediate_aspiration4'];
//                if (isset($this->data_json['immediate_aspiration5']) and $this->data_json['immediate_aspiration5'])
//                    $srlm_bc_application->immediate_aspiration5 = $this->data_json['immediate_aspiration5'];
//                if (isset($this->data_json['immediate_aspiration6']) and $this->data_json['immediate_aspiration6'])
//                    $srlm_bc_application->immediate_aspiration6 = $this->data_json['immediate_aspiration6'];
//                if (isset($this->data_json['already_group_member']) and $this->data_json['already_group_member'])
//                    $srlm_bc_application->already_group_member = $this->data_json['already_group_member'];
//                if (isset($this->data_json['your_group_name']) and $this->data_json['your_group_name'])
//                    $srlm_bc_application->your_group_name = $this->data_json['your_group_name'];
//                if (isset($this->data_json['which_program_your_group_formed']) and $this->data_json['which_program_your_group_formed'])
//                    $srlm_bc_application->which_program_your_group_formed = $this->data_json['which_program_your_group_formed'];
//                if (isset($this->data_json['thought_of_forming_group']) and $this->data_json['thought_of_forming_group'])
//                    $srlm_bc_application->thought_of_forming_group = $this->data_json['thought_of_forming_group'];
//                if (isset($this->data_json['try_towards_group_formation1']) and $this->data_json['try_towards_group_formation1'])
//                    $srlm_bc_application->try_towards_group_formation1 = $this->data_json['try_towards_group_formation1'];
//                if (isset($this->data_json['try_towards_group_formation2']) and $this->data_json['try_towards_group_formation2'])
//                    $srlm_bc_application->try_towards_group_formation2 = $this->data_json['try_towards_group_formation2'];
//                if (isset($this->data_json['try_towards_group_formation3']) and $this->data_json['try_towards_group_formation3'])
//                    $srlm_bc_application->try_towards_group_formation3 = $this->data_json['try_towards_group_formation3'];
//                if (isset($this->data_json['try_towards_group_formation4']) and $this->data_json['try_towards_group_formation4'])
//                    $srlm_bc_application->try_towards_group_formation4 = $this->data_json['try_towards_group_formation4'];
//                if (isset($this->data_json['try_towards_group_formation5']) and $this->data_json['try_towards_group_formation5'])
//                    $srlm_bc_application->try_towards_group_formation5 = $this->data_json['try_towards_group_formation5'];
//                if (isset($this->data_json['try_towards_group_formation6']) and $this->data_json['try_towards_group_formation6'])
//                    $srlm_bc_application->try_towards_group_formation6 = $this->data_json['try_towards_group_formation6'];
//                if (isset($this->data_json['try_towards_group_formation7']) and $this->data_json['try_towards_group_formation7'])
//                    $srlm_bc_application->try_towards_group_formation7 = $this->data_json['try_towards_group_formation7'];
//                if (isset($this->data_json['try_towards_group_formation8']) and $this->data_json['try_towards_group_formation8'])
//                    $srlm_bc_application->try_towards_group_formation8 = $this->data_json['try_towards_group_formation8'];
//                if (isset($this->data_json['leadership_name_index']) and $this->data_json['leadership_name_index'])
//                    $srlm_bc_application->leadership_name_index = $this->data_json['leadership_name_index'];
//                if (isset($this->data_json['leadership_name']) and $this->data_json['leadership_name'])
//                    $srlm_bc_application->leadership_name = $this->data_json['leadership_name'];
//                if (isset($this->data_json['role_in_group1']) and $this->data_json['role_in_group1'])
//                    $srlm_bc_application->role_in_group1 = $this->data_json['role_in_group1'];
//                if (isset($this->data_json['role_in_group2']) and $this->data_json['role_in_group2'])
//                    $srlm_bc_application->role_in_group2 = $this->data_json['role_in_group2'];
//                if (isset($this->data_json['role_in_group3']) and $this->data_json['role_in_group3'])
//                    $srlm_bc_application->role_in_group3 = $this->data_json['role_in_group3'];
//                if (isset($this->data_json['role_in_group4']) and $this->data_json['role_in_group4'])
//                    $srlm_bc_application->role_in_group4 = $this->data_json['role_in_group4'];
//                if (isset($this->data_json['role_in_group5']) and $this->data_json['role_in_group5'])
//                    $srlm_bc_application->role_in_group5 = $this->data_json['role_in_group5'];
//                if (isset($this->data_json['role_in_group6']) and $this->data_json['role_in_group6'])
//                    $srlm_bc_application->role_in_group6 = $this->data_json['role_in_group6'];
//                if (isset($this->data_json['role_in_group7']) and $this->data_json['role_in_group7'])
//                    $srlm_bc_application->role_in_group7 = $this->data_json['role_in_group7'];
//                if (isset($this->data_json['role_in_group8']) and $this->data_json['role_in_group8'])
//                    $srlm_bc_application->role_in_group8 = $this->data_json['role_in_group8'];
//                if (isset($this->data_json['why_did_you_get_elected1']) and $this->data_json['why_did_you_get_elected1'])
//                    $srlm_bc_application->why_did_you_get_elected1 = $this->data_json['why_did_you_get_elected1'];
//                if (isset($this->data_json['why_did_you_get_elected2']) and $this->data_json['why_did_you_get_elected2'])
//                    $srlm_bc_application->why_did_you_get_elected2 = $this->data_json['why_did_you_get_elected2'];
//                if (isset($this->data_json['why_did_you_get_elected3']) and $this->data_json['why_did_you_get_elected3'])
//                    $srlm_bc_application->why_did_you_get_elected3 = $this->data_json['why_did_you_get_elected3'];
//                if (isset($this->data_json['why_did_you_get_elected4']) and $this->data_json['why_did_you_get_elected4'])
//                    $srlm_bc_application->why_did_you_get_elected4 = $this->data_json['why_did_you_get_elected4'];
//                if (isset($this->data_json['why_did_you_get_elected5']) and $this->data_json['why_did_you_get_elected5'])
//                    $srlm_bc_application->why_did_you_get_elected5 = $this->data_json['why_did_you_get_elected5'];
//                if (isset($this->data_json['why_did_you_get_elected6']) and $this->data_json['why_did_you_get_elected6'])
//                    $srlm_bc_application->why_did_you_get_elected6 = $this->data_json['why_did_you_get_elected6'];
//                if (isset($this->data_json['why_did_you_get_elected7']) and $this->data_json['why_did_you_get_elected7'])
//                    $srlm_bc_application->why_did_you_get_elected7 = $this->data_json['why_did_you_get_elected7'];
//                if (isset($this->data_json['why_did_you_get_elected8']) and $this->data_json['why_did_you_get_elected8'])
//                    $srlm_bc_application->why_did_you_get_elected8 = $this->data_json['why_did_you_get_elected8'];
//                if (isset($this->data_json['why_did_you_get_elected9']) and $this->data_json['why_did_you_get_elected9'])
//                    $srlm_bc_application->why_did_you_get_elected9 = $this->data_json['why_did_you_get_elected9'];
//                if (isset($this->data_json['if_you_were_a_member_of_a_self_help_group1']) and $this->data_json['if_you_were_a_member_of_a_self_help_group1'])
//                    $srlm_bc_application->if_you_were_a_member_of_a_self_help_group1 = $this->data_json['if_you_were_a_member_of_a_self_help_group1'];
//                if (isset($this->data_json['if_you_were_a_member_of_a_self_help_group2']) and $this->data_json['if_you_were_a_member_of_a_self_help_group2'])
//                    $srlm_bc_application->if_you_were_a_member_of_a_self_help_group2 = $this->data_json['if_you_were_a_member_of_a_self_help_group2'];
//                if (isset($this->data_json['if_you_were_a_member_of_a_self_help_group3']) and $this->data_json['if_you_were_a_member_of_a_self_help_group3'])
//                    $srlm_bc_application->if_you_were_a_member_of_a_self_help_group3 = $this->data_json['if_you_were_a_member_of_a_self_help_group3'];
//                if (isset($this->data_json['if_you_were_a_member_of_a_self_help_group4']) and $this->data_json['if_you_were_a_member_of_a_self_help_group4'])
//                    $srlm_bc_application->if_you_were_a_member_of_a_self_help_group4 = $this->data_json['if_you_were_a_member_of_a_self_help_group4'];
//                if (isset($this->data_json['if_you_were_a_member_of_a_self_help_group5']) and $this->data_json['if_you_were_a_member_of_a_self_help_group5'])
//                    $srlm_bc_application->if_you_were_a_member_of_a_self_help_group5 = $this->data_json['if_you_were_a_member_of_a_self_help_group5'];
//                if (isset($this->data_json['if_you_were_a_member_of_a_self_help_group6']) and $this->data_json['if_you_were_a_member_of_a_self_help_group6'])
//                    $srlm_bc_application->if_you_were_a_member_of_a_self_help_group6 = $this->data_json['if_you_were_a_member_of_a_self_help_group6'];
//                if (isset($this->data_json['if_you_were_a_member_of_a_self_help_group7']) and $this->data_json['if_you_were_a_member_of_a_self_help_group7'])
//                    $srlm_bc_application->if_you_were_a_member_of_a_self_help_group7 = $this->data_json['if_you_were_a_member_of_a_self_help_group7'];
//                if (isset($this->data_json['if_you_were_a_member_of_a_self_help_group8']) and $this->data_json['if_you_were_a_member_of_a_self_help_group8'])
//                    $srlm_bc_application->if_you_were_a_member_of_a_self_help_group8 = $this->data_json['if_you_were_a_member_of_a_self_help_group8'];
//                if (isset($this->data_json['if_you_were_a_member_of_a_self_help_group9']) and $this->data_json['if_you_were_a_member_of_a_self_help_group9'])
//                    $srlm_bc_application->if_you_were_a_member_of_a_self_help_group9 = $this->data_json['if_you_were_a_member_of_a_self_help_group9'];
//                if (isset($this->data_json['active_members_name1']) and $this->data_json['active_members_name1'])
//                    $srlm_bc_application->active_members_name1 = $this->data_json['active_members_name1'];
//                if (isset($this->data_json['active_members_name2']) and $this->data_json['active_members_name2'])
//                    $srlm_bc_application->active_members_name2 = $this->data_json['active_members_name2'];
//                if (isset($this->data_json['active_members_position1']) and $this->data_json['active_members_position1'])
//                    $srlm_bc_application->active_members_position1 = $this->data_json['active_members_position1'];
//                if (isset($this->data_json['active_members_position2']) and $this->data_json['active_members_position2'])
//                    $srlm_bc_application->active_members_position2 = $this->data_json['active_members_position2'];
//                if (isset($this->data_json['belongingness_name1']) and $this->data_json['belongingness_name1'])
//                    $srlm_bc_application->belongingness_name1 = $this->data_json['belongingness_name1'];
//                if (isset($this->data_json['belongingness_name2']) and $this->data_json['belongingness_name2'])
//                    $srlm_bc_application->belongingness_name2 = $this->data_json['belongingness_name2'];
//                if (isset($this->data_json['belongingness_position1']) and $this->data_json['belongingness_position1'])
//                    $srlm_bc_application->belongingness_position1 = $this->data_json['belongingness_position1'];
//                if (isset($this->data_json['belongingness_position2']) and $this->data_json['belongingness_position2'])
//                    $srlm_bc_application->belongingness_position2 = $this->data_json['belongingness_position2'];
//                if (isset($this->data_json['awareness_name1']) and $this->data_json['awareness_name1'])
//                    $srlm_bc_application->awareness_name1 = $this->data_json['awareness_name1'];
//                if (isset($this->data_json['awareness_name2']) and $this->data_json['awareness_name2'])
//                    $srlm_bc_application->awareness_name2 = $this->data_json['awareness_name2'];
//                if (isset($this->data_json['awareness_position1']) and $this->data_json['awareness_position1'])
//                    $srlm_bc_application->awareness_position1 = $this->data_json['awareness_position1'];
//                if (isset($this->data_json['awareness_position2']) and $this->data_json['awareness_position2'])
//                    $srlm_bc_application->awareness_position2 = $this->data_json['awareness_position2'];
//                if (isset($this->data_json['member_who_contact_in_other_group_name1']) and $this->data_json['member_who_contact_in_other_group_name1'])
//                    $srlm_bc_application->member_who_contact_in_other_group_name1 = $this->data_json['member_who_contact_in_other_group_name1'];
//                if (isset($this->data_json['member_who_contact_in_other_group_name2']) and $this->data_json['member_who_contact_in_other_group_name2'])
//                    $srlm_bc_application->member_who_contact_in_other_group_name2 = $this->data_json['member_who_contact_in_other_group_name2'];
//                if (isset($this->data_json['member_who_contact_in_other_group_position1']) and $this->data_json['member_who_contact_in_other_group_position1'])
//                    $srlm_bc_application->member_who_contact_in_other_group_position1 = $this->data_json['member_who_contact_in_other_group_position1'];
//                if (isset($this->data_json['member_who_contact_in_other_group_position2']) and $this->data_json['member_who_contact_in_other_group_position2'])
//                    $srlm_bc_application->member_who_contact_in_other_group_position2 = $this->data_json['member_who_contact_in_other_group_position2'];
//                if (isset($this->data_json['demanded_group_member_name1']) and $this->data_json['demanded_group_member_name1'])
//                    $srlm_bc_application->demanded_group_member_name1 = $this->data_json['demanded_group_member_name1'];
//                if (isset($this->data_json['demanded_group_member_name2']) and $this->data_json['demanded_group_member_name2'])
//                    $srlm_bc_application->demanded_group_member_name2 = $this->data_json['demanded_group_member_name2'];
//                if (isset($this->data_json['demanded_group_member_position1']) and $this->data_json['demanded_group_member_position1'])
//                    $srlm_bc_application->demanded_group_member_position1 = $this->data_json['demanded_group_member_position1'];
//                if (isset($this->data_json['demanded_group_member_position2']) and $this->data_json['demanded_group_member_position2'])
//                    $srlm_bc_application->demanded_group_member_position2 = $this->data_json['demanded_group_member_position2'];
//                if (isset($this->data_json['capable_fast_pace']) and $this->data_json['capable_fast_pace'])
//                    $srlm_bc_application->capable_fast_pace = $this->data_json['capable_fast_pace'];
//                if (isset($this->data_json['why_demanded1']) and $this->data_json['why_demanded1'])
//                    $srlm_bc_application->why_demanded1 = $this->data_json['why_demanded1'];
//                if (isset($this->data_json['why_demanded2']) and $this->data_json['why_demanded2'])
//                    $srlm_bc_application->why_demanded2 = $this->data_json['why_demanded2'];
//                if (isset($this->data_json['why_demanded3']) and $this->data_json['why_demanded3'])
//                    $srlm_bc_application->why_demanded3 = $this->data_json['why_demanded3'];
//                if (isset($this->data_json['why_demanded4']) and $this->data_json['why_demanded4'])
//                    $srlm_bc_application->why_demanded4 = $this->data_json['why_demanded4'];
//                if (isset($this->data_json['why_demanded5']) and $this->data_json['why_demanded5'])
//                    $srlm_bc_application->why_demanded5 = $this->data_json['why_demanded5'];
//                if (isset($this->data_json['why_demanded6']) and $this->data_json['why_demanded6'])
//                    $srlm_bc_application->why_demanded6 = $this->data_json['why_demanded6'];
//                if (isset($this->data_json['if_you_have_group_members_what_are_they']) and $this->data_json['if_you_have_group_members_what_are_they'])
//                    $srlm_bc_application->if_you_have_group_members_what_are_they = $this->data_json['if_you_have_group_members_what_are_they'];
//                if (isset($this->data_json['capable_fast_pace_member_name']) and $this->data_json['capable_fast_pace_member_name'])
//                    $srlm_bc_application->capable_fast_pace_member_name = $this->data_json['capable_fast_pace_member_name'];
//                if (isset($this->data_json['capable_fast_pace_member_number']) and $this->data_json['capable_fast_pace_member_number'])
//                    $srlm_bc_application->capable_fast_pace_member_number = $this->data_json['capable_fast_pace_member_number'];
//                if (isset($this->data_json['his_perception1']) and $this->data_json['his_perception1'])
//                    $srlm_bc_application->his_perception1 = $this->data_json['his_perception1'];
//                if (isset($this->data_json['his_perception2']) and $this->data_json['his_perception2'])
//                    $srlm_bc_application->his_perception2 = $this->data_json['his_perception2'];
//                if (isset($this->data_json['his_perception3']) and $this->data_json['his_perception3'])
//                    $srlm_bc_application->his_perception3 = $this->data_json['his_perception3'];
//                if (isset($this->data_json['his_perception4']) and $this->data_json['his_perception4'])
//                    $srlm_bc_application->his_perception4 = $this->data_json['his_perception4'];
//                if (isset($this->data_json['his_perception5']) and $this->data_json['his_perception5'])
//                    $srlm_bc_application->his_perception5 = $this->data_json['his_perception5'];
//                if (isset($this->data_json['his_perception6']) and $this->data_json['his_perception6'])
//                    $srlm_bc_application->his_perception6 = $this->data_json['his_perception6'];
//                if (isset($this->data_json['his_perception7']) and $this->data_json['his_perception7'])
//                    $srlm_bc_application->his_perception7 = $this->data_json['his_perception7'];
//                if (isset($this->data_json['his_perception8']) and $this->data_json['his_perception8'])
//                    $srlm_bc_application->his_perception8 = $this->data_json['his_perception8'];
//                if (isset($this->data_json['what_could_you_do_if_you_were_in_a_group1']) and $this->data_json['what_could_you_do_if_you_were_in_a_group1'])
//                    $srlm_bc_application->what_could_you_do_if_you_were_in_a_group1 = $this->data_json['what_could_you_do_if_you_were_in_a_group1'];
//                if (isset($this->data_json['what_could_you_do_if_you_were_in_a_group2']) and $this->data_json['what_could_you_do_if_you_were_in_a_group2'])
//                    $srlm_bc_application->what_could_you_do_if_you_were_in_a_group2 = $this->data_json['what_could_you_do_if_you_were_in_a_group2'];
//                if (isset($this->data_json['what_could_you_do_if_you_were_in_a_group3']) and $this->data_json['what_could_you_do_if_you_were_in_a_group3'])
//                    $srlm_bc_application->what_could_you_do_if_you_were_in_a_group3 = $this->data_json['what_could_you_do_if_you_were_in_a_group3'];
//                if (isset($this->data_json['what_could_you_do_if_you_were_in_a_group4']) and $this->data_json['what_could_you_do_if_you_were_in_a_group4'])
//                    $srlm_bc_application->what_could_you_do_if_you_were_in_a_group4 = $this->data_json['what_could_you_do_if_you_were_in_a_group4'];
//                if (isset($this->data_json['what_could_you_do_if_you_were_in_a_group5']) and $this->data_json['what_could_you_do_if_you_were_in_a_group5'])
//                    $srlm_bc_application->what_could_you_do_if_you_were_in_a_group5 = $this->data_json['what_could_you_do_if_you_were_in_a_group5'];
//                if (isset($this->data_json['what_could_you_do_if_you_were_in_a_group6']) and $this->data_json['what_could_you_do_if_you_were_in_a_group6'])
//                    $srlm_bc_application->what_could_you_do_if_you_were_in_a_group6 = $this->data_json['what_could_you_do_if_you_were_in_a_group6'];
//                if (isset($this->data_json['what_could_you_do_if_you_were_in_a_group7']) and $this->data_json['what_could_you_do_if_you_were_in_a_group7'])
//                    $srlm_bc_application->what_could_you_do_if_you_were_in_a_group7 = $this->data_json['what_could_you_do_if_you_were_in_a_group7'];
//                if (isset($this->data_json['what_could_you_do_if_you_were_in_a_group8']) and $this->data_json['what_could_you_do_if_you_were_in_a_group8'])
//                    $srlm_bc_application->what_could_you_do_if_you_were_in_a_group8 = $this->data_json['what_could_you_do_if_you_were_in_a_group8'];
//                if (isset($this->data_json['what_could_you_do_if_you_were_in_a_group9']) and $this->data_json['what_could_you_do_if_you_were_in_a_group9'])
//                    $srlm_bc_application->what_could_you_do_if_you_were_in_a_group9 = $this->data_json['what_could_you_do_if_you_were_in_a_group9'];
//                if (isset($this->data_json['most_contribute_index']) and $this->data_json['most_contribute_index'])
//                    $srlm_bc_application->most_contribute_index = $this->data_json['most_contribute_index'];
//                if (isset($this->data_json['most_contribute_name']) and $this->data_json['most_contribute_name'])
//                    $srlm_bc_application->most_contribute_name = $this->data_json['most_contribute_name'];
//                if (isset($this->data_json['group_culture']) and $this->data_json['group_culture'])
//                    $srlm_bc_application->group_culture = $this->data_json['group_culture'];
//                if (isset($this->data_json['provision_in_the_group_as_voluntary']) and $this->data_json['provision_in_the_group_as_voluntary'])
//                    $srlm_bc_application->provision_in_the_group_as_voluntary = $this->data_json['provision_in_the_group_as_voluntary'];
//                if (isset($this->data_json['entrepreneurial_index']) and $this->data_json['entrepreneurial_index'])
//                    $srlm_bc_application->entrepreneurial_index = $this->data_json['entrepreneurial_index'];
//                if (isset($this->data_json['entrepreneurial']) and $this->data_json['entrepreneurial'])
//                    $srlm_bc_application->entrepreneurial = $this->data_json['entrepreneurial'];
//                if (isset($this->data_json['economic_status']) and $this->data_json['economic_status'])
//                    $srlm_bc_application->economic_status = $this->data_json['economic_status'];
//                if (isset($this->data_json['afraid_unknown_rules_index1']) and $this->data_json['afraid_unknown_rules_index1'])
//                    $srlm_bc_application->afraid_unknown_rules_index1 = $this->data_json['afraid_unknown_rules_index1'];
//
//                if (isset($this->data_json['afraid_unknown_rules1']) and $this->data_json['afraid_unknown_rules1'])
//                    $srlm_bc_application->afraid_unknown_rules1 = $this->data_json['afraid_unknown_rules1'];
//                if (isset($this->data_json['afraid_unknown_rules_index2']) and $this->data_json['afraid_unknown_rules_index2'])
//                    $srlm_bc_application->afraid_unknown_rules_index2 = $this->data_json['afraid_unknown_rules_index2'];
//                if (isset($this->data_json['afraid_unknown_rules2']) and $this->data_json['afraid_unknown_rules2'])
//                    $srlm_bc_application->afraid_unknown_rules2 = $this->data_json['afraid_unknown_rules2'];
//                if (isset($this->data_json['concept_of_setting_up_new_heights_index']) and $this->data_json['concept_of_setting_up_new_heights_index'])
//                    $srlm_bc_application->concept_of_setting_up_new_heights_index = $this->data_json['concept_of_setting_up_new_heights_index'];
//                if (isset($this->data_json['concept_of_setting_up_new_heights']) and $this->data_json['concept_of_setting_up_new_heights'])
//                    $srlm_bc_application->concept_of_setting_up_new_heights = $this->data_json['concept_of_setting_up_new_heights'];
//                if (isset($this->data_json['livelihood_opportunity_for_another_member_index1']) and $this->data_json['livelihood_opportunity_for_another_member_index1'])
//                    $srlm_bc_application->livelihood_opportunity_for_another_member_index1 = $this->data_json['livelihood_opportunity_for_another_member_index1'];
//                if (isset($this->data_json['livelihood_opportunity_for_another_member1']) and $this->data_json['livelihood_opportunity_for_another_member1'])
//                    $srlm_bc_application->livelihood_opportunity_for_another_member1 = $this->data_json['livelihood_opportunity_for_another_member1'];
//                if (isset($this->data_json['livelihood_opportunity_for_another_member_index2']) and $this->data_json['livelihood_opportunity_for_another_member_index2'])
//                    $srlm_bc_application->livelihood_opportunity_for_another_member_index2 = $this->data_json['livelihood_opportunity_for_another_member_index2'];
//                if (isset($this->data_json['livelihood_opportunity_for_another_member2']) and $this->data_json['livelihood_opportunity_for_another_member2'])
//                    $srlm_bc_application->livelihood_opportunity_for_another_member2 = $this->data_json['livelihood_opportunity_for_another_member2'];
//                if (isset($this->data_json['negotiate_best_index1']) and $this->data_json['negotiate_best_index1'])
//                    $srlm_bc_application->negotiate_best_index1 = $this->data_json['negotiate_best_index1'];
//                if (isset($this->data_json['negotiate_best1']) and $this->data_json['negotiate_best1'])
//                    $srlm_bc_application->negotiate_best1 = $this->data_json['negotiate_best1'];
//                if (isset($this->data_json['negotiate_best_index2']) and $this->data_json['negotiate_best_index2'])
//                    $srlm_bc_application->negotiate_best_index2 = $this->data_json['negotiate_best_index2'];
//                if (isset($this->data_json['negotiate_best2']) and $this->data_json['negotiate_best2'])
//                    $srlm_bc_application->negotiate_best2 = $this->data_json['negotiate_best2'];
//                if (isset($this->data_json['which_member_can_talk_advantages_index1']) and $this->data_json['which_member_can_talk_advantages_index1'])
//                    $srlm_bc_application->which_member_can_talk_advantages_index1 = $this->data_json['which_member_can_talk_advantages_index1'];
//                if (isset($this->data_json['which_member_can_talk_advantages1']) and $this->data_json['which_member_can_talk_advantages1'])
//                    $srlm_bc_application->which_member_can_talk_advantages1 = $this->data_json['which_member_can_talk_advantages1'];
//                if (isset($this->data_json['which_member_can_talk_advantages_index2']) and $this->data_json['which_member_can_talk_advantages_index2'])
//                    $srlm_bc_application->which_member_can_talk_advantages_index2 = $this->data_json['which_member_can_talk_advantages_index2'];
//                if (isset($this->data_json['which_member_can_talk_advantages2']) and $this->data_json['which_member_can_talk_advantages2'])
//                    $srlm_bc_application->which_member_can_talk_advantages2 = $this->data_json['which_member_can_talk_advantages2'];
//                if (isset($this->data_json['can_read_write_hindi']) and $this->data_json['can_read_write_hindi'])
//                    $srlm_bc_application->can_read_write_hindi = $this->data_json['can_read_write_hindi'];
//                if (isset($this->data_json['confirtable_in_english']) and $this->data_json['confirtable_in_english'])
//                    $srlm_bc_application->confirtable_in_english = $this->data_json['confirtable_in_english'];
//                if (isset($this->data_json['recognize_english_hindi']) and $this->data_json['recognize_english_hindi'])
//                    $srlm_bc_application->recognize_english_hindi = $this->data_json['recognize_english_hindi'];
//                if (isset($this->data_json['can_add_substract_multiply']) and $this->data_json['can_add_substract_multiply'])
//                    $srlm_bc_application->can_add_substract_multiply = $this->data_json['can_add_substract_multiply'];
//                if (isset($this->data_json['who_maintain_account_index']) and $this->data_json['who_maintain_account_index'])
//                    $srlm_bc_application->who_maintain_account_index = $this->data_json['who_maintain_account_index'];
//                if (isset($this->data_json['who_maintain_account']) and $this->data_json['who_maintain_account'])
//                    $srlm_bc_application->who_maintain_account = $this->data_json['who_maintain_account'];
//                if (isset($this->data_json['choose_other_meaning1']) and $this->data_json['choose_other_meaning1'])
//                    $srlm_bc_application->choose_other_meaning1 = $this->data_json['choose_other_meaning1'];
//                if (isset($this->data_json['choose_other_meaning2']) and $this->data_json['choose_other_meaning2'])
//                    $srlm_bc_application->choose_other_meaning2 = $this->data_json['choose_other_meaning2'];
//                if (isset($this->data_json['choose_other_meaning3']) and $this->data_json['choose_other_meaning3'])
//                    $srlm_bc_application->choose_other_meaning3 = $this->data_json['choose_other_meaning3'];
//                if (isset($this->data_json['choose_other_meaning4']) and $this->data_json['choose_other_meaning4'])
//                    $srlm_bc_application->choose_other_meaning4 = $this->data_json['choose_other_meaning4'];
//                if (isset($this->data_json['choose_other_meaning5']) and $this->data_json['choose_other_meaning5'])
//                    $srlm_bc_application->choose_other_meaning5 = $this->data_json['choose_other_meaning5'];
//                if (isset($this->data_json['same_to_same_word1']) and $this->data_json['same_to_same_word1'])
//                    $srlm_bc_application->same_to_same_word1 = $this->data_json['same_to_same_word1'];
//                if (isset($this->data_json['same_to_same_word2']) and $this->data_json['same_to_same_word2'])
//                    $srlm_bc_application->same_to_same_word2 = $this->data_json['same_to_same_word2'];
//                if (isset($this->data_json['same_to_same_word3']) and $this->data_json['same_to_same_word3'])
//                    $srlm_bc_application->same_to_same_word3 = $this->data_json['same_to_same_word3'];
//                if (isset($this->data_json['english_to_hindi1']) and $this->data_json['english_to_hindi1'])
//                    $srlm_bc_application->english_to_hindi1 = $this->data_json['english_to_hindi1'];
//                if (isset($this->data_json['english_to_hindi2']) and $this->data_json['english_to_hindi2'])
//                    $srlm_bc_application->english_to_hindi2 = $this->data_json['english_to_hindi2'];
//                if (isset($this->data_json['english_to_hindi3']) and $this->data_json['english_to_hindi3'])
//                    $srlm_bc_application->english_to_hindi3 = $this->data_json['english_to_hindi3'];
//                if (isset($this->data_json['english_to_hindi4']) and $this->data_json['english_to_hindi4'])
//                    $srlm_bc_application->english_to_hindi4 = $this->data_json['english_to_hindi4'];
//                if (isset($this->data_json['english_to_hindi5']) and $this->data_json['english_to_hindi5'])
//                    $srlm_bc_application->english_to_hindi5 = $this->data_json['english_to_hindi5'];
//                if (isset($this->data_json['percentage_option1']) and $this->data_json['percentage_option1'])
//                    $srlm_bc_application->percentage_option1 = $this->data_json['percentage_option1'];
//                if (isset($this->data_json['percentage_option2']) and $this->data_json['percentage_option2'])
//                    $srlm_bc_application->percentage_option2 = $this->data_json['percentage_option2'];
//                if (isset($this->data_json['percentage_option3']) and $this->data_json['percentage_option3'])
//                    $srlm_bc_application->percentage_option3 = $this->data_json['percentage_option3'];
//                if (isset($this->data_json['percentage_option4']) and $this->data_json['percentage_option4'])
//                    $srlm_bc_application->percentage_option4 = $this->data_json['percentage_option4'];
//                if (isset($this->data_json['percentage_option5']) and $this->data_json['percentage_option5'])
//                    $srlm_bc_application->percentage_option5 = $this->data_json['percentage_option5'];
//                if (isset($this->data_json['option_decision1']) and $this->data_json['option_decision1'])
//                    $srlm_bc_application->option_decision1 = $this->data_json['option_decision1'];
//                if (isset($this->data_json['option_decision2']) and $this->data_json['option_decision2'])
//                    $srlm_bc_application->option_decision2 = $this->data_json['option_decision2'];
//                if (isset($this->data_json['option_decision3']) and $this->data_json['option_decision3'])
//                    $srlm_bc_application->option_decision3 = $this->data_json['option_decision3'];
//                if (isset($this->data_json['option_decision4']) and $this->data_json['option_decision4'])
//                    $srlm_bc_application->option_decision4 = $this->data_json['option_decision4'];
//                if (isset($this->data_json['option_decision5']) and $this->data_json['option_decision5'])
//                    $srlm_bc_application->option_decision5 = $this->data_json['option_decision5'];
//                if (isset($this->data_json['mobile_use_experience']) and $this->data_json['mobile_use_experience'])
//                    $srlm_bc_application->mobile_use_experience = $this->data_json['mobile_use_experience'];
//                if (isset($this->data_json['whose_mobile_you_using']) and $this->data_json['whose_mobile_you_using'])
//                    $srlm_bc_application->whose_mobile_you_using = $this->data_json['whose_mobile_you_using'];
//                if (isset($this->data_json['no_of_people_using_phone']) and $this->data_json['no_of_people_using_phone'])
//                    $srlm_bc_application->no_of_people_using_phone = $this->data_json['no_of_people_using_phone'];
//                if (isset($this->data_json['no_of_family_people_using_phone']) and $this->data_json['no_of_family_people_using_phone'])
//                    $srlm_bc_application->no_of_family_people_using_phone = $this->data_json['no_of_family_people_using_phone'];
//                if (isset($this->data_json['need_help_to_fill_form']) and $this->data_json['need_help_to_fill_form'])
//                    $srlm_bc_application->need_help_to_fill_form = $this->data_json['need_help_to_fill_form'];
//                if (isset($this->data_json['already_worked']) and $this->data_json['already_worked'])
//                    $srlm_bc_application->already_worked = $this->data_json['already_worked'];
//                if (isset($this->data_json['own_mobile']) and $this->data_json['own_mobile'])
//                    $srlm_bc_application->own_mobile = $this->data_json['own_mobile'];
//                if (isset($this->data_json['own_mobile_means1']) and $this->data_json['own_mobile_means1'])
//                    $srlm_bc_application->own_mobile_means1 = $this->data_json['own_mobile_means1'];
//                if (isset($this->data_json['own_mobile_means2']) and $this->data_json['own_mobile_means2'])
//                    $srlm_bc_application->own_mobile_means2 = $this->data_json['own_mobile_means2'];
//                if (isset($this->data_json['own_mobile_means3']) and $this->data_json['own_mobile_means3'])
//                    $srlm_bc_application->own_mobile_means3 = $this->data_json['own_mobile_means3'];
//                if (isset($this->data_json['own_mobile_means4']) and $this->data_json['own_mobile_means4'])
//                    $srlm_bc_application->own_mobile_means4 = $this->data_json['own_mobile_means4'];
//                if (isset($this->data_json['own_mobile_means5']) and $this->data_json['own_mobile_means5'])
//                    $srlm_bc_application->own_mobile_means5 = $this->data_json['own_mobile_means5'];
//                if (isset($this->data_json['own_mobile_means6']) and $this->data_json['own_mobile_means6'])
//                    $srlm_bc_application->own_mobile_means6 = $this->data_json['own_mobile_means6'];
//                if (isset($this->data_json['own_mobile_means7']) and $this->data_json['own_mobile_means7'])
//                    $srlm_bc_application->own_mobile_means7 = $this->data_json['own_mobile_means7'];
//                if (isset($this->data_json['own_mobile_means8']) and $this->data_json['own_mobile_means8'])
//                    $srlm_bc_application->own_mobile_means8 = $this->data_json['own_mobile_means8'];
//                if (isset($this->data_json['method_used_for_ledger_account1']) and $this->data_json['method_used_for_ledger_account1'])
//                    $srlm_bc_application->method_used_for_ledger_account1 = $this->data_json['method_used_for_ledger_account1'];
//                if (isset($this->data_json['method_used_for_ledger_account2']) and $this->data_json['method_used_for_ledger_account2'])
//                    $srlm_bc_application->method_used_for_ledger_account2 = $this->data_json['method_used_for_ledger_account2'];
//                if (isset($this->data_json['method_used_for_ledger_account3']) and $this->data_json['method_used_for_ledger_account3'])
//                    $srlm_bc_application->method_used_for_ledger_account3 = $this->data_json['method_used_for_ledger_account3'];
//                if (isset($this->data_json['method_used_for_ledger_account4']) and $this->data_json['method_used_for_ledger_account4'])
//                    $srlm_bc_application->method_used_for_ledger_account4 = $this->data_json['method_used_for_ledger_account4'];
//                if (isset($this->data_json['method_used_for_ledger_account5']) and $this->data_json['method_used_for_ledger_account5'])
//                    $srlm_bc_application->method_used_for_ledger_account5 = $this->data_json['method_used_for_ledger_account5'];
//                if (isset($this->data_json['method_used_for_ledger_account6']) and $this->data_json['method_used_for_ledger_account6'])
//                    $srlm_bc_application->method_used_for_ledger_account6 = $this->data_json['method_used_for_ledger_account6'];
//                if (isset($this->data_json['need_training1']) and $this->data_json['need_training1'])
//                    $srlm_bc_application->need_training1 = $this->data_json['need_training1'];
//                if (isset($this->data_json['need_training2']) and $this->data_json['need_training2'])
//                    $srlm_bc_application->need_training2 = $this->data_json['need_training2'];
//                if (isset($this->data_json['need_training3']) and $this->data_json['need_training3'])
//                    $srlm_bc_application->need_training3 = $this->data_json['need_training3'];
//                if (isset($this->data_json['need_training4']) and $this->data_json['need_training4'])
//                    $srlm_bc_application->need_training4 = $this->data_json['need_training4'];
//                if (isset($this->data_json['need_training5']) and $this->data_json['need_training5'])
//                    $srlm_bc_application->need_training5 = $this->data_json['need_training5'];
//
//                if (isset($this->data_json['gps']) and $this->data_json['gps'])
//                    $srlm_bc_application->gps = $this->data_json['gps'];
//                if (isset($this->data_json['gps_accuracy']) and $this->data_json['gps_accuracy'])
//                    $srlm_bc_application->gps_accuracy = $this->data_json['gps_accuracy'];
//                $form_number = SrlmBcApplication::FORM_STATUS_BASIC_PROFILE;
//                if (isset($this->data_json['form_number'])) {
//                    $form_number = $this->data_json['form_number'];
//                }
//
//                if ($form_number == SrlmBcApplication::FORM_STATUS_BASIC_PROFILE) {
//                    $srlm_bc_application->form1_date_time = $model->time;
//                }
//                if ($form_number == SrlmBcApplication::FORM_STATUS_FAMILY_PROFILE) {
//                    $srlm_bc_application->form2_date_time = $model->time;
//                }
//                if ($form_number == SrlmBcApplication::FORM_STATUS_PART_1) {
//                    $srlm_bc_application->form3_date_time = $model->time;
//                }
//                if ($form_number == SrlmBcApplication::FORM_STATUS_PART_2) {
//                    $srlm_bc_application->form4_date_time = $model->time;
//                }
//                if ($form_number == SrlmBcApplication::FORM_STATUS_PART_3) {
//                    $srlm_bc_application->form5_date_time = $model->time;
//                }
//                if ($form_number == SrlmBcApplication::FORM_STATUS_PART_4) {
//                    $srlm_bc_application->form6_date_time = $model->time;
//                }
//                $srlm_bc_application->srlm_bc_selection_api_log_id = $model->id;
//                if (isset($this->data_json['form_date']))
//                    $srlm_bc_application->form_start_date = $this->data_json['form_date'];
//                if (isset($this->data_json['form_start_date']))
//                    $srlm_bc_application->form_start_date = $this->data_json['form_start_date'];
//                $srlm_bc_application->updated_at = $model->created_at;
//                $srlm_bc_application->form_number = $form_number;
//                $srlm_bc_application->form_status = $form_number;
//                $srlm_bc_application->action_type = ($form_number + 1);
//                $srlm_bc_application->srlm_bc_selection_app_detail_id = $model->srlm_bc_selection_app_id;
//                if ($srlm_bc_application->save()) {
//                    if (isset($this->data_json['groupInformation']) and is_array($this->data_json['groupInformation'])) {
//                        foreach ($this->data_json['groupInformation'] as $family_info) {
//                            if (isset($family_info['form_uuid'])) {
//                                $family_model = SrlmBcApplicationGroupFamily::find()->where(['form_uuid' => $family_info['form_uuid'], 'family_uuid' => $family_info['family_uuid']])->one();
//                                if (empty($family_model)) {
//                                    $family_model = new SrlmBcApplicationGroupFamily();
//                                }
//
//                                $family_model->form_uuid = $family_info['form_uuid'];
//                                $family_model->family_uuid = $family_info['family_uuid'];
//                                $family_model->srlm_bc_application_id = $srlm_bc_application->id;
//                                $family_model->member_name = $family_info['member_name'];
//                                $family_model->position = $family_info['position'];
//                                $family_model->mobile_no = $family_info['mobile_no'];
//
//                                $family_model->status = \app\models\base\GenralModel::STATUS_ACTIVE;
////                            
//                                if ($family_model->save()) {
//                                    
//                                } else {
//                                    
//                                }
//                            }
//                        }
//                    }
//                } else {
//                    print_r($srlm_bc_application->getErrors());
//                    exit;
//                }
//            } else {
//                \Yii::$app->runAction('srlm/registration');  // if user reg not exist then run
//            }
//        }
//    }
    public function actionProcess() {
        $max = SrlmBcApplication7::find()->max('srlm_bc_selection_api_log_id');
        $max = $max != NULL ? $max : 0;

        $models = SrlmBcSelectionApiLog::find()->where(['>', 'id', $max])->andWhere(['!=', 'srlm_bc_selection_user_id', 0])->andWhere(['request_url' => 'bcselection/user/formsave', 'http_response_code' => [200, 400]])->orderBy('id asc')->limit($this->process_limt)->all();
        echo count($models) . PHP_EOL;
        foreach ($models as $model) {
            echo 'process.' . $model->id . PHP_EOL . $model->request_url . PHP_EOL;
            echo 'User id.' . $model->srlm_bc_selection_user_id . PHP_EOL;
            if ($model->srlm_bc_selection_user_id and $model->request_url == 'bcselection/user/formsave' and in_array($model->http_response_code, [200, 400])) {
                try {
                    $this->data_json = json_decode($model->request_body, true);
                    echo 'process after json.' . $model->srlm_bc_selection_user_id . PHP_EOL;
//            print_r($this->data_json);exit;
                    $user_model = SrlmBcSelectionUser::findOne(['id' => $model->srlm_bc_selection_user_id]);
                    if (!empty($user_model)) {
                        $srlm_bc_application = SrlmBcApplication7::findOne(['srlm_bc_selection_user_id' => $model->srlm_bc_selection_user_id]);

                        if (!empty($srlm_bc_application)) {
                            echo 'process.' . $model->id . PHP_EOL;
                            if (isset($this->data_json['form_uuid']))
                                $srlm_bc_application->form_uuid = $this->data_json['form_uuid'];
                            if (isset($this->data_json['first_name']) and $this->data_json['first_name']) {
                                $srlm_bc_application->first_name = $this->data_json['first_name'];
                                $srlm_bc_application->orig_first_name = $this->data_json['first_name'];
                            }
                            if (isset($this->data_json['middle_name']) and $this->data_json['middle_name']) {
                                $srlm_bc_application->middle_name = $this->data_json['middle_name'];
                                $srlm_bc_application->orig_middle_name = $this->data_json['middle_name'];
                            }
                            if (isset($this->data_json['sur_name']) and $this->data_json['sur_name']) {
                                $srlm_bc_application->sur_name = $this->data_json['sur_name'];
                                $srlm_bc_application->orig_sur_name = $this->data_json['sur_name'];
                            }
                            if (isset($this->data_json['gender']) and $this->data_json['gender'])
                                $srlm_bc_application->gender = $this->data_json['gender'];
                            if (isset($this->data_json['age']) and $this->data_json['age'])
                                $srlm_bc_application->age = $this->data_json['age'];
                            if (isset($this->data_json['cast']) and $this->data_json['cast'])
                                $srlm_bc_application->cast = $this->data_json['cast'];
                            if (isset($this->data_json['district_name']) and $this->data_json['district_name'])
                                $srlm_bc_application->district_name = $this->data_json['district_name'];
                            if (isset($this->data_json['block_name']) and $this->data_json['block_name'])
                                $srlm_bc_application->block_name = $this->data_json['block_name'];
                            if (isset($this->data_json['gram_panchayat_name']) and $this->data_json['gram_panchayat_name'])
                                $srlm_bc_application->gram_panchayat_name = $this->data_json['gram_panchayat_name'];
                            if (isset($this->data_json['village_name']) and $this->data_json['village_name'])
                                $srlm_bc_application->village_name = $this->data_json['village_name'];
                            if (isset($this->data_json['hamlet']) and $this->data_json['hamlet'])
                                $srlm_bc_application->hamlet = $this->data_json['hamlet'];
                            if (isset($this->data_json['district_code']) and $this->data_json['district_code'])
                                $srlm_bc_application->district_code = $this->data_json['district_code'];
                            if (isset($this->data_json['block_code']) and $this->data_json['block_code'])
                                $srlm_bc_application->block_code = $this->data_json['block_code'];
                            if (isset($this->data_json['gram_panchayat_code']) and $this->data_json['gram_panchayat_code'])
                                $srlm_bc_application->gram_panchayat_code = $this->data_json['gram_panchayat_code'];
                            if (isset($this->data_json['village_code']) and $this->data_json['village_code'])
                                $srlm_bc_application->village_code = $this->data_json['village_code'];
                            if (isset($this->data_json['aadhar_number']) and $this->data_json['aadhar_number'])
                                $srlm_bc_application->aadhar_number = $this->data_json['aadhar_number'];
                            if (isset($this->data_json['guardian_name']) and $this->data_json['guardian_name'])
                                $srlm_bc_application->guardian_name = $this->data_json['guardian_name'];
                            if (isset($this->data_json['reading_skills']) and $this->data_json['reading_skills'])
                                $srlm_bc_application->reading_skills = $this->data_json['reading_skills'];
                            if (isset($this->data_json['mobile_number']) and $this->data_json['mobile_number'])
                                $srlm_bc_application->mobile_number = $this->data_json['mobile_number'];
                            if (isset($this->data_json['phone_type']) and $this->data_json['phone_type'])
                                $srlm_bc_application->phone_type = $this->data_json['phone_type'];
                            if (isset($this->data_json['what_else_with_mobile1']) and $this->data_json['what_else_with_mobile1'])
                                $srlm_bc_application->what_else_with_mobile1 = $this->data_json['what_else_with_mobile1'];
                            if (isset($this->data_json['what_else_with_mobile2']) and $this->data_json['what_else_with_mobile2'])
                                $srlm_bc_application->what_else_with_mobile2 = $this->data_json['what_else_with_mobile2'];
                            if (isset($this->data_json['what_else_with_mobile3']) and $this->data_json['what_else_with_mobile3'])
                                $srlm_bc_application->what_else_with_mobile3 = $this->data_json['what_else_with_mobile3'];
                            if (isset($this->data_json['what_else_with_mobile4']) and $this->data_json['what_else_with_mobile4'])
                                $srlm_bc_application->what_else_with_mobile4 = $this->data_json['what_else_with_mobile4'];
                            if (isset($this->data_json['what_else_with_mobile5']) and $this->data_json['what_else_with_mobile5'])
                                $srlm_bc_application->what_else_with_mobile5 = $this->data_json['what_else_with_mobile5'];
                            if (isset($this->data_json['whats_app_number']) and $this->data_json['whats_app_number'])
                                $srlm_bc_application->whats_app_number = $this->data_json['whats_app_number'];
                            if (isset($this->data_json['vechicle_drive1']) and $this->data_json['vechicle_drive1'])
                                $srlm_bc_application->vechicle_drive1 = $this->data_json['vechicle_drive1'];
                            if (isset($this->data_json['vechicle_drive2']) and $this->data_json['vechicle_drive2'])
                                $srlm_bc_application->vechicle_drive2 = $this->data_json['vechicle_drive2'];
                            if (isset($this->data_json['vechicle_drive3']) and $this->data_json['vechicle_drive3'])
                                $srlm_bc_application->vechicle_drive3 = $this->data_json['vechicle_drive3'];
                            if (isset($this->data_json['vechicle_drive4']) and $this->data_json['vechicle_drive4'])
                                $srlm_bc_application->vechicle_drive4 = $this->data_json['vechicle_drive4'];
                            if (isset($this->data_json['vechicle_drive5']) and $this->data_json['vechicle_drive5'])
                                $srlm_bc_application->vechicle_drive5 = $this->data_json['vechicle_drive5'];
                            if (isset($this->data_json['vechicle_drive6']) and $this->data_json['vechicle_drive6'])
                                $srlm_bc_application->vechicle_drive6 = $this->data_json['vechicle_drive6'];
                            if (isset($this->data_json['vechicle_drive7']) and $this->data_json['vechicle_drive7'])
                                $srlm_bc_application->vechicle_drive7 = $this->data_json['vechicle_drive7'];
                            if (isset($this->data_json['marital_status']) and $this->data_json['marital_status'])
                                $srlm_bc_application->marital_status = $this->data_json['marital_status'];
                            if (isset($this->data_json['house_member_details1']) and $this->data_json['house_member_details1'])
                                $srlm_bc_application->house_member_details1 = $this->data_json['house_member_details1'];
                            if (isset($this->data_json['house_member_details2']) and $this->data_json['house_member_details2'])
                                $srlm_bc_application->house_member_details2 = $this->data_json['house_member_details2'];
                            if (isset($this->data_json['house_member_details3']) and $this->data_json['house_member_details3'])
                                $srlm_bc_application->house_member_details3 = $this->data_json['house_member_details3'];
                            if (isset($this->data_json['future_scope1']) and $this->data_json['future_scope1'])
                                $srlm_bc_application->future_scope1 = $this->data_json['future_scope1'];
                            if (isset($this->data_json['future_scope2']) and $this->data_json['future_scope2'])
                                $srlm_bc_application->future_scope2 = $this->data_json['future_scope2'];
                            if (isset($this->data_json['future_scope3']) and $this->data_json['future_scope3'])
                                $srlm_bc_application->future_scope3 = $this->data_json['future_scope3'];
                            if (isset($this->data_json['future_scope4']) and $this->data_json['future_scope4'])
                                $srlm_bc_application->future_scope4 = $this->data_json['future_scope4'];
                            if (isset($this->data_json['future_scope5']) and $this->data_json['future_scope5'])
                                $srlm_bc_application->future_scope5 = $this->data_json['future_scope5'];
                            if (isset($this->data_json['future_scope6']) and $this->data_json['future_scope6'])
                                $srlm_bc_application->future_scope6 = $this->data_json['future_scope6'];
                            if (isset($this->data_json['future_scope7']) and $this->data_json['future_scope7'])
                                $srlm_bc_application->future_scope7 = $this->data_json['future_scope7'];
                            if (isset($this->data_json['future_scope8']) and $this->data_json['future_scope8'])
                                $srlm_bc_application->future_scope8 = $this->data_json['future_scope8'];
                            if (isset($this->data_json['future_scope9']) and $this->data_json['future_scope9'])
                                $srlm_bc_application->future_scope9 = $this->data_json['future_scope9'];
                            if (isset($this->data_json['future_scope10']) and $this->data_json['future_scope10'])
                                $srlm_bc_application->future_scope10 = $this->data_json['future_scope10'];
                            if (isset($this->data_json['future_scope11']) and $this->data_json['future_scope11'])
                                $srlm_bc_application->future_scope11 = $this->data_json['future_scope11'];
                            if (isset($this->data_json['future_scope12']) and $this->data_json['future_scope12'])
                                $srlm_bc_application->future_scope12 = $this->data_json['future_scope12'];
                            if (isset($this->data_json['opportunities_for_livelihood1']) and $this->data_json['opportunities_for_livelihood1'])
                                $srlm_bc_application->opportunities_for_livelihood1 = $this->data_json['opportunities_for_livelihood1'];
                            if (isset($this->data_json['opportunities_for_livelihood2']) and $this->data_json['opportunities_for_livelihood2'])
                                $srlm_bc_application->opportunities_for_livelihood2 = $this->data_json['opportunities_for_livelihood2'];
                            if (isset($this->data_json['opportunities_for_livelihood3']) and $this->data_json['opportunities_for_livelihood3'])
                                $srlm_bc_application->opportunities_for_livelihood3 = $this->data_json['opportunities_for_livelihood3'];
                            if (isset($this->data_json['opportunities_for_livelihood4']) and $this->data_json['opportunities_for_livelihood4'])
                                $srlm_bc_application->opportunities_for_livelihood4 = $this->data_json['opportunities_for_livelihood4'];
                            if (isset($this->data_json['opportunities_for_livelihood5']) and $this->data_json['opportunities_for_livelihood5'])
                                $srlm_bc_application->opportunities_for_livelihood5 = $this->data_json['opportunities_for_livelihood5'];
                            if (isset($this->data_json['opportunities_for_livelihood6']) and $this->data_json['opportunities_for_livelihood6'])
                                $srlm_bc_application->opportunities_for_livelihood6 = $this->data_json['opportunities_for_livelihood6'];
                            if (isset($this->data_json['opportunities_for_livelihood7']) and $this->data_json['opportunities_for_livelihood7'])
                                $srlm_bc_application->opportunities_for_livelihood7 = $this->data_json['opportunities_for_livelihood7'];
                            if (isset($this->data_json['opportunities_for_livelihood8']) and $this->data_json['opportunities_for_livelihood8'])
                                $srlm_bc_application->opportunities_for_livelihood8 = $this->data_json['opportunities_for_livelihood8'];
                            if (isset($this->data_json['opportunities_for_livelihood9']) and $this->data_json['opportunities_for_livelihood9'])
                                $srlm_bc_application->opportunities_for_livelihood9 = $this->data_json['opportunities_for_livelihood9'];
                            if (isset($this->data_json['opportunities_for_livelihood10']) and $this->data_json['opportunities_for_livelihood10'])
                                $srlm_bc_application->opportunities_for_livelihood10 = $this->data_json['opportunities_for_livelihood10'];
                            if (isset($this->data_json['other_occupation']) and $this->data_json['other_occupation'])
                                $srlm_bc_application->other_occupation = $this->data_json['other_occupation'];
                            if (isset($this->data_json['planning_intervention1']) and $this->data_json['planning_intervention1'])
                                $srlm_bc_application->planning_intervention1 = $this->data_json['planning_intervention1'];
                            if (isset($this->data_json['planning_intervention2']) and $this->data_json['planning_intervention2'])
                                $srlm_bc_application->planning_intervention2 = $this->data_json['planning_intervention2'];
                            if (isset($this->data_json['planning_intervention3']) and $this->data_json['planning_intervention3'])
                                $srlm_bc_application->planning_intervention3 = $this->data_json['planning_intervention3'];
                            if (isset($this->data_json['planning_intervention4']) and $this->data_json['planning_intervention4'])
                                $srlm_bc_application->planning_intervention4 = $this->data_json['planning_intervention4'];
                            if (isset($this->data_json['planning_intervention5']) and $this->data_json['planning_intervention5'])
                                $srlm_bc_application->planning_intervention5 = $this->data_json['planning_intervention5'];
                            if (isset($this->data_json['planning_intervention6']) and $this->data_json['planning_intervention6'])
                                $srlm_bc_application->planning_intervention6 = $this->data_json['planning_intervention6'];
                            if (isset($this->data_json['immediate_aspiration1']) and $this->data_json['immediate_aspiration1'])
                                $srlm_bc_application->immediate_aspiration1 = $this->data_json['immediate_aspiration1'];
                            if (isset($this->data_json['immediate_aspiration2']) and $this->data_json['immediate_aspiration2'])
                                $srlm_bc_application->immediate_aspiration2 = $this->data_json['immediate_aspiration2'];
                            if (isset($this->data_json['immediate_aspiration3']) and $this->data_json['immediate_aspiration3'])
                                $srlm_bc_application->immediate_aspiration3 = $this->data_json['immediate_aspiration3'];
                            if (isset($this->data_json['immediate_aspiration4']) and $this->data_json['immediate_aspiration4'])
                                $srlm_bc_application->immediate_aspiration4 = $this->data_json['immediate_aspiration4'];
                            if (isset($this->data_json['immediate_aspiration5']) and $this->data_json['immediate_aspiration5'])
                                $srlm_bc_application->immediate_aspiration5 = $this->data_json['immediate_aspiration5'];
                            if (isset($this->data_json['immediate_aspiration6']) and $this->data_json['immediate_aspiration6'])
                                $srlm_bc_application->immediate_aspiration6 = $this->data_json['immediate_aspiration6'];
                            if (isset($this->data_json['already_group_member']) and $this->data_json['already_group_member'])
                                $srlm_bc_application->already_group_member = $this->data_json['already_group_member'];
                            if (isset($this->data_json['your_group_name']) and $this->data_json['your_group_name'])
                                $srlm_bc_application->your_group_name = $this->data_json['your_group_name'];
                            if (isset($this->data_json['which_program_your_group_formed']) and $this->data_json['which_program_your_group_formed'])
                                $srlm_bc_application->which_program_your_group_formed = $this->data_json['which_program_your_group_formed'];
                            if (isset($this->data_json['thought_of_forming_group']) and $this->data_json['thought_of_forming_group'])
                                $srlm_bc_application->thought_of_forming_group = $this->data_json['thought_of_forming_group'];
                            if (isset($this->data_json['try_towards_group_formation1']) and $this->data_json['try_towards_group_formation1'])
                                $srlm_bc_application->try_towards_group_formation1 = $this->data_json['try_towards_group_formation1'];
                            if (isset($this->data_json['try_towards_group_formation2']) and $this->data_json['try_towards_group_formation2'])
                                $srlm_bc_application->try_towards_group_formation2 = $this->data_json['try_towards_group_formation2'];
                            if (isset($this->data_json['try_towards_group_formation3']) and $this->data_json['try_towards_group_formation3'])
                                $srlm_bc_application->try_towards_group_formation3 = $this->data_json['try_towards_group_formation3'];
                            if (isset($this->data_json['try_towards_group_formation4']) and $this->data_json['try_towards_group_formation4'])
                                $srlm_bc_application->try_towards_group_formation4 = $this->data_json['try_towards_group_formation4'];
                            if (isset($this->data_json['try_towards_group_formation5']) and $this->data_json['try_towards_group_formation5'])
                                $srlm_bc_application->try_towards_group_formation5 = $this->data_json['try_towards_group_formation5'];
                            if (isset($this->data_json['try_towards_group_formation6']) and $this->data_json['try_towards_group_formation6'])
                                $srlm_bc_application->try_towards_group_formation6 = $this->data_json['try_towards_group_formation6'];
                            if (isset($this->data_json['try_towards_group_formation7']) and $this->data_json['try_towards_group_formation7'])
                                $srlm_bc_application->try_towards_group_formation7 = $this->data_json['try_towards_group_formation7'];
                            if (isset($this->data_json['try_towards_group_formation8']) and $this->data_json['try_towards_group_formation8'])
                                $srlm_bc_application->try_towards_group_formation8 = $this->data_json['try_towards_group_formation8'];
                            if (isset($this->data_json['leadership_name_index']) and $this->data_json['leadership_name_index'])
                                $srlm_bc_application->leadership_name_index = $this->data_json['leadership_name_index'];
                            if (isset($this->data_json['leadership_name']) and $this->data_json['leadership_name'])
                                $srlm_bc_application->leadership_name = $this->data_json['leadership_name'];
                            if (isset($this->data_json['role_in_group1']) and $this->data_json['role_in_group1'])
                                $srlm_bc_application->role_in_group1 = $this->data_json['role_in_group1'];
                            if (isset($this->data_json['role_in_group2']) and $this->data_json['role_in_group2'])
                                $srlm_bc_application->role_in_group2 = $this->data_json['role_in_group2'];
                            if (isset($this->data_json['role_in_group3']) and $this->data_json['role_in_group3'])
                                $srlm_bc_application->role_in_group3 = $this->data_json['role_in_group3'];
                            if (isset($this->data_json['role_in_group4']) and $this->data_json['role_in_group4'])
                                $srlm_bc_application->role_in_group4 = $this->data_json['role_in_group4'];
                            if (isset($this->data_json['role_in_group5']) and $this->data_json['role_in_group5'])
                                $srlm_bc_application->role_in_group5 = $this->data_json['role_in_group5'];
                            if (isset($this->data_json['role_in_group6']) and $this->data_json['role_in_group6'])
                                $srlm_bc_application->role_in_group6 = $this->data_json['role_in_group6'];
                            if (isset($this->data_json['role_in_group7']) and $this->data_json['role_in_group7'])
                                $srlm_bc_application->role_in_group7 = $this->data_json['role_in_group7'];
                            if (isset($this->data_json['role_in_group8']) and $this->data_json['role_in_group8'])
                                $srlm_bc_application->role_in_group8 = $this->data_json['role_in_group8'];
                            if (isset($this->data_json['why_did_you_get_elected1']) and $this->data_json['why_did_you_get_elected1'])
                                $srlm_bc_application->why_did_you_get_elected1 = $this->data_json['why_did_you_get_elected1'];
                            if (isset($this->data_json['why_did_you_get_elected2']) and $this->data_json['why_did_you_get_elected2'])
                                $srlm_bc_application->why_did_you_get_elected2 = $this->data_json['why_did_you_get_elected2'];
                            if (isset($this->data_json['why_did_you_get_elected3']) and $this->data_json['why_did_you_get_elected3'])
                                $srlm_bc_application->why_did_you_get_elected3 = $this->data_json['why_did_you_get_elected3'];
                            if (isset($this->data_json['why_did_you_get_elected4']) and $this->data_json['why_did_you_get_elected4'])
                                $srlm_bc_application->why_did_you_get_elected4 = $this->data_json['why_did_you_get_elected4'];
                            if (isset($this->data_json['why_did_you_get_elected5']) and $this->data_json['why_did_you_get_elected5'])
                                $srlm_bc_application->why_did_you_get_elected5 = $this->data_json['why_did_you_get_elected5'];
                            if (isset($this->data_json['why_did_you_get_elected6']) and $this->data_json['why_did_you_get_elected6'])
                                $srlm_bc_application->why_did_you_get_elected6 = $this->data_json['why_did_you_get_elected6'];
                            if (isset($this->data_json['why_did_you_get_elected7']) and $this->data_json['why_did_you_get_elected7'])
                                $srlm_bc_application->why_did_you_get_elected7 = $this->data_json['why_did_you_get_elected7'];
                            if (isset($this->data_json['why_did_you_get_elected8']) and $this->data_json['why_did_you_get_elected8'])
                                $srlm_bc_application->why_did_you_get_elected8 = $this->data_json['why_did_you_get_elected8'];
                            if (isset($this->data_json['why_did_you_get_elected9']) and $this->data_json['why_did_you_get_elected9'])
                                $srlm_bc_application->why_did_you_get_elected9 = $this->data_json['why_did_you_get_elected9'];
                            if (isset($this->data_json['if_you_were_a_member_of_a_self_help_group1']) and $this->data_json['if_you_were_a_member_of_a_self_help_group1'])
                                $srlm_bc_application->if_you_were_a_member_of_a_self_help_group1 = $this->data_json['if_you_were_a_member_of_a_self_help_group1'];
                            if (isset($this->data_json['if_you_were_a_member_of_a_self_help_group2']) and $this->data_json['if_you_were_a_member_of_a_self_help_group2'])
                                $srlm_bc_application->if_you_were_a_member_of_a_self_help_group2 = $this->data_json['if_you_were_a_member_of_a_self_help_group2'];
                            if (isset($this->data_json['if_you_were_a_member_of_a_self_help_group3']) and $this->data_json['if_you_were_a_member_of_a_self_help_group3'])
                                $srlm_bc_application->if_you_were_a_member_of_a_self_help_group3 = $this->data_json['if_you_were_a_member_of_a_self_help_group3'];
                            if (isset($this->data_json['if_you_were_a_member_of_a_self_help_group4']) and $this->data_json['if_you_were_a_member_of_a_self_help_group4'])
                                $srlm_bc_application->if_you_were_a_member_of_a_self_help_group4 = $this->data_json['if_you_were_a_member_of_a_self_help_group4'];
                            if (isset($this->data_json['if_you_were_a_member_of_a_self_help_group5']) and $this->data_json['if_you_were_a_member_of_a_self_help_group5'])
                                $srlm_bc_application->if_you_were_a_member_of_a_self_help_group5 = $this->data_json['if_you_were_a_member_of_a_self_help_group5'];
                            if (isset($this->data_json['if_you_were_a_member_of_a_self_help_group6']) and $this->data_json['if_you_were_a_member_of_a_self_help_group6'])
                                $srlm_bc_application->if_you_were_a_member_of_a_self_help_group6 = $this->data_json['if_you_were_a_member_of_a_self_help_group6'];
                            if (isset($this->data_json['if_you_were_a_member_of_a_self_help_group7']) and $this->data_json['if_you_were_a_member_of_a_self_help_group7'])
                                $srlm_bc_application->if_you_were_a_member_of_a_self_help_group7 = $this->data_json['if_you_were_a_member_of_a_self_help_group7'];
                            if (isset($this->data_json['if_you_were_a_member_of_a_self_help_group8']) and $this->data_json['if_you_were_a_member_of_a_self_help_group8'])
                                $srlm_bc_application->if_you_were_a_member_of_a_self_help_group8 = $this->data_json['if_you_were_a_member_of_a_self_help_group8'];
                            if (isset($this->data_json['if_you_were_a_member_of_a_self_help_group9']) and $this->data_json['if_you_were_a_member_of_a_self_help_group9'])
                                $srlm_bc_application->if_you_were_a_member_of_a_self_help_group9 = $this->data_json['if_you_were_a_member_of_a_self_help_group9'];
                            if (isset($this->data_json['active_members_name1']) and $this->data_json['active_members_name1'])
                                $srlm_bc_application->active_members_name1 = $this->data_json['active_members_name1'];
                            if (isset($this->data_json['active_members_name2']) and $this->data_json['active_members_name2'])
                                $srlm_bc_application->active_members_name2 = $this->data_json['active_members_name2'];
                            if (isset($this->data_json['active_members_position1']) and $this->data_json['active_members_position1'])
                                $srlm_bc_application->active_members_position1 = $this->data_json['active_members_position1'];
                            if (isset($this->data_json['active_members_position2']) and $this->data_json['active_members_position2'])
                                $srlm_bc_application->active_members_position2 = $this->data_json['active_members_position2'];
                            if (isset($this->data_json['belongingness_name1']) and $this->data_json['belongingness_name1'])
                                $srlm_bc_application->belongingness_name1 = $this->data_json['belongingness_name1'];
                            if (isset($this->data_json['belongingness_name2']) and $this->data_json['belongingness_name2'])
                                $srlm_bc_application->belongingness_name2 = $this->data_json['belongingness_name2'];
                            if (isset($this->data_json['belongingness_position1']) and $this->data_json['belongingness_position1'])
                                $srlm_bc_application->belongingness_position1 = $this->data_json['belongingness_position1'];
                            if (isset($this->data_json['belongingness_position2']) and $this->data_json['belongingness_position2'])
                                $srlm_bc_application->belongingness_position2 = $this->data_json['belongingness_position2'];
                            if (isset($this->data_json['awareness_name1']) and $this->data_json['awareness_name1'])
                                $srlm_bc_application->awareness_name1 = $this->data_json['awareness_name1'];
                            if (isset($this->data_json['awareness_name2']) and $this->data_json['awareness_name2'])
                                $srlm_bc_application->awareness_name2 = $this->data_json['awareness_name2'];
                            if (isset($this->data_json['awareness_position1']) and $this->data_json['awareness_position1'])
                                $srlm_bc_application->awareness_position1 = $this->data_json['awareness_position1'];
                            if (isset($this->data_json['awareness_position2']) and $this->data_json['awareness_position2'])
                                $srlm_bc_application->awareness_position2 = $this->data_json['awareness_position2'];
                            if (isset($this->data_json['member_who_contact_in_other_group_name1']) and $this->data_json['member_who_contact_in_other_group_name1'])
                                $srlm_bc_application->member_who_contact_in_other_group_name1 = $this->data_json['member_who_contact_in_other_group_name1'];
                            if (isset($this->data_json['member_who_contact_in_other_group_name2']) and $this->data_json['member_who_contact_in_other_group_name2'])
                                $srlm_bc_application->member_who_contact_in_other_group_name2 = $this->data_json['member_who_contact_in_other_group_name2'];
                            if (isset($this->data_json['member_who_contact_in_other_group_position1']) and $this->data_json['member_who_contact_in_other_group_position1'])
                                $srlm_bc_application->member_who_contact_in_other_group_position1 = $this->data_json['member_who_contact_in_other_group_position1'];
                            if (isset($this->data_json['member_who_contact_in_other_group_position2']) and $this->data_json['member_who_contact_in_other_group_position2'])
                                $srlm_bc_application->member_who_contact_in_other_group_position2 = $this->data_json['member_who_contact_in_other_group_position2'];
                            if (isset($this->data_json['demanded_group_member_name1']) and $this->data_json['demanded_group_member_name1'])
                                $srlm_bc_application->demanded_group_member_name1 = $this->data_json['demanded_group_member_name1'];
                            if (isset($this->data_json['demanded_group_member_name2']) and $this->data_json['demanded_group_member_name2'])
                                $srlm_bc_application->demanded_group_member_name2 = $this->data_json['demanded_group_member_name2'];
                            if (isset($this->data_json['demanded_group_member_position1']) and $this->data_json['demanded_group_member_position1'])
                                $srlm_bc_application->demanded_group_member_position1 = $this->data_json['demanded_group_member_position1'];
                            if (isset($this->data_json['demanded_group_member_position2']) and $this->data_json['demanded_group_member_position2'])
                                $srlm_bc_application->demanded_group_member_position2 = $this->data_json['demanded_group_member_position2'];
                            if (isset($this->data_json['capable_fast_pace']) and $this->data_json['capable_fast_pace'])
                                $srlm_bc_application->capable_fast_pace = $this->data_json['capable_fast_pace'];
                            if (isset($this->data_json['why_demanded1']) and $this->data_json['why_demanded1'])
                                $srlm_bc_application->why_demanded1 = $this->data_json['why_demanded1'];
                            if (isset($this->data_json['why_demanded2']) and $this->data_json['why_demanded2'])
                                $srlm_bc_application->why_demanded2 = $this->data_json['why_demanded2'];
                            if (isset($this->data_json['why_demanded3']) and $this->data_json['why_demanded3'])
                                $srlm_bc_application->why_demanded3 = $this->data_json['why_demanded3'];
                            if (isset($this->data_json['why_demanded4']) and $this->data_json['why_demanded4'])
                                $srlm_bc_application->why_demanded4 = $this->data_json['why_demanded4'];
                            if (isset($this->data_json['why_demanded5']) and $this->data_json['why_demanded5'])
                                $srlm_bc_application->why_demanded5 = $this->data_json['why_demanded5'];
                            if (isset($this->data_json['why_demanded6']) and $this->data_json['why_demanded6'])
                                $srlm_bc_application->why_demanded6 = $this->data_json['why_demanded6'];
                            if (isset($this->data_json['if_you_have_group_members_what_are_they']) and $this->data_json['if_you_have_group_members_what_are_they'])
                                $srlm_bc_application->if_you_have_group_members_what_are_they = $this->data_json['if_you_have_group_members_what_are_they'];
                            if (isset($this->data_json['capable_fast_pace_member_name']) and $this->data_json['capable_fast_pace_member_name'])
                                $srlm_bc_application->capable_fast_pace_member_name = $this->data_json['capable_fast_pace_member_name'];
                            if (isset($this->data_json['capable_fast_pace_member_number']) and $this->data_json['capable_fast_pace_member_number'])
                                $srlm_bc_application->capable_fast_pace_member_number = $this->data_json['capable_fast_pace_member_number'];
                            if (isset($this->data_json['his_perception1']) and $this->data_json['his_perception1'])
                                $srlm_bc_application->his_perception1 = $this->data_json['his_perception1'];
                            if (isset($this->data_json['his_perception2']) and $this->data_json['his_perception2'])
                                $srlm_bc_application->his_perception2 = $this->data_json['his_perception2'];
                            if (isset($this->data_json['his_perception3']) and $this->data_json['his_perception3'])
                                $srlm_bc_application->his_perception3 = $this->data_json['his_perception3'];
                            if (isset($this->data_json['his_perception4']) and $this->data_json['his_perception4'])
                                $srlm_bc_application->his_perception4 = $this->data_json['his_perception4'];
                            if (isset($this->data_json['his_perception5']) and $this->data_json['his_perception5'])
                                $srlm_bc_application->his_perception5 = $this->data_json['his_perception5'];
                            if (isset($this->data_json['his_perception6']) and $this->data_json['his_perception6'])
                                $srlm_bc_application->his_perception6 = $this->data_json['his_perception6'];
                            if (isset($this->data_json['his_perception7']) and $this->data_json['his_perception7'])
                                $srlm_bc_application->his_perception7 = $this->data_json['his_perception7'];
                            if (isset($this->data_json['his_perception8']) and $this->data_json['his_perception8'])
                                $srlm_bc_application->his_perception8 = $this->data_json['his_perception8'];
                            if (isset($this->data_json['what_could_you_do_if_you_were_in_a_group1']) and $this->data_json['what_could_you_do_if_you_were_in_a_group1'])
                                $srlm_bc_application->what_could_you_do_if_you_were_in_a_group1 = $this->data_json['what_could_you_do_if_you_were_in_a_group1'];
                            if (isset($this->data_json['what_could_you_do_if_you_were_in_a_group2']) and $this->data_json['what_could_you_do_if_you_were_in_a_group2'])
                                $srlm_bc_application->what_could_you_do_if_you_were_in_a_group2 = $this->data_json['what_could_you_do_if_you_were_in_a_group2'];
                            if (isset($this->data_json['what_could_you_do_if_you_were_in_a_group3']) and $this->data_json['what_could_you_do_if_you_were_in_a_group3'])
                                $srlm_bc_application->what_could_you_do_if_you_were_in_a_group3 = $this->data_json['what_could_you_do_if_you_were_in_a_group3'];
                            if (isset($this->data_json['what_could_you_do_if_you_were_in_a_group4']) and $this->data_json['what_could_you_do_if_you_were_in_a_group4'])
                                $srlm_bc_application->what_could_you_do_if_you_were_in_a_group4 = $this->data_json['what_could_you_do_if_you_were_in_a_group4'];
                            if (isset($this->data_json['what_could_you_do_if_you_were_in_a_group5']) and $this->data_json['what_could_you_do_if_you_were_in_a_group5'])
                                $srlm_bc_application->what_could_you_do_if_you_were_in_a_group5 = $this->data_json['what_could_you_do_if_you_were_in_a_group5'];
                            if (isset($this->data_json['what_could_you_do_if_you_were_in_a_group6']) and $this->data_json['what_could_you_do_if_you_were_in_a_group6'])
                                $srlm_bc_application->what_could_you_do_if_you_were_in_a_group6 = $this->data_json['what_could_you_do_if_you_were_in_a_group6'];
                            if (isset($this->data_json['what_could_you_do_if_you_were_in_a_group7']) and $this->data_json['what_could_you_do_if_you_were_in_a_group7'])
                                $srlm_bc_application->what_could_you_do_if_you_were_in_a_group7 = $this->data_json['what_could_you_do_if_you_were_in_a_group7'];
                            if (isset($this->data_json['what_could_you_do_if_you_were_in_a_group8']) and $this->data_json['what_could_you_do_if_you_were_in_a_group8'])
                                $srlm_bc_application->what_could_you_do_if_you_were_in_a_group8 = $this->data_json['what_could_you_do_if_you_were_in_a_group8'];
                            if (isset($this->data_json['what_could_you_do_if_you_were_in_a_group9']) and $this->data_json['what_could_you_do_if_you_were_in_a_group9'])
                                $srlm_bc_application->what_could_you_do_if_you_were_in_a_group9 = $this->data_json['what_could_you_do_if_you_were_in_a_group9'];
                            if (isset($this->data_json['most_contribute_index']) and $this->data_json['most_contribute_index'])
                                $srlm_bc_application->most_contribute_index = $this->data_json['most_contribute_index'];
                            if (isset($this->data_json['most_contribute_name']) and $this->data_json['most_contribute_name'])
                                $srlm_bc_application->most_contribute_name = $this->data_json['most_contribute_name'];
                            if (isset($this->data_json['group_culture']) and $this->data_json['group_culture'])
                                $srlm_bc_application->group_culture = $this->data_json['group_culture'];
                            if (isset($this->data_json['provision_in_the_group_as_voluntary']) and $this->data_json['provision_in_the_group_as_voluntary'])
                                $srlm_bc_application->provision_in_the_group_as_voluntary = $this->data_json['provision_in_the_group_as_voluntary'];
                            if (isset($this->data_json['entrepreneurial_index']) and $this->data_json['entrepreneurial_index'])
                                $srlm_bc_application->entrepreneurial_index = $this->data_json['entrepreneurial_index'];
                            if (isset($this->data_json['entrepreneurial']) and $this->data_json['entrepreneurial'])
                                $srlm_bc_application->entrepreneurial = $this->data_json['entrepreneurial'];
                            if (isset($this->data_json['economic_status']) and $this->data_json['economic_status'])
                                $srlm_bc_application->economic_status = $this->data_json['economic_status'];
                            if (isset($this->data_json['afraid_unknown_rules_index1']) and $this->data_json['afraid_unknown_rules_index1'])
                                $srlm_bc_application->afraid_unknown_rules_index1 = $this->data_json['afraid_unknown_rules_index1'];

                            if (isset($this->data_json['afraid_unknown_rules1']) and $this->data_json['afraid_unknown_rules1'])
                                $srlm_bc_application->afraid_unknown_rules1 = $this->data_json['afraid_unknown_rules1'];
                            if (isset($this->data_json['afraid_unknown_rules_index2']) and $this->data_json['afraid_unknown_rules_index2'])
                                $srlm_bc_application->afraid_unknown_rules_index2 = $this->data_json['afraid_unknown_rules_index2'];
                            if (isset($this->data_json['afraid_unknown_rules2']) and $this->data_json['afraid_unknown_rules2'])
                                $srlm_bc_application->afraid_unknown_rules2 = $this->data_json['afraid_unknown_rules2'];
                            if (isset($this->data_json['concept_of_setting_up_new_heights_index']) and $this->data_json['concept_of_setting_up_new_heights_index'])
                                $srlm_bc_application->concept_of_setting_up_new_heights_index = $this->data_json['concept_of_setting_up_new_heights_index'];
                            if (isset($this->data_json['concept_of_setting_up_new_heights']) and $this->data_json['concept_of_setting_up_new_heights'])
                                $srlm_bc_application->concept_of_setting_up_new_heights = $this->data_json['concept_of_setting_up_new_heights'];
                            if (isset($this->data_json['livelihood_opportunity_for_another_member_index1']) and $this->data_json['livelihood_opportunity_for_another_member_index1'])
                                $srlm_bc_application->livelihood_opportunity_for_another_member_index1 = $this->data_json['livelihood_opportunity_for_another_member_index1'];
                            if (isset($this->data_json['livelihood_opportunity_for_another_member1']) and $this->data_json['livelihood_opportunity_for_another_member1'])
                                $srlm_bc_application->livelihood_opportunity_for_another_member1 = $this->data_json['livelihood_opportunity_for_another_member1'];
                            if (isset($this->data_json['livelihood_opportunity_for_another_member_index2']) and $this->data_json['livelihood_opportunity_for_another_member_index2'])
                                $srlm_bc_application->livelihood_opportunity_for_another_member_index2 = $this->data_json['livelihood_opportunity_for_another_member_index2'];
                            if (isset($this->data_json['livelihood_opportunity_for_another_member2']) and $this->data_json['livelihood_opportunity_for_another_member2'])
                                $srlm_bc_application->livelihood_opportunity_for_another_member2 = $this->data_json['livelihood_opportunity_for_another_member2'];
                            if (isset($this->data_json['negotiate_best_index1']) and $this->data_json['negotiate_best_index1'])
                                $srlm_bc_application->negotiate_best_index1 = $this->data_json['negotiate_best_index1'];
                            if (isset($this->data_json['negotiate_best1']) and $this->data_json['negotiate_best1'])
                                $srlm_bc_application->negotiate_best1 = $this->data_json['negotiate_best1'];
                            if (isset($this->data_json['negotiate_best_index2']) and $this->data_json['negotiate_best_index2'])
                                $srlm_bc_application->negotiate_best_index2 = $this->data_json['negotiate_best_index2'];
                            if (isset($this->data_json['negotiate_best2']) and $this->data_json['negotiate_best2'])
                                $srlm_bc_application->negotiate_best2 = $this->data_json['negotiate_best2'];
                            if (isset($this->data_json['which_member_can_talk_advantages_index1']) and $this->data_json['which_member_can_talk_advantages_index1'])
                                $srlm_bc_application->which_member_can_talk_advantages_index1 = $this->data_json['which_member_can_talk_advantages_index1'];
                            if (isset($this->data_json['which_member_can_talk_advantages1']) and $this->data_json['which_member_can_talk_advantages1'])
                                $srlm_bc_application->which_member_can_talk_advantages1 = $this->data_json['which_member_can_talk_advantages1'];
                            if (isset($this->data_json['which_member_can_talk_advantages_index2']) and $this->data_json['which_member_can_talk_advantages_index2'])
                                $srlm_bc_application->which_member_can_talk_advantages_index2 = $this->data_json['which_member_can_talk_advantages_index2'];
                            if (isset($this->data_json['which_member_can_talk_advantages2']) and $this->data_json['which_member_can_talk_advantages2'])
                                $srlm_bc_application->which_member_can_talk_advantages2 = $this->data_json['which_member_can_talk_advantages2'];
                            if (isset($this->data_json['can_read_write_hindi']) and $this->data_json['can_read_write_hindi'])
                                $srlm_bc_application->can_read_write_hindi = $this->data_json['can_read_write_hindi'];
                            if (isset($this->data_json['confirtable_in_english']) and $this->data_json['confirtable_in_english'])
                                $srlm_bc_application->confirtable_in_english = $this->data_json['confirtable_in_english'];
                            if (isset($this->data_json['recognize_english_hindi']) and $this->data_json['recognize_english_hindi'])
                                $srlm_bc_application->recognize_english_hindi = $this->data_json['recognize_english_hindi'];
                            if (isset($this->data_json['can_add_substract_multiply']) and $this->data_json['can_add_substract_multiply'])
                                $srlm_bc_application->can_add_substract_multiply = $this->data_json['can_add_substract_multiply'];
                            if (isset($this->data_json['who_maintain_account_index']) and $this->data_json['who_maintain_account_index'])
                                $srlm_bc_application->who_maintain_account_index = $this->data_json['who_maintain_account_index'];
                            if (isset($this->data_json['who_maintain_account']) and $this->data_json['who_maintain_account'])
                                $srlm_bc_application->who_maintain_account = $this->data_json['who_maintain_account'];
                            if (isset($this->data_json['choose_other_meaning1']) and $this->data_json['choose_other_meaning1'])
                                $srlm_bc_application->choose_other_meaning1 = $this->data_json['choose_other_meaning1'];
                            if (isset($this->data_json['choose_other_meaning2']) and $this->data_json['choose_other_meaning2'])
                                $srlm_bc_application->choose_other_meaning2 = $this->data_json['choose_other_meaning2'];
                            if (isset($this->data_json['choose_other_meaning3']) and $this->data_json['choose_other_meaning3'])
                                $srlm_bc_application->choose_other_meaning3 = $this->data_json['choose_other_meaning3'];
                            if (isset($this->data_json['choose_other_meaning4']) and $this->data_json['choose_other_meaning4'])
                                $srlm_bc_application->choose_other_meaning4 = $this->data_json['choose_other_meaning4'];
                            if (isset($this->data_json['choose_other_meaning5']) and $this->data_json['choose_other_meaning5'])
                                $srlm_bc_application->choose_other_meaning5 = $this->data_json['choose_other_meaning5'];
                            if (isset($this->data_json['same_to_same_word1']) and $this->data_json['same_to_same_word1'])
                                $srlm_bc_application->same_to_same_word1 = $this->data_json['same_to_same_word1'];
                            if (isset($this->data_json['same_to_same_word2']) and $this->data_json['same_to_same_word2'])
                                $srlm_bc_application->same_to_same_word2 = $this->data_json['same_to_same_word2'];
                            if (isset($this->data_json['same_to_same_word3']) and $this->data_json['same_to_same_word3'])
                                $srlm_bc_application->same_to_same_word3 = $this->data_json['same_to_same_word3'];
                            if (isset($this->data_json['english_to_hindi1']) and $this->data_json['english_to_hindi1'])
                                $srlm_bc_application->english_to_hindi1 = $this->data_json['english_to_hindi1'];
                            if (isset($this->data_json['english_to_hindi2']) and $this->data_json['english_to_hindi2'])
                                $srlm_bc_application->english_to_hindi2 = $this->data_json['english_to_hindi2'];
                            if (isset($this->data_json['english_to_hindi3']) and $this->data_json['english_to_hindi3'])
                                $srlm_bc_application->english_to_hindi3 = $this->data_json['english_to_hindi3'];
                            if (isset($this->data_json['english_to_hindi4']) and $this->data_json['english_to_hindi4'])
                                $srlm_bc_application->english_to_hindi4 = $this->data_json['english_to_hindi4'];
                            if (isset($this->data_json['english_to_hindi5']) and $this->data_json['english_to_hindi5'])
                                $srlm_bc_application->english_to_hindi5 = $this->data_json['english_to_hindi5'];
                            if (isset($this->data_json['percentage_option1']) and $this->data_json['percentage_option1'])
                                $srlm_bc_application->percentage_option1 = $this->data_json['percentage_option1'];
                            if (isset($this->data_json['percentage_option2']) and $this->data_json['percentage_option2'])
                                $srlm_bc_application->percentage_option2 = $this->data_json['percentage_option2'];
                            if (isset($this->data_json['percentage_option3']) and $this->data_json['percentage_option3'])
                                $srlm_bc_application->percentage_option3 = $this->data_json['percentage_option3'];
                            if (isset($this->data_json['percentage_option4']) and $this->data_json['percentage_option4'])
                                $srlm_bc_application->percentage_option4 = $this->data_json['percentage_option4'];
                            if (isset($this->data_json['percentage_option5']) and $this->data_json['percentage_option5'])
                                $srlm_bc_application->percentage_option5 = $this->data_json['percentage_option5'];
                            if (isset($this->data_json['option_decision1']) and $this->data_json['option_decision1'])
                                $srlm_bc_application->option_decision1 = $this->data_json['option_decision1'];
                            if (isset($this->data_json['option_decision2']) and $this->data_json['option_decision2'])
                                $srlm_bc_application->option_decision2 = $this->data_json['option_decision2'];
                            if (isset($this->data_json['option_decision3']) and $this->data_json['option_decision3'])
                                $srlm_bc_application->option_decision3 = $this->data_json['option_decision3'];
                            if (isset($this->data_json['option_decision4']) and $this->data_json['option_decision4'])
                                $srlm_bc_application->option_decision4 = $this->data_json['option_decision4'];
                            if (isset($this->data_json['option_decision5']) and $this->data_json['option_decision5'])
                                $srlm_bc_application->option_decision5 = $this->data_json['option_decision5'];
                            if (isset($this->data_json['mobile_use_experience']) and $this->data_json['mobile_use_experience'])
                                $srlm_bc_application->mobile_use_experience = $this->data_json['mobile_use_experience'];
                            if (isset($this->data_json['whose_mobile_you_using']) and $this->data_json['whose_mobile_you_using'])
                                $srlm_bc_application->whose_mobile_you_using = $this->data_json['whose_mobile_you_using'];
                            if (isset($this->data_json['no_of_people_using_phone']) and $this->data_json['no_of_people_using_phone'])
                                $srlm_bc_application->no_of_people_using_phone = $this->data_json['no_of_people_using_phone'];
                            if (isset($this->data_json['no_of_family_people_using_phone']) and $this->data_json['no_of_family_people_using_phone'])
                                $srlm_bc_application->no_of_family_people_using_phone = $this->data_json['no_of_family_people_using_phone'];
                            if (isset($this->data_json['need_help_to_fill_form']) and $this->data_json['need_help_to_fill_form'])
                                $srlm_bc_application->need_help_to_fill_form = $this->data_json['need_help_to_fill_form'];
                            if (isset($this->data_json['already_worked']) and $this->data_json['already_worked'])
                                $srlm_bc_application->already_worked = $this->data_json['already_worked'];
                            if (isset($this->data_json['own_mobile']) and $this->data_json['own_mobile'])
                                $srlm_bc_application->own_mobile = $this->data_json['own_mobile'];
                            if (isset($this->data_json['own_mobile_means1']) and $this->data_json['own_mobile_means1'])
                                $srlm_bc_application->own_mobile_means1 = $this->data_json['own_mobile_means1'];
                            if (isset($this->data_json['own_mobile_means2']) and $this->data_json['own_mobile_means2'])
                                $srlm_bc_application->own_mobile_means2 = $this->data_json['own_mobile_means2'];
                            if (isset($this->data_json['own_mobile_means3']) and $this->data_json['own_mobile_means3'])
                                $srlm_bc_application->own_mobile_means3 = $this->data_json['own_mobile_means3'];
                            if (isset($this->data_json['own_mobile_means4']) and $this->data_json['own_mobile_means4'])
                                $srlm_bc_application->own_mobile_means4 = $this->data_json['own_mobile_means4'];
                            if (isset($this->data_json['own_mobile_means5']) and $this->data_json['own_mobile_means5'])
                                $srlm_bc_application->own_mobile_means5 = $this->data_json['own_mobile_means5'];
                            if (isset($this->data_json['own_mobile_means6']) and $this->data_json['own_mobile_means6'])
                                $srlm_bc_application->own_mobile_means6 = $this->data_json['own_mobile_means6'];
                            if (isset($this->data_json['own_mobile_means7']) and $this->data_json['own_mobile_means7'])
                                $srlm_bc_application->own_mobile_means7 = $this->data_json['own_mobile_means7'];
                            if (isset($this->data_json['own_mobile_means8']) and $this->data_json['own_mobile_means8'])
                                $srlm_bc_application->own_mobile_means8 = $this->data_json['own_mobile_means8'];
                            if (isset($this->data_json['method_used_for_ledger_account1']) and $this->data_json['method_used_for_ledger_account1'])
                                $srlm_bc_application->method_used_for_ledger_account1 = $this->data_json['method_used_for_ledger_account1'];
                            if (isset($this->data_json['method_used_for_ledger_account2']) and $this->data_json['method_used_for_ledger_account2'])
                                $srlm_bc_application->method_used_for_ledger_account2 = $this->data_json['method_used_for_ledger_account2'];
                            if (isset($this->data_json['method_used_for_ledger_account3']) and $this->data_json['method_used_for_ledger_account3'])
                                $srlm_bc_application->method_used_for_ledger_account3 = $this->data_json['method_used_for_ledger_account3'];
                            if (isset($this->data_json['method_used_for_ledger_account4']) and $this->data_json['method_used_for_ledger_account4'])
                                $srlm_bc_application->method_used_for_ledger_account4 = $this->data_json['method_used_for_ledger_account4'];
                            if (isset($this->data_json['method_used_for_ledger_account5']) and $this->data_json['method_used_for_ledger_account5'])
                                $srlm_bc_application->method_used_for_ledger_account5 = $this->data_json['method_used_for_ledger_account5'];
                            if (isset($this->data_json['method_used_for_ledger_account6']) and $this->data_json['method_used_for_ledger_account6'])
                                $srlm_bc_application->method_used_for_ledger_account6 = $this->data_json['method_used_for_ledger_account6'];
                            if (isset($this->data_json['need_training1']) and $this->data_json['need_training1'])
                                $srlm_bc_application->need_training1 = $this->data_json['need_training1'];
                            if (isset($this->data_json['need_training2']) and $this->data_json['need_training2'])
                                $srlm_bc_application->need_training2 = $this->data_json['need_training2'];
                            if (isset($this->data_json['need_training3']) and $this->data_json['need_training3'])
                                $srlm_bc_application->need_training3 = $this->data_json['need_training3'];
                            if (isset($this->data_json['need_training4']) and $this->data_json['need_training4'])
                                $srlm_bc_application->need_training4 = $this->data_json['need_training4'];
                            if (isset($this->data_json['need_training5']) and $this->data_json['need_training5'])
                                $srlm_bc_application->need_training5 = $this->data_json['need_training5'];

                            if (isset($this->data_json['gps']) and $this->data_json['gps'])
                                $srlm_bc_application->gps = $this->data_json['gps'];
                            if (isset($this->data_json['gps_accuracy']) and $this->data_json['gps_accuracy'])
                                $srlm_bc_application->gps_accuracy = $this->data_json['gps_accuracy'];
                            $form_number = SrlmBcApplication::FORM_STATUS_BASIC_PROFILE;
                            if (isset($this->data_json['form_number'])) {
                                $form_number = $this->data_json['form_number'];
                            }

                            if ($form_number == SrlmBcApplication::FORM_STATUS_BASIC_PROFILE) {
                                $srlm_bc_application->form1_date_time = $model->time;
                            }
                            if ($form_number == SrlmBcApplication::FORM_STATUS_FAMILY_PROFILE) {
                                $srlm_bc_application->form2_date_time = $model->time;
                            }
                            if ($form_number == SrlmBcApplication::FORM_STATUS_PART_1) {
                                $srlm_bc_application->form3_date_time = $model->time;
                            }
                            if ($form_number == SrlmBcApplication::FORM_STATUS_PART_2) {
                                $srlm_bc_application->form4_date_time = $model->time;
                            }
                            if ($form_number == SrlmBcApplication::FORM_STATUS_PART_3) {
                                $srlm_bc_application->form5_date_time = $model->time;
                            }
                            if ($form_number == SrlmBcApplication::FORM_STATUS_PART_4) {
                                $srlm_bc_application->form6_date_time = $model->time;
                            }
                            $srlm_bc_application->srlm_bc_selection_api_log_id = $model->id;
                            if (isset($this->data_json['form_date']))
                                $srlm_bc_application->form_start_date = $this->data_json['form_date'];
                            if (isset($this->data_json['form_start_date']))
                                $srlm_bc_application->form_start_date = $this->data_json['form_start_date'];
                            $srlm_bc_application->updated_at = $model->created_at;
                            $srlm_bc_application->form_number = $form_number;
                            $srlm_bc_application->form_status = $form_number;
                            $srlm_bc_application->action_type = ($form_number + 1);
                            $srlm_bc_application->srlm_bc_selection_app_detail_id = $model->srlm_bc_selection_app_id;
                            if (isset($srlm_bc_application->user->profile_photo)) {
                                $srlm_bc_application->profile_photo = $srlm_bc_application->user->profile_photo;
                            }
                            if (isset($srlm_bc_application->user->aadhar_front_photo)) {
                                $srlm_bc_application->aadhar_front_photo = $srlm_bc_application->user->aadhar_front_photo;
                            }
                            if (isset($srlm_bc_application->user->aadhar_back_photo)) {
                                $srlm_bc_application->aadhar_back_photo = $srlm_bc_application->user->aadhar_back_photo;
                            }
                            if ($srlm_bc_application->profile_photo and $srlm_bc_application->aadhar_front_photo and $srlm_bc_application->aadhar_back_photo) {
                                $srlm_bc_application->bc_photo_status = 1;
                            }
                            if ($srlm_bc_application->form_uuid) {
                                if ($srlm_bc_application->save()) {
                                    if (isset($this->data_json['groupInformation']) and is_array($this->data_json['groupInformation'])) {
                                        foreach ($this->data_json['groupInformation'] as $family_info) {
                                            if (isset($family_info['form_uuid'])) {
                                                $family_model = SrlmBcApplicationGroupFamily7::find()->where(['form_uuid' => $family_info['form_uuid'], 'family_uuid' => $family_info['family_uuid']])->one();
                                                if (empty($family_model)) {
                                                    $family_model = new SrlmBcApplicationGroupFamily7();
                                                }

                                                $family_model->form_uuid = $family_info['form_uuid'];
                                                $family_model->family_uuid = $family_info['family_uuid'];
                                                $family_model->srlm_bc_application_id = $srlm_bc_application->id;
                                                $family_model->member_name = $family_info['member_name'];
                                                $family_model->position = $family_info['position'];
                                                $family_model->mobile_no = $family_info['mobile_no'];

                                                $family_model->status = \bc\modules\selection\models\base\GenralModel::STATUS_ACTIVE;
//                            
                                                if ($family_model->save()) {
                                                    
                                                } else {
                                                    
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    echo 'Error .' . $srlm_bc_application->id . PHP_EOL;
                                    print_r($srlm_bc_application->getErrors());
                                    exit;
                                }
                            }
                        } else {
                            \Yii::$app->runAction('srlmbcapplication/registration', [$model->srlm_bc_selection_user_id]);
                            exit;
                        }
                    }
                } catch (\Exception $ex) {
                    print_r($ex->getMessage());
                    exit;
                }
            }
        }
    }

    public function actionRegistration($id) {

        $max = SrlmBcApplication7::find()->max('srlm_bc_selection_user_id');
        $max = $max != NULL ? $max : 0;

        $models = SrlmBcSelectionUser::find()->andWhere(['=', 'id', $id])->orderBy('id asc')->limit($this->process_limt)->all();
        foreach ($models as $model) {
            $srlm_bc_application = SrlmBcApplication7::findOne(['srlm_bc_selection_user_id' => $model->id]);
            if (empty($srlm_bc_application)) {
                $srlm_bc_application = new SrlmBcApplication7();
                $srlm_bc_application->srlm_bc_selection_app_detail_id = $model->srlm_bc_selection_app_detail_id;
                $srlm_bc_application->srlm_bc_selection_user_id = $model->id;
                $srlm_bc_application->reg_date_time = date('Y-m-d H:i:s', $model->created_at);
                $srlm_bc_application->mobile_no = $model->mobile_no;
                $srlm_bc_application->orig_otp_mobile_no = $model->orig_otp_mobile_no;
                if ($model->profile_photo) {
                    $srlm_bc_application->profile_photo = $model->profile_photo;
                }
                if ($model->aadhar_front_photo) {
                    $srlm_bc_application->aadhar_front_photo = $model->aadhar_front_photo;
                }
                if ($model->aadhar_back_photo) {
                    $srlm_bc_application->aadhar_back_photo = $model->aadhar_back_photo;
                }
                $srlm_bc_application->created_at = $model->created_at;
                $srlm_bc_application->updated_at = $model->created_at;
                $srlm_bc_application->form_number = SrlmBcApplication::FORM_STATUS_REG;
                $srlm_bc_application->form_status = SrlmBcApplication::FORM_STATUS_REG;
                $srlm_bc_application->action_type = SrlmBcApplication::ACTION_TYPE_REG;
                $srlm_bc_application->status = 1;
                if ($srlm_bc_application->save()) {
                    $srlm_bc_application->application_id = 'UPBC' . Utility::add_leading_zero($srlm_bc_application->id, 6);
                    $srlm_bc_application->update();
                }
            }
        }
        exit();
    }

    public function actionRsph7() {

        $max = SrlmBcApplication7::find()->max('srlm_bc_selection_user_id');
        $max = $max != NULL ? $max : 0;

        $models = SrlmBcSelectionUser::find()->andWhere(['>', 'id', $max])->andWhere(['phase' => 7])->orderBy('id asc')->limit($this->process_limt)->all();
        foreach ($models as $model) {
            $srlm_bc_application = SrlmBcApplication7::findOne(['srlm_bc_selection_user_id' => $model->id]);
            if (empty($srlm_bc_application)) {
                $srlm_bc_application = new SrlmBcApplication7();
                $srlm_bc_application->srlm_bc_selection_app_detail_id = $model->srlm_bc_selection_app_detail_id;
                $srlm_bc_application->srlm_bc_selection_user_id = $model->id;
                $srlm_bc_application->reg_date_time = date('Y-m-d H:i:s', $model->created_at);
                $srlm_bc_application->mobile_no = $model->mobile_no;
                $srlm_bc_application->orig_otp_mobile_no = $model->orig_otp_mobile_no;
                if ($model->profile_photo) {
                    $srlm_bc_application->profile_photo = $model->profile_photo;
                }
                if ($model->aadhar_front_photo) {
                    $srlm_bc_application->aadhar_front_photo = $model->aadhar_front_photo;
                }
                if ($model->aadhar_back_photo) {
                    $srlm_bc_application->aadhar_back_photo = $model->aadhar_back_photo;
                }
                $srlm_bc_application->created_at = $model->created_at;
                $srlm_bc_application->updated_at = $model->created_at;
                $srlm_bc_application->form_number = SrlmBcApplication::FORM_STATUS_REG;
                $srlm_bc_application->form_status = SrlmBcApplication::FORM_STATUS_REG;
                $srlm_bc_application->action_type = SrlmBcApplication::ACTION_TYPE_REG;
                $srlm_bc_application->status = 1;
                if ($srlm_bc_application->save()) {
                    $srlm_bc_application->application_id = 'UPBC' . Utility::add_leading_zero($srlm_bc_application->id, 6);
                    $srlm_bc_application->update();
                }
            }
        }
        exit();
    }

    public function actionGpcomplete() {
        $models = \bc\models\master\MasterGramPanchayat::find()->joinWith(['gpdetail'])->where(['master_gram_panchayat.status' => 1, 'master_gram_panchayat_detail_bc.seventh_vacant' => 1])->all();
        foreach ($models as $model) {
            $condition1 = ['and',
                ['=', 'gram_panchayat_code', $model->gram_panchayat_code],
            ];

            $bc_selection_application_receive = SrlmBcApplication7::find()->where(['gram_panchayat_code' => $model->gram_panchayat_code])->andWhere(['!=', 'srlm_bc_application7.status', 0])->andWhere(['!=', 'srlm_bc_application7.status', -1])->andWhere(['srlm_bc_application7.gender' => 2, 'srlm_bc_application7.form_number' => 6])->andWhere(['urban_shg' => 0])->count();

            \bc\models\master\MasterGramPanchayatDetailBc::updateAll([
                'six_complete' => $bc_selection_application_receive,
                    ], $condition1);
        }

        return ExitCode::OK;
    }

//    public function actionFormno() {
//
//        $models = SrlmBcSelectionUser::find()->joinWith(['bcsapplication'])->andWhere(['not', ['srlm_bc_application.form_uuid' => null]])->andWhere(['not', ['srlm_bc_selection_user.form_json' => null]])->andWhere(['srlm_bc_selection_user.form_start_date' => null])->orderBy('id asc')->limit($this->process_limt)->all();
//        foreach ($models as $model) {
//            $condition = ['and',
//                ['=', 'id', $model->id],
//            ];
//            $form_end_date = null;
//            if ($model->bcsapplication->form_number == 1) {
//                $form_end_date = $model->bcsapplication->form1_date_time;
//            }
//            if ($model->bcsapplication->form_number == 2) {
//                $form_end_date = $model->bcsapplication->form2_date_time;
//            }
//            if ($model->bcsapplication->form_number == 3) {
//                $form_end_date = $model->bcsapplication->form3_date_time;
//            }
//            if ($model->bcsapplication->form_number == 4) {
//                $form_end_date = $model->bcsapplication->form4_date_time;
//            }
//            if ($model->bcsapplication->form_number == 5) {
//                $form_end_date = $model->bcsapplication->form5_date_time;
//            }
//            if ($model->bcsapplication->form_number == 6) {
//                $form_end_date = $model->bcsapplication->form6_date_time;
//            }
//            SrlmBcSelectionUser::updateAll([
//                'form_start_date' => $model->bcsapplication->form_start_date,
//                'form_end_date' => $form_end_date,
//                'form_number' => $model->bcsapplication->form_number,
//                    ], $condition);
//        }
//        exit();
//    }
//
//    public function actionRegusercsv() {
//        ini_set('max_execution_time', 600);
//        ini_set('memory_limit', '2048M');
//        $file_name = "registered_user";
//        $filePath = \Yii::$app->params['bcdatapath'] . 'bcselection/report/' . $file_name . ".csv";
//        $fp = fopen($filePath, 'a+');
//        $sr_no = 1;
//        $crone_model = SrlmCrone::findOne(1);
//        $models = SrlmBcSelectionUser::find()->where(['>', 'id', $crone_model->last_process_user_id])->orderBy('id asc')->limit($this->user_process_limit)->all();
//        $temp_data = '';
//        foreach ($models as $model) {
//
//            $mobile_no = $model->mobile_no;
//            $first_name = isset($model->bcsapplication->first_name) ? $model->bcsapplication->first_name : '';
//            $middle_name = isset($model->bcsapplication->middle_name) ? $model->bcsapplication->middle_name : '';
//            $sur_name = isset($model->bcsapplication->sur_name) ? $model->bcsapplication->sur_name : '';
//            $gender = isset($model->bcsapplication->genderrel) ? $model->bcsapplication->genderrel->name_eng : '';
//            $age = isset($model->bcsapplication->age) ? $model->bcsapplication->age : '';
//            $cast = isset($model->bcsapplication->castrel) ? $model->bcsapplication->castrel->name_eng : '';
//            $district_name = isset($model->bcsapplication->district_name) ? $model->bcsapplication->district_name : '';
//            $block_name = isset($model->bcsapplication->block_name) ? $model->bcsapplication->block_name : '';
//            $gram_panchayat_name = isset($model->bcsapplication->gram_panchayat_name) ? $model->bcsapplication->gram_panchayat_name : '';
//            $village_name = isset($model->bcsapplication->gram_panchayat_name) ? $model->bcsapplication->gram_panchayat_name : '';
//            $hamlet = isset($model->bcsapplication->hamlet) ? $model->bcsapplication->hamlet : '';
//            $guardian_name = isset($model->bcsapplication->guardian_name) ? $model->bcsapplication->guardian_name : '';
//            $aadhar_number = isset($model->bcsapplication->aadhar_number) ? $model->bcsapplication->aadhar_number : '';
//            $form_start_date = $model->form_start_date != null ? $model->form_start_date : '';
//            $form_number = $model->form_number != null ? $model->form_number : "";
//            $form_end_date = $model->form_end_date != null ? $model->form_end_date : '';
//
//            $temp_data .= "$model->id,"
//                    . "$mobile_no,"
//                    . "$first_name,"
//                    . "$middle_name,"
//                    . "$sur_name,"
//                    . "$gender,"
//                    . "$age,"
//                    . "$cast,"
//                    . "$district_name,"
//                    . "$block_name,"
//                    . "$gram_panchayat_name,"
//                    . "$village_name,"
//                    . "$hamlet,"
//                    . "$guardian_name,"
//                    . "$aadhar_number,"
//                    . "$form_number,"
//                    . "$form_start_date,"
//                    . "$form_end_date\n";
//            $sr_no++;
//            $crone_model->last_process_user_id = $model->id;
//            $crone_model->last_run_time_process_user = new Expression('NOW()');
//            $crone_model->update();
//        }
//        fwrite($fp, $temp_data);
//        fclose($fp);
//        return ExitCode::OK;
//    }
//
//    public function actionResetusercsv() {
//        ini_set('max_execution_time', 600);
//        ini_set('memory_limit', '2048M');
//
//        if (!file_exists(\Yii::$app->params['bcdatapath'] . 'bcselection/report')) {
//            mkdir(\Yii::$app->params['bcdatapath'] . 'bcselection/report');
//            chmod(\Yii::$app->params['bcdatapath'] . 'bcselection/report', 0777);
//        }
//        if (file_exists(\Yii::$app->params['bcdatapath'] . 'bcselection/report/registered_user.csv')) {
//            unlink(\Yii::$app->params['bcdatapath'] . 'bcselection/report/registered_user.csv');
//        }
//        $crone_model = BcApplicationCrone::findOne(1);
//        $crone_model->last_process_user_id = 0;
//        $crone_model->update(false);
//        $temp_data = "Sr. No.,"
//                . "Mobile No,"
//                . "First Name,"
//                . "Middle Name,"
//                . "Sur Name,"
//                . "Gender,"
//                . "Age,"
//                . "Social Category,"
//                . "District Name,"
//                . "Block Name ,"
//                . "Gram Panchayat Name,"
//                . "Village Name,"
//                . "Hamlet,"
//                . "Guardian Name,"
//                . "Aadhar Number,"
//                . "Section At,"
//                . "Started Filling Form On,"
//                . "Last form activity On\n";
//        $file_name = "registered_user";
//        $filePath = \Yii::$app->params['bcdatapath'] . 'bcselection/report/' . $file_name . ".csv";
//        $fp = fopen($filePath, 'a+');
//        fwrite($fp, $temp_data);
//        fclose($fp);
//        return ExitCode::OK;
//    }
//
//    function actionDeleterepeat() {
//        //SrlmBcSelectionApiLog::find()->where(['>', 'id', $max])->orderBy('id asc')->limit($this->process_limt)->all();
//        $count = 0;
//        for ($i = 1; $i < 300000; $i++) {
//            $models = SrlmBcApplication::find()->where(['srlm_bc_selection_user_id' => $i])->orderBy('id asc')->all();
//            $t = 0;
//            foreach ($models as $m) {
//                $t++;
//                if ($t == 1)
//                    continue;
//                if ($m->form_uuid == NULL || $m->form_uuid == "") {
//                    echo $i . "->" . $m->id . " , ";
//                    $m->delete();
//                    $count++;
//                }
//            }
//        }
//        echo $count;
//    }
}
