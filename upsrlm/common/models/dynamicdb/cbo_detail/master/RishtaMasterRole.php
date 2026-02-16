<?php

namespace common\models\dynamicdb\cbo_detail\master;

use Yii;

/**
 * This is the model class for table "rishta_master_role".
 *
 * @property int $id
 * @property string|null $role
 * @property string|null $role_hindi
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class RishtaMasterRole extends \common\models\dynamicdb\cbo_detail\CboDetailactiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'rishta_master_role';
    }

//    /**
//     * @return \yii\db\Connection the database connection used by this AR class.
//     */
//    public static function getDb()
//    {
//        return Yii::$app->get('dbcbodetail');
//    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
            [['role', 'role_hindi'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'role' => 'Role',
            'role_hindi' => 'Role Hindi',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getAttachedpermission() {
        return $this->hasMany(\common\models\dynamicdb\cbo_detail\RishtaRolePermission::className(), ['role' => 'id'])->where(['rishta_role_permission.status' => 1]);
    }

}
