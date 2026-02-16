<?php

namespace console\controllers;

use Yii;
use yii\helpers\Json;
use yii\console\Controller;
use common\helpers\FileHelpers;

class FileController extends Controller {

    public $start_date;
    public $end_date;
    public $limit;

    public function beforeAction($action) {
        $this->start_date = date("Y-m-d", strtotime("-4 day"));
        $this->end_date = date("Y-m-d", strtotime("+1 day"));
        $this->limit = 5000;
        return parent::beforeAction($action);
    }

    public function actionNight() {
        $my_current_ip = exec("ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'");
        if ($my_current_ip == '172.31.34.165') {
            echo "Daily File Cron Strat Time : " . date('Y-m-d H:i:s');
            \Yii::$app->runAction('file/ultrapoor');
            \Yii::$app->runAction('file/coponline');
            \Yii::$app->runAction('file/copclffile');
            \Yii::$app->runAction('file/copshgfile');
            \Yii::$app->runAction('file/copvofile');
            \Yii::$app->runAction('file/copmemberfile');
            echo "Daily File Cron End Time : " . date('Y-m-d H:i:s');
        }
    }

    public function actionCopclffile() {
        $my_current_ip = exec("ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'");
        echo $my_current_ip;
        
        if ($my_current_ip == '172.31.34.165') {
            echo "Daily CLF File Cron Strat Time : " . date('Y-m-d H:i:s') . PHP_EOL;
            $base_path = \Yii::$app->params['datapath'] . 'cbo/clf';
            $rii = $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($base_path));
            $files = array();
            foreach ($rii as $file) {
                if ($file->isDir()) {
                    continue;
                }
                $files[] = $file->getPathname();
            }

            if (isset($files)) {
                echo count($files) . PHP_EOL;
                $srl = 0;
                foreach ($files as $lfile) {
                    $clf = pathinfo($lfile);
                    $file = new FileHelpers();
                    $file->file_path = $clf['dirname'];
                    $file->file_name = $clf['basename'];
                    if ($file->check()) {
                        unlink($lfile);
                    } else {
                        $file->upload();
                    }
                    $srl++;
                    if ($srl == $this->limit) {
                        echo "Daily CLF File Cron End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
                        exit;
                    }
                }
            }
            echo "Daily CLF File Cron End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        }
    }

