<?php

namespace common\models\dynamicdb\mopup;

use Yii;
use common\models\dynamicdb\mopup\MopupactiveRecord;
/**
 * This is the model class for table "api_log".
 *
 * @property int $id
 * @property int $app_id
 * @property string $version_no
 * @property string|null $imei_no
 * @property string $ip
 * @property string $time
 * @property string|null $request_body
 * @property string $request_url
 * @property int $http_response_code
 * @property int $api_response_status
 * @property string|null $response
 * @property int $created_at
 */
class ApiLog extends MopupactiveRecord {



    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'api_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['app_id', 'http_response_code', 'api_response_status', 'created_at'], 'integer'],
            [['ip', 'time', 'request_url'], 'required'],
            [['time'], 'safe'],
            [['request_body', 'response'], 'string'],
            [['version_no'], 'string', 'max' => 10],
            [['imei_no'], 'string', 'max' => 100],
            [['ip'], 'string', 'max' => 25],
            [['request_url'], 'string', 'max' => 200],
            [['created_at','version_no'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'app_id' => 'App ID',
            'version_no' => 'Version No',
            'imei_no' => 'Imei No',
            'ip' => 'Ip',
            'time' => 'Time',
            'request_body' => 'Request Body',
            'request_url' => 'Request Url',
            'http_response_code' => 'Http Response Code',
            'api_response_status' => 'Api Response Status',
            'response' => 'Response',
            'created_at' => 'Created At',
        ];
    }
    

}
