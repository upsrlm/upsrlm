<?php

namespace bc\models\report;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class Graph {

    const TYPE_BC_BANK = 1;
    const TYPE_BC_SHG_BANK = 2;
    const TYPE_BC_SHG_FUND = 3;
    const TYPE_BC_HANDHELDMACHINE = 4;
    const TYPE_BC_PAN = 5;
    const TYPE_NO_OF_TRANSACTION = 6;
    const TYPE_TRANSACTION_COM = 7;
    const TYPE_NO_OF_TRANSACTION_COM = 8;

    public $date_from;
    public $date_to;

    public function __construct($basic_properties = []) {
        
    }

    public function getResponce($type = TYPE_BC_BANK) {
        try {


            if ($type == self::TYPE_BC_BANK) {
                $sql = "SELECT (UNIX_TIMESTAMP(date(time))) AS `0`, count(id) AS `1` FROM `srlm_bc_selection_api_log` ";
                $sql .= " where request_url = 'bcselection/user/bcbankaccountsave' and http_response_code=200 GROUP BY UNIX_TIMESTAMP(DATE(time))";

                $responces = \Yii::$app->dbbc->createCommand($sql)->queryAll();
                if (count($responces)) {
                    for ($i = 0; $i < count($responces); $i++) {
                        $responces[$i][0] = $responces[$i][0] * 1000;
                        settype(($responces[$i][0]), "integer");
                        settype($responces[$i][count($responces[$i]) - 1], "integer");
                    }
                    return $responces;
                }
            } elseif ($type == self::TYPE_BC_SHG_BANK) {
                $sql = "SELECT (UNIX_TIMESTAMP(date(time))) AS `0`, count(id) AS `1` FROM `srlm_bc_selection_api_log` ";
                $sql .= " where request_url = 'bcselection/user/bcshgbankaccountsave' and http_response_code=200 GROUP BY UNIX_TIMESTAMP(DATE(time))";

                $responces = \Yii::$app->dbbc->createCommand($sql)->queryAll();
                if (count($responces)) {
                    for ($i = 0; $i < count($responces); $i++) {
                        $responces[$i][0] = $responces[$i][0] * 1000;
                        settype(($responces[$i][0]), "integer");
                        settype($responces[$i][count($responces[$i]) - 1], "integer");
                    }
                    return $responces;
                }
            } elseif ($type == self::TYPE_BC_SHG_FUND) {
                $sql = "SELECT (UNIX_TIMESTAMP(date(time))) AS `0`, count(id) AS `1` FROM `srlm_bc_selection_api_log` ";
                $sql .= " where request_url = 'bcselection/user/acknowledgesupportfunds' and http_response_code=200 GROUP BY UNIX_TIMESTAMP(DATE(time))";

                $responces = \Yii::$app->dbbc->createCommand($sql)->queryAll();
                if (count($responces)) {
                    for ($i = 0; $i < count($responces); $i++) {
                        $responces[$i][0] = $responces[$i][0] * 1000;
                        settype(($responces[$i][0]), "integer");
                        settype($responces[$i][count($responces[$i]) - 1], "integer");
                    }
                    return $responces;
                }
            } elseif ($type == self::TYPE_BC_HANDHELDMACHINE) {
                $sql = "SELECT (UNIX_TIMESTAMP(date(time))) AS `0`, count(id) AS `1` FROM `srlm_bc_selection_api_log` ";
                $sql .= " where request_url = 'bcselection/user/acknowledgehandheldmachine' and http_response_code=200 GROUP BY UNIX_TIMESTAMP(DATE(time))";

                $responces = \Yii::$app->dbbc->createCommand($sql)->queryAll();
                if (count($responces)) {
                    for ($i = 0; $i < count($responces); $i++) {
                        $responces[$i][0] = $responces[$i][0] * 1000;
                        settype(($responces[$i][0]), "integer");
                        settype($responces[$i][count($responces[$i]) - 1], "integer");
                    }
                    return $responces;
                }
            } elseif ($type == self::TYPE_BC_PAN) {
                $sql = "SELECT (UNIX_TIMESTAMP(date(time))) AS `0`, count(id) AS `1` FROM `srlm_bc_selection_api_log` ";
                $sql .= " where request_url = 'bcselection/user/uploadpan' and http_response_code=200 GROUP BY UNIX_TIMESTAMP(DATE(time))";

                $responces = \Yii::$app->dbbc->createCommand($sql)->queryAll();
                if (count($responces)) {
                    for ($i = 0; $i < count($responces); $i++) {
                        $responces[$i][0] = $responces[$i][0] * 1000;
                        settype(($responces[$i][0]), "integer");
                        settype($responces[$i][count($responces[$i]) - 1], "integer");
                    }
                    return $responces;
                }
            }
        } catch (\Exception $ex) {
            print_r($ex);
        }
    }

