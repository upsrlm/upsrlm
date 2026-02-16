<?php

namespace common\models\dynamicdb\mopup;

use Yii;
use common\models\dynamicdb\mopup\MopupactiveRecord;

/**
 * This is the model class for table "app_detail".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $token
 * @property string|null $email_id
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
class AppDetail extends MopupactiveRecord {

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'app_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'imei_no', 'os_type', 'manufacturer_name', 'os_version', 'firebase_token', 'app_version', 'date_of_install'], 'required'],
            [['user_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['firebase_token'], 'string'],
            [['date_of_install', 'date_of_uninstall'], 'safe'],
            [['email_id'], 'string', 'max' => 255],
            [['token'], 'string', 'max' => 1000],
            [['imei_no', 'os_type', 'app_version'], 'string', 'max' => 100],
            [['manufacturer_name', 'os_version'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'token' => 'Token',
            'email_id' => 'Email ID',
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

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
