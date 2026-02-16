<?php

namespace common\models\dynamicdb\cbo_detail\master;

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
class CboMasterMemberDesignation extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

    const SHG_CHAIRPERSON = 1;
    const SHG_SECRETARY = 2;
    const SHG_TREASURER = 3;
    const SHG_MEMBER = 4;
    const VO_CHAIRPERSON = 5;
    const VO_SECRETARY = 6;
    const VO_TREASURER = 7;
    const VO_MEMBER = 8;
    const CLF_CHAIRPERSON = 9;
    const CLF_SECRETARY = 10;
    const CLF_TREASURER = 11;
    const CLF_MEMBER = 12;

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'cbo_master_member_designation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
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
    public function attributeLabels() {
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
