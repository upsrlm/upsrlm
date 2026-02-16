<?php

namespace common\models\dynamicdb\mopup;

use Yii;
use common\models\dynamicdb\mopup\MopupactiveRecord;

/**
 * This is the model class for table "mopup_api_log".
 *
 * @property int $id
 * @property int|null $type
 * @property int|null $type_id
 * @property string|null $type_url
 * @property int|null $user_id
 * @property float|null $app_version
 * @property int|null $created_at
 * @property int $status
 */
class MopupApiLog extends MopupactiveRecord {

    const TYPE_NOTIFICATION_EXTERNAL_URL = 5;
    const TYPE_NOTIFICATION_ACKNOWLEDGEMENT_URL = 6;
    const TYPE_STATIC_PAGE = 7;
    const TYPE_APP = 8;
    const TYPE_GET_NOTIFICATION = 9;
    const TYPE_USER = 10;
    const TYPE_SUMUP = 11;
    const TYPE_HHS = 12;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'mopup_api_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['type', 'type_id', 'user_id', 'created_at', 'status'], 'integer'],
            [['app_version'], 'number'],
            [['type_url'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'type_id' => 'Type ID',
            'type_url' => 'Type Url',
            'user_id' => 'User ID',
            'app_version' => 'App Version',
            'created_at' => 'Created At',
            'status' => 'Status',
        ];
    }
}
