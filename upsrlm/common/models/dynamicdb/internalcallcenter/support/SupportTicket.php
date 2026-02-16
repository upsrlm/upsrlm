<?php

namespace common\models\dynamicdb\internalcallcenter\support;

use Yii;

/**
 * This is the model class for table "support_ticket".
 *
 * @property int $id
 * @property string|null $refrence_number
 * @property string|null $title
 * @property int|null $ticket_status_id
 * @property int|null $ticket_priority_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status
 */
class SupportTicket extends \common\models\dynamicdb\internalcallcenter\InternalCallCenteractiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'support_ticket';
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
            [['ticket_status_id', 'ticket_priority_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['refrence_number', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'refrence_number' => 'Refrence Number',
            'title' => 'Title',
            'ticket_status_id' => 'Ticket Status ID',
            'ticket_priority_id' => 'Ticket Priority ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getTicketstatus()
    {
        return $this->hasOne(SupportMasterTicketStatus::className(), ['id' => 'ticket_status_id']);
    }

    public function getTicketreply()
    {
        return $this->hasMany(SupportTicketReply::className(), ['ticket_id' => 'id']);
    }
}
