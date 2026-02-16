<?php

namespace common\models\dynamicdb\internalcallcenter\master;

use Yii;

/**
 * This is the model class for table "cloud_tele_master_call_status".
 *
 * @property int $id
 * @property string|null $call_status
 * @property int $status
 * @property string $created_at
 */
class CloudTeleMasterCallStatus extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cloud_tele_master_call_status';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['created_at'], 'safe'],
            [['call_status'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'call_status' => 'Call Status',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
