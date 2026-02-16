<?php

namespace common\models\dynamicdb\bc;

use Yii;

/**
 * This is the model class for table "relation_user_division".
 *
 * @property int $id
 * @property int $user_id
 * @property int $division_code
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $status
 */
class RelationUserDivision extends BcactiveRecord {

    use \common\traits\Signature;
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'relation_user_division';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'division_code'], 'required'],
            [['user_id', 'division_code', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'division_code' => 'Division',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getDivision() {
        return $this->hasOne(master\MasterDivision::className(), ['division_code' => 'division_code']);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
