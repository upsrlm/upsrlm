<?php

namespace common\models\dynamicdb\support\master;

use Yii;

/**
 * This is the model class for table "master_task_status_reason".
 *
 * @property string $reason_code
 * @property string|null $status_code
 * @property string|null $task_type_code
 * @property string|null $reason_for_Incomplete_task
 */
class MasterTaskStatusReason extends \common\models\dynamicdb\support\SupportDetailactiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'technosys_master_task_status_reason';
    }

    

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reason_code'], 'required'],
            [['reason_code', 'status_code', 'task_type_code'], 'string', 'max' => 4],
            [['reason_for_Incomplete_task'], 'string', 'max' => 255],
            [['reason_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reason_code' => 'Reason Code',
            'status_code' => 'Status Code',
            'task_type_code' => 'Task Type Code',
            'reason_for_Incomplete_task' => 'Reason For Incomplete Task',
        ];
    }
}