    public function getTimetransactionbc($type = self::TYPE_NO_OF_TRANSACTION, $search) {
        try {


            if ($type == self::TYPE_NO_OF_TRANSACTION) {
                $sql = "SELECT (UNIX_TIMESTAMP(date(date))) AS `0`, sum(no_of_transaction) AS `1` FROM `bc_transaction_bc_summary_daily` ";
                $sql .= " where status = '1' ";
                if (isset($search->bc_application_id)) {
                    $sql .= " and bc_application_id =" . $search->bc_application_id;
                }
                if (isset($search->district_code)) {
                    $sql .= " and district_code =" . $search->district_code;
                }
                if (isset($search->block_code)) {
                    $sql .= " and block_code =" . $search->block_code;
                }
                if (isset($search->gram_panchayat_code)) {
                    $sql .= " and gram_panchayat_code =" . $search->gram_panchayat_code;
                }
                if (isset($search->master_partner_bank_id)) {
                    $sql .= " and master_partner_bank_id =" . $search->master_partner_bank_id;
                }
                if (isset($search->date_from)) {
                    $sql .= " and date >='" . $search->date_from . "'";
                }
                if (isset($search->date_to)) {
                    $sql .= " and date <='" . $search->date_to . "'";
                }
                $sql .= " GROUP BY UNIX_TIMESTAMP(DATE(date))";

                $responces = \Yii::$app->getModule('transaction')->bctransactionsummary->createCommand($sql)->queryAll();
                if (count($responces)) {
                    for ($i = 0; $i < count($responces); $i++) {
                        $responces[$i][0] = $responces[$i][0] * 1000;
                        settype(($responces[$i][0]), "integer");
                        settype($responces[$i][count($responces[$i]) - 1], "integer");
                    }
                    return $responces;
                } else {
                    
                }
            } elseif ($type == self::TYPE_TRANSACTION_COM) {
                $sql = "SELECT (UNIX_TIMESTAMP(date(date))) AS `0`, sum(commission_amount) AS `1` FROM `bc_transaction_bc_summary_daily` ";
                $sql .= " where status = '1' ";
                if (isset($search->bc_application_id)) {
                    $sql .= " and bc_application_id =" . $search->bc_application_id;
                }
                if (isset($search->district_code)) {
                    $sql .= " and district_code =" . $search->district_code;
                }
                if (isset($search->block_code)) {
                    $sql .= " and block_code =" . $search->block_code;
                }
                if (isset($search->gram_panchayat_code)) {
                    $sql .= " and gram_panchayat_code =" . $search->gram_panchayat_code;
                }
                if (isset($search->master_partner_bank_id)) {
                    $sql .= " and master_partner_bank_id =" . $search->master_partner_bank_id;
                }
                if (isset($search->date_from)) {
                    $sql .= " and date >='" . $search->date_from . "'";
                }
                if (isset($search->date_to)) {
                    $sql .= " and date <='" . $search->date_to . "'";
                }
                $sql .= " GROUP BY UNIX_TIMESTAMP(DATE(date))";
                $responces = \Yii::$app->getModule('transaction')->bctransactionsummary->createCommand($sql)->queryAll();
                if (count($responces)) {
                    for ($i = 0; $i < count($responces); $i++) {
                        $responces[$i][0] = $responces[$i][0] * 1000;
                        settype(($responces[$i][0]), "integer");
                        settype($responces[$i][count($responces[$i]) - 1], "integer");
                    }
                    return $responces;
                }
            } elseif ($type == self::TYPE_NO_OF_TRANSACTION_COM) {
                $sql = "SELECT (UNIX_TIMESTAMP(date(time))) AS `0`, count(id) AS `1` FROM `srlm_bc_selection_api_log` ";
                $sql .= " where request_url = 'bcselection/user/acknowledgesupportfunds' and http_response_code=200 GROUP BY UNIX_TIMESTAMP(DATE(time))";

                $responces = \Yii::$app->dbbc->createCommand($sql)->queryAll();
                if (count($responces)) {
                    for ($i = 0; $i < count($responces); $i++) {
                        $responces[$i][0] = $responces[$i][0] * 1000;
                        settype(($responces[$i][0]), "integer");
                        settype($responces[$i][count($responces[$i]) - 1], "integer");
                    }
                    return $responces;
                }
            } elseif ($type == self::TYPE_BC_HANDHELDMACHINE) {
                $sql = "SELECT (UNIX_TIMESTAMP(date(time))) AS `0`, count(id) AS `1` FROM `srlm_bc_selection_api_log` ";
                $sql .= " where request_url = 'bcselection/user/acknowledgehandheldmachine' and http_response_code=200 GROUP BY UNIX_TIMESTAMP(DATE(time))";

                $responces = \Yii::$app->dbbc->createCommand($sql)->queryAll();
                if (count($responces)) {
                    for ($i = 0; $i < count($responces); $i++) {
                        $responces[$i][0] = $responces[$i][0] * 1000;
                        settype(($responces[$i][0]), "integer");
                        settype($responces[$i][count($responces[$i]) - 1], "integer");
                    }
                    return $responces;
                }
            } elseif ($type == self::TYPE_BC_PAN) {
                $sql = "SELECT (UNIX_TIMESTAMP(date(time))) AS `0`, count(id) AS `1` FROM `srlm_bc_selection_api_log` ";
                $sql .= " where request_url = 'bcselection/user/uploadpan' and http_response_code=200 GROUP BY UNIX_TIMESTAMP(DATE(time))";

                $responces = \Yii::$app->dbbc->createCommand($sql)->queryAll();
                if (count($responces)) {
                    for ($i = 0; $i < count($responces); $i++) {
                        $responces[$i][0] = $responces[$i][0] * 1000;
                        settype(($responces[$i][0]), "integer");
                        settype($responces[$i][count($responces[$i]) - 1], "integer");
                    }
                    return $responces;
                }
            }
        } catch (\Exception $ex) {
            print_r($ex);
        }
    }

