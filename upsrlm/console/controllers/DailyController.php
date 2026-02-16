<?php

namespace console\controllers;

use Yii;
use yii\helpers\Json;
use yii\console\Controller;
use yii\base\Model;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\training\models\RsetisCenter;
use bc\modules\training\models\RsetisEcalendar;
use bc\modules\training\models\RsetisBatchTraining;
use bc\modules\training\models\RsetisCenterTraining;
use bc\modules\training\models\TrainingEntity;
use bc\modules\training\models\RsetisBatchParticipants;
use bc\models\master\MasterDistrict;
use bc\models\BcCumulativeReportDistrict;
use bc\modules\training\models\RsetisBatchParticipantsSearch;
use bc\modules\training\models\RsetisCenterSearch;
use common\models\rishta\RishtaUserData;
use common\helpers\Utility;
use cbo\models\Shg;
use common\models\dynamicdb\cbo_detail\RishtaShgProfile;
use common\models\dynamicdb\cbo_detail\RishtaShgFeedback;
use common\models\dynamicdb\cbo_detail\RishtaShgBankDetail;
use common\models\dynamicdb\cbo_detail\RishtaShgFundReceived;
use common\models\dynamicdb\cbo_detail\RishtaShgMember;
use common\models\CboMembers;
use common\models\wada\WadaApplication;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiCall;
use common\models\dynamicdb\internalcallcenter\CloudTeleApiLog;
use common\models\dynamicdb\internalcallcenter\CloudTeleUserReport;

class DailyController extends Controller {

    public $start_date;
    public $end_date;

    public function beforeAction($action) {
        //$this->start_date = (2021 - 03 - 21);
        $this->start_date = date("Y-m-d", strtotime("-3 day"));
        $this->end_date = date("Y-m-d", strtotime("+1 day"));
        return parent::beforeAction($action);
    }

    public function actionNight() {
        echo "Daili Night Cron Strat Time : " . date('Y-m-d H:i:s');
        \Yii::$app->runAction('daily/bcpinused');
        \Yii::$app->runAction('transactions/bcapplicationtransaction');
        // \Yii::$app->runAction('transactions/mapbc');
        //\Yii::$app->runAction('transactions/removed');
        //\Yii::$app->runAction('transactions/overallbcreport');
        //\Yii::$app->runAction('transactions/monthlybcreport');
        //\Yii::$app->runAction('transactions/weeklylybcreport');
        //\Yii::$app->runAction('transactions/dailybcr');
        // \Yii::$app->runAction('bc/monthlyreporttransaction');
        //\Yii::$app->runAction('daily/shg');
        //\Yii::$app->runAction('daily/callcenter');
        //\Yii::$app->runAction('rishta/bcapplication');
        \Yii::$app->runAction('rishta/copybcfile');
        \Yii::$app->runAction('transactions/nooftransactionbc');
        //\Yii::$app->runAction('transactions/partnerbank');
        echo "Daili Night Cron End Time : " . date('Y-m-d H:i:s');
    }

    public function actionBcpinused() {
        $sql = " UPDATE  srlm_bc_application
          SET srlm_bc_application.pin_used= 1
          WHERE  form_number=6 and pin_used=0 and training_status in (1,2,3) and CAST(last_app_version AS DECIMAL(10,2))>='2.62' ";
        \Yii::$app->dbbc->createCommand($sql)->execute();
        echo "BC pin used Completed Time : " . date('Y-m-d H:i:s');
    }

    public function actionShg() {
        echo "SHG Report Cron Strat Time : " . date('Y-m-d H:i:s');
        //$this->call_column();
        $this->user_column();
        $this->samuh_sakhi_column();
        $this->profile_column();
        $this->member_column();
        $this->fund_received_column();
        $this->bank_detail_column();
        $this->shg_feedback_column();
        echo "SHG Report Cron end Time : " . date('Y-m-d H:i:s');
    }

    public function actionEvery1hour() {
        echo "Daily Agent progress Cron Strat Time : " . date('Y-m-d H:i:s');
        //$this->call_column();
        \Yii::$app->runAction('cloudcallcenter/achievement');
        \Yii::$app->runAction('cloudcallcenter/dailyagent');
        \Yii::$app->runAction('cloudcallcenter/cst');
        \Yii::$app->runAction('cloudcallcenter/progress1001 0');
        \Yii::$app->runAction('cloudcallcenter/progress1005 0');
        echo "Daily Agent progress Cron end Time : " . date('Y-m-d H:i:s');
    }

    public function actionEvery15min() {
        echo "Daily wada Cron Strat Time : " . date('Y-m-d H:i:s');
        //$this->call_column();
        \Yii::$app->runAction('daily/sugesst');
        \Yii::$app->runAction('daily/formcomplete');
        \Yii::$app->runAction('wada/rating');
        echo "Daily wada Cron end Time : " . date('Y-m-d H:i:s');
    }

    public function actionCallcenter() {
        echo "User  Report Call ceter Cron Strat Time : " . date('Y-m-d H:i:s');
        $this->user_call_report();
        $this->user_call_monthly_report();
        echo "User  Report Call ceter Cron end Time : " . date('Y-m-d H:i:s');
    }

    private function call_column() {

        $models = CloudTeleApiCall::find()->select(['cbo_shg_id'])->andWhere(['upsrlm_call_type' => 1])->andWhere(['>', CloudTeleApiCall::getTableSchema()->fullName . '.cbo_shg_id', 0])->andFilterWhere(['>=', CloudTeleApiCall::getTableSchema()->fullName . '.updated_at', strtotime($this->start_date)])->andFilterWhere(['<=', CloudTeleApiCall::getTableSchema()->fullName . '.updated_at', strtotime($this->end_date)])->all();
        foreach ($models as $model) {
            $no_of_call = CloudTeleApiCall::find()->select('id')->where(['cbo_shg_id' => $model->cbo_shg_id, 'upsrlm_call_type' => 1])->count();
            $no_of_call_success = CloudTeleApiCall::find()->select('id')->where(['cbo_shg_id' => $model->cbo_shg_id, 'upsrlm_call_type' => 1, 'upsrlm_call_status' => 10])->count();
            $condition = ['and',
                ['=', 'id', $model->cbo_shg_id],
            ];
            Shg::updateAll([
                'no_of_call' => $no_of_call,
                'no_of_call_success' => $no_of_call_success,
                    ], $condition);
        }
    }

