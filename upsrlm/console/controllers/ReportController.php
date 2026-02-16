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
use bc\models\BcCumulativeReportDistrictPartnerBank;
use bc\models\BcCumulativeReportBlockPartnerBank;
use bc\modules\selection\models\DistrictPartnerGramPanchayatPerformance;
use bc\modules\transaction\models\summary\BcTransactionMasterMonth;
use bc\models\master\MasterGramPanchayatDetailBc;
use console\helpers\Utility;

class ReportController extends Controller {

    public $id = 0;
    public $district_code = 0;
    public $district_name = 'Uttar Pradesh';
    public $master_partner_bank_id = 0;
    public $partner_bank_name = 'Bank Of Baroda,FINO Payment Bank,Nearby Technologies Pvt. Ltd.,Manipal Technologies Limited,MFSL-Airtel-GVI Consortia,Paytm Payment Bank';
    public $blocked_bc = 0;
    public $certified_bc = 0;
    public $agree = 0;
    public $unwilling = 0;
    public $registered = 0;
    public $not_certified = 0;
    public $ineligible = 0;
    public $absent = 0;
    public $onboard_bc = 0;
    public $pvr = 0;
    public $shg_assigned = 0;
    public $bc_shg_bank_verified = 0;
    public $pfms_mapping = 0;
    public $bc_support_fund_shg_transfer = 0;
    public $bc_support_fund_shg_acknowledge = 0;
    public $handheld_machine_provided = 0;
    public $handheld_machine_acknowledge = 0;
    public $operational = 0;
    public $bc_bank_transaction = 0;
    public $no_of_bc_shortlisted = 0;
    public $urban = 0;
    public $no_of_training_conculded = 0;
    public $no_of_training_planned = 0;
    public $no_of_bc_appeared_training = 0;
    public $no_of_bc_registered = 0;
    public $no_of_gp = 0;
    public $no_of_unwilling = 0;
    public $bc_bank_transaction_avg_amt = 0;
    public $bc_bank_transaction_count = 0;
    public $honorarium_payment_to_bc = 0;
    public $date;
    public $last_updated_on;
    public $month3;
    public $month2;
    public $month1;
    public $from_month_id;
    public $to_month_id;

    public function beforeAction($action) {
        $this->month1 = date('Y-m-01', strtotime(date('Y-m-01') . " -1 months"));
        $this->month2 = date('Y-m-01', strtotime(date('Y-m-01') . " -2 months"));
        $this->month3 = date('Y-m-01', strtotime(date('Y-m-01') . " -3 months"));
        $ts = BcTransactionMasterMonth::find()->where(['month_start_date' => $this->month3])->one();
        $tl = BcTransactionMasterMonth::find()->where(['month_start_date' => $this->month1])->one();
        if ($ts != null) {
            $this->from_month_id = $ts->id;
        }
        if ($tl != null) {
            $this->to_month_id = $tl->id;
        }
        return parent::beforeAction($action);
    }

