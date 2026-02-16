<?php

namespace common\models\dynamicdb\cbo_detail;

use Yii;

/**
 * This is the model class for table "rishta_role_permission".
 *
 * @property int $id
 * @property int $role
 * @property int $permission
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class RishtaRolePermission extends CboDetailactiveRecord {

    const shg_chairperson = 1;
    const shg_secretary = 2;
    const shg_treasurer = 3;
    const shg_member = 4;
    const vo_chairperson = 5;
    const vo_secretary = 6;
    const vo_treasurer = 7;
    const vo_member = 8;
    const clf_chairperson = 9;
    const clf_secretary = 10;
    const clf_treasurer = 11;
    const clf_member = 12;
    const bc_sakhi = 13;
    const samuh_sakhi = 14;
    const wada_sakhi = 15;
    const accountant = 16;
    const selected_wada_sakhi = 17;

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
        return 'rishta_role_permission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['role'], 'required'],
            [['role', 'permission', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'role' => 'Role',
            'permission' => 'Permission',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getMpermission() {
        return $this->hasOne(master\RishtaMasterPermission::className(), ['id' => 'permission']);
    }

    public function getMrole() {
        return $this->hasOne(master\RishtaMasterRole::className(), ['id' => 'role']);
    }

}
