<?php

namespace bc\modules\selection\models;

use Yii;

/**
 * This is the model class for table "srlm_bc_selection_app_detail".
 *
 * @property int $id
 * @property int $srlm_bc_selection_user_id
 * @property string $imei_no
 * @property string $os_type
 * @property string $manufacturer_name
 * @property string $os_version
 * @property string $firebase_token
 * @property string $app_version
 * @property string $date_of_install
 * @property string|null $date_of_uninstall
 * @property int $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 */
class SrlmBcSelectionAppDetail extends BcactiveRecord
{
     public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'srlm_bc_selection_app_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['srlm_bc_selection_user_id', 'imei_no', 'os_type', 'manufacturer_name', 'os_version', 'firebase_token', 'app_version', 'date_of_install'], 'required'],
            [['srlm_bc_selection_user_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['firebase_token'], 'string'],
            [['date_of_install', 'date_of_uninstall'], 'safe'],
            [['imei_no', 'os_type', 'app_version'], 'string', 'max' => 100],
            [['manufacturer_name', 'os_version'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'srlm_bc_selection_user_id' => 'User ID',
            'imei_no' => 'Imei No',
            'os_type' => 'Os Type',
            'manufacturer_name' => 'Manufacturer Name',
            'os_version' => 'Os Version',
            'firebase_token' => 'Firebase Token',
            'app_version' => 'App Version',
            'date_of_install' => 'Date Of Install',
            'date_of_uninstall' => 'Date Of Uninstall',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
