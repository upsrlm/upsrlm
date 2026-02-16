<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "airphone_caller_status".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $username
 * @property int|null $user_id
 * @property int $inbound 1=inbound, 2=>outbound
 * @property int $outbound
 * @property int $airphone_user
 * @property int|null $airphone_agent_id
 * @property int $airphone_status
 * @property string|null $airphone_last_update
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class AirphoneCallerStatus extends \common\models\dynamicdb\cbo\CboactiveRecord {

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
        return 'airphone_caller_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'inbound', 'outbound', 'airphone_user', 'airphone_agent_id', 'airphone_status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['airphone_last_update'], 'safe'],
            [['name', 'username'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'username' => 'Username',
            'user_id' => 'User ID',
            'inbound' => 'Inbound',
            'outbound' => 'Outbound',
            'airphone_user' => 'Airphone User',
            'airphone_agent_id' => 'Airphone Agent ID',
            'airphone_status' => 'Airphone Status',
            'airphone_last_update' => 'Airphone Last Update',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }
}
