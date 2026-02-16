<?php

namespace common\models\dynamicdb\internalcallcenter\master;

use Yii;

/**
 * This is the model class for table "cloud_tele_master_smart_phone_whose".
 *
 * @property int $id
 * @property string|null $smart_phone_whose
 * @property int $status
 * @property string $created_at
 */
class CloudTeleMasterSmartPhoneWhose extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'cloud_tele_master_smart_phone_whose';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['status'], 'integer'],
            [['created_at'], 'safe'],
            [['smart_phone_whose'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'smart_phone_whose' => 'Smart Phone Whose',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

}