    public function actionBcdistrict() {
        //\Yii::$app->runAction('transactions/removed');
        $models_district = MasterDistrict::find()->orderBy('district_name asc')->all();
        foreach ($models_district as $md) {
            $user_model = \common\models\User::findOne(19852);
//            $user_model = \common\models\User::findOne(1);
            $searchModel = new RsetisBatchParticipantsSearch();
            $searchModel->district_code = $md->district_code;

            $dPcertified = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPcertified->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dPcertified->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dPonboard = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPonboard->query->andWhere(['srlm_bc_application.onboarding' => 1]);
            $dPonboard->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dPpvr = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPpvr->query->andWhere(['srlm_bc_application.pvr_status' => 1]);
            $dPpvr->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dPpvr->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dPassignshg = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPassignshg->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dPassignshg->query->andWhere(['not', ['srlm_bc_application.cbo_shg_id' => NULL]]);
            $dPassignshg->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dPBankVer = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPBankVer->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dPBankVer->query->andWhere(['srlm_bc_application.bc_bank' => 2, 'srlm_bc_application.shg_bank' => 2]);
            $dPBankVer->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dPPfms = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPPfms->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dPPfms->query->andWhere(['srlm_bc_application.pfms_maped_status' => 1]);
            $dPPfms->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dPsftrans = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPsftrans->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dPsftrans->query->andWhere(['srlm_bc_application.bc_shg_funds_status' => 1]);
            $dPsftrans->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dPsfack = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPsfack->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dPsfack->query->andWhere(['srlm_bc_application.bc_support_funds_received' => 1]);
            $dPsfack->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dPhhmave = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPhhmave->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dPhhmave->query->andWhere(['srlm_bc_application.handheld_machine_status' => 1]);
            $dPhhmave->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dPhhmack = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPhhmack->query->andWhere(['srlm_bc_application.bc_handheld_machine_recived' => 1]);
            $dPhhmack->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $bc_bank_transaction = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->joinWith(['gp'])->where(['bc_transaction_bc_summary.district_code' => $md->district_code, 'master_gram_panchayat.status' => 1, 'bc_status' => 1])->sum('transaction_amount');

            $modelt = RsetisCenter::findOne(['district_code' => $md->district_code]);
            $rep_dis_model = BcCumulativeReportDistrict::findOne(['district_code' => $md->district_code, 'date' => date('Y-m-d')]);
            if ($rep_dis_model == null) {
                $rep_dis_model = new BcCumulativeReportDistrict();
            }
            $rep_dis_model->district_code = $md->district_code;
            $rep_dis_model->district_name = $md->district_name;
            $rep_dis_model->master_partner_bank_id = $md->partnerbank->master_partner_bank_id;
            $rep_dis_model->partner_bank_name = $md->partnerbank->parnerbank->bank_name;

            $rep_dis_model->blocked_bc = SrlmBcApplication::find()->where(['district_code' => $md->district_code])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['!=', 'srlm_bc_application.blocked', 0])->count();
            $rep_dis_model->certified_bc = $dPcertified->query->count();
            $rep_dis_model->agree = SrlmBcApplication::find()->where(['district_code' => $md->district_code, 'training_status' => 1])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $rep_dis_model->in_batch = SrlmBcApplication::find()->where(['district_code' => $md->district_code, 'training_status' => 2])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $rep_dis_model->unwilling = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.district_code' => $md->district_code])->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_UNWILLING, SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING]])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $rep_dis_model->registered = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.district_code' => $md->district_code])->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $rep_dis_model->not_certified = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.district_code' => $md->district_code])->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_FAIL])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $rep_dis_model->ineligible = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.district_code' => $md->district_code])->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $rep_dis_model->absent = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.district_code' => $md->district_code])->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_ABSENT])->andWhere(['srlm_bc_application.blocked' => 0])->count();

            $rep_dis_model->onboard_bc = $dPonboard->query->count();
            $rep_dis_model->pvr = $dPpvr->query->count();
            $rep_dis_model->shg_assigned = $dPassignshg->query->count();

            $rep_dis_model->bc_shg_bank_verified = $dPBankVer->query->count();
            $rep_dis_model->pfms_mapping = $dPPfms->query->count();
            $rep_dis_model->bc_support_fund_shg_transfer = $dPsftrans->query->count();

            $rep_dis_model->bc_support_fund_shg_acknowledge = $dPsfack->query->count();
            $rep_dis_model->handheld_machine_provided = $dPhhmave->query->count();
            $rep_dis_model->handheld_machine_acknowledge = $dPhhmack->query->count();
            $rep_dis_model->operational = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->joinWith(['gp'])->where(['bc_transaction_bc_summary.district_code' => $md->district_code, 'master_gram_panchayat.status' => 1, 'bc_status' => 1])->count();
            $rep_dis_model->bc_bank_transaction = isset($bc_bank_transaction) ? $bc_bank_transaction : 0;
            $rep_dis_model->bc_bank_transaction_count = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->joinWith(['gp'])->where(['bc_transaction_bc_summary.district_code' => $md->district_code, 'master_gram_panchayat.status' => 1, 'bc_status' => 1])->count();
            //$rep_dis_model->no_of_bc_shortlisted = SrlmBcApplication::find()->where(['district_code' => $md->district_code, 'gender' => 2, 'form_number' => 6, 'status' => 2])->andWhere(['not in', 'srlm_bc_application.selection_by', [15]])->count();
            $rep_dis_model->no_of_bc_shortlisted = SrlmBcApplication::find()->where(['district_code' => $md->district_code, 'gender' => 2, 'form_number' => 6, 'status' => 2])->count();
            $rep_dis_model->urban = SrlmBcApplication::find()->where(['district_code' => $md->district_code, 'gender' => 2, 'form_number' => 6, 'status' => 2])->andWhere(['srlm_bc_application.urban_shg' => 1])->count();
            $rep_dis_model->no_of_training_conculded = $modelt->nooftrainingfinished;
            $rep_dis_model->no_of_training_planned = $modelt->nooftrainingplaned;
            $rep_dis_model->no_of_gp = $modelt->total_gp;
            $rep_dis_model->no_of_unwilling = SrlmBcApplication::find()->where(['district_code' => $md->district_code, 'bc_unwilling_rsetis' => 1])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $rep_dis_model->no_of_bc_appeared_training = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.district_code' => $md->district_code])->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_UNWILLING, 34, 35]])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $rep_dis_model->no_of_bc_registered = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.district_code' => $md->district_code])->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH, SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_UNWILLING, SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING, 34, 35]])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $rep_dis_model->date = new \yii\db\Expression('NOW()');
            $rep_dis_model->last_updated_on = new \yii\db\Expression('NOW()');
            $rep_dis_model->save();
            $rep_dis_model = BcCumulativeReportDistrict::findOne($rep_dis_model->id);
            $this->blocked_bc = $this->blocked_bc + $rep_dis_model->blocked_bc;
            $this->certified_bc = $this->certified_bc + $rep_dis_model->certified_bc;
            $this->agree = $this->agree + $rep_dis_model->agree;
            $this->unwilling = $this->unwilling + $rep_dis_model->unwilling;
            $this->registered = $this->registered + $rep_dis_model->registered;
            $this->not_certified = $this->blocked_bc + $rep_dis_model->not_certified;
            $this->ineligible = $this->ineligible + $rep_dis_model->ineligible;
            $this->absent = $this->absent + $rep_dis_model->absent;
            $this->onboard_bc = $this->onboard_bc + $rep_dis_model->onboard_bc;
            $this->pvr = $this->pvr + $rep_dis_model->pvr;
            $this->shg_assigned = $this->shg_assigned + $rep_dis_model->shg_assigned;
            $this->bc_shg_bank_verified = $this->bc_shg_bank_verified + $rep_dis_model->bc_shg_bank_verified;
            $this->pfms_mapping = $this->pfms_mapping + $rep_dis_model->pfms_mapping;
            $this->bc_support_fund_shg_transfer = $this->bc_support_fund_shg_transfer + $rep_dis_model->bc_support_fund_shg_transfer;
            $this->bc_support_fund_shg_acknowledge = $this->bc_support_fund_shg_acknowledge + $rep_dis_model->bc_support_fund_shg_acknowledge;
            $this->handheld_machine_provided = $this->handheld_machine_provided + $rep_dis_model->handheld_machine_provided;
            $this->handheld_machine_acknowledge = $this->handheld_machine_acknowledge + $rep_dis_model->handheld_machine_acknowledge;
            $this->operational = $this->operational + $rep_dis_model->operational;
            $this->bc_bank_transaction = $this->bc_bank_transaction + $rep_dis_model->bc_bank_transaction;
            $this->no_of_bc_shortlisted = $this->no_of_bc_shortlisted + $rep_dis_model->no_of_bc_shortlisted;
            $this->urban = $this->urban + $rep_dis_model->urban;
            $this->no_of_training_conculded = $this->no_of_training_conculded + $rep_dis_model->no_of_training_conculded;
            $this->no_of_training_planned = $this->no_of_training_planned + $rep_dis_model->no_of_training_planned;
            $this->no_of_bc_appeared_training = $this->no_of_bc_appeared_training + $rep_dis_model->no_of_bc_appeared_training;
            $this->no_of_bc_registered = $this->no_of_bc_registered + $rep_dis_model->no_of_bc_registered;
            $this->no_of_gp = $this->no_of_gp + $rep_dis_model->no_of_gp;
            $this->no_of_unwilling = $this->no_of_unwilling + $rep_dis_model->no_of_unwilling;
            $this->bc_bank_transaction_avg_amt = $this->bc_bank_transaction_avg_amt + $rep_dis_model->bc_bank_transaction_avg_amt;
            $this->bc_bank_transaction_count = $this->bc_bank_transaction_count + $rep_dis_model->bc_bank_transaction_count;
            $this->honorarium_payment_to_bc = $this->honorarium_payment_to_bc + $rep_dis_model->honorarium_payment_to_bc;
            $this->date = $rep_dis_model->date;
            $this->last_updated_on = $rep_dis_model->last_updated_on;
        }
        $array = BcCumulativeReportDistrict::find()->where(['date' => date('Y-m-d')])->asArray()->all();
        $over_all = [
            'id' => 0,
            'district_code' => $this->district_code,
            'district_name' => $this->district_name,
            'master_partner_bank_id' => $this->master_partner_bank_id,
            'partner_bank_name' => $this->partner_bank_name,
            'blocked_bc' => $this->blocked_bc,
            'certified_bc' => $this->certified_bc,
            'agree' => $this->agree,
            'unwilling' => $this->unwilling,
            'registered' => $this->registered,
            'not_certified' => $this->not_certified,
            'ineligible' => $this->ineligible,
            'absent' => $this->absent,
            'onboard_bc' => $this->onboard_bc,
            'pvr' => $this->pvr,
            'shg_assigned' => $this->shg_assigned,
            'bc_shg_bank_verified' => $this->bc_shg_bank_verified,
            'pfms_mapping' => $this->pfms_mapping,
            'bc_support_fund_shg_transfer' => $this->bc_support_fund_shg_transfer,
            'bc_support_fund_shg_acknowledge' => $this->bc_support_fund_shg_acknowledge,
            'handheld_machine_provided' => $this->handheld_machine_provided,
            'handheld_machine_acknowledge' => $this->handheld_machine_acknowledge,
            'operational' => $this->operational,
            'bc_bank_transaction' => $this->bc_bank_transaction,
            'no_of_bc_shortlisted' => $this->no_of_bc_shortlisted,
            'urban' => $this->urban,
            'no_of_training_conculded' => $this->no_of_training_conculded,
            'no_of_training_planned' => $this->no_of_training_planned,
            'no_of_bc_appeared_training' => $this->no_of_bc_appeared_training,
            'no_of_bc_registered' => $this->no_of_bc_registered,
            'no_of_gp' => $this->no_of_gp,
            'no_of_unwilling' => $this->no_of_unwilling,
            'bc_bank_transaction_avg_amt' => $this->bc_bank_transaction_avg_amt,
            'bc_bank_transaction_count' => $this->bc_bank_transaction_count,
            'honorarium_payment_to_bc' => $this->honorarium_payment_to_bc,
            'date' => $this->date,
            'last_updated_on' => $this->last_updated_on,
        ];
        array_push($array, $over_all);
        \yii\helpers\ArrayHelper::multisort($array, ['id'], [SORT_ASC]);
        $fp = fopen(Yii::$app->params['bcdatapath'] . 'bcselection/report/' . 'districts.json', 'w');
        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
        fclose($fp);
    }

    public function actionBcblock() {
        $models_blocks = \bc\models\master\MasterBlock::find()->where(['status' => 1])->orderBy([
                    'district_name' => SORT_ASC,
                    'block_name' => SORT_ASC
                ])->all();
        foreach ($models_blocks as $md) {
//            if($md->block_code=='978'){
            $user_model = \common\models\User::findOne(19852);
//            $user_model = \common\models\User::findOne(1);
            $searchModel = new RsetisBatchParticipantsSearch();
            $searchModel->block_code = $md->block_code;

            $dPcertified = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPcertified->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dPcertified->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dPonboard = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPonboard->query->andWhere(['srlm_bc_application.onboarding' => 1]);
            $dPonboard->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dPpvr = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPpvr->query->andWhere(['srlm_bc_application.pvr_status' => 1]);
            $dPpvr->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dPpvr->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dPassignshg = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPassignshg->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dPassignshg->query->andWhere(['not', ['srlm_bc_application.cbo_shg_id' => NULL]]);
            $dPassignshg->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dPBankVer = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPBankVer->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dPBankVer->query->andWhere(['srlm_bc_application.bc_bank' => 2, 'srlm_bc_application.shg_bank' => 2]);
            $dPBankVer->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dPPfms = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPPfms->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dPPfms->query->andWhere(['srlm_bc_application.pfms_maped_status' => 1]);
            $dPPfms->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dPsftrans = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPsftrans->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dPsftrans->query->andWhere(['srlm_bc_application.bc_shg_funds_status' => 1]);
            $dPsftrans->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dPsfack = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPsfack->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dPsfack->query->andWhere(['srlm_bc_application.bc_support_funds_received' => 1]);
            $dPsfack->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dPhhmave = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPhhmave->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
            $dPhhmave->query->andWhere(['srlm_bc_application.handheld_machine_status' => 1]);
            $dPhhmave->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $dPhhmack = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
            $dPhhmack->query->andWhere(['srlm_bc_application.bc_handheld_machine_recived' => 1]);
            $dPhhmack->query->andWhere(['srlm_bc_application.blocked' => 0]);
            $bc_bank_transaction = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->joinWith(['gp'])->where(['bc_transaction_bc_summary.block_code' => $md->block_code, 'master_gram_panchayat.status' => 1, 'bc_status' => 1])->sum('transaction_amount');
            $rep_block_model = \bc\models\BcCumulativeReportBlock::findOne(['block_code' => $md->block_code, 'date' => date('Y-m-d')]);
            if ($rep_block_model == null) {
                $rep_block_model = new \bc\models\BcCumulativeReportBlock();
            }
            $modeldpb = MasterDistrict::find()->where(['district_code' => $md->district_code])->one();
            $rep_block_model->district_code = $md->district_code;
            $rep_block_model->district_name = $md->district_name;
            $rep_block_model->block_code = $md->block_code;
            $rep_block_model->block_name = $md->block_name;
            $rep_block_model->master_partner_bank_id = $modeldpb->partnerbank->master_partner_bank_id;
            $rep_block_model->partner_bank_name = $modeldpb->partnerbank->parnerbank->bank_name;
            $rep_block_model->blocked_bc = SrlmBcApplication::find()->where(['block_code' => $md->block_code])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['!=', 'srlm_bc_application.blocked', 0])->count();
            $rep_block_model->certified_bc = $dPcertified->query->count();
            $rep_block_model->agree = SrlmBcApplication::find()->where(['block_code' => $md->block_code, 'training_status' => 1])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $rep_block_model->in_batch = SrlmBcApplication::find()->where(['block_code' => $md->block_code, 'training_status' => 2])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $rep_block_model->unwilling = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.block_code' => $md->block_code])->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_UNWILLING, SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING]])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $rep_block_model->registered = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.block_code' => $md->block_code])->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $rep_block_model->not_certified = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.block_code' => $md->block_code])->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_FAIL])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $rep_block_model->ineligible = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.block_code' => $md->block_code])->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $rep_block_model->absent = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.block_code' => $md->block_code])->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_ABSENT])->andWhere(['srlm_bc_application.blocked' => 0])->count();

            $rep_block_model->onboard_bc = $dPonboard->query->count();
            $rep_block_model->pvr = $dPpvr->query->count();
            $rep_block_model->shg_assigned = $dPassignshg->query->count();

            $rep_block_model->bc_shg_bank_verified = $dPBankVer->query->count();
            $rep_block_model->pfms_mapping = $dPPfms->query->count();
            $rep_block_model->bc_support_fund_shg_transfer = $dPsftrans->query->count();

            $rep_block_model->bc_support_fund_shg_acknowledge = $dPsfack->query->count();
            $rep_block_model->handheld_machine_provided = $dPhhmave->query->count();
            $rep_block_model->handheld_machine_acknowledge = $dPhhmack->query->count();
            $rep_block_model->operational = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->joinWith(['gp'])->where(['bc_transaction_bc_summary.block_code' => $md->block_code, 'master_gram_panchayat.status' => 1, 'bc_status' => 1])->groupBy(['bc_application_id'])->count();
            $rep_block_model->bc_bank_transaction = isset($bc_bank_transaction) ? $bc_bank_transaction : 0;
            $rep_block_model->bc_bank_transaction_count = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->joinWith(['gp'])->where(['bc_transaction_bc_summary.block_code' => $md->block_code, 'master_gram_panchayat.status' => 1, 'bc_status' => 1])->count();
            //$rep_block_model->no_of_bc_shortlisted = SrlmBcApplication::find()->where(['block_code' => $md->block_code])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['not in', 'srlm_bc_application.selection_by', [15]])->count();
            $rep_block_model->no_of_bc_shortlisted = SrlmBcApplication::find()->where(['block_code' => $md->block_code])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->count();

            $rep_block_model->urban = SrlmBcApplication::find()->where(['block_code' => $md->block_code])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['srlm_bc_application.urban_shg' => 1])->count();
            $rep_block_model->no_of_training_conculded = 0;
            $rep_block_model->no_of_training_planned = 0;
            $rep_block_model->no_of_gp = \bc\models\master\MasterGramPanchayat::find()->where(['block_code' => $md->block_code, 'status' => 1])->count();
            $rep_block_model->no_of_unwilling = SrlmBcApplication::find()->where(['block_code' => $md->block_code, 'bc_unwilling_rsetis' => 1])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $rep_block_model->no_of_bc_appeared_training = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.block_code' => $md->block_code])->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_UNWILLING, 34, 35]])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $rep_block_model->no_of_bc_registered = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.block_code' => $md->block_code])->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH, SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_UNWILLING, SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING, 34, 35]])->andWhere(['srlm_bc_application.blocked' => 0])->count();
            $rep_block_model->date = new \yii\db\Expression('NOW()');
            $rep_block_model->last_updated_on = new \yii\db\Expression('NOW()');
            $rep_block_model->save();
