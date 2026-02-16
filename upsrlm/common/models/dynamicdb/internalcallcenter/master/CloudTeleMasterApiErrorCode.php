<?php

namespace common\models\dynamicdb\internalcallcenter\master;

use Yii;

/**
 * This is the model class for table "cloud_tele_master_api_error_code".
 *
 * @property int $id
 * @property string|null $error_discription
 * @property int $status
 * @property string $created_at
 */
class CloudTeleMasterApiErrorCode extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'cloud_tele_master_api_error_code';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['status'], 'integer'],
            [['created_at'], 'safe'],
            [['error_discription'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'error_discription' => 'Error Discription',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

}
