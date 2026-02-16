<?php

namespace common\models\dynamicdb\internalcallcenter\support\form;

use Yii;
use common\models\dynamicdb\internalcallcenter\support\SupportTicket;
use common\models\dynamicdb\internalcallcenter\support\SupportTicketReply;

class RaiseTicket extends \yii\base\Model
{

    public $title;
    public $description;
    public $ticket_status_id;
    public $ticket_priority_id;
    public $status;
    public $ticket_model;

    public function __construct($ticket_model = null)
    {
        $this->ticket_model = Yii::createObject([
            'class' => SupportTicket::className()
        ]);

        if ($ticket_model != null) {
            $this->ticket_model = $ticket_model;
            $this->title = $this->ticket_model->title;
            $this->ticket_status_id = $this->ticket_model->ticket_status_id;
            $this->ticket_priority_id = $this->ticket_model->ticket_priority_id;
            $this->status = $this->ticket_model->status;
        }
    }

    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            ['title', 'string', 'max' => 255],
            [['ticket_status_id', 'ticket_priority_id'], 'integer'],
            [['status'], 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Ticket Title',
            'ticket_status_id' => 'Status',
            'ticket_priority_id' => 'Priority',
        ];
    }

    /**
     * initialize Form Data
     *
     * @return void
     */
    public function initializeForm()
    {
        $this->ticket_model->title = $this->title;
        $this->ticket_model->ticket_status_id = $this->ticket_status_id;
        $this->ticket_model->ticket_priority_id = $this->ticket_priority_id;
        $this->ticket_model->status = $this->status;
    }

    /**
     * This Function Add a New Entry Every Time Whenever any reply happens
     *
     * @return void
     */
    public function ticketreply()
    {
        $reply = new SupportTicketReply();
        $reply->ticket_id = $this->ticket_model->id;
        $reply->description = $this->description;
        $reply->status = $this->status;
        $reply->reply_by = \Yii::$app->user->identity->id;
        $reply->save(false);
    }
}
