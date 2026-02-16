<?php

namespace bc\modules\transaction\commands;

use Yii;
use bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily;
use bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly;

class BcController extends \yii\console\Controller {

    public $bcdbconnectionname = 'bctransactiondistrict';
    public $bctable = 'bc_transaction_bc_';

    /**
     * Start Processing and Insert record into db
     *
     * @return void
     */
    public function actionTable() {
        try {
            $sql = "select count(*) as tot from srlm_bc_application where status=2 and transaction_table=0 and training_status in (3,32) order by district_code asc";
            $result = \Yii::$app->dbbc->createCommand($sql)->queryAll();
            $total_bc = $result[0]['tot'];
            $limit = 1000;
            $batch = ceil($total_bc / $limit);
            for ($i = 0; $i < $batch; ++$i) {
                $sql = "select id,district_code from srlm_bc_application where status=2 and transaction_table=0 and training_status in (3,32) order by district_code asc limit 1000";
                $srlmbslist = \Yii::$app->dbbc->createCommand($sql)->queryAll();
                if ($srlmbslist) {
                    foreach ($srlmbslist as $srlmbc) {
                        $dbconnectionnme = "bctransactiondistrict" . $srlmbc['district_code'];
                        $table = "bc_transaction_bc_" . $srlmbc['id'];
//                        $command1 = "DROP TABLE IF EXISTS `$table`";
                        $command2 = "CREATE TABLE IF NOT EXISTS `$table` (
                            `id` int NOT NULL,
                            `bc_application_id` int DEFAULT NULL,
                            `bankidbc` varchar(20) DEFAULT NULL,
                            `district_code` int DEFAULT NULL,
                            `block_code` int DEFAULT NULL,
                            `gram_panchayat_code` int DEFAULT NULL,
                            `master_partner_bank_id` int DEFAULT NULL,
                            `file_id` int DEFAULT NULL,
                            `dtable_id` int DEFAULT NULL,
                            `banktransactionid` varchar(40) DEFAULT NULL,
                            `transaction_datetime` datetime DEFAULT NULL,
                            `transaction_date` date DEFAULT NULL,
                            `transaction_time` time DEFAULT NULL,
                            `transaction_amount` double DEFAULT NULL,
                            `transaction_type` varchar(255) DEFAULT NULL,
                            `ticket` tinyint NOT NULL DEFAULT '0',
                            `commission_amount` double DEFAULT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
                        $command3 = "ALTER TABLE `$table`
                            ADD PRIMARY KEY (`id`),
                            ADD KEY `index_bc_application_id` (`bc_application_id`),
                            ADD KEY `index_bankidbc` (`bankidbc`),
                            ADD KEY `index_district_code` (`district_code`),
                            ADD KEY `index_block_code` (`block_code`),
                            ADD KEY `index_gram_panchayat_code` (`gram_panchayat_code`),
                            ADD KEY `file_id` (`file_id`),
                            ADD CONSTRAINT `unique_banktransactionid` UNIQUE (`banktransactionid`),
                            ADD KEY `transaction_type` (`transaction_type`),
                            ADD KEY `transaction_date` (`transaction_date`),
                            ADD KEY `index_ticket` (`ticket`),
                            ADD KEY `master_partner_bank_id` (`master_partner_bank_id`);";

                        $command4 = "ALTER TABLE `$table`
                        MODIFY `id` int NOT NULL AUTO_INCREMENT;";
                        $con = \Yii::$app->getModule('transaction')->$dbconnectionnme;
//                        $con->createCommand($command1)->execute();
                        $con->createCommand($command2)->execute();
                        $con->createCommand($command3)->execute();
                        $con->createCommand($command4)->execute();
                        $sqlupdate = "UPDATE `srlm_bc_application` SET `transaction_table` = '1' WHERE `srlm_bc_application`.`id` =" . $srlmbc['id'];
                        \Yii::$app->dbbctransaction->createCommand($sqlupdate)->execute();
                        \Yii::$app->dbbc->createCommand($sqlupdate)->execute();
                    }
                }
            }
        } catch (\Exception $ex) {

            print_r($ex->getMessage());
        }
    }

