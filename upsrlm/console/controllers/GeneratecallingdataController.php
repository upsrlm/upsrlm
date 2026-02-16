<?php

namespace console\controllers;

use Yii;
use cbo\models\Shg;
use common\models\User;
use yii\console\ExitCode;
use yii\console\Controller;
use common\models\UserSearch;
use common\models\master\MasterRole;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiCall;
use common\models\dynamicdb\internalcallcenter\platform\CallingList;
use common\models\dynamicdb\internalcallcenter\platform\CallingScenarioUserVerification;

class GeneratecallingdataController extends Controller {

    /**
     * Generate Calling Data
     *
     * @return void
     */
    //    public function actionIndex()
    //    {
    //        $district_codes = [123]; // Data Will be generated for following Districts
    //        $call_scenario_id = 1001; // User Verification Scneario
    //        $upsrlm_call_type = 1; // Outbound(CTC)
    //        $call_reason_id = 2; // Direct Call or New Call
    //        $call_schedule_date = date('Y-m-d', strtotime("+1 days")); // Date for Call Schedule
    //
    //        foreach ($district_codes as $district_code) {
    //            $rishtashgmembers = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()
    //                ->innerjoinwith('cboshg')
    //                ->where(['district_code' => $district_code, 'sent_for_calling' => 0, 'role' => [1], 'cbo_shg.wada_shg' => 1, 'cbo_shg.dummy_column' => 0])->andWhere("rishta_shg_member.`user_id` IS NULL")->all();
    //            if ($rishtashgmembers) {
    //                foreach ($rishtashgmembers as $rishtashgmember) {
    //                    $newcall = CallingList::find()
    //                        ->where([
    //                            'rishta_shg_member_id' => $rishtashgmember->id,
    //                            'cbo_shg_id' => $rishtashgmember->cbo_shg_id,
    //                            'member_name' => $rishtashgmember->name,
    //                            'member_mobile' => $rishtashgmember->mobile,
    //                            'default_call_scenario_id' => $call_scenario_id,
    //                        ])->one();
    //                    if (!$newcall) {
    //                        $newcall = new CallingList();
    //                    }
    //                    $newcall->setAttributes([
    //                        'rishta_shg_member_id' => $rishtashgmember->id,
    //                        'cbo_shg_id' => $rishtashgmember->cbo_shg_id,
    //                        'name_of_shg' => $rishtashgmember->cboshg->name_of_shg,
    //                        'member_name' => $rishtashgmember->name,
    //                        'member_mobile' => $rishtashgmember->mobile,
    //                        'member_marital_status' => $rishtashgmember->marital_status,
    //                        'member_age' => $rishtashgmember->age,
    //                        'member_caste_category' => $rishtashgmember->caste_category,
    //                        'member_duration_of_membership' => $rishtashgmember->duration_of_membership,
    //                        'member_total_saving' => $rishtashgmember->total_saving,
    //                        'member_loan' => $rishtashgmember->loan,
    //                        'member_loan_count' => $rishtashgmember->loan_count,
    //                        'member_loan_amount' => $rishtashgmember->loan_amount,
    //                        'member_loan_date' => $rishtashgmember->loan_date,
    //                        'member_mcp_status' => $rishtashgmember->mcp_status,
    //                        'member_office_bearer' => $rishtashgmember->office_bearer,
    //                        'member_role' => $rishtashgmember->role,
    //                        'member_bank_account' => $rishtashgmember->bank_account,
    //                        'member_relative_in_shg' => $rishtashgmember->relative_in_shg,
    //                        'member_no_of_relative' => $rishtashgmember->no_of_relative,
    //                        'member_current_member' => $rishtashgmember->current_member,
    //                        'member_user_id' => $rishtashgmember->user_id,
    //                        'member_suggest_wada_sakhi' => $rishtashgmember->suggest_wada_sakhi,
    //                        'member_status' => $rishtashgmember->status,
    //                        'member_district_code' => $rishtashgmember->cboshg->district_code,
    //                        'member_district_name' => $rishtashgmember->cboshg->district_name,
    //                        'member_block_code' => $rishtashgmember->cboshg->block_code,
    //                        'member_block_name' => $rishtashgmember->cboshg->block_name,
    //                        'member_gram_panchayat_code' => $rishtashgmember->cboshg->gram_panchayat_code,
    //                        'member_gram_panchayat_name' => $rishtashgmember->cboshg->gram_panchayat_name,
    //                        'member_village_code' => $rishtashgmember->cboshg->village_code,
    //                        'member_village_name' => $rishtashgmember->cboshg->village_name,
    //                        'member_village_name' => $rishtashgmember->cboshg->village_name,
    //                        'member_wada_shg' => $rishtashgmember->cboshg->wada_shg,
    //                        'customer_number' => $rishtashgmember->mobile,
    //                        'call_generate_date' => date('Y-m-d'),
    //                        'default_call_scenario_id' => $call_scenario_id,
    //                        'upsrlm_call_type' => $upsrlm_call_type,
    //                        'call_reason_id' => $call_reason_id,
    //                        'call_priority' => $newcall->call_attempt != null ? $newcall->call_attempt : 0,
    //                        'call_attempt' => $newcall->call_attempt != null ? $newcall->call_attempt : 0,
    //                        'created_by' => $newcall->created_by != null ? $newcall->created_by : 0,
    //                        'updated_by' => $newcall->updated_by != null ? $newcall->updated_by : 0,
    //                        'status' => $newcall->status != null ? $newcall->status : 0,
    //                        'call_schedule_date' => $newcall->call_schedule_date != null ? $newcall->call_schedule_date : $call_schedule_date,
    //                    ]);
    //                    $newcall->save(false);
    //                    $rishtashgmember->sent_for_calling = 1; // Uncomment it later
    //                    $rishtashgmember->save(false);
    //                }
    //            }
    //        }
    //        // $this->actionDistributecalling();
    //    }

    public function actionNext() {
        $district_codes = [128]; // Data Will be generated for following Districts (Bahraich Chairepersion)
        $call_scenario_id = 1001; // User Verification Scneario
        $upsrlm_call_type = 1; // Outbound(CTC)
        $call_reason_id = 2; // Direct Call or New Call
        $call_schedule_date = date('Y-m-d'); // Date for Call Schedule

        foreach ($district_codes as $district_code) {
            $rishtashgmembers = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()
                            ->innerjoinwith('cboshg')
                            ->where(['district_code' => $district_code, 'sent_for_calling' => 0, 'mobile_callcenter_status' => 0, 'role' => [2], 'cbo_shg.wada_shg' => 1, 'cbo_shg.dummy_column' => 0])->andWhere("rishta_shg_member.`user_id` IS NULL")->all();
            if ($rishtashgmembers) {
                foreach ($rishtashgmembers as $rishtashgmember) {
                    $make_user = \common\models\CboMembers::find()->joinWith(['user'])->where([\common\models\CboMembers::getTableSchema()->fullName . '.cbo_type' => 1, \common\models\CboMembers::getTableSchema()->fullName . '.cbo_id' => $rishtashgmember->cbo_shg_id, \common\models\CboMembers::getTableSchema()->fullName . '.status' => 1, 'user.dummy_column' => 0])->andWhere([
                                'or',
                                [\common\models\CboMembers::getTableSchema()->fullName . '.shg_chairperson' => 1],
                                [\common\models\CboMembers::getTableSchema()->fullName . '.shg_secretary' => 1],
                                [\common\models\CboMembers::getTableSchema()->fullName . '.shg_treasurer' => 1],
                            ])->count();
                    $old_call = CloudTeleApiCall::find()->select(['id'])->where(['customernumber' => $rishtashgmember->mobile, 'upsrlm_connection_status' => 1])->count();
                    if ($make_user == 0 and $old_call == '0') {
                        $other_user = User::find()->where(['username' => $rishtashgmember->mobile])->count();
                        if ($other_user == '0' and preg_match('/^[6-9]\d{9}$/', $rishtashgmember->mobile)) {
                            $newcall = CallingList::find()
                                            ->where([
                                                'rishta_shg_member_id' => $rishtashgmember->id,
                                                'cbo_shg_id' => $rishtashgmember->cbo_shg_id,
                                                'default_call_scenario_id' => $call_scenario_id,
                                            ])->one();
                            if (!$newcall) {
                                $newcall = new CallingList();

                                $newcall->setAttributes([
                                    'rishta_shg_member_id' => $rishtashgmember->id,
                                    'cbo_shg_id' => $rishtashgmember->cbo_shg_id,
                                    'name_of_shg' => $rishtashgmember->cboshg->name_of_shg,
                                    'member_name' => $rishtashgmember->name,
                                    'member_mobile' => $rishtashgmember->mobile,
                                    'member_marital_status' => $rishtashgmember->marital_status,
                                    'member_age' => $rishtashgmember->age,
                                    'member_caste_category' => $rishtashgmember->caste_category,
                                    'member_duration_of_membership' => $rishtashgmember->duration_of_membership,
                                    'member_total_saving' => $rishtashgmember->total_saving,
                                    'member_loan' => $rishtashgmember->loan,
                                    'member_loan_count' => $rishtashgmember->loan_count,
                                    'member_loan_amount' => $rishtashgmember->loan_amount,
                                    'member_loan_date' => $rishtashgmember->loan_date,
                                    'member_mcp_status' => $rishtashgmember->mcp_status,
                                    'member_office_bearer' => $rishtashgmember->office_bearer,
                                    'member_role' => $rishtashgmember->role,
                                    'member_bank_account' => $rishtashgmember->bank_account,
                                    'member_relative_in_shg' => $rishtashgmember->relative_in_shg,
                                    'member_no_of_relative' => $rishtashgmember->no_of_relative,
                                    'member_current_member' => $rishtashgmember->current_member,
                                    'member_user_id' => $rishtashgmember->user_id,
                                    'member_suggest_wada_sakhi' => $rishtashgmember->suggest_wada_sakhi,
                                    'member_status' => $rishtashgmember->status,
                                    'member_district_code' => $rishtashgmember->cboshg->district_code,
                                    'member_district_name' => $rishtashgmember->cboshg->district_name,
                                    'member_block_code' => $rishtashgmember->cboshg->block_code,
                                    'member_block_name' => $rishtashgmember->cboshg->block_name,
                                    'member_gram_panchayat_code' => $rishtashgmember->cboshg->gram_panchayat_code,
                                    'member_gram_panchayat_name' => $rishtashgmember->cboshg->gram_panchayat_name,
                                    'member_village_code' => $rishtashgmember->cboshg->village_code,
                                    'member_village_name' => $rishtashgmember->cboshg->village_name,
                                    'member_village_name' => $rishtashgmember->cboshg->village_name,
                                    'member_wada_shg' => $rishtashgmember->cboshg->wada_shg,
                                    'customer_number' => $rishtashgmember->mobile,
                                    'call_generate_date' => date('Y-m-d'),
                                    'default_call_scenario_id' => $call_scenario_id,
                                    'upsrlm_call_type' => $upsrlm_call_type,
                                    'call_reason_id' => $call_reason_id,
                                    'call_priority' => $newcall->call_attempt != null ? $newcall->call_attempt : 0,
                                    'call_attempt' => $newcall->call_attempt != null ? $newcall->call_attempt : 0,
                                    'created_by' => $newcall->created_by != null ? $newcall->created_by : 0,
                                    'updated_by' => $newcall->updated_by != null ? $newcall->updated_by : 0,
                                    'status' => $newcall->status != null ? $newcall->status : 0,
                                    'call_schedule_date' => $newcall->call_schedule_date != null ? $newcall->call_schedule_date : $call_schedule_date,
                                ]);
                                $newcall->save(false);
                                $rishtashgmember->sent_for_calling = 1; // Uncomment it later
                                $rishtashgmember->save(false);
                            }
                        }
                    }
                }
            }
        }
        // $this->assignnewcalling();
    }