//            print_r($rep_block_model);
//        }
        }
        $array = \bc\models\BcCumulativeReportBlock::find()->where(['date' => date('Y-m-d')])->asArray()->all();
        $fp = fopen(Yii::$app->params['bcdatapath'] . 'bcselection/report/' . 'blocks.json', 'w');
        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
        fclose($fp);
    }

    public function actionBcdistrictbank() {
        echo "District start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        $models_district = MasterDistrict::find()->orderBy('district_name asc')->all();
        foreach ($models_district as $md) {
            $user_model = \common\models\User::findOne(19852);
            //$parner_bank = \bc\models\master\MasterGramPanchayat::find()->select(['master_partner_bank_id'])->distinct()->where(['master_gram_panchayat.district_code' => $md->district_code, 'master_gram_panchayat.status' => 1])->all();
            $parner_bank = SrlmBcApplication::find()->select(['master_partner_bank_id'])->distinct()->where(['district_code' => $md->district_code, 'status' => 2, 'urban_shg' => 0])->all();
            foreach ($parner_bank as $bank) {
                $searchModel = new RsetisBatchParticipantsSearch();
                $searchModel->district_code = $md->district_code;
                $dPcertified = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                $dPcertified->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
                $dPcertified->query->andWhere(['srlm_bc_application.blocked' => 0]);
                $dPcertified->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);

                $dPonboard = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                $dPonboard->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
                $dPonboard->query->andWhere(['srlm_bc_application.onboarding' => 1]);
                $dPonboard->query->andWhere(['srlm_bc_application.blocked' => 0]);
                $dPonboard->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);
                $dPpvr = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                $dPpvr->query->andWhere(['srlm_bc_application.pvr_status' => 1]);
                $dPpvr->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
                $dPpvr->query->andWhere(['srlm_bc_application.blocked' => 0]);
                $dPpvr->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);
                $dPassignshg = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                $dPassignshg->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
                $dPassignshg->query->andWhere(['not', ['srlm_bc_application.cbo_shg_id' => NULL]]);
                $dPassignshg->query->andWhere(['srlm_bc_application.blocked' => 0]);
                $dPassignshg->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);
                $dPBankVer = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                $dPBankVer->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
                $dPBankVer->query->andWhere(['srlm_bc_application.bc_bank' => 2, 'srlm_bc_application.shg_bank' => 2]);
                $dPBankVer->query->andWhere(['srlm_bc_application.blocked' => 0]);
                $dPBankVer->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);
                $dPPfms = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                $dPPfms->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
                $dPPfms->query->andWhere(['srlm_bc_application.pfms_maped_status' => 1]);
                $dPPfms->query->andWhere(['srlm_bc_application.blocked' => 0]);
                $dPPfms->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);
                $dPsftrans = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                $dPsftrans->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
                $dPsftrans->query->andWhere(['srlm_bc_application.bc_shg_funds_status' => 1]);
                $dPsftrans->query->andWhere(['srlm_bc_application.blocked' => 0]);
                $dPsftrans->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);
                $dPsfack = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                $dPsfack->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
                $dPsfack->query->andWhere(['srlm_bc_application.bc_support_funds_received' => 1]);
                $dPsfack->query->andWhere(['srlm_bc_application.blocked' => 0]);
                $dPsfack->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);
                $dPhhmave = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                $dPhhmave->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
                $dPhhmave->query->andWhere(['srlm_bc_application.handheld_machine_status' => 1]);
                $dPhhmave->query->andWhere(['srlm_bc_application.blocked' => 0]);
                $dPhhmave->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);
                $dPhhmack = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                $dPhhmack->query->andWhere(['srlm_bc_application.bc_handheld_machine_recived' => 1]);
                $dPhhmack->query->andWhere(['srlm_bc_application.blocked' => 0]);
                $dPhhmack->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);
                $bc_bank_transaction = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->joinWith(['gp'])->where(['bc_transaction_bc_summary.district_code' => $md->district_code, 'master_gram_panchayat.status' => 1, 'bc_transaction_bc_summary.master_partner_bank_id' => $bank->master_partner_bank_id, 'bc_status' => 1])->sum('transaction_amount');
                $modelt = RsetisCenter::findOne(['district_code' => $md->district_code]);
                $rep_dis_model = BcCumulativeReportDistrictPartnerBank::findOne(['district_code' => $md->district_code, 'date' => date('Y-m-d'), 'master_partner_bank_id' => $bank->master_partner_bank_id]);
                if ($rep_dis_model == null) {
                    $rep_dis_model = new BcCumulativeReportDistrictPartnerBank();
                }
                $rep_dis_model->district_code = $md->district_code;
                $rep_dis_model->district_name = $md->district_name;
                $rep_dis_model->master_partner_bank_id = $bank->master_partner_bank_id;
                $rep_dis_model->partner_bank_name = $bank->cbank->bank_name;

                $rep_dis_model->blocked_bc = SrlmBcApplication::find()->where(['district_code' => $md->district_code])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['!=', 'srlm_bc_application.blocked', 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                $rep_dis_model->certified_bc = $dPcertified->query->count();
                $rep_dis_model->agree = SrlmBcApplication::find()->where(['district_code' => $md->district_code, 'training_status' => 1])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                $rep_dis_model->in_batch = SrlmBcApplication::find()->where(['district_code' => $md->district_code, 'training_status' => 2])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                $rep_dis_model->unwilling = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.district_code' => $md->district_code])->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_UNWILLING, SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING]])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                $rep_dis_model->registered = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.district_code' => $md->district_code])->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                $rep_dis_model->not_certified = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.district_code' => $md->district_code])->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_FAIL])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                $rep_dis_model->ineligible = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.district_code' => $md->district_code])->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                $rep_dis_model->absent = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.district_code' => $md->district_code])->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_ABSENT])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();

                $rep_dis_model->onboard_bc = $dPonboard->query->count();
                $rep_dis_model->pvr = $dPpvr->query->count();
                $rep_dis_model->shg_assigned = $dPassignshg->query->count();

                $rep_dis_model->bc_shg_bank_verified = $dPBankVer->query->count();
                $rep_dis_model->pfms_mapping = $dPPfms->query->count();
                $rep_dis_model->bc_support_fund_shg_transfer = $dPsftrans->query->count();

                $rep_dis_model->bc_support_fund_shg_acknowledge = $dPsfack->query->count();
                $rep_dis_model->handheld_machine_provided = $dPhhmave->query->count();
                $rep_dis_model->handheld_machine_acknowledge = $dPhhmack->query->count();
                $rep_dis_model->operational = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->joinWith(['gp'])->where(['bc_transaction_bc_summary.district_code' => $md->district_code, 'master_gram_panchayat.status' => 1])->andWhere(['bc_transaction_bc_summary.master_partner_bank_id' => $bank->master_partner_bank_id, 'bc_status' => 1])->count();
                $rep_dis_model->bc_bank_transaction = isset($bc_bank_transaction) ? $bc_bank_transaction : 0;
                $rep_dis_model->bc_bank_transaction_count = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->joinWith(['gp'])->where(['bc_transaction_bc_summary.district_code' => $md->district_code, 'master_gram_panchayat.status' => 1, 'bc_transaction_bc_summary.master_partner_bank_id' => $bank->master_partner_bank_id, 'bc_status' => 1])->count();

                $rep_dis_model->no_of_bc_shortlisted = SrlmBcApplication::find()->where(['district_code' => $md->district_code, 'gender' => 2, 'form_number' => 6, 'status' => 2])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                $rep_dis_model->urban = SrlmBcApplication::find()->where(['district_code' => $md->district_code, 'gender' => 2, 'form_number' => 6, 'status' => 2])->andWhere(['srlm_bc_application.urban_shg' => 1])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                $rep_dis_model->no_of_training_conculded = $modelt->nooftrainingfinished;
                $rep_dis_model->no_of_training_planned = $modelt->nooftrainingplaned;
                $rep_dis_model->no_of_gp = \bc\models\master\MasterGramPanchayat::find()->select(['gram_panchayat_code'])->distinct()->where(['district_code' => $md->district_code, 'status' => 1])->andWhere(['master_gram_panchayat.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                $rep_dis_model->no_of_unwilling = SrlmBcApplication::find()->where(['district_code' => $md->district_code, 'bc_unwilling_rsetis' => 1])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                $rep_dis_model->no_of_bc_appeared_training = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.district_code' => $md->district_code])->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_UNWILLING, 34, 35]])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                $rep_dis_model->no_of_bc_registered = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.district_code' => $md->district_code])->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH, SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_UNWILLING, SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING, 34, 35]])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                $rep_dis_model->date = new \yii\db\Expression('NOW()');
                $rep_dis_model->last_updated_on = new \yii\db\Expression('NOW()');
                $rep_dis_model->save();
            }
        }

        echo "District End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
    }

    public function actionBcblockbank() {
        echo "Block start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        try {


            $models_blocks = \bc\models\master\MasterBlock::find()->where(['status' => 1])->orderBy([
                        'district_name' => SORT_ASC,
                        'block_name' => SORT_ASC
                    ])->all();
            foreach ($models_blocks as $md) {
//            echo $md->block_name.PHP_EOL;
//            if($md->block_code=='978'){
                //$parner_bank = \bc\models\master\MasterGramPanchayat::find()->select(['master_partner_bank_id'])->distinct()->where(['master_gram_panchayat.block_code' => $md->block_code, 'master_gram_panchayat.status' => 1])->all();
                $parner_bank = SrlmBcApplication::find()->select(['master_partner_bank_id'])->distinct()->where(['block_code' => $md->block_code, 'status' => 2, 'urban_shg' => 0])->all();
                $user_model = \common\models\User::findOne(19852);
                foreach ($parner_bank as $bank) {
                    //echo $bank->master_partner_bank_id.PHP_EOL;
                    $searchModel = new RsetisBatchParticipantsSearch();
                    $searchModel->block_code = $md->block_code;

                    $dPcertified = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                    $dPcertified->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
                    $dPcertified->query->andWhere(['srlm_bc_application.blocked' => 0]);
                    $dPcertified->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);
                    $dPonboard = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                    $dPonboard->query->andWhere(['srlm_bc_application.onboarding' => 1]);
                    $dPonboard->query->andWhere(['srlm_bc_application.blocked' => 0]);
                    $dPonboard->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);
                    $dPpvr = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                    $dPpvr->query->andWhere(['srlm_bc_application.pvr_status' => 1]);
                    $dPpvr->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
                    $dPpvr->query->andWhere(['srlm_bc_application.blocked' => 0]);
                    $dPpvr->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);
                    $dPassignshg = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                    $dPassignshg->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
                    $dPassignshg->query->andWhere(['not', ['srlm_bc_application.cbo_shg_id' => NULL]]);
                    $dPassignshg->query->andWhere(['srlm_bc_application.blocked' => 0]);
                    $dPassignshg->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);
                    $dPBankVer = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                    $dPBankVer->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
                    $dPBankVer->query->andWhere(['srlm_bc_application.bc_bank' => 2, 'srlm_bc_application.shg_bank' => 2]);
                    $dPBankVer->query->andWhere(['srlm_bc_application.blocked' => 0]);
                    $dPBankVer->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);
                    $dPPfms = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                    $dPPfms->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
                    $dPPfms->query->andWhere(['srlm_bc_application.pfms_maped_status' => 1]);
                    $dPPfms->query->andWhere(['srlm_bc_application.blocked' => 0]);
                    $dPPfms->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);
                    $dPsftrans = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                    $dPsftrans->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
                    $dPsftrans->query->andWhere(['srlm_bc_application.bc_shg_funds_status' => 1]);
                    $dPsftrans->query->andWhere(['srlm_bc_application.blocked' => 0]);
                    $dPsftrans->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);
                    $dPsfack = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                    $dPsfack->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
                    $dPsfack->query->andWhere(['srlm_bc_application.bc_support_funds_received' => 1]);
                    $dPsfack->query->andWhere(['srlm_bc_application.blocked' => 0]);
                    $dPsfack->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);
                    $dPhhmave = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                    $dPhhmave->query->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_PASS]);
                    $dPhhmave->query->andWhere(['srlm_bc_application.handheld_machine_status' => 1]);
                    $dPhhmave->query->andWhere(['srlm_bc_application.blocked' => 0]);
                    $dPhhmave->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);
                    $dPhhmack = $searchModel->search($searchModel, $user_model, \Yii::$app->params['page_size30']);
                    $dPhhmack->query->andWhere(['srlm_bc_application.bc_handheld_machine_recived' => 1]);
                    $dPhhmack->query->andWhere(['srlm_bc_application.blocked' => 0]);
                    $dPhhmack->query->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id]);
                    $bc_bank_transaction = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->joinWith(['gp'])->where(['bc_transaction_bc_summary.block_code' => $md->block_code, 'master_gram_panchayat.status' => 1])->andWhere(['bc_transaction_bc_summary.master_partner_bank_id' => $bank->master_partner_bank_id, 'bc_status' => 1])->sum('transaction_amount');
                    $rep_block_model = \bc\models\BcCumulativeReportBlockPartnerBank::findOne(['block_code' => $md->block_code, 'date' => date('Y-m-d'), 'master_partner_bank_id' => $bank->master_partner_bank_id]);
                    if ($rep_block_model == null) {
                        $rep_block_model = new \bc\models\BcCumulativeReportBlockPartnerBank();
                    }
                    $modeldpb = MasterDistrict::find()->where(['district_code' => $md->district_code])->one();
                    $rep_block_model->district_code = $md->district_code;
                    $rep_block_model->district_name = $md->district_name;
                    $rep_block_model->block_code = $md->block_code;
                    $rep_block_model->block_name = $md->block_name;
                    $rep_block_model->master_partner_bank_id = $bank->master_partner_bank_id;
                    $rep_block_model->partner_bank_name = $bank->cbank->bank_name;
                    $rep_block_model->blocked_bc = SrlmBcApplication::find()->where(['block_code' => $md->block_code])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['!=', 'srlm_bc_application.blocked', 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                    $rep_block_model->certified_bc = $dPcertified->query->count();
                    $rep_block_model->agree = SrlmBcApplication::find()->where(['block_code' => $md->block_code, 'training_status' => 1])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                    $rep_block_model->in_batch = SrlmBcApplication::find()->where(['block_code' => $md->block_code, 'training_status' => 2])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                    $rep_block_model->unwilling = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.block_code' => $md->block_code])->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_UNWILLING, SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING]])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                    $rep_block_model->registered = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.block_code' => $md->block_code])->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                    $rep_block_model->not_certified = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.block_code' => $md->block_code])->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_FAIL])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                    $rep_block_model->ineligible = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.block_code' => $md->block_code])->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                    $rep_block_model->absent = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.block_code' => $md->block_code])->andWhere(['rsetis_batch_participants.training_status' => SrlmBcApplication::TRAINING_STATUS_ABSENT])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();

                    $rep_block_model->onboard_bc = $dPonboard->query->count();
                    $rep_block_model->pvr = $dPpvr->query->count();
                    $rep_block_model->shg_assigned = $dPassignshg->query->count();

                    $rep_block_model->bc_shg_bank_verified = $dPBankVer->query->count();
                    $rep_block_model->pfms_mapping = $dPPfms->query->count();
                    $rep_block_model->bc_support_fund_shg_transfer = $dPsftrans->query->count();

                    $rep_block_model->bc_support_fund_shg_acknowledge = $dPsfack->query->count();
                    $rep_block_model->handheld_machine_provided = $dPhhmave->query->count();
                    $rep_block_model->handheld_machine_acknowledge = $dPhhmack->query->count();
                    $rep_block_model->operational = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->joinWith(['gp'])->where(['bc_transaction_bc_summary.block_code' => $md->block_code, 'master_gram_panchayat.status' => 1])->andWhere(['bc_transaction_bc_summary.master_partner_bank_id' => $bank->master_partner_bank_id, 'bc_status' => 1])->groupBy(['bc_application_id'])->count();
                    $rep_block_model->bc_bank_transaction = isset($bc_bank_transaction) ? $bc_bank_transaction : 0;
                    $rep_block_model->bc_bank_transaction_count = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->joinWith(['gp'])->where(['bc_transaction_bc_summary.block_code' => $md->block_code, 'master_gram_panchayat.status' => 1])->andWhere(['bc_transaction_bc_summary.master_partner_bank_id' => $bank->master_partner_bank_id, 'bc_status' => 1])->count();
                    $rep_block_model->no_of_bc_shortlisted = SrlmBcApplication::find()->where(['block_code' => $md->block_code])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();

                    $rep_block_model->urban = SrlmBcApplication::find()->where(['block_code' => $md->block_code])->andWhere(['=', 'form_number', '6'])->andWhere(['gender' => 2, 'status' => \bc\modules\selection\models\SrlmBcApplication::STATUS_PROVISIONAL])->andWhere(['srlm_bc_application.urban_shg' => 1])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                    $rep_block_model->no_of_training_conculded = 0;
                    $rep_block_model->no_of_training_planned = 0;
                    $rep_block_model->no_of_gp = \bc\models\master\MasterGramPanchayat::find()->select(['gram_panchayat_code'])->distinct()->where(['block_code' => $md->block_code, 'master_gram_panchayat.status' => 1])->andWhere(['master_gram_panchayat.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                    $rep_block_model->no_of_unwilling = SrlmBcApplication::find()->where(['block_code' => $md->block_code, 'bc_unwilling_rsetis' => 1])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                    $rep_block_model->no_of_bc_appeared_training = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.block_code' => $md->block_code])->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_UNWILLING, 34, 35]])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                    $rep_block_model->no_of_bc_registered = RsetisBatchParticipants::find()->joinWith(['participant'])->where(['!=', 'rsetis_batch_participants.status', -1])->andWhere(['rsetis_batch_participants.block_code' => $md->block_code])->andWhere(['rsetis_batch_participants.training_status' => [SrlmBcApplication::TRAINING_STATUS_ASIGNT_TO_BATCH, SrlmBcApplication::TRAINING_STATUS_PASS, SrlmBcApplication::TRAINING_STATUS_FAIL, SrlmBcApplication::TRAINING_STATUS_INELIIGIBLE, SrlmBcApplication::TRAINING_STATUS_ABSENT, SrlmBcApplication::TRAINING_STATUS_UNWILLING, SrlmBcApplication::TRAINING_STATUS_CERTIFIED_UNWILLING, 34, 35]])->andWhere(['srlm_bc_application.blocked' => 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                    $rep_block_model->date = new \yii\db\Expression('NOW()');
                    $rep_block_model->last_updated_on = new \yii\db\Expression('NOW()');
                    $rep_block_model->save();
//        }
                }
            }
        } catch (\Exception $ex) {
            echo $ex->getLine() . PHP_EOL;
            echo $ex->getMessage() . PHP_EOL;
        }
        echo "Block end Time : " . date('Y-m-d H:i:s') . PHP_EOL;
    }

    public function actionDbper() {
        echo "District start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        $models_district = MasterDistrict::find()->orderBy('district_name asc')->all();
        foreach ($models_district as $md) {
            $user_model = \common\models\User::findOne(19852);
            $parner_bank = SrlmBcApplication::find()->select(['master_partner_bank_id'])->distinct()->where(['district_code' => $md->district_code, 'status' => 2, 'urban_shg' => 0])->all();
            foreach ($parner_bank as $bank) {
                if ($bank->master_partner_bank_id != 6) {
                    $rep_dis_model = DistrictPartnerGramPanchayatPerformance::findOne(['district_code' => $md->district_code, 'master_partner_bank_id' => $bank->master_partner_bank_id]);
                    if ($rep_dis_model == null) {
                        $rep_dis_model = new DistrictPartnerGramPanchayatPerformance();
                    }
                    $rep_dis_model->division_code = $md->division_code;
                    $rep_dis_model->division_name = $md->division_name;
                    $rep_dis_model->district_code = $md->district_code;
                    $rep_dis_model->district_name = $md->district_name;
                    $rep_dis_model->master_partner_bank_id = $bank->master_partner_bank_id;
                    $rep_dis_model->partner_bank_name = $bank->cbank->bank_name;
                    $rep_dis_model->bc_blocked = SrlmBcApplication::find()->where(['district_code' => $md->district_code, 'srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id, 'status' => 2, 'urban_shg' => 0])->andWhere(['!=', 'srlm_bc_application.blocked', 0])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                    $rep_dis_model->certified = SrlmBcApplication::find()->where(['district_code' => $md->district_code, 'srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id, 'status' => 2, 'urban_shg' => 0])->andWhere(['=', 'srlm_bc_application.training_status', 3])->andWhere(['srlm_bc_application.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                    if ($bank->master_partner_bank_id == 7) {
                        $rep_dis_model->operational = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::find()->select(['bc_application_id'])->distinct()->joinWith(['gp'])->where(['bc_transaction_bc_summary_daily.district_code' => $md->district_code, 'master_gram_panchayat.status' => 1])->andWhere(['bc_transaction_bc_summary_daily.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                    } else {
                        $rep_dis_model->operational = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->joinWith(['gp'])->where(['bc_transaction_bc_summary.district_code' => $md->district_code, 'master_gram_panchayat.status' => 1])->andWhere(['bc_transaction_bc_summary.master_partner_bank_id' => $bank->master_partner_bank_id, 'bc_status' => 1])->count();
                    }
                    $rep_dis_model->no_of_gp = \bc\models\master\MasterGramPanchayat::find()->select(['gram_panchayat_code'])->distinct()->where(['district_code' => $md->district_code, 'status' => 1])->andWhere(['master_gram_panchayat.master_partner_bank_id' => $bank->master_partner_bank_id])->count();
                    $con = \Yii::$app->getModule('transaction')->bctransactionsummary;
                    $sql = "SELECT 
           COUNT(bc_application_id) as no_of_bc,
           SUM(no_of_transaction) as no_of_transaction,
           SUM(transaction_amount) as transaction_amount,
           SUM(commission_amount) as commission_amount,
           FLOOR(((SUM(bc_transaction_bc_summary_monthly.total_working_day))/COUNT(bc_application_id))) as avg_working_day,  
           FLOOR((SUM(no_of_transaction))/COUNT(bc_application_id)) as avg_transaction,
           FLOOR((SUM(transaction_amount))/COUNT(bc_application_id)) as avg_transaction_amount,
           FLOOR((SUM(commission_amount))/COUNT(bc_application_id)) as avg_commission_amount
          FROM `bc_transaction_bc_summary_monthly` ";
                    $where = " where bc_transaction_bc_summary_monthly.status >= 0";
                    $where .= ' and bc_transaction_bc_summary_monthly.master_partner_bank_id=' . $bank->master_partner_bank_id;
                    $where .= ' and bc_transaction_bc_summary_monthly.district_code=' . $md->district_code;
                    if ($this->from_month_id) {
                        $where .= ' and bc_transaction_bc_summary_monthly.month_id >=' . $this->from_month_id;
                    }
                    if ($this->to_month_id) {
                        $where .= ' and bc_transaction_bc_summary_monthly.month_id <=' . $this->to_month_id;
                    }
                    $sql .= $where;
                    $result = $con->createCommand($sql)->queryOne();
                    if (isset($result['avg_working_day'])) {
                        $rep_dis_model->avg_working_day = $result['avg_working_day'];
                    }
                    if (isset($result['avg_transaction'])) {
                        $rep_dis_model->avg_transaction = $result['avg_transaction'];
                    }
                    if (isset($result['avg_transaction_amount'])) {
                        $rep_dis_model->avg_transaction_amount = $result['avg_transaction_amount'];
                    }
                    if (isset($result['avg_commission_amount'])) {
                        $rep_dis_model->avg_commission_amount = $result['avg_commission_amount'];
                    }
                    $rep_dis_model->vacant_gp = MasterGramPanchayatDetailBc::findBySql("SELECT master_gram_panchayat.district_name,master_gram_panchayat.block_name,master_gram_panchayat.gram_panchayat_name,master_gram_panchayat.gram_panchayat_code  FROM `master_gram_panchayat_detail_bc`

join master_gram_panchayat on master_gram_panchayat.gram_panchayat_code=master_gram_panchayat_detail_bc.gram_panchayat_code

where master_gram_panchayat.status=1  and master_gram_panchayat.district_code=" . $md->district_code . " and master_gram_panchayat.master_partner_bank_id=" . $bank->master_partner_bank_id . "  and master_gram_panchayat_detail_bc.current_available=0 and master_gram_panchayat_detail_bc.current_status IN (-100,-2,32,4,5,6,34) and master_gram_panchayat_detail_bc.issue=0 
")->count();
                    $rep_dis_model->standby_gp = MasterGramPanchayatDetailBc::findBySql("SELECT master_gram_panchayat.district_name,master_gram_panchayat.block_name,master_gram_panchayat.gram_panchayat_name,master_gram_panchayat.gram_panchayat_code  FROM `master_gram_panchayat_detail_bc`

join master_gram_panchayat on master_gram_panchayat.gram_panchayat_code=master_gram_panchayat_detail_bc.gram_panchayat_code

where master_gram_panchayat.status=1  and master_gram_panchayat.district_code=" . $md->district_code . " and master_gram_panchayat.master_partner_bank_id=" . $bank->master_partner_bank_id . "  and master_gram_panchayat_detail_bc.current_available>0 and master_gram_panchayat_detail_bc.current_status IN (-100,-2,32,4,5,6,34) and master_gram_panchayat_detail_bc.issue=0 
")->count();

                    $sql1 = "SELECT 
           SUM(CASE WHEN bc_gram_panchayat.selected_bc_status=1 THEN 1 ELSE 0 END) AS selected_bc,
           SUM(CASE WHEN bc_gram_panchayat.select_rsethi=1 THEN 1 ELSE 0 END) AS select_rsethi,
           SUM(CASE WHEN bc_gram_panchayat.certified_status=1 THEN 1 ELSE 0 END) AS pcertified,
           SUM(CASE WHEN bc_gram_panchayat.iibf_photo_status=1 THEN 1 ELSE 0 END) AS iibf_photo,
           SUM(CASE WHEN bc_gram_panchayat.assign_shg=1 THEN 1 ELSE 0 END) AS assign_shg,
           SUM(CASE WHEN bc_gram_panchayat.bank_bc_status=1 THEN 1 ELSE 0 END) AS bank_bc,
           SUM(CASE WHEN bc_gram_panchayat.bank_shg_status=1 THEN 1 ELSE 0 END) AS bank_shg,
           SUM(CASE WHEN bc_gram_panchayat.bank_bc_shg_status=1 THEN 1 ELSE 0 END) AS bank_bc_shg,
           SUM(CASE WHEN bc_gram_panchayat.pvr=1 THEN 1 ELSE 0 END) AS pvr,
           SUM(CASE WHEN bc_gram_panchayat.shg_pfms_mapping=1 THEN 1 ELSE 0 END) AS shg_pfms_mapping,
           SUM(CASE WHEN bc_gram_panchayat.bc_shg_support_fund=1 THEN 1 ELSE 0 END) AS bc_shg_support_fund,
           SUM(CASE WHEN bc_gram_panchayat.handheld_machine=1 THEN 1 ELSE 0 END) AS handheld_machine,
           SUM(CASE WHEN bc_gram_panchayat.onboarding=1 THEN 1 ELSE 0 END) AS onboarding,
           SUM(CASE WHEN bc_gram_panchayat.operational=1 THEN 1 ELSE 0 END) AS poperational,
           FLOOR((SUM(CASE WHEN (bc_gram_panchayat.selected_bc_status=1 and bc_gram_panchayat.select_rsethi=0) THEN bc_gram_panchayat.pendency_select_rsethi_days ELSE 0 END))/SUM(CASE WHEN (bc_gram_panchayat.selected_bc_status=1 and bc_gram_panchayat.select_rsethi=0) THEN 1 ELSE 0 END)) avg_delay_day_rsetis,
           FLOOR((SUM(CASE WHEN (bc_gram_panchayat.select_rsethi=1 and bc_gram_panchayat.certified_status=0) THEN bc_gram_panchayat.pendency_certified_days ELSE 0 END))/SUM(CASE WHEN (bc_gram_panchayat.selected_bc_status=1 and bc_gram_panchayat.certified_status=0) THEN 1 ELSE 0 END)) avg_delay_day_rsetis_certified,
           FLOOR((SUM(CASE WHEN (bc_gram_panchayat.certified_status=1 and bc_gram_panchayat.iibf_photo_status=0) THEN bc_gram_panchayat.pendency_iibf_photo_days ELSE 0 END))/SUM(CASE WHEN (bc_gram_panchayat.certified_status=1 and bc_gram_panchayat.iibf_photo_status=0) THEN 1 ELSE 0 END)) avg_delay_day_iibf_photo,
           FLOOR((SUM(CASE WHEN (bc_gram_panchayat.certified_status=1 and bc_gram_panchayat.pvr=0) THEN bc_gram_panchayat.pendency_pvr_days ELSE 0 END))/SUM(CASE WHEN (bc_gram_panchayat.certified_status=1 and bc_gram_panchayat.pvr=0) THEN 1 ELSE 0 END)) avg_delay_day_pvr,
           
           FLOOR((SUM(CASE WHEN (bc_gram_panchayat.certified_status=1 and bc_gram_panchayat.assign_shg=0) THEN bc_gram_panchayat.pendency_assign_shg_days ELSE 0 END))/SUM(CASE WHEN (bc_gram_panchayat.certified_status=1 and bc_gram_panchayat.assign_shg=0) THEN 1 ELSE 0 END)) avg_delay_day_assign_shg,
           FLOOR((SUM(CASE WHEN (bc_gram_panchayat.certified_status=1 and bc_gram_panchayat.bank_bc_shg_status=0) THEN bc_gram_panchayat.pendency_bank_bc_shg_days ELSE 0 END))/SUM(CASE WHEN (bc_gram_panchayat.certified_status=1 and bc_gram_panchayat.bank_bc_shg_status=0) THEN 1 ELSE 0 END)) avg_delay_day_verified_bank,
           FLOOR((SUM(CASE WHEN (bc_gram_panchayat.certified_status=1 and bc_gram_panchayat.shg_pfms_mapping=0) THEN bc_gram_panchayat.pendency_shg_pfms_mapping_days ELSE 0 END))/SUM(CASE WHEN (bc_gram_panchayat.certified_status=1 and bc_gram_panchayat.shg_pfms_mapping=0) THEN 1 ELSE 0 END)) avg_delay_day_shg_pfms_mapping,
           FLOOR((SUM(CASE WHEN (bc_gram_panchayat.certified_status=1 and bc_gram_panchayat.bc_shg_support_fund=0) THEN bc_gram_panchayat.pendency_bc_shg_support_fund_days ELSE 0 END))/SUM(CASE WHEN (bc_gram_panchayat.certified_status=1 and bc_gram_panchayat.bc_shg_support_fund=0) THEN 1 ELSE 0 END)) avg_delay_day_funds,
           
           FLOOR((SUM(CASE WHEN (bc_gram_panchayat.certified_status=1 and bc_gram_panchayat.handheld_machine=0) THEN bc_gram_panchayat.pendency_handheld_machine_days ELSE 0 END))/SUM(CASE WHEN (bc_gram_panchayat.certified_status=1 and bc_gram_panchayat.handheld_machine=0) THEN 1 ELSE 0 END)) avg_delay_day_handheld_machine,
           FLOOR((SUM(CASE WHEN (bc_gram_panchayat.certified_status=1 and bc_gram_panchayat.onboarding=0) THEN bc_gram_panchayat.pendency_onboarding_days ELSE 0 END))/SUM(CASE WHEN (bc_gram_panchayat.certified_status=1 and bc_gram_panchayat.onboarding=0) THEN 1 ELSE 0 END)) as avg_delay_day_onboarding,
           FLOOR((SUM(CASE WHEN (bc_gram_panchayat.certified_status=1 and bc_gram_panchayat.operational=0) THEN bc_gram_panchayat.pendency_operational_days ELSE 0 END))/SUM(CASE WHEN (bc_gram_panchayat.certified_status=1 and bc_gram_panchayat.operational=0) THEN 1 ELSE 0 END)) as avg_delay_day_operational
          FROM `bc_gram_panchayat` ";
                    $where1 = " where bc_gram_panchayat.status = 1";
                    $where1 .= ' and bc_gram_panchayat.gp_partner_bank_id=' . $bank->master_partner_bank_id;
                    $where1 .= ' and bc_gram_panchayat.district_code=' . $md->district_code;

                    $sql1 .= $where1;
                    $result1 = \Yii::$app->dbbc->createCommand($sql1)->queryOne();
                    if (isset($result1['avg_delay_day_handheld_machine'])) {
                        $rep_dis_model->avg_delay_day_handheld_machine = $result1['avg_delay_day_handheld_machine'];
                    }
                    if (isset($result1['avg_delay_day_onboarding'])) {
                        $rep_dis_model->avg_delay_day_onboarding = $result1['avg_delay_day_onboarding'];
                    }
                    if (isset($result1['avg_delay_day_operational'])) {
                        $rep_dis_model->avg_delay_day_operational = $result1['avg_delay_day_operational'];
                    }
                    
                    if (isset($result1['selected_bc'])) {
                        $rep_dis_model->selected_bc = $result1['selected_bc'];
                    }
                    if (isset($result1['select_rsethi'])) {
                        $rep_dis_model->select_rsethi = $result1['select_rsethi'];
                    }
                    if (isset($result1['pcertified'])) {
                        $rep_dis_model->pcertified = $result1['pcertified'];
                    }
                    
                    if (isset($result1['iibf_photo'])) {
                        $rep_dis_model->iibf_photo = $result1['iibf_photo'];
                    }
                    if (isset($result1['assign_shg'])) {
                        $rep_dis_model->assign_shg = $result1['assign_shg'];
                    }
                    if (isset($result1['bank_bc'])) {
                        $rep_dis_model->bank_bc = $result1['bank_bc'];
                    }
                    
                    if (isset($result1['bank_shg'])) {
                        $rep_dis_model->bank_shg = $result1['bank_shg'];
                    }
                    if (isset($result1['bank_bc_shg'])) {
                        $rep_dis_model->bank_bc_shg = $result1['bank_bc_shg'];
                    }
                    if (isset($result1['pvr'])) {
                        $rep_dis_model->pvr = $result1['pvr'];
                    }
                    
                    if (isset($result1['shg_pfms_mapping'])) {
                        $rep_dis_model->shg_pfms_mapping = $result1['shg_pfms_mapping'];
                    }
                    if (isset($result1['bc_shg_support_fund'])) {
                        $rep_dis_model->bc_shg_support_fund = $result1['bc_shg_support_fund'];
                    }
                    if (isset($result1['handheld_machine'])) {
                        $rep_dis_model->handheld_machine = $result1['handheld_machine'];
                    }
                    
                    if (isset($result1['onboarding'])) {
                        $rep_dis_model->onboarding = $result1['onboarding'];
                    }
                    if (isset($result1['poperational'])) {
                        $rep_dis_model->poperational = $result1['poperational'];
                    }
                    if (isset($result1['avg_delay_day_rsetis'])) {
                        $rep_dis_model->avg_delay_day_rsetis = $result1['avg_delay_day_rsetis'];
                    }
                    
                    if (isset($result1['avg_delay_day_rsetis_certified'])) {
                        $rep_dis_model->avg_delay_day_rsetis_certified = $result1['avg_delay_day_rsetis_certified'];
                    }
                    if (isset($result1['avg_delay_day_iibf_photo'])) {
                        $rep_dis_model->avg_delay_day_iibf_photo = $result1['avg_delay_day_iibf_photo'];
                    }
                    if (isset($result1['avg_delay_day_pvr'])) {
                        $rep_dis_model->avg_delay_day_pvr = $result1['avg_delay_day_pvr'];
                    }
                    if (isset($result1['avg_delay_day_assign_shg'])) {
                        $rep_dis_model->avg_delay_day_assign_shg = $result1['avg_delay_day_assign_shg'];
                    }
                    if (isset($result1['avg_delay_day_verified_bank'])) {
                        $rep_dis_model->avg_delay_day_verified_bank = $result1['avg_delay_day_verified_bank'];
                    }
                    if (isset($result1['avg_delay_day_shg_pfms_mapping'])) {
                        $rep_dis_model->avg_delay_day_shg_pfms_mapping = $result1['avg_delay_day_shg_pfms_mapping'];
                    }
                    if (isset($result1['avg_delay_day_funds'])) {
                        $rep_dis_model->avg_delay_day_funds = $result1['avg_delay_day_funds'];
                    }
                    $rep_dis_model->updated_datetime = new \yii\db\Expression('NOW()');
                    $rep_dis_model->save();
                }
            }
        }

        echo "District End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
    }
}