    private function user_column() {
        $models = CboMembers::find()->select(['cbo_id'])->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => CboMembers::CBO_TYPE_SHG])->andFilterWhere(['>=', CboMembers::getTableSchema()->fullName . '.updated_at', strtotime($this->start_date)])->andFilterWhere(['<=', CboMembers::getTableSchema()->fullName . '.updated_at', strtotime($this->end_date)])->all();
        foreach ($models as $model) {
            $no_of_user = CboMembers::find()->select(['user_id'])->distinct()->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => CboMembers::CBO_TYPE_SHG, CboMembers::getTableSchema()->fullName . '.cbo_id' => $model->cbo_id, CboMembers::getTableSchema()->fullName . '.status' => 1])->andWhere(['or',
                        [CboMembers::getTableSchema()->fullName . '.shg_chairperson' => 1],
                        [CboMembers::getTableSchema()->fullName . '.shg_secretary' => 1],
                        [CboMembers::getTableSchema()->fullName . '.shg_treasurer' => 1],
                        [CboMembers::getTableSchema()->fullName . '.bc_sakhi' => 1],
                        [CboMembers::getTableSchema()->fullName . '.samuh_sakhi' => 1],
                        [CboMembers::getTableSchema()->fullName . '.suggest_wada_sakhi' => 1],
                    ])->count();
            $no_of_user_used_rishta = CboMembers::find()->select(['user_id'])->distinct()->joinWith(['user'])->andWhere(['not', [\common\models\User::getTableSchema()->fullName . '.app_id' => null]])->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => CboMembers::CBO_TYPE_SHG, CboMembers::getTableSchema()->fullName . '.cbo_id' => $model->cbo_id, CboMembers::getTableSchema()->fullName . '.status' => 1])->andWhere(['or',
                        [CboMembers::getTableSchema()->fullName . '.shg_chairperson' => 1],
                        [CboMembers::getTableSchema()->fullName . '.shg_secretary' => 1],
                        [CboMembers::getTableSchema()->fullName . '.shg_treasurer' => 1],
                        [CboMembers::getTableSchema()->fullName . '.bc_sakhi' => 1],
                        [CboMembers::getTableSchema()->fullName . '.samuh_sakhi' => 1],
                        [CboMembers::getTableSchema()->fullName . '.suggest_wada_sakhi' => 1],
                    ])->count();
            $no_of_cst_user = CboMembers::find()->select(['user_id'])->distinct()->joinWith(['user'])->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => CboMembers::CBO_TYPE_SHG, CboMembers::getTableSchema()->fullName . '.cbo_id' => $model->cbo_id])->andWhere(['or',
                        [CboMembers::getTableSchema()->fullName . '.shg_chairperson' => 1],
                        [CboMembers::getTableSchema()->fullName . '.shg_secretary' => 1],
                        [CboMembers::getTableSchema()->fullName . '.shg_treasurer' => 1],
                    ])->count();
            $no_of_cst_user_login = CboMembers::find()->select(['user_id'])->distinct()->joinWith(['user'])->andWhere(['not', [\common\models\User::getTableSchema()->fullName . '.app_id' => null]])->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => CboMembers::CBO_TYPE_SHG, CboMembers::getTableSchema()->fullName . '.cbo_id' => $model->cbo_id])->andWhere(['or',
                        [CboMembers::getTableSchema()->fullName . '.shg_chairperson' => 1],
                        [CboMembers::getTableSchema()->fullName . '.shg_secretary' => 1],
                        [CboMembers::getTableSchema()->fullName . '.shg_treasurer' => 1],
                    ])->count();
            $no_of_cst_user_not_login = CboMembers::find()->select(['user_id'])->distinct()->joinWith(['user'])->andFilterWhere(['is', 'user.app_id', new \yii\db\Expression('NULL')])->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => CboMembers::CBO_TYPE_SHG, CboMembers::getTableSchema()->fullName . '.cbo_id' => $model->cbo_id])->andWhere(['or',
                        [CboMembers::getTableSchema()->fullName . '.shg_chairperson' => 1],
                        [CboMembers::getTableSchema()->fullName . '.shg_secretary' => 1],
                        [CboMembers::getTableSchema()->fullName . '.shg_treasurer' => 1],
                    ])->count();
            $is_bc = CboMembers::find()->andWhere([CboMembers::getTableSchema()->fullName . '.cbo_type' => CboMembers::CBO_TYPE_SHG, CboMembers::getTableSchema()->fullName . '.cbo_id' => $model->cbo_id, CboMembers::getTableSchema()->fullName . '.bc_sakhi' => 1, 'status' => 1])->count();
            $condition = ['and',
                ['=', 'id', $model->cbo_id],
            ];
            Shg::updateAll([
                'no_of_user' => $no_of_user,
                'no_of_user_used_rishta' => $no_of_user_used_rishta,
                'no_of_cst_user' => $no_of_cst_user,
                'no_of_cst_user_login' => $no_of_cst_user_login,
                'no_of_cst_user_not_login' => $no_of_cst_user_not_login,
                'is_bc' => $is_bc,
                    ], $condition);
        }
    }

    private function samuh_sakhi_column() {
        $models = RishtaShgMember::find()->andWhere(['=', RishtaShgMember::getTableSchema()->fullName . '.suggest_wada_sakhi', 1])->andFilterWhere(['>=', RishtaShgMember::getTableSchema()->fullName . '.updated_at', strtotime($this->start_date)])->andFilterWhere(['<=', RishtaShgMember::getTableSchema()->fullName . '.updated_at', strtotime($this->end_date)])->all();
        foreach ($models as $model) {
            $condition = ['and',
                ['=', 'id', $model->cbo_shg_id],
            ];
            Shg::updateAll([
                'suggest_samuh_sakhi' => 1,
                    ], $condition);
        }
        $modelss = WadaApplication::find()->andWhere(['=', WadaApplication::getTableSchema()->fullName . '.status', 2])->andFilterWhere(['>=', WadaApplication::getTableSchema()->fullName . '.updated_at', strtotime($this->start_date)])->andFilterWhere(['<=', WadaApplication::getTableSchema()->fullName . '.updated_at', strtotime($this->end_date)])->all();
        foreach ($modelss as $models) {
            $condition = ['and',
                ['=', 'id', $models->cbo_shg_id],
            ];
            Shg::updateAll([
                'suggest_samuh_sakhi_completed_application' => 1,
                    ], $condition);
        }
        $modelssa = WadaApplication::find()->andWhere(['=', WadaApplication::getTableSchema()->fullName . '.status', 1])->andFilterWhere(['>=', WadaApplication::getTableSchema()->fullName . '.updated_at', strtotime($this->start_date)])->andFilterWhere(['<=', WadaApplication::getTableSchema()->fullName . '.updated_at', strtotime($this->end_date)])->all();
        foreach ($modelssa as $modelsa) {
            $condition = ['and',
                ['=', 'id', $modelsa->cbo_shg_id],
            ];
            Shg::updateAll([
                'suggest_samuh_sakhi_save_application' => 1,
                    ], $condition);
        }
    }

    public function actionUser() {
        $this->user_column();
    }

    public function actionSugesst() {
        $this->samuh_sakhi_column();
    }

    public function actionFormcomplete() {
        $this->samuh_sakhi_form_complete();
    }

    private function samuh_sakhi_form_complete() {
        $modelss = WadaApplication::find()->andWhere(['=', WadaApplication::getTableSchema()->fullName . '.status', 2])->andFilterWhere(['>=', WadaApplication::getTableSchema()->fullName . '.updated_at', strtotime($this->start_date)])->andFilterWhere(['<=', WadaApplication::getTableSchema()->fullName . '.updated_at', strtotime($this->end_date)])->all();
        foreach ($modelss as $models) {
            $condition = ['and',
                ['=', 'id', $models->cbo_shg_id],
            ];
            Shg::updateAll([
                'suggest_samuh_sakhi_completed_application' => 1,
                    ], $condition);
        }
    }

    private function profile_column() {
        $models = RishtaShgProfile::find()->andWhere(['not', [RishtaShgProfile::getTableSchema()->fullName . '.date_of_formation' => null]])->andFilterWhere(['>=', RishtaShgProfile::getTableSchema()->fullName . '.updated_at', strtotime($this->start_date)])->andFilterWhere(['<=', RishtaShgProfile::getTableSchema()->fullName . '.updated_at', strtotime($this->end_date)])->all();

        foreach ($models as $model) {
            $no_of_cst_user_used_rishta = 0;
            $condition = ['and',
                ['=', 'id', $model->cbo_shg_id],
            ];
            Shg::updateAll([
                'shg_profile_updated' => 1,
                'no_of_cst_user_used_rishta' => 1,
                    ], $condition);
        }
    }

    private function member_column() {
        $models = RishtaShgMember::find()->andFilterWhere(['>=', RishtaShgMember::getTableSchema()->fullName . '.updated_at', strtotime($this->start_date)])->andFilterWhere(['<=', RishtaShgMember::getTableSchema()->fullName . '.updated_at', strtotime($this->end_date)])->groupBy(RishtaShgMember::getTableSchema()->fullName . '.cbo_shg_id')->all();
        foreach ($models as $model) {
            $no_of_member_added = RishtaShgMember::find()->select('id')->where(['cbo_shg_id' => $model->cbo_shg_id, 'status' => 1])->count();
            $shg = Shg::findOne($model->cbo_shg_id);
            $condition = ['and',
                ['=', 'id', $model->cbo_shg_id],
            ];
            Shg::updateAll([
                'no_of_member_added' => ($no_of_member_added - 3),
                'no_of_cst_user_used_rishta' => ($no_of_member_added - 3) > 0 ? 1 : $shg->no_of_cst_user_used_rishta,
                    ], $condition);
        }
    }

    private function fund_received_column() {
        $models = RishtaShgFundReceived::find()->andFilterWhere(['>=', RishtaShgFundReceived::getTableSchema()->fullName . '.updated_at', strtotime($this->start_date)])->andFilterWhere(['<=', RishtaShgFundReceived::getTableSchema()->fullName . '.updated_at', strtotime($this->end_date)])->groupBy(RishtaShgFundReceived::getTableSchema()->fullName . '.cbo_shg_id')->all();
        foreach ($models as $model) {
            $shg = Shg::findOne($model->cbo_shg_id);
            $no_of_fund_received = RishtaShgFundReceived::find()->select('id')->where(['cbo_shg_id' => $model->cbo_shg_id, 'status' => 1])->count();
            $total_fund_received_amount = RishtaShgFundReceived::find()->select(['id', 'amount_received'])->where(['cbo_shg_id' => $model->cbo_shg_id, 'status' => 1])->sum('amount_received');
            $condition = ['and',
                ['=', 'id', $model->cbo_shg_id],
            ];
            Shg::updateAll([
                'no_of_fund_received' => $no_of_fund_received,
                'total_fund_received_amount' => isset($total_fund_received_amount) ? $total_fund_received_amount : 0,
                'no_of_cst_user_used_rishta' => $no_of_fund_received > 0 ? 1 : $shg->no_of_cst_user_used_rishta,
                    ], $condition);
        }
    }

    private function bank_detail_column() {
        $models = RishtaShgBankDetail::find()->andFilterWhere(['>=', RishtaShgBankDetail::getTableSchema()->fullName . '.updated_at', strtotime($this->start_date)])->andFilterWhere(['<=', RishtaShgBankDetail::getTableSchema()->fullName . '.updated_at', strtotime($this->end_date)])->all();
        foreach ($models as $model) {
            $condition = ['and',
                ['=', 'id', $model->cbo_shg_id],
            ];
            Shg::updateAll([
                'bank_detail_add' => 1,
                    ], $condition);
        }
    }

    private function shg_feedback_column() {
        $models = RishtaShgFeedback::find()->andFilterWhere(['>=', RishtaShgFeedback::getTableSchema()->fullName . '.updated_at', strtotime($this->start_date)])->andFilterWhere(['<=', RishtaShgFeedback::getTableSchema()->fullName . '.updated_at', strtotime($this->end_date)])->all();
        foreach ($models as $model) {
            $shg = Shg::findOne($model->cbo_shg_id);
            $condition = ['and',
                ['=', 'id', $model->cbo_shg_id],
            ];
            Shg::updateAll([
                'shg_feedback' => 1,
                'no_of_cst_user_used_rishta' => 1,
                    ], $condition);
        }
    }

    private function user_call_report() {
        $this->start_date = date("Y-m-d", strtotime("-2 day"));
        $this->end_date = date("Y-m-d", strtotime("+1 day"));
        $models = CloudTeleApiCall::find()->select('date(api_request_datetime) as api_request_datetime')->distinct()->where(['upsrlm_call_type' => [1, 2]])->andFilterWhere(['>=', 'created_at', strtotime($this->start_date . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($this->end_date . ' 23:59:59')])->all();

        foreach ($models as $model) {
            $distict_user_model = CloudTeleApiCall::find()->select(['upsrlm_user_id', 'date(api_request_datetime) as api_request_datetime'])->distinct()->where(['upsrlm_call_type' => 1])->andFilterWhere(['=', 'date(api_request_datetime)', $model->api_request_datetime])->all();

            foreach ($distict_user_model as $umodel) {

                if (isset($umodel->user->role)) {
//                     echo PHP_EOL;                print_r($umodel->user->role);exit;
                    $user_report = CloudTeleUserReport::find()->where(['user_id' => $umodel->upsrlm_user_id, 'date' => $umodel->api_request_datetime])->one();
                    if ($user_report == null) {
                        $user_report = new CloudTeleUserReport();
                    }
                    $user_report->name = $umodel->name;
                    $user_report->user_id = $umodel->upsrlm_user_id;
                    $user_report->role = $umodel->user->role;
                    $user_report->date = $umodel->api_request_datetime;
                    $user_report->start_time = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->min('api_request_datetime');
                    $user_report->end_time = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->max('api_request_datetime');
                    $date = new \DateTime($user_report->start_time);
                    $date2 = new \DateTime($user_report->end_time);
                    $user_report->working_time = $date2->getTimestamp() - $date->getTimestamp();
                    $user_report->no_of_call_ctc = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id, 'upsrlm_call_type' => 1])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->count();
                    $user_report->no_of_call_ibd = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id, 'upsrlm_call_type' => 2])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->count();
                    $user_report->no_of_call = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->count();
                    $user_report->no_of_call_success = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['upsrlm_call_status' => 10, 'upsrlm_connection_status' => 1])->count();
                    $user_report->total_call_duration = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->sum('talkDuration');
                    $user_report->total_ivr_duration = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->sum('ivrDuration');
                    $user_report->api_status_code0 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['api_status_code' => 0])->count();
                    $user_report->api_status_code200 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['api_status_code' => 200])->count();
                    $user_report->api_status_code111 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['api_status_code' => 111])->count();
                    $user_report->api_status_code150 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['api_status_code' => 150])->count();

                    $user_report->api_call_status3 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['callStatus' => 3])->count();
                    $user_report->api_call_status4 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['callStatus' => 4])->count();
                    $user_report->api_call_status5 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['callStatus' => 5])->count();
                    $user_report->api_call_status6 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['callStatus' => 6])->count();
                    $user_report->api_call_status7 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['callStatus' => 7])->count();
                    $user_report->api_call_status8 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['callStatus' => 8])->count();
                    $user_report->api_call_status9 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['callStatus' => 9])->count();
                    $user_report->api_call_status10 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['callStatus' => 10])->count();
                    $user_report->api_call_status11 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['callStatus' => 11])->count();
                    $user_report->api_call_status12 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['callStatus' => 12])->count();
                    $user_report->api_call_status13 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['callStatus' => 13])->count();
                    $user_report->api_call_status14 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['callStatus' => 14])->count();
                    $user_report->api_call_status15 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['callStatus' => 15])->count();
                    $user_report->api_call_status16 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['callStatus' => 16])->count();
                    $user_report->upsrlm_call_status10 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['upsrlm_call_status' => 10])->count();
                    $user_report->upsrlm_call_status11 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['upsrlm_call_status' => 11])->count();
                    $user_report->upsrlm_call_status12 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['upsrlm_call_status' => 12])->count();
                    $user_report->upsrlm_call_status13 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['upsrlm_call_status' => 13])->count();
                    $user_report->upsrlm_connection_status1 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['upsrlm_connection_status' => 1])->count();
                    $user_report->upsrlm_connection_status21 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['upsrlm_connection_status' => 21])->count();
                    $user_report->upsrlm_connection_status22 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['upsrlm_connection_status' => 22])->count();
                    $user_report->upsrlm_connection_status23 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['upsrlm_connection_status' => 23])->count();
                    $user_report->upsrlm_connection_status24 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['upsrlm_connection_status' => 24])->count();
                    $user_report->upsrlm_connection_status30 = CloudTeleApiCall::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'created_at', strtotime($umodel->api_request_datetime . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($umodel->api_request_datetime . ' 23:59:59')])->andWhere(['upsrlm_connection_status' => 23])->count();
                    $user_report->last_updated_at = time();
                    if ($user_report->save()) {
                        
                    }
                }
            }
        }
    }

    public function actionMonthlycallexreport() {
        $this->user_call_monthly_report();
    }

    private function user_call_monthly_report() {
        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $last_day_month = $date->format('Y-m-d');
        $montn_models = \common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterMonth::find()->where(['status' => 1])->andWhere(['>', 'id', 21])->andWhere(['<=', 'month_start_date', date("Y-m-d")])->all();
        foreach ($montn_models as $model) {
            $distict_user_model = CloudTeleApiLog::find()->select(['upsrlm_user_id'])->distinct()->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->andWhere(['project_id' => 1])->all();
            foreach ($distict_user_model as $umodel) {

                if (isset($umodel->user->role)) {

                    $user_report = \common\models\dynamicdb\internalcallcenter\CloudTeleUserMontlyReport::find()->where(['user_id' => $umodel->upsrlm_user_id, 'month_id' => $model->id])->one();
                    if ($user_report == null) {
                        $user_report = new \common\models\dynamicdb\internalcallcenter\CloudTeleUserMontlyReport();
                    }
                    $user_report->user_id = $umodel->upsrlm_user_id;
                    $user_report->role = $umodel->user->role;
                    $user_report->month_id = $model->id;
                    $user_report->month_start_date = $model->month_start_date;
                    $user_report->month_end_date = $model->month_end_date;
                    $user_report->no_of_call = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andWhere(['project_id' => 1])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->count();
                    $user_report->no_of_ibd_call = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id, 'upsrlm_call_type' => 2])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->count();
                    $user_report->no_of_ctc_call = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id, 'upsrlm_call_type' => 1])->andWhere(['project_id' => 1])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->count();
                    $user_report->total_time = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andWhere(['project_id' => 1])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->sum('talkDuration');
                    $user_report->ctc_time = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id, 'upsrlm_call_type' => 1])->andWhere(['project_id' => 1])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->sum('talkDuration');
                    $user_report->ibd_time = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id, 'upsrlm_call_type' => 2])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->sum('talkDuration');
                    $user_report->total_time_text = Utility::seconds2hms($user_report->total_time);
                    $user_report->ibd_time_text = Utility::seconds2hms($user_report->ibd_time);
                    $user_report->ctc_time_text = Utility::seconds2hms($user_report->ctc_time);
                    $user_report->ivr_time = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andWhere(['project_id' => 1])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->sum('ivrDuration');
                    $user_report->ivr_time_text = Utility::seconds2hms($user_report->ivr_time);
                    if ($user_report->save()) {
                        
                    } else {
                        print_r($user_report->getErrors());
                    }
                }
            }
        }
    }

    public function actionMonthlyultrapoort() {
        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $last_day_month = $date->format('Y-m-d');
        $montn_models = \common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterMonth::find()->where(['status' => 1])->andWhere(['>', 'id', 21])->andWhere(['<=', 'month_start_date', date("Y-m-d")])->all();
        foreach ($montn_models as $model) {
            $distict_user_model = CloudTeleApiLog::find()->select(['upsrlm_user_id'])->distinct()->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->andWhere(['project_id' => 3])->all();
            foreach ($distict_user_model as $umodel) {
                if (isset($umodel->user->role)) {
                    $user_report = \common\models\dynamicdb\internalcallcenter\UltraPoorCloudTeleUserMontlyReport::find()->where(['user_id' => $umodel->upsrlm_user_id, 'month_id' => $model->id])->one();
                    if ($user_report == null) {
                        $user_report = new \common\models\dynamicdb\internalcallcenter\UltraPoorCloudTeleUserMontlyReport();
                    }
                    $user_report->name = $umodel->user->name;
                    $user_report->mobile_no = $umodel->user->username;
                    $user_report->user_id = $umodel->upsrlm_user_id;
                    $user_report->role = $umodel->user->role;
                    $user_report->month_id = $model->id;
                    $user_report->month_start_date = $model->month_start_date;
                    $user_report->month_end_date = $model->month_end_date;
                    $user_report->no_of_call = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andWhere(['project_id' => 3])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->count();
                    $user_report->no_of_ibd_call = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id, 'upsrlm_call_type' => 2])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->count();
                    $user_report->no_of_ctc_call = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id, 'upsrlm_call_type' => 1])->andWhere(['project_id' => 3])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->count();
                    $user_report->total_time = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andWhere(['project_id' => 1])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->sum('talkDuration');
                    $user_report->ctc_time = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id, 'upsrlm_call_type' => 1])->andWhere(['project_id' => 3])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->sum('talkDuration');
                    $user_report->ibd_time = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id, 'upsrlm_call_type' => 2])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->sum('talkDuration');
                    $user_report->total_time_text = Utility::seconds2hms($user_report->total_time);
                    $user_report->ibd_time_text = Utility::seconds2hms($user_report->ibd_time);
                    $user_report->ctc_time_text = Utility::seconds2hms($user_report->ctc_time);
                    $user_report->ivr_time = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andWhere(['project_id' => 3])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->sum('ivrDuration');
                    $user_report->ivr_time_text = Utility::seconds2hms($user_report->ivr_time);
                    if ($user_report->save()) {
                        
                    } else {
                        print_r($user_report->getErrors());
                    }
                }
            }
        }
    }

    public function actionMonthlyuponline() {
        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $last_day_month = $date->format('Y-m-d');
        $montn_models = \common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterMonth::find()->where(['status' => 1])->andWhere(['>', 'id', 21])->andWhere(['<=', 'month_start_date', date("Y-m-d")])->all();
        foreach ($montn_models as $model) {
            $distict_user_model = CloudTeleApiLog::find()->select(['upsrlm_user_id'])->distinct()->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->andWhere(['project_id' => 2])->all();
            foreach ($distict_user_model as $umodel) {
                $user_model = \common\models\online\User::findOne($umodel->upsrlm_user_id);
                if (isset($umodel->upsrlm_user_id) and $umodel->upsrlm_user_id and isset($user_model)) {
                    $user_model = \common\models\online\User::findOne($umodel->upsrlm_user_id);
                    $user_report = \common\models\dynamicdb\internalcallcenter\UponlineCloudTeleUserMontlyReport::find()->where(['user_id' => $umodel->upsrlm_user_id, 'month_id' => $model->id])->one();
                    if ($user_report == null) {
                        $user_report = new \common\models\dynamicdb\internalcallcenter\UponlineCloudTeleUserMontlyReport();
                    }
                    $user_report->name = $user_model->name;
                    $user_report->mobile_no = $user_model->username;
                    $user_report->user_id = $umodel->upsrlm_user_id;
                    $user_report->role = $user_model->role;
                    $user_report->month_id = $model->id;
                    $user_report->month_start_date = $model->month_start_date;
                    $user_report->month_end_date = $model->month_end_date;
                    $user_report->no_of_call = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andWhere(['project_id' => 2])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->count();
                    $user_report->no_of_ibd_call = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id, 'upsrlm_call_type' => 2])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->count();
                    $user_report->no_of_ctc_call = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id, 'upsrlm_call_type' => 1])->andWhere(['project_id' => 2])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->count();
                    $user_report->total_time = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andWhere(['project_id' => 2])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->sum('talkDuration');
                    $user_report->ctc_time = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id, 'upsrlm_call_type' => 1])->andWhere(['project_id' => 2])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->sum('talkDuration');
                    $user_report->ibd_time = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id, 'upsrlm_call_type' => 2])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->sum('talkDuration');
                    $user_report->total_time_text = Utility::seconds2hms($user_report->total_time);
                    $user_report->ibd_time_text = Utility::seconds2hms($user_report->ibd_time);
                    $user_report->ctc_time_text = Utility::seconds2hms($user_report->ctc_time);
                    $user_report->ivr_time = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andFilterWhere(['>=', 'date(api_request_datetime)', $model->month_start_date])->andWhere(['project_id' => 2])->andFilterWhere(['<=', 'date(api_request_datetime)', $model->month_end_date])->sum('ivrDuration');
                    $user_report->ivr_time_text = Utility::seconds2hms($user_report->ivr_time);
                    if ($user_report->save()) {
                        
                    } else {
                        print_r($user_report->getErrors());
                    }
                }
            }
        }
    }

    public function actionCmr() {
        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $last_day_month = $date->format('Y-m-d');
        $montn_models = \common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterMonth::find()->where(['status' => 1])->andWhere(['>', 'id', 15])->andWhere(['<=', 'id', 24])->all();
        $file = "monthly_call_report.csv";
        $file_path = Yii::$app->params['datapath'] . 'tmp/' . 'callcenter/' . $file;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $output = fopen($file_path, 'w');
        fputcsv($output, array(
            'Sr No',
            'Month',
            'Total OBD Call attempt',
            'Total OBD call Talk',
            'Unique OBD number attempt',
            'Unique OBD number talk',
            'Total IBD recived ',
            'Total IBD Call talk',
            'Unique IBD number recived',
            'Unique IBD number talk'));
        $sr_no = 1;
        $row = [];
        foreach ($montn_models as $model) {
            $total_obd_call = CloudTeleApiLog::find()->select(['id'])->andWhere(['upsrlm_call_type' => 1])->andFilterWhere(['>=', 'created_at', strtotime($model->month_start_date . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($model->month_end_date . ' 23:59:59')])->count();
            $total_obd_suc_call = CloudTeleApiLog::find()->select(['id'])->andWhere(['upsrlm_call_type' => 1, 'callStatus' => 3])->andFilterWhere(['>=', 'created_at', strtotime($model->month_start_date . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($model->month_end_date . ' 23:59:59')])->count();
            $total_ibd_call = CloudTeleApiLog::find()->select(['id'])->andWhere(['upsrlm_call_type' => 2])->andFilterWhere(['>=', 'created_at', strtotime($model->month_start_date . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($model->month_end_date . ' 23:59:59')])->count();
            $total_ibd_suc_call = CloudTeleApiLog::find()->select(['id'])->andWhere(['upsrlm_call_type' => 2, 'callStatus' => 3])->andFilterWhere(['>=', 'created_at', strtotime($model->month_start_date . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($model->month_end_date . ' 23:59:59')])->count();
            $total_obd_unique_number = CloudTeleApiLog::find()->select(['customernumber'])->distinct()->andWhere(['upsrlm_call_type' => 1])->andFilterWhere(['>=', 'created_at', strtotime($model->month_start_date . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($model->month_end_date . ' 23:59:59')])->count();
            $total_obd_unique_number_talk = CloudTeleApiLog::find()->select(['customernumber'])->distinct()->andWhere(['upsrlm_call_type' => 1, 'callStatus' => 3])->andFilterWhere(['>=', 'created_at', strtotime($model->month_start_date . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($model->month_end_date . ' 23:59:59')])->count();
            $total_ibd_unique_number = CloudTeleApiLog::find()->select(['customernumber'])->distinct()->andWhere(['upsrlm_call_type' => 2])->andFilterWhere(['>=', 'created_at', strtotime($model->month_start_date . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($model->month_end_date . ' 23:59:59')])->count();
            $total_ibd_unique_number_talk = CloudTeleApiLog::find()->select(['customernumber'])->distinct()->andWhere(['upsrlm_call_type' => 2, 'callStatus' => 3])->andFilterWhere(['>=', 'created_at', strtotime($model->month_start_date . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($model->month_end_date . ' 23:59:59')])->count();
            $row = [
                $sr_no,
                \Yii::$app->formatter->asDatetime($model->month_start_date, "php:M-Y"),
                $total_obd_call,
                $total_obd_suc_call,
                $total_obd_unique_number,
                $total_obd_unique_number_talk,
                $total_ibd_call,
                $total_ibd_suc_call,
                $total_ibd_unique_number,
                $total_ibd_unique_number_talk
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
    }

    public function actionCmmissed() {
        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $last_day_month = $date->format('Y-m-d');
        $montn_models = \common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterMonth::find()->where(['status' => 1])->andWhere(['>', 'id', 15])->andWhere(['<=', 'id', 28])->all();
        $file = "monthly_missed_call.csv";
        $file_path = Yii::$app->params['datapath'] . 'tmp/' . 'callcenter/' . $file;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $output = fopen($file_path, 'w');
        fputcsv($output, array(
            'Sr No',
            'Month',
            'Total Incoming',
            'Missed Call'));
        $sr_no = 1;
        $row = [];
        foreach ($montn_models as $model) {
            $total_incoming = CloudTeleApiLog::find()->select(['id'])->andWhere(['upsrlm_call_type' => 2])->andFilterWhere(['>=', 'created_at', strtotime($model->month_start_date . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($model->month_end_date . ' 23:59:59')])->count();
            $total_missed_call = CloudTeleApiLog::find()->select(['id'])->andWhere(['upsrlm_call_type' => 2])->andWhere(['is', 'upsrlm_user_id', new \yii\db\Expression('null')])->andFilterWhere(['>=', 'created_at', strtotime($model->month_start_date . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($model->month_end_date . ' 23:59:59')])->count();
            $row = [
                $sr_no,
                \Yii::$app->formatter->asDatetime($model->month_start_date, "php:M-Y"),
                $total_incoming,
                $total_missed_call,
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
    }

    public function actionCur() {
        $start_date = '2022-04-21';
        $end_date = '2022-11-21';
        $file = "caller_call_report_with_ivr" . $start_date . ' to ' . $end_date . ".csv";
        $file_path = Yii::$app->params['datapath'] . 'tmp/' . 'callcenter/' . $file;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $output = fopen($file_path, 'w');
        fputcsv($output, array(
            'Sr No',
            'Caller Name',
            'Caller number',
            'Total OBD',
            'Total IBD',
            'Talk time OBD',
            'Talk time IBD',
            'ivr time OBD',
            'ivr time IBD'
        ));
        $sr_no = 1;
        $row = [];
        $distict_user_model = CloudTeleApiLog::find()->select(['upsrlm_user_id'])->distinct()->andFilterWhere(['>=', 'created_at', strtotime($start_date . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($end_date . ' 23:59:59')])->all();
        foreach ($distict_user_model as $umodel) {
            if (isset($umodel->user)) {
                $total_obd_call = CloudTeleApiLog::find()->select(['id'])->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andWhere(['upsrlm_call_type' => 1])->andFilterWhere(['>=', 'created_at', strtotime($start_date . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($end_date . ' 23:59:59')])->count();
                $total_ibd_call = CloudTeleApiLog::find()->select(['id'])->where(['upsrlm_user_id' => $umodel->upsrlm_user_id])->andWhere(['upsrlm_call_type' => 2])->andFilterWhere(['>=', 'created_at', strtotime($start_date . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($end_date . ' 23:59:59')])->count();
                $obd_time = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id, 'upsrlm_call_type' => 1])->andFilterWhere(['>=', 'created_at', strtotime($start_date . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($end_date . ' 23:59:59')])->sum('talkDuration');
                $ibd_time = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id, 'upsrlm_call_type' => 2])->andFilterWhere(['>=', 'created_at', strtotime($start_date . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($end_date . ' 23:59:59')])->sum('talkDuration');
                $obd_ivr_time = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id, 'upsrlm_call_type' => 1])->andFilterWhere(['>=', 'created_at', strtotime($start_date . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($end_date . ' 23:59:59')])->sum('ivrDuration');
                $ibd_ivr_time = CloudTeleApiLog::find()->where(['upsrlm_user_id' => $umodel->upsrlm_user_id, 'upsrlm_call_type' => 2])->andFilterWhere(['>=', 'created_at', strtotime($start_date . ' 00:00:00')])->andFilterWhere(['<=', 'created_at', strtotime($end_date . ' 23:59:59')])->sum('ivrDuration');
                $row = [
                    $sr_no,
                    $umodel->user->name,
                    $umodel->user->username,
                    $total_obd_call,
                    $total_ibd_call,
                    $obd_time,
                    isset($ibd_time) ? $ibd_time : '',
                    $obd_ivr_time,
                    isset($ibd_ivr_time) ? $ibd_ivr_time : ''
                ];
                fputcsv($output, $row);
            }
            $sr_no++;
        }
    }

    public function actionCbobys() {
        $sql = "SELECT user.id,cbo_member_profile.created_by FROM `user`
        join cbo_member_profile on cbo_member_profile.user_id=user.id
         where user.created_by is null and cbo_member_profile.bc=0 and cbo_member_profile.created_by is not null and user.role=100 limit 500";
//        echo $sql;exit;
        $connection = \Yii::$app->dbcbo;
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();

        foreach ($result as $um) {
            if ($um['created_by'] != null) {
                $condition = ['and',
                    ['=', 'id', $um['id']],
                ];
                if ($um['created_by']) {
                    \common\models\User::updateAll([
                        'created_by' => $um['created_by'],
                            ], $condition);
                    \common\models\dynamicdb\bc\User::updateAll([
                        'created_by' => $um['created_by'],
                            ], $condition);
                    \common\models\dynamicdb\cbo_detail\User::updateAll([
                        'created_by' => $um['created_by'],
                            ], $condition);
                }
            }
        }
    }

    public function actionBlockbmmu() {
        $block_models = \bc\models\master\MasterBlock::find()->where(['status' => 1])->all();
        foreach ($block_models as $block) {
            $bmmu = '';
            $bummus = \common\models\RelationUserBdoBlock::find()->joinWith(['user'])->where([\common\models\RelationUserBdoBlock::getTableSchema()->fullName . '.block_code' => $block->block_code, \common\models\RelationUserBdoBlock::getTableSchema()->fullName . '.status' => 1])->andWhere(['user.role' => \common\models\master\MasterRole::ROLE_BMMU, 'user.status' => 10])->all();
            $block_bmmu = \bc\models\master\BlockBmmu::findOne(['block_code' => $block->block_code]);
            if ($block_bmmu == null) {
                $block_bmmu = new \bc\models\master\BlockBmmu();
            }
            $block_bmmu->block_code = $block->block_code;
            $block_bmmu->block_name = $block->block_name;
            $block_bmmu->district_name = $block->district_name;
            if ($bummus != null) {
                foreach ($bummus as $bmodel) {
                    $bmmu .= $bmodel->user->name . ' (' . $bmodel->user->username . ')' . ' : ';
                }
            }
            $bmmu = rtrim($bmmu, ' : ');
            if ($bmmu) {
                $block_bmmu->bmmu = $bmmu;
            }
            $block_bmmu->updated_at = time();
            $block_bmmu->save();
        }
    }

    public function actionMcce() {
        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $last_day_month = $date->format('Y-m-d');
        $montn_models = \common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterMonth::find()->where(['status' => 1])->andWhere(['>', 'id', 15])->andWhere(['<', 'id', 29])->all();
        $file = "monthly_cce_call_report.csv";
        $file_path = Yii::$app->params['datapath'] . 'tmp/' . 'callcenter/' . $file;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $output = fopen($file_path, 'w');
        fputcsv($output, array(
            'Sr No',
            'CCE Name',
            'Month',
            'Total OBD Call Attempt',
            'Total IBD recived ',
        ));
        $sr_no = 1;
        $row = [];
        foreach ($montn_models as $model) {
            $searchModel = new \common\models\dynamicdb\internalcallcenter\DyCloudTeleApiLogSearch();
            $searchModel->month = $model->month_start_date;
            if ($model->id == 16) {
                $searchModel->from_date_time = '2022-04-14';
            }
            if ($model->id == 28) {
                $searchModel->to_date_time = '2023-04-14';
            }
            $dataProvider = $searchModel->search($searchModel, null, 400, \common\models\base\GenralModel::select_cloud_tele_log_columns_no_table_schema());
            $dataProvider->query->andWhere(['not', ['upsrlm_user_id' => null]]);
            $dataProvider->query->andWhere(['!=', 'upsrlm_user_role', 1]);
            $dataProvider->query->groupBy(['upsrlm_user_id']);
            foreach ($dataProvider->getModels() as $md) {
                $searchModelobd = new \common\models\dynamicdb\internalcallcenter\DyCloudTeleApiLogSearch();
                $searchModelobd->month = $model->month_start_date;
                if ($model->id == 16) {
                    $searchModelobd->from_date_time = '2022-04-14';
                }
                if ($model->id == 28) {
                    $searchModelobd->to_date_time = '2023-04-14';
                }
                $searchModelobd->upsrlm_call_type = 1;
                $searchModelobd->upsrlm_user_id = $md->upsrlm_user_id;
                $dataProviderobd = $searchModelobd->search($searchModelobd, null, 1, \common\models\base\GenralModel::select_cloud_tele_log_columns_no_table_schema());
                $searchModelibd = new \common\models\dynamicdb\internalcallcenter\DyCloudTeleApiLogSearch();
                $searchModelibd->month = $model->month_start_date;
                if ($model->id == 16) {
                    $searchModelibd->from_date_time = '2022-04-14';
                }
                if ($model->id == 28) {
                    $searchModelibd->to_date_time = '2023-04-14';
                }
                $searchModelibd->upsrlm_call_type = 2;
                $searchModelibd->upsrlm_user_id = $md->upsrlm_user_id;
                $dataProvideribd = $searchModelibd->search($searchModelibd, null, 1, \common\models\base\GenralModel::select_cloud_tele_log_columns_no_table_schema());
                $row = [
                    $sr_no,
                    $md->user->name,
                    \Yii::$app->formatter->asDatetime($model->month_start_date, "php:M-Y"),
                    $dataProviderobd->query->count(),
                    $dataProvideribd->query->count()
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
        }
    }

    public function actionMonthreport() {
        $date = new \DateTime('now');
        $date->modify('last day of this month');
        $last_day_month = $date->format('Y-m-d');
        echo "start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        $montn_models = \common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterMonth::find()->where(['status' => 1])->andWhere(['>', 'id', 27])->andWhere(['<', 'id', 40])->all();

        foreach ($montn_models as $model) {
            $file = "month_" . $model->month_start_date . "to" . $model->month_end_date . "_cce_call_reports.csv";
            $file_path = Yii::$app->params['datapath'] . 'tmp/' . 'callcenter/' . $file;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $output = fopen($file_path, 'w');
            fputcsv($output, array(
                'Sr No',
                'CCE Name',
                'Incoming Calls',
                'Outgowing Calls',
                'Attempted Calls',
                'Connected Calls',
                'Total On Call duration',
            ));
            $sr_no = 1;
            $row = [];
            $searchModel = new \common\models\dynamicdb\internalcallcenter\DyCloudTeleApiLogSearch();
            $searchModel->month = $model->month_start_date;
//            if ($model->id == 16) {
//                $searchModel->from_date_time = '2022-04-14';
//            }
//            if ($model->id == 28) {
//                $searchModel->to_date_time = '2023-04-14';
//            }
            $dataProvider = $searchModel->search($searchModel, null, 400, \common\models\base\GenralModel::select_cloud_tele_log_columns_no_table_schema());
            $dataProvider->query->andWhere(['not', ['upsrlm_user_id' => null]]);
            $dataProvider->query->andWhere(['!=', 'upsrlm_user_role', 1]);
            $dataProvider->query->groupBy(['upsrlm_user_id']);
            foreach ($dataProvider->getModels() as $md) {
                $searchModelobd = new \common\models\dynamicdb\internalcallcenter\DyCloudTeleApiLogSearch();
                $searchModelobd->month = $model->month_start_date;
//                if ($model->id == 16) {
//                    $searchModelobd->from_date_time = '2022-04-14';
//                }
//                if ($model->id == 28) {
//                    $searchModelobd->to_date_time = '2023-04-14';
//                }
                $searchModelobd->upsrlm_call_type = 1;
                $searchModelobd->upsrlm_user_id = $md->upsrlm_user_id;
                $dataProviderobd = $searchModelobd->search($searchModelobd, null, 1, \common\models\base\GenralModel::select_cloud_tele_log_columns_no_table_schema());
                $searchModelibd = new \common\models\dynamicdb\internalcallcenter\DyCloudTeleApiLogSearch();
                $searchModelibd->month = $model->month_start_date;
//                if ($model->id == 16) {
//                    $searchModelibd->from_date_time = '2022-04-14';
//                }
//                if ($model->id == 28) {
//                    $searchModelibd->to_date_time = '2023-04-14';
//                }
                $searchModelibd->upsrlm_call_type = 2;
                $searchModelibd->upsrlm_user_id = $md->upsrlm_user_id;
                $dataProvideribd = $searchModelibd->search($searchModelibd, null, 1, \common\models\base\GenralModel::select_cloud_tele_log_columns_no_table_schema());

                $searchModelt = new \common\models\dynamicdb\internalcallcenter\DyCloudTeleApiLogSearch();
                $searchModelt->month = $model->month_start_date;
//                if ($model->id == 16) {
//                    $searchModelt->from_date_time = '2022-04-14';
//                }
//                if ($model->id == 28) {
//                    $searchModelt->to_date_time = '2023-04-14';
//                }
                $searchModelt->upsrlm_user_id = $md->upsrlm_user_id;
                $dataProvidert = $searchModelt->search($searchModelt, null, 1, \common\models\base\GenralModel::select_cloud_tele_log_columns_no_table_schema());
                $row = [
                    $sr_no,
                    $md->user->name,
                    $dataProvideribd->query->count(),
                    $dataProviderobd->query->count(),
                    $dataProvidert->query->count(),
                    $dataProvidert->query->andWhere(['callStatus' => 3])->count(),
                    Utility::seconds2hms($dataProvidert->query->sum('talkDuration'))
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
        }
        echo "end Time : " . date('Y-m-d H:i:s') . PHP_EOL;
    }

    public function actionMonthreportbc($month) {

        $montn_models = \common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterMonth::find()->where(['status' => 1])->andWhere(['=', 'id', $month])->all();

        foreach ($montn_models as $model) {
            if ($model->id == 31) {
                $file = "month_" . \Yii::$app->formatter->asDatetime($model->month_start_date, "php:M-Y") . "_bc_callcenter_" . '2023-07-11' . "to" . '2023-07-31' . "_cce_call_report.csv";
            } else {
                $file = "month_" . \Yii::$app->formatter->asDatetime($model->month_start_date, "php:M-Y") . "_bc_callcenter_" . $model->month_start_date . "to" . $model->month_end_date . "_cce_call_report.csv";
            }
            $file_path = Yii::$app->params['datapath'] . 'tmp/' . 'callcenter/' . $file;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $output = fopen($file_path, 'w');
            fputcsv($output, array(
                'Sr No',
                'CCE Name',
                'Mobile No',
                'Month',
                'Incoming Calls',
                'Outgowing Calls',
                'Attempted Calls',
                'Connected Calls',
                'Ivr Time (second)',
                'Total On Call duration (second)',
                'Total On Call duration',
            ));
            $sr_no = 1;
            $row = [];
            $searchModel = new \common\models\dynamicdb\internalcallcenter\DyCloudTeleApiLogSearch();
            $searchModel->month = $model->month_start_date;
            if ($model->id == 31) {
                $searchModel->from_date_time = '2023-07-11';
            }
            $dataProvider = $searchModel->search($searchModel, null, 400, \common\models\base\GenralModel::select_cloud_tele_log_columns_no_table_schema());
            $dataProvider->query->andWhere(['not', ['upsrlm_user_id' => null]]);
            $dataProvider->query->andWhere(['upsrlm_user_role' => [151, 161]]);
            $dataProvider->query->andWhere(['project_id' => [4, 1]]);
            $dataProvider->query->groupBy(['upsrlm_user_id']);
            foreach ($dataProvider->getModels() as $md) {
                $searchModelobd = new \common\models\dynamicdb\internalcallcenter\DyCloudTeleApiLogSearch();
                $searchModelobd->month = $model->month_start_date;
                if ($model->id == 31) {
                    $searchModelobd->from_date_time = '2023-07-11';
                }
                $searchModelobd->upsrlm_call_type = 1;
                $searchModelobd->project_id = 4;
                $searchModelobd->upsrlm_user_id = $md->upsrlm_user_id;
                $dataProviderobd = $searchModelobd->search($searchModelobd, null, 1, \common\models\base\GenralModel::select_cloud_tele_log_columns_no_table_schema());
                $searchModelibd = new \common\models\dynamicdb\internalcallcenter\DyCloudTeleApiLogSearch();
                $searchModelibd->month = $model->month_start_date;
                if ($model->id == 31) {
                    $searchModelobd->from_date_time = '2023-07-11';
                }
                $searchModelibd->upsrlm_call_type = 2;
                $searchModelibd->upsrlm_user_id = $md->upsrlm_user_id;
                $dataProvideribd = $searchModelibd->search($searchModelibd, null, 1, \common\models\base\GenralModel::select_cloud_tele_log_columns_no_table_schema());

                $searchModelt = new \common\models\dynamicdb\internalcallcenter\DyCloudTeleApiLogSearch();
                $searchModelt->month = $model->month_start_date;
                if ($model->id == 31) {
                    $searchModelt->from_date_time = '2023-07-11';
                }
                $searchModelt->project_id = [1, 4];
                $searchModelt->upsrlm_user_id = $md->upsrlm_user_id;
                $dataProvidert = $searchModelt->search($searchModelt, null, 1, \common\models\base\GenralModel::select_cloud_tele_log_columns_no_table_schema());
                $row = [
                    $sr_no,
                    $md->user->name,
                    $md->user->username,
                    \Yii::$app->formatter->asDatetime($model->month_start_date, "php:M-Y"),
                    $dataProvideribd->query->count(),
                    $dataProviderobd->query->count(),
                    $dataProvidert->query->count(),
                    $dataProvidert->query->andWhere(['callStatus' => 3])->count(),
                    $dataProvidert->query->sum('ivrDuration'),
                    $dataProvidert->query->sum('talkDuration'),
                    Utility::seconds2hms($dataProvidert->query->sum('talkDuration'))
                ];
                fputcsv($output, $row);
                $sr_no++;
            }
        }
    }

    public function actionMpreport() {
         echo "s Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        $montn_models = \common\models\dynamicdb\internalcallcenter\master\CloudTeleMasterMonth::find()->where(['status' => 1])->andWhere(['>', 'id', 13])->andWhere(['<', 'id', 41])->all();
        $file = "monthly_project_call.csv";
        $file_path = Yii::$app->params['datapath'] . 'tmp/' . 'callcenter/' . $file;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $output = fopen($file_path, 'w');
        fputcsv($output, array(
            'Sr No',
            'Month',
            'DBT Call Center',
            'Online Call Center',
            'Ultrapoor Call Center',
            'BC Call Center',
            'Total IBD',
        ));
        $sr_no = 1;
        $row = [];
        foreach ($montn_models as $model) {
            $searchModel1 = new \common\models\dynamicdb\internalcallcenter\DyCloudTeleApiLogSearch();
            $searchModel1->month = $model->month_start_date;
            $searchModel1->upsrlm_call_type = 1;
            $searchModel1->project_id = 1;
            $dataProvider1 = $searchModel1->search($searchModel1, null, 1, \common\models\base\GenralModel::select_cloud_tele_log_columns_no_table_schema());
            $searchModel2 = new \common\models\dynamicdb\internalcallcenter\DyCloudTeleApiLogSearch();
            $searchModel2->month = $model->month_start_date;
            $searchModel2->upsrlm_call_type = 1;
            $searchModel2->project_id = 2;
            $dataProvider2 = $searchModel2->search($searchModel2, null, 1, \common\models\base\GenralModel::select_cloud_tele_log_columns_no_table_schema());
            $searchModel3 = new \common\models\dynamicdb\internalcallcenter\DyCloudTeleApiLogSearch();
            $searchModel3->month = $model->month_start_date;
            $searchModel3->upsrlm_call_type = 1;
            $searchModel3->project_id = 3;
            $dataProvider3 = $searchModel3->search($searchModel3, null, 1, \common\models\base\GenralModel::select_cloud_tele_log_columns_no_table_schema());
            $searchModel4 = new \common\models\dynamicdb\internalcallcenter\DyCloudTeleApiLogSearch();
            $searchModel4->month = $model->month_start_date;
            $searchModel4->upsrlm_call_type = 1;
            $searchModel4->project_id = 4;
            $dataProvider4 = $searchModel4->search($searchModel4, null, 1, \common\models\base\GenralModel::select_cloud_tele_log_columns_no_table_schema());
            $searchModelibd = new \common\models\dynamicdb\internalcallcenter\DyCloudTeleApiLogSearch();
            $searchModelibd->month = $model->month_start_date;
            $searchModelibd->upsrlm_call_type = 2;
            $dataProvideribd = $searchModelibd->search($searchModelibd, null, 1, \common\models\base\GenralModel::select_cloud_tele_log_columns_no_table_schema());
            $row = [
                $sr_no,
                \Yii::$app->formatter->asDatetime($model->month_start_date, "php:M-Y"),
                $dataProvider1->query->count(),
                $dataProvider2->query->count(),
                $dataProvider3->query->count(),
                $dataProvider4->query->count(),
                $dataProvideribd->query->count()
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
         echo "end Time : " . date('Y-m-d H:i:s') . PHP_EOL;
    }
}
