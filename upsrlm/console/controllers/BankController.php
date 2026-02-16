<?php

namespace console\controllers;

use Yii;
use yii\helpers\Json;
use yii\console\Controller;
use yii\base\Model;
use bc\modules\selection\models\SrlmBcApplication;
use bc\models\master\MasterPartnerBank;
use bc\models\PartnerBankPendencyTimeline;
use console\helpers\Utility;
use bc\modules\transaction\models\summary\BcTransactionBcSummary;

class BankController extends Controller {

   
    public $certified_bc = 0;
    public $operational = 0;
    public $date;
    public $last_updated_on;

    public function actionDaily($date = '2021-06-01') {
       
        $date = $date;
        $models_banks = MasterPartnerBank::find()->orderBy([
                    'id' => SORT_ASC,
                   
                ])->all();
        
        $i = 1;
    
        foreach ($models_banks as $md) {
            $user_model = \common\models\User::findOne(19852);
            $bank = PartnerBankPendencyTimeline::find()->where(['date' => $date, 'partner_bank_pendency_timeline.master_partner_bank_id' => $md->id])->one();
            if ($bank == null) {
                $bank = new PartnerBankPendencyTimeline();
            }
            
            $bank->master_partner_bank_id = $md->id;
            $bank->partner_bank_name = $md->bank_name;
            $bank->partner_short_bank_name = $md->bank_short_name;
            $bank->certified_bc = SrlmBcApplication::find()->select(['id', 'date(iibf_date) as iibf_date'])->where(['srlm_bc_application.status' => 2, 'srlm_bc_application.training_status' => 3, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.master_partner_bank_id' => $md->id])->andWhere(['not', ['srlm_bc_application.iibf_date' => null]])->andWhere(['<=', 'srlm_bc_application.iibf_date', $date])->count();
            $bank->bc_support_fund_shg_transfer = SrlmBcApplication::find()->select(['id', 'date(bc_shg_funds_date) as bc_shg_funds_date'])->where(['srlm_bc_application.status' => 2, 'srlm_bc_application.training_status' => 3, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.master_partner_bank_id' => $md->id])->andWhere(['not', ['srlm_bc_application.bc_shg_funds_date' => null]])->andWhere(['<=', 'srlm_bc_application.bc_shg_funds_date', $date])->count();
            $bank->bc_support_fund_shg_acknowledge = SrlmBcApplication::find()->select(['id', 'date(bc_support_funds_received_date) as bc_support_funds_received_date'])->where(['srlm_bc_application.status' => 2, 'srlm_bc_application.training_status' => 3, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.master_partner_bank_id' => $md->id])->andWhere(['not', ['srlm_bc_application.bc_support_funds_received_date' => null]])->andWhere(['<=', 'srlm_bc_application.bc_support_funds_received_date', $date])->count();
            $bank->handheld_machine_provided = SrlmBcApplication::find()->select(['id', 'date(handheld_machine_date) as handheld_machine_date'])->where(['srlm_bc_application.status' => 2, 'srlm_bc_application.training_status' => 3, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.master_partner_bank_id' => $md->id])->andWhere(['not', ['srlm_bc_application.handheld_machine_date' => null]])->andWhere(['<=', 'srlm_bc_application.handheld_machine_date', $date])->count();
            $bank->handheld_machine_acknowledge = SrlmBcApplication::find()->select(['id', 'date(bc_handheld_machine_recived_submitdate) as bc_handheld_machine_recived_submitdate'])->where(['srlm_bc_application.status' => 2, 'srlm_bc_application.training_status' => 3, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.master_partner_bank_id' => $md->id])->andWhere(['not', ['srlm_bc_application.bc_handheld_machine_recived_submitdate' => null]])->andWhere(['<=', 'srlm_bc_application.bc_handheld_machine_recived_submitdate', $date])->count();
            $bank->onboard_bc = SrlmBcApplication::find()->select(['id', 'date(onboarding_date_time) as onboarding_date_time'])->where(['srlm_bc_application.status' => 2, 'srlm_bc_application.training_status' => 3, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.master_partner_bank_id' => $md->id])->andWhere(['not', ['srlm_bc_application.onboarding_date_time' => null]])->andWhere(['<=', 'srlm_bc_application.onboarding_date_time', $date])->count();
            $bank->operational = BcTransactionBcSummary::find()->select(['id', 'date(transaction_start_date) as transaction_start_date'])->joinWith(['gp'])->where(['master_gram_panchayat.status' => 1, 'bc_transaction_bc_summary.master_partner_bank_id' => $md->id,'bc_status' => 1])->andWhere(['<=', 'bc_transaction_bc_summary.transaction_start_date', $date])->count();
            $bank->pfms_mapping = SrlmBcApplication::find()->select(['id', 'date(beneficiaries_code_date) as iibf_date'])->where(['srlm_bc_application.status' => 2, 'srlm_bc_application.training_status' => 3, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.master_partner_bank_id' => $md->id])->andWhere(['not', ['srlm_bc_application.beneficiaries_code_date' => null]])->andWhere(['<=', 'srlm_bc_application.beneficiaries_code_date', $date])->count();
            $bank->pvr = SrlmBcApplication::find()->select(['id', 'date(pvr_upload_date) as iibf_date'])->where(['srlm_bc_application.status' => 2, 'srlm_bc_application.training_status' => 3, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.master_partner_bank_id' => $md->id])->andWhere(['not', ['srlm_bc_application.pvr_upload_date' => null]])->andWhere(['<=', 'srlm_bc_application.pvr_upload_date', $date])->count();
            $bank->shg_assigned = SrlmBcApplication::find()->select(['id', 'date(assign_shg_datetime) as assign_shg_datetime'])->where(['srlm_bc_application.status' => 2, 'srlm_bc_application.training_status' => 3, 'srlm_bc_application.blocked' => 0, 'srlm_bc_application.master_partner_bank_id' => $md->id])->andWhere(['not', ['srlm_bc_application.assign_shg_datetime' => null]])->andWhere(['<=', 'srlm_bc_application.assign_shg_datetime', $date])->count();
            $bank->date = $date;
            $bank->last_updated_on = new \yii\db\Expression('NOW()');
            $bank->save();
        }
    }

    public function actionData() {
        echo "Band start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
//        $start_date = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));       
        $end_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));
//        $start_date = '2021-06-01';
//        $end_date = '2024-02-06';
        $dates = \common\helpers\Utility::date_range_key_value_date($start_date, $end_date);
        foreach ($dates as $date) {

            Yii::$app->runAction('bank/daily', [$date]);
        }
       
        echo "Bank end Time : " . date('Y-m-d H:i:s') . PHP_EOL;
    }

   


}
