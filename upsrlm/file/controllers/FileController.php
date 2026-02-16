<?php

namespace file\controllers;

use yii\web\Response;
use Yii;
use common\helpers\FileHelpers;

class FileController extends \yii\web\Controller {

    private $custom_response = [];
    public $file_path;
    public $file_name;
    public $file;

    public function beforeAction($event) {

        $this->custom_response['status'] = "0";
        $this->enableCsrfValidation = false;
        return parent::beforeAction($event);
    }

    public function actionUpload() {
        try {
            if (isset($_POST['file_path'])) {
                $this->file_path = $_POST['file_path'];
                $this->maikdirectory($this->file_path);
//                if (!is_dir($this->file_path)) {
//                    mkdir($this->file_path, 0777, true);
//                }
                if (isset($_FILES['file'])) {
                    $target_path = $this->file_path . '/' . basename($_FILES['file']['name']);
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
                        chmod($target_path, 0777);
                        $this->custom_response['status'] = 1;
                    }
                }
            }
//            $response = \Yii::$app->response;
//            $response->format = Response::FORMAT_JSON;
//            $response->data = $this->custom_response;
//            $response->send();
//            \Yii::$app->end();
//            return $this->custom_response;
        } catch (\Exception $ex) {
            
        }
    }

    public function actionStatus() {
        try {

            if (isset($_POST['file_path'])) {
                $this->file_path = $_POST['file_path'];
                
                if (isset($_POST['file_name'])) {
                    $this->file_name = $_POST['file_name'];
                    $target_path = $this->file_path . '/' . $this->file_name;
                    if (file_exists($target_path)) {
                        $this->custom_response['status'] = 1;
                    }
                }
            }
            $response = \Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = $this->custom_response;
            $response->send();
            \Yii::$app->end();
            return $this->custom_response;
        } catch (\Exception $ex) {
            
        }
    }

    private function maikdirectory($path) {
        $this->file_path = $path;
        $directory_array = explode('/', $this->file_path);
        $folder = '';
        foreach ($directory_array as $directory) {
            $folder .= $directory . '/';
            if (!is_dir($folder)) {
                mkdir($folder, 0777);
            }
        }
    }

}
