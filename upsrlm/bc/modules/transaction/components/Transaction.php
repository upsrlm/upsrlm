<?php

namespace bc\modules\transaction\components;

use Yii;
use yii\base\Component;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use common\models\User;
use common\models\base\GenralModel;
use bc\modules\transaction\models\dump\BcTransactionFiles;
use bc\modules\selection\models\SrlmBcApplication;
use bc\modules\transaction\models\summary\BcTransactionBcSummaryDaily;

ini_set('max_execution_time', -1);

class Transaction extends Component {

    public $master_partner_bank_id;
    public $file_model;
    public $new = 0;
    public $repeats = 0;
    public $error = 0;
    public $error_option = [11 => 'Error in user id', 12 => 'Error in transaction id', 13 => 'Error in Txn amount', 14 => 'Error in BC commission amount', 15 => 'Error in Txn type', 16 => 'Error in Time stamp', 17 => 'Error other', 18 => 'Error BC GP Urban'];
    public $DumoModelClass = '\bc\modules\transaction\models\dump\BcTransactionDump';
    public $BankModelClass = '\bc\modules\transaction\models\dump\BcTransactionBank';
    public $bctable = 'bc_transaction_bc_';
    public $banktable = 'bc_transaction_bank_';
    public $bank_batch_data;
    public $bcdbconnectionname = 'bctransactiondistrict';
    public $week_model;
    public $week_id;
    public $week_start_date;
    public $week_end_date;
    public $month_model;
    public $month_id;
    public $month_start_date;
    public $month_end_date;
    public $bcid_date_temp;
    public $bankid_array;
    public $file_process = 0;

    const STATUS_NEW = 1;
    const STATUS_REPEATS = 2;
    const STATUS_ERROR_BC_NOT_FOUND = 11;
    const STATUS_ERROR_TRANSACTION_ID = 12;
    const STATUS_ERROR_TXN_AMOUNT = 13;
    const STATUS_ERROR_BC_COM_AMOUNT = 14;
    const STATUS_ERROR_TXN_TYPE = 15;
    const STATUS_ERROR_TXN_DATE_TIME = 16;
    const STATUS_ERROR_GENRIC = 17;
    const STATUS_ERROR_URBAN_GP = 18;
    const BIG_SMALL_TICKET = 2000;
    const SMALL_TICKET = 1;
    const BIG_TICKET = 2;
    const RAW_DUMP_PROSSESS_LIMIT = 250;
    const DAILY_SUMMARY_PROSSESS_LIMIT = 1500;
    const BOB = 1;
    const FINO = 2;
    const NEARBY = 3;
    const MANIPAL = 4;
    const MFSL_AIRTEl = 5;
    const PTM = 6;

    public function rawdump($file_model) {
        //echo Yii::$app->params['datapath'] . 'partneragencies' . '/transaction/' . $file_model->master_partner_bank_id . '/' . $file_model->file_name;exit;
        $fp = fopen(Yii::$app->params['datapath'] . 'partneragencies' . '/transaction/' . $file_model->master_partner_bank_id . '/' . $file_model->file_name, 'r');
        $rawdumpmodeld = $this->DumoModelClass . $file_model->master_partner_bank_id;
        $rawdumpmodeld::deleteAll('file_id = :file_id', [':file_id' => $file_model->id]);
        $file_model->new_process = 1;
        $file_model->update();
        $line = fgetcsv($fp, 1000, ",");
        $first_time = true;
        $sr_no = 1;
        try {
            do {
                if ($first_time == true) {
                    $first_time = false;
                    $sr_no++;
                    continue;
                } else {
                    $rawdumpmodel = $this->DumoModelClass . $file_model->master_partner_bank_id;
                    $dmodel = new $rawdumpmodel();
                    $dmodel->col0 = $line[0];
                    $dmodel->col1 = $line[1];
                    $dmodel->col2 = $line[2];
                    $dmodel->col3 = $line[3];
                    $dmodel->col4 = $line[4];
                    $dmodel->col5 = $line[5];
                    $dmodel->col6 = (string) $sr_no;
                    $dmodel->file_id = $file_model->id;
                    $dmodel->master_partner_bank_id = $file_model->master_partner_bank_id;
                    $dmodel->save();
                }
                $sr_no++;
            } while (($line = fgetcsv($fp, 1000, ",")) != FALSE);
            $file_model->new_process = 2;
            $file_model->update();
        } catch (\Exception $ex) {
            $file_model->new_process = BcTransactionFiles::STATUS_FILE_ERROR;
            $file_model->update();
        }
        return true;
    }

    public function bankdump($file_model) {
        $file_model = BcTransactionFiles::findOne($file_model->id);
        $file_path = Yii::$app->params['datapath'] . 'partneragencies' . '/transaction/' . $file_model->master_partner_bank_id . '/';
        $file_csv_path = Yii::$app->params['datapath'] . 'partneragencies' . '/transaction/' . $file_model->master_partner_bank_id . '/' . $file_model->file_name;
        $file_csv_name = basename($file_csv_path, ".csv");
        $error_file_name = $file_csv_name . '_error';
        $rawdumpmodel = $this->DumoModelClass . $file_model->master_partner_bank_id;
        $bankdumpmodel = $this->BankModelClass . $file_model->master_partner_bank_id;
        $bank_table = $this->banktable . $file_model->master_partner_bank_id;
        $upload_transaction_data = $rawdumpmodel::find()->where(['file_id' => $file_model->id, 'status' => 0])->limit(self::RAW_DUMP_PROSSESS_LIMIT)->all();
        if ($upload_transaction_data != null) {
            $this->bank_batch_data = [];
            foreach ($upload_transaction_data as $dmodel) {
                $this->saveintobank($dmodel);
            }
//            if (!empty($this->bank_batch_data)) {
//                \Yii::$app->getModule('transaction')->bctransactiondump->createCommand()->batchInsert($bank_table,
//                        [
//                            'bc_application_id',
//                            'bankidbc',
//                            'master_partner_bank_id',
//                            'district_code',
//                            'block_code',
//                            'gram_panchayat_code',
//                            'file_id',
//                            'dtable_id',
//                            'banktransactionid',
//                            'transaction_datetime',
//                            'transaction_date',
//                            'transaction_time',
//                            'transaction_amount',
//                            'transaction_type',
//                            'ticket'
//                        ],
//                        $this->bank_batch_data)->execute();
//            }
            //exit();// after 500 record insert in bank table
            $this->bankdump($file_model);
        } else {
            $file_model->new_process = 3;
            $file_model->new = $rawdumpmodel::find()->where(['file_id' => $file_model->id])->andWhere(['=', 'status', self::STATUS_NEW])->count();
            $file_model->repeats = $rawdumpmodel::find()->where(['file_id' => $file_model->id])->andWhere(['=', 'status', self::STATUS_REPEATS])->count();
            $file_model->error = $rawdumpmodel::find()->where(['file_id' => $file_model->id])->andWhere(['>', 'status', 10])->count();
            $file_model->save();
            if (file_exists($file_path . $error_file_name . '.csv')) {
                rename($file_path . $error_file_name . '.csv', $file_path . $error_file_name . '_old' . '.csv');
            }
            $error_models = $rawdumpmodel::find()->where(['file_id' => $file_model->id])->andWhere(['>', 'status', 10])->all();
            $csv = "row_number,usr_id,txn_id,product_type,txn_value,datetime,bc_commison,Error \n";
            foreach ($error_models as $em) {
                $csv .= $em->col6 . "," . '"' . $em->col0 . '","' . $em->col1 . '","' . $em->col2 . '","' . $em->col3 . '","' . $em->col4 . '","' . $em->col5 . '",' . $this->error_option[$em->status] . "\n";
            }
            $error_csv_handler = fopen($file_path . $error_file_name . '.csv', 'w');
            fwrite($error_csv_handler, $csv);
            fclose($error_csv_handler);
            return true;
        }
        return true;
    }

    protected function saveintobank($data) {
        $bankmodel = $this->BankModelClass . $data->master_partner_bank_id;
        $transaction_model = $bankmodel::find()->select(['id'])->where(['banktransactionid' => $data->col1])->limit(1)->one();
        if ($transaction_model != null) {
            $transaction_model = $bankmodel::findOne($transaction_model->id);
            $this->updatebcdailysummary($transaction_model);
            $this->deletebank($transaction_model);
            $this->deletebctable($transaction_model);
            $this->insertintobank($data, self::STATUS_REPEATS);
        } else {
            $this->insertintobank($data);
        }
    }

