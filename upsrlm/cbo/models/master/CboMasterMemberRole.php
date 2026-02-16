<?php

namespace cbo\models\master;

use Yii;

/**
 * This is the model class for table "cbo_master_member_role".
 *
 * @property int $id
 * @property string|null $role
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class CboMasterMemberRole extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

    const ROLE_CHAIRPERSON = 1;
    const ROLE_SECRETARY = 2;
    const ROLE_TREASURER = 3;
    const ROLE_MEMBER = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'cbo_master_member_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['role'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'role' => 'Role',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

}
