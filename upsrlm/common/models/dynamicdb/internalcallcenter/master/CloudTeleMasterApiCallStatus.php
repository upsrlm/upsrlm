<?php

namespace common\models\dynamicdb\internalcallcenter\master;

use Yii;

/**
 * This is the model class for table "cloud_tele_master_api_call_status".
 *
 * @property int $id
 * @property string|null $call_status_genral
 * @property string|null $call_status_ctc
 * @property int $status
 * @property string $created_at
 */
class CloudTeleMasterApiCallStatus extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cloud_tele_master_api_call_status';
    }

    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['created_at'], 'safe'],
            [['call_status_genral'], 'string', 'max' => 255],
            [['call_status_ctc'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'call_status_genral' => 'Call Status Genral',
            'call_status_ctc' => 'Call Status Ctc',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