    public function actionTablealter() {
        try {
            echo "BC Tansaction dump alter table Start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
            $sql = "select id,district_code from srlm_bc_application where status=2 and transaction_table=1 order by district_code asc limit 5000";
            $srlmbslist = \Yii::$app->dbbc->createCommand($sql)->queryAll();
            if ($srlmbslist) {
                foreach ($srlmbslist as $srlmbc) {
                    $dbconnectionnme = "bctransactiondistrict" . $srlmbc['district_code'];
                    $table = "bc_transaction_bc_" . $srlmbc['id'];
                    $con = \Yii::$app->getModule('transaction')->$dbconnectionnme;
                    $tableSchema = \Yii::$app->getModule('transaction')->$dbconnectionnme->schema->getTableSchema($table);
                    if ($tableSchema != null) {

                        $tables = \Yii::$app->getModule('transaction')->$dbconnectionnme->schema->getTableSchema($table);
                        if (!isset($tables->columns['time_gap'])) {
//                            echo $dbconnectionnme . PHP_EOL;
//                            echo $table . PHP_EOL;
                            //print_r($tables);
                            $command = "ALTER TABLE `$table`
                        ADD `time_gap` INT NULL AFTER `commission_amount`;";
                            $con->createCommand($command)->execute();
                            $sqlupdate = "UPDATE `srlm_bc_application` SET `transaction_table` = '2' WHERE `srlm_bc_application`.`id` =" . $srlmbc['id'];
                            \Yii::$app->dbbctransaction->createCommand($sqlupdate)->execute();
                            \Yii::$app->dbbc->createCommand($sqlupdate)->execute();
                        }
                    }
                }
            }
            echo "BC Tansaction dump alter table End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        } catch (\Exception $ex) {

            print_r($ex->getMessage());
        }
    }

    public function actionMreport($month_id = 37) {
        echo "start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        $models = \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::find()->andWhere(['>=', 'month_id', $month_id])->orderBy(['month_id' => SORT_DESC, 'id' => SORT_ASC])->all();
        $file = "bc_transaction_monthly_" . date("Y_m_d_H-m-s") . ".csv";
        $file_path = Yii::$app->params['datapath'] . 'tmp/' . '' . $file;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $output = fopen($file_path, 'w');
        fputcsv($output, array('Srl. No.', 'Application No', 'Name', 'District', 'Block', 'GP', 'Partner Agency', 'Month', 'No. of transaction', 'Txn Amount', 'Commission Amount', 'No. Of Days', 'Working Days', 'Non Working Days', 'NRETP'));
        $sr_no = 1;
        $row = [];
        foreach ($models as $model) {
            $row = [
                $sr_no,
                isset($model->bc) ? $model->bc->application_id : '',
                isset($model->bc) ? $model->bc->name : '',
                isset($model->district) ? $model->district->district_name : '',
                isset($model->block) ? $model->block->block_name : '',
                isset($model->gp) ? str_replace(',', ' ', $model->gp->gram_panchayat_name) : '',
                isset($model->pbank) ? $model->pbank->bank_short_name : '',
                isset($model->month_start_date) ? \Yii::$app->formatter->asDatetime($model->month_start_date, "php:M-Y") : '',
                isset($model->no_of_transaction) ? $model->no_of_transaction : '',
                $model->transaction_amount,
                isset($model->commission_amount) ? round($model->commission_amount, 2) : '',
                isset($model->total_day) ? $model->total_day : '',
                isset($model->total_working_day) ? $model->total_working_day : '',
                isset($model->total_not_working_day) ? $model->total_not_working_day : '',
                (isset($model->block->nretp) and $model->block->nretp == 1) ? 'Yes' : 'No',
            ];
            fputcsv($output, $row);
            $sr_no++;
        }
        echo "End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
    }

