<?php

namespace bc\models\transaction\form;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use common\models\User;
use common\models\base\GenralModel;
use bc\models\transaction\master\MasterPartnerBank;
use bc\models\transaction\BcTransactionFiles;
use bc\models\transaction\BcTransaction;
use bc\models\transaction\BcTransactionTable1;
use bc\models\transaction\BcTransactionTable2;
use bc\models\transaction\BcTransactionTable3;
use bc\models\transaction\BcTransactionTable4;
use bc\models\transaction\BcTransactionTable5;
use bc\models\transaction\BcTransactionTable6;
use bc\models\transaction\SrlmBcApplication;

class UploadCsvTransactionForm extends Model {

    public $csvfile;
    public $master_partner_bank_id;
    public $rows = [];
    public $file_model;
    public $page_title;
    public $bank_option;
    public $label;
    public $error_rows = [];
    public $transaction_ids = [];
    public $file_table_time = false;
    public $new = 0;
    public $repeats = 0;
    public $error = 0;
    public $error_option = [11 => 'Error in user id', 12 => 'Error in transaction id', 13 => 'Error in Txn amount', 14 => 'Error in BC commission amount', 15 => 'Error in Txn type', 16 => 'Error in Time stamp', 17 => 'Error other'];

    const STATUS_NEW = 1;
    const STATUS_REPEATS = 2;
    const STATUS_ERROR_BC_NOT_FOUND = 11;
    const STATUS_ERROR_TRANSACTION_ID = 12;
    const STATUS_ERROR_TXN_AMOUNT = 13;
    const STATUS_ERROR_BC_COM_AMOUNT = 14;
    const STATUS_ERROR_TXN_TYPE = 15;
    const STATUS_ERROR_TXN_DATE_TIME = 16;
    const STATUS_ERROR_GENRIC = 17;
    const RAW_DUMP_PROSSESS_LIMIT = 10000;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {

        return [
            [['form'], 'required'],
            [['csvfile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'],
            [['master_partner_bank_id'], 'required'],
            [['label'], 'string', 'max' => 125],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'csvfile' => 'Select BC Transaction CSV file',
            'master_partner_bank_id' => 'Partner bank',
        );
    }

    public function dump($file_model) {
        $fp = fopen(Yii::$app->params['datapath'] . '/partneragencies' . '/transaction/' . $file_model->master_partner_bank_id . '/' . $file_model->file_name, 'r');
        $file_model->status = BcTransactionFiles::STATUS_FILE_DUMP;
        $file_model->update();
        if ($file_model->master_partner_bank_id == MasterPartnerBank::BOB) {
            $line = fgetcsv($fp, 1000, ",");
            $rows = [];
            $first_time = true;
            $sr_no = 1;
            do {
                if ($first_time == true) {
                    $first_time = false;
                    $sr_no++;
                    continue;
                } else {
                    $dmodel = new BcTransactionTable1();
                    if (isset($line[0])) {
                        $dmodel->col0 = $line[0];
                    }
                    if (isset($line[1])) {
                        $dmodel->col1 = $line[1];
                    }
                    if (isset($line[2])) {
                        $dmodel->col2 = $line[2];
                    }
                    if (isset($line[3])) {
                        $dmodel->col3 = $line[3];
                    }
                    if (isset($line[4])) {
                        $dmodel->col4 = $line[4];
                    }
                    if (isset($line[5])) {
                        $dmodel->col5 = $line[5];
                    }

                    $dmodel->col6 = (string) $sr_no;

                    if ($this->file_table_time) {
                        $dmodel->created_at = $file_model->created_at;
                        $dmodel->updated_at = $file_model->updated_at;
                    }
                    $dmodel->file_id = $file_model->id;
                    $dmodel->master_partner_bank_id = $file_model->master_partner_bank_id;
                    $dmodel->save();
                }
                $sr_no++;
            } while (($line = fgetcsv($fp, 1000, ",")) != FALSE);
            return true;
        }
        if ($file_model->master_partner_bank_id == MasterPartnerBank::FINO) {
            $line = fgetcsv($fp, 1000, ",");
            $rows = [];
            $first_time = true;
            $sr_no = 1;
            do {
                if ($first_time == true) {
                    $first_time = false;
                    $sr_no++;
                    continue;
                } else {
                    $dmodel = new BcTransactionTable2();
                    if (isset($line[0])) {
                        $dmodel->col0 = $line[0];
                    }
                    if (isset($line[1])) {
                        $dmodel->col1 = $line[1];
                    }
                    if (isset($line[2])) {
                        $dmodel->col2 = $line[2];
                    }
                    if (isset($line[3])) {
                        $dmodel->col3 = $line[3];
                    }
                    if (isset($line[4])) {
                        $dmodel->col4 = $line[4];
                    }
                    if (isset($line[5])) {
                        $dmodel->col5 = $line[5];
                    }
                    $dmodel->col6 = (string) $sr_no;
                    if ($this->file_table_time) {
                        $dmodel->created_at = $file_model->created_at;
                        $dmodel->updated_at = $file_model->updated_at;
                    }
                    $dmodel->file_id = $file_model->id;
                    $dmodel->master_partner_bank_id = $file_model->master_partner_bank_id;
                    $dmodel->save();
                }
                $sr_no++;
            } while (($line = fgetcsv($fp, 1000, ",")) != FALSE);
            return true;
        }
        if ($file_model->master_partner_bank_id == MasterPartnerBank::NEARBY) {
            $line = fgetcsv($fp, 1000, ",");
            $rows = [];
            $first_time = true;
            $sr_no = 1;
            do {
                if ($first_time == true) {
                    $first_time = false;
                    $sr_no++;
                    continue;
                } else {
                    $dmodel = new BcTransactionTable3();
                    if (isset($line[0])) {
                        $dmodel->col0 = $line[0];
                    }
                    if (isset($line[1])) {
                        $dmodel->col1 = $line[1];
                    }
                    if (isset($line[2])) {
                        $dmodel->col2 = $line[2];
                    }
                    if (isset($line[3])) {
                        $dmodel->col3 = $line[3];
                    }
                    if (isset($line[4])) {
                        $dmodel->col4 = $line[4];
                    }
                    if (isset($line[5])) {
                        $dmodel->col5 = $line[5];
                    }
                    $dmodel->col6 = (string) $sr_no;
                    if ($this->file_table_time) {
                        $dmodel->created_at = $file_model->created_at;
                        $dmodel->updated_at = $file_model->updated_at;
                    }
                    $dmodel->file_id = $file_model->id;
                    $dmodel->master_partner_bank_id = $file_model->master_partner_bank_id;
                    $dmodel->save();
                }
                $sr_no++;
            } while (($line = fgetcsv($fp, 1000, ",")) != FALSE);
            return true;
        }
        if ($file_model->master_partner_bank_id == MasterPartnerBank::MANIPAL) {
            $line = fgetcsv($fp, 1000, ",");
            $rows = [];
            $first_time = true;
            $sr_no = 1;
            do {
                if ($first_time == true) {
                    $first_time = false;
                    $sr_no++;
                    continue;
                } else {
                    $dmodel = new BcTransactionTable4();
                    if (isset($line[0])) {
                        $dmodel->col0 = $line[0];
                    }
                    if (isset($line[1])) {
                        $dmodel->col1 = $line[1];
                    }
                    if (isset($line[2])) {
                        $dmodel->col2 = $line[2];
                    }
                    if (isset($line[3])) {
                        $dmodel->col3 = $line[3];
                    }
                    if (isset($line[4])) {
                        $dmodel->col4 = $line[4];
                    }
                    if (isset($line[5])) {
                        $dmodel->col5 = $line[5];
                    }
                    $dmodel->col6 = (string) $sr_no;
                    if ($this->file_table_time) {
                        $dmodel->created_at = $file_model->created_at;
                        $dmodel->updated_at = $file_model->updated_at;
                    }
                    $dmodel->file_id = $file_model->id;
                    $dmodel->master_partner_bank_id = $file_model->master_partner_bank_id;
                    $dmodel->save();
                }
                $sr_no++;
            } while (($line = fgetcsv($fp, 1000, ",")) != FALSE);
            return true;
        }
        if ($file_model->master_partner_bank_id == MasterPartnerBank::MFSL_AIRTEl) {
            $line = fgetcsv($fp, 1000, ",");
            $rows = [];
            $first_time = true;
            $sr_no = 1;
            do {
                if ($first_time == true) {
                    $first_time = false;
                    $sr_no++;
                    continue;
                } else {
                    $dmodel = new BcTransactionTable5();
                    if (isset($line[0])) {
                        $dmodel->col0 = $line[0];
                    }
                    if (isset($line[1])) {
                        $dmodel->col1 = $line[1];
                    }
                    if (isset($line[2])) {
                        $dmodel->col2 = $line[2];
                    }
                    if (isset($line[3])) {
                        $dmodel->col3 = $line[3];
                    }
                    if (isset($line[4])) {
                        $dmodel->col4 = $line[4];
                    }
                    if (isset($line[5])) {
                        $dmodel->col5 = $line[5];
                    }
                    $dmodel->col6 = (string) $sr_no;
                    if ($this->file_table_time) {
                        $dmodel->created_at = $file_model->created_at;
                        $dmodel->updated_at = $file_model->updated_at;
                    }
                    $dmodel->file_id = $file_model->id;
                    $dmodel->master_partner_bank_id = $file_model->master_partner_bank_id;
                    $dmodel->save();
                }
                $sr_no++;
            } while (($line = fgetcsv($fp, 1000, ",")) != FALSE);
            return true;
        }
        if ($file_model->master_partner_bank_id == MasterPartnerBank::PTM) {
            $line = fgetcsv($fp, 1000, ",");
            $rows = [];
            $first_time = true;
            $sr_no = 1;
            do {
                if ($first_time == true) {
                    $first_time = false;
                    $sr_no++;
                    continue;
                } else {
                    $dmodel = new BcTransactionTable6();
                    if (isset($line[0])) {
                        $dmodel->col0 = $line[0];
                    }
                    if (isset($line[1])) {
                        $dmodel->col1 = $line[1];
                    }
                    if (isset($line[2])) {
                        $dmodel->col2 = $line[2];
                    }
                    if (isset($line[3])) {
                        $dmodel->col3 = $line[3];
                    }
                    if (isset($line[4])) {
                        $dmodel->col4 = $line[4];
                    }
                    if (isset($line[5])) {
                        $dmodel->col5 = $line[5];
                    }
                    $dmodel->col6 = (string) $sr_no;
                    if ($this->file_table_time) {
                        $dmodel->created_at = $file_model->created_at;
                        $dmodel->updated_at = $file_model->updated_at;
                    }
                    $dmodel->file_id = $file_model->id;
                    $dmodel->master_partner_bank_id = $file_model->master_partner_bank_id;
                    $dmodel->save();
                }
                $sr_no++;
            } while (($line = fgetcsv($fp, 1000, ",")) != FALSE);
            return true;
        }
    }

    public function transaction($file_model) {
        $file_model = BcTransactionFiles::findOne($file_model->id);
        $file_path = Yii::$app->params['datapath'] . '/partneragencies' . '/transaction/' . $file_model->master_partner_bank_id . '/';
        $file_csv_path = Yii::$app->params['datapath'] . '/partneragencies' . '/transaction/' . $file_model->master_partner_bank_id . '/' . $file_model->file_name;
        $file_csv_name = basename($file_csv_path, ".csv");
        $error_file_name = $file_csv_name . '_error';
        if ($file_model->master_partner_bank_id == MasterPartnerBank::BOB) {
            $upload_transaction_data = BcTransactionTable1::find()->where(['file_id' => $file_model->id, 'status' => 0])->all();
            if ($upload_transaction_data != null) {
                foreach ($upload_transaction_data as $dmodel) {
                    // col0 bankidbc
                    // col1 transaction id
                    // col2 transaction type
                    // col3 transaction amount
                    // col4 transaction date time                           
                    // col5 commition amount
                    $app_model = SrlmBcApplication::find()->where(['master_partner_bank_id' => $dmodel->master_partner_bank_id, 'bankidbc' => $dmodel->col0])->one();
                    $transaction_model = BcTransaction::find()->where(['banktransactionid' => $dmodel->col1, 'bankidbc' => $dmodel->col0])->one();
                    if ($transaction_model != null) {
                        $dmodel->status = UploadCsvTransactionForm::STATUS_REPEATS;
                    } else {
                        $transaction_model = new BcTransaction();
                        $dmodel->status = UploadCsvTransactionForm::STATUS_NEW;
                    }
                    if ($app_model != null) {
                        $transaction_model->bc_application_id = $app_model->id;
                        $transaction_model->user_id = $app_model->user_id;
                        $transaction_model->district_code = $app_model->district_code;
                        $transaction_model->block_code = $app_model->block_code;
                        $transaction_model->gram_panchayat_code = $app_model->gram_panchayat_code;
                    }
                    if (strpos($dmodel->col0, 'E+') !== false) {
                        $transaction_model->bankidbc = '';
                    } else {
                        $transaction_model->bankidbc = $dmodel->col0;
                    }
                    $transaction_model->master_partner_bank_id = $dmodel->master_partner_bank_id;
                    $transaction_model->file_id = $file_model->id;
                    $transaction_model->dtable_id = $dmodel->id;
                    $transaction_model->fileupload_datetime = $file_model->upload_datetime;
                    $transaction_model->created_by = $file_model->upload_by;
                    if (strpos($dmodel->col1, 'E+') !== false) {
                        $transaction_model->banktransactionid = '';
                    } else {
                        $transaction_model->banktransactionid = $dmodel->col1;
                    }
                    $transaction_model->transaction_type = $dmodel->col2;
                    $transaction_model->transaction_amount = $dmodel->col3;
                    try {
                        $transaction_model->transaction_datetime = \common\helpers\Utility::tbcdateformatdb($dmodel->col4);
                    } catch (\Exception $ex) {
                        $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_DATE_TIME;
                        $dmodel->save();
                        $this->error++;
                        continue;
                    }
                    $transaction_model->commission_amount = $dmodel->col5;
                    if ($this->file_table_time) {
                        $transaction_model->created_at = $file_model->created_at;
                        $transaction_model->updated_at = $file_model->updated_at;
                    }
                    if ($transaction_model->validate()) {
                        if ($transaction_model->save()) {
                            if ($dmodel->status == UploadCsvTransactionForm::STATUS_NEW) {
                                $this->new++;
                            }
                            if ($dmodel->status == UploadCsvTransactionForm::STATUS_REPEATS) {
                                $this->repeats++;
                            }
                            $dmodel->save();
                        } else {
                            
                        }
                    } else {
                        $model_errors = $transaction_model->getErrors();
                        if (isset($model_errors['bankidbc'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_BC_NOT_FOUND;
                        } else if (isset($model_errors['banktransactionid'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TRANSACTION_ID;
                        } else if (isset($model_errors['transaction_amount'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_AMOUNT;
                        } else if (isset($model_errors['transaction_datetime'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_DATE_TIME;
                        } else if (isset($model_errors['commission_amount'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_BC_COM_AMOUNT;
                        } else if (isset($model_errors['transaction_type'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_TYPE;
                        } else {
                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_GENRIC;
                        }
                        $this->error++;
                        $dmodel->save();
                    }
                }
                $error_models = BcTransactionTable1::find()->where(['file_id' => $file_model->id])->andWhere(['>', 'status', 10])->all();
                $csv = "row_number,usr_id,txn_id,product_type,txn_value,datetime,bc_commison,Error \n";
                foreach ($error_models as $em) {
                    $csv .= $em->col6 . "," . '"' . $em->col0 . '","' . $em->col1 . '","' . $em->col2 . '","' . $em->col3 . '","' . $em->col4 . '","' . $em->col5 . '",' . $this->error_option[$em->status] . "\n";
                }
                $error_csv_handler = fopen($file_path . $error_file_name . '.csv', 'w');
                fwrite($error_csv_handler, $csv);
                fclose($error_csv_handler);
                $file_model->status = BcTransactionFiles::STATUS_FILE_PROCESS;
                $file_model->new = $this->new;
                $file_model->repeats = $this->repeats;
                $file_model->error = $this->error;
                $file_model->save();
                return true;
            }
        }
        if ($file_model->master_partner_bank_id == MasterPartnerBank::FINO) {
            $upload_transaction_data = BcTransactionTable2::find()->where(['file_id' => $file_model->id, 'status' => 0])->all();
            if ($upload_transaction_data != null) {
                foreach ($upload_transaction_data as $dmodel) {
                    // col0 bankidbc
                    // col1 transaction id
                    // col2 transaction type
                    // col3 transaction amount
                    // col4 transaction date time                           
                    // col5 commition amount
                    $app_model = SrlmBcApplication::find()->where(['master_partner_bank_id' => $dmodel->master_partner_bank_id, 'bankidbc' => $dmodel->col0])->one();
                    $transaction_model = BcTransaction::find()->where(['banktransactionid' => $dmodel->col1, 'bankidbc' => $dmodel->col0])->one();
                    if ($transaction_model != null) {
                        $dmodel->status = UploadCsvTransactionForm::STATUS_REPEATS;
                    } else {
                        $transaction_model = new BcTransaction();
                        $dmodel->status = UploadCsvTransactionForm::STATUS_NEW;
                    }
                    if ($app_model != null) {
                        $transaction_model->bc_application_id = $app_model->id;
                        $transaction_model->user_id = $app_model->user_id;
                        $transaction_model->district_code = $app_model->district_code;
                        $transaction_model->block_code = $app_model->block_code;
                        $transaction_model->gram_panchayat_code = $app_model->gram_panchayat_code;
                    }
                    if (strpos($dmodel->col0, 'E+') !== false) {
                        $transaction_model->bankidbc = '';
                    } else {
                        $transaction_model->bankidbc = $dmodel->col0;
                    }
                    $transaction_model->master_partner_bank_id = $dmodel->master_partner_bank_id;
                    $transaction_model->file_id = $file_model->id;
                    $transaction_model->dtable_id = $dmodel->id;
                    $transaction_model->fileupload_datetime = $file_model->upload_datetime;
                    $transaction_model->created_by = $file_model->upload_by;
                    if (strpos($dmodel->col1, 'E+') !== false) {
                        $transaction_model->banktransactionid = '';
                    } else {
                        $transaction_model->banktransactionid = $dmodel->col1;
                    }
                    $transaction_model->transaction_type = $dmodel->col2;
                    $transaction_model->transaction_amount = $dmodel->col3;
                    try {
                        $transaction_model->transaction_datetime = $dmodel->col4;
                    } catch (\Exception $ex) {
                        $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_DATE_TIME;
                        $dmodel->save();
                        $this->error++;
                        continue;
                    }
                    $transaction_model->commission_amount = $dmodel->col5;

                    if ($this->file_table_time) {
                        $transaction_model->created_at = $file_model->created_at;
                        $transaction_model->updated_at = $file_model->updated_at;
                    }
                    if ($transaction_model->validate()) {
                        if ($transaction_model->save()) {
                            if ($dmodel->status == UploadCsvTransactionForm::STATUS_NEW) {
                                $this->new++;
                            }
                            if ($dmodel->status == UploadCsvTransactionForm::STATUS_REPEATS) {
                                $this->repeats++;
                            }
                            $dmodel->save();
                        } else {
                            
                        }
                    } else {
                        $model_errors = $transaction_model->getErrors();
                        if (isset($model_errors['bankidbc'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_BC_NOT_FOUND;
                        } else if (isset($model_errors['banktransactionid'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TRANSACTION_ID;
                        } else if (isset($model_errors['transaction_amount'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_AMOUNT;
                        } else if (isset($model_errors['transaction_datetime'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_DATE_TIME;
                        } else if (isset($model_errors['commission_amount'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_BC_COM_AMOUNT;
                        } else if (isset($model_errors['transaction_type'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_TYPE;
                        } else {
                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_GENRIC;
                        }
                        $this->error++;
                        $dmodel->save();
                    }
                }
                $error_models = BcTransactionTable2::find()->where(['file_id' => $file_model->id])->andWhere(['>', 'status', 10])->all();
                $csv = "row_number,usr_id,txn_id,product_type,txn_value,datetime,bc_commison,Error \n";
                foreach ($error_models as $em) {
                    $csv .= $em->col6 . "," . '"' . $em->col0 . '","' . $em->col1 . '","' . $em->col2 . '","' . $em->col3 . '","' . $em->col4 . '","' . $em->col5 . '",' . $this->error_option[$em->status] . "\n";
                }
                $error_csv_handler = fopen($file_path . $error_file_name . '.csv', 'w');
                fwrite($error_csv_handler, $csv);
                fclose($error_csv_handler);
                $file_model->status = BcTransactionFiles::STATUS_FILE_PROCESS;
                $file_model->new = $this->new;
                $file_model->repeats = $this->repeats;
                $file_model->error = $this->error;
                $file_model->save();
                return true;
            }
        }
        if ($file_model->master_partner_bank_id == MasterPartnerBank::NEARBY) {
            $upload_transaction_data = BcTransactionTable3::find()->where(['file_id' => $file_model->id, 'status' => 0])->all();
            if ($upload_transaction_data != null) {
                foreach ($upload_transaction_data as $dmodel) {
                    // col0 bankidbc
                    // col1 transaction id
                    // col2 transaction type
                    // col3 transaction amount
                    // col4 transaction date time                           
                    // col5 commition amount
                    $app_model = SrlmBcApplication::find()->where(['master_partner_bank_id' => $dmodel->master_partner_bank_id, 'bankidbc' => $dmodel->col0])->one();
                    $transaction_model = BcTransaction::find()->where(['banktransactionid' => $dmodel->col1, 'bankidbc' => $dmodel->col0])->one();
                    if ($transaction_model != null) {
                        $dmodel->status = UploadCsvTransactionForm::STATUS_REPEATS;
                    } else {
                        $transaction_model = new BcTransaction();
                        $dmodel->status = UploadCsvTransactionForm::STATUS_NEW;
                    }
                    if ($app_model != null) {
                        $transaction_model->bc_application_id = $app_model->id;
                        $transaction_model->user_id = $app_model->user_id;
                        $transaction_model->district_code = $app_model->district_code;
                        $transaction_model->block_code = $app_model->block_code;
                        $transaction_model->gram_panchayat_code = $app_model->gram_panchayat_code;
                    }
                    if (strpos($dmodel->col0, 'E+') !== false) {
                        $transaction_model->bankidbc = '';
                    } else {
                        $transaction_model->bankidbc = $dmodel->col0;
                    }
                    $transaction_model->master_partner_bank_id = $dmodel->master_partner_bank_id;
                    $transaction_model->file_id = $file_model->id;
                    $transaction_model->dtable_id = $dmodel->id;
                    $transaction_model->fileupload_datetime = $file_model->upload_datetime;
                    $transaction_model->created_by = $file_model->upload_by;
                    if (strpos($dmodel->col1, 'E+') !== false) {
                        $transaction_model->banktransactionid = '';
                    } else {
                        $transaction_model->banktransactionid = $dmodel->col1;
                    }
                    $transaction_model->transaction_type = $dmodel->col2;
                    $transaction_model->transaction_amount = $dmodel->col3;
                    try {
                        $transaction_model->transaction_datetime = $dmodel->col4;
                    } catch (\Exception $ex) {
                        $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_DATE_TIME;
                        $dmodel->save();
                        $this->error++;
                        continue;
                    }
                    $transaction_model->commission_amount = $dmodel->col5;

                    if ($this->file_table_time) {
                        $transaction_model->created_at = $file_model->created_at;
                        $transaction_model->updated_at = $file_model->updated_at;
                    }
                    if ($transaction_model->validate()) {
                        if ($transaction_model->save()) {
                            if ($dmodel->status == UploadCsvTransactionForm::STATUS_NEW) {
                                $this->new++;
                            }
                            if ($dmodel->status == UploadCsvTransactionForm::STATUS_REPEATS) {
                                $this->repeats++;
                            }
                            $dmodel->save();
                        } else {
                            
                        }
                    } else {
                        $model_errors = $transaction_model->getErrors();
                        if (isset($model_errors['bankidbc'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_BC_NOT_FOUND;
                        } else if (isset($model_errors['banktransactionid'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TRANSACTION_ID;
                        } else if (isset($model_errors['transaction_amount'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_AMOUNT;
                        } else if (isset($model_errors['transaction_datetime'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_DATE_TIME;
                        } else if (isset($model_errors['commission_amount'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_BC_COM_AMOUNT;
                        } else if (isset($model_errors['transaction_type'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_TYPE;
                        } else {
                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_GENRIC;
                        }
                        $this->error++;
                        $dmodel->save();
                    }
                }
                $error_models = BcTransactionTable3::find()->where(['file_id' => $file_model->id])->andWhere(['>', 'status', 10])->all();
                $csv = "row_number,usr_id,txn_id,product_type,txn_value,datetime,bc_commison,Error \n";
                foreach ($error_models as $em) {
                    $csv .= $em->col6 . "," . '"' . $em->col0 . '","' . $em->col1 . '","' . $em->col2 . '","' . $em->col3 . '","' . $em->col4 . '","' . $em->col5 . '",' . $this->error_option[$em->status] . "\n";
                }
                $error_csv_handler = fopen($file_path . $error_file_name . '.csv', 'w');
                fwrite($error_csv_handler, $csv);
                fclose($error_csv_handler);
                $file_model->status = BcTransactionFiles::STATUS_FILE_PROCESS;
                $file_model->new = $this->new;
                $file_model->repeats = $this->repeats;
                $file_model->error = $this->error;
                $file_model->save();
                return true;
            }
        }
        if ($file_model->master_partner_bank_id == MasterPartnerBank::MANIPAL) {
            $upload_transaction_data = BcTransactionTable4::find()->where(['file_id' => $file_model->id, 'status' => 0])->all();
            if ($upload_transaction_data != null) {
                foreach ($upload_transaction_data as $dmodel) {
                    // col0 bankidbc
                    // col1 transaction id
                    // col2 transaction type
                    // col3 transaction amount
                    // col4 transaction date time                           
                    // col5 commition amount
                    $app_model = SrlmBcApplication::find()->where(['master_partner_bank_id' => $dmodel->master_partner_bank_id, 'bankidbc' => $dmodel->col0])->one();
                    $transaction_model = BcTransaction::find()->where(['banktransactionid' => $dmodel->col1, 'bankidbc' => $dmodel->col0])->one();
                    if ($transaction_model != null) {
                        $dmodel->status = UploadCsvTransactionForm::STATUS_REPEATS;
                    } else {
                        $transaction_model = new BcTransaction();
                        $dmodel->status = UploadCsvTransactionForm::STATUS_NEW;
                    }
                    if ($app_model != null) {
                        $transaction_model->bc_application_id = $app_model->id;
                        $transaction_model->user_id = $app_model->user_id;
                        $transaction_model->district_code = $app_model->district_code;
                        $transaction_model->block_code = $app_model->block_code;
                        $transaction_model->gram_panchayat_code = $app_model->gram_panchayat_code;
                    }
                    if (strpos($dmodel->col0, 'E+') !== false) {
                        $transaction_model->bankidbc = '';
                    } else {
                        $transaction_model->bankidbc = $dmodel->col0;
                    }
                    $transaction_model->master_partner_bank_id = $dmodel->master_partner_bank_id;
                    $transaction_model->file_id = $file_model->id;
                    $transaction_model->dtable_id = $dmodel->id;
                    $transaction_model->fileupload_datetime = $file_model->upload_datetime;
                    $transaction_model->created_by = $file_model->upload_by;
                    if (strpos($dmodel->col1, 'E+') !== false) {
                        $transaction_model->banktransactionid = '';
                    } else {
                        $transaction_model->banktransactionid = $dmodel->col1;
                    }
                    $transaction_model->transaction_type = $dmodel->col2;
                    $transaction_model->transaction_amount = $dmodel->col3;
                    try {
                        $transaction_model->transaction_datetime = $dmodel->col4;
                    } catch (\Exception $ex) {
                        $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_DATE_TIME;
                        $dmodel->save();
                        $this->error++;
                        continue;
                    }
                    $transaction_model->commission_amount = $dmodel->col5;

                    if ($this->file_table_time) {
                        $transaction_model->created_at = $file_model->created_at;
                        $transaction_model->updated_at = $file_model->updated_at;
                    }
                    if ($transaction_model->validate()) {
                        if ($transaction_model->save()) {
                            if ($dmodel->status == UploadCsvTransactionForm::STATUS_NEW) {
                                $this->new++;
                            }
                            if ($dmodel->status == UploadCsvTransactionForm::STATUS_REPEATS) {
                                $this->repeats++;
                            }
                            $dmodel->save();
                        } else {
                            
                        }
                    } else {
                        $model_errors = $transaction_model->getErrors();
                        if (isset($model_errors['banktransactionid'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TRANSACTION_ID;
                        } else if (isset($model_errors['transaction_amount'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_AMOUNT;
                        } else if (isset($model_errors['transaction_datetime'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_DATE_TIME;
                        } else if (isset($model_errors['commission_amount'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_BC_COM_AMOUNT;
                        } else if (isset($model_errors['transaction_type'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_TYPE;
                        } else {
                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_GENRIC;
                        }
                        $this->error++;
                        $dmodel->save();
                    }
                }
                $error_models = BcTransactionTable4::find()->where(['file_id' => $file_model->id])->andWhere(['>', 'status', 10])->all();
                $csv = "row_number,usr_id,txn_id,product_type,txn_value,datetime,bc_commison,Error \n";
                foreach ($error_models as $em) {
                    $csv .= $em->col6 . "," . '"' . $em->col0 . '","' . $em->col1 . '","' . $em->col2 . '","' . $em->col3 . '","' . $em->col4 . '","' . $em->col5 . '",' . $this->error_option[$em->status] . "\n";
                }
                $error_csv_handler = fopen($file_path . $error_file_name . '.csv', 'w');
                fwrite($error_csv_handler, $csv);
                fclose($error_csv_handler);
                $file_model->status = BcTransactionFiles::STATUS_FILE_PROCESS;
                $file_model->new = $this->new;
                $file_model->repeats = $this->repeats;
                $file_model->error = $this->error;
                $file_model->save();
                return true;
            }
        }
        if ($file_model->master_partner_bank_id == MasterPartnerBank::MFSL_AIRTEl) {
            $upload_transaction_data = BcTransactionTable5::find()->where(['file_id' => $file_model->id, 'status' => 0])->all();
            if ($upload_transaction_data != null) {
                foreach ($upload_transaction_data as $dmodel) {
                    // col0 bankidbc
                    // col1 transaction id
                    // col2 transaction type
                    // col3 transaction amount
                    // col4 transaction date time                           
                    // col5 commition amount
                    $app_model = SrlmBcApplication::find()->where(['master_partner_bank_id' => $dmodel->master_partner_bank_id, 'bankidbc' => $dmodel->col0])->one();
                    $transaction_model = BcTransaction::find()->where(['banktransactionid' => $dmodel->col1, 'bankidbc' => $dmodel->col0])->one();
                    if ($transaction_model != null) {
                        $dmodel->status = UploadCsvTransactionForm::STATUS_REPEATS;
                    } else {
                        $transaction_model = new BcTransaction();
                        $dmodel->status = UploadCsvTransactionForm::STATUS_NEW;
                    }
                    if ($app_model != null) {
                        $transaction_model->bc_application_id = $app_model->id;
                        $transaction_model->user_id = $app_model->user_id;
                        $transaction_model->district_code = $app_model->district_code;
                        $transaction_model->block_code = $app_model->block_code;
                        $transaction_model->gram_panchayat_code = $app_model->gram_panchayat_code;
                    }
                    if (strpos($dmodel->col0, 'E+') !== false) {
                        $transaction_model->bankidbc = '';
                    } else {
                        $transaction_model->bankidbc = $dmodel->col0;
                    }
                    $transaction_model->master_partner_bank_id = $dmodel->master_partner_bank_id;
                    $transaction_model->file_id = $file_model->id;
                    $transaction_model->dtable_id = $dmodel->id;
                    $transaction_model->fileupload_datetime = $file_model->upload_datetime;
                    $transaction_model->created_by = $file_model->upload_by;
                    if (strpos($dmodel->col1, 'E+') !== false) {
                        $transaction_model->banktransactionid = '';
                    } else {
                        $transaction_model->banktransactionid = $dmodel->col1;
                    }
                    $transaction_model->transaction_type = $dmodel->col2;
                    $transaction_model->transaction_amount = $dmodel->col3;
                    try {
                        $transaction_model->transaction_datetime = $dmodel->col4;
                    } catch (\Exception $ex) {
                        $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_DATE_TIME;
                        $dmodel->save();
                        $this->error++;
                        continue;
                    }
                    $transaction_model->commission_amount = $dmodel->col5;

                    if ($this->file_table_time) {
                        $transaction_model->created_at = $file_model->created_at;
                        $transaction_model->updated_at = $file_model->updated_at;
                    }
                    if ($transaction_model->validate()) {
                        if ($transaction_model->save()) {
                            if ($dmodel->status == UploadCsvTransactionForm::STATUS_NEW) {
                                $this->new++;
                            }
                            if ($dmodel->status == UploadCsvTransactionForm::STATUS_REPEATS) {
                                $this->repeats++;
                            }
                            $dmodel->save();
                        } else {
                            
                        }
                    } else {
                        $model_errors = $transaction_model->getErrors();
                        if (isset($model_errors['bankidbc'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_BC_NOT_FOUND;
                        } else if (isset($model_errors['banktransactionid'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TRANSACTION_ID;
                        } else if (isset($model_errors['transaction_amount'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_AMOUNT;
                        } else if (isset($model_errors['transaction_datetime'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_DATE_TIME;
                        } else if (isset($model_errors['commission_amount'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_BC_COM_AMOUNT;
                        } else if (isset($model_errors['transaction_type'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_TYPE;
                        } else {
                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_GENRIC;
                        }
                        $this->error++;
                        $dmodel->save();
                    }
                }
                $error_models = BcTransactionTable5::find()->where(['file_id' => $file_model->id])->andWhere(['>', 'status', 10])->all();
                $csv = "row_number,usr_id,txn_id,product_type,txn_value,datetime,bc_commison,Error \n";
                foreach ($error_models as $em) {
                    $csv .= $em->col6 . "," . '"' . $em->col0 . '","' . $em->col1 . '","' . $em->col2 . '","' . $em->col3 . '","' . $em->col4 . '","' . $em->col5 . '",' . $this->error_option[$em->status] . "\n";
                }
                $error_csv_handler = fopen($file_path . $error_file_name . '.csv', 'w');
                fwrite($error_csv_handler, $csv);
                fclose($error_csv_handler);
                $file_model->status = BcTransactionFiles::STATUS_FILE_PROCESS;
                $file_model->new = $this->new;
                $file_model->repeats = $this->repeats;
                $file_model->error = $this->error;
                $file_model->save();
                return true;
            }
        }
        if ($file_model->master_partner_bank_id == MasterPartnerBank::PTM) {
            $upload_transaction_data = BcTransactionTable6::find()->where(['file_id' => $file_model->id, 'status' => 0])->all();
            if ($upload_transaction_data != null) {
                foreach ($upload_transaction_data as $dmodel) {
                    // col0 bankidbc
                    // col1 transaction id
                    // col2 transaction type
                    // col3 transaction amount
                    // col4 transaction date time                           
                    // col5 commition amount
                    $app_model = SrlmBcApplication::find()->where(['master_partner_bank_id' => $dmodel->master_partner_bank_id, 'bankidbc' => $dmodel->col0])->one();
                    $transaction_model = BcTransaction::find()->where(['banktransactionid' => $dmodel->col1, 'bankidbc' => $dmodel->col0])->one();
                    if ($transaction_model != null) {
                        $dmodel->status = UploadCsvTransactionForm::STATUS_REPEATS;
                    } else {
                        $transaction_model = new BcTransaction();
                        $dmodel->status = UploadCsvTransactionForm::STATUS_NEW;
                    }
                    if ($app_model != null) {
                        $transaction_model->bc_application_id = $app_model->id;
                        $transaction_model->user_id = $app_model->user_id;
                        $transaction_model->district_code = $app_model->district_code;
                        $transaction_model->block_code = $app_model->block_code;
                        $transaction_model->gram_panchayat_code = $app_model->gram_panchayat_code;
                    }
                    if (strpos($dmodel->col0, 'E+') !== false) {
                        $transaction_model->bankidbc = '';
                    } else {
                        $transaction_model->bankidbc = $dmodel->col0;
                    }
                    $transaction_model->master_partner_bank_id = $dmodel->master_partner_bank_id;
                    $transaction_model->file_id = $file_model->id;
                    $transaction_model->dtable_id = $dmodel->id;
                    $transaction_model->fileupload_datetime = $file_model->upload_datetime;
                    $transaction_model->created_by = $file_model->upload_by;
                    if (strpos($dmodel->col1, 'E+') !== false) {
                        $transaction_model->banktransactionid = '';
                    } else {
                        $transaction_model->banktransactionid = $dmodel->col1;
                    }
                    $transaction_model->transaction_type = $dmodel->col2;
                    $transaction_model->transaction_amount = $dmodel->col3;
                    try {
                        $transaction_model->transaction_datetime = $dmodel->col4;
                    } catch (\Exception $ex) {
                        $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_DATE_TIME;
                        $dmodel->save();
                        $this->error++;
                        continue;
                    }
                    $transaction_model->commission_amount = $dmodel->col5;

                    if ($this->file_table_time) {
                        $transaction_model->created_at = $file_model->created_at;
                        $transaction_model->updated_at = $file_model->updated_at;
                    }
                    if ($transaction_model->validate()) {
                        if ($transaction_model->save()) {
                            if ($dmodel->status == UploadCsvTransactionForm::STATUS_NEW) {
                                $this->new++;
                            }
                            if ($dmodel->status == UploadCsvTransactionForm::STATUS_REPEATS) {
                                $this->repeats++;
                            }
                            $dmodel->save();
                        } else {
                            
                        }
                    } else {
                        $model_errors = $transaction_model->getErrors();
                        if (isset($model_errors['bankidbc'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_BC_NOT_FOUND;
                        } else if (isset($model_errors['banktransactionid'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TRANSACTION_ID;
                        } else if (isset($model_errors['transaction_amount'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_AMOUNT;
                        } else if (isset($model_errors['transaction_datetime'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_DATE_TIME;
                        } else if (isset($model_errors['commission_amount'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_BC_COM_AMOUNT;
                        } else if (isset($model_errors['transaction_type'])) {

                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_TXN_TYPE;
                        } else {
                            $dmodel->status = UploadCsvTransactionForm::STATUS_ERROR_GENRIC;
                        }
                        $this->error++;
                        $dmodel->save();
                    }
                }
                $error_models = BcTransactionTable6::find()->where(['file_id' => $file_model->id])->andWhere(['>', 'status', 10])->all();
                $csv = "row_number,usr_id,txn_id,product_type,txn_value,datetime,bc_commison,Error \n";
                foreach ($error_models as $em) {
                    $csv .= $em->col6 . "," . '"' . $em->col0 . '","' . $em->col1 . '","' . $em->col2 . '","' . $em->col3 . '","' . $em->col4 . '","' . $em->col5 . '",' . $this->error_option[$em->status] . "\n";
                }
                $error_csv_handler = fopen($file_path . $error_file_name . '.csv', 'w');
                fwrite($error_csv_handler, $csv);
                fclose($error_csv_handler);
                $file_model->status = BcTransactionFiles::STATUS_FILE_PROCESS;
                $file_model->new = $this->new;
                $file_model->repeats = $this->repeats;
                $file_model->error = $this->error;
                $file_model->save();
                return true;
            }
        }
    }

    public function delete($file_model) {
        $file_model = BcTransactionFiles::findOne($file_model->id);
        $file_path = Yii::$app->params['datapath'] . '/partneragencies' . '/transaction/' . $file_model->master_partner_bank_id . '/';
        $file_csv_path = Yii::$app->params['datapath'] . '/partneragencies' . '/transaction/' . $file_model->master_partner_bank_id . '/' . $file_model->file_name;
        $file_csv_name = basename($file_csv_path, ".csv");
        $error_file_name = $file_csv_name . '_error';
        if (in_array($file_model->status, [-3, -2])) {
            $file_model->status = -2;
            $file_model->save();
            if ($file_model->master_partner_bank_id == MasterPartnerBank::BOB) {
                $upload_transaction_data = BcTransactionTable1::find()->where(['file_id' => $file_model->id])->all();
                if ($upload_transaction_data != null) {
                    foreach ($upload_transaction_data as $dmodel) {
                        $transaction = BcTransaction::find()->where(['file_id' => $dmodel->file_id, 'dtable_id' => $dmodel->id])->limit(1)->one();
                        if ($transaction != null) {
                            $oldtransation = $transaction;
                            if ($transaction->delete()) {
                                //  echo 'delete :' . $oldtransation->id;
                                if ($oldtransation->bc_application_id != null) {
                                    $this->updatebc($oldtransation);
                                    $this->updatemonthlybc($oldtransation);
                                    $this->updateweeklybc($oldtransation);
                                    $this->updatedailybc($oldtransation);
                                }
                            } else {
                                //echo 'Not delete :' . $transaction->id;
                            }
                        }
                        $dmodel->delete();
                    }
                    $file_model->status = -1;
                    if ($file_model->new_process == 0) {
                        $file_model->new_process = -1;
                    }
                    $file_model->save();
                }
            }
            if ($file_model->master_partner_bank_id == MasterPartnerBank::FINO) {
                $upload_transaction_data = BcTransactionTable2::find()->where(['file_id' => $file_model->id])->all();
                if ($upload_transaction_data != null) {
                    foreach ($upload_transaction_data as $dmodel) {
                        $transaction = BcTransaction::find()->where(['file_id' => $dmodel->file_id, 'dtable_id' => $dmodel->id])->limit(1)->one();
                        if ($transaction != null) {
                            $oldtransation = $transaction;
                            if ($transaction->delete()) {
                                //  echo 'delete :' . $oldtransation->id;
                                if ($oldtransation->bc_application_id != null) {
                                    $this->updatebc($oldtransation);
                                    $this->updatemonthlybc($oldtransation);
                                    $this->updateweeklybc($oldtransation);
                                    $this->updatedailybc($oldtransation);
                                }
                            } else {
                                //echo 'Not delete :' . $transaction->id;
                            }
                        }
                        $dmodel->delete();
                    }
                    $file_model->status = -1;
                    if ($file_model->new_process == 0) {
                        $file_model->new_process = -1;
                    }
                    $file_model->save();
                }
            }
            if ($file_model->master_partner_bank_id == MasterPartnerBank::NEARBY) {
                $upload_transaction_data = BcTransactionTable3::find()->where(['file_id' => $file_model->id])->all();
                if ($upload_transaction_data != null) {
                    foreach ($upload_transaction_data as $dmodel) {
                        $transaction = BcTransaction::find()->where(['file_id' => $dmodel->file_id, 'dtable_id' => $dmodel->id])->limit(1)->one();
                        if ($transaction != null) {
                            $oldtransation = $transaction;
                            if ($transaction->delete()) {
                                //  echo 'delete :' . $oldtransation->id;
                                if ($oldtransation->bc_application_id != null) {
                                    $this->updatebc($oldtransation);
                                    $this->updatemonthlybc($oldtransation);
                                    $this->updateweeklybc($oldtransation);
                                    $this->updatedailybc($oldtransation);
                                }
                            } else {
                                //echo 'Not delete :' . $transaction->id;
                            }
                        }
                        $dmodel->delete();
                    }
                    $file_model->status = -1;
                    if ($file_model->new_process == 0) {
                        $file_model->new_process = -1;
                    }
                    $file_model->save();
                }
            }
            if ($file_model->master_partner_bank_id == MasterPartnerBank::MANIPAL) {
                $upload_transaction_data = BcTransactionTable4::find()->where(['file_id' => $file_model->id])->all();
                if ($upload_transaction_data != null) {
                    foreach ($upload_transaction_data as $dmodel) {
                        $transaction = BcTransaction::find()->where(['file_id' => $dmodel->file_id, 'dtable_id' => $dmodel->id])->limit(1)->one();
                        if ($transaction != null) {
                            $oldtransation = $transaction;
                            if ($transaction->delete()) {
                                //  echo 'delete :' . $oldtransation->id;
                                if ($oldtransation->bc_application_id != null) {
                                    $this->updatebc($oldtransation);
                                    $this->updatemonthlybc($oldtransation);
                                    $this->updateweeklybc($oldtransation);
                                    $this->updatedailybc($oldtransation);
                                }
                            } else {
                                //echo 'Not delete :' . $transaction->id;
                            }
                        }
                        $dmodel->delete();
                    }
                    $file_model->status = -1;
                    if ($file_model->new_process == 0) {
                        $file_model->new_process = -1;
                    }
                    $file_model->save();
                }
            }
            if ($file_model->master_partner_bank_id == MasterPartnerBank::MFSL_AIRTEl) {
                $upload_transaction_data = BcTransactionTable5::find()->where(['file_id' => $file_model->id])->all();
                if ($upload_transaction_data != null) {
                    foreach ($upload_transaction_data as $dmodel) {
                        $transaction = BcTransaction::find()->where(['file_id' => $dmodel->file_id, 'dtable_id' => $dmodel->id])->limit(1)->one();
                        if ($transaction != null) {
                            $oldtransation = $transaction;
                            if ($transaction->delete()) {
                                //  echo 'delete :' . $oldtransation->id;
                                if ($oldtransation->bc_application_id != null) {
                                    $this->updatebc($oldtransation);
                                    $this->updatemonthlybc($oldtransation);
                                    $this->updateweeklybc($oldtransation);
                                    $this->updatedailybc($oldtransation);
                                }
                            } else {
                                //echo 'Not delete :' . $transaction->id;
                            }
                        }
                        $dmodel->delete();
                    }
                    $file_model->status = -1;
                    if ($file_model->new_process == 0) {
                        $file_model->new_process = -1;
                    }
                    $file_model->save();
                }
            }
            if ($file_model->master_partner_bank_id == MasterPartnerBank::PTM) {
                $upload_transaction_data = BcTransactionTable6::find()->where(['file_id' => $file_model->id])->all();
                if ($upload_transaction_data != null) {
                    foreach ($upload_transaction_data as $dmodel) {
                        $transaction = BcTransaction::find()->where(['file_id' => $dmodel->file_id, 'dtable_id' => $dmodel->id])->limit(1)->one();
                        if ($transaction != null) {
                            $oldtransation = $transaction;
                            if ($transaction->delete()) {
                                //  echo 'delete :' . $oldtransation->id;
                                if ($oldtransation->bc_application_id != null) {
                                    $this->updatebc($oldtransation);
                                    $this->updatemonthlybc($oldtransation);
                                    $this->updateweeklybc($oldtransation);
                                    $this->updatedailybc($oldtransation);
                                }
                            } else {
                                //echo 'Not delete :' . $transaction->id;
                            }
                        }
                        $dmodel->delete();
                    }
                    $file_model->status = -1;
                    if ($file_model->new_process == 0) {
                        $file_model->new_process = -1;
                    }
                    $file_model->save();
                }
            }
        }
    }

    public function updatedailybc($transaction) {
        if ($transaction->bc_application_id) {
            $bc_tran = BcTransaction::find()->where(['bc_application_id' => $transaction->bc_application_id, 'transaction_date' => $transaction->transaction_date])->limit(1)->one();
            if (!empty($bc_tran)) {
                $bc_transaction_start_date_model = BcTransaction::find()->where(['bc_application_id' => $transaction->bc_application_id])->orderBy('transaction_date ASC')->limit(1)->one();
                $t_amount = BcTransaction::find()->select(['bc_application_id', 'transaction_amount', 'transaction_date'])->where(['bc_application_id' => $transaction->bc_application_id, 'transaction_date' => $bc_tran->transaction_date])->sum('transaction_amount');
                $t_com_amount = BcTransaction::find()->select(['bc_application_id', 'commission_amount', 'transaction_date'])->where(['bc_application_id' => $transaction->bc_application_id, 'transaction_date' => $bc_tran->transaction_date])->sum('commission_amount');
                $t_number = BcTransaction::find()->select(['id', 'bc_application_id', 'transaction_date'])->where(['bc_application_id' => $transaction->bc_application_id, 'transaction_date' => $bc_tran->transaction_date])->count();
                $big_ticket_count = BcTransaction::find()->select(['bc_application_id', 'ticket', 'transaction_date'])->where(['bc_application_id' => $transaction->bc_application_id, 'ticket' => 2, 'transaction_date' => $bc_tran->transaction_date])->count();
                $small_ticket_count = BcTransaction::find()->select(['bc_application_id', 'ticket', 'transaction_date'])->where(['bc_application_id' => $transaction->bc_application_id, 'ticket' => 1, 'transaction_date' => $bc_tran->transaction_date])->count();
                $daily_bc_tranasaction = \bc\models\transaction\BcTransactionDailyReport::find()->where(['date' => $bc_tran->transaction_date, 'bc_application_id' => $transaction->bc_application_id])->one();
                if (empty($daily_bc_tranasaction)) {
                    $daily_bc_tranasaction = new \bc\models\transaction\BcTransactionDailyReport();
                }
                $daily_bc_tranasaction->bc_application_id = $bc_tran->bc_application_id;
                $daily_bc_tranasaction->user_id = $bc_tran->user_id;
                $daily_bc_tranasaction->bankidbc = $bc_tran->bankidbc;
                $daily_bc_tranasaction->district_code = $bc_tran->district_code;
                $daily_bc_tranasaction->block_code = $bc_tran->block_code;
                $daily_bc_tranasaction->gram_panchayat_code = $bc_tran->gram_panchayat_code;
                $daily_bc_tranasaction->master_partner_bank_id = $bc_tran->master_partner_bank_id;
                $daily_bc_tranasaction->date = $bc_tran->transaction_date;
                $daily_bc_tranasaction->start_date = $bc_transaction_start_date_model->transaction_date;

                $daily_bc_tranasaction->big_ticket_count = $big_ticket_count;
                $daily_bc_tranasaction->small_ticket_count = $small_ticket_count;
                $daily_bc_tranasaction->no_of_transaction = $t_number;
                $daily_bc_tranasaction->transaction_amount = $t_amount;
                $daily_bc_tranasaction->commission_amount = $t_com_amount;
                if ($daily_bc_tranasaction->validate()) {
                    $daily_bc_tranasaction->save();
                }
            } else {
                $daily_bc_tranasaction = \bc\models\transaction\BcTransactionDailyReport::find()->where(['date' => $transaction->transaction_date, 'bc_application_id' => $transaction->bc_application_id])->one();
                if ($daily_bc_tranasaction != null) {
                    $daily_bc_tranasaction->delete();
                }
            }
        }
    }

    public function updateweeklybc($transaction) {
        if ($transaction->bc_application_id) {
            $bc_transaction_start_date_model = BcTransaction::find()->where(['bc_application_id' => $transaction->bc_application_id])->orderBy('transaction_date ASC')->limit(1)->one();
            $date = "'" . $transaction->transaction_date . "'";
            $sql = "SELECT * FROM `bc_transaction_master_week` WHERE (`week_start_date` BETWEEN $date AND week_end_date) OR (`week_end_date` BETWEEN $date AND  week_end_date) LIMIT 1";
            $week_model = \bc\models\transaction\BcTransactionMasterWeek::findBySql($sql)->one();
            $week_start_date = $week_model->week_start_date;
            $week_end_date = $week_model->week_end_date;
            $week_id = $week_model->id;
            $no_of_working_days = BcTransaction::find()->where(['bc_application_id' => $transaction->bc_application_id])->andFilterWhere(['>=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $week_start_date])->andFilterWhere(['<=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $week_end_date])->groupBy('transaction_date')->count();
            if ($no_of_working_days) {
                $t_amount = BcTransaction::find()->select(['bc_application_id', 'transaction_amount'])->where(['bc_application_id' => $transaction->bc_application_id])->andFilterWhere(['>=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $week_start_date])->andFilterWhere(['<=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $week_end_date])->sum('transaction_amount');
                $t_com_amount = BcTransaction::find()->select(['bc_application_id', 'commission_amount'])->where(['bc_application_id' => $transaction->bc_application_id])->andFilterWhere(['>=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $week_start_date])->andFilterWhere(['<=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $week_end_date])->sum('commission_amount');
                $t_number = BcTransaction::find()->select(['id', 'bc_application_id'])->where(['bc_application_id' => $transaction->bc_application_id])->andFilterWhere(['>=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $week_start_date])->andFilterWhere(['<=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $week_end_date])->count();
                $big_ticket_count = BcTransaction::find()->select(['bc_application_id', 'ticket'])->where(['bc_application_id' => $transaction->bc_application_id, 'ticket' => 2])->andFilterWhere(['>=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $week_start_date])->andFilterWhere(['<=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $week_end_date])->count();
                $small_ticket_count = BcTransaction::find()->select(['bc_application_id', 'ticket'])->where(['bc_application_id' => $transaction->bc_application_id, 'ticket' => 1])->andFilterWhere(['>=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $week_start_date])->andFilterWhere(['<=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $week_end_date])->count();

                $weekly_bc_tranasaction = \bc\models\transaction\BcTransactionWeeklyReport::find()->where(['bc_application_id' => $transaction->bc_application_id, 'week_id' => $week_id])->one();
                if (empty($weekly_bc_tranasaction)) {
                    $weekly_bc_tranasaction = new \bc\models\transaction\BcTransactionWeeklyReport();
                }
                $weekly_bc_tranasaction->bc_application_id = $bc_transaction_start_date_model->bc_application_id;
                $weekly_bc_tranasaction->user_id = $bc_transaction_start_date_model->user_id;
                $weekly_bc_tranasaction->bankidbc = $bc_transaction_start_date_model->bankidbc;
                $weekly_bc_tranasaction->district_code = $bc_transaction_start_date_model->district_code;
                $weekly_bc_tranasaction->block_code = $bc_transaction_start_date_model->block_code;
                $weekly_bc_tranasaction->gram_panchayat_code = $bc_transaction_start_date_model->gram_panchayat_code;
                $weekly_bc_tranasaction->master_partner_bank_id = $bc_transaction_start_date_model->master_partner_bank_id;
                $weekly_bc_tranasaction->week_id = $week_id;
                $weekly_bc_tranasaction->week_start_date = $week_start_date;
                $weekly_bc_tranasaction->week_end_date = $week_end_date;
                $weekly_bc_tranasaction->no_of_days = 7;
                $weekly_bc_tranasaction->no_of_working_days = $no_of_working_days;
                $weekly_bc_tranasaction->no_of_not_working_days = ($weekly_bc_tranasaction->no_of_days - $no_of_working_days);
                $weekly_bc_tranasaction->start_date = $bc_transaction_start_date_model->transaction_date;
                $weekly_bc_tranasaction->big_ticket_count = $big_ticket_count;
                $weekly_bc_tranasaction->small_ticket_count = $small_ticket_count;
                $weekly_bc_tranasaction->no_of_transaction = $t_number;
                $weekly_bc_tranasaction->transaction_amount = $t_amount;
                $weekly_bc_tranasaction->commission_amount = $t_com_amount;
                $weekly_bc_tranasaction->zero_transaction = BcTransaction::find()->select(['id', 'bc_application_id'])->where(['bc_application_id' => $transaction->bc_application_id, 'transaction_amount' => 0])->andFilterWhere(['>=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $week_start_date])->andFilterWhere(['<=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $week_end_date])->count();
                if ($weekly_bc_tranasaction->validate()) {
                    $weekly_bc_tranasaction->save();
                }
            } else {
                $weekly_bc_tranasaction = \bc\models\transaction\BcTransactionWeeklyReport::find()->where(['bc_application_id' => $transaction->bc_application_id, 'week_id' => $week_id])->one();
                if ($weekly_bc_tranasaction != null) {
                    $weekly_bc_tranasaction->delete();
                }
            }
        }
    }

    public function updatemonthlybc($transaction) {
        if ($transaction->bc_application_id) {
            $date = "'" . $transaction->transaction_date . "'";
            $sql = "SELECT * FROM `bc_transaction_master_month` WHERE (`month_start_date` BETWEEN $date AND month_end_date) OR (`month_end_date` BETWEEN $date AND  month_end_date) LIMIT 1";
            $month_model = \bc\models\transaction\BcTransactionMasterMonth::findBySql($sql)->one();
            $month_start_date = $month_model->month_start_date;
            $month_end_date = $month_model->month_end_date;
            $month_id = $month_model->id;
            $bc_transaction_start_date_model = BcTransaction::find()->where(['bc_application_id' => $transaction->bc_application_id])->orderBy('transaction_date ASC')->limit(1)->one();
            $no_of_working_days = BcTransaction::find()->select(['bc_application_id', 'transaction_amount'])->where(['bc_application_id' => $transaction->bc_application_id])->andFilterWhere(['>=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $month_start_date])->andFilterWhere(['<=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $month_end_date])->groupBy('transaction_date')->count();
            $t_amount = BcTransaction::find()->select(['bc_application_id', 'transaction_amount'])->where(['bc_application_id' => $transaction->bc_application_id])->andFilterWhere(['>=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $month_start_date])->andFilterWhere(['<=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $month_end_date])->sum('transaction_amount');
            $t_com_amount = BcTransaction::find()->select(['bc_application_id', 'commission_amount'])->where(['bc_application_id' => $transaction->bc_application_id])->andFilterWhere(['>=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $month_start_date])->andFilterWhere(['<=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $month_end_date])->sum('commission_amount');
            $t_number = BcTransaction::find()->select(['id', 'bc_application_id'])->where(['bc_application_id' => $transaction->bc_application_id])->andFilterWhere(['>=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $month_start_date])->andFilterWhere(['<=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $month_end_date])->count();
            $big_ticket_count = BcTransaction::find()->select(['bc_application_id', 'ticket'])->where(['bc_application_id' => $transaction->bc_application_id, 'ticket' => 2])->andFilterWhere(['>=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $month_start_date])->andFilterWhere(['<=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $month_end_date])->count();
            $small_ticket_count = BcTransaction::find()->select(['bc_application_id', 'ticket'])->where(['bc_application_id' => $transaction->bc_application_id, 'ticket' => 1])->andFilterWhere(['>=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $month_start_date])->andFilterWhere(['<=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $month_end_date])->count();
            if ($no_of_working_days) {
                $new_bc = BcTransaction::find()->select(['id', 'bc_application_id', 'transaction_date'])->where(['bc_application_id' => $transaction->bc_application_id])->andFilterWhere(['<', BcTransaction::getTableSchema()->fullName . '.transaction_date', $month_start_date])->all();
                $monthly_bc_tranasaction = \bc\models\transaction\BcTransactionMonthlyReport::find()->where(['bc_application_id' => $transaction->bc_application_id, 'month_id' => $month_model->id])->one();
                if (empty($monthly_bc_tranasaction)) {
                    $monthly_bc_tranasaction = new \bc\models\transaction\BcTransactionMonthlyReport();
                }

                $monthly_bc_tranasaction->bc_application_id = $bc_transaction_start_date_model->bc_application_id;
                $monthly_bc_tranasaction->user_id = $bc_transaction_start_date_model->user_id;
                $monthly_bc_tranasaction->bankidbc = $bc_transaction_start_date_model->bankidbc;
                $monthly_bc_tranasaction->district_code = $bc_transaction_start_date_model->district_code;
                $monthly_bc_tranasaction->block_code = $bc_transaction_start_date_model->block_code;
                $monthly_bc_tranasaction->gram_panchayat_code = $bc_transaction_start_date_model->gram_panchayat_code;
                $monthly_bc_tranasaction->master_partner_bank_id = $bc_transaction_start_date_model->master_partner_bank_id;
                $monthly_bc_tranasaction->month_id = $month_model->id;
                $monthly_bc_tranasaction->month = $month_start_date;
                $monthly_bc_tranasaction->month_start_date = $month_start_date;
                $monthly_bc_tranasaction->month_end_date = $month_end_date;
                $monthly_bc_tranasaction->no_of_days = \DateTime::createFromFormat("Y-m-d", $month_end_date)->format("t");
                $monthly_bc_tranasaction->no_of_working_days = $no_of_working_days;
                $monthly_bc_tranasaction->no_of_not_working_days = ($monthly_bc_tranasaction->no_of_days - $no_of_working_days);
                $monthly_bc_tranasaction->start_date = $bc_transaction_start_date_model->transaction_date;
                $monthly_bc_tranasaction->big_ticket_count = $big_ticket_count;
                $monthly_bc_tranasaction->small_ticket_count = $small_ticket_count;
                $monthly_bc_tranasaction->no_of_transaction = $t_number;
                $monthly_bc_tranasaction->transaction_amount = $t_amount;
                $monthly_bc_tranasaction->commission_amount = $t_com_amount;
                $monthly_bc_tranasaction->zero_transaction = BcTransaction::find()->select(['id', 'bc_application_id'])->where(['bc_application_id' => $transaction->bc_application_id, 'transaction_amount' => 0])->andFilterWhere(['>=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $month_start_date])->andFilterWhere(['<=', BcTransaction::getTableSchema()->fullName . '.transaction_date', $month_end_date])->count();
                $monthly_bc_tranasaction->no_of_transaction_actual = ($monthly_bc_tranasaction->no_of_transaction - $monthly_bc_tranasaction->zero_transaction);
                $monthly_bc_tranasaction->bc_category = $this->getbccategory($monthly_bc_tranasaction->no_of_transaction_actual);
                if (empty($new_bc)) {
                    $monthly_bc_tranasaction->is_new = 1;
                }
                if ($monthly_bc_tranasaction->validate()) {
                    $monthly_bc_tranasaction->save();
                }
            } else {
                $monthly_bc_tranasaction = \bc\models\transaction\BcTransactionMonthlyReport::find()->where(['bc_application_id' => $transaction->bc_application_id, 'month_id' => $month_model->id])->one();
                if ($monthly_bc_tranasaction != null) {
                    $monthly_bc_tranasaction->delete();
                }
            }
        }
    }

    public function updatebc($transaction) {
        if ($transaction->bc_application_id) {
            $t_amount = BcTransaction::find()->select(['bc_application_id', 'transaction_amount'])->where(['bc_application_id' => $transaction->bc_application_id])->sum('transaction_amount');
            $t_com_amount = BcTransaction::find()->select(['bc_application_id', 'commission_amount'])->where(['bc_application_id' => $transaction->bc_application_id])->sum('commission_amount');
            $t_number = BcTransaction::find()->select(['id', 'bc_application_id'])->where(['bc_application_id' => $transaction->bc_application_id])->count();
            $big_ticket_count = BcTransaction::find()->select(['bc_application_id', 'ticket'])->where(['bc_application_id' => $transaction->bc_application_id, 'ticket' => 2])->count();
            $small_ticket_count = BcTransaction::find()->select(['bc_application_id', 'ticket'])->where(['bc_application_id' => $transaction->bc_application_id, 'ticket' => 1])->count();
            $no_of_working_days = BcTransaction::find()->select(['bc_application_id', 'transaction_date'])->where(['bc_application_id' => $transaction->bc_application_id])->groupBy('transaction_date')->count();
            $bc_transaction_start_date_model = BcTransaction::find()->where(['bc_application_id' => $transaction->bc_application_id])->orderBy('transaction_date ASC')->limit(1)->one();
            if ($bc_transaction_start_date_model != null) {
                $now = time(); // or your date as well
                $start_date = strtotime((string) $bc_transaction_start_date_model->transaction_date);
                $datediff = $now - $start_date;
                $no_of_days = round($datediff / (60 * 60 * 24));
                $no_of_not_working_days = ($no_of_days - $no_of_working_days);
                $overall_bc_tranasaction = \bc\models\transaction\BcTransactionOverallReport::find()->where(['bc_application_id' => $transaction->bc_application_id])->one();
                if (empty($overall_bc_tranasaction)) {
                    $overall_bc_tranasaction = new \bc\models\transaction\BcTransactionOverallReport();
                }
                $overall_bc_tranasaction->bc_application_id = $transaction->bc_application_id;
                $overall_bc_tranasaction->user_id = $transaction->user_id;
                $overall_bc_tranasaction->bankidbc = $transaction->bankidbc;
                $overall_bc_tranasaction->district_code = $transaction->district_code;
                $overall_bc_tranasaction->block_code = $transaction->block_code;
                $overall_bc_tranasaction->gram_panchayat_code = $transaction->gram_panchayat_code;
                $overall_bc_tranasaction->master_partner_bank_id = $transaction->master_partner_bank_id;
                $overall_bc_tranasaction->start_date = $bc_transaction_start_date_model->transaction_date;
                $overall_bc_tranasaction->no_of_days = $no_of_days;
                $overall_bc_tranasaction->no_of_working_days = $no_of_working_days;
                $overall_bc_tranasaction->no_of_not_working_days = $no_of_not_working_days;
                $overall_bc_tranasaction->big_ticket_count = $big_ticket_count;
                $overall_bc_tranasaction->small_ticket_count = $small_ticket_count;
                $overall_bc_tranasaction->no_of_transaction = $t_number;
                $overall_bc_tranasaction->transaction_amount = $t_amount;
                $overall_bc_tranasaction->commission_amount = $t_com_amount;
                $overall_bc_tranasaction->zero_transaction = BcTransaction::find()->select(['id', 'bc_application_id'])->where(['bc_application_id' => $transaction->bc_application_id, 'transaction_amount' => 0])->count();
                if ($overall_bc_tranasaction->validate() and $t_number) {
                    $overall_bc_tranasaction->save();
                } else {
                    if ($overall_bc_tranasaction != null) {
                        $overall_bc_tranasaction->delete();
                    }
                }
            }
        } else {
            
        }
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

}

?>