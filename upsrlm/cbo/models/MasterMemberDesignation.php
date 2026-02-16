<?php

namespace cbo\models;

use Yii;

/**
 * This is the model class for table "cbo_master_member_designation".
 *
 * @property int $id
 * @property string|null $role
 * @property int $entity_type
 * @property string $entity_type_name
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class MasterMemberDesignation extends \common\models\dynamicdb\cbo\CboactiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cbo_master_member_designation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entity_type', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['entity_type_name'], 'required'],
            [['role'], 'string', 'max' => 100],
            [['entity_type_name'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role' => 'Role',
            'entity_type' => 'Entity Type',
            'entity_type_name' => 'Entity Type Name',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