    /**
     * This Function Will Generate List for Calling If User Not Used App Yet
     *
     * @return void
     */
    public function actionUsernotusedappscneario() {
        $call_scenario_id = 1002; // User not used Rishta App
        $call_reason_id = 2; // Direct Call or New Call
        $upsrlm_call_type = 1; // Outbound(CTC)
        $call_schedule_date = date('Y-m-d', strtotime("+1 days")); // Date for Call Schedule

        $null = new \yii\db\Expression('NULL');
        $searchModel = new \common\models\wada\form\DashboardSearchForm([]);
        $searchModel1 = new \common\models\dynamicdb\cbo_detail\CboMembersSearch();
        $dataProvider = $searchModel1->search($searchModel, null, false);
        $dataProvider->query->andWhere([
            'or',
            ['=', 'shg_chairperson', 1],
            ['=', 'shg_secretary', 1],
            ['=', 'shg_treasurer', 1],
        ]);
        $dataProvider->query->joinWith(['user']);
        $dataProvider->query->andFilterWhere(['is', 'app_id', $null]);
        $dataProvider->query->andWhere([\common\models\User::getTableSchema()->fullName . '.dummy_column' => 0]);
        if ($searchModel->mobile_no != '') {
            $dataProvider->query->andWhere([\common\models\User::getTableSchema()->fullName . '.username' => $searchModel->mobile_no]);
        }
        if ($searchModel->district_code or $searchModel->block_code or $searchModel->gram_panchayat_code) {
            $dataProvider->query->joinWith(['shg']);
            if ($searchModel->district_code) {
                $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.district_code' => $searchModel->district_code]);
            }
            if ($searchModel->block_code) {
                $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.block_code' => $searchModel->block_code]);
            }
            if ($searchModel->gram_panchayat_code) {
                $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.gram_panchayat_code' => $searchModel->gram_panchayat_code]);
            }
        }

        if ($dataProvider->models) {
            foreach ($dataProvider->models as $usernotusedapp) {

                $rishtashgmember = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where([
                            'mobile' => $usernotusedapp->user->username,
                            'cbo_shg_id' => $usernotusedapp->cbo_id,
                            'user_id' => $usernotusedapp->user_id,
                        ])->one();
                if (!$rishtashgmember) {
                    continue;
                }
                $newcall = CallingList::find()
                                ->where([
                                    'rishta_shg_member_id' => $rishtashgmember->id,
                                    'cbo_shg_id' => $usernotusedapp->cbo_id,
                                    'member_user_id' => $usernotusedapp->user->id,
                                    'member_mobile' => $usernotusedapp->user->username,
                                    'default_call_scenario_id' => $call_scenario_id,
                                ])->one();
                if ($newcall) {
                    continue;
                }
                if (!$newcall) {
                    $newcall = new CallingList();
                }
                $newcall->setAttributes([
                    'rishta_shg_member_id' => $rishtashgmember->id,
                    'cbo_shg_id' => $usernotusedapp->cbo_id,
                    'name_of_shg' => (isset($usernotusedapp->cbo) and $usernotusedapp->cbo_type == \common\models\CboMembers::CBO_TYPE_SHG) ? $usernotusedapp->cbo->name_of_shg : '',
                    'member_name' => $usernotusedapp->user->name,
                    'member_mobile' => $usernotusedapp->user->username,
                    'member_marital_status' => $rishtashgmember->marital_status,
                    'member_age' => $rishtashgmember->age,
                    'member_caste_category' => $rishtashgmember->caste_category,
                    'member_duration_of_membership' => $rishtashgmember->duration_of_membership,
                    'member_total_saving' => $rishtashgmember->total_saving,
                    'member_loan' => $rishtashgmember->loan,
                    'member_loan_count' => $rishtashgmember->loan_count,
                    'member_loan_amount' => $rishtashgmember->loan_amount,
                    'member_loan_date' => $rishtashgmember->loan_date,
                    'member_mcp_status' => $rishtashgmember->mcp_status,
                    'member_office_bearer' => $rishtashgmember->office_bearer,
                    'member_role' => $rishtashgmember->role,
                    'member_bank_account' => $rishtashgmember->bank_account,
                    'member_relative_in_shg' => $rishtashgmember->relative_in_shg,
                    'member_no_of_relative' => $rishtashgmember->no_of_relative,
                    'member_current_member' => $rishtashgmember->current_member,
                    'member_user_id' => $rishtashgmember->user_id,
                    'member_suggest_wada_sakhi' => $rishtashgmember->suggest_wada_sakhi,
                    'member_status' => $rishtashgmember->status,
                    'member_district_code' => isset($usernotusedapp->shg) ? $usernotusedapp->shg->district_code : '',
                    'member_district_name' => isset($usernotusedapp->shg) ? $usernotusedapp->shg->district_name : '',
                    'member_block_code' => isset($usernotusedapp->shg) ? $usernotusedapp->shg->block_code : '',
                    'member_block_name' => isset($usernotusedapp->shg) ? $usernotusedapp->shg->block_name : '',
                    'member_gram_panchayat_code' => isset($usernotusedapp->shg) ? $usernotusedapp->shg->gram_panchayat_code : '',
                    'member_gram_panchayat_name' => isset($usernotusedapp->shg) ? $usernotusedapp->shg->gram_panchayat_name : '',
                    'member_village_code' => isset($usernotusedapp->shg) ? $usernotusedapp->shg->village_code : '',
                    'member_village_name' => isset($usernotusedapp->shg) ? $usernotusedapp->shg->village_name : '',
                    'member_wada_shg' => isset($usernotusedapp->shg) ? $usernotusedapp->shg->wada_shg : '',
                    'customer_number' => $usernotusedapp->user->username,
                    'call_generate_date' => date('Y-m-d'),
                    'default_call_scenario_id' => $call_scenario_id,
                    'upsrlm_call_type' => $upsrlm_call_type,
                    'call_reason_id' => $call_reason_id,
                    'call_priority' => $newcall->call_attempt != null ? $newcall->call_attempt : 0,
                    'call_attempt' => $newcall->call_attempt != null ? $newcall->call_attempt : 0,
                    'created_by' => $newcall->created_by != null ? $newcall->created_by : 0,
                    'updated_by' => $newcall->updated_by != null ? $newcall->updated_by : 0,
                    'status' => $newcall->status != null ? $newcall->status : 0,
                    'call_schedule_date' => $newcall->call_schedule_date != null ? $newcall->call_schedule_date : $call_schedule_date,
                ]);
                $newcall->save(false);
            }
        }
        // $this->actionDistributecalling(2, $call_scenario_id);
    }

