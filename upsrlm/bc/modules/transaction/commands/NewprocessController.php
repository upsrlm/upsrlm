<?php

namespace bc\modules\transaction\commands;

use Yii;
use bc\modules\transaction\models\dump\BcTransactionFiles;

class NewprocessController extends \yii\console\Controller {

    public $DumoModelClass = '\bc\modules\transaction\models\dump\BcTransactionDump';
    public $BankModelClass = '\bc\modules\transaction\models\dump\BcTransactionBank';
    public $bctable = 'bc_transaction_bc_';
    public $bcdbconnectionname = 'bctransactiondistrict';

    public function actionTest() {

        exit;
    }

    public function actionFileprocess() {
        $process = \bc\modules\transaction\models\summary\BcTransactionBankSummary::find()->select(['id'])->where(['status' => 0,'master_partner_bank_id' => [2, 3, 4, 7]])->count();
        $file_models = BcTransactionFiles::find()->where(['new_process' => 0])->andWhere(['master_partner_bank_id' => [2, 3, 4, 7]])->orderBy('id asc')->limit(1)->all();
        $file_process = 0;
        if ($file_models != null and $process == '0') {
            foreach ($file_models as $file_model) {
                try {
                    $condition = ['and',
                        ['=', 'master_partner_bank_id', $file_model->master_partner_bank_id],
                    ];
                    \bc\modules\transaction\models\summary\BcTransactionBankSummary::updateAll([
                        'status' => 0,
                            ], $condition);
                    $transacation = new \bc\modules\transaction\components\Transaction();
                    $transacation->bankid_array = [];
                    $transacation->file_model = $file_model;
                    if ($transacation->rawdump($transacation->file_model)) {
                        $transacation->bcid_date_temp = [];
                        if ($transacation->bankdump($transacation->file_model)) {
                            $transacation->master_partner_bank_id = $file_model->master_partner_bank_id;
                            $file_process++;
                            if ($file_process % 1 == 0) {
                                if ($transacation->processdailybcsummary()) {
                                    $transacation = new \bc\modules\transaction\components\Transaction();
                                    $transacation->processweeklybcsummary();
                                    $transacation->processmonthlybcsummary();
                                    $transacation->processbcsummary();
                                    $transacation->processdailybanksummary();
                                    $transacation->processweeklybanksummary();
                                    $transacation->processmonthlybanksummary();
                                    $transacation->processbanksummary();
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    print_r($e->getMessage());
                    echo "errro in file process file id" . $file_model;
                }
                sleep(20);
            }
            echo "File Process Complete Time : " . date('Y-m-d H:i:s');
        }
    }

    public function actionFile() {
        $process = \bc\modules\transaction\models\summary\BcTransactionBankSummary::find()->select(['id'])->where(['status' => 0])->count();
        $file_models = BcTransactionFiles::find()->where(['new_process' => 0])->orderBy('id asc')->limit(1)->all();
        $file_process = 0;
        if ($file_models != null and $process == '0') {
            foreach ($file_models as $file_model) {
                try {
                    $condition = ['and',
                        ['=', 'master_partner_bank_id', $file_model->master_partner_bank_id],
                    ];
                    \bc\modules\transaction\models\summary\BcTransactionBankSummary::updateAll([
                        'status' => 0,
                            ], $condition);
                    $transacation = new \bc\modules\transaction\components\Transaction();
                    $transacation->bankid_array = [];
                    $transacation->file_model = $file_model;
                    if ($transacation->rawdump($transacation->file_model)) {
                        $transacation->bcid_date_temp = [];
                        if ($transacation->bankdump($transacation->file_model)) {
                            $transacation->master_partner_bank_id = $file_model->master_partner_bank_id;
                            $bfile = BcTransactionFiles::find()->where(['new_process' => 0])->orderBy('id asc')->limit(1)->one();
                            //$bfile = BcTransactionFiles::find()->where(['new_process' => 0])->andWhere(['master_partner_bank_id' => $file_model->master_partner_bank_id])->orderBy('id asc')->limit(1)->one();
                            if ($bfile != null) {
                                $condition = ['and',
                                    ['=', 'master_partner_bank_id', $file_model->master_partner_bank_id],
                                ];
                                \bc\modules\transaction\models\summary\BcTransactionBankSummary::updateAll([
                                    'status' => 1,
                                        ], $condition);
                            } else {
                                $file_process++;
                                $transacation->master_partner_bank_id = 0;
                                if ($transacation->processdailybcsummary()) {
                                    $transacation = new \bc\modules\transaction\components\Transaction();
                                    $transacation->processweeklybcsummary();
                                    $transacation->processmonthlybcsummary();
                                    $transacation->processbcsummary();
                                    $transacation->processdailybanksummary();
                                    $transacation->processweeklybanksummary();
                                    $transacation->processmonthlybanksummary();
                                    $transacation->processbanksummary();
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    print_r($e->getMessage());
                    echo "errro in file process file id" . $file_model->id . PHP_EOL;
                }
                sleep(20);
            }
            echo "File Process Complete Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        }
    }

    public function actionCangedaily($limit = 100000) {
        $bctransaction = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::find()->where(['status' => 1, 'change_calculate' => 0])->limit($limit)->all();
        foreach ($bctransaction as $model) {
            $transacation = new \bc\modules\transaction\components\Transaction();
            $transacation->calchangebcdaily($model);
        }
    }

    public function actionCangeWeekly() {
        $bctransaction = \bc\modules\transaction\models\summary\BcTransactionBcSummaryWeekly::find()->where(['status' => 1, 'change_calculate' => 0])->limit(100000)->all();
        foreach ($bctransaction as $model) {
            $transacation = new \bc\modules\transaction\components\Transaction();
            $transacation->calchangebcweekly($model);
        }
    }

    public function actionCangeMonthly() {
        $bctransaction = \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::find()->where(['status' => 1, 'change_calculate' => 0])->limit(100000)->all();
        foreach ($bctransaction as $model) {
            $transacation = new \bc\modules\transaction\components\Transaction();
            $transacation->calchangebcmonthly($model);
        }
    }

//    public function actionFileprocessbob() {
//        $process = \bc\modules\transaction\models\summary\BcTransactionBankSummary::find()->select(['id'])->where(['status' => 0])->count();
//        $file_models = BcTransactionFiles::find()->where(['new_process' => 0])->orderBy('id asc')->limit(1)->all();
//        $file_process = 0;
//        if ($file_models != null and $process == '0') {
//            foreach ($file_models as $file_model) {
//                try {
//                    $condition = ['and',
//                        ['=', 'master_partner_bank_id', $file_model->master_partner_bank_id],
//                    ];
//                    \bc\modules\transaction\models\summary\BcTransactionBankSummary::updateAll([
//                        'status' => 0,
//                            ], $condition);
//                    $transacation = new \bc\modules\transaction\components\Transaction();
//                    $transacation->bankid_array = [];
//                    $transacation->file_model = $file_model;
//                    if ($transacation->rawdump($transacation->file_model)) {
//                        $transacation->bcid_date_temp = [];
//                        if ($transacation->bankdump($transacation->file_model)) {
//                            $transacation->master_partner_bank_id = $file_model->master_partner_bank_id;
//                            $file_process++;
//                            if ($file_process % 1 == 0) {
//                                if ($transacation->processdailybcsummary()) {
//                                    $transacation = new \bc\modules\transaction\components\Transaction();
//                                    $transacation->processweeklybcsummary();
//                                    $transacation->processmonthlybcsummary();
//                                    $transacation->processbcsummary();
//                                    $transacation->processdailybanksummary();
//                                    $transacation->processweeklybanksummary();
//                                    $transacation->processmonthlybanksummary();
//                                    $transacation->processbanksummary();
//                                }
//                            }
//                        }
//                    }
//                } catch (\Exception $e) {
//                    print_r($e->getMessage());
//                    echo "errro in file process file id" . $file_model;
//                }
//                sleep(20);
//            }
//            echo "File Process Complete Time : " . date('Y-m-d H:i:s');
//        }
//    }
//    public function actionBegennonbob() {
//        $file_models = BcTransactionFiles::find()->where(['new_process' => 0])->andWhere(['!=', 'master_partner_bank_id', \bc\modules\transaction\components\Transaction::BOB])->orderBy('id asc')->all();
//        $file_process = 0;
//        if ($file_models != null) {
//            foreach ($file_models as $file_model) {
//                try {
//                    $transacation = new \bc\modules\transaction\components\Transaction();
//                    $transacation->bankid_array = [];
//                    $transacation->file_model = $file_model;
//                    if ($transacation->rawdump($transacation->file_model)) {
//                        $transacation->bcid_date_temp = [];
//                        if ($transacation->bankdump($transacation->file_model)) {
//                            $transacation->master_partner_bank_id = [2, 3, 4, 5, 6];
//                            $file_process++;
//                            if ($file_process % 5 == 0) {
//                                if ($transacation->processdailybcsummary()) {
//                                    $transacation = new \bc\modules\transaction\components\Transaction();
//                                    $transacation->processweeklybcsummary();
//                                    $transacation->processmonthlybcsummary();
//                                    $transacation->processbcsummary();
//                                    $transacation->processdailybanksummary();
//                                    $transacation->processweeklybanksummary();
//                                    $transacation->processmonthlybanksummary();
//                                    $transacation->processbanksummary();
//                                }
//                            }
//                        }
//                    }
//                } catch (\Exception $e) {
//                    print_r($e->getMessage());
//                    echo "errro non bob";
//                }
//                sleep(20);
//            }
//            echo "Non BOB Complete Time : " . date('Y-m-d H:i:s');
//        }
//    }
//
//    public function actionBegenbob() {
//        $file_models = BcTransactionFiles::find()->where(['new_process' => 0, 'master_partner_bank_id' => \bc\modules\transaction\components\Transaction::BOB])->orderBy('id asc')->all();
//        $file_process = 0;
//        if ($file_models != null) {
//            foreach ($file_models as $file_model) {
//                try {
//                    $transacation = new \bc\modules\transaction\components\Transaction();
//                    $transacation->bankid_array = [];
//                    $transacation->file_model = $file_model;
//                    if ($transacation->rawdump($transacation->file_model)) {
//                        $transacation->bcid_date_temp = [];
//                        if ($transacation->bankdump($transacation->file_model)) {
//                            $transacation->master_partner_bank_id = [1];
//                            $file_process++;
//                            if ($file_process % 1 == 0) {
//                                if ($transacation->processdailybcsummary()) {
//                                    $transacation = new \bc\modules\transaction\components\Transaction();
//                                    $transacation->processweeklybcsummary();
//                                    $transacation->processmonthlybcsummary();
//                                    $transacation->processbcsummary();
//                                    $transacation->processdailybanksummary();
//                                    $transacation->processweeklybanksummary();
//                                    $transacation->processmonthlybanksummary();
//                                    $transacation->processbanksummary();
//                                }
//                            }
//                        }
//                    }
//                } catch (\Exception $e) {
//                    print_r($e->getMessage());
//                    echo "errro bob";
//                }
//                sleep(20);
//            }
//            echo "BOB Complete Time : " . date('Y-m-d H:i:s');
//        }
//    }

    public function actionDelete() {
        $process1 = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::find()->select(['id'])->where(['status' => 0])->count();
        $process = \bc\modules\transaction\models\summary\BcTransactionBankSummary::find()->select(['id'])->where(['status' => 0])->count();
        $file_model = BcTransactionFiles::find()->where(['new_process' => -3])->orderBy('id asc')->limit(1)->one();
        if ($file_model != null and $process == '0' and $process1 == '0') {
            try {
                $transacation = new \bc\modules\transaction\components\Transaction();
                $transacation->bankid_array = [];
                $transacation->bcid_date_temp = [];
                $transacation->file_model = $file_model;
                if ($transacation->delete($transacation->file_model)) {
                    \Yii::$app->runAction('transaction/newprocess/summary');
                }
            } catch (\Exception $e) {
                print_r($e->getMessage());
                print_r($e->getLine());
            }
        }
    }

    public function actionMapbcb1() {
        echo "Map BC Bank Of Baroda Transaction start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        $null = new \yii\db\Expression('NULL');
        $ut_models = \bc\modules\transaction\models\dump\BcTransactionBank1::find()->select(['bankidbc', 'master_partner_bank_id'])->distinct()->andFilterWhere(['is', 'bc_application_id', $null])->all();
        foreach ($ut_models as $tmodel) {
            $bc_model = \bc\modules\selection\models\SrlmBcApplication::find()->select(['id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'user_id', 'blocked'])->where(['bankidbc' => $tmodel->bankidbc, 'master_partner_bank_id' => $tmodel->master_partner_bank_id])->limit(1)->one();
            if ($bc_model != null) {
                if (!in_array($bc_model->blocked, [2, 21])) {
                    $tallmodels = \bc\modules\transaction\models\dump\BcTransactionBank1::find()->where(['bankidbc' => $tmodel->bankidbc, 'master_partner_bank_id' => $tmodel->master_partner_bank_id])->andFilterWhere(['is', 'bc_application_id', $null])->all();
                    foreach ($tallmodels as $bankdata) {
                        $bankdata->bc_application_id = $bc_model->id;
                        $bankdata->district_code = $bc_model->district_code;
                        $bankdata->block_code = $bc_model->block_code;
                        $bankdata->gram_panchayat_code = $bc_model->gram_panchayat_code;
                        if (\bc\modules\transaction\helpers\Utility::validateDate($bankdata->transaction_datetime)) {
                            list($date, $time) = explode(' ', $bankdata->transaction_datetime);
                            $bankdata->transaction_date = $date;
                            $bankdata->transaction_time = $time;
                        }
                        if ($bankdata->save()) {
                            if ($bankdata->bc_application_id) {
                                $dbconnectionnme = $this->bcdbconnectionname . $bankdata->district_code;
                                $bctable = $this->bctable . $bankdata->bc_application_id;
                                $con = \Yii::$app->getModule('transaction')->$dbconnectionnme;
                                $res = $con->createCommand()->insert($bctable, [
                                            'bc_application_id' => $bankdata->bc_application_id,
                                            'bankidbc' => $bankdata->bankidbc,
                                            'district_code' => $bankdata->district_code,
                                            'block_code' => $bankdata->block_code,
                                            'gram_panchayat_code' => $bankdata->gram_panchayat_code,
                                            'master_partner_bank_id' => $bankdata->master_partner_bank_id,
                                            'file_id' => $bankdata->file_id,
                                            'dtable_id' => $bankdata->dtable_id,
                                            'banktransactionid' => $bankdata->banktransactionid,
                                            'transaction_datetime' => $bankdata->transaction_datetime,
                                            'transaction_date' => $bankdata->transaction_date,
                                            'transaction_time' => $bankdata->transaction_time,
                                            'transaction_amount' => $bankdata->transaction_amount,
                                            'transaction_type' => $bankdata->transaction_type,
                                            'ticket' => $bankdata->ticket,
                                            'commission_amount' => $bankdata->commission_amount,
                                        ])->execute();
                                if ($res) {
                                    if ($bankdata->bc_application_id) {
                                        $tran_start_date = '2021-06-01';
                                        if (strtotime($bankdata->transaction_date) >= strtotime($tran_start_date)) {
                                            $model = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::find()->select(['id'])->where(['bc_application_id' => $bankdata->bc_application_id, 'date' => $bankdata->transaction_date])->limit(1)->one();
                                            if ($model != null) {
                                                $model = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::findOne($model->id);
                                            } else {
                                                $model = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily();
                                            }
                                            $model->bc_application_id = $bankdata->bc_application_id;
                                            $model->bankidbc = $bankdata->bankidbc;
                                            $model->district_code = $bankdata->district_code;
                                            $model->block_code = $bankdata->block_code;
                                            $model->gram_panchayat_code = $bankdata->gram_panchayat_code;
                                            $model->master_partner_bank_id = $bankdata->master_partner_bank_id;
                                            $model->date = $bankdata->transaction_date;
                                            $model->transaction_start_date = $bankdata->transaction_date;
                                            $model->status = 0;
                                            $model->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        \Yii::$app->runAction('transaction/newprocess/summary');
        echo "Map BC Bank Of Baroda Transaction Completed Time : " . date('Y-m-d H:i:s');
    }

    public function actionMapbcb2() {
        echo "Map BC FINO Payment Bank Transaction start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        $null = new \yii\db\Expression('NULL');
        $ut_models = \bc\modules\transaction\models\dump\BcTransactionBank2::find()->select(['bankidbc', 'master_partner_bank_id'])->distinct()->andFilterWhere(['is', 'bc_application_id', $null])->all();
        foreach ($ut_models as $tmodel) {
            $bc_model = \bc\modules\selection\models\SrlmBcApplication::find()->select(['id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'user_id', 'blocked'])->where(['bankidbc' => $tmodel->bankidbc, 'master_partner_bank_id' => $tmodel->master_partner_bank_id])->limit(1)->one();
            if ($bc_model != null) {
                if (!in_array($bc_model->blocked, [2, 21])) {
                    $tallmodels = \bc\modules\transaction\models\dump\BcTransactionBank2::find()->where(['bankidbc' => $tmodel->bankidbc, 'master_partner_bank_id' => $tmodel->master_partner_bank_id])->andFilterWhere(['is', 'bc_application_id', $null])->all();
                    foreach ($tallmodels as $bankdata) {
                        $bankdata->bc_application_id = $bc_model->id;
                        $bankdata->district_code = $bc_model->district_code;
                        $bankdata->block_code = $bc_model->block_code;
                        $bankdata->gram_panchayat_code = $bc_model->gram_panchayat_code;
                        if (\bc\modules\transaction\helpers\Utility::validateDate($bankdata->transaction_datetime)) {
                            list($date, $time) = explode(' ', $bankdata->transaction_datetime);
                            $bankdata->transaction_date = $date;
                            $bankdata->transaction_time = $time;
                        }
                        if ($bankdata->save()) {
                            if ($bankdata->bc_application_id) {
                                $dbconnectionnme = $this->bcdbconnectionname . $bankdata->district_code;
                                $bctable = $this->bctable . $bankdata->bc_application_id;
                                $con = \Yii::$app->getModule('transaction')->$dbconnectionnme;
                                $res = $con->createCommand()->insert($bctable, [
                                            'bc_application_id' => $bankdata->bc_application_id,
                                            'bankidbc' => $bankdata->bankidbc,
                                            'district_code' => $bankdata->district_code,
                                            'block_code' => $bankdata->block_code,
                                            'gram_panchayat_code' => $bankdata->gram_panchayat_code,
                                            'master_partner_bank_id' => $bankdata->master_partner_bank_id,
                                            'file_id' => $bankdata->file_id,
                                            'dtable_id' => $bankdata->dtable_id,
                                            'banktransactionid' => $bankdata->banktransactionid,
                                            'transaction_datetime' => $bankdata->transaction_datetime,
                                            'transaction_date' => $bankdata->transaction_date,
                                            'transaction_time' => $bankdata->transaction_time,
                                            'transaction_amount' => $bankdata->transaction_amount,
                                            'transaction_type' => $bankdata->transaction_type,
                                            'ticket' => $bankdata->ticket,
                                            'commission_amount' => $bankdata->commission_amount,
                                        ])->execute();
                                if ($res) {
                                    if ($bankdata->bc_application_id) {
                                        $tran_start_date = '2021-06-01';
                                        if (strtotime($bankdata->transaction_date) >= strtotime($tran_start_date)) {
                                            $model = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::find()->select(['id'])->where(['bc_application_id' => $bankdata->bc_application_id, 'date' => $bankdata->transaction_date])->limit(1)->one();
                                            if ($model != null) {
                                                $model = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::findOne($model->id);
                                            } else {
                                                $model = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily();
                                            }
                                            $model->bc_application_id = $bankdata->bc_application_id;
                                            $model->bankidbc = $bankdata->bankidbc;
                                            $model->district_code = $bankdata->district_code;
                                            $model->block_code = $bankdata->block_code;
                                            $model->gram_panchayat_code = $bankdata->gram_panchayat_code;
                                            $model->master_partner_bank_id = $bankdata->master_partner_bank_id;
                                            $model->date = $bankdata->transaction_date;
                                            $model->transaction_start_date = $bankdata->transaction_date;
                                            $model->status = 0;
                                            $model->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        \Yii::$app->runAction('transaction/newprocess/summary');
        echo "Map BC FINO Payment Bank Transaction Completed Time : " . date('Y-m-d H:i:s');
    }

    public function actionMapbcb3() {
        echo "Map BC Nearby Technologies Pvt. Ltd Transaction start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        $null = new \yii\db\Expression('NULL');
        $ut_models = \bc\modules\transaction\models\dump\BcTransactionBank3::find()->select(['bankidbc', 'master_partner_bank_id'])->distinct()->andFilterWhere(['is', 'bc_application_id', $null])->all();
        foreach ($ut_models as $tmodel) {
            $bc_model = \bc\modules\selection\models\SrlmBcApplication::find()->select(['id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'user_id', 'blocked'])->where(['bankidbc' => $tmodel->bankidbc, 'master_partner_bank_id' => $tmodel->master_partner_bank_id])->limit(1)->one();
            if ($bc_model != null) {
                if (!in_array($bc_model->blocked, [2, 21])) {
                    $tallmodels = \bc\modules\transaction\models\dump\BcTransactionBank3::find()->where(['bankidbc' => $tmodel->bankidbc, 'master_partner_bank_id' => $tmodel->master_partner_bank_id])->andFilterWhere(['is', 'bc_application_id', $null])->all();
                    foreach ($tallmodels as $bankdata) {
                        $bankdata->bc_application_id = $bc_model->id;
                        $bankdata->district_code = $bc_model->district_code;
                        $bankdata->block_code = $bc_model->block_code;
                        $bankdata->gram_panchayat_code = $bc_model->gram_panchayat_code;
                        if (\bc\modules\transaction\helpers\Utility::validateDate($bankdata->transaction_datetime)) {
                            list($date, $time) = explode(' ', $bankdata->transaction_datetime);
                            $bankdata->transaction_date = $date;
                            $bankdata->transaction_time = $time;
                        }
                        if ($bankdata->save()) {
                            if ($bankdata->bc_application_id) {
                                $dbconnectionnme = $this->bcdbconnectionname . $bankdata->district_code;
                                $bctable = $this->bctable . $bankdata->bc_application_id;
                                $con = \Yii::$app->getModule('transaction')->$dbconnectionnme;
                                $res = $con->createCommand()->insert($bctable, [
                                            'bc_application_id' => $bankdata->bc_application_id,
                                            'bankidbc' => $bankdata->bankidbc,
                                            'district_code' => $bankdata->district_code,
                                            'block_code' => $bankdata->block_code,
                                            'gram_panchayat_code' => $bankdata->gram_panchayat_code,
                                            'master_partner_bank_id' => $bankdata->master_partner_bank_id,
                                            'file_id' => $bankdata->file_id,
                                            'dtable_id' => $bankdata->dtable_id,
                                            'banktransactionid' => $bankdata->banktransactionid,
                                            'transaction_datetime' => $bankdata->transaction_datetime,
                                            'transaction_date' => $bankdata->transaction_date,
                                            'transaction_time' => $bankdata->transaction_time,
                                            'transaction_amount' => $bankdata->transaction_amount,
                                            'transaction_type' => $bankdata->transaction_type,
                                            'ticket' => $bankdata->ticket,
                                            'commission_amount' => $bankdata->commission_amount,
                                        ])->execute();
                                if ($res) {
                                    if ($bankdata->bc_application_id) {
                                        $tran_start_date = '2021-06-01';
                                        if (strtotime($bankdata->transaction_date) >= strtotime($tran_start_date)) {
                                            $model = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::find()->select(['id'])->where(['bc_application_id' => $bankdata->bc_application_id, 'date' => $bankdata->transaction_date])->limit(1)->one();
                                            if ($model != null) {
                                                $model = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::findOne($model->id);
                                            } else {
                                                $model = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily();
                                            }
                                            $model->bc_application_id = $bankdata->bc_application_id;
                                            $model->bankidbc = $bankdata->bankidbc;
                                            $model->district_code = $bankdata->district_code;
                                            $model->block_code = $bankdata->block_code;
                                            $model->gram_panchayat_code = $bankdata->gram_panchayat_code;
                                            $model->master_partner_bank_id = $bankdata->master_partner_bank_id;
                                            $model->date = $bankdata->transaction_date;
                                            $model->transaction_start_date = $bankdata->transaction_date;
                                            $model->status = 0;
                                            $model->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        \Yii::$app->runAction('transaction/newprocess/summary');
        echo "Map BC Nearby Technologies Pvt. Ltd Transaction Completed Time : " . date('Y-m-d H:i:s');
    }

    public function actionMapbcb4() {
        echo "Map BC Manipal Technologies Limited Transaction start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        $null = new \yii\db\Expression('NULL');
        $ut_models = \bc\modules\transaction\models\dump\BcTransactionBank4::find()->select(['bankidbc', 'master_partner_bank_id'])->distinct()->andFilterWhere(['is', 'bc_application_id', $null])->all();
        foreach ($ut_models as $tmodel) {
            $bc_model = \bc\modules\selection\models\SrlmBcApplication::find()->select(['id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'user_id', 'blocked'])->where(['bankidbc' => $tmodel->bankidbc, 'master_partner_bank_id' => $tmodel->master_partner_bank_id])->limit(1)->one();
            if ($bc_model != null) {
                if (!in_array($bc_model->blocked, [2, 21])) {
//                    echo $tmodel->bankidbc.PHP_EOL;
//                    echo $bc_model->id.PHP_EOL;
//                    echo $bc_model->district_code.',';
//                    echo $this->bctable . $bc_model->id.PHP_EOL;
                    $tallmodels = \bc\modules\transaction\models\dump\BcTransactionBank4::find()->where(['bankidbc' => $tmodel->bankidbc, 'master_partner_bank_id' => $tmodel->master_partner_bank_id])->andFilterWhere(['is', 'bc_application_id', $null])->all();
                    foreach ($tallmodels as $bankdata) {
                        $bankdata->bc_application_id = $bc_model->id;
                        $bankdata->district_code = $bc_model->district_code;
                        $bankdata->block_code = $bc_model->block_code;
                        $bankdata->gram_panchayat_code = $bc_model->gram_panchayat_code;
                        if (\bc\modules\transaction\helpers\Utility::validateDate($bankdata->transaction_datetime)) {
                            list($date, $time) = explode(' ', $bankdata->transaction_datetime);
                            $bankdata->transaction_date = $date;
                            $bankdata->transaction_time = $time;
                        }
                        if ($bankdata->save()) {
                            if ($bankdata->bc_application_id) {
                                $dbconnectionnme = $this->bcdbconnectionname . $bankdata->district_code;
                                $bctable = $this->bctable . $bankdata->bc_application_id;
                                $con = \Yii::$app->getModule('transaction')->$dbconnectionnme;
                                $res = $con->createCommand()->insert($bctable, [
                                            'bc_application_id' => $bankdata->bc_application_id,
                                            'bankidbc' => $bankdata->bankidbc,
                                            'district_code' => $bankdata->district_code,
                                            'block_code' => $bankdata->block_code,
                                            'gram_panchayat_code' => $bankdata->gram_panchayat_code,
                                            'master_partner_bank_id' => $bankdata->master_partner_bank_id,
                                            'file_id' => $bankdata->file_id,
                                            'dtable_id' => $bankdata->dtable_id,
                                            'banktransactionid' => $bankdata->banktransactionid,
                                            'transaction_datetime' => $bankdata->transaction_datetime,
                                            'transaction_date' => $bankdata->transaction_date,
                                            'transaction_time' => $bankdata->transaction_time,
                                            'transaction_amount' => $bankdata->transaction_amount,
                                            'transaction_type' => $bankdata->transaction_type,
                                            'ticket' => $bankdata->ticket,
                                            'commission_amount' => $bankdata->commission_amount,
                                        ])->execute();
                                if ($res) {
                                    if ($bankdata->bc_application_id) {
                                        $tran_start_date = '2021-06-01';
                                        if (strtotime($bankdata->transaction_date) >= strtotime($tran_start_date)) {
                                            $model = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::find()->select(['id'])->where(['bc_application_id' => $bankdata->bc_application_id, 'date' => $bankdata->transaction_date])->limit(1)->one();
                                            if ($model != null) {
                                                $model = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::findOne($model->id);
                                            } else {
                                                $model = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily();
                                            }
                                            $model->bc_application_id = $bankdata->bc_application_id;
                                            $model->bankidbc = $bankdata->bankidbc;
                                            $model->district_code = $bankdata->district_code;
                                            $model->block_code = $bankdata->block_code;
                                            $model->gram_panchayat_code = $bankdata->gram_panchayat_code;
                                            $model->master_partner_bank_id = $bankdata->master_partner_bank_id;
                                            $model->date = $bankdata->transaction_date;
                                            $model->transaction_start_date = $bankdata->transaction_date;
                                            $model->status = 0;
                                            $model->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
//                    echo count($tallmodels).PHP_EOL;
//                    exit();
                }
            }
        }
        \Yii::$app->runAction('transaction/newprocess/summary');
        echo "Map BC Manipal Technologies Limited Transaction Completed Time : " . date('Y-m-d H:i:s');
    }

    public function actionMapbcb5() {
        echo "Map BC MFSL-Airtel-GVI Consortia Transaction start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        $null = new \yii\db\Expression('NULL');
        $ut_models = \bc\modules\transaction\models\dump\BcTransactionBank5::find()->select(['bankidbc', 'master_partner_bank_id'])->distinct()->andFilterWhere(['is', 'bc_application_id', $null])->all();
        foreach ($ut_models as $tmodel) {
            $bc_model = \bc\modules\selection\models\SrlmBcApplication::find()->select(['id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'user_id', 'blocked'])->where(['bankidbc' => $tmodel->bankidbc, 'master_partner_bank_id' => $tmodel->master_partner_bank_id])->limit(1)->one();
            if ($bc_model != null) {
                if (!in_array($bc_model->blocked, [2, 21])) {
                    $tallmodels = \bc\modules\transaction\models\dump\BcTransactionBank5::find()->where(['bankidbc' => $tmodel->bankidbc, 'master_partner_bank_id' => $tmodel->master_partner_bank_id])->andFilterWhere(['is', 'bc_application_id', $null])->all();
                    foreach ($tallmodels as $bankdata) {
                        $bankdata->bc_application_id = $bc_model->id;
                        $bankdata->district_code = $bc_model->district_code;
                        $bankdata->block_code = $bc_model->block_code;
                        $bankdata->gram_panchayat_code = $bc_model->gram_panchayat_code;
                        if (\bc\modules\transaction\helpers\Utility::validateDate($bankdata->transaction_datetime)) {
                            list($date, $time) = explode(' ', $bankdata->transaction_datetime);
                            $bankdata->transaction_date = $date;
                            $bankdata->transaction_time = $time;
                        }
                        if ($bankdata->save()) {
                            if ($bankdata->bc_application_id) {
                                $dbconnectionnme = $this->bcdbconnectionname . $bankdata->district_code;
                                $bctable = $this->bctable . $bankdata->bc_application_id;
                                $con = \Yii::$app->getModule('transaction')->$dbconnectionnme;
                                $res = $con->createCommand()->insert($bctable, [
                                            'bc_application_id' => $bankdata->bc_application_id,
                                            'bankidbc' => $bankdata->bankidbc,
                                            'district_code' => $bankdata->district_code,
                                            'block_code' => $bankdata->block_code,
                                            'gram_panchayat_code' => $bankdata->gram_panchayat_code,
                                            'master_partner_bank_id' => $bankdata->master_partner_bank_id,
                                            'file_id' => $bankdata->file_id,
                                            'dtable_id' => $bankdata->dtable_id,
                                            'banktransactionid' => $bankdata->banktransactionid,
                                            'transaction_datetime' => $bankdata->transaction_datetime,
                                            'transaction_date' => $bankdata->transaction_date,
                                            'transaction_time' => $bankdata->transaction_time,
                                            'transaction_amount' => $bankdata->transaction_amount,
                                            'transaction_type' => $bankdata->transaction_type,
                                            'ticket' => $bankdata->ticket,
                                            'commission_amount' => $bankdata->commission_amount,
                                        ])->execute();
                                if ($res) {
                                    if ($bankdata->bc_application_id) {
                                        $tran_start_date = '2021-06-01';
                                        if (strtotime($bankdata->transaction_date) >= strtotime($tran_start_date)) {
                                            $model = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::find()->select(['id'])->where(['bc_application_id' => $bankdata->bc_application_id, 'date' => $bankdata->transaction_date])->limit(1)->one();
                                            if ($model != null) {
                                                $model = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::findOne($model->id);
                                            } else {
                                                $model = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily();
                                            }
                                            $model->bc_application_id = $bankdata->bc_application_id;
                                            $model->bankidbc = $bankdata->bankidbc;
                                            $model->district_code = $bankdata->district_code;
                                            $model->block_code = $bankdata->block_code;
                                            $model->gram_panchayat_code = $bankdata->gram_panchayat_code;
                                            $model->master_partner_bank_id = $bankdata->master_partner_bank_id;
                                            $model->date = $bankdata->transaction_date;
                                            $model->transaction_start_date = $bankdata->transaction_date;
                                            $model->status = 0;
                                            $model->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        \Yii::$app->runAction('transaction/newprocess/summary');
        echo "Map BC MFSL-Airtel-GVI Consortia Transaction Completed Time : " . date('Y-m-d H:i:s');
    }

    public function actionMapbcb6() {
        echo "Map BC Paytm Payment Bank Transaction start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        $null = new \yii\db\Expression('NULL');
        $ut_models = \bc\modules\transaction\models\dump\BcTransactionBank6::find()->select(['bankidbc', 'master_partner_bank_id'])->distinct()->andFilterWhere(['is', 'bc_application_id', $null])->all();
        foreach ($ut_models as $tmodel) {
            $bc_model = \bc\modules\selection\models\SrlmBcApplication::find()->select(['id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'user_id', 'blocked'])->where(['bankidbc' => $tmodel->bankidbc, 'master_partner_bank_id' => $tmodel->master_partner_bank_id])->limit(1)->one();
            if ($bc_model != null) {
                if (!in_array($bc_model->blocked, [2, 21])) {
                    $tallmodels = \bc\modules\transaction\models\dump\BcTransactionBank6::find()->where(['bankidbc' => $tmodel->bankidbc, 'master_partner_bank_id' => $tmodel->master_partner_bank_id])->andFilterWhere(['is', 'bc_application_id', $null])->all();
                    foreach ($tallmodels as $bankdata) {
                        $bankdata->bc_application_id = $bc_model->id;
                        $bankdata->district_code = $bc_model->district_code;
                        $bankdata->block_code = $bc_model->block_code;
                        $bankdata->gram_panchayat_code = $bc_model->gram_panchayat_code;
                        if (\bc\modules\transaction\helpers\Utility::validateDate($bankdata->transaction_datetime)) {
                            list($date, $time) = explode(' ', $bankdata->transaction_datetime);
                            $bankdata->transaction_date = $date;
                            $bankdata->transaction_time = $time;
                        }
                        if ($bankdata->save()) {
                            if ($bankdata->bc_application_id) {
                                $dbconnectionnme = $this->bcdbconnectionname . $bankdata->district_code;
                                $bctable = $this->bctable . $bankdata->bc_application_id;
                                $con = \Yii::$app->getModule('transaction')->$dbconnectionnme;
                                $res = $con->createCommand()->insert($bctable, [
                                            'bc_application_id' => $bankdata->bc_application_id,
                                            'bankidbc' => $bankdata->bankidbc,
                                            'district_code' => $bankdata->district_code,
                                            'block_code' => $bankdata->block_code,
                                            'gram_panchayat_code' => $bankdata->gram_panchayat_code,
                                            'master_partner_bank_id' => $bankdata->master_partner_bank_id,
                                            'file_id' => $bankdata->file_id,
                                            'dtable_id' => $bankdata->dtable_id,
                                            'banktransactionid' => $bankdata->banktransactionid,
                                            'transaction_datetime' => $bankdata->transaction_datetime,
                                            'transaction_date' => $bankdata->transaction_date,
                                            'transaction_time' => $bankdata->transaction_time,
                                            'transaction_amount' => $bankdata->transaction_amount,
                                            'transaction_type' => $bankdata->transaction_type,
                                            'ticket' => $bankdata->ticket,
                                            'commission_amount' => $bankdata->commission_amount,
                                        ])->execute();
                                if ($res) {
                                    if ($bankdata->bc_application_id) {
                                        $tran_start_date = '2021-06-01';
                                        if (strtotime($bankdata->transaction_date) >= strtotime($tran_start_date)) {
                                            $model = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::find()->select(['id'])->where(['bc_application_id' => $bankdata->bc_application_id, 'date' => $bankdata->transaction_date])->limit(1)->one();
                                            if ($model != null) {
                                                $model = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::findOne($model->id);
                                            } else {
                                                $model = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily();
                                            }
                                            $model->bc_application_id = $bankdata->bc_application_id;
                                            $model->bankidbc = $bankdata->bankidbc;
                                            $model->district_code = $bankdata->district_code;
                                            $model->block_code = $bankdata->block_code;
                                            $model->gram_panchayat_code = $bankdata->gram_panchayat_code;
                                            $model->master_partner_bank_id = $bankdata->master_partner_bank_id;
                                            $model->date = $bankdata->transaction_date;
                                            $model->transaction_start_date = $bankdata->transaction_date;
                                            $model->status = 0;
                                            $model->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        \Yii::$app->runAction('transaction/newprocess/summary');
        echo "Map BC Paytm Payment Bank Transaction Completed Time : " . date('Y-m-d H:i:s');
    }

    public function actionMapbcb7() {
        echo "Map BC SBI Bank Transaction start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        $null = new \yii\db\Expression('NULL');
        $ut_models = \bc\modules\transaction\models\dump\BcTransactionBank7::find()->select(['bankidbc', 'master_partner_bank_id'])->distinct()->andFilterWhere(['is', 'bc_application_id', $null])->all();
        foreach ($ut_models as $tmodel) {
            $bc_model = \bc\modules\selection\models\SrlmBcApplication::find()->select(['id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'user_id', 'blocked'])->where(['bankidbc' => $tmodel->bankidbc, 'master_partner_bank_id' => $tmodel->master_partner_bank_id])->limit(1)->one();
            if ($bc_model != null) {
                if (!in_array($bc_model->blocked, [2, 21])) {
                    $tallmodels = \bc\modules\transaction\models\dump\BcTransactionBank7::find()->where(['bankidbc' => $tmodel->bankidbc, 'master_partner_bank_id' => $tmodel->master_partner_bank_id])->andFilterWhere(['is', 'bc_application_id', $null])->all();
                    foreach ($tallmodels as $bankdata) {
                        $bankdata->bc_application_id = $bc_model->id;
                        $bankdata->district_code = $bc_model->district_code;
                        $bankdata->block_code = $bc_model->block_code;
                        $bankdata->gram_panchayat_code = $bc_model->gram_panchayat_code;
                        if (\bc\modules\transaction\helpers\Utility::validateDate($bankdata->transaction_datetime)) {
                            list($date, $time) = explode(' ', $bankdata->transaction_datetime);
                            $bankdata->transaction_date = $date;
                            $bankdata->transaction_time = $time;
                        }
                        if ($bankdata->save()) {
                            if ($bankdata->bc_application_id) {
                                $dbconnectionnme = $this->bcdbconnectionname . $bankdata->district_code;
                                $bctable = $this->bctable . $bankdata->bc_application_id;
                                $con = \Yii::$app->getModule('transaction')->$dbconnectionnme;
                                $res = $con->createCommand()->insert($bctable, [
                                            'bc_application_id' => $bankdata->bc_application_id,
                                            'bankidbc' => $bankdata->bankidbc,
                                            'district_code' => $bankdata->district_code,
                                            'block_code' => $bankdata->block_code,
                                            'gram_panchayat_code' => $bankdata->gram_panchayat_code,
                                            'master_partner_bank_id' => $bankdata->master_partner_bank_id,
                                            'file_id' => $bankdata->file_id,
                                            'dtable_id' => $bankdata->dtable_id,
                                            'banktransactionid' => $bankdata->banktransactionid,
                                            'transaction_datetime' => $bankdata->transaction_datetime,
                                            'transaction_date' => $bankdata->transaction_date,
                                            'transaction_time' => $bankdata->transaction_time,
                                            'transaction_amount' => $bankdata->transaction_amount,
                                            'transaction_type' => $bankdata->transaction_type,
                                            'ticket' => $bankdata->ticket,
                                            'commission_amount' => $bankdata->commission_amount,
                                        ])->execute();
                                if ($res) {
                                    if ($bankdata->bc_application_id) {
                                        $tran_start_date = '2021-06-01';
                                        if (strtotime($bankdata->transaction_date) >= strtotime($tran_start_date)) {
                                            $model = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::find()->select(['id'])->where(['bc_application_id' => $bankdata->bc_application_id, 'date' => $bankdata->transaction_date])->limit(1)->one();
                                            if ($model != null) {
                                                $model = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::findOne($model->id);
                                            } else {
                                                $model = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily();
                                            }
                                            $model->bc_application_id = $bankdata->bc_application_id;
                                            $model->bankidbc = $bankdata->bankidbc;
                                            $model->district_code = $bankdata->district_code;
                                            $model->block_code = $bankdata->block_code;
                                            $model->gram_panchayat_code = $bankdata->gram_panchayat_code;
                                            $model->master_partner_bank_id = $bankdata->master_partner_bank_id;
                                            $model->date = $bankdata->transaction_date;
                                            $model->transaction_start_date = $bankdata->transaction_date;
                                            $model->status = 0;
                                            $model->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        \Yii::$app->runAction('transaction/newprocess/summary');
        echo "Map BC SBI Bank Transaction Completed Time : " . date('Y-m-d H:i:s');
    }

//    public function actionFile() {
//        $in_process = BcTransactionFiles::find()->where(['new_process' => [1, 2]])->one();
//        if ($in_process == null) {
//            $file_model = BcTransactionFiles::find()->where(['new_process' => 0])->orderBy('id asc')->one();
//            if ($file_model != null) {
//                $this->beginprocess($file_model);
//            }
//            //\Yii::$app->runAction('transaction/newprocess/beginprocess', [$file_model->id]);
//        }
//    }
//
//    public function actionFilebobodd() {
//        $in_process = BcTransactionFiles::find()->where(['new_process' => [1, 2], 'master_partner_bank_id' => \bc\modules\transaction\components\Transaction::BOB])->andWhere("id%2 > 0")->one();
//        if ($in_process == null) {
//            $file_model = BcTransactionFiles::find()->where(['new_process' => 0, 'master_partner_bank_id' => \bc\modules\transaction\components\Transaction::BOB])->andWhere("id%2 > 0")->orderBy('id asc')->one();
//            if ($file_model != null) {
//                $this->beginprocess($file_model);
//            }
//            //\Yii::$app->runAction('transaction/newprocess/beginprocess', [$file_model->id]);
//        }
//    }
//
//    public function actionFilebobeven() {
//        $in_process = BcTransactionFiles::find()->where(['new_process' => [1, 2], 'master_partner_bank_id' => \bc\modules\transaction\components\Transaction::BOB])->andWhere("id%2 = 0")->one();
//        if ($in_process == null) {
//            $file_model = BcTransactionFiles::find()->where(['new_process' => 0, 'master_partner_bank_id' => \bc\modules\transaction\components\Transaction::BOB])->andWhere("id%2 = 0")->orderBy('id asc')->one();
//            if ($file_model != null) {
//                $this->beginprocess($file_model);
//            }
//            //\Yii::$app->runAction('transaction/newprocess/beginprocess', [$file_model->id]);
//        }
//    }
//
//    public function actionFilenonbobodd() {
//        $in_process = BcTransactionFiles::find()->where(['new_process' => [1, 2]])->andWhere(['!=', 'master_partner_bank_id', \bc\modules\transaction\components\Transaction::BOB])->andWhere("id%2 > 0")->one();
//        if ($in_process == null) {
//            $file_model = BcTransactionFiles::find()->where(['new_process' => 0])->andWhere(['!=', 'master_partner_bank_id', \bc\modules\transaction\components\Transaction::BOB])->andWhere("id%2 > 0")->orderBy('id asc')->one();
//            if ($file_model != null) {
//                $this->beginprocess($file_model);
//            }
//            //\Yii::$app->runAction('transaction/newprocess/beginprocess', [$file_model->id]);
//        }
//    }
//
//    public function actionFilenonbobeven() {
//        $in_process = BcTransactionFiles::find()->where(['new_process' => [1, 2]])->andWhere(['!=', 'master_partner_bank_id', \bc\modules\transaction\components\Transaction::BOB])->andWhere("id%2 = 0")->one();
//        if ($in_process == null) {
//            $file_model = BcTransactionFiles::find()->where(['new_process' => 0])->andWhere(['!=', 'master_partner_bank_id', \bc\modules\transaction\components\Transaction::BOB])->andWhere("id%2 = 0")->orderBy('id asc')->one();
//            if ($file_model != null) {
//                $this->beginprocess($file_model);
//            }
//            //\Yii::$app->runAction('transaction/newprocess/beginprocess', [$file_model->id]);
//        }
//    }
//
//    private function beginprocess($file_model) {
//        $file_model = $file_model;
//        if ($file_model != null) {
//            try {
//                $transacation = new \bc\modules\transaction\components\Transaction();
//                $transacation->file_model = $file_model;
//                if ($transacation->rawdump($transacation->file_model)) {
//                    $transacation->bcid_date_temp = [];
//                    if ($transacation->bankdump($transacation->file_model)) {
//                        
//                    }
//                }
//            } catch (\Exception $e) {
//                print_r($e->getMessage());
//            }
//        }
//    }
//    public function actionBeginprocess($transaction_file_id) {
//        $file_model = BcTransactionFiles::findOne(['id' => $transaction_file_id, 'new_process' => 0]);
//        if ($file_model != null) {
//            try {
//                $transacation = new \bc\modules\transaction\components\Transaction();
//                $transacation->file_model = $file_model;
//                if ($transacation->rawdump($transacation->file_model)) {
//                    $transacation->bcid_date_temp = [];
//                    if ($transacation->bankdump($transacation->file_model)) {
//                        
//                    }
//                }
//            } catch (\Exception $e) {
//                print_r($e->getMessage());
//            }
//        }
//    }
    public function actionSummary($master_partner_bank_id = 1) {

        try {
            $transacation = new \bc\modules\transaction\components\Transaction();
//            $transacation->master_partner_bank_id=$master_partner_bank_id;
            if ($transacation->processdailybcsummary()) {
                \Yii::$app->runAction('transaction/newprocess/processsummary');
            }
        } catch (\Exception $e) {
            print_r($e->getMessage());
            print_r($e->getLine());
        }
    }

    public function actionProcesssummary() {
        try {
            $process = \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::find()->where(['status' => 0])->count();
            if ($process == '0') {
                $transacation = new \bc\modules\transaction\components\Transaction();
                echo "New Weekly BC Transaction report start Time : " . date('Y-m-d H:i:s');
                $transacation->processweeklybcsummary();
                echo "New Weekly BC Transaction report End Time : " . date('Y-m-d H:i:s');
                echo "New Monthly BC Transaction report start Time : " . date('Y-m-d H:i:s');
                $transacation->processmonthlybcsummary();
                echo "New Monthly BC Transaction report start Time : " . date('Y-m-d H:i:s');
                echo "New BC Transaction report start Time : " . date('Y-m-d H:i:s');
                $transacation->processbcsummary();
                echo "New Monthly BC Transaction report end Time : " . date('Y-m-d H:i:s');
                echo "New Bank Transaction report start Time : " . date('Y-m-d H:i:s');
                $transacation->processdailybanksummary();
                $transacation->processweeklybanksummary();
                $transacation->processmonthlybanksummary();
                $transacation->processbanksummary();
                echo "New Bank Transaction report end Time : " . date('Y-m-d H:i:s');
            }
        } catch (\Exception $e) {
            print_r($e->getMessage());
            print_r($e->getLine());
        }
    }

    public function actionRprocess($transaction_file_id) {
        $file_model = BcTransactionFiles::findOne(['id' => $transaction_file_id, 'new_process' => 2]);
        if ($file_model != null) {
            try {
                $transacation = new \bc\modules\transaction\components\Transaction();
                $transacation->file_model = $file_model;
                $transacation->bankid_array = [];
                $transacation->bcid_date_temp = [];
                if ($transacation->bankdump($transacation->file_model)) {
                    // \Yii::$app->runAction('transaction/newprocess/summary'); 
                }
            } catch (\Exception $e) {
                print_r($e->getMessage());
            }
        }
    }

//    public function actionBank1() {
//        $bank_1 = \bc\modules\transaction\models\dump\BcTransactionBank1::find()->select(['bc_application_id'])->distinct()->all();
//        foreach ($bank_1 as $bank) {
//            if ($bank->bc_application_id) {
//                $app_model = \bc\modules\selection\models\SrlmBcApplication::findOne($bank->bc_application_id);
//                $condition = ['and',
//                    ['=', 'bc_application_id', $bank->bc_application_id],
//                ];
//                \bc\modules\transaction\models\dump\BcTransactionBank1::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummaryWeekly::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummary::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0,
//                        ], $condition);
//                $dbconnectionnme = $this->bcdbconnectionname . $app_model->district_code;
//                $bctable = $this->bctable . $app_model->id;
//                $updatequery = "UPDATE $bctable SET `gram_panchayat_code`=" . $app_model->gram_panchayat_code . " WHERE bc_application_id=" . $app_model->id;
//                \Yii::$app->getModule('transaction')->$dbconnectionnme->createCommand($updatequery)->execute();
//            }
//        }
//    }
//    public function actionBank2() {
//        $bank_1 = \bc\modules\transaction\models\dump\BcTransactionBank2::find()->select(['bc_application_id'])->distinct()->all();
//        foreach ($bank_1 as $bank) {
//            if ($bank->bc_application_id) {
//                $app_model = \bc\modules\selection\models\SrlmBcApplication::findOne($bank->bc_application_id);
//                $condition = ['and',
//                    ['=', 'bc_application_id', $bank->bc_application_id],
//                ];
//                \bc\modules\transaction\models\dump\BcTransactionBank2::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummaryWeekly::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummary::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0,
//                        ], $condition);
//                $dbconnectionnme = $this->bcdbconnectionname . $app_model->district_code;
//                $bctable = $this->bctable . $app_model->id;
//                $updatequery = "UPDATE $bctable SET `gram_panchayat_code`=" . $app_model->gram_panchayat_code . " WHERE bc_application_id=" . $app_model->id;
//                \Yii::$app->getModule('transaction')->$dbconnectionnme->createCommand($updatequery)->execute();
//            }
//        }
//    }
//    public function actionBank3() {
//        $bank_1 = \bc\modules\transaction\models\dump\BcTransactionBank3::find()->select(['bc_application_id'])->distinct()->all();
//        foreach ($bank_1 as $bank) {
//            if ($bank->bc_application_id) {
//                $app_model = \bc\modules\selection\models\SrlmBcApplication::findOne($bank->bc_application_id);
//                $condition = ['and',
//                    ['=', 'bc_application_id', $bank->bc_application_id],
//                ];
//                \bc\modules\transaction\models\dump\BcTransactionBank3::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummaryWeekly::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummary::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0,
//                        ], $condition);
//                $dbconnectionnme = $this->bcdbconnectionname . $app_model->district_code;
//                $bctable = $this->bctable . $app_model->id;
//                $updatequery = "UPDATE $bctable SET `gram_panchayat_code`=" . $app_model->gram_panchayat_code . " WHERE bc_application_id=" . $app_model->id;
//                \Yii::$app->getModule('transaction')->$dbconnectionnme->createCommand($updatequery)->execute();
//            }
//        }
//    }
//    public function actionBank4() {
//        $bank_1 = \bc\modules\transaction\models\dump\BcTransactionBank4::find()->select(['bc_application_id'])->distinct()->all();
//        foreach ($bank_1 as $bank) {
//            if ($bank->bc_application_id) {
//                $app_model = \bc\modules\selection\models\SrlmBcApplication::findOne($bank->bc_application_id);
//                $condition = ['and',
//                    ['=', 'bc_application_id', $bank->bc_application_id],
//                ];
//                \bc\modules\transaction\models\dump\BcTransactionBank4::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummaryWeekly::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummary::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0,
//                        ], $condition);
//                $dbconnectionnme = $this->bcdbconnectionname . $app_model->district_code;
//                $bctable = $this->bctable . $app_model->id;
//                $updatequery = "UPDATE $bctable SET `gram_panchayat_code`=" . $app_model->gram_panchayat_code . " WHERE bc_application_id=" . $app_model->id;
//                \Yii::$app->getModule('transaction')->$dbconnectionnme->createCommand($updatequery)->execute();
//            }
//        }
//    }
//    public function actionBank5() {
//        $bank_1 = \bc\modules\transaction\models\dump\BcTransactionBank5::find()->select(['bc_application_id'])->distinct()->all();
//        foreach ($bank_1 as $bank) {
//            if ($bank->bc_application_id) {
//                $app_model = \bc\modules\selection\models\SrlmBcApplication::findOne($bank->bc_application_id);
//                $condition = ['and',
//                    ['=', 'bc_application_id', $bank->bc_application_id],
//                ];
//                \bc\modules\transaction\models\dump\BcTransactionBank5::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummaryWeekly::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummary::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0,
//                        ], $condition);
//                $dbconnectionnme = $this->bcdbconnectionname . $app_model->district_code;
//                $bctable = $this->bctable . $app_model->id;
//                $updatequery = "UPDATE $bctable SET `gram_panchayat_code`=" . $app_model->gram_panchayat_code . " WHERE bc_application_id=" . $app_model->id;
//                \Yii::$app->getModule('transaction')->$dbconnectionnme->createCommand($updatequery)->execute();
//            }
//        }
//    }
//    public function actionBank6() {
//        $bank_1 = \bc\modules\transaction\models\dump\BcTransactionBank6::find()->select(['bc_application_id'])->distinct()->all();
//        foreach ($bank_1 as $bank) {
//            if ($bank->bc_application_id) {
//                $app_model = \bc\modules\selection\models\SrlmBcApplication::findOne($bank->bc_application_id);
//                $condition = ['and',
//                    ['=', 'bc_application_id', $bank->bc_application_id],
//                ];
//                \bc\modules\transaction\models\dump\BcTransactionBank6::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummaryWeekly::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0
//                        ], $condition);
//                \bc\modules\transaction\models\summary\BcTransactionBcSummary::updateAll([
//                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
//                    'status' => 0,
//                        ], $condition);
//                $dbconnectionnme = $this->bcdbconnectionname . $app_model->district_code;
//                $bctable = $this->bctable . $app_model->id;
//                $updatequery = "UPDATE $bctable SET `gram_panchayat_code`=" . $app_model->gram_panchayat_code . " WHERE bc_application_id=" . $app_model->id;
//                \Yii::$app->getModule('transaction')->$dbconnectionnme->createCommand($updatequery)->execute();
//            }
//        }
//    }
//    public function actionOperational() {
//        $null = new \yii\db\Expression('NULL');
//        try {
//            echo "BC operational Start Time : " . date('Y-m-d H:i:s');
//            $totalbc = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->select(['bc_application_id'])->count();
//            $limit = 1000;
//            $batch = ceil($totalbc / $limit);
//            for ($i = 0; $i < $batch; ++$i) {
//                $limitStart = $i * $limit;
//                $transaction_models = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->select(['bc_application_id', 'no_of_transaction', 'transaction_start_date'])->limit($limit)->offset($limitStart)->orderBy('bc_application_id asc')->all();
//                foreach ($transaction_models as $transaction) {
//                    if ($transaction->bc->training_status == 3) {
//                        if ($transaction->bc->bc_operational == 0) {
//                            $condition1 = ['and',
//                                ['=', 'gram_panchayat_code', $transaction->bc->gram_panchayat_code],
//                            ];
//                            \bc\modules\selection\models\BcGramPanchayat::updateAll([
//                                're_calculate' => 0,
//                                    ], $condition1);
//                        }
//                        $condition = ['and',
//                            ['=', 'id', $transaction->bc_application_id],
//                        ];
//                        \bc\modules\selection\models\SrlmBcApplication::updateAll([
//                            'bc_operational' => 1,
//                            'no_of_transaction' => isset($transaction->no_of_transaction) ? $transaction->no_of_transaction : 0,
//                            'transaction_start_date' => $transaction->transaction_start_date
//                                ], $condition);
//                    } else {
//                        $condition2 = ['and',
//                            ['=', 'bc_application_id', $transaction->bc_application_id],
//                        ];
//                        \bc\modules\transaction\models\summary\BcTransactionBcSummary::updateAll([
//                            'bc_status' => 0,
//                                ], $condition2);
//                    }
//                }
//            }
//            echo "BC operational End Time : " . date('Y-m-d H:i:s');
//        } catch (\Exception $exc) {
//            echo $exc->getMessage();
//        }
//    }

    public function actionOperational2() {
        $null = new \yii\db\Expression('NULL');
        try {
            echo "BC operational Start Time : " . date('Y-m-d H:i:s');
            $totalbc = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->select(['bc_application_id'])->count();
            $limit = 1000;
            $batch = ceil($totalbc / $limit);
            for ($i = 0; $i < $batch; ++$i) {
                $limitStart = $i * $limit;
                $transaction_models = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->select(['bc_application_id', 'no_of_transaction', 'transaction_start_date'])->limit($limit)->offset($limitStart)->orderBy('bc_application_id asc')->all();
                foreach ($transaction_models as $transaction) {
                    if ($transaction->bc->training_status == 3) {

                        if ($transaction->bc->bc_operational == 0) {
                            $condition1 = ['and',
                                ['=', 'gram_panchayat_code', $transaction->bc->gram_panchayat_code],
                            ];
                            \bc\modules\selection\models\BcGramPanchayat::updateAll([
                                're_calculate' => 0,
                                    ], $condition1);
                        }
                        $condition = ['and',
                            ['=', 'id', $transaction->bc_application_id],
                        ];
                        \bc\modules\selection\models\SrlmBcApplication::updateAll([
                            'bc_operational' => 1,
                            'no_of_transaction' => isset($transaction->no_of_transaction) ? $transaction->no_of_transaction : 0,
                            'transaction_start_date' => $transaction->transaction_start_date
                                ], $condition);
                        $condition2 = ['and',
                            ['=', 'bc_application_id', $transaction->bc_application_id],
                        ];
                        \bc\modules\transaction\models\summary\BcTransactionBcSummary::updateAll([
                            'bc_status' => 1,
                                ], $condition2);
                    } else {
                        $condition = ['and',
                            ['=', 'id', $transaction->bc_application_id],
                        ];
                        \bc\modules\selection\models\SrlmBcApplication::updateAll([
                            'bc_operational' => 0,
                                ], $condition);
                        $condition2 = ['and',
                            ['=', 'bc_application_id', $transaction->bc_application_id],
                        ];
                        \bc\modules\transaction\models\summary\BcTransactionBcSummary::updateAll([
                            'bc_status' => 0,
                                ], $condition2);
                    }
                }
            }
            echo "BC operational End Time : " . date('Y-m-d H:i:s');
        } catch (\Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function actionCpptm() {
        echo "BC copy ptm start Time : " . date('Y-m-d H:i:s');
        $paytmbc = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->where(['change_bank' => 0, 'master_partner_bank_id' => 6])->all();
        $sr_no = 1;
        foreach ($paytmbc as $bc1) {
            $bc1->change_bank = 1;
            if ($bc1->save()) {
                $bc = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryBankChange();
                $bc->id = $bc1->id;
                $bc->setAttributes($bc1->toArray());
                $bc->created_at = time();
                if ($bc->save()) {
                    $sr_no++;
                }
            }
        }
        echo $sr_no . " copy BC copy ptm end Time : " . date('Y-m-d H:i:s');
    }
}
