<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use Yii;

/**
 * This is the model class for table "calling_user_inbound".
 *
 * @property int $id
 * @property string|null $username
 * @property int|null $user_id
 * @property int $inbound 1=inbound, 2=>outbound
 * @property int $outbound
 * @property int $user_group
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class CallingUserInbound extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calling_user_inbound';
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'inbound', 'outbound', 'user_group', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['username'], 'string', 'max' => 255],
            [['inbound'], 'default', 'value' => 0],
            [['outbound'], 'default', 'value' => 0],
            [['user_group'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }


    public function getAgentdetail()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id']);
    }
}
