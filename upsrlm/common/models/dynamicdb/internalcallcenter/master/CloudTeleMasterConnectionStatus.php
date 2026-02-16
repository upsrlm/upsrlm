<?php

namespace common\models\dynamicdb\internalcallcenter\master;

use Yii;

/**
 * This is the model class for table "cloud_tele_master_connection_status".
 *
 * @property int $id
 * @property string|null $connection_status
 * @property int $status
 * @property string $created_at
 */
class CloudTeleMasterConnectionStatus extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'cloud_tele_master_connection_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['status'], 'integer'],
            [['created_at'], 'safe'],
            [['connection_status'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'connection_status' => 'Connection Status',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

}
