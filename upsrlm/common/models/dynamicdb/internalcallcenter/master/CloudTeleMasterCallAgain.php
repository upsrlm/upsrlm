<?php

namespace common\models\dynamicdb\internalcallcenter\master;

use Yii;

/**
 * This is the model class for table "cloud_tele_master_call_again".
 *
 * @property int $id
 * @property string|null $call_again
 * @property int $status
 * @property string $created_at
 */
class CloudTeleMasterCallAgain extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cloud_tele_master_call_again';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['created_at'], 'safe'],
            [['call_again'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'call_again' => 'Call Again',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
