<?php

namespace bc\models\report;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class Transaction {

    const TYPE_BC_BANK = 1;
    const TYPE_BC_SHG_BANK = 2;

    public $data = [
        'no_of_bc' => 0,
        'no_of_transaction' => 0,
        'txn_amount' => 0,
        'com_amount' => 0,
    ];

    public function __construct($basic_properties = []) {
        
    }

    public function getData() {
        
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
            }
        } catch (\Exception $ex) {
            print_r($ex);
        }
    }

}
