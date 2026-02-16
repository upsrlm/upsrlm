<?php

namespace common\components\aws;

use Yii;
use yii\base\InvalidConfigException;
use Aws\Credentials\Credentials;
use Aws\S3\S3Client;

class AwsS3 extends yii\base\Component {

    public $key;
    public $secret;
    public $bucket;
    public $region;
    public $version;
    public $concurrency;

    public function init() {
        return parent::init();
    }

    public function getS3Client() {
        $s3_client = new \Aws\S3\S3Client([
            'version' => $this->version,
            'region' => $this->region,
            'credentials' => [
                'key' => $this->key,
                'secret' => $this->secret
            ]
        ]);
        return $s3_client;
    }

    public function moveToS3($key_name, $source) {
        $client = $this->getS3Client();
        $result = $client->putObject([
            'Bucket' => $this->bucket,
            'Key' => $key_name,
            'Body' => fopen($source, 'r'),
        ]);
        return $result;
    }

    public function getObjectUrl($key) {
        $client = $this->getS3Client();
        $command = $client->getCommand('GetObject', [
            'Bucket' => $this->bucket,
            'Key' => $key
        ]);

        return (string) \Aws\serialize($command)->getUri();
    }

    public function getbucketbykey($key, $app) {
        $bucket_array[$this->key] = [
            'bc' => 'upsrlm-bc-demo',
            'main' => 'upsrlm-demo',
            'dbtcallcenter' => 'upsrlm-dbtcallcenter-demo',
        ];
    }

}
