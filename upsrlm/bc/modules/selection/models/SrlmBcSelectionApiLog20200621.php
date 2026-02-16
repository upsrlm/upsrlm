<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "srlm_bc_selection_api_log_20200621".
 *
 * @property int $id
 * @property int $srlm_bc_selection_app_id
 * @property int $srlm_bc_selection_user_id
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
class SrlmBcSelectionApiLog20200621 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'srlm_bc_selection_api_log_20200621';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['srlm_bc_selection_app_id', 'srlm_bc_selection_user_id', 'http_response_code', 'api_response_status', 'created_at'], 'integer'],
            [['version_no', 'ip', 'time', 'request_url', 'created_at'], 'required'],
            [['time'], 'safe'],
            [['request_body', 'response'], 'string'],
            [['version_no'], 'string', 'max' => 10],
            [['imei_no'], 'string', 'max' => 100],
            [['ip'], 'string', 'max' => 25],
            [['request_url'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'srlm_bc_selection_app_id' => 'Srlm Bc Selection App ID',
            'srlm_bc_selection_user_id' => 'Srlm Bc Selection User ID',
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