    public function getTrans($type = self::TYPE_NO_OF_TRANSACTION, $search) {
        try {
            $this->date_to = $search->date_to;
            $this->date_from = date("Y-m-d", strtotime($this->date_to . " -30 day"));
            $interval = new \DateInterval('P1D');

            $realEnd = new \DateTime($search->date_to);
            $realEnd->add($interval);
            $search->date_from = date("Y-m-d", strtotime($this->date_to . " -30 day"));
            $period = new \DatePeriod(new \DateTime($search->date_from), $interval, $realEnd);
            $array['category'] = [];
            $array['transaction'] = [];
            $array['commission'] = [];
            $array['txn'] = [];
            // Use loop to store date into array
            foreach ($period as $date) {
                array_push($array['category'], $date->format('Y-m-d'));

                $sql = "SELECT sum(no_of_transaction) AS no_of_transaction,sum(transaction_amount) AS transaction_amount,sum(commission_amount) AS commission_amount FROM `bc_transaction_bc_summary_daily` ";
                $sql .= " where status = '1' ";
                if (isset($search->bc_application_id)) {
                    $sql .= " and bc_application_id =" . $search->bc_application_id;
                }
                if (isset($search->district_code)) {
                    $sql .= " and district_code =" . $search->district_code;
                }
                if (isset($search->block_code)) {
                    $sql .= " and block_code =" . $search->block_code;
                }
                if (isset($search->gram_panchayat_code)) {
                    $sql .= " and gram_panchayat_code =" . $search->gram_panchayat_code;
                }
                if (isset($search->master_partner_bank_id)) {
                    $sql .= " and master_partner_bank_id =" . $search->master_partner_bank_id;
                }

                $sql .= " and date ='" . $date->format('Y-m-d') . "'";

                $sql .= " GROUP BY date";
                $responces = \Yii::$app->getModule('transaction')->bctransactionsummary->createCommand($sql)->queryAll();
                if (isset($responces) and $responces != null) {
                    array_push($array['transaction'], (int) $responces[0]['no_of_transaction']);
                    array_push($array['commission'], $responces[0]['commission_amount']);
                    array_push($array['txn'], $responces[0]['transaction_amount']);
                } else {
                    array_push($array['transaction'], 0);
                    array_push($array['commission'], 0);
                    array_push($array['txn'], 0);
                }
            }

            return $array;
        } catch (\Exception $ex) {
            print_r($ex);
        }
    }

