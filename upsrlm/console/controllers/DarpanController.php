<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use yii\db\Query;
use yii\base\Model;
use common\helpers\DarpanHelper;
use bc\models\BcGovermentReportBlock;
use bc\models\FootPrintLocation;

/**
 * Main Controller for YII Console
 */
class DarpanController extends Controller {
    // /**
    //  * Console Working Check
    //  *
    //  * @return void
    //  */
    // public function actionIndex()
    // {
    //     // $this->sendmail();
    //     if ($this->getdarpan()) {
    //         echo 'dapan Cron Done';
    //     } else {
    //         echo 'dapan Cron Not Done';
    //     }
    // }
    // /**
    //  * Credit Leave into Employee Account for this Month
    //  *
    //  * @return void
    //  */
    // protected function getdarpan()
    // {
    //     // $darpan = DarpanHelper::verifydata();
    //     $darpan = DarpanHelper::generateJson_Click();
    //     // $darpan = DarpanHelper::pushdata();
    //     echo "<pre>";
    //     print_r($darpan);
    //     die();
    // }

    /**
     * Console Working Check
     *
     * @return void
     */
    public function actionData() {
        echo "start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        $darpan = DarpanHelper::generateJson_Click();
        echo json_encode($darpan);

        \Yii::$app->runAction('darpan/push');

        echo "End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        die('done');
    }

    public function actionPush() {

        $govs = BcGovermentReportBlock::find()->where(['is_pushed' => 0])->orderBy('date')->groupBy('date')->asArray()->all();

        foreach ($govs as $gov) {

            $darpan = DarpanHelper::pushdata($gov);
            // $darpan = DarpanHelper::generateJson_Click();
            //    echo json_encode($darpan);
            if ($darpan[0]['Status'] == 1 and $darpan[0]['Message'] == '1#KPI Data Successfully Ported.') {
                // \Yii::$app->db->createCommand()
                // ->update('bc_goverment_report_block', ['is_pushed'=>1,'push_datetime'=>date('Y-m-d H:i:s')], 'date = '.$gov['date'].'')
                // ->execute();
                BcGovermentReportBlock::updateAll(['is_pushed' => 1, 'push_datetime' => date('Y-m-d H:i:s')],
                        'date ="' . $gov['date'] . '"'
                );
            }
            // echo "<pre>";clear
            echo $gov['id'];
            print_r($darpan);
        }

        die("done");
    }

    public function actionTestdata() {
        $block = BcGovermentReportBlock::find()->groupby('block_code')->asArray()->all();
        $array_blocks = array_column($block, 'block_code');
        // print_r($array_blocks);
        // echo "\r\n";
        // echo "\r\n";

        $blockdate = BcGovermentReportBlock::find()->groupby('date')->orderBy('date')->asArray()->all();
        $array_dates = array_column($blockdate, 'date');
        // print_r($array_dates);
        // echo "\r\n";
        // echo "\r\n";


        foreach ($array_blocks as $arr_block) {
            foreach ($array_dates as $arr_dates) {


                $curr_date = $arr_dates;
                $prev_date = date('Y-m-d', strtotime('-1 day', strtotime($arr_dates)));

                $prev_data = BcGovermentReportBlock::find()->where(['date' => $prev_date, 'block_code' => $arr_block])->one();
                $curr_data = BcGovermentReportBlock::find()->where(['date' => $curr_date, 'block_code' => $arr_block])->one();

                if (!empty($prev_data)) {
                    var_dump($curr_data->id . '------' . $curr_date . '-----' . $curr_data->operational . ' ----- ' . $prev_data->operational . '---' . $prev_date . '--------' . $arr_block);
                    if (($curr_data->operational < $prev_data->operational) || ($curr_data->trained_and_certified < $prev_data->trained_and_certified)) {
                        die('check id' . $curr_data->id . ' data is less than on compare');
                        exit;
                    }
                } else {
                    var_dump('first loop');
                }
            }
        }
    }

    public function actionCheckfootprint() {

        $foot = FootPrintLocation::find()->all();
        $i = 1;
        foreach ($foot as $foo) {
            $gov = BcGovermentReportBlock::find()->where(['state_code' => $foo->state_code, 'lgd_division_code' => $foo->division_code, 'district_code' => $foo->district_code, 'block_code' => $foo->block_code])->count();
            if ($gov < 100) {
                var_dump($foo->id . '---' . $foo->state_code . '---' . $foo->division_code . '---' . $foo->division_code . '---' . $foo->district_code);
            }
            echo "\r\n";
            echo "\r\n";
            echo $i;
            echo "\r\n";
            echo $foo->id . ' -- ' . $gov;
            $i++;
        }
    }
}
