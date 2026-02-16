<?php

namespace bc\models\transaction\report;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use common\models\User;
use common\models\base\GenralModel;
use common\models\master\MasterRole;
use bc\models\master\MasterPartnerBank;
use bc\models\transaction\BcTransactionFiles;
use bc\models\transaction\BcTransaction;
use bc\models\transaction\BcTransactionTable1;
use bc\models\transaction\BcTransactionTable2;
use bc\models\transaction\BcTransactionTable3;
use bc\models\transaction\BcTransactionTable4;
use bc\models\transaction\BcTransactionTable5;
use bc\models\transaction\BcTransactionTable6;
use bc\modules\selection\models\SrlmBcApplication;

ini_set('memory_limit', '1024M');
ini_set('max_execution_time', 500);

/**
 * Report for transaction
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class Report extends Model {

    public $month;
    public $start_date;
    public $end_date;
    public $month_option = [];
    public $months_date = [];

    public function __construct($params) {
        $this->load($params);
        if (!$this->month) {
            $date = new \DateTime('now');
            $date->modify('first day of this month');
            $this->start_date = $date->format('Y-m-d');
            $this->month = $this->start_date;
        }
        $this->end_date = \DateTime::createFromFormat("Y-m-d", $this->month)->format("Y-m-t");
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['month', 'start_date', 'end_date'], 'safe'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels() {
        return [
            'month' => 'Month',
        ];
    }

    public function monthly($params, $user_model) {

        $this->load($params);
        $this->start_date = $this->month;
        $this->end_date = \DateTime::createFromFormat("Y-m-d", $this->month)->format("Y-m-t");
        $this->months_date = $this->getDatesFromRange($this->start_date, $this->end_date);
        
//        $this->months_date = usort($this->months_date, call_user_func(array($this, 'date_sort')));
        $array = [];
        foreach ($this->months_date as $date) {
            if (strtotime($date) <= strtotime(date('Y-m-d'))) {
                $pb1 = BcTransactionFiles::find()->select('date(upload_datetime) as upload_datetime')
                                ->where(['master_partner_bank_id' => 1])
                                ->andWhere(['=', 'date(upload_datetime)', $date])->count();

                $pb2 = BcTransactionFiles::find()->select('date(upload_datetime) as upload_datetime')
                                ->where(['master_partner_bank_id' => 2])
                                ->andWhere(['=', 'date(upload_datetime)', $date])->count();
                $pb3 = BcTransactionFiles::find()->select('date(upload_datetime) as upload_datetime')
                                ->where(['master_partner_bank_id' => 3])
                                ->andWhere(['=', 'date(upload_datetime)', $date])->count();
                $pb4 = BcTransactionFiles::find()->select('date(upload_datetime) as upload_datetime')
                                ->where(['master_partner_bank_id' => 4])
                                ->andWhere(['=', 'date(upload_datetime)', $date])->count();
                $pb5 = BcTransactionFiles::find()->select('date(upload_datetime) as upload_datetime')
                                ->where(['master_partner_bank_id' => 5])
                                ->andWhere(['=', 'date(upload_datetime)', $date])->count();
                $pb6 = BcTransactionFiles::find()->select('date(upload_datetime) as upload_datetime')
                                ->where(['master_partner_bank_id' => 6])
                                ->andWhere(['=', 'date(upload_datetime)', $date])->count();
                $pb7 = BcTransactionFiles::find()->select('date(upload_datetime) as upload_datetime')
                                ->where(['master_partner_bank_id' => 7])
                                ->andWhere(['=', 'date(upload_datetime)', $date])->count();

                $temp = [$date, $pb1 ? 'Yes' : '', $pb2 ? 'Yes' : '', $pb3 ? 'Yes' : '', $pb4 ? 'Yes' : '', $pb5 ? 'Yes' : '', $pb6 ? 'Yes' : '', $pb7 ? 'Yes' : ''];
                array_push($array, $temp);
            }
        }

        return $array;
    }

    public function monthoption($params, $user_model = null) {
        $sql = 'SELECT DATE_FORMAT(upload_datetime, "%Y-%m-01") as t_date from bc_transaction_files';
        if (in_array($user_model->role, [MasterRole::ROLE_BANK_DISTRICT_UNIT, MasterRole::ROLE_BANK_FI_PARTNER_DISTRICT_NODAL,MasterRole::ROLE_CORPORATE_BCS])) {
            $profile = \common\models\UserProfile::findOne(['user_id' => $user_model->id]);
            $sql .= ' where master_partner_bank_id=' . $profile->master_partner_bank_id;
        }
        $sql .= ' group by t_date order by t_date asc';
        $res = \Yii::$app->getModule('transaction')->bctransactiondump->createCommand($sql)->queryAll();
        $array = \yii\helpers\ArrayHelper::getColumn($res, 't_date');
        $arrays = [];
        foreach ($array as $a) {
            $arrays[$a] = \Yii::$app->formatter->asDatetime($a, "php:M-Y");
        }
        return $arrays;
    }

    public function getDatesFromRange($start, $end, $format = 'Y-m-d') {

        // Declare an empty array
        $array = array();

        // Variable that store the date interval
        // of period 1 day
        $interval = new \DateInterval('P1D');

        $realEnd = new \DateTime($end);
        $realEnd->add($interval);

        $period = new \DatePeriod(new \DateTime($start), $interval, $realEnd);

        // Use loop to store date into array
        foreach ($period as $date) {
            $array[] = $date->format($format);
        }

        // Return the array elements
        return $array;
    }

    public function date_sort($a, $b) {
        return strtotime($a) - strtotime($b);
    }

}
