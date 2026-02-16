<?php

namespace common\models\dynamicdb\support;

use Yii;

/**
 * This is the model class for table "conversation_status".
 *
 * @property string|null $conversation_code
 * @property int|null $stakeholder_code
 * @property string|null $task_code
 * @property string|null $currernt_status
 * @property string|null $reason_for_Incomplete_task
 * @property string|null $status_comments
 */
class ConversationStatus extends SupportDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'technosys_conversation_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['stakeholder_code'], 'integer'],
            [['conversation_code'], 'string', 'max' => 12],
            [['task_code'], 'string', 'max' => 4],
            [['currernt_status'], 'string', 'max' => 50],
            [['reason_for_Incomplete_task', 'status_comments'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'conversation_code' => 'Conversation Code',
            'stakeholder_code' => 'Stakeholder Code',
            'task_code' => 'Task',
            'currernt_status' => 'Currernt Status',
            'reason_for_Incomplete_task' => 'Reason For Incomplete Task',
            'status_comments' => 'Status Comments',
        ];
    }

    public function getTask() {
        return $this->hasOne(master\MasterTaskType::className(), ['task_type_code' => 'task_code']);
    }

    public function getBc() {
        return $this->hasOne(\bc\modules\selection\models\SrlmBcApplication::className(), ['id' => 'stakeholder_code']);
    }

    public function getCstatus() {
        return $this->hasOne(master\MasterTaskStatus::className(), ['status_code' => 'currernt_status']);
    }

    public function getReasonfit() {
        return $this->hasOne(master\MasterTaskStatusReason::className(), ['reason_code' => 'reason_for_Incomplete_task']);
    }

}