    public function getTransmonthly($type = self::TYPE_NO_OF_TRANSACTION, $search) {
        try {
            $month_option = [];
            $maxdate = date('Y-m-d', strtotime('0 month'));
            $mindate = date('Y-m-d', strtotime('-5 month'));
            $start = new \DateTime($mindate);
            $start->modify('first day of this month');
            $end = new \DateTime($maxdate);
            $end->modify('first day of next month');
            $interval = \DateInterval::createFromDateString('1 month');
            $period = new \DatePeriod($start, $interval, $end);
            $array['category'] = [];
            $array['transaction'] = [];
            $array['commission'] = [];
            $array['txn'] = [];
            foreach ($period as $dt) {
                $temp = $dt->format("Y-m") . '-01';
                $month_option[$dt->format("Y-m") . '-01'] = date('F Y', strtotime($temp));
                array_push($array['category'], date('F Y', strtotime($temp)));

                $sql = "SELECT sum(no_of_transaction) AS no_of_transaction,sum(transaction_amount) AS transaction_amount,sum(commission_amount) AS commission_amount FROM `bc_transaction_bc_summary_monthly` ";
                $sql .= " where status > '-1' ";
                if (isset($search->bc_application_id)) {
                    $sql .= " and bc_application_id =" . $search->bc_application_id;
                }
                if (isset($search->district_code)) {
                    $sql .= " and district_code =" . $search->district_code;
                }
                if (isset($search->block_code)) {
                    $sql .= " and block_code =" . $search->block_code;
                }
                if (isset($search->gram_panchayat_code)) {
                    $sql .= " and gram_panchayat_code =" . $search->gram_panchayat_code;
                }
                if (isset($search->master_partner_bank_id)) {
                    $sql .= " and master_partner_bank_id =" . $search->master_partner_bank_id;
                }

                $sql .= " and month ='" . $dt->format("Y-m") . '-01' . "'";

                $sql .= " GROUP BY month";
                $responces = \Yii::$app->getModule('transaction')->bctransactionsummary->createCommand($sql)->queryAll();
                if (isset($responces) and $responces != null) {
                    array_push($array['transaction'], (int) $responces[0]['no_of_transaction']);
                    array_push($array['commission'], $responces[0]['commission_amount']);
                    array_push($array['txn'], $responces[0]['transaction_amount']);
                } else {
                    array_push($array['transaction'], 0);
                    array_push($array['commission'], 0);
                    array_push($array['txn'], 0);
                }
            }

            return $array;
        } catch (\Exception $ex) {
            print_r($ex);
        }
    }