    /**
     * Samuh Sakhi Not Nominated by Chairperson/Secretary/Treasurer
     *
     * @return void
     */
    public function actionNotnominatedsamuhsakhiscneario() {
        $call_scenario_id = 1003; // Samuh Sakhi Not Nominated by Chairperson/Secretary/Treasurer
        $call_reason_id = 2; // Direct Call or New Call
        $upsrlm_call_type = 1; // Outbound(CTC)
        $call_schedule_date = date('Y-m-d', strtotime("+1 days")); // Date for Call Schedule

        $null = new \yii\db\Expression('NULL');
        $searchModel = new \common\models\wada\form\DashboardSearchForm([]);
        $searchModel1 = new \common\models\dynamicdb\cbo_detail\CboMembersSearch();
        $dataProvider = $searchModel1->search($searchModel, null, false);
        $dataProvider->query->andWhere([
            'or',
            ['=', 'shg_chairperson', 1],
            ['=', 'shg_secretary', 1],
            ['=', 'shg_treasurer', 1],
        ]);
        $dataProvider->query->joinWith(['user']);
        $dataProvider->query->andFilterWhere(['is not', 'app_id', $null]);
        $dataProvider->query->andWhere([\common\models\User::getTableSchema()->fullName . '.dummy_column' => 0]);
        $dataProvider->query->joinWith(['shg']);
//        $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.suggest_samuh_sakhi' => 0]);
        if ($searchModel->mobile_no != '') {
            $dataProvider->query->andWhere([\common\models\User::getTableSchema()->fullName . '.username' => $searchModel->mobile_no]);
        }
        if ($searchModel->district_code or $searchModel->block_code or $searchModel->gram_panchayat_code) {

            if ($searchModel->district_code) {
                $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.district_code' => $searchModel->district_code]);
            }
            if ($searchModel->block_code) {
                $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.block_code' => $searchModel->block_code]);
            }
            if ($searchModel->gram_panchayat_code) {
                $dataProvider->query->andWhere([Shg::getTableSchema()->fullName . '.gram_panchayat_code' => $searchModel->gram_panchayat_code]);
            }
        }


        if ($dataProvider->models) {
            foreach ($dataProvider->models as $notnominatedsamuhsakhi) {
                $nominated = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $notnominatedsamuhsakhi->cbo_id, 'suggest_wada_sakhi' => 1])->count();
                if ($nominated == 0) {
                    $rishtashgmember = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where([
                                'mobile' => $notnominatedsamuhsakhi->user->username,
                                'cbo_shg_id' => $notnominatedsamuhsakhi->cbo_id,
                                'user_id' => $notnominatedsamuhsakhi->user_id,
                            ])->one();
                    if (!$rishtashgmember) {
                        continue;
                    }
                    $newcall = CallingList::find()
                                    ->where([
                                        'rishta_shg_member_id' => $rishtashgmember->id,
                                        'cbo_shg_id' => $notnominatedsamuhsakhi->cbo_id,
                                        'member_user_id' => $notnominatedsamuhsakhi->user->id,
                                        'member_mobile' => $notnominatedsamuhsakhi->user->username,
                                        'default_call_scenario_id' => $call_scenario_id,
                                    ])->one();
                    if ($newcall) {
                        continue;
                    }
                    if (!$newcall) {
                        $newcall = new CallingList();
                    }
                    $newcall->setAttributes([
                        'rishta_shg_member_id' => $rishtashgmember->id,
                        'cbo_shg_id' => $notnominatedsamuhsakhi->cbo_id,
                        'name_of_shg' => (isset($notnominatedsamuhsakhi->cbo) and $notnominatedsamuhsakhi->cbo_type == \common\models\CboMembers::CBO_TYPE_SHG) ? $notnominatedsamuhsakhi->cbo->name_of_shg : '',
                        'member_name' => $notnominatedsamuhsakhi->user->name,
                        'member_mobile' => $notnominatedsamuhsakhi->user->username,
                        'member_marital_status' => $rishtashgmember->marital_status,
                        'member_age' => $rishtashgmember->age,
                        'member_caste_category' => $rishtashgmember->caste_category,
                        'member_duration_of_membership' => $rishtashgmember->duration_of_membership,
                        'member_total_saving' => $rishtashgmember->total_saving,
                        'member_loan' => $rishtashgmember->loan,
                        'member_loan_count' => $rishtashgmember->loan_count,
                        'member_loan_amount' => $rishtashgmember->loan_amount,
                        'member_loan_date' => $rishtashgmember->loan_date,
                        'member_mcp_status' => $rishtashgmember->mcp_status,
                        'member_office_bearer' => $rishtashgmember->office_bearer,
                        'member_role' => $rishtashgmember->role,
                        'member_bank_account' => $rishtashgmember->bank_account,
                        'member_relative_in_shg' => $rishtashgmember->relative_in_shg,
                        'member_no_of_relative' => $rishtashgmember->no_of_relative,
                        'member_current_member' => $rishtashgmember->current_member,
                        'member_user_id' => $rishtashgmember->user_id,
                        'member_suggest_wada_sakhi' => $rishtashgmember->suggest_wada_sakhi,
                        'member_status' => $rishtashgmember->status,
                        'member_district_code' => isset($notnominatedsamuhsakhi->shg) ? $notnominatedsamuhsakhi->shg->district_code : '',
                        'member_district_name' => isset($notnominatedsamuhsakhi->shg) ? $notnominatedsamuhsakhi->shg->district_name : '',
                        'member_block_code' => isset($notnominatedsamuhsakhi->shg) ? $notnominatedsamuhsakhi->shg->block_code : '',
                        'member_block_name' => isset($notnominatedsamuhsakhi->shg) ? $notnominatedsamuhsakhi->shg->block_name : '',
                        'member_gram_panchayat_code' => isset($notnominatedsamuhsakhi->shg) ? $notnominatedsamuhsakhi->shg->gram_panchayat_code : '',
                        'member_gram_panchayat_name' => isset($notnominatedsamuhsakhi->shg) ? $notnominatedsamuhsakhi->shg->gram_panchayat_name : '',
                        'member_village_code' => isset($notnominatedsamuhsakhi->shg) ? $notnominatedsamuhsakhi->shg->village_code : '',
                        'member_village_name' => isset($notnominatedsamuhsakhi->shg) ? $notnominatedsamuhsakhi->shg->village_name : '',
                        'member_wada_shg' => isset($notnominatedsamuhsakhi->shg) ? $notnominatedsamuhsakhi->shg->wada_shg : '',
                        'customer_number' => $notnominatedsamuhsakhi->user->username,
                        'call_generate_date' => date('Y-m-d'),
                        'default_call_scenario_id' => $call_scenario_id,
                        'upsrlm_call_type' => $upsrlm_call_type,
                        'call_reason_id' => $call_reason_id,
                        'call_priority' => $newcall->call_attempt != null ? $newcall->call_attempt : 0,
                        'call_attempt' => $newcall->call_attempt != null ? $newcall->call_attempt : 0,
                        'created_by' => $newcall->created_by != null ? $newcall->created_by : 0,
                        'updated_by' => $newcall->updated_by != null ? $newcall->updated_by : 0,
                        'status' => $newcall->status != null ? $newcall->status : 0,
                        'call_schedule_date' => $newcall->call_schedule_date != null ? $newcall->call_schedule_date : $call_schedule_date,
                    ]);
                    $newcall->save(false);
                }
            }
        }
        // $this->actionDistributecalling(2, $call_scenario_id);
    }

    /**
     * Samuh Sakhi Not used Rishta APP
     *
     * @return void
     */
    public function actionSamuhsakhinotusedrishtaappscneario() {
        $call_scenario_id = 1004; // Samuh Sakhi Not used Rishta APP
        $call_reason_id = 2; // Direct Call or New Call
        $upsrlm_call_type = 1; // Outbound(CTC)
        $call_schedule_date = date('Y-m-d', strtotime("+1 days")); // Date for Call Schedule

        $null = new \yii\db\Expression('NULL');
        $searchModel = new \common\models\wada\form\DashboardSearchForm([]);
        $searchModel1 = new \common\models\dynamicdb\cbo_detail\CboMembersSearch();
        $dataProvider = $searchModel1->search($searchModel, null, false);
        $dataProvider->query->andWhere(['suggest_wada_sakhi' => 1]);

        $dataProvider->query->joinWith(['user']);
        $dataProvider->query->andWhere("`app_id` IS NULL");
        $dataProvider->query->andWhere([\common\models\User::getTableSchema()->fullName . '.dummy_column' => 0]);

        if ($dataProvider->models) {
            foreach ($dataProvider->models as $cbomember) {

                $rishtashgmember = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where([
                            'mobile' => $cbomember->user->username,
                            'cbo_shg_id' => $cbomember->cbo_id,
                            'user_id' => $cbomember->user_id,
                        ])->one();
                if (!$rishtashgmember) {
                    continue;
                }
                $newcall = CallingList::find()
                                ->where([
                                    'rishta_shg_member_id' => $rishtashgmember->id,
                                    'default_call_scenario_id' => $call_scenario_id,
                                ])->one();
                if ($newcall) {
                    continue;
                }
                if (!$newcall) {
                    $newcall = new CallingList();
                }
                $newcall->setAttributes([
                    'rishta_shg_member_id' => $rishtashgmember->id,
                    'cbo_shg_id' => $cbomember->cbo_id,
                    'name_of_shg' => (isset($cbomember->cbo) and $cbomember->cbo_type == \common\models\CboMembers::CBO_TYPE_SHG) ? $cbomember->cbo->name_of_shg : '',
                    'member_name' => $cbomember->user->name,
                    'member_mobile' => $cbomember->user->username,
                    'member_marital_status' => $rishtashgmember->marital_status,
                    'member_age' => $rishtashgmember->age,
                    'member_caste_category' => $rishtashgmember->caste_category,
                    'member_duration_of_membership' => $rishtashgmember->duration_of_membership,
                    'member_total_saving' => $rishtashgmember->total_saving,
                    'member_loan' => $rishtashgmember->loan,
                    'member_loan_count' => $rishtashgmember->loan_count,
                    'member_loan_amount' => $rishtashgmember->loan_amount,
                    'member_loan_date' => $rishtashgmember->loan_date,
                    'member_mcp_status' => $rishtashgmember->mcp_status,
                    'member_office_bearer' => $rishtashgmember->office_bearer,
                    'member_role' => $rishtashgmember->role,
                    'member_bank_account' => $rishtashgmember->bank_account,
                    'member_relative_in_shg' => $rishtashgmember->relative_in_shg,
                    'member_no_of_relative' => $rishtashgmember->no_of_relative,
                    'member_current_member' => $rishtashgmember->current_member,
                    'member_user_id' => $rishtashgmember->user_id,
                    'member_suggest_wada_sakhi' => $rishtashgmember->suggest_wada_sakhi,
                    'member_status' => $rishtashgmember->status,
                    'member_district_code' => isset($cbomember->shg) ? $cbomember->shg->district_code : '',
                    'member_district_name' => isset($cbomember->shg) ? $cbomember->shg->district_name : '',
                    'member_block_code' => isset($cbomember->shg) ? $cbomember->shg->block_code : '',
                    'member_block_name' => isset($cbomember->shg) ? $cbomember->shg->block_name : '',
                    'member_gram_panchayat_code' => isset($cbomember->shg) ? $cbomember->shg->gram_panchayat_code : '',
                    'member_gram_panchayat_name' => isset($cbomember->shg) ? $cbomember->shg->gram_panchayat_name : '',
                    'member_village_code' => isset($cbomember->shg) ? $cbomember->shg->village_code : '',
                    'member_village_name' => isset($cbomember->shg) ? $cbomember->shg->village_name : '',
                    'member_wada_shg' => isset($cbomember->shg) ? $cbomember->shg->wada_shg : '',
                    'customer_number' => $cbomember->user->username,
                    'call_generate_date' => date('Y-m-d'),
                    'default_call_scenario_id' => $call_scenario_id,
                    'upsrlm_call_type' => $upsrlm_call_type,
                    'call_reason_id' => $call_reason_id,
                    'call_priority' => $newcall->call_attempt != null ? $newcall->call_attempt : 0,
                    'call_attempt' => $newcall->call_attempt != null ? $newcall->call_attempt : 0,
                    'created_by' => $newcall->created_by != null ? $newcall->created_by : 0,
                    'updated_by' => $newcall->updated_by != null ? $newcall->updated_by : 0,
                    'status' => $newcall->status != null ? $newcall->status : 0,
                    'call_schedule_date' => $newcall->call_schedule_date != null ? $newcall->call_schedule_date : $call_schedule_date,
                ]);
                $newcall->save(false);
            }
        }
        // $this->actionDistributecalling(2, $call_scenario_id);
    }

    /**
     * Samuh Sakhi Not fill form in Rishta APP
     *
     * @return void
     */
    public function actionSamuhsakhinotfillformscneario() {
        $call_scenario_id = 1005; // Samuh Sakhi Not fill form in Rishta APP
        $call_reason_id = 2; // Direct Call or New Call
        $upsrlm_call_type = 1; // Outbound(CTC)
        $call_schedule_date = date('Y-m-d', strtotime("+1 days")); // Date for Call Schedule

        $null = new \yii\db\Expression('NULL');
        $searchModel = new \common\models\wada\form\DashboardSearchForm([]);
        $searchModel1 = new \common\models\dynamicdb\cbo_detail\CboMembersSearch();
        $dataProvider = $searchModel1->search($searchModel, null, false);
        $dataProvider->query->andWhere(['suggest_wada_sakhi' => 1]);

        $dataProvider->query->joinWith(['user']);
        $dataProvider->query->andWhere("`app_id` IS NOT NULL");
        $dataProvider->query->andWhere([\common\models\User::getTableSchema()->fullName . '.dummy_column' => 0]);

        if ($dataProvider->models) {
            foreach ($dataProvider->models as $cbomember) {

                $wadapplication = \common\models\wada\WadaApplication::find()->where([
                            'cbo_shg_id' => $cbomember->cbo_id,
                            'user_id' => $cbomember->user_id
                        ])->andWhere("`status`=2")
                        ->one();

                if ($wadapplication) {
                    continue;
                }

                $rishtashgmember = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where([
                            'mobile' => $cbomember->user->username,
                            'cbo_shg_id' => $cbomember->cbo_id,
                            'user_id' => $cbomember->user_id,
                        ])->one();
                if (!$rishtashgmember) {
                    continue;
                }
                $newcall = CallingList::find()
                                ->where([
                                    'rishta_shg_member_id' => $rishtashgmember->id,
                                    'default_call_scenario_id' => $call_scenario_id,
                                ])->one();
                if ($newcall) {
                    continue;
                }
                if (!$newcall) {
                    $newcall = new CallingList();
                }
                $newcall->setAttributes([
                    'rishta_shg_member_id' => $rishtashgmember->id,
                    'cbo_shg_id' => $cbomember->cbo_id,
                    'name_of_shg' => (isset($cbomember->cbo) and $cbomember->cbo_type == \common\models\CboMembers::CBO_TYPE_SHG) ? $cbomember->cbo->name_of_shg : '',
                    'member_name' => $cbomember->user->name,
                    'member_mobile' => $cbomember->user->username,
                    'member_marital_status' => $rishtashgmember->marital_status,
                    'member_age' => $rishtashgmember->age,
                    'member_caste_category' => $rishtashgmember->caste_category,
                    'member_duration_of_membership' => $rishtashgmember->duration_of_membership,
                    'member_total_saving' => $rishtashgmember->total_saving,
                    'member_loan' => $rishtashgmember->loan,
                    'member_loan_count' => $rishtashgmember->loan_count,
                    'member_loan_amount' => $rishtashgmember->loan_amount,
                    'member_loan_date' => $rishtashgmember->loan_date,
                    'member_mcp_status' => $rishtashgmember->mcp_status,
                    'member_office_bearer' => $rishtashgmember->office_bearer,
                    'member_role' => $rishtashgmember->role,
                    'member_bank_account' => $rishtashgmember->bank_account,
                    'member_relative_in_shg' => $rishtashgmember->relative_in_shg,
                    'member_no_of_relative' => $rishtashgmember->no_of_relative,
                    'member_current_member' => $rishtashgmember->current_member,
                    'member_user_id' => $rishtashgmember->user_id,
                    'member_suggest_wada_sakhi' => $rishtashgmember->suggest_wada_sakhi,
                    'member_status' => $rishtashgmember->status,
                    'member_district_code' => isset($cbomember->shg) ? $cbomember->shg->district_code : '',
                    'member_district_name' => isset($cbomember->shg) ? $cbomember->shg->district_name : '',
                    'member_block_code' => isset($cbomember->shg) ? $cbomember->shg->block_code : '',
                    'member_block_name' => isset($cbomember->shg) ? $cbomember->shg->block_name : '',
                    'member_gram_panchayat_code' => isset($cbomember->shg) ? $cbomember->shg->gram_panchayat_code : '',
                    'member_gram_panchayat_name' => isset($cbomember->shg) ? $cbomember->shg->gram_panchayat_name : '',
                    'member_village_code' => isset($cbomember->shg) ? $cbomember->shg->village_code : '',
                    'member_village_name' => isset($cbomember->shg) ? $cbomember->shg->village_name : '',
                    'member_wada_shg' => isset($cbomember->shg) ? $cbomember->shg->wada_shg : '',
                    'customer_number' => $cbomember->user->username,
                    'call_generate_date' => date('Y-m-d'),
                    'default_call_scenario_id' => $call_scenario_id,
                    'upsrlm_call_type' => $upsrlm_call_type,
                    'call_reason_id' => $call_reason_id,
                    'call_priority' => $newcall->call_attempt != null ? $newcall->call_attempt : 0,
                    'call_attempt' => $newcall->call_attempt != null ? $newcall->call_attempt : 0,
                    'created_by' => $newcall->created_by != null ? $newcall->created_by : 0,
                    'updated_by' => $newcall->updated_by != null ? $newcall->updated_by : 0,
                    'status' => $newcall->status != null ? $newcall->status : 0,
                    'call_schedule_date' => $newcall->call_schedule_date != null ? $newcall->call_schedule_date : $call_schedule_date,
                ]);
                $newcall->save(false);
            }
        }
        // $this->actionDistributecalling(2, $call_scenario_id);
    }

    /**
     * Distribute Calling Data
     * $group 1= internal 
     * $group 2= dbt
     * $group 3= BOTH (Internal and DBT)
     * 
     * $scneario = 1001 //User Verification
     * $scneario = 1002 //User Not Install App
     * $scneario = 1003 //Samuh Sakhi Not Nominated by Chairperson/Secretary/Treasurer
     * 
     * @return void
     */
    public function actionDistributecalling($group, $scneario) {
        $null = new \yii\db\Expression('NULL');
        $outbounduser = \common\models\dynamicdb\internalcallcenter\platform\CallingUserInbound::find()->select('user_id')->where(['status' => 1, 'outbound' => 1])->column();
        $group3 = \common\models\dynamicdb\internalcallcenter\platform\CallingUserInbound::find()->select('user_id')->where(['status' => 1, 'outbound' => 1, 'user_group' => 3])->column();
//       print_r($outbounduser);
//        print_r($group3);exit;
        try {
            $searchModel = new UserSearch();
            $searchModel->saheli = 1;
            if ($group != null) {
                if ($group == 1) {
                    $searchModel->role = [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE];
                } else if ($group == 2) {
                    $searchModel->role = [MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE];
                } else if ($group == 3) {
                    $searchModel->role = [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE];
                }
            } else {
                $searchModel->role = [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE];
            }

            $searchModel->status = User::STATUS_ACTIVE;
            $dataProvider = $searchModel->search($searchModel, null, false);
            $dataProvider->query->andWhere(['id' => $outbounduser]);
            if ($scneario == 1001) {
                $dataProvider->query->andWhere(['not', ['id' => $group3]]);
            } else if ($scneario == 1002) {
                //$dataProvider->query->andWhere(['not', ['id' => $group3]]);
                $dataProvider->query->andWhere(['id' => $group3]);
            } else if ($scneario == 1003) {
                $dataProvider->query->andWhere(['id' => $group3]);
            } else if ($scneario == 1004) {
                $dataProvider->query->andWhere(['id' => $group3]);
            } else if ($scneario == 1005) {
                $dataProvider->query->andWhere(['id' => $group3]);
            }
            $users = $dataProvider->models;
            $user_count = $dataProvider->totalcount;
            $callingdatasquery = CallingList::find()->where(['status' => 0, 'agent_call_received' => 0, 'call_priority' => 0])->andFilterWhere(['is', 'call_schedule_time', $null])->andWhere("`upsrlm_call_type` !=2");
            if ($scneario == 1001) {
                if (in_array($group, [1])) {
                    $callingdatasquery->andWhere(['member_district_code' => 118, 'member_role' => [2, 3]]);
                    $callingdatasquery->orWhere(['member_district_code' => 187, 'member_role' => [1, 2, 3]]); // varan
                    $callingdatasquery->orWhere(['member_district_code' => 185, 'member_role' => [1, 2]]); // Sultanpur
                }
                if (in_array($group, [2])) {
                    $callingdatasquery->andWhere(['member_district_code' => 119, 'member_role' => [1, 2, 3]]); // aligarh sectory
                    $callingdatasquery->orWhere(['member_district_code' => 121, 'member_role' => [1, 2, 3]]); // Agra
                    $callingdatasquery->orWhere(['member_district_code' => 125, 'member_role' => [1, 2, 3]]); // Bahraich
                    $callingdatasquery->orWhere(['member_district_code' => 128, 'member_role' => [1, 2]]); // Banda ditrict
                }
            }
            if ($scneario != null) {
                if ($scneario == '1001') {
                    $callingdatasquery->andFilterWhere(['is', 'member_user_id', $null]);
                }
                $callingdatasquery->andWhere(['default_call_scenario_id' => $scneario]);
            }
            $callingdatas = $callingdatasquery->all();
            $count = 1;
            foreach ($callingdatas as $calling_data) {
                if ($scneario == '1001') {
                    $user = User::findOne(['username' => $calling_data->customer_number]);
                    if ($user != null) {
                        continue;
                    }
                }
                for ($i = 0; $i < $user_count; $i++) {
                    if ($count % $user_count == $i) {
                        $calling_data->calling_agent_id = $users[$i]->id;
                        if ($users[$i]->role == MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE) {
                            $calling_data->caller_group_id = 1;
                        } elseif ($users[$i]->role == MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE) {
                            $calling_data->caller_group_id = 2;
                        }
                        $calling_data->save(false);
                    }
                }
                $count++;
            }
        } catch (\Exception $ex) {
            print_r($ex->getMessage());
        }
        // $this->actionUnassignedoutbounduser();
    }

    /**
     * Re Arrange Data In Case Outbound User Chnage
     *
     * @return void
     */
  

    /**
     * Unassigned Data in Case no active outbound user available
     *
     * @return void
     */
    public function actionUnassignedoutbounduser() {
        $outbounduser = \common\models\dynamicdb\internalcallcenter\platform\CallingUserInbound::find()->select('user_id')->where(['status' => 1, 'outbound' => 1])->column();
        if (!$outbounduser) {

            CallingList::updateAll(['calling_agent_id' => NULL, 'caller_group_id' => NULL], ['status' => 0, 'agent_call_received' => 0, 'calling_agent_id' => $outbounduser]);
        }
    }

    // public function assignnewcalling()
    // {
    //     $outbounduser = \common\models\dynamicdb\internalcallcenter\platform\CallingUserInbound::find()->select('username')->where(['status' => 1, 'outbound' => 1])->column();
    //     $call_schedule_date = date('Y-m-d');
    //     try {
    //         $searchModel = new UserSearch();
    //         $searchModel->saheli = 1;
    //         $searchModel->role = [MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE, MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE];
    //         $searchModel->status = User::STATUS_ACTIVE;
    //         $dataProvider = $searchModel->search($searchModel, null, false);
    //         $dataProvider->query->andWhere(['username' => $outbounduser]);
    //         $users = $dataProvider->models;
    //         $user_count = $dataProvider->totalcount;
    //         $callingdatas = CallingList::find()->where(['status' => 0])->andWhere(['call_schedule_date' => $call_schedule_date])->all();
    //         $count = 1;
    //         foreach ($callingdatas as $calling_data) {
    //             for ($i = 0; $i < $user_count; $i++) {
    //                 if ($count % $user_count == $i) {
    //                     $calling_data->calling_agent_id = $users[$i]->id;
    //                     if ($users[$i]->role == MasterRole::ROLE_INTERNAL_CALL_CENTER_EXECUTIVE) {
    //                         $calling_data->caller_group_id = 1;
    //                     } elseif ($users[$i]->role == MasterRole::ROLE_DBT_CALL_CENTER_EXECUTIVE) {
    //                         $calling_data->caller_group_id = 2;
    //                     }
    //                     $calling_data->save(false);
    //                 }
    //             }
    //             $count++;
    //         }
    //     } catch (\Exception $ex) {
    //         print_r($ex->getMessage());
    //     }
    // }