    public function actionMr() {
        $null = new \yii\db\Expression('NULL');
        try {
            echo "BC m Start Time : " . date('Y-m-d H:i:s');
            $totalbc = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->select(['bc_application_id'])->count();
            $limit = 1000;
            $batch = ceil($totalbc / $limit);
            for ($i = 0; $i < $batch; ++$i) {
                $limitStart = $i * $limit;
                $transaction_models = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->limit($limit)->offset($limitStart)->orderBy('bc_application_id asc')->all();
                foreach ($transaction_models as $transaction) {
                    if ($transaction->bc->training_status == 3) {
                        $mbcsakhi = \bc\modules\transaction\models\summary\TempBcSummaryMonthly::findOne(['bc_application_id' => $transaction->bc->id]);
                        if ($mbcsakhi == null) {
                            $mbcsakhi = new \bc\modules\transaction\models\summary\TempBcSummaryMonthly();
                        }
                        $mbcsakhi->bc_application_id = $transaction->bc_application_id;
                        $mbcsakhi->bankidbc = $transaction->bankidbc;
                        $mbcsakhi->district_code = $transaction->district_code;
                        $mbcsakhi->block_code = $transaction->block_code;
                        $mbcsakhi->gram_panchayat_code = $transaction->gram_panchayat_code;
                        $mbcsakhi->master_partner_bank_id = $transaction->master_partner_bank_id;
                        $mbcsakhi->district_name = $transaction->bc->district_name;
                        $mbcsakhi->block_name = $transaction->bc->block_name;
                        $mbcsakhi->gram_panchayat_name = str_replace(',', ' ', $transaction->bc->gram_panchayat_name);
                        $mbcsakhi->partner_agency = $transaction->pbank->bank_short_name;
                        $mbcsakhi->bc_sakhi = $transaction->bc->name;
                        $mbcsakhi->transaction_start_date = $transaction->transaction_start_date;
                        $mbcsakhi->total_day = $transaction->total_day;
                        $mbcsakhi->total_working_day = $transaction->total_working_day;
                        $mbcsakhi->total_not_working_day = $transaction->total_not_working_day;
                        $mbcsakhi->no_of_transaction = $transaction->no_of_transaction;
                        $mbcsakhi->no_of_actual_transaction = $transaction->no_of_actual_transaction;
                        $mbcsakhi->zero_transaction = $transaction->zero_transaction;
                        $mbcsakhi->transaction_amount = $transaction->transaction_amount;
                        $mbcsakhi->commission_amount = $transaction->commission_amount;
                        $mbcsakhi->start_month_name = $transaction->start_month_name;
                        $mbcsakhi->last_month_name = $transaction->last_month_name;
                        $mbcsakhi->aspirational = $transaction->block->aspirational;
                        $mbcsakhi->nretp = $transaction->block->nretp;
                        $mbcsakhi->status = $transaction->gp->status;
                        $mbcsakhi->update_on = new \yii\db\Expression('NOW()');
                        $m202401 = BcTransactionBcSummaryMonthly::findOne(['bc_application_id' => $transaction->bc_application_id, 'month_id' => 37]);
                        if ($m202401 != null) {
                            $mbcsakhi->no_of_transaction202401 = $m202401->no_of_transaction;
                            $mbcsakhi->transaction_amount202401 = $m202401->transaction_amount;
                            $mbcsakhi->commission_amount202401 = $m202401->commission_amount;
                        }
                        $m202402 = BcTransactionBcSummaryMonthly::findOne(['bc_application_id' => $transaction->bc_application_id, 'month_id' => 38]);
                        if ($m202402 != null) {
                            $mbcsakhi->no_of_transaction202402 = $m202402->no_of_transaction;
                            $mbcsakhi->transaction_amount202402 = $m202402->transaction_amount;
                            $mbcsakhi->commission_amount202402 = $m202402->commission_amount;
                        }
                        $m202403 = BcTransactionBcSummaryMonthly::findOne(['bc_application_id' => $transaction->bc_application_id, 'month_id' => 39]);
                        if ($m202403 != null) {
                            $mbcsakhi->no_of_transaction202403 = $m202403->no_of_transaction;
                            $mbcsakhi->transaction_amount202403 = $m202403->transaction_amount;
                            $mbcsakhi->commission_amount202403 = $m202403->commission_amount;
                        }
                        $m202404 = BcTransactionBcSummaryMonthly::findOne(['bc_application_id' => $transaction->bc_application_id, 'month_id' => 40]);
                        if ($m202404 != null) {
                            $mbcsakhi->no_of_transaction202404 = $m202404->no_of_transaction;
                            $mbcsakhi->transaction_amount202404 = $m202404->transaction_amount;
                            $mbcsakhi->commission_amount202404 = $m202404->commission_amount;
                        }
                        $m202405 = BcTransactionBcSummaryMonthly::findOne(['bc_application_id' => $transaction->bc_application_id, 'month_id' => 41]);
                        if ($m202405 != null) {
                            $mbcsakhi->no_of_transaction202405 = $m202405->no_of_transaction;
                            $mbcsakhi->transaction_amount202405 = $m202405->transaction_amount;
                            $mbcsakhi->commission_amount202405 = $m202405->commission_amount;
                        }
                        $m202406 = BcTransactionBcSummaryMonthly::findOne(['bc_application_id' => $transaction->bc_application_id, 'month_id' => 42]);
                        if ($m202406 != null) {
                            $mbcsakhi->no_of_transaction202406 = $m202406->no_of_transaction;
                            $mbcsakhi->transaction_amount202406 = $m202406->transaction_amount;
                            $mbcsakhi->commission_amount202406 = $m202406->commission_amount;
                        }
                        $m202407 = BcTransactionBcSummaryMonthly::findOne(['bc_application_id' => $transaction->bc_application_id, 'month_id' => 43]);
                        if ($m202407 != null) {
                            $mbcsakhi->no_of_transaction202407 = $m202407->no_of_transaction;
                            $mbcsakhi->transaction_amount202407 = $m202407->transaction_amount;
                            $mbcsakhi->commission_amount202407 = $m202407->commission_amount;
                        }
                        $m202408 = BcTransactionBcSummaryMonthly::findOne(['bc_application_id' => $transaction->bc_application_id, 'month_id' => 44]);
                        if ($m202408 != null) {
                            $mbcsakhi->no_of_transaction202408 = $m202408->no_of_transaction;
                            $mbcsakhi->transaction_amount202408 = $m202408->transaction_amount;
                            $mbcsakhi->commission_amount202408 = $m202408->commission_amount;
                        }
                        $mbcsakhi->save();
                    } else {
                        $mbcsakhi = \bc\modules\transaction\models\summary\TempBcSummaryMonthly::findOne(['bc_application_id' => $transaction->bc->id]);
                        if ($mbcsakhi == null) {
                            $mbcsakhi = new \bc\modules\transaction\models\summary\TempBcSummaryMonthly();
                        }
                        $mbcsakhi->bc_application_id = $transaction->bc_application_id;
                        $mbcsakhi->bankidbc = $transaction->bankidbc;
                        $mbcsakhi->district_code = $transaction->district_code;
                        $mbcsakhi->block_code = $transaction->block_code;
                        $mbcsakhi->gram_panchayat_code = $transaction->gram_panchayat_code;
                        $mbcsakhi->master_partner_bank_id = $transaction->master_partner_bank_id;
                        $mbcsakhi->district_name = $transaction->bc->district_name;
                        $mbcsakhi->block_name = $transaction->bc->block_name;
                        $mbcsakhi->gram_panchayat_name = str_replace(',', ' ', $transaction->bc->gram_panchayat_name);
                        $mbcsakhi->partner_agency = $transaction->pbank->bank_short_name;
                        $mbcsakhi->bc_sakhi = $transaction->bc->name;
                        $mbcsakhi->transaction_start_date = $transaction->transaction_start_date;
                        $mbcsakhi->total_day = $transaction->total_day;
                        $mbcsakhi->total_working_day = $transaction->total_working_day;
                        $mbcsakhi->total_not_working_day = $transaction->total_not_working_day;
                        $mbcsakhi->no_of_transaction = $transaction->no_of_transaction;
                        $mbcsakhi->no_of_actual_transaction = $transaction->no_of_actual_transaction;
                        $mbcsakhi->zero_transaction = $transaction->zero_transaction;
                        $mbcsakhi->transaction_amount = $transaction->transaction_amount;
                        $mbcsakhi->commission_amount = $transaction->commission_amount;
                        $mbcsakhi->start_month_name = $transaction->start_month_name;
                        $mbcsakhi->last_month_name = $transaction->last_month_name;
                        $mbcsakhi->aspirational = $transaction->block->aspirational;
                        $mbcsakhi->nretp = $transaction->block->nretp;
                        $mbcsakhi->status = 0;
                        $mbcsakhi->update_on = new \yii\db\Expression('NOW()');
                        $m202401 = BcTransactionBcSummaryMonthly::findOne(['bc_application_id' => $transaction->bc_application_id, 'month_id' => 37]);
                        if ($m202401 != null) {
                            $mbcsakhi->no_of_transaction202401 = $m202401->no_of_transaction;
                            $mbcsakhi->transaction_amount202401 = $m202401->transaction_amount;
                            $mbcsakhi->commission_amount202401 = $m202401->commission_amount;
                        }
                        $m202402 = BcTransactionBcSummaryMonthly::findOne(['bc_application_id' => $transaction->bc_application_id, 'month_id' => 38]);
                        if ($m202402 != null) {
                            $mbcsakhi->no_of_transaction202402 = $m202402->no_of_transaction;
                            $mbcsakhi->transaction_amount202402 = $m202402->transaction_amount;
                            $mbcsakhi->commission_amount202402 = $m202402->commission_amount;
                        }
                        $m202403 = BcTransactionBcSummaryMonthly::findOne(['bc_application_id' => $transaction->bc_application_id, 'month_id' => 39]);
                        if ($m202403 != null) {
                            $mbcsakhi->no_of_transaction202403 = $m202403->no_of_transaction;
                            $mbcsakhi->transaction_amount202403 = $m202403->transaction_amount;
                            $mbcsakhi->commission_amount202403 = $m202403->commission_amount;
                        }
                        $m202404 = BcTransactionBcSummaryMonthly::findOne(['bc_application_id' => $transaction->bc_application_id, 'month_id' => 40]);
                        if ($m202404 != null) {
                            $mbcsakhi->no_of_transaction202404 = $m202404->no_of_transaction;
                            $mbcsakhi->transaction_amount202404 = $m202404->transaction_amount;
                            $mbcsakhi->commission_amount202404 = $m202404->commission_amount;
                        }
                        $m202405 = BcTransactionBcSummaryMonthly::findOne(['bc_application_id' => $transaction->bc_application_id, 'month_id' => 41]);
                        if ($m202405 != null) {
                            $mbcsakhi->no_of_transaction202405 = $m202405->no_of_transaction;
                            $mbcsakhi->transaction_amount202405 = $m202405->transaction_amount;
                            $mbcsakhi->commission_amount202405 = $m202405->commission_amount;
                        }
                        $m202406 = BcTransactionBcSummaryMonthly::findOne(['bc_application_id' => $transaction->bc_application_id, 'month_id' => 42]);
                        if ($m202406 != null) {
                            $mbcsakhi->no_of_transaction202406 = $m202406->no_of_transaction;
                            $mbcsakhi->transaction_amount202406 = $m202406->transaction_amount;
                            $mbcsakhi->commission_amount202406 = $m202406->commission_amount;
                        }
                        $m202407 = BcTransactionBcSummaryMonthly::findOne(['bc_application_id' => $transaction->bc_application_id, 'month_id' => 43]);
                        if ($m202407 != null) {
                            $mbcsakhi->no_of_transaction202407 = $m202407->no_of_transaction;
                            $mbcsakhi->transaction_amount202407 = $m202407->transaction_amount;
                            $mbcsakhi->commission_amount202407 = $m202407->commission_amount;
                        }
                        $m202408 = BcTransactionBcSummaryMonthly::findOne(['bc_application_id' => $transaction->bc_application_id, 'month_id' => 44]);
                        if ($m202408 != null) {
                            $mbcsakhi->no_of_transaction202408 = $m202408->no_of_transaction;
                            $mbcsakhi->transaction_amount202408 = $m202408->transaction_amount;
                            $mbcsakhi->commission_amount202408 = $m202408->commission_amount;
                        }
                        $mbcsakhi->save();
                    }
                }
            }
            echo "BC m End Time : " . date('Y-m-d H:i:s');
        } catch (\Exception $exc) {
            echo $exc->getMessage();
        }
    }

//    public function actionTrun() {
//        //$my_current_ip = exec("ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'");
//        $district = \bc\models\master\MasterDistrict::find()->orderBy('district_code asc')->all();
//        echo "truncate bc table start : " . date('Y-m-d H:i:s');
//
//        $bcdailybcsummarymodel = \bc\modules\transaction\models\dump\BcTransactionBank6::find()->select(['bc_application_id', 'district_code'])->all();
//        if (isset($bcdailybcsummarymodel)) {
//            foreach ($bcdailybcsummarymodel as $bcdailysummary) {
//                if ($bcdailysummary->bc_application_id) {
//                    $dbconnectionnme = $this->bcdbconnectionname . $bcdailysummary->district_code;
//                    $con = \Yii::$app->getModule('transaction')->$dbconnectionnme;
//                    $bctable = $this->bctable . $bcdailysummary->bc_application_id;
//                    $sqltrun = "TRUNCATE TABLE $bctable ";
//                    $con->createCommand($sqltrun)->execute();
//                }
//            }
//        }
//
//        echo "truncate bc table complete " . date('Y-m-d H:i:s');
//    }
//    public function actionTrunbc($dis) {
//        $my_current_ip = exec("ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'");
//
////        if ($my_current_ip == '192.168.29.17') {
//        $bcdailybcsummarymodel = \bc\modules\selection\models\SrlmBcApplication::find()->select(['id', 'district_code'])->where(['status' => 2, 'transaction_table' => 1, 'training_status' => [3, 32], 'district_code' => $dis])->orderBy('district_code asc')->all();
//        if (isset($bcdailybcsummarymodel)) {
//            foreach ($bcdailybcsummarymodel as $bcdailysummary) {
//                $dbconnectionnme = $this->bcdbconnectionname . $bcdailysummary->district_code;
//                $bctable = $this->bctable . $bcdailysummary->id;
//                $con = \Yii::$app->getModule('transaction')->$dbconnectionnme;
//                $sqltrun = "TRUNCATE TABLE $bctable ";
//                $con->createCommand($sqltrun)->execute();
//            }
//        }
////        }
//    }
}
