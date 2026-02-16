<?php

namespace common\models\dynamicdb\support\master;

use Yii;

/**
 * This is the model class for table "master_task_type".
 *
 * @property int|null $sr_no
 * @property string|null $task_type_code
 * @property string|null $task_type_name
 * @property int|null $stakeholder_category_code
 * @property string|null $current_status
 */
class MasterTaskType extends \common\models\dynamicdb\support\SupportDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'technosys_master_task_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['sr_no', 'stakeholder_category_code'], 'integer'],
            [['task_type_code'], 'string', 'max' => 4],
            [['task_type_name'], 'string', 'max' => 150],
            [['current_status'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'sr_no' => 'Sr No',
            'task_type_code' => 'Task Type Code',
            'task_type_name' => 'Task Type Name',
            'stakeholder_category_code' => 'Stakeholder Category Code',
            'current_status' => 'Current Status',
        ];
    }

}