    protected function deletebank($data) {
        $bankmodel = $this->BankModelClass . $data->master_partner_bank_id;
        $bankdump = $bankmodel::find()
                ->where(['banktransactionid' => $data->banktransactionid])
                ->one()
                ->delete();
        return $bankdump;
    }

    protected function deletebctable($data) {
        if ($data->bc_application_id) {
            $dbconnectionnme = $this->bcdbconnectionname . $data->district_code;
            $bctable = $this->bctable . $data->bc_application_id;
            $banktransactionid = (string) $data->banktransactionid;
            $delquery = "DELETE FROM $bctable WHERE banktransactionid='" . $data->banktransactionid . "'";
            $x = \Yii::$app->getModule('transaction')->$dbconnectionnme->createCommand($delquery)->execute();
            return $x;
        }
    }

    protected function insertintobank($data, $new = self::STATUS_NEW) {
        $bankmodel = $this->BankModelClass . $data->master_partner_bank_id;
        if (!isset($this->bankid_array[$data->col0])) {
            $app_model = SrlmBcApplication::find()->select(['id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'user_id', 'blocked'])->where(['master_partner_bank_id' => $data->master_partner_bank_id, 'bankidbc' => $data->col0, 'training_status' => 3])->limit(1)->one();
            if ($app_model != null) {
                $temp = [];
                $temp[$app_model->id] = [
                    'id' => $app_model->id,
                    'district_code' => $app_model->district_code,
                    'block_code' => $app_model->block_code,
                    'gram_panchayat_code' => $app_model->gram_panchayat_code,
                    'master_partner_bank_id' => $app_model->master_partner_bank_id,
                    'blocked' => $app_model->blocked
                ];
                $this->bankid_array[$data->col0] = $temp;
            } else {
//                $app_model = \bc\modules\selection\models\SrlmBcApplicationHistory::find()->select(['id', 'parent_id', 'district_code', 'block_code', 'gram_panchayat_code', 'master_partner_bank_id', 'user_id', 'blocked'])->where(['master_partner_bank_id' => $data->master_partner_bank_id, 'bankidbc' => $data->col0])->limit(1)->one();
//                if ($app_model != null) {
//                    $temp1 = [];
//                    $temp1[$app_model->bc->id] = [
//                        'id' => $app_model->bc->id,
//                        'district_code' => $app_model->bc->district_code,
//                        'block_code' => $app_model->bc->block_code,
//                        'gram_panchayat_code' => $app_model->bc->gram_panchayat_code,
//                        'master_partner_bank_id' => $app_model->bc->master_partner_bank_id,
//                        'blocked' => $app_model->bc->blocked
//                    ];
//                    $this->bankid_array[$data->col0] = $temp1;
//                }
            }
        }

        $transaction_model = new $bankmodel();
        $urban_gp = 0;
        if (isset($this->bankid_array[$data->col0])) {
            $bc_application_id_kys = array_keys($this->bankid_array[$data->col0]);
            $transaction_model->bc_application_id = $bc_application_id_kys[0];
            $transaction_model->district_code = $this->bankid_array[$data->col0][$transaction_model->bc_application_id]['district_code'];
            $transaction_model->block_code = $this->bankid_array[$data->col0][$transaction_model->bc_application_id]['block_code'];
            $transaction_model->gram_panchayat_code = $this->bankid_array[$data->col0][$transaction_model->bc_application_id]['gram_panchayat_code'];
            if ($this->bankid_array[$data->col0][$transaction_model->bc_application_id]['blocked'] == 2) {
                $urban_gp = 1;
            }
            if ($this->bankid_array[$data->col0][$transaction_model->bc_application_id]['blocked'] == 21) {
                $urban_gp = 1;
            }
        }
//        if ($app_model != null) {
//            $transaction_model->bc_application_id = $app_model->id;
//            $transaction_model->district_code = $app_model->district_code;
//            $transaction_model->block_code = $app_model->block_code;
//            $transaction_model->gram_panchayat_code = $app_model->gram_panchayat_code;
//            if ($app_model->blocked == 2) {
//                $urban_gp = 1;
//            }
//        }
        if (strpos($data->col0, 'E+') !== false) {
            $transaction_model->bankidbc = '';
        } else {
            $transaction_model->bankidbc = $data->col0;
        }
        $transaction_model->master_partner_bank_id = $data->master_partner_bank_id;
        $transaction_model->file_id = $data->file_id;
        $transaction_model->dtable_id = $data->id;
        if (strpos($data->col1, 'E+') !== false) {
            $transaction_model->banktransactionid = '';
        } else {
            $transaction_model->banktransactionid = $data->col1;
        }
        if ($data->master_partner_bank_id == self::BOB) {
            $transaction_model->transaction_datetime = \common\helpers\Utility::tbcdateformatdb($data->col4);
        } else {
            $transaction_model->transaction_datetime = $data->col4;
        }
        $transaction_model->transaction_amount = $data->col3;
        $transaction_model->transaction_type = $data->col2;
        $transaction_model->commission_amount = $data->col5;
        if ($transaction_model->commission_amount < \bc\modules\transaction\components\transaction::BIG_SMALL_TICKET) {
            $transaction_model->ticket = \bc\modules\transaction\components\transaction::SMALL_TICKET;
        }
        if ($transaction_model->commission_amount >= \bc\modules\transaction\components\transaction::BIG_SMALL_TICKET) {
            $transaction_model->ticket = \bc\modules\transaction\components\transaction::BIG_TICKET;
        }
        if (\bc\modules\transaction\helpers\Utility::validateDate($transaction_model->transaction_datetime)) {
            list($date, $time) = explode(' ', $transaction_model->transaction_datetime);
            $transaction_model->transaction_date = $date;
            $transaction_model->transaction_time = $time;
        }
        if ($urban_gp == 0) {
            if ($transaction_model->validate() and $transaction_model->save()) {
                $temp_array = [
                    $transaction_model->bc_application_id,
                    $transaction_model->bankidbc,
                    $transaction_model->master_partner_bank_id,
                    $transaction_model->district_code,
                    $transaction_model->block_code,
                    $transaction_model->gram_panchayat_code,
                    $transaction_model->file_id,
                    $transaction_model->dtable_id,
                    $transaction_model->banktransactionid,
                    $transaction_model->transaction_datetime,
                    $transaction_model->transaction_date,
                    $transaction_model->transaction_time,
                    $transaction_model->transaction_amount,
                    $transaction_model->transaction_type,
                    $transaction_model->ticket
                ];
                array_push($this->bank_batch_data, $temp_array);
                $data->status = $new;
                if ($transaction_model->bc_application_id) {
                    $this->saveintobctable($transaction_model);
                }
                $data->save();
            } else {
                $model_errors = $transaction_model->getErrors();
                if (isset($model_errors['bankidbc'])) {
                    $data->status = self::STATUS_ERROR_BC_NOT_FOUND;
                } else if (isset($model_errors['banktransactionid'])) {
                    $data->status = self::STATUS_ERROR_TRANSACTION_ID;
                } else if (isset($model_errors['transaction_amount'])) {
                    $data->status = self::STATUS_ERROR_TXN_AMOUNT;
                } else if (isset($model_errors['transaction_datetime'])) {
                    $data->status = self::STATUS_ERROR_TXN_DATE_TIME;
                } else if (isset($model_errors['commission_amount'])) {
                    $data->status = self::STATUS_ERROR_BC_COM_AMOUNT;
                } else if (isset($model_errors['transaction_type'])) {
                    $data->status = self::STATUS_ERROR_TXN_TYPE;
                } else {
                    $data->status = self::STATUS_ERROR_GENRIC;
                }
                $data->save();
            }
        } else {
            $data->status = self::STATUS_ERROR_URBAN_GP;
            $data->save();
        }
    }

    protected function saveintobctable($bankdata) {
        if ($bankdata) {
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
                $this->updatebcdailysummary($bankdata);
            }
        }
    }

    protected function updatebcdailysummary($bcmodel) {
        if ($bcmodel->bc_application_id) {
            $tran_start_date = '2021-06-01';
            if (strtotime($bcmodel->transaction_date) >= strtotime($tran_start_date)) {
                $bcid_date = $bcmodel->bc_application_id . '-' . $bcmodel->transaction_date;
                if (in_array($bcid_date, $this->bcid_date_temp)) {
                    
                } else {
                    $model = BcTransactionBcSummaryDaily::find()->select(['id'])->where(['bc_application_id' => $bcmodel->bc_application_id, 'date' => $bcmodel->transaction_date])->limit(1)->one();
                    if ($model != null) {
                        $model = BcTransactionBcSummaryDaily::findOne($model->id);
                    } else {
                        $model = new BcTransactionBcSummaryDaily();
                    }

                    $model->bc_application_id = $bcmodel->bc_application_id;
                    $model->bankidbc = $bcmodel->bankidbc;
                    $model->district_code = $bcmodel->district_code;
                    $model->block_code = $bcmodel->block_code;
                    $model->gram_panchayat_code = $bcmodel->gram_panchayat_code;
                    $model->master_partner_bank_id = $bcmodel->master_partner_bank_id;
                    $model->date = $bcmodel->transaction_date;
                    $model->transaction_start_date = $bcmodel->transaction_date;
                    $model->status = 0;
                    $model->change_calculate = 0;
                    $model->save();
                    array_push($this->bcid_date_temp, $bcid_date);
                }
            }
        }
    }

    public function processdailybcsummary() {
        $bcdailybcsummarymodel = BcTransactionBcSummaryDaily::find()->where(['status' => 0]);
        if ($this->master_partner_bank_id) {
            $bcdailybcsummarymodel->andWhere(['master_partner_bank_id' => $this->master_partner_bank_id]);
        }
        $bcdailybcsummarymodel = $bcdailybcsummarymodel->limit(self::DAILY_SUMMARY_PROSSESS_LIMIT)->all();
        if ($bcdailybcsummarymodel != null) {
            foreach ($bcdailybcsummarymodel as $bcdailysummary) {

                $dbconnectionnme = $this->bcdbconnectionname . $bcdailysummary->district_code;
                $bctable = $this->bctable . $bcdailysummary->bc_application_id;
                $con = \Yii::$app->getModule('transaction')->$dbconnectionnme;
                $is_new = 0;
                $no_of_transaction = 0;
                $zero_transaction = 0;
                $no_of_actual_transaction = 0;
                $transaction_amount = 0;
                $commission_amount = 0;
                $day_count = 0;
                $transaction_start_date = $bcdailysummary->transaction_start_date;
                $temp_bcdailysummary = $bcdailysummary;
                $sql1 = "select sum(rn) from (SELECT transaction_date,1 as rn FROM `$bctable` WHERE `transaction_date` <= '" . $bcdailysummary->date . "'" . " and bc_application_id=" . $bcdailysummary->bc_application_id . " GROUP BY transaction_date  order by transaction_date asc ) as tmp_table 
ORDER BY tmp_table.rn  desc";
                $sqltsdate = "SELECT 
       transaction_date as 'transaction_start_date'     
       FROM `$bctable`  
       where bc_application_id=" . $bcdailysummary->bc_application_id . " order by transaction_date asc limit 1 ";
                $sql = "SELECT 
                    ($sql1) as `day_count` ,
                    ($sqltsdate) as `transaction_start_date` ,    
       COUNT(id) as 'no_of_transaction',
       SUM(CASE WHEN transaction_amount = 0 THEN 1 ELSE 0 END) zero_transaction,
       SUM(CASE WHEN transaction_amount != 0 THEN 1 ELSE 0 END) no_of_actual_transaction,
       SUM(transaction_amount) as 'transaction_amount',
       sum(commission_amount) as 'commission_amount'      
       FROM `$bctable`  
       where bc_application_id=" . $bcdailysummary->bc_application_id . " and transaction_date='" . $bcdailysummary->date . "'";
                $result = $con->createCommand($sql)->queryAll();

                if (isset($result[0]['transaction_start_date'])) {
                    $transaction_start_date = $result[0]['transaction_start_date'];
                }
                if (isset($result[0]['no_of_transaction'])) {
                    $no_of_transaction = $result[0]['no_of_transaction'];
                }
                if (isset($result[0]['zero_transaction'])) {
                    $zero_transaction = $result[0]['zero_transaction'];
                }
                if (isset($result[0]['no_of_actual_transaction'])) {
                    $no_of_actual_transaction = $result[0]['no_of_actual_transaction'];
                }
                if (isset($result[0]['transaction_amount'])) {
                    $transaction_amount = $result[0]['transaction_amount'];
                }
                if (isset($result[0]['commission_amount'])) {
                    $commission_amount = $result[0]['commission_amount'];
                }
                if ($no_of_transaction) {
                    $day_count = $result[0]['day_count'];
                    $bcdailysummary->no_of_transaction = $no_of_transaction;
                    $bcdailysummary->zero_transaction = $zero_transaction;
                    $bcdailysummary->no_of_actual_transaction = $no_of_actual_transaction;
                    $bcdailysummary->transaction_amount = $transaction_amount;
                    $bcdailysummary->commission_amount = $commission_amount;
                    $bcdailysummary->day_count = $day_count;
                    if ($bcdailysummary->save()) {
                        $condition = ['and',
                            ['=', 'bc_application_id', $bcdailysummary->bc_application_id],
                        ];
                        BcTransactionBcSummaryDaily::updateAll([
                            'transaction_start_date' => $transaction_start_date,
                                ], $condition);
                        $this->updateweeklybcsummary($bcdailysummary);
                        $this->updatemonthlybcsummary($bcdailysummary);
                        $this->updatebcsummary($bcdailysummary);
                        $this->updatedailybanksummary($bcdailysummary);
                        $this->updateweeklybanksummary($bcdailysummary);
                        $this->updatemonthlybanksummary($bcdailysummary);
                        $this->updatebanksummary($bcdailysummary);
                        $bcdailysummary->status = 1;
                        $bcdailysummary->save();
                        $this->calchangebcdaily($bcdailysummary);
                    }
                } else {
                    if ($bcdailysummary->delete()) {
                        $this->updateweeklybcsummary($bcdailysummary);
                        $this->updatemonthlybcsummary($bcdailysummary);
                        $this->updatebcsummary($bcdailysummary);
                        $this->updatedailybanksummary($bcdailysummary);
                        $this->updateweeklybanksummary($bcdailysummary);
                        $this->updatemonthlybanksummary($bcdailysummary);
                        $this->updatebanksummary($bcdailysummary);
                    }
                }
            }
            sleep(1);
            $this->processdailybcsummary();
        } else {
            return true;
        }
        return true;
    }

    public function updateweeklybcsummary($bcdailysummary) {

        $date = "'" . $bcdailysummary->date . "'";
        $sqlweek = "SELECT * FROM `bc_transaction_master_week` WHERE (`week_start_date` BETWEEN $date AND week_end_date) OR (`week_end_date` BETWEEN $date AND  week_end_date) LIMIT 1";
        $this->week_model = \bc\modules\transaction\models\summary\BcTransactionMasterWeek::findBySql($sqlweek)->one();
        $this->week_start_date = $this->week_model->week_start_date;
        $this->week_end_date = $this->week_model->week_end_date;
        $this->week_id = $this->week_model->id;
        $total_day = 7;
        $transaction_bc_week_summary = \bc\modules\transaction\models\summary\BcTransactionBcSummaryWeekly::find()->select(['id'])->where(['bc_application_id' => $bcdailysummary->bc_application_id, 'week_id' => $this->week_id])->limit(1)->one();
        if (empty($transaction_bc_week_summary)) {
            $transaction_bc_week_summary = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryWeekly();
        }
        $transaction_bc_week_summary->bc_application_id = $bcdailysummary->bc_application_id;
        $transaction_bc_week_summary->bankidbc = $bcdailysummary->bankidbc;
        $transaction_bc_week_summary->district_code = $bcdailysummary->district_code;
        $transaction_bc_week_summary->block_code = $bcdailysummary->block_code;
        $transaction_bc_week_summary->gram_panchayat_code = $bcdailysummary->gram_panchayat_code;
        $transaction_bc_week_summary->master_partner_bank_id = $bcdailysummary->master_partner_bank_id;
        $transaction_bc_week_summary->week_id = $this->week_id;
        $transaction_bc_week_summary->week_start_date = $this->week_start_date;
        $transaction_bc_week_summary->week_end_date = $this->week_end_date;
        $transaction_bc_week_summary->total_day = $total_day;
        $transaction_bc_week_summary->status = 0;
        $transaction_bc_week_summary->change_calculate = 0;
        if ($transaction_bc_week_summary->save()) {
            
        }
    }

    public function updatemonthlybcsummary($bcdailysummary) {
        $date = "'" . $bcdailysummary->date . "'";
        $sql = "SELECT * FROM `bc_transaction_master_month` WHERE (`month_start_date` BETWEEN $date AND month_end_date) OR (`month_end_date` BETWEEN $date AND  month_end_date) LIMIT 1";
        $this->month_model = \bc\modules\transaction\models\summary\BcTransactionMasterMonth::findBySql($sql)->one();
        $this->month_start_date = $this->month_model->month_start_date;
        $this->month_end_date = $this->month_model->month_end_date;
        $this->month_id = $this->month_model->id;
        $transaction_bc_month_summary = \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::find()->select(['id'])->where(['bc_application_id' => $bcdailysummary->bc_application_id, 'month_id' => $this->month_id])->limit(1)->one();
        if ($transaction_bc_month_summary == null) {
            $transaction_bc_month_summary = new \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly();
        }
        $transaction_bc_month_summary->bc_application_id = $bcdailysummary->bc_application_id;
        $transaction_bc_month_summary->bankidbc = $bcdailysummary->bankidbc;
        $transaction_bc_month_summary->district_code = $bcdailysummary->district_code;
        $transaction_bc_month_summary->block_code = $bcdailysummary->block_code;
        $transaction_bc_month_summary->gram_panchayat_code = $bcdailysummary->gram_panchayat_code;
        $transaction_bc_month_summary->master_partner_bank_id = $bcdailysummary->master_partner_bank_id;
        $transaction_bc_month_summary->month_id = $this->month_id;
        $transaction_bc_month_summary->month = $this->month_start_date;
        $transaction_bc_month_summary->month_start_date = $this->month_start_date;
        $transaction_bc_month_summary->month_end_date = $this->month_end_date;
        $transaction_bc_month_summary->total_day = \DateTime::createFromFormat("Y-m-d", $this->month_end_date)->format("t");
        $transaction_bc_month_summary->status = 0;
        $transaction_bc_month_summary->change_calculate = 0;
        if ($transaction_bc_month_summary->save()) {
            
        }
    }

    public function updatebcsummary($bcdailysummary) {
        $transaction_bc_summary = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->select(['id'])->where(['bc_application_id' => $bcdailysummary->bc_application_id])->limit(1)->one();
        if (empty($transaction_bc_summary)) {
            $transaction_bc_summary = new \bc\modules\transaction\models\summary\BcTransactionBcSummary();
        }
        $transaction_bc_summary->bc_application_id = $bcdailysummary->bc_application_id;
        $transaction_bc_summary->bankidbc = $bcdailysummary->bankidbc;
        $transaction_bc_summary->district_code = $bcdailysummary->district_code;
        $transaction_bc_summary->block_code = $bcdailysummary->block_code;
        $transaction_bc_summary->gram_panchayat_code = $bcdailysummary->gram_panchayat_code;
        $transaction_bc_summary->master_partner_bank_id = $bcdailysummary->master_partner_bank_id;
        $transaction_bc_summary->status = 0;
        if ($transaction_bc_summary->save()) {
            
        }
    }

    public function updatedailybanksummary($bcdailysummary) {
        $transaction_bank_daily_summary = \bc\modules\transaction\models\summary\BcTransactionBankSummaryDaily::find()->select(['id'])->where(['master_partner_bank_id' => $bcdailysummary->master_partner_bank_id, 'date' => $bcdailysummary->date])->limit(1)->one();
        if (empty($transaction_bank_daily_summary)) {
            $transaction_bank_daily_summary = new \bc\modules\transaction\models\summary\BcTransactionBankSummaryDaily();
        }
        $transaction_bank_daily_summary->master_partner_bank_id = $bcdailysummary->master_partner_bank_id;
        $transaction_bank_daily_summary->date = $bcdailysummary->date;
        $transaction_bank_daily_summary->status = 0;
        if ($transaction_bank_daily_summary->save()) {
            
        }
    }

    public function updateweeklybanksummary($bcdailysummary) {
        $date = "'" . $bcdailysummary->date . "'";
        $sql = "SELECT * FROM `bc_transaction_master_week` WHERE (`week_start_date` BETWEEN $date AND week_end_date) OR (`week_end_date` BETWEEN $date AND  week_end_date) LIMIT 1";
        $this->week_model = \bc\modules\transaction\models\summary\BcTransactionMasterWeek::findBySql($sql)->one();
        $this->week_start_date = $this->week_model->week_start_date;
        $this->week_end_date = $this->week_model->week_end_date;
        $this->week_id = $this->week_model->id;
        $transaction_bank_week_summary = \bc\modules\transaction\models\summary\BcTransactionBankSummaryWeekly::find()->select(['id'])->where(['master_partner_bank_id' => $bcdailysummary->master_partner_bank_id, 'week_id' => $this->week_id])->limit(1)->one();
        if (empty($transaction_bank_week_summary)) {
            $transaction_bank_week_summary = new \bc\modules\transaction\models\summary\BcTransactionBankSummaryWeekly();
        }
        $transaction_bank_week_summary->master_partner_bank_id = $bcdailysummary->master_partner_bank_id;
        $transaction_bank_week_summary->week_id = $this->week_id;
        $transaction_bank_week_summary->week_start_date = $this->week_start_date;
        $transaction_bank_week_summary->week_end_date = $this->week_end_date;
        $transaction_bank_week_summary->total_day = 7;
        $transaction_bank_week_summary->status = 0;
        if ($transaction_bank_week_summary->save()) {
            
        }
    }

    public function updatemonthlybanksummary($bcdailysummary) {
        $date = "'" . $bcdailysummary->date . "'";
        $sql = "SELECT * FROM `bc_transaction_master_month` WHERE (`month_start_date` BETWEEN $date AND month_end_date) OR (`month_end_date` BETWEEN $date AND  month_end_date) LIMIT 1";
        $this->month_model = \bc\modules\transaction\models\summary\BcTransactionMasterMonth::findBySql($sql)->one();
        $this->month_start_date = $this->month_model->month_start_date;
        $this->month_end_date = $this->month_model->month_end_date;
        $this->month_id = $this->month_model->id;
        $transaction_bank_month_summary = \bc\modules\transaction\models\summary\BcTransactionBankSummaryMonthly::find()->select(['id'])->where(['master_partner_bank_id' => $bcdailysummary->master_partner_bank_id, 'month_id' => $this->month_id])->limit(1)->one();
        if (empty($transaction_bank_month_summary)) {
            $transaction_bank_month_summary = new \bc\modules\transaction\models\summary\BcTransactionBankSummaryMonthly();
        }
        $transaction_bank_month_summary->master_partner_bank_id = $bcdailysummary->master_partner_bank_id;
        $transaction_bank_month_summary->month_id = $this->month_id;
        $transaction_bank_month_summary->month = $this->month_start_date;
        $transaction_bank_month_summary->month_start_date = $this->month_start_date;
        $transaction_bank_month_summary->month_end_date = $this->month_end_date;
        $transaction_bank_month_summary->total_day = \DateTime::createFromFormat("Y-m-d", $this->month_end_date)->format("t");
        $transaction_bank_month_summary->status = 0;
        if ($transaction_bank_month_summary->save()) {
            
        }
    }

    public function updatebanksummary($bcdailysummary) {
        $transaction_bank_summary = \bc\modules\transaction\models\summary\BcTransactionBankSummary::find()->select(['id'])->where(['master_partner_bank_id' => $bcdailysummary->master_partner_bank_id])->limit(1)->one();
        if (empty($transaction_bank_summary)) {
            $transaction_bank_summary = new \bc\modules\transaction\models\summary\BcTransactionBankSummary();
        }
        $transaction_bank_summary->master_partner_bank_id = $bcdailysummary->master_partner_bank_id;
        $transaction_bank_summary->status = 0;
        if ($transaction_bank_summary->save()) {
            
        }
    }

    public function processweeklybcsummary() {

        $bcsummarymodel = \bc\modules\transaction\models\summary\BcTransactionBcSummaryWeekly::find()->where(['status' => 0])->limit(self::DAILY_SUMMARY_PROSSESS_LIMIT);
        if ($this->master_partner_bank_id) {
            $bcsummarymodel->andWhere(['master_partner_bank_id' => $this->master_partner_bank_id]);
        }
        $bcsummarymodel = $bcsummarymodel->limit(self::DAILY_SUMMARY_PROSSESS_LIMIT)->all();
        if ($bcsummarymodel != null) {
            $con = \Yii::$app->getModule('transaction')->bctransactionsummary;
            foreach ($bcsummarymodel as $bcsummary) {
                $sqltsdate = "SELECT 
       date as 'transaction_start_date'     
       FROM `bc_transaction_bc_summary_daily`  
       where bc_application_id=" . $bcsummary->bc_application_id . " and status=1 AND date >= '$bcsummary->week_start_date' AND date <= '$bcsummary->week_end_date'  order by date asc limit 1 ";

                $sqldaycount = "SELECT count(distinct(date))   
       FROM `bc_transaction_bc_summary_daily`  
       where bc_application_id=" . $bcsummary->bc_application_id . " AND date >= '$bcsummary->week_start_date' AND date <= '$bcsummary->week_end_date' ";
                $sqlweekcount = "select sum(rn) from (SELECT week_id,1 as rn FROM `bc_transaction_bc_summary_weekly` where bc_application_id = " . $bcsummary->bc_application_id . " AND week_id <= $bcsummary->week_id GROUP BY week_id order by week_id asc ) as tmp_table ORDER BY tmp_table.rn desc";

                $sql = "SELECT
                    ($sqldaycount) as total_working_day,
                    ($sqltsdate) as transaction_start_date,  
                    ($sqlweekcount) as week_count,    
                    SUM(no_of_transaction) as no_of_transaction,
                    SUM(transaction_amount) as transaction_amount,
                    SUM(commission_amount) as commission_amount,
                    SUM(zero_transaction) as zero_transaction
                FROM `bc_transaction_bc_summary_daily` where bc_application_id=" . $bcsummary->bc_application_id . " and status=1 AND date >= '$bcsummary->week_start_date' AND date <= '$bcsummary->week_end_date'";

                $result = $con->createCommand($sql)->queryAll()[0];
                $now = time(); // or your date as well
                if (isset($result['no_of_transaction'])) {

                    $total_day = $bcsummary->total_day;
                    $total_not_working_day = ($total_day - $result['total_working_day']);
                    $bcsummary->total_working_day = $result['total_working_day'];
                    $bcsummary->transaction_start_date = $result['transaction_start_date'];
                    $bcsummary->total_not_working_day = $total_not_working_day;
                    $bcsummary->no_of_transaction = $result['no_of_transaction'];
                    $bcsummary->zero_transaction = $result['zero_transaction'];
                    $bcsummary->no_of_actual_transaction = ($result['no_of_transaction'] - $result['zero_transaction']);
                    $bcsummary->transaction_amount = $result['transaction_amount'];
                    $bcsummary->commission_amount = $result['commission_amount'];
                    $bcsummary->week_count = $result['week_count'];
                    $bcsummary->status = 1;
                    
                    if ($bcsummary->save()) {
                       $this->calchangebcweekly($bcsummary); 
                    } else {
                        //
                    }
                } else {
                    $bcsummary->delete();
                }
            }
            sleep(1);
            $this->processweeklybcsummary();
        } else {
            return true;
        }
        return true;
    }

    public function processmonthlybcsummary() {
        $bcsummarymodel = \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::find()->where(['status' => 0])->limit(self::DAILY_SUMMARY_PROSSESS_LIMIT);
        if ($this->master_partner_bank_id) {
            $bcsummarymodel->andWhere(['master_partner_bank_id' => $this->master_partner_bank_id]);
        }
        $bcsummarymodel = $bcsummarymodel->limit(self::DAILY_SUMMARY_PROSSESS_LIMIT)->all();

        if ($bcsummarymodel != null) {
            $con = \Yii::$app->getModule('transaction')->bctransactionsummary;
            foreach ($bcsummarymodel as $bcsummary) {
                $sqltsdate = "SELECT 
       date as 'transaction_start_date'     
       FROM `bc_transaction_bc_summary_daily`  
       where bc_application_id=" . $bcsummary->bc_application_id . " and status=1 AND date >= '$bcsummary->month_start_date' AND date <= '$bcsummary->month_end_date'  order by date asc limit 1 ";

                $sqldaycount = "SELECT count(distinct(date))   
       FROM `bc_transaction_bc_summary_daily`  
       where bc_application_id=" . $bcsummary->bc_application_id . " AND date >= '$bcsummary->month_start_date' AND date <= '$bcsummary->month_end_date' ";
                $sqlmonthcount = "select sum(rn) from (SELECT month_id,1 as rn FROM `bc_transaction_bc_summary_monthly` where bc_application_id = " . $bcsummary->bc_application_id . " AND month_id <= $bcsummary->month_id GROUP BY month_id order by month_id asc ) as tmp_table ORDER BY tmp_table.rn desc";

                $sql = "SELECT
                    ($sqldaycount) as total_working_day,
                    ($sqltsdate) as transaction_start_date,  
                    ($sqlmonthcount) as month_count,    
                    SUM(no_of_transaction) as no_of_transaction,
                    SUM(transaction_amount) as transaction_amount,
                    SUM(commission_amount) as commission_amount,
                    SUM(zero_transaction) as zero_transaction
                FROM `bc_transaction_bc_summary_daily` where bc_application_id=" . $bcsummary->bc_application_id . " and status=1 AND date >= '$bcsummary->month_start_date' AND date <= '$bcsummary->month_end_date'";
                $result = $con->createCommand($sql)->queryAll()[0];
                $now = time(); // or your date as well
                if (isset($result['no_of_transaction'])) {

                    $total_day = \DateTime::createFromFormat("Y-m-d", $bcsummary->month_end_date)->format("t");
                    $total_not_working_day = ($total_day - $result['total_working_day']);
                    $bcsummary->total_day = $total_day;
                    $bcsummary->total_working_day = $result['total_working_day'];
                    $bcsummary->transaction_start_date = $result['transaction_start_date'];
                    $bcsummary->total_not_working_day = $total_not_working_day;
                    $bcsummary->no_of_transaction = $result['no_of_transaction'];
                    $bcsummary->zero_transaction = $result['zero_transaction'];
                    $bcsummary->no_of_actual_transaction = ($result['no_of_transaction'] - $result['zero_transaction']);
                    $bcsummary->transaction_amount = $result['transaction_amount'];
                    $bcsummary->commission_amount = $result['commission_amount'];
                    $bcsummary->month_count = $result['month_count'];
                    $bcsummary->bc_category = $this->getbccategory($bcsummary->no_of_actual_transaction);
                    $bcsummary->status = 1;
                    $bcsummary->save();
                    $this->calchangebcmonthly($bcsummary);
                } else {
                    $bcsummary->delete();
                }
            }
            sleep(1);
            $this->processmonthlybcsummary();
        } else {
            return true;
        }
        return true;
    }

    public function processbcsummary() {

        $bcsummarymodel = \bc\modules\transaction\models\summary\BcTransactionBcSummary::find()->where(['status' => 0])->limit(self::DAILY_SUMMARY_PROSSESS_LIMIT);
        if ($this->master_partner_bank_id) {
            $bcsummarymodel->andWhere(['master_partner_bank_id' => $this->master_partner_bank_id]);
        }
        $bcsummarymodel = $bcsummarymodel->limit(self::DAILY_SUMMARY_PROSSESS_LIMIT)->all();

        $con = \Yii::$app->getModule('transaction')->bctransactionsummary;

        if ($bcsummarymodel != null) {
            foreach ($bcsummarymodel as $bcsummary) {

                $sqltsdate = "SELECT 
       date as 'transaction_start_date'     
       FROM `bc_transaction_bc_summary_daily`  
       where bc_application_id=" . $bcsummary->bc_application_id . " and status=1 order by date asc limit 1 ";
                $sqldaycount = "SELECT count(distinct(date))   
       FROM `bc_transaction_bc_summary_daily`  
       where bc_application_id=" . $bcsummary->bc_application_id . "";

                $sqlstartmonthid = "SELECT month_id FROM `bc_transaction_bc_summary_monthly`"
                        . " WHERE bc_application_id=" . $bcsummary->bc_application_id . "  order by month_start_date asc limit 1 ";

                $sqlstartmonthstartdate = "SELECT month_end_date FROM `bc_transaction_bc_summary_monthly`"
                        . " WHERE bc_application_id=" . $bcsummary->bc_application_id . "  order by month_start_date asc limit 1 ";

                $sqlendmonthid = "SELECT month_id FROM `bc_transaction_bc_summary_monthly`"
                        . " WHERE bc_application_id=" . $bcsummary->bc_application_id . "  order by month_start_date desc limit 1 ";

                $sqlendmonthdate = "SELECT month_end_date FROM `bc_transaction_bc_summary_monthly`"
                        . " WHERE bc_application_id=" . $bcsummary->bc_application_id . "  order by month_start_date desc limit 1 ";

                $sql = "SELECT
                    ($sqldaycount) as total_working_day,
                    ($sqltsdate) as transaction_start_date,  
                    ($sqlstartmonthid) as start_month_id,    
                    ($sqlstartmonthstartdate) as start_month_date,    
                    ($sqlendmonthid) as last_month_id,    
                    ($sqlendmonthdate) as last_month_date,    
                    SUM(no_of_transaction) as no_of_transaction,
                    SUM(transaction_amount) as transaction_amount,
                    SUM(commission_amount) as commission_amount,
                    SUM(zero_transaction) as zero_transaction
                FROM `bc_transaction_bc_summary_daily` where bc_application_id=" . $bcsummary->bc_application_id . " and status=1";
                $result = $con->createCommand($sql)->queryAll()[0];
                $now = time(); // or your date as well
                if (isset($result['no_of_transaction'])) {
                    $start_date = strtotime((string) $result['transaction_start_date']);
                    $datediff = $now - $start_date;
                    $total_day = round($datediff / (60 * 60 * 24));
                    $total_not_working_day = ($total_day - $result['total_working_day']);
                    $bcsummary->transaction_start_date = $result['transaction_start_date'];
                    $bcsummary->total_day = $total_day;
                    $bcsummary->total_working_day = $result['total_working_day'];
                    $bcsummary->total_not_working_day = $total_not_working_day;
                    $bcsummary->no_of_transaction = $result['no_of_transaction'];
                    $bcsummary->zero_transaction = $result['zero_transaction'];
                    $bcsummary->no_of_actual_transaction = ($result['no_of_transaction'] - $result['zero_transaction']);
                    $bcsummary->transaction_amount = $result['transaction_amount'];
                    $bcsummary->commission_amount = $result['commission_amount'];

                    if (isset($result['start_month_id'])) {
                        $bcsummary->start_month_id = $result['start_month_id'];
                        $bcsummary->start_month_name = date('F Y', strtotime($result['start_month_date']));
                    }
                    if (isset($result['last_month_id'])) {
                        $bcsummary->last_month_id = $result['last_month_id'];
                        $bcsummary->last_month_name = date('F Y', strtotime($result['last_month_date']));
                    }

                    $bcsummary->status = 1;
                    $bcsummary->save();
                    
                } else {
                    $bcsummary->delete();
                }
            }
            sleep(1);
            $this->processbcsummary();
        } else {
            return true;
        }
        return true;
    }

    public function processdailybanksummary() {
        $transaction_bank_daily_summary_models = \bc\modules\transaction\models\summary\BcTransactionBankSummaryDaily::find()->where(['status' => 0]);
        if ($this->master_partner_bank_id) {
            $transaction_bank_daily_summary_models->andWhere(['master_partner_bank_id' => $this->master_partner_bank_id]);
        }
        $transaction_bank_daily_summary_models = $transaction_bank_daily_summary_models->limit(self::DAILY_SUMMARY_PROSSESS_LIMIT)->all();
        if ($transaction_bank_daily_summary_models != null) {
            foreach ($transaction_bank_daily_summary_models as $transaction_bank_daily_summary) {
                $con = \Yii::$app->getModule('transaction')->bctransactionsummary;

                $sqldaycount = "
                        select sum(rn) from (SELECT date,1 as rn FROM `bc_transaction_bc_summary_daily` where master_partner_bank_id = " . $transaction_bank_daily_summary->master_partner_bank_id . " AND date <= '$transaction_bank_daily_summary->date' GROUP BY date order by date asc ) as tmp_table ORDER BY tmp_table.rn desc";
                $sql = "SELECT
                    ($sqldaycount) as day_count,
                    COUNT(DISTINCT(district_code)) as no_of_district,
                    COUNT(DISTINCT(block_code)) as no_of_block,
                    COUNT(DISTINCT(gram_panchayat_code)) as no_of_gp,
                    COUNT(DISTINCT(bc_application_id)) as total_bc,
                    SUM(no_of_transaction) as no_of_transaction,
                    SUM(transaction_amount) as transaction_amount,
                    SUM(commission_amount) as commission_amount,
                    SUM(zero_transaction) as zero_transaction
                FROM `bc_transaction_bc_summary_daily` where master_partner_bank_id=" . $transaction_bank_daily_summary->master_partner_bank_id . " and status=1 AND date = '$transaction_bank_daily_summary->date' ";
//               echo $sql;exit;
                $result = $con->createCommand($sql)->queryAll()[0];

                if ($result['no_of_transaction']) {
                    $transaction_bank_daily_summary->transaction_start_date = $transaction_bank_daily_summary->date;
                    $transaction_bank_daily_summary->total_bc = $result['total_bc'];
                    $transaction_bank_daily_summary->no_of_district = $result['no_of_district'];
                    $transaction_bank_daily_summary->no_of_block = $result['no_of_block'];
                    $transaction_bank_daily_summary->no_of_gp = $result['no_of_gp'];
                    $transaction_bank_daily_summary->no_of_transaction = $result['no_of_transaction'];
                    $transaction_bank_daily_summary->zero_transaction = $result['zero_transaction'];
                    $transaction_bank_daily_summary->no_of_actual_transaction = ($result['no_of_transaction'] - $result['zero_transaction']);
                    $transaction_bank_daily_summary->transaction_amount = $result['transaction_amount'];
                    $transaction_bank_daily_summary->commission_amount = $result['commission_amount'];
                    $transaction_bank_daily_summary->day_count = $result['day_count'];
                    $transaction_bank_daily_summary->status = 1;
                    $transaction_bank_daily_summary->save();
                } else {
                    $transaction_bank_daily_summary->delete();
                }
            }
            sleep(1);
            $this->processdailybanksummary();
        } else {
            return true;
        }
        return true;
    }

    public function processweeklybanksummary() {
        $transaction_bank_weekly_summary_models = \bc\modules\transaction\models\summary\BcTransactionBankSummaryWeekly::find()->where(['status' => 0])->limit(self::DAILY_SUMMARY_PROSSESS_LIMIT);
        if ($this->master_partner_bank_id) {
            $transaction_bank_weekly_summary_models->andWhere(['master_partner_bank_id' => $this->master_partner_bank_id]);
        }
        $transaction_bank_weekly_summary_models = $transaction_bank_weekly_summary_models->limit(self::DAILY_SUMMARY_PROSSESS_LIMIT)->all();
        if ($transaction_bank_weekly_summary_models != null) {
            foreach ($transaction_bank_weekly_summary_models as $transaction_bank_weekly_summary) {
                $con = \Yii::$app->getModule('transaction')->bctransactionsummary;
                $sqltsdate = "SELECT 
       date as 'transaction_start_date'     
       FROM `bc_transaction_bc_summary_daily`  
       where master_partner_bank_id=" . $transaction_bank_weekly_summary->master_partner_bank_id . " and status=1 AND date >= '$transaction_bank_weekly_summary->week_start_date' AND date <= '$transaction_bank_weekly_summary->week_end_date'  order by date asc limit 1 ";
                $sqlnoofworkingday = "SELECT COUNT(DISTINCT(date))     
       FROM `bc_transaction_bc_summary_daily`  
       where master_partner_bank_id=" . $transaction_bank_weekly_summary->master_partner_bank_id . " and status=1 AND date >= '$transaction_bank_weekly_summary->week_start_date' AND date <= '$transaction_bank_weekly_summary->week_end_date'";

                $sqlweekcount = "select sum(rn) from (SELECT week_id,1 as rn FROM `bc_transaction_bank_summary_weekly` "
                        . "where master_partner_bank_id = " . $transaction_bank_weekly_summary->master_partner_bank_id . " AND"
                        . " week_id <= $transaction_bank_weekly_summary->week_id GROUP BY week_id order by week_id asc ) as"
                        . " tmp_table ORDER BY tmp_table.rn desc";

                $sql = "SELECT
                    ($sqltsdate) as transaction_start_date,
                    ($sqlnoofworkingday) as total_working_day,  
                    ($sqlweekcount) as week_count,
                    COUNT(DISTINCT(district_code)) as no_of_district,
                    COUNT(DISTINCT(block_code)) as no_of_block,
                    COUNT(DISTINCT(gram_panchayat_code)) as no_of_gp,
                    COUNT(DISTINCT(bc_application_id)) as total_bc,
                    SUM(no_of_transaction) as no_of_transaction,
                    SUM(transaction_amount) as transaction_amount,
                    SUM(commission_amount) as commission_amount,
                    SUM(zero_transaction) as zero_transaction
                FROM `bc_transaction_bc_summary_daily` where master_partner_bank_id=" . $transaction_bank_weekly_summary->master_partner_bank_id . " and status=1 AND date >= '$transaction_bank_weekly_summary->week_start_date' AND date <= '$transaction_bank_weekly_summary->week_end_date'";

                $result = $con->createCommand($sql)->queryAll()[0];

                if ($result['no_of_transaction']) {
                    $transaction_bank_weekly_summary->transaction_start_date = $result['transaction_start_date'];
                    $transaction_bank_weekly_summary->total_bc = $result['total_bc'];
                    $transaction_bank_weekly_summary->no_of_district = $result['no_of_district'];
                    $transaction_bank_weekly_summary->no_of_block = $result['no_of_block'];
                    $transaction_bank_weekly_summary->no_of_gp = $result['no_of_gp'];
                    $transaction_bank_weekly_summary->total_working_day = $result['total_working_day'];
                    $transaction_bank_weekly_summary->total_not_working_day = ($transaction_bank_weekly_summary->total_day - $result['total_working_day']);
                    $transaction_bank_weekly_summary->no_of_transaction = $result['no_of_transaction'];
                    $transaction_bank_weekly_summary->zero_transaction = $result['zero_transaction'];
                    $transaction_bank_weekly_summary->no_of_actual_transaction = ($result['no_of_transaction'] - $result['zero_transaction']);
                    $transaction_bank_weekly_summary->transaction_amount = $result['transaction_amount'];
                    $transaction_bank_weekly_summary->commission_amount = $result['commission_amount'];
                    $transaction_bank_weekly_summary->week_count = $result['week_count'];
                    $transaction_bank_weekly_summary->status = 1;
                    $transaction_bank_weekly_summary->save();
                } else {
                    $transaction_bank_weekly_summary->delete();
                }
            }
            sleep(1);
            $this->processweeklybanksummary();
        } else {
            return true;
        }
        return true;
    }

    public function processmonthlybanksummary() {

        $transaction_bank_month_summary_models = \bc\modules\transaction\models\summary\BcTransactionBankSummaryMonthly::find()->where(['status' => 0])->limit(self::DAILY_SUMMARY_PROSSESS_LIMIT);
        if ($this->master_partner_bank_id) {
            $transaction_bank_month_summary_models->andWhere(['master_partner_bank_id' => $this->master_partner_bank_id]);
        }
        $transaction_bank_month_summary_models = $transaction_bank_month_summary_models->limit(self::DAILY_SUMMARY_PROSSESS_LIMIT)->all();
        if ($transaction_bank_month_summary_models != null) {
            foreach ($transaction_bank_month_summary_models as $transaction_bank_month_summary) {
                $con = \Yii::$app->getModule('transaction')->bctransactionsummary;
                $sqltsdate = "SELECT 
       date as 'transaction_start_date'     
       FROM `bc_transaction_bc_summary_daily`  
       where master_partner_bank_id=" . $transaction_bank_month_summary->master_partner_bank_id . " and status=1 AND date >= '$transaction_bank_month_summary->month_start_date' AND date <= '$transaction_bank_month_summary->month_end_date'  order by date asc limit 1 ";
                $sqlnoofworkingday = "SELECT COUNT(DISTINCT(date))     
       FROM `bc_transaction_bc_summary_daily`  
       where master_partner_bank_id=" . $transaction_bank_month_summary->master_partner_bank_id . " and status=1 AND date >= '$transaction_bank_month_summary->month_start_date' AND date <= '$transaction_bank_month_summary->month_end_date'";

                $sqlmonthcount = "select sum(rn) from (SELECT month_id,1 as rn FROM `bc_transaction_bank_summary_monthly` "
                        . "where master_partner_bank_id = " . $transaction_bank_month_summary->master_partner_bank_id . " AND"
                        . " month_id <= $transaction_bank_month_summary->month_id GROUP BY month_id order by month_id asc ) as"
                        . " tmp_table ORDER BY tmp_table.rn desc";

                $sql = "SELECT
                    ($sqltsdate) as transaction_start_date,
                    ($sqlnoofworkingday) as total_working_day,  
                    ($sqlmonthcount) as month_count,
                    COUNT(DISTINCT(district_code)) as no_of_district,
                    COUNT(DISTINCT(block_code)) as no_of_block,
                    COUNT(DISTINCT(gram_panchayat_code)) as no_of_gp,
                    COUNT(DISTINCT(bc_application_id)) as total_bc,
                    SUM(no_of_transaction) as no_of_transaction,
                    SUM(transaction_amount) as transaction_amount,
                    SUM(commission_amount) as commission_amount,
                    SUM(zero_transaction) as zero_transaction
                FROM `bc_transaction_bc_summary_daily` where master_partner_bank_id=" . $transaction_bank_month_summary->master_partner_bank_id . " and status=1 AND date >= '$transaction_bank_month_summary->month_start_date' AND date <= '$transaction_bank_month_summary->month_end_date'";

                $result = $con->createCommand($sql)->queryAll()[0];

                if ($result['no_of_transaction']) {
                    $transaction_bank_month_summary->transaction_start_date = $result['transaction_start_date'];
                    $transaction_bank_month_summary->total_bc = $result['total_bc'];
                    $transaction_bank_month_summary->no_of_district = $result['no_of_district'];
                    $transaction_bank_month_summary->no_of_block = $result['no_of_block'];
                    $transaction_bank_month_summary->no_of_gp = $result['no_of_gp'];
                    $transaction_bank_month_summary->total_working_day = $result['total_working_day'];
                    $transaction_bank_month_summary->total_day = \DateTime::createFromFormat("Y-m-d", $transaction_bank_month_summary->month_end_date)->format("t");
                    $transaction_bank_month_summary->total_not_working_day = ($transaction_bank_month_summary->total_day - $result['total_working_day']);
                    $transaction_bank_month_summary->no_of_transaction = $result['no_of_transaction'];
                    $transaction_bank_month_summary->zero_transaction = $result['zero_transaction'];
                    $transaction_bank_month_summary->no_of_actual_transaction = ($result['no_of_transaction'] - $result['zero_transaction']);
                    $transaction_bank_month_summary->transaction_amount = $result['transaction_amount'];
                    $transaction_bank_month_summary->commission_amount = $result['commission_amount'];
                    $transaction_bank_month_summary->month_count = $result['month_count'];
                    $transaction_bank_month_summary->status = 1;
                    $transaction_bank_month_summary->save();
                } else {
                    $transaction_bank_month_summary->delete();
                }
            }
            sleep(1);
            $this->processmonthlybanksummary();
        } else {
            return true;
        }
        return true;
    }

    public function processbanksummary() {
        $bank_summary_models = \bc\modules\transaction\models\summary\BcTransactionBankSummary::find()->where(['status' => 0]);
        if ($this->master_partner_bank_id) {
            $bank_summary_models->andWhere(['master_partner_bank_id' => $this->master_partner_bank_id]);
        }
        $bank_summary_models = $bank_summary_models->limit(self::DAILY_SUMMARY_PROSSESS_LIMIT)->all();
        if ($bank_summary_models != null) {
            foreach ($bank_summary_models as $bank_summary) {
                $con = \Yii::$app->getModule('transaction')->bctransactionsummary;
                $sqltsdate = "SELECT 
       date as 'transaction_start_date'     
       FROM `bc_transaction_bc_summary_daily`  
       where master_partner_bank_id=" . $bank_summary->master_partner_bank_id . " and status=1 order by date asc limit 1 ";
                $sqlnoofworkingday = "SELECT COUNT(DISTINCT(date))     
       FROM `bc_transaction_bc_summary_daily`  
       where master_partner_bank_id=" . $bank_summary->master_partner_bank_id . " and status=1";

                $sqlstartmonthid = "SELECT month_id FROM `bc_transaction_bc_summary_monthly`"
                        . " WHERE master_partner_bank_id=" . $bank_summary->master_partner_bank_id . "  order by month_start_date asc limit 1 ";

                $sqlstartmonthstartdate = "SELECT month_end_date FROM `bc_transaction_bc_summary_monthly`"
                        . " WHERE master_partner_bank_id=" . $bank_summary->master_partner_bank_id . "  order by month_start_date asc limit 1 ";

                $sqlendmonthid = "SELECT month_id FROM `bc_transaction_bc_summary_monthly`"
                        . " WHERE master_partner_bank_id=" . $bank_summary->master_partner_bank_id . "  order by month_start_date desc limit 1 ";

                $sqlendmonthdate = "SELECT month_end_date FROM `bc_transaction_bc_summary_monthly`"
                        . " WHERE master_partner_bank_id=" . $bank_summary->master_partner_bank_id . "  order by month_start_date desc limit 1 ";

                $sql = "SELECT
                    ($sqltsdate) as transaction_start_date,
                    ($sqlnoofworkingday) as total_working_day, 
                        ($sqlstartmonthid) as start_month_id,    
                    ($sqlstartmonthstartdate) as start_month_date,    
                    ($sqlendmonthid) as last_month_id,    
                    ($sqlendmonthdate) as last_month_date, 
                    COUNT(DISTINCT(district_code)) as no_of_district,
                    COUNT(DISTINCT(block_code)) as no_of_block,
                    COUNT(DISTINCT(gram_panchayat_code)) as no_of_gp,
                    COUNT(DISTINCT(bc_application_id)) as total_bc,
                    SUM(no_of_transaction) as no_of_transaction,
                    SUM(transaction_amount) as transaction_amount,
                    SUM(commission_amount) as commission_amount,
                    SUM(zero_transaction) as zero_transaction
                FROM `bc_transaction_bc_summary_daily` where master_partner_bank_id=" . $bank_summary->master_partner_bank_id . " and status=1";
                $result = $con->createCommand($sql)->queryAll();
                $now = time(); // or your date as well
                $start_date = strtotime((string) $result[0]['transaction_start_date']);
                $datediff = $now - $start_date;
                $total_day = round($datediff / (60 * 60 * 24));
                $total_not_working_day = ($total_day - $result[0]['total_working_day']);
                $start_month = \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::find()->where(['master_partner_bank_id' => $bank_summary->master_partner_bank_id])->andWhere(['>=', 'month_id', 6])->orderBy(['month_start_date' => SORT_ASC])->limit(1)->one();
                $last_month = \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::find()->where(['master_partner_bank_id' => $bank_summary->master_partner_bank_id])->andWhere(['>=', 'month_id', 6])->orderBy(['month_start_date' => SORT_DESC])->limit(1)->one();

                if ($result[0]['no_of_transaction']) {

                    $bank_summary->master_partner_bank_id = $bank_summary->master_partner_bank_id;
                    $bank_summary->transaction_start_date = $result[0]['transaction_start_date'];
                    $bank_summary->total_bc = $result[0]['total_bc'];
                    $bank_summary->no_of_district = $result[0]['no_of_district'];
                    $bank_summary->no_of_block = $result[0]['no_of_block'];
                    $bank_summary->no_of_gp = $result[0]['no_of_gp'];
                    $bank_summary->total_day = $total_day;
                    $bank_summary->total_working_day = $result[0]['total_working_day'];
                    $bank_summary->total_not_working_day = $total_not_working_day;
                    $bank_summary->no_of_transaction = $result[0]['no_of_transaction'];
                    $bank_summary->zero_transaction = $result[0]['zero_transaction'];
                    $bank_summary->no_of_actual_transaction = ($result[0]['no_of_transaction'] - $result[0]['zero_transaction']);
                    $bank_summary->transaction_amount = $result[0]['transaction_amount'];
                    $bank_summary->commission_amount = $result[0]['commission_amount'];
                    $bank_summary->status = 1;

                    if (isset($result[0]['start_month_id'])) {
                        $bank_summary->start_month_id = $result[0]['start_month_id'];
                        $bank_summary->start_month_name = date('F Y', strtotime($result[0]['start_month_date']));
                    }
                    if (isset($result[0]['last_month_id'])) {
                        $bank_summary->last_month_id = $result[0]['last_month_id'];
                        $bank_summary->last_month_name = date('F Y', strtotime($result[0]['last_month_date']));
                    }
                    $bank_summary->save();
                } else {
                    $bank_summary->delete();
                }
            }
        }
    }

    public function delete($file_model) {
        $file_model = BcTransactionFiles::findOne($file_model->id);
        if (in_array($file_model->new_process, [-3, -2])) {
            $file_model->new_process = -2;
            $file_model->save();
            $rawdumpmodel = $this->DumoModelClass . $file_model->master_partner_bank_id;
            $bankdumpmodel = $this->BankModelClass . $file_model->master_partner_bank_id;
            $bank_table = $this->banktable . $file_model->master_partner_bank_id;
            $upload_transaction_data = $rawdumpmodel::find()->where(['file_id' => $file_model->id])->limit(self::RAW_DUMP_PROSSESS_LIMIT)->all();
            if ($upload_transaction_data != null) {
                foreach ($upload_transaction_data as $data) {
                    $bankmodel = $this->BankModelClass . $data->master_partner_bank_id;
                    $transaction_model = $bankmodel::find()->select(['id'])->where(['file_id' => $data->file_id, 'banktransactionid' => $data->col1])->limit(1)->one();
                    if ($transaction_model != null) {
                        $transaction_model = $bankmodel::findOne($transaction_model->id);
                        $this->updatebcdailysummary($transaction_model);
                        $this->deletebank($transaction_model);
                        $this->deletebctable($transaction_model);
                    }
                    $data->delete();
                }
                $this->delete($file_model);
            } else {
                $file_model->new_process = -1;
                $file_model->save();
            }
        }
        return true;
    }

    private function getbccategory($transaction) {
        $bc_category = 0;
        if ($transaction >= 0 and $transaction < 100) {
            $bc_category = 1;
        } elseif ($transaction >= 100 and $transaction < 500) {
            $bc_category = 2;
        } elseif ($transaction >= 500 and $transaction < 1000) {
            $bc_category = 3;
        } elseif ($transaction >= 1000) {
            $bc_category = 4;
        }
        return $bc_category;
    }

    public function calchangebcdaily($model) {
        try {
            $date = new \DateTime($model->date);
            $date->modify('-1 day');
            $predate = $date->format('Y-m-d');
            
            $pre_model = BcTransactionBcSummaryDaily::find()->where(['bc_application_id' => $model->bc_application_id, 'date' => $predate])->limit(1)->one();
            $day_count = 0;
            $no_of_transaction = 0;
            $transaction_amount = 0;
            $commission_amount = 0;
            if ($pre_model != null) {
                $day_count = $pre_model->day_count;
                $no_of_transaction = $pre_model->no_of_transaction;
                $transaction_amount = $pre_model->transaction_amount;
                $commission_amount = $pre_model->commission_amount;
            }

            $model->change_day = $model->day_count - $day_count;
            $model->change_transaction = $model->no_of_transaction - $no_of_transaction;
            $model->change_transaction_amount = $model->transaction_amount - $transaction_amount;
            $model->change_commission_amount = $model->commission_amount - $commission_amount;
            $model->change_calculate = 1;
            $model->save();
        } catch (\Exception $ex) {
            
        }
        return true;
    }

    public function calchangebcweekly($model) {
        try {
            $week_model = \bc\modules\transaction\models\summary\BcTransactionMasterWeek::find()->where(['<', 'week_start_date', $model->week_start_date])->orderBy('week_start_date desc')->limit(1)->one();
            $pre_model = \bc\modules\transaction\models\summary\BcTransactionBcSummaryWeekly::find()->where(['bc_application_id' => $model->bc_application_id, 'week_id' => $week_model->id])->limit(1)->one();
            $day_count = 0;
            $no_of_transaction = 0;
            $transaction_amount = 0;
            $commission_amount = 0;
            if ($pre_model != null) {
                $day_count = $pre_model->total_working_day;
                $no_of_transaction = $pre_model->no_of_transaction;
                $transaction_amount = $pre_model->transaction_amount;
                $commission_amount = $pre_model->commission_amount;
            }

            $model->change_day = $model->total_working_day - $day_count;
            $model->change_transaction = $model->no_of_transaction - $no_of_transaction;
            $model->change_transaction_amount = $model->transaction_amount - $transaction_amount;
            $model->change_commission_amount = $model->commission_amount - $commission_amount;
            $model->change_calculate = 1;
            $model->save();
        } catch (\Exception $ex) {
            
        }
        return true;
    }

    public function calchangebcmonthly($model) {
        try {
            $month_model = \bc\modules\transaction\models\summary\BcTransactionMasterMonth::find()->where(['<', 'month_start_date', $model->month_start_date])->orderBy('month_start_date desc')->limit(1)->one();
            $pre_model = \bc\modules\transaction\models\summary\BcTransactionBcSummaryMonthly::find()->where(['bc_application_id' => $model->bc_application_id, 'month_id' => $month_model->id])->limit(1)->one();
            $day_count = 0;
            $no_of_transaction = 0;
            $transaction_amount = 0;
            $commission_amount = 0;
            if ($pre_model != null) {
                $day_count = $pre_model->total_working_day;
                $no_of_transaction = $pre_model->no_of_transaction;
                $transaction_amount = $pre_model->transaction_amount;
                $commission_amount = $pre_model->commission_amount;
            }

            $model->change_day = $model->total_working_day - $day_count;
            $model->change_transaction = $model->no_of_transaction - $no_of_transaction;
            $model->change_transaction_amount = $model->transaction_amount - $transaction_amount;
            $model->change_commission_amount = $model->commission_amount - $commission_amount;
            $model->change_calculate = 1;
            $model->save();
        } catch (\Exception $ex) {
            
        }
        return true;
    }
}
