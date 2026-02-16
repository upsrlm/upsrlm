<?php

namespace common\models\dynamicdb\support\master;

use Yii;

/**
 * This is the model class for table "master_task_status".
 *
 * @property string $sr_no
 * @property string|null $status_code
 * @property string|null $task_status_name
 */
class MasterTaskStatus extends \common\models\dynamicdb\support\SupportDetailactiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'technosys_master_task_status';
    }

   

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sr_no'], 'required'],
            [['sr_no'], 'string', 'max' => 5],
            [['status_code'], 'string', 'max' => 12],
            [['task_status_name'], 'string', 'max' => 50],
            [['sr_no'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sr_no' => 'Sr No',
            'status_code' => 'Status Code',
            'task_status_name' => 'Task Status Name',
        ];
    }
}