    public function actionCopshgfile() {
        $my_current_ip = exec("ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'");
        if ($my_current_ip == '172.31.34.165') {
            echo "Daily SHG File Cron Strat Time : " . date('Y-m-d H:i:s') . PHP_EOL;
            $base_path = \Yii::$app->params['datapath'] . 'cbo/shg';
            $rii = $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($base_path));
            $files = array();
            foreach ($rii as $file) {
                if ($file->isDir()) {
                    continue;
                }
                $files[] = $file->getPathname();
            }
            if (isset($files)) {
                echo count($files) . PHP_EOL;
                $srl = 0;
                foreach ($files as $lfile) {
                    $shg = pathinfo($lfile);
                    $file = new FileHelpers();
                    $file->file_path = $shg['dirname'];
                    $file->file_name = $shg['basename'];
                    if ($file->check()) {
                        unlink($lfile);
                    } else {
                        echo $srl . ' ' . $file->file_name . ' file not exist' . PHP_EOL;
                        $file->upload();
                    }
                    $srl++;
                    if ($srl == $this->limit) {
                        echo "Daily SHG File Cron End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
                        exit;
                    }
                }
//            }
                echo "Daily SHG File Cron End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
            }
        }
    }

    public function actionCopvofile() {
        $my_current_ip = exec("ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'");
        if ($my_current_ip == '172.31.34.165') {
            echo "Daily VO File Cron Strat Time : " . date('Y-m-d H:i:s') . PHP_EOL;
            $base_path = \Yii::$app->params['datapath'] . 'cbo/vo';
            $rii = $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($base_path));
            $files = array();
            if (isset($files)) {
                echo count($files) . PHP_EOL;
                $srl = 0;
                foreach ($files as $lfile) {
                    $vo = pathinfo($lfile);
                    $file = new FileHelpers();
                    $file->file_path = $vo['dirname'];
                    $file->file_name = $vo['basename'];
                    if ($file->check()) {
                        unlink($lfile);
                    } else {
                        echo $srl . ' ' . $file->file_name . ' file not exist' . PHP_EOL;
                        $file->upload();
                    }
                    $srl++;
                    if ($srl == $this->limit) {
                        echo "Daily VO File Cron End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
                        exit;
                    }
                }
            }
            echo "Daily VO File Cron End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        }
    }

    public function actionCopmemberfile() {
        $my_current_ip = exec("ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'");
//        echo $my_current_ip;
        if ($my_current_ip == '172.31.34.165') {
            echo "Daily Member File Cron Strat Time : " . date('Y-m-d H:i:s') . PHP_EOL;
            $base_path = \Yii::$app->params['datapath'] . 'cbo/member';
            $rii = $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($base_path));
            $files = array();
            foreach ($rii as $file) {
                if ($file->isDir()) {
                    continue;
                }
                $files[] = $file->getPathname();
            }
            if (isset($files)) {
                echo count($files) . PHP_EOL;
                $srl = 0;
                foreach ($files as $lfile) {
                    $member = pathinfo($lfile);
                    $file = new FileHelpers();
                    $file->file_path = $member['dirname'];
                    $file->file_name = $member['basename'];
                    if ($file->check()) {
                        unlink($lfile);
                    } else {
//                        echo $srl . ' ' . $file->file_name . ' file not exist' . PHP_EOL;
                        $file->upload();
                    }
                    $srl++;
                    if ($srl == $this->limit) {
                        echo "Daily Member File Cron End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
                        exit;
                    }
//                }
                }
                echo "Daily Member File Cron End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
            }
        }
    }
    public function actionCoponline() {
        $my_current_ip = exec("ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'");
//        echo $my_current_ip;
        if ($my_current_ip == '172.31.34.165') {
            echo "Daily Member File Cron Strat Time : " . date('Y-m-d H:i:s') . PHP_EOL;
            $base_path = \Yii::$app->params['datapath'] . 'online';
            $rii = $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($base_path));
            $files = array();
            foreach ($rii as $file) {
                if ($file->isDir()) {
                    continue;
                }
                $files[] = $file->getPathname();
            }
            if (isset($files)) {
                echo count($files) . PHP_EOL;
                $srl = 0;
                foreach ($files as $lfile) {
                    $member = pathinfo($lfile);
                    $file = new FileHelpers();
                    $file->file_path = $member['dirname'];
                    $file->file_name = $member['basename'];
                    if ($file->check()) {
                        unlink($lfile);
                    } else {
//                        echo $srl . ' ' . $file->file_name . ' file not exist' . PHP_EOL;
                        $file->upload();
                    }
                    $srl++;
                    if ($srl == $this->limit) {
                        echo "Daily Member File Cron End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
                        exit;
                    }
//                }
                }
                echo "Daily Member File Cron End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
            }
        }
    }
    public function actionUltrapoor() {
        $my_current_ip = Yii::$app->params['rishta_sever_ip'];//exec("ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'");
         echo $my_current_ip;
        if ($my_current_ip == '172.31.34.165') {
            echo "Daily Ultra poor File Cron Strat Time : " . date('Y-m-d H:i:s') . PHP_EOL;
            $base_path = \Yii::$app->params['datapath'] . 'nfsasurveyphoto';
            $rii = $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($base_path));
            $files = array();
            foreach ($rii as $file) {
                if ($file->isDir()) {
                    continue;
                }
                $files[] = $file->getPathname();
            }
            if (isset($files)) {
                echo count($files) . PHP_EOL;               
                //exit();
                $srl = 0;
                foreach ($files as $lfile) {
                    $member = pathinfo($lfile);
                    $file = new FileHelpers();
                    $file->file_path = $member['dirname'];
                    $file->file_name = $member['basename'];
                    if ($file->check()) {
                        unlink($lfile);
                    } else {
//                        echo $srl . ' ' . $file->file_name . ' file not exist' . PHP_EOL;
                        $file->upload();
                    }
                    $srl++;
                    if ($srl == $this->limit) {
                        echo "Daily Ultra poor File Cron End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
                        exit;
                    }
//                }
                }
                echo "Daily Ultra poor File Cron End Time : " . date('Y-m-d H:i:s') . PHP_EOL;
            }
        }
    }
    private function RemoveEmptySubFolders($path) {
        $my_current_ip = exec("ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'");
        if ($my_current_ip == '172.31.43.178' or $my_current_ip == '172.31.34.161') {
            $empty = true;
            foreach (glob($path . DIRECTORY_SEPARATOR . "*") as $file) {
                $empty &= is_dir($file) && $this->RemoveEmptySubFolders($file);
            }
            return $empty && (is_readable($path) && count(scandir($path)) == 2) && rmdir($path);
        }
    }

    public function actionUploadbcappfiles3() {
        $aws = \Yii::$app->get('aws');
        $base_path = Yii::$app->params['path'] . '/www-bc-data';
        $rii = $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($base_path));
        $files = array();
        foreach ($rii as $file) {
            if ($file->isDir()) {
                continue;
            }
            $files[] = $file->getPathname();
        }
        $srl = 0;
        echo "Daily BC Selection File Cron Start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        echo count($files);
        if (isset($files)) {
            foreach ($files as $afile) {
                $bcfile = pathinfo($afile);
                $pieces = explode("/home/upsrlm/", $bcfile['dirname']);
                $aws = \Yii::$app->get('aws');
                $client = $aws->getS3Client();
                try {
                    $response = $client->putObject([
                        'Bucket' => $aws->bucket,
                        'Key' => $pieces[1] . '/' . $bcfile['basename'],
                        'Body' => fopen($bcfile['dirname'] . '/' . $bcfile['basename'], 'r'),
                    ]);
                    if (isset($response['ObjectURL'])) {
                        if (isset($bcfile['extension'])) {
                            if (!in_array($bcfile['extension'], ['csv', 'zip'])) {
//                                unlink($bcfile['dirname'] . '/' . $bcfile['basename']);
                            }
                        }
                    }
                } catch (\Aws\S3\Exception\S3Exception $e) {
                    echo "There was an error uploading the file.\n";
                    echo $e->getMessage();
                }

                if ($srl == $this->limit) {
                    echo "Daily BC Selection File Cron Start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
                    exit;
                }
                $srl++;
            }
        }
    }

    public function actionUploadcbofiles3() {
        $aws = \Yii::$app->get('aws');
        $base_path = Yii::$app->params['path'] . '/www-bc-data';
        $rii = $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($base_path));
        $files = array();
        foreach ($rii as $file) {
            if ($file->isDir()) {
                continue;
            }
            $files[] = $file->getPathname();
        }
        $srl = 0;
        echo "Daily CBO File Cron Start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
        echo count($files);
        if (isset($files)) {
            foreach ($files as $afile) {
                $cbofile = pathinfo($afile);
                $pieces = explode("/home/upsrlm/", $cbofile['dirname']);
                $aws = \Yii::$app->get('aws');
                $client = $aws->getS3Client();
                try {
                    $response = $client->putObject([
                        'Bucket' => $aws->bucket,
                        'Key' => $pieces[1] . '/' . $cbofile['basename'],
                        'Body' => fopen($cbofile['dirname'] . '/' . $cbofile['basename'], 'r'),
                    ]);
                    if (isset($response['ObjectURL'])) {
                        if (isset($cbofile['extension'])) {
                            if (!in_array($cbofile['extension'], ['csv', 'zip'])) {
//                                unlink($cbofile['dirname'] . '/' . $cbofile['basename']);
                            }
                        }
                    }
                } catch (\Aws\S3\Exception\S3Exception $e) {
                    echo "There was an error uploading the file.\n";
                    echo $e->getMessage();
                }

                if ($srl == $this->limit) {
                    echo "Daily BC Selection File Cron Start Time : " . date('Y-m-d H:i:s') . PHP_EOL;
                    exit;
                }
                $srl++;
            }
        }
    }

}
