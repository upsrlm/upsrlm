<?php

namespace common\models\dynamicdb\internalcallcenter\platform;

use Yii;

/**
 * This is the model class for table "calling_user_sarv_log".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $sarv_agent_id
 * @property int|null $sarv_status
 * @property string|null $created_at
 * @property string|null $ref_from
 */
class CallingUserSarvLog extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calling_user_sarv_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'sarv_agent_id', 'sarv_status'], 'integer'],
            [['created_at'], 'safe'],
            [['ref_from'], 'string', 'max' => 50],
            ['api_response', 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'sarv_agent_id' => 'Sarv Agent ID',
            'sarv_status' => 'Sarv Status',
            'created_at' => 'Created At',
            'ref_from' => 'Ref From',
        ];
    }
}
