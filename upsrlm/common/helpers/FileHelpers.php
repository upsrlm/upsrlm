<?php

namespace common\helpers;

use yii\helpers\FileHelper;

/**
 * File helpers.
 *
 * @author Habibur Rahman <rahman.kld@gmail.com>
 */
class FileHelpers extends FileHelper {

    public $url;
    public $status_url;
    public $file_path;
    public $file_name;

    public function __construct() {
        $this->url = \Yii::$app->params['app_url']['file'] . '/file/upload';
        $this->status_url = \Yii::$app->params['app_url']['file'] . '/file/status';
    }

    public function upload() {
        try {
            $session_begin = curl_init();
            curl_setopt($session_begin, CURLOPT_POST, true);
            curl_setopt($session_begin, CURLOPT_POSTFIELDS, array('file' => curl_file_create($this->file_path . '/' . $this->file_name), 'file_path' => $this->file_path, 'file_name' => $this->file_name));
            curl_setopt($session_begin, CURLOPT_URL, $this->url);
            $response = curl_exec($session_begin);
            curl_close($session_begin);
        } catch (\Exception $ex) {
            
        }
    }

    public function check() {
        try {
            $session_begin = curl_init();
            curl_setopt($session_begin, CURLOPT_POST, true);
            curl_setopt($session_begin, CURLOPT_POSTFIELDS, array('file' => curl_file_create($this->file_path . '/' . $this->file_name), 'file_path' => $this->file_path, 'file_name' => $this->file_name));
            curl_setopt($session_begin, CURLOPT_URL, $this->status_url);
            curl_setopt($session_begin, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($session_begin);
            $header_size = curl_getinfo($session_begin, CURLINFO_HEADER_SIZE);
            $header = substr($response, 0, $header_size);
            curl_close($session_begin);
            $res = json_decode($header);
            if (isset($res->status)) {
                return $res->status;
            } else {
                return false;
            }
        } catch (\Exception $ex) {
            
        }
    }

}
