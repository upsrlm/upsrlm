<?php

namespace common\models\dynamicdb\internalcallcenter\support;

use Yii;

/**
 * This is the model class for table "support_ticket_reply".
 *
 * @property int $id
 * @property int|null $ticket_id
 * @property int|null $parent_id last reply id of this ticket
 * @property string|null $description reply description
 * @property int|null $reply_by reply_user_id
 * @property string|null $file if user have any file we can add here
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status
 */
class SupportTicketReply extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'support_ticket_reply';
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
            [['ticket_id', 'parent_id', 'reply_by', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['description', 'file'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ticket_id' => 'Ticket ID',
            'parent_id' => 'Parent ID',
            'description' => 'Description',
            'reply_by' => 'Reply By',
            'file' => 'File',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }
}