    public function getBankparformanc($type = 1, $master_partner_bank_id) {
        try {


            if ($type == 1) {
                $sql = "SELECT (UNIX_TIMESTAMP(date(date))) AS `0`, sum(certified_bc) AS `1` FROM `partner_bank_pendency_timeline` ";
                if ($master_partner_bank_id) {
                    $sql .= " where master_partner_bank_id =" . $master_partner_bank_id;
                }
                $sql .= " GROUP BY UNIX_TIMESTAMP(DATE(date))";

                $responces = \Yii::$app->dbbc->createCommand($sql)->queryAll();
                if (count($responces)) {
                    for ($i = 0; $i < count($responces); $i++) {
                        $responces[$i][0] = $responces[$i][0] * 1000;
                        settype(($responces[$i][0]), "integer");
                        settype($responces[$i][count($responces[$i]) - 1], "integer");
                    }
                    return $responces;
                }
            } elseif ($type == 2) {
                $sql = "SELECT (UNIX_TIMESTAMP(date(date))) AS `0`, sum(bc_support_fund_shg_transfer) AS `1` FROM `partner_bank_pendency_timeline` ";

                if ($master_partner_bank_id) {
                    $sql .= " where master_partner_bank_id =" . $master_partner_bank_id;
                }

                $sql .= " GROUP BY UNIX_TIMESTAMP(DATE(date))";
                $responces = \Yii::$app->dbbc->createCommand($sql)->queryAll();
                if (count($responces)) {
                    for ($i = 0; $i < count($responces); $i++) {
                        $responces[$i][0] = $responces[$i][0] * 1000;
                        settype(($responces[$i][0]), "integer");
                        settype($responces[$i][count($responces[$i]) - 1], "integer");
                    }
                    return $responces;
                }
            } elseif ($type == 3) {
                $sql = "SELECT (UNIX_TIMESTAMP(date(date))) AS `0`, sum(handheld_machine_provided) AS `1` FROM `partner_bank_pendency_timeline` ";

               if ($master_partner_bank_id) {
                    $sql .= " where master_partner_bank_id =" . $master_partner_bank_id;
                }

                $sql .= " GROUP BY UNIX_TIMESTAMP(DATE(date))";
                $responces = \Yii::$app->dbbc->createCommand($sql)->queryAll();
                if (count($responces)) {
                    for ($i = 0; $i < count($responces); $i++) {
                        $responces[$i][0] = $responces[$i][0] * 1000;
                        settype(($responces[$i][0]), "integer");
                        settype($responces[$i][count($responces[$i]) - 1], "integer");
                    }
                    return $responces;
                }
            } elseif ($type == 4) {
                $sql = "SELECT (UNIX_TIMESTAMP(date(date))) AS `0`, sum(operational) AS `1` FROM `partner_bank_pendency_timeline` ";

                if ($master_partner_bank_id) {
                    $sql .= " where master_partner_bank_id =" . $master_partner_bank_id;
                }

                $sql .= " GROUP BY UNIX_TIMESTAMP(DATE(date))";
                $responces = \Yii::$app->dbbc->createCommand($sql)->queryAll();
                if (count($responces)) {
                    for ($i = 0; $i < count($responces); $i++) {
                        $responces[$i][0] = $responces[$i][0] * 1000;
                        settype(($responces[$i][0]), "integer");
                        settype($responces[$i][count($responces[$i]) - 1], "integer");
                    }
                    return $responces;
                }
            } elseif ($type == 5) {
                $sql = "SELECT (UNIX_TIMESTAMP(date(date))) AS `0`, sum(onboard_bc) AS `1` FROM `partner_bank_pendency_timeline` ";

                if ($master_partner_bank_id) {
                    $sql .= " where master_partner_bank_id =" . $master_partner_bank_id;
                }

                $sql .= " GROUP BY UNIX_TIMESTAMP(DATE(date))";
                $responces = \Yii::$app->dbbc->createCommand($sql)->queryAll();
                if (count($responces)) {
                    for ($i = 0; $i < count($responces); $i++) {
                        $responces[$i][0] = $responces[$i][0] * 1000;
                        settype(($responces[$i][0]), "integer");
                        settype($responces[$i][count($responces[$i]) - 1], "integer");
                    }
                    return $responces;
                }
            }
        } catch (\Exception $ex) {
            print_r($ex);
        }
    }
}