//    public function actionDistrictcallinglist() {
//        $work_on_district = [185, 186, 187, 119, 121, 640];
//        $call_scenario_id = 1001; // User Verification Scneario
//        $call_reason_id = 2; // Direct Call or New Call
//        $call_schedule_date = date('Y-m-d'); // Date for Call Schedule
//        foreach ($work_on_district as $district_code) {
//            $rishtashgmembers = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()
//                            ->innerjoinwith('cboshg')
//                            ->where(['district_code' => $district_code, 'sent_for_calling' => 0, 'role' => [1, 2, 3], 'cbo_shg.wada_shg' => 1, 'cbo_shg.dummy_column' => 0, 'mobile_callcenter_status' => 0])->all();
//            foreach ($rishtashgmembers as $rishtashgmember) {
//                if (preg_match('/^[6-9]\d{9}$/', $rishtashgmember->mobile)) {
//                    $old_call = CloudTeleApiCall::find()->select(['id'])->where(['customernumber' => $rishtashgmember->mobile, 'upsrlm_connection_status' => 1, 'upsrlm_call_status' => 10])->count();
//                    if ($old_call == '0') {
//                        $newcall = CallingList::find()->where(['rishta_shg_member_id' => $rishtashgmember->id, 'default_call_scenario_id' => 1001])->one();
//                        if ($newcall == null) {
//                            $newcall = new CallingList();
//                            $newcall->setAttributes([
//                                'rishta_shg_member_id' => $rishtashgmember->id,
//                                'cbo_shg_id' => $rishtashgmember->cbo_shg_id,
//                                'name_of_shg' => $rishtashgmember->cboshg->name_of_shg,
//                                'member_name' => $rishtashgmember->name,
//                                'member_mobile' => $rishtashgmember->mobile,
//                                'member_marital_status' => $rishtashgmember->marital_status,
//                                'member_age' => $rishtashgmember->age,
//                                'member_caste_category' => $rishtashgmember->caste_category,
//                                'member_duration_of_membership' => $rishtashgmember->duration_of_membership,
//                                'member_total_saving' => $rishtashgmember->total_saving,
//                                'member_loan' => $rishtashgmember->loan,
//                                'member_loan_count' => $rishtashgmember->loan_count,
//                                'member_loan_amount' => $rishtashgmember->loan_amount,
//                                'member_loan_date' => $rishtashgmember->loan_date,
//                                'member_mcp_status' => $rishtashgmember->mcp_status,
//                                'member_office_bearer' => $rishtashgmember->office_bearer,
//                                'member_role' => $rishtashgmember->role,
//                                'member_bank_account' => $rishtashgmember->bank_account,
//                                'member_relative_in_shg' => $rishtashgmember->relative_in_shg,
//                                'member_no_of_relative' => $rishtashgmember->no_of_relative,
//                                'member_current_member' => $rishtashgmember->current_member,
//                                'member_user_id' => $rishtashgmember->user_id,
//                                'member_suggest_wada_sakhi' => $rishtashgmember->suggest_wada_sakhi,
//                                'member_status' => $rishtashgmember->status,
//                                'member_district_code' => $rishtashgmember->cboshg->district_code,
//                                'member_district_name' => $rishtashgmember->cboshg->district_name,
//                                'member_block_code' => $rishtashgmember->cboshg->block_code,
//                                'member_block_name' => $rishtashgmember->cboshg->block_name,
//                                'member_gram_panchayat_code' => $rishtashgmember->cboshg->gram_panchayat_code,
//                                'member_gram_panchayat_name' => $rishtashgmember->cboshg->gram_panchayat_name,
//                                'member_village_code' => $rishtashgmember->cboshg->village_code,
//                                'member_village_name' => $rishtashgmember->cboshg->village_name,
//                                'member_village_name' => $rishtashgmember->cboshg->village_name,
//                                'member_wada_shg' => $rishtashgmember->cboshg->wada_shg,
//                                'customer_number' => $rishtashgmember->mobile,
//                                'call_generate_date' => date('Y-m-d'),
//                                'default_call_scenario_id' => $call_scenario_id,
//                                'call_reason_id' => $call_reason_id,
//                                'call_priority' => $newcall->call_attempt != null ? $newcall->call_attempt : 0,
//                                'call_attempt' => $newcall->call_attempt != null ? $newcall->call_attempt : 0,
//                                'created_by' => $newcall->created_by != null ? $newcall->created_by : 0,
//                                'updated_by' => $newcall->updated_by != null ? $newcall->updated_by : 0,
//                                'status' => $rishtashgmember->user_id != null ? 1 : 0,
//                                'call_schedule_date' => $newcall->call_schedule_date != null ? $newcall->call_schedule_date : $call_schedule_date,
//                            ]);
//                            $newcall->save(false);
//                            $rishtashgmember->sent_for_calling = 1;
//                            $rishtashgmember->save(false);
//                        }
//                    }
//                }
//            }
//        }
//    }

    //    public function actionInternallog() {
    //        $this->interchairpersion();
    ////        $this->intersec();
    ////        $this->intertre();
    //    }
    //
    //    public function interchairpersion()
    //    {
    //        $call_logs = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::find()->where(['upsrlm_call_scenario' => 300])->groupBy('customernumber')->orderBy('api_request_datetime asc')->all();
    //        $total_count = 0;
    //        $calling_count_update = 0;
    //        $no_not_exist_count = 0;
    //        $insert_count = 0;
    //        $not_insert_count = 0;
    //        foreach ($call_logs as $call) {
    //            $call_latest = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::find()->where(['upsrlm_call_scenario' => 300, 'customernumber' => $call->customernumber])->orderBy('api_request_datetime desc')->one();
    //            $call_atempt = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::find()->where(['upsrlm_call_scenario' => 300, 'customernumber' => $call->customernumber])->count();
    //            $calling = CallingList::find()->where(['customer_number' => $call->customernumber, 'cbo_shg_id' => $call->cbo_shg_id, 'member_role' => 1])->one();
    //            if (isset($calling) and $calling->call_attempt == '0') {
    //                $callings = $this->updatecallinglist($call, $calling, $call_latest, $call_atempt);
    //                $this->updatecallinglistid($calling, $call_latest);
    //                $old_call_senario = \common\models\dynamicdb\cbo_detail\RishtaShgMemberVerificationFormLog::find()->where(['cbo_shg_id' => $call->cbo_shg_id, 'mobile_no' => $call->customernumber, 'designation' => 1])->andWhere(['!=', 'call_log_id', 0])->orderBy('id desc')->limit(1)->one();
    //                if ($old_call_senario != null) {
    //                    $user_verification_model = new \common\models\dynamicdb\internalcallcenter\platform\CallingScenarioUserVerification();
    //                    $user_verification_model->calling_id = $calling->id;
    //                    $user_verification_model->calling_agent_id = $calling->calling_agent_id;
    //                    $user_verification_model->caller_group_id = $calling->caller_group_id;
    //                    $user_verification_model->rishta_shg_member_id = $calling->rishta_shg_member_id;
    //                    $user_verification_model->cbo_shg_id = $calling->cbo_shg_id;
    //                    $user_verification_model->member_mobile = $calling->customer_number;
    //                    $user_verification_model->member_role = $calling->member_role;
    //                    $user_verification_model->member_name = $calling->member_name;
    //                    $user_verification_model->shg_name_and_other_verify = $old_call_senario->verify_ques1;
    //                    $user_verification_model->smart_phone = $old_call_senario->verify_ques2;
    //                    $user_verification_model->agree_download_rishta_app = $old_call_senario->verify_ques3;
    //                    $user_verification_model->user_id = $calling->member_user_id;
    //                    $user_verification_model->old = 1;
    //
    //                    if ($user_verification_model->save()) {
    //                        if ($old_call_senario->verify_ques1 and $old_call_senario->verify_ques2 and $old_call_senario->verify_ques3) {
    //                            $calling->status = 1;
    //                            $calling->call_complete_date = $call_latest->api_request_datetime;
    //                            $calling->save();
    //                        }
    //                        $insert_count++;
    //                    }
    //                } else {
    //                    $not_insert_count++;
    //                }
    //
    //                $calling_count_update++;
    //            } else {
    //                $no_not_exist_count++;
    //            }
    //            $total_count++;
    //        }
    //        echo "Total : " . $total_count . PHP_EOL;
    //        echo "Calling list update : " . $calling_count_update . PHP_EOL;
    //        echo "Number Not exist in calling list : " . $no_not_exist_count . PHP_EOL;
    //        echo "Insert in senarie table : " . $insert_count . PHP_EOL;
    //        echo "Not Insert in senarie table : " . $not_insert_count . PHP_EOL;
    //        return ExitCode::OK;
    //    }
    //
    //    public function intersec()
    //    {
    //        $call_logs = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::find()->where(['upsrlm_call_scenario' => [301]])->groupBy('customernumber')->orderBy('api_request_datetime asc')->all();
    //        $total_count = 0;
    //        $calling_count_update = 0;
    //        $no_not_exist_count = 0;
    //        $insert_count = 0;
    //        $not_insert_count = 0;
    //        foreach ($call_logs as $call) {
    //            $call_latest = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::find()->where(['upsrlm_call_scenario' => 301, 'customernumber' => $call->customernumber])->orderBy('api_request_datetime desc')->one();
    //            $call_atempt = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::find()->where(['upsrlm_call_scenario' => 301, 'customernumber' => $call->customernumber])->count();
    //            $calling = CallingList::find()->where(['customer_number' => $call->customernumber, 'cbo_shg_id' => $call->cbo_shg_id, 'member_role' => 2])->one();
    //            if (isset($calling) and $calling->call_attempt == '0') {
    //                $calling = $this->updatecallinglist($call, $calling, $call_latest, $call_atempt);
    //                $this->updatecallinglistid($calling, $call_latest);
    //                $old_call_senario = \common\models\dynamicdb\cbo_detail\RishtaShgMemberVerificationFormLog::find()->where(['cbo_shg_id' => $call->cbo_shg_id, 'mobile_no' => $call->customernumber, 'designation' => 2])->andWhere(['!=', 'call_log_id', 0])->orderBy('id desc')->limit(1)->one();
    //                if ($old_call_senario != null) {
    //                    $user_verification_model = new \common\models\dynamicdb\internalcallcenter\platform\CallingScenarioUserVerification();
    //                    $user_verification_model->calling_id = $calling->id;
    //                    $user_verification_model->calling_agent_id = $calling->calling_agent_id;
    //                    $user_verification_model->caller_group_id = $calling->caller_group_id;
    //                    $user_verification_model->rishta_shg_member_id = $calling->rishta_shg_member_id;
    //                    $user_verification_model->cbo_shg_id = $calling->cbo_shg_id;
    //                    $user_verification_model->member_mobile = $calling->customer_number;
    //                    $user_verification_model->member_role = $calling->member_role;
    //                    $user_verification_model->member_name = $calling->member_name;
    //                    $user_verification_model->shg_name_and_other_verify = $old_call_senario->verify_ques1;
    //                    $user_verification_model->smart_phone = $old_call_senario->verify_ques2;
    //                    $user_verification_model->agree_download_rishta_app = $old_call_senario->verify_ques3;
    //                    $user_verification_model->user_id = $calling->member_user_id;
    //                    $user_verification_model->old = $calling->old;
    //                    if ($user_verification_model->save()) {
    //                        if ($old_call_senario->verify_ques1 and $old_call_senario->verify_ques2 and $old_call_senario->verify_ques3) {
    //                            $calling->status = 1;
    //                            $calling->call_complete_date = $call_latest->api_request_datetime;
    //                            $calling->save();
    //                        }
    //                        $insert_count++;
    //                    }
    //                } else {
    //                    $not_insert_count++;
    //                }
    //
    //                $calling_count_update++;
    //            } else {
    //                $no_not_exist_count++;
    //            }
    //            $total_count++;
    //        }
    //        echo "Total : " . $total_count . PHP_EOL;
    //        echo "Calling list update : " . $calling_count_update . PHP_EOL;
    //        echo "Number Not exist in calling list : " . $no_not_exist_count . PHP_EOL;
    //        echo "Insert in senarie table : " . $insert_count . PHP_EOL;
    //        echo "Not Insert in senarie table : " . $not_insert_count . PHP_EOL;
    //        return ExitCode::OK;
    //    }
    //
    //    public function intertre()
    //    {
    //        $call_logs = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::find()->where(['upsrlm_call_scenario' => [302]])->groupBy('customernumber')->orderBy('api_request_datetime asc')->all();
    //        $total_count = 0;
    //        $calling_count_update = 0;
    //        $no_not_exist_count = 0;
    //        $insert_count = 0;
    //        $not_insert_count = 0;
    //        foreach ($call_logs as $call) {
    //            $call_latest = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::find()->where(['upsrlm_call_scenario' => 302, 'customernumber' => $call->customernumber])->orderBy('api_request_datetime desc')->one();
    //            $call_atempt = \common\models\dynamicdb\internalcallcenter\CloudTeleApiLog::find()->where(['upsrlm_call_scenario' => 302, 'customernumber' => $call->customernumber])->count();
    //            $calling = CallingList::find()->where(['customer_number' => $call->customernumber, 'cbo_shg_id' => $call->cbo_shg_id, 'member_role' => 3])->one();
    //            if (isset($calling) and $calling->call_attempt == '0') {
    //                $calling = $this->updatecallinglist($call, $calling, $call_latest, $call_atempt);
    //                $this->updatecallinglistid($calling, $call_latest);
    //                $old_call_senario = \common\models\dynamicdb\cbo_detail\RishtaShgMemberVerificationFormLog::find()->where(['cbo_shg_id' => $call->cbo_shg_id, 'mobile_no' => $call->customernumber, 'designation' => 3])->andWhere(['!=', 'call_log_id', 0])->orderBy('id desc')->limit(1)->one();
    //                if ($old_call_senario != null) {
    //                    $user_verification_model = new \common\models\dynamicdb\internalcallcenter\platform\CallingScenarioUserVerification();
    //                    $user_verification_model->calling_id = $calling->id;
    //                    $user_verification_model->calling_agent_id = $calling->calling_agent_id;
    //                    $user_verification_model->caller_group_id = $calling->caller_group_id;
    //                    $user_verification_model->rishta_shg_member_id = $calling->rishta_shg_member_id;
    //                    $user_verification_model->cbo_shg_id = $calling->cbo_shg_id;
    //                    $user_verification_model->member_mobile = $calling->customer_number;
    //                    $user_verification_model->member_role = $calling->member_role;
    //                    $user_verification_model->member_name = $calling->member_name;
    //                    $user_verification_model->shg_name_and_other_verify = $old_call_senario->verify_ques1;
    //                    $user_verification_model->smart_phone = $old_call_senario->verify_ques2;
    //                    $user_verification_model->agree_download_rishta_app = $old_call_senario->verify_ques3;
    //                    $user_verification_model->user_id = $calling->member_user_id;
    //                    $user_verification_model->old = $calling->old;
    //                    if ($user_verification_model->save()) {
    //                        if ($old_call_senario->verify_ques1 and $old_call_senario->verify_ques2 and $old_call_senario->verify_ques3) {
    //                            $calling->status = 1;
    //                            $calling->call_complete_date = $call_latest->api_request_datetime;
    //                            $calling->save();
    //                        }
    //                        $insert_count++;
    //                    }
    //                } else {
    //                    $not_insert_count++;
    //                }
    //
    //                $calling_count_update++;
    //            } else {
    //                $no_not_exist_count++;
    //            }
    //            $total_count++;
    //        }
    //        echo "Total : " . $total_count . PHP_EOL;
    //        echo "Calling list update : " . $calling_count_update . PHP_EOL;
    //        echo "Number Not exist in calling list : " . $no_not_exist_count . PHP_EOL;
    //        echo "Insert in senarie table : " . $insert_count . PHP_EOL;
    //        echo "Not Insert in senarie table : " . $not_insert_count . PHP_EOL;
    //        return ExitCode::OK;
    //    }
    //
    //    public function updatecallinglist($call, $calling, $call_latest, $call_atempt)
    //    {
    //        $calling->calling_agent_number = $call->upsrlm_user_mobile_no;
    //        $calling->calling_agent_id = $call->upsrlm_user_id;
    //        $calling->caller_group_id = 1;
    //        $calling->connection_status = $call_latest->upsrlm_connection_status;
    //        $calling->call_status = $call_latest->upsrlm_call_status;
    //        if ($call_latest->upsrlm_connection_status) {
    //            $calling->agent_call_received = 1;
    //        }
    //        $calling->call_start_time = $call_latest->ivrSTime;
    //        $calling->call_end_time = $call_latest->ivrETime;
    //        $calling->call_end_time = $call_latest->ivrETime;
    //        $calling->call_duration = $call_latest->ivrDuration;
    //        $calling->api_call_log_id = $call_latest->id;
    //        $calling->callid = $call_latest->callid;
    //        $calling->call_attempt = $call_atempt;
    //        $calling->ctc_click_count = $call_atempt;
    //        return $calling->save();
    //    }
    //
    //    public function updatecallinglistid($calling, $call_latest) {
    //        if (isset($calling) and isset($call_latest)) {
    //            $call_latest->calling_list_id = $calling->id;
    //            $call_latest->save();
    //        }
    //    }

    /**
     * Generate Data for Daily basis for agent all progress : in Params Pass Number of Days 
     *
     * @return void
     */
    public function actionGenerateagentprogress($days = null) {
        if (isset($days) && $days > 1) {
            $start_date = date('Y-m-d', strtotime('-' . $days . ' day', strtotime(date("Y-m-d"))));
            $end_date = date('Y-m-d');
        } else {
            $start_date = date('Y-m-d', strtotime('-1 day', strtotime(date("Y-m-d"))));
            $end_date = date('Y-m-d');
        }
        $upsrlm_call_type = 1; //CTC
        $begin = new \DateTime($start_date);
        $end = new \DateTime($end_date);
        $end = $end->modify('+1 day');
        $interval = new \DateInterval('P1D');
        $alldates = new \DatePeriod($begin, $interval, $end);
        foreach ($alldates as $calls_date) {
            $api_request_datetime = $calls_date->format('Y-m-d');

            $query = \common\models\dynamicdb\internalcallcenter\CloudTeleApiCall::find();
            $query->andWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')]);
            $query->andWhere(['upsrlm_call_type' => $upsrlm_call_type, 'project_id' => 1]);
            $query->select('upsrlm_user_id,upsrlm_user_role');
            $agentids = $query->distinct()->all();

            if ($agentids) {
                foreach ($agentids as $calling_agent) {
                    if (!$calling_agent->upsrlm_user_id) {
                        continue;
                    }

                    $progress = \common\models\dynamicdb\internalcallcenter\platform\CallingAgentProgress::find()->where(['calling_agent_id' => $calling_agent->upsrlm_user_id, 'calling_date' => $api_request_datetime])->one();
                    if (!$progress) {
                        $progress = new \common\models\dynamicdb\internalcallcenter\platform\CallingAgentProgress();
                    }

                    $start_time = NULL;
                    $first = CloudTeleApiCall::find()->select(['api_request_datetime'])->where(['project_id' => 1,'upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->orderBy(['api_request_datetime' => SORT_ASC])->limit(1)->one();
                    if ($first) {
                        $start_time = $first->api_request_datetime;
                    }

                    $end_time = NULL;
                    $last = CloudTeleApiCall::find()->select(['api_request_datetime'])->where(['project_id' => 1,'upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->orderBy(['api_request_datetime' => SORT_DESC])->limit(1)->one();
                    if ($last) {
                        $end_time = $last->api_request_datetime;
                    }

                    $work_hour = 0;
                    if ($first && $last) {
                        $work_hour = round(abs(strtotime($end_time) - strtotime($start_time)), 0);
                    }

                    $ctc_click = CloudTeleApiCall::find()->select(['id'])->where(['project_id' => 1,'upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $agent_call_recived = CloudTeleApiCall::find()->select(['id'])->where(['project_id' => 1,'upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_call_type' => $upsrlm_call_type, 'upsrlm_agent_call_received' => 1])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $both_answered = CloudTeleApiCall::find()->select(['id'])->where(['project_id' => 1,'upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'callStatus' => 3, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $from_unanswered = CloudTeleApiCall::find()->select(['id'])->where(['project_id' => 1,'upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'callStatus' => 7, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $talk_duration = CloudTeleApiCall::find()->select(['id'])->where(['project_id' => 1,'project_id' => 1,'upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->sum('talkDuration');
                    $ivr_duration = CloudTeleApiCall::find()->select(['id'])->where(['project_id' => 1,'upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->sum('ivrDuration');

                    $upsrlm_connection_status1 = CloudTeleApiCall::find()->select(['id'])->where(['project_id' => 1,'upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_connection_status' => 1, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $upsrlm_connection_status21 = CloudTeleApiCall::find()->select(['id'])->where(['project_id' => 1,'upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_connection_status' => 21, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $upsrlm_connection_status22 = CloudTeleApiCall::find()->select(['id'])->where(['project_id' => 1,'upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_connection_status' => 22, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $upsrlm_connection_status23 = CloudTeleApiCall::find()->select(['id'])->where(['project_id' => 1,'upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_connection_status' => 23, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $upsrlm_connection_status24 = CloudTeleApiCall::find()->select(['id'])->where(['project_id' => 1,'upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_connection_status' => 24, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $upsrlm_connection_status30 = CloudTeleApiCall::find()->select(['id'])->where(['project_id' => 1,'upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_connection_status' => 30, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();

                    $progress->ctc_click = $ctc_click != null ? $ctc_click : 0;
                    $progress->agent_call_recived = $agent_call_recived != null ? $agent_call_recived : 0;
                    $progress->upsrlm_connection_status1 = $upsrlm_connection_status1 != null ? $upsrlm_connection_status1 : 0;
                    $progress->upsrlm_connection_status21 = $upsrlm_connection_status21 != null ? $upsrlm_connection_status21 : 0;
                    $progress->upsrlm_connection_status22 = $upsrlm_connection_status22 != null ? $upsrlm_connection_status22 : 0;
                    $progress->upsrlm_connection_status23 = $upsrlm_connection_status23 != null ? $upsrlm_connection_status23 : 0;
                    $progress->upsrlm_connection_status24 = $upsrlm_connection_status24 != null ? $upsrlm_connection_status24 : 0;
                    $progress->upsrlm_connection_status30 = $upsrlm_connection_status30 != null ? $upsrlm_connection_status30 : 0;
                    $progress->both_answered = $both_answered != null ? $both_answered : 0;
                    $progress->from_unanswered = $from_unanswered != null ? $from_unanswered : 0;
                    $progress->talk_duration = $talk_duration != null ? $talk_duration : 0;
                    $progress->ivr_duration = $ivr_duration != null ? $ivr_duration : 0;
                    $progress->calling_agent_id = $calling_agent->upsrlm_user_id;
                    $progress->calling_agent_role = $calling_agent->upsrlm_user_role;
                    $progress->calling_date = $api_request_datetime;
                    $progress->start_time = $start_time;
                    $progress->end_time = $end_time;
                    $progress->work_hour = $work_hour;
                    if (!$progress->save()) {
                        return $progress->errors;
                    }
                }
            }
        }
    }

    /**
     * Generate IBD Progress
     */
    public function actionGenerateagentprogressibd($days = null) {
        if (isset($days) && $days > 1) {
            $start_date = date('Y-m-d', strtotime('-' . $days . ' day', strtotime(date("Y-m-d"))));
            $end_date = date('Y-m-d');
        } else {
            $start_date = date('Y-m-d', strtotime('-1 day', strtotime(date("Y-m-d"))));
            $end_date = date('Y-m-d');
        }
        $upsrlm_call_type = 2; //IBD
        $begin = new \DateTime($start_date);
        $end = new \DateTime($end_date);
        $end = $end->modify('+1 day');
        $interval = new \DateInterval('P1D');
        $alldates = new \DatePeriod($begin, $interval, $end);
        foreach ($alldates as $calls_date) {
            $api_request_datetime = $calls_date->format('Y-m-d');

            $query = \common\models\dynamicdb\internalcallcenter\CloudTeleApiCall::find();
            $query->andWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')]);
            $query->andWhere(['upsrlm_call_type' => $upsrlm_call_type]);
            $query->select('upsrlm_user_id,upsrlm_user_role');
            $agentids = $query->distinct()->all();

            if ($agentids) {
                foreach ($agentids as $calling_agent) {
                    if (!$calling_agent->upsrlm_user_id) {
                        continue;
                    }

                    $progress = \common\models\dynamicdb\internalcallcenter\platform\CallingAgentProgressIbd::find()->where(['calling_agent_id' => $calling_agent->upsrlm_user_id, 'calling_date' => $api_request_datetime])->one();
                    if (!$progress) {
                        $progress = new \common\models\dynamicdb\internalcallcenter\platform\CallingAgentProgressIbd();
                    }

                    $start_time = NULL;
                    $first = CloudTeleApiCall::find()->select(['api_request_datetime'])->where(['upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->orderBy(['api_request_datetime' => SORT_ASC])->limit(1)->one();
                    if ($first) {
                        $start_time = $first->api_request_datetime;
                    }

                    $end_time = NULL;
                    $last = CloudTeleApiCall::find()->select(['api_request_datetime'])->where(['upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->orderBy(['api_request_datetime' => SORT_DESC])->limit(1)->one();
                    if ($last) {
                        $end_time = $last->api_request_datetime;
                    }

                    $work_hour = 0;
                    if ($first && $last) {
                        $work_hour = round(abs(strtotime($end_time) - strtotime($start_time)), 0);
                    }

                    $other_call = $registred_call = 0;
                    $ibd_call = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $ibd_calls = CloudTeleApiCall::find()->select(['id', 'customernumber'])->where(['upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->all();
                    if ($ibd_calls) {
                        foreach ($ibd_calls as $ibdcall) {
                            $member = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['mobile' => $ibdcall->customernumber, 'status' => 1])->one();
                            if ($member != null) {
                                $registred_call = $registred_call + 1;
                            } else {
                                $other_call = $other_call + 1;
                            }
                        }
                    }

                    $agent_call_recived = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_call_type' => $upsrlm_call_type, 'upsrlm_agent_call_received' => 1])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $both_answered = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'callStatus' => 3, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $from_unanswered = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'callStatus' => 7, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $talk_duration = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->sum('talkDuration');
                    $ivr_duration = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_user_id' => $calling_agent->upsrlm_user_id, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->sum('ivrDuration');

                    $progress->ibd_call = $ibd_call != null ? $ibd_call : 0;
                    $progress->other_call = $other_call;
                    $progress->registred_call = $registred_call;
                    $progress->agent_call_recived = $agent_call_recived != null ? $agent_call_recived : 0;
                    $progress->both_answered = $both_answered != null ? $both_answered : 0;
                    $progress->from_unanswered = $from_unanswered != null ? $from_unanswered : 0;
                    $progress->talk_duration = $talk_duration != null ? $talk_duration : 0;
                    $progress->ivr_duration = $ivr_duration != null ? $ivr_duration : 0;
                    $progress->calling_agent_id = $calling_agent->upsrlm_user_id;
                    $progress->calling_agent_role = $calling_agent->upsrlm_user_role;
                    $progress->calling_date = $api_request_datetime;
                    $progress->start_time = $start_time;
                    $progress->end_time = $end_time;
                    $progress->work_hour = $work_hour;
                    if (!$progress->save()) {
                        return $progress->errors;
                    }
                }
            }
        }
    }

    /**
     * Generate Scneario Progress
     */
    public function actionGeneratescnearioprogress($days = null) {
        if (isset($days) && $days > 1) {
            $start_date = date('Y-m-d', strtotime('-' . $days . ' day', strtotime(date("Y-m-d"))));
            $end_date = date('Y-m-d');
        } else {
            $start_date = date('Y-m-d', strtotime('-1 day', strtotime(date("Y-m-d"))));
            $end_date = date('Y-m-d');
        }
        $upsrlm_call_type = [1, 2]; //CTC & IBD
        $begin = new \DateTime($start_date);
        $end = new \DateTime($end_date);
        $end = $end->modify('+1 day');
        $interval = new \DateInterval('P1D');
        $alldates = new \DatePeriod($begin, $interval, $end);
        foreach ($alldates as $calls_date) {
            $api_request_datetime = $calls_date->format('Y-m-d');

            $query = \common\models\dynamicdb\internalcallcenter\CloudTeleApiCall::find();
            $query->andWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')]);
            $query->andWhere(['upsrlm_call_type' => $upsrlm_call_type]);
            $query->select('upsrlm_call_scenario');
            $scnearioids = $query->distinct()->all();

            if ($scnearioids) {
                foreach ($scnearioids as $calling_scneario) {
                    if (!$calling_scneario->upsrlm_call_scenario) {
                        continue;
                    }

                    $progress = \common\models\dynamicdb\internalcallcenter\platform\CallingScnearioProgress::find()->where(['call_scenario_id' => $calling_scneario->upsrlm_call_scenario, 'calling_date' => $api_request_datetime])->one();
                    if (!$progress) {
                        $progress = new \common\models\dynamicdb\internalcallcenter\platform\CallingScnearioProgress();
                    }

                    $start_time = NULL;
                    $first = CloudTeleApiCall::find()->select(['api_request_datetime'])->where(['upsrlm_call_scenario' => $calling_scneario->upsrlm_call_scenario, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->orderBy(['api_request_datetime' => SORT_ASC])->limit(1)->one();
                    if ($first) {
                        $start_time = $first->api_request_datetime;
                    }

                    $end_time = NULL;
                    $last = CloudTeleApiCall::find()->select(['api_request_datetime'])->where(['upsrlm_call_scenario' => $calling_scneario->upsrlm_call_scenario, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->orderBy(['api_request_datetime' => SORT_DESC])->limit(1)->one();
                    if ($last) {
                        $end_time = $last->api_request_datetime;
                    }

                    $work_hour = 0;
                    if ($first && $last) {
                        $work_hour = round(abs(strtotime($end_time) - strtotime($start_time)), 0);
                    }

                    $ctc_click = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_call_scenario' => $calling_scneario->upsrlm_call_scenario, 'upsrlm_call_type' => 1])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $ibd_call = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_call_scenario' => $calling_scneario->upsrlm_call_scenario, 'upsrlm_call_type' => 2])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $agent_call_recived = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_call_scenario' => $calling_scneario->upsrlm_call_scenario, 'upsrlm_call_type' => $upsrlm_call_type, 'upsrlm_agent_call_received' => 1])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $both_answered = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_call_scenario' => $calling_scneario->upsrlm_call_scenario, 'callStatus' => 3, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $from_unanswered = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_call_scenario' => $calling_scneario->upsrlm_call_scenario, 'callStatus' => 7, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $talk_duration = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_call_scenario' => $calling_scneario->upsrlm_call_scenario, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->sum('talkDuration');
                    $ivr_duration = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_call_scenario' => $calling_scneario->upsrlm_call_scenario, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->sum('ivrDuration');

                    $upsrlm_connection_status1 = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_call_scenario' => $calling_scneario->upsrlm_call_scenario, 'upsrlm_connection_status' => 1, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $upsrlm_connection_status21 = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_call_scenario' => $calling_scneario->upsrlm_call_scenario, 'upsrlm_connection_status' => 21, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $upsrlm_connection_status22 = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_call_scenario' => $calling_scneario->upsrlm_call_scenario, 'upsrlm_connection_status' => 22, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $upsrlm_connection_status23 = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_call_scenario' => $calling_scneario->upsrlm_call_scenario, 'upsrlm_connection_status' => 23, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $upsrlm_connection_status24 = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_call_scenario' => $calling_scneario->upsrlm_call_scenario, 'upsrlm_connection_status' => 24, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    $upsrlm_connection_status30 = CloudTeleApiCall::find()->select(['id'])->where(['upsrlm_call_scenario' => $calling_scneario->upsrlm_call_scenario, 'upsrlm_connection_status' => 30, 'upsrlm_call_type' => $upsrlm_call_type])->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();

                    $success_call = 0;

                    if ($calling_scneario->upsrlm_call_scenario == 1001) { // User Verification
                        $success_call = CallingScenarioUserVerification::find()->select(['user_id'])->where("`user_id` IS NOT NULL")->andFilterWhere(['>=', 'created_at', strtotime($api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($api_request_datetime . ' 23:59:59')])->count();
                    }


                    $progress->success_call = $success_call != null ? $success_call : 0;
                    $progress->ctc_click = $ctc_click != null ? $ctc_click : 0;
                    $progress->ibd_call = $ibd_call != null ? $ibd_call : 0;
                    $progress->total_call = $progress->ctc_click + $progress->ibd_call;
                    $progress->agent_call_recived = $agent_call_recived != null ? $agent_call_recived : 0;
                    $progress->upsrlm_connection_status1 = $upsrlm_connection_status1 != null ? $upsrlm_connection_status1 : 0;
                    $progress->upsrlm_connection_status21 = $upsrlm_connection_status21 != null ? $upsrlm_connection_status21 : 0;
                    $progress->upsrlm_connection_status22 = $upsrlm_connection_status22 != null ? $upsrlm_connection_status22 : 0;
                    $progress->upsrlm_connection_status23 = $upsrlm_connection_status23 != null ? $upsrlm_connection_status23 : 0;
                    $progress->upsrlm_connection_status24 = $upsrlm_connection_status24 != null ? $upsrlm_connection_status24 : 0;
                    $progress->upsrlm_connection_status30 = $upsrlm_connection_status30 != null ? $upsrlm_connection_status30 : 0;
                    $progress->both_answered = $both_answered != null ? $both_answered : 0;
                    $progress->from_unanswered = $from_unanswered != null ? $from_unanswered : 0;
                    $progress->talk_duration = $talk_duration != null ? $talk_duration : 0;
                    $progress->ivr_duration = $ivr_duration != null ? $ivr_duration : 0;
                    $progress->call_scenario_id = $calling_scneario->upsrlm_call_scenario;
                    $progress->calling_date = $api_request_datetime;
                    $progress->start_time = $start_time;
                    $progress->end_time = $end_time;
                    $progress->work_hour = $work_hour;
                    if (!$progress->save()) {
                        return $progress->errors;
                    }
                }
            }
        }
    }

    public function actionClose() {
        $calling_data = CallingList::find()->where(['status' => 0, 'agent_call_received' => 0, 'upsrlm_call_type' => 1])->andWhere(['!=', 'calling_agent_id', 0])->all();
        if ($calling_data != null) {
            foreach ($calling_data as $cdata) {
                if ($cdata->default_call_scenario_id == '1001') {
                    $this->sce1001($cdata);
                } elseif ($cdata->default_call_scenario_id == '1002') {
                    $this->sce1002($cdata);
                } elseif ($cdata->default_call_scenario_id == '1003') {
                    $this->sce1003($cdata);
                } elseif ($cdata->default_call_scenario_id == '1004') {
                    $this->sce1004($cdata);
                } elseif ($cdata->default_call_scenario_id == '1005') {
                    $this->sce1005($cdata);
                } else {
                    
                }
            }
        }
    }

    private function sce1001($cdata) {
        $model = $cdata;
        $user = User::findOne(['username' => $model->customer_number]);
    }

    private function sce1002($cdata) {
        $model = $cdata;
        $user = User::findOne(['username' => $model->customer_number]);
        if (isset($user) and $user->app_id) {
            $model->status = 2;
            $model->save();
        }
    }

    private function sce1003($cdata) {
        $model = $cdata;
        $sugest_samuhsakhi = \common\models\dynamicdb\cbo_detail\RishtaShgMember::find()->where(['cbo_shg_id' => $model->cbo_shg_id, 'suggest_wada_sakhi' => 1])->count();
        if ($sugest_samuhsakhi) {
            $model->status = 2;
            $model->save();
        }
    }

    private function sce1004($cdata) {
        $model = $cdata;
        $user = User::findOne(['username' => $model->customer_number]);
        if (isset($user) and $user->app_id) {
            $model->status = 2;
            $model->save();
        }
    }

    private function sce1005($cdata) {
        $model = $cdata;
        $user = User::findOne(['username' => $model->customer_number]);
        $wada_app = \common\models\wada\WadaApplication::find()->where(['user_id' => $user->id, 'status' => 2, 'cbo_shg_id' => $model->cbo_shg_id])->one();
        if (isset($user) and $user->app_id and $wada_app) {
            $model->status = 2;
            $model->save();
        }
    }

}
